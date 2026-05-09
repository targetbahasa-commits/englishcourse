<?php
$src = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/university_sports_centre.png';
$dest = '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/university_sports_centre_clean.png';

$data = file_get_contents($src);
if (!$data) die("Failed to read");
$im = imagecreatefromstring($data);
$w = imagesx($im);
$h = imagesy($im);

// We suspect "Write at least 150 words." is near the top.
// Let's scan the first 100 rows.
// We expect a line of text, then whitespace, then the Map Title "UNIVERSITY SPORTS CENTRE".
// We want to cut *above* the Map Title.

$map_title_y = 0;
// Heuristic: The Map title "UNIVERSITY..." is likely centered or prominent.
// But simpler: Find the first *large* block of non-white content after some whitespace.

// Let's print row density for the first 150 rows.
echo "Row Density Analysis (0-150):\n";
$buffer = 20; // Ignore margins
for ($y = 0; $y < 150; $y++) {
    $dark_pixels = 0;
    for ($x = $buffer; $x < $w - $buffer; $x++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        if ($r < 200 || $g < 200 || $b < 200) {
            $dark_pixels++;
        }
    }
    // Only print meaningful rows
    if ($dark_pixels > 0) {
        // echo "Y: $y, Dark: $dark_pixels\n"; 
    }
}

// Algorithm:
// 1. Scan past the first block of text (if any) - this corresponds to "Write at least...".
// 2. Find a whitespace gap.
// 3. Find the start of the next block (Map Title).
// 4. Cut at the whitespace gap.

$state = 'start'; // start, in_text, in_gap
$cut_y = 0;
$gap_rows = 0;

for ($y = 0; $y < 150; $y++) {
    $row_has_content = false;
    for ($x = 20; $x < $w - 20; $x+=5) {
        $rgb = imagecolorat($im, $x, $y);
        if (($rgb & 0xFF) < 240) { // simplistic check
             $row_has_content = true;
             break;
        }
    }

    if ($row_has_content) {
        if ($state == 'start') {
            $state = 'in_text'; // This is likely "Write..." line
        } else if ($state == 'in_gap') {
            // We hit content after a gap! This must be the Map Title.
            // So we set our cut point here (minus some margin)
            $cut_y = $y - 10;
            break; 
        }
    } else {
        if ($state == 'in_text') {
            $state = 'in_gap';
            $gap_rows++;
        } else if ($state == 'in_gap') {
            $gap_rows++;
        }
    }
}

if ($cut_y > 0) {
    echo "Detected secondary text. content starts at $y. Cutting at $cut_y.\n";
} else {
    // If we didn't find a gap-then-content sequence, maybe it was clean?
    // Or maybe the text is at the very top 0?
    echo "No clear separate header found in top 150px. Force cropping top 50px just in case?\n";
    $cut_y = 0; 
}

// If we cut
if ($cut_y > 0) {
    if ($cut_y < 0) $cut_y = 0;
    $new_h = $h - $cut_y;
    $out = imagecreatetruecolor($w, $new_h);
    // Fill white (optional, but copy handles it)
    $white = imagecolorallocate($out, 255, 255, 255);
    imagefill($out, 0, 0, $white);
    
    imagecopy($out, $im, 0, 0, 0, $cut_y, $w, $new_h);
    imagepng($out, $dest);
    imagedestroy($out);
    echo "Saved clean image to $dest\n";
} else {
    echo "Image seems clean or pattern not matched. No crop performed.\n";
}

imagedestroy($im);
?>
