import ftplib
import os

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

print("Uploading vendor.zip...")
with open('vendor.zip', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/vendor.zip', f)

unzip_php = b"""<?php
$zip = new ZipArchive;
$res = $zip->open('vendor.zip');
if ($res === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Unzipped successfully!";
    unlink('vendor.zip');
    unlink(__FILE__);
} else {
    echo "Failed to open zip!";
}
"""
with open('unzip.php', 'wb') as f:
    f.write(unzip_php)

with open('unzip.php', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/unzip.php', f)

ftp.quit()
print("Done uploading!")
