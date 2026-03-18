<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Berhasil – Target Bahasa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center px-4">

<div class="max-w-md mx-auto text-center">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10">
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Pendaftaran Berhasil!</h1>
        <p class="text-gray-500 text-sm mb-6 leading-relaxed">
            Data kamu sudah kami terima. Tim Target Bahasa akan segera menghubungi kamu via <strong>WhatsApp</strong> untuk informasi lebih lanjut.
        </p>
        <div class="bg-blue-50 rounded-xl p-4 text-sm text-blue-700 mb-8">
            <p class="font-semibold mb-1">Langkah selanjutnya:</p>
            <p>Pantau pesan WhatsApp dari tim kami. Biasanya kami menghubungi dalam <strong>1×24 jam</strong> di hari kerja.</p>
        </div>
        <div class="flex flex-col gap-3">
            <a href="{{ route('registration.show') }}" class="w-full border border-gray-200 text-gray-600 font-semibold py-3 rounded-xl hover:bg-gray-50 transition text-sm">
                Daftarkan orang lain
            </a>
            <a href="{{ route('guest.free-tests') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition text-sm">
                Coba Free Test dulu →
            </a>
        </div>
    </div>
    <p class="text-xs text-gray-400 mt-6">© {{ date('Y') }} Target Bahasa Course</p>
</div>

</body>
</html>
