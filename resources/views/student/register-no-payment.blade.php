<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Akun Student – Target Bahasa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased min-h-screen" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">

<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-lg">

        {{-- Header --}}
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-6">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-700 font-bold text-sm shadow">TB</div>
                <span class="text-xl font-bold text-white">Target Bahasa</span>
            </a>
            <h1 class="text-3xl font-extrabold text-white mb-2">Buat Akun Student</h1>
            <p class="text-indigo-200 text-sm">Daftarkan dirimu untuk mengakses kelas tanpa melalui tahap pembayaran.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden" x-data="{
            selectedProgram: '{{ $preselectedProgram ?? '' }}',
            showPassword: false,
            showConfirm: false,
        }">

            {{-- Program Selection Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                <p class="text-indigo-100 text-xs font-semibold uppercase tracking-wider mb-3">Pilih Kelas &amp; Selesaikan</p>
                <p class="text-white font-semibold text-sm">Pilih program utama yang ingin kamu ikuti, lalu langsung buat akun.</p>
            </div>

            <form action="{{ route('student.register.store') }}" method="POST" class="p-8 space-y-5">
                @csrf

                {{-- Program Selection --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Program</label>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($programs as $prog)
                        <label class="flex items-center gap-3 p-3.5 border-2 border-gray-100 rounded-2xl cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                            <input type="radio" name="program_id" value="{{ $prog->id }}"
                                   x-model="selectedProgram"
                                   {{ (string)($preselectedProgram ?? '') === (string)$prog->id ? 'checked' : '' }}
                                   class="accent-indigo-600 w-4 h-4 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <span class="text-sm font-semibold text-gray-800">{{ $prog->name }}</span>
                                @php
                                    $descriptions = [
                                        'ielts' => 'Fokus untuk kebutuhan studi dan akademik.',
                                        'general' => 'Fokus untuk kebutuhan kerja dan migrasi.',
                                        'toefl' => 'Persiapan tes TOEFL ITP untuk kebutuhan institusional.',
                                        'pte' => 'Persiapan tes PTE berbasis komputer.',
                                        'grammar' => 'Fokus memperkuat grammar untuk writing akademik dan profesional.',
                                    ];
                                    $desc = '';
                                    $slug = strtolower($prog->name);
                                    foreach ($descriptions as $key => $val) {
                                        if (str_contains($slug, $key)) { $desc = $val; break; }
                                    }
                                    if (!$desc) $desc = 'Program belajar bahasa Inggris intensif.';
                                @endphp
                                <p class="text-xs text-gray-400 mt-0.5">{{ $desc }}</p>
                            </div>
                            <div :class="selectedProgram == '{{ $prog->id }}' ? 'bg-indigo-500' : 'bg-gray-100'"
                                 class="w-5 h-5 rounded-full flex-shrink-0 flex items-center justify-center transition-colors">
                                <svg x-show="selectedProgram == '{{ $prog->id }}'" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </label>
                        @endforeach
                        <label class="flex items-center gap-3 p-3.5 border-2 border-gray-100 rounded-2xl cursor-pointer hover:border-gray-300 transition-all has-[:checked]:border-gray-300 has-[:checked]:bg-gray-50">
                            <input type="radio" name="program_id" value="" x-model="selectedProgram" class="accent-gray-500 w-4 h-4 flex-shrink-0">
                            <span class="text-sm text-gray-400">Belum yakin / minta rekomendasi</span>
                        </label>
                    </div>
                    @error('program_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <hr class="border-gray-100">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500 font-medium flex-shrink-0">+62</span>
                        <input type="tel" name="phone_number" value="{{ old('phone_number') }}" placeholder="812-3456-7890"
                               class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('phone_number') border-red-400 @enderror">
                    </div>
                    @error('phone_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="kamu@email.com"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Minimal 6 karakter"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition pr-10 @error('password') border-red-400 @enderror">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Password Confirm --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" placeholder="Ulangi password"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition pr-10">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Errors --}}
                @if($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                        <li class="text-xs text-red-600 flex items-start gap-1.5">
                            <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Submit --}}
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3.5 rounded-2xl transition text-sm shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Buat Akun Student
                </button>

                {{-- Login Link --}}
                <p class="text-center text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Masuk di sini</a>
                </p>
            </form>
        </div>

        {{-- Already a student note --}}
        <p class="text-center text-xs text-indigo-200 mt-6">
            Dengan mendaftar, kamu menyetujui penggunaan data untuk keperluan akses kelas dan komunikasi dari Tim Target Bahasa.
        </p>

    </div>
</div>

</body>
</html>
