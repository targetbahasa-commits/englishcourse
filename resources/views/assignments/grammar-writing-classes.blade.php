<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Grammar for Writing</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Grammar for Writing{{ $mode === 'offline' ? ' (Offline)' : '' }}
                            </h1>
                            <p class="text-gray-600 mt-1">Pilih kelas dan mulai perjalanan belajarmu!</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('assignments.grammar-writing.my-scores') }}"
                            class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Nilai &amp; Koreksi Guru
                        </a>
                        <a href="{{ route('assignments.index', $mode === 'offline' ? ['tab' => 'offline'] : []) }}"
                            class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>

                <!-- Classes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Introductory Grammar for Writing -->
                    @if($accessIntroductory)
                    <a href="{{ route('assignments.grammar-writing.track', ['track' => 'introductory'] + ($mode === 'offline' ? ['mode' => 'offline'] : [])) }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-orange-400 to-orange-600 relative overflow-hidden shrink-0 {{ !$accessIntroductory ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            @if(!$accessIntroductory)
                                <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">
                                    🔒 Locked
                                </div>
                            @endif
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center {{ $accessIntroductory ? 'transform group-hover:rotate-6 transition-transform duration-300' : '' }}">
                                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Introductory Grammar for Writing</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Kelas dasar tata bahasa Inggris untuk penulisan akademik.</p>
                            @if($accessIntroductory)
                            <div class="w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
                                Start Learning
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                            @else
                            <a href="{{ route('brochure') }}" target="_blank" class="flex items-center justify-center gap-2 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition-all duration-300 text-sm mt-4">
                                Lihat Brosur Program
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </a>
                            @endif
                        </div>
                    @if($accessIntroductory)
                    </a>
                    @else
                    </div>
                    @endif

                    <!-- Complexity Grammar for Writing -->
                    @if($accessComplexity)
                    <a href="{{ route('assignments.grammar-writing.track', ['track' => 'complexity'] + ($mode === 'offline' ? ['mode' => 'offline'] : [])) }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 relative overflow-hidden shrink-0 {{ !$accessComplexity ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            @if($accessComplexity)
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-green-600 shadow-sm">
                                10 Meetings
                            </div>
                            @else
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">
                                🔒 Locked
                            </div>
                            @endif
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Complexity Grammar for Writing</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Penguasaan struktur kalimat kompleks untuk penulisan lanjutan.</p>
                            @if($accessComplexity)
                            <div class="w-full text-center bg-green-500 text-white font-bold py-3 px-6 rounded-xl text-sm mt-4 group-hover:bg-green-600 transition">
                                Start Learning
                            </div>
                            @else
                            <a href="{{ route('brochure') }}" target="_blank" class="flex items-center justify-center gap-2 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition-all duration-300 text-sm mt-4">
                                Lihat Brosur Program
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </a>
                            @endif
                        </div>
                    @if($accessComplexity)
                    </a>
                    @else
                    </div>
                    @endif

                    <!-- Proficiency Grammar for Writing -->
                    @if($accessProficiency)
                    <a href="{{ route('assignments.grammar-writing.track', ['track' => 'proficiency'] + ($mode === 'offline' ? ['mode' => 'offline'] : [])) }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-purple-400 to-purple-600 relative overflow-hidden shrink-0 {{ !$accessProficiency ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            @if($accessProficiency)
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-purple-600 shadow-sm">
                                10 Meetings
                            </div>
                            @else
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">
                                🔒 Locked
                            </div>
                            @endif
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Proficiency Grammar for Writing</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Tingkat mahir tata bahasa untuk penulisan akademik dan profesional.</p>
                            @if($accessProficiency)
                            <div class="w-full text-center bg-purple-500 text-white font-bold py-3 px-6 rounded-xl text-sm mt-4 group-hover:bg-purple-600 transition">
                                Start Learning
                            </div>
                            @else
                            <a href="{{ route('brochure') }}" target="_blank" class="flex items-center justify-center gap-2 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition-all duration-300 text-sm mt-4">
                                Lihat Brosur Program
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </a>
                            @endif
                        </div>
                    @if($accessProficiency)
                    </a>
                    @else
                    </div>
                    @endif

                    <!-- Fast Track Grammar for Writing -->
                    <div class="md:col-start-2 md:col-span-1">
                    @if($accessFastTrack)
                    <a href="{{ route('assignments.grammar-writing', $mode === 'offline' ? ['mode' => 'offline'] : []) }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1 w-full">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200 w-full">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden shrink-0 {{ !$accessFastTrack ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            @if(!$accessFastTrack)
                                <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">
                                    🔒 Locked
                                </div>
                            @endif
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center {{ $accessFastTrack ? 'transform group-hover:rotate-6 transition-transform duration-300' : '' }}">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Fast Track Grammar for Writing</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Kelas tata bahasa Inggris intensif yang akan mempersiapkanmu untuk kelas IELTS.</p>
                            @if($accessFastTrack)
                            <div class="w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
                                Start Learning
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                            @else
                            <a href="{{ route('brochure') }}" target="_blank" class="flex items-center justify-center gap-2 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition-all duration-300 text-sm mt-4">
                                Lihat Brosur Program
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </a>
                            @endif
                        </div>
                    @if($accessFastTrack)
                    </a>
                    @else
                    </div>
                    @endif
                    </div>

                </div>

                <!-- Practice Group -->
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Practice</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Grammar Practice -->
                        <div class="md:col-start-2 md:col-span-1">
                            <a href="{{ route('assignments.grammar-writing.practice') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1 w-full">
                                <div class="h-32 bg-gradient-to-br from-teal-400 to-teal-600 relative overflow-hidden shrink-0">
                                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                    <div class="absolute bottom-4 left-6">
                                        <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Grammar Practice</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed flex-1">Latihan grammar intensif untuk memantapkan pemahaman dasar dan lanjutan.</p>
                                    <div class="w-full text-center bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
                                        Start Practice
                                        <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    @include('components.student-broadcaster')
</body>
</html>
