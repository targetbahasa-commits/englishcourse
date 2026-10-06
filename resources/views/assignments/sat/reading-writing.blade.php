<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - SAT Reading & Writing</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    @include('components.flash-messages')

    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8 pb-24">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                Reading &amp; Writing
                            </h1>
                            <p class="text-gray-600 mt-1">Digital SAT &mdash; Struktur kurikulum, 4 domain keahlian, dan panduan materi.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('assignments.sat') }}#practice-tests"
                            class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Buka Practice Tests
                        </a>
                        <a href="{{ route('assignments.sat') }}"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Callout: Practice Tests Moved Notice -->
            <div class="mb-8 p-6 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-3xl shadow-xl text-white flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur-sm border border-white/20 text-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Paket Latihan &amp; Ujian
                    </span>
                    <h2 class="text-xl md:text-2xl font-bold drop-shadow-sm pt-1">Mencari Paket Soal &amp; Simulasi Ujian?</h2>
                    <p class="text-indigo-100 text-sm max-w-2xl leading-relaxed">
                        Seluruh simulasi soal adaptif (Diagnostic Drills, Practice Test Module 1 &amp; Module 2) telah dipindahkan dan dikelompokkan ke menu <strong>SAT Full Practice Tests</strong> di halaman utama SAT.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('assignments.sat') }}#practice-tests" class="inline-flex items-center gap-2 px-6 py-3.5 bg-white hover:bg-yellow-400 text-indigo-950 font-bold text-sm rounded-2xl shadow-lg transition-all duration-200 hover:scale-105">
                        Menuju SAT Full Practice Tests
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Format Specs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Durasi Total</div>
                        <div class="text-lg font-bold text-gray-800">64 Menit</div>
                        <div class="text-[11px] text-gray-500">2 Module @ 32 menit</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Soal</div>
                        <div class="text-lg font-bold text-gray-800">54 Soal</div>
                        <div class="text-[11px] text-gray-500">27 Soal per module</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Model Ujian</div>
                        <div class="text-lg font-bold text-gray-800">Stage-Adaptive</div>
                        <div class="text-[11px] text-gray-500">Modul 2 adaptif berbasis skor M1</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe Passage</div>
                        <div class="text-lg font-bold text-gray-800">Kutipan Ringkas</div>
                        <div class="text-[11px] text-gray-500">25–150 kata per 1 pertanyaan</div>
                    </div>
                </div>
            </div>

            <!-- 4 Skill Domains -->
            <div class="mb-10">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-gradient-to-b from-blue-600 to-indigo-600 rounded-full inline-block"></span>
                        4 Domain Keahlian Digital SAT Reading &amp; Writing
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Ujian Digital SAT menguji empat domain kemampuan bahasa Inggris akademik secara menyeluruh:</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Domain 1 -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                                Domain 1 &bull; ~28% Porsi Soal
                            </span>
                            <span class="text-xs font-semibold text-gray-500">13–15 Soal</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Craft and Structure</h3>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            Menilai pemahaman makna kata dalam konteks tingkat tinggi, kemampuan menganalisis maksud penulis, serta membandingkan struktur antar teks.
                        </p>
                        <div class="space-y-2 pt-3 border-t border-gray-100">
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-blue-600">•</span>
                                <div><strong class="text-gray-900">Words in Context:</strong> Menentukan arti kata/frasa berdasarkan konteks bacaan akademis.</div>
                            </div>
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-blue-600">•</span>
                                <div><strong class="text-gray-900">Text Structure &amp; Purpose:</strong> Mengidentifikasi peran paragraf atau kalimat dalam membangun argumen teks.</div>
                            </div>
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-blue-600">•</span>
                                <div><strong class="text-gray-900">Cross-Text Connections:</strong> Membandingkan sudut pandang dua kutipan teks ilmiah/literatur.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Domain 2 -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200">
                                Domain 2 &bull; ~26% Porsi Soal
                            </span>
                            <span class="text-xs font-semibold text-gray-500">12–14 Soal</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Information and Ideas</h3>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            Mengukur kemampuan mengevaluasi gagasan utama, menarik kesimpulan logis, serta menganalisis bukti teks maupun data kuantitatif tabel/grafik.
                        </p>
                        <div class="space-y-2 pt-3 border-t border-gray-100">
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-indigo-600">•</span>
                                <div><strong class="text-gray-900">Central Ideas and Details:</strong> Menemukan ide pokok serta informasi kunci dalam bacaan.</div>
                            </div>
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-indigo-600">•</span>
                                <div><strong class="text-gray-900">Command of Evidence:</strong> Memilih kutipan atau data grafik yang memperkuat / melemahkan hipotesis.</div>
                            </div>
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-indigo-600">•</span>
                                <div><strong class="text-gray-900">Inferences:</strong> Melengkapi kesimpulan akhir teks secara konsisten dan logis.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Domain 3 -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-purple-50 text-purple-700 border border-purple-200">
                                Domain 3 &bull; ~26% Porsi Soal
                            </span>
                            <span class="text-xs font-semibold text-gray-500">11–15 Soal</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Standard English Conventions</h3>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            Menguji penguasaan tata bahasa baku Inggris, struktur kalimat lengkap, batas klausa, keselarasan subjek-verba, dan tanda baca standar.
                        </p>
                        <div class="space-y-2 pt-3 border-t border-gray-100">
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-purple-600">•</span>
                                <div><strong class="text-gray-900">Boundaries:</strong> Memperbaiki run-on sentences, comma splices, dan pemakaian titik koma / titik dua / em-dash.</div>
                            </div>
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-purple-600">•</span>
                                <div><strong class="text-gray-900">Form, Structure, and Sense:</strong> Subject-verb agreement, pronoun case, tenses konsisten, dan modifier placement.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Domain 4 -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Domain 4 &bull; ~20% Porsi Soal
                            </span>
                            <span class="text-xs font-semibold text-gray-500">8–12 Soal</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Expression of Ideas</h3>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            Meningkatkan efektivitas penyampaian pesan, kohesi antar kalimat, serta sintesis catatan riset sesuai tujuan retoris tertentu.
                        </p>
                        <div class="space-y-2 pt-3 border-t border-gray-100">
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-emerald-600">•</span>
                                <div><strong class="text-gray-900">Transitions:</strong> Memilih kata hubung logis (however, furthermore, consequently, specifically).</div>
                            </div>
                            <div class="flex items-start gap-2 text-xs text-gray-700">
                                <span class="font-bold text-emerald-600">•</span>
                                <div><strong class="text-gray-900">Rhetorical Synthesis:</strong> Memanfaatkan bullet points catatan peneliti untuk memenuhi tujuan tulisan yang diminta.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom CTA -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm text-center">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Siap Menguji Kemampuan Reading &amp; Writing Anda?</h3>
                <p class="text-gray-600 text-sm max-w-xl mx-auto mb-6">
                    Kerjakan paket latihan soal adaptif langsung di menu SAT Full Practice Tests yang dilengkapi pembahasan dan penskoran instan.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('assignments.sat') }}#practice-tests"
                        class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg transition hover:scale-105 inline-flex items-center gap-2">
                        Buka SAT Full Practice Tests
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                    <a href="{{ route('assignments.sat') }}"
                        class="px-6 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-2xl transition">
                        Kembali ke Menu SAT
                    </a>
                </div>
            </div>
        </main>
    </div>

    @include('components.student-broadcaster')
    @include('components.floating-wa-button')
</body>
</html>
