<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Target Bahasa') }} - Daftar Tes Kompetensi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">

<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl shadow-lg shadow-blue-500/30 mb-6 transform hover:scale-105 transition-transform">
                <span class="text-2xl font-bold text-white tracking-widest">TB</span>
            </a>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Sebelum Mulai</h2>
            <p class="mt-3 text-base text-gray-500">Isi data singkat di bawah ini untuk memulai Tes Kompetensi-mu.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-indigo-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>

            <form class="space-y-6 relative z-10" action="{{ route('placement-test.register.submit') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 rounded-xl p-4 text-sm font-medium border border-red-100">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required class="focus:ring-blue-500 focus:border-blue-500 block w-full py-3 px-4 sm:text-sm border-gray-300 rounded-xl" placeholder="Ahmad Rizky" value="{{ old('name') }}">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Aktif</label>
                    <input type="email" name="email" id="email" required class="focus:ring-blue-500 focus:border-blue-500 block w-full py-3 px-4 sm:text-sm border-gray-300 rounded-xl" placeholder="nama@email.com" value="{{ old('email') }}">
                    <p class="mt-1.5 text-xs text-gray-500">Hasil tes akan tersimpan di akun Anda.</p>
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium sm:text-sm">+62</span>
                        </div>
                        <input type="tel" name="phone_number" id="phone_number" required class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 py-3 sm:text-sm border-gray-300 rounded-xl" placeholder="81234567890" value="{{ old('phone_number') }}">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors transform hover:-translate-y-0.5">
                        Lanjut & Mulai Tes <span class="ml-2">&rarr;</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
