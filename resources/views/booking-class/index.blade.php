@php
    $categories = [
        'all' => ['label' => 'Semua', 'icon' => 'grid'],
        'IELTS' => ['label' => 'IELTS', 'icon' => 'academic'],
        'TOEFL' => ['label' => 'TOEFL', 'icon' => 'certificate'],
        'Speaking' => ['label' => 'Speaking', 'icon' => 'chat'],
        'Grammar & Writing' => ['label' => 'Grammar', 'icon' => 'pencil'],
        'PTE Academic' => ['label' => 'PTE', 'icon' => 'globe'],
        'Bahasa Asing' => ['label' => 'Bahasa Asing', 'icon' => 'translate'],
    ];

    $programsJson = $programs->map(function($p) use ($bookingCounts) {
        $slug = strtolower($p->slug ?? '');
        $name = strtolower($p->name ?? '');
        
        $category = 'Kursus';
        $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
        
        if (str_contains($slug, 'ielts') || str_contains($name, 'ielts')) {
            $category = 'IELTS';
            $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
        } elseif (str_contains($slug, 'toefl') || str_contains($name, 'toefl')) {
            $category = 'TOEFL';
            $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
        } elseif (str_contains($slug, 'speaking') || str_contains($name, 'speaking')) {
            $category = 'Speaking';
            $badgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
        } elseif (str_contains($slug, 'grammar') || str_contains($name, 'grammar') || str_contains($slug, 'writing') || str_contains($name, 'writing')) {
            $category = 'Grammar & Writing';
            $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200';
        } elseif (str_contains($slug, 'pte') || str_contains($name, 'pte')) {
            $category = 'PTE Academic';
            $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
        } elseif (str_contains($slug, 'jepang') || str_contains($name, 'jepang') || str_contains($slug, 'japanese') || str_contains($name, 'japanese')) {
            $category = 'Bahasa Asing';
            $badgeClass = 'bg-pink-50 text-pink-700 border-pink-200';
        } elseif (str_contains($slug, 'korea') || str_contains($name, 'korea') || str_contains($slug, 'korean') || str_contains($name, 'korean')) {
            $category = 'Bahasa Asing';
            $badgeClass = 'bg-purple-50 text-purple-700 border-purple-200';
        } elseif (str_contains($slug, 'jerman') || str_contains($name, 'jerman') || str_contains($slug, 'german') || str_contains($name, 'german')) {
            $category = 'Bahasa Asing';
            $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
        } elseif (str_contains($slug, 'prancis') || str_contains($name, 'prancis') || str_contains($slug, 'french') || str_contains($name, 'french')) {
            $category = 'Bahasa Asing';
            $badgeClass = 'bg-cyan-50 text-cyan-700 border-cyan-200';
        } elseif (str_contains($slug, 'arab') || str_contains($name, 'arab') || str_contains($slug, 'arabic') || str_contains($name, 'arabic')) {
            $category = 'Bahasa Asing';
            $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
        } elseif (str_contains($slug, 'mandarin') || str_contains($name, 'mandarin')) {
            $category = 'Bahasa Asing';
            $badgeClass = 'bg-red-50 text-red-700 border-red-200';
        }

        return [
            'id' => (string) $p->id,
            'name' => $p->name,
            'category' => $category,
            'badgeClass' => $badgeClass,
            'bookingCount' => (int) ($bookingCounts[$p->id] ?? 0),
            'deliveryMode' => $p->delivery_mode,
        ];
    })->values();

    $layout = Auth::check() ? 'layouts.dashboard' : 'layouts.blank';
    $pageTitle = 'Booking Class';
    $pageDescription = 'Formulir pendaftaran dan booking periode belajar kelas Target Bahasa';
@endphp

