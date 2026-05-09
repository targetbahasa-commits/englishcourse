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
        'meeting_number' => 101,
        'title' => 'Prac 1: Job Skills vs Knowledge',
        'prompt' => '<div class="space-y-4">
    <p class="font-medium">Some people believe that university education should focus on job skills, while others think it should provide knowledge for its own sake.</p>
    <p>Discuss both these views and give your own opinion.</p>
</div>'
    ],
    [
        'meeting_number' => 102,
        'title' => 'Prac 2: Team vs Individual Sports',
        'prompt' => '<div class="space-y-4">
    <p class="font-medium">Some people think that it is better for children to participate in team sports. Others, however, believe that individual sports are more beneficial.</p>
    <p>Discuss both these views and give your own opinion.</p>
</div>'
    ],
    [
        'meeting_number' => 103,
        'title' => 'Prac 3: Reducing Crime',
        'prompt' => '<div class="space-y-4">
    <p class="font-medium">Some people believe that the best way to reduce crime is to increase the length of prison sentences. Others debate that there are better alternative ways to reduce crime.</p>
    <p>Discuss both these views and give your own opinion.</p>
</div>'
    ],
    [
        'meeting_number' => 104,
        'title' => 'Prac 4: Tech Influence on Kids',
        'prompt' => '<div class="space-y-4">
    <p class="font-medium">Some argue that television and the internet have a negative influence on children, while others believe that they are valuable resources for learning and entertainment.</p>
    <p>Discuss both these views and give your own opinion.</p>
</div>'
    ],
    [
        'meeting_number' => 105,
        'title' => 'Prac 5: City vs Countryside',
        'prompt' => '<div class="space-y-4">
    <p class="font-medium">Some people prefer to live in a big city. Others, however, prefer to live in the countryside.</p>
    <p>Discuss both these views and give your own opinion.</p>
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
