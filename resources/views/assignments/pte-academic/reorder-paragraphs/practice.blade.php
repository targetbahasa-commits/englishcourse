<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Re-order Paragraphs - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
                    <a href="{{ route('assignments.pte-academic.reading.reorder-paragraphs.index') }}" class="inline-flex items-center text-gray-600 hover:text-blue-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
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
                                        
                                        <!-- Draggable Item A -->
                                        <div class="drag-item flex items-stretch border border-teal-200 rounded-lg overflow-hidden bg-white hover:shadow-md" draggable="true" id="item-a" data-id="A">
                                            <div class="w-12 flex items-center justify-center font-bold text-white text-lg flex-shrink-0 teal-bar">A</div>
                                            <div class="p-4 text-gray-700 text-sm font-medium flex-1">
                                                Globalization has increased the popularity of international cuisines.
                                            </div>
                                        </div>

                                        <!-- Draggable Item B -->
                                        <div class="drag-item flex items-stretch border border-teal-200 rounded-lg overflow-hidden bg-white hover:shadow-md" draggable="true" id="item-b" data-id="B">
                                            <div class="w-12 flex items-center justify-center font-bold text-white text-lg flex-shrink-0 teal-bar">B</div>
                                            <div class="p-4 text-gray-700 text-sm font-medium flex-1">
                                                This curiosity has led to a rise in ethnic restaurants and food festivals.
                                            </div>
                                        </div>

                                        <!-- Draggable Item C -->
                                        <div class="drag-item flex items-stretch border border-teal-200 rounded-lg overflow-hidden bg-white hover:shadow-md" draggable="true" id="item-c" data-id="C">
                                            <div class="w-12 flex items-center justify-center font-bold text-white text-lg flex-shrink-0 teal-bar">C</div>
                                            <div class="p-4 text-gray-700 text-sm font-medium flex-1">
                                                Yet, this trend also challenges traditional food industries to innovate and adapt to changing consumer preferences.
                                            </div>
                                        </div>

                                        <!-- Draggable Item D -->
                                        <div class="drag-item flex items-stretch border border-teal-200 rounded-lg overflow-hidden bg-white hover:shadow-md" draggable="true" id="item-d" data-id="D">
                                            <div class="w-12 flex items-center justify-center font-bold text-white text-lg flex-shrink-0 teal-bar">D</div>
                                            <div class="p-4 text-gray-700 text-sm font-medium flex-1">
                                                People are now more adventurous in their food choices, exploring dishes from different cultures.
                                            </div>
                                        </div>

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
                                    <div id="targetContainer" class="flex-1 border-2 border-teal-200 border-t-0 rounded-b-xl p-4 min-h-[300px] flex flex-col gap-3 bg-gray-50 transition-colors" ondragover="allowDrop(event)" ondrop="drop(event, 'target')">
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
                                    <p class="text-gray-800 font-medium text-sm mt-3" id="correctOrderMessage"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <a href="{{ route('assignments.pte-academic.reading.reorder-paragraphs.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
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
        </main>
    </div>

    <script>
        // Set correct order (example for this mockup: A -> D -> B -> C)
        const correctOrder = ['A', 'D', 'B', 'C'];
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
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 1], 'grammarLevel' => 'all'])
</body>
</html>
