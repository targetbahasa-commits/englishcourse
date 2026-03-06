@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Part {{ $set }} Practice Tests</h1>
                    <p class="text-gray-600 mt-1">Select a test from the available list to practice your listening skills.</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic.listening.practice.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 font-medium rounded-lg transition-colors duration-200 border border-gray-200 shadow-sm hover:shadow-md hover:bg-gray-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Practices
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- 30 Tests Grid --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Available Tests (30)</h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-4">
            @for ($i = 1; $i <= 30; $i++)
                <a href="{{ route('assignments.ielts-academic.listening.part1.practice.test', ['meeting' => $meeting->id, 'set' => $set, 'test' => $i]) }}" 
                   class="group block p-4 bg-gray-50 border border-gray-200 rounded-2xl hover:bg-gradient-to-br hover:from-indigo-50 hover:to-purple-50 hover:border-indigo-300 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 text-center">
                    
                    <div class="w-12 h-12 mx-auto bg-white rounded-xl shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-indigo-600 transition-all duration-300">
                        <span class="text-xl font-bold text-gray-700 group-hover:text-white">{{ $i }}</span>
                    </div>
                    
                    <h3 class="font-bold text-gray-800 text-sm">Test {{ $i }}</h3>
                    <p class="text-xs text-gray-500 mt-1 uppercase font-semibold tracking-wider">Start</p>
                </a>
            @endfor
        </div>
    </div>
</div>
@endsection
