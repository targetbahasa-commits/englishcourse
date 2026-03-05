<?php

use App\Models\IeltsWritingMeeting;

$meeting = IeltsWritingMeeting::updateOrCreate(
    ['meeting_number' => 7, 'task_type' => 1, 'category' => 'lesson'],
    [
        'title' => 'Lesson 7: Reducing',
        'view_type' => 'reducing_clauses',
        'prompt' => 'Learn how to reduce clauses to participle phrases (verb-ing) for concise writing.',
        'objectives' => '["Understand relative clauses", "Convert clauses to participle phrases", "Practice concise sentence structures"]',
    ]
);

echo "Lesson 7 seeded: ID " . $meeting->id . "\n";
