import ftplib
import os

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"
REMOTE_DIR = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts/listening-mcma"

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
ftp.cwd(REMOTE_DIR)

deleted_count = 0
for i in range(181, 305):
    filename = f"lmcma_topic_{i}.mp3"
    try:
        ftp.delete(filename)
        deleted_count += 1
    except Exception as e:
        pass # File might not exist

print(f"Deleted {deleted_count} old mp3 files from {REMOTE_DIR}.")

# Now try to delete the v2 folder from the other path
try:
    ftp.cwd("/domains/targetbahasa.com/public_html/storage/app/public/kokoro-tts/listening-mcma-v2")
    # To delete a non-empty directory in FTP, we need to delete its contents first
    files = ftp.nlst()
    for f in files:
        if f not in ('.', '..'):
            ftp.delete(f)
    ftp.cwd("..")
    ftp.rmd("listening-mcma-v2")
    print("Deleted leftover listening-mcma-v2 folder.")
except Exception as e:
    print("Could not delete listening-mcma-v2 folder, might not exist.", e)

ftp.quit()
