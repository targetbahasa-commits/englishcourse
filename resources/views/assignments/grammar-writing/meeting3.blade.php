<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 3</title>
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
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-4 sm:p-6 lg:p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar', ['programSidebarAlwaysVisible' => true])
    <div class="w-full max-w-[1920px] mx-auto flex flex-col min-h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-sm font-semibold text-indigo-600 tracking-wider uppercase">Fast-track Grammar for Writing</span>
                <h1 class="text-2xl font-bold text-gray-800">Modals &amp; Phrasal Modals (Pertemuan 3)</h1>
            </div>
            <x-grammar-meeting-actions :meetingNumber="3" track="fast-track" />
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        @if($submitted)
            <div class="bg-blue-600 text-white p-6 rounded-xl text-center mb-6 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-blue-100 mb-3">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
                <a href="{{ route('assignments.grammar-writing.meeting3.hasil-pdf') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-blue-700 rounded-lg text-xs sm:text-sm font-bold shadow-sm hover:bg-blue-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Download Hasil Penilaian (PDF)
                </a>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="meeting3-main-form" method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting3.submit'), PHP_URL_PATH) }}" x-data="{ mobileTab: 'soal' }">
            @csrf

            <!-- Mobile View Switcher (< lg) -->
            <div class="flex lg:hidden mb-4 p-1.5 bg-white rounded-2xl border border-indigo-200 shadow-sm sticky top-3 z-30">
                <button type="button" @click="mobileTab = 'soal'"
                        :class="mobileTab === 'soal' ? 'bg-indigo-600 text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="flex-1 py-2.5 px-3 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Soal Latihan ({{ count($questions) }})</span>
                </button>
                <button type="button" @click="mobileTab = 'materi'"
                        :class="mobileTab === 'materi' ? 'bg-indigo-600 text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="flex-1 py-2.5 px-3 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Materi &amp; Rumus</span>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-8">
                <!-- Left Column: Materi (Sticky on Desktop, Tab on Mobile) -->
                <div id="materi-sticky-panel"
                     class="lg:col-span-5 lg:sticky lg:top-6 lg:self-start lg:max-h-[calc(100vh-2rem)] lg:overflow-y-auto pr-0 lg:pr-2"
                     :class="mobileTab === 'materi' ? 'block' : 'hidden lg:block'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 space-y-6">
                        <div>
                            <!-- Header Title -->
                            <div class="flex items-start justify-between gap-3 mb-1">
                                <h5 class="text-base font-bold text-gray-800">Summary Chart of Modals & Phrasal Modals (SEOM)</h5>
                                <a href="{{ route('assignments.grammar-writing.meeting3.materi-pdf') }}"
                                   class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg text-[11px] font-semibold transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    PDF
                                </a>
                            </div>
                            <p class="text-xs text-gray-500 mb-4">Panduan pola rumus, fungsi, makna bahasa Indonesia, dan contoh kalimat.</p>

                            <!-- 3 Rumus Utama Modal Auxiliaries (Verbal, Nominal, Pasif) -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs mb-5">
                                <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100 shadow-2xs">
                                    <span class="font-bold text-indigo-900 block mb-1 text-[11px]">1. Verbal (Dasar)</span>
                                    <code class="text-indigo-700 font-bold font-mono text-[11px] block bg-white px-2 py-0.5 rounded border border-indigo-200 mb-1">S + Modal + V1</code>
                                    <p class="text-gray-600 text-[10.5px] leading-snug">Tanpa <em class="text-red-500 font-semibold">to/s/es/ing</em> setelah modal.</p>
                                </div>
                                <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100 shadow-2xs">
                                    <span class="font-bold text-indigo-900 block mb-1 text-[11px]">2. Nominal / Sifat</span>
                                    <code class="text-indigo-700 font-bold font-mono text-[11px] block bg-white px-2 py-0.5 rounded border border-indigo-200 mb-1">S + Modal + be + Adj/N</code>
                                    <p class="text-gray-600 text-[10.5px] leading-snug">Gunakan <strong>be</strong> sebelum kata sifat/benda.</p>
                                </div>
                                <div class="bg-indigo-50/70 p-3 rounded-xl border border-indigo-100 shadow-2xs">
                                    <span class="font-bold text-indigo-900 block mb-1 text-[11px]">3. Pasif (Passive)</span>
                                    <code class="text-indigo-700 font-bold font-mono text-[11px] block bg-white px-2 py-0.5 rounded border border-indigo-200 mb-1">S + Modal + be + V3</code>
                                    <p class="text-gray-600 text-[10.5px] leading-snug">Bermakna pasif ("di-" atau "ter-").</p>
                                </div>
                            </div>

                            <!-- Bagian 1: Pure Modals (Modal Dasar) -->
                            <h5 class="text-sm font-bold text-indigo-900 mb-2.5 flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="bg-indigo-100 text-indigo-700 w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold">1</span>
                                    Pure Modals (Modal Dasar)
                                </span>
                                <span class="text-[11px] text-gray-500 font-normal">Selalu + Bare V1</span>
                            </h5>
                            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-6">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse bg-white text-xs">
                                        <thead>
                                            <tr class="bg-slate-800 text-white text-xs uppercase tracking-wider">
                                                <th class="p-3 font-semibold border-b border-slate-700 whitespace-nowrap">Modal</th>
                                                <th class="p-3 font-semibold border-b border-slate-700">Fungsi (Kegunaan)</th>
                                                <th class="p-3 font-semibold border-b border-slate-700">Makna (Indonesia)</th>
                                                <th class="p-3 font-semibold border-b border-slate-700 min-w-[190px]">Contoh & Pola</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700">
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    can
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Present</span>
                                                </td>
                                                <td class="p-3 align-top">Kemampuan (Ability), Izin (Permission)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">bisa; dapat; mampu; boleh</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">S + can + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"She can speak three languages."</div>
                                                    <div class="text-[10.5px] text-gray-500">Dia bisa berbicara tiga bahasa.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    could
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Past / Polite</span>
                                                </td>
                                                <td class="p-3 align-top">Kemampuan lampau (Past Ability), Permintaan sopan (Polite Request)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">bisa (dulu); sudikah/bisakah; kemungkinan</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">Could + S + V1?</code>
                                                    <div class="text-[11px] italic text-gray-700">"Could you please help me?"</div>
                                                    <div class="text-[10.5px] text-gray-500">Bisakah Anda membantu saya?</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    may
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Present</span>
                                                </td>
                                                <td class="p-3 align-top">Izin resmi (Formal Permission), Kemungkinan (~50%)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">boleh; mungkin</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">May + S + V1?</code>
                                                    <div class="text-[11px] italic text-gray-700">"May I leave the room early?"</div>
                                                    <div class="text-[10.5px] text-gray-500">Bolehkah saya keluar lebih awal?</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    might
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Possibility</span>
                                                </td>
                                                <td class="p-3 align-top">Kemungkinan kecil (Weak Possibility ~30%)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">mungkin saja; barangkali</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">S + might + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"It might rain this afternoon."</div>
                                                    <div class="text-[10.5px] text-gray-500">Mungkin saja nanti sore hujan.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    must
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Obligation</span>
                                                </td>
                                                <td class="p-3 align-top">Keharusan mutlak (Strong Obligation), Kesimpulan pasti (95%)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">harus; wajib; pasti</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">S + must + V1 / be + Adj</code>
                                                    <div class="text-[11px] italic text-gray-700">"You must wear a helmet."</div>
                                                    <div class="text-[10.5px] text-gray-500">Kamu wajib memakai helm.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    must not
                                                    <span class="block text-[10px] text-red-600 font-normal">Prohibition</span>
                                                </td>
                                                <td class="p-3 align-top">Larangan keras (Prohibition)</td>
                                                <td class="p-3 align-top font-medium text-red-700">dilarang; tidak boleh sama sekali</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-red-700 font-mono font-semibold bg-red-50 px-1.5 py-0.5 rounded">S + must not + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"You must not smoke here."</div>
                                                    <div class="text-[10.5px] text-gray-500">Dilarang merokok di sini.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    should
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Advice</span>
                                                </td>
                                                <td class="p-3 align-top">Saran / Anjuran (Advice & Recommendation)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">seharusnya; sebaiknya; saran</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">S + should + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"You should rest more."</div>
                                                    <div class="text-[10.5px] text-gray-500">Kamu sebaiknya lebih banyak istirahat.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    ought to
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Moral Advice</span>
                                                </td>
                                                <td class="p-3 align-top">Kewajiban moral / Saran yang patut dilakukan</td>
                                                <td class="p-3 align-top font-medium text-gray-900">seharusnya; patutnya</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">S + ought to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"We ought to respect teachers."</div>
                                                    <div class="text-[10.5px] text-gray-500">Kita seharusnya menghormati guru.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    had better
                                                    <span class="block text-[10px] text-amber-600 font-normal">Urgent Advice</span>
                                                </td>
                                                <td class="p-3 align-top">Saran mendesak dengan konsekuensi negatif</td>
                                                <td class="p-3 align-top font-medium text-gray-900">lebih baik (ada resiko jika tidak)</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-amber-800 font-mono font-semibold bg-amber-50 px-1.5 py-0.5 rounded">S + had better + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"You had better hurry."</div>
                                                    <div class="text-[10.5px] text-gray-500">Kamu lebih baik bergegas.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    will
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Future</span>
                                                </td>
                                                <td class="p-3 align-top">Masa depan (Future), Kesediaan/Janji (Willingness)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">akan; kesediaan; mau</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">S + will + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"I will support you."</div>
                                                    <div class="text-[10.5px] text-gray-500">Saya akan mendukungmu.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    would
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Past Future</span>
                                                </td>
                                                <td class="p-3 align-top">Permintaan sangat sopan, Pengandaian, Kebiasaan lampau</td>
                                                <td class="p-3 align-top font-medium text-gray-900">sudikah/maukah; akan (lampau)</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">Would you like...?</code>
                                                    <div class="text-[11px] italic text-gray-700">"Would you mind helping me?"</div>
                                                    <div class="text-[10.5px] text-gray-500">Sudikah Anda membantu saya?</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-indigo-900 whitespace-nowrap align-top">
                                                    shall
                                                    <span class="block text-[10px] text-indigo-600 font-normal">Formal / Offer</span>
                                                </td>
                                                <td class="p-3 align-top">Tawaran bantuan / Usulan bersama (I & We), Masa depan resmi</td>
                                                <td class="p-3 align-top font-medium text-gray-900">haruskah kita; mari; akan</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-indigo-700 font-mono font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">Shall + I/We + V1?</code>
                                                    <div class="text-[11px] italic text-gray-700">"Shall we start the meeting?"</div>
                                                    <div class="text-[10.5px] text-gray-500">Haruskah kita memulai rapat?</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Bagian 2: Phrasal Modals / SEOM (Similar Expressions of Modals) -->
                            <h5 class="text-sm font-bold text-blue-900 mb-2.5 flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold">2</span>
                                    Phrasal Modals / SEOM (Similar Expressions of Modals)
                                </span>
                                <span class="text-[11px] text-blue-600 font-medium">Bisa Dikonjugasi & Double Modal</span>
                            </h5>
                            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-5">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse bg-white text-xs">
                                        <thead>
                                            <tr class="bg-slate-800 text-white text-xs uppercase tracking-wider">
                                                <th class="p-3 font-semibold border-b border-slate-700 whitespace-nowrap">Phrasal Modal (SEOM)</th>
                                                <th class="p-3 font-semibold border-b border-slate-700">Padanan Modal</th>
                                                <th class="p-3 font-semibold border-b border-slate-700">Makna (Indonesia)</th>
                                                <th class="p-3 font-semibold border-b border-slate-700 min-w-[190px]">Contoh & Pola</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700">
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">be able to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= can / could</td>
                                                <td class="p-3 align-top font-medium text-gray-900">dapat; mampu (di semua tenses)</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">will be able to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"I will be able to finish it."</div>
                                                    <div class="text-[10.5px] text-gray-500">Saya akan mampu menyelesaikannya.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">have to / has to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= must</td>
                                                <td class="p-3 align-top font-medium text-gray-900">harus; terpaksa (aturan dari luar)</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">S + have/has to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"I have to work tomorrow."</div>
                                                    <div class="text-[10.5px] text-gray-500">Saya harus bekerja besok.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">don't / doesn't have to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= no obligation</td>
                                                <td class="p-3 align-top font-medium text-gray-900">tidak harus; tidak perlu</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">don't/doesn't have to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"You don't have to wake up early."</div>
                                                    <div class="text-[10.5px] text-gray-500">Kamu tidak harus bangun pagi.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">have got to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= must (informal)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">harus banget; terpaksa</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">S + have/has got to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"I've got to go now."</div>
                                                    <div class="text-[10.5px] text-gray-500">Saya harus pergi sekarang.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">be supposed to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= should / rule</td>
                                                <td class="p-3 align-top font-medium text-gray-900">seharusnya; semestinya (sesuai aturan/jadwal)</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">is/are supposed to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"Students are supposed to attend."</div>
                                                    <div class="text-[10.5px] text-gray-500">Siswa seharusnya hadir.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">be allowed to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= may / permitted</td>
                                                <td class="p-3 align-top font-medium text-gray-900">diizinkan; diperbolehkan</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">is/are allowed to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"They are allowed to enter."</div>
                                                    <div class="text-[10.5px] text-gray-500">Mereka diizinkan masuk.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">be required to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= must / mandatory</td>
                                                <td class="p-3 align-top font-medium text-gray-900">diwajibkan; disyaratkan resmi</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">is/are required to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"Staff are required to sign in."</div>
                                                    <div class="text-[10.5px] text-gray-500">Staf diwajibkan absen masuk.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">be going to have to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= will have to</td>
                                                <td class="p-3 align-top font-medium text-gray-900">akan harus; bakal terpaksa</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">is/are going to have to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"You're going to have to study."</div>
                                                    <div class="text-[10.5px] text-gray-500">Kamu akan harus belajar lebih giat.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">used to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= past state/habit</td>
                                                <td class="p-3 align-top font-medium text-gray-900">dulu biasa; dulu sering (kini tidak)</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">S + used to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"I used to live in London."</div>
                                                    <div class="text-[10.5px] text-gray-500">Dulu saya biasa tinggal di London.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">be going to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= will (planned)</td>
                                                <td class="p-3 align-top font-medium text-gray-900">akan (rencana/kepastian)</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">is/are going to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"She is going to travel tomorrow."</div>
                                                    <div class="text-[10.5px] text-gray-500">Dia akan bepergian besok.</div>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="p-3 font-bold text-blue-950 whitespace-nowrap align-top">need to</td>
                                                <td class="p-3 align-top font-mono text-blue-700 text-[11px]">= necessity</td>
                                                <td class="p-3 align-top font-medium text-gray-900">perlu untuk; butuh</td>
                                                <td class="p-3 align-top space-y-1">
                                                    <code class="text-[11px] text-blue-700 font-mono font-semibold bg-blue-50 px-1.5 py-0.5 rounded">S + need(s) to + V1</code>
                                                    <div class="text-[11px] italic text-gray-700">"You need to practice more."</div>
                                                    <div class="text-[10.5px] text-gray-500">Kamu perlu berlatih lebih banyak.</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Bagian 3: Aturan Modal & SEOM (Similar Expressions of Modals) -->
                            <div class="bg-blue-50 border border-blue-200 text-blue-950 p-4 sm:p-5 rounded-xl shadow-xs space-y-2">
                                <strong class="block text-sm font-bold text-blue-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Aturan Penting Modal & SEOM (Similar Expressions of Modals):
                                </strong>
                                <ol class="list-decimal list-inside space-y-2 ml-1 text-xs text-blue-900 leading-relaxed">
                                    <li><strong>Modal Murni Selalu Diikuti Bare Infinitive (V1) atau be:</strong> Tidak boleh ditambahkan akhiran <em>-s, -es, -ed, -ing</em> atau kata <em>to</em> (contoh: <em>She can speak</em> ✅, bukan <em>She can speaks / to speak</em> ❌).</li>
                                    <li><strong>Larangan Double Modal:</strong> Dua modal murni tidak boleh berurutan (contoh: <em>will can</em> ❌, <em>must can</em> ❌). Gunakan <strong>SEOM / Phrasal Modal</strong> untuk modal kedua:
                                        <ul class="list-disc list-inside ml-4 mt-1 text-[11px] text-blue-800 space-y-0.5">
                                            <li><em>I will <strong>be able to</strong> attend tomorrow.</em> ✅</li>
                                            <li><em>They might <strong>have to</strong> reschedule.</em> ✅</li>
                                            <li><em>Students should <strong>be allowed to</strong> ask questions.</em> ✅</li>
                                        </ul>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Exercise (Always on Desktop, Tab on Mobile) -->
                <div class="lg:col-span-7 space-y-6" :class="mobileTab === 'soal' ? 'block' : 'hidden lg:block'">
                    <div class="bg-white rounded-3xl shadow-sm border border-blue-100 overflow-visible">
                        <div class="bg-gradient-to-r from-blue-50 via-sky-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-blue-100">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">A. Translate Kalimat</h3>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <button type="button" @click="showAddQuestion = !showAddQuestion" class="text-xs text-blue-700 hover:text-blue-900 underline font-semibold">
                                        <span x-text="showAddQuestion ? 'Close Add Question' : '+ Add Question'"></span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <div x-show="showAddQuestion" style="display: none;" class="rounded-2xl border border-blue-200 bg-blue-50/60 p-4 sm:p-5">
                                    <h4 class="text-sm font-bold text-gray-800 mb-4">Admin: Add New Question</h4>
                                    <form action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="meeting_number" value="3">
                                        <input type="hidden" name="section" value="sentences">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Question Text (ID)</label>
                                                <input type="text" name="question_text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Correct Answer (EN)</label>
                                                <input type="text" name="correct_answer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Question Number</label>
                                                <input type="number" name="question_number" value="{{ count($questions) + 1 }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Add Question</button>
                                    </form>
                                </div>
                            @endif

                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($questions as $data)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-blue-200 space-y-3">
                                        <div class="flex items-start justify-between gap-3 sm:gap-4">
                                            <div class="flex items-start gap-3 sm:gap-4 flex-1">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                    {{ $loop->iteration }}
                                                </div>
                                                <div class="pt-1 flex-1">
                                                    <p class="text-gray-800 leading-relaxed">{{ $data['id'] }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-1.5 shrink-0 pt-0.5">
                                                @if(!empty($data['example']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-xs font-bold hover:bg-amber-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Contoh Serupa">
                                                            ?
                                                        </button>
                                                        <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                            <strong class="block mb-1 text-amber-300 border-b border-gray-600 pb-1">Contoh Serupa:</strong>
                                                            {{ is_array($data['example']) ? ($data['example']['id'] ?? '') : $data['example'] }}<br>
                                                            <em class="text-gray-300">{{ is_array($data['example']) ? ($data['example']['en'] ?? '') : '' }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(!empty($data['vocab']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Vocabulary Helper">
                                                            v
                                                        </button>
                                                        <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                            <ul class="space-y-1">
                                                                @foreach($data['vocab'] as $word => $info)
                                                                    <li class="flex justify-between gap-3">
                                                                        <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ is_array($info) ? ($info['pos'] ?? '') : '' }}</span></span>
                                                                        <span>{{ is_array($info) ? ($info['id'] ?? '') : $info }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                    <button type="button"
                                                            onclick="openMeeting3EditModal(
                                                                '{{ $data['original_id'] }}',
                                                                {{ \Illuminate\Support\Js::from($data['id'] ?? '') }},
                                                                {{ \Illuminate\Support\Js::from($data['en'] ?? '') }},
                                                                {{ \Illuminate\Support\Js::from($data['tense'] ?? '') }},
                                                                {{ \Illuminate\Support\Js::from($data['vocab'] ?? []) }}
                                                            )"
                                                            class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm" title="Edit soal">
                                                        e
                                                    </button>
                                                    <form action="{{ parse_url(route('admin.grammar.question.destroy', $data['original_id']), PHP_URL_PATH) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-6 h-6 rounded-md bg-red-50 border border-red-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-red-100 transition-colors focus:outline-none shadow-sm" title="Hapus">
                                                            x
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ml-11 sm:ml-13 space-y-3">
                                            <div>
                                                <textarea name="userAnswers[{{ $data['q_num'] }}][trans]"
                                                          rows="1"
                                                          style="field-sizing: content;"
                                                          class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                          placeholder="Translate to English..."
                                                          {{ $submitted ? 'readonly' : '' }}
                                                          autocomplete="off">{{ old('userAnswers.'.$data['q_num'].'.trans', $userAnswers[$data['q_num']]['trans'] ?? '') }}</textarea>

                                                @if($submitted)
                                                    @if(($results[$data['q_num']]['answered'] ?? true) === false)
                                                        <div class="mt-2 text-sm font-medium text-gray-500 bg-gray-50 p-2 rounded border border-gray-200">
                                                            Belum dikerjakan - tidak dinilai.
                                                        </div>
                                                    @elseif(($results[$data['q_num']]['trans_score'] ?? 0) == 10)
                                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                                            ✓ Terjemahan Sempurna! (10/10)
                                                        </div>
                                                    @else
                                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                                            <strong>Nilai Terjemahan: {{ $results[$data['q_num']]['trans_score'] ?? 0 }}/10</strong><br>
                                                            Koreksi: {!! $results[$data['q_num']]['formatted_answer'] ?? '' !!}<br>
                                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Section B: Paragraph -->
                    <div class="bg-white rounded-3xl shadow-sm border border-green-100 overflow-visible">
                        <div class="bg-gradient-to-r from-green-50 via-emerald-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-green-100 flex items-center justify-between">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">B. Latihan Paragraf</h3>
                                <p class="text-sm text-gray-600 mt-1">Translate paragraf berikut ke dalam bahasa Inggris.</p>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <button type="button"
                                            onclick="openMeeting3EditModal(
                                                '{{ $paragraphId }}',
                                                {{ \Illuminate\Support\Js::from($fullParagraphId) }},
                                                {{ \Illuminate\Support\Js::from($fullParagraphEn) }},
                                                '',
                                                {{ \Illuminate\Support\Js::from($paragraphVocab ?? []) }}
                                            )"
                                            class="text-xs text-green-700 hover:text-green-900 underline font-semibold shrink-0">Edit Paragraph</button>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4">
                            <p class="text-gray-700 leading-relaxed">{{ $fullParagraphId }}</p>

                            @if(!empty($paragraphVocab))
                                <div x-data="{ showVocab: false }">
                                    <button type="button" @click="showVocab = !showVocab" class="w-full px-4 py-3 bg-yellow-50 border border-yellow-200 hover:bg-yellow-100 text-yellow-900 font-bold rounded-xl transition-colors flex items-center justify-between text-sm shadow-2xs">
                                        <span class="flex items-center gap-2"><span>📚</span> Vocabulary Bantuan</span>
                                        <svg :class="showVocab ? 'rotate-180' : ''" class="w-5 h-5 transition-transform text-yellow-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="showVocab" x-transition style="display:none;" class="mt-3 bg-yellow-50 border border-yellow-200 p-4 rounded-xl">
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                            @foreach($paragraphVocab as $en => $data)
                                                <span class="bg-white px-3 py-1.5 rounded-lg border border-yellow-200 text-xs text-gray-700 shadow-xs">
                                                    <strong class="text-indigo-600">{{ $en }}</strong>:
                                                    @if(is_array($data))
                                                        {{ $data['id'] }} <span class="text-gray-400 text-[10px]">{{ $data['pos'] ?? '' }}</span>
                                                    @else
                                                        {{ $data }}
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                                <textarea
                                    name="userParagraphAnswer"
                                    rows="6"
                                    style="field-sizing: content;"
                                    class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    placeholder="Tulis terjemahan paragraf di sini..."
                                    {{ $submitted ? 'readonly' : '' }}>{{ old('userParagraphAnswer', $userParagraphAnswer) }}</textarea>
                            </div>

                            @if($submitted)
                                <div>
                                    @if(($paragraphResult['answered'] ?? true) === false)
                                        <div class="text-sm font-medium text-gray-500 bg-gray-50 p-3 rounded border border-gray-200 mb-2">
                                            Belum dikerjakan - tidak dinilai.
                                        </div>
                                    @else
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
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        @if(!$submitted)
                            <p id="translate-progress-text" class="text-sm font-medium text-gray-600">Progress Translate: 0/20</p>
                            <button id="meeting3-submit-button" type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors shadow-md disabled:opacity-60 disabled:cursor-not-allowed">
                                Cek Jawaban
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if($submitted)
            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting3.reset'), PHP_URL_PATH) }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gray-500 text-white rounded-xl font-bold hover:bg-gray-600 transition-colors shadow-md">
                    Coba Lagi
                </button>
            </form>
        @endif

        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->role === 'teacher'))
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-600 mb-3 font-medium">🔐 Admin/Teacher Area:</p>
                <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting3.admin-reset'), PHP_URL_PATH) }}" class="inline-block">
                    @csrf
                    <button type="submit" onclick="return confirm('Hapus semua grading dan catatan Anda? Jawaban student tetap tersimpan.')" class="px-6 py-3 bg-orange-600 text-white rounded-xl font-bold hover:bg-orange-700 transition-colors shadow-lg text-sm">
                        🔄 Reset Grading Saya
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-2 italic">Tombol ini hanya menghapus grading dan catatan Anda, jawaban student tidak terpengaruh.</p>
            </div>
        @endif
    </div>
    
    <!-- Auto-Save Script -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mainForm = document.getElementById('meeting3-main-form');
            const submitButton = document.getElementById('meeting3-submit-button');
            const progressText = document.getElementById('translate-progress-text');
            const totalQuestions = 20;

            if (!mainForm || !submitButton || !progressText) {
                return;
            }

            const translationInputs = Array.from(mainForm.querySelectorAll('input[name^="userAnswers"][name$="[trans]"], textarea[name^="userAnswers"][name$="[trans]"]'));
            const paragraphInput = mainForm.querySelector('textarea[name="userParagraphAnswer"]');

            // Progress display is still out of the full 20 (+ paragraph) so
            // students can see how much is left, but "Cek Jawaban" no
            // longer requires finishing everything first - checking
            // whatever's filled in is the whole point of this button.
            // Unanswered questions are simply excluded from scoring
            // server-side, not marked wrong.
            const updateProgress = () => {
                const filled = translationInputs.reduce((total, input) => {
                    return total + (input.value.trim() !== '' ? 1 : 0);
                }, 0);
                const paragraphFilled = paragraphInput ? paragraphInput.value.trim() !== '' : false;

                progressText.textContent = `Progress Translate: ${filled}/${totalQuestions}`;
                submitButton.disabled = filled === 0 && !paragraphFilled;
            };

            translationInputs.forEach((input) => {
                input.addEventListener('input', updateProgress);
                input.addEventListener('blur', updateProgress);
            });
            if (paragraphInput) {
                paragraphInput.addEventListener('input', updateProgress);
                paragraphInput.addEventListener('blur', updateProgress);
            }

            updateProgress();
        });
    </script>

    <script>
        window.openMeeting3EditModal = function(id, question, answer, tense, vocab) {
            window.dispatchEvent(new CustomEvent('open-edit-modal', { 
                detail: { 
                    id: id, 
                    question: question, 
                    answer: answer, 
                    tense: tense,
                    vocab: vocab
                } 
            }));
        };
    </script>

    <!-- Edit Question Modal -->
    <div x-data="{ open: false, id: '', question: '', answer: '', tense: '', vocab: '' }"
         @open-edit-modal.window="open = true; id = $event.detail.id; question = $event.detail.question; answer = $event.detail.answer; tense = $event.detail.tense; vocab = JSON.stringify($event.detail.vocab, null, 2)"
         x-show="open"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form :action="`{{ route('admin.grammar.question.update', '0') }}`.slice(0, -1) + id" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit Item</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Question / Text (ID)</label>
                                <textarea name="question_text" x-model="question" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Answer / Translation (EN) <br><small class="text-gray-500 font-normal">Use <b>|</b> to separate multiple correct answers (e.g. I am|I'm)</small></label>
                                <textarea name="correct_answer" x-model="answer" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div x-show="tense">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tense (Optional for Paragraph)</label>
                                <input type="text" name="tense" x-model="tense" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Vocabulary (JSON Format)</label>
                                <textarea name="vocab" x-model="vocab" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 font-mono text-sm leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                <p class="text-xs text-gray-500 mt-1">Format: {"English": {"pos": "n/v/adj", "id": "Indonesian"}}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save Changes
                        </button>
                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
        draftEndpoint: '{{ parse_url(route('assignments.grammar-writing.meeting.draft', ['meeting' => 3]), PHP_URL_PATH) }}',

        /**
         * Initialize auto-save for a specific meeting
         * @param {string} meetingNumber - Meeting number (e.g., '1', '2', '10')
         * @param {number} userId - Current user ID
         */
        async init(meetingNumber, userId = null) {
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

            // Restore saved data on page load. Awaited so the eager sync
            // below never fires with only-partially-restored form state
            // (which would overwrite the server's fuller draft with less).
            console.log('Attempting to restore answers...');
            await this.restoreAnswers();

            // ── Sync to server immediately on page load ──────────────────
            // This ensures the admin live preview shows answers even if the
            // student hasn't typed anything new since their last session.
            const form = document.getElementById('meeting3-main-form');
            setTimeout(() => {
                console.log('[AutoSave] Initial server sync on page load...');
                this.syncDraftToServer(form);
            }, 600);

            // ── Periodic sync every 15 s ─────────────────────────────────
            // Keeps admin live preview up-to-date even without keystrokes.
            this.periodicSyncTimer = setInterval(() => {
                const f = document.getElementById('meeting3-main-form');
                if (f && !this.isSubmitted) {
                    console.log('[AutoSave] Periodic 15s server sync...');
                    this.syncDraftToServer(f);
                }
            }, 15000);

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
            const form = document.getElementById('meeting3-main-form');
            if (!form) {
                return false;
            }

            // Scope readonly check to the main meeting form only.
            const isReadonly = form.querySelector('input[type="text"][readonly], textarea[readonly]');
            
            return !!isReadonly;
        },

        /**
         * Set up auto-save listeners on all input fields
         */
        setupAutoSave() {
            // Find all input and textarea elements in the form
            const form = document.getElementById('meeting3-main-form');
            if (!form) {
                console.log('[AutoSave] No form found for auto-save');
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            console.log(`[AutoSave] Found ${inputs.length} input fields to monitor`);

            inputs.forEach((input, index) => {
                // Skip if readonly (already submitted)
                if (input.readOnly || input.disabled) {
                    return;
                }

                const inputName = input.name || `input-${index}`;

                // Save immediately on every keystroke (input event)
                input.addEventListener('input', () => {
                    console.log(`[AutoSave] Input changed: ${inputName}`);
                    this.saveAnswers();
                });

                // Also save on blur (when moving to next field)
                input.addEventListener('blur', () => {
                    console.log(`[AutoSave] Input blurred: ${inputName}`);
                    this.saveAnswers();
                });

                // Save on keyup as backup
                input.addEventListener('keyup', () => {
                    this.saveAnswers();
                });
            });

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

            console.log(`[AutoSave] Auto-save listeners attached to ${inputs.length} fields`);
        },

        /**
         * Save all answers to localStorage
         */
        saveAnswers() {
            if (this.isSubmitted) {
                console.log('[AutoSave] Skipping save - form already submitted');
                return;
            }

            const form = document.getElementById('meeting3-main-form');
            if (!form) {
                console.error('[AutoSave] ERROR: No form found! Looking for #meeting3-main-form');
                const allForms = document.querySelectorAll('form');
                console.log('[AutoSave] Total forms on page:', allForms.length);
                allForms.forEach((f, i) => {
                    console.log(`  Form ${i}:`, { method: f.method, id: f.id, action: f.action });
                });
                return;
            }

            console.log('[AutoSave] Form found:', { formId: form.id, formMethod: form.method });

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};

            inputs.forEach(input => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });

            try {
                localStorage.setItem(this.storageKey, JSON.stringify({ answers, savedAt: Date.now() }));
                this.showSaveIndicator();

                console.log('[AutoSave] Queueing draft sync...');
                this.queueDraftSync(form);
            } catch (e) {
                console.error('[AutoSave] Failed to save to localStorage:', e);
            }
        },

        queueDraftSync(form) {
            console.log('[AutoSave] Queue drift sync with 500ms delay');
            clearTimeout(this.draftSyncTimer);
            this.draftSyncTimer = setTimeout(() => {
                console.log('[AutoSave] Executing deferred sync...');
                this.syncDraftToServer(form);
            }, this.debounceDelay);
        },

        async syncDraftToServer(form) {
            if (!this.draftEndpoint || !form) {
                console.log('[AutoSave] Skipping sync - missing endpoint or form');
                return false;
            }

            const userAnswers = {};
            const answerInputs = form.querySelectorAll('input[name^="userAnswers["], textarea[name^="userAnswers["]');
            answerInputs.forEach((input) => {
                const match = input.name.match(/^userAnswers\[(\d+)\](?:\[(tense|trans)\])?$/);
                if (!match) {
                    return;
                }

                const qNum = match[1];
                const field = match[2] || 'trans';
                if (!userAnswers[qNum]) {
                    userAnswers[qNum] = {};
                }
                userAnswers[qNum][field] = input.value || '';
            });

            const paragraphInput = form.querySelector('textarea[name="userParagraphAnswer"]');
            const userParagraphAnswer = paragraphInput ? paragraphInput.value || '' : '';

            console.log('[AutoSave] Syncing to server:', { userAnswers, userParagraphAnswer });

            try {
                const response = await fetch(this.draftEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        userAnswers,
                        userParagraphAnswer,
                    }),
                    keepalive: true,
                });

                if (!response.ok) {
                    console.error('[AutoSave] Sync failed:', response.status, response.statusText);
                    return false;
                }

                const data = await response.json();
                console.log('[AutoSave] Sync success:', data);
                return true;
            } catch (e) {
                console.error('[AutoSave] Fetch error:', e);
                return false;
            }
        },

        /**
         * Manual "Save" button handler - forces an immediate server sync
         * (bypassing the debounce/periodic timers) and gives the user
         * explicit visual confirmation once the server has actually
         * persisted the answers, rather than the optimistic "saved"
         * shown by saveAnswers() the moment localStorage is written.
         */
        async manualSave() {
            const form = document.getElementById('meeting3-main-form');
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
                localStorage.setItem(this.storageKey, JSON.stringify({ answers, savedAt: Date.now() }));
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
        },

        /**
         * Restore saved answers, merging localStorage with the server-side
         * draft (AssignmentDraft). localStorage alone isn't reliable across
         * devices/browsers or after storage eviction/clearing - when that
         * happens the page used to look like all progress was lost, even
         * though the server copy (synced on every save) was intact. Local
         * wins per-field on conflict (freshest since it's written on every
         * keystroke pre-sync); the server fills in anything local is
         * missing. The merged result is written back to localStorage so
         * this device is "healed" going forward.
         */
        async restoreAnswers() {
            let localAnswers = {};
            let localSavedAt = 0;
            try {
                const savedData = localStorage.getItem(this.storageKey);
                if (savedData) {
                    const parsed = JSON.parse(savedData) || {};
                    // New format wraps the answer map with a timestamp; old
                    // format (pre-reconciliation) IS the answer map itself -
                    // treat that as having no known timestamp (0) so a
                    // server copy that DOES have one can win against it.
                    if (parsed && typeof parsed === 'object' && parsed.answers && typeof parsed.answers === 'object') {
                        localAnswers = parsed.answers;
                        localSavedAt = Number(parsed.savedAt) || 0;
                    } else {
                        localAnswers = parsed;
                    }
                }
            } catch (e) {
                console.error('Failed to read localStorage draft:', e);
            }

            let serverAnswers = {};
            let serverSavedAt = 0;
            try {
                const response = await fetch(this.draftEndpoint, {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                if (response.ok) {
                    const data = await response.json();
                    if (data && data.answers && typeof data.answers === 'object') {
                        Object.keys(data.answers).forEach((qNum) => {
                            const q = data.answers[qNum];
                            if (q && typeof q === 'object') {
                                if (q.tense) serverAnswers[`userAnswers[${qNum}][tense]`] = q.tense;
                                if (q.trans) serverAnswers[`userAnswers[${qNum}][trans]`] = q.trans;
                                if (q.answer) serverAnswers[`userAnswers[${qNum}]`] = q.answer;
                            } else if (typeof q === 'string' || typeof q === 'number') {
                                serverAnswers[`userAnswers[${qNum}][trans]`] = String(q);
                                serverAnswers[`userAnswers[${qNum}]`] = String(q);
                            }
                        });
                    }
                    if (data && data.paragraph_answer) {
                        serverAnswers['userParagraphAnswer'] = data.paragraph_answer;
                    }
                    if (data && data.saved_at) {
                        const parsedServerTime = Date.parse(data.saved_at);
                        if (!Number.isNaN(parsedServerTime)) {
                            serverSavedAt = parsedServerTime;
                        }
                    }
                }
            } catch (e) {
                console.error('[AutoSave] Failed to fetch server draft:', e);
            }

            // Whichever side has a known, strictly-later timestamp wins on a
            // per-key basis (the other side still fills in any keys it's
            // missing). Falls back to the original "local always wins"
            // behavior when neither side has a usable timestamp (e.g. an
            // old-format localStorage entry, or a server response with no
            // saved_at) - same effective behavior as before this change for
            // anyone whose localStorage predates it.
            const answers = (serverSavedAt > localSavedAt)
                ? Object.assign({}, localAnswers, serverAnswers)
                : Object.assign({}, serverAnswers, localAnswers);

            if (Object.keys(answers).length === 0) {
                console.log('No saved data to restore');
                return;
            }

            let restoredCount = 0;
            Object.keys(answers).forEach(name => {
                let input = document.querySelector(`input[name="${name}"], textarea[name="${name}"]`);
                if (!input) {
                    const qMatch = name.match(/^(?:userAnswers\[)?(\d+)\]?(?:\[(trans|tense)\])?$/);
                    if (qMatch) {
                        const qNum = qMatch[1];
                        const field = qMatch[2] || 'trans';
                        input = document.querySelector(`input[name="userAnswers[${qNum}][${field}]"], textarea[name="userAnswers[${qNum}][${field}]"], input[name="userAnswers[${qNum}]"], textarea[name="userAnswers[${qNum}]"]`);
                    }
                }

                // Apply the winning value from the timestamp-reconciled `answers`
                // above, even if the field already has a server-rendered value
                // (from PHP Blade) - `answers` has already resolved which side
                // (local vs server) is actually newer, so this is no longer a
                // blind "local always overrides PHP's render" like before.
                // Only skip readOnly/disabled fields and truly-missing values.
                if (input && !input.readOnly && !input.disabled && answers[name] !== undefined && answers[name] !== null) {
                    if (input.value !== String(answers[name])) {
                        input.value = answers[name];
                        restoredCount++;
                    }
                }
            });

            try {
                localStorage.setItem(this.storageKey, JSON.stringify({ answers, savedAt: Date.now() }));
            } catch (e) {
                console.error('Failed to heal localStorage with merged draft:', e);
            }

            if (restoredCount > 0) {
                console.log(`✓ Restored ${restoredCount} saved answers`);
                this.showRestoreIndicator(restoredCount);
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
         * Show a brief error indicator when a manual save fails
         */
        showSaveErrorIndicator() {
            const indicator = document.createElement('div');
            indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
            indicator.style.transition = 'opacity 0.3s';
            indicator.innerHTML = '✗ Gagal menyimpan, coba lagi';
            document.body.appendChild(indicator);

            setTimeout(() => {
                indicator.style.opacity = '0';
                setTimeout(() => indicator.remove(), 300);
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

    // Initialize auto-save for meeting 3
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('3', userId);
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

    @if(!$submitted)
        {{-- Fixed bottom-center, horizontally aligned with the Whiteboard
             toggle button (live-drawing.blade.php uses the same
             left: 50%; transform: translateX(-50%) centering, but pinned
             to the top instead of the bottom). --}}
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