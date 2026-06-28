<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Target Bahasa') }} - Guest Registration</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Daftar Akun Guest Gratis</h2>
        <form method="POST" action="{{ route('guest.register.submit') }}" class="space-y-6">
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
                <input type="text" name="name" id="name" required class="block w-full py-3 px-4 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500" placeholder="Nama Lengkap" value="{{ old('name') }}">
            </div>
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Aktif</label>
                <input type="email" name="email" id="email" required class="block w-full py-3 px-4 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500" placeholder="nama@email.com" value="{{ old('email') }}">
            </div>
            <div>
                <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                <input type="tel" name="phone_number" id="phone_number" required class="block w-full py-3 px-4 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500" placeholder="08123456789" value="{{ old('phone_number') }}">
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">Daftar & Dapatkan Akses Semua Tes</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
