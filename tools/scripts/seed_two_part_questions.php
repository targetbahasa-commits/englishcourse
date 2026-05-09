<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;
use Illuminate\Support\Facades\DB;

echo "--- SEEDING: Multiple / Two-part Questions (121-125) ---\n";

$newTopics = [
    [
        'number' => 121,
        'title' => 'Prac 1: News Sources',
        'prompt' => "Many people today prefer to get news from social media rather than newspapers.\n\nWhy is this the case? Is it a positive or negative development?",
    ],
    [
        'number' => 122,
        'title' => 'Prac 2: Working Abroad',
        'prompt' => "Some people move to other countries to find better job opportunities.\n\nWhat problems can this cause for individuals and for their families?",
    ],
    [
        'number' => 123,
        'title' => 'Prac 3: Competition vs Cooperation',
        'prompt' => "Some parents believe that children should be encouraged to compete, while others think that cooperation is more important.\n\nDiscuss both views and give your own opinion.",
    ],
    [
        'number' => 124,
        'title' => 'Prac 4: Aging Population',
        'prompt' => "In some countries, people are living longer than ever before.\n\nWhat problems does this create for society, and what can be done to reduce its impact?",
    ],
    [
        'number' => 125,
        'title' => 'Prac 5: Financial Education',
        'prompt' => "Many people believe that students should be taught financial management at school.\n\nWhy is this important? How can schools help students learn about money effectively?",
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

// CREATE PARENT MEETING 130
echo "\nCreating Parent Meeting 130...\n";
IeltsWritingMeeting::updateOrCreate(
    ['meeting_number' => 130, 'task_type' => 2],
    [
        'title' => 'Multiple / Two-part Questions',
        'category' => 'practice',
        'view_type' => 'practice_selection', // Custom view to show list
        'prompt' => 'Select a topic to practice.',
    ]
);
echo "Created Meeting 130.\n";

echo "\n--- SUCCESS ---\n";
