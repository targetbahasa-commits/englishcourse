<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\IeltsWritingMeeting;

echo "=== RESTORING IELTS WRITING TASK 2 LESSONS ===\n\n";

// Define all Task 2 lessons that should exist
$task2Lessons = [
    [
        'meeting_number' => 1,
        'title' => 'Essay Structure & Layout',
        'prompt' => 'Topic: Some people believe that social media has a negative impact on society, while others believe it connects people. Discuss both views and give your own opinion.',
        'view_type' => 'layout_builder',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 2,
        'title' => 'Positive or Negative Development',
        'prompt' => 'In many countries, more and more people are competing for a place at university. Do you think this is a positive or a negative development?',
        'view_type' => 'layout_builder_3body',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 3,
        'title' => 'Introduction Paragraph',
        'prompt' => 'Learn how to write an effective introduction paragraph for your essay.',
        'view_type' => 'lesson_introduction',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 4,
        'title' => 'Body Paragraph',
        'prompt' => 'Learn how to write effective body paragraphs with supporting details and examples.',
        'view_type' => 'body_paragraph',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 5,
        'title' => 'Conclusion',
        'prompt' => 'Write a conclusion for your essay...',
        'view_type' => 'layout_builder',
        'category' => 'lesson',
    ],
    [
        'meeting_number' => 6,
        'title' => 'Review & Practice: Discuss Both Views',
        'prompt' => '<div class="space-y-4">
    <p class="font-medium">You should spend about 40 minutes on this task.</p>
    
    <p>Write about the following topic:</p>
    
    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-gray-700 italic font-serif">
        "Some people believe that the best way to solve environmental problems is to increase the price of fuel. Others disagree and think that there are better solutions being employed to solve these problems."
        <br><br>
        <strong>Discuss both views and give your own opinion.</strong>
    </div>

    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
    
    <p class="text-sm text-gray-500">Write at least 250 words.</p>
</div>',
        'view_type' => 'practice_view',
        'category' => 'lesson',
    ],
];

// Seed/restore all lessons
$created = 0;
$updated = 0;

foreach ($task2Lessons as $lesson) {
    $existing = IeltsWritingMeeting::where('task_type', 2)
        ->where('meeting_number', $lesson['meeting_number'])
        ->first();
    
    if ($existing && $existing->category === 'lesson') {
        // Already exists as a lesson
        echo "✓ Lesson {$lesson['meeting_number']} already exists: {$lesson['title']}\n";
    } else if ($existing && $existing->category !== 'lesson') {
        // Exists but with a different category - delete and recreate
        IeltsWritingMeeting::where('task_type', 2)
            ->where('meeting_number', $lesson['meeting_number'])
            ->delete();
        
        IeltsWritingMeeting::create(array_merge(['task_type' => 2], $lesson));
        echo "✓ Updated Meeting {$lesson['meeting_number']}: {$lesson['title']} (changed category to 'lesson')\n";
        $updated++;
    } else {
        // Doesn't exist - create it
        IeltsWritingMeeting::create(array_merge(['task_type' => 2], $lesson));
        echo "✓ Created Lesson {$lesson['meeting_number']}: {$lesson['title']}\n";
        $created++;
    }
}

echo "\n=== RESTORATION COMPLETE ===\n";
echo "Created: $created new lessons\n";
echo "Updated: $updated lessons\n";

// Verify
echo "\n=== VERIFICATION ===\n";
$verifyLessons = IeltsWritingMeeting::where('task_type', 2)
    ->where('category', 'lesson')
    ->orderBy('meeting_number')
    ->get();

echo "Total Task 2 Lessons now: " . $verifyLessons->count() . "\n\n";
foreach ($verifyLessons as $lesson) {
    echo "- Lesson {$lesson->meeting_number}: {$lesson->title} ({$lesson->view_type})\n";
}
