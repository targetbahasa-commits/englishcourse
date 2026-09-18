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
        continue
        
    with open(local_path, 'r') as f:
        content = f.read()
        
    old_content = content
    
    # 1. Fix ReferenceError: audioPlayInterval is not defined
    content = re.sub(r'^\s*clearInterval\(audioPlayInterval\);\n?', '', content, flags=re.MULTILINE)
    
    # 2. Fix prepTimer overwrite in startPrepTimer
    content = re.sub(
        r'prepTimerEl\.parentElement\.innerHTML\s*=\s*(.*?<span class="teal-text" id="prepTimer">.*?);',
        r'let _pt1 = document.getElementById("prepTimer"); if(_pt1) _pt1.parentElement.innerHTML = \1;',
        content
    )
    
    # 3. Fix prepTimer overwrite in startAudio
    content = re.sub(
        r'document\.getElementById\(\'prepTimer\'\)\.parentElement\.innerHTML\s*=\s*\'Status:\s*<span class="teal-text">Playing Audio</span>\';',
        r'let _pt2 = document.getElementById("prepTimer"); if(_pt2) _pt2.parentElement.innerHTML = \'Status: <span class="teal-text" id="prepTimer">Playing Audio</span>\';',
        content
    )
    
    # 4. Fix prepTimer overwrite in ended event
    content = re.sub(
        r'document\.getElementById\(\'prepTimer\'\)\.parentElement\.innerHTML\s*=\s*\'Status:\s*<span class="teal-text">Audio Completed</span>\';',
        r'let _pt3 = document.getElementById("prepTimer"); if(_pt3) _pt3.parentElement.innerHTML = \'Status: <span class="teal-text" id="prepTimer">Audio Completed</span>\';',
        content
    )

    # 5. Fix prepTimer overwrite in startWriting (for SST)
    content = re.sub(
        r'document\.getElementById\(\'prepTimer\'\)\.parentElement\.innerHTML\s*=\s*\'Status:\s*<span class="teal-text">Writing</span>\s*\|\s*Time Remaining:\s*<span id="writeTimer" class="font-bold">10:00</span>\';',
        r'let _pt4 = document.getElementById("prepTimer"); if(_pt4) _pt4.parentElement.innerHTML = \'Status: <span class="teal-text" id="prepTimer">Writing</span> | Time Remaining: <span id="writeTimer" class="font-bold">10:00</span>\';',
        content
    )
    
    # 6. Any other instances of prepTimerEl.textContent
    content = re.sub(
        r'prepTimerEl\.textContent\s*=',
        r'let _pt5 = document.getElementById("prepTimer"); if(_pt5) _pt5.textContent =',
        content
    )
    
    if content != old_content:
        print(f"Modifying {local_path}...")
        with open(local_path, 'w') as f:
            f.write(content)
            
        with open(local_path, 'rb') as f:
            ftp.storbinary(f"STOR {remote_path}", f)
            
ftp.quit()
print("Done!")
