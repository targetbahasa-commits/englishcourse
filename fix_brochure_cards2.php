<?php
$html = file_get_contents('/tmp/pte_and_more.html');

function getBlock($startMarker, $endMarker) {
    global $html;
    $start = strpos($html, $startMarker);
    if ($start === false) return "";
    if ($endMarker) {
        $end = strpos($html, $endMarker, $start);
        if ($end === false) {
            return substr($html, $start);
        }
        return substr($html, $start, $end - $start);
    } else {
        return substr($html, $start);
    }
}

$pte = getBlock('<!-- PTE -->', '<!-- GRAMMAR -->');
$grammar = getBlock('<!-- GRAMMAR -->', '<!-- SPEAKING -->');
$speaking = getBlock('<!-- SPEAKING -->', '<!-- LISTENING -->');
$listening = getBlock('<!-- LISTENING -->', null);

file_put_contents('/tmp/pte.txt', trim($pte));
file_put_contents('/tmp/grammar.txt', trim($grammar));
file_put_contents('/tmp/speaking.txt', trim($speaking));
file_put_contents('/tmp/listening.txt', trim($listening));

echo "Extracted blocks from pte_and_more.";
