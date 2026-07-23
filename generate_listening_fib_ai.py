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

# TEST MODE: Set to True to generate only 3 items and test the edge-tts quality.
TEST_MODE = False

TOTAL_ITEMS = 3 if TEST_MODE else 300
START_FROM = 0

# 300 varied topics based on alfapte style (academic, real-world)
TOPICS = [
    # Sciences & Tech
    "the role of the US Agency for International Development in global health",
    "how artificial intelligence is improving early disease diagnosis",
    "the impact of ocean acidification on marine ecosystems",
    "the mechanics of quantum computing and its future applications",
    "how mRNA vaccines were developed and their future potential",
    "the science behind earthquake prediction technologies",
    "how microplastics are entering the human food chain",
    "the development of solid-state batteries for electric vehicles",
    "how the James Webb Space Telescope is changing astronomy",
    "the potential of nuclear fusion as a clean energy source",
    # Economics
    "the effects of rising inflation on middle-class households",
    "how junk bonds and credit derivatives contributed to financial crises",
    "the economics of universal basic income experiments",
    "how cryptocurrency regulation is evolving globally",
    "the impact of automation on blue-collar employment",
    "how global supply chain disruptions affect local businesses",
    "the economics of the global coffee trade",
    "how microfinance is empowering women in developing nations",
    "the economic impact of an aging population in developed countries",
    "the role of central banks in preventing economic recessions",
    # History & Politics
    "the political transition in the Democratic Republic of Congo",
    "the causes and aftermath of the Arab Spring",
    "how the Industrial Revolution shaped modern urban planning",
    "the history of the United Nations Security Council",
    "how the Cold War influenced space exploration",
    "the role of women in the civil rights movement",
    "how ancient trade routes shaped cultural exchange",
    "the political consequences of Brexit on European unity",
    "how the fall of the Berlin Wall changed global geopolitics",
    "the history of international copyright law",
    # Environment
    "the efforts to protect endangered species in the Amazon",
    "how renewable energy is transforming the European power grid",
    "the consequences of deforestation in Southeast Asia",
    "how urban farming is reducing food miles",
    "the impact of global warming on polar bear populations",
    "how coral bleaching is affecting the Great Barrier Reef",
    "the role of carbon capture technology in fighting climate change",
    "how water scarcity is affecting agriculture in the Middle East",
    "the importance of biodiversity in agricultural resilience",
    "how circular economy models can reduce industrial waste",
    # Psychology & Society
    "how memory consolidation occurs during REM sleep",
    "the psychological effects of long-term social media use",
    "how cognitive behavioral therapy helps treat anxiety",
    "the sociological impact of remote work on corporate culture",
    "how language acquisition differs between children and adults",
    "the psychology of decision-making and cognitive biases",
    "how urbanization affects mental health in young adults",
    "the role of emotional intelligence in effective leadership",
    "how cultural differences affect the perception of time",
    "the sociology of fashion and identity expression"
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
    {"type": "kokoro_female", "name": "af_bella"},
    {"type": "kokoro_female", "name": "af_sky"},
    {"type": "kokoro_female", "name": "af_heart"},
    {"type": "kokoro_female", "name": "af_sarah"},
    {"type": "kokoro_female", "name": "af_nicole"}
]

STOP_WORDS = {"a", "an", "the", "and", "but", "or", "for", "nor", "on", "at", "to", "from", "by", "with", "in", "of", "is", "are", "was", "were", "be", "been", "being", "have", "has", "had", "do", "does", "did", "it", "he", "she", "they", "we", "i", "you", "this", "that", "these", "those", "as", "if", "then", "than", "not", "no", "all", "any", "some", "which", "who", "whom", "whose", "what", "where", "when", "why", "how"}

