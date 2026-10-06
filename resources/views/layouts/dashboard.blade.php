<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        textarea.auto-expand-answer {
            field-sizing: content;
            height: auto;
            width: 100%;
            resize: none;
            overflow: hidden;
        }
        textarea.auto-expand-answer[rows="1"] {
            min-block-size: 2.75rem;
            min-height: 2.75rem;
        }
        textarea.auto-expand-answer[rows="2"] {
            min-height: 4.25rem;
        }
        textarea.auto-expand-answer[rows="3"] {
            min-height: 5.75rem;
        }
        textarea.auto-expand-answer[rows="4"] {
            min-height: 7.25rem;
        }
        textarea.auto-expand-answer:not([rows="1"]):not([rows="2"]):not([rows="3"]):not([rows="4"]) {
            min-block-size: 8lh;
            min-height: 9rem;
        }
    </style>
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-[#F3F4FF] overflow-x-hidden">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar - Automatically selected based on user role -->
        @auth
            <?php 
                $sidebarRole = strtolower(Auth::user()->active_role ?? 'student'); 
                if (request()->query('live_preview_for')) {
                    $sidebarRole = 'student';
                }
            ?>

            @if($sidebarRole === 'admin')
                @include('components.sidebar-admin')
            @elseif($sidebarRole === 'teacher')
                @include('components.sidebar-teacher')
            @elseif(in_array($sidebarRole, ['guest', 'guest_quick']))
                @include('components.sidebar-guest')
            @else
                @include('components.sidebar-student')
            @endif
        @else
            @include('components.sidebar-guest')
        @endauth

        <!-- Main Content -->
        <main class="flex-1 transition-all duration-200 p-4 md:p-8 overflow-x-hidden min-w-0">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8 min-w-0 overflow-hidden gap-2">
                <div>
                    @if(isset($header))
                        {{ $header }}
                    @else
                        <h1 class="text-2xl font-bold text-gray-800">{{ $pageTitle ?? 'Dashboard' }}</h1>
                        <p class="text-gray-500">{{ $pageDescription ?? (Auth::check() ? 'Welcome back!' : 'Explore opportunities') }}</p>
                    @endif
                </div>
                
                <div class="flex items-center gap-4 md:gap-6">
                    @auth
                        <?php $activeRole = strtolower(Auth::user()->active_role ?? 'student'); ?>
                        @if(!in_array($activeRole, ['guest', 'guest_quick'], true))
                            @include('components.topbar-action-icons')
                        @endif
                    @endauth
                    
                    <!-- User Profile / Auth Actions -->
                    <div class="flex items-center gap-3">
                        @auth
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ in_array(Auth::user()->active_role, ['guest', 'guest_quick']) ? 'Guest' : ucfirst(Auth::user()->active_role) }}</p>
                            </div>
                            <div class="w-10 h-10 bg-blue-100 rounded-full overflow-hidden flex items-center justify-center text-blue-600 font-bold shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition whitespace-nowrap">Log In</a>
                                <a href="{{ route('student.register') }}" class="text-sm font-medium text-white bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm whitespace-nowrap">Sign Up</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div>
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')
    <script>
        (function () {
            const resizeEl = function (el) {
                if (!el || el.tagName !== 'TEXTAREA' || !el.classList.contains('auto-expand-answer')) return;
                el.style.height = 'auto';
                if (el.scrollHeight > 0) {
                    el.style.height = el.scrollHeight + 'px';
                }
            };
            const resizeAll = function (root) {
                (root || document).querySelectorAll('textarea.auto-expand-answer').forEach(resizeEl);
            };
            window.resizeAutoExpandTextarea = resizeEl;
            window.resizeAutoExpandTextareas = resizeAll;
            document.addEventListener('input', function (e) {
                if (e.target && e.target.matches && e.target.matches('textarea.auto-expand-answer')) {
                    resizeEl(e.target);
                }
            });
            window.addEventListener('resize', function () { resizeAll(); });
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function () {
                    resizeAll();
                    setTimeout(resizeAll, 150);
                    setTimeout(resizeAll, 600);
                });
            } else {
                resizeAll();
                setTimeout(resizeAll, 150);
                setTimeout(resizeAll, 600);
            }
            window.addEventListener('load', function () { resizeAll(); });
        })();
    </script>
    @include('components.student-broadcaster')
    @include('components.chat-notifier')
    @include('components.floating-wa-button')
    {{-- Collaborative whiteboard: only on assignment/meeting pages, for any
         logged-in role (admin/teacher/student can all draw together there). --}}
    @auth
        @if(request()->is('assignments/*') || request()->is('assignments'))
            <x-live-drawing />
        @endif
    @endauth
    <!-- Alpine.js for interactivity -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
