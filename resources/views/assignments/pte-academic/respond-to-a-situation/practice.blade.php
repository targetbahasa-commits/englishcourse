<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Respond to a Situation - {{ $topic['title'] }} | Target Bahasa</title>
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
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <div class="container mx-auto">

                <!-- Header with Back Button -->
                <div class="mb-8">
                    <a href="{{ route('assignments.pte-academic.speaking-writing.respond-to-a-situation.index') }}#topic-{{ $topicId }}" class="inline-flex items-center text-gray-600 hover:text-blue-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <h1 class="text-3xl font-bold text-gray-800">Respond to a Situation</h1>
                                <span id="pteAttemptBadge" class="hidden text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700"></span>
                                <span id="pteAvgScoreBadge" class="hidden text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700"></span>
                            </div>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                        <button id="pteBookmarkBtn" title="Bookmark" class="ml-auto text-gray-400 hover:text-yellow-400 transition-colors" data-bookmarked="0">
                            <svg id="pteBookmarkIcon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
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
                                You will hear and read a description of a situation. You will have <strong>20 seconds</strong> to think about what you want to say. You will then have <strong>40 seconds</strong> to give your response.
                            </div>

                            <!-- Prompt Box -->
                            @if(!empty($topic['prompt']))
                            <div class="w-full bg-gray-50 border border-gray-200 rounded-xl p-6 mb-6 text-left text-gray-800 text-lg leading-relaxed font-medium shadow-inner">
                                {{ $topic['prompt'] }}
                            </div>
                            @endif

                            <!-- Status Line -->
                            <div id="statusLine" class="w-full text-left font-bold text-gray-800 mb-4">
                                Play the audio to listen to the situation.
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
                            <div id="recordingBox" class="hidden w-full max-w-lg bg-blue-50 rounded-2xl p-5 border border-blue-100 shadow-sm mb-6">
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
                                <div id="sampleAnswerBox" class="hidden mt-4 bg-blue-50 border border-blue-100 rounded-2xl p-5 text-left text-gray-700 text-sm leading-relaxed">
                                    {{ $topic['sample_answer'] }}
                                </div>
                            </div>
                            @endif

                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-12 py-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <a href="{{ route('assignments.pte-academic.speaking-writing.respond-to-a-situation.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / {{ $totalTopics }}</span>
                            <a href="{{ route('assignments.pte-academic.speaking-writing.respond-to-a-situation.practice', ['id' => min($totalTopics, $topicId + 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-all hover:shadow-lg flex items-center gap-2 {{ $topicId >= $totalTopics ? 'pointer-events-none opacity-40' : '' }}">
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
                x: 0, 
                y: 0, 
                dragging: false,
                isDragged: false,
                startX: 0, startY: 0,
                init() {
                    this.x = window.innerWidth / 2 - 50;
                    this.y = window.innerHeight - 100;
                },
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
                    this.isDragged = true;
                    let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
                    this.x = clientX - this.startX;
                    this.y = clientY - this.startY;
                },
                end() {
                    this.dragging = false;
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
                        <div @click.away="showTips = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-gray-200">
                            <div class="flex items-center justify-between p-6 border-b border-blue-100 bg-blue-50">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-blue-900">Tips Respond to a Situation (RSit)</h2>
                                        <p class="text-blue-600 text-sm">Template jawaban speaking Anda.</p>
                                    </div>
                                </div>
                                <button @click="showTips = false" class="text-blue-400 hover:text-blue-600 hover:bg-blue-100 p-2 rounded-full transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="p-6 overflow-y-auto bg-white">
                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">Template Respond to a Situation</h4>
                                    </div>
                                    <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-2">
                                        <p class="text-sm text-red-600 mb-2 italic">Catatan: Pastikan kata "You" diganti menjadi "I", karena kita merespon situasi kita sendiri.</p>
                                        <p>Hi [Mr/Mrs], thank you for raising this concern / providing this opportunity.</p>
                                        <p>I see that <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>But the issue in question is that <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>According to me the best solution to this is <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>Alternatively, we could consider <span class="text-amber-600 font-bold">[ ___ ]</span>.</p>
                                        <p>Please advise what your thoughts are. I will be happy to proceed accordingly.</p>
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
        $rsAudioAbsPath = public_path('storage/audio/pte/respond-to-a-situation/questions/' . $topicId . '.mp3');
        $rsCacheKey = file_exists($rsAudioAbsPath) ? filemtime($rsAudioAbsPath) : md5($topic['transcript'] ?? (string) $topicId);
        $rsAudioUrl = asset('storage/audio/pte/respond-to-a-situation/questions/' . $topicId . '.mp3') . '?v=' . $rsCacheKey;
    @endphp
    <audio id="lectureAudio" src="{{ $rsAudioUrl }}"></audio>
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
        var audioLoadFailed = false;

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

        // ── State ──
        var state = 'idle';
        var prepTimer = null;
        var recTimer  = null;
        var recElapsed = 0;
        var recTotal   = 40; // RSit has 40 seconds
        var prepLeft   = 20;
        var mediaRecorder = null;
        var audioChunks   = [];
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
        lectureAudio.addEventListener('ended', function () {
            setPlayingUI(false);
            if (state === 'playing') {
                startPrep();
            }
        });
        lectureAudio.addEventListener('error', function () {
            audioLoadFailed = true;
            if (state === 'playing') {
                startPrep();
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
                if (!lectureAudio.getAttribute('src') || audioLoadFailed) {
                    startPrep();
                    return;
                }
                if (lectureAudio.paused) {
                    lectureAudio.playbackRate = currentSpeed;
                    lectureAudio.play();
                    state = 'playing';
                    setPlayingUI(true);
                    setStatus('Listening to the situation... Think about your response.', '#2563eb');
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
            if (!lectureAudio.getAttribute('src') || audioLoadFailed) {
                startPrep();
                return;
            }
            lectureAudio.playbackRate = currentSpeed;
            lectureAudio.play();
            state = 'playing';
            setPlayingUI(true);
            setStatus('Listening to the situation... Think about your response.', '#2563eb');
            startBtn.style.display = 'none';
            restartBtn.style.display = 'inline-flex';
        }

        function startPrep() {
            state = 'prep';
            lectureAudio.pause();
            setPlayingUI(false);
            prepLeft = 20;
            prepBox.classList.remove('hidden');
            prepCountdown.textContent = prepLeft;
            setStatus('Prepare your summary...', '#2563eb');

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
                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];
                    mediaRecorder.ondataavailable = function (e) {
                        if (e.data.size > 0) audioChunks.push(e.data);
                    };
                    mediaRecorder.onstop = function () {
                        var blob = new Blob(audioChunks, { type: 'audio/webm' });
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
                    alert('Microphone access is required. Please allow microphone access and try again.');
                    restartSession();
                });
        }

        function finishRecording() {
            state = 'finished';
            recordingBox.classList.add('hidden');
            playAnswerBox.classList.remove('hidden');
            micCircle.style.background = '#9ca3af';
            micCircle.style.boxShadow  = 'none';
            setStatus('Recording complete! Listen to your summary below.', '#16a34a');
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
            prepLeft   = 20;
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
            setStatus('Play the audio to listen to the situation.', '#2563eb');
            startBtn.style.display    = 'inline-flex';
            restartBtn.style.display  = 'none';
        }

        async function submitAudio() {
            if (audioChunks.length === 0) return;
            
            var blob = new Blob(audioChunks, { type: 'audio/webm' });
            var submitBtnEl = document.getElementById('submitBtn');
            submitBtnEl.disabled = true;
            submitBtnEl.textContent = 'Evaluating...';

            var formData = new FormData();
            formData.append('audio', blob, 'recording.webm');
            formData.append('module', 'respond-to-a-situation');
            formData.append('topic_id', {{ $topicId }});
            // respond to a situation uses the prompt + sample answer as context if available
            formData.append('original_text', `{{ addslashes(($topic['prompt'] ?? '') . "\n" . ($topic['sample_answer'] ?? '')) }}`);

            try {
                const response = await fetch('/pte/practice/evaluate-speaking', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                const data = await response.json();
                submitBtnEl.disabled = false;
                submitBtnEl.textContent = 'Submit for AI Scoring';
                
                if (data.success) {
                    PTEScorePopup.show({ 
                        skill: 'Speaking', 
                        score: data.scores.overall_score, 
                        max: 90,
                        title: 'AI Scoring Complete!',
                        message: 'Pronunciation: ' + data.scores.pronunciation_score + ' | Fluency: ' + data.scores.fluency_score + '<br><br>Transcription: ' + data.transcription
                    });
                } else {
                    alert('Error scoring audio: ' + data.message);
                }
            } catch (error) {
                console.error('Error submitting audio:', error);
                submitBtnEl.disabled = false;
                submitBtnEl.textContent = 'Submit for AI Scoring';
                alert('Network error while submitting audio.');
            }
        }
    </script>

    @include('components.pte-score-popup')
    @include('components.pte-practice-tracker', ['module' => 'respond-to-a-situation', 'topicId' => $topicId])
</body>
</html>
