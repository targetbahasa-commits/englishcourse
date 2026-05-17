<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $trackData['title'] }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div class="relative w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                </div>

                <div class="flex items-center gap-6">
                    @include('components.topbar-action-icons')

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $trackData['title'] }}</h2>
                    <p class="text-gray-500 text-sm">{{ $trackData['description'] }}</p>
                    <p class="text-xs mt-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-semibold border border-blue-100">
                            {{ $trackData['summary'] }}
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('assignments.grammar-writing.classes') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <!-- Meetings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach($trackData['meetings'] as $meeting)
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 {{ $meeting['available'] ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} rounded-full text-xs font-bold">
                            {{ $meeting['available'] ? 'OPEN' : 'LOCKED' }}
                        </span>
                    </div>

                    <!-- Document Icon -->
                    <div class="w-12 h-12 {{ $meeting['available'] ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400' }} rounded-2xl flex items-center justify-center mb-4 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $meeting['title'] }}</h3>
                    <p class="text-gray-500 text-sm mb-4">{{ $meeting['topic'] }}</p>

                    @if($meeting['available'] && $meeting['route_name'])
                        <a href="{{ route($meeting['route_name'], $meeting['route_parameters'] ?? []) }}"
                           class="js-start-link block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">
                            Start
                        </a>
                    @else
                        <button disabled class="block w-full py-2 bg-gray-100 text-gray-400 text-center rounded-xl font-bold cursor-not-allowed">
                            Locked
                        </button>
                    @endif
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <script>
        (function () {
            const OPENING_HTML = '<span class="inline-flex items-center gap-2"><svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-opacity="0.25" stroke-width="3"></circle><path d="M22 12a10 10 0 00-10-10" stroke-width="3"></path></svg>Opening...</span>';

            const resetStartLink = (link) => {
                if (!link) {
                    return;
                }

                const originalHtml = link.dataset.originalHtml || 'Start';
                link.dataset.loading = 'false';
                link.classList.remove('opacity-70', 'cursor-wait', 'pointer-events-none');
                link.innerHTML = originalHtml;
            };

            const markStartLinkLoading = (link) => {
                if (!link.dataset.originalHtml) {
                    link.dataset.originalHtml = link.innerHTML;
                }

                link.dataset.loading = 'true';
                link.classList.add('opacity-70', 'cursor-wait', 'pointer-events-none');
                link.innerHTML = OPENING_HTML;

                // Fallback reset if navigation fails or is interrupted.
                window.setTimeout(() => {
                    if (link.dataset.loading === 'true') {
                        resetStartLink(link);
                    }
                }, 5000);
            };

            const setupStartLinkGuards = () => {
                document.querySelectorAll('a.js-start-link').forEach((link) => {
                    if (!link.dataset.originalHtml) {
                        link.dataset.originalHtml = link.innerHTML;
                    }

                    link.addEventListener('click', (event) => {
                        if (link.dataset.loading === 'true') {
                            event.preventDefault();
                            return;
                        }

                        markStartLinkLoading(link);
                    });
                });
            };

            const resetAllStartLinks = () => {
                document.querySelectorAll('a.js-start-link').forEach((link) => resetStartLink(link));
            };

            setupStartLinkGuards();

            // Reset UI when user returns via browser back/forward cache.
            window.addEventListener('pageshow', () => {
                resetAllStartLinks();
            });
        })();
    </script>

    @include('components.student-broadcaster')
</body>
</html>