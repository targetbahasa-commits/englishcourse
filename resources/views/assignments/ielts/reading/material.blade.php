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
                    @if(auth()->check() && auth()->user()->isAdmin())
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
                                            selected: {{ isset($question['sub_questions']) ? '{' . collect($question['sub_questions'])->map(function($sq) { return "'".$sq['id']."': ''"; })->implode(',') . '}' : (isset($question['type']) && $question['type'] === 'checkbox' ? '[]' : 'null') }},
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
                                                
                                                @if(!$isGroup)
                                                <div class="flex-none pt-0.5">
                                                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white text-blue-600 font-bold text-xs ring-1 ring-blue-100">
                                                        {{ $currentBadgeNum }}
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
                                                            
                                                            // Split lines by <br> or newline
                                                            $lines = array_filter(array_map('trim', preg_split('/<br\s*\/?>|\n/i', $rawText)));
                                                            $outputHtml = '';
                                                            
                                                            foreach ($lines as $lIndex => $lText) {
                                                                if (preg_match('/^Questions?\s+\d+/i', $lText)) {
                                                                    $outputHtml .= '<h3 class="text-lg md:text-xl font-bold font-serif text-gray-900 mb-2">' . $lText . '</h3>';
                                                                } elseif (preg_match('/^(Choose|Write|Do the following|Look at)/i', $lText)) {
                                                                    $lTextFormatted = preg_replace('/(TWO|THREE|FOUR|FIVE|SIX|SEVEN|EIGHT|A–[A-Z]|A-[A-Z])/i', '<strong class="font-bold">$1</strong>', $lText);
                                                                    $outputHtml .= '<p class="text-base md:text-lg italic text-gray-700 mb-1">' . $lTextFormatted . '</p>';
                                                                } else {
                                                                    $lTextFormatted = preg_replace('/Which\s+(TWO|THREE|FOUR|FIVE|SIX|SEVEN|EIGHT)/i', 'Which <strong class="font-bold">$1</strong>', $lText);
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
                                                    @if(isset($question['type']) && in_array($question['type'], ['checkbox', 'multiple_choice_multiple']))
                                                        <p class="text-xs text-blue-500 font-medium mt-1.5 uppercase tracking-wide">Select {{ is_array($question['correct_answer']) ? count($question['correct_answer']) : 'multiple' }} answers</p>
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
                        <div class="mt-8 mb-12 flex justify-center">
                            <button type="button" onclick="evaluateIeltsReading()" id="eval-button" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all text-lg flex items-center gap-2 transform hover:scale-105">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Selesai & Cek Jawaban
                            </button>
                        </div>

                        <!-- Evaluation Summary Box -->
                        <div id="eval-summary" class="hidden mt-8 mb-12 bg-white rounded-2xl shadow-xl border border-gray-100 p-8 transition-all duration-500">
                            <div class="text-center mb-6">
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">Hasil Evaluasi</h2>
                                <p class="text-gray-500">Berikut adalah analisis jawaban Anda</p>
                            </div>
                            <div class="flex justify-center items-center gap-8 mb-8">
                                <div class="text-center">
                                    <div class="text-5xl font-bold text-emerald-500 mb-1" id="eval-score">-</div>
                                    <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Benar</div>
                                </div>
                                <div class="h-16 w-px bg-gray-200"></div>
                                <div class="text-center">
                                    <div class="text-5xl font-bold text-rose-500 mb-1" id="eval-wrong">-</div>
                                    <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Salah/Kosong</div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 text-center">
                                <p class="text-blue-800 font-medium">Scroll ke atas untuk melihat penjelasan dan perbaikan pada setiap pertanyaan.</p>
                            </div>
                            <div class="mt-6 text-center">
                                <button type="button" onclick="window.location.reload()" class="text-gray-500 hover:text-gray-800 font-medium underline">Ulangi Latihan</button>
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
    async function evaluateIeltsReading() {
        // Prevent multiple clicks
        const evalBtn = document.getElementById('eval-button');
        const originalBtnText = evalBtn.innerHTML;
        evalBtn.innerHTML = '<svg class="w-6 h-6 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengevaluasi...';
        evalBtn.disabled = true;

        // Collect answers
        const allInputs = document.querySelectorAll('[data-qid]');
        const userAnswers = {};
        
        allInputs.forEach(input => {
            const qid = input.getAttribute('data-qid');
            if (!qid) return;
            
            if (input.type === 'checkbox' || input.type === 'radio') {
                if (input.checked) {
                    if (input.type === 'radio') {
                        userAnswers[qid] = input.value;
                    } else {
                        if (!userAnswers[qid]) userAnswers[qid] = [];
                        userAnswers[qid].push(input.value);
                    }
                }
            } else {
                userAnswers[qid] = input.value;
            }
        });

        try {
            const response = await fetch("{{ route('assignments.ielts-academic.reading.practice-submit') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    material_id: "{{ $material_id ?? '' }}",
                    answers: userAnswers
                })
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();
            
            const answerKeyData = data.answer_key;
            
            // Render Feedback
            Object.keys(answerKeyData).forEach(qid => {
                const ansData = answerKeyData[qid];
                if (!ansData.correct) return;

                let userAnswer = userAnswers[qid] || null;
                let isCorrect = false;
                
                // Compare (similar to backend logic for UI rendering purposes)
                if (Array.isArray(ansData.correct)) {
                    if (Array.isArray(userAnswer)) {
                        const sortedUser = [...userAnswer].sort();
                        const sortedCorrect = [...ansData.correct].sort();
                        isCorrect = JSON.stringify(sortedUser) === JSON.stringify(sortedCorrect);
                    } else {
                        const normalizedCorrect = ansData.correct.map(c => c.toString().trim().toLowerCase());
                        isCorrect = userAnswer && normalizedCorrect.includes(userAnswer.toString().trim().toLowerCase());
                    }
                } else {
                    const ansStr = (userAnswer || '').toString().trim().toLowerCase();
                    const corrStr = (ansData.correct || '').toString().trim().toLowerCase();
                    isCorrect = ansStr === corrStr && ansStr !== '';
                }

                // Inject Feedback into UI
                const inputs = document.querySelectorAll(`[data-qid="${qid}"]`);
                if (inputs.length === 0) return;
                const firstInput = inputs[0];
                
                const wrapper = firstInput.closest('td') || firstInput.closest('.flex.items-center.justify-between') || firstInput.closest('.pl-10') || firstInput.closest('.mb-4') || firstInput.parentElement;
                
                if (wrapper) {
                    if (isCorrect) {
                        firstInput.classList.add('border-emerald-500', 'bg-white', 'text-emerald-700');
                        firstInput.classList.remove('border-gray-300', 'border-gray-200');
                    } else {
                        firstInput.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-700');
                        firstInput.classList.remove('border-gray-300', 'border-gray-200');
                    }

                    inputs.forEach(i => {
                        i.setAttribute('disabled', 'true');
                        i.classList.add('cursor-not-allowed', 'opacity-80');
                    });

                    const feedbackHtml = `
                        <div class="mt-3 p-4 rounded-xl border ${isCorrect ? 'bg-white border-emerald-200' : 'bg-rose-50 border-rose-200'} shadow-sm text-left animate-fade-in">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-bold text-sm uppercase tracking-wide ${isCorrect ? 'text-emerald-700' : 'text-rose-700'}">
                                    ${isCorrect ? '✓ Benar' : '✕ Salah'}
                                </span>
                            </div>
                            <div class="text-sm text-gray-800 mb-2">
                                <span class="font-semibold text-gray-600">Jawaban Benar:</span> 
                                <span class="font-bold bg-white px-2 py-0.5 rounded border border-gray-200">${Array.isArray(ansData.correct) ? ansData.correct.join(', ') : ansData.correct}</span>
                            </div>
                            ${ansData.explanation ? `
                            <div class="mt-3 pt-3 border-t ${isCorrect ? 'border-emerald-200/60' : 'border-rose-200/60'}">
                                <div class="font-semibold text-xs text-gray-500 uppercase tracking-wide mb-1">Penjelasan:</div>
                                <div class="text-sm text-gray-700 leading-relaxed">${ansData.explanation}</div>
                            </div>
                            ` : ''}
                        </div>
                    `;
                    
                    if (firstInput.closest('td')) {
                        const div = document.createElement('div');
                        div.innerHTML = feedbackHtml;
                        wrapper.appendChild(div);
                    } else {
                        const div = document.createElement('div');
                        div.innerHTML = feedbackHtml;
                        wrapper.parentNode.insertBefore(div, wrapper.nextSibling);
                    }
                }
            });

            // Update summary numbers
            document.getElementById('eval-score').innerText = data.correct;
            document.getElementById('eval-wrong').innerText = data.total - data.correct;

            evalBtn.classList.add('hidden');
            const summaryBox = document.getElementById('eval-summary');
            summaryBox.classList.remove('hidden');
            summaryBox.scrollIntoView({ behavior: 'smooth', block: 'center' });

        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan saat mengevaluasi jawaban. Silakan coba lagi.');
            evalBtn.innerHTML = originalBtnText;
            evalBtn.disabled = false;
        }
    }
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
