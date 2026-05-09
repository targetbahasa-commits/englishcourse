<?php
$zip = new ZipArchive;
$res = $zip->open('build.zip');
if ($res === TRUE) {
    $zip->extractTo(__DIR__ . '/build');
    $zip->close();
    echo "Unzipped cleanly!";
} else {
    echo "Failed to open zip!";
}
