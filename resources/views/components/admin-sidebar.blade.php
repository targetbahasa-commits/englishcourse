<div class="px-4 py-4">
    <div class="mb-4">
        <p class="text-xs font-semibold text-gray-400 mb-3">OVERVIEW</p>
        <nav class="space-y-0.5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.dashboard') && !request('section') && !request('report') && !request('settings') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.reports.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span>Reports</span>
            </a>
            <a href="{{ route('admin.chat.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.chat.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span>Live Chat</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.settings.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>System Settings</span>
            </a>
            <a href="{{ route('admin.waha.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.waha.*') ? 'bg-green-50 text-green-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span>WhatsApp Gateway</span>
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <p class="text-xs font-semibold text-gray-400 mb-3">PAYMENT & ADMIN OPS</p>
        <nav class="space-y-0.5">
            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.payments.index') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-800 hover:bg-gray-50 ' }} rounded-xl text-base font-semibold transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2M5 9h14l1 10a2 2 0 01-2 2H6a2 2 0 01-2-2L5 9z"></path></svg>
                <span>Payments</span>
            </a>
            <a href="{{ route('admin.payments.queue') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.payments.queue') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition pl-8">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                <span class="text-sm">Payment Queue</span>
            </a>
            <a href="{{ route('admin.payments.proofs') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.payments.proofs') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition pl-8">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-sm">Bukti Transfer</span>
            </a>
            <a href="{{ route('admin.pricing.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.pricing.*') ? 'bg-indigo-50 text-indigo-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Pricing Management</span>
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <p class="text-xs font-semibold text-gray-400 mb-3">STAFF MANAGEMENT</p>
        <nav class="space-y-0.5">
            <a href="{{ route('users.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Users</span>
            </a>
            <a href="{{ route('teachers.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('teachers.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span>Teachers</span>
            </a>
            <a href="{{ route('students.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('students.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Students</span>
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <p class="text-xs font-semibold text-gray-400 mb-3">CLASS MANAGEMENT</p>
        <nav class="space-y-0.5">
            <a href="{{ route('admin.camp-management.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.camp-management.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span>Camp Management</span>
            </a>
            <a href="{{ route('programs.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('programs.index') || request('section') === 'programs' ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Programs</span>
            </a>
            <a href="{{ route('class-periods.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('class-periods.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Class Periods</span>
            </a>
            <a href="{{ route('admin.class-schedules.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.class-schedules.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Class Schedule</span>
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.attendance.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Attendance</span>
            </a>
            <a href="{{ route('assignments.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('assignments.*') && !request()->routeIs('assignments.final-test*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Assignments</span>
            </a>
            <a href="{{ route('admin.assignment-results.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.assignment-results.*') ? 'bg-purple-50 text-purple-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition pl-8">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="text-sm">Assignment Results</span>
            </a>
            <a href="{{ route('final-test') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('final-test*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m5-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Final Test</span>
            </a>
            <a href="{{ route('online-test.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('online-test.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M3 12h18M3 19h18"></path></svg>
                <span>Online Test</span>
            </a>
            <a href="{{ route('mock-test') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('mock-test') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Mock Test</span>
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <p class="text-xs font-semibold text-gray-400 mb-3">EVALUATIONS</p>
        <nav class="space-y-0.5">
            <a href="{{ route('admin.evaluations.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.evaluations.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <span>Teacher Evaluations</span>
            </a>
            <a href="{{ route('admin.class-evaluations.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.class-evaluations.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Class Evaluations</span>
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <p class="text-xs font-semibold text-gray-400 mb-3">ASSESSMENT & CONTENT</p>
        <nav class="space-y-0.5">
            <div class="{{ request()->routeIs('programs.mock-tests') || request()->routeIs('admin.toefl-mockup-results.*') ? '' : '' }} rounded-xl space-y-0.5 overflow-hidden transition-colors">
                <a href="{{ route('programs.mock-tests') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('programs.mock-tests') ? 'bg-pink-50 text-pink-600' : 'text-gray-500 hover:bg-gray-50' }} text-base font-medium transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Manage Mock Test</span>
                </a>
                <a href="{{ route('admin.toefl-mockup-results.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.toefl-mockup-results.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-500 hover:bg-gray-50' }} text-base font-medium transition pl-8">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="text-sm">Mockup Results</span>
                </a>
               
            </div>
                @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('admin.manage-final-test') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.manage-final-test') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m5-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Manage Final Test</span>
                </a>
                <a href="{{ route('admin.final-test-results.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.final-test-results.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-500 hover:bg-gray-50' }} text-base font-medium transition pl-8">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="text-sm">Final Test Results</span>
                </a>
            @endif
            <a href="{{ route('admin.online-tests.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.online-tests.*') ? 'bg-indigo-50 text-indigo-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M3 12h18M3 19h18"></path></svg>
                <span>Manage Online Tests</span>
            </a>
            <a href="{{ route('admin.online-test-results.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.online-test-results.*') ? 'bg-teal-50 text-teal-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition pl-8">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="text-sm">Online Test Results</span>
            </a>
            <a href="{{ route('admin.free-tests.certificates.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.free-tests.certificates.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Certificates</span>
            </a>
            <a href="{{ route('free-lesson') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('free-lesson') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>Free Lesson</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'guest_free_tests']) }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request('section') === 'guest_free_tests' ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                <span>Guest Free Tests</span>
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <p class="text-xs font-semibold text-gray-400 mb-3">MARKETING & OUTREACH</p>
        <nav class="space-y-0.5">
            <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.announcements.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                <span>Announcements</span>
            </a>
            <a href="{{ route('admin.broadcast-messages.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.broadcast-messages.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                <span>Broadcast Messages</span>
            </a>
            <a href="{{ route('admin.outreach-messages.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.outreach-messages.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Outreach Messages</span>
            </a>
            <a href="{{ route('admin.leads.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.leads.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span>Lead Tracker</span>
            </a>
            <a href="{{ route('admin.promo-tests.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.promo-tests.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                <span>Manage Promo Tests</span>
            </a>
            <a href="{{ route('admin.registration-leads.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.registration-leads.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Registration Leads</span>
            </a>
            <a href="{{ route('admin.email-logs.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.email-logs.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Email Outbox</span>
            </a>
            <a href="{{ route('admin.referrals.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.referrals.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                <span>Referral Management</span>
            </a>
            <a href="{{ route('admin.social-media.all') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.social-media.*') ? 'bg-indigo-50 text-indigo-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                <span>Social Media</span>
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <p class="text-xs font-semibold text-gray-400 mb-3">TOOLS</p>
        <nav class="space-y-0.5">
            <a href="{{ route('admin.listening-machine.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.listening-machine.*') ? 'bg-violet-50 text-violet-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                <span>Listening Machine</span>
            </a>
            <a href="{{ route('admin.ai-management.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.ai-management.*') ? 'bg-indigo-50 text-indigo-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>AI Management</span>
            </a>
            <a href="{{ route('admin.audio-library.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.audio-library.*') ? 'bg-teal-50 text-teal-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                <span>Audio Library</span>
            </a>
        </nav>
    </div>

    <div>
        <p class="text-xs font-semibold text-gray-400 mb-3">PUBLIC PAGES & OPPORTUNITIES</p>
        <nav class="space-y-0.5">
            <a href="{{ route('admin.scholarships.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.scholarships.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                <span>Scholarships</span>
            </a>
            <a href="{{ route('admin.scholarship-news.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.scholarship-news.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                <span>Scholarship News</span>
            </a>
            <a href="{{ route('admin.job-vacancies.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.job-vacancies.*') ? 'bg-blue-50 text-blue-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Overseas Jobs</span>
            </a>
            <a href="{{ route('admin.whv-applications.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->routeIs('admin.whv-applications.*') ? 'bg-amber-50 text-amber-600 ' : 'text-gray-500 hover:bg-gray-50 ' }} rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8.97 5.7a1 1 0 01-1.06 0L4 7m16 0a2 2 0 00-2-2H6a2 2 0 00-2 2m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m9 10.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"></path></svg>
                <span>WHV Australia</span>
            </a>
        </nav>
    </div>
</div>
