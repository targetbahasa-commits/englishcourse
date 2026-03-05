<?php
function cropTop($source, $output, $pixelsToRemove) {
    list($width, $height, $type) = getimagesize($source);
    $newHeight = $height - $pixelsToRemove;
    $newImage = imagecreatetruecolor($width, $newHeight);
    
    switch ($type) {
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($source);
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            break;
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($source);
            break;
    }
    
    imagecopy($newImage, $sourceImage, 0, 0, 0, $pixelsToRemove, $width, $newHeight);
    
    switch ($type) {
        case IMAGETYPE_PNG:
            imagepng($newImage, $output);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $output);
            break;
    }
    
    imagedestroy($sourceImage);
    imagedestroy($newImage);
    echo "Cropped $source\n";
}

cropTop('/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/milk_production.png', '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/milk_production.png', 50);
?>
