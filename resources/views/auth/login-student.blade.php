<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Target Bahasa') }} - Student Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">


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
    @php
        $tb_auth_login_student_title = \App\Models\Setting::where('key', 'auth_login_student_title')->value('value') ?? 'Welcome Back!';
        $tb_auth_login_student_subtitle = \App\Models\Setting::where('key', 'auth_login_student_subtitle')->value('value') ?? 'Please sign in to your student account.';
        $tb_auth_login_student_brand_title = \App\Models\Setting::where('key', 'auth_login_student_brand_title')->value('value') ?? 'Target Bahasa';
        $tb_auth_login_student_brand_desc = \App\Models\Setting::where('key', 'auth_login_student_brand_desc')->value('value') ?? 'Your journey to mastering the language starts here. Log in to access your dashboard, track progress, and continue learning.';
    @endphp
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
                <img src="{{ asset('images/brand/TARGET.png') }}" alt="{{ $tb_auth_login_student_brand_title }}" class="mb-8 w-[400px] max-w-[80%] max-h-[40vh] object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-500">
                
                <p class="text-blue-100 text-lg max-w-md mx-auto font-medium leading-relaxed drop-shadow-sm">
                    {{ $tb_auth_login_student_brand_desc }}
                </p>

                <!-- Floating Stats/Badges for visual interest -->
                <div class="mt-12 flex gap-4">
                    <div class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/10 rounded-full text-sm font-semibold hover:bg-white/20 transition-colors duration-300">
                        🎓 Expert Teachers
                    </div>
                    <div class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/10 rounded-full text-sm font-semibold hover:bg-white/20 transition-colors duration-300">
                        📈 Track Progress
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
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $tb_auth_login_student_title }}</h2>
                    <p class="text-gray-500 text-sm">{{ $tb_auth_login_student_subtitle }}</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Flash Messages -->
                @if (session('error'))
                    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-600 flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif
                @if (session('message'))
                    <div class="mb-4 p-4 rounded-xl bg-blue-50 border border-blue-200 text-sm text-blue-600 flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>{{ session('message') }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
                                placeholder="student@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Password -->
                    <div class="group relative">
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700 transition-colors group-focus-within:text-blue-600">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline transition-all">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" 
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer transition-all">
                        <label for="remember_me" class="ml-2 text-sm font-medium text-gray-600 cursor-pointer select-none">Remember me for 30 days</label>
                    </div>

                    <x-turnstile />
                    <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2 text-sm text-red-500 text-center" />

                    <!-- Submit Button -->
                    <button type="submit" class="w-full relative py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300 group overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Sign In to Dashboard
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        <!-- Glossy effect -->
                        <div class="absolute top-0 -inset-full h-full w-1/2 z-0 block transform -skew-x-12 bg-gradient-to-r from-transparent to-white opacity-20 group-hover:animate-shine"></div>
                    </button>
                    
                    <!-- Register Link -->
                    <p class="text-center text-sm text-gray-600 mt-8">
                        Don't have an account? 
                        <a href="{{ route('student.register') }}" class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-all">
                            Register now
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
