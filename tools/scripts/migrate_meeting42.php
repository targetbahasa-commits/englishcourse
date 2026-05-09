<?php

use App\Models\IeltsWritingMeeting;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Define Meeting 42 Data
$meetingData = [
    'task_type' => 1, // Task 1
    'meeting_number' => 41 + 1, // Lesson 9 (Meeting 41 was Lesson 8) -> Meeting 42? 
    // Wait, user said "Lesson 9". Meeting 41 is Lesson 8. So Meeting 42 is Lesson 9.
    // Let's verify if 42 is free.
    // The previous meeting was 41.
    'meeting_number' => 42,
    'title' => 'Lesson 9: Writing General Overview',
    'prompt' => 'Summarize the information by selecting and reporting the main features, and make comparisons where relevant.',
    'view_type' => 'writing_overview',
    'category' => 'practice_item' // Or main item? Usually 'practice_item' or null. Check 41.
    // I ignore category for now or set it null if not in fillable.
    // Based on M41 seed:
    // 'view_type' => 'writing_introduction'
];

// Check existing
$meeting = IeltsWritingMeeting::where('meeting_number', 42)->first();

if ($meeting) {
    echo "Meeting 42 already exists. Updating...\n";
    $meeting->update([
        'title' => $meetingData['title'],
        'view_type' => $meetingData['view_type'],
        'prompt' => $meetingData['prompt']
    ]);
    echo "Meeting 42 updated.\n";
} else {
    echo "Creating Meeting 42...\n";
    IeltsWritingMeeting::create($meetingData);
    echo "Meeting 42 created.\n";
}
