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
            meeting_number: ''
        };
        this.showModal = true;
    }
}">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">IELTS Academic Writing</h1>
                    <p class="text-gray-600 mt-1">Practice your writing skills for IELTS! ✍️</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to IELTS
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-50 text-red-700 font-semibold border border-red-100 text-xs">
                Active Batch: {{ $selectedClassPeriod->name ?? 'No Batch Active' }}
            </span>

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <form action="{{ route('assignments.batch-period') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $batchProgram?->id }}">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <select name="class_period_id" class="border-none bg-gray-50 rounded-lg text-sm focus:ring-2 focus:ring-red-500 min-w-[220px]" {{ !$batchProgram ? 'disabled' : '' }}>
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
                    <button type="submit" class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed" title="Apply batch" {{ !$batchProgram ? 'disabled' : '' }}>
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

            @php
                $calendarClassPeriodId = $selectedClassPeriod->id ?? Auth::user()->class_period_id ?? optional($batchProgram->classPeriods->first())->id ?? '';
                $calendarBatchName = addslashes($batchProgram->name ?? 'Assignments');
            @endphp
            @if($calendarClassPeriodId)
                <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="px-4 py-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-sm text-gray-600">
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

    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Practice Tests</h2>
        </div>

        <div id="ielts-writing-tasks" class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Task 1 Card -->
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => 1]) }}" class="group relative overflow-hidden bg-white rounded-3xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-32 h-32 bg-teal-50 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                
                <div class="relative z-10 flex flex-col h-full items-center text-center">
                    <div class="w-20 h-20 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-3xl font-bold text-gray-800 mb-3 group-hover:text-teal-600 transition-colors">Task 1</h3>
                    <p class="text-gray-500 font-medium mb-2">Academic Report</p>
                    <p class="text-sm text-gray-400">Describe visual information (graphs, charts, tables) in roughly 150 words.</p>
                    
                    <div class="mt-8 flex items-center text-teal-600 font-bold group-hover:translate-x-2 transition-transform">
                        @if(!empty($isClassEnded) && Auth::user()->isStudent())
                            <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Kerjakan Ulang ↺</span>
                        @else
                            <span>Start Practice</span>
                        @endif
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </div>
            </a>

            <!-- Task 2 Card -->
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => 2]) }}" class="group relative overflow-hidden bg-white rounded-3xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                
                <div class="relative z-10 flex flex-col h-full items-center text-center">
                    <div class="w-20 h-20 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-3xl font-bold text-gray-800 mb-3 group-hover:text-orange-600 transition-colors">Task 2</h3>
                    <p class="text-gray-500 font-medium mb-2">Essay Writing</p>
                    <p class="text-sm text-gray-400">Write a formal essay in response to a point of view, argument or problem.</p>
                    
                    <div class="mt-8 flex items-center text-orange-600 font-bold group-hover:translate-x-2 transition-transform">
                        @if(!empty($isClassEnded) && Auth::user()->isStudent())
                            <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Kerjakan Ulang ↺</span>
                        @else
                            <span>Start Practice</span>
                        @endif
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @include('components.meetings-calendar-modal')
</div>
@endsection
