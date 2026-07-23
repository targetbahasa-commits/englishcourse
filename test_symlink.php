<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$target = __DIR__ . '/storage/app/public/kokoro-tts';
$link = __DIR__ . '/public/storage/kokoro-tts';

if (!file_exists($link)) {
    if (function_exists('symlink')) {
        if (symlink($target, $link)) {
            echo "Symlink created successfully!";
        } else {
            echo "Failed to create symlink.";
        }
    } else {
        echo "symlink() function is disabled!";
    }
} else {
    echo "Symlink or directory already exists.";
}
