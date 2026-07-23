<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Summarize Spoken Text - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .teal-bar { background: #00c5b5; }
        .teal-text { color: #00c5b5; }
        
        /* Audio Player Styling */
        .audio-player-box {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            background: white;
        }
        .play-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #1e40af; /* blue-800 to match mockup play button */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            flex-shrink: 0;
            transition: opacity 0.2s;
        }
        .play-btn:hover { opacity: 0.9; }
        
        .progress-container {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .time-text {
            font-family: monospace;
            font-size: 14px;
            color: #374151;
            font-weight: 600;
        }
        .progress-bar-bg {
            flex: 1;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            position: relative;
        }
        .progress-bar-fill {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            background: #e5e7eb; /* In mockup it's just gray, let's make it light gray */
            border-radius: 4px;
            width: 0%;
        }
        .progress-handle {
            position: absolute;
            top: 50%;
            left: 0%;
            transform: translate(-50%, -50%);
            width: 16px;
            height: 16px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .controls-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .speed-btn {
            border: 1px solid #00c5b5;
            color: #00c5b5;
            border-radius: 16px;
            padding: 4px 12px;
            font-size: 14px;
            font-weight: 600;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .speed-dropdown {
            position: fixed;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            overflow: hidden;
            z-index: 9999;
            min-width: 110px;
        }
        .speed-option {
            display: block;
            width: 100%;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            background: white;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: background 0.15s;
        }
        .speed-option:hover { background: #f0fdf9; color: #00c5b5; }
        .speed-option.active { background: #e0faf7; color: #00c5b5; }
        .volume-control {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #00c5b5;
        }
        .volume-slider {
            width: 60px;
            height: 4px;
            background: #00c5b5;
            border-radius: 2px;
            position: relative;
        }
        .volume-handle {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translate(50%, -50%);
            width: 12px;
            height: 12px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 50%;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        /* Textarea Styling */
        .summary-textarea {
            width: 100%;
            min-height: 200px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 16px;
            font-size: 15px;
            color: #374151;
            resize: vertical;
            outline: none;
            transition: border-color 0.2s;
        }
        .summary-textarea:focus {
            border-color: #00c5b5;
            box-shadow: 0 0 0 2px rgba(0, 197, 181, 0.1);
        }
        .resize-handle-wrapper {
            display: flex;
            justify-content: center;
            margin-top: -12px;
            position: relative;
            z-index: 10;
        }
        .resize-handle {
            width: 40px;
            height: 16px;
            background: #00c5b5;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2px;
            cursor: ns-resize;
        }
        .resize-line {
            width: 16px;
            height: 2px;
            background: white;
            border-radius: 1px;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::check())
            @php($sidebarRole = strtolower(Auth::user()->active_role ?? 'student'))
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
                <div class="mb-8">
                    <a href="{{ route('assignments.pte-academic.listening.index') }}#topic-{{ $topicId }}" class="inline-flex items-center text-gray-600 hover:text-purple-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-400 to-purple-600 text-white shadow-lg shadow-purple-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Summarize Spoken Text</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="max-w-5xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col">

                        <!-- Teal Title Bar -->
                        <div class="teal-bar text-white font-bold text-base py-3 px-8 rounded-t-xl mx-8 mt-8 flex justify-between items-center">
                            <span>Sample Question {{ $topicId }}:</span>
                        </div>

                        <!-- Status Row -->
                        <div class="px-8 pt-4 pb-2 flex justify-between items-center">
                            <div class="font-bold text-gray-800 flex gap-1">
                                Beginning in <span class="teal-text" id="prepTimer">5 sec</span>
                            </div>
                            <div class="text-sm font-medium text-gray-500" id="wordCountContainer" style="display: none;">
                                Word Count: <span id="wordCount" class="font-bold text-gray-700">0</span> / 70
                            </div>
                        </div>

                        <!-- Audio Player Area -->
                        <div class="px-8 pb-4">
                            <div class="audio-player-box">
                                <button class="play-btn" id="playBtn">
                                    <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4l12 6-12 6z"></path>
                                    </svg>
                                </button>
                                
                                <div class="progress-container">
                                    <span class="time-text" id="currentTime">00:00</span>
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill" id="progressBar"></div>
                                        <div class="progress-handle" id="progressHandle"></div>
                                    </div>
                                    <span class="time-text">02:15</span>
                                </div>

                                <div class="controls-right">
                                    <div class="relative" id="speedContainer">
                                        <button class="speed-btn" id="speedBtn" onclick="toggleSpeedDropdown(event)">
                                            <span id="speedLabel">1.0×</span>
                                            <svg class="w-4 h-4 transition-transform duration-200" id="speedChevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div id="speedDropdown" class="speed-dropdown hidden">
                                            <button onclick="setSpeed(0.5, this)" class="speed-option">0.5× Slow</button>
                                            <button onclick="setSpeed(0.6, this)" class="speed-option">0.6×</button>
                                            <button onclick="setSpeed(0.7, this)" class="speed-option">0.7×</button>
                                            <button onclick="setSpeed(0.75, this)" class="speed-option">0.75×</button>
                                            <button onclick="setSpeed(0.8, this)" class="speed-option">0.8×</button>
                                            <button onclick="setSpeed(0.9, this)" class="speed-option">0.9×</button>
                                            <button onclick="setSpeed(1.0, this)" class="speed-option active">1.0× Normal</button>
                                        </div>
                                    </div>
                                    <div class="volume-control">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M11 5L6 9H2v6h4l5 4V5z"></path>
                                        </svg>
                                        <div class="volume-slider">
                                            <div class="volume-handle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Textarea Area -->
                        <div class="px-8 pb-6">
                            <textarea id="summaryInput" class="summary-textarea" placeholder="Type your summary here..." readonly></textarea>
                            <div class="resize-handle-wrapper">
                                <div class="resize-handle">
                                    <div class="resize-line"></div>
                                    <div class="resize-line"></div>
                                    <div class="resize-line"></div>
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
                                class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-full text-sm hover:bg-gray-50 transition">
                                Restart
                            </button>
                            <button id="startTimerBtn" onclick="startPrepTimer()"
                                class="px-6 py-2.5 bg-white font-bold rounded-full text-sm border-2 transition"
                                style="color:#00c5b5; border-color:#00c5b5;">
                                Start
                            </button>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <a href="{{ route('assignments.pte-academic.listening.summarize-spoken-text.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.listening.summarize-spoken-text.practice', ['id' => min(300, $topicId + 1)]) }}"
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
                    
                    // Keep within screen bounds
                    this.x = Math.max(0, Math.min(this.x, window.innerWidth - 60));
                    this.y = Math.max(0, Math.min(this.y, window.innerHeight - 60));
                },
                end() {
                    this.dragging = false;
                    // Reset position if dragged out of bounds
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
                            <div class="flex items-center justify-between p-6 border-b border-purple-100 bg-purple-50 shrink-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-purple-900">Tips Summarize Spoken Text (SST)</h2>
                                        <p class="text-purple-600 text-sm">Panduan dan format jawaban Anda.</p>
                                    </div>
                                </div>
                                <button @click="showTips = false" class="text-purple-400 hover:text-purple-600 hover:bg-purple-100 p-2 rounded-full transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="p-6 overflow-y-auto bg-gray-50 flex-1">

                                <div class="bg-white rounded-xl border border-purple-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-purple-50 px-4 py-3 border-b border-purple-100">
                                        <h4 class="font-bold text-purple-900">Syarat</h4>
                                    </div>
                                    <div class="p-4 text-purple-800 leading-relaxed text-sm sm:text-base space-y-2">
                                        <p>Tulis frasa (2 kata atau lebih). Jawaban tidak boleh lebih dari 70 kata.</p>
                                        <p>Frasa adalah gabungan kata yang memiliki makna kesatuan namun tanpa Subjek dan Predikat.</p>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl border border-purple-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-purple-50 px-4 py-3 border-b border-purple-100">
                                        <h4 class="font-bold text-purple-900">Template Jawaban</h4>
                                    </div>
                                    <div class="p-4 text-purple-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <p>
                                            The lecture gives information about many aspects of the effects of <span class="text-amber-600 font-bold">[Phrases 1]</span>. While the impacts of <span class="text-amber-600 font-bold">[Phrases 2]</span>, such as <span class="text-amber-600 font-bold">[Phrases 3]</span>, are important for <span class="text-amber-600 font-bold">[Phrases 4]</span>, the influences of <span class="text-amber-600 font-bold">[Phrases 5]</span>, such as <span class="text-amber-600 font-bold">[Phrases 6]</span>, are remarkable for <span class="text-amber-600 font-bold">[Phrases 7]</span>. Finally, the effects of having <span class="text-amber-600 font-bold">[Phrases 8]</span>, such as <span class="text-amber-600 font-bold">[Phrases 9]</span>, are significant for <span class="text-amber-600 font-bold">[Phrases 10]</span>.
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl border border-purple-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-purple-50 px-4 py-3 border-b border-purple-100">
                                        <h4 class="font-bold text-purple-900">Contoh Jawaban</h4>
                                    </div>
                                    <div class="p-4 text-purple-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <p>
                                            The lecture gives information about many aspects of the effects of <span class="text-amber-600 font-bold">[climate change on oceans]</span>. While the impacts of <span class="text-amber-600 font-bold">[raising global temperature]</span>, such as <span class="text-amber-600 font-bold">[raising sea levels]</span>, are important for <span class="text-amber-600 font-bold">[marine life]</span>, the influences of <span class="text-amber-600 font-bold">[this environmental issue]</span>, such as <span class="text-amber-600 font-bold">[biodiversity]</span>, are remarkable for <span class="text-amber-600 font-bold">[coastal lives]</span>. Finally, the effects of having <span class="text-amber-600 font-bold">[actions]</span>, such as <span class="text-amber-600 font-bold">[preserving the environment]</span>, are significant for <span class="text-amber-600 font-bold">[protecting the community]</span>.
                                        </p>
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
        let prepTimerInterval;
        let audioPlayInterval;
        let writingTimerInterval;
        
        let prepTime = 5;
        let audioDuration = 135; // 2:15
        let audioCurrentTime = 0;
        let writingTime = 600; // 10 minutes total for summarize spoken text usually
        let currentSpeed = 1.0;
        let isAudioPlaying = false;
        
        const prepTimerEl = document.getElementById('prepTimer');
        const playBtn = document.getElementById('playBtn');
        const currentTimeEl = document.getElementById('currentTime');
        const progressBar = document.getElementById('progressBar');
        const progressHandle = document.getElementById('progressHandle');
        const summaryInput = document.getElementById('summaryInput');
        const wordCountEl = document.getElementById('wordCount');
        const wordCountContainer = document.getElementById('wordCountContainer');
        const startTimerBtn = document.getElementById('startTimerBtn');

        function toggleSpeedDropdown(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('speedDropdown');
            const chevron = document.getElementById('speedChevron');
            const btn = document.getElementById('speedBtn');
            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                const rect = btn.getBoundingClientRect();
                dropdown.style.top = (rect.bottom + 6) + 'px';
                dropdown.style.left = (rect.left + rect.width / 2) + 'px';
                dropdown.style.transform = 'translateX(-50%)';
            }
            dropdown.classList.toggle('hidden');
            chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
        }

        function setSpeed(speed, btn) {
            currentSpeed = speed;
            document.getElementById('speedLabel').textContent = speed + '×';
            document.querySelectorAll('.speed-option').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('speedDropdown').classList.add('hidden');
            document.getElementById('speedChevron').style.transform = '';
            if (isAudioPlaying) {
                clearInterval(audioPlayInterval);
                audioPlayInterval = setInterval(audioTick, 1000 / currentSpeed);
            }
        }

        document.addEventListener('click', function(e) {
            const sc = document.getElementById('speedContainer');
            if (sc && !sc.contains(e.target)) {
                document.getElementById('speedDropdown').classList.add('hidden');
                document.getElementById('speedChevron').style.transform = '';
            }
        });

        function fmtTime(s) {
            let m = Math.floor(s / 60);
            let sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

        function startPrepTimer() {
            startTimerBtn.style.display = 'none';
            prepTime = 5;
            prepTimerEl.textContent = prepTime + ' sec';
            prepTimerEl.parentElement.innerHTML = 'Beginning in <span class="teal-text" id="prepTimer">5 sec</span>';
            
            clearInterval(prepTimerInterval);
            prepTimerInterval = setInterval(() => {
                prepTime--;
                document.getElementById('prepTimer').textContent = prepTime + ' sec';
                if(prepTime <= 0) {
                    clearInterval(prepTimerInterval);
                    startAudio();
                }
            }, 1000);
        }

        function audioTick() {
            audioCurrentTime++;
            currentTimeEl.textContent = fmtTime(audioCurrentTime);
            let perc = (audioCurrentTime / audioDuration) * 100;
            progressBar.style.width = perc + '%';
            progressHandle.style.left = perc + '%';
            if(audioCurrentTime >= audioDuration) {
                clearInterval(audioPlayInterval);
                isAudioPlaying = false;
                startWriting();
            }
        }

        function startAudio() {
            document.getElementById('prepTimer').parentElement.innerHTML = 'Status: <span class="teal-text">Playing Audio</span>';
            playBtn.innerHTML = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
            audioCurrentTime = 0;
            isAudioPlaying = true;
            clearInterval(audioPlayInterval);
            audioPlayInterval = setInterval(audioTick, 1000 / currentSpeed);
        }

        function startWriting() {
            document.getElementById('prepTimer').parentElement.innerHTML = 'Status: <span class="teal-text">Writing</span> | Time Remaining: <span id="writeTimer" class="font-bold">10:00</span>';
            playBtn.innerHTML = '<svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>';
            
            summaryInput.removeAttribute('readonly');
            summaryInput.focus();
            wordCountContainer.style.display = 'block';
            
            writingTime = 600;
            clearInterval(writingTimerInterval);
            writingTimerInterval = setInterval(() => {
                writingTime--;
                const wt = document.getElementById('writeTimer');
                if(wt) wt.textContent = fmtTime(writingTime);
                
                if(writingTime <= 0) {
                    clearInterval(writingTimerInterval);
                    summaryInput.setAttribute('readonly', true);
                    document.getElementById('prepTimer').parentElement.innerHTML = 'Status: <span class="text-red-500 font-bold">Time is up!</span>';
                    if (window.PTETracker) {
                        PTETracker.saveResult({ score: 1, maxScore: 1, durationSeconds: 600 });
                    }
                }
            }, 1000);
        }

        function restartPractice() {
            clearInterval(prepTimerInterval);
            clearInterval(audioPlayInterval);
            clearInterval(writingTimerInterval);
            
            startTimerBtn.style.display = 'inline-block';
            document.getElementById('prepTimer').parentElement.innerHTML = 'Beginning in <span class="teal-text" id="prepTimer">5 sec</span>';
            
            currentTimeEl.textContent = "00:00";
            progressBar.style.width = '0%';
            progressHandle.style.left = '0%';
            playBtn.innerHTML = '<svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>';
            
            summaryInput.value = '';
            summaryInput.setAttribute('readonly', true);
            wordCountEl.textContent = '0';
            wordCountEl.className = 'font-bold text-gray-700';
            wordCountContainer.style.display = 'none';
        }

        // Word count logic
        summaryInput.addEventListener('input', function() {
            let text = this.value.trim();
            let words = text === '' ? 0 : text.split(/\s+/).length;
            wordCountEl.textContent = words;
            
            if(words < 50 || words > 70) {
                wordCountEl.className = 'font-bold text-red-500';
            } else {
                wordCountEl.className = 'font-bold text-green-500';
            }
        });
        
        // Custom Resize Handle Logic
        const resizeHandle = document.querySelector('.resize-handle');
        let isResizing = false;
        let startY;
        let startHeight;

        resizeHandle.addEventListener('mousedown', function(e) {
            isResizing = true;
            startY = e.clientY;
            startHeight = parseInt(document.defaultView.getComputedStyle(summaryInput).height, 10);
            document.body.style.cursor = 'ns-resize';
        });

        document.addEventListener('mousemove', function(e) {
            if (!isResizing) return;
            const newHeight = startHeight + (e.clientY - startY);
            if (newHeight >= 100) { // minimum height
                summaryInput.style.height = newHeight + 'px';
            }
        });

        document.addEventListener('mouseup', function() {
            if (isResizing) {
                isResizing = false;
                document.body.style.cursor = 'default';
            }
        });

        // Auto start prep timer on load like the other modules
        window.addEventListener('load', () => {
            startPrepTimer();
        });
    </script>
    @include('components.pte-score-popup')
    @include('components.pte-practice-tracker', ['module' => 'summarize-spoken-text', 'topicId' => $topicId])
</body>
</html>
