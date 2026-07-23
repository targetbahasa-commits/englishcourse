#!/bin/bash
while pgrep -f generate_300_from_ai.py > /dev/null; do
    sleep 5
done

echo "AI Generation finished. Running config generators..."
python3 generate_300_all_modules.py
python3 generate_300_fib.py

echo "Uploading FIB config..."
python3 -c "import ftplib, os, re
with open('generate_300_all_modules.py', 'r') as f:
    text = f.read()
FTP_HOST = re.search(r'FTP_HOST\s*=\s*[\'\" ]([^\'\"]+)', text).group(1)
FTP_USER = re.search(r'FTP_USER\s*=\s*[\'\" ]([^\'\"]+)', text).group(1)
FTP_PASS = re.search(r'FTP_PASS\s*=\s*[\'\" ]([^\'\"]+)', text).group(1)

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
local_path = 'config/pte_listening_fib.php'
remote_path = f'/domains/targetbahasa.com/public_html/config/pte_listening_fib.php'
with open(local_path, 'rb') as f:
    ftp.storbinary(f'STOR {remote_path}', f)
ftp.quit()
"

echo "Running Kokoro audio generation..."
nohup python3 generate_audio_kokoro.py > audio_kokoro.log 2>&1 &
