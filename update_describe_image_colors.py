import sys

content = """<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Describe Image Practice - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @php
            if(Auth::check()) {
                $sidebarRole = strtolower(Auth::user()->active_role ?? 'student');
            } else {
                $sidebarRole = 'guest';
            }
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

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <div class="container mx-auto">

                <!-- Header with Back Button -->
                <div class="mb-8">
                    <a href="{{ route('assignments.pte-academic.speaking-writing.describe-image.index') }}#topic-{{ $topicId }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Selection
                    </a>

                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full shadow-md" style="background-color: #e0f2fe; color: #0284c7;">
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
                    <!-- Title Bar (Light Blue) -->
                    <div class="font-bold text-lg py-3.5 px-6 rounded-xl shadow-sm mb-3" style="background-color: #00b4d8; color: #ffffff;">
                        Sample Question {{ $topicId }}: {{ $topic['title'] }}
                    </div>

                    <!-- Status Line -->
                    <div class="py-2 px-1 text-base font-bold mb-2" id="statusLine" style="color: #00b4d8;">
                        Click to Start
                    </div>

                    <!-- Image Display Box -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden p-6 bg-white shadow-sm flex justify-center items-center min-h-96">
                        @php
                            $tid = (int)$topicId;
                            $jpgTopics = [259, 287, 232, 256, 280, 282, 298, 227, 240, 242, 250, 267, 253, 274, 251, 275, 285];
                            if ($tid >= 51 && $tid <= 300) {
                                // New generated chart/map/photo images
                                $imgExt = in_array($tid, $jpgTopics) ? '.jpg' : '.png';
                                $imgBase = 'storage/describe-image/di_topic_' . $tid;
                            } else {
                                // Original topics 1-50
                                $imgExt = in_array($tid, [7, 8]) ? '.webp' : '.png';
                                $imgBase = 'storage/images/pte/describe-image/questions/' . $tid;
                            }
                            $imgSrc = ($tid >= 1 && $tid <= $totalTopics) ? asset($imgBase . $imgExt) : null;
                        @endphp
                        @if($imgSrc)
                            <img src="{{ $imgSrc }}"
                                 alt="Describe Image - Topic {{ $topicId }}"
                                 class="max-w-full object-contain" style="max-height: 550px;"
                                 onerror="this.parentElement.innerHTML='<div class=\'flex flex-col items-center justify-center gap-4 text-gray-300 py-16\'><svg class=\'w-20 h-20\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><p class=\'text-gray-400 font-medium text-sm\'>Image will be available soon</p></div>';">
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
                    <div class="border border-amber-100/80 rounded-xl p-5 mt-5 shadow-sm" style="background-color: #fffcf8;">
                        <div class="flex items-center gap-4">
                            <!-- Mic Button -->
                            <button id="micBtn" onclick="toggleRecording()"
                                style="width:44px;height:44px;border-radius:50%;background:#e87a5d;color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.3s;" class="shadow">
                                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </button>
                            <!-- Current Time -->
                            <div id="currentTime" style="font-family:monospace;font-size:14px;font-weight:700;color:#64748b;width:48px;text-align:center;">00:00</div>
                            <!-- Progress Bar -->
                            <div style="flex:1;height:10px;background:#e2e8f0;border-radius:9999px;overflow:hidden;">
                                <div id="progressBar" style="width:0%;height:100%;background:#00b4d8;border-radius:9999px;transition:width 0.5s linear;"></div>
                            </div>
                            <!-- Total Time -->
                            <div style="font-family:monospace;font-size:14px;font-weight:700;color:#64748b;width:48px;text-align:center;">00:40</div>
                        </div>
                    </div>

                    <!-- Action Pill Buttons -->
                    <div class="flex flex-wrap justify-start items-center gap-3 mt-6">
                        <button id="startBtn" onclick="startSession()"
                            style="background-color: #00b4d8; color: white; font-weight: 700; padding: 10px 24px; border-radius: 9999px; border: none; cursor: pointer;" class="shadow transition-all hover:opacity-90">
                            Practice with AI Scoring
                        </button>

                        <button id="playBtn" onclick="playAnswer()"
                            style="display:none; background-color: #00b4d8; color: white; font-weight: 700; padding: 10px 24px; border-radius: 9999px; border: none; cursor: pointer;" class="shadow items-center gap-2">
                            ▶ Play Answer
                        </button>

                        <button id="restartBtn" onclick="restartSession()"
                            style="display:none; background-color: white; color: #374151; font-weight: 600; padding: 10px 24px; border-radius: 9999px; border: 1px solid #d1d5db; cursor: pointer;">
                            Restart
                        </button>

                        @if(Auth::check() && Auth::user()->isAdmin())
                        <button onclick="PTEScorePopup.show({ skill: 'Speaking', score: 76, max: 90, breakdown: { 'Content': 80, 'Pronunciation': 74, 'Oral_Fluency': 75 }, feedback: 'Good description of trends and key data points in the image.' })" class="px-5 py-2.5 font-bold rounded-full shadow transition-all flex items-center gap-2 cursor-pointer hover:opacity-90" style="background-color: #f59e0b; color: #ffffff;" title="Khusus Admin: Preview Hasil Evaluasi AI">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Preview Evaluasi
                        </button>
                        @endif
                    </div>

                    <!-- Navigation Footer -->
                    <div class="flex justify-between items-center mt-10 pt-4 border-t border-gray-100">
                        <a href="{{ route('assignments.pte-academic.speaking-writing.describe-image.practice', ['id' => max(1, $topicId - 1)]) }}"
                           class="px-6 py-2.5 rounded-lg text-white font-medium shadow-sm transition-all flex items-center gap-2 {{ $topicId <= 1 ? 'pointer-events-none opacity-40' : '' }}" style="background-color: #00b4d8;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Previous
                        </a>
                        <a href="{{ route('assignments.pte-academic.speaking-writing.describe-image.practice', ['id' => min(50, $topicId + 1)]) }}"
                           class="px-6 py-2.5 rounded-lg text-white font-medium shadow-sm transition-all flex items-center gap-2 {{ $topicId >= 50 ? 'pointer-events-none opacity-40' : '' }}" style="background-color: #00b4d8;">
                            Next Question
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <audio id="playbackAudio"></audio>
    @include('components.pte-score-popup')

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
            statusLine.style.color = color || '#00b4d8';
        }

        function startSession() {
            clearAllTimers();
            audioChunks = [];
            audioUrl = null;
            recordTimeElapsed = 0;
            prepTimeLeft = prepTimeTotal;
            currentTime.textContent = '00:00';
            progressBar.style.width = '0%';
            progressBar.style.background = '#00b4d8';

            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(function(stream) {
                    setupMediaRecorder(stream);
                    state = 'preparing';
                    startBtn.style.display = 'none';
                    playBtn.style.display = 'none';
                    restartBtn.style.display = 'inline-flex';
                    micBtn.style.background = '#00b4d8';
                    setStatus('Beginning in ' + prepTimeLeft + ' sec', '#00b4d8');

                    prepTimer = setInterval(function() {
                        prepTimeLeft--;
                        setStatus('Beginning in ' + prepTimeLeft + ' sec', '#00b4d8');
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
            micBtn.style.background = '#00b4d8';
            micBtn.style.boxShadow = 'none';
            progressBar.style.width = '100%';
            progressBar.style.background = '#00b4d8';
            setStatus('Recording complete. Listen to your answer below.', '#00b4d8');
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
            progressBar.style.background = '#00b4d8';
            micBtn.style.background = '#e87a5d';
            micBtn.style.boxShadow = 'none';
            setStatus('Click to Start', '#00b4d8');
            startBtn.style.display = 'inline-flex';
            playBtn.style.display = 'none';
            restartBtn.style.display = 'none';
        }

        function clearAllTimers() {
            clearInterval(prepTimer);
            clearInterval(recordTimer);
        }
    </script>
    @include('assignments.ielts.writing.practice_toolbar', ['meeting' => (object)['task_type' => 1], 'grammarLevel' => 'all'])
</body>
</html>
"""

with open('resources/views/assignments/pte-academic/describe-image/practice.blade.php', 'w') as f:
    f.write(content)

print('Updated Describe Image practice view with light blue theme successfully.')
