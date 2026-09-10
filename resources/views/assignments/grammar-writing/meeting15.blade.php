<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting {{ $displayMeetingNumber ?? 15 }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar', ['programSidebarAlwaysVisible' => true])
    <div class="w-full max-w-[1920px] mx-auto flex flex-col min-h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-sm font-semibold text-rose-600 tracking-wider uppercase">Fast-track Grammar for Writing</span>
                <h1 class="text-2xl font-bold text-gray-800">Adjective Clause RPP & Relative Adverb (Pertemuan 15)</h1>
            </div>
            <x-grammar-meeting-actions :meetingNumber="15" track="fast-track" />
        </div>

        @if($submitted)
            <div class="bg-rose-600 text-white p-6 rounded-xl text-center mb-6 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-rose-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting9.submit'), PHP_URL_PATH) }}" id="meetingAnswerForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-8">
                <!-- Left Column: Tips & Cheat Sheet (Sticky) -->
                <div class="lg:col-span-5 sticky top-6 self-start max-h-[calc(100vh-2rem)] overflow-y-auto pr-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 space-y-6">
                        <div>
                            <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <span class="bg-rose-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">📌</span>
                                Pola Adjective Clause - RPP, RA, & Reduced Clause
                            </h5>
                            <p class="text-xs sm:text-sm text-gray-600 mb-3">Tentukan dahulu <strong>Subject Main Clause</strong> dan <strong>Verb Main Clause</strong> sebelum menerjemahkan!</p>

                            <div class="bg-rose-50 border border-rose-200 rounded-xl p-3.5 mb-4 shadow-xs">
                                <h6 class="text-xs uppercase tracking-wider font-bold text-rose-900 mb-2">Formula Dasar Adjective Clause:</h6>
                                <div class="space-y-2 text-xs font-mono">
                                    <div class="bg-white p-2.5 rounded-lg border border-rose-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-rose-800 font-sans block mb-1">1. Pola RPP (Relative Pronoun Possessive):</span>
                                        <span class="px-2 py-0.5 bg-rose-100 rounded text-rose-900 font-bold">RPP = whose + Noun</span>
                                        <span class="block text-[11px] font-sans text-gray-500 mt-1 italic">Contoh: The author <u>whose book was popular</u>.</span>
                                    </div>
                                    <div class="bg-white p-2.5 rounded-lg border border-rose-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-rose-800 font-sans block mb-1">2. Pola RA (Relative Adverb):</span>
                                        <span class="px-2 py-0.5 bg-rose-100 rounded text-rose-900 font-bold">RA = where / when / why + S + V</span>
                                        <span class="block text-[11px] font-sans text-gray-500 mt-1 italic">Contoh: The lab <u>where experiments were conducted</u>.</span>
                                    </div>
                                    <div class="bg-white p-2.5 rounded-lg border border-rose-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-rose-800 font-sans block mb-1">3. Pola Reduced Clause (Participle):</span>
                                        <span class="px-2 py-0.5 bg-rose-100 rounded text-rose-900 font-bold">Aktif: V-ing | Pasif: V3</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-200 rounded-xl p-3.5 mb-4 shadow-xs">
                                <h6 class="text-xs uppercase tracking-wider font-bold text-rose-900 mb-2">📍 Variasi Posisi Noun yang Diterangkan:</h6>
                                <div class="space-y-2 text-xs">
                                    <div class="bg-white p-2.5 rounded-lg border border-rose-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-emerald-700 block mb-1">1. Menerangkan Subjek Main Clause:</span>
                                        <div class="font-mono text-emerald-900 font-semibold text-[11px] bg-emerald-50 px-2 py-1 rounded">[Subjek + Klausa] + Verb + Objek</div>
                                        <span class="block text-[11px] text-gray-600 mt-1 italic">The lab <u>where we work</u> is very modern.</span>
                                    </div>
                                    <div class="bg-white p-2.5 rounded-lg border border-rose-100 text-gray-900 shadow-xs">
                                        <span class="font-bold text-purple-700 block mb-1">2. Menerangkan Objek Main Clause:</span>
                                        <div class="font-mono text-purple-900 font-semibold text-[11px] bg-purple-50 px-2 py-1 rounded">Subjek + Verb + [Objek + Klausa]</div>
                                        <span class="block text-[11px] text-gray-600 mt-1 italic">We visited the lab <u>where they work</u>.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Preposition + which Equivalent Card -->
                            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-3.5 mb-4 shadow-xs">
                                <h6 class="text-xs uppercase tracking-wider font-bold text-indigo-900 mb-2 flex items-center gap-1.5">
                                    <span>🔄</span> Ekuivalensi: Relative Adverb = Preposition + which
                                </h6>
                                <p class="text-[11px] text-indigo-900 mb-2.5 leading-relaxed">
                                    Dalam academic &amp; formal writing, Relative Adverb dapat digantikan oleh kombinasi <strong>Preposition + which</strong>:
                                </p>
                                <div class="space-y-2 text-xs font-mono">
                                    <div class="bg-white p-2.5 rounded-lg border border-indigo-100 text-gray-900 shadow-xs">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-indigo-700 font-sans">1. where (Tempat)</span>
                                            <span class="px-2 py-0.5 bg-indigo-100 rounded text-indigo-900 font-bold text-[11px]">= in / at / on which</span>
                                        </div>
                                        <div class="text-[11px] font-sans text-gray-600 space-y-0.5">
                                            <div>• The lab <strong class="text-rose-600">where</strong> we conduct research...</div>
                                            <div>= The lab <strong class="text-indigo-600 font-semibold">in which</strong> we conduct research...</div>
                                        </div>
                                    </div>

                                    <div class="bg-white p-2.5 rounded-lg border border-indigo-100 text-gray-900 shadow-xs">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-indigo-700 font-sans">2. when (Waktu)</span>
                                            <span class="px-2 py-0.5 bg-indigo-100 rounded text-indigo-900 font-bold text-[11px]">= in / on / at / during which</span>
                                        </div>
                                        <div class="text-[11px] font-sans text-gray-600 space-y-0.5">
                                            <div>• The era <strong class="text-rose-600">when</strong> science flourished...</div>
                                            <div>= The era <strong class="text-indigo-600 font-semibold">in which / during which</strong> science flourished...</div>
                                        </div>
                                    </div>

                                    <div class="bg-white p-2.5 rounded-lg border border-indigo-100 text-gray-900 shadow-xs">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-indigo-700 font-sans">3. why (Alasan)</span>
                                            <span class="px-2 py-0.5 bg-indigo-100 rounded text-indigo-900 font-bold text-[11px]">= for which</span>
                                        </div>
                                        <div class="text-[11px] font-sans text-gray-600 space-y-0.5">
                                            <div>• The reason <strong class="text-rose-600">why</strong> the cell mutated...</div>
                                            <div>= The reason <strong class="text-indigo-600 font-semibold">for which</strong> the cell mutated...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse bg-white text-xs min-w-[520px]">
                                    <thead>
                                        <tr class="bg-gray-800 text-white text-[11px] uppercase tracking-wider">
                                            <th class="p-3 font-semibold border-b border-gray-700">Jenis Klausa</th>
                                            <th class="p-3 font-semibold border-b border-gray-700">Kata Hubung & Makna</th>
                                            <th class="p-3 font-semibold border-b border-gray-700">Formula & Contoh</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 text-gray-700">
                                        <tr class="bg-white hover:bg-rose-50/40">
                                            <td class="p-3 font-bold text-gray-900">RPP<br><span class="text-[10px] text-gray-500 font-normal">Kepemilikan</span></td>
                                            <td class="p-3 text-gray-800">
                                                <div>• <strong class="text-rose-700 font-mono">whose</strong> = yang ...-nya</div>
                                            </td>
                                            <td class="p-3">
                                                <div class="font-mono text-rose-900 font-semibold text-[11px]">whose + Noun + V/S+V</div>
                                                <div class="italic text-gray-600 text-[11px] mt-0.5">The author <u>whose book is famous</u>.</div>
                                            </td>
                                        </tr>
                                        <tr class="bg-white hover:bg-rose-50/40">
                                            <td class="p-3 font-bold text-gray-900">Relative Adverb<br><span class="text-[10px] text-gray-500 font-normal">Keterangan</span></td>
                                            <td class="p-3 text-gray-800">
                                                <div>• <strong class="text-rose-700 font-mono">where</strong> = in/at which (tempat)</div>
                                                <div>• <strong class="text-rose-700 font-mono">when</strong> = in/during which (waktu)</div>
                                                <div>• <strong class="text-rose-700 font-mono">why</strong> = for which (alasan)</div>
                                            </td>
                                            <td class="p-3">
                                                <div class="font-mono text-rose-900 font-semibold text-[11px]">where/in which + S + V</div>
                                                <div class="italic text-gray-600 text-[11px] mt-0.5">The lab <u>where (in which) experiments were done</u>.</div>
                                            </td>
                                        </tr>
                                        <tr class="bg-white hover:bg-rose-50/40">
                                            <td class="p-3 font-bold text-gray-900">Reduced Clause<br><span class="text-[10px] text-gray-500 font-normal">Penyederhanaan</span></td>
                                            <td class="p-3 text-gray-800">
                                                <div>• <strong>Aktif:</strong> V-ing</div>
                                                <div>• <strong>Pasif:</strong> V3</div>
                                            </td>
                                            <td class="p-3">
                                                <div class="italic text-gray-600 text-[11px]">Species <u>living in oceans</u>. (who live)</div>
                                                <div class="italic text-gray-600 text-[11px] mt-0.5">Data <u>collected from survey</u>. (which was collected)</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tips & Rules -->
                        <div class="bg-blue-50 border border-blue-200 text-blue-950 p-4 rounded-xl text-xs space-y-1.5">
                            <strong class="block text-xs font-bold text-blue-900 flex items-center gap-1.5 mb-1">
                                💡 Tips & Panduan Pemahaman:
                            </strong>
                            <p>• <strong>whose</strong> selalu langsung diikuti oleh kata benda yang dimilikinya tanpa article (<em>the/a/an</em>).</p>
                            <p>• <strong>where/when/why</strong> selalu diikuti oleh klausa lengkap ($S + V$) dan ekuivalen dengan <strong>Preposition + which</strong> (<em>in which / at which / during which / for which</em>).</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Exercise -->
                <div class="lg:col-span-7">
                    <!-- Section A -->
                    <div class="bg-white rounded-3xl shadow-sm border border-rose-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-rose-50 via-pink-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-rose-100">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">A. Adjective Clause RPP (whose) — Soal 1–15</h3>
                                    <p class="text-xs text-gray-500 mt-1">Pola Kepemilikan (whose + Noun) &bull; Variasi Menerangkan Subjek &amp; Objek</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center rounded-full bg-rose-600 text-white text-xs font-bold px-3 py-1.5 w-fit shadow-xs">
                                        15 Soal RPP
                                    </span>
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <button type="button" @click="$dispatch('open-add-modal')" class="text-xs text-rose-700 hover:text-rose-900 underline font-semibold ml-2">+ Add Question</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($questions as $idx => $data)
                                    @if($idx < 15)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-rose-200 space-y-3 overflow-visible">
                                        <div class="flex items-start gap-3 sm:gap-4">
                                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                {{ $idx + 1 }}
                                            </div>
                                            <div class="pt-0.5 flex-1">
                                                <div class="mb-2 flex flex-wrap items-center gap-1.5">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #ffe4e6; color: #be123c; border: 1px solid #fecdd3;">
                                                        <span class="w-2 h-2 rounded-full inline-block" style="background-color: #e11d48;"></span> RPP: whose + Noun
                                                    </span>

                                                    @if(in_array($idx, [0, 2, 4, 6, 8, 10, 12, 14]))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                            📌 Menerangkan Subjek
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                                            🎯 Menerangkan Objek
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-gray-900 font-medium text-sm sm:text-base leading-relaxed">{{ $data['id'] }}</p>
                                            </div>
                                            <div class="flex flex-row items-center gap-1 ml-2">
                                                @if(isset($data['example']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                            ?
                                                        </button>
                                                        <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                            {{ $data['example']['id'] }}<br>
                                                            <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(isset($data['vocab']) && count($data['vocab']) > 0)
                                                    <div x-data="{ open: false }" class="relative inline-block">
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

                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                    <button type="button"
                                                            data-payload="{{ json_encode([
                                                                'id' => $data['db_id'],
                                                                'question_text' => $data['id'],
                                                                'correct_answer' => $data['en'],
                                                                'example_id' => $data['example']['id'] ?? '',
                                                                'example_en' => $data['example']['en'] ?? '',
                                                                'vocab' => json_encode($data['vocab'] ?? [])
                                                            ]) }}"
                                                            onclick="openEditModal(this)"
                                                            class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm" title="Edit soal">
                                                        e
                                                    </button>
                                                    <button type="button"
                                                            onclick="confirmDelete('{{ $data['db_id'] }}')"
                                                            class="w-6 h-6 rounded-md bg-red-50 border border-red-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-red-100 transition-colors focus:outline-none shadow-sm" title="Hapus">
                                                        x
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-11 sm:ml-13">
                                            <input type="text"
                                                   name="userAnswers[{{ $idx }}]"
                                                   value="{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}"
                                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   {{ $submitted ? 'readonly' : '' }}
                                                   autocomplete="off">

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

                    <!-- Section B -->
                    <div class="bg-white rounded-3xl shadow-sm border border-blue-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-blue-50 via-sky-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-blue-100">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">B. Relative Adverb (where, when, why) — Soal 16–30</h3>
                                    <p class="text-xs text-gray-500 mt-1">where (Tempat), when (Waktu), why (Alasan) &bull; Variasi Menerangkan Subjek &amp; Objek</p>
                                </div>
                                <span class="inline-flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold px-3 py-1.5 w-fit shadow-xs">
                                    15 Soal Relative Adverb
                                </span>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($questions as $idx => $data)
                                    @if($idx >= 15)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-blue-200 space-y-3 overflow-visible">
                                        <div class="flex items-start gap-3 sm:gap-4">
                                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                {{ $idx + 1 }}
                                            </div>
                                            <div class="pt-0.5 flex-1">
                                                <div class="mb-2 flex flex-wrap items-center gap-1.5">
                                                    @if($idx < 20)
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #0284c7;"></span> RA (Tempat): where + S + V
                                                        </span>
                                                    @elseif($idx < 25)
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #4f46e5;"></span> RA (Waktu): when + S + V
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #d97706;"></span> RA (Alasan): why + S + V
                                                        </span>
                                                    @endif

                                                    @if(in_array($idx, [15, 17, 19, 20, 22, 24, 25, 27]))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                            📌 Menerangkan Subjek
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                                            🎯 Menerangkan Objek
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-gray-900 font-medium text-sm sm:text-base leading-relaxed">{{ $data['id'] }}</p>
                                            </div>
                                            <div class="flex flex-row items-center gap-1 ml-2">
                                                @if(isset($data['example']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                            ?
                                                        </button>
                                                        <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                            <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                            {{ $data['example']['id'] }}<br>
                                                            <em class="text-gray-300">{{ $data['example']['en'] }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(isset($data['vocab']) && count($data['vocab']) > 0)
                                                    <div x-data="{ open: false }" class="relative inline-block">
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

                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                    <button type="button"
                                                            data-payload="{{ json_encode([
                                                                'id' => $data['db_id'],
                                                                'question_text' => $data['id'],
                                                                'correct_answer' => $data['en'],
                                                                'example_id' => $data['example']['id'] ?? '',
                                                                'example_en' => $data['example']['en'] ?? '',
                                                                'vocab' => json_encode($data['vocab'] ?? [])
                                                            ]) }}"
                                                            onclick="openEditModal(this)"
                                                            class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm" title="Edit soal">
                                                        e
                                                    </button>
                                                    <button type="button"
                                                            onclick="confirmDelete('{{ $data['db_id'] }}')"
                                                            class="w-6 h-6 rounded-md bg-red-50 border border-red-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-red-100 transition-colors focus:outline-none shadow-sm" title="Hapus">
                                                        x
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-11 sm:ml-13">
                                            <input type="text"
                                                   name="userAnswers[{{ $idx }}]"
                                                   value="{{ old('userAnswers.'.$idx, $userAnswers[$idx] ?? '') }}"
                                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   {{ $submitted ? 'readonly' : '' }}
                                                   autocomplete="off">

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
                    <div class="bg-white rounded-3xl shadow-sm border border-rose-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-rose-50 via-pink-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-rose-100">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">C. Translate Paragraf</h3>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    @if(isset($paragraphDbId) && $paragraphDbId)
                                        <div class="flex gap-2 shrink-0">
                                            <button type="button"
                                                    data-payload="{{ json_encode([
                                                        'id' => $paragraphDbId,
                                                        'question_text' => $fullParagraphId,
                                                        'correct_answer' => $fullParagraphEn,
                                                        'vocab' => is_array($paragraphVocab) ? json_encode($paragraphVocab) : $paragraphVocab
                                                    ]) }}"
                                                    onclick="openParagraphEditModal(this)"
                                                    class="text-xs text-rose-700 hover:text-rose-900 underline font-semibold">Edit</button>
                                            <button type="button"
                                                    onclick="confirmDelete('{{ $paragraphDbId }}')"
                                                    class="text-xs text-red-600 hover:text-red-800 underline font-semibold">Hapus</button>
                                        </div>
                                    @else
                                        <button type="button" @click="$dispatch('open-add-paragraph-modal')" class="text-xs text-rose-700 hover:text-rose-900 underline font-semibold">+ Add Paragraph</button>
                                    @endif
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
                                        @foreach($paragraphVocab as $en => $id)
                                            <span class="bg-white px-3 py-1.5 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                                <strong class="text-rose-600">{{ $en }}</strong>: {{ $id }}
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
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    placeholder="Tulis terjemahan paragraf di sini..."
                                    {{ $submitted ? 'readonly' : '' }}>{{ old('userParagraphAnswer', $userParagraphAnswer) }}</textarea>
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
                            <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-rose-600 text-white rounded-xl font-bold hover:bg-rose-700 transition-colors shadow-md">
                                Cek Jawaban
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if($submitted)
            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting9.reset'), PHP_URL_PATH) }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gray-500 text-white rounded-xl font-bold hover:bg-gray-600 transition-colors shadow-md">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <!-- Admin Modals -->
    @if(auth()->check() && auth()->user()->isAdmin())
        <!-- Edit Question Modal -->
        <div x-data="{ open: false }"
             x-on:open-edit-modal.window="open = true"
             x-on:close-modal.window="open = false"
             x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="open" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <form id="editQuestionForm" method="POST" action="#" class="p-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_id">
                        <input type="hidden" name="meeting_number" value="15">
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Question</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Question (Indonesian)</label>
                                <textarea name="question_text" id="edit_question_text" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correct Answer (English)</label>
                                <textarea name="correct_answer" id="edit_correct_answer" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vocabulary (JSON: {"Word": "Meaning"})</label>
                                <textarea name="vocab" id="edit_vocab" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono"></textarea>
                                <p class="mt-1 text-xs text-gray-500">Format: {"Word": {"id": "Meaning", "pos": "(n)"}}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Example (Indo)</label>
                                    <input type="text" name="example_id" id="edit_example_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Example (Eng)</label>
                                    <input type="text" name="example_en" id="edit_example_en" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end gap-2">
                            <button type="button" @click="open = false" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:text-sm">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Question Modal -->
        <div x-data="{ open: false }"
             x-on:open-add-modal.window="open = true"
             x-on:close-modal.window="open = false"
             x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form method="POST" action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="15">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Question</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Question Number</label>
                                <input type="number" name="question_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Question (ID)</label>
                                <textarea name="question_text" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Answer (EN)</label>
                                <textarea name="correct_answer" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vocabulary (JSON)</label>
                                <textarea name="vocab" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder='{"Word": {"id": "Meaning", "pos": "(n)"}}'></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700">Ex (ID)</label><input type="text" name="example_id" class="mt-1 block w-full rounded-md border-gray-300"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Ex (EN)</label><input type="text" name="example_en" class="mt-1 block w-full rounded-md border-gray-300"></div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end gap-2">
                             <button type="button" @click="open = false" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm">Cancel</button>
                             <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-violet-600 text-base font-medium text-white hover:bg-violet-700 focus:outline-none sm:text-sm">Add Question</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Paragraph Modal -->
        <div x-data="{ open: false }"
             x-on:open-paragraph-edit-modal.window="open = true"
             x-on:close-modal.window="open = false"
             x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form id="editParagraphForm" method="POST" action="#" class="p-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_paragraph_db_id">
                        <input type="hidden" name="meeting_number" value="15">
                        <input type="hidden" name="section" value="paragraph">
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Paragraph</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Paragraph (Indonesian)</label>
                                <textarea name="question_text" id="edit_paragraph_id" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correct Answer (English)</label>
                                <textarea name="correct_answer" id="edit_paragraph_en" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vocabulary (JSON)</label>
                                <textarea name="vocab" id="edit_paragraph_vocab" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono"></textarea>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end gap-2">
                            <button type="button" @click="open = false" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:text-sm">Cancel</button>
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:text-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Paragraph Modal -->
        <div x-data="{ open: false }"
             x-on:open-add-paragraph-modal.window="open = true"
             x-on:close-modal.window="open = false"
             x-show="open"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form method="POST" action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="15">
                        <input type="hidden" name="section" value="paragraph">
                        <input type="hidden" name="question_number" value="100">
                        <input type="hidden" name="question_type" value="paragraph">
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Add Paragraph</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Paragraph (Indonesian)</label>
                                <textarea name="question_text" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Answer (English)</label>
                                <textarea name="correct_answer" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vocab (JSON)</label>
                                <textarea name="vocab" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end gap-2">
                             <button type="button" @click="open = false" class="btn-secondary">Cancel</button>
                             <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-violet-600 text-base font-medium text-white hover:bg-violet-700 focus:outline-none sm:text-sm">Add Paragraph</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openEditModal(button) {
                const payload = JSON.parse(button.dataset.payload);
                document.getElementById('edit_id').value = payload.id;
                document.getElementById('edit_question_text').value = payload.question_text;
                document.getElementById('edit_correct_answer').value = payload.correct_answer;
                document.getElementById('edit_example_id').value = payload.example_id;
                document.getElementById('edit_example_en').value = payload.example_en;
                document.getElementById('edit_vocab').value = payload.vocab;
                
                // Set Form Action Dynamically
                document.getElementById('editQuestionForm').action = '/admin/assignments/grammar-writing/questions/' + payload.id;
                
                window.dispatchEvent(new CustomEvent('open-edit-modal'));
            }

            function openParagraphEditModal(button) {
                const payload = JSON.parse(button.dataset.payload);
                document.getElementById('edit_paragraph_db_id').value = payload.id;
                document.getElementById('edit_paragraph_id').value = payload.question_text;
                document.getElementById('edit_paragraph_en').value = payload.correct_answer;
                document.getElementById('edit_paragraph_vocab').value = payload.vocab;
                
                // Set Form Action Dynamically
                document.getElementById('editParagraphForm').action = '/admin/assignments/grammar-writing/questions/' + payload.id;
                
                window.dispatchEvent(new CustomEvent('open-paragraph-edit-modal'));
            }

            function confirmDelete(id) {
                if(confirm('Are you sure you want to delete this item?')) {
                    // Create a hidden form and submit it
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/assignments/grammar-writing/questions/' + id;
                    
                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrf);
                    
                    let method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    @endif

    <style>
        .word-correct { color: #10b981; }
        .word-wrong { color: #ef4444; text-decoration: line-through; }
        .word-missing { color: #3b82f6; font-weight: bold; }
        .word-extra { color: #f59e0b; text-decoration: line-through; }
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
            const isReadonly = document.querySelector('#meetingAnswerForm input[type="text"][readonly]');
            
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


    // Initialize auto-save for meeting 15
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('15', userId);
        }
    });
    </script>



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