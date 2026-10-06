@extends('layouts.admin')

@section('title', 'Class Schedule')

{{-- layouts.admin never outputs a csrf-token meta tag, so saveMeeting()'s
     fetch()-based save (below) has been reading
     document.querySelector('meta[name="csrf-token"]').getAttribute(...) off
     a tag that never existed - every "Save Changes" click threw "Cannot
     read properties of null" and silently never reached the server. --}}
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<!-- FullCalendar CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">

<div class="w-full" x-data="classSchedule()" x-cloak>

    <!-- Page Header -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-blue-600 to-blue-700 px-6 py-8 sm:px-10 sm:py-10 mb-8 rounded-2xl shadow-lg">
        <!-- Decorative blobs -->
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-32 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <!-- Title -->
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-white/70 text-sm font-medium uppercase tracking-widest">Admin Panel</span>
                </div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Class Schedule</h1>
                <p class="text-blue-100 mt-1 text-sm">View and manage all class meeting schedules across programs.</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
                <div class="bg-white/15 backdrop-blur rounded-xl px-5 py-3 text-center border border-white/20">
                    <p class="text-2xl font-bold text-white">{{ $stats['staff']['teachers'] ?? 0 }}</p>
                    <p class="text-blue-100 text-xs font-medium mt-0.5">Teachers</p>
                </div>
                <div class="bg-white/15 backdrop-blur rounded-xl px-5 py-3 text-center border border-white/20">
                    <p class="text-2xl font-bold text-white">{{ $stats['staff']['students'] ?? 0 }}</p>
                    <p class="text-blue-100 text-xs font-medium mt-0.5">Students</p>
                </div>
                <div class="bg-white/15 backdrop-blur rounded-xl px-5 py-3 text-center border border-white/20">
                    <p class="text-2xl font-bold text-white" x-text="totalToday">—</p>
                    <p class="text-blue-100 text-xs font-medium mt-0.5">Today's Classes</p>
                </div>
                <div class="bg-white/15 backdrop-blur rounded-xl px-5 py-3 text-center border border-white/20">
                    <p class="text-2xl font-bold text-white" x-text="totalThisWeek">—</p>
                    <p class="text-blue-100 text-xs font-medium mt-0.5">This Week</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Legend + Filter Bar -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-3 mb-4 flex flex-wrap items-center gap-4">
        <!-- Legend dots -->
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                <span class="text-xs text-gray-500 font-semibold">Online</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-violet-500"></div>
                <span class="text-xs text-gray-500 font-semibold">Offline</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                <span class="text-xs text-gray-500 font-semibold">Completed</span>
            </div>
        </div>

        <!-- Divider -->
        <div class="h-4 w-px bg-gray-200"></div>

        <!-- Counters -->
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-full px-3 py-0.5 text-xs font-semibold">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                {{ $stats['classes']['programs'] ?? 0 }} programs
            </span>
            <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-600 border border-slate-200 rounded-full px-3 py-0.5 text-xs font-semibold">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $stats['classes']['class_periods'] ?? 0 }} active periods
            </span>
        </div>

        <!-- Heatmap Toggle -->
        <div class="flex items-center gap-2 ml-4 border-l border-gray-200 pl-4">
            <label class="relative inline-flex items-center cursor-pointer" title="Color code days based on class density">
              <input type="checkbox" x-model="heatmapEnabled" @change="renderHeatmap" class="sr-only peer">
              <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
              <span class="ml-2 text-xs font-semibold text-gray-600">Heatmap Mode</span>
            </label>
        </div>

        <!-- Hint right-aligned -->
        <div class="ml-auto flex items-center gap-1.5 text-xs text-gray-400">
            <svg class="w-3.5 h-3.5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/></svg>
            Click any event to view details &amp; edit
        </div>
    </div>

    <!-- Jam Kelas: Pending Change Requests -->
    @if($pendingClassMeetingChangeRequests->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-amber-200 overflow-hidden mb-4">
            <div class="px-5 py-4 sm:px-8 sm:py-5 border-b border-amber-100 bg-amber-50 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-sm font-bold text-amber-900">Menunggu Konfirmasi: Perubahan Jam Kelas ({{ $pendingClassMeetingChangeRequests->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($pendingClassMeetingChangeRequests as $changeRequest)
                    <div class="px-5 py-4 sm:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">
                                {{ $changeRequest->requester->name ?? 'Unknown' }}
                                <span class="font-normal text-gray-500">memilih</span>
                                Meeting {{ $changeRequest->classMeeting->meeting_number ?? '?' }}
                                <span class="font-normal text-gray-500">({{ $changeRequest->program->name ?? 'Program' }})</span>
                                <span class="font-normal text-gray-500">sebagai jam kelas hari ini</span>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Jadwal sistem: {{ optional($changeRequest->classMeeting->meeting_date)->translatedFormat('l, d M Y') ?? '—' }}
                                &nbsp;→&nbsp;
                                Diajukan: {{ $changeRequest->requested_date->translatedFormat('l, d M Y') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <form method="POST" action="{{ route('admin.class-schedules.change-requests.reject', $changeRequest) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Tolak</button>
                            </form>
                            <form method="POST" action="{{ route('admin.class-schedules.change-requests.approve', $changeRequest) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-lg transition">Konfirmasi</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Calendar Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div id="calendar" class="px-5 py-5 sm:px-8 sm:py-6"></div>
    </div>

    <!-- ===================== EDIT MODAL ===================== -->
    <div x-show="isOpen"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display:none;"
         role="dialog" aria-modal="true">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="isOpen = false"></div>

        <!-- Modal Panel -->
        <div class="relative flex min-h-screen items-center justify-center p-4">
            <div x-show="isOpen"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden">

                <!-- Modal Header with gradient -->
                <div class="relative bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-5 overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                    <div class="relative flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-white/20 text-white text-xs font-semibold"
                                      x-text="editData.batch_number ? 'Batch ' + editData.batch_number : 'No Batch'"></span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-white/20 text-white text-xs font-semibold"
                                      x-text="'Meeting #' + editData.meeting_number"></span>
                            </div>
                            <h3 class="text-lg font-bold text-white leading-tight" x-text="editData.class_name"></h3>
                            <p class="text-blue-100 text-sm mt-0.5" x-text="editData.program_name"></p>
                        </div>
                        <button @click="isOpen = false"
                                class="flex-shrink-0 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Info Pills -->
                <div class="px-6 py-4 grid grid-cols-3 gap-3 border-b border-gray-100 bg-gray-50/50">
                    <div class="text-center">
                        <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center mx-auto mb-1.5">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-400 font-medium">Teacher</p>
                        <p class="text-xs font-semibold text-gray-800 mt-0.5 truncate" x-text="editData.teacher_name"></p>
                    </div>
                    <div class="text-center">
                        <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-400 font-medium">Students</p>
                        <p class="text-xs font-semibold text-gray-800 mt-0.5" x-text="editData.students_count + ' enrolled'"></p>
                    </div>
                    <div class="text-center">
                        <div class="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-1.5">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-400 font-medium">Mode</p>
                        <p class="text-xs font-semibold text-gray-800 mt-0.5" x-text="editData.learning_mode"></p>
                    </div>
                </div>

                <!-- Edit Form -->
                <form @submit.prevent="saveMeeting">
                    <div class="px-6 py-5 space-y-4">

                        <!-- Section Label -->
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Edit Schedule Details</p>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <svg class="inline w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Meeting Date
                            </label>
                            <input type="date" x-model="formData.meeting_date"
                                   class="w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50 hover:bg-white transition">
                        </div>

                        <!-- Time Row -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <svg class="inline w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Start Time
                                </label>
                                <input type="time" x-model="formData.start_time"
                                       class="w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50 hover:bg-white transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <svg class="inline w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    End Time
                                </label>
                                <input type="time" x-model="formData.end_time"
                                       class="w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50 hover:bg-white transition">
                            </div>
                        </div>

                        <!-- Topic -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <svg class="inline w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                Topic / Subject
                            </label>
                            <input type="text" x-model="formData.topic"
                                   class="w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50 hover:bg-white transition"
                                   placeholder="e.g. Listening Section Part A">
                        </div>

                        <!-- Meeting Link -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <svg class="inline w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                Meeting Link
                            </label>
                            <div class="relative">
                                <input type="url" x-model="formData.meeting_link"
                                       class="w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50 hover:bg-white transition pr-10"
                                       placeholder="https://zoom.us/...">
                                <a x-show="formData.meeting_link" :href="formData.meeting_link" target="_blank"
                                   class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-500 transition"
                                   title="Open link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Recording URLs -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <svg class="inline w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                Link Rekaman (Video Review)
                            </label>
                            <div class="space-y-1.5" x-show="formData.recording_urls.length > 0">
                                <template x-for="(url, index) in formData.recording_urls" :key="index">
                                    <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2 border border-gray-200">
                                        <a :href="url" target="_blank" class="flex-1 min-w-0 truncate text-xs text-indigo-600 hover:text-indigo-700" x-text="url"></a>
                                        <button type="button" @click="formData.recording_urls.splice(index, 1)" class="text-gray-400 hover:text-red-500 shrink-0" title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <div class="relative mt-1.5">
                                <input type="url" x-model="newRecordingUrl"
                                       @keydown.enter.prevent="if (newRecordingUrl.trim()) { formData.recording_urls.push(newRecordingUrl.trim()); newRecordingUrl = ''; }"
                                       class="w-full border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50 hover:bg-white transition pr-10"
                                       placeholder="Zoom, Google Drive, YouTube, dll... lalu tekan Enter">
                                <button type="button"
                                        @click="if (newRecordingUrl.trim()) { formData.recording_urls.push(newRecordingUrl.trim()); newRecordingUrl = ''; }"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-500 transition"
                                        title="Tambah link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Bisa lebih dari satu link (mis. Zoom + Google Drive + YouTube). Muncul sebagai tombol "Tonton Rekaman" di kartu meeting untuk student.</p>
                        </div>

                        <!-- Recording Passwords -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                <svg class="inline w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Password Rekaman
                            </label>
                            <div class="space-y-1.5" x-show="formData.recording_passwords.length > 0">
                                <template x-for="(entry, index) in formData.recording_passwords" :key="index">
                                    <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2 border border-gray-200">
                                        <span class="text-xs font-semibold text-gray-500 shrink-0" x-text="entry.label"></span>
                                        <span class="flex-1 min-w-0 truncate text-xs font-mono text-gray-700" x-text="entry.password"></span>
                                        <button type="button" @click="formData.recording_passwords.splice(index, 1)" class="text-gray-400 hover:text-red-500 shrink-0" title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <datalist id="recording-password-label-suggestions">
                                <option value="Zoom"></option>
                                <option value="Google Drive"></option>
                                <option value="YouTube"></option>
                                <option value="Lainnya"></option>
                            </datalist>
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <input type="text" x-model="newRecordingPasswordLabel" list="recording-password-label-suggestions"
                                       class="w-32 shrink-0 border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50 hover:bg-white transition"
                                       placeholder="Zoom, GDrive, dll..."
                                       @keydown.enter.prevent="$refs.newRecordingPasswordValueInput.focus()">
                                <input type="text" x-model="newRecordingPasswordValue" x-ref="newRecordingPasswordValueInput"
                                       class="flex-1 min-w-0 border-gray-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50 hover:bg-white transition"
                                       placeholder="Password..."
                                       @keydown.enter.prevent="if (newRecordingPasswordValue.trim()) { formData.recording_passwords.push({label: newRecordingPasswordLabel.trim() || 'Password', password: newRecordingPasswordValue.trim()}); newRecordingPasswordLabel = ''; newRecordingPasswordValue = ''; }">
                                <button type="button"
                                        @click="if (newRecordingPasswordValue.trim()) { formData.recording_passwords.push({label: newRecordingPasswordLabel.trim() || 'Password', password: newRecordingPasswordValue.trim()}); newRecordingPasswordLabel = ''; newRecordingPasswordValue = ''; }"
                                        class="text-gray-400 hover:text-indigo-500 transition shrink-0"
                                        title="Tambah password">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Bisa lebih dari satu password dengan keterangan (mis. Zoom + Google Drive). Ditampilkan ke student di samping tombol "Tonton Rekaman", bisa langsung di-copy.</p>
                        </div>

                        <!-- Error Banner -->
                        <div x-show="errorMessage" x-transition
                             class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-600 p-3 rounded-xl text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span x-text="errorMessage"></span>
                        </div>

                        <!-- Success Banner -->
                        <div x-show="successMessage" x-transition
                             class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-600 p-3 rounded-xl text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-text="successMessage"></span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between rounded-b-2xl">
                        <button type="button" @click="isOpen = false"
                                class="px-4 py-2 border border-gray-200 rounded-xl text-gray-600 bg-white hover:bg-gray-50 text-sm font-medium transition">
                            Cancel
                        </button>
                        <button type="submit" :disabled="loading"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm shadow-indigo-200 transition disabled:opacity-60 disabled:cursor-not-allowed">
                            <svg x-show="loading" class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span x-text="loading ? 'Saving...' : 'Save Changes'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- FullCalendar Library -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('classSchedule', () => ({
            isOpen: false,
            loading: false,
            errorMessage: '',
            successMessage: '',
            calendar: null,
            heatmapEnabled: false,
            eventsData: [],
            totalToday: '—',
            totalThisWeek: '—',
            editData: {
                meeting_id: null,
                class_name: '',
                batch_number: '',
                meeting_number: '',
                teacher_name: '',
                students_count: 0,
                program_name: '',
                learning_mode: '',
            },
            formData: {
                meeting_date: '',
                start_time: '',
                end_time: '',
                topic: '',
                meeting_link: '',
                recording_urls: [],
                recording_passwords: []
            },
            newRecordingUrl: '',
            newRecordingPasswordLabel: '',
            newRecordingPasswordValue: '',

            init() {
                const calendarEl = document.getElementById('calendar');
                this.calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    buttonText: {
                        today: 'Today',
                        month: 'Month',
                        week: 'Week',
                        day: 'Day',
                        list: 'List'
                    },
                    events: '{{ route("admin.class-schedules.events") }}',
                    eventClick: (info) => {
                        info.jsEvent.preventDefault();
                        this.openEditModal(info.event);
                    },
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                    dayMaxEvents: 4,
                    height: 'auto',
                    nowIndicator: true,
                    navLinks: true,
                    businessHours: {
                        daysOfWeek: [1, 2, 3, 4, 5, 6],
                        startTime: '06:00',
                        endTime: '22:00',
                    },
                    eventDidMount: (info) => {
                        // Add tooltip title
                        const props = info.event.extendedProps;
                        const batch = props.batch_number ? `Batch ${props.batch_number} • ` : '';
                        info.el.title = `${batch}${props.class_name} — Meeting #${props.meeting_number}\n👨‍🏫 ${props.teacher_name}\n👥 ${props.students_count} students\n📍 ${props.learning_mode}`;
                    },
                    eventsSet: (events) => {
                        this.eventsData = events;
                        this.computeStats(events);
                        
                        // We use setTimeout to ensure FullCalendar has rendered the DOM cells before applying colors
                        setTimeout(() => {
                            this.renderHeatmap();
                        }, 50);
                    },
                    datesSet: (info) => {
                        // Re-apply heatmap when user changes month/week/view
                        setTimeout(() => {
                            this.renderHeatmap();
                        }, 50);
                    },
                    themeSystem: 'standard'
                });

                this.calendar.render();
            },

            computeStats(events) {
                const today = new Date();
                const todayStr = today.toISOString().split('T')[0];

                const startOfWeek = new Date(today);
                startOfWeek.setDate(today.getDate() - today.getDay());
                const endOfWeek = new Date(startOfWeek);
                endOfWeek.setDate(startOfWeek.getDate() + 6);

                let todayCount = 0, weekCount = 0;

                events.forEach(e => {
                    const d = e.start;
                    if (!d) return;
                    const dStr = d.toISOString().split('T')[0];
                    if (dStr === todayStr) todayCount++;
                    if (d >= startOfWeek && d <= endOfWeek) weekCount++;
                });

                this.totalToday = todayCount;
                this.totalThisWeek = weekCount;
            },

            renderHeatmap() {
                // First, remove existing heatmap colors
                document.querySelectorAll('.fc-daygrid-day-frame').forEach(cell => {
                    cell.style.backgroundColor = '';
                });

                if (!this.heatmapEnabled || !this.eventsData.length) return;

                const counts = {};
                this.eventsData.forEach(e => {
                    if (!e.start) return;
                    // Format as YYYY-MM-DD local time using FullCalendar's date env or simple logic
                    // Because e.start is a Date object (UTC depending on FC timezone), 
                    // To avoid timezone offset issues, use the local Date string:
                    const d = new Date(e.start.getTime() - (e.start.getTimezoneOffset() * 60000));
                    const dStr = d.toISOString().split('T')[0];
                    counts[dStr] = (counts[dStr] || 0) + 1;
                });
                
                Object.keys(counts).forEach(dateStr => {
                    const count = counts[dateStr];
                    // Target the frame inside the cell for the background
                    const cell = document.querySelector(`.fc-daygrid-day[data-date="${dateStr}"] .fc-daygrid-day-frame`);
                    if (cell) {
                        // Color scale from green (light) to red (heavy) depending on class count - Calm Pastel Palette
                        if (count === 1) cell.style.backgroundColor = '#f0fdf4'; // green-50
                        else if (count === 2) cell.style.backgroundColor = '#fefce8'; // yellow-50
                        else if (count === 3) cell.style.backgroundColor = '#fef9c3'; // yellow-100
                        else if (count === 4) cell.style.backgroundColor = '#ffedd5'; // orange-100
                        else if (count >= 5) cell.style.backgroundColor = '#fee2e2'; // red-100
                    }
                });
            },

            openEditModal(eventObj) {
                const props = eventObj.extendedProps;

                this.editData = {
                    meeting_id: props.meeting_id,
                    class_name: props.class_name,
                    batch_number: props.batch_number,
                    meeting_number: props.meeting_number,
                    teacher_name: props.teacher_name,
                    students_count: props.students_count,
                    program_name: props.program_name || '',
                    learning_mode: props.learning_mode || 'Online',
                };

                const start = eventObj.start;
                const end = eventObj.end;

                this.formData = {
                    meeting_date: start ? start.toISOString().split('T')[0] : '',
                    start_time: start ? this.pad(start.getHours()) + ':' + this.pad(start.getMinutes()) : '',
                    end_time: end ? this.pad(end.getHours()) + ':' + this.pad(end.getMinutes()) : '',
                    topic: props.topic || '',
                    meeting_link: props.meeting_link || '',
                    recording_urls: Array.isArray(props.recording_urls) ? props.recording_urls.slice() : [],
                    recording_passwords: Array.isArray(props.recording_passwords) ? props.recording_passwords.slice() : []
                };
                this.newRecordingUrl = '';
                this.newRecordingPasswordLabel = '';
                this.newRecordingPasswordValue = '';

                this.errorMessage = '';
                this.successMessage = '';
                this.isOpen = true;
            },

            pad(num) {
                return num.toString().padStart(2, '0');
            },

            async saveMeeting() {
                this.loading = true;
                this.errorMessage = '';
                this.successMessage = '';

                try {
                    const response = await fetch('/admin/class-schedules/' + this.editData.meeting_id, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.formData)
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Something went wrong.');
                    }

                    this.successMessage = 'Schedule updated successfully!';
                    this.calendar.refetchEvents();

                    setTimeout(() => {
                        this.isOpen = false;
                        this.successMessage = '';
                    }, 1500);

                } catch (error) {
                    this.errorMessage = error.message;
                } finally {
                    this.loading = false;
                }
            }
        }));
    });
