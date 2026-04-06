@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 relative">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $main->title }}</h1>
                    <p class="text-gray-600 mt-1">Please select an exercise to begin practice</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.toefl-itp.structure') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Meetings
            </a>
        </div>
    </div>

    <!-- Selection Grid -->
    <div class="mb-8" x-data="{ 
        editModalOpen: false, 
        deleteModalOpen: false,
        selectedExercise: null,
        editTitle: '' 
    }">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Pilih Latihan</h2>
            
            @if(Auth::user()->isAdmin())
            <div class="flex items-center gap-2">
                <!-- Add Button -->
                <form action="{{ route('assignments.toefl-itp.structure.meeting.add-set', $main->meeting_number) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add
                    </button>
                </form>

                <!-- Edit Button (Trigger Modal) -->
                <button @click="editModalOpen = true" class="flex items-center gap-2 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit
                </button>

                <!-- Delete Button (Trigger Modal) -->
                <button @click="deleteModalOpen = true" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete
                </button>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($exercises as $index => $exercise)
                @php
                    // Determine link
                    // If it's the main meeting, use query param. 
                    // If it's a hidden meeting, use that meeting number.
                    $link = ($exercise->id == $main->id) 
                        ? route('assignments.toefl-itp.structure.meeting', $main->meeting_number) . '?exercise=1' 
                        : route('assignments.toefl-itp.structure.meeting', $exercise->meeting_number);
                    
                    $labelNumber = $index + 1;
                    
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
                                <h3 class="text-xl font-bold text-white">{{ $exercise->title }}</h3>
                            </div>
                            <svg class="w-6 h-6 text-white/70 group-hover:text-white group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <p class="{{ $color['text'] }} text-sm">Structure Practice Part {{ $labelNumber }}</p>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Edit Modal -->
        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" x-transition>
            <div class="bg-white rounded-2xl w-full max-w-lg p-6 max-h-[80vh] overflow-y-auto" @click.away="editModalOpen = false">
                <h3 class="text-xl font-bold mb-4">Edit Exercise Title</h3>
                <div class="space-y-4">
                    @foreach($exercises as $exercise)
                    <form action="{{ route('assignments.toefl-itp.structure.update', $exercise->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="meeting_number" value="{{ $exercise->meeting_number }}">
                        <input type="text" name="title" value="{{ $exercise->title }}" class="flex-1 rounded-lg border-gray-300">
                        <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
                    </form>
                    @endforeach
                </div>
                <button @click="editModalOpen = false" class="mt-4 w-full py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Close</button>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" x-transition>
            <div class="bg-white rounded-2xl w-full max-w-lg p-6" @click.away="deleteModalOpen = false">
                <h3 class="text-xl font-bold mb-4">Delete Exercise</h3>
                <div class="space-y-2">
                    @foreach($exercises as $index => $exercise)
                        @if($exercise->meeting_number != 6)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">{{ $exercise->title }}</span>
                            <form action="{{ route('assignments.toefl-itp.structure.meeting.remove-set', $main->meeting_number) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                <input type="hidden" name="target_number" value="{{ $exercise->meeting_number }}">
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Delete</button>
                            </form>
                        </div>
                        @else
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg opacity-50">
                            <span class="font-medium">{{ $exercise->title }} (Main)</span>
                            <span class="text-xs text-gray-500">Cannot Delete</span>
                        </div>
                        @endif
                    @endforeach
                </div>
                <button @click="deleteModalOpen = false" class="mt-4 w-full py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Close</button>
            </div>
        </div>

    </div>
</div>
@endsection
