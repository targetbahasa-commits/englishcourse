import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

print("Listing /domains/targetbahasa.com/public_html/public/build:")
try:
    for f in ftp.nlst('/domains/targetbahasa.com/public_html/public/build'): print(f)
except Exception as e:
    print(e)
    
print("Listing /domains/targetbahasa.com/public_html/public/build/build:")
try:
    for f in ftp.nlst('/domains/targetbahasa.com/public_html/public/build/build'): print(f)
except Exception as e:
    print(e)
    
ftp.quit()
