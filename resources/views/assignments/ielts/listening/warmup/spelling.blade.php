@extends('layouts.admin')

@section('content')
@php
    $allPackages = include base_path('config/ielts_spelling_warmup.php');
    $currentSet = isset($practice) ? (int) $practice : (int) request()->get('practice', 1);
    $currentSet = max(1, min(30, $currentSet));

    $currentPkg = $allPackages[$currentSet] ?? $allPackages[(string) $currentSet] ?? reset($allPackages);
    $spellingItems = $currentPkg['items'] ?? [];
    $pctA = $currentPkg['pct_a'] ?? 50;
    $pctB = $currentPkg['pct_b'] ?? 40;
    $pctC = $currentPkg['pct_c'] ?? 10;
    $countA = $currentPkg['count_a'] ?? 10;
    $countB = $currentPkg['count_b'] ?? 8;
    $countC = $currentPkg['count_c'] ?? 2;
    $focusLabel = $currentPkg['focus'] ?? 'Fokus Level A (A1 & A2)';
    $tier = $currentPkg['tier'] ?? 'A';
    $introStart = $currentPkg['intro_start'] ?? 0.0;
    $introEnd = $currentPkg['intro_end'] ?? 10.5;
@endphp

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 relative overflow-hidden py-8 font-sans"
     x-data="{ activeTier: '{{ $tier }}', showPackageGrid: false }">
    {{-- Background Decoration --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-indigo-200/40 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] rounded-full bg-purple-200/30 blur-3xl"></div>
        <div class="absolute top-[20%] left-[20%] w-[300px] h-[300px] rounded-full bg-white blur-2xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        {{-- Navigation --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('assignments.ielts-academic.listening.index') }}" 
               class="inline-flex items-center text-gray-500 hover:text-indigo-600 transition-colors group text-sm font-medium tracking-wide">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mr-3 shadow-sm group-hover:bg-indigo-50 transition-all">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span>Back to Skills</span>
            </a>
            <div class="flex items-center gap-2">
                @if($currentSet > 1)
                    <a href="{{ route('assignments.ielts-academic.listening.warmup', 'spelling') }}?practice={{ $currentSet - 1 }}"
                       class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:border-indigo-300 hover:text-indigo-600 shadow-sm transition-all">
                        &larr; Paket {{ $currentSet - 1 }}
                    </a>
                @endif
                <span class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-sm">
                    Paket {{ $currentSet }} / 30
                </span>
                @if($currentSet < 30)
                    <a href="{{ route('assignments.ielts-academic.listening.warmup', 'spelling') }}?practice={{ $currentSet + 1 }}"
                       class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:border-indigo-300 hover:text-indigo-600 shadow-sm transition-all">
                        Paket {{ $currentSet + 1 }} &rarr;
                    </a>
                @endif
            </div>
        </div>

        {{-- 30-Package Selector Card (3 Progressive Tiers: A, B, C) --}}
        <div class="mb-6 bg-white rounded-2xl shadow-lg border border-indigo-100 p-4 md:p-5">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                <div>
                    <h2 class="text-sm md:text-base font-extrabold text-slate-800 flex items-center gap-2">
                        <span>Pilih Paket Soal Spelling (30 Paket — Kosakata IELTS Part 1)</span>
                    </h2>
                    <p class="text-xs text-slate-500">Prosentase level kosakata meningkat bertahap dari Paket 1 (Fokus A1–A2) hingga Paket 30 (Fokus C1–C2)</p>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <button type="button" @click="activeTier = 'A'"
                            :class="activeTier === 'A' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer">
                        Paket 1–10 (Fokus A)
                    </button>
                    <button type="button" @click="activeTier = 'B'"
                            :class="activeTier === 'B' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100'"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer">
                        Paket 11–20 (Fokus B)
                    </button>
                    <button type="button" @click="activeTier = 'C'"
                            :class="activeTier === 'C' ? 'bg-purple-600 text-white shadow-sm' : 'bg-purple-50 text-purple-700 hover:bg-purple-100'"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer">
                        Paket 21–30 (Fokus C)
                    </button>
                </div>
            </div>

            {{-- Tier A (Packages 1-10) --}}
            <div x-show="activeTier === 'A'" class="grid grid-cols-2 sm:grid-cols-5 lg:grid-cols-10 gap-2">
                @for($s = 1; $s <= 10; $s++)
                    @php
                        $p = $allPackages[$s] ?? $allPackages[(string)$s] ?? [];
                        $isActive = ($s === $currentSet);
                    @endphp
                    <a href="{{ route('assignments.ielts-academic.listening.warmup', 'spelling') }}?practice={{ $s }}"
                       class="flex flex-col items-center justify-center p-2 rounded-xl border text-center transition-all {{ $isActive ? 'bg-emerald-600 text-white border-emerald-600 shadow-md scale-[1.02]' : 'bg-emerald-50/40 hover:bg-emerald-50 text-slate-700 border-emerald-200' }}">
                        <span class="text-xs font-extrabold">Paket {{ $s }}</span>
                        <span class="text-[10px] {{ $isActive ? 'text-emerald-100' : 'text-emerald-700' }} font-semibold mt-0.5">
                            A:{{ $p['pct_a'] ?? 50 }}% B:{{ $p['pct_b'] ?? 40 }}% C:{{ $p['pct_c'] ?? 10 }}%
                        </span>
                    </a>
                @endfor
            </div>

            {{-- Tier B (Packages 11-20) --}}
            <div x-show="activeTier === 'B'" style="display: none;" class="grid grid-cols-2 sm:grid-cols-5 lg:grid-cols-10 gap-2">
                @for($s = 11; $s <= 20; $s++)
                    @php
                        $p = $allPackages[$s] ?? $allPackages[(string)$s] ?? [];
                        $isActive = ($s === $currentSet);
                    @endphp
                    <a href="{{ route('assignments.ielts-academic.listening.warmup', 'spelling') }}?practice={{ $s }}"
                       class="flex flex-col items-center justify-center p-2 rounded-xl border text-center transition-all {{ $isActive ? 'bg-indigo-600 text-white border-indigo-600 shadow-md scale-[1.02]' : 'bg-indigo-50/40 hover:bg-indigo-50 text-slate-700 border-indigo-200' }}">
                        <span class="text-xs font-extrabold">Paket {{ $s }}</span>
                        <span class="text-[10px] {{ $isActive ? 'text-indigo-100' : 'text-indigo-700' }} font-semibold mt-0.5">
                            A:{{ $p['pct_a'] ?? 25 }}% B:{{ $p['pct_b'] ?? 55 }}% C:{{ $p['pct_c'] ?? 20 }}%
                        </span>
                    </a>
                @endfor
            </div>

            {{-- Tier C (Packages 21-30) --}}
            <div x-show="activeTier === 'C'" style="display: none;" class="grid grid-cols-2 sm:grid-cols-5 lg:grid-cols-10 gap-2">
                @for($s = 21; $s <= 30; $s++)
                    @php
                        $p = $allPackages[$s] ?? $allPackages[(string)$s] ?? [];
                        $isActive = ($s === $currentSet);
                    @endphp
                    <a href="{{ route('assignments.ielts-academic.listening.warmup', 'spelling') }}?practice={{ $s }}"
                       class="flex flex-col items-center justify-center p-2 rounded-xl border text-center transition-all {{ $isActive ? 'bg-purple-600 text-white border-purple-600 shadow-md scale-[1.02]' : 'bg-purple-50/40 hover:bg-purple-50 text-slate-700 border-purple-200' }}">
                        <span class="text-xs font-extrabold">Paket {{ $s }}</span>
                        <span class="text-[10px] {{ $isActive ? 'text-purple-100' : 'text-purple-700' }} font-semibold mt-0.5">
                            A:{{ $p['pct_a'] ?? 10 }}% B:{{ $p['pct_b'] ?? 30 }}% C:{{ $p['pct_c'] ?? 60 }}%
                        </span>
                    </a>
                @endfor
            </div>
        </div>

        {{-- Main Interface Card --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-800/10 ring-1 ring-white/10">
            
            {{-- Header Info --}}
            <div class="px-6 md:px-12 pt-10 pb-4">
                <div class="flex flex-wrap items-center gap-3 mb-3">
                    <span class="px-4 py-1.5 rounded-lg text-sm font-bold bg-orange-500 text-white uppercase tracking-wider shadow-lg shadow-orange-500/30">
                        Exercise 1.01 • Paket {{ $currentSet }}
                    </span>
                    <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $tier === 'A' ? 'bg-emerald-100 text-emerald-800' : ($tier === 'B' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800') }}">
                        {{ $focusLabel }}
                    </span>
                    <span class="text-slate-400 text-sm font-medium">IELTS Listening Part 1 Vocabulary • 20 Words</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-3">
                    Spelling Practice — Paket {{ $currentSet }}
                    <span class="block h-1 w-32 bg-orange-500 rounded-full mt-3"></span>
                </h1>
                <p class="text-slate-600 text-base md:text-lg max-w-2xl leading-relaxed mb-4">
                    Listen to the audio. Each word is read <span class="text-amber-600 font-bold">three times</span>. Type exactly what you hear.
                </p>

                {{-- CEFR Distribution Badges for Active Package --}}
                <div class="flex flex-wrap items-center gap-2 pt-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        {{ $pctA }}% A1 &amp; A2 ({{ $countA }} Kata)
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        {{ $pctB }}% B1 &amp; B2 ({{ $countB }} Kata)
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                        {{ $pctC }}% C1 &amp; C2 ({{ $countC }} Kata)
                    </span>
                </div>
            </div>

            {{-- Score Summary Banner (Hidden until Submit) --}}
            <div id="spellingScoreBanner" class="hidden mx-6 md:mx-10 mt-2 mb-2 p-5 rounded-2xl border-2 border-indigo-200 bg-gradient-to-r from-indigo-50 via-white to-purple-50 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-1">Hasil Latihan Spelling — Paket {{ $currentSet }}</div>
                        <div class="text-2xl md:text-3xl font-extrabold text-slate-900">
                            Skor: <span id="scoreTotalText" class="text-indigo-600">0 / 20</span>
                            <span id="scorePercentText" class="ml-2 text-base font-bold px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800">0%</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs font-bold">
                        <div class="px-3 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800">
                            A1–A2: <span id="scoreA1A2">0/{{ $countA }}</span>
                        </div>
                        <div class="px-3 py-2 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-800">
                            B1–B2: <span id="scoreB1B2">0/{{ $countB }}</span>
                        </div>
                        <div class="px-3 py-2 rounded-xl bg-purple-50 border border-purple-200 text-purple-800">
                            C1–C2: <span id="scoreC1C2">0/{{ $countC }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content Area --}}
            <div class="p-6 md:px-10 md:pb-10 bg-white min-h-[400px]">
                <form id="spellingForm" onsubmit="event.preventDefault(); submitSpellingAnswers();">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6">
                        @foreach($spellingItems as $idx => $item)
                        @php
                            $i = $item['num'];
                            $colors = [
                                ['bg' => 'bg-white', 'text' => 'text-orange-600', 'border' => 'border-orange-300', 'ring' => 'ring-orange-500/10', 'focus' => 'focus:border-orange-500'],
                                ['bg' => 'bg-white', 'text' => 'text-indigo-600', 'border' => 'border-indigo-300', 'ring' => 'ring-indigo-500/10', 'focus' => 'focus:border-indigo-500'],
                                ['bg' => 'bg-pink-100', 'text' => 'text-pink-600', 'border' => 'border-pink-300', 'ring' => 'ring-pink-500/10', 'focus' => 'focus:border-pink-500'],
                                ['bg' => 'bg-white', 'text' => 'text-teal-600', 'border' => 'border-teal-300', 'ring' => 'ring-teal-500/10', 'focus' => 'focus:border-teal-500'],
                            ];
                            $color = $colors[($i - 1) % 4];

                            $cefrBadgeClass = match($item['cefr']) {
                                'A1', 'A2' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'B1', 'B2' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                default    => 'bg-purple-50 text-purple-700 border-purple-200',
                            };
                        @endphp
                        <div class="group" data-question-card="{{ $i }}">
                            <div class="mb-2 flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    <div class="inline-block {{ $color['bg'] }} px-2.5 py-1 rounded-lg border {{ $color['border'] }} shadow-sm text-sm font-bold {{ $color['text'] }} transition-all group-focus-within:scale-110">
                                        {{ $i }}
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md border text-[11px] font-bold {{ $cefrBadgeClass }}">
                                        {{ $item['cefr'] }}
                                    </span>
                                </div>
                                <button type="button"
                                        onclick="jumpToTime({{ $item['start'] ?? 0 }})"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors cursor-pointer"
                                        title="Putar audio nomor {{ $i }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6l-4 4H5v4h3l4 4V6z"></path>
                                    </svg>
                                </button>
                            </div>
                            <input type="text"
                                   id="spellingInput_{{ $i }}"
                                   name="q{{ $i }}"
                                   data-num="{{ $i }}"
                                   data-answer="{{ $item['word'] }}"
                                   data-cefr="{{ $item['cefr'] }}"
                                   data-group="{{ $item['group'] }}"
                                   data-meaning="{{ $item['id'] }}"
                                   class="spelling-input w-full h-14 pl-4 pr-4 bg-white border-2 border-slate-200 rounded-xl text-slate-800 text-lg font-semibold focus:outline-none focus:ring-4 {{ $color['ring'] }} {{ $color['focus'] }} transition-all placeholder-slate-400 shadow-sm hover:border-slate-300 hover:shadow-md"
                                   placeholder="Type answer..."
                                   autocomplete="off">
                            {{-- Feedback / Answer Key Pill --}}
                            <div id="spellingFeedback_{{ $i }}" class="hidden mt-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border"></div>
                            <div id="spellingKey_{{ $i }}" class="spelling-key-box hidden mt-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-50 border border-amber-200 text-amber-900">
                                <span class="font-bold text-amber-700">Key:</span> {{ $item['word'] }}
                                <span class="text-slate-500 font-normal">({{ $item['id'] }})</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
            
            {{-- Footer / Actions --}}
            <div class="bg-white border-t border-slate-100 p-6 md:px-12 md:py-8 flex flex-wrap justify-between items-center gap-4">
                <button type="button" onclick="resetSpellingForm()" class="text-slate-400 hover:text-slate-600 text-base font-medium transition-colors cursor-pointer">
                    Reset Form
                </button>
                <div class="flex items-center gap-3">
                    @if($currentSet < 30)
                        <a href="{{ route('assignments.ielts-academic.listening.warmup', 'spelling') }}?practice={{ $currentSet + 1 }}"
                           class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-bold transition-all">
                            Paket Berikutnya ({{ $currentSet + 1 }}) &rarr;
                        </a>
                    @endif
                    <button type="button" onclick="submitSpellingAnswers()" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow-lg shadow-orange-500/30 text-base font-bold tracking-wide transition-all transform hover:-translate-y-0.5 hover:shadow-xl cursor-pointer">
                        Submit Answers
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- Floating Transcript & Terjemahan Drawer (Above Bottom Audio Player) --}}
    <div id="transcriptDrawer" class="hidden fixed bottom-20 left-0 right-0 md:left-64 z-40 px-4 pointer-events-none">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-2xl border border-indigo-200 overflow-hidden pointer-events-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200 h-72 md:h-80">
                {{-- English Script --}}
                <div class="flex flex-col h-full bg-white overflow-hidden">
                    <div class="flex-none px-4 py-2.5 bg-indigo-50/70 border-b border-indigo-100 font-bold text-indigo-900 text-sm flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/w20/gb.png" alt="UK" class="rounded-sm">
                            <span>English Audio Script — Paket {{ $currentSet }}</span>
                        </div>
                        <span class="text-[11px] font-semibold text-indigo-600">Klik baris untuk putar</span>
                    </div>
                    <div id="transcriptScrollEn" class="flex-1 p-4 overflow-y-auto space-y-2 text-sm text-slate-700">
                        <div class="transcript-line p-2 rounded-lg cursor-pointer hover:bg-indigo-50/60 transition-colors"
                             data-start="{{ $introStart }}" data-end="{{ $introEnd }}" onclick="jumpToTime({{ $introStart }})">
                            <span class="font-bold text-indigo-700">Intro:</span> IELTS Listening Spelling Practice. Listen to the audio. Each word is read three times. Type the word you hear.
                        </div>
                        @foreach($spellingItems as $item)
                            <div class="transcript-line p-2 rounded-lg cursor-pointer hover:bg-indigo-50/60 transition-colors flex items-center justify-between gap-2"
                                 data-start="{{ $item['start'] ?? 0 }}" data-end="{{ $item['end'] ?? 0 }}"
                                 onclick="jumpToTime({{ $item['start'] ?? 0 }})">
                                <div>
                                    <span class="font-bold text-slate-900">{{ $item['num'] }}.</span>
                                    <span class="font-semibold text-indigo-700">{{ $item['word'] }}</span>
                                    <span class="text-slate-400">— {{ $item['word'] }} — {{ $item['word'] }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">{{ $item['cefr'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Indonesian Translation --}}
                <div class="flex flex-col h-full bg-white overflow-hidden">
                    <div class="flex-none px-4 py-2.5 bg-purple-50/70 border-b border-purple-100 font-bold text-purple-900 text-sm flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm">
                            <span>Terjemahan &amp; Level Kosakata — Paket {{ $currentSet }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs font-medium text-purple-800 bg-white px-2 py-0.5 rounded border border-purple-200">
                                <input type="checkbox" id="autoscrollCheckbox" class="w-3.5 h-3.5 text-indigo-600 rounded" checked onchange="toggleAutoscroll(this.checked)">
                                <span>Autoscroll</span>
                            </label>
                            <button type="button" onclick="toggleTranscriptDrawer()" class="text-slate-400 hover:text-slate-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="transcriptScrollId" class="flex-1 p-4 overflow-y-auto space-y-2 text-sm text-slate-700">
                        <div class="transcript-line p-2 rounded-lg cursor-pointer hover:bg-purple-50/60 transition-colors"
                             data-start="{{ $introStart }}" data-end="{{ $introEnd }}" onclick="jumpToTime({{ $introStart }})">
                            <span class="font-bold text-purple-700">Instruksi:</span> Latihan Ejaan (Spelling) IELTS Listening. Dengarkan audio. Setiap kata dibacakan tiga kali. Ketik kata yang Anda dengar.
                        </div>
                        @foreach($spellingItems as $item)
                            <div class="transcript-line p-2 rounded-lg cursor-pointer hover:bg-purple-50/60 transition-colors flex items-center justify-between gap-2"
                                 data-start="{{ $item['start'] ?? 0 }}" data-end="{{ $item['end'] ?? 0 }}"
                                 onclick="jumpToTime({{ $item['start'] ?? 0 }})">
                                <div>
                                    <span class="font-bold text-slate-900">{{ $item['num'] }}.</span>
                                    <span class="font-semibold text-purple-800">{{ $item['word'] }}</span>
                                    <span class="text-slate-600">= {{ $item['id'] }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-800">Level {{ $item['cefr'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Fixed Audio Player (TOEFL style) --}}
    @include('assignments.ielts.listening.partials.audio-player-toefl-style', ['set' => $currentSet, 'fixed' => true])

</div>

@push('scripts')
<style>
    @keyframes slide-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-down {
        animation: slide-down 0.3s ease-out forwards;
    }
</style>
@include('assignments.ielts.listening.partials.audio-player-scripts')
<script>
    let isSpellingKeyVisible = false;

    window.toggleTranscriptDrawer = function() {
        const drawer = document.getElementById('transcriptDrawer');
        if (drawer) {
            drawer.classList.toggle('hidden');
        }
    };

    window.toggleAnswerKey = function() {
        isSpellingKeyVisible = !isSpellingKeyVisible;
        const keyBoxes = document.querySelectorAll('.spelling-key-box');
        const keyBtn = document.getElementById('toggleKeyBtn');

        keyBoxes.forEach(box => {
            if (isSpellingKeyVisible) {
                box.classList.remove('hidden');
            } else {
                box.classList.add('hidden');
            }
        });

        if (keyBtn) {
            if (isSpellingKeyVisible) {
                keyBtn.classList.remove('bg-white', 'text-yellow-700');
                keyBtn.classList.add('bg-yellow-400', 'text-black');
            } else {
                keyBtn.classList.add('bg-white', 'text-yellow-700');
                keyBtn.classList.remove('bg-yellow-400', 'text-black');
            }
        }
    };

    window.submitSpellingAnswers = function() {
        const inputs = document.querySelectorAll('.spelling-input');
        let totalCorrect = 0;
        let a1a2Correct = 0;
        let b1b2Correct = 0;
        let c1c2Correct = 0;

        inputs.forEach(input => {
            const num = input.dataset.num;
            const expected = (input.dataset.answer || '').trim();
            const group = input.dataset.group;
            const meaning = input.dataset.meaning;
            const cefr = input.dataset.cefr;
            const userVal = (input.value || '').trim();
            const feedbackEl = document.getElementById('spellingFeedback_' + num);

            const isCorrect = userVal.toLowerCase() === expected.toLowerCase();

            input.classList.remove('border-slate-200', 'border-emerald-500', 'border-rose-500', 'bg-white', 'bg-emerald-50/40', 'bg-rose-50/40');

            if (isCorrect) {
                totalCorrect++;
                if (group === 'A1-A2') a1a2Correct++;
                else if (group === 'B1-B2') b1b2Correct++;
                else if (group === 'C1-C2') c1c2Correct++;

                input.classList.add('border-emerald-500', 'bg-emerald-50/40');
                if (feedbackEl) {
                    feedbackEl.className = 'mt-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border bg-emerald-50 border-emerald-200 text-emerald-800';
                    feedbackEl.innerHTML = `✓ Benar! <span class="font-bold">${expected}</span> <span class="text-emerald-600 font-normal">(${meaning} • ${cefr})</span>`;
                }
            } else {
                input.classList.add('border-rose-500', 'bg-rose-50/40');
                if (feedbackEl) {
                    feedbackEl.className = 'mt-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border bg-rose-50 border-rose-200 text-rose-800';
                    feedbackEl.innerHTML = `✕ Jawaban: <span class="font-bold">${expected}</span> <span class="text-rose-600 font-normal">(${meaning} • ${cefr})</span>`;
                }
            }
        });

        const banner = document.getElementById('spellingScoreBanner');
        const totalText = document.getElementById('scoreTotalText');
        const percentText = document.getElementById('scorePercentText');
        const scoreA1A2 = document.getElementById('scoreA1A2');
        const scoreB1B2 = document.getElementById('scoreB1B2');
        const scoreC1C2 = document.getElementById('scoreC1C2');

        const pct = Math.round((totalCorrect / 20) * 100);
        if (totalText) totalText.textContent = `${totalCorrect} / 20`;
        if (percentText) percentText.textContent = `${pct}%`;
        if (scoreA1A2) scoreA1A2.textContent = `${a1a2Correct}/{{ $countA }}`;
        if (scoreB1B2) scoreB1B2.textContent = `${b1b2Correct}/{{ $countB }}`;
        if (scoreC1C2) scoreC1C2.textContent = `${c1c2Correct}/{{ $countC }}`;

        if (banner) {
            banner.classList.remove('hidden');
            banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    };

    window.resetSpellingForm = function() {
        const inputs = document.querySelectorAll('.spelling-input');
        inputs.forEach(input => {
            input.value = '';
            input.classList.remove('border-emerald-500', 'border-rose-500', 'bg-emerald-50/40', 'bg-rose-50/40');
            input.classList.add('border-slate-200', 'bg-white');
            const num = input.dataset.num;
            const feedbackEl = document.getElementById('spellingFeedback_' + num);
            if (feedbackEl) {
                feedbackEl.className = 'hidden mt-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border';
                feedbackEl.innerHTML = '';
            }
        });
        const banner = document.getElementById('spellingScoreBanner');
        if (banner) banner.classList.add('hidden');
    };
</script>
@endpush

@endsection
