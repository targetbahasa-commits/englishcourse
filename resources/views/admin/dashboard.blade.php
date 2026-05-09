<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - {{ config('app.name', 'Target Bahasa') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-admin')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
                    <p class="text-gray-500">Welcome back, {{ Auth::user()->name }}</p>
                </div>
                
                <div class="flex items-center gap-6">
                    @include('components.topbar-action-icons', ['notificationHref' => route('admin.announcements.index'), 'notificationUnread' => false])
                    @if(Auth::user()->role === 'admin')
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            View As
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="open" style="display: none;"
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-50 mb-1">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Switch Dashboard</p>
                            </div>
                            <a href="{{ route('admin.impersonate', 'teacher') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                Teacher <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                            </a>
                            <a href="{{ route('admin.impersonate', 'student') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                Student <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                            </a>
                            <a href="{{ route('admin.impersonate', 'guest') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                Guest <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-full overflow-hidden flex items-center justify-center text-blue-600 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area based on Section -->
            @if(request('section') === 'guest_free_tests')
                @include('guest.components.free-tests-content')
            @else
                <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Students -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $totalStudents }}</h3>
                    <p class="text-gray-500 text-sm">Total Students</p>
                </div>

                <!-- Total Teachers -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $totalTeachers }}</h3>
                    <p class="text-gray-500 text-sm">Total Teachers</p>
                </div>

                <!-- Total Programs -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-green-50 rounded-xl text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $totalPrograms }}</h3>
                    <p class="text-gray-500 text-sm">Active Programs</p>
                </div>

                <!-- Active Assignments -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $activeAssignments }}</h3>
                    <p class="text-gray-500 text-sm">Open Assignments</p>
                </div>
            </div>

            <!-- Overview Grids -->
            <div class="mb-8 grid gap-6 lg:grid-cols-2">
                <!-- Program Performance -->
                <div class="overflow-hidden rounded-2xl border border-gray-100">
                    <div class="border-b border-gray-100 bg-white px-5 py-4">
                        <h3 class="text-sm font-bold text-gray-800">Program Performance</h3>
                    </div>
                    @if(isset($programPerformance) && collect($programPerformance)->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-xs uppercase tracking-[0.12em] text-gray-400">
                                    <tr>
                                        <th class="px-5 py-3 font-semibold">Program</th>
                                        <th class="px-5 py-3 font-semibold text-right">Students</th>
                                        <th class="px-5 py-3 font-semibold text-right">Active</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach($programPerformance as $prog)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-5 py-4 font-semibold text-gray-800">{{ $prog->name }}</td>
                                            <td class="px-5 py-4 text-right text-gray-600">{{ $prog->students_count ?? 0 }}</td>
                                            <td class="px-5 py-4 text-right">
                                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                                    {{ $prog->active_students_count ?? 0 }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-5 py-10 text-sm text-gray-400 bg-white">No program data available.</div>
                    @endif
                </div>

                <!-- Teacher Activity -->
                <div class="overflow-hidden rounded-2xl border border-gray-100">
                    <div class="border-b border-gray-100 bg-white px-5 py-4">
                        <h3 class="text-sm font-bold text-gray-800">Top Teachers</h3>
                    </div>
                    @if(isset($teacherActivitySummary) && collect($teacherActivitySummary)->isNotEmpty())
                        <div class="space-y-2 p-5 bg-white h-full">
                            @foreach($teacherActivitySummary as $teacher)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-800">{{ $teacher->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $teacher->program_count ?? 0 }} program{{ $teacher->program_count !== 1 ? 's' : '' }}</div>
                                    </div>
                                    <div class="text-2xl font-black text-blue-600">{{ $teacher->program_count ?? 0 }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-5 py-10 text-sm text-gray-400 bg-white">No teacher data available.</div>
                    @endif
                </div>
            </div>

            <!-- Realtime Monitoring -->
            <div class="mb-8" x-data="{
                search: '',
                selectedProgram: '',
                programOptions: ['IELTS Academic', 'IELTS General', 'PTE', 'Grammar for Writing'],
                students: [
                    @foreach($activeStudents ?? [] as $student)
                    {
                        id: {{ $student->id }},
                        name: '{{ addslashes($student->name) }}',
                        role: '{{ $student->role }}',
                        program: '{{ $student->role === 'guest' ? 'Free Test' : addslashes($student->program_name ?? 'No Program Assigned') }}',
                        last_activity: {{ $student->last_activity }},
                    },
                    @endforeach
                ],
                normalizeProgram(program) {
                    const value = (program || '').toLowerCase();

                    if (value.includes('grammar for writing') || value.includes('grammar-writing')) {
                        return 'Grammar for Writing';
                    }

                    if (value.includes('ielts general')) {
                        return 'IELTS General';
                    }

                    if (value.includes('ielts')) {
                        return 'IELTS Academic';
                    }

                    if (value.includes('pte')) {
                        return 'PTE';
                    }

                    return '';
                },
                get filteredStudents() {
                    return this.students.filter(s => {
                        const matchesSearch =
                            s.name.toLowerCase().includes(this.search.toLowerCase()) ||
                            s.program.toLowerCase().includes(this.search.toLowerCase());
                        const matchesProgram = !this.selectedProgram || this.normalizeProgram(s.program) === this.selectedProgram;

                        return matchesSearch && matchesProgram;
                    }).sort((a,b) => b.last_activity - a.last_activity);
                },
                formatTime(timestamp) {
                    if(!timestamp) return '';
                    const now = Math.floor(Date.now() / 1000);
                    const diffInSeconds = now - timestamp;
                    
                    if (diffInSeconds < 60) return `Just now`;
                    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} mins ago`;
                    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
                    return `${Math.floor(diffInSeconds / 86400)} days ago`;
                },
                isIdle(timestamp) {
                    const now = Math.floor(Date.now() / 1000);
                    const diffInSeconds = now - timestamp;
                    // Consider idle if no activity in the last 15 minutes (900 seconds)
                    return diffInSeconds > 900;
                }
            }">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <h3 class="text-xl font-bold text-gray-800">Recently Active Students</h3>
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                        </div>
                        <div class="flex gap-3">
                            <select x-model="selectedProgram" class="form-control rounded-xl text-sm border-gray-200 min-w-[180px]">
                                <option value="">Semua Kelas</option>
                                <template x-for="program in programOptions" :key="program">
                                    <option :value="program" x-text="program"></option>
                                </template>
                            </select>
                            <input type="text" x-model="search" placeholder="Search student..." class="form-control rounded-xl text-sm border-gray-200">
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 text-sm border-b border-gray-100">
                                    <th class="pb-3 font-medium">Student Name</th>
                                    <th class="pb-3 font-medium">Status</th>
                                    <th class="pb-3 font-medium">Role</th>
                                    <th class="pb-3 font-medium">Program</th>
                                    <th class="pb-3 font-medium">Last Seen</th>
                                    <th class="pb-3 font-medium text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="student in filteredStudents" :key="student.id">
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition" :class="{'opacity-80': isIdle(student.last_activity)}">
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm" x-text="student.name.charAt(0)"></div>
                                                <div>
                                                    <span class="font-medium text-gray-800 block" x-text="student.name"></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <template x-if="!isIdle(student.last_activity)">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Online
                                                </span>
                                            </template>
                                            <template x-if="isIdle(student.last_activity)">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span> Offline
                                                </span>
                                            </template>
                                        </td>
                                        <td class="py-4 text-sm text-gray-700">
                                            <span class="block font-medium capitalize" x-text="student.role"></span>
                                        </td>
                                        <td class="py-4 text-sm text-gray-700">
                                            <span class="block text-xs text-gray-500" x-text="student.program"></span>
                                        </td>
                                        <td class="py-4">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100" x-text="formatTime(student.last_activity)">
                                            </span>
                                        </td>
                                        <td class="py-4 text-right flex flex-col gap-2 items-end">
                                            <template x-if="student.role === 'student'">
                                                <a :href="`/admin/students/${student.id}`" class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition inline-block">View Details</a>
                                            </template>
                                            <template x-if="student.role === 'guest'">
                                                <a :href="`/admin/users/${student.id}`" class="px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg transition shadow-sm inline-block">Manage Guest</a>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredStudents.length === 0" x-cloak>
                                    <td colspan="6" class="py-8 text-center text-gray-400">
                                        No active students found in the last 24 hours.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions, Admin Controls, & System Status Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('students.index') }}" class="w-full flex items-center gap-3 p-3 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition text-left">
                            <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Manage Students</span>
                        </a>
                        <a href="{{ route('teachers.index') }}" class="w-full flex items-center gap-3 p-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition text-left">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Manage Teachers</span>
                        </a>
                        <button onclick="alert('Announcement Broadcast Functionality Here')" class="w-full flex items-center gap-3 p-3 bg-orange-50 hover:bg-orange-100 rounded-xl transition text-left">
                            <div class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Broadcast Announcement</span>
                        </button>
                        <a href="{{ route('admin.scholarships.create') }}" class="w-full flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-xl transition text-left">
                            <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Add Scholarship</span>
                        </a>
                        <a href="{{ route('admin.whv-applications.create') }}" class="w-full flex items-center gap-3 p-3 bg-amber-50 hover:bg-amber-100 rounded-xl transition text-left">
                            <div class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8.97 5.7a1 1 0 01-1.06 0L4 7m16 0a2 2 0 00-2-2H6a2 2 0 00-2 2m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m9 10.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Add WHV Program</span>
                        </a>
                    </div>
                </div>

                <!-- Admin Controls -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Instructor Controls</h3>
                    <div class="space-y-3">
                        <a href="{{ route('assignments.index') }}" class="w-full flex items-center gap-3 p-3 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition text-left">
                            <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">All Assignments</span>
                        </a>
                        <a href="{{ route('class-periods.index') }}" class="w-full flex items-center gap-3 p-3 bg-red-50 hover:bg-red-100 rounded-xl transition text-left">
                            <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Class Periods</span>
                        </a>
                        <a href="{{ route('admin.attendance.index') }}" class="w-full flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition text-left">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Attendance Summary</span>
                        </a>
                        <a href="{{ route('admin.whv-applications.index') }}" class="w-full flex items-center gap-3 p-3 bg-amber-50 hover:bg-amber-100 rounded-xl transition text-left">
                            <div class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V6a3 3 0 013-3h0a3 3 0 013 3v1m4 0H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-700">WHV Programs</div>
                                <div class="text-xs text-gray-500">Kelola landing page program WHV Australia</div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">System Status</h3>
                    <div class="grid grid-cols-1 gap-4 flex-1">
                        <div class="p-4 border border-gray-100 rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-500">Database Status</span>
                                @if($dbStatus === 'Connected')
                                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-bold rounded-full">Connected</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full">Disconnected</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400">Driver: {{ config('database.default') }}</p>
                        </div>
                        <div class="p-4 border border-gray-100 rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-500">System Version</span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-600 text-xs font-bold rounded-full">{{ $appVersion }}</span>
                            </div>
                            <p class="text-xs text-gray-400">Environment: {{ app()->environment() }}</p>
                        </div>
                        <div class="p-4 border border-gray-100 rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-500">Email Service</span>
                                <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-bold rounded-full">Operational</span>
                            </div>
                            <p class="text-xs text-gray-400">Driver: {{ strtoupper($mailService) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Scholarships Closing Soon --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Scholarships Closing Soon</h3>
                        <a href="{{ route('admin.scholarships.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">View All →</a>
                    </div>
                    @if(isset($closingSoonScholarships) && collect($closingSoonScholarships)->isNotEmpty())
                        <ul class="space-y-3 flex-1">
                            @foreach($closingSoonScholarships as $s)
                            <li class="flex items-start gap-3">
                                <div class="mt-0.5 p-2 rounded-lg shrink-0
                                    {{ $s->deadline->diffInDays(now()) <= 3 ? 'bg-red-100 text-red-500' : 'bg-amber-100 text-amber-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $s->title }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Closes {{ $s->deadline->format('d M Y') }}
                                        <span class="
                                            {{ $s->deadline->diffInDays(now()) <= 3 ? 'text-red-500 font-semibold' : 'text-amber-500' }}">
                                            ({{ $s->deadline->diffForHumans() }})
                                        </span>
                                    </p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('admin.scholarships.create') }}" class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add New Scholarship
                        </a>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center py-6 text-center">
                            <svg class="w-10 h-10 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-gray-400">No scholarships closing in the next 14 days.</p>
                        </div>
                        <a href="{{ route('admin.scholarships.create') }}" class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add New Scholarship
                        </a>
                    @endif
                </div>
            </div>
            @endif
        </main>
    </div>

    <div id="copy-link-toast" class="pointer-events-none fixed bottom-6 right-6 z-[100] hidden translate-y-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-semibold text-white opacity-0 shadow-lg transition-all duration-200 ease-out">
        <span class="inline-flex items-center gap-2">
            <svg id="copy-link-toast-icon-success" class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <svg id="copy-link-toast-icon-error" class="hidden h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span id="copy-link-toast-text">Link copied</span>
        </span>
    </div>

    </div>

    <script>
        let copyLinkToastTimeout = null;

        function copyReplayLink(url) {
            if (!url) {
                return;
            }

            const showToast = (message, type = 'success') => {
                const toast = document.getElementById('copy-link-toast');
                const toastText = document.getElementById('copy-link-toast-text');
                const successIcon = document.getElementById('copy-link-toast-icon-success');
                const errorIcon = document.getElementById('copy-link-toast-icon-error');
                if (!toast) {
                    return;
                }

                if (toastText) {
                    toastText.textContent = message;
                }
                toast.classList.remove('bg-emerald-600', 'bg-rose-600');
                toast.classList.add(type === 'error' ? 'bg-rose-600' : 'bg-emerald-600');

                if (successIcon && errorIcon) {
                    if (type === 'error') {
                        successIcon.classList.add('hidden');
                        errorIcon.classList.remove('hidden');
                    } else {
                        errorIcon.classList.add('hidden');
                        successIcon.classList.remove('hidden');
                    }
                }

                toast.classList.remove('hidden');
                toast.classList.remove('opacity-0', 'translate-y-2');
                toast.classList.add('opacity-100', 'translate-y-0');

                if (copyLinkToastTimeout) {
                    clearTimeout(copyLinkToastTimeout);
                }

                copyLinkToastTimeout = setTimeout(() => {
                    toast.classList.remove('opacity-100', 'translate-y-0');
                    toast.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 200);
                }, 1400);
            };

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url)
                    .then(() => showToast('Link copied', 'success'))
                    .catch(() => showToast('Copy failed', 'error'));
                return;
            }

            const input = document.createElement('input');
            input.value = url;
            document.body.appendChild(input);
            input.select();

            try {
                const successful = document.execCommand('copy');
                showToast(successful ? 'Link copied' : 'Copy failed', successful ? 'success' : 'error');
            } catch (error) {
                showToast('Copy failed', 'error');
            }

            document.body.removeChild(input);
        }

        document.addEventListener('keydown', function (event) {
            if (!(event.metaKey || event.ctrlKey) || String(event.key).toLowerCase() !== 'c') {
                return;
            }

            const activeElement = document.activeElement;
            if (!activeElement) {
                return;
            }

            const replayUrl = activeElement.getAttribute('data-replay-url');
            if (!replayUrl) {
                return;
            }

            event.preventDefault();
            copyReplayLink(replayUrl);
        });
    </script>
</body>
</html>
