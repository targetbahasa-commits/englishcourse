import os
import json
import random
import time
import requests
import asyncio
import edge_tts
from pathlib import Path
import re
from dotenv import load_dotenv

load_dotenv()
GROQ_API_KEY = os.getenv("GROQ_API_KEY")

if not GROQ_API_KEY:
    print("Error: GROQ_API_KEY not found in .env")
    exit(1)

# Load existing JSON data
JSON_PATH = "PTE/highlight_incorrect_words.json"
PHP_PATH = "config/pte_highlight_incorrect_words.php"

if os.path.exists(JSON_PATH):
    with open(JSON_PATH, "r") as f:
        hiw_data_list = json.load(f)
else:
    hiw_data_list = []

existing_ids = {item["id"] for item in hiw_data_list}
missing_ids = [i for i in range(300) if i not in existing_ids]

print(f"Loaded {len(hiw_data_list)} existing items. Missing IDs: {len(missing_ids)}")

TOPICS = [
    # Biology & Medicine
    "how infant smiles are analyzed in psychological studies",
    "the role of the pygmy rain forests in African biodiversity",
    "the tail-slapping behavior of thresher sharks during hunting",
    "speciation and adaptation of cichlid fish in fresh water",
    "the science of memory retention and optimal sleep duration",
    "how mRNA vaccines stimulate the immune system to produce antibodies",
    "the impact of microplastics on human endocrine systems",
    "how gut microbiota influence brain function and mood",
    "the evolutionary purpose of play behavior in young mammals",
    "how bats use echolocation to navigate complex forest environments",
    # Environment & Climate
    "the IPCC estimates on sea level rise and historical temperature models",
    "the consequences of ocean acidification on coral reef structures",
    "how urban farming reduces carbon emissions in modern metropolises",
    "the role of peatlands in global carbon sequestration efforts",
    "deforestation in the Amazon and its effect on local weather",
    "the viability of nuclear fusion as a clean energy source",
    "how melting glaciers affect global ocean currents and climate",
    "the impact of wild fires on forest soil chemistry and recovery",
    "how biodiversity increases ecosystem resilience against drought",
    "the effects of light pollution on migratory bird behavior",
    # Technology & Space
    "how quantum computers utilize superposition and entanglement",
    "the engineering challenges of deploying the James Webb Space Telescope",
    "how solid-state batteries differ from traditional lithium-ion",
    "the role of artificial intelligence in analyzing geological data",
    "how space debris in low Earth orbit poses risks to satellites",
    "the development of carbon capture and storage technologies",
    "how autonomous vehicles perceive and navigate complex intersections",
    "the application of blockchain in securing international trade chains",
    "how smart grids optimize electricity distribution in real-time",
    "the physics behind modern earthquake early warning systems",
    # Economics & History
    "how central banks manage inflation using interest rate adjustments",
    "the history of the Silk Road and early global trade networks",
    "the economic consequences of an aging workforce in developed countries",
    "how microfinance initiatives empower women in rural Asia",
    "the role of junk bonds and credit derivatives in financial crises",
    "the history of international maritime law and territorial waters",
    "how the Industrial Revolution transformed urban architecture",
    "the impact of automation on future white-collar employment",
    "how the Silk Road facilitated cultural and technological exchange",
    "the development of modern intellectual property laws"
]

# Expand to 300 topics
while len(TOPICS) < 300:
    TOPICS.extend(TOPICS[:300 - len(TOPICS)])
random.shuffle(TOPICS)

VOICES = [
    {"type": "edge_male", "name": "en-US-ChristopherNeural"},
    {"type": "edge_male", "name": "en-US-GuyNeural"},
    {"type": "edge_male", "name": "en-GB-RyanNeural"},
    {"type": "edge_male", "name": "en-AU-WilliamNeural"},
    {"type": "kokoro_male", "name": "am_fenrir"},
    {"type": "kokoro_male", "name": "am_michael"},
    {"type": "kokoro_male", "name": "am_adam"},
    {"type": "kokoro_female", "name": "af_bella"},
    {"type": "kokoro_female", "name": "af_sky"},
    {"type": "kokoro_female", "name": "af_heart"},
    {"type": "kokoro_female", "name": "af_sarah"},
    {"type": "kokoro_female", "name": "af_nicole"}
]

