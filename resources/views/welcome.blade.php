<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Target Bahasa - Online English Course & Free Test</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/brand/icon.png') }}">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v=20260517">
    <link rel="stylesheet" href="{{ asset('css/test-selection-modern.css') }}?v=20260517">
</head>

<body>


<style>
    .landing-header {
        box-sizing: border-box;
    }

    .login-label-mobile {
        display: none;
    }

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
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        text-shadow: none;
    }
    .marquee-content:hover {
        animation-play-state: paused;
    }
    @keyframes marquee {
        0% { transform: translate(0, 0); }
        100% { transform: translate(-100%, 0); }
    }

    @media (max-width: 900px) {
        .landing-header {
            flex-wrap: wrap !important;
            justify-content: center !important;
            column-gap: 6px !important;
            row-gap: 0 !important;
            padding: 4px 10px 6px !important;
        }

        .landing-logo {
            width: 100%;
            display: flex;
            justify-content: center;
            line-height: 0;
            margin-bottom: 2px;
        }

        .landing-logo img {
            height: 56px !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .landing-header .marquee-container {
            display: none !important;
        }

        .landing-login-group {
            width: 100%;
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap;
            justify-content: center;
            padding: 0 4px;
        }

        .landing-login-group .login-btn {
            flex: 1 1 calc(33.333% - 6px);
            min-width: 100px;
            justify-content: center;
            height: 38px;
            padding: 7px 8px !important;
            font-size: 0.82rem;
            line-height: 1.2;
            white-space: nowrap;
            gap: 5px !important;
        }

        .landing-login-group .login-btn i {
            font-size: 0.9rem;
            margin: 0;
        }

        .login-label-desktop {
            display: none;
        }

        .login-label-mobile {
            display: inline;
        }

        .landing-hero {
            padding-top: 150px !important;
        }
    }
</style>
<!-- HEADER FIXED -->
<div class="landing-header" style="position: fixed; top: 0; left: 0; width: 100%; display:flex; justify-content:space-between; align-items:center; padding: 5px 30px; z-index: 9999; backdrop-filter: blur(10px); background: rgba(13, 71, 161, 0.95); border-bottom: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <div class="logo landing-logo">
        <img src="/images/brand/logo.png" alt="Target Bahasa" style="height: 110px; width: auto; margin-top: -20px; margin-bottom: -50px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
    </div>
    <div class="marquee-container">
        <div class="marquee-content">
            {!! setting('header_running_text', '🌟 <strong>Dari Kampung Inggris Pare, untuk Indonesia, menuju Dunia</strong> | 🚀 <strong>PROMO SPESIAL!</strong> Dapatkan Diskon 20% untuk Pendaftaran Kelas IELTS & TOEFL Bulan Ini! | 📝 <strong>IKUTI MOCKUP TEST!</strong> Uji Kemampuan Bahasa Inggrismu dengan Standar Internasional Sekarang Juga! | 🎓 Tingkatkan Karirmu dengan Sertifikat Target Bahasa!') !!}
        </div>
    </div>

    <div class="landing-login-group" style="display:flex; gap:12px; flex-shrink: 0;">
        <a href="{{ route('student.login') }}" class="login-btn" style="color:#fff; font-weight:600; border-radius:50px; border: 1px solid rgba(255,255,255,0.4); padding:8px 20px; text-decoration:none; display:flex; align-items:center; gap:8px; background: rgba(255,255,255,0.1); transition: all 0.3s;"><i class="fas fa-graduation-cap"></i><span class="login-label-desktop">Student Login</span><span class="login-label-mobile">Student</span></a>
        <a href="{{ route('teacher.login') }}" class="login-btn" style="color:#fff; font-weight:600; border-radius:50px; border: 1px solid rgba(255,255,255,0.4); padding:8px 20px; text-decoration:none; display:flex; align-items:center; gap:8px; background: rgba(255,255,255,0.1); transition: all 0.3s;"><i class="fas fa-chalkboard-teacher"></i><span class="login-label-desktop">Teacher Login</span><span class="login-label-mobile">Teacher</span></a>
        <a href="{{ route('guest.login') }}" class="login-btn" style="background:#FFB800; color:#1e293b; font-weight:800; border-radius:50px; padding:8px 20px; text-decoration:none; display:flex; align-items:center; gap:8px; transition: all 0.3s;"><i class="fas fa-user"></i><span class="login-label-desktop">Tamu (Guest)</span><span class="login-label-mobile">Guest</span></a>
    </div>
</div>

<!-- HERO SECTION MODERN-->
<section class="landing-hero" style="background: linear-gradient(rgba(13,71,161,0.50), rgba(13,71,161,0.50)), url('/images/hero/hero-background.png') center center / cover no-repeat; color:#fff; padding:130px 0 60px 0; position: relative;">
    <div class="container" style="max-width:900px; margin:0 auto; text-align:center; position:relative; z-index:10;">
        
        <!-- Jargon / Slogan Tagline -->
        <div style="margin-bottom: 20px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 50px; padding: 8px 26px; box-shadow: 0 4px 15px rgba(0,0,0,0.25);">
            <span style="font-size: 1.05rem; font-weight: 700; color: #ffffff; letter-spacing: 0.3px; text-shadow: 0 2px 4px rgba(0,0,0,0.6);">
                <span style="color: #FFB800;">📍</span> <em>Dari Kampung Inggris Pare, untuk Indonesia, menuju Dunia</em>
            </span>
        </div>

        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap; margin-bottom:24px;">
            <span style="background: rgba(0,0,0,0.45); backdrop-filter:blur(6px); border: 1px solid rgba(255,255,255,0.2); border-radius:50px; padding:8px 24px; font-size:1rem; font-weight:600; display:flex; align-items:center; gap:8px; text-shadow:0 1px 4px rgba(0,0,0,0.6);"><span style="color:#FFB800;">⭐</span> 4.9/5 dari 1000+ peserta</span>
            <span style="background: rgba(0,0,0,0.45); backdrop-filter:blur(6px); border: 1px solid rgba(255,255,255,0.2); border-radius:50px; padding:8px 24px; font-size:1rem; font-weight:600; display:flex; align-items:center; gap:8px; text-shadow:0 1px 4px rgba(0,0,0,0.6);"><span style="color:#fff;">🎓</span> Dipakai pelamar WHV & Beasiswa</span>
            <span style="background: rgba(0,0,0,0.45); backdrop-filter:blur(6px); border: 1px solid rgba(255,255,255,0.2); border-radius:50px; padding:8px 24px; font-size:1rem; font-weight:600; display:flex; align-items:center; gap:8px; text-shadow:0 1px 4px rgba(0,0,0,0.6);"><span style="color:#FFB800;">⚡</span> Skor keluar dalam 1x test</span>
        </div>

        <h1 style="font-size:3.5rem; font-weight:900; margin-bottom:20px; line-height: 1.2; letter-spacing: -1px; color: #ffffff; text-shadow: 0 3px 20px rgba(0,0,0,0.8), 0 1px 6px rgba(0,0,0,0.9);">Cek Skor IELTS, TOEFL, PTE<br>Kamu <span style="color: #FFB800; text-shadow: 0 3px 20px rgba(0,0,0,0.8);">Gratis</span></h1>
        
        <p style="font-size:1.15rem; margin-bottom:30px; color:#ffffff; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.6; text-shadow: 0 2px 8px rgba(0,0,0,0.8);">
            Tanpa daftar ribet. Langsung tahu levelmu dalam 10–20 menit dengan <strong>Hasil Instan +<br>Rekomendasi Kelas Otomatis.</strong>
        </p>
        
        <div style="margin-bottom:30px; display: flex; justify-content: center;">
            <span style="display:inline-block; background:rgba(0,0,0,0.5); backdrop-filter:blur(6px); border: 1px dashed rgba(255,255,255,0.6); color:#fff; padding:12px 24px; border-radius:8px; font-weight:600; font-size:1rem; text-shadow:0 2px 6px rgba(0,0,0,0.8);">
                <i class="fas fa-exclamation-triangle" style="color:#FFB800; margin-right:6px;"></i> Tanpa tahu skor asli, kamu berisiko salah pilih kelas dan buang waktu.
            </span>
        </div>
        
        <a href="{{ route('guest.free-tests') }}" style="display:inline-block; background: #FFB800; color: #1e293b; font-weight:800; border-radius:8px; padding:18px 42px; font-size:1.2rem; text-decoration:none; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: transform 0.3s ease;">🎯 DAPATKAN SKOR SAYA SEKARANG</a>
    </div>
</section>

<!-- TEST SELECTION MODERN -->
<style>
/* ══ FREE TEST SECTION ══ */
.free-test-section {
    position: relative;
    background: linear-gradient(145deg, #0d1f6e 0%, #1e40af 40%, #1d6fbb 70%, #0284c7 100%);
    padding: 32px 0 0;
    overflow: hidden;
}

/* Glassmorphism orbs */
.ft-orb {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    filter: blur(60px);
}
.ft-orb-1 {
    width: 480px; height: 480px;
    background: radial-gradient(circle, rgba(96,165,250,0.22) 0%, transparent 70%);
    top: -120px; left: -80px;
    animation: ft-float 8s ease-in-out infinite;
}
.ft-orb-2 {
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(14,165,233,0.18) 0%, transparent 70%);
    bottom: 30px; right: -60px;
    animation: ft-float 10s ease-in-out infinite reverse;
}
.ft-orb-3 {
    width: 240px; height: 240px;
    background: radial-gradient(circle, rgba(251,191,36,0.12) 0%, transparent 70%);
    top: 40%; left: 45%;
    animation: ft-float 7s ease-in-out infinite 2s;
}
@keyframes ft-float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-20px) scale(1.06); }
}

