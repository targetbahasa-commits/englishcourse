<?php
$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php';
$html = file_get_contents($file);

$startPTE = strpos($html, "@case('pte-academic')");
$endListening = strpos($html, "@default", $startPTE); // stop at @default

if ($startPTE === false || $endListening === false) {
    die("Could not find markers.");
}

$pteHtml = file_get_contents('/tmp/pte_fixed.html');
// Remove the "@case('pte-academic')" string from pte_fixed.html because we will add it manually
$pteHtml = str_replace("@case('pte-academic')", "", $pteHtml);

$grammarHtml = file_get_contents('/tmp/grammar_fixed.html');

$newBlock = "                        @case('pte-academic')\n" . 
            $pteHtml . "\n" .
            "                            @break\n" .
            "                        @case('fast-track-grammar-for-writing')\n" .
            $grammarHtml . "\n" .
            "                            @break\n" .
            "                        ";

$newHtml = substr($html, 0, $startPTE) . $newBlock . substr($html, $endListening);

file_put_contents($file, $newHtml);
echo "Fixed brochure.blade.php successfully.";
