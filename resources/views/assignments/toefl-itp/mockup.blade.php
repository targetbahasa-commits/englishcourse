@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ currentView: 'section1', currentSection: 'instructions', currentListeningPart: 'A' }">
    <style>
        body {
            background-color: white !important;
        }
        .instruction-box {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            border-left: 6px solid #f59e0b;
        }
        .part-header {
            color: #0f766e;
            font-weight: 700;
        }
    </style>

    <!-- Audio Player -->
    @include('assignments.toefl-itp.listening.partials.audio-player')

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">TOEFL ITP Mock Up Test</h1>
                    <p class="text-gray-600 mt-1">Section 1: Listening Comprehension</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.toefl-itp') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to TOEFL ITP
            </a>
        </div>
    </div>

    <!-- Instructions Section -->
    <div x-show="currentSection === 'instructions'" class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Section Header -->
        <div class="instruction-box text-white p-6">
            <h2 class="text-2xl font-bold mb-2">Section 1: Listening Comprehension</h2>
            <p class="text-teal-50">Time: Approximately 35 minutes | 50 Questions</p>
        </div>

        <!-- Instructions Content -->
        <div class="p-8 space-y-6">
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed">
                    In this section of the test, you will have an opportunity to demonstrate your ability to understand conversations and talks in English. There are <strong>3 parts</strong> to this section, with special directions for each part. Answer all the questions on the basis of what is stated or implied by the speakers in this test.
                </p>
            </div>

            <!-- Part A Instructions -->
            <div class="border-l-4 border-teal-600 pl-6 py-4 bg-teal-50">
                <h3 class="part-header text-2xl mb-4">Part A</h3>
                
                <div class="space-y-4 text-gray-700">
                    <p><strong>Directions:</strong> In Part A, you will hear short conversations between 2 people. After each conversation, you will hear a question about the conversation. The conversations and questions will not be repeated. After you hear a question, read the 4 possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</p>
                    
                    <div class="bg-white p-6 rounded-lg border border-teal-200 mt-4">
                        <p class="font-semibold text-gray-800 mb-3">Here is an example:</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-2">On the recording, you hear:</p>
                                <div class="bg-gray-50 p-4 rounded italic text-gray-700 mb-4">
                                    <p class="mb-2">(Man) That exam was just awful.</p>
                                    <p class="mb-2">(Woman) Oh, it could have been worse.</p>
                                    <p class="font-semibold">(Narrator) What does the woman mean?</p>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-2">In your test book, you read:</p>
                                <div class="space-y-2">
                                    <div class="flex items-start gap-2">
                                        <span class="font-semibold">(A)</span>
                                        <span>The exam was really awful.</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="font-semibold">(B)</span>
                                        <span>It was the worst exam she had ever seen.</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="font-semibold">(C)</span>
                                        <span>It couldn't have been more difficult.</span>
                                    </div>
                                    <div class="flex items-start gap-2 bg-teal-100 p-2 rounded">
                                        <span class="font-semibold">(D)</span>
                                        <span><strong>The exam wasn't that bad.</strong></span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 p-3 bg-blue-50 rounded text-sm">
                                    <p class="text-blue-900">The best answer to the question "What does the woman mean?" is (D), "The exam wasn't that bad." Therefore, the correct choice is (D).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ready Button -->
            <div class="flex justify-center pt-6">
                <button @click="currentSection = 'questions'" 
                        style="background: linear-gradient(to right, #0f766e, #0d9488) !important; color: white !important;"
                        class="px-8 py-4 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <span class="flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Now Begin Work on the Questions
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Questions Section (Part A) -->
    <div x-show="currentSection === 'questions'" class="bg-white rounded-2xl shadow-lg p-8">
        <div class="mb-6">
            <template x-if="currentListeningPart === 'A'">
                <div>
                    <h2 class="text-2xl font-bold text-teal-700 mb-2">Part A - Questions 1-30</h2>
                    <p class="text-gray-600">Short Conversations</p>
                </div>
            </template>
            <template x-if="currentListeningPart === 'B'">
                <div>
                    <h2 class="text-2xl font-bold text-purple-700 mb-2">Part B - Questions 31-37</h2>
                    <p class="text-gray-600">Longer Conversations</p>
                </div>
            </template>
            <template x-if="currentListeningPart === 'C'">
                <div>
                    <h2 class="text-2xl font-bold text-indigo-700 mb-2">Part C - Questions 38-50</h2>
                    <p class="text-gray-600">Talks and Lectures</p>
                </div>
            </template>
        </div>

        <form method="POST" action="#" class="space-y-8">
            @csrf
            
            
            <!-- Part A Content -->
            <div x-show="currentListeningPart === 'A'">
                @if($listeningPartA->count() > 0)
                    @php
                        $splitIndex = ceil($listeningPartA->count() / 2);
                    @endphp
                    
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 relative">
                            {{-- Column 1 --}}
                            <div class="space-y-0 divide-y divide-gray-100">
                                @foreach($listeningPartA->slice(0, $splitIndex) as $question)
                                    <div class="py-3 group transition-colors hover:bg-gray-50/50 rounded-lg px-2 -mx-2">
                                        <div class="flex items-baseline gap-3">
                                            <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
                                            </div>
                                            <div class="flex flex-col gap-3 flex-1">
                                                <div class="mb-3 text-lg text-gray-800 font-medium pl-1">
                                                    {{ $question->question_text }}
                                                </div>

                                                <div class="space-y-3">
                                                    @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                        <label class="group/option block w-full cursor-pointer">
                                                            <input type="radio" 
                                                                   name="question_{{ $question->id }}" 
                                                                   value="{{ $option }}" 
                                                                   class="peer sr-only"
                                                                   required>
                                                            
                                                            <div class="flex items-center p-3 rounded-xl border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                <div class="flex items-center justify-center mr-4 flex-none">
                                                                    <div class="w-10 h-10 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                        <span class="text-sm font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <span class="text-lg text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Column 2 --}}
                            <div class="space-y-0 divide-y divide-gray-100">
                                @foreach($listeningPartA->slice($splitIndex) as $question)
                                    <div class="py-3 group transition-colors hover:bg-gray-50/50 rounded-lg px-2 -mx-2">
                                        <div class="flex items-baseline gap-3">
                                            <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
                                            </div>
                                            <div class="flex flex-col gap-3 flex-1">
                                                <div class="mb-3 text-lg text-gray-800 font-medium pl-1">
                                                    {{ $question->question_text }}
                                                </div>

                                                <div class="space-y-3">
                                                    @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                        <label class="group/option block w-full cursor-pointer">
                                                            <input type="radio" 
                                                                   name="question_{{ $question->id }}" 
                                                                   value="{{ $option }}" 
                                                                   class="peer sr-only"
                                                                   required>
                                                            
                                                            <div class="flex items-center p-3 rounded-xl border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                <div class="flex items-center justify-center mr-4 flex-none">
                                                                    <div class="w-10 h-10 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                        <span class="text-sm font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <span class="text-lg text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Buttons for Part A -->
                    <div class="flex justify-between mt-8">
                        <button type="button" @click="currentSection = 'instructions'; window.scrollTo(0,0)" 
                                class="flex items-center gap-2 px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Instructions
                        </button>

                        <button type="button" @click="currentListeningPart = 'B'; window.scrollTo(0,0)" 
                                class="flex items-center gap-2 px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg shadow-md transition-colors">
                            Next: Part B
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                @else
                    <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-gray-500 text-lg font-medium">No questions available</p>
                        <p class="text-gray-400 text-sm mt-2">Please run the seeder to add questions</p>
                    </div>
                @endif
            </div>

            <!-- Part B Questions (31-37) -->
            <!-- Part B Content -->
            <div x-show="currentListeningPart === 'B'">
                @if($listeningPartB->count() > 0)
                    <div class="mt-12 pt-8 border-t-4 border-purple-200">
                        <!-- Part B Directions -->
                        <div class="mb-6 p-6 bg-purple-50 border-l-4 border-purple-600 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-purple-700 mb-4">Part B</h3>
                            <div class="space-y-3 text-gray-700">
                                <p><strong>Directions:</strong> In this part of the test, you will hear longer conversations. After each conversation, you will hear several questions. The conversations and questions will not be repeated.</p>
                                <p>After you hear a question, read the 4 possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</p>
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-purple-700 mb-4">Questions 31-37</h3>
                        <p class="text-gray-600 mb-6">Longer Conversations</p>
                        
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 relative">
                                {{-- Column 1 --}}
                                <div class="space-y-0 divide-y divide-gray-100">
                                    @foreach($listeningPartB->take(4) as $question)
                                        <div class="py-3 group transition-colors hover:bg-gray-50/50 rounded-lg px-2 -mx-2">
                                            <div class="flex items-baseline gap-3">
                                                <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                    <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
                                                </div>
                                                <div class="flex flex-col gap-3 flex-1">
                                                    <div class="mb-3 text-lg text-gray-800 font-medium pl-1">
                                                        {!! nl2br(e($question->question_text)) !!}
                                                    </div>

                                                    <div class="space-y-3">
                                                        @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                            <label class="group/option block w-full cursor-pointer">
                                                                <input type="radio" 
                                                                       name="question_{{ $question->id }}" 
                                                                       value="{{ $option }}" 
                                                                       class="peer sr-only"
                                                                       required>
                                                                
                                                                <div class="flex items-center p-3 rounded-xl border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                    <div class="flex items-center justify-center mr-4 flex-none">
                                                                        <div class="w-10 h-10 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                            <span class="text-sm font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <span class="text-lg text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Vertical Divider --}}
                                <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-px bg-gray-200 -ml-px"></div>

                                {{-- Column 2 --}}
                                <div class="space-y-0 divide-y divide-gray-100">
                                    @foreach($listeningPartB->skip(4) as $question)
                                        <div class="py-3 group transition-colors hover:bg-gray-50/50 rounded-lg px-2 -mx-2">
                                            <div class="flex items-baseline gap-3">
                                                <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                    <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
                                                </div>
                                                <div class="flex flex-col gap-3 flex-1">
                                                    <div class="mb-3 text-lg text-gray-800 font-medium pl-1">
                                                        {!! nl2br(e($question->question_text)) !!}
                                                    </div>

                                                    <div class="space-y-3">
                                                        @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                            <label class="group/option block w-full cursor-pointer">
                                                                <input type="radio" 
                                                                       name="question_{{ $question->id }}" 
                                                                       value="{{ $option }}" 
                                                                       class="peer sr-only"
                                                                       required>
                                                                
                                                                <div class="flex items-center p-3 rounded-xl border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                    <div class="flex items-center justify-center mr-4 flex-none">
                                                                        <div class="w-10 h-10 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                            <span class="text-sm font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <span class="text-lg text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Buttons for Part B -->
                    <div class="flex justify-between mt-8">
                        <button type="button" @click="currentListeningPart = 'A'; window.scrollTo(0,0)" 
                                class="flex items-center gap-2 px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back: Part A
                        </button>
                        
                        <button type="button" @click="currentListeningPart = 'C'; window.scrollTo(0,0)" 
                                class="flex items-center gap-2 px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-md transition-colors">
                            Next: Part C
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Part C Questions (38-50) -->
            <!-- Part C Content -->
            <div x-show="currentListeningPart === 'C'">
                @if($listeningPartC->count() > 0)
                    <div class="mt-12 pt-8 border-t-4 border-indigo-200">
                        <!-- Part C Directions -->
                        <div class="mb-6 p-6 bg-indigo-50 border-l-4 border-indigo-600 rounded-r-lg">
                            <h3 class="text-2xl font-bold text-indigo-700 mb-4">Part C</h3>
                            <div class="space-y-3 text-gray-700">
                                <p><strong>Directions:</strong> In this part of the test, you will hear several short talks. After each talk, you will hear some questions. The talks and questions will not be repeated.</p>
                                <p>After you hear a question, read the 4 possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</p>
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-indigo-700 mb-4">Questions 38-50</h3>
                        <p class="text-gray-600 mb-6">Talks and Lectures</p>
                        
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 relative">
                                {{-- Column 1 --}}
                                <div class="space-y-0 divide-y divide-gray-100">
                                    @php
                                        $splitIndex = ceil($listeningPartC->count() / 2);
                                    @endphp
                                    @foreach($listeningPartC->slice(0, $splitIndex) as $question)
                                        <div class="py-3 group transition-colors hover:bg-gray-50/50 rounded-lg px-2 -mx-2">
                                            <div class="flex items-baseline gap-3">
                                                <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                    <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
                                                </div>
                                                <div class="flex flex-col gap-3 flex-1">
                                                    <div class="mb-3 text-lg text-gray-800 font-medium pl-1">
                                                        {!! nl2br(e($question->question_text)) !!}
                                                    </div>

                                                    <div class="space-y-3">
                                                        @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                            <label class="group/option block w-full cursor-pointer">
                                                                <input type="radio" 
                                                                       name="question_{{ $question->id }}" 
                                                                       value="{{ $option }}" 
                                                                       class="peer sr-only"
                                                                       required>
                                                                
                                                                <div class="flex items-center p-3 rounded-xl border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                    <div class="flex items-center justify-center mr-4 flex-none">
                                                                        <div class="w-10 h-10 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                            <span class="text-sm font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <span class="text-lg text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Vertical Divider --}}
                                <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-px bg-gray-200 -ml-px"></div>

                                {{-- Column 2 --}}
                                <div class="space-y-0 divide-y divide-gray-100">
                                    @foreach($listeningPartC->slice($splitIndex) as $question)
                                        <div class="py-3 group transition-colors hover:bg-gray-50/50 rounded-lg px-2 -mx-2">
                                            <div class="flex items-baseline gap-3">
                                                <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                    <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
                                                </div>
                                                <div class="flex flex-col gap-3 flex-1">
                                                    <div class="mb-3 text-lg text-gray-800 font-medium pl-1">
                                                        {!! nl2br(e($question->question_text)) !!}
                                                    </div>

                                                    <div class="space-y-3">
                                                        @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                            <label class="group/option block w-full cursor-pointer">
                                                                <input type="radio" 
                                                                       name="question_{{ $question->id }}" 
                                                                       value="{{ $option }}" 
                                                                       class="peer sr-only"
                                                                       required>
                                                                
                                                                <div class="flex items-center p-3 rounded-xl border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                    <div class="flex items-center justify-center mr-4 flex-none">
                                                                        <div class="w-10 h-10 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                            <span class="text-sm font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <span class="text-lg text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons for Part C -->
                    <div class="flex justify-between mt-8">
                        <button type="button" @click="currentListeningPart = 'B'; window.scrollTo(0,0)" 
                                class="flex items-center gap-2 px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back: Part B
                        </button>
                        
                        <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            Submit Answers
                        </button>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- ============================================ -->
    <!-- SECTION 2: STRUCTURE AND WRITTEN EXPRESSION -->
    <!-- ============================================ -->

    <!-- Section 2 Instructions -->
    <div x-show="currentView === 'section2' && currentSection === 'instructions'" class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Section Header -->
        <div class="instruction-box text-white p-6">
            <h2 class="text-2xl font-bold mb-2">Section 2: Structure and Written Expression</h2>
            <p class="text-teal-50">Time: 25 minutes | 40 Questions</p>
        </div>

        <!-- Instructions Content -->
        <div class="p-8 space-y-6">
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed">
                    This section is designed to measure your ability to recognize language that is appropriate for standard written English. There are <strong>2 types</strong> of questions in this section, with special directions for each type.
                </p>
            </div>

            <!-- Structure Instructions -->
            <div class="border-l-4 border-teal-600 pl-6 py-4 bg-teal-50">
                <h3 class="part-header text-2xl mb-4">Structure</h3>
                
                <div class="space-y-4 text-gray-700">
                    <p><strong>Directions:</strong> Questions 1-15 are incomplete sentences. Beneath each sentence you will see 4 words or phrases, marked (A), (B), (C) and (D). Choose the word or phrase that best completes the sentence. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</p>
                    
                    <div class="bg-white p-6 rounded-lg border border-teal-200 mt-4">
                        <p class="font-semibold text-gray-800 mb-3">Example:</p>
                        
                        <div class="mb-4">
                            <p class="text-gray-700 mb-3">Geysers have often been compared to volcanoes ______ they both emit hot liquids from below the Earth's surface.</p>
                            <div class="grid grid-cols-2 gap-2 ml-4">
                                <div>(A) due to</div>
                                <div>(B) because</div>
                                <div>(C) in spite of</div>
                                <div>(D) regardless of</div>
                            </div>
                        </div>
                        
                        <div class="p-3 bg-blue-50 rounded text-sm">
                            <p class="text-blue-900">The sentence should read, "Geysers have often been compared to volcanoes because they both emit hot liquids from beneath the Earth's surface." Therefore, the correct choice is (B).</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Written Expression Instructions -->
            <div class="border-l-4 border-orange-600 pl-6 py-4 bg-orange-50 mt-6">
                <h3 class="text-2xl font-bold text-orange-700 mb-4">Written Expression</h3>
                
                <div class="space-y-4 text-gray-700">
                    <p><strong>Directions:</strong> In questions 16-40, each sentence has 4 underlined words or phrases. The underlined parts of the sentence are marked (A), (B), (C) and (D). Identify the underlined word or phrase that must be changed in order for the sentence to be correct. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.</p>
                    
                    <div class="bg-white p-6 rounded-lg border border-orange-200 mt-4">
                        <p class="font-semibold text-gray-800 mb-3">Example:</p>
                        
                        <div class="mb-4">
                            <p class="text-gray-700 mb-3">Guppies are sometimes <u>call</u> rainbow fish <u>due to</u> the <u>bright</u> colors of <u>the males</u>.</p>
                            <div class="grid grid-cols-4 gap-2 ml-4 text-center">
                                <div>A</div>
                                <div>B</div>
                                <div>C</div>
                                <div>D</div>
                            </div>
                        </div>
                        
                        <div class="p-3 bg-blue-50 rounded text-sm">
                            <p class="text-blue-900">The sentence should read, "Guppies are sometimes called rainbow fish due to the bright colors of the males." Therefore, you should choose (A).</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ready Button -->
            <div class="flex justify-center pt-6">
                <button @click="currentSection = 'questions'" 
                        style="background: linear-gradient(to right, #0f766e, #0d9488) !important; color: white !important;"
                        class="px-8 py-4 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <span class="flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Now Begin Work on the Questions
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Section 2 Questions -->
    <div x-show="currentView === 'section2' && currentSection === 'questions'" class="bg-white rounded-2xl shadow-lg p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-teal-700 mb-2">Section 2: Structure and Written Expression</h2>
            <p class="text-gray-600">Questions 1-40</p>
        </div>

        <form method="POST" action="#" class="space-y-8">
            @csrf
            
            <!-- Structure Questions (1-15) -->
            @if($structureQuestions->count() > 0)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-teal-600 mb-4 pb-2 border-b-2 border-teal-200">Structure (Questions 1-15)</h3>
                    
                    <div class="space-y-6">
                        @foreach($structureQuestions as $question)
                            <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="flex-none">
                                        <span class="font-bold text-gray-600 text-lg">{{ $question->question_number }}.</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="mb-3 text-gray-800 text-lg">
                                            {!! nl2br(e($question->question_text)) !!}
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                <label class="flex items-center cursor-pointer p-2 hover:bg-red-50 rounded transition-colors has-[:checked]:bg-red-100 has-[:checked]:font-semibold border border-transparent has-[:checked]:border-blue-300">
                                                    <input type="radio" 
                                                           name="structure_{{ $question->id }}" 
                                                           value="{{ $option }}" 
                                                           class="mr-2"
                                                           required>
                                                    <span class="text-gray-700">{{ $text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Written Expression Questions (16-30) -->
            @if($writtenQuestions->count() > 0)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-orange-600 mb-4 pb-2 border-b-2 border-orange-200">Written Expression (Questions 16-30)</h3>
                    
                    <div class="space-y-6">
                        @foreach($writtenQuestions as $question)
                            <div class="p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="flex-none">
                                        <span class="font-bold text-gray-600 text-lg">{{ $question->question_number }}.</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="mb-3 text-gray-800 text-lg">
                                            {!! nl2br(e($question->question_text)) !!}
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                            @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                <label class="flex items-center justify-center cursor-pointer p-3 hover:bg-orange-200 rounded transition-colors has-[:checked]:bg-orange-300 has-[:checked]:font-bold border-2 border-transparent has-[:checked]:border-orange-500">
                                                    <input type="radio" 
                                                           name="written_{{ $question->id }}" 
                                                           value="{{ $option }}" 
                                                           class="sr-only peer"
                                                           required>
                                                    <span class="text-gray-700 text-lg font-semibold">({{ $option }})</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-between pt-6 border-t">
                <button type="button" @click="currentSection = 'instructions'" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition-colors duration-200">
                    ← Back to Instructions
                </button>
                <button type="submit" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    Submit Answers
                </button>
            </div>
        </form>
    </div>

    <!-- Section Navigation -->
    <div class="fixed bottom-8 right-8 flex gap-3 z-50">
        <button @click="currentView = 'section1'; currentSection = 'instructions'" 
                :class="currentView === 'section1' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600'"
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
            Section 1: Listening
        </button>
        <button @click="currentView = 'section2'; currentSection = 'instructions'" 
                :class="currentView === 'section2' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600'"
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
            Section 2: Structure
        </button>
    </div>
</div>

@include('assignments.toefl-itp.listening.partials.audio-player-scripts')
@endsection
