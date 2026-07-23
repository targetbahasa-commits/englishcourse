@extends('layouts.admin')

@section('title', $classPeriod->name . ' - Management')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('class-periods.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $classPeriod->name }} - Management
            </h2>
        </div>
        <div class="flex space-x-2">
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-class-period')" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">
                Edit Details
            </button>
                <form action="{{ route('class-periods.destroy', $classPeriod) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the class period and unassign all students.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div x-data="{ tab: 'overview' }">
        <div>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-t-lg border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button @click="tab = 'overview'" :class="{'border-indigo-500 text-indigo-600': tab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'overview'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Overview
                    </button>
                    <button @click="tab = 'students'" :class="{'border-indigo-500 text-indigo-600': tab === 'students', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'students'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Students ({{ $classPeriod->users->count() }})
                    </button>
                    <button @click="tab = 'meetings'" :class="{'border-indigo-500 text-indigo-600': tab === 'meetings', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'meetings'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Meetings
                    </button>
                    <button @click="tab = 'settings'" :class="{'border-indigo-500 text-indigo-600': tab === 'settings', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'settings'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Settings
                    </button>
                </nav>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-b-lg p-6">
                
                <!-- Tab: Overview -->
                <div x-show="tab === 'overview'">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Students</h3>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $classPeriod->users->count() }}</p>
                        </div>
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Program</h3>
                            <p class="mt-2 text-xl font-bold text-gray-900">{{ $classPeriod->program ? $classPeriod->program->name : 'N/A' }}</p>
                        </div>
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Status</h3>
                            <div class="mt-2 flex gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $classPeriod->status === 'active' ? 'green' : 'gray' }}-100 text-{{ $classPeriod->status === 'active' ? 'green' : 'gray' }}-800">
                                    {{ ucfirst($classPeriod->status) }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $classPeriod->learning_mode === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($classPeriod->learning_mode) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Duration</h3>
                                <p class="text-gray-600">
                                    <strong>Start Date:</strong> {{ $classPeriod->start_date ? $classPeriod->start_date->format('F d, Y') : 'Not Set' }}<br>
                                    <strong>End Date:</strong> {{ $classPeriod->end_date ? $classPeriod->end_date->format('F d, Y') : 'Not Set' }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Teacher</h3>
                                @if($classPeriod->teacher)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-base shrink-0">
                                            {{ strtoupper(substr($classPeriod->teacher->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $classPeriod->teacher->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $classPeriod->teacher->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-orange-600 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Belum ada teacher yang diassign. Edit class period untuk menambahkan.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Students -->
                <div x-show="tab === 'students'" style="display: none;">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Enrolled Students</h3>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-student')" class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500">
                            + Add Student
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($classPeriod->users as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('class-periods.remove-student', [$classPeriod, $student]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Remove this student from the class period?')">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($classPeriod->users->isEmpty())
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No students enrolled yet.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Meetings (CORE FEATURE) -->
                <div x-show="tab === 'meetings'" style="display: none;">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Meeting Access Control</h3>
                        <p class="text-sm text-gray-500">Toggle switch to OPEN/LOCK meetings for this class period.</p>
                    </div>
                    
                    @if($meetings->isEmpty())
                            <p class="text-gray-500 text-center py-4">No meetings found for this program.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($meetings as $meeting)
                                <div class="border rounded-lg p-4 flex items-center justify-between {{ $meeting->is_open_for_period ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                    <div>
                                        <h4 class="font-bold text-gray-800">Meeting {{ $meeting->meeting_number }}</h4>
                                        <p class="text-sm text-gray-600 truncate w-48" title="{{ $meeting->title }}">{{ $meeting->title }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="mr-2 text-xs font-bold {{ $meeting->is_open_for_period ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $meeting->is_open_for_period ? 'OPEN' : 'LOCKED' }}
                                        </span>
                                        
                                        <!-- Toggle Form -->
                                        <form action="{{ route('class-periods.toggle-meeting', [$classPeriod, $meeting]) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {{ $meeting->is_open_for_period ? 'bg-green-600' : 'bg-gray-200' }}" 
                                                role="switch" 
                                                aria-checked="{{ $meeting->is_open_for_period ? 'true' : 'false' }}">
                                                <span 
                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition duration-200 ease-in-out {{ $meeting->is_open_for_period ? 'translate-x-5' : 'translate-x-0' }}">
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab: Settings (Placeholder) -->
                <div x-show="tab === 'settings'" style="display: none;">
                    <p class="text-gray-500">Additional settings like auto-lock dates can be implemented here.</p>
                        
                        <div class="mt-6 border-t pt-6">
                            <h4 class="font-medium text-gray-900">Danger Zone</h4>
                            <div class="mt-2 text-sm text-gray-500">
                                Deleting this class period will remove the association for all students, but student accounts will remain active.
                            </div>
                        </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
    <!-- Edit Modal -->
    <x-modal name="edit-class-period" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Edit Class Period</h2>
            <form method="POST" action="{{ route('class-periods.update', $classPeriod) }}" class="mt-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="batch_type" value="{{ $classPeriod->batch_type }}">
                <div class="mb-4">
                    <x-input-label for="edit_name" value="Period Name" />
                    <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" value="{{ $classPeriod->name }}" required />
                </div>
                
                <div class="mb-4">
                    <x-input-label for="edit_program_id" value="Program" />
                    <select name="program_id" id="edit_program_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        @foreach (\App\Models\Program::all() as $program)
                            <option value="{{ $program->id }}" {{ $classPeriod->program_id == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="edit_start_date" value="Start Date" />
                        <x-text-input id="edit_start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ $classPeriod->start_date ? $classPeriod->start_date->format('Y-m-d') : '' }}" />
                    </div>
                    <div>
                        <x-input-label for="edit_end_date" value="End Date" />
                        <x-text-input id="edit_end_date" name="end_date" type="date" class="mt-1 block w-full" value="{{ $classPeriod->end_date ? $classPeriod->end_date->format('Y-m-d') : '' }}" />
                    </div>
                </div>
                
                 <div class="mb-4">
                    <x-input-label for="edit_status" value="Status" />
                    <select name="status" id="edit_status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="active" {{ $classPeriod->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="upcoming" {{ $classPeriod->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="closed" {{ $classPeriod->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <x-input-label for="edit_learning_mode" value="Learning Mode" />
                    <select name="learning_mode" id="edit_learning_mode" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="online" {{ $classPeriod->learning_mode == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ $classPeriod->learning_mode == 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_teacher_id" value="Teacher (Optional)" />
                    <select name="teacher_id" id="edit_teacher_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                        <option value="">— Unassigned —</option>
                        @foreach (\App\Models\User::where('role', 'teacher')->orderBy('name')->get() as $t)
                            <option value="{{ $t->id }}" {{ $classPeriod->teacher_id == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pengajar yang mengampu batch ini.</p>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        Save Changes
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
    
    <!-- Add Student Modal -->
    <x-modal name="add-student" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Add Student to {{ $classPeriod->name }}</h2>
            <form method="POST" action="{{ route('class-periods.assign-student', $classPeriod) }}" class="mt-6">
                @csrf
                <div class="mb-4">
                    <x-input-label for="user_id" value="Select Student" />
                    <!-- Ideally this would be a search with Alpine/AJAX, but simple select for now -->
                    <select name="user_id" id="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Select Student --</option>
                        @foreach ($allStudents as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }} ({{ $student->email }}) 
                                - Mode: {{ ucfirst($student->learning_mode) }}
                                {{ $student->class_period_id ? '- Already in ' . $student->classPeriod['name'] : '' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Students already in another class will be moved to this one.</p>
                </div>
                
                <div class="mt-6 flex justify-end">
                   <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        Add Student
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
@endsection
