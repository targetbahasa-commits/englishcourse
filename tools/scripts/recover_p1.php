<?php
$bladePath = __DIR__ . '/resources/views/assignments/ielts/mockup/reading-test-2.blade.php';
$bladeContent = file_get_contents($bladePath);

$cachePath = __DIR__ . '/storage/framework/views/1083c06a04d8d323c9e96f6e56dcb8e2.php';
$cacheContent = file_get_contents($cachePath);

// Extract Passage 1 Content from Cache
$passageStartMarker = '<div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-[\'Georgia\',serif]"';
$passageEndMarker = '</div>';

$posStart = strpos($cacheContent, $passageStartMarker);
$posEnd = strpos($cacheContent, $passageEndMarker, $posStart);

$cachePassageHtml = substr($cacheContent, $posStart, $posEnd - $posStart + strlen($passageEndMarker));

// In the cache, the Blade variables are output as php tags. Let's fix the image tag.
$cachePassageHtml = str_replace('<?php echo e(asset(\'images/uffington_white_horse.png\')); ?>', '{{ asset(\'images/uffington_white_horse.png\') }}', $cachePassageHtml);


// Extract Q1-8 Content from Cache
$q18StartMarker = '<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–8</strong></p>';
$posStartQ18 = strpos($cacheContent, $q18StartMarker);

// Find the end of this div
$posEndQ18 = strpos($cacheContent, '</div>', strpos($cacheContent, '</table>', $posStartQ18)) + 6;
// Add one more </div> for the parent
$posEndQ18 = strpos($cacheContent, '</div>', $posEndQ18) + 6;


$cacheQ18Html = substr($cacheContent, $posStartQ18, $posEndQ18 - $posStartQ18);

// The cache has PHP loops for Q1-8. We can actually just leave the PHP loop or convert back to Blade.
$cacheQ18Html = preg_replace('/<\?php\s+\$__currentLoopData\s+=\s+(.*?);\s+\$__env->addLoop\(\$__currentLoopData\);\s+foreach\(\$__currentLoopData\s+as\s+\[\$num,\s+\$statement\]\):\s+\$__env->incrementLoopIndices\(\);\s+\$loop\s+=\s+\$__env->getLastLoop\(\);\s+\?>/s', '@foreach($1 as [$num, $statement])', $cacheQ18Html);
$cacheQ18Html = str_replace('<?php echo e($num); ?>', '{{ $num }}', $cacheQ18Html);
$cacheQ18Html = str_replace('<?php echo e($statement); ?>', '{{ $statement }}', $cacheQ18Html);
$cacheQ18Html = str_replace('<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>', '@endforeach', $cacheQ18Html);


// Replace Passage 1 in Blade
$posStartBladePassage = strpos($bladeContent, $passageStartMarker);
$posEndBladePassage = strpos($bladeContent, $passageEndMarker, $posStartBladePassage) + strlen($passageEndMarker);
$bladeContent = substr_replace($bladeContent, $cachePassageHtml, $posStartBladePassage, $posEndBladePassage - $posStartBladePassage);


// Replace Q1-8 in Blade
// Currently in reading-test-2 it has "Questions 1–7" (polar bears)
$q17StartMarker = '<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–7</strong></p>';
$posStartBladeQ18 = strpos($bladeContent, $q17StartMarker);
if ($posStartBladeQ18 === false) {
    // try searching for just <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6"> after the passage
    $posStartBladeQ18 = strpos($bladeContent, '<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">', $posEndBladePassage);
}

// Find the end of this div in blade
$posEndBladeQ18 = strpos($bladeContent, '</div>', strpos($bladeContent, '</table>', $posStartBladeQ18)) + 6;
$posEndBladeQ18 = strpos($bladeContent, '</div>', $posEndBladeQ18) + 6;

$bladeContent = substr_replace($bladeContent, $cacheQ18Html, $posStartBladeQ18, $posEndBladeQ18 - $posStartBladeQ18);

file_put_contents($bladePath, $bladeContent);
echo "Passage 1 and Q1-8 recovered successfully.";

?>
