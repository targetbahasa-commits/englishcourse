<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PTE Academic - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @elseif(Auth::user()->isGuest() || Auth::user()->role === 'guest_quick')
            @include('components.sidebar-guest')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <!-- Header -->
            <div class="mb-6 bg-white border border-gray-100 rounded-3xl p-4 md:p-6 shadow-sm overflow-hidden">
                <div class="flex justify-end items-center gap-2 mb-2">
                    @php
                        $calendarClassPeriodId = Auth::user()->class_period_id ?? '';
                        $calendarBatchName = 'PTE Academic';
                    @endphp
                    @if($calendarClassPeriodId)
                        <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full transition-colors duration-200 shadow-sm shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Lihat Kalender</span>
                        </button>
                    @endif
                    <a href="{{ route('assignments.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Back</span>
                    </a>
                </div>

                <div class="flex items-center gap-3 md:gap-4">
                    <div class="p-3 bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl shadow-lg shrink-0">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent truncate">PTE Academic</h1>
                        <p class="text-xs md:text-sm text-gray-600 mt-0.5 break-words">Comprehensive PTE Academic computer-based preparation! 🖥️</p>
                        @if(!empty($isClassEnded) && Auth::user()->isStudent())
                            <p class="text-xs mt-2">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white text-amber-700 font-semibold border border-amber-200 shadow-sm">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Practice Mode — Nilai tidak dilaporkan ke guru</span>
                                </span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sections Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $sections = [
                        ['title' => 'Speaking & Writing', 'desc' => 'Practice read aloud, repeat sentence, describe image, re-tell lecture, summarize group discussion, respond to situation, and essay tasks.', 'color' => 'orange', 'gradient' => 'from-orange-400 to-orange-600', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'route' => route('assignments.pte-academic.speaking-writing.index')],
                        ['title' => 'Reading', 'desc' => 'Fill in the blanks, multiple choice, reorder paragraphs, and reading comprehension tasks.', 'color' => 'blue', 'gradient' => 'from-blue-400 to-blue-600', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'route' => route('assignments.pte-academic.reading.index')],
                        ['title' => 'Listening', 'desc' => 'Summarize spoken text, multiple choice, fill blanks, highlight correct summary.', 'color' => 'purple', 'gradient' => 'from-purple-400 to-purple-600', 'icon' => 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828', 'route' => route('assignments.pte-academic.listening.index')],
                    ];
                @endphp
                @foreach($sections as $section)
                <a href="{{ $section['route'] }}"
                   @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('pte_')) localStorage.removeItem(k); });" @endif class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-28 md:h-32 bg-gradient-to-br {{ $section['gradient'] }} relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-{{ $section['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $section['icon'] }}"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 md:p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $section['title'] }}</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed break-words">{{ $section['desc'] }}</p>
                        <div class="w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-'.$section['color'].'-500 hover:bg-'.$section['color'].'-600' }} text-white font-bold py-3 px-4 md:px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <span>{{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : 'Start Learning' }}</span>
                            @if(empty($isClassEnded) || !Auth::user()->isStudent())
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l5-5m5-5H6"></path></svg>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>   </div>

            @php
                $scores = $pteScores ?? [
                    'listening' => 0,
                    'reading'   => 0,
                    'speaking'  => 0,
                    'writing'   => 0,
                    'overall'   => 0,
                    'latest_date' => date('d M Y'),
                    'total_attempts' => 0,
                ];
                $ovr = $scores['overall'];
                $lScore = $scores['listening'];
                $rScore = $scores['reading'];
                $sScore = $scores['speaking'];
                $wScore = $scores['writing'];

                $ovrPct = $ovr > 0 ? max(5, min(100, (($ovr - 10) / 80) * 100)) : 0;
                $lPct   = $lScore > 0 ? max(5, min(100, (($lScore - 10) / 80) * 100)) : 0;
                $rPct   = $rScore > 0 ? max(5, min(100, (($rScore - 10) / 80) * 100)) : 0;
                $sPct   = $sScore > 0 ? max(5, min(100, (($sScore - 10) / 80) * 100)) : 0;
                $wPct   = $wScore > 0 ? max(5, min(100, (($wScore - 10) / 80) * 100)) : 0;

                $reportCode = strtoupper(substr(md5(Auth::id() . 'pte_academic_report'), 0, 10));
            @endphp

            <!-- Official Pearson PTE Academic Score Report Certificate -->
            <div class="mt-12 mb-10 bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden font-sans">
                <!-- Certificate Header Banner -->
                <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4" style="background-color: #f0fdfa;">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shadow-sm bg-gradient-to-br from-orange-500 to-amber-600">
                            <span class="text-xs font-black tracking-tighter">TB</span>
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-1.5 text-sm md:text-base font-medium text-gray-700">
                                <span class="font-bold tracking-tight text-gray-800 font-sans">Target Bahasa</span>
                                <span class="text-gray-300">|</span>
                                <span class="font-semibold text-gray-700">PTE Academic</span>
                                <span class="text-gray-300">|</span>
                                <span class="text-gray-600">Score Reports</span>
                            </div>
                            <div class="text-xs text-gray-500 font-mono mt-0.5">
                                Score Report Code: <span class="font-semibold text-gray-700">{{ $reportCode }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-emerald-800 text-xs font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Up to date Student Average Score
                        </span>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <!-- Top Student Info Row & Overall Score Card -->
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center gap-5">
                            <div class="relative">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-24 h-24 rounded-lg object-cover border-2 border-gray-300 shadow-md">
                                @else
                                    <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-slate-700 to-slate-900 text-white flex items-center justify-center text-3xl font-bold border-2 border-gray-300 shadow-md">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ Auth::user()->name }}</h3>
                                <div class="space-y-0.5 text-xs text-gray-600 font-medium">
                                    <p><span class="font-semibold text-gray-700">Test Taker ID:</span> PTE{{ sprintf('%08d', Auth::user()->id) }}</p>
                                    <p><span class="font-semibold text-gray-700">Registration ID:</span> 41{{ sprintf('%06d', Auth::user()->id) }}</p>
                                    <p><span class="font-semibold text-gray-700">Total Attempts:</span> {{ $scores['total_attempts'] }} Practice Tests</p>
                                </div>
                            </div>
                        </div>

                        <!-- Overall Score Pill (Plum background) -->
                        <div class="w-full md:w-auto flex flex-col items-center md:items-end">
                            <div class="rounded-2xl p-4 min-w-[140px] text-center shadow-lg border border-purple-800/30" style="background-color: #6b21a8;">
                                <div class="text-[11px] font-bold tracking-wider uppercase text-purple-100 bg-purple-900/60 px-3 py-1 rounded-full mb-2 inline-block">
                                    Overall Score
                                </div>
                                <div class="text-5xl font-black tracking-tight text-white py-1">
                                    {{ $ovr > 0 ? $ovr : '-' }}
                                </div>
                                <div class="text-[10px] text-purple-200 font-medium">
                                    Scale: 10 - 90
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Communicative Skills Circles -->
                    <div class="py-6 border-b border-gray-200">
                        <h4 class="text-lg font-bold text-gray-800 mb-6">Communicative Skills</h4>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                            <!-- Listening -->
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-extrabold text-slate-800 mb-2 shadow-inner" style="border: 5px solid #1e293b; background-color: #ffffff;">
                                    {{ $lScore > 0 ? $lScore : '-' }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700">Listening</span>
                            </div>

                            <!-- Reading -->
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-extrabold text-yellow-800 mb-2 shadow-inner" style="border: 5px solid #ca8a04; background-color: #ffffff;">
                                    {{ $rScore > 0 ? $rScore : '-' }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700">Reading</span>
                            </div>

                            <!-- Speaking -->
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-extrabold text-gray-700 mb-2 shadow-inner" style="border: 5px solid #6b7280; background-color: #ffffff;">
                                    {{ $sScore > 0 ? $sScore : '-' }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700">Speaking</span>
                            </div>

                            <!-- Writing -->
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-extrabold text-purple-900 mb-2 shadow-inner" style="border: 5px solid #9333ea; background-color: #ffffff;">
                                    {{ $wScore > 0 ? $wScore : '-' }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700">Writing</span>
                            </div>
                        </div>
                    </div>

                    <!-- Skills Breakdown & Candidate Information Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-6">
                        <!-- Left Column: Skills Breakdown Horizontal Progress Bars -->
                        <div class="pr-0 lg:pr-4">
                            <h4 class="text-lg font-bold text-gray-800 mb-6">Skills Breakdown</h4>
                            
                            <div class="space-y-4 relative pt-6">
                                @if($ovr > 0)
                                <!-- Vertical Overall Score Indicator Line -->
                                <div class="absolute top-0 bottom-0 pointer-events-none z-10 flex flex-col items-center" style="left: calc(75px + {{ $ovrPct }}% * 0.72);">
                                    <div class="bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow whitespace-nowrap -mt-2">
                                        {{ $ovr }} Overall
                                    </div>
                                    <div class="w-0.5 h-full bg-blue-500 opacity-60 border-dashed border-l border-blue-600"></div>
                                </div>
                                @endif

                                <!-- Listening Bar -->
                                <div class="flex items-center gap-3">
                                    <span class="w-20 text-xs font-semibold text-gray-600 text-right">Listening <strong class="text-gray-900 ml-1">{{ $lScore > 0 ? $lScore : '-' }}</strong></span>
                                    <div class="flex-1 bg-white rounded-full h-5 overflow-hidden p-0.5 shadow-inner border border-gray-200">
                                        <div class="h-full rounded-full transition-all duration-500" style="width: {{ $lPct }}%; background-color: #1e293b;"></div>
                                    </div>
                                </div>

                                <!-- Reading Bar -->
                                <div class="flex items-center gap-3">
                                    <span class="w-20 text-xs font-semibold text-gray-600 text-right">Reading <strong class="text-gray-900 ml-1">{{ $rScore > 0 ? $rScore : '-' }}</strong></span>
                                    <div class="flex-1 bg-white rounded-full h-5 overflow-hidden p-0.5 shadow-inner border border-gray-200">
                                        <div class="h-full rounded-full transition-all duration-500" style="width: {{ $rPct }}%; background-color: #ca8a04;"></div>
                                    </div>
                                </div>

                                <!-- Speaking Bar -->
                                <div class="flex items-center gap-3">
                                    <span class="w-20 text-xs font-semibold text-gray-600 text-right">Speaking <strong class="text-gray-900 ml-1">{{ $sScore > 0 ? $sScore : '-' }}</strong></span>
                                    <div class="flex-1 bg-white rounded-full h-5 overflow-hidden p-0.5 shadow-inner border border-gray-200">
                                        <div class="h-full rounded-full transition-all duration-500" style="width: {{ $sPct }}%; background-color: #6b7280;"></div>
                                    </div>
                                </div>

                                <!-- Writing Bar -->
                                <div class="flex items-center gap-3">
                                    <span class="w-20 text-xs font-semibold text-gray-600 text-right">Writing <strong class="text-gray-900 ml-1">{{ $wScore > 0 ? $wScore : '-' }}</strong></span>
                                    <div class="flex-1 bg-white rounded-full h-5 overflow-hidden p-0.5 shadow-inner border border-gray-200">
                                        <div class="h-full rounded-full transition-all duration-500" style="width: {{ $wPct }}%; background-color: #9333ea;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Candidate & Test Centre Information -->
                        <div>
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Candidate & Test Information</h4>
                            
                            <div class="bg-white p-4 rounded-xl border border-gray-200 text-xs space-y-3">
                                <div class="grid grid-cols-2 gap-y-2">
                                    <div>
                                        <span class="text-gray-500 block">Date of Birth:</span>
                                        <span class="font-semibold text-gray-800">{{ Auth::user()->dob ? date('d M Y', strtotime(Auth::user()->dob)) : '15 Jan 1998' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 block">Gender:</span>
                                        <span class="font-semibold text-gray-800">{{ ucfirst(Auth::user()->gender ?? 'Student') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 block">Country of Citizenship:</span>
                                        <span class="font-semibold text-gray-800">Indonesia</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 block">Country of Residence:</span>
                                        <span class="font-semibold text-gray-800">Indonesia</span>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-3">
                                    <span class="text-gray-700 font-bold block mb-2">Test Centre Information</span>
                                    <div class="grid grid-cols-2 gap-y-2">
                                        <div>
                                            <span class="text-gray-500 block">Test Centre Country:</span>
                                            <span class="font-semibold text-gray-800">Indonesia</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 block">Test Date:</span>
                                            <span class="font-semibold text-gray-800">{{ $scores['latest_date'] }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 block">Test Centre ID:</span>
                                            <span class="font-semibold text-gray-800">50404 (TB-PTE)</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 block">Valid Until:</span>
                                            <span class="font-semibold text-gray-800">{{ date('d M Y', strtotime($scores['latest_date'] . ' + 2 years')) }}</span>
                                        </div>
                                        <div class="col-span-2">
                                            <span class="text-gray-500 block">Test Centre:</span>
                                            <span class="font-semibold text-gray-800">Target Bahasa Course - Online Computer Test</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="mt-12 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-10">
                <div class="p-6 text-center border-b border-gray-100" style="background: linear-gradient(to right, #f8fafc, #f1f5f9);">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight uppercase">SKOR BREAKDOWN 2026</h2>
                </div>
                <div class="overflow-x-auto p-0">
                    <table class="w-full text-sm text-center border-collapse">
                        <thead>
                            <tr>
                                <th colspan="10" class="py-4 px-4 font-bold text-base md:text-lg" style="background: linear-gradient(to right, #0d9488, #14b8a6); color: white; border-bottom: 2px solid #0f766e;">
                                    PTE Content Question Types & Score Information Table V5 (Official Release)
                                </th>
                            </tr>
                            <tr style="background-color: #0f766e; color: white;" class="font-medium text-xs md:text-sm">
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Sequence</th>
                                <th colspan="2" class="py-3 px-2 border" style="border-color: #115e59;">Question Type</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Numbers</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Time for answering a question</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Overall</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Speaking</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Writing</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Reading</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Listening</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 bg-white align-middle [&>tr>td]:border [&>tr>td]:border-gray-200 [&>tr>td]:py-2 [&>tr>td]:px-2">
                            <!-- ROW 1 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>1</td>
                                <td class="font-semibold">RA</td>
                                <td rowspan="9" class="font-bold shadow-inner" style="background-color: #fff7ed; color: #c2410c; border: 2px solid #fdba74;">Speaking &amp; Writing<br>(76~84mins)</td>
                                <td>6~7</td>
                                <td class="text-xs text-gray-600">Preparation time: 35s or 40s<br>Answer time: 40s</td>
                                <td class="font-medium">4%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">9%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 2 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>2</td>
                                <td class="font-semibold">RS</td>
                                <td>10~12</td>
                                <td class="text-xs text-gray-600">No preparation time<br>Answer time: 15s</td>
                                <td class="font-medium">7%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">16%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">17%</td>
                            </tr>
                            <!-- ROW 3 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>3</td>
                                <td class="font-semibold">DI</td>
                                <td>5~6</td>
                                <td class="text-xs text-gray-600">Preparation time: 25s<br>Answer time: 40s</td>
                                <td class="font-medium">15%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">31%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 4 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>4</td>
                                <td class="font-semibold">RL</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Preparation time: 10s<br>Answer time: 40s</td>
                                <td class="font-medium">6%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">13%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">13%</td>
                            </tr>
                            <!-- ROW 5 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>5</td>
                                <td class="font-semibold">ASQ</td>
                                <td>5~6</td>
                                <td class="text-xs text-gray-600">No preparation time<br>Answer time: 10s</td>
                                <td class="font-medium">2%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">4%</td>
                            </tr>
                            <!-- ROW 6 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>6</td>
                                <td class="font-semibold">SGD</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Preparation time: 10s<br>Answer time: 2min</td>
                                <td class="font-medium">9%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">19%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">20%</td>
                            </tr>
                            <!-- ROW 7 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>7</td>
                                <td class="font-semibold">RTS</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Preparation time: 10s<br>Answer time: 40s</td>
                                <td class="font-medium">6%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">13%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 8 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>8</td>
                                <td class="font-semibold">SWT</td>
                                <td>2</td>
                                <td class="text-xs text-gray-600">10 mins per question (timed individually)</td>
                                <td class="font-medium">7%</td>
                                <td></td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">28%</td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">23%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 9 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>9</td>
                                <td class="font-semibold">WE</td>
                                <td>1</td>
                                <td class="text-xs text-gray-600">20 mins per question (timed individually)</td>
                                <td class="font-medium">7%</td>
                                <td></td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">31%</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 10 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>10</td>
                                <td class="font-semibold">FIB_Dropdown</td>
                                <td rowspan="5" class="font-bold shadow-inner" style="background-color: #eff6ff; color: #1d4ed8; border: 2px solid #93c5fd;">Reading<br>(23~30mins)</td>
                                <td>5~6</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 2 mins</td>
                                <td class="font-medium">7%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">25%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 11 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>11</td>
                                <td class="font-semibold">MCM_R</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">1%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">5%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 12 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>12</td>
                                <td class="font-semibold">RO</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1.5-2 mins</td>
                                <td class="font-medium">3%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">9%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 13 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>13</td>
                                <td class="font-semibold">FIB_Drag and Drop</td>
                                <td>4~5</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 2 mins</td>
                                <td class="font-medium">6%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">20%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 14 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>14</td>
                                <td class="font-semibold">MCS_R</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">3%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 15 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>15</td>
                                <td class="font-semibold">SST</td>
                                <td rowspan="8" class="font-bold shadow-inner" style="background-color: #faf5ff; color: #7e22ce; border: 2px solid #d8b4fe;">Listening<br>(31~39 mins)<br><br><span class="text-xs font-normal" style="color: #6b21a8;">&bull; SST is timed individually per question</span></td>
                                <td>1</td>
                                <td class="text-xs text-gray-600">Each question: 10 minutes (timed individually)</td>
                                <td class="font-medium">4%</td>
                                <td></td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">18%</td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">10%</td>
                            </tr>
                            <!-- ROW 16 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>16</td>
                                <td class="font-semibold">MCM_L</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">3%</td>
                            </tr>
                            <!-- ROW 17 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>17</td>
                                <td class="font-semibold">FIB_L</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 2 mins</td>
                                <td class="font-medium">3%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">8%</td>
                            </tr>
                            <!-- ROW 18 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>18</td>
                                <td class="font-semibold">HCS</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">3%</td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">2%</td>
                            </tr>
                            <!-- ROW 19 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>19</td>
                                <td class="font-semibold">MCS_L</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">2%</td>
                            </tr>
                            <!-- ROW 20 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>20</td>
                                <td class="font-semibold">SMW</td>
                                <td>1-2</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">1%</td>
                            </tr>
                            <!-- ROW 21 -->
                            <tr class="hover:bg-white transition-colors">
                                <td>21</td>
                                <td class="font-semibold">HIW</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 2 minutes</td>
                                <td class="font-medium">4%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">13%</td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">8%</td>
                            </tr>
                            <!-- ROW 22 -->
                            <tr class="hover:bg-white transition-colors" style="background-color: #f8fafc;">
                                <td>22</td>
                                <td class="font-semibold">WFD</td>
                                <td>3~4</td>
                                <td class="text-xs text-gray-600">2 minutes per question</td>
                                <td class="font-medium">5%</td>
                                <td></td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">23%</td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">13%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
    @include('components.meetings-calendar-modal')
    @include('components.floating-wa-button')
</body>
</html>
