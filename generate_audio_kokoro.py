import os, json, requests

AUDIO_DIR = "public/storage/kokoro-tts"
os.makedirs(AUDIO_DIR, exist_ok=True)
tts_url = "http://127.0.0.1:8100/api/generate-listening"

# We can parse the PHP files by calling php and json_encode!
php_script = """
<?php
$files = [
    'config/pte_retell_lecture.php' => 'rl',
    'config/pte_answer_short_question.php' => 'asq',
    'config/pte_listening_mcma.php' => 'lmcma',
    'config/pte_listening_fib.php' => 'fib',
    'config/pte_highlight_correct_summary.php' => 'hcs',
    'config/pte_listening_mcsa.php' => 'lmcsa',
    'config/pte_select_missing_word.php' => 'smw',
    'config/pte_highlight_incorrect_words.php' => 'hiw',
    'config/pte_write_from_dictation.php' => 'wfd'
];
$all = [];
foreach ($files as $f => $prefix) {
    if(file_exists($f)){
        $data = include $f;
        $all[$prefix] = $data;
    }
}
echo json_encode($all);
"""
with open('tmp_dump.php', 'w') as f:
    f.write(php_script)

import subprocess
out = subprocess.check_output(['php', 'tmp_dump.php'])
os.remove('tmp_dump.php')

data = json.loads(out)

for prefix, items in data.items():
    print(f"Generating audio for {prefix}...")
    for key, item in items.items():
        if isinstance(item, dict) and 'transcript' in item and 'voice' in item:
            text = item['transcript']
            voice = item['voice']
            mp3_filename = f"{prefix}_{key}.mp3"
            mp3_path = os.path.join(AUDIO_DIR, mp3_filename)
            
            if os.path.exists(mp3_path):
                continue
                
            payload = {
                "text": text,
                "voice": voice,
                "speed": 1.0,
                "lang": "en",
                "output_format": "mp3"
            }
            try:
                resp = requests.post(tts_url, json=payload, timeout=40)
                if resp.status_code == 200:
                    with open(mp3_path, 'wb') as f:
                        f.write(resp.content)
                    print(f"Generated {mp3_filename}")
                else:
                    print(f"Failed {mp3_filename}: {resp.status_code}")
            except Exception as e:
                print(f"Error {mp3_filename}: {e}")

