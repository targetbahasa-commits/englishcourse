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
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-3 tracking-tight text-gray-900">Buat Akun Student</h1>
            <p class="text-gray-600 text-sm sm:text-base mx-auto font-medium leading-relaxed max-w-md">
                {{ !empty($skipPaymentFlow) ? 'Daftarkan dirimu untuk mengakses kelas tanpa melalui tahap pembayaran.' : 'Daftarkan dirimu untuk mengakses kelas dan memulai perjalanan belajar bahasa Inggris.' }}
            </p>
            <div class="mt-5 flex items-center justify-center gap-3 text-xs font-semibold tracking-wide uppercase">
                <span id="step-indicator-1" class="px-3 py-1 rounded-full bg-blue-600 text-white font-medium">Tahap 1: Data Akun</span>
                <span id="step-indicator-2" class="px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">{{ !empty($skipPaymentFlow) ? 'Tahap 2: Selesai' : 'Tahap 2: Pilih Kelas' }}</span>
                @if(empty($skipPaymentFlow))
                <span id="step-indicator-3" class="px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">Tahap 3: Pembayaran</span>
                @endif
            </div>
            @if(request('program'))
            <div class="mt-4 mx-auto max-w-md px-4 py-2 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-700 font-medium">
                🎯 Program yang kamu pilih: <strong>{{ request('program') }}</strong>
            </div>
            @endif
        </div>

        <!-- Registration Form -->
        <div class="p-8 sm:p-10 text-left">
            <form method="POST" action="{{ !empty($skipPaymentFlow) ? route('student.register.no-payment') : route('register') }}" class="space-y-5" novalidate>
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
                <input type="hidden" id="program_choice" name="program_choice" value="{{ old('program_choice', $preselectedProgramSlug ?? '') }}">
                <input type="hidden" id="payment_channel_choice" name="payment_channel_choice" value="{{ old('payment_channel_choice', 'bank_transfer') }}">
                <input type="hidden" name="skip_payment_flow" value="{{ !empty($skipPaymentFlow) ? '1' : '0' }}">
                <input type="hidden" name="city" value="{{ request('city') }}">

                <div id="student-step-1" class="space-y-5">
                <!-- Name -->
                <div class="group relative">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1 transition-colors group-focus-within:text-blue-600">Full Name <span class="text-red-500">*</span></label>
                    <div class="relative flex items-center">
                        <div class="absolute left-4 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name', request('name')) }}" required autocomplete="name" 
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
                            <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number', request('phone_number')) }}" autocomplete="tel" 
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



                <x-turnstile />
                <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2 text-sm text-red-500 text-center" />
                </div>

                <div id="student-step-2" class="hidden space-y-4">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900">{{ !empty($skipPaymentFlow) ? 'Pilih Kelas & Selesaikan' : 'Pilih Kelas' }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ !empty($skipPaymentFlow) ? 'Pilih program utama yang ingin kamu ikuti, lalu langsung buat akun.' : 'Pilih program utama yang ingin kamu ikuti.' }}</p>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <button type="button" data-program="ielts-academic" class="program-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                            <p class="font-semibold text-gray-900">IELTS Academic</p>
                            <p class="text-sm text-gray-500">Fokus untuk kebutuhan studi dan akademik.</p>
                        </button>

                        <button type="button" data-program="ielts-general" class="program-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                            <p class="font-semibold text-gray-900">IELTS General</p>
                            <p class="text-sm text-gray-500">Fokus untuk kebutuhan kerja dan migrasi.</p>
                        </button>

                        <button type="button" data-program="toefl-itp" class="program-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                            <p class="font-semibold text-gray-900">TOEFL ITP</p>
                            <p class="text-sm text-gray-500">Persiapan tes TOEFL ITP untuk kebutuhan institusional.</p>
                        </button>

                        <button type="button" data-program="pte-academic" class="program-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                            <p class="font-semibold text-gray-900">PTE Academic</p>
                            <p class="text-sm text-gray-500">Persiapan tes PTE berbasis komputer.</p>
                        </button>

                        <button type="button" data-program="grammar-for-writing" class="program-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                            <p class="font-semibold text-gray-900">Grammar for Writing</p>
                            <p class="text-sm text-gray-500">Fokus memperkuat grammar untuk writing akademik dan profesional.</p>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('program_choice')" class="mt-2 text-sm text-red-500 text-center" />
                </div>

                @if(empty($skipPaymentFlow))
                <div id="student-step-3" class="hidden space-y-4">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900">Tahap Pembayaran</h3>
                        <p class="text-sm text-gray-500 mt-1">Pilih metode pembayaran yang akan kamu gunakan.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <button type="button" data-payment-channel="bank_transfer" class="payment-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                            <p class="font-semibold text-gray-900">Transfer Bank</p>
                            <p class="text-sm text-gray-500">Upload bukti transfer lalu tunggu verifikasi admin.</p>
                        </button>

                        <button type="button" data-payment-channel="cash" class="payment-choice-btn text-left rounded-xl border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition">
                            <p class="font-semibold text-gray-900">Cash (Bayar di kantor)</p>
                            <p class="text-sm text-gray-500">Buat invoice lalu lakukan pembayaran langsung di kantor.</p>
                        </button>
                    </div>

                    <div class="rounded-xl bg-blue-50 border border-blue-200 p-3 text-sm text-blue-700">
                        Setelah akun dibuat, kamu akan langsung diarahkan ke halaman pembayaran untuk membuat invoice.
                    </div>

                    <x-input-error :messages="$errors->get('payment_channel_choice')" class="mt-2 text-sm text-red-500 text-center" />
                </div>
                @endif

                <div class="flex items-center justify-between gap-3">
                    <button type="button" id="btn-step-back" class="hidden w-full py-3 px-4 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                        ← Kembali
                    </button>

                    <button type="button" id="btn-step-next" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300">
                        {{ !empty($skipPaymentFlow) ? 'Lanjut Pilih Kelas →' : 'Lanjut Pilih Kelas →' }}
                    </button>

                <!-- Submit Button -->
                <button type="submit" id="btn-submit-register" class="hidden w-full relative py-3.5 mt-2 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 focus:outline-none focus:ring-4 focus:ring-blue-600/20 active:scale-[0.98] transition-all duration-300">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        {{ !empty($skipPaymentFlow) ? 'Create Account' : 'Create Account & Lanjut Pembayaran' }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </button>
                </div>
                
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
                choiceButtons.forEach((btn) => {
                    const isSelected = btn.getAttribute('data-program') === programInput.value;
                    btn.classList.toggle('border-blue-500', isSelected);
                    btn.classList.toggle('bg-blue-50', isSelected);
                    btn.classList.toggle('ring-2', isSelected);
                    btn.classList.toggle('ring-blue-200', isSelected);
                });
            }

            function markSelectedPaymentChannel() {
                if (skipPaymentFlow) {
                    return;
                }

                paymentChoiceButtons.forEach((btn) => {
                    const isSelected = btn.getAttribute('data-payment-channel') === paymentChannelInput.value;
                    btn.classList.toggle('border-blue-500', isSelected);
                    btn.classList.toggle('bg-blue-50', isSelected);
                    btn.classList.toggle('ring-2', isSelected);
                    btn.classList.toggle('ring-blue-200', isSelected);
                });
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
