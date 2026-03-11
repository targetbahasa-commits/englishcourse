<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Phrasal Verbs - Target Bahasa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-green-50 via-emerald-50 to-teal-100 min-h-screen relative overflow-x-hidden">
    @include('components.impersonation-banner')
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-float" style="animation-delay: 4s;"></div>
    </div>

    <div class="flex min-h-screen relative z-10">
        <!-- Sidebar -->
        @auth
            @if(Auth::user()->isAdmin())
                @include('components.sidebar-admin')
            @elseif(Auth::user()->isTeacher())
                @include('components.sidebar-teacher')
            @elseif(Auth::user()->role === 'guest')
                @include('components.sidebar-guest')
            @else
                @include('components.sidebar-student')
            @endif
        @else
            @include('components.sidebar-guest')
        @endauth

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Header with Glassmorphism -->
            <div class="mb-8">
                <a href="{{ route('free-lesson') }}" class="inline-flex items-center text-green-600 hover:text-green-700 mb-6 font-medium transition-all hover:gap-3 gap-2 group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Free Lessons
                </a>
                
                <div class="glassmorphism rounded-3xl p-8 shadow-2xl border-2 border-white/50">
                    <div class="flex items-center gap-6 mb-4">
                        <div class="relative">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-500 via-green-600 to-emerald-600 rounded-3xl flex items-center justify-center shadow-2xl transform hover:rotate-6 transition-all duration-300 animate-gradient">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent mb-2">
                                Phrasal Verbs
                            </h1>
                            <p class="text-gray-700 text-lg font-medium">⚡ Learn Essential Phrasal Verbs from Basic to Advanced</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-4 mt-6">
                        <div class="flex items-center gap-2 bg-white/60 px-4 py-2 rounded-full shadow-md">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="font-bold text-gray-800">3 Levels</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/60 px-4 py-2 rounded-full shadow-md">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-bold text-gray-800">{{ collect($levels)->sum('count') }} Phrasal Verbs</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/60 px-4 py-2 rounded-full shadow-md">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="font-bold text-gray-800">100% Free</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Levels Grid with Enhanced Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($levels as $index => $levelData)
                @php
                    $colors = [
                        ['from' => 'from-green-400', 'to' => 'to-green-600', 'accent' => 'bg-green-500', 'light' => 'bg-green-50'],
                        ['from' => 'from-emerald-400', 'to' => 'to-emerald-600', 'accent' => 'bg-emerald-500', 'light' => 'bg-emerald-50'],
                        ['from' => 'from-teal-400', 'to' => 'to-teal-600', 'accent' => 'bg-teal-500', 'light' => 'bg-teal-50'],
                    ];
                    $color = $colors[$index % 3];
                @endphp
                
                <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border-2 border-gray-100 hover:border-transparent hover:scale-105 hover:-translate-y-2">
                    <!-- Card Header with Gradient Background -->
                    <div class="bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} p-5 rounded-t-2xl relative overflow-hidden">
                        <!-- Decorative Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -mr-16 -mt-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white rounded-full -ml-12 -mb-12"></div>
                        </div>
                        
                        <div class="relative z-10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                                    <span class="text-xl font-black text-white">{{ substr($levelData['level'], 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:rotate-180 transition-transform duration-500">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 relative z-10">
                        <h3 class="text-base font-bold text-gray-800 mb-3 transition-all duration-300 min-h-[3rem]">
                            {{ $levelData['title'] }}
                        </h3>
                        
                        <!-- Description Section -->
                        <div class="mb-4 {{ $color['light'] }} rounded-xl p-3 border border-gray-100">
                            <p class="text-xs font-bold text-gray-500 mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                DESCRIPTION:
                            </p>
                            <p class="text-xs text-gray-700 leading-relaxed">{{ $levelData['description'] }}</p>
                        </div>
                        
                        <!-- Action Button -->
                        <a href="{{ route('phrasal-verbs-level', strtolower($levelData['level'])) }}" class="relative z-20 block w-full bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} text-white py-2.5 px-4 rounded-xl font-bold text-sm hover:shadow-xl transition-all duration-300 text-center group/btn transform hover:scale-105">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 group-hover/btn:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Start Learning ({{ $levelData['count'] }} phrasal verbs)
                            </div>
                        </a>
                    </div>

                    <!-- Hover Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
                </div>
                @endforeach
            </div>

            <!-- Enhanced Info Section -->
            <div class="mt-12 glassmorphism rounded-3xl p-8 shadow-2xl border-2 border-white/50 relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full opacity-10 -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-br from-teal-400 to-green-600 rounded-full opacity-10 -ml-24 -mb-24"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-xl animate-gradient">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-3">About Phrasal Verbs</h3>
                            <p class="text-gray-700 mb-6 leading-relaxed">
                                Master essential phrasal verbs across <span class="font-bold text-green-600">3 proficiency levels</span>. 
                                Each level includes carefully selected phrasal verbs with translations, meanings, and example sentences to help you sound more natural in English.
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center gap-3 bg-white/60 p-4 rounded-2xl shadow-md hover:shadow-lg transition-all hover:scale-105">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-800 font-bold">100% Free</span>
                                </div>
                                <div class="flex items-center gap-3 bg-white/60 p-4 rounded-2xl shadow-md hover:shadow-lg transition-all hover:scale-105">
                                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-800 font-bold">Self-Paced</span>
                                </div>
                                <div class="flex items-center gap-3 bg-white/60 p-4 rounded-2xl shadow-md hover:shadow-lg transition-all hover:scale-105">
                                    <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-teal-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <span class="text-gray-800 font-bold">With Examples</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
