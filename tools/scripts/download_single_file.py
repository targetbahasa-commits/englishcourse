import ftplib
import os
import sys

if len(sys.argv) < 2:
    print("Usage: python3 download_single_file.py <file_path>")
    sys.exit(1)

file = sys.argv[1]

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
remote_file_path = f"{remote_path}/{file}".replace('//', '/')

print(f"Downloading {remote_file_path} to {file}")
try:
    with open(file, 'wb') as f:
        ftp.retrbinary(f"RETR {remote_file_path}", f.write)
    print("Done!")
except Exception as e:
    print(f"Error downloading: {e}")
ftp.quit()
