import ftplib
ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')
with open('hello.php', 'wb') as f:
    f.write(b"<?php echo 'Hello from PHP ' . phpversion();")
with open('hello.php', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/hello.php', f)
ftp.quit()
