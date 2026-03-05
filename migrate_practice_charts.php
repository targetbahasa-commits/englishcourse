<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\IeltsWritingMeeting;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$practices = [
    [
        'id' => 101,
        'title' => 'Practice: Line Chart',
        'prompt' => 'Summarize the information by selecting and reporting the main features, and make comparisons where relevant.',
        'view_type' => 'writing_practice',
        'category' => 'practice'
    ],
    [
        'id' => 102,
        'title' => 'Practice: Bar Chart',
        'prompt' => 'Summarize the information by selecting and reporting the main features, and make comparisons where relevant.',
        'view_type' => 'writing_practice',
        'category' => 'practice'
    ],
    [
        'id' => 103,
        'title' => 'Practice: Pie Chart',
        'prompt' => 'Summarize the information by selecting and reporting the main features, and make comparisons where relevant.',
        'view_type' => 'writing_practice',
        'category' => 'practice'
    ],
    [
        'id' => 104,
        'title' => 'Practice: Table',
        'prompt' => 'Summarize the information by selecting and reporting the main features, and make comparisons where relevant.',
        'view_type' => 'writing_practice',
        'category' => 'practice'
    ],
    [
        'id' => 105,
        'title' => 'Practice: Mixed Charts',
        'prompt' => 'Summarize the information by selecting and reporting the main features, and make comparisons where relevant.',
        'view_type' => 'writing_practice',
        'category' => 'practice'
    ],
    [
        'id' => 106,
        'title' => 'Practice: Flow Chart',
        'prompt' => 'Summarize the information by selecting and reporting the main features.',
        'view_type' => 'writing_practice',
        'category' => 'practice'
    ],
    [
        'id' => 107,
        'title' => 'Practice: Mapping',
        'prompt' => 'Summarize the information by selecting and reporting the main features, and make comparisons where relevant.',
        'view_type' => 'writing_practice',
        'category' => 'practice'
    ],
];

foreach ($practices as $p) {
    IeltsWritingMeeting::updateOrCreate(
        ['meeting_number' => $p['id']],
        [
            'title' => $p['title'],
            'task_type' => 1,
            'prompt' => $p['prompt'],
            'view_type' => $p['view_type'],
            'category' => $p['category'],
            'is_active' => true
        ]
    );
    echo "Created/Updated {$p['title']}\n";
}
