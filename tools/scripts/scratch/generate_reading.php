<?php

$mockupPath = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/toefl-itp/mockup.blade.php';
$mockupContent = file_get_contents($mockupPath);

preg_match('/<style>(.*?)<\/style>/s', $mockupContent, $matches);
$mockupStyle = $matches[1] ?? '';

$startReading = strpos($mockupContent, '<!-- SECTION 3: READING COMPREHENSION -->');
$endReading = strpos($mockupContent, '<!-- Section Navigation -->');
$readingHtml = substr($mockupContent, $startReading, $endReading - $startReading);

// Replace currentView === 'section3' with true or similar things
$readingHtml = str_replace("currentView === 'section3' && ", "", $readingHtml);
$readingHtml = str_replace("currentView === 'section3'", "true", $readingHtml);
$readingHtml = preg_replace('/@click="currentView = \'section3\';\s*/', '@click="', $readingHtml);

// We don't need the form from mockup, we will wrap it in our own form like structure.blade.php
$readingHtml = str_replace('submitFullMockup', 'submitReadingSection', $readingHtml);

// Generate final blade file content
$finalContent = <<<'HTML'
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['label'] ?? 'TOEFL ITP' }} Reading - Paket {{ $test['package_number'] ?? 1 }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #f8fafc !important; font-family: Figtree, sans-serif; }
        .toefl-mockup-font { font-family: Arial, Helvetica, sans-serif; }
HTML;

$finalContent .= "\n        " . trim($mockupStyle) . "\n";

$finalContent .= <<<'HTML'
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-teal-50 via-white to-emerald-50">
    @include('components.impersonation-banner')

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
    @endphp

    <div x-data="{
        currentReadingSection: 'instructions', // 'instructions' or 'questions'
        currentReadingPassageIndex: 0,
        readingCountdown: 3300, // 55 minutes
        readingTimer: null,
        isSubmitting: false,
        startReadingTimer() {
            if (this.readingTimer) return;
            this.readingTimer = setInterval(() => {
                if (this.readingCountdown > 0) {
                    this.readingCountdown--;
                } else {
                    clearInterval(this.readingTimer);
                    this.submitReadingSection();
                }
            }, 1000);
        },
        formatReadingTime() {
            const m = Math.floor(this.readingCountdown / 60).toString().padStart(2, '0');
            const s = (this.readingCountdown % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        },
        goToReadingPassage(index) {
            this.currentReadingPassageIndex = index;
            this.currentReadingSection = 'questions';
            this.startReadingTimer();
            window.scrollTo(0,0);
        },
        submitReadingSection() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;
            document.getElementById('readingForm').submit();
        }
    }">

        <!-- Floating Global Timer -->
        <div x-cloak x-show="currentReadingSection === 'questions'" class="fixed top-24 right-8 z-50 bg-white border-2 px-5 py-3 rounded-2xl shadow-xl flex items-center gap-3 transition-colors duration-300 pointer-events-none"
             :class="{
                 'border-teal-500 text-teal-700': readingCountdown > 300,
                 'border-orange-400 text-orange-700 bg-orange-50': readingCountdown <= 300 && readingCountdown > 60,
                 'border-red-500 text-red-700 bg-red-50 animate-pulse': readingCountdown <= 60
             }">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="font-bold text-2xl font-mono tracking-wider" x-text="formatReadingTime()"></div>
        </div>

        <form id="readingForm" method="POST" action="{{ $packageSectionSubmitUrl }}" class="space-y-0 relative">
            @csrf
            
            <div class="max-w-6xl mx-auto px-4 py-8 pb-32">
HTML;

$finalContent .= "\n" . $readingHtml;

$finalContent .= <<<'HTML'
            </div>
        </form>
    </div>
</body>
</html>
HTML;

file_put_contents('/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/online-test/packages/toefl-itp/paket1/reading.blade.php', $finalContent);
echo "reading.blade.php created successfully.\n";

