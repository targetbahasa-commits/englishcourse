import os
import ftplib
import re

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

objective_dirs = [
    # Listening
    "answer-short-question",
    "highlight-correct-summary",
    "highlight-incorrect-words",
    "listening-fill-blanks",
    "listening-multiple-choice-multiple-answer",
    "listening-multiple-choice-single-answer",
    "select-missing-word",
    "write-from-dictation",
    # Reading
    "reading-fill-blanks",
    "reading-multiple-choice-multiple-answer",
    "reading-multiple-choice-single-answer",
    "reading-reorder-paragraphs",
    "rw-fill-blanks"
]

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)

removed_count = 0

for directory in objective_dirs:
    local_path = f"resources/views/assignments/pte-academic/{directory}/practice.blade.php"
    remote_path = f"/domains/targetbahasa.com/public_html/resources/views/assignments/pte-academic/{directory}/practice.blade.php"
    
    if not os.path.exists(local_path):
        print(f"Skipping {local_path}, does not exist.")
        continue
        
    with open(local_path, 'r') as f:
        content = f.read()
        
    old_content = content
    
    # Regex to remove the Practice with AI Scoring button.
    # We look for <button id="practiceBtn" ...>Practice with AI Scoring</button>
    content = re.sub(
        r'<button\s+id="practiceBtn"[\s\S]*?Practice with AI Scoring\s*</button>',
        '',
        content
    )
    
    if content != old_content:
        print(f"Removed button from {local_path}...")
        with open(local_path, 'w') as f:
            f.write(content)
            
        with open(local_path, 'rb') as f:
            ftp.storbinary(f"STOR {remote_path}", f)
        removed_count += 1

ftp.quit()
print(f"Done! Modified {removed_count} files.")
