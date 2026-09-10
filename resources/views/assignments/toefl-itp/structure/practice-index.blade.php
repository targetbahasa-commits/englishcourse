<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Structure Practice - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">Structure Practice</h1>
                            <p class="text-gray-600 mt-1">TOEFL ITP – Practice Tests</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.toefl-itp') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            @php
                $palettes = [
                    [
                        'gradient' => 'linear-gradient(135deg, #22c55e 0%, #0f766e 100%)',
                        'badge' => 'bg-white border-emerald-100/40 text-white',
                        'icon' => 'bg-white text-emerald-600',
                        'body' => 'bg-white',
                        'button' => 'bg-emerald-200 text-emerald-800',
                    ],
                    [
                        'gradient' => 'linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%)',
                        'badge' => 'bg-white border-indigo-100/40 text-white',
                        'icon' => 'bg-white text-blue-600',
                        'body' => 'bg-white',
                        'button' => 'bg-blue-200 text-blue-800',
                    ],
                    [
                        'gradient' => 'linear-gradient(135deg, #f97316 0%, #ef4444 100%)',
                        'badge' => 'bg-white border-orange-100/40 text-white',
                        'icon' => 'bg-white text-orange-600',
                        'body' => 'bg-white',
                        'button' => 'bg-orange-200 text-orange-800',
                    ],
                    [
                        'gradient' => 'linear-gradient(135deg, #a855f7 0%, #ec4899 100%)',
                        'badge' => 'bg-fuchsia-100/25 border-fuchsia-100/40 text-white',
                        'icon' => 'bg-fuchsia-50 text-fuchsia-600',
                        'body' => 'bg-fuchsia-50/40',
                        'button' => 'bg-fuchsia-200 text-fuchsia-800',
                    ],
                    [
                        'gradient' => 'linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%)',
                        'badge' => 'bg-white border-cyan-100/40 text-white',
                        'icon' => 'bg-white text-cyan-600',
                        'body' => 'bg-white',
                        'button' => 'bg-cyan-200 text-cyan-800',
                    ],
                    [
                        'gradient' => 'linear-gradient(135deg, #eab308 0%, #f97316 100%)',
                        'badge' => 'bg-white border-yellow-100/40 text-white',
                        'icon' => 'bg-white text-yellow-600',
                        'body' => 'bg-white',
                        'button' => 'bg-yellow-200 text-yellow-800',
                    ],
                ];
            @endphp

            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Available Packages (70)</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse(($practicePackages ?? collect()) as $index => $pkg)
                        @php
                            $styleIndex = $index % count($palettes);
                            $palette = $palettes[$styleIndex];
                            $isAvailable = ($pkg['status'] ?? 'coming_soon') === 'available';
                            $meetingLink = $isAvailable
                                ? route('assignments.toefl-itp.structure.meeting', $pkg['meeting_number'])
                                : '#';
                            $questionCount = (int) ($pkg['question_count'] ?? 0);
                        @endphp
                        <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col hover:-translate-y-1 transform">
                            <div style="background: {{ $palette['gradient'] }}" class="p-6 relative">
                                <span class="absolute top-4 right-4 px-3 py-1 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wide border {{ $palette['badge'] }}">
                                    {{ $isAvailable ? 'PRACTICE' : 'COMING SOON' }}
                                </span>

                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-md mb-4 {{ $palette['icon'] }}">
                                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>

                                <h3 class="text-white text-2xl font-bold">Paket {{ $pkg['package_number'] ?? ($index + 1) }}</h3>
                                <p class="text-white/90 text-sm mt-1">TOEFL ITP Structure</p>

                                <p class="mt-3 text-white/90 text-xs uppercase tracking-wider font-semibold">
                                    {{ $isAvailable ? ('Meeting ' . $pkg['meeting_number'] . ' - ' . max(1, $questionCount) . ' Questions') : 'Package not available yet' }}
                                </p>
                            </div>

                            <div class="p-6 flex flex-col flex-1 {{ $palette['body'] }} justify-end">

                                @if($isAvailable)
                                    <a href="{{ $meetingLink }}"
                                       class="block w-full py-3 text-center rounded-xl font-bold shadow bg-red-500 text-white hover:bg-red-600 transition">
                                        Start Practice ->
                                    </a>
                                @else
                                    <button type="button"
                                       disabled
                                       class="block w-full py-3 text-center rounded-xl font-bold shadow cursor-not-allowed bg-sky-400 text-white">
                                        Coming Soon
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 text-center text-gray-600">
                            Paket practice belum tersedia.
                        </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>
</body>
</html>
