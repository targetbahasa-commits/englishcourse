<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reading & Writing: Fill in the Blanks | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white flex flex-col min-h-screen">

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

        <main class="flex-1 md:ml-64 p-4 md:p-8">
            <div class="mb-6 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
                <div class="flex justify-end mb-2">
                    <a href="{{ route('assignments.pte-academic.reading.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Back</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.pte-academic.reading.index') }}" class="hover:text-blue-600 transition">Reading</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Reading & Writing: Fill in the Blanks</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">300 Practice Topics</h1>
                            <p class="text-gray-600 mt-1">Pilih topik untuk memulai latihan Reading & Writing: Fill in the Blanks.</p>
                        </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @for ($i = 1; $i <= 300; $i++)
                <a id="topic-{{ $i }}" data-topic-card="{{ $i }}" href="{{ route('assignments.pte-academic.reading.reading-writing-fill-blanks.practice', ['id' => $i]) }}" class="group relative bg-white border border-gray-100 rounded-2xl p-5 hover:border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                    <x-pte-topic-badge />
                    <div class="relative flex items-center justify-between w-full mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-xl shadow-md flex items-center justify-center font-bold text-lg group-hover:shadow-lg transition-all duration-300">
                            {{ $i }}
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-300 group-hover:bg-white group-hover:text-blue-500 transition-all duration-300">
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                    <div class="relative mt-auto">
                        <h3 class="text-gray-800 font-bold text-lg mb-1 group-hover:text-blue-700 transition-colors">{{ $topics[$i]['title'] }}</h3>
                        <p class="text-gray-500 text-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Fill in the Blanks
                        </p>
                    </div>
                </a>
                @endfor
            </div>
        </main>
    </div>


    <script src="{{ asset('js/pte-tracking.js') }}"></script>
    <script>
        pteTracking.init('reading-writing-fill-blanks');
    </script>

</body>
</html>
