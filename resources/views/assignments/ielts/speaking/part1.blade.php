@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
             <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl shadow-lg">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">IELTS Speaking Part 1</h1>
                    <p class="text-gray-600 mt-1">Introduction & Interview Practice</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic.speaking.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Selection
            </a>
        </div>
    </div>
            @php
            $colorMap = [
                'blue' => [
                    'bg_hover' => 'group-hover:bg-blue-50',
                    'border' => 'border-blue-100',
                    'border_hover' => 'group-hover:border-blue-300',
                    'shadow_hover' => 'group-hover:shadow-blue-200',
                    'icon_bg' => 'bg-blue-500',
                    'icon_ring' => 'ring-blue-200',
                    'text' => 'text-blue-600',
                    'badge_bg' => 'group-hover:bg-blue-100',
                    'badge_text' => 'group-hover:text-blue-700',
                    'blob' => 'bg-blue-500' 
                ],
                'green' => [
                    'bg_hover' => 'group-hover:bg-green-50',
                    'border' => 'border-green-100',
                    'border_hover' => 'group-hover:border-green-300',
                    'shadow_hover' => 'group-hover:shadow-green-200',
                    'icon_bg' => 'bg-green-500',
                    'icon_ring' => 'ring-green-200',
                    'text' => 'text-green-600',
                    'badge_bg' => 'group-hover:bg-green-100',
                    'badge_text' => 'group-hover:text-green-700',
                    'blob' => 'bg-green-500'
                ],
                'indigo' => [
                    'bg_hover' => 'group-hover:bg-indigo-50',
                    'border' => 'border-indigo-100',
                    'border_hover' => 'group-hover:border-indigo-300',
                    'shadow_hover' => 'group-hover:shadow-indigo-200',
                    'icon_bg' => 'bg-indigo-500',
                    'icon_ring' => 'ring-indigo-200',
                    'text' => 'text-indigo-600',
                    'badge_bg' => 'group-hover:bg-indigo-100',
                    'badge_text' => 'group-hover:text-indigo-700',
                    'blob' => 'bg-indigo-500'
                ],
                'orange' => [
                    'bg_hover' => 'group-hover:bg-orange-50',
                    'border' => 'border-orange-100',
                    'border_hover' => 'group-hover:border-orange-300',
                    'shadow_hover' => 'group-hover:shadow-orange-200',
                    'icon_bg' => 'bg-orange-500',
                    'icon_ring' => 'ring-orange-200',
                    'text' => 'text-orange-600',
                    'badge_bg' => 'group-hover:bg-orange-100',
                    'badge_text' => 'group-hover:text-orange-700',
                    'blob' => 'bg-orange-500'
                ],
                'purple' => [
                    'bg_hover' => 'group-hover:bg-purple-50',
                    'border' => 'border-purple-100',
                    'border_hover' => 'group-hover:border-purple-300',
                    'shadow_hover' => 'group-hover:shadow-purple-200',
                    'icon_bg' => 'bg-purple-500',
                    'icon_ring' => 'ring-purple-200',
                    'text' => 'text-purple-600',
                    'badge_bg' => 'group-hover:bg-purple-100',
                    'badge_text' => 'group-hover:text-purple-700',
                    'blob' => 'bg-purple-500'
                ],
                'red' => [
                    'bg_hover' => 'group-hover:bg-red-50',
                    'border' => 'border-red-100',
                    'border_hover' => 'group-hover:border-red-300',
                    'shadow_hover' => 'group-hover:shadow-red-200',
                    'icon_bg' => 'bg-red-500',
                    'icon_ring' => 'ring-red-200',
                    'text' => 'text-red-600',
                    'badge_bg' => 'group-hover:bg-red-100',
                    'badge_text' => 'group-hover:text-red-700',
                    'blob' => 'bg-red-500'
                ],
                'sky' => [
                    'bg_hover' => 'group-hover:bg-sky-50',
                    'border' => 'border-sky-100',
                    'border_hover' => 'group-hover:border-sky-300',
                    'shadow_hover' => 'group-hover:shadow-sky-200',
                    'icon_bg' => 'bg-sky-500',
                    'icon_ring' => 'ring-sky-200',
                    'text' => 'text-sky-600',
                    'badge_bg' => 'group-hover:bg-sky-100',
                    'badge_text' => 'group-hover:text-sky-700',
                    'blob' => 'bg-sky-500'
                ],
                'cyan' => [
                    'bg_hover' => 'group-hover:bg-cyan-50',
                    'border' => 'border-cyan-100',
                    'border_hover' => 'group-hover:border-cyan-300',
                    'shadow_hover' => 'group-hover:shadow-cyan-200',
                    'icon_bg' => 'bg-cyan-500',
                    'icon_ring' => 'ring-cyan-200',
                    'text' => 'text-cyan-600',
                    'badge_bg' => 'group-hover:bg-cyan-100',
                    'badge_text' => 'group-hover:text-cyan-700',
                    'blob' => 'bg-cyan-500'
                ],
                'pink' => [
                    'bg_hover' => 'group-hover:bg-pink-50',
                    'border' => 'border-pink-100',
                    'border_hover' => 'group-hover:border-pink-300',
                    'shadow_hover' => 'group-hover:shadow-pink-200',
                    'icon_bg' => 'bg-pink-500',
                    'icon_ring' => 'ring-pink-200',
                    'text' => 'text-pink-600',
                    'badge_bg' => 'group-hover:bg-pink-100',
                    'badge_text' => 'group-hover:text-pink-700',
                    'blob' => 'bg-pink-500'
                ],
                'teal' => [
                    'bg_hover' => 'group-hover:bg-teal-50',
                    'border' => 'border-teal-100',
                    'border_hover' => 'group-hover:border-teal-300',
                    'shadow_hover' => 'group-hover:shadow-teal-200',
                    'icon_bg' => 'bg-teal-500',
                    'icon_ring' => 'ring-teal-200',
                    'text' => 'text-teal-600',
                    'badge_bg' => 'group-hover:bg-teal-100',
                    'badge_text' => 'group-hover:text-teal-700',
                    'blob' => 'bg-teal-500'
                ],
                'emerald' => [
                    'bg_hover' => 'group-hover:bg-emerald-50',
                    'border' => 'border-emerald-100',
                    'border_hover' => 'group-hover:border-emerald-300',
                    'shadow_hover' => 'group-hover:shadow-emerald-200',
                    'icon_bg' => 'bg-emerald-500',
                    'icon_ring' => 'ring-emerald-200',
                    'text' => 'text-emerald-600',
                    'badge_bg' => 'group-hover:bg-emerald-100',
                    'badge_text' => 'group-hover:text-emerald-700',
                    'blob' => 'bg-emerald-500'
                ],
                'slate' => [
                    'bg_hover' => 'group-hover:bg-gray-50',
                    'border' => 'border-gray-100',
                    'border_hover' => 'group-hover:border-gray-400',
                    'shadow_hover' => 'group-hover:shadow-gray-200',
                    'icon_bg' => 'bg-gray-700',
                    'icon_ring' => 'ring-gray-300',
                    'text' => 'text-gray-700',
                    'badge_bg' => 'group-hover:bg-gray-200',
                    'badge_text' => 'group-hover:text-gray-800',
                    'blob' => 'bg-gray-400'
                ],
                'amber' => [
                    'bg_hover' => 'group-hover:bg-amber-50',
                    'border' => 'border-amber-100',
                    'border_hover' => 'group-hover:border-amber-300',
                    'shadow_hover' => 'group-hover:shadow-amber-200',
                    'icon_bg' => 'bg-amber-500',
                    'icon_ring' => 'ring-amber-200',
                    'text' => 'text-amber-600',
                    'badge_bg' => 'group-hover:bg-amber-100',
                    'badge_text' => 'group-hover:text-amber-700',
                    'blob' => 'bg-amber-500'
                ],
                'rose' => [
                    'bg_hover' => 'group-hover:bg-rose-50',
                    'border' => 'border-rose-100',
                    'border_hover' => 'group-hover:border-rose-300',
                    'shadow_hover' => 'group-hover:shadow-rose-200',
                    'icon_bg' => 'bg-rose-500',
                    'icon_ring' => 'ring-rose-200',
                    'text' => 'text-rose-600',
                    'badge_bg' => 'group-hover:bg-rose-100',
                    'badge_text' => 'group-hover:text-rose-700',
                    'blob' => 'bg-rose-500'
                ],
                'yellow' => [
                    'bg_hover' => 'group-hover:bg-yellow-50',
                    'border' => 'border-yellow-200',
                    'border_hover' => 'group-hover:border-yellow-400',
                    'shadow_hover' => 'group-hover:shadow-yellow-200',
                    'icon_bg' => 'bg-yellow-500',
                    'icon_ring' => 'ring-yellow-200',
                    'text' => 'text-yellow-700',
                    'badge_bg' => 'group-hover:bg-yellow-100',
                    'badge_text' => 'group-hover:text-yellow-800',
                    'blob' => 'bg-yellow-500'
                ],
                'gray' => [
                    'bg_hover' => 'group-hover:bg-gray-100',
                    'border' => 'border-gray-200',
                    'border_hover' => 'group-hover:border-gray-400',
                    'shadow_hover' => 'group-hover:shadow-gray-200',
                    'icon_bg' => 'bg-gray-800',
                    'icon_ring' => 'ring-gray-300',
                    'text' => 'text-gray-700',
                    'badge_bg' => 'group-hover:bg-gray-200',
                    'badge_text' => 'group-hover:text-gray-900',
                    'blob' => 'bg-gray-600'
                ],
                'violet' => [
                    'bg_hover' => 'group-hover:bg-violet-50',
                    'border' => 'border-violet-100',
                    'border_hover' => 'group-hover:border-violet-300',
                    'shadow_hover' => 'group-hover:shadow-violet-200',
                    'icon_bg' => 'bg-violet-500',
                    'icon_ring' => 'ring-violet-200',
                    'text' => 'text-violet-600',
                    'badge_bg' => 'group-hover:bg-violet-100',
                    'badge_text' => 'group-hover:text-violet-700',
                    'blob' => 'bg-violet-500'
                ],
                'lime' => [
                    'bg_hover' => 'group-hover:bg-lime-50',
                    'border' => 'border-lime-100',
                    'border_hover' => 'group-hover:border-lime-300',
                    'shadow_hover' => 'group-hover:shadow-lime-200',
                    'icon_bg' => 'bg-lime-500',
                    'icon_ring' => 'ring-lime-200',
                    'text' => 'text-lime-600',
                    'badge_bg' => 'group-hover:bg-lime-100',
                    'badge_text' => 'group-hover:text-lime-700',
                    'blob' => 'bg-lime-500'
                ],
                'fuchsia' => [
                    'bg_hover' => 'group-hover:bg-fuchsia-50',
                    'border' => 'border-fuchsia-100',
                    'border_hover' => 'group-hover:border-fuchsia-300',
                    'shadow_hover' => 'group-hover:shadow-fuchsia-200',
                    'icon_bg' => 'bg-fuchsia-500',
                    'icon_ring' => 'ring-fuchsia-200',
                    'text' => 'text-fuchsia-600',
                    'badge_bg' => 'group-hover:bg-fuchsia-100',
                    'badge_text' => 'group-hover:text-fuchsia-700',
                    'blob' => 'bg-fuchsia-500'
                ],
                'stone' => [
                    'bg_hover' => 'group-hover:bg-stone-50',
                    'border' => 'border-stone-100',
                    'border_hover' => 'group-hover:border-stone-300',
                    'shadow_hover' => 'group-hover:shadow-stone-200',
                    'icon_bg' => 'bg-stone-500',
                    'icon_ring' => 'ring-stone-200',
                    'text' => 'text-stone-600',
                    'badge_bg' => 'group-hover:bg-stone-100',
                    'badge_text' => 'group-hover:text-stone-700',
                    'blob' => 'bg-stone-500'
                ],
                'zinc' => [
                    'bg_hover' => 'group-hover:bg-zinc-50',
                    'border' => 'border-zinc-100',
                    'border_hover' => 'group-hover:border-zinc-300',
                    'shadow_hover' => 'group-hover:shadow-zinc-200',
                    'icon_bg' => 'bg-zinc-500',
                    'icon_ring' => 'ring-zinc-200',
                    'text' => 'text-zinc-600',
                    'badge_bg' => 'group-hover:bg-zinc-100',
                    'badge_text' => 'group-hover:text-zinc-700',
                    'blob' => 'bg-zinc-500'
                ],
            ];
            
            $lessons = collect($topics)->filter(function($t) { 
                return str_contains(strtolower($t['slug']), 'lesson'); 
            });
            
            // Current Part 1 content is lesson-based, so render all topics.
            $practices = collect($topics);
            @endphp




    <!-- Practice Section -->
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
            Speaking Practice
        </h2>
        
        <!-- Topics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">


            @foreach($practices as $topic)
            @php
                $theme = $colorMap[$topic['color']] ?? $colorMap['blue'];
            @endphp
            <a href="{{ route('assignments.ielts-academic.speaking.practice', ['topic' => $topic['slug']]) }}" 
               class="bg-white rounded-3xl p-6 cursor-pointer border {{ $theme['border'] }} {{ $theme['border_hover'] }} hover:shadow-lg {{ $theme['shadow_hover'] }} {{ $theme['bg_hover'] }} transition-all duration-300 group hover:-translate-y-1 relative overflow-hidden block">
                
                <!-- Decorative Blob -->
                <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full {{ $theme['blob'] }} opacity-5 group-hover:opacity-20 group-hover:scale-150 transition-all duration-500 blur-2xl"></div>

                <div class="relative z-10 flex items-start justify-between mb-4">
                    <!-- Icon Container -->
                    <div class="p-4 rounded-2xl {{ $theme['icon_bg'] }} text-white shadow-md ring-4 ring-white group-hover:ring-offset-2 {{ $theme['icon_ring'] }} transition-all duration-300 transform group-hover:rotate-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $topic['icon'] }}"></path>
                        </svg>
                    </div>
                    
                    <!-- Question Count Badge -->
                    <span class="px-3 py-1 rounded-full bg-gray-50 text-gray-500 border border-gray-100 text-xs font-bold {{ $theme['badge_bg'] }} {{ $theme['badge_text'] }} transition-colors">
                        {{ count($topic['questions'] ?? []) }} Qs
                    </span>
                </div>

                <h3 class="relative z-10 text-xl font-bold text-gray-800 mb-1 group-hover:text-gray-900 transition-colors">
                    {{ $topic['title'] }}
                </h3>
                
                <p class="text-sm {{ $theme['text'] }} font-medium opacity-60 group-hover:opacity-100 transition-opacity">
                    Start Practice &rarr;
                </p>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
