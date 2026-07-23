#!/usr/bin/env python3
"""
Regenerate all 300 HCS (Highlight Correct Summary) audio files.
Each file will be re-generated from the correct transcript in the config.
Overwrites existing files.

Format for TTS server: speakers = [{"tag": "A", "voice_id": "<voice>"}]
"""

import os, json, subprocess, requests, time

AUDIO_DIR = "storage/app/public/kokoro-tts"
TTS_URL   = "http://127.0.0.1:8100/api/generate-listening"
CONFIG    = "config/pte_highlight_correct_summary.php"

os.makedirs(AUDIO_DIR, exist_ok=True)

# --- Load config via PHP ---
php_script = f"""<?php
$data = require '{CONFIG}';
echo json_encode($data);
"""
with open('_tmp_hcs_dump.php', 'w') as f:
    f.write(php_script)

try:
    out = subprocess.check_output(['php', '_tmp_hcs_dump.php'], stderr=subprocess.DEVNULL)
    topics = json.loads(out)
finally:
    if os.path.exists('_tmp_hcs_dump.php'):
        os.remove('_tmp_hcs_dump.php')

print(f"Loaded {len(topics)} HCS topics.")
print(f"Saving audio to: {os.path.abspath(AUDIO_DIR)}\n")

success, fail, skip = 0, 0, 0

for i, item in enumerate(topics):
    transcript = item.get('transcript', '').strip()
    voice      = item.get('voice', 'af_sky')
    filename   = item.get('filename', f'hcs_{i}.mp3')
    mp3_path   = os.path.join(AUDIO_DIR, filename)

    if not transcript:
        print(f"[{i:3d}] SKIP — no transcript")
        skip += 1
        continue

    payload = {
        "text": transcript,
        "speakers": [{"tag": "A", "voice_id": voice}]
    }

    done = False
    for attempt in range(3):
        try:
            resp = requests.post(TTS_URL, json=payload, timeout=120)
            if resp.status_code == 200 and len(resp.content) > 1000:
                with open(mp3_path, 'wb') as f:
                    f.write(resp.content)
                print(f"[{i:3d}] OK  — {filename} ({len(resp.content)//1024}KB) voice={voice}")
                success += 1
                done = True
                break
            else:
                print(f"[{i:3d}] ERR attempt {attempt+1} — status={resp.status_code} body={resp.text[:80]}")
                time.sleep(2)
        except Exception as e:
            print(f"[{i:3d}] EXC attempt {attempt+1} — {e}")
            time.sleep(3)

    if not done:
        fail += 1
        print(f"[{i:3d}] FAIL — giving up on {filename}")

print(f"\n{'='*50}")
print(f"Done: {success} success, {fail} failed, {skip} skipped")
print(f"Audio directory: {os.path.abspath(AUDIO_DIR)}")
