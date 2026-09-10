<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        // Shared Turnstile callback — stores the latest verified token globally
        window.cfTurnstileToken = null;
        function onTurnstileVerified(token) {
            window.cfTurnstileToken = token;
        }
        function onTurnstileExpired() {
            window.cfTurnstileToken = null;
        }
    </script>
    <style>
        html,
        body {
            min-height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        @keyframes avatarPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }

            50% {
                box-shadow: 0 0 0 15px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        .avatar-speaking {
            animation: avatarPulse 1.5s infinite ease-in-out;
            border-color: #3b82f6 !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    @php
        $type = $type ?? 'grammar';
        $test = $test ?? null;
        $textToSpeak = '';
        if (str_starts_with($type, 'speaking')) {
            $textToSpeak .= "Part 1. ";
            if (isset($test->part1_questions) && is_array($test->part1_questions)) {
                $textToSpeak .= implode(' ', $test->part1_questions) . ' ';
            }
            $textToSpeak .= "Part 2. ";
            $questionsArray = isset($test->questions) ? (is_string($test->questions) ? json_decode($test->questions, true) : $test->questions) : [];
            if (is_array($questionsArray)) {
                $textToSpeak .= implode(' ', $questionsArray) . ' ';
            }
            $textToSpeak .= "Part 3. ";
            $part3Array = isset($test->part3_questions) ? (is_string($test->part3_questions) ? json_decode($test->part3_questions, true) : $test->part3_questions) : [];
            if (is_array($part3Array)) {
                $textToSpeak .= implode(' ', $part3Array);
            }
        } else {
            if (isset($test->prompt)) {
                $textToSpeak = $test->prompt;
            } elseif (isset($test->questions)) {
                $questionsArray = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;
                if (is_array($questionsArray)) {
                    $textToSpeak = implode(' ', $questionsArray);
                }
            }
        }

        // Combine idioms and collocations
        $allCollocations = [];
        $part2Collo = isset($test->collocations) ? (is_string($test->collocations) ? json_decode($test->collocations, true) : $test->collocations) : [];
        if (is_array($part2Collo))
            $allCollocations = array_merge($allCollocations, $part2Collo);
        $part3Collo = isset($test->part3_collocations) ? (is_string($test->part3_collocations) ? json_decode($test->part3_collocations, true) : $test->part3_collocations) : [];
        if (is_array($part3Collo))
            $allCollocations = array_merge($allCollocations, $part3Collo);

        $allIdioms = [];
        $part2Idioms = isset($test->idioms) ? (is_string($test->idioms) ? json_decode($test->idioms, true) : $test->idioms) : [];
        if (is_array($part2Idioms))
            $allIdioms = array_merge($allIdioms, $part2Idioms);
        $part3Idioms = isset($test->part3_idioms) ? (is_string($test->part3_idioms) ? json_decode($test->part3_idioms, true) : $test->part3_idioms) : [];
        if (is_array($part3Idioms))
            $allIdioms = array_merge($allIdioms, $part3Idioms);
    @endphp
    <div class="min-h-screen flex flex-col bg-gray-50"
        x-data="promoTest({ promptText: {{ json_encode($textToSpeak) }}, part1Questions: {{ json_encode($test?->part1_questions ?? []) }}, part2Questions: {{ json_encode(is_string($test?->questions ?? '[]') ? json_decode($test?->questions ?? '[]', true) : ($test?->questions ?? [])) }}, part3Questions: {{ json_encode(isset($test?->part3_questions) ? (is_string($test->part3_questions) ? json_decode($test->part3_questions, true) : $test->part3_questions) : []) }}, collocations: {{ json_encode($allCollocations) }}, idioms: {{ json_encode($allIdioms) }}, isSpeakingTest: {{ str_starts_with($type ?? 'grammar', 'speaking') ? 'true' : 'false' }}, isAdmin: {{ (auth()->user()?->isAdmin()) ? 'true' : 'false' }} })">

        <!-- Header (always visible) -->
        <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10 w-full pl-0">
            <div class="px-6 py-4 flex items-center justify-between relative">
                <div class="flex items-center gap-4 z-10">
                    @if(str_starts_with($type, 'speaking'))
                        <div class="p-2.5 bg-gradient-to-br from-gray-700 to-black rounded-xl shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </div>
                    @else
                        <div class="p-2.5 bg-gradient-to-br from-gray-700 to-black rounded-xl shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">{{ $test->title ?? ($trackTitle ?? 'Grammar Practice Test') }}</h1>
                        <p class="text-sm text-gray-500">Free Practice Test</p>
                    </div>
                </div>
            </div>
        </div>

    <div class="flex-1 bg-[#F3F4FF] p-4 sm:p-8 custom-scrollbar">
        <div class="max-w-3xl mx-auto">
            <form x-data="{ showReview: {{ ($submitted ?? false) ? 'true' : 'false' }} }" method="POST" action="{{ route('promo.test.grammar.submit', ['meeting' => $meetingNumber ?? 1]) }}" class="bg-white rounded-3xl shadow-sm border border-orange-100 overflow-visible">
                    @csrf

                    @if(!($submitted ?? false))
                        <div class="p-5 sm:p-8 bg-white border-b border-orange-100">
                            <h3 class="font-bold text-gray-800 mb-4 uppercase tracking-wide">Your Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $userAnswers['name'] ?? '') }}" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="John Doe">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $userAnswers['email'] ?? '') }}" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="john@example.com">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp Number (Optional)</label>
                                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $userAnswers['whatsapp_number'] ?? '') }}"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="+6281234567890">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(($submitted ?? false) === true)
                        <div class="bg-gradient-to-r from-orange-50 via-amber-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-orange-100">
                            <div class="rounded-2xl bg-orange-500 text-white px-4 py-4 shadow-sm">
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
                    </div>
                        @endif

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
                                                    <p class="text-gray-800 leading-relaxed font-medium">{{ $question }}</p>
                                                    @if(!empty($helper['vocab']))
                                                        <div class="flex flex-wrap gap-1 sm:gap-1.5 pt-1.5">
                                                            @foreach($helper['vocab'] as $enTerm => $vocabData)
                                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 bg-slate-50 hover:bg-orange-50/70 text-slate-700 text-[11px] sm:text-xs font-medium rounded-lg border border-slate-200/80 transition-colors">
                                                                    <strong class="text-orange-700">{{ $enTerm }}</strong>
                                                                    <span class="text-slate-400">=</span>
                                                                    <span>{{ is_array($vocabData) ? ($vocabData['id'] ?? '') : $vocabData }}</span>
                                                                    @if(is_array($vocabData) && !empty($vocabData['pos']))
                                                                        <span class="text-[9px] sm:text-[10px] px-1 py-0.2 bg-slate-200/80 text-slate-600 rounded font-mono">{{ trim($vocabData['pos'], '()') }}</span>
                                                                    @endif
                                                                </span>
                                                            @endforeach
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
                                        <p class="text-gray-800 leading-relaxed font-medium">{{ $question }}</p>
                                        @if(!empty($helper['vocab']))
                                            <div class="flex flex-wrap gap-1 sm:gap-1.5 pt-1.5">
                                                @foreach($helper['vocab'] as $enTerm => $vocabData)
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 bg-slate-50 hover:bg-orange-50/70 text-slate-700 text-[11px] sm:text-xs font-medium rounded-lg border border-slate-200/80 transition-colors">
                                                        <strong class="text-orange-700">{{ $enTerm }}</strong>
                                                        <span class="text-slate-400">=</span>
                                                        <span>{{ is_array($vocabData) ? ($vocabData['id'] ?? '') : $vocabData }}</span>
                                                        @if(is_array($vocabData) && !empty($vocabData['pos']))
                                                            <span class="text-[9px] sm:text-[10px] px-1 py-0.2 bg-slate-200/80 text-slate-600 rounded font-mono">{{ trim($vocabData['pos'], '()') }}</span>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if(Auth::user()?->isAdmin() && (int) $meetingNumber === 1)
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
                                    @if(Auth::user()?->isAdmin() && (int) $meetingNumber === 3)
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

                    @if(!($submitted ?? false))
                    <div class="pt-6 pb-6 border-t border-gray-100 flex flex-col items-center gap-2">
                        <a href="{{ url('/brochure/' . (request('b') ?: 'offline')) }}" target="_blank"
                            class="inline-flex items-center gap-2 text-sm text-red-600 hover:text-red-700 transition-colors group">
                            <svg class="w-4 h-4 text-red-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium underline decoration-transparent group-hover:decoration-red-300 underline-offset-4 transition-all">Informasi Kelas Grammar Target Bahasa</span>
                            <svg class="w-3.5 h-3.5 opacity-0 -ml-1 group-hover:opacity-100 group-hover:ml-0 transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                        <div class="mt-1 text-xs text-gray-500 text-center">
                            <p>Jalan Brawijaya 64 Pare Kediri - Kampung Inggris Pare</p>
                            <p class="mt-1 text-green-600 font-bold text-sm">WhatsApp 0857 0661 5607</p>
                        </div>
                        <div class="mt-4 cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}"
                            data-action="submit"
                            data-callback="onTurnstileVerified"
                            data-expired-callback="onTurnstileExpired"></div>
                    </div>
                    @endif

                    <div class="px-5 py-6 sm:px-8 border-t border-gray-100 bg-gray-50/60 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('promo.test.index') }}"
                           class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-300 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Promo Tes
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
                
                        @if(!($submitted ?? false))
                            <div class="mt-8 pt-6 pb-4 flex justify-center">
                                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-10 rounded-xl shadow-md transition-colors text-lg">
                                    Submit Answers
                                </button>
                            </div>
                        @else
                             <div class="mt-8 pt-6 pb-4 flex justify-center flex-col items-center gap-4">
                                <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-bold text-center w-full max-w-md shadow-sm">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-lg">Submit Successful!</span>
                                    </div>
                                    <p class="text-sm font-medium">Your score is {{ $score }} / 100.</p>
                                </div>
                                <a href="{{ url('/brochure/' . (request('b') ?: 'offline')) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-colors">
                                    Informasi Kelas Target Bahasa
                                </a>
                            </div>
                        @endif

