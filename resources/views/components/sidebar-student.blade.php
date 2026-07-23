<!-- Student Sidebar Component -->
<style>
    .student-sidebar-shell {
        width: 16rem;
    }

    @media (min-width: 768px) {
        body.has-student-sidebar main {
            margin-left: var(--student-sidebar-offset, 16rem) !important;
            transition: margin-left .2s ease;
        }

        .student-sidebar-shell {
            width: var(--student-sidebar-width, 16rem);
        }

        body.sidebar-collapsed main {
            margin-left: 4rem !important;
        }
    }

    .sidebar-collapsed .sidebar-title,
    .sidebar-collapsed .sidebar-menu p {
        display: none;
    }

    .sidebar-collapsed .sidebar-header {
        padding: 0.75rem 0.25rem;
        justify-content: center;
        position: relative;
    }

    .sidebar-collapsed .sidebar-brand {
        width: 100%;
        justify-content: center;
        gap: 0;
    }

    .sidebar-collapsed .sidebar-logo {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.75rem;
    }

    .sidebar-collapsed .sidebar-desktop-toggle {
        position: absolute;
        right: 0.25rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.75rem;
        height: 1.75rem;
        border: 1px solid #dbeafe;
        border-radius: 9999px;
        background: #eff6ff;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.12);
        color: #2563eb;
        z-index: 20;
    }

    .sidebar-collapsed .sidebar-menu {
        padding-left: 0.25rem;
        padding-right: 0.25rem;
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
            padding-left: 3rem;
        }
    }
</style>
<div x-data="{
    mobileSidebarOpen: false,
    sidebarCollapsed: JSON.parse(localStorage.getItem('studentSidebarCollapsed') || 'false')
}"
     x-effect="
        localStorage.setItem('studentSidebarCollapsed', JSON.stringify(sidebarCollapsed));
        document.body.classList.toggle('sidebar-collapsed', sidebarCollapsed);
        document.body.classList.add('has-student-sidebar');
        document.documentElement.style.setProperty('--student-sidebar-width', sidebarCollapsed ? '4rem' : '16rem');
        document.documentElement.style.setProperty('--student-sidebar-offset', sidebarCollapsed ? '4rem' : '16rem');
     ">
<button
    type="button"
    @click="mobileSidebarOpen = true"
    class="md:hidden fixed top-4 left-4 z-[9999] inline-flex items-center justify-center w-11 h-11 rounded-xl bg-blue-600 border border-blue-700 shadow-xl text-white"
    aria-label="Open menu">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
</button>

<div x-show="mobileSidebarOpen" x-transition.opacity class="md:hidden fixed inset-0 bg-black/40 z-40" @click="mobileSidebarOpen = false"></div>

<aside class="student-sidebar-shell bg-white shadow-md fixed h-full z-50 md:z-10 transform transition-all duration-200 md:translate-x-0"
    :class="(mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0')">
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto pb-4">
        <div class="sidebar-header p-6 flex items-center gap-3 justify-between">
            <div class="sidebar-brand flex items-center gap-3">
            <img src="{{ asset('images/brand/icon.png') }}" class="sidebar-logo w-16 h-16 rounded-lg object-contain" alt="TB">
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
        <p class="text-xs font-semibold text-gray-400 mb-4">MENU UTAMA</p>
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') || request()->routeIs('student.dashboard') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('assignments.*') && !request()->routeIs('final-test*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Assignments
            </a>
            <a href="{{ route('mock-test') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('mock-test*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Mock Test
            </a>
            <a href="{{ route('final-test') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('final-test*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Final Test
            </a>
            <a href="{{ route('student.schedule') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('student.schedule') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Schedule
            </a>
            <a href="{{ route('student.progress') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('student.progress') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                My Progress
            </a>
            <a href="{{ route('student.payments.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('student.payments.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2M5 9h14l1 10a2 2 0 01-2 2H6a2 2 0 01-2-2L5 9z"></path></svg>
                Payments
            </a>
            <a href="{{ route('free-lesson') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('free-lesson') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Free Lesson
            </a>

            <a href="{{ route('scholarships.search.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('scholarships.search.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6"></path></svg>
                Scholarship Search
            </a>
            <a href="{{ route('overseas-jobs.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('overseas-jobs.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Overseas Jobs
            </a>
            <a href="{{ route('whv-applications.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('whv-applications.*') ? 'bg-amber-50 text-amber-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8.97 5.7a1 1 0 01-1.06 0L4 7m16 0a2 2 0 00-2-2H6a2 2 0 00-2 2m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m9 10.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"></path></svg>
                WHV Australia
            </a>
            @if(Auth::check() && Auth::user()->isStudent() && Auth::user()->teacher_id)
            <a href="{{ route('student.evaluations.create') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('student.evaluations.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                Evaluate Teacher
            </a>
            @endif
            <a href="{{ route('student.referrals.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('student.referrals.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                Refer a Friend
            </a>
        </nav>
    </div>

    {{-- Marketing & Outreach --}}
    <div class="sidebar-menu px-6 py-4">
        <p class="text-xs font-semibold text-gray-400 mb-4 uppercase tracking-wider">Marketing & Outreach</p>
        <nav class="space-y-1">
            {{-- School English Camp --}}
            <a href="{{ route('school-program') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('school-program') ? 'bg-amber-50 text-amber-700' : 'text-gray-500 hover:bg-amber-50 hover:text-amber-700' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span class="flex-1 min-w-0 truncate">School English Camp</span>
            </a>
        </nav>
    </div>

    <div class="sidebar-menu mt-auto px-6 py-6 border-t border-gray-100 bg-white flex-shrink-0">
        <p class="text-xs font-semibold text-gray-400 mb-4">AKUN - STUDENT</p>
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
