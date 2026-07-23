import ftplib
import os

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

REMOTE_AUDIO = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts/listening-fill-blanks"
LOCAL_AUDIO = "public/storage/kokoro-tts/listening-fill-blanks"

def get_ftp():
    ftp = ftplib.FTP(FTP_HOST)
    ftp.login(user=FTP_USER, passwd=FTP_PASS)
    return ftp

ftp = get_ftp()

# Ensure remote dir exists
try:
    ftp.mkd(REMOTE_AUDIO)
except Exception:
    pass

files = os.listdir(LOCAL_AUDIO)
mp3s = [f for f in files if f.endswith('.mp3')]
total = len(mp3s)
print(f"Uploading {total} MP3s...")

for i, f in enumerate(mp3s):
    local_path = os.path.join(LOCAL_AUDIO, f)
    remote_path = f"{REMOTE_AUDIO}/{f}"
    
    with open(local_path, "rb") as file_obj:
        try:
            ftp.storbinary(f"STOR {remote_path}", file_obj)
        except Exception as e:
            # Reconnect and retry once
            ftp = get_ftp()
            ftp.storbinary(f"STOR {remote_path}", file_obj)
            
    if (i+1) % 50 == 0:
        print(f"Uploaded {i+1}/{total}")

print("Upload complete!")
