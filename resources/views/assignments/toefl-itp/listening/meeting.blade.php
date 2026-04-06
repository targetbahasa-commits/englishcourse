@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 {{ isset($set) ? 'pt-24 pb-8' : 'py-8' }} relative" x-data="{ 
    sidebarOpen: false, 
    editingQuestion: null,
    showForm: false,
    formData: {
        id: null,
        meeting_number: {{ $number }},
        set_number: {{ $set ?? 1 }},
        question_number: '',
        question_text: '',
        option_a: '',
        option_b: '',
        option_c: '',
        option_d: '',
        correct_answer: 'A',
        audio_file: null
    },
    edit(question) {
        this.editingQuestion = question;
        this.formData = {
            id: question.id,
            meeting_number: question.meeting_number,
            set_number: question.set_number,
            question_number: question.question_number,
            question_text: question.question_text,
            option_a: question.option_a,
            option_b: question.option_b,
            option_c: question.option_c,
            option_d: question.option_d,
            correct_answer: question.correct_answer,
            audio_file: null
        };
        this.showForm = true;
        this.sidebarOpen = true;
    },
    create() {
        this.editingQuestion = null;
        this.formData = {
            id: null,
            meeting_number: {{ $number }},
            set_number: {{ $set ?? 1 }},
            question_number: {{ count($questions) + 1 }},
            question_text: '',
            option_a: '',
            option_b: '',
            option_c: '',
            option_d: '',
            correct_answer: 'A',
            audio_file: null
        };
        this.showForm = true;
        this.sidebarOpen = true;
    },
    cancelEdit() {
        this.showForm = false;
        this.editingQuestion = null;
    }
}" x-on:open-edit-question.window="edit($event.detail)" x-on:create-question.window="create()">
    <style>
        body {
            background-color: white !important;
        }

    /* Force circular bubble */
    .answer-label div div {
        border-radius: 50% !important;
        width: 2.5rem !important;
        height: 2.5rem !important;
        min-width: 2.5rem !important;
        min-height: 2.5rem !important;
    }

    /* Make bubble red when checked */
    .answer-label:has(input[type="radio"]:checked) div div {
        background-color: #ef4444 !important; /* red-500 */
        border-color: #ef4444 !important;
    }

    /* Make text inside bubble white when checked */
    .answer-label:has(input[type="radio"]:checked) div div span {
        color: white !important;
    }

    /* Student Result Feedback Overrides */
    .answer-label.is-correct {
        background-color: #dcfce7 !important; /* green-100 */
        border: 2px solid #22c55e !important; /* green-500 */
    }
    .answer-label.is-correct span {
        color: #15803d !important; /* green-700 */
        font-weight: bold;
    }
    
    .answer-label.is-wrong {
        background-color: #fef2f2 !important; /* red-50 */
        border: 2px solid #ef4444 !important; /* red-500 */
    }
    .answer-label.is-wrong span {
        color: #991b1b !important; /* red-800 */
    }
