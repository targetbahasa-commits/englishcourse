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

        <form id="listeningForm" onsubmit="event.preventDefault(); PteListeningTest.showLeadScreen();" class="space-y-6">

            @if(isset($test['questions']['sst']))
            @php $sst = $test['questions']['sst']; @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-10 lg:p-12">
                <div class="font-bold text-lg md:text-xl px-5 py-3 md:py-4 rounded-xl mb-6 text-white" style="background-color:#00b4d8;">Summarize Spoken Text</div>
                <p class="text-sm text-gray-500 mb-4">{{ $sst['prompt'] ?? 'Dengarkan audio, lalu rangkum dalam satu paragraf.' }}</p>
                <button type="button" onclick="PteListeningTest.playAudio('sstAudio', 'sstPlayBtn')" id="sstPlayBtn" class="flex items-center gap-2 px-5 py-2.5 font-bold rounded-full shadow text-white hover:opacity-90 transition mb-4" style="background-color:#00b4d8;">
                    &#9654; Putar Audio
                </button>
                <audio id="sstAudio" src="{{ route('tts.stream', ['text' => $sst['transcript'] ?? '']) }}" preload="none"></audio>
                <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                    <span>{{ $sst['word_limit'] ?? '50-70 words' }}</span>
                    <span>Words: <span id="sstWordCount" class="font-bold" style="color:#00b4d8;">0</span></span>
                </div>
                <textarea id="sstAnswer" rows="5" class="w-full border border-gray-300 rounded-xl p-4 text-gray-800 focus:outline-none focus:ring-2" style="--tw-ring-color:#00b4d8;" placeholder="Tulis ringkasan Anda di sini..." oninput="PteListeningTest.onSstInput()"></textarea>
            </div>
            @endif

            @if(isset($test['questions']['wfd']))
            @php $sentences = $test['questions']['wfd']['sentences'] ?? []; @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-10 lg:p-12">
                <div class="font-bold text-lg md:text-xl px-5 py-3 md:py-4 rounded-xl mb-6 text-white" style="background-color:#00b4d8;">Write From Dictation</div>
                <p class="text-sm text-gray-500 mb-4">Dengarkan setiap kalimat, lalu ketik ulang persis seperti yang Anda dengar.</p>
                <div class="space-y-4">
                    @foreach($sentences as $i => $sentence)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex items-center gap-3 mb-2">
                            <button type="button" onclick="PteListeningTest.playAudio('wfdAudio{{ $i }}', 'wfdPlayBtn{{ $i }}')" id="wfdPlayBtn{{ $i }}" class="flex items-center gap-1 px-4 py-1.5 text-sm font-bold rounded-full text-white shadow hover:opacity-90 transition" style="background-color:#00b4d8;">
                                &#9654; Putar Kalimat {{ $i + 1 }}
                            </button>
                            <audio id="wfdAudio{{ $i }}" src="{{ route('tts.stream', ['text' => $sentence]) }}" preload="none"></audio>
                        </div>
                        <input type="text" class="wfd-answer w-full border border-gray-300 rounded-lg p-3" data-index="{{ $i }}" placeholder="Ketik kalimat yang Anda dengar...">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <button type="submit" class="w-full px-6 py-3 font-bold rounded-full shadow text-white hover:opacity-90 transition" style="background-color:#00b4d8;">
                Lihat Estimasi Skor PTE Saya
            </button>
        </form>

        {{-- Lead capture / submit screen --}}
        <div id="leadScreen" class="hidden bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-1">Hampir Selesai!</h2>
            <p class="text-gray-600 mb-6">Masukkan data Anda untuk melihat estimasi skor PTE Anda.</p>
            <form onsubmit="event.preventDefault(); PteListeningTest.submitAll();" class="space-y-4">
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
    </div>

    <script>
        var PteListeningTest = (function () {
            function playAudio(audioId, btnId) {
                var audio = document.getElementById(audioId);
                var btn = document.getElementById(btnId);
                if (!audio) return;
                btn.disabled = true;
                audio.currentTime = 0;
                audio.play();
                audio.onended = function () { btn.disabled = false; };
            }

            function onSstInput() {
                var text = document.getElementById('sstAnswer').value.trim();
                var count = text ? text.split(/\s+/).length : 0;
                document.getElementById('sstWordCount').textContent = count;
            }

            function showLeadScreen() {
                document.getElementById('listeningForm').classList.add('hidden');
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

                var formData = new FormData();
                formData.append('name', document.getElementById('leadName').value);
                formData.append('email', document.getElementById('leadEmail').value);
                formData.append('whatsapp_number', document.getElementById('leadWhatsapp').value);
                formData.append('cf-turnstile-response', window.cfTurnstileToken);

                var sstAnswer = document.getElementById('sstAnswer');
                if (sstAnswer) formData.append('sst_answer', sstAnswer.value);

                document.querySelectorAll('.wfd-answer').forEach(function (el) {
                    formData.append('wfd_answers[' + el.dataset.index + ']', el.value);
                });

                fetch('{{ route('promo.test.pte.listening.submit', $test['id']) }}', {
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
                        errorEl.textContent = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                        errorEl.classList.remove('hidden');
                        submitBtn.disabled = false;
                    }
                }).catch(function () {
                    errorEl.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                    errorEl.classList.remove('hidden');
                    submitBtn.disabled = false;
                });
            }

            return { playAudio: playAudio, onSstInput: onSstInput, showLeadScreen: showLeadScreen, submitAll: submitAll };
        })();
    </script>
</body>
</html>
