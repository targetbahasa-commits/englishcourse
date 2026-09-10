<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Grammar Practice</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-teal-50 via-cyan-50 to-emerald-50 overflow-x-hidden">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 transition-all duration-200 p-4 md:p-8 overflow-x-hidden min-w-0">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3 min-w-0 overflow-hidden">
                        <div class="p-3 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl shadow-lg shrink-0">
                            <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 overflow-hidden">
                            <h1 class="text-2xl md:text-4xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent truncate">
                                Grammar Practice
                            </h1>
                            <p class="text-gray-600 mt-1 text-sm md:text-base truncate">Pilih level latihan grammar yang ingin kamu kerjakan!</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.grammar-writing.classes') }}"
                        class="flex items-center justify-center gap-2 px-3 py-2 md:px-4 md:py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200 shrink-0 text-sm md:text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                </div>

                <!-- Classes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Introductory Practice -->
                    <div class="relative">
                        @if(!$accessIntroductory)
                            <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl">
                                <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi Introductory Grammar untuk membuka</span>
                            </div>
                        @endif
                        <a href="{{ $accessIntroductory ? route('assignments.grammar-writing.practice.level', 'introductory') : 'javascript:void(0)' }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg {{ $accessIntroductory ? 'hover:shadow-2xl hover:scale-105 hover:-translate-y-1' : '' }} transition-all duration-300 overflow-hidden border border-gray-100">
                            <div class="h-32 bg-gradient-to-br from-orange-400 to-orange-600 relative overflow-hidden shrink-0">
                                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                <div class="absolute bottom-4 left-6">
                                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                                <h3 class="text-lg font-bold text-gray-800 mb-1">Introductory Practice</h3>
                                <p class="text-gray-600 text-sm leading-relaxed flex-1">Latihan grammar level dasar untuk penulisan akademik.</p>
                                <div class="w-full text-center bg-orange-500 {{ $accessIntroductory ? 'hover:bg-orange-600' : '' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md {{ $accessIntroductory ? 'hover:shadow-lg' : '' }} mt-4">
                                    Start Practice
                                    <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Complexity Practice -->
                    <div class="relative">
                        @if(!$accessComplexity)
                            <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl">
                                <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi Complexity Grammar untuk membuka</span>
                            </div>
                        @endif
                        <a href="{{ $accessComplexity ? route('assignments.grammar-writing.practice.level', 'complexity') : 'javascript:void(0)' }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg {{ $accessComplexity ? 'hover:shadow-xl hover:-translate-y-1' : '' }} transition-all duration-300 overflow-hidden border border-gray-100">
                            <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 relative overflow-hidden shrink-0">
                                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                <div class="absolute bottom-4 left-6">
                                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                                <h3 class="text-lg font-bold text-gray-800 mb-1">Complexity Practice</h3>
                                <p class="text-gray-600 text-sm leading-relaxed flex-1">Latihan grammar struktur kalimat kompleks untuk penulisan lanjutan.</p>
                                <div class="w-full text-center bg-green-500 {{ $accessComplexity ? 'hover:bg-green-600' : '' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md {{ $accessComplexity ? 'hover:shadow-lg' : '' }} mt-4">
                                    Start Practice
                                    <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Proficiency Practice -->
                    <div class="relative">
                        @if(!$accessProficiency)
                            <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl">
                                <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi Proficiency Grammar untuk membuka</span>
                            </div>
                        @endif
                        <a href="{{ $accessProficiency ? route('assignments.grammar-writing.practice.level', 'proficiency') : 'javascript:void(0)' }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg {{ $accessProficiency ? 'hover:shadow-xl hover:-translate-y-1' : '' }} transition-all duration-300 overflow-hidden border border-gray-100">
                            <div class="h-32 bg-gradient-to-br from-purple-400 to-purple-600 relative overflow-hidden shrink-0">
                                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                <div class="absolute bottom-4 left-6">
                                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                                <h3 class="text-lg font-bold text-gray-800 mb-1">Proficiency Practice</h3>
                                <p class="text-gray-600 text-sm leading-relaxed flex-1">Latihan grammar tingkat mahir untuk penulisan akademik dan profesional.</p>
                                <div class="w-full text-center bg-purple-500 {{ $accessProficiency ? 'hover:bg-purple-600' : '' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md {{ $accessProficiency ? 'hover:shadow-lg' : '' }} mt-4">
                                    Start Practice
                                    <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <!-- All Grammar Practice -->
                <div class="mt-8 relative">
                    @if(!$accessAll)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi Fast Track atau selesaikan semua modul Grammar untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $accessAll ? route('assignments.grammar-writing.practice.level', 'all') : 'javascript:void(0)' }}" class="group relative flex flex-col md:flex-row items-center bg-white rounded-2xl shadow-lg {{ $accessAll ? 'hover:shadow-xl hover:-translate-y-1' : '' }} transition-all duration-300 overflow-hidden border border-gray-100 p-6 md:p-2 md:pr-6 gap-4 md:gap-0">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shrink-0 shadow-inner {{ $accessAll ? 'group-hover:scale-105' : '' }} transition-transform duration-300">
                            <svg class="w-8 h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="md:ml-6 flex-1 text-center md:text-left">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">All Grammar Practice</h3>
                            <p class="text-gray-600 text-sm">Latihan campuran (Mixed Practice) yang mencakup seluruh topik grammar dari dasar hingga mahir.</p>
                        </div>
                        <div class="w-full md:w-auto shrink-0 mt-2 md:mt-0">
                            <div class="bg-white text-blue-600 {{ $accessAll ? 'group-hover:bg-blue-600 group-hover:text-white' : '' }} font-bold py-2.5 px-6 rounded-xl transition-all duration-300 shadow-sm flex items-center justify-center md:justify-start gap-2">
                                Start All Practice
                                <svg class="w-5 h-5 transition-transform duration-300 {{ $accessAll ? 'group-hover:translate-x-1' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>



            </div>
        </main>
    </div>

    @include('components.student-broadcaster')


</body>
</html>
