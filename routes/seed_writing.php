<?php
// Seeding script for IELTS Writing Task 2 - Lesson 1 (Layout)
// To be placed in routes/web.php or executed once

use App\Models\IeltsWritingMeeting;

Route::get('/seed-ielts-writing-layout', function () {
    // Check if exists
    $exists = IeltsWritingMeeting::where('task_type', 2)
        ->where('meeting_number', 1)
        ->first();

    if (!$exists) {
        IeltsWritingMeeting::create([
            'task_type' => 2,
            'meeting_number' => 1,
            'title' => 'Essay Structure & Layout',
            'prompt' => 'Topic: Some people believe that social media has a negative impact on society, while others believe it connects people. Discuss both views and give your own opinion.',
            'view_type' => 'layout_builder'
        ]);
        return "Task 2 Lesson 1 (Layout Builder) created successfully!";
    }
    
    // If exists, update it ensuring it's layout builder
    $exists->update(['view_type' => 'layout_builder', 'title' => 'Essay Structure & Layout']);
    return "Task 2 Lesson 1 updated to Layout Builder.";
});
