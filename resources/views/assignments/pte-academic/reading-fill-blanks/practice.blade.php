<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reading: Fill in the Blanks - {{ $topic['title'] }} | Target Bahasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .teal-bar { background: #00c5b5; }
        .teal-text { color: #00c5b5; }
        
        .blank-space {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            height: 34px;
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
            border-radius: 4px;
            margin: 0 6px;
            vertical-align: middle;
            transition: all 0.2s;
        }
        
        .blank-space.drag-over {
            background-color: rgba(0, 197, 181, 0.1);
            border-color: #00c5b5;
            box-shadow: 0 0 0 2px rgba(0, 197, 181, 0.2);
        }

        .word-bank {
            min-height: 80px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .word-bank.drag-over {
            background-color: rgba(0, 197, 181, 0.05);
            border-color: #00c5b5;
        }

        .drag-word {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 16px;
            border: 1.5px solid #10b981; /* emerald-500 */
            color: #059669; /* emerald-600 */
            font-weight: 700;
            background-color: white;
            border-radius: 4px;
            cursor: move;
            user-select: none;
            transition: transform 0.1s, opacity 0.1s;
            font-size: 14px;
            height: 32px;
        }
        
        .drag-word:active {
            transform: scale(0.95);
        }

        .drag-word.dragging {
            opacity: 0.5;
        }

        /* Results styling */
        .blank-space.correct {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.1);
        }
        .blank-space.incorrect {
            border-color: #ef4444;
            background-color: rgba(239, 68, 68, 0.1);
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
                    <a href="{{ route('assignments.pte-academic.reading.reading-fill-blanks.index') }}" class="inline-flex items-center text-gray-600 hover:text-blue-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Reading: Fill in the Blanks</h1>
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
                        <div class="px-8 pb-4 pt-2">
                            <div class="border border-teal-200 rounded-xl p-8 bg-white" style="border-color: #00c5b5;">
                                <div class="text-gray-800 text-base leading-[2.5] font-medium" id="readingPassage">
                                    Coding languages, 
                                    <div class="blank-space dropzone" data-id="blank1"></div> 
                                    to modern technology, emerged from the convergence of mathematical logic and electronic engineering. Initially 
                                    <div class="blank-space dropzone" data-id="blank2"></div> 
                                    for specific tasks, they evolved to create complex systems and applications. Python, known for its simplicity and readability, has become widely used in 
                                    <div class="blank-space dropzone" data-id="blank3"></div> 
                                    fields from web development to data science. Moreover, it is constantly evolving and improving, as new features and enhancements are 
                                    <div class="blank-space dropzone" data-id="blank4"></div> 
                                    into the language and its library every year.
                                </div>
                            </div>
                        </div>

                        <!-- Word Bank Box -->
                        <div class="px-8 pb-8">
                            <div class="word-bank dropzone" id="wordBank">
                                <div class="drag-word" draggable="true" id="word-1" data-word="diverse">diverse</div>
                                <div class="drag-word" draggable="true" id="word-2" data-word="reverse">reverse</div>
                                <div class="drag-word" draggable="true" id="word-3" data-word="incorporated">incorporated</div>
                                <div class="drag-word" draggable="true" id="word-4" data-word="integral">integral</div>
                                <div class="drag-word" draggable="true" id="word-5" data-word="frugal">frugal</div>
                                <div class="drag-word" draggable="true" id="word-6" data-word="mixed">mixed</div>
                                <div class="drag-word" draggable="true" id="word-7" data-word="developed">developed</div>
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
                                    <div class="mt-3 text-sm text-gray-700 font-medium" id="correctAnswersList"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <a href="{{ route('assignments.pte-academic.reading.reading-fill-blanks.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.reading.reading-fill-blanks.practice', ['id' => min(300, $topicId + 1)]) }}"
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
        // Correct answers map for the blanks
        const correctAnswers = {
            'blank1': 'integral',
            'blank2': 'developed',
            'blank3': 'diverse',
            'blank4': 'incorporated'
        };

        const initialWordBankHTML = document.getElementById('wordBank').innerHTML;
        const initialPassageHTML = document.getElementById('readingPassage').innerHTML;

        // --- Drag and Drop Logic ---
        let draggedWord = null;

        function initializeDragAndDrop() {
            const words = document.querySelectorAll('.drag-word');
            const dropzones = document.querySelectorAll('.dropzone');

            words.forEach(word => {
                word.addEventListener('dragstart', function(e) {
                    draggedWord = this;
                    setTimeout(() => this.classList.add('dragging'), 0);
                    e.dataTransfer.effectAllowed = 'move';
                });

                word.addEventListener('dragend', function() {
                    this.classList.remove('dragging');
                    draggedWord = null;
                    dropzones.forEach(dz => dz.classList.remove('drag-over'));
                });
            });

            dropzones.forEach(zone => {
                zone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('drag-over');
                });

                zone.addEventListener('dragleave', function() {
                    this.classList.remove('drag-over');
                });

                zone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('drag-over');

                    if (draggedWord) {
                        // If dropping onto a blank space
                        if (this.classList.contains('blank-space')) {
                            // If blank is already occupied, move the existing word back to wordBank
                            if (this.children.length > 0) {
                                const existingWord = this.children[0];
                                document.getElementById('wordBank').appendChild(existingWord);
                            }
                            this.appendChild(draggedWord);
                        } 
                        // If dropping back to word bank
                        else if (this.classList.contains('word-bank')) {
                            this.appendChild(draggedWord);
                        }
                    }
                });
            });
        }

        initializeDragAndDrop();

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
            
            let blanks = document.querySelectorAll('.blank-space');
            let correctCount = 0;
            let answeredCount = 0;

            // Disable all drag items
            document.querySelectorAll('.drag-word').forEach(word => {
                word.setAttribute('draggable', false);
                word.style.cursor = 'default';
            });

            blanks.forEach(blank => {
                blank.classList.remove('correct', 'incorrect');
                let blankId = blank.getAttribute('data-id');
                let correctAnswer = correctAnswers[blankId];

                if (blank.children.length > 0) {
                    answeredCount++;
                    let userWord = blank.children[0].getAttribute('data-word');
                    
                    if (userWord === correctAnswer) {
                        correctCount++;
                        blank.classList.add('correct');
                        blank.children[0].style.borderColor = '#10b981'; // keep green
                    } else {
                        blank.classList.add('incorrect');
                        blank.children[0].style.borderColor = '#ef4444'; // turn red
                        blank.children[0].style.color = '#ef4444';
                    }
                }
            });

            // Show result
            let resultBox = document.getElementById('resultBox');
            let resultIconBox = document.getElementById('resultIconBox');
            let resultIcon = document.getElementById('resultIcon');
            let resultMessage = document.getElementById('resultMessage');
            let correctAnswersList = document.getElementById('correctAnswersList');
            
            resultBox.classList.remove('hidden');

            let totalBlanks = Object.keys(correctAnswers).length;

            if (correctCount === totalBlanks) {
                resultTitle.textContent = "Perfect!";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>";
                resultMessage.textContent = "You correctly filled all " + totalBlanks + " blanks in " + fmtTimer(secondsElapsed) + "!";
                resultMessage.className = "text-emerald-700 font-medium text-sm mt-1";
                correctAnswersList.textContent = "";
            } else {
                resultTitle.textContent = "Results Checked";
                resultIconBox.className = "w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500";
                resultIcon.innerHTML = "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>";
                resultMessage.textContent = "You got " + correctCount + " out of " + totalBlanks + " correct. " + (totalBlanks - answeredCount) + " blanks were left empty.";
                resultMessage.className = "text-amber-700 font-medium text-sm mt-1";
                
                let answersText = "Correct Answers: ";
                for (let [key, val] of Object.entries(correctAnswers)) {
                    answersText += "Blank " + key.replace('blank', '') + " = " + val + ", ";
                }
                correctAnswersList.textContent = answersText.slice(0, -2);
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
            document.getElementById('wordBank').innerHTML = initialWordBankHTML;
            document.getElementById('readingPassage').innerHTML = initialPassageHTML;

            // Re-bind drag events
            initializeDragAndDrop();
            startTimer();
        }
    </script>
</body>
</html>
