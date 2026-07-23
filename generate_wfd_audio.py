"""
Regenerate all 300 audio files for the Listening: Write From Dictation module.
The current live audio (kokoro-tts/write-from-dictation/wfd_topic_N.mp3) is
unrelated book-reading audio (Pride and Prejudice / Origin of Species), not TTS
of the actual dictation transcripts. Regenerates from config/pte_write_from_dictation.php
(verified identical between local and production) using the local Kokoro TTS server.

Filenames are 1-indexed (wfd_topic_1.mp3 for config array index 0), matching the
blade view's `wfd_topic_{topicId}.mp3` where topicId = arrayIndex + 1.

Usage: python3 generate_wfd_audio.py
"""
import json
import os
import subprocess
import time

import requests

CONFIG_SOURCE = "/private/tmp/prod_pte_write_from_dictation.php"
OUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/write-from-dictation"
TTS_URL = "http://127.0.0.1:8100/api/generate-listening"
LOG_PATH = "/private/tmp/generate_wfd_audio.log"

os.makedirs(OUT_DIR, exist_ok=True)


def load_topics():
    php = f'''
    $data = include "{CONFIG_SOURCE}";
    echo json_encode(array_values($data));
    '''
    out = subprocess.check_output(["php", "-r", php])
    return json.loads(out)


def log(msg):
    line = f"[{time.strftime('%H:%M:%S')}] {msg}"
    print(line, flush=True)
    with open(LOG_PATH, "a") as f:
        f.write(line + "\n")


def main():
    topics = load_topics()
    log(f"Loaded {len(topics)} topics from production config.")

    ok, failed, skipped = 0, [], 0
    for idx, topic in enumerate(topics):
        topic_id = idx + 1  # filenames are 1-indexed
        out_path = os.path.join(OUT_DIR, f"wfd_topic_{topic_id}.mp3")
        if os.path.exists(out_path) and os.path.getsize(out_path) > 1000:
            skipped += 1
            continue

        text = topic.get("transcript", "").strip()
        voice = topic.get("voice", "af_heart")
        if not text:
            log(f"[{idx}] SKIP: empty transcript")
            continue

        for attempt in range(3):
            try:
                resp = requests.post(
                    TTS_URL,
                    json={"text": text, "speakers": [{"tag": "S1", "voice_id": voice}]},
                    timeout=90,
                )
                if resp.status_code == 200 and len(resp.content) > 1000:
                    with open(out_path, "wb") as f:
                        f.write(resp.content)
                    ok += 1
                    if (idx + 1) % 10 == 0:
                        log(f"[{idx + 1}/{len(topics)}] generated (ok={ok} failed={len(failed)})")
                    break
                else:
                    raise RuntimeError(f"HTTP {resp.status_code}, {len(resp.content)} bytes")
            except Exception as e:
                if attempt == 2:
                    failed.append((idx, str(e)))
                    log(f"[{idx}] FAILED after 3 attempts: {e}")
                else:
                    time.sleep(2)

    log(f"Done. ok={ok} skipped={skipped} failed={len(failed)}")
    if failed:
        log(f"Failed indices: {[i for i, _ in failed]}")


if __name__ == "__main__":
    main()