def generate_fib_transcript(topic, retries=5):
    system_prompt = f"""You are an expert PTE Academic content creator specializing in Listening Fill in the Blanks.
Your task is to write an academic paragraph (part of a lecture) on the given topic.

Output MUST be a strict JSON object with a SINGLE key 'transcript'.
Example: {{"transcript": "Today, we will explore the impact of..."}}

Guidelines:
- The paragraph must be between 40 to 80 words long.
- Write in a natural, academic, and informative style.
- DO NOT use bullet points, headings, or markdown.
- DO NOT use any special characters that would be weird when read aloud by TTS.
"""
    prompt = f"Write an academic paragraph about: '{topic}'"
    headers = {"Authorization": f"Bearer {GROQ_API_KEY}", "Content-Type": "application/json"}
    payload = {
        "model": "llama-3.1-8b-instant",
        "messages": [
            {"role": "system", "content": system_prompt},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.7,
        "max_tokens": 512,
        "response_format": {"type": "json_object"}
    }

    for attempt in range(retries):
        try:
            response = requests.post("https://api.groq.com/openai/v1/chat/completions", json=payload, headers=headers, timeout=30)
            response.raise_for_status()
            data = json.loads(response.json()['choices'][0]['message']['content'])
            return data.get("transcript", "")
        except Exception as e:
            if attempt < retries - 1:
                time.sleep(2)
            else:
                print(f"Error: {e}")
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
    audio_dir = Path("public/storage/kokoro-tts/listening-fill-blanks")
    audio_dir.mkdir(parents=True, exist_ok=True)
    
    config_content = "<?php\n\nreturn [\n"
    
    print(f"\n🚀 Generating FIB academic transcripts (Test Mode: {TEST_MODE})...\n")
    
    for i in range(START_FROM, TOTAL_ITEMS):
        topic = TOPICS[i]
        voice_info = random.choice(VOICES)
        voice = voice_info["name"]
        vtype = voice_info["type"]
        print(f"[{i+1}/{TOTAL_ITEMS}] 📚 Topic: {topic[:50]}... (Voice: {voice} [{vtype}])")
        
        transcript = generate_fib_transcript(topic)
        if not transcript:
            continue
            
        words = transcript.split()
        blankable_indices = []
        for idx, w in enumerate(words):
            clean_w = re.sub(r'[^A-Za-z]', '', w).lower()
            if len(clean_w) >= 4 and clean_w not in STOP_WORDS:
                blankable_indices.append(idx)
                
        num_blanks = random.randint(4, 7)
        chosen_indices = sorted(random.sample(blankable_indices, min(num_blanks, len(blankable_indices)))) if blankable_indices else []
        
        text_words = words.copy()
        answers = []
        for idx in chosen_indices:
            word = words[idx]
            clean_word = re.sub(r'[^A-Za-z]', '', word)
            answers.append(clean_word)
            text_words[idx] = re.sub(r'[A-Za-z]+', '[blank]', word, count=1)
            
        text = " ".join(text_words)
        
        mp3_path = audio_dir / f"lfb_topic_test_{i}.mp3" if TEST_MODE else audio_dir / f"lfb_topic_{i}.mp3"
        
        # Generate Audio
        if vtype == "edge_male":
            asyncio.run(generate_audio_edge(transcript, voice, str(mp3_path)))
        else:
            generate_audio_kokoro(transcript, voice, str(mp3_path))
        
        transcript_escaped = transcript.replace("'", "\\'")
        text_escaped = text.replace("'", "\\'")
        
        config_content += f"    {i} => [\n"
        config_content += f"        'transcript' => '{transcript_escaped}',\n"
        config_content += f"        'text' => '{text_escaped}',\n"
        config_content += f"        'answers' => [\n"
        for answer in answers:
            config_content += f"            '{answer}',\n"
        config_content += f"        ],\n"
        config_content += f"        'voice' => '{voice}',\n"
        config_content += f"    ],\n"
        
        print(f"    ✅ Generated: {len(words)} words, {len(answers)} blanks")
        time.sleep(1)

    config_content += "];\n"
    
    local_path = "config/pte_listening_fib_test.php" if TEST_MODE else "config/pte_listening_fib.php"
    with open(local_path, "w") as f:
        f.write(config_content)
        
    print(f"\n🎉 DONE! Saved config to {local_path}")

if __name__ == "__main__":
    main()
