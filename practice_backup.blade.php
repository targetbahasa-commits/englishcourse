<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Write Essay - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .resizable-box {
            resize: vertical !important;
            overflow: auto !important;
            min-height: 80px;
            display: block;
            width: 100%;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 1rem;
            line-height: 1.75;
            background: white;
            cursor: default;
        }
        .essay-box {
            resize: vertical !important;
            overflow: auto !important;
            min-height: 280px;
            display: block;
            width: 100%;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 1rem;
            line-height: 1.85;
        }
        .resizable-box:focus { outline: none; }
        @keyframes timerPulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
        }
        .timer-urgent { animation: timerPulse 1s ease-in-out infinite; color: #ef4444 !important; }

        /* Teal accent to match reference screenshot */
        .teal-bar { background: #00c5b5; }
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
                    <a href="{{ route('assignments.pte-academic.speaking-writing.write-essay.index') }}" class="inline-flex items-center text-gray-600 hover:text-rose-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-rose-400 to-rose-600 text-white shadow-lg shadow-rose-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Write Essay</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="max-w-5xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col">

                        <!-- Teal Title Bar (matches reference) -->
                        <div class="teal-bar text-white font-bold text-base py-3 px-8">
                            Sample Question {{ $topicId }}:
                        </div>

                        <!-- Timer Bar -->
                        <div class="flex items-center justify-between px-8 py-4 bg-gray-50 border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold text-gray-700 text-sm">Remaining Time</span>
                                <span id="timerDisplay" class="font-bold font-mono text-lg" style="color:#00c5b5;">
                                    00 : 20 : 00
                                </span>
                                <span class="text-gray-400 text-sm">sec</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-sm text-gray-500">
                                    Words: <span id="wordCount" class="font-bold" style="color:#00c5b5;">0</span>
                                    <span class="text-gray-400 ml-1">(aim: 200–300)</span>
                                </div>
                                <button id="submitBtn" onclick="submitEssay()"
                                    class="px-5 py-2 text-white font-bold rounded-full text-sm shadow-md transition-colors"
                                    style="background:#00c5b5;">
                                    Submit
                                </button>
                            </div>
                        </div>

                        <div class="p-8 md:p-10 space-y-5">

                            <!-- Question / Prompt Box (resizable) -->
                            <div>
                                <textarea
                                    readonly
                                    class="resizable-box border-2 border-gray-200 rounded-xl p-5 text-gray-800 shadow-sm focus:outline-none"
                                    style="background:white; border-color:#e2e8f0;"
                                >{{ $topic['prompt'] ?? 'Do you agree that technology has had a more positive than negative impact on the quality of education? Discuss both views and give your own opinion. Write 200–300 words.' }}</textarea>
                            </div>

                            <!-- Essay Writing Box (resizable) -->
                            <div>
                                <textarea id="essayBox"
                                    class="essay-box border-2 border-gray-200 rounded-xl p-5 text-gray-800 shadow-sm focus:outline-none transition-colors"
                                    placeholder="Type your essay here..."
                                    style="border-color:#e2e8f0;"
                                    oninput="updateWordCount(this)"></textarea>

                                <!-- Word count feedback -->
                                <div class="flex items-center justify-between mt-2">
                                    <div id="wordWarning" class="text-xs text-gray-400"></div>
                                    <div id="wordProgress" class="w-48 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div id="wordProgressBar" class="h-full rounded-full transition-all" style="width:0%;background:#00c5b5;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Result -->
                            <div id="resultBox" class="hidden bg-rose-50 border border-rose-200 rounded-2xl p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-rose-800 text-lg">Essay Submitted!</h3>
                                        <p class="text-rose-600 text-sm mt-1" id="submittedWordCount"></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Action Buttons (matches reference) -->
                        <div class="px-8 md:px-10 pb-8 flex items-center gap-3">
                            <button id="startBtn"
                                class="px-6 py-2.5 text-white font-bold rounded-full text-sm shadow-md"
                                style="background:#00c5b5;">
                                Practice with AI Scoring
                            </button>
                            <button onclick="restartEssay()"
                                class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-full text-sm hover:bg-gray-50 transition">
                                Restart
                            </button>
                            <button id="startTimerBtn"
                                class="px-6 py-2.5 bg-white font-bold rounded-full text-sm border-2 transition"
                                style="color:#00c5b5; border-color:#00c5b5;">
                                Start
                            </button>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <a href="{{ route('assignments.pte-academic.speaking-writing.write-essay.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.speaking-writing.write-essay.practice', ['id' => min(300, $topicId + 1)]) }}"
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
        var totalSeconds = 20 * 60; // 20 minutes
        var timerDisplay = document.getElementById('timerDisplay');
        
        function fmtTimer(s) {
            var h = Math.floor(s / 3600);
            var m = Math.floor((s % 3600) / 60);
            var sec = s % 60;
            return (h < 10 ? '0'+h : h) + ' : ' + (m < 10 ? '0'+m : m) + ' : ' + (sec < 10 ? '0'+sec : sec);
        }

        var timerInterval = setInterval(function () {
            totalSeconds--;
            timerDisplay.textContent = fmtTimer(totalSeconds);

            if (totalSeconds <= 120) {
                timerDisplay.classList.add('timer-urgent');
            }
            if (totalSeconds <= 0) {
                clearInterval(timerInterval);
                submitEssay();
            }
        }, 1000);

        function updateWordCount(el) {
            var text  = el.value.trim();
            var words = text === '' ? 0 : text.split(/\s+/).length;
            document.getElementById('wordCount').textContent = words;

            // Progress bar (capped at 300 words = 100%)
            var pct = Math.min(100, (words / 300) * 100);
            var bar = document.getElementById('wordProgressBar');
            bar.style.width = pct + '%';

            // Color feedback
            var wc = document.getElementById('wordCount');
            var warn = document.getElementById('wordWarning');

            if (words < 50) {
                wc.style.color = '#9ca3af';
                warn.textContent = '';
                bar.style.background = '#d1d5db';
            } else if (words < 200) {
                wc.style.color = '#f59e0b';
                warn.textContent = 'Keep writing — aim for at least 200 words.';
                warn.style.color = '#f59e0b';
                bar.style.background = '#f59e0b';
            } else if (words <= 300) {
                wc.style.color = '#00c5b5';
                warn.textContent = '✓ Good length!';
                warn.style.color = '#00c5b5';
                bar.style.background = '#00c5b5';
            } else {
                wc.style.color = '#ef4444';
                warn.textContent = 'Over 300 words — consider trimming your essay.';
                warn.style.color = '#ef4444';
                bar.style.background = '#ef4444';
            }
        }

        function submitEssay() {
            clearInterval(timerInterval);
            var essay = document.getElementById('essayBox').value.trim();
            var words = essay === '' ? 0 : essay.split(/\s+/).length;

            document.getElementById('essayBox').setAttribute('readonly', true);
            document.getElementById('essayBox').style.background = '#f9fafb';
            document.getElementById('submitBtn').style.display = 'none';

            document.getElementById('submittedWordCount').textContent =
                'Your essay (' + words + ' words) has been submitted successfully.';
            document.getElementById('resultBox').classList.remove('hidden');
            document.getElementById('resultBox').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function restartEssay() {
            clearInterval(timerInterval);
            totalSeconds  = 20 * 60;
            timerDisplay.textContent = fmtTimer(totalSeconds);
            timerDisplay.classList.remove('timer-urgent');

            document.getElementById('essayBox').removeAttribute('readonly');
            document.getElementById('essayBox').value = '';
            document.getElementById('essayBox').style.background = '';
            document.getElementById('wordCount').textContent = '0';
            document.getElementById('wordCount').style.color = '#00c5b5';
            document.getElementById('wordWarning').textContent = '';
            document.getElementById('wordProgressBar').style.width = '0%';
            document.getElementById('wordProgressBar').style.background = '#00c5b5';
            document.getElementById('submitBtn').style.display = '';
            document.getElementById('resultBox').classList.add('hidden');
            document.getElementById('startBtn').style.opacity = '1';
            document.getElementById('startTimerBtn').style.opacity = '1';

            // Restart automatic timer
            timerInterval = setInterval(function () {
                totalSeconds--;
                timerDisplay.textContent = fmtTimer(totalSeconds);

                if (totalSeconds <= 120) {
                    timerDisplay.classList.add('timer-urgent');
                }
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    submitEssay();
                }
            }, 1000);
        }
    </script>
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 2], 'grammarLevel' => 'all'])
</body>
</html>
