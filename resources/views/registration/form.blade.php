<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Pendaftaran Kelas – Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white min-h-screen relative flex items-center justify-center overflow-x-hidden p-6">

    <!-- Canvas Background (Full Screen) -->
    <canvas id="particleCanvas" class="fixed inset-0 z-0 opacity-70 border-r border-gray-100/50"></canvas>
    <div class="fixed inset-0 z-0 pointer-events-none bg-gradient-to-br from-white/90 via-white/50 to-white/90"></div>

    <div class="relative z-10 w-full max-w-2xl bg-white/70 backdrop-blur-xl rounded-3xl border border-white/50 shadow-2xl p-6 sm:p-8 my-8" x-data="regForm()" @set-step.window="step = $event.detail">

    {{-- Header & Step Indicator --}}
    <div class="p-0 sm:p-4 pb-0 text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30 transform hover:scale-105 transition-transform duration-500">
            <span class="text-2xl font-black text-white">TB</span>
        </div>
        @php
            $tb_auth_register_daftar_title = \App\Models\Setting::where('key', 'auth_register_daftar_title')->value('value') ?? 'Formulir Pendaftaran Kelas';
            $tb_auth_register_daftar_subtitle = \App\Models\Setting::where('key', 'auth_register_daftar_subtitle')->value('value') ?? 'Isi data di bawah ini dan tim kami akan segera menghubungi kamu.';
        @endphp
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-3 tracking-tight text-gray-900">{{ $tb_auth_register_daftar_title }}</h1>
        <p class="text-gray-600 text-sm sm:text-base mx-auto font-medium leading-relaxed max-w-md">{{ $tb_auth_register_daftar_subtitle }}</p>

        <div class="mt-5 flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-[10px] sm:text-xs font-semibold tracking-wide uppercase">
            @foreach(['Data Diri', 'Program & Mode', 'Jadwal & Tujuan', 'Buat Akun', 'Pembayaran', 'Konfirmasi'] as $i => $label)
                <span :class="step === {{ $i + 1 }} ? 'bg-blue-600 text-white border-blue-600' : (step > {{ $i + 1 }} ? 'bg-green-500 text-white border-green-500' : 'bg-gray-100 text-gray-500 border-gray-200')" 
                      class="px-3 py-1 rounded-full border transition-all duration-300">
                    Tahap {{ $i + 1 }}: {{ $label }}
                </span>
            @endforeach
        </div>
    </div>

    <form action="{{ route('registration.store') }}" method="POST">
        @csrf
        <x-marketing-attribution />

        {{-- ============ STEP 1: DATA DIRI ============ --}}
        <div x-show="step === 1" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">
                <span class="text-blue-600 mr-2">①</span> Data Diri
            </h2>

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                  <input type="text" name="full_name" x-model="form.full_name" placeholder="Contoh: Budi Santoso"
                      class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                @error('full_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- WhatsApp --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500 font-medium">+62</span>
                              <input type="tel" name="whatsapp" x-model="form.whatsapp" placeholder="812-3456-7890"
                                  class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>
                @error('whatsapp')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="email" name="email" x-model="form.email" placeholder="kamu@email.com"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
            </div>

            {{-- Kota & Usia --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kota Domisili <span class="text-red-500">*</span></label>
                              <input type="text" name="city" x-model="form.city" placeholder="Jakarta, Bandung..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    @error('city')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Usia <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="number" name="age" x-model="form.age" placeholder="20" min="10" max="100"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>
            </div>

            {{-- Profesi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status / Profesi <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['student_sma' => 'Pelajar SMA', 'mahasiswa' => 'Mahasiswa', 'karyawan' => 'Karyawan', 'other' => 'Lainnya'] as $val => $label)
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="profession" value="{{ $val }}" x-model="form.profession" class="accent-blue-600">
                            <span class="text-sm">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                <div x-show="form.profession === 'other'" x-transition class="mt-2">
                    <input type="text" name="profession_other" x-model="form.profession_other" placeholder="Profesi kamu..."
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                @error('profession')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Sumber --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahu Target Bahasa dari mana? <span class="text-red-500">*</span></label>
                <select name="source" x-model="form.source"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                    <option value="">-- Pilih --</option>
                    <option value="instagram">Instagram</option>
                    <option value="tiktok">TikTok</option>
                    <option value="youtube">YouTube</option>
                    <option value="teman">Rekomendasi Teman</option>
                    <option value="google">Google</option>
                    <option value="brosur">Brosur / Flyer</option>
                    <option value="other">Lainnya</option>
                </select>
                <div x-show="form.source === 'teman' || form.source === 'other'" x-transition class="mt-2">
                    <input type="text" name="source_detail" x-model="form.source_detail" placeholder="Ceritakan lebih lanjut..."
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                @error('source')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="button" @click="nextStep()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition text-sm mt-2">
                Lanjut ke Pilihan Program →
            </button>
        </div>

        {{-- ============ STEP 2: PROGRAM & MODE ============ --}}
        <div x-show="step === 2" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">
                <span class="text-blue-600 mr-2">②</span> Pilih Program & Mode Belajar
            </h2>

            {{-- Program --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Program yang diminati <span class="text-red-500">*</span></label>
                <div class="space-y-3">
                    @foreach(collect($programs)->groupBy('category') as $category => $categoryPrograms)
                        <details class="group border border-gray-200 rounded-xl bg-white overflow-hidden [&_summary::-webkit-details-marker]:hidden">
                            <summary class="flex justify-between items-center font-bold cursor-pointer list-none px-5 py-4 bg-gray-50 hover:bg-gray-100 transition text-gray-800">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v6M7 11h10"></path>
                                    </svg>
                                    {{ $category ?: 'Program Lainnya' }}
                                </span>
                                <span class="transition group-open:rotate-180 bg-white border border-gray-200 rounded-full p-1 text-gray-500 shadow-sm">
                                    <svg fill="none" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="18">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="p-3 grid grid-cols-1 gap-2 border-t border-gray-200 bg-white/50">
                                @foreach($categoryPrograms as $prog)
                                    <label class="block relative text-left rounded-lg border border-gray-200 bg-white px-4 py-3 hover:border-blue-400 hover:bg-blue-50 transition cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:ring-2 has-[:checked]:ring-blue-200">
                                        <input type="radio" name="program_id" value="{{ $prog->id }}" x-model="form.program_id" @change="onProgramOrModeChanged(); programError = false" class="hidden">
                                        <p class="font-semibold text-gray-900">{{ $prog->name }}</p>
                                        <p class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit(strip_tags($prog->description ?? 'Tingkatkan kemampuan bahasa Inggris Anda secara intensif.'), 100) }}</p>
                                    </label>
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </div>
                {{-- Inline error --}}
                <div x-show="programError" x-transition class="mt-2 flex items-center gap-2 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    <p class="text-sm text-red-600 font-medium">Silakan pilih program terlebih dahulu.</p>
                </div>
            </div>

            {{-- Batch Kelas --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Batch Kelas <span class="text-gray-400 font-normal">(opsional)</span></label>
                <select name="class_period_id" x-model="form.class_period_id" @change="onBatchChanged()"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                    <option value="">-- Pilih batch kelas --</option>
                    @foreach($classPeriods as $period)
                        <option value="{{ $period->id }}"
                                x-show="isBatchVisible('{{ $period->program_id ?? '' }}', '{{ $period->learning_mode }}')">
                            {{ $period->program?->name ?? 'Program' }} - {{ $period->name }}
                            @if($period->start_date)
                                (Mulai {{ $period->start_date->format('d M Y') }})
                            @endif
                            - {{ ucfirst($period->learning_mode) }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Batch menentukan materi/soal aktif sesuai gelombang kelas.</p>
                @error('class_period_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Mode --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mode Belajar <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-400 transition has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50 text-center">
                        <input type="radio" name="mode" value="online" x-model="form.mode" @change="onProgramOrModeChanged()" class="hidden">
                        <span class="text-sm font-semibold text-gray-700">Online</span>
                        <span class="text-xs text-gray-400">Zoom / Meet</span>
                    </label>
                    <label class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-orange-400 transition has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 text-center">
                        <input type="radio" name="mode" value="offline" x-model="form.mode" @change="onProgramOrModeChanged()" class="hidden">
                        <span class="text-sm font-semibold text-gray-700">Offline</span>
                        <span class="text-xs text-gray-400">Di lokasi kelas</span>
                    </label>
                    <label class="flex flex-col items-center gap-2 p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-teal-400 transition has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50 text-center">
                        <input type="radio" name="mode" value="flexible" x-model="form.mode" @change="onProgramOrModeChanged()" class="hidden">
                        <span class="text-sm font-semibold text-gray-700">Fleksibel</span>
                        <span class="text-xs text-gray-400">Bisa keduanya</span>
                    </label>
                </div>
                @error('mode')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

                {{-- Kondisional Online --}}
                <div x-show="form.mode === 'online' || form.mode === 'flexible'" x-transition class="mt-3 p-3 bg-purple-50 rounded-xl border border-purple-100">
                    <template x-if="form.mode === 'online'">
                        <div>
                            <p class="text-xs font-semibold text-purple-700 mb-2">Info untuk kelas online:</p>
                            <p class="text-xs text-purple-600">Kelas dilaksanakan via Zoom/Google Meet. Pastikan kamu memiliki koneksi internet yang stabil. Tim akan mengirimkan link kelas via WhatsApp.</p>
                        </div>
                    </template>
                    <template x-if="form.mode === 'flexible'">
                        <div>
                            <p class="text-xs font-semibold text-teal-700 mb-2">Info untuk kelas fleksibel:</p>
                            <p class="text-xs text-teal-600">Kelas fleksibel (online & offline) hanya tersedia dengan konfirmasi admin. Silakan hubungi admin terlebih dahulu sebelum memilih mode ini.</p>
                        </div>
                    </template>
                </div>

                {{-- Kondisional Offline --}}
                <div x-show="form.mode === 'offline'" x-transition class="mt-3 p-3 bg-orange-50 rounded-xl border border-orange-100">
                    <p class="text-xs font-semibold text-orange-700 mb-2">Info untuk kelas offline:</p>
                    <p class="text-xs text-orange-600">Tim kami akan menginformasikan lokasi kelas dan waktu trial class setelah kamu mendaftar.</p>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" @click="step--" class="flex-1 border border-gray-200 text-gray-600 font-semibold py-3 rounded-xl transition text-sm hover:bg-gray-50">
                    ← Kembali
                </button>
                <button type="button" @click="nextStep()" class="flex-2 flex-grow bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition text-sm">
                    Lanjut ke Jadwal →
                </button>
            </div>
        </div>

        {{-- ============ STEP 3: JADWAL & TUJUAN ============ --}}
        <div x-show="step === 3" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">
                <span class="text-blue-600 mr-2">③</span> Jadwal & Tujuan Belajar
            </h2>

            {{-- Jadwal --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Preferensi Jadwal <span class="text-red-500">*</span></label>
                    <select name="schedule_preference" x-model="form.schedule_preference"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                        <option value="weekday">Weekday (Senin–Jumat)</option>
                        <option value="weekend">Weekend (Sabtu–Minggu)</option>
                        <option value="flexible" selected>Fleksibel</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Waktu Pilihan <span class="text-red-500">*</span></label>
                    <select name="preferred_time" x-model="form.preferred_time"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                        <option value="pagi">Pagi (07.00–11.00)</option>
                        <option value="siang">Siang (11.00–14.00)</option>
                        <option value="sore">Sore (14.00–17.00)</option>
                        <option value="malam">Malam (17.00–21.00)</option>
                        <option value="flexible" selected>Fleksibel</option>
                    </select>
                </div>
            </div>

            {{-- Tujuan belajar --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tujuan Belajar</label>
                <textarea name="learning_goal" x-model="form.learning_goal" rows="3"
                          placeholder="Contoh: Persiapan IELTS 7.0 untuk beasiswa ke Australia..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition resize-none"></textarea>
            </div>

            {{-- Target skor --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Target Skor <span class="text-gray-400 font-normal">(jika ada)</span></label>
                <input type="text" name="target_score" x-model="form.target_score" placeholder="Contoh: IELTS 7.0 / TOEFL 600"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            {{-- Kursus sebelumnya --}}
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <input type="checkbox" name="has_previous_course" id="prev_course" value="1" x-model="form.has_previous_course" class="accent-blue-600 w-4 h-4">
                    <label for="prev_course" class="text-sm text-gray-700 cursor-pointer">Saya pernah ikut kursus bahasa Inggris sebelumnya</label>
                </div>
                <input type="hidden" name="has_previous_course" :value="form.has_previous_course ? 1 : 0">
                <div x-show="form.has_previous_course" x-transition>
                    <input type="text" name="previous_course_name" x-model="form.previous_course_name" placeholder="Nama kursus sebelumnya..."
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>



            {{-- Waktu dihubungi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Waktu terbaik untuk dihubungi <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="text" name="best_contact_time" x-model="form.best_contact_time" placeholder="Contoh: Senin–Jumat jam 19.00–21.00"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            {{-- Catatan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan / Pertanyaan lain <span class="text-gray-400 font-normal">(opsional)</span></label>
                <textarea name="notes" x-model="form.notes" rows="2"
                          placeholder="Tulis pertanyaan atau hal yang ingin kamu sampaikan..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" @click="step--" class="flex-1 border border-gray-200 text-gray-600 font-semibold py-3 rounded-xl transition text-sm hover:bg-gray-50">
                    ← Kembali
                </button>
                <button type="button" @click="nextStep()" class="flex-2 flex-grow bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition text-sm">
                    Lanjut Buat Akun →
                </button>
            </div>
        </div>

        {{-- ============ STEP 4: BUAT AKUN ============ --}}
        <div x-show="step === 4" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">
                <span class="text-blue-600 mr-2">④</span> Buat Akun Student
            </h2>
            <p class="text-sm text-gray-500 mb-4">Buat password untuk login ke sistem kami setelah pendaftaran kamu dikonfirmasi oleh tim Target Bahasa.</p>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" x-model="form.password" placeholder="Minimal 8 karakter"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                <div x-show="passwordError" x-transition class="mt-1 text-xs text-red-500" x-text="passwordErrorMsg"></div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" x-model="form.password_confirmation" placeholder="Ulangi password di atas"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
            </div>

            @include('components.password-rules')

            <div class="flex gap-3 pt-2">
                <button type="button" @click="step--" class="flex-1 border border-gray-200 text-gray-600 font-semibold py-3 rounded-xl transition text-sm hover:bg-gray-50">
                    ← Kembali
                </button>
                <button type="button" @click="nextStep()" class="flex-2 flex-grow bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition text-sm">
                    Lihat Ringkasan →
                </button>
            </div>
        </div>

        {{-- ============ STEP 5: PEMBAYARAN ============ --}}
        <div x-show="step === 5" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">
                <span class="text-blue-600 mr-2">⑤</span> Pilih Metode Pembayaran
            </h2>

            {{-- Referral Code --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Referral (Opsional)</label>
                <div class="flex gap-2">
                    <input type="text" name="referral_code" x-model="form.referral_code" placeholder="Masukkan kode referral teman..."
                           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 uppercase outline-none transition">
                    <button type="button" @click="verifyReferral()"
                            class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold px-4 py-2 rounded-xl transition text-sm border border-blue-200">
                        Gunakan
                    </button>
                </div>
                {{-- Referral Status --}}
                <div x-show="referralMessage" x-transition class="mt-2 text-sm flex items-center gap-1">
                    <span :class="referralStatus === 'valid' ? 'text-green-600' : 'text-red-500'" x-html="referralMessage"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3">
                <label class="flex flex-col gap-1 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:ring-2 has-[:checked]:ring-blue-200">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-900">Transfer Bank</span>
                        <input type="radio" name="payment_channel" value="bank_transfer" x-model="form.payment_channel" class="accent-blue-600 w-5 h-5">
                    </div>
                    <p class="text-sm text-gray-500">Upload bukti transfer lalu tunggu verifikasi admin.</p>
                </label>

                <label class="flex flex-col gap-1 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:ring-2 has-[:checked]:ring-blue-200">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-900">Cash (Bayar di kantor)</span>
                        <input type="radio" name="payment_channel" value="cash" x-model="form.payment_channel" class="accent-blue-600 w-5 h-5">
                    </div>
                    <p class="text-sm text-gray-500">Buat invoice lalu lakukan pembayaran langsung di kantor.</p>
                </label>
            </div>

            <div class="flex gap-3 pt-3">
                <button type="button" @click="step--" class="flex-1 border border-gray-200 text-gray-600 font-semibold py-3 rounded-xl transition text-sm hover:bg-gray-50">
                    ← Kembali
                </button>
                <button type="button" @click="nextStep()" class="flex-2 flex-grow bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition text-sm">
                    Lanjut ke Konfirmasi →
                </button>
            </div>
        </div>

        {{-- ============ STEP 6: KONFIRMASI ============ --}}
        <div x-show="step === 6" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">
                <span class="text-blue-600 mr-2">⑥</span> Konfirmasi Data
            </h2>

            <div class="bg-gray-50 rounded-xl p-4 space-y-2.5 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-medium text-gray-800" x-text="form.full_name || '—'"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">WhatsApp</span>
                    <span class="font-medium text-gray-800" x-text="form.whatsapp || '—'"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Kota</span>
                    <span class="font-medium text-gray-800" x-text="form.city || '—'"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Mode Belajar</span>
                    <span class="font-semibold capitalize" :class="{'text-purple-600': form.mode==='online','text-orange-600': form.mode==='offline','text-teal-600': form.mode==='flexible'}" x-text="form.mode || '—'"></span>
                </div>
                <div class="flex justify-between" x-show="selectedBatchLabel()">
                    <span class="text-gray-500">Batch Kelas</span>
                    <span class="font-medium text-gray-800 text-right max-w-[60%]" x-text="selectedBatchLabel()"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Jadwal</span>
                    <span class="font-medium text-gray-800" x-text="(form.schedule_preference || '—') + ' / ' + (form.preferred_time || '—')"></span>
                </div>
                <div class="flex justify-between" x-show="form.target_score">
                    <span class="text-gray-500">Target Skor</span>
                    <span class="font-medium text-gray-800" x-text="form.target_score"></span>
                </div>
                <div class="flex justify-between" x-show="form.learning_goal">
                    <span class="text-gray-500">Tujuan</span>
                    <span class="font-medium text-gray-800 text-right max-w-[60%]" x-text="form.learning_goal"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pembayaran</span>
                    <span class="font-semibold capitalize text-blue-600" x-text="form.payment_channel === 'bank_transfer' ? 'Transfer Bank' : 'Cash'"></span>
                </div>
                <div class="flex justify-between" x-show="form.referral_code">
                    <span class="text-gray-500">Kode Referral</span>
                    <span class="font-medium text-green-600 uppercase" x-text="form.referral_code + (referrerName ? ' (' + referrerName + ')' : '')"></span>
                </div>
            </div>

            <p class="text-xs text-gray-400 text-center">
                Dengan mendaftar, kamu setuju data ini digunakan untuk keperluan follow-up kelas oleh tim Target Bahasa.
            </p>

            <div class="flex gap-3 pt-1">
                <button type="button" @click="step--" class="flex-1 border border-gray-200 text-gray-600 font-semibold py-3 rounded-xl transition text-sm hover:bg-gray-50">
                    ← Edit
                </button>
                <button type="submit" class="flex-2 flex-grow bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition text-sm">
                    Daftarkan Saya
                </button>
            </div>
        </div>

        {{-- Honeypot field (hidden from real users) --}}
        <div style="display:none;">
            <label for="address_line_2">Leave this field blank</label>
            <input type="text" name="address_line_2" id="address_line_2" tabindex="-1" autocomplete="off">
        </div>

        {{-- Cloudflare Turnstile --}}
        <div class="mt-4 flex flex-col items-center justify-center w-full" x-show="step === 6">
            <x-turnstile />
            @error('cf-turnstile-response')
                <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
            @enderror
        </div>

    </form>

    {{-- Error summary from back() --}}
    @if($errors->any())
        <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4">
            <p class="text-sm font-semibold text-red-700 mb-2">Ada data yang perlu diperbaiki:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-xs text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



</div>

    <!-- Admin Preview Panel (Outside Container) -->
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
                <div class="flex flex-col gap-2" x-data>
                    @foreach(['Data Diri', 'Program & Mode', 'Jadwal & Tujuan', 'Buat Akun', 'Pembayaran', 'Konfirmasi'] as $i => $label)
                    <button type="button" @click="$dispatch('set-step', {{ $i + 1 }})"
                        class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-lg bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition border border-gray-200 hover:border-blue-200 font-medium">
                        Tahap {{ $i + 1 }}: {{ $label }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@php
    $batchOptions = collect($classPeriods)->map(function ($period) {
        return [
            'id' => (string) $period->id,
            'label' => trim(($period->program?->name ?? 'Program') . ' - ' . $period->name . ($period->start_date ? ' (Mulai ' . $period->start_date->format('d M Y') . ')' : '') . ' - ' . ucfirst($period->learning_mode)),
            'program_id' => $period->program_id ? (string) $period->program_id : '',
            'learning_mode' => $period->learning_mode,
        ];
    })->values();
@endphp

<script>
function regForm() {
    const batchOptions = @json($batchOptions);

    return {
        step: 1,
        programError: false,
        passwordError: false,
        passwordErrorMsg: '',
        form: {
            full_name:            '{{ old('full_name', auth()->user()?->name ?? '') }}',
            whatsapp:             '{{ old('whatsapp', auth()->user()?->phone_number ?? '') }}',
            email:                '{{ old('email', auth()->user()?->email ?? '') }}',
            city:                 '{{ old('city') }}',
            age:                  '{{ old('age') }}',
            profession:           '{{ old('profession', 'other') }}',
            profession_other:     '{{ old('profession_other') }}',
            program_id:           '{{ old('program_id') }}',
            class_period_id:      '{{ old('class_period_id') }}',
            program_interest:     '{{ old('program_interest') }}',
            mode:                 '{{ old('mode', 'flexible') }}',
            schedule_preference:  '{{ old('schedule_preference', 'flexible') }}',
            preferred_time:       '{{ old('preferred_time', 'flexible') }}',
            learning_goal:        '{{ old('learning_goal') }}',
            target_score:         '{{ old('target_score') }}',
            source:               '{{ old('source') }}',
            source_detail:        '{{ old('source_detail') }}',
            has_previous_course:  {{ old('has_previous_course', 0) ? 'true' : 'false' }},
            previous_course_name: '{{ old('previous_course_name') }}',
            best_contact_time:    '{{ old('best_contact_time') }}',
            notes:                '{{ old('notes') }}',
            password:             '',
            password_confirmation:'',
            payment_channel:      '{{ old('payment_channel', 'bank_transfer') }}',
            referral_code:        '{{ old('referral_code') }}',
        },
        referralStatus: '',
        referralMessage: '',
        referrerName: '',
        async verifyReferral() {
            if (!this.form.referral_code) {
                this.referralStatus = 'error';
                this.referralMessage = 'Masukkan kode referral terlebih dahulu.';
                return;
            }
            
            this.referralMessage = '<i>Memverifikasi...</i>';
            this.referralStatus = '';
            
            try {
                const response = await fetch('/api/verify-referral', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code: this.form.referral_code })
                });
                
                const data = await response.json();
                if (data.valid) {
                    this.referralStatus = 'valid';
                    this.referralMessage = data.message + ' (' + data.referrer_name + ')';
                    this.referrerName = data.referrer_name;
                } else {
                    this.referralStatus = 'error';
                    this.referralMessage = data.message || 'Kode referral tidak valid.';
                    this.referrerName = '';
                }
            } catch (err) {
                this.referralStatus = 'error';
                this.referralMessage = 'Gagal memverifikasi kode. Coba lagi.';
            }
        },
        isBatchVisible(programId, learningMode) {
            const matchProgram = !this.form.program_id || String(this.form.program_id) === String(programId);
            const matchMode = this.form.mode === 'flexible' || this.form.mode === learningMode;
            return matchProgram && matchMode;
        },
        selectedBatchLabel() {
            const selected = batchOptions.find((item) => String(item.id) === String(this.form.class_period_id));
            return selected ? selected.label : '';
        },
        onBatchChanged() {
            const selected = batchOptions.find((item) => String(item.id) === String(this.form.class_period_id));
            if (!selected) {
                return;
            }

            if (selected.program_id) {
                this.form.program_id = selected.program_id;
            }

            if (selected.learning_mode === 'online' || selected.learning_mode === 'offline') {
                this.form.mode = selected.learning_mode;
            }
        },
        onProgramOrModeChanged() {
            if (!this.form.class_period_id) {
                return;
            }

            const selected = batchOptions.find((item) => String(item.id) === String(this.form.class_period_id));
            if (!selected) {
                this.form.class_period_id = '';
                return;
            }

            if (!this.isBatchVisible(selected.program_id, selected.learning_mode)) {
                this.form.class_period_id = '';
            }
        },
        nextStep() {
            // Validate program selection on step 2
            if (this.step === 2) {
                if (!this.form.program_id) {
                    this.programError = true;
                    document.querySelector('[x-show="programError"]')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }
                this.programError = false;
            }
            
            // Validate password on step 4
            if (this.step === 4) {
                if (!this.form.password || this.form.password.length < 8) {
                    this.passwordError = true;
                    this.passwordErrorMsg = 'Password minimal 8 karakter.';
                    return;
                }
                if (this.form.password !== this.form.password_confirmation) {
                    this.passwordError = true;
                    this.passwordErrorMsg = 'Konfirmasi password tidak cocok.';
                    return;
                }
                this.passwordError = false;
                this.passwordErrorMsg = '';
            }

            this.step++;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
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
