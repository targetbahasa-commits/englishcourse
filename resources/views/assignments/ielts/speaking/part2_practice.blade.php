@extends('layouts.admin')

@section('content')

@php
    $colorMap = [
        'blue' => ['bg' => 'bg-white', 'text' => 'text-blue-600', 'border' => 'border-blue-200', 'progress' => 'bg-blue-500', 'ring' => 'ring-blue-200', 'hover' => 'hover:bg-blue-200'],
        'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'border' => 'border-green-200', 'progress' => 'bg-green-500', 'ring' => 'ring-green-200', 'hover' => 'hover:bg-green-200'],
        'indigo' => ['bg' => 'bg-white', 'text' => 'text-indigo-600', 'border' => 'border-indigo-200', 'progress' => 'bg-indigo-500', 'ring' => 'ring-indigo-200', 'hover' => 'hover:bg-indigo-200'],
        'orange' => ['bg' => 'bg-white', 'text' => 'text-orange-600', 'border' => 'border-orange-200', 'progress' => 'bg-orange-500', 'ring' => 'ring-orange-200', 'hover' => 'hover:bg-orange-200'],
        'purple' => ['bg' => 'bg-white', 'text' => 'text-purple-600', 'border' => 'border-purple-200', 'progress' => 'bg-purple-500', 'ring' => 'ring-purple-200', 'hover' => 'hover:bg-purple-200'],
        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'border' => 'border-red-200', 'progress' => 'bg-red-500', 'ring' => 'ring-red-200', 'hover' => 'hover:bg-red-200'],
        'cyan' => ['bg' => 'bg-white', 'text' => 'text-cyan-600', 'border' => 'border-cyan-200', 'progress' => 'bg-cyan-500', 'ring' => 'ring-cyan-200', 'hover' => 'hover:bg-cyan-200'],
        'pink' => ['bg' => 'bg-pink-100', 'text' => 'text-pink-600', 'border' => 'border-pink-200', 'progress' => 'bg-pink-500', 'ring' => 'ring-pink-200', 'hover' => 'hover:bg-pink-200'],
        'teal' => ['bg' => 'bg-white', 'text' => 'text-teal-600', 'border' => 'border-teal-200', 'progress' => 'bg-teal-500', 'ring' => 'ring-teal-200', 'hover' => 'hover:bg-teal-200'],
        'emerald' => ['bg' => 'bg-white', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200', 'progress' => 'bg-emerald-500', 'ring' => 'ring-emerald-200', 'hover' => 'hover:bg-emerald-200'],
        'amber' => ['bg' => 'bg-white', 'text' => 'text-amber-600', 'border' => 'border-amber-200', 'progress' => 'bg-amber-500', 'ring' => 'ring-amber-200', 'hover' => 'hover:bg-amber-200'],
        'rose' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'border' => 'border-rose-200', 'progress' => 'bg-rose-500', 'ring' => 'ring-rose-200', 'hover' => 'hover:bg-rose-200'],
        'yellow' => ['bg' => 'bg-white', 'text' => 'text-yellow-600', 'border' => 'border-yellow-200', 'progress' => 'bg-yellow-500', 'ring' => 'ring-yellow-200', 'hover' => 'hover:bg-yellow-200'],
        'gray' => ['bg' => 'bg-white', 'text' => 'text-gray-600', 'border' => 'border-gray-200', 'progress' => 'bg-gray-500', 'ring' => 'ring-gray-200', 'hover' => 'hover:bg-gray-200'],
        'violet' => ['bg' => 'bg-violet-100', 'text' => 'text-violet-600', 'border' => 'border-violet-200', 'progress' => 'bg-violet-500', 'ring' => 'ring-violet-200', 'hover' => 'hover:bg-violet-200'],
        'lime' => ['bg' => 'bg-lime-100', 'text' => 'text-lime-600', 'border' => 'border-lime-200', 'progress' => 'bg-lime-500', 'ring' => 'ring-lime-200', 'hover' => 'hover:bg-lime-200'],
        'fuchsia' => ['bg' => 'bg-fuchsia-100', 'text' => 'text-fuchsia-600', 'border' => 'border-fuchsia-200', 'progress' => 'bg-fuchsia-500', 'ring' => 'ring-fuchsia-200', 'hover' => 'hover:bg-fuchsia-200'],
        'stone' => ['bg' => 'bg-stone-100', 'text' => 'text-stone-600', 'border' => 'border-stone-200', 'progress' => 'bg-stone-500', 'ring' => 'ring-stone-200', 'hover' => 'hover:bg-stone-200'],
        'zinc' => ['bg' => 'bg-zinc-100', 'text' => 'text-zinc-600', 'border' => 'border-zinc-200', 'progress' => 'bg-zinc-500', 'ring' => 'ring-zinc-200', 'hover' => 'hover:bg-zinc-200'],
    ];
    $theme = $colorMap[$topic['color']] ?? $colorMap['blue'];
