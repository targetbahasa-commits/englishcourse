import json
import os
import subprocess
import time

def main():
    with open('sst_topics.json', 'r') as f:
        topics = json.load(f)
    
    out_dir = 'storage/app/public/kokoro-tts'
    os.makedirs(out_dir, exist_ok=True)
    
    print(f"Loaded {len(topics)} topics.")
    
    # Process 11 to 50
    start_idx = 10
    end_idx = 50
    
    for i in range(start_idx, end_idx):
        topic = topics[i]
        topic_id = i + 1
        text = topic['transcript']
        voice = topic['voice']
        lang = 'b' if voice.startswith('b') else 'a'
        
        wav_file = f"{out_dir}/sst_topic_{topic_id}.wav"
        mp3_file = f"{out_dir}/sst_topic_{topic_id}.mp3"
        
        print(f"Generating audio for Topic {topic_id} ({voice})...")
        start_time = time.time()
        
        # 1. Generate WAV using Kokoro
        kokoro_cmd = [
            'python3', 'scripts/kokoro_tts.py',
            '--text', text,
            '--voice', voice,
            '--lang', lang,
            '--output', wav_file
        ]
        
        res = subprocess.run(kokoro_cmd, capture_output=True, text=True)
        if res.returncode != 0:
            print(f"Error generating WAV for Topic {topic_id}: {res.stderr}")
            continue
            
        # 2. Convert to MP3
        ffmpeg_cmd = [
            'ffmpeg', '-y', '-i', wav_file, '-b:a', '64k', mp3_file
        ]
        res2 = subprocess.run(ffmpeg_cmd, capture_output=True, text=True)
        if res2.returncode != 0:
            print(f"Error converting MP3 for Topic {topic_id}: {res2.stderr}")
            continue
            
        # 3. Clean up WAV
        if os.path.exists(wav_file):
            os.remove(wav_file)
            
        elapsed = time.time() - start_time
        print(f"Done Topic {topic_id} in {elapsed:.1f}s -> {mp3_file}")

if __name__ == '__main__':
    main()
