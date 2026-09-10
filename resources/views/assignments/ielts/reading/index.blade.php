@extends('layouts.admin')

@section('title', 'IELTS Reading')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{
    showModal: false,
    editingMeeting: null,
    formData: {
        id: null,
        title: '',
        meeting_number: ''
    },
    edit(meeting) {
        this.editingMeeting = meeting;
        this.formData = {
            id: meeting.id,
            title: meeting.title,
            meeting_number: meeting.meeting_number
        };
        this.showModal = true;
    },
    create() {
        this.editingMeeting = null;
        this.formData = {
            id: null,
            title: '',
            meeting_number: {{ $meetings->count() + 1 }}
        };
        this.showModal = true;
    }
}">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-pink-600 to-red-600 bg-clip-text text-transparent">{{ !empty($isGeneral) ? 'IELTS General Reading' : 'IELTS Reading Skills' }}</h1>
                    <p class="text-gray-600 mt-1">{{ !empty($isGeneral) ? 'Practice your general reading comprehension skills! 📖' : 'Practice your reading comprehension skills for IELTS! 📖' }}</p>
                </div>
            </div>

            <a href="{{ !empty($isGeneral) ? route('assignments.ielts-general') : route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ !empty($isGeneral) ? 'Back to IELTS General' : 'Back to IELTS' }}
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-pink-50 text-pink-700 font-semibold border border-pink-100 text-xs">
                Active Batch: {{ $selectedClassPeriod->name ?? 'No Batch Active' }}
            </span>

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <form action="{{ route('assignments.batch-period') }}" method="POST" class="inline-flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $batchProgram?->id }}">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <select name="class_period_id" class="border-none bg-white rounded-lg text-sm focus:ring-2 focus:ring-pink-500 min-w-[220px]" {{ !$batchProgram ? 'disabled' : '' }}>
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
                    <button type="submit" class="p-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition disabled:opacity-50 disabled:cursor-not-allowed" title="Apply batch" {{ !$batchProgram ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            @else
                <div class="inline-flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <div class="bg-white px-4 py-2 rounded-lg text-sm font-medium text-gray-800 min-w-[220px]">
                        {{ $selectedClassPeriod->name ?? 'No Batch Active' }}
                    </div>
                </div>
            @endif

            @php
                $calendarClassPeriodId = $selectedClassPeriod->id ?? Auth::user()->class_period_id ?? optional(optional($batchProgram)->classPeriods)->first()?->id ?? '';
                $calendarBatchName = addslashes($batchProgram->name ?? 'Assignments');
            @endphp
            @if($calendarClassPeriodId)
                <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="px-4 py-2 bg-white border border-gray-200 rounded-xl hover:bg-white text-sm text-gray-600">
                    Lihat Kalender
                </button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Skill Building Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Skill Building</h2>
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <button @click="create()" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition shadow flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Practice Test
                </button>
            @endif
        </div>

        <div id="ielts-reading-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $meetingsMap = $meetings->keyBy('meeting_number');
                $materials = [
                    1  => ['title' => 'Matching Headings',           'color' => 'pink',    'slug' => 'matching-headings'],
                    2  => ['title' => 'Multiple Choice',              'color' => 'rose',    'slug' => 'multiple-choice'],
                    3  => ['title' => 'Short Answer',                 'color' => 'fuchsia', 'slug' => 'short-answer'],
                    4  => ['title' => 'Name Matching',                'color' => 'purple',  'slug' => 'name-matching'],
                    5  => ['title' => 'True / False / Not Given',     'color' => 'violet',  'slug' => 'true-false-not-given'],
                    6  => ['title' => 'Yes / No / Not Given',         'color' => 'indigo',  'slug' => 'yes-no-not-given'],
                    7  => ['title' => 'Summary Completion',           'color' => 'blue',    'slug' => 'summary-completion'],
                    8  => ['title' => 'Matching Sentence Endings',    'color' => 'cyan',    'slug' => 'matching-sentence-endings'],
                    9  => ['title' => 'Sentence Completion',          'color' => 'teal',    'slug' => 'sentence-completion'],
                    10 => ['title' => 'Matching Paragraph Info',      'color' => 'emerald', 'slug' => 'matching-paragraph-info'],
                    11 => ['title' => 'Table Completion',             'color' => 'green',   'slug' => 'table-completion'],
                    12 => ['title' => 'Diagram Labelling',            'color' => 'lime',    'slug' => 'diagram-labelling'],
                ];

                $colorMap = [
                    'pink'    => ['bg' => 'bg-pink-50',    'text' => 'text-pink-600',    'btn' => 'bg-pink-600 hover:bg-pink-700',    'badge' => 'bg-pink-100 text-pink-600'],
                    'rose'    => ['bg' => 'bg-rose-50',    'text' => 'text-rose-600',    'btn' => 'bg-rose-600 hover:bg-rose-700',    'badge' => 'bg-rose-100 text-rose-600'],
                    'fuchsia' => ['bg' => 'bg-fuchsia-50', 'text' => 'text-fuchsia-600', 'btn' => 'bg-fuchsia-600 hover:bg-fuchsia-700', 'badge' => 'bg-fuchsia-100 text-fuchsia-600'],
                    'purple'  => ['bg' => 'bg-white',  'text' => 'text-purple-600',  'btn' => 'bg-purple-600 hover:bg-purple-700',  'badge' => 'bg-white text-purple-600'],
                    'violet'  => ['bg' => 'bg-violet-50',  'text' => 'text-violet-600',  'btn' => 'bg-violet-600 hover:bg-violet-700',  'badge' => 'bg-violet-100 text-violet-600'],
                    'indigo'  => ['bg' => 'bg-white',  'text' => 'text-indigo-600',  'btn' => 'bg-indigo-600 hover:bg-indigo-700',  'badge' => 'bg-white text-indigo-600'],
                    'blue'    => ['bg' => 'bg-white',    'text' => 'text-blue-600',    'btn' => 'bg-blue-600 hover:bg-blue-700',    'badge' => 'bg-white text-blue-600'],
                    'cyan'    => ['bg' => 'bg-white',    'text' => 'text-cyan-600',    'btn' => 'bg-cyan-600 hover:bg-cyan-700',    'badge' => 'bg-white text-cyan-600'],
                    'teal'    => ['bg' => 'bg-white',    'text' => 'text-teal-600',    'btn' => 'bg-teal-600 hover:bg-teal-700',    'badge' => 'bg-white text-teal-600'],
                    'emerald' => ['bg' => 'bg-white', 'text' => 'text-emerald-600', 'btn' => 'bg-emerald-600 hover:bg-emerald-700', 'badge' => 'bg-white text-emerald-600'],
                    'green'   => ['bg' => 'bg-green-50',   'text' => 'text-green-600',   'btn' => 'bg-green-600 hover:bg-green-700',   'badge' => 'bg-green-100 text-green-600'],
                    'lime'    => ['bg' => 'bg-lime-50',    'text' => 'text-lime-600',    'btn' => 'bg-lime-600 hover:bg-lime-700',    'badge' => 'bg-lime-100 text-lime-600'],
                ];
            @endphp

            @foreach($materials as $id => $mat)
                @php 
                    $c = $colorMap[$mat['color']]; 
                    $dbMeeting = $meetingsMap->get($id);
                    $isLocked = $dbMeeting ? (bool) $dbMeeting->is_locked : false;
                    $canAccess = !$isLocked || Auth::user()->isAdmin() || Auth::user()->isTeacher();
                @endphp
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-4 py-1.5 {{ $isLocked ? 'bg-red-100 text-red-600' : $c['badge'] }} rounded-full text-sm font-bold uppercase tracking-wide">
                            {{ $isLocked ? 'LOCKED' : 'OPEN' }}
                        </span>
                        @if((Auth::user()->isAdmin() || Auth::user()->isTeacher()) && $dbMeeting)
                            <form action="{{ route('assignments.ielts.reading.meeting.toggle-lock', $dbMeeting->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-gray-600 transition" title="Toggle Lock">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($isLocked)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                        @endif
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="flex-1 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 {{ $isLocked ? 'bg-white text-gray-400' : $c['bg'] . ' ' . $c['text'] }} rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-xl">{{ $id }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 leading-tight">{{ $mat['title'] }}</h3>
                        </div>
                    </div>

                    @if($canAccess)
                        <a href="{{ route('assignments.ielts-academic.reading.skill', $mat['slug']) }}"
                           class="block w-full py-3 {{ $c['btn'] }} text-white text-center rounded-xl font-bold transition shadow-sm hover:shadow active:scale-95">
                            @if(!empty($isClassEnded) && Auth::user()->isStudent())
                                Kerjakan Ulang ↺
                            @else
                                Start Practice
                            @endif
                        </a>
                    @else
                        <button disabled class="block w-full py-3 bg-white text-gray-400 text-center rounded-xl font-bold cursor-not-allowed">
                            Locked
                        </button>
                    @endif
                    
                    @php
                        $classMeeting = $dbMeeting && !empty($selectedClassPeriod) ? $selectedClassPeriod->classMeetings->firstWhere('meeting_id', $dbMeeting->id) : null;
                    @endphp
                    @if($classMeeting)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>{{ $classMeeting->meeting_date ? $classMeeting->meeting_date->format('d M Y') : 'TBA' }}</span>
                                    <span class="mx-1">•</span>
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ $classMeeting->start_time ? $classMeeting->start_time->format('H:i') . ' - ' . $classMeeting->end_time->format('H:i') . ' WIB' : 'TBA' }}</span>
                                </div>
                                @if($classMeeting->meeting_link)
                                    <a href="{{ $classMeeting->meeting_link }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 mt-1">
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
    </div>

    <!-- Add/Edit Meeting Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8" @click.outside="showModal = false">
            <h3 class="text-xl font-bold text-gray-800 mb-6" x-text="editingMeeting ? 'Edit Practice Test' : 'Add Practice Test'"></h3>
            <form :action="editingMeeting
                    ? '{{ route('assignments.ielts.reading.meeting.store') }}'
                    : '{{ route('assignments.ielts.reading.meeting.store') }}'"
                  method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" x-model="formData.title"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                               placeholder="e.g. Practice Test 1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Number</label>
                        <input type="number" name="meeting_number" x-model="formData.meeting_number"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                               required>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 py-2 bg-pink-600 text-white rounded-lg font-bold hover:bg-pink-700 transition">
                        Save
                    </button>
                    <button type="button" @click="showModal = false" class="flex-1 py-2 bg-white text-gray-700 rounded-lg font-bold hover:bg-gray-200 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('components.meetings-calendar-modal')
</div>
@endsection
