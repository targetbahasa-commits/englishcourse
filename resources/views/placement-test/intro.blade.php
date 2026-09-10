<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Target Bahasa') }} - Tes Kompetensi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">

<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl shadow-lg shadow-blue-500/30 mb-6 transform hover:scale-105 transition-transform">
                <span class="text-2xl font-bold text-white tracking-widest">TB</span>
            </a>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Tes Kompetensi Bahasa Inggris</h1>
            <p class="mt-3 text-base text-gray-500 max-w-lg mx-auto">
                Ukur kemampuan Reading, Listening, Writing, dan Speaking-mu sebelum memilih kelas. Hasilnya langsung menunjukkan level CEFR-mu dan rekomendasi program yang sesuai.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10">
            <div class="grid grid-cols-2 gap-4 mb-8">
                @foreach ([
                    ['label' => 'Reading', 'desc' => 'Bacaan + pilihan ganda'],
                    ['label' => 'Listening', 'desc' => 'Audio + pilihan ganda'],
                    ['label' => 'Writing', 'desc' => 'Menulis esai singkat'],
                    ['label' => 'Speaking', 'desc' => 'Rekam jawaban lisan'],
                ] as $skill)
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="font-bold text-gray-800">{{ $skill['label'] }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $skill['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            @if (session('error'))
                <div class="bg-amber-50 text-amber-700 rounded-xl p-4 text-sm font-medium border border-amber-100 mb-4">{{ session('error') }}</div>
            @endif

            @if ($hasActivePackage)
                <a href="{{ route('placement-test.register.show') }}" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors transform hover:-translate-y-0.5">
                    Mulai Tes Kompetensi <span class="ml-2">&rarr;</span>
                </a>
                <p class="text-center text-xs text-gray-400 mt-4">Hasil akan disimpan di akun Anda dan dapat dilihat kembali kapan saja.</p>
            @else
                <div class="w-full flex justify-center py-3.5 px-4 rounded-xl bg-gray-100 text-sm font-bold text-gray-400 cursor-not-allowed">
                    Tes Belum Tersedia
                </div>
                <p class="text-center text-xs text-gray-400 mt-4">Tes kompetensi sedang disiapkan. Silakan cek kembali beberapa saat lagi.</p>
            @endif
        </div>
    </div>
</div>
</body>
</html>
