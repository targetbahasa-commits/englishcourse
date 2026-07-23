<?php
$retell = require 'config/pte_retell_lecture.php';
$fib = [];

foreach (array_slice($retell, 0, 300) as $index => $item) {
    $transcript = $item['transcript'];
    $words = explode(' ', $transcript);
    
    // find candidates (length >= 5, no punctuation attached if possible, or we just strip punctuation for the answer but keep it in the text)
    $candidates = [];
    foreach ($words as $i => $word) {
        $cleanWord = preg_replace('/[^a-zA-Z]/', '', $word);
        if (strlen($cleanWord) >= 5 && strlen($cleanWord) == strlen($word)) {
            $candidates[] = $i;
        }
    }
    
    // Pick 5 random candidates, or fewer if not enough
    $numBlanks = min(count($candidates), rand(5, 7));
    if ($numBlanks > 0) {
        shuffle($candidates);
        $selectedIndices = array_slice($candidates, 0, $numBlanks);
        sort($selectedIndices); // sort to keep them in order of appearance
        
        $answers = [];
        $textWords = $words;
        foreach ($selectedIndices as $i) {
            $cleanWord = preg_replace('/[^a-zA-Z]/', '', $words[$i]);
            $answers[] = $cleanWord;
            $textWords[$i] = str_replace($cleanWord, '[blank]', $words[$i]);
        }
        
        $fib[] = [
            'transcript' => $transcript,
            'text' => implode(' ', $textWords),
            'answers' => $answers,
            'voice' => $item['voice']
        ];
    } else {
        // Fallback if no valid candidates
        $fib[] = [
            'transcript' => $transcript,
            'text' => $transcript, // Might want a better fallback, but 300 will likely be fine.
            'answers' => [],
            'voice' => $item['voice']
        ];
    }
}

file_put_contents('config/pte_listening_fib.php', "<?php\n\nreturn " . var_export($fib, true) . ";\n");
echo "Done! Generated " . count($fib) . " questions.";
