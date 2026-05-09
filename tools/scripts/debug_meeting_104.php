<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$meeting = \App\Models\IeltsWritingMeeting::find(104);
if ($meeting) {
    echo "ID: " . $meeting->id . "\n";
    echo "Title: " . $meeting->title . "\n";
    echo "Meeting Number: " . $meeting->meeting_number . "\n";
    echo "View Type: " . $meeting->view_type . "\n";
    echo "Category: " . $meeting->category . "\n";
} else {
    echo "Meeting 104 not found.\n";
}
