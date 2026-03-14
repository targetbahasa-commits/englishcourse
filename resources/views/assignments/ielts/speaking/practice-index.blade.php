@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-orange-500 to-yellow-600 rounded-2xl shadow-lg">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-yellow-600 bg-clip-text text-transparent">IELTS Speaking Practice</h1>
                    <p class="text-gray-600 mt-1">Focused exercises to improve your speaking fluency.</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to IELTS
            </a>
        </div>
    </div>

    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Practice Sections</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Part 1 Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-4 py-1.5 bg-orange-100 text-orange-600 rounded-full text-sm font-bold uppercase tracking-wide">
                        Part 1
                    </span>
                </div>
                
                <div class="flex-1 mb-6 text-center">
                    <div class="w-20 h-20 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <span class="font-bold text-3xl">1</span>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Introduction & Interview</h3>
                    <p class="text-gray-500 text-sm">Short questions about yourself and familiar topics.</p>
                </div>
                
                <a href="{{ route('assignments.ielts-academic.speaking.practice-index.part', ['part' => 1]) }}" class="block w-full py-3 bg-orange-600 text-white text-center rounded-xl font-bold hover:bg-orange-700 transition shadow-sm hover:shadow active:scale-95">
                    Start Practice
                </a>
            </div>

            <!-- Part 2 Card -->
             <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-4 py-1.5 bg-pink-100 text-pink-600 rounded-full text-sm font-bold uppercase tracking-wide">
                        Part 2
                    </span>
                </div>
                
                <div class="flex-1 mb-6 text-center">
                    <div class="w-20 h-20 bg-pink-50 text-pink-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-pink-600 group-hover:text-white transition-colors duration-300">
                        <span class="font-bold text-3xl">2</span>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Long Turn</h3>
                    <p class="text-gray-500 text-sm">Speak for 1-2 minutes on a given topic.</p>
                </div>
                
                <a href="{{ route('assignments.ielts-academic.speaking.practice-index.part', ['part' => 2]) }}" class="block w-full py-3 bg-pink-600 text-white text-center rounded-xl font-bold hover:bg-pink-700 transition shadow-sm hover:shadow active:scale-95">
                    Start Practice
                </a>
            </div>

            <!-- Part 3 Card -->
             <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative flex flex-col h-full border border-gray-100">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-4 py-1.5 bg-purple-100 text-purple-600 rounded-full text-sm font-bold uppercase tracking-wide">
                        Part 3
                    </span>
                </div>
                
                <div class="flex-1 mb-6 text-center">
                    <div class="w-20 h-20 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <span class="font-bold text-3xl">3</span>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Discussion</h3>
                    <p class="text-gray-500 text-sm">In-depth discussion related to the Part 2 topic.</p>
                </div>
                
                <a href="{{ route('assignments.ielts-academic.speaking.practice-index.part', ['part' => 3]) }}" class="block w-full py-3 bg-purple-600 text-white text-center rounded-xl font-bold hover:bg-purple-700 transition shadow-sm hover:shadow active:scale-95">
                    Start Practice
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
