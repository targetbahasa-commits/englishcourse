<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Test PTE Academic | Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased flex items-center justify-center min-h-screen p-4 bg-gray-50">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-6 flex justify-center border-b border-gray-100" style="background-color:#e0f2fe;">
            <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background-color:#bae6fd; color:#0284c7;">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        <div class="p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Terima Kasih, {{ $submission->name }}!</h2>

            @if(!is_null($submission->estimated_band_score))
                <p class="text-gray-500 mb-1">Estimasi Skor PTE Anda</p>
                <p class="text-5xl font-extrabold mb-4" style="color:#00b4d8;">{{ rtrim(rtrim(number_format($submission->estimated_band_score, 1), '0'), '.') }}<span class="text-lg text-gray-400 font-medium">/90</span></p>
            @endif

            <p class="text-gray-600 mb-6 leading-relaxed">
                Jawaban Anda telah kami terima. Tim Target Bahasa akan menghubungi Anda melalui WhatsApp atau email untuk membahas hasil lengkap dan rekomendasi persiapan PTE Academic Anda.
            </p>
            <a href="{{ url('/brochure/online') }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-6 py-3 font-bold rounded-full shadow text-white hover:opacity-90 transition" style="background-color:#00b4d8;">
                Lihat Program PTE Academic
            </a>
            <div class="mt-4 text-xs text-gray-500 text-center">
                <p class="text-green-600 font-bold text-sm">WhatsApp 0857 0661 5607</p>
            </div>
        </div>
    </div>
</body>
</html>
