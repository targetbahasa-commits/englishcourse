<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ToeflListeningQuestion;

function usage(): void
{
    echo "Usage:\n";
    echo "  php link_toefl_listening_audio.php <meeting_number> <set_number> <filename>\n";
    echo "  php link_toefl_listening_audio.php <meeting_number> <set_number> <source_file_path>\n\n";
    echo "Examples:\n";
    echo "  php link_toefl_listening_audio.php 3 2 audio_custom.mp3\n";
    echo "  php link_toefl_listening_audio.php 3 2 ~/Downloads/audio_custom.mp3\n";
}

if (($argc >= 2 && in_array($argv[1], ['-h', '--help'], true))) {
    usage();
    exit(0);
}

if ($argc < 4) {
    usage();
    exit(1);
}

$meetingNumber = (int) $argv[1];
$setNumber = (int) $argv[2];
$input = $argv[3];

if ($meetingNumber <= 0 || $setNumber <= 0) {
    fwrite(STDERR, "Meeting number and set number must be positive integers.\n");
    exit(1);
}

$targetRelativeDirectory = "audio/toefl/listening/meeting-{$meetingNumber}/set-{$setNumber}";
$targetDirectory = public_path($targetRelativeDirectory);

if (!is_dir($targetDirectory) && !mkdir($targetDirectory, 0777, true) && !is_dir($targetDirectory)) {
    fwrite(STDERR, "Failed to create target directory: {$targetDirectory}\n");
    exit(1);
}

$expandedInput = str_starts_with($input, '~/') ? rtrim(getenv('HOME') ?: '', '/') . substr($input, 1) : $input;
$sourcePath = $expandedInput;
$copiedFromSource = false;

if (is_file($sourcePath)) {
    $filename = basename($sourcePath);
    $targetPath = $targetDirectory . DIRECTORY_SEPARATOR . $filename;

    if (realpath(dirname($sourcePath)) !== realpath($targetDirectory)) {
        if (!copy($sourcePath, $targetPath)) {
            fwrite(STDERR, "Failed to copy file to target directory: {$targetPath}\n");
            exit(1);
        }
        $copiedFromSource = true;
    }
} else {
    $filename = basename($input);
    $targetPath = $targetDirectory . DIRECTORY_SEPARATOR . $filename;

    if (!is_file($targetPath)) {
        fwrite(STDERR, "Audio file not found in target folder: {$targetPath}\n");
        exit(1);
    }
}

$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$allowedExtensions = ['mp3', 'wav', 'ogg', 'm4a'];

if (!in_array($extension, $allowedExtensions, true)) {
    fwrite(STDERR, "Unsupported audio extension: .{$extension}\n");
    exit(1);
}

$questionCount = ToeflListeningQuestion::where('meeting_number', $meetingNumber)
    ->where('set_number', $setNumber)
    ->count();

if ($questionCount === 0) {
    fwrite(STDERR, "No TOEFL listening questions found for meeting {$meetingNumber}, set {$setNumber}.\n");
    exit(1);
}

$relativeAudioPath = $targetRelativeDirectory . '/' . $filename;

$updatedRows = ToeflListeningQuestion::where('meeting_number', $meetingNumber)
    ->where('set_number', $setNumber)
    ->update(['audio_file' => $relativeAudioPath]);

echo "TOEFL listening audio linked successfully.\n";
echo "- meeting: {$meetingNumber}\n";
echo "- set: {$setNumber}\n";
echo "- audio path: {$relativeAudioPath}\n";
echo "- updated rows: {$updatedRows}\n";
echo "- copied file: " . ($copiedFromSource ? 'yes' : 'no') . "\n";