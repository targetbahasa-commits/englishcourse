<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/assignments/ielts-academic/speaking/1/meeting/1/evaluation-preview', 'GET', ['b' => 'online']);
$controller = app()->make(\App\Http\Controllers\IeltsSpeakingController::class);
$response = $controller->evaluationPreview($request, 1, 1);
echo "SUCCESS!\n";
