<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Assignments</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
                @if(session('require_access_key'))
                    @php
                        $slug = session('require_access_key');
                        $program = $programs->firstWhere('slug', $slug);
                    @endphp
                    @if($program && $program->access_key)
                    <div class="max-w-lg mx-auto mb-8 bg-white border border-blue-200 rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold mb-2 text-blue-700">Access Key Required</h2>
                        <p class="mb-4 text-gray-600">Enter the access key to unlock <b>{{ $program->name }}</b>.</p>
                        @if(session('error'))
                            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('assignments.program-access.submit', $program->id) }}" class="flex flex-col gap-4">
                            @csrf
                            <input type="text" name="access_key" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter access key..." required autofocus>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">Submit</button>
                        </form>
                    </div>
                    @endif
                @endif
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <!-- Header -->
            <div class="mb-6 bg-white border border-gray-100 rounded-3xl p-4 md:p-6 shadow-sm overflow-hidden">
                <div class="flex justify-end items-center gap-2 mb-2">
                    @if(Auth::user()->isAdmin())
                        {{-- Admins manage programs through the Programs admin section --}}
                        <a href="{{ route('programs.index') }}"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-full transition-colors duration-200 shadow-sm shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Manage Programs</span>
                        </a>
                    @endif
                </div>

                <div class="flex items-center gap-3 md:gap-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg shrink-0">
                        <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1
                            class="text-2xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent truncate">
                            Assignment Programs</h1>
                        <p class="text-xs md:text-sm text-gray-600 mt-0.5 break-words">Choose your program and start your learning journey!</p>
                    </div>
                </div>
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
                    $programSlug = match ($program->slug) {
                    'grammar-writing',
                    'introductory-grammar-for-writing',
                    'complexity-grammar-for-writing',
                    'proficiency-grammar-for-writing',
                    'fast-track-grammar-for-writing' => 'grammar-for-writing',
                    'introductory-speaking',
                    'intermediate-speaking',
                    'advanced-speaking',
                    'proficiency-speaking',
                    'super-speaking' => 'speaking',
                    'speaking' => 'speaking',
                    'grammar-for-speaking' => 'speaking',
                    'ielts-academic-listening' => 'ielts-academic-listening',
                    'ielts-academic-reading' => 'ielts-academic-reading',
                    'ielts-academic-writing' => 'ielts-academic-writing',
                    'ielts-academic-speaking' => 'ielts-academic-speaking',
                    'ielts-academic-full-package' => 'ielts-academic',
                    'ielts-academic-all-sections' => 'ielts-academic',
                    default => $program->slug,
                    };

                    // Determine route based on program slug
                    $routeName = '#';
                    if ($programSlug === 'grammar-for-writing') {
                    $routeName = route('assignments.grammar-writing.classes');
                    } elseif ($programSlug === 'speaking') {
                    $routeName = route('assignments.speaking.classes');
                    } elseif ($programSlug === 'toefl-itp') {
                    $routeName = route('assignments.toefl-itp');
                    } elseif ($programSlug === 'ielts-academic-listening') {
                    $routeName = route('assignments.ielts-academic.listening.index');
                    } elseif ($programSlug === 'ielts-academic-reading') {
                    $routeName = route('assignments.ielts-academic.reading.index');
                    } elseif ($programSlug === 'ielts-academic-writing') {
                    $routeName = route('assignments.ielts-academic.writing.index');
                    } elseif ($programSlug === 'ielts-academic-speaking') {
                    $routeName = route('assignments.ielts-academic.speaking.index');
                    } elseif ($programSlug === 'ielts-academic') {
                    $routeName = route('assignments.ielts-academic');
                    } elseif ($programSlug === 'pte-academic') {
                    $routeName = route('assignments.pte-academic');
                    } elseif ($programSlug === 'ielts-general') {
                    $routeName = route('assignments.ielts-general');
                    }

                    $isLocked = $isStudent
                        && (empty($allowedAssignmentProgramSlugs) || !in_array($programSlug, $allowedAssignmentProgramSlugs, true));
                    @endphp

                    @php
                        $cardRoute = $routeName;
                        if ($cardRoute === '#') {
                            $cardRoute = route('student.payments.index');
                        }
                        $cardClasses = "group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1";
                        $lockedCardClasses = "group relative bg-white/95 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border-2 border-gray-200";
                    @endphp

                    <div class="{{ $isLocked ? $lockedCardClasses : $cardClasses }}">
                        <!-- Gradient Header -->
                        <div class="h-28 md:h-32 bg-gradient-to-br {{ $colors['gradient'] }} relative overflow-hidden">
                            <div class="absolute inset-0 bg-black {{ $isLocked ? 'opacity-20' : 'opacity-0 group-hover:opacity-10' }} transition-opacity duration-300"></div>
                            @if($isLocked)
                                <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">
                                    🔒 Locked
                                </div>
                            @endif
                            <div class="absolute bottom-4 left-6">
                                <div class="w-14 h-14 md:w-16 md:h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center {{ $isLocked ? '' : 'transform group-hover:rotate-6 transition-transform duration-300' }}">
                                    <svg class="w-7 h-7 md:w-8 md:h-8 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $program->icon ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>' !!}
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 md:p-6 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-800 mb-1 break-words">{{ $program->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed break-words">{{ $program->description }}</p>

                            @if($isLocked)
                                <a href="{{ route('student.payments.index', ['program_id' => $program->id]) }}" class="flex items-center justify-center gap-2 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition-all duration-300 text-sm">
                                    <span>Daftar Program Ini</span>
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            @else
                                <!-- Start Learning Button -->
                                <a href="{{ $cardRoute }}" class="w-full text-center {{ $colors['bg'] . ' ' . $colors['hover'] }} text-white font-bold py-3 px-4 md:px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <span>Start Learning</span>
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l5-5m5-5H6"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        <!-- Decorative Element -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $colors['gradient'] }} opacity-5 rounded-full -mr-16 -mt-16 group-hover:opacity-10 transition-opacity duration-300"></div>
                    </div>
                    @endforeach


                    </div>
                </div>
        </main>
    </div>

    @include('components.meetings-calendar-modal')
    @include('components.student-broadcaster')
</body>

</html>