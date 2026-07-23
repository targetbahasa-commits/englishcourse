<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waktu Tes Berakhir - Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased flex items-center justify-center min-h-screen p-4 bg-cover bg-center bg-gray-50"
    style="background-image: url('{{ asset('images/background-container/background-kelas.png') }}');">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-red-50 p-6 flex justify-center border-b border-red-100">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center text-red-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Waktu Tes Telah Habis</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Mohon maaf, batas waktu untuk mengerjakan promo tes gratis ini sudah berakhir atau tidak aktif lagi.
                Silakan tunggu informasi tes lainnya dari Target Bahasa.
            </p>
            <a href="https://targetbahasa.com"
                class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all hover:shadow-md w-full">
                Kembali ke Beranda
            </a>

            <p class="mt-6 text-sm text-gray-500">
                Ada pertanyaan? Hubungi tim admin <a href="https://wa.me/628123456789"
                    class="text-blue-600 hover:underline">WhatsApp</a>.
            </p>
        </div>
    </div>
</body>

</html>