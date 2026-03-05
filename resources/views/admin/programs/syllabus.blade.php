@extends('layouts.admin')

@section('title', 'Meeting Builder - ' . $program->name)

@section('content')
<div class="p-6 md:p-8 space-y-8 pb-32">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('programs.index') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Programs
                </a>
            </div>
            <h1 class="text-3xl font-bold font-serif text-gray-900">Curriculum Builder</h1>
            <p class="text-gray-500 mt-1">Manage meetings and syllabuses for <span class="font-semibold text-gray-700">{{ $program->name }}</span>.</p>
        </div>
        <button 
            x-data
            @click="$dispatch('open-meeting-modal')"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Meeting
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Syllabus Editor -->
    <div 
        x-data="syllabusBuilder()" 
        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
    >
        <div class="mb-6 flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-200">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 text-blue-700 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Meeting Order</h3>
                    <p class="text-sm text-gray-500">Drag and drop the cards below to reorder the syllabus.</p>
                </div>
            </div>
            <div x-show="isSaving" style="display: none;" class="text-sm text-blue-600 flex items-center gap-2 font-medium">
                <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Saving order...
            </div>
        </div>

        <div id="syllabus-list" class="space-y-3">
            @forelse($meetings as $meeting)
                <div data-id="{{ $meeting->id }}" class="group bg-white border border-gray-200 rounded-xl p-4 flex items-center justify-between hover:border-blue-300 hover:shadow-md transition-all cursor-move">
                    <div class="flex items-center gap-4">
                        <div class="text-gray-400 group-hover:text-blue-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-sm">
                            {{ $meeting->meeting_number }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-lg">{{ $meeting->title }}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                @if($meeting->is_locked)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Locked
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                        Unlocked
                                    </span>
                                @endif
                                <span class="text-xs text-gray-500">ID: {{ $meeting->id }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $assignmentRoute = '#';
                            $btnText = 'Manage Content';
                            $slug = \Illuminate\Support\Str::slug($program->slug ?? $program->name);

                            if (\Illuminate\Support\Str::contains($slug, 'ielts-academic-listening')) {
                                $assignmentRoute = route('assignments.ielts-academic.listening.index');
                                $btnText = 'Edit Assignment';
                            } elseif (\Illuminate\Support\Str::contains($slug, 'ielts-academic-reading')) {
                                $assignmentRoute = route('assignments.ielts-academic.reading.index');
                                $btnText = 'Edit Assignment';
                            } elseif (\Illuminate\Support\Str::contains($slug, 'ielts-academic-writing')) {
                                $assignmentRoute = route('assignments.ielts-academic.writing.index');
                                $btnText = 'Edit Assignment';
                            } elseif (\Illuminate\Support\Str::contains($slug, 'toefl-itp-listening')) {
                                $assignmentRoute = route('assignments.toefl-itp.listening.index');
                                $btnText = 'Edit Assignment';
                            } elseif (\Illuminate\Support\Str::contains($slug, 'toefl-itp-reading')) {
                                $assignmentRoute = route('assignments.toefl-itp.reading.index');
                                $btnText = 'Edit Assignment';
                            } elseif (\Illuminate\Support\Str::contains($slug, 'toefl-itp-structure')) {
                                $assignmentRoute = route('assignments.toefl-itp.structure.index');
                                $btnText = 'Edit Assignment';
                            }
                        @endphp
                        
                        <a href="{{ $assignmentRoute }}" class="px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            {{ $btnText }}
                        </a>

                        <button @click="$dispatch('open-meeting-modal', {{ json_encode($meeting) }})" class="p-2 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors cursor-pointer" title="Edit Meeting">
                            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        
                        <form action="{{ route('programs.syllabus.destroy', [$program, $meeting]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this meeting? This will irreversibly remove it from the syllabus.');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Delete Meeting">
                                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No meetings defined</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating the first meeting for this syllabus.</p>
                    <div class="mt-6">
                        <button @click="$dispatch('open-meeting-modal')" type="button" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Add Meeting
                        </button>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Meeting Add/Edit Modal using Alpine -->
<div 
    x-data="meetingModal()" 
    @open-meeting-modal.window="openModal($event.detail)"
    x-show="isOpen"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
    aria-labelledby="modal-title" role="dialog" aria-modal="true"
>
    <!-- Background backdrop -->
    <div x-show="isOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
         @click="closeModal()"></div>

    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <!-- Modal panel -->
        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            
            <form :action="formAction" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT" x-bind:disabled="!isEditing">

                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title" x-text="isEditing ? 'Edit Meeting' : 'Add New Meeting'"></h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Meeting Title</label>
                                    <input type="text" name="title" id="title" x-model="formData.title" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border" placeholder="e.g., Introduction to IELTS" required>
                                </div>
                                
                                <div class="flex items-center gap-2 mt-4">
                                    <input type="checkbox" name="is_locked" id="is_locked" value="1" x-model="formData.is_locked" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 h-4 w-4">
                                    <label for="is_locked" class="text-sm text-gray-700 font-medium">Locked (Students cannot access yet)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto" x-text="isEditing ? 'Update Meeting' : 'Add Meeting'"></button>
                    <button type="button" @click="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    function syllabusBuilder() {
        return {
            isSaving: false,
            init() {
                const el = document.getElementById('syllabus-list');
                if(el) {
                    Sortable.create(el, {
                        animation: 150,
                        ghostClass: 'bg-blue-50',
                        handle: '.cursor-move',
                        onEnd: (evt) => {
                            this.saveOrder();
                        }
                    });
                }
            },
            saveOrder() {
                this.isSaving = true;
                const items = document.querySelectorAll('#syllabus-list > div[data-id]');
                const newOrder = Array.from(items).map(item => item.getAttribute('data-id'));
                
                fetch("{{ route('programs.syllabus.reorder', $program->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ order: newOrder })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Update the UI meeting numbers sequentially
                        items.forEach((item, index) => {
                            const numBadge = item.querySelector('.bg-blue-50.text-blue-700.rounded-full');
                            if(numBadge) {
                                numBadge.textContent = index + 1;
                            }
                        });
                    }
                    setTimeout(() => { this.isSaving = false; }, 500);
                })
                .catch(error => {
                    console.error('Error saving order:', error);
                    alert("Failed to save reordered syllabus. Please reload the page.");
                    this.isSaving = false;
                });
            }
        }
    }

    function meetingModal() {
        return {
            isOpen: false,
            isEditing: false,
            formAction: "{{ route('programs.syllabus.store', $program->id) }}",
            formData: {
                id: null,
                title: '',
                is_locked: false
            },
            openModal(meeting = null) {
                if(meeting && meeting.id) {
                    this.isEditing = true;
                    this.formData = {
                        id: meeting.id,
                        title: meeting.title,
                        is_locked: meeting.is_locked == 1
                    };
                    this.formAction = "{{ url('admin/programs') }}/{{ $program->id }}/syllabus/" + meeting.id;
                } else {
                    this.isEditing = false;
                    this.formData = {
                        id: null,
                        title: '',
                        is_locked: false
                    };
                    this.formAction = "{{ route('programs.syllabus.store', $program->id) }}";
                }
                this.isOpen = true;
                setTimeout(() => document.getElementById('title').focus(), 100);
            },
            closeModal() {
                this.isOpen = false;
            }
        }
    }
</script>
@endpush
