<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multiple Choice, Multiple Answer - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .teal-bar { background: #00c5b5; }
        .teal-text { color: #00c5b5; }
        .option-row {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .option-row:hover {
            border-color: #00c5b5;
            background-color: rgba(0, 197, 181, 0.02);
        }
        /* Custom Checkbox */
        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #9ca3af;
            border-radius: 4px;
            outline: none;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .custom-checkbox:checked {
            border-color: #00c5b5;
        }
        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 6px;
            width: 5px;
            height: 10px;
            border: solid #00c5b5;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        /* State styling when selected */
        .option-row.selected {
            border-color: #00c5b5;
            background-color: rgba(0, 197, 181, 0.05);
        }

        /* Results styling */
        .option-row.correct-answer {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.05);
        }
        .option-row.incorrect-answer {
            border-color: #ef4444;
            background-color: rgba(239, 68, 68, 0.05);
        }
        .option-row.missed-answer {
            border-color: #f59e0b;
            background-color: rgba(245, 158, 11, 0.05);
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
                        <a href="{{ route('assignments.pte-academic.reading.multiple-choice-multiple-answer.index') }}#topic-{{ $topicId }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Back</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Multiple Choice, Multiple Answer</h1>
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
                        <div class="px-8 pb-4">
                            <div class="border border-teal-400 rounded-xl p-8 bg-white shadow-sm" style="border-color: #00c5b5;">
                                <div class="text-gray-800 text-sm leading-[1.8] font-medium space-y-4">
                                    <p>{{ $topic['passage'] }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question Area -->
                        <div class="px-8 pb-4">
                            <div class="border border-gray-200 rounded-xl p-4 bg-white shadow-sm text-center">
                                <p class="text-gray-700 font-medium">{{ $topic['question'] }}</p>
                            </div>
                        </div>

                        <!-- Options Area -->
                        <div class="px-8 pb-8 space-y-3" id="optionsContainer">
                            @foreach($topic['options'] as $index => $optionText)
                                @php $letter = chr(65 + $index); @endphp
                                <label class="option-row flex items-center gap-4 border border-teal-200 rounded-xl p-3 bg-white">
                                    <input type="checkbox" class="custom-checkbox" value="{{ $letter }}">
                                    <div class="w-10 h-10 flex items-center justify-center font-bold text-white text-lg flex-shrink-0" style="background:#00c5b5;">{{ $letter }}</div>
                                    <span class="text-gray-700 text-sm font-medium">{{ $optionText }}</span>
                                </label>
                            @endforeach
                        </div>

                        <!-- Action Buttons (matches reference) -->
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
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-white">
                            <a href="{{ route('assignments.pte-academic.reading.multiple-choice-multiple-answer.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-white transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.reading.multiple-choice-multiple-answer.practice', ['id' => min(300, $topicId + 1)]) }}"
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
        const correctAnswers = @json($topic['answers']);

        // Row highlighting logic
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const row = this.closest('.option-row');
                if(this.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
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
            
            let selectedCount = 0;
            let correctSelectedCount = 0;
            let incorrectSelectedCount = 0;

            checkboxes.forEach(cb => {
                let row = cb.closest('.option-row');
                let val = cb.value;
                let isChecked = cb.checked;
                let isCorrect = correctAnswers.includes(val);

                // Reset styles
                row.classList.remove('selected', 'correct-answer', 'incorrect-answer', 'missed-answer');
                cb.disabled = true;

                if (isChecked) {
                    selectedCount++;
                    if (isCorrect) {
                        correctSelectedCount++;
                        row.classList.add('correct-answer'); // Green border
                    } else {
                        incorrectSelectedCount++;
                        row.classList.add('incorrect-answer'); // Red border
                    }
                } else {
                    if (isCorrect) {
                        row.classList.add('missed-answer'); // Orange border for missed correct answers
                    }
                }
            });

            // Show result
            let resultBox = document.getElementById('resultBox');
            let resultIconBox = document.getElementById('resultIconBox');
            let resultIcon = document.getElementById('resultIcon');
            let resultMessage = document.getElementById('resultMessage');
            let resultTitle = document.getElementById('resultTitle');

            resultBox.classList.remove('hidden');

            // PTE Multiple Answer scoring: +1 for correct, -1 for incorrect, min 0.
            let pteScore = Math.max(0, correctSelectedCount - incorrectSelectedCount);
            let pteMax = correctAnswers.length;

            if (selectedCount === 0) {
                resultTitle.textContent = "No Answers Selected";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You did not select any options. The correct answers (marked in orange) were: " + correctAnswers.join(', ') + ".";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
            } else if (correctSelectedCount === correctAnswers.length && incorrectSelectedCount === 0) {
                resultTitle.textContent = "Perfect!";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>";
                resultMessage.textContent = "You found all the correct answers in " + fmtTimer(secondsElapsed) + "!";
                resultMessage.className = "text-emerald-700 font-medium text-sm mt-1";
            } else {
                resultTitle.textContent = "Results Checked";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You selected " + correctSelectedCount + " correct and " + incorrectSelectedCount + " incorrect options. (PTE Score: " + pteScore + "/" + pteMax + "). Review the highlights above.";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
            }

            PTEScorePopup.show({ skill: 'Reading', score: pteScore, max: pteMax });
            if (window.PTETracker) {
                PTETracker.saveResult({ score: pteScore, maxScore: pteMax, durationSeconds: secondsElapsed });
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

            checkboxes.forEach(cb => {
                cb.checked = false;
                cb.disabled = false;
                let row = cb.closest('.option-row');
                row.classList.remove('selected', 'correct-answer', 'incorrect-answer', 'missed-answer');
            });

            startTimer();
        }
    </script>
    @include('components.pte-score-popup')
    @include('components.pte-practice-tracker', ['module' => 'multiple-choice-multiple-answer', 'topicId' => $topicId])
    <x-live-drawing />
</body>
</html>
