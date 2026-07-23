import os
import ftplib
import re

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

pattern = re.compile(r"^\s*@include\('assignments\.ielts\.writing\.practice_toolbar'.*?\n", re.MULTILINE)

for root, dirs, files in os.walk('resources/views/assignments/pte-academic/'):
    for file in files:
        if file.endswith('.blade.php'):
            path = os.path.join(root, file)
            with open(path, 'r') as f:
                content = f.read()
            
            if 'practice_toolbar' in content:
                new_content = pattern.sub('', content)
                if new_content != content:
                    with open(path, 'w') as f:
                        f.write(new_content)
                    
                    print(f"Uploading {path}...")
                    remote_path = "/domains/targetbahasa.com/public_html/" + path
                    remote_dir = os.path.dirname(remote_path)
                    ensure_dir_exists(ftp, remote_dir)
                    with open(path, 'rb') as f:
                        ftp.storbinary(f'STOR {remote_path}', f)

ftp.quit()
