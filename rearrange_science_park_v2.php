<?php
$src = '/Users/macpro2021/.gemini/antigravity/brain/eab6e16b-4f6f-4104-a194-ea6165f1d0e9/science_park_fixed_1769265320687.png';
$dest = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/science_park_rearranged_v2.png';

$data = file_get_contents($src);
if (!$data) die("Failed to read source file");

$im = imagecreatefromstring($data);
if (!$im) die("Failed to create image from string");

$w = imagesx($im);
$h = imagesy($im);

// Source Coordinates
$src_h = 512;

// Map 1: ~20 to ~440. Let's grab 0 to 450 to be safe.
$map1_x = 0;
$map1_w = 460; 

// Key: The analysis said segment was 487-572 (Width 85).
// But there might be padding or labels. 
// Let's grab the whole space between Map 1 and Map 2.
// Map 2 starts ~580.
// So Key region is ~460 to ~580.
$key_x = 460;
$key_w = 125;  // 585 - 460

// Map 2: ~580 to ~1000.
$map2_x = 585;
$map2_w = 439; // 1024 - 585

// Target Dimensions
// Row 1: Map1 + Key
// Row 2: Map2 (aligned left, below Map 1)
// We want to align Map 2 with Map 1 visually.
// Canvas Width = Map1 W + Key W + Padding
// Canvas Height = Map1 H + Map2 H + Padding

$dest_w = $map1_w + $key_w + 20; 
$dest_h = $src_h + 20 + $src_h;

$out = imagecreatetruecolor($dest_w, $dest_h);
$white = imagecolorallocate($out, 255, 255, 255);
imagefill($out, 0, 0, $white);

// Copy Map 1 (2008) to Top Left
// We might want to trim the left whitespace of Map 1 if it's too much.
// Previous analysis said start 23.
// Let's copy from 10 to 460. Width 450.
imagecopy($out, $im, 0, 0, 10, 0, 450, $src_h);

// Copy Key to Top Right (Right of Map 1)
// Place it slightly offset
imagecopy($out, $im, 450, 0, $key_x, 0, $key_w, $src_h);

// Copy Map 2 (Today) to Bottom Left
// Align with Map 1 start (x=0 relative to dest)
// Map 2 starts at 585.
imagecopy($out, $im, 0, $src_h + 20, $map2_x, 0, $map2_w, $src_h);

imagepng($out, $dest);
imagedestroy($im);
imagedestroy($out);

echo "Saved v2 to $dest\n";
?>
