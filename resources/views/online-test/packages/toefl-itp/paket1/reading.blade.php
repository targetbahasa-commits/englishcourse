<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['label'] ?? 'TOEFL ITP' }} Reading - Paket {{ $test['package_number'] ?? 1 }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #f8fafc !important; font-family: Figtree, sans-serif; }
        .toefl-mockup-font { font-family: Arial, Helvetica, sans-serif; }
        body {
            background-color: white !important;
        }
        .instruction-box {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            border-left: 6px solid #f59e0b;
        }
        .part-header {
            color: #0f766e;
            font-weight: 700;
        }
        .listening-answer-sheet .divide-y > .group {
            padding-top: 0.125rem;
            padding-bottom: 0.125rem;
        }
        .listening-answer-sheet .group .mb-2.text-sm {
            font-size: 1.05rem;
            line-height: 1.35;
            margin-bottom: 0.2rem;
        }
        .listening-answer-sheet .group .space-y-2 > :not([hidden]) ~ :not([hidden]) {
            margin-top: 0.2rem;
        }
        .listening-answer-sheet .group .space-y-2 .p-2 {
            padding: 0.4rem 0.62rem;
        }
        .listening-answer-sheet .group .space-y-2 span.text-sm {
            font-size: 1.08rem;
            line-height: 1.32;
        }
        .listening-answer-sheet .bg-white.rounded-lg.border.border-gray-200.shadow-sm.p-4 {
            padding: 0.7rem;
        }
        .listening-answer-sheet .grid.grid-cols-1.md\:grid-cols-2.gap-4.md\:gap-6 {
            gap: 0.5rem;
        }
        .listening-answer-sheet .listening-option-card {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            min-height: 3.35rem;
            transition: border-color 0.16s ease, background-color 0.16s ease, box-shadow 0.16s ease, transform 0.12s ease;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card {
            transform: translateY(-1px);
            box-shadow: 0 3px 12px rgba(220, 38, 38, 0.16);
        }
        .listening-answer-sheet .listening-option-card::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 2.1rem;
            width: 6px;
            height: 6px;
            border-radius: 9999px;
            background: rgba(220, 38, 38, 0.22);
            transform: translate(-50%, -50%) scale(0);
            pointer-events: none;
            opacity: 0;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card::after {
            animation: listeningOptionRipple 0.34s ease-out;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card span.text-sm {
            color: #b91c1c;
        }
        .listening-answer-sheet .listening-option-badge {
            width: 2.32rem;
            height: 2.32rem;
            transform-origin: center;
            will-change: transform, box-shadow;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge {
            border-color: #dc2626;
            background-color: #dc2626;
            color: #ffffff;
            animation: listeningBadgePop 0.18s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge span {
            color: #ffffff;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card {
            border-color: #e02424;
            background-color: #fff7f7;
            box-shadow: 0 0 0 1px rgba(224, 36, 36, 0.36), 0 3px 12px rgba(224, 36, 36, 0.14);
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card span.text-sm {
            font-weight: 700;
            letter-spacing: 0.005em;
        }
        .listening-answer-sheet .listening-option-card .mr-3 {
            margin-right: 0.78rem;
        }
        .listening-answer-sheet .listening-option-card span.text-sm {
            padding-left: 0.1rem;
        }
        @keyframes listeningBadgePop {
            0% {
                transform: scale(0.82);
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.45);
            }
            65% {
                transform: scale(1.1);
                box-shadow: 0 0 0 8px rgba(220, 38, 38, 0.12);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
            }
        }
        @keyframes listeningOptionRipple {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 0.5;
            }
            100% {
                transform: translate(-50%, -50%) scale(42);
                opacity: 0;
            }
        }
        @media (max-width: 768px) {
            .listening-answer-sheet .group .space-y-2 .p-2 {
                padding: 0.32rem 0.5rem;
            }
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1rem;
                line-height: 1.28;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.05rem;
                height: 2.05rem;
            }
            .listening-answer-sheet .listening-option-card .mr-3 {
                margin-right: 0.58rem;
            }
            .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge {
                animation-duration: 0.14s;
            }
            .listening-answer-sheet input[type="radio"]:checked + .listening-option-card::after {
                animation-duration: 0.24s;
            }
            .listening-answer-sheet .listening-option-card {
                transition-duration: 0.11s;
            }
        }
        @media (min-width: 769px) and (max-width: 1199px) {
            .listening-answer-sheet .group .space-y-2 .p-2 {
                padding: 0.36rem 0.58rem;
            }
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1.04rem;
                line-height: 1.3;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3.22rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.2rem;
                height: 2.2rem;
            }
            .listening-answer-sheet .listening-option-card .mr-3 {
                margin-right: 0.68rem;
            }
        }
        @media (min-width: 1200px) {
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1.12rem;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3.45rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.38rem;
                height: 2.38rem;
            }
        }
        .listening-option-ellipse {
            width: 26px;
            height: 18px;
            border: 2px solid #333;
            border-radius: 50%;
            display: inline-block;
            margin-right: 12px;
            flex-shrink: 0;
            transition: all 0.2s;
            position: relative;
        }

        input[type="radio"]:checked + div .listening-option-ellipse {
            background-color: #111;
            border-color: #111;
        }

        /* Paginated question option styles */
        .mockup-option-label input[type="radio"]:checked ~ .mockup-option-card {
            border-color: #ef4444;
            background-color: #fef2f2;
        }
        .mockup-option-label input[type="radio"]:checked ~ .mockup-option-card .mockup-option-badge {
            background-color: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
        }
        .mockup-option-label input[type="radio"]:checked ~ .mockup-option-card .mockup-option-text {
            color: #b91c1c;
            font-weight: 700;
        }
        .mockup-option-label:hover .mockup-option-card {
            border-color: #d1d5db;
            background-color: #f9fafb;
        }
        .mockup-option-badge {
            transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }
        .mockup-option-card {
            transition: border-color 0.15s ease, background-color 0.15s ease;
        }
        /* ── Custom TOEFL Colors ── */
        .bg-toefl-yellow { background-color: #d1a82e !important; }
        .bg-toefl-yellow-light { background-color: rgba(209, 168, 46, 0.2) !important; }
        .border-toefl-yellow { border-color: #d1a82e !important; }
        .text-toefl-yellow { color: #d1a82e !important; }
        .hover\:bg-toefl-yellow-dark:hover { background-color: #b89327 !important; }

        /* ── Split Screen Layout ── */
        .split-screen-wrapper {
            height: calc(100vh - 3.5rem);
            min-height: 600px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .split-screen-section {
            min-height: 760px;
            flex: 1 1 0%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .split-screen-panels {
            min-height: 0;
            flex: 1 1 0%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        @media (min-width: 1024px) {
            .split-screen-panels {
                flex-direction: row;
            }
        }
        .split-screen-left, .split-screen-right {
            min-height: 0;
            flex: 1 1 0%;
            overflow-y: auto;
        }
        .split-screen-left {
            border-right: 1px solid #e5e7eb;
        }
        .split-screen-custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .split-screen-custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .split-screen-custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 9999px;
            border: 2px solid transparent;
            background-clip: content-box;
        }
        .split-screen-custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8;
        }

        /* ── Reading passage gutter (line markers) ── */
        .mockup-passage-shell {
            --toefl-passage-font-size: 15px;
            --toefl-passage-leading: 1.65;
            --toefl-line-step: calc(var(--toefl-passage-font-size) * var(--toefl-passage-leading));
        }
        .mockup-passage-shell.with-gutter {
            display: grid;
            grid-template-columns: 2.9rem minmax(0, 1fr);
            column-gap: 0.45rem;
            align-items: stretch;
        }
        .mockup-passage-gutter {
            position: relative;
            padding-top: 0.25rem;
        }
        .mockup-gutter-marker {
            position: absolute;
            right: 0;
            text-align: right;
            font-style: italic;
            font-weight: 500;
            color: #374151;
            font-size: 13px;
            line-height: 1;
            white-space: nowrap;
            transform: translateY(-50%);
        }
        .mockup-passage-text {
            color: #111827;
            font-size: var(--toefl-passage-font-size);
            line-height: var(--toefl-passage-leading);
        }
        .mockup-passage-paragraph {
            margin: 0;
        }
        .mockup-passage-paragraph + .mockup-passage-paragraph {
            text-indent: 1.25em;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    @include('components.impersonation-banner')

    @php
        $isAdminLayout = auth()->check() && strtolower(auth()->user()->active_role ?? 'student') === 'admin';
    @endphp

    <div class="flex min-h-screen">
        @if($isAdminLayout)
            @include('components.sidebar-admin')
        @endif

        <main class="flex-1 overflow-hidden transition-all duration-300 {{ $isAdminLayout ? 'md:ml-64' : '' }}">
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

        <div x-data="{
        currentReadingSection: 'instructions',
        currentReadingPassageIndex: 0,
        readingCountdown: 3300,
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
        readAnswer(num) {
            const checked = document.querySelector(`input[type='radio'][name='question_${num}']:checked`);
            return checked ? checked.value : '';
        },
        collectAnswersPayload() {
            const payload = {};
            const inputs = document.querySelectorAll(`input[type='radio']:checked`);
            inputs.forEach(input => {
                const name = input.name;
                if (name.startsWith('q')) {
                    payload[name] = input.value;
                }
            });
            return payload;
        },
        submitReadingSection() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;

            const dbAnswerKey = window._readingData.dbAnswerKey;
            const customAnswerKey = window._readingData.customAnswerKey;
            const submitUrl = window._readingData.submitUrl;
            const csrfToken = document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '';

            const getAnswerForQuestion = (number) => {
                const qKey = `q${number}`;
                const raw = customAnswerKey[qKey] ?? customAnswerKey[String(number)] ?? dbAnswerKey[qKey] ?? '';
                return String(raw || '').trim().toUpperCase();
            };

            let correct = 0;
            const wrong = [];
            const payloadAnswers = {};

            // Collect all radio buttons (name format: q1, q2... q50)
            for (let i = 1; i <= 50; i++) {
                const checked = document.querySelector(`input[type='radio'][name='q${i}']:checked`);
                const user = checked ? checked.value : '';
                payloadAnswers[`q${i}`] = user;
                
                const expected = getAnswerForQuestion(i);
                const ok = user !== '' && expected !== '' && user === expected;
                if (ok) {
                    correct++;
                } else {
                    wrong.push(i);
                }
            }

            fetch(submitUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    score: correct,
                    total_questions: 50,
                    wrong_numbers: wrong,
                    answers: payloadAnswers
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('HTTP error');
                return response.json();
            })
            .then(data => {
                if (data.result_id) {
                    window.location.href = window._readingData.redirectUrl.replace('0', data.result_id);
                } else {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menyambung ke server.');
                this.isSubmitting = false;
            });
        }
    }">

        <form id="readingForm" method="POST" action="{{ $packageSectionSubmitUrl }}" class="space-y-0 relative">
            @csrf
            
            <div class="container mx-auto px-4 py-8 pb-32">
<!-- SECTION 3: READING COMPREHENSION -->
    <!-- ============================================ -->
    <div x-show="currentReadingSection === 'instructions'" class="w-full flex justify-center">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden pb-8 font-sans border border-gray-200 flex justify-center w-full">
            <div style="max-width: 1100px; width: 100%; padding: 32px 20px 48px;">
                <div style="background-color: #d1a82e; border-radius: 9999px; padding: 14px 36px; margin-bottom: 32px; width: 100%; box-sizing: border-box;">
                    <h2 style="font-size: 2rem; font-weight: 800; color: #111; margin: 0; letter-spacing: -0.02em; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Section 3: Reading Comprehension</h2>
                </div>

                <div style="padding-left: 36px; padding-right: 36px; font-size: 1.05rem; color: #222; line-height: 1.6; font-family: 'Myriad Pro', -apple-system, Arial, sans-serif;">
                    <p style="margin: 0 0 18px 0;">Time: 55 minutes, including the reading of the directions</p>
                    <p style="margin: 0 0 24px 0;">Now set your clock for 55 minutes.</p>
                    <p style="margin: 0 0 24px 0;"><strong style="font-weight: 800; color: #111;">Directions:</strong> In this section you will read several passages. Each passage is followed by several questions about it. For questions 1-50, you are to choose the <strong style="font-weight: 800; color: #111;">one</strong> best answer, (A), (B), (C) or (D), to each question. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</p>
                    <p style="margin: 0 0 34px 0;">Answer all questions following a passage on the basis of what is <strong style="font-weight: 800; color: #111;">stated</strong> or <strong style="font-weight: 800; color: #111;">implied</strong> in the passage.</p>

                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #111; margin: 0 0 24px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Read the following sample passage:</h3>

                    <div style="display: grid; grid-template-columns: 68px minmax(0, 1fr); column-gap: 22px; align-items: start; margin-bottom: 42px;">
                        <div style="text-align: right; font-style: italic; color: #374151; line-height: 1.5; padding-top: 104px;">
                            <div>Line</div>
                            <div style="margin-top: 24px;">5</div>
                        </div>
                        <div style="font-size: 1.05rem; color: #222; line-height: 1.65;">
                            <p style="margin: 0; text-indent: 0;">The railroad was not the first institution to impose regularity on society, or to draw attention to the importance of precise timekeeping. For as long as merchants have set out their wares at daybreak and communal festivities have been celebrated, people have been in rough agreement with their neighbors as to the time of day. The value of this tradition is today more apparent than ever. Were it not for public acceptance of a single yardstick of time, social life would be unbearably chaotic: the massive daily transfers of goods, services, and information would proceed in fits and starts; the very fabric of modern society would begin to unravel.</p>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; margin-bottom: 18px; flex-wrap: wrap;">
                        <h4 style="font-size: 1.05rem; font-weight: 800; color: #111; margin: 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Example I</h4>
                        <div style="text-align: center; min-width: 180px;">
                            <p style="font-weight: 800; color: #111; font-size: 0.9rem; margin: 0 0 8px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.01em;">Sample Answer</p>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">A</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">B</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; background-color: #111; display: inline-flex;"></span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">D</span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 32px;">
                        <p style="font-size: 1.05rem; margin: 0 0 14px 0;">What is the main idea of the passage?</p>
                        <div style="padding-left: 58px; line-height: 1.6;">
                            <p style="margin: 0 0 4px 0;">(A) In modern society, we must take more time for our neighbors.</p>
                            <p style="margin: 0 0 4px 0;">(B) The traditions of society are timeless.</p>
                            <p style="margin: 0 0 4px 0;">(C) An accepted way of measuring time is essential for the smooth functioning of society.</p>
                            <p style="margin: 0 0 14px 0;">(D) Society judges people by the times at which they conduct certain activities.</p>
                        </div>
                        <p style="margin: 0;">The main idea of the passage is that societies need to agree about how time is to be measured in order to function smoothly. Therefore, you should choose (C).</p>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; margin-bottom: 18px; flex-wrap: wrap;">
                        <h4 style="font-size: 1.05rem; font-weight: 800; color: #111; margin: 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Example II</h4>
                        <div style="text-align: center; min-width: 180px;">
                            <p style="font-weight: 800; color: #111; font-size: 0.9rem; margin: 0 0 8px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; letter-spacing: -0.01em;">Sample Answer</p>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">A</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">B</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; border: 1.5px solid #333; display: inline-flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #111;">C</span>
                                <span style="width: 28px; height: 20px; border-radius: 50%; background-color: #111; display: inline-flex;"></span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 34px;">
                        <p style="font-size: 1.05rem; margin: 0 0 14px 0;">In line 5, the phrase “this tradition” refers to</p>
                        <div style="padding-left: 58px; line-height: 1.6;">
                            <p style="margin: 0 0 4px 0;">(A) the practice of starting the business day at dawn</p>
                            <p style="margin: 0 0 4px 0;">(B) friendly relations between neighbors</p>
                            <p style="margin: 0 0 4px 0;">(C) the railroad’s reliance on time schedules</p>
                            <p style="margin: 0 0 14px 0;">(D) people’s agreement on the measurement of time</p>
                        </div>
                        <p style="margin: 0;">The phrase “this tradition” refers to the preceding clause, “people have been in rough agreement with their neighbors as to the time of day.” Therefore you should choose (D).</p>
                    </div>

                    <p style="font-size: 1.3rem; font-weight: 800; color: #d1a82e; text-align: center; margin: 0 0 28px 0; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;">Now begin work on the questions.</p>
                </div>

                <div style="display: flex; justify-content: center; margin-top: 24px;">
                    <button type="button" @click="goToReadingPassage(0)" style="padding: 14px 32px; background-color: #d1a82e; color: #111; font-weight: bold; font-size: 1.1rem; border-radius: 12px; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px; font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                        Now Begin Work on the Questions
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="currentReadingSection === 'questions'" class="split-screen-wrapper px-2 md:px-4 pt-2 pb-0">
        <div style="flex-shrink: 0; margin-bottom: 0.4rem;" class="flex flex-row items-center justify-between gap-2 px-2">
            <div>
                <h2 class="text-base font-bold text-black leading-tight">Section 3: Reading Comprehension <span class="font-normal text-gray-500 text-sm ml-2">Questions 1-50</span></h2>
            </div>
            
            <!-- Global Timer -->
            <div class="bg-white border-2 px-4 py-1.5 rounded-xl shadow-sm flex items-center gap-2 transition-colors duration-300 pointer-events-none"
                 :class="{
                     'border-gray-800 text-gray-800': readingCountdown > 300,
                     'border-orange-400 text-orange-700 bg-orange-50': readingCountdown <= 300 && readingCountdown > 60,
                     'border-red-500 text-red-700 bg-red-50 animate-pulse': readingCountdown <= 60
                 }">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="font-bold text-lg font-mono tracking-wider" x-text="formatReadingTime()"></div>
            </div>
        </div>

        @foreach(($readingPassages ?? []) as $passageIndex => $passage)

            <section
                x-cloak
                x-show="currentReadingPassageIndex === {{ $passageIndex }}"
                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden split-screen-section"
            >
                <div class="px-4 md:px-6 py-2 border-b border-gray-100" style="background-color: #fbf8f1; flex-shrink: 0;">
                    <div class="flex flex-row items-center justify-between gap-2">
                        <h3 class="text-xl font-bold leading-tight text-gray-900">{{ $passage['section_title'] ?? ('Passage ' . ($passageIndex + 1)) }}</h3>
                        <span class="inline-flex items-center rounded-full bg-white px-3 py-1 text-xs font-bold text-black border border-toefl-yellow whitespace-nowrap">
                            Passage {{ $passage['passage_number'] ?? ($passageIndex + 1) }}
                        </span>
                    </div>
                </div>

                <div class="split-screen-panels">
                    <div data-reading-scroll class="p-4 md:p-6 bg-white split-screen-left split-screen-custom-scrollbar">
                        <div class="mockup-passage-shell with-gutter mockup-passage-text">
                            {{-- Gutter: Line number markers --}}
                            <div class="mockup-passage-gutter" aria-hidden="true">
                                @if(isset($passage['line_markers']) && count($passage['line_markers']) > 0)
                                    @foreach($passage['line_markers'] as $marker)
                                        @php
                                            $defaultLine = $loop->index === 0 ? 1 : $loop->index * 5;
                                            $markerLabel = is_array($marker) ? ($marker['label'] ?? '') : $marker;
                                            $lineNumber  = is_array($marker) ? (int) ($marker['line'] ?? $defaultLine) : $defaultLine;
                                            $lineCenter  = $lineNumber - 0.5;
                                        @endphp
                                        <div class="mockup-gutter-marker" style="top: calc({{ $lineCenter }} * var(--toefl-line-step));">{{ $markerLabel }}</div>
                                    @endforeach
                                @endif
                            </div>
                            {{-- Content --}}
                            <div class="mockup-passage-frame">
                                {!! $passage['content'] ?? '' !!}
                            </div>
                        </div>
                    </div>

                    <div data-reading-scroll class="bg-gray-50/60 split-screen-right split-screen-custom-scrollbar">
                        <div class="p-4 md:p-6 space-y-6 flex-1 pb-28">
                            @foreach(($passage['questions'] ?? []) as $question)
                                <article
                                    id="reading-question-{{ $question['id'] ?? $question['question_number'] }}"
                                    class="bg-white rounded-xl border border-gray-200 shadow-sm p-3 md:p-4"
                                >
                                    <div class="flex items-start gap-2 border-b border-gray-100 pb-3 mb-3">
                                        <div class="w-7 h-7 rounded-lg bg-toefl-yellow-light text-black font-extrabold text-xs flex items-center justify-center border border-toefl-yellow shrink-0">
                                            {{ $question['question_number'] }}
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900 leading-6">{{ $question['question_text'] }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @foreach(['A' => $question['option_a'], 'B' => $question['option_b'], 'C' => $question['option_c'], 'D' => $question['option_d']] as $option => $text)
                                            <label class="mockup-option-label relative block w-full cursor-pointer">
                                                <input
                                                    type="radio"
                                                    name="q{{ $question['question_number'] }}"
                                                    value="{{ $option }}"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer m-0 p-0 z-10"
                                                    required
                                                >
                                                <div class="mockup-option-card flex items-center p-2.5 bg-white border border-gray-200 rounded-xl" style="border-width: 1.5px;">
                                                    <div class="mockup-option-badge flex-shrink-0 flex items-center justify-center w-7 h-7 rounded-full border-2 border-gray-300 text-gray-500 font-bold text-xs mr-3">
                                                        {{ $option }}
                                                    </div>
                                                    <span class="mockup-option-text text-gray-700 text-sm select-none" style="line-height: 1.45;">{{ $text }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>

                                    <!-- Admin Inline Kunci Update toolbar -->
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <div class="mt-4 flex flex-wrap items-center gap-3 border-t border-gray-100 pt-4">
                                            <div class="flex gap-2 flex-grow">
                                                @if(!empty($question['answer']))
                                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">&#10003; Kunci: {{ $question['answer'] }}</span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">&#10005; Belum ada kunci</span>
                                                @endif
                                            </div>
                                            <button type="button" class="bg-gray-800 hover:bg-black text-white font-semibold rounded-lg px-3 py-1.5 text-xs transition" onclick="updateKunci({{ $question['id'] }}, {{ $question['question_number'] }}, '{{ $question['answer'] ?? '' }}')">Edit Kunci</button>
                                        </div>
                                    @endif

                                </article>
                            @endforeach
                        </div>

                        <div class="sticky bottom-0 z-30 border-t border-gray-200 bg-gray-50/95 p-4 backdrop-blur w-full mt-auto">
                            <div class="flex justify-between items-center gap-4">
                                <button
                                    type="button"
                                    @click="goToReadingPassage(currentReadingPassageIndex - 1)"
                                    :disabled="currentReadingPassageIndex === 0"
                                    :class="currentReadingPassageIndex === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 text-gray-700 shadow-sm bg-white'"
                                    class="px-5 py-2.5 rounded-xl border border-gray-300 font-bold transition flex items-center gap-2"
                                    style="border-width: 2px;"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    Prev Passage
                                </button>

                                @if($passageIndex < (count($readingPassages ?? []) - 1))
                                    <button
                                        type="button"
                                        @click="goToReadingPassage(currentReadingPassageIndex + 1)"
                                        class="px-6 py-2.5 rounded-xl bg-toefl-yellow text-black font-bold hover:bg-toefl-yellow-dark transition shadow-lg flex items-center gap-2"
                                    >
                                        Next Passage
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                @else
                                    <button
                                        type="button"
                                        @click="submitReadingSection"
                                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition shadow-lg flex items-center gap-2"
                                    >
                                        Submit Full Test
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    </div>

                </div>
        </form>
    </div>
    <!-- Section Navigation -->
    <div class="fixed bottom-8 right-8 flex flex-col md:flex-row gap-3 z-50">
        <a href="{{ $listeningUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'listening']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ 'reading' === 'listening' ? 'bg-toefl-yellow text-black' : 'bg-white text-black border-2 border-black' }}">
            Section 1: Listening
        </a>
        <a href="{{ $structureRedirectUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'structure']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ 'reading' === 'structure' ? 'bg-toefl-yellow text-black' : 'bg-white text-black border-2 border-black' }}">
            Section 2: Structure
        </a>
        <a href="{{ $readingRedirectUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'reading']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ 'reading' === 'reading' ? 'bg-toefl-yellow text-black' : 'bg-white text-black border-2 border-black' }}">
            Section 3: Reading
        </a>
    </div>

    @if(auth()->check() && auth()->user()->isAdmin())
        <script>
            function updateKunci(questionId, questionNum, currentAnswer) {
                const answer = prompt(`Masukkan Kunci Jawaban (A/B/C/D) untuk soal No ${questionNum}:`, currentAnswer || '');
                if (answer === null) return;
                const cleanAnswer = answer.trim().toUpperCase();
                if (!['A','B','C','D'].includes(cleanAnswer)) {
                    alert('Jawaban tidak valid, harus A, B, C, atau D');
                    return;
                }
                
                fetch(`/assignments/toefl-itp/mockup/package/{{ $packageNumber ?? 1 }}/question/${questionId}/update-answer`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ answer: cleanAnswer })
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        alert('Kunci berhasil diperbarui ke: ' + cleanAnswer + '. Halaman akan dimuat ulang.');
                        location.reload();
                    } else {
                        alert('Gagal update: ' + (data.message || 'Unknown error'));
                    }
                }).catch(err => {
                    alert('Terjadi kesalahan koneksi.');
                    console.error(err);
                });
            }
        </script>
    @endif

        </main>
    </div>
</body>
</html>