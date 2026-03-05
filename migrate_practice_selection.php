<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\IeltsWritingMeeting;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Update Parents to be Selection Menus
$parents = [
    101 => 'Practice: Line Chart',
    102 => 'Practice: Bar Chart',
    103 => 'Practice: Pie Chart',
    104 => 'Practice: Table',
    105 => 'Practice: Mixed Charts',
    106 => 'Practice: Flow Chart',
    107 => 'Practice: Mapping',
];

foreach ($parents as $id => $title) {
    IeltsWritingMeeting::updateOrCreate(
        ['meeting_number' => $id],
        [
            'title' => $title,
            'task_type' => 1,
            'prompt' => 'Select a practice test below.',
            'view_type' => 'practice_selection', // CHANGED from 'writing_practice'
            'category' => 'practice',
            'is_active' => true
        ]
    );
    echo "Updated Parent {$id}\n";
}

// 2. Create Children (10 per parent)
foreach ($parents as $parentId => $parentTitle) {
    $baseChildId = $parentId * 10; // e.g., 1010
    
    // Extract type name for prompt customization
    $type = str_replace('Practice: ', '', $parentTitle);

    for ($i = 0; $i < 10; $i++) {
        $childId = $baseChildId + $i;
        $childNum = $i + 1;
        
        IeltsWritingMeeting::updateOrCreate(
            ['meeting_number' => $childId],
            [
                'title' => "{$type} Practice {$childNum}",
                'task_type' => 1,
                'prompt' => "Analyze the {$type} below. Summarize the information by selecting and reporting the main features, and make comparisons where relevant.",
                'view_type' => 'writing_practice',
                'category' => 'practice_item', // Hidden from main menu
                'is_active' => true
            ]
        );
        echo "Created Child {$childId}\n";
    }
}
