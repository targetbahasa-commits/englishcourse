<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$userId = 91; // Or whatever user id
$student = \App\Models\User::find($userId);
if (!$student) {
    // Find any student
    $student = \App\Models\User::where('role', 'student')->first();
}

$controller = app(\App\Http\Controllers\Admin\StudentController::class);
$response = $controller->currentAssignmentJson($student);
echo $response->getContent();
