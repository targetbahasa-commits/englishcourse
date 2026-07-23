<?php
$hcs = require 'config/pte_highlight_correct_summary.php';

function getSummary($text) {
    // Replace common abbreviations to avoid bad splitting
    $text = preg_replace('/(Mr|Mrs|Dr|Ms|Prof|St|etc)\./i', '$1<DOT>', $text);
    
    // Split by . ! or ?
    preg_match_all('/[^.!?]+[.!?]*/', $text, $matches);
    $sentences = $matches[0];
    
    $summary = "";
    $wordCount = 0;
    foreach ($sentences as $s) {
        $s = str_replace('<DOT>', '.', $s);
        $summary .= trim($s) . ' ';
        $wordCount += str_word_count($s);
        if ($wordCount >= 20) {
            break;
        }
    }
    $summary = trim($summary);
    if (empty($summary)) {
        return $text;
    }
    return $summary;
}

$summaries = [];
foreach ($hcs as $item) {
    $summaries[] = getSummary($item['transcript']);
}

$fixed = [];
foreach ($hcs as $i => $item) {
    $correct = $summaries[$i];
    
    // Pick 3 random WRONG summaries
    $wrongIndices = [];
    while (count($wrongIndices) < 3) {
        $rand = rand(0, count($hcs) - 1);
        if ($rand !== $i && !in_array($rand, $wrongIndices)) {
            $wrongIndices[] = $rand;
        }
    }
    
    $options = [
        $correct,
        $summaries[$wrongIndices[0]],
        $summaries[$wrongIndices[1]],
        $summaries[$wrongIndices[2]],
    ];
    
    shuffle($options);
    
    $fixed[] = [
        'transcript' => $item['transcript'],
        'options' => $options,
        'correct_answer' => $correct,
        'voice' => $item['voice'] ?? 'af_sky'
    ];
}

file_put_contents('config/pte_highlight_correct_summary.php', "<?php\n\nreturn " . var_export($fixed, true) . ";\n");
echo "Done fixing HCS options!\n";
