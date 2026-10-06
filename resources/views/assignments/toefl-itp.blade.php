<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TOEFL ITP - {{ config('app.name', 'Target Bahasa') }}</title>
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
        <main class="flex-1 md:ml-64 p-8 pb-24">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">TOEFL ITP</h1>
                            <p class="text-gray-600 mt-1">Master your TOEFL ITP skills! 🎯</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @php
                            $calendarClassPeriodId = Auth::user()->class_period_id ?? '';
                            $calendarBatchName = 'TOEFL ITP';
                        @endphp
                        @if($calendarClassPeriodId)
                            <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-white text-gray-600 font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Lihat Kalender
                            </button>
                        @endif
                        <a href="{{ route('assignments.index') }}" class="flex items-center gap-2 px-4 py-2 {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-gray-600 hover:bg-gray-700' }} text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Assignments
                        </a>
                    </div>
                </div>
            </div>

            @if(!empty($isClassEnded) && Auth::user()->isStudent())
            <div class="mb-6 flex items-center gap-3 px-4 py-3 rounded-xl bg-white border border-amber-200 text-amber-800 text-sm font-medium shadow-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <span class="font-bold">Practice Mode Aktif</span> — Periode kelas Anda telah berakhir. Anda masih bisa mengakses semua materi dan mengerjakan ulang latihan, namun nilai tidak akan dilaporkan ke guru.
                </div>
            </div>
            @endif

            {{-- Learning Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('assignments.toefl-itp.listening.lesson') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
                        <div class="block w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : 'Start Learning' }}
                            @if(empty($isClassEnded) || !Auth::user()->isStudent())
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            @endif
                        </div>
                    </div>
                </a>

                <a href="{{ route('assignments.toefl-itp.structure.lesson') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Structure</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Strengthen grammar and sentence accuracy.</p>
                        <div class="block w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : 'Start Learning' }}
                            @if(empty($isClassEnded) || !Auth::user()->isStudent())
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            @endif
                        </div>
                    </div>
                </a>

                <a href="{{ route('assignments.toefl-itp.reading.lesson') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-purple-400 to-purple-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Reading</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Build comprehension on academic passages.</p>
                        <div class="block w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-purple-500 hover:bg-purple-600' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : 'Start Learning' }}
                            @if(empty($isClassEnded) || !Auth::user()->isStudent())
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            @endif
                        </div>
                    </div>
                </a>

                <a href="{{ route('assignments.toefl-itp.vocabulary') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-orange-400 to-orange-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Vocabulary</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Expand TOEFL word power and usage.</p>
                        <div class="block w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-orange-500 hover:bg-orange-600' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : 'Start Learning' }}
                            @if(empty($isClassEnded) || !Auth::user()->isStudent())
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            @endif
                        </div>
                    </div>
                </a>
            </div>

            <div class="my-10 flex items-center gap-4">
                <div class="h-px bg-gray-200 flex-1"></div>
                <h2 class="text-2xl font-bold text-gray-700">Practice Tests</h2>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('assignments.toefl-itp.listening.practice') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-blue-400 to-blue-600 relative overflow-hidden">
                        <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">PRACTICE</span>
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 5.5L7 9H4v6h3l4.5 3.5V5.5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 9.5a4 4 0 010 5"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 7a7.5 7.5 0 010 10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Listening</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Focused audio drills and answer checks.</p>
                        <div class="block w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Practice
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('assignments.toefl-itp.structure.practice') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-green-400 to-green-600 relative overflow-hidden">
                        <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">PRACTICE</span>
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Structure</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Grammar section-style timed practice.</p>
                        <div class="block w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Practice
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('assignments.toefl-itp.reading.practice') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-indigo-400 to-indigo-600 relative overflow-hidden">
                        <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-lg text-xs font-bold border border-white/30">PRACTICE</span>
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Reading</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Passage-based answer strategy practice.</p>
                        <div class="block w-full text-center {{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-indigo-500 hover:bg-indigo-600' }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Practice
                            <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                    </div>
                </a>
            </div>


        </main>
    </div>
    @include('components.meetings-calendar-modal')
    @include('components.floating-wa-button')
</body>
</html>
