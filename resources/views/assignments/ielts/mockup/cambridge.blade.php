<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Mock Tests - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
                         <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Mock Tests</h1>
                            <p class="text-gray-600 mt-1">Pilih jenis mock test untuk memulai</p>
                        </div>
                    </div>
                    @if(Auth::user()->active_role === 'guest_quick')
                    <a href="{{ request()->routeIs('mock-test.ielts-academic.cambridge') ? route('mock-test.ielts-academic') : (request()->has('editions') ? route('assignments.ielts-academic.mockup.cambridge') : route('guest.free-tests')) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            {{ 'Kembali ke Pilihan' }}
                    </a>
                    @else
                    <a href="{{ request()->routeIs('mock-test.ielts-academic.cambridge') ? route('mock-test.ielts-academic') : (request()->routeIs('mock-test.ielts-academic') ? route('mock-test') : route('assignments.ielts-academic')) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                    @endif
                </div>
            </div>

            {{-- Guest Quick Banner --}}
            @if(Auth::user()->active_role === 'guest_quick')
            <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white flex flex-col md:flex-row items-center justify-between gap-4 shadow-lg">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>
                        <span class="font-bold text-yellow-200 text-sm uppercase tracking-wider">Akses Gratis Aktif</span>
                    </div>
                    <p class="font-bold text-xl mb-1">Kamu sedang mencoba IELTS Mock Test secara gratis!</p>
                    <p class="text-blue-100 text-sm">Daftar sebagai student untuk mengakses semua edisi Cambridge, British Council, serta materi lengkap lainnya.</p>
                </div>
                <a href="{{ route('mock-test.register-or-pay') . '?program=ielts-academic' }}" class="flex-shrink-0 bg-white text-blue-700 font-bold px-6 py-3 rounded-xl hover:bg-blue-50 transition shadow">
                    🎓 Daftar Sekarang →
                </a>
            </div>
            @endif

            @php $isGuestQuick = Auth::user()->active_role === 'guest_quick'; @endphp
            @if(!request()->has('editions') && !request()->routeIs('mock-test.ielts-academic.cambridge'))
                {{-- View: Cambridge vs British Council --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                    {{-- Cambridge: Unlocked for everyone --}}
                    <div class="bg-white rounded-2xl shadow-md border border-purple-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="h-44 bg-gradient-to-br from-purple-500 to-purple-700 relative flex items-center justify-center overflow-hidden">
                            <div class="absolute top-3 right-3 bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-lg border border-white/30 backdrop-blur-sm">MOCK UP</div>
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center border border-white/30">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($isGuestQuick)
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">✓ Gratis</span>
                            </div>
                            @endif
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Cambridge IELTS TEST</h3>
                            <p class="text-gray-500 text-sm mb-6">Full mock exam. @if($isGuestQuick) Cambridge 16–20 tersedia untuk dicoba gratis. @endif</p>
                            <a href="{{ request()->routeIs('mock-test.ielts-academic') ? route('mock-test.ielts-academic.cambridge') : route('assignments.ielts-academic.mockup.cambridge') . '?editions=1' }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition">
                                Start Test →
                            </a>
                        </div>
                    </div>

                    {{-- British Council: Locked for Guests, Unlocked for Students --}}
                    <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden relative">
                        <div class="h-44 bg-gradient-to-br from-red-500 to-red-700 relative flex items-center justify-center overflow-hidden">
                            <div class="absolute top-3 right-3 bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-lg border border-white/30 backdrop-blur-sm">MOCK UP</div>
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center border border-white/30">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            {{-- Lock Overlay --}}
                            @if($isGuestQuick)
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-10 h-10 text-white mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <span class="text-white font-bold text-sm">Khusus Student</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="p-6">
                            @if($isGuestQuick)
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">🔒 Student Only</span>
                            </div>
                            @endif
                            <h3 class="text-xl font-bold text-gray-800 mb-2">British Council IELTS TEST</h3>
                            <p class="text-gray-500 text-sm mb-6">Full mock exam. @if($isGuestQuick) Daftar sebagai student untuk mengakses British Council mock test. @endif</p>
                            @if($isGuestQuick)
                            <a href="{{ route('mock-test.register-or-pay') . '?program=ielts-academic' }}" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition">
                                Daftar untuk Akses →
                            </a>
                            @else
                            <a href="{{ route('assignments.ielts-academic.mockup.british-council') }}" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition shadow-md hover:shadow-lg transform hover:scale-105">
                                Start Test
                                <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

            @else
                @php 
                    $isGuestQuick = Auth::user()->active_role === 'guest_quick'; 
                    $editionSlugs = collect([16, 17, 18, 19, 20])->map(fn($e) => "cambridge-{$e}")->toArray();
                    $editionPrograms = \App\Models\Program::whereIn('slug', $editionSlugs)->get()->keyBy('slug');
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach([16, 17, 18, 19, 20] as $edition)
                    @php 
                        $locked = $isGuestQuick && $edition !== 16;
                        $prog = $editionPrograms->get("cambridge-{$edition}");
                        $priceText = $prog ? 'IDR ' . number_format($prog->price, 0, ',', '.') : '';
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm border {{ $locked ? 'border-gray-200 opacity-90' : 'border-gray-200 hover:shadow-md' }} overflow-hidden transition relative">
                        @if($locked)
                        {{-- Lock badge --}}
                        <div class="absolute top-4 right-4 z-10">
                            <span class="bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Locked
                            </span>
                        </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 {{ $locked ? 'bg-gray-100 text-gray-400' : 'bg-purple-100 text-purple-700' }} rounded-full text-xs font-bold uppercase tracking-wide">Edition {{ $edition }}</span>
                                <span class="text-gray-400 text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Full Exam
                                </span>
                            </div>
                            <a href="{{ route('mock-test.ielts-academic.cambridge.edition', ['edition' => $edition]) }}" class="hover:text-purple-600 transition">
                                <h3 class="text-2xl font-bold {{ $locked ? 'text-gray-400' : 'text-gray-800' }} mb-2">CAMBRIDGE {{ $edition }}</h3>
                            </a>
                            <p class="{{ $locked ? 'text-gray-400' : 'text-gray-600' }} text-sm mb-6">Complete listening, reading, writing, and speaking mock tests from Cambridge {{ $edition }}.</p>
                            @if($locked)
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('mock-test.register-or-pay') . '?program=cambridge-' . $edition }}" class="flex items-center justify-center gap-2 w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl transition text-sm shadow-sm">
                                        Buy Full Edition {{ $priceText ? "({$priceText})" : '' }}
                                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </a>
                                    <a href="{{ route('mock-test.ielts-academic.cambridge.edition', ['edition' => $edition]) }}" class="flex items-center justify-center gap-2 w-full text-center bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-2.5 rounded-xl transition text-sm shadow-sm">
                                        Buy Per Test (IDR 50.000)
                                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </a>
                                </div>
                            @else
                                <a href="{{ route('mock-test.ielts-academic.cambridge.edition', ['edition' => $edition]) }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition">
                                    Start Exam
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

        </main>
    </div>
</body>
</html>
