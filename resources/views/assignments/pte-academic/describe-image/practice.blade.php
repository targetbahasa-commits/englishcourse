<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Describe Image Practice - {{ $topic['title'] }} | Target Bahasa</title>
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
                    <a href="{{ route('assignments.pte-academic.speaking-writing.describe-image.index') }}" class="inline-flex items-center text-gray-600 hover:text-teal-500 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-gradient-to-br from-teal-400 to-teal-600 text-white shadow-lg shadow-teal-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Describe Image</h1>
                            <p class="text-gray-500">PTE Academic Practice - {{ $topic['title'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main UI Block -->
                <div class="w-full">
                    <!-- Title Bar -->
                    <div class="bg-teal-500 text-white font-bold text-lg py-3 px-6 rounded-xl shadow-sm mb-2">
                        Sample Question {{ $topicId }}:
                    </div>

                    <!-- Status Line -->
                    <div class="py-2 px-1 text-base font-semibold" id="statusLine" style="color: #0d9488;">
                        Click to Start
                    </div>

                    <!-- Image Display Box -->
                    <div class="border-2 border-teal-300 rounded-xl overflow-hidden p-6 bg-white shadow-sm flex justify-center items-center min-h-96">
                        @php
                            $imagePath = public_path('storage/images/pte/describe-image/questions/' . $topicId . '.png');
                            $imageExists = file_exists($imagePath);
                        @endphp
                        @if($imageExists)
                            <img src="{{ asset('storage/images/pte/describe-image/questions/' . $topicId . '.png') }}"
                                 alt="Describe Image - Topic {{ $topicId }}"
                                 class="max-w-full object-contain" style="max-height:480px;">
                        @else
                            <div class="flex flex-col items-center justify-center gap-4 text-gray-300 py-16">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-400 font-medium text-sm">Image will be available soon</p>
                                <p class="text-gray-300 text-xs">Topic {{ str_pad($topicId, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Recording Controls Box -->
                    <div class="bg-orange-50 rounded-xl p-5 mt-5 border border-gray-200 shadow-sm">
                        <div class="flex items-center gap-4">
                            <!-- Mic Button -->
                            <button id="micBtn" onclick="toggleRecording()"
                                style="width:48px;height:48px;border-radius:50%;background:#fb923c;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.3s;">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </button>
                            <!-- Current Time -->
                            <div id="currentTime" style="font-family:monospace;font-size:14px;font-weight:600;color:#374151;width:48px;text-align:center;">00:00</div>
                            <!-- Progress Bar -->
                            <div style="flex:1;height:12px;background:#e5e7eb;border-radius:9999px;overflow:hidden;">
                                <div id="progressBar" style="width:0%;height:100%;background:#d1d5db;border-radius:9999px;transition:width 0.5s linear;"></div>
                            </div>
                            <!-- Total Time -->
                            <div style="font-family:monospace;font-size:14px;font-weight:600;color:#374151;width:48px;text-align:center;">00:40</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center items-center gap-4 mt-6">
                        <button id="startBtn" onclick="startSession()"
                            style="background:#14b8a6;color:white;font-weight:700;padding:12px 24px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 4px 6px rgba(0,0,0,0.1);transition:background 0.2s;">
                            Practice with AI Scoring
                        </button>

                        <button id="playBtn" onclick="playAnswer()"
                            style="display:none;background:#14b8a6;color:white;font-weight:700;padding:12px 24px;border-radius:9999px;border:none;cursor:pointer;box-shadow:0 4px 6px rgba(0,0,0,0.1);align-items:center;gap:8px;">
                            ▶ Play Answer
                        </button>

                        <button id="restartBtn" onclick="restartSession()"
                            style="display:none;background:white;color:#374151;font-weight:700;padding:12px 32px;border-radius:9999px;border:1px solid #d1d5db;cursor:pointer;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                            Restart
                        </button>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-between mt-10 pt-4 border-t border-gray-100">
                        <a href="{{ route('assignments.pte-academic.speaking-writing.describe-image.practice', ['id' => max(1, $topicId - 1)]) }}"
                           class="px-8 py-3 rounded-xl bg-white border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-all hover:shadow flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Previous
                        </a>
                        <a href="{{ route('assignments.pte-academic.speaking-writing.describe-image.practice', ['id' => min(50, $topicId + 1)]) }}"
                           class="px-8 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-all hover:shadow-lg flex items-center gap-2 {{ $topicId >= 50 ? 'pointer-events-none opacity-40' : '' }}">
                            Next Question
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <audio id="playbackAudio"></audio>

    <script>
        var state = 'idle';
        var prepTimer = null;
        var recordTimer = null;
        var recordTimeElapsed = 0;
        var recordTimeTotal = 40;
        var prepTimeLeft = 25;
        var prepTimeTotal = 25;
        var mediaRecorder = null;
        var audioChunks = [];
        var audioUrl = null;

        var playbackAudio = document.getElementById('playbackAudio');
        var statusLine    = document.getElementById('statusLine');
        var micBtn        = document.getElementById('micBtn');
        var progressBar   = document.getElementById('progressBar');
        var currentTime   = document.getElementById('currentTime');
        var startBtn      = document.getElementById('startBtn');
        var playBtn       = document.getElementById('playBtn');
        var restartBtn    = document.getElementById('restartBtn');

        function fmt(s) {
            var m = Math.floor(s / 60);
            var sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

        function setStatus(txt, color) {
            statusLine.textContent = txt;
            statusLine.style.color = color || '#0d9488';
        }

        function startSession() {
            clearAllTimers();
            audioChunks = [];
            audioUrl = null;
            recordTimeElapsed = 0;
            prepTimeLeft = prepTimeTotal;
            currentTime.textContent = '00:00';
            progressBar.style.width = '0%';
            progressBar.style.background = '#d1d5db';

            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(function(stream) {
                    setupMediaRecorder(stream);
                    state = 'preparing';
                    startBtn.style.display = 'none';
                    playBtn.style.display = 'none';
                    restartBtn.style.display = 'inline-flex';
                    micBtn.style.background = '#fb923c';
                    setStatus('Beginning in ' + prepTimeLeft + ' sec', '#0d9488');

                    prepTimer = setInterval(function() {
                        prepTimeLeft--;
                        setStatus('Beginning in ' + prepTimeLeft + ' sec', '#0d9488');
                        if (prepTimeLeft <= 0) {
                            clearInterval(prepTimer);
                            startRecording();
                        }
                    }, 1000);
                })
                .catch(function(err) {
                    alert('Microphone access is required. Please allow microphone access and try again.');
                });
        }

        function setupMediaRecorder(stream) {
            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];
            mediaRecorder.ondataavailable = function(e) {
                if (e.data.size > 0) audioChunks.push(e.data);
            };
            mediaRecorder.onstop = function() {
                var blob = new Blob(audioChunks, { type: 'audio/webm' });
                audioUrl = URL.createObjectURL(blob);
                playbackAudio.src = audioUrl;
                stream.getTracks().forEach(function(t) { t.stop(); });
                playBtn.style.display = 'inline-flex';
            };
        }

        function startRecording() {
            if (!mediaRecorder) return;
            state = 'recording';
            mediaRecorder.start();
            recordTimeElapsed = 0;
            micBtn.style.background = '#ef4444';
            micBtn.style.boxShadow = '0 0 0 6px rgba(239,68,68,0.25)';
            progressBar.style.background = '#ef4444';
            setStatus('Recording... Describe the image above.', '#ef4444');

            recordTimer = setInterval(function() {
                recordTimeElapsed++;
                currentTime.textContent = fmt(recordTimeElapsed);
                progressBar.style.width = ((recordTimeElapsed / recordTimeTotal) * 100) + '%';
                if (recordTimeElapsed >= recordTimeTotal) {
                    stopRecording();
                }
            }, 1000);
        }

        function stopRecording() {
            clearInterval(recordTimer);
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
            state = 'finished';
            micBtn.style.background = '#9ca3af';
            micBtn.style.boxShadow = 'none';
            progressBar.style.width = '100%';
            progressBar.style.background = '#2dd4bf';
            setStatus('Recording complete. Listen to your answer below.', '#0d9488');
        }

        function toggleRecording() {
            if (state === 'idle') {
                startSession();
            } else if (state === 'preparing') {
                clearInterval(prepTimer);
                startRecording();
            } else if (state === 'recording') {
                stopRecording();
            }
        }

        function playAnswer() {
            if (!audioUrl) return;
            if (playbackAudio.paused) {
                playbackAudio.play();
                playBtn.textContent = '⏸ Pause';
            } else {
                playbackAudio.pause();
                playBtn.textContent = '▶ Play Answer';
            }
        }

        playbackAudio.onended = function() {
            playBtn.textContent = '▶ Play Answer';
        };

        function restartSession() {
            clearAllTimers();
            if (mediaRecorder && mediaRecorder.state !== 'inactive') mediaRecorder.stop();
            if (!playbackAudio.paused) playbackAudio.pause();

            state = 'idle';
            audioUrl = null;
            audioChunks = [];
            recordTimeElapsed = 0;
            prepTimeLeft = prepTimeTotal;
            currentTime.textContent = '00:00';
            progressBar.style.width = '0%';
            progressBar.style.background = '#d1d5db';
            micBtn.style.background = '#fb923c';
            micBtn.style.boxShadow = 'none';
            setStatus('Click to Start', '#0d9488');
            startBtn.style.display = 'inline-flex';
            playBtn.style.display = 'none';
            restartBtn.style.display = 'none';
        }

        function clearAllTimers() {
            clearInterval(prepTimer);
            clearInterval(recordTimer);
        }
    </script>
</body>
</html>