/* Particle dots grid */
.free-test-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.14) 1px, transparent 1px);
    background-size: 36px 36px;
    pointer-events: none;
}

/* Floating sparkles */
.ft-sparkle {
    position: absolute;
    pointer-events: none;
    animation: ft-sparkle-anim 3s ease-in-out infinite;
    opacity: 0.5;
}
.ft-sparkle:nth-child(1)  { top: 12%; left: 8%;  animation-delay: 0s;   font-size: 1.2rem; }
.ft-sparkle:nth-child(2)  { top: 20%; right: 12%; animation-delay: 1s;   font-size: 0.9rem; }
.ft-sparkle:nth-child(3)  { top: 65%; left: 5%;  animation-delay: 1.5s; font-size: 1rem;   }
.ft-sparkle:nth-child(4)  { top: 55%; right: 8%; animation-delay: 0.5s; font-size: 1.4rem; }
.ft-sparkle:nth-child(5)  { top: 30%; left: 22%; animation-delay: 2s;   font-size: 0.8rem; }
@keyframes ft-sparkle-anim {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.4; }
    50%       { transform: translateY(-12px) scale(1.2); opacity: 0.9; }
}

/* Inner content wrapper */
.free-test-inner {
    position: relative;
    z-index: 2;
    max-width: 1100px;
    margin: 0 auto;
    padding: 44px 20px 0;
    text-align: center;
}

/* Badge */
.free-test-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(251,191,36,0.18);
    border: 1.5px solid rgba(251,191,36,0.5);
    color: #fde68a;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 16px;
}

/* Heading */
.free-test-heading {
    font-size: 2.6rem;
    font-weight: 900;
    color: #fff;
    margin-bottom: 10px;
    line-height: 1.2;
    text-shadow: 0 4px 24px rgba(0,0,0,0.3);
}
.free-test-heading span {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.free-test-subtitle {
    color: rgba(255,255,255,0.78);
    font-size: 1.05rem;
    margin-bottom: 22px;
    line-height: 1.6;
}

/* Counter badge */
.free-test-counter {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 50px;
    padding: 10px 22px;
    margin-bottom: 36px;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 600;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
}
.free-test-counter .counter-fire {
    font-size: 1.2rem;
    animation: pulse-fire 1.5s ease-in-out infinite;
}
@keyframes pulse-fire {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.25) rotate(-5deg); }
}
.free-test-counter strong { color: #fbbf24; }

/* Card overrides — glassmorphism cards on dark bg */
.free-test-section .test-card-item {
    background: rgba(255,255,255,0.96) !important;
    border: 1.5px solid rgba(255,255,255,0.4);
    box-shadow: 0 12px 40px rgba(0,0,0,0.25) !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease !important;
}
.free-test-section .test-card-item:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 24px 56px rgba(0,0,0,0.35) !important;
}
.free-test-section .test-card-item.is-center {
    box-shadow: 0 24px 60px rgba(0,0,0,0.35), 0 0 0 3px rgba(251,191,36,0.7) !important;
}

/* Carousel button overrides */
.free-test-section .test-carousel-btn {
    background: rgba(255,255,255,0.15) !important;
    backdrop-filter: blur(8px);
    border-color: rgba(255,255,255,0.35) !important;
    color: #fff !important;
}
.free-test-section .test-carousel-btn:hover {
    background: #fbbf24 !important;
    border-color: #fbbf24 !important;
    color: #1e293b !important;
}

/* Silhouette — wave bottom */
.free-test-silhouette {
    position: relative;
    width: 100%;
    line-height: 0;
    margin-top: 24px;
    z-index: 1;
}
.free-test-silhouette svg {
    display: block;
    width: 100%;
    height: 80px;
}

@media (max-width: 768px) {
    .free-test-heading { font-size: 1.8rem; }
    .ft-orb-1 { width: 280px; height: 280px; }
    .ft-orb-2 { width: 200px; height: 200px; }
    .ft-sparkle { display: none; }
}
</style>

