<?php

// A script to export all 11 PTE Listening & Speaking config files to JSON in one go.
// Run this via CLI: php export_all_pte.php

$configs = [
    [
        'config' => 'pte_listening_mcma',
        'json' => 'PTE/listening_mcma.json',
        'prefix' => 'lmcma_topic',
        'folder' => 'kokoro-tts/listening-mcma'
    ],
    [
        'config' => 'pte_listening_mcsa',
        'json' => 'PTE/listening_mcsa.json',
        'prefix' => 'lmcsa_topic',
        'folder' => 'kokoro-tts/listening-mcsa'
    ],
    [
        'config' => 'pte_listening_fib',
        'json' => 'PTE/listening_fill_blanks.json',
        'prefix' => 'lfb_topic',
        'folder' => 'kokoro-tts/listening-fill-blanks'
    ],
    [
        'config' => 'pte_highlight_correct_summary',
        'json' => 'PTE/highlight_correct_summary.json',
        'prefix' => 'hcs_topic',
        'folder' => 'kokoro-tts/highlight-correct-summary'
    ],
    [
        'config' => 'pte_select_missing_word',
        'json' => 'PTE/select_missing_word.json',
        'prefix' => 'smw_topic',
        'folder' => 'kokoro-tts/select-missing-word'
    ],
    [
        'config' => 'pte_highlight_incorrect_words',
        'json' => 'PTE/highlight_incorrect_words.json',
        'prefix' => 'hiw_topic',
        'folder' => 'kokoro-tts/highlight-incorrect-words'
    ],
    [
        'config' => 'pte_write_from_dictation',
        'json' => 'PTE/write_from_dictation.json',
        'prefix' => 'wfd_topic',
        'folder' => 'kokoro-tts/write-from-dictation'
    ],
    [
        'config' => 'pte_listening_sst_topics',
        'json' => 'PTE/sst_topics.json',
        'prefix' => 'sst_topic',
        'folder' => 'kokoro-tts/summarize-spoken-text'
    ],
    [
        'config' => 'pte_repeat_sentence',
        'json' => 'PTE/repeat_sentence.json',
        'prefix' => 'rs_topic',
        'folder' => 'kokoro-tts/repeat-sentence'
    ],
    [
        'config' => 'pte_answer_short_question',
        'json' => 'PTE/answer_short_question.json',
        'prefix' => 'asq_topic',
        'folder' => 'kokoro-tts/answer-short-question'
    ],
    [
        'config' => 'pte_retell_lecture',
        'json' => 'PTE/retell_lecture.json',
        'prefix' => 'rtl_topic',
        'folder' => 'kokoro-tts/retell-lecture'
    ]
];

// Ensure output directory exists
if (!is_dir(__DIR__ . '/PTE')) {
    mkdir(__DIR__ . '/PTE', 0755, true);
}

$voices = ['af_sky', 'am_michael', 'af_bella', 'am_fenrir', 'af_heart'];

foreach ($configs as $cfg) {
    $configName = $cfg['config'];
    $outputJson = $cfg['json'];
    $audioPrefix = $cfg['prefix'];
    $folderName = $cfg['folder'];

    $configPath = __DIR__ . '/config/' . $configName . '.php';

    if (!file_exists($configPath)) {
        echo "[ERROR] Config file not found: $configPath\n";
        continue;
    }

    $data = include $configPath;
    if (!is_array($data)) {
        echo "[ERROR] Config '$configName' did not return an array.\n";
        continue;
    }

    $exportData = [];
    $index = 1;
    foreach ($data as $key => $item) {
        $text = '';
        if (isset($item['content'])) {
            $text = $item['content'];
        } elseif (isset($item['transcript'])) {
            $text = $item['transcript'];
        } elseif (isset($item['prompt'])) {
            $text = $item['prompt'];
        } elseif (is_string($item)) {
            $text = $item;
        }

        if (empty($text)) {
            continue;
        }

        $voice = $item['voice'] ?? $voices[$index % count($voices)];

        $exportData[] = [
            'id' => $key,
            'text' => $text,
            'voice' => $voice,
            'filename' => $audioPrefix . '_' . $key . '.mp3',
            'folder' => $folderName
        ];
        $index++;
    }

    file_put_contents(__DIR__ . '/' . $outputJson, json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo "Successfully exported " . count($exportData) . " topics from config '$configName' into '$outputJson'!\n";
}

echo "All config files exported to the 'PTE/' directory successfully!\n";
