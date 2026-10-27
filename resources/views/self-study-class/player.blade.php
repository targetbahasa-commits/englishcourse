<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $curriculum['title'] }} - Self-Study Learning Player</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background-color: #94a3b8;
        }
        /* NetAcad / Cisco LMS interactive question styles */
        .netacad-prompt-bar {
            background-color: #d7d8dc !important;
            color: #2b2d30 !important;
            border-bottom: 1px solid #ced4da !important;
        }
        .netacad-select-bar {
            background-color: #ffffff !important;
            color: #212529 !important;
        }
        .netacad-btn {
            background-color: #d7d8dc !important;
            color: #4b5563 !important;
        }
        .netacad-btn:hover {
            background-color: #cbced3 !important;
            color: #1f2937 !important;
        }
        .dark .netacad-prompt-bar {
            background-color: #374151 !important;
            color: #e5e7eb !important;
            border-bottom: 1px solid #4b5563 !important;
        }
        .dark .netacad-select-bar {
            background-color: #1f2937 !important;
            color: #ffffff !important;
        }
        .dark .netacad-btn {
            background-color: #374151 !important;
            color: #e5e7eb !important;
        }
        /* Target Bahasa Brand Theme (#1e3a8a - Deep Academic Navy) */
        .bg-tb-primary {
            background-color: #1e3a8a !important;
        }
        .bg-tb-primary:hover {
            background-color: #172554 !important;
        }
        .text-tb-primary {
            color: #1e3a8a !important;
        }
        .border-tb-primary {
            border-color: #1e3a8a !important;
        }
        .focus\:ring-tb:focus {
            --tw-ring-color: #1e3a8a !important;
        }
        /* Unified Self-Study Floating Grammar Toolbar (#1e3a8a Deep Navy Theme) */
        .self-study-floating-tools > div > button {
            background-color: #1e3a8a !important;
            background-image: none !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.22) !important;
            box-shadow: 0 4px 14px 0 rgba(15, 23, 42, 0.18), 0 1px 3px 0 rgba(15, 23, 42, 0.1) !important;
            opacity: 0.92 !important;
            font-weight: 600 !important;
            font-size: 0.8125rem !important;
            letter-spacing: 0.015em !important;
            backdrop-filter: blur(4px) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .self-study-floating-tools > div > button:hover {
            background-color: #172554 !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.45) !important;
            box-shadow: 0 8px 24px 0 rgba(15, 23, 42, 0.3), 0 3px 6px 0 rgba(15, 23, 42, 0.16) !important;
            opacity: 1 !important;
            transform: translateY(-1.5px) scale(1.03) !important;
        }
        .self-study-floating-tools > div > button svg {
            color: #93c5fd !important;
            transition: color 0.2s ease-in-out !important;
        }
        .self-study-floating-tools > div > button:hover svg {
            color: #ffffff !important;
        }
        /* Realistic 3D Flip Card for Syntax Formula */
        .flip-card-perspective {
            perspective: 1200px;
        }
        .flip-card-inner {
            display: grid;
            grid-template-columns: 1fr;
            transition: transform 0.65s cubic-bezier(0.34, 1.4, 0.64, 1);
            transform-style: preserve-3d;
            cursor: pointer;
        }
        .flip-card-inner.is-flipped {
            transform: rotateY(180deg);
        }
        .flip-card-front,
        .flip-card-back {
            grid-area: 1 / 1;
            width: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }
        .flip-card-back {
            transform: rotateY(180deg) translateZ(1px);
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
        }

        /* Bulletproof Formula Card High-Contrast Styling */
        .formula-card-box {
            background-color: rgba(9, 13, 22, 0.96) !important;
            border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.7), 0 8px 10px -6px rgba(0, 0, 0, 0.7) !important;
        }
        .formula-card-title {
            color: #34d399 !important; /* emerald green */
            font-weight: 800 !important;
        }
        .formula-card-code {
            color: #ffffff !important; /* pure brilliant white for max contrast */
            font-weight: 900 !important;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
            letter-spacing: 0.03em !important;
            line-height: 1.6 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.9) !important;
        }
    </style>
</head>

