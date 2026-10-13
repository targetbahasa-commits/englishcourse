<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - SAT</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
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
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-2xl shadow-lg shrink-0">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 20.055 12.083 12.083 0 015.84 10.578L12 14z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"></path>
                                </a>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-yellow-600 to-amber-600 bg-clip-text text-transparent">
                                    SAT
                                </h1>
                                <p class="text-gray-600 mt-1">Scholastic Assessment Test - pilih section dan mulai latihanmu!</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            @if(Auth::check() && Auth::user()->isAdmin())
                                <a href="{{ route('admin.impersonate', 'student') }}"
                                   class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition text-sm shrink-0"
                                   title="Masuk mode siswa untuk melihat tampilan student">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Tampilan Siswa
                                </a>
                            @endif

                            <a href="{{ route('assignments.index') }}"
                                class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Section Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Reading & Writing -->
                    <a href="{{ route('assignments.sat.reading-writing') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                        <div class="h-32 bg-indigo-600 relative overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-indigo-700 shadow-sm">4 Domains</span>
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Reading &amp; Writing</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Pemahaman bacaan, struktur teks, analisis data, dan 4 domain keahlian Digital SAT.</p>
                            <div class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
                                Start Learning
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <!-- Grammar Lessons -->
                    <a href="{{ route('assignments.sat.reading-writing') }}?tab=grammar" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                        <div class="h-32 bg-purple-600 relative overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-purple-700 shadow-sm">9 Lessons</span>
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Grammar Lessons</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Panduan lengkap tata bahasa Digital SAT: kalimat, tanda baca, tenses, modifier, dan transisi.</p>
                            <div class="w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
                                Start Learning
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <!-- Math -->
                    <a href="{{ route('assignments.sat.math') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                        <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-600 relative overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-teal-700 shadow-sm">4 Domains</span>
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m12 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Math</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Aljabar, geometri, fungsi lanjutan, dan analisis data kuantitatif.</p>
                            <div class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
                                Start Learning
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>

                @php $fullTests = $fullTests ?? collect(); $drills = $drills ?? collect(); @endphp

                <!-- SAT Score Estimate Banner -->
                <div class="mt-10 p-6 sm:p-7 bg-gradient-to-r from-sky-600 to-blue-700 rounded-3xl text-white shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-6 border border-sky-400/30">
                    <div class="space-y-2 max-w-2xl">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-white/20 text-white">
                                Estimasi &mdash; Bukan Skor Resmi
                            </span>
                            <span class="text-xs text-sky-100 font-medium tracking-wide">Skala estimasi 400 &ndash; 1600</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">Digital SAT &mdash; Estimasi Skor Latihan</h3>
                        <p class="text-xs sm:text-sm text-sky-100 leading-relaxed">
                            Selesaikan salah satu Full Test di bawah (Reading &amp; Writing + Math, 4 modul) untuk melihat estimasi skor latihanmu. Ini bukan skor resmi College Board.
                        </p>
                    </div>
                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 shrink-0">
                        @forelse($fullTests->filter(fn($t) => $t->score_report_available) as $t)
                            <a href="{{ route('assignments.sat.score-report', $t->test_number) }}"
                               class="px-5 py-3 rounded-xl bg-white text-sky-700 hover:bg-sky-50 font-extrabold text-sm shadow-md hover:shadow-lg transition flex items-center gap-2">
                                <span>Lihat Estimasi Test {{ $t->test_number }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @empty
                            <span class="px-4 py-3 rounded-xl bg-white/10 text-sky-100 text-xs font-semibold border border-white/20">
                                Belum ada Full Test yang selesai
                            </span>
                        @endforelse
                    </div>
                </div>

                <!-- Full Tests Section -->
                <div class="mt-12" id="practice-tests">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                <span class="w-2.5 h-6 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full inline-block"></span>
                                SAT Full Practice Tests
                            </h2>
                            <p class="text-sm text-gray-500 mt-0.5">Simulasi ujian Digital SAT 4 modul (RW 1&ndash;2 + Math 1&ndash;2) dengan estimasi skor 400&ndash;1600.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(Auth::user()->isAdmin())
                            <button onclick="document.getElementById('addPracticeTestModal').classList.remove('hidden')" class="px-3.5 py-1.5 bg-indigo-600 text-white rounded-xl shadow-xs hover:bg-indigo-700 font-bold text-xs transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Practice Test
                            </button>
                            @endif
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 self-start sm:self-auto">
                                {{ $fullTests->count() }} Full Test{{ $fullTests->count() === 1 ? '' : 's' }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @php
                            $colorStyles = [
                                1 => ['header' => 'background: linear-gradient(135deg, #2563eb, #4f46e5);', 'text' => '#4338ca', 'btn' => 'background-color: #4f46e5; color: #ffffff;'],
                                2 => ['header' => 'background: linear-gradient(135deg, #0d9488, #059669);', 'text' => '#0f766e', 'btn' => 'background-color: #0d9488; color: #ffffff;'],
                                3 => ['header' => 'background: linear-gradient(135deg, #be123c, #f43f5e);', 'text' => '#be123c', 'btn' => 'background-color: #e11d48; color: #ffffff;'],
                            ];
                        @endphp
                        @forelse($fullTests as $t)
                        @php $cs = $colorStyles[$t->test_number] ?? $colorStyles[1]; @endphp
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-1">
                            <div class="min-h-[6.5rem] p-5 flex flex-col justify-between text-white relative" style="{{ $cs['header'] }}">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-white/20 backdrop-blur-sm border border-white/20">
                                        Full Test {{ $t->test_number }} &bull; Adaptive
                                    </span>
                                    @if($t->rw_completed)
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-400 text-gray-900 shadow-xs">
                                            ✓ RW Selesai
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-bold text-white drop-shadow-sm leading-snug line-clamp-2" title="{{ $t->title }}">{{ $t->title }}</h3>
                            </div>
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <p class="text-xs sm:text-sm text-gray-500 leading-relaxed mb-4">
                                        Section 1: Reading &amp; Writing (2 modul adaptif) &bull; Section 2: Math (2 modul adaptif). Estimasi skor 400&ndash;1600 setelah keempat modul selesai.
                                    </p>
                                </div>
                                <div class="pt-3 border-t border-gray-100 space-y-2">
                                    @if(!$t->is_locked || Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                        <a href="{{ route('assignments.sat.practice-test', $t->module1->meeting_number) }}" class="block w-full py-3 px-4 text-center rounded-xl text-sm font-bold transition shadow-sm hover:shadow-md" style="{{ $cs['btn'] }}">
                                            {{ $t->rw_completed ? 'Lanjutkan / Review' : 'Mulai Full Test' }} &rarr;
                                        </a>
                                        @if($t->score_report_available)
                                            <a href="{{ route('assignments.sat.score-report', $t->test_number) }}" class="block w-full py-2 px-3 text-center rounded-xl text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 transition">
                                                Lihat Estimasi Skor
                                            </a>
                                        @endif
                                    @else
                                        <button disabled class="block w-full py-3 px-4 text-center rounded-xl text-sm font-bold text-gray-400 bg-gray-100 cursor-not-allowed">
                                            🔒 Terkunci
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full bg-white rounded-2xl p-8 text-center text-gray-500 border border-gray-100">
                            Belum ada Full Test yang ditambahkan.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Topical Drills Section -->
                @if($drills->isNotEmpty())
                <div class="mt-12" id="topical-drills">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-2.5 h-6 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full inline-block"></span>
                            Latihan Topikal (Reading &amp; Writing)
                        </h2>
                        <p class="text-sm text-gray-500 mt-0.5">Latihan satu-modul untuk mengasah skill tertentu. Skor ditampilkan dalam persen (0&ndash;100%) dan <strong>tidak</strong> masuk ke estimasi 400&ndash;1600.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($drills as $drill)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Latihan {{ $drill->meeting_number }}</span>
                                    @if($drill->completed)
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">{{ round($drill->user_score) }}%</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-gray-800 text-sm leading-snug mb-1 line-clamp-2">{{ $drill->title }}</h4>
                                <p class="text-xs text-gray-400">{{ $drill->questions_count }} soal</p>
                            </div>
                            @if(!$drill->is_locked || Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                <a href="{{ route('assignments.sat.practice-test', $drill->meeting_number) }}" class="mt-3 block w-full py-2 px-3 text-center rounded-lg text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 transition">
                                    {{ $drill->completed ? 'Kerjakan Lagi' : 'Mulai Latihan' }} &rarr;
                                </a>
                            @else
                                <button disabled class="mt-3 block w-full py-2 px-3 text-center rounded-lg text-xs font-bold text-gray-400 bg-gray-100 cursor-not-allowed">🔒 Terkunci</button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Add Practice Test Modal (Admin) -->
    @if(Auth::user()->isAdmin())
    <div id="addPracticeTestModal" class="fixed inset-0 bg-black/50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-lg shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Tambah SAT Full Practice Test</h3>
                    <button onclick="document.getElementById('addPracticeTestModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('assignments.sat.reading-writing.meeting.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Set</label>
                            <input type="number" name="meeting_number" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required placeholder="misal: 5">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Practice Test</label>
                            <input type="text" name="title" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required placeholder="misal: Practice Test 2 — Module 1">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Sub Judul (Opsional)</label>
                            <input type="text" name="subtitle" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="misal: Reading & Writing Module 1">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label>
                            <textarea name="description" rows="3" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Tuliskan cakupan simulasi practice test ini..."></textarea>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="add_is_locked" name="is_locked" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="add_is_locked" class="text-sm text-gray-700">Kunci set ini untuk siswa</label>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('addPracticeTestModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition">Simpan Practice Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Practice Test Modal (Admin) -->
    <div id="editPracticeTestModal" class="fixed inset-0 bg-black/50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-lg shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Edit SAT Full Practice Test</h3>
                    <button onclick="document.getElementById('editPracticeTestModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form id="editPracticeTestForm" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Practice Test</label>
                            <input type="text" id="edit_test_title" name="title" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Sub Judul</label>
                            <input type="text" id="edit_test_subtitle" name="subtitle" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label>
                            <textarea id="edit_test_description" name="description" rows="3" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('editPracticeTestModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition">Perbarui Practice Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditPracticeTestModal(test) {
            document.getElementById('editPracticeTestForm').action = `/assignments/sat/reading-writing/meeting/${test.id}/update`;
            document.getElementById('edit_test_title').value = test.title;
            document.getElementById('edit_test_subtitle').value = test.subtitle || '';
            document.getElementById('edit_test_description').value = test.description || '';
            document.getElementById('editPracticeTestModal').classList.remove('hidden');
        }
    </script>
    @endif

    @include('components.student-broadcaster')
    @include('components.floating-wa-button')
</body>
</html>
