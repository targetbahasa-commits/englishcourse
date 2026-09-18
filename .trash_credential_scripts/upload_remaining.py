import ftplib
import os
import glob

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"
REMOTE_MP3_DIR = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts/listening-mcma"
LOCAL_DIR = "/Applications/MAMP/htdocs/TargetBahasaCourse/storage/app/public/kokoro-tts/listening-mcma"
PHP_PATH = "/Applications/MAMP/htdocs/TargetBahasaCourse/config/pte_listening_mcma.php"
REMOTE_PHP_DIR = "/domains/targetbahasa.com/public_html/config"

print("Uploading MP3 files to FTP...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
ftp.cwd(REMOTE_MP3_DIR)

mp3_files = sorted(glob.glob(os.path.join(LOCAL_DIR, "*.mp3")))
total = len(mp3_files)
for idx, file_path in enumerate(mp3_files, 1):
    filename = os.path.basename(file_path)
    # Only upload 248 to 299, since 0-247 was already uploaded?
    # Wait, the previous task failed at 50/248! So NOT all were uploaded!
    # I should upload ALL 300 mp3s to be safe.
    with open(file_path, "rb") as file:
        ftp.storbinary(f"STOR {filename}", file)
    if idx % 50 == 0 or idx == total:
        print(f"Uploaded {idx}/{total} MP3s")

print("Uploading PHP config to FTP...")
ftp.cwd(REMOTE_PHP_DIR)
with open(PHP_PATH, "rb") as file:
    ftp.storbinary("STOR pte_listening_mcma.php", file)

ftp.quit()
print("Done!")
