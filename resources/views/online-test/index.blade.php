<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-slate-100">
    @include('components.impersonation-banner')
    @if(!Auth::user()->isAdmin())
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">TB</div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent">Target Bahasa</span>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-medium rounded-xl transition-colors duration-200 text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @endif

    <div class="flex min-h-screen {{ !Auth::user()->isAdmin() ? 'max-w-7xl mx-auto w-full' : '' }}">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @endif

        <main class="flex-1 {{ Auth::user()->isAdmin() ? 'md:ml-64' : 'w-full' }} relative bg-slate-50 min-h-screen">
            <!-- Decorative background glow -->
            <div class="absolute top-0 inset-x-0 h-[400px] bg-gradient-to-b from-blue-100/60 to-transparent pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[400px] bg-blue-300/20 rounded-full blur-[100px] pointer-events-none mix-blend-multiply"></div>
            <div class="absolute top-0 left-0 w-[400px] h-[300px] bg-indigo-300/10 rounded-full blur-[80px] pointer-events-none mix-blend-multiply"></div>

            <div class="p-6 md:p-12 max-w-6xl mx-auto relative z-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                    <div>
                        <p class="text-slate-500 mb-2 font-medium">Welcome back, <span class="text-blue-600 font-semibold">{{ Auth::user()->name }}</span>! 👋</p>
                        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 tracking-tight leading-tight">Choose your <br class="hidden md:block" />English Test Module</h1>
                        <p class="text-slate-500 mt-4 text-sm md:text-base max-w-xl leading-relaxed">Prepare for IELTS, TOEFL, and PTE with real CBT simulations and detailed performance analytics.</p>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Total Tests</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_tests'] ?? 0 }}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Tests Completed</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-500 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Average Score</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $stats['average_score'] ?? 0 }}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Overall</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-500 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Modules</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $stats['modules_completed'] ?? 0 }}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Completed</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 flex items-center gap-4 hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-500 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Study Streak</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $stats['study_streak'] ?? 0 }}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Days in a row 🔥</p>
                        </div>
                    </div>
                </div>

                @php
                    $colorClasses = [
                        'blue' => [
                            'logo_bg' => 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-100 text-blue-600',
                            'btn' => 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-blue-500/30'
                        ],
                        'green' => [
                            'logo_bg' => 'bg-gradient-to-br from-emerald-50 to-green-50 border-emerald-100 text-emerald-600',
                            'btn' => 'bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 shadow-emerald-500/30'
                        ],
                        'purple' => [
                            'logo_bg' => 'bg-gradient-to-br from-purple-50 to-fuchsia-50 border-purple-100 text-purple-600',
                            'btn' => 'bg-gradient-to-r from-purple-500 to-fuchsia-600 hover:from-purple-600 hover:to-fuchsia-700 shadow-purple-500/30'
                        ],
                        'orange' => [
                            'logo_bg' => 'bg-gradient-to-br from-orange-50 to-amber-50 border-orange-100 text-orange-600',
                            'btn' => 'bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 shadow-orange-500/30'
                        ],
                    ];
                @endphp

                <!-- Test Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($tests as $test)
                        @php 
                            $colors = $colorClasses[$test['color']] ?? $colorClasses['blue']; 
                            $shortName = explode(' ', $test['label'])[0];
                            if ($shortName === 'TOEFL') { $shortName = "TOEFL\nITP"; }
                        @endphp
                        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 p-6 flex flex-col relative overflow-hidden">
                            <!-- Card Content Top -->
                            <div class="flex gap-5 relative z-10">
                                <div class="w-20 h-20 shrink-0 rounded-2xl flex items-center justify-center font-black text-lg text-center border shadow-sm leading-none tracking-tight {{ $colors['logo_bg'] }}">
                                    {!! nl2br(e($shortName)) !!}
                                </div>
                                <div class="flex-1 pt-1">
                                    <h3 class="text-xl font-bold text-slate-800 mb-1.5">{{ $test['label'] }}</h3>
                                    <p class="text-slate-500 text-sm leading-relaxed max-w-xs">{{ $test['description'] }}</p>
                                </div>
                            </div>
                            
                            <!-- Badges -->
                            <div class="flex items-center gap-3 mt-6 mb-8 relative z-10 pl-2">
                                <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-lg">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $test['duration_minutes'] }} min
                                </div>
                                <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/60 px-3 py-1.5 rounded-lg">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    {{ count($test['sections'] ?? []) }} sections
                                </div>
                            </div>

                        @php
                            $slug = $test['slug'];
                            $isAdmin = Auth::user() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin();
                            $needsCode = !($test['has_session_access'] ?? false);
                            $codeError = $errors->first("access_code_{$slug}");
                        @endphp

                        @if($needsCode)
                            {{-- Code Entry Form --}}
                            <div x-data="{ showInput: {{ $codeError ? 'true' : 'false' }} }" class="mt-auto relative z-10">
                                <div x-show="!showInput">
                                    <button @click="showInput = true"
                                        class="w-full flex items-center justify-center text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-300 shadow-lg group-hover:-translate-y-0.5 {{ $colors['btn'] }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                        Masukkan Kode Akses
                                    </button>
                                </div>

                                <div x-show="showInput" x-cloak>
                                    <form method="POST" action="{{ $test['verify_url'] }}" class="space-y-2">
                                        @csrf
                                        <div class="flex gap-2">
                                            <input
                                                type="text"
                                                name="access_code"
                                                placeholder="Masukkan kode akses..."
                                                autocomplete="off"
                                                autofocus
                                                class="flex-1 px-4 py-3 rounded-xl border {{ $codeError ? 'border-red-400 bg-red-50 focus:ring-red-300' : 'border-slate-200 bg-slate-50 focus:ring-blue-200' }} text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 transition"
                                            />
                                            <button type="submit"
                                                class="px-5 py-3 rounded-xl text-white font-semibold text-sm transition-all duration-200 shadow-md {{ $colors['btn'] }}">
                                                Masuk
                                            </button>
                                        </div>
                                        @if($codeError)
                                            <p class="text-xs text-red-500 font-medium flex items-center gap-1 px-1">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                {{ $codeError }}
                                            </p>
                                        @endif
                                        <div class="flex items-center justify-between mt-2">
                                            <button type="button" @click="showInput = false" class="text-xs text-slate-400 hover:text-slate-600 transition px-1">
                                                ← Batal
                                            </button>
                                            @if($isAdmin)
                                                <a href="{{ $test['url'] }}" class="text-xs text-amber-600 font-semibold hover:text-amber-700 transition px-2.5 py-1 rounded-md border border-amber-200 bg-amber-50 hover:bg-amber-100 flex items-center gap-1 shadow-sm">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                    Admin Bypass
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- Direct Access --}}
                            <a href="{{ $test['url'] }}" class="mt-auto relative z-10 w-full flex items-center justify-center text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-300 shadow-lg group-hover:-translate-y-0.5 {{ $colors['btn'] }}">
                                Access Module
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 bg-white border border-slate-100 rounded-3xl p-12 text-center shadow-sm">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">No Tests Available</h3>
                            <p class="text-slate-500 text-sm max-w-md mx-auto">There are currently no active modules. Please check back later.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</body>

</html>
