@extends('layouts.admin')

@section('title', 'IELTS Listening Test Practice')

@section('content')
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 pb-32">

        {{-- Header --}}
        <div class="mb-0 flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Part {{ $set }} - Test {{ $testId }}</h1>
                <p class="text-gray-500 mt-1">IELTS Listening Practice</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('assignments.ielts-academic.listening.practice-index.part', ['set' => $set]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Tests
                </a>
            </div>
        </div>

        {{-- Session Status --}}
        @if(session('success'))
            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- Evaluation Results Box --}}
        @if(session('evaluation_results'))
            @php 
                $eval = session('evaluation_results'); 
                if(!isset($eval['band_score'])) {
                    $scaled = (int) round((($eval['correct_count'] ?? 0) / max(1, $eval['total_questions'] ?? 10)) * 40);
                    if ($scaled >= 39) $eval['band_score'] = '9.0';
                    else if ($scaled >= 37) $eval['band_score'] = '8.5';
                    else if ($scaled >= 35) $eval['band_score'] = '8.0';
                    else if ($scaled >= 32) $eval['band_score'] = '7.5';
                    else if ($scaled >= 30) $eval['band_score'] = '7.0';
                    else if ($scaled >= 26) $eval['band_score'] = '6.5';
                    else if ($scaled >= 23) $eval['band_score'] = '6.0';
                    else if ($scaled >= 18) $eval['band_score'] = '5.5';
                    else if ($scaled >= 16) $eval['band_score'] = '5.0';
                    else if ($scaled >= 13) $eval['band_score'] = '4.5';
                    else if ($scaled >= 10) $eval['band_score'] = '4.0';
                    else if ($scaled >= 6)  $eval['band_score'] = '3.5';
                    else if ($scaled >= 4)  $eval['band_score'] = '3.0';
                    else $eval['band_score'] = '2.5';
                }
            @endphp
            <div class="mt-6 mb-8 bg-white rounded-2xl p-6 sm:p-8 shadow-xl border-2 border-indigo-200">
                
                {{-- Header Summary --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-200 pb-6 mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-3 py-1 bg-white text-indigo-800 rounded-full text-xs font-extrabold uppercase tracking-wider border border-indigo-300">
                                Hasil Penilaian & Evaluasi
                            </span>
                            <span class="text-xs text-gray-500 font-medium">• {{ $eval['submitted_at'] }}</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-black text-gray-900">Part {{ $eval['set'] }} — Test {{ $eval['testId'] }}</h3>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                        {{-- Band Score Badge --}}
                        <div class="bg-gradient-to-br from-purple-700 to-indigo-700 border-2 border-purple-300 px-5 py-3 rounded-2xl text-center min-w-[135px] text-white shadow-md">
                            <span class="text-xs text-purple-200 font-bold block uppercase tracking-wider">Estimasi Band</span>
                            <span class="text-3xl font-black text-amber-300">Band {{ $eval['band_score'] }}</span>
                        </div>

                        {{-- Score Badge --}}
                        <div class="bg-white border-2 border-indigo-200 px-5 py-3 rounded-2xl text-center min-w-[125px] shadow-sm">
                            <span class="text-xs text-indigo-700 font-bold block uppercase tracking-wider">Skor Akhir</span>
                            <span class="text-3xl font-black text-indigo-700">{{ $eval['score_percentage'] }}%</span>
                        </div>
                        {{-- Correct Count Badge --}}
                        <div class="bg-white border-2 border-emerald-200 px-5 py-3 rounded-2xl text-center min-w-[125px] shadow-sm">
                            <span class="text-xs text-emerald-700 font-bold block uppercase tracking-wider">Jawaban Benar</span>
                            <span class="text-3xl font-black text-emerald-700">{{ $eval['correct_count'] }} <span class="text-base text-gray-500 font-normal">/ {{ $eval['total_questions'] }}</span></span>
                        </div>
                    </div>
                </div>

                {{-- Detail Per Soal Grid --}}
                <h4 class="font-bold text-lg text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Evaluasi Detail Jawaban
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($eval['results'] as $qNum => $item)
                        <div class="p-4 rounded-xl border-2 {{ $item['is_correct'] ? 'bg-white border-emerald-300 text-gray-900' : 'bg-red-50 border-red-300 text-gray-900' }} flex items-start justify-between gap-3 shadow-xs">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-sm px-2.5 py-0.5 rounded-md {{ $item['is_correct'] ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white' }}">Soal {{ $qNum }}</span>
                                    <span class="text-xs font-black uppercase tracking-wider {{ $item['is_correct'] ? 'text-emerald-700' : 'text-red-700' }}">
                                        {{ $item['is_correct'] ? '✓ Benar' : '✕ Salah' }}
                                    </span>
                                </div>
                                <div class="text-sm pt-1">
                                    <span class="text-gray-500 text-xs font-bold block">Jawaban Anda:</span>
                                    <span class="font-bold {{ $item['is_correct'] ? 'text-emerald-900' : 'text-red-900' }}">{{ $item['user_answer'] ?: '(Kosong / Tidak diisi)' }}</span>
                                </div>
                                @if(!$item['is_correct'])
                                    <div class="text-sm pt-1 border-t border-red-200 mt-1">
                                        <span class="text-gray-500 text-xs font-bold block">Kunci Jawaban Benar:</span>
                                        <span class="font-extrabold text-emerald-800 bg-white border border-emerald-300 px-2 py-0.5 rounded inline-block mt-0.5">{{ $item['correct_answer'] }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="shrink-0">
                                @if($item['is_correct'])
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-black text-base shadow-sm">✓</div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center font-black text-base shadow-sm">✕</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Key & Explanations Included --}}
                @if(view()->exists('assignments.ielts.listening.answers.part' . $eval['set'] . '.test' . $eval['testId']))
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-bold text-lg text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Kunci Jawaban & Penjelasan Resmi
                        </h4>
                        <div class="bg-white text-gray-800 rounded-xl p-4 border border-gray-200">
                            @include('assignments.ielts.listening.answers.part' . $eval['set'] . '.test' . $eval['testId'])
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-200">
                    <button type="button" onclick="toggleTranscriptDrawer()" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Lihat Transkrip & Terjemahan Pembahasan
                    </button>
                </div>

            </div>
        @endif

        @php
            $section = (isset($meeting) && $meeting && isset($meeting->ieltsSections)) 
                ? $meeting->ieltsSections->where('section_number', $set)->first() 
                : null;
        @endphp

        {{-- Colored Audio Player (Indigo/Purple theme) --}}
        @include('assignments.ielts.listening.partials.audio-player-practice', [
            'section' => $section,
            'meeting' => $meeting ?? null,
            'set'     => $set,
            'testId'  => $testId ?? null,
            'fixed'   => true,
        ])

        <form method="POST" id="questionsForm" action="{{ route('assignment.ielts.listening.submit', ['meeting' => $meeting->id ?? 0, 'set' => $set, 'test' => $testId]) }}" class="-mt-16 relative z-10">
            @csrf
            
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300 mb-6">
                <div class="flex justify-center mb-6">
                    <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                </div>

                @if(view()->exists('assignments.ielts.listening.questions.part' . $set . '.test' . $testId))
                    @include('assignments.ielts.listening.questions.part' . $set . '.test' . $testId)
                @else
                    <div class="flex flex-col items-center justify-center h-48 text-gray-400">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"></path></svg>
                        <p class="text-lg font-medium">Question content not available yet.</p>
                        <p class="text-sm mt-2 text-center text-gray-500">The text for this specific test has not been added to the system.</p>
                    </div>
                @endif
            </div>

            <div class="max-w-4xl mx-auto mt-8 flex justify-between gap-4">
                <a href="{{ route('assignments.ielts-academic.listening.part1.practice', ['meeting' => $meeting->id ?? 0, 'set' => $set]) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl transition-all">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                    Submit Answers
                </button>
            </div>
        </form>


    </div>

    {{-- (Audio player scripts included in audio-player-practice partial) -->

    <script>
    function toggleTranscriptDrawer() {
        const drawer = document.getElementById('transcriptDrawer');
        if (drawer) {
            drawer.classList.toggle('hidden');
        }
    }

    // Limit Checkbox Selections (Choose TWO, Choose THREE, etc.)
    document.addEventListener('DOMContentLoaded', function() {
        const selectionQueues = {};

        // Parse max allowed from name (e.g. "answers_multi[27_28]" -> 28 - 27 + 1 = 2)
        function getMaxAllowed(name) {
            const match = name.match(/\[(\d+)_(\d+)\]/);
            if (match) {
                return parseInt(match[2], 10) - parseInt(match[1], 10) + 1;
            }
            return 2; // Fallback to 2
        }

        const multiCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="answers_multi["]');

        // Initialize queues
        multiCheckboxes.forEach(function(checkbox) {
            const name = checkbox.name;
            if (!selectionQueues[name]) selectionQueues[name] = [];
            
            // Push initially checked elements to queue
            if (checkbox.checked) {
                selectionQueues[name].push(checkbox);
            }

            // Listen to changes
            checkbox.addEventListener('change', function() {
                const maxAllowed = getMaxAllowed(name);
                const queue = selectionQueues[name];
                
                if (this.checked) {
                    queue.push(this);
                    
                    // If queue exceeds max, shift the oldest and uncheck it
                    if (queue.length > maxAllowed) {
                        const oldest = queue.shift();
                        oldest.checked = false;
                    }
                } else {
                    // Remove unchecked from queue
                    const index = queue.indexOf(this);
                    if (index !== -1) {
                        queue.splice(index, 1);
                    }
                }
            });
        });
    });
    </script>
@endsection
