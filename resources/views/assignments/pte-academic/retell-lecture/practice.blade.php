<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Re-tell Lecture Practice - {{ $topic['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-white flex flex-col min-h-screen">
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
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-800 leading-tight">Re-tell Lecture</h1>
                            <p class="text-xs text-gray-500">PTE Academic Practice - Topic #{{ str_pad($topicId, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('assignments.pte-academic.speaking-writing.retell-lecture.index') }}#topic-{{ $topicId }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Back</span>
                </a>
            </nav>

            {{-- Main Test Area --}}
            <main class="flex-1 flex flex-col max-w-5xl w-full mx-auto p-4 md:p-8">
                
                {{-- Top Light Blue Header Banner --}}
                <div class="font-bold text-lg px-6 py-3.5 rounded-xl mb-4 shadow-sm" style="background-color: #00b4d8; color: #ffffff;">
                    Sample Question {{ $topicId }}: {{ $topic['title'] }}
                </div>

                {{-- Status / Timer --}}
                <div class="mb-4">
                    <p class="text-base font-bold text-gray-800">
                        Beginning in <span style="color: #00b4d8; font-weight: 800;" id="countdownText">2 sec</span>
                    </p>
                </div>

                {{-- Prompt Audio Box (Reference Style) --}}
                <div class="rounded-xl p-5 mb-6 flex flex-col md:flex-row items-center gap-4 shadow-sm" style="background-color: #ffffff; border: 1px solid #00b4d8;">
                    <button id="playBtn" onclick="toggleAudio()" class="w-10 h-10 rounded-full flex items-center justify-center text-white shadow shrink-0 cursor-pointer transition-transform hover:scale-105" style="background-color: #f97316;">
                        <svg id="playIcon" class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                        <svg id="pauseIcon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                    </button>
                    <span id="audioCurrentTime" class="text-xs font-mono font-bold text-gray-500 shrink-0">00:00</span>
                    
                    <div class="flex-1 w-full h-2.5 bg-gray-200 rounded-full overflow-hidden relative">
                        <div id="audioProgressBar" class="h-full rounded-full transition-all duration-300" style="background-color: #00b4d8; width: 0%;"></div>
                    </div>

                    <span id="audioTotalTime" class="text-xs font-mono font-bold text-gray-500 shrink-0">01:18</span>

                    {{-- Speed Control Pill --}}
                    <div class="relative" x-data="{ openSpeed: false }">
                        <button @click="openSpeed = !openSpeed" class="px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 border shrink-0 bg-white cursor-pointer" style="border-color: #00b4d8; color: #00b4d8;">
                            <span>1.0</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>

                    {{-- Volume Indicator --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <svg class="w-5 h-5" style="color: #00b4d8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828"></path></svg>
                        <div class="w-16 h-1.5 rounded-full" style="background-color: #00b4d8;"></div>
                    </div>
                </div>

                {{-- Recording Controls Area (Student Response) --}}
                <div class="border border-amber-100/80 rounded-xl p-6 md:p-8 mb-6 shadow-sm flex flex-col items-center justify-center relative" style="background-color: #fffcf8;">
                    <p id="statusLine" class="text-gray-800 font-bold text-base mb-6 text-center">Click to Start</p>
                    
                    <div class="w-full max-w-3xl flex items-center gap-4">
                        <button id="micBtn" onclick="toggleRecording()" 
                                class="w-10 h-10 rounded-full flex items-center justify-center text-white shadow transition-all shrink-0 cursor-pointer"
                                style="background-color: #e87a5d;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </button>
                        <span id="recCurrentTime" class="text-xs font-mono font-bold text-gray-500 shrink-0">00:00</span>
                        <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                            <div id="recProgressBar" class="h-full rounded-full transition-all duration-300" style="background-color: #00b4d8; width: 0%;"></div>
                        </div>
                        <span class="text-xs font-mono font-bold text-gray-500 shrink-0">00:40</span>
                    </div>
                </div>

                {{-- Action Pill Buttons --}}
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <button id="startBtn" onclick="startSession()" class="px-6 py-2.5 font-bold rounded-full shadow transition-all cursor-pointer hover:opacity-90" style="background-color: #00b4d8; color: #ffffff;">
                        Practice with AI Scoring
                    </button>
                    <button id="restartBtn" onclick="restartSession()" class="px-6 py-2.5 font-medium rounded-full shadow-sm transition-all cursor-pointer hover:bg-white" style="background-color: #ffffff; color: #374151; border: 1px solid #d1d5db;">
                        Restart
                    </button>
                    @if(Auth::check() && Auth::user()->isAdmin())
                    <button onclick="PTEScorePopup.show({ skill: 'Speaking', score: 79, max: 90, breakdown: { 'Content': 83, 'Pronunciation': 77, 'Oral_Fluency': 78 }, feedback: 'Good comprehension of the lecture topic. Strong key point summary.' })" class="px-5 py-2.5 font-bold rounded-full shadow transition-all flex items-center gap-2 cursor-pointer hover:opacity-90" style="background-color: #f59e0b; color: #ffffff;" title="Khusus Admin: Preview Hasil Evaluasi AI">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Preview Evaluasi
                    </button>
                    @endif
                </div>

                {{-- Transcript Accordion --}}
                <div class="mt-4 mb-8" x-data="{ showAnswer: false }">
                    <button @click="showAnswer = !showAnswer" class="text-xs font-bold px-4 py-2 rounded-full border transition-all flex items-center gap-1.5" style="background-color: #e0f2fe; color: #0284c7; border-color: #bae6fd;">
                        <svg class="w-4 h-4 transition-transform duration-300" :class="showAnswer ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        <span x-text="showAnswer ? 'Hide Transcript' : 'Show Transcript'">Show Transcript</span>
                    </button>
                    
                    <div x-show="showAnswer" x-cloak class="mt-3 bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                        <p class="text-gray-800 text-base leading-relaxed font-sans">{{ $topic['content'] ?? 'Audio transcript for this lecture topic will be available soon.' }}</p>
                    </div>
                </div>
            </main>

            {{-- Bottom Action Bar & Helpers --}}
            <footer class="bg-white border-t border-gray-200 p-4 sticky bottom-0 z-10">
                <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('assignments.pte-academic.speaking-writing.retell-lecture.practice', ['id' => max(1, $topicId - 1)]) }}" class="px-6 py-2.5 font-medium rounded-lg shadow-sm transition-colors {{ $topicId <= 1 ? 'opacity-40 pointer-events-none' : '' }}" style="background-color: #00b4d8; color: #ffffff;">
                            Previous
                        </a>
                        <a href="{{ route('assignments.pte-academic.speaking-writing.retell-lecture.practice', ['id' => min(300, $topicId + 1)]) }}" class="px-6 py-2.5 font-medium rounded-lg shadow-sm transition-colors {{ $topicId >= 300 ? 'opacity-40 pointer-events-none' : '' }}" style="background-color: #00b4d8; color: #ffffff;">
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

    <!-- Audio elements -->
    <audio id="lectureAudio" src="{{ asset('storage/kokoro-tts/retell-lecture/rtl_topic_' . ($topicId - 1) . '.mp3') }}"></audio>
    <audio id="answerAudio"></audio>

    @include('components.pte-score-popup')

    <script>
        var lectureAudio     = document.getElementById('lectureAudio');
        var answerAudio      = document.getElementById('answerAudio');
        var playBtn          = document.getElementById('playBtn');
        var playIcon         = document.getElementById('playIcon');
        var pauseIcon        = document.getElementById('pauseIcon');
        var audioProgressBar = document.getElementById('audioProgressBar');
        var audioCurrentTime = document.getElementById('audioCurrentTime');
        var audioTotalTime   = document.getElementById('audioTotalTime');
        var statusLine       = document.getElementById('statusLine');
        var micBtn           = document.getElementById('micBtn');
        var recCurrentTime   = document.getElementById('recCurrentTime');
        var recProgressBar   = document.getElementById('recProgressBar');
        var startBtn         = document.getElementById('startBtn');
        var restartBtn       = document.getElementById('restartBtn');

        var state = 'idle';
        var prepTimer = null;
        var recTimer  = null;
        var recElapsed = 0;
        var recTotal   = 40;
        var prepLeft   = 10;
        var mediaRecorder = null;
        var audioChunks   = [];
        var recordedMimeType = '';

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
        var answerUrl     = null;

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
            if (state === 'playing') startPrep();
        });

        function fmt(s) {
            s = Math.max(0, s);
            var m = Math.floor(s / 60), sec = s % 60;
            return (m < 10 ? '0'+m : m) + ':' + (sec < 10 ? '0'+sec : sec);
        }

        function setStatus(txt, color) {
            statusLine.textContent = txt;
            statusLine.style.color = color || '#00b4d8';
        }

        function setPlayingUI(playing) {
            if (playing) {
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
            } else {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            }
        }

        function toggleAudio() {
            if (state === 'idle' || state === 'playing') {
                if (lectureAudio.paused) {
                    lectureAudio.play();
                    state = 'playing';
                    setPlayingUI(true);
                    setStatus('Listening to lecture...', '#00b4d8');
                } else {
                    lectureAudio.pause();
                    setPlayingUI(false);
                    setStatus('Paused. Click play to continue.', '#64748b');
                }
            }
        }

        function startSession() {
            restartSession();
            lectureAudio.play();
            state = 'playing';
            setPlayingUI(true);
            setStatus('Listening to lecture...', '#00b4d8');
        }

        function startPrep() {
            state = 'prep';
            lectureAudio.pause();
            setPlayingUI(false);
            prepLeft = 10;
            setStatus('Beginning in ' + prepLeft + ' sec', '#ea580c');

            prepTimer = setInterval(function () {
                prepLeft--;
                setStatus('Beginning in ' + prepLeft + ' sec', '#ea580c');
                if (prepLeft <= 0) {
                    clearInterval(prepTimer);
                    startRecording();
                }
            }, 1000);
        }

        function startRecording() {
            state = 'recording';
            recElapsed = 0;
            setStatus('Recording in progress...', '#ef4444');
            micBtn.style.background = '#ef4444';

            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(function (stream) {
                    var mimeType = pteGetSupportedMimeType();
                    try {
                        mediaRecorder = mimeType ? new MediaRecorder(stream, { mimeType: mimeType }) : new MediaRecorder(stream);
                    } catch (e) {
                        mediaRecorder = new MediaRecorder(stream);
                    }
                    recordedMimeType = mediaRecorder.mimeType || mimeType || 'audio/webm';
                    audioChunks = [];
                    mediaRecorder.ondataavailable = function (e) {
                        if (e.data.size > 0) audioChunks.push(e.data);
                    };
                    mediaRecorder.onstop = function () {
                        var blob = new Blob(audioChunks, { type: recordedMimeType });
                        answerUrl = URL.createObjectURL(blob);
                        answerAudio.src = answerUrl;
                        stream.getTracks().forEach(function (t) { t.stop(); });
                        evaluateAudio(blob);
                    };
                    mediaRecorder.start();

                    recTimer = setInterval(function () {
                        recElapsed++;
                        recCurrentTime.textContent = fmt(recElapsed);
                        recProgressBar.style.width = ((recElapsed / recTotal) * 100) + '%';
                        if (recElapsed >= recTotal) {
                            stopRecording();
                        }
                    }, 1000);
                })
                .catch(function () {
                    if (!window.MediaRecorder) {
                        alert('Browser Anda tidak mendukung perekaman audio. Silakan gunakan versi terbaru Chrome, Firefox, atau Safari.');
                    } else {
                        alert('Akses mikrofon diperlukan. Harizkan akses mikrofon.');
                    }
                });
        }

        function toggleRecording() {
            if (!mediaRecorder || mediaRecorder.state === 'inactive') {
                startRecording();
            } else {
                stopRecording();
            }
        }

        async function evaluateAudio(blob) {
            if (!blob || blob.size < 1000) {
                setStatus('Recording complete.', '#ea580c');
                alert('No audio was captured. This can happen on some browsers/devices — please try again.');
                return;
            }
            setStatus('Evaluating audio with AI...', '#f59e0b');
            var formData = new FormData();
            formData.append('audio', blob, 'retell_lecture.' + pteMimeTypeToExtension(recordedMimeType));
            formData.append('module', 'retell-lecture');
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

        function stopRecording() {
            clearInterval(recTimer);
            if (mediaRecorder && mediaRecorder.state !== 'inactive') mediaRecorder.stop();
            state = 'finished';
            micBtn.style.background = '#00b4d8';
            setStatus('Recording complete. Processing AI Evaluation...', '#00b4d8');
            if (window.PTETracker) {
                PTETracker.saveResult({ score: 1, maxScore: 1, durationSeconds: recElapsed });
            }
        }

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
            micBtn.style.background   = '#e87a5d';

            setPlayingUI(false);
            setStatus('Click to Start', '#00b4d8');
        }
    </script>
    @include('components.pte-practice-tracker', ['module' => 'retell-lecture', 'topicId' => $topicId])
    <x-live-drawing />
</body>
</html>
