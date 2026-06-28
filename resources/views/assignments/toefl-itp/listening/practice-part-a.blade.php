<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Listening Practice Part A - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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

            <style>
            .lp-folder-card {
                transition: box-shadow 0.22s cubic-bezier(.4,2,.3,1), transform 0.16s cubic-bezier(.4,2,.3,1);
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
                border-radius: 1.25rem;
                box-shadow: 0 4px 16px 0 rgba(30,64,175,0.12);
                border: 1.5px solid rgba(255,255,255,0.15);
                position: relative;
                overflow: hidden;
            }
            .lp-folder-card::before {
                content: '';
                position: absolute;
                top: -40%;
                right: -20%;
                width: 180px;
                height: 180px;
                border-radius: 50%;
                background: rgba(255,255,255,0.06);
                pointer-events: none;
            }
            .lp-folder-card:hover {
                box-shadow: 0 12px 36px 0 rgba(30,64,175,0.22), 0 2px 8px 0 rgba(30,64,175,0.12);
                transform: translateY(-5px) scale(1.02);
            }
            .lp-folder-music {
                background: rgba(255,255,255,0.18);
                color: #fff;
                border-radius: 0.9rem;
                width: 2.6rem;
                height: 2.6rem;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(4px);
            }
            .lp-badge {
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                border-radius: 0.5rem;
                padding: 0.2rem 0.55rem;
                background: rgba(255,255,255,0.22);
                color: #fff;
                white-space: nowrap;
                flex-shrink: 0;
                border: 1px solid rgba(255,255,255,0.3);
            }
            .lp-badge-soon {
                background: rgba(148,163,184,0.25);
                color: rgba(255,255,255,0.7);
                border-color: rgba(255,255,255,0.15);
            }
            .lp-folder-title {
                color: #fff;
                font-size: 1.25rem;
                font-weight: 800;
                line-height: 1.2;
                letter-spacing: -0.01em;
                text-shadow: 0 1px 3px rgba(0,0,0,0.15);
            }
            .lp-folder-desc {
                color: rgba(219,234,254,0.85);
                font-size: 0.82rem;
                font-weight: 500;
                margin-top: 0.2rem;
            }
            .lp-folder-btn {
                display: block;
                width: 100%;
                font-size: 0.92rem;
                font-weight: 700;
                border-radius: 0.75rem;
                padding: 0.65rem 1rem;
                background: linear-gradient(90deg, #ef4444 0%, #f97316 100%);
                color: #fff;
                text-align: center;
                box-shadow: 0 2px 8px 0 rgba(239,68,68,0.25);
                transition: background 0.18s, box-shadow 0.18s, transform 0.13s;
                letter-spacing: 0.01em;
            }
            .lp-folder-btn:hover {
                background: linear-gradient(90deg, #dc2626 0%, #ea580c 100%);
                box-shadow: 0 4px 16px 0 rgba(239,68,68,0.35);
                transform: scale(1.02);
            }
            .lp-folder-btn-soon {
                background: rgba(148,163,184,0.25);
                color: rgba(255,255,255,0.6);
                box-shadow: none;
                cursor: not-allowed;
                border: 1px solid rgba(255,255,255,0.15);
            }
            </style>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5 px-2 py-2">
                @foreach(($ranges ?? collect()) as $index => $range)
                    @php
                        $hasQuestions = (int) ($range['question_count'] ?? 0) > 0;
                    @endphp
                    <div class="lp-folder-card {{ $hasQuestions ? '' : 'opacity-70' }} p-5 flex flex-col gap-4">
                        {{-- Top row: icon + title + badge --}}
                        <div class="flex items-start gap-3">
                            <div class="lp-folder-music mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-2v13"></path>
                                    <circle cx="6" cy="18" r="3" fill="currentColor"/>
                                    <circle cx="18" cy="16" r="3" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="lp-folder-title">Soal {{ $range['label'] }}</div>
                                <div class="lp-folder-desc">{{ $hasQuestions ? ($range['question_count'] . ' soal tersedia') : 'Belum ada soal' }}</div>
                            </div>
                            <span class="lp-badge {{ $hasQuestions ? '' : 'lp-badge-soon' }}">
                                {{ $hasQuestions ? 'AVAILABLE' : 'COMING SOON' }}
                            </span>
                        </div>
                        {{-- Button --}}
                        <div class="mt-auto">
                            @if($hasQuestions)
                                <a href="{{ route('assignments.toefl-itp.listening.practice.part-a.range', ['start' => $range['start'], 'end' => $range['end']]) }}" class="lp-folder-btn">Buka Soal {{ $range['label'] }} &rarr;</a>
                            @else
                                <span class="lp-folder-btn lp-folder-btn-soon">Coming Soon</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </main>
    </div>
</body>
</html>
