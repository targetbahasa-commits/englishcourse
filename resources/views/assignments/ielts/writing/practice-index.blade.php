@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ 
    selectedType: null,
    items: [],
    loading: false,
    async selectType(type) {
        this.selectedType = type;
        this.loading = true;
        try {
            const response = await fetch(`{{ route('assignments.ielts-academic.writing.practice.index') }}?type=${type}`, {
                headers: { 'Accept': 'application/json' }
            });
            // Since we're rendering server-side, we reload the page instead
            window.location.href = `{{ route('assignments.ielts-academic.writing.practice.index') }}?type=${type}`;
        } catch (error) {
            console.error('Error loading items:', error);
            this.loading = false;
        }
    }
}">

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent">IELTS Writing Practice</h1>
                    <p class="text-gray-600 mt-1">Focused exercises to improve your writing skills.</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg" x-show="!({{ count($items) > 0 ? 'true' : 'false' }})">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to IELTS
            </a>
            <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200" x-show="{{ count($items) > 0 ? 'true' : 'false' }}" x-cloak>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Selection
            </a>
        </div>
    </div>

    <!-- Main Selection Grid (7 Practice Types) -->
    <div x-show="!({{ count($items) > 0 ? 'true' : 'false' }})" class="mb-12" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Select Practice Type</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Line Chart Card -->
            <button @click="selectType('line')" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group relative flex flex-col h-full border border-blue-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <span class="text-4xl mb-4">📈</span>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Line Chart</h3>
                <p class="text-gray-500 text-sm flex-1">Analyze trends over time.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">20 Practices</span>
            </button>

            <!-- Bar Chart Card -->
            <button @click="selectType('bar')" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group relative flex flex-col h-full border border-emerald-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <span class="text-4xl mb-4">📊</span>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Bar Chart</h3>
                <p class="text-gray-500 text-sm flex-1">Compare categories.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-emerald-100 text-emerald-600 text-xs font-semibold rounded-full">20 Practices</span>
            </button>

            <!-- Pie Chart Card -->
            <button @click="selectType('pie')" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group relative flex flex-col h-full border border-purple-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <span class="text-4xl mb-4">🥧</span>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Pie Chart</h3>
                <p class="text-gray-500 text-sm flex-1">Understand proportions.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-purple-100 text-purple-600 text-xs font-semibold rounded-full">20 Practices</span>
            </button>

            <!-- Table Card -->
            <button @click="selectType('table')" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group relative flex flex-col h-full border border-orange-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <span class="text-4xl mb-4">📋</span>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Table</h3>
                <p class="text-gray-500 text-sm flex-1">Interpret tabular data.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full">20 Practices</span>
            </button>

            <!-- Mixed Chart Card -->
            <button @click="selectType('mixed')" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group relative flex flex-col h-full border border-pink-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <span class="text-4xl mb-4">📉</span>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Mixed Chart</h3>
                <p class="text-gray-500 text-sm flex-1">Combine chart types.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-pink-100 text-pink-600 text-xs font-semibold rounded-full">20 Practices</span>
            </button>

            <!-- Flowchart Card -->
            <button @click="selectType('flowchart')" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group relative flex flex-col h-full border border-indigo-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <span class="text-4xl mb-4">🔄</span>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Flowchart</h3>
                <p class="text-gray-500 text-sm flex-1">Describe processes.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-indigo-100 text-indigo-600 text-xs font-semibold rounded-full">20 Practices</span>
            </button>

            <!-- Mapping Diagram Card -->
            <button @click="selectType('mapping')" class="text-left p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition group relative flex flex-col h-full border border-rose-100 transform hover:scale-105 hover:-translate-y-1 duration-300">
                <span class="text-4xl mb-4">🗺️</span>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Mapping</h3>
                <p class="text-gray-500 text-sm flex-1">Analyze spatial changes.</p>
                <span class="mt-4 inline-block px-3 py-1 bg-rose-100 text-rose-600 text-xs font-semibold rounded-full">20 Practices</span>
            </button>
        </div>
    </div>

    <!-- Practice Items Display -->
    <div x-show="selectedType !== null || {{ count($items) > 0 ? 'true' : 'false' }}" class="mb-12" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
        @if(count($items) > 0)
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <span x-text="selectedType ? selectedType.charAt(0).toUpperCase() + selectedType.slice(1).replace(/([A-Z])/g, ' $1') : ''"></span> 
                @if(request('type'))
                    {{ ucfirst(request('type')) }}
                @endif
                Practice Items
            </h2>
            <span class="text-gray-600 font-medium">{{ count($items) }} available practices</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $item)
                <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => $item->id]) }}" class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 border-l-4 border-blue-500 hover:border-blue-600 group">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="font-bold text-gray-800 flex-1 group-hover:text-blue-600 transition">{{ $item->title }}</h3>
                        <span class="ml-2 text-2xl">📝</span>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $item->prompt }}</p>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500 font-medium">Meeting #{{ $item->meeting_number }}</span>
                        <span class="text-xs font-semibold text-blue-500 group-hover:text-blue-700 transition">Start Practice →</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
                    <p class="text-gray-600 mb-2">No practice items available for this type yet.</p>
                    <p class="text-sm text-gray-500">Check back soon for more content.</p>
                </div>
            @endforelse
        </div>
        @endif
    </div>

</div>

@endsection
