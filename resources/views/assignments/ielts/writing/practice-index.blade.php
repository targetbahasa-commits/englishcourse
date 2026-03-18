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
                <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Task Selection
                </a>
            @elseif($taskParam == 2 && $typeParam)
                <a href="{{ route('assignments.ielts-academic.writing.practice.index', ['task' => 2]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Essay Types
                </a>
            @elseif($taskParam == 1 && !$typeParam)
                <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Task Selection
                </a>
            @elseif($taskParam == 1 && $typeParam)
                <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}?task=1" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
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
                        Start Practice
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
                   class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 border-l-4 border-orange-400 hover:border-orange-500 group">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="font-bold text-gray-800 flex-1 group-hover:text-orange-600 transition">{{ $m->title }}</h3>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $m->prompt }}</p>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500 font-medium">Meeting #{{ $m->meeting_number }}</span>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <a href="?task=1&type=line" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group flex flex-col h-full border border-blue-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Line Chart</h3>
                <p class="text-gray-500 text-sm flex-1">Analyze trends over time.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">20 Practices</span>
            </a>

            <a href="?task=1&type=bar" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group flex flex-col h-full border border-emerald-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Bar Chart</h3>
                <p class="text-gray-500 text-sm flex-1">Compare categories.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-emerald-100 text-emerald-600 text-xs font-semibold rounded-full">20 Practices</span>
            </a>

            <a href="?task=1&type=pie" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group flex flex-col h-full border border-purple-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Pie Chart</h3>
                <p class="text-gray-500 text-sm flex-1">Understand proportions.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-purple-100 text-purple-600 text-xs font-semibold rounded-full">20 Practices</span>
            </a>

            <a href="?task=1&type=table" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group flex flex-col h-full border border-orange-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Table</h3>
                <p class="text-gray-500 text-sm flex-1">Interpret tabular data.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full">20 Practices</span>
            </a>

            <a href="?task=1&type=mixed" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group flex flex-col h-full border border-pink-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Mixed Chart</h3>
                <p class="text-gray-500 text-sm flex-1">Combine chart types.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-pink-100 text-pink-600 text-xs font-semibold rounded-full">20 Practices</span>
            </a>

            <a href="?task=1&type=flowchart" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group flex flex-col h-full border border-indigo-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Flowchart</h3>
                <p class="text-gray-500 text-sm flex-1">Describe processes.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-indigo-100 text-indigo-600 text-xs font-semibold rounded-full">20 Practices</span>
            </a>

            <a href="?task=1&type=mapping" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group flex flex-col h-full border border-rose-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Mapping</h3>
                <p class="text-gray-500 text-sm flex-1">Analyze spatial changes.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-rose-100 text-rose-600 text-xs font-semibold rounded-full">20 Practices</span>
            </a>

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
                <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => $item->id]) }}" class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 border-l-4 border-teal-500 hover:border-teal-600 group">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="font-bold text-gray-800 flex-1 group-hover:text-teal-600 transition">{{ $item->title }}</h3>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $item->prompt }}</p>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500 font-medium">Meeting #{{ $item->meeting_number }}</span>
                        <span class="text-xs font-semibold text-teal-500 group-hover:text-teal-700 transition">Start Practice →</span>
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
