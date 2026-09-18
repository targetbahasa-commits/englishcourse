import os
import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

def ensure_dir_exists(ftp, remote_dir):
    parts = [p for p in remote_dir.split('/') if p]
    current = ""
    for p in parts:
        current += "/" + p
        try:
            ftp.cwd(current)
        except ftplib.error_perm:
            ftp.mkd(current)
            ftp.cwd(current)

ftp = ftplib.FTP()
ftp.connect(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd('/')

for root, dirs, files in os.walk('resources/views/assignments/pte-academic/'):
    for file in files:
        if file.endswith('.blade.php'):
            local_path = os.path.join(root, file)
            # check if it was modified in the last 15 mins
            if os.path.getmtime(local_path) > os.path.getmtime('upload_autoplay_fixes.py') - 900:
                print(f"Uploading {local_path}...")
                remote_path = "/domains/targetbahasa.com/public_html/" + local_path
                remote_dir = os.path.dirname(remote_path)
                ensure_dir_exists(ftp, remote_dir)
                with open(local_path, 'rb') as f:
                    ftp.storbinary(f'STOR {remote_path}', f)

ftp.quit()
