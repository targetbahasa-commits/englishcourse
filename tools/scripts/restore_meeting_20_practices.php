<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;

$topics = [
    [
        'meeting_number' => 106,
        'title' => 'Prac 1: Online Shopping',
        'prompt' => '<div class="space-y-4">
    <p class="font-medium">Online shopping is increasing dramatically. What are the advantages and disadvantages of this trend?</p>
    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
</div>'
    ],
    [
        'meeting_number' => 107,
        'title' => 'Prac 2: Tourism Growth',
        'prompt' => '<div class="space-y-4">
    <p class="font-medium">International tourism has become a huge industry. improved transport has made it easier for people to travel abroad. What are the advantages and disadvantages of this trend?</p>
    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
</div>'
    ],
];

foreach ($topics as $topic) {
    // Check if exists to avoid duplicates
    $exists = IeltsWritingMeeting::where('meeting_number', $topic['meeting_number'])
        ->where('category', 'practice_item')
        ->exists();

    if (!$exists) {
        IeltsWritingMeeting::create([
            'meeting_number' => $topic['meeting_number'],
            'title' => $topic['title'],
            'prompt' => $topic['prompt'],
            'view_type' => 'practice_view',
            'category' => 'practice_item',
            'task_type' => 2 // Task 2
        ]);
        echo "Created: " . $topic['title'] . "\n";
    } else {
        echo "Skipped (Exists): " . $topic['title'] . "\n";
    }
}
