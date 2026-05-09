import ftplib

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

files_to_delete = [
    '/domains/targetbahasa.com/public_html/hello.php',
    '/domains/targetbahasa.com/public_html/test.php',
    '/domains/targetbahasa.com/public_html/c_install.php',
    '/domains/targetbahasa.com/public_html/unzip2.php',
    '/domains/targetbahasa.com/public_html/unzip3.php',
    '/domains/targetbahasa.com/public_html/fix.php',
    '/domains/targetbahasa.com/public_html/public/build.zip',
    '/domains/targetbahasa.com/public_html/public/unzip3.php',
]

for f in files_to_delete:
    try:
        ftp.delete(f)
        print(f"Deleted: {f}")
    except Exception as e:
        print(f"Skip {f}: {e}")

# Also remove debug from index.php
with open('index_local.php', 'wb') as lf:
    ftp.retrbinary('RETR /domains/targetbahasa.com/public_html/index.php', lf.write)

with open('index_local.php', 'r') as lf:
    content = lf.read()

content = content.replace("\nini_set('display_errors', 1);\nini_set('display_startup_errors', 1);\nerror_reporting(E_ALL);", "")

with open('index_local.php', 'w') as lf:
    lf.write(content)

with open('index_local.php', 'rb') as lf:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/index.php', lf)

print("Cleaned up debug index.php")
ftp.quit()
