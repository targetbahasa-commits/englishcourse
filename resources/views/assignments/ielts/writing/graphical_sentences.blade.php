@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="graphicalSentences({{ $meeting->id }})">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => 1]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-teal-600 tracking-wider uppercase">IELTS Writing Task 1</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ $meeting->title }}</h1>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-32 w-full">
        <!-- Left Column: Reference (Sticky) -->
        <div class="lg:col-span-5 sticky top-6 self-start space-y-6 max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            
            <!-- Theory Box 1: What are Graphical Sentences? -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-teal-50 px-6 py-4 border-b border-teal-100">
                    <h2 class="text-lg font-bold text-teal-900">What are Graphical Sentences?</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-4 text-sm leading-relaxed">
                    <p>
                        A <strong>graphical sentence</strong> is a single sentence that describes the main trend, pattern, or key feature shown in a graph, chart, diagram or map.
                    </p>
                    <p>
                        In IELTS Writing Task 1, you must write:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li><strong>Overview sentences</strong> at the start (summarizing overall trends)</li>
                        <li><strong>Descriptive sentences</strong> in body paragraphs (explaining specific data)</li>
                    </ul>
                    <p class="bg-blue-50 p-3 rounded border border-blue-100 text-blue-900 italic">
                        A good graphical sentence is clear, concise, and uses appropriate vocabulary for describing trends and changes.
                    </p>
                </div>
            </div>

            <!-- Theory Box 2: Basic Structure -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-teal-50 px-6 py-4 border-b border-teal-100">
                    <h2 class="text-lg font-bold text-teal-900">Basic Sentence Structure</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-3 text-sm leading-relaxed">
                    <div class="bg-indigo-50 p-3 rounded border border-indigo-100">
                        <p class="font-bold text-indigo-900 mb-2">Subject + Verb + Preposition/Object</p>
                        <p class="text-indigo-800">The unemployment rate <strong>rose</strong> <strong>from</strong> 5% <strong>to</strong> 10%.</p>
                    </div>
                    
                    <div class="bg-green-50 p-3 rounded border border-green-100">
                        <p class="font-bold text-green-900 mb-2">Subject + Verb + Object + Prepositional Phrase</p>
                        <p class="text-green-800">Cell phone usage increased significantly <strong>between 2000 and 2010</strong>.</p>
                    </div>

                    <div class="bg-orange-50 p-3 rounded border border-orange-100">
                        <p class="font-bold text-orange-900 mb-2">There + Verb Structure</p>
                        <p class="text-orange-800"><strong>There was</strong> a sharp decline in vehicle sales.</p>
                    </div>
                </div>
            </div>

            <!-- Theory Box 3: Key Trends Vocabulary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-teal-50 px-6 py-4 border-b border-teal-100">
                    <h2 class="text-lg font-bold text-teal-900">Trend Vocabulary</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-2 text-sm leading-relaxed">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="font-bold text-red-600 mb-1">🔴 Increasing:</p>
                            <ul class="text-xs space-y-1 text-gray-600">
                                <li>• rise, increase, grow</li>
                                <li>• surge, leap</li>
                                <li>• upward trend</li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-bold text-blue-600 mb-1">🔵 Decreasing:</p>
                            <ul class="text-xs space-y-1 text-gray-600">
                                <li>• fall, decrease, drop</li>
                                <li>• decline, plunge</li>
                                <li>• downward trend</li>
                            </ul>
                        </div>
                    </div>
                    <div class="pt-2 border-t">
                        <p class="font-bold text-gray-700 mb-1">🟡 Stable/Stable:</p>
                        <ul class="text-xs space-y-1 text-gray-600">
                            <li>• remain stable, flatten</li>
                            <li>• level off, plateau</li>
                            <li>• stay constant, stabilize</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Practice -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- Exercise 1: Identifying Key Trends -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Exercise 1: Matching Trends to Descriptions</h3>
                    <p class="text-sm text-gray-600 mt-1">Match each trend vocabulary word with its correct description.</p>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(item, idx) in exercises1" :key="idx">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-start gap-3">
                                <span class="flex-shrink-0 text-lg font-bold text-teal-600" x-text="idx + 1"></span>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800" x-text="item.word"></p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span x-text="item.meaning" class="italic text-blue-600"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Exercise 2: Correcting Sentences -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Exercise 2: Identify Correct Graphical Sentences</h3>
                    <p class="text-sm text-gray-600 mt-1">Read these sentences and identify which ones are correctly written.</p>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(item, idx) in exercises2" :key="idx">
                        <div :class="'p-4 rounded-lg border-2 transition-colors cursor-pointer',
                             item.correct ? 'bg-green-50 border-green-300 hover:bg-green-100' : 'bg-red-50 border-red-300 hover:bg-red-100'">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900" x-text="item.sentence"></p>
                                    <p class="text-sm mt-2" :class="item.correct ? 'text-green-700' : 'text-red-700'" x-text="item.correct ? '✓ Correct' : '✗ Incorrect'"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Exercise 3: Write Your Own -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Exercise 3: Write Graphical Sentences</h3>
                    <p class="text-sm text-gray-600 mt-1">Write one sentence to describe each trend below.</p>
                </div>
                <div class="p-6 space-y-6">
                    <template x-for="(item, idx) in exercises3" :key="idx">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <label class="block mb-3">
                                <p class="font-bold text-gray-800" x-text="(idx + 1) + '. ' + item.prompt"></p>
                                <p class="text-xs text-gray-500 mt-1" x-text="'Hint: ' + item.hint"></p>
                            </label>
                            <textarea 
                                x-model="userAnswers[idx]"
                                :placeholder="'Write a complete sentence...'"
                                class="w-full h-20 p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:outline-none transition-all resize-none text-sm">
                            </textarea>
                        </div>
                    </template>
                    
                    <div class="flex gap-3 pt-4">
                        <button @click="submit()" :disabled="loading" class="flex-1 px-6 py-3 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700 transition-colors disabled:opacity-50">
                            <span x-show="!loading">Submit Answers</span>
                            <span x-show="loading">Saving...</span>
                        </button>
                        <button @click="checkAnswers()" class="flex-1 px-6 py-3 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition-colors">
                            Check My Answers
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine Data for the page -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('graphicalSentences', (meetingId) => ({
            userAnswers: {},
            loading: false,
            exercises1: [
                { word: 'Rise/Increase/Grow', meaning: 'The value went up or became higher' },
                { word: 'Fall/Decrease/Drop', meaning: 'The value went down or became lower' },
                { word: 'Remain stable/Flatten', meaning: 'The value stayed the same with little or no change' },
                { word: 'Surge/Leap', meaning: 'The value went up suddenly and dramatically' },
                { word: 'Decline/Plunge', meaning: 'The value went down sharply and significantly' },
                { word: 'Level off/Plateau', meaning: 'The value stopped changing after a period of growth or decline' },
            ],
            exercises2: [
                { sentence: 'Coffee consumption rose from 20% to 35% between 2000 and 2015.', correct: true },
                { sentence: 'The unemployment are increased significantly.', correct: false },
                { sentence: 'There was a sharp decline in vehicle sales.', correct: true },
                { sentence: 'Internet usage grew rapidly during the 1990s.', correct: true },
                { sentence: 'Oil prices falling gradually.', correct: false },
                { sentence: 'Temperatures remained stable throughout the year.', correct: true },
            ],
            exercises3: [
                { prompt: 'Describe what happened to fossil fuel consumption from 2005 to 2020', hint: 'It increased significantly' },
                { prompt: 'Describe what happened to printed book sales from 2010 to 2023', hint: 'It decreased steadily' },
                { prompt: 'Describe what happened to renewable energy usage over the past decade', hint: 'It grew rapidly' },
            ],
            init() {
                if (window.AutoSave) {
                    window.AutoSave.init(meetingId, '{{ Auth::id() }}');
                }
            },
            submit() {
                this.loading = true;
                const key = 'graphical_sentences_autosave_' + meetingId;
                localStorage.setItem(key, JSON.stringify(this.userAnswers));
                
                setTimeout(() => {
                    this.loading = false;
                    alert('Your answers have been saved!');
                }, 1000);
            },
            checkAnswers() {
                alert('Your answers have been recorded. Continue practicing to improve your sentence structure!');
            }
        }))
    })
</script>
@include('assignments.ielts.writing.practice_toolbar')
@endsection
