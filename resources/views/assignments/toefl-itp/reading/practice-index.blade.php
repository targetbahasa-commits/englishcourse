<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reading Practice - {{ config('app.name', 'Target Bahasa') }}</title>
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
                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Reading Practice</h1>
                            <p class="text-gray-600 mt-1">TOEFL ITP – Practice Tests</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.toefl-itp') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            {{-- 10 Reading Packages --}}
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Paket Soal Reading</h2>
                    <span class="text-sm text-gray-500">{{ collect($readingPackages ?? [])->where('status', 'available')->count() }} paket tersedia</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5">
                    @foreach(($readingPackages ?? collect()) as $package)
                        @php
                            $isAvailable = ($package['status'] ?? 'coming_soon') === 'available';
                                $palettes = [
                                    1  => ['bg' => 'linear-gradient(135deg,#4338ca,#7c3aed)', 'btn' => '#4338ca', 'btnHover' => '#3730a3'],
                                    2  => ['bg' => 'linear-gradient(135deg,#6d28d9,#7e22ce)', 'btn' => '#6d28d9', 'btnHover' => '#5b21b6'],
                                    3  => ['bg' => 'linear-gradient(135deg,#7c3aed,#a21caf)', 'btn' => '#7c3aed', 'btnHover' => '#6d28d9'],
                                    4  => ['bg' => 'linear-gradient(135deg,#1d4ed8,#4338ca)', 'btn' => '#1d4ed8', 'btnHover' => '#1e40af'],
                                    5  => ['bg' => 'linear-gradient(135deg,#0f766e,#047857)', 'btn' => '#0f766e', 'btnHover' => '#0d6460'],
                                    6  => ['bg' => 'linear-gradient(135deg,#065f46,#166534)', 'btn' => '#065f46', 'btnHover' => '#064e3b'],
                                    7  => ['bg' => 'linear-gradient(135deg,#334155,#1e293b)', 'btn' => '#334155', 'btnHover' => '#1e293b'],
                                    8  => ['bg' => 'linear-gradient(135deg,#1e40af,#1e3a5f)', 'btn' => '#1e40af', 'btnHover' => '#1e3a8a'],
                                    9  => ['bg' => 'linear-gradient(135deg,#be123c,#9f1239)', 'btn' => '#be123c', 'btnHover' => '#9f1239'],
                                    10 => ['bg' => 'linear-gradient(135deg,#c2410c,#b91c1c)', 'btn' => '#c2410c', 'btnHover' => '#9a3412'],
                                ];
                                $p = $palettes[$package['package_number']] ?? $palettes[1];
                        @endphp
                        <div class="group bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col hover:-translate-y-1 transform">
                            {{-- Card Header --}}
                                     <div class="p-5 relative overflow-hidden" style="background: {{ $p['bg'] }}">
                                <div class="absolute -top-6 -right-6 w-20 h-20 rounded-full bg-white/10"></div>
                                <div class="absolute -bottom-4 -left-4 w-16 h-16 rounded-full bg-white/10"></div>

                                <div class="relative">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide border {{ $isAvailable ? 'bg-white/20 border-white/30 text-white' : 'bg-white/10 border-white/20 text-white/70' }} mb-3">
                                        {{ $isAvailable ? 'TERSEDIA' : 'SEGERA HADIR' }}
                                    </span>

                                    <div class="flex items-center gap-3 mb-1">
                                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shadow-inner">
                                            <span class="text-white font-extrabold text-lg leading-none">{{ $package['package_number'] }}</span>
                                        </div>
                                        <div>
                                            <h3 class="text-white font-bold text-lg leading-tight">{{ $package['title'] }}</h3>
                                            <p class="text-white/80 text-xs">{{ $package['subtitle'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-4 flex flex-col flex-1 justify-between bg-white">
                                <p class="text-gray-500 text-sm mb-4 leading-relaxed">{{ $package['description'] }}</p>

                                @if($isAvailable)
                                    <a href="{{ route('assignments.toefl-itp.reading.practice.package', ['package' => $package['package_number']]) }}"
                                           class="block w-full py-2.5 text-center rounded-xl font-bold shadow text-white transition-colors duration-200"
                                           style="background-color: {{ $p['btn'] }}"
                                           onmouseover="this.style.backgroundColor='{{ $p['btnHover'] }}'"
                                           onmouseout="this.style.backgroundColor='{{ $p['btn'] }}'">
                                        Mulai →
                                    </a>
                                @else
                                    <button type="button" disabled
                                            class="block w-full py-2.5 text-center rounded-xl font-bold cursor-not-allowed text-white shadow-sm"
                                            style="background: {{ $p['bg'] }}; opacity: 0.72;">
                                        Coming Soon
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </main>
    </div>
</body>
</html>
