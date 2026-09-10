<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $defaultPageTitle = null;
        if (isset($meeting) && !empty($meeting->title)) {
            $defaultPageTitle = $meeting->title;
        } elseif (isset($pageTitle) && !empty($pageTitle)) {
            $defaultPageTitle = $pageTitle;
        } elseif (isset($title) && !empty($title)) {
            $defaultPageTitle = $title;
        } elseif (Auth::check()) {
            $currentRole = strtolower(Auth::user()->active_role ?? Auth::user()->role ?? 'student');
            $defaultPageTitle = match($currentRole) {
                'admin', 'superadmin' => 'Admin Portal',
                'teacher' => 'Teacher Portal',
                'intern' => 'Intern Portal',
                'guest', 'guest_quick' => 'Guest Portal',
                default => 'Student Portal',
            };
        } else {
            $defaultPageTitle = 'Dashboard';
        }
    @endphp
    <title>@yield('title', $defaultPageTitle) - {{ config('app.name', 'Target Bahasa Course') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
    {{-- Several child views (IELTS Writing sub-lessons) define @section('head') for
    their CSRF meta tag / autosave script, but nothing ever yielded it here, so it was
    silently discarded - the CSRF meta tag never rendered and their draft-autosave
    fetch() calls crashed on a null meta lookup before ever reaching the network. --}}
    @yield('head')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.flash-messages')
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @auth
            <?php
                // Note: during admin's "Live Student View" (?live_preview_for=...),
                // whichever sidebar gets selected below renders nothing at all -
                // see the guard at the top of each components/sidebar-*.blade.php
                // file, which is the single point of truth for that behavior.
                $sidebarRole = strtolower(Auth::user()->active_role ?? 'student');
            ?>

            @if($sidebarRole === 'admin')
                @include('components.sidebar-admin')
            @elseif($sidebarRole === 'intern')
                @include('components.sidebar-intern')
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
        <style>
            @media (min-width: 768px) {
                main.layout-main-content {
                    margin-left: var(--admin-sidebar-offset, var(--teacher-sidebar-offset, var(--student-sidebar-offset, var(--guest-sidebar-offset, 16rem))));
                }
            }
        </style>
        <main class="flex-1 transition-all duration-200 layout-main-content min-w-0 overflow-x-hidden">
            {{-- A dozen+ admin views (students/show, students/index,
                 students/current-assignment, teachers/show, scores/index,
                 offline-tests/*, final-test-results/*,
                 toefl-mockup-results/*, online-test-results/*) define
                 @section('header') for their page title/breadcrumbs/action
                 buttons, but nothing here ever yielded it - it was silently
                 discarded on every single one of those pages, same root
                 cause as the @yield('head') fix above this. @hasSection
                 guards it so pages that only define 'content' (most of the
                 app) don't get an empty bar. --}}
            @hasSection('header')
                <div class="bg-white border-b border-gray-100 px-8 py-6">
                    @yield('header')
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    @yield('modals')
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
    <script>
        window.copyToClipboard = function(text) {
            if (navigator.clipboard && window.isSecureContext) {
                return navigator.clipboard.writeText(text);
            } else {
                return new Promise(function(resolve, reject) {
                    var textArea = document.createElement("textarea");
                    textArea.value = text;
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    textArea.style.top = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        var successful = document.execCommand('copy');
                        document.body.removeChild(textArea);
                        if (successful) resolve(); else reject();
                    } catch (err) {
                        document.body.removeChild(textArea);
                        reject(err);
                    }
                });
            }
        };
    </script>
    @stack('scripts')
</body>
</html>
