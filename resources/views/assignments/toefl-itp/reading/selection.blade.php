@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 relative">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $meeting->title }}</h1>
                    <p class="text-gray-600 mt-1">Select a passage to practice</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.toefl-itp.reading') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Meetings
            </a>
        </div>
    </div>

    <!-- Selection Grid -->
    <div class="mb-8" x-data="{ 
        addModalOpen: false,
        editModalOpen: false,
    }">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Passages</h2>
            
            @if(Auth::user()->isAdmin())
            <button @click="addModalOpen = true" class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Passage
            </button>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($passages as $index => $passage)
                @php
                    $link = route('assignments.toefl-itp.reading.meeting', $meeting->meeting_number) . '?passage_id=' . $passage->id;
                    $labelNumber = $passage->passage_number;
                    
                    $colors = [
                        ['from' => 'from-blue-500', 'to' => 'to-blue-600', 'text' => 'text-blue-50'],
                        ['from' => 'from-indigo-500', 'to' => 'to-indigo-600', 'text' => 'text-indigo-50'],
                        ['from' => 'from-purple-500', 'to' => 'to-purple-600', 'text' => 'text-purple-50'],
                    ];
                    $color = $colors[$index % count($colors)];
                @endphp

                <div class="relative group">
                    <a href="{{ $link }}" 
                       class="block p-6 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-xl">{{ $labelNumber }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-white">Passage {{ $passage->passage_number }}</h3>
                            </div>
                            <svg class="w-6 h-6 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <p class="{{ $color['text'] }} text-sm line-clamp-3">{{ Str::limit($passage->content, 100) }}</p>
                        <div class="mt-2 text-xs {{ $color['text'] }} opacity-75">
                            {{ $passage->questions_count ?? 0 }} Questions
                        </div>
                    </a>

                    <!-- Admin Controls - Always Visible -->
                    @if(Auth::user()->isAdmin())
                    <div class="absolute top-3 right-3 z-20 flex gap-2 transition-opacity">
                        <button onclick='event.preventDefault(); event.stopPropagation(); openEditPassageModal(@json($passage))' class="w-8 h-8 flex items-center justify-center bg-white text-blue-600 rounded-lg hover:bg-white shadow-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <form action="{{ route('assignments.toefl-itp.reading.passage.destroy', $passage->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Delete this passage and all its questions?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white text-red-600 rounded-lg hover:bg-red-50 shadow-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Add Passage Modal -->
        <div x-show="addModalOpen" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" x-transition>
            <div class="bg-white rounded-2xl w-full max-w-2xl p-6" @click.away="addModalOpen = false">
                <h3 class="text-xl font-bold mb-4">Add New Passage</h3>
                <form action="{{ route('assignments.toefl-itp.reading.passage.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Passage Number</label>
                        <input type="number" name="passage_number" class="w-full rounded-lg border-gray-300" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Passage Content</label>
                        <textarea name="content" rows="10" class="w-full rounded-lg border-gray-300" required></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Indonesian Translation (Optional)</label>
                        <textarea name="translation" rows="5" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Passage</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Passage Modal -->
        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" x-transition>
            <div class="bg-white rounded-2xl w-full max-w-2xl p-6" @click.away="editModalOpen = false">
                <h3 class="text-xl font-bold mb-4">Edit Passage</h3>
                <form id="editPassageForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Passage Number</label>
                        <input type="number" id="edit_passage_number" name="passage_number" class="w-full rounded-lg border-gray-300" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Passage Content</label>
                        <textarea id="edit_passage_content" name="content" rows="10" class="w-full rounded-lg border-gray-300" required></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Indonesian Translation (Optional)</label>
                        <textarea id="edit_passage_translation" name="translation" rows="5" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Passage</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function openEditPassageModal(passage) {
        const form = document.getElementById('editPassageForm');
        let updateUrl = "{{ route('assignments.toefl-itp.reading.passage.update', 0) }}";
        form.action = updateUrl.replace('/0', '/' + passage.id);
        
        document.getElementById('edit_passage_number').value = passage.passage_number;
        document.getElementById('edit_passage_content').value = passage.content;
        document.getElementById('edit_passage_translation').value = passage.translation || '';
        
        // Open modal using Alpine.js
        Alpine.store('editModalOpen', true);
        // Alternative approach - directly set the data
        const container = document.querySelector('[x-data]');
        if (container && container._x_dataStack) {
            container._x_dataStack[0].editModalOpen = true;
        }
    }
</script>
@endsection