@php
    $now = now();
    $activePromos = collect();

    // 1. Active Grammar Practice Topics
    $activeGrammarTopics = \App\Models\GrammarTopic::where('is_free_tier', true)
        ->where(function($q) use ($now) { $q->whereNull('promo_start')->orWhere('promo_start', '<=', $now); })
        ->where(function($q) use ($now) { $q->whereNull('promo_deadline')->orWhere('promo_deadline', '>=', $now); })
        ->orderBy('order')
        ->get();
    foreach ($activeGrammarTopics as $gt) {
        $activePromos->push((object)[
            'badge' => '🔥 PROMO EVENT',
            'title' => 'Grammar: ' . $gt->title,
            'desc' => $gt->desc ? \Illuminate\Support\Str::limit($gt->desc, 70) : 'Latihan grammar kalimat & evaluasi terjemahan real-time dengan AI.',
            'duration' => '10 Soal Interaktif',
            'icon' => 'fas fa-spell-check',
            'icon_gradient' => 'linear-gradient(135deg, #0d9488, #14b8a6)',
            'url' => url('/promo/test/grammar-practice/' . $gt->id . '?b=online'),
            'btn_text' => '🎯 Mulai Test Grammar Promo',
            'btn_gradient' => 'linear-gradient(135deg, #0d9488, #0f766e)',
            'btn_shadow' => 'rgba(13,148,136,0.35)',
        ]);
    }

    // 2. Active IELTS Writing Promos
    $activeWritingPromos = \App\Models\IeltsWritingMeeting::where('is_free_tier', true)
        ->where(function($q) use ($now) { $q->whereNull('promo_start')->orWhere('promo_start', '<=', $now); })
        ->where(function($q) use ($now) { $q->whereNull('promo_deadline')->orWhere('promo_deadline', '>=', $now); })
        ->orderBy('id', 'desc')
        ->take(2)
        ->get();
    foreach ($activeWritingPromos as $wm) {
        $activePromos->push((object)[
            'badge' => '🔥 PROMO EVENT',
            'title' => 'Writing: ' . ($wm->task_type == 1 ? 'Task 1 Academic' : 'Task 2 Essay'),
            'desc' => \Illuminate\Support\Str::limit($wm->title, 70),
            'duration' => 'Real-Time AI Evaluasi',
            'icon' => 'fas fa-pen-nib',
            'icon_gradient' => 'linear-gradient(135deg, #4f46e5, #7c3aed)',
            'url' => url('/promo/test/writing/' . $wm->id),
            'btn_text' => '🎯 Ambil Test Writing Promo',
            'btn_gradient' => 'linear-gradient(135deg, #4f46e5, #4338ca)',
            'btn_shadow' => 'rgba(79,70,229,0.35)',
        ]);
    }

    // 3. Active IELTS Speaking Promos
    $activeSpeakingPromos = \App\Models\IeltsSpeakingTopic::where('is_free_tier', true)
        ->where(function($q) use ($now) { $q->whereNull('promo_start')->orWhere('promo_start', '<=', $now); })
        ->where(function($q) use ($now) { $q->whereNull('promo_deadline')->orWhere('promo_deadline', '>=', $now); })
        ->orderBy('id', 'desc')
        ->take(2)
        ->get();
    foreach ($activeSpeakingPromos as $st) {
        $activePromos->push((object)[
            'badge' => '🔥 PROMO EVENT',
            'title' => 'Speaking: ' . $st->title,
            'desc' => 'Simulasi interview berbicara Part 1 & Part 2 dengan AI Avatar & scoring instan.',
            'duration' => 'Simulasi AI Examiner',
            'icon' => 'fas fa-microphone-alt',
            'icon_gradient' => 'linear-gradient(135deg, #ea580c, #f97316)',
            'url' => url('/promo/test/speaking/' . $st->id),
            'btn_text' => '🎯 Ambil Test Speaking Promo',
            'btn_gradient' => 'linear-gradient(135deg, #ea580c, #c2410c)',
            'btn_shadow' => 'rgba(234,88,12,0.35)',
        ]);
    }
@endphp

