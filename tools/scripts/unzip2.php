<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Move broken vendor
if (file_exists(__DIR__ . '/vendor')) {
    rename(__DIR__ . '/vendor', __DIR__ . '/vendor_' . time());
}

$zip = new ZipArchive;
$res = $zip->open('vendor.zip');
if ($res === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Unzipped cleanly!";
} else {
    echo "Failed to open zip!";
}
