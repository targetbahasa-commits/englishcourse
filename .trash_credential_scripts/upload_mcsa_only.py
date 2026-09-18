import ftplib
import os
import time

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

REMOTE_AUDIO = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts"
local_dir = "public/storage/kokoro-tts/listening-multiple-choice-single-answer"
remote_dir = f"{REMOTE_AUDIO}/listening-multiple-choice-single-answer"

files = [f for f in os.listdir(local_dir) if f.endswith(".mp3")]
files_to_upload = [(os.path.join(local_dir, filename), f"{remote_dir}/{filename}") for filename in sorted(files)]

ftp = None
for i, (local_path, remote_path) in enumerate(files_to_upload, 1):
    for attempt in range(3):
        try:
            if ftp is None:
                ftp = ftplib.FTP(FTP_HOST)
                ftp.login(user=FTP_USER, passwd=FTP_PASS)
            with open(local_path, "rb") as f:
                ftp.storbinary(f"STOR {remote_path}", f)
            break
        except Exception as e:
            try:
                if ftp: ftp.quit()
            except: pass
            ftp = None
            time.sleep(2)
if ftp: ftp.quit()
