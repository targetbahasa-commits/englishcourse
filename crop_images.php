<?php
// Function to crop image from top
function cropTop($source, $output, $pixelsToRemove) {
    list($width, $height, $type) = getimagesize($source);
    
    $newHeight = $height - $pixelsToRemove;
    $newImage = imagecreatetruecolor($width, $newHeight);
    
    switch ($type) {
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($source);
            // Maintain transparency
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            break;
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($source);
            break;
        default:
            echo "Unsupported type for $source\n";
            return;
    }
    
    // Copy content starting from y = $pixelsToRemove
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

// Crop Sheep (200px)
cropTop('/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/sheep_cloning_process.png', '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/sheep_cloning_process.png', 200);

// Crop Water (220px - slightly more buffer)
cropTop('/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/water_treatment_process.jpg', '/Applications/MAMP/htdocs/TargetBahasaCourse/public/images/practice/water_treatment_process.jpg', 220);

?>
