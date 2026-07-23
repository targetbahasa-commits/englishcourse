<?php
$cached = file_get_contents('/Applications/MAMP/htdocs/TargetBahasaCourse/storage/framework/views/153baf25476538324381cfcce861de15.php');

function getBlock($startMarker, $endMarker) {
    global $cached;
    $start = strpos($cached, $startMarker);
    if ($start === false) return "";
    if ($endMarker) {
        $end = strpos($cached, $endMarker, $start);
        return substr($cached, $start, $end - $start);
    } else {
        $end = strpos($cached, '</section>', $start);
        $block = substr($cached, $start, $end - $start);
        $endDiv = strrpos($block, '</div>');
        // Find 10th </div> from end approx. We just need to stop before the section ends.
        return substr($block, 0, strrpos($block, '</div>', -10) + 6);
    }
}

$pte = getBlock('<!-- PTE -->', '<!-- GRAMMAR -->');
$grammar = getBlock('<!-- GRAMMAR -->', '<!-- SPEAKING -->');
$speaking = getBlock('<!-- SPEAKING -->', '<!-- LISTENING -->');
$listening = getBlock('<!-- LISTENING -->', null);

// Clean up php tags
function clean($str) {
    $str = preg_replace('/<\?php echo e\((.*?)\); \?>/', '{{ $1 }}', $str);
    return trim($str);
}

$pte = clean($pte);
$grammar = clean($grammar);
$speaking = clean($speaking);
$listening = clean($listening);

file_put_contents('/tmp/pte.txt', $pte);
file_put_contents('/tmp/grammar.txt', $grammar);
file_put_contents('/tmp/speaking.txt', $speaking);
file_put_contents('/tmp/listening.txt', $listening);

echo "Extracted blocks.";
