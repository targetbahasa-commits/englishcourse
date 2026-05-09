<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\IeltsWritingMeeting;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Add Meeting 43
$meeting = IeltsWritingMeeting::updateOrCreate(
    ['meeting_number' => 43],
    [
        'title' => 'Lesson 10: Writing Body Paragraph',
        'task_type' => 1, // Task 1
        'prompt' => 'Group information logically and describe trends/comparisons in detail.',
        'view_type' => 'writing_body',
        'category' => 'lesson', 
        'is_active' => true
    ]
);

echo "Meeting 43 (Lesson 10) created/updated successfully.\n";
