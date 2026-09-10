<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 4</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .word-correct { color: #2ecc71; font-weight: bold; }
        .word-extra { color: #3498db; font-weight: bold; text-decoration: line-through; }
        .word-missing { color: #f1c40f; font-weight: bold; }
        .word-wrong { color: #e74c3c; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div x-data="{ editMode: false, editId: null, editSection: '', editQ: '', editA: '', editTense: '', editStructure: '' }" class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        @php
            $currentUser = auth()->user();
            $isTeacherUser = $currentUser?->isTeacher() ?? false;
            $isAdminUser = $currentUser?->isAdmin() ?? false;
        @endphp

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <a href="{{ $backRoute ?? route('assignments.grammar-writing') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
                <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>

            <!-- Mode Switcher & Actions (Hidden for Teacher, Display Only / Non-Functional for Admin) -->
            @if(!$isTeacherUser)
                <div class="flex flex-wrap items-center gap-2.5">
                    @if($isAdminUser)
                        <!-- Admin Preview Only: Repeat Button (Non-functional) -->
                        <button type="button" 
                                onclick="showAdminMockToast('Ulangi Soal Ini')" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-amber-50 text-gray-700 border border-gray-300 rounded-xl text-xs sm:text-sm font-semibold shadow-xs transition group cursor-pointer"
                                title="Mode Admin: Tampilan tombol Repeat">
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Ulangi Soal Ini</span>
                        </button>

                        <!-- Admin Preview Only: AI Variation Button (Non-functional) -->
                        <button type="button" 
                                onclick="showAdminMockToast('Latihan Variasi Baru (AI)')" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition cursor-pointer"
                                title="Mode Admin: Tampilan tombol Variasi AI">
                            <span>✨ Latihan Variasi Baru (AI)</span>
                            <span class="bg-white/20 px-1.5 py-0.5 rounded text-[10px] uppercase tracking-wider">New Vocab</span>
                        </button>
                    @else
                        <!-- Student: Fully Functional Repeat Button -->
                        <button type="button" 
                                onclick="confirmRepeatMeeting()" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-amber-50 text-gray-700 hover:text-amber-800 border border-gray-300 hover:border-amber-200 rounded-xl text-xs sm:text-sm font-semibold shadow-xs transition active:scale-95 group"
                                title="Kosongkan jawaban & kerjakan ulang soal yang sama dari awal">
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Ulangi Soal Ini</span>
                        </button>

                        @if(!empty($isAiVariation))
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-700 border border-purple-200 rounded-xl text-xs font-bold shadow-xs">
                                <span>✨ Soal AI (Attempt #{{ $aiAttempt ?? 1 }})</span>
                            </div>
                            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.switch-mode'), PHP_URL_PATH) }}" class="inline">
                                @csrf
                                <input type="hidden" name="mode" value="default">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 rounded-xl text-xs sm:text-sm font-bold shadow-xs transition group cursor-pointer" title="Tampilkan kembali bank soal asli saat ini (bukan buatan AI)">
                                    <svg class="w-4 h-4 text-blue-600 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span>Soal Asli</span>
                                </button>
                            </form>
                            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.ai-variation'), PHP_URL_PATH) }}" onsubmit="showAiLoadingModal()" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-xl text-xs sm:text-sm font-bold shadow-sm transition">
                                    <span>✨ Variasi Baru Lagi</span>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.ai-variation'), PHP_URL_PATH) }}" onsubmit="showAiLoadingModal()" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:opacity-95 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                                    <span>✨ Latihan Variasi Baru (AI)</span>
                                    <span class="bg-white/20 px-1.5 py-0.5 rounded text-[10px] uppercase tracking-wider">New Vocab</span>
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            @endif
        </div>

        @if($stage === 3)
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 text-white p-6 sm:p-8 rounded-2xl text-center mb-8 shadow-lg relative overflow-hidden">
                <h2 class="text-2xl font-bold mb-2">Nilai Akhir: {{ $totalScore }} / 100</h2>
                <p class="text-lg opacity-90 mb-4">
                    {{ $totalScore >= 80 ? 'Luar biasa! Pemahaman kalimat negatifmu sangat baik.' : ($totalScore >= 60 ? 'Bagus, terus berlatih!' : 'Jangan menyerah, coba lagi!') }}
                </p>
                <div class="flex justify-center gap-4 text-sm mb-6">
                    <span class="bg-white/20 px-3.5 py-1.5 rounded-lg font-semibold">Part 1 (Kalimat): {{ $scorePart1 }}/50</span>
                    <span class="bg-white/20 px-3.5 py-1.5 rounded-lg font-semibold">Part 2 (Matrix): {{ $scorePart2 }}/50</span>
                </div>
                @if(!$isTeacherUser)
                    <div class="flex flex-wrap justify-center gap-3">
                        @if($isAdminUser)
                            <button type="button" onclick="showAdminMockToast('Drill Lagi dengan Soal Baru (AI)')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-400 text-gray-900 rounded-xl font-bold text-sm shadow-md transition cursor-pointer">
                                <span>✨ Drill Lagi dengan Soal Baru (AI)</span>
                            </button>
                            <button type="button" onclick="showAdminMockToast('Ulangi Soal Ini')" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 text-white rounded-xl font-semibold text-sm transition cursor-pointer">
                                <span>Ulangi Soal Ini</span>
                            </button>
                        @else
                            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.ai-variation'), PHP_URL_PATH) }}" onsubmit="showAiLoadingModal()" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-xl font-bold text-sm shadow-md transition transform hover:scale-105">
                                    <span>✨ Drill Lagi dengan Soal Baru (AI)</span>
                                </button>
                            </form>
                            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.reset'), PHP_URL_PATH) }}" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white rounded-xl font-semibold text-sm transition">
                                    <span>Ulangi Soal Ini</span>
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        @if(!empty($isAiVariation))
            <div class="mb-6 bg-gradient-to-r from-purple-50 via-indigo-50 to-blue-50 border border-purple-200 p-4 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center text-lg font-bold shadow-xs">✨</span>
                    <div>
                        <p class="text-sm font-bold text-purple-900">Mode Latihan: Soal Variasi Baru AI (Attempt #{{ $aiAttempt ?? 1 }})</p>
                        <p class="text-xs text-purple-700">Soal-soal di bawah ini adalah variasi kosakata baru dari AI. Ingin kembali ke bank soal kurikulum?</p>
                    </div>
                </div>
                <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.switch-mode'), PHP_URL_PATH) }}" class="inline shrink-0">
                    @csrf
                    <input type="hidden" name="mode" value="default">
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-blue-50 text-blue-700 border border-blue-200 rounded-xl text-xs sm:text-sm font-bold shadow-xs transition">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span>Soal Asli</span>
                    </button>
                </form>
            </div>
        @endif

        <h1 class="text-3xl font-bold text-center text-blue-600 mb-2">Pertemuan 4 - Kalimat Negatif</h1>
        <p class="text-center text-gray-600 mb-6 text-lg font-medium">Translate setiap kalimat negatif berdasarkan tensesnya</p>

        <!-- Penjelasan Materi & Summary Chart Kalimat Negatif -->
        <div x-data="{ showSummary: true }" class="mb-8 bg-gradient-to-br from-blue-50/80 via-indigo-50/50 to-white rounded-2xl border border-blue-200 shadow-sm overflow-hidden transition-all">
            <!-- Header Accordion -->
            <div class="px-5 py-4 sm:px-6 bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex items-center justify-between cursor-pointer" @click="showSummary = !showSummary">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-lg shadow-xs">📘</span>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold">Panduan & Ringkasan Materi Kalimat Negatif</h2>
                        <p class="text-xs text-blue-100 hidden sm:block">Pelajari aturan penempatan "not", rumus 3 struktur (Verbal, Nominal, Pasif), dan tabel tenses di bawah ini.</p>
                    </div>
                </div>
                <button type="button" class="px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs font-semibold rounded-lg transition-colors flex items-center gap-1.5 shrink-0">
                    <span x-text="showSummary ? 'Sembunyikan' : 'Tampilkan Materi'"></span>
                    <svg :class="showSummary ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <!-- Body Materi -->
            <div x-show="showSummary" x-transition class="p-5 sm:p-7 space-y-6">
                <!-- 3 Struktur Pilar -->
                <div>
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        1. Tiga Pilar Struktur Kalimat Negatif
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Verbal -->
                        <div class="bg-white p-4 rounded-xl border border-blue-100 shadow-xs">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-blue-700 text-sm">1. Verbal (Aktivitas)</span>
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md">Action</span>
                            </div>
                            <div class="bg-blue-50/70 p-2 rounded-lg text-xs font-mono text-blue-950 font-bold mb-2">
                                S + Aux / Modal + NOT + V1
                            </div>
                            <p class="text-xs text-gray-600 mb-2">Digunakan untuk tindakan/aktivitas. Menggunakan <em>do/does/did not + V1</em> atau <em>Aux/Modal + not + Verb</em>.</p>
                            <div class="text-[11px] text-gray-700 bg-gray-50 p-2 rounded border border-gray-100 italic">
                                "She does not eat rice."<br>
                                "They did not come yesterday."
                            </div>
                        </div>

                        <!-- Nominal -->
                        <div class="bg-white p-4 rounded-xl border border-indigo-100 shadow-xs">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-indigo-700 text-sm">2. Nominal (Sifat/Benda)</span>
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-md">State / Being</span>
                            </div>
                            <div class="bg-indigo-50/70 p-2 rounded-lg text-xs font-mono text-indigo-950 font-bold mb-2">
                                S + To Be/Modal + NOT + Adj/N
                            </div>
                            <p class="text-xs text-gray-600 mb-2">Digunakan untuk menyatakan sifat, profesi, identitas, atau lokasi tanpa kata kerja aksi.</p>
                            <div class="text-[11px] text-gray-700 bg-gray-50 p-2 rounded border border-gray-100 italic">
                                "He is not sad today."<br>
                                "They were not ready last night."
                            </div>
                        </div>

                        <!-- Pasif -->
                        <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-xs">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-purple-700 text-sm">3. Pasif (Dikenai Aksi)</span>
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 bg-purple-50 text-purple-700 rounded-md">Passive</span>
                            </div>
                            <div class="bg-purple-50/70 p-2 rounded-lg text-xs font-mono text-purple-950 font-bold mb-2">
                                S + To Be/Modal + NOT + V3
                            </div>
                            <p class="text-xs text-gray-600 mb-2">Subjek menerima perlakuan/dikenai pekerjaan (bermakna "di-" atau "ter-").</p>
                            <div class="text-[11px] text-gray-700 bg-gray-50 p-2 rounded border border-gray-100 italic">
                                "The book is not read."<br>
                                "The report was not submitted."
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Matrix Tenses Table -->
                <div>
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        2. Tabel Rumus Lengkap Kalimat Negatif Berdasarkan Tenses
                    </h3>
                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs bg-white">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs min-w-[620px]">
                                <thead>
                                    <tr class="bg-gray-800 text-white text-[11px] uppercase tracking-wider">
                                        <th class="p-3 font-semibold border-b border-gray-700">Tenses</th>
                                        <th class="p-3 font-semibold border-b border-gray-700 text-blue-300">Verbal Negatif</th>
                                        <th class="p-3 font-semibold border-b border-gray-700 text-indigo-300">Nominal Negatif</th>
                                        <th class="p-3 font-semibold border-b border-gray-700 text-purple-300">Pasif Negatif</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-700">
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="p-3 font-bold text-gray-900">Simple Present<br><span class="text-[10px] text-gray-400 font-normal">Fakta / Kebiasaan</span></td>
                                        <td class="p-3">
                                            <div class="font-mono text-blue-900 font-bold">do / does not + V1</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">They do not ignore / He does not ignore</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-indigo-900 font-bold">am / is / are + not + Adj/N</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">I am not / He is not / They are not</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-purple-900 font-bold">am / is / are + not + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The rules are not ignored</div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="p-3 font-bold text-gray-900">Present Continuous<br><span class="text-[10px] text-gray-400 font-normal">Sedang berlangsung</span></td>
                                        <td class="p-3">
                                            <div class="font-mono text-blue-900 font-bold">am/is/are + not + V-ing</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">Scientists are not testing the vaccine</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-indigo-900 font-bold">am/is/are + not + being + Adj</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">He is not being cooperative</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-purple-900 font-bold">am/is/are + not + being + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The car is not being washed</div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="p-3 font-bold text-gray-900">Present Perfect<br><span class="text-[10px] text-gray-400 font-normal">Sudah / belum terjadi</span></td>
                                        <td class="p-3">
                                            <div class="font-mono text-blue-900 font-bold">have / has + not + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">They have not applied the method</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-indigo-900 font-bold">have / has + not + been + Adj/N</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">She has not been here before</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-purple-900 font-bold">have / has + not + been + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The letter has not been sent</div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="p-3 font-bold text-gray-900">Simple Past<br><span class="text-[10px] text-gray-400 font-normal">Masa lampau spesifik</span></td>
                                        <td class="p-3">
                                            <div class="font-mono text-blue-900 font-bold">did not + V1</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">Researchers did not find evidence</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-indigo-900 font-bold">was / were + not + Adj/N</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The station was not active last year</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-purple-900 font-bold">was / were + not + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The cake was not eaten</div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="p-3 font-bold text-gray-900">Past Continuous<br><span class="text-[10px] text-gray-400 font-normal">Sedang berlangsung di masa lalu</span></td>
                                        <td class="p-3">
                                            <div class="font-mono text-blue-900 font-bold">was/were + not + V-ing</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The team was not drilling rocks</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-indigo-900 font-bold">was/were + not + being + Adj</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">They were not being honest</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-purple-900 font-bold">was/were + not + being + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The bridge was not being repaired</div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="p-3 font-bold text-gray-900">Past Perfect<br><span class="text-[10px] text-gray-400 font-normal">Terjadi sebelum lampau lain</span></td>
                                        <td class="p-3">
                                            <div class="font-mono text-blue-900 font-bold">had not + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The species had not become extinct</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-indigo-900 font-bold">had not + been + Adj/N</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The area had not been safe</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-purple-900 font-bold">had not + been + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The files had not been archived</div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="p-3 font-bold text-gray-900">Future & Modals<br><span class="text-[10px] text-gray-400 font-normal">will, can, must, should, etc.</span></td>
                                        <td class="p-3">
                                            <div class="font-mono text-blue-900 font-bold">Modal + not + V1</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">AI will not replace all doctors</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-indigo-900 font-bold">Modal + not + be + Adj/N</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">The assumption will not be accurate</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-mono text-purple-900 font-bold">Modal + not + be + V3</div>
                                            <div class="text-[11px] text-gray-500 italic mt-0.5">Waste should not be disposed of</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 4 Aturan Emas & Tips Penting -->
                <div class="bg-blue-50/90 border border-blue-200 text-blue-950 p-4 sm:p-5 rounded-xl text-xs space-y-2.5">
                    <strong class="block text-sm font-bold text-blue-900 flex items-center gap-1.5">
                        <span>💡</span> Aturan Emas & Tips Menghindari Kesalahan Umum:
                    </strong>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-800">
                        <div class="bg-white p-3 rounded-lg border border-blue-100 shadow-2xs">
                            <span class="font-bold text-blue-800 block mb-1">1. Posisi Kata "NOT"</span>
                            Kata <strong>"not"</strong> selalu diletakkan tepat setelah <em>Auxiliary / To Be / Modal</em> <strong>pertama</strong>.<br>
                            Contoh: <code class="text-blue-700">have not been</code> (bukan <em>have been not</em>), <code class="text-blue-700">will not be</code> (bukan <em>will be not</em>).
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-blue-100 shadow-2xs">
                            <span class="font-bold text-blue-800 block mb-1">2. Wajib Kembali ke Verb 1</span>
                            Setelah <code class="text-red-700">do not</code>, <code class="text-red-700">does not</code>, atau <code class="text-red-700">did not</code>, kata kerja <strong>wajib kembali ke V1 polos</strong> (tanpa <em>-s/-es</em> atau <em>V2</em>).<br>
                            ❌ <em>He did not found...</em> ➔ ✔️ <code class="text-green-700">He did not find...</code>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-blue-100 shadow-2xs">
                            <span class="font-bold text-blue-800 block mb-1">3. Kesesuaian Subjek (Subject-Verb Agreement)</span>
                            • Subjek Tunggal (<em>He/She/It/Singular</em>): <code class="text-blue-700">does not</code> / <code class="text-blue-700">is not</code> / <code class="text-blue-700">has not</code> / <code class="text-blue-700">was not</code>.<br>
                            • Subjek Jamak (<em>You/We/They/Plural</em>): <code class="text-blue-700">do not</code> / <code class="text-blue-700">are not</code> / <code class="text-blue-700">have not</code> / <code class="text-blue-700">were not</code>.
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-blue-100 shadow-2xs">
                            <span class="font-bold text-blue-800 block mb-1">4. Penulisan Baku Akademik</span>
                            Gunakan bentuk pemisah penuh (<code class="text-blue-700">does not</code>, <code class="text-blue-700">did not</code>, <code class="text-blue-700">will not</code>, <code class="text-blue-700">cannot</code>) untuk standar tes penulisan formal (IELTS / TOEFL Writing).
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.submit'), PHP_URL_PATH) }}" id="meetingAnswerForm">
            @csrf

            <div x-data="{ tab: 'matrix' }">
                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200 mb-8 mt-4">
                    <button type="button"
                            @click="tab = 'matrix'"
                            :class="tab === 'matrix' ? 'border-blue-500 text-blue-600 border-b-2' : 'text-gray-500 hover:text-gray-700'"
                            class="py-3 px-6 font-bold text-lg transition-colors flex-1 text-center">
                        Latihan Matrix Tenses
                    </button>
                    <button type="button"
                            @click="tab = 'sentences'"
                            :class="tab === 'sentences' ? 'border-blue-500 text-blue-600 border-b-2' : 'text-gray-500 hover:text-gray-700'"
                            class="py-3 px-6 font-bold text-lg transition-colors flex-1 text-center">
                        Latihan Kalimat
                    </button>
                </div>

                <!-- Tab 1: Sentences -->
                <div x-show="tab === 'sentences'" x-transition style="display: none;">
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-6 rounded-xl mb-8">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-bold mb-2 flex items-center">
                                    <span class="bg-blue-200 text-blue-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">1</span>
                                    Identifikasi Tenses
                                </h3>
                                <p class="text-sm text-blue-700">Lihat kolom "Tenses" untuk mengetahui pola kalimat yang harus digunakan.</p>
                            </div>
                            <div>
                                <h3 class="font-bold mb-2 flex items-center">
                                    <span class="bg-blue-200 text-blue-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">2</span>
                                    Terjemahkan
                                </h3>
                                <p class="text-sm text-blue-700">Sisipkan "not" setelah auxiliary/to-be/modal pertama sesuai rumus tenses tersebut.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Grammar Cheat Sheet -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-sm">
                            <h4 class="font-bold text-blue-800 mb-2">Simple Present Negatif Verbal</h4>
                            <ul class="space-y-1 text-gray-700">
                                <li>I/ You/ We/ They/ Benda Jamak + <span class="font-bold">do not + Verb 1</span></li>
                                <li>He/ She/ It/ Benda Tunggal + <span class="font-bold">does not + Verb 1</span></li>
                            </ul>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-sm">
                            <h4 class="font-bold text-blue-800 mb-2">Simple Present Negatif Nominal</h4>
                            <ul class="space-y-1 text-gray-700">
                                <li>I + <span class="font-bold">am not</span></li>
                                <li>You/ We/ They/ Benda Jamak + <span class="font-bold">are not</span></li>
                                <li>He/ She/ It/ Benda Tunggal + <span class="font-bold">is not</span></li>
                            </ul>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-sm">
                            <h4 class="font-bold text-blue-800 mb-2">Present Perfect Negatif</h4>
                            <ul class="space-y-1 text-gray-700">
                                <li>I/ You/ We/ They/ Benda Jamak + <span class="font-bold">have not + V3</span></li>
                                <li>He/ She/ It/ Benda Tunggal + <span class="font-bold">has not + V3</span></li>
                            </ul>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-sm">
                            <h4 class="font-bold text-blue-800 mb-2">Simple Past Negatif</h4>
                            <ul class="space-y-1 text-gray-700">
                                <li>Semua subjek + <span class="font-bold">did not + Verb 1</span> (verbal)</li>
                                <li>I/ He/ She/ It/ Benda Tunggal + <span class="font-bold">was not</span> (nominal)</li>
                                <li>You/ We/ They/ Benda Jamak + <span class="font-bold">were not</span> (nominal)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Translation Sentences -->
                    <div class="space-y-6 mb-8">
                        @foreach($translationSentences as $idx => $item)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-center mb-1">
                                    <label class="block font-bold text-gray-800 mr-2">
                                        {{ $loop->iteration }}. {{ $item['id'] }}
                                        @if(auth()->check() && auth()->user()->isAdmin())
                                            <div class="inline-flex gap-2 ml-2 text-xs font-normal">
                                                <button type="button" @click="editMode = true; editSection = 'sentences'; editId = {{ $item['original_id'] ?? 0 }}; editQ = '{{ addslashes($item['id']) }}'; editA = '{{ addslashes($item['en']) }}'; editTense = '{{ $item['tense'] }}'; editStructure = '{{ $item['type'] }}'" class="text-blue-600 hover:text-blue-800 underline">Edit</button>
                                                <form action="{{ parse_url(route('admin.grammar.question.destroy', $item['original_id'] ?? 0), PHP_URL_PATH) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 underline">Delete</button>
                                                </form>
                                            </div>
                                        @endif
                                    </label>
                                    <div class="flex flex-col gap-1">
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
                                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                                <strong class="block mb-1 text-yellow-300">Contoh ({{ $item['tense'] }} - {{ ucfirst($item['type']) }}):</strong>
                                                {{ $tenseExamples[$item['tense']][$item['type']]['id'] }}<br>
                                                <em class="text-gray-300">{{ $tenseExamples[$item['tense']][$item['type']]['en'] }}</em>
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                            </div>
                                        </div>

                                        <!-- Vocabulary Helper -->
                                        @php
                                            $sentenceVocab = !empty($item['vocab']) ? $item['vocab'] : ($vocabularies[$item['tense']][$item['type']] ?? null);
                                        @endphp
                                        @if(!empty($sentenceVocab))
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
                                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                <ul class="space-y-1">
                                                    @foreach($sentenceVocab as $en => $vocabData)
                                                        <li class="flex justify-between">
                                                            <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ is_array($vocabData) ? ($vocabData['pos'] ?? '') : '' }}</span></span>
                                                            <span>{{ is_array($vocabData) ? ($vocabData['id'] ?? '') : $vocabData }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <input type="text"
                                       name="trans_sent[{{ $idx }}]"
                                       value="{{ old('trans_sent.'.$idx, $transResults['sentences'][$idx]['user_answer'] ?? ($draftAnswers['trans_sent'][$idx] ?? '')) }}"
                                       class="w-full p-2 border border-gray-300 rounded focus:border-blue-400 focus:ring-1 focus:ring-blue-400 {{ $stage === 3 ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $stage === 3 ? 'readonly' : '' }}
                                       autocomplete="off">

                                @if($stage === 3 && isset($transResults['sentences'][$idx]))
                                    @php
                                        $res = $transResults['sentences'][$idx];
                                    @endphp
                                    @if($res['is_correct'])
                                        <div class="mt-2 text-sm font-bold text-green-600">✓ Benar</div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Salah.</strong><br>
                                            Jawaban: {{ $res['correct_answer'] }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if(auth()->check() && auth()->user()->isAdmin())
                        <!-- ADD QUESTION FORM (SENTENCES) -->
                        <div class="bg-blue-50 p-6 rounded-xl mb-8 border-l-4 border-blue-500 shadow-sm">
                            <h3 class="text-lg font-bold text-blue-700 mb-4">Admin: Tambah Soal Baru (Kalimat)</h3>
                            <form action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" method="POST">
                                @csrf
                                <input type="hidden" name="meeting_number" value="4">
                                <input type="hidden" name="section" value="sentences">
                                <input type="hidden" name="question_number" value="{{ count($translationSentences) + 1 }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Soal (Ind)</label>
                                        <input type="text" name="question_text" class="w-full p-2 border rounded" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Jawaban (Eng)</label>
                                        <input type="text" name="correct_answer" class="w-full p-2 border rounded" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Tenses</label>
                                        <input type="text" name="tense" class="w-full p-2 border rounded" placeholder="e.g. Simple Present" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Structure (Type)</label>
                                        <select name="structure" class="w-full p-2 border rounded" required>
                                            <option value="verbal">Verbal</option>
                                            <option value="nominal">Nominal</option>
                                            <option value="passive">Passive</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Soal</button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Tab 2: Tenses x Structure Matrix -->
                <div x-show="tab === 'matrix'" x-transition>
                    <div class="mb-6 text-center">
                        <div class="inline-block p-4 border border-gray-200 rounded-lg bg-gray-50 max-w-2xl">
                            <p class="text-gray-600 text-sm">Translate setiap kalimat pada tabel di bawah ke dalam bentuk negatif sesuai tenses dan strukturnya (Verbal/Nominal/Passive).</p>
                        </div>
                    </div>

                    <!-- Matrix Intro Sentences -->
                    <div class="space-y-6 mb-8">
                        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-xl">
                            <p class="text-sm text-blue-700 font-medium">Translate setiap kalimat berdasarkan tensesnya!</p>
                        </div>
                        @php $lastIntroTense = null; @endphp
                        @foreach($matrixIntroSentences as $idx => $item)
                            @if($item['tense'] !== $lastIntroTense)
                                <h4 class="font-bold text-gray-700">{{ $item['tense'] }}</h4>
                                @php $lastIntroTense = $item['tense']; @endphp
                            @endif
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-center mb-1">
                                    <label class="block font-bold text-gray-800 mr-2">
                                        {{ $idx }}. {{ $item['id'] }}
                                        @if(auth()->check() && auth()->user()->isAdmin())
                                            <div class="inline-flex gap-2 ml-2 text-xs font-normal">
                                                <button type="button" @click="editMode = true; editSection = 'matrix_intro'; editId = {{ $item['original_id'] ?? 0 }}; editQ = '{{ addslashes($item['id']) }}'; editA = '{{ addslashes($item['en']) }}'; editTense = '{{ $item['tense'] }}'; editStructure = '{{ $item['type'] }}'" class="text-blue-600 hover:text-blue-800 underline">Edit</button>
                                                <form action="{{ parse_url(route('admin.grammar.question.destroy', $item['original_id'] ?? 0), PHP_URL_PATH) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 underline">Delete</button>
                                                </form>
                                            </div>
                                        @endif
                                    </label>
                                    <div class="flex flex-col gap-1">
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
                                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                                <strong class="block mb-1 text-yellow-300">Contoh ({{ $item['tense'] }} - {{ ucfirst($item['type']) }}):</strong>
                                                {{ $tenseExamples[$item['tense']][$item['type']]['id'] }}<br>
                                                <em class="text-gray-300">{{ $tenseExamples[$item['tense']][$item['type']]['en'] }}</em>
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                            </div>
                                        </div>

                                        <!-- Vocabulary Helper -->
                                        @php
                                            $introVocab = !empty($item['vocab']) ? $item['vocab'] : ($vocabularies[$item['tense']][$item['type']] ?? null);
                                        @endphp
                                        @if(!empty($introVocab))
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
                                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                <ul class="space-y-1">
                                                    @foreach($introVocab as $en => $vocabData)
                                                        <li class="flex justify-between">
                                                             <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ is_array($vocabData) ? ($vocabData['pos'] ?? '') : '' }}</span></span>
                                                             <span>{{ is_array($vocabData) ? ($vocabData['id'] ?? '') : $vocabData }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <input type="text"
                                       name="trans_matrix_intro[{{ $idx }}]"
                                       value="{{ old('trans_matrix_intro.'.$idx, $transResults['matrixIntro'][$idx]['user_answer'] ?? ($draftAnswers['trans_matrix_intro'][$idx] ?? '')) }}"
                                       class="w-full p-2 border border-gray-300 rounded focus:border-blue-400 focus:ring-1 focus:ring-blue-400 {{ $stage === 3 ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $stage === 3 ? 'readonly' : '' }}
                                       autocomplete="off">

                                @if($stage === 3 && isset($transResults['matrixIntro'][$idx]))
                                    @php
                                        $introRes = $transResults['matrixIntro'][$idx];
                                    @endphp
                                    @if($introRes['is_correct'])
                                        <div class="mt-2 text-sm font-bold text-green-600">✓ Benar</div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Salah.</strong><br>
                                            Jawaban: {{ $introRes['correct_answer'] }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto mb-8">
                        <table class="w-full border-collapse text-sm" style="min-width: 800px;">
                            <thead>
                                <tr class="bg-blue-500 text-white">
                                    <th class="p-5 border border-blue-600 text-left w-1/4">Tenses</th>
                                    <th class="p-5 border border-blue-600 text-left w-1/4">Verbal / Aktif</th>
                                    <th class="p-5 border border-blue-600 text-left w-1/4">Nominal</th>
                                    <th class="p-5 border border-blue-600 text-left w-1/4">Passive</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($translationMatrix as $tenseName => $items)
                                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                        <td class="p-5 border border-gray-200 font-bold text-gray-700">{{ $tenseName }}</td>
                                        @foreach(['verbal', 'nominal', 'passive'] as $type)
                                            <td class="p-5 border border-gray-200 align-top">
                                                @if(!isset($items[$type]))
                                                    <span class="text-gray-400">-</span>
                                                @else
                                                <div class="mb-1 text-sm font-medium text-gray-800 flex items-center gap-2">
                                                    {{ $items[$type]['id'] }}
                                                    @if(auth()->check() && auth()->user()->isAdmin())
                                                        <button type="button"
                                                            @click="editMode = true; editSection = 'matrix'; editId = {{ $items[$type]['original_id'] ?? 0 }}; editQ = '{{ addslashes($items[$type]['id']) }}'; editA = '{{ addslashes($items[$type]['en']) }}'; editTense = '{{ $tenseName }}'; editStructure = '{{ $type }}'"
                                                            class="text-blue-600 hover:text-blue-800 text-xs ml-2 cursor-pointer font-normal">
                                                            [Edit]
                                                        </button>
                                                    @endif
                                                    <div class="flex flex-col gap-1">
                                                        <div x-data="{ open: false }" class="relative inline-block">
                                                            <button type="button" @click="open = !open" @click.outside="open = false" class="text-yellow-600 hover:text-yellow-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-yellow-50 px-1.5 py-0.5 rounded border border-yellow-100 w-6 h-6 flex items-center justify-center">
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
                                                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed">
                                                                <strong class="block mb-1 text-yellow-300">Contoh ({{ $tenseName }} - {{ ucfirst($type) }}):</strong>
                                                                {{ $tenseExamples[$tenseName][$type]['id'] }}<br>
                                                                <em class="text-gray-300">{{ $tenseExamples[$tenseName][$type]['en'] }}</em>
                                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                            </div>
                                                        </div>

                                                        <!-- Vocabulary Helper -->
                                                        @php
                                                            $matrixVocab = !empty($items[$type]['vocab']) ? $items[$type]['vocab'] : ($vocabularies[$tenseName][$type] ?? null);
                                                        @endphp
                                                        @if(!empty($matrixVocab))
                                                        <div x-data="{ open: false }" class="relative inline-block">
                                                            <button type="button" @click="open = !open" @click.outside="open = false" class="text-green-600 hover:text-green-700 focus:outline-none transition-colors cursor-pointer text-xs font-bold bg-green-50 px-1.5 py-0.5 rounded border border-green-100 w-6 h-6 flex items-center justify-center">
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
                                                                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                                <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                                 <ul class="space-y-1">
                                                                    @foreach($matrixVocab as $en => $vocabData)
                                                                        <li class="flex justify-between">
                                                                            <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ is_array($vocabData) ? ($vocabData['pos'] ?? '') : '' }}</span></span>
                                                                            <span>{{ is_array($vocabData) ? ($vocabData['id'] ?? '') : $vocabData }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @php
                                                    $key = str_replace(' ', '_', strtolower($tenseName)) . '_' . $type;
                                                @endphp
                                                <input type="text"
                                                       name="trans_matrix[{{ $key }}]"
                                                       value="{{ old('trans_matrix.'.$key, $transResults['matrix'][$tenseName][$type]['user_answer'] ?? ($draftAnswers['trans_matrix'][$key] ?? '')) }}"
                                                       class="w-full p-2 border border-gray-300 rounded focus:border-blue-400 focus:ring-1 focus:ring-blue-400 text-sm {{ $stage === 3 ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                       placeholder="Translate..."
                                                       {{ $stage === 3 ? 'readonly' : '' }}
                                                       autocomplete="off">

                                                @if($stage === 3 && isset($transResults['matrix'][$tenseName][$type]))
                                                    @php
                                                        $res = $transResults['matrix'][$tenseName][$type];
                                                    @endphp
                                                    @if($res['is_correct'])
                                                        <div class="mt-1 text-xs font-bold text-green-600">✓ Benar</div>
                                                    @else
                                                        <div class="mt-1 text-xs text-red-600 bg-red-50 p-1 rounded border border-red-100">
                                                            <strong>Salah.</strong><br>
                                                            Jawaban: {{ $res['correct_answer'] }}
                                                        </div>
                                                    @endif
                                                @endif
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- End Tab Container -->

            @if($stage !== 3)
            <div class="mt-8">
                <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition-colors shadow-lg">
                    Cek Semua Jawaban
                </button>
            </div>
            @endif
        </form>

        @if($stage === 3)
            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.reset'), PHP_URL_PATH) }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Ulangi Latihan
                </button>
            </form>
        @endif

        <!-- EDIT QUESTION MODAL -->
        <div x-show="editMode"
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
             style="display: none;">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Edit Soal</h3>
                <form :action="'{{ route('admin.grammar.question.update', '0') }}'.slice(0, -1) + editId" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="meeting_number" value="4">
                    <input type="hidden" name="section" :value="editSection">

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Soal (Ind)</label>
                        <input type="text" name="question_text" x-model="editQ" class="w-full p-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Jawaban (Eng)</label>
                        <input type="text" name="correct_answer" x-model="editA" class="w-full p-2 border rounded">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                         <div>
                            <label class="block text-xs text-gray-500">Tense</label>
                            <input type="text" name="tense" x-model="editTense" class="w-full p-2 border rounded bg-gray-100 text-sm" readonly>
                         </div>
                         <div>
                            <label class="block text-xs text-gray-500">Structure</label>
                            <input type="text" name="structure" x-model="editStructure" class="w-full p-2 border rounded bg-gray-100 text-sm" readonly>
                         </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="editMode = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- INLINE AUTO-SAVE SCRIPT -->
    <script>
    const AutoSave = {
        debounceTimer: null,
        debounceDelay: 500,
        userId: null,
        draftSyncTimer: null,

        init(meetingNumber, userId = null) {
            this.meetingNumber = meetingNumber;
            this.userId = userId || window.userId || 'guest';
            this.storageKey = `grammar_writing_meeting${meetingNumber}_user_${this.userId}`;

            this.isSubmitted = this.checkIfSubmitted();

            if (this.isSubmitted) {
                this.clearSaved();
                return;
            }

            this.restoreAnswers();
            this.setupAutoSave();
        },

        checkIfSubmitted() {
            const isReadonly = document.querySelector('#meetingAnswerForm input[type="text"][readonly]');
            return !!isReadonly;
        },

        setupAutoSave() {
            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');

            inputs.forEach(input => {
                if (input.readOnly || input.disabled) {
                    return;
                }

                input.addEventListener('input', () => {
                    this.saveAnswers();
                });

                input.addEventListener('blur', () => {
                    this.saveAnswers();
                });

                input.addEventListener('keyup', () => {
                    this.saveAnswers();
                });
            });

            // Periodic heartbeat sync every 45 seconds
            setInterval(() => {
                this.saveAnswers();
            }, 45000);

            // Lifecycle listeners for mobile / tab switching / reconnecting / focus
            document.addEventListener('visibilitychange', () => {
                this.saveAnswers();
            });
            window.addEventListener('focus', () => {
                this.saveAnswers();
            });
            window.addEventListener('online', () => {
                this.saveAnswers();
            });
            window.addEventListener('pageshow', () => {
                this.restoreAnswers();
                this.saveAnswers();
            });
            window.addEventListener('beforeunload', () => {
                this.saveAnswers();
            });
        },

        saveAnswers() {
            if (this.isSubmitted) {
                return;
            }

            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};

            inputs.forEach(input => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });

            try {
                localStorage.setItem(this.storageKey, JSON.stringify(answers));
                this.showSaveIndicator();
                this.queueDraftSync(form);
            } catch (e) {
                console.error('Failed to save to localStorage:', e);
            }
        },

        queueDraftSync(form) {
            clearTimeout(this.draftSyncTimer);
            this.draftSyncTimer = setTimeout(() => {
                this.syncDraftToServer(form);
            }, this.debounceDelay);
        },

        async syncDraftToServer(form) {
            if (!form) {
                return false;
            }

            const action = form.getAttribute('action') || '';
            const match = action.match(/\/assignments\/grammar-writing\/fast-track\/meeting(\d+)/);
            if (!match) {
                return false;
            }

            const meetingNumber = match[1];
            const draftEndpoint = '/assignments/grammar-writing/fast-track/meeting' + meetingNumber + '/draft';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const payload = {};
            const assignNestedValue = (obj, key, value) => {
                const parts = String(key).replace(/\]/g, '').split('[');
                let ref = obj;

                for (let i = 0; i < parts.length; i++) {
                    const part = parts[i];
                    const isLast = i === parts.length - 1;

                    if (isLast) {
                        ref[part] = value;
                        return;
                    }

                    if (typeof ref[part] !== 'object' || ref[part] === null) {
                        ref[part] = {};
                    }

                    ref = ref[part];
                }
            };

            new FormData(form).forEach((value, key) => {
                if (key === '_token') {
                    return;
                }

                assignNestedValue(payload, key, value);
            });

            try {
                let response = await fetch(draftEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                    keepalive: true,
                });

                if (response.status === 419) {
                    const fresh = await fetch('/refresh-csrf').then(r => r.json()).catch(() => null);
                    if (fresh && fresh.token) {
                        response = await fetch(draftEndpoint, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': fresh.token,
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: JSON.stringify(payload),
                            keepalive: true,
                        });
                    }
                }

                return response.ok;
            } catch (e) {
                console.error('Failed to sync draft to server:', e);
                return false;
            }
        },

        restoreAnswers() {
            try {
                const savedData = localStorage.getItem(this.storageKey);

                if (!savedData) {
                    return;
                }

                const answers = JSON.parse(savedData);
                let restoredCount = 0;

                Object.keys(answers).forEach(name => {
                    const input = document.querySelector(`input[name="${name}"], textarea[name="${name}"]`);

                    if (input && !input.value && !input.readOnly) {
                        input.value = answers[name];
                        restoredCount++;
                    }
                });

                if (restoredCount > 0) {
                    this.showRestoreIndicator(restoredCount);
                }
            } catch (e) {
                console.error('Failed to restore from localStorage:', e);
            }
        },

        showRestoreIndicator(count) {
            const indicator = document.createElement('div');
            indicator.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
            indicator.innerHTML = `✓ ${count} jawaban dipulihkan`;
            document.body.appendChild(indicator);

            setTimeout(() => {
                indicator.style.opacity = '0';
                indicator.style.transition = 'opacity 0.3s';
                setTimeout(() => indicator.remove(), 300);
            }, 3000);
        },

        showSaveIndicator() {
            let indicator = document.getElementById('auto-save-indicator');

            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'auto-save-indicator';
                indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                indicator.style.transition = 'opacity 0.3s';
                indicator.innerHTML = '✓ Tersimpan otomatis';
                document.body.appendChild(indicator);
            }

            indicator.style.opacity = '1';
            indicator.style.backgroundColor = '#10b981';

            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            indicator.innerHTML = `✓ Tersimpan ${timeStr}`;

            clearTimeout(this.saveIndicatorTimeout);
            this.saveIndicatorTimeout = setTimeout(() => {
                indicator.style.opacity = '0.7';
            }, 3000);
        },

        clearSaved() {
            try {
                localStorage.removeItem(this.storageKey);
            } catch (e) {
                console.error('Failed to clear localStorage:', e);
            }
        }
    };

    window.AutoSave = AutoSave;
    AutoSave.showSaveErrorIndicator = function () {
        const indicator = document.createElement('div');
        indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
        indicator.style.transition = 'opacity 0.3s';
        indicator.innerHTML = '✗ Gagal menyimpan, coba lagi';
        document.body.appendChild(indicator);
        setTimeout(() => {
            indicator.style.opacity = '0';
            setTimeout(() => indicator.remove(), 300);
        }, 3000);
    };

    AutoSave.manualSave = async function () {
        const form = document.getElementById('meetingAnswerForm');
        if (!form) {
            return;
        }

        const btn = document.getElementById('manual-save-btn');
        if (btn) {
            btn.dataset.originalText = btn.dataset.originalText || btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';
        }

        try {
            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};
            inputs.forEach((input) => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });
            localStorage.setItem(this.storageKey, JSON.stringify(answers));
        } catch (e) {
            console.error('[ManualSave] Failed to update localStorage:', e);
        }

        const ok = await this.syncDraftToServer(form);

        if (btn) {
            btn.disabled = false;
            btn.innerHTML = btn.dataset.originalText;
        }

        if (ok) {
            this.showSaveIndicator();
        } else {
            this.showSaveErrorIndicator();
        }
    };


    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('4', userId);
        }
    });
    </script>

    <x-live-drawing />

    {{-- Consolidated Floating Helper Buttons (hidden during admin Live
         Preview - these are student-only interactive tools, not relevant
         to the admin's read-only observation view) --}}
    @if(!request()->filled('live_preview_for'))
    <div class="fixed bottom-4 right-8 z-50 flex flex-col gap-2 items-end">
        <x-dictionary-button />
        <x-conjunction-button />
        <x-preposition-button />
        <x-pronouns-button />
        <x-verb-patterns-button />
        <x-modal-button />
        <x-tenses-button />
        <x-irregular-verbs-button />
    </div>
    @endif

    @if($stage !== 3)
        <div class="fixed bottom-4 z-50" style="left: 50%; transform: translateX(-50%);">
            <button type="button" id="manual-save-btn" onclick="AutoSave.manualSave()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-sm font-semibold shadow-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3M8 7h8"></path></svg>
                Save
            </button>
        </div>
    @endif

    <!-- Repeat Confirmation Modal -->
    <div id="repeatConfirmModal" class="fixed inset-0 z-[100000] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 sm:p-7 text-center border border-gray-100 animate-in fade-in zoom-in-95">
            <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-amber-50 border-4 border-amber-100 mb-4 text-amber-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Ulangi Latihan Soal Ini?</h3>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                Jawaban pada halaman ini akan dikosongkan agar kamu bisa mengerjakan ulang <strong>soal yang sama</strong> dari lembar bersih.
            </p>
            <form id="repeatMeetingForm" method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting4.reset'), PHP_URL_PATH) }}">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" onclick="closeRepeatModal()" class="w-full sm:w-1/2 py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="btnExecuteRepeat" class="w-full sm:w-1/2 py-2.5 px-4 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm shadow-md transition">
                        Ya, Ulangi Soal Ini
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- AI Generating Modal -->
    <div id="aiLoadingModal" class="fixed inset-0 z-[100000] bg-black/70 backdrop-blur-md flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl border border-purple-100 animate-in fade-in zoom-in-95">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white flex items-center justify-center mx-auto mb-5 shadow-lg animate-bounce">
                <span class="text-2xl">✨</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Menyusun Soal Baru...</h3>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">AI sedang membuat variasi kalimat negatif dan kosakata baru dengan rumus tenses yang sama persis.</p>
            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-full rounded-full animate-pulse w-full"></div>
            </div>
        </div>
    </div>
    <!-- Admin Mock Toast -->
    <div id="adminMockToast" class="fixed top-5 right-5 z-[100000] bg-slate-900/95 backdrop-blur-md text-white px-5 py-3 rounded-2xl shadow-2xl border border-slate-700 flex items-center gap-3 transition-all duration-300 transform translate-y-[-100px] opacity-0 pointer-events-none">
        <span class="text-xl">ℹ️</span>
        <div>
            <p class="text-xs font-bold text-indigo-300">Mode Admin (Tampilan Sahaja)</p>
            <p class="text-xs text-gray-300" id="adminMockToastText">Tombol ini hanya aktif untuk akun student saat mengerjakan latihan.</p>
        </div>
    </div>

    <script>
    function showAdminMockToast(name) {
        const toast = document.getElementById('adminMockToast');
        const text = document.getElementById('adminMockToastText');
        if (toast && text) {
            text.innerText = `Tombol "${name}" hanya aktif untuk akun student saat mengerjakan latihan.`;
            toast.classList.remove('translate-y-[-100px]', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-[-100px]', 'opacity-0', 'pointer-events-none');
            }, 3000);
        }
    }

    function showAiLoadingModal() {
        const modal = document.getElementById('aiLoadingModal');
        if (modal) modal.style.display = 'flex';
    }

    function confirmRepeatMeeting() {
        const modal = document.getElementById('repeatConfirmModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeRepeatModal() {
        const modal = document.getElementById('repeatConfirmModal');
        if (modal) modal.style.display = 'none';
    }

    document.getElementById('repeatMeetingForm')?.addEventListener('submit', function() {
        if (window.AutoSave && typeof window.AutoSave.clearSaved === 'function') {
            try { window.AutoSave.clearSaved(); } catch(e) {}
        }
        const btn = document.getElementById('btnExecuteRepeat');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = 'Mereset...';
        }
    });
    </script>

</body>
</html>
