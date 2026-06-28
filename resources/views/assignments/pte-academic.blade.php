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
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent">PTE Academic</h1>
                            <p class="text-gray-600 mt-1">Comprehensive PTE Academic computer-based preparation! 🖥️</p>
                            @if(!empty($isClassEnded) && Auth::user()->isStudent())
                                <p class="text-xs mt-2">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 font-semibold border border-amber-200 shadow-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Practice Mode — Nilai tidak dilaporkan ke guru
                                    </span>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $calendarClassPeriodId = Auth::user()->class_period_id ?? '';
                            $calendarBatchName = 'PTE Academic';
                        @endphp
                        @if($calendarClassPeriodId)
                            <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Lihat Kalender
                            </button>
                        @endif
                        <a href="{{ route('assignments.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Assignments
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sections Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $sections = [
                        ['title' => 'Speaking & Writing', 'desc' => 'Practice read aloud, repeat sentence, describe image, re-tell lecture, and essay tasks.', 'color' => 'orange', 'gradient' => 'from-orange-400 to-orange-600', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'route' => route('assignments.pte-academic.speaking-writing.index')],
                        ['title' => 'Reading', 'desc' => 'Fill in the blanks, multiple choice, reorder paragraphs, and reading comprehension tasks.', 'color' => 'blue', 'gradient' => 'from-blue-400 to-blue-600', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'route' => route('assignments.pte-academic.reading.index')],
                        ['title' => 'Listening', 'desc' => 'Summarize spoken text, multiple choice, fill blanks, highlight correct summary.', 'color' => 'purple', 'gradient' => 'from-purple-400 to-purple-600', 'icon' => 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828', 'route' => route('assignments.pte-academic.listening.index')],
                    ];
                @endphp
                @foreach($sections as $section)
                <a href="{{ $section['route'] }}"
                   @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('pte_')) localStorage.removeItem(k); });" @endif class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br {{ $section['gradient'] }} relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-{{ $section['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $section['icon'] }}"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $section['title'] }}</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $section['desc'] }}</p>
                        <div class="block w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-'.$section['color'].'-500 hover:bg-'.$section['color'].'-600' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : 'Start Learning' }}
                            @if(empty($isClassEnded) || !Auth::user()->isStudent())
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </main>
    </div>
    @include('components.meetings-calendar-modal')
    @include('components.floating-wa-button')
</body>
</html>
