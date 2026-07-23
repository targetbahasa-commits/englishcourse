<?php
$f1 = "/home/u822472458/domains/targetbahasa.com/public_html/vendor/composer/installed.json";
if(file_exists($f1)) {
    $data = json_decode(file_get_contents($f1), true);
    if (isset($data["packages"])) {
        foreach($data["packages"] as $k => $pkg) {
            if ($pkg["name"] === "laravel/pail") {
                unset($data["packages"][$k]);
            }
        }
        $data["packages"] = array_values($data["packages"]);
    }
    file_put_contents($f1, json_encode($data, JSON_PRETTY_PRINT));
}

$f2 = "/home/u822472458/domains/targetbahasa.com/public_html/vendor/composer/installed.php";
if(file_exists($f2)) {
    $c = file_get_contents($f2);
    $c = preg_replace("/'laravel\/pail' =>[^\]]+\]\,\n/s", "", $c);
    file_put_contents($f2, $c);
}
if(file_exists(__DIR__."/../bootstrap/cache/packages.php")) unlink(__DIR__."/../bootstrap/cache/packages.php");
echo "Done fixing composer";
