import ftplib
import re

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

try:
    with open('index_local.php', 'wb') as f:
        ftp.retrbinary('RETR /domains/targetbahasa.com/public_html/index.php', f.write)

    with open('index_local.php', 'r') as f:
        content = f.read()

    # Change whatever vendor path it has to use the one inside public_html
    content = re.sub(r"__DIR__\.'/[^']*vendor/autoload\.php'", "__DIR__.'/vendor/autoload.php'", content)
    content = re.sub(r"__DIR__\.'/[^']*bootstrap/app\.php'", "__DIR__.'/bootstrap/app.php'", content)

    with open('index_local.php', 'w') as f:
        f.write(content)

    with open('index_local.php', 'rb') as f:
        ftp.storbinary('STOR /domains/targetbahasa.com/public_html/index.php', f)
    print("Fixed index.php to point to public_html locally")
except Exception as e:
    print("Error:", e)

ftp.quit()
