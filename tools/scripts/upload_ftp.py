import ftplib
import os
import glob
import subprocess
import time

# Get the list of modified files from the latest commit
result = subprocess.run(['git', 'show', '--name-only', '--format='], stdout=subprocess.PIPE)
git_files = [f for f in result.stdout.decode('utf-8').split('\n') if f]

# Add public/build/ to the list
build_files = glob.glob('public/build/**', recursive=True)
files_to_upload = git_files + [f for f in build_files if os.path.isfile(f)]

# Filter out deleted files
files_to_upload = [f for f in files_to_upload if os.path.isfile(f)]

host = "153.92.9.128"
username = "u822472458"
password = "@Dreamer19"
remote_path = "/domains/targetbahasa.com/public_html"

print(f"Total files to upload: {len(files_to_upload)}")

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
                pass # might already exist or permission denied

uploaded_count = 0
for file in files_to_upload:
    remote_file_path = f"{remote_path}/{file}".replace('//', '/')
    remote_dir = os.path.dirname(remote_file_path)
    
    max_retries = 3
    for attempt in range(max_retries):
        try:
            ensure_dir(ftp, remote_dir)
            print(f"Uploading {file} to {remote_file_path}")
            with open(file, 'rb') as f:
                ftp.storbinary(f"STOR {remote_file_path}", f)
            uploaded_count += 1
            break # Success, break out of retry loop
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

print(f"Done! Uploaded {uploaded_count} files successfully.")
