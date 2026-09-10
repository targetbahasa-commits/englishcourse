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

    <div class="max-w-[1280px] mx-auto bg-white shadow-2xl relative overflow-hidden" 
     x-data="{ 
         classType: null,
         brochureModalOpen: false,
         brochureTitle: '',
         brochurePdfUrl: '',
         brochureDownloadUrl: '',
         openBrochure(title, pdfUrl, downloadUrl) {
             this.brochureTitle = title;
             this.brochurePdfUrl = pdfUrl;
             this.brochureDownloadUrl = downloadUrl;
             this.brochureModalOpen = true;
             document.body.style.overflow = 'hidden';
         },
         closeBrochure() {
             this.brochureModalOpen = false;
             this.brochurePdfUrl = '';
             document.body.style.overflow = '';
         }
     }">
        
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
                    if ($program->slug === 'fast-track-grammar-for-writing' || str_contains($name, 'fast track') || str_contains($name, 'grammar')) {
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

            // Sort Grammar programs logically
            $grammarOrder = [
                'introductory-grammar-for-writing' => 1,
                'fast-track-grammar-for-writing' => 2,
                'complexity-grammar-for-writing' => 3,
                'proficiency-grammar-for-writing' => 4,
            ];
            $satuanGrammar = $satuanGrammar->sortBy(function($p) use ($grammarOrder) {
                return $grammarOrder[$p->slug] ?? 99;
            })->values();

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
                        $bp = $type === 'offline' ? (($prog->price_offline ?? 0) > 0 ? $prog->price_offline : (($prog->price ?? 0) > 0 ? $prog->price : 1999000)) : (($prog->price ?? 0) > 0 ? $prog->price : 1999000);
                        $bs = $type === 'offline' ? (($prog->price_semi_private_offline ?? 0) > 0 ? $prog->price_semi_private_offline : (($prog->price_semi_private ?? 0) > 0 ? $prog->price_semi_private : 2499000)) : (($prog->price_semi_private ?? 0) > 0 ? $prog->price_semi_private : 2499000);
                        $bpv = $type === 'offline' ? (($prog->price_private_offline ?? 0) > 0 ? $prog->price_private_offline : (($prog->price_private ?? 0) > 0 ? $prog->price_private : 3499000)) : (($prog->price_private ?? 0) > 0 ? $prog->price_private : 3499000);
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
                    
                    @php $base_price = $type === 'offline' ? (($program->price_offline ?? 0) > 0 ? $program->price_offline : (($program->price ?? 0) > 0 ? $program->price : 1999000)) : (($program->price ?? 0) > 0 ? $program->price : 1999000);
$base_semi = $type === 'offline' ? (($program->price_semi_private_offline ?? 0) > 0 ? $program->price_semi_private_offline : (($program->price_semi_private ?? 0) > 0 ? $program->price_semi_private : 2499000)) : (($program->price_semi_private ?? 0) > 0 ? $program->price_semi_private : 2499000);
$base_priv = $type === 'offline' ? (($program->price_private_offline ?? 0) > 0 ? $program->price_private_offline : (($program->price_private ?? 0) > 0 ? $program->price_private : 3499000)) : (($program->price_private ?? 0) > 0 ? $program->price_private : 3499000); @endphp
<div x-show="(classType === 'regular' && {{ $base_price ?: 0 }} > 0) || (classType === 'semi_private' && {{ $base_semi ?: 0 }} > 0) || (classType === 'private' && {{ $base_priv ?: 0 }} > 0)" x-transition>
                    @switch($program->slug)
                        @case('ielts-academic-full-package')
<!-- IELTS -->
                <div class="card flex flex-col h-full theme-ielts overflow-hidden relative group">
                    <!-- Background Image -->
                    <div class="absolute inset-0 w-full h-full bg-cover bg-top z-0 transition-transform duration-700 group-hover:scale-105" style="background-image: url('/images/programs/ielts.webp');"></div>
                    <!-- Image Overlay -->
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: rgba(255,255,255,0.85);"></div>
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

@php $validBatches = $program ? $program->classPeriods->filter(fn($b) => in_array($b->status, ['active', 'upcoming']) && (!$b->end_date || \Carbon\Carbon::parse($b->end_date)->endOfDay()->gte(now()->startOfDay())))->sortBy('start_date')->take(2) : collect(); @endphp
@if($validBatches->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $validBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
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
                    <div class="flex flex-col gap-2.5 mt-auto">
                                                <button type="button" 
                                onclick="window.openSyllabusModal('{{ $program->slug }}', '{{ addslashes($program->name) }}', '{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}')" 
                                class="w-full py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-indigo-700 border border-indigo-200/80 shadow-xs flex items-center justify-center gap-2 group cursor-pointer">
                            <i class="fas fa-book-open text-indigo-600 group-hover:scale-110 transition-transform"></i>
                            <span>Materi Pembelajaran</span>
                        </button>
                        <div class="flex gap-2">
                            <button type="button" 
                                    onclick="window.openBrochureModal('{{ addslashes($program->name) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type]) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}')" 
                                    class="flex-1 py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 shadow-sm flex items-center justify-center gap-2">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                <span>Brosur PDF</span>
                            </button>
                            <a href="{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}" 
                               class="py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm flex items-center justify-center gap-1.5 shrink-0" 
                               title="Download Brosur PDF">
                                <i class="fas fa-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                            <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                        </div>
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
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: rgba(255,255,255,0.85);"></div>
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

@php $validBatches = $program ? $program->classPeriods->filter(fn($b) => in_array($b->status, ['active', 'upcoming']) && (!$b->end_date || \Carbon\Carbon::parse($b->end_date)->endOfDay()->gte(now()->startOfDay())))->sortBy('start_date')->take(2) : collect(); @endphp
@if($validBatches->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $validBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
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
                    <div class="flex flex-col gap-2.5 mt-auto">
                                                <button type="button" 
                                onclick="window.openSyllabusModal('{{ $program->slug }}', '{{ addslashes($program->name) }}', '{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}')" 
                                class="w-full py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-indigo-700 border border-indigo-200/80 shadow-xs flex items-center justify-center gap-2 group cursor-pointer">
                            <i class="fas fa-book-open text-indigo-600 group-hover:scale-110 transition-transform"></i>
                            <span>Materi Pembelajaran</span>
                        </button>
                        <div class="flex gap-2">
                            <button type="button" 
                                    onclick="window.openBrochureModal('{{ addslashes($program->name) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type]) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}')" 
                                    class="flex-1 py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 shadow-sm flex items-center justify-center gap-2">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                <span>Brosur PDF</span>
                            </button>
                            <a href="{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}" 
                               class="py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm flex items-center justify-center gap-1.5 shrink-0" 
                               title="Download Brosur PDF">
                                <i class="fas fa-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                            <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                        </div>
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
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: rgba(255,255,255,0.85);"></div>
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

@php $validBatches = $program ? $program->classPeriods->filter(fn($b) => in_array($b->status, ['active', 'upcoming']) && (!$b->end_date || \Carbon\Carbon::parse($b->end_date)->endOfDay()->gte(now()->startOfDay())))->sortBy('start_date')->take(2) : collect(); @endphp
@if($validBatches->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $validBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
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
                    <div class="flex flex-col gap-2.5 mt-auto">
                                                <button type="button" 
                                onclick="window.openSyllabusModal('{{ $program->slug }}', '{{ addslashes($program->name) }}', '{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}')" 
                                class="w-full py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-indigo-700 border border-indigo-200/80 shadow-xs flex items-center justify-center gap-2 group cursor-pointer">
                            <i class="fas fa-book-open text-indigo-600 group-hover:scale-110 transition-transform"></i>
                            <span>Materi Pembelajaran</span>
                        </button>
                        <div class="flex gap-2">
                            <button type="button" 
                                    onclick="window.openBrochureModal('{{ addslashes($program->name) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type]) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}')" 
                                    class="flex-1 py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 shadow-sm flex items-center justify-center gap-2">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                <span>Brosur PDF</span>
                            </button>
                            <a href="{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}" 
                               class="py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm flex items-center justify-center gap-1.5 shrink-0" 
                               title="Download Brosur PDF">
                                <i class="fas fa-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                            <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                        </div>
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
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: rgba(255,255,255,0.85);"></div>
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

@php $validBatches = $program ? $program->classPeriods->filter(fn($b) => in_array($b->status, ['active', 'upcoming']) && (!$b->end_date || \Carbon\Carbon::parse($b->end_date)->endOfDay()->gte(now()->startOfDay())))->sortBy('start_date')->take(2) : collect(); @endphp
@if($validBatches->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $validBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
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
                    <div class="flex flex-col gap-2.5 mt-auto">
                                                <button type="button" 
                                onclick="window.openSyllabusModal('{{ $program->slug }}', '{{ addslashes($program->name) }}', '{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}')" 
                                class="w-full py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-indigo-700 border border-indigo-200/80 shadow-xs flex items-center justify-center gap-2 group cursor-pointer">
                            <i class="fas fa-book-open text-indigo-600 group-hover:scale-110 transition-transform"></i>
                            <span>Materi Pembelajaran</span>
                        </button>
                        <div class="flex gap-2">
                            <button type="button" 
                                    onclick="window.openBrochureModal('{{ addslashes($program->name) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type]) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}')" 
                                    class="flex-1 py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 shadow-sm flex items-center justify-center gap-2">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                <span>Brosur PDF</span>
                            </button>
                            <a href="{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}" 
                               class="py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm flex items-center justify-center gap-1.5 shrink-0" 
                               title="Download Brosur PDF">
                                <i class="fas fa-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                            <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                        </div>
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
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: rgba(255,255,255,0.85);"></div>
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

@php $validBatches = $program ? $program->classPeriods->filter(fn($b) => in_array($b->status, ['active', 'upcoming']) && (!$b->end_date || \Carbon\Carbon::parse($b->end_date)->endOfDay()->gte(now()->startOfDay())))->sortBy('start_date')->take(2) : collect(); @endphp
@if($validBatches->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @php $__currentLoopData = $validBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
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
                    <div class="flex flex-col gap-2.5 mt-auto">
                                                <button type="button" 
                                onclick="window.openSyllabusModal('{{ $program->slug }}', '{{ addslashes($program->name) }}', '{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}')" 
                                class="w-full py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-indigo-700 border border-indigo-200/80 shadow-xs flex items-center justify-center gap-2 group cursor-pointer">
                            <i class="fas fa-book-open text-indigo-600 group-hover:scale-110 transition-transform"></i>
                            <span>Materi Pembelajaran</span>
                        </button>
                        <div class="flex gap-2">
                            <button type="button" 
                                    onclick="window.openBrochureModal('{{ addslashes($program->name) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type]) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}')" 
                                    class="flex-1 py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 shadow-sm flex items-center justify-center gap-2">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                <span>Brosur PDF</span>
                            </button>
                            <a href="{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}" 
                               class="py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm flex items-center justify-center gap-1.5 shrink-0" 
                               title="Download Brosur PDF">
                                <i class="fas fa-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center">Daftar Sekarang</a>
                            <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                        </div>
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
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: rgba(255,255,255,0.9);"></div>
                    
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
@php $validBatches = $program ? $program->classPeriods->filter(fn($b) => in_array($b->status, ['active', 'upcoming']) && (!$b->end_date || \Carbon\Carbon::parse($b->end_date)->endOfDay()->gte(now()->startOfDay())))->sortBy('start_date')->take(2) : collect(); @endphp
@if($validBatches->isNotEmpty())
                            <div class="mb-4">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                                <div class="space-y-1.5">
                                    @php $__currentLoopData = $validBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); @endphp
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

                            <div class="flex flex-col gap-2.5 mt-auto">
                                                        <button type="button" 
                                onclick="window.openSyllabusModal('{{ $program->slug }}', '{{ addslashes($program->name) }}', '{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}')" 
                                class="w-full py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-indigo-700 border border-indigo-200/80 shadow-xs flex items-center justify-center gap-2 group cursor-pointer">
                            <i class="fas fa-book-open text-indigo-600 group-hover:scale-110 transition-transform"></i>
                            <span>Materi Pembelajaran</span>
                        </button>
                        <div class="flex gap-2">
                                    <button type="button" 
                                            onclick="window.openBrochureModal('{{ addslashes($program->name) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type]) }}', '{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}')" 
                                            class="flex-1 py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 shadow-sm flex items-center justify-center gap-2">
                                        <i class="fas fa-file-pdf text-red-500"></i>
                                        <span>Brosur PDF</span>
                                    </button>
                                    <a href="{{ route('brochure.pdf', ['slug' => $program->slug, 'mode' => $type, 'download' => 1]) }}" 
                                       class="py-2.5 px-3 rounded-lg font-bold text-xs uppercase tracking-wider transition bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 shadow-sm flex items-center justify-center gap-1.5 shrink-0" 
                                       title="Download Brosur PDF">
                                        <i class="fas fa-download"></i>
                                        <span>Download</span>
                                    </a>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ url('daftar') }}?program_id={{ $program->id }}&mode={{ $type }}" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center" style="background-color: {{ $themeColor }}; color: {{ $btnTextColor }};">Daftar Sekarang</a>
                                    <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                                </div>
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


        
    <!-- Brochure PDF Modal (Vanilla JS + Alpine Compatible) -->
    <div id="tb-brochure-modal" 
         style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 999999999; background: rgba(0, 0, 0, 0.3); -webkit-backdrop-filter: blur(5px); backdrop-filter: blur(5px); align-items: center; justify-content: center; padding: 12px; box-sizing: border-box; margin: 0;">
        
        <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(0, 0, 0, 0.1); width: 96vw; max-width: 1400px; height: 94vh; max-height: 94vh; display: flex; flex-direction: column; overflow: hidden; border: 1px solid #cbd5e1; position: relative; z-index: 1000000000;">
            
            <!-- Modal Header -->
            <div style="background: linear-gradient(135deg, #0d47a1 0%, #1565c0 50%, #1976d2 100%) !important; color: #ffffff !important; padding: 16px 24px; position: relative; flex-shrink: 0; box-shadow: 0 4px 12px rgba(13, 71, 161, 0.25);">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.35); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 20px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                            <i class="fas fa-file-pdf text-red-300"></i>
                        </div>
                        <div>
                            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 2px 10px; border-radius: 9999px; background: #FFB800; color: #0f172a; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                                Brosur Resmi Program
                            </span>
                            <h3 id="tb-modal-title" style="font-size: 18px; font-weight: 900; color: #ffffff !important; margin: 0; letter-spacing: -0.3px; line-height: 1.25; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                Brosur Program
                            </h3>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <a id="tb-modal-download" href="#" class="px-4 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-900 font-extrabold text-xs flex items-center gap-1.5 shadow-md transition">
                            <i class="fas fa-download"></i>
                            <span>Download PDF</span>
                        </a>
                        <a id="tb-modal-newtab" href="#" target="_blank" class="px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs flex items-center gap-1.5 border border-white/30 transition">
                            <i class="fas fa-external-link-alt" style="pointer-events: none;"></i>
                            <span>Buka Tab Baru</span>
                        </a>
                        <button type="button" 
                                id="btn-close-brochure-x" 
                                onclick="window.closeAllModals()" 
                                style="width: 38px; height: 38px; border-radius: 50%; background: rgba(255, 255, 255, 0.25); border: 1.5px solid rgba(255, 255, 255, 0.5); color: #ffffff; display: flex; align-items: center; justify-content: center; cursor: pointer !important; transition: all 0.2s; font-size: 16px; flex-shrink: 0; z-index: 50;" 
                                onmouseover="this.style.background='rgba(255,255,255,0.4)'; this.style.transform='scale(1.08)';"
                                onmouseout="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='scale(1)';"
                                title="Tutup Modal">
                            <i class="fas fa-times" style="pointer-events: none;"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Body (PDF Viewer) -->
            <div style="flex: 1; background-color: #f1f5f9; padding: 10px; overflow: hidden; display: flex; flex-direction: column; position: relative; height: calc(94vh - 110px); box-sizing: border-box;">
                <div id="tb-modal-loader" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: #f8fafc; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; z-index: 10;">
                    <div style="width: 40px; height: 40px; border: 4px solid #0d47a1; border-top-color: transparent; border-radius: 50%; animation: tb-spin 1s linear infinite;"></div>
                    <span style="font-size: 13px; color: #334155; font-weight: 600;">Memuat Dokumen Brosur PDF...</span>
                </div>
                <iframe id="tb-modal-iframe" src="" style="width: 100%; height: 100%; min-height: 100%; border: 1px solid #cbd5e1; border-radius: 10px; background: #ffffff; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);" frameborder="0" onload="document.getElementById('tb-modal-loader').style.display='none';"></iframe>
            </div>

            <!-- Modal Footer -->
            <div style="background-color: #ffffff; padding: 10px 20px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; font-size: 12px; color: #64748b;">
                <span style="font-weight: 500;">Target Bahasa &bull; English Skills. Global Success.</span>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span>Tekan <strong style="color: #0f172a;">ESC</strong> untuk keluar</span>
                    <button type="button" 
                            id="btn-close-brochure-footer" 
                            onclick="window.closeAllModals()" 
                            style="padding: 6px 16px; font-weight: 600; color: #334155; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; cursor: pointer !important;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes tb-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>

    <script>
        window.closeAllModals = function() {
            var bModal = document.getElementById('tb-brochure-modal');
            var sModal = document.getElementById('tb-syllabus-modal');
            var iframeEl = document.getElementById('tb-modal-iframe');
            if (iframeEl) iframeEl.src = '';
            if (bModal) bModal.style.display = 'none';
            if (sModal) sModal.style.display = 'none';
            document.body.style.overflow = '';
        };

        window.closeBrochureModal = window.closeAllModals;
        window.closeSyllabusModal = window.closeAllModals;

        window.openBrochureModal = function(title, pdfUrl, downloadUrl) {
            window.closeAllModals();
            var modal = document.getElementById('tb-brochure-modal');
            var titleEl = document.getElementById('tb-modal-title');
            var downloadEl = document.getElementById('tb-modal-download');
            var newtabEl = document.getElementById('tb-modal-newtab');
            var iframeEl = document.getElementById('tb-modal-iframe');
            var loaderEl = document.getElementById('tb-modal-loader');
            
            if (titleEl) titleEl.innerText = title;
            if (downloadEl) downloadEl.href = downloadUrl;
            if (newtabEl) newtabEl.href = pdfUrl;
            if (loaderEl) loaderEl.style.display = 'flex';
            if (iframeEl) iframeEl.src = pdfUrl;
            
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        };

        // Global ESC handler
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                window.closeAllModals();
            }
        });

        // Close on backdrop click
        document.addEventListener('DOMContentLoaded', function() {
            var bModal = document.getElementById('tb-brochure-modal');
            var sModal = document.getElementById('tb-syllabus-modal');
            if (bModal) {
                bModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        window.closeAllModals();
                    }
                });
            }
            if (sModal) {
                sModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        window.closeAllModals();
                    }
                });
            }
        });
    </script>


    <!-- ========================================== -->
    <!-- SYLLABUS / MATERI PEMBELAJARAN POPUP MODAL -->
    <!-- ========================================== -->
    <div id="tb-syllabus-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 2147483647; background: rgba(15, 23, 42, 0.75); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 16px; box-sizing: border-box; margin: 0;">
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col border border-gray-100 overflow-hidden animate-in fade-in zoom-in-95">
            <!-- Modal Header -->
            <div style="background: linear-gradient(135deg, #0d47a1 0%, #1565c0 50%, #1976d2 100%) !important; color: #ffffff !important; padding: 20px 24px; position: relative; flex-shrink: 0; box-shadow: 0 4px 12px rgba(13, 71, 161, 0.25);">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 46px; height: 46px; border-radius: 14px; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.35); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 20px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; border-radius: 9999px; background: #FFB800; color: #0f172a; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                <i class="fas fa-book-open" style="font-size: 10px;"></i> Silabus & Rencana Belajar
                            </span>
                            <h3 id="tb-syllabus-title" style="font-size: 21px; font-weight: 900; color: #ffffff !important; margin: 0; letter-spacing: -0.3px; line-height: 1.25; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                Materi Pembelajaran
                            </h3>
                            <p id="tb-syllabus-badge" style="font-size: 12px; color: #e2e8f0 !important; font-weight: 600; margin: 4px 0 0 0;">
                                Daftar materi & topik per pertemuan
                            </p>
                        </div>
                    </div>
                    <button type="button" 
                            id="btn-close-syllabus-x" 
                            onclick="window.closeAllModals()" 
                            style="width: 38px; height: 38px; border-radius: 50%; background: rgba(255, 255, 255, 0.25); border: 1.5px solid rgba(255, 255, 255, 0.5); color: #ffffff; display: flex; align-items: center; justify-content: center; cursor: pointer !important; transition: all 0.2s; font-size: 16px; flex-shrink: 0; z-index: 50;" 
                            onmouseover="this.style.background='rgba(255,255,255,0.4)'; this.style.transform='scale(1.08)';"
                            onmouseout="this.style.background='rgba(255,255,255,0.25)'; this.style.transform='scale(1)';"
                            title="Tutup Modal">
                        <i class="fas fa-times" style="pointer-events: none;"></i>
                    </button>
                </div>

                <!-- Search / Filter input -->
                <div style="margin-top: 16px; position: relative;">
                    <span style="position: absolute; top: 0; bottom: 0; left: 14px; display: flex; align-items: center; color: #0d47a1; pointer-events: none;">
                        <i class="fas fa-search" style="font-size: 13px;"></i>
                    </span>
                    <input type="text" 
                           id="tb-syllabus-search" 
                           oninput="filterSyllabusMeetings(this.value)" 
                           placeholder="Cari materi, topik, atau nomor pertemuan..." 
                           style="width: 100%; padding: 10px 16px 10px 38px; background: #ffffff !important; color: #0f172a !important; font-size: 13px; font-weight: 600; border-radius: 12px; border: 2px solid #93c5fd; outline: none; box-shadow: 0 2px 6px rgba(0,0,0,0.08); box-sizing: border-box;">
                </div>
            </div>

            <!-- Modal Body (Scrollable List of Meetings) -->
            <div id="tb-syllabus-body" class="p-4 sm:p-6 overflow-y-auto space-y-3 sm:space-y-3.5 bg-slate-50 flex-grow">
                <!-- Dynamically Rendered by JS -->
            </div>

            <!-- Modal Footer -->
            <div class="p-4 sm:p-5 bg-white border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 shrink-0">
                <div class="text-xs text-gray-500 text-center sm:text-left">
                    <span class="font-bold text-gray-700" id="tb-syllabus-total-count">Total Pertemuan</span>
                    <span class="block text-[11px] text-gray-400">Kurikulum terstruktur berbasis target skor & sertifikat</span>
                </div>
                <div class="flex items-center gap-2.5 w-full sm:w-auto">
                    <button type="button" 
                            id="btn-close-syllabus-footer" 
                            onclick="window.closeAllModals()" 
                            class="flex-1 sm:flex-initial px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                        Tutup
                    </button>
                    <a id="tb-syllabus-register-btn" href="{{ url('daftar') }}" class="flex-1 sm:flex-initial px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center justify-center gap-2">
                        <span>Daftar Kelas</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Syllabus Catalog & Modal Script -->
    <script>
                const PROGRAM_SYLLABUSES = {
            'fast-track-grammar-for-writing': {
                title: 'Fast Track Grammar for Writing',
                badge: '10 Pertemuan • Program Intensif Grammar',
                color: '#d97706',
                meetings: [
                    { num: 1, title: 'Meeting 1: Silang - silang tenses', desc: 'Latihan terarah untuk topik silang - silang tenses & pola dasar.', tag: 'Grammar' },
                    { num: 2, title: 'Meeting 2: Latihan penerapan tenses', desc: 'Latihan terarah untuk topik penerapan tenses dalam kalimat terjemahan.', tag: 'Grammar' },
                    { num: 3, title: 'Meeting 3: Modal', desc: 'Latihan terarah untuk topik modal auxiliaries & degrees of certainty.', tag: 'Grammar' },
                    { num: 4, title: 'Meeting 4: Negative sentence', desc: 'Latihan terarah untuk topik negative sentence & matriks 16 tenses.', tag: 'Grammar' },
                    { num: 5, title: 'Meeting 5: To Infinitive & Gerund', desc: 'Latihan terarah untuk topik penggunaan to infinitive & gerund.', tag: 'Grammar' },
                    { num: 6, title: 'Meeting 6: Noun Phrase, Comparative, Superlative, & Positive Degree', desc: 'Latihan terarah untuk topik frasa kata benda dan perbandingan derajat.', tag: 'Grammar' },
                    { num: 7, title: 'Meeting 7: FANBOYS & Adverbial Clause', desc: 'Latihan terarah untuk topik kata hubung FANBOYS (compound) dan Adverbial Clause (complex).', tag: 'Grammar' },
                    { num: 8, title: 'Meeting 8: Adjective Clause - RPS / RPO', desc: 'Latihan terarah untuk klausa kata sifat (Relative Pronoun as Subject / Object).', tag: 'Grammar' },
                    { num: 9, title: 'Meeting 9: Adjective Clause RPP, RA', desc: 'Latihan terarah untuk klausa kata sifat kepemilikan (RPP) & Relative Adverb.', tag: 'Grammar' },
                    { num: 10, title: 'Meeting 10: Noun Clause & Prepositional Phrase', desc: 'Latihan terarah untuk klausa kata benda dan frasa preposisi (Prepositional Phrase).', tag: 'Grammar' }
                ]
            },
            'introductory-grammar-for-writing': {
                title: 'Introductory Grammar for Writing',
                badge: '19 Pertemuan • Fondasi Tata Bahasa Terstruktur',
                color: '#0284c7',
                meetings: [
                    { num: 1, title: 'Meeting 1a: Simple Present Verbal', desc: 'Membentuk kalimat kebiasaan & fakta dengan kata kerja Verb 1.', tag: 'Grammar' },
                    { num: 2, title: 'Meeting 1b: Simple Present Pasif', desc: 'Membentuk kalimat pasif Simple Present (Is/Am/Are + V3).', tag: 'Grammar' },
                    { num: 3, title: 'Meeting 2a: Simple Present Nominal', desc: 'Penggunaan to be (Am, Is, Are) untuk sifat, profesi, & lokasi.', tag: 'Grammar' },
                    { num: 4, title: 'Meeting 2b: Simple Present Campuran', desc: 'Latihan terintegrasi pola verbal dan nominal Simple Present.', tag: 'Grammar' },
                    { num: 5, title: 'Meeting 3a: To Infinitive', desc: 'Pola kata kerja bantu dan penggunaan To + Verb 1.', tag: 'Grammar' },
                    { num: 6, title: 'Meeting 3b: Simple Past Verbal', desc: 'Menceritakan kejadian masa lalu menggunakan Verb 2 & irregular verbs.', tag: 'Grammar' },
                    { num: 7, title: 'Meeting 4a: Simple Past Passive + Nominal', desc: 'Kalimat pasif dan nominal masa lalu menggunakan Was/Were.', tag: 'Grammar' },
                    { num: 8, title: 'Meeting 4b: Negative Simple Present Verbal & Simple Past Verbal', desc: 'Pola kalimat negatif menggunakan Do/Does not dan Did not.', tag: 'Grammar' },
                    { num: 9, title: 'Meeting 5a: Simple Present & Simple Past Campuran', desc: 'Latihan variasi tenses present dan past secara simultan.', tag: 'Grammar' },
                    { num: 10, title: 'Meeting 5b: Pronoun', desc: 'Penguasaan Subject, Object, Possessive, & Reflexive Pronoun.', tag: 'Grammar' },
                    { num: 11, title: 'Meeting 6a: Irregular Verb', desc: 'Penguasaan bentuk kata kerja tidak beraturan (V1, V2, V3).', tag: 'Grammar' },
                    { num: 12, title: 'Meeting 6b: Present Continuous Verbal, Nominal, Passive', desc: 'Kalimat sedang berlangsung bentuk aktif, nominal, dan pasif.', tag: 'Grammar' },
                    { num: 13, title: 'Meeting 7a: Present Perfect & Present Perfect Continuous', desc: 'Mengekspresikan aksi yang telah selesai atau masih berlangsung hingga kini.', tag: 'Grammar' },
                    { num: 14, title: 'Meeting 7b: Review Simple Present - Present Perfect', desc: 'Review terpadu dan perbandingan seluruh tenses present.', tag: 'Review' },
                    { num: 15, title: 'Meeting 8a: Modal', desc: 'Penggunaan can, could, will, would, shall, should, must, may, might.', tag: 'Modals' },
                    { num: 16, title: 'Meeting 8b: Gerund', desc: 'Kata kerja yang berfungsi sebagai kata benda (V-ing as Subject/Object).', tag: 'Grammar' },
                    { num: 17, title: 'Meeting 9a: Complex Ditransitive', desc: 'Struktur kalimat dengan dua objek (Direct Object & Indirect Object).', tag: 'Grammar' },
                    { num: 18, title: 'Meeting 9b: Noun Phrase', desc: 'Menyusun frasa kata benda dengan modifiers dan determiners.', tag: 'Grammar' },
                    { num: 19, title: 'Meeting 10a: Examination', desc: 'Ujian komprehensif evaluasi pemahaman seluruh materi introductory.', tag: 'Exam' }
                ]
            },
            'complexity-grammar-for-writing': {
                title: 'Complexity Grammar for Writing',
                badge: '10 Pertemuan • Penguasaan Struktur Kalimat Kompleks',
                color: '#7c3aed',
                meetings: [
                    { num: 1, title: 'Meeting 1: Silang - silang tenses', desc: 'Latihan terarah untuk topik silang - silang tenses.', tag: 'Complexity' },
                    { num: 2, title: 'Meeting 2: Latihan penerapan tenses', desc: 'Latihan terarah untuk topik penerapan tenses dalam kalimat kompleks.', tag: 'Complexity' },
                    { num: 3, title: 'Meeting 3: To Infinitive & Gerund', desc: 'Pendalaman struktur To Infinitive dan Gerund pada tulisan akademis.', tag: 'Complexity' },
                    { num: 4, title: 'Meeting 4: Comparative, superlative, positive degree', desc: 'Tingkat perbandingan kompleks dan ekspresi derajat.', tag: 'Complexity' },
                    { num: 5, title: 'Meeting 5: Parallel Structures', desc: 'Menjaga kesejajaran elemen tata bahasa dalam kalimat majemuk.', tag: 'Complexity' },
                    { num: 6, title: 'Meeting 6: Adverbial Clause', desc: 'Klausa keterangan komplek (Time, Cause, Condition, Concession, Purpose).', tag: 'Complexity' },
                    { num: 7, title: 'Meeting 7: Adjective Clause - RPS / RPO', desc: 'Klausa penjelas subjek dan objek dengan pronoun penghubung.', tag: 'Complexity' },
                    { num: 8, title: 'Meeting 8: Adjective Clause RPP, RA', desc: 'Klausa penjelas kepemilikan (whose) dan keterangan tempat/waktu.', tag: 'Complexity' },
                    { num: 9, title: 'Meeting 9: Noun Clause', desc: 'Klausa nomina sebagai subjek, objek, dan pelengkap dalam esai.', tag: 'Complexity' },
                    { num: 10, title: 'Meeting 10: Exam', desc: 'Ujian evaluasi akhir kemampuan menulis struktur kalimat kompleks.', tag: 'Exam' }
                ]
            },
            'proficiency-grammar-for-writing': {
                title: 'Proficiency Grammar for Writing',
                badge: '10 Pertemuan • Advanced & Professional Writing Structure',
                color: '#4f46e5',
                meetings: [
                    { num: 1, title: 'Meeting 1: Suffixes', desc: 'Memahami penggunaan akhiran kata & mengidentifikasi jenis kata (Word Formation).', tag: 'Proficiency' },
                    { num: 2, title: 'Meeting 2: Reducing', desc: 'Meringkas klausa menggunakan participle untuk gaya penulisan ringkas.', tag: 'Proficiency' },
                    { num: 3, title: 'Meeting 3: Abridgement and omitting', desc: 'Penyederhanaan kalimat kompleks dan mencegah pemborosan kata.', tag: 'Proficiency' },
                    { num: 4, title: 'Meeting 4: Negative Inversion', desc: 'Menyusun kalimat pembalikan subjek-predikat dengan ungkapan negatif untuk penekanan.', tag: 'Proficiency' },
                    { num: 5, title: 'Meeting 5: Fronting', desc: 'Menempatkan elemen di awal kalimat untuk variasi struktur dan fokus informasi.', tag: 'Proficiency' },
                    { num: 6, title: 'Meeting 6: Cleft sentences', desc: 'Penggunaan kalimat terbelah (It is... that, What...) untuk menonjolkan poin kunci.', tag: 'Proficiency' },
                    { num: 7, title: 'Meeting 7: Emphatic structures', desc: 'Struktur penekanan dalam penulisan esai argumen akademis formal.', tag: 'Proficiency' },
                    { num: 8, title: 'Meeting 8: Nominalization', desc: 'Mengubah kata kerja/sifat menjadi kata benda untuk nada penulisan yang lebih ilmiah.', tag: 'Proficiency' },
                    { num: 9, title: 'Meeting 9: Conditional sentences', desc: 'Penguasaan mixed conditionals, inversion in conditionals, & formal hypothesis.', tag: 'Proficiency' },
                    { num: 10, title: 'Meeting 10: Exam', desc: 'Ujian komprehensif tingkat mahir tata bahasa dan penulisan formal.', tag: 'Exam' }
                ]
            },
            'introductory-speaking': {
                title: 'Introductory Speaking',
                badge: '15 Pertemuan • Percakapan Sehari-hari Pemula',
                color: '#10b981',
                meetings: [
                    { num: 1, title: 'Meeting 1: Introduction and Greetings', desc: 'Latihan pengenalan diri, salam formal/informal, dan ekspresi sapaan.', tag: 'Speaking' },
                    { num: 2, title: 'Meeting 2: Daily Routines and Time', desc: 'Menceritakan jadwal rutinitas harian dan membaca waktu secara natural.', tag: 'Speaking' },
                    { num: 3, title: 'Meeting 3: Family and Relationships', desc: 'Mendeskripsikan silsilah keluarga dan hubungan sosial pertemanan.', tag: 'Speaking' },
                    { num: 4, title: 'Meeting 4: Describing People and Places', desc: 'Kosakata deskripsi ciri fisik seseorang dan tempat umum.', tag: 'Speaking' },
                    { num: 5, title: 'Meeting 5: Food and Dining', desc: 'Percakapan saat makan di restoran, memesan menu, & menanyakan rasa makanan.', tag: 'Speaking' },
                    { num: 6, title: 'Meeting 6: Shopping and Prices', desc: 'Percakapan tawar-menawar, menanyakan ukuran, warna, & harga.', tag: 'Speaking' },
                    { num: 7, title: 'Meeting 7: Hobbies and Leisure', desc: 'Membicarakan hobi, musik favorit, olahraga, & waktu luang.', tag: 'Speaking' },
                    { num: 8, title: 'Meeting 8: Directions and Locations', desc: 'Menanyakan dan memberikan petunjuk arah di ruang publik.', tag: 'Speaking' },
                    { num: 9, title: 'Meeting 9: Weather and Seasons', desc: 'Membicarakan kondisi cuaca, iklim, dan rencana liburan.', tag: 'Speaking' },
                    { num: 10, title: 'Meeting 10: Health and Feelings', desc: 'Mengekspresikan kondisi fisik, keluhan penyakit ringan, dan emosi.', tag: 'Speaking' },
                    { num: 11, title: 'Meeting 11: Past Experiences', desc: 'Menceritakan peristiwa masa lalu dan pengalaman liburan berkesan.', tag: 'Speaking' },
                    { num: 12, title: 'Meeting 12: Future Plans', desc: 'Mendiskusikan impian, rencana karier, dan agenda masa depan.', tag: 'Speaking' },
                    { num: 13, title: 'Meeting 13: Making Appointments', desc: 'Etika menelepon dan membuat janji temu secara profesional.', tag: 'Speaking' },
                    { num: 14, title: 'Meeting 14: Opinions and Preferences', desc: 'Menyatakan opini, kesukaan, dan ketidaksukaan beserta alasan.', tag: 'Speaking' },
                    { num: 15, title: 'Meeting 15: Review and Speaking Assessment', desc: 'Simulasi percakapan peran multi-situasi dan feedback kelancaran bicara.', tag: 'Assessment' }
                ]
            },
            'intermediate-speaking': {
                title: 'Intermediate Speaking',
                badge: '10 Pertemuan • Percakapan Interaktif & Diskusi',
                color: '#06b6d4',
                meetings: [
                    { num: 1, title: 'Meeting 1: Introducing others', desc: 'Memperkenalkan rekan kerja/teman dalam konteks formal dan sosial.', tag: 'Speaking' },
                    { num: 2, title: 'Meeting 2: Polite request & Making suggestion', desc: 'Ungkapan permintaan sopan dan memberikan saran kepada orang lain.', tag: 'Speaking' },
                    { num: 3, title: 'Meeting 3: Expressing necessity, prohibition, & ability', desc: 'Menyatakan keharusan, larangan, dan kemampuan berbicara secara spontan.', tag: 'Speaking' },
                    { num: 4, title: 'Meeting 4: Making suggestion, Expectation, Advisability, & Expressing preference', desc: 'Kombinasi saran, ekspektasi, nasihat, dan menyatakan preferensi.', tag: 'Speaking' },
                    { num: 5, title: 'Meeting 5: Simple Future, be going to, & Semi Modal', desc: 'Menjelaskan rencana masa depan dan penggunaan semi-modals.', tag: 'Speaking' },
                    { num: 6, title: 'Meeting 6: Conditional Sentence Type 1 & 2', desc: 'Mendiskusikan kemungkinan nyata dan pengandaian situasi imajiner.', tag: 'Speaking' },
                    { num: 7, title: 'Meeting 7: Expressing certainty & uncertainty', desc: 'Menyatakan tingkat keyakinan terhadap suatu informasi atau peristiwa.', tag: 'Speaking' },
                    { num: 8, title: 'Meeting 8: Asking for and giving advice', desc: 'Meminta masukan dan memberikan solusi pada situasi pemecahan masalah.', tag: 'Speaking' },
                    { num: 9, title: 'Meeting 9: Discussion & debate techniques', desc: 'Teknik mempertahankan argumen dan merespon sudut pandang lawan bicara.', tag: 'Speaking' },
                    { num: 10, title: 'Meeting 10: Speaking Evaluation', desc: 'Evaluasi percakapan komprehensif dan umpan balik personal dari tutor.', tag: 'Evaluation' }
                ]
            },
            'advanced-speaking': {
                title: 'Advanced Speaking',
                badge: '10 Pertemuan • Fluency, Nuance & Presentation',
                color: '#f59e0b',
                meetings: [
                    { num: 1, title: 'Meeting 1: Introduction B1, too / enough, & Used to', desc: 'Pemetaan level B1, ekspresi intensifier, dan kebiasaan masa lalu.', tag: 'Speaking' },
                    { num: 2, title: 'Meeting 2: Simple Past Nominal', desc: 'Pola kelancaran berbicara menceritakan profil dan peristiwa masa lalu.', tag: 'Speaking' },
                    { num: 3, title: 'Meeting 3: Simple Past Verbal & irregular verbs', desc: 'Penceritaan kronologis (Storytelling) dengan pelafalan kata kerja lampau yang tepat.', tag: 'Speaking' },
                    { num: 4, title: 'Meeting 4: Simple past & Past Continuous', desc: 'Mendeskripsikan dua kejadian bersamaan di masa lampau secara fasih.', tag: 'Speaking' },
                    { num: 5, title: 'Meeting 5: Modals & Degrees certainty (Past time)', desc: 'Spekulasi dan deduksi logis tentang kejadian masa lalu (must have been, could have).', tag: 'Speaking' },
                    { num: 6, title: 'Meeting 6: Passive Voice in Speech', desc: 'Penggunaan kalimat pasif dalam laporan lisan dan konteks formal.', tag: 'Speaking' },
                    { num: 7, title: 'Meeting 7: Complex Discussion & Presentation Skills', desc: 'Teknik presentasi lisan, struktur pembukaan, inti, dan kesimpulan meyakinkan.', tag: 'Speaking' },
                    { num: 8, title: 'Meeting 8: Business English & Negotiation', desc: 'Keterampilan negosiasi bisnis, tawar-menawar profesional, dan diplomasi.', tag: 'Speaking' },
                    { num: 9, title: 'Meeting 9: Expressing Nuance & Tone', desc: 'Mengatur intonasi, nada bicara, dan pilihan kosakata sesuai audiens.', tag: 'Speaking' },
                    { num: 10, title: 'Meeting 10: Final Advanced Presentation', desc: 'Ujian presentasi formal individu dengan rubrik penilaian komprehensif.', tag: 'Final' }
                ]
            },
            'toefl-itp': {
                title: 'TOEFL ITP Preparation',
                badge: '16 - 24 Pertemuan • Target Skor 450 - 600+',
                color: '#2563eb',
                meetings: [
                    { num: 1, title: 'Listening Comprehension: Short Dialogues & Restatement Strategy', desc: 'Strategi menjawab Part A dengan mencari sinonim/restatement dari pembicara kedua tanpa terjebak kata yang terdengar mirip.', tag: 'Listening' },
                    { num: 2, title: 'Listening Comprehension: Negative Expressions & Agreement Idioms', desc: 'Memahami makna pernyataan negatif, double negatives, "almost negative", serta ekspresi persetujuan (So do I, You can say that again).', tag: 'Listening' },
                    { num: 3, title: 'Listening Comprehension: Long Conversations & Academic Lectures', desc: 'Teknik note-taking dan memprediksi topik pertanyaan pada Part B (Conversations) dan Part C (Academic Talks).', tag: 'Listening' },
                    { num: 4, title: 'Structure: Subject-Verb Identification & Prepositional Objects', desc: 'Menganalisis kalimat tunggal, mengidentifikasi subjek & kata kerja utama, dan membedakan Object of Preposition.', tag: 'Structure' },
                    { num: 5, title: 'Structure: Appositives, Present & Past Participles', desc: 'Menguasai pola penjelas subjek (Appositive) dan membedakan Participle aktif (-ing) vs pasif (-ed/V3).', tag: 'Structure' },
                    { num: 6, title: 'Structure: Coordinate Connectors & Adverb Clauses', desc: 'Pola penggabungan 2 klausa menggunakan FANBOYS dan Adverb Clause Connectors (Time, Cause, Condition, Contrast).', tag: 'Structure' },
                    { num: 7, title: 'Structure: Noun Clauses & Adjective Clause Connectors', desc: 'Menguasai klausa kata benda sebagai subjek/objek dan klausa kata sifat (Who, Whom, Which, That, Whose).', tag: 'Structure' },
                    { num: 8, title: 'Written Expression: Subject-Verb Agreement & Parallelism', desc: 'Mendeteksi kesalahan kesesuaian subjek tunggal/jamak, ungkapan kuantitas, dan kesejajaran kata dalam kalimat.', tag: 'Written Exp' },
                    { num: 9, title: 'Written Expression: Comparatives & Superlatives', desc: 'Pola perbandingan derajat (more/-er, most/-est) dan penggunaan as...as, the more... the more.', tag: 'Written Exp' },
                    { num: 10, title: 'Written Expression: Verb Forms & Active vs Passive Voice', desc: 'Mengidentifikasi kesalahan bentuk kata kerja (Base, V2, V3, V-ing) dan penggunaan kalimat pasif.', tag: 'Written Exp' },
                    { num: 11, title: 'Written Expression: Pronouns, Word Formations & Word Choice', desc: 'Mendeteksi kesalahan jenis pronoun, pemakaian Adjective vs Adverb, dan pasangan kata (Make vs Do, Like vs Alike).', tag: 'Written Exp' },
                    { num: 12, title: 'Reading Comprehension: Main Idea & Organization of Ideas', desc: 'Menemukan ide pokok paragraf dengan cepat (Skimming) dan mengenali bagaimana ide dalam teks diorganisir.', tag: 'Reading' },
                    { num: 13, title: 'Reading Comprehension: Stated & Unstated Detail Questions', desc: 'Teknik Scanning untuk menemukan informasi spesifik dan menjawab pertanyaan "NOT mentioned / EXCEPT".', tag: 'Reading' },
                    { num: 14, title: 'Reading Comprehension: Vocabulary in Context & Pronoun Referents', desc: 'Menebak arti kata sulit menggunakan petunjuk konteks kalimat dan mencari rujukan kata ganti.', tag: 'Reading' },
                    { num: 15, title: 'Reading Comprehension: Inference Questions & Tone/Purpose', desc: 'Menarik kesimpulan logis yang tersirat dan menganalisis nada atau tujuan penulisan artikel ilmiah.', tag: 'Reading' },
                    { num: 16, title: 'Full TOEFL ITP Complete Simulation & Diagnostic Review', desc: 'Simulasi ujian lengkap 140 soal (Listening, Structure, Reading) dengan scoring report dan bedah pembahasan.', tag: 'Mock Test' }
                ]
            },
            'ielts-academic-full-package': {
                title: 'IELTS Academic Full Package',
                badge: '16 - 24 Pertemuan • Target Band 6.5 - 7.5+',
                color: '#dc2626',
                meetings: [
                    { num: 1, title: 'IELTS Academic Overview & Diagnostic Assessment', desc: 'Pengenalan format 4 modul, sistem penilaian Band Score (0-9), dan pemetaan target skor.', tag: 'Overview' },
                    { num: 2, title: 'Listening Section 1: Social Contexts & Form Completion', desc: 'Teknik menjawab percakapan sehari-hari, spelling nama, angka, tanggal, dan instruksi batas kata.', tag: 'Listening' },
                    { num: 3, title: 'Listening Section 2: Maps, Plans, & Multiple Choice', desc: 'Strategi navigasi arah pada peta denah dan eliminasi jebakan pada soal pilihan ganda.', tag: 'Listening' },
                    { num: 4, title: 'Listening Section 3 & 4: Academic Discussions & Monologues', desc: 'Teknik note-taking pada diskusi studi kelompok dan kuliah ilmiah dengan pembicara cepat.', tag: 'Listening' },
                    { num: 5, title: 'Reading Passage 1: True / False / Not Given & Matching', desc: 'Memahami perbedaan mendasar antara False vs Not Given dan strategi scanning teks deskriptif.', tag: 'Reading' },
                    { num: 6, title: 'Reading Passage 2: Matching Headings & Summary Completion', desc: 'Menganalisis ide utama tiap paragraf dan teknik parafrase pada ringkasan teks.', tag: 'Reading' },
                    { num: 7, title: 'Reading Passage 3: Yes / No / Not Given & Complex Academic Texts', desc: 'Menganalisis opini penulis pada teks argumen kompleks dan manajemen waktu pengerjaan 20 menit.', tag: 'Reading' },
                    { num: 8, title: 'Writing Task 1: Line Graphs, Bar Charts, & Pie Charts', desc: 'Menulis Overview yang kuat, mengelompokkan data tren, dan variasi kosakata kenaikan/penurunan.', tag: 'Writing' },
                    { num: 9, title: 'Writing Task 1: Tables & Multiple/Mixed Charts', desc: 'Strategi membandingkan dua grafik berbeda secara runtut dan akurat tanpa melebihi batas waktu 20 menit.', tag: 'Writing' },
                    { num: 10, title: 'Writing Task 1: Process Diagrams & Map Evolutions', desc: 'Menulis tahapan proses alami/manufaktur dengan passive voice dan mendeskripsikan perubahan tata ruang.', tag: 'Writing' },
                    { num: 11, title: 'Writing Task 2: Opinion Essays (Agree / Disagree)', desc: 'Struktur esai 4-paragraf, perumusan thesis statement yang jelas, dan pengembangan ide argumen yang solid.', tag: 'Writing' },
                    { num: 12, title: 'Writing Task 2: Discussion Essays (Discuss Both Views)', desc: 'Menyajikan dua sudut pandang secara berimbang dan memberikan opini pribadi yang terargumentasi baik.', tag: 'Writing' },
                    { num: 13, title: 'Writing Task 2: Problem & Solution / Two-Part Questions', desc: 'Menganalisis akar penyebab masalah, mengajukan solusi konkret, dan menyusun esai terstruktur.', tag: 'Writing' },
                    { num: 14, title: 'Writing Task 2: Coherence, Lexical Resource & Grammar Accuracy', desc: 'Penggunaan discourse markers, transisi logis, collocations akademis, dan variasi kalimat kompleks.', tag: 'Writing' },
                    { num: 15, title: 'Speaking Part 1: Fluency & Everyday Topics Expansion', desc: 'Strategi menjawab pertanyaan personal (Home, Work, Hobbies) secara natural dengan teknik perluasan kalimat (AREA).', tag: 'Speaking' },
                    { num: 16, title: 'Speaking Part 2: Long Turn Cue Card (2 Minutes Mastery)', desc: 'Teknik memanfaatkan 1 menit persiapan catatan dan berbicara lancar 2 menit tanpa jeda atau filler.', tag: 'Speaking' },
                    { num: 17, title: 'Speaking Part 3: Two-Way Abstract Discussion & Critical Thinking', desc: 'Mengembangkan opini abstrak, memberikan contoh spesifik, spekulasi masa depan, dan perbandingan sosial.', tag: 'Speaking' },
                    { num: 18, title: 'Full Cambridge Simulation: Listening & Reading', desc: 'Simulasi ujian Cambridge otentik dengan kondisi waktu ketat dan pembahasan kunci jawaban.', tag: 'Mock Test' },
                    { num: 19, title: 'Full Timed Writing Simulation: Task 1 & Task 2', desc: 'Simulasi menulis 60 menit dengan koreksi detail berdasarkan 4 kriteria penilaian resmi IELTS.', tag: 'Mock Test' },
                    { num: 20, title: '1-on-1 Mock Speaking Interview with Examiner Feedback', desc: 'Simulasi wawancara speaking 1-on-1 lengkap (Part 1-3) dengan scoring band breakdown dan rekomendasi perbaikan.', tag: 'Mock Test' }
                ]
            },
            'ielts-academic-reading': {
                title: 'IELTS Academic Reading Specialist',
                badge: '20 Pertemuan • Latihan Modul Cambridge Lengkap',
                color: '#dc2626',
                meetings: [
                    { num: 1, title: 'Meeting 1: IELTS Reading Practice 1 (Cambridge 16 Test 1)', desc: 'Passage 1-3: True/False/Not Given, Matching Headings, & Summary Completion.', tag: 'Reading' },
                    { num: 2, title: 'Meeting 2: IELTS Reading Practice 2 (Cambridge 16 Test 2)', desc: 'Passage 1-3: Multiple Choice, Diagram Labelling, & Sentence Completion.', tag: 'Reading' },
                    { num: 3, title: 'Meeting 3: IELTS Reading Practice 3 (Cambridge 16 Test 3)', desc: 'Passage 1-3: Yes/No/Not Given, Matching Features, & Table Completion.', tag: 'Reading' },
                    { num: 4, title: 'Meeting 4: IELTS Reading Practice 4 (Cambridge 16 Test 4)', desc: 'Passage 1-3: Flow-chart Completion, Short-answer questions, & Skimming.', tag: 'Reading' },
                    { num: 5, title: 'Meeting 5: IELTS Reading Practice 5 (Cambridge 17 Test 1)', desc: 'Passage 1-3: Advanced matching information & Academic passages analysis.', tag: 'Reading' },
                    { num: 6, title: 'Meeting 6: IELTS Reading Practice 6 (Cambridge 17 Test 2)', desc: 'Passage 1-3: Complex scientific texts & scanning strategy under time limit.', tag: 'Reading' },
                    { num: 7, title: 'Meeting 7: IELTS Reading Practice 7 (Cambridge 17 Test 3)', desc: 'Passage 1-3: Historical texts, author opinion analysis & vocabulary clues.', tag: 'Reading' },
                    { num: 8, title: 'Meeting 8: IELTS Reading Practice 8 (Cambridge 17 Test 4)', desc: 'Passage 1-3: Sociological essays, matching sentence endings & elimination.', tag: 'Reading' },
                    { num: 9, title: 'Meeting 9: IELTS Reading Practice 9 (Cambridge 18 Test 1)', desc: 'Passage 1-3: Cambridge 18 authentic exam patterns & speed reading drills.', tag: 'Reading' },
                    { num: 10, title: 'Meeting 10: IELTS Reading Practice 10 (Cambridge 18 Test 2)', desc: 'Passage 1-3: Technical innovation texts & full reading simulation.', tag: 'Reading' }
                ]
            }
        };

        // Current active syllabus list for search filtering
        let currentSyllabusList = [];

        window.openSyllabusModal = function(programSlug, programName, registerUrl) {
            window.closeAllModals();
            const modal = document.getElementById('tb-syllabus-modal');
            if (modal && modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
            const titleEl = document.getElementById('tb-syllabus-title');
            const badgeEl = document.getElementById('tb-syllabus-badge');
            const countEl = document.getElementById('tb-syllabus-total-count');
            const bodyEl = document.getElementById('tb-syllabus-body');
            const regBtn = document.getElementById('tb-syllabus-register-btn');
            const searchInput = document.getElementById('tb-syllabus-search');

            if (searchInput) searchInput.value = '';
            if (regBtn && registerUrl) regBtn.href = registerUrl;

            // Find syllabus data or generate fallback
            let data = PROGRAM_SYLLABUSES[programSlug];
            if (!data) {
                // Check partial key matches
                for (const key in PROGRAM_SYLLABUSES) {
                    if (programSlug.includes(key) || key.includes(programSlug)) {
                        data = PROGRAM_SYLLABUSES[key];
                        break;
                    }
                }
            }

            if (!data) {
                // Clean Fallback for other programs
                data = {
                    title: programName,
                    badge: 'Kurikulum Terstruktur • 10 - 20 Pertemuan',
                    color: '#4f46e5',
                    meetings: [
                        { num: 1, title: 'Meeting 1: Pengenalan & Fondasi Utama', desc: 'Pemetaan kemampuan awal, pengenalan modul, dan strategi belajar efektif.', tag: 'Fondasi' },
                        { num: 2, title: 'Meeting 2: Konsep Inti & Pembahasan Teori 1', desc: 'Pendalaman materi pokok dengan studi kasus dan contoh aplikatif.', tag: 'Teori' },
                        { num: 3, title: 'Meeting 3: Latihan Terbimbing & Bedah Pola Soal', desc: 'Latihan soal terstruktur dengan feedback langsung dari pengajar.', tag: 'Latihan' },
                        { num: 4, title: 'Meeting 4: Pendalaman Materi Lanjutan', desc: 'Membahas topik kompleks dan perluasan kosakata serta strategi praktis.', tag: 'Lanjutan' },
                        { num: 5, title: 'Meeting 5: Praktek Intensif & Simulasi Sesi 1', desc: 'Uji pemahaman paruh materi dengan simulasi berbasis waktu.', tag: 'Simulasi' },
                        { num: 6, title: 'Meeting 6: Evaluasi Progres & Perbaikan Kelemahan', desc: 'Analisis kesalahan umum dan teknik akselerasi pemahaman.', tag: 'Evaluasi' },
                        { num: 7, title: 'Meeting 7: Aplikasi Keterampilan & Studi Kasus Nyata', desc: 'Penerapan langsung materi dalam konteks akademis dan profesional.', tag: 'Praktek' },
                        { num: 8, title: 'Meeting 8: Review Menyeluruh & Simulasi Akhir', desc: 'Simulasi ujian lengkap dan penyusunan rekomendasi pasca kursus.', tag: 'Final' }
                    ]
                };
            }

            if (titleEl) titleEl.innerText = 'Materi: ' + (data.title || programName);
            if (badgeEl) badgeEl.innerText = data.badge || 'Daftar materi & silabus per pertemuan';
            if (countEl) countEl.innerText = `${data.meetings.length} Pertemuan Terstruktur`;

            currentSyllabusList = data.meetings;
            renderSyllabusList(data.meetings);

            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        };

        function renderSyllabusList(meetings) {
            const bodyEl = document.getElementById('tb-syllabus-body');
            if (!bodyEl) return;

            if (!meetings || meetings.length === 0) {
                bodyEl.innerHTML = `
                    <div class="text-center py-12 text-gray-500">
                        <i class="fas fa-search text-3xl mb-3 text-gray-300"></i>
                        <p class="text-sm font-semibold">Tidak ada materi yang sesuai dengan pencarian.</p>
                        <p class="text-xs text-gray-400 mt-1">Coba kata kunci lain atau hapus pencarian.</p>
                    </div>
                `;
                return;
            }

            let html = '';
            meetings.forEach(m => {
                const tagColors = {
                    'Listening': 'bg-blue-100 text-blue-700 border-blue-200',
                    'Structure': 'bg-purple-100 text-purple-700 border-purple-200',
                    'Written Exp': 'bg-indigo-100 text-indigo-700 border-indigo-200',
                    'Reading': 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    'Writing': 'bg-amber-100 text-amber-700 border-amber-200',
                    'Speaking': 'bg-rose-100 text-rose-700 border-rose-200',
                    'Mock Test': 'bg-red-100 text-red-700 border-red-200 font-bold',
                    'High-Yield': 'bg-fuchsia-100 text-fuchsia-700 border-fuchsia-200 font-bold',
                    'Grammar': 'bg-cyan-100 text-cyan-700 border-cyan-200',
                    'Fondasi': 'bg-teal-100 text-teal-700 border-teal-200'
                };
                const tagClass = tagColors[m.tag] || 'bg-gray-100 text-gray-700 border-gray-200';

                html += `
                    <div style="background: #ffffff; padding: 14px 16px; border-radius: 14px; border: 1.5px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04); display: flex; align-items: flex-start; gap: 14px; transition: all 0.2s;" onmouseenter="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 4px 12px rgba(59,130,246,0.1)';" onmouseleave="this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)';">
                        <!-- Number Badge: High Contrast & Super Clear -->
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; border: 2px solid #3b82f6; display: flex; flex-direction: column; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 5px rgba(59,130,246,0.15);">
                            <span style="font-size: 10px; font-weight: 800; color: #2563eb; line-height: 1; letter-spacing: 0.5px;">M</span>
                            <span style="font-size: 17px; font-weight: 900; color: #1e3a8a; line-height: 1; margin-top: 2px;">${m.num}</span>
                        </div>
                        <div style="flex-grow: 1; min-width: 0;">
                            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 6px; margin-bottom: 4px;">
                                <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.35;">
                                    ${m.title}
                                </h4>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border ${tagClass}">
                                    ${m.tag}
                                </span>
                            </div>
                            <p style="font-size: 12px; color: #475569; line-height: 1.5; margin: 0;">
                                ${m.desc}
                            </p>
                        </div>
                    </div>
                `;
            });

            bodyEl.innerHTML = html;
        }

        window.filterSyllabusMeetings = function(keyword) {
            if (!keyword || !keyword.trim()) {
                renderSyllabusList(currentSyllabusList);
                return;
            }
            const q = keyword.toLowerCase().trim();
            const filtered = currentSyllabusList.filter(m => 
                m.title.toLowerCase().includes(q) || 
                m.desc.toLowerCase().includes(q) || 
                m.tag.toLowerCase().includes(q) ||
                ('meeting ' + m.num).includes(q)
            );
            renderSyllabusList(filtered);
        };

        window.closeSyllabusModal = window.closeAllModals;
    </script>
</body>
</html>
@php /**PATH /Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php ENDPATH**/ @endphp