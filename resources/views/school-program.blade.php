<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School English Camp - Target Bahasa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* ── TOKENS ────────────────────────────────────────── */
    :root {
        --camp-primary:   #0f6fec;
        --camp-accent:    #f97316;
        --camp-green:     #16a34a;
        --camp-yellow:    #eab308;
        --camp-soft:      #eff6ff;
        --camp-dark:      #1e3a5f;
    }

    /* ── HERO ───────────────────────────────────────────── */
    .camp-hero {
        background: linear-gradient(135deg, #1e3a5f 0%, #0f6fec 60%, #3b82f6 100%);
        border-radius: 1.5rem;
        overflow: hidden;
        position: relative;
    }
    .camp-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* ── BADGES ─────────────────────────────────────────── */
    .camp-badge-new {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(90deg, #f97316, #ef4444);
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        padding: 0.2rem 0.55rem;
        border-radius: 99px;
        text-transform: uppercase;
        animation: pulse-badge 2s infinite;
    }
    @keyframes pulse-badge { 0%,100%{ opacity:1; } 50%{ opacity:.75; } }

    /* ── SECTION HEADINGS ────────────────────────────────── */
    .camp-section-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--camp-primary);
    }
    .camp-section-title {
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 800;
        color: var(--camp-dark);
        line-height: 1.2;
    }

    /* ── CARDS ───────────────────────────────────────────── */
    .camp-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 2px 16px rgba(15,111,236,.08);
        transition: transform .2s, box-shadow .2s;
    }
    .camp-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 32px rgba(15,111,236,.14);
    }

    /* ── LEVEL CARDS ─────────────────────────────────────── */
    .level-card { border-radius: 1rem; padding: 1.5rem; text-align: center; cursor: default; }
    .level-icon { font-size: 2.5rem; margin-bottom: 0.5rem; }

    /* ── ACTIVITY TIMELINE ───────────────────────────────── */
    .timeline-step { display: flex; gap: 1rem; align-items: flex-start; }
    .timeline-dot {
        width: 2.5rem; height: 2.5rem; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; flex-shrink: 0; font-weight: 700;
    }
    .timeline-line { width: 2px; height: 2rem; background: #e2e8f0; margin: 0 auto; }

    /* ── STEP FLOW ───────────────────────────────────────── */
    .step-flow { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; }
    .step-item {
        display: flex; flex-direction: column; align-items: center;
        text-align: center; flex: 1; min-width: 120px; max-width: 160px; gap: 0.5rem;
    }
    .step-num {
        width: 3rem; height: 3rem; border-radius: 50%;
        background: var(--camp-primary); color: #fff;
        font-weight: 800; font-size: 1.2rem;
        display: flex; align-items: center; justify-content: center;
    }
    .step-arrow { font-size: 1.5rem; color: #cbd5e1; align-self: center; flex-shrink: 0; }

    /* ── FORM ────────────────────────────────────────────── */
    .camp-input {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.7rem 1rem;
        font-size: 0.92rem;
        color: #1e293b;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .camp-input:focus { border-color: var(--camp-primary); box-shadow: 0 0 0 3px rgba(15,111,236,.12); }
    .camp-label { font-size: 0.82rem; font-weight: 600; color: #475569; margin-bottom: 0.35rem; display: block; }
    .camp-submit-btn {
        background: linear-gradient(90deg, var(--camp-primary), #3b82f6);
        color: #fff; border: none; border-radius: 0.875rem;
        padding: 0.9rem 2.5rem; font-size: 1rem; font-weight: 700;
        cursor: pointer; transition: opacity .2s, transform .15s;
        width: 100%;
    }
    .camp-submit-btn:hover { opacity: 0.92; transform: translateY(-1px); }
    .camp-submit-btn:active { transform: translateY(0); }

    /* ── SUCCESS CARD ────────────────────────────────────── */
    .camp-success {
        background: linear-gradient(135deg, #dcfce7, #f0fdf4);
        border: 2px solid #86efac;
        border-radius: 1.25rem;
        padding: 2.5rem;
        text-align: center;
    }

    /* ── FACILITY ICON ───────────────────────────────────── */
    .facility-item { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; text-align: center; }
    .facility-icon { font-size: 2rem; }

    /* ── CTA STRIP ───────────────────────────────────────── */
    .camp-cta-strip {
        background: linear-gradient(90deg, #f97316, #ef4444);
        border-radius: 1.25rem;
        padding: 1.5rem 2rem;
        display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between;
    }
    .camp-wa-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: #fff; color: #16a34a;
        font-weight: 700; font-size: 0.95rem;
        padding: 0.75rem 1.5rem; border-radius: 0.875rem;
        text-decoration: none; transition: transform .15s, box-shadow .15s;
        box-shadow: 0 2px 10px rgba(0,0,0,.12);
        white-space: nowrap;
    }
    .camp-wa-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,.16); }
</style>
</head>
<body class="font-sans antialiased bg-slate-50 text-gray-900">

{{-- ── SUCCESS STATE (after form submit) ─────────────────────── --}}
@if(session('inquiry_success'))
<div class="camp-success mb-8 animate-bounce-once">
    <div class="text-5xl mb-3">🎉</div>
    <h2 class="text-2xl font-extrabold text-green-700 mb-2">Inquiry Berhasil Terkirim!</h2>
    <p class="text-green-600 mb-4">Tim kami akan segera menghubungi Bapak/Ibu dalam 1×24 jam melalui WhatsApp.<br>Terima kasih atas kepercayaan Anda!</p>
    <a href="{{ route('school-program') }}" class="inline-flex items-center gap-2 bg-green-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-green-700 transition text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Halaman Program
    </a>
</div>
@endif

{{-- ══════════════════════════════════════════════════════════
     SECTION 1 — HERO
════════════════════════════════════════════════════════════ --}}
<div class="camp-hero p-8 md:p-12 mb-8 relative">
    <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center">
        {{-- Text --}}
        <div class="flex-1 text-white">
            <div class="flex items-center gap-2 mb-4">
                <span class="camp-badge-new">✨ Program Baru</span>
                <span class="text-blue-200 text-xs font-medium">Kampung Inggris Pare</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight mb-4">
                🏕️ PARE<br>
                <span class="text-yellow-300">English School Camp</span>
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed mb-6 max-w-lg">
                Program wisata edukasi bahasa Inggris eksklusif untuk sekolah. Bawa guru & siswa belajar langsung di jantung <strong class="text-white">Kampung Inggris Pare</strong> — lingkungan belajar bahasa Inggris terbaik di Indonesia.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="#inquiry-form" class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold px-6 py-3 rounded-xl transition shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Kirim Inquiry Sekolah
                </a>
                <a href="#tentang-program" class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white font-semibold px-6 py-3 rounded-xl transition border border-white/30">
                    Pelajari Program
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
            </div>

            {{-- Highlight stats --}}
            <div class="flex flex-wrap gap-4 mt-8">
                @foreach([['Semua Jenjang', '🎒'], ['1–2 Minggu', '📅'], ['Sertifikat Resmi', '🏆'], ['All-in-One Paket', '✅']] as [$stat, $icon])
                <div class="bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-sm font-semibold text-white flex items-center gap-2">
                    <span>{{ $icon }}</span> {{ $stat }}
                </div>
                @endforeach
            </div>
        </div>

        {{-- Hero Image --}}
        <div class="flex-1 max-w-md w-full">
            <img src="{{ asset('images/school-program/hero.jpg') }}"
                 alt="Siswa belajar bahasa Inggris di Kampung Inggris Pare"
                 class="w-full rounded-2xl shadow-2xl object-cover"
                 style="aspect-ratio:16/10; object-position: center;">
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SECTION 2 — TENTANG PROGRAM
════════════════════════════════════════════════════════════ --}}
<div id="tentang-program" class="camp-card p-8 mb-8">
    <p class="camp-section-label mb-2">Tentang Program</p>
    <h2 class="camp-section-title mb-4">Mengapa PARE English School Camp?</h2>
    <p class="text-gray-500 text-sm leading-relaxed max-w-3xl mb-8">
        Kampung Inggris di Pare, Kediri — Jawa Timur — adalah kawasan yang telah puluhan tahun dikenal sebagai pusat belajar Bahasa Inggris terbaik di Indonesia. Dengan suasana immersif dimana bahasa Inggris digunakan sehari-hari, program ini memberikan pengalaman belajar yang tidak bisa didapatkan di kelas biasa.
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach([
            ['🌍', 'Lingkungan Immersif', 'Siswa terdorong berbicara Inggris sepanjang hari dalam zona English Only.', 'bg-blue-50 border-blue-100'],
            ['👩‍🏫', 'Guru Terlatih & Berpengalaman', 'Pengajar kami berpengalaman menangani berbagai jenjang usia dari SD hingga SMK.', 'bg-green-50 border-green-100'],
            ['📜', 'Sertifikat Resmi', 'Setiap peserta mendapatkan sertifikat kelulusan yang dapat digunakan sebagai portofolio.', 'bg-yellow-50 border-yellow-100'],
            ['📊', 'Laporan Perkembangan', 'Pihak sekolah menerima laporan perkembangan tertulis untuk setiap siswa.', 'bg-purple-50 border-purple-100'],
            ['🎯', 'Kurikulum Khusus Sekolah', 'Materi didesain sesuai level dan kebutuhan sekolah, bukan kurikulum umum.', 'bg-orange-50 border-orange-100'],
            ['🎒', 'Paket Lengkap', 'Akomodasi, konsumsi, materi, kegiatan, dan transportasi lokal sudah termasuk.', 'bg-red-50 border-red-100'],
        ] as [$icon, $title, $desc, $bg])
        <div class="border {{ $bg }} rounded-2xl p-5 flex items-start gap-4">
            <span class="text-3xl flex-shrink-0">{{ $icon }}</span>
            <div>
                <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $title }}</h3>
                <p class="text-gray-500 text-xs leading-relaxed">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SECTION 3 — JENJANG PESERTA
