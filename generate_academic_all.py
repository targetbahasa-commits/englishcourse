import os
import json
import time
import asyncio
import random
import argparse
from groq import Groq
import edge_tts

# Konfigurasi
GROQ_API_KEY = os.environ.get("GROQ_API_KEY")
if not GROQ_API_KEY:
    # Coba baca dari .env
    try:
        with open('.env', 'r') as f:
            for line in f:
                if line.startswith('GROQ_API_KEY='):
                    GROQ_API_KEY = line.strip().split('=', 1)[1].strip('"').strip("'")
    except:
        pass

client = Groq(api_key=GROQ_API_KEY)
TOTAL_ITEMS = 300
OUTPUT_DIR = "PTE"
CONFIG_DIR = "config"
AUDIO_BASE_DIR = "public/storage/kokoro-tts"

# Voices TTS
EDGE_VOICES = [
    "en-GB-SoniaNeural", "en-GB-RyanNeural", "en-GB-LibbyNeural",
    "en-US-ChristopherNeural", "en-US-EricNeural", "en-US-MichelleNeural",
    "en-AU-WilliamNeural", "en-AU-NatashaNeural"
]

def generate_with_groq(prompt):
    max_retries = 5
    for attempt in range(max_retries):
        try:
            response = client.chat.completions.create(
                messages=[{"role": "user", "content": prompt}],
                model="qwen/qwen3-32b",
                temperature=0.7,
                response_format={"type": "json_object"}
            )
            return json.loads(response.choices[0].message.content)
        except Exception as e:
            print(f"Error calling Groq API: {e}")
            if attempt < max_retries - 1:
                wait_time = 5 * (attempt + 1)
                print(f"Retrying in {wait_time}s...")
                time.sleep(wait_time)
            else:
                return None

async def generate_tts(text, voice, output_path):
    try:
        communicate = edge_tts.Communicate(text, voice)
        await communicate.save(output_path)
        return True
    except Exception as e:
        print(f"TTS Error: {e}")
        return False

# Modul Configs
MODULE_CONFIGS = {
    "mcsa": {
        "json_name": "listening_mcsa.json",
        "php_name": "pte_listening_mcsa.php",
        "audio_dir": "listening-multiple-choice-single-answer",
        "prompt": """Generate a JSON object containing an academic PTE Listening Multiple Choice Single Answer task.
Topic should be one of: biology, astronomy, history, psychology, geology, literature, technology.
Format required:
{
  "transcript": "A 50-80 word academic paragraph.",
  "question": "A multiple choice question based on the transcript.",
  "options": ["Option A", "Option B", "Option C", "Option D"],
  "correct_answer": "The exact string from options that is correct."
}"""
    },
    "hcs": {
        "json_name": "highlight_correct_summary.json",
        "php_name": "pte_highlight_correct_summary.php",
        "audio_dir": "listening-highlight-correct-summary",
        "prompt": """Generate a JSON object containing an academic PTE Highlight Correct Summary task.
Topic should be one of: biology, astronomy, history, psychology, geology, literature, technology.
Format required:
{
  "transcript": "A 70-100 word academic paragraph.",
  "options": ["Summary 1 (correct)", "Summary 2 (incorrect)", "Summary 3 (incorrect)", "Summary 4 (incorrect)"],
  "correct_answer": "The exact string from options that is the correct summary."
}
Shuffle the options array before returning."""
    },
    "smw": {
        "json_name": "select_missing_word.json",
        "php_name": "pte_select_missing_word.php",
        "audio_dir": "listening-select-missing-word",
        "prompt": """Generate a JSON object containing an academic PTE Select Missing Word task.
Topic should be one of: biology, astronomy, history, psychology, geology, literature, technology.
The transcript MUST end with the word [beep], replacing the final word or phrase of the lecture.
Format required:
{
  "transcript_text": "The full text WITHOUT the beep, ending with the actual correct word.",
  "transcript": "The text with the final word/phrase replaced exactly with [beep].",
  "options": ["Correct word", "Wrong word 1", "Wrong word 2", "Wrong word 3"],
  "correct_answer": "The correct word/phrase."
}
Shuffle the options array before returning."""
    },
    "rl": {
        "json_name": "retell_lecture.json",
        "php_name": "pte_retell_lecture.php",
        "audio_dir": "speaking-retell-lecture",
        "prompt": """Generate a JSON object containing an academic PTE Retell Lecture task.
Topic should be one of: biology, astronomy, history, psychology, geology, literature, technology.
Format required:
{
  "transcript": "A 70-100 word academic lecture.",
  "key_points": ["Keyword/phrase 1", "Keyword/phrase 2", "Keyword/phrase 3"]
}"""
    },
    "sst": {
        "json_name": "sst_topics.json",
        "php_name": "pte_listening_sst_topics.php",
        "audio_dir": "listening-summarize-spoken-text",
        "prompt": """Generate a JSON object containing an academic PTE Summarize Spoken Text task.
Topic should be one of: biology, astronomy, history, psychology, geology, literature, technology.
Format required:
{
  "transcript": "A 100-150 word academic lecture."
}"""
    },
    "rs": {
        "json_name": "repeat_sentence.json",
        "php_name": "pte_repeat_sentence.php",
        "audio_dir": "speaking-repeat-sentence",
        "prompt": """Generate a JSON object containing a PTE Repeat Sentence task.
Format required:
{
  "transcript": "A single academic sentence between 8 and 14 words long."
}"""
    },
    "wfd": {
        "json_name": "write_from_dictation.json",
        "php_name": "pte_write_from_dictation.php",
        "audio_dir": "listening-write-from-dictation",
        "prompt": """Generate a JSON object containing a PTE Write From Dictation task.
Format required:
{
  "transcript": "A single academic sentence between 8 and 14 words long."
}"""
    }
}

