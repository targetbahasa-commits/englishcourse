import ftplib, os, re

with open('generate_300_all_modules.py', 'r') as f:
    text = f.read()
FTP_HOST = re.search(r'FTP_HOST\s*=\s*[\'"]([^\'"]+)', text).group(1)
FTP_USER = re.search(r'FTP_USER\s*=\s*[\'"]([^\'"]+)', text).group(1)
FTP_PASS = re.search(r'FTP_PASS\s*=\s*[\'"]([^\'"]+)', text).group(1)

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
print(ftp.nlst('/domains/targetbahasa.com/public_html/config'))
ftp.quit()
