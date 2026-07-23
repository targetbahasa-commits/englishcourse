<?php

// A simple script to export Laravel PHP configs to JSON for Google Colab TTS generation
// Usage: php export_questions.php <config_name> <output_json_name> <audio_prefix> <folder_name>
// Example: php export_questions.php pte_repeat_sentence repeat_sentence.json rs_topic repeat-sentence

if ($argc < 5) {
    echo "Usage: php export_questions.php <config_name> <output_json_name> <audio_prefix> <folder_name>\n";
    echo "Example: php export_questions.php pte_repeat_sentence repeat_sentence.json rs_topic repeat-sentence\n";
    exit(1);
}

$configName = $argv[1];
$outputJson = $argv[2];
$audioPrefix = $argv[3];
$folderName = $argv[4];

$configPath = __DIR__ . '/config/' . $configName . '.php';

if (!file_exists($configPath)) {
    echo "Config file not found: $configPath\n";
    exit(1);
}

$data = include $configPath;
if (!is_array($data)) {
    echo "Config did not return an array.\n";
    exit(1);
}

// Available Kokoro voices
$voices = ['af_sky', 'am_michael', 'af_bella', 'am_fenrir', 'af_heart'];

$exportData = [];
$index = 1;
foreach ($data as $key => $item) {
    // Determine the text content
    $text = '';
    if (isset($item['content'])) {
        $text = $item['content'];
    } elseif (isset($item['transcript'])) {
        $text = $item['transcript'];
    } elseif (isset($item['prompt'])) {
        $text = $item['prompt'];
    } elseif (is_string($item)) {
        $text = $item;
    }

    if (empty($text)) {
        continue;
    }

    // Determine voice (either reuse if exists, or assign alternating)
    $voice = $item['voice'] ?? $voices[$index % count($voices)];

    $exportData[] = [
        'id' => $key,
        'text' => $text,
        'voice' => $voice,
        'filename' => $audioPrefix . '_' . $key . '.mp3',
        'folder' => $folderName
    ];
    $index++;
}

file_put_contents($outputJson, json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "Successfully exported " . count($exportData) . " topics from config '$configName' into '$outputJson'!\n";
