<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting {{ $displayMeetingNumber ?? 17 }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-4 sm:p-6 lg:p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar', ['programSidebarAlwaysVisible' => true])
    <div class="w-full max-w-[1920px] mx-auto flex flex-col min-h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-sm font-semibold text-purple-600 tracking-wider uppercase">{{ ($displayMeetingNumber ?? 17) == 10 ? 'Fast-track Grammar for Writing' : 'Grammar for Writing' }}</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ ($displayMeetingNumber ?? 17) == 10 ? 'Noun Clause & Prepositional Phrase (Pertemuan 10)' : 'Noun Clause (Pertemuan 17)' }}</h1>
            </div>
            <div class="flex items-center gap-2">
                @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
                    <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting10.reset'), PHP_URL_PATH) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-bold flex items-center gap-2 shadow-sm" onclick="return confirm('Reset semua progress (Session only)?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset (Admin)
                        </button>
                    </form>
                @endif
                <x-grammar-meeting-actions :meetingNumber="($displayMeetingNumber ?? 17)" track="fast-track" />
            </div>
        </div>

        @if($submitted)
            <div class="bg-purple-600 text-white p-6 rounded-xl text-center mb-6 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-purple-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting10.submit'), PHP_URL_PATH) }}" id="meetingAnswerForm" x-data="{ mobileTab: 'soal' }">
            @csrf

            <!-- Mobile View Switcher (< lg) -->
            <div class="flex lg:hidden mb-4 p-1.5 bg-white rounded-2xl border border-purple-200 shadow-sm sticky top-3 z-30">
                <button type="button" @click="mobileTab = 'soal'"
                        :class="mobileTab === 'soal' ? 'bg-purple-600 text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="flex-1 py-2.5 px-3 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Soal Latihan ({{ count($questions) }})</span>
                </button>
                <button type="button" @click="mobileTab = 'materi'"
                        :class="mobileTab === 'materi' ? 'bg-purple-600 text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="flex-1 py-2.5 px-3 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Materi &amp; Rumus</span>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-8">
                <!-- Left Column: Tips & Cheat Sheet (Sticky on Desktop, Tab on Mobile) -->
                <div id="materi-sticky-panel"
                     class="lg:col-span-5 lg:sticky lg:top-6 lg:self-start lg:max-h-[calc(100vh-2rem)] lg:overflow-y-auto pr-0 lg:pr-2"
                     :class="mobileTab === 'materi' ? 'block' : 'hidden lg:block'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 space-y-6">
                        <!-- 1. Noun Clause -->
                        <div>
                            <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <span class="bg-purple-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">1</span>
                                Pola Noun Clause (Klausa Kata Benda)
                            </h5>
                            <p class="text-xs sm:text-sm text-gray-600 mb-3">Noun Clause adalah anak kalimat (klausa) yang berfungsi sebagai kata benda (Subjek, Objek, atau Pelengkap) dalam kalimat utama.</p>

                            <div class="bg-purple-50 border border-purple-200 rounded-xl p-3.5 mb-4 shadow-xs">
                                <h6 class="text-xs uppercase tracking-wider font-bold text-purple-900 mb-2">Formula / Pola Dasar Noun Clause:</h6>
                                <div class="space-y-2 text-xs font-mono">
                                    <div class="bg-white p-2.5 rounded-lg border border-purple-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-purple-800 font-sans block mb-1">1. Pola Noun Clause (Standar):</span>
                                        <span class="px-2 py-0.5 bg-purple-100 rounded text-purple-900 font-bold">Conjunction + Subject + Verb</span>
                                        <span class="block text-[11px] font-sans text-gray-500 mt-1 italic">(Contoh: that / whether / why + S + V)</span>
                                    </div>
                                    <div class="bg-white p-2.5 rounded-lg border border-purple-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-purple-800 font-sans block mb-1">2. Pola Noun Clause (Sebagai Subjek):</span>
                                        <span class="px-2 py-0.5 bg-purple-100 rounded text-purple-900 font-bold">Conjunction + Verb</span>
                                        <span class="block text-[11px] font-sans text-gray-500 mt-1 italic">(Contoh: what happened / who came)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Variasi Posisi Noun Clause -->
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-3.5 mb-4 shadow-xs">
                                <h6 class="text-xs uppercase tracking-wider font-bold text-purple-900 mb-2 flex items-center gap-1.5">
                                    <span>📍</span> Variasi Posisi Noun Clause dalam Kalimat Utama:
                                </h6>
                                <div class="space-y-2 text-xs">
                                    <div class="bg-white p-2.5 rounded-lg border border-purple-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-emerald-700 block mb-1">1. Sebagai Subjek Kalimat:</span>
                                        <div class="font-mono text-emerald-900 font-semibold text-[11px] bg-emerald-50 px-2 py-1 rounded">[That / Whether / Q-Word + S + V] + Verb + Objek</div>
                                        <span class="block text-[11px] text-gray-600 mt-1 italic"><u>That the climate is changing</u> is indisputable.</span>
                                    </div>
                                    <div class="bg-white p-2.5 rounded-lg border border-purple-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-purple-700 block mb-1">2. Sebagai Objek Kata Kerja (Object of Verb):</span>
                                        <div class="font-mono text-purple-900 font-semibold text-[11px] bg-purple-50 px-2 py-1 rounded">Subjek + Verb + [That / Whether / Q-Word + S + V]</div>
                                        <span class="block text-[11px] text-gray-600 mt-1 italic">Scientists proved <u>that the virus mutates</u>.</span>
                                    </div>
                                    <div class="bg-white p-2.5 rounded-lg border border-purple-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-indigo-700 block mb-1">3. Sebagai Objek dari Preposisi (Object of Preposition):</span>
                                        <div class="font-mono text-indigo-900 font-semibold text-[11px] bg-indigo-50 px-2 py-1 rounded">Subjek + Verb + Preposisi + [Q-Word + S + V]</div>
                                        <span class="block text-[11px] text-gray-600 mt-1 italic">They focused on <u>why the experiment failed</u>.</span>
                                    </div>
                                    <div class="bg-white p-2.5 rounded-lg border border-purple-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-amber-700 block mb-1">4. Sebagai Pelengkap Subjek (Subject Complement):</span>
                                        <div class="font-mono text-amber-900 font-semibold text-[11px] bg-amber-50 px-2 py-1 rounded">Subjek + Linking Verb + [That / Whether / Q-Word + S + V]</div>
                                        <span class="block text-[11px] text-gray-600 mt-1 italic">The main issue is <u>whether funds are adequate</u>.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Noun Clause -->
                        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse bg-white text-xs min-w-[520px]">
                                    <thead>
                                        <tr class="bg-gray-800 text-white text-[11px] uppercase tracking-wider">
                                            <th class="p-3 font-semibold border-b border-gray-700">Jenis Noun Clause</th>
                                            <th class="p-3 font-semibold border-b border-gray-700">Kata Hubung & Makna</th>
                                            <th class="p-3 font-semibold border-b border-gray-700">Formula & Contoh</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 text-gray-700">
                                        <tr class="bg-white hover:bg-purple-50/40">
                                            <td class="p-3 font-bold text-gray-900">That-Clause<br><span class="text-[10px] text-gray-500 font-normal">(Pernyataan / Fakta)</span></td>
                                            <td class="p-3 text-gray-800"><strong class="text-purple-700 font-mono">that</strong> = <em>bahwa</em></td>
                                            <td class="p-3">
                                                <div class="font-mono text-purple-900 font-semibold text-[11px]">that + S + V</div>
                                                <div class="italic text-gray-600 text-[11px] mt-0.5">We know <u>that Earth orbits the Sun</u>.</div>
                                            </td>
                                        </tr>
                                        <tr class="bg-white hover:bg-purple-50/40">
                                            <td class="p-3 font-bold text-gray-900">If / Whether Clause<br><span class="text-[10px] text-gray-500 font-normal">(Pilihan / Keraguan)</span></td>
                                            <td class="p-3 text-gray-800"><strong class="text-purple-700 font-mono">whether / if</strong> = <em>apakah</em></td>
                                            <td class="p-3">
                                                <div class="font-mono text-purple-900 font-semibold text-[11px]">whether / if + S + V</div>
                                                <div class="italic text-gray-600 text-[11px] mt-0.5">They wonder <u>whether life exists on Mars</u>.</div>
                                            </td>
                                        </tr>
                                        <tr class="bg-white hover:bg-purple-50/40">
                                            <td class="p-3 font-bold text-gray-900">Question Word Clause<br><span class="text-[10px] text-gray-500 font-normal">(Informasi / WH-Words)</span></td>
                                            <td class="p-3 text-gray-800">
                                                <div class="space-y-0.5 text-[11px]">
                                                    <div>• <strong class="text-purple-700 font-mono">what</strong> = apa / apa yang</div>
                                                    <div>• <strong class="text-purple-700 font-mono">where</strong> = di mana / ke mana</div>
                                                    <div>• <strong class="text-purple-700 font-mono">when</strong> = kapan / waktu ketika</div>
                                                    <div>• <strong class="text-purple-700 font-mono">why</strong> = mengapa / kenapa</div>
                                                    <div>• <strong class="text-purple-700 font-mono">how</strong> = bagaimana / cara</div>
                                                </div>
                                            </td>
                                            <td class="p-3">
                                                <div class="font-mono text-purple-900 font-semibold text-[11px]">Q-Word + S + V</div>
                                                <div class="italic text-gray-600 text-[11px] mt-0.5">I know <u>how black holes absorb matter</u>.</div>
                                                <div class="italic text-gray-600 text-[11px] mt-0.5">We saw <u>what happened</u>.</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 2. Prepositional Phrase -->
                        <div>
                            <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <span class="bg-indigo-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">2</span>
                                Pola Prepositional Phrase (Frasa Preposisi)
                            </h5>
                            <p class="text-xs sm:text-sm text-gray-600 mb-3">
                                <strong>Prepositional Phrase</strong> adalah gabungan kata depan (Preposition) dengan Objek Preposisi (Noun / Pronoun / Noun Phrase / Gerund).
                            </p>

                            <!-- Table of Prepositional Phrase -->
                            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse bg-white text-xs min-w-[500px]">
                                        <thead>
                                            <tr class="bg-gray-800 text-white text-[11px] uppercase tracking-wider">
                                                <th class="p-3 font-semibold border-b border-gray-700">Fungsi Frasa</th>
                                                <th class="p-3 font-semibold border-b border-gray-700">Formula Gramatikal</th>
                                                <th class="p-3 font-semibold border-b border-gray-700">Penjelasan & Contoh</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700">
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-3 font-bold text-gray-900">Sebagai Adjective<br><span class="text-[10px] text-gray-500 font-normal">(Menerangkan Noun)</span></td>
                                                <td class="p-3 font-mono text-indigo-900 font-semibold text-[11px]">Noun + [Prep + Object]</td>
                                                <td class="p-3 text-[11px]">
                                                    Menjelaskan kata benda di depannya.<br>
                                                    <span class="italic text-gray-600">The report <u>on climate change</u> is very thorough.</span>
                                                </td>
                                            </tr>
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-3 font-bold text-gray-900">Sebagai Adverb<br><span class="text-[10px] text-gray-500 font-normal">(Menerangkan Verb/Klausa)</span></td>
                                                <td class="p-3 font-mono text-indigo-900 font-semibold text-[11px]">[Prep + Object], S + V<br>S + V + [Prep + Object]</td>
                                                <td class="p-3 text-[11px]">
                                                    Menjelaskan waktu, tempat, cara, atau tujuan.<br>
                                                    <span class="italic text-gray-600"><u>In the 19th century</u>, technology grew rapidly.</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="bg-indigo-50/80 p-3 rounded-xl border border-indigo-100 space-y-1.5 text-xs text-gray-800">
                                <strong class="text-indigo-900 font-bold block text-[11px]">📌 Daftar Preposisi Penting & Penggunaannya:</strong>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 font-mono text-[11px]">
                                    <div>• <strong>in, on, at</strong> (tempat / waktu)</div>
                                    <div>• <strong>during, throughout</strong> (selama)</div>
                                    <div>• <strong>under, behind, between</strong> (posisi)</div>
                                    <div>• <strong>according to</strong> (menurut)</div>
                                    <div>• <strong>despite, in spite of</strong> (meskipun)</div>
                                    <div>• <strong>due to, because of</strong> (karena)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Tips & Rules -->
                        <div class="bg-blue-50 border border-blue-200 text-blue-950 p-4 rounded-xl text-xs space-y-1.5">
                            <strong class="block text-xs font-bold text-blue-900 flex items-center gap-1.5 mb-1">
                                💡 Tips & Panduan Pemahaman:
                            </strong>
                            <p>• <strong>Noun Clause:</strong> Klausa utuh berpredikat (memiliki Subjek & Verb) yang menempati posisi kata benda: <em>I know <u>that she works hard</u></em>.</p>
                            <p>• <strong>Prepositional Phrase:</strong> Frasa tanpa predikat tenses yang diawali preposisi: <em>The book <u>on the desk</u></em> / <em><u>In modern society</u>, education is essential</em>.</p>
                            <p>• Jika terdapat kata <strong>"bahwa"</strong>, gunakan <strong class="font-mono text-blue-800">that</strong>.</p>
                            <p>• Jika terdapat kata <strong>"apakah"</strong> di tengah kalimat berita, gunakan <strong class="font-mono text-blue-800">whether / if</strong>.</p>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 text-amber-950 p-4 rounded-xl text-xs space-y-1.5">
                            <strong class="block text-xs font-bold text-amber-900 flex items-center gap-1.5 mb-1">
                                ⚠️ Aturan & Formula Penting:
                            </strong>
                            <p>1. <strong>Susunan Berita (S+V):</strong> Noun Clause <u>WAJIB</u> berbentuk kalimat berita (Subject + Verb), bukan susunan kalimat tanya!</p>
                            <p>2. <s>why did the system fail</s> → <strong>why the system failed</strong>.</p>
                            <p>3. <strong>Hukum Subjek:</strong> Objek Preposisi (Prepositional Phrase) <u>TIDAK BISA</u> menjadi Subjek kalimat!</p>
                            <p>4. <s>In the Amazon rainforest produces oxygen</s> → <strong>The Amazon rainforest produces oxygen</strong>.</p>
                            <em class="block text-[11px] text-amber-800 pt-1 border-t border-amber-200/60">Catatan Kunci: [Prep + Noun] hanya berperan sebagai modifier / keterangan, bukan subject utama.</em>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Exercise (Always on Desktop, Tab on Mobile) -->
                <div class="lg:col-span-7" :class="mobileTab === 'soal' ? 'block' : 'hidden lg:block'">
                    <!-- Section A: Noun Clause -->
                    <div class="bg-white rounded-3xl shadow-sm border border-purple-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-purple-50 via-violet-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-purple-100">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">A. Noun Clause (Klausa Kata Benda) — Soal 1–15</h3>
                                    <p class="text-xs text-gray-500 mt-1">Variasi Posisi: Subjek, Objek Kata Kerja, Objek Preposisi, &amp; Pelengkap</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center rounded-full bg-purple-600 text-white text-xs font-bold px-3 py-1.5 w-fit shadow-xs">
                                        15 Soal Noun Clause
                                    </span>
                                    @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
                                        <button type="button" @click="$dispatch('open-add-modal')" class="text-xs text-purple-700 hover:text-purple-900 underline font-semibold ml-2">+ Tambah Soal</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($questions as $idx => $data)
                                    @if($idx <= 15)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-purple-200 space-y-3 overflow-visible" x-data="{ open: false }">
                                        <div class="flex items-start gap-3 sm:gap-4">
                                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                {{ $idx }}
                                            </div>
                                            <div class="pt-0.5 flex-1">
                                                <div class="mb-2 flex flex-wrap items-center gap-1.5">
                                                    @if($idx <= 4)
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #059669;"></span> 📌 Posisi: Sebagai Subjek
                                                        </span>
                                                    @elseif($idx <= 8)
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #9333ea;"></span> 🎯 Posisi: Sebagai Objek Kata Kerja
                                                        </span>
                                                    @elseif($idx <= 12)
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #4f46e5;"></span> ⚓ Posisi: Objek dari Preposisi
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #d97706;"></span> ✨ Posisi: Pelengkap Subjek (Complement)
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-gray-800 font-medium text-sm sm:text-base leading-relaxed">{{ $data['id'] }}</p>
                                            </div>
                                            <div class="flex flex-row items-center gap-1 ml-2">
                                                @if(isset($data['example']))
                                                    <div x-data="{ openExample: false }" class="relative inline-block flex-shrink-0">
                                                        <button type="button" @click="openExample = !openExample" @click.outside="openExample = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                            ?
                                                        </button>
                                                        <div x-show="openExample" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                            {{ $data['example']['id'] }}<br>
                                                            <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(isset($data['vocab']) && count($data['vocab']) > 0)
                                                    <div class="relative inline-block flex-shrink-0">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                                            v
                                                        </button>
                                                        <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                            <ul class="space-y-1">
                                                                @foreach($data['vocab'] as $en => $vocabItem)
                                                                    <li class="flex justify-between gap-3">
                                                                        <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ $vocabItem['pos'] }}</span></span>
                                                                        <span>{{ $vocabItem['id'] }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
                                                    <button type="button" @click="openEditModal($el)"
                                                        data-payload="{{ json_encode(array_merge($data, ['question_number' => $idx])) }}"
                                                        class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm"
                                                        title="Edit Soal">
                                                        e
                                                    </button>
                                                    <button type="button" onclick="confirmDelete('{{ $data['db_id'] ?? '' }}', 'question')"
                                                        class="w-6 h-6 rounded-md bg-red-50 border border-red-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-red-100 transition-colors focus:outline-none shadow-sm"
                                                        title="Hapus Soal">
                                                        x
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-11 sm:ml-13">
                                            <textarea rows="1"
                                                   name="userAnswers[{{ $idx }}]"
                                                   style="field-sizing: content;"
                                                   class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   @if($submitted) readonly="readonly" @endif
                                                   autocomplete="off">{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}</textarea>

                                            @if($submitted)
                                                @if($results[$idx]['score'] == 10)
                                                    <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                                        ✓ Sempurna! (10/10)
                                                    </div>
                                                @else
                                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                                        <strong>Nilai: {{ $results[$idx]['score'] }}/10</strong><br>
                                                        Koreksi: {!! $results[$idx]['formatted_answer'] !!}<br>
                                                        <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Section B: Prepositional Phrase -->
                    <div class="bg-white rounded-3xl shadow-sm border border-indigo-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-indigo-50 via-blue-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-indigo-100">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">B. Prepositional Phrase (Frasa Preposisi) — Soal 16–30</h3>
                                    <p class="text-xs text-gray-500 mt-1">Variasi Fungsi: Menerangkan Noun (Adjective Phrase) &amp; Keterangan Klausa (Adverb Phrase)</p>
                                </div>
                                <span class="inline-flex items-center justify-center rounded-full bg-indigo-600 text-white text-xs font-bold px-3 py-1.5 w-fit shadow-xs">
                                    15 Soal Prepositional Phrase
                                </span>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($questions as $idx => $data)
                                    @if($idx > 15)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-indigo-200 space-y-3 overflow-visible" x-data="{ open: false }">
                                        <div class="flex items-start gap-3 sm:gap-4">
                                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                {{ $idx }}
                                            </div>
                                            <div class="pt-0.5 flex-1">
                                                <div class="mb-2 flex flex-wrap items-center gap-1.5">
                                                    @if($idx <= 22)
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #0284c7;"></span> 🏷️ Fungsi: Menerangkan Noun (Adjective Phrase)
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #ccfbf1; color: #115e59; border: 1px solid #99f6e4;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #0d9488;"></span> ⏱️ Fungsi: Keterangan Klausa (Adverb Phrase)
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-gray-800 font-medium text-sm sm:text-base leading-relaxed">{{ $data['id'] }}</p>
                                            </div>
                                            <div class="flex flex-row items-center gap-1 ml-2">
                                                @if(isset($data['example']))
                                                    <div x-data="{ openExample: false }" class="relative inline-block flex-shrink-0">
                                                        <button type="button" @click="openExample = !openExample" @click.outside="openExample = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                            ?
                                                        </button>
                                                        <div x-show="openExample" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                            {{ $data['example']['id'] }}<br>
                                                            <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(isset($data['vocab']) && count($data['vocab']) > 0)
                                                    <div class="relative inline-block flex-shrink-0">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                                            v
                                                        </button>
                                                        <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                            <ul class="space-y-1">
                                                                @foreach($data['vocab'] as $en => $vocabItem)
                                                                    <li class="flex justify-between gap-3">
                                                                        <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ $vocabItem['pos'] }}</span></span>
                                                                        <span>{{ $vocabItem['id'] }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
                                                    <button type="button" @click="openEditModal($el)"
                                                        data-payload="{{ json_encode(array_merge($data, ['question_number' => $idx])) }}"
                                                        class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm"
                                                        title="Edit Soal">
                                                        e
                                                    </button>
                                                    <button type="button" onclick="confirmDelete('{{ $data['db_id'] ?? '' }}', 'question')"
                                                        class="w-6 h-6 rounded-md bg-red-50 border border-red-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-red-100 transition-colors focus:outline-none shadow-sm"
                                                        title="Hapus Soal">
                                                        x
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-11 sm:ml-13">
                                            <textarea rows="1"
                                                   name="userAnswers[{{ $idx }}]"
                                                   style="field-sizing: content;"
                                                   class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   @if($submitted) readonly="readonly" @endif
                                                   autocomplete="off">{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}</textarea>

                                            @if($submitted)
                                                @if($results[$idx]['score'] == 10)
                                                    <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                                        ✓ Sempurna! (10/10)
                                                    </div>
                                                @else
                                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                                        <strong>Nilai: {{ $results[$idx]['score'] }}/10</strong><br>
                                                        Koreksi: {!! $results[$idx]['formatted_answer'] !!}<br>
                                                        <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Section C: Paragraph -->
                    <div class="bg-white rounded-3xl shadow-sm border border-purple-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-purple-50 via-violet-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-purple-100">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">C. Translate Paragraf</h3>
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <div class="flex gap-2 shrink-0">
                                        @if(empty($fullParagraphId))
                                            <button type="button" @click="$dispatch('open-add-paragraph-modal')" class="text-xs text-purple-700 hover:text-purple-900 underline font-semibold">+ Tambah Paragraf</button>
                                        @else
                                            <button type="button" @click="openParagraphEditModal('{{ $fullParagraphId }}', '{{ $fullParagraphEn }}', '{{ $paragraphDbId }}', {{ json_encode($paragraphVocab) }})"
                                                class="text-xs text-purple-700 hover:text-purple-900 underline font-semibold">Edit</button>
                                            <button type="button" onclick="confirmDelete('{{ $paragraphDbId }}', 'paragraph')"
                                                class="text-xs text-red-600 hover:text-red-800 underline font-semibold">Hapus</button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4">
                            <p class="text-gray-700 leading-relaxed">{{ $fullParagraphId }}</p>

                            <div x-data="{ showVocab: false }">
                                <button type="button" @click="showVocab = !showVocab" class="w-full px-4 py-3 bg-yellow-50 border border-yellow-200 hover:bg-yellow-100 text-yellow-800 font-bold rounded-lg transition-colors flex items-center justify-between text-sm">
                                    <span>📚 Vocabulary Bantuan</span>
                                    <svg :class="showVocab ? 'rotate-180' : ''" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="showVocab" x-transition style="display:none;" class="mt-3 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @foreach($paragraphVocab as $en => $vocabItem)
                                            <span class="bg-white px-3 py-1.5 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                                <strong class="text-purple-600">{{ $en }} <span class="text-gray-400 text-[10px]">{{ $vocabItem['pos'] }}</span></strong>: {{ $vocabItem['id'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                                <textarea
                                    name="userParagraphAnswer"
                                    rows="6"
                                    style="field-sizing: content;"
                                    class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    placeholder="Tulis terjemahan paragraf di sini..."
                                    @if($submitted) readonly="readonly" @endif>{{ old('userParagraphAnswer', $userParagraphAnswer) }}</textarea>
                            </div>

                            @if($submitted)
                                <div>
                                    @if($paragraphResult['score'] >= $paragraphResult['max_score'] * 0.8)
                                        <div class="text-sm font-bold text-green-600 bg-green-50 p-3 rounded border border-green-100 mb-2">
                                            ✓ Luar Biasa! Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}
                                        </div>
                                    @else
                                        <div class="text-sm font-bold text-red-600 bg-red-50 p-3 rounded border border-red-100 mb-2">
                                            Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}
                                        </div>
                                    @endif

                                    <div class="bg-gray-50 p-4 rounded border border-gray-200 text-sm leading-relaxed">
                                        <strong class="block mb-2 text-gray-700">Analisis Perbedaan:</strong>
                                        <div class="prose max-w-none">
                                            {!! $paragraphResult['formatted_answer'] !!}
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <strong class="block mb-1 text-gray-700">Jawaban Lengkap:</strong>
                                        <p class="text-gray-600 italic">{{ $fullParagraphEn }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        @if(!$submitted)
                            <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700 transition-colors shadow-md">
                                Cek Jawaban
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if($submitted)
            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting10.reset'), PHP_URL_PATH) }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gray-500 text-white rounded-xl font-bold hover:bg-gray-600 transition-colors shadow-md">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <style>
        .word-correct { color: #10b981; }
        .word-wrong { color: #ef4444; text-decoration: line-through; }
        .word-missing { color: #3b82f6; font-weight: bold; }
        .word-extra { color: #f59e0b; text-decoration: line-through; }

        /* lg:top-6, lg:max-h-[calc(100vh-2rem)] and lg:self-start aren't in the
           compiled Tailwind bundle on this deploy (the utility combo was never
           used elsewhere, so it was never generated) - lg:sticky and
           lg:overflow-y-auto DO exist and work, but without a top offset or a
           max-height, sticky has nothing to stick to and overflow-y has no
           constrained height to scroll within, so the left panel just grows to
           full content height instead of staying pinned with its own scrollbar.
           Plain CSS here matches Tailwind's own lg breakpoint (min-width: 1024px)
           exactly, so it stays in sync with the lg:sticky / lg:block toggling
           that already works. */
        @media (min-width: 1024px) {
            #materi-sticky-panel {
                top: 1.5rem;
                align-self: start;
                max-height: calc(100vh - 2rem);
            }
        }
    </style>

    <!-- Auto-Save Script -->

    <!-- INLINE AUTO-SAVE SCRIPT -->
    <script>
    /**
     * Auto-Save Module for Grammar Writing Assignments
     * Automatically saves student progress to localStorage
     * Supports multiple input naming patterns across different meetings
     */
    const AutoSave = {
        debounceTimer: null,
        debounceDelay: 500, // milliseconds
        userId: null,
        draftSyncTimer: null,

        /**
         * Initialize auto-save for a specific meeting
         * @param {string} meetingNumber - Meeting number (e.g., '1', '2', '10')
         * @param {number} userId - Current user ID
         */
        init(meetingNumber, userId = null) {
            console.log('=== AUTO-SAVE INITIALIZATION START ===');
            console.log('Meeting Number:', meetingNumber);
            console.log('User ID:', userId);
            
            this.meetingNumber = meetingNumber;
            this.userId = userId || window.userId || 'guest';
            this.storageKey = `grammar_writing_meeting${meetingNumber}_user_${this.userId}`;
            
            console.log('Storage Key:', this.storageKey);
            console.log('LocalStorage available:', typeof localStorage !== 'undefined');

            // Check if form was submitted
            this.isSubmitted = this.checkIfSubmitted();
            console.log('Form submitted:', this.isSubmitted);

            if (this.isSubmitted) {
                // Clear localStorage after submission
                this.clearSaved();
                console.log('LocalStorage cleared after submission');
                console.log('=== AUTO-SAVE INITIALIZATION END (SUBMITTED) ===');
                return;
            }

            // Restore saved data on page load
            console.log('Attempting to restore answers...');
            this.restoreAnswers();

            // Set up auto-save listeners
            console.log('Setting up auto-save listeners...');
            this.setupAutoSave();

            console.log(`✓ Auto-save initialized successfully for meeting ${meetingNumber}`);
            console.log('=== AUTO-SAVE INITIALIZATION END ===');
        },

        /**
         * Check if form has been submitted
         */
        checkIfSubmitted() {
            // Check if inputs are readonly (server renders them readonly when submitted)
            // We strictly check for readonly attribute on text inputs to avoid false positives
            const isReadonly = document.querySelector('#meetingAnswerForm input[type="text"][readonly], #meetingAnswerForm textarea[readonly]');
            
            return !!isReadonly;
        },

        /**
         * Set up auto-save listeners on all input fields
         */
        setupAutoSave() {
            // Find all input and textarea elements in the form
            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                console.log('No form found for auto-save');
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            console.log(`Found ${inputs.length} input fields`);

            inputs.forEach(input => {
                // Skip if readonly (already submitted)
                if (input.readOnly || input.disabled) {
                    return;
                }

                // Save immediately on every keystroke (input event)
                input.addEventListener('input', () => {
                    this.saveAnswers();
                });

                // Also save on blur (when moving to next field)
                input.addEventListener('blur', () => {
                    this.saveAnswers();
                });

                // Save on keyup as backup
                input.addEventListener('keyup', () => {
                    this.saveAnswers();
                });
            });

            console.log(`Auto-save listeners attached to ${inputs.length} fields`);
        },

        /**
         * Save all answers to localStorage
         */
        saveAnswers() {
            if (this.isSubmitted) {
                console.log('Skipping save - form already submitted');
                return;
            }

            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                console.log('No form found');
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
                await fetch(draftEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                    keepalive: true,
                });
                return true;
            } catch (e) {
                console.error('Failed to sync draft to server:', e);
                return false;
            }
        },

        /**
         * Restore saved answers from localStorage
         */
        restoreAnswers() {
            try {
                const savedData = localStorage.getItem(this.storageKey);
                
                if (!savedData) {
                    console.log('No saved data to restore');
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
                    console.log(`✓ Restored ${restoredCount} saved answers from localStorage`);
                    this.showRestoreIndicator(restoredCount);
                }
            } catch (e) {
                console.error('Failed to restore from localStorage:', e);
            }
        },

        /**
         * Show a brief restore indicator
         */
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

        /**
         * Show a brief save indicator
         */
        showSaveIndicator() {
            // Check if indicator already exists
            let indicator = document.getElementById('auto-save-indicator');

            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'auto-save-indicator';
                indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                indicator.style.transition = 'opacity 0.3s';
                indicator.innerHTML = '✓ Tersimpan otomatis';
                document.body.appendChild(indicator);
            }

            // Show indicator with animation
            indicator.style.opacity = '1';
            indicator.style.backgroundColor = '#10b981'; // green
            
            // Update text to show it's actively saving
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            indicator.innerHTML = `✓ Tersimpan ${timeStr}`;

            // Keep visible for 3 seconds
            clearTimeout(this.saveIndicatorTimeout);
            this.saveIndicatorTimeout = setTimeout(() => {
                indicator.style.opacity = '0.7'; // Semi-transparent when idle
            }, 3000);
        },

        /**
         * Clear saved data for this meeting
         */
        clearSaved() {
            try {
                localStorage.removeItem(this.storageKey);
                console.log('Cleared saved data');
            } catch (e) {
                console.error('Failed to clear localStorage:', e);
            }
        }
    };

    // Make AutoSave available globally
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


    // Initialize auto-save for meeting 17
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('17', userId);
        }
    });
    </script>

    <!-- Admin Modals -->
    @if(Auth::guard('web')->check() && Auth::guard('web')->user()->isAdmin())
    
    <!-- Add Question Modal -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-add-modal.window="open = true" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div @click.away="open = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" class="p-6">
                    @csrf
                    <input type="hidden" name="meeting_number" value="17">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Soal Baru</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Question (ID)</label>
                        <textarea name="question_text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Answer (EN)</label>
                        <textarea name="correct_answer" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>

                    <!-- Vocab Section -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Vocabulary (JSON Format)</label>
                        <textarea name="vocab" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder='{"Word": "Arti", "Another": "Lain"}'></textarea>
                        <p class="text-xs text-gray-500 mt-1">Format: {"English": "Indonesian"}</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="open = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Question Modal -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-edit-modal.window="open = true" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div @click.away="open = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="editQuestionForm" method="POST" action="#" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Soal</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Question (ID)</label>
                        <textarea name="question_text" id="edit_question_text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Answer (EN)</label>
                        <textarea name="correct_answer" id="edit_correct_answer" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Vocabulary (JSON)</label>
                        <textarea name="vocab" id="edit_vocab" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="open = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Paragraph Modal -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-add-paragraph-modal.window="open = true" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div @click.away="open = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" class="p-6">
                    @csrf
                    <input type="hidden" name="meeting_number" value="17">
                    <input type="hidden" name="section" value="paragraph">
                    <input type="hidden" name="question_number" value="100">
                    <input type="hidden" name="question_type" value="paragraph">

                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Paragraf</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Paragraph (ID)</label>
                        <textarea name="question_text" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Answer (EN)</label>
                        <textarea name="correct_answer" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Vocabulary (JSON)</label>
                        <textarea name="vocab" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="open = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Paragraph Modal -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-edit-paragraph-modal.window="open = true" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div @click.away="open = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="editParagraphForm" method="POST" action="#" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Paragraf</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Paragraph (ID)</label>
                        <textarea name="question_text" id="edit_paragraph_text" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Answer (EN)</label>
                        <textarea name="correct_answer" id="edit_paragraph_answer" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Vocabulary (JSON)</label>
                        <textarea name="vocab" id="edit_paragraph_vocab" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="open = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" method="POST" action="" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function openEditModal(button) {
            const payload = JSON.parse(button.dataset.payload);
            document.getElementById('edit_question_text').value = payload.id;
            document.getElementById('edit_correct_answer').value = payload.en;
            // Handle Vocab: If it's an object/array, stringify it
            let vocabStr = '';
            try {
                if (typeof payload.vocab === 'object') {
                    // Try to format it as formatted JSON for easier editing
                    // But since the original data structure might be complex (array of objects or key-value), 
                    // we need to be careful. The seeder uses key-value ['Word' => 'Arti'].
                    // But the View expects key-value. 
                    vocabStr = JSON.stringify(payload.vocab, null, 2);
                } else {
                    vocabStr = payload.vocab;
                }
            } catch(e) { vocabStr = ''; }
            
            document.getElementById('edit_vocab').value = vocabStr;
            
            // Set Action
            document.getElementById('editQuestionForm').action = '/admin/assignments/grammar-writing/questions/' + payload.db_id;
            
            window.dispatchEvent(new CustomEvent('open-edit-modal'));
        }

        function openParagraphEditModal(textId, textEn, dbId, vocab) {
            document.getElementById('edit_paragraph_text').value = textId;
            document.getElementById('edit_paragraph_answer').value = textEn;

            let vocabStr = '';
             try {
                if (typeof vocab === 'object') {
                    vocabStr = JSON.stringify(vocab, null, 2);
                } else {
                    vocabStr = vocab;
                }
            } catch(e) { vocabStr = ''; }

            document.getElementById('edit_paragraph_vocab').value = vocabStr;
            document.getElementById('editParagraphForm').action = '/admin/assignments/grammar-writing/questions/' + dbId;
            
            window.dispatchEvent(new CustomEvent('open-edit-paragraph-modal'));
        }

        function confirmDelete(id, type) {
            if (confirm('Apakah Anda yakin ingin menghapus ' + type + ' ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = '/admin/assignments/grammar-writing/questions/' + id;
                form.submit();
            }
        }
    </script>
    @endif



    <x-live-drawing />
    @include('components.student-broadcaster')

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

    @if(!$submitted)
        <div class="fixed bottom-4 z-50" style="left: 50%; transform: translateX(-50%);">
            <button type="button" id="manual-save-btn" onclick="AutoSave.manualSave()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-sm font-semibold shadow-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3M8 7h8"></path></svg>
                Save
            </button>
        </div>
    @endif

</body>
</html>