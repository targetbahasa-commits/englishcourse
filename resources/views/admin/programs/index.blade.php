@extends('layouts.admin')

@section('title', 'Manage Programs')

@section('content')
<div class="p-6 md:p-8 space-y-8 pb-32">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold font-serif text-gray-900">Manage Programs</h1>
            <p class="text-gray-500 mt-1">Design course products, build syllabuses, and track active enrollments.</p>
        </div>
        <button 
            x-data
            @click="$dispatch('open-program-modal')"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Program
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
    
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Programs Master Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ searchQuery: '' }">
        
        <!-- Table Toolbar -->
        <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    x-model="searchQuery"
                    type="text" 
                    placeholder="Search program name or description..." 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors sm:text-sm"
                >
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                {{-- Placeholder for Future Filters if needed --}}
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs uppercase tracking-wider text-gray-400 font-semibold">
                        <th class="p-5 w-2/5">Program Details</th>
                        <th class="p-5">Duration / Meetings</th>
                        <th class="p-5">Active Enrollees</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($programs as $program)
                    <tr class="hover:bg-gray-50/50 transition-colors group" x-show="!searchQuery || '{{ strtolower(addslashes($program->name . ' ' . $program->description)) }}'.includes(searchQuery.toLowerCase())">
                        <td class="p-5">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold shadow-sm" style="background-color: {{ $program->color ?? '#3B82F6' }}; color: white;">
                                    @if($program->icon)
                                        <i class="bi bi-{{ $program->icon }} text-lg"></i>
                                    @else
                                        {{ substr($program->name, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $program->name }}
                                        @if($program->price && $program->price > 0)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                                IDR {{ number_format($program->price, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $program->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-medium text-gray-700">{{ $program->period ?? 'Flexible / Self-Paced' }}</span>
                            </div>
                            <div class="text-xs text-gray-400 mt-1 ml-6">{{ $program->meetings_count }} total meetings</div>
                        </td>
                        <td class="p-5">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-semibold border border-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                {{ $program->active_enrollees_count }}
                            </div>
                        </td>
                        <td class="p-5">
                            @if($program->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Draft
                                </span>
                            @endif
                        </td>
                        <td class="p-5">
                            <div class="flex justify-end items-center gap-2">
                                {{-- Manage Batches Button --}}
                                <button 
                                    type="button" 
                                    x-data 
                                    @click="$dispatch('open-batch-modal', { program: {{ Js::from($program) }} })"
                                    class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors border border-transparent hover:border-emerald-100" 
                                    title="Manage Class Batches"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </button>
                                
                                {{-- Build Syllabus --}}
                                <a href="{{ route('programs.syllabus', $program->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors border border-transparent hover:border-indigo-100" title="Build Syllabus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                </a>
                                
                                {{-- Edit Button --}}
                                <button 
                                    type="button" 
                                    x-data 
                                    @click="$dispatch('open-program-modal', { program: {{ Js::from($program) }} })"
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" 
                                    title="Edit Program Settings"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>

                                {{-- Dropdown for more actions (e.g. Delete) --}}
                                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                    <button @click="open = !open" type="button" class="p-2 text-gray-400 hover:text-gray-900 transition-colors rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                    
                                    <div x-show="open" 
                                         x-transition.opacity
                                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-10 py-1"
                                         style="display: none;">
                                        
                                        <form method="POST" action="{{ route('programs.destroy', $program->id) }}" onsubmit="return confirm('Archive/Delete this program forever?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Archive & Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-400 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">No Programs Found</h3>
                            <p class="text-gray-500 mb-6">You haven't created any course programs yet.</p>
                            <button 
                                x-data
                                @click="$dispatch('open-program-modal')"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create First Program
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Create / Edit Modal (Alpine Component) --}}
@endsection

@section('modals')
<div 
    x-data="{ 
        isOpen: false, 
        isEdit: false,
        form: {
            id: null,
            name: '',
            description: '',
            period: '',
            price: '',
            is_active: true
        }
    }"
    @open-program-modal.window="
        isOpen = true;
        if($event.detail && $event.detail.program) {
            isEdit = true;
            form.id = $event.detail.program.id;
            form.name = $event.detail.program.name;
            form.description = $event.detail.program.description;
            form.period = $event.detail.program.period;
            form.price = $event.detail.program.price;
            form.is_active = $event.detail.program.is_active == 1;
        } else {
            isEdit = false;
            form.id = null;
            form.name = '';
            form.description = '';
            form.period = '';
            form.price = '';
            form.is_active = true;
        }
    "
    x-show="isOpen" 
    class="fixed inset-0 z-50 overflow-y-auto" 
    style="display: none;"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div 
            x-show="isOpen" 
            x-transition.opacity 
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            @click="isOpen = false"
            aria-hidden="true"
        ></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div 
            x-show="isOpen" 
            x-transition.duration.300ms.scale.95
            class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full"
        >
            <div class="bg-white">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold font-serif text-gray-900" id="modal-title" x-text="isEdit ? 'Edit Program' : 'Create New Program'"></h3>
                        <p class="text-sm text-gray-500 mt-1" x-text="isEdit ? 'Update settings and details' : 'Deploy a new course product for students'"></p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>

                <!-- Form -->
                <form :action="isEdit ? '/admin/programs/' + form.id : '{{ route('programs.store') }}'" method="POST" class="px-6 py-5 space-y-6">
                    @csrf
                    <!-- Dynamic Method Injection for PUT requests -->
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Program Name <span class="text-red-500">*</span></label>
                        <input type="text" x-model="form.name" name="name" id="name" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., IELTS Intensive Masterclass">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="period" class="block text-sm font-semibold text-gray-700 mb-1">Duration Tag <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.period" name="period" id="period" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 3 Months, 20 Meetings">
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price (IDR) <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <input type="number" x-model="form.price" name="price" id="price" min="0" step="1" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 placeholder:text-gray-400" placeholder="e.g., 5000000">
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                        <textarea x-model="form.description" name="description" id="description" rows="3" required class="block w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 resize-none h-24 placeholder:text-gray-400" placeholder="Enter a brief summary of what this program covers and who it is for..."></textarea>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">Program Status</h4>
                            <p class="text-xs text-gray-500">Enable this to allow students to see and enroll in this program.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" class="sr-only peer" x-model="form.is_active">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700" x-text="form.is_active ? 'Active' : 'Draft'"></span>
                        </label>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 -mx-6 -mb-5 rounded-b-2xl">
                        <button type="button" @click="isOpen = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 border border-transparent text-white rounded-xl font-medium hover:bg-blue-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Manage Batches Modal (Alpine Component) --}}
<div 
    x-data="{ 
        isOpen: false, 
        program: null,
        form: {
            name: '',
            start_date: '',
            end_date: '',
            status: 'active',
            batch_type: 'regular'
        },
        initCalendar() {
            flatpickr(this.$refs.dateRange, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                minDate: 'today',
                onChange: (selectedDates, dateStr, instance) => {
                    if (selectedDates.length === 2) {
                        this.form.start_date = instance.formatDate(selectedDates[0], 'Y-m-d');
                        this.form.end_date = instance.formatDate(selectedDates[1], 'Y-m-d');
                    } else {
                        this.form.start_date = '';
                        this.form.end_date = '';
                    }
                }
            });
        }
    }"
    @open-batch-modal.window="
        isOpen = true;
        program = $event.detail.program;
        form = { name: '', start_date: '', end_date: '', status: 'active', batch_type: 'regular' };
        if($refs.dateRange && $refs.dateRange._flatpickr) {
            $refs.dateRange._flatpickr.clear();
        } else {
            $nextTick(() => { initCalendar(); });
        }
    "
    x-show="isOpen" 
    class="fixed inset-0 z-50 overflow-y-auto" 
    style="display: none;"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div 
            x-show="isOpen" 
            x-transition.opacity 
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            @click="isOpen = false"
            aria-hidden="true"
        ></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div 
            x-show="isOpen" 
            x-transition.duration.300ms.scale.95
            class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full"
        >
            <div class="bg-white">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h3 class="text-xl font-bold font-serif text-gray-900" x-text="'Batches: ' + (program ? program.name : '')"></h3>
                        <p class="text-sm text-gray-500 mt-1">Manage schedules or deploy a new timeline.</p>
                    </div>
                </div>
                
                <div class="px-6 py-5">
                    <!-- Current Batches List -->
                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">Existing Batches</h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="batch in program?.class_periods" :key="batch.id">
                                <div class="flex justify-between items-center p-3 bg-white border border-gray-200 rounded-xl hover:shadow-sm transition-shadow">
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                            <span x-text="batch.name"></span>
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded bg-purple-100 text-purple-700 border border-purple-200" x-show="batch.batch_type === 'private'">Private</span>
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded bg-gray-100 text-gray-700 border border-gray-200" x-show="batch.batch_type === 'regular'">Regular</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5 font-medium" x-text="batch.start_date.substring(0,10) + ' to ' + batch.end_date.substring(0,10)"></div>
                                    </div>
                                    <span class="px-2.5 py-1 text-[10px] uppercase tracking-wider font-bold rounded-md" 
                                        :class="{
                                            'bg-emerald-50 text-emerald-700 border border-emerald-200': batch.status === 'active',
                                            'bg-blue-50 text-blue-700 border border-blue-200': batch.status === 'upcoming',
                                            'bg-gray-100 text-gray-600 border border-gray-200': batch.status === 'closed'
                                        }" 
                                        x-text="batch.status"></span>
                                </div>
                            </template>
                            <template x-if="!program?.class_periods || program?.class_periods.length === 0">
                                <div class="text-sm text-gray-500 italic p-4 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                    No batches exist for this program yet.
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Create New Batch Form -->
                    <form action="{{ route('class-periods.store') }}" method="POST" class="border-t border-gray-100 pt-5 space-y-4">
                        @csrf
                        <input type="hidden" name="program_id" :value="program?.id">
                        
                        <h4 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">Deploy New Batch</h4>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Batch Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900" placeholder="e.g., September Intensive 2024">
                        </div>

                        <div>
                             <label class="block text-sm font-semibold text-gray-700 mb-1">Batch Type</label>
                             <select name="batch_type" x-model="form.batch_type" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-700">
                                 <option value="regular">Regular (Group Class)</option>
                                 <option value="private">Private Class</option>
                             </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Duration (Start & End) <span class="text-red-500">*</span></label>
                            <input x-ref="dateRange" type="text" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 cursor-pointer bg-white" placeholder="Select dates on Interactive Calendar" readonly>
                            <input type="hidden" name="start_date" x-model="form.start_date">
                            <input type="hidden" name="end_date" x-model="form.end_date">
                        </div>

                        <div>
                             <label class="block text-sm font-semibold text-gray-700 mb-1">Initial Status</label>
                             <select name="status" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 text-gray-700">
                                 <option value="upcoming">Upcoming (Pre-enrollment)</option>
                                 <option value="active" selected>Active (Ongoing)</option>
                             </select>
                        </div>

                        <!-- Buttons are pinned to bottom -->
                        <div class="mt-8 flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="isOpen = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors shadow-sm focus:outline-none">
                                Close
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-gray-900 border border-transparent text-white rounded-xl font-medium hover:bg-black transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Deploy Batch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
