<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PTE Academic - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent">PTE Academic</h1>
                            <p class="text-gray-600 mt-1">Comprehensive PTE Academic computer-based preparation! 🖥️</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Assignments
                    </a>
                </div>
            </div>

            <!-- Coming Soon Banner -->
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl p-6 mb-8 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Coming Soon! 🚀</h2>
                        <p class="text-orange-100 text-sm mt-1">PTE Academic materials are being prepared. Check back soon for a full suite of practice tests.</p>
                    </div>
                </div>
            </div>

            <!-- Sections Grid (Preview) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @php
                    $sections = [
                        ['title' => 'Speaking & Writing', 'desc' => 'Practice read aloud, repeat sentence, describe image, re-tell lecture, and essay tasks.', 'color' => 'orange', 'gradient' => 'from-orange-400 to-orange-600', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                        ['title' => 'Reading', 'desc' => 'Fill in the blanks, multiple choice, reorder paragraphs, and reading comprehension tasks.', 'color' => 'blue', 'gradient' => 'from-blue-400 to-blue-600', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['title' => 'Listening', 'desc' => 'Summarize spoken text, multiple choice, fill blanks, highlight correct summary.', 'color' => 'purple', 'gradient' => 'from-purple-400 to-purple-600', 'icon' => 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828'],
                        ['title' => 'Full Mock Test', 'desc' => 'Simulate a full computer-based PTE Academic exam with timed sections.', 'color' => 'red', 'gradient' => 'from-red-400 to-red-600', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                    ];
                @endphp
                @foreach($sections as $section)
                <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 opacity-70">
                    <div class="h-32 bg-gradient-to-br {{ $section['gradient'] }} relative overflow-hidden">
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-{{ $section['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $section['icon'] }}"></path></svg>
                            </div>
                        </div>
                        <div class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm text-gray-600 text-xs font-bold px-3 py-1 rounded-full">Coming Soon</div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $section['title'] }}</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $section['desc'] }}</p>
                        <button disabled class="block w-full text-center bg-gray-200 text-gray-400 font-bold py-3 px-6 rounded-xl cursor-not-allowed">
                            Coming Soon
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>
