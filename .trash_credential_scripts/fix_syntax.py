import os
import ftplib
import re

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

directories = [
    "listening-fill-blanks",
    "listening-multiple-choice-multiple-answer",
    "listening-multiple-choice-single-answer",
    "summarize-spoken-text"
]

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)

for directory in directories:
    local_path = f"resources/views/assignments/pte-academic/{directory}/practice.blade.php"
    remote_path = f"/domains/targetbahasa.com/public_html/resources/views/assignments/pte-academic/{directory}/practice.blade.php"
    
    if not os.path.exists(local_path):
        continue
        
    with open(local_path, 'r') as f:
        content = f.read()
        
    old_content = content
    
    content = content.replace(r"\'Status:", "'Status:")
    content = content.replace(r"Audio</span>\';", "Audio</span>';")
    content = content.replace(r"Completed</span>\';", "Completed</span>';")
    content = content.replace(r"10:00</span>\';", "10:00</span>';")
    
    if content != old_content:
        print(f"Modifying {local_path}...")
        with open(local_path, 'w') as f:
            f.write(content)
            
        with open(local_path, 'rb') as f:
            ftp.storbinary(f"STOR {remote_path}", f)

ftp.quit()
print("Done!")
