<script>
    // Pastikan klik pada label tetap memilih radio
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.mockup-option-label').forEach(function(label) {
            label.addEventListener('click', function(e) {
                if (e.target.tagName !== 'INPUT') {
                    e.preventDefault();
                }
                const radio = label.querySelector('input[type="radio"]');
                if (radio && !radio.checked) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });
    });
</script>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['label'] ?? 'TOEFL ITP' }} Listening - Paket {{ $test['package_number'] ?? 1 }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .toefl-mockup-font {
            font-family: Arial, Helvetica, sans-serif;
        }

        .toefl-section-pill {
            border-radius: 9999px;
            background: #d1a82e;
            color: #111111;
            font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;
            font-weight: 800;
            letter-spacing: -0.01em;
        }

        .toefl-part-chip {
            border-radius: 0.75rem;
            background: #111111;
            color: #ffffff;
            font-family: 'Arial Narrow', 'Helvetica Condensed', Arial, sans-serif;
            font-weight: 800;
            letter-spacing: 0.02em;
        }

        .toefl-directions-copy {
            font-family: 'Myriad Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            font-size: 1.03rem;
            line-height: 1.62;
        }

        .toefl-example-copy {
            font-family: 'Myriad Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            font-size: 1.02rem;
            line-height: 1.58;
        }

        .toefl-part-card {
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .toefl-question-nav-btn {
            min-width: 2rem;
            height: 2rem;
            padding: 0 0.45rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #4b5563;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
            transition: all 0.15s ease;
        }

        .toefl-question-nav-btn:hover {
            border-color: #f59e0b;
            color: #92400e;
            background: #fffbeb;
        }

        .toefl-question-nav-btn.is-active {
            border-color: #dc2626;
            background: #dc2626;
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(220, 38, 38, 0.26);
        }

        .toefl-part-divider-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 2rem;
            padding: 0 0.6rem;
            border-radius: 0.5rem;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.01em;
            text-transform: uppercase;
            border: 1px solid #f3e8b0;
            background: #fff8dc;
            color: #7a5700;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .toefl-part-divider-chip:hover {
            border-color: #e8c95f;
            background: #fff2bf;
        }

        .toefl-dialog-divider-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 2rem;
            padding: 0 0.6rem;
            border-radius: 0.5rem;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
            border: 1px solid #bae6fd;
            transition: all 0.15s ease;
        }

        .toefl-dialog-divider-chip:hover {
            border-color: #38bdf8;
            color: #0c4a6e;
            background: #bae6fd;
        }

        .toefl-part-divider-chip.is-active {
            border-color: #dc2626;
            background: #dc2626;
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(220, 38, 38, 0.22);
        }

        .toefl-authentic-sheet {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: #ffffff;
            color: #111111;
            padding: 1.15rem 1.2rem;
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.32;
        }

        .toefl-authentic-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.85rem;
        }

        .toefl-authentic-top h3 {
            margin: 0;
            font-size: 1.85rem;
            line-height: 1.08;
            font-weight: 700;
            font-family: Arial, Helvetica, sans-serif;
            letter-spacing: 0.01em;
        }

        .toefl-authentic-top h3 span {
            display: block;
            margin-top: 0.12rem;
            font-size: 2.55rem;
            font-weight: 900;
            line-height: 0.98;
        }

        .toefl-authentic-box {
            width: 4.45rem;
            height: 4.45rem;
            border: 3px solid #111111;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2.45rem;
            font-weight: 900;
            line-height: 1;
            flex-shrink: 0;
        }

        .toefl-authentic-body {
            font-size: 2rem;
            line-height: 1.25;
            font-weight: 700;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }

        .toefl-authentic-copy {
            margin-top: 0.8rem;
            font-size: 1.02rem;
            line-height: 1.34;
            font-weight: 700;
        }

        .toefl-authentic-part-title {
            margin: 1rem 0 0.55rem;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            font-family: Arial, Helvetica, sans-serif;
        }

        .toefl-authentic-directions,
        .toefl-authentic-example,
        .toefl-authentic-result {
            font-size: 1.02rem;
            line-height: 1.34;
            margin: 0.6rem 0;
            font-weight: 700;
        }

        .toefl-authentic-flex {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1.25rem;
            margin-top: 0.5rem;
        }

        .toefl-authentic-sample {
            text-align: center;
            min-width: 10rem;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.96rem;
            font-weight: 700;
        }

        .toefl-authentic-bubbles {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.38rem;
            margin-top: 0.22rem;
        }

        .toefl-authentic-bubble {
            width: 0.95rem;
            height: 0.95rem;
            border: 1.5px solid #111111;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.64rem;
            line-height: 1;
        }

        .toefl-authentic-bubble.is-fill {
            background: #111111;
            border-color: #111111;
            color: transparent;
        }

        .toefl-authentic-options {
            margin: 0.35rem 0 0 0;
            padding: 0;
            list-style: none;
            font-size: 1.02rem;
            line-height: 1.32;
            font-weight: 700;
        }

        .toefl-authentic-options li {
            margin: 0.08rem 0;
        }

        @media (max-width: 900px) {
            .toefl-authentic-sheet {
                padding: 1rem;
            }

            .toefl-authentic-top h3 {
                font-size: 1.2rem;
            }

            .toefl-authentic-top h3 span {
                font-size: 1.7rem;
            }

            .toefl-authentic-box {
                width: 3rem;
                height: 3rem;
                border-width: 2px;
                font-size: 1.65rem;
            }

            .toefl-authentic-body,
            .toefl-authentic-copy,
            .toefl-authentic-part-title,
            .toefl-authentic-directions,
            .toefl-authentic-example,
            .toefl-authentic-result,
            .toefl-authentic-options {
                font-size: 1.05rem;
                line-height: 1.45;
            }

            .toefl-authentic-flex {
                flex-direction: column;
                gap: 0.5rem;
            }

            .toefl-authentic-sample {
                align-self: flex-end;
                font-size: 0.95rem;
            }
        }

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
    </style>
</head>

