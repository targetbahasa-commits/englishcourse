<?php

use Illuminate\Support\Facades\Route;
use App\Models\IeltsWritingMeeting;

Route::get('/seed-ielts-writing-lesson2', function () {
    
    // Check if it exists to avoid duplicates
    $exists = IeltsWritingMeeting::where('task_type', 2)
        ->where('meeting_number', 2)
        ->first();

    if (!$exists) {
        IeltsWritingMeeting::create([
            'task_type' => 2,
            'meeting_number' => 2,
            'title' => 'Lesson 2: Positive or Negative Development',
            'prompt' => 'In many countries, more and more people are competing for a place at university. Do you think this is a positive or a negative development?',
            'view_type' => 'layout_builder_3body',
            'category' => 'lesson',
        ]);
        return 'Seeded Lesson 2 successfully!';
    }
    
    return 'Lesson 2 already exists.';
});
