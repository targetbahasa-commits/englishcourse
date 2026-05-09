<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Academic - {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.impersonation-banner')
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
            {{-- Header with Gradient Text (Matched to Assignments Index) --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">IELTS Academic</h1>
                            <p class="text-gray-600 mt-1">Comprehensive preparation for your IELTS Academic exam</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.index') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            {{-- Main Sections Grid (Redesigned Cards) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- 1. Listening IELTS Academic --}}
                <a href="{{ route('assignments.ielts-academic.listening.index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-purple-400 to-purple-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 5.5L7 9H4v6h3l4.5 3.5V5.5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 9.5a4 4 0 010 5"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 7a7.5 7.5 0 010 10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Listening</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Practice listening skills.</p>
                        <div class="block w-full text-center bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Learning
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                <!-- Reading: Pink -->
                <a href="{{ route('assignments.ielts-academic.reading.index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-pink-400 to-pink-600 relative overflow-hidden">
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Reading</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Enhance comprehension.</p>
                        <div class="block w-full text-center bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Learning
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                <!-- Writing: Rose/Red -->
                <a href="{{ route('assignments.ielts-academic.writing.index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-red-400 to-red-600 relative overflow-hidden">
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Writing</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Task 1 & 2 practice.</p>
                         <div class="block w-full text-center bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Learning
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                <!-- Speaking: Orange -->
                <a href="{{ route('assignments.ielts-academic.speaking.index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-orange-400 to-orange-600 relative overflow-hidden">
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Speaking</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Fluency practice.</p>
                         <div class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Learning
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Practice Section Divider --}}
            <div class="my-10 flex items-center gap-4">
                <div class="h-px bg-gray-200 flex-1"></div>
                <h2 class="text-2xl font-bold text-gray-700">Practice Tests</h2>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

             {{-- Practice Grid --}}
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Practice Listening: Blue -->
                <a href="{{ route('assignments.ielts-academic.listening.practice.index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
                         <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">PRACTICE</span>
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 5.5L7 9H4v6h3l4.5 3.5V5.5z"></path>
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 9.5a4 4 0 010 5"></path>
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 7a7.5 7.5 0 010 10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Listening</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Focused exercises.</p>
                         <div class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Practice
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                 <!-- Practice Reading: Green -->
                <a href="{{ route('assignments.ielts-academic.reading.practice-index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 relative overflow-hidden">
                         <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">PRACTICE</span>
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Reading</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Passage practice.</p>
                         <div class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Practice
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                 <!-- Practice Structure: Cyan/Teal -->
                <a href="{{ route('assignments.ielts-academic.writing.practice.index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-teal-400 to-teal-600 relative overflow-hidden">
                         <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">PRACTICE</span>
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Writing</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Task 1 & 2 practice.</p>
                         <div class="block w-full text-center bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Practice
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                  <!-- Practice Speaking: Indigo -->
                <a href="{{ route('assignments.ielts-academic.speaking.practice.index') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-indigo-400 to-indigo-600 relative overflow-hidden">
                         <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">PRACTICE</span>
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Speaking</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Speaking prompts.</p>
                         <div class="block w-full text-center bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Practice
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>
             </div>

            {{-- Mock Up Section Divider --}}
            <div class="my-10 flex items-center gap-4">
                <div class="h-px bg-gray-200 flex-1"></div>
                <h2 class="text-2xl font-bold text-gray-700">Mock Up Tests</h2>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            {{-- Mock Up Grid --}}
             <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                 <!-- Mock Up Cambridge: Purple -->
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-purple-600 to-purple-800 relative overflow-hidden">
                         <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">MOCK UP</span>
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-purple-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Cambridge IELTS TEST</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Full mock exam.</p>
                         <div class="block w-full text-center bg-purple-700 hover:bg-purple-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Test
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                 <!-- Mock Up British Council: Red -->
                <a href="{{ route('assignments.ielts-academic.mockup.british-council') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-red-600 to-red-800 relative overflow-hidden">
                         <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">MOCK UP</span>
                         <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">British Council IELTS TEST</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Full mock exam.</p>
                         <div class="block w-full text-center bg-red-700 hover:bg-red-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Test
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>
             </div>
        </main>
    </div>
</body>
</html>
