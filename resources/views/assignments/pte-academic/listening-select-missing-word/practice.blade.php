<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listening: Select Missing Word - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $audioFile = 'kokoro-tts/select-missing-word/smw_topic_' . $topicId . '.mp3';
        $audioPath = public_path('storage/' . $audioFile);
        $audioSrc = asset('storage/' . $audioFile) . '?v=' . (file_exists($audioPath) ? filemtime($audioPath) : '1');
        $correctIndex = array_search($topic['correct_answer'], $topic['options']);
        $correctLetter = $correctIndex !== false ? chr(65 + $correctIndex) : 'A';
    @endphp

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

        /* Radio Option Styling (2 Column) */
        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .option-row {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .option-row:hover {
            border-color: #00c5b5;
            background-color: rgba(0, 197, 181, 0.02);
        }
        .custom-radio {
            appearance: none;
            -webkit-appearance: none;
            width: 22px;
            height: 22px;
            border: 2px solid #00c5b5;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            flex-shrink: 0;
            background-color: transparent;
        }
        .custom-radio:checked {
            border-color: #00c5b5;
        }
        .custom-radio:checked::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #00c5b5;
        }
        
        .option-row.selected {
            border-color: #00c5b5;
            background-color: rgba(0, 197, 181, 0.05);
        }

        .option-row.correct-answer {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.05);
        }
        .option-row.incorrect-answer {
            border-color: #ef4444;
            background-color: rgba(239, 68, 68, 0.05);
        }
        .option-row.missed-answer {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.05);
            border-style: dashed;
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

        <main class="flex-1 min-w-0 md:ml-64 p-4 md:p-8">
            <div class="container mx-auto">

                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-end mb-2">
                        <a href="{{ route('assignments.pte-academic.listening.listening-select-missing-word.index') }}#topic-{{ $topicId }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Back</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-400 to-purple-600 text-white shadow-lg shadow-purple-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Listening: Select Missing Word</h1>
                            <span id="pteAttemptBadge" class="hidden text-xs font-semibold px-2.5 py-1 rounded-full bg-white text-emerald-700"></span>
                            <span id="pteAvgScoreBadge" class="hidden text-xs font-semibold px-2.5 py-1 rounded-full bg-white text-emerald-700"></span>
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

                        <!-- Status Row -->
                        <div class="px-8 pt-4 pb-2">
                            <div class="font-bold text-gray-800">
                                Beginning in <span class="teal-text" id="prepTimer">5 sec</span>
                            </div>
                        </div>

                        <!-- Audio Player Area -->
                        <div class="px-8 pb-6">
                            <audio id="dictationAudio" preload="auto" src="{{ $audioSrc }}"></audio>
                            <div class="audio-player-box shadow-sm">
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
                                    <span class="time-text" id="totalTime">00:00</span>
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

                        <!-- Options Area -->
                        <div class="px-8 pb-8 options-grid" id="optionsContainer">
                            @foreach($topic['options'] as $index => $optionText)
                                @php $letter = chr(65 + $index); @endphp
                                <label class="option-row flex items-stretch gap-4 border border-teal-200 rounded-xl p-0 bg-white overflow-hidden">
                                    <div class="flex items-center pl-4 pr-2">
                                        <input type="radio" name="single_answer" class="custom-radio" value="{{ $letter }}">
                                    </div>
                                    <div class="w-10 flex items-center justify-center font-bold text-white text-lg flex-shrink-0" style="background:#00c5b5;">{{ $letter }}</div>
                                    <div class="py-3 pr-6 flex items-center">
                                        <span class="text-gray-800 text-[15px] font-medium">{{ $optionText }}</span>
                                    </div>
                                </label>
                            @endforeach
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
                            <button onclick="checkAnswer()" id="answerBtn"
                                class="px-6 py-2.5 bg-white font-bold rounded-full text-sm border-2 transition hover:bg-white"
                                style="color:#10b981; border-color:#10b981;">
                                Answer
                            </button>
                            <button id="startTimerBtn" onclick="startPrepTimer()"
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
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-white">
                            <a href="{{ route('assignments.pte-academic.listening.listening-select-missing-word.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-white transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.listening.listening-select-missing-word.practice', ['id' => min(300, $topicId + 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-all hover:shadow-lg flex items-center gap-2 {{ $topicId >= 300 ? 'pointer-events-none opacity-40' : '' }}">
                                Next Question
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        const correctAnswer = @json($correctLetter);
        const radios = document.querySelectorAll('input[name="single_answer"]');

        // Row highlighting logic
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove selected from all
                radios.forEach(r => {
                    r.closest('.option-row').classList.remove('selected');
                });
                
                // Add selected to checked
                if(this.checked) {
                    this.closest('.option-row').classList.add('selected');
                }
            });
        });

        // Speed Control
        let currentSpeed = 1.0;
        let isAudioPlaying = false;

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
            dictationAudio.playbackRate = currentSpeed;
        }

        document.addEventListener('click', function(e) {
            const sc = document.getElementById('speedContainer');
            if (sc && !sc.contains(e.target)) {
                document.getElementById('speedDropdown').classList.add('hidden');
                document.getElementById('speedChevron').style.transform = '';
            }
        });

        // Audio and Timer Logic
        let prepTimerInterval;
        let prepTime = 5;

        const dictationAudio = document.getElementById('dictationAudio');
        const prepTimerEl = document.getElementById('prepTimer');
        const playBtn = document.getElementById('playBtn');
        const currentTimeEl = document.getElementById('currentTime');
        const totalTimeEl = document.getElementById('totalTime');
        const progressBar = document.getElementById('progressBar');
        const progressHandle = document.getElementById('progressHandle');
        const startTimerBtn = document.getElementById('startTimerBtn');

        const PLAY_ICON_SVG = '<svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>';
        const PAUSE_ICON_SVG = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';

        function fmtTime(s) {
            s = Math.floor(s || 0);
            let m = Math.floor(s / 60);
            let sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

        dictationAudio.addEventListener('loadedmetadata', () => {
            totalTimeEl.textContent = fmtTime(dictationAudio.duration);
        });

        dictationAudio.addEventListener('timeupdate', () => {
            currentTimeEl.textContent = fmtTime(dictationAudio.currentTime);
            let perc = dictationAudio.duration ? (dictationAudio.currentTime / dictationAudio.duration) * 100 : 0;
            progressBar.style.width = perc + '%';
            progressHandle.style.left = perc + '%';
        });

        dictationAudio.addEventListener('ended', () => {
            playBtn.innerHTML = PLAY_ICON_SVG;
            document.getElementById('prepTimer').parentElement.innerHTML = 'Status: <span class="teal-text">Audio Completed</span>';
        });

        function startPrepTimer() {
            startTimerBtn.style.display = 'none';
            prepTime = 5;
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

        function startAudio() {
            document.getElementById('prepTimer').parentElement.innerHTML = 'Status: <span class="teal-text">Playing Audio</span>';
            playBtn.innerHTML = PAUSE_ICON_SVG;
            dictationAudio.currentTime = 0;
            dictationAudio.playbackRate = currentSpeed;
            dictationAudio.play().catch(err => console.error(err));
        }

        // Auto start
        window.addEventListener('load', () => {
            startPrepTimer();
        });

        // Scoring Logic
        function checkAnswer() {
            clearInterval(prepTimerInterval);
            dictationAudio.pause();

            let selectedValue = null;
            let selectedRadio = null;

            radios.forEach(radio => {
                radio.disabled = true;
                let row = radio.closest('.option-row');
                row.classList.remove('selected', 'correct-answer', 'incorrect-answer', 'missed-answer');

                if (radio.checked) {
                    selectedValue = radio.value;
                    selectedRadio = radio;
                }
                
                // Highlight correct answer if it wasn't selected
                if (radio.value === correctAnswer && !radio.checked) {
                    row.classList.add('missed-answer');
                }
            });

            let resultBox = document.getElementById('resultBox');
            let resultIconBox = document.getElementById('resultIconBox');
            let resultIcon = document.getElementById('resultIcon');
            let resultMessage = document.getElementById('resultMessage');
            let resultTitle = document.getElementById('resultTitle');

            resultBox.classList.remove('hidden');

            if (!selectedValue) {
                resultTitle.textContent = "No Answer Selected";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You did not select an option. The correct answer (Option " + correctAnswer + ") is marked with a dashed green border.";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
            } else if (selectedValue === correctAnswer) {
                selectedRadio.closest('.option-row').classList.add('correct-answer');
                resultTitle.textContent = "Perfect!";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>";
                resultMessage.textContent = "You selected the correct missing word! PTE awards 1 point for the correct answer.";
                resultMessage.className = "text-emerald-700 font-medium text-sm mt-1";
            } else {
                selectedRadio.closest('.option-row').classList.add('incorrect-answer');
                resultTitle.textContent = "Incorrect";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-red-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'></path>";
                resultMessage.textContent = "You selected the wrong option. The correct answer (Option " + correctAnswer + ") is highlighted in dashed green.";
                resultMessage.className = "text-red-700 font-medium text-sm mt-1";
            }
            
            
            var formData = new FormData();
            formData.append('module', 'listening-select-missing-word');
            formData.append('topic_id', '{{ $topicId }}');
            formData.append('score', (selectedValue === correctAnswer ? 1 : 0));
            formData.append('max_score', 1);

            fetch('/pte/practice/save-score', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: formData
            }).then(res => res.json()).then(data => {
                if (data.success) PTEScorePopup.show({ skill: 'Listening', score: data.scores.overall_score, max: 90 });
            }).catch(err => console.error(err));
        
            document.getElementById('answerBtn').style.opacity = '0.5';
            document.getElementById('answerBtn').style.pointerEvents = 'none';
        }

        function restartPractice() {
            clearInterval(prepTimerInterval);
            dictationAudio.pause();
            dictationAudio.currentTime = 0;

            currentTimeEl.textContent = "00:00";
            progressBar.style.width = '0%';
            progressHandle.style.left = '0%';
            playBtn.innerHTML = PLAY_ICON_SVG;

            document.getElementById('resultBox').classList.add('hidden');
            document.getElementById('answerBtn').style.opacity = '1';
            document.getElementById('answerBtn').style.pointerEvents = 'auto';

            radios.forEach(radio => {
                radio.checked = false;
                radio.disabled = false;
                let row = radio.closest('.option-row');
                row.classList.remove('selected', 'correct-answer', 'incorrect-answer', 'missed-answer');
            });

            startTimerBtn.style.display = 'inline-block';
            startPrepTimer();
        }
    </script>
    @include('components.pte-score-popup')
    @include('components.pte-practice-tracker', ['module' => 'listening-select-missing-word', 'topicId' => $topicId])
</body>
</html>
