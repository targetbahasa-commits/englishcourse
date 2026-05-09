import ftplib
import os

print("Connecting to FTP...")
ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

print("Uploading public_audio.zip...")
with open('public_audio.zip', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/public_audio.zip', f)

updater_php = b"""<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Starting audio update...<br>";

// Extract
$zip = new ZipArchive;
$res = $zip->open('public_audio.zip');
if ($res === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Audio extracted successfully.<br>";
} else {
    die("Failed to extract update.zip");
}
@unlink('public_audio.zip');
@unlink(__FILE__);
?>"""

with open('updater_audio.php', 'wb') as f:
    f.write(updater_php)

with open('updater_audio.php', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/updater_audio.php', f)

ftp.quit()
print("FTP steps completed. Now call the updater via curl.")
