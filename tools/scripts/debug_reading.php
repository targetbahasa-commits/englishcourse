<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test the service data
$pkg = App\Services\ToeflReadingPracticeData::package(1);
echo "Package title: " . $pkg['title'] . "\n";
echo "Questions count: " . $pkg['questions_count'] . "\n";
echo "Passages: " . count($pkg['passages']) . "\n\n";

// Test JSON encoding of answer key
$answerKey = collect($pkg['passages'])->flatMap(function($passage) {
    return collect($passage['questions'])->mapWithKeys(function($question) {
        return [(string)$question['number'] => $question['answer']];
    });
})->all();

$json = json_encode($answerKey);
echo "Answer key JSON length: " . strlen($json) . "\n";
echo "JSON valid: " . (json_last_error() === JSON_ERROR_NONE ? 'YES' : 'NO: ' . json_last_error_msg()) . "\n";
echo "Sample: " . substr($json, 0, 80) . "\n\n";

// Check for problematic characters in passage content
foreach ($pkg['passages'] as $i => $passage) {
    $content = $passage['content'];
    echo "Passage " . ($i+1) . " content length: " . strlen($content) . "\n";
    
    // Check for single quotes that might break x-data attribute
    if (strpos($content, "'") !== false) {
        echo "  WARNING: Contains single quotes!\n";
    }
    
    // Check for backticks
    if (strpos($content, '`') !== false) {
        echo "  WARNING: Contains backticks!\n";
    }
}

// Also check the build manifest
echo "\nBuild manifest:\n";
print_r(json_decode(file_get_contents('public/build/manifest.json'), true));
