<?php
// Function to download image and save it locally
function downloadImage($url, $savePath) {
    $ch = curl_init($url);
    $fp = fopen($savePath, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // Add user agent to prevent 403 Forbidden
    array_push($headers, "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    
    $success = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);
    
    if (!$success || $httpCode !== 200) {
        unlink($savePath); // Delete empty file
        return false;
    }
    return true;
}

// User's provided image URL (Google Chat embedded image from the prompt)
// We will use the system tools to screenshot instead, or download it.
