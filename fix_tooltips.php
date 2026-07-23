<?php
$file = 'resources/views/promo/promo_toolbar.blade.php';
$content = file_get_contents($file);

// Remove 'invisible' and 'group-hover:visible'
$content = str_replace('opacity-0 invisible group-hover:opacity-100 group-hover:visible', 'opacity-0 group-hover:opacity-100 pointer-events-none', $content);

file_put_contents($file, $content);
echo "Fixed.\n";
