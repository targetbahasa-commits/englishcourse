<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - TOEFL ITP Vocabulary</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3FFFF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div class="relative w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto">
                
                <!-- Header Section -->
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent drop-shadow-sm">
                            TOEFL ITP Vocabulary
                        </h1>
                        <p class="mt-2 text-gray-600 text-lg">Master these 300 essential words to boost your TOEFL ITP score.</p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="bg-white px-6 py-4 rounded-2xl shadow-sm border border-orange-100 flex items-center gap-4">
                            <div class="bg-white p-3 rounded-full">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Vocabulary</p>
                                <p class="text-2xl font-bold text-gray-800">300 Words</p>
                            </div>
                        </div>
                        <a href="{{ route('assignments.toefl-itp') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-white border border-gray-200 transition-all font-medium text-sm shadow-sm group h-full self-stretch">
                            <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>

                <?php
                    // We load the 300 words generated in parts
                    $cat1 = include storage_path('app/vocabularies/toefl_vocab_1.php');
                    $cat2 = include storage_path('app/vocabularies/toefl_vocab_2.php');
                    $cat3 = include storage_path('app/vocabularies/toefl_vocab_3.php');
                    
                    // Combine all categories into one array
                    $vocabularyCategories = array_merge($cat1, $cat2, $cat3);
                ?>

                <!-- Vocabulary Categories -->
                <div class="space-y-12">
                    @foreach($vocabularyCategories as $categoryName => $words)
                    <div>
                        <div class="mb-6 flex items-center border-b border-gray-200 pb-4">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $categoryName }}</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($words as $index => $item)
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 overflow-hidden group">
                                <div class="h-2 w-full bg-gradient-to-r from-orange-400 to-orange-500"></div>
                                <div class="p-5 flex flex-col h-full">
                                    <div class="flex items-start justify-between mb-4">
                                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors">{{ $item['word'] }}</h3>
                                        <span class="bg-white text-indigo-600 text-xs font-bold px-2 py-1 rounded-lg">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <div class="mb-4 flex-grow">
                                        <p class="text-gray-700 text-sm font-medium mb-1">{{ $item['meaning'] }}</p>
                                        <p class="text-gray-500 text-sm italic">{{ $item['meaning_id'] }}</p>
                                    </div>
                                    <div class="mt-auto pt-3 border-t border-gray-100 bg-white rounded-lg p-3">
                                        <p class="text-gray-600 text-sm leading-relaxed"><span class="font-semibold text-gray-800 mix-blend-multiply">Example:</span> "{{ $item['example'] }}"</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Call to Action -->
                <div class="mt-16 mb-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 md:p-12 text-center shadow-xl">
                    <h2 class="text-3xl font-bold text-white mb-4">Ready to test your vocabulary?</h2>
                    <p class="text-indigo-100 mb-8 max-w-2xl mx-auto">Practice using these 300 essential words in context. Try our TOEFL ITP listening and structure practices to see them in action!</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('assignments.toefl-itp.structure') }}" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                            Go to Structure Practice
                        </a>
                        <a href="{{ route('assignments.toefl-itp.reading') }}" class="px-8 py-4 bg-indigo-500 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-1 hover:bg-indigo-400 transition-all duration-300">
                            Go to Reading Practice
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
