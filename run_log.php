<?php
$logFile = "/home/u822472458/domains/targetbahasa.com/public_html/storage/logs/laravel.log";
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -150);
    $content = implode("", $lastLines);
    echo $content;
} else {
    echo "Log file not found.";
}
