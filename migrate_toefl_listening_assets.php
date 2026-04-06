<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ToeflListeningQuestion;
use Illuminate\Support\Facades\DB;

function ensureDirectory(string $path): void
{
    if (!is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
        throw new RuntimeException('Failed to create directory: ' . $path);
    }
}

function moveSetDirectory(string $sourceDir, string $targetDir, array &$summary): void
{
    ensureDirectory(dirname($targetDir));

    if (!file_exists($targetDir) && rename($sourceDir, $targetDir)) {
        $summary['moved_set_directories']++;
        return;
    }

    ensureDirectory($targetDir);

    $items = scandir($sourceDir);
    if ($items === false) {
        throw new RuntimeException('Failed to read directory: ' . $sourceDir);
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $sourcePath = $sourceDir . DIRECTORY_SEPARATOR . $item;
        $targetName = $item === 'transcript.srt' ? 'transcript-en.srt' : $item;
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $targetName;

        if (is_dir($sourcePath)) {
            moveSetDirectory($sourcePath, $targetPath, $summary);
            continue;
        }

        if (file_exists($targetPath)) {
            unlink($sourcePath);
            $summary['skipped_existing_files']++;
            continue;
        }

        if (!rename($sourcePath, $targetPath)) {
            throw new RuntimeException('Failed to move file: ' . $sourcePath . ' -> ' . $targetPath);
        }

        $summary['moved_files']++;
        if ($item === 'transcript.srt') {
            $summary['renamed_transcripts']++;
        }
    }

    $remaining = scandir($sourceDir);
    if ($remaining !== false && count(array_diff($remaining, ['.', '..'])) === 0) {
        rmdir($sourceDir);
    }

    $summary['merged_set_directories']++;
}

function removeEmptyDirectories(string $path): void
{
    if (!is_dir($path)) {
        return;
    }

    $items = scandir($path);
    if ($items === false) {
        return;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $childPath = $path . DIRECTORY_SEPARATOR . $item;
        if (is_dir($childPath)) {
            removeEmptyDirectories($childPath);
        }
    }

    $items = scandir($path);
    if ($items !== false && count(array_diff($items, ['.', '..'])) === 0) {
        rmdir($path);
    }
}

$legacyRoot = public_path('audio/toefl-listening');
$newRoot = public_path('audio/toefl/listening');

$summary = [
    'moved_set_directories' => 0,
    'merged_set_directories' => 0,
    'moved_files' => 0,
    'skipped_existing_files' => 0,
    'renamed_transcripts' => 0,
    'updated_db_rows' => 0,
];

echo "Migrating TOEFL listening assets...\n";
echo 'Legacy root: ' . $legacyRoot . "\n";
echo 'New root:    ' . $newRoot . "\n\n";

ensureDirectory($newRoot);

if (is_dir($legacyRoot)) {
    $legacyMeetingDirs = glob($legacyRoot . '/meeting-*');

    if ($legacyMeetingDirs !== false) {
        foreach ($legacyMeetingDirs as $legacyMeetingDir) {
            if (!is_dir($legacyMeetingDir)) {
                continue;
            }

            $targetMeetingDir = $newRoot . '/' . basename($legacyMeetingDir);
            ensureDirectory($targetMeetingDir);

            $legacySetDirs = glob($legacyMeetingDir . '/set-*');
            if ($legacySetDirs === false) {
                continue;
            }

            foreach ($legacySetDirs as $legacySetDir) {
                if (!is_dir($legacySetDir)) {
                    continue;
                }

                $targetSetDir = $targetMeetingDir . '/' . basename($legacySetDir);
                moveSetDirectory($legacySetDir, $targetSetDir, $summary);
            }
        }
    }

    removeEmptyDirectories($legacyRoot);
}

$summary['updated_db_rows'] = ToeflListeningQuestion::where('audio_file', 'like', 'audio/toefl-listening/%')
    ->update([
        'audio_file' => DB::raw("REPLACE(audio_file, 'audio/toefl-listening/', 'audio/toefl/listening/')"),
    ]);

echo "Summary:\n";
echo '- moved set directories: ' . $summary['moved_set_directories'] . "\n";
echo '- merged set directories: ' . $summary['merged_set_directories'] . "\n";
echo '- moved files: ' . $summary['moved_files'] . "\n";
echo '- skipped existing files: ' . $summary['skipped_existing_files'] . "\n";
echo '- renamed transcript files: ' . $summary['renamed_transcripts'] . "\n";
echo '- updated DB rows: ' . $summary['updated_db_rows'] . "\n";

echo "\nDone.\n";