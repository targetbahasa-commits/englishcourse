<?php
$filePath = __DIR__ . '/resources/views/assignments/ielts/mockup/reading-test-2.blade.php';
$lines = file($filePath);

$newLines = [];
$skip = false;
$skip2 = false;

foreach ($lines as $i => $line) {
    if (strpos($line, '{{-- Passage 2 --}}') !== false && !strpos($line, 'PASSAGE 2 Questions')) {
        $skip = true;
    }
    if (strpos($line, '{{-- Floating Annotation Toolbar --}}') !== false && $skip) {
        $skip = false;
        // Don't skip the toolbar itself, so we add it and continue
    }
    
    if (strpos($line, '{{-- ── PASSAGE 2 Questions ── --}}') !== false) {
        $skip2 = true;
    }
    // We want to skip all lines from passage 2 questions until the end of the div holding the questions
    // Since we put a submit button right before it, we can just skip down to </div></div><!-- end split screen -->
    // Let's just find the closing tags of the right column. 
    // Line 658 is `            </div>`
    // Line 659 is `        </div>`
    if (strpos($line, '            </div>') === 0 && $skip2) {
        // Here we can stop skipping
        $skip2 = false;
        $newLines[] = $line;
        continue;
    }

    if (!$skip && !$skip2) {
        $newLines[] = $line;
    }
}

file_put_contents($filePath, implode("", $newLines));
echo "Cleanup done.";
?>