@endphp

<div class="container mx-auto px-4 py-8" 
     x-data="part2Practice({{ json_encode($idioms ?? []) }}, {{ json_encode($collocations ?? []) }}, {{ json_encode($advanced_verbs ?? []) }}, {{ json_encode($advanced_adverbs ?? []) }}, {{ json_encode($advanced_adjectives ?? []) }})"
     x-init="init()"
     x-cloak>
    
    <!-- Header with Back Button -->
    <div class="mb-8">

        

        
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <div class="p-3 {{ $theme['bg'] }} rounded-xl {{ $theme['text'] }}">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $topic['icon'] }}"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $topic['title'] }}</h1>
                    <p class="text-gray-500">IELTS Speaking Part 2 - The Long Turn</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if(auth()->user() && (auth()->user()->isTeacher() || auth()->user()->isAdmin()))
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('assignments.ielts-academic.speaking.evaluation', ['topic' => $topic['slug']]) }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm font-semibold shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Review Hasil
                    </a>
                    @endif
                    <button @click="showEditModal = true" class="inline-flex items-center px-4 py-2 bg-white text-orange-700 rounded-lg hover:bg-orange-200 transition-colors text-sm font-semibold shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Soal
                    </button>
                @endif
                <a href="{{ route('assignments.ielts-academic.speaking.index', ['part' => 2]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Topics
                </a>
            </div>
        </div>
    </div>

    <!-- Main Card - Unified like Part 1 -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden min-h-[500px] flex flex-col relative">
            
            <!-- Phase Navigation Tab -->
            <div class="bg-white border-b border-gray-100 p-2 flex text-center text-sm font-bold">
                 <div class="flex-1 py-2 rounded-xl transition-colors cursor-pointer" 
                      @click="step !== 'speaking' && (step = 'prep')"
                      :class="{'{{ $theme['bg'] }} {{ $theme['text'] }}': step === 'prep', 'text-gray-400': step !== 'prep'}">
                     1. PREPARE (1 min)
                 </div>
                 <div class="flex-1 py-2 rounded-xl transition-colors"
                      :class="{'{{ $theme['bg'] }} {{ $theme['text'] }} ring-2 ring-offset-1 {{ $theme['ring'] }}': step === 'speaking', 'text-gray-400': step !== 'speaking'}">
                     2. SPEAK (2 min)
                 </div>
            </div>

            <!-- Content Area -->
            <div class="p-8 md:p-12 flex-1 flex flex-col items-center justify-center relative">
                
                <!-- PREPARATION PHASE -->
                <div x-show="step === 'prep'" class="w-full" x-transition:enter="transition ease-out duration-300">
                    <div class="grid md:grid-cols-2 gap-12 items-center">
                        <!-- Left: Cue Card -->
                        <div class="prose prose-lg text-gray-700 bg-white p-6 rounded-2xl border-2 {{ $theme['border'] }}">
                             <p class="font-bold text-xl mb-4 text-gray-900">{{ $topic['questions'][0] }}</p>
                             
                             <p class="text-gray-500 text-xs font-bold uppercase tracking-wide mb-2">You should say:</p>
                             <ul class="list-disc list-inside space-y-1 mb-6 ml-1 text-base">
                                 @foreach(array_slice($topic['questions'], 2, -1) as $point)
                                     <li>{{ ltrim($point, '- ') }}</li>
                                 @endforeach
                             </ul>
                             
                             <div class="font-medium text-gray-800 border-l-4 {{ $theme['border'] }} pl-3 py-1 bg-white rounded-r text-sm">
                                {{ end($topic['questions']) }}
                             </div>
                        </div>

                        <!-- Right: Timer -->
                        <div class="text-center">
                            <h3 class="text-gray-400 font-bold mb-4 uppercase tracking-widest text-sm">Preparation Timer</h3>
                            <div class="relative w-48 h-48 mx-auto flex items-center justify-center mb-8">
                                <!-- Circular Progress (SVG) -->
                                <svg class="w-full h-full transform -rotate-90">
                                    <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="12" fill="none" class="text-gray-100" />
                                    <circle cx="96" cy="96" r="88" stroke="currentColor" stroke-width="12" fill="none" 
                                            class="{{ $theme['text'] }} transition-all duration-1000 ease-linear" 
                                            :stroke-dasharray="2 * Math.PI * 88" 
                                            :stroke-dashoffset="2 * Math.PI * 88 * (1 - prepTimer / 60)" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-5xl font-black text-gray-800 font-mono">
                                    <span x-text="formatTime(prepTimer)"></span>
                                </div>
                                
                                <!-- Pause Button -->
                                <div class="absolute inset-x-0 bottom-8 flex justify-center z-10">
                                     <button @click="togglePause()" 
                                             class="w-8 h-8 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 hover:text-orange-500 hover:border-orange-200 transition-all hover:scale-105"
                                             :title="isPaused ? 'Resume' : 'Pause'">
                                         <template x-if="!isPaused">
                                             <svg class="w-4 h-4 ml-[1px]" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" /></svg>
                                         </template>
                                         <template x-if="isPaused">
                                             <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                         </template>
                                     </button>
                                </div>
                            </div>
                            
                            <button @click="startSpeakingPhase()" 
                                    class="px-8 py-3 rounded-full {{ $theme['bg'] }} {{ $theme['text'] }} font-bold hover:brightness-95 transition-all w-full shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                I'm Ready, Start Speaking
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SPEAKING PHASE -->
                <div x-show="step === 'speaking'" class="text-center w-full max-w-2xl mx-auto" x-transition:enter="transition ease-out duration-300">
                    <h3 class="text-red-500 font-bold mb-4 uppercase tracking-wide animate-pulse flex items-center justify-center gap-2">
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        Recording in Progress...
                    </h3>
                    
                    <!-- Timer -->
                    <div class="text-8xl font-black text-gray-900 font-mono mb-12 tabular-nums tracking-tight">
                        <span x-text="formatMinSec(speakingTimer)"></span>
                    </div>

                    <!-- Visualizer -->
                    <div class="h-24 flex items-center justify-center gap-1.5 mb-12 bg-white rounded-2xl p-4 border border-gray-100">
                       <template x-for="(barHeight, index) in visualizerBars" :key="index">
                           <div class="w-2 rounded-full transition-all duration-75 ease-linear"
                                :class="index % 2 === 0 ? 'bg-red-400' : 'bg-orange-400'"
                                :style="'height: ' + Math.max(10, barHeight) + '%;'"></div>
                       </template>
                    </div>

                    <div class="flex justify-center gap-4">
                        <button @click="finishSpeakingPhase()" 
                                class="w-20 h-20 rounded-full border-4 border-red-500 flex items-center justify-center hover:bg-red-50 transition-all group relative">
                            <div class="w-8 h-8 bg-red-500 rounded-sm group-hover:scale-90 transition-transform"></div>
                        </button>
                    </div>
                    <p class="text-gray-400 text-sm mt-4 font-medium">Press stop when finished</p>
                </div>

                <!-- (Review Phase removed) -->

            </div>

            <!-- Inline Helper Buttons (Part 1 Style) -->
            <div class="bg-white p-4 border-t border-gray-100 flex justify-center gap-4">
                <button @click="isCollocationsOpen = !isCollocationsOpen" 
                        class="px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors bg-white text-teal-700 hover:bg-teal-200">
                    <span class="text-lg">🔗</span> Collocations
                </button>

                <button @click="isIdiomsOpen = !isIdiomsOpen" 
                        class="px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition-colors bg-white text-orange-700 hover:bg-orange-200">
                    <span class="text-lg"></span> Idioms
                </button>

                <!-- Whiteboard Button -->
                <button @click="toggleBoard()" 
                        class="w-10 h-10 rounded-full flex items-center justify-center transition-colors shadow-sm border border-indigo-100"
                        :class="isBoardOpen ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-white text-indigo-600 hover:bg-white'"
                        title="Open Whiteboard">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
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

    <!-- Floating Advanced Vocab Buttons (Part 1 Style) - REPLACED BY COMPONENTS -->

    <!-- Edit Questions Modal -->
    @if(isset($topic['id']))
    <template x-teleport="body">
        <div x-show="showEditModal" 
             class="fixed inset-0 z-[9999] overflow-y-auto" 
             style="display: none;">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showEditModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all" @click.stop>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Topic Content</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>

                    <!-- Tabs -->
                    <div class="flex border-b border-gray-200 mb-4 gap-4 overflow-x-auto">
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'questions' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'questions'">Questions</button>
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'part3_questions' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'part3_questions'">Part 3 Questions</button>
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'idioms' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'idioms'">Idioms</button>
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'collocations' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'collocations'">Collocations</button>
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'adv_verbs' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'adv_verbs'">Adv. Verbs</button>
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'adv_adverbs' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'adv_adverbs'">Adv. Adverbs</button>
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'adv_adjectives' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'adv_adjectives'">Adv. Adjectives</button>
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'part3_idioms' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'part3_idioms'">Part 3 Idioms</button>
                        <button class="pb-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap" :class="editTab === 'part3_collocations' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700'" @click="editTab = 'part3_collocations'">Part 3 Collocations</button>
                    </div>

                    <form action="{{ route('admin.ielts.speaking.topics.update-questions', $topic['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="max-h-[60vh] overflow-y-auto px-1 pb-4">
                            <!-- Questions Tab -->
                            <div x-show="editTab === 'questions'">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Questions (One per line)</label>
                                <textarea name="questions_raw" x-model="editingQuestions" rows="10" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"></textarea>
                                <div class="hidden">
                                    <template x-for="(q, index) in editingQuestions.split('\n').map(q => q.trim()).filter(q => q)" :key="index">
                                        <input type="hidden" x-bind:name="`questions[${index}]`" x-bind:value="q">
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Part 3 Questions Tab -->
                            <div x-show="editTab === 'part3_questions'">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Part 3 Questions (One per line)</label>
                                <textarea name="part3_questions_raw" x-model="editingPart3Questions" rows="10" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"></textarea>
                                <div class="hidden">
                                    <template x-for="(q, index) in editingPart3Questions.split('\n').map(q => q.trim()).filter(q => q)" :key="index">
                                        <input type="hidden" x-bind:name="`part3_questions[${index}]`" x-bind:value="q">
                                    </template>
                                </div>
                            </div>

                            <!-- Idioms Tab -->
                            <div x-show="editTab === 'idioms'" class="space-y-4">
                                <template x-for="(item, index) in editIdioms" :key="index">
                                    <div class="bg-white p-4 rounded-lg relative">
                                        <button type="button" @click="editIdioms.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">Delete</button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><label class="text-xs font-bold">Phrase</label><input type="text" x-model="item.phrase" x-bind:name="`idioms[${index}][phrase]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning</label><input type="text" x-model="item.meaning" x-bind:name="`idioms[${index}][meaning]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div class="col-span-2"><label class="text-xs font-bold">Example</label><input type="text" x-model="item.example" x-bind:name="`idioms[${index}][example]`" class="w-full rounded border-gray-300 text-sm"></div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="editIdioms.push({phrase:'', meaning:'', example:''})" class="text-orange-600 text-sm font-bold">+ Add Idiom</button>
                            </div>

                            <!-- Part 3 Idioms Tab -->
                            <div x-show="editTab === 'part3_idioms'" class="space-y-4">
                                <template x-for="(item, index) in editPart3Idioms" :key="index">
                                    <div class="bg-white p-4 rounded-lg relative">
                                        <button type="button" @click="editPart3Idioms.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">Delete</button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><label class="text-xs font-bold">Phrase</label><input type="text" x-model="item.phrase" x-bind:name="`part3_idioms[${index}][phrase]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning</label><input type="text" x-model="item.meaning" x-bind:name="`part3_idioms[${index}][meaning]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div class="col-span-2"><label class="text-xs font-bold">Example</label><input type="text" x-model="item.example" x-bind:name="`part3_idioms[${index}][example]`" class="w-full rounded border-gray-300 text-sm"></div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="editPart3Idioms.push({phrase:'', meaning:'', example:''})" class="text-orange-600 text-sm font-bold">+ Add Part 3 Idiom</button>
                            </div>

                            <!-- Collocations Tab -->
                            <div x-show="editTab === 'collocations'" class="space-y-4">
                                <template x-for="(item, index) in editCollocations" :key="index">
                                    <div class="bg-white p-4 rounded-lg relative">
                                        <button type="button" @click="editCollocations.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">Delete</button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><label class="text-xs font-bold">Phrase</label><input type="text" x-model="item.phrase" x-bind:name="`collocations[${index}][phrase]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning</label><input type="text" x-model="item.meaning" x-bind:name="`collocations[${index}][meaning]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div class="col-span-2"><label class="text-xs font-bold">Example</label><input type="text" x-model="item.example" x-bind:name="`collocations[${index}][example]`" class="w-full rounded border-gray-300 text-sm"></div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="editCollocations.push({phrase:'', meaning:'', example:''})" class="text-orange-600 text-sm font-bold">+ Add Collocation</button>
                            </div>
                            
                            <!-- Part 3 Collocations Tab -->
                            <div x-show="editTab === 'part3_collocations'" class="space-y-4">
                                <template x-for="(item, index) in editPart3Collocations" :key="index">
                                    <div class="bg-white p-4 rounded-lg relative">
                                        <button type="button" @click="editPart3Collocations.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">Delete</button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><label class="text-xs font-bold">Phrase</label><input type="text" x-model="item.phrase" x-bind:name="`part3_collocations[${index}][phrase]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning</label><input type="text" x-model="item.meaning" x-bind:name="`part3_collocations[${index}][meaning]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div class="col-span-2"><label class="text-xs font-bold">Example</label><input type="text" x-model="item.example" x-bind:name="`part3_collocations[${index}][example]`" class="w-full rounded border-gray-300 text-sm"></div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="editPart3Collocations.push({phrase:'', meaning:'', example:''})" class="text-orange-600 text-sm font-bold">+ Add Part 3 Collocation</button>
                            </div>

                            <!-- Adv Verbs Tab -->
                            <div x-show="editTab === 'adv_verbs'" class="space-y-4">
                                <template x-for="(item, index) in editAdvVerbs" :key="index">
                                    <div class="bg-white p-4 rounded-lg relative">
                                        <button type="button" @click="editAdvVerbs.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">Delete</button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><label class="text-xs font-bold">Phrase</label><input type="text" x-model="item.phrase" x-bind:name="`advanced_verbs[${index}][phrase]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning</label><input type="text" x-model="item.meaning" x-bind:name="`advanced_verbs[${index}][meaning]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Level</label><input type="text" x-model="item.level" x-bind:name="`advanced_verbs[${index}][level]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning ID</label><input type="text" x-model="item.meaning_id" x-bind:name="`advanced_verbs[${index}][meaning_id]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div class="col-span-2"><label class="text-xs font-bold">Example</label><input type="text" x-model="item.example" x-bind:name="`advanced_verbs[${index}][example]`" class="w-full rounded border-gray-300 text-sm"></div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="editAdvVerbs.push({phrase:'', meaning:'', level:'', meaning_id:'', example:''})" class="text-orange-600 text-sm font-bold">+ Add Advanced Verb</button>
                            </div>

                            <!-- Adv Adverbs Tab -->
                            <div x-show="editTab === 'adv_adverbs'" class="space-y-4">
                                <template x-for="(item, index) in editAdvAdverbs" :key="index">
                                    <div class="bg-white p-4 rounded-lg relative">
                                        <button type="button" @click="editAdvAdverbs.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">Delete</button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><label class="text-xs font-bold">Phrase</label><input type="text" x-model="item.phrase" x-bind:name="`advanced_adverbs[${index}][phrase]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning</label><input type="text" x-model="item.meaning" x-bind:name="`advanced_adverbs[${index}][meaning]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Level</label><input type="text" x-model="item.level" x-bind:name="`advanced_adverbs[${index}][level]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning ID</label><input type="text" x-model="item.meaning_id" x-bind:name="`advanced_adverbs[${index}][meaning_id]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div class="col-span-2"><label class="text-xs font-bold">Example</label><input type="text" x-model="item.example" x-bind:name="`advanced_adverbs[${index}][example]`" class="w-full rounded border-gray-300 text-sm"></div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="editAdvAdverbs.push({phrase:'', meaning:'', level:'', meaning_id:'', example:''})" class="text-orange-600 text-sm font-bold">+ Add Advanced Adverb</button>
                            </div>

                            <!-- Adv Adjectives Tab -->
                            <div x-show="editTab === 'adv_adjectives'" class="space-y-4">
                                <template x-for="(item, index) in editAdvAdjectives" :key="index">
                                    <div class="bg-white p-4 rounded-lg relative">
                                        <button type="button" @click="editAdvAdjectives.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700">Delete</button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><label class="text-xs font-bold">Phrase</label><input type="text" x-model="item.phrase" x-bind:name="`advanced_adjectives[${index}][phrase]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning</label><input type="text" x-model="item.meaning" x-bind:name="`advanced_adjectives[${index}][meaning]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Level</label><input type="text" x-model="item.level" x-bind:name="`advanced_adjectives[${index}][level]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div><label class="text-xs font-bold">Meaning ID</label><input type="text" x-model="item.meaning_id" x-bind:name="`advanced_adjectives[${index}][meaning_id]`" class="w-full rounded border-gray-300 text-sm"></div>
                                            <div class="col-span-2"><label class="text-xs font-bold">Example</label><input type="text" x-model="item.example" x-bind:name="`advanced_adjectives[${index}][example]`" class="w-full rounded border-gray-300 text-sm"></div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="editAdvAdjectives.push({phrase:'', meaning:'', level:'', meaning_id:'', example:''})" class="text-orange-600 text-sm font-bold">+ Add Advanced Adjective</button>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-200 rounded-lg transition-colors" @click="showEditModal = false">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-lg shadow-sm transition-colors">
                                Save All Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
    @endif

    <!-- SLIDE OVERS (Copied from Part 1) -->
    
    <!-- Idioms Panel -->
    <template x-if="isIdiomsOpen">
        <div class="fixed inset-y-0 right-0 w-80 z-[100] flex pointer-events-none">
            <div class="w-full h-full pointer-events-auto bg-white shadow-2xl flex flex-col transform transition-transform" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="translate-x-full" 
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300" 
                 x-transition:leave-start="translate-x-0" 
                 x-transition:leave-end="translate-x-full">
                 <div class="p-4 bg-white border-b border-orange-100 flex justify-between items-center">
                     <h3 class="font-bold text-orange-800"> Idioms</h3>
                     <button @click="isIdiomsOpen = false" class="text-orange-400 hover:text-orange-600">&times;</button>
                 </div>
                 <div class="flex-1 overflow-y-auto p-4 space-y-4">
                     <template x-for="item in idioms">
                         <div class="p-3 bg-white border border-orange-100 rounded-xl shadow-sm">
                             <div class="font-bold text-orange-600" x-text="item.phrase"></div>
                             <div class="text-sm text-gray-600 italic" x-text="item.meaning"></div>
                             <div class="mt-2 text-xs bg-white p-2 rounded text-gray-500" x-text="item.example"></div>
                         </div>
                     </template>
                     <div x-show="!idioms.length" class="text-center text-gray-400 mt-10">No idioms available.</div>
                 </div>
            </div>
        </div>
    </template>

    <!-- Collocations Panel -->
    <template x-if="isCollocationsOpen">
        <div class="fixed inset-y-0 left-0 w-80 z-[100] flex pointer-events-none">
            <div class="w-full h-full pointer-events-auto bg-white shadow-2xl flex flex-col transform transition-transform"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                 <div class="p-4 bg-white border-b border-teal-100 flex justify-between items-center">
                     <h3 class="font-bold text-teal-800">🔗 Collocations</h3>
                     <button @click="isCollocationsOpen = false" class="text-teal-400 hover:text-teal-600">&times;</button>
                 </div>
                 <div class="flex-1 overflow-y-auto p-4 space-y-4">
                     <template x-for="item in collocations">
                         <div class="p-3 bg-white border border-teal-100 rounded-xl shadow-sm">
                             <div class="font-bold text-teal-600" x-text="item.phrase"></div>
                             <div class="text-sm text-gray-600 italic" x-text="item.meaning"></div>
                             <div class="mt-2 text-xs bg-white p-2 rounded text-gray-500" x-text="item.example"></div>
                         </div>
                     </template>
                 </div>
            </div>
        </div>
    </template>

