<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mock Test {{ $testId }} – Select Skill | {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.edition', ['edition' => $edition]) }}" class="hover:text-blue-600 transition">Cambridge {{ $edition }}</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Test {{ $testId }}</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">Cambridge {{ $edition }} Test {{ $testId }} – Select Skill</h1>
                            <p class="text-gray-600 mt-1">Choose which skill section you want to attempt</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge.edition', ['edition' => $edition]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            {{-- 4 Skill Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- IELTS Listening --}}
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.test', ['edition' => $edition, 'id' => $testId, 'skill' => 'listening']) }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-blue-400 to-blue-600 relative flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                            </svg>
                        </div>
                        <span class="absolute top-3 right-3 bg-white/20 text-white text-xs font-bold px-2 py-1 rounded-lg border border-white/30">LISTENING</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">IELTS Listening</h3>
                        <p class="text-gray-500 text-sm mb-4">Full listening mock test {{ $testId }} with audio and questions.</p>
                        <div class="w-full text-center bg-blue-600 group-hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition-colors duration-300 text-sm">
                            Start →
                        </div>
                    </div>
                </a>

                {{-- IELTS Reading --}}
                @php
                    $readingLink = in_array($testId, [1, 2, 3, 4]) ? route('assignments.ielts-academic.mockup.cambridge.test', ['edition' => $edition, 'id' => $testId, 'skill' => 'reading']) : '#';
                @endphp
                <a href="{{ $readingLink }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 relative flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="absolute top-3 right-3 bg-white/20 text-white text-xs font-bold px-2 py-1 rounded-lg border border-white/30">READING</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">IELTS Reading</h3>
                        <p class="text-gray-500 text-sm mb-4">Full reading mock test {{ $testId }} with passages and questions.</p>
                        <div class="w-full text-center bg-green-600 group-hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl transition-colors duration-300 text-sm">
                            Start →
                        </div>
                    </div>
                </a>

                {{-- IELTS Writing --}}
                @php
                    $writingLink = in_array($testId, [1, 2, 3, 4]) ? route('assignments.ielts-academic.mockup.cambridge.test', ['edition' => $edition, 'id' => $testId, 'skill' => 'writing']) : '#';
                @endphp
                <a href="{{ $writingLink }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-orange-400 to-orange-600 relative flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <span class="absolute top-3 right-3 bg-white/20 text-white text-xs font-bold px-2 py-1 rounded-lg border border-white/30">WRITING</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">IELTS Writing</h3>
                        <p class="text-gray-500 text-sm mb-4">Full writing mock test {{ $testId }} — Task 1 and Task 2.</p>
                        <div class="w-full text-center bg-orange-600 group-hover:bg-orange-700 text-white font-semibold py-2.5 rounded-xl transition-colors duration-300 text-sm">
                            Start →
                        </div>
                    </div>
                </a>

                {{-- IELTS Speaking --}}
                @php
                    $speakingLink = in_array($testId, [1, 2, 3, 4]) ? route('assignments.ielts-academic.mockup.cambridge.test', ['edition' => $edition, 'id' => $testId, 'skill' => 'speaking']) : '#';
                @endphp
                <a href="{{ $speakingLink }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-pink-400 to-pink-600 relative flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <span class="absolute top-3 right-3 bg-white/20 text-white text-xs font-bold px-2 py-1 rounded-lg border border-white/30">SPEAKING</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">IELTS Speaking</h3>
                        <p class="text-gray-500 text-sm mb-4">Full speaking mock test {{ $testId }} — Parts 1, 2 and 3.</p>
                        <div class="w-full text-center bg-pink-600 group-hover:bg-pink-700 text-white font-semibold py-2.5 rounded-xl transition-colors duration-300 text-sm">
                            Start →
                        </div>
                    </div>
                </a>

            </div>
        </main>
    </div>
</body>
</html>
