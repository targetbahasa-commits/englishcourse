<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Re-order Paragraphs - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .teal-bar { background: #00c5b5; }
        .teal-text { color: #00c5b5; }
        
        .drag-item {
            cursor: move;
            transition: transform 0.2s, box-shadow 0.2s;
            user-select: none;
        }
        .drag-item:active {
            cursor: move;
        }
        .drag-item.dragging {
            opacity: 0.5;
            transform: scale(0.98);
        }
        .drag-over {
            background-color: rgba(0, 197, 181, 0.05);
            border-color: #00c5b5 !important;
        }

        /* Results styling */
        .result-item-correct {
            border-color: #10b981 !important;
            background-color: rgba(16, 185, 129, 0.05) !important;
        }
        .result-item-incorrect {
            border-color: #ef4444 !important;
            background-color: rgba(239, 68, 68, 0.05) !important;
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
                        <a href="{{ route('assignments.pte-academic.reading.reorder-paragraphs.index') }}#topic-{{ $topicId }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Back</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Re-order Paragraphs</h1>
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

                        <!-- Drag and Drop Area -->
                        <div class="px-8 pb-8 pt-2">
                            <div class="flex flex-col md:flex-row gap-6 items-stretch">
                                
                                <!-- Source Column -->
                                <div class="flex-1 flex flex-col">
                                    <div class="teal-bar text-white font-bold text-center py-3 rounded-t-xl">
                                        Source
                                    </div>
                                    <div id="sourceContainer" class="flex-1 border-2 border-teal-200 border-t-0 rounded-b-xl p-4 min-h-[300px] flex flex-col gap-3 bg-white" ondragover="allowDrop(event)" ondrop="drop(event, 'source')">
                                        @foreach($topic['paragraphs'] as $pIndex => $paragraphText)
                                            @php $pLetter = chr(65 + $pIndex); @endphp
                                            <div class="drag-item flex items-stretch border border-teal-200 rounded-lg overflow-hidden bg-white hover:shadow-md" draggable="true" id="item-{{ strtolower($pLetter) }}" data-id="{{ $pLetter }}">
                                                <div class="w-12 flex items-center justify-center font-bold text-white text-lg flex-shrink-0 teal-bar">{{ $pLetter }}</div>
                                                <div class="p-4 text-gray-700 text-sm font-medium flex-1">
                                                    {{ $paragraphText }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Arrow Divider -->
                                <div class="hidden md:flex flex-col items-center justify-center text-teal-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                    </svg>
                                </div>

                                <!-- Target Column -->
                                <div class="flex-1 flex flex-col">
                                    <div class="teal-bar text-white font-bold text-center py-3 rounded-t-xl">
                                        Target
                                    </div>
                                    <div id="targetContainer" class="flex-1 border-2 border-teal-200 border-t-0 rounded-b-xl p-4 min-h-[300px] flex flex-col gap-3 bg-white transition-colors" ondragover="allowDrop(event)" ondrop="drop(event, 'target')">
                                        <!-- Dropped items will appear here -->
                                    </div>
                                </div>

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
                                    <p class="text-gray-800 font-medium text-sm mt-3" id="correctOrderMessage"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-white">
                            <a href="{{ route('assignments.pte-academic.reading.reorder-paragraphs.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-white transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.reading.reorder-paragraphs.practice', ['id' => min(300, $topicId + 1)]) }}"
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
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">1. Mencari Independent Sentence (Kalimat Utama)</h4>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>Kalimat pertama adalah kunci. Harus bisa berdiri sendiri tanpa penjelasan kalimat lain.</li>
                                        <li><strong>Ciri-ciri:</strong> Mengandung subjek utama, definisi umum. Sering berupa perkenalan nama lengkap (Full Name) atau artikel indefinit (a/an).</li>
                                        <li><strong>Bukan Kalimat Pertama:</strong> Jika dimulai dengan Pronoun (He, She, It, They, This, These, Those) atau kata hubung kesimpulan/pertentangan (However, Furthermore, Therefore).</li>
                                        <li><strong>Pengecualian:</strong> Terkadang kalimat pertama memakai "The" jika merujuk konsep umum (misal: "The solar system is...").</li>
                                    </ul>
                                </div>
                                
                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">2. Teknik Pairing (Mencari Pasangan)</h4>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li><strong>Noun → Pronoun:</strong> "The University..." (A) lalu "...It is..." (B). Urutan: A-B.</li>
                                        <li><strong>Full Name → Surname:</strong> "Albert Einstein..." (A) lalu "...Einstein published..." (B). Urutan: A-B.</li>
                                        <li><strong>Indefinite → Definite Articles:</strong> "...a new species of frog." (A) lalu "The frog lives..." (B). Urutan: A-B.</li>
                                        <li><strong>Time Sequence:</strong> Kronologi tahun kejadian (1990 → 2000 → Present).</li>
                                    </ul>
                                </div>
                                
                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">3. Strategi Transisi dan Konektor</h4>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li><strong>Cause and Effect:</strong> Masalah → Penyebab / Solusi.</li>
                                        <li><strong>Contrast:</strong> Cari kalimat pertentangan jika menemukan "However".</li>
                                        <li><strong>Addition:</strong> Kata "Furthermore" atau "In addition" mengikuti poin sebelumnya.</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </main>
    </div>

    <script>
        const correctOrder = @json($topic['correctOrder']);
        const initialHTML = document.getElementById('sourceContainer').innerHTML; // For restart

        // --- Drag and Drop Logic ---
        let draggedItem = null;

        document.querySelectorAll('.drag-item').forEach(setupDragItem);

        function setupDragItem(item) {
            item.addEventListener('dragstart', function(e) {
                draggedItem = item;
                setTimeout(() => item.classList.add('dragging'), 0);
                e.dataTransfer.effectAllowed = 'move';
            });

            item.addEventListener('dragend', function(e) {
                setTimeout(() => item.classList.remove('dragging'), 0);
                draggedItem = null;
                document.getElementById('sourceContainer').classList.remove('drag-over');
                document.getElementById('targetContainer').classList.remove('drag-over');
            });
        }

        function allowDrop(ev) {
            ev.preventDefault();
            let container = ev.currentTarget;
            container.classList.add('drag-over');
        }

        function drop(ev, columnType) {
            ev.preventDefault();
            document.getElementById('sourceContainer').classList.remove('drag-over');
            document.getElementById('targetContainer').classList.remove('drag-over');
            
            if (draggedItem) {
                let container = ev.currentTarget;
                
                // Allow sorting inside the same container
                const afterElement = getDragAfterElement(container, ev.clientY);
                if (afterElement == null) {
                    container.appendChild(draggedItem);
                } else {
                    container.insertBefore(draggedItem, afterElement);
                }
            }
        }

        // Add dragleave event to remove drag-over class
        document.getElementById('sourceContainer').addEventListener('dragleave', function() { this.classList.remove('drag-over'); });
        document.getElementById('targetContainer').addEventListener('dragleave', function() { this.classList.remove('drag-over'); });

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.drag-item:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child }
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

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
            
            let targetItems = document.getElementById('targetContainer').querySelectorAll('.drag-item');
            let sourceItems = document.getElementById('sourceContainer').querySelectorAll('.drag-item');

            // Disable dragging
            document.querySelectorAll('.drag-item').forEach(item => item.setAttribute('draggable', false));

            let resultBox = document.getElementById('resultBox');
            let resultIconBox = document.getElementById('resultIconBox');
            let resultIcon = document.getElementById('resultIcon');
            let resultTitle = document.getElementById('resultTitle');
            let resultMessage = document.getElementById('resultMessage');
            let correctOrderMessage = document.getElementById('correctOrderMessage');

            resultBox.classList.remove('hidden');

            if (targetItems.length < correctOrder.length) {
                resultTitle.textContent = "Incomplete";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You did not move all items to the Target column.";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
                correctOrderMessage.textContent = "Correct order: " + correctOrder.join(' -> ');
                document.getElementById('answerBtn').style.opacity = '0.5';
                document.getElementById('answerBtn').style.pointerEvents = 'none';
                return;
            }

            // PTE Re-order paragraphs scoring: 1 point for each adjacent pair
            let pairsCorrect = 0;
            let totalPairs = correctOrder.length - 1;
            let userOrder = Array.from(targetItems).map(item => item.getAttribute('data-id'));

            // Highlight items
            let isPerfect = true;
            for (let i = 0; i < userOrder.length; i++) {
                if (userOrder[i] === correctOrder[i]) {
                    targetItems[i].classList.add('result-item-correct');
                } else {
                    targetItems[i].classList.add('result-item-incorrect');
                    isPerfect = false;
                }

                // Check pairs for PTE scoring
                if (i < userOrder.length - 1) {
                    let currentItem = userOrder[i];
                    let nextItem = userOrder[i+1];
                    let correctIndex = correctOrder.indexOf(currentItem);
                    if (correctIndex !== -1 && correctIndex < correctOrder.length - 1 && correctOrder[correctIndex+1] === nextItem) {
                        pairsCorrect++;
                    }
                }
            }

            if (isPerfect) {
                resultTitle.textContent = "Perfect!";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>";
                resultMessage.textContent = "You ordered the paragraphs perfectly in " + fmtTimer(secondsElapsed) + "!";
                resultMessage.className = "text-emerald-700 font-medium text-sm mt-1";
                correctOrderMessage.textContent = "";
            } else {
                resultTitle.textContent = "Results Checked";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You got " + pairsCorrect + " out of " + totalPairs + " adjacent pairs correct. (PTE Score: " + pairsCorrect + "/" + totalPairs + ")";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
                correctOrderMessage.textContent = "Correct order: " + correctOrder.join(' -> ');
            }

            let pteScore = isPerfect ? totalPairs : pairsCorrect;
            PTEScorePopup.show({ skill: 'Reading', score: pteScore, max: totalPairs });
            if (window.PTETracker) {
                PTETracker.saveResult({ score: pteScore, maxScore: totalPairs, durationSeconds: secondsElapsed });
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
            document.getElementById('sourceContainer').innerHTML = initialHTML;
            document.getElementById('targetContainer').innerHTML = '';

            // Re-bind drag events to new elements
            document.querySelectorAll('.drag-item').forEach(setupDragItem);

            startTimer();
        }
    </script>
    @include('components.pte-score-popup')
    @include('components.pte-practice-tracker', ['module' => 'reorder-paragraphs', 'topicId' => $topicId])
    <x-live-drawing />
</body>
</html>
