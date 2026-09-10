@extends('layouts.admin')

@section('title', 'IELTS Listening Part 1')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ 
    showModal: false, 
    editingPart: null,
    formData: {
        id: null,
        title: '',
        meeting_number: '',
    },
    edit(part) {
        this.editingPart = part;
        this.formData = {
            id: part.id,
            title: part.title,
            meeting_number: part.meeting_number
        };
        this.showModal = true;
    },
    create() {
        this.editingPart = null;
        this.formData = {
            id: null,
            title: '',
            meeting_number: {{ $sections->count() + 1 }}
        };
        this.showModal = true;
    }
}">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">IELTS Listening Practice</h1>
                    <p class="text-gray-600 mt-1">Manage practice sections</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic.listening.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Index
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Content Grid --}}
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Course Content</h2>
            @if(false)
                <!-- Admin controls removed -->
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($sections as $section)
                @php
                    // Using Red theme with variations for IELTS
                    $colors = [
                        ['from' => 'from-red-500', 'to' => 'to-red-600'],
                        ['from' => 'from-orange-500', 'to' => 'to-orange-600'],
                        ['from' => 'from-rose-500', 'to' => 'to-rose-600'],
                        ['from' => 'from-pink-500', 'to' => 'to-pink-600'],
                    ];
                    // Cycle colors
                    $color = $colors[($section->section_number - 1) % count($colors)];
                    $isLocked = false; // Parts typically not locked if Practice is open, or handled by section
                @endphp

                <div class="relative group h-full">
                    {{-- Admin Controls --}}
                    {{-- Admin Controls Removed --}}

                    @if(!$isLocked)
                    <a href="{{ route('assignments.ielts-academic.listening.part1.practice', ['meeting' => $meeting->id, 'set' => $section->section_number]) }}" 
                       class="block h-full p-6 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden flex flex-col justify-between">
                        
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                    </svg>
                                </div>
                                <span class="bg-white/20 text-white text-xs font-bold px-2 py-1 rounded-lg backdrop-blur-sm border border-white/10">
                                    OPEN
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-white mb-1">Part {{ $section->section_number }}</h3>
                            <p class="text-white/80 text-sm leading-snug">{{ $section->title }}</p>
                        </div>
                        
                        <div class="mt-4 flex items-center gap-2 text-white/90 text-sm font-medium group-hover:text-white group-hover:gap-3 transition-all">
                            <span>Start Part {{ $section->section_number }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </a>
                    @else
                    <div class="block h-full p-6 bg-white rounded-2xl border border-gray-100 relative overflow-hidden flex flex-col justify-between opacity-75">
                         <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <span class="bg-white text-gray-400 text-xs font-bold px-2 py-1 rounded-lg border border-gray-200">LOCKED</span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-400 mb-1">Part {{ $section->section_number }}</h3>
                            <p class="text-gray-400/80 text-sm leading-snug">{{ $section->title }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Modal Removed -->
</div>
@endsection
