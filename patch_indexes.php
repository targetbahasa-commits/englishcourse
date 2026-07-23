<?php
$modules = [
    'read-aloud',
    'repeat-sentence',
    'describe-image',
    'retell-lecture',
    'answer-short-question',
    'respond-to-a-situation',
    'summarize-written-text',
    'write-essay'
];

$basePath = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/pte-academic/';

foreach ($modules as $module) {
    $path = $basePath . $module . '/index.blade.php';
    if (!file_exists($path)) {
        echo "File not found: $path\n";
        continue;
    }

    $content = file_get_contents($path);

    // 1. Add data-topic-id to the main card link
    if (strpos($content, 'data-topic-id') === false) {
        $content = preg_replace('/(<a\s+href="[^"]+"\s+class=")(group relative [^"]+)(")/', '$1$2" data-topic-id="{{ $i }}"', $content);
    }

    // 2. Add the pte-badges container inside the card
    if (strpos($content, 'pte-badges') === false) {
        $content = preg_replace('/(<h3[^>]*>.*?<\/h3>)/', "$1\n                        <div class=\"pte-badges flex items-center gap-1.5 flex-wrap mb-2\"></div>", $content);
    }

    // 3. Add the tracker script inclusion at the end of the file before </body>
    if (strpos($content, 'pte-practice-index-tracker') === false) {
        $includeStr = "    @include('components.pte-practice-index-tracker', ['module' => '$module'])";
        $content = preg_replace('/(<\/body>)/', "$includeStr\n$1", $content);
    }

    file_put_contents($path, $content);
    echo "Patched $module/index.blade.php\n";
}
echo "Done.\n";
