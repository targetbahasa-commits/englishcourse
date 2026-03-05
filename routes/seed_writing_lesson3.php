<?php

use Illuminate\Support\Facades\Route;
use App\Models\IeltsWritingMeeting;

Route::get('/seed-ielts-writing-lesson3', function () {
    
    $exists = IeltsWritingMeeting::where('task_type', 2)
        ->where('meeting_number', 3)
        ->first();

    if (!$exists) {
        IeltsWritingMeeting::create([
            'task_type' => 2,
            'meeting_number' => 3,
            'title' => 'Lesson 3: Introduction Paragraph',
            'prompt' => 'Cara membuat Introduction Paragraph', // Prompt unused in this view but filling mandatory field
            'view_type' => 'lesson_introduction',
            'category' => 'lesson',
        ]);
        return 'Seeded Lesson 3 successfully!';
    }
    
    return 'Lesson 3 already exists.';
});
