import ftplib
import re

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

# Fix index.php
try:
    with open('index_local.php', 'wb') as f:
        ftp.retrbinary('RETR /domains/targetbahasa.com/public_html/index.php', f.write)

    with open('index_local.php', 'r') as f:
        content = f.read()

    # If it has "../vendor/", change it to "vendor/"
    content = content.replace("__DIR__.'/../vendor", "__DIR__.'/vendor")
    content = content.replace("__DIR__.'/../bootstrap", "__DIR__.'/bootstrap")

    with open('index_local.php', 'w') as f:
        f.write(content)

    with open('index_local.php', 'rb') as f:
        ftp.storbinary('STOR /domains/targetbahasa.com/public_html/index.php', f)
    print("Fixed index.php")
except Exception as e:
    print("Error fixing index.php:", e)

# Upload the local public/css/landing.css to public_html/css/landing.css
try:
    with open('public/css/landing.css', 'rb') as f:
        ftp.storbinary('STOR /domains/targetbahasa.com/public_html/css/landing.css', f)
    print("Uploaded landing.css")
except Exception as e:
    print("Error uploading css:", e)

ftp.quit()
