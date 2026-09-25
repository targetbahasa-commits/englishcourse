@extends('layouts.admin')

@section('title', ($meeting->title ?? 'Reading Material') . ' - IELTS Reading')

@section('content')
@php
    $isSingle = isset($content['passage_title']);
    $sections = $isSingle ? [$content] : $content;
    $globalQIndex = 0;
    $hasAnswerKey = false;

    foreach ($sections as $section) {
        foreach (($section['questions'] ?? []) as $question) {
            $correctAnswer = $question['correct_answer'] ?? ($question['data']['correct_answer'] ?? null);
            $hasCorrectAnswer = false;

            if (is_array($correctAnswer)) {
                $hasCorrectAnswer = count(array_filter($correctAnswer, static fn ($value) => filled($value))) > 0;
            } else {
                $hasCorrectAnswer = filled($correctAnswer);
            }

            $hasExplanation = filled($question['explanation'] ?? null);

            if ($hasCorrectAnswer || $hasExplanation) {
                $hasAnswerKey = true;
                break 2;
            }
        }
    }
@endphp

<!-- Full-screen reading layout — fixed to viewport, bypasses admin layout chain -->
<!-- Full-screen reading layout — fixed to viewport, bypasses admin layout chain -->
<div id="mat-outer" class="fixed inset-0 z-0 grid grid-rows-[auto_1fr] bg-white transition-[padding] duration-200 ease-in-out">
    <!-- Header (fixed height) -->
    <div id="mat-header" class="flex-none bg-white border-b border-gray-200 shadow-sm z-10">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-2.5 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-md">
                        <span class="text-white font-bold text-xl leading-none">{{ $id }}</span>
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800 leading-tight">{{ $title }}</h1>
                        <p class="text-gray-500 text-xs md:text-sm font-medium">{{ (!empty($isGeneral) || request()->routeIs('assignments.ielts-general*')) ? 'IELTS General Reading' : 'IELTS Academic Reading' }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <!-- Autosave Status Indicator -->
                    <div id="autosave-status" class="{{ isset($existingResult) ? 'hidden' : 'flex' }} items-center gap-1.5 text-xs text-gray-500 font-medium px-2.5 py-1 rounded-full bg-gray-50 border border-gray-200">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Autosave Aktif</span>
                    </div>

                    <!-- Header Score Badge -->
                    <div id="header-score-badge" class="{{ isset($existingResult) ? 'flex' : 'hidden' }} items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-full font-bold text-xs shadow-sm">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span id="header-score-text">
                            @if(isset($existingResult))
                                Band {{ number_format($existingResult->band_score, 1) }} ({{ $existingResult->correct_count }}/{{ $existingResult->total_questions }})
                            @endif
                        </span>
                    </div>

                    <!-- Header Kerjakan Ulang Button -->
                    <button type="button" id="header-retry-btn" onclick="confirmResetPractice()" class="{{ isset($existingResult) ? 'inline-flex' : 'hidden' }} items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-rose-50 text-rose-600 hover:text-rose-700 border border-rose-200 rounded-lg text-xs font-bold transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span>Kerjakan Ulang</span>
                    </button>

                    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher()))
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border {{ $hasAnswerKey ? 'bg-white text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                            <span>{{ $hasAnswerKey ? '✓' : '✕' }}</span>
                            <span>{{ $hasAnswerKey ? 'Answer Key Ditambahkan' : 'Answer Key Belum Ada' }}</span>
                        </span>
                    @endif

                    @if(!empty($isMockTestView) && isset($edition) && isset($testId))
                        <a href="{{ route('mock-test.ielts-general.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span class="hidden md:inline">Back to Test Hub</span>
                        </a>
                    @elseif(!empty($isGeneral) || request()->routeIs('assignments.ielts-general*'))
                        <a href="{{ route('assignments.ielts-general.reading.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span class="hidden md:inline">Back</span>
                        </a>
                    @else
                        <a href="{{ route('assignments.ielts-academic.reading.practice-index') }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span class="hidden md:inline">Back</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Split Screen: grid fills remaining vertical space -->
    <div id="mat-grid" class="min-h-0 grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">

            
            <!-- LEFT PANEL: Passages -->
            <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar relative">
                <div class="pl-6 pr-3 md:pl-8 md:pr-4 pt-6 md:pt-8 pb-32">
                    @if(($isSkillView ?? false) && empty($sections))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center text-gray-500">
                            <p class="font-medium">Belum ada soal tipe ini yang tersedia.</p>
                            <p class="text-sm mt-1">Silakan coba tipe soal lain, atau kembali lagi nanti setelah konten ditambahkan.</p>
                        </div>
                    @elseif(!($isSkillView ?? false) && empty($sections))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center text-gray-500">
                            <p class="font-medium">Test ini belum punya passage sama sekali.</p>
                            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher()))
                                <p class="text-sm mt-1 mb-4">Tambahkan passage pertama untuk mulai mengisi konten test ini.</p>
                                <button onclick="openPassageModal()" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">+ Add Passage</button>
                            @else
                                <p class="text-sm mt-1">Silakan kembali lagi nanti setelah konten ditambahkan.</p>
                            @endif
                        </div>
                    @endif
                    @if($sections)
                        @foreach($sections as $index => $section)
                            <!-- Passage Card -->
                            <div id="passage-{{ $index }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 relative group">
                                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $totalSections = count($sections);
                                            if ($totalSections === 5) {
                                                $sectionLabels = [
                                                    0 => 'Section 1 · Passage 1',
                                                    1 => 'Section 1 · Passage 2',
                                                    2 => 'Section 2 · Passage 1 (Passage 3)',
                                                    3 => 'Section 2 · Passage 2 (Passage 4)',
                                                    4 => 'Section 3 · Passage 5',
                                                ];
                                                $passageBadge = $sectionLabels[$index] ?? "Passage " . ($index + 1);
                                            } else {
                                                $passageBadge = "Passage " . ($index + 1);
                                            }
                                        @endphp
                                        <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">{{ $passageBadge }}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        @if(isset($section['id']) && !($isSkillView ?? false))
                                            <button onclick="openPassageModal({{ $index }})" class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg transition-colors">Edit</button>
                                            <button onclick="deletePassage({{ $section['id'] }})" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition-colors">Delete</button>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="relative" 
                                     x-data="{ 
                                        translateMode: false, 
                                        highlightMode: false,
                                        pencilMode: false,
                                        eraserMode: false,
                                        highlightColor: 'yellow',
                                        originalContent: `{{ $section['passage_text'] }}`,
                                        canvasObj: null
                                    }"
                                    x-init="
                                        $watch('pencilMode', value => {
                                            if (value && !canvasObj) {
                                                canvasObj = window.initDrawingCanvas($refs.drawingCanvas);
                                            }
                                            if (value && canvasObj) canvasObj.setMode('draw');
                                        });
                                        $watch('eraserMode', value => {
                                            if (value && !canvasObj) {
                                                canvasObj = window.initDrawingCanvas($refs.drawingCanvas);
                                            }
                                            if (value && canvasObj) canvasObj.setMode('erase');
                                        });
                                        new ResizeObserver(() => {
                                            if (canvasObj) canvasObj.resize();
                                        }).observe($el);
                                    "
                                >
                                    <!-- Drawing Canvas -->
                                    <canvas x-ref="drawingCanvas" 
                                            class="absolute inset-0 w-full h-full z-10" 
                                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'"
                                    ></canvas>

                                    <div class="passage-content max-w-none text-gray-900 leading-relaxed pr-2 sm:pr-0 pb-12"
                                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);">
                                        <style>
                                            .passage-content h2,
                                            .passage-content p:first-child {
                                                text-align: center !important;
                                                font-weight: 700 !important;
                                                font-size: 1.5rem !important;
                                                margin-top: 0.5rem !important;
                                                margin-bottom: 1.5rem !important;
                                                color: #111827 !important;
                                            }
                                        </style>
                                        {!! $section['passage_text'] !!}
                                    </div>

                                    <!-- Floating Toolbar -->
                                    <div class="sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2">
                                        <!-- Color Palette (positioned above toolbar) -->
                                        <div x-show="highlightMode" 
                                             class="flex gap-2 p-2 bg-white/95 backdrop-blur-md rounded-full shadow-xl border border-gray-100 mb-3 pointer-events-auto"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 translate-y-4"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             style="display: none;">
                                            <button @click.prevent.stop="highlightColor = 'yellow'" class="w-8 h-8 rounded-full bg-yellow-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor === 'yellow' ? 'ring-2 ring-yellow-500 scale-110' : 'hover:ring-yellow-400'"></button>
                                            <button @click.prevent.stop="highlightColor = 'green'" class="w-8 h-8 rounded-full bg-green-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor === 'green' ? 'ring-2 ring-green-500 scale-110' : 'hover:ring-green-400'"></button>
                                            <button @click.prevent.stop="highlightColor = 'blue'" class="w-8 h-8 rounded-full bg-blue-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor === 'blue' ? 'ring-2 ring-blue-500 scale-110' : 'hover:ring-blue-400'"></button>
                                            <button @click.prevent.stop="highlightColor = 'pink'" class="w-8 h-8 rounded-full bg-pink-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor === 'pink' ? 'ring-2 ring-pink-500 scale-110' : 'hover:ring-pink-400'"></button>
                                        </div>

                                        <div class="flex justify-center items-center gap-3 pointer-events-auto bg-white/40 p-1.5 rounded-full backdrop-blur-md shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-200/50">
                                            <!-- Translate Button -->
                                            <button 
                                                @click="
                                                    let isTranslating = translateMode;
                                                    translateMode = !isTranslating;
                                                    highlightMode = false;
                                                    pencilMode = false;
                                                    eraserMode = false;
                                                    if(document.querySelector('.passage-translated') || isTranslating) {
                                                        toggleTranslate($el.closest('.relative').parentElement, false, originalContent);
                                                    } else {
                                                        toggleTranslate($el.closest('.relative').parentElement, true, originalContent);
                                                    }
                                                "
                                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white hover:opacity-100 opacity-90 hover:shadow-md hover:text-yellow-600 hover:border-yellow-400 hover:scale-105 transition-all"
                                                :class="{ '!bg-yellow-400 !text-white !border-yellow-500 shadow-md !opacity-100': translateMode }"
                                                title="Translate Tool"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                            </button>
                                            
                                            <!-- Highlight Button -->
                                            <button 
                                                @click="
                                                    highlightMode = !highlightMode;
                                                    pencilMode = false;
                                                    eraserMode = false;
                                                    let wasTranslate = translateMode;
                                                    translateMode = false;
                                                    if(document.querySelector('.passage-translated') || wasTranslate) {
                                                        toggleTranslate($el.closest('.relative').parentElement, false, originalContent);
                                                    }
                                                "
                                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white hover:opacity-100 opacity-90 hover:shadow-md hover:text-green-600 hover:border-green-400 hover:scale-105 transition-all"
                                                :class="{ '!bg-green-500 !text-white !border-green-600 shadow-md !opacity-100': highlightMode }"
                                                title="Highlight Tool"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </button>

                                            <!-- Pencil Button -->
                                            <button 
                                                @click="
                                                    pencilMode = !pencilMode;
                                                    highlightMode = false;
                                                    eraserMode = false;
                                                    let wasTranslate = translateMode;
                                                    translateMode = false;
                                                    if(document.querySelector('.passage-translated') || wasTranslate) {
                                                        toggleTranslate($el.closest('.relative').parentElement, false, originalContent);
                                                    }
                                                "
                                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white hover:opacity-100 opacity-90 hover:shadow-md hover:text-blue-600 hover:border-blue-400 hover:scale-105 transition-all"
                                                :class="{ '!bg-blue-500 !text-white !border-blue-600 shadow-md !opacity-100': pencilMode }"
                                                title="Notes Tool"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>

                                            <!-- Eraser Button -->
                                            <button 
                                                @click="
                                                    eraserMode = !eraserMode;
                                                    pencilMode = false;
                                                    highlightMode = false;
                                                    let wasTranslate = translateMode;
                                                    translateMode = false;
                                                    if(document.querySelector('.passage-translated') || wasTranslate) {
                                                        toggleTranslate($el.closest('.relative').parentElement, false, originalContent);
                                                    }
                                                "
                                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white hover:opacity-100 opacity-90 hover:shadow-md hover:text-indigo-600 hover:border-indigo-400 hover:scale-105 transition-all"
                                                :class="{ '!bg-indigo-500 !text-white !border-indigo-600 shadow-md !opacity-100': eraserMode }"
                                                title="Eraser Tool"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @endif
                    
                    

                </div>
            </div>

                <!-- RIGHT PANEL: Questions -->
            <div id="questions-panel" class="h-full overflow-y-auto bg-white custom-scrollbar relative">
                
                <div class="p-1 md:p-2 pb-32">
                     @if($sections)
                        @foreach($sections as $index => $section)
                            <!-- Questions Card -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-3 mb-4" data-passage-index="{{ $index }}">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-2">
                                        @php
                                            if ($totalSections === 5) {
                                                $qSectionLabels = [
                                                    0 => 'Questions for Section 1 (Passage 1)',
                                                    1 => 'Questions for Section 1 (Passage 2)',
                                                    2 => 'Questions for Section 2 (Passage 3)',
                                                    3 => 'Questions for Section 2 (Passage 4)',
                                                    4 => 'Questions for Section 3 (Passage 5)',
                                                ];
                                                $qBadge = $qSectionLabels[$index] ?? "Questions for Passage " . ($index + 1);
                                            } else {
                                                $qBadge = "Questions for Passage " . ($index + 1);
                                            }
                                        @endphp
                                        <span class="text-xs font-bold text-red-500 uppercase tracking-wider">{{ $qBadge }}</span>
                                        <div class="h-px bg-gray-200 flex-1"></div>
                                    </div>
                                    @if(!($isSkillView ?? false))
                                        <button onclick="openQuestionModal({{ $index }})" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg transition-colors">+ Add Question</button>
                                    @endif
                                </div>

                                @foreach($section['questions'] as $qIndex => $question)
                                    @php
                                        $maxSelect = 1;
                                        if (isset($question['type']) && in_array($question['type'], ['checkbox', 'multiple_choice_multiple'])) {
                                            if (isset($question['correct_answer']) && is_array($question['correct_answer'])) {
                                                $maxSelect = count($question['correct_answer']);
                                            } else {
                                                $qTxtUpper = strtoupper($question['text'] ?? '');
                                                if (str_contains($qTxtUpper, 'FIVE')) $maxSelect = 5;
                                                elseif (str_contains($qTxtUpper, 'FOUR')) $maxSelect = 4;
                                                elseif (str_contains($qTxtUpper, 'THREE')) $maxSelect = 3;
                                                elseif (str_contains($qTxtUpper, 'TWO')) $maxSelect = 2;
                                                else $maxSelect = 2;
                                            }
                                        }
                                    @endphp
                                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 hover:border-blue-300 transition-colors duration-200"
                                         x-data="{ 
                                            selected: {{ in_array($question['type'] ?? '', ['checkbox', 'multiple_choice_multiple']) ? '[]' : (isset($question['sub_questions']) ? '{' . collect($question['sub_questions'])->map(function($sq) { return "'".$sq['id']."': ''"; })->implode(',') . '}' : 'null') }},
                                            maxSelect: {{ $maxSelect }},
                                            toggleOption(optKey) {
                                                if (!Array.isArray(this.selected)) {
                                                    this.selected = this.selected ? [this.selected] : [];
                                                }
                                                const idx = this.selected.indexOf(optKey);
                                                if (idx > -1) {
                                                    this.selected.splice(idx, 1);
                                                } else {
                                                    if (this.selected.length >= this.maxSelect) {
                                                        this.selected.shift();
                                                    }
                                                    this.selected.push(optKey);
                                                    this.selected.sort();
                                                }
                                            }
                                         }"
                                    >
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1 flex gap-3">
                                                @php
                                                    $isGroup = isset($question['sub_questions']) || in_array($question['type'] ?? '', ['summary_completion', 'sentence_completion', 'table_completion', 'diagram_labelling', 'matching_headings', 'matching_features', 'matching_sentence_endings', 'true_false', 'true_false_not_given', 'yes_no_not_given', 'matching_paragraph_information', 'short_answer_group', 'checkbox', 'multiple_choice_multiple']);
                                                    
                                                    $count = 1;
                                                    if (isset($question['sub_questions']) && is_array($question['sub_questions']) && count($question['sub_questions']) > 0) {
                                                        $count = count($question['sub_questions']);
                                                    } elseif (isset($question['type']) && in_array($question['type'], ['checkbox', 'multiple_choice_multiple']) && isset($question['correct_answer']) && is_array($question['correct_answer'])) {
                                                        $count = count($question['correct_answer']);
                                                    } elseif (isset($question['blanks']) && is_array($question['blanks']) && count($question['blanks']) > 0) {
                                                        $count = count($question['blanks']);
                                                    } elseif (isset($question['placeholders']) && is_array($question['placeholders']) && count($question['placeholders']) > 0) {
                                                        $count = count($question['placeholders']);
                                                    } elseif (isset($question['points']) && is_numeric($question['points']) && $question['points'] > 0) {
                                                        $count = (int)$question['points'];
                                                    }
                                                    
                                                    $explicitNum = null;
                                                    if (isset($question['sub_questions'][0]['id']) && is_numeric($question['sub_questions'][0]['id'])) {
                                                        $explicitNum = (int)$question['sub_questions'][0]['id'];
                                                    } elseif (isset($question['id']) && is_numeric($question['id'])) {
                                                        $explicitNum = (int)$question['id'];
                                                    }

                                                    // Always track globally so question numbers are sequential (1-40) across all passages
                                                    $currentBadgeNum = $explicitNum ?? ($globalQIndex + 1);
                                                    $globalQIndex = $globalQIndex + $count;
                                                    $question['start_number'] = $currentBadgeNum - 1;
                                                @endphp
                                                
                                                @if(!$isGroup || in_array($question['type'] ?? '', ['multiple_choice_multiple', 'checkbox']))
                                                <div class="flex-none pt-0.5">
                                                    <span class="flex items-center justify-center {{ $count > 1 ? 'px-2.5 h-7' : 'w-6 h-6' }} rounded-full bg-white text-blue-600 font-bold text-xs ring-1 ring-blue-100 shadow-sm">
                                                        {{ $count > 1 ? ($currentBadgeNum . '-' . ($currentBadgeNum + $count - 1)) : $currentBadgeNum }}
                                                    </span>
                                                </div>
                                                @endif
                                                <div class="flex-1 group">
                                                    <div class="question-text-content text-base md:text-lg text-gray-800 leading-relaxed cursor-text hover:cursor-pointer transition-colors" title="Click any word to find it in the passage">
                                                        @php
                                                            $isTfNg = in_array($question['type'] ?? '', ['true_false', 'true_false_not_given'])
                                                                || (($question['type'] ?? '') === 'matching_features' && isset($question['options']['TRUE']));
                                                            $isYnNg = in_array($question['type'] ?? '', ['yes_no_not_given'])
                                                                || (($question['type'] ?? '') === 'matching_features' && isset($question['options']['YES']));
                                                            $rawText = $question['text'] ?? '';

                                                            // Scalar (non-grouped) short_answer questions store the whole
                                                            // fill-in-the-blank sentence as $question['text'], with the blank
                                                            // marked by a run of dots/ellipsis - same convention used by
                                                            // short_answer_group's per-sub-question labels. Convert it to an
                                                            // inline input here so it renders like every other fill-in-the-blank
                                                            // question on this page, instead of a disconnected generic box.
                                                            $hasInlineBlank = false;
                                                            if (($question['type'] ?? '') === 'short_answer' && empty($question['sub_questions'])) {
                                                                $dotPattern = '/([.\x{2026}]{3,})/u';
                                                                if (preg_match($dotPattern, $rawText)) {
                                                                    $hasInlineBlank = true;
                                                                    $numMatch = preg_replace('/\D/', '', $question['id'] ?? '');
                                                                    $qNumVal = $numMatch ? $numMatch : $currentBadgeNum;
                                                                    $inputHtml = '<span class="inline-inline-flex items-baseline mx-1 align-middle">' .
                                                                                 '<span class="text-blue-600 font-bold text-sm md:text-base mr-1 select-none pointer-events-none">' . $qNumVal . '</span>' .
                                                                                 '<input type="text" data-qid="' . $question['id'] . '" x-model="selected" placeholder="......" class="user-answer border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-1 py-0.5 w-32 text-gray-900 font-medium transition-all focus:ring-0 placeholder-gray-400 text-sm md:text-base">' .
                                                                                 '</span>';
                                                                    $rawText = preg_replace($dotPattern, $inputHtml, $rawText, 1);
                                                                }
                                                            }

                                                            if ($isTfNg || $isYnNg) {
                                                                $rawText = preg_replace('/(<br\s*\/?>)?\s*In boxes.*?write:?\s*(<br\s*\/?>)?\s*(<b>)?(TRUE|YES).*/si', '', $rawText);
                                                                $rawText = preg_replace('/(<br\s*\/?>)?\s*Write\s+(YES|TRUE)\s+if.*/si', '', $rawText);
                                                                $rawText = preg_replace('/Write\s+(TRUE|YES)\s+if\s+the\s+statement.*?,?.*?or\s+NOT\s+GIVEN.*?(passage|this)\.?/si', '', $rawText);
                                                                $rawText = preg_replace('/^Questions?\s*\d+(–|-)\d+\s*(<br\s*\/?>)?/i', '', $rawText);
                                                            }

                                                            if (($question['type'] ?? '') === 'matching_headings') {
                                                                $rawText = preg_replace('/(<br\s*\/?>)?\s*(<[^>]+>)?\s*List of [Hh]eadings.*/si', '', $rawText);
                                                            }

                                                            // Clean instruction for summary_completion / sentence_completion so reconstructed/passage text doesn't leak into header
                                                            if (in_array($question['type'] ?? '', ['summary_completion', 'sentence_completion'])) {
                                                                $summaryPatterns = [
                                                                    '/(.*?on your answer sheet\.?)(.*)$/si',
                                                                    '/(.*?in boxes \d+[-–]\d+\.?)(.*)$/si',
                                                                    '/(.*?each answer\.?)(.*)$/si',
                                                                ];
                                                                foreach ($summaryPatterns as $sp) {
                                                                    if (preg_match($sp, $rawText, $sm)) {
                                                                        $rawText = trim($sm[1]);
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                            
                                                             // Normalize any split "Questions XX ... <br> ... -YY" so the question range stays unified on one line
                                                             $rawText = preg_replace('/(Questions?\s*\d+)\s*(?:<\/strong>)?\s*<br\s*\/?>\s*(?:<em>)?\s*[-–]\s*(\d+)/i', '$1-$2</strong><br><em>', $rawText);
                                                             $rawText = preg_replace('/(Questions?\s*\d+)\s*<br\s*\/?>\s*[-–]\s*(\d+)/i', '$1-$2<br>', $rawText);
                                                             $rawText = preg_replace('/\s*Advertisements\s*/i', '', $rawText);

                                                             // Split lines by <br> or newline
                                                             $lines = array_filter(array_map('trim', preg_split('/<br\s*\/?>|\n/i', $rawText)));
                                                             $outputHtml = '';
                                                            
                                                            foreach ($lines as $lIndex => $lText) {
                                                                $cleanLText = strip_tags($lText);
                                                                if (preg_match('/^Questions?\s+\d+/i', $cleanLText)) {
                                                                    $outputHtml .= '<h3 class="text-lg md:text-xl font-bold font-serif text-gray-900 mb-2">' . $cleanLText . '</h3>';
                                                                } elseif (preg_match('/^(Complete|Choose|Write|Do the following|Look at)/i', $cleanLText)) {
                                                                    $lTextFormatted = preg_replace_callback('/\b(ONE|TWO|THREE|FOUR|FIVE|SIX|SEVEN|EIGHT|A–[A-Z]|A-[A-Z])\b/i', function($m) {
                                                                        return '<strong class="font-bold">' . $m[1] . '</strong>';
                                                                    }, $cleanLText);
                                                                    $outputHtml .= '<p class="text-base md:text-lg italic text-gray-700 mb-1">' . $lTextFormatted . '</p>';
                                                                } else {
                                                                    $lTextFormatted = preg_replace_callback('/\b(Which\s+(?:TWO|THREE|FOUR|FIVE|SIX|SEVEN|EIGHT)|ONE|TWO|THREE|FOUR|FIVE|SIX|SEVEN|EIGHT)\b/i', function($m) {
                                                                        return '<strong class="font-bold">' . $m[1] . '</strong>';
                                                                    }, $cleanLText);
                                                                    $outputHtml .= '<p class="font-semibold text-gray-900 text-base md:text-lg mt-3 mb-2 leading-relaxed">' . $lTextFormatted . '</p>';
                                                                }
                                                            }
                                                            if (empty($outputHtml)) {
                                                                $outputHtml = $rawText;
                                                            }
                                                        @endphp
                                                        {!! $outputHtml !!}
                                                    </div>
                                                    @if($isTfNg || $isYnNg)
                                                        <div class="mt-6 mb-4">
                                                                <p class="text-base md:text-lg text-gray-800 italic mb-3">
                                                                    @if($currentBadgeNum === $globalQIndex)
                                                                        In box <span class="font-bold">{{ $currentBadgeNum }}</span> on your answer sheet, write
                                                                    @else
                                                                        In boxes <span class="font-bold">{{ $currentBadgeNum }}-{{ $globalQIndex }}</span> on your answer sheet, write
                                                                    @endif
                                                                </p>
                                                                <div class="text-base md:text-lg text-gray-800 ml-4 md:ml-8 flex flex-col gap-1.5">
                                                                    <div class="flex gap-4 md:gap-6 items-start">
                                                                        <div class="font-bold tracking-wide w-28 flex-shrink-0">{{ $isTfNg ? 'TRUE' : 'YES' }}</div>
                                                                        <div class="italic whitespace-nowrap">if the statement agrees with the {{ $isTfNg ? 'information' : 'claims of the writer' }}</div>
                                                                    </div>
                                                                    <div class="flex gap-4 md:gap-6 items-start">
                                                                        <div class="font-bold tracking-wide w-28 flex-shrink-0">{{ $isTfNg ? 'FALSE' : 'NO' }}</div>
                                                                        <div class="italic whitespace-nowrap">if the statement contradicts the {{ $isTfNg ? 'information' : 'claims of the writer' }}</div>
                                                                    </div>
                                                                    <div class="flex gap-4 md:gap-6 items-start">
                                                                        <div class="font-bold tracking-wide w-28 flex-shrink-0">NOT GIVEN</div>
                                                                        <div class="italic whitespace-nowrap">if {{ $isTfNg ? 'there is no information on this' : 'it is impossible to say what the writer thinks about this' }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                </div>
                                            </div>
                                            <div class="flex gap-2 flex-shrink-0 items-start">
                                                    @if(isset($question['db_id']) && !($isSkillView ?? false))
                                                        <button onclick="openQuestionModal({{ $index }}, {{ $qIndex }})" class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded transition-colors">Edit</button>
                                                        <button onclick="deleteQuestion({{ $question['db_id'] }})" class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded transition-colors">Delete</button>
                                                    @endif
                                            </div>
                                        </div>

                                        <div class="pl-0 md:pl-2">
                                            @php
                                                $questionPartial = match(true) {
                                                    isset($question['type']) && in_array($question['type'], ['matching_headings', 'matching_features', 'matching_sentence_endings', 'true_false', 'true_false_not_given', 'yes_no_not_given', 'matching_paragraph_information']) => 'matching-and-tf-ng',
                                                    isset($question['type']) && $question['type'] === 'table_completion' => 'table-completion',
                                                    isset($question['type']) && $question['type'] === 'diagram_labelling' => 'diagram-labelling',
                                                    isset($question['type']) && in_array($question['type'], ['sentence_completion', 'summary_completion']) => 'summary-sentence-completion',
                                                    isset($question['type']) && in_array($question['type'], ['short_answer_group', 'short_answer']) && isset($question['sub_questions']) => 'short-answer-group',
                                                    isset($question['type']) && in_array($question['type'], ['multiple_choice_multiple', 'checkbox']) => 'scalar-choice',
                                                    isset($question['sub_questions']) => 'sub-questions-fallback',
                                                    isset($question['type']) && $question['type'] === 'short_answer' => 'scalar-short-answer',
                                                    default => 'scalar-choice',
                                                };
                                            @endphp
                                            @include('assignments.ielts.reading.partials.questions.' . $questionPartial)
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    @endif


                    @if($hasAnswerKey)
                        <!-- Evaluation Button -->
                        <div class="mt-8 mb-12 flex justify-center {{ isset($existingResult) ? 'hidden' : '' }}" id="eval-button-container">
                            <button type="button" onclick="evaluateIeltsReading()" id="eval-button" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all text-lg flex items-center gap-2 transform hover:scale-105">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Selesai & Cek Jawaban
                            </button>
                        </div>

                        <!-- Evaluation Summary Box -->
                        <div id="eval-summary" class="{{ isset($existingResult) ? '' : 'hidden' }} mt-8 mb-12 bg-white rounded-3xl shadow-xl border border-gray-100 p-8 transition-all duration-500">
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider mb-3">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Latihan Selesai
                                </div>
                                <h2 class="text-3xl font-extrabold text-gray-900 mb-1">Hasil Evaluasi</h2>
                                <p class="text-gray-500 text-sm">Berikut adalah pencapaian dan analisis jawaban Anda</p>
                            </div>

                            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white text-center shadow-lg mb-8 max-w-sm mx-auto">
                                <span class="text-xs font-bold uppercase tracking-widest text-emerald-100 block mb-1">Perkiraan Band Score</span>
                                <div class="text-5xl font-black tracking-tight" id="eval-band-score">
                                    {{ isset($existingResult) ? 'Band ' . number_format($existingResult->band_score, 1) : '-' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8 max-w-lg mx-auto">
                                <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-4 text-center">
                                    <div class="text-3xl font-extrabold text-emerald-600 mb-1" id="eval-score">
                                        {{ isset($existingResult) ? $existingResult->correct_count : '-' }}
                                    </div>
                                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wide">Benar</div>
                                </div>
                                <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-4 text-center">
                                    <div class="text-3xl font-extrabold text-rose-500 mb-1" id="eval-wrong">
                                        {{ isset($existingResult) ? ($existingResult->total_questions - $existingResult->correct_count) : '-' }}
                                    </div>
                                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wide">Salah / Kosong</div>
                                </div>
                                <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-4 text-center col-span-2 md:col-span-1">
                                    <div class="text-3xl font-extrabold text-gray-700 mb-1" id="eval-total">
                                        {{ isset($existingResult) ? $existingResult->total_questions : '-' }}
                                    </div>
                                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wide">Total Soal</div>
                                </div>
                            </div>

                            <div class="bg-blue-50 border border-blue-200/60 rounded-2xl p-4 text-center mb-6 max-w-lg mx-auto">
                                <p class="text-blue-900 text-sm font-medium">Scroll ke atas untuk melihat kunci jawaban dan pembahasan lengkap pada masing-masing nomor.</p>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                                <button type="button" onclick="confirmResetPractice()" class="w-full sm:w-auto px-6 py-3 bg-white hover:bg-rose-50 text-rose-600 hover:text-rose-700 font-bold rounded-xl border border-rose-200 shadow-sm transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Kerjakan Ulang
                                </button>
                                <button type="button" onclick="document.getElementById('questions-panel')?.scrollTo({top: 0, behavior: 'smooth'})" class="w-full sm:w-auto px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl shadow transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    Review Jawaban di Atas
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="mt-8 mb-12 flex justify-center">
                            <div class="px-8 py-3 bg-white text-gray-500 font-bold rounded-xl border border-gray-200 text-lg flex items-center gap-3">
                                <svg class="w-6 h-6 animate-spin text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Menunggu Kunci Jawaban & Pembahasan Diupload...
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Prevent page-level scrolling so only the two panels scroll */
    body, main { overflow: hidden !important; height: 100vh !important; }
    
    /* Handle dynamic padding when sidebar collapses */
    @media (min-width: 768px) {
        #mat-outer {
            padding-left: 16rem;
        }
        body.sidebar-collapsed #mat-outer {
            padding-left: 4rem;
        }
        body.has-admin-sidebar.sidebar-collapsed #mat-outer {
            padding-left: 3.5rem;
        }
    }

    /* Authentic Cambridge IELTS Typography */
    .passage-content {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        color: #111827 !important;
        font-size: 1.05rem !important;
        line-height: 1.65 !important;
    }

    .passage-content p {
        margin-bottom: 1.25rem !important;
        font-size: 1.05rem !important;
        line-height: 1.65 !important;
        color: #111827 !important;
    }

    .passage-content strong,
    .passage-content b {
        font-weight: 700 !important;
        color: #111827 !important;
    }

    .passage-section-banner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #0056b3;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        padding-bottom: 0.25rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .passage-section-banner .section-title {
        color: #0056b3;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 800;
        font-size: 1.35rem;
    }

    .passage-section-banner .section-questions {
        color: #0056b3;
        font-style: italic;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .passage-instruction {
        font-style: italic;
        color: #374151;
        font-size: 1.05rem;
        margin-bottom: 1.25rem;
    }

    .passage-content h2, 
    .passage-content h3, 
    .passage-main-title {
        color: #0056b3 !important;
        font-weight: 800 !important;
        font-size: 1.65rem !important;
        line-height: 1.35 !important;
        margin-top: 0.5rem !important;
        margin-bottom: 1.5rem !important;
        letter-spacing: -0.01em !important;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
        border: 2px solid transparent;
        background-clip: content-box;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #94a3b8;
    }
</style>
@endpush

<!-- Definition Popup -->
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
    
    <div>
        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Synonyms</p>
        <p id="def_synonyms" class="text-sm text-gray-600"></p>
    </div>
</div>

<script>
    function toggleTranslate(container, active, originalText) {
        const contentDiv = container.querySelector('.passage-content');

        if (!active) {
            contentDiv.innerHTML = originalText;
            document.getElementById('definitionPopup').classList.add('hidden');
            return;
        }

        // Restore clean HTML first (in case re-toggling)
        contentDiv.innerHTML = originalText;

        // Walk only text nodes — this never touches HTML tags
        const walker = document.createTreeWalker(contentDiv, NodeFilter.SHOW_TEXT, null, false);
        const textNodes = [];
        let node;
        while ((node = walker.nextNode())) {
            textNodes.push(node);
        }

        textNodes.forEach(textNode => {
            const parent = textNode.parentNode;
            // Skip if already inside a clickable span
            if (parent && parent.classList && parent.classList.contains('translate-word')) return;

            const tokens = (textNode.nodeValue || '').match(/([a-zA-Z0-9\-\']+|[^a-zA-Z0-9\-\'\s]+|\s+)/g) || [];
            if (tokens.length === 0) return;

            const frag = document.createDocumentFragment();
            tokens.forEach(token => {
                if (/^[a-zA-Z0-9\-\']+$/.test(token)) {
                    const span = document.createElement('span');
                    span.className = 'translate-word cursor-pointer hover:bg-yellow-200 hover:text-yellow-800 rounded px-0.5 transition-colors border-b border-dashed border-gray-400';
                    span.textContent = token;
                    span.setAttribute('onclick', `lookupWord('${token.replace(/'/g, "\\'")}', event)`);
                    frag.appendChild(span);
                } else {
                    frag.appendChild(document.createTextNode(token));
                }
            });
            parent.replaceChild(frag, textNode);
        });
    }

    async function lookupWord(word, event) {
        event.stopPropagation();
        
        const popup = document.getElementById('definitionPopup');
        const cleanWord = word.replace(/[^a-zA-Z0-9\-\']/g, '').toLowerCase();

        const x = Math.min(event.pageX, window.innerWidth - 300); 
        const y = event.pageY + 15;

        popup.style.top = `${y}px`;
        popup.style.left = `${x}px`;
        
        document.getElementById('def_word').innerText = cleanWord;
        document.getElementById('def_translation').innerText = 'Memuat...';
        document.getElementById('def_synonyms').innerText = '...';
        
        popup.classList.remove('hidden');

        try {
            const response = await fetch(`{{ route('api.dictionary.lookup') }}?word=${cleanWord}`);
            const data = await response.json();

            if (data.found) {
                document.getElementById('def_word').innerText = data.word;
                document.getElementById('def_translation').innerText = data.translation;
                
                // If backend already has synonyms, use them. Otherwise fetch.
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

</script>

@unless($isSkillView ?? false)
    @include('assignments.ielts.reading.partials.admin-toolbar')
@endunless

@push('scripts')
<script>
    const MATERIAL_ID = {{ $materialId ?? $id ?? 0 }};
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const EXISTING_RESULT = @json($existingResult ?? null);
    const DRAFT_ANSWERS = @json($draftAnswers ?? null);
    const ANSWER_KEYS = @json((auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher())) || !empty($existingResult) ? ($answerKeys ?? null) : null);
    const RETRY_URL = window.location.pathname + '?retry=1';
    const SUBMIT_URL = "{{ route('assignments.ielts-academic.reading.practice-submit') }}";
    const DRAFT_URL = "{{ route('assignments.ielts-academic.reading.practice-draft') }}";
    const STORAGE_KEY = `ielts_reading_draft_${MATERIAL_ID}_{{ auth()->id() ?? 'guest' }}`;

    function confirmResetPractice() {
        if (confirm('Apakah Anda yakin ingin mengulang latihan ini? Jawaban dan skor Anda sebelumnya akan direset sehingga Anda dapat mengerjakan ulang dari awal.')) {
            try {
                localStorage.removeItem(STORAGE_KEY);
            } catch (e) {}
            window.location.href = RETRY_URL;
        }
    }

    function checkIsCorrect(correctData, userAnswer) {
        if (correctData === undefined || correctData === null) return false;

        if (Array.isArray(correctData)) {
            if (Array.isArray(userAnswer)) {
                const sortedUser = [...userAnswer].map(x => String(x).trim().toLowerCase()).sort();
                const sortedCorrect = [...correctData].map(x => String(x).trim().toLowerCase()).sort();
                return JSON.stringify(sortedUser) === JSON.stringify(sortedCorrect);
            } else {
                const userNorm = String(userAnswer || '').trim().toLowerCase();
                const normalizedCorrect = correctData.map(c => String(c).trim().toLowerCase());
                return userNorm !== '' && normalizedCorrect.includes(userNorm);
            }
        } else {
            const userNorm = String(userAnswer || '').trim().toLowerCase();
            if (userNorm === '') return false;
            const corrStr = String(correctData).trim().toLowerCase();
            const possible = corrStr.split('/').map(s => s.trim().toLowerCase());
            return possible.includes(userNorm);
        }
    }

    function collectCurrentAnswers() {
        const allInputs = document.querySelectorAll('[data-qid]');
        const userAnswers = {};

        allInputs.forEach(input => {
            const qid = input.getAttribute('data-qid');
            if (!qid) return;

            if (input.type === 'checkbox') {
                if (input.checked) {
                    if (!userAnswers[qid]) userAnswers[qid] = [];
                    userAnswers[qid].push(input.value);
                }
            } else if (input.type === 'radio') {
                if (input.checked) {
                    userAnswers[qid] = input.value;
                }
            } else if (input.tagName === 'SELECT') {
                if (input.value !== '') {
                    userAnswers[qid] = input.value;
                }
            } else {
                if (input.value !== undefined && input.value !== '') {
                    userAnswers[qid] = input.value;
                }
            }
        });
        return userAnswers;
    }

    function restoreAnswers(answers) {
        if (!answers || typeof answers !== 'object') return;

        Object.keys(answers).forEach(qid => {
            const val = answers[qid];
            if (val === null || val === undefined) return;

            const inputs = document.querySelectorAll(`[data-qid="${qid}"]`);
            inputs.forEach(input => {
                if (input.type === 'radio') {
                    if (String(input.value).trim().toLowerCase() === String(val).trim().toLowerCase()) {
                        input.checked = true;
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                } else if (input.type === 'checkbox') {
                    const arr = Array.isArray(val) ? val : [val];
                    if (arr.map(x => String(x).trim().toLowerCase()).includes(String(input.value).trim().toLowerCase())) {
                        input.checked = true;
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                } else if (input.tagName === 'SELECT') {
                    input.value = val;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                } else {
                    input.value = val;
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                }

                // Sync Alpine.js component state if available
                const alpineEl = input.closest('[x-data]');
                if (alpineEl && alpineEl._x_dataStack && alpineEl._x_dataStack[0]) {
                    const stack = alpineEl._x_dataStack[0];
                    if (stack.selected !== undefined) {
                        if (Array.isArray(stack.selected)) {
                            const arr = Array.isArray(val) ? val : [val];
                            arr.forEach(v => {
                                if (!stack.selected.includes(v)) stack.selected.push(v);
                            });
                        } else if (typeof stack.selected === 'object' && stack.selected !== null) {
                            stack.selected[qid] = val;
                        } else {
                            stack.selected = val;
                        }
                    }
                }
            });
        });
    }

    let autosaveTimer = null;
    function scheduleAutosave() {
        if (EXISTING_RESULT) return;

        const statusEl = document.getElementById('autosave-status');
        if (statusEl) {
            statusEl.innerHTML = `<svg class="w-3.5 h-3.5 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="text-amber-600 font-semibold">Menyimpan...</span>`;
        }

        const answers = collectCurrentAnswers();
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(answers));
        } catch (e) {}

        clearTimeout(autosaveTimer);
        autosaveTimer = setTimeout(async () => {
            try {
                const res = await fetch(DRAFT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        material_id: MATERIAL_ID,
                        answers: answers
                    })
                });
                if (res.ok && statusEl) {
                    statusEl.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg><span class="text-emerald-700 font-semibold">Tersimpan</span>`;
                }
            } catch (err) {
                console.warn('Draft save error:', err);
                if (statusEl) {
                    statusEl.innerHTML = `<span class="text-gray-400">Tersimpan lokal</span>`;
                }
            }
        }, 1000);
    }

    function renderEvaluationFeedback(answerKeyData, userAnswers, stats) {
        if (!answerKeyData || typeof answerKeyData !== 'object') return;

        Object.keys(answerKeyData).forEach(qid => {
            const ansData = answerKeyData[qid];
            if (!ansData || ansData.correct === undefined || ansData.correct === null) return;

            const userAnswer = userAnswers[qid] !== undefined ? userAnswers[qid] : null;
            const isCorrect = checkIsCorrect(ansData.correct, userAnswer);

            const inputs = document.querySelectorAll(`[data-qid="${qid}"]`);
            if (inputs.length === 0) return;

            // Remove previous feedback
            document.querySelectorAll(`.eval-feedback-qid-${qid}`).forEach(el => el.remove());

            // Style inputs and labels
            inputs.forEach(input => {
                input.setAttribute('disabled', 'true');
                input.classList.add('cursor-not-allowed', 'opacity-85');

                const label = input.closest('label');
                if (label) {
                    label.classList.add('pointer-events-none');
                    if (input.type === 'radio' || input.type === 'checkbox') {
                        const val = input.value;
                        const isThisOptionCorrect = checkIsCorrect(ansData.correct, val);
                        if (isThisOptionCorrect) {
                            label.classList.remove('border-gray-200', 'bg-white');
                            label.classList.add('border-emerald-500', 'bg-emerald-50/70', 'ring-1', 'ring-emerald-500');
                        } else if (input.checked && !isCorrect) {
                            label.classList.remove('border-gray-200', 'bg-white');
                            label.classList.add('border-rose-500', 'bg-rose-50/70', 'ring-1', 'ring-rose-500');
                        }
                    }
                }

                if (input.tagName === 'SELECT' || (input.tagName === 'INPUT' && input.type !== 'radio' && input.type !== 'checkbox' && input.type !== 'hidden')) {
                    if (isCorrect) {
                        input.classList.remove('border-gray-300', 'border-gray-200', 'border-rose-500', 'bg-rose-50', 'text-rose-700');
                        input.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-800');
                    } else {
                        input.classList.remove('border-gray-300', 'border-gray-200', 'border-emerald-500', 'bg-emerald-50', 'text-emerald-700');
                        input.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-800');
                    }
                }
            });

            // Format displayed correct answer
            let formattedCorrect = '';
            if (Array.isArray(ansData.correct)) {
                formattedCorrect = ansData.correct.join(' / ');
            } else {
                formattedCorrect = String(ansData.correct);
            }

            let formattedUser = '';
            if (userAnswer === null || userAnswer === undefined || userAnswer === '') {
                formattedUser = '(Tidak dijawab)';
            } else if (Array.isArray(userAnswer)) {
                formattedUser = userAnswer.join(', ');
            } else {
                formattedUser = String(userAnswer);
            }

            const feedbackHtml = `
                <div class="eval-feedback-qid-${qid} mt-2.5 p-3.5 rounded-xl border ${isCorrect ? 'bg-emerald-50/80 border-emerald-200' : 'bg-rose-50/80 border-rose-200'} shadow-sm text-left">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="font-bold text-xs uppercase tracking-wider ${isCorrect ? 'text-emerald-800' : 'text-rose-800'} flex items-center gap-1.5">
                            ${isCorrect ? '<svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Jawaban Benar' : '<svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg> Jawaban Salah / Belum Terjawab'}
                        </span>
                        ${qid ? `<span class="text-[10px] font-bold text-gray-500 uppercase">Soal ${qid}</span>` : ''}
                    </div>
                    ${!isCorrect ? `
                    <div class="text-xs text-rose-900 mb-1 flex items-center gap-1.5 flex-wrap">
                        <span class="font-medium text-gray-600">Jawaban Anda:</span>
                        <span class="font-bold bg-white px-2 py-0.5 rounded border border-rose-200 line-through text-rose-700">${formattedUser}</span>
                    </div>` : ''}
                    <div class="text-xs text-emerald-950 mb-1 flex items-center gap-1.5 flex-wrap">
                        <span class="font-medium text-gray-600">Kunci Jawaban:</span>
                        <span class="font-bold bg-white px-2 py-0.5 rounded border border-emerald-300 text-emerald-800">${formattedCorrect}</span>
                    </div>
                    ${ansData.explanation ? `
                    <div class="mt-2 pt-2 border-t ${isCorrect ? 'border-emerald-200/60' : 'border-rose-200/60'}">
                        <span class="font-bold text-[11px] text-gray-500 uppercase tracking-wide block mb-0.5">Penjelasan:</span>
                        <p class="text-xs text-gray-700 leading-relaxed">${ansData.explanation}</p>
                    </div>` : ''}
                </div>
            `;

            const firstInput = inputs[0];
            const targetWrapper = firstInput.closest('.multi-sub-feedback-wrapper')
                || firstInput.closest('td')
                || firstInput.closest('.flex.items-center.justify-between')
                || firstInput.closest('.py-3.5')
                || firstInput.closest('.py-2')
                || firstInput.closest('.mb-4')
                || firstInput.parentElement;

            if (targetWrapper) {
                const div = document.createElement('div');
                div.innerHTML = feedbackHtml;
                if (firstInput.closest('td')) {
                    targetWrapper.appendChild(div);
                } else {
                    targetWrapper.parentNode.insertBefore(div, targetWrapper.nextSibling);
                }
            }
        });

        // Update Summary Box
        const bandEl = document.getElementById('eval-band-score');
        if (bandEl && stats.band_score !== undefined) {
            bandEl.innerText = 'Band ' + Number(stats.band_score).toFixed(1);
        }
        const scoreEl = document.getElementById('eval-score');
        if (scoreEl) scoreEl.innerText = stats.correct;
        const wrongEl = document.getElementById('eval-wrong');
        if (wrongEl) wrongEl.innerText = stats.total - stats.correct;
        const totalEl = document.getElementById('eval-total');
        if (totalEl) totalEl.innerText = stats.total;

        const evalBtnContainer = document.getElementById('eval-button-container');
        if (evalBtnContainer) evalBtnContainer.classList.add('hidden');

        const summaryBox = document.getElementById('eval-summary');
        if (summaryBox) {
            summaryBox.classList.remove('hidden');
        }

        // Update Top Header
        const headerScoreBadge = document.getElementById('header-score-badge');
        const headerScoreText = document.getElementById('header-score-text');
        const headerRetryBtn = document.getElementById('header-retry-btn');
        const autosaveStatus = document.getElementById('autosave-status');

        if (headerScoreBadge && headerScoreText) {
            headerScoreText.innerText = `Band ${Number(stats.band_score).toFixed(1)} (${stats.correct}/${stats.total})`;
            headerScoreBadge.classList.remove('hidden');
            headerScoreBadge.classList.add('flex');
        }
        if (headerRetryBtn) {
            headerRetryBtn.classList.remove('hidden');
            headerRetryBtn.classList.add('inline-flex');
        }
        if (autosaveStatus) {
            autosaveStatus.classList.add('hidden');
        }
    }

    async function evaluateIeltsReading() {
        const evalBtn = document.getElementById('eval-button');
        if (!evalBtn) return;
        const originalBtnText = evalBtn.innerHTML;
        evalBtn.innerHTML = '<svg class="w-6 h-6 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengevaluasi...';
        evalBtn.disabled = true;

        const userAnswers = collectCurrentAnswers();

        try {
            const response = await fetch(SUBMIT_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    material_id: MATERIAL_ID,
                    answers: userAnswers
                })
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();

            try {
                localStorage.removeItem(STORAGE_KEY);
            } catch (e) {}

            renderEvaluationFeedback(data.answer_key, userAnswers, {
                correct: data.correct,
                total: data.total,
                band_score: data.band_score
            });

            const summaryBox = document.getElementById('eval-summary');
            if (summaryBox) {
                summaryBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan saat mengevaluasi jawaban. Silakan coba lagi.');
            evalBtn.innerHTML = originalBtnText;
            evalBtn.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (EXISTING_RESULT) {
            const userAnswers = EXISTING_RESULT.answers_data || {};
            restoreAnswers(userAnswers);
            renderEvaluationFeedback(ANSWER_KEYS, userAnswers, {
                correct: EXISTING_RESULT.correct_count,
                total: EXISTING_RESULT.total_questions,
                band_score: EXISTING_RESULT.band_score
            });
        } else {
            let savedAnswers = DRAFT_ANSWERS;
            if (!savedAnswers || Object.keys(savedAnswers).length === 0) {
                try {
                    const localStr = localStorage.getItem(STORAGE_KEY);
                    if (localStr) savedAnswers = JSON.parse(localStr);
                } catch (e) {}
            }
            if (savedAnswers && Object.keys(savedAnswers).length > 0) {
                restoreAnswers(savedAnswers);
                const statusEl = document.getElementById('autosave-status');
                if (statusEl) {
                    statusEl.innerHTML = `<svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg><span class="text-blue-700 font-semibold">Draft dipulihkan</span>`;
                }
            }

            // Bind autosave events
            document.addEventListener('input', (e) => {
                if (e.target && e.target.hasAttribute && e.target.hasAttribute('data-qid')) {
                    scheduleAutosave();
                }
            });

            document.addEventListener('change', (e) => {
                if (e.target && (e.target.hasAttribute('data-qid') || e.target.closest('[x-data]'))) {
                    scheduleAutosave();
                }
            });
        }
    });
</script>

<script>
    window.applyAnnotation = function(type, color = 'yellow') {
        const selection = window.getSelection();
        if (!selection.rangeCount || selection.isCollapsed) return;

        const range = selection.getRangeAt(0);
        const span = document.createElement('span');
        
        if (type === 'highlight') {
            const colors = {
                'yellow': 'bg-yellow-200 hover:bg-yellow-300',
                'green': 'bg-green-200 hover:bg-green-300',
                'blue': 'bg-blue-200 hover:bg-blue-300',
                'pink': 'bg-pink-200 hover:bg-pink-300'
            };
            const colorClass = colors[color] || colors['yellow'];
            span.className = `${colorClass} rounded px-1 pb-0.5 cursor-pointer transition-colors border shadow-sm border-transparent`;
            span.title = 'Click to remove highlight';
        }

        span.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            const parent = this.parentNode;
            while(this.firstChild) {
                parent.insertBefore(this.firstChild, this);
            }
            parent.removeChild(this);
            parent.normalize();
        };

        try {
            range.surroundContents(span);
        } catch (e) {
            // Fallback for when selection spans multiple elements visually but isn't a complex block boundary
            console.warn('Cannot highlight across HTML nodes with basic boundary.', e);
            // Optionally could implement DocumentFragment walking here for full multi-node support.
        }

        selection.removeAllRanges();
    };

    window.initDrawingCanvas = function(canvas) {
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let currentMode = 'draw';
        
        // Setup initial dimensions (intrinsic size)
        const rect = canvas.parentElement.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = rect.height;
        ctx.lineJoin = 'round';
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#ef4444'; // Tailwind red-500
        ctx.lineWidth = 3;

        function setMode(mode) {
            currentMode = mode;
            if (mode === 'erase') {
                ctx.globalCompositeOperation = 'destination-out';
                ctx.lineWidth = 20;
            } else {
                ctx.globalCompositeOperation = 'source-over';
                ctx.lineWidth = 3;
                ctx.strokeStyle = '#ef4444';
            }
        }

        function refreshContext() {
            setMode(currentMode);
        }

        function resize() {
            const containerRect = canvas.parentElement.getBoundingClientRect();
            // Need to save contents before resizing effectively clears the canvas
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = canvas.width;
            tempCanvas.height = canvas.height;
            const tCtx = tempCanvas.getContext('2d');
            tCtx.drawImage(canvas, 0, 0);

            canvas.width = containerRect.width;
            canvas.height = containerRect.height;

            ctx.drawImage(tempCanvas, 0, 0);
            refreshContext();
        }

        function getMousePos(evt) {
            const canvasRect = canvas.getBoundingClientRect();
            let clientX = evt.clientX;
            let clientY = evt.clientY;
            
            if (evt.touches && evt.touches.length > 0) {
                clientX = evt.touches[0].clientX;
                clientY = evt.touches[0].clientY;
            }
            return {
                x: clientX - canvasRect.left,
                y: clientY - canvasRect.top
            };
        }

        function eraseHighlightUnderCursor(clientX, clientY) {
            canvas.style.pointerEvents = 'none';
            const el = document.elementFromPoint(clientX, clientY);
            canvas.style.pointerEvents = '';
            
            if (el && el.tagName === 'SPAN' && el.title === 'Click to remove highlight') {
                const parent = el.parentNode;
                while(el.firstChild) {
                    parent.insertBefore(el.firstChild, el);
                }
                parent.removeChild(el);
                parent.normalize();
            }
        }

        function startPosition(e) {
            isDrawing = true;
            const pos = getMousePos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            
            if (currentMode === 'erase') {
                let clientX = e.clientX;
                let clientY = e.clientY;
                if (e.touches && e.touches.length > 0) {
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                }
                eraseHighlightUnderCursor(clientX, clientY);
            }
        }

        function draw(e) {
            if (!isDrawing) return;
            e.preventDefault(); // Stop touch scrolling
            const pos = getMousePos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            
            if (currentMode === 'erase') {
                let clientX = e.clientX;
                let clientY = e.clientY;
                if (e.touches && e.touches.length > 0) {
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                }
                eraseHighlightUnderCursor(clientX, clientY);
            }
        }

        function endPosition() {
            if (isDrawing) {
                ctx.stroke();
                ctx.closePath();
                isDrawing = false;
            }
        }

        canvas.addEventListener('mousedown', startPosition, { passive: false });
        canvas.addEventListener('mousemove', draw, { passive: false });
        canvas.addEventListener('mouseup', endPosition);
        canvas.addEventListener('mouseout', endPosition);

        canvas.addEventListener('touchstart', startPosition, { passive: false });
        canvas.addEventListener('touchmove', draw, { passive: false });
        canvas.addEventListener('touchend', endPosition);

        return {
            setMode,
            resize
        };
    };

    // Interactive Vocabulary Highlighting CSS Injection
    const style = document.createElement('style');
    style.innerHTML = `
        #questions-panel .question-text-content:hover,
        #questions-panel .question-text-content *:hover,
        #questions-panel li:hover span:not(.font-bold),
        #questions-panel table td.hover\\:cursor-pointer:hover,
        #questions-panel .hover\\:cursor-pointer:hover {
            cursor: pointer !important;
        }
    `;
    document.head.appendChild(style);

    // Interactive Vocabulary Highlighting
    (function() {
        document.addEventListener('click', function(e) {
            const inQuestionsPanel = e.target.closest('#questions-panel');
            if (!inQuestionsPanel) return;

            const questionCard = e.target.closest('[data-passage-index]');
            const passageIndex = questionCard ? questionCard.getAttribute('data-passage-index') : null;

            // Only trigger on actual text clicks, not buttons or inputs
            if (e.target.tagName === 'BUTTON' || e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.closest('button')) {
                return;
            }

            // Get exact word clicked using caret positioning
            let clickedWord = '';
            
            if (document.caretPositionFromPoint) {
                // Firefox standard
                const range = document.caretPositionFromPoint(e.clientX, e.clientY);
                if (range && range.offsetNode.nodeType === Node.TEXT_NODE) {
                    clickedWord = extractWordFromTextNode(range.offsetNode.textContent, range.offset);
                }
            } else if (document.caretRangeFromPoint) {
                // WebKit standard
                const range = document.caretRangeFromPoint(e.clientX, e.clientY);
                console.log("caretRangeFromPoint:", range ? range.startContainer.nodeType : "null");
                if (range) {
                    console.log("Container Name:", range.startContainer.nodeName);
                    console.log("TextContent:", range.startContainer.textContent);
                    console.log("Offset:", range.startOffset);
                }
                
                if (range && range.startContainer.nodeType === Node.TEXT_NODE) {
                    clickedWord = extractWordFromTextNode(range.startContainer.textContent, range.startOffset);
                    console.log("Extracted word:", clickedWord);
                } else if (range && range.startContainer.nodeType === Node.ELEMENT_NODE) {
                    console.log("Clicked Element. InnerText:", range.startContainer.innerText);
                }
            }

            if (clickedWord && clickedWord.trim().length > 2) { // Minimum 3 letters
                highlightInPassage(clickedWord.trim(), passageIndex);
            } else {
                clearVocabHighlights();
            }
        });

        function extractWordFromTextNode(text, offset) {
            // Find boundaries of the word around the offset
            let start = offset;
            let end = offset;
            
            // Regex to match valid word characters (including hyphens and apostrophes for words)
            const wordCharRegex = /[a-zA-Z0-9'-]/;

            // Move start index backward
            while (start > 0 && wordCharRegex.test(text[start - 1])) {
                start--;
            }

            // Move end index forward
            while (end < text.length && wordCharRegex.test(text[end])) {
                end++;
            }

            return text.substring(start, end).replace(/^['-]+|['-]+$/g, ''); // Trim leading/trailing punctuation
        }

        function clearVocabHighlights() {
            document.querySelectorAll('mark.vocab-highlight').forEach(mark => {
                const parent = mark.parentNode;
                while (mark.firstChild) {
                    parent.insertBefore(mark.firstChild, mark);
                }
                parent.removeChild(mark);
                parent.normalize();
            });
        }

        function highlightInPassage(word, passageIndex = null) {
            clearVocabHighlights();
            
            let passages;
            if (passageIndex !== null) {
                const passageBlock = document.getElementById(`passage-${passageIndex}`);
                passages = passageBlock ? passageBlock.querySelectorAll('.passage-content') : document.querySelectorAll('.passage-content');
            } else {
                passages = document.querySelectorAll('.passage-content');
            }

            let firstHighlight = null;
            const searchRegex = new RegExp(`\\b${escapeRegExp(word)}\\b`, 'gi');

            passages.forEach(passage => {
                const treeWalker = document.createTreeWalker(
                    passage,
                    NodeFilter.SHOW_TEXT,
                    {
                        acceptNode: function(node) {
                            if (node.parentNode.tagName === 'MARK' || node.parentNode.tagName === 'SCRIPT' || node.parentNode.tagName === 'STYLE') {
                                return NodeFilter.FILTER_REJECT;
                            }
                            return searchRegex.test(node.textContent) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
                        }
                    },
                    false
                );

                const nodesToReplace = [];
                let currentNode;
                while (currentNode = treeWalker.nextNode()) {
                    nodesToReplace.push(currentNode);
                }

                nodesToReplace.forEach(node => {
                    const textContent = node.textContent;
                    const fragment = document.createDocumentFragment();
                    let lastIndex = 0;
                    
                    searchRegex.lastIndex = 0;
                    let match;

                    while ((match = searchRegex.exec(textContent)) !== null) {
                        // Text before match
                        if (match.index > lastIndex) {
                            fragment.appendChild(document.createTextNode(textContent.substring(lastIndex, match.index)));
                        }

                        // The match itself
                        const mark = document.createElement('mark');
                        mark.className = 'vocab-highlight bg-cyan-200 text-cyan-900 px-0.5 rounded transition-all duration-300 ring-2 ring-cyan-300/50';
                        mark.textContent = match[0];
                        fragment.appendChild(mark);
                        
                        if (!firstHighlight) firstHighlight = mark;

                        lastIndex = match.index + match[0].length;
                    }

                    // Text after last match
                    if (lastIndex < textContent.length) {
                        fragment.appendChild(document.createTextNode(textContent.substring(lastIndex)));
                    }

                    node.parentNode.replaceChild(fragment, node);
                });
            });

            if (firstHighlight) {
                firstHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
        }


    })();

</script>
@endpush

@endsection
