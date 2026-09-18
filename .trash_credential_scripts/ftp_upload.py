import os
import ftplib
from pathlib import Path

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

local_dir = "/Applications/MAMP/htdocs/TargetBahasaCourse/public/storage/kokoro-tts/select-missing-word"
remote_dir = "/domains/targetbahasa.com/public_html/storage/app/public/kokoro-tts/select-missing-word"

print("Connecting to FTP...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
print("Changing directory...")
try:
    ftp.cwd(remote_dir)
except ftplib.error_perm:
    print("Creating remote directory...")
    ftp.mkd(remote_dir)
    ftp.cwd(remote_dir)

print("Fetching remote files list to skip existing full files...")
remote_files = set(ftp.nlst())
print(f"Found {len(remote_files)} remote files.")

local_path = Path(local_dir)
files_to_upload = list(local_path.glob("*.mp3"))

print(f"Found {len(files_to_upload)} local mp3 files.")

uploaded = 0
for file_path in files_to_upload:
    filename = file_path.name
    # if filename in remote_files:
    #     continue # skip checking size for now, just skip if exists?
    # wait, some might be incomplete, but let's just upload all that start from 233 or so. Actually let's just upload them all to be safe, overwriting directly
    
    print(f"Uploading {filename}...")
    try:
        with open(file_path, "rb") as f:
            ftp.storbinary(f"STOR {filename}", f)
        uploaded += 1
    except Exception as e:
        print(f"Failed to upload {filename}: {e}")

ftp.quit()
print(f"Successfully uploaded {uploaded} files.")
