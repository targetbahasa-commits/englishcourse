<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Target Bahasa Course') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS (via CDN for standalone welcome page or you can use your compiled one) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .dark .glass-panel {
            background: rgba(30, 41, 59, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        
        .animated-bg {
            background: linear-gradient(-45deg, #1e3a8a, #4f46e5, #312e81, #0f172a);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="animated-bg min-h-screen flex flex-col items-center justify-center p-4 sm:p-8 text-gray-800 dark:text-gray-100 antialiased selection:bg-indigo-500 selection:text-white" x-data="{ copied: false, link: '{{ url()->current() }}' }">
    @include('components.impersonation-banner')

    <div class="max-w-6xl w-full grid md:grid-cols-2 gap-12 items-center lg:gap-20">
        
        <!-- Left Side: Copy & Branding -->
        <div class="text-center md:text-left space-y-8 z-10">
            <div class="inline-flex items-center justify-center p-4 bg-white/10 rounded-2xl backdrop-blur-md mb-2 shadow-2xl ring-1 ring-white/20">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-white drop-shadow-lg leading-tight">
                Master English <br class="hidden sm:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300">With Target.</span>
            </h1>
            
            <p class="text-xl text-indigo-100/90 hidden md:block max-w-lg leading-relaxed font-light drop-shadow">
                Elevate your language skills with our premium comprehensive Cambridge & TOEFL preparation courses. Join our learning community today.
            </p>
        </div>

        <!-- Right Side: Login Panel -->
        <div class="glass-panel p-8 md:p-10 rounded-[2.5rem] relative overflow-hidden transform transition-all hover:scale-[1.01] duration-500">
            <!-- Decorative circle -->
            <div class="absolute -top-32 -right-32 w-64 h-64 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full blur-[80px] opacity-60"></div>
            <div class="absolute -bottom-32 -left-32 w-64 h-64 bg-gradient-to-tr from-pink-500 to-rose-500 rounded-full blur-[80px] opacity-40"></div>
            
            <div class="relative z-10 space-y-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Access Portal</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-2 font-medium">Please select your designated role to continue</p>
                </div>

                    <!-- Admin section was deliberately removed to hide it from public view -->

                    <!-- Teacher -->
                    <div x-data="{ teacherCopied: false }" class="group relative px-6 py-5 bg-white/60 dark:bg-gray-800/60 rounded-2xl border border-white/50 dark:border-gray-700/50 hover:bg-white dark:hover:bg-gray-800 transition-all duration-300 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-gradient-to-br from-indigo-100 to-blue-100 dark:from-indigo-500/20 dark:to-blue-500/20 rounded-xl text-indigo-600 dark:text-indigo-400 shadow-inner">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Instructor</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Class & curriculum management</p>
                                </div>
                            </div>
                            <!-- Copy Link Button for Teacher -->
                            <button @click="navigator.clipboard.writeText('{{ route('teacher.login') }}'); teacherCopied = true; setTimeout(() => teacherCopied = false, 2000)" 
                                    class="p-2 text-indigo-500 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-800/50 rounded-lg transition-colors" 
                                    title="Copy Teacher Login Link">
                                <svg x-show="!teacherCopied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <svg x-cloak x-show="teacherCopied" class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('teacher.login') }}" class="w-full flex justify-center py-2.5 px-4 rounded-xl shadow-sm text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform active:scale-95">
                                Sign In
                            </a>
                        </div>
                    </div>

                    <!-- Student -->
                    <div x-data="{ studentCopied: false }" class="group relative px-6 py-5 bg-white/60 dark:bg-gray-800/60 rounded-2xl border border-white/50 dark:border-gray-700/50 hover:bg-white dark:hover:bg-gray-800 transition-all duration-300 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-500/20 dark:to-teal-500/20 rounded-xl text-emerald-600 dark:text-emerald-400 shadow-inner">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Student</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Access courses & materials</p>
                                </div>
                            </div>
                            <!-- Copy Link Button for Student -->
                            <button @click="navigator.clipboard.writeText('{{ route('student.login') }}'); studentCopied = true; setTimeout(() => studentCopied = false, 2000)" 
                                    class="p-2 text-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 hover:bg-emerald-100 dark:hover:bg-emerald-800/50 rounded-lg transition-colors" 
                                    title="Copy Student Login Link">
                                <svg x-show="!studentCopied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <svg x-cloak x-show="studentCopied" class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('student.login') }}" class="w-full flex justify-center py-2.5 px-4 rounded-xl shadow-sm text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform active:scale-95">
                                Sign In
                            </a>
                            <a href="{{ route('student.register') }}" class="w-full flex justify-center py-2.5 px-4 border-2 border-emerald-100 dark:border-gray-600 rounded-xl shadow-sm text-sm font-bold text-emerald-700 dark:text-gray-200 bg-white/50 dark:bg-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform active:scale-95">
                                Register
                            </a>
                        </div>
                    </div>

                    <!-- Guest -->
                    <div x-data="{ guestCopied: false }" class="group relative px-6 py-5 bg-white/60 dark:bg-gray-800/60 rounded-2xl border border-white/50 dark:border-gray-700/50 hover:bg-white dark:hover:bg-gray-800 transition-all duration-300 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-gradient-to-br from-amber-100 to-yellow-100 dark:from-amber-500/20 dark:to-yellow-500/20 rounded-xl text-amber-600 dark:text-amber-400 shadow-inner">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Guest Role</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">View access</p>
                                </div>
                            </div>
                            <!-- Copy Link Button for Guest -->
                            <button @click="navigator.clipboard.writeText('{{ route('guest.login') }}'); guestCopied = true; setTimeout(() => guestCopied = false, 2000)" 
                                    class="p-2 text-amber-500 bg-amber-50 dark:bg-amber-900/30 hover:bg-amber-100 dark:hover:bg-amber-800/50 rounded-lg transition-colors" 
                                    title="Copy Guest Login Link">
                                <svg x-show="!guestCopied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <svg x-cloak x-show="guestCopied" class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('guest.login') }}" class="w-full flex justify-center py-2.5 px-4 rounded-xl shadow-sm text-sm font-bold text-white bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all transform active:scale-95">
                                Sign In
                            </a>
                            <a href="{{ route('login') }}" class="w-full flex justify-center py-2.5 px-4 border-2 border-amber-100 dark:border-gray-600 rounded-xl shadow-sm text-sm font-bold text-amber-700 dark:text-gray-200 bg-white/50 dark:bg-gray-700 hover:bg-amber-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all transform active:scale-95">
                                Register
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
