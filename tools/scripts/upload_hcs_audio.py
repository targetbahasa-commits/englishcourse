import ftplib
import os
import time

host = "153.92.9.128"
username = "u822472458"
password = "@Dreamer19"
remote_path = "/domains/targetbahasa.com/public_html"
local_dir = "storage/app/public/kokoro-tts"

def get_ftp_connection():
    ftp = ftplib.FTP()
    ftp.connect(host, 21)
    ftp.login(username, password)
    ftp.set_pasv(True)
    return ftp

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

ftp = get_ftp_connection()

files_uploaded = 0

for root, _, files in os.walk(local_dir):
    for file_name in files:
        if file_name.startswith("hcs_") and file_name.endswith(".mp3"):
            local_file = os.path.join(root, file_name)
            
            # Check if file was modified recently (in the last hour)
            mtime = os.path.getmtime(local_file)
            if time.time() - mtime > 3600:
                continue
                
            remote_file_path = f"{remote_path}/{local_file}".replace('//', '/')
            remote_dir = os.path.dirname(remote_file_path)

            max_retries = 3
            for attempt in range(max_retries):
                try:
                    ensure_dir(ftp, remote_dir)
                    print(f"Uploading {local_file} -> {remote_file_path}")
                    with open(local_file, 'rb') as f:
                        ftp.storbinary(f"STOR {remote_file_path}", f)
                    files_uploaded += 1
                    break
                except Exception as e:
                    print(f"Error uploading {local_file}: {e}. Retrying ({attempt+1}/{max_retries})...")
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

print(f"Done uploading {files_uploaded} HCS audio files to production!")
