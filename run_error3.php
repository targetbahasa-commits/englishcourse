<?php
$f = "/home/u822472458/domains/targetbahasa.com/public_html/storage/logs/laravel.log";
if(file_exists($f)) {
    $c = file_get_contents($f);
    $parts = explode("local.ERROR:", $c);
    $lastError = array_pop($parts);
    echo "local.ERROR:" . substr($lastError, 0, 1000);
}
