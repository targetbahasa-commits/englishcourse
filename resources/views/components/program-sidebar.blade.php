<div x-data="{ programSidebarOpen: false }">
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
         class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 backdrop-blur-sm" 
         style="display: none;"></div>

    <aside class="fixed inset-y-0 left-0 bg-white shadow-2xl w-72 z-50 transform transition-transform duration-300 ease-in-out flex flex-col pt-0 h-full overflow-hidden"
           :class="programSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        
        <div class="p-6 flex items-center justify-between border-b border-gray-100 bg-gray-50 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">TB</div>
                <span class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Target Bahasa</span>
            </div>
            <button @click="programSidebarOpen = false" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col">
            @if(Auth::check())
                @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                    @include('components.admin-sidebar')
                    
                    <!-- Admin Logout -->
                    <div class="px-6 py-4 mt-auto mb-4 border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-red-50 hover:text-red-600 rounded-xl font-medium transition w-full text-left">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                @else
                    @include('components.student-sidebar')
                @endif
            @endif
        </div>
    </aside>
</div>
