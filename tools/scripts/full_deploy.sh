#!/bin/bash
# Full deployment script: removes old project and uploads the latest version
# Uses lftp mirror --reverse --delete to sync local -> remote

HOST="153.92.9.128"
USER="u822472458"
PASS="@Dreamer19"
REMOTE_PATH="/domains/targetbahasa.com/public_html"
LOCAL_PATH="/Applications/MAMP/htdocs/TargetBahasaCourse"

echo "=== TargetBahasa Full Deployment ==="
echo "Starting at: $(date)"
echo "Local: $LOCAL_PATH"
echo "Remote: $REMOTE_PATH"
echo ""

lftp -u "$USER","$PASS" "ftp://$HOST" <<EOF
set ftp:ssl-allow no
set net:timeout 30
set net:max-retries 5
set net:reconnect-interval-base 5
set net:reconnect-interval-multiplier 1
set mirror:parallel-transfer-count 5
set xfer:clobber on

# Mirror local -> remote with delete (removes files on remote that don't exist locally)
# Excludes: .git, node_modules, .vscode, storage/logs, storage/framework, test artifacts, .env, database.sqlite
mirror --reverse --delete --verbose \
  --exclude ^\.git/ \
  --exclude ^\.vscode/ \
  --exclude ^node_modules/ \
  --exclude ^storage/logs/ \
  --exclude ^storage/framework/cache/ \
  --exclude ^storage/framework/sessions/ \
  --exclude ^storage/framework/views/ \
  --exclude ^playwright-report/ \
  --exclude ^test-results/ \
  --exclude ^\.env$ \
  --exclude ^database/database\.sqlite$ \
  --exclude ^tools/scripts/upload_ftp\.py$ \
  "$LOCAL_PATH" "$REMOTE_PATH"

bye
EOF

echo ""
echo "=== Deployment completed at: $(date) ==="
