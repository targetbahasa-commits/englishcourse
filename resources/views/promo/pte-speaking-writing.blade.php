<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['title'] }} | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        window.cfTurnstileToken = null;
        function onTurnstileVerified(token) { window.cfTurnstileToken = token; }
        function onTurnstileExpired() { window.cfTurnstileToken = null; }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">

    <div class="max-w-5xl mx-auto p-4 md:p-10 lg:p-12">
        <div class="flex items-center gap-3 mb-8">
            <img src="{{ asset('images/brand/icon.png') }}" class="w-9 h-9 md:w-12 md:h-12" alt="Target Bahasa">
            <div>
                <h1 class="text-lg md:text-2xl font-bold text-gray-800 leading-tight">{{ $test['title'] }}</h1>
                <p class="text-xs md:text-sm text-gray-500">Free PTE Academic Practice Test &mdash; Target Bahasa</p>
            </div>
        </div>

        {{-- Intro screen --}}
        <div id="introScreen" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 md:p-16 text-center">
            <div class="w-14 h-14 md:w-20 md:h-20 mx-auto mb-4 md:mb-6 rounded-2xl flex items-center justify-center" style="background-color:#e0f2fe;">
                <svg class="w-7 h-7 md:w-10 md:h-10" style="color:#0284c7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
            <h2 class="text-xl md:text-3xl font-bold text-gray-800 mb-2 md:mb-4">6 Tasks &middot; ~15 Minutes</h2>
            <p class="text-gray-600 md:text-lg mb-6 md:mb-8 max-w-md md:max-w-xl mx-auto">Anda akan mengerjakan 4 tugas Speaking (rekam suara) dan 2 tugas Writing, lalu mendapatkan estimasi skor PTE (10&ndash;90) dari AI secara instan. Pastikan mikrofon Anda aktif.</p>
            <button onclick="PteSpeakingWritingTest.start()" class="px-8 md:px-10 py-3 md:py-4 font-bold md:text-lg rounded-full shadow text-white hover:opacity-90 transition" style="background-color:#00b4d8;">
                Mulai Test Gratis
            </button>
        </div>

        {{-- Task screen --}}
        <div id="taskScreen" class="hidden">
            <div class="mb-4 flex items-center justify-between text-sm font-medium text-gray-500">
                <span id="taskProgressLabel">Task 1 of 6</span>
                <div class="flex-1 mx-4 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div id="taskProgressBar" class="h-full rounded-full transition-all duration-300" style="background-color:#00b4d8; width: 0%;"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-10 lg:p-12">
                <div class="font-bold text-lg md:text-xl px-5 py-3 md:py-4 rounded-xl mb-6 text-white" style="background-color:#00b4d8;" id="taskTitle"></div>

                <img id="taskImage" class="hidden max-w-full rounded-lg mb-6 border border-gray-200" />
                <p id="taskContent" class="text-base md:text-xl text-gray-800 leading-relaxed mb-6"></p>

                <p id="taskStatus" class="text-sm md:text-base font-bold mb-4" style="color:#00b4d8;">Click to Start</p>

                {{-- Speaking controls --}}
                <div id="speakingControls" class="hidden border border-amber-100/80 rounded-xl p-6 md:p-8 mb-4 flex items-center gap-4" style="background-color:#fffcf8;">
                    <button id="micBtn" onclick="PteSpeakingWritingTest.toggleRecording()" class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-white shadow" style="background-color:#e87a5d;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    </button>
                    <span id="speakingTime" class="text-xs font-mono font-bold text-gray-500 shrink-0">00:00</span>
                    <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                        <div id="speakingProgressBar" class="h-full rounded-full transition-all duration-300" style="background-color:#00b4d8; width: 0%;"></div>
                    </div>
                </div>

                {{-- Writing controls --}}
                <div id="writingControls" class="hidden">
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                        <span id="writingWordLimit"></span>
                        <span>Words: <span id="writingWordCount" class="font-bold" style="color:#00b4d8;">0</span></span>
                    </div>
                    <textarea id="writingAnswer" rows="8" class="w-full border border-gray-300 rounded-xl p-4 text-gray-800 focus:outline-none focus:ring-2" style="--tw-ring-color:#00b4d8;" placeholder="Tulis jawaban Anda di sini..." oninput="PteSpeakingWritingTest.onWritingInput()"></textarea>
                    <button onclick="PteSpeakingWritingTest.submitWriting()" class="mt-4 px-6 py-2.5 font-bold rounded-full shadow text-white hover:opacity-90 transition" style="background-color:#00b4d8;">Lanjut &rarr;</button>
                </div>
            </div>
        </div>

        {{-- Lead capture / submit screen --}}
        <div id="leadScreen" class="hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-1">Hampir Selesai!</h2>
            <p class="text-gray-600 mb-6">Masukkan data Anda untuk melihat estimasi skor PTE Anda.</p>
            <form onsubmit="event.preventDefault(); PteSpeakingWritingTest.submitAll();" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="leadName" required class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2" style="--tw-ring-color:#00b4d8;">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="leadEmail" required class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2" style="--tw-ring-color:#00b4d8;">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp (opsional)</label>
                    <input type="text" id="leadWhatsapp" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2" style="--tw-ring-color:#00b4d8;">
                </div>
                <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}" data-action="submit" data-callback="onTurnstileVerified" data-expired-callback="onTurnstileExpired"></div>
                <p id="leadError" class="hidden text-sm text-red-600"></p>
                <button type="submit" id="leadSubmitBtn" class="w-full px-6 py-3 font-bold rounded-full shadow text-white hover:opacity-90 transition" style="background-color:#00b4d8;">
                    Lihat Estimasi Skor PTE Saya
                </button>
            </form>
        </div>

        {{-- Scoring in progress screen --}}
        <div id="scoringScreen" class="hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-10 text-center">
            <svg class="animate-spin h-8 w-8 mx-auto mb-4" style="color:#00b4d8;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            <p class="text-gray-700 font-medium">Menilai jawaban Anda dengan AI, mohon tunggu...</p>
            <p class="text-gray-400 text-sm mt-1">Biasanya memakan waktu 30&ndash;60 detik.</p>
        </div>
    </div>

    <script>
        var PTE_TASKS = [
            { key: 'read_aloud', type: 'speaking', title: 'Read Aloud', content: @json($test['questions']['read_aloud']['text'] ?? ''), prep: {{ $test['questions']['read_aloud']['prep_time'] ?? 35 }}, record: {{ $test['questions']['read_aloud']['record_time'] ?? 40 }} },
            { key: 'repeat_sentence', type: 'speaking', title: 'Repeat Sentence', content: @json($test['questions']['repeat_sentence']['text'] ?? ''), prep: 3, record: 15 },
            { key: 'describe_image', type: 'speaking', title: 'Describe Image', content: @json($test['questions']['describe_image']['title'] ?? ''), image: @json($test['questions']['describe_image']['image'] ?? null), prep: {{ $test['questions']['describe_image']['prep_time'] ?? 25 }}, record: {{ $test['questions']['describe_image']['record_time'] ?? 40 }} },
            { key: 'retell_lecture', type: 'speaking', title: 'Re-tell Lecture', content: @json($test['questions']['retell_lecture']['transcript'] ?? ''), prep: {{ $test['questions']['retell_lecture']['prep_time'] ?? 10 }}, record: {{ $test['questions']['retell_lecture']['record_time'] ?? 40 }} },
            { key: 'summarize_written_text', type: 'writing', title: 'Summarize Written Text', content: @json($test['questions']['summarize_written_text']['passage'] ?? ''), wordLimit: @json($test['questions']['summarize_written_text']['word_limit'] ?? ''), timeLimit: {{ $test['questions']['summarize_written_text']['time_limit'] ?? 600 }} },
            { key: 'write_essay', type: 'writing', title: 'Write Essay', content: @json($test['questions']['write_essay']['topic'] ?? ''), wordLimit: @json($test['questions']['write_essay']['word_limit'] ?? ''), timeLimit: {{ $test['questions']['write_essay']['time_limit'] ?? 1200 }} },
        ];

        var PteSpeakingWritingTest = (function () {
            var currentIndex = -1;
            var answers = {}; // key -> Blob (speaking) or string (writing)
            var mediaRecorder = null;
            var audioChunks = [];
            var prepTimer = null, recordTimer = null, writingTimer = null;

            function fmt(s) {
                var m = Math.floor(s / 60), sec = s % 60;
                return (m < 10 ? '0' + m : m) + ':' + (sec < 10 ? '0' + sec : sec);
            }

            function start() {
                document.getElementById('introScreen').classList.add('hidden');
                document.getElementById('taskScreen').classList.remove('hidden');
                nextTask();
            }

            function nextTask() {
                clearAllTimers();
                currentIndex++;
                if (currentIndex >= PTE_TASKS.length) {
                    return showLeadScreen();
                }
                renderTask(PTE_TASKS[currentIndex]);
            }

            function renderTask(task) {
                document.getElementById('taskProgressLabel').textContent = 'Task ' + (currentIndex + 1) + ' of ' + PTE_TASKS.length;
                document.getElementById('taskProgressBar').style.width = (((currentIndex) / PTE_TASKS.length) * 100) + '%';
                document.getElementById('taskTitle').textContent = task.title;
                document.getElementById('taskContent').textContent = task.content;

                var img = document.getElementById('taskImage');
                if (task.image) {
                    img.src = task.image;
                    img.classList.remove('hidden');
                } else {
                    img.classList.add('hidden');
                }

                var speaking = document.getElementById('speakingControls');
                var writing = document.getElementById('writingControls');

                if (task.type === 'speaking') {
                    speaking.classList.remove('hidden');
                    writing.classList.add('hidden');
                    document.getElementById('taskStatus').textContent = 'Click the microphone to start';
                    document.getElementById('speakingTime').textContent = '00:00';
                    document.getElementById('speakingProgressBar').style.width = '0%';
                    resetMic();
                } else {
                    speaking.classList.add('hidden');
                    writing.classList.remove('hidden');
                    document.getElementById('taskStatus').textContent = '';
                    document.getElementById('writingWordLimit').textContent = task.wordLimit || '';
                    document.getElementById('writingWordCount').textContent = '0';
                    var textarea = document.getElementById('writingAnswer');
                    textarea.value = '';
                    startWritingTimer(task.timeLimit);
                }
            }

            function resetMic() {
                var micBtn = document.getElementById('micBtn');
                micBtn.style.background = '#e87a5d';
                micBtn.dataset.state = 'idle';
            }

            function toggleRecording() {
                var micBtn = document.getElementById('micBtn');
                var state = micBtn.dataset.state || 'idle';
                if (state === 'idle') {
                    startPrep();
                } else if (state === 'preparing') {
                    clearInterval(prepTimer);
                    startRecording();
                } else if (state === 'recording') {
                    stopRecording();
                }
            }

            function startPrep() {
                var task = PTE_TASKS[currentIndex];
                var micBtn = document.getElementById('micBtn');
                micBtn.dataset.state = 'preparing';
                micBtn.style.background = '#00b4d8';

                navigator.mediaDevices.getUserMedia({ audio: true }).then(function (stream) {
                    audioChunks = [];
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.ondataavailable = function (e) { if (e.data.size > 0) audioChunks.push(e.data); };
                    mediaRecorder.onstop = function () {
                        answers[task.key] = new Blob(audioChunks, { type: 'audio/webm' });
                        stream.getTracks().forEach(function (t) { t.stop(); });
                        document.getElementById('taskStatus').textContent = 'Recording saved. Moving to next task...';
                        setTimeout(nextTask, 800);
                    };

                    var prepLeft = task.prep;
                    document.getElementById('taskStatus').textContent = 'Get ready... ' + prepLeft + 's';
                    prepTimer = setInterval(function () {
                        prepLeft--;
                        document.getElementById('taskStatus').textContent = 'Get ready... ' + prepLeft + 's';
                        if (prepLeft <= 0) {
                            clearInterval(prepTimer);
                            startRecording();
                        }
                    }, 1000);
                }).catch(function () {
                    alert('Akses mikrofon diperlukan untuk melanjutkan test ini.');
                    micBtn.dataset.state = 'idle';
                });
            }

            function startRecording() {
                var task = PTE_TASKS[currentIndex];
                var micBtn = document.getElementById('micBtn');
                micBtn.dataset.state = 'recording';
                micBtn.style.background = '#ef4444';
                mediaRecorder.start();

                var elapsed = 0;
                document.getElementById('taskStatus').textContent = 'Recording...';
                recordTimer = setInterval(function () {
                    elapsed++;
                    document.getElementById('speakingTime').textContent = fmt(elapsed);
                    document.getElementById('speakingProgressBar').style.width = ((elapsed / task.record) * 100) + '%';
                    if (elapsed >= task.record) {
                        stopRecording();
                    }
                }, 1000);
            }

            function stopRecording() {
                clearInterval(recordTimer);
                if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                    mediaRecorder.stop();
                }
            }

            function startWritingTimer(seconds) {
                var left = seconds;
                writingTimer = setInterval(function () {
                    left--;
                    if (left <= 0) {
                        clearInterval(writingTimer);
                        submitWriting();
                    }
                }, 1000);
            }

            function onWritingInput() {
                var text = document.getElementById('writingAnswer').value.trim();
                var count = text ? text.split(/\s+/).length : 0;
                document.getElementById('writingWordCount').textContent = count;
            }

            function submitWriting() {
                clearInterval(writingTimer);
                var task = PTE_TASKS[currentIndex];
                answers[task.key] = document.getElementById('writingAnswer').value;
                nextTask();
            }

            function clearAllTimers() {
                clearInterval(prepTimer);
                clearInterval(recordTimer);
                clearInterval(writingTimer);
            }

            function showLeadScreen() {
                document.getElementById('taskScreen').classList.add('hidden');
                document.getElementById('leadScreen').classList.remove('hidden');
            }

            function submitAll() {
                var errorEl = document.getElementById('leadError');
                errorEl.classList.add('hidden');

                if (!window.cfTurnstileToken) {
                    errorEl.textContent = 'Mohon selesaikan verifikasi captcha.';
                    errorEl.classList.remove('hidden');
                    return;
                }

                var submitBtn = document.getElementById('leadSubmitBtn');
                submitBtn.disabled = true;

                document.getElementById('leadScreen').classList.add('hidden');
                document.getElementById('scoringScreen').classList.remove('hidden');

                var formData = new FormData();
                formData.append('name', document.getElementById('leadName').value);
                formData.append('email', document.getElementById('leadEmail').value);
                formData.append('whatsapp_number', document.getElementById('leadWhatsapp').value);
                formData.append('cf-turnstile-response', window.cfTurnstileToken);
                formData.append('read_aloud_audio', answers.read_aloud, 'read_aloud.webm');
                formData.append('repeat_sentence_audio', answers.repeat_sentence, 'repeat_sentence.webm');
                formData.append('describe_image_audio', answers.describe_image, 'describe_image.webm');
                formData.append('retell_lecture_audio', answers.retell_lecture, 'retell_lecture.webm');
                formData.append('summarize_written_text_answer', answers.summarize_written_text || '');
                formData.append('write_essay_answer', answers.write_essay || '');

                fetch('{{ route('promo.test.pte.speaking-writing.submit', $test['id']) }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                }).then(function (r) { return r.json(); }).then(function (data) {
                    if (data.success) {
                        window.location.href = '{{ url('/promo/test/pte/thank-you') }}/' + data.submission_id;
                    } else {
                        document.getElementById('scoringScreen').classList.add('hidden');
                        document.getElementById('leadScreen').classList.remove('hidden');
                        errorEl.textContent = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                        errorEl.classList.remove('hidden');
                        submitBtn.disabled = false;
                    }
                }).catch(function () {
                    document.getElementById('scoringScreen').classList.add('hidden');
                    document.getElementById('leadScreen').classList.remove('hidden');
                    errorEl.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                    errorEl.classList.remove('hidden');
                    submitBtn.disabled = false;
                });
            }

            return { start: start, toggleRecording: toggleRecording, submitWriting: submitWriting, onWritingInput: onWritingInput, submitAll: submitAll };
        })();
    </script>
</body>
</html>
