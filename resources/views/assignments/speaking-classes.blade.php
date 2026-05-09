<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Speaking</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
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

        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2v4c0 1.105 1.343 2 3 2s3-.895 3-2V10c0-1.105-1.343-2-3-2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18h6a2 2 0 002-2v-3l4 3V5l-4 3V5a2 2 0 00-2-2H9a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-yellow-600 to-yellow-700 bg-clip-text text-transparent">
                                Speaking
                            </h1>
                            <p class="text-gray-600 mt-1">Pilih kelas dan mulai perjalanan belajarmu!</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.index') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                </div>

                <!-- Classes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Introductory Speaking -->
                    <div class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="h-32 bg-gradient-to-br from-rose-400 to-rose-600 relative overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-rose-600 shadow-sm">
                                Coming Soon
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Introductory Speaking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Kelas dasar berbicara Inggris untuk pemula.</p>
                            <div class="w-full text-center bg-rose-100 text-rose-500 font-bold py-3 px-6 rounded-xl text-sm mt-4">
                                Coming Soon
                            </div>
                        </div>
                    </div>

                    <!-- Intermediate Speaking -->
                    <div class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="h-32 bg-gradient-to-br from-amber-400 to-amber-600 relative overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-amber-600 shadow-sm">
                                Coming Soon
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Intermediate Speaking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Tingkatkan kemampuan berbicara Anda dengan kelas menengah yang komprehensif.</p>
                            <div class="w-full text-center bg-amber-100 text-amber-500 font-bold py-3 px-6 rounded-xl text-sm mt-4">
                                Coming Soon
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Speaking -->
                    <div class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="h-32 bg-gradient-to-br from-teal-400 to-teal-600 relative overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-teal-600 shadow-sm">
                                Coming Soon
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Advanced Speaking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Kuasai berbicara Inggris di level profesional dan akademik.</p>
                            <div class="w-full text-center bg-teal-100 text-teal-500 font-bold py-3 px-6 rounded-xl text-sm mt-4">
                                Coming Soon
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    @include('components.student-broadcaster')
</body>
</html>
