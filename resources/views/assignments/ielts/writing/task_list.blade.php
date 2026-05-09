@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 {{ $task == 1 ? 'bg-teal-100 text-teal-600' : 'bg-orange-100 text-orange-600' }} rounded-2xl shadow-lg">
                    @if($task == 1)
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    @else
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    @endif
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">IELTS Writing Task {{ $task }}</h1>
                    <p class="text-gray-600 mt-1">{{ $task == 1 ? 'Describe Visual Information' : 'Essay Writing' }}</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic.writing.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Selection
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full {{ $task == 1 ? 'bg-teal-50 text-teal-700 border-teal-100' : 'bg-orange-50 text-orange-700 border-orange-100' }} font-semibold border text-xs">
                Active Batch: {{ $selectedClassPeriod->name ?? ($batchProgram->period ?? 'Not selected') }}
            </span>

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <form action="{{ route('assignments.batch-period') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $batchProgram?->id }}">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <select name="period" class="border-none bg-gray-50 rounded-lg text-sm focus:ring-2 {{ $task == 1 ? 'focus:ring-teal-500' : 'focus:ring-orange-500' }} min-w-[220px]" {{ !$batchProgram ? 'disabled' : '' }}>
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
                    <button type="submit" class="p-2 {{ $task == 1 ? 'bg-teal-600 hover:bg-teal-700' : 'bg-orange-600 hover:bg-orange-700' }} text-white rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed" title="Apply batch" {{ !$batchProgram ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            @else
                <div class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <span class="text-sm text-gray-800 px-2 py-1 bg-gray-50 rounded-lg">
                        {{ $selectedClassPeriod->name ?? ($batchProgram->period ?? 'Not selected') }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- Lessons Section -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="w-2 h-8 bg-{{ $task == 1 ? 'teal' : 'orange' }}-500 rounded-full mr-3"></span>
                Lessons
            </h2>
            @if(Auth::user()->isAdmin())
            <button onclick="openReorderModal()" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                Atur Urutan
            </button>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Add New Lesson Card (Admin Only) -->
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
            <button onclick="openCreateModal('lesson')" class="group flex flex-col items-center justify-center p-8 bg-white rounded-2xl border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-all duration-300 h-full min-h-[200px]">
                <div class="w-12 h-12 bg-blue-100 text-blue-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <span class="font-semibold text-gray-600 group-hover:text-blue-600">Add New Lesson</span>
            </button>
            @endif

            @foreach($lessons as $meeting)
                @include('assignments.ielts.writing.partials.meeting_card', ['meeting' => $meeting, 'task' => $task, 'type' => 'Lesson'])
            @endforeach
        </div>
    </div>


</div>

<!-- Create Modal -->
<div id="createMeetingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold mb-4">Add New <span id="modalType">Lesson</span> (Task {{ $task }})</h3>
        <form action="{{ route('assignments.ielts.writing.store') }}" method="POST">
            @csrf
            <input type="hidden" name="task_type" value="{{ $task }}">
            <input type="hidden" name="category" id="modalCategoryInput" value="lesson">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lesson Number</label>
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
                <button type="button" onclick="hideModal('createMeetingModal')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Lesson</button>
            </div>
        </form>
    </div>
</div>

<!-- Reorder Modal -->
@if(Auth::user()->isAdmin())
<div id="reorderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl flex flex-col max-h-[90vh]">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-800">Atur Urutan Lesson</h3>
            <button onclick="hideModal('reorderModal')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <p class="text-sm text-gray-500 px-6 pt-3">Seret item untuk mengubah urutan, lalu klik Simpan.</p>
        <ul id="sortableList" class="overflow-y-auto px-6 py-4 space-y-2 flex-1">
            @foreach($lessons as $lesson)
            <li class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 cursor-grab active:cursor-grabbing select-none"
                draggable="true"
                data-id="{{ $lesson->id }}"
                ondragstart="reorderDragStart(event)"
                ondragover="reorderDragOver(event)"
                ondrop="reorderDrop(event)"
                ondragend="reorderDragEnd(event)">
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span class="order-badge inline-flex items-center justify-center w-7 h-7 rounded-full bg-{{ $task == 1 ? 'teal' : 'orange' }}-100 text-{{ $task == 1 ? 'teal' : 'orange' }}-700 text-xs font-bold flex-shrink-0">{{ $lesson->meeting_number }}</span>
                <span class="text-sm font-medium text-gray-700 truncate">{{ $lesson->title }}</span>
            </li>
            @endforeach
        </ul>
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
            <button onclick="hideModal('reorderModal')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium transition">Batal</button>
            <button onclick="saveReorder()" id="saveReorderBtn" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition shadow-sm">Simpan Urutan</button>
        </div>
    </div>
</div>
@endif

<!-- Edit Modal -->
<div id="editMeetingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold mb-4">Edit Lesson</h3>
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
                <button type="button" onclick="hideModal('editMeetingModal')" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openCreateModal(type) {
        document.getElementById('modalType').innerText = type.charAt(0).toUpperCase() + type.slice(1);
        document.getElementById('modalCategoryInput').value = type;
        showModal('createMeetingModal');
    }

    function editMeeting(meeting) {
        document.getElementById('edit_title').value = meeting.title;
        document.getElementById('edit_prompt').value = meeting.prompt;
        
        let form = document.getElementById('editForm');
        form.action = "/assignments/ielts-academic/writing/" + meeting.id;
        
        showModal('editMeetingModal');
    }

    // --- Reorder (drag-and-drop) ---
    let reorderDragSrc = null;

    function openReorderModal() {
        // Reset badge numbers to current DOM order
        updateOrderBadges();
        showModal('reorderModal');
    }

    function reorderDragStart(e) {
        reorderDragSrc = e.currentTarget;
        e.dataTransfer.effectAllowed = 'move';
        e.currentTarget.classList.add('opacity-50', 'scale-95');
    }

    function reorderDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        const target = e.currentTarget;
        if (target !== reorderDragSrc) {
            target.classList.add('border-indigo-400', 'bg-indigo-50');
        }
    }

    function reorderDrop(e) {
        e.preventDefault();
        const target = e.currentTarget;
        target.classList.remove('border-indigo-400', 'bg-indigo-50');
        if (reorderDragSrc && target !== reorderDragSrc) {
            const list = document.getElementById('sortableList');
            const children = [...list.children];
            const srcIdx = children.indexOf(reorderDragSrc);
            const tgtIdx = children.indexOf(target);
            if (srcIdx < tgtIdx) {
                target.after(reorderDragSrc);
            } else {
                target.before(reorderDragSrc);
            }
            updateOrderBadges();
        }
    }

    function reorderDragEnd(e) {
        e.currentTarget.classList.remove('opacity-50', 'scale-95');
        document.querySelectorAll('#sortableList li').forEach(li => {
            li.classList.remove('border-indigo-400', 'bg-indigo-50');
        });
    }

    function updateOrderBadges() {
        document.querySelectorAll('#sortableList li').forEach((li, idx) => {
            const badge = li.querySelector('.order-badge');
            if (badge) badge.textContent = idx + 1;
        });
    }

    async function saveReorder() {
        const btn = document.getElementById('saveReorderBtn');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        const items = [...document.querySelectorAll('#sortableList li')].map((li, idx) => ({
            id: parseInt(li.dataset.id),
            meeting_number: idx + 1,
        }));

        try {
            const res = await fetch('{{ route('assignments.ielts.writing.reorder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        || '{{ csrf_token() }}',
                },
                body: JSON.stringify({ order: items }),
            });

            if (!res.ok) throw new Error('Server error');

            hideModal('reorderModal');
            window.location.reload();
        } catch (err) {
            alert('Gagal menyimpan urutan. Silakan coba lagi.');
            btn.disabled = false;
            btn.textContent = 'Simpan Urutan';
        }
    }
</script>
@endsection
