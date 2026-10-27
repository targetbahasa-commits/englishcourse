@php
    $mode = app(\App\Application\GrammarPlacement\ResolveSelfStudyGrammarMode::class)->resolve((float) $result->percentage);
    $modeLabel = $mode === 'B'
        ? 'Jalur Lanjutan (B1-C2)'
        : 'Jalur Bertahap (A1 ke B1-B2)';
    $modeDescription = $mode === 'B'
        ? 'Materi Modul 1 akan ditampilkan langsung dengan kosakata tingkat lanjut (B1-C2).'
        : 'Materi Modul 1 akan dimulai dari kosakata dasar (A1-A2) dan meningkat bertahap menuju B1-B2.';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Tes Penempatan - Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 min-h-screen py-8 px-4">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 text-center text-white">
                <div class="w-16 h-16 bg-white/15 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h1 class="text-xl font-bold">Terima kasih, {{ $result->student_name }}!</h1>
                <p class="text-blue-100 text-sm mt-1">Tes penempatanmu sudah selesai dinilai.</p>
            </div>

            <div class="p-8 text-center">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-2xl font-black bg-indigo-100 text-indigo-800">{{ $result->cefr_level }}</span>
                <p class="text-sm text-gray-500 mt-2">Skor: {{ $result->correct_count }}/{{ $result->total_count }} ({{ $result->percentage }}%)</p>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Jalur Materimu</p>
                    <p class="text-lg font-bold text-blue-700">{{ $modeLabel }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $modeDescription }}</p>
                </div>

                <a href="{{ route('self-study-classes.player', ['course' => 'grammar-for-writing']) }}"
                   class="mt-8 inline-flex justify-center items-center gap-2 px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all hover:shadow-md w-full">
                    Mulai Belajar
                </a>
            </div>
        </div>
        <p class="text-center text-xs text-gray-400 mt-6">Target Bahasa &middot; targetbahasa.com</p>
    </div>
</body>
</html>
