<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;

echo "--- SEEDING: Task 1 Meeting 33 (Practice) ---\n";

IeltsWritingMeeting::updateOrCreate(
    ['id' => 33], // Force ID 33
    [
        'meeting_number' => 33, // Just to match ID
        'task_type' => 1,
        'title' => 'Graphical Sentences Practice',
        'prompt' => 'Practice describing graphs. Analyze the trends and describe them in one sentence.',
        'view_type' => 'graphical_practice',
        'category' => 'practice',
    ]
);

echo "Created Meeting 33 for Task 1.\n";
