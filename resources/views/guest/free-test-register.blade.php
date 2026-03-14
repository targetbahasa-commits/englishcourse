@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Brand / Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl shadow-lg shadow-blue-500/30 mb-6 transform hover:scale-105 transition-transform">
                <span class="text-2xl font-bold text-white tracking-widest">TB</span>
            </a>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Mulai Uji Kemampuanmu
            </h2>
            <p class="mt-3 text-base text-gray-500">
                Silakan isi data singkat di bawah ini untuk memulai <strong>{{ ucwords(str_replace('_', ' ', $type)) }} Free Test</strong>.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10 relative overflow-hidden">
            <!-- Decorative blur -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-indigo-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
            
            <form class="space-y-6 relative z-10" action="{{ route('free-test.register.submit', $type) }}" method="POST">
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
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <input type="text" name="name" id="name" required class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-3 sm:text-sm border-gray-300 rounded-xl" placeholder="Ahmad Rizky" value="{{ old('name') }}">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Aktif</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <input type="email" name="email" id="email" required class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-3 sm:text-sm border-gray-300 rounded-xl" placeholder="nama@email.com" value="{{ old('email') }}">
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500">Hasil tes & sertifikat (jika tersedia) akan tersimpan di akun Anda.</p>
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium sm:text-sm">+62</span>
                        </div>
                        <input type="tel" name="phone_number" id="phone_number" required class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 py-3 sm:text-sm border-gray-300 rounded-xl" placeholder="81234567890" value="{{ old('phone_number') }}">
                    </div>
                </div>

                {{-- <x-turnstile /> --}}

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors transform hover:-translate-y-0.5">
                        Lanjut & Mulai Tes <span class="ml-2">→</span>
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400">Dengan menekan tombol di atas, Anda menyetujui<br>Ketentuan Layanan dan Kebijakan Privasi Target Bahasa.</p>
            </div>
        </div>
        
    </div>
</div>
@endsection