def generate_hiw_data(topic, retries=5):
    system_prompt = """You are an expert PTE Academic content creator specializing in Highlight Incorrect Words.

Your task is to write an academic paragraph (70 to 110 words) about the given topic, and then create a modified version of it where EXACTLY 3 to 5 words are replaced by contextually incorrect but grammatically possible SINGLE words (e.g., similar parts of speech, similar length, or words that sound slightly similar or look similar, but make the sentence contextually incorrect).

IMPORTANT:
- Every replacement word in the display "text" MUST be a single word (no spaces!). E.g., do not replace "fresh water" with "salt water" because "salt water" contains a space. Instead, replace "fresh" with "salt".
- The "incorrect_words" list must contain only the modified replacement words as they appear in the "text" (lowercase, with no spaces, and stripped of punctuation).
- The modified paragraph "text" MUST contain the exact same sentence structure and the exact same number of words as the "transcript", with ONLY the 3 to 5 words replaced. Do NOT truncate or omit any sentences.

Output MUST be a strict JSON object with EXACTLY three keys:
1. "transcript": The original paragraph (70-110 words) which will be read by the audio. No brackets, no edits.
2. "text": The modified paragraph displayed on screen where EXACTLY 3 to 5 words have been replaced by contextually incorrect single words.
3. "incorrect_words": A list of the EXACT replacement words (as they appear in "text") in lowercase, containing no spaces or punctuation. The length of this list must be exactly 3, 4, or 5.
"""
    prompt = f"Create a Highlight Incorrect Words item for topic: '{topic}' with EXACTLY 3 to 5 single-word replacements. Enforce identical sentence structure and word count."
    headers = {"Authorization": f"Bearer {GROQ_API_KEY}", "Content-Type": "application/json"}
    payload = {
        "model": "llama-3.1-8b-instant",
        "messages": [
            {"role": "system", "content": system_prompt},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.7,
        "max_tokens": 1024,
        "response_format": {"type": "json_object"}
    }

    for attempt in range(retries):
        try:
            response = requests.post("https://api.groq.com/openai/v1/chat/completions", json=payload, headers=headers, timeout=30)
            if response.status_code == 429:
                print("   Rate limit hit (429). Sleeping for 15s...")
                time.sleep(15)
                continue
            response.raise_for_status()
            data = json.loads(response.json()['choices'][0]['message']['content'])
            
            if "transcript" in data and "text" in data and "incorrect_words" in data:
                inc = [w.strip().lower() for w in data["incorrect_words"]]
                if 3 <= len(inc) <= 5 and all(" " not in w for w in inc):
                    data["incorrect_words"] = inc
                    return data
        except Exception as e:
            print(f"   Attempt {attempt+1} failed: {e}")
            time.sleep(3)
    return None

async def generate_audio_edge(text, voice, output_path):
    communicate = edge_tts.Communicate(text, voice)
    await communicate.save(output_path)

def generate_audio_kokoro(text, voice, output_path):
    tts_url = "http://127.0.0.1:8100/api/generate-listening"
    payload = {
        "text": text,
        "speakers": [{"tag": "Speaker 1", "voice_id": voice}]
    }
    try:
        resp = requests.post(tts_url, json=payload, timeout=60)
        resp.raise_for_status()
        with open(output_path, 'wb') as f:
            f.write(resp.content)
    except Exception as e:
        print(f"Kokoro TTS error: {e}")

def main():
    audio_dir = Path("public/storage/kokoro-tts/highlight-incorrect-words")
    audio_dir.mkdir(parents=True, exist_ok=True)
    
    for i in missing_ids:
        topic = TOPICS[i]
        voice_info = random.choice(VOICES)
        voice = voice_info["name"]
        vtype = voice_info["type"]
        print(f"Generating missing ID {i}: {topic[:50]}... (Voice: {voice} [{vtype}])")
        
        hiw_data = generate_hiw_data(topic)
        if not hiw_data:
            print(f"❌ Failed to generate data for ID {i}")
            continue
            
        transcript = hiw_data["transcript"]
        text = hiw_data["text"]
        incorrect_words = hiw_data["incorrect_words"]
        
        mp3_filename = f"hiw_topic_{i}.mp3"
        mp3_path = audio_dir / mp3_filename
        
        # Generate Audio
        if vtype == "edge_male":
            asyncio.run(generate_audio_edge(transcript, voice, str(mp3_path)))
        else:
            generate_audio_kokoro(transcript, voice, str(mp3_path))
            
        # Add to local list
        hiw_data_list.append({
            "id": i,
            "audio_text": transcript,
            "text": text,
            "incorrect_words": incorrect_words,
            "voice": voice,
            "filename": mp3_filename,
            "folder": "kokoro-tts/highlight-incorrect-words"
        })
        
        print(f"   ✅ Saved ID {i} to list. Generated: {len(transcript.split())} words, {len(incorrect_words)} incorrect words")
        
        # Save temporary progress to avoid losing generated items if it crashes
        with open(JSON_PATH, "w") as f:
            json.dump(hiw_data_list, f, indent=4)
            
        time.sleep(3) # Throttle to prevent 429
        
    # Sort final list by ID
    hiw_data_list.sort(key=lambda x: x["id"])
    
    # Save Final JSON
    with open(JSON_PATH, "w") as f:
        json.dump(hiw_data_list, f, indent=4)
        
    # Generate PHP Config from JSON
    php_content = "<?php\n\nreturn [\n"
    for item in hiw_data_list:
        idx = item["id"]
        transcript_escaped = item["audio_text"].replace("'", "\\'")
        text_escaped = item["text"].replace("'", "\\'")
        voice = item["voice"]
        
        php_content += f"    {idx} => [\n"
        php_content += f"        'transcript' => '{transcript_escaped}',\n"
        php_content += f"        'text' => '{text_escaped}',\n"
        php_content += f"        'incorrect_words' => [\n"
        for word in item["incorrect_words"]:
            word_escaped = word.replace("'", "\\'")
            php_content += f"            '{word_escaped}',\n"
        php_content += f"        ],\n"
        php_content += f"        'voice' => '{voice}',\n"
        php_content += f"    ],\n"
    php_content += "];\n"
    
    with open(PHP_PATH, "w") as f:
        f.write(php_content)
        
    print(f"🎉 Repair complete! 300 sequential items generated and saved to PHP and JSON.")

if __name__ == "__main__":
    main()
