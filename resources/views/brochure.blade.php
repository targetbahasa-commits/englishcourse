<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Target Bahasa - Program Kelas</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900|outfit:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {!! app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']) !!}
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        
        .bg-tb-blue { background-color: #0d47a1; }
        .text-tb-blue { color: #0d47a1; }
        .bg-tb-yellow { background-color: #FFB800; }
        .text-tb-yellow { color: #FFB800; }
        
        .hero-slant {
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 55%;
            background: #1d4ed8;
            clip-path: polygon(25% 0, 100% 0, 100% 100%, 0% 100%);
            z-index: 0;
        }
        .hero-slant-dark {
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 45%;
            background: #0d47a1;
            clip-path: polygon(25% 0, 100% 0, 100% 100%, 0% 100%);
            z-index: 1;
        }

        .card { overflow: hidden;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            display: flex;
            flex-direction: column;
            padding: 32px;
            height: 100%;
            border-top: 5px solid;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .card-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 0 20px;
            color: white;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

/* Colorful Tags */
        .theme-ielts .theme-tag { background: rgba(13,71,161,0.1); color: #0d47a1; border: 1px solid rgba(13,71,161,0.2); }
        .theme-ielts-general .theme-tag { background: rgba(220,38,38,0.1); color: #dc2626; border: 1px solid rgba(220,38,38,0.2); }
        .theme-toefl .theme-tag { background: rgba(29,78,216,0.1); color: #1d4ed8; border: 1px solid rgba(29,78,216,0.2); }
        .theme-pte .theme-tag { background: rgba(3,105,161,0.1); color: #0369a1; border: 1px solid rgba(3,105,161,0.2); }
        .theme-grammar .theme-tag { background: rgba(124,58,237,0.1); color: #7c3aed; border: 1px solid rgba(124,58,237,0.2); }
        .theme-speaking .theme-tag { background: rgba(234,88,12,0.1); color: #ea580c; border: 1px solid rgba(234,88,12,0.2); }
        .theme-listening .theme-tag { background: rgba(219,39,119,0.1); color: #db2777; border: 1px solid rgba(219,39,119,0.2); }

        /* Info Item Colors */
        .theme-ielts .info-item { background: rgba(13,71,161,0.04); border: 1px solid rgba(13,71,161,0.1); }
        .theme-ielts-general .info-item { background: rgba(220,38,38,0.04); border: 1px solid rgba(220,38,38,0.1); }
        .theme-toefl .info-item { background: rgba(29,78,216,0.04); border: 1px solid rgba(29,78,216,0.1); }
        .theme-pte .info-item { background: rgba(3,105,161,0.04); border: 1px solid rgba(3,105,161,0.1); }
        .theme-grammar .info-item { background: rgba(124,58,237,0.04); border: 1px solid rgba(124,58,237,0.1); }
        .theme-speaking .info-item { background: rgba(234,88,12,0.04); border: 1px solid rgba(234,88,12,0.1); }
        .theme-listening .info-item { background: rgba(219,39,119,0.04); border: 1px solid rgba(219,39,119,0.1); }

        /* Check Colors */
        .theme-ielts .theme-check { color: #0d47a1; }
        .theme-ielts-general .theme-check { color: #dc2626; }
        .theme-toefl .theme-check { color: #1d4ed8; }
        .theme-pte .theme-check { color: #0369a1; }
        .theme-grammar .theme-check { color: #7c3aed; }
        .theme-speaking .theme-check { color: #ea580c; }
        .theme-listening .theme-check { color: #db2777; }
        
        .card > *:not(.absolute) { position: relative; z-index: 10; }
        .card .title { font-size: 1.5rem; text-shadow: 0 0 10px white, 0 0 20px white; }
        
        /* Specific card colors */
        .theme-ielts { border-color: #0d47a1; }
        .theme-ielts .card-icon { background: #0d47a1; }
        .theme-ielts .title, .theme-ielts .text-highlight { color: #0d47a1; }
        .theme-ielts .btn-primary { background: #0d47a1; color: white; }
        .theme-ielts .btn-outline { border: 1px solid #0d47a1; color: #0d47a1; }
        
        .theme-ielts-general { border-color: #dc2626; }
        .theme-ielts-general .card-icon { background: #dc2626; }
        .theme-ielts-general .title, .theme-ielts-general .text-highlight { color: #dc2626; }
        .theme-ielts-general .btn-primary { background: #dc2626; color: white; }
        .theme-ielts-general .btn-outline { border: 1px solid #dc2626; color: #dc2626; }
        
        .theme-toefl { border-color: #1d4ed8; }
        .theme-toefl .card-icon { background: #1d4ed8; }
        .theme-toefl .title, .theme-toefl .text-highlight { color: #1d4ed8; }
        .theme-toefl .btn-primary { background: #1d4ed8; color: white; }
        .theme-toefl .btn-outline { border: 1px solid #1d4ed8; color: #1d4ed8; }

        .theme-pte { border-color: #0369a1; }
        .theme-pte .card-icon { background: #0369a1; flex-direction: column; line-height: 1; }
        .theme-pte .title, .theme-pte .text-highlight { color: #0369a1; }
        .theme-pte .btn-primary { background: #0369a1; color: white; }
        .theme-pte .btn-outline { border: 1px solid #0369a1; color: #0369a1; }

        .theme-grammar { border-color: #7c3aed; }
        .theme-grammar .card-icon { background: #7c3aed; }
        .theme-grammar .title, .theme-grammar .text-highlight { color: #7c3aed; }
        .theme-grammar .btn-primary { background: #7c3aed; color: white; }
        .theme-grammar .btn-outline { border: 1px solid #7c3aed; color: #7c3aed; }

        .theme-speaking { border-color: #ea580c; }
        .theme-speaking .card-icon { background: #ea580c; }
        .theme-speaking .title, .theme-speaking .text-highlight { color: #ea580c; }
        .theme-speaking .btn-primary { background: #ea580c; color: white; }
        .theme-speaking .btn-outline { border: 1px solid #ea580c; color: #ea580c; }

        .theme-listening { border-color: #db2777; }
        .theme-listening .card-icon { background: #db2777; }
        .theme-listening .title, .theme-listening .text-highlight { color: #db2777; }
        .theme-listening .btn-primary { background: #db2777; color: white; }
        .theme-listening .btn-outline { border: 1px solid #db2777; color: #db2777; }

        .feature-icon {
            color: #0d47a1;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 64px;
        }
        .feature-icon i { font-size: 40px; }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        .info-item {
            background: #f8fafc;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        .info-item i {
            margin-top: 2px;
            font-size: 0.9rem;
        }
        .info-label {
            display: block;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 2px;
            font-weight: 700;
        }
        .info-value {
            font-weight: 600;
            color: #1e293b;
        }
    </style>
</head>
<body class="bg-slate-50 text-gray-800 antialiased overflow-x-hidden">

    <div class="max-w-[1280px] mx-auto bg-white shadow-2xl relative overflow-hidden" x-data="{ classType: null }">
        
        <!-- Hero -->
        <section class="relative w-full h-[650px] overflow-hidden flex items-center border-b-[6px] border-[#FFB800]" style="background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.95)), url('/images/hero/hero-background.webp') center center / cover no-repeat;">
            
            <!-- Header inside Hero -->
            <header class="absolute top-0 left-0 w-full py-6 px-10 flex items-center justify-between z-30">
                <div class="flex items-center gap-3">
                    <img src="/images/brand/logo.png" alt="Target Bahasa" class="h-24 w-auto drop-shadow-sm">
                </div>
                <div>
                    <a href="/" class="text-sm font-bold text-tb-blue hover:text-blue-700 transition flex items-center gap-2 bg-white/90 backdrop-blur-md px-5 py-2.5 rounded-full shadow-lg border border-white">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                </div>
            </header>
            
            <!-- Diagonal Backgrounds -->
            <div class="absolute inset-0 z-0">
                <div class="hero-slant opacity-95"></div>
                <div class="hero-slant-dark"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 w-full flex flex-col md:flex-row h-full">
                
                <!-- Left Content -->
                <div class="w-full md:w-[60%] pl-10 pr-4 flex flex-col justify-center">
                    <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:20px;">
                        <span style="background: rgba(13,71,161,0.1); border: 1px solid rgba(13,71,161,0.2); border-radius:50px; padding:6px 16px; font-size:0.8rem; font-weight:700; color:#0d47a1;"><span style="color:#FFB800;">⭐</span> 4.9/5 Rating</span>
                        <span style="background: rgba(13,71,161,0.1); border: 1px solid rgba(13,71,161,0.2); border-radius:50px; padding:6px 16px; font-size:0.8rem; font-weight:700; color:#0d47a1;">🏆 Terbaik untuk WHV & Beasiswa</span>
                    </div>

                    <h2 class="text-5xl md:text-6xl font-black font-heading leading-[1.05] mb-2 drop-shadow-sm">
                        <span class="text-tb-blue">ENGLISH SKILLS.</span><br>
                        <span class="text-blue-600">GLOBAL SUCCESS.</span>
                        <div class="mt-4 text-3xl font-bold uppercase {{ $type === 'offline' ? 'text-green-600' : 'text-blue-500' }}">
                            {{ $type === 'offline' ? 'Program Kelas Offline' : 'Program Kelas Online' }}

                        </div>
                    </h2>
                    <p class="text-lg text-gray-700 mb-10 max-w-lg leading-relaxed font-medium">
                        Tingkatkan kemampuan Bahasa Inggris Anda dan capai target skor impian untuk kuliah di luar negeri, beasiswa, atau Australia WHV.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="flex items-center gap-3">
                            <div class="bg-tb-blue text-white rounded-full p-2.5 shadow-md flex items-center justify-center w-10 h-10"><i class="fas fa-chart-line"></i></div>
                            <span class="text-xs font-bold text-tb-blue leading-tight">Kurikulum Terstruktur<br><span class="font-medium text-gray-500">berbasis tujuan skor</span></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-tb-blue text-white rounded-full p-2.5 shadow-md flex items-center justify-center w-10 h-10"><i class="fas fa-chalkboard-teacher"></i></div>
                            <span class="text-xs font-bold text-tb-blue leading-tight">Pengajar Profesional<br><span class="font-medium text-gray-500">& Bersertifikasi</span></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-tb-blue text-white rounded-full p-2.5 shadow-md flex items-center justify-center w-10 h-10"><i class="fas fa-bullseye"></i></div>
                            <span class="text-xs font-bold text-tb-blue leading-tight">Strategi Teruji<br><span class="font-medium text-gray-500">& Materi Up-to-date</span></span>
                        </div>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="w-full md:w-[40%] relative flex items-end justify-end">
                    <img src="{{ asset('images/hero/hero_new.webp') }}" alt="Target Bahasa Students" class="object-cover object-top w-full h-[90%] rounded-tl-[10rem] drop-shadow-2xl opacity-95">
                    
                    <!-- Floating Badge -->
                    <div class="absolute bottom-12 right-6 bg-[#FFB800] p-4 rounded-xl shadow-2xl z-20 flex items-center gap-4 border-2 border-yellow-300">
                        <div class="text-[#1e293b] text-3xl">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-[#1e293b] leading-tight text-lg">Test Gratis!</h4>
                            <p class="text-sm font-bold text-[#1e293b]">Dapatkan Skor Instan</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pilihan Jenis Kelas -->
        <section class="py-16 px-8 relative bg-white">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-tb-blue font-heading tracking-widest px-6">PILIHAN JENIS KELAS {{ strtoupper($type) }}</h2>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto">Kami menyediakan beberapa tipe kelas yang bisa disesuaikan dengan kebutuhan belajarmu.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Regular -->
                <div @click="classType = 'regular'" :class="classType === 'regular' ? 'ring-4 ring-blue-500 bg-slate-100 border-blue-400' : 'border-slate-200'" class="cursor-pointer bg-slate-50 rounded-2xl p-8 border-2 shadow-md hover:shadow-xl hover:border-slate-300 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-users text-6xl text-slate-600"></i>
                    </div>
                    <div class="w-14 h-14 bg-slate-200 text-slate-700 rounded-xl flex items-center justify-center text-2xl mb-6 shadow-sm">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-heading">Regular</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Belajar bersama teman-teman lainnya. Cocok untuk kamu yang suka diskusi kelompok dan suasana kelas yang lebih interaktif.</p>
                </div>
                
                <!-- Semi Private -->
                <div @click="classType = 'semi_private'" :class="classType === 'semi_private' ? 'ring-4 ring-blue-500 bg-blue-100 border-blue-500' : 'border-blue-300'" class="cursor-pointer bg-blue-50 rounded-2xl p-8 border-2 shadow-md hover:shadow-xl hover:border-blue-400 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-user-friends text-6xl text-blue-700"></i>
                    </div>
                    <div class="w-14 h-14 bg-blue-600 text-white rounded-xl flex items-center justify-center text-2xl mb-6 shadow-md">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-heading">Semi Private</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Kelas dengan grup kecil (2-4 orang). Lebih fokus, namun tetap bisa bertukar pikiran dengan teman belajar.</p>
                </div>
                
                <!-- Private -->
                <div @click="classType = 'private'" :class="classType === 'private' ? 'ring-4 ring-amber-500 bg-amber-100 border-amber-500' : 'border-amber-300'" class="cursor-pointer bg-amber-50 rounded-2xl p-8 border-2 shadow-md hover:shadow-xl hover:border-amber-400 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-user text-6xl text-amber-600"></i>
                    </div>
                    <div class="w-14 h-14 bg-amber-500 text-white rounded-xl flex items-center justify-center text-2xl mb-6 shadow-md">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-heading">Private</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Fokus penuh 1-on-1 dengan tutor. Jadwal lebih fleksibel, materi disesuaikan dengan kebutuhan personal kamu.</p>
                </div>
            </div>
        </section>

        <!-- Programs -->
        @php $programPaket = collect();
            $satuanGrammar = collect();
            $satuanIelts = collect();
            $satuanSpeaking = collect();
            $satuanLainnya = collect();

            foreach($programs as $program) {
                if ($program->program_type === 'satuan') {
                    $name = strtolower($program->name);
                    if ($program->slug === 'fast-track-grammar-for-writing' || str_contains($name, 'grammar fast track')) {
                        $satuanIelts->push($program);
                    } elseif (str_contains($name, 'grammar')) {
                        $satuanGrammar->push($program);
                    } elseif (str_contains($name, 'ielts')) {
                        $satuanIelts->push($program);
                    } elseif (str_contains($name, 'speaking')) {
                        $satuanSpeaking->push($program);
                    } else {
                        $satuanLainnya->push($program);
                    }
                } else {
                    $programPaket->push($program);
                }
            }

            $groups = [
                ['title' => 'PROGRAM PAKET', 'desc' => 'Persiapan komprehensif untuk seluruh sesi tes (IELTS, TOEFL, PTE).', 'items' => $programPaket]
            ];
            
            if ($satuanGrammar->count() > 0) {
                $groups[] = ['title' => 'PROGRAM SATUAN: GRAMMAR', 'desc' => 'Perdalam tata bahasa untuk hasil writing maksimal.', 'items' => $satuanGrammar];
            }
            if ($satuanIelts->count() > 0) {
                $groups[] = ['title' => 'PROGRAM SATUAN: IELTS', 'desc' => 'Fokus pada peningkatan skill spesifik IELTS.', 'items' => $satuanIelts];
            }
            if ($satuanSpeaking->count() > 0) {
                $groups[] = ['title' => 'PROGRAM SATUAN: SPEAKING', 'desc' => 'Fokus pada peningkatan skill komunikasi bahasa Inggris.', 'items' => $satuanSpeaking];
            }
            if ($satuanLainnya->count() > 0) {
                $groups[] = ['title' => 'PROGRAM SATUAN: LAINNYA', 'desc' => 'Fokus pada peningkatan skill spesifik.', 'items' => $satuanLainnya];
            } @endphp

        @php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
            @if($group['items']->count() > 0)
            @php
                $hasRegular = false;
                $hasSemi = false;
                $hasPrivate = false;

                foreach($group['items'] as $prog) {
                    $is_default = !in_array($prog->slug, ['ielts-academic-full-package', 'toefl-itp', 'toefl-ibt', 'ielts-general', 'pte-academic']);
                    
                    if ($is_default) {
                        $bp = $type === 'offline' ? ($prog->price_offline ?? $prog->price ?? 0) : ($prog->price ?? 0);
                        $bs = $type === 'offline' ? ($prog->price_semi_private_offline ?? $prog->price_semi_private ?? 0) : ($prog->price_semi_private ?? 0);
                        $bpv = $type === 'offline' ? ($prog->price_private_offline ?? $prog->price_private ?? 0) : ($prog->price_private ?? 0);
                    } else {
                        $bp = $type === 'offline' ? ($prog ? ($prog->price_offline ?? $prog->price ?? 1999000) : 1999000) : ($prog ? $prog->price : 1999000);
                        $bs = $type === 'offline' ? ($prog ? ($prog->price_semi_private_offline ?? $prog->price_semi_private ?? 2499000) : 2499000) : ($prog ? $prog->price_semi_private : 2499000);
                        $bpv = $type === 'offline' ? ($prog ? ($prog->price_private_offline ?? $prog->price_private ?? 3499000) : 3499000) : ($prog ? $prog->price_private : 3499000);
                    }

                    if ($bp > 0) $hasRegular = true;
                    if ($bs > 0) $hasSemi = true;
                    if ($bpv > 0) $hasPrivate = true;
                }
            @endphp
            <section class="py-16 px-8 relative" x-show="classType !== null && ((classType === 'regular' && {{ $hasRegular ? 'true' : 'false' }}) || (classType === 'semi_private' && {{ $hasSemi ? 'true' : 'false' }}) || (classType === 'private' && {{ $hasPrivate ? 'true' : 'false' }}))" x-transition.opacity.duration.500ms>
                <div class="text-center mb-16 relative flex flex-col items-center justify-center">
                    <div class="absolute w-full h-px bg-gray-300 top-1/2"></div>
                    <h2 class="text-3xl font-black text-tb-blue font-heading tracking-widest px-6 bg-white relative z-10">{{ $group['title'] }}</h2>
                    <p class="mt-4 text-gray-500 max-w-2xl bg-white px-4 relative z-10">{{ $group['desc'] }}</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 max-w-6xl mx-auto">
                    @php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
                    
                    @php $base_price = $type === 'offline' ? ($program ? ($program->price_offline ?? $program->price ?? 1999000) : 1999000) : ($program ? $program->price : 1999000);
$base_semi = $type === 'offline' ? ($program ? ($program->price_semi_private_offline ?? $program->price_semi_private ?? 2499000) : 2499000) : ($program ? $program->price_semi_private : 2499000);
$base_priv = $type === 'offline' ? ($program ? ($program->price_private_offline ?? $program->price_private ?? 3499000) : 3499000) : ($program ? $program->price_private : 3499000); @endphp
<div x-show="(classType === 'regular' && {{ $base_price ?: 0 }} > 0) || (classType === 'semi_private' && {{ $base_semi ?: 0 }} > 0) || (classType === 'private' && {{ $base_priv ?: 0 }} > 0)" x-transition>
                    @switch($program->slug)
                        @case('ielts-academic-full-package')
<!-- IELTS -->
                <div class="card flex flex-col h-full theme-ielts overflow-hidden relative group">
                    <!-- Background Image -->
                    <div class="absolute inset-0 w-full h-full bg-cover bg-top z-0 transition-transform duration-700 group-hover:scale-105" style="background-image: url('/images/programs/ielts.webp');"></div>
                    <!-- Image Overlay -->
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: linear-gradient(to bottom, rgba(255,255,255,0.85) 0%, rgba(255,255,255,0) 30%);"></div>
                    <!-- Content Wrapper -->
                    <div class="relative z-10 w-full h-full flex flex-col flex-grow pt-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="card-icon mb-0 shrink-0">IELTS™</div>
                        <div>
                            <h3 class="title text-2xl font-black font-heading mb-1">IELTS PREPARATION</h3>
                            <p class="text-sm font-semibold italic text-gray-600">"Tembus skor IELTS 6.5+ untuk kuliah dan beasiswa luar negeri."</p>
                        </div>
                    </div>
                    
                    <!-- Glass Body Container -->
                        <div class="flex-grow flex flex-col mt-6 p-6 rounded-2xl" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); ">
                            <p class="text-[13.5px] text-gray-700 mb-6 leading-relaxed">
                        Kelas intensif yang dirancang khusus untuk memahami strategi pengerjaan IELTS (Listening, Reading, Writing, Speaking) agar mencapai skor impian.
                    </p>

                    <div class="mb-5">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">COCOK UNTUK:</span>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Mahasiswa</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Pendaftar Beasiswa</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Australia WHV</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Profesional</span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item text-highlight">
                            <i class="far fa-calendar-alt"></i>
                            <div>
                                <span class="info-label">Durasi</span>
                                <span class="info-value">8 - 12 Minggu</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-layer-group"></i>
                            <div>
                                <span class="info-label">Pertemuan</span>
                                <span class="info-value">16 - 24 Meeting</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="far fa-clock"></i>
                            <div>
                                <span class="info-label">Lama Belajar</span>
                                <span class="info-value">90 Menit / Sesi</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-bullseye"></i>
                            <div>
                                <span class="info-label">Target Skor</span>
                                <span class="info-value text-gray-800 font-semibold">Band 5.5 - 7.5+</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 flex-grow">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-3">FASILITAS:</span>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[12.5px] font-medium text-gray-700">
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Placement Test Gratis</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Progress Report</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Modul Digital</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Simulasi Tes</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Rekaman Kelas</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Sertifikat</div>
                        </div>
                    </div>



@if($base_price > 0 || $base_semi > 0 || $base_priv > 0)
@php
    $priceCount = ($base_price > 0 ? 1 : 0) + ($base_semi > 0 ? 1 : 0) + ($base_priv > 0 ? 1 : 0);
    $priceClass = 'text-2xl md:text-3xl';
@endphp

<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">

<div class="flex justify-between items-center w-full mb-1">

<span class="text-xs font-bold text-gray-500 uppercase tracking-wide">INVESTASI:</span>

<div class="flex gap-1.5 justify-end">

@if($type === 'online')

<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>

@else

<span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE (PARE)</span>

@endif

</div>

</div>

<div class="grid grid-cols-1 md:flex md:justify-center gap-2 w-full">

@if($base_price > 0)

<div class="relative group bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'regular'">

<div class="text-[10px] font-bold text-gray-500 uppercase">Regular</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_price, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Belajar bersama teman-teman lainnya. Cocok untuk diskusi kelompok.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_semi > 0)

<div class="relative group bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'semi_private'">

<div class="text-[10px] font-bold text-blue-700 uppercase">Semi Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_semi, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Kelas dengan grup kecil (2-4 orang). Lebih fokus.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_priv > 0)

<div class="relative group bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help flex-1" x-show="classType === 'private'">

<div class="text-[10px] font-bold text-yellow-700 uppercase">Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_priv, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Fokus penuh 1-on-1 dengan tutor. Jadwal lebih fleksibel.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

</div>

</div>

@else
<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6 text-center justify-center min-h-[80px]">
<span class="text-xs font-semibold italic text-gray-500">Untuk harga kelas silahkan hubungi Admin melalui WA ini</span>
</div>
@endif

@if($program && $program->classPeriods->whereIn('status', ['active', 'upcoming'])->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $program->classPeriods->whereIn('status', ['active', 'upcoming'])->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
                            <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-gray-100 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                    <span class="text-xs font-bold text-gray-800">{{ $batch->name }}</span>
                                </div>
                                <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}</span>
                            </div>
                            @php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); @endphp
                        </div>
                    </div>
                    @endif
                    <div class="flex gap-3 mt-auto">
                        <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                        <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                    </div>
                    </div><!-- End Glass Body Container -->
                    </div><!-- End Content Wrapper -->
                </div>

@break
                        @case('toefl-itp')
<!-- TOEFL -->
                <div class="card flex flex-col h-full theme-toefl overflow-hidden relative group">
                    <!-- Background Image -->
                    <div class="absolute inset-0 w-full h-full bg-cover bg-top z-0 transition-transform duration-700 group-hover:scale-105" style="background-image: url('/images/programs/toefl.webp');"></div>
                    <!-- Image Overlay -->
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: linear-gradient(to bottom, rgba(255,255,255,0.85) 0%, rgba(255,255,255,0) 30%);"></div>
                    <!-- Content Wrapper -->
                    <div class="relative z-10 w-full h-full flex flex-col flex-grow pt-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="card-icon mb-0 shrink-0 italic">TOEFL®</div>
                        <div>
                            <h3 class="title text-2xl font-black font-heading mb-1">TOEFL ITP</h3>
                            <p class="text-sm font-semibold italic text-gray-600">"Capai skor TOEFL 500+ dengan strategi cepat dan akurat."</p>
                        </div>
                    </div>
                    
                    <!-- Glass Body Container -->
                        <div class="flex-grow flex flex-col mt-6 p-6 rounded-2xl" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); ">
                            <p class="text-[13.5px] text-gray-700 mb-6 leading-relaxed">
                        Dirancang untuk menaklukkan soal-soal TOEFL ITP/iBT dengan metode terstruktur, fokus pada pola soal yang paling sering muncul.
                    </p>

                    <div class="mb-5">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">COCOK UNTUK:</span>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Mahasiswa</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Syarat Skripsi</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ CPNS / BUMN</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Profesional</span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item text-highlight">
                            <i class="far fa-calendar-alt"></i>
                            <div>
                                <span class="info-label">Durasi</span>
                                <span class="info-value">8 - 12 Minggu</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-layer-group"></i>
                            <div>
                                <span class="info-label">Pertemuan</span>
                                <span class="info-value">16 - 24 Meeting</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="far fa-clock"></i>
                            <div>
                                <span class="info-label">Lama Belajar</span>
                                <span class="info-value">90 Menit / Sesi</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-bullseye"></i>
                            <div>
                                <span class="info-label">Target Skor</span>
                                <span class="info-value text-gray-800 font-semibold">450 - 600+</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 flex-grow">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-3">FASILITAS:</span>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[12.5px] font-medium text-gray-700">
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Placement Test Gratis</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Progress Report</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Modul Digital</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Simulasi Tes</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Rekaman Kelas</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Sertifikat</div>
                        </div>
                    </div>



@if($base_price > 0 || $base_semi > 0 || $base_priv > 0)
@php
    $priceCount = ($base_price > 0 ? 1 : 0) + ($base_semi > 0 ? 1 : 0) + ($base_priv > 0 ? 1 : 0);
    $priceClass = 'text-2xl md:text-3xl';
@endphp

<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">

<div class="flex justify-between items-center w-full mb-1">

<span class="text-xs font-bold text-gray-500 uppercase tracking-wide">INVESTASI:</span>

<div class="flex gap-1.5 justify-end">

@if($type === 'online')

<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>

@else

<span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE (PARE)</span>

@endif

</div>

</div>

<div class="grid grid-cols-1 md:flex md:justify-center gap-2 w-full">

@if($base_price > 0)

<div class="relative group bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'regular'">

<div class="text-[10px] font-bold text-gray-500 uppercase">Regular</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_price, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Belajar bersama teman-teman lainnya. Cocok untuk diskusi kelompok.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_semi > 0)

<div class="relative group bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'semi_private'">

<div class="text-[10px] font-bold text-blue-700 uppercase">Semi Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_semi, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Kelas dengan grup kecil (2-4 orang). Lebih fokus.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_priv > 0)

<div class="relative group bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help flex-1" x-show="classType === 'private'">

<div class="text-[10px] font-bold text-yellow-700 uppercase">Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_priv, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Fokus penuh 1-on-1 dengan tutor. Jadwal lebih fleksibel.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

</div>

</div>

@else
<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6 text-center justify-center min-h-[80px]">
<span class="text-xs font-semibold italic text-gray-500">Untuk harga kelas silahkan hubungi Admin melalui WA ini</span>
</div>
@endif

@if($program && $program->classPeriods->whereIn('status', ['active', 'upcoming'])->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $program->classPeriods->whereIn('status', ['active', 'upcoming'])->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
                            <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-gray-100 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                    <span class="text-xs font-bold text-gray-800">{{ $batch->name }}</span>
                                </div>
                                <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}</span>
                            </div>
                            @php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); @endphp
                        </div>
                    </div>
                    @endif
                    <div class="flex gap-3 mt-auto">
                        <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                        <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                    </div>
                    </div><!-- End Glass Body Container -->
                    </div><!-- End Content Wrapper -->
                </div>

@break
                        @case('toefl-ibt')
<!-- TOEFL iBT -->
                <div class="card flex flex-col h-full theme-toefl overflow-hidden relative group">
                    <!-- Background Image -->
                    <div class="absolute inset-0 w-full h-full bg-cover bg-top z-0 transition-transform duration-700 group-hover:scale-105" style="background-image: url('/images/programs/toefl.webp');"></div>
                    <!-- Image Overlay -->
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: linear-gradient(to bottom, rgba(255,255,255,0.85) 0%, rgba(255,255,255,0) 30%);"></div>
                    <!-- Content Wrapper -->
                    <div class="relative z-10 w-full h-full flex flex-col flex-grow pt-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="card-icon mb-0 shrink-0 italic">TOEFL®</div>
                        <div>
                            <h3 class="title text-2xl font-black font-heading mb-1">TOEFL IBT</h3>
                            <p class="text-sm font-semibold italic text-gray-600">"Taklukkan tes berbasis internet secara komprehensif."</p>
                        </div>
                    </div>
                    
                    <!-- Glass Body Container -->
                        <div class="flex-grow flex flex-col mt-6 p-6 rounded-2xl" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); ">
                            <p class="text-[13.5px] text-gray-700 mb-6 leading-relaxed">
                        Dirancang untuk menghadapi format terbaru TOEFL iBT dengan strategi efektif di 4 skill: Reading, Listening, Speaking, dan Writing.
                    </p>

                    <div class="mb-5">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">COCOK UNTUK:</span>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Studi Luar Negeri</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Beasiswa LPDP</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Bekerja & Migrasi</span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item text-highlight">
                            <i class="far fa-calendar-alt"></i>
                            <div>
                                <span class="info-label">Durasi</span>
                                <span class="info-value">8 - 12 Minggu</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-layer-group"></i>
                            <div>
                                <span class="info-label">Pertemuan</span>
                                <span class="info-value">16 - 24 Meeting</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="far fa-clock"></i>
                            <div>
                                <span class="info-label">Lama Belajar</span>
                                <span class="info-value">90 Menit / Sesi</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-bullseye"></i>
                            <div>
                                <span class="info-label">Target Skor</span>
                                <span class="info-value text-gray-800 font-semibold">80 - 100+</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 flex-grow">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-3">FASILITAS:</span>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[12.5px] font-medium text-gray-700">
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Placement Test Gratis</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Progress Report</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Modul Digital</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Simulasi Tes (AI)</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Rekaman Kelas</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Sertifikat</div>
                        </div>
                    </div>



@if($base_price > 0 || $base_semi > 0 || $base_priv > 0)
@php
    $priceCount = ($base_price > 0 ? 1 : 0) + ($base_semi > 0 ? 1 : 0) + ($base_priv > 0 ? 1 : 0);
    $priceClass = 'text-2xl md:text-3xl';
@endphp

<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">

<div class="flex justify-between items-center w-full mb-1">

<span class="text-xs font-bold text-gray-500 uppercase tracking-wide">INVESTASI:</span>

<div class="flex gap-1.5 justify-end">

@if($type === 'online')

<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>

@else

<span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE (PARE)</span>

@endif

</div>

</div>

<div class="grid grid-cols-1 md:flex md:justify-center gap-2 w-full">

@if($base_price > 0)

<div class="relative group bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'regular'">

<div class="text-[10px] font-bold text-gray-500 uppercase">Regular</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_price, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Belajar bersama teman-teman lainnya. Cocok untuk diskusi kelompok.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_semi > 0)

<div class="relative group bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'semi_private'">

<div class="text-[10px] font-bold text-blue-700 uppercase">Semi Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_semi, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Kelas dengan grup kecil (2-4 orang). Lebih fokus.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_priv > 0)

<div class="relative group bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help flex-1" x-show="classType === 'private'">

<div class="text-[10px] font-bold text-yellow-700 uppercase">Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_priv, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Fokus penuh 1-on-1 dengan tutor. Jadwal lebih fleksibel.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

</div>

</div>

@else
<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6 text-center justify-center min-h-[80px]">
<span class="text-xs font-semibold italic text-gray-500">Untuk harga kelas silahkan hubungi Admin melalui WA ini</span>
</div>
@endif

@if($program && $program->classPeriods->whereIn('status', ['active', 'upcoming'])->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $program->classPeriods->whereIn('status', ['active', 'upcoming'])->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
                            <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-gray-100 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                    <span class="text-xs font-bold text-gray-800">{{ $batch->name }}</span>
                                </div>
                                <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}</span>
                            </div>
                            @php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); @endphp
                        </div>
                    </div>
                    @endif
                    <div class="flex gap-3 mt-auto">
                        <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                        <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                    </div>
                    </div><!-- End Glass Body Container -->
                    </div><!-- End Content Wrapper -->
                </div>

                            @break
                        @case('ielts-general')
                        
<!-- IELTS GENERAL -->
                <div class="card flex flex-col h-full theme-ielts-general overflow-hidden relative group">
                    <!-- Background Image -->
                    <div class="absolute inset-0 w-full h-full bg-cover bg-top z-0 transition-transform duration-700 group-hover:scale-105" style="background-image: url('/images/programs/ielts.webp');"></div>
                    <!-- Image Overlay -->
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: linear-gradient(to bottom, rgba(255,255,255,0.85) 0%, rgba(255,255,255,0) 30%);"></div>
                    <!-- Content Wrapper -->
                    <div class="relative z-10 w-full h-full flex flex-col flex-grow pt-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="card-icon mb-0 shrink-0"><span class="text-xl">IELTS</span></div>
                        <div>
                            <h3 class="title text-2xl font-black font-heading mb-1">IELTS GENERAL</h3>
                            <p class="text-sm font-semibold italic text-gray-600">"Persiapan praktis untuk migrasi & bekerja ke luar negeri."</p>
                        </div>
                    </div>
                    
                    <!-- Glass Body Container -->
                        <div class="flex-grow flex flex-col mt-6 p-6 rounded-2xl" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); ">
                            <p class="text-[13.5px] text-gray-700 mb-6 leading-relaxed">
                        Dirancang khusus untuk menguasai format IELTS General Training dengan fokus pada komunikasi sehari-hari dan lingkungan kerja, membantu Anda meraih skor target untuk keperluan visa dan PR.
                    </p>

                    <div class="mb-5">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">COCOK UNTUK:</span>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Australia WHV</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Pendaftar Visa & PR</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Bekerja di Luar Negeri</span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item text-highlight">
                            <i class="far fa-calendar-alt"></i>
                            <div>
                                <span class="info-label">Durasi</span>
                                <span class="info-value">8 - 12 Minggu</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-layer-group"></i>
                            <div>
                                <span class="info-label">Pertemuan</span>
                                <span class="info-value">16 - 24 Meeting</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="far fa-clock"></i>
                            <div>
                                <span class="info-label">Lama Belajar</span>
                                <span class="info-value">90 Menit / Sesi</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-bullseye"></i>
                            <div>
                                <span class="info-label">Target Skor</span>
                                <span class="info-value text-gray-800 font-semibold">Band 6.5 - 7.5+</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 flex-grow">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-3">FASILITAS:</span>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[12.5px] font-medium text-gray-700">
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Placement Test Gratis</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Progress Report</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Modul Digital</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Simulasi Tes (AI)</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Rekaman Kelas</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Sertifikat</div>
                        </div>
                    </div>



@if($base_price > 0 || $base_semi > 0 || $base_priv > 0)
@php
    $priceCount = ($base_price > 0 ? 1 : 0) + ($base_semi > 0 ? 1 : 0) + ($base_priv > 0 ? 1 : 0);
    $priceClass = 'text-2xl md:text-3xl';
@endphp

<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">

<div class="flex justify-between items-center w-full mb-1">

<span class="text-xs font-bold text-gray-500 uppercase tracking-wide">INVESTASI:</span>

<div class="flex gap-1.5 justify-end">

@if($type === 'online')

<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>

@else

<span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE (PARE)</span>

@endif

</div>

</div>

<div class="grid grid-cols-1 md:flex md:justify-center gap-2 w-full">

@if($base_price > 0)

<div class="relative group bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'regular'">

<div class="text-[10px] font-bold text-gray-500 uppercase">Regular</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_price, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Belajar bersama teman-teman lainnya. Cocok untuk diskusi kelompok.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_semi > 0)

<div class="relative group bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'semi_private'">

<div class="text-[10px] font-bold text-blue-700 uppercase">Semi Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_semi, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Kelas dengan grup kecil (2-4 orang). Lebih fokus.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_priv > 0)

<div class="relative group bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help flex-1" x-show="classType === 'private'">

<div class="text-[10px] font-bold text-yellow-700 uppercase">Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_priv, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Fokus penuh 1-on-1 dengan tutor. Jadwal lebih fleksibel.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

</div>

</div>

@else
<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6 text-center justify-center min-h-[80px]">
<span class="text-xs font-semibold italic text-gray-500">Untuk harga kelas silahkan hubungi Admin melalui WA ini</span>
</div>
@endif

@if($program && $program->classPeriods->whereIn('status', ['active', 'upcoming'])->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $program->classPeriods->whereIn('status', ['active', 'upcoming'])->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
                            <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-gray-100 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                    <span class="text-xs font-bold text-gray-800">{{ $batch->name }}</span>
                                </div>
                                <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}</span>
                            </div>
                            @php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); @endphp
                        </div>
                    </div>
                    @endif
                    <div class="flex gap-3 mt-auto">
                        <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                        <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                    </div>
                    </div><!-- End Glass Body Container -->
                    </div><!-- End Content Wrapper -->
                </div>

                            @break
                                                @case('pte-academic')
                        
<!-- PTE -->
                <div class="card flex flex-col h-full theme-pte overflow-hidden relative group">
                    <!-- Background Image -->
                    <div class="absolute inset-0 w-full h-full bg-cover bg-top z-0 transition-transform duration-700 group-hover:scale-105" style="background-image: url('/images/programs/pte.webp');"></div>
                    <!-- Image Overlay -->
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: linear-gradient(to bottom, rgba(255,255,255,0.85) 0%, rgba(255,255,255,0) 30%);"></div>
                    <!-- Content Wrapper -->
                    <div class="relative z-10 w-full h-full flex flex-col flex-grow pt-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="card-icon mb-0 shrink-0"><span class="text-xl">PTE</span></div>
                        <div>
                            <h3 class="title text-2xl font-black font-heading mb-1">PTE ACADEMIC</h3>
                            <p class="text-sm font-semibold italic text-gray-600">"Strategi cerdas taklukkan tes berbasis komputer."</p>
                        </div>
                    </div>
                    
                    <!-- Glass Body Container -->
                        <div class="flex-grow flex flex-col mt-6 p-6 rounded-2xl" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); ">
                            <p class="text-[13.5px] text-gray-700 mb-6 leading-relaxed">
                        Persiapan komprehensif PTE Academic yang berfokus pada format unik tes komputer dan algoritma penilaian AI untuk mengejar skor ideal Anda.
                    </p>

                    <div class="mb-5">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">COCOK UNTUK:</span>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Australia WHV</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Pendaftar Visa & PR</span>
                            <span class="px-2 py-1 theme-tag rounded text-xs font-semibold">✓ Pelajar</span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item text-highlight">
                            <i class="far fa-calendar-alt"></i>
                            <div>
                                <span class="info-label">Durasi</span>
                                <span class="info-value">8 - 12 Minggu</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-layer-group"></i>
                            <div>
                                <span class="info-label">Pertemuan</span>
                                <span class="info-value">16 - 24 Meeting</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="far fa-clock"></i>
                            <div>
                                <span class="info-label">Lama Belajar</span>
                                <span class="info-value">90 Menit / Sesi</span>
                            </div>
                        </div>
                        <div class="info-item text-highlight">
                            <i class="fas fa-bullseye"></i>
                            <div>
                                <span class="info-label">Target Skor</span>
                                <span class="info-value text-gray-800 font-semibold">50 - 79+</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 flex-grow">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-3">FASILITAS:</span>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[12.5px] font-medium text-gray-700">
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Placement Test Gratis</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Progress Report</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Modul Digital</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Simulasi Tes (AI)</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Rekaman Kelas</div>
                            <div class="flex items-center gap-1.5"><i class="fas fa-check-circle theme-check"></i> Sertifikat</div>
                        </div>
                    </div>



@if($base_price > 0 || $base_semi > 0 || $base_priv > 0)
@php
    $priceCount = ($base_price > 0 ? 1 : 0) + ($base_semi > 0 ? 1 : 0) + ($base_priv > 0 ? 1 : 0);
    $priceClass = 'text-2xl md:text-3xl';
@endphp

<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">

<div class="flex justify-between items-center w-full mb-1">

<span class="text-xs font-bold text-gray-500 uppercase tracking-wide">INVESTASI:</span>

<div class="flex gap-1.5 justify-end">

@if($type === 'online')

<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>

@else

<span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE (PARE)</span>

@endif

</div>

</div>

<div class="grid grid-cols-1 md:flex md:justify-center gap-2 w-full">

@if($base_price > 0)

<div class="relative group bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'regular'">

<div class="text-[10px] font-bold text-gray-500 uppercase">Regular</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_price, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Belajar bersama teman-teman lainnya. Cocok untuk diskusi kelompok.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_semi > 0)

<div class="relative group bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help flex-1" x-show="classType === 'semi_private'">

<div class="text-[10px] font-bold text-blue-700 uppercase">Semi Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_semi, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Kelas dengan grup kecil (2-4 orang). Lebih fokus.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

@if($base_priv > 0)

<div class="relative group bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help flex-1" x-show="classType === 'private'">

<div class="text-[10px] font-bold text-yellow-700 uppercase">Private</div>

<div class="{{ $priceClass }} font-black text-tb-blue mt-0.5" style="white-space: nowrap;">Rp {{ number_format($base_priv, 0, ',', '.') }}</div>

<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">

Fokus penuh 1-on-1 dengan tutor. Jadwal lebih fleksibel.

<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>

</div>

</div>

@endif

</div>

</div>

@else
<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6 text-center justify-center min-h-[80px]">
<span class="text-xs font-semibold italic text-gray-500">Untuk harga kelas silahkan hubungi Admin melalui WA ini</span>
</div>
@endif

@if($program && $program->classPeriods->whereIn('status', ['active', 'upcoming'])->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $program->classPeriods->whereIn('status', ['active', 'upcoming'])->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
                            <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-gray-100 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                    <span class="text-xs font-bold text-gray-800">{{ $batch->name }}</span>
                                </div>
                                <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}</span>
                            </div>
                            @php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); @endphp
                        </div>
                    </div>
                    @endif
                    <div class="flex gap-3 mt-auto">
                        <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                        <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                    </div>
                    </div><!-- End Glass Body Container -->
                    </div><!-- End Content Wrapper -->
                </div>

@break

                        @default
                @php $tailwindColors = [
                        'rose' => '#e11d48', 'amber' => '#d97706', 'yellow' => '#ca8a04', 'green' => '#16a34a', 
                        'emerald' => '#059669', 'teal' => '#0d9488', 'cyan' => '#0891b2', 'sky' => '#0284c7', 
                        'blue' => '#2563eb', 'indigo' => '#4f46e5', 'violet' => '#7c3aed', 'purple' => '#9333ea', 
                        'fuchsia' => '#c026d3', 'pink' => '#db2777', 'red' => '#dc2626', 'orange' => '#ea580c'
                    ];
                    $themeColor = $program->color ?? '#3b82f6';
                    if (array_key_exists(strtolower($themeColor), $tailwindColors)) {
                        $themeColor = $tailwindColors[strtolower($themeColor)];
                    }

                    $bgImage = null;
                    if ($program->brochure_image) {
                        $bgImage = asset('storage/'.$program->brochure_image);
                    } else {
                        $nameLower = strtolower($program->name);
                        if (str_contains($nameLower, 'grammar')) {
                            $bgImage = '/images/programs/grammar.webp';
                        } elseif (str_contains($nameLower, 'speaking')) {
                            $bgImage = '/images/programs/speaking.webp';
                        } elseif (str_contains($nameLower, 'listening')) {
                            $bgImage = '/images/programs/listening.webp';
                        } elseif (str_contains($nameLower, 'ielts')) {
                            $bgImage = '/images/programs/ielts.webp';
                        } elseif (str_contains($nameLower, 'toefl')) {
                            $bgImage = '/images/programs/toefl.webp';
                        } elseif (str_contains($nameLower, 'pte')) {
                            $bgImage = '/images/programs/pte.webp';
                        }
                    }

                    // Determine button text color based on background brightness
                    $hex = str_replace('#', '', $themeColor);
                    if (strlen($hex) == 3 || strlen($hex) == 6) {
                        if (strlen($hex) == 3) {
                            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                        } else {
                            $r = hexdec(substr($hex,0,2));
                            $g = hexdec(substr($hex,2,2));
                            $b = hexdec(substr($hex,4,2));
                        }
                        $yiq = (($r*299)+($g*587)+($b*114))/1000;
                        $btnTextColor = ($yiq >= 150) ? '#1f2937' : 'white';
                    } else {
                        $btnTextColor = 'white';
                    } @endphp
                <!-- GENERIC CARD -->
                <div class="card flex flex-col h-full overflow-hidden relative group" style="--theme-color: {{ $themeColor }}; border-top: none;">
                    <!-- Background Image -->
                    <div class="absolute inset-0 w-full h-full bg-cover bg-top z-0 transition-transform duration-700 group-hover:scale-105" 
                         style="background-color: {{ $themeColor }}; {{ $bgImage ? 'background-image: url(\''.$bgImage.'\');' : 'background-image: linear-gradient(135deg, '.$themeColor.' 0%, '.$themeColor.'88 100%);' }}">
                    </div>
                    <!-- Image Overlay -->
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: linear-gradient(to bottom, rgba(255,255,255,0.92) 0%, rgba(255,255,255,{{ $bgImage ? '0' : '0.4' }}) {{ $bgImage ? '35%' : '100%' }});"></div>
                    
                    <!-- Content Wrapper -->
                    <div class="relative z-10 w-full h-full flex flex-col flex-grow pt-2">
                        <div class="flex items-center gap-4 mb-4">
                            <div>
                                <h3 class="title text-2xl font-black font-heading mb-1" style="color: {{ $themeColor }}">{{ strtoupper($program->name) }}</h3>
                                @if($program->period)
                                <p class="text-sm font-semibold italic text-gray-600">"{{ $program->period }}"</p>
                                @endif
                            </div>
                        </div>

<!-- Glass Body Container -->
                        <div class="flex-grow flex flex-col mt-6 p-6 rounded-2xl" style="background: rgba(255, 255, 255, 0.90); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8);">
                            <p class="text-[13.5px] text-gray-700 mb-6 leading-relaxed">
                                {{ $program->description ?? 'Program intensif yang dirancang untuk membantu Anda menguasai materi dengan metode belajar yang efektif dan terstruktur.' }}

                            </p>

                            <div class="info-grid mb-4">
                                <div class="info-item" style="color: {{ $themeColor }}">
                                    <i class="far fa-calendar-alt"></i>
                                    <div>
                                        <span class="info-label">Durasi</span>
                                        <span class="info-value">1 Bulan</span>
                                    </div>
                                </div>
                                <div class="info-item" style="color: {{ $themeColor }}">
                                    <i class="fas fa-layer-group"></i>
                                    <div>
                                        <span class="info-label">Pertemuan</span>
                                        <span class="info-value">10 Meeting</span>
                                    </div>
                                </div>
                                <div class="info-item" style="color: {{ $themeColor }}">
                                    <i class="far fa-clock"></i>
                                    <div>
                                        <span class="info-label">Lama Belajar</span>
                                        <span class="info-value">90 Menit/Sesi</span>
                                    </div>
                                </div>
                                <div class="info-item" style="color: {{ $themeColor }}">
                                    <i class="fas fa-bolt"></i>
                                    <div>
                                        <span class="info-label">Level</span>
                                        <span class="info-value">All Levels</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-6 flex-grow">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-3">FASILITAS:</span>
                                <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-[12.5px] font-medium text-gray-700">
                                    <div class="flex items-center gap-1.5"><i class="fas fa-check-circle" style="color: {{ $themeColor }}"></i> Modul Digital</div>
                                    <div class="flex items-center gap-1.5"><i class="fas fa-check-circle" style="color: {{ $themeColor }}"></i> Latihan & Evaluasi</div>
                                    <div class="flex items-center gap-1.5"><i class="fas fa-check-circle" style="color: {{ $themeColor }}"></i> Progress Report</div>
                                    <div class="flex items-center gap-1.5"><i class="fas fa-check-circle" style="color: {{ $themeColor }}"></i> Rekaman Kelas</div>
                                    <div class="flex items-center gap-1.5"><i class="fas fa-check-circle" style="color: {{ $themeColor }}"></i> Sertifikat</div>
                                    <div class="flex items-center gap-1.5"><i class="fas fa-check-circle" style="color: {{ $themeColor }}"></i> Konsultasi Tutor</div>
                                </div>
                            </div>

                            @php $base_price = $type === 'offline' ? ($program->price_offline ?? $program->price ?? 0) : ($program->price ?? 0);
                                    $base_semi = $type === 'offline' ? ($program->price_semi_private_offline ?? $program->price_semi_private ?? 0) : ($program->price_semi_private ?? 0);
                                    $base_priv = $type === 'offline' ? ($program->price_private_offline ?? $program->price_private ?? 0) : ($program->price_private ?? 0); @endphp
                                @if($base_price > 0 || $base_semi > 0 || $base_priv > 0)
@php
    $priceCount = ($base_price > 0 ? 1 : 0) + ($base_semi > 0 ? 1 : 0) + ($base_priv > 0 ? 1 : 0);
    $priceClass = 'text-2xl md:text-3xl';
@endphp
                                <div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">
                                    <div class="flex justify-between items-center w-full mb-1">
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">INVESTASI:</span>
                                        <div class="flex gap-1.5 justify-end">
                                            @if($type === 'online')
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>
                                            @else
                                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE (PARE)</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-center gap-2 w-full mt-2">
                                        @if($base_price > 0)
                                        <div class="flex-1 bg-white rounded p-2 border border-gray-100 text-center" x-show="classType === 'regular'">
                                            <div class="text-[9px] font-bold text-gray-500 uppercase">Regular</div>
                                            <div class="{{ $priceClass }} font-black mt-0.5" style="color: {{ $themeColor }}; white-space: nowrap;">Rp {{ number_format($base_price, 0, ',', '.') }}</div>
                                        </div>
                                        @endif
                                        @if($base_semi > 0)
                                        <div class="flex-1 bg-white rounded p-2 border border-gray-100 text-center" x-show="classType === 'semi_private'">
                                            <div class="text-[9px] font-bold text-gray-500 uppercase">Semi Private</div>
                                            <div class="{{ $priceClass }} font-black mt-0.5" style="color: {{ $themeColor }}; white-space: nowrap;">Rp {{ number_format($base_semi, 0, ',', '.') }}</div>
                                        </div>
                                        @endif
                                        @if($base_priv > 0)
                                        <div class="flex-1 bg-white rounded p-2 border border-gray-100 text-center" x-show="classType === 'private'">
                                            <div class="text-[9px] font-bold text-gray-500 uppercase">Private</div>
                                            <div class="{{ $priceClass }} font-black mt-0.5" style="color: {{ $themeColor }}; white-space: nowrap;">Rp {{ number_format($base_priv, 0, ',', '.') }}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @else
<div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6 text-center justify-center min-h-[80px]">
<span class="text-xs font-semibold italic text-gray-500">Untuk harga kelas silahkan hubungi Admin melalui WA ini</span>
</div>
@endif
@if($program->classPeriods->whereIn('status', ['active', 'upcoming'])->isNotEmpty())
                            <div class="mb-4">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                                <div class="space-y-1.5">
                                    @php $__currentLoopData = $program->classPeriods->whereIn('status', ['active', 'upcoming'])->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
                                    <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-gray-100 shadow-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                            <span class="text-xs font-bold text-gray-800">{{ $batch->name }}</span>
                                        </div>
                                        <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}</span>
                                    </div>
                                    @php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); @endphp
                                </div>
                            </div>
                            @endif

                            <div class="flex gap-3 mt-auto">
                                <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center" style="background-color: {{ $themeColor }}; color: {{ $btnTextColor }};">Daftar Sekarang</a>
                                <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                            </div>
                        </div><!-- End Glass Body Container -->
                    </div><!-- End Content Wrapper -->
                </div>
                    @endswitch
</div>
                @php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); @endphp
            </div>
            </section>
            @endif
        @php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); @endphp

        <!-- Keunggulan -->
        <section class="py-16 px-8 mb-4 bg-slate-100">
            <div class="text-center mb-12 relative flex items-center justify-center">
                <div class="absolute w-full h-px bg-gray-300"></div>
                <h2 class="text-2xl font-black text-tb-blue font-heading tracking-widest px-6 bg-slate-100 relative z-10 uppercase">⭐ Mengapa Memilih Target Bahasa?</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-y-10 gap-x-6 text-center max-w-5xl mx-auto px-4">
                <div>
                    <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Tutor Bersertifikat Internasional</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Dibimbing langsung oleh para pakar berpengalaman.</p>
                </div>
                <div>
                    <div class="feature-icon"><i class="fas fa-bullseye"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Kurikulum Berbasis Target Skor</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Dirancang khusus untuk mencapai target secara presisi.</p>
                </div>
                <div>
                    <div class="feature-icon"><i class="fas fa-laptop-code"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Simulasi Tes Berkala</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Latihan simulasi yang terstruktur seperti tes asli.</p>
                </div>
                <div>
                    <div class="feature-icon"><i class="fas fa-comment-dots"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Feedback Personal</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Bimbingan personal untuk perbaikan berkelanjutan.</p>
                </div>
                <div>
                    <div class="feature-icon"><i class="far fa-calendar-check"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Jadwal Fleksibel</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Pilih jadwal belajar sesuai kesibukan Anda.</p>
                </div>
                <div>
                    <div class="feature-icon"><i class="fas fa-globe"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Online & Offline Learning</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Belajar kapan saja dan di mana saja tanpa batas.</p>
                </div>
                <div>
                    <div class="feature-icon"><i class="fas fa-sync-alt"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Materi Selalu Up-to-Date</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Disesuaikan dengan perubahan format tes terbaru.</p>
                </div>
                <div>
                    <div class="feature-icon"><i class="fas fa-headset"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Konsultasi Akademik Gratis</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Konsultasi pendidikan dan studi ke luar negeri gratis.</p>
                </div>
                <div>
                    <div class="feature-icon"><i class="fas fa-plane-departure"></i></div>
                    <h4 class="font-bold text-tb-blue mb-2 text-sm leading-tight">Alumni Berhasil</h4>
                    <p class="text-[13px] text-gray-500 font-medium">Terbukti membantu alumni meraih Beasiswa dan WHV.</p>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-16 px-8 relative">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 relative">
                        <div class="absolute -top-4 -left-4 text-5xl text-[#FFB800] opacity-50"><i class="fas fa-quote-left"></i></div>
                        <div class="flex text-[#FFB800] mb-4 text-sm">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-gray-700 italic mb-6 text-sm leading-relaxed">
                            "Dalam 2 bulan skor IELTS saya naik dari Band 5.5 menjadi 7.0. Strateginya sangat membantu dan latihan speaking-nya mirip tes asli. Sekarang saya siap mendaftar WHV Australia!"
                        </p>
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=Andi+Pratama&background=0D47A1&color=fff" alt="Andi Pratama" class="w-12 h-12 rounded-full border-2 border-gray-200">
                            <div>
                                <h4 class="font-bold text-tb-blue text-sm">Andi Pratama</h4>
                                <p class="text-xs text-gray-500">IELTS Preparation Student</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 relative">
                        <div class="absolute -top-4 -left-4 text-5xl text-[#FFB800] opacity-50"><i class="fas fa-quote-left"></i></div>
                        <div class="flex text-[#FFB800] mb-4 text-sm">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-gray-700 italic mb-6 text-sm leading-relaxed">
                            "Belajar TOEFL di sini sangat terstruktur. Target saya awalnya cuma 500 untuk syarat skripsi, tapi setelah ikut program 2 bulan malah dapet 580! Sangat direkomendasikan."
                        </p>
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=Siti+Aisyah&background=1d4ed8&color=fff" alt="Siti Aisyah" class="w-12 h-12 rounded-full border-2 border-gray-200">
                            <div>
                                <h4 class="font-bold text-tb-blue text-sm">Siti Aisyah</h4>
                                <p class="text-xs text-gray-500">TOEFL Preparation Student</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        <section class="bg-tb-blue py-20 px-8 relative overflow-hidden">
            <div class="absolute inset-0 z-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            
            <div class="max-w-4xl mx-auto relative z-10 text-center">
                <h2 class="text-3xl md:text-5xl font-black text-white font-heading mb-4">Mulai Perjalanan Menuju Skor Impian Anda</h2>
                <p class="text-blue-100 text-base md:text-lg mb-10 max-w-2xl mx-auto font-medium">Ikuti placement test gratis dan dapatkan rekomendasi program yang sesuai dengan level serta target Anda.</p>
                
                <div class="flex flex-wrap justify-center gap-4 md:gap-8 mb-10">
                    <div class="flex items-center gap-2 text-white font-semibold"><i class="fas fa-bullseye text-[#FFB800] text-xl"></i> Placement Test Gratis</div>
                    <div class="flex items-center gap-2 text-white font-semibold"><i class="fas fa-headset text-[#FFB800] text-xl"></i> Konsultasi Gratis</div>
                    <div class="flex items-center gap-2 text-white font-semibold"><i class="fas fa-laptop-house text-[#FFB800] text-xl"></i> Kelas Online & Offline</div>
                    <div class="flex items-center gap-2 text-white font-semibold"><i class="fas fa-award text-[#FFB800] text-xl"></i> Tutor Berpengalaman</div>
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#" class="bg-[#FFB800] text-[#0d47a1] font-black py-4 px-8 rounded-xl shadow-xl hover:bg-yellow-400 hover:-translate-y-1 transition transform uppercase tracking-wider text-sm md:text-base">DAPATKAN SKOR SAYA SEKARANG</a>
                    <a href="#" class="bg-transparent border-2 border-white text-white font-black py-4 px-8 rounded-xl hover:bg-white hover:text-[#0d47a1] transition uppercase tracking-wider text-sm md:text-base">KONSULTASI GRATIS</a>
                </div>
            </div>
        </section>

        <!-- Footer Contact Info -->
        <footer class="bg-slate-900 text-white py-8 border-t-4 border-[#FFB800]">
            <div class="max-w-6xl mx-auto px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <img src="/images/brand/logo.png" alt="Target Bahasa" class="h-10 opacity-80 filter grayscale brightness-200">
                    <p class="text-sm text-gray-400 font-medium">© {{ date('Y') }} Target Bahasa. All rights reserved.</p>
                </div>
                <div class="flex gap-6 text-gray-400">
                    <a href="#" class="hover:text-white transition"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-facebook text-xl"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-youtube text-xl"></i></a>
                </div>
            </div>
        </footer>
        
    </div>

</body>
</html>
@php /**PATH /Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php ENDPATH**/ @endphp