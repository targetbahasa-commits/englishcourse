<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
\Auth::login($user);
$hasListening = true; $hasReading = true; $hasWriting = true; $hasSpeaking = true; $isClassEnded = false; $hasFullAccess = true;

$view = view('ielts.writing.index', compact('hasListening', 'hasReading', 'hasWriting', 'hasSpeaking', 'hasFullAccess', 'isClassEnded'))->render();

if (preg_match('/<div class="mt-12 mb-6" x-data="\{ isVocabOpen: false, activeTab: \'A1\' \}">.*?<\/main>/s', $view, $matches)) {
    file_put_contents('public/debug_vocab.html', $matches[0]);
    echo "Saved to public/debug_vocab.html";
} else {
    echo "Not found";
}
