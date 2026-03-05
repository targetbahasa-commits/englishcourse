<?php

require 'vendor/autoload.php';

// Mock the Controller part or just copy the data structure extraction logic.
// Simpler: Read the file content and parse the arrays using regex or simple parsing if possible, 
// OR simpler: Instantiate the controller if possible. But it's a Laravel controller, might be hard to instantiate in isolation.
// I will use a simple regex based counter on the file content since I know the structure.

$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/app/Http/Controllers/AssignmentController.php';
$content = file_get_contents($file);

// Function to extract counts
function countItems($content, $mapName) {
    echo "Counting items for $mapName...\n";
    // Find the start of the map
    preg_match('/\$' . $mapName . '\s*=\s*\[/', $content, $matches, PREG_OFFSET_CAPTURE);
    if (empty($matches)) {
        echo "Could not find $mapName\n";
        return;
    }
    
    $startPos = $matches[0][1];
    // Find the end of the map efficiently? 
    // It's a nested array structure.
    
    // Improved regex approach: match key => [ ... ]
    
    $pattern = "/'([a-z-]+)'\s*=>\s*\[(.*?)\](?=\s*,\s*'|\s*];)/s";
    
    // We need to limit the search area to roughly the map size to avoid conflicts, or use a better parser.
    // Let's grab the content starting from $startPos
    $subContent = substr($content, $startPos);
    
    // Match all topics like 'topic' => [ ... ]
    // This regex is tricky with nested arrays.
    
    // Simpler approach:
    // Extract the map content manually by bracket counting.
    $offset = strpos($content, '[', $startPos) + 1;
    $depth = 1;
    $currentKey = '';
    $mapContent = '';
    
    for ($i = $offset; $i < strlen($content); $i++) {
        $char = $content[$i];
        if ($char == '[') $depth++;
        if ($char == ']') $depth--;
        
        if ($depth == 0) {
            $mapContent = substr($content, $startPos, $i - $startPos + 1);
            break;
        }
    }
    
    // Now match topics inside mapContent
    // 'topic' => [ items ]
    
    preg_match_all("/'([a-z0-9-]+)'\s*=>\s*\[(.*?)\](?=\s*,\s*'|\s*\])/s", $mapContent, $matches);
    
    foreach ($matches[1] as $index => $topic) {
        $itemsContent = $matches[2][$index];
        // Count 'phrase' => occurrences
        $count = substr_count($itemsContent, "'phrase' =>");
        // Special case for technology/artificial-intelligence which might have sub-arrays 0, 1, 2, 3
        if ($count < 5 && strpos($itemsContent, '0 => [') !== false) {
             $count = substr_count($itemsContent, "'phrase' =>"); // It still counts all phrases inside
        }
        
        echo "$topic: $count\n";
        if ($count < 10) {
            echo "WARNING: $topic has only $count items (Target: 10)\n";
        }
    }
    echo "\n";
}

countItems($content, 'collocationsMap');
countItems($content, 'idiomsMap');
