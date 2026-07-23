
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['label'] ?? 'TOEFL ITP' }} Structure - Paket {{ $test['package_number'] ?? 1 }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #f8fafc !important;
        }

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

        $structureQuestions = \App\Models\ToeflMockupQuestion::query()
            ->where('section', 'structure')
            ->where('package_number', $packageNumber)
            ->orderBy('question_number')
            ->get()
            ->map(function ($q) {
                $number = (int) $q->question_number;
                $partVal = strtoupper((string) ($q->part ?? ''));
                $resolvedPart = 'A';
                if ($partVal === 'STRUCTURE' || $partVal === 'A') {
                    $resolvedPart = 'A';
                } elseif ($partVal === 'WRITTEN EXPRESSION' || $partVal === 'B') {
                    $resolvedPart = 'B';
                } else {
                    $resolvedPart = $number <= 15 ? 'A' : 'B';
                }

                return [
                    'id' => $q->id,
                    'number' => $number,
                    'part' => $resolvedPart,
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

        $structureQuestionsOnly = array_values(array_filter($structureQuestions, fn ($q) => $q['part'] === 'A'));
        $writtenQuestionsOnly = array_values(array_filter($structureQuestions, fn ($q) => $q['part'] === 'B'));
        $structureCount = count($structureQuestionsOnly);

        $dbAnswerKey = [];
        foreach ($structureQuestions as $q) {
            $dbAnswerKey['q' . $q['number']] = $q['answer'];
        }

        $latestScore = is_array($latestPackageSectionResult?->evaluation_data ?? null)
            ? ($latestPackageSectionResult->evaluation_data['score_correct'] ?? null)
            : null;

        $latestTotal = is_array($latestPackageSectionResult?->evaluation_data ?? null)
            ? ($latestPackageSectionResult->evaluation_data['score_total'] ?? null)
            : null;

        $readingRedirectUrl = route('online-test.package-section', [
            'slugAlias' => $slugAlias ?? 'toefl-itp',
            'package' => $packageNumber,
            'section' => 'reading',
        ]);

        $listeningUrl = route('online-test.package-section', [
            'slugAlias' => $slugAlias ?? 'toefl-itp',
            'package' => $packageNumber,
            'section' => 'listening',
        ]);

        if (!function_exists('renderWrittenExpression')) {
            function renderWrittenExpression($text, $number, $questionId) {
                $optionLetters = ['A', 'B', 'C', 'D'];
                $count = 0;

                // Split into plain text + **marked** tokens
                $parts = preg_split('/(\*\*.*?\*\*)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

                $html = '';
                foreach ($parts as $part) {
                    if (preg_match('/^\*\*(.*?)\*\*$/', $part, $m)) {
                        $letter = $optionLetters[$count] ?? 'X';
                        $count++;
                        $word = htmlspecialchars(trim($m[1]), ENT_QUOTES);
                        // Circle badge style for letter
                        $circleBadge = '<span class="we-badge" style="'
                            . 'display:inline-flex; align-items:center; justify-content:center;'
                            . 'width:22px; height:22px; border-radius:50%;'
                            . 'border:2px solid #9ca3af; background:#fff;'
                            . 'font-size:0.72rem; font-weight:700; font-family:monospace;'
                            . 'color:#6b7280; margin-top:3px;'
                            . 'transition:background 0.15s, border-color 0.15s, color 0.15s;">'
                            . $letter
                            . '</span>';
                        $html .= '<label data-qid="' . $questionId . '" data-opt="' . $letter . '" style="'
                            . 'display:inline-flex; flex-direction:column; align-items:center;'
                            . 'cursor:pointer; margin:0 3px; vertical-align:top; line-height:1.3;">'
                            . '<input type="radio" name="q' . $number . '" value="' . $letter . '" '
                            . 'style="position:absolute;opacity:0;width:1px;height:1px;" required>'
                            . '<span class="we-word" style="'
                            . 'border-bottom:2.5px solid #1f2937; padding:0 3px 1px; display:block;'
                            . 'transition:border-color 0.15s, background 0.15s;">'
                            . $word
                            . '</span>'
                            . $circleBadge
                            . '</label>';
                    } else {
                        $html .= '<span style="vertical-align:top; line-height:1.3; display:inline-block;">'
                            . htmlspecialchars($part, ENT_QUOTES)
                            . '</span>';
                    }
                }

                // JS: on radio change → reset all, highlight selected (red circle + red underline)
                $html .= '<script>
        (function(){
            var labels = document.querySelectorAll("label[data-qid=\"' . $questionId . '\"]");
            labels.forEach(function(lbl){
                lbl.addEventListener("change", function(){
                    labels.forEach(function(l){
                        l.querySelector(".we-word").style.borderBottomColor = "#1f2937";
                        l.querySelector(".we-word").style.background = "";
                        var b = l.querySelector(".we-badge");
                        b.style.background = "#fff";
                        b.style.borderColor = "#9ca3af";
                        b.style.color = "#6b7280";
                    });
                    var selWord = lbl.querySelector(".we-word");
                    selWord.style.borderBottomColor = "#dc2626";
                    selWord.style.background = "#fef2f2";
                    var selBadge = lbl.querySelector(".we-badge");
                    selBadge.style.background = "#dc2626";
                    selBadge.style.borderColor = "#dc2626";
                    selBadge.style.color = "#fff";
                });
            });
        })();
        </script>';

                return $html;
            }
        }
    @endphp

    <script>
        window._structureData = {
            dbAnswerKey:    @json($dbAnswerKey),
            customAnswerKey: @json($packageAnswerKey ?? []),
            submitUrl:      @json($packageSectionSubmitUrl ?? null),
            redirectUrl:    @json($readingRedirectUrl)
        };
    </script>

       <div class="max-w-4xl mx-auto px-4 py-8 pb-32" x-data="{
        currentSection: 'instructions', // 'instructions', 'questions'
        currentStructureIndex: 0,
        showWrittenDir: false,
        structureCountdown: 1500, // 25 minutes
        structureTimer: null,
        isSubmitting: false,
        startStructureTimer() {
            if (this.structureTimer) return;
            this.structureTimer = setInterval(() => {
                if (this.structureCountdown > 0) {
                    this.structureCountdown--;
                } else {
                    clearInterval(this.structureTimer);
                    this.submitStructureSection();
                }
            }, 1000);
        },
        formatStructureTime() {
            const m = Math.floor(this.structureCountdown / 60).toString().padStart(2, '0');
            const s = (this.structureCountdown % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        },
        readAnswer(num) {
            const checked = document.querySelector(`input[type='radio'][name='q${num}']:checked`);
            return checked ? checked.value : '';
        },
        collectAnswersPayload() {
            const payload = {};
            for (let i = 1; i <= 40; i++) {
                payload[`q${i}`] = this.readAnswer(i);
            }
            return payload;
        },
        submitStructureSection() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;

            const dbAnswerKey    = window._structureData.dbAnswerKey;
            const customAnswerKey = window._structureData.customAnswerKey;
            const submitUrl      = window._structureData.submitUrl;
            const csrfToken = document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '';

            const getAnswerForQuestion = (number) => {
                const qKey = `q${number}`;
                const raw = customAnswerKey[qKey] ?? customAnswerKey[String(number)] ?? dbAnswerKey[qKey] ?? '';
                return String(raw || '').trim().toUpperCase();
            };

            let correct = 0;
            const wrong = [];
            for (let i = 1; i <= 40; i++) {
                const user = this.readAnswer(i);
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
                    total_questions: 40,
                    wrong_numbers: wrong,
                    answers: this.collectAnswersPayload()
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('HTTP error');
                return response.json();
            })
            .then(data => {
                window.location.href = window._structureData.redirectUrl;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menyambung ke server.');
                this.isSubmitting = false;
            });
        }
    }" x-init="
        $watch('currentSection', value => { if(value === 'questions') startStructureTimer() });
    ">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Structure Practice - Paket {{ $packageNumber }}</h1>
                        <p class="text-gray-600 mt-1">Section 2: Structure and Written Expression</p>
                    </div>
                </div>
                
                <a href="{{ route('online-test.show', ['slug' => $slugAlias ?? 'toefl-itp']) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to TOEFL ITP
                </a>
            </div>
        </div>

        <!-- Navigation Panel (matches mockup layout) -->
        <div class="mb-6 rounded-xl border border-amber-300 bg-amber-50 p-3" x-data="{ devOpen: true }">
            <div class="flex items-center gap-2 mb-2 cursor-pointer select-none" @click="devOpen = !devOpen">
                <span class="text-xs font-bold text-amber-700 uppercase tracking-widest">🛠 Dev Nav</span>
                <span class="ml-auto text-amber-500 text-xs" x-text="devOpen ? '▲ hide' : '▼ show'"></span>
            </div>
            <div x-show="devOpen" class="space-y-2">
                <!-- Section row -->
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-xs font-semibold text-amber-700 w-16 flex-shrink-0">Section:</span>
                    <a href="{{ $listeningUrl }}"
                        class="px-3 py-1 text-xs font-bold rounded-lg border transition bg-white text-red-700 border-red-300 hover:bg-red-50">
                        1 · Listening
                    </a>
                    <span class="px-3 py-1 text-xs font-bold rounded-lg border bg-indigo-600 text-white border-indigo-600 cursor-default">
                        2 · Structure
                    </span>
                    <a href="{{ $readingRedirectUrl }}"
                        class="px-3 py-1 text-xs font-bold rounded-lg border transition bg-white text-amber-700 border-amber-300 hover:bg-amber-50">
                        3 · Reading
                    </a>
                </div>

                <!-- Structure question row -->
                <div class="flex flex-wrap gap-1 items-center">
                    <span class="text-xs font-semibold text-amber-700 w-16 flex-shrink-0">Structure:</span>

                    {{-- Part A pill + Questions 1-15 --}}
                    <button type="button"
                        @click="currentSection = 'instructions'; showWrittenDir = false; window.scrollTo(0,0)"
                        :class="currentSection === 'instructions' && !showWrittenDir ? 'bg-amber-400 text-amber-900 border-amber-400' : 'bg-amber-100 text-amber-800 border-amber-200 hover:bg-amber-200'"
                        class="px-2 py-1 text-xs font-semibold rounded-md border transition">
                        Part A
                    </button>

                    @foreach($structureQuestionsOnly as $idx => $q)
                        <button type="button"
                            @click="currentSection = 'questions'; currentStructureIndex = {{ $idx }}; showWrittenDir = false; window.scrollTo(0,0)"
                            :class="currentSection === 'questions' && currentStructureIndex === {{ $idx }} && !showWrittenDir ? 'bg-indigo-600 text-white ring-2 ring-indigo-300 border-indigo-600' : 'bg-white text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 border-gray-200'"
                            class="w-8 h-8 rounded-lg border text-xs font-bold transition flex items-center justify-center">
                            {{ $q['number'] }}
                        </button>
                    @endforeach

                    {{-- Part B pill + Questions 16-40 --}}
                    <button type="button"
                        @click="currentSection = 'questions'; currentStructureIndex = {{ $structureCount }}; showWrittenDir = true; window.scrollTo(0,0)"
                        :class="currentSection === 'questions' && showWrittenDir ? 'bg-amber-400 text-amber-900 border-amber-400' : 'bg-amber-100 text-amber-800 border-amber-200 hover:bg-amber-200'"
                        class="px-2 py-1 text-xs font-semibold rounded-md border transition">
                        Part B
                    </button>

                    @foreach($writtenQuestionsOnly as $wIdx => $q)
                        @php $absIdx = $structureCount + $wIdx; @endphp
                        <button type="button"
                            @click="currentSection = 'questions'; currentStructureIndex = {{ $absIdx }}; showWrittenDir = false; window.scrollTo(0,0)"
                            :class="currentSection === 'questions' && currentStructureIndex === {{ $absIdx }} && !showWrittenDir ? 'bg-indigo-600 text-white ring-2 ring-indigo-300 border-indigo-600' : 'bg-white text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 border-gray-200'"
                            class="w-8 h-8 rounded-lg border text-xs font-bold transition flex items-center justify-center">
                            {{ $q['number'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <form id="structureForm" method="POST" action="{{ $packageSectionSubmitUrl }}" class="space-y-0 relative">
            @csrf

            <!-- Part A (Structure) Instructions -->
            <div x-cloak x-show="currentSection === 'instructions' && !showWrittenDir" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden pb-8 font-sans flex justify-center w-full">
                <div class="w-full px-6 py-8 md:px-12 md:py-10">
                    <div class="bg-amber-500 rounded-full py-3 px-8 mb-8 inline-block">
                        <h2 class="text-xl md:text-2xl font-bold text-black tracking-tight">Section 2: Structure and Written Expression</h2>
                    </div>
                    
                    <div class="mb-10 text-gray-800 text-base leading-relaxed">
                        <p class="mb-4">
                            <strong class="font-bold text-lg">Time: 25 minutes, including the reading of directions</strong><br>
                            Now set your clock for 25 minutes.
                        </p>
                        <p>
                            This section is designed to measure your ability to recognize language that is appropriate for standard written English. There are two types of questions in this section, with special directions for each type.
                        </p>
                    </div>

                    <div class="mb-12">
                        <h3 class="text-2xl font-black text-black tracking-tight mb-6">Section 2, Part A</h3>
                        
                        <div class="pl-4 border-l-4 border-amber-400">
                            <p class="text-base text-gray-700 leading-relaxed mb-8">
                                <strong class="font-bold">Directions:</strong> Questions 1-15 are incomplete sentences. Beneath each sentence you will see four words or phrases, marked (A), (B), (C) and (D). Choose the <strong class="font-bold">one</strong> word or phrase that best completes the sentence. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.
                            </p>
                            
                            <!-- Example I -->
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="text-lg font-bold text-gray-800">Example I</h4>
                                    <div class="text-center">
                                        <p class="font-bold text-gray-500 text-xs tracking-wider uppercase mb-1">Sample Answer</p>
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">A</div>
                                            <div class="w-6 h-6 bg-gray-800 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-sm">B</div>
                                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">C</div>
                                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">D</div>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-gray-800 text-lg mb-4">Geysers have often been compared to volcanoes ________ they both emit hot liquids from below the Earth's surface.</p>
                                
                                <div class="text-gray-600 text-base pl-6 mb-6">
                                    <div class="mb-1">(A) due to</div>
                                    <div class="mb-1 font-semibold text-gray-800">(B) because</div>
                                    <div class="mb-1">(C) in spite of</div>
                                    <div class="mb-1">(D) regardless of</div>
                                </div>
                                
                                <p class="text-gray-600 text-sm italic">
                                    The sentence should read, "Geysers have often been compared to volcanoes because they both emit hot liquids from beneath the Earth's surface." Therefore, the correct choice is (B).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Ready Button -->
                    <div class="flex justify-center mt-12">
                        <button type="button" @click="currentSection = 'questions'; currentStructureIndex = 0; window.scrollTo(0,0)" class="px-8 py-3.5 bg-amber-500 hover:bg-amber-600 text-black font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition flex items-center gap-3">
                            <svg class="w-5 h-5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                            Now Begin Work on the Questions
                        </button>
                    </div>
                </div>
            </div>

            <!-- Part B (Written Expression) Instructions -->
            <div x-cloak x-show="currentSection === 'questions' && showWrittenDir" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden pb-8 font-sans flex justify-center w-full">
                <div class="w-full px-6 py-8 md:px-12 md:py-10">
                    <div class="bg-amber-500 rounded-full py-3 px-8 mb-8 inline-block">
                        <h2 class="text-xl md:text-2xl font-bold text-black tracking-tight">Section 2: Structure and Written Expression</h2>
                    </div>

                    <div class="mb-12">
                        <h3 class="text-2xl font-black text-black tracking-tight mb-6">Section 2, Part B</h3>
                        
                        <div class="pl-4 border-l-4 border-amber-400">
                            <p class="text-base text-gray-700 leading-relaxed mb-8">
                                <strong class="font-bold">Directions:</strong> In questions 16-40, each sentence has four underlined words or phrases. The four underlined parts of the sentence are marked (A), (B), (C), and (D). Identify the one underlined word or phrase that must be changed in order for the sentence to be correct. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.
                            </p>
                            
                            <!-- Example I -->
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="text-lg font-bold text-gray-800">Example I</h4>
                                    <div class="text-center">
                                        <p class="font-bold text-gray-500 text-xs tracking-wider uppercase mb-1">Sample Answer</p>
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">A</div>
                                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">B</div>
                                            <div class="w-6 h-6 bg-gray-800 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-sm">C</div>
                                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">D</div>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-gray-800 text-lg mb-4 leading-loose">Geysers <span class="underline decoration-2 font-bold">have</span> (A) often <span class="underline decoration-2 font-bold">been</span> (B) compared to volcanoes because they both <span class="underline decoration-2 font-bold decoration-red-600 text-red-700 bg-red-50 px-1 rounded">emits</span> (C) hot liquids from below the <span class="underline decoration-2 font-bold">Earth's surface</span> (D).</p>
                                
                                <p class="text-gray-600 text-sm italic mt-6">
                                    The sentence should read, "...volcanoes because they both emit..." Therefore, you should choose (C).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-center gap-4 mt-12">
                        <button type="button" @click="currentStructureIndex = {{ $structureCount - 1 }}; showWrittenDir = false; window.scrollTo(0,0)" class="px-6 py-3 bg-white border-2 border-gray-200 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition flex items-center gap-2">
                            <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                            Back
                        </button>
                        <button type="button" @click="showWrittenDir = false; currentStructureIndex = {{ $structureCount }}; window.scrollTo(0,0)" class="px-8 py-3.5 bg-amber-500 hover:bg-amber-600 text-black font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition flex items-center gap-3">
                            Proceed to Part B Questions
                            <svg class="w-5 h-5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Global Timer for Questions -->
            <div x-cloak x-show="currentSection === 'questions'" class="flex justify-end mb-6">
                <div class="bg-white border-2 px-5 py-2.5 rounded-xl shadow-sm flex items-center gap-3 transition-colors duration-300 pointer-events-none"
                     :class="{
                         'border-gray-800 text-gray-800': structureCountdown > 300,
                         'border-orange-400 text-orange-700 bg-orange-50': structureCountdown <= 300 && structureCountdown > 60,
                         'border-red-500 text-red-700 bg-red-50 animate-pulse': structureCountdown <= 60
                     }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="font-bold text-xl font-mono tracking-wider" x-text="formatStructureTime()"></div>
                </div>
            </div>

            <!-- Loop Questions -->
            @foreach($structureQuestions as $idx => $q)
                <div x-cloak x-show="currentSection === 'questions' && currentStructureIndex === {{ $idx }} && !showWrittenDir" class="bg-white rounded-2xl shadow-lg p-6 md:p-10 max-w-4xl mx-auto border border-gray-200 w-full">
                    
                    <!-- Card Top Header -->
                    <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="bg-amber-50 p-2.5 rounded-full border border-amber-200 flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800" style="margin: 0;">Question {{ $q['number'] }}</h3>

                        <span class="ml-auto text-sm text-gray-600 font-semibold bg-gray-100 px-4 py-1.5 rounded-full border border-gray-200">
                            {{ $q['part'] === 'A' ? 'Structure' : 'Written Expression' }}
                        </span>
                    </div>

                    <!-- Question Content -->
                    @if($q['part'] === 'A')
                        <div class="mb-6 text-gray-800 text-lg md:text-xl leading-relaxed" style="line-height: 1.6;">
                            {!! nl2br(e($q['question'])) !!}
                        </div>

                        <!-- Option Cards -->
                        <div class="space-y-4 max-w-2xl pl-2">
                            @foreach(['A', 'B', 'C', 'D'] as $option)
                                @php $text = $q[$option]; @endphp
                                <label class="mockup-option-label block w-full cursor-pointer" style="margin-bottom: 12px;">
                                    <input type="radio"
                                           name="q{{ $q['number'] }}"
                                           value="{{ $option }}"
                                           class="sr-only"
                                           required>
                                    <div class="mockup-option-card flex items-center p-4 bg-white border border-gray-200 rounded-2xl shadow-sm" style="border-width: 1.5px;">
                                        <div class="mockup-option-badge flex-shrink-0 flex items-center justify-center w-9 h-9 rounded-full border-2 border-gray-300 text-gray-500 font-bold text-sm mr-4">
                                            {{ $option }}
                                        </div>
                                        <span class="mockup-option-text text-gray-700 text-lg select-none leading-snug" style="line-height: 1.4;">{{ $text }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        {{-- Written Expression: sentences with underlined marked words --}}
                        <div class="mb-6 text-gray-800 text-lg md:text-xl leading-relaxed" style="line-height: 3; word-spacing: 3px; padding-bottom: 8px;">
                            {!! renderWrittenExpression($q['question'], $q['number'], $q['id']) !!}
                        </div>
                    @endif

                    <!-- Admin Inline Kunci Update toolbar -->
                    @php $isAdmin = auth()->check() && auth()->user()->isAdmin(); @endphp
                    @if($isAdmin)
                        <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-gray-100 pt-4">
                            <div class="flex gap-2 flex-grow">
                                @if(!empty($q['answer']))
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">&#10003; Kunci: {{ $q['answer'] }}</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">&#10005; Belum ada kunci</span>
                                @endif
                            </div>
                            <button type="button" class="bg-gray-900 hover:bg-black text-white font-semibold rounded-lg px-3 py-1.5 text-xs transition" onclick="updateKunci({{ $q['id'] }}, {{ $q['number'] }}, '{{ $q['answer'] }}')">Edit Kunci</button>
                        </div>
                    @endif

                    <!-- Question bottom navigation buttons -->
                    <div class="mt-12 pt-6 border-t border-gray-100 flex justify-between items-center">
                        <button type="button" @click="currentStructureIndex--; window.scrollTo(0,0)" 
                                :disabled="currentStructureIndex === 0"
                                :class="currentStructureIndex === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 text-gray-700 shadow-sm bg-white'"
                                class="px-6 py-3 rounded-xl border border-gray-300 font-bold transition flex items-center gap-2" style="border-width: 2px;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Prev
                        </button>
                        
                        <div class="flex gap-3">
                            <template x-if="currentStructureIndex === {{ $structureCount - 1 }}">
                                <button type="button" @click="showWrittenDir = true; window.scrollTo(0,0)" class="px-8 py-3 rounded-xl bg-amber-500 text-black font-bold hover:bg-amber-600 transition shadow-lg flex items-center gap-2">
                                    Next
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </template>
                            <template x-if="currentStructureIndex !== {{ $structureCount - 1 }} && currentStructureIndex < 39">
                                <button type="button" @click="currentStructureIndex++; window.scrollTo(0,0)" class="px-8 py-3 rounded-xl bg-amber-500 text-black font-bold hover:bg-amber-600 transition shadow-lg flex items-center gap-2">
                                    Next
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </template>
                            <template x-if="currentStructureIndex === 39">
                                <button type="button" @click="submitStructureSection()" class="px-8 py-3 rounded-xl bg-amber-500 text-black font-bold hover:bg-amber-600 transition shadow-lg flex items-center gap-2">
                                    Simpan & Lanjut ke Reading
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            @endforeach
        </form>
    </div>

    @if($isAdmin)
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
        </script>
    @endif
    <!-- Section Navigation -->
    <div class="fixed bottom-0 left-0 right-0 flex flex-row justify-center gap-0 z-50 bg-white border-t border-gray-200 shadow-lg">
        <a href="{{ $listeningUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'listening']) }}" 
                class="px-6 py-3 font-bold text-sm transition-all duration-200 border-r border-gray-200 hover:bg-gray-50 text-gray-700">
            Section 1: Listening
        </a>
        <a href="{{ $structureRedirectUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'structure']) }}" 
                class="px-6 py-3 font-bold text-sm transition-all duration-200 border-r border-gray-200 bg-amber-400 text-black">
            Section 2: Structure
        </a>
        <a href="{{ $readingRedirectUrl ?? route('online-test.package-section', ['slugAlias' => $slugAlias ?? 'toefl-itp', 'package' => $packageNumber, 'section' => 'reading']) }}" 
                class="px-6 py-3 font-bold text-sm transition-all duration-200 hover:bg-gray-50 text-gray-700">
            Section 3: Reading
        </a>
    </div>

        </main>
    </div>
</body>
</html>