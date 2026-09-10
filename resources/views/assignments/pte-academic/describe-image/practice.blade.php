<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Describe Image Practice - {{ $topic['title'] }} | Target Bahasa</title>
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

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <div class="container mx-auto">

                <!-- Header with Back Button -->
                <div class="mb-6">
                    <div class="flex justify-end mb-2">
                        <a href="{{ route('assignments.pte-academic.speaking-writing.describe-image.index') }}#topic-{{ $topicId }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Back</span>
                        </a>
                    </div>

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
                                 onerror="this.parentElement.innerHTML='<div class='flex flex-col items-center justify-center gap-4 text-gray-300 py-16'><svg class='w-20 h-20' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'></path></svg><p class='text-gray-400 font-medium text-sm'>Image will be available soon</p></div>';">
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
                alert('No audio was captured. This can happen on some browsers/devices — please try again.');
                return;
            }
            setStatus('Evaluating audio with AI...', '#f59e0b');
            var formData = new FormData();
            formData.append('audio', blob, 'describe_image.' + pteMimeTypeToExtension(recordedMimeType));
            formData.append('module', 'describe-image');
            formData.append('topic_id', {{ $topicId }});
            formData.append('original_text', @json($topic['title'] ?? ''));

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
    {{-- Floating Button & Draggable/Resizable/Pinnable Tips Modal --}}
    <div x-data="{
        showTips: false,
        isPinned: false,
        
        // Floating button position & drag
        btnX: 0, btnY: 0,
        btnDragging: false, btnIsDragged: false,
        btnStartX: 0, btnStartY: 0,

        // Modal position & dimensions
        modalX: null, modalY: null,
        modalW: 920, modalH: 650,
        modalDragging: false,
        modalStartX: 0, modalStartY: 0,

        // Modal resizing
        modalResizing: false,
        resizeStartX: 0, resizeStartY: 0,
        resizeStartW: 0, resizeStartH: 0,

        init() {
            this.btnX = Math.max(12, window.innerWidth - 90);
            this.btnY = Math.max(60, window.innerHeight - 130);
            this.modalW = Math.min(920, window.innerWidth - 24);
            this.modalH = Math.min(650, window.innerHeight - 24);
        },

        openTips() {
            if (!this.btnIsDragged) {
                this.showTips = true;
                if (this.modalX === null) {
                    this.modalW = Math.min(920, window.innerWidth - 24);
                    this.modalH = Math.min(650, window.innerHeight - 24);
                    this.modalX = Math.max(8, Math.floor((window.innerWidth - this.modalW) / 2));
                    this.modalY = Math.max(8, Math.floor((window.innerHeight - this.modalH) / 2));
                }
            }
        },

        startBtnDrag(e) {
            this.btnDragging = true;
            this.btnIsDragged = false;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.btnStartX = clientX - this.btnX;
            this.btnStartY = clientY - this.btnY;
        },

        startModalDrag(e) {
            if (e.target.closest('button') || e.target.closest('a') || e.target.closest('input')) return;
            this.modalDragging = true;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.modalStartX = clientX - (this.modalX || 0);
            this.modalStartY = clientY - (this.modalY || 0);
        },

        startResize(e) {
            e.stopPropagation();
            e.preventDefault();
            this.modalResizing = true;
            let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
            this.resizeStartX = clientX;
            this.resizeStartY = clientY;
            this.resizeStartW = this.modalW;
            this.resizeStartH = this.modalH;
        },

        onMove(e) {
            let clientX = e.type.includes('mouse') ? e.clientX : (e.touches && e.touches[0] ? e.touches[0].clientX : 0);
            let clientY = e.type.includes('mouse') ? e.clientY : (e.touches && e.touches[0] ? e.touches[0].clientY : 0);

            if (this.btnDragging) {
                this.btnIsDragged = true;
                let nx = clientX - this.btnStartX;
                let ny = clientY - this.btnStartY;
                this.btnX = Math.max(8, Math.min(nx, window.innerWidth - 65));
                this.btnY = Math.max(8, Math.min(ny, window.innerHeight - 65));
            }

            if (this.modalDragging) {
                this.modalX = clientX - this.modalStartX;
                this.modalY = clientY - this.modalStartY;
            }

            if (this.modalResizing) {
                let dx = clientX - this.resizeStartX;
                let dy = clientY - this.resizeStartY;
                this.modalW = Math.max(320, Math.min(this.resizeStartW + dx, window.innerWidth - (this.modalX || 0) - 10));
                this.modalH = Math.max(240, Math.min(this.resizeStartH + dy, window.innerHeight - (this.modalY || 0) - 10));
            }
        },

        onEnd() {
            this.btnDragging = false;
            this.modalDragging = false;
            this.modalResizing = false;
        }
    }"
    @mousemove.window="onMove" @mouseup.window="onEnd" @touchmove.window="onMove" @touchend.window="onEnd">
        <button x-show="!showTips" @click.prevent="openTips()"
                @mousedown="startBtnDrag" @touchstart="startBtnDrag"
                class="fixed z-[9999] text-white px-3.5 py-2.5 md:p-4 rounded-full shadow-2xl flex items-center gap-1.5 md:gap-2 select-none"
                :style="`left: ${btnX}px; top: ${btnY}px; background-color: #eab308; touch-action: none;`"
                :class="btnDragging ? 'cursor-grabbing scale-105' : 'cursor-grab hover:scale-105 transition-transform'"
                title="Tips & Strategi">
            <svg class="w-5 h-5 md:w-6 md:h-6 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-bold text-xs md:text-sm text-white">Tips</span>
        </button>

        {{-- Draggable, Resizable, Pinnable Tips Modal --}}
        <template x-teleport="body">
            <div x-show="showTips" style="display: none;" class="fixed inset-0 z-[100] pointer-events-none">
                
                {{-- Dark Backdrop (Only active when NOT pinned) --}}
                <div x-show="!isPinned" 
                     @click="showTips = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="absolute inset-0 bg-black/25 pointer-events-auto cursor-pointer">
                </div>

                <div x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="fixed bg-white rounded-2xl flex flex-col shadow-2xl border border-gray-300 pointer-events-auto overflow-hidden"
                     :style="`left: ${modalX ?? 20}px; top: ${modalY ?? 20}px; width: ${modalW}px; height: ${modalH}px; max-width: 95vw; max-height: 90vh; min-width: 320px; min-height: 240px;`">
                    
                    {{-- Seamless Header Drag Bar (Symbol Controls Only) --}}
                    {{-- Seamless Header Drag Bar (Symbol Controls Only) --}}
                    <div @mousedown="startModalDrag" @touchstart="startModalDrag"
                         class="flex items-center justify-between px-4 py-3 select-none cursor-grab active:cursor-grabbing flex-shrink-0 bg-white">
                        <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
                            <span class="w-2 h-2 rounded-full bg-amber-400 inline-block animate-pulse"></span>
                            <span class="text-[11px] font-medium text-gray-400">Tips & Strategi</span>
                        </div>

                        {{-- Control Icon Buttons (Pin & Close as symbols only) --}}
                        <div class="flex items-center gap-1.5 shrink-0">
                            {{-- Pin Icon Only --}}
                            <button type="button" @click="isPinned = !isPinned" 
                                    class="w-8 h-8 rounded-full transition flex items-center justify-center cursor-pointer text-sm"
                                    :class="isPinned ? 'bg-amber-500 text-white shadow-md ring-2 ring-amber-300' : 'bg-white hover:bg-gray-200 text-gray-600'"
                                    :title="isPinned ? 'Unpin modal' : 'Pin modal'">
                                
                            </button>

                            {{-- Close Icon Only --}}
                            <button type="button" @click="showTips = false" 
                                    class="w-8 h-8 rounded-full bg-white hover:bg-gray-200 text-gray-500 hover:text-gray-800 transition flex items-center justify-center cursor-pointer"
                                    title="Tutup">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Modal Content --}}
                    <div class="p-6 md:p-8 overflow-y-auto bg-white space-y-8">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-2 flex items-center gap-2">
                                Strategi Utama
                            </h3>
                            <p class="text-gray-600 bg-white p-4 rounded-xl border border-gray-200">Baca <strong>hanya clue saja</strong>. Begitu timer mencapai <strong>detik ke-25 ke atas</strong>, langsung tutup dengan conclusion.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <div class="bg-white px-4 py-3 border-b border-gray-200">
                                    <h4 class="font-bold text-gray-800">OPSI 1 <span class="text-sm font-normal text-gray-500">(Umum/Gambar)</span></h4>
                                </div>
                                <div class="p-4 space-y-4 text-sm">
                                    <div class="text-gray-600 font-medium italic bg-white p-3 rounded-lg border border-gray-100">
                                        "From the following picture I know information about [title]. According to the picture I notice with [clues]. furthermore it explains about [clues] moreover it has [clues] additionally it addresses about [clues], to sum up the picture shows good essential information of [title]."
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-600 uppercase mb-1">Example (Supermarket):</p>
                                        <p class="text-gray-600 leading-relaxed">
                                            "From the following picture I know information about <span class="font-semibold text-gray-800">Supermarket</span>. According to the picture I notice <span class="font-semibold text-gray-800">a lot of produce in this supermarket</span>. furthermore it explain about <span class="font-semibold text-gray-800">several sections</span> moreover it has <span class="font-semibold text-gray-800">fruit sections and vegetable sections with variety samples</span> additionally it addresses about <span class="font-semibold text-gray-800">peach, apple, plum, oranges, watermelon, cabbage, eggplant, lettuce, and others</span>, to sum up the picture shows good essential information of <span class="font-semibold text-gray-800">the best Supermarket in town</span>."
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <div class="bg-white px-4 py-3 border-b border-gray-200">
                                    <h4 class="font-bold text-gray-800">OPSI 2 <span class="text-sm font-normal text-gray-500">(Chart/Graph)</span></h4>
                                </div>
                                <div class="p-4 space-y-4 text-sm">
                                    <div class="text-gray-600 font-medium italic bg-white p-3 rounded-lg border border-gray-100">
                                        "From the following [chart/topic/graph/image] I know this information is about [title]. According to the graph, the percentage of [option items] from about [percentage] in [year] to about [percentage] in [year]. What's more, there are many percentages from the lowest until the highest. The lowest is [percentage] and the highest [percentage]. To sum up, the picture is about [title]."
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-600 uppercase mb-1">Example (Trend):</p>
                                        <p class="text-gray-600 leading-relaxed">
                                            "The provided chart illustrates the growth of <span class="font-semibold text-gray-800">Online purchase Trend</span>. According to the graph, the percentage of <span class="font-semibold text-gray-800">China</span> increased from about <span class="font-semibold text-gray-800">12%</span> in <span class="font-semibold text-gray-800">2016</span> to about <span class="font-semibold text-gray-800">23%</span> in <span class="font-semibold text-gray-800">2026</span>. What's more, there is a wide range of percentages from the lowest until the highest; the lowest is <span class="font-semibold text-gray-800">6%</span> recorded in the early stages, and the highest reaches <span class="font-semibold text-gray-800">38%</span> in the most recent projection. To sum up, the picture is about the significant upward <span class="font-semibold text-gray-800">trend of Online purchase Trend</span>."
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                                Tips Describe Image
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">1. Manajemen Waktu (Time Management)</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Durasi Ideal:</strong> Waktu terbaik untuk menjawab adalah sekitar <strong>35 - 38 detik</strong>.</li>
                                            <li><strong>Segera Klik "Next":</strong> Jangan menunggu sampai progress bar habis (40 detik). Segera klik tombol "Next" tepat setelah Anda mengucapkan kesimpulan untuk menghindari AI merekam keheningan (dead air) atau suara napas yang bisa merusak skor kelancaran.</li>
                                        </ul>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">2. Kelancaran & Intonasi</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Kestabilan Suara:</strong> Jaga fluency (kelancaran) dan intonasi agar tetap stabil.</li>
                                            <li><strong>Haram Hukumnya Berjeda:</strong> Usahakan tidak membuat jeda yang tidak wajar (seperti umm, ahh, atau terdiam mikir) di tengah kalimat. Algoritma AI sangat sensitif terhadap keraguan (hesitation); skor akan turun drastis jika Anda terputus-putus.</li>
                                            <li><strong class="text-red-600">Jangan Koreksi Diri Sendiri (PENTING):</strong> Jika Anda salah mengucapkan sebuah kata, JANGAN diulangi atau diperbaiki. Teruslah berbicara seolah-olah tidak terjadi kesalahan. Bagi AI PTE: <strong>Fluency > Content</strong>.</li>
                                            <li><strong>Tempo Bicara:</strong> Kelancaran bukan berarti berbicara secepat kilat. Bicaralah dengan tempo normal yang jelas artikulasinya.</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">3. Variasi Kosakata & Transisi</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Gunakan Conjunction Variatif:</strong> Gunakan kata hubung yang kaya untuk merangkai ide, seperti: <em>Firstly, Moreover, Additionally, Furthermore, Subsequently, In contrast,</em> dan <em>Lastly/To conclude</em>.</li>
                                            <li><strong>Hindari Repetisi:</strong> Jangan menggunakan conjunction atau kosakata yang sama berulang-ulang secara berdekatan (misal: terus-terusan memakai kata <em>And then, I can see, we can see, in front of,</em> atau <em>Also</em>).</li>
                                        </ul>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">4. Pengembangan Konten Grafik</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Analisis Komprehensif:</strong> Jangan hanya menyebutkan titik tertinggi dan terendah.</li>
                                            <li><strong>Jelaskan Pergerakan Data:</strong> Tambahkan penjelasan terkait: Tren kenaikan, Tren penurunan, Fluktuasi, atau Rata-rata/Kesetaraan data.</li>
                                        </ul>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">5. Improvisasi & Darurat</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Kembangkan Kalimat:</strong> Improvisasikan kalimat turunan untuk menunjang nilai Konten. Gabungkan beberapa elemen gambar menjadi satu kalimat utuh.</li>
                                            <li><strong>Taktik Jika Nge-blank:</strong> Jika di detik ke-20 Anda kehabisan ide, jangan diam! Sebutkan saja warna yang ada di gambar, bentuk objek, atau baca teks apa pun yang terlihat di layar untuk menjaga mulut tetap bergerak sampai mendekati detik ke-35.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Interactive Drag Resize Handle Corner --}}
                    <div @mousedown.stop="startResize" @touchstart.stop="startResize"
                         class="absolute bottom-0 right-0 w-9 h-9 cursor-se-resize flex items-center justify-center z-30 hover:scale-110 transition-all bg-amber-500/20 rounded-tl-xl hover:bg-amber-500 hover:text-white text-amber-600 shadow-md border-t border-l border-amber-300/50"
                         style="touch-action: none;"
                         title="Tarik sudut ini untuk mengukur ulang window tips">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 16v-4h-2v2h-2v2h4zM16 8v-2h-2v2h2zM12 12v-2h-2v2h2zM8 16v-2h-2v2h2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @include('components.pte-practice-tracker', ['module' => 'describe-image', 'topicId' => $topicId])
    <x-live-drawing />
</body>
</html>
