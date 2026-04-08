<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - TOEFL ITP Reading - Lesson {{ $meeting->meeting_number }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3FFFF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif
        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="bg-white rounded-3xl p-8 shadow-sm mb-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                        <div class="flex items-center gap-4">
                            <a href="{{ route('assignments.toefl-itp.reading') }}" class="p-2 bg-white rounded-lg shadow-sm hover:shadow-md transition text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            </a>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $meeting->title }}</h1>
                                <p class="text-blue-600 font-medium">Reading Lesson {{ $meeting->meeting_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="prose max-w-none mb-8">
                     <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <p class="font-bold">Directions:</p>
                        <p>Read the passages. Then choose the correct answer for each question.</p>
                     </div>

                     @foreach($passages as $passage)
                        <div class="mb-10 p-6 bg-white border border-gray-100 rounded-2xl shadow-sm">
                            <div class="bg-gray-50 p-6 rounded-xl mb-6 text-gray-800 leading-relaxed text-justify relative group" 
                                 x-data="{ 
                                    translateMode: false, 
                                    originalContent: `{{ $passage->content }}`,
                                    passageTranslation: `{{ addslashes($passage->indonesian_translation ?? '') }}`
                                 }"
                            >
                                <span class="absolute top-0 right-0 bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded-bl-lg rounded-tr-lg">Passage {{ $passage->passage_number }}</span>
                                
                                <!-- Admin Controls -->
                                @if(Auth::user()->isAdmin())
                                <div class="absolute top-8 right-2 flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity p-2 z-10">
                                    <button onclick='openEditPassageModal(@json($passage))' class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl hover:bg-blue-200 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('assignments.toefl-itp.reading.passage.destroy', $passage->id) }}" method="POST" onsubmit="return confirm('Delete this passage? This will also delete all associated questions.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                @endif

                                <!-- Translate Toggle -->
                                <button 
                                    @click="translateMode = !translateMode; toggleTranslate($el.parentElement, translateMode, originalContent, passageTranslation)"
                                    class="absolute bottom-4 right-4 w-10 h-10 flex items-center justify-center rounded-full transition-all z-20 shadow-md border border-gray-200 hover:scale-105"
                                    :class="translateMode ? 'bg-yellow-400 text-white border-yellow-500 ring-2 ring-yellow-200' : 'bg-white text-gray-400 hover:text-yellow-500 hover:border-yellow-400'"
                                    title="Translate Mode"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>

                                <div class="passage-content mt-4" :class="translateMode ? 'cursor-help' : ''">
                                    {!! $passage->content !!}
                                </div>
                            </div>
                            
                            <div class="space-y-8">
                                @foreach($passage->questions as $question)
                                <div class="relative pl-4 border-l-2 border-gray-200 group" x-data="{ selected: null }">
                                    
                                    <!-- Admin Controls -->
                                    @if(Auth::user()->isAdmin())
                                    <div class="absolute top-0 right-0 flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity p-2">
                                        <button onclick='openEditQuestionModal(@json($question))' class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl hover:bg-blue-200 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <form action="{{ route('assignments.toefl-itp.reading.question.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Delete this question?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                    @endif

                                    @php
                                        $hasOptions = !empty($question->option_a) || !empty($question->option_b) || !empty($question->option_c) || !empty($question->option_d);
                                    @endphp

                                    <div class="flex gap-4 mb-4">
                                        <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-lg font-bold text-sm">{{ $question->question_number }}</span>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-800 inline">{{ $question->question_text }}</p>
                                            
                                            @if(!$hasOptions && $question->question_number <= 23)
                                                {{-- Textbox for fill-in-the-blank questions (Q1-23) --}}
                                                <input type="text" 
                                                    name="question_{{ $question->id }}" 
                                                    class="ml-2 w-48 px-3 py-1 border-2 border-gray-300 rounded-lg focus:border-red-500 focus:outline-none text-center font-medium inline-block"
                                                    placeholder="____"
                                                    maxlength="100"
                                                >
                                            @endif
                                        </div>
                                    </div>

                                    @if($hasOptions)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ml-12">
                                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                                            @php $optionText = $question->{'option_'.$opt}; @endphp
                                            @if($optionText)
                                            <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 group"
                                                :class="selected === '{{ strtoupper($opt) }}' ? 'border-red-500 bg-red-50' : 'border-gray-100 hover:border-gray-200 bg-white'"
                                            >
                                                <input type="radio" 
                                                    name="question_{{ $question->id }}" 
                                                    value="{{ strtoupper($opt) }}" 
                                                    class="hidden"
                                                    x-model="selected"
                                                >
                                                
                                                <div class="flex items-center gap-4 w-full">
                                                    <span class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-200 shrink-0"
                                                        :class="selected === '{{ strtoupper($opt) }}' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'"
                                                    >
                                                        {{ strtoupper($opt) }}
                                                    </span>
                                                    <span class="text-gray-700 font-medium transition-colors duration-200"
                                                        :class="selected === '{{ strtoupper($opt) }}' ? 'text-red-700' : 'text-gray-600'"
                                                    >
                                                        {{ $optionText }}
                                                    </span>
                                                </div>
                                            </label>
                                            @endif
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                     @endforeach
                </div>
                
                <div class="flex justify-end">
                    <button class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md hover:bg-blue-700 transition">
                        Submit Answers
                    </button>
                </div>
            </div>
        </main>
    </div>
    <!-- Edit Question Modal -->
    <div id="editQuestionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
        <div class="bg-white rounded-2xl p-8 w-full max-w-2xl mx-4 my-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Question</h3>
            <form id="editQuestionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-4 gap-4 mb-4">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">No.</label>
                        <input type="number" id="edit_question_number" name="question_number" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500" required>
                    </div>
                    <div class="col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                        <input type="text" id="edit_question_text" name="question_text" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500" required>
                    </div>
                </div>

                <div class="space-y-4 mb-6" id="edit_options_section">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option A</label>
                            <input type="text" id="edit_option_a" name="option_a" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option B</label>
                            <input type="text" id="edit_option_b" name="option_b" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option C</label>
                            <input type="text" id="edit_option_c" name="option_c" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option D (Optional)</label>
                            <input type="text" id="edit_option_d" name="option_d" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                    <input type="text" id="edit_correct_answer_text" name="correct_answer" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="Enter the correct answer" required>
                    <select id="edit_correct_answer_select" name="correct_answer_select" class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 hidden">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editQuestionModal').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium transition">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Update Question</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Edit Passage Modal -->
    <div id="editPassageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
        <div class="bg-white rounded-2xl p-8 w-full max-w-2xl mx-4 my-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Passage</h3>
            <form id="editPassageForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Passage Number</label>
                    <input type="number" id="edit_passage_number" name="passage_number" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea id="edit_passage_content" name="content" rows="10" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Indonesian Translation</label>
                    <textarea id="edit_passage_translation" name="indonesian_translation" rows="10" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Optional translation..."></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editPassageModal').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium transition">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Update Passage</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Add Question Modal -->
    <div id="addQuestionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
        <div class="bg-white rounded-2xl p-8 w-full max-w-2xl mx-4 my-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Add New Question</h3>
            <form id="addQuestionForm" action="{{ route('assignments.toefl-itp.reading.question.store') }}" method="POST">
                @csrf
                <input type="hidden" id="add_passage_id" name="passage_id">
                
                <div class="grid grid-cols-4 gap-4 mb-4">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">No.</label>
                        <input type="number" name="question_number" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                    </div>
                    <div class="col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                        <input type="text" name="question_text" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                    </div>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option A</label>
                            <input type="text" name="option_a" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option B</label>
                            <input type="text" name="option_b" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option C</label>
                            <input type="text" name="option_c" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option D (Optional)</label>
                            <input type="text" name="option_d" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                    <select name="correct_answer" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addQuestionModal').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium transition">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition">Add Question</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div id="definitionPopup" class="absolute hidden bg-white rounded-xl shadow-xl border border-gray-100 p-4 w-72 z-50 transition-all duration-200">
        <div class="flex justify-between items-start mb-2">
            <div>
                <h4 id="def_word" class="text-lg font-bold text-gray-900 capitalize"></h4>
                <p id="def_translation" class="text-sm text-blue-600 font-medium mt-0.5"></p>
            </div>
            <button onclick="document.getElementById('definitionPopup').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Context Sentence Section -->
        <div id="def_context_container" class="mb-3 hidden">
             <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Context</p>
             <p id="def_context_sentence" class="text-xs text-gray-700 italic border-l-2 border-yellow-400 pl-2"></p>
        </div>

        <div>
            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold mb-1">TOEFL Synonyms</p>
            <p id="def_synonyms" class="text-sm text-gray-600"></p>
        </div>
    </div>

    <script>
        function openEditQuestionModal(question) {
            const form = document.getElementById('editQuestionForm');
            let updateUrl = "{{ route('assignments.toefl-itp.reading.question.update', 0) }}";
            form.action = updateUrl.replace('/0', '/' + question.id);
            
            document.getElementById('edit_question_number').value = question.question_number;
            document.getElementById('edit_question_text').value = question.question_text;
            document.getElementById('edit_option_a').value = question.option_a || '';
            document.getElementById('edit_option_b').value = question.option_b || '';
            document.getElementById('edit_option_c').value = question.option_c || '';
            document.getElementById('edit_option_d').value = question.option_d || '';
            
            // Check if this is a fill-in-the-blank question (no options)
            const hasOptions = question.option_a || question.option_b || question.option_c || question.option_d;
            const textInput = document.getElementById('edit_correct_answer_text');
            const selectInput = document.getElementById('edit_correct_answer_select');
            
            if (!hasOptions) {
                // Fill-in-the-blank: show textbox, hide dropdown
                textInput.classList.remove('hidden');
                textInput.disabled = false;
                textInput.value = question.correct_answer || '';
                selectInput.classList.add('hidden');
                selectInput.disabled = true;
                selectInput.removeAttribute('name');
            } else {
                // Multiple choice: show dropdown, hide textbox
                textInput.classList.add('hidden');
                textInput.disabled = true;
                textInput.removeAttribute('name');
                selectInput.classList.remove('hidden');
                selectInput.disabled = false;
                selectInput.setAttribute('name', 'correct_answer');
                selectInput.value = question.correct_answer;
            }
            
            document.getElementById('editQuestionModal').classList.remove('hidden');
        }

        function openEditPassageModal(passage) {
            const form = document.getElementById('editPassageForm');
            let updateUrl = "{{ route('assignments.toefl-itp.reading.passage.update', 0) }}";
            form.action = updateUrl.replace('/0', '/' + passage.id);
            
            document.getElementById('edit_passage_number').value = passage.passage_number;
            document.getElementById('edit_passage_content').value = passage.content;
            document.getElementById('edit_passage_translation').value = passage.indonesian_translation || '';
            
            document.getElementById('editPassageModal').classList.remove('hidden');
        }

        function openAddQuestionModal(passageId) {
            document.getElementById('add_passage_id').value = passageId;
            document.getElementById('addQuestionModal').classList.remove('hidden');
        }

        function toggleTranslate(container, active, originalText, passageTranslation = '') {
            const contentDiv = container.querySelector('.passage-content');
            
            if (!active) {
                contentDiv.innerText = originalText;
                document.getElementById('definitionPopup').classList.add('hidden');
                return;
            }

            // User Logic: Pisahkan Kata -> Span -> Event -> Fetch -> Display
            
            // 1. Prepare sentences for context (Optional feature but requested by "connect meaning")
            // We split translation by sentences to map them.
            const transSentences = passageTranslation ? (passageTranslation.match(/[^.!?]+[.!?]+(\s+|$)|[^.!?]+$/g) || [passageTranslation]) : [];

            // 2. Tokenize English text into words and punctuation
            // This regex matches words (alphanumeric+skips) OR non-whitespace punctuation
            const tokens = originalText.match(/([a-zA-Z0-9\-\']+|[^a-zA-Z0-9\-\'\s]+|\s+)/g) || [];

            let html = '';
            let sentenceIndex = 0;

            tokens.forEach(token => {
                // Check if token is a word
                if (/^[a-zA-Z0-9\-\']+$/.test(token)) {
                    const cleanWord = token.replace(/'/g, "\\'"); // Escape for JS string
                    
                    // Context: Get corresponding translation sentence if available
                    // We handle index bounds safely
                    const transSentenceSafe = transSentences[sentenceIndex] ? transSentences[sentenceIndex].trim().replace(/'/g, "\\'").replace(/"/g, '&quot;') : '';

                    html += `<span 
                                class="cursor-pointer hover:bg-yellow-200 hover:text-yellow-800 rounded px-0.5 transition-colors border-b border-dashed border-gray-400"
                                onclick="lookupWord('${cleanWord}', event, ${sentenceIndex}, '${transSentenceSafe}')"
                             >${token}</span>`;
                } else {
                    // Punctuation or Space
                    html += token;
                    
                    // Increment sentence index if punctuation is a sentence ender
                    if (/[.!?]/.test(token)) {
                        sentenceIndex++;
                    }
                }
            });

            contentDiv.innerHTML = html;
        }

        async function lookupWord(word, event, sentenceIndex, contextSentence) {
            event.stopPropagation();
            
            const popup = document.getElementById('definitionPopup');
            const cleanWord = word.replace(/[^a-zA-Z0-9\-\']/g, '').toLowerCase();

            // Position Popup Logic
            const x = Math.min(event.pageX, window.innerWidth - 300); 
            const y = event.pageY + 15;

            popup.style.top = `${y}px`;
            popup.style.left = `${x}px`;
            
            // Reset Content
            document.getElementById('def_word').innerText = cleanWord;
            document.getElementById('def_translation').innerText = 'Memuat...';
            document.getElementById('def_synonyms').innerText = '...';
            
            // Context Display
            const ctxContainer = document.getElementById('def_context_container');
            const ctxText = document.getElementById('def_context_sentence');
            
            if (contextSentence && contextSentence.length > 5) {
                ctxText.innerText = contextSentence;
                ctxContainer.classList.remove('hidden');
            } else {
                ctxContainer.classList.add('hidden');
            }

            popup.classList.remove('hidden');

            try {
                // Fetch API Logic
                const response = await fetch(`{{ route('api.dictionary.lookup') }}?word=${cleanWord}`);
                const data = await response.json();

                if (data.found) {
                    document.getElementById('def_word').innerText = data.word;
                    document.getElementById('def_translation').innerText = data.translation;
                    
                    if (data.synonyms && data.synonyms !== '-' && data.synonyms !== null) {
                        document.getElementById('def_synonyms').innerText = data.synonyms;
                    } else {
                        document.getElementById('def_synonyms').innerText = 'Memuat...';
                        fetch(`{{ route('api.dictionary.synonyms') }}?word=${cleanWord}`)
                            .then(res => res.json())
                            .then(synData => {
                                if (document.getElementById('def_word').innerText.toLowerCase() === data.word.toLowerCase()) {
                                    document.getElementById('def_synonyms').innerText = synData.synonyms || '-';
                                }
                            })
                            .catch(err => {
                                console.error('Synonym error:', err);
                                document.getElementById('def_synonyms').innerText = '-';
                            });
                    }
                } else {
                    document.getElementById('def_translation').innerText = 'Tidak ditemukan';
                    document.getElementById('def_synonyms').innerText = '-';
                }
            } catch (error) {
                console.error('Dictionary error:', error);
                document.getElementById('def_translation').innerText = 'Error';
            }
        }
    </script>        <div>
            <h3 id="def_word" class="text-lg font-bold text-gray-800 mb-1 capitalize">Word</h3>
            <div class="bg-blue-50 text-blue-700 text-sm font-semibold px-3 py-1 rounded-lg inline-block mb-3" id="def_translation">
                Translation
            </div>
            
            <div class="text-left bg-gray-50 rounded-lg p-3">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Synonyms</p>
                <p id="def_synonyms" class="text-sm text-gray-700 italic">synonym 1, synonym 2</p>
            </div>
        </div>
    </div>
</body>
</html>
