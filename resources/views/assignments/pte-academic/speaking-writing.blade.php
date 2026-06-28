<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Speaking & Writing | {{ config('app.name', 'Target Bahasa') }}</title>
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
        @else
            @include('components.sidebar-student')
        @endif

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-orange-500 to-orange-700 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.pte-academic') }}" class="hover:text-orange-600 transition">PTE Academic</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-600 font-medium">Speaking & Writing</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">Speaking & Writing</h1>
                            <p class="text-gray-600 mt-1">54 – 67 Minutes. Kedua kemampuan ini digabung dalam satu sesi.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $calendarClassPeriodId = Auth::user()->class_period_id ?? '';
                            $calendarBatchName = 'PTE Academic';
                        @endphp
                        @if($calendarClassPeriodId)
                            <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Lihat Kalender
                            </button>
                        @endif
                        <a href="{{ route('assignments.pte-academic') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- 8 Question Types --}}
            @php
                $questions = [
                    ['title' => 'Personal Introduction', 'desc' => 'Perkenalan diri (tidak dinilai, hanya untuk dikirim ke universitas).', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'route' => route('assignments.pte-academic.speaking-writing.personal-introduction.practice')],
                    ['title' => 'Read Aloud', 'desc' => 'Membaca teks di layar dengan suara lantang.', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'route' => route('assignments.pte-academic.speaking-writing.read-aloud.index')],
                    ['title' => 'Repeat Sentence', 'desc' => 'Mendengarkan kalimat lalu mengulanginya dengan tepat.', 'icon' => 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828', 'route' => route('assignments.pte-academic.speaking-writing.repeat-sentence.index')],
                    ['title' => 'Describe Image', 'desc' => 'Menjelaskan gambar atau grafik yang muncul di layar.', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'route' => route('assignments.pte-academic.speaking-writing.describe-image.index')],
                    ['title' => 'Re-tell Lecture', 'desc' => 'Mendengarkan kuliah singkat lalu menceritakan kembali isinya.', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'route' => route('assignments.pte-academic.speaking-writing.retell-lecture.index')],
                    ['title' => 'Answer Short Question', 'desc' => 'Menjawab pertanyaan singkat dengan satu atau beberapa kata.', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => route('assignments.pte-academic.speaking-writing.answer-short-question.index')],
                    ['title' => 'Summarize Written Text', 'desc' => 'Membaca teks dan merangkumnya dalam satu kalimat saja.', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'route' => route('assignments.pte-academic.speaking-writing.summarize-written-text.index')],
                    ['title' => 'Write Essay', 'desc' => 'Menulis esai 200–300 kata berdasarkan topik yang diberikan.', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'route' => route('assignments.pte-academic.speaking-writing.write-essay.index')],
                ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach($questions as $index => $q)
                <a href="{{ $q['route'] }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="h-32 bg-gradient-to-br from-orange-400 to-orange-600 relative flex items-center justify-center overflow-hidden">
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
                        <div class="w-full text-center bg-orange-500 group-hover:bg-orange-600 text-white font-semibold py-2 rounded-xl transition-colors duration-300 text-sm">
                            Practice
                        </div>
                    </div>
                </a>
                @endforeach

            </div>
        </main>
    </div>
    @include('components.meetings-calendar-modal')
</body>
</html>
