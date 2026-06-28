<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Target Bahasa') }} - Tutors Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white min-h-screen relative flex items-center justify-center overflow-x-hidden p-6">

    <!-- Canvas Background (Full Screen) -->
    <canvas id="particleCanvas" class="fixed inset-0 z-0 opacity-70 border-r border-gray-100/50"></canvas>
    <div class="fixed inset-0 z-0 pointer-events-none bg-gradient-to-br from-white/90 via-white/50 to-white/90"></div>

    <!-- Centered Glassmorphism Container -->
    <div class="relative z-10 w-full max-w-xl bg-white/70 backdrop-blur-xl rounded-3xl border border-white/50 shadow-2xl overflow-hidden my-8">
        
        <!-- Header Section -->
        <div class="p-8 pb-0 text-center">
            <img src="{{ asset('images/brand/TARGET.png') }}" alt="Target Bahasa" class="max-w-[160px] w-auto object-contain mx-auto mb-6 drop-shadow-xl hover:scale-105 transition-transform duration-500">
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-3 tracking-tight text-gray-900">Tutors Portal</h1>
            <p class="text-gray-600 text-sm sm:text-base mx-auto font-medium leading-relaxed max-w-md">
                Secure access for tutors. Please log in to your account.
            </p>
        </div>

        <div class="p-8 sm:p-10 text-left">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div class="group relative">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-indigo-600">Email Address</label>
                    <div class="relative flex items-center">
                        <div class="absolute left-4 text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                            class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                            placeholder="tutor@example.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Password -->
                <div class="group relative">
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700 transition-colors group-focus-within:text-indigo-600">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 hover:underline transition-all">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="relative flex items-center">
                        <div class="absolute left-4 text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                            class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                            placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer transition-all">
                    <label for="remember_me" class="ml-2 text-sm font-medium text-gray-600 cursor-pointer select-none">Remember me for 30 days</label>
                </div>

                <!-- Turnstile -->
                <x-turnstile />
                <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2 text-sm text-red-500 text-center" />

                <!-- Submit Button -->
                <button type="submit" class="w-full relative py-3.5 mt-2 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Sign In to Dashboard
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </button>
            </form>
        </div>
    </div>

    <!-- Background Animation Script -->
    <script>
        const canvas = document.getElementById('particleCanvas');
        const ctx = canvas.getContext('2d');
        let width, height;
        let particles = [];
        
        // Colors from the registration page
        const pColors = ['#4f46e5', '#3b82f6', '#8b5cf6', '#0ea5e9'];

        function resize() {
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width;
            canvas.height = height;
        }
        window.addEventListener('resize', resize);
        resize();

        for (let i = 0; i < 40; i++) {
            particles.push({
                x: Math.random() * width,
                y: Math.random() * height,
                angle: Math.random() * Math.PI * 2,
                dist: Math.random() * Math.max(width, height),
                speed: (Math.random() * 0.005) + 0.002,
                outSpeed: Math.random() * 0.5 + 0.1,
                size: Math.random() * 2 + 0.5,
                color: pColors[Math.floor(Math.random() * pColors.length)],
                life: Math.random() * 100
            });
        }

        function animate() {
            ctx.fillStyle = 'rgba(255, 255, 255, 0.4)';
            ctx.fillRect(0, 0, width, height);

            const cx = width / 2;
            const cy = height / 2;

            particles.forEach(p => {
                p.dist += p.outSpeed;
                p.angle += p.speed * (100 / (p.dist + 10));

                p.x = cx + Math.cos(p.angle) * p.dist;
                p.y = cy + Math.sin(p.angle) * p.dist;

                ctx.beginPath();
                const dashLen = p.size * 2;
                const endX = p.x + Math.cos(p.angle + Math.PI / 2) * dashLen;
                const endY = p.y + Math.sin(p.angle + Math.PI / 2) * dashLen;

                ctx.moveTo(p.x, p.y);
                ctx.lineTo(endX, endY);
                ctx.strokeStyle = p.color;
                ctx.lineWidth = p.size;
                ctx.lineCap = 'round';
                ctx.stroke();

                if (p.dist > Math.max(width, height)) {
                    p.dist = Math.random() * 10;
                    p.angle = Math.random() * Math.PI * 2;
                }
            });

            requestAnimationFrame(animate);
        }
        animate();
    </script>
</body>
</html>
