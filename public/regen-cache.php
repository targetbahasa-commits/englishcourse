<?php
// Force regenerate bootstrap cache
$basePath = __DIR__ . '/..';

// Delete compiled files
@unlink($basePath . '/bootstrap/cache/packages.php');
@unlink($basePath . '/bootstrap/cache/services.php');
@unlink($basePath . '/bootstrap/cache/config.php');

// Now boot the application to regenerate
require $basePath . '/bootstrap/app.php';

// Trigger optimization to generate new cache
\Illuminate\Support\Facades\Artisan::call('optimize');

echo "Cache regenerated successfully!";
?>
