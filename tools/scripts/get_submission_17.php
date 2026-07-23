<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sub = \Illuminate\Support\Facades\DB::table('free_test_submissions')->where('id', 17)->first();
echo json_encode(json_decode($sub->ai_raw_json_feedback, true), JSON_PRETTY_PRINT);
