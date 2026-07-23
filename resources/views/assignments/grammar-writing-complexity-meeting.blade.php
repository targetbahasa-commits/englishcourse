<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $trackTitle }} - Meeting {{ $meetingNumber }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
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

        <main class="flex-1 md:ml-64 p-4 sm:p-6 md:p-8">
            <!-- Topbar -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-6 md:mb-8">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm" placeholder="Search">
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
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $trackTitle }}</h2>
                    <p class="text-gray-500 text-sm">Meeting {{ $meetingNumber }} &mdash; {{ $topic }}</p>
                </div>
                <a href="{{ route('assignments.grammar-writing.track', 'complexity') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
            </div>

            @if(isset($questions))
            <form method="post" action="#" class="bg-white rounded-3xl shadow-sm border border-green-100 overflow-visible">
                @csrf
                <div class="bg-gradient-to-r from-green-50 via-emerald-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-green-100">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800">Soal Meeting {{ $meetingNumber }}</h3>
                            <p class="text-gray-600 mt-1 text-sm sm:text-base">Terjemahkan dan isi jawaban untuk setiap soal di bawah ini.</p>
                        </div>
                        <span class="inline-flex items-center justify-center rounded-full bg-green-600 text-white text-xs font-bold px-3 py-1.5 w-fit">
                            {{ count($questions) }} Soal
                        </span>
                    </div>
                </div>

                <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                    <ol class="space-y-4 sm:space-y-5">
                        @foreach($questions as $i => $q)
                            @php
                                $helper = $questionHelpers[$i + 1] ?? ['example' => null, 'vocab' => []];
                            @endphp
                            <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-green-200 space-y-3 overflow-visible">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-green-100 text-green-700 flex items-center justify-center text-sm font-bold shrink-0">
                                        {{ $i + 1 }}
                                    </div>
                                    <div class="pt-1 flex-1">
                                        <p class="text-gray-800 leading-relaxed">{{ $q }}</p>
                                    </div>
                                    <div class="flex flex-row items-center gap-1 ml-2">
                                        @if(!empty($helper['example']))
                                            <div x-data="{ open: false }" class="relative inline-block">
                                                <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                    ?
                                                </button>
                                                <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed" style="display: none;">
                                                    <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                    {{ $helper['example']['id'] }}<br>
                                                    <em class="text-gray-300">{{ $helper['example']['en'] }}</em>
                                                    <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(!empty($helper['vocab']))
                                            <div x-data="{ open: false }" class="relative inline-block">
                                                <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                                    v
                                                </button>
                                                <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                    <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                    <ul class="space-y-1">
                                                        @foreach($helper['vocab'] as $word => $info)
                                                            <li class="flex justify-between gap-3">
                                                                <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] }}</span></span>
                                                                <span>{{ $info['id'] }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-11 sm:ml-13">
                                    <input type="text"
                                           name="answers[{{ $i + 1 }}]"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white hover:border-gray-400"
                                           placeholder="Tulis bahasa Inggrisnya di sini..."
                                           autocomplete="off">
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="px-5 py-6 sm:px-8 border-t border-gray-100 bg-gray-50/60 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('assignments.grammar-writing.track', 'complexity') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                    <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kirim Jawaban
                    </button>
                </div>
            </form>
            @else
            <div class="flex flex-col items-center justify-center min-h-[60vh]">
                <div class="bg-white rounded-3xl shadow-sm p-16 text-center max-w-lg w-full">
                    <div class="w-20 h-20 bg-green-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Meeting {{ $meetingNumber }}</h3>
                    <p class="text-green-600 font-semibold text-lg mb-4">{{ $topic }}</p>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Konten untuk meeting ini sedang disiapkan.<br>
                        Silakan tunggu update berikutnya.
                    </p>
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('assignments.grammar-writing.track', 'complexity') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                    </div>
                </div>
            </div>
            @endif
        </main>
    </div>

    <x-irregular-verbs-button />

    @include('components.student-broadcaster')
</body>
</html>
