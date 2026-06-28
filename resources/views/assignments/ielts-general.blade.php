<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IELTS General - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-red-50 via-rose-50 to-pink-50">
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
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text text-transparent">IELTS General Training</h1>
                            <p class="text-gray-600 mt-1">Practical scenarios and comprehensive drills for IELTS General! 🌍</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Assignments
                    </a>
                </div>
            </div>

            <!-- Coming Soon Banner -->
            <div class="bg-gradient-to-r from-red-500 to-rose-500 rounded-2xl p-6 mb-8 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Coming Soon! 🚀</h2>
                        <p class="text-red-100 text-sm mt-1">IELTS General Training content is being prepared. Full reading and writing practice sets for practical scenarios will be available soon.</p>
                    </div>
                </div>
            </div>

            <!-- Difference from IELTS Academic info box -->
            <div class="bg-white rounded-2xl p-6 mb-8 shadow-sm border border-red-100">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Perbedaan IELTS General vs. Academic
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="bg-red-50 rounded-xl p-4">
                        <p class="font-semibold text-red-700 mb-2">IELTS General Training (ini)</p>
                        <ul class="space-y-1">
                            <li>✅ Cocok untuk imigrasi & visa kerja</li>
                            <li>✅ Reading: teks praktis & formal</li>
                            <li>✅ Writing Task 1: surat formal/informal</li>
                            <li>✅ Listening & Speaking: sama dengan Academic</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="font-semibold text-gray-700 mb-2">IELTS Academic</p>
                        <ul class="space-y-1">
                            <li>📚 Cocok untuk kuliah & universitas</li>
                            <li>📚 Reading: teks akademis kompleks</li>
                            <li>📚 Writing Task 1: grafik & diagram</li>
                            <li>📚 Listening & Speaking: sama</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sections Grid (Preview) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @php
                    $sections = [
                        ['title' => 'Listening', 'desc' => 'Sama seperti IELTS Academic – 4 bagian percakapan dan monolog berbagai aksen.', 'color' => 'blue', 'gradient' => 'from-blue-400 to-blue-600', 'icon' => 'M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828 2.828'],
                        ['title' => 'Reading (General)', 'desc' => 'Tiga bagian – teks praktis, teks formal, dan esai panjang berbasis kehidupan sehari-hari.', 'color' => 'green', 'gradient' => 'from-green-400 to-green-600', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['title' => 'Writing (General)', 'desc' => 'Task 1: surat formal/semi-formal. Task 2: esai argumentatif umum.', 'color' => 'purple', 'gradient' => 'from-purple-400 to-purple-600', 'icon' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z'],
                        ['title' => 'Speaking', 'desc' => 'Sama seperti IELTS Academic – tiga bagian wawancara dengan ekaminator.', 'color' => 'red', 'gradient' => 'from-red-400 to-red-600', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                    ];
                @endphp
                @foreach($sections as $section)
                <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 opacity-70">
                    <div class="h-32 bg-gradient-to-br {{ $section['gradient'] }} relative overflow-hidden">
                        <div class="absolute bottom-4 left-6">
                            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-{{ $section['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $section['icon'] }}"></path></svg>
                            </div>
                        </div>
                        <div class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm text-gray-600 text-xs font-bold px-3 py-1 rounded-full">Coming Soon</div>
                    </div>
                    <div class="p-6 pt-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $section['title'] }}</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $section['desc'] }}</p>
                        <button disabled class="block w-full text-center bg-gray-200 text-gray-400 font-bold py-3 px-6 rounded-xl cursor-not-allowed">
                            Coming Soon
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
    @include('components.floating-wa-button')
</body>
</html>
