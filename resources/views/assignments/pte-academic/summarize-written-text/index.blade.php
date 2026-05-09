<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Summarize Written Text | {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::check())
            @php($sidebarRole = strtolower(Auth::user()->active_role ?? 'student'))
            @if($sidebarRole === 'admin')
                @include('components.sidebar-admin')
            @elseif($sidebarRole === 'teacher')
                @include('components.sidebar-teacher')
            @elseif(in_array($sidebarRole, ['guest', 'guest_quick']))
                @include('components.sidebar-guest')
            @else
                @include('components.sidebar-student')
            @endif
        @else
            @include('components.sidebar-guest')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}" class="hover:text-emerald-600 transition">Speaking &amp; Writing</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Summarize Written Text</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">300 Summarize Written Text Topics</h1>
                            <p class="text-gray-600 mt-1">Pilih topik untuk memulai latihan Summarize Written Text Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @for ($i = 1; $i <= 300; $i++)
                <a href="{{ route('assignments.pte-academic.speaking-writing.summarize-written-text.practice', ['id' => $i]) }}" class="group relative bg-white border border-gray-100 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <div class="relative flex items-center justify-between w-full mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 text-white rounded-xl shadow-md flex items-center justify-center font-bold text-lg group-hover:shadow-lg transition-all duration-300">
                            {{ $i }}
                        </div>
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-all duration-300">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                    <div class="relative mt-auto">
                        <h3 class="text-gray-800 font-bold text-lg mb-1 group-hover:text-emerald-700 transition-colors">{{ $topics[$i]['title'] }}</h3>
                        <p class="text-gray-500 text-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Summarize Written Text Practice
                        </p>
                    </div>
                </a>
                @endfor
            </div>
        </main>
    </div>

</body>
</html>
