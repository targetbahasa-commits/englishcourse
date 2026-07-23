import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)

for filename in ["web.php", "web_prod.php"]:
    local_path = f"routes/{filename}"
    remote_path = f"/domains/targetbahasa.com/public_html/routes/{filename}"
    with open(local_path, "rb") as f:
        ftp.storbinary(f"STOR {remote_path}", f)
    print(f"Uploaded {filename}")

ftp.quit()
