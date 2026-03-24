@extends('layouts.admin')

@section('content')
@php
    $isSingle = isset($content['passage_title']);
    $sections = $isSingle ? [$content] : $content;
    $globalQIndex = 0;
@endphp

<!-- Full-screen reading layout — fixed to viewport, bypasses admin layout chain -->
<!-- Full-screen reading layout — fixed to viewport, bypasses admin layout chain -->
<div id="mat-outer" class="fixed inset-0 z-0 grid grid-rows-[auto_1fr] bg-gray-50 md:pl-64">
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
                        <p class="text-gray-500 text-xs md:text-sm font-medium">IELTS Academic Reading</p>
                    </div>
                </div>
                
                <a href="{{ route('assignments.ielts-academic.reading.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span class="hidden md:inline">Back</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Split Screen: grid fills remaining vertical space -->
    <div id="mat-grid" class="min-h-0 grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">

            
            <!-- LEFT PANEL: Passages -->
            <div class="h-full overflow-y-auto bg-gray-50 border-r border-gray-200 custom-scrollbar relative">
                <div class="pl-6 pr-3 md:pl-8 md:pr-4 pt-6 md:pt-8 pb-32">
                    @if($sections)
                        @foreach($sections as $index => $section)
                            <!-- Passage Card -->
                            <div id="passage-{{ $index }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 relative group">
                                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">Passage {{ $index + 1 }}</span>
                                        <h2 class="text-xl md::text-2xl font-bold text-gray-900">{{ $section['passage_title'] ?? 'Passage' }}</h2>
                                    </div>
                                    <div class="flex gap-2">
                                        @if(isset($section['id']))
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

                                    <div class="passage-content prose prose-lg max-w-none text-gray-700 leading-loose pr-2 sm:pr-0 pb-12"
                                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);">
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
            <div id="questions-panel" class="h-full overflow-y-auto bg-gray-50 custom-scrollbar relative">
                
                <div class="p-1 md:p-2 pb-32">
                     @if($sections)
                        @foreach($sections as $index => $section)
                            <!-- Questions Card -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-3 mb-4" data-passage-index="{{ $index }}">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-red-500 uppercase tracking-wider">Questions for Passage {{ $index + 1 }}</span>
                                        <div class="h-px bg-gray-200 flex-1"></div>
                                    </div>
                                    <button onclick="openQuestionModal({{ $index }})" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg transition-colors">+ Add Question</button>
                                </div>

                                @foreach($section['questions'] as $qIndex => $question)
                                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 hover:border-blue-300 transition-colors duration-200"
                                         x-data="{ 
                                            selected: {{ isset($question['sub_questions']) ? '{' . collect($question['sub_questions'])->map(function($sq) { return "'".$sq['id']."': ''"; })->implode(',') . '}' : (isset($question['type']) && $question['type'] === 'checkbox' ? '[]' : 'null') }} 
                                         }"
                                    >
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1 flex gap-3">
                                                @php
                                                    $isGroup = isset($question['sub_questions']) || in_array($question['type'] ?? '', ['summary_completion', 'sentence_completion', 'table_completion', 'diagram_labelling', 'matching_headings', 'matching_features', 'matching_sentence_endings', 'true_false', 'true_false_not_given', 'yes_no_not_given', 'matching_paragraph_information', 'short_answer_group']);
                                                    
                                                    $count = 1;
                                                    if (isset($question['sub_questions'])) {
                                                        $count = count($question['sub_questions']);
                                                    } elseif (isset($question['blanks'])) {
                                                        $count = count($question['blanks']);
                                                    } elseif (isset($question['placeholders'])) {
                                                        $count = count($question['placeholders']);
                                                    }
                                                    
                                                    if (isset($question['start_number'])) {
                                                        $currentBadgeNum = $question['start_number'] + 1;
                                                        $globalQIndex = $currentBadgeNum + $count - 1;
                                                    } else {
                                                        $currentBadgeNum = $globalQIndex + 1;
                                                        $globalQIndex = $globalQIndex + $count;
                                                        $question['start_number'] = $currentBadgeNum - 1;
                                                    }
                                                @endphp
                                                
                                                @if(!$isGroup)
                                                <div class="flex-none pt-0.5">
                                                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-50 text-blue-600 font-bold text-xs ring-1 ring-blue-100">
                                                        {{ $currentBadgeNum }}
                                                    </span>
                                                </div>
                                                @endif
                                                <div class="flex-1 group">
                                                    <div class="question-text-content text-base font-semibold text-gray-800 leading-relaxed cursor-text hover:cursor-pointer transition-colors" title="Click any word to find it in the passage">
                                                        @php
                                                            $isTfNg = in_array($question['type'] ?? '', ['true_false', 'true_false_not_given']);
                                                            $isYnNg = in_array($question['type'] ?? '', ['yes_no_not_given']);
                                                            $formattedText = $question['text'];
                                                            
                                                            if ($isTfNg || $isYnNg) {
                                                                // Strip existing instruction blocks
                                                                $formattedText = preg_replace('/(<br\s*\/?>)?\s*In boxes.*?write:?\s*(<br\s*\/?>)?\s*(<b>)?(TRUE|YES).*/si', '', $formattedText);
                                                                $formattedText = preg_replace('/(<br\s*\/?>)?\s*Write\s+(YES|TRUE)\s+if.*/si', '', $formattedText);
                                                                $formattedText = preg_replace('/Write\s+(TRUE|YES)\s+if\s+the\s+statement.*?,?.*?or\s+NOT\s+GIVEN.*?(passage|this)\.?/si', '', $formattedText);
                                                                $formattedText = preg_replace('/Write\s+(?:<b>|<strong>)?(TRUE|YES)(?:<\/b>|<\/strong>)?\s+if\s+the\s+statement.*?(?:<b>|<strong>)?(FALSE|NO)(?:<\/b>|<\/strong>)?\s+if\s+the\s+statement.*?(?:,?\s*or\s+)?(?:<b>|<strong>)?NOT\s+GIVEN(?:<\/b>|<\/strong>)?\s+if.*/si', '', $formattedText);
                                                                
                                                                // Remove potential "Questions 1-5" header from the string
                                                                $formattedText = preg_replace('/^Questions?\s*\d+(–|-)\d+\s*(<br\s*\/?>)?/i', '', $formattedText);
                                                            }
                                                            
                                                            $formattedText = preg_replace('/(NB\s*:?\s*You may use any letter more than once\.?)/i', '<i class="font-normal text-gray-600">$1</i>', $formattedText);
                                                        @endphp
                                                        {!! $formattedText !!}
                                                    </div>
                                                    @if($isTfNg || $isYnNg)
                                                        <div class="mt-6 mb-4">
                                                                <p class="text-[15px] text-gray-800 italic mb-4">
                                                                    @if($currentBadgeNum === $globalQIndex)
                                                                        In box <span class="font-bold">{{ $currentBadgeNum }}</span> on your answer sheet, write
                                                                    @else
                                                                        In boxes <span class="font-bold">{{ $currentBadgeNum }}-{{ $globalQIndex }}</span> on your answer sheet, write
                                                                    @endif
                                                                </p>
                                                                <div class="text-[15px] text-gray-800 ml-8 md:ml-16 flex flex-col gap-1.5">
                                                                    <div class="flex gap-4 md:gap-6 items-start">
                                                                        <div class="font-bold tracking-wide w-24 flex-shrink-0">{{ $isTfNg ? 'TRUE' : 'YES' }}</div>
                                                                        <div class="italic whitespace-nowrap">if the statement agrees with the {{ $isTfNg ? 'information' : 'claims of the writer' }}</div>
                                                                    </div>
                                                                    <div class="flex gap-4 md:gap-6 items-start">
                                                                        <div class="font-bold tracking-wide w-24 flex-shrink-0">{{ $isTfNg ? 'FALSE' : 'NO' }}</div>
                                                                        <div class="italic whitespace-nowrap">if the statement contradicts the {{ $isTfNg ? 'information' : 'claims of the writer' }}</div>
                                                                    </div>
                                                                    <div class="flex gap-4 md:gap-6 items-start">
                                                                        <div class="font-bold tracking-wide w-24 flex-shrink-0">NOT GIVEN</div>
                                                                        <div class="italic whitespace-nowrap">if {{ $isTfNg ? 'there is no information on this' : 'it is impossible to say what the writer thinks about this' }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @if(isset($question['type']) && $question['type'] === 'checkbox')
                                                        <p class="text-xs text-blue-500 font-medium mt-1.5 uppercase tracking-wide">Select {{ is_array($question['correct_answer']) ? count($question['correct_answer']) : 'multiple' }} answers</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex gap-2 flex-shrink-0 items-start">
                                                    @if(isset($question['db_id']))
                                                        <button onclick="openQuestionModal({{ $index }}, {{ $qIndex }})" class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded transition-colors">Edit</button>
                                                        <button onclick="deleteQuestion({{ $question['db_id'] }})" class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded transition-colors">Delete</button>
                                                    @endif
                                            </div>
                                        </div>

                                        <div class="pl-0 md:pl-2">
                                            @if(isset($question['type']) && (in_array($question['type'], ['matching_headings', 'matching_features', 'matching_sentence_endings', 'true_false', 'true_false_not_given', 'yes_no_not_given', 'matching_paragraph_information'])))
                                                
                                                <!-- List of Headings/Features Box (Top) -->
                                                @if(!empty($question['box_title']) && in_array($question['type'], ['matching_headings', 'matching_features']))
                                                <div class="mb-8 border-2 border-gray-300 p-4 rounded-none bg-white">
                                                    <h4 class="text-center font-bold text-gray-800 mb-4 text-lg">{{ $question['box_title'] ?? 'List of Headings' }}</h4>
                                                    <ul class="space-y-2">
                                                        @foreach($question['options'] as $optKey => $optText)
                                                            <li class="text-gray-700 text-sm md:text-base leading-relaxed pl-8 -indent-8 flex gap-2">
                                                                <span class="font-bold min-w-[25px] inline-block">{{ $optKey }}</span>
                                                                <span>{{ $optText }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif

                                                @if(!empty($question['box_title']))
                                                <!-- Questions List with Dropdowns (Existing Layout) -->
                                                <div class="space-y-4 max-w-2xl mx-auto">
                                                    @foreach($question['sub_questions'] as $subIndex => $subQuestion)
                                                        <div class="flex items-center justify-between gap-4 py-2 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors px-2 rounded-lg">
                                                            <div class="flex items-start gap-3 w-3/4 pt-1">
                                                                <span class="text-gray-500 font-bold text-base md:text-lg mt-0.5">{{ $subIndex + 1 + ($question['start_number'] ?? 0) }}</span>
                                                                <span class="font-normal text-gray-900 text-lg md:text-xl leading-relaxed block">{{ $subQuestion['label'] }}</span>
                                                            </div>
                                                            
                                                            <div class="relative w-1/4 max-w-[140px]">
                                                                <select 
                                                                    x-model="selected['{{ $subQuestion['id'] }}']"
                                                                    class="appearance-none w-full bg-white border-2 border-gray-300 text-gray-700 py-2.5 px-3 pr-8 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-bold text-center cursor-pointer text-base md:text-lg shadow-sm transition-colors"
                                                                >
                                                                    <option value="" disabled selected>-</option>
                                                                    @foreach($question['options'] ?? [] as $optKey => $optText)
                                                                        <option value="{{ $optKey }}">{{ $optKey }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @else
                                                <!-- Table Layout for T/F/NG (No Box) -->
                                                <div class="overflow-x-auto mt-6">
                                                    <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                                                        <thead>
                                                            <tr class="bg-gray-50 border-b border-gray-200">
                                                                <th class="p-4 font-bold text-gray-600 w-12 text-center">#</th>
                                                                <th class="p-4 font-bold text-gray-600">Question Statement</th>
                                                                <th class="p-4 font-bold text-gray-600 w-48 text-center">Answer</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($question['sub_questions'] ?? [] as $subIndex => $subQuestion)
                                                                <tr class="group/row border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                                                    <td class="py-2 px-4 font-bold text-blue-600 text-center">
                                                                        {{ $subIndex + 1 + ($question['start_number'] ?? 0) }}
                                                                    </td>
                                                                    <td class="py-2 px-4 text-gray-800 font-medium leading-relaxed cursor-text transition-colors relative" title="Click any word to find it in the passage">
                                                                        <span class="block">{{ $subQuestion['label'] }}</span>
                                                                    </td>
                                                                    <td class="py-2 px-4 text-center">
                                                                        <div class="relative inline-block w-full">
                                                                            <select 
                                                                                x-model="selected['{{ $subQuestion['id'] }}']"
                                                                                class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer"
                                                                                :class="{'text-blue-600 border-blue-500': selected['{{ $subQuestion['id'] }}']}"
                                                                            >
                                                                                <option value="" disabled selected>-</option>
                                                                                @foreach($question['options'] ?? [] as $optKey => $optText)
                                                                                    <option value="{{ $optKey }}">{{ $optKey }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @endif

                                                <!-- List of Endings Box (Bottom) -->
                                                @if(!empty($question['box_title']) && $question['type'] === 'matching_sentence_endings')
                                                <div class="mt-8 border-2 border-gray-300 p-4 rounded-none bg-white">
                                                    <h4 class="text-center font-bold text-gray-800 mb-4 text-lg">{{ $question['box_title'] ?? 'List of Endings' }}</h4>
                                                    <ul class="space-y-2">
                                                        @foreach($question['options'] ?? [] as $optKey => $optText)
                                                            <li class="text-gray-700 text-sm md:text-base leading-relaxed pl-8 -indent-8 flex gap-2">
                                                                <span class="font-bold min-w-[25px] inline-block">{{ $optKey }}</span>
                                                                <span>{{ $optText }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                            @elseif(isset($question['type']) && $question['type'] === 'table_completion')
                                                <!-- Table Completion -->
                                                <div class="overflow-x-auto mt-6 mb-8">
                                                    @if(!empty($question['instruction']))
                                                        <p class="mb-4 italic text-gray-700">{!! $question['instruction'] !!}</p>
                                                    @endif
                                                    
                                                    <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200 text-sm md:text-base">
                                                        <thead>
                                                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                                                @foreach($question['columns'] ?? [] as $col)
                                                                    <th class="p-3 font-bold text-gray-800 border-r border-gray-300 last:border-0 align-top {{ $loop->last ? 'min-w-[200px]' : '' }}">{{ $col }}</th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($question['rows'] ?? [] as $rowIndex => $row)
                                                                <tr class="border-b border-gray-200 last:border-0 hover:bg-gray-50 transition-colors">
                                                                    @foreach($row as $cellIndex => $cellContent)
                                                                        <td class="p-3 border-r border-gray-300 last:border-0 align-top text-gray-700 leading-relaxed">
                                                                            @php
                                                                                $cellText = $cellContent;
                                                                                // Check if placeholders exist in this cell
                                                                                if (isset($question['placeholders'])) {
                                                                                    foreach(($question['placeholders'] ?? []) as $key => $qNum) {
                                                                                        if (str_contains($cellText, "[$key]")) {
                                                                                            $inputHtml = '<div class="inline-block relative mx-1 align-baseline">' . 
                                                                                                         '<span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-600 font-bold text-xs select-none">' . $qNum . '</span>' .
                                                                                                         '<input type="text" placeholder=" _______ " class="border border-gray-300 focus:border-blue-500 rounded outline-none bg-white pl-10 pr-2 py-1 w-28 md:w-36 text-gray-900 font-medium shadow-sm transition-all focus:ring-1 focus:ring-blue-200 text-sm">' .
                                                                                                         '</div>';
                                                                                            $cellText = str_replace("[$key]", $inputHtml, $cellText);
                                                                                        }
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            {!! $cellText !!}
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            @elseif(isset($question['type']) && $question['type'] === 'diagram_labelling')
                                                <!-- Diagram Labelling -->
                                                <div class="mt-6 mb-8 overflow-x-auto">
                                                    @if(!empty($question['instruction']))
                                                        <p class="mb-4 italic text-gray-700">{!! $question['instruction'] !!}</p>
                                                    @endif
                                                    
                                                    <div class="relative rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-gray-50 mx-auto" style="min-width: 900px !important;">
                                                        <img src="{{ asset($question['image'] ?? '') }}" alt="Diagram for Question {{ $question['question_number'] ?? $question['id'] }}" class="w-full h-auto object-contain">
                                                        
                                                        @foreach($question['sub_questions'] ?? [] as $subQuestion)
                                                            <div class="absolute transform -translate-y-1/2" style="top: {{ $subQuestion['y'] ?? 0 }}%; left: {{ $subQuestion['x'] ?? 0 }}%;">
                                                                <div class="flex items-center border border-gray-400 rounded-md px-2 py-1 transition-all focus-within:border-blue-500 bg-white hover:border-blue-400 shadow-sm">
                                                                    <span class="font-bold text-blue-700 mr-2 text-sm select-none">{{ $subQuestion['label'] }}</span>
                                                                    <input type="text" 
                                                                           x-model="selected['{{ $subQuestion['id'] }}']"
                                                                           class="bg-transparent border-none p-0 w-24 focus:ring-0 text-sm text-gray-900 placeholder-gray-600 font-bold"
                                                                           placeholder="Answer...">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            @elseif(isset($question['type']) && in_array($question['type'], ['summary_completion', 'sentence_completion']))
                                                <!-- Summary Completion -->
                                                <div class="border-2 border-gray-800 p-6 rounded-none mb-6">
                                                    @if(!empty($question['box_title']))
                                                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $question['box_title'] }}</h3>
                                                    @endif
                                                    
                                                    @if(!empty($question['instruction']))
                                                        <p class="mb-4 italic text-gray-700">{!! $question['instruction'] !!}</p>
                                                    @endif



                                                    <div class="text-gray-800 leading-loose text-lg font-medium">
                                                        @php
                                                            $summaryText = $question['summary_text'] ?? $question['text'] ?? '';

                                                            // Format 1: legacy 'placeholders' → ['q10' => 10, ...]
                                                            $placeholderMap = [];
                                                            if (!empty($question['placeholders'])) {
                                                                foreach ($question['placeholders'] as $key => $qNum) {
                                                                    $placeholderMap[$key] = $qNum;
                                                                }
                                                            }

                                                            // Format 2: 'blanks' → [['id'=>'q10','blank_number'=>10], ...]
                                                            if (!empty($question['blanks'])) {
                                                                foreach ($question['blanks'] as $blank) {
                                                                    $placeholderMap[$blank['id']] = $blank['blank_number'];
                                                                }
                                                            }

                                                            foreach ($placeholderMap as $key => $qNum) {
                                                                $inputHtml = '<span class="inline-block relative mx-1 align-middle">' .
                                                                             '<span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-600 font-bold text-xs select-none">' . $qNum . '</span>' .
                                                                             '<input type="text" data-id="' . $key . '" class="user-answer border-2 border-gray-300 focus:border-blue-500 rounded-md outline-none bg-white pl-8 pr-3 py-1.5 w-48 text-gray-800 font-medium shadow-sm transition-all focus:ring-2 focus:ring-blue-100">' .
                                                                             '</span>';
                                                                // Match [N] bracket style (e.g. [10]) in summary_text
                                                                $summaryText = str_replace('[' . $qNum . ']', $inputHtml, $summaryText);
                                                                // Also match [key] style (e.g. [q10])
                                                                $summaryText = str_replace('[' . $key . ']', $inputHtml, $summaryText);
                                                            }
                                                        @endphp
                                                        {!! $summaryText !!}
                                                    </div>

                                                    @if(isset($question['box_options']))
                                                        <div class="bg-gray-100 p-4 rounded-lg border border-gray-200 mt-6">
                                                            <strong class="block text-gray-700 mb-2 uppercase text-sm tracking-wide">List of Words</strong>
                                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                                                @foreach($question['box_options'] ?? [] as $key => $option)
                                                                    <div class="text-sm">
                                                                        <span class="font-bold text-gray-900 mr-1">{{ $key }}</span> 
                                                                        <span class="text-gray-700">{{ $option }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif(isset($question['type']) && $question['type'] === 'short_answer_group')
                                                {{-- Short Answer Group: numbered questions with text inputs below --}}
                                                <div class="space-y-5 mt-4">
                                                    @foreach($question['sub_questions'] ?? [] as $subIndex => $subQuestion)
                                                        <div class="flex flex-col gap-2 py-3 border-b border-gray-100 last:border-0">
                                                            <div class="flex items-start gap-3">
                                                                <span class="flex-none w-7 h-7 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm border border-blue-100">
                                                                    {{ $subIndex + 1 + ($question['start_number'] ?? 0) }}
                                                                </span>
                                                                <span class="font-normal text-gray-700 leading-relaxed block pt-0.5">{{ $subQuestion['label'] }}</span>
                                                            </div>
                                                            <div class="pl-10">
                                                                <input type="text"
                                                                       x-model="selected['{{ $subQuestion['id'] }}']"
                                                                       class="w-full max-w-sm px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 text-gray-800 font-medium text-sm placeholder-gray-300 transition-all shadow-sm"
                                                                       placeholder="Type answer here...">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif(isset($question['sub_questions']))
                                                <!-- Fallback for other sub-question types (like Matching Features) -->
                                                <div class="space-y-6 pl-10">
                                                    @foreach($question['sub_questions'] ?? [] as $subIndex => $subQuestion)
                                                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                                            <div class="mb-4 flex items-start gap-4">
                                                                <span class="flex-none w-8 h-8 rounded-full bg-white border-2 border-blue-100 text-sm font-bold text-gray-600 flex items-center justify-center shadow-sm relative top-0.5">
                                                                    {{ $subIndex + 1 + ($question['start_number'] ?? 0) }}
                                                                </span>
                                                                <p class="font-medium text-gray-900 text-lg md:text-xl leading-relaxed mt-0 mb-0">{{ $subQuestion['label'] }}</p>
                                                            </div>
                                                            <div class="space-y-3">
                                                                @foreach($question['options'] ?? [] as $optKey => $optText)
                                                                    <label class="group flex items-center gap-3 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-white hover:border-blue-300 transition-all duration-200"
                                                                           :class="{ 
                                                                                'bg-white border-blue-500 ring-1 ring-blue-500 shadow-sm': selected['{{ $subQuestion['id'] }}'] === '{{ $optKey }}',
                                                                                'bg-gray-50/50': selected['{{ $subQuestion['id'] }}'] !== '{{ $optKey }}'
                                                                           }">
                                                                        
                                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-200 border"
                                                                             :class="{ 
                                                                                'bg-blue-600 text-white border-blue-600': selected['{{ $subQuestion['id'] }}'] === '{{ $optKey }}', 
                                                                                'bg-white text-gray-600 border-gray-300 group-hover:border-blue-400': selected['{{ $subQuestion['id'] }}'] !== '{{ $optKey }}' 
                                                                             }">
                                                                            {{ $optKey }}
                                                                        </div>

                                                                        <span class="text-base md:text-lg text-gray-700 font-medium group-hover:text-gray-900 transition-colors"
                                                                                :class="{ 'text-blue-900 font-bold': selected['{{ $subQuestion['id'] }}'] === '{{ $optKey }}' }">
                                                                            {{ $optText }}
                                                                        </span>
                                                                        
                                                                        <input type="radio" 
                                                                               name="question_{{ $qIndex }}_{{ $subQuestion['id'] }}" 
                                                                               value="{{ $optKey }}" 
                                                                               class="hidden" 
                                                                               x-model="selected['{{ $subQuestion['id'] }}']">
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            @elseif(isset($question['type']) && $question['type'] === 'short_answer')
                                                <!-- Short Answer Input -->
                                                <div class="pl-10">
                                                    <input type="text"
                                                           x-model="selected"
                                                           class="w-full md:w-2/3 p-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors text-gray-700 font-medium"
                                                           placeholder="Type your answer here..."
                                                    >
                                                </div>
                                            @else
                                                <div class="space-y-3 pl-10">
                                                    @foreach($question['options'] ?? [] as $optKey => $optText)
                                                        <label class="group flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-all duration-200"
                                                               :class="{ 
                                                                    'bg-blue-50 border-blue-500 ring-1 ring-blue-500 shadow-sm': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}',
                                                                    'bg-white': !(Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}')
                                                               }">
                                                            
                                                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-colors duration-200 border"
                                                                 :class="{ 
                                                                    'bg-blue-600 text-white border-blue-600': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}', 
                                                                    'bg-gray-50 text-gray-500 border-gray-200 group-hover:bg-white group-hover:border-blue-400': !(Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}') 
                                                                 }">
                                                                {{ $optKey }}
                                                            </div>

                                                                <span class="text-base md:text-lg text-gray-700 font-medium group-hover:text-gray-900 transition-colors"
                                                                        :class="{ 'text-blue-900 font-bold': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}' }">
                                                                    {{ $optText }}
                                                                </span>
                                                            
                                                            @if(isset($question['type']) && $question['type'] === 'checkbox')
                                                                <input type="checkbox" name="question_{{ $qIndex }}[]" value="{{ $optKey }}" class="hidden" x-model="selected">
                                                            @else
                                                                <input type="radio" name="question_{{ $qIndex }}" value="{{ $optKey }}" class="hidden" x-model="selected">
                                                          @endif

                                                    @if(isset($question['box_options']))
                                                        <div class="bg-gray-100 p-4 rounded-lg border border-gray-200 mb-6">
                                                            <strong class="block text-gray-700 mb-2 uppercase text-sm tracking-wide">List of Words</strong>
                                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                                                @foreach($question['box_options'] ?? [] as $key => $option)
                                                                    <div class="text-sm">
                                                                        <span class="font-bold text-gray-900 mr-1">{{ $key }}</span> 
                                                                        <span class="text-gray-700">{{ $option }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($question['box_options']))
                                                        <div class="bg-gray-100 p-4 rounded-lg border border-gray-200 mb-6">
                                                            <strong class="block text-gray-700 mb-2 uppercase text-sm tracking-wide">List of Words</strong>
                                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                                                @foreach($question['box_options'] ?? [] as $key => $option)
                                                                    <div class="text-sm">
                                                                        <span class="font-bold text-gray-900 mr-1">{{ $key }}</span> 
                                                                        <span class="text-gray-700">{{ $option }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
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
    .passage-content p {
        margin-bottom: 1.25rem;
        font-size: 1.05rem;
        line-height: 2;
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

    // Admin CRUD Functions
    const materialContent = @json($sections);

    function openPassageModal(index = null) {
        const modal = document.getElementById('passageModal');
        const form = document.getElementById('passageForm');
        
        if (index !== null) {
            const passage = materialContent[index];
            document.getElementById('passage_id').value = passage.id;
            document.getElementById('passage_title').value = passage.passage_title;
            document.getElementById('passage_content').value = passage.passage_text;
            document.getElementById('passageModalTitle').innerText = 'Edit Passage';
            form.action = `/admin/ielts-reading/passage/${passage.id}`;
            document.getElementById('passage_method').value = 'PUT';
        } else {
            // New Passage
            document.getElementById('passage_id').value = '';
            document.getElementById('passage_title').value = '';
            document.getElementById('passage_content').value = '';
            document.getElementById('passageModalTitle').innerText = 'Add Passage';
            form.action = `{{ route('admin.ielts.reading.passage.store') }}`;
            document.getElementById('passage_method').value = 'POST';
        }
        
        modal.classList.remove('hidden');
    }

    function closePassageModal() {
        document.getElementById('passageModal').classList.add('hidden');
    }

    function deletePassage(id) {
        if (!confirm('Are you sure you want to delete this passage? This will delete all associated questions.')) return;
        
        fetch(`/admin/ielts-reading/passage/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function openQuestionModal(passageIndex, questionIndex = null) {
        const modal = document.getElementById('questionModal');
        const form = document.getElementById('questionForm');
        const passage = materialContent[passageIndex];
        
        document.getElementById('q_passage_id').value = passage.id; 
        
        if (questionIndex !== null) {
            const question = passage.questions[questionIndex];
            document.getElementById('question_id').value = question.db_id;
            document.getElementById('question_number').value = question.id;
            document.getElementById('question_text').value = question.text || '';
            document.getElementById('question_explanation').value = question.explanation || '';
            document.getElementById('question_type').value = question.type;
            
            console.log('Opened Question:', question); // DEBUG: Check if data is present
            console.log('Question Data:', question.data); // DEBUG: Check if data object exists

            // Reconstruct data object for JSON field
            // Use existing data as base to preserve fields like 'image'
            const dataObj = question.data ? JSON.parse(JSON.stringify(question.data)) : {};
            
            // Ensure core fields are synced if they differ (though usually they are in data too or handled separately)
            if(question.options) dataObj.options = question.options;
            if(question.correct_answer) dataObj.correct_answer = question.correct_answer;

            // We don't need to manually check for sub_questions etc if we copy data
            // But let's keep the explicit checks just in case data was null but sub_questions existed on top level (unlikely)
            if(question.sub_questions && !dataObj.sub_questions) dataObj.sub_questions = question.sub_questions;
            if(question.box_title && !dataObj.box_title) dataObj.box_title = question.box_title;
            if(question.summary_text && !dataObj.summary_text) dataObj.summary_text = question.summary_text;
            if(question.placeholders && !dataObj.placeholders) dataObj.placeholders = question.placeholders;
            if(question.box_options && !dataObj.box_options) dataObj.box_options = question.box_options;

            document.getElementById('question_data').value = JSON.stringify(dataObj, null, 2);
            
            // Visual Editor Handling
            const editorContainer = document.getElementById('diagramEditor');
            const editorImage = document.getElementById('diagramImage');
            
            if (question.type === 'diagram_labelling') {
                editorContainer.classList.remove('hidden');
                editorContainer.style.display = 'block'; 

                const imgSrc = question.image || (question.data && question.data.image) || '';
                const errorMsg = document.getElementById('diagramError');
                const toolbar = document.getElementById('editorToolbar');
                const canvas = document.getElementById('diagramCanvas');

                if(imgSrc) {
                    // Success Case
                    if(errorMsg) errorMsg.classList.add('hidden');
                    if(toolbar) toolbar.classList.remove('hidden');
                    if(canvas) canvas.classList.remove('hidden');

                    if(editorImage) {
                         editorImage.src = imgSrc;
                         if (editorImage.complete && editorImage.naturalHeight !== 0) {
                             initDiagramEditor(dataObj);
                         } else {
                             editorImage.onload = () => initDiagramEditor(dataObj);
                         }
                    }
                } else {
                    // Error Case
                    if(errorMsg) errorMsg.classList.remove('hidden');
                    if(toolbar) toolbar.classList.add('hidden');
                    if(canvas) canvas.classList.add('hidden');
                }
            } else {
                editorContainer.classList.add('hidden');
                editorContainer.style.display = 'none';
            }
            
            document.getElementById('questionModalTitle').innerText = 'Edit Question';
            form.action = `/admin/ielts-reading/question/${question.db_id}`;
            document.getElementById('question_method').value = 'PUT';
        } else {
            // New Question
            document.getElementById('question_id').value = '';
            document.getElementById('question_number').value = (passage.questions.length + 1);
            document.getElementById('question_text').value = '';
            document.getElementById('question_explanation').value = '';
            document.getElementById('question_type').value = 'matching_headings';
            document.getElementById('question_data').value = '{\n  "options": [],\n  "correct_answer": [],\n  "sub_questions": []\n}';
            
            document.getElementById('questionModalTitle').innerText = 'Add Question';
            form.action = `{{ route('admin.ielts.reading.question.store') }}`;
            document.getElementById('question_method').value = 'POST';
        }
        
        modal.classList.remove('hidden');
    }

    function closeQuestionModal() {
        document.getElementById('questionModal').classList.add('hidden');
    }

    function deleteQuestion(id) {
        if (!confirm('Are you sure you want to delete this question block?')) return;
        
        fetch(`/admin/ielts-reading/question/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Form Submissions
    // Form Submissions
    document.addEventListener('DOMContentLoaded', function() {
        const passageForm = document.getElementById('passageForm');
        if (passageForm) {
            passageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                data.material_id = {{ $id }}; // Current Material ID

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'X-HTTP-Method-Override': data._method || 'POST'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) location.reload();
                    else alert(data.message);
                });
            });
        }

        const questionForm = document.getElementById('questionForm');
        if (questionForm) {
            questionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                
                function appendFormData(formData, data, parentKey) {
                    if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
                        Object.keys(data).forEach(key => {
                            appendFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                        });
                    } else {
                        const value = data == null ? '' : data;
                        formData.append(parentKey, value);
                    }
                }

                const finalFormData = new FormData(form);
                
                // Parse "data" field from JSON string to object and flatten it for FormData
                try {
                    console.log('Submitting form...');
                    console.log('Raw JSON:', data.data_json);
                    const rawData = JSON.parse(data.data_json); 
                    // Controller expects 'data' as array
                    appendFormData(finalFormData, rawData, 'data');
                    
                    // Controller also validates specific fields like 'options' and 'correct_answer' at top level
                    if(rawData.options) appendFormData(finalFormData, rawData.options, 'options');
                    if(rawData.correct_answer) appendFormData(finalFormData, rawData.correct_answer, 'correct_answer');
                    
                } catch (err) {
                    alert('Invalid JSON in Data field');
                    return;
                }

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: finalFormData
                })
                .then(async res => {
                    if (!res.ok) {
                        const contentType = res.headers.get("content-type");
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            const errorData = await res.json();
                            throw new Error(errorData.message || 'Validation Error');
                        } else {
                            const text = await res.text();
                            console.error('Server Error:', text);
                            throw new Error('Server responded with ' + res.status);
                        }
                    }
                    return res.json();
                })
                .then(data => {
                    if(data.success) location.reload();
                    else alert('Save Failed: ' + data.message);
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    alert('Error saving question: ' + error.message);
                });
            });
        }
    });
    // Visual Diagram Editor Logic
    let currentDiagramTags = [];
    let activeDrag = null;
    let activeResize = null;

    function initDiagramEditor(dataObj) {
        const editor = document.getElementById('diagramEditor');
        const img = document.getElementById('diagramImage');
        const overlay = document.getElementById('diagramOverlay');
        
        // Reset state
        currentDiagramTags = dataObj.sub_questions || [];
        
        // Load Image
        // If image is in root object (legacy) or data object
        // The modal logic populates dataObj from question.sub_questions etc.
        // We need to find the image URL. It might be in the main question object/data. 
        // We need to pass the full question object or image path to this init function.
        // For now, let's look for 'image' property in the JSON or assume it's passed differently.
        // Quick fix: The image path isn't in sub_questions. It's usually question.image or question.data.image.
        // The openQuestionModal function handles setting the image src on the DOM element.
        
        renderDiagramLabels();
    }

    function renderDiagramLabels() {
        const overlay = document.getElementById('diagramOverlay');
        overlay.innerHTML = ''; // Clear existing

        currentDiagramTags.forEach(tag => {
            const el = document.createElement('div');
            el.className = 'absolute bg-white border border-blue-500 rounded flex items-center shadow-sm group';
            // Default width 120px if not set, convert to percentage or keep px?
            // Existing data uses % for x,y. Let's assume width is px for now or we add width support.
            // If width is missing, default to some reasonable value relative to container or fixed.
            const width = tag.width ? tag.width + 'px' : '100px'; 
            
            el.style.left = tag.x + '%';
            el.style.top = tag.y + '%';
            el.style.width = width;
            el.style.transform = 'translate(0, -50%)'; // Vertically center on the point like the view does
            el.style.cursor = 'move';
            
            el.innerHTML = `
                <span class="font-bold text-blue-700 px-2 select-none">${tag.label}</span>
                <div class="flex-grow h-6 bg-gray-100 border-l border-gray-300"></div>
                <!-- Delete Handle -->
                <button onclick="deleteDiagramLabel('${tag.id}')" class="bg-red-500 text-white w-5 h-5 flex items-center justify-center rounded-full absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity text-xs" title="Delete">×</button>
                <!-- Resize Handle -->
                <div class="absolute right-0 top-0 bottom-0 w-2 cursor-e-resize hover:bg-blue-300" onmousedown="startResize(event, '${tag.id}')"></div>
            `;

            el.onmousedown = (e) => startDrag(e, tag.id);
            overlay.appendChild(el);
        });
    }

    function startDrag(e, id) {
        if (e.target.tagName === 'BUTTON' || e.target.classList.contains('cursor-e-resize')) return; // Ignore if clicking delete or resize
        e.preventDefault();
        e.stopPropagation();
        
        const tag = currentDiagramTags.find(t => t.id == id);
        const overlay = document.getElementById('diagramOverlay');
        const rect = overlay.getBoundingClientRect();
        
        activeDrag = {
            id: id,
            startX: e.clientX,
            startY: e.clientY,
            initialLeft: parseFloat(tag.x), // Ensure it's number
            initialTop: parseFloat(tag.y),   // Ensure it's number
            containerWidth: rect.width,
            containerHeight: rect.height
        };
        
        document.addEventListener('mousemove', handleDrag);
        document.addEventListener('mouseup', stopDrag);
    }

    function handleDrag(e) {
        if (!activeDrag) return;
        
        const dxPx = e.clientX - activeDrag.startX;
        const dyPx = e.clientY - activeDrag.startY;
        
        // Convert px delta to %
        const dxPct = (dxPx / activeDrag.containerWidth) * 100;
        const dyPct = (dyPx / activeDrag.containerHeight) * 100;
        
        let newX = activeDrag.initialLeft + dxPct;
        let newY = activeDrag.initialTop + dyPct;
        
        // Clamp
        newX = Math.max(0, Math.min(100, newX));
        newY = Math.max(0, Math.min(100, newY));
        
        // Update state
        const tag = currentDiagramTags.find(t => t.id == activeDrag.id);
        tag.x = Math.round(newX * 100) / 100;
        tag.y = Math.round(newY * 100) / 100;
        
        renderDiagramLabels();
    }

    function stopDrag() {
        if(activeDrag) {
            syncDiagramData();
            activeDrag = null;
        }
        document.removeEventListener('mousemove', handleDrag);
        document.removeEventListener('mouseup', stopDrag);
    }

    function startResize(e, id) {
        e.preventDefault();
        e.stopPropagation();
        
        const tag = currentDiagramTags.find(t => t.id == id);
        const el = e.target.parentElement;
        
        activeResize = {
            id: id,
            startX: e.clientX,
            initialWidth: parseFloat(el.style.width) // px
        };
        
        document.addEventListener('mousemove', handleResize);
        document.addEventListener('mouseup', stopResize);
    }

    function handleResize(e) {
        if (!activeResize) return;
        const dx = e.clientX - activeResize.startX;
        let newWidth = Math.max(50, activeResize.initialWidth + dx); // Min 50px
        
        const tag = currentDiagramTags.find(t => t.id == activeResize.id);
        tag.width = Math.round(newWidth);
        
        renderDiagramLabels();
    }

    function stopResize() {
        if (activeResize) {
            syncDiagramData();
            activeResize = null;
        }
        document.removeEventListener('mousemove', handleResize);
        document.removeEventListener('mouseup', stopResize);
    }

    function addDiagramLabel() {
        const id = (currentDiagramTags.length + 1).toString();
        currentDiagramTags.push({
            id: id,
            label: id,
            x: 50,
            y: 50,
            width: 100
        });
        renderDiagramLabels();
        syncDiagramData();
    }

    function deleteDiagramLabel(id) {
        if(!confirm('Delete this label?')) return;
        currentDiagramTags = currentDiagramTags.filter(t => t.id != id);
        renderDiagramLabels();
        syncDiagramData();
    }

    function syncDiagramData() {
        const jsonField = document.getElementById('question_data');
        try {
            const currentData = JSON.parse(jsonField.value || '{}');
            currentData.sub_questions = currentDiagramTags;
            jsonField.value = JSON.stringify(currentData, null, 2);
            document.getElementById('jsonSyncMsg').classList.remove('hidden');
            setTimeout(() => document.getElementById('jsonSyncMsg').classList.add('hidden'), 2000);
        } catch(e) {
            console.error("Cannot sync diagram data, invalid JSON in textarea", e);
        }
    }
