<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Listening Practice - {{ config('app.name', 'Target Bahasa') }}</title>
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
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.5 5.5L7 9H4v6h3l4.5 3.5V5.5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 9.5a4 4 0 010 5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 7a7.5 7.5 0 010 10"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Listening Practice</h1>
                            <p class="text-gray-600 mt-1">TOEFL ITP – Practice Tests</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.toefl-itp') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Pilih Bagian Listening</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach(($parts ?? collect()) as $part)
                        @php
                            $isAvailable = ($part['status'] ?? 'coming_soon') === 'available';
                        @endphp
                        <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col hover:-translate-y-1 transform">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 relative">
                                <span class="absolute top-4 right-4 px-3 py-1 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wide border border-blue-100/40 text-white {{ $isAvailable ? 'bg-blue-100/25' : 'bg-slate-200/25' }}">
                                    {{ $isAvailable ? 'AVAILABLE' : 'COMING SOON' }}
                                </span>

                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-md mb-4 bg-white/20 text-white">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-2v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"></path>
                                    </svg>
                                </div>

                                <h3 class="text-white text-2xl font-bold">{{ $part['title'] }}</h3>
                                <p class="text-white/90 text-sm mt-1">{{ $part['subtitle'] }}</p>
                                <p class="mt-3 text-white/85 text-sm">{{ $part['description'] }}</p>
                            </div>

                            <div class="p-6 flex flex-col flex-1 bg-blue-50/40 justify-end">
                                @if($isAvailable && ($part['key'] ?? '') === 'A')
                                    <a href="{{ route('assignments.toefl-itp.listening.practice.part-a') }}"
                                       class="block w-full py-3 text-center rounded-xl font-bold shadow bg-red-500 text-white hover:bg-red-600 transition">
                                        Buka Part A ->
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
                    @endforeach
                </div>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Paket Soal Listening</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-5 gap-6">
                    @foreach(($listeningPackages ?? collect()) as $package)
                        @php
                            $isPackageAvailable = ($package['status'] ?? 'coming_soon') === 'available';
                        @endphp
                        <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col hover:-translate-y-1 transform">
                            <div class="bg-gradient-to-r from-sky-600 to-blue-700 px-6 py-4 relative">
                                <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border border-sky-100/50 text-white bg-white/15">
                                    {{ strtoupper(str_replace('_', ' ', $package['status'])) }}
                                </span>

                                <p class="text-white text-sm font-semibold tracking-wide">Listening Package</p>
                            </div>

                            <div class="p-6 flex flex-col flex-1 bg-white justify-between">
                                <div>
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-sm mb-4 bg-sky-100 text-sky-700 border border-sky-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h8m-8 4h6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"></path>
                                        </svg>
                                    </div>

                                    <h3 class="text-slate-900 text-2xl font-bold">{{ $package['title'] }}</h3>
                                    <p class="text-sky-700 text-sm mt-1 font-medium">{{ $package['subtitle'] }}</p>
                                    <p class="mt-3 text-slate-600 text-sm leading-6">{{ $package['description'] }}</p>
                                </div>

                                <button type="button"
                                        disabled
                                        class="block w-full py-3 text-center rounded-xl font-bold shadow cursor-not-allowed bg-sky-400 text-white {{ $isPackageAvailable ? 'hidden' : '' }}">
                                    Coming Soon
                                </button>

                                @if($isPackageAvailable)
                                    <a href="{{ route('assignments.toefl-itp.listening.practice.package', ['package' => $package['package_number']]) }}"
                                       class="block w-full py-3 text-center rounded-xl font-bold shadow bg-red-500 text-white hover:bg-red-600 transition">
                                        Buka Paket {{ $package['package_number'] }} ->
                                    </a>
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
