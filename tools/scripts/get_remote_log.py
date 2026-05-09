import ftplib
import os

FTP_HOST = '153.92.9.128'
FTP_USER = 'u822472458'
FTP_PASS = '@Dreamer19'
REMOTE_LOG = '/domains/targetbahasa.com/public_html/storage/logs/laravel.log'
LOCAL_LOG = 'remote_laravel.log'

print(f"Connecting to FTP: {FTP_HOST}...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.set_pasv(True)
print("Connected!")

print("Downloading log...")
with open(LOCAL_LOG, 'wb') as f:
    ftp.retrbinary(f'RETR {REMOTE_LOG}', f.write)

ftp.quit()
print("Done! Read the last lines of remote_laravel.log")
