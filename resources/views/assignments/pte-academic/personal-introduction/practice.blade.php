<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Introduction | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
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

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <div class="container mx-auto">

                <!-- Header with Back Button -->
                <div class="mb-8">
                    <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}" class="inline-flex items-center text-gray-600 hover:text-blue-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Personal Introduction</h1>
                            <p class="text-gray-500">PTE Academic Practice</p>
                        </div>
                    </div>
                </div>

                <!-- Main Practice Card -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col relative">

                        <div class="p-8 md:p-12 flex-1 flex flex-col items-center text-center">

                            <!-- Instruction Box -->
                            <div class="w-full border border-gray-300 rounded-xl p-5 mb-8 text-left text-gray-700 text-base leading-relaxed bg-gray-50">
                                Read the prompt below. In <strong>25 seconds</strong>, you must reply in your own words, as naturally and clearly as possible. You have <strong>30 seconds</strong> to record your response. Your response will be sent together with your score report to the institutions selected by you. This item is not scored.
                            </div>

                            <div class="w-full border border-blue-200 rounded-xl p-5 mb-8 text-left text-gray-800 font-medium text-lg leading-relaxed shadow-sm bg-blue-50">
                                Please introduce yourself. For example, you could talk about one or more of the following:
                                <ul class="list-disc ml-6 mt-3 space-y-1 text-gray-600 text-base font-normal">
                                    <li>Your interests</li>
                                    <li>Your plans for future study</li>
                                    <li>Why you want to study abroad</li>
                                    <li>Why you need to learn English</li>
                                    <li>Why you chose this test</li>
                                </ul>
                            </div>

                            <!-- Status Line -->
                            <div id="statusLine" class="text-base font-semibold mb-6" style="color:#3b82f6;">
                                Click Start to begin the 25-second preparation.
                            </div>

                            <!-- Prep Countdown -->
                            <div id="prepBox" class="hidden w-full max-w-lg text-center mb-6">
                                <p class="text-gray-500 text-sm mb-2">Prepare to speak in...</p>
                                <div id="prepCountdown" class="text-5xl font-bold text-blue-500">25</div>
                            </div>

                            <!-- Recording Controls -->
                            <div id="recordingBox" class="hidden w-full max-w-lg bg-blue-50 rounded-2xl p-5 border border-blue-100 shadow-sm mb-6">
                                <p class="text-center text-blue-700 font-semibold text-sm mb-4">Recording... Please speak now</p>
                                <div class="flex items-center gap-4">
                                    <div id="micCircle"
                                        style="width:48px;height:48px;border-radius:50%;background:#ef4444;color:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                        </svg>
                                    </div>
                                    <div id="recCurrentTime" style="font-family:monospace;font-size:14px;font-weight:600;color:#374151;width:48px;text-align:center;">00:00</div>
                                    <div style="flex:1;height:12px;background:#dbeafe;border-radius:9999px;overflow:hidden;">
                                        <div id="recProgressBar" style="width:0%;height:100%;background:#3b82f6;border-radius:9999px;transition:width 0.5s linear;"></div>
                                    </div>
                                    <div style="font-family:monospace;font-size:14px;font-weight:600;color:#374151;width:48px;text-align:center;">00:30</div>
                                </div>
                            </div>

                            <!-- Play Answer (after recording) -->
                            <div id="playAnswerBox" class="hidden w-full max-w-lg text-center mb-6">
                                <button id="playAnswerBtn" onclick="playAnswer()"
                                    style="background:#3b82f6;color:white;font-weight:700;padding:12px 28px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                                    ▶ Play My Answer
                                </button>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center items-center gap-4 mt-2">
                                <button id="startBtn" onclick="startPrep()"
                                    style="background:#3b82f6;color:white;font-weight:700;padding:12px 28px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 4px 6px rgba(0,0,0,0.1);transition:background 0.2s;">
                                    Start Practice
                                </button>
                                <button id="restartBtn" onclick="restartSession()"
                                    style="display:none;background:white;color:#374151;font-weight:700;padding:12px 28px;border-radius:9999px;border:1px solid #d1d5db;cursor:pointer;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                    Restart
                                </button>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>

    <audio id="answerAudio"></audio>

    <script>
        var answerAudio     = document.getElementById('answerAudio');
        var statusLine      = document.getElementById('statusLine');
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

        var state = 'idle';
        var prepTimer = null;
        var recTimer  = null;
        var recElapsed = 0;
        var recTotal   = 30; // 30 seconds for personal intro
        var prepLeft   = 25; // 25 seconds prep
        var mediaRecorder = null;
        var audioChunks   = [];
        var answerUrl     = null;

        function fmt(s) {
            s = Math.max(0, s);
            var m = Math.floor(s / 60), sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

        function setStatus(txt, color) {
            statusLine.textContent = txt;
            statusLine.style.color = color || '#3b82f6';
        }

        function startPrep() {
            restartSession();
            state = 'prep';
            startBtn.style.display = 'none';
            restartBtn.style.display = 'inline-flex';
            prepLeft = 25;
            prepBox.classList.remove('hidden');
            prepCountdown.textContent = prepLeft;
            setStatus('Prepare your response...', '#3b82f6');

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
            setStatus('Recording your response...', '#ef4444');
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
            micCircle.style.boxShadow  = 'none';
            setStatus('Recording complete! Listen to your response below.', '#16a34a');
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

        function restartSession() {
            clearInterval(prepTimer);
            clearInterval(recTimer);
            if (mediaRecorder && mediaRecorder.state !== 'inactive') mediaRecorder.stop();
            if (!answerAudio.paused) answerAudio.pause();

            state      = 'idle';
            recElapsed = 0;
            prepLeft   = 25;
            answerUrl  = null;
            audioChunks = [];
            recCurrentTime.textContent   = '00:00';
            recProgressBar.style.width   = '0%';
            micCircle.style.boxShadow    = 'none';

            prepBox.classList.add('hidden');
            recordingBox.classList.add('hidden');
            playAnswerBox.classList.add('hidden');
            setStatus('Click Start to begin the 25-second preparation.', '#3b82f6');
            startBtn.style.display    = 'inline-flex';
            restartBtn.style.display  = 'none';
        }
    </script>
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 1], 'grammarLevel' => 'all'])
</body>
</html>
