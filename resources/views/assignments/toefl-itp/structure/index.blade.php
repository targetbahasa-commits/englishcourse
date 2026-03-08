<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - TOEFL ITP Structure</title>
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
            @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
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
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm" placeholder="Search">
                </div>
                
                <div class="flex items-center gap-6">
                    <button class="relative p-2 bg-white rounded-full shadow-sm hover:bg-gray-50">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </button>
                    <button class="relative p-2 bg-white rounded-full shadow-sm hover:bg-gray-50">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    
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
                    <h2 class="text-2xl font-bold text-gray-800">TOEFL ITP Structure</h2>
                    <p class="text-gray-500 text-sm">Master your grammar structure and written expression.</p>
                </div>
                <div class="flex items-center gap-3">
                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                    <button onclick="document.getElementById('addMeetingModal').classList.remove('hidden')" class="px-4 py-2 bg-green-600 text-white rounded-xl shadow-sm hover:bg-green-700 font-medium transition flex items-center gap-2">
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
                @foreach($topics as $topic)
                <div class="topic-card bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative" data-id="{{ $topic->id }}">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 {{ $topic->is_locked ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} rounded-full text-xs font-bold">
                            {{ $topic->is_locked ? 'LOCKED' : 'OPEN' }}
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
                            <form action="{{ route('assignments.toefl-itp.structure.toggle-lock', $topic) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-gray-600 transition" title="{{ $topic->is_locked ? 'Unlock' : 'Lock' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($topic->is_locked)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                        @endif
                                    </svg>
                                </button>
                            </form>
                            
                            <!-- Edit Button -->
                            <button onclick='openEditModal(@json($topic))' class="text-gray-400 hover:text-blue-500 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('assignments.toefl-itp.structure.destroy', $topic) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
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
                    <div class="w-12 h-12 {{ $topic->is_locked ? 'bg-gray-100 text-gray-400' : 'bg-green-100 text-green-600' }} rounded-2xl flex items-center justify-center mb-4 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-1 line-clamp-2" title="{{ $topic->title }}">{{ $topic->title }}</h3>
                    <p class="text-gray-500 text-sm mb-4">Structure Exercise</p>
                    
                    @if(!$topic->is_locked || Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <a href="{{ route('assignments.toefl-itp.structure.meeting', $topic->meeting_number) }}" class="block w-full py-2 bg-green-600 text-white text-center rounded-xl font-bold hover:bg-green-700 transition">Start</a>
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
            <form action="{{ route('assignments.toefl-itp.structure.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lesson Number</label>
                    <input type="number" name="meeting_number" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addMeetingModal').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition">Add Lesson</button>
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
                    <input type="number" id="edit_meeting_number" name="meeting_number" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" id="edit_title" name="title" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500" required>
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
            var el = document.querySelector('.grid-cols-1'); // Select the grid container
            var sortable = Sortable.create(el, {
                animation: 150,
                ghostClass: 'bg-green-50',
                handle: '.cursor-move', // Add a handle or make whole card draggable
                onEnd: function() {
                    let order = [];
                    document.querySelectorAll('.topic-card').forEach(function(card) {
                        order.push(card.dataset.id);
                    });

                    fetch('{{ route("assignments.toefl-itp.structure.reorder") }}', {
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

        function openEditModal(topic) {
            const form = document.getElementById('editMeetingForm');
            // Use a placeholder ID '0' for the route helper, then replace it with the actual ID
            let updateUrl = "{{ route('assignments.toefl-itp.structure.update', 0) }}";
            form.action = updateUrl.replace('/0', '/' + topic.id);
            
            document.getElementById('edit_meeting_number').value = topic.meeting_number;
            document.getElementById('edit_title').value = topic.title;
            
            document.getElementById('editMeetingModal').classList.remove('hidden');
        }
    </script>
</body>
</html>