════════════════════════════════════════════════════════════ --}}
<div class="mb-8">
    <div class="text-center mb-6">
        <p class="camp-section-label mb-1">Peserta</p>
        <h2 class="camp-section-title">Program untuk Semua Jenjang</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([
            ['🎒', 'SD', 'Kelas 4–6', 'Fun learning, vocabulary, basic conversation', 'bg-sky-500'],
            ['📚', 'SMP', 'Kelas 7–9', 'Speaking, grammar dasar, presentasi', 'bg-indigo-500'],
            ['🎓', 'SMA', 'Kelas 10–12', 'TOEFL/IELTS prep, debate, conversation', 'bg-purple-500'],
            ['🏭', 'SMK', 'Semua Kelas', 'English for work, vokasional, wawancara', 'bg-orange-500'],
        ] as [$icon, $level, $sub, $desc, $color])
        <div class="camp-card level-card">
            <div class="level-icon">{{ $icon }}</div>
            <div class="inline-block {{ $color }} text-white text-xs font-bold px-3 py-1 rounded-full mb-2">{{ $level }}</div>
            <p class="text-xs text-gray-400 font-medium mb-2">{{ $sub }}</p>
            <p class="text-xs text-gray-500 leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SECTION 4 — KEGIATAN HARIAN
════════════════════════════════════════════════════════════ --}}
<div class="camp-card p-8 mb-8">
    <div class="flex flex-col md:flex-row gap-10 items-start">
        <div class="flex-1">
            <p class="camp-section-label mb-2">Jadwal</p>
            <h2 class="camp-section-title mb-6">Sehari-hari di Camp</h2>
            <div class="space-y-0">
                @foreach([
                    ['☀️', '06.00 – 07.30', 'Pagi Aktif', 'Senam inggris & morning warm-up conversation', 'bg-yellow-100 text-yellow-700'],
                    ['📖', '08.00 – 11.30', 'Kelas Pagi', 'Sesi materi intensif: speaking, grammar, vocabulary', 'bg-blue-100 text-blue-700'],
                    ['🍱', '12.00 – 13.00', 'Istirahat & Makan Siang', 'Makan bersama dengan percakapan Bahasa Inggris', 'bg-green-100 text-green-700'],
                    ['🎮', '13.30 – 16.00', 'Kelas Sore & Games', 'Role play, storytelling, English games seru', 'bg-purple-100 text-purple-700'],
                    ['🌙', '19.30 – 21.00', 'Malam Belajar', 'Review & presentasi mini, diskusi kelompok', 'bg-indigo-100 text-indigo-700'],
                    ['🏆', 'Akhir Camp', 'Ceremony & Sertifikat', 'Penampilan siswa & penganugerahan sertifikat', 'bg-orange-100 text-orange-700'],
                ] as [$icon, $time, $activity, $desc, $style])
                <div class="timeline-step">
                    <div class="flex flex-col items-center">
                        <div class="timeline-dot {{ $style }}">{{ $icon }}</div>
                        @if(!$loop->last)<div class="timeline-line"></div>@endif
                    </div>
                    <div class="pb-4">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">{{ $time }}</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $activity }}</p>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="flex-1 max-w-sm w-full mx-auto">
            <img src="{{ asset('images/school-program/activities.jpg') }}"
                 alt="Kegiatan belajar di PARE English School Camp"
                 class="w-full rounded-2xl shadow-xl object-cover"
                 style="aspect-ratio:4/3;">
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SECTION 5 — FASILITAS
════════════════════════════════════════════════════════════ --}}
<div class="mb-8">
    <div class="text-center mb-6">
        <p class="camp-section-label mb-1">Fasilitas</p>
        <h2 class="camp-section-title">Semua Sudah Termasuk</h2>
    </div>
    <div class="camp-card p-6">
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-6">
            @foreach([
                ['🏫', 'Kelas Nyaman'],
                ['🍽️', 'Makan 3x Sehari'],
                ['🛏️', 'Penginapan'],
                ['📋', 'Materi & Modul'],
                ['📜', 'Sertifikat'],
                ['📊', 'Laporan Siswa'],
                ['🎯', 'Fun Activities'],
                ['🚐', 'Transport Lokal'],
                ['🩺', 'P3K / Kesehatan'],
                ['📸', 'Dokumentasi'],
                ['🎤', 'English Games'],
                ['👩‍🏫', 'Guru Pendamping'],
            ] as [$icon, $label])
            <div class="facility-item">
                <div class="facility-icon">{{ $icon }}</div>
                <p class="text-xs text-gray-600 font-medium leading-tight">{{ $label }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SECTION 6 — ALUR PENDAFTARAN
════════════════════════════════════════════════════════════ --}}
<div class="camp-card p-8 mb-8">
    <div class="text-center mb-8">
        <p class="camp-section-label mb-1">Cara Daftar</p>
        <h2 class="camp-section-title">4 Langkah Mudah</h2>
    </div>
    <div class="step-flow">
        <div class="step-item">
            <div class="step-num">1</div>
            <p class="font-bold text-gray-800 text-sm">Isi Form Inquiry</p>
            <p class="text-xs text-gray-500 leading-relaxed">Kirim data sekolah & estimasi peserta lewat form di bawah</p>
        </div>
        <div class="step-arrow hidden sm:block">→</div>
        <div class="step-item">
            <div class="step-num">2</div>
            <p class="font-bold text-gray-800 text-sm">Diskusi & Survey</p>
            <p class="text-xs text-gray-500 leading-relaxed">Tim kami akan menghubungi untuk detail program & kebutuhan</p>
        </div>
        <div class="step-arrow hidden sm:block">→</div>
        <div class="step-item">
            <div class="step-num">3</div>
            <p class="font-bold text-gray-800 text-sm">Konfirmasi & DP</p>
            <p class="text-xs text-gray-500 leading-relaxed">Penandatanganan MoU dan pembayaran uang muka</p>
        </div>
        <div class="step-arrow hidden sm:block">→</div>
        <div class="step-item">
            <div class="step-num">4</div>
            <p class="font-bold text-gray-800 text-sm">Berangkat! 🎉</p>
            <p class="text-xs text-gray-500 leading-relaxed">Siswa dan guru siap belajar Inggris di Kampung Inggris Pare</p>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SECTION 7 — FORM INQUIRY
