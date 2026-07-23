#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# Start script for Listening Machine microservice
# Usage:  bash tools/listening-machine-api/start.sh
# ─────────────────────────────────────────────────────────────────────────────

set -e
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
VENV_DIR="$SCRIPT_DIR/venv"

# Activate the dedicated venv
if [ -f "$VENV_DIR/bin/activate" ]; then
    source "$VENV_DIR/bin/activate"
    echo "[Listening Machine] Using venv: $VENV_DIR"
    python --version
else
    echo "[Listening Machine] ERROR: venv not found at $VENV_DIR"
    echo "  Run: python3.11 -m venv tools/listening-machine-api/venv"
    echo "  Then: source tools/listening-machine-api/venv/bin/activate && pip install -r tools/listening-machine-api/requirements.txt"
    exit 1
fi

# Ensure storage directory for listening banks exists
mkdir -p "$(dirname "$SCRIPT_DIR")/../../storage/app/public/listening-banks"

echo "[Listening Machine] Starting FastAPI on http://127.0.0.1:8100"
cd "$SCRIPT_DIR"
uvicorn main:app --host 127.0.0.1 --port 8100 --reload
