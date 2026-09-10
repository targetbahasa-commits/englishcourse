<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mock Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-slate-100">
    @include('components.impersonation-banner')
    
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @elseif(Auth::user()->active_role === 'guest_quick')
            @include('components.sidebar-guest')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 relative bg-slate-50 min-h-screen">
            <!-- Decorative background glow -->
            <div class="absolute top-0 inset-x-0 h-[400px] bg-gradient-to-b from-blue-100/60 to-transparent pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[400px] bg-blue-300/20 rounded-full blur-[100px] pointer-events-none mix-blend-multiply"></div>
            <div class="absolute top-0 left-0 w-[400px] h-[300px] bg-indigo-300/10 rounded-full blur-[80px] pointer-events-none mix-blend-multiply"></div>

            <div class="p-6 md:p-12 max-w-6xl mx-auto relative z-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                    <div>
                        <p class="text-slate-500 mb-2 font-medium">Welcome back, <span class="text-blue-600 font-semibold">{{ Auth::user()->name }}</span>! 👋</p>
                        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 tracking-tight leading-tight">Choose your <br class="hidden md:block" />Mock Test</h1>
                        <p class="text-slate-500 mt-4 text-sm md:text-base max-w-xl leading-relaxed">Select the mock test you want to practice. Prepare for your real exams with our full mock tests.</p>
                    </div>
                </div>

                <!-- Test Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- TOEFL ITP Card -->
                    <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 p-6 flex flex-col relative overflow-hidden">
                        <div class="flex gap-5 relative z-10">
                            <div class="w-20 h-20 shrink-0 rounded-2xl flex items-center justify-center font-black text-lg text-center border shadow-sm leading-none tracking-tight bg-gradient-to-br from-red-50 to-pink-50 border-red-100 text-red-600">
                                TOEFL<br>ITP
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="text-xl font-bold text-slate-800 mb-1.5">TOEFL ITP Full Mock Test</h3>
                                <p class="text-slate-500 text-sm leading-relaxed max-w-xs">Complete simulation test with Listening, Structure, and Reading sections.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 mt-6 mb-8 relative z-10 pl-2">
                            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-lg">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                115 min
                            </div>
                            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-lg">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                3 sections
                            </div>
                        </div>

                        <a href="{{ route('mock-test.toefl-itp') }}" class="mt-auto relative z-10 w-full flex items-center justify-center text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-300 shadow-lg group-hover:-translate-y-0.5 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 shadow-red-500/30">
                            Access Module
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Cambridge IELTS Academic Card -->
                    <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 p-6 flex flex-col relative overflow-hidden">
                        <div class="flex gap-5 relative z-10">
                            <div class="w-20 h-20 shrink-0 rounded-2xl flex items-center justify-center font-black text-lg text-center border shadow-sm leading-none tracking-tight bg-gradient-to-br from-purple-50 to-fuchsia-50 border-purple-100 text-purple-600">
                                IELTS<br>ACAD
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="text-xl font-bold text-slate-800 mb-1.5">Cambridge IELTS Academic</h3>
                                <p class="text-slate-500 text-sm leading-relaxed max-w-xs">Full Mock Tests from Cambridge IELTS series editions 1-20.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 mt-6 mb-8 relative z-10 pl-2">
                            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-lg">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                170 min
                            </div>
                            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-lg">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                4 sections
                            </div>
                        </div>

                        <a href="{{ route('mock-test.ielts-academic') }}" class="mt-auto relative z-10 w-full flex items-center justify-center text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-300 shadow-lg group-hover:-translate-y-0.5 bg-gradient-to-r from-purple-500 to-fuchsia-600 hover:from-purple-600 hover:to-fuchsia-700 shadow-purple-500/30">
                            Access Module
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Cambridge IELTS General Card -->
                    <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 p-6 flex flex-col relative overflow-hidden">
                        <div class="flex gap-5 relative z-10">
                            <div class="w-20 h-20 shrink-0 rounded-2xl flex items-center justify-center font-black text-lg text-center border shadow-sm leading-none tracking-tight bg-gradient-to-br from-emerald-50 to-teal-50 border-emerald-100 text-emerald-600">
                                IELTS<br>GEN
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="text-xl font-bold text-slate-800 mb-1.5">Cambridge IELTS General</h3>
                                <p class="text-slate-500 text-sm leading-relaxed max-w-xs">Full Mock Tests & Practice for Cambridge IELTS General Training.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 mt-6 mb-8 relative z-10 pl-2">
                            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-lg">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                170 min
                            </div>
                            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-lg">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                4 sections
                            </div>
                        </div>

                        <a href="{{ route('mock-test.ielts-general') }}" class="mt-auto relative z-10 w-full flex items-center justify-center text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-300 shadow-lg group-hover:-translate-y-0.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-emerald-500/30">
                            Access Module
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
