import ftplib
import os

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)

files_to_force = [
    "public/storage/kokoro-tts/listening-summarize-spoken-text/topic_297.mp3",
    "public/storage/kokoro-tts/listening-summarize-spoken-text/topic_298.mp3",
    "public/storage/kokoro-tts/listening-summarize-spoken-text/topic_127.mp3",
    "public/storage/kokoro-tts/listening-summarize-spoken-text/topic_091.mp3",
]

for local_path in files_to_force:
    if os.path.exists(local_path):
        remote_path = f"/domains/targetbahasa.com/public_html/{local_path}"
        with open(local_path, "rb") as f:
            ftp.storbinary(f"STOR {remote_path}", f)
            print(f"Force uploaded {local_path}")
    else:
        print(f"File not found: {local_path}")

ftp.quit()
