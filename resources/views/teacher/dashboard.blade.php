<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teacher Dashboard - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

            <!-- Page Content -->
            <div class="p-8">
                        @if(request('section') === 'guest_free_tests')
                            @include('guest.components.free-tests-content')
                        @else
                        <h2 class="text-2xl font-bold mb-4">Teacher Dashboard</h2>
                        <p class="text-gray-600">Welcome to the teacher dashboard. View student progress and manage your classes here.</p>

                        <!-- Announcements Section -->
                        @if(isset($announcements) && $announcements->count() > 0)
                            <div class="mt-6 mb-8 space-y-4">
                                @foreach($announcements as $announcement)
                                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-5 shadow-sm relative overflow-hidden">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="text-blue-900 font-bold text-lg flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                                    {{ $announcement->title }}
                                                </h3>
                                                <div class="mt-2 text-blue-800 text-sm whitespace-pre-line">{{ $announcement->content }}</div>
                                            </div>
                                            <span class="text-xs text-blue-400 font-medium bg-blue-100 px-2 py-1 rounded">{{ $announcement->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-blue-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-blue-900 mb-2">My Classes</h3>
                                <p class="text-blue-700 text-sm">View and manage your classes</p>
                            </div>
                            <div class="bg-green-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-green-900 mb-2">Student Progress</h3>
                                <p class="text-green-700 text-sm">Track student performance</p>
                            </div>
                            <div class="bg-purple-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-purple-900 mb-2">Assignments</h3>
                                <p class="text-purple-700 text-sm">Review and grade assignments</p>
                            </div>
                        </div>

                        <!-- Realtime Monitoring -->
                        <div class="mt-8" x-data="monitoringDashboard()">
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                <div class="flex justify-between items-center mb-6">
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-xl font-bold text-gray-800">Live Student Monitoring</h3>
                                        <span class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                        </span>
                                    </div>
                                    <div class="flex gap-3">
                                        <input type="text" x-model="search" placeholder="Search student..." class="form-control rounded-lg text-sm border-gray-200">
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="text-gray-400 text-sm border-b border-gray-100">
                                                <th class="pb-3 font-medium">Student Name</th>
                                                <th class="pb-3 font-medium">Current Page</th>
                                                <th class="pb-3 font-medium">Last Active</th>
                                                <th class="pb-3 font-medium text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="student in filteredStudents" :key="student.id">
                                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                                    <td class="py-4">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm" x-text="student.name.charAt(0)"></div>
                                                            <span class="font-medium text-gray-800" x-text="student.name"></span>
                                                        </div>
                                                    </td>
                                                    <td class="py-4">
                                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                            <span x-text="student.title"></span>
                                                        </span>
                                                    </td>
                                                    <td class="py-4 text-sm text-gray-500" x-text="formatTime(student.timestamp)"></td>
                                                    <td class="py-4 text-right">
                                                        <div class="flex items-center justify-end gap-2">
                                                            <a :href="student.url" target="_blank" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg transition inline-block border border-gray-200">View Page</a>
                                                            <a :href="`/teacher/remote-view/${student.id}`" target="_blank" class="px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition inline-block">
                                                                <div class="flex items-center gap-1.5">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                                    View Screen
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr x-show="filteredStudents.length === 0" x-cloak>
                                                <td colspan="4" class="py-8 text-center text-gray-400">
                                                    No students are currently active.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('monitoringDashboard', () => ({
                search: '',
                students: {},
                
                init() {
                    if (typeof window.Echo !== 'undefined') {
                        window.Echo.join('monitoring')
                            .here((users) => {
                                users.forEach(user => {
                                    if(user.role === 'student' || user.role === 'guest') {
                                        this.students[user.id] = { id: user.id, name: user.name, title: 'Loading...', url: '#', timestamp: new Date() };
                                    }
                                });
                            })
                            .joining((user) => {
                                if(user.role === 'student' || user.role === 'guest') {
                                    this.students[user.id] = { id: user.id, name: user.name, title: 'Just joined...', url: '#', timestamp: new Date() };
                                }
                            })
                            .leaving((user) => {
                                delete this.students[user.id];
                            })
                            .listenForWhisper('client-page-update', (e) => {
                                this.students[e.id] = {
                                    id: e.id,
                                    name: e.name,
                                    title: e.title,
                                    url: e.url,
                                    timestamp: new Date(e.timestamp)
                                };
                            });
                        
                        setInterval(() => {
                            const now = new Date();
                            for(let id in this.students) {
                                if (now - this.students[id].timestamp > 120000) {
                                    delete this.students[id];
                                }
                            }
                        }, 30000);
                    }
                },

                get filteredStudents() {
                    return Object.values(this.students).filter(s => {
                        return s.name.toLowerCase().includes(this.search.toLowerCase()) || 
                               s.title.toLowerCase().includes(this.search.toLowerCase());
                    }).sort((a,b) => b.timestamp - a.timestamp);
                },

                formatTime(date) {
                    if(!date) return '';
                    const now = new Date();
                    const diffInSeconds = Math.floor((now - date) / 1000);
                    
                    if (diffInSeconds < 60) return `Just now`;
                    if (diffInSeconds < 120) return `1 min ago`;
                    return `${Math.floor(diffInSeconds / 60)} mins ago`;
                }
            }))
        })
    </script>
</body>
</html>
