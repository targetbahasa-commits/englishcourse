<?php
$src = '/Users/macpro2021/.gemini/antigravity/brain/eab6e16b-4f6f-4104-a194-ea6165f1d0e9/science_park_fixed_1769265320687.png';
$dest = '/Users/macpro2021/.gemini/antigravity/brain/eab6e16b-4f6f-4104-a194-ea6165f1d0e9/science_park_cropped.png';

if (!file_exists($src)) {
    die("Source file not found: $src");
}

$data = file_get_contents($src);
$im = imagecreatefromstring($data);
if (!$im) {
    die("Failed to create image from string");
}

$width = imagesx($im);
$height = imagesy($im);
$new_height = $height / 2;

echo "Original size: $width x $height\n";
echo "Cropping to: $width x $new_height\n";

$cropped = imagecreatetruecolor($width, $new_height);
imagealphablending($cropped, false);
imagesavealpha($cropped, true);

imagecopy($cropped, $im, 0, 0, 0, 0, $width, $new_height);

if (imagepng($cropped, $dest)) {
    echo "Successfully saved to $dest";
} else {
    echo "Failed to save image";
}

imagedestroy($im);
imagedestroy($cropped);
?>