</form>
        </div>
    </div>
</div>

@if(Auth::user()?->isAdmin())
    {{-- Hidden forms for question create/update/delete --}}
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

    {{-- Question Editor Modal --}}
    <div id="intro-question-editor-modal" class="fixed inset-0 z-[200] hidden" aria-hidden="true">
        <div id="intro-question-editor-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Editor Soal</h3>
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

    <script>
        let currentIntroEditorPayload = null;

        function openIntroQuestionEditor(payload) {
            currentIntroEditorPayload = payload;
            document.getElementById('intro-question-editor-number').textContent = `Meeting ${payload.meetingNumber} - Soal ${payload.questionNumber}`;
            document.getElementById('intro-question-editor-text').value = payload.questionText || '';
            document.getElementById('intro-question-editor-answer').value = payload.correctAnswer || '';
            const modal = document.getElementById('intro-question-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            setTimeout(() => { document.getElementById('intro-question-editor-text').focus(); }, 0);
        }

        function closeIntroQuestionEditor() {
            const modal = document.getElementById('intro-question-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            currentIntroEditorPayload = null;
        }

        function saveIntroQuestionEditor() {
            if (!currentIntroEditorPayload) return;
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
            if (!window.confirm('Hapus override soal ini? Soal akan kembali ke default.')) return;
            const deleteForm = document.getElementById('intro-question-delete-form');
            deleteForm.action = `/admin/assignments/grammar-writing/questions/${dbId}`;
            deleteForm.submit();
        }

        document.getElementById('intro-question-editor-save')?.addEventListener('click', saveIntroQuestionEditor);
        document.getElementById('intro-question-editor-cancel')?.addEventListener('click', closeIntroQuestionEditor);
        document.getElementById('intro-question-editor-close')?.addEventListener('click', closeIntroQuestionEditor);
        document.getElementById('intro-question-editor-overlay')?.addEventListener('click', closeIntroQuestionEditor);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                const modal = document.getElementById('intro-question-editor-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeIntroQuestionEditor();
                }
            }
        });
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

@include('assignments.ielts.writing.practice_toolbar', [
    'meeting' => (object)[
        'task_type' => 3,
        'prompt' => $test->title ?? 'Grammar Practice Test'
    ],
    'grammarLevel' => 'all'
])

</body>

</html>
