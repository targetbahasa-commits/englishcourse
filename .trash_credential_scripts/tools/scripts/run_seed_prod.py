import ftplib
import urllib.request

FTP_HOST = '153.92.9.128'
FTP_USER = 'u822472458'
FTP_PASS = '@Dreamer19'
REMOTE_BASE = '/domains/targetbahasa.com/public_html'

ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.set_pasv(True)

print("Uploading fix_structure_seed.php...")
with open('fix_structure_seed.php', 'rb') as f:
    ftp.storbinary(f'STOR {REMOTE_BASE}/fix_structure_seed.php', f)

ftp.quit()
print("Upload done. Executing...")

url = 'https://targetbahasa.com/fix_structure_seed.php'
try:
    response = urllib.request.urlopen(url)
    print("Response:")
    print(response.read().decode('utf-8'))
except Exception as e:
    print("Error:", e)
