{{-- Guest Sidebar Component --}}
<aside class="w-64 bg-white shadow-md fixed h-full z-10 hidden md:block">
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto pb-4">

            {{-- Brand --}}
            <div class="p-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
                <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
            </div>

            {{-- Free Test Section --}}
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 mb-4 uppercase tracking-wider">Explore</p>
                <nav class="space-y-1">
                    {{-- Free Lesson --}}
                    <a href="{{ route('free-lesson') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('free-lesson') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Free Lesson
                    </a>

                    {{-- Guest Free Tests --}}
                    <a href="{{ route('guest.free-tests') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guest.free-tests') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                        Guest Free Tests
                    </a>

                    {{-- My English (Guest Progress) --}}
                    <a href="{{ route('guest.my-english') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guest.my-english') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        My English
                    </a>

                    {{-- Scholarship Search --}}
                    <a href="{{ route('scholarships.search.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('scholarships.search.*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6"></path></svg>
                        Scholarship Search
                    </a>

                    {{-- Overseas Jobs --}}
                    <a href="{{ route('overseas-jobs.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('overseas-jobs.*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Overseas Jobs
                    </a>

                    {{-- Working Holiday Visa Australia --}}
                    <a href="{{ route('whv-applications.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('whv-applications.*') ? 'bg-amber-50 text-amber-600 border-l-4 border-amber-600' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8.97 5.7a1 1 0 01-1.06 0L4 7m16 0a2 2 0 00-2-2H6a2 2 0 00-2 2m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m9 10.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"></path></svg>
                        WHV Australia
                    </a>
                </nav>
            </div>

            {{-- CTA to Register --}}
            <div class="px-6 mt-4">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-4 text-white">
                    <p class="text-sm font-bold mb-1">🎯 Mulai Belajar</p>
                    <p class="text-xs text-blue-100 mb-3">Daftar sekarang untuk mengakses semua fitur belajar.</p>
                    <a href="{{ route('student.register') }}" class="block text-center bg-white text-blue-700 font-bold text-xs py-2 px-3 rounded-lg hover:bg-blue-50 transition">
                        Daftar Gratis
                    </a>
                </div>
            </div>

        </div>

        {{-- Footer Auth Links --}}
        <div class="mt-auto px-6 py-6 border-t border-gray-100 bg-white flex-shrink-0">
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
                    <a href="{{ route('student.register') }}" class="flex items-center gap-3 px-4 py-3 text-blue-600 hover:bg-blue-50 rounded-xl font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Sign Up
                    </a>
                @endauth
            </nav>
        </div>
    </div>
</aside>
