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

target = """        // Play/Pause button click
        playBtn.addEventListener('click', () => {
            if(prepTime > 0) return; // can't click during prep"""

replacement = """        // Play/Pause button click
        playBtn.addEventListener('click', () => {
            if (typeof startTimerBtn !== 'undefined' && startTimerBtn && startTimerBtn.style.display !== 'none') {
                startPrepTimer();
                return;
            }
            if(prepTime > 0) return; // can't click during prep"""

files_to_fix = [
    "resources/views/assignments/pte-academic/listening-select-missing-word/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-multiple-choice-single-answer/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-fill-blanks/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-highlight-correct-summary/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-write-from-dictation/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-highlight-incorrect-words/practice.blade.php",
    "resources/views/assignments/pte-academic/listening-multiple-choice-multiple-answer/practice.blade.php"
]

for local_path in files_to_fix:
    with open(local_path, 'r') as f:
        content = f.read()
    
    if target in content:
        content = content.replace(target, replacement)
        with open(local_path, 'w') as f:
            f.write(content)
            
        print(f"Uploading {local_path}...")
        remote_path = "/domains/targetbahasa.com/public_html/" + local_path
        remote_dir = os.path.dirname(remote_path)
        ensure_dir_exists(ftp, remote_dir)
        with open(local_path, 'rb') as f:
            ftp.storbinary(f'STOR {remote_path}', f)

ftp.quit()
