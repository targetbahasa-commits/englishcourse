<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - TOEFL ITP Reading</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3FFFF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md fixed h-full z-10 hidden md:block">
            <div class="p-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
                <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
            </div>
            
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <!-- Admin/Teacher Sidebar -->
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-gray-400 mb-4">MAIN MENU</p>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            User Management
                        </a>
                        <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-medium border-l-4 border-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Assignments
                        </a>
                    </nav>
                </div>
            @else
                <!-- Student Sidebar -->
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-gray-400 mb-4">MENU UTAMA</p>
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-medium border-l-4 border-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Assignments
                        </a>
                    </nav>
                </div>
                
                <div class="absolute bottom-8 px-6 w-full">
                    <p class="text-xs font-semibold text-gray-400 mb-4">AKUN</p>
                    <nav class="space-y-2">
                         <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile
                        </a>
                    </nav>
                </div>
            @endif

            <div class="absolute bottom-8 px-6 w-full">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition w-full text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div class="relative w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                    <p class="font-bold">Error</p>
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">TOEFL ITP Reading</h2>
                    <p class="text-gray-500 text-sm">Improve your reading comprehension skills.</p>
                </div>
                <div class="flex items-center gap-3">
                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                    <button onclick="document.getElementById('addMeetingModal').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm hover:bg-blue-700 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Lesson
                    </button>
                    @endif
                    <a href="{{ route('assignments.toefl-itp') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <!-- Meetings Grid -->
            <div id="meetings-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach($meetings as $meeting)
                <div class="meeting-card bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative" data-id="{{ $meeting->id }}">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 {{ $meeting->is_locked ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }} rounded-full text-xs font-bold">
                            {{ $meeting->is_locked ? 'LOCKED' : 'OPEN' }}
                        </span>
                        
                        <div class="flex items-center gap-2">
                            <!-- Drag Handle -->
                            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                            <div class="cursor-move text-gray-300 hover:text-gray-500 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                            </div>
                            @endif
                            
                            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                            <!-- Lock Toggle -->
                            <form action="{{ route('assignments.toefl-itp.reading.toggle-lock', $meeting) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-gray-600 transition" title="{{ $meeting->is_locked ? 'Unlock' : 'Lock' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($meeting->is_locked)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                        @endif
                                    </svg>
                                </button>
                            </form>
                            
                            <!-- Edit Button -->
                            <button onclick='openEditModal(@json($meeting))' class="text-gray-400 hover:text-blue-500 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('assignments.toefl-itp.reading.destroy', $meeting) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-300 hover:text-red-500 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Icon -->
                    <div class="w-12 h-12 {{ $meeting->is_locked ? 'bg-gray-100 text-gray-400' : 'bg-blue-100 text-blue-600' }} rounded-2xl flex items-center justify-center mb-4 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-1 line-clamp-2" title="{{ $meeting->title }}">{{ $meeting->title }}</h3>
                    <p class="text-gray-500 text-sm mb-4">Reading Lesson</p>
                    
                    @if(!$meeting->is_locked || Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <a href="{{ route('assignments.toefl-itp.reading.meeting', $meeting->meeting_number) }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start Lesson</a>
                    @else
                        <button disabled class="block w-full py-2 bg-gray-100 text-gray-400 text-center rounded-xl font-bold cursor-not-allowed">Locked</button>
                    @endif
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <!-- Add Meeting Modal -->
    <div id="addMeetingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md mx-4">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Add New Lesson</h3>
            <form action="{{ route('assignments.toefl-itp.reading.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lesson Number</label>
                    <input type="number" name="meeting_number" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addMeetingModal').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Add Lesson</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit Meeting Modal -->
    <div id="editMeetingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md mx-4">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Lesson</h3>
            <form id="editMeetingForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lesson Number</label>
                    <input type="number" id="edit_meeting_number" name="meeting_number" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" id="edit_title" name="title" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editMeetingModal').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">Update Lesson</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SortableJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('meetings-grid'); // Select the grid container
            var sortable = Sortable.create(el, {
                animation: 150,
                ghostClass: 'bg-blue-50',
                handle: '.cursor-move',
                onEnd: function() {
                    let order = [];
                    document.querySelectorAll('.meeting-card').forEach(function(card) {
                        order.push(card.dataset.id);
                    });

                    fetch('{{ route("assignments.toefl-itp.reading.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ meetings: order })
                    });
                }
            });
        });

        function openEditModal(meeting) {
            const form = document.getElementById('editMeetingForm');
            // Use a placeholder ID '0' for the route helper, then replace it with the actual ID
            let updateUrl = "{{ route('assignments.toefl-itp.reading.update', 0) }}";
            form.action = updateUrl.replace('/0', '/' + meeting.id);
            
            document.getElementById('edit_meeting_number').value = meeting.meeting_number;
            document.getElementById('edit_title').value = meeting.title;
            
            document.getElementById('editMeetingModal').classList.remove('hidden');
        }
    </script>
</body>
</html>
