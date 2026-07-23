<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['label'] }} Exam - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-slate-100">
    @include('components.impersonation-banner')
    @if(!Auth::user()->isAdmin())
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">TB</div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent">Target Bahasa</span>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-medium rounded-xl transition-colors duration-200 text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @endif

    <div class="flex min-h-screen {{ !Auth::user()->isAdmin() ? 'max-w-7xl mx-auto w-full' : '' }}">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @endif

        <main class="flex-1 {{ Auth::user()->isAdmin() ? 'md:ml-64' : 'w-full' }} p-4 md:p-8" x-data="examTimer({{ (int) $test['duration_minutes'] * 60 }})" x-init="init()">
            <div class="max-w-5xl mx-auto">
                <div class="mb-6 flex items-center justify-between gap-3 flex-wrap">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $test['label'] }} - Exam Session</h1>
                        <p class="text-sm text-slate-500 mt-1">Isi jawaban per section, lalu submit sebelum waktu habis.</p>
                    </div>
                    <div class="px-4 py-2 rounded-xl bg-red-50 border border-red-200 text-red-700 font-semibold text-sm">
                        Timer: <span x-text="formatted"></span>
                    </div>
                </div>

                <form id="online-test-submit-form" action="{{ route('online-test.submit', ['slug' => $test['slug'], 'onlineTestResult' => $attempt->id]) }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="time_spent_seconds" :value="timeSpentSeconds">

                    @foreach($test['sections'] as $section)
                        <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <h2 class="text-lg font-semibold text-slate-800">{{ $section['title'] }}</h2>
                                <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">{{ $section['minutes'] }} menit</span>
                            </div>
                            <p class="text-sm text-slate-500 mb-3">{{ $section['question_count'] }} pertanyaan</p>
                            <textarea name="answers[{{ $section['key'] }}]" rows="5" class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis jawaban untuk section {{ $section['title'] }} di sini..."></textarea>
                        </section>
                    @endforeach

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('online-test.show', ['slug' => $test['slug']]) }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-600 bg-white hover:bg-slate-50 font-medium">Kembali</a>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">Submit Exam</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function examTimer(totalSeconds) {
            return {
                remaining: totalSeconds,
                total: totalSeconds,
                formatted: '00:00',
                timeSpentSeconds: 0,
                intervalId: null,
                init() {
                    this.updateDisplay();
                    this.intervalId = setInterval(() => {
                        this.remaining = Math.max(0, this.remaining - 1);
                        this.timeSpentSeconds = this.total - this.remaining;
                        this.updateDisplay();

                        if (this.remaining <= 0) {
                            clearInterval(this.intervalId);
                            document.getElementById('online-test-submit-form').submit();
                        }
                    }, 1000);
                },
                updateDisplay() {
                    const minutes = Math.floor(this.remaining / 60);
                    const seconds = this.remaining % 60;
                    this.formatted = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                }
            };
        }
    </script>
</body>

</html>
