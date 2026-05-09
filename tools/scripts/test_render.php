<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$user = \App\Models\User::first();
auth()->login($user);
$controller = app(\App\Http\Controllers\AssignmentController::class);
try {
    $response = $controller->toeflItpMockupPackage(2);
    file_put_contents('test_output.html', $response->render());
    echo 'Rendered successfully.';
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString();
}
