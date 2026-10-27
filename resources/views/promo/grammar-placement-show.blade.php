<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tes Penempatan Grammar - Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 min-h-screen py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <img src="{{ asset('images/brand/icon.png') }}" alt="Target Bahasa" class="w-14 h-14 mx-auto mb-3 rounded-2xl shadow-sm">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Tes Penempatan Grammar</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $package->title }}</p>
            @if($package->description)
                <p class="text-sm text-gray-400 mt-1">{{ $package->description }}</p>
            @endif
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                <ul class="list-disc list-inside text-sm">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @if($questions->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center text-gray-400">
                Tes ini belum memiliki soal. Silakan hubungi admin.
            </div>
        @else
            <form method="POST" action="{{ route('promo.test.grammar-placement.submit', $package) }}" class="space-y-6">
                @csrf

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wide">Data Kamu</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="student_name" value="{{ old('student_name') }}" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Nama kamu">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="student_phone" value="{{ old('student_phone') }}" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Soal ({{ $questions->count() }})</h2>
                    @foreach($questions as $i => $q)
                        <div class="pb-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                            <p class="font-semibold text-gray-900 mb-3">{{ $i + 1 }}. {{ $q->question_text }}</p>
                            <div class="space-y-2">
                                @foreach(['a' => $q->option_a, 'b' => $q->option_b, 'c' => $q->option_c, 'd' => $q->option_d] as $letter => $optionText)
                                    <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="{{ $letter }}" required class="mt-0.5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="text-sm text-gray-700"><span class="font-semibold uppercase mr-1">{{ $letter }}.</span>{{ $optionText }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <x-turnstile />
                </div>

                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-sm">
                    Selesai &amp; Lihat Hasil
                </button>
            </form>
        @endif

        <p class="text-center text-xs text-gray-400 mt-6">
            Target Bahasa &middot; <a href="https://targetbahasa.com" class="underline hover:text-gray-600">targetbahasa.com</a>
        </p>
    </div>
</body>
</html>
