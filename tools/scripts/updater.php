<?php
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
?>