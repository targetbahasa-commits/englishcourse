<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - {{ $meeting->title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F4F6FB]">
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

        <main class="flex-1 md:ml-64 p-4 sm:p-6 md:p-8 pb-24">
            <div class="max-w-5xl mx-auto">
                <!-- Top Navigation & Title Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('assignments.sat.reading-writing') }}" class="p-2.5 bg-white text-gray-600 rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition" title="Kembali ke Daftar Practice Test">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-full border border-indigo-100">
                                Digital SAT Reading &amp; Writing
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">{{ $meeting->title }}</h1>
                            @if($meeting->subtitle)
                                <p class="text-sm text-gray-500">{{ $meeting->subtitle }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3 flex-wrap">
                        @if($existingScore)
                            <span class="px-4 py-2 rounded-xl font-bold text-sm bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-xs flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Skor: {{ round($existingScore->score) }} ({{ $existingScore->correct_count }}/{{ $existingScore->total_questions }} Benar)
                            </span>
                            <a href="{{ request()->fullUrlWithQuery(['retry' => 1]) }}" onclick="return confirm('Apakah Anda yakin ingin mengulang latihan ini? Jawaban sebelumnya akan direset.')" class="px-4 py-2 rounded-xl font-bold text-sm bg-amber-100 hover:bg-amber-200 text-amber-800 border border-amber-300 shadow-xs transition inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Ulangi Latihan
                            </a>
                        @endif

                        @if(Auth::user()->isAdmin())
                            <button onclick="document.getElementById('addQuestionModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-sm transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Soal
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Digital SAT Instructions Banner -->
                <div class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white rounded-2xl p-5 mb-8 shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="p-2.5 bg-white/10 rounded-xl shrink-0">
                            <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-yellow-300">Petunjuk Pengerjaan Digital SAT:</h3>
                            <p class="text-sm text-indigo-100 mt-1 leading-relaxed">
                                Setiap soal menyajikan teks bacaan atau kutipan singkat diikuti satu pertanyaan pilihan ganda. Pilihlah satu jawaban yang paling logis dan tepat sesuai kaidah Standard English atau teks bacaan. Setelah selesai, klik tombol <strong>Submit Answers</strong> di bagian bawah untuk melihat skor dan pembahasan lengkap.
                            </p>
                        </div>
                    </div>
                </div>

                @if($existingScore)
                    <!-- Score Summary Alert -->
                    <div class="bg-white border-2 border-emerald-400 rounded-2xl p-6 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">Hasil Pengerjaan</span>
                            <h2 class="text-2xl font-bold text-gray-900 mt-2">Skor Anda: {{ round($existingScore->score) }}%</h2>
                            <p class="text-sm text-gray-600 mt-1">
                                Anda menjawab dengan benar <strong class="text-emerald-700">{{ $existingScore->correct_count }}</strong> dari <strong class="text-gray-800">{{ $existingScore->total_questions }}</strong> soal.
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="#question-1" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl transition">
                                Review Pembahasan
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Question Form -->
                <form method="POST" action="{{ route('assignments.sat.reading-writing.submit') }}" id="satExamForm">
                    @csrf
                    <input type="hidden" name="meeting_number" value="{{ $meeting->meeting_number }}">

                    <div class="space-y-8">
                        @forelse($questions as $question)
                        @php
                            $userAns = $existingScore ? ($existingScore->answers[$question->id] ?? null) : null;
                            $correctAns = strtoupper(trim((string)$question->correct_answer));
                            $isCorrect = $userAns && ($userAns === $correctAns);
                        @endphp

                        <div id="question-{{ $question->question_number }}" class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border {{ $existingScore ? ($isCorrect ? 'border-emerald-200' : 'border-rose-200') : 'border-gray-200' }} relative group transition-all"
                             x-data="{ selected: '{{ $userAns ?? '' }}' }">
                            
                            <!-- Question Header & Badges -->
                            <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-extrabold text-sm flex items-center justify-center shadow-xs">
                                        {{ $question->question_number }}
                                    </span>
                                    @if($question->category)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                            {{ $question->category }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Admin Action Buttons -->
                                @if(Auth::user()->isAdmin())
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick='openEditQuestionModal(@json($question))' class="p-1.5 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition" title="Edit Soal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button type="button" onclick="deleteQuestion({{ $question->id }})" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition" title="Hapus Soal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                                @endif
                            </div>

                            <!-- Stimulus / Passage Text -->
                            @if($question->passage)
                            <div class="bg-gray-50/80 rounded-xl p-5 mb-5 border border-gray-100 text-gray-800 text-base leading-relaxed text-justify font-serif">
                                {!! nl2br(e($question->passage)) !!}
                            </div>
                            @endif

                            <!-- Question Prompt -->
                            @if($question->question_prompt)
                            <p class="font-bold text-gray-900 mb-5 text-base">
                                {{ $question->question_prompt }}
                            </p>
                            @endif

                            <!-- Multiple Choice Options -->
                            <div class="space-y-3">
                                @foreach(['a', 'b', 'c', 'd'] as $opt)
                                @php
                                    $optionText = $question->{'option_'.$opt};
                                    $upperOpt = strtoupper($opt);
                                    $isUserChoice = ($userAns === $upperOpt);
                                    $isCorrectChoice = ($correctAns === $upperOpt);

                                    $cardStyle = 'border-gray-200 bg-white hover:border-indigo-300 hover:bg-indigo-50/30';
                                    $badgeStyle = 'bg-gray-100 text-gray-600';

                                    if ($existingScore) {
                                        if ($isCorrectChoice) {
                                            $cardStyle = 'border-emerald-500 bg-emerald-50/70 ring-2 ring-emerald-300';
                                            $badgeStyle = 'bg-emerald-600 text-white font-bold';
                                        } elseif ($isUserChoice && !$isCorrectChoice) {
                                            $cardStyle = 'border-rose-500 bg-rose-50/70 ring-2 ring-rose-300';
                                            $badgeStyle = 'bg-rose-600 text-white font-bold';
                                        }
                                    }
                                @endphp

                                @if(!empty($optionText))
                                <label class="flex items-start gap-3 p-3.5 sm:p-4 rounded-xl border-2 cursor-pointer transition-all {{ $cardStyle }}"
                                       @if(!$existingScore) :class="selected === '{{ $upperOpt }}' ? 'border-indigo-600 bg-indigo-50/60 ring-2 ring-indigo-200' : 'border-gray-200 bg-white hover:border-indigo-300'" @endif>
                                    <input type="radio" 
                                           name="question_{{ $question->id }}" 
                                           value="{{ $upperOpt }}" 
                                           class="hidden"
                                           @if($isUserChoice) checked @endif
                                           @if(!$existingScore) x-model="selected" @endif>
                                    
                                    <span class="w-7 h-7 rounded-lg flex items-center justify-center font-bold text-sm shrink-0 transition-colors {{ $badgeStyle }}"
                                          @if(!$existingScore) :class="selected === '{{ $upperOpt }}' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'" @endif>
                                        {{ $upperOpt }}
                                    </span>

                                    <div class="flex-1 text-sm sm:text-base text-gray-800 pt-0.5 leading-snug">
                                        {{ $optionText }}
                                    </div>

                                    @if($existingScore)
                                        @if($isCorrectChoice)
                                            <span class="ml-auto px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                                ✓ Jawaban Benar
                                            </span>
                                        @elseif($isUserChoice)
                                            <span class="ml-auto px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300 shrink-0">
                                                ✕ Jawaban Anda
                                            </span>
                                        @endif
                                    @endif
                                </label>
                                @endif
                                @endforeach
                            </div>

                            <!-- Detailed Explanation (Shown after submission) -->
                            @if($existingScore && !empty($question->explanation))
                            <div class="mt-6 pt-5 border-t border-gray-100">
                                <div class="bg-blue-50/70 rounded-xl p-5 border border-blue-100">
                                    <div class="flex items-center gap-2 mb-2 text-indigo-900 font-bold text-sm">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pembahasan (Princeton Review):
                                    </div>
                                    <div class="text-sm text-gray-700 leading-relaxed text-justify">
                                        {!! nl2br(e($question->explanation)) !!}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="bg-white rounded-2xl p-12 text-center text-gray-500 border border-gray-100">
                            Belum ada pertanyaan pada meeting ini.
                        </div>
                        @endforelse
                    </div>

                    <!-- Bottom Submit Bar -->
                    @if($questions->count() > 0)
                    <div class="mt-10 bg-white rounded-2xl p-5 shadow-sm border border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-6 z-20">
                        <div class="text-sm text-gray-600">
                            Total <strong>{{ $questions->count() }}</strong> pertanyaan. Pastikan semua soal telah terjawab.
                        </div>
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            @if($existingScore)
                                <a href="{{ request()->fullUrlWithQuery(['retry' => 1]) }}" onclick="return confirm('Reset jawaban dan kerjakan ulang?')" class="flex-1 sm:flex-initial px-5 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-xs transition text-center text-sm">
                                    Kerjakan Ulang
                                </a>
                            @endif
                            <button type="submit" class="flex-1 sm:flex-initial px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition text-sm">
                                {{ $existingScore ? 'Kirim Ulang Jawaban' : 'Submit Answers' }}
                            </button>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </main>
    </div>

    @if(Auth::user()->isAdmin())
    <!-- Add Question Modal -->
    <div id="addQuestionModal" class="fixed inset-0 bg-black/50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-2xl shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Tambah Soal Baru</h3>
                    <button type="button" onclick="document.getElementById('addQuestionModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('assignments.sat.reading-writing.question.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Soal</label>
                                <input type="number" name="question_number" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required value="{{ $questions->count() + 1 }}">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Soal</label>
                                <input type="text" name="category" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="misal: Vocabulary, Purpose, Transitions">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Teks Bacaan / Passage</label>
                            <textarea name="passage" rows="4" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-mono text-xs"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pertanyaan / Question Prompt</label>
                            <input type="text" name="question_prompt" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Which choice completes the text with the most logical and precise word or phrase?">
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Pilihan A</label>
                                <input type="text" name="option_a" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Pilihan B</label>
                                <input type="text" name="option_b" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Pilihan C</label>
                                <input type="text" name="option_c" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Pilihan D (Opsional)</label>
                                <input type="text" name="option_d" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kunci Jawaban</label>
                                <select name="correct_answer" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Penjelasan / Explanation</label>
                            <textarea name="explanation" rows="3" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('addQuestionModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition">Simpan Soal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Question Modal -->
    <div id="editQuestionModal" class="fixed inset-0 bg-black/50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-2xl shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Edit Soal</h3>
                    <button type="button" onclick="document.getElementById('editQuestionModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form id="editQuestionForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Soal</label>
                                <input type="number" id="edit_question_number" name="question_number" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Soal</label>
                                <input type="text" id="edit_category" name="category" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Teks Bacaan / Passage</label>
                            <textarea id="edit_passage" name="passage" rows="4" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-mono text-xs"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pertanyaan / Question Prompt</label>
                            <input type="text" id="edit_question_prompt" name="question_prompt" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Pilihan A</label>
                                <input type="text" id="edit_option_a" name="option_a" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Pilihan B</label>
                                <input type="text" id="edit_option_b" name="option_b" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Pilihan C</label>
                                <input type="text" id="edit_option_c" name="option_c" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Pilihan D</label>
                                <input type="text" id="edit_option_d" name="option_d" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kunci Jawaban</label>
                                <select id="edit_correct_answer" name="correct_answer" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Penjelasan / Explanation</label>
                            <textarea id="edit_explanation" name="explanation" rows="3" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('editQuestionModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition">Perbarui Soal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditQuestionModal(q) {
            document.getElementById('editQuestionForm').action = `/assignments/sat/reading-writing/question/${q.id}`;
            document.getElementById('edit_question_number').value = q.question_number;
            document.getElementById('edit_category').value = q.category || '';
            document.getElementById('edit_passage').value = q.passage || '';
            document.getElementById('edit_question_prompt').value = q.question_prompt || '';
            document.getElementById('edit_option_a').value = q.option_a || '';
            document.getElementById('edit_option_b').value = q.option_b || '';
            document.getElementById('edit_option_c').value = q.option_c || '';
            document.getElementById('edit_option_d').value = q.option_d || '';
            document.getElementById('edit_correct_answer').value = (q.correct_answer || 'A').toUpperCase();
            document.getElementById('edit_explanation').value = q.explanation || '';
            document.getElementById('editQuestionModal').classList.remove('hidden');
        }

        function deleteQuestion(id) {
            if (confirm('Hapus soal ini?')) {
                const f = document.createElement('form');
                f.method = 'POST';
                f.action = `/assignments/sat/reading-writing/question/${id}`;
                f.style.display = 'none';
                const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
                f.innerHTML = `<input type="hidden" name="_token" value="${token}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(f);
                f.submit();
            }
        }
    </script>
    @endif

    @include('components.student-broadcaster')
    @include('components.floating-wa-button')
</body>
</html>
