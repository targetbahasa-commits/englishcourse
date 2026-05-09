import ftplib
import os

print("Connecting to FTP...")
ftp = ftplib.FTP('153.92.9.128')
ftp.login('u822472458', '@Dreamer19')

print("Uploading update.zip...")
with open('update.zip', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/update.zip', f)

updater_php = b"""<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Starting update...<br>";

// Extract
$zip = new ZipArchive;
$res = $zip->open('update.zip');
if ($res === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Files extracted successfully.<br>";
} else {
    die("Failed to extract update.zip");
}

try {
    // Bootstrap Laravel
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    
    // Instead of instantiating Kernel, let's just make it and bootstrap it
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "Running migrations...<br>";
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . Illuminate\Support\Facades\Artisan::output() . "</pre>";
    
    echo "Clearing caches...<br>";
    Illuminate\Support\Facades\Artisan::call('optimize:clear');
    echo "<pre>" . Illuminate\Support\Facades\Artisan::output() . "</pre>";
    
    echo "Update complete!<br>";
} catch (Exception $e) {
    echo "Error during artisan commands: " . $e->getMessage() . "<br>";
}

// Cleanup
@unlink('update.zip');
@unlink(__FILE__);
?>"""

print("Uploading updater.php...")
with open('updater.php', 'wb') as f:
    f.write(updater_php)

with open('updater.php', 'rb') as f:
    ftp.storbinary('STOR /domains/targetbahasa.com/public_html/updater.php', f)

ftp.quit()
print("FTP steps completed. Now call the updater via curl.")
