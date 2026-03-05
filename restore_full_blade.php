<?php
$bladePath = __DIR__ . '/resources/views/assignments/ielts/mockup/reading-test-2.blade.php';
$cachePath = __DIR__ . '/storage/framework/views/1083c06a04d8d323c9e96f6e56dcb8e2.php';

$content = file_get_contents($cachePath);

// Convert blade echoes
$content = preg_replace('/<\?php\s+echo\s+e\((.*?)\);\s+\?>/s', '{{ $1 }}', $content);

// Remove the Illuminate Foundation Vite
$content = preg_replace('/<\?php\s+echo\s+app\(\'Illuminate\\\\Foundation\\\\Vite\'\).*?\?>/s', '@vite([\'resources/css/app.css\', \'resources/js/app.js\'])', $content);

// Convert foreach loops
$content = preg_replace('/<\?php\s+\$__currentLoopData\s+=\s+(.*?);\s+\$__env->addLoop\(\$__currentLoopData\);\s+foreach\(\$__currentLoopData\s+as\s+(.*?)\):\s+\$__env->incrementLoopIndices\(\);\s+\$loop\s+=\s+\$__env->getLastLoop\(\);\s+\?>/s', '@foreach($1 as $2)', $content);

$content = str_replace('<' . '?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?' . '>', '@endforeach', $content);

// Remove the endpath comment
$content = preg_replace('/<\?php\s+\/\*\*PATH.*?\*\/\s+\?>/s', '', $content);

file_put_contents($bladePath, $content);

echo "Base blade file restored from cache.\n";
?>
