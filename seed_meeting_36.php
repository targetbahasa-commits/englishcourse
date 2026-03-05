<?php

use App\Models\IeltsWritingMeeting;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$meeting = IeltsWritingMeeting::updateOrCreate(
    ['id' => 36],
    [
        'title' => 'Lesson 3: Labeling and Connecting Trends',
        'prompt' => 'First, label the graph using the words and phrases below. Then describe the changes and connect the trends where relevant.',
        'view_type' => 'labeling_trends',
        'task_type' => 1,
        'meeting_number' => 36,
    ]
);

echo "Meeting 36 created/updated successfully: " . $meeting->title . "\n";
