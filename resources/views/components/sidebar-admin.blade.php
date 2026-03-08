<!-- Admin Sidebar Component -->
<aside class="w-64 bg-white shadow-md fixed h-full z-10 hidden md:block">
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto pb-4">
        <div class="p-6 flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
            <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
        </div>
        
        @include('components.admin-sidebar')
        </div>

    <div class="mt-auto px-6 py-4 border-t border-gray-100 bg-white flex-shrink-0">
        <p class="text-xs font-semibold text-gray-400 mb-3">ACCOUNT</p>
        <nav class="space-y-0.5">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-500 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-red-500 hover:bg-red-50 rounded-xl text-sm font-medium transition w-full text-left">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Log Out
                </button>
            </form>
        </nav>
    </div>
    </div>
</aside>
