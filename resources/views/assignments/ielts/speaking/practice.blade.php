@extends('layouts.admin')

@section('content')


@php
    $colorMap = [
        'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
        'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
        'indigo' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600'],
        'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
        'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-600'],
        'sky' => ['bg' => 'bg-sky-100', 'text' => 'text-sky-600'],
        'cyan' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-600'],
        'pink' => ['bg' => 'bg-pink-100', 'text' => 'text-pink-600'],
        'teal' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-600'],
        'emerald' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
        'slate' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
        'amber' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600'],
        'rose' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-600'],
        'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
        'gray' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
        'violet' => ['bg' => 'bg-violet-100', 'text' => 'text-violet-600'],
        'lime' => ['bg' => 'bg-lime-100', 'text' => 'text-lime-600'],
        'fuchsia' => ['bg' => 'bg-fuchsia-100', 'text' => 'text-fuchsia-600'],
        'stone' => ['bg' => 'bg-stone-100', 'text' => 'text-stone-600'],
        'zinc' => ['bg' => 'bg-zinc-100', 'text' => 'text-zinc-600'],
    ];
    $theme = $colorMap[$topic['color']] ?? $colorMap['blue'];
@endphp

<div class="container mx-auto px-4 py-8" 
     x-data="speakingPractice({{ json_encode($topic['questions'] ?? []) }}, {{ json_encode($idioms ?? []) }}, {{ json_encode($collocations ?? []) }}, '{{ request('topic') }}', '{{ request('subtopic') }}', {{ json_encode($advanced_verbs ?? []) }}, {{ json_encode($advanced_adverbs ?? []) }}, {{ json_encode($advanced_adjectives ?? []) }})"
     x-cloak>
    
    <!-- Header with Back Button -->
    <div class="mb-8">
        @if(isset($topic['parent_title']))
        <a href="{{ route('assignments.ielts-academic.speaking.practice', ['topic' => request()->query('topic')]) }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition-colors mb-4">
        @else
        <a href="{{ route('assignments.ielts-academic.speaking.index', ['part' => $topic['part'] ?? 1]) }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition-colors mb-4">
        @endif
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Selection
        </a>
        
        <!-- Insecure Context Warning -->
        <template x-if="!isSecureContext">
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Microphone Access Blocked by Browser</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p class="mb-2">Chrome prevents microphone access on insecure websites (http://<span x-text="window.location.hostname"></span>).</p>
                            <p class="font-bold">To fix this, please try one of the following:</p>
                            <ul class="list-disc list-inside ml-2 mt-1 space-y-1">
                                <li>Use <strong>localhost</strong> instead of the .test domain (e.g. <code>http://localhost:8888/...</code>)</li>
                                <li>Enable <strong>SSL/HTTPS</strong> in MAMP for this host.</li>
                                <li>Use a different browser like Firefox (which may verify differently).</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex items-center gap-4">
            <div class="p-3 {{ $theme['bg'] }} rounded-xl {{ $theme['text'] }}">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $topic['icon'] }}"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $topic['title'] }}</h1>
                <p class="text-gray-500">Speaking Part {{ $topic['part'] ?? 1 }} Practice</p>
            </div>
        </div>
    </div>

    <!-- Main Practice Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden min-h-[500px] flex flex-col relative">
            
            <!-- Progress Bar -->
            <div class="h-2 bg-gray-100">
                <div class="h-full bg-orange-500 transition-all duration-300"
                     :style="'width: ' + ((currentIndex + 1) / questions.length * 100) + '%'"></div>
            </div>

            <div class="p-8 md:p-12 flex-1 flex flex-col justify-center items-center text-center">
                
                <!-- Question Counter & Status -->
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="text-sm font-bold tracking-wider text-orange-500 uppercase bg-orange-50 px-4 py-1 rounded-full">
                        Question <span x-text="currentIndex + 1"></span> of <span x-text="questions.length"></span>
                    </div>
                    
                    <template x-if="answers[currentIndex]">
                        <div class="flex items-center text-sm font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full animate-fadeIn">
                             <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                             </svg>
                             Answer Recorded
                        </div>
                    </template>
                </div>

                <!-- The Question -->
                <div class="mb-12 relative inline-block {{ (in_array(request('topic'), ['lesson-3', 'lesson-4']) || str_contains(request('subtopic', ''), 'part-2')) ? 'text-left' : 'text-center' }}">
                    <!-- Countdown Overlay -->
                    <div x-show="ttsCountdown > 0" 

                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-50"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-150"
                         class="absolute inset-0 z-10 flex items-center justify-center bg-white/90 backdrop-blur-sm rounded-2xl">
                        <span class="text-6xl font-black text-orange-500 animate-pulse" x-text="ttsCountdown"></span>
                    </div>

                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 leading-tight inline whitespace-pre-line" 
                        x-text="currentQuestion"
                        :class="{'opacity-25 blur-sm': ttsCountdown > 0}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                    </h2>
                    @if(!(request('topic') == 'lesson-9' && request('subtopic') == 'part-2-challenging-task') && !(request('topic') == 'lesson-8' && request('subtopic') == 'part-2-journey') && !(request('topic') == 'lesson-7' && request('subtopic') == 'part-2-achievement'))
                    <button @click="speakQuestion()" 
                            class="inline-flex items-center justify-center w-10 h-10 ml-3 rounded-full bg-orange-100 text-orange-500 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors"
                            title="Read question aloud">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                        </svg>
                    </button>
                    @endif
                </div>

                <!-- Recording Controls -->
                <div class="w-full max-w-sm mx-auto space-y-6">
                    
                    <!-- Recorder Status / Visualizer Placeholder -->
                    <div class="h-24 flex items-center justify-center w-full">
                        <template x-if="!audioUrl && !isRecording">
                            <div class="flex flex-col items-center animate-pulse">
                                <p class="text-gray-400 mb-2">Tekan tombol rekam untuk menjawab dan usahakan Anda ada di tempat yang sunyi dan tenang.</p>
                            </div>
                        </template>

                        <template x-if="isRecording">
                             <div class="flex items-center justify-center gap-3 w-full max-w-md mx-auto">
                                <!-- Red Mic Icon -->
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/>
                                        <path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/>
                                    </svg>
                                </div>

                                <!-- Waveform Bars -->
                                <div class="flex items-center justify-center h-12 gap-[2px] flex-1">
                                    <template x-for="(barHeight, index) in visualizerBars" :key="index">
                                        <div class="w-1.5 bg-red-500 rounded-full transition-all duration-75 ease-linear" 
                                             :style="'height: ' + Math.max(10, barHeight) + '%;'"></div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="audioUrl && !isRecording">
                             <!-- Audio player hidden as per request -->
                             <div class="flex items-center text-green-600 font-medium animate-fadeIn">
                                <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Recording Saved
                             </div>
                        </template>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-center gap-4">
                        <template x-if="!isRecording && !audioUrl">
                            <button @click="startRecording()" 
                                    :disabled="!canRecord"
                                    :class="{'opacity-50 cursor-not-allowed': !canRecord, 'hover:scale-105 shadow-lg': canRecord}"
                                    class="w-16 h-16 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition-all">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </button>
                        </template>

                        <template x-if="isRecording">
                            <div class="flex flex-col items-center gap-2">
                                <div class="text-red-500 font-mono text-xl" x-text="formattedTime"></div>
                                <button @click="stopRecording()" 
                                        class="w-16 h-16 rounded-full border-4 border-red-500 flex items-center justify-center hover:bg-red-50 transition-all">
                                    <div class="w-6 h-6 bg-red-500 rounded-sm"></div>
                                </button>
                            </div>
                        </template>

                        <!-- Re-record -->
                        <template x-if="audioUrl && !isRecording">
                             <button @click="resetRecording()" 
                                    class="px-6 py-2 rounded-full border border-gray-200 text-gray-500 hover:border-orange-500 hover:text-orange-500 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Re-record
                            </button>
                        </template>
                    </div>

                    <!-- Debug Log Area -->
                    <div class="w-full text-left" x-show="debugLogs.length > 0">
                        <details>
                            <summary class="text-xs text-gray-400 cursor-pointer hover:text-gray-600 text-center">View Debug Logs</summary>
                            <div class="bg-gray-100 p-2 rounded mt-2 max-h-32 overflow-y-auto text-xs font-mono text-gray-600">
                                 <template x-for="log in debugLogs">
                                    <div x-text="log"></div>
                                </template>
                            </div>
                        </details>
                    </div>
                </div>

            </div>

            <!-- Card Footer / Navigation -->
            <div class="bg-gray-50 p-6 flex justify-between items-center border-t border-gray-100">
                <button @click="prev()" 
                        :disabled="currentIndex === 0"
                        class="px-6 py-3 rounded-xl text-gray-600 font-medium hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    Previous
                </button>

                <!-- Assistant Buttons -->
                <div class="flex items-center gap-3">
                    <button @click="isCollocationsOpen = !isCollocationsOpen" 
                            class="px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors"
                            :class="isCollocationsOpen ? 'bg-teal-600 text-white hover:bg-teal-700' : 'bg-teal-100 text-teal-700 hover:bg-teal-200'"
                            title="View Collocations">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        Collocations
                    </button>

                    <button @click="isIdiomsOpen = !isIdiomsOpen" 
                            class="px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors"
                            :class="isIdiomsOpen ? 'bg-orange-600 text-white hover:bg-orange-700' : 'bg-orange-100 text-orange-700 hover:bg-orange-200'"
                            title="View Idioms">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Idioms
                    </button>




                    
                     <button @click="toggleBoard()" 
                            class="w-10 h-10 rounded-full flex items-center justify-center transition-colors"
                            :class="showBoard ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-indigo-100 text-indigo-600 hover:bg-indigo-200'"
                            title="Open Whiteboard">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>

                <button @click="next()" 
                        class="px-8 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-all hover:shadow-lg flex items-center gap-2">
                    <span x-text="currentIndex === questions.length - 1 ? 'Finish & Grade' : 'Next Question'"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div x-show="isGrading" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"

         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-cloak>
        <div class="bg-white rounded-2xl p-8 flex flex-col items-center max-w-sm w-full shadow-2xl">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-orange-500 mb-4"></div>
            <h3 class="text-xl font-bold text-gray-800">Analyzing Your Speech...</h3>
            <p class="text-gray-500 text-center mt-2">Our AI is evaluating your fluency, vocabulary, grammar, and pronunciation.</p>
        </div>
    </div>



    <!-- Idioms Slide-over/Panel -->
    <template x-if="isIdiomsOpen">
        <div class="fixed inset-y-0 right-0 w-80 z-[60] flex pointer-events-none">
            <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                     
                     <!-- Header -->
                     <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-orange-50">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                             <span class="text-2xl">💡</span> Useful Idioms
                        </h2>
                        <button @click="isIdiomsOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                     </div>
                     
                     <!-- Content -->
                     <div class="flex-1 overflow-y-auto w-full p-6 bg-white">
                         <template x-if="idioms && idioms.length > 0">
                             <div class="space-y-6">
                                 <template x-for="(idiom, index) in idioms" :key="index">
                                     <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-orange-100">
                                         <h3 class="text-lg font-bold text-orange-600 mb-1" x-text="idiom.phrase"></h3>
                                         <p class="text-gray-700 italic mb-1" x-text="idiom.meaning"></p>
                                         <p class="text-sm text-gray-500 italic mb-2" x-text="idiom.meaning_id" x-show="idiom.meaning_id"></p>
                                         <div class="bg-gray-50 p-2 rounded text-sm text-gray-600 border-l-2 border-gray-300">
                                             <span class="font-semibold text-gray-400 text-xs uppercase tracking-wide">Example:</span><br>
                                             <span x-text="idiom.example"></span>
                                         </div>
                                     </div>
                                 </template>
                             </div>
                         </template>
                         <template x-if="!idioms || idioms.length === 0">
                             <div class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                                 <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                 </svg>
                                 <p>No specific idioms found for this topic.</p>
                             </div>
                         </template>
                     </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Collocations Slide-over/Panel -->
    <template x-if="isCollocationsOpen">
        <div class="fixed inset-y-0 left-0 w-80 z-[60] flex pointer-events-none">
            <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                     
                     <!-- Header -->
                     <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-teal-50">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                             <span class="text-2xl">🔗</span> Useful Collocations
                        </h2>
                        <button @click="isCollocationsOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                     </div>
                     
                     <!-- Content -->
                     <div class="flex-1 overflow-y-auto w-full p-6 bg-white">
                         <template x-if="collocations && collocations.length > 0">
                             <div class="space-y-6">
                                 <template x-for="(collocation, index) in collocations" :key="index">
                                     <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-teal-100">
                                         <h3 class="text-lg font-bold text-teal-600 mb-1" x-text="collocation.phrase"></h3>
                                         <p class="text-gray-700 italic mb-1" x-text="collocation.meaning"></p>
                                         <p class="text-sm text-gray-500 italic mb-2" x-text="collocation.meaning_id" x-show="collocation.meaning_id"></p>
                                         <div class="bg-gray-50 p-2 rounded text-sm text-gray-600 border-l-2 border-gray-300">
                                             <span class="font-semibold text-gray-400 text-xs uppercase tracking-wide">Example:</span><br>
                                             <span x-text="collocation.example"></span>
                                         </div>
                                     </div>
                                 </template>
                             </div>
                         </template>
                         <template x-if="!collocations || collocations.length === 0">
                             <div class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                                 <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                 </svg>
                                 <p>No specific collocations found for this topic.</p>
                             </div>
                         </template>
                     </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Advanced Verbs Slide-over (Left side) -->
    <template x-if="isAdvancedVerbsOpen">
        <div class="fixed inset-y-0 left-0 w-80 z-[60] flex pointer-events-none">
            <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                     <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-indigo-50">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                             <span class="text-2xl">🔥</span> Advanced Verbs
                        </h2>
                        <button @click="isAdvancedVerbsOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                     </div>
                     <div class="flex-1 overflow-y-auto w-full p-6 bg-white">
                         <template x-if="advancedVerbs && advancedVerbs.length > 0">
                             <div class="space-y-6">
                                 <template x-for="(item, index) in advancedVerbs" :key="index">
                                     <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-indigo-100">
                                         <div class="flex justify-between items-start mb-1">
                                             <h3 class="text-lg font-bold text-indigo-600" x-text="item.phrase"></h3>
                                             <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded" x-text="item.level"></span>
                                         </div>
                                         <p class="text-gray-700 italic mb-1" x-text="item.meaning"></p>
                                         <p class="text-sm text-gray-500 italic mb-2" x-text="item.meaning_id"></p>
                                         <div class="bg-gray-50 p-2 rounded text-sm text-gray-600 border-l-2 border-gray-300">
                                             <span class="font-semibold text-gray-400 text-xs uppercase tracking-wide">Example:</span><br>
                                             <span x-text="item.example"></span>
                                         </div>
                                     </div>
                                 </template>
                             </div>
                         </template>
                         <template x-if="!advancedVerbs || advancedVerbs.length === 0">
                             <div class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                                 <p>No advanced verbs found.</p>
                             </div>
                         </template>
                     </div>
            </div>
        </div>
    </template>

    <!-- Advanced Adverbs Slide-over (Right side) -->
    <template x-if="isAdvancedAdverbsOpen">
        <div class="fixed inset-y-0 right-0 w-80 z-[60] flex pointer-events-none">
            <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                     <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-purple-50">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                             <span class="text-2xl">⚡</span> Advanced Adverbs
                        </h2>
                        <button @click="isAdvancedAdverbsOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                     </div>
                     <div class="flex-1 overflow-y-auto w-full p-6 bg-white">
                         <template x-if="advancedAdverbs && advancedAdverbs.length > 0">
                             <div class="space-y-6">
                                 <template x-for="(item, index) in advancedAdverbs" :key="index">
                                     <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-purple-100">
                                         <div class="flex justify-between items-start mb-1">
                                             <h3 class="text-lg font-bold text-purple-600" x-text="item.phrase"></h3>
                                             <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-bold rounded" x-text="item.level"></span>
                                         </div>
                                         <p class="text-gray-700 italic mb-1" x-text="item.meaning"></p>
                                         <p class="text-sm text-gray-500 italic mb-2" x-text="item.meaning_id"></p>
                                         <div class="bg-gray-50 p-2 rounded text-sm text-gray-600 border-l-2 border-gray-300">
                                             <span class="font-semibold text-gray-400 text-xs uppercase tracking-wide">Example:</span><br>
                                             <span x-text="item.example"></span>
                                         </div>
                                     </div>
                                 </template>
                             </div>
                         </template>
                         <template x-if="!advancedAdverbs || advancedAdverbs.length === 0">
                             <div class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                                 <p>No advanced adverbs found.</p>
                             </div>
                         </template>
                     </div>
            </div>
        </div>
    </template>





    <!-- Floating Grammar Button (Lesson 2 Only) -->
    @if(request('topic') == 'lesson-2')
    <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 z-[60]">
        <button @click="isGrammarOpen = !isGrammarOpen" 
                class="flex items-center gap-2 px-6 py-3 rounded-full font-bold shadow-2xl transition-all transform hover:scale-105"
                :class="isGrammarOpen ? 'bg-blue-600 text-white ring-4 ring-blue-300' : 'bg-white text-blue-600 hover:bg-blue-50'"
                title="View Nominal & Passive Rules">
            <div class="p-1.5 bg-blue-100 rounded-full text-blue-600" :class="isGrammarOpen ? 'bg-white/20 text-white' : ''">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span>Nominal & Passive</span>
            

        </button>
    </div>
    @endif

    <!-- Floating Modal Button (Lesson 5 Only) -->
    @if(request('topic') == 'lesson-5')
    <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 z-[60]">
        <button @click="isGrammarOpen = !isGrammarOpen" 
                class="flex items-center gap-2 px-6 py-3 rounded-full font-bold shadow-2xl transition-all transform hover:scale-105"
                :class="isGrammarOpen ? 'bg-yellow-500 text-white ring-4 ring-yellow-300' : 'bg-white text-yellow-600 hover:bg-yellow-50'"
                title="View Modal Verbs">
            <div class="p-1.5 bg-yellow-100 rounded-full text-yellow-600" :class="isGrammarOpen ? 'bg-white/20 text-white' : ''">
                <!-- Lightning icon for quick helpers -->
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span>Modal Verbs</span>
        </button>
    </div>
    @endif

    <!-- Nominal & Passive Modal (Lesson 2 Only) -->
    <template x-if="isGrammarOpen">
        <div class="fixed z-[70] bg-white rounded-2xl shadow-2xl flex flex-col border border-gray-200 overflow-hidden"
             :style="'top: ' + grammarY + 'px; left: ' + grammarX + 'px; width: 650px; max-height: 80vh;'"
             @mousemove.window="onDragGrammar($event)"
             @mouseup.window="stopDragGrammar()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-cloak>

            @if(request('topic') == 'lesson-5')
            <!-- Header (Lesson 5 - Yellow) -->
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4 flex justify-between items-center cursor-move select-none"
                 @mousedown="startDragGrammar">
                <h3 class="text-xl font-bold text-white flex items-center gap-2 pointer-events-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Modal Verbs Cheat Sheet
                </h3>
                <button @click="isGrammarOpen = false" class="text-white/80 hover:text-white transition-colors" @mousedown.stop>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content for Lesson 5 -->
            <div class="p-6 overflow-y-auto max-h-[60vh] text-gray-700">
                <div class="space-y-4">
                    <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                        <h4 class="font-bold text-yellow-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Common Modals
                        </h4>
                        <div class="grid grid-cols-1 gap-3">
                            <!-- Item -->
                            <div class="flex items-center justify-between border-b border-yellow-200 pb-2">
                                <span class="font-medium text-gray-600">Mungkin</span>
                                <span class="font-bold text-gray-800">May / Might / Could</span>
                            </div>
                            <!-- Item -->
                            <div class="flex items-center justify-between border-b border-yellow-200 pb-2">
                                <span class="font-medium text-gray-600">Akan</span>
                                <span class="font-bold text-gray-800">Will / Be going to</span>
                            </div>
                            <!-- Item -->
                            <div class="flex items-center justify-between border-b border-yellow-200 pb-2">
                                <span class="font-medium text-gray-600">Akan (pengandaian)</span>
                                <span class="font-bold text-gray-800">Would</span>
                            </div>
                            <!-- Item -->
                            <div class="flex items-center justify-between border-b border-yellow-200 pb-2">
                                <span class="font-medium text-gray-600">Bisa / Mampu</span>
                                <span class="font-bold text-gray-800">Can / Could (lampau) / Be able to</span>
                            </div>
                            <!-- Item -->
                            <div class="flex items-center justify-between border-b border-yellow-200 pb-2">
                                <span class="font-medium text-gray-600">Seharusnya</span>
                                <span class="font-bold text-gray-800">Should / Be supposed to</span>
                            </div>
                            <!-- Item -->
                            <div class="flex items-center justify-between pb-1">
                                <span class="font-medium text-gray-600">Harus</span>
                                <span class="font-bold text-gray-800">Must / Have to / Have got to</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @else
            <!-- Header (Lesson 2 - Blue) -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex justify-between items-center cursor-move select-none"
                 @mousedown="startDragGrammar">
                <h3 class="text-xl font-bold text-white flex items-center gap-2 pointer-events-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Nominal & Passive Voice Rules
                </h3>
                <button @click="isGrammarOpen = false" class="text-white/80 hover:text-white transition-colors" @mousedown.stop>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body (Scrollable) -->
            <div class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-6 grid md:grid-cols-2 gap-6">
                    
                    <!-- Nominal Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                        <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                            <h4 class="font-bold text-blue-800 text-lg">Nominal Sentences</h4>
                            <p class="text-xs text-blue-600">Sentences without an action verb</p>
                        </div>
                        <div class="p-4 space-y-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Present</span>
                                <div class="bg-gray-50 p-2 rounded text-gray-700 font-mono text-sm border-l-4 border-blue-400">
                                    Subject + <span class="font-bold text-blue-600">is / am / are</span> + ...
                                </div>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Past</span>
                                <div class="bg-gray-50 p-2 rounded text-gray-700 font-mono text-sm border-l-4 border-blue-400">
                                    Subject + <span class="font-bold text-blue-600">was / were</span> + ...
                                </div>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Modal</span>
                                <div class="bg-gray-50 p-2 rounded text-gray-700 font-mono text-sm border-l-4 border-blue-400">
                                    Modal + <span class="font-bold text-blue-600">be</span> + ...
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Passive Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-indigo-100 overflow-hidden">
                        <div class="bg-indigo-50 px-4 py-3 border-b border-indigo-100">
                            <h4 class="font-bold text-indigo-800 text-lg">Passive Voice</h4>
                            <p class="text-xs text-indigo-600">Action received by the subject</p>
                        </div>
                        <div class="p-4 space-y-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Present</span>
                                <div class="bg-gray-50 p-2 rounded text-gray-700 font-mono text-sm border-l-4 border-indigo-400">
                                    <span class="font-bold text-indigo-600">is/am/are</span> + Verb 3
                                </div>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Past</span>
                                <div class="bg-gray-50 p-2 rounded text-gray-700 font-mono text-sm border-l-4 border-indigo-400">
                                    <span class="font-bold text-indigo-600">was/were</span> + Verb 3
                                </div>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Modal</span>
                                <div class="bg-gray-50 p-2 rounded text-gray-700 font-mono text-sm border-l-4 border-indigo-400">
                                    Modal + <span class="font-bold text-indigo-600">be</span> + Verb 3
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                <!-- Footer Hint -->
                <div class="bg-gray-100 px-6 py-3 text-center text-xs text-gray-500">
                    Use these structures to add variety and complexity to your speaking answers.
                </div>
            </div>
            @endif
        </div>
    </template>

    <!-- Whiteboard Overlay (Windowed) -->
    <div x-show="isBoardOpen"
         class="fixed z-50 bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col border border-gray-200"
         :style="'top: ' + boardY + 'px; left: ' + boardX + 'px; width: ' + boardWidth + 'px; height: ' + boardHeight + 'px;'"
         @mousemove.window="onDragBoard($event); onResize($event)"
         @mouseup.window="stopDragBoard(); stopResize()"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         x-cloak>
         
        <!-- Toolbar (Draggable Handle) -->
        <div class="bg-gray-100 p-3 flex justify-between items-center cursor-move border-b border-gray-200 select-none"
             @mousedown="startDragBoard">
            <h3 class="text-sm font-bold text-gray-700 flex items-center pointer-events-none">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Whiteboard
            </h3>
            
            <div class="flex items-center gap-3">
                <!-- Tools -->
                <div class="flex items-center bg-white rounded-lg p-1 border border-gray-200 shadow-sm" @mousedown.stop>
                    <button @click="setTool('pen')" 
                            class="p-1.5 rounded hover:bg-gray-100 transition-colors"
                            :class="{'bg-indigo-100 text-indigo-600': currentTool === 'pen', 'text-gray-500': currentTool !== 'pen'}"
                            title="Pen">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                    <button @click="setTool('text')" 
                            class="p-1.5 rounded hover:bg-gray-100 transition-colors"
                            :class="{'bg-indigo-100 text-indigo-600': currentTool === 'text', 'text-gray-500': currentTool !== 'text'}"
                            title="Text Tool">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M12 6v14" />
                        </svg>
                    </button>
                    <button @click="setTool('eraser')" 
                            class="p-1.5 rounded hover:bg-gray-100 transition-colors"
                            :class="{'bg-indigo-100 text-indigo-600': currentTool === 'eraser', 'text-gray-500': currentTool !== 'eraser'}"
                            title="Eraser">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>

                <!-- Color Picker (Only for Pen/Text) -->
                <div class="flex items-center gap-1.5" @mousedown.stop x-show="currentTool !== 'eraser'">
                    <template x-for="color in ['#000000', '#EF4444', '#3B82F6', '#10B981']">
                        <button @click="setPenColor(color)" 
                                class="w-6 h-6 rounded-full border border-gray-300 transition-transform hover:scale-110"
                                :class="{'ring-2 ring-offset-1 ring-indigo-500': currentColor === color}"
                                :style="'background-color: ' + color"></button>
                    </template>
                </div>
                
                <div class="h-6 w-px bg-gray-300 mx-1"></div>
                
                <div class="h-6 w-px bg-gray-300 mx-1"></div>

                <button @click="drawGrid()" @mousedown.stop class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors" title="Divide Board (4 Parts)">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16M12 4v16" />
                    </svg>
                </button>
                
                <button @click="clearBoard()" @mousedown.stop class="p-1.5 text-gray-500 hover:text-red-500 hover:bg-red-50 rounded transition-colors" title="Clear All">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                
                <button @click="toggleBoard()" @mousedown.stop class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-200 rounded transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Canvas Area -->
        <div class="flex-1 relative bg-white touch-none" x-ref="boardContainer">
            <canvas x-ref="whiteboard" 
                    @mousedown="startDrawing" 
                    @mousemove="draw" 
                    @mouseup="stopDrawing" 
                    @mouseleave="stopDrawing"
                    @touchstart.prevent="startDrawing"
                    @touchmove.prevent="draw"
                    @touchend.prevent="stopDrawing"
                    class="w-full h-full cursor-crosshair block"></canvas>
            
            <!-- Floating Text Input for Text Tool -->
            <input x-ref="textInput"
                   type="text"
                   x-show="isTyping"
                   x-model="currentText"
                   @keydown.enter="finishText"
                   @blur="finishText"
                   class="absolute bg-white border-2 border-indigo-500 rounded px-2 py-1 text-lg font-bold outline-none shadow-xl z-50 placeholder-gray-400"
                   :style="'top: ' + textY + 'px; left: ' + textX + 'px; color: ' + currentColor + '; min-width: 150px; transform: translateY(-50%);'"
                   placeholder="Type here..."
                   x-cloak>
        </div>
        
        <!-- Resize Handle (Placed in main container to ensuring layering) -->
        <div class="absolute bottom-0 right-0 w-8 h-8 flex items-end justify-end z-50 cursor-nwse-resize"
             @mousedown.stop="startResize">
            <!-- Visual Grip -->
            <div class="w-full h-full bg-gray-200 hover:bg-gray-300 rounded-tl-xl flex items-end justify-end p-1.5 transition-colors shadow-sm">
                 <div class="flex flex-col gap-0.5 items-end">
                     <div class="w-4 h-0.5 bg-gray-500 rounded-full"></div>
                     <div class="w-3 h-0.5 bg-gray-500 rounded-full"></div>
                     <div class="w-2 h-0.5 bg-gray-500 rounded-full"></div>
                 </div>
            </div>
        </div>
    


    <!-- Results Modal -->
    <template x-if="gradingResults">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
                <!-- ... content ... -->
                <button @click="gradingResults = null" class="absolute top-4 right-4 p-2 rounded-full hover:bg-gray-100 transition-colors z-10">
                    <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Header -->
                <div class="bg-orange-500 p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                         <h2 class="text-3xl font-bold mb-2">Speaking Result</h2>
                         <p class="opacity-90">Topic: {{ $topic['title'] }}</p>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                        <!-- Overall Score -->
                        <div class="col-span-1 md:col-span-1">
                            <div class="bg-orange-50 rounded-2xl p-6 flex flex-col items-center justify-center h-full text-center border-2 border-orange-100">
                                <span class="text-gray-500 font-medium uppercase tracking-wider text-xs mb-2">Overall Band</span>
                                <span class="text-6xl font-black text-orange-600" x-text="gradingResults.overall_score"></span>
                                <div class="mt-4 flex gap-1">
                                    <template x-for="i in 5">
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- General Feedback -->
                        <div class="col-span-1 md:col-span-2">
                             <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                General Feedback
                             </h4>
                             <p class="text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-xl" x-text="gradingResults.general_feedback"></p>
                        </div>
                    </div>

                    <!-- Category Breakdown -->
                    <h4 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Band Descriptors Breakdown</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Fluency -->
                        <div class="bg-white border rounded-xl p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-gray-700">Fluency & Coherence</span>
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md font-bold text-sm" x-text="gradingResults.categories.fluency_coherence.score"></span>
                            </div>
                            <p class="text-sm text-gray-500" x-text="gradingResults.categories.fluency_coherence.feedback"></p>
                        </div>

                        <!-- Lexical -->
                        <div class="bg-white border rounded-xl p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-gray-700">Lexical Resource</span>
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-md font-bold text-sm" x-text="gradingResults.categories.lexical_resource.score"></span>
                            </div>
                            <p class="text-sm text-gray-500" x-text="gradingResults.categories.lexical_resource.feedback"></p>
                        </div>

                        <!-- Grammar -->
                        <div class="bg-white border rounded-xl p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-gray-700">Grammar Range</span>
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-md font-bold text-sm" x-text="gradingResults.categories.grammatical_range.score"></span>
                            </div>
                            <p class="text-sm text-gray-500" x-text="gradingResults.categories.grammatical_range.feedback"></p>
                        </div>

                        <!-- Pronunciation -->
                        <div class="bg-white border rounded-xl p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-gray-700">Pronunciation</span>
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-md font-bold text-sm" x-text="gradingResults.categories.pronunciation.score"></span>
                            </div>
                            <p class="text-sm text-gray-500" x-text="gradingResults.categories.pronunciation.feedback"></p>
                        </div>

                    </div>

                    <!-- Transcripts -->
                    <template x-if="gradingResults.transcripts && gradingResults.transcripts.length > 0">
                        <div class="mt-8">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                                Answer Transcripts
                            </h4>
                            <div class="space-y-4">
                                <template x-for="(item, index) in gradingResults.transcripts">
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                        <p class="text-sm font-semibold text-gray-700 mb-1" x-text="item.question"></p>
                                        <div class="bg-white p-3 rounded-lg text-gray-600 text-sm italic border border-gray-200 shadow-sm">
                                            <span class="text-indigo-400 font-bold mr-1">“</span>
                                            <span x-text="item.answer"></span>
                                            <span class="text-indigo-400 font-bold ml-1">”</span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('assignments.ielts-academic.speaking.index') }}?part=1" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                            Return to Topics
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </template>





