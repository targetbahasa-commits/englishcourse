<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = 115;
echo "Checking Meeting ID $id:\n";

$meeting = \App\Models\IeltsWritingMeeting::find($id);

if ($meeting) {
    echo "Found ID $id:\n";
    echo "Number: " . $meeting->meeting_number . "\n";
    echo "Title: " . $meeting->title . "\n";
    echo "View Type: " . $meeting->view_type . "\n";
    echo "Category: " . $meeting->category . "\n";
    echo "Task Type: " . $meeting->task_type . "\n"; // Added check
    echo "Prompt Length: " . strlen($meeting->prompt) . "\n";
    echo "Prompt Content Sample:\n" . substr($meeting->prompt, 0, 500) . "...\n";
    
    // Check if "Body Paragraph 1" exists in prompt
    if (strpos($meeting->prompt, 'Body Paragraph 1') !== false) {
        echo "MATCH: 'Body Paragraph 1' found in prompt.\n";
    } else {
        echo "NO MATCH: 'Body Paragraph 1' NOT found in prompt.\n";
    }

    // Check if "Topic Sentence" exists in prompt
    if (strpos($meeting->prompt, 'Topic Sentence') !== false) {
        echo "MATCH: 'Topic Sentence' found in prompt.\n";
    } else {
        echo "NO MATCH: 'Topic Sentence' NOT found in prompt.\n";
    }

} else {
    echo "Meeting ID $id not found.\n";
}
