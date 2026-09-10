<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambridge {{ $edition }} Mock Tests - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @elseif(Auth::user()->active_role === 'guest_quick')
            @include('components.sidebar-guest')
        @else
            @include('components.sidebar-student')
        @endif

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ request()->routeIs('mock-test.ielts-general*') ? route('mock-test.ielts-general.cambridge') : route('mock-test.ielts-academic.cambridge') }}" class="hover:text-purple-600 transition">Cambridge IELTS {{ request()->routeIs('mock-test.ielts-general*') ? 'General' : 'Academic' }}</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Cambridge {{ $edition }}</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">Cambridge {{ $edition }} {{ request()->routeIs('mock-test.ielts-general*') ? 'General Reading' : '' }} Mock Tests</h1>
                            <p class="text-gray-600 mt-1">Select a test to begin your exam</p>
                        </div>
                    </div>
                    @if(Auth::user()->active_role === 'guest_quick')
                    <a href="{{ request()->routeIs('mock-test.ielts-general*') ? route('mock-test.ielts-general.cambridge') : route('mock-test.ielts-academic.cambridge') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-white border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                    @endif
                </div>
            </div>

            {{-- 4 Test Cards --}}
            @php
                $isGeneral = request()->routeIs('mock-test.ielts-general*');
                $isGuestQuick = Auth::user()->active_role === 'guest_quick';
                $validEditions = range(1, 20);
                $testLinks = [];
                foreach([1,2,3,4] as $tNum) {
                    if ($isGeneral) {
                        $testLinks[$tNum] = route('mock-test.ielts-general.cambridge.skills', ['edition' => $edition, 'id' => $tNum]);
                    } else {
                        $testLinks[$tNum] = in_array($edition, $validEditions) ? route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $tNum]) : '#';
                    }
                }
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach([1,2,3,4] as $testNum)
                @php 
                    $accessPolicy = app()->make(\App\Domain\IeltsShared\CambridgeAccessPolicy::class);
                    $locked = !$accessPolicy->canAccess(Auth::user(), (int) $edition, (int) $testNum);
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden transition relative {{ $locked ? 'opacity-90' : 'hover:shadow-md' }}">
                    @if($locked)
                    <div class="absolute top-4 right-4 z-10">
                        <span class="bg-white text-gray-500 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Locked
                        </span>
                    </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 {{ $locked ? 'bg-white text-gray-400' : 'bg-white text-purple-700' }} rounded-full text-xs font-bold uppercase tracking-wide">Test {{ $testNum }}</span>
                            <span class="text-gray-400 text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Full Test
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold {{ $locked ? 'text-gray-400' : 'text-gray-800' }} mb-2">TEST {{ $testNum }}</h3>
                        <p class="{{ $locked ? 'text-gray-400' : 'text-gray-600' }} text-sm mb-6">
                            Cambridge {{ $edition }} complete mock test {{ $testNum }} — Listening, Reading, Writing &amp; Speaking.
                        </p>
                        @if($locked)
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('brochure') }}" target="_blank" class="flex items-center justify-center gap-2 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition text-sm shadow-sm">
                                    Lihat Brosur Program
                                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </a>
                            </div>
                        @else
                            <a href="{{ $testLinks[$testNum] }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition">
                                Start Test
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach

            </div>

        </main>
    </div>
</body>
</html>
