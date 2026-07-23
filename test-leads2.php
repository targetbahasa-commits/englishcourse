<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('role', 'admin')->first();
$app->make('auth')->login($user);

$request = Illuminate\Http\Request::create('/admin/registration-leads', 'GET');
$response = $kernel->handle($request);

if (isset($response->exception) && $response->exception) {
    echo "Exception:\n";
    echo (string) $response->exception;
} else {
    echo "Status code: " . $response->getStatusCode() . "\n";
}
