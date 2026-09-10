@php
    // Sidebar suppressed entirely during admin's "Live Student View" preview
    // (?live_preview_for=... - see admin/students/current-assignment.blade.php).
    // Simpler and far more robust than swapping to the "correct" role's
    // sidebar across the 20+ pages that each independently @include this
    // file - that approach kept regressing whenever a previewed page used
    // a layout that hadn't also been patched with the same override.
    if (request()->query('live_preview_for')) {
        // No sidebar to offset for in this mode, but many pages that
        // @include this file hardcode a "md:ml-64"-style left margin on
        // their own <main> (an older pattern predating program-sidebar
        // .blade.php's CSS-variable approach) - without this override,
        // that margin stays applied even though the sidebar it was meant
        // to clear never rendered, leaving a dead gap in its place.
        echo '<style>main{margin-left:0 !important;}</style>';
        return;
    }
@endphp
{{-- Guest Sidebar Component --}}
<style>
    .guest-sidebar-shell {
        width: 16rem;
    }

    @media (min-width: 768px) {
        body.has-guest-sidebar main {
            margin-left: var(--guest-sidebar-offset, 16rem) !important;
            transition: margin-left .2s ease;
        }

        .guest-sidebar-shell {
            width: var(--guest-sidebar-width, 16rem);
        }

        body.sidebar-collapsed main {
            margin-left: 4rem !important;
        }
    }

    .sidebar-collapsed .sidebar-title,
    .sidebar-collapsed .sidebar-menu p,
    .sidebar-collapsed .sidebar-menu .sidebar-cta {
        display: none;
    }

    .sidebar-collapsed .sidebar-menu nav a,
    .sidebar-collapsed .sidebar-menu nav button {
        justify-content: center;
        padding-left: 0.625rem;
        padding-right: 0.625rem;
        font-size: 0;
    }

    .sidebar-collapsed .sidebar-menu nav a svg,
    .sidebar-collapsed .sidebar-menu nav button svg {
        margin-right: 0;
        flex-shrink: 0;
    }
</style>
<div x-data="{ mobileSidebarOpen: false }">
<button
    type="button"
    @click="mobileSidebarOpen = true"
    class="md:hidden fixed top-4 left-4 z-[9999] inline-flex items-center justify-center w-11 h-11 rounded-xl bg-blue-600 border border-blue-700 shadow-xl text-white"
    aria-label="Open menu">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
</button>

<div x-show="mobileSidebarOpen" x-transition.opacity class="md:hidden fixed inset-0 bg-black/40 z-40" @click="mobileSidebarOpen = false"></div>

<aside class="guest-sidebar-shell bg-white shadow-md fixed h-full z-50 md:z-10 transform transition-all duration-200 md:translate-x-0"
    :class="(mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0')">
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto pb-4">

            {{-- Brand --}}
            <div class="p-6 flex items-center gap-3 justify-between relative">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/brand/icon.png') }}" class="w-16 h-16 rounded-lg object-contain" alt="TB">
                    <span class="sidebar-title text-xl font-bold text-[#0fa2ec]">Target Bahasa</span>
                </div>
                <button type="button" @click="mobileSidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700" aria-label="Close menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Free Test Section --}}
            <div class="sidebar-menu px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 mb-4 uppercase tracking-wider">Explore</p>
                <nav class="space-y-1">
                    {{-- Free Lesson --}}
                    <a href="{{ route('free-lesson') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('free-lesson') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Free Lesson
                    </a>

                    {{-- Guest Free Tests --}}
                    <a href="{{ route('guest.free-tests') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guest.free-tests') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                        Guest Free Tests
                    </a>

                    {{-- My English (Guest Progress) --}}
                    <a href="{{ route('guest.my-english') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guest.my-english') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        My English
                    </a>

                    {{-- Scholarship Search --}}
                    <a href="{{ route('scholarships.search.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('scholarships.search.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6"></path></svg>
                        Scholarship Search
                    </a>

                    {{-- Overseas Jobs --}}
                    <a href="{{ route('overseas-jobs.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('overseas-jobs.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Overseas Jobs
                    </a>

                    {{-- Working Holiday Visa Australia --}}
                    <a href="{{ route('whv-applications.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('whv-applications.*') ? 'bg-amber-50 text-amber-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8.97 5.7a1 1 0 01-1.06 0L4 7m16 0a2 2 0 00-2-2H6a2 2 0 00-2 2m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m9 10.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"></path></svg>
                        WHV Australia
                    </a>
                </nav>
            </div>

            {{-- Marketing & Outreach --}}
            <div class="sidebar-menu px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 mb-4 uppercase tracking-wider">Marketing & Outreach</p>
                <nav class="space-y-1">
                    {{-- School English Camp --}}
                    <a href="{{ route('school-program') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('school-program') ? 'bg-amber-50 text-amber-700' : 'text-gray-500 hover:bg-amber-50 hover:text-amber-700' }} rounded-xl font-medium transition group">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="flex-1 min-w-0 truncate">School English Camp</span>
                    </a>
                </nav>
            </div>

            {{-- CTA to Register --}}
            <div class="sidebar-menu sidebar-cta px-6 mt-4">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-4 text-white">
                    <p class="text-sm font-bold mb-1">🎯 Mulai Belajar</p>
                    <p class="text-xs text-blue-100 mb-3">Daftar sekarang untuk mengakses semua fitur belajar.</p>
                    <a href="{{ route('student.register.entry') }}" class="block text-center bg-white text-blue-700 font-bold text-xs py-2 px-3 rounded-lg hover:bg-blue-50 transition">
                        Daftar Gratis
                    </a>
                </div>
            </div>

        </div>

        {{-- Footer Auth Links --}}
        <div class="sidebar-menu mt-auto px-6 py-6 border-t border-gray-100 bg-white flex-shrink-0">
            <nav class="space-y-1 mb-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </nav>
            <p class="text-xs font-semibold text-gray-400 mb-4 uppercase tracking-wider">AKUN - GUEST</p>
            <nav class="space-y-1">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition w-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Log Out
                        </a>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Log In
                    </a>
                    <a href="{{ route('student.register.entry') }}" class="flex items-center gap-3 px-4 py-3 text-blue-600 hover:bg-blue-50 rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Sign Up
                    </a>
                @endauth
            </nav>
        </div>
    </div>
</aside>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mainEl = document.querySelector('main');
        if (mainEl) {
            mainEl.classList.add('mobile-sidebar-safe');
        }
    });
</script>
