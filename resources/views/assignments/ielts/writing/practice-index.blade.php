@extends('layouts.admin')

@php
    $taskParam = $task ?? request('task'); // null | '1' | '2'
    $typeParam = $type ?? request('type'); // null | 'line' | 'bar' | ...
    $typeLabels = [
        'line'                    => 'Line Chart',
        'bar'                     => 'Bar Chart',
        'pie'                     => 'Pie Chart',
        'table'                   => 'Table',
        'mixed'                   => 'Mixed Chart',
        'flowchart'               => 'Flowchart',
        'mapping'                 => 'Mapping',
        'advantages_disadvantages'=> 'Advantages & Disadvantages',
        'opinion'                 => 'Positive or Negative',
        'problem_solution'        => 'Problem & Solution',
        'discussion'              => 'Two-Part Question',
        'agree_disagree'          => 'Agree or Disagree',
    ];
    $currentTypeLabel = $typeParam ? ($typeLabels[$typeParam] ?? ucfirst($typeParam)) : '';
@endphp

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent">IELTS Writing Practice</h1>
                    <p class="text-gray-600 mt-1">
                        @if(!$taskParam)
                            Focused exercises to improve your writing skills.
                        @elseif($taskParam == 1 && !$typeParam)
                            Task 1 — Select a chart type to practice.
                        @elseif($taskParam == 1 && $typeParam)
                            Task 1 &rsaquo; {{ $currentTypeLabel }}                        @elseif($taskParam == 2 && !$typeParam)
                            Task 2 — Pilih jenis soal essay
                        @elseif($taskParam == 2 && $typeParam)
                            Task 2 › {{ $currentTypeLabel }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Back button: context-aware --}}
            @if(!$taskParam)
                <a href="{{ route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to IELTS
                </a>
            @elseif($taskParam == 2 && !$typeParam)
                <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Task Selection
                </a>
            @elseif($taskParam == 2 && $typeParam)
                <a href="{{ route('assignments.ielts-academic.writing.practice.index', ['task' => 2]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Essay Types
                </a>
            @elseif($taskParam == 1 && !$typeParam)
                <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Task Selection
                </a>
            @elseif($taskParam == 1 && $typeParam)
                <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}?task=1" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Chart Types
                </a>
            @endif
        </div>
    </div>

    {{-- ── LEVEL 0: Task 1 / Task 2 Selector ── --}}
    @if(!$taskParam)
    <div class="flex flex-col items-center justify-center py-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-2 tracking-tight">Pilih Task</h2>
        <p class="text-gray-400 text-sm mb-10">Pilih jenis tugas yang ingin kamu latih</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-2xl">

            {{-- Task 1 --}}
            <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}?task=1"
               class="group relative overflow-hidden rounded-3xl shadow-lg border-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                {{-- gradient bg --}}
                <div class="absolute inset-0 bg-gradient-to-br from-teal-400 to-emerald-600"></div>
                {{-- decorative circles --}}
                <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="relative z-10 p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-white/70 mb-1">Academic Report</span>
                    <h3 class="text-4xl font-black text-white mb-3">Task 1</h3>
                    <p class="text-white/80 text-sm leading-relaxed">Charts, graphs, tables, flowcharts &amp; maps — ~150 words</p>
                    <div class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-white text-teal-700 font-bold text-sm rounded-full group-hover:bg-teal-50 transition-colors">
                        @if(!empty($isClassEnded) && Auth::user()->isStudent())
                            <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Kerjakan Ulang ↺</span>
                        @else
                            Start Practice
                        @endif
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>

            {{-- Task 2 --}}
            <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}?task=2"
               class="group relative overflow-hidden rounded-3xl shadow-lg border-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-rose-600"></div>
                <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="relative z-10 p-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-white/70 mb-1">Essay Writing</span>
                    <h3 class="text-4xl font-black text-white mb-3">Task 2</h3>
                    <p class="text-white/80 text-sm leading-relaxed">Point of view, argument or problem — ~250 words</p>
                    <div class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-white text-orange-700 font-bold text-sm rounded-full group-hover:bg-orange-50 transition-colors">
                        @if(!empty($isClassEnded) && Auth::user()->isStudent())
                            <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Kerjakan Ulang ↺</span>
                        @else
                            Start Practice
                        @endif
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>

        </div>

        <div class="w-full max-w-2xl mt-6">
            <a href="{{ route('assignments.ielts-academic.writing.grammar-practice') }}"
               class="group relative overflow-hidden rounded-3xl shadow-lg border-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl block">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-700"></div>
                <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="relative z-10 p-6 flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest text-white/70 mb-1">Fundamental Skill</span>
                    <h3 class="text-3xl font-black text-white mb-2">Practice IELTS Grammar</h3>
                    <p class="text-white/80 text-sm leading-relaxed">Improve your grammatical range and accuracy for IELTS Writing.</p>
                    <div class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-white text-indigo-700 font-bold text-sm rounded-full group-hover:bg-indigo-50 transition-colors">
                        Start Practice
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endif

    {{-- ── LEVEL 1b (Task 2): Essay Type Selector ── --}}
    @if($taskParam == 2 && !$typeParam)
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pilih Jenis Essay</h2>
        <p class="text-gray-400 text-sm mb-8">Setiap jenis memiliki struktur argumen yang berbeda</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <a href="?task=2&type=advantages_disadvantages"
               class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-0">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-600"></div>
                <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-white/10 rounded-full"></div>
                <div class="relative z-10 p-6">
                    <h3 class="text-xl font-bold text-white mb-1">Advantages &amp; Disadvantages</h3>
                    <p class="text-white/75 text-sm">Timbang sisi positif dan negatif suatu isu.</p>
                    <div class="mt-4 inline-flex items-center gap-1 text-white/90 text-xs font-semibold">
                        Mulai <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>

            <a href="?task=2&type=opinion"
               class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-0">
                <div class="absolute inset-0 bg-gradient-to-br from-violet-400 to-purple-600"></div>
                <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-white/10 rounded-full"></div>
                <div class="relative z-10 p-6">
                    <h3 class="text-xl font-bold text-white mb-1">Positive or Negative</h3>
                    <p class="text-white/75 text-sm">Nilailah apakah suatu perkembangan bersifat positif atau negatif.</p>
                    <div class="mt-4 inline-flex items-center gap-1 text-white/90 text-xs font-semibold">
                        Mulai <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>

            <a href="?task=2&type=problem_solution"
               class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-0">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-400 to-orange-500"></div>
                <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-white/10 rounded-full"></div>
                <div class="relative z-10 p-6">
                    <h3 class="text-xl font-bold text-white mb-1">Problem &amp; Solution</h3>
                    <p class="text-white/75 text-sm">Identifikasi masalah dan tawarkan solusi yang relevan.</p>
                    <div class="mt-4 inline-flex items-center gap-1 text-white/90 text-xs font-semibold">
                        Mulai <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>

            <a href="?task=2&type=discussion"
               class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-0">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600"></div>
                <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-white/10 rounded-full"></div>
                <div class="relative z-10 p-6">
                    <h3 class="text-xl font-bold text-white mb-1">Two-Part Question</h3>
                    <p class="text-white/75 text-sm">Jawab dua pertanyaan berbeda mengenai satu topik.</p>
                    <div class="mt-4 inline-flex items-center gap-1 text-white/90 text-xs font-semibold">
                        Mulai <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>

            <a href="?task=2&type=agree_disagree"
               class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-0">
                <div class="absolute inset-0 bg-gradient-to-br from-rose-400 to-pink-600"></div>
                <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-white/10 rounded-full"></div>
                <div class="relative z-10 p-6">
                    <h3 class="text-xl font-bold text-white mb-1">Agree or Disagree</h3>
                    <p class="text-white/75 text-sm">Nyatakan dan dukung pendapatmu terhadap suatu pernyataan.</p>
                    <div class="mt-4 inline-flex items-center gap-1 text-white/90 text-xs font-semibold">
                        Mulai <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>

        </div>
    </div>
    @endif

    {{-- ── LEVEL 2b (Task 2 + type): Practice items filtered by essay type ── --}}
    @if($taskParam == 2 && $typeParam)
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $currentTypeLabel }} — Practice</h2>
            <span class="text-gray-500 font-medium">{{ count($task2Meetings) }} soal tersedia</span>
        </div>
        @if(count($task2Meetings) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($task2Meetings as $m)
                <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 2, 'id' => $m->id]) }}"
                   class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 group">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="font-bold text-gray-800 flex-1 group-hover:text-orange-600 transition">{{ $m->title }}</h3>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $m->prompt }}</p>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end">
                        <span class="text-xs font-semibold text-orange-500 group-hover:text-orange-700 transition">Open →</span>
                    </div>
                </a>
            @endforeach
        </div>
        @else
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-10 text-center">
            <p class="text-gray-600 mb-2">Belum ada soal untuk tipe ini.</p>
            <p class="text-sm text-gray-400">Konten akan segera ditambahkan.</p>
        </div>
        @endif
    </div>
    @endif

    {{-- ── LEVEL 1 (Task 1): Chart Type Selector ── --}}
    @if($taskParam == 1 && !$typeParam)
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Select Practice Type</h2>
        @php
            $practiceTypes = [
                ['slug' => 'line', 'title' => 'Line Chart', 'desc' => 'Analyze trends over time.', 'accent' => 'blue', 'icon' => 'M4 19h16M4 14h4m3 0h9M4 9h7m3 0h6'],
                ['slug' => 'bar', 'title' => 'Bar Chart', 'desc' => 'Compare categories.', 'accent' => 'emerald', 'icon' => 'M5 20V10m7 10V4m7 16v-7'],
                ['slug' => 'pie', 'title' => 'Pie Chart', 'desc' => 'Understand proportions.', 'accent' => 'violet', 'icon' => 'M11 3v9h9A9 9 0 1 1 11 3Z'],
                ['slug' => 'table', 'title' => 'Table', 'desc' => 'Interpret tabular data.', 'accent' => 'amber', 'icon' => 'M4 7h16M4 12h16M4 17h16M9 4v16M15 4v16'],
                ['slug' => 'mixed', 'title' => 'Mixed Chart', 'desc' => 'Combine chart types.', 'accent' => 'pink', 'icon' => 'M4 18h4v-6H4v6Zm6 0h4V8h-4v10Zm6 0h4V4h-4v14Z'],
                ['slug' => 'flowchart', 'title' => 'Flowchart', 'desc' => 'Describe processes.', 'accent' => 'indigo', 'icon' => 'M12 3v4m0 0H8m4 0h4m-4 4v4m0 0H8m4 0h4m-4 4v2'],
                ['slug' => 'mapping', 'title' => 'Mapping', 'desc' => 'Analyze spatial changes.', 'accent' => 'rose', 'icon' => 'M9 20 4 18V6l5 2 6-2 5 2v12l-5-2-6 2Z'],
            ];

            $accentMap = [
                'blue'    => ['style' => 'background: linear-gradient(135deg, #38bdf8, #2563eb)'],
                'emerald' => ['style' => 'background: linear-gradient(135deg, #34d399, #0d9488)'],
                'violet'  => ['style' => 'background: linear-gradient(135deg, #a78bfa, #9333ea)'],
                'amber'   => ['style' => 'background: linear-gradient(135deg, #fbbf24, #f97316)'],
                'pink'    => ['style' => 'background: linear-gradient(135deg, #f472b6, #c026d3)'],
                'indigo'  => ['style' => 'background: linear-gradient(135deg, #818cf8, #2563eb)'],
                'rose'    => ['style' => 'background: linear-gradient(135deg, #fb7185, #dc2626)'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($practiceTypes as $type)
                @php $accent = $accentMap[$type['accent']]; @endphp
                <a href="?task=1&type={{ $type['slug'] }}" class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-0">
                    <div class="absolute inset-0" style="{{ $accent['style'] }}"></div>
                    <div class="absolute -bottom-8 -right-8 w-28 h-28 bg-white/10 rounded-full"></div>
                    <div class="absolute -top-5 -left-5 w-20 h-20 bg-white/10 rounded-full"></div>

                    <div class="relative z-10 p-6 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-xl bg-white/25 backdrop-blur flex items-center justify-center border border-white/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"></path>
                                </svg>
                            </span>
                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-white/20 text-white/90">20 Practices</span>
                        </div>

                        <h3 class="font-bold text-xl text-white mb-1.5">{{ $type['title'] }}</h3>
                        <p class="text-white/80 text-sm flex-1">{{ $type['desc'] }}</p>

                        <div class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-white/95 text-gray-800 text-sm font-bold rounded-full w-fit group-hover:bg-white transition-colors">
                            Mulai
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── LEVEL 2 (Task 1 + type): Practice Items ── --}}
    @if($taskParam == 1 && $typeParam)
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $currentTypeLabel }} — Practice Items</h2>
            <span class="text-gray-500 font-medium">{{ count($items) }} practices available</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $item)
                <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => $item->id]) }}" class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 group">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="font-bold text-gray-800 flex-1 group-hover:text-teal-600 transition">{{ $item->title }}</h3>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $item->prompt }}</p>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end">
                        @if(!empty($isClassEnded) && Auth::user()->isStudent())
                            <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Kerjakan Ulang ↺</span>
                        @else
                            <span class="text-xs font-semibold text-teal-500 group-hover:text-teal-700 transition">Start Practice →</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-teal-50 border border-teal-200 rounded-lg p-8 text-center">
                    <p class="text-gray-600 mb-2">No practice items available for this type yet.</p>
                    <p class="text-sm text-gray-500">Check back soon for more content.</p>
                </div>
            @endforelse
        </div>
    </div>
    @endif

</div>
@endsection
