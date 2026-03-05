<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Free Lessons</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md fixed h-full z-10 hidden md:block">
            <div class="p-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
                <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
            </div>
            
            @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTeacher()))
                 <!-- Admin/Teacher Sidebar (Same as Assignments) -->
                @include('components.admin-sidebar')
            @else
                <!-- Student Sidebar -->
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-gray-400 mb-4">MENU UTAMA</p>
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Assignments
                        </a>
                        <a href="{{ route('free-lesson') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-medium border-l-4 border-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            Free Lesson
                        </a>
                        <a href="{{ route('guest.free-tests') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                            Guest Free Tests
                        </a>
                    </nav>
                </div>
                
                <div class="absolute bottom-8 px-6 w-full">
                    <p class="text-xs font-semibold text-gray-400 mb-4">AKUN</p>
                    <nav class="space-y-2">
                         <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile
                        </a>
                         <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition w-full text-left">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Log Out
                            </button>
                        </form>
                    </nav>
                </div>
            @endif
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Free Lessons</h1>
                        <p class="text-gray-600 mt-1">Explore our free content and start learning today! 🚀</p>
                    </div>
                </div>
            </div>

            <!-- Free Lessons Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($freeLessons as $lesson)
                    @php
                        $colorClasses = [
                            'blue' => ['gradient' => 'from-blue-400 to-blue-600', 'btn' => 'bg-blue-500 hover:bg-blue-600'],
                            'green' => ['gradient' => 'from-green-400 to-green-600', 'btn' => 'bg-green-500 hover:bg-green-600'],
                            'purple' => ['gradient' => 'from-purple-400 to-purple-600', 'btn' => 'bg-purple-500 hover:bg-purple-600'],
                            'orange' => ['gradient' => 'from-orange-400 to-orange-600', 'btn' => 'bg-orange-500 hover:bg-orange-600'],
                            'red' => ['gradient' => 'from-red-400 to-red-600', 'btn' => 'bg-red-500 hover:bg-red-600'],
                            'teal' => ['gradient' => 'from-teal-400 to-teal-600', 'btn' => 'bg-teal-500 hover:bg-teal-600'],
                            'indigo' => ['gradient' => 'from-indigo-400 to-indigo-600', 'btn' => 'bg-indigo-500 hover:bg-indigo-600'],
                            'pink' => ['gradient' => 'from-pink-400 to-pink-600', 'btn' => 'bg-pink-500 hover:bg-pink-600'],
                            'yellow' => ['gradient' => 'from-yellow-400 to-yellow-600', 'btn' => 'bg-yellow-500 hover:bg-yellow-600 text-white'],
                            'cyan' => ['gradient' => 'from-cyan-400 to-cyan-600', 'btn' => 'bg-cyan-500 hover:bg-cyan-600'],
                        ];
                        $colors = $colorClasses[$lesson['color']] ?? $colorClasses['blue'];
                    @endphp
                    
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                        <!-- Header / Image Area -->
                         <div class="h-32 bg-gradient-to-br {{ $colors['gradient'] }} relative p-6 flex flex-col justify-end">
                            <h3 class="text-2xl font-bold text-white shadow-sm">{{ $lesson['title'] }}</h3>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <p class="text-gray-600 mb-6 leading-relaxed">{{ $lesson['description'] }}</p>
                            
                            <a href="{{ $lesson['route'] }}" class="block w-full text-center {{ $colors['btn'] }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                Start Lesson
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if(count($freeLessons) === 0)
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No free lessons available yet</h3>
                    <p class="mt-1 text-gray-500">Check back soon for new content!</p>
                </div>
            @endif

        </main>
    </div>
</body>
</html>
