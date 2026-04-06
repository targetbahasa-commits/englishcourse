import ftplib
import os

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

unzip_php = b"""<?php
$zip = new ZipArchive;
$res = $zip->open('public/build.zip');
if ($res === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Unzipped cleanly!";
} else {
    echo "Failed to open zip!";
}
"""
with open('unzip3.php', 'wb') as f:
    f.write(unzip_php)

with open('unzip3.php', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/unzip3.php', f)

ftp.quit()
print("Done uploading script!")
