<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['label'] }} Result - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        <main class="flex-1 {{ Auth::user()->isAdmin() ? 'md:ml-64' : 'w-full' }} p-4 md:p-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
                    <p class="text-sm uppercase tracking-wide text-slate-500 font-semibold">Online Test Result</p>
                    <h1 class="text-3xl font-bold text-slate-900 mt-2">{{ $test['label'] }}</h1>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                            <p class="text-xs text-blue-500 uppercase">Status</p>
                            <p class="text-xl font-semibold text-blue-800 mt-1">{{ ucfirst((string) $result->status) }}</p>
                        </div>
                        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                            <p class="text-xs text-emerald-500 uppercase">Score</p>
                            <p class="text-xl font-semibold text-emerald-800 mt-1">{{ $result->score ?? 0 }}</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                            <p class="text-xs text-slate-500 uppercase">Time Spent</p>
                            <p class="text-xl font-semibold text-slate-800 mt-1">{{ gmdate('H:i:s', (int) ($result->time_spent_seconds ?? 0)) }}</p>
                        </div>
                    </div>

                    @php
                        $evaluation = $result->evaluation_data ?? [];
                        $answers = $result->answers_data ?? [];
                    @endphp

                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-slate-900 mb-3">Section Summary</h2>
                        <div class="space-y-3">
                            @foreach($test['sections'] as $section)
                                @php
                                    $sectionAnswer = trim((string) ($answers[$section['key']] ?? ''));
                                @endphp
                                <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $section['title'] }}</p>
                                        <p class="text-sm text-slate-500">{{ $section['question_count'] }} pertanyaan</p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $sectionAnswer !== '' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $sectionAnswer !== '' ? 'Answered' : 'Not answered' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        @if(!empty($evaluation))
                            <div class="mt-5 text-sm text-slate-600">
                                Answered sections: <span class="font-semibold">{{ $evaluation['answered_sections'] ?? 0 }}</span> / {{ $evaluation['total_sections'] ?? count($test['sections']) }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row items-center gap-4">
                        <a href="{{ route('online-test.show', ['slug' => $test['slug']]) }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-600 bg-white hover:bg-slate-50 font-medium text-center w-full sm:w-auto">Kembali ke Detail Test</a>
                        <form action="{{ route('online-test.end-session', ['slug' => $test['slug']]) }}" method="POST" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2.5 rounded-xl border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 font-medium text-center" onclick="return confirm('Apakah Anda yakin ingin mengakhiri sesi? Progress ujian yang sedang berjalan mungkin akan hilang.')">Selesai & Keluar</button>
                        </form>
                        <form action="{{ route('online-test.start', ['slug' => $test['slug']]) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">Ulangi Test</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
