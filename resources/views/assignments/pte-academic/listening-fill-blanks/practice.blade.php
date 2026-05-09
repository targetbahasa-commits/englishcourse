<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listening: Fill in the Blanks - {{ $topic['title'] }} | Target Bahasa</title>
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

        /* Blank Input Styling */
        .blank-input {
            border: none;
            border-bottom: 2px solid #374151; /* gray-700 */
            background-color: transparent;
            font-family: inherit;
            font-size: inherit;
            color: #111827; /* gray-900 */
            padding: 0 4px;
            margin: 0 4px;
            text-align: center;
            width: 140px;
            outline: none;
            transition: all 0.2s;
        }
        .blank-input:focus {
            border-bottom-color: #00c5b5;
            background-color: rgba(0, 197, 181, 0.05);
        }
        
        .blank-input.correct {
            border-bottom-color: #10b981;
            color: #10b981;
            background-color: rgba(16, 185, 129, 0.05);
            font-weight: bold;
        }
        .blank-input.incorrect {
            border-bottom-color: #ef4444;
            color: #ef4444;
            background-color: rgba(239, 68, 68, 0.05);
            text-decoration: line-through;
        }
        .correct-answer-text {
            color: #10b981;
            font-weight: bold;
            margin-left: 4px;
            display: none;
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
                    <a href="{{ route('assignments.pte-academic.listening.listening-fill-blanks.index') }}" class="inline-flex items-center text-gray-600 hover:text-purple-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-purple-400 to-purple-600 text-white shadow-lg shadow-purple-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Listening: Fill in the Blanks</h1>
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
                                    <span class="time-text">00:52</span>
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

                        <!-- Transcript Area -->
                        <div class="px-8 pb-8">
                            <div class="text-gray-700 text-[16px] leading-[2.5] font-medium">
                                Doctors have been concerned for a long time about people googling their symptoms. There's this term "Dr. Google," which is really frustrating to a lot of physicians, because people come in and think that they know what they have without having the actual 
                                <input type="text" class="blank-input" data-answer="diagnosis" autocomplete="off" spellcheck="false"><span class="correct-answer-text"></span>
                                , just by having looked up, "I have a headache. What does it mean?" GPT software is much better at actually being accurate in 
                                <input type="text" class="blank-input" data-answer="predicting" autocomplete="off" spellcheck="false"><span class="correct-answer-text"></span>
                                what patients have and asking sometimes follow-up questions that will help it further hone in on the correct diagnosis. Companies are starting to study this. And 
                                <input type="text" class="blank-input" data-answer="preliminary" autocomplete="off" spellcheck="false"><span class="correct-answer-text"></span>
                                research suggests the AIs are surprisingly accurate. Studies have shown that they work better than online 
                                <input type="text" class="blank-input" data-answer="symptom" autocomplete="off" spellcheck="false"><span class="correct-answer-text"></span>
                                checkers—which are websites that let you input your symptoms and spit out a diagnosis. They're also better than some 
                                <input type="text" class="blank-input" data-answer="practitioners" autocomplete="off" spellcheck="false"><span class="correct-answer-text"></span>
                                .
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
                            <button onclick="checkAnswers()" id="answerBtn"
                                class="px-6 py-2.5 bg-white font-bold rounded-full text-sm border-2 transition hover:bg-emerald-50"
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
                        <div id="resultBox" class="hidden bg-gray-50 border-t border-gray-200 p-6 px-8 mx-8 mb-8 rounded-xl">
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
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <a href="{{ route('assignments.pte-academic.listening.listening-fill-blanks.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.listening.listening-fill-blanks.practice', ['id' => min(300, $topicId + 1)]) }}"
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
        const inputs = document.querySelectorAll('.blank-input');
        
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

        // Audio and Timer Logic
        let prepTimerInterval;
        let audioPlayInterval;
        let prepTime = 5;
        let audioDuration = 52; // 00:52
        let audioCurrentTime = 0;
        
        const prepTimerEl = document.getElementById('prepTimer');
        const playBtn = document.getElementById('playBtn');
        const currentTimeEl = document.getElementById('currentTime');
        const progressBar = document.getElementById('progressBar');
        const progressHandle = document.getElementById('progressHandle');
        const startTimerBtn = document.getElementById('startTimerBtn');

        function fmtTime(s) {
            let m = Math.floor(s / 60);
            let sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

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

        function audioTick() {
            audioCurrentTime++;
            currentTimeEl.textContent = fmtTime(audioCurrentTime);
            let perc = (audioCurrentTime / audioDuration) * 100;
            progressBar.style.width = perc + '%';
            progressHandle.style.left = perc + '%';
            if(audioCurrentTime >= audioDuration) {
                clearInterval(audioPlayInterval);
                isAudioPlaying = false;
                playBtn.innerHTML = '<svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>';
                document.getElementById('prepTimer').parentElement.innerHTML = 'Status: <span class="teal-text">Audio Completed</span>';
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

        // Auto start
        window.addEventListener('load', () => {
            startPrepTimer();
        });

        // Scoring Logic
        function checkAnswers() {
            clearInterval(prepTimerInterval);
            clearInterval(audioPlayInterval);
            
            let correctCount = 0;
            let total = inputs.length;

            inputs.forEach(input => {
                input.disabled = true;
                let userAnswer = input.value.trim().toLowerCase();
                let correctAnswer = input.getAttribute('data-answer').toLowerCase();
                let textNode = input.nextElementSibling; // the correct-answer-text span

                input.classList.remove('correct', 'incorrect');
                textNode.style.display = 'none';

                if (userAnswer === correctAnswer) {
                    input.classList.add('correct');
                    correctCount++;
                } else {
                    input.classList.add('incorrect');
                    textNode.textContent = ' (' + correctAnswer + ')';
                    textNode.style.display = 'inline';
                }
            });

            // Show result
            let resultBox = document.getElementById('resultBox');
            let resultIconBox = document.getElementById('resultIconBox');
            let resultIcon = document.getElementById('resultIcon');
            let resultMessage = document.getElementById('resultMessage');
            let resultTitle = document.getElementById('resultTitle');

            resultBox.classList.remove('hidden');

            if (correctCount === total) {
                resultTitle.textContent = "Perfect!";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>";
                resultMessage.textContent = "You spelled every word correctly! (" + correctCount + "/" + total + ")";
                resultMessage.className = "text-emerald-700 font-medium text-sm mt-1";
            } else {
                resultTitle.textContent = "Results Checked";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You got " + correctCount + " out of " + total + " words correct. Check the corrections in green.";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
            }
            
            document.getElementById('answerBtn').style.opacity = '0.5';
            document.getElementById('answerBtn').style.pointerEvents = 'none';
        }

        function restartPractice() {
            clearInterval(prepTimerInterval);
            clearInterval(audioPlayInterval);
            
            currentTimeEl.textContent = "00:00";
            progressBar.style.width = '0%';
            progressHandle.style.left = '0%';
            playBtn.innerHTML = '<svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>';
            
            document.getElementById('resultBox').classList.add('hidden');
            document.getElementById('answerBtn').style.opacity = '1';
            document.getElementById('answerBtn').style.pointerEvents = 'auto';

            inputs.forEach(input => {
                input.value = '';
                input.disabled = false;
                input.classList.remove('correct', 'incorrect');
                input.nextElementSibling.style.display = 'none';
            });

            startTimerBtn.style.display = 'inline-block';
            startPrepTimer();
        }
    </script>
</body>
</html>
