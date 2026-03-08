<!-- Student Sidebar Component -->
<aside class="w-64 bg-white shadow-md fixed h-full z-10 hidden md:block">
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto pb-4">
        <div class="p-6 flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
            <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
        </div>
    
    <div class="px-6 py-4">
        <p class="text-xs font-semibold text-gray-400 mb-4">MENU UTAMA</p>
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') || request()->routeIs('student.dashboard') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('assignments.*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Assignments
            </a>
            <a href="{{ route('free-lesson') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('free-lesson') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Free Lesson
            </a>
            <a href="{{ route('dashboard', ['section' => 'guest_free_tests']) }}" class="flex items-center gap-3 px-4 py-3 {{ request('section') === 'guest_free_tests' ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                Guest Free Tests
            </a>
            <a href="{{ route('student.evaluations.create') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('student.evaluations.*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                Evaluate Teacher
            </a>
            <a href="{{ route('student.progress') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('student.progress') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                My Progress
            </a>
            <a href="{{ route('student.schedule') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('student.schedule') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Schedule
            </a>
        </nav>
    </div>
    
    <div class="mt-auto px-6 py-6 border-t border-gray-100 bg-white flex-shrink-0">
        <p class="text-xs font-semibold text-gray-400 mb-4">AKUN</p>
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