@extends($layout)

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div x-data="{
    programsList: {{ json_encode($programsJson, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }},
    filterProgram: '{{ old('program_id', $programs->first()->id ?? '') }}',
    filterType: '{{ old('batch_type', 'regular') }}',
    selectedMonth: '{{ old('booking_month', $months[0] ?? 'Maret 2026') }}',
    selectedWeek: '{{ old('booking_week', 'Minggu 1') }}',
    searchProgram: '',
    selectedCategory: 'all',
    openMonthDropdown: false,
    agreeTerms: true,
    periodCounts: {{ json_encode($periodCounts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }},

    get selectedProgram() {
        return this.programsList.find(p => p.id == this.filterProgram) || this.programsList[0] || { name: 'Pilih Program Kursus', category: 'Semua', badgeClass: 'bg-blue-50 text-blue-700 border-blue-200', bookingCount: 0, deliveryMode: 'online' };
    },

    get filterMode() {
        return this.selectedProgram.deliveryMode || 'online';
    },

    get selectedBatchCount() {
        const key = this.filterProgram + '|' + this.selectedMonth + '|' + this.selectedWeek;
        return this.periodCounts[key] || 0;
    },

    get filteredPrograms() {
        return this.programsList.filter(p => {
            const query = this.searchProgram.trim().toLowerCase();
            const matchesSearch = query === '' || 
                p.name.toLowerCase().includes(query) || 
                p.category.toLowerCase().includes(query);
            const matchesCategory = this.selectedCategory === 'all' || p.category === this.selectedCategory;
            return matchesSearch && matchesCategory;
        });
    }
}">

    @guest
        {{-- Top Navbar for Guest Visitors --}}
        <header class="bg-white/95 backdrop-blur-md border-b border-blue-100/80 sticky top-0 z-30 shadow-xs mb-6 -mx-4 -mt-4 sm:-mx-6 sm:-mt-6 lg:-mx-8 lg:-mt-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group shrink-0">
                    <img src="{{ asset('images/brand/logo.png') }}" alt="Target Bahasa" class="h-8 w-auto object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div class="hidden w-9 h-9 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold text-xs items-center justify-center shadow-md shadow-blue-500/20">TB</div>
                    <div class="flex flex-col">
                        <span class="font-black text-base text-slate-900 tracking-tight leading-tight group-hover:text-blue-600 transition">Target Bahasa</span>
                        <span class="text-[10px] text-blue-500 font-bold tracking-wider">Course & Certification</span>
                    </div>
                </a>

                {{-- Center Search Quick Bar --}}
                <div class="hidden md:flex items-center flex-1 max-w-md mx-4">
                    <div class="relative w-full">
                        <input type="text" 
                               x-model="searchProgram"
                               placeholder="Cari program kursus (IELTS, TOEFL, Speaking)..." 
                               class="w-full bg-blue-50/50 border border-blue-100 rounded-full py-2 pl-4 pr-10 text-xs sm:text-sm text-slate-700 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition shadow-2xs">
                        <div class="absolute right-1.5 top-1.5 w-7 h-7 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Right Action --}}
                <div class="flex items-center gap-2.5 shrink-0">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-500 text-white text-xs sm:text-sm font-bold shadow-sm shadow-blue-500/20 hover:bg-blue-600 transition">
                        <span>Masuk Portal</span>
                    </a>
                </div>
            </div>
        </header>
    @endguest

    {{-- Main Content Container --}}
    <main class="max-w-4xl mx-auto px-2 sm:px-4 lg:px-6 py-2 md:py-4">

        {{-- Alerts --}}
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-3xl flex items-center gap-3 text-sm shadow-xs">
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-3xl text-sm shadow-xs">
                <div class="font-bold mb-1">Mohon periksa data formulir:</div>
                <ul class="list-disc pl-6 space-y-0.5 text-xs sm:text-sm text-red-700">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Booking Success Receipt (If Submitted) --}}
        @if(session('booking_success_data'))
            @php $receipt = session('booking_success_data'); @endphp
            <div class="mb-8 bg-white border-2 border-emerald-500 rounded-3xl p-6 sm:p-8 shadow-sm relative overflow-hidden">
                <div class="flex items-start gap-4 mb-5">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl shrink-0">
                        ✓
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Konfirmasi Pendaftaran</span>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Booking Kelas Berhasil</h2>
                        <p class="text-sm text-slate-500 mt-0.5">Jadwal belajar Anda telah terdaftar resmi ke sistem Target Bahasa.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 rounded-2xl p-5 border border-slate-200 text-sm">
                    <div>
                        <span class="text-slate-400 font-medium block text-xs">Nama Peserta</span>
                        <strong class="text-slate-900 text-base font-bold">{{ $receipt['student_name'] }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block text-xs">Kontak</span>
                        <span class="text-slate-800 font-semibold">{{ $receipt['student_email'] }} &bull; {{ $receipt['student_phone'] }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block text-xs">Program Kursus</span>
                        <strong class="text-blue-600 text-base font-bold">{{ $receipt['program_name'] }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block text-xs">Periode Belajar</span>
                        <strong class="text-slate-900 text-base font-bold">{{ $receipt['batch_name'] }}</strong>
                        <p class="text-slate-500 text-xs mt-0.5">Tipe: {{ $receipt['batch_type'] }} &bull; Moda: {{ $receipt['learning_mode'] }}</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100">
                    <p class="text-xs sm:text-sm text-slate-500">
                        Admin kami akan segera menghubungi WhatsApp Anda untuk konfirmasi jadwal dan grup kelas.
                    </p>
                    @php
                        $adminWa = preg_replace('/[^0-9]/', '', setting('contact_whatsapp', setting('support_phone', '6285706615607')));
                        if (str_starts_with($adminWa, '0')) {
                            $adminWa = '62' . substr($adminWa, 1);
                        }
                        if (empty($adminWa)) {
                            $adminWa = '6285706615607';
                        }
                    @endphp
                    <a href="https://wa.me/{{ $adminWa }}?text={{ urlencode('Halo Admin Target Bahasa, saya telah melakukan booking kelas untuk program ' . $receipt['program_name'] . ' periode ' . $receipt['batch_name'] . ' atas nama ' . $receipt['student_name']) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-full shadow-sm transition">
                        <span>Konfirmasi via WhatsApp</span>
                    </a>
                </div>
            </div>
        @endif

        {{-- BOOKING FORM --}}
        <form method="POST" action="{{ route('student.booking-class.submit') }}" class="space-y-6">
            @csrf

            {{-- Hidden fields for form state --}}
            <input type="hidden" name="program_id" :value="filterProgram" required>
            <input type="hidden" name="batch_type" :value="filterType" required>
            <input type="hidden" name="learning_mode" :value="filterMode" required>
            <input type="hidden" name="booking_month" :value="selectedMonth" required>
            <input type="hidden" name="booking_week" :value="selectedWeek" required>

    @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->active_role === 'admin' || (method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())))
        <!-- Floating Admin Preview Panel -->
        <div class="fixed top-20 right-6 z-50 flex flex-col items-end">
            <button type="button" 
                    onclick="document.getElementById('admin-preview-content-booking').classList.toggle('hidden')"
                    class="bg-blue-600 hover:bg-blue-700 text-white shadow-xl rounded-full px-4 py-2.5 text-xs font-bold uppercase tracking-wider flex items-center gap-2 transition-transform hover:scale-105 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Admin Preview
            </button>

            <div id="admin-preview-content-booking" class="mt-2 bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-200 p-5 w-72 text-sm hidden transition-all">
                <div class="font-bold text-gray-800 mb-1.5 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        Panel Preview
                    </span>
                    <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">Admin</span>
                </div>
                <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                    Gunakan tombol di bawah ini untuk melompat antar tahap (tanpa perlu scroll manual).
                </p>
                <div class="flex flex-col gap-2">
                    <button type="button" 
                            onclick="document.getElementById('section-data-diri').scrollIntoView({ behavior: 'smooth' })"
                            class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition border border-gray-200 hover:border-blue-200 font-medium text-xs cursor-pointer">
                        Tahap 1: Data Diri Siswa
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('section-program').scrollIntoView({ behavior: 'smooth' })"
                            class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition border border-gray-200 hover:border-blue-200 font-medium text-xs cursor-pointer">
                        Tahap 2: Pilih Program Kursus
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('section-periode').scrollIntoView({ behavior: 'smooth' })"
                            class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition border border-gray-200 hover:border-blue-200 font-medium text-xs cursor-pointer">
                        Tahap 3: Periode & Minggu Belajar
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('section-konfirmasi').scrollIntoView({ behavior: 'smooth' })"
                            class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition border border-gray-200 hover:border-blue-200 font-medium text-xs cursor-pointer">
                        Tahap 4: Catatan & Konfirmasi
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-center">
                    <a href="{{ route('admin.bookings.index') }}" target="_blank"
                        class="text-xs text-blue-600 hover:text-blue-800 font-semibold hover:underline flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Kelola Booking di Admin
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- SECTION 1: DATA DIRI SISWA --}}
    <div id="section-data-diri" class="bg-white border border-blue-100/90 rounded-3xl p-6 sm:p-8 shadow-sm">
                <div class="text-center sm:text-left mb-6 pb-4 border-b border-blue-50 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="flex items-center justify-center sm:justify-start gap-3">
                        <div class="w-9 h-9 rounded-full border-2 border-blue-500 text-blue-600 font-black text-sm flex items-center justify-center shrink-0">
                            1
                        </div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                            Data Diri Siswa
                        </h2>
                    </div>
                    @auth
                        <div class="inline-flex items-center justify-center gap-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold border border-blue-100 self-center sm:self-auto">
                            <span>✓ Logged in as {{ Auth::user()->email }}</span>
                        </div>
                    @else
                        <span class="text-xs text-slate-400 font-medium">Tanpa perlu registrasi manual di awal</span>
                    @endauth
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 text-xs sm:text-sm mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $user->name ?? '') }}" 
                               required 
                               placeholder="Contoh: Budi Santoso"
                               class="w-full rounded-2xl border-blue-100 bg-blue-50/30 text-sm p-3.5 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 font-medium transition shadow-2xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-xs sm:text-sm mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $user->email ?? '') }}" 
                               required 
                               placeholder="budi@gmail.com"
                               class="w-full rounded-2xl border-blue-100 bg-blue-50/30 text-sm p-3.5 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 font-medium transition shadow-2xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-xs sm:text-sm mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="whatsapp" 
                               value="{{ old('whatsapp', $user->phone_number ?? '') }}" 
                               required 
                               placeholder="081234567890"
                               class="w-full rounded-2xl border-blue-100 bg-blue-50/30 text-sm p-3.5 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 font-medium transition shadow-2xs">
                    </div>
                </div>
            </div>

            {{-- SECTION 2: PILIHAN PROGRAM & MODE BELAJAR (VISUAL PILL CARDS) --}}
            <div id="section-program" class="bg-white border border-blue-100/90 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-blue-50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full border-2 border-blue-500 text-blue-600 font-black text-sm flex items-center justify-center shrink-0">
                            2
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                                Pilihan Kategori Program Kursus
                            </h2>
                            <p class="text-xs text-slate-500 font-medium">Pilih program kursus bahasa yang ingin Anda ikuti</p>
                        </div>
                    </div>

                    {{-- Category Filter Pills --}}
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 scrollbar-none">
                        @foreach($categories as $key => $cat)
                            <button type="button" 
                                    @click="selectedCategory = '{{ $key }}'"
                                    :class="selectedCategory === '{{ $key }}' ? 'bg-blue-500 text-white font-bold shadow-xs' : 'bg-blue-50/70 text-slate-600 hover:bg-blue-100 font-medium'"
                                    class="px-3 py-1.5 rounded-full text-xs transition-all whitespace-nowrap cursor-pointer">
                                {{ $cat['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Programs Tag Grid Selection --}}
                <div class="space-y-3">
                    <div class="flex flex-wrap gap-2.5">
                        <template x-for="p in filteredPrograms" :key="p.id">
                            <button type="button" 
                                    @click="filterProgram = p.id"
                                    :class="filterProgram == p.id ? 'bg-blue-500 text-white font-bold shadow-md shadow-blue-500/20 ring-2 ring-blue-300 scale-102' : 'bg-blue-50/70 hover:bg-blue-100 text-slate-700 border border-blue-100/80 font-medium'"
                                    class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm transition-all duration-150 flex items-center gap-2 cursor-pointer">
                                <span x-text="p.name"></span>
                                <span x-show="filterProgram == p.id" class="text-white text-xs">✓</span>
                            </button>
                        </template>
                    </div>

                    <div x-show="filteredPrograms.length === 0" class="p-6 text-center bg-blue-50/40 rounded-2xl border border-dashed border-blue-200 text-slate-500 text-xs sm:text-sm">
                        Tidak ada program kursus yang cocok dengan filter atau kata kunci pencarian.
                    </div>
                </div>

                {{-- Class Type & Learning Mode Selectors --}}
                <div class="pt-5 border-t border-blue-50 grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">
                    {{-- Tipe Kelas --}}
                    <div>
                        <label class="block font-bold text-slate-800 text-sm mb-2">
                            Tipe Kelas Belajar <span class="text-red-500">*</span>
                        </label>
                        <div class="p-1 bg-blue-50/80 rounded-2xl sm:rounded-full border border-blue-100 flex flex-col sm:flex-row w-full gap-1">
                            <button type="button" 
                                    @click="filterType = 'regular'"
                                    :class="filterType === 'regular' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'text-blue-700 hover:text-blue-900 font-semibold'"
                                    class="flex-1 py-2.5 px-3 text-xs sm:text-sm rounded-xl sm:rounded-full transition-all text-center cursor-pointer whitespace-nowrap">
                                Reguler (4-10 orang)
                            </button>
                            <button type="button" 
                                    @click="filterType = 'semi_private'"
                                    :class="filterType === 'semi_private' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'text-blue-700 hover:text-blue-900 font-semibold'"
                                    class="flex-1 py-2.5 px-3 text-xs sm:text-sm rounded-xl sm:rounded-full transition-all text-center cursor-pointer whitespace-nowrap">
                                Semi-Privat (2-3 orang)
                            </button>
                            <button type="button" 
                                    @click="filterType = 'private'"
                                    :class="filterType === 'private' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'text-blue-700 hover:text-blue-900 font-semibold'"
                                    class="flex-1 py-2.5 px-3 text-xs sm:text-sm rounded-xl sm:rounded-full transition-all text-center cursor-pointer whitespace-nowrap">
                                Private 1-on-1
                            </button>
                        </div>
                    </div>

                    {{-- Moda Belajar (mengikuti program yang dipilih) --}}
                    <div>
                        <label class="block font-bold text-slate-800 text-sm mb-2">
                            Moda Belajar
                        </label>
                        <div class="p-3 px-4 bg-blue-50/80 rounded-full border border-blue-100 text-sm font-bold text-blue-700 flex items-center gap-2">
                            <span x-text="filterMode === 'offline' ? '🏫 Offline (Tatap Muka)' : '💻 Online (Zoom Live)'"></span>
                            <span class="text-xs font-normal text-slate-500">— sesuai program yang dipilih</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: PILIHAN BULAN & MINGGU BELAJAR --}}
            <div id="section-periode" class="bg-white border border-blue-100/90 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-blue-50">
                    <div class="w-9 h-9 rounded-full border-2 border-blue-500 text-blue-600 font-black text-sm flex items-center justify-center shrink-0">
                        3
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                            Pilih Periode & Minggu Belajar
                        </h2>
                        <p class="text-xs text-slate-500 font-medium">Tentukan bulan mulai serta minggu periode kelas pilihan Anda</p>
                    </div>
                </div>

                {{-- Month Selection Pill / Select Bar --}}
                <div class="space-y-2">
                    <label class="block font-bold text-slate-800 text-xs sm:text-sm">Bulan Mulai Belajar <span class="text-red-500">*</span></label>
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" 
                                @click="open = !open" 
                                class="w-full bg-blue-50/50 hover:bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-center justify-between text-left transition cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-blue-500 text-white flex items-center justify-center shrink-0 font-bold text-xs">
                                    📅
                                </div>
                                <div>
                                    <span class="text-xs text-slate-400 font-medium block">Bulan Dipilih</span>
                                    <strong class="text-slate-900 font-bold text-sm sm:text-base" x-text="selectedMonth"></strong>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-blue-600 font-bold bg-blue-100 px-3 py-1 rounded-full">12 Bulan Tersedia</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false" 
                             x-transition
                             class="absolute left-0 right-0 mt-2 bg-white border border-blue-100 rounded-2xl shadow-xl z-20 p-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                            @foreach($months as $m)
                                <button type="button" 
                                        @click="selectedMonth = '{{ $m }}'; open = false"
                                        :class="selectedMonth === '{{ $m }}' ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-slate-700 font-medium'"
                                        class="p-3 rounded-xl text-xs sm:text-sm text-left transition-colors cursor-pointer flex items-center justify-between">
                                    <span>{{ $m }}</span>
                                    <span x-show="selectedMonth === '{{ $m }}'" class="text-xs">✓</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Week Selection Pill Cards --}}
                <div class="space-y-3 pt-2">
                    <label class="block font-bold text-slate-800 text-xs sm:text-sm">Minggu Belajar <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <button type="button" 
                                @click="selectedWeek = 'Minggu 1'"
                                :class="selectedWeek === 'Minggu 1' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-200' : 'bg-blue-50/70 hover:bg-blue-100 text-slate-800 border border-blue-100'"
                                class="p-4 rounded-2xl text-left transition-all duration-150 flex flex-col justify-between gap-1 cursor-pointer">
                            <span class="font-black text-sm sm:text-base">Minggu 1</span>
                            <span :class="selectedWeek === 'Minggu 1' ? 'text-blue-100' : 'text-slate-500'" class="text-xs sm:text-sm font-medium">1 – 7 Bulan</span>
                        </button>

                        <button type="button" 
                                @click="selectedWeek = 'Minggu 2'"
                                :class="selectedWeek === 'Minggu 2' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-200' : 'bg-blue-50/70 hover:bg-blue-100 text-slate-800 border border-blue-100'"
                                class="p-4 rounded-2xl text-left transition-all duration-150 flex flex-col justify-between gap-1 cursor-pointer">
                            <span class="font-black text-sm sm:text-base">Minggu 2</span>
                            <span :class="selectedWeek === 'Minggu 2' ? 'text-blue-100' : 'text-slate-500'" class="text-xs sm:text-sm font-medium">8 – 14 Bulan</span>
                        </button>

                        <button type="button" 
                                @click="selectedWeek = 'Minggu 3'"
                                :class="selectedWeek === 'Minggu 3' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-200' : 'bg-blue-50/70 hover:bg-blue-100 text-slate-800 border border-blue-100'"
                                class="p-4 rounded-2xl text-left transition-all duration-150 flex flex-col justify-between gap-1 cursor-pointer">
                            <span class="font-black text-sm sm:text-base">Minggu 3</span>
                            <span :class="selectedWeek === 'Minggu 3' ? 'text-blue-100' : 'text-slate-500'" class="text-xs sm:text-sm font-medium">15 – 21 Bulan</span>
                        </button>

                        <button type="button" 
                                @click="selectedWeek = 'Minggu 4'"
                                :class="selectedWeek === 'Minggu 4' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-200' : 'bg-blue-50/70 hover:bg-blue-100 text-slate-800 border border-blue-100'"
                                class="p-4 rounded-2xl text-left transition-all duration-150 flex flex-col justify-between gap-1 cursor-pointer">
                            <span class="font-black text-sm sm:text-base">Minggu 4</span>
                            <span :class="selectedWeek === 'Minggu 4' ? 'text-blue-100' : 'text-slate-500'" class="text-xs sm:text-sm font-medium">22 – Akhir Bulan</span>
                        </button>
                    </div>
                </div>

                {{-- Clean Schedule Summary Pill --}}
                <div class="p-4 sm:p-5 bg-gradient-to-r from-blue-50/90 via-indigo-50/70 to-blue-50/90 border border-blue-100 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-sm">
                    <div class="space-y-1">
                        <span class="text-xs uppercase font-bold text-blue-600 tracking-wider">Jadwal Belajar Dipilih:</span>
                        <h4 class="text-slate-900 font-black text-base sm:text-lg">
                            <span x-text="selectedMonth"></span> &bull; <span x-text="selectedWeek"></span>
                        </h4>
                        <p class="text-slate-600 text-xs sm:text-sm">
                            Tipe: <strong class="text-blue-600 font-bold" x-text="filterType === 'private' ? 'Private 1-on-1' : (filterType === 'semi_private' ? 'Semi-Privat (2-3 orang)' : 'Reguler (4-10 orang)')"></strong>
                            &bull; Moda: <strong class="text-indigo-600 font-bold" x-text="filterMode === 'offline' ? 'Offline (Tatap Muka)' : 'Online (Zoom Live)'"></strong>
                        </p>
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full font-bold text-xs sm:text-sm shrink-0 self-start sm:self-center border border-emerald-300">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Pendaftaran Terbuka</span>
                    </div>
                </div>

            </div>

            {{-- SECTION 4: CATATAN & KONFIRMASI BOOKING --}}
            <div id="section-konfirmasi" class="bg-white border border-blue-100/90 rounded-3xl p-6 sm:p-8 shadow-sm space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-blue-50">
                    <div class="w-9 h-9 rounded-full border-2 border-blue-500 text-blue-600 font-black text-sm flex items-center justify-center shrink-0">
                        4
                    </div>
                    <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                        Catatan & Konfirmasi Booking
                    </h2>
                </div>

                <div class="space-y-4 text-sm">
                    <div>
                        <label class="block font-bold text-slate-700 text-xs sm:text-sm mb-2">Catatan Tambahan untuk Tutor / Admin (Opsional)</label>
                        <textarea name="notes" 
                                  rows="3" 
                                  placeholder="Contoh: Target tes IELTS/TOEFL, jam belajar yang diprioritaskan, dsb..."
                                  class="w-full rounded-2xl border-blue-100 bg-blue-50/30 text-sm p-4 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 font-medium transition shadow-2xs">{{ old('notes') }}</textarea>
                    </div>

                    <div class="p-4 bg-blue-50/60 rounded-2xl border border-blue-100">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="agree_terms" 
                                   value="1" 
                                   x-model="agreeTerms" 
                                   required 
                                   class="mt-0.5 text-blue-600 focus:ring-blue-500 rounded-md border-blue-300 w-4 h-4">
                            <span class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                                Saya menyatakan data yang diisi telah sesuai, jadwal periode belajar telah dipilih dengan benar, dan menyetujui syarat & ketentuan kursus di <strong>Target Bahasa</strong>.
                            </span>
                        </label>
                    </div>

                    <div class="pt-3 flex flex-col sm:flex-row sm:items-center justify-end gap-4">
                        <button type="submit" 
                                :disabled="!agreeTerms || !filterProgram || !selectedMonth || !selectedWeek"
                                :class="(!agreeTerms || !filterProgram || !selectedMonth || !selectedWeek) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/30 active:scale-98'"
                                class="w-full sm:w-auto px-8 py-3.5 bg-blue-500 text-white font-extrabold text-sm rounded-full transition-all duration-200 flex items-center justify-center gap-2 shadow-md shadow-blue-500/25 cursor-pointer">
                            <span>Konfirmasi & Booking Kelas</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Footer --}}
        <div class="mt-12 text-center text-xs sm:text-sm text-slate-400">
            <p>&copy; {{ date('Y') }} Target Bahasa Course. All rights reserved.</p>
        </div>
    </main>
</div>
@endsection
