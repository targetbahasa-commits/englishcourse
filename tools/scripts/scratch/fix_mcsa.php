<?php
$mcsa = require 'config/pte_listening_mcsa.php';

function getSentence($text) {
    $text = preg_replace('/(Mr|Mrs|Dr|Ms|Prof|St|etc)\./i', '$1<DOT>', $text);
    preg_match_all('/[^.!?]+[.!?]*/', $text, $matches);
    $sentences = $matches[0];
    
    // Pick the first sentence that is at least 5 words long. If none, just return a fallback.
    foreach ($sentences as $s) {
        $s = str_replace('<DOT>', '.', $s);
        if (str_word_count($s) >= 5) {
            return trim($s);
        }
    }
    // Fallback
    $s = $sentences[0] ?? $text;
    return trim(str_replace('<DOT>', '.', $s));
}

$sentences = [];
foreach ($mcsa as $item) {
    $sentences[] = getSentence($item['transcript']);
}

$fixed = [];
foreach ($mcsa as $i => $item) {
    $correct = $sentences[$i];
    
    $wrongIndices = [];
    while (count($wrongIndices) < 3) {
        $rand = rand(0, count($mcsa) - 1);
        if ($rand !== $i && !in_array($rand, $wrongIndices)) {
            $wrongIndices[] = $rand;
        }
    }
    
    $options = [
        $correct,
        $sentences[$wrongIndices[0]],
        $sentences[$wrongIndices[1]],
        $sentences[$wrongIndices[2]],
    ];
    
    shuffle($options);
    
    $fixed[] = [
        'transcript' => $item['transcript'],
        'question' => 'Which of the following statements best reflects a key point made in the passage?',
        'options' => $options,
        'correct_answer' => $correct,
        'voice' => $item['voice'] ?? 'af_sky'
    ];
}

file_put_contents('config/pte_listening_mcsa.php', "<?php\n\nreturn " . var_export($fixed, true) . ";\n");
echo "Done fixing MCSA options!\n";
