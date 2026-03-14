<?php
// Find the table and record for meeting 166
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// List tables
$tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
echo "Tables:\n";
foreach ($tables as $t) {
    echo "  " . $t->name . "\n";
}

// Try finding in various tables
$candidates = ['meetings', 'writing_practices', 'ielts_writings', 'practices', 'items'];
foreach ($candidates as $tbl) {
    try {
        $r = DB::table($tbl)->where('id', 166)->first();
        if ($r) {
            echo "\nFound in '$tbl' (id=166): " . json_encode((array)$r, JSON_PRETTY_PRINT) . "\n";
        }
    } catch (\Exception $e) {
        // table doesn't exist
    }
    try {
        $r = DB::table($tbl)->where('meeting_number', 1125)->first();
        if ($r) {
            echo "\nFound in '$tbl' (meeting_number=1125): " . json_encode((array)$r, JSON_PRETTY_PRINT) . "\n";
        }
    } catch (\Exception $e) {}
}
