<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Speaking Course</title>
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

        <main class="flex-1 md:ml-64 p-8 pb-24">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                Cambridge Curriculum
                            </h1>
                            <p class="text-gray-600 mt-1">Pilih level kelas speaking dan mulai perjalanan belajarmu!</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('assignments.speaking.classes') }}"
                            class="flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-white font-medium transition border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>

                <!-- Classes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- 1. First Point Speaking (Introductory) -->
                    @if($accessIntroductory)
                    <a href="{{ route('assignments.speaking.level', 'introductory') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-rose-500 to-rose-700 relative overflow-hidden shrink-0 {{ !$accessIntroductory ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                @if($accessIntroductory)
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-rose-700 shadow-sm">11 Meetings</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">🔒 Locked</span>
                                @endif
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center {{ $accessIntroductory ? 'transform group-hover:rotate-6 transition-transform duration-300' : '' }}">
                                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <span class="text-xs font-bold text-rose-600 uppercase tracking-wider mb-1">Level 1 (A1-A2 Foundation)</span>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">First Point Speaking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Kelas dasar intensif berbicara bahasa Inggris untuk pemula. Fokus pada salam, perkenalan diri, aktivitas sehari-hari, dan pola kalimat dasar.</p>
                            @if($accessIntroductory)
                            <div class="w-full text-center bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
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

                    <!-- 2. Second Point Speaking (Intermediate) -->
                    @if($accessIntermediate)
                    <a href="{{ route('assignments.speaking.level', 'intermediate') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-amber-500 to-orange-600 relative overflow-hidden shrink-0 {{ !$accessIntermediate ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                @if($accessIntermediate)
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-amber-700 shadow-sm">10 Meetings</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">🔒 Locked</span>
                                @endif
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center {{ $accessIntermediate ? 'transform group-hover:rotate-6 transition-transform duration-300' : '' }}">
                                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <span class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Level 2 (B1 Intermediate)</span>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Second Point Speaking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Tingkatkan kelancaran berbicara tingkat menengah dengan modal keharusan, degrees of certainty, dan percakapan opini mendalam.</p>
                            @if($accessIntermediate)
                            <div class="w-full text-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
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
                    @if($accessIntermediate)
                    </a>
                    @else
                    </div>
                    @endif

                    <!-- 3. Third Point Speaking (Advanced) -->
                    @if($accessAdvanced)
                    <a href="{{ route('assignments.speaking.level', 'advanced') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-600 relative overflow-hidden shrink-0 {{ !$accessAdvanced ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                @if($accessAdvanced)
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-teal-700 shadow-sm">10 Meetings</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">🔒 Locked</span>
                                @endif
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center {{ $accessAdvanced ? 'transform group-hover:rotate-6 transition-transform duration-300' : '' }}">
                                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <span class="text-xs font-bold text-teal-600 uppercase tracking-wider mb-1">Level 3 (B2 Advanced)</span>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Third Point Speaking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Kuasai berbicara bahasa Inggris di level profesional & akademik. Past Modals deduction, Passive Voice, Causative Verbs, dan debat.</p>
                            @if($accessAdvanced)
                            <div class="w-full text-center bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
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
                    @if($accessAdvanced)
                    </a>
                    @else
                    </div>
                    @endif

                    <!-- 4. Fourth Point Speaking (Proficiency) -->
                    @if($accessProficiency)
                    <a href="{{ route('assignments.speaking.level', 'proficiency') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-indigo-600 to-purple-600 relative overflow-hidden shrink-0 {{ !$accessProficiency ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                @if($accessProficiency)
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-purple-700 shadow-sm">10 Meetings</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">🔒 Locked</span>
                                @endif
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center {{ $accessProficiency ? 'transform group-hover:rotate-6 transition-transform duration-300' : '' }}">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <span class="text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">Level 4 (C1-C2 Masterclass)</span>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Fourth Point Speaking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Kuasai retorika C2, diplomasi tingkat eksekutif, counterfactual argument, dan capstone keynote speech berdaya pikat tinggi.</p>
                            @if($accessProficiency)
                            <div class="w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
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
                    @if($accessProficiency)
                    </a>
                    @else
                    </div>
                    @endif

                    <!-- 5. Super Point Speaking (Super Mastery) -->
                    @if($accessSuper)
                    <a href="{{ route('assignments.speaking.level', 'super') }}" class="group relative flex flex-col bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    @else
                    <div class="group relative flex flex-col bg-white/95 rounded-2xl shadow-lg transition-all duration-300 overflow-hidden border-2 border-gray-200">
                    @endif
                        <div class="h-32 bg-gradient-to-br from-fuchsia-600 to-rose-600 relative overflow-hidden shrink-0 {{ !$accessSuper ? 'opacity-60' : '' }}">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 right-4">
                                @if($accessSuper)
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-fuchsia-700 shadow-sm">10 Meetings</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-gray-700 shadow-sm">🔒 Locked</span>
                                @endif
                            </div>
                            <div class="absolute bottom-4 left-6">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center {{ $accessSuper ? 'transform group-hover:rotate-6 transition-transform duration-300' : '' }}">
                                    <svg class="w-8 h-8 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 px-6 pt-4 pb-4">
                            <span class="text-xs font-bold text-fuchsia-600 uppercase tracking-wider mb-1">Level 5 (Super Mastery)</span>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Super Point Speaking</h3>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1">Akselerasi refleks berbicara seketika, pitching berdaya pengaruh tinggi, respons spontan cepat, dan improvisasi tanpa jeda.</p>
                            @if($accessSuper)
                            <div class="w-full text-center bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg mt-4">
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
                    @if($accessSuper)
                    </a>
                    @else
                    </div>
                    @endif

                </div>

            </div>
        </main>
    </div>

    @include('components.student-broadcaster')
    @include('components.floating-wa-button')
</body>
</html>
