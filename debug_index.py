import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

with open('index_local.php', 'wb') as f:
    ftp.retrbinary('RETR /domains/targetbahasa.com/public_html/index.php', f.write)

with open('index_local.php', 'r') as f:
    content = f.read()

if "ini_set('display_errors'" not in content:
    content = content.replace("define('LARAVEL_START', microtime(true));", "define('LARAVEL_START', microtime(true));\nini_set('display_errors', 1);\nini_set('display_startup_errors', 1);\nerror_reporting(E_ALL);")

with open('index_local.php', 'w') as f:
    f.write(content)

with open('index_local.php', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/index.php', f)

ftp.quit()
