@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{
    showModal: false,
    isEdit: false,
    form: {
        id: null,
        title: '',
        prompt: '',
        meeting_number: '',
        task_type: '{{ $task }}',
        category: 'practice_item',
        view_type: 'practice_view'
    },
    openCreate() {
        this.isEdit = false;
        this.form.id = null;
        this.form.title = '';
        this.form.prompt = '';
        this.form.meeting_number = '';
        this.showModal = true;
    },
    openEdit(item) {
        this.isEdit = true;
        this.form.id = item.id;
        this.form.title = item.title;
        this.form.prompt = item.prompt;
        this.form.meeting_number = item.meeting_number;
        this.showModal = true;
    },
    deleteItem(id) {
        if(confirm('Are you sure you want to delete this practice item?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
}">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $meeting->title }}</h1>
                    <p class="text-gray-600 mt-1">Select a topic to start practicing.</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                @if(Auth::check() && Auth::user()->role === 'admin')
                <button @click="openCreate()" class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Topic
                </button>
                @endif

                <a href="{{ $backUrl }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Practices
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Practice List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($practices as $practice)
            <div class="group relative overflow-hidden bg-white rounded-2xl shadow-md border border-gray-100 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex flex-col h-full">
                <!-- Card Background Decoration -->
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
                
                <!-- Main Content Link -->
                <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 2, 'id' => $practice->id]) }}" class="block p-6 flex-1 relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                <span class="font-bold text-sm">{{ $loop->iteration }}</span>
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-1 rounded">Practice</span>
                        </div>
                        
                        <!-- Admin Meeting Number Badge -->
                        @if(Auth::check() && Auth::user()->role === 'admin')
                        <span class="text-xs font-mono text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded" title="Meeting ID">#{{ $practice->meeting_number }}</span>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors line-clamp-2" title="{{ $practice->title }}">{{ $practice->title }}</h3>
                    
                    <div class="text-sm text-gray-500 line-clamp-3 mb-4">
                        {!! strip_tags($practice->prompt) !!}
                    </div>
                </a>
                
                <!-- Footer Action Area -->
                <div class="px-6 pb-6 pt-0 mt-auto relative z-20 flex items-center justify-between">
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 2, 'id' => $practice->id]) }}" class="flex items-center text-blue-600 font-semibold text-sm group-hover:translate-x-1 transition-transform">
                        <span>Start Writing</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <div class="flex items-center gap-2">
                         <button @click.prevent="openEdit({{ $practice }})" class="p-1.5 text-yellow-600 hover:bg-yellow-50 rounded transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <form id="delete-form-{{ $practice->id }}" action="{{ route('assignments.ielts.writing.destroy', $practice->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" @click.prevent="deleteItem({{ $practice->id }})" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach

        @if($practices->isEmpty())
            <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border border-gray-200 border-dashed">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <p class="text-gray-500 font-medium">No practice topics found for this section.</p>
                @if(Auth::check() && Auth::user()->role === 'admin')
                <button @click="openCreate()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Create First Topic
                </button>
                @endif
            </div>
        @endif
    </div>

    <!-- MODAL -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModal = false" x-transition.opacity></div>

        <!-- Modal Panel -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6" x-transition.scale>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800" x-text="isEdit ? 'Edit Topic' : 'Create New Topic'"></h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="isEdit ? '/assignments/ielts-academic/writing/' + form.id : '{{ route('assignments.ielts.writing.store') }}'" method="POST">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <input type="hidden" name="task_type" x-model="form.task_type">
                    <input type="hidden" name="category" x-model="form.category">
                    <input type="hidden" name="view_type" x-model="form.view_type">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" x-model="form.title" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., Prac 1: Topic Name" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Number (ID)</label>
                            <input type="number" name="meeting_number" x-model="form.meeting_number" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., 101" required>
                            <p class="mt-1 text-xs text-gray-500">Must be unique and within range (e.g., 101-105).</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prompt (HTML supported)</label>
                            <textarea name="prompt" x-model="form.prompt" rows="5" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 font-mono text-sm" placeholder="<div class='space-y-4'>...</div>" required></textarea>
                            <p class="mt-1 text-xs text-gray-500">Enter prompt text or HTML.</p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Save Topic</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
