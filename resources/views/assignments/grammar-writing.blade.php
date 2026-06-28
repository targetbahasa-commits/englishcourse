<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Grammar for Writing</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div class="relative w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                </div>
                
                <div class="flex items-center gap-6">
                    @include('components.topbar-action-icons')
                    
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                @php
                    $successState = session('success_state');
                    $successClass = 'border-green-200 bg-green-50 text-green-800';
                    $successTitle = 'Meeting Opened';
                    if ($successState === 'locked') {
                        $successClass = 'border-red-200 bg-red-50 text-red-800';
                        $successTitle = 'Meeting Locked';
                    } elseif ($successState === 'batch') {
                        $successClass = 'border-blue-200 bg-blue-50 text-blue-800';
                        $successTitle = 'Batch Updated';
                    }
                @endphp
                <div id="success-flash" class="mb-6 rounded-xl border px-4 py-3 text-sm font-medium shadow-sm transition-opacity duration-500 {{ $successClass }}">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                        <span class="mt-0.5">
                            @if($successState === 'locked')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            @elseif($successState === 'batch')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </span>
                        <div>
                            <p class="font-bold text-xs uppercase tracking-wide">{{ $successTitle }}</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                        <button type="button" id="success-flash-close" class="opacity-70 hover:opacity-100 transition" aria-label="Close success message">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div id="error-flash" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm font-medium shadow-sm transition-opacity duration-500">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <div>
                                <p class="font-bold text-xs uppercase tracking-wide">Action Failed</p>
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                        <button type="button" id="error-flash-close" class="opacity-70 hover:opacity-100 transition" aria-label="Close error message">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Header & Period -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Grammar for Writing</h2>
                    <p class="text-gray-500 text-sm">Manage meetings and class period.</p>
                    <p class="text-xs mt-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-semibold border border-blue-100">
                            Active Batch: {{ $selectedClassPeriod->name ?? ($program->period ?: 'Not selected') }}
                        </span>
                        @if(!empty($isClassEnded) && Auth::user()->isStudent())
                            <span class="ml-2 inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 font-semibold border border-amber-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Practice Mode — Nilai tidak dilaporkan ke guru
                            </span>
                        @endif
                    </p>
                </div>
                @php
                    $calendarClassPeriodId = $selectedClassPeriod->id ?? Auth::user()->class_period_id ?? optional($program->classPeriods->first())->id ?? '';
                    $calendarBatchName = addslashes($program->name ?? 'Assignments');
                @endphp
                <div class="flex items-center gap-3">
                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <form action="{{ route('assignments.grammar-writing.period') }}" method="POST" class="js-submit-guard flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                            @csrf
                            <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                            <select name="class_period_id" class="border-none bg-gray-50 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 min-w-[220px]">
                                @if($program->classPeriods->isEmpty())
                                    <option value="" disabled selected>No batch available</option>
                                @else
                                    @foreach($program->classPeriods->sortByDesc('start_date') as $classPeriod)
                                        <option value="{{ $classPeriod->id }}" {{ $program->active_class_period_id === $classPeriod->id ? 'selected' : '' }}>
                                            {{ $classPeriod->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" title="Apply batch" data-loading-label="Applying">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </form>
                    @else
                        <div class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                            <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                            <div class="bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium text-gray-800 min-w-[220px]">
                                {{ $selectedClassPeriod->name ?? 'No Batch Active' }}
                            </div>
                        </div>
                    @endif
                    
                    @if($calendarClassPeriodId)
                        <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="px-4 py-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-sm text-gray-600">
                            Lihat Kalender
                        </button>
                    @endif

                    <a href="{{ route('assignments.grammar-writing.classes') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <!-- Meetings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach($program->meetings as $meeting)
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative">
                    @php $showAchievement = Auth::user()->isStudent(); @endphp
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 {{ $meeting->is_locked ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} rounded-full text-xs font-bold">
                            {{ $meeting->is_locked ? 'LOCKED' : 'OPEN' }}
                        </span>
                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <form action="{{ route('assignments.meeting.toggle-lock', $meeting) }}" method="POST" class="js-submit-guard">
                            @csrf
                            @if(!empty($selectedClassPeriod))
                                <input type="hidden" name="class_period_id" value="{{ $selectedClassPeriod->id }}">
                            @endif
                            <button type="submit" class="text-gray-400 hover:text-gray-600 transition" title="Toggle Lock" data-loading-label="Saving">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($meeting->is_locked)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    @endif
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                    
                    @if($showAchievement && isset($scores[$meeting->meeting_number]))
                        @php
                            $score = $scores[$meeting->meeting_number];
                            $scoreRounded = round($score / 10, 1);
                            
                            // Determine icon based on score range
                            if ($scoreRounded == 10) {
                                $icon = '💎';
                                $badge = 'Diamond';
                            } elseif ($scoreRounded >= 9.5) {
                                $icon = '👑';
                                $badge = 'Crown';
                            } elseif ($scoreRounded >= 9.0) {
                                $icon = '🥇';
                                $badge = 'Platinum';
                            } elseif ($scoreRounded >= 8.0) {
                                $icon = '🏆';
                                $badge = 'Gold';
                            } elseif ($scoreRounded >= 7.0) {
                                $icon = '🥈';
                                $badge = 'Silver';
                            } elseif ($scoreRounded >= 6.0) {
                                $icon = '⭐';
                                $badge = 'Score 6';
                            } elseif ($scoreRounded >= 5.0) {
                                $icon = '🌟';
                                $badge = 'Score 5';
                            } elseif ($scoreRounded >= 4.0) {
                                $icon = '💫';
                                $badge = 'Score 4';
                            } elseif ($scoreRounded >= 3.0) {
                                $icon = '🌠';
                                $badge = 'Score 3';
                            } elseif ($scoreRounded >= 2.0) {
                                $icon = '✨';
                                $badge = 'Score 2';
                            } elseif ($scoreRounded >= 1.0) {
                                $icon = '🎖️';
                                $badge = 'Score 1';
                            } else {
                                $icon = '⭕';
                                $badge = 'Empty';
                            }
                        @endphp
                        
                        <!-- Score Icon and Value -->
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl flex items-center justify-center border-2 border-blue-100 shadow-sm">
                            <span class="text-5xl">{{ $icon }}</span>
                        </div>
                            <span class="text-3xl font-bold text-gray-800">{{ number_format($score, 1) }}</span>
                        </div>
                    @else
                        <!-- Default Document Icon when no score -->
                        <div class="w-12 h-12 {{ $meeting->is_locked ? 'bg-gray-100 text-gray-400' : 'bg-blue-100 text-blue-600' }} rounded-2xl flex items-center justify-center mb-4 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    @endif
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $meeting->title }}</h3>
                    <p class="text-gray-500 text-sm mb-4">
                        {{ $meetingTopics[$meeting->meeting_number] ?? 'Grammar Exercises' }}
                    </p>
                    
                    @if(!$meeting->is_locked)
                        @php
                            $meetingNumber = (int) $meeting->meeting_number;
                            $meetingRouteName = 'assignments.grammar-writing.meeting' . $meetingNumber;
                            $hasMeetingRoute = \Illuminate\Support\Facades\Route::has($meetingRouteName);
                            $meetingStartUrl = $meetingNumber === 1
                                ? url('/assignments/grammar-writing/fast-track/meeting1')
                                : ($hasMeetingRoute ? route($meetingRouteName) : '#');
                        @endphp
                        @if($hasMeetingRoute)
                            <a href="{{ $meetingStartUrl }}" class="js-start-link block w-full py-2 {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white text-center rounded-xl font-bold transition">
                                {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : 'Start' }}
                            </a>
                        @else
                            <a href="#" class="block w-full py-2 bg-gray-400 text-white text-center rounded-xl font-bold hover:bg-gray-500 transition cursor-not-allowed">Start</a>
                        @endif
                    @else
                        <button disabled class="block w-full py-2 bg-gray-100 text-gray-400 text-center rounded-xl font-bold cursor-not-allowed">Locked</button>
                    @endif
                    
                    @if(isset($meeting->classMeeting) && $meeting->classMeeting)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>{{ $meeting->classMeeting->meeting_date ? $meeting->classMeeting->meeting_date->format('d M Y') : 'TBA' }}</span>
                                    <span class="mx-1">•</span>
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ $meeting->classMeeting->start_time ? $meeting->classMeeting->start_time->format('H:i') . ' - ' . $meeting->classMeeting->end_time->format('H:i') . ' WIB' : 'TBA' }}</span>
                                </div>
                                @if($meeting->classMeeting->meeting_link)
                                    <a href="{{ $meeting->classMeeting->meeting_link }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 mt-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Join Virtual Class
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <script>
        (function () {
            const setupFlash = (flashId, closeId, timeoutMs) => {
                const flash = document.getElementById(flashId);
                if (!flash) return;

                const hideFlash = () => {
                    flash.classList.add('opacity-0');
                    setTimeout(() => {
                        flash.remove();
                    }, 500);
                };

                const closeButton = document.getElementById(closeId);
                if (closeButton) {
                    closeButton.addEventListener('click', hideFlash);
                }

                setTimeout(hideFlash, timeoutMs);
            };

            const setupSubmitGuards = () => {
                document.querySelectorAll('form.js-submit-guard').forEach((form) => {
                    form.addEventListener('submit', () => {
                        const button = form.querySelector('button[type="submit"]');
                        if (!button || button.disabled) return;

                        button.disabled = true;
                        button.classList.add('opacity-60', 'cursor-not-allowed');

                        const loadingLabel = button.getAttribute('data-loading-label') || 'Saving';
                        button.setAttribute('aria-busy', 'true');
                        button.innerHTML = `<span class="inline-flex items-center gap-2 text-xs font-semibold"><svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-opacity="0.25" stroke-width="3"></circle><path d="M22 12a10 10 0 00-10-10" stroke-width="3"></path></svg>${loadingLabel}</span>`;
                    });
                });
            };

            const setupStartLinkGuards = () => {
                document.querySelectorAll('a.js-start-link').forEach((link) => {
                    link.addEventListener('click', (event) => {
                        if (link.dataset.loading === 'true') {
                            event.preventDefault();
                            return;
                        }

                        link.dataset.loading = 'true';
                        link.classList.add('opacity-70', 'cursor-wait', 'pointer-events-none');
                        link.innerHTML = '<span class="inline-flex items-center gap-2"><svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-opacity="0.25" stroke-width="3"></circle><path d="M22 12a10 10 0 00-10-10" stroke-width="3"></path></svg>Opening...</span>';
                    });
                });
            };

            setupFlash('success-flash', 'success-flash-close', 4000);
            setupFlash('error-flash', 'error-flash-close', 6000);
            setupSubmitGuards();
            setupStartLinkGuards();
        })();
    </script>

    @include('components.meetings-calendar-modal')
</body>
</html>
