@extends('layouts.admin')

@section('title', 'Class Periods')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Class Periods') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">Manage student batches and control meeting access per class</p>
        </div>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-class-period')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Class Period
        </button>
    </div>

    <!-- Main Content -->
    <div>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Filters -->
        <form method="GET" action="{{ route('class-periods.index') }}" class="flex gap-4 mb-6">
                 <select name="program_id" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    <option value="">All Programs</option>
                    @foreach (\App\Models\Program::all() as $program)
                        <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
                <select name="status" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                @if($periods->isEmpty())
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                        <div class="bg-gray-50 p-4 rounded-full mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No class periods created yet</h3>
                        <p class="text-gray-500 mt-1 mb-6 max-w-sm">Create a class period to organize students into batches and manage their meeting access.</p>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-class-period')" class="text-blue-600 hover:text-blue-800 font-medium">
                            + Create your first class period
                        </button>
                    </div>
                @else
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Class Period Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Program</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date Range</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mode</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Students</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($periods as $period)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $period->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                           <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $period->program ? $period->program->name : 'All Programs' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $period->start_date ? $period->start_date->format('M d, Y') : 'TBD' }}</div>
                                            <div class="text-xs text-gray-500">to {{ $period->end_date ? $period->end_date->format('M d, Y') : 'TBD' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $period->learning_mode === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ ucfirst($period->learning_mode) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $period->users_count }}</div>
                                            <div class="text-xs text-gray-500">enrolled</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('class-periods.status', $period) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" 
                                                    class="text-xs font-semibold rounded-full border-0 py-1 pl-3 pr-8 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-xs sm:leading-6
                                                    {{ $period->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $period->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $period->status === 'closed' ? 'bg-gray-100 text-gray-600' : '' }}
                                                    ">
                                                    <option value="active" {{ $period->status === 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="upcoming" {{ $period->status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                                    <option value="closed" {{ $period->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('class-periods.show', $period) }}" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 rounded-md text-indigo-600 hover:bg-indigo-50 font-medium text-xs transition duration-150 ease-in-out">
                                                Manage
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
    </div>
</div>
@endsection

@section('modals')
    <!-- Modal for Create -->
    <x-modal name="create-class-period" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Create New Class Period</h2>
            
            <form method="POST" action="{{ route('class-periods.store') }}" class="space-y-4">
                @csrf
                
                <div>
                    <x-input-label for="program_id" value="Program" />
                     <select name="program_id" id="program_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        @foreach (\App\Models\Program::all() as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Select the curriculum program for this batch.</p>
                </div>

                <div>
                    <x-input-label for="name" value="Period Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="e.g. September 2024 Batch" required />
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="start_date" value="Start Date" />
                        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="end_date" value="End Date" />
                        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" />
                    </div>
                </div>
                
                 <div>
                    <x-input-label for="status" value="Status" />
                    <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="active" selected>Active</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                
                <div>
                    <x-input-label for="learning_mode" value="Learning Mode" />
                    <select name="learning_mode" id="learning_mode" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="online" selected>Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
                
                <div class="flex items-center mt-2">
                    <input id="auto_lock" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" disabled checked>
                    <label for="auto_lock" class="ml-2 block text-sm text-gray-500 opacity-75">
                        Auto-lock meetings after end date (Available in Pro)
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </button>

                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Create Period
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
@endsection
