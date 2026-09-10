<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $packageData['title'] }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 h-screen overflow-hidden">
    <style>
        .toefl-passage-shell {
            --toefl-passage-font-size: 15px;
            --toefl-passage-leading: 1.65;
            --toefl-line-step: calc(var(--toefl-passage-font-size) * var(--toefl-passage-leading));
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
        }

        .toefl-passage-frame {
            max-width: 860px;
            margin: 0 auto;
            padding: 0.25rem 0;
        }

        .toefl-passage-text {
            color: #111827;
            font-size: var(--toefl-passage-font-size);
            line-height: var(--toefl-passage-leading);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 9999px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8;
        }

        .toefl-passage-shell.with-gutter {
            display: grid;
            grid-template-columns: 2.9rem minmax(0, 1fr);
            column-gap: 0.45rem;
            align-items: stretch;
        }

        .toefl-passage-gutter {
            position: relative;
            padding-top: 0.25rem;
        }

        .toefl-gutter-marker {
            position: absolute;
            right: 0;
            text-align: right;
            font-style: italic;
            font-weight: 500;
            color: #111827;
            font-size: 13px;
            line-height: 1;
            white-space: nowrap;
            transform: translateY(-50%);
        }

        .toefl-passage-paragraph {
            margin: 0;
        }

        .toefl-passage-paragraph + .toefl-passage-paragraph {
            text-indent: 1.25em;
        }

        .toefl-line-segment {
            display: grid;
            grid-template-columns: 2.9rem minmax(0, 1fr);
            column-gap: 0.45rem;
            align-items: start;
        }

        .toefl-line-segment.is-paragraph-start .toefl-line-copy {
            text-indent: 3rem;
        }

        .toefl-line-gutter {
            display: block;
            text-align: right;
            font-style: italic;
            font-weight: 500;
            color: #111827;
            line-height: 1.65;
            white-space: nowrap;
            pointer-events: none;
        }

        .toefl-line-gutter.is-line-word {
            letter-spacing: 0.01em;
        }

        .toefl-line-copy {
            display: block;
        }

        .reading-answer-sheet .listening-option-card {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem;
            min-height: 2.5rem;
            transition: border-color 0.16s ease, background-color 0.16s ease, box-shadow 0.16s ease, transform 0.12s ease;
        }

        .reading-answer-sheet input[type="radio"]:checked + .listening-option-card {
            transform: translateY(-1px);
            border-color: #e02424;
            background-color: #fff7f7;
            box-shadow: 0 0 0 1px rgba(224, 36, 36, 0.36), 0 3px 12px rgba(224, 36, 36, 0.14);
        }

        .reading-answer-sheet .listening-option-card::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 1.25rem;
            width: 6px;
            height: 6px;
            border-radius: 9999px;
            background: rgba(220, 38, 38, 0.22);
            transform: translate(-50%, -50%) scale(0);
            pointer-events: none;
            opacity: 0;
        }

        .reading-answer-sheet input[type="radio"]:checked + .listening-option-card::after {
            animation: listeningOptionRipple 0.34s ease-out;
        }

        .reading-answer-sheet .listening-option-badge {
            width: 2rem;
            height: 2rem;
            transform-origin: center;
            will-change: transform, box-shadow;
        }

        .reading-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge {
            border-color: #dc2626;
            background-color: #dc2626;
            color: #ffffff;
            animation: listeningBadgePop 0.18s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .reading-answer-sheet input[type="radio"]:checked + .listening-option-card .listening-option-badge span {
            color: #ffffff;
        }

        .reading-answer-sheet input[type="radio"]:checked + .listening-option-card .reading-option-text {
            color: #b91c1c;
            font-weight: 700;
            letter-spacing: 0.005em;
        }

        .reading-answer-sheet .reading-correct {
            border-color: #16a34a;
            background-color: #f0fdf4;
            box-shadow: 0 0 0 1px rgba(22, 163, 74, 0.22), 0 3px 12px rgba(22, 163, 74, 0.08);
        }

        .reading-answer-sheet .reading-correct .listening-option-badge {
            border-color: #16a34a;
            background-color: #16a34a;
        }

        .reading-answer-sheet .reading-correct .listening-option-badge span {
            color: #ffffff;
        }

        .reading-answer-sheet .reading-correct .reading-option-text {
            color: #166534;
            font-weight: 700;
        }

        .reading-answer-sheet .reading-wrong {
            border-color: #e11d48;
            background-color: #fff1f2;
            box-shadow: 0 0 0 1px rgba(225, 29, 72, 0.18);
        }

        .reading-answer-sheet .reading-wrong .listening-option-badge {
            border-color: #e11d48;
            background-color: #ffffff;
        }

        .reading-answer-sheet .reading-wrong .listening-option-badge span,
        .reading-answer-sheet .reading-wrong .reading-option-text {
            color: #be123c;
            font-weight: 700;
        }

        .reading-answer-sheet .reading-muted {
            opacity: 0.82;
        }

        .question-section-card {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .question-item-card {
            border: 1px solid rgba(203, 213, 225, 0.9);
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }

        .question-number-badge {
            width: 2rem;
            height: 2rem;
            border-radius: 0.6rem;
            background: #eef2ff;
            color: #3730a3;
            font-size: 0.75rem;
            font-weight: 800;
            border: 1px solid #c7d2fe;
        }

        .translate-word {
            cursor: pointer;
            border-bottom: 1px dashed #94a3b8;
            border-radius: 0.2rem;
            padding: 0 0.08rem;
            transition: background-color 0.12s ease, color 0.12s ease;
        }

        .translate-word:hover {
            background: #fef3c7;
            color: #92400e;
        }

        mark.vocab-highlight {
            background: #a5f3fc;
            color: #0f172a;
            border-radius: 0.28rem;
            padding: 0 0.15rem;
            box-shadow: 0 0 0 2px rgba(34, 211, 238, 0.28);
        }

        #passageHighlightToast {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            z-index: 80;
            max-width: 22rem;
            padding: 0.6rem 0.8rem;
            border-radius: 0.65rem;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.18);
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.18s ease, transform 0.18s ease;
            pointer-events: none;
        }

        #passageHighlightToast.show {
            opacity: 1;
            transform: translateY(0);
        }

        #passageHighlightToast.info {
            background: #e0f2fe;
            color: #0c4a6e;
            border: 1px solid #7dd3fc;
        }

        #passageHighlightToast.warn {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
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
                opacity: 0.32;
            }
            100% {
                transform: translate(-50%, -50%) scale(42);
                opacity: 0;
            }
        }

        .toefl-practice-shell {
            height: 100vh;
            overflow: hidden;
        }

        .toefl-practice-shell main {
            height: 100%;
            min-height: 0;
            overflow: hidden;
        }

        .toefl-practice-panels {
            min-height: 0;
            flex: 1 1 0%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .toefl-passages-panel,
        .toefl-questions-panel {
            min-height: 0;
            flex: 1 1 0%;
        }

        @media (min-width: 768px) {
            .toefl-practice-panels {
                flex-direction: row;
            }

            .toefl-passages-panel {
                flex: 1.12 1 0%;
                border-right: 1px solid #e2e8f0;
            }

            .toefl-questions-panel {
                flex: 1 1 0%;
            }
        }

        @media (max-width: 768px) {
            .toefl-passage-shell.with-gutter {
                grid-template-columns: 2.2rem minmax(0, 1fr);
                column-gap: 0.3rem;
            }

            .toefl-gutter-marker {
                font-size: 12px;
            }

            .toefl-passage-paragraph + .toefl-passage-paragraph {
                text-indent: 1.1em;
            }

            .toefl-line-segment {
                grid-template-columns: 2.2rem minmax(0, 1fr);
                column-gap: 0.3rem;
            }

            .toefl-line-segment.is-paragraph-start .toefl-line-copy {
                text-indent: 1.75rem;
            }

            .toefl-line-gutter {
                font-size: 13px;
            }

            .reading-answer-sheet .listening-option-card {
                min-height: 3rem;
                padding: 0.5rem 0.7rem;
            }

            .reading-answer-sheet .listening-option-badge {
                width: 1.8rem;
                height: 1.8rem;
            }
        }
    </style>
    @include('components.impersonation-banner')
        <div class="toefl-practice-shell">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

            <main class="p-0 h-full overflow-hidden md:ml-64" x-data="readingPracticePage({{ json_encode((object)$answerKey) }}, {{ $packageData['questions_count'] }})">
            <div class="flex h-full min-h-0 flex-col bg-white">
                <header class="shrink-0 border-b border-slate-200 bg-white/95 backdrop-blur">
                    <div class="px-3 py-3 md:px-4 md:py-3.5">
                        <div class="flex flex-col gap-2.5 xl:flex-row xl:items-center xl:justify-between">
                            <div class="flex items-start gap-3 md:gap-4">
                                <a href="{{ route('assignments.toefl-itp.reading.practice') }}" class="mt-1 inline-flex items-center justify-center rounded-lg bg-white p-2 text-slate-700 transition hover:bg-slate-200">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </a>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-600">TOEFL Reading Practice</p>
                                    <h1 class="mt-0.5 text-2xl font-bold text-slate-900 md:text-[1.75rem]">{{ $packageData['title'] }}</h1>
                                    <p class="mt-0.5 text-xs text-slate-600 md:text-sm">{{ $packageData['description'] }}</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 md:gap-3">
                                <div class="rounded-xl bg-white px-3 py-2 text-xs font-bold text-indigo-700">Answered: <span x-text="answeredCount()"></span>/{{ $packageData['questions_count'] }}</div>
                                <div class="rounded-xl bg-white px-3 py-2 text-xs font-bold text-amber-700">Remaining: <span x-text="remainingCount()"></span></div>
                                <div class="rounded-xl bg-white px-3 py-2 text-xs font-bold text-emerald-700">Score: <span x-text="submitted ? score() : '-' "></span></div>
                                <button type="button" @click="resetPractice()" class="rounded-xl bg-white px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-slate-200 transition hover:bg-white">Reset</button>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="toefl-practice-panels">
                    <section id="passages-panel" class="toefl-passages-panel custom-scrollbar overflow-y-auto border-b border-slate-200 bg-white md:border-b-0">
                        <div class="space-y-3 p-3 pb-16 md:p-4">
                            @foreach($packageData['passages'] as $index => $passage)
                                <article class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 md:p-5"
                                         id="passage-{{ $index }}"
                                         data-passage-index="{{ $index }}"
                                         x-data="{
                                            translateMode: false,
                                            highlightMode: false,
                                            pencilMode: false,
                                            eraserMode: false,
                                            highlightColor: 'yellow',
                                            canvasObj: null
                                         }"
                                         x-init="
                                            $watch('pencilMode', value => {
                                                if (value && !canvasObj) {
                                                    canvasObj = window.initDrawingCanvas($refs.drawingCanvas);
                                                }
                                                if (value && canvasObj) {
                                                    canvasObj.setMode('draw');
                                                }
                                            });
                                            $watch('eraserMode', value => {
                                                if (value && !canvasObj) {
                                                    canvasObj = window.initDrawingCanvas($refs.drawingCanvas);
                                                }
                                                if (value && canvasObj) {
                                                    canvasObj.setMode('erase');
                                                }
                                            });
                                            $nextTick(() => {
                                                if ($refs.contentStage) {
                                                    new ResizeObserver(() => {
                                                        if (canvasObj) {
                                                            canvasObj.resize();
                                                        }
                                                    }).observe($refs.contentStage);
                                                }
                                            });
                                         ">
                                    <div class="mb-3 flex items-center justify-between border-b border-slate-100 pb-3">
                                        <h2 class="text-lg font-bold text-slate-900">{{ $passage['section_title'] }}</h2>
                                        <div class="flex items-center gap-2">
                                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-indigo-700">Passage {{ $index + 1 }}</span>
                                        </div>
                                    </div>
                                    <div class="toefl-passage-shell with-gutter rounded-2xl px-4 py-4 md:px-6 md:py-5">
                                        <!-- Gutter Column -->
                                        <div class="toefl-passage-gutter" aria-hidden="true">
                                            @if(isset($passage['line_markers']))
                                                @foreach($passage['line_markers'] as $marker)
                                                    @php
                                                        $defaultLine = $loop->index === 0 ? 1 : $loop->index * 5;
                                                        $markerLabel = is_array($marker) ? ($marker['label'] ?? '') : $marker;
                                                        $lineNumber = is_array($marker) ? (int) ($marker['line'] ?? $defaultLine) : $defaultLine;
                                                        $lineCenter = $lineNumber - 0.5;
                                                    @endphp
                                                    <div class="toefl-gutter-marker" style="top: calc({{ $lineCenter }} * var(--toefl-line-step));">{{ $markerLabel }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <!-- Content Column -->
                                        <div class="toefl-passage-frame relative" x-ref="contentStage">
                                            <canvas x-ref="drawingCanvas"
                                                    class="absolute inset-0 h-full w-full z-10"
                                                    :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'"></canvas>

                                            <div class="passage-content relative z-0"
                                                 x-ref="content"
                                                 @mouseup="if (highlightMode) window.applyAnnotation('highlight', highlightColor)">
                                                {!! $passage['content'] !!}
                                            </div>

                                            <div class="sticky bottom-4 z-20 mt-5 flex w-full flex-col items-center pointer-events-none">
                                                <div x-show="highlightMode"
                                                     class="mb-2 flex gap-2 rounded-full border border-slate-200 bg-white/95 p-2 shadow-lg pointer-events-auto"
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 translate-y-2"
                                                     x-transition:enter-end="opacity-100 translate-y-0"
                                                     style="display: none;">
                                                    <button @click.prevent.stop="highlightColor = 'yellow'" class="h-7 w-7 rounded-full bg-yellow-300 transition-all" :class="highlightColor === 'yellow' ? 'ring-2 ring-yellow-500 ring-offset-2 scale-110' : ''"></button>
                                                    <button @click.prevent.stop="highlightColor = 'green'" class="h-7 w-7 rounded-full bg-green-300 transition-all" :class="highlightColor === 'green' ? 'ring-2 ring-green-500 ring-offset-2 scale-110' : ''"></button>
                                                    <button @click.prevent.stop="highlightColor = 'blue'" class="h-7 w-7 rounded-full bg-blue-300 transition-all" :class="highlightColor === 'blue' ? 'ring-2 ring-blue-500 ring-offset-2 scale-110' : ''"></button>
                                                    <button @click.prevent.stop="highlightColor = 'pink'" class="h-7 w-7 rounded-full bg-pink-300 transition-all" :class="highlightColor === 'pink' ? 'ring-2 ring-pink-500 ring-offset-2 scale-110' : ''"></button>
                                                </div>

                                                <div class="pointer-events-auto flex items-center gap-3 rounded-full border border-slate-200/70 bg-white/80 p-2 shadow-[0_8px_30px_rgb(0,0,0,0.12)] backdrop-blur">
                                                    <button
                                                        type="button"
                                                        @click="
                                                            const wasActive = translateMode;
                                                            translateMode = !wasActive;
                                                            highlightMode = false;
                                                            pencilMode = false;
                                                            eraserMode = false;
                                                            togglePassageTranslate($refs.content, !wasActive);
                                                        "
                                                        class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition-all hover:border-amber-400 hover:text-amber-600"
                                                        :class="translateMode ? '!border-amber-500 !bg-amber-400 !text-white shadow-md' : ''"
                                                        title="Translate Tool">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        @click="
                                                            highlightMode = !highlightMode;
                                                            pencilMode = false;
                                                            eraserMode = false;
                                                            if (translateMode) {
                                                                translateMode = false;
                                                                togglePassageTranslate($refs.content, false);
                                                            }
                                                        "
                                                        class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition-all hover:border-green-400 hover:text-green-600"
                                                        :class="highlightMode ? '!border-green-600 !bg-green-500 !text-white shadow-md' : ''"
                                                        title="Highlight Tool">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        @click="
                                                            pencilMode = !pencilMode;
                                                            highlightMode = false;
                                                            eraserMode = false;
                                                            if (translateMode) {
                                                                translateMode = false;
                                                                togglePassageTranslate($refs.content, false);
                                                            }
                                                        "
                                                        class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition-all hover:border-blue-400 hover:text-blue-600"
                                                        :class="pencilMode ? '!border-blue-600 !bg-blue-500 !text-white shadow-md' : ''"
                                                        title="Notes Tool">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        @click="
                                                            eraserMode = !eraserMode;
                                                            pencilMode = false;
                                                            highlightMode = false;
                                                            if (translateMode) {
                                                                translateMode = false;
                                                                togglePassageTranslate($refs.content, false);
                                                            }
                                                        "
                                                        class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition-all hover:border-indigo-400 hover:text-indigo-600"
                                                        :class="eraserMode ? '!border-indigo-600 !bg-indigo-500 !text-white shadow-md' : ''"
                                                        title="Eraser Tool">
                                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"></path><path d="M22 21H7"></path><path d="m5 11 9 9"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section id="questions-panel" class="toefl-questions-panel custom-scrollbar overflow-y-auto bg-white">
                        <div class="space-y-3 p-3 pb-16 md:p-4">
                            <div :class="submitted ? 'hidden' : 'space-y-3'">
                                    @foreach($packageData['passages'] as $pIndex => $passage)
                                        <article class="question-section-card p-3 md:p-4" data-passage-index="{{ $pIndex }}">
                                            <div class="mb-3 flex items-center justify-between">
                                                <h3 class="text-lg font-bold text-slate-900">{{ $passage['section_title'] }}</h3>
                                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-indigo-700">{{ count($passage['questions']) }} questions</span>
                                            </div>

                                            <div class="space-y-3">
                                                @foreach($passage['questions'] as $question)
                                                    <article id="question-{{ $question['number'] }}" class="question-item-card p-4">
                                                        <div class="flex items-start gap-2.5">
                                                            <div class="question-number-badge flex shrink-0 items-center justify-center">{{ $question['number'] }}</div>
                                                            <div class="min-w-0 flex-1">
                                                                <p class="text-[15px] font-semibold leading-7 text-slate-900">{{ $question['text'] }}</p>

                                                                <div class="reading-answer-sheet mt-1.5 grid grid-cols-1 gap-1">
                                                                    @foreach($question['options'] as $letter => $optionText)
                                                                        <label class="group/option relative block w-full cursor-pointer" @click.stop>
                                                                            <input type="radio"
                                                                                   class="peer absolute inset-0 w-full h-full opacity-0 cursor-pointer m-0 p-0"
                                                                                   name="question_{{ $question['number'] }}"
                                                                                   value="{{ $letter }}"
                                                                                   :checked="answers['{{ $question['number'] }}'] === '{{ $letter }}'"
                                                                                   @change="setAnswer('{{ $question['number'] }}', '{{ $letter }}')">
                                                                             <div class="listening-option-card flex items-center border border-slate-200/90 bg-white px-3 py-2 transition-all duration-200 hover:border-red-300 hover:bg-red-50"
                                                                                 :class="optionClass('{{ $question['number'] }}', '{{ $letter }}')">
                                                                                <div class="mr-2 flex flex-none items-center justify-center">
                                                                                    <div class="listening-option-badge flex aspect-square shrink-0 items-center justify-center rounded-full border-2 border-slate-300 bg-white transition-all duration-200 group-hover/option:border-red-400">
                                                                                        <span class="text-xs font-bold text-slate-600 transition-colors duration-200">{{ $letter }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <span class="reading-option-text text-sm leading-6 text-slate-700 transition-colors duration-200 group-hover/option:text-red-700">{{ $optionText }}</span>
                                                                            </div>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                @endforeach
                                            </div>
                                        </article>
                                    @endforeach

                                    <div class="pt-1">
                                        <button
                                            type="button"
                                            @click="submitPractice()"
                                            class="w-full rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-indigo-700"
                                        >
                                            Submit
                                        </button>
                                    </div>
                            </div>

                            <div :class="submitted ? 'space-y-3' : 'hidden'">
                                    <div class="sticky top-0 z-20 rounded-xl border border-emerald-100 bg-white px-4 py-3 shadow-sm">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="text-sm font-bold text-emerald-800">Result: <span x-text="score()"></span>/{{ $packageData['questions_count'] }}</p>
                                            <p class="text-sm font-semibold text-emerald-700"><span x-text="percentage()"></span>%</p>
                                        </div>
                                        <p class="mt-1 text-xs text-emerald-700">Sudah submit. Berikut penilaian dan penjelasan untuk setiap jawaban.</p>
                                    </div>

                                    @foreach($packageData['passages'] as $pIndex => $passage)
                                        <article class="question-section-card p-3 md:p-4" data-passage-index="{{ $pIndex }}">
                                            <div class="mb-3 flex items-center justify-between">
                                                <h3 class="text-lg font-bold text-slate-900">{{ $passage['section_title'] }}</h3>
                                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-indigo-700">Review</span>
                                            </div>

                                            <div class="space-y-3">
                                                @foreach($passage['questions'] as $question)
                                                    @php
                                                        $correctOptionText = $question['options'][$question['answer']] ?? '';
                                                        $defaultExplanation = 'Jawaban benar adalah ' . $question['answer'] . '. Pilihan ini paling sesuai dengan isi pertanyaan' . ($correctOptionText ? ': ' . $correctOptionText . '.' : '.');
                                                        $explanationText = $question['explanation'] ?? $defaultExplanation;
                                                        $distractorExplanations = $question['distractor_explanations'] ?? [];
                                                    @endphp
                                                    <article class="question-item-card p-4">
                                                        <div class="flex items-start gap-2.5">
                                                            <div class="question-number-badge flex shrink-0 items-center justify-center">{{ $question['number'] }}</div>
                                                            <div class="min-w-0 flex-1">
                                                                <p class="text-[15px] font-semibold leading-7 text-slate-900">{{ $question['text'] }}</p>

                                                                <div class="mt-2 grid gap-2 text-xs md:grid-cols-2">
                                                                    <div class="rounded-lg border border-slate-200 bg-white px-3 py-2">
                                                                        <p class="font-semibold text-slate-700">Jawaban Anda</p>
                                                                        <p class="mt-0.5 text-slate-900" x-text="answers['{{ $question['number'] }}'] ? answers['{{ $question['number'] }}'] : '-' "></p>
                                                                    </div>
                                                                    <div class="rounded-lg border border-emerald-200 bg-white px-3 py-2">
                                                                        <p class="font-semibold text-emerald-700">Jawaban Benar</p>
                                                                        <p class="mt-0.5 text-emerald-900">{{ $question['answer'] }}. {{ $correctOptionText }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="mt-2 rounded-lg px-3 py-2 text-xs font-semibold"
                                                                     :class="answers['{{ $question['number'] }}'] === '{{ $question['answer'] }}' ? 'bg-white text-emerald-800' : 'bg-rose-50 text-rose-800'">
                                                                    <span x-show="answers['{{ $question['number'] }}'] === '{{ $question['answer'] }}'">Benar</span>
                                                                    <span x-show="answers['{{ $question['number'] }}'] !== '{{ $question['answer'] }}'">Perlu diperbaiki</span>
                                                                </div>

                                                                <div class="mt-2 rounded-lg border border-indigo-100 bg-white px-3 py-2">
                                                                    <p class="text-[11px] font-bold uppercase tracking-wide text-indigo-700">Penjelasan</p>
                                                                    <p class="mt-1 text-[11px] font-bold uppercase tracking-wide text-indigo-700/90">Alasan Jawaban Benar</p>
                                                                    <p class="mt-0.5 text-xs leading-5 text-indigo-900">{{ $explanationText }}</p>

                                                                    <p class="mt-2 text-[11px] font-bold uppercase tracking-wide text-indigo-700/90">Kenapa Opsi Lain Kurang Tepat</p>
                                                                    <div class="mt-1 space-y-1">
                                                                        @foreach($distractorExplanations as $letter => $reason)
                                                                            <p class="text-xs leading-5 text-indigo-900/90">{{ $letter }}. {{ $question['options'][$letter] ?? '' }}: {{ $reason }}</p>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                @endforeach
                                            </div>
                                        </article>
                                    @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <div id="definitionPopup" class="fixed hidden w-72 rounded-xl border border-slate-200 bg-white p-4 shadow-xl z-[70]">
        <div class="mb-2 flex items-start justify-between">
            <div>
                <h4 id="def_word" class="text-lg font-bold text-slate-900 capitalize"></h4>
                <p id="def_translation" class="mt-0.5 text-sm font-medium text-indigo-600"></p>
            </div>
            <button type="button" id="def_close" class="text-slate-400 transition hover:text-slate-600" aria-label="Close definition popup">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div>
            <p class="mb-1 text-[10px] font-semibold uppercase tracking-wider text-slate-400">TOEFL Synonyms</p>
            <p id="def_synonyms" class="text-sm text-slate-700"></p>
        </div>
    </div>

    <div id="passageHighlightToast" class="hidden"></div>

    <script>
        let passageHighlightToastTimer = null;

        function showPassageHighlightToast(message, variant = 'info') {
            const toast = document.getElementById('passageHighlightToast');
            if (!toast) {
                return;
            }

            toast.className = 'show ' + (variant === 'warn' ? 'warn' : 'info');
            toast.textContent = message;
            toast.classList.remove('hidden');

            if (passageHighlightToastTimer) {
                clearTimeout(passageHighlightToastTimer);
            }

            passageHighlightToastTimer = setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.classList.add('hidden'), 180);
            }, 1800);
        }

        function hideDefinitionPopup() {
            const popup = document.getElementById('definitionPopup');
            if (popup) {
                popup.classList.add('hidden');
            }
        }

        function wrapTranslatableWords(rootEl) {
            const walker = document.createTreeWalker(rootEl, NodeFilter.SHOW_TEXT);
            const textNodes = [];

            while (walker.nextNode()) {
                const node = walker.currentNode;
                if (!node || !node.nodeValue || !/[A-Za-z]/.test(node.nodeValue)) {
                    continue;
                }
                const parent = node.parentElement;
                if (!parent || parent.closest('.translate-word')) {
                    continue;
                }
                textNodes.push(node);
            }

            textNodes.forEach((node) => {
                const parts = node.nodeValue.split(/([A-Za-z][A-Za-z'\-]*)/g);
                if (parts.length === 1) {
                    return;
                }

                const fragment = document.createDocumentFragment();
                parts.forEach((part) => {
                    if (!part) {
                        return;
                    }

                    if (/^[A-Za-z][A-Za-z'\-]*$/.test(part)) {
                        const span = document.createElement('span');
                        span.className = 'translate-word';
                        span.textContent = part;
                        span.dataset.word = part;
                        span.addEventListener('click', (event) => lookupWord(part, event));
                        fragment.appendChild(span);
                    } else {
                        fragment.appendChild(document.createTextNode(part));
                    }
                });

                node.parentNode.replaceChild(fragment, node);
            });
        }

        function togglePassageTranslate(contentEl, active) {
            if (!contentEl) {
                return;
            }

            if (!active) {
                if (contentEl.dataset.originalHtml) {
                    contentEl.innerHTML = contentEl.dataset.originalHtml;
                }
                contentEl.classList.remove('cursor-help');
                hideDefinitionPopup();
                return;
            }

            if (!contentEl.dataset.originalHtml) {
                contentEl.dataset.originalHtml = contentEl.innerHTML;
            }

            contentEl.innerHTML = contentEl.dataset.originalHtml;
            contentEl.classList.add('cursor-help');
            wrapTranslatableWords(contentEl);
        }

        function extractWordFromTextNode(text, offset) {
            let start = offset;
            let end = offset;
            const wordCharRegex = /[a-zA-Z0-9'-]/;

            while (start > 0 && wordCharRegex.test(text[start - 1])) {
                start--;
            }

            while (end < text.length && wordCharRegex.test(text[end])) {
                end++;
            }

            return text.substring(start, end).replace(/^['-]+|['-]+$/g, '');
        }

        function clearVocabHighlights() {
            document.querySelectorAll('mark.vocab-highlight').forEach((mark) => {
                const parent = mark.parentNode;
                while (mark.firstChild) {
                    parent.insertBefore(mark.firstChild, mark);
                }
                parent.removeChild(mark);
                parent.normalize();
            });
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function extractQuotedQuestionWord(text) {
            if (!text) {
                return '';
            }

            const quotedMatch = text.match(/"([^"]{2,})"/);
            if (!quotedMatch) {
                return '';
            }

            return quotedMatch[1].trim().replace(/^['-]+|['-]+$/g, '');
        }

        function resolveQuestionHighlightWord(target, event) {
            let clickedWord = '';

            if (document.caretPositionFromPoint) {
                const range = document.caretPositionFromPoint(event.clientX, event.clientY);
                if (range && range.offsetNode && range.offsetNode.nodeType === Node.TEXT_NODE) {
                    clickedWord = extractWordFromTextNode(range.offsetNode.textContent, range.offset);
                }
            } else if (document.caretRangeFromPoint) {
                const range = document.caretRangeFromPoint(event.clientX, event.clientY);
                if (range && range.startContainer && range.startContainer.nodeType === Node.TEXT_NODE) {
                    clickedWord = extractWordFromTextNode(range.startContainer.textContent, range.startOffset);
                }
            }

            if (clickedWord && clickedWord.trim().length > 2) {
                return clickedWord.trim();
            }

            const questionPrompt = target.closest('.question-item-card')?.querySelector('p');
            if (!questionPrompt) {
                return '';
            }

            return extractQuotedQuestionWord(questionPrompt.textContent || '');
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

            const searchRegex = new RegExp(`\\b${escapeRegExp(word)}\\b`, 'gi');
            let firstHighlight = null;

            passages.forEach((passage) => {
                const treeWalker = document.createTreeWalker(
                    passage,
                    NodeFilter.SHOW_TEXT,
                    {
                        acceptNode(node) {
                            const parentTag = node.parentNode && node.parentNode.tagName;
                            if (parentTag === 'MARK' || parentTag === 'SCRIPT' || parentTag === 'STYLE') {
                                return NodeFilter.FILTER_REJECT;
                            }
                            searchRegex.lastIndex = 0;
                            return searchRegex.test(node.textContent) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
                        },
                    },
                    false
                );

                const nodesToReplace = [];
                let currentNode;
                while ((currentNode = treeWalker.nextNode())) {
                    nodesToReplace.push(currentNode);
                }

                nodesToReplace.forEach((node) => {
                    const textContent = node.textContent;
                    const fragment = document.createDocumentFragment();
                    let lastIndex = 0;
                    searchRegex.lastIndex = 0;
                    let match;

                    while ((match = searchRegex.exec(textContent)) !== null) {
                        if (match.index > lastIndex) {
                            fragment.appendChild(document.createTextNode(textContent.substring(lastIndex, match.index)));
                        }

                        const mark = document.createElement('mark');
                        mark.className = 'vocab-highlight';
                        mark.textContent = match[0];
                        fragment.appendChild(mark);

                        if (!firstHighlight) {
                            firstHighlight = mark;
                        }

                        lastIndex = match.index + match[0].length;
                    }

                    if (lastIndex < textContent.length) {
                        fragment.appendChild(document.createTextNode(textContent.substring(lastIndex)));
                    }

                    node.parentNode.replaceChild(fragment, node);
                });
            });

            if (firstHighlight) {
                firstHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return true;
            }

            return false;
        }

        if (!window.applyAnnotation) {
            window.applyAnnotation = function(type, color = 'yellow') {
                const selection = window.getSelection();
                if (!selection.rangeCount || selection.isCollapsed) {
                    return;
                }

                const range = selection.getRangeAt(0);
                const span = document.createElement('span');

                if (type === 'highlight') {
                    const colors = {
                        yellow: 'bg-yellow-200 hover:bg-yellow-300',
                        green: 'bg-green-200 hover:bg-green-300',
                        blue: 'bg-blue-200 hover:bg-blue-300',
                        pink: 'bg-pink-200 hover:bg-pink-300',
                    };

                    span.className = `${colors[color] || colors.yellow} rounded px-1 pb-0.5 cursor-pointer transition-colors border shadow-sm border-transparent`;
                    span.title = 'Click to remove highlight';
                }

                span.onclick = function(ev) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    const parent = this.parentNode;
                    while (this.firstChild) {
                        parent.insertBefore(this.firstChild, this);
                    }
                    parent.removeChild(this);
                    parent.normalize();
                };

                try {
                    range.surroundContents(span);
                } catch (error) {
                    console.warn('Highlight boundary not supported for this selection.', error);
                }

                selection.removeAllRanges();
            };
        }

        if (!window.removeHighlightElement) {
            window.removeHighlightElement = function(element) {
                if (!element) {
                    return false;
                }

                const parent = element.parentNode;
                if (!parent) {
                    return false;
                }

                while (element.firstChild) {
                    parent.insertBefore(element.firstChild, element);
                }
                parent.removeChild(element);
                parent.normalize();
                return true;
            };
        }

        if (!window.initDrawingCanvas) {
            window.initDrawingCanvas = function(canvas) {
                const ctx = canvas.getContext('2d');
                let isDrawing = false;
                let currentMode = 'draw';

                function removeHighlightAtPointer(evt) {
                    if (currentMode !== 'erase') {
                        return;
                    }

                    let clientX = evt.clientX;
                    let clientY = evt.clientY;

                    if ((clientX == null || clientY == null) && evt.touches && evt.touches.length > 0) {
                        clientX = evt.touches[0].clientX;
                        clientY = evt.touches[0].clientY;
                    }

                    if (clientX == null || clientY == null) {
                        return;
                    }

                    const previousPointerEvents = canvas.style.pointerEvents;
                    canvas.style.pointerEvents = 'none';
                    const stackedElements = document.elementsFromPoint(clientX, clientY);
                    canvas.style.pointerEvents = previousPointerEvents;

                    const removable = stackedElements.find((el) => {
                        if (!el || !el.tagName) {
                            return false;
                        }
                        if (el.tagName === 'MARK') {
                            return true;
                        }
                        if (el.tagName === 'SPAN' && el.title === 'Click to remove highlight') {
                            return true;
                        }
                        return false;
                    });

                    if (removable) {
                        window.removeHighlightElement(removable);
                    }
                }

                function resize() {
                    const parent = canvas.parentElement;
                    if (!parent) {
                        return;
                    }

                    const rect = parent.getBoundingClientRect();
                    const temp = document.createElement('canvas');
                    temp.width = canvas.width;
                    temp.height = canvas.height;
                    temp.getContext('2d').drawImage(canvas, 0, 0);

                    canvas.width = rect.width;
                    canvas.height = rect.height;
                    ctx.drawImage(temp, 0, 0);
                    setMode(currentMode);
                }

                function setMode(mode) {
                    currentMode = mode;
                    ctx.lineJoin = 'round';
                    ctx.lineCap = 'round';

                    if (mode === 'erase') {
                        ctx.globalCompositeOperation = 'destination-out';
                        ctx.lineWidth = 18;
                    } else {
                        ctx.globalCompositeOperation = 'source-over';
                        ctx.lineWidth = 3;
                        ctx.strokeStyle = '#ef4444';
                    }
                }

                function getPos(evt) {
                    const rect = canvas.getBoundingClientRect();
                    let x = evt.clientX;
                    let y = evt.clientY;
                    if (evt.touches && evt.touches.length > 0) {
                        x = evt.touches[0].clientX;
                        y = evt.touches[0].clientY;
                    }
                    return { x: x - rect.left, y: y - rect.top };
                }

                function start(e) {
                    e.preventDefault();
                    isDrawing = true;
                    const pos = getPos(e);
                    ctx.beginPath();
                    ctx.moveTo(pos.x, pos.y);
                    removeHighlightAtPointer(e);
                }

                function draw(e) {
                    if (!isDrawing) {
                        return;
                    }
                    e.preventDefault();
                    removeHighlightAtPointer(e);
                    const pos = getPos(e);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                }

                function end() {
                    if (!isDrawing) {
                        return;
                    }
                    ctx.stroke();
                    ctx.closePath();
                    isDrawing = false;
                }

                canvas.addEventListener('mousedown', start, { passive: false });
                canvas.addEventListener('mousemove', draw, { passive: false });
                canvas.addEventListener('mouseup', end);
                canvas.addEventListener('mouseleave', end);
                canvas.addEventListener('touchstart', start, { passive: false });
                canvas.addEventListener('touchmove', draw, { passive: false });
                canvas.addEventListener('touchend', end);
                canvas.addEventListener('touchcancel', end);

                resize();
                setMode('draw');

                return { setMode, resize };
            };
        }

        async function lookupWord(word, event) {
            event.stopPropagation();

            const popup = document.getElementById('definitionPopup');
            const cleanWord = (word || '').replace(/[^A-Za-z0-9'\-]/g, '').toLowerCase();
            if (!cleanWord) {
                return;
            }

            const x = Math.min(event.clientX + 12, window.innerWidth - 304);
            const y = Math.min(event.clientY + 14, window.innerHeight - 170);
            popup.style.left = `${x}px`;
            popup.style.top = `${y}px`;

            document.getElementById('def_word').innerText = cleanWord;
            document.getElementById('def_translation').innerText = 'Memuat...';
            document.getElementById('def_synonyms').innerText = '...';
            popup.classList.remove('hidden');

            try {
                const response = await fetch(`{{ route('api.dictionary.lookup') }}?word=${encodeURIComponent(cleanWord)}`);
                const data = await response.json();

                if (data.found) {
                    document.getElementById('def_word').innerText = data.word;
                    document.getElementById('def_translation').innerText = data.translation || '-';

                    if (data.synonyms && data.synonyms !== '-') {
                        document.getElementById('def_synonyms').innerText = data.synonyms;
                    } else {
                        const synRes = await fetch(`{{ route('api.dictionary.synonyms') }}?word=${encodeURIComponent(cleanWord)}`);
                        const synData = await synRes.json();
                        document.getElementById('def_synonyms').innerText = synData.synonyms || '-';
                    }
                } else {
                    document.getElementById('def_translation').innerText = 'Tidak ditemukan';
                    document.getElementById('def_synonyms').innerText = '-';
                }
            } catch (error) {
                console.error('Dictionary error:', error);
                document.getElementById('def_translation').innerText = 'Error';
                document.getElementById('def_synonyms').innerText = '-';
            }
        }

        document.addEventListener('click', (event) => {
            const target = event.target instanceof Element ? event.target : event.target?.parentElement;
            const popup = document.getElementById('definitionPopup');
            if (!popup || popup.classList.contains('hidden')) {
                return;
            }

            if (!target) {
                hideDefinitionPopup();
                return;
            }

            if (!popup.contains(target) && !target.closest('.translate-word')) {
                hideDefinitionPopup();
            }
        });

        document.addEventListener('click', (event) => {
            const target = event.target instanceof Element ? event.target : event.target?.parentElement;
            if (!target) {
                return;
            }

            const inQuestionsPanel = target.closest('#questions-panel');
            if (!inQuestionsPanel) {
                return;
            }

            // Ignore answer option interactions completely.
            // This avoids accidental word-highlighting logic while choosing answers.
            if (
                target.closest('.reading-answer-sheet') ||
                target.closest('.question-item-card label') ||
                target.closest('.listening-option-card')
            ) {
                return;
            }

            if (
                target.tagName === 'BUTTON' ||
                target.tagName === 'INPUT' ||
                target.tagName === 'SELECT' ||
                target.closest('button')
            ) {
                return;
            }

            try {
                const questionCard = target.closest('[data-passage-index]');
                const passageIndex = questionCard ? questionCard.getAttribute('data-passage-index') : null;

                const clickedWord = resolveQuestionHighlightWord(target, event);

                if (clickedWord && clickedWord.trim().length > 2) {
                    const normalizedWord = clickedWord.trim();
                    const foundInCurrent = highlightInPassage(normalizedWord, passageIndex);

                    if (!foundInCurrent && passageIndex !== null) {
                        const foundAnywhere = highlightInPassage(normalizedWord, null);
                        if (foundAnywhere) {
                            showPassageHighlightToast('Kata tidak ditemukan di passage ini. Ditampilkan dari passage lain.', 'info');
                        } else {
                            showPassageHighlightToast('Kata tidak ditemukan di semua passage.', 'warn');
                        }
                    } else if (!foundInCurrent) {
                        showPassageHighlightToast('Kata tidak ditemukan di semua passage.', 'warn');
                    }
                } else {
                    clearVocabHighlights();
                }
            } catch (error) {
                console.warn('Question panel click handler error:', error);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                hideDefinitionPopup();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const closeBtn = document.getElementById('def_close');
            if (closeBtn) {
                closeBtn.addEventListener('click', hideDefinitionPopup);
            }

            const passagePanel = document.getElementById('passages-panel');
            const questionPanel = document.getElementById('questions-panel');

            if (passagePanel) {
                passagePanel.addEventListener('scroll', hideDefinitionPopup, { passive: true });
            }

            if (questionPanel) {
                questionPanel.addEventListener('scroll', hideDefinitionPopup, { passive: true });
            }

            window.addEventListener('resize', hideDefinitionPopup, { passive: true });
        });

        function readingPracticePage(answerKey, totalQuestions) {
            return {
                answers: {},
                submitted: false,
                answerKey,
                totalQuestions,
                answeredCount() {
                    return Object.values(this.answers).filter(Boolean).length;
                },
                remainingCount() {
                    return this.totalQuestions - this.answeredCount();
                },
                score() {
                    return Object.entries(this.answerKey).reduce((total, [questionNumber, correctAnswer]) => {
                        return total + (this.answers[questionNumber] === correctAnswer ? 1 : 0);
                    }, 0);
                },
                setAnswer(questionNumber, optionLetter) {
                    this.answers[questionNumber] = optionLetter;
                },
                percentage() {
                    if (this.totalQuestions === 0) {
                        return 0;
                    }

                    return Math.round((this.score() / this.totalQuestions) * 100);
                },
                optionClass(questionNumber, optionLetter) {
                    if (!this.submitted) {
                        return '';
                    }

                    if (this.answerKey[questionNumber] === optionLetter) {
                        return 'reading-correct';
                    }

                    if (this.answers[questionNumber] === optionLetter) {
                        return 'reading-wrong';
                    }

                    return 'reading-muted';
                },
                submitPractice() {
                    this.submitted = true;
                    const questionPanel = document.getElementById('questions-panel');

                    if (questionPanel) {
                        questionPanel.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
                resetPractice() {
                    this.answers = {};
                    this.submitted = false;
                    const passagePanel = document.getElementById('passages-panel');
                    const questionPanel = document.getElementById('questions-panel');
                    if (passagePanel) {
                        passagePanel.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    if (questionPanel) {
                        questionPanel.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
            };
        }
    </script>
    <x-live-drawing />
</body>
</html>