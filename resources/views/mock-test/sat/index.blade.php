<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Digital SAT Full Mock Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-slate-100">
    @include('components.impersonation-banner')
    @include('components.flash-messages')

    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @elseif(Auth::user()->active_role === 'guest_quick')
            @include('components.sidebar-guest')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 relative bg-slate-50 min-h-screen pb-24">
            <!-- Decorative background glow -->
            <div class="absolute top-0 inset-x-0 h-[380px] bg-gradient-to-b from-blue-100/70 to-transparent pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[400px] bg-blue-300/20 rounded-full blur-[100px] pointer-events-none mix-blend-multiply"></div>
            <div class="absolute top-0 left-0 w-[400px] h-[300px] bg-indigo-300/15 rounded-full blur-[80px] pointer-events-none mix-blend-multiply"></div>

            <div class="p-6 md:p-10 max-w-6xl mx-auto relative z-10">
                <!-- Header Breadcrumb & Back -->
                <div class="flex items-center justify-between gap-4 mb-6">
                    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <a href="{{ route('mock-test') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            <span>Mock Tests</span>
                        </a>
                        <span>/</span>
                        <span class="text-slate-800 font-bold">Digital SAT</span>
                    </nav>

                    <a href="{{ route('mock-test') }}" class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Kembali</span>
                    </a>
                </div>

                @php $fullTests = $fullTests ?? collect(); $drills = $drills ?? collect(); @endphp

                <!-- Title Banner -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-blue-100 text-blue-700 border border-blue-200 mb-3">
                            <span>CBT Bluebook-Style Simulator</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            Digital SAT Mock Test
                        </h1>
                        <p class="text-slate-600 mt-2 text-sm md:text-base max-w-2xl leading-relaxed">
                            {{ $fullTests->count() }} Full Test adaptif (2 modul Reading &amp; Writing + 2 modul Math, estimasi skor 400&ndash;1600) dan {{ $drills->count() }} latihan topikal satu-modul untuk mengasah skill tertentu.
                        </p>
                    </div>

                    <div class="flex items-center gap-2.5 shrink-0">
                        @if(Auth::user()->isAdmin())
                        <button onclick="document.getElementById('addPracticeTestModal').classList.remove('hidden')" class="px-4 py-2.5 bg-blue-600 text-white rounded-xl shadow-xs hover:bg-blue-700 font-bold text-xs transition flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Set
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Full Tests Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                        $colorStyles = [
                            1 => ['header' => 'background: linear-gradient(135deg, #2563eb, #4f46e5);', 'btn' => 'background-color: #4f46e5; color: #ffffff;'],
                            2 => ['header' => 'background: linear-gradient(135deg, #0d9488, #059669);', 'btn' => 'background-color: #0d9488; color: #ffffff;'],
                            3 => ['header' => 'background: linear-gradient(135deg, #be123c, #f43f5e);', 'btn' => 'background-color: #e11d48; color: #ffffff;'],
                        ];
                    @endphp
                    @forelse($fullTests as $t)
                    @php $cs = $colorStyles[$t->test_number] ?? $colorStyles[1]; @endphp
                    <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-200/80 flex flex-col group hover:-translate-y-1">
                        <div class="min-h-[7rem] p-6 flex flex-col justify-between text-white relative" style="{{ $cs['header'] }}">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-sm border border-white/25">
                                    Full Test {{ $t->test_number }} &bull; Adaptive
                                </span>

                                <div class="flex items-center gap-1.5">
                                    @if($t->rw_completed)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-400 text-gray-900 shadow-xs">
                                            ✓ RW Selesai
                                        </span>
                                    @endif

                                    @if(Auth::user()->isAdmin())
                                    <!-- Lock/Unlock Toggle -->
                                    <form action="{{ route('mock-test.sat.reading-writing.meeting.toggle-lock', $t->module1->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 rounded-lg transition {{ $t->is_locked ? 'bg-red-500 text-white' : 'bg-white/20 text-white hover:bg-white/30' }}" title="{{ $t->is_locked ? 'Buka Kunci' : 'Kunci Practice Test' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($t->is_locked)
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                                @endif
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <h3 class="text-xl font-extrabold text-white drop-shadow-sm leading-snug line-clamp-2" title="{{ $t->title }}">{{ $t->title }}</h3>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        Section 1: Reading & Writing
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3v-6m-3 6v-9m12 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2z"></path></svg>
                                        Section 2: Math
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                                    {{ $t->description ?? '2 modul adaptif per section. Estimasi skor 400-1600 setelah keempat modul selesai — bukan skor resmi College Board.' }}
                                </p>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                                @if(!$t->is_locked || Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                    <a href="{{ route('mock-test.sat.practice-test', $t->module1->meeting_number) }}" class="block w-full py-3 px-4 text-center rounded-xl text-sm font-bold transition shadow-sm hover:shadow-md" style="{{ $cs['btn'] }}">
                                        {{ $t->rw_completed ? 'Lanjutkan / Review RW' : 'Mulai Full Test (RW)' }} &rarr;
                                    </a>
                                    @if($t->score_report_available)
                                        <a href="{{ route('mock-test.sat.score-report', $t->test_number) }}" class="block w-full py-2 px-3 text-center rounded-xl text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 transition">
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
                    <div class="col-span-full bg-white rounded-3xl p-12 text-center text-slate-500 border border-slate-200 shadow-sm">
                        Belum ada Full Test yang ditambahkan.
                    </div>
                    @endforelse
                </div>

                <!-- Topical Drills -->
                @if($drills->isNotEmpty())
                <div class="mt-12">
                    <div class="mb-6">
                        <h2 class="text-xl font-extrabold text-slate-900">Latihan Topikal (Reading &amp; Writing)</h2>
                        <p class="text-sm text-slate-500 mt-0.5">Latihan satu-modul. Skor dalam persen (0&ndash;100%), <strong>tidak</strong> masuk ke estimasi 400&ndash;1600.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($drills as $drill)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Latihan {{ $drill->meeting_number }}</span>
                                    @if($drill->completed)
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">{{ round($drill->user_score) }}%</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm leading-snug mb-1 line-clamp-2">{{ $drill->title }}</h4>
                                <p class="text-xs text-slate-400">{{ $drill->questions_count }} soal</p>
                            </div>
                            @if(!$drill->is_locked || Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                <a href="{{ route('mock-test.sat.practice-test', $drill->meeting_number) }}" class="mt-3 block w-full py-2 px-3 text-center rounded-lg text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition">
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

    @if(Auth::user()->isAdmin())
    <!-- Add Practice Test Modal (Admin) -->
    <div id="addPracticeTestModal" class="fixed inset-0 bg-black/50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-lg shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Tambah SAT Full Practice Test</h3>
                    <button onclick="document.getElementById('addPracticeTestModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('mock-test.sat.reading-writing.meeting.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Set</label>
                            <input type="number" name="meeting_number" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required placeholder="misal: 11">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Practice Test</label>
                            <input type="text" name="title" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required placeholder="misal: Reading and Writing — Practice Test 11">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Sub Judul (Opsional)</label>
                            <input type="text" name="subtitle" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Full Digital SAT Mockup (27 Soal • 32 Menit)">
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
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition">Simpan Practice Test</button>
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
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition">Perbarui Practice Test</button>
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
