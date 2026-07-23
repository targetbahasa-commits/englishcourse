#!/bin/bash
# ─────────────────────────────────────────────────────────────────
# api-manager.sh — Listening Machine TTS Server Manager
# ─────────────────────────────────────────────────────────────────

PROJECT_DIR="/Applications/MAMP/htdocs/TargetBahasaCourse"
TOOLS_DIR="$PROJECT_DIR/tools/listening-machine-api"
VENV_UVICORN="$TOOLS_DIR/venv/bin/uvicorn"
MAIN_PY="$TOOLS_DIR/main.py"
LOG_FILE="$TOOLS_DIR/server.log"
ERR_FILE="$TOOLS_DIR/server.error.log"
PID_FILE="$TOOLS_DIR/server.pid"
PORT=8100

is_running() {
    if [ -f "$PID_FILE" ]; then
        PID=$(cat "$PID_FILE")
        if kill -0 "$PID" 2>/dev/null; then
            return 0
        fi
    fi
    # Also check via port
    PORTPID=$(lsof -ti :$PORT 2>/dev/null | head -1)
    if [ -n "$PORTPID" ]; then
        echo "$PORTPID" > "$PID_FILE"
        return 0
    fi
    return 1
}

case "$1" in
    start)
        if is_running; then
            echo "✅ Server sudah berjalan (PID $(cat $PID_FILE))"
            exit 0
        fi

        echo "🚀 Menyalakan Kokoro TTS Server di port $PORT..."
        mkdir -p "$(dirname "$LOG_FILE")"

        # Kill anything on the port just in case
        EXISTING=$(lsof -ti :$PORT 2>/dev/null)
        [ -n "$EXISTING" ] && kill -9 $EXISTING 2>/dev/null && sleep 1

        # Start server in background using the venv uvicorn
        nohup "$VENV_UVICORN" main:app \
            --host 127.0.0.1 \
            --port $PORT \
            --app-dir "$TOOLS_DIR" \
            >> "$LOG_FILE" 2>> "$ERR_FILE" &

        echo $! > "$PID_FILE"
        sleep 4

        if is_running; then
            echo "✅ Server BERHASIL dinyalakan! (PID $(cat $PID_FILE), Port $PORT)"
        else
            echo "⏳ Server masih loading model AI (tunggu ~10 detik, lalu cek status)"
        fi
        ;;

    stop)
        echo "🛑 Mematikan server..."
        if [ -f "$PID_FILE" ]; then
            PID=$(cat "$PID_FILE")
            kill "$PID" 2>/dev/null
            sleep 1
            kill -9 "$PID" 2>/dev/null
            rm -f "$PID_FILE"
        fi
        # Kill anything still on port
        PORTPID=$(lsof -ti :$PORT 2>/dev/null)
        [ -n "$PORTPID" ] && kill -9 $PORTPID 2>/dev/null
        echo "🛑 Server berhasil dimatikan. RAM Anda kembali lega!"
        ;;

    status)
        if is_running; then
            echo "🟢 ONLINE"
        else
            echo "🔴 OFFLINE"
        fi
        ;;

    *)
        echo "Usage: $0 {start|stop|status}"
        exit 1
        ;;
esac
