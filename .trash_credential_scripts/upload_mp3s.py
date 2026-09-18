import ftplib
import os
import glob

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"
REMOTE_DIR = "/domains/targetbahasa.com/public_html/storage/app/public/kokoro-tts"
LOCAL_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts"

print(f"Connecting to {FTP_HOST}...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
ftp.cwd(REMOTE_DIR)

mp3_files = glob.glob(os.path.join(LOCAL_DIR, "*.mp3"))
print(f"Found {len(mp3_files)} MP3 files to upload.")

for idx, file_path in enumerate(mp3_files, 1):
    filename = os.path.basename(file_path)
    print(f"[{idx}/{len(mp3_files)}] Uploading {filename}...")
    with open(file_path, "rb") as file:
        ftp.storbinary(f"STOR {filename}", file)

ftp.quit()
print("Upload complete!")
