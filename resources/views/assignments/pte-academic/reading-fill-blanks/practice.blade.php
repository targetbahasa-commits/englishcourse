<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reading: Fill in the Blanks - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .teal-bar { background: #00c5b5; }
        .teal-text { color: #00c5b5; }
        
        .blank-space {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            height: 34px;
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
            border-radius: 4px;
            margin: 0 6px;
            vertical-align: middle;
            transition: all 0.2s;
        }
        
        .blank-space.drag-over {
            background-color: rgba(0, 197, 181, 0.1);
            border-color: #00c5b5;
            box-shadow: 0 0 0 2px rgba(0, 197, 181, 0.2);
        }

        .word-bank {
            min-height: 80px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .word-bank.drag-over {
            background-color: rgba(0, 197, 181, 0.05);
            border-color: #00c5b5;
        }

        .drag-word {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 16px;
            border: 1.5px solid #10b981; /* emerald-500 */
            color: #059669; /* emerald-600 */
            font-weight: 700;
            background-color: white;
            border-radius: 4px;
            cursor: move;
            user-select: none;
            transition: transform 0.1s, opacity 0.1s;
            font-size: 14px;
            height: 32px;
        }
        
        .drag-word:active {
            transform: scale(0.95);
        }

        .drag-word.dragging {
            opacity: 0.5;
        }

        /* Results styling */
        .blank-space.correct {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.1);
        }
        .blank-space.incorrect {
            border-color: #ef4444;
            background-color: rgba(239, 68, 68, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::check())
            @php
                $sidebarRole = strtolower(Auth::user()->active_role ?? 'student');
            @endphp
            @if($sidebarRole === 'admin')
                @include('components.sidebar-admin')
            @elseif($sidebarRole === 'teacher')
                @include('components.sidebar-teacher')
            @elseif(in_array($sidebarRole, ['guest', 'guest_quick']))
                @include('components.sidebar-guest')
            @else
                @include('components.sidebar-student')
            @endif
        @else
            @include('components.sidebar-guest')
        @endif

        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <div class="container mx-auto">

                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-end mb-2">
                        <a href="{{ route('assignments.pte-academic.reading.reading-fill-blanks.index') }}#topic-{{ $topicId }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Back</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Reading: Fill in the Blanks</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="max-w-6xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col">

                        <!-- Teal Title Bar -->
                        <div class="teal-bar text-white font-bold text-base py-3 px-8 rounded-t-xl mx-8 mt-8 flex justify-between items-center">
                            <span>Sample Question {{ $topicId }}:</span>
                        </div>

                        <!-- Timer Row -->
                        <div class="px-8 pt-4 pb-2">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-800">Time</span>
                                <span id="timerDisplay" class="font-bold teal-text">00:00</span>
                                <span class="text-gray-600 font-medium">sec</span>
                            </div>
                        </div>

                        <!-- Reading Passage Box -->
                        <div class="px-8 pb-4 pt-2">
                            <div class="border border-teal-200 rounded-xl p-8 bg-white" style="border-color: #00c5b5;">
                                <div class="text-gray-800 text-base leading-[2.5] font-medium" id="readingPassage">
                                    {!! $topic['passage'] !!}
                                </div>
                            </div>
                        </div>

                        <!-- Word Bank Box -->
                        <div class="px-8 pb-8">
                            <div class="word-bank dropzone" id="wordBank">
                                @foreach($topic['words'] as $wIndex => $word)
                                    <div class="drag-word" draggable="true" id="word-{{ $wIndex + 1 }}" data-word="{{ $word }}">{{ $word }}</div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="px-8 pb-8 flex items-center gap-3">
                            <button id="practiceBtn"
                                class="px-6 py-2.5 text-white font-bold rounded-full text-sm shadow-md transition-opacity"
                                style="background:#00c5b5;">
                                Practice with AI Scoring
                            </button>
                            <button onclick="restartPractice()"
                                class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-full text-sm hover:bg-white transition">
                                Restart
                            </button>
                            <button onclick="checkAnswers()" id="answerBtn"
                                class="px-6 py-2.5 bg-white font-bold rounded-full text-sm border-2 transition hover:bg-white"
                                style="color:#10b981; border-color:#10b981;">
                                Answer
                            </button>
                            <button id="startTimerBtn"
                                class="px-6 py-2.5 bg-white font-bold rounded-full text-sm border-2 transition"
                                style="color:#00c5b5; border-color:#00c5b5; display:none;">
                                Start
                            </button>
                        </div>

                        <!-- Submit Result -->
                        <div id="resultBox" class="hidden bg-white border-t border-gray-200 p-6 px-8 mx-8 mb-8 rounded-xl">
                            <div class="flex items-start gap-4">
                                <div id="resultIconBox" class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="resultIcon"></svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 text-lg" id="resultTitle">Results Checked!</h3>
                                    <p class="text-gray-600 text-sm mt-1" id="resultMessage"></p>
                                    <div class="mt-3 text-sm text-gray-700 font-medium" id="correctAnswersList"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-white">
                            <a href="{{ route('assignments.pte-academic.reading.reading-fill-blanks.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-white transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.reading.reading-fill-blanks.practice', ['id' => min(300, $topicId + 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-all hover:shadow-lg flex items-center gap-2 {{ $topicId >= 300 ? 'pointer-events-none opacity-40' : '' }}">
                                Next Question
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
            {{-- Floating Tips Button --}}
            <div x-data="{
        showTips: false,
        isPinned: false,
        
        // Floating button position & drag
        btnX: 0, btnY: 0,
        btnDragging: false, btnIsDragged: false,
        btnStartX: 0, btnStartY: 0,

        // Modal position & dimensions
        modalX: null, modalY: null,
        modalW: 920, modalH: 650,
        modalDragging: false,
        modalStartX: 0, modalStartY: 0,

        // Modal resizing
        modalResizing: false,
        resizeStartX: 0, resizeStartY: 0,
        resizeStartW: 0, resizeStartH: 0,

        init() {
            this.btnX = Math.max(12, window.innerWidth - 90);
            this.btnY = Math.max(60, window.innerHeight - 130);
            this.modalW = Math.min(920, window.innerWidth - 24);
            this.modalH = Math.min(650, window.innerHeight - 24);
        },

        openTips() {
            if (!this.btnIsDragged) {
                this.showTips = true;
                if (this.modalX === null) {
                    this.modalW = Math.min(920, window.innerWidth - 24);
                    this.modalH = Math.min(650, window.innerHeight - 24);
                    this.modalX = Math.max(8, Math.floor((window.innerWidth - this.modalW) / 2));
                    this.modalY = Math.max(8, Math.floor((window.innerHeight - this.modalH) / 2));
                }
            }
        },

        startBtnDrag(e) {
            this.btnDragging = true;
            this.btnIsDragged = false;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.btnStartX = clientX - this.btnX;
            this.btnStartY = clientY - this.btnY;
        },

        startModalDrag(e) {
            if (e.target.closest('button') || e.target.closest('a') || e.target.closest('input')) return;
            this.modalDragging = true;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.modalStartX = clientX - (this.modalX || 0);
            this.modalStartY = clientY - (this.modalY || 0);
        },

        startResize(e) {
            e.stopPropagation();
            e.preventDefault();
            this.modalResizing = true;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.resizeStartX = clientX;
            this.resizeStartY = clientY;
            this.resizeStartW = this.modalW;
            this.resizeStartH = this.modalH;
        },

        onMove(e) {
            let clientX = e.type.includes('mouse') ? e.clientX : (e.touches && e.touches[0] ? e.touches[0].clientX : 0);
            let clientY = e.type.includes('mouse') ? e.clientY : (e.touches && e.touches[0] ? e.touches[0].clientY : 0);

            if (this.btnDragging) {
                this.btnIsDragged = true;
                let nx = clientX - this.btnStartX;
                let ny = clientY - this.btnStartY;
                this.btnX = Math.max(8, Math.min(nx, window.innerWidth - 65));
                this.btnY = Math.max(8, Math.min(ny, window.innerHeight - 65));
            }

            if (this.modalDragging) {
                this.modalX = clientX - this.modalStartX;
                this.modalY = clientY - this.modalStartY;
            }

            if (this.modalResizing) {
                let dx = clientX - this.resizeStartX;
                let dy = clientY - this.resizeStartY;
                this.modalW = Math.max(320, Math.min(this.resizeStartW + dx, window.innerWidth - (this.modalX || 0) - 10));
                this.modalH = Math.max(240, Math.min(this.resizeStartH + dy, window.innerHeight - (this.modalY || 0) - 10));
            }
        },

        onEnd() {
            this.btnDragging = false;
            this.modalDragging = false;
            this.modalResizing = false;
        }
    }"
    @mousemove.window="onMove" @mouseup.window="onEnd" @touchmove.window="onMove" @touchend.window="onEnd">
                <button x-show="!showTips" @click.prevent="openTips()"
                @mousedown="startBtnDrag" @touchstart="startBtnDrag"
                class="fixed z-[9999] text-white px-3.5 py-2.5 md:p-4 rounded-full shadow-2xl flex items-center gap-1.5 md:gap-2 select-none"
                :style="`left: ${btnX}px; top: ${btnY}px; background-color: #eab308; touch-action: none;`"
                :class="btnDragging ? 'cursor-grabbing scale-105' : 'cursor-grab hover:scale-105 transition-transform'"
                title="Tips & Strategi">
            <svg class="w-5 h-5 md:w-6 md:h-6 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-bold text-xs md:text-sm text-white">Tips</span>
        </button>

                {{-- Tips Modal --}}
                <template x-teleport="body">
            <div x-show="showTips" style="display: none;" class="fixed inset-0 z-[100] pointer-events-none">
                
                {{-- Dark Backdrop (Only active when NOT pinned) --}}
                <div x-show="!isPinned" 
                     @click="showTips = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="absolute inset-0 bg-black/25 pointer-events-auto cursor-pointer">
                </div>

                <div x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="fixed bg-white rounded-2xl flex flex-col shadow-2xl border border-gray-300 pointer-events-auto overflow-hidden"
                     :style="`left: ${modalX ?? 20}px; top: ${modalY ?? 20}px; width: ${modalW}px; height: ${modalH}px; max-width: 95vw; max-height: 90vh; min-width: 320px; min-height: 240px;`">
                            {{-- Seamless Header Drag Bar (Symbol Controls Only) --}}
                    <div @mousedown="startModalDrag" @touchstart="startModalDrag"
                         class="flex items-center justify-between px-4 py-3 select-none cursor-grab active:cursor-grabbing flex-shrink-0 bg-white">
                        <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
                            <span class="w-2 h-2 rounded-full bg-amber-400 inline-block animate-pulse"></span>
                            <span class="text-[11px] font-medium text-gray-400">Tips & Strategi</span>
                        </div>

                        {{-- Control Icon Buttons (Pin & Close as symbols only) --}}
                        <div class="flex items-center gap-1.5 shrink-0">
                            {{-- Pin Icon Only --}}
                            <button type="button" @click="isPinned = !isPinned" 
                                    class="w-8 h-8 rounded-full transition flex items-center justify-center cursor-pointer text-sm"
                                    :class="isPinned ? 'bg-amber-500 text-white shadow-md ring-2 ring-amber-300' : 'bg-white hover:bg-gray-200 text-gray-600'"
                                    :title="isPinned ? 'Unpin modal' : 'Pin modal'">
                                
                            </button>

                            {{-- Close Icon Only --}}
                            <button type="button" @click="showTips = false" 
                                    class="w-8 h-8 rounded-full bg-white hover:bg-gray-200 text-gray-500 hover:text-gray-800 transition flex items-center justify-center cursor-pointer"
                                    title="Tutup">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="isPinned = !isPinned" 
                                    class="px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 text-xs font-bold cursor-pointer"
                                    :class="isPinned ? 'bg-amber-500 text-white shadow ring-2 ring-amber-300' : 'bg-white text-gray-600 hover:bg-gray-200 border border-gray-300'"
                                    :title="isPinned ? 'Unpin modal (allow click outside to close)' : 'Pin modal (keep visible while practicing)'">
                                <svg class="w-3.5 h-3.5" :class="isPinned ? 'rotate-45' : ''" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582A1 1 0 0115.5 6.82v4.36l1.382 1.382A1 1 0 0116.172 14H11v3.586l.707.707a1 1 0 01-1.414 1.414l-2-2a1 1 0 010-1.414l.707-.707V14H3.828a1 1 0 01-.707-1.707L4.5 10.918V6.82a1 1 0 01.546-.915L9 4.323V3a1 1 0 011-1z" />
                                </svg>
                                <span x-text="isPinned ? 'Pinned ' : 'Pin '">Pin </span>
                            </button>

                            <button type="button" @click="showTips = false" class="text-gray-400 hover:text-gray-700 hover:bg-gray-200 p-2 rounded-xl transition cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                            <div class="p-6 overflow-y-auto bg-white flex-1">

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-white border-b border-gray-200">
                                                    <th class="p-3 text-gray-700 font-bold border-r border-gray-200">Collocation (English)</th>
                                                    <th class="p-3 text-gray-700 font-bold border-r border-gray-200">Arti (Indonesian)</th>
                                                    <th class="p-3 text-gray-700 font-bold border-r border-gray-200">Collocation (English)</th>
                                                    <th class="p-3 text-gray-700 font-bold">Arti (Indonesian)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Row 1 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">make a decision</td>
                                                    <td class="p-3 border-r border-gray-200">membuat keputusan</td>
                                                    <td class="p-3 border-r border-gray-200">reach a conclusion</td>
                                                    <td class="p-3">mencapai kesimpulan</td>
                                                </tr>
                                                <!-- Row 2 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">draw a conclusion</td>
                                                    <td class="p-3 border-r border-gray-200">menarik kesimpulan</td>
                                                    <td class="p-3 border-r border-gray-200">play a crucial/key role</td>
                                                    <td class="p-3">memainkan peran penting/utama</td>
                                                </tr>
                                                <!-- Row 3 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">take responsibility</td>
                                                    <td class="p-3 border-r border-gray-200">mengambil tanggung jawab</td>
                                                    <td class="p-3 border-r border-gray-200">gain experience/knowledge</td>
                                                    <td class="p-3">mendapat pengalaman/pengetahuan</td>
                                                </tr>
                                                <!-- Row 4 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">obtain information</td>
                                                    <td class="p-3 border-r border-gray-200">memperoleh informasi</td>
                                                    <td class="p-3 border-r border-gray-200">provide evidence/support</td>
                                                    <td class="p-3">memberikan bukti/dukungan</td>
                                                </tr>
                                                <!-- Row 5 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">conduct/carry out research</td>
                                                    <td class="p-3 border-r border-gray-200">melakukan penelitian</td>
                                                    <td class="p-3 border-r border-gray-200">raise/increase awareness</td>
                                                    <td class="p-3">meningkatkan kesadaran</td>
                                                </tr>
                                                <!-- Row 6 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">pose a threat/risk</td>
                                                    <td class="p-3 border-r border-gray-200">menimbulkan ancaman/risiko</td>
                                                    <td class="p-3 border-r border-gray-200">face/pose challenges</td>
                                                    <td class="p-3">menghadapi/menimbulkan tantangan</td>
                                                </tr>
                                                <!-- Row 7 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">meet requirements</td>
                                                    <td class="p-3 border-r border-gray-200">memenuhi persyaratan</td>
                                                    <td class="p-3 border-r border-gray-200">achieve success/goals</td>
                                                    <td class="p-3">mencapai kesuksesan/tujuan</td>
                                                </tr>
                                                <!-- Row 8 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">solve a problem</td>
                                                    <td class="p-3 border-r border-gray-200">memecahkan masalah</td>
                                                    <td class="p-3 border-r border-gray-200">address an issue</td>
                                                    <td class="p-3">menangani masalah</td>
                                                </tr>
                                                <!-- Row 9 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">have an impact/effect</td>
                                                    <td class="p-3 border-r border-gray-200">memiliki dampak/efek</td>
                                                    <td class="p-3 border-r border-gray-200">take into account</td>
                                                    <td class="p-3">mempertimbangkan</td>
                                                </tr>
                                                <!-- Row 10 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">pay attention</td>
                                                    <td class="p-3 border-r border-gray-200">memberikan perhatian</td>
                                                    <td class="p-3 border-r border-gray-200">come to/reach an agreement</td>
                                                    <td class="p-3">mencapai kesepakatan</td>
                                                </tr>
                                                <!-- Row 11 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">build relationships</td>
                                                    <td class="p-3 border-r border-gray-200">membangun hubungan</td>
                                                    <td class="p-3 border-r border-gray-200">develop skills/knowledge</td>
                                                    <td class="p-3">mengembangkan keterampilan/ilmu</td>
                                                </tr>
                                                <!-- Row 12 (Image 2) -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">increase productivity</td>
                                                    <td class="p-3 border-r border-gray-200">meningkatkan produktivitas</td>
                                                    <td class="p-3 border-r border-gray-200">improve performance/quality</td>
                                                    <td class="p-3">meningkatkan kinerja/kualitas</td>
                                                </tr>
                                                <!-- Row 13 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">reduce costs/pollution/risk</td>
                                                    <td class="p-3 border-r border-gray-200">mengurangi biaya/polusi/risiko</td>
                                                    <td class="p-3 border-r border-gray-200">create opportunities/value</td>
                                                    <td class="p-3">menciptakan peluang/nilai</td>
                                                </tr>
                                                <!-- Row 14 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">generate income/interest</td>
                                                    <td class="p-3 border-r border-gray-200">menghasilkan pendapatan/minat</td>
                                                    <td class="p-3 border-r border-gray-200">offer a chance/solutions</td>
                                                    <td class="p-3">memberikan kesempatan/solusi</td>
                                                </tr>
                                                <!-- Row 15 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">apply knowledge/theory</td>
                                                    <td class="p-3 border-r border-gray-200">menerapkan pengetahuan/teori</td>
                                                    <td class="p-3 border-r border-gray-200">take action/measures/steps</td>
                                                    <td class="p-3">mengambil tindakan/langkah</td>
                                                </tr>
                                                <!-- Row 16 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">take advantage</td>
                                                    <td class="p-3 border-r border-gray-200">memanfaatkan</td>
                                                    <td class="p-3 border-r border-gray-200">make progress/improvements</td>
                                                    <td class="p-3">membuat kemajuan/perbaikan</td>
                                                </tr>
                                                <!-- Row 17 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">have access/difficulty</td>
                                                    <td class="p-3 border-r border-gray-200">memiliki akses/kesulitan</td>
                                                    <td class="p-3 border-r border-gray-200">conduct experiments/surveys</td>
                                                    <td class="p-3">melakukan eksperimen/survei</td>
                                                </tr>
                                                <!-- Row 18 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">draw attention/comparisons</td>
                                                    <td class="p-3 border-r border-gray-200">menarik perhatian/perbandingan</td>
                                                    <td class="p-3 border-r border-gray-200">cause damage/concern</td>
                                                    <td class="p-3">menyebabkan kerusakan/kekhawatiran</td>
                                                </tr>
                                                <!-- Row 19 -->
                                                <tr class="border-b border-gray-200 hover:bg-white">
                                                    <td class="p-3 border-r border-gray-200">take part in activities</td>
                                                    <td class="p-3 border-r border-gray-200">ikut serta dalam aktivitas</td>
                                                    <td class="p-3 border-r border-gray-200">gain recognition/support</td>
                                                    <td class="p-3">mendapatkan pengakuan/dukungan</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </main>
    </div>

    <script>
        // Correct answers map for the blanks
        const correctAnswers = @json($topic['correctAnswers']);

        const initialWordBankHTML = document.getElementById('wordBank').innerHTML;
        const initialPassageHTML = document.getElementById('readingPassage').innerHTML;

        // --- Drag and Drop Logic ---
        let draggedWord = null;

        function initializeDragAndDrop() {
            const words = document.querySelectorAll('.drag-word');
            const dropzones = document.querySelectorAll('.dropzone');

            words.forEach(word => {
                word.addEventListener('dragstart', function(e) {
                    draggedWord = this;
                    setTimeout(() => this.classList.add('dragging'), 0);
                    e.dataTransfer.effectAllowed = 'move';
                });

                word.addEventListener('dragend', function() {
                    this.classList.remove('dragging');
                    draggedWord = null;
                    dropzones.forEach(dz => dz.classList.remove('drag-over'));
                });
            });

            dropzones.forEach(zone => {
                zone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('drag-over');
                });

                zone.addEventListener('dragleave', function() {
                    this.classList.remove('drag-over');
                });

                zone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('drag-over');

                    if (draggedWord) {
                        // If dropping onto a blank space
                        if (this.classList.contains('blank-space')) {
                            // If blank is already occupied, move the existing word back to wordBank
                            if (this.children.length > 0) {
                                const existingWord = this.children[0];
                                document.getElementById('wordBank').appendChild(existingWord);
                            }
                            this.appendChild(draggedWord);
                        } 
                        // If dropping back to word bank
                        else if (this.classList.contains('word-bank')) {
                            this.appendChild(draggedWord);
                        }
                    }
                });
            });
        }

        initializeDragAndDrop();

        // --- Timer Logic ---
        var timerDisplay = document.getElementById('timerDisplay');
        var secondsElapsed = 0;
        var timerInterval = null;

        function fmtTimer(s) {
            var m = Math.floor(s / 60);
            var sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

        function startTimer() {
            clearInterval(timerInterval);
            timerInterval = setInterval(function () {
                secondsElapsed++;
                timerDisplay.textContent = fmtTimer(secondsElapsed);
            }, 1000);
        }

        startTimer();

        // --- Checking Logic ---
        function checkAnswers() {
            clearInterval(timerInterval);
            
            let blanks = document.querySelectorAll('.blank-space');
            let correctCount = 0;
            let answeredCount = 0;

            // Disable all drag items
            document.querySelectorAll('.drag-word').forEach(word => {
                word.setAttribute('draggable', false);
                word.style.cursor = 'default';
            });

            blanks.forEach(blank => {
                blank.classList.remove('correct', 'incorrect');
                let blankId = blank.getAttribute('data-id');
                let correctAnswer = correctAnswers[blankId];

                if (blank.children.length > 0) {
                    answeredCount++;
                    let userWord = blank.children[0].getAttribute('data-word');
                    
                    if (userWord === correctAnswer) {
                        correctCount++;
                        blank.classList.add('correct');
                        blank.children[0].style.borderColor = '#10b981'; // keep green
                    } else {
                        blank.classList.add('incorrect');
                        blank.children[0].style.borderColor = '#ef4444'; // turn red
                        blank.children[0].style.color = '#ef4444';
                    }
                }
            });

            // Show result
            let resultBox = document.getElementById('resultBox');
            let resultIconBox = document.getElementById('resultIconBox');
            let resultIcon = document.getElementById('resultIcon');
            let resultTitle = document.getElementById('resultTitle');
            let resultMessage = document.getElementById('resultMessage');
            let correctAnswersList = document.getElementById('correctAnswersList');

            resultBox.classList.remove('hidden');

            let totalBlanks = Object.keys(correctAnswers).length;

            if (correctCount === totalBlanks) {
                resultTitle.textContent = "Perfect!";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>";
                resultMessage.textContent = "You correctly filled all " + totalBlanks + " blanks in " + fmtTimer(secondsElapsed) + "!";
                resultMessage.className = "text-emerald-700 font-medium text-sm mt-1";
                correctAnswersList.textContent = "";
            } else {
                resultTitle.textContent = "Results Checked";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You got " + correctCount + " out of " + totalBlanks + " correct. " + (totalBlanks - answeredCount) + " blanks were left empty.";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
                
                let answersText = "Correct Answers: ";
                for (let [key, val] of Object.entries(correctAnswers)) {
                    answersText += "Blank " + key.replace('blank', '') + " = " + val + ", ";
                }
                correctAnswersList.textContent = answersText.slice(0, -2);
            }

            PTEScorePopup.show({ skill: 'Reading', score: correctCount, max: totalBlanks });
            if (window.PTETracker) {
                PTETracker.saveResult({ score: correctCount, maxScore: totalBlanks, durationSeconds: secondsElapsed });
            }

            document.getElementById('answerBtn').style.opacity = '0.5';
            document.getElementById('answerBtn').style.pointerEvents = 'none';
        }

        function restartPractice() {
            secondsElapsed = 0;
            timerDisplay.textContent = "00:00";
            document.getElementById('resultBox').classList.add('hidden');
            
            document.getElementById('answerBtn').style.opacity = '1';
            document.getElementById('answerBtn').style.pointerEvents = 'auto';

            // Reset containers
            document.getElementById('wordBank').innerHTML = initialWordBankHTML;
            document.getElementById('readingPassage').innerHTML = initialPassageHTML;

            // Re-bind drag events
            initializeDragAndDrop();
            startTimer();
        }
    </script>
    @include('components.pte-score-popup')
    @include('components.pte-practice-tracker', ['module' => 'reading-fill-blanks', 'topicId' => $topicId])
    <x-live-drawing />
</body>
</html>
