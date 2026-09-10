@php
    $programSidebarAlwaysVisible = $programSidebarAlwaysVisible ?? false;
    $programSidebarIsAdminOrTeacher = Auth::check() && (optional(Auth::user())->isAdmin() || optional(Auth::user())->isTeacher());
    $programSidebarIsStudent = Auth::check() && optional(Auth::user())->isStudent();
@endphp

@if($programSidebarIsAdminOrTeacher)
    @include('components.sidebar-admin')
    <style>
        body.has-admin-sidebar {
            margin-left: var(--admin-sidebar-offset, 16rem) !important;
            transition: margin-left .2s ease;
        }

        /* This page's <body> has its own padding (unlike the plain admin
           layout), which shifts the sidebar's fixed-position static-position
           fallback away from the viewport edge. Pin it explicitly. */
        body.has-admin-sidebar .admin-sidebar-shell,
        body.has-admin-sidebar > button[aria-label="Open menu"] {
            left: 0 !important;
        }

        @media (max-width: 767px) {
            body.has-admin-sidebar {
                margin-left: 0 !important;
            }

            body.has-admin-sidebar .admin-sidebar-shell {
                left: 0 !important;
            }
        }
    </style>
@elseif($programSidebarIsStudent)
    @include('components.sidebar-student')
    <style>
        body.has-student-sidebar {
            margin-left: var(--student-sidebar-offset, 16rem) !important;
            transition: margin-left .2s ease;
        }

        /* Same static-position fix as the admin sidebar branch above: this
           page's <body> padding shifts the sidebar's fixed-position fallback
           away from the viewport edge without an explicit left:0. */
        body.has-student-sidebar .student-sidebar-shell,
        body.has-student-sidebar > button[aria-label="Open menu"] {
            left: 0 !important;
        }

        @media (max-width: 767px) {
            body.has-student-sidebar {
                margin-left: 0 !important;
            }

            body.has-student-sidebar .student-sidebar-shell {
                left: 0 !important;
            }
        }
    </style>
