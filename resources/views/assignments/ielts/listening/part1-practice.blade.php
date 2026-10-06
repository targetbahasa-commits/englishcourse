@extends('layouts.admin')

@section('title', "IELTS Listening Part {$set} Practice")

@section('content')
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-4 py-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Part {{ $set }} Practice Tests</h1>
                        <p class="text-gray-500 mt-1">Select a test to practice your listening skills. 🎧</p>
                    </div>
                </div>

                <a href="{{ route('assignments.ielts-academic.listening.practice.index') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Practices
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @php
            // Question types per part, per test number
                        $allTestData = [
                // PART 1
                1 => [
                     1 => ['Notes Completion'],
                     2 => ['Notes Completion'],
                     3 => ['Notes Completion', 'Form Completion', 'Sentence Completion'],
                     4 => ['Notes Completion'],
                     5 => ['Notes Completion', 'Table Completion'],
                     6 => ['Notes Completion', 'Table Completion'],
                     7 => ['Form Completion'],
                     8 => ['Form Completion'],
                     9 => ['Form Completion'],
                    10 => ['Notes Completion'],
                    11 => ['Form Completion'],
                    12 => ['Sentence Completion'],
                    13 => ['Notes Completion', 'Form Completion'],
                    14 => ['Notes Completion', 'Form Completion', 'Table Completion', 'Multiple Choice'],
                    15 => ['Notes Completion'],
                    16 => ['Notes Completion'],
                    17 => ['Form Completion', 'Multiple Choice'],
                    18 => ['Form Completion'],
                    19 => ['Notes Completion', 'Table Completion'],
                    20 => ['Notes Completion'],
                    21 => ['Notes Completion'],
                    22 => ['Notes Completion'],
                    23 => ['Notes Completion', 'Sentence Completion', 'Multiple Choice'],
                    24 => ['Notes Completion'],
                    25 => ['Notes Completion', 'Table Completion', 'Short Answer'],
                    26 => ['Notes Completion', 'Table Completion'],
                    27 => ['Form Completion', 'Short Answer'],
                    28 => ['Table Completion', 'Sentence Completion', 'Choose TWO'],
                    29 => ['Form Completion'],
                    30 => ['Notes Completion', 'Form Completion', 'Sentence Completion'],
                    31 => ['Form Completion'],
                    32 => ['Form Completion'],
                    33 => ['Table Completion'],
                    34 => ['Form Completion', 'Sentence Completion', 'Multiple Choice'],
                    35 => ['Notes Completion', 'Form Completion', 'Table Completion'],
                    36 => ['Notes Completion', 'Table Completion'],
                    37 => ['Notes Completion', 'Form Completion', 'Table Completion'],
                    38 => ['Notes Completion', 'Form Completion', 'Table Completion'],
                    39 => ['Notes Completion'],
                    40 => ['Notes Completion'],
                    41 => ['Form Completion', 'Notes Completion'],
                    42 => ['Form Completion', 'Notes Completion'],
                    43 => ['Form Completion', 'Notes Completion'],
                    44 => ['Form Completion', 'Notes Completion'],
                    45 => ['Notes Completion', 'Table Completion'],
                    46 => ['Form Completion', 'Table Completion'],
                    47 => ['Notes Completion', 'Form Completion'],
                    48 => ['Notes Completion', 'Form Completion', 'Table Completion'],
                    49 => ['Notes Completion', 'Form Completion'],
                    50 => ['Notes Completion', 'Table Completion'],
                ],
                // PART 2
                2 => [
                     1 => ['Form Completion', 'Sentence Completion', 'Multiple Choice', 'Matching Features'],
                     2 => ['Map Labeling', 'Form Completion', 'Sentence Completion'],
                     3 => ['Notes Completion', 'Table Completion'],
                     4 => ['Multiple Choice', 'Matching Features'],
                     5 => ['Map Labeling', 'Multiple Choice', 'Matching Features'],
                     6 => ['Sentence Completion'],
                     7 => ['Map Labeling', 'Matching Features'],
                     8 => ['Form Completion', 'Multiple Choice'],
                     9 => ['Form Completion', 'Table Completion', 'Multiple Choice'],
                    10 => ['Form Completion', 'Sentence Completion', 'Multiple Choice', 'Matching Features'],
                    11 => ['Multiple Choice', 'Matching Features'],
                    12 => ['Form Completion'],
                    13 => ['Multiple Choice'],
                    14 => ['Matching Features'],
                    15 => ['Multiple Choice', 'Matching Features'],
                    16 => ['Flow-chart Completion'],
                    17 => ['Notes Completion', 'Form Completion'],
                    18 => ['Notes Completion'],
                    19 => ['Sentence Completion', 'Choose TWO'],
                    20 => ['Map Labeling', 'Form Completion', 'Sentence Completion'],
                    21 => ['Map Labeling', 'Form Completion', 'Sentence Completion'],
                    22 => ['Table Completion', 'Flow-chart Completion', 'Multiple Choice'],
                    23 => ['Multiple Choice', 'Notes Completion'],
                    24 => ['Multiple Choice'],
                    25 => ['Notes Completion', 'Form Completion', 'Table Completion'],
                    26 => ['Notes Completion', 'Form Completion', 'Multiple Choice'],
                    27 => ['Map Labeling', 'Multiple Choice'],
                    28 => ['Notes Completion'],
                    29 => ['Form Completion', 'Table Completion', 'Multiple Choice'],
                    30 => ['Notes Completion', 'Table Completion'],
                    31 => ['Map Labeling', 'Sentence Completion'],
                    32 => ['Notes Completion'],
                    33 => ['Form Completion'],
                    34 => ['Multiple Choice', 'Notes Completion'],
                    35 => ['Map Labeling', 'Multiple Choice'],
                    36 => ['Multiple Choice'],
                    37 => ['Matching Features'],
                    38 => ['Table Completion', 'Choose TWO'],
                    39 => ['Map Labeling', 'Multiple Choice'],
                    40 => ['Multiple Choice', 'Matching Features'],
                    41 => ['Multiple Choice'],
                    42 => ['Multiple Choice', 'Notes Completion'],
                    43 => ['Matching Features'],
                    44 => ['Multiple Choice', 'Notes Completion'],
                    45 => ['Multiple Choice', 'Matching Features'],
                    46 => ['Multiple Choice', 'Notes Completion'],
                    47 => ['Multiple Choice'],
                    48 => ['Multiple Choice', 'Notes Completion'],
                    49 => ['Matching Features'],
                    50 => ['Map Labeling', 'Multiple Choice', 'Matching Features'],
                ],
                // PART 3
                3 => [
                     1 => ['Multiple Choice', 'Matching Features'],
                     2 => ['Multiple Choice', 'Matching Features'],
                     3 => ['Notes Completion'],
                     4 => ['Matching Features'],
                     5 => ['Multiple Choice', 'Matching Features'],
                     6 => ['Form Completion', 'Flow-chart Completion', 'Multiple Choice'],
                     7 => ['Sentence Completion', 'Multiple Choice'],
                     8 => ['Multiple Choice', 'Matching Features'],
                     9 => ['Matching Features'],
                    10 => ['Multiple Choice', 'Matching Features'],
                    11 => ['Multiple Choice', 'Matching Features'],
                    12 => ['Choose THREE'],
                    13 => ['Map Labeling', 'Matching Features'],
                    14 => ['Table Completion', 'Sentence Completion'],
                    15 => ['Table Completion'],
                    16 => ['Multiple Choice', 'Matching Features'],
                    17 => ['Notes Completion', 'Sentence Completion'],
                    18 => ['Notes Completion', 'Multiple Choice'],
                    19 => ['Matching Features'],
                    20 => ['Multiple Choice', 'Matching Features'],
                    21 => ['Multiple Choice', 'Matching Features'],
                    22 => ['Multiple Choice', 'Matching Features'],
                    23 => ['Form Completion'],
                    24 => ['Map Labeling'],
                    25 => ['Multiple Choice', 'Matching Features'],
                    26 => ['Sentence Completion', 'Choose TWO'],
                    27 => ['Multiple Choice', 'Matching Features'],
                    28 => ['Multiple Choice', 'Matching Features'],
                    29 => ['Sentence Completion'],
                    30 => ['Notes Completion'],
                    31 => ['Map Labeling', 'Table Completion', 'Multiple Choice'],
                    32 => ['Multiple Choice'],
                    33 => ['Table Completion', 'Sentence Completion', 'Multiple Choice'],
                    34 => ['Map Labeling'],
                    35 => ['Multiple Choice', 'Matching Features'],
                    36 => ['Map Labeling', 'Matching Features'],
                    37 => ['Form Completion', 'Sentence Completion', 'Multiple Choice'],
                    38 => ['Matching Features'],
                    39 => ['Multiple Choice', 'Matching Features'],
                    40 => ['Matching Features'],
                    41 => ['Multiple Choice', 'Matching Features'],
                    42 => ['Multiple Choice', 'Matching Features'],
                    43 => ['Map Labeling', 'Table Completion'],
                    44 => ['Multiple Choice', 'Matching Features'],
                    45 => ['Flow-chart Completion', 'Matching Features'],
                    46 => ['Map Labeling', 'Multiple Choice'],
                    47 => ['Flow-chart Completion', 'Matching Features'],
                    48 => ['Map Labeling', 'Multiple Choice', 'Matching Features'],
                    49 => ['Multiple Choice', 'Matching Features'],
                    50 => ['Multiple Choice', 'Matching Features'],
                ],
                // PART 4
                4 => [
                     1 => ['Notes Completion'],
                     2 => ['Notes Completion'],
                     3 => ['Notes Completion', 'Sentence Completion'],
                     4 => ['Notes Completion'],
                     5 => ['Notes Completion'],
                     6 => ['Notes Completion'],
                     7 => ['Notes Completion'],
                     8 => ['Notes Completion'],
                     9 => ['Notes Completion'],
                    10 => ['Notes Completion'],
                    11 => ['Notes Completion', 'Form Completion'],
                    12 => ['Notes Completion'],
                    13 => ['Notes Completion'],
                    14 => ['Notes Completion'],
                    15 => ['Notes Completion'],
                    16 => ['Table Completion'],
                    17 => ['Multiple Choice'],
                    18 => ['Notes Completion', 'Table Completion', 'Sentence Completion'],
                    19 => ['Notes Completion'],
                    20 => ['Notes Completion'],
                    21 => ['Notes Completion'],
                    22 => ['Sentence Completion'],
                    23 => ['Notes Completion'],
                    24 => ['Notes Completion'],
                    25 => ['Short Answer'],
                    26 => ['Diagram Labeling'],
                    27 => ['Notes Completion', 'Form Completion', 'Sentence Completion'],
                    28 => ['Notes Completion'],
                    29 => ['Notes Completion', 'Form Completion'],
                    30 => ['Notes Completion', 'Sentence Completion'],
                    31 => ['Notes Completion'],
                    32 => ['Sentence Completion'],
                    33 => ['Multiple Choice'],
                    34 => ['Notes Completion'],
                    35 => ['Notes Completion'],
                    36 => ['Notes Completion', 'Form Completion'],
                    37 => ['Notes Completion'],
                    38 => ['Notes Completion'],
                    39 => ['Notes Completion'],
                    40 => ['Notes Completion'],
                    41 => ['Notes Completion'],
                    42 => ['Multiple Choice'],
                    43 => ['Notes Completion'],
                    44 => ['Notes Completion'],
                    45 => ['Map Labeling', 'Notes Completion', 'Table Completion'],
                    46 => ['Notes Completion', 'Form Completion', 'Sentence Completion'],
                    47 => ['Notes Completion', 'Sentence Completion'],
                    48 => ['Notes Completion'],
                    49 => ['Map Labeling', 'Form Completion', 'Flow-chart Completion'],
                    50 => ['Notes Completion'],
                ],
            ];

            $gradients = [
                'linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%)',
                'linear-gradient(135deg, #0d9488 0%, #0891b2 100%)',
                'linear-gradient(135deg, #f59e0b 0%, #ef4444 100%)',
                'linear-gradient(135deg, #2563eb 0%, #7c3aed 100%)',
                'linear-gradient(135deg, #ec4899 0%, #f43f5e 100%)',
                'linear-gradient(135deg, #10b981 0%, #047857 100%)',
                'linear-gradient(135deg, #f97316 0%, #be123c 100%)',
                'linear-gradient(135deg, #84cc16 0%, #16a34a 100%)',
                'linear-gradient(135deg, #6366f1 0%, #4338ca 100%)',
                'linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%)',
            ];
            $btnColors = [
                '#5b21b6', '#0d7377', '#d97706', '#1d4ed8', '#db2777',
                '#059669', '#c2410c', '#4ade80', '#4f46e5', '#0284c7',
            ];
            $iconColors = [
                '#7c3aed', '#0d9488', '#f59e0b', '#2563eb', '#ec4899',
                '#10b981', '#ea580c', '#65a30d', '#4338ca', '#0ea5e9',
            ];

            $currentTestData = $allTestData[$set] ?? [];
        @endphp

        <!-- Tests Grid -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Available Tests (50)</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @for ($i = 1; $i <= 50; $i++)
                    @php
                        $idx       = ($i - 1) % 10;
                        $gradient  = $gradients[$idx];
                        $btnColor  = $btnColors[$idx];
                        $iconColor = $iconColors[$idx];
                        $types     = $currentTestData[$i] ?? ['Listening Practice'];
                    @endphp

                    <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col hover:-translate-y-1 transform">

                        <!-- Card Top Banner -->
                        <div style="background: {{ $gradient }}" class="p-6 relative">
                            <div class="absolute top-4 right-4 flex flex-col items-end gap-2">
                                <span class="px-3 py-1 bg-white/25 text-white backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wide border border-white/40 shadow-sm">
                                    PRACTICE
                                </span>
                                @if(isset($studentResults) && isset($studentResults[$i]))
                                    @php
                                        $res = $studentResults[$i];
                                    @endphp
                                    <div class="student-score-badge flex items-center gap-1.5 px-3 py-1 bg-emerald-600 text-white rounded-full text-xs font-bold uppercase tracking-wide border border-emerald-400 shadow-md">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Band {{ number_format($res->band_score, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md mb-4">
                                <svg style="color: {{ $iconColor }}" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                </svg>
                            </div>

                            <h3 class="text-white text-xl font-bold">Test {{ $i }}</h3>
                            <p class="text-white/80 text-sm mt-1">Part {{ $set }} · 10 questions</p>

                            <!-- Question type tags -->
                            <div class="mt-3 flex flex-wrap items-center gap-1">
                                @foreach($types as $idx2 => $type)
                                    <span class="text-[10px] text-white/80 uppercase tracking-wider font-medium">{{ $type }}</span>
                                    @if($idx2 < count($types) - 1)
                                        <span class="text-white/40 font-bold mx-0.5">·</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex flex-col flex-1">
                            <ul class="space-y-2 mb-4 flex-1">
                                @foreach($types as $typeLabel)
                                    <li class="flex items-center gap-2 text-sm text-gray-600">
                                        <span class="flex-none w-6 h-6 bg-white rounded-full flex items-center justify-center text-xs font-bold text-gray-500">✎</span>
                                        {{ $typeLabel }}
                                    </li>
                                @endforeach
                            </ul>

                            @if(isset($studentResults) && isset($studentResults[$i]))
                                @php
                                    $res = $studentResults[$i];
                                @endphp
                                <div class="mb-4 p-3 bg-emerald-50 rounded-2xl border border-emerald-200/80 flex items-center justify-between shadow-sm">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                            ✓
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Sudah Dikerjakan</p>
                                            <p class="text-xs text-emerald-700 font-medium">{{ $res->correct_count }} / {{ $res->total_questions }} Soal Benar</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] text-gray-500 font-medium block uppercase tracking-wider">Skor Band</span>
                                        <span class="text-base font-black text-emerald-700">Band {{ number_format($res->band_score, 1) }}</span>
                                    </div>
                                </div>
                            @endif

                            @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
                                @php
                                    $hasQuestions = view()->exists('assignments.ielts.listening.questions.part' . $set . '.test' . $i);
                                    $hasAnswerKey = view()->exists('assignments.ielts.listening.answers.part' . $set . '.test' . $i);

                                    $relAudio = 'assets/audio/ielts/listening/practice/part' . $set . '/test' . $i . '.mp3';
                                    $pathA = public_path($relAudio);
                                    $pathB = public_path('public/' . $relAudio);
                                    $pathC = base_path('public/' . $relAudio);
                                    $pathD = ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/' . $relAudio;
                                    $hasAudio = (file_exists($pathA) && filesize($pathA) > 1000) ||
                                                (file_exists($pathB) && filesize($pathB) > 1000) ||
                                                (file_exists($pathC) && filesize($pathC) > 1000) ||
                                                (file_exists($pathD) && filesize($pathD) > 1000) ||
                                                filled(config("ielts_listening_audios.{$set}.{$i}"));

                                    $relSrt = 'assets/audio/ielts/listening/practice/part' . $set . '/test' . $i . '.srt';
                                    $hasSrt = file_exists(public_path($relSrt)) ||
                                              file_exists(public_path('public/' . $relSrt)) ||
                                              file_exists(($_SERVER['DOCUMENT_ROOT'] ?? '') . '/' . $relSrt);
                                @endphp
                                <div class="flex flex-wrap gap-1.5 mb-5 mt-auto">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold {{ $hasQuestions ? 'bg-white text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}" title="Soal">
                                        {{ $hasQuestions ? '✓' : '✕' }} Soal
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold {{ $hasAnswerKey ? 'bg-white text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}" title="Kunci Jawaban">
                                        {{ $hasAnswerKey ? '✓' : '✕' }} Kunci
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold {{ $hasAudio ? 'bg-white text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}" title="Audio">
                                        {{ $hasAudio ? '✓' : '✕' }} Audio
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold {{ $hasSrt ? 'bg-white text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}" title="SRT (Subtitle)">
                                        {{ $hasSrt ? '✓' : '✕' }} SRT
                                    </span>
                                </div>
                            @endif

                            @php
                                $isDone = isset($studentResults) && isset($studentResults[$i]);
                                $targetUrl = (isset($meeting) && $meeting)
                                    ? route('assignments.ielts-academic.listening.part1.practice.test', ['meeting' => $meeting->id ?? $meeting, 'set' => $set, 'test' => $i])
                                    : route('assignments.ielts-academic.listening.practice-index.test', ['set' => $set, 'test' => $i]);
                            @endphp
                            <a href="{{ $targetUrl }}"
                               style="background-color: {{ $btnColor }}"
                               class="block w-full py-3 text-white text-center rounded-xl font-bold transition shadow hover:shadow-md active:scale-95 hover:opacity-90 flex items-center justify-center gap-1.5">
                                @if($isDone)
                                    <span>Review Hasil & Kerjakan Ulang</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                @else
                                    <span>Start Practice →</span>
                                @endif
                            </a>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

    </div>
</div>
@endsection
