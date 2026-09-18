import os
import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

local_path = "resources/views/assignments/ielts/writing/practice_toolbar.blade.php"
with open(local_path, 'r') as f:
    content = f.read()

target = 'x-show="!showResults"'
replacement = 'x-show="typeof showResults !== \'undefined\' ? !showResults : true"'

if target in content:
    content = content.replace(target, replacement)
    with open(local_path, 'w') as f:
        f.write(content)
    
    # Upload
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
    print(f"Uploading {local_path}...")
    remote_path = "/domains/targetbahasa.com/public_html/" + local_path
    remote_dir = os.path.dirname(remote_path)
    ensure_dir_exists(ftp, remote_dir)
    with open(local_path, 'rb') as f:
        ftp.storbinary(f'STOR {remote_path}', f)
    ftp.quit()
else:
    print("Target not found")
