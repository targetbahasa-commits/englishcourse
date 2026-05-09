<!-- Admin Sidebar Component -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 4px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: #94a3b8;
    }

    .admin-sidebar-shell {
        width: 16rem;
    }

    @media (min-width: 768px) {
        body.has-admin-sidebar main {
            margin-left: var(--admin-sidebar-offset, 16rem) !important;
            transition: margin-left .2s ease;
        }

        .admin-sidebar-shell {
            width: var(--admin-sidebar-width, 16rem);
        }
    }

    .sidebar-menu .sidebar-label {
        transition: opacity .15s ease;
    }

    .sidebar-collapsed .sidebar-menu p,
    .sidebar-collapsed .sidebar-menu .sidebar-label,
    .sidebar-collapsed .sidebar-title {
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
        border-left: 1px solid #dbeafe;
        border-radius: 9999px;
        background: #eff6ff;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.12);
        color: #2563eb;
        z-index: 20;
    }

    .sidebar-collapsed .sidebar-desktop-toggle svg {
        width: 0.9rem;
        height: 0.9rem;
    }

    .sidebar-collapsed .sidebar-menu {
        padding-left: 0.25rem;
        padding-right: 0.25rem;
    }

    .sidebar-collapsed .sidebar-menu nav a,
    .sidebar-collapsed .sidebar-menu nav button {
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        margin-left: auto;
        margin-right: auto;
        padding-left: 0;
        padding-right: 0;
        font-size: 0;
        border-left-color: transparent !important;
    }

    .sidebar-collapsed .sidebar-menu nav a svg,
    .sidebar-collapsed .sidebar-menu nav button svg {
        margin-right: 0;
        flex-shrink: 0;
    }

    .sidebar-collapsed .sidebar-menu nav a span {
        font-size: 0;
    }

    .sidebar-desktop-toggle {
        display: inline-flex;
    }

    body.has-fixed-bottom-player .sidebar-account-safe {
        padding-bottom: 6rem;
    }

    body.has-fixed-bottom-player .sidebar-scroll-safe {
        padding-bottom: 5rem;
    }

    @media (max-width: 767px) {
        .sidebar-desktop-toggle {
            display: none !important;
        }
    }

    .sidebar-collapsed .custom-scrollbar::-webkit-scrollbar {
        width: 0;
    }
</style>
<style>
    @media (max-width: 767px) {
        .mobile-sidebar-safe {
            padding-left: 3.5rem;
        }
    }
</style>
<div x-data="{ 
    mobileSidebarOpen: false,
    sidebarCollapsed: JSON.parse(localStorage.getItem('adminSidebarCollapsed') || 'false')
}"
     x-effect="
        localStorage.setItem('adminSidebarCollapsed', JSON.stringify(sidebarCollapsed));
        document.body.classList.toggle('sidebar-collapsed', sidebarCollapsed);
        document.body.classList.add('has-admin-sidebar');
        document.documentElement.style.setProperty('--admin-sidebar-width', sidebarCollapsed ? '3.5rem' : '16rem');
        document.documentElement.style.setProperty('--admin-sidebar-offset', sidebarCollapsed ? '3.5rem' : '16rem');
     ">
<button
    type="button"
    @click="mobileSidebarOpen = true"
    class="md:hidden fixed top-4 left-4 z-[9999] inline-flex items-center justify-center w-11 h-11 rounded-xl bg-blue-600 border border-blue-700 shadow-xl text-white"
    aria-label="Open menu">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
</button>

<div x-show="mobileSidebarOpen" x-transition.opacity class="md:hidden fixed inset-0 bg-black/40 z-40" @click="mobileSidebarOpen = false"></div>

<aside class="admin-sidebar-shell bg-white shadow-md fixed h-full z-50 md:z-10 transform transition-all duration-200 md:translate-x-0"
    :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto custom-scrollbar pb-6 sidebar-scroll-safe" data-admin-sidebar-scroll>
        <div class="sidebar-header p-6 flex items-center gap-3 justify-between">
            <div class="sidebar-brand flex items-center gap-3">
            <div class="sidebar-logo w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
            <span class="sidebar-title text-xl font-bold text-gray-800" x-show="!sidebarCollapsed" x-transition.opacity>Target Bahasa</span>
            </div>

            <button type="button" @click="sidebarCollapsed = !sidebarCollapsed" class="sidebar-desktop-toggle items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" :aria-label="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'" :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'">
                <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <button type="button" @click="mobileSidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700" aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="sidebar-menu">
            @include('components.admin-sidebar')
        </div>
        </div>

    <div class="sidebar-menu sidebar-account-safe mt-auto px-6 py-4 border-t border-gray-100 bg-white flex-shrink-0">
        <p class="sidebar-label text-xs font-semibold text-gray-400 mb-3">ACCOUNT - ADMIN</p>
        <nav class="space-y-0.5">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-500 hover:bg-gray-50 rounded-xl text-base font-medium transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="sidebar-label">Profile</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-red-500 hover:bg-red-50 rounded-xl text-base font-medium transition w-full text-left">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="sidebar-label">Log Out</span>
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

        const sidebarScrollContainer = document.querySelector('[data-admin-sidebar-scroll]');
        const sidebarStorageKey = 'admin-sidebar-scroll-top';

        if (sidebarScrollContainer) {
            const storedScrollTop = window.sessionStorage.getItem(sidebarStorageKey);

            if (storedScrollTop !== null) {
                sidebarScrollContainer.scrollTop = Number(storedScrollTop);
            }

            sidebarScrollContainer.addEventListener('scroll', function () {
                window.sessionStorage.setItem(sidebarStorageKey, String(sidebarScrollContainer.scrollTop));
            }, { passive: true });

            document.querySelectorAll('.sidebar-menu a[href]').forEach(function (link) {
                link.addEventListener('click', function () {
                    window.sessionStorage.setItem(sidebarStorageKey, String(sidebarScrollContainer.scrollTop));
                });
            });
        }

        const fixedBottomBars = document.querySelectorAll('.fixed.bottom-0.left-0.right-0');
        if (fixedBottomBars.length > 0) {
            document.body.classList.add('has-fixed-bottom-player');
        }
    });
</script>
