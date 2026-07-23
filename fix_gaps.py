import os
import glob
import re
import ftplib

PHP_PATH = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_listening_mcma.php"
LOCAL_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/listening-mcma"
FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"
REMOTE_MP3_DIR = "/domains/targetbahasa.com/public_html/storage/app/public/kokoro-tts/listening-mcma"
REMOTE_PHP_DIR = "/domains/targetbahasa.com/public_html/config"

with open(PHP_PATH, 'r') as f:
    content = f.read()

# Extract items
items = re.findall(r"(\s*\d+ => \[\n.*?'voice'.*?\n\s*\],)", content, re.DOTALL)

new_content = "<?php\n\nreturn [\n"
renames = []

for new_id, item_str in enumerate(items):
    # Extract old id
    old_id_match = re.search(r"^\s*(\d+) => \[", item_str)
    if old_id_match:
        old_id = int(old_id_match.group(1))
        # Replace the key
        item_str = re.sub(r"^\s*\d+ => \[", f"  {new_id} => [", item_str, count=1)
        new_content += item_str + "\n"
        
        # We need to rename lmcma_topic_{old_id}.mp3 to lmcma_topic_{new_id}.mp3
        if old_id != new_id:
            old_mp3 = os.path.join(LOCAL_DIR, f"lmcma_topic_{old_id}.mp3")
            new_mp3 = os.path.join(LOCAL_DIR, f"lmcma_topic_{new_id}.mp3")
            if os.path.exists(old_mp3):
                os.rename(old_mp3, new_mp3)
                renames.append(new_mp3)

new_content += "];\n"

with open(PHP_PATH, 'w') as f:
    f.write(new_content)

print(f"Re-indexed {len(items)} items. Made {len(renames)} renames.")

print("Uploading MP3 files to FTP...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
ftp.cwd(REMOTE_MP3_DIR)

mp3_files = glob.glob(os.path.join(LOCAL_DIR, "*.mp3"))
for idx, file_path in enumerate(mp3_files, 1):
    filename = os.path.basename(file_path)
    with open(file_path, "rb") as file:
        ftp.storbinary(f"STOR {filename}", file)

print("Uploading PHP config to FTP...")
ftp.cwd(REMOTE_PHP_DIR)
with open(PHP_PATH, "rb") as file:
    ftp.storbinary("STOR pte_listening_mcma.php", file)

ftp.quit()
print("Done!")
