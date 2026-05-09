<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Target Bahasa - Online English Course & Free Test</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/test-selection-modern.css') }}">
</head>

<body>


<style>
    .marquee-container {
        flex-grow: 1;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
        margin: 0 30px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 30px;
        padding: 6px 0;
        display: flex;
        align-items: center;
    }
    .marquee-content {
        display: inline-block;
        padding-left: 100%;
        animation: marquee 25s linear infinite;
        color: #fff;
        font-weight: 500;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
    }
    .marquee-content:hover {
        animation-play-state: paused;
    }
    @keyframes marquee {
        0% { transform: translate(0, 0); }
        100% { transform: translate(-100%, 0); }
    }
</style>
<!-- HEADER FIXED -->
<div style="position: fixed; top: 0; left: 0; width: 100%; display:flex; justify-content:space-between; align-items:center; padding: 5px 30px; z-index: 9999; backdrop-filter: blur(10px); background: rgba(13, 71, 161, 0.95); border-bottom: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <div class="logo">
        <img src="/images/logo.png" alt="Target Bahasa" style="height: 110px; width: auto; margin-top: -20px; margin-bottom: -50px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
    </div>
    <div class="marquee-container">
        <div class="marquee-content">
            {!! setting('header_running_text', '🚀 <strong>PROMO SPESIAL!</strong> Dapatkan Diskon 20% untuk Pendaftaran Kelas IELTS & TOEFL Bulan Ini! | 📝 <strong>IKUTI MOCKUP TEST!</strong> Uji Kemampuan Bahasa Inggrismu dengan Standar Internasional Sekarang Juga! | 🎓 Tingkatkan Karirmu dengan Sertifikat Target Bahasa!') !!}
        </div>
    </div>

    <div style="display:flex; gap:12px; flex-shrink: 0;">
        <a href="{{ route('student.login') }}" style="color:#fff; font-weight:600; border-radius:50px; border: 1px solid rgba(255,255,255,0.4); padding:8px 20px; text-decoration:none; display:flex; align-items:center; gap:8px; background: rgba(255,255,255,0.1); transition: all 0.3s;"><i class="fas fa-graduation-cap"></i> Student Login</a>
        <a href="{{ route('teacher.login') }}" style="color:#fff; font-weight:600; border-radius:50px; border: 1px solid rgba(255,255,255,0.4); padding:8px 20px; text-decoration:none; display:flex; align-items:center; gap:8px; background: rgba(255,255,255,0.1); transition: all 0.3s;"><i class="fas fa-chalkboard-teacher"></i> Teacher Login</a>
        <a href="{{ route('guest.login') }}" style="background:#FFB800; color:#1e293b; font-weight:800; border-radius:50px; padding:8px 20px; text-decoration:none; display:flex; align-items:center; gap:8px; transition: all 0.3s;"><i class="fas fa-user"></i> Guest Access</a>
    </div>
</div>

<!-- HERO SECTION MODERN-->
<section style="background: #0d47a1; color:#fff; padding:130px 0 100px 0; min-height: 90vh; position: relative;">
    <div class="container" style="max-width:900px; margin:0 auto; text-align:center; position:relative; z-index:10;">
        
        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap; margin-bottom:24px;">
            <span style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius:50px; padding:8px 24px; font-size:1rem; font-weight:600; display:flex; align-items:center; gap:8px;"><span style="color:#FFB800;">⭐</span> 4.9/5 dari 1000+ peserta</span>
            <span style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius:50px; padding:8px 24px; font-size:1rem; font-weight:600; display:flex; align-items:center; gap:8px;"><span style="color:#fff;">🎓</span> Dipakai pelamar WHV & Beasiswa</span>
            <span style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius:50px; padding:8px 24px; font-size:1rem; font-weight:600; display:flex; align-items:center; gap:8px;"><span style="color:#FFB800;">⚡</span> Skor keluar dalam 1x test</span>
        </div>

        <h1 style="font-size:3.5rem; font-weight:900; margin-bottom:20px; line-height: 1.2; letter-spacing: -1px; color: #ffffff; text-shadow: 0 4px 10px rgba(0,0,0,0.1);">Cek Skor IELTS, TOEFL, PTE<br>Kamu <span style="color: #FFB800;">Gratis</span></h1>
        
        <p style="font-size:1.15rem; margin-bottom:30px; color:#f8fafc; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            Tanpa daftar ribet. Langsung tahu levelmu dalam 10–20 menit dengan <strong>Hasil Instan +<br>Rekomendasi Kelas Otomatis.</strong>
        </p>
        
        <div style="margin-bottom:30px; display: flex; justify-content: center;">
            <span style="display:inline-block; background:transparent; border: 1px dashed rgba(255,255,255,0.5); color:#fff; padding:12px 24px; border-radius:8px; font-weight:600; font-size:1rem;">
                <i class="fas fa-exclamation-triangle" style="color:#fff; margin-right:6px;"></i> Tanpa tahu skor asli, kamu berisiko salah pilih kelas dan buang waktu.
            </span>
        </div>
        
        <a href="#form-test" style="display:inline-block; background: #FFB800; color: #1e293b; font-weight:800; border-radius:8px; padding:18px 42px; font-size:1.2rem; text-decoration:none; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: transform 0.3s ease;">🎯 DAPATKAN SKOR SAYA SEKARANG</a>
    </div>
</section>

