import os
import ftplib
import re

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

files_to_fix = []
for root, dirs, files in os.walk('resources/views/assignments/pte-academic/'):
    for file in files:
        if file.endswith('.blade.php'):
            path = os.path.join(root, file)
            with open(path, 'r') as f:
                content = f.read()
            if "Status: <span class=\"teal-text\">Waiting to Start</span>" in content:
                files_to_fix.append(path)

target = """            let prepTimer = document.getElementById('prepTimer');
            if (prepTimer && prepTimer.parentElement) {
                prepTimer.parentElement.innerHTML = 'Status: <span class="teal-text">Waiting to Start</span>';
            }"""

replacement = """            let prepTimer = document.getElementById('prepTimer');
            if (prepTimer) {
                prepTimer.textContent = 'Waiting to Start';
                // Don't overwrite parentElement.innerHTML so the span isn't destroyed
            }"""

target_sst = """            let prepTimer = document.getElementById('prepTimer');
            if (prepTimer) {
                prepTimer.parentElement.innerHTML = 'Status: <span class="teal-text">Waiting to Start</span>';
            }"""

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

for local_path in files_to_fix:
    with open(local_path, 'r') as f:
        content = f.read()
    
    if target in content:
        content = content.replace(target, replacement)
    elif target_sst in content:
        content = content.replace(target_sst, replacement)
    
    with open(local_path, 'w') as f:
        f.write(content)
        
    print(f"Uploading {local_path}...")
    remote_path = "/domains/targetbahasa.com/public_html/" + local_path
    remote_dir = os.path.dirname(remote_path)
    ensure_dir_exists(ftp, remote_dir)
    with open(local_path, 'rb') as f:
        ftp.storbinary(f'STOR {remote_path}', f)

ftp.quit()
