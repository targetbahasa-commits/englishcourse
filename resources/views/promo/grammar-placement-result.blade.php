<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Tes Penempatan Grammar - Target Bahasa</title>
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
                <p class="text-blue-100 text-sm mt-1">Tes penempatan grammar kamu sudah selesai dinilai.</p>
            </div>

            <div class="p-8 text-center">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-2xl font-black bg-indigo-100 text-indigo-800">{{ $result->cefr_level }}</span>
                <p class="text-sm text-gray-500 mt-2">Skor: {{ $result->correct_count }}/{{ $result->total_count }} ({{ $result->percentage }}%)</p>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Kelas yang Cocok Untukmu</p>
                    @if($result->recommendedProgram)
                        <p class="text-lg font-bold text-blue-700">{{ $result->recommendedProgram->name }}</p>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum ada kelas yang cocok ditemukan. Tim kami akan menghubungimu.</p>
                    @endif
                </div>

                <a href="https://wa.me/6285706615607?text={{ urlencode('Halo, saya sudah mengerjakan Tes Penempatan Grammar (' . $result->cefr_level . ') dan ingin tahu info kelas ' . ($result->recommendedProgram->name ?? 'Grammar') . '.') }}"
                   target="_blank"
                   class="mt-8 inline-flex justify-center items-center gap-2 px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition-all hover:shadow-md w-full">
                    Chat Admin via WhatsApp
                </a>
                <a href="https://targetbahasa.com" class="mt-3 inline-flex justify-center items-center px-6 py-3 border border-gray-200 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all w-full">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
        <p class="text-center text-xs text-gray-400 mt-6">Target Bahasa &middot; targetbahasa.com</p>
    </div>
</body>
</html>
