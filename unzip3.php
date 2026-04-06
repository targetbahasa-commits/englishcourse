<?php
$zip = new ZipArchive;
$res = $zip->open('public/build.zip');
if ($res === TRUE) {
    $zip->extractTo(__DIR__);
    $zip->close();
    echo "Unzipped cleanly!";
} else {
    echo "Failed to open zip!";
}
