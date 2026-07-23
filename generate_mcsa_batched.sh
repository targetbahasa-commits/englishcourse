#!/bin/bash
# Runs generate_mcsa_audio.py in a loop, restarting the TTS server every batch
# to avoid the memory-pressure slowdown seen in the first run.
set -e
cd /Applications/MAMP/htdocs/TargetBahasaCourse

TARGET=300
DIR="storage/app/public/kokoro-tts/listening-mcsa"

while true; do
    COUNT=$(ls "$DIR" 2>/dev/null | wc -l | tr -d ' ')
    echo "[batch-runner] $COUNT/$TARGET files present."
    if [ "$COUNT" -ge "$TARGET" ]; then
        echo "[batch-runner] Done."
        break
    fi

    echo "[batch-runner] Restarting TTS server..."
    ./start_tts.sh
    sleep 2

    echo "[batch-runner] Running generation (will process until this batch's cap or failure)..."
    timeout 360 python3 generate_mcsa_audio.py || true

    sleep 2
done
