<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Running post-deploy tasks...</h2>";

try {
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "<b>Running migrations...</b><br>";
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "<pre>" . Illuminate\Support\Facades\Artisan::output() . "</pre>";

    echo "<b>Clearing all caches...</b><br>";
    Illuminate\Support\Facades\Artisan::call('optimize:clear');
    echo "<pre>" . Illuminate\Support\Facades\Artisan::output() . "</pre>";

    echo "<b style='color:green'>Done! All tasks completed.</b>";
} catch (Exception $e) {
    echo "<b style='color:red'>Error: " . $e->getMessage() . "</b>";
}

// Self-delete for security
@unlink(__FILE__);
?>