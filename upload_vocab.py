import ftplib
import os

host = "153.92.9.128"
username = "u822472458"
password = "@Dreamer19"
remote_path = "/domains/targetbahasa.com/public_html"

ftp = ftplib.FTP()
ftp.connect(host, 21)
ftp.login(username, password)
ftp.set_pasv(True)

def ensure_dir(ftp, dir_path):
    parts = dir_path.split('/')
    for i in range(1, len(parts) + 1):
        path = '/'.join(parts[:i])
        try:
            ftp.cwd(path)
            ftp.cwd('/')
        except ftplib.error_perm:
            try:
                ftp.mkd(path)
            except ftplib.error_perm:
                pass

file = "storage/app/vocabularies/ielts_vocabularies.json"
remote_file_path = f"{remote_path}/{file}"
remote_dir = os.path.dirname(remote_file_path)

ensure_dir(ftp, remote_dir)
print(f"Uploading {file} to {remote_file_path}")
with open(file, 'rb') as f:
    ftp.storbinary(f"STOR {remote_file_path}", f)

ftp.quit()
print("Done!")
