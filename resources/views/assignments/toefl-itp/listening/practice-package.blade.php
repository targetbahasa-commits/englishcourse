<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Listening Practice Paket {{ $package }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
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
                        <div class="p-3 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-2v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent">Listening Practice - Paket {{ $package }}</h1>
                            <p class="text-gray-600 mt-1">Diagnostic Pre-Test (Section 1 Listening Comprehension)</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.toefl-itp.listening.practice') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <div class="space-y-8">
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-2xl font-bold text-blue-800 mb-2">Part A</h2>
                    <p class="text-sm text-gray-600 mb-4">Questions 1-30. Short conversations between two speakers.</p>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        @foreach($partAQuestions as $question)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <p class="font-bold text-gray-900 mb-3">{{ $question->question_number }}. {{ $question->question_text }}</p>
                                <div class="space-y-2 text-sm text-gray-700">
                                    <div>(A) {{ $question->option_a }}</div>
                                    <div>(B) {{ $question->option_b }}</div>
                                    <div>(C) {{ $question->option_c }}</div>
                                    <div>(D) {{ $question->option_d }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-2xl font-bold text-purple-800 mb-2">Part B</h2>
                    <p class="text-sm text-gray-600 mb-4">Questions 31-38. Longer conversations.</p>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        @foreach($partBQuestions as $question)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <p class="font-bold text-gray-900 mb-3">{{ $question->question_number }}. {{ $question->question_text }}</p>
                                <div class="space-y-2 text-sm text-gray-700">
                                    <div>(A) {{ $question->option_a }}</div>
                                    <div>(B) {{ $question->option_b }}</div>
                                    <div>(C) {{ $question->option_c }}</div>
                                    <div>(D) {{ $question->option_d }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-2xl font-bold text-indigo-800 mb-2">Part C</h2>
                    <p class="text-sm text-gray-600 mb-4">Questions 39-50. Talks and lectures.</p>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        @foreach($partCQuestions as $question)
                            <div class="rounded-xl border border-gray-200 p-4">
                                <p class="font-bold text-gray-900 mb-3">{{ $question->question_number }}. {{ $question->question_text }}</p>
                                <div class="space-y-2 text-sm text-gray-700">
                                    <div>(A) {{ $question->option_a }}</div>
                                    <div>(B) {{ $question->option_b }}</div>
                                    <div>(C) {{ $question->option_c }}</div>
                                    <div>(D) {{ $question->option_d }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
