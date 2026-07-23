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

with open('public/test_vocab_web.php', 'rb') as f:
    ftp.storbinary(f"STOR {remote_path}/public/test_vocab_web.php", f)

ftp.quit()
print("Done!")
