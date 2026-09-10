@extends('layouts.admin')

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto" x-data="{ 
    showAssignModal: false, 
    showProgramModal: false, 
    selectedUsers: [],
    selectAll: false,
    toggleAll() {
        if (this.selectAll) {
            this.selectedUsers = {{ $users->pluck('id') }};
        } else {
            this.selectedUsers = [];
        }
    }
}">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="p-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                <p class="text-gray-500 mt-1">Manage students, teachers, and guests across all programs.</p>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('users.create') }}" class="px-5 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters and Action Toolbar -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 flex flex-wrap gap-4 items-end justify-between">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap gap-4 items-end flex-1">
            <div class="w-full md:w-64">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search User</label>
                <div class="relative">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." class="pl-10 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Roles</option>
                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="guest" {{ request('role') == 'guest' ? 'selected' : '' }}>Guest</option>
                    <option value="test-taker" {{ request('role') == 'test-taker' ? 'selected' : '' }}>Test Taker</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="intern" {{ request('role') == 'intern' ? 'selected' : '' }}>Intern</option>
                </select>
            </div>

            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                <select name="program_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Programs</option>
                    @foreach(collect($programs)->groupBy('category') as $category => $categoryPrograms)
                        <optgroup label="{{ $category }}">
                            @foreach($categoryPrograms as $program)
                                <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-32">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors">
                Apply Filters
            </button>
        </form>

        <!-- Bulk Actions Menu -->
        <div class="relative" x-data="{ open: false }" x-show="selectedUsers.length > 0" x-cloak>
            <button @click="open = !open" class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors shadow-sm flex items-center gap-2">
                Bulk Actions (<span x-text="selectedUsers.length"></span>)
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 z-20 overflow-hidden transform transition-all origin-top-right">
                <div class="py-1">
                    <button @click="showAssignModal = true; open = false;" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 w-full text-left">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Assign to Teacher
                    </button>
                    <button @click="showProgramModal = true; open = false;" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 w-full text-left">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        Assign Program
                    </button>
                    <button @click="$refs.bulkActiveForm.submit(); open = false;" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 w-full text-left">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Set Active
                    </button>
                    <button @click="$refs.bulkInactiveForm.submit(); open = false;" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 w-full text-left">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                        Set Inactive
                    </button>
                </div>
            </div>
            
            <form x-ref="bulkActiveForm" action="{{ route('admin.users.bulk_update_status') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="user_ids" x-bind:value="JSON.stringify(selectedUsers)">
                <input type="hidden" name="status" value="active">
            </form>
            <form x-ref="bulkInactiveForm" action="{{ route('admin.users.bulk_update_status') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="user_ids" x-bind:value="JSON.stringify(selectedUsers)">
                <input type="hidden" name="status" value="inactive">
            </form>
        </div>
    </div>

    <!-- Master User Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="p-4 w-4">
                            <div class="flex items-center">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll" class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 font-semibold">User</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Contact</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Role</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Program & Teacher</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center">
                                <input type="checkbox" value="{{ $user->id }}" x-model="selectedUsers" class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($user->profile_photo)
                                    <img src="{{ asset($user->profile_photo) }}" alt="" class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-700 flex items-center justify-center font-bold text-lg border border-blue-200">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">Joined {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">{{ $user->email }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $user->phone_number ?? 'No phone added' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role == 'admin')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-purple-100 text-purple-700 border border-purple-200">Admin</span>
                            @elseif($user->role == 'teacher')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-700 border border-emerald-200">Teacher</span>
                            @elseif($user->role == 'student')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-blue-100 text-blue-700 border border-blue-200">Student</span>
                            @elseif($user->role == 'guest')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700 border border-gray-200">Guest</span>
                            @elseif($user->role == 'test-taker')
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-cyan-100 text-cyan-700 border border-cyan-200">Test Taker</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($user->program)
                                <div class="text-sm font-medium text-gray-800">{{ $user->program->name }}</div>
                            @else
                                <div class="text-sm text-gray-400 italic">No Program</div>
                            @endif

                            @if($user->classPeriod)
                                <div class="text-xs text-blue-600 font-medium flex items-center mt-1 gap-1">
                                    <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Batch: {{ $user->classPeriod->name }}
                                </div>
                            @endif
                            
                            @if($user->teacher)
                                <div class="text-xs text-gray-500 flex items-center mt-1 gap-1">
                                    <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                    {{ $user->teacher->name }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <!-- Toggle Status Component Placeholder -->
                            <button class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium {{ $user->status == 'active' ? 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100' : 'bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100' }} transition-colors" data-user-id="{{ $user->id }}" onclick="toggleStatus(this)">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->status == 'active' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                <span class="status-text">{{ ucfirst($user->status) }}</span>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 text-gray-400">
                                @if($user->role == 'guest')
                                <!-- Quick Convert Action -->
                                <button type="button" onclick="convertGuest({{ $user->id }})" class="p-1.5 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Convert to Student">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </button>
                                @endif

                                <a href="{{ route('users.edit', $user) }}" class="p-1.5 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline delete-form" onsubmit="return confirm('Delete user {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="mx-auto w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <p class="text-base font-medium text-gray-900">No users found</p>
                            <p class="text-sm mt-1">Try changing your filters or add a new user.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $users->links() }}
        </div>
    </div>
    
    <!-- Modals for Bulk Assignment -->
    <!-- Assign Teacher Modal -->
    <div x-show="showAssignModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showAssignModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showAssignModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('admin.users.bulk_assign_teacher') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_ids" x-bind:value="JSON.stringify(selectedUsers)">
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Assign Teacher</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Assign a teacher to the <span class="font-bold text-gray-900" x-text="selectedUsers.length"></span> selected students.</p>
                                    
                                    <div class="mt-4">
                                        <select name="teacher_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">-- Select Teacher --</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Assign
                        </button>
                        <button type="button" @click="showAssignModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Assign Program Modal -->
    <div x-show="showProgramModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showProgramModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showProgramModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('admin.users.bulk_assign_program') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_ids" x-bind:value="JSON.stringify(selectedUsers)">
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Assign Program</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Enroll <span class="font-bold text-gray-900" x-text="selectedUsers.length"></span> selected users into a program.</p>
                                    
                                    <div class="mt-4">
                                        <select name="program_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            <option value="">-- Select Program --</option>
                                            @foreach(collect($programs)->groupBy('category') as $category => $categoryPrograms)
                                                <optgroup label="{{ $category }}">
                                                    @foreach($categoryPrograms as $program)
                                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Enroll Users
                        </button>
                        <button type="button" @click="showProgramModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleStatus(btn) {
        const userId = btn.dataset.userId;
        const currentSpan = btn.querySelector('.w-1\\.5');
        const textSpan = btn.querySelector('.status-text');
        
        fetch(`/admin/users/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'active') {
                btn.className = 'flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 transition-colors';
                currentSpan.className = 'w-1.5 h-1.5 rounded-full bg-green-500';
                textSpan.innerText = 'Active';
            } else {
                btn.className = 'flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100 transition-colors';
                currentSpan.className = 'w-1.5 h-1.5 rounded-full bg-gray-400';
                textSpan.innerText = 'Inactive';
            }
        });
    }

    function convertGuest(userId) {
        if(confirm("Are you sure you want to convert this Guest to a Student?")) {
            fetch(`/admin/users/${userId}/convert`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.reload();
                }
            });
        }
    }
</script>
@endsection
