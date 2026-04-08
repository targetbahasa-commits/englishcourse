<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Listening Practice Part A - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
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
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Listening Practice - Part A</h1>
                            <p class="text-gray-600 mt-1">Pilih rentang soal (1-270)</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.toefl-itp.listening.practice') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>

            </div>

            @php
                $palettes = [
                    [
                        'ring' => 'ring-blue-200/70',
                        'surface' => 'from-blue-50 to-indigo-50',
                        'icon' => 'bg-blue-600 text-white',
                        'accent' => 'text-blue-700',
                        'dot' => 'bg-blue-500',
                    ],
                    [
                        'ring' => 'ring-cyan-200/70',
                        'surface' => 'from-cyan-50 to-sky-50',
                        'icon' => 'bg-cyan-600 text-white',
                        'accent' => 'text-cyan-700',
                        'dot' => 'bg-cyan-500',
                    ],
                    [
                        'ring' => 'ring-emerald-200/70',
                        'surface' => 'from-emerald-50 to-teal-50',
                        'icon' => 'bg-emerald-600 text-white',
                        'accent' => 'text-emerald-700',
                        'dot' => 'bg-emerald-500',
                    ],
                    [
                        'ring' => 'ring-orange-200/70',
                        'surface' => 'from-orange-50 to-amber-50',
                        'icon' => 'bg-orange-600 text-white',
                        'accent' => 'text-orange-700',
                        'dot' => 'bg-orange-500',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 gap-6">
                @foreach(($ranges ?? collect()) as $index => $range)
                    @php
                        $hasQuestions = (int) ($range['question_count'] ?? 0) > 0;
                        $palette = $palettes[$index % count($palettes)];
                    @endphp
                    <a href="{{ route('assignments.toefl-itp.listening.practice.part-a.range', ['start' => $range['start'], 'end' => $range['end']]) }}"
                       class="group w-full text-left rounded-3xl border border-white/70 ring-1 {{ $palette['ring'] }} bg-gradient-to-br {{ $palette['surface'] }} px-5 py-5 transition duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1 block relative overflow-hidden {{ $hasQuestions ? '' : 'opacity-85' }}">
                        <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full bg-white/40 blur-xl"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-11 h-11 rounded-2xl {{ $palette['icon'] }} flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M10 4l2 2h8a2 2 0 012 2v9a3 3 0 01-3 3H5a3 3 0 01-3-3V6a2 2 0 012-2h6z"></path>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $hasQuestions ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $hasQuestions ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $hasQuestions ? 'Ready' : 'Empty' }}
                                </span>
                            </div>

                            <div class="text-3xl font-bold text-slate-800 leading-none">{{ $range['label'] }}</div>

                            <div class="mt-3 flex items-center justify-between">
                                <div class="text-xs font-semibold {{ $hasQuestions ? $palette['accent'] : 'text-slate-500' }}">
                                    {{ $hasQuestions ? (($range['question_count'] ?? 0) . ' soal tersedia') : 'Belum ada soal' }}
                                </div>
                                <div class="text-slate-500 group-hover:text-slate-700 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="mt-2 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full {{ $palette['dot'] }}"></span>
                                Klik untuk buka folder
                            </div>
                        </div>
                        <div class="absolute inset-0 rounded-3xl ring-1 ring-transparent group-hover:ring-white/60 pointer-events-none"></div>
                    </a>
                @endforeach
            </div>

        </main>
    </div>
</body>
</html>
