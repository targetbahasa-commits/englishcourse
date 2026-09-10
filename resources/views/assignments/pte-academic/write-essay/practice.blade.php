<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Write Essay - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .resize-handle-btn {
            background-color: #00b4d8;
            color: #ffffff;
            transition: transform 0.15s ease, background-color 0.15s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .resize-handle-btn:hover {
            background-color: #0096c7;
            transform: translateX(-50%) scale(1.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-white flex flex-col min-h-screen">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @php
            if(Auth::check()) {
                $sidebarRole = strtolower(Auth::user()->active_role ?? 'student');
            } else {
                $sidebarRole = 'guest';
            }
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

        {{-- Main Content Wrapper --}}
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">

            {{-- Top Navigation Bar --}}
            <nav class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
                <div class="flex items-center gap-4">
                    <a href="{{ route('assignments.pte-academic.speaking-writing.write-essay.index') }}#topic-{{ $topicId }}" class="p-2 text-gray-500 hover:text-gray-800 hover:bg-white rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold" style="background-color: #e0f2fe; color: #0284c7;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-800 leading-tight">Write Essay</h1>
                            <p class="text-xs text-gray-500">PTE Academic Practice - Topic #{{ str_pad($topicId, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Main Test Area --}}
            <main class="flex-1 flex flex-col max-w-5xl w-full mx-auto p-4 md:p-8">
                
                {{-- Top Light Blue Header Banner --}}
                <div class="font-bold text-lg px-6 py-3.5 rounded-xl mb-4 shadow-sm" style="background-color: #00b4d8; color: #ffffff;">
                    Sample Question {{ $topicId }}: {{ $topic['title'] }}
                </div>

                {{-- Status / Timer --}}
                <div class="mb-4 flex items-center justify-between">
                    <p class="text-base font-bold text-gray-800">
                        Remaining Time <span style="color: #00b4d8; font-weight: 800;" id="timerDisplay">00 : 20 : 00 sec</span>
                    </p>
                    <div class="text-xs text-gray-500">
                        Word count: <span id="wordCount" class="font-bold text-[#00b4d8]">0</span> (aim: 200–300 words)
                    </div>
                </div>

                {{-- Prompt Question Resizable Card (Default height: auto) --}}
                <div id="promptCard" class="rounded-xl p-6 shadow-sm flex flex-col" style="position: relative; background-color: #ffffff; border: 1px solid #00b4d8; min-height: 100px; height: auto; margin-bottom: 28px;">
                    <div id="promptContent" class="text-gray-800 leading-relaxed font-sans text-base flex-1 pr-2 pb-4">
                        {{ $topic['prompt'] ?? $topic['content'] ?? 'Do you agree that technology has had a more positive than negative impact on the quality of education? Discuss both views and give your own opinion. Write 200–300 words.' }}
                    </div>
                    
                    {{-- Interactive Drag Resize Handle Pill --}}
                    <div onmousedown="initDragResize(event, 'promptCard')" ontouchstart="initDragResize(event, 'promptCard')" 
                         class="resize-handle-btn px-4 py-1 rounded-full flex items-center justify-center cursor-ns-resize"
                         style="position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%); background-color: #00b4d8; color: #ffffff; z-index: 20;"
                         title="Klik & tarik untuk mengubah ukuran kotak soal">
                        <svg class="w-4 h-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 8h16M4 16h16"></path></svg>
                    </div>
                </div>

                {{-- Essay Resizable Textarea Box --}}
                <div id="essayCard" class="rounded-xl p-6 shadow-sm flex flex-col" style="position: relative; background-color: #ffffff; border: 1px solid #00b4d8; min-height: 200px; height: 280px; margin-bottom: 28px;">
                    <textarea id="essayBox"
                        class="w-full flex-1 border-none p-0 text-gray-800 text-base leading-relaxed bg-transparent focus:ring-0 focus:outline-none resize-none"
                        placeholder="Type your essay here..."
                        oninput="updateWordCount(this)"></textarea>

                    {{-- Interactive Drag Resize Handle Pill --}}
                    <div onmousedown="initDragResize(event, 'essayCard')" ontouchstart="initDragResize(event, 'essayCard')" 
                         class="resize-handle-btn px-4 py-1 rounded-full flex items-center justify-center cursor-ns-resize"
                         style="position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%); background-color: #00b4d8; color: #ffffff; z-index: 20;"
                         title="Klik & tarik untuk mengubah ukuran kotak essay">
                        <svg class="w-4 h-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 8h16M4 16h16"></path></svg>
                    </div>
                </div>

                {{-- Action Pill Buttons --}}
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <button id="submitBtn" onclick="submitEssay()" class="px-6 py-2.5 font-bold rounded-full shadow transition-all cursor-pointer hover:opacity-90" style="background-color: #00b4d8; color: #ffffff;">
                        Practice with AI Scoring
                    </button>
                    <button onclick="restartEssay()" class="px-6 py-2.5 font-medium rounded-full shadow-sm transition-all cursor-pointer hover:bg-white" style="background-color: #ffffff; color: #374151; border: 1px solid #d1d5db;">
                        Restart
                    </button>
                    <button onclick="startTimer()" class="px-6 py-2.5 font-bold rounded-full shadow-sm transition-all cursor-pointer" style="background-color: #ffffff; color: #00b4d8; border: 1px solid #00b4d8;">
                        Start
                    </button>
                    @if(Auth::check() && Auth::user()->isAdmin())
                    <button onclick="PTEScorePopup.show({ skill: 'Writing', score: 82, max: 90, breakdown: { 'Grammar': 84, 'Spelling': 88, 'Form': 90, 'Vocabulary': 80 }, feedback: 'Well-structured 4-paragraph essay (245 words). Excellent coherence.' })" class="px-5 py-2.5 font-bold rounded-full shadow transition-all flex items-center gap-2 cursor-pointer hover:opacity-90" style="background-color: #f59e0b; color: #ffffff;" title="Khusus Admin: Preview Hasil Evaluasi AI">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Preview Evaluasi
                    </button>
                    @endif
                </div>
            </main>

            {{-- Bottom Action Bar & Helpers --}}
            <footer class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-10">
                <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('assignments.pte-academic.speaking-writing.write-essay.practice', ['id' => max(1, $topicId - 1)]) }}" class="px-6 py-2.5 font-medium rounded-lg shadow-sm transition-colors {{ $topicId <= 1 ? 'opacity-40 pointer-events-none' : '' }}" style="background-color: #00b4d8; color: #ffffff;">
                            Previous
                        </a>
                        <a href="{{ route('assignments.pte-academic.speaking-writing.write-essay.practice', ['id' => min(300, $topicId + 1)]) }}" class="px-6 py-2.5 font-medium rounded-lg shadow-sm transition-colors {{ $topicId >= 300 ? 'opacity-40 pointer-events-none' : '' }}" style="background-color: #00b4d8; color: #ffffff;">
                            Next
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="relative flex-1 sm:w-48">
                            <input type="text" placeholder="Question ..." class="w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm">
                            <button class="absolute right-0 top-0 bottom-0 px-3 font-medium text-white rounded-r-lg transition-colors flex items-center justify-center" style="background-color: #00b4d8;">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Floating Tips Button & Modal --}}
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
                            <div class="bg-white px-4 py-3 border-b border-blue-100">
                                <h4 class="font-bold text-blue-900">Struktur Umum</h4>
                            </div>
                            <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4">
                                <p>Write 200–300 words. Keep your paragraphs clear with introduction, body paragraph 1, body paragraph 2, and conclusion.</p>
                            </div>
                        </div>
                    </div>
                <div class="absolute bottom-1 right-1 pointer-events-none opacity-40">
                        <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 16 16"><path d="M16 16v-4h-2v2h-2v2h4zM16 8v-2h-2v2h2zM12 12v-2h-2v2h2zM8 16v-2h-2v2h2z"/></svg>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @include('components.pte-score-popup')

    <script>
        var totalSeconds = 20 * 60;
        var timerDisplay = document.getElementById('timerDisplay');
        var timerInterval = null;

        function startTimer() {
            if (timerInterval) return;
            timerInterval = setInterval(function () {
                totalSeconds--;
                var m = Math.floor(totalSeconds / 60);
                var s = totalSeconds % 60;
                timerDisplay.textContent = '00 : ' + (m < 10 ? '0'+m : m) + ' : ' + (s < 10 ? '0'+s : s) + ' sec';

                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    timerDisplay.textContent = '00 : 00 : 00 sec';
                    submitEssay();
                }
            }, 1000);
        }

        function updateWordCount(el) {
            var text = el.value.trim();
            var words = text === '' ? 0 : text.split(/\s+/).length;
            document.getElementById('wordCount').textContent = words;
        }

        async function submitEssay() {
            clearInterval(timerInterval);
            var answer = document.getElementById('essayBox').value.trim();
            if (!answer) {
                alert('Silakan tulis essay Anda terlebih dahulu.');
                return;
            }

            var submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Evaluating with AI...';
            }

            try {
                var response = await fetch('/pte/practice/evaluate-writing', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        answer: answer,
                        module: 'write-essay',
                        topic_id: {{ $topicId }},
                        prompt_text: @json($topic['prompt'] ?? '')
                    })
                });

                var data = await response.json();
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Practice with AI Scoring';
                }

                if (data.success && data.scores) {
                    PTEScorePopup.show({
                        skill: 'Writing',
                        score: data.scores.overall_score || 70,
                        max: 90,
                        breakdown: {
                            'Content': data.scores.content_score || 70,
                            'Form': data.scores.form_score || 70,
                            'Grammar': data.scores.grammar_score || 70,
                            'Vocabulary': data.scores.vocabulary_score || 70,
                            'Spelling': data.scores.spelling_score || 70
                        },
                        feedback: data.scores.feedback || ''
                    });

                    if (window.PTETracker) {
                        PTETracker.saveResult({ score: data.scores.overall_score || 70, maxScore: 90, durationSeconds: (20 * 60) - totalSeconds });
                    }
                } else {
                    alert('Evaluasi AI Gagal: ' + (data.message || 'Error occurred'));
                }
            } catch (err) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Practice with AI Scoring';
                }
                console.error('Error evaluating essay:', err);
                alert('Terjadi kesalahan jaringan saat mengevaluasi essay.');
            }
        }

        function restartEssay() {
            clearInterval(timerInterval);
            timerInterval = null;
            totalSeconds = 20 * 60;
            timerDisplay.textContent = '00 : 20 : 00 sec';
            document.getElementById('essayBox').value = '';
            document.getElementById('wordCount').textContent = '0';
        }

        // ── Interactive Drag Resize Handler for Cyan Handle Pill ──
        function initDragResize(e, targetId) {
            e.preventDefault();
            e.stopPropagation();
            var target = document.getElementById(targetId);
            if (!target) return;
            
            var innerContent = target.querySelector('#promptContent') || target.querySelector('#essayBox');
            if (innerContent) {
                innerContent.style.overflowY = 'auto';
            }

            var startY = e.type.includes('mouse') ? e.clientY : (e.touches ? e.touches[0].clientY : 0);
            var startHeight = target.offsetHeight;

            function doDrag(event) {
                var currentY = event.type.includes('mouse') ? event.clientY : (event.touches ? event.touches[0].clientY : startY);
                var deltaY = currentY - startY;
                var newHeight = startHeight + deltaY;
                
                if (newHeight >= 100 && newHeight <= 800) {
                    target.style.height = newHeight + 'px';
                }
            }

            function stopDrag() {
                document.removeEventListener('mousemove', doDrag);
                document.removeEventListener('mouseup', stopDrag);
                document.removeEventListener('touchmove', doDrag);
                document.removeEventListener('touchend', stopDrag);
            }

            document.addEventListener('mousemove', doDrag);
            document.addEventListener('mouseup', stopDrag);
            document.addEventListener('touchmove', doDrag, { passive: false });
            document.addEventListener('touchend', stopDrag);
        }
    </script>
    @include('components.pte-practice-tracker', ['module' => 'write-essay', 'topicId' => $topicId])
    <x-live-drawing />
</body>
</html>
