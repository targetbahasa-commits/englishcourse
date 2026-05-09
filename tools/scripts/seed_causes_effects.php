<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;
use Illuminate\Support\Facades\DB;

echo "--- SEEDING: Causes, Effects, and Solutions (112-116) ---\n";

$newTopics = [
    [
        'number' => 112,
        'title' => 'Prac 1: Global Warming',
        'prompt' => "Global warming is becoming a serious problem worldwide.\n\nWhat are the causes and effects of this issue, and what measures can be taken to reduce it?",
    ],
    [
        'number' => 113,
        'title' => 'Prac 2: Youth Crime',
        'prompt' => "In many countries, crime rates among young people are increasing.\n\nWhat are the main causes of this, and how can the problem be solved?",
    ],
    [
        'number' => 114,
        'title' => 'Prac 3: Childhood Obesity',
        'prompt' => "Obesity is becoming an increasing problem among children in many countries.\n\nWhat are the reasons for this rise, and what can be done to solve it?",
    ],
    [
        'number' => 115,
        'title' => 'Prac 4: Workplace Stress',
        'prompt' => "Many people suffer from stress-related problems at work.\n\nWhat are the causes of this, and what solutions can you suggest?",
    ],
    [
        'number' => 116,
        'title' => 'Prac 5: Wealth Gap',
        'prompt' => "The gap between rich and poor people is widening in many societies.\n\nWhat problems does this cause, and how can these problems be solved?",
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

// CREATE PARENT MEETING 120
echo "\nCreating Parent Meeting 120...\n";
IeltsWritingMeeting::updateOrCreate(
    ['meeting_number' => 120, 'task_type' => 2],
    [
        'title' => 'Causes, Effects, and Solutions',
        'category' => 'practice',
        'view_type' => 'practice_selection', // Custom view to show list (112-116)
        'prompt' => 'Select a topic to practice.',
    ]
);
echo "Created Meeting 120.\n";

echo "\n--- SUCCESS ---\n";
