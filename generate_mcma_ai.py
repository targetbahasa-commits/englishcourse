import os
import re
import json
import random
import time
import requests
from dotenv import load_dotenv

# Load .env variables
load_dotenv()
GROQ_API_KEY = os.getenv("GROQ_API_KEY")

if not GROQ_API_KEY:
    print("Error: GROQ_API_KEY not found in .env")
    exit(1)

def escape_php(text):
    return text.replace("'", "\\'")

def generate_mcma_question(topic, length_seconds, retries=5):
    # Estimate word count based on 150 words per minute (2.5 words per second)
    word_count = int(length_seconds * 2.5)
    
    system_prompt = f"""You are an expert PTE Academic content creator. 
Create a Listening Multiple Choice Multiple Answer (MCMA) question.
Output MUST be in strict JSON format with NO markdown formatting, NO extra text, just the raw JSON object.

The JSON format must be:
{{
  "transcript": "<spoken lecture transcript>",
  "question": "<analytical or inferential question based on the transcript>",
  "options": ["<option 1>", "<option 2>", "<option 3>", "<option 4>", "<option 5>"],
  "correct_answers": ["<correct option 1>", "<correct option 2>"]
}}

Guidelines:
- 'transcript' must be exactly an academic lecture about the given topic.
- 'transcript' length must be approximately {word_count} words (which translates to {length_seconds} seconds of speaking).
- 'question' should be PTE-style, e.g., asking for main ideas, conclusions, or specific details. Do NOT just ask "what words are mentioned".
- 'options' must be 5 plausible answers.
- 'correct_answers' must contain exactly 2 or 3 of the options from the 'options' list. The strings must match exactly.
"""
    
    prompt = f"Create a lecture transcript about '{topic}' of approximately {word_count} words ({length_seconds} seconds). Then create an MCMA question for it."

    headers = {
        "Authorization": f"Bearer {GROQ_API_KEY}",
        "Content-Type": "application/json"
    }

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
            response = requests.post("https://api.groq.com/openai/v1/chat/completions", json=payload, headers=headers)
            response.raise_for_status()
            content = response.json()['choices'][0]['message']['content']
            return json.loads(content)
        except requests.exceptions.HTTPError as e:
            if response.status_code == 429:
                sleep_time = (2 ** attempt) + random.uniform(0, 1)
                print(f"Rate limited. Retrying in {sleep_time:.2f} seconds...")
                time.sleep(sleep_time)
            else:
                print(f"Error generating question: {e}")
                return None
        except Exception as e:
            print(f"Error generating question: {e}")
            return None
    return None

def main():
    topics = [
        "Astronomy: Black holes", "Biology: Photosynthesis", "Computer Science: Artificial Intelligence",
        "History: The Industrial Revolution", "Psychology: Cognitive Dissonance", "Sociology: Urbanization",
        "Art History: The Renaissance", "Economics: Supply and Demand", "Physics: Quantum Mechanics",
        "Geology: Plate Tectonics", "Linguistics: Language Acquisition", "Environmental Science: Climate Change",
        "Anthropology: Human Evolution", "Literature: Shakespearean Tragedy", "Political Science: Democracy vs Autocracy",
        "Medicine: Vaccination History", "Education: Montessori Method", "Architecture: Gothic Cathedrals",
        "Chemistry: Periodic Table", "Business: Marketing Strategies"
    ]

    voices = ["af_bella", "af_sky", "am_fenrir", "am_michael", "af_heart"]
    
    TOTAL_ITEMS = 300
    print(f"Generating {TOTAL_ITEMS} MCMA questions using Groq AI...")
    
    json_data = []
    php_content = "<?php\n\nreturn [\n"

    for i in range(TOTAL_ITEMS):
        print(f"Generating item {i+1}/{TOTAL_ITEMS}...")
        topic = random.choice(topics)
        length_seconds = random.randint(35, 85)
        
        data = generate_mcma_question(topic, length_seconds)
        if not data:
            print("Failed to generate data for this item, skipping...")
            continue
        
        voice = random.choice(voices)
        filename = f"lmcma_topic_{i}.mp3"
        
        json_item = {
            "id": i,
            "text": data["transcript"],
            "voice": voice,
            "filename": filename,
            "folder": "kokoro-tts/listening-mcma"
        }
        json_data.append(json_item)
        
        php_content += f"  {i} => [\n"
        php_content += f"    'transcript' => '{escape_php(data['transcript'])}',\n"
        php_content += f"    'question' => '{escape_php(data['question'])}',\n"
        php_content += f"    'options' => [\n"
        for opt in data['options']:
            php_content += f"      '{escape_php(opt)}',\n"
        php_content += f"    ],\n"
        php_content += f"    'correct_answers' => [\n"
        for corr in data['correct_answers']:
            php_content += f"      '{escape_php(corr)}',\n"
        php_content += f"    ],\n"
        php_content += f"    'voice' => '{voice}',\n"
        php_content += f"  ],\n"
        
        # Adding a small sleep to be polite to the API
        time.sleep(1.5)
        
    php_content += "];\n"
    
    json_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/PTE/listening_mcma.json"
    php_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_listening_mcma.php"
    
    with open(json_path, 'w') as f:
        json.dump(json_data, f, indent=4)
        
    with open(php_path, 'w') as f:
        f.write(php_content)
        
    print(f"\nDone! Generated {TOTAL_ITEMS} items.")
    print(f"Updated JSON: {json_path}")
    print(f"Updated PHP: {php_path}")

if __name__ == "__main__":
    main()
