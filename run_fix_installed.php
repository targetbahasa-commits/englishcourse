<?php
$f2 = "/home/u822472458/domains/targetbahasa.com/public_html/vendor/composer/installed.php";
if(file_exists($f2)) {
    $data = require $f2;
    if (isset($data['versions']['laravel/pail'])) {
        unset($data['versions']['laravel/pail']);
    }
    $c = "<?php return " . var_export($data, true) . ";";
    file_put_contents($f2, $c);
}
if(file_exists(__DIR__."/../bootstrap/cache/packages.php")) unlink(__DIR__."/../bootstrap/cache/packages.php");
if(file_exists(__DIR__."/../bootstrap/cache/services.php")) unlink(__DIR__."/../bootstrap/cache/services.php");
echo "Done replacing installed.php";