<!-- TEST SELECTION MODERN -->
<section style="background:#f8fafc; padding:60px 0 40px 0;">
    <div class="container" style="max-width:1100px; margin:0 auto; text-align:center;">
        <h2 style="font-size:2.1rem; font-weight:800; margin-bottom:10px; color:#1e293b;">Pilih Test Gratis Kamu</h2>
        <p class="section-subtitle" style="font-size:1.1rem; color:#64748B; margin-bottom:18px;">Dapatkan hasil instan dan ketahui levelmu yang sebenarnya</p>
        <div style="margin-bottom:24px;">
            <span style="display:inline-block; background:#fff3cd; color:#856404; padding:8px 18px; border-radius:8px; font-weight:700; font-size:1rem;">🔥 Sudah 1.247 peserta mengikuti test minggu ini</span>
        </div>
        <div style="position:relative; max-width:1100px; margin:0 auto;">
            <button class="test-carousel-btn left" onclick="document.getElementById('free-test-track').scrollBy({left:-350, behavior:'smooth'})" aria-label="Scroll left">&#8249;</button>
            <div id="free-test-track" class="test-selection-carousel">
            <!-- Card 1 -->
            <div class="hover-lift test-card-item" style="background:#fff; border-radius:18px; box-shadow:0 4px 18px rgba(0,0,0,0.07); padding:32px 20px 28px 20px; display:flex; flex-direction:column; align-items:center;">
                <div style="font-size:2.2rem; color:#2563eb; margin-bottom:10px;"><i class="fas fa-graduation-cap"></i></div>
                <div style="font-weight:800; font-size:1.15rem; margin-bottom:6px; color:#1e293b;">TOEFL ITP <span style="background:#22c55e; color:#fff; font-size:0.85rem; font-weight:700; border-radius:8px; padding:2px 10px; margin-left:6px;">GRATIS</span></div>
                <div style="color:#64748B; font-size:0.98rem; margin-bottom:10px;">Syarat kelulusan kampus, melamar CPNS, atau kerja di perusahaan BUMN/Lokal.</div>
                <div style="color:#64748B; font-size:0.98rem; margin-bottom:10px;"><i class="fas fa-clock"></i> 15 Menit Simulasi</div>
                <a href="/form-test?type=toefl" class="hover-glow-btn" style="display:inline-block; background:#2563eb; color:#fff; font-weight:700; border-radius:8px; padding:10px 0; width:100%; text-decoration:none; margin-top:10px;">🎯 Mulai Test TOEFL Gratis</a>
            </div>
            <!-- Card 2 -->
            <div class="hover-lift test-card-item" style="background:#fff; border-radius:18px; box-shadow:0 4px 18px rgba(0,0,0,0.07); padding:32px 20px 28px 20px; display:flex; flex-direction:column; align-items:center;">
                <div style="font-size:2.2rem; color:#1d4ed8; margin-bottom:10px;"><i class="fas fa-book"></i></div>
                <div style="font-weight:800; font-size:1.15rem; margin-bottom:6px; color:#1e293b;">IELTS Academic <span style="background:#22c55e; color:#fff; font-size:0.85rem; font-weight:700; border-radius:8px; padding:2px 10px; margin-left:6px;">GRATIS</span></div>
                <div style="color:#64748B; font-size:0.98rem; margin-bottom:10px;">Daftar kuliah di luar negeri (Study Abroad) atau beasiswa internasional (AAS, LPDP).</div>
                <div style="color:#64748B; font-size:0.98rem; margin-bottom:10px;"><i class="fas fa-clock"></i> 20 Menit Simulasi</div>
                <a href="/form-test?type=ielts-academic" class="hover-glow-btn" style="display:inline-block; background:#2563eb; color:#fff; font-weight:700; border-radius:8px; padding:10px 0; width:100%; text-decoration:none; margin-top:10px;">🎯 Cek Skor IELTS Sekarang</a>
            </div>
            <!-- Card 3 -->
            <div class="hover-lift test-card-item" style="background:#fff; border-radius:18px; box-shadow:0 4px 18px rgba(0,0,0,0.07); padding:32px 20px 28px 20px; display:flex; flex-direction:column; align-items:center; position:relative;">
                <div style="position:absolute; top:18px; right:-18px; background:#F97316; color:#fff; font-size:0.85rem; font-weight:800; border-radius:8px; padding:4px 18px; transform:rotate(15deg); box-shadow:0 2px 8px rgba(249,115,22,0.13);">PALING POPULER</div>
                <div style="font-size:2.2rem; color:#0A58CA; margin-bottom:10px;"><i class="fas fa-globe"></i></div>
                <div style="font-weight:800; font-size:1.15rem; margin-bottom:6px; color:#1e293b;">IELTS General</div>
                <div style="color:#64748B; font-size:0.98rem; margin-bottom:10px;">Visa Kerja (WHV Australia), migrasi, atau training.</div>
                <div style="color:#64748B; font-size:0.98rem; margin-bottom:10px;"><i class="fas fa-clock"></i> 20 Menit Simulasi</div>
                <a href="/form-test?type=ielts-general" class="hover-glow-btn" style="display:inline-block; background:#2563eb; color:#fff; font-weight:700; border-radius:8px; padding:10px 0; width:100%; text-decoration:none; margin-top:10px;">🎯 Cek Skor IELTS Sekarang</a>
            </div>
            <!-- Card 4 -->
            <div class="hover-lift test-card-item" style="background:#fff; border-radius:18px; box-shadow:0 4px 18px rgba(0,0,0,0.07); padding:32px 20px 28px 20px; display:flex; flex-direction:column; align-items:center;">
                <div style="font-size:2.2rem; color:#0A58CA; margin-bottom:10px;"><i class="fas fa-laptop"></i></div>
                <div style="font-weight:800; font-size:1.15rem; margin-bottom:6px; color:#1e293b;">PTE Academic <span style="background:#22c55e; color:#fff; font-size:0.85rem; font-weight:700; border-radius:8px; padding:2px 10px; margin-left:6px;">GRATIS</span></div>
                <div style="color:#64748B; font-size:0.98rem; margin-bottom:10px;">Alternatif IELTS untuk WHV Australia atau studi UK/Aus dengan sistem komputer.</div>
                <div style="color:#64748B; font-size:0.98rem; margin-bottom:10px;"><i class="fas fa-clock"></i> 15 Menit Simulasi</div>
                <a href="/form-test?type=pte" class="hover-glow-btn" style="display:inline-block; background:#2563eb; color:#fff; font-weight:700; border-radius:8px; padding:10px 0; width:100%; text-decoration:none; margin-top:10px;">🎯 Mulai Test PTE Gratis</a>
            </div>
            </div>
            <button class="test-carousel-btn right" onclick="document.getElementById('free-test-track').scrollBy({left:350, behavior:'smooth'})" aria-label="Scroll right">&#8250;</button>
        </div>
    </div>
