<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - IELTS Listening Practice</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar', ['programSidebarAlwaysVisible' => true])

<div x-data="{ sidebarOpen: true }"
    @program-sidebar-change.window="sidebarOpen = !!($event.detail && $event.detail.open)"
    class="transition-all duration-300"
    :class="sidebarOpen ? 'lg:ml-72' : 'lg:ml-0'">
<div class="container mx-auto px-4 py-8 max-w-5xl transition-all duration-300"
    :class="sidebarOpen ? '' : 'max-w-7xl'">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg">
                    <span class="text-white font-bold text-xl">{{ $id }}</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $title }}</h1>
                    <p class="text-gray-600 mt-1">IELTS Listening Skill Building</p>
                </div>
            </div>
            
            @if(request()->has('practice'))
                <a href="{{ route('assignments.ielts-academic.listening.material', ['id' => $id]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Skills
                </a>
            @else
                <a href="{{ route('assignments.ielts-academic.listening.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Skills
                </a>
            @endif
        </div>
    </div>



    @if($id == 6 && !request()->has('practice'))
    <!-- Practice Selection Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Practice 1 Card (Enabled) -->
          <a href="{{ route('assignments.ielts-academic.listening.material', ['id' => 6, 'practice' => 1]) }}"
              class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-purple-400 transform hover:-translate-y-1">
                <div class="p-8 relative h-full flex flex-col">
                <!-- Badge -->
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 1
                    </span>
                </div>
                
                <!-- Icon -->
                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                
                <!-- Content -->
                <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">
                    Recycling Exercise
                </h3>
                <p class="text-gray-600 mb-6">
                    Complete form completion questions 1-10 about environmental protection and recycling programs.
                </p>
                
                <!-- Stats -->
                <div class="flex items-center gap-4 mb-6 text-sm text-gray-500">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>10 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>~15 mins</span>
                    </div>
                </div>
                
                <!-- Button -->
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-purple-600 font-semibold group-hover:text-purple-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>

        <!-- Practice 2 Card (Hotel Information) -->
        <a href="?practice=2" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-purple-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <!-- Badge -->
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 2
                    </span>
                </div>
                
                <!-- Icon -->
                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">Hotel Information</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Complete form completion questions 1-6 about hotel booking details and guest information.</p>
                </div>
                
                <!-- Stats -->
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>6 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>~10 mins</span>
                    </div>
                </div>
                
                <!-- Button -->
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-purple-600 font-semibold group-hover:text-purple-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>

        <!-- Practice 3 Card (Apartment for Rent) -->
        <a href="?practice=3" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-blue-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <!-- Badge -->
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 3
                    </span>
                </div>
                
                <!-- Icon -->
                <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Apartment for Rent</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Complete the form with details about an apartment rental including utilities and tenant info.</p>
                </div>
                
                <!-- Stats -->
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>5 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>~8 mins</span>
                    </div>
                </div>
                
                <!-- Button -->
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-blue-600 font-semibold group-hover:text-blue-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>

        <!-- Practice 4 Card (John Kepler's Memo) -->
        <a href="?practice=4" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-amber-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 4
                    </span>
                </div>

                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">John Kepler's Memo</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Complete memo notes questions 11-20 for the music examination preparation.</p>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>10 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>~12 mins</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <span class="text-amber-600 font-semibold group-hover:text-amber-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>

        <!-- Practice 5 Card (Restaurant Menu) -->
        <a href="?practice=5" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-teal-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-teal-500 to-cyan-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 5
                    </span>
                </div>

                <div class="w-16 h-16 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h10"></path>
                    </svg>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">Restaurant Menu</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Part A multiple choice and Part B form completion about menu choices.</p>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>6 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>~10 mins</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <span class="text-teal-600 font-semibold group-hover:text-teal-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>

        <!-- Practice 6 Card (Sentence Completion - Listening 1) -->
        <a href="?practice=6" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-indigo-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 6
                    </span>
                </div>

                <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Game Restrictions (Listening 1)</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Complete the sentence completion questions 1-6.</p>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>6 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>~8 mins</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <span class="text-indigo-600 font-semibold group-hover:text-indigo-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>

        <!-- Practice 7 Card (Sentence Completion - Listening 2) -->
        <a href="?practice=7" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-rose-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-rose-500 to-pink-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 7
                    </span>
                </div>

                <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-rose-600 transition-colors">TV Viewing Debate (Listening 2)</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Complete the sentence completion questions 7-12.</p>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>6 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>~8 mins</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <span class="text-rose-600 font-semibold group-hover:text-rose-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>

        <!-- Practice 8 Card (Sentence Completion - Listening 1) -->
        <a href="?practice=8" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 8
                    </span>
                </div>

                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Sarah's Diet Problem (Listening 1)</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Complete the sentence completion questions 1-7.</p>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>7 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>~9 mins</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <span class="text-emerald-600 font-semibold group-hover:text-emerald-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>

        <!-- Practice 9 Card (Sentence Completion - Listening 2) -->
        <a href="?practice=9" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-amber-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                        Practice 9
                    </span>
                </div>

                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Tina's Weight Gain (Listening 2)</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Complete the sentence completion questions 8-13.</p>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>6 Questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>~8 mins</span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-auto">
                    <span class="text-amber-600 font-semibold group-hover:text-amber-700 flex items-center gap-2">
                        Start Practice
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    </div>
    @elseif($id == 6 && request()->has('practice'))
    @if(request()->get('practice') == 1 || request()->get('practice') == 4)
    <!-- Practice 1 Content -->
    <div class="space-y-8">
        @if(request()->get('practice') == 1)
        <!-- Question Block -->
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-indigo-500 p-8 relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <!-- Header Section -->
            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Sample Question 1</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Protecting Environment through Recycling Listening Answers</h3>
            </div>

            <!-- Instructions -->
            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the form below. Write <span class="font-bold">NO MORE THAN THREE WORDS AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <!-- Form Table -->
            <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-5 font-semibold w-1/2 rounded-tl-xl text-sm uppercase tracking-wider">Example</th>
                            <th class="p-5 font-semibold w-1/2 rounded-tr-xl text-sm uppercase tracking-wider">Answer</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Example Row -->
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="p-3 text-gray-800 text-lg font-medium">Type of group:</td>
                            <td class="p-3 text-gray-900 text-lg font-bold">non-profit</td>
                        </tr>
                        <!-- Q1 -->
                        <tr class="group hover:bg-indigo-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-lg font-medium">Frequency of newspaper collection:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">1</span>
                                    <input type="text" name="q1" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                        <!-- Q2 -->
                        <tr class="group hover:bg-indigo-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-lg font-medium">Name:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">2</span>
                                    <input type="text" name="q2" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                        <!-- Q3 -->
                        <tr class="group hover:bg-indigo-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-lg font-medium">Address:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">3</span>
                                    <input type="text" name="q3" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                        <!-- Q4 -->
                        <tr class="group hover:bg-indigo-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-lg font-medium">E-mail:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">4</span>
                                    <input type="text" name="q4" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                        <!-- Q5 -->
                        <tr class="group hover:bg-indigo-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-lg font-medium">Postcode:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">5</span>
                                    <input type="text" name="q5" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Bottom Spacer for Audio Player -->
            <div class="h-8"></div>

            <!-- Question Block 2 -->
            <div class="bg-white rounded-3xl shadow-xl border-t-4 border-emerald-500 p-8 relative overflow-hidden">
                <!-- Decorative Background Element -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                <!-- Header Section -->
                <div class="relative z-10 mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider">Questions 6-10</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 leading-tight">Recycling</h3>
                </div>

                <!-- Instructions -->
                <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                        <p class="text-amber-700 text-sm">Complete the form below. Write <span class="font-bold">NO MORE THAN TWO WORDS</span> for each answer.</p>
                    </div>
                </div>

                <!-- Form Table -->
                <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <tbody class="divide-y divide-gray-100">
                            <!-- Q6 -->
                            <tr class="group hover:bg-emerald-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium w-1/2 align-top">Ways of recycling</td>
                                <td class="p-3 w-1/2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-gray-900 text-lg">Newspaper: in a</span>
                                        <div class="flex items-center gap-2">
                                             <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">6</span>
                                             <input type="text" name="q6" class="min-w-[120px] bg-transparent border-b-2 border-gray-300 focus:border-emerald-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Answer...">
                                        </div>
                                        <span class="text-gray-900 text-lg">box</span>
                                    </div>
                                </td>
                            </tr>
                            <!-- Q7 -->
                            <tr class="group hover:bg-emerald-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium align-top">Nearest rubbish collection centre</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-gray-900 text-lg">On the East Side of</span>
                                        <div class="flex items-center gap-2">
                                             <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">7</span>
                                             <input type="text" name="q7" class="min-w-[150px] bg-transparent border-b-2 border-gray-300 focus:border-emerald-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Answer...">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- Q8 -->
                            <tr class="group hover:bg-emerald-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium align-top">Rubbish that can be recycled</td>
                                <td class="p-3">
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-gray-900 text-lg">Blue box:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">8</span>
                                                <input type="text" name="q8" class="min-w-[120px] bg-transparent border-b-2 border-gray-300 focus:border-emerald-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Answer...">
                                            </div>
                                        </div>
                                        <div class="text-gray-900 text-lg pl-8 relative">
                                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full absolute left-3 top-3"></span>
                                            Green box: glass and plastics
                                        </div>
                                        <div class="text-gray-900 text-lg pl-8 relative">
                                             <span class="w-1.5 h-1.5 bg-gray-300 rounded-full absolute left-3 top-3"></span>
                                            Yellow box: paper
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- Q9 -->
                            <tr class="group hover:bg-emerald-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium align-top">Rubbish that cannot be recycled</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">9</span>
                                        <input type="text" name="q9" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-emerald-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Your answer...">
                                    </div>
                                </td>
                            </tr>
                            <!-- Q10 -->
                            <tr class="group hover:bg-emerald-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium align-top">Name of a booklet</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">10</span>
                                        <input type="text" name="q10" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-emerald-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Your answer...">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(request()->get('practice') == 4)
            <!-- Question Block 3 -->
            <div class="mt-8 bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-amber-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

                <div class="relative z-10 mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">Questions 11-20</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 leading-tight">John Kepler's Memo</h3>
                </div>

                <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                        <p class="text-amber-700 text-sm">Complete the memo. Write <span class="font-bold">NO MORE THAN THREE WORDS AND/OR A NUMBER</span> for each answer.</p>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <tbody class="divide-y divide-gray-100">
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium w-1/2">Exam at</td>
                                <td class="p-3 w-1/2">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">11</span>
                                        <input type="text" name="q11" class="flex-1 min-w-[180px] bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Answer...">
                                        <span class="text-gray-900 text-lg">Primary School</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium">Arrive at the school by</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">12</span>
                                        <input type="text" name="q12" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Answer...">
                                    </div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium">Tuning: four strings C, G,</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">13</span>
                                        <input type="text" name="q13" class="w-36 bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="...">
                                        <span class="text-gray-900 text-lg">, A</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium">Take: a spare bow / a cleaning cloth / a</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">14</span>
                                        <input type="text" name="q14" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Answer...">
                                    </div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium">Also, take own music</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">15</span>
                                        <input type="text" name="q15" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Answer...">
                                    </div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium align-top">Order of three-part exam</td>
                                <td class="p-3 space-y-3">
                                    <div class="text-gray-900 text-lg">First part: sight-reading</div>
                                    <div class="flex items-center gap-2 flex-wrap text-gray-900 text-lg">
                                        <span>Second part:</span>
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">16</span>
                                        <input type="text" name="q16" class="min-w-[180px] bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 placeholder-gray-300" placeholder="Answer...">
                                        <span>prepared pieces of music</span>
                                    </div>
                                    <div class="text-gray-900 text-lg">Third part: <span class="inline-block align-middle ml-2 w-40 border-b-2 border-gray-300"></span></div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium">Marking of first and third parts is out of</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">17</span>
                                        <input type="text" name="q17" class="w-40 bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="...">
                                        <span class="text-gray-900 text-lg">%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium">Examiner looking for</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3 flex-wrap text-gray-900 text-lg">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">18</span>
                                        <input type="text" name="q18" class="w-44 bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 placeholder-gray-300" placeholder="...">
                                        <span>and fluency</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium">Results made available on the Woodlands</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3 flex-wrap text-gray-900 text-lg">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">19</span>
                                        <input type="text" name="q19" class="w-44 bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 placeholder-gray-300" placeholder="...">
                                        <span>and through the mail</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-gray-800 text-lg font-medium">Aim for 2009: Grade</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">20</span>
                                        <input type="text" name="q20" class="w-40 bg-transparent border-b-2 border-gray-300 focus:border-amber-500 outline-none px-2 py-1 transition-colors text-gray-900 text-lg placeholder-gray-300" placeholder="Answer...">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            <!-- Bottom Spacer for Audio Player -->
            <div class="h-24"></div>
        </div>
        
        <!-- Fixed Bottom Audio Player -->
        <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-indigo-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] px-4 py-3 transform transition-transform duration-300" x-data="{ playing: false, time: '0:00', duration: '0:00', audio: null, progress: 0 }">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-4">
                <!-- Icon & Title -->
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white shadow-md flex-shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-indigo-900 line-clamp-1 hidden sm:inline">Audio Session - Practice {{ request()->get('practice') }}</span>
                </div>

                <!-- Controls -->
                <div class="flex-1 flex items-center gap-3 w-full justify-center md:justify-center">
                    <!-- Key (Dummy) -->
                    <button class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200 hidden sm:block">
                        Key
                    </button>

                    <!-- Skip Back -->
                    <button type="button" onclick="skipAudio(-10)" class="p-2 bg-indigo-50 hover:bg-indigo-100 rounded-lg text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path></svg>
                    </button>

                    <!-- Play/Pause -->
                    <button type="button" id="playPauseBtn" onclick="togglePlayPause()" class="w-10 h-10 bg-indigo-600 hover:bg-indigo-700 rounded-xl flex items-center justify-center text-white transition-colors shadow-lg hover:shadow-indigo-200 transform hover:scale-105 active:scale-95">
                        <svg id="playIcon" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <svg id="pauseIcon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>
                    </button>

                    <!-- Progress -->
                    <div class="flex-1 flex flex-col min-w-[200px] max-w-lg">
                        <div class="flex justify-between text-[10px] text-indigo-600 font-bold mb-1">
                            <span id="currentTime">0:00</span>
                            <span id="duration">0:00</span>
                        </div>
                        <div class="relative h-2 bg-indigo-100 rounded-full cursor-pointer group" id="progressContainer">
                            <div id="progressBar" class="absolute h-full bg-indigo-600 rounded-full" style="width: 0%"></div>
                            <div id="progressHandle" class="absolute top-1/2 -translate-y-1/2 -ml-2 w-4 h-4 bg-white border-2 border-indigo-600 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%"></div>
                        </div>
                    </div>

                    <!-- Skip Forward -->
                    <button type="button" onclick="skipAudio(10)" class="p-2 bg-indigo-50 hover:bg-indigo-100 rounded-lg text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path></svg>
                    </button>
                    
                    <!-- Terjemah -->
                    <button type="button" onclick="toggleTranscriptDrawer()" 
                            class="p-2 bg-yellow-400 border-2 border-yellow-500 hover:bg-yellow-500 rounded-lg transition-colors flex-shrink-0 flex items-center gap-2 group shadow-sm" title="Lihat/Tutup Transkrip">
                        <svg class="w-5 h-5 text-black group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-xs font-bold text-black hidden sm:inline">Terjemah</span>
                    </button>
                    
                    @if(Auth::user()->isAdmin())
                       <!-- Upload Buttons (Admin Only) -->
                       <div class="flex items-center gap-2">
                           <button onclick="const modal=document.getElementById('uploadSrtModal'); modal.classList.remove('hidden'); modal.classList.add('flex');" class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload SRT">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Upload SRT
                            </button>
                           <button onclick="const modal=document.getElementById('uploadAudioModal'); modal.classList.remove('hidden'); modal.classList.add('flex');" class="px-3 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload Audio">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                Upload Audio
                            </button>
                       </div>
                    @endif
                </div>

                <audio id="mainAudio" class="hidden">
                    @if(isset($material) && $material->audio_file)
                        <source src="{{ asset($material->audio_file) }}" type="audio/mpeg">
                    @else
                        <source src="" type="audio/mpeg">
                    @endif
                </audio>
            </div>
        </div>
        
        {{-- Transcript Drawer (Collapsible) --}}
        <div id="transcriptDrawer" class="hidden border border-gray-300 rounded-lg mx-4 mb-4 bg-white h-80 overflow-hidden flex-col transition-all duration-300 ease-in-out shadow-md">
            <div class="flex-1 overflow-hidden grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                {{-- English Column --}}
                <div class="flex flex-col h-full bg-slate-50">
                    <div class="flex-none px-4 py-2 bg-slate-100 border-b border-slate-200 font-semibold text-slate-700 flex items-center justify-between z-10">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/w20/us.png" alt="US" class="rounded-sm"> English Script
                        </div>
                    </div>
                    <div class="flex-1 relative overflow-hidden">
                        <div class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-slate-600 custom-scrollbar pr-2">
                            @if(isset($material) && $material->transcript_en)
                                @php
                                    $transcriptEn = $material->transcript_en;
                                    $jsonEn = json_decode($transcriptEn, true);
                                    $isJsonEn = (json_last_error() === JSON_ERROR_NONE && is_array($jsonEn));
                                @endphp
                                @if($isJsonEn)
                                    <div class="space-y-2">
                                        @foreach($jsonEn as $block)
                                            <div class="mb-2">
                                                @php $words = explode(' ', $block['text']); @endphp
                                                @foreach($words as $word)
                                                    <span class="transcript-word cursor-pointer hover:bg-yellow-100 transition-colors duration-200 rounded px-0.5 inline-block">{{ $word }}</span>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    {!! nl2br(e($transcriptEn)) !!}
                                @endif
                            @else
                                <div class="text-center text-slate-400 italic mt-4">No transcript available.</div>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- Indonesian Column --}}
                <div class="flex flex-col h-full bg-indigo-50">
                    <div class="flex-none px-4 py-2 bg-indigo-100 border-b border-indigo-200 font-semibold text-indigo-800 flex items-center justify-between z-10">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm"> Terjemahan Indonesia
                        </div>
                        <button onclick="toggleTranscriptDrawer()" class="text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="flex-1 relative overflow-hidden">
                        <div class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-indigo-900/80 custom-scrollbar pr-2">
                            @if(isset($material) && $material->transcript_id)
                                {!! nl2br(e($material->transcript_id)) !!}
                            @else
                                <div class="text-center text-indigo-300 italic mt-4">Belum ada terjemahan.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 2)
    <!-- Practice 2 Content: Hotel Information -->
    <div class="space-y-8">
        <!-- Question Block -->
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-purple-500 p-8 relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-purple-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <!-- Header Section -->
            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Questions 1-6</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Hotel Information</h3>
            </div>

            <!-- Instructions -->
            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the form below. Write <span class="font-bold">NO MORE THAN THREE WORDS AND/OR NUMBERS</span> for each answer.</p>
                </div>
            </div>

            <!-- Hotel Information Form Table -->
            <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th colspan="2" class="p-5 font-semibold rounded-t-xl text-center text-lg uppercase tracking-wider">
                                <span class="text-red-400">Hotel Information</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Example Row -->
                        <tr class="bg-gray-50">
                            <td class="p-3 text-gray-700 text-base font-medium italic">Example answer</td>
                            <td class="p-3"></td>
                        </tr>
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Name of accommodation:</td>
                            <td class="p-3 text-gray-900 text-base"><strong>(0)</strong> <em>Carlton Hotel</em></td>
                        </tr>
                        
                        <!-- Length of stay -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Length of stay:</td>
                            <td class="p-3 text-gray-900 text-base">3 nights</td>
                        </tr>
                        
                        <!-- Q1: Ages of children -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Ages of children:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">(1)</span>
                                    <input type="text" name="q1" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-purple-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Rooms available -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Rooms available:</td>
                            <td class="p-3 text-gray-900 text-base">Two en-suites at £270</td>
                        </tr>
                        
                        <!-- Q2: Price inclusive of -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Price inclusive of:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">(2)</span>
                                    <input type="text" name="q2" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-purple-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Payment method -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Payment method:</td>
                            <td class="p-3 text-gray-900 text-base">credit card</td>
                        </tr>
                        
                        <!-- Q3: Name -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Name:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-900 text-base">Michael</span>
                                    <span class="w-7 h-7 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">(3)</span>
                                    <input type="text" name="q3" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-purple-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Q4: Date of birth -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Date of birth:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">(4)</span>
                                    <input type="text" name="q4" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-purple-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                    <span class="text-gray-900 text-base">1968</span>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Address -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Address:</td>
                            <td class="p-3 text-gray-900 text-base">273, Stanton Court, London.</td>
                        </tr>
                        
                        <!-- Q5: Post code -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Post code:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">(5)</span>
                                    <input type="text" name="q5" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-purple-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Q6: Telephone -->
                        <tr class="group hover:bg-purple-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Telephone:</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-900 text-base">08773</span>
                                    <span class="w-7 h-7 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">(6)</span>
                                    <input type="text" name="q6" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-purple-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Question Block 2: Questions 7-10 -->
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-pink-500 p-8 relative overflow-hidden mt-8">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-pink-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <!-- Header Section -->
            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-pink-100 text-pink-700 text-xs font-bold uppercase tracking-wider rounded-full">Questions 7-10</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Transport Options</h3>
            </div>

            <!-- Instructions -->
            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the table below. Write <span class="font-bold">NO MORE THAN THREE WORDS AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <!-- Transport Options Table -->
            <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th colspan="4" class="p-5 font-semibold rounded-t-xl text-center text-lg uppercase tracking-wider">
                                <span class="text-red-400">Transport Options</span>
                            </th>
                        </tr>
                        <tr class="bg-gray-700 text-white">
                            <th class="p-3 font-semibold text-center border-r border-gray-600">Mode of Transport</th>
                            <th class="p-3 font-semibold text-center border-r border-gray-600">Cost</th>
                            <th class="p-3 font-semibold text-center border-r border-gray-600">Arrangements</th>
                            <th class="p-3 font-semibold text-center">Travel time to town</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Taxi Row -->
                        <tr class="group hover:bg-pink-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium text-center border-r border-gray-100">Taxi</td>
                            <td class="p-3 border-r border-gray-100">
                                <div class="space-y-2">
                                    <p class="text-gray-900 text-base">Approximately</p>
                                    <div class="flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-sm font-bold">(7)</span>
                                        <span class="text-gray-900 text-base">£</span>
                                        <input type="text" name="q7" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-pink-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 text-gray-900 text-base text-center border-r border-gray-100">Pick up from the hotel</td>
                            <td class="p-3 text-gray-900 text-base text-center">10 minutes</td>
                        </tr>
                        
                        <!-- Bus Row -->
                        <tr class="group hover:bg-pink-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium text-center border-r border-gray-100">Bus</td>
                            <td class="p-3 text-gray-900 text-base text-center border-r border-gray-100">£2 per person</td>
                            <td class="p-3 border-r border-gray-100">
                                <div class="space-y-2">
                                    <p class="text-gray-900 text-base">Walk down Oak Tree <span class="w-7 h-7 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-600 text-sm font-bold">(8)</span></p>
                                    <input type="text" name="q8" class="w-full bg-transparent border-b-2 border-gray-300 focus:border-pink-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                            <td class="p-3 text-gray-900 text-base text-center">15 minutes</td>
                        </tr>
                        
                        <!-- Walking Row -->
                        <tr class="group hover:bg-pink-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium text-center border-r border-gray-100">Walking</td>
                            <td class="p-3 text-gray-900 text-base text-center border-r border-gray-100">--------</td>
                            <td class="p-3 border-r border-gray-100">
                                <div class="space-y-2">
                                    <p class="text-gray-900 text-base">Walk through <span class="w-7 h-7 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-600 text-sm font-bold">(9)</span></p>
                                    <input type="text" name="q9" class="w-full bg-transparent border-b-2 border-gray-300 focus:border-pink-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center gap-2 justify-center">
                                    <span class="w-7 h-7 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-sm font-bold">(10)</span>
                                    <input type="text" name="q10" class="flex-1 max-w-[150px] bg-transparent border-b-2 border-gray-300 focus:border-pink-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Your answer...">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bottom Spacer for Audio Player -->
        <div class="h-24"></div>
    </div>
    
    <!-- Fixed Bottom Audio Player -->
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-indigo-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] px-4 py-3 transform transition-transform duration-300" x-data="{ playing: false, time: '0:00', duration: '0:00', audio: null, progress: 0 }">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-4">
            <!-- Icon & Title -->
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white shadow-md flex-shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"></path></svg>
                </div>
                <span class="text-sm font-bold text-indigo-900 line-clamp-1 hidden sm:inline">Audio Session - Practice 2</span>
            </div>

            <!-- Controls -->
            <div class="flex-1 flex items-center gap-3 w-full justify-center md:justify-center">
                <!-- Key (Dummy) -->
                <button class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200 hidden sm:block">
                    Key
                </button>

                <!-- Skip Back -->
                <button type="button" onclick="skipAudio(-10)" class="p-2 bg-indigo-50 hover:bg-indigo-100 rounded-lg text-indigo-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path></svg>
                </button>

                <!-- Play/Pause -->
                <button type="button" id="playPauseBtn" onclick="togglePlayPause()" class="w-10 h-10 bg-indigo-600 hover:bg-indigo-700 rounded-xl flex items-center justify-center text-white transition-colors shadow-lg hover:shadow-indigo-200 transform hover:scale-105 active:scale-95">
                    <svg id="playIcon" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <svg id="pauseIcon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>
                </button>

                <!-- Progress -->
                <div class="flex-1 flex flex-col min-w-[200px] max-w-lg">
                    <div class="flex justify-between text-[10px] text-indigo-600 font-bold mb-1">
                        <span id="currentTime">0:00</span>
                        <span id="duration">0:00</span>
                    </div>
                    <div class="relative h-2 bg-indigo-100 rounded-full cursor-pointer group" id="progressContainer">
                        <div id="progressBar" class="absolute h-full bg-indigo-600 rounded-full" style="width: 0%"></div>
                        <div id="progressHandle" class="absolute top-1/2 -translate-y-1/2 -ml-2 w-4 h-4 bg-white border-2 border-indigo-600 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%"></div>
                    </div>
                </div>

                <!-- Skip Forward -->
                <button type="button" onclick="skipAudio(10)" class="p-2 bg-indigo-50 hover:bg-indigo-100 rounded-lg text-indigo-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path></svg>
                </button>
                
                <!-- Terjemah -->
                <button type="button" onclick="toggleTranscriptDrawer()" 
                        class="p-2 bg-yellow-400 border-2 border-yellow-500 hover:bg-yellow-500 rounded-lg transition-colors flex-shrink-0 flex items-center gap-2 group shadow-sm" title="Lihat/Tutup Transkrip">
                    <svg class="w-5 h-5 text-black group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-xs font-bold text-black hidden sm:inline">Terjemah</span>
                </button>
                
                @if(Auth::user()->isAdmin())
                   <!-- Upload Buttons (Admin Only) -->
                   <div class="flex items-center gap-2">
                       <button onclick="const modal=document.getElementById('uploadSrtModal'); modal.classList.remove('hidden'); modal.classList.add('flex');" class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload SRT">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Upload SRT
                        </button>
                       <button onclick="const modal=document.getElementById('uploadAudioModal'); modal.classList.remove('hidden'); modal.classList.add('flex');" class="px-3 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload Audio">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            Upload Audio
                        </button>
                   </div>
                @endif
            </div>

            <audio id="mainAudio" class="hidden">
                @if(isset($material) && $material->audio_file)
                    <source src="{{ asset($material->audio_file) }}" type="audio/mpeg">
                @else
                    <source src="" type="audio/mpeg">
                @endif
            </audio>
        </div>
    </div>
    
        {{-- Transcript Drawer (Collapsible) --}}
        <div id="transcriptDrawer" class="hidden border border-gray-300 rounded-lg mx-4 mb-4 bg-white h-80 overflow-hidden flex-col transition-all duration-300 ease-in-out shadow-md">
            <div class="flex-1 overflow-hidden grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                {{-- English Column --}}
                <div class="flex flex-col h-full bg-slate-50">
                    <div class="flex-none px-4 py-2 bg-slate-100 border-b border-slate-200 font-semibold text-slate-700 flex items-center justify-between z-10">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/w20/us.png" alt="US" class="rounded-sm"> English Script
                        </div>
                    </div>
                    <div class="flex-1 relative overflow-hidden">
                        <div class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-slate-600 custom-scrollbar pr-2">
                            @if(isset($material) && $material->transcript_en)
                                @php
                                    $transcriptEn = $material->transcript_en;
                                    $jsonEn = json_decode($transcriptEn, true);
                                    $isJsonEn = (json_last_error() === JSON_ERROR_NONE && is_array($jsonEn));
                                @endphp
                                @if($isJsonEn)
                                    <div class="space-y-2">
                                        @foreach($jsonEn as $block)
                                            <div class="mb-2">
                                                @php $words = explode(' ', $block['text']); @endphp
                                                @foreach($words as $word)
                                                    <span class="transcript-word cursor-pointer hover:bg-yellow-100 transition-colors duration-200 rounded px-0.5 inline-block">{{ $word }}</span>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    {!! nl2br(e($transcriptEn)) !!}
                                @endif
                            @else
                                <p class="text-gray-400 italic">No English transcript available.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Indonesian Column --}}
                <div class="flex flex-col h-full bg-amber-50">
                    <div class="flex-none px-4 py-2 bg-amber-100 border-b border-amber-200 font-semibold text-amber-800 flex items-center justify-between z-10">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm"> Indonesian Script
                        </div>
                    </div>
                    <div class="flex-1 relative overflow-hidden">
                        <div class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-amber-900 custom-scrollbar pr-2">
                            @if(isset($material) && $material->transcript_id)
                                {!! nl2br(e($material->transcript_id)) !!}
                            @else
                                <p class="text-gray-400 italic">No Indonesian transcript available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 3)
    <!-- Practice 3 Content: Apartment for Rent -->
    <div class="space-y-8">
        <!-- Question Block -->
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-blue-500 p-8 relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-blue-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <!-- Header Section -->
            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider rounded-full">Questions 1-5</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Apartment for Rent</h3>
            </div>

            <!-- Instructions -->
            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the information below. Write <span class="font-bold">NO MORE THAN ONE WORD OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <!-- Apartment for Rent Form Table -->
            <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th colspan="2" class="p-5 font-semibold rounded-t-xl text-center text-lg uppercase tracking-wider">
                                <span class="text-blue-300">Apartment for rent</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Street -->
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium w-1/3">Street</td>
                            <td class="p-3 text-gray-900 text-base"><u>Bridge</u> street</td>
                        </tr>
                        
                        <!-- Q1: Street No -->
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Street Nº</td>
                            <td class="p-3 text-gray-900 text-base">
                                <div class="flex items-center gap-3">
                                    <span class="flex-shrink-0 font-bold">(1)</span>
                                    <input type="text" name="q1" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-blue-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Answer...">
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Q2: Included utilities -->
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Included utilities</td>
                            <td class="p-3 text-gray-900 text-base">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Gas, heat, water,</span>
                                    <span class="font-bold">(2)</span>
                                    <input type="text" name="q2" class="min-w-[150px] bg-transparent border-b-2 border-gray-300 focus:border-blue-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Answer...">
                                    <span>, phone</span>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Q3: Not included utilities -->
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Not included utilities</td>
                            <td class="p-3 text-gray-900 text-base">
                                <div class="flex items-center gap-3">
                                    <span class="flex-shrink-0 font-bold">(3)</span>
                                    <input type="text" name="q3" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-blue-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Answer...">
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Q4: Public transport -->
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Public transport</td>
                            <td class="p-3 text-gray-900 text-base">
                                <div class="flex items-center gap-3">
                                    <span>Underground,</span>
                                    <span class="flex-shrink-0 font-bold">(4)</span>
                                    <input type="text" name="q4" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-blue-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Answer...">
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Q5: Tenant's name -->
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="p-3 text-gray-800 text-base font-medium">Tenant's name</td>
                            <td class="p-3 text-gray-900 text-base">
                                <div class="flex items-center gap-3">
                                    <span>John</span>
                                    <span class="flex-shrink-0 font-bold">(5)</span>
                                    <input type="text" name="q5" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-blue-500 outline-none px-2 py-1 transition-colors text-gray-900 text-base placeholder-gray-300" placeholder="Answer...">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Bottom Spacer for Audio Player -->
            <div class="h-8"></div>

            <!-- Question Block: Questions 6-8 (Multiple Choice - Multiple Answer) -->
            <div class="bg-white rounded-3xl shadow-xl border-t-4 border-purple-500 p-8 relative overflow-hidden">
                <!-- Decorative Background Element -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-purple-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                <!-- Header Section -->
                <div class="relative z-10 mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Questions 6-8</span>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                        <p class="text-amber-700 text-sm">Choose <span class="font-bold">THREE</span> letters, <span class="font-bold">A-F</span>.</p>
                    </div>
                </div>

                <!-- Question -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Which <span class="font-bold">THREE</span> things should the caller bring to the meeting?</h4>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-purple-50 cursor-pointer transition-colors group">
                            <input type="checkbox" name="q6_8[]" value="A" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">A.</span> Driving license</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-purple-50 cursor-pointer transition-colors group">
                            <input type="checkbox" name="q6_8[]" value="B" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">B.</span> Passport</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-purple-50 cursor-pointer transition-colors group">
                            <input type="checkbox" name="q6_8[]" value="C" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">C.</span> Tax bill</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-purple-50 cursor-pointer transition-colors group">
                            <input type="checkbox" name="q6_8[]" value="D" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">D.</span> Employment contract</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-purple-50 cursor-pointer transition-colors group">
                            <input type="checkbox" name="q6_8[]" value="E" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">E.</span> Reference from a friend or colleague</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-purple-50 cursor-pointer transition-colors group">
                            <input type="checkbox" name="q6_8[]" value="F" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">F.</span> Reference from an employer</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Bottom Spacer for Audio Player -->
            <div class="h-8"></div>

            <!-- Question Block: Questions 9-10 (Multiple Choice - Single Answer) -->
            <div class="bg-white rounded-3xl shadow-xl border-t-4 border-pink-500 p-8 relative overflow-hidden">
                <!-- Decorative Background Element -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-pink-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                <!-- Header Section -->
                <div class="relative z-10 mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-pink-100 text-pink-700 text-xs font-bold uppercase tracking-wider rounded-full">Questions 9-10</span>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                        <p class="text-amber-700 text-sm">Choose the correct letters, <span class="font-bold">A, B, or C</span>.</p>
                    </div>
                </div>

                <!-- Question 9 -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4"><span class="inline-block w-8 h-8 bg-pink-100 text-pink-600 rounded-full text-center leading-8 mr-2">9</span> What time do the caller and apartment manager decide to meet?</h4>
                    <div class="space-y-3 pl-10">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-pink-50 cursor-pointer transition-colors group">
                            <input type="radio" name="q9" value="A" class="w-5 h-5 text-pink-600 border-gray-300 focus:ring-pink-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">A.</span> 5:30 PM</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-pink-50 cursor-pointer transition-colors group">
                            <input type="radio" name="q9" value="B" class="w-5 h-5 text-pink-600 border-gray-300 focus:ring-pink-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">B.</span> 6:00 PM</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-pink-50 cursor-pointer transition-colors group">
                            <input type="radio" name="q9" value="C" class="w-5 h-5 text-pink-600 border-gray-300 focus:ring-pink-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">C.</span> 6:30 PM</span>
                        </label>
                    </div>
                </div>

                <!-- Question 10 -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4"><span class="inline-block w-8 h-8 bg-pink-100 text-pink-600 rounded-full text-center leading-8 mr-2">10</span> Where do they decide to meet?</h4>
                    <div class="space-y-3 pl-10">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-pink-50 cursor-pointer transition-colors group">
                            <input type="radio" name="q10" value="A" class="w-5 h-5 text-pink-600 border-gray-300 focus:ring-pink-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">A.</span> Near the manager's apartment</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-pink-50 cursor-pointer transition-colors group">
                            <input type="radio" name="q10" value="B" class="w-5 h-5 text-pink-600 border-gray-300 focus:ring-pink-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">B.</span> At the caller's future apartment</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-pink-50 cursor-pointer transition-colors group">
                            <input type="radio" name="q10" value="C" class="w-5 h-5 text-pink-600 border-gray-300 focus:ring-pink-500">
                            <span class="text-gray-700 font-medium group-hover:text-gray-900"><span class="font-bold mr-2">C.</span> At the office</span>
                        </label>
                    </div>
                </div>
            </div>
            
             <!-- Bottom Spacer for Audio Player -->
            <div class="h-24"></div>
        </div>
        
        <!-- Fixed Bottom Audio Player -->
        <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-indigo-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] px-4 py-3 transform transition-transform duration-300" x-data="{ playing: false, time: '0:00', duration: '0:00', audio: null, progress: 0 }">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-4">
                <!-- Icon & Title -->
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white shadow-md flex-shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-indigo-900 line-clamp-1 hidden sm:inline">Audio Session - Practice 3</span>
                </div>

                <!-- Controls -->
                <div class="flex-1 flex items-center gap-3 w-full justify-center md:justify-center">
                    <!-- Key (Dummy) -->
                    <button class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200 hidden sm:block">
                        Key
                    </button>

                    <!-- Skip Back -->
                    <button type="button" onclick="skipAudio(-10)" class="p-2 bg-indigo-50 hover:bg-indigo-100 rounded-lg text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path></svg>
                    </button>

                    <!-- Play/Pause -->
                    <button type="button" id="playPauseBtn" onclick="togglePlayPause()" class="w-10 h-10 bg-indigo-600 hover:bg-indigo-700 rounded-xl flex items-center justify-center text-white transition-colors shadow-lg hover:shadow-indigo-200 transform hover:scale-105 active:scale-95">
                        <svg id="playIcon" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <svg id="pauseIcon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>
                    </button>

                    <!-- Progress -->
                    <div class="flex-1 flex flex-col min-w-[200px] max-w-lg">
                        <div class="flex justify-between text-[10px] text-indigo-600 font-bold mb-1">
                            <span id="currentTime">0:00</span>
                            <span id="duration">0:00</span>
                        </div>
                        <div class="relative h-2 bg-indigo-100 rounded-full cursor-pointer group" id="progressContainer">
                            <div id="progressBar" class="absolute h-full bg-indigo-600 rounded-full" style="width: 0%"></div>
                            <div id="progressHandle" class="absolute top-1/2 -translate-y-1/2 -ml-2 w-4 h-4 bg-white border-2 border-indigo-600 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity" style="left: 0%"></div>
                        </div>
                    </div>

                    <!-- Skip Forward -->
                    <button type="button" onclick="skipAudio(10)" class="p-2 bg-indigo-50 hover:bg-indigo-100 rounded-lg text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path></svg>
                    </button>
                    
                    <!-- Terjemah -->
                    <button type="button" onclick="toggleTranscriptDrawer()" 
                            class="p-2 bg-yellow-400 border-2 border-yellow-500 hover:bg-yellow-500 rounded-lg transition-colors flex-shrink-0 flex items-center gap-2 group shadow-sm" title="Lihat/Tutup Transkrip">
                        <svg class="w-5 h-5 text-black group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-xs font-bold text-black hidden sm:inline">Terjemah</span>
                    </button>
                    
                    @if(Auth::user()->isAdmin())
                       <!-- Upload Buttons (Admin Only) -->
                       <div class="flex items-center gap-2">
                           <button onclick="const modal=document.getElementById('uploadSrtModal'); modal.classList.remove('hidden'); modal.classList.add('flex');" class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload SRT">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Upload SRT
                            </button>
                           <button onclick="const modal=document.getElementById('uploadAudioModal'); modal.classList.remove('hidden'); modal.classList.add('flex');" class="px-3 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload Audio">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                Upload Audio
                            </button>
                       </div>
                    @endif
                </div>

                <audio id="mainAudio" class="hidden">
                    @if(isset($material) && $material->audio_file)
                        <source src="{{ asset($material->audio_file) }}" type="audio/mpeg">
                    @else
                        <source src="" type="audio/mpeg">
                    @endif
                </audio>
            </div>
        </div>
        
        {{-- Transcript Drawer (Collapsible) --}}
        <div id="transcriptDrawer" class="hidden border border-gray-300 rounded-lg mx-4 mb-4 bg-white h-80 overflow-hidden flex-col transition-all duration-300 ease-in-out shadow-md">
            <div class="flex-1 overflow-hidden grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                {{-- English Column --}}
                <div class="flex flex-col h-full bg-slate-50">
                    <div class="flex-none px-4 py-2 bg-slate-100 border-b border-slate-200 font-semibold text-slate-700 flex items-center justify-between z-10">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/w20/us.png" alt="US" class="rounded-sm"> English Script
                        </div>
                    </div>
                    <div class="flex-1 relative overflow-hidden">
                        <div class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-slate-600 custom-scrollbar pr-2">
                            @if(isset($material) && $material->transcript_en)
                                @php
                                    $transcriptEn = $material->transcript_en;
                                    $jsonEn = json_decode($transcriptEn, true);
                                    $isJsonEn = (json_last_error() === JSON_ERROR_NONE && is_array($jsonEn));
                                @endphp
                                @if($isJsonEn)
                                    <div class="space-y-2">
                                        @foreach($jsonEn as $block)
                                            <div class="mb-2">
                                                @php $words = explode(' ', $block['text']); @endphp
                                                @foreach($words as $word)
                                                    <span class="transcript-word cursor-pointer hover:bg-yellow-100 transition-colors duration-200 rounded px-0.5 inline-block">{{ $word }}</span>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    {!! nl2br(e($transcriptEn)) !!}
                                @endif
                            @else
                                <p class="text-gray-400 italic">No English transcript available.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Indonesian Column --}}
                <div class="flex flex-col h-full bg-amber-50">
                    <div class="flex-none px-4 py-2 bg-amber-100 border-b border-amber-200 font-semibold text-amber-800 flex items-center justify-between z-10">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID" class="rounded-sm"> Indonesian Script
                        </div>
                    </div>
                    <div class="flex-1 relative overflow-hidden">
                        <div class="absolute inset-0 p-4 overflow-y-scroll overflow-x-hidden prose prose-sm max-w-none text-amber-900 custom-scrollbar pr-2">
                            @if(isset($material) && $material->transcript_id)
                                {!! nl2br(e($material->transcript_id)) !!}
                            @else
                                <p class="text-gray-400 italic">No Indonesian transcript available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 5)
    <div class="space-y-8">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-teal-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-teal-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-teal-100 text-teal-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Part A</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Choose the correct letter, A, B, or C</h3>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">1. Where are they sitting?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q1" value="A" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>next to the window</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q1" value="B" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>next to the door</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q1" value="C" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>in the centre of the room</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">2. What is Dan having as a starter?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q2" value="A" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>tomato soup</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q2" value="B" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>green salad</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q2" value="C" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>He isn't having a starter.</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">3. When did Lucy last eat?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q3" value="A" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>in the morning</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q3" value="B" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>at lunchtime</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-teal-50 cursor-pointer transition-colors group"><input type="radio" name="q3" value="C" class="w-5 h-5 text-teal-600 border-gray-300 focus:ring-teal-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>in the afternoon</span></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-cyan-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-cyan-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider rounded-full">Part B</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Form Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the form below</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN THREE WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h4 class="text-xl font-bold text-center text-gray-900 mb-5">Menu</h4>
                <div class="space-y-4 text-gray-800">
                    <div class="grid grid-cols-[120px_1fr] gap-3 items-start">
                        <span class="font-semibold">Starters:</span>
                        <div class="space-y-2">
                            <div>tomato soup</div>
                            <div>seafood chowder</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-[120px_1fr] gap-3 items-start">
                        <span class="font-semibold">Mains:</span>
                        <div class="space-y-2">
                            <div><span class="font-semibold mr-2">4.</span><input type="text" name="q4" class="w-72 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"></div>
                            <div>roast lamb with potatoes</div>
                            <div>bacon and egg pie</div>
                            <div><span class="font-semibold mr-2">5.</span><input type="text" name="q5" class="w-72 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"></div>
                            <div>spaghetti bolognaise</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-[120px_1fr] gap-3 items-start">
                        <span class="font-semibold">Desserts:</span>
                        <div class="space-y-2">
                            <div>apple pie</div>
                            <div><span class="font-semibold mr-2">6.</span><input type="text" name="q6" class="w-72 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 6)
    <div class="space-y-8">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-indigo-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Sentence Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the sentences below</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN TWO WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-5 text-lg text-gray-800 leading-relaxed">
                <div>1. Paul can't buy the game because he is not <input type="text" name="q1" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">.</div>
                <div>2. The game contains <input type="text" name="q2" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"> scenes that young people shouldn't see.</div>
                <div>3. Children may get injured if they mimic the game's violence in <input type="text" name="q3" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">.</div>
                <div>4. Games that are not designed for young people should have an <input type="text" name="q4" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">.</div>
                <div>5. Paul thinks that <input type="text" name="q5" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"> should decide which games to buy for their children.</div>
                <div>6. Paul's friends agree that restrictions on games should be just like restrictions on <input type="text" name="q6" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">.</div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 7)
    <div class="space-y-8">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-rose-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-rose-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Sentence Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the sentences below</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN TWO WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-5 text-lg text-gray-800 leading-relaxed">
                <div>7. The television show that Carla is watching is about <input type="text" name="q7" class="w-64 border-b-2 border-gray-300 focus:border-rose-500 outline-none">.</div>
                <div>8. Jack and Sally agree that it is not appropriate for <input type="text" name="q8" class="w-64 border-b-2 border-gray-300 focus:border-rose-500 outline-none"> to see that type of show.</div>
                <div>9. Carla believes that violent crime shows should not be shown to <input type="text" name="q9" class="w-64 border-b-2 border-gray-300 focus:border-rose-500 outline-none">.</div>
                <div>10. There's a possibility people may attempt to repeat a <input type="text" name="q10" class="w-64 border-b-2 border-gray-300 focus:border-rose-500 outline-none"> that they saw on television.</div>
                <div>11. Jack believes that <input type="text" name="q11" class="w-64 border-b-2 border-gray-300 focus:border-rose-500 outline-none"> should not have restrictions on their television viewing.</div>
                <div>12. The three friends decide to <input type="text" name="q12" class="w-64 border-b-2 border-gray-300 focus:border-rose-500 outline-none"> about this topic.</div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 8)
    <div class="space-y-8">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-emerald-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Sentence Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the sentences below</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN THREE WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-5 text-lg text-gray-800 leading-relaxed">
                <div>1. Sarah said she didn't <input type="text" name="q1" class="w-64 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> in reply to the three previous invitations for dinner.</div>
                <div>2. Anna said that Sarah doesn't agree to meet her <input type="text" name="q2" class="w-64 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> these days.</div>
                <div>3. Carolyn and Blair think that Sarah doesn't want to eat <input type="text" name="q3" class="w-64 border-b-2 border-gray-300 focus:border-emerald-500 outline-none">.</div>
                <div>4. Anna saw Sarah in the supermarket and thought she <input type="text" name="q4" class="w-64 border-b-2 border-gray-300 focus:border-emerald-500 outline-none">.</div>
                <div>5. Anna said that Sarah didn't buy any <input type="text" name="q5" class="w-64 border-b-2 border-gray-300 focus:border-emerald-500 outline-none">.</div>
                <div>6. Blair is worried that Sarah might diet until she has to spend time <input type="text" name="q6" class="w-64 border-b-2 border-gray-300 focus:border-emerald-500 outline-none">.</div>
                <div>7. The friends decide to invite Sarah to a party and <input type="text" name="q7" class="w-64 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> about her dieting problem.</div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 9)
    <div class="space-y-8">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-amber-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Sentence Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the sentences below</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN THREE WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-5 text-lg text-gray-800 leading-relaxed">
                <div>8. Helen says that Tina is <input type="text" name="q8" class="w-64 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> now, despite gaining weight.</div>
                <div>9. Helen thinks that Tina's weight gain might be because she isn't <input type="text" name="q9" class="w-64 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> as she was before.</div>
                <div>10. Donna says that Tina stopped gymnastics training so that she can <input type="text" name="q10" class="w-64 border-b-2 border-gray-300 focus:border-amber-500 outline-none">.</div>
                <div>11. Helen thinks that Tina will notice her weight gain is unhealthy and make changes to <input type="text" name="q11" class="w-64 border-b-2 border-gray-300 focus:border-amber-500 outline-none">.</div>
                <div>12. Donna says Tina doesn't need to be concerned about her weight if she <input type="text" name="q12" class="w-64 border-b-2 border-gray-300 focus:border-amber-500 outline-none">.</div>
                <div>13. Peter suggests they give her an invitation to go with them for <input type="text" name="q13" class="w-64 border-b-2 border-gray-300 focus:border-amber-500 outline-none">.</div>
            </div>
        </div>
    </div>
    @endif

    @elseif($id == 8)
    @if(!request()->has('practice'))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="?practice=1" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-teal-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-teal-500 to-cyan-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 1</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">Marketplace Safety Tips</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Short-answer questions 1-7.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>7 Questions</span><span>~10 mins</span></div>
                <span class="text-teal-600 font-semibold group-hover:text-teal-700 flex items-center gap-2">Start Listening 1 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=2" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-indigo-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 2</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Personal Security Advice</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Short-answer questions 8-16.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>9 Questions</span><span>~12 mins</span></div>
                <span class="text-indigo-600 font-semibold group-hover:text-indigo-700 flex items-center gap-2">Start Listening 2 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

    </div>
    @elseif(request()->get('practice') == 1)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-teal-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-teal-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-teal-100 text-teal-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Short Answer</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the short-answer questions</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN TWO WORDS AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm text-lg leading-relaxed text-gray-800 space-y-5">
                <div>
                    <p class="font-medium mb-2">What combination of things in a marketplace makes thieves happy?</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li><span class="font-semibold">1.</span> <input type="text" name="q1" class="w-64 border-b-2 border-gray-300 focus:border-teal-500 outline-none"></li>
                        <li>tourists</li>
                    </ul>
                </div>
                <div>
                    <p class="font-medium mb-2">Which two examples of essential documents are named by the speaker?</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li><span class="font-semibold">2.</span> <input type="text" name="q2" class="w-64 border-b-2 border-gray-300 focus:border-teal-500 outline-none"></li>
                        <li><span class="font-semibold">3.</span> <input type="text" name="q3" class="w-64 border-b-2 border-gray-300 focus:border-teal-500 outline-none"></li>
                    </ul>
                </div>
                <div>
                    <p class="font-medium mb-2">Which three minor items are said to be alright in a waist bag?</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li><span class="font-semibold">4.</span> <input type="text" name="q4" class="w-64 border-b-2 border-gray-300 focus:border-teal-500 outline-none"></li>
                        <li><span class="font-semibold">5.</span> <input type="text" name="q5" class="w-64 border-b-2 border-gray-300 focus:border-teal-500 outline-none"></li>
                        <li>cheap reading glasses</li>
                    </ul>
                </div>
                <div>
                    <p class="font-medium mb-2">What information about prices did the tour guide give for when people bargain in the bazaar?</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li>The initial price will be <span class="font-semibold">6.</span> <input type="text" name="q6" class="w-64 border-b-2 border-gray-300 focus:border-teal-500 outline-none">.</li>
                        <li>A fair price is about <span class="font-semibold">7.</span> <input type="text" name="q7" class="w-52 border-b-2 border-gray-300 focus:border-teal-500 outline-none"> of the initial price.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 2)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-indigo-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Short Answer</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the short-answer questions</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN TWO WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm text-lg leading-relaxed text-gray-800 space-y-5">
                <div>
                    <p class="font-medium mb-2">When you get a debit card, what advice does the speaker give in relation to the PIN? Don't:</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li>use an <span class="font-semibold">8.</span> <input type="text" name="q8" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">.</li>
                        <li>tell anyone what your number is.</li>
                    </ul>
                </div>
                <div>
                    <p class="font-medium mb-2">Who must you notify if you lose your card?</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li><span class="font-semibold">9.</span> <input type="text" name="q9" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"></li>
                        <li><span class="font-semibold">10.</span> <input type="text" name="q10" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"></li>
                    </ul>
                </div>
                <div>
                    <p class="font-medium mb-2">Which scams does the speaker tell you to beware of?</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li><span class="font-semibold">11.</span> <input type="text" name="q11" class="w-56 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"> scams</li>
                        <li><span class="font-semibold">12.</span> <input type="text" name="q12" class="w-56 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"> scams</li>
                    </ul>
                </div>
                <div>
                    <p class="font-medium mb-2">What three kinds of possessions are said to be attractive to thieves in College Hall?</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li><span class="font-semibold">13.</span> <input type="text" name="q13" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"></li>
                        <li>MP3 players</li>
                        <li><span class="font-semibold">14.</span> <input type="text" name="q14" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"></li>
                    </ul>
                </div>
                <div>
                    <p class="font-medium mb-2">Which car safety devices does the speaker suggest car owners should buy?</p>
                    <ul class="list-disc pl-8 space-y-2">
                        <li>a <span class="font-semibold">15.</span> <input type="text" name="q15" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"></li>
                        <li>or</li>
                        <li>a <span class="font-semibold">16.</span> <input type="text" name="q16" class="w-64 border-b-2 border-gray-300 focus:border-indigo-500 outline-none"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    @elseif($id == 7)
    @if(!request()->has('practice'))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="?practice=1" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-rose-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-rose-500 to-red-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 1</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-red-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-rose-600 transition-colors">Kitesurfing Safety Summary</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Complete the summary questions 1-8.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>8 Questions</span><span>~10 mins</span></div>
                <span class="text-rose-600 font-semibold group-hover:text-rose-700 flex items-center gap-2">Start Listening 1 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=2" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-indigo-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 2</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Rock Climbing Safety Summary</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Complete the summary questions 9-16.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>8 Questions</span><span>~10 mins</span></div>
                <span class="text-indigo-600 font-semibold group-hover:text-indigo-700 flex items-center gap-2">Start Listening 2 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=3" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-amber-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 3</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Assessment Schedule (Listening 1)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Multiple choice (1-3) and table completion (4-10).</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>10 Questions</span><span>~12 mins</span></div>
                <span class="text-amber-600 font-semibold group-hover:text-amber-700 flex items-center gap-2">Start Soal 3 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=4" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-cyan-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 4</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-cyan-600 transition-colors">Assessment Schedule (Listening 2)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Sentence completion (1-4) and value table (5-10).</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>10 Questions</span><span>~12 mins</span></div>
                <span class="text-cyan-600 font-semibold group-hover:text-cyan-700 flex items-center gap-2">Start Soal 4 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

    </div>
    @elseif(request()->get('practice') == 1)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-rose-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-rose-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Summary Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the summary</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm text-lg leading-relaxed text-gray-800 space-y-4">
                <p>
                    A growing number of people are <span class="font-semibold">(1)</span>
                    <input type="text" name="q1" class="w-44 border-b-2 border-gray-300 focus:border-rose-500 outline-none">
                    all over the world, resulting in a number of serious and even <span class="font-semibold">(2)</span>
                    <input type="text" name="q2" class="w-40 border-b-2 border-gray-300 focus:border-rose-500 outline-none">
                    accidents every year.
                </p>
                <p>
                    You should get proper training in basic skills, the use of safety devices, and <span class="font-semibold">(3)</span>
                    <input type="text" name="q3" class="w-40 border-b-2 border-gray-300 focus:border-rose-500 outline-none">
                    techniques. Make sure you have <span class="font-semibold">(4)</span>
                    <input type="text" name="q4" class="w-40 border-b-2 border-gray-300 focus:border-rose-500 outline-none">
                    clothing, such as a helmet and life jacket. Don't try kitesurfing unless you can swim.
                </p>
                <p>
                    Once you have done your training, there are two <span class="font-semibold">(5)</span>
                    <input type="text" name="q5" class="w-36 border-b-2 border-gray-300 focus:border-rose-500 outline-none">
                    things that you should remember. First, choose a good place to practise, without a lot of other people around and with few natural <span class="font-semibold">(6)</span>
                    <input type="text" name="q6" class="w-36 border-b-2 border-gray-300 focus:border-rose-500 outline-none">
                    . Second, always check the <span class="font-semibold">(7)</span>
                    <input type="text" name="q7" class="w-36 border-b-2 border-gray-300 focus:border-rose-500 outline-none">
                    . Avoid strong winds, which might result in <span class="font-semibold">(8)</span>
                    <input type="text" name="q8" class="w-36 border-b-2 border-gray-300 focus:border-rose-500 outline-none">
                    . That usually causes serious injuries.
                </p>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 2)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-indigo-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Summary Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Complete the summary</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm text-lg leading-relaxed text-gray-800 space-y-4">
                <p>
                    A growing number of people are <span class="font-semibold">(9)</span>
                    <input type="text" name="q9" class="w-44 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">
                    climbing all over the world, resulting in a number of <span class="font-semibold">(10)</span>
                    <input type="text" name="q10" class="w-40 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">
                    falls every year.
                </p>
                <p>
                    You should get proper training in basic skills, the use of safety devices, and emergency <span class="font-semibold">(11)</span>
                    <input type="text" name="q11" class="w-40 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">
                    . Make sure you have protective equipment, such as a helmet and <span class="font-semibold">(12)</span>
                    <input type="text" name="q12" class="w-40 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">
                    . Don't try rock climbing unless you have first practised on a training wall.
                </p>
                <p>
                    Once you have done your <span class="font-semibold">(13)</span>
                    <input type="text" name="q13" class="w-36 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">
                    , there are two vital things that you should remember. First, choose a good place to practise, without a lot of other people around and with few <span class="font-semibold">(14)</span>
                    <input type="text" name="q14" class="w-36 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">
                    hazards. Second, always check the <span class="font-semibold">(15)</span>
                    <input type="text" name="q15" class="w-36 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">
                    . Avoid storms with rain, snow, and strong gusts that might cause a climber to <span class="font-semibold">(16)</span>
                    <input type="text" name="q16" class="w-36 border-b-2 border-gray-300 focus:border-indigo-500 outline-none">
                    .
                </p>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 3)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-amber-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Mixed Exercise</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Assessment Schedule</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 1-3:</p>
                    <p class="text-amber-700 text-sm">Choose the correct letter, <span class="font-bold">A, B, or C</span>.</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">1. Ms. Potts prefers to work with</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="A" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">A.</span>a computer.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="B" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">B.</span>a pencil and paper.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="C" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">C.</span>spreadsheets.</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">2. She believes it is essential to have</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="A" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">A.</span>a good system.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="B" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">B.</span>good old days.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="C" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">C.</span>one major assessment.</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">3. John thinks continuous assessment</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q3" value="A" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">A.</span>makes him sick.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q3" value="B" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">B.</span>affects his performance.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q3" value="C" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">C.</span>is fair.</span></label>
                    </div>
                </div>
            </div>

            <div class="mt-8 mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 4-10:</p>
                    <p class="text-amber-700 text-sm">Complete the table below. Write <span class="font-bold">NO MORE THAN TWO WORDS AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-amber-700 text-white">
                            <th class="p-4 text-left font-semibold w-40">Month</th>
                            <th class="p-4 text-left font-semibold">Assessment Schedule</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr><td class="p-4 font-semibold">January</td><td class="p-4">No assessment - summer holiday</td></tr>
                        <tr><td class="p-4 font-semibold">February</td><td class="p-4"><span class="font-semibold mr-1">4.</span><input type="text" name="q4" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> ; set essay topics</td></tr>
                        <tr><td class="p-4 font-semibold">March</td><td class="p-4">Field trip; <span class="font-semibold mr-1">5.</span><input type="text" name="q5" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> with photographs</td></tr>
                        <tr><td class="p-4 font-semibold">April</td><td class="p-4"><span class="font-semibold mr-1">6.</span><input type="text" name="q6" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> with visual aids. <span class="italic">Break.</span></td></tr>
                        <tr><td class="p-4 font-semibold">May</td><td class="p-4">A series of <span class="font-semibold mr-1">7.</span><input type="text" name="q7" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> (short-answer questions)</td></tr>
                        <tr><td class="p-4 font-semibold">June</td><td class="p-4">Mid-year exams</td></tr>
                        <tr><td class="p-4 font-semibold">July</td><td class="p-4"><span class="italic">Break.</span> <span class="font-semibold mr-1">8.</span><input type="text" name="q8" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"></td></tr>
                        <tr><td class="p-4 font-semibold">August</td><td class="p-4"><span class="font-semibold mr-1">9.</span><input type="text" name="q9" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"></td></tr>
                        <tr><td class="p-4 font-semibold">September</td><td class="p-4"><span class="font-semibold mr-1">10.</span><input type="text" name="q10" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> . <span class="italic">Break.</span></td></tr>
                        <tr><td class="p-4 font-semibold">October</td><td class="p-4">Test</td></tr>
                        <tr><td class="p-4 font-semibold">November</td><td class="p-4">Final exam</td></tr>
                        <tr><td class="p-4 font-semibold">December</td><td class="p-4">No assessment - summer holiday</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 4)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-cyan-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-cyan-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Mixed Exercise</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Assessment Schedule</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 1-4:</p>
                    <p class="text-amber-700 text-sm">Complete the sentences below. Write <span class="font-bold">NO MORE THAN THREE WORDS OR NUMBERS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-4 text-gray-800 text-lg">
                <div><span class="font-semibold" style="color:#2563eb;">1.</span> Jim thinks he won't have a social life because of <input type="text" name="q1" class="w-64 border-b-2 border-gray-300 focus:border-cyan-500 outline-none">.</div>
                <div><span class="font-semibold" style="color:#2563eb;">2.</span> Last year, Jim enjoyed the <input type="text" name="q2" class="w-64 border-b-2 border-gray-300 focus:border-cyan-500 outline-none">.</div>
                <div><span class="font-semibold" style="color:#2563eb;">3.</span> The <input type="text" name="q3" class="w-64 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> is scheduled for September.</div>
                <div><span class="font-semibold" style="color:#2563eb;">4.</span> There are <input type="text" name="q4a" class="w-24 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> books and <input type="text" name="q4b" class="w-24 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> articles on the reading list.</div>
            </div>

            <div class="mt-8 mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 5-10:</p>
                    <p class="text-amber-700 text-sm">Complete the table below. Write <span class="font-bold">NO MORE THAN ONE WORD OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-cyan-700 text-white">
                            <th class="p-4 text-left font-semibold w-40">Month</th>
                            <th class="p-4 text-left font-semibold">Assessment Schedule</th>
                            <th class="p-4 text-center font-semibold w-32">Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr><td class="p-4 font-semibold">January</td><td class="p-4">No assessment - summer holiday</td><td class="p-4 text-center">-</td></tr>
                        <tr><td class="p-4 font-semibold">February</td><td class="p-4">Quiz; set essay topics</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">5.</span><input type="text" name="q5" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">March</td><td class="p-4">Field trip; poster with photographs</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">6.</span><input type="text" name="q6" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">April</td><td class="p-4">Oral presentation with visual aids. <span class="italic">Break.</span></td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">7.</span><input type="text" name="q7" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">May</td><td class="p-4">A series of quizzes (short-answer questions)</td><td class="p-4 text-center">10%</td></tr>
                        <tr><td class="p-4 font-semibold">June</td><td class="p-4">Mid-year exams</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">8.</span><input type="text" name="q8" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">July</td><td class="p-4"><span class="italic">Break.</span> 5,000-word essay</td><td class="p-4 text-center">10%</td></tr>
                        <tr><td class="p-4 font-semibold">August</td><td class="p-4">Research projects</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">9.</span><input type="text" name="q9" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">September</td><td class="p-4">Seminar. <span class="italic">Break.</span></td><td class="p-4 text-center">5%</td></tr>
                        <tr><td class="p-4 font-semibold">October</td><td class="p-4">Test</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">10.</span><input type="text" name="q10" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">November</td><td class="p-4">Final exam</td><td class="p-4 text-center">20%</td></tr>
                        <tr><td class="p-4 font-semibold">December</td><td class="p-4">No assessment - summer holiday</td><td class="p-4 text-center">-</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @elseif($id == 9)
    @if(!request()->has('practice'))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <a href="?practice=1" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-teal-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-teal-500 to-cyan-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 1</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L6 20.75M3 13.25l3.75-3.75M14 6l4-4m0 0l2 2m-2-2L9 11l-2 5 5-2 9-9z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">Town Map Labelling</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Label the map and write the correct letters B-G for questions 1-2.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>2 Questions</span>
                    <span>~6 mins</span>
                </div>
                <span class="text-teal-600 font-semibold group-hover:text-teal-700 flex items-center gap-2">Start Listening 1 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=2" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-sky-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-sky-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 2</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-sky-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-sky-600 transition-colors">City Map Labelling</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Label the second map and write the correct letters B-H for questions 3-7.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>5 Questions</span>
                    <span>~10 mins</span>
                </div>
                <span class="text-sky-600 font-semibold group-hover:text-sky-700 flex items-center gap-2">Start Listening 2 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=3" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-violet-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-violet-500 to-purple-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 3</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-violet-100 to-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5h16v14H4zM8 9h8m-8 3h6"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-violet-600 transition-colors">Camera Diagram Labels</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Konten lama: choose 4 answers and label questions 1-4.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>4 Questions</span>
                    <span>~8 mins</span>
                </div>
                <span class="text-violet-600 font-semibold group-hover:text-violet-700 flex items-center gap-2">Start Soal 3 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=4" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-fuchsia-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-fuchsia-500 to-pink-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 4</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-fuchsia-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h12"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-fuchsia-600 transition-colors">Equipment Case Labels</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Konten lama: choose 4 answers and label questions 5-8.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>4 Questions</span>
                    <span>~8 mins</span>
                </div>
                <span class="text-fuchsia-600 font-semibold group-hover:text-fuchsia-700 flex items-center gap-2">Start Soal 4 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=5" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-amber-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 5</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Station Plan Labeling</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Choose SIX answers A-I for questions 1-6.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>6 Questions</span>
                    <span>~10 mins</span>
                </div>
                <span class="text-amber-600 font-semibold group-hover:text-amber-700 flex items-center gap-2">Start Soal 5 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=6" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 6</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Shopping Plan Labeling</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Choose SIX answers A-I for questions 7-12.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>6 Questions</span>
                    <span>~10 mins</span>
                </div>
                <span class="text-emerald-600 font-semibold group-hover:text-emerald-700 flex items-center gap-2">Start Soal 6 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>
    </div>
    @elseif(request()->get('practice') == 1 || request()->get('practice') == 2 || request()->get('practice') == 3 || request()->get('practice') == 4)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 {{ request()->get('practice') == 1 ? 'border-teal-500' : (request()->get('practice') == 2 ? 'border-sky-500' : (request()->get('practice') == 3 ? 'border-violet-500' : 'border-fuchsia-500')) }} p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 {{ request()->get('practice') == 1 ? 'bg-teal-50' : (request()->get('practice') == 2 ? 'bg-sky-50' : (request()->get('practice') == 3 ? 'bg-violet-50' : 'bg-fuchsia-50')) }} rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 {{ request()->get('practice') == 1 ? 'bg-teal-100 text-teal-700' : (request()->get('practice') == 2 ? 'bg-sky-100 text-sky-700' : (request()->get('practice') == 3 ? 'bg-violet-100 text-violet-700' : 'bg-fuchsia-100 text-fuchsia-700')) }} text-xs font-bold uppercase tracking-wider rounded-full">{{ request()->get('practice') == 1 ? 'Listening 1' : (request()->get('practice') == 2 ? 'Listening 2' : (request()->get('practice') == 3 ? 'Soal 3' : 'Soal 4')) }}</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Diagram Labeling</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">{{ request()->get('practice') == 1 ? 'Label the map (Questions 1-2)' : (request()->get('practice') == 2 ? 'Label the map (Questions 3-7)' : (request()->get('practice') == 3 ? 'Label the camera diagram (Questions 1-4)' : 'Label the equipment case diagram (Questions 5-8)')) }}</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">{{ request()->get('practice') == 1 ? "Label the map below. Write the correct letters, B-G, next to Questions 1 and 2. 'A' is already given as an example." : (request()->get('practice') == 2 ? "Label the map below. Write the correct letters, B-H, next to Questions 3-7. 'A' is already given as an example." : (request()->get('practice') == 3 ? 'Label the diagram below. Choose 4 answers from the box and write the correct letter next to questions 1-4.' : 'Label the diagram below. Choose 4 answers from the box and write the correct letter next to questions 5-8.')) }}</p>
                </div>
            </div>

            @if(request()->get('practice') == 1)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-xl border border-teal-200 overflow-hidden">
                    <div class="bg-teal-50 px-4 py-2 text-sm font-semibold text-teal-700">Available Letters</div>
                    <div class="divide-y divide-teal-100 text-sm">
                        <div class="px-4 py-2">Use letters <span class="font-semibold">B, C, D, E, F, G</span>.</div>
                        <div class="px-4 py-2 text-gray-600">A is already used as the example.</div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                    <div class="text-sm font-semibold text-gray-700 mb-3">Listening 1 Map</div>
                    <img src="{{ asset('images/listening/material9/map-listening1.png') }}" alt="Listening 1 town map" class="w-full h-[26rem] object-contain bg-white border border-gray-200 rounded-lg p-3">
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">1. Katie's house</label><select name="q1" class="flex-1 rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"><option value="">Select letter</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">2. Helen's house</label><select name="q2" class="flex-1 rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"><option value="">Select letter</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
            </div>

            <div class="mt-8 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-amber-800 font-medium">Listening 1 - Check: Check your answers.</div>
            @elseif(request()->get('practice') == 2)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-xl border border-sky-200 overflow-hidden">
                    <div class="bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-700">Available Letters</div>
                    <div class="divide-y divide-sky-100 text-sm">
                        <div class="px-4 py-2">Use letters <span class="font-semibold">B, C, D, E, F, G, H</span>.</div>
                        <div class="px-4 py-2 text-gray-600">A is already used as the example.</div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                    <div class="text-sm font-semibold text-gray-700 mb-3">Listening 2 Map</div>
                    <img src="{{ asset('images/listening/material9/map-listening2.png') }}" alt="Listening 2 city map" class="w-full h-[26rem] object-contain bg-white border border-gray-200 rounded-lg p-3">
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">3. restaurant</label><select name="q3" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select letter</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">4. chemist</label><select name="q4" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select letter</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">5. library</label><select name="q5" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select letter</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">6. service station</label><select name="q6" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select letter</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">7. town hall</label><select name="q7" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select letter</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
            </div>
            @elseif(request()->get('practice') == 3)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-xl border border-violet-200 overflow-hidden">
                    <div class="bg-violet-50 px-4 py-2 text-sm font-semibold text-violet-700">Answer Box (A-H)</div>
                    <div class="divide-y divide-violet-100 text-sm">
                        <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>filter</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>lens</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>focusing ring</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">D</span>hand grip</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">E</span>on / off button</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">F</span>microphone</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">G</span>rubber cup</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">H</span>tripod socket</div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                    <div class="text-sm font-semibold text-gray-700 mb-3">Camera Diagram</div>
                    <img src="{{ asset('images/listening/material9/listening1-camera.png') }}" alt="Camera diagram labels" class="w-full h-[26rem] object-contain bg-white border border-gray-200 rounded-lg p-3">
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">1.</label><select name="q1" class="flex-1 rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500"><option value="">Select letter</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">2.</label><select name="q2" class="flex-1 rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500"><option value="">Select letter</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">3.</label><select name="q3" class="flex-1 rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500"><option value="">Select letter</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">4.</label><select name="q4" class="flex-1 rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500"><option value="">Select letter</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option></select></div>
            </div>
            @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-xl border border-fuchsia-200 overflow-hidden">
                    <div class="bg-fuchsia-50 px-4 py-2 text-sm font-semibold text-fuchsia-700">Answer Box (A-G)</div>
                    <div class="divide-y divide-fuchsia-100 text-sm">
                        <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>bulbs</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>cord</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>microphone</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">D</span>battery charger</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">E</span>lens</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">F</span>battery</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">G</span>camera</div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                    <div class="text-sm font-semibold text-gray-700 mb-3">Equipment Case Diagram</div>
                    <img src="{{ asset('images/listening/material9/listening2-equipment-case.png') }}" alt="Equipment case diagram labels" class="w-full h-[26rem] object-contain bg-white border border-gray-200 rounded-lg p-3">
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">5.</label><select name="q5" class="flex-1 rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500"><option value="">Select letter</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">6.</label><select name="q6" class="flex-1 rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500"><option value="">Select letter</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">7.</label><select name="q7" class="flex-1 rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500"><option value="">Select letter</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                <div class="flex items-center gap-3"><label class="w-40 text-sm text-gray-700">8.</label><select name="q8" class="flex-1 rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500"><option value="">Select letter</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
            </div>
            @endif
        </div>
    </div>
    @elseif(request()->get('practice') == 5)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-amber-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Plan Labeling</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Label the station plan (Questions 1-6)</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Choose <span class="font-bold">SIX</span> answers from the box and write the correct letters, <span class="font-bold">A-I</span>, next to questions 1-6.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-5">
                    <div class="text-sm font-semibold text-gray-700 mb-3">Plan</div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="h-20 border-2 border-gray-300 rounded-lg flex items-start justify-start p-2 text-lg font-bold text-gray-600">1</div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg flex items-start justify-start p-2 text-lg font-bold text-gray-600">2</div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg flex items-start justify-start p-2 text-lg font-bold text-gray-600">3</div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg col-span-2"></div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg flex items-start justify-start p-2 text-lg font-bold text-gray-600">4</div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg flex items-start justify-start p-2 text-lg font-bold text-gray-600">5</div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg col-span-2 flex items-start justify-start p-2 text-lg font-bold text-gray-600">6</div>
                        <div class="h-20 border-2 border-gray-300 rounded-lg"></div>
                    </div>
                </div>

                <div class="rounded-xl border border-amber-200 overflow-hidden">
                    <div class="bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">Answer Box (A-I)</div>
                    <div class="divide-y divide-amber-100 text-sm">
                        <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>cafe</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>information desk</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>baggage lockers</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">D</span>open-air bike parking</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">E</span>bike lockers</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">F</span>covered bike parking</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">G</span>ticket office</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">H</span>ticket machines</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">I</span>tourist information</div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">1.</label><select name="q1" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">4.</label><select name="q4" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">2.</label><select name="q2" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">5.</label><select name="q5" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">3.</label><select name="q3" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">6.</label><select name="q6" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 6)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-emerald-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Plan Labeling</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Label the shopping plan (Questions 7-12)</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Choose <span class="font-bold">SIX</span> answers from the box and write the correct letters, <span class="font-bold">A-I</span>, next to questions 7-12.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-5">
                    <div class="text-sm font-semibold text-gray-700 mb-3">Plan</div>
                    <div class="grid grid-cols-4 gap-2">
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg flex items-start p-1 font-bold text-gray-600">12</div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg flex items-start p-1 font-bold text-gray-600">11</div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg flex items-start p-1 font-bold text-gray-600">10</div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg flex items-start p-1 font-bold text-gray-600">9</div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg flex items-start p-1 font-bold text-gray-600">8</div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg flex items-start p-1 font-bold text-gray-600">7</div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                        <div class="h-16 border-2 border-gray-300 rounded-lg"></div>
                    </div>
                </div>

                <div class="rounded-xl border border-emerald-200 overflow-hidden">
                    <div class="bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">Answer Box (A-I)</div>
                    <div class="divide-y divide-emerald-100 text-sm">
                        <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>jewellery store</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>supermarket</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>menswear store</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">D</span>Music-Music store</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">E</span>baby clothes store</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">F</span>electronics store</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">G</span>food court</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">H</span>video store</div>
                        <div class="px-4 py-2"><span class="font-semibold mr-2">I</span>bookstore</div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">7.</label><select name="q7" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">10.</label><select name="q10" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">8.</label><select name="q8" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">11.</label><select name="q11" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">9.</label><select name="q9" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
                <div class="flex items-center gap-3"><label class="w-12 text-sm text-gray-700">12.</label><select name="q12" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">A-I</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option></select></div>
            </div>
        </div>
    </div>
    @endif

    @elseif($id == 1)
    @if(!request()->has('practice'))
    <!-- Material 1: Practice Selection Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="?practice=1" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-rose-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-rose-500 to-pink-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 1</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-rose-600 transition-colors">School Tuck Shops</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Multiple choice questions 1-7 about healthy food in schools.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>7 Questions</span>
                    <span>~10 mins</span>
                </div>
                <span class="text-rose-600 font-semibold group-hover:text-rose-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=2" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-orange-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 2</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-amber-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">Healthy Lifestyle Talk</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Multiple choice questions 8-15 about nutrition and exercise advice.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>8 Questions</span>
                    <span>~12 mins</span>
                </div>
                <span class="text-orange-600 font-semibold group-hover:text-orange-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=3" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 3</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h6M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Relay Race Matching</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Matching questions 1-24 about teams, colours, positions, and race-day announcements.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>24 Questions</span>
                    <span>~20 mins</span>
                </div>
                <span class="text-emerald-600 font-semibold group-hover:text-emerald-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=4" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-sky-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-sky-500 to-cyan-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 4</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-sky-100 to-cyan-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-sky-600 transition-colors">Teacher Matching (1-4)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Choose A-F to match teacher information for questions 1-4.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>4 Questions</span>
                    <span>~7 mins</span>
                </div>
                <span class="text-sky-600 font-semibold group-hover:text-sky-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=5" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-violet-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 5</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-violet-100 to-fuchsia-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-violet-600 transition-colors">Teacher Matching (5-8)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Choose A-F to match teacher information for questions 5-8.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>4 Questions</span>
                    <span>~7 mins</span>
                </div>
                <span class="text-violet-600 font-semibold group-hover:text-violet-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=6" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-amber-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 6</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Olympic Timeline (1-7)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Classification questions about the history of the Olympic Games.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>7 Questions</span>
                    <span>~9 mins</span>
                </div>
                <span class="text-amber-600 font-semibold group-hover:text-amber-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=7" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-lime-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-lime-500 to-emerald-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 7</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-lime-100 to-emerald-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-lime-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-lime-600 transition-colors">Flight History (8-14)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Classification questions about key milestones in flight development.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>7 Questions</span>
                    <span>~9 mins</span>
                </div>
                <span class="text-lime-600 font-semibold group-hover:text-lime-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>
    </div>
    @elseif(request()->get('practice') == 1 || request()->get('practice') == 2 || request()->get('practice') == 3)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 {{ request()->get('practice') == 1 ? 'border-rose-500' : (request()->get('practice') == 2 ? 'border-orange-500' : 'border-emerald-500') }} p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 {{ request()->get('practice') == 1 ? 'bg-rose-50' : (request()->get('practice') == 2 ? 'bg-orange-50' : 'bg-emerald-50') }} rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 {{ request()->get('practice') == 1 ? 'bg-rose-100 text-rose-700' : (request()->get('practice') == 2 ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700') }} text-xs font-bold uppercase tracking-wider rounded-full">{{ request()->get('practice') == 1 ? 'Listening 1' : (request()->get('practice') == 2 ? 'Listening 2' : 'Listening 3') }}</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">{{ request()->get('practice') == 3 ? 'Matching' : 'Multiple Choice' }}</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">{{ request()->get('practice') == 1 ? 'School Tuck Shops - Multiple Choice' : (request()->get('practice') == 2 ? 'Healthy Lifestyle - Multiple Choice' : 'Relay Race - Matching Information') }}</h3>
            </div>
            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">{!! request()->get('practice') == 3 ? 'Choose your answers from the box and write the correct letters for each question.' : 'Choose the correct letter, <span class="font-bold">A, B, or C</span>.' !!}</p>
                </div>
            </div>
            <div class="space-y-6">
                @if(request()->get('practice') == 1)
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">1. What are they doing in school tuck shops?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q1" value="A" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>selling more wholesome food</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q1" value="B" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>selling more junk food</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q1" value="C" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>offering more meat pies and sausage rolls</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">2. What do most adults think about this?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q2" value="A" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>It's a bad idea.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q2" value="B" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>It's a good idea.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q2" value="C" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>Tuck shops should sell more cream doughnuts.</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">3. Which opinion is NOT expressed?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q3" value="A" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>Children should be free to decide what they eat.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q3" value="B" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>There should be more sport at school.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q3" value="C" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>The school is responsible for teaching healthy eating to children.</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">4. What will some of the children do?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q4" value="A" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>bring healthy food from home</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q4" value="B" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>buy junk food on the way to school</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q4" value="C" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>bring junk food from home</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">5. How much does it cost for chicken and chips?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q5" value="A" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>$4.00</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q5" value="B" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>$4.50</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q5" value="C" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>$2.50</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">6. How could parents be educated about healthy eating?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q6" value="A" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>magazine advertisements</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q6" value="B" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>public meetings</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q6" value="C" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>advertisements on television</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">7. How can schools help children eat healthily?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q7" value="A" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>check children's lunchboxes</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q7" value="B" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>sell mainly healthy food</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-rose-50 cursor-pointer transition-colors group"><input type="radio" name="q7" value="C" class="w-5 h-5 text-rose-600 border-gray-300 focus:ring-rose-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>ban junk food in school</span></label></div></div>
                @elseif(request()->get('practice') == 2)
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">8. Mr. White is a</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q8" value="A" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>nutritionist.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q8" value="B" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>school principal.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q8" value="C" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>health expert.</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">9. The children will be happier and healthier by</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q9" value="A" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>eating less fruit and vegetables.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q9" value="B" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>eating greater amounts of fast food.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q9" value="C" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>eating greater amounts of fruit and vegetables.</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">10. How many servings of vegetables per day do health specialists recommend?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q10" value="A" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>five</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q10" value="B" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>two</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q10" value="C" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>three</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">11. What happens to people when they don't eat breakfast?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q11" value="A" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>They feel tired.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q11" value="B" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>They usually eat a banana late in the morning.</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q11" value="C" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>They don't feel hungry at lunchtime.</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">12. Which food item is NOT suggested for lunch?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q12" value="A" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>a wholesome sandwich</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q12" value="B" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>steamed vegetables</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q12" value="C" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>fried chicken</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">13. What recommendations does the speaker make for summer?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q13" value="A" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>select green, white, and purple vegetables</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q13" value="B" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>make a salad with uncooked vegetables</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q13" value="C" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>use a high-fat cooking method</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">14. How much exercise per day does she recommend for young people?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q14" value="A" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>30 minutes</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q14" value="B" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>13 minutes</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q14" value="C" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>20 minutes</span></label></div></div>
                <div class="bg-white border border-gray-200 rounded-xl p-5"><h4 class="text-lg font-semibold text-gray-900 mb-4">15. What should children do if they can't walk or bike to school?</h4><div class="space-y-3 pl-2"><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q15" value="A" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">A.</span>take a taxi</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q15" value="B" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">B.</span>play sports with friends</span></label><label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-orange-50 cursor-pointer transition-colors group"><input type="radio" name="q15" value="C" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500"><span class="text-gray-700 font-medium"><span class="font-bold mr-2">C.</span>join a chess club</span></label></div></div>
                @else
                @if(!request()->has('section'))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="?practice=3&section=1" class="group block bg-white rounded-2xl shadow-md border border-emerald-100 hover:border-emerald-300 hover:shadow-xl transition-all duration-300 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                            <span class="text-xs text-gray-500">Q1-Q12</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-emerald-600">Teams, Colours, and Events</h4>
                        <p class="text-sm text-gray-600">Matching set about athletes, colleges, and race event times.</p>
                    </a>
                    <a href="?practice=3&section=2" class="group block bg-white rounded-2xl shadow-md border border-cyan-100 hover:border-cyan-300 hover:shadow-xl transition-all duration-300 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                            <span class="text-xs text-gray-500">Q13-Q24</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-cyan-600">Positions and After-Race Phrases</h4>
                        <p class="text-sm text-gray-600">Matching set about positions before the race and announcements after the race.</p>
                    </a>
                </div>
                @elseif(request()->get('section') == 1)
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <p class="text-lg font-semibold text-gray-900 mb-2">Questions 1 - 4</p>
                    <p class="text-gray-600 mb-4">Choose your answers from the box. Write the correct letters, A - D, next to questions 1 - 4.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-emerald-200 overflow-hidden">
                            <div class="bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">Athletes</div>
                            <div class="divide-y divide-emerald-100 text-sm">
                                <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>Andy</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>Pete</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>Robbie</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">D</span>Dave</div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">1. first runner</label><select name="q1" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">2. second runner</label><select name="q2" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">3. third runner</label><select name="q3" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">4. fourth runner</label><select name="q4" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option></select></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <p class="text-lg font-semibold text-gray-900 mb-2">Questions 5 - 7</p>
                    <p class="text-gray-600 mb-4">Choose your answers from the box. Write the correct letters, A - C, next to questions 5 - 7.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-emerald-200 overflow-hidden">
                            <div class="bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">Teams</div>
                            <div class="divide-y divide-emerald-100 text-sm">
                                <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>Lancaster College</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>Ashgrove College</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>Highland Park</div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3"><label class="w-24 text-sm text-gray-700">5. green</label><select name="q5" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-24 text-sm text-gray-700">6. red</label><select name="q6" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-24 text-sm text-gray-700">7. white</label><select name="q7" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option></select></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <p class="text-lg font-semibold text-gray-900 mb-2">Questions 8 - 12</p>
                    <p class="text-gray-600 mb-4">Choose your answers from the box. Write the correct letters, A - E, next to questions 8 - 12.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-emerald-200 overflow-hidden">
                            <div class="bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">Events</div>
                            <div class="divide-y divide-emerald-100 text-sm">
                                <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>hurdles</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>high jump</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>100-metre sprint</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">D</span>long jump</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">E</span>400-metre relay</div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">8. 1 p.m.</label><select name="q8" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">9. 1:30 p.m.</label><select name="q9" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">10. 3 p.m.</label><select name="q10" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">11. 4:30 p.m.</label><select name="q11" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-28 text-sm text-gray-700">12. 5 p.m.</label><select name="q12" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option></select></div>
                        </div>
                    </div>
                </div>

                @elseif(request()->get('section') == 2)
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="mb-2 text-xs font-bold uppercase tracking-wide text-emerald-700">Listening 2</div>
                    <p class="text-lg font-semibold text-gray-900 mb-2">Questions 13 - 18</p>
                    <p class="text-gray-700 mb-1">What do the athletes say before the race about people's positions?</p>
                    <p class="text-gray-600 mb-4">Choose your answers from the box. Write the correct letters, A - G, next to questions 13 - 18.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-emerald-200 overflow-hidden">
                            <div class="bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">People</div>
                            <div class="divide-y divide-emerald-100 text-sm">
                                <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>Catherine</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>Elizabeth</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>Thomas</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">D</span>Jeremy</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">E</span>Tony</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">F</span>Felicity</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">G</span>Matt</div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">13. on the start line</label><select name="q13" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">14. beside the first jump</label><select name="q14" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">15. at the registration table</label><select name="q15" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">16. in the timekeeper's tent</label><select name="q16" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">17. beside the water jump</label><select name="q17" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">18. at the First Aid tent</label><select name="q18" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option></select></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <p class="text-lg font-semibold text-gray-900 mb-2">Questions 19 - 24</p>
                    <p class="text-gray-700 mb-1">What is said after the race?</p>
                    <p class="text-gray-600 mb-4">Choose your answers from the box. Write the correct letters, A - K, next to questions 19 - 24.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-emerald-200 overflow-hidden">
                            <div class="bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">Phrases</div>
                            <div class="divide-y divide-emerald-100 text-sm">
                                <div class="px-4 py-2"><span class="font-semibold mr-2">A</span>everyone</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">B</span>next week</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">C</span>next year</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">D</span>to the winners</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">E</span>in the kitchen</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">F</span>in the club rooms</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">G</span>in the shower block</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">H</span>to all the helpers</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">I</span>to see</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">J</span>to eat</div>
                                <div class="px-4 py-2"><span class="font-semibold mr-2">K</span>in the car park</div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">19. Congratulations</label><select name="q19" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">20. Well done</label><select name="q20" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">21. There's tea and coffee</label><select name="q21" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">22. There's plenty</label><select name="q22" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">23. Thank you</label><select name="q23" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option></select></div>
                            <div class="flex items-center gap-3"><label class="w-44 text-sm text-gray-700">24. See you</label><select name="q24" class="flex-1 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option></select></div>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 4)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-sky-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-sky-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 4</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Matching</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">What do the students say about each teacher?</h3>
            </div>
            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Choose your answers from the box and write the correct letters, <span class="font-bold">A-F</span>, next to questions <span class="font-bold">1-4</span>. 'F' has already been done as an example.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-xl border border-sky-200 overflow-hidden bg-sky-50/50">
                    <div class="divide-y divide-sky-100 text-base">
                        <div class="px-4 py-3"><span class="font-semibold mr-2">A</span>Mr. Smith</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">B</span>Miss Williams</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">C</span>Mr. Jones</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">D</span>Mrs. Brown</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">E</span>Mr. Harris</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">F</span>Ms. Taylor</div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 p-3 bg-white"><span class="text-gray-700 italic">Example: teaches art history</span><span class="font-bold text-lg">F</span></div>
                    <div class="flex items-center gap-3"><label class="w-72 text-sm text-gray-700">1. is new to the school</label><select name="q1" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-72 text-sm text-gray-700">2. teaches geography</label><select name="q2" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-72 text-sm text-gray-700">3. only teaches the upper classes</label><select name="q3" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-72 text-sm text-gray-700">4. is often sick</label><select name="q4" class="flex-1 rounded-lg border-gray-300 focus:border-sky-500 focus:ring-sky-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option></select></div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 5)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-violet-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-violet-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-violet-100 text-violet-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 5</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Matching</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">What do the students say about each teacher?</h3>
            </div>
            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Choose your answers from the box and write the correct letters, <span class="font-bold">A-F</span>, next to questions <span class="font-bold">5-8</span>. 'F' has already been done as an example.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-xl border border-violet-200 overflow-hidden bg-violet-50/50">
                    <div class="divide-y divide-violet-100 text-base">
                        <div class="px-4 py-3"><span class="font-semibold mr-2">A</span>Ms. Palmer</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">B</span>Mr. Turner</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">C</span>Dr. Reed</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">D</span>Mrs. Fisher</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">E</span>Miss Edwards</div>
                        <div class="px-4 py-3"><span class="font-semibold mr-2">F</span>Mr. Green</div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 p-3 bg-white"><span class="text-gray-700 italic">Example: teaches German</span><span class="font-bold text-lg">F</span></div>
                    <div class="flex items-center gap-3"><label class="w-72 text-sm text-gray-700">5. teaches art history</label><select name="q5" class="flex-1 rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-72 text-sm text-gray-700">6. no longer works at the school</label><select name="q6" class="flex-1 rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-72 text-sm text-gray-700">7. is very strict</label><select name="q7" class="flex-1 rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-72 text-sm text-gray-700">8. teaches drama</label><select name="q8" class="flex-1 rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500"><option value="">Select</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option></select></div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 6)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-amber-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Classification</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Olympic Games Timeline</h3>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the classification questions. Write the correct letter, <span class="font-bold">A, B, or C</span>, next to questions 1-7.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h4 class="text-xl font-bold text-gray-900 mb-4">Questions 1-7</h4>
                <p class="text-gray-700 mb-3">When did the following events take place?</p>
                <div class="space-y-2 text-gray-800 mb-6">
                    <div><span class="font-semibold inline-block w-6">A</span> before 394 A.D.</div>
                    <div><span class="font-semibold inline-block w-6">B</span> between 1830 and 1896</div>
                    <div><span class="font-semibold inline-block w-6">C</span> after 1896</div>
                </div>
                <p class="text-gray-700 mb-4">Write the correct letter, A, B, or C, next to questions 1-7.</p>

                <div class="space-y-3">
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">1. women permitted to compete</label><select name="q1" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">2. wrestling added as an Olympic sport</label><select name="q2" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">3. Winter Games first held</label><select name="q3" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">4. seven sports with 84 separate events</label><select name="q4" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">5. International Olympic Committee founded</label><select name="q5" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">6. 11,000 athletes from 202 nations</label><select name="q6" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">7. first Games held after revival campaign</label><select name="q7" class="flex-1 rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 7)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-lime-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-lime-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-lime-100 text-lime-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Classification</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Flight Development Timeline</h3>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the classification questions. Write the correct letter, <span class="font-bold">A, B, or C</span>, next to questions 8-14.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h4 class="text-xl font-bold text-gray-900 mb-4">Questions 8-14</h4>
                <p class="text-gray-700 mb-3">When did the following events take place?</p>
                <div class="space-y-2 text-gray-800 mb-6">
                    <div><span class="font-semibold inline-block w-6">A</span> before 1900</div>
                    <div><span class="font-semibold inline-block w-6">B</span> between 1900 and 1910</div>
                    <div><span class="font-semibold inline-block w-6">C</span> after 1910</div>
                </div>
                <p class="text-gray-700 mb-4">Write the correct letter, A, B, or C, next to questions 8-14.</p>

                <div class="space-y-3">
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">8. Wright brothers flew 35 metres</label><select name="q8" class="flex-1 rounded-lg border-gray-300 focus:border-lime-500 focus:ring-lime-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">9. first flight by jet plane</label><select name="q9" class="flex-1 rounded-lg border-gray-300 focus:border-lime-500 focus:ring-lime-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">10. hot-air balloon flew with animal 'passengers'</label><select name="q10" class="flex-1 rounded-lg border-gray-300 focus:border-lime-500 focus:ring-lime-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">11. helicopter flew for 14 minutes</label><select name="q11" class="flex-1 rounded-lg border-gray-300 focus:border-lime-500 focus:ring-lime-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">12. gliders were flown successfully</label><select name="q12" class="flex-1 rounded-lg border-gray-300 focus:border-lime-500 focus:ring-lime-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">13. first manned helicopter flight</label><select name="q13" class="flex-1 rounded-lg border-gray-300 focus:border-lime-500 focus:ring-lime-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                    <div class="flex items-center gap-3"><label class="w-[32rem] text-gray-800">14. Cayley tried to solve the mystery of flight</label><select name="q14" class="flex-1 rounded-lg border-gray-300 focus:border-lime-500 focus:ring-lime-500"><option value="">A-C</option><option>A</option><option>B</option><option>C</option></select></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @elseif($id == 5)
    @if(!request()->has('practice'))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 items-stretch">
        <a href="?practice=1" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-indigo-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 1</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors min-h-[56px]">Exam Entry Form</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-1">Table completion about music examination entry form.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>10 Questions</span><span>~12 mins</span></div>
                <div class="mt-auto">
                    <span class="text-indigo-600 font-semibold group-hover:text-indigo-700 flex items-center gap-2">Start Soal 1 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
                </div>
            </div>
        </a>

        <a href="?practice=3" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-sky-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-sky-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 3</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-sky-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-sky-600 transition-colors min-h-[56px]">Phone Features Table</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-1">Complete table by writing Y to show features for each phone.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>Matrix Task</span><span>~8 mins</span></div>
                <div class="mt-auto">
                    <span class="text-sky-600 font-semibold group-hover:text-sky-700 flex items-center gap-2">Start Soal 3 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
                </div>
            </div>
        </a>

        <a href="?practice=4" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-cyan-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-cyan-500 to-teal-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 4</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-cyan-600 transition-colors min-h-[56px]">Phone Company Rates Table</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-1">Complete rate table and plans for Listening 2.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>8 Questions</span><span>~10 mins</span></div>
                <div class="mt-auto">
                    <span class="text-cyan-600 font-semibold group-hover:text-cyan-700 flex items-center gap-2">Start Soal 4 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
                </div>
            </div>
        </a>

        <a href="?practice=5" class="group block h-full bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-cyan-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative h-full flex flex-col">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-cyan-500 to-teal-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 5</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-cyan-600 transition-colors min-h-[56px]">Restaurant Menu (Listening 2)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-1">Part A multiple choice (7-9) and Part B menu form completion (10-14).</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>8 Questions</span><span>~10 mins</span></div>
                <div class="mt-auto">
                    <span class="text-cyan-600 font-semibold group-hover:text-cyan-700 flex items-center gap-2">Start Soal 5 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
                </div>
            </div>
        </a>
    </div>
    @elseif(request()->get('practice') == 1)
    <!-- Table Completion: Material 5 -->
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-indigo-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Table Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Woodlands School of Music - Examination Entry Form 2008</h3>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the form. Write <span class="font-bold">NO MORE THAN THREE WORDS AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-indigo-700 text-white">
                            <th class="p-4 text-left font-semibold w-[52%]">Field</th>
                            <th class="p-4 text-left font-semibold">Answer</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Candidate's name</td>
                            <td class="p-4 text-gray-900"><span class="text-gray-500 mr-2">Example</span> <span class="font-semibold italic">John Kepler</span></td>
                        </tr>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Grade exam this weekend</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">1</span>
                                    <span class="text-gray-600">Grade</span>
                                    <input type="text" name="q1" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Grade attained in 2007</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">2</span>
                                    <span class="text-gray-600">Grade</span>
                                    <input type="text" name="q2" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Instrument</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">3</span>
                                    <input type="text" name="q3" class="flex-1 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Date and time of examination</td>
                            <td class="p-4 space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">4</span>
                                    <span class="text-gray-600">Date: Saturday, July</span>
                                    <input type="text" name="q4" class="w-32 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">5</span>
                                    <span class="text-gray-600">Time:</span>
                                    <input type="text" name="q5" class="w-40 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Examination fee</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">6</span>
                                    <span class="text-gray-700 font-semibold">$</span>
                                    <input type="text" name="q6" class="w-40 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Examination room</td>
                            <td class="p-4 space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">7</span>
                                    <span class="text-gray-600">Room</span>
                                    <input type="text" name="q7" class="w-36 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">8</span>
                                    <span class="text-gray-600">in</span>
                                    <input type="text" name="q8" class="w-36 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                    <span class="text-gray-600">Block</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Candidate's choice of three pieces</td>
                            <td class="p-4 space-y-3">
                                <div class="text-gray-700">List A <span class="ml-6">No. 1</span></div>
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">9</span>
                                    <span class="text-gray-700">List B</span>
                                    <span class="text-gray-600">No.</span>
                                    <input type="text" name="q9" class="w-40 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                                <div class="text-gray-700">List C <span class="ml-6">No. 6</span></div>
                            </td>
                        </tr>
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">Number of scales candidates must play</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">10</span>
                                    <input type="text" name="q10" class="w-48 bg-transparent border-b-2 border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 text-gray-900 placeholder-gray-300" placeholder="...">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @elseif(request()->get('practice') == 3)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-sky-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-sky-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Table Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Mobile Phone Features Comparison</h3>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the table. Write <span class="font-bold">Y</span> in the table to show the features for each phone.</p>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-sky-700 text-white">
                            <th class="p-4 text-left font-semibold">Phone</th>
                            <th class="p-4 text-center font-semibold">Games</th>
                            <th class="p-4 text-center font-semibold">Camera</th>
                            <th class="p-4 text-center font-semibold">Internet connectivity</th>
                            <th class="p-4 text-center font-semibold">Voice recorder</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach(['LUNA 500', 'AQUILA 50', 'HERMES 580', 'RIVA A65'] as $idx => $phone)
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="p-4 font-semibold text-gray-800">{{ $phone }}</td>
                            <td class="p-4 text-center"><input type="checkbox" name="p3_{{ $idx }}_games" class="w-5 h-5 text-sky-600 border-gray-300 rounded"></td>
                            <td class="p-4 text-center"><input type="checkbox" name="p3_{{ $idx }}_camera" class="w-5 h-5 text-sky-600 border-gray-300 rounded"></td>
                            <td class="p-4 text-center"><input type="checkbox" name="p3_{{ $idx }}_internet" class="w-5 h-5 text-sky-600 border-gray-300 rounded"></td>
                            <td class="p-4 text-center"><input type="checkbox" name="p3_{{ $idx }}_voice" class="w-5 h-5 text-sky-600 border-gray-300 rounded"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @elseif(request()->get('practice') == 4)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-cyan-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-cyan-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Table Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Phone Company Rates Table</h3>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the table. Write <span class="font-bold">NO MORE THAN TWO WORDS AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-cyan-700 text-white">
                            <th class="p-4 text-left font-semibold">Plan</th>
                            <th class="p-4 text-center font-semibold">Monthly Fee</th>
                            <th class="p-4 text-center font-semibold">Call Rate (per min)</th>
                            <th class="p-4 text-center font-semibold">Data Quota</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-cyan-50/40 transition-colors">
                            <td class="p-4 font-semibold text-gray-800">Basic Plan</td>
                            <td class="p-4 text-center text-gray-900">$ <input type="text" name="q7" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"></td>
                            <td class="p-4 text-center text-gray-900"><input type="text" name="q8" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> cents</td>
                            <td class="p-4 text-center text-gray-900">2 GB</td>
                        </tr>
                        <tr class="hover:bg-cyan-50/40 transition-colors">
                            <td class="p-4 font-semibold text-gray-800">Family Plan</td>
                            <td class="p-4 text-center text-gray-900">$35</td>
                            <td class="p-4 text-center text-gray-900">10 cents</td>
                            <td class="p-4 text-center text-gray-900"><input type="text" name="q9" class="w-24 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"></td>
                        </tr>
                        <tr class="hover:bg-cyan-50/40 transition-colors">
                            <td class="p-4 font-semibold text-gray-800">Business Plan</td>
                            <td class="p-4 text-center text-gray-900">$ <input type="text" name="q10" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"></td>
                            <td class="p-4 text-center text-gray-900">5 cents</td>
                            <td class="p-4 text-center text-gray-900">Unlimited</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Questions 11-14</h4>
                <div class="space-y-4 text-gray-800">
                    <div>11. Customers on the Basic Plan get <input type="text" name="q11" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> free text messages each month.</div>
                    <div>12. The Family Plan includes free calls after <input type="text" name="q12" class="w-40 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> p.m.</div>
                    <div>13. Business users can add international calls for an extra $<input type="text" name="q13" class="w-24 border-b-2 border-gray-300 focus:border-cyan-500 outline-none">.</div>
                    <div>14. All plans require a minimum contract of <input type="text" name="q14" class="w-32 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> months.</div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 5)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-cyan-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-cyan-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Part A + Part B</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Restaurant Conversation - Menu Choices</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Part A:</p>
                    <p class="text-amber-700 text-sm">Choose the correct letter, <span class="font-bold">A, B, or C</span> for questions 7-9.</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">7. What is the name of the couple?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q7" value="A" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">A.</span>Mr. and Mrs. Watson</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q7" value="B" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">B.</span>Mr. and Mrs. Williams</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q7" value="C" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">C.</span>Mr. and Mrs. Wilson</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">8. Where do they decide to sit?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q8" value="A" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">A.</span>next to the window</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q8" value="B" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">B.</span>next to the door</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q8" value="C" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">C.</span>in the centre of the room</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">9. What number is their table?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q9" value="A" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">A.</span>14</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q9" value="B" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">B.</span>24</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-cyan-50 cursor-pointer transition-colors"><input type="radio" name="q9" value="C" class="w-5 h-5 text-cyan-600 border-gray-300 focus:ring-cyan-500"><span><span class="font-bold mr-2">C.</span>34</span></label>
                    </div>
                </div>
            </div>

            <div class="mt-8 mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Part B:</p>
                    <p class="text-amber-700 text-sm">Complete the form below. Write <span class="font-bold">NO MORE THAN THREE WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h4 class="text-xl font-bold text-center text-gray-900 mb-5">Menu</h4>
                <div class="space-y-4 text-gray-800">
                    <div class="grid grid-cols-[120px_1fr] gap-3 items-start">
                        <span class="font-semibold">Starters:</span>
                        <div class="space-y-2">
                            <div>green salad</div>
                            <div><span class="font-semibold mr-2">10.</span><input type="text" name="q10" class="w-72 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-[120px_1fr] gap-3 items-start">
                        <span class="font-semibold">Mains:</span>
                        <div class="space-y-2">
                            <div><span class="font-semibold mr-2">11.</span><input type="text" name="q11" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> <span class="ml-2">with potatoes</span></div>
                            <div><span class="font-semibold mr-2">12.</span><input type="text" name="q12" class="w-72 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-[120px_1fr] gap-3 items-start">
                        <span class="font-semibold">Desserts:</span>
                        <div><span class="font-semibold mr-2">13.</span><input type="text" name="q13" class="w-72 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"></div>
                    </div>
                    <div class="grid grid-cols-[120px_1fr] gap-3 items-start">
                        <span class="font-semibold">Drinks:</span>
                        <div class="space-y-2">
                            <div>coffee</div>
                            <div><span class="font-semibold mr-2">14.</span><input type="text" name="q14" class="w-72 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @elseif($id == 10)
    @if(!request()->has('practice'))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="?practice=1" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-amber-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 1</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Glass Recycling Process</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Flow-chart completion questions 1-10.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>10 Questions</span><span>~12 mins</span></div>
                <span class="text-amber-600 font-semibold group-hover:text-amber-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=2" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-cyan-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 2</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-cyan-600 transition-colors">Can Recycling Process</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Flow-chart completion questions 11-20.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>10 Questions</span><span>~12 mins</span></div>
                <span class="text-cyan-600 font-semibold group-hover:text-cyan-700 flex items-center gap-2">Start Practice <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=3" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-amber-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 3</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Soft Drink Factory Production Line</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Flow-chart completion questions 1-6.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>6 Questions</span><span>~10 mins</span></div>
                <span class="text-amber-600 font-semibold group-hover:text-amber-700 flex items-center gap-2">Start Soal 3 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=4" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-cyan-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 4</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-cyan-600 transition-colors">Chewing Gum Factory Production Line</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Flow-chart completion questions 7-13.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>7 Questions</span><span>~10 mins</span></div>
                <span class="text-cyan-600 font-semibold group-hover:text-cyan-700 flex items-center gap-2">Start Soal 4 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>
    </div>
    @elseif(request()->get('practice') == 1)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-amber-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Flow-Chart Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Glass Recycling Process</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the flow chart. Write <span class="font-bold">NO MORE THAN TWO WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="text-center text-gray-700">Glass bottles and jars cleaned in <input type="text" name="q1" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> water</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Collected in public <input type="text" name="q2" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> or picked up by</div>
                <div class="text-center text-gray-700"><input type="text" name="q3" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> companies</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Taken to a <input type="text" name="q4" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"></div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">EITHER bottles <input type="text" name="q5" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> and refilled</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">OR glass <input type="text" name="q6" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> into small pieces</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Glass mixed with <input type="text" name="q7" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center">, and limestone</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Melted in a <input type="text" name="q8" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"></div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">EITHER made into new <input type="text" name="q9" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> and <input type="text" name="q9b" class="w-36 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"></div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">OR used to make tiles or <input type="text" name="q10" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"></div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 2)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-cyan-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-cyan-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Flow-Chart Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Can Recycling Process</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the flow chart. Write <span class="font-bold">NO MORE THAN TWO WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="text-center text-gray-700">Cans collected in <input type="text" name="q11" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> or picked up from houses by trucks</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Checked for <input type="text" name="q12" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">, or other materials</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Taken to a <input type="text" name="q13" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"></div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Cut into <input type="text" name="q14" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> by a machine</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700"><input type="text" name="q15" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> in a hot furnace</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Poured into <input type="text" name="q16" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> to cool</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Heated and <input type="text" name="q17" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> thin</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Made into <input type="text" name="q18" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> by another machine</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Painted, dried, and <input type="text" name="q19" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"></div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">Filled with <input type="text" name="q20" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> and <input type="text" name="q20b" class="w-36 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"></div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 3)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-amber-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Flow-Chart Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Soft Drink Factory Production Line</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the flow chart. Write <span class="font-bold">ONE WORD</span> for each answer.</p>
                </div>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="text-center text-gray-700">water is filtered and sterilised in a large tank and then <span class="font-semibold">1.</span> <input type="text" name="q1" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> for quality</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">the <span class="font-semibold">2.</span> <input type="text" name="q2" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> flavours are made using a secret company recipe</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">these flavours are mixed with sugar to make <span class="font-semibold">3.</span> <input type="text" name="q3" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> which is sterilised and then added to the water</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700"><span class="font-semibold">4.</span> <input type="text" name="q4" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> are added when the drink is mixed with carbon dioxide in a carbonator</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">the drink is <span class="font-semibold">5.</span> <input type="text" name="q5" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> in bottles and cans</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">the bottles are labelled</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">the soft drinks are <span class="font-semibold">6.</span> <input type="text" name="q6" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none text-center"> around the country</div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 4)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-cyan-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-cyan-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Flow-Chart Completion</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Chewing Gum Factory Production Line</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Instructions:</p>
                    <p class="text-amber-700 text-sm">Complete the flow chart. Write <span class="font-bold">ONE WORD</span> for each answer.</p>
                </div>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="text-center text-gray-700">gum is <span class="font-semibold">7.</span> <input type="text" name="q7" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> from trees</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">it is <span class="font-semibold">8.</span> <input type="text" name="q8" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> and dried and the resulting product arrives at the factory</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">this is heated and <span class="font-semibold">9.</span> <input type="text" name="q9" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">, an important step to make sure the gum is clean</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">sugar syrup, <span class="font-semibold">10.</span> <input type="text" name="q10" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">, and colours are added to the hot gum</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">the gum is mixed until smooth in a round machine</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">another machine <span class="font-semibold">11.</span> <input type="text" name="q11" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> out the gum and then it is cooled before being cut into pieces</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">foil-wrapped pieces of gum are <span class="font-semibold">12.</span> <input type="text" name="q12" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> in packets</div>
                <div class="text-center text-2xl text-gray-500">↓</div>
                <div class="text-center text-gray-700">the packets are <span class="font-semibold">13.</span> <input type="text" name="q13" class="w-44 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center"> and boxed for distribution around the country</div>
            </div>
        </div>
    </div>
    @endif

    @elseif($id == 11)
    @if(!request()->has('practice'))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <a href="?practice=1" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 1</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Comparison of Three Digital Cameras</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Part A notes completion (1-9) and Part B table completion (10-14).</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>14 Questions</span><span>~15 mins</span></div>
                <span class="text-emerald-600 font-semibold group-hover:text-emerald-700 flex items-center gap-2">Start Listening 1 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=2" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-indigo-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Listening 2</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Comparison of Three Notebook Computers</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Part B matching questions (24-26) with options A-G.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>3 Questions</span><span>~8 mins</span></div>
                <span class="text-indigo-600 font-semibold group-hover:text-indigo-700 flex items-center gap-2">Start Listening 2 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=3" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-amber-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 3</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Assessment Schedule (Listening 1)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Multiple choice (1-3) and table completion (4-10).</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>10 Questions</span><span>~12 mins</span></div>
                <span class="text-amber-600 font-semibold group-hover:text-amber-700 flex items-center gap-2">Start Soal 3 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=4" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-cyan-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 4</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-cyan-600 transition-colors">Assessment Schedule (Listening 2)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Sentence completion (1-4) and value table (5-10).</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>10 Questions</span><span>~12 mins</span></div>
                <span class="text-cyan-600 font-semibold group-hover:text-cyan-700 flex items-center gap-2">Start Soal 4 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=5" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-teal-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-teal-500 to-cyan-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 5</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">Internet Safety Discussion (Listening 1)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Short-answer questions 1-4 and sentence completion 5-9.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>9 Questions</span><span>~12 mins</span></div>
                <span class="text-teal-600 font-semibold group-hover:text-teal-700 flex items-center gap-2">Start Soal 5 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=6" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-emerald-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-green-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 6</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h6M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Social Networking Risks (Listening 2)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Short-answer questions 10-12 and sentence completion 13-17.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>8 Questions</span><span>~11 mins</span></div>
                <span class="text-emerald-600 font-semibold group-hover:text-emerald-700 flex items-center gap-2">Start Soal 6 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=7" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-lime-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-lime-500 to-emerald-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 7</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-lime-100 to-emerald-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h7"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-lime-700 transition-colors">Tourism Effects (Listening 1)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Multiple choice questions 1-2 and note completion 3-7.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>7 Questions</span><span>~10 mins</span></div>
                <span class="text-lime-700 font-semibold group-hover:text-lime-800 flex items-center gap-2">Start Soal 7 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>

        <a href="?practice=8" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-sky-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-gradient-to-r from-sky-500 to-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md">Soal 8</span>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-sky-100 to-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-sky-700 transition-colors">Tourism Pollution (Listening 2)</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">Multiple choice questions 8-10 and matching 11-14.</p>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6"><span>7 Questions</span><span>~10 mins</span></div>
                <span class="text-sky-700 font-semibold group-hover:text-sky-800 flex items-center gap-2">Start Soal 8 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg></span>
            </div>
        </a>
    </div>
    @elseif(request()->get('practice') == 1)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-emerald-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Mixed Exercise</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Comparison of Three Digital Cameras</h3>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Part A:</p>
                    <p class="text-amber-700 text-sm">Complete the notes. Write <span class="font-bold">NO MORE THAN THREE WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="space-y-6 text-gray-800">
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">CF Superzoom:</h4>
                        <div class="space-y-2 pl-5">
                            <div>has <span class="font-semibold mr-1">1.</span><input type="text" name="q1" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> zoom</div>
                            <div>has <span class="font-semibold mr-1">2.</span><input type="text" name="q2" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> screen size</div>
                            <div>is <span class="font-semibold mr-1">3.</span><input type="text" name="q3" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> model</div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">Photo-Pal A23:</h4>
                        <div class="space-y-2 pl-5">
                            <div>has <span class="font-semibold mr-1">4.</span><input type="text" name="q4" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> megapixel count</div>
                            <div>screen is <span class="font-semibold mr-1">5.</span><input type="text" name="q5" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> size for viewing photos</div>
                            <div>warranty is <span class="font-semibold mr-1">6.</span><input type="text" name="q6" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> that for CF Superzoom</div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">QT Easishot:</h4>
                        <div class="space-y-2 pl-5">
                            <div>is <span class="font-semibold mr-1">7.</span><input type="text" name="q7" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> model</div>
                            <div>has <span class="font-semibold mr-1">8.</span><input type="text" name="q8" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> megapixel count</div>
                            <div>screen is <span class="font-semibold mr-1">9.</span><input type="text" name="q9" class="w-52 border-b-2 border-gray-300 focus:border-emerald-500 outline-none"> size</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Part B:</p>
                    <p class="text-amber-700 text-sm">Complete the table. Write <span class="font-bold">NO MORE THAN TWO WORDS AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-emerald-700 text-white">
                            <th class="p-4 text-left font-semibold">Specifications</th>
                            <th class="p-4 text-center font-semibold">CF Superzoom</th>
                            <th class="p-4 text-center font-semibold">Photo-Pal A23</th>
                            <th class="p-4 text-center font-semibold">QT Easishot</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="p-4 font-semibold text-gray-800">Megapixels</td>
                            <td class="p-4 text-center">12</td>
                            <td class="p-4 text-center"><span class="font-semibold mr-1">10.</span><input type="text" name="q10" class="w-28 border-b-2 border-gray-300 focus:border-emerald-500 outline-none text-center"></td>
                            <td class="p-4 text-center">7</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-gray-800">Zoom range</td>
                            <td class="p-4 text-center"><span class="font-semibold mr-1">11.</span><input type="text" name="q11" class="w-28 border-b-2 border-gray-300 focus:border-emerald-500 outline-none text-center"></td>
                            <td class="p-4 text-center">4x</td>
                            <td class="p-4 text-center">3x</td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-gray-800">Screen size</td>
                            <td class="p-4 text-center">3.5 inches</td>
                            <td class="p-4 text-center">3 inches</td>
                            <td class="p-4 text-center"><span class="font-semibold mr-1">12.</span><input type="text" name="q12" class="w-28 border-b-2 border-gray-300 focus:border-emerald-500 outline-none text-center"></td>
                        </tr>
                        <tr>
                            <td class="p-4 font-semibold text-gray-800">Standard warranty</td>
                            <td class="p-4 text-center"><span class="font-semibold mr-1">13.</span><input type="text" name="q13" class="w-28 border-b-2 border-gray-300 focus:border-emerald-500 outline-none text-center"></td>
                            <td class="p-4 text-center">1-year warranty</td>
                            <td class="p-4 text-center"><span class="font-semibold mr-1">14.</span><input type="text" name="q14" class="w-28 border-b-2 border-gray-300 focus:border-emerald-500 outline-none text-center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 2)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-indigo-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider rounded-full">Mixed Exercise</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Comparison of Three Notebook Computers</h3>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Part B:</p>
                    <p class="text-amber-700 text-sm">Complete the matching questions. Write <span class="font-bold">ONE letter from A-G</span> beside each number.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="space-y-2 text-gray-800 text-lg">
                        <div><span class="font-bold mr-3">A</span>has a 266 MB graphic card</div>
                        <div><span class="font-bold mr-3">B</span>has a 15-inch screen</div>
                        <div><span class="font-bold mr-3">C</span>costs $1,950</div>
                        <div><span class="font-bold mr-3">D</span>has a 2.5 GB hard drive</div>
                        <div><span class="font-bold mr-3">E</span>costs $1,295</div>
                        <div><span class="font-bold mr-3">F</span>has a 3-year warranty</div>
                        <div><span class="font-bold mr-3">G</span>costs $899</div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 text-xl text-gray-900">
                        <span class="font-bold">24.</span>
                        <span>the Speedy Z</span>
                        <input type="text" name="q24" maxlength="1" class="ml-auto w-16 uppercase text-center border-b-2 border-gray-300 focus:border-indigo-500 outline-none" placeholder="A-G">
                    </div>
                    <div class="flex items-center gap-3 text-xl text-gray-900">
                        <span class="font-bold">25.</span>
                        <span>the Maestro Supalite</span>
                        <input type="text" name="q25" maxlength="1" class="ml-auto w-16 uppercase text-center border-b-2 border-gray-300 focus:border-indigo-500 outline-none" placeholder="A-G">
                    </div>
                    <div class="flex items-center gap-3 text-xl text-gray-900">
                        <span class="font-bold">26.</span>
                        <span>the Genius XT</span>
                        <input type="text" name="q26" maxlength="1" class="ml-auto w-16 uppercase text-center border-b-2 border-gray-300 focus:border-indigo-500 outline-none" placeholder="A-G">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 3)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-amber-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-amber-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Mixed Exercise</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Assessment Schedule</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 1-3:</p>
                    <p class="text-amber-700 text-sm">Choose the correct letter, <span class="font-bold">A, B, or C</span>.</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">1. Ms. Potts prefers to work with</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="A" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">A.</span>a computer.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="B" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">B.</span>a pencil and paper.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="C" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">C.</span>spreadsheets.</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">2. She believes it is essential to have</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="A" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">A.</span>a good system.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="B" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">B.</span>good old days.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="C" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">C.</span>one major assessment.</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">3. John thinks continuous assessment</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q3" value="A" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">A.</span>makes him sick.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q3" value="B" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">B.</span>affects his performance.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 cursor-pointer transition-colors"><input type="radio" name="q3" value="C" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500"><span><span class="font-bold mr-2">C.</span>is fair.</span></label>
                    </div>
                </div>
            </div>

            <div class="mt-8 mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 4-10:</p>
                    <p class="text-amber-700 text-sm">Complete the table below. Write <span class="font-bold">NO MORE THAN TWO WORDS AND/OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-amber-700 text-white">
                            <th class="p-4 text-left font-semibold w-40">Month</th>
                            <th class="p-4 text-left font-semibold">Assessment Schedule</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr><td class="p-4 font-semibold">January</td><td class="p-4">No assessment - summer holiday</td></tr>
                        <tr><td class="p-4 font-semibold">February</td><td class="p-4"><span class="font-semibold mr-1">4.</span><input type="text" name="q4" class="w-44 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> ; set essay topics</td></tr>
                        <tr><td class="p-4 font-semibold">March</td><td class="p-4">Field trip; <span class="font-semibold mr-1">5.</span><input type="text" name="q5" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> with photographs</td></tr>
                        <tr><td class="p-4 font-semibold">April</td><td class="p-4"><span class="font-semibold mr-1">6.</span><input type="text" name="q6" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> with visual aids. <span class="italic">Break.</span></td></tr>
                        <tr><td class="p-4 font-semibold">May</td><td class="p-4">A series of <span class="font-semibold mr-1">7.</span><input type="text" name="q7" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> (short-answer questions)</td></tr>
                        <tr><td class="p-4 font-semibold">June</td><td class="p-4">Mid-year exams</td></tr>
                        <tr><td class="p-4 font-semibold">July</td><td class="p-4"><span class="italic">Break.</span> <span class="font-semibold mr-1">8.</span><input type="text" name="q8" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"></td></tr>
                        <tr><td class="p-4 font-semibold">August</td><td class="p-4"><span class="font-semibold mr-1">9.</span><input type="text" name="q9" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"></td></tr>
                        <tr><td class="p-4 font-semibold">September</td><td class="p-4"><span class="font-semibold mr-1">10.</span><input type="text" name="q10" class="w-52 border-b-2 border-gray-300 focus:border-amber-500 outline-none"> . <span class="italic">Break.</span></td></tr>
                        <tr><td class="p-4 font-semibold">October</td><td class="p-4">Test</td></tr>
                        <tr><td class="p-4 font-semibold">November</td><td class="p-4">Final exam</td></tr>
                        <tr><td class="p-4 font-semibold">December</td><td class="p-4">No assessment - summer holiday</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 4)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-cyan-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-cyan-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Mixed Exercise</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Assessment Schedule</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 1-4:</p>
                    <p class="text-amber-700 text-sm">Complete the sentences below. Write <span class="font-bold">NO MORE THAN THREE WORDS OR NUMBERS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-4 text-gray-800 text-lg">
                <div><span class="font-semibold" style="color:#2563eb;">1.</span> Jim thinks he won't have a social life because of <input type="text" name="q1" class="w-64 border-b-2 border-gray-300 focus:border-cyan-500 outline-none">.</div>
                <div><span class="font-semibold" style="color:#2563eb;">2.</span> Last year, Jim enjoyed the <input type="text" name="q2" class="w-64 border-b-2 border-gray-300 focus:border-cyan-500 outline-none">.</div>
                <div><span class="font-semibold" style="color:#2563eb;">3.</span> The <input type="text" name="q3" class="w-64 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> is scheduled for September.</div>
                <div><span class="font-semibold" style="color:#2563eb;">4.</span> There are <input type="text" name="q4a" class="w-24 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> books and <input type="text" name="q4b" class="w-24 border-b-2 border-gray-300 focus:border-cyan-500 outline-none"> articles on the reading list.</div>
            </div>

            <div class="mt-8 mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 5-10:</p>
                    <p class="text-amber-700 text-sm">Complete the table below. Write <span class="font-bold">NO MORE THAN ONE WORD OR A NUMBER</span> for each answer.</p>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-cyan-700 text-white">
                            <th class="p-4 text-left font-semibold w-40">Month</th>
                            <th class="p-4 text-left font-semibold">Assessment Schedule</th>
                            <th class="p-4 text-center font-semibold w-32">Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr><td class="p-4 font-semibold">January</td><td class="p-4">No assessment - summer holiday</td><td class="p-4 text-center">-</td></tr>
                        <tr><td class="p-4 font-semibold">February</td><td class="p-4">Quiz; set essay topics</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">5.</span><input type="text" name="q5" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">March</td><td class="p-4">Field trip; poster with photographs</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">6.</span><input type="text" name="q6" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">April</td><td class="p-4">Oral presentation with visual aids. <span class="italic">Break.</span></td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">7.</span><input type="text" name="q7" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">May</td><td class="p-4">A series of quizzes (short-answer questions)</td><td class="p-4 text-center">10%</td></tr>
                        <tr><td class="p-4 font-semibold">June</td><td class="p-4">Mid-year exams</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">8.</span><input type="text" name="q8" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">July</td><td class="p-4"><span class="italic">Break.</span> 5,000-word essay</td><td class="p-4 text-center">10%</td></tr>
                        <tr><td class="p-4 font-semibold">August</td><td class="p-4">Research projects</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">9.</span><input type="text" name="q9" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">September</td><td class="p-4">Seminar. <span class="italic">Break.</span></td><td class="p-4 text-center">5%</td></tr>
                        <tr><td class="p-4 font-semibold">October</td><td class="p-4">Test</td><td class="p-4 text-center"><span class="font-semibold mr-1" style="color:#2563eb;">10.</span><input type="text" name="q10" class="w-16 border-b-2 border-gray-300 focus:border-cyan-500 outline-none text-center">%</td></tr>
                        <tr><td class="p-4 font-semibold">November</td><td class="p-4">Final exam</td><td class="p-4 text-center">20%</td></tr>
                        <tr><td class="p-4 font-semibold">December</td><td class="p-4">No assessment - summer holiday</td><td class="p-4 text-center">-</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 5)
    <div class="mb-8">
        <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-3xl p-8 border border-teal-100 mb-6">
            <h1 class="text-3xl font-black text-gray-900 mb-3 tracking-tight">Exercise 5: Internet Safety Discussion (Listening 1)</h1>
            <p class="text-gray-700 text-base mb-2">Questions 1-4: Answer the questions below. Write NO MORE THAN THREE WORDS for each answer.</p>
            <p class="text-gray-700 text-base">Questions 5-9: Complete the notes below. Write NO MORE THAN TWO WORDS for each answer.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Questions 1-4</h2>
            <ol class="space-y-5 text-gray-800 leading-relaxed" style="list-style: decimal; padding-left: 1.5rem;">
                <li>What made Yousef decide to use social media less?
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>Who does Sarah say is often responsible for online scams?
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>What does Sarah suggest people should use before opening suspicious links?
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>What kind of websites are becoming harder to distinguish from genuine ones?
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
            </ol>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Questions 5-9</h2>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">How to stay safe online:</h3>
            <ol class="space-y-5 text-gray-800 leading-relaxed" style="list-style: decimal; padding-left: 1.5rem;" start="5">
                <li>Never share your ____, even with friends.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>Use a ____ password for every account.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>Always check if the website uses ____ before entering personal data.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>Think before posting, as your online image can affect your ____.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>If you receive strange emails, report them to your internet ____.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
            </ol>
        </div>
    </div>
    @elseif(request()->get('practice') == 6)
    <div class="mb-8">
        <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-3xl p-8 border border-emerald-100 mb-6">
            <h1 class="text-3xl font-black text-gray-900 mb-3 tracking-tight">Exercise 6: Social Networking Risks (Listening 2)</h1>
            <p class="text-gray-700 text-base mb-2">Questions 10-12: Answer the questions below. Write NO MORE THAN THREE WORDS for each answer.</p>
            <p class="text-gray-700 text-base">Questions 13-17: Complete the notes below. Write NO MORE THAN TWO WORDS for each answer.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Questions 10-12</h2>
            <ol class="space-y-5 text-gray-800 leading-relaxed" style="list-style: decimal; padding-left: 1.5rem;" start="10">
                <li>How many social networking users does the speaker say there are globally?
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>What is one major danger of fake profile scams?
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>What can happen to students if they post inappropriate comments?
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
            </ol>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Questions 13-17</h2>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Online safety tips from the speaker:</h3>
            <ol class="space-y-5 text-gray-800 leading-relaxed" style="list-style: decimal; padding-left: 1.5rem;" start="13">
                <li>Keep your privacy settings at the highest ____.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>Avoid posting details about your ____ activities.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>Do not add online contacts you do not know in ____.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>Use ____ tools to check where profile photos appear online.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
                <li>Report suspicious users to the platform ____ team.
                    <input type="text" class="w-full mt-2 p-2 border rounded" placeholder="Your answer">
                </li>
            </ol>
        </div>
    </div>
    @elseif(request()->get('practice') == 7)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-lime-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-lime-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-lime-100 text-lime-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 1</span>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider rounded-full">Mixed Exercise</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Tourism: Benefits and Local Impact</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 1-2:</p>
                    <p class="text-amber-700 text-sm">Choose the correct answer, <span class="font-bold">A, B, or C</span>.</p>
                </div>
            </div>

            <div class="space-y-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">1. What are the two levels of tourism that are talked about?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-lime-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="A" class="w-5 h-5 text-lime-600 border-gray-300 focus:ring-lime-500"><span><span class="font-bold mr-2">A.</span>environmental and social</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-lime-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="B" class="w-5 h-5 text-lime-600 border-gray-300 focus:ring-lime-500"><span><span class="font-bold mr-2">B.</span>positive and negative</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-lime-50 cursor-pointer transition-colors"><input type="radio" name="q1" value="C" class="w-5 h-5 text-lime-600 border-gray-300 focus:ring-lime-500"><span><span class="font-bold mr-2">C.</span>global and local</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">2. How much air travel is a result of tourism?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-lime-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="A" class="w-5 h-5 text-lime-600 border-gray-300 focus:ring-lime-500"><span><span class="font-bold mr-2">A.</span>16%</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-lime-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="B" class="w-5 h-5 text-lime-600 border-gray-300 focus:ring-lime-500"><span><span class="font-bold mr-2">B.</span>60%</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-lime-50 cursor-pointer transition-colors"><input type="radio" name="q2" value="C" class="w-5 h-5 text-lime-600 border-gray-300 focus:ring-lime-500"><span><span class="font-bold mr-2">C.</span>66%</span></label>
                    </div>
                </div>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 3-7:</p>
                    <p class="text-amber-700 text-sm">Write <span class="font-bold">NO MORE THAN THREE WORDS</span> for each answer.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <p class="text-gray-800 leading-8">
                    It is also important to consider the effects of tourism on a
                    <span class="font-semibold mr-1">3.</span><input type="text" name="q3" class="w-44 border-b-2 border-gray-300 focus:border-lime-500 outline-none">
                    region and its people and economy.
                    <span class="font-semibold mr-1">4.</span><input type="text" name="q4" class="w-44 border-b-2 border-gray-300 focus:border-lime-500 outline-none">
                    creates a variety of jobs for all sorts of people. It also enables people to learn new skills and start their own small businesses. An additional benefit is that both tourists and local people can gain a
                    <span class="font-semibold mr-1">5.</span><input type="text" name="q5" class="w-44 border-b-2 border-gray-300 focus:border-lime-500 outline-none">
                    of other cultures and customs. Ideally, the money that is earned by tourism in a particular area will be used to improve
                    <span class="font-semibold mr-1">6.</span><input type="text" name="q6" class="w-44 border-b-2 border-gray-300 focus:border-lime-500 outline-none">
                    and health services for people in that area. Such income can also be used to build better
                    <span class="font-semibold mr-1">7.</span><input type="text" name="q7" class="w-44 border-b-2 border-gray-300 focus:border-lime-500 outline-none">
                    and rubbish disposal systems and to protect wildlife in the region.
                </p>
            </div>
        </div>
    </div>
    @elseif(request()->get('practice') == 8)
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl border-t-4 border-sky-500 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-sky-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative z-10 mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider rounded-full">Listening 2</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider rounded-full">Mixed Exercise</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 leading-tight">Tourism: Water Use and Pollution</h3>
            </div>

            <div class="mb-8 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 8-10:</p>
                    <p class="text-amber-700 text-sm">Choose the correct answer, <span class="font-bold">A, B, or C</span>.</p>
                </div>
            </div>

            <div class="space-y-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">8. How much water does a tropical golf course use?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q8" value="A" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">A.</span>the same amount as 60,000 villagers</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q8" value="B" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">B.</span>more than 60,000 villagers</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q8" value="C" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">C.</span>less than 60,000 villagers</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">9. What is a typical 'peak season' population increase?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q9" value="A" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">A.</span>twenty times</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q9" value="B" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">B.</span>seven times</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q9" value="C" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">C.</span>ten times</span></label>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">10. What happens if pollution is not well managed?</h4>
                    <div class="space-y-3 pl-2">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q10" value="A" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">A.</span>There are too many swimming pools.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q10" value="B" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">B.</span>Fewer tourists visit.</span></label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-sky-50 cursor-pointer transition-colors"><input type="radio" name="q10" value="C" class="w-5 h-5 text-sky-600 border-gray-300 focus:ring-sky-500"><span><span class="font-bold mr-2">C.</span>Poor countries need modern facilities.</span></label>
                    </div>
                </div>
            </div>

            <div class="mb-6 flex items-start p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-amber-800 font-medium mb-1">Questions 11-14:</p>
                    <p class="text-amber-700 text-sm">Write the correct letter, <span class="font-bold">A, B, C, or D</span>, next to each statement.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Which kind of pollution affects these places?</h4>
                    <div class="space-y-3 text-gray-800 text-lg">
                        <div><span class="font-bold mr-3">A</span>the Taj Mahal</div>
                        <div><span class="font-bold mr-3">B</span>Yellowstone Park</div>
                        <div><span class="font-bold mr-3">C</span>the Caribbean</div>
                        <div><span class="font-bold mr-3">D</span>the Philippines</div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 text-base text-gray-900">
                        <span class="font-bold">11.</span>
                        <span>Destruction of reefs and beaches</span>
                        <input type="text" name="q11" maxlength="1" class="ml-auto w-16 uppercase text-center border-b-2 border-gray-300 focus:border-sky-500 outline-none" placeholder="A-D">
                    </div>
                    <div class="flex items-center gap-3 text-base text-gray-900">
                        <span class="font-bold">12.</span>
                        <span>Rubbish problems</span>
                        <input type="text" name="q12" maxlength="1" class="ml-auto w-16 uppercase text-center border-b-2 border-gray-300 focus:border-sky-500 outline-none" placeholder="A-D">
                    </div>
                    <div class="flex items-center gap-3 text-base text-gray-900">
                        <span class="font-bold">13.</span>
                        <span>Air pollution and acid rain</span>
                        <input type="text" name="q13" maxlength="1" class="ml-auto w-16 uppercase text-center border-b-2 border-gray-300 focus:border-sky-500 outline-none" placeholder="A-D">
                    </div>
                    <div class="flex items-center gap-3 text-base text-gray-900">
                        <span class="font-bold">14.</span>
                        <span>Noise pollution</span>
                        <input type="text" name="q14" maxlength="1" class="ml-auto w-16 uppercase text-center border-b-2 border-gray-300 focus:border-sky-500 outline-none" placeholder="A-D">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @else
    <!-- Content Placeholder for other materials -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 min-h-[400px] flex flex-col items-center justify-center text-center">
        <div class="w-20 h-20 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Content Coming Soon</h2>
        <p class="text-gray-500 max-w-md mx-auto">
            The material for <strong>{{ $title }}</strong> is currently being prepared. Check back later for practice exercises and lessons.
        </p>
    </div>
    @endif
    
    {{-- Upload SRT Modal (Admin Only) --}}
    @if(Auth::user()->isAdmin())
           <div id="uploadSrtModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] items-center justify-center"
               onclick="if(event.target === this) { this.classList.add('hidden'); this.classList.remove('flex'); }">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Upload SRT Transcript</h3>
                    <button type="button" onclick="const modal=document.getElementById('uploadSrtModal'); modal.classList.add('hidden'); modal.classList.remove('flex');" 
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('assignments.ielts-academic.listening.material.upload-srt', ['id' => $id]) }}" 
                      method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="language" value="en" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500" checked>
                                <span class="text-gray-700">English 🇺🇸</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="language" value="id" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-gray-700">Indonesian 🇮🇩</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">SRT File (.srt - Max 2MB)</label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-indigo-500 transition-colors text-center cursor-pointer" onclick="document.getElementById('srtFileInput').click()">
                            <input type="file" id="srtFileInput" name="srt_file" accept=".srt"
                                   class="hidden" onchange="document.getElementById('srtFileName').textContent = this.files[0].name">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-500" id="srtFileName">Click to select file</span>
                        </div>
                    </div>

                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-2 bg-white text-sm text-gray-500 font-semibold">OR PASTE TEXT</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Paste SRT Content Directly</label>
                        <textarea name="srt_content" rows="4" 
                                  class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none placeholder-gray-400 text-sm font-mono"
                                  placeholder="1