</div>
<script>
    // Use a global function for ensuring registration order doesn't matter as long as it's defined before Alpine runs or init
    function speakingPractice(initialQuestions, initialIdioms = [], initialCollocations = [], topicSlug = '', subtopicSlug = '', initialAdvancedVerbs = [], initialAdvancedAdverbs = [], initialAdvancedAdjectives = []) {
        return {
            topic: topicSlug,
            subtopic: subtopicSlug,
            questions: initialQuestions,
            allIdioms: initialIdioms,
            allCollocations: initialCollocations,
            allAdvancedVerbs: initialAdvancedVerbs,
            allAdvancedAdverbs: initialAdvancedAdverbs,
            allAdvancedAdjectives: initialAdvancedAdjectives,
            // If data is indexed (lesson 2), init with first question's data, else use all
            idioms: Array.isArray(initialIdioms[0]) ? (initialIdioms[0] || []) : initialIdioms,
            collocations: Array.isArray(initialCollocations[0]) ? (initialCollocations[0] || []) : initialCollocations,
            advancedVerbs: Array.isArray(initialAdvancedVerbs[0]) ? (initialAdvancedVerbs[0] || []) : initialAdvancedVerbs,
            advancedAdverbs: Array.isArray(initialAdvancedAdverbs[0]) ? (initialAdvancedAdverbs[0] || []) : initialAdvancedAdverbs,
            advancedAdjectives: Array.isArray(initialAdvancedAdjectives[0]) ? (initialAdvancedAdjectives[0] || []) : initialAdvancedAdjectives,
            isIdiomsOpen: false,
            isCollocationsOpen: false,
            isAdvancedVerbsOpen: false,
            isAdvancedAdverbsOpen: false,
            isAdvancedAdjectivesOpen: false,
            isGrammarOpen: false, // Added for Nominal & Passive Modal
            currentIndex: 0,
            isRecording: false,
            mediaRecorder: null,
            audioChunks: [],
            audioUrl: null,
            recordingStartTime: null,
            recordingDuration: 0,
            timerInterval: null,
            stream: null,
            errorMessage: null,
            visualizerBars: new Array(40).fill(5),
            audioContext: null,
            analyser: null,
            source: null,
            animationFrame: null,
            debugLogs: [],
            ttsCountdown: null,
            answers: {},
            isGrading: false,
            gradingResults: null,

            countdownTimer: null,
            canRecord: false,
            recognition: null,
            transcripts: {},
            currentTranscript: '',
            
            // Whiteboard props
            isBoardOpen: false,
            bgContext: null,
            isDrawing: false,
            currentColor: '#000000',
            currentTool: 'pen', // pen, eraser, text
            lastX: 0,
            lastY: 0,
            
            // Text Tool props
            isTyping: false,
            currentText: '',
            textX: 0,
            textY: 0,
            
            // Draggable & Resizable props
            boardX: window.innerWidth / 2 - 300,
            boardY: window.innerHeight / 2 - 225,
            boardWidth: 600,
            boardHeight: 450,
            
            isDraggingBoard: false,
            dragOffsetX: 0,
            dragOffsetY: 0,
            
            isResizing: false,
            resizeStartX: 0,
            resizeStartY: 0,
            startWidth: 0,
            startHeight: 0,
            
            // Whiteboard methods
            toggleBoard() {
                this.isBoardOpen = !this.isBoardOpen;
                if (this.isBoardOpen) {
                    this.$nextTick(() => {
                        this.initBoard();
                    });
                }
            },
            
            initBoard() {
                const canvas = this.$refs.whiteboard;
                const container = this.$refs.boardContainer;
                if (!canvas || !container) return;
                
                // Use current board dimensions
                canvas.width = this.boardWidth;
                canvas.height = this.boardHeight;
                
                this.bgContext = canvas.getContext('2d');
                this.bgContext.lineCap = 'round';
                this.bgContext.lineJoin = 'round';
                
                this.updateContextStyles();
            },
            
            setTool(tool) {
                this.currentTool = tool;
                if (tool !== 'text') {
                    this.isTyping = false;
                    this.currentText = '';
                }
                this.updateContextStyles();
            },
            
            setPenColor(color) {
                this.currentColor = color;
                if (this.currentTool === 'eraser') {
                    this.currentTool = 'pen';
                }
                this.updateContextStyles();
            },
            
            startResize(e) {
                this.isResizing = true;
                this.resizeStartX = e.clientX;
                this.resizeStartY = e.clientY;
                this.startWidth = this.boardWidth;
                this.startHeight = this.boardHeight;
            },
            
            onResize(e) {
                if (!this.isResizing) return;
                
                const newWidth = this.startWidth + (e.clientX - this.resizeStartX);
                const newHeight = this.startHeight + (e.clientY - this.resizeStartY);
                
                // Minimum size constraints
                this.boardWidth = Math.max(300, newWidth);
                this.boardHeight = Math.max(200, newHeight);
            },
            
            stopResize() {
                if (!this.isResizing) return;
                this.isResizing = false;
                
                // Preserve content and resize canvas resolution
                const canvas = this.$refs.whiteboard;
                if (!canvas) return;
                
                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = canvas.width;
                tempCanvas.height = canvas.height;
                tempCanvas.getContext('2d').drawImage(canvas, 0, 0);
                
                canvas.width = this.boardWidth;
                canvas.height = this.boardHeight;
                
                this.bgContext = canvas.getContext('2d');
                this.bgContext.drawImage(tempCanvas, 0, 0);
                
                this.updateContextStyles();
            },
            
            updateContextStyles() {
                if (!this.bgContext) return;
                
                if (this.currentTool === 'eraser') {
                    this.bgContext.globalCompositeOperation = 'destination-out';
                    this.bgContext.lineWidth = 30; // Thicker eraser
                    // Color doesn't matter for destination-out, but keep it consistent
                    this.bgContext.strokeStyle = 'rgba(0,0,0,1)'; 
                } else {
                    this.bgContext.globalCompositeOperation = 'source-over';
                    this.bgContext.lineWidth = 3;
                    this.bgContext.strokeStyle = this.currentColor;
                }
            },
            
            startDragBoard(e) {
                this.isDraggingBoard = true;
                this.dragOffsetX = e.clientX - this.boardX;
                this.dragOffsetY = e.clientY - this.boardY;
            },
            
            onDragBoard(e) {
                if (!this.isDraggingBoard) return;
                this.boardX = e.clientX - this.dragOffsetX;
                this.boardY = e.clientY - this.dragOffsetY;
            },
            
            stopDragBoard() {
                this.isDraggingBoard = false;
            },
            
            getCoordinates(e) {
                const canvas = this.$refs.whiteboard;
                const rect = canvas.getBoundingClientRect();
                
                let clientX, clientY;
                
                if (e.touches && e.touches.length > 0) {
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                } else {
                    clientX = e.clientX;
                    clientY = e.clientY;
                }
                
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            },
            
            startDrawing(e) {
                // If text mode
                if (this.currentTool === 'text') {
                    // Prevent default to stop focus stealing issues
                    e.preventDefault(); 
                    
                    if (this.isTyping) {
                        this.finishText();
                        return;
                    }
                    
                    const coords = this.getCoordinates(e);
                    this.textX = coords.x;
                    this.textY = coords.y;
                    this.isTyping = true;
                    this.currentText = '';
                    
                    this.$nextTick(() => {
                        this.$refs.textInput.focus();
                    });
                    return;
                }
            
                this.isDrawing = true;
                this.updateContextStyles();
                
                const coords = this.getCoordinates(e);
                this.lastX = coords.x;
                this.lastY = coords.y;
                
                this.bgContext.beginPath();
                this.bgContext.moveTo(this.lastX, this.lastY);
            },
            
            draw(e) {
                if (!this.isDrawing) return;
                if (!this.bgContext) return;
                if (this.currentTool === 'text') return;
                
                const coords = this.getCoordinates(e);
                
                this.bgContext.lineTo(coords.x, coords.y);
                this.bgContext.stroke();
                
                this.lastX = coords.x;
                this.lastY = coords.y;
            },
            
            stopDrawing() {
                this.isDrawing = false;
                if (this.bgContext) {
                    this.bgContext.closePath();
                    // Reset to source-over just in case, but usually handled by startDrawing
                    // Keeping it stateful is better for verify
                }
            },
            
            finishText() {
                if (!this.isTyping || !this.currentText.trim()) {
                    this.isTyping = false;
                    this.currentText = '';
                    return;
                }
                
                if (!this.bgContext) return;
                
                // Ensure we write on top
                const previousOperation = this.bgContext.globalCompositeOperation;
                this.bgContext.globalCompositeOperation = 'source-over';
                
                this.bgContext.font = 'bold 20px sans-serif'; 
                this.bgContext.fillStyle = this.currentColor;
                this.bgContext.fillText(this.currentText, this.textX + 5, this.textY + 24); 
                
                // Restore operation (though startDrawing updates it anyway)
                this.bgContext.globalCompositeOperation = previousOperation;
                
                this.isTyping = false;
                this.currentText = '';
            },
            
            drawGrid() {
                 if (!this.bgContext) return;
                 const canvas = this.$refs.whiteboard;
                 const w = canvas.width;
                 const h = canvas.height;
                 
                 this.bgContext.save();
                 this.bgContext.globalCompositeOperation = 'source-over';
                 this.bgContext.beginPath();
                 this.bgContext.strokeStyle = this.currentColor === '#ffffff' ? '#000000' : this.currentColor; // Fallback if white
                 this.bgContext.lineWidth = 2;
                 
                 // Horizontal
                 this.bgContext.moveTo(0, h/2);
                 this.bgContext.lineTo(w, h/2);
                 
                 // Vertical
                 this.bgContext.moveTo(w/2, 0);
                 this.bgContext.lineTo(w/2, h);
                 
                 this.bgContext.stroke();
                 this.bgContext.restore();
                 
                 // Reset tool state (optional, but good UX to not switch tools)
                 this.updateContextStyles();
            },

            // Grammar Modal Drag & Position
            grammarX: window.innerWidth / 2 - 300,
            grammarY: window.innerHeight / 2 - 200,
            isDraggingGrammar: false,
            dragOffsetGrammarX: 0,
            dragOffsetGrammarY: 0,

            startDragGrammar(e) {
                this.isDraggingGrammar = true;
                this.dragOffsetGrammarX = e.clientX - this.grammarX;
                this.dragOffsetGrammarY = e.clientY - this.grammarY;
            },

            onDragGrammar(e) {
                if (!this.isDraggingGrammar) return;
                this.grammarX = e.clientX - this.dragOffsetGrammarX;
                this.grammarY = e.clientY - this.dragOffsetGrammarY;
            },

            stopDragGrammar() {
                this.isDraggingGrammar = false;
            },
            
            clearBoard() {
                if (!this.bgContext) return;
                const canvas = this.$refs.whiteboard;
                this.bgContext.clearRect(0, 0, canvas.width, canvas.height);
                this.isTyping = false;
                this.currentText = '';
            },
            

            // computed
            get currentQuestion() {
                if (!this.questions || this.questions.length === 0) return 'No questions available';
                return this.questions[this.currentIndex];
            },

            get formattedTime() {
                const minutes = Math.floor(this.recordingDuration / 60);
                const seconds = this.recordingDuration % 60;
                return minutes + ':' + seconds.toString().padStart(2, '0');
            },

            get isSecureContext() {
                 return window.isSecureContext || window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1' || window.location.protocol === 'https:';
            },
            
            init() {
                setTimeout(() => this.startTTSCountdown(), 500);
                // Dispatch initial event for advanced verbs with a small delay to ensure modal is ready
                if (this.advancedVerbs.length > 0) {
                     setTimeout(() => {
                         window.dispatchEvent(new CustomEvent('update-advanced-verbs', { detail: this.advancedVerbs }));
                     }, 200);
                }
            },

            log(msg) {
                console.log(msg);
                this.debugLogs.push(new Date().toLocaleTimeString().split(' ')[0] + ': ' + msg);
            },
            
            async submitForGrading() {
                this.isGrading = true;
                this.log('Submitting for grading...');
                
                const formData = new FormData();
                
                Object.keys(this.answers).forEach(key => {
                    const blob = this.answers[key];
                    formData.append('audio_blobs[]', blob, 'question_' + key + '.webm');
                    
                    // Append transcript
                    if (this.transcripts[key]) {
                        formData.append('transcripts[' + key + ']', this.transcripts[key]);
                    }
                });
                
                const token = document.querySelector('meta[name=\'csrf-token\']').getAttribute('content');

                try {
                    const response = await fetch('{{ route('assignments.ielts-academic.speaking.practice.grade') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    
                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(`Grading failed: ${response.status} ${response.statusText}\n${errorText.substring(0, 200)}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.redirect_url) {
                        this.log('Redirecting to evaluation...');
                        window.location.href = data.redirect_url;
                    } else {
                        // Fallback for mock or error
                        this.gradingResults = data;
                        this.log('Grading complete');
                    }
                    
                } catch (error) {
                    this.log('Error submitting: ' + error.message);
                    alert('Failed to submit for grading:\n' + error.message);
                } finally {
                    // Only stop loading if NOT redirecting 
                    // (if redirecting, we want the spinner to stay until page unload)
                    // But since we can't easily detect unload, we'll leave it unless it failed
                    if (!this.gradingResults && !window.location.href.includes('evaluation')) {
                         this.isGrading = false;
                    }
                }
            },

            async initRecording() {
                if (!navigator.mediaDevices && !navigator.getUserMedia && !navigator.webkitGetUserMedia && !navigator.mozGetUserMedia) {
                    this.log('No getUserMedia implementation found');
                    let msg = 'Audio recording API is missing.';
                    if (!this.isSecureContext) {
                        msg += '\n\nChrome requires a secure connection (HTTPS) or \'localhost\' to use the microphone. Your current URL (' + window.location.hostname + ') is treated as insecure.';
                    }
                    alert(msg);
                    return false;
                }

                if (!navigator.mediaDevices) {
                    navigator.mediaDevices = {};
                }
                if (!navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia = function(constraints) {
                        var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                        if (!getUserMedia) {
                            return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                        }
                        return new Promise(function(resolve, reject) {
                            getUserMedia.call(navigator, constraints, resolve, reject);
                        });
                    }
                }

                try {
                    this.log('Requesting microphone access...');
                    this.stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    this.log('Microphone access granted');
                    return true;
                } catch (err) {
                    this.log('Microphone error: ' + err.message);
                    
                    let msg = 'Microphone access failed: ' + err.message;
                    if (!this.isSecureContext) {
                        msg += '\n\nIMPORTANT: Chrome blocks microphone access on insecure (HTTP) sites. Please try using \'localhost\' or enable HTTPS.';
                    }
                    alert(msg);
                    return false;
                }
            },

            startVisualizer() {
                if (!this.stream) return;

                if (!this.audioContext) {
                     this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
                } else if (this.audioContext.state === 'suspended') {
                     this.audioContext.resume();
                }
                
                if (!this.analyser) {
                     this.analyser = this.audioContext.createAnalyser();
                     this.analyser.fftSize = 256;
                }
                
                if (!this.source) {
                     this.source = this.audioContext.createMediaStreamSource(this.stream);
                     this.source.connect(this.analyser);
                }

                const bufferLength = this.analyser.frequencyBinCount;
                const dataArray = new Uint8Array(bufferLength);

                const update = () => {
                    if (!this.isRecording) return;
                    
                    this.animationFrame = requestAnimationFrame(update);
                    this.analyser.getByteFrequencyData(dataArray);
                    
                    const step = Math.floor(bufferLength / 60); 
                    const bars = [];
                    for(let i=0; i<40; i++) {
                        const val = dataArray[i * step];
                        bars.push(Math.max(5, val / 255 * 100));
                    }
                    this.visualizerBars = bars;
                };
                
                update();
            },

            async startRecording() {
                if (!this.stream) {
                    const success = await this.initRecording();
                    if (!success) return;
                }
                
                // Reset transcript for this session
                this.currentTranscript = '';
                
                // Start Speech Recognition if supported
                if ('webkitSpeechRecognition' in window) {
                    this.recognition = new webkitSpeechRecognition();
                    this.recognition.continuous = true;
                    this.recognition.interimResults = true;
                    this.recognition.lang = 'en-US';
                    
                    this.recognition.onresult = (event) => {
                        let final = '';
                        for (let i = event.resultIndex; i < event.results.length; ++i) {
                            if (event.results[i].isFinal) {
                                final += event.results[i][0].transcript;
                            }
                        }
                        if (final) {
                             this.currentTranscript += final + ' ';
                             this.log('Transcript chunk: ' + final);
                        }
                    };
                    
                    this.recognition.onerror = (event) => {
                        this.log('Recognition error: ' + event.error);
                    };
                    
                    try {
                        this.recognition.start();
                        this.log('Speech recognition started');
                    } catch (e) {
                         this.log('Speech recognition start failed: ' + e.message);
                    }
                }

                try {
                    this.audioChunks = [];
                    
                    let options = {};
                    if (MediaRecorder.isTypeSupported('audio/webm;codecs=opus')) {
                        options = { mimeType: 'audio/webm;codecs=opus' };
                        this.log('Using mimeType: audio/webm;codecs=opus');
                    } else if (MediaRecorder.isTypeSupported('audio/webm')) {
                        options = { mimeType: 'audio/webm' };
                         this.log('Using mimeType: audio/webm');
                    } else if (MediaRecorder.isTypeSupported('audio/mp4')) {
                        options = { mimeType: 'audio/mp4' }; 
                         this.log('Using mimeType: audio/mp4');
                    } else {
                         this.log('Using default browser mimeType');
                    }

                    this.mediaRecorder = new MediaRecorder(this.stream, options);
                    
                    this.mediaRecorder.ondataavailable = (event) => {
                        if (event.data && event.data.size > 0) {
                            this.audioChunks.push(event.data);
                            this.log('Data chunk received: ' + event.data.size + ' bytes');
                        }
                    };

                    this.mediaRecorder.onstop = () => {
                        this.log('Recorder stopped');
                        if (this.audioChunks.length === 0) {
                            this.log('Error: No audio data recorded');
                            return;
                        }
                        
                        const mimeType = this.mediaRecorder.mimeType || 'audio/webm';
                        const audioBlob = new Blob(this.audioChunks, { type: mimeType });
                        this.audioUrl = URL.createObjectURL(audioBlob);
                        
                        this.answers[this.currentIndex] = audioBlob;
                        
                        this.log('Blob created (' + mimeType + '), size: ' + audioBlob.size);
                    };

                    this.mediaRecorder.start(1000); 
                    this.isRecording = true;
                    this.log('Recording started');
                    this.startVisualizer();
                    
                    this.recordingStartTime = Date.now();
                    
                    // Countdown Logic for Lesson 3 Part 2 & Lesson 6 Part 2 & Lesson 9 Part 2 & Lesson 8 Part 2 & Lesson 7 Part 2
                    const isCountdown = (this.topic === 'lesson-3' && this.subtopic === 'describing-person') 
                                     || (this.topic === 'lesson-6' && this.subtopic === 'part-2-goal')
                                     || (this.topic === 'lesson-9' && this.subtopic === 'part-2-challenging-task')
                                     || (this.topic === 'lesson-8' && this.subtopic === 'part-2-journey')
                                     || (this.topic === 'lesson-7' && this.subtopic === 'part-2-achievement')
                                     || (this.topic === 'lesson-10' && this.subtopic === 'part-2-change');
                    const maxDuration = 120; // 2 minutes

                    if (isCountdown) {
                        this.recordingDuration = maxDuration;
                    } else {
                        this.recordingDuration = 0;
                    }
                    
                    this.timerInterval = setInterval(() => {
                        const elapsed = Math.floor((Date.now() - this.recordingStartTime) / 1000);
                        if (isCountdown) {
                            this.recordingDuration = Math.max(0, maxDuration - elapsed);
                            if (this.recordingDuration <= 0) {
                                this.stopRecording();
                            }
                        } else {
                            this.recordingDuration = elapsed;
                        }
                    }, 1000);
                } catch (e) {
                    this.log('MediaRecorder error: ' + e.message);
                    alert('Failed to start recording: ' + e.message);
                }
            },

            stopRecording() {
                if (this.mediaRecorder && this.isRecording && this.mediaRecorder.state !== 'inactive') {
                    this.mediaRecorder.stop();
                    this.isRecording = false;
                    clearInterval(this.timerInterval);
                    
                    if (this.animationFrame) {
                        cancelAnimationFrame(this.animationFrame);
                    }
                    this.visualizerBars = new Array(40).fill(5);
                    
                    // Stop Recognition
                    if (this.recognition) {
                        this.recognition.stop();
                        this.log('Speech recognition stopped');
                        // Store transcript
                        if (this.currentTranscript.trim()) {
                            this.transcripts[this.currentIndex] = this.currentTranscript.trim();
                        } else {
                            this.transcripts[this.currentIndex] = "(No speech detected)";
                        }
                    }
                }
            },

            resetRecording() {
                if (this.answers[this.currentIndex]) {
                    this.audioUrl = URL.createObjectURL(this.answers[this.currentIndex]);
                    this.audioUrl = null;
                    this.audioChunks = [];
                    this.transcripts[this.currentIndex] = null;
                    this.currentTranscript = ''; 
                } else {
                    this.audioUrl = null;
                    this.audioChunks = [];
                }
                this.errorMessage = null;
                this.visualizerBars = new Array(40).fill(5);
            },

            saveAnswer() {
                return new Promise((resolve) => {
                    // Safety timeout to ensure we don't hang indefinitely
                    const timeoutId = setTimeout(() => {
                        console.warn('saveAnswer timed out, forcing resolve');
                        resolve();
                    }, 2000);

                    try {
                        if (this.mediaRecorder && this.isRecording && this.mediaRecorder.state !== 'inactive') {
                            const originalOnStop = this.mediaRecorder.onstop;
                            
                            this.mediaRecorder.onstop = (e) => {
                                clearTimeout(timeoutId);
                                try {
                                    if (originalOnStop) originalOnStop(e);
                                } catch (err) {
                                    console.error('Error in original onstop:', err);
                                }
                                resolve();
                            };
                            
                            this.mediaRecorder.stop();
                            this.isRecording = false;
                            clearInterval(this.timerInterval);
                            
                            if (this.animationFrame) {
                                cancelAnimationFrame(this.animationFrame);
                            }
                            this.visualizerBars = new Array(40).fill(5);
                        } else {
                            clearTimeout(timeoutId);
                            resolve();
                        }
                    } catch (e) {
                         console.error('Error stopping recorder:', e);
                         clearTimeout(timeoutId);
                         resolve();
                    }
                });
            },
            
            speakQuestion() {
                if ('speechSynthesis' in window) {
                    this.canRecord = false;
                    window.speechSynthesis.cancel();
                    
                    const utterance = new SpeechSynthesisUtterance(this.currentQuestion);
                    utterance.lang = 'en-US';
                    
                    utterance.onend = () => {
                        this.canRecord = true;
                    };
                    
                    utterance.onerror = () => {
                        console.error('TTS Error');
                        this.canRecord = true; // Fallback
                    };
                    
                    window.speechSynthesis.speak(utterance);
                } else {
                    this.canRecord = true; // No TTS support
                }
            },
            
            startTTSCountdown() {
                // Skip TTS and enable recording immediately for Lesson 3 Part 2 & Lesson 6 Part 2 & Lesson 9 Part 2 & Lesson 8 Part 2 & Lesson 7 Part 2
                if ((this.topic === 'lesson-3' && this.subtopic === 'describing-person') || 
                    (this.topic === 'lesson-6' && this.subtopic === 'part-2-goal') ||
                    (this.topic === 'lesson-9' && this.subtopic === 'part-2-challenging-task') ||
                    (this.topic === 'lesson-8' && this.subtopic === 'part-2-journey') ||
                    (this.topic === 'lesson-7' && this.subtopic === 'part-2-achievement') ||
                    (this.topic === 'lesson-10' && this.subtopic === 'part-2-change')) {
                     if (this.timerInterval) clearInterval(this.timerInterval);
                     if (this.countdownTimer) clearInterval(this.countdownTimer);
                     if ('speechSynthesis' in window) window.speechSynthesis.cancel();
                     
                     this.ttsCountdown = 0;
                     this.canRecord = true;
                     return;
                }

                // Clear any existing timer
                if (this.timerInterval) clearInterval(this.timerInterval);
                if (this.countdownTimer) clearInterval(this.countdownTimer);
                
                // Stop any playing audio/speech
                if ('speechSynthesis' in window) window.speechSynthesis.cancel();

                // Only show countdown for the first question
                if (this.currentIndex > 0) {
                    this.ttsCountdown = 0;
                    this.speakQuestion();
                    return;
                }


                this.canRecord = false;
                this.ttsCountdown = 3;
                
                this.countdownTimer = setInterval(() => {
                    this.ttsCountdown--;
                    if (this.ttsCountdown <= 0) {
                        clearInterval(this.countdownTimer);
                        this.ttsCountdown = 0; // Ensure it stays at 0 (or null if you prefer hiding)
                        this.speakQuestion();
                    }
                }, 1000);
            },

            async next() {
                await this.saveAnswer();
                if ('speechSynthesis' in window) window.speechSynthesis.cancel();
                
                if (this.currentIndex < this.questions.length - 1) {
                    this.currentIndex++;
                    this.updateAssistance();
                    this.resetRecording();
                    this.canRecord = false;
                    // Small delay to allow UI to update before starting countdown
                    setTimeout(() => this.startTTSCountdown(), 100);
                } else {
                    this.submitForGrading();
                }
            },

            async prev() {
                 await this.saveAnswer();
                 if ('speechSynthesis' in window) window.speechSynthesis.cancel();
                 
                 if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.updateAssistance();
                    this.resetRecording();
                    this.canRecord = false;
                    setTimeout(() => this.startTTSCountdown(), 100);
                 }
            },

            updateAssistance() {
                if (Array.isArray(this.allIdioms[0])) {
                    this.idioms = this.allIdioms[this.currentIndex] || [];
                }
                if (Array.isArray(this.allCollocations[0])) {
                    this.collocations = this.allCollocations[this.currentIndex] || [];
                }
                
                if (Array.isArray(this.allAdvancedVerbs[0])) {
                    this.advancedVerbs = this.allAdvancedVerbs[this.currentIndex] || [];
                    window.dispatchEvent(new CustomEvent('update-advanced-verbs', { detail: this.advancedVerbs }));
                }
            }
        };
    }
</script>

    @include('assignments.ielts.speaking.components.advanced_adjectives_modal')
    @include('assignments.ielts.speaking.components.advanced_adverbs_modal')
    @include('assignments.ielts.speaking.components.advanced_verbs_modal')
@endsection
