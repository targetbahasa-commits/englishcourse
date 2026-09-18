import re
import random
import ftplib
import os
from pathlib import Path
import requests

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

print("Reading source text from pte_retell_lecture.php...")

paragraphs = []
try:
    with open("config/pte_retell_lecture.php", "r", encoding="utf-8") as f:
        content = f.read()
        matches = re.findall(r"'transcript'\s*=>\s*'(.*?(?<!\\))'", content)
        for m in matches:
            text = m.replace("\\'", "'")
            # split into sentences
            sents = re.split(r'(?<=[.!?])\s+', text)
            
            # Group into paragraphs of at least 40 words, max 90 words
            current_p = []
            current_w = 0
            for s in sents:
                w_count = len(re.findall(r'\b[A-Za-z]+\b', s))
                current_p.append(s)
                current_w += w_count
                if current_w >= 40:
                    if current_w <= 120:
                        paragraphs.append(" ".join(current_p))
                    current_p = []
                    current_w = 0
except Exception as e:
    print(f"Error parsing pte_retell_lecture.php: {e}")

paragraphs = list(set(paragraphs))
random.shuffle(paragraphs)

print(f"Collected {len(paragraphs)} suitable paragraphs.")

stop_words = {"a", "an", "the", "and", "but", "or", "for", "nor", "on", "at", "to", "from", "by", "with", "in", "of", "is", "are", "was", "were", "be", "been", "being", "have", "has", "had", "do", "does", "did", "it", "he", "she", "they", "we", "i", "you", "this", "that", "these", "those", "as", "if", "then", "than", "not", "no", "all", "any", "some", "which", "who", "whom", "whose", "what", "where", "when", "why", "how"}

voices = ['af_bella', 'af_sky', 'am_fenrir', 'am_michael', 'af_heart']

config_content = "<?php\n\nreturn [\n"

audio_dir = Path("public/storage/kokoro-tts/listening-fill-blanks")
audio_dir.mkdir(parents=True, exist_ok=True)

tts_url = "http://127.0.0.1:8100/api/generate-listening"

# Take exactly 300 paragraphs, looping if necessary
selected_paragraphs = []
while len(selected_paragraphs) < 300 and len(paragraphs) > 0:
    selected_paragraphs.extend(paragraphs)
selected_paragraphs = selected_paragraphs[:300]

for i, transcript in enumerate(selected_paragraphs):
    words = transcript.split()
    blankable_indices = []
    
    for idx, w in enumerate(words):
        clean_w = re.sub(r'[^A-Za-z]', '', w).lower()
        if len(clean_w) > 4 and clean_w not in stop_words:
            blankable_indices.append(idx)
            
    num_blanks = random.randint(4, 7)
    if num_blanks > len(blankable_indices):
        num_blanks = len(blankable_indices)
        
    if num_blanks > 0:
        chosen_indices = sorted(random.sample(blankable_indices, num_blanks))
    else:
        chosen_indices = []
        
    text_words = words.copy()
    answers = []
    
    j = 0
    while j < len(words):
        if j in chosen_indices:
            # 80% 1 word, 15% 2 words, 5% 3 words
            length = random.choices([1, 2, 3], weights=[80, 15, 5], k=1)[0]
            actual_len = 1
            for k in range(1, length):
                if j + k < len(words) and (j + k) not in chosen_indices:
                    actual_len += 1
                else:
                    break
                    
            phrase_words = words[j:j+actual_len]
            clean_phrase = " ".join([re.sub(r'[^A-Za-z0-9]', '', w) for w in phrase_words]).strip()
            answers.append(clean_phrase)
            
            text_words[j] = '[blank]'
            for k in range(1, actual_len):
                text_words[j+k] = ''
                
            j += actual_len
        else:
            j += 1
            
    # Filter out the empty strings from multi-word blanks
    text_words = [w for w in text_words if w != '']
    text = " ".join(text_words)
    voice = random.choice(voices)
    
    transcript_escaped = transcript.replace("\\'", "'").replace("'", "\\'")
    text_escaped = text.replace("\\'", "'").replace("'", "\\'")
    
    config_content += f"    {i} => [\n"
    config_content += f"        'transcript' => '{transcript_escaped}',\n"
    config_content += f"        'text' => '{text_escaped}',\n"
    config_content += f"        'answers' => [\n"
    for answer in answers:
        config_content += f"            '{answer}',\n"
    config_content += f"        ],\n"
    config_content += f"        'voice' => '{voice}',\n"
    config_content += f"    ],\n"

    # mp3_path = audio_dir / f"lfb_topic_{i}.mp3"
    
    # payload = {
    #     "text": text,
    #     "voice": voice,
    #     "speed": 1.0,
    #     "lang": "en",
    #     "output_format": "mp3"
    # }
    
    # mp3_filename = f"fib_{i}.mp3"
    # mp3_path = os.path.join(audio_dir, mp3_filename)
    
    # # We will generate audio later in a separate script or parallel job
    # try:
    #     resp = requests.post(tts_url, json=payload, timeout=40)
    #     if resp.status_code == 200:
    #         with open(mp3_path, 'wb') as f:
    #             f.write(resp.content)
    #         print(f"Generated audio for topic {i}")
    #     else:
    #         print(f"Failed audio for topic {i}: {resp.status_code}")
    # except Exception as e:
    #     print(f"Error generating audio for topic {i}: {e}")

config_content += "];\n"

local_path = "config/pte_listening_fib.php"
remote_path = "/domains/targetbahasa.com/public_html/config/pte_listening_fib.php"

with open(local_path, "w") as f:
    f.write(config_content)

print(f"Generated {local_path} successfully.")
