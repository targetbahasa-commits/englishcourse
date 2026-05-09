<?php
$src = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/university_sports_centre.png';
$dest = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/university_sports_centre_cropped.png';

$data = file_get_contents($src);
if (!$data) die("Failed to read");
$im = imagecreatefromstring($data);
$w = imagesx($im);
$h = imagesy($im);

// Scan rows from top to find where content starts after the text block.
// The text block is dense.
// We are looking for a significant whitespace gap or the specific "UNIVERSITY SPORTS CENTRE" header.
// Let's print row density.

// Heuristic:
// The text block is at the top.
// Then there is "Write at least 150 words."
// Then a gap.
// Then "UNIVERSITY SPORTS CENTRE (present)"

// Let's look for a gap of > 10 white lines after line 100?
$start_search = 100;
$gap_threshold = 20; // number of consecutive white lines
$consecutive_white = 0;
$cut_y = 0;

for ($y = $start_search; $y < $h / 2; $y++) {
    $is_white = true;
    for ($x = 20; $x < $w - 20; $x+=10) { // Sample points
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        if ($r < 240 || $g < 240 || $b < 240) {
            $is_white = false;
            break;
        }
    }
    
    if ($is_white) {
        $consecutive_white++;
    } else {
        if ($consecutive_white > $gap_threshold) {
            // We found a gap, and now we hit content again.
            // This Y is safe to cut *above*.
            // We want to cut at the *bottom* of the whitespace, or close to the new content.
            $cut_y = $y - 5; // Give a little margin above the content
            break;
        }
        $consecutive_white = 0;
    }
}

if ($cut_y == 0) {
    // Fallback: Just crop top 250px
    $cut_y = 250;
    echo "Heuristic detection failed, using fallback 250px.\n";
} else {
    echo "Detected cut point at Y: $cut_y\n";
}

$new_h = $h - $cut_y;
$out = imagecreatetruecolor($w, $new_h);
imagecopy($out, $im, 0, 0, 0, $cut_y, $w, $new_h);

imagepng($out, $dest);
imagedestroy($im);
imagedestroy($out);
echo "Saved cropped image to $dest\n";
?>
