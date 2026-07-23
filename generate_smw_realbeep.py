"""
Regenerate all 300 Select Missing Word audio files using a REAL electronic beep
tone (a short double sine-wave "beep-beep", like a censor/sensor tone) instead
of having the TTS voice literally speak the word "beep" out loud.

Pipeline per topic:
  1. Strip the trailing " [beep]." marker from the config transcript, leaving
     just the sentence fragment up to the blank.
  2. Generate TTS speech for that fragment only.
  3. Concatenate the speech with a pre-generated beep-tone clip via ffmpeg.
  4. Save as the final smw_topic_{id}.mp3.

Usage: python3 generate_smw_realbeep.py
"""
import json
import os
import subprocess
import time

import requests

CONFIG_SOURCE = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_select_missing_word.php"
OUT_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/select-missing-word"
TMP_SPEECH_DIR = "/private/tmp/smw_realbeep_speech"
BEEP_TONE = "/private/tmp/beep_tone_test.mp3"
TTS_URL = "http://127.0.0.1:8100/api/generate-listening"
LOG_PATH = "/private/tmp/generate_smw_realbeep.log"
DEFAULT_VOICE = "af_heart"

os.makedirs(OUT_DIR, exist_ok=True)
os.makedirs(TMP_SPEECH_DIR, exist_ok=True)


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


def strip_beep_marker(transcript):
    t = transcript.strip()
    for suffix in (" [beep].", " [beep]", "[beep].", "[beep]"):
        if t.endswith(suffix):
            return t[: -len(suffix)].strip()
    return t


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

        text = strip_beep_marker(topic.get("transcript") or "")
        voice = topic.get("voice", DEFAULT_VOICE)
        if not text:
            log(f"[{idx}] SKIP: empty transcript")
            continue

        speech_path = os.path.join(TMP_SPEECH_DIR, f"speech_{topic_id}.mp3")

        for attempt in range(3):
            try:
                resp = requests.post(
                    TTS_URL,
                    json={"text": text, "speakers": [{"tag": "S1", "voice_id": voice}]},
                    timeout=90,
                )
                if resp.status_code == 200 and len(resp.content) > 1000:
                    with open(speech_path, "wb") as f:
                        f.write(resp.content)
                    break
                else:
                    raise RuntimeError(f"HTTP {resp.status_code}, {len(resp.content)} bytes")
            except Exception as e:
                if attempt == 2:
                    failed.append((idx, f"TTS failed: {e}"))
                    log(f"[{idx}] FAILED (TTS) after 3 attempts: {e}")
                else:
                    time.sleep(2)
        else:
            continue

        if not os.path.exists(speech_path):
            continue

        try:
            subprocess.run(
                [
                    "ffmpeg", "-i", speech_path, "-i", BEEP_TONE,
                    "-filter_complex", "[0:a][1:a]concat=n=2:v=0:a=1[out]",
                    "-map", "[out]", "-ar", "24000", "-ac", "1",
                    "-y", out_path, "-loglevel", "error",
                ],
                check=True,
                timeout=30,
            )
            ok += 1
            os.remove(speech_path)
            if (idx + 1) % 10 == 0:
                log(f"[{idx + 1}/{len(topics)}] generated (ok={ok} failed={len(failed)})")
        except Exception as e:
            failed.append((idx, f"ffmpeg concat failed: {e}"))
            log(f"[{idx}] FAILED (concat): {e}")

    log(f"Done. ok={ok} skipped={skipped} failed={len(failed)}")
    if failed:
        log(f"Failed indices: {[i for i, _ in failed]}")


if __name__ == "__main__":
    main()
