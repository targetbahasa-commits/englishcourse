<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;

echo "Seeding Practice Topics (101-105)...\n";

$topics = [
    [
        'meeting_number' => 101,
        'title' => 'Adv/Disadv: Work from Home',
        'prompt' => "More and more people are choosing to work from home.\n\nDo the advantages of this development outweigh the disadvantages?",
    ],
    [
        'meeting_number' => 102,
        'title' => 'Adv/Disadv: Online Shopping',
        'prompt' => "Some people prefer shopping online rather than going to physical stores.\n\nWhat are the advantages and disadvantages of this trend?",
    ],
    [
        'meeting_number' => 103,
        'title' => 'Adv/Disadv: Study Abroad',
        'prompt' => "Many students now choose to study abroad.\n\nWhat are the benefits and drawbacks of studying in another country?",
    ],
    [
        'meeting_number' => 104,
        'title' => 'Adv/Disadv: Social Media',
        'prompt' => "The use of social media has increased dramatically in recent years.\n\nWhat are the advantages and disadvantages of this development?",
    ],
    [
        'meeting_number' => 105,
        'title' => 'Adv/Disadv: Casual Dress Code',
        'prompt' => "Many companies allow employees to dress casually at work.\n\nDo the advantages outweigh the disadvantages?",
    ],
];

foreach ($topics as $topic) {
    IeltsWritingMeeting::updateOrCreate(
        [
            'meeting_number' => $topic['meeting_number'],
            'task_type' => 2, // Writing Task 2
        ],
        [
            'title' => $topic['title'],
            'prompt' => $topic['prompt'],
            'view_type' => 'layout_builder',
            'category' => 'practice_item',
        ]
    );
    echo "Updated/Created Meeting {$topic['meeting_number']}: {$topic['title']}\n";
}

echo "Seeding Complete.\n";
