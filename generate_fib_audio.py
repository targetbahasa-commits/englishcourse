import re
import random
import os
import asyncio
from pathlib import Path
import edge_tts

audio_dir = Path("public/storage/kokoro-tts/listening-fill-blanks")
audio_dir.mkdir(parents=True, exist_ok=True)

EDGE_VOICES = [
    "en-US-JennyNeural", "en-US-GuyNeural", "en-GB-SoniaNeural", 
    "en-GB-RyanNeural", "en-AU-NatashaNeural", "en-AU-WilliamNeural",
    "en-CA-ClaraNeural", "en-CA-LiamNeural"
]

async def generate_edge_tts(text, output_path):
    voice = random.choice(EDGE_VOICES)
    communicate = edge_tts.Communicate(text, voice)
    await communicate.save(output_path)

async def main():
    try:
        with open("config/pte_listening_fib.php", "r", encoding="utf-8") as f:
            content = f.read()
            
            matches = re.findall(r"'transcript'\s*=>\s*'(.*?(?<!\\))'", content)
            
            for i in range(len(matches)):
                text = matches[i].replace("\\'", "'")
                
                mp3_filename = f"lfb_topic_{i}.mp3"
                mp3_path = os.path.join(audio_dir, mp3_filename)
                
                try:
                    await generate_edge_tts(text, mp3_path)
                    print(f"Generated audio for topic {i}")
                except Exception as e:
                    print(f"Error generating audio for topic {i}: {e}")
                    
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    asyncio.run(main())
