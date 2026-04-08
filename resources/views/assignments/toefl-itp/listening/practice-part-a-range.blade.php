<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Listening Part A {{ $start }}-{{ $end }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6m2 13H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Part A Soal {{ $start }}-{{ $end }}</h1>
                            <p class="text-gray-600 mt-1">Total {{ $questions->count() }} soal</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.toefl-itp.listening.practice.part-a') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            @if($questions->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-600">
                    Soal untuk rentang ini belum tersedia.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($questions as $question)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <div class="flex items-start gap-4">
                                <span class="flex-shrink-0 w-10 h-10 rounded-xl bg-blue-50 text-blue-700 font-bold flex items-center justify-center">{{ $question->question_number }}</span>
                                <div class="w-full">
                                    <p class="text-gray-700 font-semibold mb-4">{{ $question->question_text ?: ('Question ' . $question->question_number) }}</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-700">
                                        <div class="rounded-xl border border-gray-200 px-4 py-2">A. {{ $question->option_a }}</div>
                                        <div class="rounded-xl border border-gray-200 px-4 py-2">B. {{ $question->option_b }}</div>
                                        <div class="rounded-xl border border-gray-200 px-4 py-2">C. {{ $question->option_c }}</div>
                                        <div class="rounded-xl border border-gray-200 px-4 py-2">D. {{ $question->option_d }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</body>
</html>
