<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Starting boot...<br>";

try {
    require __DIR__.'/../laravel_app/vendor/autoload.php';
    echo "Autoload loaded!<br>";
    $app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';
    echo "App loaded!<br>";
    $app->handleRequest(Illuminate\Http\Request::capture());
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage();
} catch (\Error $e) {
    echo "Fatal Error: " . $e->getMessage();
}
