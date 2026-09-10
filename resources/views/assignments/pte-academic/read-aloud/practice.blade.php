<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Read Aloud Practice | {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
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

        {{-- Main Content Wrapper --}}
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">

            {{-- Top Navigation Bar --}}
            <nav class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold" style="background-color: #e0f2fe; color: #0284c7;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-800 leading-tight">Read Aloud</h1>
                            <p class="text-xs text-gray-500">Speaking & Writing</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-white rounded-lg text-sm text-gray-600">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Look at the text below. In 40 seconds, you must read this text aloud as naturally and clearly as possible.
                    </div>
                    <a href="{{ route('assignments.pte-academic.speaking-writing.read-aloud.index') }}#topic-{{ $topicId }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Back</span>
                    </a>
                </div>
            </nav>

            {{-- Main Test Area --}}
            <main class="flex-1 flex flex-col max-w-5xl w-full mx-auto p-4 md:p-8">

                {{-- Top Light Blue Header Banner --}}
                <div class="font-bold text-lg px-6 py-3.5 rounded-xl mb-4 shadow-sm" style="background-color: #00b4d8; color: #ffffff;">
                    Sample Question {{ $topicId }}: {{ $topic['title'] }}
                </div>

                {{-- Status Line --}}
                <div class="mb-4">
                    <p id="statusLine" class="text-base font-bold" style="color: #00b4d8;">Click to Start</p>
                </div>

                {{-- Reading Text Container --}}
                <div class="bg-white border border-gray-200 rounded-xl p-6 md:p-8 mb-6 shadow-sm">
                    <p class="text-base md:text-lg text-gray-800 leading-relaxed font-sans font-normal">
                        {{ $topic['content'] }}
                    </p>
                </div>

                {{-- Recording Controls Area --}}
                <div class="border border-amber-100/80 rounded-xl p-6 md:p-8 mb-6 shadow-sm flex flex-col items-center justify-center relative" style="background-color: #fffcf8;">
                    <div class="w-full max-w-3xl flex items-center gap-4">
                        <button id="micBtn" onclick="toggleRecording()"
                                class="w-10 h-10 rounded-full flex items-center justify-center shadow transition-all shrink-0 cursor-pointer"
                                style="background-color: #e87a5d; color: #ffffff;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </button>
                        <span id="currentTime" class="text-xs font-mono font-bold text-gray-500 shrink-0">00:00</span>
                        <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                            <div id="progressBar" class="h-full rounded-full transition-all duration-300" style="background-color: #00b4d8; width: 0%;"></div>
                        </div>
                        <span class="text-xs font-mono font-bold text-gray-500 shrink-0">00:40</span>
                    </div>
                </div>

                {{-- Action Pill Buttons --}}
                <div class="flex flex-wrap items-center gap-3 mb-8">
                    <button id="startBtn" onclick="startSession()" class="px-6 py-2.5 font-bold rounded-full shadow transition-all cursor-pointer hover:opacity-90" style="background-color: #00b4d8; color: #ffffff;">
                        Practice with AI Scoring
                    </button>
                    <button id="playBtn" onclick="playAnswer()" style="display:none; background-color: #00b4d8; color: #ffffff;" class="px-6 py-2.5 font-bold rounded-full shadow transition-all cursor-pointer hover:opacity-90 items-center gap-2">
                        ▶ Play Answer
                    </button>
                    <button id="restartBtn" onclick="restartSession()" style="display:none;" class="px-6 py-2.5 font-medium rounded-full shadow-sm transition-all cursor-pointer hover:bg-white" style="background-color: #ffffff; color: #374151; border: 1px solid #d1d5db;">
                        Restart
                    </button>
                    @if(Auth::check() && Auth::user()->isAdmin())
                    <button onclick="PTEScorePopup.show({ skill: 'Speaking', score: 78, max: 90, breakdown: { 'Content': 82, 'Pronunciation': 75, 'Oral_Fluency': 78 }, feedback: 'Pace was good. Minor hesitation on academic vocabulary.' })" class="px-5 py-2.5 font-bold rounded-full shadow transition-all flex items-center gap-2 cursor-pointer hover:opacity-90" style="background-color: #f59e0b; color: #ffffff;" title="Khusus Admin: Preview Hasil Evaluasi AI">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Preview Evaluasi
                    </button>
                    @endif
                </div>
            </main>

            {{-- Bottom Action Bar & Helpers --}}
            <footer class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-10">
                <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('assignments.pte-academic.speaking-writing.read-aloud.practice', ['id' => max(1, $topicId - 1)]) }}" class="px-6 py-2.5 font-medium rounded-lg shadow-sm transition-colors {{ $topicId <= 1 ? 'opacity-40 pointer-events-none' : '' }}" style="background-color: #00b4d8; color: #ffffff;">
                            Previous
                        </a>
                        <a href="{{ route('assignments.pte-academic.speaking-writing.read-aloud.practice', ['id' => min(300, $topicId + 1)]) }}" class="px-6 py-2.5 font-medium rounded-lg shadow-sm transition-colors {{ $topicId >= 300 ? 'opacity-40 pointer-events-none' : '' }}" style="background-color: #00b4d8; color: #ffffff;">
                            Next
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="relative flex-1 sm:w-48">
                            <input type="text" placeholder="Question ..." class="w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm">
                            <button class="absolute right-0 top-0 bottom-0 px-3 font-medium text-white rounded-r-lg transition-colors flex items-center justify-center" style="background-color: #00b4d8;">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <audio id="playbackAudio"></audio>
    @include('components.pte-score-popup')

    <script>
        var state = 'idle';
        var prepTimer = null;
        var recordTimer = null;
        var recordTimeElapsed = 0;
        var recordTimeTotal = 40;
        var prepTimeLeft = 35;
        var prepTimeTotal = 35;
        var mediaRecorder = null;
        var audioChunks = [];
        var audioUrl = null;
        var recordedMimeType = '';

        // Safari/WebKit doesn't support 'audio/webm' recording — MediaRecorder there
        // either throws or silently falls back to its own default. Explicitly probe
        // for a format the current browser actually supports instead of hardcoding
        // webm, so recording (and the resulting file sent for AI scoring) works the
        // same way on Safari as it does on Chrome/Firefox.
        function pteGetSupportedMimeType() {
            var candidates = [
                'audio/webm;codecs=opus',
                'audio/webm',
                'audio/mp4',
                'audio/mp4;codecs=mp4a.40.2',
                'audio/aac',
                'audio/ogg;codecs=opus'
            ];
            for (var i = 0; i < candidates.length; i++) {
                if (window.MediaRecorder && MediaRecorder.isTypeSupported && MediaRecorder.isTypeSupported(candidates[i])) {
                    return candidates[i];
                }
            }
            return '';
        }

        function pteMimeTypeToExtension(mimeType) {
            if (!mimeType) return 'webm';
            if (mimeType.indexOf('mp4') !== -1 || mimeType.indexOf('aac') !== -1) return 'm4a';
            if (mimeType.indexOf('ogg') !== -1) return 'ogg';
            return 'webm';
        }

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
                    setStatus('Beginning in ' + prepTimeLeft + ' sec', '#ea580c');

                    prepTimer = setInterval(function() {
                        prepTimeLeft--;
                        setStatus('Beginning in ' + prepTimeLeft + ' sec', '#ea580c');
                        if (prepTimeLeft <= 0) {
                            clearInterval(prepTimer);
                            startRecording();
                        }
                    }, 1000);
                })
                .catch(function(err) {
                    if (!window.MediaRecorder) {
                        alert('Your browser does not support audio recording. Please try a recent version of Chrome, Firefox, or Safari.');
                    } else {
                        alert('Microphone access is required. Please allow microphone access and try again.');
                    }
                });
        }

        function setupMediaRecorder(stream) {
            var mimeType = pteGetSupportedMimeType();
            try {
                mediaRecorder = mimeType ? new MediaRecorder(stream, { mimeType: mimeType }) : new MediaRecorder(stream);
            } catch (e) {
                mediaRecorder = new MediaRecorder(stream);
            }
            recordedMimeType = mediaRecorder.mimeType || mimeType || 'audio/webm';
            audioChunks = [];
            mediaRecorder.ondataavailable = function(e) {
                if (e.data.size > 0) audioChunks.push(e.data);
            };
            mediaRecorder.onstop = function() {
                var blob = new Blob(audioChunks, { type: recordedMimeType });
                audioUrl = URL.createObjectURL(blob);
                playbackAudio.src = audioUrl;
                stream.getTracks().forEach(function(t) { t.stop(); });
                playBtn.style.display = 'inline-flex';
                evaluateAudio(blob);
            };
        }

        async function evaluateAudio(blob) {
            if (!blob || blob.size < 1000) {
                setStatus('Recording complete.', '#ea580c');
                alert('No audio was captured. This can happen on some browsers/devices — please try again, and make sure your microphone is working.');
                return;
            }
            setStatus('Evaluating audio with AI...', '#f59e0b');
            var formData = new FormData();
            formData.append('audio', blob, 'read_aloud.' + pteMimeTypeToExtension(recordedMimeType));
            formData.append('module', 'read-aloud');
            formData.append('topic_id', {{ $topicId }});
            formData.append('original_text', @json($topic['content'] ?? ''));

            try {
                var response = await fetch('/pte/practice/evaluate-speaking', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });
                var data = await response.json();
                if (data.success && data.scores) {
                    setStatus('Recording complete. AI Evaluation ready.', '#00b4d8');
                    PTEScorePopup.show({
                        skill: 'Speaking',
                        score: data.scores.overall_score || 70,
                        max: 90,
                        breakdown: {
                            'Content': data.scores.content_score || 70,
                            'Pronunciation': data.scores.pronunciation_score || 70,
                            'Oral_Fluency': data.scores.fluency_score || 70
                        },
                        feedback: data.scores.feedback || ('Transcription: ' + (data.transcription || ''))
                    });
                } else {
                    setStatus('Recording complete.', '#00b4d8');
                    alert('Evaluasi AI Gagal: ' + (data.message || 'Speech not recognized'));
                }
            } catch (err) {
                setStatus('Recording complete.', '#00b4d8');
                console.error('Error evaluating audio:', err);
                alert('Evaluasi AI Gagal: terjadi kesalahan saat menghubungi server. Silakan coba lagi.');
            }
        }

        function startRecording() {
            if (!mediaRecorder) return;
            state = 'recording';
            mediaRecorder.start();
            recordTimeElapsed = 0;
            micBtn.style.background = '#ef4444';
            micBtn.style.boxShadow = '0 0 0 6px rgba(239,68,68,0.25)';
            progressBar.style.background = '#ef4444';
            setStatus('Recording... Read the text aloud.', '#ef4444');

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
            setStatus('Recording complete. Processing AI Evaluation...', '#00b4d8');
            if (window.PTETracker) {
                PTETracker.saveResult({ score: 1, maxScore: 1, durationSeconds: recordTimeElapsed });
            }
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
    @include('components.pte-practice-tracker', ['module' => 'read-aloud', 'topicId' => $topicId])
    <x-live-drawing />
</body>
</html>
