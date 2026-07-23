<?php

// A script to automatically pad all pte_*.php configs to exactly 300 items
// by repeating their existing items in a loop.

$configs = [
    "pte_answer_short_question",
    "pte_highlight_correct_summary",
    "pte_highlight_incorrect_words",
    "pte_listening_fib",
    "pte_listening_mcma",
    "pte_listening_mcsa",
    "pte_listening_sst_topics",
    "pte_retell_lecture",
    "pte_select_missing_word",
    "pte_write_from_dictation"
];

foreach ($configs as $name) {
    $path = __DIR__ . "/config/" . $name . ".php";
    if (!file_exists($path)) {
        echo "Config not found: $name.php\n";
        continue;
    }

    $arr = include $path;
    if (!is_array($arr)) {
        echo "Config $name.php is not an array.\n";
        continue;
    }

    $count = count($arr);
    if ($count === 0) {
        echo "Config $name.php is empty, skipping.\n";
        continue;
    }

    if ($count >= 300) {
        echo "Config $name.php already has $count items, skipping.\n";
        continue;
    }

    echo "Padding $name.php from $count to 300 items...\n";

    $padded = [];
    for ($i = 0; $i < 300; $i++) {
        $padded[] = $arr[$i % $count];
    }

    // Export PHP array back to file format
    $content = "<?php\n\nreturn " . var_export($padded, true) . ";\n";
    
    // Fix var_export array syntax to modern PHP [] if possible (optional but cleaner)
    // We can leave it as var_export array format, or convert it. var_export is perfectly valid.
    file_put_contents($path, $content);
}

echo "All specified configs padded to 300 items successfully!\n";
