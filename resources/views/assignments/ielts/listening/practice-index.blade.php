@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">IELTS Listening Practice</h1>
                    <p class="text-gray-600 mt-1">Focused exercises to improve your listening.</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to IELTS
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Full Practice Test 1</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $practiceParts = [
                    1 => ['meeting_id' => 146, 'set' => 1, 'title' => 'Part 1'],
                    2 => ['meeting_id' => 146, 'set' => 2, 'title' => 'Part 2'],
                    3 => ['meeting_id' => 129, 'set' => 1, 'title' => 'Part 3'],
                    4 => ['meeting_id' => 130, 'set' => 1, 'title' => 'Part 4'],
                ];
            @endphp

            @foreach($practiceParts as $partNum => $data)
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-4 py-1.5 bg-purple-100 text-purple-600 rounded-full text-sm font-bold uppercase tracking-wide">
                            PRACTICE
                        </span>
                    </div>
                    
                    <div class="flex-1 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-xl">{{ $partNum }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 leading-tight">{{ $data['title'] }}</h3>
                        </div>
                    </div>
                    
                    <a href="{{ route('assignments.ielts-academic.listening.practice-index.part', ['set' => $partNum]) }}" class="block w-full py-3 bg-purple-600 text-white text-center rounded-xl font-bold hover:bg-purple-700 transition shadow-sm hover:shadow active:scale-95">
                        Start Part
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
