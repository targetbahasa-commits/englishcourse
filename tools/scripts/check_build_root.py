import ftplib
ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')
try:
    for f in ftp.nlst('/domains/targetbahasa.com/public_html/build'): print(f)
except Exception as e:
    print(e)
ftp.quit()