<script>
    function part2Practice(idioms = [], collocations = [], advancedVerbs = [], advancedAdverbs = [], advancedAdjectives = []) {
        const topicData = @json($topic);
        return {
            showEditModal: false,
            editTab: 'questions',
            editingQuestions: (topicData.questions || []).join('\n'),
            editingPart3Questions: (topicData.part3_questions || []).join('\n'),
            editIdioms: JSON.parse(JSON.stringify(idioms || [])),
            editCollocations: JSON.parse(JSON.stringify(collocations || [])),
            editAdvVerbs: JSON.parse(JSON.stringify(advancedVerbs || [])),
            editAdvAdverbs: JSON.parse(JSON.stringify(advancedAdverbs || [])),
            editAdvAdjectives: JSON.parse(JSON.stringify(advancedAdjectives || [])),
            editPart3Idioms: JSON.parse(JSON.stringify(topicData.part3_idioms || [])),
            editPart3Collocations: JSON.parse(JSON.stringify(topicData.part3_collocations || [])),

            step: 'prep', // prep, speaking
            prepTimer: 60,
            speakingTimer: 120, // 2 minutes
            interval: null,
            mediaRecorder: null,
            audioChunks: [],
            audioUrl: null,
            audioBlob: null,
            stream: null,
            isPaused: false,
            isGrading: false,
            
            // Visualizer props
            visualizerBars: new Array(40).fill(5),
            audioContext: null,
            analyser: null,
            source: null,
            animationFrame: null,
            
            currentTranscript: '',
            recognition: null,

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
            
            // Vocab Data
            idioms: idioms,
            collocations: collocations,
            advancedVerbs: advancedVerbs,
            advancedAdverbs: advancedAdverbs,
            advancedAdjectives: advancedAdjectives,

            // Slide-over States
            isIdiomsOpen: false,
            isCollocationsOpen: false,


            init() {
                this.startPrepTimer();
                this.requestMicrophone();
            },

            async requestMicrophone() {
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                } catch (err) {
                    console.error('Microphone access denied:', err);
                    alert('Please allow microphone access to record your answer.');
                }
            },

            startPrepTimer() {
                this.step = 'prep';
                this.prepTimer = 60;
                this.isPaused = false;
                
                if (this.interval) clearInterval(this.interval);
                
                this.interval = setInterval(() => {
                    if (!this.isPaused) {
                        if (this.prepTimer > 0) {
                            this.prepTimer--;
                        } else {
                            this.startSpeakingPhase();
                        }
                    }
                }, 1000);
            },

            togglePause() {
                this.isPaused = !this.isPaused;
            },

            startSpeakingPhase() {
                clearInterval(this.interval);
                this.step = 'speaking';
                this.speakingTimer = 120;
                this.startRecording();
                
                // Close any open panels
                this.isIdiomsOpen = false;
                this.isCollocationsOpen = false;
                // Advanced Vocab modals handle their own state

                
                this.interval = setInterval(() => {
                    if (this.speakingTimer > 0) {
                        this.speakingTimer--;
                    } else {
                        this.finishSpeakingPhase();
                    }
                }, 1000);
            },

            finishSpeakingPhase() {
                clearInterval(this.interval);
                this.stopRecording();
            },

            startRecording() {
                if (!this.stream) return;
                this.audioChunks = [];
                this.mediaRecorder = new MediaRecorder(this.stream);
                
                this.currentTranscript = '';
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
                        }
                    };
                    
                    try {
                        this.recognition.start();
                    } catch (e) { console.error('Speech recognition start failed:', e); }
                }

                this.mediaRecorder.ondataavailable = event => {
                    this.audioChunks.push(event.data);
                };

                this.mediaRecorder.onstop = () => {
                    this.audioBlob = new Blob(this.audioChunks, { type: 'audio/wav' });
                    this.audioUrl = URL.createObjectURL(this.audioBlob);
                    this.submitForGrading();
                };

                this.mediaRecorder.start();
                this.startVisualizer();
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
                    if (this.step !== 'speaking') return;
                    
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

            stopRecording() {
                if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                    this.mediaRecorder.stop();
                }
                if (this.recognition) {
                    try { this.recognition.stop(); } catch (e) {}
                }
                if (this.animationFrame) {
                    cancelAnimationFrame(this.animationFrame);
                }
                this.visualizerBars = new Array(40).fill(5);
            },

            reset() {
                if(this.stream) {
                     this.stream.getTracks().forEach(track => track.stop());
                }
                this.audioUrl = null;
                this.requestMicrophone(); 
                this.startPrepTimer();
            },

            formatTime(seconds) {
                return seconds < 10 ? '0' + seconds : seconds;
            },

            formatMinSec(seconds) {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                return `${m < 10 ? '0' + m : m}:${s < 10 ? '0' + s : s}`;
            },

            async submitForGrading() {
                if (!this.audioBlob) {
                    alert("No audio recorded to submit.");
                    return;
                }

                this.isGrading = true;
                
                const formData = new FormData();
                formData.append('audio_blobs[]', this.audioBlob, 'question_0.webm');
                
                // Construct the full prompt/question
                const cueCardText = "{{ $topic['questions'][0] ?? '' }}";
                const bulletPoints = @json(array_slice($topic['questions'], 2, -1));
                const finalPoint = "{{ end($topic['questions']) }}";
                
                let fullQuestion = cueCardText + "\n\nYou should say:\n";
                bulletPoints.forEach(pt => fullQuestion += pt + "\n");
                fullQuestion += "\n" + finalPoint;

                formData.append('questions[0]', fullQuestion);
                if (this.currentTranscript) {
                    formData.append('transcripts[0]', this.currentTranscript.trim());
                }
                formData.append('part', '{{ $topic['part'] ?? 2 }}');
                formData.append('topic_title', '{{ $topic['title'] ?? '' }}');
                
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                        window.location.href = data.redirect_url;
                    } else {
                        alert("Grading complete, but no redirect URL provided.");
                        this.isGrading = false;
                    }
                    
                } catch (error) {
                    alert('Failed to submit for grading:\n' + error.message);
                    this.isGrading = false;
                }
            },



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
            
            clearBoard() {
                if (!this.bgContext) return;
                const canvas = this.$refs.whiteboard;
                this.bgContext.clearRect(0, 0, canvas.width, canvas.height);
                this.isTyping = false;
                this.currentText = '';
            }
        }
    }
