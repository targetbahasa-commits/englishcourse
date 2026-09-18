import ftplib
import glob
import os

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"
LOCAL_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/listening-mcma-v2"
REMOTE_DIR = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts/listening-mcma"

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
ftp.cwd(REMOTE_DIR)

mp3_files = sorted(glob.glob(os.path.join(LOCAL_DIR, "*.mp3")))
total = len(mp3_files)
print(f"Uploading {total} MP3 files to {REMOTE_DIR}...")

for idx, file_path in enumerate(mp3_files, 1):
    filename = os.path.basename(file_path)
    with open(file_path, "rb") as f:
        ftp.storbinary(f"STOR {filename}", f)
    if idx % 20 == 0 or idx == total:
        print(f"  Uploaded {idx}/{total}")

ftp.quit()
print("Done!")
