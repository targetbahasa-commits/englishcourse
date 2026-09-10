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

        <form id="readingForm" onsubmit="event.preventDefault(); PteReadingTest.showLeadScreen();" class="space-y-6">

            @if(isset($test['questions']['rw_fib']))
            @php
                $rwPassage = $test['questions']['rw_fib']['passage'] ?? '';
                $rwOptions = $test['questions']['rw_fib']['options'] ?? [];
                $rwSegments = preg_split('/\[(.*?)\]/', $rwPassage, -1, PREG_SPLIT_DELIM_CAPTURE);
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-10 lg:p-12">
                <div class="font-bold text-lg md:text-xl px-5 py-3 md:py-4 rounded-xl mb-6 text-white" style="background-color:#00b4d8;">Reading &amp; Writing: Fill in the Blanks</div>
                <p class="text-sm text-gray-500 mb-4">Pilih kata yang paling tepat untuk setiap bagian yang kosong.</p>
                <p class="text-base md:text-lg text-gray-800 leading-loose">
                    @php $blankIndex = 0; @endphp
                    @foreach($rwSegments as $i => $segment)
                        @if($i % 2 === 0)
                            {{ $segment }}
                        @else
                            <select class="rw-fib-select inline-block border-2 rounded-lg px-2 py-1 mx-1 font-semibold" style="border-color:#00b4d8;" data-blank="{{ $blankIndex }}">
                                <option value="">Select...</option>
                                @foreach(($rwOptions[$blankIndex] ?? []) as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                            @php $blankIndex++; @endphp
                        @endif
                    @endforeach
                </p>
            </div>
            @endif

            @if(isset($test['questions']['reorder']))
            @php $paragraphs = $test['questions']['reorder']['paragraphs'] ?? []; @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-10 lg:p-12">
                <div class="font-bold text-lg md:text-xl px-5 py-3 md:py-4 rounded-xl mb-6 text-white" style="background-color:#00b4d8;">Re-order Paragraphs</div>
                <p class="text-sm text-gray-500 mb-4">Gunakan panah untuk menyusun paragraf ini menjadi urutan yang logis.</p>
                <div id="reorderList" class="space-y-2">
                    @foreach($paragraphs as $i => $p)
                        <div class="reorder-item flex items-start gap-3 border border-gray-200 rounded-lg p-3 bg-gray-50" data-original-index="{{ $i }}">
                            <div class="flex flex-col shrink-0">
                                <button type="button" onclick="PteReadingTest.moveParagraph(this, -1)" class="text-gray-400 hover:text-gray-700">&#9650;</button>
                                <button type="button" onclick="PteReadingTest.moveParagraph(this, 1)" class="text-gray-400 hover:text-gray-700">&#9660;</button>
                            </div>
                            <p class="text-gray-800 text-sm leading-relaxed">{{ $p }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(isset($test['questions']['reading_fib']))
            @php
                $fibPassage = $test['questions']['reading_fib']['passage'] ?? '';
                $fibWords = $test['questions']['reading_fib']['drag_words'] ?? [];
                $fibSegments = preg_split('/\[(.*?)\]/', $fibPassage, -1, PREG_SPLIT_DELIM_CAPTURE);
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-10 lg:p-12">
                <div class="font-bold text-lg md:text-xl px-5 py-3 md:py-4 rounded-xl mb-6 text-white" style="background-color:#00b4d8;">Reading: Fill in the Blanks</div>
                <p class="text-sm text-gray-500 mb-4">Pilih kata dari daftar kata untuk mengisi setiap bagian yang kosong.</p>
                <p class="text-base md:text-lg text-gray-800 leading-loose mb-4">
                    @php $fibBlankIndex = 0; @endphp
                    @foreach($fibSegments as $i => $segment)
                        @if($i % 2 === 0)
                            {{ $segment }}
                        @else
                            <select class="reading-fib-select inline-block border-2 rounded-lg px-2 py-1 mx-1 font-semibold" style="border-color:#00b4d8;" data-blank="{{ $fibBlankIndex }}">
                                <option value="">Select...</option>
                                @foreach($fibWords as $word)
                                    <option value="{{ $word }}">{{ $word }}</option>
                                @endforeach
                            </select>
                            @php $fibBlankIndex++; @endphp
                        @endif
                    @endforeach
                </p>
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
            <form onsubmit="event.preventDefault(); PteReadingTest.submitAll();" class="space-y-4">
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
        var PteReadingTest = (function () {
            function moveParagraph(btn, direction) {
                var item = btn.closest('.reorder-item');
                var list = document.getElementById('reorderList');
                var sibling = direction < 0 ? item.previousElementSibling : item.nextElementSibling;
                if (!sibling) return;
                if (direction < 0) {
                    list.insertBefore(item, sibling);
                } else {
                    list.insertBefore(sibling, item);
                }
            }

            function showLeadScreen() {
                document.getElementById('readingForm').classList.add('hidden');
                document.getElementById('leadScreen').classList.remove('hidden');
            }

            function collectAnswers() {
                var rwFibAnswers = [];
                document.querySelectorAll('.rw-fib-select').forEach(function (el) {
                    rwFibAnswers[parseInt(el.dataset.blank, 10)] = el.value;
                });

                var reorderAnswer = [];
                document.querySelectorAll('#reorderList .reorder-item').forEach(function (el) {
                    reorderAnswer.push(parseInt(el.dataset.originalIndex, 10));
                });

                var readingFibAnswers = [];
                document.querySelectorAll('.reading-fib-select').forEach(function (el) {
                    readingFibAnswers[parseInt(el.dataset.blank, 10)] = el.value;
                });

                return { rwFibAnswers: rwFibAnswers, reorderAnswer: reorderAnswer, readingFibAnswers: readingFibAnswers };
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

                var answers = collectAnswers();
                var formData = new FormData();
                formData.append('name', document.getElementById('leadName').value);
                formData.append('email', document.getElementById('leadEmail').value);
                formData.append('whatsapp_number', document.getElementById('leadWhatsapp').value);
                formData.append('cf-turnstile-response', window.cfTurnstileToken);
                answers.rwFibAnswers.forEach(function (v, i) { formData.append('rw_fib_answers[' + i + ']', v || ''); });
                answers.reorderAnswer.forEach(function (v, i) { formData.append('reorder_answer[' + i + ']', v); });
                answers.readingFibAnswers.forEach(function (v, i) { formData.append('reading_fib_answers[' + i + ']', v || ''); });

                fetch('{{ route('promo.test.pte.reading.submit', $test['id']) }}', {
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

            return { moveParagraph: moveParagraph, showLeadScreen: showLeadScreen, submitAll: submitAll };
        })();
    </script>
</body>
</html>
