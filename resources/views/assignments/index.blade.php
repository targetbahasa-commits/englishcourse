<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Assignments</title>
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
        @if(Auth::user()->isAdmin())
        @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
        @include('components.sidebar-teacher')
        @else
        @include('components.sidebar-student')
        @endif

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1
                                class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Assignment Programs</h1>
                            <p class="text-gray-600 mt-1">Choose your program and start your learning journey!</p>
                        </div>
                    </div>

                    @if(Auth::user()->isAdmin())
                    {{-- Admins manage programs through the Programs admin section --}}
                    <a href="{{ route('programs.index') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-md hover:shadow-lg text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Manage Programs
                    </a>
                    @endif
                </div>

                <!-- Programs Grid -->
                <div class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                        $isStudent = !Auth::user()->isAdmin() && !Auth::user()->isTeacher();
                        @endphp

                        <!-- Dynamic Programs -->
                        @foreach($programs as $program)
                        @php
                        $colorClasses = [
                        'blue' => ['bg' => 'bg-blue-500', 'hover' => 'hover:bg-blue-600', 'text' => 'text-blue-600',
                        'light' => 'bg-blue-50', 'gradient' => 'from-blue-400 to-blue-600'],
                        'green' => ['bg' => 'bg-green-500', 'hover' => 'hover:bg-green-600', 'text' => 'text-green-600',
                        'light' => 'bg-green-50', 'gradient' => 'from-green-400 to-green-600'],
                        'purple' => ['bg' => 'bg-purple-500', 'hover' => 'hover:bg-purple-600', 'text' =>
                        'text-purple-600', 'light' => 'bg-purple-50', 'gradient' => 'from-purple-400 to-purple-600'],
                        'orange' => ['bg' => 'bg-orange-500', 'hover' => 'hover:bg-orange-600', 'text' =>
                        'text-orange-600', 'light' => 'bg-orange-50', 'gradient' => 'from-orange-400 to-orange-600'],
                        'red' => ['bg' => 'bg-red-500', 'hover' => 'hover:bg-red-600', 'text' => 'text-red-600', 'light'
                        => 'bg-red-50', 'gradient' => 'from-red-400 to-red-600'],
                        'yellow' => ['bg' => 'bg-yellow-500', 'hover' => 'hover:bg-yellow-600', 'text' =>
                        'text-yellow-600', 'light' => 'bg-yellow-50', 'gradient' => 'from-yellow-400 to-yellow-600']
                        ];
                        $colors = $colorClasses[$program->color] ?? $colorClasses['blue'];

                        // Determine route based on program name
                        $routeName = '#';
                        if ($program->name === 'Grammar for Writing') {
                        $routeName = route('assignments.grammar-writing');
                        } elseif ($program->name === 'TOEFL ITP') {
                        $routeName = route('assignments.toefl-itp');
                        } elseif ($program->name === 'IELTS Academic') {
                        $routeName = route('assignments.ielts-academic');
                        } elseif ($program->name === 'PTE Academic') {
                        $routeName = route('assignments.pte-academic');
                        } elseif ($program->name === 'IELTS General') {
                        $routeName = route('assignments.ielts-general');
                        }
                        @endphp

                        <a href="{{ $routeName }}"
                            class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                            <!-- Gradient Header -->
                            <div class="h-32 bg-gradient-to-br {{ $colors['gradient'] }} relative overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                                </div>
                                <div class="absolute bottom-4 left-6">
                                    <div
                                        class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                        <svg class="w-8 h-8 {{ $colors['text'] }}" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            {!! $program->icon ?? '<path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>' !!}
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6 pt-8">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $program->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $program->description }}</p>

                                <!-- CTA Button -->
                                <div
                                    class="block w-full text-center {{ $colors['bg'] }} {{ $colors['hover'] }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                    Start Learning
                                    <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Decorative Element -->
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $colors['gradient'] }} opacity-5 rounded-full -mr-16 -mt-16 group-hover:opacity-10 transition-opacity duration-300">
                            </div>
                        </a>
                        @endforeach


                    </div>
                </div>
        </main>
    </div>

    @include('components.student-broadcaster')
</body>

</html>