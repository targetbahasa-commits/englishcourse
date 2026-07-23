<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\PtePracticeResult;

$user = User::first();
if (!$user) {
    echo "No user found\n";
    exit;
}

// Clear old
PtePracticeResult::where('user_id', $user->id)->delete();

// Seed Reading (raw score logic)
PtePracticeResult::create([
    'user_id' => $user->id,
    'module' => 'rfib',
    'topic_id' => 1,
    'score' => 4,
    'max_score' => 5, // 4/5 = 0.8 -> 10 + 0.8 * 80 = 74
]);

// Seed Listening (scaled logic)
PtePracticeResult::create([
    'user_id' => $user->id,
    'module' => 'summarize-spoken-text',
    'topic_id' => 1,
    'score' => 75,
    'max_score' => 90,
]);

// Seed Speaking & Writing
PtePracticeResult::create([
    'user_id' => $user->id,
    'module' => 'write-essay',
    'topic_id' => 1,
    'score' => 60,
    'max_score' => 90,
]);

echo "Seeded for user {$user->id}\n";
