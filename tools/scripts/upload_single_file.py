import ftplib
import os
import sys
import time

if len(sys.argv) < 2:
    print("Usage: python3 upload_single_file.py <file_path>")
    sys.exit(1)

file = sys.argv[1]
if not os.path.isfile(file):
    print(f"File not found: {file}")
    sys.exit(1)

host = "153.92.9.128"
username = "u822472458"
password = "@Dreamer19"
remote_path = "/domains/targetbahasa.com/public_html"

def get_ftp_connection():
    ftp = ftplib.FTP()
    ftp.connect(host, 21)
    ftp.login(username, password)
    ftp.set_pasv(True)
    return ftp

ftp = get_ftp_connection()

def ensure_dir(ftp, dir_path):
    parts = dir_path.split('/')
    for i in range(1, len(parts) + 1):
        path = '/'.join(parts[:i])
        try:
            ftp.cwd(path)
            ftp.cwd('/')
        except ftplib.error_perm:
            try:
                ftp.mkd(path)
            except ftplib.error_perm:
                pass

remote_file_path = f"{remote_path}/{file}".replace('//', '/')
remote_dir = os.path.dirname(remote_file_path)

max_retries = 3
for attempt in range(max_retries):
    try:
        ensure_dir(ftp, remote_dir)
        print(f"Uploading {file} to {remote_file_path}")
        with open(file, 'rb') as f:
            ftp.storbinary(f"STOR {remote_file_path}", f)
        print("Done!")
        break
    except Exception as e:
        print(f"Error uploading {file}: {e}. Retrying ({attempt+1}/{max_retries})...")
        try:
            ftp.quit()
        except:
            pass
        time.sleep(2)
        ftp = get_ftp_connection()

try:
    ftp.quit()
except:
    pass
