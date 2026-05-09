<?php
$src = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/science_park.png';
$im = imagecreatefrompng($src);
if (!$im) die("Failed to load");
$w = imagesx($im);
$h = imagesy($im);

$column_density = [];
$white_threshold = 0xFFFFFF; // Pure white

// Sample middle 50% of height to avoid title interference if any
$start_y = $h * 0.25;
$end_y = $h * 0.75;

for ($x = 0; $x < $w; $x++) {
    $non_white = 0;
    for ($y = $start_y; $y < $end_y; $y++) {
        $rgb = imagecolorat($im, $x, $y);
        // Check difference from white just to be safe (compression artifacts)
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        if ($r < 250 || $g < 250 || $b < 250) {
            $non_white++;
        }
    }
    $column_density[$x] = $non_white;
}

// Find gaps
$in_content = false;
$segments = [];
$current_segment = ['start' => 0, 'end' => 0, 'mass' => 0];

for ($x = 0; $x < $w; $x++) {
    $is_content = $column_density[$x] > ($end_y - $start_y) * 0.05; // > 5% non-white
    
    if ($is_content) {
        if (!$in_content) {
            $in_content = true;
            $current_segment['start'] = $x;
            $current_segment['mass'] = 0;
        }
        $current_segment['mass'] += $column_density[$x];
        $current_segment['end'] = $x;
    } else {
        if ($in_content) {
            $in_content = false;
            // Only keep significant segments
            if ($current_segment['mass'] > 100) {
                 $segments[] = $current_segment;
            }
        }
    }
}
// Capture last segment
if ($in_content && $current_segment['mass'] > 100) {
    $segments[] = $current_segment;
}

echo "Detected Segments:\n";
foreach ($segments as $i => $s) {
    echo "Segment $i: Start {$s['start']}, End {$s['end']}, Width " . ($s['end'] - $s['start']) . "\n";
}

?>
