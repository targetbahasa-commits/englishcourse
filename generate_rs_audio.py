"""
Regenerate all 300 audio files for the Speaking: Repeat Sentence module.
The current live audio (kokoro-tts/repeat-sentence/rs_topic_N.mp3) is unrelated
book-reading audio (Pride and Prejudice / Origin of Species), not TTS of the
actual sentence content. Regenerates from config/pte_repeat_sentence.php
(verified identical between local and production) using the local Kokoro TTS
server.

Config is 1-indexed (keys 1..300) with a 'content' field (no 'transcript' key,
no per-topic voice). Filenames are 1-indexed: rs_topic_{id}.mp3, matching the
blade view's `rs_topic_{topicId}.mp3`.

Usage: python3 generate_rs_audio.py
"""
import json
import os
import subprocess
import time

import requests

CONFIG_SOURCE = "/private/tmp/prod_pte_repeat_sentence.php"
OUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/repeat-sentence"
TTS_URL = "http://127.0.0.1:8100/api/generate-listening"
LOG_PATH = "/private/tmp/generate_rs_audio.log"
DEFAULT_VOICE = "af_heart"

os.makedirs(OUT_DIR, exist_ok=True)


def load_topics():
    php = f'''
    $data = include "{CONFIG_SOURCE}";
    echo json_encode($data);
    '''
    out = subprocess.check_output(["php", "-r", php])
    return json.loads(out)  # dict keyed by "1".."300"


def log(msg):
    line = f"[{time.strftime('%H:%M:%S')}] {msg}"
    print(line, flush=True)
    with open(LOG_PATH, "a") as f:
        f.write(line + "\n")


def main():
    topics = load_topics()
    ids = sorted(int(k) for k in topics.keys())
    log(f"Loaded {len(ids)} topics from production config.")

    ok, failed, skipped = 0, [], 0
    for i, topic_id in enumerate(ids):
        topic = topics[str(topic_id)]
        out_path = os.path.join(OUT_DIR, f"rs_topic_{topic_id}.mp3")
        if os.path.exists(out_path) and os.path.getsize(out_path) > 1000:
            skipped += 1
            continue

        text = (topic.get("content") or "").strip()
        voice = topic.get("voice", DEFAULT_VOICE)
        if not text:
            log(f"[{topic_id}] SKIP: empty content")
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
                    if (i + 1) % 10 == 0:
                        log(f"[{i + 1}/{len(ids)}] generated (ok={ok} failed={len(failed)})")
                    break
                else:
                    raise RuntimeError(f"HTTP {resp.status_code}, {len(resp.content)} bytes")
            except Exception as e:
                if attempt == 2:
                    failed.append((topic_id, str(e)))
                    log(f"[{topic_id}] FAILED after 3 attempts: {e}")
                else:
                    time.sleep(2)

    log(f"Done. ok={ok} skipped={skipped} failed={len(failed)}")
    if failed:
        log(f"Failed ids: {[i for i, _ in failed]}")


if __name__ == "__main__":
    main()
