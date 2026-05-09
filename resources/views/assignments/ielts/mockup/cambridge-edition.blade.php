<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambridge {{ $edition }} Mock Tests - {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
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
                                <a href="{{ route('assignments.ielts-academic.mockup.cambridge') }}" class="hover:text-purple-600 transition">Cambridge IELTS</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Cambridge {{ $edition }}</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">Cambridge {{ $edition }} Mock Tests</h1>
                            <p class="text-gray-600 mt-1">Select a test to begin your exam</p>
                        </div>
                    </div>
                    @if(Auth::user()->active_role === 'guest_quick')
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge') }}?editions=1" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Free Tests
                    </a>
                    @else
                    <a href="{{ route('assignments.ielts-academic.mockup.cambridge') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                    @endif
                </div>
            </div>

            {{-- 4 Test Cards --}}
            @php
                $isGuestQuick = Auth::user()->active_role === 'guest_quick';
                $testLinks = [
                    1 => in_array($edition, [16, 17, 18, 19, 20]) ? route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => 1]) : '#',
                    2 => in_array($edition, [16, 17, 18, 19, 20]) ? route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => 2]) : '#',
                    3 => in_array($edition, [16, 17, 18, 19, 20]) ? route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => 3]) : '#',
                    4 => in_array($edition, [16, 17, 18, 19, 20]) ? route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => 4]) : '#',
                ];
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
                        <span class="bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Locked
                        </span>
                    </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 {{ $locked ? 'bg-gray-100 text-gray-400' : 'bg-purple-100 text-purple-700' }} rounded-full text-xs font-bold uppercase tracking-wide">Test {{ $testNum }}</span>
                            <span class="text-gray-400 text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Full Test
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold {{ $locked ? 'text-gray-400' : 'text-gray-800' }} mb-2">TEST {{ $testNum }}</h3>
                        <p class="{{ $locked ? 'text-gray-400' : 'text-gray-600' }} text-sm mb-6">Cambridge {{ $edition }} complete mock test {{ $testNum }} — Listening, Reading, Writing &amp; Speaking.</p>
                        @if($locked)
                            @php
                                $pkgSlug = "cambridge-{$edition}";
                                $testSlug = "cambridge-{$edition}-test-{$testNum}";
                                
                                $pkgProg = \App\Models\Program::where('slug', $pkgSlug)->first();
                                $testProg = \App\Models\Program::where('slug', $testSlug)->first();
                                
                                $pkgPrice = $pkgProg ? 'IDR ' . number_format($pkgProg->price, 0, ',', '.') : 'IDR 150.000';
                                $testPrice = $testProg ? 'IDR ' . number_format($testProg->price, 0, ',', '.') : 'IDR 50.000';
                            @endphp
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('mock-test.register-or-pay') . '?program=' . $pkgSlug }}" class="flex items-center justify-center gap-2 w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl transition text-sm shadow-sm">
                                    Buy Full Edition {{ $pkgPrice ? "({$pkgPrice})" : '' }}
                                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </a>
                                @if(in_array($edition, [16,17,18,19,20]))
                                <a href="{{ route('mock-test.register-or-pay') . '?program=' . $testSlug . '-per-part' }}" class="flex items-center justify-center gap-2 w-full text-center bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-2.5 rounded-xl transition text-sm shadow-sm">
                                    Buy Per Test (IDR 50.000)
                                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </a>
                                @endif
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
