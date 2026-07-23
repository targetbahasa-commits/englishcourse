import os
import json
import random
import asyncio
import edge_tts
from dotenv import load_dotenv
import groq

load_dotenv()
client = groq.AsyncGroq(api_key=os.getenv("GROQ_API_KEY"))

LOCAL_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/listening-mcma"
PHP_PATH = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_listening_mcma.php"

EDGE_VOICES = [
    "en-GB-SoniaNeural", "en-GB-RyanNeural", "en-GB-LibbyNeural",
    "en-US-ChristopherNeural", "en-US-EricNeural", "en-US-MichelleNeural",
    "en-AU-WilliamNeural", "en-AU-NatashaNeural"
]

async def generate_mcma(topic, subtopic):
    prompt = f"""Generate a JSON object containing an academic PTE Listening Multiple Choice Multiple Answer task.
Broad Topic: {topic}
Specific Subtopic: {subtopic}

The lecture MUST be highly specific to the subtopic.
Format required:
{{
  "transcript": "A 100-130 word academic lecture about {subtopic}.",
  "question": "An analytical question based on the transcript.",
  "options": ["Option 1", "Option 2", "Option 3", "Option 4", "Option 5"],
  "correct_answers": ["Exact string from options", "Exact string from options"]
}}"""
    for attempt in range(5):
        try:
            response = await client.chat.completions.create(
                messages=[{"role": "user", "content": prompt}],
                model="llama-3.1-8b-instant",
                temperature=0.8,
                response_format={"type": "json_object"}
            )
            data = json.loads(response.choices[0].message.content)
            if "transcript" in data and "question" in data and "options" in data and "correct_answers" in data:
                if len(data['options']) >= 3 and len(data['correct_answers']) >= 1:
                    return data
        except Exception as e:
            await asyncio.sleep(2)
    return None

def escape_php(s):
    return str(s).replace("'", "\\'")

async def process_item(i, topic, subtopic):
    data = await generate_mcma(topic, subtopic)
    if not data:
        return None
    voice = random.choice(EDGE_VOICES)
    audio_filename = f"lmcma_topic_{i}.mp3"
    audio_path = os.path.join(LOCAL_DIR, audio_filename)
    try:
        communicate = edge_tts.Communicate(data['transcript'], voice)
        await communicate.save(audio_path)
    except Exception:
        return None
    data['voice'] = voice
    data['filename'] = audio_filename
    return data

async def main():
    # To get 52 more items, we need around 15 broad topics * 5 aspects = 75 attempts
    broad_topics = [
        "Astronomy and Space Exploration", "Robotics and Automation", "Marine Conservation", 
        "Renewable Energy", "Public Health", "Epidemiology", "Agricultural Science",
        "Environmental Sustainability", "Graphic Design", "History of Photography",
        "Anthropology", "Archaeology", "Political Science", "International Relations",
        "Business Ethics"
    ]
    
    tasks = []
    sem = asyncio.Semaphore(5)
    
    async def bounded_process(i, topic, subtopic):
        async with sem:
            return await process_item(i, topic, subtopic)
            
    idx = 248
    for broad in broad_topics:
        for j in range(5):
            subtopic = f"Aspect {j+1} of {broad}"
            tasks.append(bounded_process(idx, broad, subtopic))
            idx += 1
            
    results = await asyncio.gather(*tasks)
    valid_data = [r for r in results if r is not None]
    
    needed = 300 - 248
    final_data = valid_data[:needed]
    
    print(f"Generated {len(valid_data)} valid items. Using {len(final_data)} items to reach 300.")
    
    # Read existing PHP lines except the last 2 lines ("\n];\n")
    with open(PHP_PATH, 'r') as f:
        lines = f.readlines()
        
    while lines and ("return" not in lines[-1]) and ("[" not in lines[-1]) and ("]" in lines[-1] or ";" in lines[-1]):
        if "];" in lines[-1] or "]" in lines[-1]:
            lines.pop()
        else:
            break
            
    with open(PHP_PATH, 'w') as f:
        # Write back existing up to the end
        f.writelines(lines)
        if not lines[-1].endswith("\n"):
            f.write("\n")
            
        for i, data in enumerate(final_data):
            idx = 248 + i
            
            # rename file to correct sequential index
            old_filename = data['filename']
            new_filename = f"lmcma_topic_{idx}.mp3"
            old_path = os.path.join(LOCAL_DIR, old_filename)
            new_path = os.path.join(LOCAL_DIR, new_filename)
            
            if old_filename != new_filename and os.path.exists(old_path):
                os.rename(old_path, new_path)
            
            f.write(f"  {idx} => [\n")
            f.write(f"    'transcript' => '{escape_php(data.get('transcript', ''))}',\n")
            f.write(f"    'question' => '{escape_php(data.get('question', ''))}',\n")
            f.write("    'options' => [\n")
            for opt in data.get('options', []):
                f.write(f"      '{escape_php(opt)}',\n")
            f.write("    ],\n")
            f.write("    'correct_answers' => [\n")
            for ans in data.get('correct_answers', []):
                f.write(f"      '{escape_php(ans)}',\n")
            f.write("    ],\n")
            f.write(f"    'voice' => '{data.get('voice', 'en-US-ChristopherNeural')}',\n")
            f.write("  ],\n")
        f.write("];\n")

if __name__ == "__main__":
    asyncio.run(main())
