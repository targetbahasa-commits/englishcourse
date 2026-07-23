<?php
$f = "/home/u822472458/domains/targetbahasa.com/public_html/storage/logs/laravel.log";
if(file_exists($f)) {
    $lines = file($f);
    $lastLines = array_slice($lines, -300);
    foreach($lastLines as $line) {
        if (strpos($line, "local.ERROR:") !== false) {
            echo $line;
        }
    }
}
