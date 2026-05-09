<?php
$src = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/science_park.png';
$dest = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/science_park_vertical_stacked.png';
$im = imagecreatefrompng($src);
if (!$im) die("Failed to load");

$w = imagesx($im);
$h = imagesy($im);

// Defined Zones based on analysis
// Map 1: 0 - 442
// Key: 442 - 580
// Map 2: 580 - 1024

$map1_w = 442;
$key_start_x = 442;
$key_end_x = 580;
$map2_start_x = 580;
$map2_w = $w - $map2_start_x;

// Analyze Key Y bounds
$key_min_y = $h;
$key_max_y = 0;
$found_key = false;

for ($y = 0; $y < $h; $y++) {
    for ($x = $key_start_x; $x < $key_end_x; $x++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        if ($r < 250 || $g < 250 || $b < 250) {
            if ($y < $key_min_y) $key_min_y = $y;
            if ($y > $key_max_y) $key_max_y = $y;
            $found_key = true;
        }
    }
}

if (!$found_key) {
    // If no key found, just use 0 height
    $key_h = 0;
    $key_y_crop_start = 0;
} else {
    // Add padding
    $pad = 20;
    $key_min_y = max(0, $key_min_y - $pad);
    $key_max_y = min($h-1, $key_max_y + $pad);
    $key_h = $key_max_y - $key_min_y;
    $key_y_crop_start = $key_min_y;
}

echo "Key Height: $key_h\n";

// Target Canvas
$dest_w = max($map1_w, $map2_w);
$dest_h = $h + $key_h + $h; // Map1 + Key + Map2

// Creating image
$out = imagecreatetruecolor($dest_w, $dest_h);
$white = imagecolorallocate($out, 255, 255, 255);
imagefill($out, 0, 0, $white);

// Copy Map 1
imagecopy($out, $im, ($dest_w - $map1_w)/2, 0, 0, 0, $map1_w, $h);

// Copy Key
if ($key_h > 0) {
    imagecopy($out, $im, ($dest_w - ($key_end_x - $key_start_x))/2, $h, $key_start_x, $key_y_crop_start, ($key_end_x - $key_start_x), $key_h);
}

// Copy Map 2
imagecopy($out, $im, ($dest_w - $map2_w)/2, $h + $key_h, $map2_start_x, 0, $map2_w, $h);

imagepng($out, $dest);
imagedestroy($im);
imagedestroy($out);

echo "Saved stacked image to $dest\n";
?>
