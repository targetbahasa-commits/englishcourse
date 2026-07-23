<?php

$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/online-test/packages/toefl-itp/paket1/reading.blade.php';
$content = file_get_contents($file);

$phpCode = <<<'PHP'
    @php
        $packageNumber = (int) ($test['package_number'] ?? 1);
        $packageContentResolver = app(\App\Application\ToeflMockup\ResolveMockupPackageContent::class);
        $readingResolution = $packageContentResolver->resolveReadingPassages($packageNumber);
        $readingPassagesData = $readingResolution['passages'];
        $readingPassages = collect($readingPassagesData)
            ->map(fn ($passage) => \App\Application\ToeflMockup\ViewData\ReadingPassageViewData::fromModel($passage)->toArray())
            ->values()
            ->all();
        
        $readingQuestions = collect($readingPassages)->flatMap(function ($passage) {
            return $passage['questions'] ?? [];
        })->values()->all();

        $dbAnswerKey = [];
        foreach ($readingQuestions as $q) {
            $dbAnswerKey['q' . $q['question_number']] = $q['correct_answer'] ?? '';
        }
        
        $reportRedirectUrl = route('online-test.result', [
            'slug' => $slugAlias ?? 'toefl-itp',
            'onlineTestResult' => 0 // This will be handled dynamically in JS
        ]);
    @endphp

    <script>
        window._readingData = {
            dbAnswerKey: @json($dbAnswerKey),
            customAnswerKey: @json($packageAnswerKey ?? []),
            submitUrl: @json($packageSectionSubmitUrl ?? null),
            redirectUrl: @json($reportRedirectUrl)
        };
    </script>
PHP;

$content = str_replace(
    "@php\n        \$packageNumber", 
    str_replace("    @php\n        \$packageNumber", "@php\n        \$packageNumber", $phpCode) . "\n\n        // Dummy to replace", 
    $content
);

$content = preg_replace('/@php.*?__\/\/ Dummy to replace/s', '', $content); // remove duplicate stuff if any (not needed as I will just preg_replace the whole php block)

