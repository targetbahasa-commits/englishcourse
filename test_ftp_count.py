import ftplib

FTP_HOST = "153.92.9.128"
FTP_USER = "u822472458"
FTP_PASS = "@Dreamer19"
REMOTE_AUDIO = "/domains/targetbahasa.com/public_html/public/storage/kokoro-tts/listening-fill-blanks"

ftp = ftplib.FTP(FTP_HOST)
ftp.login(user=FTP_USER, passwd=FTP_PASS)
files = ftp.nlst(REMOTE_AUDIO)
print(f"Total files on server in {REMOTE_AUDIO}: {len(files)}")
ftp.quit()
