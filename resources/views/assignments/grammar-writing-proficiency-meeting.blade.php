<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $meetingData['title'] }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-violet-50 via-fuchsia-50 to-rose-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <div class="max-w-5xl mx-auto">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <p class="text-sm uppercase tracking-[0.25em] text-violet-500 font-semibold">{{ $trackTitle }}</p>
                        <h1 class="text-4xl font-bold text-gray-900 mt-2">{{ $meetingData['title'] }}</h1>
                        <p class="text-xl font-semibold text-gray-700 mt-3">{{ $meetingData['topic'] }}</p>
                        <p class="text-gray-600 mt-3 max-w-2xl">{{ $meetingData['description'] }}</p>
                    </div>
                    <a href="{{ route('assignments.grammar-writing.track', 'proficiency') }}" class="inline-flex items-center gap-2 rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Proficiency
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="lg:col-span-2 rounded-3xl bg-white p-8 shadow-sm border border-violet-100">
                        <div class="inline-flex items-center rounded-full bg-violet-100 px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-violet-600">Lesson Focus</div>
                        <h2 class="text-2xl font-bold text-gray-900 mt-4">Tujuan meeting ini</h2>
                        <p class="text-gray-600 mt-3">Gunakan meeting ini sebagai sesi belajar mandiri untuk membangun kontrol grammar tingkat lanjut sebelum masuk ke writing task penuh.</p>

                        <div class="mt-6 space-y-4">
                            @foreach($meetingData['focus_points'] as $index => $focusPoint)
                                <div class="flex gap-4 rounded-2xl bg-violet-50 px-4 py-4">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-violet-600 text-sm font-bold text-white">{{ $index + 1 }}</div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $focusPoint }}</p>
                                        <p class="text-sm text-gray-600 mt-1">Latihan ini diarahkan untuk membangun akurasi dan fleksibilitas grammar pada konteks writing akademik.</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-3xl bg-gray-900 p-8 text-white shadow-sm">
                        <div class="text-sm font-semibold uppercase tracking-[0.2em] text-violet-300">Practice Flow</div>
                        <ol class="mt-5 space-y-4 text-sm text-gray-200">
                            <li class="rounded-2xl bg-white/10 px-4 py-4">Baca penjelasan konsep dan identifikasi pola grammar utamanya.</li>
                            <li class="rounded-2xl bg-white/10 px-4 py-4">Tulis 3-5 kalimat dengan target structure meeting ini.</li>
                            <li class="rounded-2xl bg-white/10 px-4 py-4">Edit kembali kalimat agar lebih formal, ringkas, dan tepat.</li>
                        </ol>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900">Suggested Output</h2>
                    <p class="text-gray-600 mt-3">Setelah menyelesaikan meeting ini, targetkan satu paragraf pendek yang menggunakan fokus grammar utama secara konsisten dan natural.</p>
                </div>
            </div>
        </main>
    </div>

    @include('components.student-broadcaster')
</body>
</html>