</script>

<style>
    /* =========================================
       FULLCALENDAR PREMIUM THEME
    ========================================= */

    /* Toolbar */
    .fc .fc-toolbar-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #1e1b4b;
        letter-spacing: -0.03em;
    }

    .fc .fc-toolbar {
        gap: 0.5rem;
        flex-wrap: wrap;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 1.25rem !important;
        align-items: center;
    }

    /* Make the right group wrap gracefully */
    .fc .fc-toolbar-chunk {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    /* Buttons */
    .fc .fc-button {
        font-size: 0.8125rem;
        font-weight: 600;
        padding: 0.4rem 0.875rem;
        border-radius: 0.625rem;
        text-transform: capitalize;
        transition: all 0.15s ease;
        letter-spacing: 0;
        border: 1px solid #e2e8f0;
        outline: none !important;
        box-shadow: none !important;
    }

    .fc .fc-button-primary {
        background-color: #f8fafc;
        color: #475569;
        border-color: #e2e8f0;
    }

    .fc .fc-button-primary:hover {
        background-color: #f1f5f9;
        color: #1e293b;
        border-color: #cbd5e1;
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active,
    .fc .fc-button-primary:not(:disabled):active {
        background-color: #6366f1;
        color: #ffffff;
        border-color: #6366f1;
        box-shadow: 0 1px 4px rgba(99, 102, 241, 0.35) !important;
    }

    .fc .fc-today-button {
        background: linear-gradient(135deg, #6366f1, #3b82f6) !important;
        color: white !important;
        border-color: transparent !important;
    }

    .fc .fc-today-button:disabled {
        opacity: 0.5;
    }

    .fc .fc-prev-button, .fc .fc-next-button {
        width: 2.25rem;
        height: 2.25rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Grid */
    .fc-theme-standard th {
        border-color: #f1f5f9;
        padding: 0.625rem 0;
        font-size: 0.6875rem;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        font-weight: 700;
        background: #fafafa;
    }

    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #f1f5f9;
    }

    /* Ensure calendar table fills container */
    .fc-view-harness {
        min-height: 580px;
    }

    .fc table {
        width: 100% !important;
    }

    .fc-daygrid-day {
        transition: background 0.1s ease;
    }

    .fc-daygrid-day:hover {
        background: #fafafa;
    }

    .fc-daygrid-day-number {
        color: #475569;
        font-weight: 600;
        font-size: 0.8125rem;
        padding: 0.5rem 0.625rem !important;
    }

    .fc-day-other .fc-daygrid-day-number {
        color: #cbd5e1;
    }

    .fc-day-today {
        background-color: #eef2ff !important;
    }

    .fc-day-today .fc-daygrid-day-number {
        background: linear-gradient(135deg, #6366f1, #3b82f6);
        color: white;
        border-radius: 0.5rem;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    /* Events */
    .fc-event {
        border-radius: 0.4375rem;
        border: none;
        padding: 0.1875rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.1s ease, box-shadow 0.1s ease;
        line-height: 1.4;
    }

    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .fc-daygrid-event-dot { display: none; }

    .fc-v-event {
        border-radius: 0.5rem;
        border: none;
        padding: 0.25rem 0.5rem;
    }

    /* List view */
    .fc-list-day-cushion {
        background: linear-gradient(135deg, #6366f1, #3b82f6) !important;
    }

    .fc-list-day-text, .fc-list-day-side-text {
        color: white !important;
        font-weight: 700 !important;
    }

    .fc-list-event:hover td {
        background-color: #f8fafc;
    }

    .fc-list-event-dot {
        border-width: 6px;
    }

    /* Now indicator */
    .fc-timegrid-now-indicator-line {
        border-color: #ef4444 !important;
        border-width: 2px;
    }

    .fc-timegrid-now-indicator-arrow {
        border-top-color: #ef4444 !important;
    }

    /* More link */
    .fc-daygrid-more-link {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6366f1;
        padding: 0.125rem 0.25rem;
    }

    .fc-daygrid-more-link:hover {
        color: #4338ca;
        background: #eef2ff;
        border-radius: 0.375rem;
    }
</style>

@endsection
