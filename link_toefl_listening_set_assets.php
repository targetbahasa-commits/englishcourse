<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ToeflListeningQuestion;

function usage(): void
{
    echo "Usage:\n";
    echo "  php link_toefl_listening_set_assets.php <meeting_number> <set_number> [--audio <file>] [--transcript-en <file>] [--transcript-id <file>]\n\n";
    echo "Examples:\n";
    echo "  php link_toefl_listening_set_assets.php 3 2 --audio ~/Downloads/m3s2.mp3\n";
    echo "  php link_toefl_listening_set_assets.php 3 2 --audio m3s2.mp3 --transcript-en transcript-en.srt\n";
    echo "  php link_toefl_listening_set_assets.php 3 2 --transcript-en ~/Downloads/en.srt --transcript-id ~/Downloads/id.srt\n";
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

function expandHomePath(string $path): string
{
    if (str_starts_with($path, '~/')) {
        return rtrim(getenv('HOME') ?: '', '/') . substr($path, 1);
    }

    return $path;
}

function resolveInputToTarget(string $input, string $targetDirectory, string $targetFilename, array $allowedExtensions): array
{
    $expandedInput = expandHomePath($input);
    $copied = false;
    $targetPath = $targetDirectory . DIRECTORY_SEPARATOR . $targetFilename;

    if (is_file($expandedInput)) {
        $ext = strtolower(pathinfo($expandedInput, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions, true)) {
            throw new RuntimeException('Unsupported file extension: .' . $ext);
        }

        if (realpath($expandedInput) !== realpath($targetPath)) {
            if (!copy($expandedInput, $targetPath)) {
                throw new RuntimeException('Failed to copy file: ' . $expandedInput . ' -> ' . $targetPath);
            }
            $copied = true;
        }

        return [$targetPath, $copied];
    }

    $candidatePath = $targetDirectory . DIRECTORY_SEPARATOR . basename($input);
    if (!is_file($candidatePath)) {
        throw new RuntimeException('File not found: ' . $candidatePath);
    }

    $ext = strtolower(pathinfo($candidatePath, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions, true)) {
        throw new RuntimeException('Unsupported file extension: .' . $ext);
    }

    if (realpath($candidatePath) !== realpath($targetPath)) {
        if (!rename($candidatePath, $targetPath)) {
            throw new RuntimeException('Failed to rename file: ' . $candidatePath . ' -> ' . $targetPath);
        }
    }

    return [$targetPath, $copied];
}

if (($argc >= 2 && in_array($argv[1], ['-h', '--help'], true))) {
    usage();
    exit(0);
}

if ($argc < 3) {
    usage();
    exit(1);
}

$meetingNumber = (int) $argv[1];
$setNumber = (int) $argv[2];

if ($meetingNumber <= 0 || $setNumber <= 0) {
    fwrite(STDERR, "Meeting number and set number must be positive integers.\n");
    exit(1);
}

$audioInput = null;
$transcriptEnInput = null;
$transcriptIdInput = null;

for ($i = 3; $i < $argc; $i++) {
    $token = $argv[$i];
    $next = $argv[$i + 1] ?? null;

    if ($token === '--audio' && $next !== null) {
        $audioInput = $next;
        $i++;
        continue;
    }

    if ($token === '--transcript-en' && $next !== null) {
        $transcriptEnInput = $next;
        $i++;
        continue;
    }

    if ($token === '--transcript-id' && $next !== null) {
        $transcriptIdInput = $next;
        $i++;
        continue;
    }

    fwrite(STDERR, 'Unknown argument: ' . $token . "\n");
    usage();
    exit(1);
}

if ($audioInput === null && $transcriptEnInput === null && $transcriptIdInput === null) {
    fwrite(STDERR, "Provide at least one of --audio, --transcript-en, or --transcript-id.\n\n");
    usage();
    exit(1);
}

$questionCount = ToeflListeningQuestion::where('meeting_number', $meetingNumber)
    ->where('set_number', $setNumber)
    ->count();

if ($questionCount === 0) {
    fwrite(STDERR, "No TOEFL listening questions found for meeting {$meetingNumber}, set {$setNumber}.\n");
    exit(1);
}

$relativeDirectory = "audio/toefl/listening/meeting-{$meetingNumber}/set-{$setNumber}";
$targetDirectory = public_path($relativeDirectory);

if (!is_dir($targetDirectory) && !mkdir($targetDirectory, 0777, true) && !is_dir($targetDirectory)) {
    fwrite(STDERR, "Failed to create target directory: {$targetDirectory}\n");
    exit(1);
}

$updatedColumns = [];
$copies = [];

try {
    if ($audioInput !== null) {
        $audioFilename = basename(expandHomePath($audioInput));
        [$audioPath, $audioCopied] = resolveInputToTarget($audioInput, $targetDirectory, $audioFilename, ['mp3', 'wav', 'ogg', 'm4a']);
        $relativeAudioPath = $relativeDirectory . '/' . basename($audioPath);

        ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->update(['audio_file' => $relativeAudioPath]);

        $updatedColumns['audio_file'] = $relativeAudioPath;
        $copies['audio'] = $audioCopied ? 'yes' : 'no';
    }

    if ($transcriptEnInput !== null) {
        [$transcriptEnPath, $transcriptEnCopied] = resolveInputToTarget($transcriptEnInput, $targetDirectory, 'transcript-en.srt', ['srt', 'txt']);
        $enContent = file_get_contents($transcriptEnPath);
        if ($enContent === false || trim($enContent) === '') {
            throw new RuntimeException('English transcript is empty or unreadable: ' . $transcriptEnPath);
        }

        $normalized = normalizeSrtContent($enContent);
        file_put_contents($transcriptEnPath, $normalized);

        ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->update(['transcript_en' => parseSrtContentForStorage($normalized)]);

        $updatedColumns['transcript_en'] = $relativeDirectory . '/transcript-en.srt';
        $copies['transcript_en'] = $transcriptEnCopied ? 'yes' : 'no';
    }

    if ($transcriptIdInput !== null) {
        [$transcriptIdPath, $transcriptIdCopied] = resolveInputToTarget($transcriptIdInput, $targetDirectory, 'transcript-id.srt', ['srt', 'txt']);
        $idContent = file_get_contents($transcriptIdPath);
        if ($idContent === false || trim($idContent) === '') {
            throw new RuntimeException('Indonesian transcript is empty or unreadable: ' . $transcriptIdPath);
        }

        $normalized = normalizeSrtContent($idContent);
        file_put_contents($transcriptIdPath, $normalized);

        ToeflListeningQuestion::where('meeting_number', $meetingNumber)
            ->where('set_number', $setNumber)
            ->update(['transcript_id' => parseSrtContentForStorage($normalized)]);

        $updatedColumns['transcript_id'] = $relativeDirectory . '/transcript-id.srt';
        $copies['transcript_id'] = $transcriptIdCopied ? 'yes' : 'no';
    }
} catch (Throwable $e) {
    fwrite(STDERR, 'Error: ' . $e->getMessage() . "\n");
    exit(1);
}

echo "TOEFL listening set assets linked successfully.\n";
echo "- meeting: {$meetingNumber}\n";
echo "- set: {$setNumber}\n";
echo "- rows affected target set: {$questionCount}\n";

foreach ($updatedColumns as $column => $value) {
    echo '- ' . $column . ': ' . $value . "\n";
}

foreach ($copies as $key => $value) {
    echo '- copied ' . $key . ': ' . $value . "\n";
}
