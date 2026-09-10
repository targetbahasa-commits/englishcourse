<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS General Training - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-red-50 via-rose-50 to-pink-50">
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
            {{-- Header with Gradient Text --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text text-transparent">IELTS General Training</h1>
                            <p class="text-gray-600 mt-1">Comprehensive preparation for your IELTS General Training exam</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $calendarClassPeriodId = Auth::user()->class_period_id ?? '';
                            $calendarBatchName = 'IELTS General Training';
                        @endphp
                        @if($calendarClassPeriodId)
                            <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-white text-gray-600 font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Lihat Kalender
                            </button>
                        @endif
                        <a href="{{ route('assignments.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-white border border-gray-200 transition-all font-medium text-sm shadow-sm group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Sections Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- 1. Listening IELTS General --}}
                <div class="relative h-full">
                    @if(!$hasListening)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi IELTS Listening untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $hasListening ? route('assignments.ielts-academic.listening.index') : 'javascript:void(0)' }}"
                       @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('ielts')) localStorage.removeItem(k); });" @endif
                       class="block h-full group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
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
                </div>

                {{-- 2. Reading General --}}
                <div class="relative h-full">
                    @if(!$hasReading)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi IELTS Reading General untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $hasReading ? route('assignments.ielts-general.reading.index') : 'javascript:void(0)' }}"
                       @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('ielts')) localStorage.removeItem(k); });" @endif class="block h-full group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
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
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-800">Reading</h3>
                                <span class="bg-white text-emerald-700 text-xs font-extrabold px-2 py-0.5 rounded-md uppercase">General</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Practical & everyday texts comprehension.</p>
                            <div class="block w-full text-center bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                Start Learning
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- 3. Writing General (Task 1 Letter & Task 2 Essay) --}}
                <div class="relative h-full">
                    @if(!$hasWriting)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi IELTS Writing General untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $hasWriting ? route('assignments.ielts-general.writing.index') : 'javascript:void(0)' }}"
                       @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('ielts')) localStorage.removeItem(k); });" @endif class="block h-full group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
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
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-800">Writing</h3>
                                <span class="bg-rose-100 text-rose-700 text-xs font-extrabold px-2 py-0.5 rounded-md uppercase">General</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Task 1 (Letter) & Task 2 (Essay) practice.</p>
                            <div class="block w-full text-center bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                Start Learning
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- 4. Speaking --}}
                <div class="relative h-full">
                    @if(!$hasSpeaking)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi IELTS Speaking untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $hasSpeaking ? route('assignments.ielts-academic.speaking.index') : 'javascript:void(0)' }}"
                       @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('ielts')) localStorage.removeItem(k); });" @endif class="block h-full group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
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
            </div>

            {{-- Practice Section Divider --}}
            <div class="my-10 flex items-center gap-4">
                <div class="h-px bg-gray-200 flex-1"></div>
                <h2 class="text-2xl font-bold text-gray-700">Practice Tests</h2>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            {{-- Practice Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Practice Listening: Blue --}}
                <div class="relative h-full">
                    @if(!$hasListening)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi IELTS Listening untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $hasListening ? route('assignments.ielts-academic.listening.practice.index') : 'javascript:void(0)' }}"
                       @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('ielts')) localStorage.removeItem(k); });" @endif class="block h-full group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
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
                </div>

                {{-- Practice Reading (General): Green --}}
                <div class="relative h-full">
                    @if(!$hasReading)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi IELTS Reading General untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $hasReading ? route('assignments.ielts-general.reading.index') : 'javascript:void(0)' }}"
                       @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('ielts')) localStorage.removeItem(k); });" @endif class="block h-full group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
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
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-800">Reading</h3>
                                <span class="bg-white text-emerald-700 text-xs font-extrabold px-2 py-0.5 rounded-md uppercase">General</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Practical passage practice.</p>
                            <div class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                Start Practice
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Practice Writing (General): Teal --}}
                <div class="relative h-full">
                    @if(!$hasWriting)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi IELTS Writing General untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $hasWriting ? route('assignments.ielts-general.writing.practice.index') : 'javascript:void(0)' }}"
                       @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('ielts')) localStorage.removeItem(k); });" @endif class="block h-full group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
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
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-xl font-bold text-gray-800">Writing</h3>
                                <span class="bg-rose-100 text-rose-700 text-xs font-extrabold px-2 py-0.5 rounded-md uppercase">General</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">Task 1 (Letter) & Task 2 (Essay).</p>
                            <div class="block w-full text-center bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                Start Practice
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Practice Speaking: Indigo --}}
                <div class="relative h-full">
                    @if(!$hasSpeaking)
                        <div class="absolute inset-0 bg-white backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl border border-gray-100">
                            <div class="bg-white p-3 rounded-full shadow-md mb-2 text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-600 text-sm px-4 text-center">Registrasi IELTS Speaking untuk membuka</span>
                        </div>
                    @endif
                    <a href="{{ $hasSpeaking ? route('assignments.ielts-academic.speaking.practice.index') : 'javascript:void(0)' }}"
                       @if(!empty($isClassEnded) && Auth::user()->isStudent()) onclick="Object.keys(localStorage).forEach(k => { if(k.startsWith('ielts')) localStorage.removeItem(k); });" @endif class="block h-full group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
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
            </div>

            {{-- IELTS Vocabularies Section --}}
            <div class="mt-12 mb-6" x-data="{ isVocabOpen: false, activeTab: 'A1' }">
                {{-- Toggle Button --}}
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <button @click="isVocabOpen = !isVocabOpen" 
                            class="flex items-center gap-3 px-5 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold rounded-2xl shadow-lg shadow-red-200 hover:shadow-xl hover:shadow-red-300 transition-all duration-300 hover:scale-[1.02] active:scale-100">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>IELTS Vocabularies</span>
                        <svg class="w-5 h-5 transition-transform duration-300" :class="isVocabOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                {{-- Expandable Content --}}
                <div x-cloak x-show="isVocabOpen" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">

                    {{-- Level Tabs --}}
                    <div class="grid grid-cols-5 gap-3 mb-8">
                        @foreach(['A1' => ['Beginner', 'from-green-400 to-green-500'], 'A2' => ['Elementary', 'from-teal-400 to-teal-500'], 'B1' => ['Intermediate', 'from-blue-400 to-blue-500'], 'B2' => ['Upper Inter.', 'from-indigo-400 to-indigo-500'], 'C1' => ['Advanced', 'from-purple-400 to-purple-500']] as $level => $info)
                            <button @click="activeTab = '{{ $level }}'"
                                    :class="activeTab === '{{ $level }}' ? 'ring-2 ring-offset-2 ring-red-500 scale-105 shadow-lg' : 'opacity-75 hover:opacity-100 hover:scale-[1.02]'"
                                    class="bg-gradient-to-br {{ $info[1] }} text-white rounded-xl p-3 text-center transition-all duration-200 shadow-md">
                                <div class="text-lg font-extrabold">{{ $level }}</div>
                                <div class="text-[10px] uppercase tracking-wider opacity-90 font-medium">{{ $info[0] }}</div>
                            </button>
                        @endforeach
                    </div>

                    {{-- Vocab Cards --}}
                    @php
                    $jsonPath = storage_path('app/vocabularies/ielts_vocabularies.json');
                    $allVocabs = ['A1' => [], 'A2' => [], 'B1' => [], 'B2' => [], 'C1' => []];
                    if (file_exists($jsonPath)) {
                        $allVocabsRaw = json_decode(file_get_contents($jsonPath), true);
                        foreach ($allVocabsRaw as $level => $words) {
                            $allVocabs[$level] = array_map(function($w) {
                                return ['word' => $w[0], 'meaning' => $w[1], 'type' => $w[2]];
                            }, $words);
                        }
                    }
                    $typeColors = [
                        'noun' => 'text-blue-700 bg-white',
                        'verb' => 'text-rose-700 bg-rose-100',
                        'adjective' => 'text-emerald-700 bg-white',
                        'adverb' => 'text-amber-700 bg-white',
                        'conjunction' => 'text-purple-700 bg-white',
                        'preposition' => 'text-cyan-700 bg-white',
                        'pronoun' => 'text-fuchsia-700 bg-fuchsia-100',
                    ];
                    @endphp

                    @foreach(['A1', 'A2', 'B1', 'B2', 'C1'] as $level)
                    <div x-cloak x-show="activeTab === '{{ $level }}'"
                         class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 max-h-[500px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: #fca5a5 #f8fafc;">
                        @foreach($allVocabs[$level] as $v)
                        @php $colorClass = $typeColors[$v['type']] ?? 'text-gray-700 bg-white'; @endphp
                        <div class="group bg-white rounded-lg border border-gray-100 p-3 hover:shadow-md hover:border-red-300 transition-all duration-200 flex flex-col justify-center">
                            <div class="flex items-start justify-between gap-2 mb-1.5">
                                <h4 class="font-extrabold text-gray-800 text-base leading-tight notranslate truncate" title="{{ $v['word'] }}" translate="no">{{ $v['word'] }}</h4>
                                <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider whitespace-nowrap {{ $colorClass }}">{{ $v['type'] }}</span>
                            </div>
                            <div class="text-gray-600 font-medium text-sm leading-snug">{{ $v['meaning'] }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

        </main>
    </div>
    @include('components.meetings-calendar-modal')
    @include('components.floating-wa-button')
</body>
</html>