</script>

    @include('assignments.ielts.speaking.components.advanced_adjectives_modal')
    @include('assignments.ielts.speaking.components.advanced_adverbs_modal')
    @include('assignments.ielts.speaking.components.advanced_verbs_modal')
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
        <div class="bg-white p-3 flex justify-between items-center cursor-move border-b border-gray-200 select-none"
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
                            class="p-1.5 rounded hover:bg-white transition-colors"
                            :class="{'bg-white text-indigo-600': currentTool === 'pen', 'text-gray-500': currentTool !== 'pen'}"
                            title="Pen">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                    <button @click="setTool('text')" 
                            class="p-1.5 rounded hover:bg-white transition-colors"
                            :class="{'bg-white text-indigo-600': currentTool === 'text', 'text-gray-500': currentTool !== 'text'}"
                            title="Text Tool">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M12 6v14" />
                        </svg>
                    </button>
                    <button @click="setTool('eraser')" 
                            class="p-1.5 rounded hover:bg-white transition-colors"
                            :class="{'bg-white text-indigo-600': currentTool === 'eraser', 'text-gray-500': currentTool !== 'eraser'}"
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

                <button @click="drawGrid()" @mousedown.stop class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-white rounded transition-colors" title="Divide Board (4 Parts)">
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
    </div>
</div>
@endsection