</script>

<!-- Modals -->
<div id="passageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 max-w-6xl w-full">
        <h3 id="passageModalTitle" class="text-2xl font-bold mb-4">Edit Passage</h3>
        <form id="passageForm">
            <input type="hidden" name="_method" id="passage_method" value="POST">
            <input type="hidden" name="id" id="passage_id">
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="passage_title" class="w-full border p-2 rounded">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Content (HTML)</label>
                <textarea name="content" id="passage_content" class="w-full border p-2 rounded h-96 font-mono text-sm"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closePassageModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="questionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <h3 id="questionModalTitle" class="text-2xl font-bold mb-4">Edit Question</h3>
        <form id="questionForm">
            <input type="hidden" name="_method" id="question_method" value="POST">
            @csrf
            <input type="hidden" name="passage_id" id="q_passage_id">
            <input type="hidden" name="id" id="question_id">
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold mb-2">Number (ID)</label>
                    <input type="text" name="question_number" id="question_number" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Type</label>
                    <select name="type" id="question_type" class="w-full border p-2 rounded">
                        <option value="matching_headings">Matching Headings</option>
                        <option value="summary_completion">Summary Completion</option>
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="true_false">True/False</option>
                        <option value="short_answer">Short Answer</option>
                        <option value="sentence_completion">Sentence Completion</option>
                        <option value="diagram_labelling">Diagram Labelling</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Instruction / Text</label>
                <textarea name="question_text" id="question_text" class="w-full border p-2 rounded h-20"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Answer Key & Explanation</label>
                <textarea name="explanation" id="question_explanation" class="w-full border p-2 rounded h-32"></textarea>
            </div>
            
            <!-- Visual Editor for Diagram Labelling -->
            <div id="diagramEditor" class="mb-4 hidden border rounded p-4 bg-gray-50 overflow-x-auto">
                <label class="block text-sm font-bold mb-2">Visual Diagram Editor</label>
                <!-- Image path is retrieved from question.image or data.image in JS -->
                <p id="diagramError" class="hidden text-red-500 mb-2 font-bold">Error: No image path found. Please add "image" to the JSON.</p>
                <div id="editorToolbar" class="mb-2 flex items-center gap-4 bg-blue-50 p-2 rounded border border-blue-100 min-w-[900px]">
                    <button type="button" onclick="addDiagramLabel()" class="px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700 shadow-sm font-bold">
                        + Add Label
                    </button>
                    <div class="text-xs text-blue-800 flex flex-col">
                        <span><strong>Move:</strong> Click and drag any blue box.</span>
                        <span><strong>Resize:</strong> Drag the right edge of a box.</span>
                        <span><strong>Delete:</strong> Click the red 'X' on a box.</span>
                    </div>
                </div>
                
                <div id="diagramCanvas" class="relative overflow-hidden border border-gray-300 bg-white select-none shadow-inner" style="min-height: 400px; background-color: #f3f4f6; min-width: 900px;">
                    <!-- Image and Labels will be injected here -->
                    <img id="diagramImage" src="" class="w-full h-auto pointer-events-none block" style="user-select: none; pointer-events: none;">
                    <div id="diagramOverlay" class="absolute inset-0 z-10"></div>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Data Configuration (JSON)</label>
                <p class="text-xs text-gray-500 mb-1">Includes options, correct_answer, sub_questions, placeholders. <span id="jsonSyncMsg" class="text-blue-600 hidden">Updated from Visual Editor.</span></p>
                <textarea name="data_json" id="question_data" class="w-full border p-2 rounded h-80 font-mono text-xs"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeQuestionModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
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
