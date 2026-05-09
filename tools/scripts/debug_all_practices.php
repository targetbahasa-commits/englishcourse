<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$items = \App\Models\IeltsWritingMeeting::where('category', 'practice_item')->take(5)->get();

echo "Found " . $items->count() . " sample practice items.\n";
foreach ($items as $item) {
    echo "ID: " . $item->id . ", Number: " . $item->meeting_number . ", Title: " . $item->title . "\nPrompt: " . substr($item->prompt, 0, 50) . "...\n";
}
