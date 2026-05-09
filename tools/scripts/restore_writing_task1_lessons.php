<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;

echo "=== RESTORING IELTS WRITING TASK 1 LESSONS ===\n\n";

// Define all Task 1 lessons that should exist
$task1Lessons = [
    [
        'meeting_number' => 1,
        'title' => 'Graphical Sentences',
        'prompt' => 'Introduction to describing graphs and charts.',
        'view_type' => 'graphical_sentences',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 2,
        'title' => 'Connecting Trends',
        'prompt' => 'Learn how to connect and compare trends in your writing.',
        'view_type' => 'connecting_trend',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 3,
        'title' => 'Labeling Trends',
        'prompt' => 'First, label the graph using the words and phrases. Then describe the changes and connect the trends where relevant.',
        'view_type' => 'labeling_trends',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 4,
        'title' => 'Parts of Paragraph',
        'prompt' => 'Understand the structure and components of a well-written paragraph.',
        'view_type' => 'parts_of_paragraph',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 5,
        'title' => 'Body Paragraph',
        'prompt' => 'Learn how to write effective body paragraphs with supporting details.',
        'view_type' => 'body_paragraph',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 6,
        'title' => 'Comparison Structures',
        'prompt' => 'Learn how to use multipliers, -fold structures, and complex comparison grammar.',
        'view_type' => 'comparison_structures',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 7,
        'title' => 'Reducing Clauses',
        'prompt' => 'Learn how to reduce clauses to participle phrases (verb-ing) for concise writing.',
        'view_type' => 'reducing_clauses',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 8,
        'title' => 'Using Prepositions',
        'prompt' => 'Master prepositions for describing location, time, and movement in graphs.',
        'view_type' => 'using_prepositions',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 9,
        'title' => 'Introduction',
        'prompt' => 'Learn how to write an effective introduction paragraph for your response.',
        'view_type' => 'introduction',
        'category' => 'lesson',
    ],
];

// Seed/restore all lessons
$created = 0;
$updated = 0;

foreach ($task1Lessons as $lesson) {
    $existing = IeltsWritingMeeting::where('task_type', 1)
        ->where('meeting_number', $lesson['meeting_number'])
        ->first();
    
    if ($existing && $existing->category === 'lesson') {
        // Already exists as a lesson
        echo "✓ Lesson {$lesson['meeting_number']} already exists: {$lesson['title']}\n";
    } else if ($existing && $existing->category !== 'lesson') {
        // Exists but with a different category - delete and recreate
        IeltsWritingMeeting::where('task_type', 1)
            ->where('meeting_number', $lesson['meeting_number'])
            ->delete();
        
        IeltsWritingMeeting::create(array_merge(['task_type' => 1], $lesson));
        echo "✓ Updated Meeting {$lesson['meeting_number']}: {$lesson['title']} (changed category to 'lesson')\n";
        $updated++;
    } else {
        // Doesn't exist - create it
        IeltsWritingMeeting::create(array_merge(['task_type' => 1], $lesson));
        echo "✓ Created Lesson {$lesson['meeting_number']}: {$lesson['title']}\n";
        $created++;
    }
}

echo "\n=== RESTORATION COMPLETE ===\n";
echo "Created: $created new lessons\n";
echo "Updated: $updated lessons\n";

// Verify
echo "\n=== VERIFICATION ===\n";
$verifyLessons = IeltsWritingMeeting::where('task_type', 1)
    ->where('category', 'lesson')
    ->orderBy('meeting_number')
    ->get();

echo "Total Task 1 Lessons now: " . $verifyLessons->count() . "\n\n";
foreach ($verifyLessons as $lesson) {
    echo "- Lesson {$lesson->meeting_number}: {$lesson->title} ({$lesson->view_type})\n";
}
