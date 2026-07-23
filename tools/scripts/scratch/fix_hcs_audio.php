<?php
/**
 * Fix HCS audio references.
 * 
 * Problem: All 300 HCS topics have wrong audio:
 *   - folder: 'kokoro-tts/listening-fill-blanks' (should be 'kokoro-tts')
 *   - filename: 'lfb_topic_X.mp3' (should be 'hcs_X.mp3')
 * 
 * The correct audio files hcs_0.mp3 through hcs_299.mp3 already exist in public/storage/kokoro-tts/.
 */

$configPath = __DIR__ . '/../../../config/pte_highlight_correct_summary.php';
$hcs = require $configPath;

$fixedCount = 0;
foreach ($hcs as $i => &$item) {
    $changed = false;
    
    // Fix folder
    if (($item['folder'] ?? '') !== 'kokoro-tts') {
        $item['folder'] = 'kokoro-tts';
        $changed = true;
    }
    
    // Fix filename: lfb_topic_X.mp3 -> hcs_X.mp3
    $expectedFilename = 'hcs_' . $i . '.mp3';
    if (($item['filename'] ?? '') !== $expectedFilename) {
        $item['filename'] = $expectedFilename;
        $changed = true;
    }
    
    if ($changed) {
        $fixedCount++;
    }
}
unset($item);

// Write back
$export = var_export($hcs, true);
// Clean up var_export output: replace array() with [] for readability
$export = preg_replace('/array\s*\(/', '[', $export);
$export = preg_replace('/\)$/', ']', $export);
$export = preg_replace('/\),/', '],', $export);

file_put_contents($configPath, "<?php\n\nreturn " . $export . ";\n");

echo "Fixed $fixedCount / " . count($hcs) . " HCS topic audio references.\n";
echo "folder: kokoro-tts, filename: hcs_X.mp3\n";
