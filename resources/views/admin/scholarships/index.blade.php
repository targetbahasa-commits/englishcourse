@extends('layouts.admin')

@section('title', 'Scholarships')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Scholarship Management</h1>
            <p class="text-sm text-gray-500 mt-1">Manage and publish scholarship opportunities.</p>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Add button -->
            <a href="{{ route('admin.scholarships.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2 inline-flex items-center transition">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="ml-2 font-medium">Add Scholarship</span>
            </a>
        </div>

    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex justify-between items-center" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-600 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Scholarship</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Location</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Level</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Deadline</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($scholarships as $scholarship)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 shrink-0 mr-3 sm:mr-4 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden">
                                        @if($scholarship->image_path)
                                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $scholarship->image_path) }}" alt="{{ $scholarship->title }}">
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $scholarship->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $scholarship->provider }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $scholarship->location }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $scholarship->level_of_study }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $scholarship->deadline->format('d M Y') }}
                                @if($scholarship->deadline->isPast())
                                    <span class="block text-xs text-red-500 mt-1">Expired</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($scholarship->is_active)
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.scholarships.edit', $scholarship) }}" class="text-indigo-600 hover:text-indigo-900 mx-2 transition">Edit</a>
                                <form action="{{ route('admin.scholarships.destroy', $scholarship) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this scholarship?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <span class="text-gray-400">No scholarships found. Let's add one!</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($scholarships->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $scholarships->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
