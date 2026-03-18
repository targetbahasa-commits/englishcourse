<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Pendaftaran Kelas – Target Bahasa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen py-10 px-4">

<div class="max-w-2xl mx-auto" x-data="regForm()">

    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-2 mb-3">
            <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">TB</div>
            <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Formulir Pendaftaran Kelas</h1>
        <p class="text-gray-500 text-sm">Isi data di bawah ini dan tim kami akan segera menghubungi kamu.</p>
    </div>

    {{-- Step Indicator --}}
    <div class="flex items-center justify-center gap-2 mb-8">
        @foreach(['Data Diri', 'Program & Mode', 'Jadwal & Tujuan', 'Konfirmasi'] as $i => $label)
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1.5">
                    <div :class="step > {{ $i + 1 }} ? 'bg-green-500 text-white' : (step === {{ $i + 1 }} ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400')"
                         class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all">
                        <span x-show="step <= {{ $i + 1 }}">{{ $i + 1 }}</span>
                        <svg x-show="step > {{ $i + 1 }}" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span :class="step === {{ $i + 1 }} ? 'text-blue-600 font-semibold' : 'text-gray-400'"
                          class="text-xs hidden sm:inline transition-all">{{ $label }}</span>
                </div>
                @if($i < 3)
                    <div :class="step > {{ $i + 1 }} ? 'bg-green-300' : 'bg-gray-200'" class="w-8 h-0.5 rounded transition-all"></div>
                @endif
            </div>
        @endforeach
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Program yang diminati <span class="text-gray-400 font-normal">(opsional)</span></label>
                <div class="grid grid-cols-1 gap-2">
                    @foreach($programs as $prog)
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="program_id" value="{{ $prog->id }}" x-model="form.program_id" @change="onProgramOrModeChanged()" class="accent-blue-600">
                            <span class="text-sm font-medium">{{ $prog->name }}</span>
                        </label>
                    @endforeach
                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:border-gray-300 transition has-[:checked]:border-gray-400 has-[:checked]:bg-gray-50">
                        <input type="radio" name="program_id" value="" x-model="form.program_id" @change="onProgramOrModeChanged()" class="accent-gray-600">
                        <span class="text-sm text-gray-500">Belum yakin / minta rekomendasi</span>
                    </label>
                </div>
                <div x-show="!form.program_id" x-transition class="mt-2">
                    <input type="text" name="program_interest" x-model="form.program_interest" placeholder="Ada program tertentu yang diminati?"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
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
                                :disabled="!isBatchVisible('{{ $period->program_id ?? '' }}', '{{ $period->learning_mode }}')">
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
                    <p class="text-xs font-semibold text-purple-700 mb-2">Info untuk kelas online:</p>
                    <p class="text-xs text-purple-600">Kelas dilaksanakan via Zoom/Google Meet. Pastikan kamu memiliki koneksi internet yang stabil. Tim akan mengirimkan link kelas via WhatsApp.</p>
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

            {{-- Budget --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Budget yang disiapkan <span class="text-gray-400 font-normal">(opsional)</span></label>
                <select name="budget_range" x-model="form.budget_range"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                    <option value="">-- Pilih range budget --</option>
                    <option value="< 500rb">Di bawah Rp 500.000</option>
                    <option value="500rb - 1jt">Rp 500.000 – Rp 1.000.000</option>
                    <option value="1jt - 2jt">Rp 1.000.000 – Rp 2.000.000</option>
                    <option value="2jt - 5jt">Rp 2.000.000 – Rp 5.000.000</option>
                    <option value="> 5jt">Di atas Rp 5.000.000</option>
                </select>
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
                    Lihat Ringkasan →
                </button>
            </div>
        </div>

        {{-- ============ STEP 4: KONFIRMASI ============ --}}
        <div x-show="step === 4" x-transition class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">
                <span class="text-blue-600 mr-2">④</span> Konfirmasi Data
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

@php
    $batchOptions = $classPeriods->map(function ($period) {
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
        form: {
            full_name:            '{{ old('full_name') }}',
            whatsapp:             '{{ old('whatsapp') }}',
            email:                '{{ old('email') }}',
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
            budget_range:         '{{ old('budget_range') }}',
            best_contact_time:    '{{ old('best_contact_time') }}',
            notes:                '{{ old('notes') }}',
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
            this.step++;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}
</script>

</body>
</html>
