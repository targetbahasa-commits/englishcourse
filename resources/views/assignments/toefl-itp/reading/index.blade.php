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
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

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
                    <p class="text-xs mt-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-semibold border border-blue-100">
                            Active Batch: {{ $selectedClassPeriod->name ?? ($batchProgram->period ?? 'Not selected') }}
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    @if(Auth::user()->isAdmin())
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

            <div class="mb-6">
                @if(Auth::user()->isAdmin())
                    <form action="{{ route('assignments.batch-period') }}" method="POST" class="inline-flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                        @csrf
                        <input type="hidden" name="program_id" value="{{ $batchProgram?->id }}">
                        <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                        <select name="period" class="border-none bg-gray-50 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 min-w-[220px]" {{ !$batchProgram ? 'disabled' : '' }}>
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
                        <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed" title="Apply batch" {{ !$batchProgram ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </form>
                @else
                    <div class="inline-flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                        <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                        <span class="text-sm text-gray-800 px-2 py-1 bg-gray-50 rounded-lg">
                            {{ $selectedClassPeriod->name ?? ($batchProgram->period ?? 'Not selected') }}
                        </span>
                    </div>
                @endif
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
                            @if(Auth::user()->isAdmin())
                            <div class="cursor-move text-gray-300 hover:text-gray-500 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                            </div>
                            @endif
                            
                            @if(Auth::user()->isAdmin())
                            <!-- Lock Toggle -->
                            <form action="{{ route('assignments.toefl-itp.reading.toggle-lock', $meeting) }}" method="POST">
                                @csrf
                                @if($selectedClassPeriod)
                                    <input type="hidden" name="class_period_id" value="{{ $selectedClassPeriod->id }}">
                                @endif
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center p-1.5 rounded-lg border transition {{ $meeting->is_locked ? 'bg-red-50 text-red-600 border-red-200 hover:bg-red-100 hover:text-red-700' : 'bg-emerald-50 text-emerald-600 border-emerald-200 hover:bg-emerald-100 hover:text-emerald-700' }}"
                                    title="{{ $meeting->is_locked ? 'Unlock' : 'Lock' }}"
                                >
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
                    
                    @if(!$meeting->is_locked)
                        <a href="{{ route('assignments.toefl-itp.reading.meeting', $meeting->meeting_number) }}" class="block w-full py-2 text-center rounded-xl font-bold transition bg-blue-600 text-white hover:bg-blue-700">Start Lesson</a>
                    @else
                        <button disabled class="block w-full py-2 bg-gray-300 text-gray-700 text-center rounded-xl font-bold cursor-not-allowed">Locked</button>
                    @endif
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <!-- Add Meeting Modal -->
    <div id="addMeetingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
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
    </div>
    <!-- Edit Meeting Modal -->
    <div id="editMeetingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="min-h-full grid place-items-center p-4">
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
