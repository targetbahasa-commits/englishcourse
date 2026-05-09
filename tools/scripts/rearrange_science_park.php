<?php
$src = '/Users/macpro2021/.gemini/antigravity/brain/eab6e16b-4f6f-4104-a194-ea6165f1d0e9/science_park_fixed_1769265320687.png';
$dest = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/science_park_rearranged.png';

$data = file_get_contents($src);
if (!$data) die("Failed to read source file");

$im = imagecreatefromstring($data);
if (!$im) die("Failed to create image from string");

$w = imagesx($im);
$h = imagesy($im);

// Source Coordinates (Based on previous analysis)
$src_h = 512;

$map1_x = 20;
$map1_w = 420; 
$key_x = 480;
$key_w = 100;  
$map2_x = 580;
$map2_w = 420; 

// Padding
$pad = 20;

// Target Dimensions
// Row 1: Map1 + Padding + Key
// Row 2: Map2 (aligned left)
$dest_w = $map1_w + $pad + $key_w;
$dest_h = $src_h + $pad + $src_h;

$out = imagecreatetruecolor($dest_w, $dest_h);
// Fill with white background
$white = imagecolorallocate($out, 255, 255, 255);
imagefill($out, 0, 0, $white);

// Copy Map 1 (2008) to Top Left
imagecopy($out, $im, 0, 0, $map1_x, 0, $map1_w, $src_h);

// Copy Key to Top Right (Right of Map 1)
imagecopy($out, $im, $map1_w + $pad, 0, $key_x, 0, $key_w, $src_h);

// Copy Map 2 (Today) to Bottom Left
imagecopy($out, $im, 0, $src_h + $pad, $map2_x, 0, $map2_w, $src_h);

imagepng($out, $dest);
imagedestroy($im);
imagedestroy($out);

echo "Saved rearranged image to $dest\n";
?>
