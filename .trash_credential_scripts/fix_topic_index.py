import os
import ftplib
import re

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

directories = [
    "answer-short-question",
    "highlight-correct-summary",
    "highlight-incorrect-words",
    "listening-fill-blanks",
    "listening-multiple-choice-multiple-answer",
    "listening-multiple-choice-single-answer",
    "summarize-spoken-text",
    "retell-lecture",
    "select-missing-word",
    "write-from-dictation"
]

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)

for directory in directories:
    local_path = f"resources/views/assignments/pte-academic/{directory}/practice.blade.php"
    remote_path = f"/domains/targetbahasa.com/public_html/resources/views/assignments/pte-academic/{directory}/practice.blade.php"
    
    if not os.path.exists(local_path):
        print(f"File not found locally: {local_path}")
        continue
        
    with open(local_path, 'r') as f:
        content = f.read()
        
    new_content = re.sub(r'([\'"]\s*\.\s*)\$topicId(\s*\.\s*[\'"])', r'\1($topicId - 1)\2', content)
    
    if new_content != content:
        print(f"Modifying {local_path}...")
        with open(local_path, 'w') as f:
            f.write(new_content)
            
        with open(local_path, 'rb') as f:
            ftp.storbinary(f"STOR {remote_path}", f)
    else:
        print(f"No changes for {local_path} (maybe already fixed or different format)")

ftp.quit()
