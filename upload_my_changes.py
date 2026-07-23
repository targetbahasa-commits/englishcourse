import os
import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

def ensure_dir_exists(ftp, remote_dir):
    parts = [p for p in remote_dir.split('/') if p]
    current = ""
    for part in parts:
        current += f"/{part}"
        try:
            ftp.cwd(current)
        except ftplib.error_perm:
            try:
                ftp.mkd(current)
                ftp.cwd(current)
            except Exception as e:
                pass

def upload_file(ftp, local_path, remote_path):
    remote_dir = os.path.dirname(remote_path)
    ensure_dir_exists(ftp, remote_dir)
    with open(local_path, "rb") as file:
        ftp.storbinary(f"STOR {remote_path}", file)
    print(f"Uploaded: {local_path} -> {remote_path}")

try:
    ftp = ftplib.FTP(FTP_HOST)
    ftp.login(FTP_USER, FTP_PASS)
    print("Logged in successfully.")
    
    with open('changed_files.txt', 'r') as f:
        files = f.read().splitlines()
        
    for f in files:
        if f.strip():
            remote = f"/domains/targetbahasa.com/public_html/{f}"
            upload_file(ftp, f, remote)
            
    ftp.quit()
    print("All files uploaded successfully.")
except Exception as e:
    print(f"FTP Error: {e}")
