import sys

content = """<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Write Essay - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">
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
                    <a href="{{ route('assignments.pte-academic.speaking-writing.write-essay.index') }}#topic-{{ $topicId }}" class="p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
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
                    <button onclick="restartEssay()" class="px-6 py-2.5 font-medium rounded-full shadow-sm transition-all cursor-pointer hover:bg-gray-50" style="background-color: #ffffff; color: #374151; border: 1px solid #d1d5db;">
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
        isDragged: false,
        dragging: false,
        x: window.innerWidth / 2 - 50,
        y: window.innerHeight - 100,
        startX: 0,
        startY: 0,
        start(e) {
            this.dragging = true;
            this.isDragged = false;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.startX = clientX - this.x;
            this.startY = clientY - this.y;
        },
        move(e) {
            if (!this.dragging) return;
            e.preventDefault();
            this.isDragged = true;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.x = clientX - this.startX;
            this.y = clientY - this.startY;
            this.x = Math.max(0, Math.min(this.x, window.innerWidth - 60));
            this.y = Math.max(0, Math.min(this.y, window.innerHeight - 60));
        },
        end() {
            this.dragging = false;
            if (this.x < 0) this.x = 0;
            if (this.y < 0) this.y = 0;
            if (this.x > window.innerWidth - 60) this.x = window.innerWidth - 60;
            if (this.y > window.innerHeight - 60) this.y = window.innerHeight - 60;
        }
    }" 
    @mousemove.window="move" @mouseup.window="end" @touchmove.window="move" @touchend.window="end">
        <button @click.prevent="if(!isDragged) showTips = true" 
                @mousedown="start" @touchstart="start"
                class="fixed z-50 text-white p-4 rounded-full shadow-2xl flex items-center gap-2 select-none"
                :style="`left: ${x}px; top: ${y}px; background-color: #eab308; touch-action: none;`"
                :class="dragging ? 'cursor-grabbing scale-105' : 'cursor-grab hover:scale-105 transition-transform'"
                title="Tips & Strategi">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-bold hidden md:inline text-white">Tips</span>
        </button>

        {{-- Tips Modal --}}
        <template x-teleport="body">
            <div x-show="showTips" style="display: none;" class="fixed inset-0 bg-transparent z-[100] flex items-center justify-center p-4">
                <div @click.away="showTips = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-gray-200">
                    <div class="flex items-center justify-between p-6 border-b border-blue-100 bg-blue-50 shrink-0">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-blue-900">Tips Write Essay</h2>
                                <p class="text-blue-600 text-sm">Panduan dan format jawaban Anda.</p>
                            </div>
                        </div>
                        <button @click="showTips = false" class="text-blue-400 hover:text-blue-600 hover:bg-blue-100 p-2 rounded-full transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="p-6 overflow-y-auto bg-gray-50 flex-1">
                        <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                            <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                <h4 class="font-bold text-blue-900">Struktur Umum</h4>
                            </div>
                            <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4">
                                <p>Write 200–300 words. Keep your paragraphs clear with introduction, body paragraph 1, body paragraph 2, and conclusion.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @include('components.pte-score-popup')
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 2], 'grammarLevel' => 'all'])

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

        function submitEssay() {
            clearInterval(timerInterval);
            var answer = document.getElementById('essayBox').value.trim();
            alert('Essay tersimpan! (Word count: ' + (answer === '' ? 0 : answer.split(/\s+/).length) + ' kata)');
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
</body>
</html>
"""

with open('resources/views/assignments/pte-academic/write-essay/practice.blade.php', 'w') as f:
    f.write(content)

print('Updated Write Essay practice view successfully.')