════════════════════════════════════════════════════════════ --}}
<div id="inquiry-form" class="camp-card p-8 mb-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <p class="camp-section-label mb-2">📩 Formulir Inquiry</p>
            <h2 class="camp-section-title mb-2">Hubungi Kami Sekarang</h2>
            <p class="text-gray-500 text-sm">Isi form di bawah dan tim kami akan menghubungi Anda dalam 1×24 jam.</p>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
            <p class="text-red-700 font-semibold text-sm mb-2">Mohon periksa isian Anda:</p>
            <ul class="list-disc list-inside text-red-600 text-xs space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('school-program.inquiry') }}" class="space-y-5">
            @csrf

            {{-- Row 1 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="camp-label" for="school_name">🏫 Nama Sekolah / Instansi <span class="text-red-500">*</span></label>
                    <input type="text" id="school_name" name="school_name" required
                           value="{{ old('school_name') }}"
                           class="camp-input @error('school_name') border-red-400 @enderror"
                           placeholder="Contoh: SMPN 1 Malang">
                </div>
                <div>
                    <label class="camp-label" for="pic_name">👤 Nama Penanggung Jawab (PIC) <span class="text-red-500">*</span></label>
                    <input type="text" id="pic_name" name="pic_name" required
                           value="{{ old('pic_name') }}"
                           class="camp-input @error('pic_name') border-red-400 @enderror"
                           placeholder="Nama lengkap koordinator">
                </div>
            </div>

            {{-- Row 2 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="camp-label" for="whatsapp">📱 Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <input type="tel" id="whatsapp" name="whatsapp" required
                           value="{{ old('whatsapp') }}"
                           class="camp-input @error('whatsapp') border-red-400 @enderror"
                           placeholder="08xxxxxxxxxx">
                </div>
                <div>
                    <label class="camp-label" for="email">📧 Email <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           class="camp-input @error('email') border-red-400 @enderror"
                           placeholder="email@sekolah.sch.id">
                </div>
            </div>

            {{-- Row 3 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="camp-label" for="city">📍 Kota / Kabupaten <span class="text-red-500">*</span></label>
                    <input type="text" id="city" name="city" required
                           value="{{ old('city') }}"
                           class="camp-input @error('city') border-red-400 @enderror"
                           placeholder="Contoh: Surabaya">
                </div>
                <div>
                    <label class="camp-label" for="school_level">🎒 Jenjang Sekolah <span class="text-red-500">*</span></label>
                    <select id="school_level" name="school_level" required class="camp-input @error('school_level') border-red-400 @enderror">
                        <option value="" disabled {{ old('school_level') ? '' : 'selected' }}>-- Pilih Jenjang --</option>
                        @foreach(['SD', 'SMP', 'SMA', 'SMK', 'Lainnya'] as $level)
                        <option value="{{ $level }}" {{ old('school_level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Row 4 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="camp-label" for="participant_count">👥 Estimasi Jumlah Peserta <span class="text-red-500">*</span></label>
                    <select id="participant_count" name="participant_count" required class="camp-input @error('participant_count') border-red-400 @enderror">
                        <option value="" disabled {{ old('participant_count') ? '' : 'selected' }}>-- Pilih Estimasi --</option>
                        @foreach(['<20' => 'Kurang dari 20 orang', '20-50' => '20 – 50 orang', '50-100' => '50 – 100 orang', '>100' => 'Lebih dari 100 orang'] as $val => $label)
                        <option value="{{ $val }}" {{ old('participant_count') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="camp-label" for="departure_plan">📅 Rencana Keberangkatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="month" id="departure_plan" name="departure_plan"
                           value="{{ old('departure_plan') }}"
                           class="camp-input @error('departure_plan') border-red-400 @enderror"
                           min="{{ date('Y-m') }}">
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="camp-label" for="notes">💬 Pertanyaan / Catatan Tambahan <span class="text-gray-400 font-normal">(opsional)</span></label>
                <textarea id="notes" name="notes" rows="3"
                          class="camp-input @error('notes') border-red-400 @enderror resize-none"
                          placeholder="Sampaikan pertanyaan atau kebutuhan khusus sekolah Anda...">{{ old('notes') }}</textarea>
            </div>

            {{-- Privacy note --}}
            <p class="text-xs text-gray-400 flex items-start gap-2">
                <svg class="w-4 h-4 flex-shrink-0 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Data Anda aman dan hanya digunakan untuk keperluan komunikasi program ini. Kami tidak akan menyebarkan informasi Anda kepada pihak ketiga.
            </p>

            <button type="submit" class="camp-submit-btn flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Kirim Inquiry Sekarang
            </button>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SECTION 8 — CTA STRIP (WhatsApp)
════════════════════════════════════════════════════════════ --}}
@php
    $contactWa    = config('services.contact.wa', '6285706615607');
    $contactEmail = config('services.contact.email', 'targetbahasa@gmail.com');
    $waText       = urlencode('Halo, saya ingin bertanya tentang PARE English School Camp');
@endphp
<div class="camp-cta-strip mb-8">
    <div>
        <p class="text-white font-extrabold text-lg">Ada pertanyaan? Hubungi kami langsung!</p>
        <p class="text-orange-100 text-sm">Tim kami siap membantu Senin–Sabtu, 08.00–21.00 WIB</p>
        <p class="text-orange-100 text-xs mt-1">
            📧 <a href="mailto:{{ $contactEmail }}" class="underline hover:text-white transition">{{ $contactEmail }}</a>
        </p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="https://wa.me/{{ $contactWa }}?text={{ $waText }}"
           target="_blank" class="camp-wa-btn">
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Chat WhatsApp
        </a>
        <a href="mailto:{{ $contactEmail }}"
           class="camp-wa-btn" style="color:#1d4ed8;">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Kirim Email
        </a>
    </div>
</div>

</body>
</html>
