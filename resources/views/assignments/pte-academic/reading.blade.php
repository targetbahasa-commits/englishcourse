<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Reading | {{ config('app.name', 'Target Bahasa') }}</title>
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
        @elseif(Auth::user()->isGuest() || Auth::user()->role === 'guest_quick')
            @include('components.sidebar-guest')
        @else
            @include('components.sidebar-student')
        @endif

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            {{-- Header --}}
            <div class="mb-6 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
                <div class="flex justify-end items-center gap-2 mb-2">
                    @php
                        $calendarClassPeriodId = Auth::user()->class_period_id ?? '';
                        $calendarBatchName = 'PTE Academic';
                    @endphp
                    @if($calendarClassPeriodId)
                        <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full transition-colors duration-200 shadow-sm shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Lihat Kalender</span>
                        </button>
                    @endif
                    <a href="{{ route('assignments.pte-academic') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-gray-600 bg-white hover:bg-white border border-gray-200 rounded-full shadow-sm transition-all shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Back</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                            <a href="{{ route('assignments.pte-academic') }}" class="hover:text-blue-600 transition">PTE Academic</a>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="text-gray-600 font-medium">Reading</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Reading</h1>
                        <p class="text-xs md:text-sm text-gray-600 mt-1">29 – 30 Minutes. Bagian ini menguji kemampuan memahami teks tertulis dalam bahasa Inggris akademik.</p>
                    </div>
                </div>
            </div>

            {{-- 5 Question Types --}}
            @php
                $questions = [
                    ['title' => 'Reading & Writing: Fill in the Blanks', 'desc' => 'Mengisi titik-titik dalam teks dengan memilih kata dari menu drop-down.', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                    ['title' => 'Multiple Choice, Multiple Answer', 'desc' => 'Memilih lebih dari satu jawaban yang benar berdasarkan teks.', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                    ['title' => 'Re-order Paragraphs', 'desc' => 'Menyusun acak paragraf agar menjadi urutan yang logis.', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                    ['title' => 'Reading: Fill in the Blanks', 'desc' => 'Menyeret (drag and drop) kata-kata yang tepat ke dalam ruang kosong di teks.', 'icon' => 'M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11'],
                    ['title' => 'Multiple Choice, Single Answer', 'desc' => 'Memilih satu jawaban yang benar berdasarkan teks.', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach($questions as $index => $q)
                @php
                    $route = '#';
                    if ($index === 0) {
                        $route = route('assignments.pte-academic.reading.reading-writing-fill-blanks.index');
                    } elseif ($index === 1) {
                        $route = route('assignments.pte-academic.reading.multiple-choice-multiple-answer.index');
                    } elseif ($index === 2) {
                        $route = route('assignments.pte-academic.reading.reorder-paragraphs.index');
                    } elseif ($index === 3) {
                        $route = route('assignments.pte-academic.reading.reading-fill-blanks.index');
                    } elseif ($index === 4) {
                        $route = route('assignments.pte-academic.reading.multiple-choice-single-answer.index');
                    }
                @endphp
                <a href="{{ $route }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-blue-400 to-blue-600 relative flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute top-3 left-3 bg-white/20 text-white font-bold w-8 h-8 rounded-full flex items-center justify-center border border-white/30">{{ $index + 1 }}</div>
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $q['icon'] }}"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col h-[160px]">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $q['title'] }}</h3>
                        <p class="text-gray-500 text-sm mb-4 flex-grow">{{ $q['desc'] }}</p>
                        <div class="w-full text-center bg-blue-500 group-hover:bg-blue-600 text-white font-semibold py-2 rounded-xl transition-colors duration-300 text-sm">
                            Practice
                        </div>
                    </div>
                </a>
                @endforeach

            </div>
        </main>
    </div>
</body>
</html>
