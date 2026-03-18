@extends('layouts.admin')

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
                <div class="p-3 bg-purple-600 rounded-2xl shadow-lg">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-purple-600">IELTS Listening Skills</h1>
                    <p class="text-gray-600 mt-1">Practice your listening skills for IELTS! 🎧</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to IELTS
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 font-semibold border border-purple-100 text-xs">
                Active Batch: {{ $selectedClassPeriod->name ?? ($batchProgram->period ?? 'Not selected') }}
            </span>

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <form action="{{ route('assignments.batch-period') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $batchProgram?->id }}">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <select name="period" class="border-none bg-gray-50 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 min-w-[220px]" {{ !$batchProgram ? 'disabled' : '' }}>
                        @if(!$batchProgram)
                            <option value="" selected>No program found</option>
                        @elseif($batchProgram->classPeriods->isEmpty())
                            <option value="{{ $batchProgram->period }}" selected>{{ $batchProgram->period ?: 'No batch available' }}</option>
                        @else
                            @foreach($batchProgram->classPeriods->sortByDesc('start_date') as $classPeriod)
                                <option value="{{ $classPeriod->name }}" {{ $batchProgram->period === $classPeriod->name ? 'selected' : '' }}>
                                    {{ $classPeriod->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <button type="submit" class="p-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition disabled:opacity-50 disabled:cursor-not-allowed" title="Apply batch" {{ !$batchProgram ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            @else
                <div class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <span class="text-sm text-gray-800 px-2 py-1 bg-gray-50 rounded-lg">
                        {{ $selectedClassPeriod->name ?? ($batchProgram->period ?? 'Not selected') }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Warm-Up Practice</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-4">
            @php
                $warmUpPractices = [
                    'Spelling' => 'text-amber-600 bg-amber-50',
                    'Times and Dates' => 'text-amber-600 bg-amber-50',
                    'Addresses' => 'text-amber-600 bg-amber-50',
                    'Numbers' => 'text-amber-600 bg-amber-50',
                    'Names' => 'text-amber-600 bg-amber-50',
                    'Geographical Names' => 'text-amber-600 bg-amber-50',
                    'Direction' => 'text-amber-600 bg-amber-50',
                ];
            @endphp

            @foreach($warmUpPractices as $title => $colorClass)
                @php
                    $link = '#';
                    if ($title === 'Spelling') {
                        $link = route('assignments.ielts-academic.listening.warmup', 'spelling');
                    } elseif ($title === 'Times and Dates') {
                        $link = route('assignments.ielts-academic.listening.warmup', 'times-dates');
                    } elseif ($title === 'Addresses') {
                        $link = route('assignments.ielts-academic.listening.warmup', 'addresses');
                    } elseif ($title === 'Numbers') {
                        $link = route('assignments.ielts-academic.listening.warmup', 'numbers');
                    } elseif ($title === 'Names') {
                        $link = route('assignments.ielts-academic.listening.warmup', 'names');
                    } elseif ($title === 'Geographical Names') {
                        $link = route('assignments.ielts-academic.listening.warmup', 'geographical-names');
                    } elseif ($title === 'Direction') {
                        $link = route('assignments.ielts-academic.listening.warmup', 'direction');
                    }
                @endphp
                <a href="{{ $link }}" class="bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition group border border-amber-100 hover:border-amber-300 flex flex-col items-center justify-center text-center h-32">
                    <div class="w-10 h-10 {{ $colorClass }} rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm leading-tight">{{ $title }}</h3>
                </a>
            @endforeach
        </div>
    </div>

    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Skill Building</h2>
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                {{-- 
                <button @click="create()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition shadow flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Practice Test
                </button>
                --}}
            @endif
        </div>

        <div id="ielts-meetings-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $materials = [
                    1 => 'Multiple Choice',
                    2 => 'Matching',
                    3 => 'Note Completion',
                    4 => 'Form Completion',
                    5 => 'Table Completion',
                    6 => 'Sentence Completion',
                    7 => 'Summary Completion',
                    8 => 'Short Answer',
                    9 => 'Map & Plan Labelling',
                    10 => 'Diagrams & Flowcharts',
                    11 => 'Mixed Exercise',
                ];
            @endphp

            @foreach($materials as $number => $title)
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-4 py-1.5 bg-green-100 text-green-600 rounded-full text-sm font-bold uppercase tracking-wide">
                            OPEN
                        </span>
                    </div>
                    
                    <div class="flex-1 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-xl">{{ $number }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 leading-tight">{{ $title }}</h3>
                        </div>
                    </div>
                    
                    <a href="{{ route('assignments.ielts-academic.listening.material', $number) }}" class="block w-full py-3 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition shadow-sm hover:shadow active:scale-95">
                        Start Practice
                    </a>
                </div>
            @endforeach
        </div>
    </div>


</div>
@endsection
