import ftplib
import os

ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

print("Uploading vendor.zip (26MB)... this might take a minute...")
with open('vendor.zip', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/vendor.zip', f)

unzip_php = b"""<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Move broken vendor
if (file_exists(__DIR__ . '/vendor')) {
    rename(__DIR__ . '/vendor', __DIR__ . '/vendor_' . time());
}

$zip = new ZipArchive;
$res = $zip->open('vendor.zip');
if ($res === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Unzipped cleanly!";
} else {
    echo "Failed to open zip!";
}
"""
with open('unzip2.php', 'wb') as f:
    f.write(unzip_php)

with open('unzip2.php', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/unzip2.php', f)

ftp.quit()
print("Done uploading script!")
