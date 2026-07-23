"""
Regenerate all 300 audio files for the Listening: Select Missing Word module
using the newly authored question bank (config/pte_select_missing_word.php),
which replaces the old bank that had only 11 unique transcripts repeated ~27x
each with mismatched/nonsensical distractor options.

Config is 0-indexed (array), each entry has 'transcript' and 'voice'. Filenames
are topicId-indexed (1-based): smw_topic_{topicId}.mp3, matching the blade
view's `smw_topic_{topicId}.mp3` where topicId = arrayIndex + 1.

Usage: python3 generate_smw_audio_v2.py
"""
import json
import os
import subprocess
import time

import requests

CONFIG_SOURCE = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_select_missing_word.php"
OUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/select-missing-word"
TTS_URL = "http://127.0.0.1:8100/api/generate-listening"
LOG_PATH = "/private/tmp/generate_smw_v2_audio.log"
DEFAULT_VOICE = "af_heart"

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
    log(f"Loaded {len(topics)} topics from config.")

    ok, failed, skipped = 0, [], 0
    for idx, topic in enumerate(topics):
        topic_id = idx + 1
        out_path = os.path.join(OUT_DIR, f"smw_topic_{topic_id}.mp3")
        if os.path.exists(out_path) and os.path.getsize(out_path) > 1000:
            skipped += 1
            continue

        text = (topic.get("transcript") or "").strip()
        voice = topic.get("voice", DEFAULT_VOICE)
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
