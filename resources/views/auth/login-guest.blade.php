<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Target Bahasa') }} - Guest Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Add custom styles for the animations -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes shine {
            100% { left: 125%; }
        }
        .animate-shine {
            animation: shine 1s;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <!-- Background styling and layout -->
    <div class="min-h-screen w-full flex">
        
        <!-- Left Side: Interactive Branding / Image Section -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-blue-600">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-indigo-900 z-0"></div>
            
            <!-- Floating Elements Animation (Micro-interactions) -->
            <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob"></div>
            <div class="absolute top-40 right-10 w-32 h-32 bg-indigo-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-40 h-40 bg-purple-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-4000"></div>

            <!-- Content overlay -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full h-full p-12 text-white text-center">
                <!-- App Logo/Icon -->
                <img src="{{ asset('images/brand/TARGET.png') }}" alt="Target Bahasa" class="mb-8 w-[400px] max-w-[80%] max-h-[40vh] object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-500">
                
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight drop-shadow-md">Guest Access</h1>
                <p class="text-blue-100 text-lg max-w-md mx-auto font-medium leading-relaxed drop-shadow-sm">
                    Continue your learning journey. Check your test scores, vocabulary progress, and access free lessons.
                </p>

                <!-- Floating Stats/Badges for visual interest -->
                <div class="mt-12 flex flex-wrap justify-center gap-4">
                    <div class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/10 rounded-full text-sm font-semibold hover:bg-white/20 transition-colors duration-300">
                        🎧 Free Lessons
                    </div>
                    <div class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/10 rounded-full text-sm font-semibold hover:bg-white/20 transition-colors duration-300">
                        📊 Check Scores
                    </div>
                    <div class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/10 rounded-full text-sm font-semibold hover:bg-white/20 transition-colors duration-300">
                        🚀 Start Learning
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative">
            <!-- Mobile Logo (visible only on small screens) -->
            <div class="lg:hidden absolute top-8 left-8 flex items-center">
                <img src="{{ asset('images/brand/TARGET.png') }}" alt="Target Bahasa" class="h-10">
            </div>

            <div class="w-full max-w-md mt-16 lg:mt-0">
                <!-- Header -->
                <div class="mb-10 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-sm font-semibold mb-4 border border-blue-100">
                        Guest Access
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back!</h2>
                    <p class="text-gray-500 text-sm">Enter your email address to receive a secure, one-time login link.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-medium">{{ session('status') }}</p>
                    </div>
                @endif
                
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('guest.login.magic-link') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="group relative">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Email Address</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                                placeholder="guest@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer transition-all" checked>
                        <label for="remember_me" class="ml-2 text-sm font-medium text-gray-600 cursor-pointer select-none">Remember me for 30 days</label>
                    </div>

                    <x-turnstile />
                    <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2 text-sm text-red-500 text-center" />

                    <!-- Submit Button -->
                    <button type="submit" class="w-full relative py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300 group overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Send Login Link
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        <!-- Glossy effect -->
                        <div class="absolute top-0 -inset-full h-full w-1/2 z-0 block transform -skew-x-12 bg-gradient-to-r from-transparent to-white opacity-20 group-hover:animate-shine"></div>
                    </button>

                    <!-- SKIP NOW Button -->
                    <a href="{{ url('/guest/quick-access/ielts_academic') }}" class="w-full block mt-4 py-3.5 px-4 text-center bg-white border border-blue-200 text-blue-600 font-semibold rounded-xl shadow hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-100 active:scale-[0.98] transition-all duration-300">
                        SKIP NOW
                    </a>
                    <span class="block text-xs text-gray-400 mt-1 mb-2 text-center">Langsung masuk sebagai guest tanpa login. Akan diminta login saat mengambil tes.</span>
                    
                    <!-- Register Link -->
                    <p class="text-center text-sm text-gray-600 mt-8">
                        Don't have a guest account? 
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-all">
                            Register now
                        </a>
                    </p>

                    <!-- Are you a student? Link -->
                    <p class="text-center text-xs text-gray-500 mt-4 border-t border-gray-100 pt-4">
                        Are you a registered student? 
                        <a href="{{ route('student.login') }}" class="font-medium text-blue-600 hover:underline">
                            Student Login
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh CSRF token on back-forward cache or stale session tab
        window.addEventListener('pageshow', async function(event) {
            try {
                const res = await fetch('/csrf-token', { headers: { 'Accept': 'application/json' } });
                if (res.ok) {
                    const data = await res.json();
                    if (data.token) {
                        document.querySelectorAll('input[name="_token"]').forEach(input => input.value = data.token);
                        const meta = document.querySelector('meta[name="csrf-token"]');
                        if (meta) meta.content = data.token;
                    }
                }
            } catch(e) {}
        });
    </script>
</body>
</html>
