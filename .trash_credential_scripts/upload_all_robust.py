import ftplib
import os
import time

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

REMOTE_AUDIO = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts"
local_audio_base = "public/storage/kokoro-tts"

audio_dirs = [
    "listening-summarize-spoken-text",
    "listening-fill-blanks",
    "listening-highlight-correct-summary",
    "listening-mcma",
    "listening-multiple-choice-single-answer",
    "listening-select-missing-word",
    "highlight-incorrect-words",
]

def get_ftp():
    ftp = ftplib.FTP(FTP_HOST)
    ftp.login(user=FTP_USER, passwd=FTP_PASS)
    return ftp

print("Starting robust upload...")

files_to_upload = []

for subdir in audio_dirs:
    local_dir = os.path.join(local_audio_base, subdir)
    remote_dir = f"{REMOTE_AUDIO}/{subdir}"
    if not os.path.isdir(local_dir):
        continue
    files = [f for f in os.listdir(local_dir) if f.endswith(".mp3")]
    for filename in sorted(files):
        files_to_upload.append((os.path.join(local_dir, filename), f"{remote_dir}/{filename}"))

root_mp3s = [f for f in os.listdir(local_audio_base) if f.endswith(".mp3")]
for filename in sorted(root_mp3s):
    files_to_upload.append((os.path.join(local_audio_base, filename), f"{REMOTE_AUDIO}/{filename}"))

total = len(files_to_upload)
print(f"Total files to upload: {total}")

ftp = None
for i, (local_path, remote_path) in enumerate(files_to_upload, 1):
    success = False
    for attempt in range(3):
        try:
            if ftp is None:
                ftp = get_ftp()
            with open(local_path, "rb") as f:
                ftp.storbinary(f"STOR {remote_path}", f)
            success = True
            break
        except Exception as e:
            print(f"    ✗ Error on {local_path}: {e}")
            try:
                if ftp:
                    ftp.quit()
            except:
                pass
            ftp = None
            time.sleep(2)
            
    if success:
        if i % 50 == 0 or i == total:
            print(f"    [{i}/{total}] uploaded {local_path}...")
    else:
        print(f"    ✗ FAILED to upload {local_path} after 3 retries.")

if ftp:
    try:
        ftp.quit()
    except:
        pass
print("\n=== DONE! ===")