</section>

<section class="problems bg-light">
    <div class="container">
        <div class="problem-content text-center">
            <h2>Pernah Berada di Situasi Ini?</h2>
            
            <div class="grid-3 problem-boxes">
                <div class="problem-box">
                    <i class="fas fa-question-circle"></i>
                    <p>Tidak tahu skor saat ini dan <strong>bingung harus mulai belajar dari level mana?</strong></p>
                </div>
                <div class="problem-box">
                    <i class="fas fa-briefcase"></i>
                    <p>Ingin cari kerja dengan gaji Dollar di luar negeri tapi <strong>takut bahasa Inggrismu belum cukup?</strong></p>
                </div>
                <div class="problem-box">
                    <i class="fas fa-frown"></i>
                    <p>Sering merasa <strong>tidak percaya diri</strong> jika disuruh ngobrol atau interview bahasa Inggris?</p>
                </div>
            </div>

            <div class="problem-solution-trigger">
                <h3>👉 Solusinya: Mulai dari Test Gratis untuk tahu level kamu secara presisi!</h3>
                <a href="#form-test" class="btn-primary-large">Ambil Test Sekarang</a>
            </div>
        </div>
    </div>
</section>

<!-- 4. SOLUSI (FLOW SYSTEM) -->
<section class="flow-system">
    <div class="container text-center">
        <h2>Sistem Belajar Cerdas Kami</h2>
        <p class="section-subtitle">Kami memastikan rute belajarmu tepat sasaran, hemat waktu & biaya</p>
        
        <div class="flow-steps">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-icon"><i class="fas fa-file-alt"></i></div>
                <h4>Ambil Test Gratis</h4>
                <p>Pilih test sesuai target.</p>
            </div>
            <div class="step-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>
            <div class="step active-step">
                <div class="step-number">2</div>
                <div class="step-icon"><i class="fas fa-bolt text-yellow"></i></div>
                <h4>Dapat Skor Instan</h4>
                <p>Hasil akurat keluar saat itu juga.</p>
            </div>
            <div class="step-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-icon"><i class="fas fa-door-open"></i></div>
                <h4>Masuk Kelas Level Pas</h4>
                <p>Belajar sesuai rekomendasi.</p>
            </div>
            <div class="step-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-icon"><i class="fas fa-plane-departure"></i></div>
                <h4>Siap Kerja & Kuliah</h4>
                <p>Skor & skill tercapai.</p>
            </div>
        </div>
    </div>
</section>

<!-- NEW: AFTER TEST EXPERIENCE -->
<section class="after-test bg-light">
    <div class="container text-center">
        <h2>Apa yang Kamu Dapat Setelah Test?</h2>
        <p class="section-subtitle">Wah, ini bukan sekadar test biasa! Ini adalah gerbang belajarmu.</p>
        
        <div class="grid-3 mb-4">
            <div class="feature-box">
                <div class="fb-icon"><i class="fas fa-chart-pie"></i></div>
                <h4>1. Skor Akurat</h4>
                <p>Mengetahui persis berapa estimasi skor IELTS/TOEFL/PTE kamu saat ini tanpa nebak-nebak.</p>
            </div>
            <div class="feature-box">
                <div class="fb-icon"><i class="fas fa-signal"></i></div>
                <h4>2. Level Kemampuan</h4>
                <p>Pemetaan otomatis posisi bahasamu: Beginner, Intermediate, atau sudah Advanced.</p>
            </div>
            <div class="feature-box">
                <div class="fb-icon"><i class="fas fa-magic"></i></div>
                <h4>3. Rekomendasi Kelas</h4>
                <p>Sistem akan memberi saran cerdas kelas mana yang 100% cocok untuk menambal kelemahanmu.</p>
            </div>
        </div>
        <a href="#form-test" class="btn-primary-medium">Saya Mau Tahu Level Saya</a>
    </div>
</section>

<!-- 5. PROGRAM KELAS -->
<section class="programs" id="programs">
    <div class="container text-center">
        <h2>Butuh Kelas Langsung?</h2>
        <p class="section-subtitle">Tenang, ini program yang bisa kamu pilih <strong>setelah tahu skor kamu</strong></p>

        <!-- CAROUSEL WRAPPER -->
        <div class="programs-carousel-wrapper">
            <button class="carousel-btn carousel-prev" id="prog-prev" aria-label="Previous">&#8249;</button>

            <div class="programs-carousel-viewport" id="prog-viewport">
                <div class="programs-carousel-track" id="prog-track">
                    <div class="program-card card-beginner pricing-style">
                        <div class="card-top">
                            <div class="badge badge-beginner"><i class="fas fa-seedling"></i> Beginner</div>
                            <h3 class="card-title">Speaking Basic</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Membangun pondasi speaking dari nol agar berani bicara.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="/daftar" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('speaking_basic')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-intermediate pricing-style">
                        <div class="card-top">
                            <div class="badge badge-intermediate"><i class="fas fa-layer-group"></i> Intermediate</div>
                            <h3 class="card-title">Speaking Intermediate</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Memperlancar percakapan dengan grammar yang tepat.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="/daftar" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('speaking_intermediate')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-advanced pricing-style">
                        <div class="card-top">
                            <div class="badge badge-advanced"><i class="fas fa-graduation-cap"></i> Advanced</div>
                            <h3 class="card-title">Speaking Advanced</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Level mahir untuk presentasi dan diskusi profesional.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="/daftar" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('speaking_advanced')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-toefl pricing-style">
                        <div class="card-top">
                            <div class="badge badge-all"><i class="fas fa-certificate"></i> All Levels</div>
                            <h3 class="card-title">TOEFL ITP</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Kelas intensif mengejar target skor 550+ TOEFL ITP.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="/daftar" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('toefl_itp')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-ielts pricing-style">
                        <div class="popular-overlay"><i class="fas fa-fire" style="margin-right:5px;"></i>POPULAR</div>
                        <div class="card-top">
                            <div class="badge badge-advanced"><i class="fas fa-book-open"></i> Advanced</div>
                            <h3 class="card-title">IELTS Preparation</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Kuasai 4 skill spesifik IELTS untuk gapai band 7.0+.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="/daftar" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('ielts_prep')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-marlins pricing-style">
                        <div class="card-top">
                            <div class="badge badge-all"><i class="fas fa-anchor"></i> Special Purpose</div>
                            <h3 class="card-title">Marlins Test</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Bimbingan khusus pelaut kapal pesiar menembus skor tinggi.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="/daftar" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('marlins')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-btn carousel-next" id="prog-next" aria-label="Next">&#8250;</button>
        </div>

        <!-- DOT INDICATORS -->
        <div class="carousel-dots" id="prog-dots"></div>
    </div>
