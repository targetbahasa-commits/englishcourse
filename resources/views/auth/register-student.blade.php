<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Target Bahasa') }} - Student Registration</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-gray-900 bg-white min-h-screen relative flex items-center justify-center overflow-x-hidden p-6">

    <!-- Canvas Background (Full Screen) -->
    <canvas id="particleCanvas" class="fixed inset-0 z-0 opacity-70 border-r border-gray-100/50"></canvas>
    <div class="fixed inset-0 z-0 pointer-events-none bg-gradient-to-br from-white/90 via-white/50 to-white/90"></div>

    <!-- Centered Glassmorphism Container -->
    <div
        class="relative z-10 w-full max-w-xl bg-white/70 backdrop-blur-xl rounded-3xl border border-white/50 shadow-2xl overflow-hidden my-8">

        <!-- Header Section -->
        @php
            $tb_auth_register_student_title = \App\Models\Setting::where('key', 'auth_register_student_title')->value('value') ?? 'Buat Akun Student';
            $tb_auth_register_student_subtitle = \App\Models\Setting::where('key', 'auth_register_student_subtitle')->value('value') ?? 'Daftarkan dirimu untuk mengakses kelas dan memulai perjalanan belajar bahasa Inggris.';

            $tb_auth_register_step2_title = \App\Models\Setting::where('key', 'auth_register_step2_title')->value('value') ?? 'Pilih Kelas';
            $tb_auth_register_step2_title_skip_payment = \App\Models\Setting::where('key', 'auth_register_step2_title_skip_payment')->value('value') ?? 'Pilih Kelas & Selesaikan';
            $tb_auth_register_step2_subtitle = \App\Models\Setting::where('key', 'auth_register_step2_subtitle')->value('value') ?? 'Pilih program utama yang ingin kamu ikuti.';
            $tb_auth_register_step2_subtitle_skip_payment = \App\Models\Setting::where('key', 'auth_register_step2_subtitle_skip_payment')->value('value') ?? 'Pilih program utama yang ingin kamu ikuti, lalu langsung buat akun.';

            $tb_auth_register_step3_title = \App\Models\Setting::where('key', 'auth_register_step3_title')->value('value') ?? 'Tahap Pembayaran';
            $tb_auth_register_step3_subtitle = \App\Models\Setting::where('key', 'auth_register_step3_subtitle')->value('value') ?? 'Pilih metode pembayaran yang akan kamu gunakan.';
        @endphp
        <div class="p-8 pb-0 text-center">
            <div class="flex items-center justify-center mx-auto mb-6 transform hover:scale-105 transition-transform duration-500">
                <img src="{{ asset('images/brand/TARGET.png') }}" alt="Target Bahasa" class="h-16 w-auto object-contain">
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-3 tracking-tight text-gray-900">
                {{ $tb_auth_register_student_title }}</h1>
            <p class="text-gray-600 text-sm sm:text-base mx-auto font-medium leading-relaxed max-w-md">
                {{ !empty($skipPaymentFlow) ? 'Daftarkan dirimu untuk mengakses kelas tanpa melalui tahap pembayaran.' : $tb_auth_register_student_subtitle }}
            </p>
            <div class="mt-5 flex items-center justify-center gap-3 text-xs font-semibold tracking-wide uppercase">
                <span id="step-indicator-1" class="px-3 py-1 rounded-full bg-blue-600 text-white font-medium">Tahap 1:
                    Data Akun</span>
                <span id="step-indicator-2"
                    class="px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">{{ !empty($skipPaymentFlow) ? 'Tahap 2: Selesai' : 'Tahap 2: Pilih Kelas' }}</span>
                @if(empty($skipPaymentFlow))
                    <span id="step-indicator-3"
                        class="px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">Tahap 3:
                        Pembayaran</span>
                @endif
            </div>
            @if(request('program'))
                <div
                    class="mt-4 mx-auto max-w-md px-4 py-2 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-700 font-medium">
                    🎯 Program yang kamu pilih: <strong>{{ request('program') }}</strong>
                </div>
            @endif
        </div>

        <!-- Registration Form -->
        <div class="p-8 sm:p-10 text-left">
            <form method="POST"
                action="{{ !empty($skipPaymentFlow) ? route('student.register.no-payment') : route('register') }}"
                enctype="multipart/form-data" class="space-y-5" id="register-form" novalidate>
                @csrf
                <input type="hidden" name="role" value="student">
                <x-marketing-attribution />

                @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <input type="hidden" name="referral_code" value="{{ request()->query('ref') }}">
                <input type="hidden" name="partner_code" value="{{ $partner->registration_code ?? '' }}">

                @if(!empty($partner))
                    <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                        Mendaftar sebagai karyawan <strong>{{ $partner->name }}</strong>.
                    </div>
                @endif

                <input type="hidden" id="program_choice" name="program_choice"
                    value="{{ old('program_choice', $preselectedProgramSlug ?? '') }}">
                <input type="hidden" id="payment_channel_choice" name="payment_channel_choice"
                    value="{{ old('payment_channel_choice', 'bank_transfer') }}">
                <input type="hidden" name="skip_payment_flow" value="{{ !empty($skipPaymentFlow) ? '1' : '0' }}">
                <input type="hidden" name="city" value="{{ request('city') }}">

                <div id="student-step-1" class="space-y-5">
                    <!-- Name -->
                    <div class="group relative">
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Full
                            Name <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <div
                                class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name', request('name')) }}" required
                                autocomplete="name"
                                class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm"
                                placeholder="Ahmad Wijaya">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Email Address -->
                    <div class="group relative">
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Email
                            Address <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <div
                                class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="username"
                                class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm"
                                placeholder="student@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- WhatsApp Number & OTP -->
                    <div class="group relative">
                        <label for="phone_number"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-green-600">WhatsApp
                            Number <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <div class="relative flex-1 flex items-center">
                                <div
                                    class="absolute left-4 text-gray-400 group-focus-within:text-green-600 transition-colors">
                                    <!-- Phone Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <input id="phone_number" type="tel" name="phone_number"
                                    value="{{ old('phone_number', request('phone_number')) }}" autocomplete="tel"
                                    class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-green-600/10 focus:border-green-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm"
                                    placeholder="081234567890">
                            </div>
                            {{-- OTP button hidden temporarily --}}
                            {{-- <button type="button" id="btn-send-otp" onclick="sendOtp()" ...>Send OTP</button> --}}
                        </div>
                        <p id="otp-message" class="mt-2 text-sm hidden"></p>
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-sm text-red-500" />
                    </div>

                    {{-- OTP input hidden temporarily --}}
                    {{-- <div id="otp-container" class="group relative hidden">...</div> --}}
                    <input type="hidden" id="is_phone_verified" value="true">

                    <!-- Passwords -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="group relative">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Password
                                <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <div
                                    class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password" required
                                    autocomplete="new-password"
                                    class="w-full pl-11 pr-12 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm"
                                    placeholder="••••••••">
                                <button type="button" id="togglePassword" class="absolute right-4 text-gray-400 hover:text-blue-600 focus:outline-none transition-colors" tabindex="-1">
                                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                        </div>

                        <div class="group relative">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Confirm
                                <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <div
                                    class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    autocomplete="new-password"
                                    class="w-full pl-11 pr-12 py-3 bg-white/90 backdrop-blur border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 transition-all duration-300 outline-none placeholder-gray-400 shadow-sm"
                                    placeholder="••••••••">
                                <button type="button" id="togglePasswordConf" class="absolute right-4 text-gray-400 hover:text-blue-600 focus:outline-none transition-colors" tabindex="-1">
                                    <svg id="eyeIconConf" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeSlashIconConf" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <x-turnstile />
                    <x-input-error :messages="$errors->get('cf-turnstile-response')"
                        class="mt-2 text-sm text-red-500 text-center" />

                    @include('components.password-rules')
                </div>

                <div id="student-step-2" class="hidden space-y-4">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ !empty($skipPaymentFlow) ? $tb_auth_register_step2_title_skip_payment : $tb_auth_register_step2_title }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ !empty($skipPaymentFlow) ? $tb_auth_register_step2_subtitle_skip_payment : $tb_auth_register_step2_subtitle }}
                        </p>
                    </div>

                    <div class="space-y-3">
                        @foreach($programs->groupBy('category') as $category => $categoryPrograms)
                            <details
                                class="group border border-gray-200 rounded-xl bg-white overflow-hidden [&_summary::-webkit-details-marker]:hidden"
                                {{ (collect($categoryPrograms)->contains('slug', old('program_choice', $preselectedProgramSlug))) ? 'open' : '' }}>
                                <summary
                                    class="flex justify-between items-center font-bold cursor-pointer list-none px-5 py-4 bg-gray-50 hover:bg-gray-100 transition text-gray-800">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v6M7 11h10">
                                            </path>
                                        </svg>
                                        {{ $category }}
                                    </span>
                                    <span
                                        class="transition group-open:rotate-180 bg-white border border-gray-200 rounded-full p-1 text-gray-500 shadow-sm">
                                        <svg fill="none" height="18" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="18">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </span>
                                </summary>
                                <div class="p-3 grid grid-cols-1 gap-2 border-t border-gray-200 bg-white/50">
                                    @foreach($categoryPrograms as $program)
                                        <button type="button" data-program="{{ $program->slug }}"
                                            class="program-choice-btn text-left rounded-lg border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                                            <p class="font-semibold text-gray-900">{{ $program->name }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($program->description ?? 'Fokus untuk meningkatkan skor bahasa Inggrismu.'), 100) }}
                                            </p>
                                        </button>
                                    @endforeach
                                </div>
                            </details>
                        @endforeach
                    </div>

                    <x-input-error :messages="$errors->get('program_choice')"
                        class="mt-2 text-sm text-red-500 text-center" />
                        
                    <div class="mt-5 space-y-3" id="class-type-container" style="display: none;">
                        <label class="block text-sm font-semibold text-gray-700">Pilih Jenis Kelas <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 gap-3">
                            <label class="relative flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition class-type-label">
                                <input type="radio" name="class_type" value="regular" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                <div class="ml-3">
                                    <span class="block text-sm font-semibold text-gray-900">Regular</span>
                                    <span class="block text-xs text-gray-500">Belajar bersama teman-teman lainnya.</span>
                                </div>
                            </label>
                            <label class="relative flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition class-type-label">
                                <input type="radio" name="class_type" value="semi_private" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <div class="ml-3">
                                    <span class="block text-sm font-semibold text-gray-900">Semi Private (2-4 orang)</span>
                                    <span class="block text-xs text-gray-500">Kelas lebih fokus dengan grup kecil.</span>
                                </div>
                            </label>
                            <label class="relative flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition class-type-label">
                                <input type="radio" name="class_type" value="private" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <div class="ml-3">
                                    <span class="block text-sm font-semibold text-gray-900">Private (1 orang)</span>
                                    <span class="block text-xs text-gray-500">Fokus penuh 1-on-1 dengan tutor.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                @if(empty($skipPaymentFlow))
                    <div id="student-step-3" class="hidden space-y-4">
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900">{{ $tb_auth_register_step3_title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $tb_auth_register_step3_subtitle }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            <button type="button" data-payment-channel="bank_transfer"
                                class="payment-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                                <p class="font-semibold text-gray-900">Transfer Bank</p>
                                <p class="text-sm text-gray-500">Upload bukti transfer lalu tunggu verifikasi admin.</p>
                            </button>

                            <button type="button" data-payment-channel="qris"
                                class="payment-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                                <p class="font-semibold text-gray-900">QRIS</p>
                                <p class="text-sm text-gray-500">Kirim lewat QRIS lalu upload bukti pembayaran.</p>
                            </button>

                            <button type="button" data-payment-channel="cash"
                                class="payment-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                                <p class="font-semibold text-gray-900">Cash (Bayar di kantor)</p>
                                <p class="text-sm text-gray-500">Buat invoice lalu lakukan pembayaran langsung di kantor.
                                </p>
                            </button>
                        </div>

                        <div id="bank-transfer-details" class="hidden pl-1 pr-1 pb-2">
                            <div
                                class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800 space-y-3 shadow-inner">
                                <div>
                                    <p class="font-semibold">Instruksi Pembayaran</p>
                                    <div id="transfer-instructions-bank" class="hidden">
                                        <div class="mb-3 pb-3 border-b border-blue-200">
                                            <span class="text-sm">Total Pembayaran</span>
                                            <div class="font-bold text-lg text-blue-700" id="total-payment-bank">Rp 0</div>
                                        </div>
                                        <p class="mt-1">Transfer sejumlah tagihan kelas ke rekening berikut:</p>
                                        <ul class="list-disc ml-5 mt-1 text-blue-900 font-medium">
                                            <li>Bank BCA: <strong>{{ setting('bank_account_number') ?: '1234567890' }}</strong>
                                            </li>
                                            <li>Atas Nama:
                                                <strong>{{ setting('bank_account_name') ?: 'Target Bahasa Course' }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="transfer-instructions-qris" class="hidden text-center">
                                        <div class="mb-3 pb-3 border-b border-blue-200">
                                            <span class="text-sm">Total Pembayaran</span>
                                            <div class="font-bold text-lg text-blue-700" id="total-payment-qris">Rp 0</div>
                                        </div>
                                        <p class="mt-1 mb-2">Silakan scan kode QRIS di bawah ini menggunakan aplikasi e-wallet atau m-banking Anda.</p>
                                        <img src="{{ asset('images/qris.jpeg') }}?v=1.1" alt="QRIS Code" class="w-48 max-w-full h-auto mx-auto border border-slate-200 rounded-lg shadow-sm">
                                        <a href="{{ asset('images/qris.jpeg') }}?v=1.1" download="qris_target_bahasa.jpeg" class="inline-flex items-center justify-center gap-2 mt-3 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1.5 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Download QRIS
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="block font-semibold mb-1">Upload Bukti Transfer
                                        <!-- <span class="text-xs font-normal text-gray-500">(Opsional)</span> --></label>
                                    <input type="file" name="proof_file" id="proof_file_input" accept=".jpg,.jpeg,.png,.pdf"
                                        class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-white hover:file:bg-blue-700">
                                    <p class="text-xs text-blue-600 mt-1">Format: JPG, PNG, PDF (Max 4MB)</p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-blue-200">
                                    <p class="text-xs text-blue-800 mb-3 font-medium">ATAU bisa juga kirim via WhatsApp ke
                                        admin:</p>
                                    @php
                                        $waNumber = setting('support_phone') ?: '6281234567890';
                                        $waMessage = urlencode("Halo Admin Target Bahasa, saya ingin konfirmasi pendaftaran dan mengirim bukti pembayaran.");
                                    @endphp
                                    <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank"
                                        class="inline-flex items-center justify-center rounded-xl bg-green-500 hover:bg-green-600 text-white text-sm font-bold px-4 py-3 transition w-full sm:w-auto shadow-sm">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.082 21.157c-1.551 0-3.053-.412-4.38-1.196l-4.945 1.306 1.325-4.815c-.86-1.378-1.314-2.973-1.314-4.636 0-4.869 3.96-8.829 8.829-8.829 4.869 0 8.829 3.96 8.829 8.829s-3.96 8.829-8.829 8.829z" />
                                        </svg>
                                        Kirim bukti transfer ke WA Admin (+{{ $waNumber }})
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div id="payment-info-text"
                            class="rounded-xl bg-blue-50 border border-blue-200 p-3 text-sm text-blue-700 mt-3 hidden">
                            Setelah akun dibuat, invoice akan otomatis dibuat.
                        </div>

                        <x-input-error :messages="$errors->get('payment_channel_choice')"
                            class="mt-2 text-sm text-red-500 text-center" />
                    </div>
                @endif

                <div class="flex items-center justify-between gap-3">
                    <button type="button" id="btn-step-back"
                        class="hidden w-full py-3 px-4 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                        ← Kembali
                    </button>

                    <button type="button" id="btn-step-next"
                        class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300">
                        {{ !empty($skipPaymentFlow) ? 'Lanjut Pilih Kelas →' : 'Lanjut Pilih Kelas →' }}
                    </button>

                    <!-- Submit Button -->
                    <button type="submit" id="btn-submit-register"
                        class="hidden w-full relative py-3.5 mt-2 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            {{ !empty($skipPaymentFlow) ? 'Create Account' : 'Create Account & Lanjut Pembayaran' }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <!-- Login Link -->
                <p class="text-center text-sm text-gray-600 mt-6 pb-2">
                    Already have an account?
                    <a href="{{ route('student.login') }}"
                        class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-all">
                        Sign in here
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- Admin Preview Panel -->
    @if(auth()->check() && auth()->user()->isAdmin())
        <div id="admin-preview-container" class="fixed top-4 right-4 z-50 flex flex-col items-end">
            <!-- Toggle Button -->
            <button type="button" onclick="document.getElementById('admin-preview-content').classList.toggle('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white shadow-lg rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wider flex items-center gap-2 transition-transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                    </path>
                </svg>
                Admin Preview
            </button>

            <!-- Panel Content -->
            <div id="admin-preview-content"
                class="mt-2 bg-white/95 backdrop-blur shadow-2xl rounded-xl border border-blue-200 p-5 w-72 text-sm hidden">
                <div class="font-bold text-gray-800 mb-2 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        Panel Preview
                    </span>
                    <span
                        class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">Admin</span>
                </div>
                <p class="text-xs text-gray-500 mb-4 leading-relaxed">Gunakan tombol di bawah ini untuk melompat antar tahap
                    (tanpa validasi form).</p>
                <div class="flex flex-col gap-2">
                    <button type="button" onclick="forceShowStep(1)"
                        class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-lg bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition border border-gray-200 hover:border-blue-200 font-medium">
                        Tahap 1: Data Akun
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <button type="button" onclick="forceShowStep(2)"
                        class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-lg bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition border border-gray-200 hover:border-blue-200 font-medium">
                        Tahap 2: Pilih Kelas
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    @if(empty($skipPaymentFlow))
                        <button type="button" onclick="forceShowStep(3)"
                            class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-lg bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition border border-gray-200 hover:border-blue-200 font-medium">
                            Tahap 3: Pembayaran
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-center">
                    <a href="{{ route('admin.settings.index', ['tab' => 'auth-pages-content']) }}"
                        class="text-xs text-blue-600 hover:text-blue-800 font-semibold hover:underline flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Edit Teks di Settings
                    </a>
                </div>
            </div>
        </div>

        <script>
            function forceShowStep(stepNumber) {
                const step1 = document.getElementById('student-step-1');
                const step2 = document.getElementById('student-step-2');
                const step3 = document.getElementById('student-step-3');
                const nextBtn = document.getElementById('btn-step-next');
                const backBtn = document.getElementById('btn-step-back');
                const submitBtn = document.getElementById('btn-submit-register');
                const skipPaymentFlow = {{ !empty($skipPaymentFlow) ? 'true' : 'false' }};

                const onStep2 = stepNumber === 2;
                const onStep3 = stepNumber === 3;
                const finalStep = skipPaymentFlow ? 2 : 3;

                if (step1) step1.classList.toggle('hidden', stepNumber !== 1);
                if (step2) step2.classList.toggle('hidden', !onStep2);
                if (step3) {
                    step3.classList.toggle('hidden', !onStep3);
                }
                if (nextBtn) nextBtn.classList.toggle('hidden', stepNumber === finalStep);
                if (backBtn) backBtn.classList.toggle('hidden', stepNumber === 1);
                if (submitBtn) submitBtn.classList.toggle('hidden', stepNumber !== finalStep);

                if (stepNumber === 1 && nextBtn) {
                    nextBtn.textContent = 'Lanjut Pilih Kelas →';
                } else if (nextBtn) {
                    nextBtn.textContent = skipPaymentFlow ? 'Selesaikan Pendaftaran →' : 'Lanjut Pembayaran →';
                }

                const ind1 = document.getElementById('step-indicator-1');
                const ind2 = document.getElementById('step-indicator-2');
                const ind3 = document.getElementById('step-indicator-3');

                if (ind1) ind1.className = stepNumber === 1
                    ? 'px-3 py-1 rounded-full bg-blue-600 text-white font-medium'
                    : 'px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200';
                if (ind2) ind2.className = stepNumber === 2
                    ? 'px-3 py-1 rounded-full bg-blue-600 text-white font-medium'
                    : 'px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200';
                if (ind3) {
                    ind3.className = stepNumber === 3
                        ? 'px-3 py-1 rounded-full bg-blue-600 text-white font-medium'
                        : 'px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200';
                }
            }
        </script>
    @endif

    <!-- OTP Logic Script -->
    <script>
        const programsData = @json($programs);

        (function () {
            const step1 = document.getElementById('student-step-1');
            const step2 = document.getElementById('student-step-2');
            const step3 = document.getElementById('student-step-3');
            const skipPaymentFlow = @json(!empty($skipPaymentFlow));
            const nextBtn = document.getElementById('btn-step-next');
            const backBtn = document.getElementById('btn-step-back');
            const submitBtn = document.getElementById('btn-submit-register');
            const programInput = document.getElementById('program_choice');
            const paymentChannelInput = document.getElementById('payment_channel_choice');
            const indicator1 = document.getElementById('step-indicator-1');
            const indicator2 = document.getElementById('step-indicator-2');
            const indicator3 = document.getElementById('step-indicator-3');
            const choiceButtons = document.querySelectorAll('.program-choice-btn');
            const paymentChoiceButtons = document.querySelectorAll('.payment-choice-btn');
            const form = step1.closest('form');
            const step1RequiredFieldIds = ['name', 'email', 'phone_number', 'password', 'password_confirmation'];

            if (!step1 || !step2 || !nextBtn || !backBtn || !submitBtn || !programInput || !paymentChannelInput) {
                return;
            }

            function markSelectedProgram() {
                let anySelected = false;
                choiceButtons.forEach((btn) => {
                    const isSelected = btn.getAttribute('data-program') === programInput.value;
                    if (isSelected) anySelected = true;
                    btn.classList.toggle('border-blue-500', isSelected);
                    btn.classList.toggle('bg-blue-50', isSelected);
                    btn.classList.toggle('ring-2', isSelected);
                    btn.classList.toggle('ring-blue-200', isSelected);
                });
                
                const classTypeContainer = document.getElementById('class-type-container');
                if (classTypeContainer) {
                    classTypeContainer.style.display = anySelected ? 'block' : 'none';
                }
                if (typeof updateTotalUI === 'function') updateTotalUI();
            }

            if (programInput.value) {
                markSelectedProgram();
            }
            if (paymentChannelInput.value) {
                markSelectedPaymentChannel();
            }
            
            const classTypeRadios = document.querySelectorAll('input[name="class_type"]');
            function updateClassTypeStyling() {
                classTypeRadios.forEach(radio => {
                    const label = radio.closest('.class-type-label');
                    if (radio.checked) {
                        label.classList.add('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-200');
                    } else {
                        label.classList.remove('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-200');
                    }
                });
                if (typeof updateTotalUI === 'function') updateTotalUI();
            }
            classTypeRadios.forEach(radio => {
                radio.addEventListener('change', updateClassTypeStyling);
            });
            updateClassTypeStyling();

            // Password Peek Feature
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function (e) {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    
                    if (type === 'text') {
                        eyeIcon.classList.add('hidden');
                        eyeSlashIcon.classList.remove('hidden');
                    } else {
                        eyeIcon.classList.remove('hidden');
                        eyeSlashIcon.classList.add('hidden');
                    }
                });
            }

            const togglePasswordConf = document.getElementById('togglePasswordConf');
            const passwordConf = document.getElementById('password_confirmation');
            const eyeIconConf = document.getElementById('eyeIconConf');
            const eyeSlashIconConf = document.getElementById('eyeSlashIconConf');

            if (togglePasswordConf && passwordConf) {
                togglePasswordConf.addEventListener('click', function (e) {
                    const type = passwordConf.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConf.setAttribute('type', type);
                    
                    if (type === 'text') {
                        eyeIconConf.classList.add('hidden');
                        eyeSlashIconConf.classList.remove('hidden');
                    } else {
                        eyeIconConf.classList.remove('hidden');
                        eyeSlashIconConf.classList.add('hidden');
                    }
                });
            }

            function calculateTotal() {
                if (!programInput.value) return 'Rp 0';
                
                const program = programsData.find(p => p.slug === programInput.value);
                if (!program) return 'Rp 0';
                
                let basePrice = program.price || 0;
                const classTypeRadio = document.querySelector('input[name="class_type"]:checked');
                const classType = classTypeRadio ? classTypeRadio.value : 'regular';
                
                if (classType === 'private') {
                    basePrice = program.price_private || basePrice;
                } else if (classType === 'semi_private') {
                    basePrice = program.price_semi_private || basePrice;
                }
                
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(basePrice);
            }

            function updateTotalUI() {
                const total = calculateTotal();
                const bankTotal = document.getElementById('total-payment-bank');
                const qrisTotal = document.getElementById('total-payment-qris');
                if (bankTotal) bankTotal.textContent = total;
                if (qrisTotal) qrisTotal.textContent = total;
            }

            function markSelectedPaymentChannel() {
                if (skipPaymentFlow) {
                    return;
                }

                updateTotalUI();

                paymentChoiceButtons.forEach((btn) => {
                    const isSelected = btn.getAttribute('data-payment-channel') === paymentChannelInput.value;
                    btn.classList.toggle('border-blue-500', isSelected);
                    btn.classList.toggle('bg-blue-50', isSelected);
                    btn.classList.toggle('ring-2', isSelected);
                    btn.classList.toggle('ring-blue-200', isSelected);
                });

                const bankDetails = document.getElementById('bank-transfer-details');
                const infoText = document.getElementById('payment-info-text');
                const submitBtnText = submitBtn ? submitBtn.querySelector('span') : null;

                if (bankDetails && infoText && submitBtnText) {
                    if (paymentChannelInput.value === 'bank_transfer' || paymentChannelInput.value === 'qris') {
                        bankDetails.classList.remove('hidden');
                        infoText.classList.add('hidden');
                        submitBtnText.innerHTML = `Selesaikan Pendaftaran <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                        
                        const instBank = document.getElementById('transfer-instructions-bank');
                        const instQris = document.getElementById('transfer-instructions-qris');
                        if (instBank && instQris) {
                            if (paymentChannelInput.value === 'bank_transfer') {
                                instBank.classList.remove('hidden');
                                instQris.classList.add('hidden');
                            } else {
                                instBank.classList.add('hidden');
                                instQris.classList.remove('hidden');
                            }
                        }
                    } else if (paymentChannelInput.value === 'cash') {
                        bankDetails.classList.add('hidden');
                        infoText.classList.remove('hidden');
                        submitBtnText.innerHTML = `Create Account & Lanjut Pembayaran <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>`;
                    }
                }
            }

            function validateStep1Fields() {
                for (const fieldId of step1RequiredFieldIds) {
                    const field = document.getElementById(fieldId);
                    if (!field) {
                        continue;
                    }

                    const value = (field.value || '').trim();
                    if (value === '') {
                        showStep(1);
                        field.focus();
                        alert('Lengkapi data akun pada Tahap 1 terlebih dahulu.');
                        return false;
                    }
                }

                const passwordField = document.getElementById('password');
                const passwordConfirmationField = document.getElementById('password_confirmation');
                if (passwordField && passwordConfirmationField && passwordField.value !== passwordConfirmationField.value) {
                    showStep(1);
                    passwordConfirmationField.focus();
                    alert('Konfirmasi password belum sama.');
                    return false;
                }

                return true;
            }

            function showStep(stepNumber) {
                const onStep2 = stepNumber === 2;
                const onStep3 = stepNumber === 3;
                const finalStep = skipPaymentFlow ? 2 : 3;

                step1.classList.toggle('hidden', stepNumber !== 1);
                step2.classList.toggle('hidden', !onStep2);
                if (step3) {
                    step3.classList.toggle('hidden', !onStep3);
                }
                nextBtn.classList.toggle('hidden', stepNumber === finalStep);
                backBtn.classList.toggle('hidden', stepNumber === 1);
                submitBtn.classList.toggle('hidden', stepNumber !== finalStep);

                if (stepNumber === 1) {
                    nextBtn.textContent = 'Lanjut Pilih Kelas →';
                } else {
                    nextBtn.textContent = skipPaymentFlow ? 'Selesaikan Pendaftaran →' : 'Lanjut Pembayaran →';
                }

                indicator1.className = stepNumber === 1
                    ? 'px-3 py-1 rounded-full bg-blue-600 text-white'
                    : 'px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200';
                indicator2.className = stepNumber === 2
                    ? 'px-3 py-1 rounded-full bg-blue-600 text-white'
                    : 'px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200';
                if (indicator3) {
                    indicator3.className = stepNumber === 3
                        ? 'px-3 py-1 rounded-full bg-blue-600 text-white'
                        : 'px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200';
                }

                if (onStep2) {
                    markSelectedProgram();
                }

                if (onStep3) {
                    markSelectedPaymentChannel();
                }
            }

            choiceButtons.forEach((btn) => {
                btn.addEventListener('click', function () {
                    programInput.value = this.getAttribute('data-program') || '';
                    markSelectedProgram();
                });
            });

            paymentChoiceButtons.forEach((btn) => {
                btn.addEventListener('click', function () {
                    paymentChannelInput.value = this.getAttribute('data-payment-channel') || 'bank_transfer';
                    markSelectedPaymentChannel();
                });
            });

            nextBtn.addEventListener('click', function () {
                if (!step1.classList.contains('hidden')) {
                    if (!validateStep1Fields()) {
                        return;
                    }

                    showStep(2);
                    return;
                }

                if (!programInput.value) {
                    alert('Silakan pilih kelas terlebih dahulu sebelum lanjut ke pembayaran.');
                    return;
                }

                if (skipPaymentFlow) {
                    submitBtn.focus();
                    return;
                }

                showStep(3);
            });

            backBtn.addEventListener('click', function () {
                if (!skipPaymentFlow && step3 && !step3.classList.contains('hidden')) {
                    showStep(2);
                    return;
                }

                showStep(1);
            });

            const hasStep1Errors = {{ ($errors->has('name') || $errors->has('email') || $errors->has('phone_number') || $errors->has('password') || $errors->has('password_confirmation') || $errors->has('cf-turnstile-response')) ? 'true' : 'false' }};
            const hasStep2Errors = {{ $errors->has('program_choice') ? 'true' : 'false' }};
            const hasStep3Errors = {{ $errors->has('payment_channel_choice') ? 'true' : 'false' }};

            const openStep = hasStep1Errors ? 1 : (hasStep2Errors ? 2 : ((!skipPaymentFlow && hasStep3Errors) ? 3 : 1));
            showStep(openStep);

            if (form) {
                form.addEventListener('submit', function (event) {
                    if (!validateStep1Fields()) {
                        event.preventDefault();
                        return;
                    }

                    if (!programInput.value) {
                        event.preventDefault();
                        showStep(2);
                        alert('Silakan pilih kelas pada Tahap 2.');
                        return;
                    }

                    if (!skipPaymentFlow && !paymentChannelInput.value) {
                        event.preventDefault();
                        showStep(3);
                        alert('Silakan pilih metode pembayaran pada Tahap 3.');
                    }
                });
            }
        })();
    </script>



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
                x: width / 2 + (Math.random() - 0.5) * 10,
                y: height / 2 + (Math.random() - 0.5) * 10,
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
                const endX = p.x + Math.cos(p.angle + Math.PI / 2) * dashLen;
                const endY = p.y + Math.sin(p.angle + Math.PI / 2) * dashLen;

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