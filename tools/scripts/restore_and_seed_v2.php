<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;
use Illuminate\Support\Facades\DB;

echo "--- STARTING RESTORATION & SEEDING ---\n";

// 1. RESTORE "Discuss Both Views" (101-105)
echo "Restoring 'Discuss Both Views' items (101-105)...\n";
$restoreTopics = [
    [
        'number' => 101,
        'title' => 'Practice 1: Online vs Traditional Learning',
        'prompt' => 'Some people believe that online learning is more effective than traditional classroom teaching, while others think face-to-face learning is better.<br><br>Discuss both views and give your opinion.'
    ],
    [
        'number' => 102,
        'title' => 'Practice 2: Public Transport vs Roads',
        'prompt' => 'Some people think governments should spend more money on public transportation, while others believe that road infrastructure for cars is more important.<br><br>Discuss both views and give your opinion.'
    ],
    [
        'number' => 103,
        'title' => 'Practice 3: Art vs Science Subjects',
        'prompt' => 'Some believe that art subjects are as important as science in education, while others argue that students should focus only on science and technology.<br><br>Discuss both views and give your opinion.'
    ],
    [
        'number' => 104,
        'title' => 'Practice 4: Advertising Pros & Cons',
        'prompt' => 'Some people say that advertising encourages us to buy unnecessary products, while others believe it provides useful information about new goods.<br><br>Discuss both views and give your opinion.'
    ],
    [
        'number' => 105,
        'title' => 'Practice 5: Countryside vs City Life',
        'prompt' => 'Some people think it is better to live in the countryside, while others believe that city life offers more advantages.<br><br>Discuss both views and give your opinion.'
    ],
];

foreach ($restoreTopics as $p) {
    IeltsWritingMeeting::updateOrCreate(
        ['meeting_number' => $p['number'], 'task_type' => 2],
        [
            'title' => $p['title'],
            'prompt' => '<div class="space-y-4">
    <p class="font-medium">You should spend about 40 minutes on this task.</p>
    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-gray-700 italic font-serif">
        "' . $p['prompt'] . '"
    </div>
    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
    <p class="text-sm text-gray-500">Write at least 250 words.</p>
</div>',
            'view_type' => 'layout_builder',
            'category' => 'practice_item',
        ]
    );
    echo "Restored {$p['number']}: {$p['title']}\n";
}


// 2. SEED "Adv/Disadv" (106-110)
echo "\nSeeding 'Advantage/Disadvantage' items (106-110)...\n";
$newTopics = [
    [
        'number' => 106,
        'title' => 'Prac 1: Work from Home',
        'prompt' => "More and more people are choosing to work from home.\n\nDo the advantages of this development outweigh the disadvantages?",
    ],
    [
        'number' => 107,
        'title' => 'Prac 2: Online Shopping',
        'prompt' => "Some people prefer shopping online rather than going to physical stores.\n\nWhat are the advantages and disadvantages of this trend?",
    ],
    [
        'number' => 108,
        'title' => 'Prac 3: Study Abroad',
        'prompt' => "Many students now choose to study abroad.\n\nWhat are the benefits and drawbacks of studying in another country?",
    ],
    [
        'number' => 109,
        'title' => 'Prac 4: Social Media',
        'prompt' => "The use of social media has increased dramatically in recent years.\n\nWhat are the advantages and disadvantages of this development?",
    ],
    [
        'number' => 110,
        'title' => 'Prac 5: Casual Dress Code',
        'prompt' => "Many companies allow employees to dress casually at work.\n\nDo the advantages outweigh the disadvantages?",
    ],
];

foreach ($newTopics as $topic) {
    IeltsWritingMeeting::updateOrCreate(
        ['meeting_number' => $topic['number'], 'task_type' => 2],
        [
            'title' => $topic['title'],
            'prompt' => '<div class="space-y-4">
    <p class="font-medium">You should spend about 40 minutes on this task.</p>
    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-gray-700 italic font-serif">
        "' . nl2br($topic['prompt']) . '"
    </div>
    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
    <p class="text-sm text-gray-500">Write at least 250 words.</p>
</div>',
            'view_type' => 'layout_builder',
            'category' => 'practice_item',
        ]
    );
    echo "Created {$topic['number']}: {$topic['title']}\n";
}

// 3. CREATE PARENT MEETING 111
echo "\nCreating Parent Meeting 111 (Adv/Disadv)...\n";
IeltsWritingMeeting::updateOrCreate(
    ['meeting_number' => 111, 'task_type' => 2],
    [
        'title' => 'Advantages & Disadvantages',
        'category' => 'practice',       // Shows in main list
        'view_type' => 'practice_selection', // Custom view to show list (106-110)
        'prompt' => 'Select a topic to practice.',
    ]
);
echo "Created Meeting 111.\n";

echo "\n--- OPERATION COMPLETE ---\n";