</section>

<style>
/* --- Pricing Card Style Carousel --- */
.pricing-style {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    border: none;
    padding: 0;
    position: relative;
    transition: all 0.3s ease;
}

.pricing-style:hover {
    transform: scale(1.05) translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    z-index: 2;
}

.pricing-style .card-top {
    padding: 2.5rem 1.5rem 2rem 1.5rem;
    text-align: center;
    color: #ffffff;
}

.pricing-style .card-bottom {
    background: transparent;
    padding: 2rem 1.5rem 2.5rem 1.5rem;
    flex: 1 1 auto;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: center;
}

.pricing-style .card-title {
    font-size: 1.8rem;
    font-weight: 800;
    margin: 0;
    letter-spacing: 0.5px;
    color: #ffffff !important;
}

.pricing-style .prog-desc {
    color: #1F2937;
    font-size: 1.05rem;
    margin-bottom: 2rem;
    margin-top: 1rem;
    line-height: 1.6;
}

.btn-pricing {
    display: block;
    width: 100%;
    background: #F97316;
    color: #ffffff !important;
    text-decoration: none;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 800;
    padding: 1rem 0;
    margin-top: auto;
    transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.25);
}

.btn-pricing:hover, .btn-pricing:focus {
    background: #ea580c;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
}

