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
            <div class="mb-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                    <div class="flex items-start gap-4">
                        <div class="p-4 rounded-3xl shadow-lg bg-gradient-to-br {{ $trackData['gradient'] }} text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
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
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-white text-blue-700 font-semibold border border-blue-100 text-xs">
                                    Active Batch: {{ $activeBatchLabel }}
                                </span>

                                @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                    <form action="{{ route('assignments.batch-period') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                                        @csrf
                                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                                        <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                                        <select name="class_period_id" class="border-none bg-white rounded-lg text-sm focus:ring-2 focus:ring-blue-500 min-w-[220px]">
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
                                        <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" title="Apply batch" data-loading-label="Applying">
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

                                <x-assignments.class-meeting-selector :program="$program" :selectedClassPeriod="$selectedClassPeriod ?? null" />
                            </div>
                        </div>
                    </div>

                    @php
                        $calendarClassPeriodId = $selectedClassPeriod->id ?? Auth::user()->class_period_id ?? $program?->classPeriods?->first()?->id ?? '';
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
                        <a href="{{ route('assignments.grammar-writing.classes', ($program->delivery_mode ?? 'online') === 'offline' ? ['mode' => 'offline'] : []) }}" class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>

                @php
                    if (!isset($allMeetingsUnlocked)) {
                        $allMeetingsUnlocked = true;
                        if (isset($program) && $program->meetings->isNotEmpty()) {
                            foreach ($trackData['meetings'] as $mRow) {
                                $dbM = $program->meetings->firstWhere('meeting_number', $mRow['source_meeting_number']);
                                if (!$dbM || $dbM->is_locked || empty($mRow['available'])) {
                                    $allMeetingsUnlocked = false;
                                    break;
                                }
                            }
                        } else {
                            $allMeetingsUnlocked = false;
                        }
                    }
                @endphp

                @if(($hasCompletedAllMeetings ?? false) && $allMeetingsUnlocked)
                    <div class="mb-6 p-6 rounded-3xl shadow-lg bg-blue-600 border border-blue-500 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg">Semua meeting {{ $trackData['title'] }} sudah selesai!</p>
                                <p class="text-blue-100 text-sm mt-0.5">Anda sudah bisa mengerjakan Final Test untuk track ini.</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 shrink-0">
                            @if($track === 'fast-track')
                                <a href="{{ route('assignments.grammar-writing.fast-track.book-pdf') }}" target="_blank"
                                   class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-700/80 hover:bg-blue-800 text-white rounded-2xl font-bold border border-white/25 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span>Buka PDF Buku Materi</span>
                                </a>
                            @endif
                            <a href="{{ route('final-test.show', ['program' => 'grammar-for-writing', 'variant' => $track]) }}"
                               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-blue-700 rounded-2xl font-bold shadow-md hover:bg-blue-50 transition">
                                <span>Lanjut ke Final Test</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($trackData['meetings'] as $meeting)
                        @php
                            $dbMeeting = isset($program) ? $program->meetings->firstWhere('meeting_number', $meeting['source_meeting_number']) : null;
                            $classMeeting = isset($selectedClassPeriod) ? $selectedClassPeriod->classMeetings->firstWhere('meeting_number', $meeting['source_meeting_number']) : null;
                            $canEditRecording = Auth::user()->isAdmin() || Auth::user()->isTeacher();
                            $isBonus = !empty($meeting['is_bonus']);
                            $isAdminOrTeacher = Auth::user()->isAdmin() || Auth::user()->isTeacher();
                        @endphp

                        {{-- Pertemuan Bonus disembunyikan total dari siswa jika berstatus terkunci --}}
                        @if($isBonus && !$isAdminOrTeacher && ($dbMeeting?->is_locked ?? true))
                            @continue
                        @endif

                        <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition overflow-hidden {{ $isBonus ? 'border-2 border-amber-400 bg-gradient-to-b from-amber-50/25 via-white to-white' : 'border border-gray-100' }} relative">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4 gap-4">
                                    <div>
                                        @if($isBonus)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                                ⭐ PERTEMUAN BONUS
                                            </span>
                                            <h2 class="text-xl font-extrabold text-gray-900 mt-1.5">{{ $meeting['title'] }}</h2>
                                        @else
                                            <p class="text-xs uppercase tracking-[0.2em] text-gray-400 font-semibold">Grammar for Writing</p>
                                            <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $meeting['title'] }}</h2>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        @if($dbMeeting)
                                            @if($isBonus && $isAdminOrTeacher)
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $dbMeeting->is_locked ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-green-100 text-green-700 border border-green-300' }}">
                                                    {{ $dbMeeting->is_locked ? 'HIDDEN DARI SISWA' : 'OPEN UNTUK SISWA' }}
                                                </span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $dbMeeting->is_locked ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                                    {{ $dbMeeting->is_locked ? 'LOCKED' : 'OPEN' }}
                                                </span>
                                            @endif
                                            
                                            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                                <form action="{{ route('assignments.meeting.toggle-lock', $dbMeeting->id) }}" method="POST">
                                                    @csrf
                                                    @if(isset($selectedClassPeriod))
                                                        <input type="hidden" name="class_period_id" value="{{ $selectedClassPeriod->id }}">
                                                    @endif
                                                    <button type="submit" class="text-gray-400 hover:text-gray-600 transition" title="{{ $isBonus ? ($dbMeeting->is_locked ? 'Klik untuk Mengaktifkan Pertemuan Bonus ke Siswa' : 'Klik untuk Mengunci / Menyembunyikan dari Siswa') : 'Toggle Lock' }}">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            @if($dbMeeting->is_locked)
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
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

                                @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                    <div class="mb-3">
                                        <x-grammar-writing-ai-toggle
                                            :track="$track"
                                            :meeting="$meeting['source_meeting_number']"
                                            :enabled="$aiEnabledByMeeting[$meeting['source_meeting_number']] ?? true"
                                        />
                                    </div>
                                @endif

                                <p class="text-base font-semibold text-gray-700 mb-2">{{ $meeting['topic'] }}</p>
                                <p class="text-sm text-gray-500 leading-relaxed min-h-[48px]">{{ $meeting['description'] }}</p>

                                @if($meeting['available'] && $meeting['route_name'])
                                    @if(isset($dbMeeting) && $dbMeeting->is_locked)
                                        @if($isBonus && $isAdminOrTeacher)
                                            <div class="mt-6 flex flex-col gap-2">
                                                <a href="{{ route($meeting['route_name'], $meeting['route_parameters'] ?? []) }}" class="inline-flex items-center justify-center w-full rounded-2xl bg-amber-500 hover:bg-amber-600 text-white px-4 py-3 text-sm font-bold shadow-xs transition">
                                                    <span>Preview Meeting (Admin / Teacher)</span>
                                                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                                </a>
                                                <p class="text-xs text-center text-amber-700 font-medium">Klik ikon gembok di atas untuk mengaktifkan ke akun siswa.</p>
                                            </div>
                                        @else
                                            <div class="mt-6 inline-flex items-center justify-center w-full rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-500">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                Locked
                                            </div>
                                        @endif
                                    @else
                                        <a href="{{ route($meeting['route_name'], $meeting['route_parameters'] ?? []) }}" class="mt-6 inline-flex items-center justify-center w-full rounded-2xl {{ $isBonus ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'bg-blue-100 hover:bg-blue-200 text-blue-700' }} px-4 py-3 text-sm font-semibold transition">
                                            {{ $isBonus ? '⭐ Buka Pertemuan Bonus' : 'Open Meeting' }}
                                        </a>
                                    @endif
                                @else
                                    <div class="mt-6 inline-flex items-center justify-center w-full rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-500">
                                        Coming Soon
                                    </div>
                                @endif
                                
                                @if($classMeeting || ($canEditRecording && $dbMeeting && isset($selectedClassPeriod)))
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex flex-col gap-2">
                                            @if($classMeeting)
                                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    @php
                                                        // Prefer the date this meeting's lock was last manually
                                                        // toggled (set on $meeting by BuildGrammarWritingIndexData
                                                        // from the class_period_meetings pivot's own updated_at)
                                                        // over meeting_date, which is just the auto-calculated
                                                        // start_date + N weeks schedule and can drift from
                                                        // reality once a meeting's been manually opened/locked
                                                        // out of band. Only meetings that were never manually
                                                        // toggled fall back to the auto-calculated date.
                                                        $displayDate = $dbMeeting?->lock_toggled_at ?? $classMeeting->meeting_date;
                                                    @endphp
                                                    <span>{{ $displayDate ? $displayDate->format('d M Y') : 'TBA' }}</span>
                                                    <span class="mx-1">•</span>
                                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <x-class-meeting-time
                                                        :meeting-id="$dbMeeting->id"
                                                        :class-period-id="$selectedClassPeriod->id"
                                                        :start-time="$classMeeting->start_time?->format('H:i')"
                                                        :end-time="$classMeeting->end_time?->format('H:i')"
                                                        :can-edit="$canEditRecording"
                                                    />
                                                </div>
                                                @if($classMeeting->meeting_link)
                                                    <a href="{{ $classMeeting->meeting_link }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 mt-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                        Join Virtual Class
                                                    </a>
                                                @endif
                                            @endif
                                            @if($dbMeeting && isset($selectedClassPeriod))
                                                <x-class-meeting-recording-link
                                                    :meeting-id="$dbMeeting->id"
                                                    :class-period-id="$selectedClassPeriod->id"
                                                    :recording-urls="$classMeeting->recording_urls ?? []"
                                                    :recording-passwords="$classMeeting->recording_passwords ?? []"
                                                    :can-edit="$canEditRecording"
                                                />
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Final Test Card -->
                    @if($allMeetingsUnlocked)
                        <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition overflow-hidden border-2 border-blue-600 relative flex flex-col justify-between">
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between mb-4 gap-4">
                                        <div>
                                            <p class="text-xs uppercase tracking-[0.2em] text-blue-600 font-bold">Tahap Akhir</p>
                                            <h2 class="text-xl font-bold text-gray-900 mt-1">Final Test</h2>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                            OPEN
                                        </span>
                                    </div>
                                    <p class="text-base font-semibold text-gray-800 mb-2">Final Assessment {{ $trackData['title'] }}</p>
                                    <p class="text-sm text-gray-500 leading-relaxed min-h-[48px]">
                                        Ujian evaluasi akhir komprehensif (3 paragraf esai) untuk menguji seluruh materi dan penerbitan sertifikat resmi.
                                    </p>
                                </div>

                                <div class="mt-6">
                                    <a href="{{ route('final-test.show', ['program' => 'grammar-for-writing', 'variant' => $track]) }}" 
                                       class="inline-flex items-center justify-center w-full rounded-2xl bg-blue-600 hover:bg-blue-700 text-white px-4 py-3.5 text-sm font-bold shadow-sm transition">
                                        <span>Buka Final Test</span>
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-3xl shadow-sm transition overflow-hidden border border-gray-200 relative flex flex-col justify-between">
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between mb-4 gap-4">
                                        <div>
                                            <p class="text-xs uppercase tracking-[0.2em] text-gray-400 font-semibold">Tahap Akhir</p>
                                            <h2 class="text-xl font-bold text-gray-700 mt-1">Final Test</h2>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600 flex items-center gap-1 border border-red-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            LOCKED
                                        </span>
                                    </div>
                                    <p class="text-base font-semibold text-gray-700 mb-2">Final Assessment {{ $trackData['title'] }}</p>
                                    <p class="text-sm text-gray-500 leading-relaxed min-h-[48px]">
                                        Ujian evaluasi akhir komprehensif (3 paragraf esai) untuk menguji seluruh materi dan penerbitan sertifikat resmi.
                                    </p>
                                </div>

                                <div class="mt-6">
                                    <div class="inline-flex items-center justify-center w-full rounded-2xl bg-slate-100 px-4 py-3.5 text-sm font-semibold text-slate-500 cursor-not-allowed">
                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Locked
                                    </div>
                                    <p class="text-xs text-center text-gray-400 mt-2">Terbuka otomatis setelah semua {{ count($trackData['meetings']) }} pertemuan terbuka</p>

                                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                        <div class="mt-3 text-center">
                                            <a href="{{ route('final-test.show', ['program' => 'grammar-for-writing', 'variant' => $track]) }}" class="text-xs font-semibold text-blue-600 hover:underline inline-flex items-center gap-1">
                                                <span>Preview Final Test (Admin / Teacher)</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Fast Track Book PDF Card -->
                    @if($track === 'fast-track')
                        @php
                            $isBookUnlocked = ($allMeetingsUnlocked ?? false) || ($hasCompletedAllMeetings ?? false);
                            $canPreviewBook = Auth::user()->isAdmin() || Auth::user()->isTeacher();
                        @endphp
                        @if($isBookUnlocked)
                            <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg transition overflow-hidden border-2 border-indigo-600 relative flex flex-col justify-between">
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-start justify-between mb-4 gap-4">
                                            <div>
                                                <p class="text-xs uppercase tracking-[0.2em] text-indigo-600 font-bold">E-Book Lengkap</p>
                                                <h2 class="text-xl font-bold text-gray-900 mt-1">Buku Penjelasan &amp; Contoh</h2>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">
                                                OPEN
                                            </span>
                                        </div>
                                        <p class="text-base font-semibold text-gray-800 mb-2">Panduan Kompilasi Meeting 1 &ndash; 10</p>
                                        <p class="text-sm text-gray-500 leading-relaxed min-h-[48px]">
                                            Buku rangkuman materi lengkap: rumus tata bahasa, tabel matriks aturan silang-silang, cheat sheet, serta ratusan contoh kalimat terjemahan &amp; kosakata dari seluruh pertemuan.
                                        </p>
                                    </div>

                                    <div class="mt-6">
                                        <a href="{{ route('assignments.grammar-writing.fast-track.book-pdf') }}" 
                                           target="_blank"
                                           class="inline-flex items-center justify-center w-full rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3.5 text-sm font-bold shadow-sm transition">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            <span>Buka PDF Buku Materi</span>
                                            <svg class="w-4 h-4 ml-1.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-3xl shadow-sm transition overflow-hidden border border-gray-200 relative flex flex-col justify-between">
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-start justify-between mb-4 gap-4">
                                            <div>
                                                <p class="text-xs uppercase tracking-[0.2em] text-gray-400 font-semibold">E-Book Lengkap</p>
                                                <h2 class="text-xl font-bold text-gray-700 mt-1">Buku Penjelasan &amp; Contoh</h2>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600 flex items-center gap-1 border border-red-200">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                                LOCKED
                                            </span>
                                        </div>
                                        <p class="text-base font-semibold text-gray-700 mb-2">Panduan Kompilasi Meeting 1 &ndash; 10</p>
                                        <p class="text-sm text-gray-500 leading-relaxed min-h-[48px]">
                                            Buku rangkuman materi lengkap: rumus tata bahasa, tabel matriks aturan silang-silang, cheat sheet, serta ratusan contoh kalimat terjemahan &amp; kosakata dari seluruh pertemuan.
                                        </p>
                                    </div>

                                    <div class="mt-6">
                                        <div class="inline-flex items-center justify-center w-full rounded-2xl bg-slate-100 px-4 py-3.5 text-sm font-semibold text-slate-500 cursor-not-allowed">
                                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            Locked
                                        </div>
                                        <p class="text-xs text-center text-gray-400 mt-2">Terbuka otomatis setelah seluruh 10 pertemuan terbuka</p>

                                        @if($canPreviewBook)
                                            <div class="mt-3 text-center">
                                                <a href="{{ route('assignments.grammar-writing.fast-track.book-pdf') }}" target="_blank" class="text-xs font-semibold text-indigo-600 hover:underline inline-flex items-center gap-1">
                                                    <span>Preview PDF Buku (Admin / Teacher)</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </main>
    </div>

    @include('components.meetings-calendar-modal')
    @include('components.student-broadcaster')
    @include('components.floating-wa-button')
    <x-meeting-progress-bar :program-slug="$program->slug" :total-meetings="count(array_filter($trackData['meetings'], fn($m) => empty($m['is_bonus'])))" />
</body>
</html>