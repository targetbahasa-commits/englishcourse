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
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold text-gray-800">Target Bahasa - Teacher</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-700 mr-4">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if(request('section') === 'guest_free_tests')
                            @include('guest.components.free-tests-content')
                        @else
                        <h2 class="text-2xl font-bold mb-4">Teacher Dashboard</h2>
                        <p class="text-gray-600">Welcome to the teacher dashboard. View student progress and manage your classes here.</p>
                        
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
                                                        <a :href="student.url" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Page</a>
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
                </div>
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
