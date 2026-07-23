#!/bin/bash
# ─────────────────────────────────────────────────────────────────
# start_tts.sh — Start Kokoro TTS Server on port 8100
# Usage: ./start_tts.sh
# ─────────────────────────────────────────────────────────────────

PROJECT_DIR="/Applications/MAMP/htdocs/TargetBahasaCourse"
LOG_FILE="$PROJECT_DIR/storage/logs/tts_server.log"
PID_FILE="$PROJECT_DIR/storage/logs/tts_server.pid"

# Kill any existing instance
if [ -f "$PID_FILE" ]; then
    OLD_PID=$(cat "$PID_FILE")
    if kill -0 "$OLD_PID" 2>/dev/null; then
        echo "⏹  Stopping existing TTS server (PID $OLD_PID)…"
        kill "$OLD_PID"
        sleep 1
    fi
fi

# Also kill anything on port 8100
EXISTING=$(lsof -ti :8100 2>/dev/null)
if [ -n "$EXISTING" ]; then
    echo "⏹  Killing process on port 8100 (PID $EXISTING)…"
    kill -9 $EXISTING 2>/dev/null
    sleep 1
fi

echo "🚀 Starting Kokoro TTS Server on http://127.0.0.1:8100 …"
nohup python3 "$PROJECT_DIR/tts_server.py" >> "$LOG_FILE" 2>&1 &
TTS_PID=$!
echo $TTS_PID > "$PID_FILE"

sleep 2

# Check if it started
if kill -0 "$TTS_PID" 2>/dev/null; then
    echo "✅ TTS Server started! PID=$TTS_PID"
    echo "   Health: $(curl -s http://127.0.0.1:8100/health)"
    echo "   Logs: $LOG_FILE"
else
    echo "❌ TTS Server failed to start. Check logs:"
    tail -20 "$LOG_FILE"
    exit 1
fi