<body class="h-full bg-[#f8fafc] text-gray-800 antialiased font-sans select-none overflow-hidden"
      x-data="selfStudyPlayer()"
      :class="{ 'dark bg-gray-900 text-gray-100': isDarkMode }">

    <!-- Top LMS Header Bar -->
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-6 z-30 relative shrink-0 shadow-xs"
            :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
        <div class="flex items-center gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('self-study-classes.index') }}" class="flex items-center gap-2 group" title="Kembali ke Dashboard Self-Study">
                <img src="{{ asset('images/brand/icon.png') }}" class="w-9 h-9 rounded-lg object-contain shadow-xs group-hover:scale-105 transition-transform" alt="TB">
                <span class="hidden sm:inline font-bold text-sm tracking-tight text-[#1e3a8a]">Target Bahasa</span>
            </a>

            <div class="h-6 w-px bg-gray-200 hidden sm:block" :class="{ 'bg-gray-700': isDarkMode }"></div>

            <!-- Course Title -->
            <div class="flex items-center gap-3">
                <h1 class="text-base md:text-lg font-semibold text-gray-900 truncate max-w-xs md:max-w-md lg:max-w-xl"
                    :class="{ 'text-white': isDarkMode }">
                    {{ $curriculum['title'] }}
                </h1>
                <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#1e3a8a]/10 text-[#1e3a8a] border border-[#1e3a8a]/30">
                    {{ $curriculum['badge'] ?? 'Self-Study' }}
                </span>
            </div>
        </div>

        <!-- Top Right Controls -->
        <div class="flex items-center gap-2 md:gap-3">
            <!-- Reading / Curriculum Book Icon -->
            <button type="button" 
                    @click="activeTab = 'outline'; sidebarOpen = true"
                    class="p-2 text-gray-500 hover:text-[#1e3a8a] hover:bg-[#1e3a8a]/10 rounded-lg transition"
                    title="Buka Course Outline">
                <svg class="w-5 h-5 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </button>

            <!-- Exit (Close) Button -->
            <a href="{{ route('self-study-classes.index') }}" 
               class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition ml-1"
               title="Tutup & Keluar ke Halaman Self-Study">
                <svg class="w-6 h-6 text-gray-700" :class="{ 'text-gray-300 hover:text-red-400': isDarkMode }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>
    </header>

    <!-- Main Player Workspace (Sidebar + Main Content) -->
    <div class="flex h-[calc(100vh-4rem)] relative overflow-hidden">

        <!-- Collapsible Left Sidebar (Cisco NetAcad Outline) -->
        {{-- Static w-80/md:w-[22rem] below matches the sidebarOpen:true default so the
             sidebar renders at its correct width on first paint, before Alpine hydrates
             and the :class binding below takes over - without it, the aside has no width
             constraint at all for a brief moment and flashes to its full content width. --}}
        <aside class="h-full bg-white border-r border-gray-200 flex flex-col shrink-0 transition-all duration-300 z-20 shadow-sm w-80 md:w-[22rem]"
               :class="{
                   'w-80 md:w-[22rem]': sidebarOpen,
                   'w-0 -translate-x-full border-r-0 overflow-hidden pointer-events-none': !sidebarOpen,
                   'bg-gray-800 border-gray-700': isDarkMode
               }">
            
            <!-- Sidebar Tabs -->
            <div class="flex border-b border-gray-200 bg-gray-50/70"
                 :class="{ 'border-gray-700 bg-gray-800': isDarkMode }">
                <button type="button"
                        @click="activeTab = 'outline'"
                        class="flex-1 py-3 px-4 text-xs font-bold uppercase tracking-wider flex items-center justify-center gap-2 border-b-2 transition"
                        :class="activeTab === 'outline' ? (isDarkMode ? 'border-[#1e3a8a] text-blue-300 bg-gray-700' : 'border-[#1e3a8a] text-[#1e3a8a] bg-white') : (isDarkMode ? 'border-transparent text-gray-400 hover:text-gray-200' : 'border-transparent text-gray-500 hover:text-gray-700')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <span>Course Outline</span>
                </button>
                <button type="button"
                        @click="activeTab = 'resources'"
                        class="flex-1 py-3 px-4 text-xs font-bold uppercase tracking-wider flex items-center justify-center gap-2 border-b-2 transition"
                        :class="activeTab === 'resources' ? (isDarkMode ? 'border-[#1e3a8a] text-blue-300 bg-gray-700' : 'border-[#1e3a8a] text-[#1e3a8a] bg-white') : (isDarkMode ? 'border-transparent text-gray-400 hover:text-gray-200' : 'border-transparent text-gray-500 hover:text-gray-700')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Resources</span>
                </button>
            </div>

            <!-- Tab 1: Course Outline -->
            <div x-show="activeTab === 'outline'" class="flex-1 flex flex-col overflow-hidden">
                <!-- Search Box -->
                <div class="p-3 border-b border-gray-100 bg-white"
                     :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
                    <div class="relative">
                        <input type="text"
                               x-model="searchQuery"
                               placeholder="Search course outline..."
                               class="w-full pl-9 pr-4 py-2 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:bg-white transition"
                               :class="{ 'bg-gray-700 border-gray-600 text-white placeholder-gray-400': isDarkMode }">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- My Knowledge Check Summary -->
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between"
                     :class="{ 'bg-gray-800/80 border-gray-700': isDarkMode }">
                    <div class="flex items-center gap-2 text-xs font-semibold text-gray-700" :class="{ 'text-gray-300': isDarkMode }">
                        <span>My Knowledge Check</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-[#1e3a8a]/15 text-[#1e3a8a]" title="Progress Tracker">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </span>
                        <button type="button" class="text-gray-400 hover:text-gray-600" title="Refresh Progress">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modules & Topics Accordion -->
                <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-2">
                    @foreach($curriculum['modules'] as $mKey => $mod)
                        <div class="rounded-xl overflow-hidden bg-white shadow-2xs mb-2 transition"
                             style="border: 1.5px solid #dbeafe;"
                             :class="{ 'bg-gray-800 border-gray-700': isDarkMode }"
                             x-show="!searchQuery || '{{ strtolower($mod['title']) }}'.includes(searchQuery.toLowerCase())">
                            
                            <!-- Module Accordion Header -->
                            <button type="button"
                                    @click="openModule = (openModule === '{{ $mKey }}' ? '' : '{{ $mKey }}')"
                                    class="w-full px-3.5 py-3 flex items-center justify-between text-left transition"
                                    :style="isDarkMode
                                        ? (openModule === '{{ $mKey }}' ? 'background: linear-gradient(135deg, #1e3a8a55 0%, #1e293b 100%);' : 'background: transparent;')
                                        : (openModule === '{{ $mKey }}' ? 'background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);' : 'background: #ffffff;')"
                                    :class="{
                                        'hover:bg-blue-50/60': openModule !== '{{ $mKey }}' && !isDarkMode,
                                        'hover:bg-gray-700': isDarkMode
                                    }">
                                <div class="flex-1 pr-2 min-w-0">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-bold text-gray-900 truncate"
                                              :class="{ 'text-[#1e3a8a]': openModule === '{{ $mKey }}', 'text-white': isDarkMode }">
                                            {{ $mod['title'] }}
                                        </span>
                                    </div>
                                    
                                    <!-- Progress Bar -->
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-1.5 bg-blue-100 rounded-full overflow-hidden" :class="{ 'bg-gray-600': isDarkMode }">
                                            <div class="h-full rounded-full" style="background-color: #1e3a8a; width: {{ $mod['progress'] }}%;"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-[#1e3a8a]" :class="{ 'text-blue-300': isDarkMode }">
                                            {{ $mod['progress'] }}%
                                        </span>
                                    </div>
                                </div>

                                <svg class="w-4 h-4 text-[#1e3a8a] shrink-0 transition-transform duration-200"
                                     :class="{ 'rotate-180': openModule === '{{ $mKey }}' }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Sub-Topics List -->
                            <div x-show="openModule === '{{ $mKey }}'" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="divide-y divide-blue-100/60 border-t border-blue-100"
                                 :class="{ 'divide-gray-700 border-gray-700': isDarkMode }">
                                
                                @foreach($mod['topics'] as $tKey => $top)
                                    @php
                                        $isActive = ($activeModuleKey === $mKey && $activeTopicKey === $tKey);
                                        $subLessonsList = $top['scenarios']['sub_lessons'] ?? null;
                                        $outlineItems = $subLessonsList ?? ($top['scenarios']['questions'] ?? []);
                                    @endphp

                                    @if($isActive)
                                        <!-- Active Topic Card (Judul Utama) -->
                                        <div class="bg-gradient-to-r from-blue-50 via-blue-50/70 to-white border-l-4 border-[#1e3a8a] border-y border-blue-100 shadow-2xs"
                                             :class="{ 'bg-gradient-to-r from-blue-950/40 via-gray-800 to-gray-800 border-blue-500 border-gray-700': isDarkMode }">
                                            <div @click="subLessonsOpen = !subLessonsOpen"
                                                 class="px-3.5 py-2.5 flex items-start gap-2.5 cursor-pointer select-none group"
                                                 :title="subLessonsOpen ? 'Klik untuk ciutkan sub-materi' : 'Klik untuk buka sub-materi'">
                                                
                                                <!-- Topic Code Badge -->
                                                <div class="shrink-0 mt-0.5">
                                                    <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-md bg-[#1e3a8a] text-white font-extrabold text-[11px] tracking-wide shadow-2xs">
                                                        {{ $top['code'] }}
                                                    </span>
                                                </div>

                                                <!-- Topic Title (Judul) -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-1.5 mb-0.5">
                                                        <span class="text-[9px] uppercase tracking-wider font-extrabold text-blue-800"
                                                              :class="{ 'text-blue-400': isDarkMode }">TOPIK UTAMA</span>
                                                    </div>
                                                    <p class="text-xs font-black text-blue-950 leading-snug group-hover:text-[#1e3a8a] transition-colors"
                                                       :class="{ 'text-white group-hover:text-blue-300': isDarkMode }">
                                                        {{ $top['title'] }}
                                                    </p>
                                                </div>

                                                <!-- Progress & Dropdown Button -->
                                                <div class="flex flex-col items-end gap-1.5 shrink-0 mt-0.5">
                                                    <span class="text-[10px] font-bold text-blue-800 bg-blue-100 px-2 py-0.5 rounded-full"
                                                          :class="{ 'bg-blue-900/60 text-blue-200': isDarkMode }">
                                                        0/{{ $top['questions_count'] ?? '80' }}
                                                    </span>
                                                    
                                                    <!-- Dropdown Toggle Button -->
                                                    <button type="button"
                                                            @click.stop="subLessonsOpen = !subLessonsOpen"
                                                            class="p-1 rounded-md text-[#1e3a8a] hover:text-blue-950 hover:bg-blue-100/70 transition cursor-pointer flex items-center justify-center"
                                                            :class="{ 'hover:bg-gray-700 text-blue-400': isDarkMode }"
                                                            :title="subLessonsOpen ? 'Sembunyikan Sub-Materi' : 'Tampilkan Sub-Materi'">
                                                        <svg class="w-4 h-4 transition-transform duration-200"
                                                             :class="{ 'rotate-180': subLessonsOpen }"
                                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- If Active Topic: Render Sub-Lessons Outline (Sub Judul) -->
                                            @if(!empty($outlineItems))
                                                <div x-show="subLessonsOpen"
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                                     x-transition:enter-end="opacity-100 translate-y-0"
                                                     x-transition:leave="transition ease-in duration-150"
                                                     x-transition:leave-start="opacity-100 translate-y-0"
                                                     x-transition:leave-end="opacity-0 -translate-y-2"
                                                     class="pt-1.5 pb-3 px-3 bg-white/60 border-t border-blue-100/70"
                                                     :class="{ 'bg-gray-900/40 border-gray-700/60': isDarkMode }">
                                                    
                                                    <!-- Sub-topics header label -->
                                                    <div class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-600 flex items-center justify-between"
                                                         :class="{ 'text-gray-400': isDarkMode }">
                                                        <span class="flex items-center gap-1.5">
                                                            <svg class="w-3 h-3 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                                            </svg>
                                                            SUB-MATERI (SUB JUDUL)
                                                        </span>
                                                        <span class="text-[9px] font-semibold text-slate-600" :class="{ 'text-gray-400': isDarkMode }">{{ count($outlineItems) }} Bagian</span>
                                                    </div>

                                                    <!-- Tree Structure with Connector Line -->
                                                    <div class="relative ml-3 pl-3 border-l-2 border-blue-200/80 space-y-1 mt-1"
                                                         :class="{ 'border-blue-800/80': isDarkMode }">
                                                        @foreach($outlineItems as $qIdx => $qItem)
                                                            @php
                                                                $itemCode = $qItem['code'] ?? ($top['code'] . '.' . ($qIdx + 1));
                                                                $rawName = $qItem['name'] ?? ($qItem['sub_lesson'] ?? ($qItem['title'] ?? ('Sub-Lesson ' . ($qIdx + 1))));
                                                                // Strip repeated codes like "1.1.1" or "2.1.1" if already in rawName
                                                                $cleanName = preg_replace('/^\s*' . preg_quote($itemCode, '/') . '\s*[:\-–]?\s*/i', '', $rawName);
                                                                $cleanName = preg_replace('/^\s*\d+(\.\d+)+\s*[:\-–]?\s*/', '', $cleanName);
                                                                if (preg_match('/^(.*?)\s*(\(.*?\))\s*$/', $cleanName, $matches)) {
                                                                    $mainTitle = trim($matches[1]);
                                                                    $subTitle = trim($matches[2]);
                                                                } else {
                                                                    $mainTitle = $cleanName;
                                                                    $subTitle = '';
                                                                }
                                                            @endphp
                                                            <button type="button"
                                                                    @click="selectSubLesson({{ $qIdx }})"
                                                                    class="w-full text-left flex items-center justify-between gap-2 px-2.5 py-1.5 rounded-lg text-xs transition cursor-pointer group"
                                                                    :style="selectedSubLesson === {{ $qIdx }} ? 'background-color: #1e3a8a; color: #ffffff;' : ''"
                                                                    :class="selectedSubLesson === {{ $qIdx }}
                                                                        ? 'font-bold shadow-xs'
                                                                        : (isDarkMode ? 'text-gray-300 hover:text-white hover:bg-gray-700 font-medium' : 'text-slate-700 hover:text-blue-950 hover:bg-blue-100/60 font-medium')">
                                                                <div class="flex items-center gap-1.5 min-w-0">
                                                                    <!-- Bullet / Connector -->
                                                                    <span class="w-1.5 h-1.5 rounded-full shrink-0 transition-colors"
                                                                          :style="selectedSubLesson === {{ $qIdx }} ? 'background-color: #ffffff;' : 'background-color: #60a5fa;'"></span>

                                                                    <!-- Number Code -->
                                                                    <span class="font-mono font-bold text-[10px] shrink-0"
                                                                          :class="selectedSubLesson === {{ $qIdx }} ? 'text-white' : (isDarkMode ? 'text-blue-400' : 'text-blue-700')"
                                                                          :style="selectedSubLesson === {{ $qIdx }} ? 'color: #ffffff;' : ''">
                                                                        {{ $itemCode }}
                                                                    </span>

                                                                    <!-- Title & Parenthetical Subtitle -->
                                                                    <span class="truncate leading-tight text-[11px]">
                                                                        <span :class="selectedSubLesson === {{ $qIdx }} ? 'text-white font-bold' : 'text-slate-800 font-semibold'"
                                                                              :style="selectedSubLesson === {{ $qIdx }} ? 'color: #ffffff;' : (isDarkMode ? 'color: #e5e7eb;' : '')">
                                                                            {{ $mainTitle }}
                                                                        </span>
                                                                        @if($subTitle)
                                                                            <span class="text-[10px] ml-1"
                                                                                  :class="selectedSubLesson === {{ $qIdx }} ? 'text-white/80 font-normal' : 'text-slate-600 font-normal'"
                                                                                  :style="selectedSubLesson === {{ $qIdx }} ? 'color: rgba(255,255,255,0.85);' : (isDarkMode ? 'color: #9ca3af;' : '')">
                                                                                {{ $subTitle }}
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                <span class="text-[9px] font-bold shrink-0 px-1.5 py-0.5 rounded shadow-2xs"
                                                                      :style="selectedSubLesson === {{ $qIdx }}
                                                                        ? 'background-color: rgba(255,255,255,0.22); color: #ffffff;'
                                                                        : (isDarkMode ? 'background-color: rgba(96,165,250,0.15); color: #93c5fd; border: 1px solid rgba(96,165,250,0.35);' : 'background-color: #eff6ff; color: #1e3a8a; border: 1px solid #bfdbfe;')"
                                                                      x-text="viewMode === 'study' ? 'Materi' : '10 Soal'">
                                                                </span>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <!-- Inactive Topic Row -->
                                        <a href="{{ route('self-study-classes.player', ['course' => $course, 'module' => $mKey, 'topic' => $tKey]) }}"
                                           class="px-3.5 py-2.5 flex items-center justify-between gap-2.5 transition text-gray-700 hover:bg-blue-50/50 hover:text-blue-900 group"
                                           :class="{ 'hover:bg-gray-700/50 text-gray-300 hover:text-white': isDarkMode }">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <!-- Status Icon / Code -->
                                                <div class="shrink-0">
                                                    @if($top['status'] === 'completed')
                                                        <div class="w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-2xs">
                                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="w-4 h-4 rounded-full border border-gray-300 bg-white"
                                                             :class="{ 'border-gray-600 bg-gray-800': isDarkMode }"></div>
                                                    @endif
                                                </div>

                                                <div class="truncate">
                                                    <span class="font-bold text-[11px] text-gray-500 mr-1.5 group-hover:text-blue-700"
                                                          :class="{ 'text-gray-400 group-hover:text-blue-400': isDarkMode }">{{ $top['code'] }}</span>
                                                    <span class="text-xs font-medium text-gray-700 group-hover:text-blue-950"
                                                          :class="{ 'text-gray-300 group-hover:text-white': isDarkMode }">{{ $top['title'] }}</span>
                                                </div>
                                            </div>

                                            <span class="text-[10px] font-semibold text-gray-600 bg-gray-100 group-hover:bg-blue-100/70 group-hover:text-blue-800 px-1.5 py-0.5 rounded shrink-0"
                                                  :class="{ 'bg-gray-700 text-gray-400 group-hover:bg-gray-600 group-hover:text-blue-300': isDarkMode }">
                                                0/{{ $top['questions_count'] ?? '80' }}
                                            </span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tab 2: Resources -->
            <div x-show="activeTab === 'resources'" class="flex-1 overflow-y-auto p-4 space-y-3" style="display: none;">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2" :class="{ 'text-gray-500': isDarkMode }">Materi Pendukung & PDF</p>
                <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between opacity-75 cursor-not-allowed"
                     :class="{ 'bg-gray-800 border-gray-700': isDarkMode }"
                     title="Materi ini sedang disiapkan dan belum tersedia untuk diunduh.">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs">PDF</div>
                        <div>
                            <p class="text-xs font-semibold text-gray-800" :class="{ 'text-gray-200': isDarkMode }">Cheat Sheet & Formula</p>
                            <p class="text-[10px] text-gray-500" :class="{ 'text-gray-400': isDarkMode }">Panduan Ringkas</p>
                        </div>
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-wide text-gray-500 bg-gray-200 px-2 py-1 rounded shrink-0" :class="{ 'bg-gray-700 text-gray-300': isDarkMode }">Segera Hadir</span>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between opacity-75 cursor-not-allowed"
                     :class="{ 'bg-gray-800 border-gray-700': isDarkMode }"
                     title="Materi ini sedang disiapkan dan belum tersedia untuk diunduh.">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">VOC</div>
                        <div>
                            <p class="text-xs font-semibold text-gray-800" :class="{ 'text-gray-200': isDarkMode }">Academic Vocabulary Bank</p>
                            <p class="text-[10px] text-gray-500" :class="{ 'text-gray-400': isDarkMode }">Daftar Istilah & Frasa Akademik</p>
                        </div>
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-wide text-gray-500 bg-gray-200 px-2 py-1 rounded shrink-0" :class="{ 'bg-gray-700 text-gray-300': isDarkMode }">Segera Hadir</span>
                </div>
            </div>
        </aside>

        <!-- Sidebar Collapse / Expand Toggle Button on Border -->
        <button type="button"
                @click="sidebarOpen = !sidebarOpen"
                class="absolute z-30 top-1/2 -translate-y-1/2 transition-all duration-300 w-6 h-12 bg-white border border-gray-200 text-gray-500 hover:text-[#1e3a8a] hover:bg-[#1e3a8a]/10 flex items-center justify-center rounded-r-md shadow-sm"
                :style="sidebarOpen ? 'left: 20rem;' : 'left: 0;'"
                :title="sidebarOpen ? 'Sembunyikan Outline' : 'Tampilkan Outline'">
            <svg class="w-3.5 h-3.5 transition-transform" :class="{ 'rotate-180': !sidebarOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col h-full bg-[#f8fafc] overflow-y-auto custom-scrollbar relative"
              :class="{ 'bg-gray-900': isDarkMode }">
            
            <!-- Context Bar / Breadcrumbs Bar -->
            <div class="h-12 bg-white border-b border-gray-200 px-6 flex items-center justify-between shrink-0 sticky top-0 z-10"
                 :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
                
                <div class="flex items-center gap-3">
                    <button type="button" 
                            @click="sidebarOpen = !sidebarOpen" 
                            class="text-gray-400 hover:text-gray-700" 
                            title="Toggle Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    
                    <span class="text-xs font-semibold text-gray-700 tracking-tight" :class="{ 'text-gray-200': isDarkMode }">
                        <span class="text-[#1e3a8a] font-bold mr-1">{{ $activeTopic['code'] }}</span>
                        {{ $activeTopic['title'] }}
                    </span>
                </div>

                <!-- Utilities on right of content bar -->
                <div class="flex items-center gap-3 text-gray-500 text-xs">
                    <!-- Dark mode toggle -->
                    <button type="button" @click="isDarkMode = !isDarkMode" class="hover:text-[#1e3a8a] transition" :title="isDarkMode ? 'Mode Terang' : 'Mode Gelap'">
                        <svg x-show="!isDarkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="isDarkMode" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>

                    <!-- Language badge -->
                    <span class="font-bold text-[11px] px-1.5 py-0.5 rounded bg-gray-100 text-gray-600" :class="{ 'bg-gray-700 text-gray-300': isDarkMode }">EN</span>

                    <!-- Fullscreen button -->
                    <button type="button" @click="toggleFullscreen()" class="hover:text-[#1e3a8a] transition" title="Toggle Fullscreen">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content Area Body (Clean Minimalist Scenario Workspace) -->
            <div class="flex-1 p-5 md:p-8 max-w-5xl mx-auto w-full space-y-6">
                
                @php
                    $guide = $activeTopic['scenarios']['study_guide'] ?? null;
                    $subLessons = $activeTopic['scenarios']['sub_lessons'] ?? null;
                    $questions = $activeTopic['scenarios']['questions'] ?? [];
                    $questionCount = count($questions);
                @endphp

                <!-- Sleek Minimalist Header & Mode Switcher -->
                <div class="rounded-2xl shadow-xs p-5 md:p-6"
                     :style="isDarkMode
                        ? 'background: linear-gradient(135deg, #1e293b 0%, #1e3a8a33 100%); border: 1.5px solid #374151;'
                        : 'background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%); border: 1.5px solid #bfdbfe;'">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-[11px] font-bold text-[#1e3a8a] bg-[#1e3a8a]/10 px-2.5 py-0.5 rounded-md border border-[#1e3a8a]/30"
                                      :class="{ 'bg-blue-950/60 border-blue-800 text-blue-400': isDarkMode }">
                                    {{ $activeTopic['code'] }}
                                </span>
                                <span class="text-xs text-gray-500 font-medium" :class="{ 'text-gray-400': isDarkMode }">
                                    @if(!empty($activeTopic['scenarios']['sub_lessons']))
                                        {{ count($activeTopic['scenarios']['sub_lessons']) }} Sub-Lessons • {{ count($activeTopic['scenarios']['questions'] ?? []) }} Latihan Terjemahan
                                    @else
                                        {{ count($activeTopic['scenarios']['questions'] ?? []) ?: ($activeTopic['questions_count'] ?? '80') }} Latihan Soal
                                    @endif
                                </span>
                            </div>
                            <h2 class="text-lg md:text-xl font-bold text-gray-900 tracking-tight" :class="{ 'text-white': isDarkMode }">
                                <span x-show="viewMode === 'practice'">{{ $activeTopic['title'] }}</span>
                                <span x-show="viewMode === 'study'" x-cloak>Study Guide & Kaidah: {{ $activeTopic['title'] }}</span>
                                <span x-show="viewMode === 'answers'" x-cloak>Model Answers & Analisis Lengkap</span>
                            </h2>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed max-w-2xl" :class="{ 'text-gray-300': isDarkMode }">
                                <span x-show="viewMode === 'practice'">{{ $activeTopic['scenarios']['banner_subtitle'] ?? 'Terjemahkan kalimat formal ke bahasa Inggris yang tepat sesuai kaidah gramatikal.' }}</span>
                                <span x-show="viewMode === 'study'" x-cloak>Pelajari kaidah konsep, rumus sintaksis, dan bedah contoh kalimat sebelum berlatih.</span>
                                <span x-show="viewMode === 'answers'" x-cloak>Pelajari kunci jawaban resmi beserta alasan gramatikal untuk setiap soal latihan.</span>
                            </p>
                        </div>

                        <!-- Clean Segmented Mode Switcher -->
                        <div class="inline-flex items-center p-1 bg-gray-100/90 rounded-xl shrink-0 self-start md:self-auto border border-gray-200/70"
                             :class="{ 'bg-gray-900 border-gray-700': isDarkMode }">
                            <button type="button" 
                                    @click="viewMode = 'practice'"
                                    :class="viewMode === 'practice' ? 'bg-white text-gray-900 shadow-2xs font-bold' : 'text-gray-600 hover:text-gray-900 font-medium'"
                                    class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 cursor-pointer">
                                <span>Practice</span>
                                <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-[#1e3a8a]/15 text-[#1e3a8a] font-bold">{{ count($activeTopic['scenarios']['questions'] ?? []) ?: ($activeTopic['questions_count'] ?? '80') }}</span>
                            </button>
                            <button type="button" 
                                    @click="viewMode = 'study'"
                                    :class="viewMode === 'study' ? 'bg-white text-gray-900 shadow-2xs font-bold' : 'text-gray-600 hover:text-gray-900 font-medium'"
                                    class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 cursor-pointer">
                                <span>Study Guide</span>
                            </button>
                            <button type="button" 
                                    @click="viewMode = 'answers'"
                                    :class="viewMode === 'answers' ? 'bg-white text-gray-900 shadow-2xs font-bold' : 'text-gray-600 hover:text-gray-900 font-medium'"
                                    class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 cursor-pointer">
                                <span>Model Answer</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- VIEW 1: STUDY GUIDE (PENJELASAN MATERI)    -->
                <!-- ========================================== -->
                <div x-show="viewMode === 'study'" x-cloak class="space-y-6">
                    @if($guide)
                        <!-- Concept Overview Card -->
                        <div class="bg-white rounded-3xl border border-gray-100 p-6 md:p-8 shadow-sm space-y-4" :class="{ 'bg-gray-800 border-gray-700 text-white': isDarkMode }">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-[#1e3a8a]/15 text-[#1e3a8a] border border-[#1e3a8a]/30">
                                    CORE CONCEPT & THEORY
                                </span>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900" :class="{ 'text-white': isDarkMode }">
                                {{ $guide['concept_title'] }}
                            </h3>
                            <p class="text-sm md:text-base text-gray-700 leading-relaxed" :class="{ 'text-gray-300': isDarkMode }">
                                {{ $guide['concept_summary'] }}
                            </p>
                        </div>

                        <!-- Grammar Rules & Formulas -->
                        @if(!empty($guide['rules']))
                            <div class="space-y-4">
                                <div class="flex items-center gap-2 px-1">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#1e3a8a]"></span>
                                    <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider" :class="{ 'text-white': isDarkMode }">
                                        Kaidah & Rumus Tata Bahasa (Grammar Rules)
                                    </h4>
                                </div>

                                @foreach($guide['rules'] as $rIdx => $rule)
                                    <div id="study-rule-{{ $rIdx }}"
                                         class="bg-white rounded-2xl border border-gray-100 p-6 shadow-2xs space-y-3.5 transition"
                                         :class="{ 
                                             'bg-gray-800 border-gray-700': isDarkMode,
                                             'ring-2 ring-[#1e3a8a] border-[#1e3a8a] bg-[#1e3a8a]/5': selectedSubLesson === {{ $rIdx }}
                                         }">
                                        <div class="flex items-start justify-between gap-4">
                                            <h5 class="text-base font-bold text-gray-900 flex items-center gap-2" :class="{ 'text-white': isDarkMode }">
                                                <span class="w-6 h-6 rounded-full bg-[#1e3a8a]/15 text-[#1e3a8a] text-xs font-bold flex items-center justify-center shrink-0"
                                                      :class="{ 'bg-[#1e3a8a] text-white': selectedSubLesson === {{ $rIdx }} }">
                                                    {{ $rIdx + 1 }}
                                                </span>
                                                {{ $rule['rule_title'] }}
                                            </h5>
                                            <button type="button"
                                                    @click="selectSubLesson({{ $rIdx }}, 'practice')"
                                                    class="text-xs font-semibold text-[#1e3a8a] hover:text-[#172554] hover:underline shrink-0 flex items-center gap-1 cursor-pointer">
                                                <span>Latihan Soal Sub-Lesson</span> →
                                            </button>
                                        </div>

                                        @if(!empty($rule['rule_formula']))
                                            <div class="bg-[#1e3a8a]/10 border border-[#1e3a8a]/30 rounded-xl px-4 py-3 font-mono text-xs md:text-sm text-blue-950 font-semibold" :class="{ 'bg-gray-900 border-blue-800 text-blue-300': isDarkMode }">
                                                <span class="text-[#1e3a8a] font-bold mr-1">Rumus:</span>
                                                <span>{{ $rule['rule_formula'] }}</span>
                                            </div>
                                        @endif

                                        <p class="text-sm text-gray-800 leading-relaxed" :class="{ 'text-gray-100': isDarkMode }">
                                            {{ $rule['rule_description'] }}
                                        </p>

                                        @if(!empty($rule['examples']))
                                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-3" :class="{ 'bg-gray-900/60 border-gray-700': isDarkMode }">
                                                <span class="text-[11px] font-bold text-[#1e3a8a] uppercase tracking-wider" :class="{ 'text-blue-400': isDarkMode }">
                                                    Contoh Bedah Kalimat Akademik:
                                                </span>
                                                @foreach($rule['examples'] as $ex)
                                                    <div class="text-xs space-y-1 pl-2 border-l-2 border-[#1e3a8a]">
                                                        <p class="font-semibold text-gray-900 text-sm" :class="{ 'text-gray-100': isDarkMode }">EN: "{{ $ex['en'] }}"</p>
                                                        <p class="text-gray-600 italic" :class="{ 'text-gray-400': isDarkMode }">ID: "{{ $ex['id'] }}"</p>
                                                        @if(!empty($ex['note']))
                                                            <p class="text-[11px] text-[#1e3a8a] font-medium pt-0.5" :class="{ 'text-blue-400': isDarkMode }">Analisis: {{ $ex['note'] }}</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Contrast / Classification Table -->
                        @if(!empty($guide['contrast_table']))
                            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-2xs space-y-4" :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
                                <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2" :class="{ 'text-white': isDarkMode }">
                                    Tabel Klasifikasi & Panduan Cepat
                                </h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-xs text-left">
                                        <thead class="bg-gray-50 border-b border-gray-200 text-gray-700" :class="{ 'bg-gray-700 border-gray-600 text-gray-200': isDarkMode }">
                                            <tr>
                                                @foreach($guide['contrast_table']['headers'] as $header)
                                                    <th class="py-3 px-3.5 font-bold">{{ $header }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100" :class="{ 'divide-gray-700': isDarkMode }">
                                            @foreach($guide['contrast_table']['rows'] as $row)
                                                <tr class="hover:bg-gray-50/60" :class="{ 'hover:bg-gray-700/60': isDarkMode }">
                                                    @foreach($row as $cellIdx => $cell)
                                                        <td class="py-3 px-3.5 {{ $cellIdx === 0 ? 'font-semibold text-gray-900' : 'text-gray-600' }}" :class="{ 'text-gray-100': {{ $cellIdx === 0 ? 'true' : 'false' }} && isDarkMode, 'text-gray-300': !{{ $cellIdx === 0 ? 'true' : 'false' }} && isDarkMode }">
                                                            {{ $cell }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Common Pitfalls (Kesalahan Umum) -->
                        @if(!empty($guide['common_pitfalls']))
                            <div class="bg-rose-50/50 border border-rose-100 rounded-2xl p-6 space-y-4" :class="{ 'bg-rose-950/20 border-rose-900': isDarkMode }">
                                <h4 class="text-sm font-bold text-rose-900 flex items-center gap-2" :class="{ 'text-rose-300': isDarkMode }">
                                    Kesalahan Umum & Jebakan yang Harus Dihindari
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                                    @foreach($guide['common_pitfalls'] as $pit)
                                        <div class="bg-white rounded-xl p-4 border border-rose-100 shadow-2xs text-xs space-y-2" :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
                                            <p class="text-rose-700 font-semibold" :class="{ 'text-rose-400': isDarkMode }">Salah: <span class="line-through">{{ $pit['incorrect'] }}</span></p>
                                            <p class="text-emerald-700 font-bold" :class="{ 'text-emerald-400': isDarkMode }">Benar: {{ $pit['correct'] }}</p>
                                            <p class="text-gray-600 text-[11px] pt-1 leading-relaxed" :class="{ 'text-gray-300': isDarkMode }">{{ $pit['explanation'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Exam Tips -->
                        @if(!empty($guide['exam_tips']))
                            <div class="bg-blue-50/60 border border-blue-200/80 rounded-2xl p-5 space-y-2 text-xs" :class="{ 'bg-blue-950/20 border-blue-900': isDarkMode }">
                                <h5 class="font-bold text-blue-900 flex items-center gap-1.5" :class="{ 'text-blue-300': isDarkMode }">
                                    Tips Ujian & Strategi Academic Writing:
                                </h5>
                                <ul class="list-disc list-inside space-y-1 text-gray-700 pl-1 leading-relaxed" :class="{ 'text-gray-300': isDarkMode }">
                                    @foreach($guide['exam_tips'] as $tip)
                                        <li>{{ $tip }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Bottom Switch to Practice Button -->
                        <div class="p-6 bg-gradient-to-r from-[#1e3a8a] via-[#1e40af] to-[#172554] rounded-3xl text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-lg">
                            <div>
                                <h4 class="font-bold text-base">Sudah Memahami Kaidah Materi Ini?</h4>
                                <p class="text-xs text-blue-100 mt-1">Uji pemahaman Anda sekarang melalui latihan soal diagnostik interaktif.</p>
                            </div>
                            <button type="button" 
                                    @click="viewMode = 'practice'" 
                                    class="px-6 py-3 bg-white text-blue-950 hover:bg-blue-50 rounded-xl font-bold text-xs uppercase tracking-wider transition shadow-sm shrink-0 cursor-pointer">
                                Mulai Latihan Soal Sekarang →
                            </button>
                        </div>
                    @endif
                </div>

                <!-- ========================================== -->
                <!-- VIEW 2: PRACTICE ACTIVITY (LATIHAN SOAL)   -->
                <!-- ========================================== -->
                <div x-show="viewMode === 'practice'" class="space-y-6">

                    <!-- Score Result Card (Shown after submit) -->
                    <div x-show="submitted" x-cloak class="p-4 sm:p-5 rounded-2xl border flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition shadow-xs"
                         :class="{
                             'bg-emerald-50 border-emerald-300 text-emerald-950': calculateScore(selectedSubLesson) === (selectedSubLesson === null ? {{ $questionCount }} : 10),
                             'bg-amber-50 border-amber-300 text-amber-950': calculateScore(selectedSubLesson) > 0 && calculateScore(selectedSubLesson) < (selectedSubLesson === null ? {{ $questionCount }} : 10),
                             'bg-rose-50 border-rose-300 text-rose-950': calculateScore(selectedSubLesson) === 0,
                             'bg-gray-800 border-gray-700 text-white': isDarkMode
                         }">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-2xs"
                                 :class="{
                                     'bg-emerald-600 text-white': calculateScore(selectedSubLesson) === (selectedSubLesson === null ? {{ $questionCount }} : 10),
                                     'bg-amber-500 text-white': calculateScore(selectedSubLesson) > 0 && calculateScore(selectedSubLesson) < (selectedSubLesson === null ? {{ $questionCount }} : 10),
                                     'bg-rose-600 text-white': calculateScore(selectedSubLesson) === 0
                                 }">
                                <span x-text="calculateScore(selectedSubLesson) + '/' + (selectedSubLesson === null ? '{{ $questionCount }}' : '10')"></span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold">Hasil Evaluasi Diagnostik</h4>
                                <p class="text-xs opacity-90">
                                    Anda menjawab benar <strong x-text="calculateScore(selectedSubLesson)"></strong> dari <strong x-text="selectedSubLesson === null ? '{{ $questionCount }}' : '10'"></strong> soal.
                                    <span x-show="calculateScore(selectedSubLesson) === (selectedSubLesson === null ? {{ $questionCount }} : 10)">Luar biasa! Pemahaman Anda sangat solid.</span>
                                    <span x-show="calculateScore(selectedSubLesson) < (selectedSubLesson === null ? {{ $questionCount }} : 10)">Periksa kunci jawaban dan penjelasan di bawah untuk evaluasi.</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button type="button" 
                                    @click="viewMode = 'answers'"
                                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-2xs cursor-pointer">
                                Lihat Kunci & Pembahasan →
                            </button>
                        </div>
                    </div>

                    <!-- Scenario Questions List (Continuous Scrolling NetAcad Style) -->
                    <div class="space-y-12">
                        @if(!empty($subLessons))
                            @php
                                $explanationThemes = [
                                    [
                                        'badge' => 'bg-blue-800 text-white',
                                        'badge_style' => 'background-color: #1e40af !important; color: #ffffff !important;',
                                        'title' => 'text-blue-950',
                                        'card_bg' => 'bg-gradient-to-br from-white to-blue-50/50 border border-blue-200',
                                        'code_badge' => 'bg-blue-100 text-blue-900 border-blue-200',
                                        'teori_btn' => 'bg-blue-100 hover:bg-blue-200 text-blue-900 border-blue-200',
                                        'formula_box' => 'bg-gradient-to-r from-blue-50 to-indigo-50/60 border-blue-200',
                                        'formula_label' => 'text-blue-800',
                                        'formula_text' => 'text-blue-950',
                                        'rule_card' => 'bg-blue-50/70 border-blue-200/90 text-slate-900',
                                        'example_box' => 'bg-blue-50/50 border-blue-200/90',
                                    ],
                                    [
                                        'badge' => 'bg-emerald-700 text-white',
                                        'badge_style' => 'background-color: #047857 !important; color: #ffffff !important;',
                                        'title' => 'text-emerald-950',
                                        'card_bg' => 'bg-gradient-to-br from-white to-emerald-50/50 border border-emerald-200',
                                        'code_badge' => 'bg-emerald-100 text-emerald-900 border-emerald-200',
                                        'teori_btn' => 'bg-emerald-100 hover:bg-emerald-200 text-emerald-900 border-emerald-200',
                                        'formula_box' => 'bg-gradient-to-r from-emerald-50 to-teal-50/60 border-emerald-200',
                                        'formula_label' => 'text-emerald-800',
                                        'formula_text' => 'text-emerald-950',
                                        'rule_card' => 'bg-emerald-50/70 border-emerald-200/90 text-slate-900',
                                        'example_box' => 'bg-emerald-50/50 border-emerald-200/90',
                                    ],
                                    [
                                        'badge' => 'bg-sky-700 text-white',
                                        'badge_style' => 'background-color: #0369a1 !important; color: #ffffff !important;',
                                        'title' => 'text-sky-950',
                                        'card_bg' => 'bg-gradient-to-br from-white to-sky-50/50 border border-sky-200',
                                        'code_badge' => 'bg-sky-100 text-sky-900 border-sky-200',
                                        'teori_btn' => 'bg-sky-100 hover:bg-sky-200 text-sky-900 border-sky-200',
                                        'formula_box' => 'bg-gradient-to-r from-sky-50 to-blue-50/60 border-sky-200',
                                        'formula_label' => 'text-sky-800',
                                        'formula_text' => 'text-sky-950',
                                        'rule_card' => 'bg-sky-50/70 border-sky-200/90 text-slate-900',
                                        'example_box' => 'bg-sky-50/50 border-sky-200/90',
                                    ],
                                    [
                                        'badge' => 'bg-teal-700 text-white',
                                        'badge_style' => 'background-color: #0f766e !important; color: #ffffff !important;',
                                        'title' => 'text-teal-950',
                                        'card_bg' => 'bg-gradient-to-br from-white to-teal-50/50 border border-teal-200',
                                        'code_badge' => 'bg-teal-100 text-teal-900 border-teal-200',
                                        'teori_btn' => 'bg-teal-100 hover:bg-teal-200 text-teal-900 border-teal-200',
                                        'formula_box' => 'bg-gradient-to-r from-teal-50 to-emerald-50/60 border-teal-200',
                                        'formula_label' => 'text-teal-800',
                                        'formula_text' => 'text-teal-950',
                                        'rule_card' => 'bg-teal-50/70 border-teal-200/90 text-slate-900',
                                        'example_box' => 'bg-teal-50/50 border-teal-200/90',
                                    ],
                                    [
                                        'badge' => 'bg-indigo-700 text-white',
                                        'badge_style' => 'background-color: #4338ca !important; color: #ffffff !important;',
                                        'title' => 'text-indigo-950',
                                        'card_bg' => 'bg-gradient-to-br from-white to-blue-50/50 border border-blue-200',
                                        'code_badge' => 'bg-blue-100 text-blue-900 border-blue-200',
                                        'teori_btn' => 'bg-blue-100 hover:bg-blue-200 text-blue-900 border-blue-200',
                                        'formula_box' => 'bg-gradient-to-r from-blue-50 to-indigo-50/60 border-blue-200',
                                        'formula_label' => 'text-blue-800',
                                        'formula_text' => 'text-blue-950',
                                        'rule_card' => 'bg-blue-50/70 border-blue-200/90 text-slate-900',
                                        'example_box' => 'bg-blue-50/50 border-blue-200/90',
                                    ],
                                    [
                                        'badge' => 'bg-green-700 text-white',
                                        'badge_style' => 'background-color: #15803d !important; color: #ffffff !important;',
                                        'title' => 'text-green-950',
                                        'card_bg' => 'bg-gradient-to-br from-white to-green-50/50 border border-green-200',
                                        'code_badge' => 'bg-green-100 text-green-900 border-green-200',
                                        'teori_btn' => 'bg-green-100 hover:bg-green-200 text-green-900 border-green-200',
                                        'formula_box' => 'bg-gradient-to-r from-green-50 to-emerald-50/60 border-green-200',
                                        'formula_label' => 'text-green-800',
                                        'formula_text' => 'text-green-950',
                                        'rule_card' => 'bg-green-50/70 border-green-200/90 text-slate-900',
                                        'example_box' => 'bg-green-50/50 border-green-200/90',
                                    ],
                                    [
                                        'badge' => 'bg-slate-700 text-white',
                                        'badge_style' => 'background-color: #334155 !important; color: #ffffff !important;',
                                        'title' => 'text-slate-950',
                                        'card_bg' => 'bg-gradient-to-br from-white to-slate-50/50 border border-slate-300',
                                        'code_badge' => 'bg-slate-100 text-slate-900 border-slate-300',
                                        'teori_btn' => 'bg-slate-100 hover:bg-slate-200 text-slate-900 border-slate-300',
                                        'formula_box' => 'bg-gradient-to-r from-slate-50 to-blue-50/60 border-slate-300',
                                        'formula_label' => 'text-slate-800',
                                        'formula_text' => 'text-slate-950',
                                        'rule_card' => 'bg-slate-50/80 border-slate-200/90 text-slate-900',
                                        'example_box' => 'bg-slate-50/60 border-slate-200/90',
                                    ],
                                    [
                                        'badge' => 'bg-emerald-800 text-white',
                                        'badge_style' => 'background-color: #065f46 !important; color: #ffffff !important;',
                                        'title' => 'text-emerald-950',
                                        'card_bg' => 'bg-gradient-to-br from-white to-emerald-50/50 border border-emerald-200',
                                        'code_badge' => 'bg-emerald-100 text-emerald-900 border-emerald-200',
                                        'teori_btn' => 'bg-emerald-100 hover:bg-emerald-200 text-emerald-900 border-emerald-200',
                                        'formula_box' => 'bg-gradient-to-r from-emerald-50 to-teal-50/60 border-emerald-200',
                                        'formula_label' => 'text-emerald-800',
                                        'formula_text' => 'text-emerald-950',
                                        'rule_card' => 'bg-emerald-50/70 border-emerald-200/90 text-slate-900',
                                        'example_box' => 'bg-emerald-50/50 border-emerald-200/90',
                                    ],
                                ];
                            @endphp
                            @foreach($subLessons as $sIdx => $sl)
                                @php
                                    $expTheme = $explanationThemes[$sIdx % count($explanationThemes)];

                                    // Resolve example sentences with Indonesian prompt, English translation, and translation breakdown
                                    $subExamples = [];
                                    if (!empty($guide['rules'][$sIdx]['examples']) && is_array($guide['rules'][$sIdx]['examples'])) {
                                        foreach ($guide['rules'][$sIdx]['examples'] as $exData) {
                                            $subExamples[] = [
                                                'subject' => $exData['subject'] ?? ($exData['label'] ?? ''),
                                                'id' => $exData['id'] ?? '',
                                                'en' => $exData['en'] ?? '',
                                                'cara' => $exData['note'] ?? ($exData['explanation'] ?? '')
                                            ];
                                        }
                                    } elseif (!empty($sl['example']) && !empty($sl['example']['id']) && !empty($sl['example']['en'])) {
                                        $subExamples[] = [
                                            'subject' => '',
                                            'id' => $sl['example']['id'] ?? '',
                                            'en' => $sl['example']['en'] ?? '',
                                            'cara' => $sl['example']['note'] ?? ($sl['example']['explanation'] ?? ($sl['exercises'][0]['explanation'] ?? ''))
                                        ];
                                    } elseif (!empty($sl['exercises'][0])) {
                                        $ex0 = $sl['exercises'][0];
                                        $subExamples[] = [
                                            'subject' => '',
                                            'id' => $ex0['id_sentence'] ?? '',
                                            'en' => $ex0['options'][$ex0['correct_index']] ?? '',
                                            'cara' => $ex0['explanation'] ?? ''
                                        ];
                                    }
                                    $slCode = (string)($sl['code'] ?? ($sl['id'] ?? ($sIdx + 1)));
                                @endphp
                                <section id="sublesson-block-{{ $sIdx }}" 
                                         class="p-5 sm:p-7 rounded-3xl space-y-6 sm:space-y-7 transition scroll-mt-20 bg-slate-100/70 border border-slate-200/90 shadow-2xs"
                                         :class="{ 'bg-gray-800/40 border-gray-700': isDarkMode }">
                                    
                                    <!-- Sub-Lesson Header & Overview Card (Bagian Penjelasan Lengkap) -->
                                    <div class="rounded-2xl p-5 sm:p-6 {{ $expTheme['card_bg'] }} shadow-xs space-y-4 sm:space-y-5 transition border"
                                         :class="{ 'border-gray-700': isDarkMode }"
                                         :style="isDarkMode ? 'background-image: none; background-color: #1f2937;' : ''">
                                        
                                        <!-- Header Row: Unified Index & Title -->
                                        <div class="flex items-center gap-3 pb-3 sm:pb-3.5 border-b border-black/5"
                                             :class="{ 'border-gray-700': isDarkMode }">
                                            <!-- Fixed Curriculum Index Badge -->
                                            <span class="px-2.5 py-1 rounded-xl font-bold font-mono text-xs sm:text-sm tracking-wide flex items-center justify-center shrink-0 shadow-2xs {{ $expTheme['badge'] }}"
                                                  style="{{ $expTheme['badge_style'] ?? '' }}">
                                                {{ $sl['code'] ?? ($sIdx + 1) }}
                                            </span>
                                            <h3 class="font-bold text-base sm:text-lg tracking-tight {{ $expTheme['title'] }}"
                                                :style="isDarkMode ? 'color: #ffffff;' : ''">
                                                {{ $sl['name'] }}
                                            </h3>
                                        </div>

                                        @if(!empty($sl['concept_title']) && trim($sl['concept_title']) !== trim($sl['name']))
                                            <h4 class="font-bold text-xs sm:text-sm tracking-tight text-slate-800"
                                                :style="isDarkMode ? 'color: #f3f4f6;' : ''">
                                                {{ $sl['concept_title'] }}
                                            </h4>
                                        @endif

                                        <!-- Explanation Description Paragraph -->
                                        <p class="text-xs sm:text-sm leading-relaxed text-slate-900 text-justify font-normal"
                                           :style="isDarkMode ? 'color: #f3f4f6;' : ''">
                                            {{ $sl['concept_description'] ?? $sl['description'] ?? '' }}
                                        </p>

                                        <!-- Video Penjelasan Materi (Embedded Video & Admin Insertion Control) -->
                                        <template x-if="videos['{{ $slCode }}']">
                                            <div class="my-3 rounded-2xl overflow-hidden border border-slate-200/90 bg-slate-900 shadow-md">
                                                <!-- Video Header Bar -->
                                                <div class="px-3.5 py-2 bg-slate-900/95 border-b border-slate-800 flex items-center justify-between text-xs text-white">
                                                    <div class="flex items-center gap-2 truncate">
                                                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-md bg-blue-600/30 text-blue-400 shrink-0">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 2h8a1 1 0 011 1v6a1 1 0 01-1 1H6a1 1 0 01-1-1V7a1 1 0 011-1z" />
                                                            </svg>
                                                        </span>
                                                        <span class="font-bold text-slate-200 truncate" x-text="videos['{{ $slCode }}']?.title || 'Video Penjelasan: {{ addslashes($sl['name']) }}'"></span>
                                                    </div>

                                                    @if($isAdmin)
                                                        <div class="flex items-center gap-1.5 shrink-0 pl-2">
                                                            <button type="button"
                                                                    @click="openVideoModal('{{ $slCode }}', '{{ addslashes($sl['name']) }}')"
                                                                    class="px-2 py-1 rounded-md text-[11px] font-semibold bg-slate-800 hover:bg-slate-700 text-blue-300 hover:text-white transition cursor-pointer flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                                <span>Edit</span>
                                                            </button>
                                                            <button type="button"
                                                                    @click="videoForm.sublesson = '{{ $slCode }}'; submitVideo('delete')"
                                                                    class="px-2 py-1 rounded-md text-[11px] font-semibold bg-rose-950/60 hover:bg-rose-900 text-rose-300 transition cursor-pointer flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                <span>Hapus</span>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- 16:9 Responsive Video Player Container -->
                                                <div class="relative w-full aspect-video bg-black">
                                                    <template x-if="videos['{{ $slCode }}']?.type === 'direct'">
                                                        <video :src="videos['{{ $slCode }}']?.embed_url" controls class="w-full h-full object-contain"></video>
                                                    </template>
                                                    <template x-if="videos['{{ $slCode }}']?.type !== 'direct'">
                                                        <iframe :src="videos['{{ $slCode }}']?.embed_url"
                                                                class="w-full h-full border-0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                allowfullscreen
                                                                loading="lazy">
                                                        </iframe>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>

                                        @if($isAdmin)
                                            <!-- Admin Button to Insert Video when None Exists -->
                                            <template x-if="!videos['{{ $slCode }}']">
                                                <div class="my-2 p-2.5 rounded-xl border border-dashed border-blue-300/80 bg-blue-50/50 hover:bg-blue-50 transition flex items-center justify-between gap-3">
                                                    <div class="flex items-center gap-2 text-xs text-blue-900">
                                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-lg bg-blue-100 text-blue-700">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                            </svg>
                                                        </span>
                                                        <span class="font-medium">Belum ada video penjelasan untuk sub-materi ini.</span>
                                                    </div>
                                                    <button type="button"
                                                            @click="openVideoModal('{{ $slCode }}', '{{ addslashes($sl['name']) }}')"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 active:scale-95 transition shadow-xs cursor-pointer shrink-0">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                        <span>Sisipkan Video Penjelasan</span>
                                                    </button>
                                                </div>
                                            </template>
                                        @endif

                                        <!-- Realistic 3D Physical Flashcard for Syntax Formula (Diletakkan Sebelum Kaidah) -->
                                        @if(!empty($sl['formula']))
                                            <div x-data="{ flipped: false, copied: false }" class="flip-card-perspective my-3">
                                                <div class="flip-card-inner group" :class="{ 'is-flipped': flipped }">
                                                    
                                                    <!-- FRONT FACE: Sharp Van Gogh Art + Minimal High-Contrast Capsule -->
                                                    <div @click="flipped = true"
                                                         class="flip-card-front relative overflow-hidden rounded-2xl p-5 sm:p-6 border-2 border-indigo-500/80 border-b-4 border-b-indigo-700/90 shadow-xl hover:shadow-2xl transition-all duration-300 flex flex-col items-center justify-between min-h-[170px] select-none cursor-pointer group">
                                                        
                                                        <!-- Van Gogh 'Irises' Art Background (Sharp & Vivid - No Blurring) -->
                                                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105 pointer-events-none"
                                                             style="background-image: url('{{ asset('images/flashcards/van-gogh-irises.jpg') }}');">
                                                        </div>

                                                        <!-- Sleek Top Deck Code -->
                                                        <div class="relative z-10 w-full flex items-center justify-between">
                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black tracking-wider uppercase bg-slate-950/85 text-emerald-400 border border-white/20 shadow-md">
                                                                <svg class="w-3 h-3 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                                </svg>
                                                                Flashcard #{{ $sl['code'] ?? ($sIdx + 1) }}
                                                            </span>
                                                            <span class="text-[11px] font-bold text-white/90 bg-black/50 px-2 py-0.5 rounded-full border border-white/20 shadow-xs">
                                                                3D Flip Card
                                                            </span>
                                                        </div>

                                                        <!-- Centerpiece: Minimalist "Rumus" Capsule -->
                                                        <div class="relative z-10 my-auto py-1">
                                                            <div class="formula-card-box px-8 py-2.5 rounded-2xl text-center shadow-2xl">
                                                                <h4 class="text-base sm:text-lg font-black text-white tracking-widest uppercase">
                                                                    Rumus
                                                                </h4>
                                                            </div>
                                                        </div>

                                                        <!-- Bottom Action Pill -->
                                                        <div class="relative z-10 w-full flex justify-center pt-1">
                                                            <span class="inline-flex items-center gap-2 px-5 py-1.5 rounded-full bg-white text-slate-950 font-black text-xs shadow-xl group-hover:bg-emerald-300 group-hover:scale-105 active:scale-95 transition-all">
                                                                <svg class="w-4 h-4 text-[#1e3a8a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                </svg>
                                                                <span>Buka Rumus (Flip)</span>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- BACK FACE: Sharp Van Gogh Art + Verified Formula Slate -->
                                                    <div @click="flipped = false"
                                                         class="flip-card-back relative overflow-hidden rounded-2xl p-5 sm:p-6 border-2 border-emerald-500/80 border-b-4 border-b-emerald-700/90 shadow-xl flex flex-col justify-between min-h-[170px] select-none cursor-pointer">
                                                        
                                                        <!-- Van Gogh 'Irises' Art Background (Sharp & Vivid - No Blurring) -->
                                                        <div class="absolute inset-0 bg-cover bg-center pointer-events-none"
                                                             style="background-image: url('{{ asset('images/flashcards/van-gogh-irises.jpg') }}');">
                                                        </div>

                                                        <!-- Back Top Strip -->
                                                        <div class="relative z-10 flex items-center justify-between gap-3 pb-2">
                                                            <div class="flex items-center gap-2">
                                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-extrabold tracking-wider uppercase bg-emerald-500 text-slate-950 shadow-xs">
                                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    Formula Terverifikasi
                                                                </span>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <!-- Copy Button -->
                                                                <button type="button"
                                                                        @click.stop="if (navigator && navigator.clipboard) { navigator.clipboard.writeText('{{ addslashes($sl['formula']) }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); }); }"
                                                                        class="px-3 py-1 rounded-lg text-xs font-black bg-white hover:bg-emerald-300 text-slate-950 transition shadow-sm flex items-center gap-1.5 cursor-pointer active:scale-95"
                                                                        title="Salin Rumus ke Clipboard">
                                                                    <svg class="w-3.5 h-3.5" :class="{ 'text-emerald-700': copied, 'text-slate-900': !copied }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path x-show="!copied" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                        <path x-show="copied" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                                                                </button>
                                                                <!-- Flip Back Button -->
                                                                <button type="button"
                                                                        @click.stop="flipped = false"
                                                                        class="px-2.5 py-1 rounded-lg text-xs font-black bg-black/60 hover:bg-black/80 text-white border border-white/30 transition shadow-sm flex items-center gap-1 cursor-pointer active:scale-95"
                                                                        title="Tutup / Balik Kartu">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                    </svg>
                                                                    <span>Tutup</span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Formula Center Slate: 100% Solid Obsidian Black + Pure Crisp White Text -->
                                                        <div class="formula-card-box relative z-10 my-2 p-4 sm:p-5 rounded-2xl flex flex-col justify-center text-center sm:text-left">
                                                            <div class="formula-card-title text-xs uppercase tracking-wider mb-1.5 flex items-center gap-1.5 justify-center sm:justify-start">
                                                                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                                </svg>
                                                                <span>RUMUS SINTAKSIS:</span>
                                                            </div>
                                                            <div class="formula-card-code text-sm sm:text-base select-all overflow-x-auto">
                                                                {{ $sl['formula'] }}
                                                            </div>
                                                        </div>

                                                        <!-- Back Bottom Helper: High-Contrast Pill -->
                                                        <div class="relative z-10 pt-1 text-center">
                                                            <span class="inline-block px-3.5 py-1 rounded-full bg-black/85 text-white font-bold text-xs border border-white/25 shadow-md">
                                                                Ketuk di mana saja untuk membalik kartu ↺
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif

                                        <!-- Kaidah & Aturan Akademik Lengkap -->
                                        @if(!empty($sl['rules']))
                                            <div class="space-y-2.5 pt-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-4 rounded-full {{ $expTheme['badge'] }}" style="{{ $expTheme['badge_style'] ?? '' }}"></span>
                                                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-900"
                                                          :class="{ 'text-white': isDarkMode }">
                                                        Kaidah & Aturan Akademik:
                                                    </span>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5">
                                                    @foreach($sl['rules'] as $rIdx => $rText)
                                                        <div class="p-3.5 rounded-xl border flex items-start gap-2.5 text-xs sm:text-[13px] leading-relaxed shadow-xs transition-all {{ $expTheme['rule_card'] }}"
                                                             :class="{ 'bg-gray-800/80 border-gray-700 text-gray-100': isDarkMode }">
                                                            <span class="w-5 h-5 rounded-md flex items-center justify-center font-mono font-bold text-[10px] shrink-0 mt-0.5 shadow-2xs {{ $expTheme['badge'] }}"
                                                                  style="{{ $expTheme['badge_style'] ?? '' }}">
                                                                {{ $rIdx + 1 }}
                                                            </span>
                                                            <span class="min-w-0 flex-1 font-semibold text-slate-900" :class="{ 'text-gray-100': isDarkMode }">{{ $rText }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Daftar Lengkap Stative Verbs Populer (Academic & Formal Writing) -->
                                        @if(!empty($sl['stative_categories']))
                                            <div class="space-y-3 pt-2">
                                                <div class="flex items-center justify-between gap-2">
                                                    <div class="flex items-center gap-2">
                                                        <span class="w-2 h-4 rounded-full {{ $expTheme['badge'] }}" style="{{ $expTheme['badge_style'] ?? '' }}"></span>
                                                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-900"
                                                              :class="{ 'text-white': isDarkMode }">
                                                            Daftar Lengkap Stative Verbs Akademik (Wajib Simple Present):
                                                        </span>
                                                    </div>
                                                    <span class="text-[11px] font-bold text-slate-500 hidden sm:inline" :class="{ 'text-gray-400': isDarkMode }">
                                                        Dilarang Bentuk Progressive (-ing)
                                                    </span>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    @foreach($sl['stative_categories'] as $cat)
                                                        <div class="rounded-xl border border-slate-200/90 bg-white p-3.5 space-y-2.5 shadow-2xs transition"
                                                             :class="{ 'bg-gray-800/90 border-gray-700': isDarkMode }">
                                                            <div class="flex items-center justify-between pb-1.5 border-b border-slate-100"
                                                                 :class="{ 'border-gray-700': isDarkMode }">
                                                                <h5 class="text-xs font-bold text-slate-900 tracking-tight"
                                                                    :class="{ 'text-gray-100': isDarkMode }">
                                                                    {{ $cat['category'] }}
                                                                </h5>
                                                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider {{ $expTheme['badge'] }}"
                                                                      style="{{ $expTheme['badge_style'] ?? '' }}; color: #ffffff !important;">
                                                                    {{ $cat['badge'] }}
                                                                </span>
                                                            </div>

                                                            <div class="grid grid-cols-2 sm:grid-cols-2 gap-1.5">
                                                                @foreach($cat['verbs'] as $v)
                                                                    <div class="flex items-baseline gap-1.5 text-xs p-1 rounded-md hover:bg-slate-50 transition"
                                                                         :class="{ 'hover:bg-gray-700/50': isDarkMode }">
                                                                        <span class="font-bold text-slate-950 font-mono tracking-tight shrink-0"
                                                                              :class="{ 'text-emerald-400': isDarkMode }">
                                                                            {{ $v['en'] }}
                                                                        </span>
                                                                        <span class="text-[11px] text-slate-500 truncate"
                                                                              :class="{ 'text-gray-400': isDarkMode }">
                                                                            ({{ $v['id'] }})
                                                                        </span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Callout Verba Ganda (Dual-Function Stative vs Dynamic Verbs) -->
                                                <div class="rounded-xl p-3 bg-blue-50/70 border border-blue-200/90 text-xs space-y-1.5"
                                                     :class="{ 'bg-blue-950/30 border-blue-800 text-blue-200': isDarkMode }">
                                                    <div class="flex items-center gap-1.5 font-bold text-blue-950" :class="{ 'text-blue-300': isDarkMode }">
                                                        <svg class="w-3.5 h-3.5 text-blue-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>Catatan Kritis: Verba Bermakna Ganda (Stative vs Dynamic)</span>
                                                    </div>
                                                    <p class="text-[11.5px] text-slate-700 leading-relaxed font-normal" :class="{ 'text-gray-300': isDarkMode }">
                                                        Beberapa kata kerja dapat berstatus <strong>Stative</strong> (opini/keadaan) atau <strong>Dynamic</strong> (tindakan aktif). Contoh: <em>"I <strong>think</strong> the data is valid"</em> (Opini ➔ WAJIB Simple Present) vs <em>"I <strong>am thinking</strong> about the solution"</em> (Aktivitas berpikir saat ini). Begitu pula dengan <em>have</em>: <em>"She <strong>has</strong> experience"</em> (Milik ➔ Simple Present) vs <em>"They <strong>are having</strong> lunch"</em> (Aktivitas).
                                                    </p>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Contoh Kalimat & Bedah Cara Menerjemahkan untuk Masing-Masing Subjek -->
                                        @if(!empty($subExamples) && count($subExamples) > 0)
                                            <div class="space-y-3 pt-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-4 rounded-full {{ $expTheme['badge'] }}" style="{{ $expTheme['badge_style'] ?? '' }}"></span>
                                                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-900"
                                                          :class="{ 'text-white': isDarkMode }">
                                                        Contoh Kalimat & Cara Menerjemahkan Berdasarkan Subjek:
                                                    </span>
                                                </div>
                                                
                                                <div class="space-y-2.5">
                                                    @foreach($subExamples as $exIdx => $ex)
                                                        <div class="rounded-xl p-3 sm:p-3.5 border shadow-2xs space-y-2 {{ $expTheme['example_box'] }}"
                                                             :class="{ 'bg-gray-800/80 border-gray-700': isDarkMode }">
                                                            
                                                            <!-- Subject Header: Thematic Badge & Index (No Black Container) -->
                                                            @if(!empty($ex['subject']))
                                                                <div class="flex items-center justify-between pb-1 border-b border-black/5"
                                                                     :class="{ 'border-gray-700': isDarkMode }">
                                                                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-black uppercase tracking-wider {{ $expTheme['badge'] }} shadow-2xs"
                                                                          style="{{ $expTheme['badge_style'] ?? '' }}; color: #ffffff !important;">
                                                                        {{ $ex['subject'] }}
                                                                    </span>
                                                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider"
                                                                          :class="{ 'text-gray-400': isDarkMode }">
                                                                        Contoh #{{ $exIdx + 1 }}
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            <!-- Compact Unified Translation Panel -->
                                                            <div class="p-2.5 sm:p-3 rounded-xl bg-white border border-slate-200/90 shadow-2xs space-y-1.5"
                                                                 :class="{ 'bg-gray-900/90 border-gray-700': isDarkMode }">
                                                                
                                                                <!-- Indonesian Sentence -->
                                                                <div class="flex items-start gap-2.5">
                                                                    <span class="px-1.5 py-0.5 rounded font-mono text-[10px] font-black uppercase bg-blue-700 text-white shrink-0 mt-0.5 shadow-2xs"
                                                                          style="color: #ffffff !important;">
                                                                        ID
                                                                    </span>
                                                                    <p class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug"
                                                                       :class="{ 'text-gray-200': isDarkMode }">
                                                                        {{ $ex['id'] }}
                                                                    </p>
                                                                </div>

                                                                <!-- English Translation -->
                                                                <div class="flex items-start gap-2.5">
                                                                    <span class="px-1.5 py-0.5 rounded font-mono text-[10px] font-black uppercase bg-emerald-700 text-white shrink-0 mt-0.5 shadow-2xs"
                                                                          style="color: #ffffff !important;">
                                                                        EN
                                                                    </span>
                                                                    <p class="text-xs sm:text-sm font-black text-slate-950 leading-snug tracking-wide"
                                                                       :class="{ 'text-white': isDarkMode }">
                                                                        {{ $ex['en'] }}
                                                                    </p>
                                                                </div>

                                                                <!-- Cara Menerjemahkan / Analisis Gramatikal -->
                                                                @if(!empty($ex['cara']))
                                                                    <div class="pt-1.5 mt-1 border-t border-slate-100 flex items-start gap-2.5"
                                                                         :class="{ 'border-gray-800': isDarkMode }">
                                                                        <span class="px-1.5 py-0.5 rounded font-sans text-[9px] font-black uppercase bg-teal-700 text-white shrink-0 mt-0.5 shadow-2xs"
                                                                              style="color: #ffffff !important;">
                                                                            Cara
                                                                        </span>
                                                                        <p class="text-xs sm:text-[12px] text-slate-700 leading-relaxed font-medium"
                                                                           :class="{ 'text-gray-300': isDarkMode }">
                                                                            {{ $ex['cara'] }}
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- 10 Translation Exercises Cards for this Sub-Lesson -->
                                    <div class="space-y-3.5 pt-1">
                                    @php
                                        $subStartIdx = $sIdx * 10;
                                    @endphp
                                    @foreach($sl['exercises'] as $exIdx => $ex)
                                        @php
                                            $globalQIndex = $subStartIdx + $exIdx;
                                            $targetTranslation = $ex['options'][$ex['correct_index']];
                                        @endphp
                                        <div id="question-card-{{ $globalQIndex }}"
                                             class="rounded-2xl bg-white p-5 sm:p-6 transition-all duration-200 shadow-xs hover:shadow-sm space-y-3.5 border border-slate-200/90 relative"
                                             :style="isDarkMode ? 'background-color: #1f2937; color: #ffffff;' : ''"
                                             :class="{
                                                 'border-gray-700': isDarkMode,
                                                 'ring-2 ring-emerald-500 !border-emerald-500': isQuestionSubmitted({{ $globalQIndex }}) && isAnswerCorrect(userAnswers[{{ $globalQIndex }}], '{{ addslashes($targetTranslation) }}', {{ $globalQIndex }}),
                                                 'ring-2 ring-rose-400 !border-rose-400': isQuestionSubmitted({{ $globalQIndex }}) && userAnswers[{{ $globalQIndex }}] && !aiPending[{{ $globalQIndex }}] && !isAnswerCorrect(userAnswers[{{ $globalQIndex }}], '{{ addslashes($targetTranslation) }}', {{ $globalQIndex }})
                                             }">

                                            <!-- Top Header Bar with Number Badge & Sentence Prompt -->
                                            <div class="flex items-start justify-between gap-3 sm:gap-4">
                                                <div class="flex items-start gap-3 sm:gap-4 flex-1">
                                                    <!-- Distinctive Question Number Badge -->
                                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center text-xs sm:text-sm font-bold font-mono shrink-0 mt-0.5 shadow-2xs bg-slate-100 text-slate-800 border border-slate-200"
                                                         :style="isDarkMode ? 'background-color: #374151; color: #e5e7eb; border-color: #4b5563;' : ''">
                                                        {{ $globalQIndex + 1 }}
                                                    </div>
                                                    <div class="flex-1 min-w-0 pt-0.5">
                                                        <p class="text-sm md:text-base font-semibold text-slate-900 leading-relaxed tracking-tight" :style="isDarkMode ? 'color: #ffffff;' : ''">
                                                            {{ $ex['id_sentence'] }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Helper Buttons (? for Contoh Serupa, v for Vocab Helper) - Distinctive & Neutral -->
                                                <div class="flex items-center gap-1.5 shrink-0 pt-0.5">
                                                    <!-- Question Helper Tooltip (? - Contoh Serupa) -->
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" 
                                                                @click="open = !open" 
                                                                @click.outside="open = false" 
                                                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 border border-slate-200 flex items-center justify-center text-xs font-bold transition shadow-2xs cursor-pointer"
                                                                :class="{ 'bg-gray-700 hover:bg-gray-600 text-gray-300 border-gray-600': isDarkMode }"
                                                                title="Contoh Serupa">
                                                            ?
                                                        </button>
                                                        <div x-show="open" 
                                                             x-transition:enter="transition ease-out duration-200"
                                                             x-transition:enter-start="opacity-0 translate-y-2"
                                                             x-transition:enter-end="opacity-100 translate-y-0"
                                                             x-transition:leave="transition ease-in duration-150"
                                                             x-transition:leave-start="opacity-100 translate-y-0"
                                                             x-transition:leave-end="opacity-0 translate-y-2"
                                                             class="absolute bottom-full right-0 mb-2 w-72 sm:w-80 bg-slate-900 text-white text-xs rounded-xl p-3.5 shadow-xl z-20 text-left leading-relaxed" 
                                                             style="display: none;">
                                                            <strong class="block mb-1.5 text-slate-200 font-bold border-b border-slate-700 pb-1">Contoh Serupa:</strong>
                                                            @if(!empty($ex['example']))
                                                                <p class="text-slate-300 mb-1 leading-snug">{{ is_array($ex['example']) ? ($ex['example']['id'] ?? '') : $ex['example'] }}</p>
                                                                <p class="text-sky-300 italic font-medium leading-snug">{{ is_array($ex['example']) ? ($ex['example']['en'] ?? '') : '' }}</p>
                                                            @else
                                                                <p class="text-slate-300">Target: <strong class="text-sky-300">{{ $ex['target_word'] ?? '' }}</strong></p>
                                                                <p class="text-slate-400 text-[11px] mt-1">{{ $ex['explanation'] ?? '' }}</p>
                                                            @endif
                                                            <div class="absolute top-full right-3 -mt-1 border-4 border-transparent border-t-slate-900"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Vocabulary Helper Tooltip (v) -->
                                                    @php
                                                        $sentenceVocab = $ex['vocab'] ?? null;
                                                    @endphp
                                                    @if(!empty($sentenceVocab) && is_array($sentenceVocab))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" 
                                                                @click="open = !open" 
                                                                @click.outside="open = false" 
                                                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 border border-slate-200 flex items-center justify-center text-xs font-bold transition shadow-2xs cursor-pointer font-serif italic"
                                                                :class="{ 'bg-gray-700 hover:bg-gray-600 text-gray-300 border-gray-600': isDarkMode }"
                                                                title="Vocabulary Helper">
                                                            v
                                                        </button>
                                                        <div x-show="open" 
                                                             x-transition:enter="transition ease-out duration-200"
                                                             x-transition:enter-start="opacity-0 translate-y-2"
                                                             x-transition:enter-end="opacity-100 translate-y-0"
                                                             x-transition:leave="transition ease-in duration-150"
                                                             x-transition:leave-start="opacity-100 translate-y-0"
                                                             x-transition:leave-end="opacity-0 translate-y-2"
                                                             class="absolute bottom-full right-0 mb-2 w-72 sm:w-80 bg-slate-900 text-white text-xs rounded-xl p-3.5 shadow-xl z-20 text-left leading-relaxed max-h-72 overflow-y-auto custom-scrollbar" 
                                                             style="display: none;">
                                                            <strong class="block mb-2 text-slate-200 font-bold border-b border-slate-700 pb-1">Vocabulary Helper:</strong>
                                                            <ul class="space-y-1.5">
                                                                @foreach($sentenceVocab as $en => $vocabData)
                                                                    <li class="flex justify-between items-baseline text-xs gap-2 border-b border-slate-800 pb-1 last:border-0 last:pb-0">
                                                                        <span class="text-sky-300 font-mono font-medium shrink-0">
                                                                            {{ $en }}
                                                                            <span class="text-slate-400 text-[10px]">{{ is_array($vocabData) ? ($vocabData['pos'] ?? '') : '' }}</span>
                                                                        </span>
                                                                        <span class="text-slate-200 text-right">{{ is_array($vocabData) ? ($vocabData['id'] ?? '') : $vocabData }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-3 -mt-1 border-4 border-transparent border-t-slate-900"></div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Typing Input Area with Restart Icon & Submit Button (Indented Under Sentence Prompt) -->
                                            <div class="sm:ml-11 md:ml-13 pt-0.5 space-y-3">
                                                <div class="flex items-center gap-2.5">
                                                    <div class="relative flex-1">
                                                        <input type="text"
                                                               x-model="userAnswers[{{ $globalQIndex }}]"
                                                               @input="queueAutoSave()"
                                                               @change="queueAutoSave()"
                                                               @blur="queueAutoSave()"
                                                               @keydown.enter.prevent="if(!isQuestionSubmitted({{ $globalQIndex }})) submitQuestion({{ $globalQIndex }})"
                                                               :disabled="isQuestionSubmitted({{ $globalQIndex }})"
                                                               placeholder="Tulis bahasa Inggrisnya di sini..."
                                                               class="grammar-draft-input w-full h-11 px-4 pr-11 border border-gray-300 rounded-xl text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent transition bg-white hover:border-gray-400 disabled:bg-gray-50 disabled:text-gray-600 shadow-2xs font-sans placeholder-gray-400"
                                                               :class="{ 'border-gray-600 placeholder-gray-400': isDarkMode }"
                                                               :style="isDarkMode ? (isQuestionSubmitted({{ $globalQIndex }}) ? 'background-color: #1f2937; color: #d1d5db;' : 'background-color: #374151; color: #ffffff;') : ''"
                                                               autocomplete="off">
                                                        <button type="button"
                                                                @click.prevent="resetQuestion({{ $globalQIndex }})"
                                                                title="Refresh / Ulangi Latihan Ini"
                                                                class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg text-gray-400 hover:text-[#1e3a8a] hover:bg-gray-100 flex items-center justify-center transition focus:outline-none bg-transparent cursor-pointer">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <button type="button" 
                                                            @click.prevent="submitQuestion({{ $globalQIndex }})"
                                                            x-show="!isQuestionSubmitted({{ $globalQIndex }})"
                                                            class="h-11 text-white text-sm font-semibold rounded-xl transition shadow-xs shrink-0 cursor-pointer flex items-center justify-center hover:opacity-95"
                                                            style="background-color: #1e3a8a; color: #ffffff; padding-left: 1.25rem; padding-right: 1.25rem; min-width: 5.5rem; border: none;">
                                                        Submit
                                                    </button>
                                                </div>

                                                <!-- Feedback & Model Answer Box -->
                                                <div x-show="isQuestionSubmitted({{ $globalQIndex }}) || showFeedback" 
                                                     x-cloak
                                                     class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-xs leading-relaxed space-y-2"
                                                     :style="isDarkMode
                                                        ? (isAnswerCorrect(userAnswers[{{ $globalQIndex }}], '{{ addslashes($targetTranslation) }}', {{ $globalQIndex }})
                                                            ? 'background-color: #064e3b55; border-color: #10b981; color: #e5e7eb;'
                                                            : (userAnswers[{{ $globalQIndex }}] && !aiPending[{{ $globalQIndex }}]
                                                                ? 'background-color: #7f1d1d55; border-color: #f87171; color: #e5e7eb;'
                                                                : 'background-color: #374151; border-color: #4b5563; color: #e5e7eb;'))
                                                        : ''"
                                                     :class="{
                                                         'border-emerald-300 text-emerald-950 bg-emerald-50/70': !isDarkMode && isAnswerCorrect(userAnswers[{{ $globalQIndex }}], '{{ addslashes($targetTranslation) }}', {{ $globalQIndex }}),
                                                         'border-rose-300 text-rose-950 bg-rose-50/70': !isDarkMode && userAnswers[{{ $globalQIndex }}] && !aiPending[{{ $globalQIndex }}] && !isAnswerCorrect(userAnswers[{{ $globalQIndex }}], '{{ addslashes($targetTranslation) }}', {{ $globalQIndex }})
                                                     }">
                                                    <div class="flex items-center justify-between gap-2 font-semibold">
                                                        <div>
                                                            <span class="text-gray-500 uppercase tracking-wider text-[10px]" :class="{ 'text-gray-400': isDarkMode }">Kunci Jawaban:</span>
                                                            <p class="text-[#1e3a8a] text-sm mt-0.5 font-medium" :class="{ 'text-sky-300': isDarkMode }">
                                                                {{ $targetTranslation }}
                                                            </p>
                                                        </div>
                                                        <span class="text-[11px] font-bold px-2 py-0.5 rounded shrink-0 flex items-center gap-1"
                                                              x-show="!aiPending[{{ $globalQIndex }}]"
                                                              :class="isAnswerCorrect(userAnswers[{{ $globalQIndex }}], '{{ addslashes($targetTranslation) }}', {{ $globalQIndex }}) ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'">
                                                            <span x-show="isAnswerCorrect(userAnswers[{{ $globalQIndex }}], '{{ addslashes($targetTranslation) }}', {{ $globalQIndex }})">Benar</span>
                                                            <span x-show="!isAnswerCorrect(userAnswers[{{ $globalQIndex }}], '{{ addslashes($targetTranslation) }}', {{ $globalQIndex }})">Kurang Tepat</span>
                                                        </span>
                                                        <span class="text-[11px] font-bold px-2 py-0.5 rounded shrink-0 bg-slate-100 text-slate-600 animate-pulse"
                                                              x-show="aiPending[{{ $globalQIndex }}]" x-cloak>
                                                            Memeriksa dengan AI...
                                                        </span>
                                                    </div>
                                                    <div class="pt-2 border-t border-gray-200/60" :class="{ 'border-gray-600': isDarkMode }">
                                                        <p class="text-gray-600" :style="isDarkMode ? 'color: #d1d5db;' : ''">
                                                            <strong>Penjelasan:</strong>
                                                            <span x-show="aiFeedback[{{ $globalQIndex }}]" x-text="aiFeedback[{{ $globalQIndex }}]"></span>
                                                            <span x-show="!aiFeedback[{{ $globalQIndex }}]">{{ $ex['explanation'] }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </section>
                            @endforeach
                        @elseif(!empty($questions))
                            @foreach($questions as $qIndex => $q)
                                <div id="question-card-{{ $qIndex }}"
                                     class="border border-[#ced4da] rounded-md overflow-hidden bg-white shadow-2xs transition"
                                     :class="{
                                         'ring-2 ring-emerald-500': submitted && userAnswers[{{ $qIndex }}] == {{ $q['correct_index'] }},
                                         'ring-2 ring-rose-400': submitted && userAnswers[{{ $qIndex }}] !== undefined && userAnswers[{{ $qIndex }}] != {{ $q['correct_index'] }},
                                         'ring-2 ring-indigo-500 shadow-md': !submitted && selectedSubLesson === {{ $qIndex }}
                                     }">
                                    
                                    <!-- Top Prompt Bar (Solid Light Gray #d7d8dc) -->
                                    <div class="netacad-prompt-bar px-4 py-3 text-sm font-normal leading-relaxed flex flex-wrap items-center justify-between gap-2"
                                         style="background-color: #d7d8dc; color: #2b2d30; border-bottom: 1px solid #ced4da;">
                                        <div class="flex items-baseline gap-2 flex-1">
                                            @if(!empty($q['sub_lesson']))
                                                <span class="inline-block text-[11px] font-bold px-2 py-0.5 rounded bg-white/70 text-[#2b2d30] border border-[#ced4da] uppercase tracking-wider shrink-0"
                                                      :class="{ 'bg-emerald-600 text-white border-emerald-600': selectedSubLesson === {{ $qIndex }} }">
                                                    {{ $q['sub_lesson'] }}
                                                </span>
                                            @endif
                                            <span>{{ $qIndex + 1 }}. {{ $q['prompt'] }}</span>
                                        </div>
                                        <button type="button" 
                                                @click="selectSubLesson({{ $qIndex }}, 'study')"
                                                class="text-[11px] text-gray-500 hover:text-emerald-700 underline font-semibold shrink-0 cursor-pointer">
                                            Baca Materi
                                        </button>
                                    </div>

                                    <!-- Bottom Select Bar (Pure White) -->
                                    <div class="relative netacad-select-bar" style="background-color: #ffffff;">
                                        <select x-model="userAnswers[{{ $qIndex }}]"
                                                class="w-full bg-transparent text-[#212529] text-sm py-3 px-4 pr-10 appearance-none focus:outline-none cursor-pointer"
                                                :class="{ 'text-white': isDarkMode }"
                                                :disabled="submitted">
                                            <option value="" disabled selected>Please select an option</option>
                                            @foreach($q['options'] as $optIndex => $opt)
                                                <option value="{{ $optIndex }}">{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                        
                                        <!-- Solid Dropdown Arrow -->
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#212529] text-[10px]"
                                             :class="{ 'text-gray-300': isDarkMode }">
                                            ▼
                                        </div>
                                    </div>

                                    <!-- Feedback Explanation box -->
                                    <div x-show="showFeedback || submitted" 
                                         x-cloak
                                         class="p-4 bg-gray-50 border-t border-[#ced4da] text-xs leading-relaxed space-y-1.5"
                                         :class="{
                                             'bg-gray-700 border-gray-600 text-gray-200': isDarkMode,
                                             'border-emerald-200 text-emerald-950 bg-emerald-50/50': userAnswers[{{ $qIndex }}] == {{ $q['correct_index'] }},
                                             'border-rose-200 text-rose-950 bg-rose-50/50': userAnswers[{{ $qIndex }}] !== undefined && userAnswers[{{ $qIndex }}] != {{ $q['correct_index'] }}
                                         }">
                                        <div class="flex items-center justify-between gap-2 font-semibold">
                                            <div>
                                                Kunci Jawaban: <span class="text-emerald-700 font-bold" :class="{ 'text-emerald-400': isDarkMode }">{{ $q['options'][$q['correct_index']] }}</span>
                                            </div>
                                            <span class="text-[11px] font-bold px-2 py-0.5 rounded"
                                                  :class="userAnswers[{{ $qIndex }}] == {{ $q['correct_index'] }} ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'">
                                                <span x-show="userAnswers[{{ $qIndex }}] == {{ $q['correct_index'] }}">Benar</span>
                                                <span x-show="userAnswers[{{ $qIndex }}] != {{ $q['correct_index'] }}">Kurang Tepat</span>
                                            </span>
                                        </div>
                                        <p class="text-gray-600 pt-1" :class="{ 'text-gray-300': isDarkMode }">
                                            <strong>Penjelasan:</strong> {{ $q['explanation'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @if(!empty($subLessons))
                        <!-- Sub-Lesson Stepper Navigation (When viewing a specific sub-lesson) -->
                        <div x-show="selectedSubLesson !== null" class="flex items-center justify-between gap-3 p-3.5 bg-white rounded-2xl border border-gray-200/90 shadow-2xs"
                             :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
                            <button type="button"
                                    @click="prevSubLesson()"
                                    :disabled="selectedSubLesson === 0"
                                    class="px-3.5 py-2 rounded-xl text-xs font-semibold border transition flex items-center gap-1.5 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed"
                                    :class="selectedSubLesson === 0 ? 'bg-gray-50 text-gray-400 border-gray-200' : 'bg-white hover:bg-gray-50 text-gray-700 border-gray-300' + (isDarkMode ? ' bg-gray-700 text-gray-200 border-gray-600' : '')">
                                <span>← Sub-Lesson Sebelumnya</span>
                            </button>

                            <span class="text-xs font-bold text-gray-600" :class="{ 'text-gray-300': isDarkMode }">
                                Sub-Lesson <span class="text-[#1e3a8a]" x-text="selectedSubLesson + 1"></span> dari {{ count($activeTopic['scenarios']['sub_lessons'] ?? []) }}
                            </span>

                            <button type="button"
                                    @click="nextSubLesson()"
                                    :disabled="selectedSubLesson === {{ count($activeTopic['scenarios']['sub_lessons'] ?? []) - 1 }}"
                                    class="px-3.5 py-2 rounded-xl text-xs font-semibold border transition flex items-center gap-1.5 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed"
                                    :class="selectedSubLesson === {{ count($activeTopic['scenarios']['sub_lessons'] ?? []) - 1 }} ? 'bg-gray-50 text-gray-400 border-gray-200' : 'bg-[#1e3a8a] hover:bg-[#172554] text-white border-[#1e3a8a] shadow-2xs'">
                                <span>Lanjut Sub-Lesson →</span>
                            </button>
                        </div>
                    @endif

                    <!-- Bottom Action Controls: 2 Equal-Width Buttons (Submit | Show feedback) -->
                    <div class="space-y-3 pt-2 pb-16">
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button"
                                    @click="submitAll()"
                                    class="netacad-btn w-full py-3 font-medium text-sm rounded-md transition shadow-2xs cursor-pointer text-center"
                                    style="background-color: #d7d8dc; color: #4b5563;"
                                    :class="{ 
                                        'bg-[#2b2d30] text-white hover:bg-black': Object.keys(userAnswers).length > 0 && !submitted,
                                        'bg-gray-700 text-gray-200 hover:bg-gray-600': isDarkMode 
                                    }">
                                Submit Semua
                            </button>

                            <button type="button"
                                    @click="showFeedback = !showFeedback"
                                    class="netacad-btn w-full py-3 font-medium text-sm rounded-md transition shadow-2xs cursor-pointer text-center"
                                    style="background-color: #d7d8dc; color: #4b5563;"
                                    :class="{ 'bg-gray-700 text-gray-200 hover:bg-gray-600': isDarkMode }">
                                <span x-show="!showFeedback">Show feedback</span>
                                <span x-show="showFeedback">Hide feedback</span>
                            </button>
                        </div>

                        <!-- Secondary Helpers (Reset & Study Guide Links) -->
                        <div class="flex items-center justify-between text-xs pt-1 px-1">
                            <button type="button"
                                    @click="userAnswers = {}; submitted = false; showFeedback = false"
                                    x-show="submitted"
                                    x-cloak
                                    class="font-semibold text-rose-600 hover:text-rose-700 cursor-pointer underline">
                                ↺ Reset Jawaban
                            </button>
                            <button type="button"
                                    @click="viewMode = 'study'"
                                    class="font-semibold text-[#1e3a8a] hover:text-[#172554] ml-auto cursor-pointer">
                                ← Buka Penjelasan Materi (Study Guide)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- VIEW 3: VIEW MODEL ANSWER (KUNCI & BEDAH)  -->
                <!-- ========================================== -->
                <div x-show="viewMode === 'answers'" x-cloak class="space-y-6">
                    <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-6" :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-indigo-100 text-indigo-800 border border-indigo-200">
                                OFFICIAL MODEL ANSWERS & LINGUISTIC RATIONALE
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900" :class="{ 'text-white': isDarkMode }">
                            Kunci Jawaban Resmi & Pembahasan Diagnostik
                        </h3>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed" :class="{ 'text-gray-300': isDarkMode }">
                            Pelajari alasan di balik setiap jawaban yang optimal dan kenali kelemahan pada opsi pilihan lainnya untuk memperdalam insting tata bahasa Anda.
                        </p>
                    </div>

                    <div class="space-y-5">
                        @if(!empty($subLessons))
                            @foreach($subLessons as $sIdx => $sl)
                                <div id="answer-sublesson-block-{{ $sIdx }}" class="space-y-4 pt-2 scroll-mt-20">
                                    <div class="bg-indigo-900/90 text-white p-4 rounded-xl flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-full bg-indigo-500 text-white font-bold text-xs flex items-center justify-center">
                                                {{ $sIdx + 1 }}
                                            </span>
                                            <h4 class="font-bold text-sm text-white">{{ $sl['name'] }}</h4>
                                        </div>
                                        <span class="text-xs text-indigo-200">10 Model Answers</span>
                                    </div>
                                    @php
                                        $subStartIdx = $sIdx * 10;
                                    @endphp
                                    @foreach($sl['exercises'] as $exIdx => $ex)
                                        @php
                                            $globalQIndex = $subStartIdx + $exIdx;
                                        @endphp
                                        <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4 shadow-2xs" :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
                                            <div class="flex items-start justify-between gap-3">
                                                <h5 class="text-sm font-bold text-gray-900" :class="{ 'text-white': isDarkMode }">
                                                    <span class="text-indigo-600 mr-1">#{{ $globalQIndex + 1 }} [{{ explode(' ', $sl['name'])[0] }}]:</span>
                                                    Translate: "{{ $ex['id_sentence'] }}"
                                                    @if(!empty($ex['target_word']))
                                                        <span class="text-xs font-normal text-emerald-600 ml-1">({{ $ex['target_word'] }})</span>
                                                    @endif
                                                </h5>
                                            </div>

                                            <!-- Correct Answer Banner -->
                                            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3.5 flex items-start gap-3" :class="{ 'bg-emerald-950/20 border-emerald-900': isDarkMode }">
                                                <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                                <div class="text-xs space-y-0.5">
                                                    <p class="font-bold text-emerald-900" :class="{ 'text-emerald-300': isDarkMode }">Terjemahan Akademik Resmi & Pilihan Optimal:</p>
                                                    <p class="text-gray-900 font-semibold text-sm" :class="{ 'text-white': isDarkMode }">{{ $ex['options'][$ex['correct_index']] }}</p>
                                                </div>
                                            </div>

                                            <!-- Explanation -->
                                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-xs leading-relaxed space-y-1" :class="{ 'bg-gray-900/60 border-gray-700': isDarkMode }">
                                                <p class="font-bold text-gray-900" :class="{ 'text-gray-100': isDarkMode }">Analisis Sintaksis & Pembahasan:</p>
                                                <p class="text-gray-600" :class="{ 'text-gray-300': isDarkMode }">{{ $ex['explanation'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @elseif(!empty($questions))
                            @foreach($questions as $qIndex => $q)
                                <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4 shadow-2xs" :class="{ 'bg-gray-800 border-gray-700': isDarkMode }">
                                    <div class="flex items-start justify-between gap-3">
                                        <h5 class="text-sm font-bold text-gray-900" :class="{ 'text-white': isDarkMode }">
                                            <span class="text-indigo-600 mr-1">Soal {{ $qIndex + 1 }}:</span>
                                            {{ $q['prompt'] }}
                                        </h5>
                                    </div>

                                    <!-- Correct Answer Banner -->
                                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3.5 flex items-start gap-3" :class="{ 'bg-emerald-950/20 border-emerald-900': isDarkMode }">
                                        <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div class="text-xs space-y-0.5">
                                            <p class="font-bold text-emerald-900" :class="{ 'text-emerald-300': isDarkMode }">Pilihan Jawaban yang Optimal:</p>
                                            <p class="text-gray-900 font-semibold text-sm" :class="{ 'text-white': isDarkMode }">{{ $q['options'][$q['correct_index']] }}</p>
                                        </div>
                                    </div>

                                    <!-- Explanation -->
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-xs leading-relaxed space-y-1" :class="{ 'bg-gray-900/60 border-gray-700': isDarkMode }">
                                        <p class="font-bold text-gray-900" :class="{ 'text-gray-100': isDarkMode }">Analisis Gramatikal & Pembahasan:</p>
                                        <p class="text-gray-600" :class="{ 'text-gray-300': isDarkMode }">{{ $q['explanation'] }}</p>
                                    </div>

                                    <!-- All Options Overview -->
                                    <div class="pt-2 border-t border-gray-100" :class="{ 'border-gray-700': isDarkMode }">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Evaluasi Semua Pilihan:</p>
                                        <ul class="space-y-1.5 text-xs">
                                            @foreach($q['options'] as $optIdx => $opt)
                                                <li class="flex items-start gap-2 p-2 rounded-lg {{ $optIdx == $q['correct_index'] ? 'bg-emerald-50 text-emerald-900 font-semibold' : 'text-gray-600' }}" :class="{ 'bg-emerald-950/20 text-emerald-300': {{ $optIdx == $q['correct_index'] ? 'true' : 'false' }} && isDarkMode, 'text-gray-400': !{{ $optIdx == $q['correct_index'] ? 'true' : 'false' }} && isDarkMode }">
                                                    <span class="font-bold {{ $optIdx == $q['correct_index'] ? 'text-emerald-600' : 'text-gray-400' }}">{{ chr(65 + $optIdx) }}.</span>
                                                    <span>{{ $opt }}</span>
                                                    @if($optIdx == $q['correct_index'])
                                                        <span class="ml-auto text-[10px] uppercase font-bold text-emerald-700 shrink-0">Optimal Choice</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4 pb-16">
                        <button type="button" 
                                @click="viewMode = 'practice'"
                                class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-xs cursor-pointer">
                            ← Kembali ke Latihan Soal
                        </button>
                        <button type="button" 
                                @click="viewMode = 'study'"
                                class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-xs cursor-pointer">
                            Buka Study Guide Lengkap →
                        </button>
                    </div>
                </div>
            </div>

            {{-- Floating Helper Buttons Stack (Dictionary, Conjunction, Preposition, Pronoun, Adverb, Verb Palsu, Modal, Tenses Chart, Irregular Verbs) --}}
            <div class="self-study-floating-tools fixed bottom-6 right-3 sm:right-6 z-40 flex flex-col gap-1.5 sm:gap-2 items-end pointer-events-none [&>*]:pointer-events-auto">
                <x-dictionary-button />
                <x-conjunction-button />
                <x-preposition-button />
                <x-pronouns-button />
                <x-adverb-button />
                <x-verb-patterns-button />
                <x-modal-button />
                <x-tenses-button />
                <x-irregular-verbs-button />
            </div>

            {{-- Floating Manual Save Button (Matching assignments/custom-class/68/meeting/3/grammar) --}}
            <div x-show="viewMode === 'practice' && !submitted" 
                 class="fixed bottom-6 z-40 pointer-events-auto" 
                 style="left: 50%; transform: translateX(-50%);">
                <button type="button" 
                        id="manual-save-btn" 
                        @click="manualSaveDraft()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3M8 7h8"></path>
                    </svg>
                    <span x-text="saveBtnText">Save</span>
                </button>
            </div>
        </main>

        @if($isAdmin)
            <!-- Admin Modal: Sisipkan / Edit Video Penjelasan -->
            <div x-show="videoModalOpen"
                 x-cloak
                 class="fixed inset-0 z-50 overflow-y-auto"
                 aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity"
                     @click="closeVideoModal()"></div>

                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-200"
                         @click.stop>
                        
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-800 px-6 py-4 text-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-white leading-tight">Sisipkan Video Penjelasan</h3>
                                    <p class="text-xs text-blue-100 font-medium" x-text="videoForm.sublessonTitle || 'Sub-materi'"></p>
                                </div>
                            </div>
                            <button type="button"
                                    @click="closeVideoModal()"
                                    class="rounded-lg p-1.5 text-blue-200 hover:text-white hover:bg-white/10 transition cursor-pointer">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Tab Selector: Upload Video vs Tautan URL -->
                        <div class="px-6 pt-5 pb-0">
                            <div class="flex items-center gap-2 p-1 bg-slate-100 rounded-xl border border-slate-200">
                                <button type="button"
                                        @click="videoForm.tab = 'upload'"
                                        class="flex-1 py-2 px-3 rounded-lg text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer"
                                        :class="videoForm.tab === 'upload' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <span>Upload File Video</span>
                                </button>
                                <button type="button"
                                        @click="videoForm.tab = 'url'"
                                        class="flex-1 py-2 px-3 rounded-lg text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer"
                                        :class="videoForm.tab === 'url' ? 'bg-white text-blue-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <span>Tautan / URL Embed</span>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 space-y-4">
                            <!-- Error notification -->
                            <div x-show="videoForm.error" class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span x-text="videoForm.error"></span>
                            </div>

                            <!-- TAB 1: UPLOAD FILE VIDEO -->
                            <div x-show="videoForm.tab === 'upload'" class="space-y-3">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Pilih File Video dari Perangkat <span class="text-rose-500">*</span>
                                </label>

                                <!-- Drag & Drop Dropzone (When no new file selected) -->
                                <div x-show="!videoForm.file"
                                     @dragover.prevent
                                     @dragenter.prevent
                                     @drop.prevent="handleFileDrop($event)"
                                     @click="$refs.fileInput.click()"
                                     class="border-2 border-dashed border-blue-300 hover:border-blue-500 bg-blue-50/40 hover:bg-blue-50/80 rounded-2xl p-6 text-center cursor-pointer transition group">
                                    <input type="file"
                                           x-ref="fileInput"
                                           @change="handleFileSelect($event)"
                                           accept="video/mp4,video/webm,video/quicktime,video/ogg,video/x-matroska"
                                           class="hidden">
                                    
                                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white mx-auto flex items-center justify-center transition duration-200 shadow-xs mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <p class="text-xs sm:text-sm font-bold text-slate-800">
                                        Klik untuk memilih file video atau seret file ke sini
                                    </p>
                                    <p class="text-[11px] text-slate-500 mt-1">
                                        Mendukung format MP4, WebM, MOV, OGG (Maksimal 2048 MB / 2 GB)
                                    </p>
                                </div>

                                <!-- Selected File Info & Local Preview -->
                                <div x-show="videoForm.file" class="space-y-3">
                                    <div class="flex items-center justify-between p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/60">
                                        <div class="flex items-center gap-3 truncate">
                                            <span class="w-9 h-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                            <div class="truncate text-left">
                                                <p class="text-xs font-bold text-slate-900 truncate" x-text="videoForm.fileName"></p>
                                                <p class="text-[11px] text-slate-500 font-mono" x-text="videoForm.fileSize"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <button type="button"
                                                    @click="$refs.fileInput.click()"
                                                    class="px-2.5 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-100 rounded-lg transition cursor-pointer">
                                                Ganti
                                            </button>
                                            <button type="button"
                                                    @click="removeUploadFile()"
                                                    class="p-1 text-slate-400 hover:text-rose-600 transition cursor-pointer"
                                                    title="Hapus file">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Local Live Video Preview -->
                                    <div x-show="videoForm.filePreviewUrl" class="space-y-1.5">
                                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">
                                            Preview Video Lokal:
                                        </label>
                                        <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-black shadow-inner">
                                            <video :src="videoForm.filePreviewUrl" controls class="w-full h-full object-contain"></video>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Video on Server Notice (If any) -->
                                <template x-if="!videoForm.file && videos[videoForm.sublesson]?.file_path">
                                    <div class="p-3 rounded-xl bg-blue-50/70 border border-blue-200 text-xs text-blue-900 flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2 truncate">
                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="truncate">File video saat ini aktif di server (<strong x-text="videos[videoForm.sublesson]?.file_name || 'video file'"></strong>). Upload file baru di atas jika ingin menggantinya.</span>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- TAB 2: LINK EMBED / URL -->
                            <div x-show="videoForm.tab === 'url'" class="space-y-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        URL Video / Link Embed <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text"
                                           x-model="videoForm.url"
                                           placeholder="Contoh: https://www.youtube.com/watch?v=... atau Google Drive preview"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-sm text-slate-900 transition">
                                    <p class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        Mendukung link <strong>YouTube</strong> (standar, share, shorts), <strong>Google Drive</strong>, <strong>Vimeo</strong>, atau file <strong>MP4</strong>.
                                    </p>
                                </div>

                                <!-- Live Preview for URL -->
                                <div x-show="videoForm.url && getPreviewEmbedUrl(videoForm.url)" class="space-y-1.5 pt-1">
                                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">
                                        Preview Tautan Video:
                                    </label>
                                    <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-950 border border-slate-200 shadow-inner">
                                        <iframe :src="getPreviewEmbedUrl(videoForm.url)"
                                                class="w-full h-full border-0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>

                                <!-- Unsupported link notice -->
                                <div x-show="videoForm.url && !getPreviewEmbedUrl(videoForm.url)"
                                     class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4 shrink-0 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Tautan tidak dikenali. Mohon gunakan link YouTube, Google Drive, Vimeo, atau file video (.mp4/.webm/.ogg).</span>
                                </div>
                            </div>

                            <!-- Title Input (Common for both tabs) -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                    Judul Video <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                                </label>
                                <input type="text"
                                       x-model="videoForm.videoTitle"
                                       placeholder="Contoh: Penjelasan Lengkap Adjective & Tata Letak Kalimat"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-sm text-slate-900 transition">
                            </div>

                            <!-- Upload Progress Bar (Visible during saving/uploading) -->
                            <div x-show="videoForm.isSaving" class="space-y-2 pt-2">
                                <div class="flex items-center justify-between text-xs font-semibold">
                                    <span class="text-slate-700 flex items-center gap-1.5">
                                        <svg class="animate-spin w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span x-text="videoForm.tab === 'upload' && videoForm.file ? (videoForm.uploadProgress < 100 ? 'Mengunggah video ke server...' : 'Menyimpan & memproses video...') : 'Menyimpan video...'"></span>
                                    </span>
                                    <span class="text-blue-700 font-mono" x-show="videoForm.tab === 'upload' && videoForm.file" x-text="videoForm.uploadProgress + '%'"></span>
                                </div>
                                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                                    <div class="h-full bg-gradient-to-r from-blue-600 to-emerald-600 transition-all duration-150"
                                         :style="`width: ${videoForm.tab === 'upload' && videoForm.file ? videoForm.uploadProgress : 100}%`"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-slate-50 px-6 py-3.5 border-t border-slate-200 flex items-center justify-between gap-3">
                            <div>
                                <template x-if="videos[videoForm.sublesson]">
                                    <button type="button"
                                            @click="submitVideo('delete')"
                                            :disabled="videoForm.isSaving"
                                            class="px-3.5 py-2 rounded-xl text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 active:scale-95 transition cursor-pointer flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Hapus Video</span>
                                    </button>
                                </template>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button"
                                        @click="closeVideoModal()"
                                        :disabled="videoForm.isSaving"
                                        class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-800 hover:bg-slate-200/60 transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="button"
                                        @click="submitVideo('save')"
                                        :disabled="videoForm.isSaving || (videoForm.tab === 'upload' && !videoForm.file && !videos[videoForm.sublesson]?.file_path) || (videoForm.tab === 'url' && !isValidVideoUrl(videoForm.url))"
                                        class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none active:scale-95 transition shadow-sm cursor-pointer flex items-center gap-2">
                                    <svg x-show="videoForm.isSaving" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-text="videoForm.isSaving ? 'Menyimpan...' : (videoForm.tab === 'upload' && videoForm.file ? 'Upload & Simpan' : 'Simpan Video')"></span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>

    @php
        $flatTargets = [];
        if (!empty($activeTopic['scenarios']['sub_lessons'])) {
            foreach($activeTopic['scenarios']['sub_lessons'] as $sIdx => $sl) {
                foreach($sl['exercises'] as $exIdx => $ex) {
                    $flatTargets[] = [
                        'sub' => $sIdx,
                        'ans' => $ex['options'][$ex['correct_index']],
                        'src' => $ex['id_sentence'] ?? ''
                    ];
                }
            }
        }
    @endphp

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('selfStudyPlayer', () => ({
                sidebarOpen: true,
                subLessonsOpen: true,
                activeTab: 'outline',
                searchQuery: '',
                openModule: '{{ $activeModuleKey }}',
                userAnswers: @json($draftAnswers ?? (object)[]),
                questionSubmitted: @json($draftSubmitted ?? (object)[]),
                aiVerdicts: {},
                aiFeedback: {},
                aiPending: {},
                aiGradeUrl: '{{ route("self-study-classes.grade-translation") }}',
                submitted: false,
                showFeedback: false,
                isDarkMode: false,
                isFullscreen: false,
                viewMode: 'practice',
                selectedSubLesson: 0,
                isScrollingFromClick: false,
                targets: @json($flatTargets),
                storageKey: 'tb_self_study_draft_{{ $course }}_{{ $activeModuleKey }}_{{ $activeTopicKey }}_{{ auth()->id() ?? "guest" }}',
                scrollKey: 'tb_self_study_scroll_{{ $course }}_{{ $activeModuleKey }}_{{ $activeTopicKey }}_{{ auth()->id() ?? "guest" }}',
                draftUrl: '{{ route("self-study-classes.draft") }}',
                csrfToken: '{{ csrf_token() }}',
                saveBtnText: 'Save',
                saveTimer: null,
                scrollSaveTimer: null,
                isSaving: false,
                isAdmin: {{ $isAdmin ? 'true' : 'false' }},
                videos: @json($videos ?? (object)[]),
                videoModalOpen: false,
                videoForm: {
                    sublesson: '',
                    sublessonTitle: '',
                    tab: 'upload',
                    file: null,
                    fileName: '',
                    fileSize: '',
                    filePreviewUrl: '',
                    url: '',
                    videoTitle: '',
                    isSaving: false,
                    uploadProgress: 0,
                    error: ''
                },
                videoSaveUrl: '{{ route("self-study-classes.video") }}',
                init() {
                    if ('scrollRestoration' in history) {
                        history.scrollRestoration = 'manual';
                    }
                    this.restoreFromLocalStorage();
                    this.setupAutoSaveListeners();
                    this.$nextTick(() => {
                        this.initScrollSpy();
                        this.restoreScrollPosition();
                    });
                },
                saveScrollPosition() {
                    try {
                        const scrollContainer = document.querySelector('main');
                        if (!scrollContainer) return;
                        localStorage.setItem(this.scrollKey, scrollContainer.scrollTop);
                        localStorage.setItem(this.scrollKey + '_sub', this.selectedSubLesson ?? 0);
                    } catch (e) {}
                },
                restoreScrollPosition() {
                    const scrollContainer = document.querySelector('main');
                    if (!scrollContainer) return;
                    try {
                        const savedSub = localStorage.getItem(this.scrollKey + '_sub');
                        if (savedSub !== null) {
                            const subIdx = parseInt(savedSub, 10);
                            if (!isNaN(subIdx)) {
                                this.selectedSubLesson = subIdx;
                            }
                        }
                        const savedTop = localStorage.getItem(this.scrollKey);
                        if (savedTop !== null) {
                            const top = parseInt(savedTop, 10);
                            if (!isNaN(top) && top > 0) {
                                this.isScrollingFromClick = true;
                                scrollContainer.scrollTop = top;
                                setTimeout(() => {
                                    scrollContainer.scrollTop = top;
                                    this.isScrollingFromClick = false;
                                }, 100);
                                setTimeout(() => {
                                    scrollContainer.scrollTop = top;
                                    this.isScrollingFromClick = false;
                                }, 350);
                            }
                        }
                    } catch (e) {}
                },
                saveToLocalStorage() {
                    try {
                        const payload = {
                            answers: this.userAnswers,
                            submitted: this.questionSubmitted,
                            savedAt: Date.now()
                        };
                        localStorage.setItem(this.storageKey, JSON.stringify(payload));
                    } catch (e) {
                        console.error('Failed to save to localStorage:', e);
                    }
                },
                restoreFromLocalStorage() {
                    try {
                        const raw = localStorage.getItem(this.storageKey);
                        if (!raw) return;
                        const data = JSON.parse(raw);
                        if (!data) return;

                        if (data.answers && typeof data.answers === 'object') {
                            for (let k in data.answers) {
                                if (data.answers[k] && (!this.userAnswers[k] || !this.userAnswers[k].trim())) {
                                    this.userAnswers[k] = data.answers[k];
                                }
                            }
                        }

                        if (data.submitted && typeof data.submitted === 'object') {
                            for (let k in data.submitted) {
                                if (data.submitted[k]) {
                                    this.questionSubmitted[k] = true;
                                }
                            }
                        }
                    } catch (e) {
                        console.error('Failed to restore from localStorage:', e);
                    }
                },
                queueAutoSave() {
                    this.saveToLocalStorage();
                    clearTimeout(this.saveTimer);
                    this.saveTimer = setTimeout(() => {
                        this.syncDraft(false);
                    }, 600);
                },
                async syncDraft(isManual = false) {
                    if (this.isSaving) return;
                    this.saveToLocalStorage();
                    
                    if (isManual) {
                        this.saveBtnText = 'Menyimpan...';
                    }
                    this.isSaving = true;

                    let ok = false;
                    try {
                        const res = await fetch(this.draftUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                course: '{{ $course }}',
                                module: '{{ $activeModuleKey }}',
                                topic: '{{ $activeTopicKey }}',
                                answers: this.userAnswers,
                                submitted: this.questionSubmitted
                            }),
                            keepalive: true
                        });
                        ok = res.ok;
                    } catch (e) {
                        console.warn('Network sync failed, saved locally:', e);
                    } finally {
                        this.isSaving = false;
                        if (isManual) {
                            this.saveBtnText = 'Save';
                            this.showToast(ok ? '✓ Tersimpan' : '✓ Tersimpan di browser');
                        }
                    }
                    return ok;
                },
                manualSaveDraft() {
                    this.syncDraft(true);
                },
                showToast(msg) {
                    const existing = document.getElementById('autosave-toast');
                    if (existing) existing.remove();

                    const toast = document.createElement('div');
                    toast.id = 'autosave-toast';
                    toast.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-emerald-600 text-white px-4 py-2 rounded-xl shadow-xl z-50 text-sm font-semibold flex items-center gap-2 pointer-events-none transition-all duration-300';
                    toast.innerHTML = `<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> <span>${msg}</span>`;
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translate(-50%, 10px)';
                        setTimeout(() => toast.remove(), 350);
                    }, 2500);
                },
                setupAutoSaveListeners() {
                    setInterval(() => {
                        if (Object.keys(this.userAnswers).some(k => this.userAnswers[k] && this.userAnswers[k].trim())) {
                            this.syncDraft(false);
                        }
                    }, 45000);

                    document.addEventListener('visibilitychange', () => {
                        if (document.visibilityState === 'hidden') {
                            this.saveScrollPosition();
                            this.syncDraft(false);
                        }
                    });

                    window.addEventListener('pageshow', () => {
                        this.restoreFromLocalStorage();
                        this.restoreScrollPosition();
                    });

                    window.addEventListener('beforeunload', () => {
                        this.saveScrollPosition();
                        this.saveToLocalStorage();
                        this.syncDraft(false);
                    });

                    window.addEventListener('online', () => {
                        this.syncDraft(false);
                    });
                },
                initScrollSpy() {
                    const scrollContainer = document.querySelector('main');
                    if (!scrollContainer) return;
                    
                    const updateActiveSubLessonOnScroll = () => {
                        if (this.isScrollingFromClick || this.viewMode !== 'practice') return;
                        
                        if (!this.scrollSaveTimer) {
                            this.scrollSaveTimer = setTimeout(() => {
                                this.saveScrollPosition();
                                this.scrollSaveTimer = null;
                            }, 150);
                        }
                        
                        const containerTop = scrollContainer.getBoundingClientRect().top;
                        const blocks = document.querySelectorAll('[id^="sublesson-block-"]');
                        let currentIdx = this.selectedSubLesson;
                        
                        blocks.forEach((block) => {
                            const rect = block.getBoundingClientRect();
                            if (rect.top - containerTop <= 160 && rect.bottom - containerTop > 80) {
                                const idParts = block.id.split('-');
                                const idx = parseInt(idParts[idParts.length - 1], 10);
                                if (!isNaN(idx)) {
                                    currentIdx = idx;
                                }
                            }
                        });
                        
                        if (currentIdx !== this.selectedSubLesson) {
                            this.selectedSubLesson = currentIdx;
                            this.saveScrollPosition();
                        }
                    };
                    
                    scrollContainer.addEventListener('scroll', updateActiveSubLessonOnScroll, { passive: true });
                },
                isQuestionSubmitted(idx) {
                    return this.submitted || !!this.questionSubmitted[idx];
                },
                submitQuestion(idx) {
                    if (!this.userAnswers[idx] || !this.userAnswers[idx].trim()) return;
                    this.questionSubmitted[idx] = true;
                    this.queueAutoSave();
                    this.requestAiGrading(idx);
                },
                resetQuestion(idx) {
                    this.userAnswers[idx] = '';
                    this.questionSubmitted[idx] = false;
                    delete this.aiVerdicts[idx];
                    delete this.aiFeedback[idx];
                    this.aiPending[idx] = false;
                    this.queueAutoSave();
                },
                submitAll() {
                    this.submitted = true;
                    this.showFeedback = true;
                    for (let k in this.userAnswers) {
                        if (this.userAnswers[k] && this.userAnswers[k].trim()) {
                            this.questionSubmitted[k] = true;
                            this.requestAiGrading(k);
                        }
                    }
                    this.queueAutoSave();
                },
                selectSubLesson(idx, mode = null) {
                    this.selectedSubLesson = idx;
                    if (mode) {
                        this.viewMode = mode;
                    }
                    this.isScrollingFromClick = true;
                    this.$nextTick(() => {
                        let targetId = 'sublesson-block-' + (idx ?? 0);
                        if (this.viewMode === 'study') {
                            targetId = 'study-rule-' + (idx ?? 0);
                        } else if (this.viewMode === 'answers') {
                            targetId = 'answer-sublesson-block-' + (idx ?? 0);
                        }
                        let el = document.getElementById(targetId);
                        if (el) {
                            const mainEl = document.querySelector('main');
                            if (mainEl) {
                                const topOffset = el.getBoundingClientRect().top - mainEl.getBoundingClientRect().top + mainEl.scrollTop - 20;
                                mainEl.scrollTo({ top: topOffset, behavior: 'smooth' });
                            } else {
                                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        }
                        setTimeout(() => {
                            this.isScrollingFromClick = false;
                            this.saveScrollPosition();
                        }, 800);
                    });
                },
                nextSubLesson() {
                    if (this.selectedSubLesson === null) {
                        this.selectSubLesson(0);
                    } else if (this.selectedSubLesson < 7) {
                        this.selectSubLesson(this.selectedSubLesson + 1);
                    }
                },
                prevSubLesson() {
                    if (this.selectedSubLesson !== null && this.selectedSubLesson > 0) {
                        this.selectSubLesson(this.selectedSubLesson - 1);
                    }
                },
                normalizeText(str) {
                    if (!str) return '';
                    return str.toString()
                              .toLowerCase()
                              .replace(/[.,\/#!$%\^&\*;:{}=\-_`~()?\x22']/g, '')
                              .replace(/\s+/g, ' ')
                              .trim();
                },
                quickMatch(userAns, targetAns) {
                    if (!userAns || !targetAns) return false;
                    let u = this.normalizeText(userAns);
                    let t = this.normalizeText(targetAns);
                    if (u === t) return true;
                    return u.length > 5 && (t.includes(u) || u.includes(t));
                },
                isAnswerCorrect(userAns, targetAns, idx) {
                    if (!userAns || !targetAns) return false;
                    if (idx !== undefined && idx !== null && this.aiVerdicts[idx] !== undefined && this.aiVerdicts[idx] !== null) {
                        return this.aiVerdicts[idx];
                    }
                    return this.quickMatch(userAns, targetAns);
                },
                requestAiGrading(idx) {
                    const target = this.targets ? this.targets[idx] : null;
                    const userAns = this.userAnswers[idx];
                    if (!target || !userAns || !userAns.trim()) return;
                    // Obvious near-exact matches don't need a round trip to the AI.
                    if (this.quickMatch(userAns, target.ans)) return;
                    if (this.aiVerdicts[idx] !== undefined || this.aiPending[idx]) return;

                    this.aiPending[idx] = true;
                    fetch(this.aiGradeUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            source: target.src || '',
                            user_answer: userAns,
                            model_answer: target.ans,
                        }),
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.aiPending[idx] = false;
                        if (data && typeof data.correct === 'boolean') {
                            this.aiVerdicts[idx] = data.correct;
                            this.aiFeedback[idx] = data.feedback || '';
                        }
                    })
                    .catch(() => {
                        this.aiPending[idx] = false;
                    });
                },
                calculateScore(subLessonIdx = null) {
                    let correct = 0;
                    if (this.targets && this.targets.length > 0) {
                        for (let i = 0; i < this.targets.length; i++) {
                            if (subLessonIdx !== null && this.targets[i].sub !== subLessonIdx) continue;
                            if (this.isAnswerCorrect(this.userAnswers[i], this.targets[i].ans, i)) {
                                correct++;
                            }
                        }
                    }
                    return correct;
                },
                toggleFullscreen() {
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen();
                        this.isFullscreen = true;
                    } else {
                        if (document.exitFullscreen) {
                            document.exitFullscreen();
                            this.isFullscreen = false;
                        }
                    }
                },
                openVideoModal(sublessonCode, sublessonName) {
                    this.videoForm.sublesson = sublessonCode;
                    this.videoForm.sublessonTitle = sublessonName;
                    const existing = this.videos[sublessonCode];
                    this.videoForm.url = existing ? (existing.original_url || existing.embed_url || '') : '';
                    this.videoForm.videoTitle = existing ? (existing.title || '') : '';
                    this.videoForm.file = null;
                    this.videoForm.fileName = existing?.file_name || '';
                    this.videoForm.fileSize = existing?.file_size ? (existing.file_size / (1024 * 1024)).toFixed(1) + ' MB' : '';
                    if (this.videoForm.filePreviewUrl) {
                        try { URL.revokeObjectURL(this.videoForm.filePreviewUrl); } catch (e) {}
                    }
                    this.videoForm.filePreviewUrl = '';
                    this.videoForm.tab = (existing && existing.file_path) ? 'upload' : (existing ? 'url' : 'upload');
                    this.videoForm.error = '';
                    this.videoForm.isSaving = false;
                    this.videoForm.uploadProgress = 0;
                    this.videoModalOpen = true;
                },
                closeVideoModal() {
                    if (this.videoForm.filePreviewUrl) {
                        try { URL.revokeObjectURL(this.videoForm.filePreviewUrl); } catch (e) {}
                    }
                    this.videoForm.filePreviewUrl = '';
                    this.videoForm.file = null;
                    this.videoModalOpen = false;
                },
                handleFileSelect(event) {
                    const file = event.target.files && event.target.files[0];
                    if (file) {
                        this.setUploadFile(file);
                    }
                },
                handleFileDrop(event) {
                    const file = event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files[0];
                    if (file) {
                        if (!file.type.startsWith('video/') && !file.name.match(/\.(mp4|webm|mov|ogg|mkv|m4v)$/i)) {
                            this.videoForm.error = 'File yang dijatuhkan bukan file video yang didukung.';
                            return;
                        }
                        this.setUploadFile(file);
                    }
                },
                setUploadFile(file) {
                    if (this.videoForm.filePreviewUrl) {
                        try { URL.revokeObjectURL(this.videoForm.filePreviewUrl); } catch (e) {}
                    }
                    this.videoForm.file = file;
                    this.videoForm.fileName = file.name;
                    this.videoForm.fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                    this.videoForm.filePreviewUrl = URL.createObjectURL(file);
                    this.videoForm.error = '';
                    if (!this.videoForm.videoTitle || !this.videoForm.videoTitle.trim()) {
                        const baseName = file.name.replace(/\.[^/.]+$/, "");
                        this.videoForm.videoTitle = baseName.replace(/[-_]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    }
                },
                removeUploadFile() {
                    if (this.videoForm.filePreviewUrl) {
                        try { URL.revokeObjectURL(this.videoForm.filePreviewUrl); } catch (e) {}
                    }
                    this.videoForm.file = null;
                    this.videoForm.fileName = '';
                    this.videoForm.fileSize = '';
                    this.videoForm.filePreviewUrl = '';
                    if (this.$refs.fileInput) {
                        this.$refs.fileInput.value = '';
                    }
                },
                getPreviewEmbedUrl(url) {
                    if (!url) return '';
                    url = url.trim();
                    const iframeMatch = url.match(/<iframe.*?src=["']([^"']+)["']/i);
                    if (iframeMatch) url = iframeMatch[1].trim();

                    const ytMatch = url.match(/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|v\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i);
                    if (ytMatch) {
                        return `https://www.youtube-nocookie.com/embed/${ytMatch[1]}`;
                    }
                    const gdMatch = url.match(/drive\.google\.com\/(?:file\/d\/|open\?id=)([a-zA-Z0-9_-]+)/i);
                    if (gdMatch) {
                        return `https://drive.google.com/file/d/${gdMatch[1]}/preview`;
                    }
                    const vimMatch = url.match(/(?:vimeo\.com\/(?:video\/)?|player\.vimeo\.com\/video\/)([0-9]+)/i);
                    if (vimMatch) {
                        return `https://player.vimeo.com/video/${vimMatch[1]}`;
                    }
                    if (/\.(mp4|webm|ogg)($|\?)/i.test(url)) {
                        return url;
                    }
                    // Unrecognized link: don't embed arbitrary third-party URLs.
                    return '';
                },
                isValidVideoUrl(url) {
                    return !!this.getPreviewEmbedUrl(url);
                },
                submitVideo(action = 'save') {
                    if (action === 'delete') {
                        if (!confirm('Apakah Anda yakin ingin menghapus video penjelasan ini?')) {
                            return;
                        }
                    }
                    if (action === 'save') {
                        if (this.videoForm.tab === 'upload' && !this.videoForm.file && !this.videos[this.videoForm.sublesson]?.file_path) {
                            this.videoForm.error = 'Mohon pilih file video yang ingin diunggah.';
                            return;
                        }
                        if (this.videoForm.tab === 'url' && !this.videoForm.url.trim()) {
                            this.videoForm.error = 'Mohon masukkan tautan video terlebih dahulu.';
                            return;
                        }
                    }

                    this.videoForm.isSaving = true;
                    this.videoForm.uploadProgress = 0;
                    this.videoForm.error = '';

                    const formData = new FormData();
                    formData.append('course', '{{ $course }}');
                    formData.append('module', '{{ $activeModuleKey }}');
                    formData.append('topic', '{{ $activeTopicKey }}');
                    formData.append('sublesson', this.videoForm.sublesson);
                    formData.append('action', action);
                    formData.append('title', this.videoForm.videoTitle || '');
                    formData.append('source_type', this.videoForm.tab);

                    if (action === 'save') {
                        if (this.videoForm.tab === 'upload' && this.videoForm.file) {
                            formData.append('video_file', this.videoForm.file);
                        } else if (this.videoForm.tab === 'url') {
                            formData.append('url', this.videoForm.url.trim());
                        }
                    }

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', this.videoSaveUrl, true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', this.csrfToken);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    if (xhr.upload) {
                        xhr.upload.onprogress = (e) => {
                            if (e.lengthComputable) {
                                const percent = Math.round((e.loaded / e.total) * 100);
                                this.videoForm.uploadProgress = percent;
                            }
                        };
                    }

                    xhr.onload = () => {
                        this.videoForm.isSaving = false;
                        try {
                            const data = JSON.parse(xhr.responseText);
                            if (xhr.status >= 200 && xhr.status < 300 && data.success) {
                                if (action === 'delete') {
                                    delete this.videos[this.videoForm.sublesson];
                                    this.showToast('✓ Video penjelasan berhasil dihapus');
                                } else {
                                    this.videos[this.videoForm.sublesson] = data.video;
                                    this.showToast('✓ Video penjelasan berhasil disimpan');
                                }
                                this.closeVideoModal();
                            } else {
                                this.videoForm.error = data.message || 'Gagal menyimpan video.';
                            }
                        } catch (err) {
                            this.videoForm.error = 'Terjadi kesalahan respons dari server.';
                        }
                    };

                    xhr.onerror = () => {
                        this.videoForm.isSaving = false;
                        this.videoForm.error = 'Terjadi kesalahan koneksi saat mengunggah video.';
                    };

                    xhr.send(formData);
                }
            }));
        });
    </script>
</body>
</html>
