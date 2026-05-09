<?php
define('LARAVEL_START', microtime(true));
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (file_exists($maintenance = __DIR__.'/../laravel_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../laravel_app/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);
