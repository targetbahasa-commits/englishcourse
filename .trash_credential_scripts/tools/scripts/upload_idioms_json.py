import ftplib
import os

FTP_HOST = '153.92.9.128'
FTP_USER = 'u822472458'
FTP_PASS = '@Dreamer19'
REMOTE_STORAGE = '/domains/targetbahasa.com/public_html/storage/app'

files_to_upload = [
    'storage/app/basic_idioms.json',
    'storage/app/intermediate_idioms.json',
    'storage/app/advanced_idioms.json',
]

print(f"Connecting to FTP: {FTP_HOST}...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.set_pasv(True)
print("Connected!")

for local_path in files_to_upload:
    filename = os.path.basename(local_path)
    remote_path = f"{REMOTE_STORAGE}/{filename}"
    print(f"Uploading {filename} -> {remote_path} ...")
    with open(local_path, 'rb') as f:
        ftp.storbinary(f'STOR {remote_path}', f)
    print(f"  Done: {filename}")

ftp.quit()
print("\nAll idiom JSON files uploaded successfully!")
print("Visit https://targetbahasa.com/idioms-level/basic to verify.")
