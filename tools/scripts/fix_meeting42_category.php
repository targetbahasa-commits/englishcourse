<?php

use App\Models\IeltsWritingMeeting;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$meeting = IeltsWritingMeeting::where('meeting_number', 42)->first();

if ($meeting) {
    echo "Current category: " . $meeting->category . "\n";
    $meeting->update(['category' => 'lesson']);
    echo "Updated category to 'lesson'.\n";
} else {
    echo "Meeting 42 not found.\n";
}
