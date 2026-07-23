<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
\Artisan::call('view:clear');
\Artisan::call('cache:clear');
\Artisan::call('config:clear');
echo "Cleared all caches! Artisan output view: " . \Artisan::output();
