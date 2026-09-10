<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $trackData['title'] }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#2563EB] text-slate-900 min-h-screen relative overflow-x-hidden">
    <!-- Ambient Graphic Shapes in Blueprint Style -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-[36rem] h-[36rem] bg-blue-400/30 rounded-full blur-3xl filter"></div>
        <div class="absolute top-1/2 -right-32 w-[32rem] h-[32rem] bg-cyan-400/25 rounded-full blur-3xl filter"></div>
        <div class="absolute -bottom-32 left-1/3 w-[36rem] h-[36rem] bg-indigo-500/30 rounded-full blur-3xl filter"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#60a5fa_1px,transparent_1px)] [background-size:32px_32px] opacity-25"></div>
    </div>
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 min-w-0 md:ml-64 p-4 sm:p-6 lg:p-10 w-full transition-all duration-200">
            <div class="max-w-6xl mx-auto w-full space-y-8">
                <!-- MAIN FLOATING WHITE CANVAS (Reference Style) -->
                <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border border-white/80 space-y-8">
                <div class="mb-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                    <div class="flex items-start gap-4">
                        <div class="p-4 rounded-3xl shadow-lg bg-gradient-to-br {{ $trackData['gradient'] ?? 'from-rose-500 to-rose-700' }} text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2v4c0 1.105 1.343 2 3 2s3-.895 3-2V10c0-1.105-1.343-2-3-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18h6a2 2 0 002-2v-3l4 3V5l-4 3V5a2 2 0 00-2-2H9a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white text-gray-600 text-sm font-semibold shadow-sm mb-3">
                                <span>{{ count($trackData['meetings']) }} Meetings</span>
                            </div>
                            <h1 class="text-4xl font-bold text-gray-900">{{ $trackData['title'] }}</h1>
                            <p class="text-gray-600 mt-2">{{ $trackData['description'] }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ $trackData['summary'] }}</p>

                            @php
                                $activeBatchLabel = $selectedClassPeriod->name ?? 'No Batch Active';
                            @endphp
                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-white text-rose-700 font-semibold border border-rose-100 text-xs">
                                    Active Batch: {{ $activeBatchLabel }}
                                </span>

                                @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                    <form action="{{ route('assignments.batch-period') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                                        @csrf
                                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                                        <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                                        <select name="class_period_id" class="border-none bg-white rounded-lg text-sm focus:ring-2 focus:ring-rose-500 min-w-[220px]">
                                            @php
                                        $activeBatches = $program->classPeriods->where('status', 'active');
                                    @endphp
                                    @if($activeBatches->isEmpty())
                                        <option value="" disabled selected>No active batch</option>
                                    @else
                                        @foreach($activeBatches->sortByDesc('start_date') as $classPeriod)
                                                    <option value="{{ $classPeriod->id }}" {{ $program->active_class_period_id === $classPeriod->id ? 'selected' : '' }}>
                                                        {{ $classPeriod->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <button type="submit" class="p-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition" title="Apply batch" data-loading-label="Applying">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                                        <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                                        <span class="px-3 py-2 bg-white rounded-lg text-sm text-gray-700">
                                            {{ $activeBatchLabel }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @php
                        $calendarClassPeriodId = $selectedClassPeriod->id ?? Auth::user()->class_period_id ?? optional($program->classPeriods->first())->id ?? '';
                        $calendarBatchName = $trackData['title'];
                    @endphp
                    <div class="flex items-center gap-3">
                        @if($calendarClassPeriodId)
                            <button type="button" onclick="(function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Lihat Kalender
                            </button>
                        @else
                            <button type="button" onclick="alert('Pilih batch kelas terlebih dahulu untuk melihat kalender.');" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-400 rounded-xl shadow-sm cursor-not-allowed border border-gray-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Lihat Kalender
                            </button>
                        @endif
                        <a href="{{ route('assignments.speaking.classes') }}" class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($trackData['meetings'] as $meeting)
                        @php
                            $dbMeeting = isset($program) ? $program->meetings->firstWhere('meeting_number', $meeting['source_meeting_number']) : null;
                        @endphp
                        <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition overflow-hidden border border-gray-100 relative">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4 gap-4">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.2em] text-rose-500 font-semibold">{{ $trackData['title'] }}</p>
                                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $meeting['title'] }}</h2>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        @if($dbMeeting)
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $dbMeeting->is_locked ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                                {{ $dbMeeting->is_locked ? 'LOCKED' : 'OPEN' }}
                                            </span>
                                            
                                            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                                <form action="{{ route('assignments.meeting.toggle-lock', $dbMeeting->id) }}" method="POST">
                                                    @csrf
                                                    @if(isset($selectedClassPeriod))
                                                        <input type="hidden" name="class_period_id" value="{{ $selectedClassPeriod->id }}">
                                                    @endif
                                                    <button type="submit" class="text-gray-400 hover:text-gray-600 transition" title="Toggle Lock">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            @if($dbMeeting->is_locked)
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                                            @else
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                                            @endif
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $meeting['available'] ? 'bg-green-100 text-green-600' : 'bg-white text-gray-500' }}">
                                                {{ $meeting['available'] ? 'READY' : 'COMING SOON' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <p class="text-base font-semibold text-gray-800 mb-2">{{ $meeting['topic'] }}</p>
                                <p class="text-sm text-gray-500 leading-relaxed min-h-[48px]">{{ $meeting['description'] }}</p>

                                @php
                                    $isLocked = isset($dbMeeting) && $dbMeeting->is_locked && !(Auth::user()->isAdmin() || Auth::user()->isTeacher());
                                @endphp
                                @if($isLocked)
                                    <div class="mt-6 inline-flex items-center justify-center w-full rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                        Locked
                                    </div>
                                @else
                                    <a href="{{ route('assignments.speaking.meeting', ['level' => $level, 'meeting' => $meeting['source_meeting_number']]) }}" class="mt-6 inline-flex items-center justify-center w-full rounded-2xl bg-rose-500 hover:bg-rose-600 text-white font-bold px-4 py-3 text-sm shadow-md hover:shadow-lg transition-all duration-200 gap-2">
                                        <span>Open Meeting</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                @endif
                                
                                @if(isset($meeting['classMeeting']) && $meeting['classMeeting'])
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span>{{ $meeting['classMeeting']->meeting_date ? $meeting['classMeeting']->meeting_date->format('d M Y') : 'TBA' }}</span>
                                                <span class="mx-1">•</span>
                                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span>{{ $meeting['classMeeting']->start_time ? $meeting['classMeeting']->start_time->format('H:i') . ' - ' . $meeting['classMeeting']->end_time->format('H:i') . ' WIB' : 'TBA' }}</span>
                                            </div>
                                            @if($meeting['classMeeting']->meeting_link)
                                                <a href="{{ $meeting['classMeeting']->meeting_link }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-medium text-rose-600 hover:text-rose-700 mt-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                    Join Virtual Class
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>
            </div>
        </main>
    </div>

    @include('components.meetings-calendar-modal')
    @include('components.student-broadcaster')
    @include('components.floating-wa-button')
</body>
</html>
