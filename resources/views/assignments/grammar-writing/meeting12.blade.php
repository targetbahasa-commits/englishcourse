<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting {{ $displayMeetingNumber ?? 12 }}</title>
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
                <span class="text-sm font-semibold text-cyan-600 tracking-wider uppercase">{{ ($displayMeetingNumber ?? 12) == 7 ? 'Fast-track Grammar for Writing' : 'Grammar for Writing' }}</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ ($displayMeetingNumber ?? 12) == 7 ? 'FANBOYS & Adverbial Clause (Pertemuan 7)' : 'Adverbial Clause (Pertemuan 12)' }}</h1>
            </div>
            <x-grammar-meeting-actions :meetingNumber="($displayMeetingNumber ?? 12)" track="fast-track" />
        </div>

        @if($submitted)
            <div class="bg-cyan-600 text-white p-6 rounded-xl text-center mb-6 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-cyan-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting7.submit'), PHP_URL_PATH) }}" id="meetingAnswerForm" x-data="{ mobileTab: 'soal' }">
            @csrf

            <!-- Mobile View Switcher (< lg) -->
            <div class="flex lg:hidden mb-4 p-1.5 bg-white rounded-2xl border border-cyan-200 shadow-sm sticky top-3 z-30">
                <button type="button" @click="mobileTab = 'soal'"
                        :class="mobileTab === 'soal' ? 'bg-cyan-600 text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="flex-1 py-2.5 px-3 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Soal Latihan ({{ count($questions) }})</span>
                </button>
                <button type="button" @click="mobileTab = 'materi'"
                        :class="mobileTab === 'materi' ? 'bg-cyan-600 text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-semibold'"
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
                        <!-- 1. FANBOYS (Coordinating Conjunctions) -->
                        <div>
                            <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <span class="bg-indigo-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">1</span>
                                FANBOYS (Coordinating Conjunctions - Compound Sentences)
                            </h5>
                            <p class="text-xs sm:text-sm text-gray-600 mb-3">
                                <strong>FANBOYS</strong> adalah kata hubung koordinatif yang menghubungkan 2 kalimat utuh yang setara (Independent Clauses) membentuk <strong>Compound Sentence</strong>.
                            </p>

                            <!-- Table of FANBOYS -->
                            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse bg-white text-xs min-w-[500px]">
                                        <thead>
                                            <tr class="bg-gray-800 text-white text-[11px] uppercase tracking-wider">
                                                <th class="p-3 font-semibold border-b border-gray-700 w-16 text-center">Huruf</th>
                                                <th class="p-3 font-semibold border-b border-gray-700">Konjungsi</th>
                                                <th class="p-3 font-semibold border-b border-gray-700">Makna / Fungsi</th>
                                                <th class="p-3 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700 font-mono text-[11px]">
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-2.5 font-bold text-indigo-700 text-center">F</td>
                                                <td class="p-2.5 font-bold text-gray-900">For</td>
                                                <td class="p-2.5 font-sans text-gray-700">Karena / Sebab</td>
                                                <td class="p-2.5 italic text-gray-600 font-sans">He studied hard, <strong>for</strong> the exam was crucial.</td>
                                            </tr>
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-2.5 font-bold text-indigo-700 text-center">A</td>
                                                <td class="p-2.5 font-bold text-gray-900">And</td>
                                                <td class="p-2.5 font-sans text-gray-700">Dan / Serta (Penambahan)</td>
                                                <td class="p-2.5 italic text-gray-600 font-sans">She completed the report, <strong>and</strong> he presented it.</td>
                                            </tr>
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-2.5 font-bold text-indigo-700 text-center">N</td>
                                                <td class="p-2.5 font-bold text-gray-900">Nor</td>
                                                <td class="p-2.5 font-sans text-gray-700">Maupun / Dan tidak juga (Inversi)</td>
                                                <td class="p-2.5 italic text-gray-600 font-sans">He did not call, <strong>nor</strong> did he send a message.</td>
                                            </tr>
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-2.5 font-bold text-indigo-700 text-center">B</td>
                                                <td class="p-2.5 font-bold text-gray-900">But</td>
                                                <td class="p-2.5 font-sans text-gray-700">Tetapi / Namun (Kontras)</td>
                                                <td class="p-2.5 italic text-gray-600 font-sans">The plan was ambitious, <strong>but</strong> the budget was tight.</td>
                                            </tr>
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-2.5 font-bold text-indigo-700 text-center">O</td>
                                                <td class="p-2.5 font-bold text-gray-900">Or</td>
                                                <td class="p-2.5 font-sans text-gray-700">Atau (Pilihan)</td>
                                                <td class="p-2.5 italic text-gray-600 font-sans">We must adapt now, <strong>or</strong> we will fall behind.</td>
                                            </tr>
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-2.5 font-bold text-indigo-700 text-center">Y</td>
                                                <td class="p-2.5 font-bold text-gray-900">Yet</td>
                                                <td class="p-2.5 font-sans text-gray-700">Namun / Kendati demikian</td>
                                                <td class="p-2.5 italic text-gray-600 font-sans">It rained heavily, <strong>yet</strong> the match continued.</td>
                                            </tr>
                                            <tr class="bg-white hover:bg-indigo-50/40">
                                                <td class="p-2.5 font-bold text-indigo-700 text-center">S</td>
                                                <td class="p-2.5 font-bold text-gray-900">So</td>
                                                <td class="p-2.5 font-sans text-gray-700">Sehingga / Akibatnya (Hasil)</td>
                                                <td class="p-2.5 italic text-gray-600 font-sans">The data was validated, <strong>so</strong> the paper was published.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="p-3 bg-indigo-50 rounded-xl border border-indigo-200 text-indigo-950 text-xs">
                                <strong class="block font-bold text-indigo-900 mb-1">📌 Aturan Tanda Koma FANBOYS:</strong>
                                <p>Jika menghubungkan 2 kalimat lengkap (Independent Clauses: <code>S + V</code>), <strong>WAJIB</strong> diberi tanda koma sebelum kata hubung: <code class="font-bold bg-white px-1.5 py-0.5 rounded border border-indigo-200">[Clause 1], + [FANBOYS] + [Clause 2]</code>.</p>
                            </div>
                        </div>

                        <!-- 2. Adverbial Clause -->
                        <div>
                            <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <span class="bg-cyan-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">2</span>
                                Pola & Posisi Adverbial Clause (Complex Sentences)
                            </h5>
                            <p class="text-xs sm:text-sm text-gray-600 mb-3">Adverbial Clause adalah anak kalimat yang diawali kata hubung (subordinating conjunction) dan berfungsi menerangkan kata kerja, kata sifat, atau seluruh kalimat utama (Main Clause).</p>

                            <!-- Table of Positions -->
                            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse bg-white text-xs min-w-[500px]">
                                        <thead>
                                            <tr class="bg-gray-800 text-white text-[11px] uppercase tracking-wider">
                                                <th class="p-3 font-semibold border-b border-gray-700">Posisi Klausa</th>
                                                <th class="p-3 font-semibold border-b border-gray-700">Formula Gramatikal</th>
                                                <th class="p-3 font-semibold border-b border-gray-700">Aturan Koma & Contoh</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700">
                                            <tr class="bg-white hover:bg-cyan-50/40">
                                                <td class="p-3 font-bold text-gray-900">Di Awal<br><span class="text-[10px] text-gray-500 font-normal">(Initial)</span></td>
                                                <td class="p-3 font-mono text-cyan-900 font-semibold text-[11px]">Conj + S + V, S + V</td>
                                                <td class="p-3">
                                                    <div class="text-emerald-700 font-semibold text-[11px]">WAJIB tanda koma (,)</div>
                                                    <div class="italic text-gray-600 text-[11px] mt-0.5"><u>Before the machine was invented</u>, spread of science was slow.</div>
                                                </td>
                                            </tr>
                                            <tr class="bg-white hover:bg-cyan-50/40">
                                                <td class="p-3 font-bold text-gray-900">Di Tengah<br><span class="text-[10px] text-gray-500 font-normal">(Middle)</span></td>
                                                <td class="p-3 font-mono text-cyan-900 font-semibold text-[11px]">S, Conj + S + V, + V</td>
                                                <td class="p-3">
                                                    <div class="text-emerald-700 font-semibold text-[11px]">Diapit dua koma (,)</div>
                                                    <div class="italic text-gray-600 text-[11px] mt-0.5">Civilization, <u>although very old</u>, built great monuments.</div>
                                                </td>
                                            </tr>
                                            <tr class="bg-white hover:bg-cyan-50/40">
                                                <td class="p-3 font-bold text-gray-900">Di Akhir<br><span class="text-[10px] text-gray-500 font-normal">(Final)</span></td>
                                                <td class="p-3 font-mono text-cyan-900 font-semibold text-[11px]">S + V + Conj + S + V</td>
                                                <td class="p-3">
                                                    <div class="text-gray-700 font-semibold text-[11px]">Tidak perlu koma</div>
                                                    <div class="italic text-gray-600 text-[11px] mt-0.5">I will wait for you <u>until you finish your work</u>.</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- 10 Categories of Conjunctions -->
                        <div>
                            <h5 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <span class="bg-cyan-600 text-white w-5 h-5 flex items-center justify-center rounded-full text-[10px] font-bold shadow-xs">3</span>
                                Daftar Kata Hubung Adverbial Clause & Artinya
                            </h5>
                            <div class="grid grid-cols-1 gap-3 text-xs">
                                <div class="bg-cyan-50/70 p-3 rounded-xl border border-cyan-100 space-y-1">
                                    <strong class="text-cyan-900 font-bold block mb-1">1) Waktu (Time):</strong>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-1 text-gray-800 font-mono text-[11px]">
                                        <div>• <strong>when</strong> = ketika / saat</div>
                                        <div>• <strong>whenever</strong> = kapan pun</div>
                                        <div>• <strong>while / as</strong> = selagi / sementara</div>
                                        <div>• <strong>before</strong> = sebelum</div>
                                        <div>• <strong>after</strong> = setelah / sesudah</div>
                                        <div>• <strong>since</strong> = sejak / semenjak</div>
                                        <div>• <strong>until / till</strong> = hingga / sampai</div>
                                        <div>• <strong>as soon as / once</strong> = segera setelah</div>
                                        <div>• <strong>by the time</strong> = menjelang / saat</div>
                                        <div>• <strong>as long as</strong> = selama / sepanjang</div>
                                    </div>
                                </div>

                                <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100 space-y-1">
                                    <strong class="text-emerald-900 font-bold block mb-1">2) Sebab / Alasan (Cause & Reason):</strong>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-1 text-gray-800 font-mono text-[11px]">
                                        <div>• <strong>because / as</strong> = karena / sebab</div>
                                        <div>• <strong>since</strong> = karena / berhubung</div>
                                        <div>• <strong>in that</strong> = karena / dalam hal</div>
                                        <div>• <strong>now that</strong> = karena sekarang</div>
                                    </div>
                                </div>

                                <div class="bg-purple-50/70 p-3 rounded-xl border border-purple-100 space-y-1">
                                    <strong class="text-purple-900 font-bold block mb-1">3) Tempat & Tujuan (Place & Purpose):</strong>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-1 text-gray-800 font-mono text-[11px]">
                                        <div>• <strong>where</strong> = di mana</div>
                                        <div>• <strong>wherever</strong> = di mana pun</div>
                                        <div>• <strong>so that / in order that</strong> = agar / supaya (+ S+V)</div>
                                        <div>• <strong>in order to / so as to</strong> = agar (+ V1)</div>
                                    </div>
                                </div>

                                <div class="bg-amber-50/70 p-3 rounded-xl border border-amber-100 space-y-1">
                                    <strong class="text-amber-900 font-bold block mb-1">4) Syarat / Pengandaian (Condition):</strong>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-1 text-gray-800 font-mono text-[11px]">
                                        <div>• <strong>if</strong> = jika / jikalau</div>
                                        <div>• <strong>unless</strong> = jika tidak / kecuali jika</div>
                                        <div>• <strong>provided that</strong> = asalkan / syaratnya</div>
                                        <div>• <strong>in case (that)</strong> = untuk antisipasi jika</div>
                                    </div>
                                </div>

                                <div class="bg-rose-50/70 p-3 rounded-xl border border-rose-100 space-y-1">
                                    <strong class="text-rose-900 font-bold block mb-1">5) Pertentangan / Konsesi (Contrast & Concession):</strong>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-1 text-gray-800 font-mono text-[11px]">
                                        <div>• <strong>although / even though</strong> = meskipun</div>
                                        <div>• <strong>while / whereas</strong> = sedangkan / sementara</div>
                                        <div>• <strong>despite the fact that</strong> = meski faktanya</div>
                                        <div>• <strong>no matter how</strong> = betapapun</div>
                                    </div>
                                </div>

                                <div class="bg-teal-50/70 p-3 rounded-xl border border-teal-100 space-y-1">
                                    <strong class="text-teal-900 font-bold block mb-1">6) Akibat, Cara & Perbandingan (Result, Manner, Comparison):</strong>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-1 text-gray-800 font-mono text-[11px]">
                                        <div>• <strong>so + Adj + that</strong> = sangat... sehingga...</div>
                                        <div>• <strong>such + NP + that</strong> = sangat... sehingga...</div>
                                        <div>• <strong>as / just as</strong> = sebagaimana / persis seperti</div>
                                        <div>• <strong>as if / as though</strong> = seolah-olah</div>
                                        <div>• <strong>than / as... as</strong> = daripada / sama... seperti</div>
                                        <div>• <strong>the more..., the more...</strong> = semakin..., semakin...</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tips & Laws -->
                        <div class="bg-blue-50 border border-blue-200 text-blue-950 p-4 rounded-xl text-xs space-y-1.5">
                            <strong class="block text-xs font-bold text-blue-900 flex items-center gap-1.5 mb-1">
                                💡 Tips & Hukum Utama:
                            </strong>
                            <p>• <strong>Compound (FANBOYS):</strong> Menghubungkan 2 Independent Clause (klausa utama setara): <code>[S+V], [FANBOYS] [S+V]</code>.</p>
                            <p>• <strong>Complex (Adv Clause):</strong> Menghubungkan 1 Independent Clause dan 1 Dependent Clause: <code>[Conj S+V], [S+V]</code> atau <code>[S+V] [Conj S+V]</code>.</p>
                            <p>• <strong>Rumus Jumlah Verb:</strong> <code class="bg-blue-100 text-blue-900 px-1.5 py-0.5 rounded font-mono text-[11px]">Total Verb Tenses = Total Conjunction + 1</code></p>
                        </div>

                        <!-- Preposition vs Conjunction -->
                        <div class="bg-amber-50 border border-amber-200 text-amber-950 p-4 rounded-xl text-xs space-y-1.5">
                            <strong class="block text-xs font-bold text-amber-900 flex items-center gap-1.5 mb-1">
                                ⚠️ Aturan Emas: Pembeda Preposisi vs Konjungsi:
                            </strong>
                            <p>1. <strong>because / although / while:</strong> WAJIB diikuti Klausa (<code class="bg-amber-100 text-amber-900 px-1 py-0.5 rounded font-mono text-[11px]">S + V</code>) &rarr; <em>because the climate changed</em>.</p>
                            <p>2. <strong>because of / despite / in spite of:</strong> WAJIB diikuti Frasa Kata Benda / Noun Phrase (<code class="bg-amber-100 text-amber-900 px-1 py-0.5 rounded font-mono text-[11px]">Noun Phrase / Gerund</code>) &rarr; <em>because of climate change</em>.</p>
                            <em class="block text-[11px] text-amber-800 pt-1 border-t border-amber-200/60">Catatan Kunci: Jangan menambahkan Verb tenses setelah preposition (because of, despite, due to).</em>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Exercise (Always on Desktop, Tab on Mobile) -->
                <div class="lg:col-span-7" :class="mobileTab === 'soal' ? 'block' : 'hidden lg:block'">
                    <div class="bg-white rounded-3xl shadow-sm border border-cyan-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-cyan-50 via-sky-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-cyan-100">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">A. Translate Kalimat</h3>
                                    <p class="text-xs text-gray-500 mt-1">Dikelompokkan menjadi: <strong class="text-indigo-800">1. FANBOYS</strong> (Soal 1–18) & <strong class="text-cyan-800">2. Adverbial Clause</strong> (Soal 19–33)</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center justify-center rounded-full bg-indigo-600 text-white text-xs font-bold px-3 py-1.5 w-fit shadow-xs">
                                        18 Soal FANBOYS
                                    </span>
                                    <span class="inline-flex items-center justify-center rounded-full bg-cyan-600 text-white text-xs font-bold px-3 py-1.5 w-fit shadow-xs">
                                        15 Soal Adv Clause
                                    </span>
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <button type="button" @click="$dispatch('open-add-modal')" class="text-xs text-cyan-700 hover:text-cyan-900 underline font-semibold ml-2">+ Add Question</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($questions as $idx => $data)
                                    @if($idx == 0)
                                        <li class="list-none pt-1 pb-1">
                                            <div class="rounded-2xl border-2 border-indigo-600 p-4 shadow-sm flex items-center justify-between" style="background-color: #4f46e5; color: #ffffff;">
                                                <div class="flex items-center gap-3">
                                                    <span class="flex items-center justify-center w-8 h-8 rounded-xl font-black text-sm shadow-xs" style="background-color: #ffffff; color: #4f46e5;">1</span>
                                                    <div>
                                                        <h4 class="text-base font-bold tracking-wide" style="color: #ffffff;">Bagian 1: FANBOYS (Coordinating Conjunctions - Compound Sentences)</h4>
                                                        <p class="text-xs font-medium mt-0.5" style="color: #e0e7ff;">Soal 1 s.d. 18 &bull; For, And, Nor, But, Or, Yet, So (Kalimat Majemuk Setara)</p>
                                                    </div>
                                                </div>
                                                <span class="text-xs font-bold px-3 py-1 rounded-full shadow-xs shrink-0" style="background-color: #ffffff; color: #3730a3;">18 Soal</span>
                                            </div>
                                        </li>
                                    @elseif($idx == 18)
                                        <li class="list-none pt-6 pb-1">
                                            <div class="rounded-2xl border-2 border-cyan-600 p-4 shadow-sm flex items-center justify-between" style="background-color: #0891b2; color: #ffffff;">
                                                <div class="flex items-center gap-3">
                                                    <span class="flex items-center justify-center w-8 h-8 rounded-xl font-black text-sm shadow-xs" style="background-color: #ffffff; color: #0891b2;">2</span>
                                                    <div>
                                                        <h4 class="text-base font-bold tracking-wide" style="color: #ffffff;">Bagian 2: Adverbial Clause (Complex Sentences)</h4>
                                                        <p class="text-xs font-medium mt-0.5" style="color: #cffafe;">Soal 19 s.d. 33 &bull; Variasi: Di Awal (Wajib Koma), Di Tengah (Diapit Dua Koma), Di Akhir (Tanpa Koma)</p>
                                                    </div>
                                                </div>
                                                <span class="text-xs font-bold px-3 py-1 rounded-full shadow-xs shrink-0" style="background-color: #ffffff; color: #0e7490;">15 Soal</span>
                                            </div>
                                        </li>
                                    @endif

                                    <li class="group rounded-2xl border {{ $idx < 18 ? 'border-indigo-100 hover:border-indigo-300' : 'border-gray-200 hover:border-cyan-300' }} bg-white p-4 sm:p-5 transition hover:shadow-md space-y-3 overflow-visible">
                                        <div class="flex items-start gap-3 sm:gap-4">
                                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-sm font-bold shrink-0" style="{{ $idx < 18 ? 'background-color: #e0e7ff; color: #4f46e5;' : 'background-color: #cffafe; color: #0891b2;' }}">
                                                {{ $idx + 1 }}
                                            </div>
                                            <div class="pt-0.5 flex-1">
                                                <div class="mb-2 flex flex-wrap items-center gap-1.5">
                                                    @if($idx < 18)
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #4f46e5;"></span> FANBOYS: {{ $data['conjunction'] ?? 'Compound' }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold shadow-2xs" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: #0284c7;"></span> Adverbial Clause: {{ $data['conjunction'] ?? 'Complex' }}
                                                        </span>

                                                        @if($idx >= 18 && $idx <= 22)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                                                🚀 Di Awal (Initial)
                                                            </span>
                                                        @elseif($idx >= 23 && $idx <= 27)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-800 border border-purple-200">
                                                                ⚖️ Di Tengah (Middle)
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                                🏁 Di Akhir (Final)
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                                <p class="text-gray-900 font-medium text-sm sm:text-base leading-relaxed">{{ $data['id'] }}</p>
                                            </div>
                                            <div class="flex flex-row items-center gap-1 ml-2">
                                                <div x-data="{ open: false }" class="relative inline-block">
                                                    <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                        ?
                                                    </button>
                                                    <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                        <strong class="block mb-1 text-yellow-300">Contoh ({{ $data['conjunction'] }}):</strong>
                                                        {{ data_get($data, 'example.id', '-') }}<br>
                                                        <em class="text-gray-300">{{ data_get($data, 'example.en', '-') }}</em>
                                                        <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                    </div>
                                                </div>

                                                <div x-data="{ open: false }" class="relative inline-block">
                                                    <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                                        v
                                                    </button>
                                                    <div x-show="open" x-transition style="display: none;" class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed">
                                                        <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                        <?php $vocabItems = is_array($data['vocab'] ?? null) ? $data['vocab'] : []; ?>
                                                        <ul class="space-y-1">
                                                            @forelse($vocabItems as $en => $vocabData)
                                                                <li class="flex justify-between gap-3">
                                                                    <span class="text-green-300 font-mono">{{ $en }} <span class="text-gray-400 text-xs">{{ data_get($vocabData, 'pos', '') }}</span></span>
                                                                    <span>{{ data_get($vocabData, 'id', '-') }}</span>
                                                                </li>
                                                            @empty
                                                                <li class="text-gray-300">Tidak ada vocabulary helper.</li>
                                                            @endforelse
                                                        </ul>
                                                        <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                    </div>
                                                </div>

                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                    <button type="button"
                                                            data-payload="{{ json_encode([
                                                                'id' => $data['db_id'],
                                                                'question_text' => $data['id'],
                                                                'correct_answer' => $data['en'],
                                                                'type' => $data['type'],
                                                                'conjunction' => $data['conjunction'],
                                                                'example' => $data['example'],
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
                                            <textarea rows="1"
                                                   name="userAnswers[{{ $idx }}]"
                                                   style="field-sizing: content;"
                                                   class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   {{ $submitted ? 'readonly' : '' }}
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
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Section B: Paragraph -->
                    <div class="bg-white rounded-3xl shadow-sm border border-cyan-100 overflow-visible mb-6">
                        <div class="bg-gradient-to-r from-cyan-50 via-sky-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-cyan-100">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">B. Translate Paragraf</h3>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    @if(isset($paragraphDbId) && $paragraphDbId)
                                        <div class="flex gap-2 shrink-0">
                                            <button type="button"
                                                    data-payload="{{ json_encode([
                                                        'id' => $paragraphDbId,
                                                        'question_text' => $fullParagraphId,
                                                        'correct_answer' => $fullParagraphEn,
                                                        'vocab' => json_encode($paragraphVocab)
                                                    ]) }}"
                                                    onclick="openParagraphEditModal(this)"
                                                    class="text-xs text-cyan-700 hover:text-cyan-900 underline font-semibold">Edit</button>
                                            <form action="{{ parse_url(route('admin.grammar.question.destroy', $paragraphDbId), PHP_URL_PATH) }}" method="POST" onsubmit="return confirm('Delete paragraph? This cannot be undone.')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 underline font-semibold">Hapus</button>
                                            </form>
                                        </div>
                                    @else
                                        <button type="button" @click="$dispatch('open-add-paragraph-modal')" class="text-xs text-cyan-700 hover:text-cyan-900 underline font-semibold">+ Add Paragraph</button>
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
                                                <strong class="text-cyan-600">{{ $en }}</strong>: {{ $id }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                                <textarea
                                    name="userParagraphAnswer"
                                    rows="10"
                                    style="field-sizing: content;"
                                    class="auto-expand-answer resize-none overflow-hidden w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
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
                            <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-cyan-600 text-white rounded-xl font-bold hover:bg-cyan-700 transition-colors shadow-md">
                                Cek Jawaban
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if($submitted)
            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting7.reset'), PHP_URL_PATH) }}" class="mt-4">
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


    // Initialize auto-save for meeting 12
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('12', userId);
        }
    });
    </script>

    <!-- Add Question Modal -->
    <div x-data="{ open: false }" 
         @open-add-modal.window="open = true" 
         class="relative z-500" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true"
         style="display: none;"
         x-show="open">
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="12">
                        <input type="hidden" name="question_number" value="{{ count($questions) + 1 }}">
                        <!-- Default section -->
                        <input type="hidden" name="section" value="default">

                        <h3 class="text-xl font-bold text-gray-900 mb-6">Add New Question</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Type / Structure</label>
                            <select name="structure" class="w-full p-2 border rounded" required>
                                <option value="time">Time</option>
                                <option value="cause">Cause</option>
                                <option value="contrast">Contrast</option>
                                <option value="condition">Condition</option>
                                <option value="purpose">Purpose</option>
                                <option value="place">Place</option>
                                <option value="manner">Manner</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Conjunction (Formula)</label>
                            <input type="text" name="formula" class="w-full p-2 border rounded" placeholder="e.g. before (sebelum)" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Question (Indonesian)</label>
                            <textarea name="question_text" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Answer (English)</label>
                            <textarea name="correct_answer" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Example ID</label>
                                <input type="text" name="example_id" class="w-full p-2 border rounded" placeholder="Indonesian Example">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Example EN</label>
                                <input type="text" name="example_en" class="w-full p-2 border rounded" placeholder="English Example">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 rounded text-white hover:bg-indigo-700">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Question Modal -->
    <div x-data="{ open: false, data: {} }" 
         @open-meeting12-edit-modal.window="open = true; data = $event.detail; if(data.example) { data.example_id = data.example.id; data.example_en = data.example.en; }" 
         class="relative z-500" 
         style="display: none;"
         x-show="open">
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form :action="'/admin/assignments/grammar-writing/questions/' + data.id" method="POST" class="p-6">
                        @csrf
                        @method('PUT')
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Edit Question</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Type / Structure</label>
                            <select name="structure" x-model="data.type" class="w-full p-2 border rounded" required>
                                <option value="time">Time</option>
                                <option value="cause">Cause</option>
                                <option value="contrast">Contrast</option>
                                <option value="condition">Condition</option>
                                <option value="purpose">Purpose</option>
                                <option value="place">Place</option>
                                <option value="manner">Manner</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Conjunction (Formula)</label>
                            <input type="text" name="formula" x-model="data.conjunction" class="w-full p-2 border rounded" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Question (Indonesian)</label>
                            <textarea name="question_text" x-model="data.question_text" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Answer (English)</label>
                            <textarea name="correct_answer" x-model="data.correct_answer" rows="3" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Example ID</label>
                                <input type="text" name="example_id" x-model="data.example_id" class="w-full p-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Example EN</label>
                                <input type="text" name="example_en" x-model="data.example_en" class="w-full p-2 border rounded">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Vocab JSON (Advanced)</label>
                            <textarea name="vocab" x-model="data.vocab" rows="3" class="w-full p-2 border rounded font-mono text-xs"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: {"Word": {"id": "Terjemahan", "pos": "(n)"}}</p>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 rounded text-white hover:bg-indigo-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Paragraph Modal -->
    <div x-data="{ open: false, data: {} }" 
         @open-meeting12-paragraph-modal.window="open = true; data = $event.detail" 
         class="relative z-500" 
         style="display: none;"
         x-show="open">
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <form :action="'/admin/assignments/grammar-writing/questions/' + data.id" method="POST" class="p-6">
                        @csrf
                        @method('PUT')
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Edit Paragraph</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Paragraph (Indonesian)</label>
                            <textarea name="question_text" x-model="data.question_text" rows="6" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Paragraph (English)</label>
                            <textarea name="correct_answer" x-model="data.correct_answer" rows="6" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Vocab JSON</label>
                            <textarea name="vocab" x-model="data.vocab" rows="4" class="w-full p-2 border rounded font-mono text-xs"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: {"Word": "Translation"}</p>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 rounded text-white hover:bg-indigo-700">Update Paragraph</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Paragraph Modal -->
    <div x-data="{ open: false }" 
         @open-add-paragraph-modal.window="open = true" 
         class="relative z-500" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true"
         style="display: none;"
         x-show="open">
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <form action="{{ parse_url(route('admin.grammar.question.store'), PHP_URL_PATH) }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="meeting_number" value="12">
                        <input type="hidden" name="question_number" value="100">
                        <input type="hidden" name="section" value="paragraph">

                        <h3 class="text-xl font-bold text-gray-900 mb-6">Add Paragraph</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Paragraph (Indonesian)</label>
                            <textarea name="question_text" rows="6" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Paragraph (English)</label>
                            <textarea name="correct_answer" rows="6" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-900 mb-2">Vocab JSON</label>
                            <textarea name="vocab" rows="4" class="w-full p-2 border rounded font-mono text-xs"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: {"Word": "Translation"}</p>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 rounded text-gray-800 hover:bg-gray-300">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 rounded text-white hover:bg-indigo-700">Save Paragraph</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="delete-question-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this question?')) {
                const form = document.getElementById('delete-question-form');
                form.action = `/admin/assignments/grammar-writing/questions/${id}`;
                form.submit();
            }
        }

        function openEditModal(el) {
            try {
                const data = JSON.parse(el.dataset.payload);
                window.dispatchEvent(new CustomEvent('open-meeting12-edit-modal', { detail: data }));
            } catch (e) {
                console.error('Error parsing edit data', e);
                alert('Error opening edit modal. See console.');
            }
        }

        function openParagraphEditModal(el) {
            try {
                const data = JSON.parse(el.dataset.payload);
                window.dispatchEvent(new CustomEvent('open-meeting12-paragraph-modal', { detail: data }));
            } catch (e) {
                console.error('Error parsing paragraph edit data', e);
                alert('Error opening paragraph edit modal. See console.');
            }
        }
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