00:00:10,000 --> 00:00:15,000
Start translating here..."></textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="const modal=document.getElementById('uploadSrtModal'); modal.classList.add('hidden'); modal.classList.remove('flex');"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                            Upload & Parse
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        {{-- Upload Audio Modal (Admin Only) --}}
           <div id="uploadAudioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] items-center justify-center"
               onclick="if(event.target === this) { this.classList.add('hidden'); this.classList.remove('flex'); }">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Upload Audio File</h3>
                    <button type="button" onclick="const modal=document.getElementById('uploadAudioModal'); modal.classList.add('hidden'); modal.classList.remove('flex');" 
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('assignments.ielts-academic.listening.material.upload-audio', ['id' => $id]) }}" 
                      method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Audio File (MP3, WAV, OGG - Max 50MB)</label>
                        <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,audio/*" required
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>

                    @if(isset($material) && $material->audio_file)
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-sm text-blue-800">
                                <span class="font-semibold">Current file:</span> 
                                {{ basename($material->audio_file) }}
                            </p>
                        </div>
                    @endif

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="const modal=document.getElementById('uploadAudioModal'); modal.classList.add('hidden'); modal.classList.remove('flex');"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
</div>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const audio = document.getElementById('mainAudio');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const playIcon = document.getElementById('playIcon');
        const pauseIcon = document.getElementById('pauseIcon');
        const progressBar = document.getElementById('progressBar');
        const progressHandle = document.getElementById('progressHandle');
        const progressContainer = document.getElementById('progressContainer');
        const currentTimeDisplay = document.getElementById('currentTime');
        const durationDisplay = document.getElementById('duration');

        if (!audio || !progressContainer) {
            console.warn('Audio player elements not found');
            return;
        }

        let isDragging = false;

        // Format time in MM:SS
        function formatTime(seconds) {
            if (isNaN(seconds)) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        // Toggle play/pause
        window.togglePlayPause = function() {
            if (audio.paused) {
                audio.play();
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
            } else {
                audio.pause();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            }
        };

        // Skip audio by seconds
        window.skipAudio = function(seconds) {
            if (audio && audio.duration) {
                const newTime = Math.max(0, Math.min(audio.duration, audio.currentTime + seconds));
                audio.currentTime = newTime;
            }
        };

        // Seek to position when clicking or dragging progress bar
        function seekAudio(event) {
            if (!audio.duration) return;
            
            const rect = progressContainer.getBoundingClientRect();
            const clientX = event.clientX || (event.touches ? event.touches[0].clientX : 0);
            const clickX = clientX - rect.left;
            const width = rect.width;
            
            if (width === 0) return;

            let percentage = clickX / width;
            percentage = Math.max(0, Math.min(1, percentage));
            
            const newTime = percentage * audio.duration;
            audio.currentTime = newTime;
        }

        // Mouse down on progress bar
        progressContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            seekAudio(e);
            e.preventDefault();
        });

        // Mouse move - drag to seek
        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                seekAudio(e);
            }
        });

        // Mouse up - stop dragging
        document.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
            }
        });

        // Touch support for mobile
        progressContainer.addEventListener('touchstart', (e) => {
            isDragging = true;
            const touch = e.touches[0];
            seekAudio(touch);
            e.preventDefault();
        });

        document.addEventListener('touchmove', (e) => {
            if (isDragging) {
                const touch = e.touches[0];
                seekAudio(touch);
            }
        });

        document.addEventListener('touchend', () => {
            if (isDragging) {
                isDragging = false;
            }
        });

        // Update progress bar and time display
        audio.addEventListener('timeupdate', () => {
            if (audio.duration && !isDragging) {
                const percentage = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = percentage + '%';
                progressHandle.style.left = percentage + '%';
                currentTimeDisplay.textContent = formatTime(audio.currentTime);
            }
        });

        // Set duration when metadata is loaded
        audio.addEventListener('loadedmetadata', () => {
            durationDisplay.textContent = formatTime(audio.duration);
        });

        // Reset play button when audio ends
        audio.addEventListener('ended', () => {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        });
        
        // Toggle transcript drawer
        window.toggleTranscriptDrawer = function() {
            const transcriptDrawer = document.getElementById('transcriptDrawer');
            if (transcriptDrawer) {
                if (transcriptDrawer.classList.contains('hidden')) {
                    transcriptDrawer.classList.remove('hidden');
                    transcriptDrawer.classList.add('flex');
                } else {
                    transcriptDrawer.classList.add('hidden');
                    transcriptDrawer.classList.remove('flex');
                }
            }
        };
    });
</script>
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
</style>
