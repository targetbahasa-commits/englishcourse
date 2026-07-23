<?php
$mcsa = require 'config/pte_listening_mcsa.php';

$newGenerics = [
    "Identify the statement below that gives the most accurate statement of the central idea of this passage.",
    "Which of the following statements is best related with the opinion expressed by the speaker?",
    "What is the main idea conveyed in this audio?"
];

foreach ($mcsa as $i => &$item) {
    // Inject the new questions randomly for ~20% of the generic questions to add more variety
    if (rand(1, 100) <= 20) {
        $item['question'] = $newGenerics[array_rand($newGenerics)];
    }
}
unset($item);

file_put_contents('config/pte_listening_mcsa.php', "<?php\n\nreturn " . var_export($mcsa, true) . ";\n");
echo "Added more generic questions!\n";
