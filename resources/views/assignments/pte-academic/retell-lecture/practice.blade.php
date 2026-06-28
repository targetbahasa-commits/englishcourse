<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Re-tell Lecture Practice - {{ $topic['title'] }} | Target Bahasa</title>
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
                    <a href="{{ route('assignments.pte-academic.speaking-writing.retell-lecture.index') }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-orange-400 to-orange-600 text-white shadow-lg shadow-orange-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Re-tell Lecture</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Practice Card -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col relative">

                        <div class="p-8 md:p-12 flex-1 flex flex-col items-center text-center">

                            <!-- Instruction Box -->
                            <div class="w-full border border-gray-300 rounded-xl p-5 mb-8 text-left text-gray-700 text-base leading-relaxed">
                                You will hear a lecture. After listening to it, in <strong>10 seconds</strong>, please tell what you have just heard from the lecture in your own words. You will have <strong>40 seconds</strong> to give your response.
                            </div>

                            <!-- Status Line -->
                            <div id="statusLine" class="text-base font-semibold mb-6" style="color:#ea580c;">
                                Play the audio to listen to the related recording.
                            </div>

                            <!-- Audio Player -->
                            <div class="w-full max-w-lg mx-auto bg-white rounded-3xl p-6 mb-8 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 flex flex-col items-center gap-5">
                                <!-- Play Button -->
                                <button id="playBtn" onclick="toggleAudio()"
                                    class="w-20 h-20 flex-shrink-0 flex items-center justify-center rounded-full bg-gradient-to-tr from-orange-400 to-orange-500 text-white shadow-xl shadow-orange-500/30 transition-all duration-300 hover:scale-105 hover:shadow-orange-500/50 relative">
                                    <div id="pingRing" class="hidden absolute inset-0 rounded-full border-2 border-orange-400 animate-ping opacity-75"></div>
                                    <svg id="playIcon" class="w-10 h-10 ml-1 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                    <svg id="pauseIcon" class="hidden w-10 h-10 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                                </button>

                                <!-- Audio Progress -->
                                <div class="w-full px-4">
                                    <div class="h-2.5 w-full bg-gray-100 rounded-full overflow-hidden relative mb-3">
                                        <div id="audioProgressBar" class="absolute top-0 left-0 h-full bg-orange-400 transition-all duration-300" style="width:0%"></div>
                                    </div>
                                    <div class="flex justify-center font-bold text-gray-400 text-sm font-mono tracking-wider">
                                        <span id="audioCurrentTime">00:00</span>
                                        <span class="mx-1">/</span>
                                        <span id="audioTotalTime">00:00</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Prep Countdown (hidden initially) -->
                            <div id="prepBox" class="hidden w-full max-w-lg text-center mb-6">
                                <p class="text-gray-500 text-sm mb-2">Prepare to speak in...</p>
                                <div id="prepCountdown" class="text-5xl font-bold text-orange-500">10</div>
                                <p class="text-gray-400 text-xs mt-2">Recall what you heard and prepare your response</p>
                            </div>

                            <!-- Recording Controls -->
                            <div id="recordingBox" class="hidden w-full max-w-lg bg-orange-50 rounded-2xl p-5 border border-orange-100 shadow-sm mb-6">
                                <div class="flex items-center gap-4">
                                    <div id="micCircle"
                                        style="width:48px;height:48px;border-radius:50%;background:#f97316;color:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                        </svg>
                                    </div>
                                    <div id="recCurrentTime" style="font-family:monospace;font-size:14px;font-weight:600;color:#374151;width:48px;text-align:center;">00:00</div>
                                    <div style="flex:1;height:12px;background:#fed7aa;border-radius:9999px;overflow:hidden;">
                                        <div id="recProgressBar" style="width:0%;height:100%;background:#f97316;border-radius:9999px;transition:width 0.5s linear;"></div>
                                    </div>
                                    <div style="font-family:monospace;font-size:14px;font-weight:600;color:#374151;width:48px;text-align:center;">00:40</div>
                                </div>
                            </div>

                            <!-- Play Answer (after recording) -->
                            <div id="playAnswerBox" class="hidden w-full max-w-lg text-center mb-6">
                                <button id="playAnswerBtn" onclick="playAnswer()"
                                    style="background:#f97316;color:white;font-weight:700;padding:12px 28px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                                    ▶ Play My Answer
                                </button>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center items-center gap-4 mt-2">
                                <button id="startBtn" onclick="startSession()"
                                    style="background:#f97316;color:white;font-weight:700;padding:12px 28px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 4px 6px rgba(0,0,0,0.1);transition:background 0.2s;">
                                    Practice with AI Scoring
                                </button>
                                <button id="restartBtn" onclick="restartSession()"
                                    style="display:none;background:white;color:#374151;font-weight:700;padding:12px 28px;border-radius:9999px;border:1px solid #d1d5db;cursor:pointer;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                    Restart
                                </button>
                            </div>

                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-8 md:px-12 py-6 border-t border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <a href="{{ route('assignments.pte-academic.speaking-writing.retell-lecture.practice', ['id' => max(1, $topicId - 1)]) }}"
                               class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Previous
                            </a>
                            <span class="text-gray-400 text-sm font-medium">{{ $topicId }} / 300</span>
                            <a href="{{ route('assignments.pte-academic.speaking-writing.retell-lecture.practice', ['id' => min(300, $topicId + 1)]) }}"
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

    <!-- Audio elements -->
    <audio id="lectureAudio" src="{{ asset('storage/audio/pte/retell-lecture/' . $topicId . '.wav') }}"></audio>
    <audio id="answerAudio"></audio>

    <script>
        // ── DOM refs ──
        var lectureAudio    = document.getElementById('lectureAudio');
        var answerAudio     = document.getElementById('answerAudio');
        var playBtn         = document.getElementById('playBtn');
        var playIcon        = document.getElementById('playIcon');
        var pauseIcon       = document.getElementById('pauseIcon');
        var pingRing        = document.getElementById('pingRing');
        var audioProgressBar = document.getElementById('audioProgressBar');
        var audioCurrentTime = document.getElementById('audioCurrentTime');
        var audioTotalTime   = document.getElementById('audioTotalTime');
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

        // ── State ──
        var state = 'idle'; // idle, playing, prep, recording, finished
        var prepTimer = null;
        var recTimer  = null;
        var recElapsed = 0;
        var recTotal   = 40;
        var prepLeft   = 10;
        var mediaRecorder = null;
        var audioChunks   = [];
        var answerUrl     = null;
        var autoStarted   = false;

        // ── Audio listeners ──
        lectureAudio.addEventListener('loadedmetadata', function () {
            audioTotalTime.textContent = fmt(Math.floor(lectureAudio.duration));
        });
        lectureAudio.addEventListener('timeupdate', function () {
            var cur = lectureAudio.currentTime;
            var dur = lectureAudio.duration || 0;
            audioCurrentTime.textContent = fmt(Math.floor(cur));
            if (dur > 0) audioProgressBar.style.width = ((cur / dur) * 100) + '%';
        });
        lectureAudio.addEventListener('ended', function () {
            setPlayingUI(false);
            if (state === 'playing') {
                startPrep();
            }
        });

        function fmt(s) {
            s = Math.max(0, s);
            var m = Math.floor(s / 60), sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

        function setStatus(txt, color) {
            statusLine.textContent = txt;
            statusLine.style.color = color || '#ea580c';
        }

        function setPlayingUI(playing) {
            if (playing) {
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
                pingRing.classList.remove('hidden');
            } else {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
                pingRing.classList.add('hidden');
            }
        }

        function toggleAudio() {
            if (state === 'idle' || state === 'playing') {
                if (lectureAudio.paused) {
                    lectureAudio.play();
                    state = 'playing';
                    setPlayingUI(true);
                    setStatus('Listening to lecture... Take notes mentally.', '#ea580c');
                    startBtn.style.display = 'none';
                    restartBtn.style.display = 'inline-flex';
                } else {
                    lectureAudio.pause();
                    setPlayingUI(false);
                    setStatus('Paused. Click play to continue.', '#9ca3af');
                }
            }
        }

        function startSession() {
            restartSession();
            lectureAudio.play();
            state = 'playing';
            setPlayingUI(true);
            setStatus('Listening to lecture... Take notes mentally.', '#ea580c');
            startBtn.style.display = 'none';
            restartBtn.style.display = 'inline-flex';
        }

        function startPrep() {
            state = 'prep';
            lectureAudio.pause();
            setPlayingUI(false);
            prepLeft = 10;
            prepBox.classList.remove('hidden');
            prepCountdown.textContent = prepLeft;
            setStatus('Prepare your response...', '#ea580c');

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
            micCircle.style.background = '#ef4444';
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
            micCircle.style.background = '#9ca3af';
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
            if (!lectureAudio.paused) { lectureAudio.pause(); lectureAudio.currentTime = 0; }
            if (!answerAudio.paused) answerAudio.pause();

            state      = 'idle';
            recElapsed = 0;
            prepLeft   = 10;
            answerUrl  = null;
            audioChunks = [];
            audioProgressBar.style.width = '0%';
            audioCurrentTime.textContent = '00:00';
            recCurrentTime.textContent   = '00:00';
            recProgressBar.style.width   = '0%';
            micCircle.style.background   = '#f97316';
            micCircle.style.boxShadow    = 'none';

            prepBox.classList.add('hidden');
            recordingBox.classList.add('hidden');
            playAnswerBox.classList.add('hidden');
            setPlayingUI(false);
            setStatus('Play the audio to listen to the related recording.', '#ea580c');
            startBtn.style.display    = 'inline-flex';
            restartBtn.style.display  = 'none';
        }
    </script>
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 1], 'grammarLevel' => 'all'])
</body>
</html>
