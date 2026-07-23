<?php
$f = "/home/u822472458/domains/targetbahasa.com/public_html/storage/logs/laravel.log";
if(file_exists($f)) {
    $lines = file($f);
    foreach($lines as $line) {
        if(strpos($line, "ParseError:") !== false) {
            echo $line;
        }
    }
}
