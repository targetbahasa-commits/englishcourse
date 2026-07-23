"""
Regenerate all 300 audio files for the Speaking: Retell Lecture module.

This fixes TWO bugs at once:
1. 404s in production: the blade view expects kokoro-tts/retell-lecture/
   rtl_topic_{topicId-1}.mp3, but that exact path/filename never existed —
   the two folders that DO exist (kokoro-tts/retell-lecture with rl_topic_N.mp3
   naming, and kokoro-tts/speaking-retell-lecture with topic_NNN.mp3 naming)
   use different filenames and were never referenced by any route/blade code.
2. Wrong content: both of those existing folders were also confirmed (via
   whisper transcription) to contain audio for the WRONG topic per file —
   same disease as MCMA/HIW/SST before their fixes.

Generating fresh directly into the exact path+filename the blade already
expects (kokoro-tts/retell-lecture/rtl_topic_{idx}.mp3) fixes both issues
without touching any PHP/blade code.

Source: config/pte_retell_lecture.php (verified identical between local and
production). Config is 0-indexed (array), each entry has 'transcript' and
'voice'.

Usage: python3 generate_rtl_audio.py
"""
import json
import os
import subprocess
import time

import requests

CONFIG_SOURCE = "/private/tmp/prod_pte_retell_lecture.php"
OUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/retell-lecture"
TTS_URL = "http://127.0.0.1:8100/api/generate-listening"
LOG_PATH = "/private/tmp/generate_rtl_audio.log"
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
    log(f"Loaded {len(topics)} topics from production config.")

    ok, failed, skipped = 0, [], 0
    for idx, topic in enumerate(topics):
        out_path = os.path.join(OUT_DIR, f"rtl_topic_{idx}.mp3")
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
