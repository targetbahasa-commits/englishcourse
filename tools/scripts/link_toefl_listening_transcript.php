<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ToeflListeningQuestion;

function usage(): void
{
    echo "Usage:\n";
    echo "  php link_toefl_listening_transcript.php <meeting_number> <set_number> <en|id> <filename>\n";
    echo "  php link_toefl_listening_transcript.php <meeting_number> <set_number> <en|id> <source_file_path>\n\n";
    echo "Examples:\n";
    echo "  php link_toefl_listening_transcript.php 3 2 en transcript-en.srt\n";
    echo "  php link_toefl_listening_transcript.php 3 2 id ~/Downloads/transcript-id.srt\n";
}

function normalizeSrtContent(string $content): string
{
    return str_replace(["\r\n", "\r"], "\n", $content);
}

function srtTimeToSeconds(string $srtTime): float
{
    $srtTime = str_replace(',', '.', $srtTime);

    $ms = 0;
    if (strpos($srtTime, '.') !== false) {
        [$time, $msPart] = explode('.', $srtTime, 2);
        $ms = '0.' . $msPart;
    } else {
        $time = $srtTime;
    }

    $parts = explode(':', $time);
    $count = count($parts);

    $h = 0;
    $m = 0;
    $s = 0;

    if ($count === 3) {
        [$h, $m, $s] = $parts;
    } elseif ($count === 2) {
        [$m, $s] = $parts;
    } else {
        $s = $parts[0];
    }

    return ($h * 3600) + ($m * 60) + $s + (float) $ms;
}

function parseSrtContentForStorage(string $content): string
{
    $content = normalizeSrtContent($content);
    $pattern = '/(\d+)\s+(\d{1,2}:\d{2}:\d{2}[,.]\d{1,3})\s*-->\s*(\d{1,2}:\d{2}:\d{2}[,.]\d{1,3})\s+([\s\S]*?)(?=(?:\n\s*\d+\s+\d{1,2}:\d{2}:\d{2})|$)/';

    $blocks = [];
    $matches = [];

    if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $text = trim(str_replace("\n", ' ', $match[4]));

            if ($text === '') {
                continue;
            }

            $blocks[] = [
                'start' => srtTimeToSeconds($match[2]),
                'end' => srtTimeToSeconds($match[3]),
                'text' => $text,
            ];
        }
    }

    if (empty($blocks)) {
        return empty($matches) ? $content : json_encode($blocks);
    }

    return json_encode($blocks);
}

if (($argc >= 2 && in_array($argv[1], ['-h', '--help'], true))) {
    usage();
    exit(0);
}

if ($argc < 5) {
    usage();
    exit(1);
}

$meetingNumber = (int) $argv[1];
$setNumber = (int) $argv[2];
$language = strtolower($argv[3]);
$input = $argv[4];

if ($meetingNumber <= 0 || $setNumber <= 0) {
    fwrite(STDERR, "Meeting number and set number must be positive integers.\n");
    exit(1);
}

if (!in_array($language, ['en', 'id'], true)) {
    fwrite(STDERR, "Language must be 'en' or 'id'.\n");
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
$targetFilename = 'transcript-' . $language . '.srt';
$targetPath = $targetDirectory . DIRECTORY_SEPARATOR . $targetFilename;
$copiedFromSource = false;

if (is_file($sourcePath)) {
    $sourceExtension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
    if (!in_array($sourceExtension, ['srt', 'txt'], true)) {
        fwrite(STDERR, "Transcript source file must use the .srt or .txt extension.\n");
        exit(1);
    }

    if (realpath($sourcePath) !== realpath($targetPath)) {
        if (!copy($sourcePath, $targetPath)) {
            fwrite(STDERR, "Failed to copy transcript file to target directory: {$targetPath}\n");
            exit(1);
        }
        $copiedFromSource = true;
    }
} else {
    $candidatePath = $targetDirectory . DIRECTORY_SEPARATOR . basename($input);

    if (is_file($candidatePath) && realpath($candidatePath) !== realpath($targetPath)) {
        if (!rename($candidatePath, $targetPath)) {
            fwrite(STDERR, "Failed to rename transcript file to {$targetFilename}.\n");
            exit(1);
        }
    }

    if (!is_file($targetPath)) {
        fwrite(STDERR, "Transcript file not found in target folder: {$targetPath}\n");
        exit(1);
    }
}

$questionCount = ToeflListeningQuestion::where('meeting_number', $meetingNumber)
    ->where('set_number', $setNumber)
    ->count();

if ($questionCount === 0) {
    fwrite(STDERR, "No TOEFL listening questions found for meeting {$meetingNumber}, set {$setNumber}.\n");
    exit(1);
}

$content = file_get_contents($targetPath);
if ($content === false || trim($content) === '') {
    fwrite(STDERR, "Transcript file is empty or unreadable: {$targetPath}\n");
    exit(1);
}

$normalizedContent = normalizeSrtContent($content);
file_put_contents($targetPath, $normalizedContent);

$column = $language === 'en' ? 'transcript_en' : 'transcript_id';
$storedValue = parseSrtContentForStorage($normalizedContent);

$updatedRows = ToeflListeningQuestion::where('meeting_number', $meetingNumber)
    ->where('set_number', $setNumber)
    ->update([$column => $storedValue]);

echo "TOEFL listening transcript linked successfully.\n";
echo "- meeting: {$meetingNumber}\n";
echo "- set: {$setNumber}\n";
echo "- language: {$language}\n";
echo "- transcript file: {$targetRelativeDirectory}/{$targetFilename}\n";
echo "- updated column: {$column}\n";
echo "- updated rows: {$updatedRows}\n";
echo "- copied file: " . ($copiedFromSource ? 'yes' : 'no') . "\n";