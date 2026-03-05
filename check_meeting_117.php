<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$meeting = App\Models\IeltsWritingMeeting::where('meeting_number', 117)->first();
if ($meeting) {
    echo "View Type: " . $meeting->view_type . PHP_EOL;
} else {
    echo "Meeting 117 not found." . PHP_EOL;
}
