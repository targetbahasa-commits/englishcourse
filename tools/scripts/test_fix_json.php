<?php

$badJson = '{
  "title": "My Essay",
  "content": "This is a paragraph.
This is a new line that breaks JSON.
It really does."
}';

echo "ORIGINAL (Invalid):\n$badJson\n\n";

// Sanitize: find strings and escape newlines inside them
// Regex explanation: Match a double quote, then any character that is NOT a quote OR an escaped character, then a closing quote.
$fixedJson = preg_replace_callback(
    '/"(?:[^"\\\\]|\\\\.)*"/s', 
    function ($m) {
        // Replace actual newlines with literal \n inside the matched string
        return str_replace(["\r\n", "\n", "\r"], ['\n', '\n', '\r'], $m[0]);
    }, 
    $badJson
);

echo "FIXED:\n$fixedJson\n\n";

$decoded = json_decode($fixedJson, true);
if ($decoded) {
    echo "SUCCESS: " . $decoded['content'] . "\n";
} else {
    echo "FAIL: " . json_last_error_msg() . "\n";
}