@else
<div x-data="{
        programSidebarOpen: {{ $programSidebarAlwaysVisible ? 'true' : 'false' }},
        sidebarCollapsed: JSON.parse(localStorage.getItem('programSidebarCollapsed') || 'false')
    }"
    x-effect="
        localStorage.setItem('programSidebarCollapsed', JSON.stringify(sidebarCollapsed));
        document.body.classList.toggle('program-sidebar-open', programSidebarOpen && !sidebarCollapsed);
        document.body.classList.toggle('program-sidebar-collapsed', programSidebarOpen && sidebarCollapsed);
        window.dispatchEvent(new CustomEvent('program-sidebar-change', { detail: { open: programSidebarOpen } }));
    ">
    <style>
        @media (min-width: 1024px) {
            body {
                margin-left: 0;
                transition: margin-left 300ms ease-in-out;
            }

            body.program-sidebar-open {
                margin-left: 18rem;
            }

            body.program-sidebar-collapsed {
                margin-left: 4rem;
            }
        }

        .sidebar-collapsed-program .sidebar-menu p,
        .sidebar-collapsed-program .sidebar-title {
            display: none;
        }

        .sidebar-collapsed-program .sidebar-menu nav a,
        .sidebar-collapsed-program .sidebar-menu nav button {
            justify-content: center;
            padding-left: 0.625rem;
            padding-right: 0.625rem;
            font-size: 0;
        }

        .sidebar-collapsed-program .sidebar-menu nav a svg,
        .sidebar-collapsed-program .sidebar-menu nav button svg {
            margin-right: 0;
            flex-shrink: 0;
        }

        .program-collapse-toggle {
            display: inline-flex;
        }

        body.has-fixed-bottom-player .program-sidebar-account-safe {
            padding-bottom: 6rem;
        }

        body.has-fixed-bottom-player .program-sidebar-scroll-safe {
            padding-bottom: 5rem;
        }

        @media (max-width: 767px) {
            .program-collapse-toggle {
                display: none !important;
            }
        }
    </style>
    <button @click="programSidebarOpen = true" x-show="!programSidebarOpen" 
            class="fixed top-6 left-6 z-40 p-2.5 bg-white rounded-xl shadow-lg border border-gray-100 text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center group"
            title="Open Menu">
        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

        <div x-show="programSidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="programSidebarOpen = false"
             class="fixed inset-0 z-40 lg:hidden" 
         style="display: none;"></div>

        <aside class="fixed inset-y-0 left-0 bg-white shadow-2xl z-50 transform transition-all duration-300 ease-in-out flex flex-col pt-0 h-full overflow-hidden"
            :class="(sidebarCollapsed ? 'w-16 sidebar-collapsed-program ' : 'w-72 ') + (programSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0')">
        
        <div class="flex items-center border-b border-gray-100 bg-gray-50 flex-shrink-0"
             :class="sidebarCollapsed ? 'justify-center p-2' : 'justify-between p-6'">

            {{-- Brand (hidden when collapsed) --}}
            <div class="flex items-center gap-3" x-show="!sidebarCollapsed" x-transition.opacity>
                <img src="{{ asset('images/brand/icon.png') }}" class="w-16 h-16 rounded-xl object-contain shadow-sm" alt="TB">
                <span class="sidebar-title text-xl font-bold text-[#0fa2ec]">Target Bahasa</span>
            </div>

            {{-- Collapse / Expand toggle --}}
            <button type="button"
                    @click="sidebarCollapsed = !sidebarCollapsed"
                    class="program-collapse-toggle items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition flex-shrink-0"
                    :aria-label="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                    :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'">
                <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            {{-- Mobile close button --}}
            <button @click="programSidebarOpen = false"
                    class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors focus:outline-none md:hidden"
                    x-show="!sidebarCollapsed">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col program-sidebar-scroll-safe">
            @if(Auth::check())
                @if(in_array(optional(Auth::user())->role, ['guest', 'guest_quick']))
                    {{-- Guest Menu --}}
                    <div class="sidebar-menu px-6 py-4">
                        <p class="text-xs font-semibold text-gray-400 mb-4 uppercase tracking-wider">Explore</p>
                        <nav class="space-y-1">
                            <a href="{{ route('free-lesson') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('free-lesson') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span>Free Lesson</span>
                            </a>
                            <a href="{{ route('guest.free-tests') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guest.free-tests') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                                <span>Guest Free Tests</span>
                            </a>
                            <a href="{{ route('guest.my-english') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guest.my-english') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                                <span>My English</span>
                            </a>
                            <a href="{{ route('scholarships.search.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('scholarships.search.*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                <span>Scholarship Search</span>
                            </a>
                            <a href="{{ route('overseas-jobs.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('overseas-jobs.*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>Overseas Jobs</span>
                            </a>
                            <a href="{{ route('whv-applications.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('whv-applications.*') ? 'bg-amber-50 text-amber-600 border-l-4 border-amber-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>WHV Australia</span>
                            </a>
                        </nav>
                    </div>

                    {{-- CTA to Register --}}
                    <div class="sidebar-menu px-6 mt-2">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-4 text-white">
                            <p class="text-sm font-bold mb-1">🎯 Mulai Belajar</p>
                            <p class="text-xs text-blue-100 mb-3">Daftar sekarang untuk mengakses semua fitur belajar.</p>
                            <a href="{{ route('student.register.entry') }}" class="block text-center bg-white text-blue-700 font-bold text-xs py-2 px-3 rounded-lg hover:bg-blue-50 transition">
                                Daftar Gratis
                            </a>
                        </div>
                    </div>

                    {{-- Guest Account Footer --}}
                    <div class="sidebar-menu mt-auto px-6 py-6 border-t border-gray-100 bg-white flex-shrink-0">
                        <p class="text-xs font-semibold text-gray-400 mb-4 uppercase tracking-wider">AKUN - GUEST</p>
                        <nav class="space-y-1">
                            <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                <span>Kembali ke Beranda</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition w-full text-left">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Log Out
                                </button>
                            </form>
                        </nav>
                    </div>
                @else
                    @include('components.student-sidebar')
                @endif
            @endif
        </div>
    </aside>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fixedBottomBars = document.querySelectorAll('.fixed.bottom-0.left-0.right-0');
        if (fixedBottomBars.length > 0) {
            document.body.classList.add('has-fixed-bottom-player');
        }
    });
</script>
