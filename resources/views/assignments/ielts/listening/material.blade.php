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
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

<div class="container mx-auto px-4 py-8 max-w-5xl">
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Practice 1 Card (Enabled) -->
        <a href="{{ route('assignments.ielts-academic.listening.material', ['id' => 6, 'practice' => 1]) }}" 
           target="_blank"
           class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-purple-400 transform hover:-translate-y-1">
            <div class="p-8 relative">
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
                <div class="flex items-center justify-between">
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
        <a href="?practice=2" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-purple-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
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
                <div class="flex items-center justify-between">
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
        <a href="?practice=3" class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl overflow-hidden border-2 border-transparent hover:border-blue-300 transition-all duration-300 hover:-translate-y-2">
            <div class="p-8 relative">
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
                <div class="flex items-center justify-between">
                    <span class="text-blue-600 font-semibold group-hover:text-blue-700 flex items-center gap-2">
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
    @if(request()->get('practice') == 1)
    <!-- Practice 1 Content -->
    <div class="space-y-8">
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
                    <span class="text-sm font-bold text-indigo-900 line-clamp-1 hidden sm:inline">Audio Session - Latihan 1</span>
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
                           <button onclick="document.getElementById('uploadSrtModal').classList.remove('hidden')" class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload SRT">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Upload SRT
                            </button>
                           <button onclick="document.getElementById('uploadAudioModal').classList.remove('hidden')" class="px-3 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload Audio">
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
        <div id="transcriptDrawer" class="hidden border border-gray-300 rounded-lg mx-4 mb-4 bg-white h-80 overflow-hidden flex flex-col transition-all duration-300 ease-in-out shadow-md">
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
                       <button onclick="document.getElementById('uploadSrtModal').classList.remove('hidden')" class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload SRT">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Upload SRT
                        </button>
                       <button onclick="document.getElementById('uploadAudioModal').classList.remove('hidden')" class="px-3 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload Audio">
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
        <div id="transcriptDrawer" class="hidden border border-gray-300 rounded-lg mx-4 mb-4 bg-white h-80 overflow-hidden flex flex-col transition-all duration-300 ease-in-out shadow-md">
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
                           <button onclick="document.getElementById('uploadSrtModal').classList.remove('hidden')" class="px-3 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload SRT">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Upload SRT
                            </button>
                           <button onclick="document.getElementById('uploadAudioModal').classList.remove('hidden')" class="px-3 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-md relative z-10 text-sm" title="Upload Audio">
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
        <div id="transcriptDrawer" class="hidden border border-gray-300 rounded-lg mx-4 mb-4 bg-white h-80 overflow-hidden flex flex-col transition-all duration-300 ease-in-out shadow-md">
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
        <div id="uploadSrtModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center"
             onclick="if(event.target === this) this.classList.add('hidden')">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Upload SRT Transcript</h3>
                    <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" 
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
                        <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')"
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
        <div id="uploadAudioModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center"
             onclick="if(event.target === this) this.classList.add('hidden')">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Upload Audio File</h3>
                    <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" 
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
                        <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')"
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
                transcriptDrawer.classList.toggle('hidden');
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
