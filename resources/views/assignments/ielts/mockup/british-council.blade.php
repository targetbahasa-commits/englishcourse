<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>British Council Mock Tests - {{ config('app.name', 'Target Bahasa') }}</title>
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
            @php
                $isGeneral = !empty($isGeneral) || request()->routeIs('mock-test.ielts-general*');
                $backLink = $isGeneral ? route('mock-test.ielts-general') : url('/mock-test/ielts-academic');
            @endphp
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-red-600 to-red-800 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ $backLink }}" class="hover:text-red-600 transition">IELTS {{ $isGeneral ? 'General' : 'Academic' }}</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">British Council</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">British Council IELTS {{ $isGeneral ? 'General' : '' }} Mock Tests</h1>
                            <p class="text-gray-600 mt-1">Select a test to begin your exam</p>
                        </div>
                    </div>
                    <a href="{{ $backLink }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-white border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                </div>
            </div>

            @if($isGeneral)
                {{-- Empty state for IELTS General British Council --}}
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-200 shadow-sm max-w-2xl mx-auto my-8">
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Materi Belum Tersedia</h3>
                    <p class="text-gray-500 mb-6">Materi British Council IELTS General saat ini belum tersedia. Silakan gunakan latihan Cambridge IELTS General.</p>
                    <a href="{{ route('mock-test.ielts-general.cambridge') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl transition shadow-md">
                         Buka Cambridge IELTS General →
                    </a>
                </div>
            @else
                {{-- 10 Test Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    @foreach(range(1, 10) as $testNum)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden transition relative hover:shadow-md">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase tracking-wide">Test {{ $testNum }}</span>
                                <span class="text-gray-400 text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Full Test
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">TEST {{ $testNum }}</h3>
                            <p class="text-gray-600 text-sm mb-6">British Council complete mock test {{ $testNum }} — Listening, Reading, Writing &amp; Speaking.</p>
                            <a href="{{ route('assignments.ielts-academic.mockup.british-council.skills', ['id' => $testNum]) }}" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition">
                                Start Test
                            </a>
                        </div>
                    </div>
                    @endforeach

                </div>
            @endif

        </main>
    </div>
</body>
</html>
