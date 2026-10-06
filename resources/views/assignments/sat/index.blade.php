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
            <div class="max-w-4xl mx-auto">
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
                        <a href="{{ route('assignments.index') }}"
                            class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>

                <!-- Section Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Reading & Writing -->
                    <a href="{{ route('assignments.sat.reading-writing') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                        <div class="h-32 bg-gradient-to-br from-blue-500 to-indigo-600 relative overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-indigo-700 shadow-sm">Curriculum &amp; Guide</span>
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
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Pemahaman bacaan, tata bahasa standar, dan 4 domain kemampuan bahasa Inggris akademik.</p>
                            <div class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
                                Buka Materi &amp; Panduan
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
                                <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-teal-700 shadow-sm">2 Modules</span>
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
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Aljabar, geometri, fungsi lanjutan, dan analisis data.</p>
                            <div class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
                                Start Learning
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>
                    </a>

                </div>

                <!-- Practice Tests Section -->
                <div class="mt-12" id="practice-tests">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                <span class="w-2.5 h-6 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full inline-block"></span>
                                SAT Full Practice Tests
                            </h2>
                            <p class="text-sm text-gray-500 mt-0.5">Simulasi ujian Digital SAT adaptif penuh sesuai format Princeton Review 2024.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(Auth::user()->isAdmin())
                            <button onclick="document.getElementById('addPracticeTestModal').classList.remove('hidden')" class="px-3.5 py-1.5 bg-indigo-600 text-white rounded-xl shadow-xs hover:bg-indigo-700 font-bold text-xs transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Practice Test
                            </button>
                            @endif
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 self-start sm:self-auto">
                                Adaptive Full-Length
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @forelse($practiceSets ?? [] as $set)
                        @php
                            $colors = [
                                1 => ['from' => 'from-blue-600', 'to' => 'to-indigo-600', 'text' => 'text-indigo-700', 'bg' => 'bg-indigo-50', 'btn' => 'bg-indigo-600 hover:bg-indigo-700'],
                                2 => ['from' => 'from-purple-600', 'to' => 'to-violet-700', 'text' => 'text-purple-700', 'bg' => 'bg-purple-50', 'btn' => 'bg-purple-600 hover:bg-purple-700'],
                                3 => ['from' => 'from-teal-600', 'to' => 'to-emerald-600', 'text' => 'text-teal-700', 'bg' => 'bg-teal-50', 'btn' => 'bg-teal-600 hover:bg-teal-700'],
                                4 => ['from' => 'from-amber-500', 'to' => 'to-orange-600', 'text' => 'text-amber-700', 'bg' => 'bg-amber-50', 'btn' => 'bg-amber-600 hover:bg-amber-700'],
                            ];
                            $c = $colors[$set->meeting_number] ?? $colors[1];
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col group hover:-translate-y-1">
                            <div class="h-28 bg-gradient-to-br {{ $c['from'] }} {{ $c['to'] }} p-4 flex flex-col justify-between text-white relative">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/20 backdrop-blur-sm border border-white/20">
                                        Practice Set {{ $set->meeting_number }}
                                    </span>

                                    <div class="flex items-center gap-1.5">
                                        @if($set->completed)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-400 text-gray-900 shadow-xs">
                                                ✓ Skor: {{ round($set->user_score) }}
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-white/20 text-white">
                                                {{ $set->questions_count }} Soal
                                            </span>
                                        @endif

                                        @if(Auth::user()->isAdmin())
                                        <!-- Lock/Unlock Toggle -->
                                        <form action="{{ route('assignments.sat.reading-writing.meeting.toggle-lock', $set->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-1 rounded-lg transition {{ $set->is_locked ? 'bg-red-500 text-white' : 'bg-white/20 text-white hover:bg-white/30' }}" title="{{ $set->is_locked ? 'Buka Kunci' : 'Kunci Practice Test' }}">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($set->is_locked)
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                                    @endif
                                                </svg>
                                            </button>
                                        </form>

                                        <!-- Edit Button -->
                                        <button onclick='openEditPracticeTestModal(@json($set))' class="p-1 rounded-lg bg-white/20 text-white hover:bg-white/30 transition" title="Edit Practice Test">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('assignments.sat.reading-writing.meeting.destroy', $set->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus practice test ini beserta semua soalnya?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 rounded-lg bg-white/20 text-red-200 hover:text-white hover:bg-red-500 transition" title="Hapus Practice Test">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                                <h3 class="text-base font-bold text-white drop-shadow-sm line-clamp-1" title="{{ $set->title }}">{{ $set->title }}</h3>
                            </div>
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    @if($set->subtitle)
                                        <p class="text-[11px] font-semibold {{ $c['text'] }} mb-1 line-clamp-1">{{ $set->subtitle }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4">
                                        {{ $set->description }}
                                    </p>
                                </div>
                                <div class="pt-3 border-t border-gray-100">
                                    @if(!$set->is_locked || Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                        <a href="{{ route('assignments.sat.reading-writing.meeting', $set->meeting_number) }}" class="block w-full py-2.5 px-3 text-center rounded-xl text-xs font-bold text-white {{ $c['btn'] }} transition shadow-sm">
                                            {{ $set->completed ? 'Buka Latihan' : 'Mulai Latihan' }} &rarr;
                                        </a>
                                    @else
                                        <button disabled class="block w-full py-2 px-3 text-center rounded-xl text-xs font-bold text-gray-400 bg-gray-100 cursor-not-allowed">
                                            🔒 Terkunci
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full bg-white rounded-2xl p-8 text-center text-gray-500 border border-gray-100">
                            Belum ada paket practice test yang ditambahkan.
                        </div>
                        @endforelse
                    </div>
                </div>
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
                            <textarea name="description" rows="3" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Tuliskan gambaran latihan ini..."></textarea>
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
