@extends('layouts.admin')

@section('content')
@php
    $colorMap = [
        'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'border' => 'border-blue-100', 'bg_hover' => 'group-hover:bg-blue-50', 'text_hover' => 'group-hover:text-blue-700', 'icon_bg' => 'bg-blue-500'],
        'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'border' => 'border-green-100', 'bg_hover' => 'group-hover:bg-green-50', 'text_hover' => 'group-hover:text-green-700', 'icon_bg' => 'bg-green-500'],
        'indigo' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'border' => 'border-indigo-100', 'bg_hover' => 'group-hover:bg-indigo-50', 'text_hover' => 'group-hover:text-indigo-700', 'icon_bg' => 'bg-indigo-500'],
        'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'border' => 'border-orange-100', 'bg_hover' => 'group-hover:bg-orange-50', 'text_hover' => 'group-hover:text-orange-700', 'icon_bg' => 'bg-orange-500'],
        'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'border' => 'border-purple-100', 'bg_hover' => 'group-hover:bg-purple-50', 'text_hover' => 'group-hover:text-purple-700', 'icon_bg' => 'bg-purple-500'],
        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'border' => 'border-red-100', 'bg_hover' => 'group-hover:bg-red-50', 'text_hover' => 'group-hover:text-red-700', 'icon_bg' => 'bg-red-500'],
        'pink' => ['bg' => 'bg-pink-100', 'text' => 'text-pink-600', 'border' => 'border-pink-100', 'bg_hover' => 'group-hover:bg-pink-50', 'text_hover' => 'group-hover:text-pink-700', 'icon_bg' => 'bg-pink-500'],
        'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'border' => 'border-yellow-100', 'bg_hover' => 'group-hover:bg-yellow-50', 'text_hover' => 'group-hover:text-yellow-700', 'icon_bg' => 'bg-yellow-500'],
        'teal' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-600', 'border' => 'border-teal-100', 'bg_hover' => 'group-hover:bg-teal-50', 'text_hover' => 'group-hover:text-teal-700', 'icon_bg' => 'bg-teal-500'],
        'cyan' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-600', 'border' => 'border-cyan-100', 'bg_hover' => 'group-hover:bg-cyan-50', 'text_hover' => 'group-hover:text-cyan-700', 'icon_bg' => 'bg-cyan-500'],
        'emerald' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100', 'bg_hover' => 'group-hover:bg-emerald-50', 'text_hover' => 'group-hover:text-emerald-700', 'icon_bg' => 'bg-emerald-500'],
    ]; // Simplified map, can be expanded or shared
@endphp

<div class="w-full px-8 py-8">
    <!-- Header -->
    <div class="mb-12">
        <a href="{{ route('assignments.ielts-academic.speaking.index') }}" class="inline-flex items-center text-gray-500 hover:text-orange-600 transition-colors mb-6 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>
        
        <div class="flex items-center gap-4">
            <div class="p-4 bg-orange-100 text-orange-600 rounded-2xl">
                 <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $topic['icon'] }}"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $topic['title'] }}</h1>
                <p class="text-gray-500 mt-1">Select a topic to start practicing</p>
            </div>
        </div>
    </div>

    <!-- Topics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($topic['subtopics'] as $index => $subtopic)
        @php
            // Rotate colors specifically for subtopics if needed, or stick to nice defaults
            $colors = array_keys($colorMap);
            $colorKey = $colors[$index % count($colors)];
            $theme = $colorMap[$colorKey];
        @endphp
        
        <a href="{{ route('assignments.ielts-academic.speaking.practice', ['topic' => $topic['slug'], 'subtopic' => $subtopic['slug']]) }}" 
           class="group bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:border-{{ $colorKey }}-100 transition-all duration-300 relative overflow-hidden flex flex-col items-center text-center">
            
            <div class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 opacity-50 group-hover:opacity-0 transition-opacity"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-{{ $colorKey }}-50 to-white opacity-0 group-hover:opacity-100 transition-opacity"></div>
            
            <div class="relative z-10 w-16 h-16 rounded-2xl {{ $theme['bg'] }} {{ $theme['text'] }} flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                <span class="text-2xl font-bold">{{ $index + 1 }}</span>
            </div>
            
            <h3 class="relative z-10 text-xl font-bold text-gray-800 mb-2 group-hover:text-{{ $colorKey }}-700 transition-colors">
                {{ $subtopic['title'] }}
            </h3>
            
            <p class="relative z-10 text-gray-500 text-sm mb-6">
                {{ count($subtopic['questions']) }} Questions
            </p>
            
            <div class="relative z-10 mt-auto flex items-center text-{{ $colorKey }}-600 font-semibold group-hover:translate-x-1 transition-transform">
                Start Topic
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </div>
        </a>
        @endforeach
    </div>
</div>

@endsection
