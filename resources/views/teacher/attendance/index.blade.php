<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Tracking - {{ config('app.name', 'Target Bahasa') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .status-present { background-color: #d1fae5; color: #065f46; border-color: #34d399; }
        .status-absent { background-color: #fee2e2; color: #991b1b; border-color: #f87171; }
        .status-late { background-color: #fef3c7; color: #92400e; border-color: #fbbf24; }
        .status-excused { background-color: #e0e7ff; color: #3730a3; border-color: #818cf8; }
        
        .radio-status:checked + div {
            border-width: 2px;
            font-weight: 600;
        }
        
        /* Custom stylings for the radios based on value */
        input[value="present"]:checked + div { @apply bg-green-50 border-green-500 text-green-700 shadow-sm; }
        input[value="absent"]:checked + div { @apply bg-red-50 border-red-500 text-red-700 shadow-sm; }
        input[value="late"]:checked + div { @apply bg-yellow-50 border-yellow-500 text-yellow-700 shadow-sm; }
        input[value="excused"]:checked + div { @apply bg-blue-50 border-blue-500 text-blue-700 shadow-sm; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-teacher')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 bg-gray-100">
            <!-- Navigation Header -->
            <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-20">
                <div class="px-8 flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-gray-800">Target Bahasa - Teacher</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </nav>

            <div class="p-8" x-data="attendanceTracker()">
                <!-- Header -->
                <div class="mb-8 relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl shadow-lg p-8">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-20 -mt-20"></div>
                    <div class="absolute bottom-0 left-10 w-40 h-40 bg-white opacity-5 rounded-full -mb-20"></div>
                    <div class="relative z-10 text-white flex justify-between items-center">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                <h1 class="text-3xl font-bold">My Class Attendance</h1>
                            </div>
                            <p class="text-blue-100 mt-1 max-w-xl">Record class attendance, monitor student participation, and save daily records.</p>
                        </div>
                        <div class="text-right hidden sm:block">
                            <p class="text-sm text-blue-200 uppercase tracking-widest font-semibold">Today's Date</p>
                            <p class="text-2xl font-bold">{{ now()->format('l, F j, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Top Action Bar & Filters -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
                    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                        <div class="flex gap-4 w-full md:w-auto">
                            <!-- Filters -->
                            <div class="relative min-w-[200px]">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">My Active Classes</label>
                                <select x-model="selectedClassId" @change="fetchMeetings" class="w-full bg-gray-50 border-gray-200 text-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">-- Select Class --</option>
                                    @foreach($classPeriods as $period)
                                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="relative min-w-[150px]">
                                <label class="text-xs font-semibold text-gray-500 mb-1 block">Current Meeting</label>
                                <select x-model="selectedMeetingId" @change="fetchAttendance" :disabled="meetings.length === 0" class="w-full bg-gray-50 border-gray-200 text-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm disabled:opacity-50">
                                    <option value="">-- Select Meeting --</option>
                                    <template x-for="meeting in meetings" :key="meeting.id">
                                        <option :value="meeting.id" x-text="meeting.topic || 'Meeting ' + meeting.meeting_number"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-3 w-full md:w-auto">
                            <button @click="saveAttendance" :disabled="!selectedMeetingId || isSaving" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm shadow-md disabled:opacity-50">
                                <svg x-show="!isSaving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <svg x-show="isSaving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span x-text="isSaving ? 'Saving...' : 'Save Records'"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats for Current Session -->
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl" x-text="students.length"></div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase">My Class</p>
                            <p class="text-sm font-medium text-gray-900">Students</p>
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

                <!-- Attendance Form Area -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    
                    <!-- Table Header -->
                    <div class="bg-gray-50 border-b border-gray-100 p-4 flex justify-between items-center">
                        <div class="flex items-center gap-2 px-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <h2 class="font-bold text-gray-700">Class Roll Call</h2>
                        </div>
                        
                        <button @click="markAll('present')" class="text-sm font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5 border border-blue-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Mark All Present
                        </button>
                    </div>

                    <!-- Student List View -->
                    <div class="divide-y divide-gray-100">
                        <template x-if="students.length === 0 && selectedMeetingId">
                            <div class="p-8 text-center text-gray-500">No students enrolled in this class.</div>
                        </template>
                        <template x-if="!selectedMeetingId">
                            <div class="p-8 text-center text-gray-500">Select a class period and meeting to view the student list.</div>
                        </template>
                        <template x-for="(student, index) in students" :key="student.id">
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6">
                                
                                <!-- Student Info -->
                                <div class="flex items-center gap-4 w-full md:w-1/4 min-w-[250px]">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center font-bold text-gray-600 shadow-inner">
                                        <span x-text="student.name.charAt(0)"></span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900" x-text="student.name"></p>
                                        <p class="text-xs text-gray-500" x-text="'ID: ' + student.id"></p>
                                    </div>
                                </div>

                                <!-- Options (Radio Grid) -->
                                <div class="flex-1 w-full overflow-x-auto pb-2 md:pb-0">
                                    <div class="flex gap-2 min-w-max">
                                        <!-- Present -->
                                        <label class="cursor-pointer relative">
                                            <input type="radio" :name="'attendance[' + student.id + ']'" value="present" x-model="student.status" class="peer sr-only radio-status">
                                            <div class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all flex items-center gap-2">
                                                 <div class="w-3 h-3 rounded-full border border-gray-300 peer-checked:bg-green-500 peer-checked:border-green-500" :class="{'bg-green-500 border-green-500': student.status === 'present'}"></div>
                                                Present
                                            </div>
                                        </label>

                                        <!-- Absent -->
                                        <label class="cursor-pointer relative">
                                            <input type="radio" :name="'attendance[' + student.id + ']'" value="absent" x-model="student.status" class="peer sr-only radio-status">
                                            <div class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full border border-gray-300" :class="{'bg-red-500 border-red-500': student.status === 'absent'}"></div>
                                                Absent
                                            </div>
                                        </label>

                                        <!-- Late -->
                                        <label class="cursor-pointer relative">
                                            <input type="radio" :name="'attendance[' + student.id + ']'" value="late" x-model="student.status" class="peer sr-only radio-status">
                                            <div class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full border border-gray-300" :class="{'bg-yellow-500 border-yellow-500': student.status === 'late'}"></div>
                                                Late
                                            </div>
                                        </label>

                                        <!-- Excused -->
                                        <label class="cursor-pointer relative">
                                            <input type="radio" :name="'attendance[' + student.id + ']'" value="excused" x-model="student.status" class="peer sr-only radio-status">
                                            <div class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-all flex items-center gap-2">
                                                <div class="w-3 h-3 rounded-full border border-gray-300" :class="{'bg-blue-500 border-blue-500': student.status === 'excused'}"></div>
                                                Excused
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Notes Input -->
                                <div class="w-full md:w-1/3 min-w-[250px]">
                                    <input type="text" x-model="student.notes" :placeholder="student.status === 'late' ? 'Reason for being late...' : (student.status === 'excused' ? 'Reason for excuse...' : 'Teacher notes...')" 
                                           class="w-full text-sm border-gray-200 hover:border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 bg-white shadow-sm rounded-lg transition-colors py-2"
                                           :class="{'bg-yellow-50': student.status === 'late', 'bg-blue-50': student.status === 'excused', 'bg-red-50': student.status === 'absent'}">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('attendanceTracker', () => ({
                selectedClassId: '',
                selectedMeetingId: '',
                meetings: [],
                students: [],
                isSaving: false,

                init() {
                    // Initial calculation
                },

                async fetchMeetings() {
                    this.selectedMeetingId = '';
                    this.meetings = [];
                    this.students = [];
                    
                    if (!this.selectedClassId) return;

                    try {
                        const response = await fetch(`/teacher/attendance/meetings/${this.selectedClassId}`);
                        this.meetings = await response.json();
                    } catch (error) {
                        console.error('Error fetching meetings:', error);
                        alert('Failed to load meetings.');
                    }
                },

                async fetchAttendance() {
                    this.students = [];
                    if (!this.selectedMeetingId) return;

                    try {
                        const response = await fetch(`/teacher/attendance/records/${this.selectedMeetingId}`);
                        this.students = await response.json();
                    } catch (error) {
                        console.error('Error fetching attendance records:', error);
                        alert('Failed to load attendance records.');
                    }
                },

                async saveAttendance() {
                    if (!this.selectedMeetingId || this.students.length === 0) return;
                    
                    this.isSaving = true;
                    
                    // Format data for saving
                    const attendanceData = {};
                    this.students.forEach(s => {
                        if (s.status) { // Only save if a status is selected
                            attendanceData[s.id] = {
                                status: s.status,
                                notes: s.notes || ''
                            };
                        }
                    });

                    try {
                        const response = await fetch(`/teacher/attendance/store`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                class_meeting_id: this.selectedMeetingId,
                                attendance: attendanceData
                            })
                        });

                        const result = await response.json();
                        
                        if (response.ok) {
                            alert('Attendance save successfully!');
                        } else {
                            throw new Error(result.message || 'Failed to save');
                        }
                    } catch (error) {
                        console.error('Error saving attendance:', error);
                        alert('An error occurred while saving attendance.');
                    } finally {
                        this.isSaving = false;
                    }
                },

                // Computed property for quick stats
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
                    this.students.forEach(student => {
                        student.status = statusStr;
                    });
                }
            }));
        });
    </script>
</body>
</html>
