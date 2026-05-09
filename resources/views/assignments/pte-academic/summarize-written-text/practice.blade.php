<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Summarize Written Text - {{ $topic['title'] }} | Target Bahasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .resizable-box {
            resize: vertical !important;
            overflow: auto !important;
            min-height: 160px;
            display: block;
            width: 100%;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 1rem;
            line-height: 1.75;
            background: white;
            cursor: default;
        }
        .answer-box {
            resize: vertical !important;
            overflow: auto !important;
            min-height: 120px;
            display: block;
            width: 100%;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 1rem;
            line-height: 1.75;
        }
        .resizable-box:focus, .resizable-box:active {
            outline: none;
        }
        /* Timer pulse when under 2 minutes */
        @keyframes timerPulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
        }
        .timer-urgent { animation: timerPulse 1s ease-in-out infinite; color: #ef4444 !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
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
                    <a href="{{ route('assignments.pte-academic.speaking-writing.summarize-written-text.index') }}" class="inline-flex items-center text-gray-600 hover:text-emerald-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 text-white shadow-lg shadow-emerald-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Summarize Written Text</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="max-w-5xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col">

                        <!-- Top Bar: Timer + Word Count -->
                        <div class="flex items-center justify-between px-8 py-4 bg-emerald-50 border-b border-emerald-100">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-emerald-700">Time Remaining:</span>
                                <span id="timerDisplay" class="text-lg font-bold text-emerald-600 font-mono">10:00</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-sm text-gray-500">
                                    Word count: <span id="wordCount" class="font-bold text-emerald-600">0</span>
                                    <span class="text-gray-400 ml-1">(aim: 1 sentence, 5–75 words)</span>
                                </div>
                                <button id="submitBtn" onclick="submitAnswer()"
                                    class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-full text-sm shadow-md transition-colors">
                                    Submit
                                </button>
                            </div>
                        </div>

                        <div class="p-8 md:p-10 space-y-6">

                            <!-- Instruction -->
                            <div class="border border-gray-200 rounded-xl p-5 text-gray-700 text-sm leading-relaxed bg-gray-50">
                                Read the passage below and summarize it using <strong>one sentence</strong>. You have <strong>10 minutes</strong> to finish this task. Your response will be judged on the quality of your writing and on how well your response presents the key points in the passage.
                            </div>

                            <!-- Reading Passage (resizable) -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Reading Passage</h2>
                                    <span class="text-xs text-gray-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                        Drag bottom edge to resize
                                    </span>
                                </div>
                                <textarea
                                    readonly
                                    class="resizable-box border-2 border-gray-200 rounded-2xl p-6 text-gray-800 shadow-sm hover:border-emerald-300 focus:border-emerald-300 focus:outline-none transition-colors"
                                    style="background:white;">{{ $topic['passage'] ?? 'The passage for this topic will be available soon. This placeholder text represents the reading material that students will need to summarize. In the actual exam, a detailed paragraph or passage on a specific topic will appear here, and students must identify the key points and write a one-sentence summary that captures the main idea of the text accurately and concisely.' }}</textarea>
                            </div>

                            <!-- Answer Area (resizable) -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Your Summary</h2>
                                    <span class="text-xs text-gray-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                        Drag bottom edge to resize
                                    </span>
                                </div>
                                <textarea id="answerBox"
                                    class="answer-box w-full border-2 border-gray-200 rounded-2xl p-5 text-gray-800 text-base leading-relaxed shadow-sm hover:border-emerald-300 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition-colors"
                                    placeholder="Write your one-sentence summary here... Capture the main idea of the passage in a single, well-constructed sentence."
                                    oninput="updateWordCount(this)"></textarea>

                                <!-- Word count warning -->
                                <div id="wordWarning" class="hidden mt-2 text-xs text-amber-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span id="wordWarningText"></span>
                                </div>
                            </div>

                            <!-- Submit Result Box (shown after submit) -->
                            <div id="resultBox" class="hidden bg-emerald-50 border border-emerald-200 rounded-2xl p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-emerald-800 text-lg">Answer Submitted!</h3>
                                        <p class="text-emerald-700 text-sm mt-1">Your summary has been saved. Review it below:</p>
                                        <div id="submittedAnswer" class="mt-3 p-4 bg-white rounded-xl border border-emerald-200 text-gray-700 text-sm leading-relaxed italic"></div>
                                        <div id="submittedWordCount" class="mt-2 text-xs text-emerald-600 font-semibold"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-10 py-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <a href="{{ route('assignments.pte-academic.speaking-writing.summarize-written-text.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.speaking-writing.summarize-written-text.practice', ['id' => min(300, $topicId + 1)]) }}"
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
        // ── Timer ──
        var totalSeconds = 10 * 60; // 10 minutes
        var timerDisplay = document.getElementById('timerDisplay');
        var timerInterval = setInterval(function () {
            totalSeconds--;
            var m = Math.floor(totalSeconds / 60);
            var s = totalSeconds % 60;
            timerDisplay.textContent = (m < 10 ? '0'+m : m) + ':' + (s < 10 ? '0'+s : s);

            if (totalSeconds <= 120) {
                timerDisplay.classList.add('timer-urgent');
            }
            if (totalSeconds <= 0) {
                clearInterval(timerInterval);
                timerDisplay.textContent = '00:00';
                submitAnswer();
            }
        }, 1000);

        // ── Word Count ──
        function updateWordCount(el) {
            var text = el.value.trim();
            var words = text === '' ? 0 : text.split(/\s+/).length;
            document.getElementById('wordCount').textContent = words;

            var warning = document.getElementById('wordWarning');
            var warningText = document.getElementById('wordWarningText');

            if (words > 75) {
                warning.classList.remove('hidden');
                warningText.textContent = 'Your summary exceeds 75 words. Try to condense it into one concise sentence.';
                document.getElementById('wordCount').style.color = '#ef4444';
            } else if (words > 0 && words < 5) {
                warning.classList.remove('hidden');
                warningText.textContent = 'Your summary is too short. Aim for at least one complete sentence.';
                document.getElementById('wordCount').style.color = '#f59e0b';
            } else {
                warning.classList.add('hidden');
                document.getElementById('wordCount').style.color = '#059669';
            }
        }

        // ── Submit ──
        function submitAnswer() {
            clearInterval(timerInterval);
            var answer = document.getElementById('answerBox').value.trim();
            var words  = answer === '' ? 0 : answer.split(/\s+/).length;

            document.getElementById('answerBox').setAttribute('readonly', true);
            document.getElementById('answerBox').style.background = '#f9fafb';
            document.getElementById('submitBtn').style.display = 'none';

            if (answer === '') {
                answer = '(No answer provided)';
            }

            document.getElementById('submittedAnswer').textContent = '"' + answer + '"';
            document.getElementById('submittedWordCount').textContent = 'Word count: ' + words + ' words';
            document.getElementById('resultBox').classList.remove('hidden');
            document.getElementById('resultBox').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    </script>
</body>
</html>