</style>
    @if(isset($set))
        @include('assignments.toefl-itp.listening.partials.audio-player')
    @endif

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Listening - Meeting {{ $number }}</h1>
                    <p class="text-gray-600 mt-1">Complete listening questions</p>
                </div>
            </div>
            
            @if(!isset($set))
                <a href="{{ route('assignments.toefl-itp.listening') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Meetings
                </a>
            @endif
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Existing Score Display -->
    @if($existingScore)
        <div class="mb-6 p-6 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-blue-900">Previous Score</h3>
                    <p class="text-blue-700">{{ $existingScore->score }}% - Submitted {{ $existingScore->submitted_at->diffForHumans() }}</p>
                </div>
                <div class="text-3xl font-bold text-blue-600">{{ $existingScore->score }}%</div>
            </div>
        </div>
    @endif

    <!-- Questions Form -->
    @if(!isset($set))
        {{-- Practice Buttons Section --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Pilih Latihan</h2>
                @if(Auth::user()->isAdmin())
                    <div class="flex items-center gap-2">
                        {{-- (Removed Global Remove Set Button) --}}

                        {{-- Add Set Button --}}
                        <form action="{{ route('assignments.toefl-itp.listening.meeting.add-set', ['number' => $number]) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="p-2 bg-green-100 text-green-600 rounded-full hover:bg-green-200 transition-colors"
                                    title="Add New Practice Set">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($availableSets as $s)
                    @php
                        // Cycle colors
                        $colors = [
                            ['from' => 'from-blue-500', 'to' => 'to-blue-600'],
                            ['from' => 'from-indigo-500', 'to' => 'to-indigo-600'],
                            ['from' => 'from-purple-500', 'to' => 'to-purple-600'],
                            ['from' => 'from-pink-500', 'to' => 'to-pink-600'],
                            ['from' => 'from-rose-500', 'to' => 'to-rose-600'],
                            ['from' => 'from-amber-500', 'to' => 'to-amber-600'],
                        ];
                        $color = $colors[($s - 1) % count($colors)];
                    @endphp

                    <div class="relative group">
                        @if(Auth::user()->isAdmin())
                            <form action="{{ route('assignments.toefl-itp.listening.meeting.remove-set', ['number' => $number]) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Hapus Latihan {{ $s }}? Semua soal di dalamnya akan dihapus.');"
                                  class="absolute top-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                <input type="hidden" name="set_number" value="{{ $s }}">
                                <button type="submit" class="p-1.5 bg-white/20 hover:bg-red-500 hover:text-white text-white rounded-full transition-colors backdrop-blur-sm" title="Hapus Latihan {{ $s }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        @endif

                    <a href="{{ route('assignments.toefl-itp.listening.meeting.practice', ['number' => $number, 'set' => $s]) }}" 
                       class="block p-6 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">Latihan {{ $s }}</h3>
                            </div>
                            <svg class="w-6 h-6 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <p class="text-blue-50 text-sm">Klik untuk memulai latihan {{ $s }}</p>
                    </a>
                    </div>
                @endforeach
            </div>
        </div>
    @else

        <form method="POST" action="{{ route('assignments.toefl-itp.listening.meeting.submit', $number) }}" class="space-y-8">
            @csrf
            <input type="hidden" name="set_number" value="{{ $set }}">
            <script>
                window.toeflListeningQuestions = @json($questions->keyBy('id'));
                window.openEditQuestionById = function(questionId) {
                    const map = window.toeflListeningQuestions || {};
                    const key = String(questionId);
                    const question = map[key] || map[questionId];

                    if (!question) {
                        console.warn('Question data not found for ID:', questionId);
                        return;
                    }

                    window.dispatchEvent(new CustomEvent('open-edit-question', { detail: question }));
                };
            </script>
            
            @php
                $instructionPanel = null;
                $instructionQuestionId = null;

                if ($questions->isNotEmpty()) {
                    $firstQuestion = $questions->sortBy('question_number')->first();
                    $rawInstructionText = trim((string) ($firstQuestion->question_text ?? ''));
                    $normalizedInstructionText = str_replace('\\n', "\n", $rawInstructionText);

                    if (stripos($normalizedInstructionText, 'Focus:') === 0 && stripos($normalizedInstructionText, 'Directions:') !== false) {
                        $focusText = '';
                        $directionsText = '';

                        if (preg_match('/^\s*Focus:\s*(.+?)\s*Directions:\s*(.+)\s*$/is', $normalizedInstructionText, $matches)) {
                            $focusText = trim($matches[1]);
                            $directionsText = trim($matches[2]);
                        } else {
                            $parts = preg_split('/Directions:/i', $normalizedInstructionText, 2);
                            $focusText = isset($parts[0]) ? trim(preg_replace('/^\s*Focus:\s*/i', '', $parts[0])) : '';
                            $directionsText = isset($parts[1]) ? trim($parts[1]) : '';
                        }

                        if ($focusText !== '' || $directionsText !== '') {
                            $instructionPanel = [
                                'focus' => $focusText,
                                'directions' => $directionsText,
                            ];
                            $instructionQuestionId = $firstQuestion->id;
                        }
                    }
                }

                $splitIndex = ceil(count($questions) / 2);
            @endphp

            @if($instructionPanel)
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-5">
                    @if($instructionPanel['focus'] !== '')
                        <p class="text-amber-900"><span class="font-semibold">Focus:</span> {{ $instructionPanel['focus'] }}</p>
                    @endif
                    @if($instructionPanel['directions'] !== '')
                        <p class="text-amber-900 mt-2"><span class="font-semibold">Directions:</span> {{ $instructionPanel['directions'] }}</p>
                    @endif
                </div>
            @endif
            
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="flex items-center justify-between gap-3 mb-5 pb-4 border-b border-gray-100">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800">Container Soal</h3>
                    @php
                        $currentUser = Auth::user();
                        $baseRole = strtolower(trim((string) ($currentUser->role ?? '')));
                        $hasAdminBaseRole = $baseRole === 'admin' || str_contains($baseRole, 'admin');
                        $isAdminImpersonating = $currentUser && $baseRole === 'admin' && request()->hasSession() && session()->has('view_as_role');
                        $hasPrivilegedAccess = $currentUser && (
                            (method_exists($currentUser, 'isAdmin') && $currentUser->isAdmin())
                            || $hasAdminBaseRole
                            || $isAdminImpersonating
                        );
                        $canSeeEditSoal = $currentUser && (
                            $hasPrivilegedAccess
                        );
                    @endphp
                    @if($canSeeEditSoal)
                        @if($questions->isNotEmpty())
                            <button type="button"
                                onclick="openEditQuestionById({{ $questions->sortBy('question_number')->first()->id }})"
                                class="px-3 py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2 shadow-md text-sm"
                                title="Edit Soal">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L12.828 14H10v-2.828l7.586-7.586z"></path>
                                </svg>
                                Edit Soal
                            </button>
                        @else
                            <button type="button"
                                onclick='window.dispatchEvent(new CustomEvent("create-question"))'
                                class="px-3 py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2 shadow-md text-sm"
                                title="Tambah Soal">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Soal
                            </button>
                        @endif
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 relative">
                    {{-- Column 1 --}}
                    <div class="space-y-0 divide-y divide-gray-100">
                        @foreach($questions->slice(0, $splitIndex) as $index => $question)
                            @include('assignments.toefl-itp.listening.partials.question-card', ['question' => $question, 'index' => $question->question_number, 'existingScore' => $existingScore, 'instructionQuestionId' => $instructionQuestionId])
                        @endforeach
                    </div>

                    {{-- Column 2 --}}
                    <div class="space-y-0 divide-y divide-gray-100">
                        @foreach($questions->slice($splitIndex) as $index => $question)
                            @include('assignments.toefl-itp.listening.partials.question-card', ['question' => $question, 'index' => $question->question_number, 'existingScore' => $existingScore, 'instructionQuestionId' => $instructionQuestionId])
                        @endforeach
                    </div>
                </div>
            </div>
        


        <!-- Submit Button -->            <div class="mt-8 flex flex-col gap-6">
                {{-- Score Report Section (Bottom) --}}
                 @if(session('score_data'))
                    @php
                        $sData = session('score_data');
                        $score = $sData['score'];
                        $correct = $sData['correct_count'];
                        $total = $sData['total_question'];
                        
                        // Color Logic
                        if ($score >= 80) {
                            $scoreColor = 'green';
                            $scoreMsg = 'Excellent! Keep it up!';
                        } elseif ($score >= 60) {
                            $scoreColor = 'blue';
                            $scoreMsg = 'Good job! Practice makes perfect.';
                        } else {
                            $scoreColor = 'red';
                            $scoreMsg = 'Keep practicing! You can do better.';
                        }
                    @endphp
                    <div id="scoreReport" class="bg-{{ $scoreColor }}-50 border-l-4 border-{{ $scoreColor }}-500 p-6 rounded-r-lg shadow-sm animate-fade-in-down mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    @if($score >= 80)
                                        <svg class="h-8 w-8 text-{{ $scoreColor }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($score >= 60)
                                        <svg class="h-8 w-8 text-{{ $scoreColor }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    @else
                                        <svg class="h-8 w-8 text-{{ $scoreColor }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl leading-6 font-bold text-{{ $scoreColor }}-800">
                                        Hasil Latihan
                                    </h3>
                                    <div class="mt-2 text-{{ $scoreColor }}-700 grid grid-cols-1 md:grid-cols-2 gap-x-8">
                                        <div class="flex items-baseline gap-3">
                                            <span class="text-5xl font-extrabold tracking-tight">{{ round($score) }}%</span>
                                            <span class="text-sm font-semibold uppercase tracking-wide opacity-80">Score</span>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <div class="text-lg font-semibold">Benar {{ $correct }} / {{ $total }}</div>
                                            <p class="text-sm opacity-90 italic">{{ $scoreMsg }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:block text-{{ $scoreColor }}-200 opacity-20 transform rotate-12">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    {{-- Auto Scroll to Score --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const scoreReport = document.getElementById('scoreReport');
                            if(scoreReport) {
                                scoreReport.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        });
                    </script>
                @endif
            
            <div class="flex justify-end gap-4">
            <a href="{{ route('assignments.toefl-itp.listening.meeting', $number) }}" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition-colors duration-200">
                Back to Set Selection
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                {{ $existingScore ? 'Resubmit Answers' : 'Submit Answers' }}
            </button>
        </div>
    </form>

    <!-- Question Management Floating Action Button -->
    @php
        $currentUser = Auth::user();
        $baseRole = strtolower(trim((string) ($currentUser->role ?? '')));
        $hasAdminBaseRole = $baseRole === 'admin' || str_contains($baseRole, 'admin');
        $isAdminImpersonating = $currentUser && $baseRole === 'admin' && request()->hasSession() && session()->has('view_as_role');
        $hasPrivilegedAccess = $currentUser && (
            (method_exists($currentUser, 'isAdmin') && $currentUser->isAdmin())
            || $hasAdminBaseRole
            || $isAdminImpersonating
        );
        $canManageQuestions = $currentUser && (
            $hasPrivilegedAccess
        );
    @endphp
    @if($canManageQuestions)
        <button @click="create()" class="fixed bottom-8 right-8 w-16 h-16 bg-blue-600 text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-blue-700 hover:scale-110 transition-all duration-300 z-50">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>

        <!-- Modal Backdrop -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
             @click="sidebarOpen = false">

            <!-- Modal Panel -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto"
                 @click.stop>
                
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-10">
                    <h2 class="text-2xl font-bold text-gray-800" x-text="editingQuestion ? 'Edit Question' : 'New Question'"></h2>
                    <button @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-8">
                    <form method="POST" action="{{ route('assignments.toefl-itp.listening.question.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="id" x-model="formData.id">
                        <input type="hidden" name="meeting_number" x-model="formData.meeting_number">
                        <input type="hidden" name="set_number" x-model="formData.set_number">

                        <!-- Question Number & Audio File in Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Question Number</label>
                                <input type="number" name="question_number" x-model="formData.question_number" class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all duration-200" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Audio File (MP3/WAV)</label>
                                <div class="relative">
                                    <input type="file" name="audio_file" class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-gray-200 rounded-xl">
                                </div>
                                <p class="mt-2 text-xs text-green-600 font-medium flex items-center gap-1" x-show="editingQuestion && editingQuestion.audio_file">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Audio uploaded
                                </p>
                            </div>
                        </div>

                        <!-- Question Text -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Question Text</label>
                            <textarea name="question_text" x-model="formData.question_text" rows="4" class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all duration-200 font-medium" required placeholder="Type the question content here..."></textarea>
                        </div>

                        <!-- Options Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Option A</label>
                                <div class="flex items-center">
                                    <span class="w-10 h-10 flex items-center justify-center bg-gray-100 text-gray-500 font-bold rounded-l-xl border-y border-l border-gray-200">A</span>
                                    <input type="text" name="option_a" x-model="formData.option_a" class="w-full px-4 py-3 rounded-r-xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all duration-200" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Option B</label>
                                <div class="flex items-center">
                                    <span class="w-10 h-10 flex items-center justify-center bg-gray-100 text-gray-500 font-bold rounded-l-xl border-y border-l border-gray-200">B</span>
                                    <input type="text" name="option_b" x-model="formData.option_b" class="w-full px-4 py-3 rounded-r-xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all duration-200" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Option C</label>
                                <div class="flex items-center">
                                    <span class="w-10 h-10 flex items-center justify-center bg-gray-100 text-gray-500 font-bold rounded-l-xl border-y border-l border-gray-200">C</span>
                                    <input type="text" name="option_c" x-model="formData.option_c" class="w-full px-4 py-3 rounded-r-xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all duration-200" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Option D</label>
                                <div class="flex items-center">
                                    <span class="w-10 h-10 flex items-center justify-center bg-gray-100 text-gray-500 font-bold rounded-l-xl border-y border-l border-gray-200">D</span>
                                    <input type="text" name="option_d" x-model="formData.option_d" class="w-full px-4 py-3 rounded-r-xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all duration-200" required>
                                </div>
                            </div>
                        </div>

                        <!-- Correct Answer -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Correct Answer</label>
                            <div class="grid grid-cols-4 gap-4">
                                @foreach(['A', 'B', 'C', 'D'] as $option)
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="correct_answer" value="{{ $option }}" x-model="formData.correct_answer" class="peer sr-only">
                                    <div class="h-12 flex items-center justify-center rounded-xl border-2 border-gray-100 bg-white font-bold text-gray-500 hover:bg-gray-50 hover:border-blue-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 transition-all duration-200">
                                        {{ $option }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex gap-4 pt-6 mt-6 border-t border-gray-100">
                            <button type="button" @click="sidebarOpen = false" class="px-8 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-lg shadow-blue-200 hover:shadow-blue-300 transform hover:-translate-y-0.5">
                                Save Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @endif
</div>
@include('assignments.toefl-itp.listening.partials.admin-modals')
@include('assignments.toefl-itp.listening.partials.audio-player-scripts')
@endsection
