import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

print("Fetching /domains/targetbahasa.com/public_html/public/build/manifest.json")
try:
    with open('remote_manifest.json', 'wb') as f:
        ftp.retrbinary('RETR /domains/targetbahasa.com/public_html/public/build/manifest.json', f.write)
    with open('remote_manifest.json', 'r') as f:
        print(f.read())
except Exception as e:
    print(e)
    
ftp.quit()
