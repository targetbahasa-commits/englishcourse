<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reading & Writing: Fill in the Blanks - {{ $topic['title'] }} | Target Bahasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .teal-bar { background: #00c5b5; }
        .teal-text { color: #00c5b5; }
        .pte-select {
            appearance: none;
            -webkit-appearance: none;
            border: none;
            border-bottom: 2px solid #00c5b5;
            color: #00c5b5;
            background: transparent;
            font-size: 1rem;
            padding: 0 24px 2px 8px;
            margin: 0 4px;
            cursor: pointer;
            outline: none;
            font-family: inherit;
            min-width: 140px;
            background-image: url("data:image/svg+xml,%3Csvg w='12' h='12' fill='none' stroke='%2300c5b5' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 4px center;
            background-size: 14px;
            transition: all 0.2s ease;
        }
        .pte-select:hover {
            background-color: rgba(0, 197, 181, 0.05);
        }
        .pte-select:focus {
            background-color: rgba(0, 197, 181, 0.1);
            border-bottom-width: 3px;
        }
        .pte-select option {
            color: #374151; /* gray-700 */
        }
        
        /* Dropdown states */
        .pte-select.answered {
            color: #374151;
            border-bottom-color: #d1d5db;
            background-image: url("data:image/svg+xml,%3Csvg w='12' h='12' fill='none' stroke='%239ca3af' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        }
        .pte-select.correct {
            color: #10b981;
            border-bottom-color: #10b981;
            background-image: url("data:image/svg+xml,%3Csvg w='12' h='12' fill='none' stroke='%2310b981' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'%3E%3C/path%3E%3C/svg%3E");
            background-size: 16px;
        }
        .pte-select.incorrect {
            color: #ef4444;
            border-bottom-color: #ef4444;
            background-image: url("data:image/svg+xml,%3Csvg w='12' h='12' fill='none' stroke='%23ef4444' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'%3E%3C/path%3E%3C/svg%3E");
            background-size: 14px;
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
                    <a href="{{ route('assignments.pte-academic.reading.reading-writing-fill-blanks.index') }}" class="inline-flex items-center text-gray-600 hover:text-blue-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Reading & Writing: Fill in the Blanks</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="max-w-6xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col">

                        <!-- Teal Title Bar (matches reference) -->
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
                        <div class="px-8 pb-8">
                            <div class="border border-teal-400 rounded-xl p-8 bg-white shadow-sm" style="border-color: #00c5b5;">
                                <p class="text-gray-800 text-lg leading-[2.5] font-medium" id="readingPassage">
                                    At the height of summer the Antarctic, tourist ships move gently around the coast. Even 30 years ago such sights would have been unthinkable, but today people are willing to pay large sums of money to see the last real wilderness in the world. In the Arctic, careless human exploitation 
                                    <select class="pte-select" data-answer="has damaged">
                                        <option value="" disabled selected>Select Answer</option>
                                        <option value="have damaged">have damaged</option>
                                        <option value="has damaged">has damaged</option>
                                        <option value="damaging">damaging</option>
                                        <option value="damage">damage</option>
                                    </select> 
                                    the fragile ecosystem. Today concerned governments are trying to find ways to develop the region 
                                    <select class="pte-select" data-answer="in the future">
                                        <option value="" disabled selected>Select Answer</option>
                                        <option value="in the future">in the future</option>
                                        <option value="ever before">ever before</option>
                                        <option value="in the past">in the past</option>
                                        <option value="on one side">on one side</option>
                                    </select> 
                                    special natural environment. 
                                    <select class="pte-select" data-answer="Although">
                                        <option value="" disabled selected>Select Answer</option>
                                        <option value="Because">Because</option>
                                        <option value="Since">Since</option>
                                        <option value="Although">Although</option>
                                        <option value="When">When</option>
                                    </select> 
                                    the Antarctic is less accessible than the Arctic, it is still largely undamaged by humans, although the ozone layer above the Antarctic 
                                    <select class="pte-select" data-answer="has thinned">
                                        <option value="" disabled selected>Select Answer</option>
                                        <option value="has thinned">has thinned</option>
                                        <option value="thinning">thinning</option>
                                        <option value="thinned">thinned</option>
                                        <option value="have thinned">have thinned</option>
                                    </select>. 
                                    Many people believe that one way to preserve the area is to make the whole region into a world park, with every form of exploitation internationally 
                                    <select class="pte-select" data-answer="banned">
                                        <option value="" disabled selected>Select Answer</option>
                                        <option value="banning">banning</option>
                                        <option value="banned">banned</option>
                                        <option value="ban">ban</option>
                                        <option value="to ban">to ban</option>
                                    </select>.
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons (matches reference) -->
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
                                class="px-6 py-2.5 bg-white font-bold rounded-full text-sm border-2 transition"
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
                            <a href="{{ route('assignments.pte-academic.reading.reading-writing-fill-blanks.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.reading.reading-writing-fill-blanks.practice', ['id' => min(300, $topicId + 1)]) }}"
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
        // Setup dropdown styling logic
        const selects = document.querySelectorAll('.pte-select');
        selects.forEach(select => {
            select.addEventListener('change', function() {
                if (this.value !== "") {
                    this.classList.add('answered');
                } else {
                    this.classList.remove('answered');
                }
                this.classList.remove('correct', 'incorrect');
            });
        });

        // Setup up-counting timer
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

        // Start timer immediately
        startTimer();

        function checkAnswers() {
            clearInterval(timerInterval);
            
            let correctCount = 0;
            let totalCount = selects.length;
            let allAnswered = true;

            selects.forEach(select => {
                let correctAnswer = select.getAttribute('data-answer');
                let userAnswer = select.value;

                select.classList.remove('answered', 'correct', 'incorrect');

                if (userAnswer === "") {
                    allAnswered = false;
                } else if (userAnswer === correctAnswer) {
                    correctCount++;
                    select.classList.add('correct');
                } else {
                    select.classList.add('incorrect');
                }
                
                // Disable to prevent changing after checking
                select.disabled = true;
            });

            // Show result
            let resultBox = document.getElementById('resultBox');
            let resultIconBox = document.getElementById('resultIconBox');
            let resultIcon = document.getElementById('resultIcon');
            let resultMessage = document.getElementById('resultMessage');

            resultBox.classList.remove('hidden');

            if (correctCount === totalCount) {
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>";
                resultMessage.textContent = "Perfect! You got " + correctCount + " out of " + totalCount + " correct in " + fmtTimer(secondsElapsed) + ".";
                resultMessage.className = "text-emerald-700 font-medium text-sm mt-1";
            } else {
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You got " + correctCount + " out of " + totalCount + " correct in " + fmtTimer(secondsElapsed) + ". Review the incorrect answers marked in red.";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
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

            selects.forEach(select => {
                select.value = "";
                select.disabled = false;
                select.classList.remove('answered', 'correct', 'incorrect');
            });

            startTimer();
        }
    </script>
</body>
</html>
