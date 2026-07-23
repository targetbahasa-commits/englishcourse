<?php
$file = 'resources/views/promo/promo_toolbar.blade.php';
$content = file_get_contents($file);

// Remove all remaining tooltip divs with the absolute pattern we added
$content = preg_replace(
    '/<div class="absolute top-full[^>]*>.*?<div class="absolute bottom-full[^>]*><\/div>\s*<\/div>\s*/s',
    '',
    $content
);

file_put_contents($file, $content);
echo "Done. Lines: " . count(explode("\n", $content)) . "\n";
