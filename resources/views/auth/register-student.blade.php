<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Target Bahasa') }} - Student Registration</title>
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
            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30 transform hover:scale-105 transition-transform duration-500">
                <span class="text-2xl font-black text-white">TB</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-3 tracking-tight text-gray-900">Create Account ✨</h1>
            <p class="text-gray-600 text-sm sm:text-base mx-auto font-medium leading-relaxed max-w-md">
                Start your language mastery journey today. Please fill in your details to register as a student.
            </p>
        </div>

        <!-- Registration Form -->
        <div class="p-8 sm:p-10 text-left">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="student">

                <input type="hidden" name="referral_code" value="{{ request()->query('ref') }}">

                <!-- Name -->
                <div class="group relative">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Full Name <span class="text-red-500">*</span></label>
                    <div class="relative flex items-center">
                        <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" 
                            class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                            placeholder="Ahmad Wijaya">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Email Address -->
                <div class="group relative">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Email Address <span class="text-red-500">*</span></label>
                    <div class="relative flex items-center">
                        <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                            class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                            placeholder="student@example.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- WhatsApp Number & OTP -->
                <div class="group relative">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-green-600">WhatsApp Number <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <div class="relative flex-1 flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-green-600 transition-colors">
                                <!-- Phone Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel" 
                                class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-green-600/10 focus:border-green-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                                placeholder="081234567890" oninput="resetOtpState()">
                        </div>
                        <button type="button" id="btn-send-otp" onclick="sendOtp()" class="px-4 py-3 bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 font-semibold rounded-xl transition-all duration-300 whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                            Send OTP
                        </button>
                    </div>
                    <p id="otp-message" class="mt-2 text-sm hidden"></p>
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- OTP Input (Hidden initially) -->
                <div id="otp-container" class="group relative hidden">
                    <label for="otp_code" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Enter OTP Code <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <div class="relative flex-1 flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="otp_code" type="text" maxlength="6"
                                class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm tracking-widest text-center" 
                                placeholder="------">
                        </div>
                        <button type="button" id="btn-verify-otp" onclick="verifyOtp()" class="px-6 py-3 bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 font-semibold rounded-xl transition-all duration-300 whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                            Verify
                        </button>
                    </div>
                    <p id="otp-verify-message" class="mt-2 text-sm hidden"></p>
                </div>
                <!-- Hidden input to track verification status for form submission -->
                <input type="hidden" id="is_phone_verified" value="false">

                <!-- Passwords -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="group relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Password <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password" 
                                class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <div class="group relative">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Confirm <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                                class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>



                <!-- Submit Button -->
                <button type="submit" id="btn-submit-register" disabled class="w-full relative py-3.5 mt-2 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Create Account (Verify Phone First)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </button>
                
                <!-- Login Link -->
                <p class="text-center text-sm text-gray-600 mt-6 pb-2">
                    Already have an account? 
                    <a href="{{ route('student.login') }}" class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-all">
                        Sign in here
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- OTP Logic Script -->
    <script>
        let countdownInterval;

        function showMessage(elementId, text, isError = false) {
            const el = document.getElementById(elementId);
            el.textContent = text;
            el.className = 'mt-2 text-sm block ' + (isError ? 'text-red-500' : 'text-green-600');
        }

        function resetOtpState() {
            document.getElementById('otp-container').classList.add('hidden');
            document.getElementById('is_phone_verified').value = 'false';
            
            const submitBtn = document.getElementById('btn-submit-register');
            submitBtn.disabled = true;
            submitBtn.querySelector('span').innerHTML = 'Create Account (Verify Phone First) <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
            
            const sendBtn = document.getElementById('btn-send-otp');
            sendBtn.disabled = false;
            sendBtn.textContent = 'Send OTP';
            clearInterval(countdownInterval);
            document.getElementById('otp-message').classList.add('hidden');
            document.getElementById('otp-verify-message').classList.add('hidden');
        }

        async function sendOtp() {
            const phone = document.getElementById('phone_number').value;
            if (!phone || phone.length < 9) {
                showMessage('otp-message', 'Please enter a valid WhatsApp number.', true);
                return;
            }

            const btn = document.getElementById('btn-send-otp');
            btn.disabled = true;
            btn.textContent = 'Sending...';

            try {
                const response = await fetch('{{ route("otp.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ phone_number: phone })
                });

                const data = await response.json();

                if (response.ok) {
                    showMessage('otp-message', data.message);
                    document.getElementById('otp-container').classList.remove('hidden');
                    startCountdown(60); // 60 seconds cooldown
                } else {
                    showMessage('otp-message', data.message || 'Error sending OTP.', true);
                    btn.disabled = false;
                    btn.textContent = 'Send OTP';
                }
            } catch (error) {
                showMessage('otp-message', 'Network error. Please try again.', true);
                btn.disabled = false;
                btn.textContent = 'Send OTP';
            }
        }

        function startCountdown(seconds) {
            const btn = document.getElementById('btn-send-otp');
            let timeLeft = seconds;
            
            clearInterval(countdownInterval);
            btn.disabled = true;
            
            countdownInterval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    btn.disabled = false;
                    btn.textContent = 'Resend OTP';
                } else {
                    btn.textContent = `Resend (${timeLeft}s)`;
                    timeLeft -= 1;
                }
            }, 1000);
        }

        async function verifyOtp() {
            const phone = document.getElementById('phone_number').value;
            const code = document.getElementById('otp_code').value;
            
            if (!code || code.length !== 6) {
                showMessage('otp-verify-message', 'Please enter the 6-digit OTP.', true);
                return;
            }

            const btn = document.getElementById('btn-verify-otp');
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Verifying...';

            try {
                const response = await fetch('{{ route("otp.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ phone_number: phone, otp_code: code })
                });

                const data = await response.json();

                if (response.ok) {
                    showMessage('otp-verify-message', 'Phone verified successfully! You can now create your account.');
                    
                    // Lock inputs
                    document.getElementById('phone_number').readOnly = true;
                    document.getElementById('phone_number').classList.add('bg-gray-100');
                    document.getElementById('otp_code').readOnly = true;
                    document.getElementById('otp_code').classList.add('bg-gray-100');
                    document.getElementById('btn-send-otp').classList.add('hidden');
                    btn.classList.add('hidden');
                    
                    document.getElementById('is_phone_verified').value = 'true';
                    
                    const submitBtn = document.getElementById('btn-submit-register');
                    submitBtn.disabled = false;
                    submitBtn.querySelector('span').innerHTML = 'Create Account <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
                    clearInterval(countdownInterval);
                } else {
                    showMessage('otp-verify-message', data.message || 'Invalid OTP.', true);
                    btn.disabled = false;
                    btn.textContent = originalText;
                }
            } catch (error) {
                showMessage('otp-verify-message', 'Network error. Please try again.', true);
                btn.disabled = false;
                btn.textContent = originalText;
            }
        }
    </script>

    <!-- Canvas Animation Script -->
    <script>
        const canvas = document.getElementById('particleCanvas');
        const ctx = canvas.getContext('2d');
        let width, height;
        
        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        const particles = [];
        const particleCount = window.innerWidth < 768 ? 200 : 400; // Less dense on mobile
        
        // Use an array of nice blues and purples
        const pColors = ['#3b82f6', '#60a5fa', '#2563eb', '#818cf8', '#c084fc', '#93c5fd', '#6366f1'];

        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: width/2 + (Math.random()-0.5)*10,
                y: height/2 + (Math.random()-0.5)*10,
                angle: Math.random() * Math.PI * 2,
                dist: Math.random() * Math.max(width, height), // Start distributed
                speed: (Math.random() * 0.005) + 0.002, // orbit speed
                outSpeed: Math.random() * 0.5 + 0.1,    // expansion speed
                size: Math.random() * 2 + 0.5,
                color: pColors[Math.floor(Math.random() * pColors.length)],
                life: Math.random() * 100
            });
        }

        function animate() {
            // Faint trailing effect for trails
            ctx.fillStyle = 'rgba(255, 255, 255, 0.4)';
            ctx.fillRect(0, 0, width, height);
            
            const cx = width / 2;
            const cy = height / 2;

            particles.forEach(p => {
                // Determine new distance and angle
                p.dist += p.outSpeed;
                p.angle += p.speed * (100 / (p.dist + 10)); // Faster near center
                
                p.x = cx + Math.cos(p.angle) * p.dist;
                p.y = cy + Math.sin(p.angle) * p.dist;

                // Draw
                ctx.beginPath();
                // Instead of plain circles, let's draw short lines pointing outward
                // To emulate the "dash" style from the screenshot
                const dashLen = p.size * 2;
                const endX = p.x + Math.cos(p.angle + Math.PI/2) * dashLen;
                const endY = p.y + Math.sin(p.angle + Math.PI/2) * dashLen;
                
                ctx.moveTo(p.x, p.y);
                ctx.lineTo(endX, endY);
                ctx.strokeStyle = p.color;
                ctx.lineWidth = p.size;
                ctx.lineCap = 'round';
                ctx.stroke();

                // Reset particle when far away
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
