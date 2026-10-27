<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $testType === '4skill' ? ($fourSkillPackage->title ?? 'Tes Penempatan 4-Skill') : ($package->title ?? 'Tes Penempatan Grammar for Writing') }} - Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 min-h-screen py-8 px-4">
    <div class="{{ $isAdmin ? 'max-w-4xl' : 'max-w-2xl' }} mx-auto">
        <div class="text-center mb-8">
            <img src="{{ asset('images/brand/icon.png') }}" alt="Target Bahasa" class="w-14 h-14 mx-auto mb-3 rounded-2xl shadow-sm">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                {{ $testType === '4skill' ? ($fourSkillPackage->title ?? 'Tes Penempatan 4-Skill') : ($package->title ?? 'Tes Penempatan Grammar for Writing') }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                @if($testType === '4skill')
                    Uji kompetensi terpadu kemampuan Reading, Listening, Writing, dan Speaking.
                @else
                    Sebelum mulai belajar, kerjakan tes singkat ini agar kami bisa menyesuaikan tingkat materi dan kosakatamu.
                @endif
            </p>
        </div>

        @if(isset($errors) && $errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                <ul class="list-disc list-inside text-sm">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($isAdmin)
            <!-- PANEL KENDALI ADMIN (MEMILIH PLACEMENT TEST & MODUL SOAL) -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50/70 border border-amber-200/90 rounded-2xl p-5 sm:p-6 mb-8 shadow-sm space-y-5">
                <!-- Bar Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3.5 border-b border-amber-200/80">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-600 text-white shadow-xs">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="text-sm font-extrabold text-amber-900 tracking-wide uppercase">Kendali Admin &bull; Pemeriksaan Soal &amp; Mode Tes</h2>
                            <p class="text-xs text-amber-700">Pilih placement test dan modul soal mana yang ingin diperiksa secara mendetail.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-xs">
                        <a href="{{ route('admin.self-study-placement.index') }}" class="font-bold text-amber-800 hover:text-amber-950 underline flex items-center gap-1">
                            <span>Riwayat Hasil Siswa &rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Kontrol Grid: 1. Pilih Placement Test & 2. Pilih Modul Soal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- 1. Pilihan Placement Test -->
                    <div class="bg-white/90 rounded-xl p-4 border border-amber-200 shadow-2xs flex flex-col justify-between">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    1. Pilih Placement Test
                                </span>
                                @if($testType === 'grammar' && $package && (string)$package->id === (string)$gatePackageId)
                                    <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        Aktif untuk Siswa
                                    </span>
                                @endif
                            </label>

                            <form id="placement-picker-form" method="GET" action="{{ route('self-study-classes.placement.show') }}">
                                <select name="package_id" 
                                        onchange="if(this.value === '4skill'){ window.location.href = '{{ route('self-study-classes.placement.show', ['test_type' => '4skill']) }}'; } else { document.getElementById('placement-picker-form').submit(); }"
                                        class="block w-full border border-slate-300 rounded-xl px-3.5 py-2 text-xs sm:text-sm font-medium focus:ring-amber-500 focus:border-amber-500 bg-white">
                                    <optgroup label="Grammar for Writing Placement Packages">
                                        @foreach($allGrammarPackages as $pkg)
                                            <option value="{{ $pkg->id }}" {{ ($testType === 'grammar' && $package && $package->id == $pkg->id) ? 'selected' : '' }}>
                                                {{ $pkg->title }} ({{ $pkg->questions_count ?? $pkg->questions()->count() }} Soal) {{ (string)$pkg->id === (string)$gatePackageId ? '— [AKTIF SISWA]' : '' }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    @if($allFourSkillPackages->isNotEmpty())
                                        <optgroup label="Placement Test Lainnya">
                                            <option value="4skill" {{ $testType === '4skill' ? 'selected' : '' }}>
                                                Tes Penempatan 4-Skill (Reading, Listening, Writing, Speaking)
                                            </option>
                                        </optgroup>
                                    @endif
                                </select>
                            </form>
                        </div>

                        <!-- Tombol Jadikan Aktif untuk Siswa -->
                        @if($testType === 'grammar' && $package && (string)$package->id !== (string)$gatePackageId)
                            <form method="POST" action="{{ route('admin.self-study-placement.set-gate-package') }}" class="mt-3">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ $package->id }}">
                                <button type="submit" class="w-full py-1.5 px-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Jadikan Paket Ini Tes Aktif Siswa</span>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- 2. Pilihan Modul Soal yang Ingin Diperiksa -->
                    <div class="bg-white/90 rounded-xl p-4 border border-amber-200 shadow-2xs">
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            <span>2. Modul Soal yang Ingin Diperiksa</span>
                        </label>

                        @if($testType === 'grammar')
                            <form id="module-filter-form" method="GET" action="{{ route('self-study-classes.placement.show') }}">
                                <input type="hidden" name="package_id" value="{{ $package->id ?? '' }}">
                                <select name="module"
                                        onchange="document.getElementById('module-filter-form').submit()"
                                        class="block w-full border border-slate-300 rounded-xl px-3.5 py-2 text-xs sm:text-sm font-medium focus:ring-amber-500 focus:border-amber-500 bg-white">
                                    <option value="all" {{ $selectedModule === 'all' ? 'selected' : '' }}>
                                        Semua Modul ({{ array_sum($moduleCounts) }} Soal)
                                    </option>
                                    <option value="A1" {{ $selectedModule === 'A1' ? 'selected' : '' }}>
                                        Modul A1 &bull; Dasar / Beginner ({{ $moduleCounts['A1'] ?? 0 }} Soal)
                                    </option>
                                    <option value="A2" {{ $selectedModule === 'A2' ? 'selected' : '' }}>
                                        Modul A2 &bull; Dasar Lanjutan / Elementary ({{ $moduleCounts['A2'] ?? 0 }} Soal)
                                    </option>
                                    <option value="B1" {{ $selectedModule === 'B1' ? 'selected' : '' }}>
                                        Modul B1 &bull; Menengah / Intermediate ({{ $moduleCounts['B1'] ?? 0 }} Soal)
                                    </option>
                                    <option value="B2" {{ $selectedModule === 'B2' ? 'selected' : '' }}>
                                        Modul B2 &bull; Menengah Atas / Upper-Intermediate ({{ $moduleCounts['B2'] ?? 0 }} Soal)
                                    </option>
                                    <option value="C1" {{ $selectedModule === 'C1' ? 'selected' : '' }}>
                                        Modul C1 &bull; Tingkat Mahir / Advanced ({{ $moduleCounts['C1'] ?? 0 }} Soal)
                                    </option>
                                </select>
                            </form>

                            <!-- Quick Module Pill Tabs -->
                            <div class="flex flex-wrap gap-1.5 mt-2.5">
                                <a href="{{ route('self-study-classes.placement.show', ['package_id' => $package->id ?? '', 'module' => 'all']) }}"
                                   class="px-2 py-0.5 rounded-md text-[11px] font-bold transition {{ $selectedModule === 'all' ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-900 hover:bg-amber-200' }}">
                                    Semua ({{ array_sum($moduleCounts) }})
                                </a>
                                @foreach(['A1' => 'A1', 'A2' => 'A2', 'B1' => 'B1', 'B2' => 'B2', 'C1' => 'C1'] as $lvl => $lbl)
                                    @if(!empty($moduleCounts[$lvl]))
                                        <a href="{{ route('self-study-classes.placement.show', ['package_id' => $package->id ?? '', 'module' => $lvl]) }}"
                                           class="px-2 py-0.5 rounded-md text-[11px] font-bold transition {{ $selectedModule === $lvl ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-900 hover:bg-amber-200' }}">
                                            Modul {{ $lbl }} ({{ $moduleCounts[$lvl] }})
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <!-- 4-Skill Module Selector -->
                            <div class="space-y-2">
                                <div class="flex flex-wrap gap-1.5">
                                    <a href="{{ route('self-study-classes.placement.show', ['test_type' => '4skill', 'module' => 'all']) }}"
                                       class="px-2.5 py-1 rounded-md text-xs font-bold transition {{ $selectedModule === 'all' ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-900 hover:bg-amber-200' }}">
                                        Semua Skill
                                    </a>
                                    <a href="{{ route('self-study-classes.placement.show', ['test_type' => '4skill', 'module' => 'reading']) }}"
                                       class="px-2.5 py-1 rounded-md text-xs font-bold transition {{ $selectedModule === 'reading' ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-900 hover:bg-amber-200' }}">
                                        Reading ({{ $moduleCounts['reading'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('self-study-classes.placement.show', ['test_type' => '4skill', 'module' => 'listening']) }}"
                                       class="px-2.5 py-1 rounded-md text-xs font-bold transition {{ $selectedModule === 'listening' ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-900 hover:bg-amber-200' }}">
                                        Listening ({{ $moduleCounts['listening'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('self-study-classes.placement.show', ['test_type' => '4skill', 'module' => 'writing']) }}"
                                       class="px-2.5 py-1 rounded-md text-xs font-bold transition {{ $selectedModule === 'writing' ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-900 hover:bg-amber-200' }}">
                                        Writing ({{ $moduleCounts['writing'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('self-study-classes.placement.show', ['test_type' => '4skill', 'module' => 'speaking']) }}"
                                       class="px-2.5 py-1 rounded-md text-xs font-bold transition {{ $selectedModule === 'speaking' ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-900 hover:bg-amber-200' }}">
                                        Speaking ({{ $moduleCounts['speaking'] ?? 0 }})
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Bagian Pintasan: Periksa Modul Materi Kursus (Course Learning Modules) -->
                <div class="bg-amber-100/70 rounded-xl p-3.5 border border-amber-200/90 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2 text-amber-950">
                        <span class="font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Periksa Modul Latihan Kursus:
                        </span>
                        <span class="text-amber-800 hidden sm:inline">&bull; Langsung buka dan periksa materi/latihan di Course Player:</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-1.5">
                        @foreach($courseModules as $cm)
                            <a href="{{ $cm['route'] }}" target="_blank"
                               title="{{ $cm['title'] }}"
                               class="px-2.5 py-1 bg-white hover:bg-amber-50 text-amber-900 border border-amber-300 rounded-lg font-bold text-[11px] transition flex items-center gap-1 shadow-2xs">
                                <span>{{ $cm['code'] }}</span>
                                <svg class="w-3 h-3 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Bagian Form Override Mode Siswa (Collapsible) -->
                <div x-data="{ open: false }" class="border-t border-amber-200/80 pt-3">
                    <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left text-xs font-bold text-amber-900 hover:text-amber-950 cursor-pointer">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Atur Mode Siswa Secara Manual (Bypass Tes untuk Siswa Tertentu)</span>
                        </span>
                        <span class="text-amber-700 text-[11px]" x-text="open ? '▲ Tutup Form' : '▼ Buka Form'"></span>
                    </button>

                    <div x-show="open" x-cloak class="mt-3 pt-3 border-t border-amber-200/60">
                        <form method="POST" action="{{ route('admin.self-study-placement.override') }}" class="flex flex-col sm:flex-row gap-3 sm:items-end">
                            @csrf
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-amber-800 mb-1">Pilih Siswa</label>
                                <select name="user_id" required class="block w-full border border-amber-200 rounded-xl px-4 py-2 text-xs sm:text-sm focus:ring-amber-500 focus:border-amber-500 bg-white">
                                    <option value="">Pilih siswa...</option>
                                    @foreach($students as $s)
                                        <option value="{{ $s->id }}">
                                            {{ $s->name }} ({{ $s->email }})@if($s->self_study_grammar_mode_override) &mdash; saat ini: Mode {{ $s->self_study_grammar_mode_override }} @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-amber-800 mb-1">Tetapkan Mode</label>
                                <select name="mode" class="block w-full border border-amber-200 rounded-xl px-4 py-2 text-xs sm:text-sm focus:ring-amber-500 focus:border-amber-500 bg-white">
                                    <option value="">Otomatis (ikuti hasil tes)</option>
                                    <option value="A">Mode A &mdash; A1-A2 bertahap ke B1-B2</option>
                                    <option value="B">Mode B &mdash; B1-C2 lanjutan</option>
                                </select>
                            </div>
                            <button type="submit" class="px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs sm:text-sm font-bold rounded-xl transition-colors shadow-sm cursor-pointer">
                                Simpan Mode
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if($testType === 'grammar')
            <!-- TAMPILAN SOAL GRAMMAR PLACEMENT TEST -->
            @if($questions->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center text-gray-400">
                    Tidak ada soal yang ditemukan untuk modul ini. Silakan pilih modul lain atau periksa paket soal.
                </div>
            @else
                <form method="POST" action="{{ route('self-study-classes.placement.submit') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id ?? '' }}">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                        <!-- Bar Judul List Soal -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-100 pb-3">
                            <div class="flex items-center gap-2">
                                <h2 class="text-sm font-extrabold text-gray-800 uppercase tracking-wide">
                                    Daftar Soal
                                </h2>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                    {{ $questions->count() }} Soal Ditampilkan
                                </span>
                                @if($selectedModule !== 'all')
                                    <span class="px-2 py-0.5 rounded-md text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        Modul {{ $selectedModule }}
                                    </span>
                                @endif
                            </div>

                            @if($isAdmin)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Kunci Jawaban Ditampilkan</span>
                                    </span>
                                    @if($package)
                                        <a href="{{ route('admin.grammar-placement.questions.index', $package) }}" target="_blank" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                            <span>Kelola Soal</span>
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Daftar Soal -->
                        @foreach($questions as $i => $q)
                            <div class="pb-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <div class="flex items-start justify-between gap-3 mb-2.5">
                                    <p class="font-semibold text-gray-900 text-sm sm:text-base leading-relaxed">
                                        <span class="font-bold text-blue-600">{{ $i + 1 }}.</span> {{ $q->question_text }}
                                    </p>
                                    @if(!empty($q->cefr_level))
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold tracking-wider uppercase shrink-0 
                                            {{ in_array($q->cefr_level, ['A1', 'A2']) ? 'bg-blue-100 text-blue-800' : (in_array($q->cefr_level, ['B1', 'B2']) ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800') }}">
                                            Modul {{ $q->cefr_level }}
                                        </span>
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    @foreach(['a' => $q->option_a, 'b' => $q->option_b, 'c' => $q->option_c, 'd' => $q->option_d] as $letter => $optionText)
                                        @php
                                            $isCorrect = $isAdmin && (strtolower($letter) === strtolower($q->correct_option));
                                        @endphp
                                        <label class="flex items-start justify-between gap-3 p-3 border rounded-xl transition-colors cursor-pointer 
                                            {{ $isCorrect ? 'border-emerald-500 bg-emerald-50/90 shadow-2xs' : 'border-gray-200 hover:bg-gray-50' }}">
                                            <div class="flex items-start gap-3">
                                                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $letter }}" {{ $isCorrect ? 'checked' : '' }} class="mt-0.5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <span class="text-sm {{ $isCorrect ? 'text-emerald-950 font-bold' : 'text-gray-700' }}">
                                                    <span class="font-semibold uppercase mr-1">{{ $letter }}.</span>{{ $optionText }}
                                                </span>
                                            </div>
                                            @if($isCorrect)
                                                <span class="inline-flex items-center gap-1 text-[11px] font-extrabold text-emerald-800 bg-emerald-200/80 px-2 py-0.5 rounded-md shrink-0">
                                                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>KUNCI JAWABAN</span>
                                                </span>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-sm cursor-pointer">
                        {{ $isAdmin ? 'Simulasi Submit & Lihat Hasil' : 'Selesai & Lihat Hasil' }}
                    </button>
                </form>
            @endif

        @elseif($testType === '4skill' && $fourSkillPackage)
            <!-- TAMPILAN PEMERIKSAAN TES PENEMPATAN 4-SKILL -->
            <div class="space-y-6">
                <!-- READING SECTION -->
                @if(in_array($selectedModule, ['all', 'reading']) && $fourSkillPackage->readingPassages->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 font-extrabold text-xs">MODUL READING</span>
                                <span>{{ $fourSkillPackage->readingPassages->first()->title ?? 'Reading Comprehension' }}</span>
                            </h3>
                            <span class="text-xs text-gray-500 font-medium">{{ $fourSkillPackage->readingPassages->first()->questions->count() }} Soal</span>
                        </div>

                        <!-- Passage text -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm leading-relaxed text-slate-800 max-h-64 overflow-y-auto whitespace-pre-line">
                            {{ $fourSkillPackage->readingPassages->first()->passage_text }}
                        </div>

                        <!-- Questions -->
                        <div class="space-y-4 pt-2">
                            @foreach($fourSkillPackage->readingPassages->first()->questions as $rqIdx => $rq)
                                <div class="p-4 rounded-xl border border-gray-200 space-y-2">
                                    <p class="font-semibold text-gray-900 text-sm">
                                        {{ $rqIdx + 1 }}. {{ $rq->question_text }}
                                    </p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                                        @foreach($rq->options ?? [] as $optIdx => $optVal)
                                            @php
                                                $letter = chr(65 + $optIdx);
                                                $isAns = strtoupper($rq->correct_answer) === $letter;
                                            @endphp
                                            <div class="p-2.5 rounded-lg border text-xs flex items-center justify-between {{ $isAns ? 'border-emerald-500 bg-emerald-50 text-emerald-950 font-bold' : 'border-gray-200 bg-white text-gray-700' }}">
                                                <span><strong class="mr-1">{{ $letter }}.</strong> {{ $optVal }}</span>
                                                @if($isAns)
                                                    <span class="text-[10px] text-emerald-700 bg-emerald-200 px-1.5 py-0.5 rounded font-extrabold">✓ KUNCI</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- LISTENING SECTION -->
                @if(in_array($selectedModule, ['all', 'listening']) && $fourSkillPackage->listeningBanks->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-800 font-extrabold text-xs">MODUL LISTENING</span>
                                <span>{{ $fourSkillPackage->listeningBanks->first()->title ?? 'Listening Audio' }}</span>
                            </h3>
                            <span class="text-xs text-gray-500 font-medium">{{ $fourSkillPackage->listeningBanks->first()->questions->count() }} Soal</span>
                        </div>

                        @if(!empty($fourSkillPackage->listeningBanks->first()->audio_url))
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                <audio controls class="w-full">
                                    <source src="{{ asset($fourSkillPackage->listeningBanks->first()->audio_url) }}" type="audio/mpeg">
                                    Browser tidak mendukung pemutar audio.
                                </audio>
                            </div>
                        @endif

                        <div class="space-y-4 pt-2">
                            @foreach($fourSkillPackage->listeningBanks->first()->questions as $lqIdx => $lq)
                                <div class="p-4 rounded-xl border border-gray-200 space-y-2">
                                    <p class="font-semibold text-gray-900 text-sm">
                                        {{ $lqIdx + 1 }}. {{ $lq->question_text }}
                                    </p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                                        @foreach($lq->options ?? [] as $optIdx => $optVal)
                                            @php
                                                $letter = chr(65 + $optIdx);
                                                $isAns = strtoupper($lq->correct_answer) === $letter;
                                            @endphp
                                            <div class="p-2.5 rounded-lg border text-xs flex items-center justify-between {{ $isAns ? 'border-emerald-500 bg-emerald-50 text-emerald-950 font-bold' : 'border-gray-200 bg-white text-gray-700' }}">
                                                <span><strong class="mr-1">{{ $letter }}.</strong> {{ $optVal }}</span>
                                                @if($isAns)
                                                    <span class="text-[10px] text-emerald-700 bg-emerald-200 px-1.5 py-0.5 rounded font-extrabold">✓ KUNCI</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- WRITING SECTION -->
                @if(in_array($selectedModule, ['all', 'writing']) && $fourSkillPackage->writingPrompts->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-800 font-extrabold text-xs">MODUL WRITING</span>
                                <span>Essay Writing Task</span>
                            </h3>
                            <span class="text-xs text-gray-500 font-medium">{{ $fourSkillPackage->writingPrompts->first()->min_words ?? 150 }} Kata Minimal</span>
                        </div>
                        <div class="p-4 rounded-xl bg-amber-50/60 border border-amber-200 text-sm text-slate-800 leading-relaxed font-medium">
                            {{ $fourSkillPackage->writingPrompts->first()->prompt_text }}
                        </div>
                    </div>
                @endif

                <!-- SPEAKING SECTION -->
                @if(in_array($selectedModule, ['all', 'speaking']) && $fourSkillPackage->speakingPrompts->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md bg-purple-100 text-purple-800 font-extrabold text-xs">MODUL SPEAKING</span>
                                <span>Oral Interview &amp; Response</span>
                            </h3>
                            <span class="text-xs text-gray-500 font-medium">{{ $fourSkillPackage->speakingPrompts->first()->time_limit ?? 120 }} Detik</span>
                        </div>
                        <div class="p-4 rounded-xl bg-purple-50/60 border border-purple-200 text-sm text-slate-800 leading-relaxed font-medium">
                            {{ $fourSkillPackage->speakingPrompts->first()->prompt_text }}
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <p class="text-center text-xs text-gray-400 mt-6">
            Target Bahasa &middot; <a href="https://targetbahasa.com" class="underline hover:text-gray-600">targetbahasa.com</a>
        </p>
    </div>
</body>
</html>
