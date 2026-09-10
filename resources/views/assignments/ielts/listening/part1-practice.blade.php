@extends('layouts.admin')

@section('title', 'IELTS Listening Part 1 Practice')

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
                    1  => ['Form Completion', 'Notes Completion'],
                    2  => ['Form Completion', 'Multiple Choice'],
                    3  => ['Notes Completion', 'Multiple Choice'],
                    4  => ['Form Completion', 'Sentence Completion'],
                    5  => ['Form Completion', 'Multiple Choice'],
                    6  => ['Table Completion', 'Multiple Choice'],
                    7  => ['Notes Completion', 'Sentence Completion'],
                    8  => ['Form Completion', 'Notes Completion'],
                    9  => ['Form Completion', 'Multiple Choice'],
                    10 => ['Form Completion', 'Table Completion'],
                    11 => ['Form Completion', 'Notes Completion'],
                    12 => ['Form Completion', 'Multiple Choice'],
                    13 => ['Notes Completion', 'Multiple Choice'],
                    14 => ['Form Completion', 'Sentence Completion'],
                    15 => ['Form Completion', 'Notes Completion'],
                    16 => ['Table Completion', 'Notes Completion'],
                    17 => ['Form Completion', 'Multiple Choice'],
                    18 => ['Table Completion', 'Multiple Choice'],
                    19 => ['Form Completion', 'Notes Completion'],
                    20 => ['Notes Completion', 'Sentence Completion'],
                    21 => ['Form Completion', 'Table Completion'],
                    22 => ['Notes Completion', 'Multiple Choice'],
                    23 => ['Form Completion', 'Notes Completion'],
                    24 => ['Table Completion', 'Sentence Completion'],
                    25 => ['Form Completion', 'Multiple Choice'],
                    26 => ['Notes Completion', 'Table Completion'],
                    27 => ['Form Completion', 'Sentence Completion'],
                    28 => ['Table Completion', 'Multiple Choice'],
                    29 => ['Form Completion', 'Notes Completion'],
                    30 => ['Notes Completion', 'Multiple Choice'],
                    31 => ['Form Completion', 'Notes Completion'],
                    32 => ['Form Completion', 'Multiple Choice'],
                    33 => ['Notes Completion', 'Multiple Choice'],
                    34 => ['Form Completion', 'Sentence Completion'],
                    35 => ['Form Completion', 'Notes Completion'],
                    36 => ['Table Completion', 'Multiple Choice'],
                    37 => ['Notes Completion', 'Sentence Completion'],
                    38 => ['Form Completion', 'Notes Completion'],
                    39 => ['Form Completion', 'Multiple Choice'],
                    40 => ['Form Completion', 'Table Completion'],
                    41 => ['Form Completion', 'Notes Completion'],
                    42 => ['Form Completion', 'Multiple Choice'],
                    43 => ['Notes Completion', 'Multiple Choice'],
                    44 => ['Form Completion', 'Sentence Completion'],
                    45 => ['Form Completion', 'Notes Completion'],
                    46 => ['Table Completion', 'Notes Completion'],
                    47 => ['Form Completion', 'Multiple Choice'],
                    48 => ['Table Completion', 'Multiple Choice'],
                    49 => ['Form Completion', 'Notes Completion'],
                    50 => ['Notes Completion', 'Sentence Completion'],
                ],
                // PART 2
                2 => [
                    1  => ['Multiple Choice', 'Map Labeling'],
                    2  => ['Multiple Choice', 'Notes Completion'],
                    3  => ['Multiple Choice', 'Matching Features'],
                    4  => ['Multiple Choice', 'Map Labeling'],
                    5  => ['Multiple Choice', 'Matching Features'],
                    6  => ['Multiple Choice', 'Sentence Completion'],
                    7  => ['Multiple Choice', 'Map Labeling'],
                    8  => ['Notes Completion', 'Multiple Choice'],
                    9  => ['Matching Features', 'Table Completion'],
                    10 => ['Multiple Choice', 'Flow-chart Completion'],
                    11 => ['Multiple Choice', 'Table Completion'],
                    12 => ['Multiple Choice', 'Map Labeling'],
                    13 => ['Matching Features', 'Sentence Completion'],
                    14 => ['Multiple Choice', 'Notes Completion'],
                    15 => ['Multiple Choice', 'Table Completion'],
                    16 => ['Multiple Choice', 'Map Labeling'],
                    17 => ['Matching Features', 'Multiple Choice'],
                    18 => ['Multiple Choice', 'Notes Completion'],
                    19 => ['Multiple Choice', 'Matching Features'],
                    20 => ['Notes Completion', 'Map Labeling'],
                    21 => ['Multiple Choice', 'Sentence Completion'],
                    22 => ['Matching Features', 'Table Completion'],
                    23 => ['Multiple Choice', 'Flow-chart Completion'],
                    24 => ['Multiple Choice', 'Map Labeling'],
                    25 => ['Matching Features', 'Notes Completion'],
                    26 => ['Multiple Choice', 'Table Completion'],
                    27 => ['Multiple Choice', 'Map Labeling'],
                    28 => ['Matching Features', 'Sentence Completion'],
                    29 => ['Multiple Choice', 'Notes Completion'],
                    30 => ['Multiple Choice', 'Map Labeling'],
                    31 => ['Multiple Choice', 'Sentence Completion'],
                    32 => ['Matching Features', 'Table Completion'],
                    33 => ['Multiple Choice', 'Flow-chart Completion'],
                    34 => ['Multiple Choice', 'Map Labeling'],
                    35 => ['Matching Features', 'Notes Completion'],
                    36 => ['Multiple Choice', 'Table Completion'],
                    37 => ['Multiple Choice', 'Map Labeling'],
                    38 => ['Matching Features', 'Sentence Completion'],
                    39 => ['Multiple Choice', 'Notes Completion'],
                    40 => ['Multiple Choice', 'Map Labeling'],
                    41 => ['Multiple Choice', 'Sentence Completion'],
                    42 => ['Matching Features', 'Table Completion'],
                    43 => ['Multiple Choice', 'Flow-chart Completion'],
                    44 => ['Multiple Choice', 'Map Labeling'],
                    45 => ['Matching Features', 'Notes Completion'],
                    46 => ['Multiple Choice', 'Table Completion'],
                    47 => ['Multiple Choice', 'Map Labeling'],
                    48 => ['Matching Features', 'Sentence Completion'],
                    49 => ['Multiple Choice', 'Notes Completion'],
                    50 => ['Multiple Choice', 'Map Labeling'],
                ],
                // PART 3
                3 => [
                    1  => ['Multiple Choice', 'Sentence Completion'],
                    2  => ['Multiple Choice', 'Notes Completion'],
                    3  => ['Multiple Choice', 'Matching Features'],
                    4  => ['Choose TWO', 'Notes Completion'],
                    5  => ['Multiple Choice', 'Table Completion'],
                    6  => ['Choose TWO', 'Sentence Completion'],
                    7  => ['Multiple Choice', 'Matching Features'],
                    8  => ['Choose TWO', 'Flow-chart Completion'],
                    9  => ['Multiple Choice', 'Notes Completion'],
                    10 => ['Choose TWO', 'Sentence Completion'],
                    11 => ['Multiple Choice', 'Table Completion'],
                    12 => ['Choose TWO', 'Matching Features'],
                    13 => ['Multiple Choice', 'Notes Completion'],
                    14 => ['Choose TWO', 'Sentence Completion'],
                    15 => ['Multiple Choice', 'Table Completion'],
                    16 => ['Choose TWO', 'Matching Features'],
                    17 => ['Multiple Choice', 'Sentence Completion'],
                    18 => ['Choose TWO', 'Notes Completion'],
                    19 => ['Multiple Choice', 'Flow-chart Completion'],
                    20 => ['Multiple Choice', 'Matching Features'],
                    21 => ['Choose TWO', 'Table Completion'],
                    22 => ['Multiple Choice', 'Sentence Completion'],
                    23 => ['Choose TWO', 'Notes Completion'],
                    24 => ['Multiple Choice', 'Matching Features'],
                    25 => ['Choose TWO', 'Sentence Completion'],
                    26 => ['Multiple Choice', 'Table Completion'],
                    27 => ['Choose TWO', 'Notes Completion'],
                    28 => ['Multiple Choice', 'Matching Features'],
                    29 => ['Choose TWO', 'Sentence Completion'],
                    30 => ['Multiple Choice', 'Table Completion'],
                    31 => ['Choose TWO', 'Table Completion'],
                    32 => ['Multiple Choice', 'Sentence Completion'],
                    33 => ['Choose TWO', 'Notes Completion'],
                    34 => ['Multiple Choice', 'Matching Features'],
                    35 => ['Choose TWO', 'Sentence Completion'],
                    36 => ['Multiple Choice', 'Table Completion'],
                    37 => ['Choose TWO', 'Notes Completion'],
                    38 => ['Multiple Choice', 'Matching Features'],
                    39 => ['Choose TWO', 'Sentence Completion'],
                    40 => ['Multiple Choice', 'Table Completion'],
                    41 => ['Choose TWO', 'Table Completion'],
                    42 => ['Multiple Choice', 'Sentence Completion'],
                    43 => ['Choose TWO', 'Notes Completion'],
                    44 => ['Multiple Choice', 'Matching Features'],
                    45 => ['Choose TWO', 'Sentence Completion'],
                    46 => ['Multiple Choice', 'Table Completion'],
                    47 => ['Choose TWO', 'Notes Completion'],
                    48 => ['Multiple Choice', 'Matching Features'],
                    49 => ['Choose TWO', 'Sentence Completion'],
                    50 => ['Multiple Choice', 'Table Completion'],
                ],
                // PART 4
                4 => [
                    1  => ['Notes Completion'],
                    2  => ['Notes Completion'],
                    3  => ['Notes Completion'],
                    4  => ['Notes Completion'],
                    5  => ['Notes Completion', 'Choose TWO'],
                    6  => ['Notes Completion', 'Table Completion'],
                    7  => ['Notes Completion'],
                    8  => ['Notes Completion'],
                    9  => ['Multiple Choice', 'Table Completion'],
                    10 => ['Notes Completion'],
                    11 => ['Notes Completion'],
                    12 => ['Notes Completion'],
                    13 => ['Notes Completion'],
                    14 => ['Notes Completion'],
                    15 => ['Notes Completion'],
                    16 => ['Notes Completion', 'Table Completion'],
                    17 => ['Multiple Choice', 'Short Answer', 'Table Completion'],
                    18 => ['Table Completion', 'Sentence Completion'],
                    19 => ['Notes Completion', 'Choose TWO'],
                    20 => ['Notes Completion'],
                    21 => ['Notes Completion', 'Sentence Completion'],
                    22 => ['Notes Completion'],
                    23 => ['Notes Completion'],
                    24 => ['Short Answer', 'Sentence Completion'],
                    25 => ['Summary Completion', 'Diagram Labeling'],
                    26 => ['Sentence Completion', 'Notes Completion'],
                    27 => ['Notes Completion'],
                    28 => ['Notes Completion', 'Table Completion'],
                    29 => ['Sentence Completion', 'Notes Completion'],
                    30 => ['Table Completion', 'Choose THREE'],
                    31 => ['Notes Completion'],
                    32 => ['Notes Completion'],
                    33 => ['Notes Completion'],
                    34 => ['Notes Completion'],
                    35 => ['Notes Completion', 'Choose TWO'],
                    36 => ['Notes Completion', 'Table Completion'],
                    37 => ['Notes Completion'],
                    38 => ['Notes Completion'],
                    39 => ['Multiple Choice', 'Table Completion'],
                    40 => ['Notes Completion'],
                    41 => ['Notes Completion'],
                    42 => ['Notes Completion'],
                    43 => ['Notes Completion'],
                    44 => ['Notes Completion'],
                    45 => ['Notes Completion'],
                    46 => ['Notes Completion', 'Table Completion'],
                    47 => ['Multiple Choice', 'Short Answer', 'Table Completion'],
                    48 => ['Table Completion', 'Sentence Completion'],
                    49 => ['Notes Completion', 'Choose TWO'],
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
                            <span class="absolute top-4 right-4 px-3 py-1 bg-white/25 text-white backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wide border border-white/40">
                                PRACTICE
                            </span>

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
                                                (file_exists($pathD) && filesize($pathD) > 1000);

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

                            <a href="{{ route('assignments.ielts-academic.listening.practice-index.test', ['set' => $set, 'test' => $i]) }}"
                               style="background-color: {{ $btnColor }}"
                               class="block w-full py-3 text-white text-center rounded-xl font-bold transition shadow hover:shadow-md active:scale-95 hover:opacity-90">
                                Start Practice →
                            </a>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

    </div>
</div>
@endsection
