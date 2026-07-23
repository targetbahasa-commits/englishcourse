<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$users = \App\Models\User::where('name', 'like', '%Dewi%')->get();
foreach ($users as $u) {
    echo "ID: {$u->id}, Name: {$u->name}, Email: {$u->email}\n";
    $en = \App\Models\Enrollment::where('user_id', $u->id)->count();
    $pa = \App\Models\ProgramAccess::where('user_id', $u->id)->count();
    echo "  Enrollments: {$en}, ProgramAccess: {$pa}\n";
}
