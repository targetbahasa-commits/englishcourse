<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$items = \App\Models\IeltsWritingMeeting::where('category', 'practice_item')
    ->whereBetween('meeting_number', [101, 105])
    ->get();

echo "Found " . $items->count() . " practice items in range 101-105.\n";
foreach ($items as $item) {
    echo "ID: " . $item->id . ", Number: " . $item->meeting_number . ", Title: " . $item->title . "\n";
}