/* --- Colored Card Headers --- */
.card-beginner .card-top { background: #22C55E !important; }
.card-intermediate .card-top { background: #3B82F6 !important; }
.card-advanced .card-top { background: #8B5CF6 !important; }
.card-toefl .card-top { background: #F97316 !important; }
.card-ielts .card-top { background: #1D4ED8 !important; }
.card-marlins .card-top { background: #1E293B !important; }

/* Strip old program-card backgrounds since they are solid white now */
.card-beginner { background: #ffffff !important; }
.card-intermediate { background: #ffffff !important; }
.card-advanced { background: #ffffff !important; }
.card-toefl { background: #ffffff !important; }
.card-ielts { background: #ffffff !important; }
.card-marlins { background: #ffffff !important; }

/* Eliminate old program-card hover since pricing-style handles it */
.program-card {
    transition: all 0.3s ease;
}
.program-card:hover {
    box-shadow: none !important;
    transform: none !important;
}

/* --- Badges --- */
.pricing-style .badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: #ffffff;
    color: #1F2937;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}
.pricing-style .badge i {
    font-size: 1.2rem;
    margin: 0;
    display: block;
    color: inherit !important;
}

/* Popular Badge */
.popular-overlay {
    position: absolute;
    top: 15px;
    right: -35px;
    background: #F97316;
    color: #ffffff;
    padding: 5px 40px;
    font-size: 0.8rem;
    font-weight: 800;
    text-transform: uppercase;
    transform: rotate(45deg);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 10;
}

/* --- Button Animation --- */
.btn-anim { transition: background .2s, color .2s, box-shadow .2s, transform .2s; box-shadow: 0 1px 4px rgba(249,194,40,0.08); }
.btn-anim:hover, .btn-anim:focus { background: #f9c228; color: #fff; box-shadow: 0 4px 16px rgba(249,194,40,0.18); transform: scale(1.04); border-color: #f9c228; }
/* ── Programs Carousel ── */
.programs-carousel-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 2rem;
}
.programs-carousel-viewport {
    overflow: hidden;
    flex: 1;
    padding: 60px 10px;
    margin: -60px -10px;
    touch-action: pan-y;
}
.programs-carousel-track {
    display: flex;
    gap: 1.5rem;
    transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
    will-change: transform;
}

/* Card States & Center Focus */
.programs-carousel-track .program-card {
    flex: 0 0 calc((100% - 3rem) / 3);
    min-width: 0;
    transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
    transform: scale(0.92);
    opacity: 0.9;
    user-select: none;
    cursor: grab;
    pointer-events: auto;
}
.programs-carousel-track .program-card:active {
    cursor: grabbing;
}

@media (max-width: 900px) {
    .programs-carousel-track .program-card {
        flex: 0 0 calc((100% - 1.5rem) / 2);
    }
}
@media (max-width: 600px) {
    .programs-carousel-track .program-card {
        flex: 0 0 calc(100% - 3rem);
    }
}

/* Active Highlight */
.programs-carousel-track .program-card.is-active {
    transform: scale(1.06);
    opacity: 1;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    z-index: 5;
}

/* Hover Physics & Glow */
.programs-carousel-track .program-card:hover {
    opacity: 1;
    transform: scale(0.95) translateY(-6px);
}
.programs-carousel-track .program-card.is-active:hover {
    opacity: 1;
    transform: scale(1.06) translateY(-6px);
}
.program-card.card-beginner:hover { box-shadow: 0 20px 40px rgba(34, 197, 94, 0.4) !important; }
.program-card.card-intermediate:hover { box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4) !important; }
.program-card.card-advanced:hover { box-shadow: 0 20px 40px rgba(139, 92, 246, 0.4) !important; }
.program-card.card-toefl:hover { box-shadow: 0 20px 40px rgba(249, 115, 22, 0.4) !important; }
.program-card.card-ielts:hover { box-shadow: 0 20px 40px rgba(29, 78, 216, 0.4) !important; }
.program-card.card-marlins:hover { box-shadow: 0 20px 40px rgba(30, 41, 59, 0.4) !important; }

/* Micro-Interactions */
.program-card .popular-overlay {
    opacity: 0;
    transform: rotate(45deg) translateY(15px);
    transition: all 0.4s ease;
}
.program-card.is-active .popular-overlay {
    opacity: 1;
    transform: rotate(45deg) translateY(0);
    transition-delay: 0.1s;
}
.program-card .card-title {
    opacity: 0.8;
    transform: translateY(10px);
    transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
}
.program-card.is-active .card-title {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.1s;
}
.program-card .btn-pricing {
    opacity: 0.7;
    transform: translateY(10px);
    transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
}
.program-card.is-active .btn-pricing {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.2s;
}

/* Nav Buttons */
.carousel-btn {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 2px solid #e2e8f0;
    background: #ffffff;
    font-size: 1.6rem;
    line-height: 1;
    cursor: pointer;
    color: #333;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}
.carousel-btn:hover {
    background: #F97316;
    border-color: #F97316;
    color: #fff;
    transform: scale(1.1);
}

/* Indicator Dots */
.carousel-dots {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 2rem;
}
.carousel-dots .dot {
    width: 10px;
    height: 10px;
    border-radius: 10px;
    background: #cbd5e1;
    border: none;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    padding: 0;
}
.carousel-dots .dot.active {
    width: 28px;
    background: #F97316;
    box-shadow: 0 0 10px rgba(249, 115, 22, 0.5);
}
/* Brochure Modal & Button */
.btn-info-more {
    display: block;
    width: 100%;
    background: transparent;
    color: #475569;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1.05rem;
    font-weight: 700;
    padding: 0.8rem 0;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-info-more:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #cbd5e1;
}

.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}
.modal-box {
    background: #ffffff;
    border-radius: 24px;
    width: 90%;
    max-width: 500px;
    padding: 2.5rem 2rem;
    position: relative;
    transform: translateY(30px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
.modal-overlay.active .modal-box {
    transform: translateY(0) scale(1);
}
.modal-close-btn {
    position: absolute;
    top: 15px;
    right: 20px;
    background: none;
    border: none;
    font-size: 2rem;
    line-height: 1;
    cursor: pointer;
    color: #94a3b8;
    transition: color 0.2s;
}
.modal-close-btn:hover {
    color: #475569;
}
</style>

<script>
        // === Inline Editing Logic ===
        var isEditMode = false;
        var editTextBtn = document.getElementById('edit-text-btn');
        var editableEls = document.querySelectorAll('[data-editable]');
        // Load saved edits
        editableEls.forEach(function(el) {
            var key = 'editable-' + el.getAttribute('data-editable');
            var saved = localStorage.getItem(key);
            if(saved) el.innerHTML = saved;
        });
        function enableEditMode() {
            isEditMode = true;
            editableEls.forEach(function(el) {
                el.setAttribute('contenteditable', 'true');
                el.style.outline = '2px dashed #9333ea';
                el.style.cursor = 'text';
                el.title = 'Klik untuk edit';
            });
        }
        function disableEditMode() {
            isEditMode = false;
            editableEls.forEach(function(el) {
                el.removeAttribute('contenteditable');
                el.style.outline = '';
                el.style.cursor = '';
                el.title = '';
            });
        }
        function saveEdits() {
            editableEls.forEach(function(el) {
                var key = 'editable-' + el.getAttribute('data-editable');
                localStorage.setItem(key, el.innerHTML);
            });
        }
        if(editTextBtn) {
            editTextBtn.onclick = function() {
                if(!isEditMode) {
                    enableEditMode();
                    editTextBtn.textContent = 'Simpan Teks';
                } else {
                    saveEdits();
                    disableEditMode();
                    editTextBtn.textContent = 'Edit Teks';
                }
            };
        }
        // Disable edit mode if toolbar closed
        if(typeof closeBtn !== 'undefined' && closeBtn) {
            closeBtn.addEventListener('click', function() {
                if(isEditMode) {
                    disableEditMode();
                    if(editTextBtn) editTextBtn.textContent = 'Edit Teks';
                }
            });
        }
(function () {
    const track   = document.getElementById('prog-track');
    const prev    = document.getElementById('prog-prev');
    const next    = document.getElementById('prog-next');
    const dotsEl  = document.getElementById('prog-dots');
    
    // Infinite Loop Setup
    const originals = Array.from(track.querySelectorAll('.program-card'));
    const totalOrig = originals.length;
    
    // Append copies for seamless looping
    originals.forEach(card => {
        let cloneLast = card.cloneNode(true);
        cloneLast.classList.add('clone-node');
        track.appendChild(cloneLast);
    });
    // Prepend copies backward to preserve DOM order
    originals.slice().reverse().forEach(card => {
        let cloneFirst = card.cloneNode(true);
        cloneFirst.classList.add('clone-node');
        track.insertBefore(cloneFirst, track.firstChild);
    });

    const allCards = Array.from(track.querySelectorAll('.program-card'));
    let currentIndex = totalOrig; // start exactly at first original
    let isTransitioning = false;
    let cardWidth = 0;
    let gap = 0;

    function getVisibleCount() {
        const w = track.parentElement.clientWidth;
        if (w <= 600) return 1;
        if (w <= 900) return 2;
        return 3;
    }

    function updateMetrics() {
        cardWidth = allCards[0].offsetWidth;
        gap = parseFloat(getComputedStyle(track).gap) || 24;
    }

    function buildDots() {
        dotsEl.innerHTML = '';
        for (let i = 0; i < totalOrig; i++) {
            const dot = document.createElement('button');
            dot.className = 'dot';
            dot.setAttribute('aria-label', 'Slide ' + (i + 1));
            dot.addEventListener('click', () => goToIndex(i + totalOrig));
            dotsEl.appendChild(dot);
        }
    }

    function updateStates() {
        const vCount = getVisibleCount();
        let targetActive = currentIndex;
        if (vCount === 3) targetActive = currentIndex + 1;

        allCards.forEach((c, i) => {
            if (i === targetActive) {
                c.classList.add('is-active');
            } else {
                c.classList.remove('is-active');
            }
        });

        const realIndex = (currentIndex % totalOrig + totalOrig) % totalOrig;
        const dots = dotsEl.querySelectorAll('.dot');
        dots.forEach((d, i) => d.classList.toggle('active', i === realIndex));
    }

    function setTransform(idx, animate = true) {
        updateMetrics();
        const offset = -(idx * (cardWidth + gap));
        track.style.transition = animate ? 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)' : 'none';
        track.style.transform = `translate3d(${offset}px, 0, 0)`;
    }

    let transitionTimeout;

    function goToIndex(idx) {
        currentIndex = idx;
        setTransform(currentIndex, true);
        updateStates();
        
        isTransitioning = true;
        clearTimeout(transitionTimeout);
        // Loop boundary correction visually seamless
        transitionTimeout = setTimeout(() => {
            if (currentIndex >= totalOrig * 2) {
                currentIndex -= totalOrig;
                setTransform(currentIndex, false);
            } else if (currentIndex < totalOrig) {
                currentIndex += totalOrig;
                setTransform(currentIndex, false);
            }
            updateStates();
            isTransitioning = false;
        }, 500);
    }

    prev.addEventListener('click', () => { stopAutoPlay(); goToIndex(currentIndex - 1); startAutoPlay(); });
    next.addEventListener('click', () => { stopAutoPlay(); goToIndex(currentIndex + 1); startAutoPlay(); });

    // Click to focus card logic
    allCards.forEach((card, i) => {
        card.addEventListener('click', (e) => {
            if (wasDragged) return;
            if (e.target.closest('.btn-pricing') || e.target.closest('button') || e.target.closest('a')) return;
            
            const vCount = getVisibleCount();
            let targetActive = currentIndex;
            if (vCount === 3) targetActive = currentIndex + 1;
            
            const jump = i - targetActive;
            if (jump !== 0) {
                stopAutoPlay();
                goToIndex(currentIndex + jump);
                startAutoPlay();
            }
        });

        // Hover to center card logic
        if (window.matchMedia('(hover: hover)').matches) {
            card.addEventListener('mouseenter', () => {
                if (wasDragged) return;
                
                const vCount = getVisibleCount();
                let targetActive = currentIndex;
                if (vCount === 3) targetActive = currentIndex + 1;
                
                const jump = i - targetActive;
                if (jump !== 0) {
                    stopAutoPlay();
                    goToIndex(currentIndex + jump);
                }
            });
        }
    });

    // Intuitive Swipe & Drag Physics
    let isDragging = false, startX = 0, currentTranslate = 0, prevTranslate = 0;
    let wasDragged = false;
    
    function getX(e) { return e.type.includes('mouse') ? e.pageX : e.touches[0].clientX; }

    function touchStart(e) {
        if (isTransitioning) return;
        if (e.target.closest('button') || e.target.closest('a')) return;
        
        isDragging = true;
        wasDragged = false;
        stopAutoPlay();
        updateMetrics();
        startX = getX(e);
        prevTranslate = -(currentIndex * (cardWidth + gap));
        track.style.transition = 'none';
        
        if (e.type === 'mousedown') e.preventDefault();
    }
    
    function touchMove(e) {
        if (!isDragging) return;
        const diff = getX(e) - startX;
        if (Math.abs(diff) > 5) wasDragged = true;
        
        currentTranslate = prevTranslate + diff;
        track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
    }
    
    function touchEnd(e) {
        if (!isDragging) return;
        isDragging = false;
        
        if (!wasDragged) {
            startAutoPlay();
            return;
        }
        
        let diff = 0;
        if(e.type.includes('mouse')){
            diff = e.pageX - startX;
        } else {
            diff = e.changedTouches[0].clientX - startX;
        }

        let jump = Math.round(-diff / (cardWidth + gap));
        if (diff < -40 && jump === 0) jump = 1;
        if (diff > 40 && jump === 0) jump = -1;

        goToIndex(currentIndex + jump);
        startAutoPlay();
    }

    track.addEventListener('mousedown', touchStart);
    track.addEventListener('touchstart', touchStart, {passive: true});
    window.addEventListener('mouseup', touchEnd);
    window.addEventListener('touchend', touchEnd);
    window.addEventListener('mousemove', touchMove);
    window.addEventListener('touchmove', touchMove, {passive: true});

    let autoPlayTimer;
    function startAutoPlay() {
        stopAutoPlay();
        autoPlayTimer = setInterval(() => goToIndex(currentIndex + 1), 6000);
    }
    function stopAutoPlay() {
        clearInterval(autoPlayTimer);
    }

    const parent = track.parentElement;
    parent.addEventListener('mouseenter', stopAutoPlay);
    parent.addEventListener('mouseleave', startAutoPlay);
    parent.addEventListener('touchstart', stopAutoPlay, {passive: true});
    parent.addEventListener('touchend', startAutoPlay, {passive: true});

    // Run first frame
    setTimeout(() => {
        buildDots();
        setTransform(currentIndex, false);
        updateStates();
        startAutoPlay();
        // Force force browser redraw
        const dummy = track.offsetHeight;
    }, 100);

    window.addEventListener('resize', () => {
        updateMetrics();
        setTransform(currentIndex, false);
        updateStates();
    });
})();
</script>


<!-- 6. WHV OPPORTUNITY TRIGGER -->
<section class="whv-trigger text-center">
    <div class="container">
        <div class="whv-badge"><i class="fas fa-fire"></i> Peluang Emas Australia</div>
        <h2>Kerja di Australia dengan Gaji Dollar 💰</h2>
        
        <div class="whv-salary-box">
            <p>Estimasi Gaji Pekerja WHV:</p>
            <h3>Rp 30.000.000 – Rp 50.000.000 / Bulan</h3>
        </div>

        <p class="whv-req-title">Syarat Utama Bahasa Inggris (Salah Satu):</p>
        <div class="whv-req-box">
            <span><strong>IELTS</strong> Minimal 4.5</span>
            <span class="divider">/</span>
            <span><strong>PTE</strong> Minimal 30</span>
        </div>

        <p class="mt-3 text-white-70">Ayo cek apakah bahasamu sudah memenuhi standar untuk berangkat!</p>
        <a href="#form-test" class="btn-yellow-huge mt-3 pulse-anim">🎯 Cek Skor WHV Kamu Sekarang (Gratis)</a>
    </div>
</section>

<!-- 7. TESTIMONI -->
<section class="testimonials bg-light">
    <div class="container text-center">
        <h2>Hasil Nyata Siswa Kami</h2>
        <p class="section-subtitle">Mereka bermula dari Test Gratis, dan ini hasilnya.</p>
        
        <div class="grid-3">
            <div class="testimonial-card">
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="review">"Dari awalnya nggak tahu level saya, ambil tes gratis disini ternyata masuk beginner. Lanjut kelas Speaking intensif, <strong>IELTS pecah 6.5 dalam 2.5 bulan</strong>. Tutornya sabar banget!"</p>
                <div class="user-info">
                    <strong>Bima S.</strong> - <em>Pejuang Beasiswa AAS</em>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="review">"Awalnya takes tes gratis disini cuma penasaran. Direkomendasiin masuk kelas Speaking Intermediate. Dua bulan belajar, kemarin baru aja lolos interview di perusahaan Multinasional!"</p>
                <div class="user-info">
                    <strong>Rina M.</strong> - <em>Karyawan Swasta</em>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="review">"Rencana WHV Aussie hampir gagal karena males test PTE. Disini test PTE simulasi rasanya real banget. Setelah dipandu triknya, sukses dapat PTE 45. Berangkat!"</p>
                <div class="user-info">
                    <strong>Deri P.</strong> - <em>WHV Hunter</em>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. FORM CAPTURE (LEAD GENERATION) -->
<section class="form-capture bg-blue-grad" id="form-test">
    <div class="container text-center">
        <h2 class="text-white">Masukkan Data & Mulai Test Sekarang</h2>
        
        <div class="form-trust">
            <div class="trust-item"><i class="fas fa-shield-alt"></i> 100% Aman & Tanpa Spam.</div>
            <div class="trust-item"><i class="fas fa-paper-plane text-yellow"></i> Link Test dikirim ke WhatsApp dalam <strong>< 1 Menit</strong>.</div>
        </div>
        
        <form class="lead-form compact-form mt-4" action="{{ route('guest.register.submit') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="text-left mb-4" style="background:rgba(254, 226, 226, 0.96); color:#b91c1c; border:1px solid rgba(248, 113, 113, 0.35); border-radius:14px; padding:14px 16px;">
                    <div style="font-weight:800; margin-bottom:6px;">Periksa data Anda:</div>
                    <ul style="margin:0; padding-left:18px; font-size:0.92rem; line-height:1.6;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <label for="landing-name">Nama Anda</label>
            <input id="landing-name" type="text" name="name" placeholder="Budi Santoso" value="{{ old('name') }}" required>
            
            <label for="landing-email">Alamat Email</label>
            <input id="landing-email" type="email" name="email" placeholder="budi@example.com" value="{{ old('email') }}" required>
            
            <label for="landing-phone">Nomor WhatsApp Aktif</label>
            <input id="landing-phone" type="tel" name="phone_number" placeholder="08123456789" value="{{ old('phone_number') }}" required>
            
            <button type="submit" class="btn-yellow-huge w-100 scale-anim mt-3">🎯 MULAI TEST SEKARANG</button>
            <div class="text-center mt-3 text-muted" style="font-size: 0.85rem;">Setelah submit, akun guest Anda langsung dibuat dan siap dipakai untuk mulai tes.</div>
        </form>
    </div>
</section>


<!-- FOOTER -->
<footer>
    <div class="container">
        <h3>TARGET BAHASA</h3>
        <p>Jalan Brawijaya No. 64 Pare Kediri Jawa Timur</p>
        <p>© Target Bahasa 2026. Empowering Your English Journey.</p>
    </div>
</footer>

<!-- Floating Mobile CTA -->
<div class="floating-cta-mobile" style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
    <a href="https://wa.me/6285706615607" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;background:#25D366;color:#fff;padding:12px 24px;font-weight:500;border-radius:50px;text-decoration:none;box-shadow:0 6px 20px rgba(0,0,0,0.2);border:2px solid #fff;transition:all 0.3s;font-size:0.9rem;white-space:nowrap;">💬 Chat WhatsApp</a>
    <a href="/daftar" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;background:#FBBF24;color:#0F172A;padding:12px 24px;font-weight:500;border-radius:50px;text-decoration:none;box-shadow:0 6px 20px rgba(0,0,0,0.2);border:2px solid #fff;transition:all 0.3s;font-size:0.9rem;white-space:nowrap;">🎓 Mendaftar Kelas</a>
    <a href="#form-test" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;background:#EF4444;color:#fff;padding:12px 24px;font-weight:500;border-radius:50px;text-decoration:none;box-shadow:0 6px 20px rgba(0,0,0,0.2);border:2px solid #fff;transition:all 0.3s;font-size:0.9rem;white-space:nowrap;">🎯 Mulai Test Gratis Sekarang</a>
</div>

<!-- Free Test Carousel JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('free-test-track');
    if (!track) return;
    const cards = track.querySelectorAll('.test-card-item');
    const supportsHover = window.matchMedia('(hover: hover)').matches;

    function centerCard(card, behavior = 'smooth') {
        if (!card) return;

        const cardOffsetLeft = card.offsetLeft;
        const targetLeft = cardOffsetLeft - ((track.clientWidth - card.offsetWidth) / 2);
        const maxScrollLeft = Math.max(track.scrollWidth - track.clientWidth, 0);
        const nextScrollLeft = Math.min(Math.max(targetLeft, 0), maxScrollLeft);

        track.scrollTo({
            left: nextScrollLeft,
            behavior: behavior,
        });
    }
    
    function updateCenterCard() {
        const trackRect = track.getBoundingClientRect();
        const trackCenter = trackRect.left + trackRect.width / 2;
        
        let minDistance = Infinity;
        let centerCard = null;
        
        cards.forEach(card => {
            const cardRect = card.getBoundingClientRect();
            const cardCenter = cardRect.left + cardRect.width / 2;
            const distance = Math.abs(trackCenter - cardCenter);
            
            if (distance < minDistance) {
                minDistance = distance;
                centerCard = card;
            }
            card.classList.remove('is-center');
        });
        
        if (centerCard) {
            centerCard.classList.add('is-center');
        }
    }
    
    track.addEventListener('scroll', updateCenterCard, {passive: true});
    window.addEventListener('resize', updateCenterCard, {passive: true});

    if (supportsHover) {
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                centerCard(card, 'smooth');
            });
        });
    }
    
    setTimeout(updateCenterCard, 100);
});
</script>

<!-- Brochure Modal -->
<div id="brochure-modal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close-btn" onclick="closeBrochure()" aria-label="Tutup">&times;</button>
        <div style="text-align:center; margin-bottom:1.5rem;">
            <div style="width:60px; height:60px; background:#e0e7ff; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 15px auto; color:#4f46e5; font-size:1.8rem;">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3 id="brochure-title" style="font-size:1.6rem; font-weight:800; color:#1e293b; margin:0;">Program Title</h3>
        </div>
        <div id="brochure-desc" style="color:#475569; font-size:1.05rem; line-height:1.7; margin-bottom:2rem; text-align:center;">
            Description goes here.
        </div>
        <a href="/daftar" class="btn-pricing" style="text-align:center;">Daftar Kelas Sekarang</a>
    </div>
</div>

<script>
    // Brochure Modal Logic
    const brochureData = {
        'speaking_basic': {
            title: 'Speaking Basic',
            desc: 'Program Speaking Basic didesain khusus untuk pemula (Beginner) yang ingin membangun rasa percaya diri dalam berbicara bahasa Inggris. Anda akan belajar kosakata dasar, pelafalan yang benar, dan percakapan sehari-hari. Cocok untuk Anda yang masih terbata-bata atau takut salah saat berbicara.'
        },
        'speaking_intermediate': {
            title: 'Speaking Intermediate',
            desc: 'Program Speaking Intermediate ditujukan bagi Anda yang sudah memiliki dasar namun ingin memperlancar percakapan. Fokus pada perbaikan tata bahasa (grammar) saat berbicara secara spontan, memperluas kosakata, dan berlatih diskusi interaktif dalam berbagai konteks sosial maupun profesional.'
        },
        'speaking_advanced': {
            title: 'Speaking Advanced',
            desc: 'Program Speaking Advanced adalah kelas mahir (Advanced) untuk menyempurnakan kefasihan bahasa Inggris Anda. Sangat cocok bagi profesional atau mahasiswa yang membutuhkan kemampuan presentasi tingkat lanjut, negosiasi, debat, dan public speaking dengan tingkat akurasi tinggi.'
        },
        'toefl_itp': {
            title: 'TOEFL ITP Preparation',
            desc: 'Kelas intensif yang dirancang untuk mendongkrak skor TOEFL ITP Anda hingga 550+. Kami menyediakan strategi khusus untuk menaklukkan sesi Listening, Structure and Written Expression, serta Reading Comprehension secara efektif dan efisien.'
        },
        'ielts_prep': {
            title: 'IELTS Preparation',
            desc: 'Program persiapan komprehensif untuk mencapai skor ideal (Band 7.0+). Anda akan dibimbing menguasai keempat skill IELTS: Listening, Reading, Writing, dan Speaking dengan format tes terbaru dan simulasi rutin.'
        },
        'marlins': {
            title: 'Marlins Test Preparation',
            desc: 'Program bimbingan khusus bagi pelaut dan kru kapal pesiar. Membekali Anda dengan kemampuan bahasa Inggris maritim spesifik untuk lulus tes Marlins dengan skor tinggi, memperbesar peluang kerja di perusahaan pelayaran internasional.'
        }
    };

    window.openBrochure = function(id) {
        const data = brochureData[id];
        if(data) {
            document.getElementById('brochure-title').innerText = data.title;
            document.getElementById('brochure-desc').innerText = data.desc;
            document.getElementById('brochure-modal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };
    
    window.closeBrochure = function() {
        document.getElementById('brochure-modal').classList.remove('active');
        document.body.style.overflow = '';
    };

    // Close on overlay click
    document.getElementById('brochure-modal').addEventListener('click', function(e) {
        if(e.target === this) closeBrochure();
    });

</script>

</body>
</html>
