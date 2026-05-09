<?php

use App\Models\IeltsWritingMeeting;

// Create Lesson 6
IeltsWritingMeeting::updateOrCreate(
    ['meeting_number' => 6, 'task_type' => 1],
    [
        'title' => 'Lesson 6: Comparisons',
        'category' => 'lesson',
        'description' => 'Learn how to use multipliers, -fold structures, and complex comparison grammar.',
        'view_type' => 'comparison_structures', // New view type
        'is_active' => true,
    ]
);

echo "Lesson 6 seeded successfully.\n";
