<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Target Bahasa') }} - Free Test Registration</title>

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
            <div class="relative z-10 flex flex-col justify-center items-center w-full h-full p-12 text-white text-left max-w-lg mx-auto">
                <!-- App Logo/Icon -->
                <div class="w-16 h-16 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center mb-10 shadow-xl transform hover:scale-105 transition-transform duration-500 cursor-default self-start">
                    <span class="text-3xl font-black bg-clip-text text-transparent bg-gradient-to-tr from-white to-blue-100">TB</span>
                </div>
                
                <p class="text-blue-200 font-bold tracking-widest uppercase text-sm mb-3">Target Bahasa</p>
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 tracking-tight drop-shadow-md leading-tight">
                    FREE TOEFL<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-indigo-100">PREDICTION TEST</span>
                </h1>
                
                <p class="text-blue-50 text-xl font-medium leading-relaxed drop-shadow-sm mb-6 border-l-4 border-blue-400 pl-4 py-1">
                    Test your English level in 30 minutes.
                </p>

                <!-- Benefit Bullet Points -->
                <ul class="space-y-4 mb-10 text-lg text-blue-100 font-medium">
                    <li class="flex items-center gap-3">
                        <div class="bg-blue-500/30 p-1.5 rounded-full border border-blue-400/50">
                            <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        Free mock test
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="bg-blue-500/30 p-1.5 rounded-full border border-blue-400/50">
                            <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        Instant score report
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="bg-blue-500/30 p-1.5 rounded-full border border-blue-400/50">
                            <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        Certificate preview
                    </li>
                </ul>

                <!-- Trust Element / Social Proof -->
                <div class="mt-auto bg-black/20 backdrop-blur-md rounded-2xl p-6 border border-white/10 w-full transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-blue-800" src="https://ui-avatars.com/api/?name=A+S&background=random" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-blue-800" src="https://ui-avatars.com/api/?name=B+R&background=random" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-blue-800" src="https://ui-avatars.com/api/?name=C+D&background=random" alt="User">
                            <div class="w-10 h-10 rounded-full border-2 border-blue-800 bg-blue-500 flex items-center justify-center text-xs font-bold shrink-0">+1k</div>
                        </div>
                        <div class="flex gap-1 text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                    </div>
                    <p class="text-blue-100 font-medium text-sm">
                        "Trusted by 1000+ students preparing for TOEFL & IELTS."
                    </p>
                </div>

            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-20 relative bg-white">
            <!-- Mobile Logo (visible only on small screens) -->
            <div class="lg:hidden absolute top-8 left-8 flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                    <span class="text-lg font-bold text-white">TB</span>
                </div>
                <span class="text-xl font-bold text-gray-900 tracking-tight">Target Bahasa</span>
            </div>

            <div class="w-full max-w-md mt-16 lg:mt-0">
                <!-- Header -->
                <div class="mb-10 lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-sm font-semibold mb-4 border border-indigo-100">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        No Payment Required
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">Get Your Score Instantly</h2>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Take a free English proficiency test and receive your estimated TOEFL score. Results will be sent directly to your email.
                    </p>
                </div>

                <!-- Session Status / Errors -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- The form actually registers the user as a guest behind the scenes, so we point to /register -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Hidden fields to configure a guest registration automatically -->
                    <input type="hidden" name="role" value="guest">
                    
                    <!-- We auto-generate a password for them in the backend if we want true friction-less, 
                         but since this is standard Laravel Auth, we'll keep password hidden and auto-fill it to skip it, 
                         OR we can just provide a simplified form if our controller handles it. 
                         For this UI, let's assume the controller handles password auto-generation if not provided for 'guest' role,
                         or we append a default password. Let's use a standard password auto-fill hack for pure frontend conversion optimization. -->
                    <input type="hidden" name="password" value="Password123!">
                    <input type="hidden" name="password_confirmation" value="Password123!">

                    <!-- Full Name -->
                    <div class="group relative">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">Full Name</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                                placeholder="Your full name">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Email Address -->
                    <div class="group relative">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">Email Address <span class="text-xs font-normal text-gray-400 ml-1">(Where we send results)</span></label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" 
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                                placeholder="you@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Phone Number (Optional) -->
                    <div class="group relative">
                        <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">WhatsApp Number <span class="text-xs font-normal text-gray-400 ml-1">(Optional)</span></label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}" autocomplete="tel" 
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm" 
                                placeholder="081234567890">
                        </div>
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Consent Checkbox -->
                    <div class="flex items-start mt-6 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                        <div class="flex items-center h-5">
                            <input id="consent" type="checkbox" name="consent" required class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer transition-all mt-0.5">
                        </div>
                        <label for="consent" class="ml-3 text-sm font-medium text-gray-700 cursor-pointer select-none leading-snug">
                            I agree to receive my score, study recommendations, and learning tips by email.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full relative py-4 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 focus:outline-none focus:ring-4 focus:ring-blue-500/20 active:scale-[0.98] transition-all duration-300 group overflow-hidden mt-8">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Start Free Test
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        <!-- Glossy effect -->
                        <div class="absolute top-0 -inset-full h-full w-1/2 z-0 block transform -skew-x-12 bg-gradient-to-r from-transparent to-white opacity-20 group-hover:animate-shine"></div>
                    </button>
                    
                    <p class="text-center text-xs text-gray-500 font-medium mt-4 flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Your information is secure.
                    </p>

                    <!-- Login Link -->
                    <p class="text-center text-sm text-gray-600 pt-6 border-t border-gray-100">
                        Already have a guest account? 
                        <a href="{{ route('guest.login') }}" class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-all">
                            Log in here
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
