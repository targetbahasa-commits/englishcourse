<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multiple Choice, Single Answer - {{ $topic['title'] }} | Target Bahasa</title>
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
        /* Custom Radio */
        .custom-radio {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
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
            background-color: #fff;
        }
        .custom-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #00c5b5;
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
                    <a href="{{ route('assignments.pte-academic.reading.multiple-choice-single-answer.index') }}" class="inline-flex items-center text-gray-600 hover:text-blue-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Multiple Choice, Single Answer</h1>
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

                        <!-- Reading Passage Box -->
                        <div class="px-8 pb-4">
                            <div class="border border-teal-200 rounded-xl p-8 bg-white shadow-sm" style="border-color: #00c5b5;">
                                <div class="text-gray-800 text-sm leading-[1.8] font-medium space-y-4">
                                    <p>B-15 broke off from the Ross Ice Shelf in Antarctica. It was the largest iceberg ever documented, with a surface area of more than 4,200 square miles - more than twice the size of the state of Delaware. After it started breaking up, the largest of its pieces, B-15a, drifted along the coast of Antarctica, lingered on a shallow seamount, and collided with an ice tongue, before running aground and breaking again. Late in 2007, the largest remaining chunk floated out into the South Pacific where, in the warmer water, it began to disintegrate. For the whole of the next year, the ocean was noisier than usual. All the way up past the equator, 4,350 miles or so away from where B-15a broke apart, hydrophones that scientists from the National Oceanic and Atmospheric Administration (NOAA) had suspended underwater were picking up strange signals. Another set of hydrophones, this one in the Juan Fernández Islands, off the coast of Chile, picked up the noise, too, even louder. When the scientists used the two sets of data to determine the source of the noise, they found the most likely culprits: B-15a and C-19a, another giant iceberg. Twenty years ago, not so long before B-15 broke off from Antarctica, "we didn't even know that icebergs made noise," says Haru Matsumoto, an ocean engineer at NOAA who has studied these sounds. But in the past few years, scientists have started to learn to distinguish the eerie, haunting sounds of iceberg life - ice cracking, icebergs grinding against each other, an iceberg grounding on the seafloor - and measure the extent to which those sounds contribute to the noise of the ocean. While they're just now learning to listen, the sounds of ice could help them understand the behavior and breakup of icebergs and ice shelves as the poles warm up.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question Area -->
                        <div class="px-8 pb-4">
                            <div class="border border-gray-200 rounded-xl p-4 bg-white shadow-sm text-center">
                                <p class="text-gray-700 font-medium">Where did the largest piece off from B-15 eventually go?</p>
                            </div>
                        </div>

                        <!-- Options Area -->
                        <div class="px-8 pb-8 space-y-3" id="optionsContainer">
                            <!-- Option A -->
                            <label class="option-row flex items-center gap-4 border border-teal-200 rounded-xl p-3 bg-white">
                                <input type="radio" name="single_choice" class="custom-radio" value="A">
                                <div class="w-10 h-10 flex items-center justify-center font-bold text-white text-lg flex-shrink-0" style="background:#00c5b5;">A</div>
                                <span class="text-gray-700 text-sm font-medium">Chile</span>
                            </label>

                            <!-- Option B -->
                            <label class="option-row flex items-center gap-4 border border-teal-200 rounded-xl p-3 bg-white">
                                <input type="radio" name="single_choice" class="custom-radio" value="B">
                                <div class="w-10 h-10 flex items-center justify-center font-bold text-white text-lg flex-shrink-0" style="background:#00c5b5;">B</div>
                                <span class="text-gray-700 text-sm font-medium">South Pacific</span>
                            </label>

                            <!-- Option C -->
                            <label class="option-row flex items-center gap-4 border border-teal-200 rounded-xl p-3 bg-white">
                                <input type="radio" name="single_choice" class="custom-radio" value="C">
                                <div class="w-10 h-10 flex items-center justify-center font-bold text-white text-lg flex-shrink-0" style="background:#00c5b5;">C</div>
                                <span class="text-gray-700 text-sm font-medium">Seafloor</span>
                            </label>

                            <!-- Option D -->
                            <label class="option-row flex items-center gap-4 border border-teal-200 rounded-xl p-3 bg-white">
                                <input type="radio" name="single_choice" class="custom-radio" value="D">
                                <div class="w-10 h-10 flex items-center justify-center font-bold text-white text-lg flex-shrink-0" style="background:#00c5b5;">D</div>
                                <span class="text-gray-700 text-sm font-medium">Antarctica</span>
                            </label>
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
                            <a href="{{ route('assignments.pte-academic.reading.multiple-choice-single-answer.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.reading.multiple-choice-single-answer.practice', ['id' => min(300, $topicId + 1)]) }}"
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
        // Set correct answer (example for this mockup: B - South Pacific)
        const correctAnswer = 'B';

        // Row highlighting logic for radios
        const radios = document.querySelectorAll('.custom-radio');
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove selected class from all rows
                document.querySelectorAll('.option-row').forEach(row => {
                    row.classList.remove('selected');
                });
                
                if(this.checked) {
                    this.closest('.option-row').classList.add('selected');
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
            
            let selectedValue = null;

            radios.forEach(radio => {
                let row = radio.closest('.option-row');
                let val = radio.value;
                let isChecked = radio.checked;
                let isCorrect = (val === correctAnswer);

                if (isChecked) {
                    selectedValue = val;
                }

                // Reset styles
                row.classList.remove('selected', 'correct-answer', 'incorrect-answer', 'missed-answer');
                radio.disabled = true;

                if (isChecked) {
                    if (isCorrect) {
                        row.classList.add('correct-answer'); // Green border
                    } else {
                        row.classList.add('incorrect-answer'); // Red border
                    }
                } else {
                    if (isCorrect) {
                        row.classList.add('missed-answer'); // Orange border for missed correct answer
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

            if (!selectedValue) {
                resultTitle.textContent = "No Answer Selected";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You did not select any option. The correct answer (marked in orange) was " + correctAnswer + ".";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
            } else if (selectedValue === correctAnswer) {
                resultTitle.textContent = "Correct!";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>";
                resultMessage.textContent = "You chose the correct answer in " + fmtTimer(secondsElapsed) + "!";
                resultMessage.className = "text-emerald-700 font-medium text-sm mt-1";
            } else {
                resultTitle.textContent = "Incorrect";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-red-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'></path>";
                resultMessage.textContent = "Your answer was incorrect. The correct answer was " + correctAnswer + ".";
                resultMessage.className = "text-red-700 font-medium text-sm mt-1";
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

            radios.forEach(radio => {
                radio.checked = false;
                radio.disabled = false;
                let row = radio.closest('.option-row');
                row.classList.remove('selected', 'correct-answer', 'incorrect-answer', 'missed-answer');
            });

            startTimer();
        }
    </script>
</body>
</html>
