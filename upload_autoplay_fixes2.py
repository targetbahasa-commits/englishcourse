import os
import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

files_to_upload = [
    "resources/views/assignments/pte-academic/listening-select-missing-word/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-multiple-choice-single-answer/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-fill-blanks/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-highlight-correct-summary/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-write-from-dictation/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-highlight-incorrect-words/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-multiple-choice-multiple-answer/practice.blade.php"
]

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

for local_path in files_to_upload:
    print(f"Uploading {local_path}...")
    remote_path = "/domains/targetbahasa.com/public_html/" + local_path
    remote_dir = os.path.dirname(remote_path)
    ensure_dir_exists(ftp, remote_dir)
    with open(local_path, 'rb') as f:
        ftp.storbinary(f'STOR {remote_path}', f)

ftp.quit()