def escape_php(s):
    if isinstance(s, str):
        return s.replace("'", "\\'")
    return s

def array_to_php(arr):
    items = []
    for item in arr:
        items.append(f"'{escape_php(item)}'")
    return "[" + ", ".join(items) + "]"

def dict_to_php(data, indent=2):
    lines = []
    spaces = " " * indent
    for k, v in data.items():
        if k == "transcript_text":
            continue
        if isinstance(v, str):
            lines.append(f"{spaces}'{k}' => '{escape_php(v)}',")
        elif isinstance(v, list):
            lines.append(f"{spaces}'{k}' => {array_to_php(v)},")
    return "\n".join(lines)

async def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--module', required=True, choices=list(MODULE_CONFIGS.keys()))
    parser.add_argument('--start', type=int, default=1)
    parser.add_argument('--end', type=int, default=TOTAL_ITEMS)
    args = parser.parse_args()

    mod = MODULE_CONFIGS[args.module]
    json_path = os.path.join(OUTPUT_DIR, mod["json_name"])
    php_path = os.path.join(CONFIG_DIR, mod["php_name"])
    audio_dir = os.path.join(AUDIO_BASE_DIR, mod["audio_dir"])
    
    os.makedirs(OUTPUT_DIR, exist_ok=True)
    os.makedirs(CONFIG_DIR, exist_ok=True)
    os.makedirs(audio_dir, exist_ok=True)

    data = []
    if os.path.exists(json_path):
        with open(json_path, 'r') as f:
            try:
                data = json.load(f)
            except:
                data = []
    
    while len(data) < args.end:
        data.append({})

    for i in range(args.start - 1, args.end):
        print(f"Generating item {i+1}/{args.end} for module {args.module}...")
        
        item_data = generate_with_groq(mod["prompt"])
        if not item_data:
            print(f"Failed to generate item {i+1}")
            continue
        
        voice = random.choice(EDGE_VOICES)
        item_data["voice"] = voice
        
        audio_filename = f"topic_{str(i+1).zfill(3)}.mp3"
        audio_path = os.path.join(audio_dir, audio_filename)
        
        text_to_speak = item_data.get("transcript_text", item_data.get("transcript", ""))
        
        if "beep" in text_to_speak.lower() and args.module != "smw":
            text_to_speak = text_to_speak.replace("[beep]", "")
            
        success = await generate_tts(text_to_speak, voice, audio_path)
        if success:
            data[i] = item_data
            with open(json_path, 'w') as f:
                json.dump(data, f, indent=4)
        else:
            print(f"Failed to generate audio for item {i+1}")
            
        time.sleep(1)

    print("Generating PHP config...")
    with open(php_path, 'w') as f:
        f.write("<?php\n\nreturn [\n")
        for i, item in enumerate(data):
            if not item: continue
            f.write(f"  {i} => [\n")
            f.write(dict_to_php(item, indent=4) + "\n")
            f.write("  ],\n")
        f.write("];\n")
        
    print(f"Finished {args.module}!")

if __name__ == "__main__":
    asyncio.run(main())
