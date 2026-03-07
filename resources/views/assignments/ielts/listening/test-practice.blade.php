@extends('layouts.admin')

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
            <a href="{{ route('assignments.ielts-academic.listening.practice-index.part', ['set' => $set]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Tests
            </a>
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

        @php
            $section = $meeting->ieltsSections->where('section_number', $set)->first();
        @endphp

        {{-- Audio Player --}}
        @include('assignments.ielts.listening.partials.audio-player', ['section' => $section, 'set' => $set])

        <form method="POST" id="questionsForm" action="{{ route('assignment.ielts.listening.submit', ['meeting' => $meeting->id, 'set' => $set, 'test' => $testId]) }}" class="-mt-16 relative z-10">
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
                <a href="{{ route('assignments.ielts-academic.listening.part1.practice', ['meeting' => $meeting->id, 'set' => $set]) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl transition-all">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                    Submit Answers
                </button>
            </div>
        </form>


    </div>

    {{-- Admin Modals --}}
    @if(auth()->check() && strtolower(auth()->user()->role) === 'admin')
    @include('assignments.ielts.listening.partials.admin-modals', ['section' => $section])
    @endif

    {{-- Audio Player Scripts --}}
    @include('assignments.ielts.listening.partials.audio-player-scripts')

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
