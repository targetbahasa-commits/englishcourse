#!/bin/bash

# Konfigurasi FTP Hostinger
HOST="153.92.9.128"
USER="u822472458"
PASS="@Dreamer19"
REMOTE_DIR="/domains/targetbahasa.com/public_html"
LOCAL_DIR="/Applications/MAMP/htdocs/TargetBahasaCourse"

echo "Memulai ulang proses sinkronisasi ke server Hostinger (mengabaikan folder media besar)..."

# Menggunakan lftp untuk upload parallel dan mirror (sync)
lftp -c "
open -u $USER,'$PASS' ftp://$HOST;
set ssl:verify-certificate no;
set net:timeout 10;
set ftp:ssl-allow yes;

echo 'Menyalin file project (kecuali yang di-ignore)...';
mirror -R -v --parallel=4 \
    --exclude-glob .git/ \
    --exclude-glob .github/ \
    --exclude-glob node_modules/ \
    --exclude-glob tests/ \
    --exclude-glob tests-e2e/ \
    --exclude-glob storage/ \
    --exclude-glob .env \
    --exclude-glob .env.* \
    --exclude-glob database/database.sqlite \
    --exclude-glob playwright-report/ \
    --exclude-glob test-results/ \
    --exclude-glob .vscode/ \
    --exclude-glob .idea/ \
    --exclude-glob venv/ \
    --exclude-glob tools/ \
    --exclude-glob audio/ \
    --exclude-glob scratch/ \
    --exclude-glob public/storage \
    --exclude-glob .DS_Store \
    --exclude-glob listening/ \
    --exclude-glob public/pdfs/ \
    $LOCAL_DIR $REMOTE_DIR;

echo 'Mengupload .env.production sebagai .env...';
put -O $REMOTE_DIR $LOCAL_DIR/.env.production -o .env;

echo 'Upload public/migrate.php untuk menjalankan migrasi...';
put -O $REMOTE_DIR/public $LOCAL_DIR/public/migrate.php;
"

echo "Proses upload selesai!"
