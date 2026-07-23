<?php
$file = 'resources/views/promo/promo_toolbar.blade.php';
$content = file_get_contents($file);

// Remove all previously injected tooltip divs (the ones we added before)
// Pattern: tooltip div after button text, before </button>
$content = preg_replace(
    '/(Linking Words|Irregular Verbs|Collocations|Idioms|Ideas|Magic Sentence|Collocation Dictionary|Dictionary)\s*<div class="absolute top-full[^"]*"[^>]*>.*?<\/div>\s*<\/div>/s',
    '$1',
    $content
);

// Also remove 'relative group' we added to button classes
$content = str_replace(' relative group', '', $content);

file_put_contents($file, $content);
echo "Cleaned.\n";
