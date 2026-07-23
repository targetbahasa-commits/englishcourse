import ftplib, os, re

with open('generate_300_all_modules.py', 'r') as f:
    text = f.read()
FTP_HOST = re.search(r'FTP_HOST\s*=\s*[\'"]([^\'"]+)', text).group(1)
FTP_USER = re.search(r'FTP_USER\s*=\s*[\'"]([^\'"]+)', text).group(1)
FTP_PASS = re.search(r'FTP_PASS\s*=\s*[\'"]([^\'"]+)', text).group(1)

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
remote_dir = '/domains/targetbahasa.com/public_html/public/storage/kokoro-tts'
try:
    files = ftp.nlst(remote_dir)
    deleted = 0
    for file in files:
        if file.endswith('.mp3'):
            ftp.delete(file)
            deleted += 1
    print(f"Deleted {deleted} mp3 files from {remote_dir}")
except Exception as e:
    print(e)
ftp.quit()
