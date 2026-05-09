<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Target Bahasa') }} - Forgot Password</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const probe = document.createElement('div');
            probe.className = 'hidden';
            probe.style.position = 'absolute';
            probe.style.left = '-9999px';
            document.body.appendChild(probe);

            const isTailwindApplied = window.getComputedStyle(probe).display === 'none';
            probe.remove();

            if (!isTailwindApplied) {
                const fallback = document.createElement('script');
                fallback.src = 'https://cdn.tailwindcss.com';
                document.head.appendChild(fallback);
            }
        });
    </script>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 sm:p-12 relative bg-white rounded-3xl shadow-2xl border border-gray-100">
        <div class="mb-8 text-center">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-blue-600/20 mb-6 transform hover:rotate-6 transition-transform">
                <span class="text-2xl font-black text-white">TB</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Lupa Password?</h2>
            <p class="text-gray-500 text-sm leading-relaxed">Jangan khawatir! Masukkan alamat email Anda di bawah ini dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 text-sm font-medium border border-green-200" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="group relative">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-blue-600">Alamat Email</label>
                <div class="relative flex items-center">
                    <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 focus:bg-white transition-all duration-300 outline-none placeholder-gray-400 shadow-inner" 
                        placeholder="contoh@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full relative py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300 flex justify-center items-center gap-2">
                Kirim Link Reset Password
                <svg class="w-4 h-4 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
            
            <div class="text-center pt-2">
                <a href="{{ route('student.login') }}" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-gray-500 hover:text-blue-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>

</body>
</html>
