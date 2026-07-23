"""
Regenerate all 300 audio files for the Listening: Multiple Choice Single Answer
module. The current live audio (kokoro-tts/listening-mcsa/lmcsa_topic_N.mp3) is
unrelated book-reading audio (Pride and Prejudice / Origin of Species), not TTS
of the actual question transcripts. This regenerates from the production config
(config/pte_listening_mcsa.php, which is what's actually served) using the local
Kokoro TTS server.

Usage: python3 generate_mcsa_audio.py
"""
import json
import os
import subprocess
import time

import requests

CONFIG_SOURCE = "/private/tmp/prod_pte_listening_mcsa.php"  # authoritative prod copy
OUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/listening-mcsa"
TTS_URL = "http://127.0.0.1:8100/api/generate-listening"
LOG_PATH = "/private/tmp/generate_mcsa_audio.log"
PROJECT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse"
RESTART_EVERY = 100000  # disabled: self-restart via subprocess killed the background task; restarts are now done externally between runs

os.makedirs(OUT_DIR, exist_ok=True)


def restart_tts_server():
    subprocess.run(["./start_tts.sh"], cwd=PROJECT_DIR, capture_output=True, timeout=30)
    time.sleep(2)


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
    since_restart = 0
    for idx, topic in enumerate(topics):
        out_path = os.path.join(OUT_DIR, f"lmcsa_topic_{idx}.mp3")
        if os.path.exists(out_path) and os.path.getsize(out_path) > 1000:
            skipped += 1
            continue

        if since_restart >= RESTART_EVERY:
            log(f"[{idx}] restarting TTS server to keep memory in check...")
            restart_tts_server()
            since_restart = 0

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
                    since_restart += 1
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
