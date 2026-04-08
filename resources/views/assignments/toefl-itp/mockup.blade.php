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
        .listening-answer-sheet .divide-y > .group {
            padding-top: 0.125rem;
            padding-bottom: 0.125rem;
        }
        .listening-answer-sheet .group .mb-2.text-sm {
            font-size: 1.05rem;
            line-height: 1.35;
            margin-bottom: 0.2rem;
        }
        .listening-answer-sheet .group .space-y-2 > :not([hidden]) ~ :not([hidden]) {
            margin-top: 0.2rem;
        }
        .listening-answer-sheet .group .space-y-2 .p-2 {
            padding: 0.4rem 0.62rem;
        }
        .listening-answer-sheet .group .space-y-2 span.text-sm {
            font-size: 1.08rem;
            line-height: 1.32;
        }
        .listening-answer-sheet .bg-white.rounded-lg.border.border-gray-200.shadow-sm.p-4 {
            padding: 0.7rem;
        }
        .listening-answer-sheet .grid.grid-cols-1.md\:grid-cols-2.gap-4.md\:gap-6 {
            gap: 0.5rem;
        }
        .listening-answer-sheet .listening-option-card {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            min-height: 3.35rem;
            transition: border-color 0.16s ease, background-color 0.16s ease, box-shadow 0.16s ease, transform 0.12s ease;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card {
            transform: translateY(-1px);
            box-shadow: 0 3px 12px rgba(220, 38, 38, 0.16);
        }
        .listening-answer-sheet .listening-option-card::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 2.1rem;
            width: 6px;
            height: 6px;
            border-radius: 9999px;
            background: rgba(220, 38, 38, 0.22);
            transform: translate(-50%, -50%) scale(0);
            pointer-events: none;
            opacity: 0;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card::after {
            animation: listeningOptionRipple 0.34s ease-out;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card span.text-sm {
            color: #b91c1c;
        }
        .listening-answer-sheet .listening-option-badge {
            width: 2.32rem;
            height: 2.32rem;
            transform-origin: center;
            will-change: transform, box-shadow;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge {
            border-color: #dc2626;
            background-color: #dc2626;
            color: #ffffff;
            animation: listeningBadgePop 0.18s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge span {
            color: #ffffff;
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card {
            border-color: #e02424;
            background-color: #fff7f7;
            box-shadow: 0 0 0 1px rgba(224, 36, 36, 0.36), 0 3px 12px rgba(224, 36, 36, 0.14);
        }
        .listening-answer-sheet input[type="radio"]:checked + .listening-option-card span.text-sm {
            font-weight: 700;
            letter-spacing: 0.005em;
        }
        .listening-answer-sheet .listening-option-card .mr-3 {
            margin-right: 0.78rem;
        }
        .listening-answer-sheet .listening-option-card span.text-sm {
            padding-left: 0.1rem;
        }
        @keyframes listeningBadgePop {
            0% {
                transform: scale(0.82);
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.45);
            }
            65% {
                transform: scale(1.1);
                box-shadow: 0 0 0 8px rgba(220, 38, 38, 0.12);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
            }
        }
        @keyframes listeningOptionRipple {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 0.5;
            }
            100% {
                transform: translate(-50%, -50%) scale(42);
                opacity: 0;
            }
        }
        @media (max-width: 768px) {
            .listening-answer-sheet .group .space-y-2 .p-2 {
                padding: 0.32rem 0.5rem;
            }
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1rem;
                line-height: 1.28;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.05rem;
                height: 2.05rem;
            }
            .listening-answer-sheet .listening-option-card .mr-3 {
                margin-right: 0.58rem;
            }
            .listening-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge {
                animation-duration: 0.14s;
            }
            .listening-answer-sheet input[type="radio"]:checked + .listening-option-card::after {
                animation-duration: 0.24s;
            }
            .listening-answer-sheet .listening-option-card {
                transition-duration: 0.11s;
            }
        }
        @media (min-width: 769px) and (max-width: 1199px) {
            .listening-answer-sheet .group .space-y-2 .p-2 {
                padding: 0.36rem 0.58rem;
            }
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1.04rem;
                line-height: 1.3;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3.22rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.2rem;
                height: 2.2rem;
            }
            .listening-answer-sheet .listening-option-card .mr-3 {
                margin-right: 0.68rem;
            }
        }
        @media (min-width: 1200px) {
            .listening-answer-sheet .group .space-y-2 span.text-sm {
                font-size: 1.12rem;
            }
            .listening-answer-sheet .listening-option-card {
                min-height: 3.45rem;
            }
            .listening-answer-sheet .listening-option-badge {
                width: 2.38rem;
                height: 2.38rem;
            }
        }
    </style>

    <!-- Audio Player -->
    @include('assignments.toefl-itp.listening.partials.audio-player')

    {{-- Dynamic spacer: height set by JS to match actual audio player height --}}
    <div id="audioPlayerSpacer" style="flex-shrink:0;"></div>
    <script>
        (function() {
            function setAudioSpacer() {
                var player = document.querySelector('.fixed.top-0.left-0.right-0');
                var spacer = document.getElementById('audioPlayerSpacer');
                if (player && spacer) {
                    spacer.style.height = player.offsetHeight + 'px';
                }
            }
            setAudioSpacer();
            window.addEventListener('resize', setAudioSpacer);
            // Re-measure after fonts/images load
            window.addEventListener('load', setAudioSpacer);
        })();
    </script>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    @if(($packageMode ?? false) && session('listeningPackageReview'))
        @php
            $review = session('listeningPackageReview');
        @endphp
        <div class="mb-6 rounded-2xl border border-blue-200 bg-white shadow-sm overflow-hidden" x-data="{ reviewFilter: 'all' }">
            <div class="px-5 py-4 bg-blue-50 border-b border-blue-100">
                <h3 class="text-lg font-bold text-blue-900">Review Jawaban Paket {{ $packageNumber ?? 1 }}</h3>
                <p class="text-sm text-blue-800 mt-1">Skor {{ $review['score'] }} - Benar {{ $review['correct'] }}/{{ $review['total'] }}</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" @click="reviewFilter = 'all'" :class="reviewFilter === 'all' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-blue-700 border-blue-200'" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition">
                        Semua
                    </button>
                    <button type="button" @click="reviewFilter = 'wrong'" :class="reviewFilter === 'wrong' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-red-700 border-red-200'" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition">
                        Salah
                    </button>
                    <button type="button" @click="reviewFilter = 'unanswered'" :class="reviewFilter === 'unanswered' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-amber-700 border-amber-200'" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition">
                        Kosong
                    </button>
                </div>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-2">
                    @foreach(($review['rows'] ?? []) as $row)
                        @php
                            $statusClass = $row['is_correct']
                                ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
                                : ($row['is_unanswered'] ? 'bg-amber-50 border-amber-200 text-amber-800' : 'bg-red-50 border-red-200 text-red-800');
                            $statusText = $row['is_correct'] ? 'Benar' : ($row['is_unanswered'] ? 'Kosong' : 'Salah');
                        @endphp
                        <div x-show="reviewFilter === 'all' || (reviewFilter === 'wrong' && {{ $row['is_correct'] ? 'false' : ($row['is_unanswered'] ? 'false' : 'true') }}) || (reviewFilter === 'unanswered' && {{ $row['is_unanswered'] ? 'true' : 'false' }})" class="rounded-lg border px-3 py-2 text-sm {{ $statusClass }}">
                            <div class="font-bold">{{ $row['question_number'] }} ({{ $row['part'] }})</div>
                            <div>Jawaban: {{ $row['user_answer'] }}</div>
                            <div>Kunci: {{ $row['correct_answer'] }}</div>
                            <div class="font-semibold mt-1">{{ $statusText }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ ($packageMode ?? false) ? ('Listening Practice - Paket ' . $packageNumber) : 'TOEFL ITP Mock Up Test' }}</h1>
                    <p class="text-gray-600 mt-1">Section 1: Listening Comprehension</p>
                </div>
            </div>
            
            <a href="{{ ($packageMode ?? false) ? route('assignments.toefl-itp.listening.practice') : route('assignments.toefl-itp') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ ($packageMode ?? false) ? 'Back to Listening Practice' : 'Back to TOEFL ITP' }}
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
    <div x-show="currentSection === 'questions'" class="listening-answer-sheet bg-white rounded-2xl shadow-lg p-5 md:p-6">
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

        <form method="POST" action="{{ $listeningSubmitRoute ?? '#' }}" class="space-y-8">
            @csrf
            
            
            <!-- Part A Content -->
            <div x-show="currentListeningPart === 'A'">
                @if($listeningPartA->count() > 0)
                    @php
                        $splitIndex = ceil($listeningPartA->count() / 2);
                    @endphp
                    
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 relative">
                            {{-- Column 1 --}}
                            <div class="space-y-0 divide-y divide-gray-100">
                                @foreach($listeningPartA->slice(0, $splitIndex) as $question)
                                    <div class="py-1 group transition-colors hover:bg-gray-50/50 rounded-md px-1 -mx-1">
                                        <div class="flex items-baseline gap-3">
                                            <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                <span class="font-bold text-gray-500 text-base">{{ $question->question_number }}.</span>
                                            </div>
                                            <div class="flex flex-col gap-2 flex-1">
                                                <div class="mb-2 text-sm text-gray-800 font-medium pl-1">
                                                    {{ $question->question_text }}
                                                </div>

                                                <div class="space-y-2">
                                                    @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                        <label class="group/option block w-full cursor-pointer">
                                                            <input type="radio" 
                                                                   name="question_{{ $question->id }}" 
                                                                   value="{{ $option }}" 
                                                                   class="peer sr-only"
                                                                   required>
                                                            
                                                            <div class="listening-option-card flex items-center p-2 rounded-md border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                <div class="flex items-center justify-center mr-3 flex-none">
                                                                    <div class="listening-option-badge w-8 h-8 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                        <span class="text-xs font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <span class="text-sm text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
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
                                    <div class="py-1 group transition-colors hover:bg-gray-50/50 rounded-md px-1 -mx-1">
                                        <div class="flex items-baseline gap-3">
                                            <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                <span class="font-bold text-gray-500 text-base">{{ $question->question_number }}.</span>
                                            </div>
                                            <div class="flex flex-col gap-2 flex-1">
                                                <div class="mb-2 text-sm text-gray-800 font-medium pl-1">
                                                    {{ $question->question_text }}
                                                </div>

                                                <div class="space-y-2">
                                                    @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                        <label class="group/option block w-full cursor-pointer">
                                                            <input type="radio" 
                                                                   name="question_{{ $question->id }}" 
                                                                   value="{{ $option }}" 
                                                                   class="peer sr-only"
                                                                   required>
                                                            
                                                            <div class="listening-option-card flex items-center p-2 rounded-md border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                <div class="flex items-center justify-center mr-3 flex-none">
                                                                    <div class="listening-option-badge w-8 h-8 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                        <span class="text-xs font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <span class="text-sm text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
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
                    <div class="mt-8 pt-5 border-t-4 border-purple-200">
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
                        
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 relative">
                                {{-- Column 1 --}}
                                <div class="space-y-0 divide-y divide-gray-100">
                                    @foreach($listeningPartB->take(4) as $question)
                                        <div class="py-1 group transition-colors hover:bg-gray-50/50 rounded-md px-1 -mx-1">
                                            <div class="flex items-baseline gap-3">
                                                <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                    <span class="font-bold text-gray-500 text-base">{{ $question->question_number }}.</span>
                                                </div>
                                                <div class="flex flex-col gap-2 flex-1">
                                                    <div class="mb-2 text-sm text-gray-800 font-medium pl-1">
                                                        {!! nl2br(e($question->question_text)) !!}
                                                    </div>

                                                    <div class="space-y-2">
                                                        @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                            <label class="group/option block w-full cursor-pointer">
                                                                <input type="radio" 
                                                                       name="question_{{ $question->id }}" 
                                                                       value="{{ $option }}" 
                                                                       class="peer sr-only"
                                                                       required>
                                                                
                                                                <div class="listening-option-card flex items-center p-2 rounded-md border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                    <div class="flex items-center justify-center mr-3 flex-none">
                                                                        <div class="listening-option-badge w-8 h-8 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                            <span class="text-xs font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <span class="text-sm text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
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
                                        <div class="py-1 group transition-colors hover:bg-gray-50/50 rounded-md px-1 -mx-1">
                                            <div class="flex items-baseline gap-3">
                                                <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                    <span class="font-bold text-gray-500 text-base">{{ $question->question_number }}.</span>
                                                </div>
                                                <div class="flex flex-col gap-2 flex-1">
                                                    <div class="mb-2 text-sm text-gray-800 font-medium pl-1">
                                                        {!! nl2br(e($question->question_text)) !!}
                                                    </div>

                                                    <div class="space-y-2">
                                                        @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                            <label class="group/option block w-full cursor-pointer">
                                                                <input type="radio" 
                                                                       name="question_{{ $question->id }}" 
                                                                       value="{{ $option }}" 
                                                                       class="peer sr-only"
                                                                       required>
                                                                
                                                                <div class="listening-option-card flex items-center p-2 rounded-md border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                    <div class="flex items-center justify-center mr-3 flex-none">
                                                                        <div class="listening-option-badge w-8 h-8 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                            <span class="text-xs font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <span class="text-sm text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
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
                    <div class="mt-8 pt-5 border-t-4 border-indigo-200">
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
                        
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 relative">
                                {{-- Column 1 --}}
                                <div class="space-y-0 divide-y divide-gray-100">
                                    @php
                                        $splitIndex = ceil($listeningPartC->count() / 2);
                                    @endphp
                                    @foreach($listeningPartC->slice(0, $splitIndex) as $question)
                                        <div class="py-1 group transition-colors hover:bg-gray-50/50 rounded-md px-1 -mx-1">
                                            <div class="flex items-baseline gap-3">
                                                <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                    <span class="font-bold text-gray-500 text-base">{{ $question->question_number }}.</span>
                                                </div>
                                                <div class="flex flex-col gap-2 flex-1">
                                                    <div class="mb-2 text-sm text-gray-800 font-medium pl-1">
                                                        {!! nl2br(e($question->question_text)) !!}
                                                    </div>

                                                    <div class="space-y-2">
                                                        @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                            <label class="group/option block w-full cursor-pointer">
                                                                <input type="radio" 
                                                                       name="question_{{ $question->id }}" 
                                                                       value="{{ $option }}" 
                                                                       class="peer sr-only"
                                                                       required>
                                                                
                                                                <div class="listening-option-card flex items-center p-2 rounded-md border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                    <div class="flex items-center justify-center mr-3 flex-none">
                                                                        <div class="listening-option-badge w-8 h-8 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                            <span class="text-xs font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <span class="text-sm text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
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
                                        <div class="py-1 group transition-colors hover:bg-gray-50/50 rounded-md px-1 -mx-1">
                                            <div class="flex items-baseline gap-3">
                                                <div class="flex-none flex items-center justify-end gap-2 w-8">
                                                    <span class="font-bold text-gray-500 text-base">{{ $question->question_number }}.</span>
                                                </div>
                                                <div class="flex flex-col gap-2 flex-1">
                                                    <div class="mb-2 text-sm text-gray-800 font-medium pl-1">
                                                        {!! nl2br(e($question->question_text)) !!}
                                                    </div>

                                                    <div class="space-y-2">
                                                        @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                                                            <label class="group/option block w-full cursor-pointer">
                                                                <input type="radio" 
                                                                       name="question_{{ $question->id }}" 
                                                                       value="{{ $option }}" 
                                                                       class="peer sr-only"
                                                                       required>
                                                                
                                                                <div class="listening-option-card flex items-center p-2 rounded-md border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-sm">
                                                                    <div class="flex items-center justify-center mr-3 flex-none">
                                                                        <div class="listening-option-badge w-8 h-8 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                                                            <span class="text-xs font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <span class="text-sm text-gray-700 font-medium peer-checked:text-red-700 peer-checked:font-semibold group-hover/option:text-red-700 transition-colors">{{ $text }}</span>
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
    @if(!($packageMode ?? false))
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
    @endif
</div>

@include('assignments.toefl-itp.listening.partials.admin-modals')
@include('assignments.toefl-itp.listening.partials.audio-player-scripts')
@endsection
