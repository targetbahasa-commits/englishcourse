import os
import json
import random
import asyncio
import edge_tts
from dotenv import load_dotenv
import groq
import ftplib
import glob

load_dotenv()
client = groq.AsyncGroq(api_key=os.getenv("GROQ_API_KEY"))

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"
REMOTE_MP3_DIR = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts/listening-mcma"
LOCAL_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/listening-mcma"
PHP_PATH = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_listening_mcma.php"
REMOTE_PHP_DIR = "/domains/targetbahasa.com/public_html/config"

EDGE_VOICES = [
    "en-GB-SoniaNeural", "en-GB-RyanNeural", "en-GB-LibbyNeural",
    "en-US-ChristopherNeural", "en-US-EricNeural", "en-US-MichelleNeural",
    "en-AU-WilliamNeural", "en-AU-NatashaNeural"
]

os.makedirs(LOCAL_DIR, exist_ok=True)

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
        print(f"Failed to generate data for {i}: {subtopic}")
        return None
        
    voice = random.choice(EDGE_VOICES)
    audio_filename = f"lmcma_topic_{i}.mp3"
    audio_path = os.path.join(LOCAL_DIR, audio_filename)
    
    try:
        communicate = edge_tts.Communicate(data['transcript'], voice)
        await communicate.save(audio_path)
    except Exception as e:
        print(f"TTS failed for {i}: {e}")
        return None
        
    data['voice'] = voice
    data['filename'] = audio_filename
    print(f"Successfully generated {i}: {subtopic}")
    return data

async def main():
    broad_topics = [
        "Ancient Egypt", "Ancient Greece", "Roman Empire", "Medieval Europe", "The Renaissance",
        "Industrial Revolution", "World War I", "World War II", "Cold War", "Civil Rights Movement",
        "Cellular Biology", "Genetics and DNA", "Evolutionary Biology", "Marine Ecosystems", "Botany and Plant Science",
        "Human Anatomy", "Neuroscience", "Microbiology", "Ecology", "Zoology",
        "Classical Mechanics", "Quantum Mechanics", "Thermodynamics", "Electromagnetism", "Astrophysics",
        "Organic Chemistry", "Inorganic Chemistry", "Biochemistry", "Physical Chemistry", "Materials Science",
        "Physical Geography", "Human Geography", "Meteorology", "Oceanography", "Geology and Plate Tectonics",
        "Microeconomics", "Macroeconomics", "International Trade", "Behavioral Economics", "Financial Markets",
        "Cognitive Psychology", "Developmental Psychology", "Social Psychology", "Clinical Psychology", "Personality Theories",
        "Sociological Theory", "Urban Sociology", "Sociology of Education", "Criminology", "Media and Culture",
        "Classical Literature", "Modernist Literature", "Poetry Analysis", "Theatrical Arts", "Literary Criticism",
        "Renaissance Art", "Modern Art Movements", "Architecture History", "Music Theory", "Film Studies",
        "Artificial Intelligence", "Cybersecurity", "Software Engineering", "Computer Networks", "Data Science"
    ] # 65 broad topics
    
    tasks = []
    sem = asyncio.Semaphore(10) # Max 10 concurrent to avoid rate limits
    
    async def bounded_process(i, topic, subtopic):
        async with sem:
            return await process_item(i, topic, subtopic)
            
    idx = 0
    for broad in broad_topics:
        for j in range(5):
            subtopic = f"Aspect {j+1} of {broad}"
            tasks.append(bounded_process(idx, broad, subtopic))
            idx += 1
            
    results = await asyncio.gather(*tasks)
    
    valid_data = [r for r in results if r is not None]
    
    # We want exactly 300 topics, sequentially re-indexed
    final_count = min(300, len(valid_data))
    final_data = valid_data[:final_count]
    
    print(f"Generated {len(valid_data)} valid items. Using {final_count} items.")
    
    # Let's rename the files to be sequential 0..299
    # We'll use a temporary folder or just rename in place
    # Actually process_item already saves them with the original `idx`.
    # It's better to just re-save TTS here or rename files.
    # To avoid confusion, let's just rename the MP3 files sequentially!
    for new_idx, data in enumerate(final_data):
        old_filename = data['filename']
        new_filename = f"lmcma_topic_{new_idx}.mp3"
        old_path = os.path.join(LOCAL_DIR, old_filename)
        new_path = os.path.join(LOCAL_DIR, new_filename)
        
        if old_filename != new_filename and os.path.exists(old_path):
            os.rename(old_path, new_path)
            
        data['filename'] = new_filename
        data['voice'] = data['voice']
    
    # Save PHP config
    with open(PHP_PATH, 'w') as f:
        f.write("<?php\n\nreturn [\n")
        for i, data in enumerate(final_data):
            f.write(f"  {i} => [\n")
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
        
    print("Uploading MP3 files to FTP...")
    ftp = ftplib.FTP(FTP_HOST)
    ftp.login(user=FTP_USER, passwd=FTP_PASS)
    try:
        ftp.mkd(REMOTE_MP3_DIR)
    except:
        pass
    ftp.cwd(REMOTE_MP3_DIR)
    
    # Delete remote files first to avoid leftovers if there are any > final_count
    try:
        remote_files = ftp.nlst()
        for f in remote_files:
            if f.endswith('.mp3'):
                ftp.delete(f)
    except:
        pass

    mp3_files = [os.path.join(LOCAL_DIR, d['filename']) for d in final_data]
    total = len(mp3_files)
    for idx, file_path in enumerate(mp3_files, 1):
        filename = os.path.basename(file_path)
        if os.path.exists(file_path):
            with open(file_path, "rb") as file:
                ftp.storbinary(f"STOR {filename}", file)
        if idx % 50 == 0 or idx == total:
            print(f"Uploaded {idx}/{total} MP3s")
            
    print("Uploading PHP config to FTP...")
    ftp.cwd(REMOTE_PHP_DIR)
    with open(PHP_PATH, "rb") as file:
        ftp.storbinary("STOR pte_listening_mcma.php", file)
            
    ftp.quit()
    print("Done!")

if __name__ == "__main__":
    asyncio.run(main())
