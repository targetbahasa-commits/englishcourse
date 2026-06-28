<!-- Teacher Sidebar Component -->
<style>
    .teacher-sidebar-shell {
        width: 16rem;
    }

    @media (min-width: 768px) {
        body.has-teacher-sidebar main {
            margin-left: var(--teacher-sidebar-offset, 16rem) !important;
            transition: margin-left .2s ease;
        }

        .teacher-sidebar-shell {
            width: var(--teacher-sidebar-width, 16rem);
        }

        body.sidebar-collapsed main {
            margin-left: 4rem !important;
        }
    }

    .sidebar-collapsed .sidebar-title,
    .sidebar-collapsed .sidebar-menu p {
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

    .sidebar-desktop-toggle {
        display: inline-flex;
    }

    @media (max-width: 767px) {
        .sidebar-desktop-toggle {
            display: none !important;
        }
    }

    @media (max-width: 767px) {
        .mobile-sidebar-safe {
            padding-left: 3.5rem;
        }
    }
</style>
<div x-data="{
    mobileSidebarOpen: false,
    sidebarCollapsed: JSON.parse(localStorage.getItem('teacherSidebarCollapsed') || 'false')
}"
     x-effect="
        localStorage.setItem('teacherSidebarCollapsed', JSON.stringify(sidebarCollapsed));
        document.body.classList.toggle('sidebar-collapsed', sidebarCollapsed);
        document.body.classList.add('has-teacher-sidebar');
        document.documentElement.style.setProperty('--teacher-sidebar-width', sidebarCollapsed ? '4rem' : '16rem');
        document.documentElement.style.setProperty('--teacher-sidebar-offset', sidebarCollapsed ? '4rem' : '16rem');
     ">
<button
    type="button"
    @click="mobileSidebarOpen = true"
    class="md:hidden fixed top-4 left-4 z-[9999] inline-flex items-center justify-center w-11 h-11 rounded-xl bg-blue-600 border border-blue-700 shadow-xl text-white"
    aria-label="Open menu">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
</button>

<div x-show="mobileSidebarOpen" x-transition.opacity class="md:hidden fixed inset-0 bg-black/40 z-40" @click="mobileSidebarOpen = false"></div>

<aside class="teacher-sidebar-shell bg-white shadow-md fixed h-full z-50 md:z-10 transform transition-all duration-200 md:translate-x-0"
    :class="(mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0')">
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto pb-4">
        <div class="p-6 flex items-center gap-3 justify-between">
            <div class="flex items-center gap-3">
            <img src="{{ asset('images/brand/icon.png') }}" class="w-16 h-16 rounded-lg object-contain" alt="TB">
            <span class="sidebar-title text-xl font-bold text-[#0fa2ec]" x-show="!sidebarCollapsed" x-transition.opacity>Target Bahasa</span>
            </div>

            <button type="button" @click="sidebarCollapsed = !sidebarCollapsed" class="sidebar-desktop-toggle items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" :aria-label="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'" :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'">
                <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <button type="button" @click="mobileSidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700" aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="sidebar-menu px-6 py-4">
        <p class="text-xs font-semibold text-gray-400 mb-4">MAIN MENU</p>
        <nav class="space-y-1">
            <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('teacher.dashboard') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('assignments.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Assignments
            </a>
            <a href="{{ route('final-test') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('final-test*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m5-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Final Test
            </a>
            <a href="{{ route('free-lesson') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('free-lesson') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Free Lesson
            </a>
            <a href="{{ route('teacher.dashboard', ['section' => 'guest_free_tests']) }}" class="flex items-center gap-3 px-4 py-3 {{ request('section') === 'guest_free_tests' ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                Guest Free Tests
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                My Students
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Grading
            </a>
            <a href="{{ route('teacher.attendance.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('teacher.attendance.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Attendance
            </a>
            <a href="{{ route('teacher.evaluations.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('teacher.evaluations.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                My Evaluations
            </a>
        </nav>
    </div>
    
    <div class="sidebar-menu mt-auto px-6 py-6 border-t border-gray-100 bg-white flex-shrink-0">
        <p class="text-xs font-semibold text-gray-400 mb-4">ACCOUNT - TEACHER</p>
        <nav class="space-y-1">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-medium transition w-full text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Log Out
                </button>
            </form>
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
