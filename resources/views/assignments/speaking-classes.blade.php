<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Kelas Speaking</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#2563EB] text-slate-900 min-h-screen relative overflow-x-hidden">
    <!-- Ambient Graphic Shapes in Blueprint Style -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-[36rem] h-[36rem] bg-blue-400/30 rounded-full blur-3xl filter"></div>
        <div class="absolute top-1/2 -right-32 w-[32rem] h-[32rem] bg-cyan-400/25 rounded-full blur-3xl filter"></div>
        <div class="absolute -bottom-32 left-1/3 w-[36rem] h-[36rem] bg-indigo-500/30 rounded-full blur-3xl filter"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#60a5fa_1px,transparent_1px)] [background-size:32px_32px] opacity-25"></div>
    </div>

    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 min-w-0 md:ml-64 p-4 sm:p-6 lg:p-10 w-full transition-all duration-200">
            <div class="max-w-6xl mx-auto w-full space-y-8">

                <!-- MAIN WHITE CANVAS (Inspired by Modern EdTech Reference) -->
                <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border border-white/80 space-y-12">
                    
                    <!-- HERO SECTION WITH ORGANIC LIME SHAPE & PLAYFUL BADGES -->
                    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-50 via-blue-50/40 to-slate-50 p-6 sm:p-10 border border-slate-200/80">
                        <!-- Decorative Organic Lime Blob & Glow -->
                        <div class="absolute -top-16 -right-16 w-80 h-80 bg-lime-400/35 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute top-10 right-20 w-48 h-48 bg-cyan-300/30 rounded-full blur-xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                            <div class="max-w-2xl">
                                <!-- Top Pill Tag -->
                                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-blue-700 text-xs font-bold mb-4 shadow-2xs">
                                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-ping"></span>
                                    <span>Target Bahasa Speaking Academy</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-lime-700 font-extrabold">#AktifBicara</span>
                                </div>

                                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                                    Program Interaktif <br>
                                    <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-rose-600 bg-clip-text text-transparent">Speaking Course</span>
                                </h1>

                                <p class="text-sm sm:text-base text-slate-600 mt-4 leading-relaxed font-medium">
                                    Kuasai percakapan bahasa Inggris dari level dasar (First Point) hingga oratori tingkat lanjut (Super Point) dengan metode 6-Tab: Materi, Short Listening, Shadowing, Partnering, Game, dan Extended Studio.
                                </p>

                                <div class="flex flex-wrap items-center gap-3 mt-6">
                                    <a href="#daftar-kelas" class="inline-flex items-center gap-3 px-6 py-3.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-lg shadow-blue-500/30 transition-all hover:scale-105">
                                        <span>Pilih Level Kelas</span>
                                        <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </span>
                                    </a>

                                    <div class="px-4 py-2.5 rounded-full bg-white border border-slate-200 shadow-xs text-xs font-bold text-slate-700 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span>5 Level Bertingkat &bull; 55 Pertemuan</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Stats Card / Visual Widget -->
                            <div class="w-full lg:w-72 shrink-0 bg-white p-5 rounded-3xl border border-slate-200/90 shadow-xl relative">
                                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Metode Praktik</span>
                                    <span class="px-2 py-0.5 rounded-full bg-lime-100 text-lime-800 text-[10px] font-black">100% Interaktif</span>
                                </div>
                                <div class="space-y-2.5 text-xs font-bold text-slate-700">
                                    <div class="flex items-center gap-2.5 p-2 rounded-xl bg-slate-50">
                                        <span class="w-6 h-6 rounded-lg bg-blue-500 text-white text-[10px] flex items-center justify-center font-black">1</span>
                                        <span>Materi Terstruktur &amp; Audio Native</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 p-2 rounded-xl bg-slate-50">
                                        <span class="w-6 h-6 rounded-lg bg-amber-500 text-white text-[10px] flex items-center justify-center font-black">2</span>
                                        <span>Shadowing &amp; Roleplay Partner</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 p-2 rounded-xl bg-slate-50">
                                        <span class="w-6 h-6 rounded-lg bg-purple-500 text-white text-[10px] flex items-center justify-center font-black">3</span>
                                        <span>Game Kelancaran &amp; Voice Studio</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BLUE SHOWCASE SECTION: "TINGKATAN PROGRAM" (Inspired by reference blue card with white clip cards) -->
                    <div class="rounded-[2.5rem] bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                        <!-- Background Pattern Grid -->
                        <div class="absolute inset-0 bg-[radial-gradient(#93c5fd_1px,transparent_1px)] [background-size:24px_24px] opacity-15 pointer-events-none"></div>

                        <div class="relative z-10 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-xs font-extrabold uppercase tracking-wider text-blue-100">Roadmap Belajar</span>
                                <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-2 text-white">Tingkatan Program Speaking</h2>
                                <p class="text-xs sm:text-sm text-blue-100 font-medium mt-1">Pilih tingkatan yang sesuai dengan target dan kemampuan Anda saat ini.</p>
                            </div>

                            <a href="{{ route('assignments.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-2xl text-xs font-bold backdrop-blur-sm border border-white/20 transition self-start sm:self-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                <span>Kembali ke Assignments</span>
                            </a>
                        </div>

                        <!-- 5 White Clip Cards Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 relative z-10">
                            <!-- Card 1: First Point -->
                            <a href="{{ route('assignments.speaking.level', 'introductory') }}" class="group bg-white rounded-3xl p-4 sm:p-5 text-slate-900 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden border border-slate-100">
                                <!-- Top Paperclip Decor -->
                                <div class="absolute top-2 right-4 text-slate-300 group-hover:text-blue-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-extrabold text-rose-600 uppercase tracking-wider block mb-1">Level 1 (A1-A2)</span>
                                    <h3 class="font-black text-base text-slate-900 group-hover:text-blue-600 transition-colors leading-snug">First Point Speaking</h3>
                                    <p class="text-xs text-slate-500 mt-1 font-medium">Dasar salam, perkenalan diri, daily routine, &amp; hobi.</p>
                                </div>
                                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-extrabold">15 Meetings</span>
                                    <span class="w-6 h-6 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">➔</span>
                                </div>
                            </a>

                            <!-- Card 2: Second Point -->
                            <a href="{{ route('assignments.speaking.level', 'intermediate') }}" class="group bg-white rounded-3xl p-4 sm:p-5 text-slate-900 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden border border-slate-100">
                                <div class="absolute top-2 right-4 text-slate-300 group-hover:text-amber-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-extrabold text-amber-600 uppercase tracking-wider block mb-1">Level 2 (B1)</span>
                                    <h3 class="font-black text-base text-slate-900 group-hover:text-amber-600 transition-colors leading-snug">Second Point Speaking</h3>
                                    <p class="text-xs text-slate-500 mt-1 font-medium">Present Continuous, modal keharusan, degrees certainty.</p>
                                </div>
                                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-extrabold">10 Meetings</span>
                                    <span class="w-6 h-6 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">➔</span>
                                </div>
                            </a>

                            <!-- Card 3: Third Point -->
                            <a href="{{ route('assignments.speaking.level', 'advanced') }}" class="group bg-white rounded-3xl p-4 sm:p-5 text-slate-900 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden border border-slate-100">
                                <div class="absolute top-2 right-4 text-slate-300 group-hover:text-teal-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-extrabold text-teal-600 uppercase tracking-wider block mb-1">Level 3 (B2)</span>
                                    <h3 class="font-black text-base text-slate-900 group-hover:text-teal-600 transition-colors leading-snug">Third Point Speaking</h3>
                                    <p class="text-xs text-slate-500 mt-1 font-medium">Past modals, passive voice, causative, complex infinitives.</p>
                                </div>
                                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-extrabold">10 Meetings</span>
                                    <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors">➔</span>
                                </div>
                            </a>

                            <!-- Card 4: Fourth Point -->
                            <a href="{{ route('assignments.speaking.level', 'proficiency') }}" class="group bg-white rounded-3xl p-4 sm:p-5 text-slate-900 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden border border-slate-100">
                                <div class="absolute top-2 right-4 text-slate-300 group-hover:text-purple-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-extrabold text-purple-600 uppercase tracking-wider block mb-1">Level 4 (C1-C2)</span>
                                    <h3 class="font-black text-base text-slate-900 group-hover:text-purple-600 transition-colors leading-snug">Fourth Point Speaking</h3>
                                    <p class="text-xs text-slate-500 mt-1 font-medium">Rhetoric &amp; oratory, diplomasi, counterfactual debate.</p>
                                </div>
                                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-extrabold">10 Meetings</span>
                                    <span class="w-6 h-6 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors">➔</span>
                                </div>
                            </a>

                            <!-- Card 5: Super Point -->
                            <a href="{{ route('assignments.speaking.level', 'super') }}" class="group bg-white rounded-3xl p-4 sm:p-5 text-slate-900 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden border border-slate-100">
                                <div class="absolute top-2 right-4 text-slate-300 group-hover:text-fuchsia-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[11px] font-extrabold text-fuchsia-600 uppercase tracking-wider block mb-1">Level 5 (Super Mastery)</span>
                                    <h3 class="font-black text-base text-slate-900 group-hover:text-fuchsia-600 transition-colors leading-snug">Super Point Speaking</h3>
                                    <p class="text-xs text-slate-500 mt-1 font-medium">Instant thinking, high-impact pitching, spontaneous wit.</p>
                                </div>
                                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-900 text-white text-[11px] font-extrabold">10 Meetings</span>
                                    <span class="w-6 h-6 rounded-full bg-fuchsia-50 text-fuchsia-600 flex items-center justify-center group-hover:bg-fuchsia-600 group-hover:text-white transition-colors">➔</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- DETAILED COURSE CARDS SECTION (Inspired by reference "Курсы" cards) -->
                    <div id="daftar-kelas" class="space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Katalog Kelas Speaking</h2>
                                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Pilih kelas untuk masuk ke silabus pertemuan dan materi interaktif.</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">5 Tingkatan Tersedia</span>
                            </div>
                        </div>

                        <!-- 3-Column Modern Course Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- 1. First Point Speaking Card -->
                            <div class="bg-white rounded-[2rem] border border-slate-200/90 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                                <div>
                                    <!-- Banner Image / Illustration Area -->
                                    <div class="h-44 bg-gradient-to-br from-rose-500 via-pink-600 to-rose-700 p-5 relative overflow-hidden flex flex-col justify-between text-white">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1.5">
                                                <span class="px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold">Level 1</span>
                                                <span class="px-2.5 py-0.5 rounded-full bg-lime-400 text-slate-950 text-[11px] font-extrabold">A1-A2 Foundation</span>
                                            </div>
                                            <span class="px-2.5 py-0.5 rounded-full bg-black/30 backdrop-blur-md text-[11px] font-bold">15 Meetings</span>
                                        </div>
                                        <div class="relative z-10">
                                            <span class="text-xs font-bold text-rose-200 uppercase tracking-wider">Foundation</span>
                                            <h3 class="text-2xl font-black text-white leading-tight">First Point Speaking</h3>
                                        </div>
                                    </div>

                                    <!-- Content Body -->
                                    <div class="p-6 space-y-4">
                                        <div class="flex items-center gap-2 text-xs font-bold text-amber-500">
                                            <span>⭐ 4.9</span>
                                            <span class="text-slate-400 font-medium">(1.2k+ Siswa Belajar)</span>
                                        </div>

                                        <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                                            Kelas dasar intensif berbicara Inggris untuk pemula. Fokus pada salam, perkenalan diri, aktivitas sehari-hari, dan pola kalimat dasar.
                                        </p>

                                        <!-- Tag Pills -->
                                        <div class="flex flex-wrap gap-1.5 pt-1">
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Greetings</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#SelfIntro</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Drilling</span>
                                        </div>

                                        <!-- Stats Matrix -->
                                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Pertemuan</span>
                                                <span class="font-black text-slate-900">15 Modul</span>
                                            </div>
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Format</span>
                                                <span class="font-black text-slate-900">6 Tab Interaktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 pt-0">
                                    <a href="{{ route('assignments.speaking.level', 'introductory') }}" class="w-full py-3 px-5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                                        <span>Masuk Kelas First Point</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>

                            <!-- 2. Second Point Speaking Card -->
                            <div class="bg-white rounded-[2rem] border border-slate-200/90 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                                <div>
                                    <div class="h-44 bg-gradient-to-br from-amber-500 via-orange-600 to-amber-700 p-5 relative overflow-hidden flex flex-col justify-between text-white">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1.5">
                                                <span class="px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold">Level 2</span>
                                                <span class="px-2.5 py-0.5 rounded-full bg-lime-400 text-slate-950 text-[11px] font-extrabold">B1 Intermediate</span>
                                            </div>
                                            <span class="px-2.5 py-0.5 rounded-full bg-black/30 backdrop-blur-md text-[11px] font-bold">10 Meetings</span>
                                        </div>
                                        <div class="relative z-10">
                                            <span class="text-xs font-bold text-amber-200 uppercase tracking-wider">Intermediate</span>
                                            <h3 class="text-2xl font-black text-white leading-tight">Second Point Speaking</h3>
                                        </div>
                                    </div>

                                    <div class="p-6 space-y-4">
                                        <div class="flex items-center gap-2 text-xs font-bold text-amber-500">
                                            <span>⭐ 4.9</span>
                                            <span class="text-slate-400 font-medium">(850+ Siswa Belajar)</span>
                                        </div>

                                        <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                                            Tingkatkan kelancaran berbicara tingkat menengah. Mempelajari present continuous, modal keharusan, degrees of certainty, dan opini.
                                        </p>

                                        <div class="flex flex-wrap gap-1.5 pt-1">
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Modals</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Opinions</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Fluency</span>
                                        </div>

                                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Pertemuan</span>
                                                <span class="font-black text-slate-900">10 Modul</span>
                                            </div>
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Format</span>
                                                <span class="font-black text-slate-900">6 Tab Interaktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 pt-0">
                                    <a href="{{ route('assignments.speaking.level', 'intermediate') }}" class="w-full py-3 px-5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                                        <span>Masuk Kelas Second Point</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>

                            <!-- 3. Third Point Speaking Card -->
                            <div class="bg-white rounded-[2rem] border border-slate-200/90 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                                <div>
                                    <div class="h-44 bg-gradient-to-br from-teal-500 via-emerald-600 to-teal-700 p-5 relative overflow-hidden flex flex-col justify-between text-white">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1.5">
                                                <span class="px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold">Level 3</span>
                                                <span class="px-2.5 py-0.5 rounded-full bg-lime-400 text-slate-950 text-[11px] font-extrabold">B2 Advanced</span>
                                            </div>
                                            <span class="px-2.5 py-0.5 rounded-full bg-black/30 backdrop-blur-md text-[11px] font-bold">10 Meetings</span>
                                        </div>
                                        <div class="relative z-10">
                                            <span class="text-xs font-bold text-teal-200 uppercase tracking-wider">Advanced</span>
                                            <h3 class="text-2xl font-black text-white leading-tight">Third Point Speaking</h3>
                                        </div>
                                    </div>

                                    <div class="p-6 space-y-4">
                                        <div class="flex items-center gap-2 text-xs font-bold text-amber-500">
                                            <span>⭐ 4.8</span>
                                            <span class="text-slate-400 font-medium">(620+ Siswa Belajar)</span>
                                        </div>

                                        <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                                            Kuasai berbicara Inggris di level profesional &amp; akademik. Past Modals deduction, Passive Voice, Causative Verbs, dan Complex Infinitives.
                                        </p>

                                        <div class="flex flex-wrap gap-1.5 pt-1">
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#PastModals</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Passive</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Debate</span>
                                        </div>

                                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Pertemuan</span>
                                                <span class="font-black text-slate-900">10 Modul</span>
                                            </div>
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Format</span>
                                                <span class="font-black text-slate-900">6 Tab Interaktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 pt-0">
                                    <a href="{{ route('assignments.speaking.level', 'advanced') }}" class="w-full py-3 px-5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                                        <span>Masuk Kelas Third Point</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>

                            <!-- 4. Fourth Point Speaking Card -->
                            <div class="bg-white rounded-[2rem] border border-slate-200/90 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                                <div>
                                    <div class="h-44 bg-gradient-to-br from-purple-600 via-indigo-600 to-purple-800 p-5 relative overflow-hidden flex flex-col justify-between text-white">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1.5">
                                                <span class="px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold">Level 4</span>
                                                <span class="px-2.5 py-0.5 rounded-full bg-lime-400 text-slate-950 text-[11px] font-extrabold">C1-C2 Masterclass</span>
                                            </div>
                                            <span class="px-2.5 py-0.5 rounded-full bg-black/30 backdrop-blur-md text-[11px] font-bold">10 Meetings</span>
                                        </div>
                                        <div class="relative z-10">
                                            <span class="text-xs font-bold text-purple-200 uppercase tracking-wider">Proficiency</span>
                                            <h3 class="text-2xl font-black text-white leading-tight">Fourth Point Speaking</h3>
                                        </div>
                                    </div>

                                    <div class="p-6 space-y-4">
                                        <div class="flex items-center gap-2 text-xs font-bold text-amber-500">
                                            <span>⭐ 4.9</span>
                                            <span class="text-slate-400 font-medium">(410+ Siswa Belajar)</span>
                                        </div>

                                        <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                                            Kuasai retorika C2, diplomasi tingkat eksekutif, counterfactual argument, dan capstone keynote speech berdaya pikat tinggi.
                                        </p>

                                        <div class="flex flex-wrap gap-1.5 pt-1">
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Rhetoric</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Negotiation</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Diplomacy</span>
                                        </div>

                                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Pertemuan</span>
                                                <span class="font-black text-slate-900">10 Modul</span>
                                            </div>
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Format</span>
                                                <span class="font-black text-slate-900">6 Tab Interaktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 pt-0">
                                    <a href="{{ route('assignments.speaking.level', 'proficiency') }}" class="w-full py-3 px-5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                                        <span>Masuk Kelas Fourth Point</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>

                            <!-- 5. Super Point Speaking Card -->
                            <div class="bg-white rounded-[2rem] border border-slate-200/90 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                                <div>
                                    <div class="h-44 bg-gradient-to-br from-fuchsia-600 via-rose-600 to-fuchsia-800 p-5 relative overflow-hidden flex flex-col justify-between text-white">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1.5">
                                                <span class="px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold">Level 5</span>
                                                <span class="px-2.5 py-0.5 rounded-full bg-lime-400 text-slate-950 text-[11px] font-extrabold">⚡ Super Mastery</span>
                                            </div>
                                            <span class="px-2.5 py-0.5 rounded-full bg-black/30 backdrop-blur-md text-[11px] font-bold">10 Meetings</span>
                                        </div>
                                        <div class="relative z-10">
                                            <span class="text-xs font-bold text-fuchsia-200 uppercase tracking-wider">Super Fluency</span>
                                            <h3 class="text-2xl font-black text-white leading-tight">Super Point Speaking</h3>
                                        </div>
                                    </div>

                                    <div class="p-6 space-y-4">
                                        <div class="flex items-center gap-2 text-xs font-bold text-amber-500">
                                            <span>⭐ 5.0</span>
                                            <span class="text-slate-400 font-medium">(280+ Siswa Belajar)</span>
                                        </div>

                                        <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                                            Akselerasi refleks berbicara seketika, pitching berdaya pengaruh tinggi, respons spontan cepat, dan improvisasi tanpa jeda.
                                        </p>

                                        <div class="flex flex-wrap gap-1.5 pt-1">
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#InstantThinking</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Pitching</span>
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">#Wit</span>
                                        </div>

                                        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Pertemuan</span>
                                                <span class="font-black text-slate-900">10 Modul</span>
                                            </div>
                                            <div class="p-2 rounded-xl bg-slate-50">
                                                <span class="text-slate-400 block text-[10px] font-bold">Format</span>
                                                <span class="font-black text-slate-900">6 Tab Interaktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 pt-0">
                                    <a href="{{ route('assignments.speaking.level', 'super') }}" class="w-full py-3 px-5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                                        <span>Masuk Kelas Super Point</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    @include('components.student-broadcaster')
    @include('components.floating-wa-button')
</body>
</html>
