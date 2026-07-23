<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Auth::login(\App\Models\User::first());

$controller = app(\App\Http\Controllers\AdminPromoTestController::class);
$response = $controller->index();
file_put_contents('/tmp/rendered.html', $response->render());
echo "Rendered successfully.\n";
