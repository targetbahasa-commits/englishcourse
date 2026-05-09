<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;

echo "--- SEEDING: Task 1 Lesson 1 (Graphical Sentences) ---\n";

IeltsWritingMeeting::updateOrCreate(
    ['meeting_number' => 1, 'task_type' => 1],
    [
        'title' => 'Graphical Sentences',
        'prompt' => 'Introduction to describing graphs and charts.',
        'view_type' => 'graphical_sentences',
        'category' => 'lesson',
    ]
);

echo "Created Meeting 1 for Task 1.\n";
