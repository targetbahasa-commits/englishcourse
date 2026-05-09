<?php

use Illuminate\Support\Facades\DB;

// Fetch Meeting 13 ID
$meeting = DB::table('toefl_reading_meetings')->where('meeting_number', 13)->first();

if (!$meeting) {
    echo "Meeting 13 not found!\n";
    exit(1);
}

$meetingId = $meeting->id;
echo "Found Meeting 13 with ID: {$meetingId}\n";

// Data for Passage 1 (Questions 1-10) - Mammals Feeding Young
// Note: We need to be careful with exact matching vs substring. 
// For this MVP, we will rely on partial or whole word matching in logic, but here we define the target terms.
$keywords = [
    1 => ['keywords' => ['subject', 'passage'], 'matches' => ['mammals', 'feed', 'young', 'nurse', 'offspring', 'care', 'parental']], 
    2 => ['keywords' => ['various', 'animals'], 'matches' => ['mammals', 'marsupials', 'platypuses', 'spiny anteaters', 'placental mammals']], 
    3 => ['keywords' => ['offspring'], 'matches' => ['young', 'calves', 'larvae', 'children']],
    4 => ['keywords' => ['egg-guarding', 'fish'], 'matches' => ['egg-guarding fish']],
    5 => ['keywords' => ['provisioning'], 'matches' => ['supply', 'feed', 'store']], 
    6 => ['keywords' => ['larvae'], 'matches' => ['larvae', 'offspring', 'young']], 
    7 => ['keywords' => ['edge'], 'matches' => ['advantage', 'benefit', 'superiority']],
    8 => ['keywords' => ['feeding'], 'matches' => ['feed', 'nurse', 'provisioning']],
    9 => ['keywords' => ['young', 'animal', 'mature', 'independent'], 'matches' => ['grown', 'adult size', 'independent', 'fend for itself']],
    10 => ['keywords' => ['shielded'], 'matches' => ['protected', 'defended', 'guarded']],
];

foreach ($keywords as $qNum => $data) {
    // Find question by number AND linked to Meeting 13
    $q = DB::table('toefl_reading_questions')
        ->join('toefl_reading_passages', 'toefl_reading_questions.passage_id', '=', 'toefl_reading_passages.id')
        ->where('toefl_reading_passages.meeting_id', $meetingId)
        ->where('toefl_reading_questions.question_number', $qNum)
        ->select('toefl_reading_questions.id')
        ->first();

    if ($q) {
        DB::table('toefl_reading_questions')
            ->where('id', $q->id)
            ->update(['keywords' => json_encode($data)]);
        echo "Updated Q{$qNum}\n";
    } else {
        echo "Q{$qNum} not found\n";
    }
}

echo "Keywords updated for Passage 1.\n";
