<?php

use App\Models\IeltsWritingMeeting;
use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$meeting = IeltsWritingMeeting::find(36);
if ($meeting) {
    echo "Found Meeting 36. Current Number: {$meeting->meeting_number}\n";
    $meeting->meeting_number = 3;
    $meeting->title = 'Lesson 3: Labeling and Connecting Trends';
    $meeting->save();
    echo "Updated Meeting 36. New Number: {$meeting->meeting_number}\n";
} else {
    echo "Meeting 36 not found.\n";
}
