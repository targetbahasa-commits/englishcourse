import re
import os
import random
import requests
import urllib.parse
from pathlib import Path
import time

def esc(s):
    return str(s).replace("'", "\\'")

sentences = []
try:
    with open("config/pte_retell_lecture.php", "r", encoding="utf-8") as f:
        content = f.read()
        matches = re.findall(r"'transcript'\s*=>\s*'(.*?)'", content)
        for m in matches:
            text = m.replace("\\'", "'")
            sents = re.split(r'(?<=[.!?])\s+', text)
            for s in sents:
                if len(s.split()) >= 8:
                    sentences.append(s)
except:
    pass

voices = ['af_heart', 'am_fenrir', 'af_bella', 'am_michael', 'af_sky']
audio_dir = Path("public/storage/kokoro-tts/select-missing-word")
audio_dir.mkdir(parents=True, exist_ok=True)

php = "<?php\n\nreturn [\n"
for i in range(300):
    s = sentences[(i+600)%len(sentences)]
    words = s.split()
    if len(words) < 8: 
        s = sentences[(i+1200)%len(sentences)]
        words = s.split()
    
    if random.random() < 0.7:
        missing_len = 1
    else:
        missing_len = random.randint(2, 4)
    missing_phrase_words = words[-missing_len:]
    missing_phrase = " ".join(missing_phrase_words)
    
    correct_clean = re.sub(r'[^A-Za-z ]', '', missing_phrase).strip()
    if not correct_clean:
        correct_clean = missing_phrase
        
    last_word_full = words[-1]
    sfx = re.search(r'[^A-Za-z]+$', last_word_full)
    sfx_str = sfx.group(0) if sfx else ""
    
    words = words[:-missing_len]
    words.append("[beep]" + sfx_str)
    
    transcript = " ".join(words)
    
    fakes = []
    attempts = 0
    while len(fakes) < 3 and attempts < 20:
        attempts += 1
        other_s = sentences[(i + 50 + len(fakes)*13) % len(sentences)]
        other_w = other_s.split()
        if len(other_w) >= missing_len:
            fake_phrase = " ".join(other_w[-missing_len:])
            fake_clean = re.sub(r'[^A-Za-z ]', '', fake_phrase).strip()
            if fake_clean and fake_clean.lower() != correct_clean.lower() and fake_clean not in fakes:
                fakes.append(fake_clean)
                
    options = [correct_clean] + fakes
    random.shuffle(options)
    voice = voices[i % len(voices)]
    
    php += f"  {i} => [\n"
    php += f"    'transcript' => '{esc(transcript)}',\n"
    php += f"    'options' => [\n"
    for opt in options:
        php += f"      '{esc(opt)}',\n"
    php += f"    ],\n"
    php += f"    'correct_answer' => '{esc(correct_clean)}',\n"
    php += f"    'voice' => '{voice}',\n"
    php += f"  ],\n"
    
    topic_id = i + 1
    mp3_path = audio_dir / f"smw_topic_{topic_id}.mp3"
    
    url = "http://127.0.0.1:8100/api/generate-listening"
    payload = {
        "text": transcript,
        "speakers": [{"tag": "Speaker 1", "voice_id": voice}]
    }
    
    try:
        resp = requests.post(url, json=payload, timeout=30)
        if resp.status_code == 200:
            with open(mp3_path, 'wb') as f:
                f.write(resp.content)
            print(f"Generated audio for topic {topic_id}")
        else:
            print(f"Failed to generate audio for topic {topic_id}: {resp.status_code}")
    except Exception as e:
        print(f"Error generating audio for topic {topic_id}: {e}")

php += "];\n"
with open("config/pte_select_missing_word.php", "w") as f:
    f.write(php)
print("Finished regenerating pte_select_missing_word.php and audio!")
