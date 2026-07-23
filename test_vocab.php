<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$jsonPath = storage_path('app/vocabularies/ielts_vocabularies.json');
$allVocabs = ['A1' => [], 'A2' => [], 'B1' => [], 'B2' => [], 'C1' => []];
if (file_exists($jsonPath)) {
    $content = file_get_contents($jsonPath);
    echo "File exists, size: " . strlen($content) . "\n";
    $allVocabsRaw = json_decode($content, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON ERROR: " . json_last_error_msg() . "\n";
    } else {
        echo "JSON decoded, keys: " . implode(', ', array_keys($allVocabsRaw)) . "\n";
        foreach ($allVocabsRaw as $level => $words) {
            echo "Level: $level, Type of words: " . gettype($words) . "\n";
            if (isset($allVocabs[$level]) && is_array($words)) {
                $allVocabs[$level] = array_map(function($w) {
                    return ['word' => $w[0] ?? '', 'meaning' => $w[1] ?? '', 'type' => $w[2] ?? ''];
                }, $words);
            }
        }
    }
} else {
    echo "File does not exist\n";
}
echo json_encode(array_map('count', $allVocabs)) . "\n";
