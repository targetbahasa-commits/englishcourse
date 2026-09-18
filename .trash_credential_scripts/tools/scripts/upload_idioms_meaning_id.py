import ftplib
import os

FTP_HOST = '153.92.9.128'
FTP_USER = 'u822472458'
FTP_PASS = '@Dreamer19'
REMOTE_STORAGE = '/domains/targetbahasa.com/public_html/storage/app'
REMOTE_VIEWS = '/domains/targetbahasa.com/public_html/resources/views'

files_to_upload = [
    ('storage/app/basic_idioms.json', f'{REMOTE_STORAGE}/basic_idioms.json'),
    ('storage/app/intermediate_idioms.json', f'{REMOTE_STORAGE}/intermediate_idioms.json'),
    ('storage/app/advanced_idioms.json', f'{REMOTE_STORAGE}/advanced_idioms.json'),
    ('resources/views/idioms-detail.blade.php', f'{REMOTE_VIEWS}/idioms-detail.blade.php'),
]

print(f"Connecting to FTP: {FTP_HOST}...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.set_pasv(True)
print("Connected!")

for local_path, remote_path in files_to_upload:
    filename = os.path.basename(local_path)
    print(f"Uploading {filename} -> {remote_path} ...")
    with open(local_path, 'rb') as f:
        ftp.storbinary(f'STOR {remote_path}', f)
    print(f"  Done: {filename}")

ftp.quit()
print("\nAll files uploaded! Visit https://targetbahasa.com/idioms-level/basic to verify.")
