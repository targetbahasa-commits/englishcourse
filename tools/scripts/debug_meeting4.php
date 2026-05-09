<?php
use App\Models\ToeflListeningQuestion;

$meetingNumber = 4;
$questions = ToeflListeningQuestion::where('meeting_number', $meetingNumber)
    ->orderBy('set_number')
    ->orderBy('question_number')
    ->get();

$sets = $questions->pluck('set_number')->unique()->sort()->values()->toArray();

echo "Available Sets for Meeting $meetingNumber: " . implode(', ', $sets) . "\n\n";

foreach ($sets as $set) {
    $count = $questions->where('set_number', $set)->count();
    $firstQ = $questions->where('set_number', $set)->first();
    $lastQ = $questions->where('set_number', $set)->last();
    echo "Set $set: $count questions (No. " . $firstQ->question_number . " - " . $lastQ->question_number . ")\n";
}
