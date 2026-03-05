@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ activeTab: null }">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-lg">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent">IELTS Writing Practice</h1>
                    <p class="text-gray-600 mt-1">Focused exercises to improve your writing skills.</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg" x-show="activeTab === null">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to IELTS
            </a>
             <button @click="activeTab = null" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200" x-show="activeTab !== null" x-cloak>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Selection
            </button>
        </div>
    </div>

    <!-- Selection View -->
    <div x-show="activeTab === null" class="mb-8" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Select Practice Type</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Task 1 Card -->
            <div @click="activeTab = 1" class="cursor-pointer bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100 transform hover:scale-105 duration-300">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-4 py-1.5 bg-teal-100 text-teal-600 rounded-full text-sm font-bold uppercase tracking-wide">
                        Task 1
                    </span>
                </div>
                
                <div class="flex-1 mb-6 text-center">
                    <div class="w-20 h-20 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                        <span class="font-bold text-3xl">1</span>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Academic Report</h3>
                    <p class="text-gray-500 text-sm">Describe visual information (graphs, charts, maps).</p>
                </div>
                
                <button class="block w-full py-3 bg-teal-600 text-white text-center rounded-xl font-bold hover:bg-teal-700 transition shadow-sm hover:shadow active:scale-95">
                    View Practices
                </button>
            </div>

            <!-- Task 2 Card -->
             <div @click="activeTab = 2" class="cursor-pointer bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100 transform hover:scale-105 duration-300">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-4 py-1.5 bg-emerald-100 text-emerald-600 rounded-full text-sm font-bold uppercase tracking-wide">
                        Task 2
                    </span>
                </div>
                
                <div class="flex-1 mb-6 text-center">
                    <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <span class="font-bold text-3xl">2</span>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Essay Writing</h3>
                    <p class="text-gray-500 text-sm">Write a discursive essay in response to a prompt.</p>
                </div>
                
                <button class="block w-full py-3 bg-emerald-600 text-white text-center rounded-xl font-bold hover:bg-emerald-700 transition shadow-sm hover:shadow active:scale-95">
                    View Practices
                </button>
            </div>
        </div>
    </div>

    <!-- Task 1 List -->
    <div x-show="activeTab === 1" class="mb-12" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <span class="w-2 h-8 bg-teal-500 rounded-full mr-3"></span>
                    Task 1: Academic Report
                </h2>
                <p class="text-gray-600 mt-1 ml-5">Describe visual information (graphs, charts, maps).</p>
            </div>
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <button onclick="openCreateModal(1)" class="flex items-center gap-2 px-4 py-2 bg-teal-100 text-teal-700 hover:bg-teal-200 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Task 1 Practice
                </button>
            @endif
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($practicesTask1 as $meeting)
                @include('assignments.ielts.writing.partials.meeting_card', ['meeting' => $meeting, 'task' => 1, 'type' => 'Practice'])
            @endforeach
        </div>
    </div>

    <!-- Task 2 List -->
    <div x-show="activeTab === 2" class="mb-12" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <span class="w-2 h-8 bg-emerald-500 rounded-full mr-3"></span>
                    Task 2: Essay Writing
                </h2>
                <p class="text-gray-600 mt-1 ml-5">Write a discursive essay in response to a prompt.</p>
            </div>
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <button onclick="openCreateModal(2)" class="flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Task 2 Practice
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($practicesTask2 as $meeting)
                @include('assignments.ielts.writing.partials.meeting_card', ['meeting' => $meeting, 'task' => 2, 'type' => 'Practice'])
            @endforeach
        </div>
    </div>
</div>

<!-- Create Modal -->
<div id="createMeetingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold mb-4">Add New Practice (Task <span id="modalTaskTypeDisplay">1</span>)</h3>
        <form action="{{ route('assignments.ielts.writing.store') }}" method="POST">
            @csrf
            <input type="hidden" name="task_type" id="modalTaskTypeInput" value="1">
            <input type="hidden" name="category" value="practice">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Practice Number</label>
                    <input type="number" name="meeting_number" required class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" required class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prompt / Question</label>
                    <textarea name="prompt" rows="4" required class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('createMeetingModal').classList.add('hidden')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Practice</button>
            </div>
        </form>
    </div>
</div>


<!-- Edit Modal -->
<div id="editMeetingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold mb-4">Edit Practice</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" id="edit_title" name="title" required class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prompt / Question</label>
                    <textarea id="edit_prompt" name="prompt" rows="4" required class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('editMeetingModal').classList.add('hidden')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal(taskType) {
        document.getElementById('modalTaskTypeDisplay').innerText = taskType;
        document.getElementById('modalTaskTypeInput').value = taskType;
        document.getElementById('createMeetingModal').classList.remove('hidden');
    }
    
    function editMeeting(meeting) {
        document.getElementById('edit_title').value = meeting.title;
        document.getElementById('edit_prompt').value = meeting.prompt;
        
        let form = document.getElementById('editForm');
        form.action = "/assignments/ielts-academic/writing/" + meeting.id;
        
        document.getElementById('editMeetingModal').classList.remove('hidden');
    }
</script>
@endsection
