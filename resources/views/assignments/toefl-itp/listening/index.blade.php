<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TOEFL ITP Listening - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        <main class="flex-1 md:ml-64 p-8 pb-24">
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 5.5L7 9H4v6h3l4.5 3.5V5.5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 9.5a4 4 0 010 5"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 7a7.5 7.5 0 010 10"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-600 bg-clip-text text-transparent">TOEFL ITP Listening</h1>
                    <p class="text-gray-600 mt-1">Practice your listening comprehension skills! 🎧</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.toefl-itp') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to TOEFL ITP
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-white text-blue-700 font-semibold border border-blue-100 text-xs">
                Active Batch: {{ $selectedClassPeriod->name ?? 'No Batch Active' }}
            </span>
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <form action="{{ route('assignments.batch-period') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $batchProgram?->id }}">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <select name="class_period_id" class="border-none bg-white rounded-lg text-sm focus:ring-2 focus:ring-blue-500 min-w-[220px]" {{ !$batchProgram ? 'disabled' : '' }}>
                        @if(!$batchProgram)
                            <option value="" selected>No program found</option>
                        @elseif($batchProgram->classPeriods->isEmpty())
                            <option value="" disabled selected>No batch available</option>
                        @else
                            @foreach($batchProgram->classPeriods->sortByDesc('start_date') as $classPeriod)
                                <option value="{{ $classPeriod->id }}" {{ $batchProgram->active_class_period_id === $classPeriod->id ? 'selected' : '' }}>
                                    {{ $classPeriod->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed" title="Apply batch" {{ !$batchProgram ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            @else
                <div class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-medium text-gray-800 min-w-[220px]">
                        {{ $selectedClassPeriod->name ?? 'No Batch Active' }}
                    </div>
                </div>
            @endif
            
            @php
                $calendarClassPeriodId = $selectedClassPeriod->id ?? Auth::user()->class_period_id ?? $batchProgram?->classPeriods?->first()?->id ?? '';
                $calendarBatchName = addslashes($batchProgram->name ?? 'Assignments');
            @endphp
            @if($calendarClassPeriodId)
                <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="px-4 py-2 bg-white border border-gray-200 rounded-xl hover:bg-white text-sm text-gray-600">
                    Lihat Kalender
                </button>
            @endif
        </div>
    </div>

    @php
        $curriculum = [
            'Part A: Dialogs' => [
                1 => 'Anticipating Questions about Dialogs',
                2 => 'Dialogs with Sound Confusion',
                3 => 'Dialogs with Homonyms and Words with Multiple Meanings',
                4 => 'Dialogs with Idiomatic Expressions',
                5 => 'Answering Inference Questions about Dialogs',
                6 => 'Dialogs Involving Agreement and Disagreement',
                7 => 'Dialogs Involving Suggestions, Invitations, Offers, and Requests',
                8 => 'Dialogs Involving Contradictions, Assumptions, and Questions',
                9 => 'Answering Questions about Activities, Plans, Topics, and Problems',
                10 => 'Dialogs with Special Verbs',
                101 => 'Mini Test Part A',
            ],
            'Part B: About Extended Conversations' => [
                11 => 'Anticipating Questions about the Extended Conversations',
                12 => 'Answering Overview Questions about Extended Conversations',
                13 => 'Answering Detail Questions about Extended Conversations',
                102 => 'Mini Test Part 2',
            ],
            'Part C: Mini-Talks' => [
                14 => 'Anticipating Questions about Mini-Talks',
                15 => 'Answering Overview Questions about Mini-Talks',
                16 => 'Answering Detail Questions about Mini-Talks',
                103 => 'Mini Test Part C',
            ],
        ];
    @endphp

    <div class="space-y-12">
        @foreach($curriculum as $sectionTitle => $lessons)
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $sectionTitle }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($lessons as $number => $title)
                        @php
                            // Find the meeting data from the controller passed variable
                            $meeting = collect($meetings)->firstWhere('number', $number);
                            // Fallback if not found (though controller provides 1-20)
                            if (!$meeting) continue;
                        @endphp

                        <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100">
                            {{-- Header: Status & Lock Buttons --}}
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 {{ $meeting['is_locked'] ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} rounded-full text-xs font-bold uppercase tracking-wide">
                                        {{ $meeting['is_locked'] ? 'Locked' : 'Open' }}
                                    </span>
                                    @if($meeting['completed'])
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-full text-xs font-bold flex items-center gap-1 shadow-sm">
                                            ✓ Skor: {{ round($meeting['score']) }}%
                                        </span>
                                    @endif
                                </div>
                                
                                @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                    <div class="flex gap-2">
                                        {{-- Meeting Lock Toggle --}}
                                        <form action="{{ route('assignments.toefl-itp.listening.toggle-lock', $number) }}" method="POST">
                                            @csrf
                                            @if($selectedClassPeriod)
                                                <input type="hidden" name="class_period_id" value="{{ $selectedClassPeriod->id }}">
                                            @endif
                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center p-1.5 rounded-lg border transition {{ $meeting['is_locked'] ? 'bg-red-50 text-red-600 border-red-200 hover:bg-red-100 hover:text-red-700' : 'bg-white text-emerald-600 border-emerald-200 hover:bg-white hover:text-emerald-700' }}"
                                                title="Toggle Meeting Lock"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($meeting['is_locked'])
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                                    @endif
                                                </svg>
                                            </button>
                                        </form>

                                        {{-- Transcript Lock Toggle --}}
                                        <form action="{{ route('assignments.toefl-itp.listening.toggle-transcript', $number) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="{{ $meeting['transcript_enabled'] ? 'text-purple-600 hover:text-purple-700' : 'text-gray-400 hover:text-gray-600' }} transition p-1 hover:bg-white rounded-full" title="Toggle Transcript">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($meeting['transcript_enabled'])
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" opacity="0.5"></path>
                                                    @endif
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Icon & Title -->
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 {{ $meeting['is_locked'] ? 'bg-white text-gray-400' : 'bg-white text-blue-600' }} rounded-xl flex items-center justify-center flex-shrink-0">
                                        <span class="font-bold text-lg">{{ $number }}</span>
                                    </div>
                                    <h3 class="font-bold text-gray-800 leading-tight line-clamp-2" title="{{ $title }}">{{ $title }}</h3>
                                </div>
                            </div>
                            
                            <!-- Score -->
                            @if($meeting['completed'])
                                <div class="mb-4 mt-2 py-2 px-3 bg-white rounded-xl border border-blue-100 flex items-center justify-between">
                                    <span class="text-xs font-bold text-blue-600 uppercase">Score</span>
                                    <span class="font-bold text-blue-700">{{ $meeting['score'] }}%</span>
                                </div>
                            @else
                                <div class="mb-4 mt-2 h-10"></div> <!-- Spacer for alignment -->
                            @endif
                            
                            <!-- Action Button -->
                            @if(!$meeting['is_locked'])
                                <a href="{{ route('assignments.toefl-itp.listening.meeting', $number) }}" 
                                   class="block w-full py-2.5 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition shadow-sm hover:shadow active:scale-95 text-sm">
                                    Start Lesson
                                </a>
                            @else
                                <button disabled class="block w-full py-2.5 bg-white text-gray-400 text-center rounded-xl font-bold cursor-not-allowed text-sm">
                                    Locked
                                </button>
                            @endif
                            
                            @php
                                $classMeeting = !empty($selectedClassPeriod) ? $selectedClassPeriod->classMeetings->firstWhere('meeting_number', $number) : null;
                                $canEditRecording = Auth::user()->isAdmin() || Auth::user()->isTeacher();
                            @endphp
                            @if($classMeeting || ($canEditRecording && !empty($selectedClassPeriod) && !empty($meeting['meeting_id'])))
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex flex-col gap-2">
                                        @if($classMeeting)
                                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span>{{ $classMeeting->meeting_date ? $classMeeting->meeting_date->format('d M Y') : 'TBA' }}</span>
                                                <span class="mx-0.5">•</span>
                                                <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <x-class-meeting-time
                                                    :meeting-id="$meeting['meeting_id']"
                                                    :class-period-id="$selectedClassPeriod->id"
                                                    :start-time="$classMeeting->start_time?->format('H:i')"
                                                    :end-time="$classMeeting->end_time?->format('H:i')"
                                                    :can-edit="$canEditRecording"
                                                />
                                            </div>
                                            @if($classMeeting->meeting_link)
                                                <a href="{{ $classMeeting->meeting_link }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 mt-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                    Join Virtual Class
                                                </a>
                                            @endif
                                        @endif
                                        @if(!empty($selectedClassPeriod) && !empty($meeting['meeting_id']))
                                            <x-class-meeting-recording-link
                                                :meeting-id="$meeting['meeting_id']"
                                                :class-period-id="$selectedClassPeriod->id"
                                                :recording-urls="$classMeeting->recording_urls ?? []"
                                                :recording-passwords="$classMeeting->recording_passwords ?? []"
                                                :can-edit="$canEditRecording"
                                                size="xs"
                                            />
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
        </main>
    </div>
    @include('components.meetings-calendar-modal')
    <x-meeting-progress-bar tracker-key="toefl-itp-listening" :total-meetings="count($meetings ?? []) ?: 20" />
</body>
</html>
