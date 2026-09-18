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
REMOTE_MP3_DIR = "/domains/targetbahasa.com/public_html/storage/app/public/kokoro-tts/listening-mcma"
LOCAL_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/listening-mcma"
PHP_PATH = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_listening_mcma.php"
REMOTE_PHP_DIR = "/domains/targetbahasa.com/public_html/config"

EDGE_VOICES = [
    "en-GB-SoniaNeural", "en-GB-RyanNeural", "en-GB-LibbyNeural",
    "en-US-ChristopherNeural", "en-US-EricNeural", "en-US-MichelleNeural",
    "en-AU-WilliamNeural", "en-AU-NatashaNeural"
]

os.makedirs(LOCAL_DIR, exist_ok=True)

async def generate_mcma(topic):
    prompt = f"""Generate a JSON object containing an academic PTE Listening Multiple Choice Multiple Answer task about: {topic}.
Format required:
{{
  "transcript": "A 100-130 word academic lecture.",
  "question": "An analytical question based on the transcript.",
  "options": ["Option 1", "Option 2", "Option 3", "Option 4", "Option 5"],
  "correct_answers": ["Exact string from options", "Exact string from options"]
}}"""
    
    for _ in range(5):
        try:
            response = await client.chat.completions.create(
                messages=[{"role": "user", "content": prompt}],
                model="llama-3.1-8b-instant",
                temperature=0.7,
                response_format={"type": "json_object"}
            )
            return json.loads(response.choices[0].message.content)
        except Exception as e:
            await asyncio.sleep(2)
    return None

def escape_php(s):
    return str(s).replace("'", "\\'")

async def process_item(i, topic):
    print(f"Generating data for topic {i}...")
    data = await generate_mcma(topic)
    if not data:
        print(f"Failed to generate data for {i}")
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
    return (i, data)

async def main():
    # Generate 300 highly diverse topics
    subjects = [
        "Ancient History", "Modern History", "Cellular Biology", "Marine Biology",
        "Quantum Physics", "Astrophysics", "Cognitive Psychology", "Behavioral Psychology",
        "Microeconomics", "Macroeconomics", "Physical Geology", "Environmental Geology",
        "Organic Chemistry", "Inorganic Chemistry", "Renaissance Art", "Modern Art",
        "Linguistics", "Sociology of the Internet", "Urban Sociology", "Classical Literature"
    ]
    topics = []
    for sub in subjects:
        for i in range(15):
            topics.append(f"A specific advanced concept in {sub}, subtopic {i+1}")
            
    tasks = []
    sem = asyncio.Semaphore(15) # 15 concurrent requests
    
    async def bounded_process(i, topic):
        async with sem:
            return await process_item(i, topic)
            
    for i, topic in enumerate(topics):
        tasks.append(bounded_process(i, topic))
        
    results = await asyncio.gather(*tasks)
    
    # Sort results
    valid_results = [r for r in results if r is not None]
    valid_results.sort(key=lambda x: x[0])
    
    # Save PHP config
    with open(PHP_PATH, 'w') as f:
        f.write("<?php\n\nreturn [\n")
        for i, data in valid_results:
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
    
    mp3_files = glob.glob(os.path.join(LOCAL_DIR, "*.mp3"))
    for idx, file_path in enumerate(mp3_files, 1):
        filename = os.path.basename(file_path)
        with open(file_path, "rb") as file:
            ftp.storbinary(f"STOR {filename}", file)
        if idx % 50 == 0:
            print(f"Uploaded {idx}/{len(mp3_files)} MP3s")
            
    print("Uploading PHP config to FTP...")
    ftp.cwd(REMOTE_PHP_DIR)
    with open(PHP_PATH, "rb") as file:
        ftp.storbinary("STOR pte_listening_mcma.php", file)
            
    ftp.quit()
    print("Done!")

if __name__ == "__main__":
    asyncio.run(main())
