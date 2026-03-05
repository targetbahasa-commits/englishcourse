<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$meeting = \App\Models\IeltsWritingMeeting::find(107); // Checking ID 107 directly, usually IDs align with meeting_number logic but let's see.
// Wait, meeting_number 107 maps to range [1070, 1079]. The meeting with ID 107 is not necessarily meeting_number 107.
// Let's find the meeting with meeting_number 107.

$parent = \App\Models\IeltsWritingMeeting::where('meeting_number', 107)->first();
if ($parent) {
    echo "Parent Found:\n";
    echo "ID: " . $parent->id . "\n";
    echo "Title: " . $parent->title . "\n";
    echo "View Type: " . $parent->view_type . "\n";
} else {
    echo "Parent with meeting_number 107 not found.\n";
}

// Also check ID 104 again to be sure.
echo "\nTarget Meeting 104:\n";
$m104 = \App\Models\IeltsWritingMeeting::find(104);
echo "ID: " . $m104->id . "\n";
echo "Meeting Number: " . $m104->meeting_number . "\n";
