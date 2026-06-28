<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - TOEFL ITP Reading - Lesson {{ $meeting->meeting_number }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Scrollbar for better visibility */
        .custom-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #c1c1c1; 
            border-radius: 4px;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8; 
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3FFFF] overflow-hidden">
    @include('components.impersonation-banner')
    <div class="flex h-screen flex-col md:flex-row w-full fixed inset-0">
        
        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full relative min-w-0">
            
            <!-- Header for navigation back -->
            <div class="bg-white shadow-sm p-4 flex justify-between items-center z-20 shrink-0 border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <a href="{{ route('assignments.toefl-itp.reading') }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">{{ $meeting->title }}</h1>
                    </div>
                </div>
                <div class="text-sm font-medium text-blue-600">Lesson {{ $meeting->meeting_number }}</div>
            </div>

            <!-- SUCCESS MODAL -->
            @if(session('success'))
            <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center backdrop-blur-sm" x-data="{ show: true }" x-show="show">
                <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all scale-100 relative text-center">
                    <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Assignment Completed!</h3>
                    
                    @if(App\Models\ToeflReadingScore::where('user_id', Auth::id())->where('meeting_number', $meeting->meeting_number)->exists())
                        @php
                            $scoreData = App\Models\ToeflReadingScore::where('user_id', Auth::id())->where('meeting_number', $meeting->meeting_number)->latest()->first();
                        @endphp
                        <div class="bg-gray-50 rounded-2xl p-6 mb-6 border border-gray-100">
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-wider mb-2">Your TOEFL Score</p>
                            <div class="text-5xl font-extrabold text-blue-600 mb-2">{{ number_format($scoreData->score, 0) }}</div>
                            <p class="text-gray-600">{{ $scoreData->correct_count }} of {{ $scoreData->total_questions }} correct</p>
                        </div>
                    @else
                        <div class="p-4 bg-blue-50 text-blue-700 rounded-xl mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <button @click="show = false" class="w-full py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg">
                        Review Answers
                    </button>
                </div>
            </div>
            @endif

            <!-- Split View Container -->
            <div class="flex-1 flex flex-col md:flex-row overflow-hidden relative h-full" x-data="{ currentPassage: 0, totalPassages: {{ $passages->count() }} }">
                
                <!-- LEFT PANEL: READING PASSAGE -->
                <div class="w-full md:w-1/2 h-full overflow-y-auto custom-scroll p-6 bg-white border-r border-gray-200" id="reading-panel">
                    <div class="max-w-3xl mx-auto">
                        
                        <!-- Actions Header -->
                        <div class="flex flex-col gap-4 mb-6">
                            <!-- Directions -->
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <p class="font-bold text-sm">Directions:</p>
                                <p class="text-sm">Read the passages. Then choose the correct answer for each question.</p>
                            </div>

                            <!-- Skimming Controls -->
                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100" 
                                 x-data="{ 
                                    speed: 'normal', 
                                    isRunning: false,
                                    getDelay() {
                                        switch(this.speed) {
                                            case 'slow': return 300;
                                            case 'normal': return 150;
                                            case 'exam': return 80;
                                            default: return 150;
                                        }
                                    }
                                 }"
                                 @skimming-stop.window="isRunning = false"
                            >
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2 text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            <span class="text-sm font-bold">Skimming Mode:</span>
                                        </div>
                                        <select x-model="speed" :disabled="isRunning" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-1 pl-2 pr-8">
                                            <option value="slow">Rendah (Low)</option>
                                            <option value="normal">Normal</option>
                                            <option value="exam">Ujian (Exam)</option>
                                        </select>
                                    </div>
                                    <button 
                                        @click="
                                            isRunning = !isRunning; 
                                            $dispatch('toggle-skimming', { speed: getDelay(), active: isRunning });
                                        "
                                        :class="isRunning ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-600 hover:bg-blue-700'"
                                        class="px-4 py-1.5 text-white text-sm font-bold rounded-md transition shadow-sm flex items-center gap-2 min-w-[140px] justify-center"
                                    >
                                        <span x-show="!isRunning" class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Start Skimming
                                        </span>
                                        <span x-show="isRunning" class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                                            Stop
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        @foreach($passages as $index => $passage)
                        <div class="mb-10 text-gray-800 leading-relaxed text-justify text-lg font-serif"
                             x-show="currentPassage === {{ $index }}"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-x-4"
                             x-transition:enter-end="opacity-100 transform translate-x-0"
                        >
                            <div class="relative group pb-16" 
                                 x-data="{ 
                                    translateMode: false, 
                                    originalContent: `{{ $passage->content }}`, // Backup for translation
                                    passageTranslation: `{{ addslashes($passage->indonesian_translation ?? '') }}`,
                                    skimmingHelper: {
                                        originalHTML: '',
                                        interval: null,
                                        active: false
                                    },
                                    initSkimming(speed) {
                                        if (this.skimmingHelper.active) {
                                            this.stopSkimming();
                                            return;
                                        }
                                        
                                        const container = this.$refs.passageContent;
                                        if (!this.skimmingHelper.originalHTML) {
                                            this.skimmingHelper.originalHTML = container.innerHTML;
                                        }

                                        // Process text nodes to wrap words
                                        const processNodes = (root) => {
                                            const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null, false);
                                            const nodes = [];
                                            let node;
                                            while(node = walker.nextNode()) nodes.push(node);
                                            
                                            nodes.forEach(n => {
                                                if(n.textContent.trim().length === 0) return;
                                                const words = n.textContent.split(/(\s+)/); // Keep delimiters
                                                const startSpan = document.createElement('span');
                                                
                                                words.forEach(word => {
                                                    if(word.trim().length === 0) {
                                                        startSpan.appendChild(document.createTextNode(word));
                                                    } else {
                                                        const s = document.createElement('span');
                                                        s.textContent = word;
                                                        s.className = 'skimming-word transition-opacity duration-500';
                                                        startSpan.appendChild(s);
                                                    }
                                                });
                                                n.parentNode.replaceChild(startSpan, n);
                                            });
                                        };

                                        processNodes(container);
                                        this.skimmingHelper.active = true;

                                        // Start animation
                                        const words = container.querySelectorAll('.skimming-word');
                                        let i = 0;
                                        this.skimmingHelper.interval = setInterval(() => {
                                            if (i >= words.length) {
                                                this.stopSkimming();
                                                this.$dispatch('skimming-stop'); // Reset button
                                                return;
                                            }
                                            words[i].style.opacity = '0.1'; // Fade out
                                            i++;
                                        }, speed);
                                    },
                                    stopSkimming() {
                                        if (this.skimmingHelper.interval) {
                                            clearInterval(this.skimmingHelper.interval);
                                        }
                                        if (this.skimmingHelper.originalHTML) {
                                            this.$refs.passageContent.innerHTML = this.skimmingHelper.originalHTML;
                                        }
                                        this.skimmingHelper.active = false;
                                    },
                                    // Scanning Feature
                                    highlightKeywords(data) {
                                        // 1. Reset first
                                        if (this.skimmingHelper.active) this.stopSkimming();
                                        // If we already have dirty HTML (from previous scan), reset it
                                        if (this.skimmingHelper.originalHTML) {
                                            this.$refs.passageContent.innerHTML = this.skimmingHelper.originalHTML;
                                        } else {
                                            this.skimmingHelper.originalHTML = this.$refs.passageContent.innerHTML;
                                        }

                                        if (!data || !data.matches || data.matches.length === 0) return;

                                        // 2. Highlight Matches
                                        const matches = data.matches.map(m => m.toLowerCase());
                                        const container = this.$refs.passageContent;
                                        
                                        // Simple walker to find text nodes
                                        const walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, null, false);
                                        const nodes = [];
                                        let node;
                                        while(node = walker.nextNode()) nodes.push(node);

                                        nodes.forEach(n => {
                                            const text = n.textContent;
                                            // Check if this node contains any of the matches
                                            // This is a naive implementation; for better results use regex with word boundaries
                                            let hasMatch = false;
                                            matches.forEach(m => {
                                                if (text.toLowerCase().includes(m)) hasMatch = true;
                                            });

                                            if (hasMatch) {
                                                const span = document.createElement('span');
                                                // We need to preserve the text structure. 
                                                // Replace matching phrases with styled spans.
                                                // Sort matches by length desc to handle overlapping phrases
                                                const sortedMatches = [...matches].sort((a, b) => b.length - a.length);
                                                
                                                let newHTML = text;
                                                sortedMatches.forEach(m => {
                                                    // Escape regex special chars
                                                    const escaped = m.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                                                    const regex = new RegExp(`\\b(${escaped})\\b`, 'gi');
                                                    newHTML = newHTML.replace(regex, '<span class=\'bg-purple-200 text-purple-900 font-bold px-0.5 rounded transition-all duration-300 scale-110 shadow-sm border border-purple-300\'>$1</span>');
                                                });
                                                
                                                span.innerHTML = newHTML;
                                                n.parentNode.replaceChild(span, n);
                                            }
                                        });
                                    }
                                 }"
                                 @toggle-skimming.window="
                                    if (currentPassage === {{ $index }}) {
                                        if ($event.detail.active) {
                                            initSkimming($event.detail.speed);
                                        } else {
                                            stopSkimming();
                                        }
                                    }
                                 "
                                 @scan-keywords.window="
                                    if (currentPassage === {{ $index }}) {
                                        highlightKeywords($event.detail);
                                    }
                                 "
                            >
                                <div class="flex justify-between items-center mb-4 border-b pb-2">
                                     <div class="flex items-center gap-3">
                                        <h3 class="font-bold text-gray-400 uppercase tracking-wider text-sm">Passage {{ $passage->passage_number }}</h3>
                                         </div>
                                </div>
                                
                                <!-- Translate Toggle -->
                                <button 
                                    @click="translateMode = !translateMode; toggleTranslate($el.parentElement, translateMode, originalContent, passageTranslation)"
                                    class="absolute bottom-4 right-4 w-10 h-10 flex items-center justify-center rounded-full transition-all z-20 shadow-md border border-gray-200 hover:scale-105"
                                    :class="translateMode ? 'bg-yellow-400 text-white border-yellow-500 ring-2 ring-yellow-200' : 'bg-white text-gray-400 hover:text-yellow-500 hover:border-yellow-400'"
                                    title="Translate Mode"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>

                                <div x-ref="passageContent" class="passage-content pl-16 relative text-lg leading-7" :class="translateMode ? 'cursor-help' : ''">
                                    {!! $passage->content !!}
                                </div>
                                <div class="h-12"></div> <!-- Spacer to prevent button overlap -->
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- RIGHT PANEL: QUESTIONS -->
                <form action="{{ route('assignments.toefl-itp.reading.submit') }}" method="POST" class="w-full md:w-1/2 h-full flex flex-col bg-[#F9FAFB]" id="questions-panel">
                    @csrf
                    <input type="hidden" name="meeting_number" value="{{ $meeting->meeting_number }}">
                    
                    <!-- Scrollable Questions Area -->
                    <div class="flex-1 overflow-y-auto custom-scroll p-6">
                        <div class="max-w-2xl mx-auto space-y-8">
                            @foreach($passages as $index => $passage)
                                <div x-show="currentPassage === {{ $index }}" class="space-y-8">
                                @foreach($passage->questions as $question)
                                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative group" x-data="{ selected: null }">
                                    
    

                                    <div class="flex gap-4 items-start relative group/question">
                                    <!-- Admin Controls -->
                                    @if(Auth::user() && Auth::user()->isAdmin())
                                    <div class="absolute top-2 right-2 z-20">
                                        <button type="button" onclick='openEditQuestionModal(@json($question))' class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition shadow-sm" title="Edit Question">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                    </div>
                                    @endif

    
                                <div class="flex flex-col gap-2 items-center">
                                    <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 font-bold rounded-lg text-sm">
                                        {{ $question->question_number }}
                                    </span>
                                    
                                    @if(!empty($question->keywords) && !empty($question->keywords['keywords']))
                                    <button 
                                        type="button"
                                        class="absolute right-0 top-0 text-[10px] bg-purple-100 text-purple-700 px-2 py-1 rounded hover:bg-purple-200 transition-all duration-300 font-bold uppercase tracking-wider flex items-center gap-1 opacity-30 hover:opacity-100"
                                        @click="$dispatch('scan-keywords', { matches: {{ json_encode($question->keywords['matches'] ?? []) }} }); $dispatch('highlight-question', { id: {{ $question->id }}, keywords: {{ json_encode($question->keywords['keywords'] ?? []) }} })"
                                        title="Scan for Keywords"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <span>Scan</span>
                                    </button>
                                    @endif
                                </div>
                                
                                <div class="flex-1" 
                                     @highlight-question.window="
                                        if ($event.detail.id === {{ $question->id }}) {
                                           // Toggle Question Highlighting
                                           const keywords = $event.detail.keywords;
                                           const container = $el.querySelector('.question-text');
                                           if (container.dataset.original) {
                                               container.innerHTML = container.dataset.original;
                                               delete container.dataset.original;
                                           } else {
                                               container.dataset.original = container.innerHTML;
                                               let html = container.innerHTML;
                                               keywords.forEach(k => {
                                                   const escaped = k.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                                                   const regex = new RegExp(`\\b(${escaped})\\b`, 'gi');
                                                   html = html.replace(regex, '<span class=\'bg-purple-200 text-purple-900 font-bold px-1 rounded\'>$1</span>');
                                               });
                                               container.innerHTML = html;
                                           }
                                        } else {
                                           // Clear other questions
                                           const container = $el.querySelector('.question-text');
                                           if (container && container.dataset.original) {
                                               container.innerHTML = container.dataset.original;
                                               delete container.dataset.original;
                                           }
                                        }
                                     ">
                                            <p class="font-medium text-gray-800 text-lg question-text">{{ $question->question_text }}</p>
                                        </div>
                                    </div>

                                    @php
                                        $hasOptions = !empty($question->option_a) || !empty($question->option_b) || !empty($question->option_c) || !empty($question->option_d);
                                    @endphp

                                    @if($hasOptions)
                                    <div class="grid grid-cols-1 gap-3 pl-0 md:pl-0 mt-4">
                                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                                            @php $optionText = $question->{'option_'.$opt}; @endphp
                                            @if($optionText)
                                            <label class="flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 group bg-white shadow-sm hover:bg-gray-50"
                                                :class="selected === '{{ strtoupper($opt) }}' ? 'border-red-500 bg-red-50 ring-1 ring-red-200' : 'border-gray-100 hover:border-gray-200'"
                                            >
                                                <input type="radio" 
                                                    name="question_{{ $question->id }}" 
                                                    value="{{ strtoupper($opt) }}" 
                                                    class="hidden"
                                                    x-model="selected"
                                                >
                                                
                                                <!-- Circle Indicator -->
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm mr-4 transition-all duration-200 shrink-0"
                                                    :class="selected === '{{ strtoupper($opt) }}' ? 'bg-red-600 text-white shadow-md scale-110' : 'bg-gray-100 text-gray-400 group-hover:bg-gray-200'"
                                                >
                                                    {{ strtoupper($opt) }}
                                                </div>

                                                <span class="text-lg font-medium transition-colors duration-200 leading-relaxed" 
                                                    :class="selected === '{{ strtoupper($opt) }}' ? 'text-red-700 font-semibold' : 'text-gray-700'"
                                                >
                                                    {{ $optionText }}
                                                </span>
                                            </label>
                                            @endif
                                        @endforeach
                                    </div>
                                    @else
                                        <div class="pl-12">
                                            <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Type your answer...">
                                        </div>
                                    @endif
                                </div>
                                @endforeach
                                
    
                                </div>
                            @endforeach
                            <!-- Navigation Buttons (Inline) -->
                            <div class="flex justify-between items-center mt-8 pt-8 border-t border-gray-100">
                                <!-- PREVIOUS -->
                                <button 
                                    type="button"
                                    @click="currentPassage--" 
                                    :disabled="currentPassage === 0"
                                    class="flex items-center gap-2 px-6 py-3 rounded-xl font-bold transition-all"
                                    :class="currentPassage === 0 ? 'bg-gray-100 text-gray-300 cursor-not-allowed' : 'bg-white text-gray-700 shadow-sm hover:bg-gray-50 border border-gray-200'"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    Previous
                                </button>

                                <!-- NEXT / SUBMIT -->
                                <div>
                                    <button 
                                        type="button"
                                        x-show="currentPassage < totalPassages - 1"
                                        @click="currentPassage++"
                                        class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1"
                                    >
                                        Next Passage
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>

                                    <button 
                                        x-show="currentPassage === totalPassages - 1"
                                        type="submit"
                                        class="flex items-center gap-2 px-8 py-3 bg-green-600 text-white rounded-xl font-bold shadow-lg hover:bg-green-700 transition transform hover:-translate-y-1"
                                    >
                                        Submit Answers
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </main>
    </div>

    <!-- REUSE MODALS AND SCRIPTS FROM ORIGINAL VIEW -->
    <!-- Edit Question Modal -->
    <div id="editQuestionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
        <div class="bg-white rounded-2xl p-8 w-full max-w-2xl mx-4 my-8 relative">
            <button onclick="document.getElementById('editQuestionModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Question</h3>
            <form id="editQuestionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-4 gap-4 mb-4">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">No.</label>
                        <input type="number" id="edit_question_number" name="question_number" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div class="col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                        <input type="text" id="edit_question_text" name="question_text" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="space-y-4 mb-6" id="edit_options_section">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option A</label>
                            <input type="text" id="edit_option_a" name="option_a" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option B</label>
                            <input type="text" id="edit_option_b" name="option_b" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option C</label>
                            <input type="text" id="edit_option_c" name="option_c" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Option D (Optional)</label>
                            <input type="text" id="edit_option_d" name="option_d" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                    <select id="edit_correct_answer_select" name="correct_answer" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
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
    <!-- Dictionary Popup -->
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
        
        <div id="def_context_container" class="mb-3 hidden">
             <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Context</p>
             <p id="def_context_sentence" class="text-xs text-gray-700 italic border-l-2 border-yellow-400 pl-2"></p>
        </div>

        <div>
            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Synonyms</p>
            <p id="def_synonyms" class="text-sm text-gray-600"></p>
        </div>
    </div>



    <script>

        // Modal Scripts
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
            
            const selectInput = document.getElementById('edit_correct_answer_select');
            selectInput.value = question.correct_answer;
            
            document.getElementById('editQuestionModal').classList.remove('hidden');
        }
        // Translation Logic (Same as original)
        // Translation Logic
        function toggleTranslate(container, active, originalText, passageTranslation = '') {
            const contentDiv = container.querySelector('.passage-content');
            
            if (!active) {
                contentDiv.innerHTML = originalText;
                document.getElementById('definitionPopup').classList.add('hidden');
                return;
            }

            const transSentences = passageTranslation ? (passageTranslation.match(/[^.!?]+[.!?]+(\s+|$)|[^.!?]+$/g) || [passageTranslation]) : [];
            
            // Create a temporary container to parse the HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = originalText;

            // Helper to process text nodes
            function processNode(node, sentenceIndexObj) {
                if (node.nodeType === 3) { // Text node
                    const text = node.nodeValue;
                    // Split text into tokens (words and non-words)
                    const tokens = text.match(/([a-zA-Z0-9\-\']+|[^a-zA-Z0-9\-\'\s]+|\s+)/g);
                    
                    if (tokens) {
                        const fragment = document.createDocumentFragment();
                        tokens.forEach(token => {
                            if (/^[a-zA-Z0-9\-\']+$/.test(token)) {
                                const span = document.createElement('span');
                                span.className = "cursor-pointer hover:bg-yellow-200 hover:text-yellow-800 rounded px-0.5 transition-colors border-b border-dashed border-gray-400";
                                span.textContent = token;
                                
                                const cleanWord = token.replace(/'/g, "\\'");
                                // Get current sentence translation roughly based on index (simplified)
                                // A robust mapping requires sentence alignment, but we stick to sequential index
                                const transSentenceSafe = transSentences[sentenceIndexObj.index] ? transSentences[sentenceIndexObj.index].trim().replace(/'/g, "\\'").replace(/"/g, '&quot;') : '';
                                
                                span.setAttribute('onclick', `lookupWord('${cleanWord}', event, ${sentenceIndexObj.index}, '${transSentenceSafe}')`);
                                fragment.appendChild(span);
                            } else {
                                fragment.appendChild(document.createTextNode(token));
                                if (/[.!?]/.test(token)) {
                                    sentenceIndexObj.index++;
                                }
                            }
                        });
                        node.parentNode.replaceChild(fragment, node);
                    }
                } else if (node.nodeType === 1) { // Element node
                    // Recursively process child nodes
                    Array.from(node.childNodes).forEach(child => processNode(child, sentenceIndexObj));
                }
            }

            let sentenceIndexObj = { index: 0 };
            Array.from(tempDiv.childNodes).forEach(node => processNode(node, sentenceIndexObj));

            contentDiv.innerHTML = tempDiv.innerHTML;
        }

        async function lookupWord(word, event, sentenceIndex, contextSentence) {
            event.stopPropagation();
            
            const popup = document.getElementById('definitionPopup');
            const cleanWord = word.replace(/[^a-zA-Z0-9\-\']/g, '').toLowerCase();

            // Adjusted positioning for split view
            let x = event.pageX;
            let y = event.pageY + 15;
            
            // Boundary checks
            if (x + 300 > window.innerWidth) {
                x = window.innerWidth - 320;
            }

            popup.style.top = `${y}px`;
            popup.style.left = `${x}px`;
            
            document.getElementById('def_word').innerText = cleanWord;
            document.getElementById('def_translation').innerText = 'Loading...';
            document.getElementById('def_synonyms').innerText = '...';
            
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
                    document.getElementById('def_translation').innerText = 'Not found';
                    document.getElementById('def_synonyms').innerText = '-';
                }
            } catch (error) {
                console.error('Dictionary error:', error);
                document.getElementById('def_translation').innerText = 'Error';
            }
        }
    </script>
</body>
</html>
