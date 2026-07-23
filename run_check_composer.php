<?php
$f1 = "/home/u822472458/domains/targetbahasa.com/public_html/vendor/composer/installed.json";
if(file_exists($f1)) {
    echo "installed.json: " . (strpos(file_get_contents($f1), "laravel/pail") !== false ? "YES" : "NO") . "
";
}
$f2 = "/home/u822472458/domains/targetbahasa.com/public_html/vendor/composer/installed.php";
if(file_exists($f2)) {
    echo "installed.php: " . (strpos(file_get_contents($f2), "laravel/pail") !== false ? "YES" : "NO") . "
";
}
if(file_exists(__DIR__."/../bootstrap/cache/packages.php")) {
    echo "packages.php EXISTS
";
    echo "packages.php contains pail: " . (strpos(file_get_contents(__DIR__."/../bootstrap/cache/packages.php"), "laravel/pail") !== false ? "YES" : "NO") . "
";
}