@if($activePromos->count() > 0)
<!-- DEDICATED PROMO TEST CONTAINER -->
<section class="promo-test-section" style="background: linear-gradient(145deg, #091235 0%, #0c235c 40%, #0d3873 100%); padding: 36px 20px 42px; position: relative; border-bottom: 1px solid rgba(255,255,255,0.1); overflow: hidden;">
    <div style="max-width: 1100px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(239,68,68,0.2); border: 1.5px solid rgba(239,68,68,0.55); color: #fca5a5; padding: 5px 16px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 12px;">
            🔥 Event Promo Aktif
        </div>
        <h2 style="font-size: 2.1rem; font-weight: 900; color: #fff; margin-bottom: 8px; text-shadow: 0 4px 20px rgba(0,0,0,0.4);">
            Latihan &amp; Promo Test <span style="background: linear-gradient(135deg, #f97316, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Spesial</span>
        </h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.98rem; margin-bottom: 24px; max-width: 650px; margin-left: auto; margin-right: auto; line-height: 1.5;">
            Uji kemampuan spesifikmu dengan AI Real-Time Feedback sebelum event promo berakhir!
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; max-width: 1050px; margin: 0 auto;">
            @foreach($activePromos as $promo)
            <div class="hover-lift" style="background: rgba(255,255,255,0.96); border-radius: 18px; padding: 28px 20px; display: flex; flex-direction: column; align-items: center; position: relative; border: 2px solid rgba(245,158,11,0.6); box-shadow: 0 10px 30px rgba(0,0,0,0.25); text-align: center;">
                <div style="position: absolute; top: -13px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg,#ef4444,#f97316); color: #fff; font-size: 0.72rem; font-weight: 900; border-radius: 50px; padding: 4px 14px; letter-spacing: 1.5px; text-transform: uppercase; box-shadow: 0 4px 12px rgba(239,68,68,0.5); white-space: nowrap;">
                    {{ $promo->badge }}
                </div>
                <div style="font-size: 2.2rem; margin-bottom: 10px; background: {{ $promo->icon_gradient }}; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="{{ $promo->icon }}"></i>
                </div>
                <div style="font-weight: 800; font-size: 1.12rem; margin-bottom: 6px; color: #1e293b;">
                    {{ $promo->title }}
                    <span style="background: linear-gradient(135deg,#16a34a,#22c55e); color: #fff; font-size: 0.72rem; font-weight: 800; border-radius: 50px; padding: 3px 10px; margin-left: 4px;">GRATIS</span>
                </div>
                <div style="color: #64748B; font-size: 0.9rem; margin-bottom: 10px; line-height: 1.45; flex-grow: 1;">
                    {{ $promo->desc }}
                </div>
                <div style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 14px;">
                    <i class="fas fa-bolt" style="color: #f59e0b;"></i> {{ $promo->duration }}
                </div>
                <a href="{{ $promo->url }}" style="display: block; width: 100%; background: {{ $promo->btn_gradient }}; color: #fff; font-weight: 700; border-radius: 10px; padding: 11px 0; text-decoration: none; font-size: 0.92rem; box-shadow: 0 4px 14px {{ $promo->btn_shadow }}; transition: all 0.3s;">
                    {{ $promo->btn_text }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="free-test-section">
    <!-- Glassmorphism floating orbs -->
    <div class="ft-orb ft-orb-1"></div>
    <div class="ft-orb ft-orb-2"></div>
    <div class="ft-orb ft-orb-3"></div>

    <!-- Dot grid overlay -->
    <div class="free-test-dots"></div>

    <!-- Floating sparkles -->
    <span class="ft-sparkle">✦</span>
    <span class="ft-sparkle">✧</span>
    <span class="ft-sparkle">✦</span>
    <span class="ft-sparkle">✧</span>
    <span class="ft-sparkle">★</span>

    <!-- Inner Content -->
    <div class="free-test-inner">
        <!-- Top badge -->
        <div class="free-test-badge">
            <i class="fas fa-bolt"></i> Test Bahasa Inggris
        </div>

        <!-- Heading -->
        <h2 class="free-test-heading">
            Pilih Test Gratis <span>Kamu</span>
        </h2>
        <p class="free-test-subtitle">
            Dapatkan hasil instan &amp; ketahui level bahasa Inggrismu yang sebenarnya
        </p>

        <!-- Counter -->
        <div class="free-test-counter">
            <span class="counter-fire">🔥</span>
            Sudah <strong>1.247 peserta</strong> mengikuti test minggu ini
        </div>

        <!-- Carousel wrapper -->
        <div style="position:relative; max-width:1100px; margin:0 auto;">
            <button class="test-carousel-btn left" onclick="freeTestPrev()" aria-label="Scroll left">&#8249;</button>
            <div id="free-test-track" class="test-selection-carousel">

            <!-- Card 1 — TOEFL ITP -->
            <div class="hover-lift test-card-item" style="border-radius:18px; padding:32px 20px 28px 20px; display:flex; flex-direction:column; align-items:center;">
                <div style="font-size:2.4rem; margin-bottom:12px; background:linear-gradient(135deg,#1d4ed8,#3b82f6); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div style="font-weight:800; font-size:1.15rem; margin-bottom:6px; color:#1e293b;">
                    TOEFL ITP
                    <span style="background:linear-gradient(135deg,#16a34a,#22c55e); color:#fff; font-size:0.75rem; font-weight:800; border-radius:50px; padding:3px 12px; margin-left:6px; letter-spacing:0.5px;">GRATIS</span>
                </div>
                <div style="color:#64748B; font-size:0.95rem; margin-bottom:10px; line-height:1.5;">Syarat kelulusan kampus, melamar CPNS, atau kerja di perusahaan BUMN/Lokal.</div>
                <div style="color:#94a3b8; font-size:0.9rem; margin-bottom:14px;"><i class="fas fa-clock" style="color:#e11d48;"></i> 15 Menit Simulasi</div>
                <a href="{{ route('guest.free-tests') }}" style="display:inline-block; background:linear-gradient(135deg,#e11d48,#be123c); color:#fff; font-weight:700; border-radius:10px; padding:11px 0; width:100%; text-decoration:none; font-size:0.95rem; box-shadow:0 4px 14px rgba(225,29,72,0.3); transition:all 0.3s;">🎯 Mulai Test TOEFL Gratis</a>
            </div>

            <!-- Card 2 — IELTS Academic -->
            <div class="hover-lift test-card-item" style="border-radius:18px; padding:32px 20px 28px 20px; display:flex; flex-direction:column; align-items:center;">
                <div style="font-size:2.4rem; margin-bottom:12px; background:linear-gradient(135deg,#1d4ed8,#6366f1); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                    <i class="fas fa-book"></i>
                </div>
                <div style="font-weight:800; font-size:1.15rem; margin-bottom:6px; color:#1e293b;">
                    IELTS Academic
                    <span style="background:linear-gradient(135deg,#16a34a,#22c55e); color:#fff; font-size:0.75rem; font-weight:800; border-radius:50px; padding:3px 12px; margin-left:6px; letter-spacing:0.5px;">GRATIS</span>
                </div>
                <div style="color:#64748B; font-size:0.95rem; margin-bottom:10px; line-height:1.5;">Daftar kuliah di luar negeri (Study Abroad) atau beasiswa internasional (AAS, LPDP).</div>
                <div style="color:#94a3b8; font-size:0.9rem; margin-bottom:14px;"><i class="fas fa-clock" style="color:#e11d48;"></i> 20 Menit Simulasi</div>
                    <a href="{{ route('guest.free-tests') }}" style="display:inline-block; background:linear-gradient(135deg,#e11d48,#be123c); color:#fff; font-weight:700; border-radius:10px; padding:11px 0; width:100%; text-decoration:none; font-size:0.95rem; box-shadow:0 4px 14px rgba(225,29,72,0.3); transition:all 0.3s;">🎯 Cek Skor IELTS Sekarang</a>
            </div>

            <!-- Card 3 — IELTS General (POPULER) -->
            <div class="hover-lift test-card-item" style="border-radius:18px; padding:32px 20px 28px 20px; display:flex; flex-direction:column; align-items:center; position:relative; overflow:visible;">
                <div style="position:absolute; top:-14px; left:50%; transform:translateX(-50%); background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; font-size:0.72rem; font-weight:900; border-radius:50px; padding:5px 16px; letter-spacing:1.5px; text-transform:uppercase; box-shadow:0 4px 12px rgba(245,158,11,0.5); white-space:nowrap;">⭐ PALING POPULER</div>
                <div style="font-size:2.4rem; margin-bottom:12px; background:linear-gradient(135deg,#0369a1,#0ea5e9); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                    <i class="fas fa-globe"></i>
                </div>
                <div style="font-weight:800; font-size:1.15rem; margin-bottom:6px; color:#1e293b;">IELTS General</div>
                <div style="color:#64748B; font-size:0.95rem; margin-bottom:10px; line-height:1.5;">Visa Kerja (WHV Australia), migrasi, atau training internasional.</div>
                <div style="color:#94a3b8; font-size:0.9rem; margin-bottom:14px;"><i class="fas fa-clock" style="color:#e11d48;"></i> 20 Menit Simulasi</div>
                    <a href="{{ route('guest.free-tests') }}" style="display:inline-block; background:linear-gradient(135deg,#e11d48,#be123c); color:#fff; font-weight:700; border-radius:10px; padding:11px 0; width:100%; text-decoration:none; font-size:0.95rem; box-shadow:0 4px 14px rgba(225,29,72,0.3); transition:all 0.3s;">🎯 Cek Skor IELTS Sekarang</a>
            </div>

            <!-- Card 4 — PTE Academic -->
            <div class="hover-lift test-card-item" style="border-radius:18px; padding:32px 20px 28px 20px; display:flex; flex-direction:column; align-items:center;">
                <div style="font-size:2.4rem; margin-bottom:12px; background:linear-gradient(135deg,#0369a1,#7c3aed); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                    <i class="fas fa-laptop"></i>
                </div>
                <div style="font-weight:800; font-size:1.15rem; margin-bottom:6px; color:#1e293b;">
                    PTE Academic
                    <span style="background:linear-gradient(135deg,#16a34a,#22c55e); color:#fff; font-size:0.75rem; font-weight:800; border-radius:50px; padding:3px 12px; margin-left:6px; letter-spacing:0.5px;">GRATIS</span>
                </div>
                <div style="color:#64748B; font-size:0.95rem; margin-bottom:10px; line-height:1.5;">Alternatif IELTS untuk WHV Australia atau studi UK/Aus dengan sistem komputer.</div>
                <div style="color:#94a3b8; font-size:0.9rem; margin-bottom:14px;"><i class="fas fa-clock" style="color:#e11d48;"></i> 15 Menit Simulasi</div>
                <a href="{{ route('guest.free-tests') }}" style="display:inline-block; background:linear-gradient(135deg,#e11d48,#be123c); color:#fff; font-weight:700; border-radius:10px; padding:11px 0; width:100%; text-decoration:none; font-size:0.95rem; box-shadow:0 4px 14px rgba(225,29,72,0.3); transition:all 0.3s;">🎯 Mulai Test PTE Gratis</a>
            </div>

            </div><!-- /#free-test-track -->
            <button class="test-carousel-btn right" onclick="freeTestNext()" aria-label="Scroll right">&#8250;</button>
        </div><!-- /carousel wrapper -->
    </div><!-- /.free-test-inner -->

    <!-- Wave silhouette — smooth transition to next section -->
    <div class="free-test-silhouette">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
            <!-- Deep back wave -->
            <path d="M0,40 C240,70 480,10 720,40 C960,70 1200,10 1440,40 L1440,80 L0,80 Z"
                  fill="rgba(255,255,255,0.06)"/>
            <!-- Mid wave -->
            <path d="M0,52 C200,25 400,70 600,48 C800,26 1000,68 1200,46 C1320,34 1380,55 1440,52 L1440,80 L0,80 Z"
                  fill="rgba(255,255,255,0.1)"/>
            <!-- Front wave — solid white for page transition -->
            <path d="M0,65 C280,45 560,78 840,60 C1040,46 1240,72 1440,65 L1440,80 L0,80 Z"
                  fill="#ffffff"/>
        </svg>
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
                <a href="{{ route('guest.free-tests') }}" class="btn-primary-large">Ambil Test Sekarang</a>
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
        <a href="{{ route('guest.free-tests') }}" class="btn-primary-medium">Saya Mau Tahu Level Saya</a>
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
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('speaking_basic')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-intermediate pricing-style">
                        <div class="card-top">
                            <div class="badge badge-intermediate"><i class="fas fa-layer-group"></i> Intermediate</div>
                            <h3 class="card-title">Speaking Intermediate</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Memperlancar percakapan dengan grammar yang tepat.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('speaking_intermediate')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-advanced pricing-style">
                        <div class="card-top">
                            <div class="badge badge-advanced"><i class="fas fa-graduation-cap"></i> Advanced</div>
                            <h3 class="card-title">Speaking Advanced</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Level mahir untuk presentasi dan diskusi profesional.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('speaking_advanced')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-toefl pricing-style">
                        <div class="card-top">
                            <div class="badge badge-all"><i class="fas fa-certificate"></i> All Levels</div>
                            <h3 class="card-title">TOEFL ITP</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Kelas intensif mengejar target skor 550+ TOEFL ITP.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('toefl_itp')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
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
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('ielts_prep')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <div class="program-card card-marlins pricing-style">
                        <div class="coming-soon-overlay"><i class="fas fa-clock" style="margin-right:5px;"></i>Coming Soon</div>
                        <div class="card-top">
                            <div class="badge badge-all"><i class="fas fa-anchor"></i> Special Purpose</div>
                            <h3 class="card-title">Marlins Test</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Bimbingan khusus pelaut kapal pesiar menembus skor tinggi.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><button type="button" class="btn-pricing btn-pricing-disabled" disabled aria-disabled="true" title="Program ini belum dibuka">Daftar Kelas Sekarang</button><button type="button" onclick="openBrochure('marlins')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <!-- IELTS Writing Academic -->
                    <div class="program-card card-ielts-writing pricing-style">
                        <div class="card-top">
                            <div class="badge"><i class="fas fa-pen-nib"></i> IELTS Academic</div>
                            <h3 class="card-title">IELTS Writing</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Kuasai Task 1 & Task 2 Academic: grafik, diagram, hingga essay argumentatif band 7+.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('ielts_writing')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <!-- IELTS Listening Academic -->
                    <div class="program-card card-ielts-listening pricing-style">
                        <div class="card-top">
                            <div class="badge"><i class="fas fa-headphones"></i> IELTS Academic</div>
                            <h3 class="card-title">IELTS Listening</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Latihan intensif 4 section audio untuk mencapai skor Listening 7.5–8.5.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('ielts_listening')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <!-- IELTS Reading Academic -->
                    <div class="program-card card-ielts-reading pricing-style">
                        <div class="card-top">
                            <div class="badge"><i class="fas fa-book-open"></i> IELTS Academic</div>
                            <h3 class="card-title">IELTS Reading</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Strategi menjawab 40 soal Reading Academic dengan cepat dan tepat untuk band 7+.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('ielts_reading')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                    <!-- IELTS Speaking Academic -->
                    <div class="program-card card-ielts-speaking pricing-style">
                        <div class="card-top">
                            <div class="badge"><i class="fas fa-microphone-alt"></i> IELTS Academic</div>
                            <h3 class="card-title">IELTS Speaking</h3>
                        </div>
                        <div class="card-bottom">
                            <p class="prog-desc">Simulasi face-to-face examiner Part 1–3 untuk meraih skor Speaking 7.0+.</p>
                            <div style="display:flex; flex-direction:column; gap:8px;"><a href="{{ route('registration.show') }}" class="btn-pricing">Daftar Kelas Sekarang</a><button type="button" onclick="openBrochure('ielts_speaking_ac')" class="btn-info-more">Informasi Lebih Lanjut</button></div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-btn carousel-next" id="prog-next" aria-label="Next">&#8250;</button>
        </div>

        <!-- DOT INDICATORS -->
        <div class="carousel-dots" id="prog-dots"></div>

        <!-- INFO BLOCKS -->
        <div style="display:flex; justify-content:center; gap:30px; flex-wrap:wrap; margin-top:60px;">
            <!-- Block 1 -->
            <div style="background:rgba(255,255,255,0.9); backdrop-filter:blur(10px); border-radius:20px; padding:24px 30px; display:flex; align-items:center; gap:20px; box-shadow:0 10px 40px rgba(13,71,161,0.08); text-align:left; max-width:480px; flex:1; min-width:320px; border:1px solid rgba(255,255,255,0.5);">
                <div style="background:#e0f2fe; width:70px; height:70px; border-radius:50%; display:flex; justify-content:center; align-items:center; flex-shrink:0;">
                    <i class="fas fa-globe-americas" style="font-size:32px; color:#0d47a1;"></i>
                </div>
                <div>
                    <h4 style="margin:0 0 8px 0; color:#0d47a1; font-weight:800; font-size:1.2rem;">Kuliah ke Luar Negeri</h4>
                    <p style="margin:0; color:#475569; font-size:0.95rem; line-height:1.5;">Persiapkan kemampuan bahasa Inggrismu untuk studi di universitas terbaik dunia.</p>
                </div>
            </div>

            <!-- Block 2 -->
            <div style="background:rgba(255,255,255,0.9); backdrop-filter:blur(10px); border-radius:20px; padding:24px 30px; display:flex; align-items:center; gap:20px; box-shadow:0 10px 40px rgba(13,71,161,0.08); text-align:left; max-width:480px; flex:1; min-width:320px; border:1px solid rgba(255,255,255,0.5);">
                <div style="background:#fef3c7; width:70px; height:70px; border-radius:50%; display:flex; justify-content:center; align-items:center; flex-shrink:0;">
                    <i class="fas fa-briefcase" style="font-size:32px; color:#d97706;"></i>
                </div>
                <div>
                    <h4 style="margin:0 0 8px 0; color:#0d47a1; font-weight:800; font-size:1.2rem;">Kerja ke Luar Negeri</h4>
                    <p style="margin:0; color:#475569; font-size:0.95rem; line-height:1.5;">Tingkatkan kepercayaan diri untuk bersaing di dunia kerja internasional.</p>
                </div>
            </div>
        </div>
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

.btn-pricing.btn-pricing-disabled,
.btn-pricing:disabled,
.btn-pricing[aria-disabled="true"] {
    background: #94a3b8 !important;
    color: #e2e8f0 !important;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
    pointer-events: none;
}

.card-beginner .card-top { background: #22C55E !important; }
.card-intermediate .card-top { background: #3B82F6 !important; }
.card-advanced .card-top { background: #8B5CF6 !important; }
.card-toefl .card-top { background: #F97316 !important; }
.card-ielts .card-top { background: #1D4ED8 !important; }
.card-marlins .card-top { background: #1E293B !important; }
/* IELTS Academic skill cards — unique teal/emerald gradient headers */
.card-ielts-writing .card-top   { background: linear-gradient(135deg, #0f766e, #14b8a6) !important; }
.card-ielts-listening .card-top { background: linear-gradient(135deg, #7c3aed, #a855f7) !important; }
.card-ielts-reading .card-top   { background: linear-gradient(135deg, #0369a1, #0ea5e9) !important; }
.card-ielts-speaking .card-top  { background: linear-gradient(135deg, #be185d, #ec4899) !important; }

/* Strip old program-card backgrounds since they are solid white now */
.card-beginner { background: #ffffff !important; }
.card-intermediate { background: #ffffff !important; }
.card-advanced { background: #ffffff !important; }
.card-toefl { background: #ffffff !important; }
.card-ielts { background: #ffffff !important; }
.card-marlins { background: #ffffff !important; }
.card-ielts-writing { background: #ffffff !important; }
.card-ielts-listening { background: #ffffff !important; }
.card-ielts-reading { background: #ffffff !important; }
.card-ielts-speaking { background: #ffffff !important; }

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

.coming-soon-overlay {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #dc2626;
    color: #ffffff;
    padding: 4px 10px;
    font-size: 0.68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border-radius: 999px;
    line-height: 1.2;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(127, 29, 29, 0.35);
    z-index: 11;
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
    <div class="container" style="max-width:700px; margin:0 auto;">

        <!-- Dark glass content card -->
        <div style="background:rgba(13,71,161,0.82); backdrop-filter:blur(18px); border:1px solid rgba(255,255,255,0.18); border-radius:28px; padding:44px 40px; box-shadow:0 20px 60px rgba(13,71,161,0.4);">

            <!-- Badge -->
            <div class="whv-badge" style="margin-bottom:20px;"><i class="fas fa-fire"></i> Peluang Emas Australia</div>

            <!-- Headline -->
            <h2 style="font-size:2.6rem; font-weight:900; color:#fff; margin-bottom:10px; line-height:1.2; text-shadow:0 3px 16px rgba(0,0,0,0.6);">
                Kerja di Australia 🇦🇺<br>
                <span style="color:#FFD700; text-shadow:0 0 20px rgba(255,215,0,0.5);">dengan Gaji Dollar 💰</span>
            </h2>
            <p style="color:rgba(255,255,255,0.85); font-size:1.05rem; margin-bottom:28px; line-height:1.6;">
                Program <strong style="color:#fff;">Working Holiday Visa</strong> — legal, terstruktur,<br>dan terbukti mengubah hidup
            </p>

            <!-- Salary Card -->
            <div style="background:rgba(255,255,255,0.08); border:2px solid rgba(96,165,250,0.6); border-radius:16px; padding:22px 36px; margin-bottom:28px;">
                <p style="color:rgba(255,255,255,0.75); font-size:0.82rem; letter-spacing:2px; text-transform:uppercase; margin-bottom:6px;">💵 Estimasi Gaji Pekerja WHV</p>
                <div style="font-size:2.3rem; font-weight:900; color:#93c5fd; line-height:1.1; text-shadow:0 0 24px rgba(147,197,253,0.6);">
                    Rp 30 – 50 Juta
                </div>
                <p style="color:rgba(255,255,255,0.65); font-size:0.9rem; margin-top:4px; margin-bottom:0;">per bulan</p>
            </div>

            <!-- Requirements -->
            <p style="color:rgba(255,255,255,0.8); font-size:0.85rem; letter-spacing:1.5px; text-transform:uppercase; margin-bottom:14px; font-weight:600;">
                🎯 Syarat Bahasa Inggris (Salah Satu)
            </p>
            <div style="display:inline-flex; gap:14px; flex-wrap:wrap; justify-content:center; margin-bottom:28px;">
                <div style="background:rgba(255,255,255,0.1); border:2px solid #60a5fa; border-radius:14px; padding:14px 30px; min-width:120px;">
                    <div style="color:#93c5fd; font-weight:900; font-size:1rem; letter-spacing:1px;">IELTS</div>
                    <div style="color:#fff; font-size:1.7rem; font-weight:900; line-height:1;">4.5 <span style="font-size:0.85rem; font-weight:500; color:rgba(255,255,255,0.7);">min</span></div>
                </div>
                <div style="display:flex; align-items:center; color:rgba(255,255,255,0.5); font-size:1rem; font-weight:600;">atau</div>
                <div style="background:rgba(255,255,255,0.1); border:2px solid #60a5fa; border-radius:14px; padding:14px 30px; min-width:120px;">
                    <div style="color:#93c5fd; font-weight:900; font-size:1rem; letter-spacing:1px;">PTE</div>
                    <div style="color:#fff; font-size:1.7rem; font-weight:900; line-height:1;">30 <span style="font-size:0.85rem; font-weight:500; color:rgba(255,255,255,0.7);">min</span></div>
                </div>
            </div>

            <!-- Sub text -->
            <p style="color:rgba(255,255,255,0.75); font-size:0.98rem; margin-bottom:24px;">
                Cek dulu bahasamu — <strong style="color:#FFD700;">gratis</strong>, hasil instan, tanpa daftar!
            </p>

            <!-- CTA Button -->
            <a href="{{ url('/whv-australia') }}" class="btn-yellow-huge pulse-anim" style="font-size:1.15rem; padding:18px 44px; border-radius:50px; display:inline-block;">
                Tentang WHV
            </a>

            <!-- Trust note -->
            <p style="margin-top:16px; color:rgba(255,255,255,0.55); font-size:0.85rem;">
                ✅ Sudah diikuti <strong style="color:#fff;">1.200+</strong> calon peserta WHV
            </p>

        </div>
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
        
        <form class="lead-form compact-form mt-4" action="/guest/register" method="POST" id="lead-form">
            @csrf
            <input type="hidden" name="test_type" id="test-type-input" value="ielts_academic">

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
<style>
/* ═══════════ FOOTER STYLES ═══════════ */
.site-footer {
    background: linear-gradient(160deg, #0a2f6e 0%, #0D47A1 60%, #1565C0 100%);
    color: #fff;
    padding-top: 0;
    position: relative;
    overflow: hidden;
}
.site-footer::before {
    content: '';
    position: absolute;
    top: -120px;
    left: -100px;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255,184,0,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.site-footer::after {
    content: '';
    position: absolute;
    bottom: 60px;
    right: -80px;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(96,165,250,0.08) 0%, transparent 70%);
    pointer-events: none;
}

/* Wave Divider */
.footer-wave {
    display: block;
    width: 100%;
    margin-bottom: -2px;
    line-height: 0;
}
.footer-wave svg {
    display: block;
    width: 100%;
    height: 70px;
}

/* Footer Body */
.footer-body {
    position: relative;
    z-index: 1;
    padding: 52px 0 32px;
}
.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.4fr;
    gap: 48px;
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 24px;
}
@media (max-width: 900px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
}
@media (max-width: 560px) {
    .footer-grid { grid-template-columns: 1fr; gap: 28px; }
    .footer-wave svg { height: 40px; }
}

/* Brand Column */
.footer-brand-logo {
    height: 70px;
    width: auto;
    filter: drop-shadow(0 2px 8px rgba(0,0,0,0.3)) brightness(1.05);
    margin-bottom: 16px;
    display: block;
}
.footer-brand-desc {
    color: rgba(255,255,255,0.72);
    font-size: 0.92rem;
    line-height: 1.7;
    margin-bottom: 20px;
}

/* Social Icons */
.footer-socials {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.footer-social-link {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(4px);
}
.footer-social-link:hover {
    background: #FFB800;
    border-color: #FFB800;
    color: #0a2f6e;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255,184,0,0.35);
}

/* Column Headings */
.footer-col-title {
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #FFB800;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.footer-col-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,184,0,0.3);
}

/* Nav Links */
.footer-nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.footer-nav-list a {
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    font-size: 0.92rem;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.25s ease;
}
.footer-nav-list a:hover {
    color: #FFB800;
    transform: translateX(4px);
}
.footer-nav-list a i {
    font-size: 0.7rem;
    opacity: 0.6;
}

/* Contact Items */
.footer-contact-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    color: rgba(255,255,255,0.75);
    font-size: 0.9rem;
    line-height: 1.5;
}
.footer-contact-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 0.85rem;
    color: #FFB800;
    margin-top: 1px;
}
.footer-contact-item a {
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    transition: color 0.2s;
}
.footer-contact-item a:hover {
    color: #FFB800;
}

/* Badge Akreditasi */
.footer-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 20px;
}
.footer-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 50px;
    padding: 5px 12px;
    font-size: 0.78rem;
    color: rgba(255,255,255,0.8);
    font-weight: 600;
}
.footer-badge i {
    color: #FFB800;
}

/* Divider */
.footer-divider {
    border: none;
    border-top: 1px solid rgba(255,255,255,0.1);
    margin: 0;
}

/* Copyright Bar */
.footer-copyright {
    position: relative;
    z-index: 1;
    padding: 18px 24px;
    max-width: 1140px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.footer-copyright-text {
    color: rgba(255,255,255,0.5);
    font-size: 0.83rem;
}
.footer-copyright-text strong {
    color: rgba(255,255,255,0.75);
}
.footer-copyright-links {
    display: flex;
    gap: 20px;
}
.footer-copyright-links a {
    color: rgba(255,255,255,0.5);
    font-size: 0.83rem;
    text-decoration: none;
    transition: color 0.2s;
}
.footer-copyright-links a:hover {
    color: #FFB800;
}
</style>

<footer class="site-footer">
    <!-- Wave Top -->
    <div class="footer-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 70" preserveAspectRatio="none">
            <path fill="#f0f4ff" d="M0,32 C180,70 360,0 540,32 C720,64 900,10 1080,36 C1260,62 1380,20 1440,32 L1440,70 L0,70 Z"/>
        </svg>
    </div>

    <!-- Main Footer Body -->
    <div class="footer-body">
        <div class="footer-grid">

            <!-- Col 1: Brand -->
            <div>
                <img src="/images/brand/logo.png" alt="Target Bahasa" class="footer-brand-logo">
                <p class="footer-brand-desc">
                    Lembaga kursus bahasa Inggris terpercaya di Pare, Kediri.<br>
                    Membantu ribuan siswa meraih skor IELTS, TOEFL &amp; PTE impian mereka sejak 2015.
                </p>
                <div class="footer-socials">
                    <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="footer-social-link" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="footer-social-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="footer-social-link" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="footer-social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer-social-link" title="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
                <div class="footer-badges">
                    <span class="footer-badge"><i class="fas fa-shield-alt"></i> Resmi & Terdaftar</span>
                    <span class="footer-badge"><i class="fas fa-star"></i> 4.9/5 Rating</span>
                    <span class="footer-badge"><i class="fas fa-users"></i> 1000+ Alumni</span>
                </div>
            </div>

            <!-- Col 2: Program -->
            <div>
                <h4 class="footer-col-title">Program</h4>
                <ul class="footer-nav-list">
                    <li><a href="{{ route('registration.show') }}"><i class="fas fa-chevron-right"></i> Speaking Basic</a></li>
                    <li><a href="{{ route('registration.show') }}"><i class="fas fa-chevron-right"></i> Speaking Intermediate</a></li>
                    <li><a href="{{ route('registration.show') }}"><i class="fas fa-chevron-right"></i> Speaking Advanced</a></li>
                    <li><a href="{{ route('registration.show') }}"><i class="fas fa-chevron-right"></i> TOEFL ITP Prep</a></li>
                    <li><a href="{{ route('registration.show') }}"><i class="fas fa-chevron-right"></i> IELTS Preparation</a></li>
                    <li><a href="{{ route('registration.show') }}"><i class="fas fa-chevron-right"></i> Marlins Test</a></li>
                    <li><a href="{{ url('/whv-australia') }}"><i class="fas fa-chevron-right"></i> WHV Australia</a></li>
                </ul>
            </div>

            <!-- Col 3: Tautan Cepat -->
            <div>
                <h4 class="footer-col-title">Tautan</h4>
                <ul class="footer-nav-list">
                    <li><a href="{{ route('guest.free-tests') }}"><i class="fas fa-chevron-right"></i> Test Gratis</a></li>
                    <li><a href="{{ route('registration.show') }}"><i class="fas fa-chevron-right"></i> Daftar Kelas</a></li>
                    <li><a href="{{ route('student.login') }}"><i class="fas fa-chevron-right"></i> Student Login</a></li>
                    <li><a href="{{ route('teacher.login') }}"><i class="fas fa-chevron-right"></i> Teacher Login</a></li>
                    <li><a href="{{ route('guest.login') }}"><i class="fas fa-chevron-right"></i> Akses Tamu</a></li>
                    <li><a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener"><i class="fas fa-chevron-right"></i> Konsultasi WA</a></li>
                </ul>
            </div>

            <!-- Col 4: Kontak -->
            <div>
                <h4 class="footer-col-title">Kontak</h4>
                <ul class="footer-contact-list">
                    <li class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <span>Jalan Brawijaya No. 64,<br>Pare, Kediri, Jawa Timur</span>
                    </li>
                    <li class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fab fa-whatsapp"></i></div>
                        <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener">+62 857-0661-5607</a>
                    </li>
                    <li class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-envelope"></i></div>
                        <a href="mailto:info@targetbahasa.com">info@targetbahasa.com</a>
                    </li>
                    <li class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-clock"></i></div>
                        <span>Senin – Sabtu<br>08.00 – 20.00 WIB</span>
                    </li>
                </ul>
            </div>

        </div><!-- /.footer-grid -->
    </div><!-- /.footer-body -->

    <hr class="footer-divider">

    <!-- Copyright Bar -->
    <div class="footer-copyright">
        <p class="footer-copyright-text">
            © 2026 <strong>Target Bahasa</strong>. All rights reserved. &nbsp;·&nbsp; Empowering Your English Journey.
        </p>
        <div class="footer-copyright-links">
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
            <a href="#">Peta Situs</a>
        </div>
    </div>

</footer>

<!-- Floating Mobile CTA -->
<div class="floating-cta-mobile">
    <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="floating-cta-btn wa-btn">Chat WA</a>
    <a href="{{ route('registration.show') }}" class="floating-cta-btn daftar-btn">Daftar</a>
    <a href="{{ route('guest.free-tests') }}" class="floating-cta-btn test-btn">Mulai Test</a>
</div>

<!-- Free Test Carousel JS — circular -->
<script>
(function() {
    // Handle test type from URL hash
    function extractTestTypeFromHash() {
        const hash = window.location.hash;
        if (hash.includes('type=')) {
            const typeParam = new URLSearchParams(hash.split('?')[1]);
            const testType = typeParam.get('type');
            if (testType) {
                const input = document.getElementById('test-type-input');
                if (input) {
                    input.value = testType;
                }
            }
        }
    }

    // Extract test type on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', extractTestTypeFromHash);
    } else {
        extractTestTypeFromHash();
    }

    // Also listen for hash changes
    window.addEventListener('hashchange', extractTestTypeFromHash);

    var CARDS, currentIdx;

    function getCards() {
        return Array.from(document.querySelectorAll('#free-test-track .test-card-item'));
    }

    function render(idx) {
        CARDS = getCards();
        var total = CARDS.length;
        if (!total) return;
        currentIdx = ((idx % total) + total) % total;

        var prev = (currentIdx - 1 + total) % total;
        var next = (currentIdx + 1) % total;

        CARDS.forEach(function(card, i) {
            card.classList.remove('is-center', 'is-left', 'is-right', 'is-hidden');
            if (i === currentIdx) {
                card.classList.add('is-center');
            } else if (i === prev) {
                card.classList.add('is-left');
            } else if (i === next) {
                card.classList.add('is-right');
            } else {
                card.classList.add('is-hidden');
            }
        });
    }

    window.freeTestPrev = function() { render(currentIdx - 1); };
    window.freeTestNext = function() { render(currentIdx + 1); };

    document.addEventListener('DOMContentLoaded', function() {
        CARDS = getCards();
        currentIdx = 1; /* Start with IELTS Academic centred */
        render(currentIdx);

        /* Hover on side cards → centre them */
        var supportsHover = window.matchMedia('(hover: hover)').matches;
        if (supportsHover) {
            CARDS.forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    CARDS = getCards();
                    var idx = CARDS.indexOf(card);
                    if (idx !== -1 && idx !== currentIdx) render(idx);
                });
            });
        }
    });
}());
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
        <div id="brochure-desc" style="color:#475569; font-size:1rem; line-height:1.75; margin-bottom:2rem; text-align:left; white-space: pre-line;">
            Description goes here.
        </div>
        <div style="display: flex; gap: 10px; margin-top: 1.5rem; flex-wrap: wrap;">
            <a id="brochure-pdf-btn" href="#" target="_blank" class="btn-outline" style="flex: 1; min-width: 140px; text-align: center; display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 16px; border-radius: 10px; font-weight: 700; font-size: 0.95rem; border: 1.5px solid #cbd5e1; color: #334155; text-decoration: none; background: #f8fafc;">
                <i class="fas fa-file-pdf" style="color: #ef4444;"></i> Brosur PDF
            </a>
            <a href="{{ route('registration.show') }}" class="btn-pricing" style="flex: 1.2; min-width: 160px; text-align:center; margin: 0;">Daftar Kelas Sekarang</a>
        </div>
    </div>
</div>

<script>
    // Brochure Modal Logic
    const brochureData = {
        'speaking_basic': {
            title: 'Speaking Basic',
            slug: 'introductory-speaking',
            desc: 'Program Speaking Basic didesain khusus untuk pemula (Beginner) yang ingin membangun rasa percaya diri dalam berbicara bahasa Inggris. Anda akan belajar kosakata dasar, pelafalan yang benar, dan percakapan sehari-hari. Cocok untuk Anda yang masih terbata-bata atau takut salah saat berbicara.'
        },
        'speaking_intermediate': {
            title: 'Speaking Intermediate',
            slug: 'intermediate-speaking',
            desc: 'Program Speaking Intermediate ditujukan bagi Anda yang sudah memiliki dasar namun ingin memperlancar percakapan. Fokus pada perbaikan tata bahasa (grammar) saat berbicara secara spontan, memperluas kosakata, dan berlatih diskusi interaktif dalam berbagai konteks sosial maupun profesional.'
        },
        'speaking_advanced': {
            title: 'Speaking Advanced',
            slug: 'advanced-speaking',
            desc: 'Program Speaking Advanced adalah kelas mahir (Advanced) untuk menyempurnakan kefasihan bahasa Inggris Anda. Sangat cocok bagi profesional atau mahasiswa yang membutuhkan kemampuan presentasi tingkat lanjut, negosiasi, debat, dan public speaking dengan tingkat akurasi tinggi.'
        },
        'toefl_itp': {
            title: 'TOEFL ITP Preparation',
            slug: 'toefl-itp',
            desc: 'Kelas intensif yang dirancang untuk mendongkrak skor TOEFL ITP Anda hingga 550+. Kami menyediakan strategi khusus untuk menaklukkan sesi Listening, Structure and Written Expression, serta Reading Comprehension secara efektif dan efisien.'
        },
        'ielts_prep': {
            title: 'IELTS Preparation',
            slug: 'ielts-academic-full-package',
            desc: 'Program persiapan komprehensif untuk mencapai skor ideal (Band 7.0+). Anda akan dibimbing menguasai keempat skill IELTS: Listening, Reading, Writing, dan Speaking dengan format tes terbaru dan simulasi rutin.'
        },
        'marlins': {
            title: 'Marlins Test Preparation',
            slug: 'speaking',
            desc: 'Program bimbingan khusus bagi pelaut dan kru kapal pesiar. Membekali Anda dengan kemampuan bahasa Inggris maritim spesifik untuk lulus tes Marlins dengan skor tinggi, memperbesar peluang kerja di perusahaan pelayaran internasional.'
        },
        'ielts_writing': {
            title: 'IELTS Writing Academic',
            slug: 'ielts-academic-writing',
            desc: `Kelas intensif khusus IELTS Academic Writing yang mencakup:\n\n✏️ Task 1 Academic — Mendeskripsikan grafik (line, bar, pie chart), diagram proses, dan peta dengan struktur overview & detail yang tepat.\n\n📝 Task 2 Essay — Menguasai jenis soal Discussion, Opinion, Problem & Solution, dan Advantages/Disadvantages dengan framework paragraf yang terbukti mencapai Band 7–8.\n\nAnda akan mendapatkan koreksi tulisan dari pengajar berpengalaman, latihan timed writing setiap sesi, dan feedback terperinci untuk setiap submission.`
        },
        'ielts_listening': {
            title: 'IELTS Listening Academic',
            slug: 'ielts-academic-full-package',
            desc: `Kelas intensif IELTS Listening Academic yang membekali Anda dengan kemampuan memahami audio berbagai aksen native speaker:\n\n🎧 Section 1 & 2 — Percakapan sehari-hari dan monolog sosial (form filling, maps, multiple choice).\n\n🎓 Section 3 & 4 — Diskusi akademik dan kuliah universitas yang lebih kompleks.\n\nLatihan dengan audio asli IELTS, teknik prediksi jawaban, dan strategi menghadapi distractor. Target skor 7.5–8.5 dalam waktu singkat.`
        },
        'ielts_reading': {
            title: 'IELTS Reading Academic',
            slug: 'ielts-academic-reading',
            desc: `Kelas strategi IELTS Reading Academic untuk menjawab 40 soal dalam 60 menit secara akurat:\n\n📖 3 passage teks ilmiah panjang — dari jurnal, majalah, dan teks akademik internasional.\n\n🔍 Teknik skim & scan, matching headings, True/False/Not Given, Summary Completion, dan sentence matching.\n\nAnda akan berlatih dengan soal IELTS Cambridge authentic, membangun kecepatan baca, dan mempelajari strategi eliminasi yang efektif untuk meraih Band 7.0+.`
        },
        'ielts_speaking_ac': {
            title: 'IELTS Speaking Academic',
            slug: 'ielts-speaking',
            desc: `Kelas simulasi IELTS Speaking dengan format persis seperti ujian resmi (face-to-face examiner):\n\n🗣️ Part 1 — Pertanyaan personal singkat tentang kehidupan sehari-hari (2 menit).\n\n💬 Part 2 — Long turn: berbicara 2 menit dari cue card tanpa persiapan panjang.\n\n🔄 Part 3 — Diskusi mendalam & analitis dengan examiner (4–5 menit).\n\nFokus pada Fluency, Coherence, Lexical Resource, Grammar Range, dan Pronunciation. Setiap sesi direkam dan dievaluasi untuk mencapai skor Speaking 7.0+.`
        }
    };

    window.openBrochure = function(id) {
        const data = brochureData[id];
        if(data) {
            document.getElementById('brochure-title').innerText = data.title;
            const pdfBtn = document.getElementById('brochure-pdf-btn');
            if (pdfBtn && data.slug) {
                pdfBtn.href = '/brochure/pdf/' + data.slug;
            }
            // Render \n as real line breaks
            document.getElementById('brochure-desc').innerHTML = data.desc
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\n/g, '<br>');
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
