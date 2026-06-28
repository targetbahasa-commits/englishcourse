<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $trackTitle }} - Meeting {{ $meetingLabel ?? $meetingNumber }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .word-correct { color: #2ecc71; font-weight: 700; }
        .word-extra { color: #3498db; font-weight: 700; text-decoration: line-through; }
        .word-missing { color: #f1c40f; font-weight: 700; }
        .word-wrong { color: #e74c3c; font-weight: 700; text-decoration: underline; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-4 sm:p-6 md:p-8">
            <!-- Topbar -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-6 md:mb-8">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                </div>
                <div class="flex items-center gap-6">
                    @include('components.topbar-action-icons')
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $trackTitle }}</h2>
                    <p class="text-gray-500 text-sm">Meeting {{ $meetingLabel ?? $meetingNumber }} &mdash; {{ $topic }}</p>
                </div>
                <a href="{{ route('assignments.grammar-writing.track', 'introductory') }}"
                   class="w-full md:w-auto justify-center px-4 py-2.5 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition inline-flex items-center gap-2 border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
            </div>

            @if(!empty($questions))
                <form x-data="{ showReview: {{ ($submitted ?? false) ? 'true' : 'false' }} }" method="POST" action="{{ route('assignments.grammar-writing.introductory.meeting.submit', ['meeting' => $meetingNumber]) }}" class="bg-white rounded-3xl shadow-sm border border-orange-100 overflow-visible">
                    @csrf
                    <div class="bg-gradient-to-r from-orange-50 via-amber-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-orange-100">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">Soal Meeting {{ $meetingLabel ?? $meetingNumber }}</h3>
                                <p class="text-gray-600 mt-1 text-sm sm:text-base">Terjemahkan dan isi jawaban untuk setiap soal di bawah ini.</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center rounded-full bg-orange-500 text-white text-xs font-bold px-3 py-1.5 w-fit">
                                    {{ count($questions) }} Soal
                                </span>
                                @if(Auth::user()->isAdmin() && (int) $meetingNumber === 1)
                                    <button type="button"
                                            onclick="openBulkIntroQuestionEditor({{ (int) $meetingNumber }})"
                                            class="inline-flex items-center justify-center rounded-full bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-3 py-1.5 w-fit transition cursor-pointer">
                                        Bulk Edit Soal
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if(($submitted ?? false) === true)
                            <div class="mt-4 rounded-2xl bg-orange-500 text-white px-4 py-4 shadow-sm">
                                <p class="text-sm opacity-90">Nilai Kamu</p>
                                <p class="text-2xl font-bold leading-tight">{{ $score }} / 100</p>
                                <p class="text-sm mt-1 opacity-90">
                                    {{ $score >= 80 ? 'Luar biasa, pertahankan!' : ($score >= 60 ? 'Bagus, tinggal rapikan lagi.' : 'Tetap semangat, coba revisi jawabanmu.') }}
                                </p>
                            </div>
                            <div class="mt-3">
                                <button type="button"
                                        @click="showReview = !showReview"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-orange-200 bg-white text-orange-700 text-sm font-semibold hover:bg-orange-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0A9 9 0 1112 3a9 9 0 019 9z"></path>
                                    </svg>
                                    <span x-show="!showReview" style="display: none;">Lihat Pembahasan</span>
                                    <span x-show="showReview">Sembunyikan Pembahasan</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                        @if(!empty($cheatSheet))
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-5 rounded-xl mb-2">
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="font-bold mb-2 flex items-center">
                                            <span class="bg-yellow-200 text-yellow-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">1</span>
                                            Identifikasi Tenses
                                        </h3>
                                        <p class="text-sm text-yellow-700">Lihat materi untuk mengetahui pola kalimat yang harus digunakan.</p>
                                    </div>
                                    <div>
                                        <h3 class="font-bold mb-2 flex items-center">
                                            <span class="bg-yellow-200 text-yellow-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">2</span>
                                            Terjemahkan
                                        </h3>
                                        <p class="text-sm text-yellow-700">Tulis terjemahan bahasa Inggris yang sesuai dengan rumus tenses tersebut.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                @foreach($cheatSheet as $title => $rules)
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 text-sm">
                                    <h4 class="font-bold text-yellow-800 mb-2">{{ $title }}</h4>
                                    <ul class="space-y-1 text-gray-700">
                                        @foreach($rules as $rule)
                                        <li>{!! $rule !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        @if(($submitted ?? false) === true)
                            <div class="mb-6">
                                <h4 class="text-lg font-bold text-gray-800 mb-3">Laporan Hasil</h4>
                                <div x-show="showReview" x-transition class="overflow-x-auto rounded-2xl border border-orange-100">
                                    <table class="w-full border-collapse text-sm bg-white">
                                        <thead>
                                            <tr class="bg-orange-500 text-white">
                                                <th class="p-3 text-left w-14">No</th>
                                                <th class="p-3 text-left">Pertanyaan</th>
                                                <th class="p-3 text-left">Jawaban Kamu</th>
                                                <th class="p-3 text-left">Jawaban Benar</th>
                                                <th class="p-3 text-left w-20">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($questions as $reportIndex => $reportQuestion)
                                                @php
                                                    $reportNumber = $reportIndex + 1;
                                                    $reportResult = $results[$reportNumber] ?? null;
                                                @endphp
                                                <tr class="odd:bg-white even:bg-orange-50/30">
                                                    <td class="p-3 border-t border-orange-100 font-semibold">{{ $reportNumber }}</td>
                                                    <td class="p-3 border-t border-orange-100">{{ $reportQuestion }}</td>
                                                    <td class="p-3 border-t border-orange-100">
                                                        {!! !empty($reportResult['formatted_answer']) ? $reportResult['formatted_answer'] : e($reportResult['user_answer'] ?? '-') !!}
                                                    </td>
                                                    <td class="p-3 border-t border-orange-100 text-gray-700">{{ $reportResult['correct_answer'] ?? '-' }}</td>
                                                    <td class="p-3 border-t border-orange-100 font-bold">{{ $reportResult['score'] ?? 0 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if((int) $meetingNumber === 11)
                            @php
                                $meeting11Items = collect($questions)->mapWithKeys(fn ($q, $i) => [$i + 1 => $q]);
                                $meeting11VerbItems = $meeting11Items->filter(fn ($q) => \Illuminate\Support\Str::startsWith($q, 'V1:'));
                                $meeting11SentenceItems = $meeting11Items->reject(fn ($q) => \Illuminate\Support\Str::startsWith($q, 'V1:'));
                            @endphp

                            <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 overflow-x-auto">
                                <table class="w-full border-collapse text-sm min-w-[720px]">
                                    <thead>
                                        <tr class="bg-orange-50 text-gray-800">
                                            <th class="border border-gray-300 p-2 text-left w-16">List</th>
                                            <th class="border border-gray-300 p-2 text-left w-64">V1 (Base Form)</th>
                                            <th class="border border-gray-300 p-2 text-left">V2 (Simple Past)</th>
                                            <th class="border border-gray-300 p-2 text-left">V3 (Past Participle)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($meeting11VerbItems as $questionNumber => $question)
                                            @php
                                                $index = $loop->index;
                                                $listLabel = chr(97 + ($index % 26)) . '.';
                                                if ($index >= 26) {
                                                    $listLabel = chr(97 + floor($index / 26) - 1) . chr(97 + ($index % 26)) . '.';
                                                }

                                                preg_match('/^V1:\s*([^\(]+)/i', $question, $v1Match);
                                                $v1Word = trim($v1Match[1] ?? $question);

                                                $combinedAnswer = (string) (old('answers.' . $questionNumber, $results[$questionNumber]['user_answer'] ?? $userAnswers[$questionNumber] ?? ''));
                                                $combinedParts = array_map('trim', explode(',', $combinedAnswer));
                                                $existingV2 = $combinedParts[0] ?? '';
                                                $existingV3 = $combinedParts[1] ?? '';

                                                $v2Value = old('meeting11_answers.' . $questionNumber . '.v2', $meeting11Answers[$questionNumber]['v2'] ?? $existingV2);
                                                $v3Value = old('meeting11_answers.' . $questionNumber . '.v3', $meeting11Answers[$questionNumber]['v3'] ?? $existingV3);
                                                $questionResult = $results[$questionNumber] ?? null;
                                            @endphp
                                            <tr class="odd:bg-white even:bg-gray-50/60">
                                                <td class="border border-gray-300 p-2 font-semibold">{{ $listLabel }}</td>
                                                <td class="border border-gray-300 p-2 font-semibold">{{ $v1Word }}</td>
                                                <td class="border border-gray-300 p-2">
                                                    <input type="text"
                                                           name="meeting11_answers[{{ $questionNumber }}][v2]"
                                                           value="{{ $v2Value }}"
                                                           placeholder="Verb 2"
                                                           class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 {{ ($submitted ?? false) ? 'bg-gray-100 cursor-not-allowed' : 'bg-white' }}"
                                                           {{ ($submitted ?? false) ? 'readonly' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 p-2">
                                                    <input type="text"
                                                           name="meeting11_answers[{{ $questionNumber }}][v3]"
                                                           value="{{ $v3Value }}"
                                                           placeholder="Verb 3"
                                                           class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 {{ ($submitted ?? false) ? 'bg-gray-100 cursor-not-allowed' : 'bg-white' }}"
                                                           {{ ($submitted ?? false) ? 'readonly' : '' }}>
                                                    @if(($submitted ?? false) === true && $questionResult)
                                                        <div x-show="showReview" class="mt-2 text-xs {{ (float)($questionResult['score'] ?? 0) >= 9.5 ? 'text-green-700' : 'text-red-700' }}">
                                                            Skor: {{ $questionResult['score'] ?? 0 }}/10
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($meeting11SentenceItems->isNotEmpty())
                                <div class="mt-6 space-y-4">
                                    <div>
                                        <h4 class="text-base sm:text-lg font-bold text-gray-800">Bagian B - Translate Kalimat</h4>
                                        <p class="text-sm text-gray-600">Terjemahkan kalimat berikut ke dalam bahasa Inggris.</p>
                                    </div>

                                    @foreach($meeting11SentenceItems as $questionNumber => $question)
                                        @php
                                            $questionResult = $results[$questionNumber] ?? null;
                                            $helper = $questionHelpers[$questionNumber] ?? ['example' => null, 'vocab' => []];
                                        @endphp
                                        <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5">
                                            <div class="flex items-start gap-3 sm:gap-4">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                    {{ $loop->iteration }}
                                                </div>
                                                <div class="pt-1 flex-1">
                                                    <p class="text-gray-800 leading-relaxed">{{ $question }}</p>
                                                </div>
                                                <div class="flex flex-col gap-1 ml-2">
                                                    @if(!empty($helper['example']))
                                                        <div x-data="{ open: false }" class="relative inline-block">
                                                            <button type="button" @click="open = !open" @click.outside="open = false" class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-2 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center">
                                                                ?
                                                            </button>
                                                            <div x-show="open"
                                                                 x-transition:enter="transition ease-out duration-200"
                                                                 x-transition:enter-start="opacity-0 translate-y-2"
                                                                 x-transition:enter-end="opacity-100 translate-y-0"
                                                                 x-transition:leave="transition ease-in duration-150"
                                                                 x-transition:leave-start="opacity-100 translate-y-0"
                                                                 x-transition:leave-end="opacity-0 translate-y-2"
                                                                 style="display: none;"
                                                                 class="absolute bottom-full right-0 mb-2 w-64 max-w-[calc(100vw-2rem)] bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-50 text-center leading-relaxed">
                                                                <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                                {{ $helper['example']['id'] }}<br>
                                                                <em class="text-gray-300">{{ $helper['example']['en'] }}</em>
                                                                <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(!empty($helper['vocab']))
                                                        <div x-data="{ open: false }" class="relative inline-block">
                                                            <button type="button" @click="open = !open" @click.outside="open = false" class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-2 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center">
                                                                v
                                                            </button>
                                                            <div x-show="open"
                                                                 x-transition:enter="transition ease-out duration-200"
                                                                 x-transition:enter-start="opacity-0 translate-y-2"
                                                                 x-transition:enter-end="opacity-100 translate-y-0"
                                                                 x-transition:leave="transition ease-in duration-150"
                                                                 x-transition:leave-start="opacity-100 translate-y-0"
                                                                 x-transition:leave-end="opacity-0 translate-y-2"
                                                                 style="display: none;"
                                                                 class="absolute bottom-full right-0 mb-2 w-80 sm:w-96 max-w-[calc(100vw-2rem)] bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-50 text-left leading-relaxed">
                                                                <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Kosa Kata Sulit:</strong>
                                                                <ul class="space-y-1">
                                                                    @foreach($helper['vocab'] as $enTerm => $vocabData)
                                                                        <li class="flex justify-between">
                                                                            <span class="text-green-300 font-mono">{{ $enTerm }} <span class="text-gray-400 text-xs">{{ $vocabData['pos'] }}</span></span>
                                                                            <span>{{ $vocabData['id'] }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-3 ml-0 sm:ml-13">
                                                <input type="text"
                                                       name="answers[{{ $questionNumber }}]"
                                                       value="{{ old('answers.' . $questionNumber, $results[$questionNumber]['user_answer'] ?? $userAnswers[$questionNumber] ?? '') }}"
                                                       placeholder="Tulis terjemahan bahasa Inggris di sini..."
                                                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ ($submitted ?? false) ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                       {{ ($submitted ?? false) ? 'readonly' : '' }}>

                                                @if(($submitted ?? false) === true && $questionResult)
                                                    <div x-show="showReview" x-transition>
                                                        @if((float) $questionResult['score'] >= 9.5)
                                                            <div class="mt-3 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium flex items-center">
                                                                <span class="mr-2">✓</span> Sempurna! ({{ $questionResult['score'] }}/10)
                                                            </div>
                                                        @else
                                                            <div class="mt-3 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm space-y-1">
                                                                <div class="font-bold">Nilai: {{ $questionResult['score'] }}/10</div>
                                                                @if(!empty($questionResult['formatted_answer']))
                                                                    <div class="text-gray-700">Analisis jawaban: {!! $questionResult['formatted_answer'] !!}</div>
                                                                @endif
                                                                <div>Jawaban yang benar: <strong class="text-gray-800">{{ $questionResult['correct_answer'] }}</strong></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                        @foreach($questions as $index => $question)
                            @php
                                $questionNumber = $index + 1;
                                $helper = $questionHelpers[$questionNumber] ?? ['example' => null, 'vocab' => []];
                                $editorQuestion = $questionEditorData[$questionNumber] ?? ['db_id' => null, 'question_text' => $question, 'correct_answer' => ''];
                            @endphp
                            <div class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-orange-200 space-y-3 overflow-visible">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center text-sm font-bold shrink-0">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="pt-1 flex-1">
                                        <p class="text-gray-800 leading-relaxed">{{ $question }}</p>
                                        @if(Auth::user()->isAdmin() && (int) $meetingNumber === 1)
                                            <div class="mt-2 flex items-center gap-2 text-xs">
                                                <button type="button"
                                                        class="px-2 py-1 rounded-md bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100"
                                                        onclick="openIntroQuestionEditor({
                                                            meetingNumber: {{ (int) $meetingNumber }},
                                                            questionNumber: {{ (int) $questionNumber }},
                                                            dbId: {{ $editorQuestion['db_id'] ? (int) $editorQuestion['db_id'] : 'null' }},
                                                            questionText: {{ \Illuminate\Support\Js::from($editorQuestion['question_text']) }},
                                                            correctAnswer: {{ \Illuminate\Support\Js::from($editorQuestion['correct_answer']) }}
                                                        })">
                                                    Edit Soal
                                                </button>
                                                @if(!empty($editorQuestion['db_id']))
                                                    <button type="button"
                                                            class="px-2 py-1 rounded-md bg-red-50 text-red-700 border border-red-200 hover:bg-red-100"
                                                            onclick="deleteIntroQuestionOverride({{ (int) $editorQuestion['db_id'] }})">
                                                        Hapus Override
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-1 ml-2">
                                        @if(!empty($helper['example']))
                                            <div x-data="{ open: false }" class="relative inline-block">
                                                <button type="button" @click="open = !open" @click.outside="open = false" class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-2 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center">
                                                    ?
                                                </button>
                                                <div x-show="open"
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 translate-y-2"
                                                     x-transition:enter-end="opacity-100 translate-y-0"
                                                     x-transition:leave="transition ease-in duration-150"
                                                     x-transition:leave-start="opacity-100 translate-y-0"
                                                     x-transition:leave-end="opacity-0 translate-y-2"
                                                     style="display: none;"
                                                     class="absolute bottom-full right-0 mb-2 w-64 max-w-[calc(100vw-2rem)] bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-50 text-center leading-relaxed">
                                                    <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                    {{ $helper['example']['id'] }}<br>
                                                    <em class="text-gray-300">{{ $helper['example']['en'] }}</em>
                                                    <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(!empty($helper['vocab']))
                                            <div x-data="{ open: false }" class="relative inline-block">
                                                <button type="button" @click="open = !open" @click.outside="open = false" class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-2 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center">
                                                    v
                                                </button>
                                                <div x-show="open"
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 translate-y-2"
                                                     x-transition:enter-end="opacity-100 translate-y-0"
                                                     x-transition:leave="transition ease-in duration-150"
                                                     x-transition:leave-start="opacity-100 translate-y-0"
                                                     x-transition:leave-end="opacity-0 translate-y-2"
                                                     style="display: none;"
                                                     class="absolute bottom-full right-0 mb-2 w-80 sm:w-96 max-w-[calc(100vw-2rem)] bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-50 text-left leading-relaxed">
                                                    <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Kosa Kata Sulit:</strong>
                                                    <ul class="space-y-1">
                                                        @foreach($helper['vocab'] as $enTerm => $vocabData)
                                                            <li class="flex justify-between">
                                                                <span class="text-green-300 font-mono">{{ $enTerm }} <span class="text-gray-400 text-xs">{{ $vocabData['pos'] }}</span></span>
                                                                <span>{{ $vocabData['id'] }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-11 sm:ml-13">
                                    <input type="text" 
                                           id="answer_{{ $index + 1 }}" 
                                           name="answers[{{ $index + 1 }}]" 
                                           value="{{ old('answers.'.($index + 1), $results[$index + 1]['user_answer'] ?? $userAnswers[$index + 1] ?? '') }}"
                                           placeholder="Tulis bahasa Inggrisnya di sini..."
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ ($submitted ?? false) ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                           {{ ($submitted ?? false) ? 'readonly' : '' }}>

                                    @if(($submitted ?? false) === true)
                                        @php
                                            $questionResult = $results[$index + 1] ?? null;
                                        @endphp
                                        @if($questionResult)
                                            <div x-show="showReview" x-transition>
                                            @if((float) $questionResult['score'] >= 9.5)
                                                <div class="mt-3 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium flex items-center">
                                                    <span class="mr-2">✓</span> Sempurna! ({{ $questionResult['score'] }}/10)
                                                </div>
                                            @else
                                                <div class="mt-3 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm space-y-1">
                                                    <div class="font-bold">Nilai: {{ $questionResult['score'] }}/10</div>
                                                    @if(!empty($questionResult['formatted_answer']))
                                                        <div class="text-gray-700">Analisis jawaban: {!! $questionResult['formatted_answer'] !!}</div>
                                                    @endif
                                                    <div>Jawaban yang benar: <strong class="text-gray-800">{{ $questionResult['correct_answer'] }}</strong></div>
                                                </div>
                                            @endif
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @endif

                        @if(!empty($paragraphData))
                            <div class="mt-8 rounded-2xl border border-green-200 bg-green-50/40 p-4 sm:p-5 space-y-4">
                                <div class="flex items-center justify-between gap-3">
                                    <h4 class="text-lg font-bold text-gray-800">Latihan Paragraf</h4>
                                    @if(Auth::user()->isAdmin() && (int) $meetingNumber === 3)
                                        <button type="button"
                                                class="px-3 py-1 rounded-md bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 text-xs font-semibold"
                                                onclick="openIntroParagraphEditor({
                                                    meetingNumber: {{ (int) $meetingNumber }},
                                                    dbId: {{ !empty($paragraphEditorData['db_id']) ? (int) $paragraphEditorData['db_id'] : 'null' }},
                                                    paragraphId: {{ \Illuminate\Support\Js::from($paragraphEditorData['id'] ?? ($paragraphData['id'] ?? '')) }},
                                                    paragraphEn: {{ \Illuminate\Support\Js::from($paragraphEditorData['en'] ?? ($paragraphData['en'] ?? '')) }}
                                                })">
                                            Edit Paragraph
                                        </button>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">Terjemahkan paragraf berikut ke dalam Bahasa Inggris.</p>

                                <p class="text-sm leading-relaxed text-gray-700 bg-white border border-gray-200 rounded-xl p-4">
                                    {{ $paragraphData['id'] }}
                                </p>

                                <div>
                                    <textarea
                                        name="paragraph_answer"
                                        rows="6"
                                        class="w-full p-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition {{ ($submitted ?? false) ? 'bg-gray-100 cursor-not-allowed' : 'bg-white' }}"
                                        placeholder="Tulis terjemahan paragraf di sini..."
                                        {{ ($submitted ?? false) ? 'readonly' : '' }}>{{ old('paragraph_answer', $userParagraphAnswer ?? '') }}</textarea>
                                </div>

                                @if(!empty($paragraphData['vocab']))
                                    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3">
                                        <strong class="text-yellow-800 text-sm block mb-2">Kosa Kata Bantuan:</strong>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($paragraphData['vocab'] as $en => $vocabData)
                                                <span class="bg-white px-2 py-1 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                                    <strong>{{ $en }}</strong> <span class="text-gray-500">{{ $vocabData['pos'] }}</span>: {{ $vocabData['id'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(($submitted ?? false) === true && !empty($paragraphResult))
                                    <div x-show="showReview" x-transition class="space-y-2">
                                        <div class="text-sm font-bold {{ ($paragraphResult['score'] ?? 0) >= (($paragraphResult['max_score'] ?? 20) * 0.8) ? 'text-green-700 bg-green-100 border-green-200' : 'text-red-700 bg-red-100 border-red-200' }} border rounded-lg p-3">
                                            Skor Paragraf: {{ $paragraphResult['score'] ?? 0 }} / {{ $paragraphResult['max_score'] ?? 20 }}
                                        </div>
                                        <div class="bg-white border border-gray-200 rounded-lg p-3 text-sm text-gray-700 leading-relaxed">
                                            <strong class="block mb-2">Analisis Perbedaan:</strong>
                                            {!! $paragraphResult['formatted_answer'] !!}
                                        </div>
                                        <div class="text-sm text-gray-700">
                                            <strong>Jawaban Lengkap:</strong>
                                            <p class="mt-1 italic text-gray-600">{{ $paragraphResult['correct_answer'] }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="px-5 py-6 sm:px-8 border-t border-gray-100 bg-gray-50/60 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('assignments.grammar-writing.track', 'introductory') }}"
                           class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-300 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Meeting
                        </a>
                        @if(($submitted ?? false) === true)
                            <button type="submit"
                                    formaction="{{ route('assignments.grammar-writing.introductory.meeting.reset', ['meeting' => $meetingNumber]) }}"
                                    formmethod="POST"
                                    class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-gray-600 text-white rounded-xl font-bold hover:bg-gray-700 transition shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 104.582 9m0 0H9"></path>
                                </svg>
                                Reset Jawaban
                            </button>
                        @else
                            <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-orange-500 text-white rounded-xl font-bold hover:bg-orange-600 transition shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Kirim Jawaban
                            </button>
                        @endif
                    </div>
                </form>
            @else
                <!-- Empty State / Placeholder -->
                <div class="flex flex-col items-center justify-center min-h-[60vh]">
                    <div class="bg-white rounded-3xl shadow-sm p-16 text-center max-w-lg w-full">
                        <div class="w-20 h-20 bg-orange-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Meeting {{ $meetingLabel ?? $meetingNumber }}</h3>
                        <p class="text-orange-500 font-semibold text-lg mb-4">{{ $topic }}</p>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Konten untuk meeting ini sedang disiapkan.<br>
                            Silakan tunggu update berikutnya.
                        </p>
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('assignments.grammar-writing.track', 'introductory') }}"
                               class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 text-white rounded-xl font-bold hover:bg-orange-600 transition shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Daftar Meeting
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <form id="intro-question-create-form" method="POST" action="{{ route('admin.grammar.question.store') }}" class="hidden">
        @csrf
        <input type="hidden" name="meeting_number" id="intro-create-meeting-number">
        <input type="hidden" name="question_number" id="intro-create-question-number">
        <input type="hidden" name="section" id="intro-create-section">
        <input type="hidden" name="question_text" id="intro-create-question-text">
        <input type="hidden" name="correct_answer" id="intro-create-correct-answer">
    </form>

    <form id="intro-question-update-form" method="POST" action="" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="section" id="intro-update-section">
        <input type="hidden" name="question_text" id="intro-update-question-text">
        <input type="hidden" name="correct_answer" id="intro-update-correct-answer">
    </form>

    <form id="intro-question-delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <form id="intro-paragraph-create-form" method="POST" action="{{ route('admin.grammar.question.store') }}" class="hidden">
        @csrf
        <input type="hidden" name="meeting_number" id="intro-paragraph-create-meeting-number">
        <input type="hidden" name="question_number" id="intro-paragraph-create-question-number" value="0">
        <input type="hidden" name="section" id="intro-paragraph-create-section">
        <input type="hidden" name="question_text" id="intro-paragraph-create-id-text">
        <input type="hidden" name="correct_answer" id="intro-paragraph-create-en-text">
    </form>

    <form id="intro-paragraph-update-form" method="POST" action="" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="section" id="intro-paragraph-update-section">
        <input type="hidden" name="question_text" id="intro-paragraph-update-id-text">
        <input type="hidden" name="correct_answer" id="intro-paragraph-update-en-text">
    </form>

    <form id="intro-paragraph-delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <div id="intro-question-editor-modal" class="fixed inset-0 z-[100] hidden" aria-hidden="true">
        <div id="intro-question-editor-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Editor Soal Introductory</h3>
                    <button type="button" id="intro-question-editor-close" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">Tutup</button>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nomor Soal</p>
                        <p id="intro-question-editor-number" class="text-sm font-semibold text-gray-700">-</p>
                    </div>
                    <div>
                        <label for="intro-question-editor-text" class="block text-sm font-semibold text-gray-700 mb-1">Teks Soal (Indonesia)</label>
                        <textarea id="intro-question-editor-text" rows="4" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                    </div>
                    <div>
                        <label for="intro-question-editor-answer" class="block text-sm font-semibold text-gray-700 mb-1">Kunci Jawaban (English)</label>
                        <textarea id="intro-question-editor-answer" rows="4" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                    </div>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2">
                    <button type="button" id="intro-question-editor-cancel" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50">Batal</button>
                    <button type="button" id="intro-question-editor-save" class="px-4 py-2 rounded-lg bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div id="intro-paragraph-editor-modal" class="fixed inset-0 z-[100] hidden" aria-hidden="true">
        <div id="intro-paragraph-editor-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Editor Paragraph Introductory</h3>
                    <button type="button" id="intro-paragraph-editor-close" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">Tutup</button>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label for="intro-paragraph-editor-id" class="block text-sm font-semibold text-gray-700 mb-1">Paragraf (Indonesia)</label>
                        <textarea id="intro-paragraph-editor-id" rows="7" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>
                    <div>
                        <label for="intro-paragraph-editor-en" class="block text-sm font-semibold text-gray-700 mb-1">Jawaban Referensi (English)</label>
                        <textarea id="intro-paragraph-editor-en" rows="7" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-2">
                    <button type="button" id="intro-paragraph-editor-delete" class="px-4 py-2 rounded-lg bg-red-50 text-red-700 border border-red-200 text-sm font-semibold hover:bg-red-100 hidden">Hapus Override</button>
                    <div class="flex items-center gap-2">
                        <button type="button" id="intro-paragraph-editor-cancel" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50">Batal</button>
                        <button type="button" id="intro-paragraph-editor-save" class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Edit Modal -->
    <div id="intro-bulk-editor-modal" class="fixed inset-0 z-[100] hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-black/50" onclick="closeBulkIntroQuestionEditor()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden relative z-10 flex flex-col max-h-full">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                    <h3 class="text-lg font-bold text-gray-800" id="intro-bulk-editor-title">Bulk Edit Soal</h3>
                    <button type="button" onclick="closeBulkIntroQuestionEditor()" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">Tutup</button>
                </div>
                <form id="intro-bulk-question-form" method="POST" action="{{ route('admin.grammar.question.bulk-introductory') }}" class="flex flex-col overflow-hidden min-h-[400px]">
                    @csrf
                    <input type="hidden" name="meeting_number" id="intro-bulk-meeting-number" value="">
                    <div class="p-5 flex-1 overflow-y-auto">
                        <div class="mb-2">
                            <label for="intro-bulk-editor-text" class="block text-sm font-semibold text-gray-700 mb-1">List Soal (1 baris per soal)</label>
                            <p class="text-xs text-gray-500 mb-2">Paste semua kalimat di sini. Setiap baris baru (enter) akan dianggap sebagai soal baru. Kunci jawaban (jika sudah ada) tidak akan terhapus.</p>
                            <textarea id="intro-bulk-editor-text" name="questions_text" rows="15" class="w-full h-full min-h-[300px] rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 font-mono whitespace-pre" required></textarea>
                        </div>
                    </div>
                    <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2 shrink-0">
                        <button type="button" onclick="closeBulkIntroQuestionEditor()" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Simpan Bulk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentIntroEditorPayload = null;
        let currentIntroParagraphPayload = null;

        function openBulkIntroQuestionEditor(meetingNumber) {
            document.getElementById('intro-bulk-meeting-number').value = meetingNumber;
            // Pre-fill with existing questions if possible
            const questionTexts = [];
            document.querySelectorAll('.group p.text-gray-800.leading-relaxed').forEach(p => {
                questionTexts.push(p.textContent.trim());
            });
            document.getElementById('intro-bulk-editor-text').value = questionTexts.join('\n');

            const modal = document.getElementById('intro-bulk-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            setTimeout(() => document.getElementById('intro-bulk-editor-text').focus(), 0);
        }

        function closeBulkIntroQuestionEditor() {
            const modal = document.getElementById('intro-bulk-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
        }

        function openIntroQuestionEditor(payload) {
            currentIntroEditorPayload = payload;

            document.getElementById('intro-question-editor-number').textContent = `Meeting ${payload.meetingNumber} - Soal ${payload.questionNumber}`;
            document.getElementById('intro-question-editor-text').value = payload.questionText || '';
            document.getElementById('intro-question-editor-answer').value = payload.correctAnswer || '';

            const modal = document.getElementById('intro-question-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');

            setTimeout(() => {
                document.getElementById('intro-question-editor-text').focus();
            }, 0);
        }

        function closeIntroQuestionEditor() {
            const modal = document.getElementById('intro-question-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            currentIntroEditorPayload = null;
        }

        function saveIntroQuestionEditor() {
            if (!currentIntroEditorPayload) {
                return;
            }

            const trimmedQuestionText = document.getElementById('intro-question-editor-text').value.trim();
            const trimmedCorrectAnswer = document.getElementById('intro-question-editor-answer').value.trim();

            if (!trimmedQuestionText || !trimmedCorrectAnswer) {
                window.alert('Soal dan kunci jawaban wajib diisi.');
                return;
            }

            if (currentIntroEditorPayload.dbId) {
                const updateForm = document.getElementById('intro-question-update-form');
                updateForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroEditorPayload.dbId}`;
                document.getElementById('intro-update-section').value = `introductory_${currentIntroEditorPayload.meetingNumber}`;
                document.getElementById('intro-update-question-text').value = trimmedQuestionText;
                document.getElementById('intro-update-correct-answer').value = trimmedCorrectAnswer;
                updateForm.submit();
                return;
            }

            const createForm = document.getElementById('intro-question-create-form');
            document.getElementById('intro-create-meeting-number').value = currentIntroEditorPayload.meetingNumber;
            document.getElementById('intro-create-question-number').value = currentIntroEditorPayload.questionNumber;
            document.getElementById('intro-create-section').value = `introductory_${currentIntroEditorPayload.meetingNumber}`;
            document.getElementById('intro-create-question-text').value = trimmedQuestionText;
            document.getElementById('intro-create-correct-answer').value = trimmedCorrectAnswer;
            createForm.submit();
        }

        function deleteIntroQuestionOverride(dbId) {
            if (!window.confirm('Hapus override soal ini? Soal akan kembali ke default.')) {
                return;
            }

            const deleteForm = document.getElementById('intro-question-delete-form');
            deleteForm.action = `/admin/assignments/grammar-writing/questions/${dbId}`;
            deleteForm.submit();
        }

        function openIntroParagraphEditor(payload) {
            currentIntroParagraphPayload = payload;

            document.getElementById('intro-paragraph-editor-id').value = payload.paragraphId || '';
            document.getElementById('intro-paragraph-editor-en').value = payload.paragraphEn || '';

            const deleteButton = document.getElementById('intro-paragraph-editor-delete');
            if (payload.dbId) {
                deleteButton.classList.remove('hidden');
            } else {
                deleteButton.classList.add('hidden');
            }

            const modal = document.getElementById('intro-paragraph-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');

            setTimeout(() => {
                document.getElementById('intro-paragraph-editor-id').focus();
            }, 0);
        }

        function closeIntroParagraphEditor() {
            const modal = document.getElementById('intro-paragraph-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            currentIntroParagraphPayload = null;
        }

        function saveIntroParagraphEditor() {
            if (!currentIntroParagraphPayload) {
                return;
            }

            const paragraphId = document.getElementById('intro-paragraph-editor-id').value.trim();
            const paragraphEn = document.getElementById('intro-paragraph-editor-en').value.trim();

            if (!paragraphId || !paragraphEn) {
                window.alert('Paragraf Indonesia dan jawaban English wajib diisi.');
                return;
            }

            if (currentIntroParagraphPayload.dbId) {
                const updateForm = document.getElementById('intro-paragraph-update-form');
                updateForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroParagraphPayload.dbId}`;
                document.getElementById('intro-paragraph-update-section').value = `introductory_${currentIntroParagraphPayload.meetingNumber}_paragraph`;
                document.getElementById('intro-paragraph-update-id-text').value = paragraphId;
                document.getElementById('intro-paragraph-update-en-text').value = paragraphEn;
                updateForm.submit();
                return;
            }

            const createForm = document.getElementById('intro-paragraph-create-form');
            document.getElementById('intro-paragraph-create-meeting-number').value = currentIntroParagraphPayload.meetingNumber;
            document.getElementById('intro-paragraph-create-section').value = `introductory_${currentIntroParagraphPayload.meetingNumber}_paragraph`;
            document.getElementById('intro-paragraph-create-id-text').value = paragraphId;
            document.getElementById('intro-paragraph-create-en-text').value = paragraphEn;
            createForm.submit();
        }

        function deleteIntroParagraphOverride() {
            if (!currentIntroParagraphPayload || !currentIntroParagraphPayload.dbId) {
                return;
            }

            if (!window.confirm('Hapus override paragraf ini? Paragraf akan kembali ke default.')) {
                return;
            }

            const deleteForm = document.getElementById('intro-paragraph-delete-form');
            deleteForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroParagraphPayload.dbId}`;
            deleteForm.submit();
        }

        document.getElementById('intro-question-editor-save')?.addEventListener('click', saveIntroQuestionEditor);
        document.getElementById('intro-question-editor-cancel')?.addEventListener('click', closeIntroQuestionEditor);
        document.getElementById('intro-question-editor-close')?.addEventListener('click', closeIntroQuestionEditor);
        document.getElementById('intro-question-editor-overlay')?.addEventListener('click', closeIntroQuestionEditor);

        document.getElementById('intro-paragraph-editor-save')?.addEventListener('click', saveIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-cancel')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-close')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-overlay')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-delete')?.addEventListener('click', deleteIntroParagraphOverride);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                const modal = document.getElementById('intro-question-editor-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeIntroQuestionEditor();
                }

                const paragraphModal = document.getElementById('intro-paragraph-editor-modal');
                if (paragraphModal && !paragraphModal.classList.contains('hidden')) {
                    closeIntroParagraphEditor();
                }
            }
        });
    </script>

    <x-irregular-verbs-button />
    <x-dictionary-button />

    @if((int) ($meetingNumber ?? 0) === 10)
        <x-pronouns-button />
    @endif
    @include('components.student-broadcaster')
</body>
</html>
