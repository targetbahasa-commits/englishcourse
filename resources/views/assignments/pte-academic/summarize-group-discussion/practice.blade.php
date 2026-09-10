<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Summarize Group Discussion - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .teal-bar { background: #3eb6f0; }
        .teal-text { color: #3eb6f0; }

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
            background: #1e40af;
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
            background: #e5e7eb;
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
            border: 1px solid #3eb6f0;
            color: #3eb6f0;
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
        .speed-option:hover { background: #f0fdf9; color: #3eb6f0; }
        .speed-option.active { background: #e0faf7; color: #3eb6f0; }
        .volume-control {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #3eb6f0;
        }
        .volume-slider {
            width: 60px;
            height: 4px;
            background: #3eb6f0;
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

        /* Mobile: the audio player's row of controls (play button, progress
           bar, speed selector, volume) doesn't fit on one line under ~480px,
           so wrap the speed/volume controls onto their own row below. */
        @media (max-width: 480px) {
            .audio-player-box {
                flex-wrap: wrap;
                padding: 12px 16px;
                gap: 10px;
            }
            .progress-container {
                min-width: 0;
                flex-basis: 0;
            }
            .controls-right {
                width: 100%;
                justify-content: space-between;
                order: 3;
            }
            .volume-slider {
                width: 50px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-cyan-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @if(Auth::check())
            <?php $sidebarRole = strtolower(Auth::user()->active_role ?? 'student'); ?>
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

        {{-- Main Content --}}
        <main class="flex-1 min-w-0 md:ml-64 p-4 md:p-8">
            <div class="container mx-auto">

                <!-- Header with Back Button -->
                <div class="mb-6">
                    <div class="flex justify-end mb-2">
                        <a href="{{ route('assignments.pte-academic.speaking-writing.summarize-group-discussion.index') }}#topic-{{ $topicId }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Back</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Summarize Group Discussion</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Practice Card -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col relative">

                        <!-- Teal Title Bar -->
                        <div class="teal-bar text-white font-bold text-base py-3 px-8 rounded-t-xl mx-8 mt-8 flex justify-between items-center">
                            <span>Sample Question {{ $topicId }}:</span>
                        </div>

                        <div class="p-8 md:p-12 pt-6 flex-1 flex flex-col items-center text-center">

                            <!-- Instruction Box -->
                            <div class="w-full border border-gray-300 rounded-xl p-5 mb-6 text-left text-gray-700 text-base leading-relaxed">
                                You will hear a group discussion. After listening to it, in <strong>10 seconds</strong>, please summarize what you have just heard in your own words. You will have <strong>60 seconds</strong> to give your response.
                            </div>

                            <!-- Status Line -->
                            <div id="statusLine" class="w-full text-left font-bold text-gray-800 mb-4">
                                Play the audio to listen to the group discussion.
                            </div>

                            <!-- Audio Player -->
                            <div class="w-full mb-8">
                                <div class="audio-player-box shadow-sm">
                                    <button class="play-btn" id="playBtn" onclick="toggleAudio()">
                                        <svg id="playIconSvg" class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4l12 6-12 6z"></path>
                                        </svg>
                                    </button>

                                    <div class="progress-container">
                                        <span class="time-text" id="audioCurrentTime">00:00</span>
                                        <div class="progress-bar-bg">
                                            <div class="progress-bar-fill" id="audioProgressBar"></div>
                                            <div class="progress-handle" id="audioProgressHandle"></div>
                                        </div>
                                        <span class="time-text" id="audioTotalTime">--:--</span>
                                    </div>

                                    <div class="controls-right">
                                        <div class="relative" id="speedContainer">
                                            <button class="speed-btn" id="speedBtn" onclick="toggleSpeedDropdown(event)">
                                                <span id="speedLabel">1.0×</span>
                                                <svg class="w-4 h-4 transition-transform duration-200" id="speedChevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                            <div id="speedDropdown" class="speed-dropdown hidden">
                                                <button onclick="setSpeed(0.5, this)" class="speed-option">0.5× Slow</button>
                                                <button onclick="setSpeed(0.75, this)" class="speed-option">0.75×</button>
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

                            <!-- Prep Countdown (hidden initially) -->
                            <div id="prepBox" class="hidden w-full max-w-lg text-center mb-6">
                                <p class="text-gray-500 text-sm mb-2">Prepare to speak in...</p>
                                <div id="prepCountdown" class="text-5xl font-bold text-blue-500">10</div>
                                <p class="text-gray-400 text-xs mt-2">Recall what you heard and prepare your summary</p>
                            </div>

                            <!-- Recording Controls -->
                            <div id="recordingBox" class="hidden w-full max-w-lg bg-white rounded-2xl p-5 border border-blue-100 shadow-sm mb-6">
                                <div class="flex items-center gap-4">
                                    <div id="micCircle"
                                        style="width:48px;height:48px;border-radius:50%;background:#3b82f6;color:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                        </svg>
                                    </div>
                                    <div id="recCurrentTime" style="font-family:monospace;font-size:14px;font-weight:600;color:#374151;width:48px;text-align:center;">00:00</div>
                                    <div style="flex:1;height:12px;background:#bfdbfe;border-radius:9999px;overflow:hidden;">
                                        <div id="recProgressBar" style="width:0%;height:100%;background:#3b82f6;border-radius:9999px;transition:width 0.5s linear;"></div>
                                    </div>
                                    <div style="font-family:monospace;font-size:14px;font-weight:600;color:#374151;width:48px;text-align:center;">01:00</div>
                                </div>
                            </div>

                            <!-- Play Answer (after recording) -->
                            <div id="playAnswerBox" class="hidden w-full max-w-lg text-center mb-6">
                                <div class="flex justify-center items-center gap-4">
                                    <button id="playAnswerBtn" onclick="playAnswer()"
                                        style="background:#f3f4f6;color:#374151;font-weight:700;padding:12px 28px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                        ▶ Play My Answer
                                    </button>
                                    <button id="submitBtn" onclick="submitAudio()"
                                        style="background:#3b82f6;color:white;font-weight:700;padding:12px 28px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                                        Submit for AI Scoring
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center items-center gap-4 mt-2">
                                <button id="startBtn" onclick="startSession()"
                                    style="background:#3b82f6;color:white;font-weight:700;padding:12px 28px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 4px 6px rgba(0,0,0,0.1);transition:background 0.2s;">
                                    Practice with AI Scoring
                                </button>
                                <button id="restartBtn" onclick="restartSession()"
                                    style="display:none;background:white;color:#374151;font-weight:700;padding:12px 28px;border-radius:9999px;border:1px solid #d1d5db;cursor:pointer;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                    Restart
                                </button>
                            </div>

                            @if(!empty($topic['sample_answer']))
                            <!-- Sample Answer Toggle -->
                            <div class="w-full max-w-lg mx-auto mt-6 text-left">
                                <button id="sampleAnswerToggle" onclick="toggleSampleAnswer()"
                                    style="background:white;color:#2563eb;font-weight:700;padding:10px 20px;border-radius:9999px;border:1px solid #bfdbfe;cursor:pointer;font-size:14px;">
                                    Show Sample Answer
                                </button>
                                <div id="sampleAnswerBox" class="hidden mt-4 bg-white border border-blue-100 rounded-2xl p-5 text-left text-gray-700 text-sm leading-relaxed">
                                    {{ $topic['sample_answer'] }}
                                </div>
                            </div>
                            @endif

                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-12 py-6 border-t border-gray-100 flex justify-between items-center bg-white">
                            <a href="{{ route('assignments.pte-academic.speaking-writing.summarize-group-discussion.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-white transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 100</span>
                            <a href="{{ route('assignments.pte-academic.speaking-writing.summarize-group-discussion.practice', ['id' => min(100, $topicId + 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-all hover:shadow-lg flex items-center gap-2 {{ $topicId >= 100 ? 'pointer-events-none opacity-40' : '' }}">
                                Next Question
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Floating Button for Tips --}}
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
                            <div class="p-6 overflow-y-auto bg-white">
                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden">
                                    <div class="bg-white px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">Template Summarize Group Discussion</h4>
                                    </div>
                                    <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-2">
                                        <p>The main topic of the discussion was <span class="text-amber-600 font-bold">[Title]</span>.</p>
                                        <p>Initially, the first speaker talked about <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>He also addressed <span class="text-amber-600 font-bold">[ ___ ]</span> and explained <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>Furthermore, the second speaker mentioned <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>Moreover, he also shared ideas about <span class="text-amber-600 font-bold">[ ___ ]</span>, giving additional details about <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>Next, the third speaker contributed by discussing <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>Additionally, he elaborated on <span class="text-amber-600 font-bold">[ ___ ]</span>, for instance <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>After that, the focus was shifted to <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>Towards the end, another important point mentioned was <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>To conclude, the discussion highlighted important aspects such as <span class="text-amber-600 font-bold">[ ___ ]</span> and <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </main>
    </div>

    <!-- Audio elements -->
    @php
        $sgdAudioAbsPath = public_path('storage/kokoro-tts/summarize-group-discussion/sgd_topic_' . $topicId . '.mp3');
        $sgdCacheKey = file_exists($sgdAudioAbsPath) ? filemtime($sgdAudioAbsPath) : md5($topic['transcript'] ?? '');
        $sgdAudioUrl = asset('storage/kokoro-tts/summarize-group-discussion/sgd_topic_' . $topicId . '.mp3') . '?v=' . $sgdCacheKey;
    @endphp
    <audio id="lectureAudio" src="{{ $sgdAudioUrl }}"></audio>
    <audio id="answerAudio"></audio>

    <script>
        // ── DOM refs ──
        var lectureAudio    = document.getElementById('lectureAudio');
        var answerAudio     = document.getElementById('answerAudio');
        var playBtn         = document.getElementById('playBtn');
        var audioProgressBar = document.getElementById('audioProgressBar');
        var audioProgressHandle = document.getElementById('audioProgressHandle');
        var audioCurrentTime = document.getElementById('audioCurrentTime');
        var audioTotalTime   = document.getElementById('audioTotalTime');
        var statusLine      = document.getElementById('statusLine');
        var progressBarBg   = document.querySelector('.progress-bar-bg');
        var isDraggingProgress = false;
        var currentSpeed = 1.0;

        var PLAY_ICON_SVG  = '<svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>';
        var PAUSE_ICON_SVG = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
        var prepBox         = document.getElementById('prepBox');
        var prepCountdown   = document.getElementById('prepCountdown');
        var recordingBox    = document.getElementById('recordingBox');
        var micCircle       = document.getElementById('micCircle');
        var recCurrentTime  = document.getElementById('recCurrentTime');
        var recProgressBar  = document.getElementById('recProgressBar');
        var playAnswerBox   = document.getElementById('playAnswerBox');
        var playAnswerBtn   = document.getElementById('playAnswerBtn');
        var startBtn        = document.getElementById('startBtn');
        var restartBtn      = document.getElementById('restartBtn');
        var recordDirectBtn = document.getElementById('recordDirectBtn');
        var stopRecBtn      = document.getElementById('stopRecBtn');

        // ── State ──
        var state = 'idle';
        var prepTimer = null;
        var recTimer  = null;
        var recElapsed = 0;
        var recTotal   = 60; // SGD has 60 seconds
        var prepLeft   = 10;
        var mediaRecorder = null;
        var audioChunks   = [];
        var recordedMimeType = '';

        function pteGetSupportedMimeType() {
            var candidates = [
                'audio/webm;codecs=opus',
                'audio/webm',
                'audio/mp4',
                'audio/mp4;codecs=mp4a.40.2',
                'audio/aac',
                'audio/ogg;codecs=opus'
            ];
            for (var i = 0; i < candidates.length; i++) {
                if (window.MediaRecorder && MediaRecorder.isTypeSupported && MediaRecorder.isTypeSupported(candidates[i])) {
                    return candidates[i];
                }
            }
            return '';
        }
        var answerUrl     = null;

        // ── Audio listeners ──
        lectureAudio.addEventListener('loadedmetadata', function () {
            audioTotalTime.textContent = fmt(Math.floor(lectureAudio.duration));
        });
        lectureAudio.addEventListener('timeupdate', function () {
            if (isDraggingProgress) return;
            var cur = lectureAudio.currentTime;
            var dur = lectureAudio.duration || 0;
            audioCurrentTime.textContent = fmt(Math.floor(cur));
            if (dur > 0) {
                var perc = (cur / dur) * 100;
                audioProgressBar.style.width = perc + '%';
                audioProgressHandle.style.left = perc + '%';
            }
        });

        function seekAudioToClientX(clientX) {
            var dur = lectureAudio.duration;
            if (!dur) return;
            var rect = progressBarBg.getBoundingClientRect();
            var ratio = Math.max(0, Math.min(1, (clientX - rect.left) / rect.width));
            var newTime = ratio * dur;
            lectureAudio.currentTime = newTime;
            audioCurrentTime.textContent = fmt(Math.floor(newTime));
            audioProgressBar.style.width = (ratio * 100) + '%';
            audioProgressHandle.style.left = (ratio * 100) + '%';
        }

        progressBarBg.style.cursor = 'pointer';
        progressBarBg.addEventListener('mousedown', function (e) {
            isDraggingProgress = true;
            seekAudioToClientX(e.clientX);
        });
        document.addEventListener('mousemove', function (e) {
            if (!isDraggingProgress) return;
            seekAudioToClientX(e.clientX);
        });
        document.addEventListener('mouseup', function () {
            isDraggingProgress = false;
        });
        progressBarBg.addEventListener('touchstart', function (e) {
            isDraggingProgress = true;
            seekAudioToClientX(e.touches[0].clientX);
        });
        document.addEventListener('touchmove', function (e) {
            if (!isDraggingProgress) return;
            seekAudioToClientX(e.touches[0].clientX);
        });
        document.addEventListener('touchend', function () {
            isDraggingProgress = false;
        });

        function toggleSpeedDropdown(e) {
            e.stopPropagation();
            var dropdown = document.getElementById('speedDropdown');
            var chevron = document.getElementById('speedChevron');
            var btn = document.getElementById('speedBtn');
            var isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                var rect = btn.getBoundingClientRect();
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
            document.querySelectorAll('.speed-option').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            document.getElementById('speedDropdown').classList.add('hidden');
            document.getElementById('speedChevron').style.transform = '';
            lectureAudio.playbackRate = speed;
        }

        document.addEventListener('click', function (e) {
            var sc = document.getElementById('speedContainer');
            if (sc && !sc.contains(e.target)) {
                document.getElementById('speedDropdown').classList.add('hidden');
                document.getElementById('speedChevron').style.transform = '';
            }
        });
        lectureAudio.addEventListener('ended', function () {
            setPlayingUI(false);
            if (state === 'playing') {
                startPrep();
            }
        });

        function fmt(s) {
            s = Math.max(0, s);
            var m = Math.floor(s / 60), sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

        function setStatus(txt, color) {
            statusLine.textContent = txt;
            statusLine.style.color = color || '#2563eb';
        }

        function setPlayingUI(playing) {
            playBtn.innerHTML = playing ? PAUSE_ICON_SVG : PLAY_ICON_SVG;
        }

        function toggleAudio() {
            if (state === 'idle' || state === 'playing') {
                if (lectureAudio.paused) {
                    lectureAudio.playbackRate = currentSpeed;
                    lectureAudio.play();
                    state = 'playing';
                    setPlayingUI(true);
                    setStatus('Listening to group discussion... Take notes mentally.', '#2563eb');
                    startBtn.style.display = 'none';
                    restartBtn.style.display = 'inline-flex';
                } else {
                    lectureAudio.pause();
                    setPlayingUI(false);
                    setStatus('Paused. Click play to continue.', '#9ca3af');
                }
            }
        }

        function startSession() {
            restartSession();
            lectureAudio.playbackRate = currentSpeed;
            lectureAudio.play();
            state = 'playing';
            setPlayingUI(true);
            setStatus('Listening to group discussion... Take notes mentally.', '#2563eb');
            startBtn.style.display = 'none';
            restartBtn.style.display = 'inline-flex';
        }

        function startPrep() {
            state = 'prep';
            lectureAudio.pause();
            setPlayingUI(false);
            prepLeft = 10;
            prepBox.classList.remove('hidden');
            prepCountdown.textContent = prepLeft;
            setStatus('Prepare your summary...', '#ea580c');

            prepTimer = setInterval(function () {
                prepLeft--;
                prepCountdown.textContent = prepLeft;
                if (prepLeft <= 0) {
                    clearInterval(prepTimer);
                    startRecording();
                }
            }, 1000);
        }

        function startRecording() {
            prepBox.classList.add('hidden');
            recordingBox.classList.remove('hidden');
            state = 'recording';
            recElapsed = 0;
            setStatus('Recording your summary...', '#ef4444');
            micCircle.style.background = '#ef4444';
            micCircle.style.boxShadow  = '0 0 0 6px rgba(239,68,68,0.25)';

            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(function (stream) {
                    var mimeType = pteGetSupportedMimeType();
                    try {
                        mediaRecorder = mimeType ? new MediaRecorder(stream, { mimeType: mimeType }) : new MediaRecorder(stream);
                    } catch (e) {
                        mediaRecorder = new MediaRecorder(stream);
                    }
                    recordedMimeType = mediaRecorder.mimeType || mimeType || 'audio/webm';
                    audioChunks = [];
                    mediaRecorder.ondataavailable = function (e) {
                        if (e.data.size > 0) audioChunks.push(e.data);
                    };
                    mediaRecorder.onstop = function () {
                        var blob = new Blob(audioChunks, { type: recordedMimeType });
                        answerUrl = URL.createObjectURL(blob);
                        answerAudio.src = answerUrl;
                        stream.getTracks().forEach(function (t) { t.stop(); });
                        finishRecording();
                    };
                    mediaRecorder.start();

                    recTimer = setInterval(function () {
                        recElapsed++;
                        recCurrentTime.textContent = fmt(recElapsed);
                        recProgressBar.style.width = ((recElapsed / recTotal) * 100) + '%';
                        if (recElapsed >= recTotal) {
                            clearInterval(recTimer);
                            if (mediaRecorder && mediaRecorder.state !== 'inactive') mediaRecorder.stop();
                        }
                    }, 1000);
                })
                .catch(function () {
                    if (!window.MediaRecorder) {
                        alert('Your browser does not support audio recording. Please try a recent version of Chrome, Firefox, or Safari.');
                    } else {
                        alert('Microphone access is required. Please allow microphone access and try again.');
                    }
                    restartSession();
                });
        }

        function pteMimeTypeToExtension(mime) {
            if (!mime) return 'webm';
            mime = mime.toLowerCase();
            if (mime.indexOf('mp4') !== -1 || mime.indexOf('aac') !== -1) return 'm4a';
            if (mime.indexOf('ogg') !== -1) return 'ogg';
            if (mime.indexOf('wav') !== -1) return 'wav';
            if (mime.indexOf('mp3') !== -1) return 'mp3';
            return 'webm';
        }

        function manualStartRecording() {
            if (!lectureAudio.paused) {
                lectureAudio.pause();
                setPlayingUI(false);
            }
            clearInterval(prepTimer);
            clearInterval(recTimer);
            prepBox.classList.add('hidden');
            startRecording();
            if (recordDirectBtn) recordDirectBtn.style.display = 'none';
            if (startBtn) startBtn.style.display = 'none';
            if (stopRecBtn) stopRecBtn.style.display = 'inline-flex';
            if (restartBtn) restartBtn.style.display = 'inline-flex';
        }

        function manualStopRecording() {
            clearInterval(recTimer);
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
            if (stopRecBtn) stopRecBtn.style.display = 'none';
        }

        function finishRecording() {
            state = 'finished';
            recordingBox.classList.add('hidden');
            playAnswerBox.classList.remove('hidden');
            if (recordDirectBtn) recordDirectBtn.style.display = 'none';
            if (stopRecBtn) stopRecBtn.style.display = 'none';
            if (startBtn) startBtn.style.display = 'none';
            if (restartBtn) restartBtn.style.display = 'inline-flex';
            micCircle.style.background = '#9ca3af';
            micCircle.style.boxShadow  = 'none';
            setStatus('Recording complete! Submit for AI scoring or listen below.', '#16a34a');
            if (window.PTETracker) {
                PTETracker.saveResult({ score: 1, maxScore: 1, durationSeconds: recElapsed });
            }
        }

        async function submitAudio() {
            if (audioChunks.length === 0) return;

            var blob = new Blob(audioChunks, { type: recordedMimeType || 'audio/webm' });
            if (blob.size < 1000) {
                alert('No audio was captured. Please try recording again.');
                return;
            }
            var submitBtnEl = document.getElementById('submitBtn');
            submitBtnEl.disabled = true;
            submitBtnEl.textContent = 'Evaluating with AI...';

            var formData = new FormData();
            formData.append('audio', blob, 'recording.' + pteMimeTypeToExtension(recordedMimeType));
            formData.append('module', 'summarize-group-discussion');
            formData.append('topic_id', {{ $topicId }});
            formData.append('original_text', @json(($topic['transcript'] ?? '') . "\n" . ($topic['sample_answer'] ?? '')));

            try {
                const response = await fetch('/pte/practice/evaluate-speaking', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });
                const data = await response.json();
                submitBtnEl.disabled = false;
                submitBtnEl.textContent = 'Submit for AI Scoring';
                
                if (data.success && data.scores) {
                    PTEScorePopup.show({ 
                        skill: 'Speaking', 
                        score: data.scores.overall_score || 70, 
                        max: 90,
                        title: 'AI Scoring Complete!',
                        breakdown: {
                            'Content': data.scores.content_score || 70,
                            'Pronunciation': data.scores.pronunciation_score || 70,
                            'Oral_Fluency': data.scores.fluency_score || 70
                        },
                        feedback: data.scores.feedback || ('Transcription: ' + (data.transcription || ''))
                    });
                } else {
                    alert('Error scoring audio: ' + (data.message || 'Speech not recognized'));
                }
            } catch (error) {
                console.error('Error submitting audio:', error);
                submitBtnEl.disabled = false;
                submitBtnEl.textContent = 'Submit for AI Scoring';
                alert('Network error while submitting audio.');
            }
        }

        function playAnswer() {
            if (!answerUrl) return;
            if (answerAudio.paused) {
                answerAudio.play();
                playAnswerBtn.textContent = '⏸ Pause';
            } else {
                answerAudio.pause();
                playAnswerBtn.textContent = '▶ Play My Answer';
            }
        }

        answerAudio.onended = function () {
            playAnswerBtn.textContent = '▶ Play My Answer';
        };

        function toggleSampleAnswer() {
            var box = document.getElementById('sampleAnswerBox');
            var btn = document.getElementById('sampleAnswerToggle');
            if (!box) return;
            var isHidden = box.classList.contains('hidden');
            box.classList.toggle('hidden');
            btn.textContent = isHidden ? 'Hide Sample Answer' : 'Show Sample Answer';
        }

        function restartSession() {
            clearInterval(prepTimer);
            clearInterval(recTimer);
            if (mediaRecorder && mediaRecorder.state !== 'inactive') mediaRecorder.stop();
            if (!lectureAudio.paused) { lectureAudio.pause(); lectureAudio.currentTime = 0; }
            if (!answerAudio.paused) answerAudio.pause();

            state      = 'idle';
            recElapsed = 0;
            prepLeft   = 10;
            answerUrl  = null;
            audioChunks = [];
            audioProgressBar.style.width = '0%';
            audioProgressHandle.style.left = '0%';
            audioCurrentTime.textContent = '00:00';
            recCurrentTime.textContent   = '00:00';
            recProgressBar.style.width   = '0%';
            micCircle.style.background   = '#3b82f6';
            micCircle.style.boxShadow    = 'none';

            prepBox.classList.add('hidden');
            recordingBox.classList.add('hidden');
            playAnswerBox.classList.add('hidden');
            setPlayingUI(false);
            setStatus('Play the audio to listen to the group discussion.', '#2563eb');
            if (recordDirectBtn) recordDirectBtn.style.display = 'inline-flex';
            if (stopRecBtn) stopRecBtn.style.display = 'none';
            if (startBtn) startBtn.style.display    = 'inline-flex';
            if (restartBtn) restartBtn.style.display  = 'none';
        }
    </script>
    @include('components.pte-score-popup')
    @include('components.pte-practice-tracker', ['module' => 'summarize-group-discussion', 'topicId' => $topicId])
    <x-live-drawing />
</body>
</html>
