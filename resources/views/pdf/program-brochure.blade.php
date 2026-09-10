@php
    $base64Image = null;
    $mode = $mode ?? 'offline';

    if (isset($program)) {
        $slug = $program->slug;
        $imageFile = null;

        if (str_contains($slug, 'introductory-grammar')) {
            $imageFile = 'introductory-grammar-for-writing-brochure.jpg';
        } elseif (str_contains($slug, 'complexity-grammar')) {
            $imageFile = 'complexity-grammar-for-writing-brochure.jpg';
        } elseif (str_contains($slug, 'proficiency-grammar')) {
            $imageFile = 'proficiency-grammar-for-writing-brochure.jpg';
        } elseif (str_contains($slug, 'fast-track-grammar')) {
            $imageFile = 'fast-track-grammar-for-writing-brochure.jpg';
        } elseif (str_contains($slug, 'toefl')) {
            $imageFile = ($mode === 'online') ? 'toefl-itp-brochure-online.jpg' : 'toefl-itp-brochure.jpg';
        } elseif (str_contains($slug, 'grammar')) {
            $imageFile = ($mode === 'online') ? 'grammar-for-writing-brochure-online.jpg' : 'grammar-for-writing-brochure.jpg';
        }

        if ($imageFile) {
            $possiblePaths = [
                public_path('images/brochures/' . $imageFile),
                base_path('public/images/brochures/' . $imageFile),
                base_path('images/brochures/' . $imageFile),
                dirname(base_path()) . '/public_html/images/brochures/' . $imageFile,
                dirname(base_path()) . '/public_html/public/images/brochures/' . $imageFile,
            ];

            if (isset($_SERVER['DOCUMENT_ROOT'])) {
                $possiblePaths[] = $_SERVER['DOCUMENT_ROOT'] . '/images/brochures/' . $imageFile;
                $possiblePaths[] = $_SERVER['DOCUMENT_ROOT'] . '/public/images/brochures/' . $imageFile;
            }

            foreach ($possiblePaths as $p) {
                if (file_exists($p) && is_readable($p)) {
                    $data = file_get_contents($p);
                    if ($data !== false && strlen($data) > 1000) {
                        $base64Image = 'data:image/jpeg;base64,' . base64_encode($data);
                        break;
                    }
                }
            }
        }
    }
@endphp

@if($base64Image)
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Brosur Program - {{ $program->name }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: 210mm 297mm;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
        }
        .poster-container {
            width: 100%;
            height: 100%;
            text-align: center;
        }
        .poster-img {
            width: 100%;
            height: 100%;
            display: block;
        }
    </style>
</head>
<body>
    <div class="poster-container">
        <img src="{{ $base64Image }}" class="poster-img" alt="Brosur {{ $program->name }}">
    </div>