<body class="antialiased bg-gradient-to-br from-amber-50 via-white to-yellow-50" style="font-family: Figtree, sans-serif;">
    @include('components.impersonation-banner')

    @php
        $isAdminLayout = auth()->check() && strtolower(auth()->user()->active_role ?? 'student') === 'admin';
    @endphp

    <div class="flex min-h-screen">
        @if($isAdminLayout)
            @include('components.sidebar-admin')
        @endif

        <main class="flex-1 transition-all duration-300 {{ $isAdminLayout ? 'md:ml-64' : '' }}">    @php
        $packageNumber = (int) ($test['package_number'] ?? 1);

        $listeningQuestions = \App\Models\ToeflMockupQuestion::query()
            ->where('section', 'listening')
            ->where('package_number', $packageNumber)
            ->orderBy('question_number')
            ->get()
            ->map(function ($q) {
                $number = (int) $q->question_number;
                $part = strtoupper((string) ($q->part ?: ($number <= 30 ? 'A' : ($number <= 38 ? 'B' : 'C'))));

                return [
                    'id' => $q->id,
                    'number' => $number,
                    'part' => in_array($part, ['A', 'B', 'C'], true) ? $part : ($number <= 30 ? 'A' : ($number <= 38 ? 'B' : 'C')),
                    'question' => (string) ($q->question_text ?? ''),
                    'A' => (string) ($q->option_a ?? ''),
                    'B' => (string) ($q->option_b ?? ''),
                    'C' => (string) ($q->option_c ?? ''),
                    'D' => (string) ($q->option_d ?? ''),
                    'answer' => strtoupper((string) ($q->correct_answer ?? '')),
                    'audio_file' => (string) ($q->audio_file ?? ''),
                    'transcript_en' => (string) ($q->transcript_en ?? ''),
                    'transcript_id' => (string) ($q->transcript_id ?? ''),
                ];
            })
            ->values()
            ->all();

        $questionsByPart = [
            'A' => array_values(array_filter($listeningQuestions, fn ($q) => $q['part'] === 'A')),
            'B' => array_values(array_filter($listeningQuestions, fn ($q) => $q['part'] === 'B')),
            'C' => array_values(array_filter($listeningQuestions, fn ($q) => $q['part'] === 'C')),
        ];

        $dbAnswerKey = [];
        foreach ($listeningQuestions as $q) {
            $dbAnswerKey['q' . $q['number']] = $q['answer'];
        }

        $latestScore = is_array($latestPackageSectionResult?->evaluation_data ?? null)
            ? ($latestPackageSectionResult->evaluation_data['score_correct'] ?? null)
            : null;

        $latestTotal = is_array($latestPackageSectionResult?->evaluation_data ?? null)
            ? ($latestPackageSectionResult->evaluation_data['score_total'] ?? null)
            : null;

        $mockupDirectionAudio = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('toefl_mockup_listening_direction_audios')) {
            $mockupDirectionAudio = \App\Models\ToeflMockupListeningDirectionAudio::query()
                ->where('package_number', $packageNumber)
                ->first();
        }

        $defaultPackageAudio = 'audio/toefl/listening/practice/package-1/audio_1775866650_introductorytest1.mp3';

        $partConfigs = [
            'A' => [
                'range' => 'Questions 1-30',
                'directions' => [
                    'In Part A, you will hear short conversations between two people. After each conversation, you will hear a question about the conversation. The conversations and questions will not be repeated.',
                    'After you hear a question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.',
                ],
                'db_audio' => $mockupDirectionAudio?->audio_part_a,
                'audio_candidates' => [
                    'audio/toefl/listening/practice/package-1/part-a.mp3',
                    'audio/toefl/listening/practice/package-1/audio-part-a.mp3',
                    'audio/toefl/listening/practice/package-1/section1-part-a.mp3',
                ],
            ],
            'B' => [
                'range' => 'Questions 31-38',
                'directions' => [
                    'In this part of the test, you will hear longer conversations. After each conversation, you will hear several questions. The conversations and questions will not be repeated.',
                    'After you hear a question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.',
                    'Remember, you are not allowed to take notes or write in your test book.',
                ],
                'db_audio' => $mockupDirectionAudio?->audio_part_b,
                'audio_candidates' => [
                    'audio/toefl/listening/practice/package-1/part-b.mp3',
                    'audio/toefl/listening/practice/package-1/audio-part-b.mp3',
                    'audio/toefl/listening/practice/package-1/section1-part-b.mp3',
                ],
            ],
            'C' => [
                'range' => 'Questions 39-50',
                'directions' => [
                    'In this part of the test, you will hear several short talks. After each talk, you will hear some questions. The talks and questions will not be repeated.',
                    'After you hear a question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.',
                    'Remember, you are not allowed to take notes or write in your test book.',
                ],
                'db_audio' => $mockupDirectionAudio?->audio_part_c,
                'audio_candidates' => [
                    'audio/toefl/listening/practice/package-1/part-c.mp3',
                    'audio/toefl/listening/practice/package-1/audio-part-c.mp3',
                    'audio/toefl/listening/practice/package-1/section1-part-c.mp3',
                ],
            ],
        ];

        foreach ($partConfigs as $partKey => $partConfig) {
            $resolvedAudio = null;
            $audioSourceType = 'none';

            $dbAudioPath = trim((string) ($partConfig['db_audio'] ?? ''));
            if ($dbAudioPath !== '' && file_exists(public_path($dbAudioPath))) {
                $resolvedAudio = $dbAudioPath;
                $audioSourceType = 'mockup-db';
            }

            if ($resolvedAudio === null) {
                foreach ($partConfig['audio_candidates'] as $candidate) {
                    if (file_exists(public_path($candidate))) {
                        $resolvedAudio = $candidate;
                        $audioSourceType = 'local-part-file';
                        break;
                    }
                }
            }

            if ($resolvedAudio === null && file_exists(public_path($defaultPackageAudio))) {
                $resolvedAudio = $defaultPackageAudio;
                $audioSourceType = 'package-fallback';
            }

            $partConfigs[$partKey]['audio_path'] = $resolvedAudio;
            $partConfigs[$partKey]['audio_source'] = $audioSourceType;
        }

        $structureRedirectUrl = route('online-test.package-section', [
            'slugAlias' => $slugAlias ?? 'toefl-itp',
            'package' => $packageNumber,
            'section' => 'structure',
        ]);

        $readingRedirectUrl = route('online-test.package-section', [
            'slugAlias' => $slugAlias ?? 'toefl-itp',
            'package' => $packageNumber,
            'section' => 'reading',
        ]);
    @endphp

    <div class="max-w-6xl mx-auto px-4 py-6 md:py-10">
        <!-- Navigation Panel (Matches Structure page layout) -->
        <div class="mb-6 rounded-xl border border-amber-300 bg-amber-50 p-3" x-data="{ devOpen: true }">
            <div class="flex items-center gap-2 mb-2 cursor-pointer select-none" @click="devOpen = !devOpen">
                <span class="text-xs font-bold text-amber-700 uppercase tracking-widest">🛠 Dev Nav</span>
                <span class="ml-auto text-amber-500 text-xs" x-text="devOpen ? '▲ hide' : '▼ show'"></span>
            </div>
            <div x-show="devOpen" class="space-y-2">
                <!-- Section row -->
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-xs font-semibold text-amber-700 w-16 flex-shrink-0">Section:</span>
                    <span class="px-3 py-1 text-xs font-bold rounded-lg border bg-red-600 text-white border-red-600 cursor-default">
                        1 · Listening
                    </span>
                    <a href="{{ $structureRedirectUrl }}"
                        class="px-3 py-1 text-xs font-bold rounded-lg border transition bg-white text-indigo-700 border-indigo-300 hover:bg-indigo-50">
                        2 · Structure
                    </a>
                    <a href="{{ $readingRedirectUrl }}"
                        class="px-3 py-1 text-xs font-bold rounded-lg border transition bg-white text-emerald-700 border-emerald-300 hover:bg-emerald-50">
                        3 · Reading
                    </a>
                </div>
            </div>
        </div>

        <section class="bg-white border border-amber-100 rounded-3xl shadow-xl overflow-hidden toefl-mockup-font">
            <div class="px-6 md:px-10 py-8 bg-gradient-to-r from-amber-50 via-white to-amber-50 border-b border-amber-200">
                <p class="text-amber-900 text-xs font-bold uppercase tracking-[0.2em]">Internal Package Section</p>
                <div class="mt-3 inline-flex w-full justify-center">
                    <h1 class="toefl-section-pill text-xl md:text-3xl px-6 md:px-10 py-2.5 md:py-3">
                        Section 1: Listening Comprehension
                    </h1>
                </div>
                <p class="mt-1 text-sm text-amber-900/90">TOEFL ITP Paket {{ $packageNumber }} • 50 soal pilihan ganda</p>
            </div>

            <div class="p-6 md:p-10 space-y-6">
                <div class="rounded-2xl border border-amber-200 bg-amber-50 px-6 md:px-9 py-6 toefl-directions-copy text-gray-800">
                    <p><strong>Directions:</strong> In this section of the test, you will have an opportunity to demonstrate your ability to understand conversations and talks in English. There are three parts to this section with special directions for each part. Answer all the questions on the basis of what is stated or implied by the speakers in this test. Do not take notes or write in your test book at any time. Do not turn the pages until you are told to do so.</p>
                </div>

                @if($latestPackageSectionResult)
                    <div id="latestListeningAttemptPanel" class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-900">
                        <p class="font-semibold">Hasil Tersimpan Terakhir</p>
                        <p class="mt-1">Skor: <span class="font-bold">{{ $latestPackageSectionResult->score ?? '-' }}%</span>
                            @if(is_numeric($latestScore) && is_numeric($latestTotal))
                                ({{ (int) $latestScore }}/{{ (int) $latestTotal }})
                            @endif
                        </p>
                        <p class="mt-1 text-xs text-emerald-700">Disimpan: {{ optional($latestPackageSectionResult->completed_at ?? $latestPackageSectionResult->created_at)->format('d M Y H:i') }}</p>
                    </div>
                @else
                    <div id="latestListeningAttemptPanel" class="hidden"></div>
                @endif

                @if(count($listeningQuestions) === 0)
                    <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">
                        Soal listening paket ini belum tersedia di bank soal internal.
                    </div>
                @else
                    <div class="rounded-2xl border border-amber-200 bg-amber-50/70 px-5 py-4">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p id="activeQuestionLabel" class="text-sm font-semibold text-amber-900">Question -/-</p>
                            <div class="flex items-center gap-2">
                                <button id="prevQuestionBtn" type="button" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-50">
                                    Prev
                                </button>
                                <button id="nextQuestionBtn" type="button" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-50">
                                    Next
                                </button>
                            </div>
                        </div>

                        <div class="mt-3 flex flex-wrap items-center gap-1.5" id="questionNumberNav">
                            @foreach($listeningQuestions as $q)
                                @if($q['number'] === 1)
                                    <button type="button" class="toefl-part-divider-chip" data-part-jump="A">Part A</button>
                                @elseif($q['number'] === 31)
                                    <button type="button" class="toefl-part-divider-chip" data-part-jump="B">Part B</button>
                                    <button type="button" class="toefl-dialog-divider-chip" data-dialog-jump="31">Audio 31-34</button>
                                @elseif($q['number'] === 35)
                                    <button type="button" class="toefl-dialog-divider-chip" data-dialog-jump="35">Audio 35-38</button>
                                @elseif($q['number'] === 39)
                                    <button type="button" class="toefl-part-divider-chip" data-part-jump="C">Part C</button>
                                    <button type="button" class="toefl-dialog-divider-chip" data-dialog-jump="39">Audio 39-42</button>
                                @elseif($q['number'] === 43)
                                    <button type="button" class="toefl-dialog-divider-chip" data-dialog-jump="43">Audio 43-46</button>
                                @elseif($q['number'] === 47)
                                    <button type="button" class="toefl-dialog-divider-chip" data-dialog-jump="47">Audio 47-50</button>
                                @endif

                                <button
                                    type="button"
                                    class="toefl-question-nav-btn"
                                    data-question-jump="{{ $q['number'] }}"
                                >
                                    {{ $q['number'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    @foreach(['A', 'B', 'C'] as $partKey)
                        @php $partQuestions = $questionsByPart[$partKey] ?? []; @endphp
                        @if(count($partQuestions) > 0)
                            <section class="toefl-part-card overflow-hidden" data-part-section="{{ $partKey }}">
                                <header class="px-6 md:px-9 py-6 bg-white border-b border-gray-200">
                                    <div class="flex flex-wrap items-center justify-between gap-3">
                                        <div>
                                            <div class="toefl-part-chip inline-flex px-3 py-1 text-sm uppercase">Part {{ $partKey }}</div>
                                            <p class="text-xs uppercase tracking-wide text-gray-500 mt-2">{{ $partConfigs[$partKey]['range'] }}</p>
                                        </div>
                                        <div class="flex flex-col items-end gap-2">
                                            {{-- Audio player moved to direction body --}}
                                        </div>
                                    </div>
                                    <div class="mt-5" data-part-intro-body="{{ $partKey }}">
                                        @php $isAdmin = auth()->check() && auth()->user()->isAdmin(); @endphp
                                        @if(!empty($partConfigs[$partKey]['audio_path']))
                                            @if($isAdmin)
                                                <div style="margin-bottom:1.5rem; padding:1.5rem; background:#f9fafb; border:1px solid #e5e7eb; border-radius:1rem; display:flex; flex-direction:column; gap:0.5rem;">
                                                    <span class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Part {{ $partKey }} Directions Audio</span>
                                                    <audio controls preload="none" style="height:2.5rem; width:100%; max-width:400px;" id="audio-direction-{{ $partKey }}">
                                                        <source src="{{ asset($partConfigs[$partKey]['audio_path']) }}" type="audio/mpeg">
                                                    </audio>
                                                </div>
                                            @else
                                                <audio preload="auto" style="display:none" id="audio-direction-{{ $partKey }}">
                                                    <source src="{{ asset($partConfigs[$partKey]['audio_path']) }}" type="audio/mpeg">
                                                </audio>
                                            @endif
                                        @else
                                            @if($isAdmin)
                                                <div style="margin-bottom:1.5rem;">
                                                    <span class="text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-4 py-3 block text-center font-medium">Audio Directions Part {{ $partKey }} belum tersedia.</span>
                                                </div>
                                            @endif
                                        @endif

                                        @if($partKey === 'A')
                                            <div style="background:#fff; color:#222; font-family:'Arial', 'Helvetica Neue', Helvetica, sans-serif; padding: 2.5rem 3.2rem 2.2rem 3.2rem; margin: -1.5rem -2.5rem; min-height: 720px;">
                                                <div style="margin-bottom:2.2rem;">
                                                    <div style="font-size:2.2rem; font-weight:900; font-family:Arial,Helvetica,sans-serif; color:#008080; letter-spacing:0.01em; margin-bottom:0.2rem;">Section 1: Listening Comprehension</div>
                                                </div>
                                                <div style="font-size:1.13rem; line-height:1.62; margin-bottom:2.1rem; max-width:700px;">
                                                    In this section of the test, you will have an opportunity to demonstrate your ability to understand conversations and talks in English. There are three parts to this section, with special instructions for each part. Answer all the questions on the basis of what is stated or implied by the speakers in this test.
                                                </div>
                                                <div style="font-size:1.55rem; font-weight:700; color:#008080; margin-bottom:1.2rem; letter-spacing:0.01em;">Part A</div>
                                                <div style="font-size:1.09rem; line-height:1.62; margin-bottom:1.1rem;"><span style="font-weight:700; font-family:Arial,Helvetica,sans-serif;">Directions:</span> In Part A, you will hear short conversations between two people. After each conversation, you will hear a question about the conversation. The conversations and questions will not be repeated. After you hear a question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</div>
                                                <div style="font-size:1.09rem; font-weight:700; margin-bottom:0.7rem;">Here is an example:</div>
                                                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:0.7rem;">
                                                    <div style="font-size:1.09rem; margin-right:2.5rem; margin-top:0.1rem;">On the recording, you hear:</div>
                                                    <div style="text-align:right; min-width:10.5rem; margin-top:0;">
                                                        <div style="font-size:1.01rem; font-weight:700; font-family:Arial,Helvetica,sans-serif; margin-bottom:0.1rem;">Sample Answer</div>
                                                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:0.38rem; margin-top:0.18rem;">
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:#111; color:transparent;">A</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">B</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">C</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">D</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-size:1.09rem; margin-bottom:0.2rem; margin-left:2.5rem;">What does the man mean?</div>
                                                <div style="font-size:1.09rem; margin-bottom:0.2rem;">In your test book, you read:</div>
                                                <ul style="font-size:1.09rem; line-height:1.48; margin-bottom:0.7rem; padding-left:2.2rem;">
                                                    <li>(A) He does not like the painting either.</li>
                                                    <li>(B) He does not know how to paint.</li>
                                                    <li>(C) He does not have any paintings.</li>
                                                    <li>(D) He does not know what to do.</li>
                                                </ul>
                                                <div style="font-size:1.09rem; margin-top:0.7rem;">You learn from the conversation that neither the man nor the woman likes the painting. The best answer to the question <span style="font-style:italic;">“What does the man mean?”</span> is (A), “He does not like the painting either.” Therefore, the correct choice is (A).</div>
                                            </div>
                                        @endif

                                        @if($partKey === 'B')
                                            <div style="background:#fff; color:#222; font-family:'Arial', 'Helvetica Neue', Helvetica, sans-serif; padding: 2.5rem 3.2rem 2.2rem 3.2rem; margin: -1.5rem -2.5rem;">
                                                <div style="font-size:1.55rem; font-weight:700; color:#008080; margin-bottom:1.2rem; letter-spacing:0.01em;">Part B</div>
                                                <div style="font-size:1.09rem; line-height:1.62; margin-bottom:0.7rem;"><span style="font-weight:700; font-family:Arial,Helvetica,sans-serif;">Directions:</span> In this part of the test, you will hear longer conversations. After each conversation, you will hear several questions. The conversations and questions will not be repeated.</div>
                                                <div style="font-size:1.09rem; line-height:1.62; margin-bottom:0.7rem;">After you hear a question, read the 4 possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</div>
                                            </div>
                                        @endif

                                        @if($partKey === 'C')
                                            <div style="background:#fff; color:#222; font-family:'Arial', 'Helvetica Neue', Helvetica, sans-serif; padding: 2.5rem 3.2rem 2.2rem 3.2rem; margin: -1.5rem -2.5rem;">
                                                <div style="font-size:1.55rem; font-weight:700; color:#008080; margin-bottom:1.2rem; letter-spacing:0.01em;">Part C</div>
                                                <div style="font-size:1.09rem; line-height:1.62; margin-bottom:0.7rem;"><span style="font-weight:700; font-family:Arial,Helvetica,sans-serif;">Directions:</span> In this part of the test, you will hear several short talks. After each talk, you will hear some questions. The talks and the questions will not be repeated.</div>
                                                <div style="font-size:1.09rem; line-height:1.62; margin-bottom:0.7rem;">After you hear a question, read the 4 possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</div>
                                                <div style="font-size:1.09rem; font-weight:700; margin:1.2rem 0 0.3rem 0;">Here is an example:</div>
                                                <div style="margin-bottom:0.7rem;">On the recording, you hear:</div>
                                                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:0.7rem;">
                                                    <div style="font-size:1.09rem; margin-right:2.5rem; margin-top:0.1rem;">Now listen to a sample question:</div>
                                                    <div style="text-align:right; min-width:10.5rem; margin-top:0;">
                                                        <div style="font-size:1.01rem; font-weight:700; font-family:Arial,Helvetica,sans-serif; margin-bottom:0.1rem;">Sample Answer</div>
                                                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:0.38rem; margin-top:0.18rem;">
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">A</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">B</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:#111; color:transparent;">C</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">D</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-size:1.09rem; margin-bottom:0.2rem; margin-left:2.5rem;">In your test book, you read: What is the main purpose of the program?</div>
                                                <ul style="font-size:1.09rem; line-height:1.48; margin-bottom:0.7rem; padding-left:2.2rem;">
                                                    <li>(A) To demonstrate the latest use of computer graphics</li>
                                                    <li>(B) To discuss the possibility of an economic depression</li>
                                                    <li>(C) To explain the workings of the brain</li>
                                                    <li>(D) To dramatize a famous mystery story</li>
                                                </ul>
                                                <div style="font-size:1.09rem; margin-bottom:0.7rem;">The best answer to the question, “What is the main purpose of the program?” is (C), “To explain the workings of the brain.” Therefore, the correct answer is (C).</div>
                                                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:0.7rem;">
                                                    <div style="font-size:1.09rem; margin-right:2.5rem; margin-top:0.1rem;">Now listen to another sample question:</div>
                                                    <div style="text-align:right; min-width:10.5rem; margin-top:0;">
                                                        <div style="font-size:1.01rem; font-weight:700; font-family:Arial,Helvetica,sans-serif; margin-bottom:0.1rem;">Sample Answer</div>
                                                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:0.38rem; margin-top:0.18rem;">
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">A</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">B</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:none; color:#111;">C</span>
                                                            <span style="width:1.13rem; height:1.13rem; border:2px solid #111; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; font-size:0.74rem; background:#111; color:transparent;">D</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="font-size:1.09rem; margin-bottom:0.2rem; margin-left:2.5rem;">In your test book, you read: Why does the speaker recommend watching the program?</div>
                                                <ul style="font-size:1.09rem; line-height:1.48; margin-bottom:0.7rem; padding-left:2.2rem;">
                                                    <li>(A) It is required of all science majors.</li>
                                                    <li>(B) It will never be shown again.</li>
                                                    <li>(C) It can help viewers improve their memory skills.</li>
                                                    <li>(D) It will help with course work.</li>
                                                </ul>
                                                <div style="font-size:1.09rem; margin-bottom:0.7rem;">The best answer to the question “Why does the speaker recommend watching the program?” is (D), “It will help with course work.” Therefore, the correct choice is (D).</div>
                                            </div>
                                        @endif

                                        <div class="mt-5 flex justify-center">
                                            <button
                                                type="button"
                                                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gray-900 hover:bg-black text-white font-semibold transition-colors"
                                                data-part-begin-btn="{{ $partKey }}"
                                            >
                                                Begin Part {{ $partKey }} Questions
                                            </button>
                                        </div>
                                    </div>
                                </header>

                                <div class="p-0 md:p-0 space-y-8" data-part-questions-body="{{ $partKey }}">
                                    @foreach($partQuestions as $question)
                                        @if(in_array($question['number'], [31, 35, 39, 43, 47]))
                                            <div class="mt-5 hidden" data-dialog-intro-body="{{ $question['number'] }}">
                                                <div style="background:#fff; border-radius:1.5rem; box-shadow:0 2px 16px 0 rgba(16,24,40,0.08); border:1.5px solid #f3f4f6; padding:3rem 2.2rem; max-width:640px; margin:2.5rem auto 0 auto; text-align:center; min-height:400px; display:flex; flex-direction:column; justify-content:center; align-items:center;">
                                                    @php 
                                                        $endQ = $question['number'] + 3; 
                                                        $isPartB = $question['number'] < 39;
                                                    @endphp
                                                    <div style="font-size:1.8rem; font-weight:700; color:#008080; margin-bottom:1rem; letter-spacing:0.01em;">Part {{ $isPartB ? 'B' : 'C' }}</div>
                                                    <div style="font-size:1.4rem; font-weight:700; margin-bottom:2.2rem; color:#111;">Questions {{ $question['number'] }} - {{ $endQ }}</div>
                                                    <div style="font-size:1.13rem; line-height:1.62; margin-bottom:2.5rem; color:#444;">Please listen to the following audio before proceeding to questions {{ $question['number'] }} through {{ $endQ }}.</div>
                                                    
                                                    @if(!empty($question['audio_file']))
                                                        <audio controls id="audio-dialog-{{ $question['number'] }}" style="width:100%; max-width:480px;">
                                                            <source src="{{ asset($question['audio_file']) }}" type="audio/mpeg">
                                                        </audio>
                                                    @else
                                                        @php $isAdmin = auth()->check() && auth()->user()->isAdmin(); @endphp
                                                        @if($isAdmin)
                                                            <div class="w-full max-w-md bg-red-50 border border-red-200 rounded-xl p-4 text-red-700 text-sm text-center font-medium flex flex-col items-center gap-3">
                                                                <span>Audio dialog untuk soal {{ $question['number'] }}-{{ $endQ }} belum diunggah.</span>
                                                                <button type="button" style="background:#dc2626; color:#fff; font-weight:600; border:none; border-radius:0.4rem; padding:0.4rem 0.8rem; cursor:pointer; font-size:0.85rem;" onclick="openAudioModal({{ $question['id'] }}, {{ $question['number'] }})">Unggah Audio</button>
                                                            </div>
                                                        @else
                                                            <div class="w-full max-w-md bg-gray-50 border border-gray-200 rounded-xl p-4 text-gray-500 text-sm text-center font-medium">
                                                                Audio is currently unavailable.
                                                            </div>
                                                        @endif
                                                    @endif
                                                    <button type="button" class="mt-8 inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gray-900 hover:bg-black text-white font-semibold transition-colors" data-dialog-begin-btn="{{ $question['number'] }}">
                                                        Mulai Soal {{ $question['number'] }}
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <article id="question-{{ $question['number'] }}" data-question-number="{{ $question['number'] }}" style="background:#fff; border-radius:1.5rem; box-shadow:0 2px 16px 0 rgba(16,24,40,0.08); border:1.5px solid #f3f4f6; padding:2.2rem 2.2rem 2.2rem 2.2rem; max-width:540px; margin:2.5rem auto 0 auto;">
                                            @php $isAdmin = auth()->check() && auth()->user()->isAdmin(); @endphp
                                            @if($isAdmin)
                                                <div style="display:flex; flex-wrap:wrap; align-items:center; gap:0.8rem; margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px solid #e5e7eb;">
                                                    <div style="display:flex; gap:0.5rem;">
                                                        @if(!empty($question['audio_file']))
                                                            <span style="padding:0.25rem 0.6rem; border-radius:1rem; font-size:0.85rem; font-weight:600; background:#bbf7d0; color:#166534;">&#10003; Audio</span>
                                                        @else
                                                            <span style="padding:0.25rem 0.6rem; border-radius:1rem; font-size:0.85rem; font-weight:600; background:#fee2e2; color:#b91c1c;">&#10005; Audio</span>
                                                        @endif
                                                        @if(!empty($question['transcript_en']) || !empty($question['transcript_id']))
                                                            <span style="padding:0.25rem 0.6rem; border-radius:1rem; font-size:0.85rem; font-weight:600; background:#bbf7d0; color:#166534;">&#10003; SRT</span>
                                                        @else
                                                            <span style="padding:0.25rem 0.6rem; border-radius:1rem; font-size:0.85rem; font-weight:600; background:#fee2e2; color:#b91c1c;">&#10005; SRT</span>
                                                        @endif
                                                        @if(!empty($question['answer']))
                                                            <span style="padding:0.25rem 0.6rem; border-radius:1rem; font-size:0.85rem; font-weight:600; background:#bbf7d0; color:#166534;">&#10003; Kunci</span>
                                                        @else
                                                            <span style="padding:0.25rem 0.6rem; border-radius:1rem; font-size:0.85rem; font-weight:600; background:#fee2e2; color:#b91c1c;">&#10005; Kunci</span>
                                                        @endif
                                                    </div>
                                                    
                                                    <audio controls preload="none" style="height:2rem; flex:1; min-width:200px;" @if(empty($question['audio_file'])) disabled @endif>
                                                        @if(!empty($question['audio_file']))
                                                            <source src="{{ asset($question['audio_file']) }}" type="audio/mpeg">
                                                        @endif
                                                    </audio>

                                                    <div style="display:flex; gap:0.4rem;">
                                                        <button style="background:#a21caf; color:#fff; font-weight:600; border:none; border-radius:0.4rem; padding:0.4rem 0.8rem; cursor:pointer; font-size:0.85rem;" onclick="openSrtModal({{ $question['id'] }}, {{ $question['number'] }})">SRT</button>
                                                        <button style="background:#dc2626; color:#fff; font-weight:600; border:none; border-radius:0.4rem; padding:0.4rem 0.8rem; cursor:pointer; font-size:0.85rem;" onclick="openAudioModal({{ $question['id'] }}, {{ $question['number'] }})">Audio</button>
                                                        <button style="background:#059669; color:#fff; font-weight:600; border:none; border-radius:0.4rem; padding:0.4rem 0.8rem; cursor:pointer; font-size:0.85rem;" onclick="updateKunci({{ $question['id'] }}, {{ $question['number'] }}, '{{ $question['answer'] }}')">Kunci</button>
                                                    </div>
                                                </div>
                                            @endif
                                            <div style="display:flex; align-items:flex-start; gap:1.1rem;">
                                                <span style="display:inline-flex; align-items:center; justify-content:center; min-width:2.3rem; height:2.3rem; border-radius:999px; background:#ffe7b2; color:#b45309; font-weight:700; font-size:1.15rem; box-shadow:0 1px 4px 0 rgba(255,193,7,0.08);">{{ $question['number'] }}</span>
                                                <div style="flex:1;">
                                                    <div style="font-size:1.13rem; font-weight:700; color:#222; margin-bottom:1.1rem;">{{ $question['question'] }}</div>
                                                    <div style="display:flex; flex-direction:column; gap:1.1rem;">
                                                        @foreach(['A', 'B', 'C', 'D'] as $choice)
                                                            <label class="mockup-option-label block w-full cursor-pointer option-card" data-question="{{ $question['number'] }}" data-choice="{{ $choice }}" style="margin-bottom: 12px;">
                                                                <input type="radio"
                                                                       name="q{{ $question['number'] }}"
                                                                       value="{{ $choice }}"
                                                                       class="sr-only"
                                                                       required>
                                                                <div class="mockup-option-card flex items-center p-4 bg-white border border-gray-200 rounded-2xl shadow-sm" style="border-width: 1.5px;">
                                                                    <div class="mockup-option-badge flex-shrink-0 flex items-center justify-center w-9 h-9 rounded-full border-2 border-gray-300 text-gray-500 font-bold text-sm mr-4">
                                                                        {{ $choice }}
                                                                    </div>
                                                                    <span class="mockup-option-text text-gray-700 text-lg select-none leading-snug" style="line-height: 1.4;">{{ $question[$choice] }}</span>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    
                                                    <!-- Tombol Next di bawah soal -->
                                                    <div class="mt-8 flex justify-end">
                                                        <button 
                                                            type="button" 
                                                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-900 hover:bg-black text-white font-semibold transition-colors shadow-sm"
                                                            onclick="document.getElementById('nextQuestionBtn').click()"
                                                        >
                                                            Selanjutnya
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @endforeach

                    <!-- Tombol Simpan & Nilai Listening dihilangkan sesuai permintaan -->
                @endif
            </div>
        </section>
    </div>

    <script>
        // Audio auto-play logic
        function playDirectionAudio(partKey) {
            var audio = document.getElementById('audio-direction-' + partKey);
            if (audio) {
                audio.currentTime = 0;
                audio.play().catch(function(){});
            }
        }
        (function() {
            const dbAnswerKey = @json($dbAnswerKey);
            const customAnswerKey = @json($packageAnswerKey ?? []);
            const submitUrl = @json($packageSectionSubmitUrl ?? null);
            const structureRedirectUrl = @json($structureRedirectUrl);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            let isSubmittingListening = false;

            const getAnswerForQuestion = (number) => {
                const qKey = `q${number}`;
                const raw = customAnswerKey[qKey] ?? customAnswerKey[String(number)] ?? dbAnswerKey[qKey] ?? '';
                return String(raw || '').trim().toUpperCase();
            };

            const allQuestionNumbers = Array.from(document.querySelectorAll('input[type="radio"][name^="q"]'))
                .map((el) => Number(String(el.name).replace('q', '')))
                .filter((n) => Number.isInteger(n) && n > 0)
                .filter((value, index, self) => self.indexOf(value) === index)
                .sort((a, b) => a - b);

            const questionCards = Array.from(document.querySelectorAll('[data-question-number]'));
            const partSections = Array.from(document.querySelectorAll('[data-part-section]'));
            const partIntroBodies = Array.from(document.querySelectorAll('[data-part-intro-body]'));
            const partQuestionsBodies = Array.from(document.querySelectorAll('[data-part-questions-body]'));
            const partBeginButtons = Array.from(document.querySelectorAll('[data-part-begin-btn]'));
            const partJumpButtons = Array.from(document.querySelectorAll('[data-part-jump]'));
            const dialogJumpButtons = Array.from(document.querySelectorAll('[data-dialog-jump]'));
            const dialogBeginButtons = Array.from(document.querySelectorAll('[data-dialog-begin-btn]'));
            const jumpButtons = Array.from(document.querySelectorAll('[data-question-jump]'));
            const prevQuestionBtn = document.getElementById('prevQuestionBtn');
            const nextQuestionBtn = document.getElementById('nextQuestionBtn');
            const activeQuestionLabel = document.getElementById('activeQuestionLabel');

            const partFirstQuestion = { A: 1, B: 31, C: 39 };
            const orderedParts = ['A', 'B', 'C'];
            let introSeenByPart = { A: false, B: false, C: false };
            let showingPartIntro = true;
            
            const dialogGroups = [
                { start: 31, end: 34 },
                { start: 35, end: 38 },
                { start: 39, end: 42 },
                { start: 43, end: 46 },
                { start: 47, end: 50 }
            ];
            let dialogSeen = { 31: false, 35: false, 39: false, 43: false, 47: false };
            let showingDialogIntro = false;
            let activeDialogStart = null;
            const dialogIntroBodies = Array.from(document.querySelectorAll('[data-dialog-intro-body]'));

            const partByQuestion = (number) => {
                if (number <= 30) return 'A';
                if (number <= 38) return 'B';
                return 'C';
            };

            let activeQuestionIndex = 0;

            const paintPaginatorState = () => {
                const activeNumber = allQuestionNumbers[activeQuestionIndex] ?? null;
                const activePart = activeNumber ? partByQuestion(activeNumber) : null;
                showingPartIntro = Boolean(activePart) && !introSeenByPart[activePart];

                const activeGroup = dialogGroups.find(g => activeNumber >= g.start && activeNumber <= g.end);
                activeDialogStart = activeGroup ? activeGroup.start : null;
                showingDialogIntro = !showingPartIntro && activeDialogStart !== null && activeNumber === activeDialogStart && !dialogSeen[activeDialogStart];

                questionCards.forEach((card) => {
                    const num = Number(card.dataset.questionNumber || 0);
                    card.classList.toggle('hidden', showingPartIntro || showingDialogIntro || num !== activeNumber);
                });

                partSections.forEach((section) => {
                    section.classList.toggle('hidden', section.dataset.partSection !== activePart);
                });

                dialogIntroBodies.forEach((intro) => {
                    const isActive = showingDialogIntro && Number(intro.dataset.dialogIntroBody) === activeDialogStart;
                    intro.classList.toggle('hidden', !isActive);
                    if (isActive) {
                        const audio = document.getElementById('audio-dialog-' + activeDialogStart);
                        if (audio) { audio.currentTime = 0; audio.play().catch(()=>{}); }
                    } else {
                        const audio = document.getElementById('audio-dialog-' + intro.dataset.dialogIntroBody);
                        if (audio && !audio.paused) { audio.pause(); }
                    }
                });

                partIntroBodies.forEach((intro) => {
                    const isActive = intro.dataset.partIntroBody === activePart && showingPartIntro;
                    intro.classList.toggle('hidden', !isActive);
                    // Auto-play direction audio when direction page shown
                    if (isActive) {
                        playDirectionAudio(activePart);
                    }
                });

                partQuestionsBodies.forEach((body) => {
                    // NOTE: do NOT hide this wrapper when showingDialogIntro, because
                    // dialogIntroBodies live inside this wrapper and need the parent visible.
                    body.classList.toggle('hidden', body.dataset.partQuestionsBody !== activePart || showingPartIntro);
                });


                // Only highlight chip PART X when direction is active, not the question number
                partJumpButtons.forEach((btn) => {
                    const part = String(btn.dataset.partJump || '').toUpperCase();
                    btn.classList.toggle('is-active', part === activePart && showingPartIntro);
                });

                // Only highlight question number when not showing direction
                jumpButtons.forEach((btn) => {
                    const num = Number(btn.dataset.questionJump || 0);
                    btn.classList.toggle('is-active', num === activeNumber && !showingPartIntro && !showingDialogIntro);
                });

                dialogJumpButtons.forEach((btn) => {
                    const startNum = Number(btn.dataset.dialogJump || 0);
                    btn.classList.toggle('is-active', showingDialogIntro && activeDialogStart === startNum);
                });

                if (activeQuestionLabel && activeNumber) {
                    if (showingPartIntro) {
                        activeQuestionLabel.textContent = `Part ${activePart} Directions`;
                    } else if (showingDialogIntro) {
                        const activeGroup = dialogGroups.find(g => activeNumber >= g.start && activeNumber <= g.end);
                        activeQuestionLabel.textContent = `Audio Dialog for Questions ${activeGroup.start}-${activeGroup.end}`;
                    } else {
                        activeQuestionLabel.textContent = `Question ${activeNumber}/${allQuestionNumbers.length} • Part ${activePart}`;
                    }
                }

                if (prevQuestionBtn) {
                    const disablePrev = showingPartIntro
                        ? activePart === 'A'
                        : (activeQuestionIndex === 0 && !showingDialogIntro);

                    prevQuestionBtn.disabled = disablePrev;
                    prevQuestionBtn.classList.toggle('opacity-50', disablePrev);
                    prevQuestionBtn.classList.toggle('cursor-not-allowed', disablePrev);
                }

                if (nextQuestionBtn) {
                    const disableNext = false;
                    const activeNumber = allQuestionNumbers[activeQuestionIndex] ?? null;
                    const isLastQuestion = !showingPartIntro && activeNumber === allQuestionNumbers[allQuestionNumbers.length - 1];

                    nextQuestionBtn.textContent = isLastQuestion ? 'Finish' : 'Next';

                    nextQuestionBtn.disabled = disableNext;
                    nextQuestionBtn.classList.toggle('opacity-50', disableNext);
                    nextQuestionBtn.classList.toggle('cursor-not-allowed', disableNext);
                }
            };

            const goToQuestionByIndex = (newIndex) => {
                if (!allQuestionNumbers.length) return;
                const safeIndex = Math.max(0, Math.min(newIndex, allQuestionNumbers.length - 1));
                activeQuestionIndex = safeIndex;
                paintPaginatorState();

                const activeNumber = allQuestionNumbers[activeQuestionIndex];
                const card = document.getElementById(`question-${activeNumber}`);
                if (card) {
                    card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };

            window.goToQuestionByIndex = goToQuestionByIndex;

            const goToDialogIntro = (startNum) => {
                const targetIndex = allQuestionNumbers.indexOf(startNum);
                if (targetIndex >= 0) {
                    activeQuestionIndex = targetIndex;
                    const activePart = partByQuestion(startNum);
                    introSeenByPart[activePart] = true;
                    dialogSeen[startNum] = false;
                    paintPaginatorState();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            };

            const goToPartIntro = (part) => {
                if (!['A', 'B', 'C'].includes(part)) return;
                const firstQuestion = partFirstQuestion[part];
                const targetIndex = allQuestionNumbers.indexOf(firstQuestion);
                if (targetIndex < 0) return;

                introSeenByPart[part] = false;
                goToQuestionByIndex(targetIndex);
            };

            if (allQuestionNumbers.length > 0) {
                paintPaginatorState();

                if (prevQuestionBtn) {
                    prevQuestionBtn.addEventListener('click', () => {
                        const activeNumber = allQuestionNumbers[activeQuestionIndex] ?? 1;
                        const activePart = partByQuestion(activeNumber);

                        if (showingPartIntro) {
                            const currentPartIndex = orderedParts.indexOf(activePart);
                            const prevPart = currentPartIndex > 0 ? orderedParts[currentPartIndex - 1] : null;
                            if (prevPart) {
                                goToPartIntro(prevPart);
                            }
                            return;
                        }

                        if (showingDialogIntro) {
                            if (activeNumber === partFirstQuestion[activePart]) {
                                introSeenByPart[activePart] = false;
                                paintPaginatorState();
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            } else {
                                goToQuestionByIndex(activeQuestionIndex - 1);
                            }
                            return;
                        }

                        const activeGroup = dialogGroups.find(g => activeNumber >= g.start && activeNumber <= g.end);
                        if (activeGroup && activeNumber === activeGroup.start) {
                            dialogSeen[activeGroup.start] = false;
                            paintPaginatorState();
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            return;
                        }

                        if (activeNumber === partFirstQuestion[activePart]) {
                            introSeenByPart[activePart] = false;
                            paintPaginatorState();
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            return;
                        }

                        goToQuestionByIndex(activeQuestionIndex - 1);
                    });
                }

                if (nextQuestionBtn) {
                    nextQuestionBtn.addEventListener('click', () => {
                        const activeNumber = allQuestionNumbers[activeQuestionIndex] ?? 1;
                        const activePart = partByQuestion(activeNumber);

                        if (showingPartIntro) {
                            const currentPartIndex = orderedParts.indexOf(activePart);
                            const nextPart = currentPartIndex >= 0 && currentPartIndex < orderedParts.length - 1
                                ? orderedParts[currentPartIndex + 1]
                                : null;

                            if (nextPart) {
                                goToPartIntro(nextPart);
                            } else {
                                introSeenByPart[activePart] = true;
                                paintPaginatorState();
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            }

                            return;
                        }

                        if (showingDialogIntro) {
                            dialogSeen[activeDialogStart] = true;
                            paintPaginatorState();
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            return;
                        }

                        if (activeQuestionIndex >= allQuestionNumbers.length - 1) {
                            submitListeningSection();
                            return;
                        }

                        goToQuestionByIndex(activeQuestionIndex + 1);
                    });
                }

                jumpButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const target = Number(btn.dataset.questionJump || 0);
                        const targetIndex = allQuestionNumbers.indexOf(target);
                        if (targetIndex >= 0) {
                            const group = dialogGroups.find(g => target >= g.start && target <= g.end);
                            if (group) {
                                dialogSeen[group.start] = true;
                            }
                            const activePart = partByQuestion(target);
                            introSeenByPart[activePart] = true;
                            goToQuestionByIndex(targetIndex);
                        }
                    });
                });

                partBeginButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const part = String(btn.dataset.partBeginBtn || '').toUpperCase();
                        if (!['A', 'B', 'C'].includes(part)) return;

                        introSeenByPart[part] = true;
                        paintPaginatorState();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                });

                partJumpButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const part = String(btn.dataset.partJump || '').toUpperCase();
                        if (!['A', 'B', 'C'].includes(part)) return;
                        goToPartIntro(part);
                    });
                });

                dialogJumpButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const target = Number(btn.dataset.dialogJump || 0);
                        goToDialogIntro(target);
                    });
                });

                dialogBeginButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const target = Number(btn.dataset.dialogBeginBtn || 0);
                        const targetIndex = allQuestionNumbers.indexOf(target);
                        if (targetIndex >= 0) {
                            dialogSeen[target] = true;
                            goToQuestionByIndex(targetIndex);
                        }
                    });
                });
            }

            const readAnswer = (number) => {
                const selected = document.querySelector(`input[name="q${number}"]:checked`);
                return String(selected?.value || '').trim().toUpperCase();
            };

            const collectAnswersPayload = () => {
                const payload = {};
                allQuestionNumbers.forEach((num) => {
                    payload[`q${num}`] = readAnswer(num);
                });
                return payload;
            };

            const submitListeningSection = async () => {
                if (isSubmittingListening) {
                    return false;
                }

                if (!submitUrl) {
                    alert('Endpoint penyimpanan tidak tersedia.');
                    return false;
                }

                const lastQuestionNumber = allQuestionNumbers[allQuestionNumbers.length - 1];
                if (lastQuestionNumber && readAnswer(lastQuestionNumber) === '') {
                    alert(`Pilih jawaban untuk soal nomor ${lastQuestionNumber} sebelum melanjutkan.`);
                    return false;
                }

                isSubmittingListening = true;

                let correct = 0;
                const wrong = [];

                resetVisualStates();

                allQuestionNumbers.forEach((qNum) => {
                    const user = readAnswer(qNum);
                    const expected = getAnswerForQuestion(qNum);
                    const ok = user !== '' && expected !== '' && user === expected;

                    if (ok) {
                        correct += 1;
                    } else {
                        wrong.push(qNum);
                    }

                    paintQuestion(qNum, ok);
                });

                const totalQuestions = allQuestionNumbers.length;

                try {
                    const response = await fetch(submitUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            score: correct,
                            total_questions: totalQuestions,
                            wrong_numbers: wrong,
                            answers: collectAnswersPayload(),
                        }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }

                    window.location.href = structureRedirectUrl;
                    return true;
                } catch (error) {
                    isSubmittingListening = false;
                    alert('Gagal menyimpan jawaban listening. Silakan coba lagi.');
                    console.error(error);
                    return false;
                }
            };

            const resetVisualStates = () => {
                document.querySelectorAll('.option-card').forEach((el) => {
                    el.style.borderColor = '#e5e7eb';
                    el.style.background = '#fff';
                });
            };

            const paintQuestion = (number, isCorrect) => {
                const selected = document.querySelector(`input[name="q${number}"]:checked`);
                const label = selected ? selected.closest('.option-card') : null;
                if (!label) return;
                // Highlight like mockup: border and subtle bg
                if (isCorrect) {
                    label.style.borderColor = '#22c55e';
                    label.style.background = '#f0fdf4';
                } else {
                    label.style.borderColor = '#ef4444';
                    label.style.background = '#fef2f2';
                }
            };

            const submitButton = document.getElementById('submitListeningAnswersBtn');
            if (submitButton) {
                submitButton.addEventListener('click', () => {
                    submitListeningSection();
                });
            }

            // Auto-submit when all questions are answered
            const radioInputs = document.querySelectorAll('input[type="radio"][name^="q"]');
            radioInputs.forEach(radio => {
                radio.addEventListener('change', () => {
                    const allAnswered = allQuestionNumbers.every(num => readAnswer(num) !== '');
                    if (allAnswered && allQuestionNumbers.length > 0) {
                        submitListeningSection();
                    }
                });
            });
        })();
    </script>

    @if(auth()->check() && auth()->user()->isAdmin())
        <div id="adminSrtModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-2xl w-full max-w-md mx-4 shadow-xl">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Upload SRT (No <span id="srtQuestionNum"></span>)</h3>
                <form id="srtUploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 font-semibold text-gray-700">SRT / TXT File</label>
                        <input type="file" name="srt_file" class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" accept=".srt,.txt" required>
                    </div>
                    <div class="mb-5">
                        <label class="block mb-2 font-semibold text-gray-700">Language</label>
                        <select name="language" class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
                            <option value="en">English</option>
                            <option value="id">Indonesian</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded font-semibold transition" onclick="document.getElementById('adminSrtModal').classList.add('hidden')">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold transition">Upload</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="adminAudioModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-2xl w-full max-w-md mx-4 shadow-xl">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Upload Audio (No <span id="audioQuestionNum"></span>)</h3>
                <form id="audioUploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <label class="block mb-2 font-semibold text-gray-700">Audio File</label>
                        <input type="file" name="audio_file" class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" accept=".mp3,.wav,.ogg,.m4a" required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded font-semibold transition" onclick="document.getElementById('adminAudioModal').classList.add('hidden')">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold transition">Upload</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function updateKunci(questionId, questionNum, currentAnswer) {
                const answer = prompt(`Masukkan Kunci Jawaban (A/B/C/D) untuk soal No ${questionNum}:`, currentAnswer || '');
                if (answer === null) return;
                const cleanAnswer = answer.trim().toUpperCase();
                if (!['A','B','C','D'].includes(cleanAnswer)) {
                    alert('Jawaban tidak valid, harus A, B, C, atau D');
                    return;
                }
                
                fetch(`/assignments/toefl-itp/mockup/package/{{ $test['package_number'] ?? 1 }}/question/${questionId}/update-answer`, {
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
                        alert('Gagal memperbarui kunci: ' + (data.message || 'Error'));
                    }
                }).catch(err => {
                    alert('Terjadi kesalahan jaringan.');
                    console.error(err);
                });
            }

            function openSrtModal(questionId, questionNum) {
                document.getElementById('srtQuestionNum').textContent = questionNum;
                document.getElementById('srtUploadForm').action = `/assignments/toefl-itp/mockup/package/{{ $test['package_number'] ?? 1 }}/question/${questionId}/upload-srt`;
                document.getElementById('adminSrtModal').classList.remove('hidden');
            }

            function openAudioModal(questionId, questionNum) {
                document.getElementById('audioQuestionNum').textContent = questionNum;
                document.getElementById('audioUploadForm').action = `/assignments/toefl-itp/mockup/package/{{ $test['package_number'] ?? 1 }}/question/${questionId}/upload-audio`;
                document.getElementById('adminAudioModal').classList.remove('hidden');
            }
        </script>
    @endif
    <!-- Section Navigation -->
    <div class="fixed bottom-8 right-8 flex flex-col md:flex-row gap-3 z-50">
        <a href="{{ $listeningUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'listening']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ 'listening' === 'listening' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600' }}">
            Section 1: Listening
        </a>
        <a href="{{ $structureRedirectUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'structure']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ 'listening' === 'structure' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600' }}">
            Section 2: Structure
        </a>
        <a href="{{ $readingRedirectUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'reading']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ 'listening' === 'reading' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600' }}">
            Section 3: Reading
        </a>
    </div>

        </main>
    </div>
</body>

</html>
