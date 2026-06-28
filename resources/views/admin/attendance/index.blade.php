@extends('layouts.admin')

@section('title', 'Attendance Tracking')

@push('styles')
<style>
    .status-present { background-color: #d1fae5; color: #065f46; border-color: #34d399; }
    .status-absent  { background-color: #fee2e2; color: #991b1b; border-color: #f87171; }
    .status-late    { background-color: #fef3c7; color: #92400e; border-color: #fbbf24; }
    .status-excused { background-color: #e0e7ff; color: #3730a3; border-color: #818cf8; }

    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-8" x-data="attendanceTracker()" x-cloak>

    {{-- Header --}}
    <div class="mb-8 relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl shadow-lg p-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-10 w-40 h-40 bg-white opacity-5 rounded-full -mb-20"></div>
        <div class="relative z-10 text-white flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </span>
                    <h1 class="text-3xl font-bold">Attendance Tracking</h1>
                </div>
                <p class="text-blue-100 mt-1 max-w-xl">Record class attendance, monitor student participation, and generate reports.</p>
            </div>
            <div class="text-right hidden sm:block">
                <p class="text-sm text-blue-200 uppercase tracking-widest font-semibold">Today's Date</p>
                <p class="text-2xl font-bold">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Top Action Bar & Filters --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6 sticky top-0 z-20">
        <div class="flex flex-col gap-4">

            {{-- Batch Filter Row --}}
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-end">
                <div class="flex gap-4 flex-1">
                    <div class="relative min-w-[120px]" x-show="selectedBatchType">
                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Batch Number</label>
                        <select x-model="selectedBatchNumber" @change="fetchBatchInfo" :disabled="!selectedBatchType"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm disabled:opacity-50">
                            <option value="">-- All Numbers --</option>
                            <template x-for="num in batchNumbers" :key="num">
                                <option :value="num" x-text="'Batch ' + num"></option>
                            </template>
                        </select>
                    </div>

                    <div x-show="selectedBatchType" class="flex items-end gap-3 pl-3 border-l border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 font-semibold">CLASSES:</span>
                            <span class="text-lg font-bold text-blue-600" x-text="batchInfo.count?.classes || 0"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 font-semibold">STUDENTS:</span>
                            <span class="text-lg font-bold text-indigo-600" x-text="batchInfo.count?.students || 0"></span>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-gray-500 font-semibold">
                    <span x-show="!selectedBatchType">Select batch type below to filter</span>
                </div>
            </div>

            {{-- Class & Meeting Selection Row --}}
            <div class="flex flex-col md:flex-row gap-4 justify-between items-start md:items-end">
                <div class="flex gap-4 w-full md:w-auto flex-1 flex-wrap">

                    {{-- Batch Type Selector --}}
                    <div class="relative min-w-[150px]">
                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Batch Type</label>
                        <select x-model="selectedBatchType" @change="fetchBatchInfo"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- All Classes --</option>
                            @foreach(array_keys($batches) as $batchType)
                                <option value="{{ $batchType }}">{{ ucfirst($batchType) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Class Period Selector --}}
                    <div class="relative min-w-[220px]">
                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Class Period</label>
                        <select x-model="selectedClassId" @change="fetchMeetings"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Select Class --</option>
                            <template x-for="period in classPeriods" :key="period.id">
                                <option :value="period.id" x-text="(period.batch_number ? 'Batch ' + period.batch_number + ' — ' : '') + period.name"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Meeting Selector --}}
                    <div class="relative min-w-[180px]">
                        <label class="text-xs font-semibold text-gray-500 mb-1 block">Meeting</label>
                        <select x-model="selectedMeetingId" @change="fetchAttendance" :disabled="!selectedClassId || isLoadingMeetings"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm disabled:opacity-50">
                            <option value="">-- Select Meeting --</option>
                            <template x-if="selectedClassId && meetings.length === 0 && !isLoadingMeetings">
                                <option value="" disabled>No meetings — add one below ↓</option>
                            </template>
                            <template x-for="meeting in meetings" :key="meeting.id">
                                <option :value="meeting.id" x-text="'M' + meeting.meeting_number + ': ' + (meeting.topic || 'Meeting ' + meeting.meeting_number) + (meeting.meeting_date ? ' (' + meeting.meeting_date + ')' : '')"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 w-full md:w-auto shrink-0">
                    <button @click="saveAttendance" :disabled="!selectedMeetingId || isSaving"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm shadow-md disabled:opacity-50">
                        <svg x-show="!isSaving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <svg x-show="isSaving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span x-text="isSaving ? 'Saving...' : 'Save Attendance'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Meeting Panel (shown when class selected but no meetings) --}}
    <div x-show="selectedClassId && !isLoadingMeetings && meetings.length === 0"
         class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-amber-100 rounded-xl">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-amber-800 mb-1">No meetings configured for this class</h3>
                <p class="text-sm text-amber-700 mb-4">This class period doesn't have predefined meetings. Add them manually below.</p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" x-model="newMeetingTopic" placeholder="Meeting topic (e.g. IELTS Full Package Week 1)"
                        class="flex-1 border border-amber-300 rounded-lg px-3 py-2 text-sm focus:ring-amber-400 focus:border-amber-400 bg-white">
                    <input type="date" x-model="newMeetingDate"
                        class="border border-amber-300 rounded-lg px-3 py-2 text-sm focus:ring-amber-400 focus:border-amber-400 bg-white">
                    <button @click="addMeeting" :disabled="!newMeetingTopic || isAddingMeeting"
                        class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg text-sm disabled:opacity-50 flex items-center gap-2 whitespace-nowrap">
                        <svg x-show="!isAddingMeeting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <svg x-show="isAddingMeeting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Add Meeting
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Meeting Panel (shown when meetings exist — collapsible) --}}
    <div x-show="selectedClassId && meetings.length > 0" class="mb-6">
        <details class="bg-white border border-gray-100 rounded-2xl shadow-sm">
            <summary class="p-4 font-semibold text-gray-700 cursor-pointer flex items-center gap-2 select-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Another Meeting
            </summary>
            <div class="p-4 border-t border-gray-100 flex flex-col sm:flex-row gap-3">
                <input type="text" x-model="newMeetingTopic" placeholder="Meeting topic"
                    class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-blue-400 focus:border-blue-400">
                <input type="date" x-model="newMeetingDate"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-blue-400 focus:border-blue-400">
                <button @click="addMeeting" :disabled="!newMeetingTopic || isAddingMeeting"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm disabled:opacity-50 flex items-center gap-2 whitespace-nowrap">
                    <svg x-show="!isAddingMeeting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <svg x-show="isAddingMeeting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Add Meeting
                </button>
            </div>
        </details>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl" x-text="students.length"></div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Total</p>
                <p class="text-sm font-medium text-gray-900">Enrolled</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center font-bold text-xl" x-text="counts.present"></div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Present</p>
                <p class="text-sm font-medium text-gray-900">On Time</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-bold text-xl" x-text="counts.absent"></div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Absent</p>
                <p class="text-sm font-medium text-gray-900">No Show</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center font-bold text-xl" x-text="counts.late"></div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Late</p>
                <p class="text-sm font-medium text-gray-900">Tardy</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xl" x-text="counts.excused"></div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Excused</p>
                <p class="text-sm font-medium text-gray-900">With Notice</p>
            </div>
        </div>
    </div>

    {{-- Attendance Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Table Header --}}
        <div class="bg-gray-50 border-b border-gray-100 p-4 flex justify-between items-center">
            <div class="flex items-center gap-2 px-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <h2 class="font-bold text-gray-700">Student List</h2>
                <span x-show="selectedMeetingId && students.length > 0" class="ml-2 text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-semibold" x-text="students.length + ' students'"></span>
            </div>
            <button x-show="students.length > 0" @click="markAll('present')"
                class="text-sm font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5 border border-blue-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Mark All Present
            </button>
        </div>

        {{-- Student List --}}
        <div class="divide-y divide-gray-100">
            <template x-if="isLoadingMeetings">
                <div class="p-8 text-center text-gray-400 flex flex-col items-center gap-3">
                    <svg class="w-8 h-8 animate-spin text-blue-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Loading...</span>
                </div>
            </template>
            <template x-if="!isLoadingMeetings && !selectedClassId">
                <div class="p-10 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="font-medium">Select a class period to begin</p>
                </div>
            </template>
            <template x-if="!isLoadingMeetings && selectedClassId && !selectedMeetingId && meetings.length > 0">
                <div class="p-8 text-center text-gray-500">Select a meeting to view the student list.</div>
            </template>
            <template x-if="!isLoadingMeetings && selectedClassId && !selectedMeetingId && meetings.length === 0">
                <div class="p-8 text-center text-gray-500">Add meetings for this class to start recording attendance.</div>
            </template>
            <template x-if="selectedMeetingId && students.length === 0 && !isLoadingMeetings">
                <div class="p-8 text-center text-gray-500">No students enrolled in this class.</div>
            </template>

            <template x-for="(student, index) in students" :key="student.id">
                <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6">

                    {{-- Student Info --}}
                    <div class="flex items-center gap-4 w-full md:w-1/4 min-w-[200px]">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-200 flex items-center justify-center font-bold text-indigo-700 shadow-inner shrink-0">
                            <span x-text="student.name.charAt(0).toUpperCase()"></span>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900" x-text="student.name"></p>
                            <p class="text-xs text-gray-400" x-text="'ID: TB-' + student.id"></p>
                        </div>
                    </div>

                    {{-- Status Radio Buttons --}}
                    <div class="flex-1 w-full overflow-x-auto pb-2 md:pb-0">
                        <div class="flex gap-2 min-w-max">
                            <template x-for="opt in [{val:'present', label:'Present', ring:'ring-green-400', bg:'bg-green-50', text:'text-green-700', dot:'bg-green-500'},
                                                     {val:'absent', label:'Absent', ring:'ring-red-400', bg:'bg-red-50', text:'text-red-700', dot:'bg-red-500'},
                                                     {val:'late', label:'Late', ring:'ring-yellow-400', bg:'bg-yellow-50', text:'text-yellow-700', dot:'bg-yellow-500'},
                                                     {val:'excused', label:'Excused', ring:'ring-blue-400', bg:'bg-blue-50', text:'text-blue-700', dot:'bg-blue-500'}]" :key="opt.val">
                                <label class="cursor-pointer">
                                    <input type="radio" :name="'attendance_' + student.id" :value="opt.val" x-model="student.status" class="sr-only">
                                    <div class="px-4 py-2 border-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2"
                                         :class="student.status === opt.val
                                             ? [opt.bg, opt.text, opt.ring, 'ring-2 border-transparent font-semibold']
                                             : 'border-gray-200 text-gray-500 hover:border-gray-300'">
                                        <div class="w-2.5 h-2.5 rounded-full border border-gray-300 transition-colors"
                                             :class="student.status === opt.val ? [opt.dot, 'border-transparent'] : ''"></div>
                                        <span x-text="opt.label"></span>
                                    </div>
                                </label>
                            </template>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="w-full md:w-1/3 min-w-[200px]">
                        <input type="text" x-model="student.notes"
                            :placeholder="student.status === 'late' ? 'Reason for being late...' : (student.status === 'excused' ? 'Reason for excuse...' : 'Add a note (optional)')"
                            class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:border-blue-400 focus:ring focus:ring-blue-100 transition-colors"
                            :class="{'bg-yellow-50': student.status==='late','bg-blue-50': student.status==='excused','bg-red-50': student.status==='absent','bg-green-50': student.status==='present'}">
                    </div>
                </div>
            </template>
        </div>

        {{-- Bottom Save --}}
        <div x-show="students.length > 0" class="bg-gray-50 px-6 py-4 flex justify-end border-t border-gray-100">
            <button @click="saveAttendance" :disabled="!selectedMeetingId || isSaving"
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg disabled:opacity-50">
                <svg x-show="!isSaving" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                <svg x-show="isSaving" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span x-text="isSaving ? 'Saving Records...' : 'Save Attendance Record'"></span>
            </button>
        </div>
    </div>

    {{-- Success toast --}}
    <div x-show="toast.show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3 rounded-xl shadow-xl text-sm font-semibold"
         :class="toast.type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'">
        <svg x-show="toast.type==='success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <svg x-show="toast.type==='error'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        <span x-text="toast.message"></span>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('attendanceTracker', () => ({
        selectedClassId:     '',
        selectedMeetingId:   '',
        selectedBatchType:   '',
        selectedBatchNumber: '',
        meetings:            [],
        students:            [],
        isSaving:            false,
        isLoadingMeetings:   false,
        batchInfo:           { count: { classes: 0, students: 0 } },
        batchNumbers:        [],
        allBatches:          @json($batches),
        availableClassPeriods: @json($classPeriods),
        classPeriods:        @json($classPeriods),
        newMeetingTopic:     '',
        newMeetingDate:      '',
        isAddingMeeting:     false,
        toast:               { show: false, message: '', type: 'success' },

        init() {
            this.updateBatchNumbers();
        },

        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => { this.toast.show = false; }, 3500);
        },

        updateBatchNumbers() {
            if (this.selectedBatchType && this.allBatches[this.selectedBatchType]) {
                this.batchNumbers = this.allBatches[this.selectedBatchType];
            } else {
                this.batchNumbers = [];
            }
        },

        async fetchBatchInfo() {
            if (!this.selectedBatchType) {
                this.batchInfo = { count: { classes: 0, students: 0 } };
                this.classPeriods = this.availableClassPeriods;
                this.batchNumbers = [];
                this.selectedBatchNumber = '';
                this.selectedClassId = '';
                this.selectedMeetingId = '';
                this.meetings = [];
                this.students = [];
                return;
            }

            this.updateBatchNumbers();
            this.selectedClassId = '';
            this.selectedMeetingId = '';
            this.meetings = [];
            this.students = [];

            try {
                const url = this.selectedBatchNumber
                    ? `/admin/attendance/batch/${this.selectedBatchType}/${this.selectedBatchNumber}`
                    : `/admin/attendance/batch/${this.selectedBatchType}`;
                const response = await fetch(url);
                const data = await response.json();
                this.batchInfo = data;
                this.classPeriods = data.class_periods || [];
            } catch (error) {
                console.error('Error fetching batch info:', error);
                this.batchInfo = { count: { classes: 0, students: 0 } };
                this.classPeriods = [];
            }
        },

        async fetchMeetings() {
            this.selectedMeetingId = '';
            this.meetings = [];
            this.students = [];

            if (!this.selectedClassId) return;

            this.isLoadingMeetings = true;
            try {
                const response = await fetch(`/admin/attendance/meetings/${this.selectedClassId}`);
                this.meetings = await response.json();
            } catch (error) {
                console.error('Error fetching meetings:', error);
                this.showToast('Failed to load meetings.', 'error');
            } finally {
                this.isLoadingMeetings = false;
            }
        },

        async fetchAttendance() {
            this.students = [];
            if (!this.selectedMeetingId) return;

            try {
                const response = await fetch(`/admin/attendance/records/${this.selectedMeetingId}`);
                this.students = await response.json();
            } catch (error) {
                console.error('Error fetching attendance records:', error);
                this.showToast('Failed to load attendance records.', 'error');
            }
        },

        async addMeeting() {
            if (!this.newMeetingTopic || !this.selectedClassId) return;

            this.isAddingMeeting = true;
            try {
                const response = await fetch(`/admin/attendance/meetings/${this.selectedClassId}/create`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        topic:        this.newMeetingTopic,
                        meeting_date: this.newMeetingDate || null,
                    }),
                });
                const result = await response.json();
                if (response.ok && result.success) {
                    this.meetings.push(result.meeting);
                    this.newMeetingTopic = '';
                    this.newMeetingDate  = '';
                    this.showToast('Meeting added successfully!');
                } else {
                    this.showToast(result.message || 'Failed to add meeting.', 'error');
                }
            } catch (error) {
                console.error('Error adding meeting:', error);
                this.showToast('An error occurred.', 'error');
            } finally {
                this.isAddingMeeting = false;
            }
        },

        async saveAttendance() {
            if (!this.selectedMeetingId || this.students.length === 0) return;

            this.isSaving = true;
            const attendanceData = {};
            this.students.forEach(s => {
                if (s.status) {
                    attendanceData[s.id] = { status: s.status, notes: s.notes || '' };
                }
            });

            try {
                const response = await fetch('/admin/attendance/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        class_meeting_id: this.selectedMeetingId,
                        attendance: attendanceData,
                    }),
                });
                const result = await response.json();
                if (response.ok) {
                    this.showToast('Attendance saved successfully!');
                } else {
                    throw new Error(result.message || 'Failed to save');
                }
            } catch (error) {
                console.error('Error saving attendance:', error);
                this.showToast('An error occurred while saving attendance.', 'error');
            } finally {
                this.isSaving = false;
            }
        },

        get counts() {
            let present = 0, absent = 0, late = 0, excused = 0;
            this.students.forEach(s => {
                if (s.status === 'present') present++;
                else if (s.status === 'absent') absent++;
                else if (s.status === 'late') late++;
                else if (s.status === 'excused') excused++;
            });
            return { present, absent, late, excused };
        },

        markAll(statusStr) {
            if (this.students.length === 0) return;
            this.students.forEach(student => { student.status = statusStr; });
        },
    }));
});
</script>
@endpush