</body>
</html>
@else
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Brosur Program - {{ $program->name }}</title>
    <style>
        @page {
            margin: 25px 30px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.45;
            font-size: 11px;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0d47a1;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-img {
            max-height: 50px;
            width: auto;
        }
        .org-tagline {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .contact-box {
            text-align: right;
            font-size: 9.5px;
            color: #475569;
            line-height: 1.4;
        }
        .contact-box strong {
            color: #0d47a1;
        }
        
        /* Banner */
        .banner {
            background-color: #0d47a1;
            color: #ffffff;
            padding: 14px 18px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .banner-mode {
            display: inline-block;
            background-color: #FFB800;
            color: #0f172a;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 3px;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .banner-title {
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .banner-subtitle {
            font-size: 11px;
            color: #e2e8f0;
            font-style: italic;
            margin: 0;
        }

        /* Section Headings */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #0d47a1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-left: 3.5px solid #0d47a1;
            padding-left: 8px;
            margin: 14px 0 8px 0;
        }

        /* Overview Box */
        .overview-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 10px 12px;
            margin-bottom: 12px;
        }
        .overview-text {
            font-size: 10.5px;
            color: #334155;
            line-height: 1.5;
            margin: 0 0 8px 0;
        }
        .target-chips {
            margin-top: 4px;
        }
        .chip {
            display: inline-block;
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            font-size: 8.5px;
            font-weight: bold;
            padding: 2px 7px;
            border-radius: 3px;
            margin-right: 4px;
            margin-bottom: 3px;
        }

        /* Specs Grid */
        .specs-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .specs-table td {
            width: 25%;
            padding: 8px;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            text-align: center;
            vertical-align: middle;
        }
        .spec-label {
            font-size: 8px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }
        .spec-value {
            font-size: 11px;
            font-weight: bold;
            color: #0d47a1;
        }

        /* Two Column Layout */
        .two-col-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .two-col-table td {
            vertical-align: top;
            padding: 0 6px;
        }
        .two-col-table td:first-child {
            padding-left: 0;
        }
        .two-col-table td:last-child {
            padding-right: 0;
        }

        /* Checklist */
        .facility-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .facility-item {
            font-size: 10px;
            color: #334155;
            padding: 3px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .facility-bullet {
            color: #059669;
            font-weight: bold;
            margin-right: 5px;
        }

        /* Pricing Table */
        .price-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .price-table th {
            background-color: #0d47a1;
            color: #ffffff;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px 8px;
            text-align: left;
            border: 1px solid #0d47a1;
        }
        .price-table td {
            font-size: 10px;
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        .price-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .price-highlight {
            font-weight: bold;
            color: #0d47a1;
            font-size: 11px;
        }

        /* Schedule / Batches */
        .batch-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 6px 10px;
            margin-bottom: 4px;
            font-size: 9.5px;
        }
        .batch-title {
            font-weight: bold;
            color: #1e293b;
        }
        .batch-dates {
            color: #64748b;
            font-size: 9px;
            float: right;
        }

        /* CTA Footer Box */
        .cta-box {
            background-color: #f0fdf4;
            border: 1.5px solid #86efac;
            border-radius: 6px;
            padding: 10px 14px;
            margin-top: 14px;
            margin-bottom: 12px;
        }
        .cta-title {
            font-size: 12px;
            font-weight: bold;
            color: #166534;
            margin: 0 0 3px 0;
        }
        .cta-desc {
            font-size: 9.5px;
            color: #15803d;
            margin: 0;
            line-height: 1.4;
        }

        /* Document Footer */
        .doc-footer {
            border-top: 1px solid #cbd5e1;
            padding-top: 8px;
            margin-top: 12px;
            font-size: 8.5px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    @php
        $logoPath = public_path('images/brand/logo.png');
        $logoSrc = '';
        if (file_exists($logoPath)) {
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoSrc = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        // Determine specific details based on slug/name
        $slug = $program->slug;
        $name = strtolower($program->name);
        
        $tagline = $program->period;
        $desc = $program->description;
        $targets = ['Mahasiswa', 'Pendaftar Beasiswa', 'Australia WHV', 'Profesional'];
        $durasi = '8 - 12 Minggu';
        $pertemuan = '16 - 24 Meeting';
        $lamaBelajar = '90 Menit / Sesi';
        $targetSkor = 'Sesuai Target';
        $facilities = [
            'Kurikulum Terstruktur berbasis target skor',
            'Pengajar Profesional & Tersertifikasi',
            'Modul & Materi Latihan Digital Terupdate',
            'Placement Test & Simulasi Tes Rutin',
            'Progress Report Evaluasi Berkala',
            'Rekaman Kelas (Khusus Online)',
            'Sertifikat Kelulusan Resmi',
            'Konsultasi Tutor & Sesi Tanya Jawab'
        ];

        if ($slug === 'ielts-academic-full-package' || str_contains($name, 'ielts academic')) {
            $tagline = $tagline ?: 'Tembus skor IELTS 6.5+ untuk kuliah dan beasiswa luar negeri.';
            $desc = $desc ?: 'Kelas intensif yang dirancang khusus untuk memahami strategi pengerjaan seluruh modul IELTS (Listening, Reading, Writing, Speaking) agar mencapai target band impian.';
            $targets = ['Mahasiswa S1/S2', 'Pendaftar LPDP / AAS / Chevening', 'Australia WHV', 'Profesional Global'];
            $durasi = '8 - 12 Minggu';
            $pertemuan = '16 - 24 Meeting';
            $targetSkor = 'Band 6.5 - 7.5+';
            $facilities = [
                'Pembahasan 4 Keterampilan: Listening, Reading, Writing, Speaking',
                'Simulasi IELTS Cambridge Authentic Test',
                'Koreksi Writing Task 1 & Task 2 dengan Feedback Detail',
                'Mock Speaking 1-on-1 dengan Format Standar Examiner',
                'Modul Lengkap, Audio Files, & Pembahasan Kunci Jawaban',
                'Progress Report & Sertifikat Resmi Target Bahasa'
            ];
        } elseif ($slug === 'toefl-itp' || str_contains($name, 'toefl itp')) {
            $tagline = $tagline ?: 'Capai skor TOEFL 500+ dengan strategi cepat dan akurat.';
            $desc = $desc ?: 'Dirancang untuk menaklukkan soal-soal TOEFL ITP dengan metode terstruktur, fokus pada pola soal yang paling sering muncul di sesi Listening, Structure & Written Expression, serta Reading.';
            $targets = ['Mahasiswa S1/S2', 'Syarat Sidang & Wisuda', 'Seleksi CPNS / BUMN', 'Karier Perusahaan'];
            $durasi = '8 - 12 Minggu';
            $pertemuan = '16 - 24 Meeting';
            $targetSkor = '450 - 600+';
            $facilities = [
                'Bedah Tuntas Pola Soal Listening, Structure, & Reading',
                'Simulasi TOEFL ITP dengan Prediksi Skor Akurat',
                'Trik Pengerjaan Cepat Tanpa Menghabiskan Waktu',
                'Modul Digital Eksklusif & Bank Soal Ribuan Nomor',
                'Progress Report & Sertifikat Resmi Target Bahasa'
            ];
        } elseif ($slug === 'toefl-ibt' || str_contains($name, 'toefl ibt')) {
            $tagline = $tagline ?: 'Taklukkan tes berbasis internet secara komprehensif.';
            $desc = $desc ?: 'Dirancang untuk menghadapi format terbaru TOEFL iBT dengan strategi efektif di 4 skill: Reading, Listening, Speaking, dan Writing terintegrasi.';
            $targets = ['Kuliah Luar Negeri (USA/Kanada/Eropa)', 'Beasiswa LPDP / Fulbright', 'Syarat Kerja Global'];
            $durasi = '4 - 8 Minggu';
            $pertemuan = '12 - 20 Meeting';
            $targetSkor = '80 - 100+';
            $facilities = [
                'Latihan Soal Sesuai Format Software Resmi TOEFL iBT',
                'Template Writing & Speaking Terstruktur',
                'Analisis Kecepatan Mengetik dan Speaking Notes',
                'Simulasi Komprehensif dengan Feedback Tutor',
                'Modul Digital & Sertifikat Resmi'
            ];
        } elseif ($slug === 'ielts-general' || str_contains($name, 'ielts general')) {
            $tagline = $tagline ?: 'Persiapan matang untuk migrasi, visa kerja, dan karier global.';
            $desc = $desc ?: 'Fokus pada format tes General Training dengan latihan intensif Letters writing, General Reading passages, Listening, dan Speaking.';
            $targets = ['Australia WHV', 'Migrasi / Permanent Resident (PR)', 'Visa Kerja Luar Negeri', 'Profesional'];
            $durasi = '8 - 12 Minggu';
            $pertemuan = '16 - 24 Meeting';
            $targetSkor = 'Band 6.0 - 7.0+';
            $facilities = [
                'Fokus Khusus General Training: Letters & Everyday Reading',
                'Template Formal & Semi-Formal Letters',
                'Simulasi General Training Test Lengkap',
                'Feedback Koreksi Writing & Speaking Interaktif',
                'Modul Digital & Sertifikat Resmi'
            ];
        } elseif ($slug === 'pte-academic' || str_contains($name, 'pte academic')) {
            $tagline = $tagline ?: 'Strategi jitu taklukkan algoritma Pearson PTE dengan skor 65+.';
            $desc = $desc ?: 'Pelajari pola penilaian AI Pearson dan kuasai template teruji untuk Speaking, Writing, Reading, & Listening.';
            $targets = ['Australia WHV', 'Visa Kerja Australia / New Zealand', 'Studi S1/S2 Luar Negeri', 'Pendaftar Beasiswa'];
            $durasi = '4 - 8 Minggu';
            $pertemuan = '12 - 20 Meeting';
            $targetSkor = '58 - 79+ (B2 - C1)';
            $facilities = [
                'Pemahaman Mendalam Algoritma Penilaian AI Pearson',
                'Template Teruji untuk Read Aloud, Repeat Sentence, Essay, SST, WFD',
                'Simulasi PTE dengan Real Exam Question Bank',
                'Evaluasi Pengucapan (Pronunciation) & Oral Fluency',
                'Modul Digital & Sertifikat Resmi'
            ];
        } else {
            $tagline = $tagline ?: 'Program intensif dengan metode belajar terstruktur dan teruji.';
            $desc = $desc ?: 'Program pembelajaran yang dirancang untuk meningkatkan keterampilan bahasa Inggris secara terukur, efektif, dan aplikatif sesuai kebutuhan Anda.';
            if ($program->min_cefr_level || $program->max_cefr_level) {
                $targetSkor = trim(($program->min_cefr_level ?? '') . ' - ' . ($program->max_cefr_level ?? ''), ' -');
            }
        }

        // Prices
        $pRegularOnline = ($program->price ?? 0) > 0 ? $program->price : 1999000;
        $pSemiOnline = ($program->price_semi_private ?? 0) > 0 ? $program->price_semi_private : 2499000;
        $pPrivOnline = ($program->price_private ?? 0) > 0 ? $program->price_private : 3499000;

        $pRegularOffline = ($program->price_offline ?? 0) > 0 ? $program->price_offline : $pRegularOnline;
        $pSemiOffline = ($program->price_semi_private_offline ?? 0) > 0 ? $program->price_semi_private_offline : $pSemiOnline;
        $pPrivOffline = ($program->price_private_offline ?? 0) > 0 ? $program->price_private_offline : $pPrivOnline;

        $activeBatches = $program->classPeriods ? $program->classPeriods->filter(fn($b) => in_array($b->status, ['active', 'upcoming']) && (!$b->end_date || \Carbon\Carbon::parse($b->end_date)->endOfDay()->gte(now()->startOfDay())))->sortBy('start_date')->take(3) : collect();
    @endphp

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="55%">
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" alt="Target Bahasa Logo" class="logo-img">
                @else
                    <div style="font-size:18px; font-weight:bold; color:#0d47a1;">TARGET BAHASA</div>
                @endif
                <div class="org-tagline">English Skills. Global Success.</div>
            </td>
            <td width="45%" class="contact-box">
                <strong>BROSUR RESMI PROGRAM KURSUS</strong><br>
                Website: <strong>targetbahasa.com</strong><br>
                WhatsApp: <strong>+62 857-0661-5607</strong><br>
                Email: <strong>info@targetbahasa.com</strong>
            </td>
        </tr>
    </table>

    <!-- Banner -->
    <div class="banner">
        <div class="banner-mode">PROGRAM KELAS {{ strtoupper($mode ?? 'ONLINE & OFFLINE') }}</div>
        <div class="banner-title">{{ strtoupper($program->name) }}</div>
        @if($tagline)
            <div class="banner-subtitle">"{{ $tagline }}"</div>
        @endif
    </div>

    <!-- Overview -->
    <div class="section-title">Ringkasan Program</div>
    <div class="overview-box">
        <p class="overview-text">{{ $desc }}</p>
        <div class="target-chips">
            <span style="font-size: 8.5px; font-weight: bold; color: #64748b; margin-right: 4px;">COCOK UNTUK:</span>
            @foreach($targets as $t)
                <span class="chip">{{ $t }}</span>
            @endforeach
        </div>
    </div>

    <!-- Specs Grid -->
    <div class="section-title">Spesifikasi Kelas</div>
    <table class="specs-table">
        <tr>
            <td>
                <span class="spec-label">Durasi</span>
                <span class="spec-value">{{ $durasi }}</span>
            </td>
            <td>
                <span class="spec-label">Jumlah Pertemuan</span>
                <span class="spec-value">{{ $pertemuan }}</span>
            </td>
            <td>
                <span class="spec-label">Lama Belajar</span>
                <span class="spec-value">{{ $lamaBelajar }}</span>
            </td>
            <td>
                <span class="spec-label">Target Level / Skor</span>
                <span class="spec-value">{{ $targetSkor }}</span>
            </td>
        </tr>
    </table>

    <!-- Two Column: Facilities & Pricing/Schedule -->
    <table class="two-col-table">
        <tr>
            <!-- Left Column: Facilities -->
            <td width="48%">
                <div class="section-title" style="margin-top:0;">Fasilitas & Keunggulan</div>
                <ul class="facility-list">
                    @foreach($facilities as $f)
                        <li class="facility-item">
                            <span class="facility-bullet">[v]</span> {{ $f }}
                        </li>
                    @endforeach
                </ul>

                @if($activeBatches->isNotEmpty())
                    <div class="section-title" style="margin-top:14px;">Jadwal Batch Terdekat</div>
                    @foreach($activeBatches as $batch)
                        <div class="batch-box">
                            <span class="batch-title">{{ $batch->name }}</span>
                            <span class="batch-dates">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}</span>
                        </div>
                    @endforeach
                @endif
            </td>

            <!-- Right Column: Investment / Pricing -->
            <td width="52%">
                <div class="section-title" style="margin-top:0;">Pilihan Kelas & Investasi Biaya</div>
                <table class="price-table">
                    <thead>
                        <tr>
                            <th>Tipe Kelas</th>
                            <th>Online</th>
                            <th>Offline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Regular (Group)</strong><br>
                                <span style="font-size: 8.5px; color:#64748b;">Belajar interaktif berkelompok</span>
                            </td>
                            <td class="price-highlight">
                                {{ $pRegularOnline > 0 ? 'Rp ' . number_format($pRegularOnline, 0, ',', '.') : 'Hubungi Admin' }}
                            </td>
                            <td class="price-highlight">
                                {{ $pRegularOffline > 0 ? 'Rp ' . number_format($pRegularOffline, 0, ',', '.') : 'Hubungi Admin' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Semi Private</strong><br>
                                <span style="font-size: 8.5px; color:#64748b;">Grup kecil 2-3 orang</span>
                            </td>
                            <td class="price-highlight">
                                {{ $pSemiOnline > 0 ? 'Rp ' . number_format($pSemiOnline, 0, ',', '.') : 'Hubungi Admin' }}
                            </td>
                            <td class="price-highlight">
                                {{ $pSemiOffline > 0 ? 'Rp ' . number_format($pSemiOffline, 0, ',', '.') : 'Hubungi Admin' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Private (1-on-1)</strong><br>
                                <span style="font-size: 8.5px; color:#64748b;">Fokus penuh & jadwal fleksibel</span>
                            </td>
                            <td class="price-highlight">
                                {{ $pPrivOnline > 0 ? 'Rp ' . number_format($pPrivOnline, 0, ',', '.') : 'Hubungi Admin' }}
                            </td>
                            <td class="price-highlight">
                                {{ $pPrivOffline > 0 ? 'Rp ' . number_format($pPrivOffline, 0, ',', '.') : 'Hubungi Admin' }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Call to action info -->
                <div class="cta-box">
                    <div class="cta-title">Pendaftaran & Konsultasi Kelas</div>
                    <p class="cta-desc">
                        1. Kunjungi link: <strong>targetbahasa.com/daftar?program_id={{ $program->id }}</strong><br>
                        2. Atau chat Admin via WhatsApp: <strong>+62 857-0661-5607</strong><br>
                        3. Dapatkan Free Placement Test untuk mengetahui level awal Anda!
                    </p>
                </div>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="doc-footer">
        Hak Cipta &copy; {{ date('Y') }} Target Bahasa. Dokumen ini adalah brosur informasi resmi program kursus Target Bahasa.<br>
        Informasi biaya, kurikulum, dan jadwal dapat diperbarui sewaktu-waktu sesuai ketentuan lembaga.
    </div>

</body>
</html>
@endif
