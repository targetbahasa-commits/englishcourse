@extends('layouts.dashboard')

@section('title', 'Working Holiday Visa (WHV) Australia')

@section('content')
@if(!$featuredApplication)
    <div class="-mx-4 px-4 py-10 md:-mx-8 md:px-8">
        <div class="rounded-[2rem] border border-amber-100 bg-white p-10 text-center shadow-sm">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V6a3 3 0 013-3h0a3 3 0 013 3v1m4 0H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2z"></path></svg>
            </div>
            <h1 class="text-3xl font-black text-slate-900">Informasi WHV Australia sedang disiapkan</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-slate-500">Halaman ini akan didedikasikan penuh untuk Working Holiday Visa Australia, termasuk syarat utama, alur pendaftaran, estimasi biaya, dan FAQ resmi.</p>
        </div>
    </div>
@else
    @php
        $whvPageBackground = asset('images/background-container/background-container.png');
        $whvHeroBackground = asset('images/background-container/background-container1.png');
        $whvGuideBackground = asset('images/background-container/background-kelas.png');
        $whvContextBackground = asset('images/background-container/referensi-background-kelas.png');
    @endphp
    <div class="relative -mx-4 overflow-hidden px-4 py-6 pb-24 md:-mx-8 md:px-8 md:py-8 md:pb-8" style="background: linear-gradient(180deg, #7DD3C0 0%, #A8DFD0 25%, #D4E8D4 50%, #F4C9B8 75%, #F4B5A0 100%); background-size: cover; background-position: center top; background-attachment: scroll;">
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-white/10 via-transparent to-white/20"></div>
        <!-- Hero Section -->
            <section data-whv-section="hero" class="relative overflow-hidden rounded-[2.25rem] bg-cover bg-center px-6 py-8 shadow-xl ring-1 ring-white/40 sm:px-8 sm:py-10 lg:px-10 lg:py-12" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.78), rgba(255, 245, 240, 0.88));">
            <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/30 via-transparent to-orange-100/15"></div>
                <div class="absolute -right-6 top-6 h-64 w-64 rounded-full bg-cyan-200/35 blur-3xl"></div>
                <div class="absolute bottom-6 left-6 h-40 w-40 rounded-full bg-amber-200/30 blur-3xl"></div>
            
            <div class="relative grid gap-10 xl:grid-cols-[1.3fr_0.7fr] xl:items-start">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-teal-300 bg-white/85 px-4 py-1.5 text-[11px] font-bold uppercase tracking-[0.24em] text-teal-700 shadow-sm backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-teal-500 animate-pulse"></span>
                        WHV Opportunity 2026
                    </span>

                    <h1 class="mt-6 max-w-4xl text-4xl font-black leading-[1.05] tracking-tight sm:text-5xl xl:text-6xl">
                        <span class="text-slate-900">Work & Travel in</span>
                        <span class="block text-cyan-700">{{ $featuredApplication->country }}</span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
                        {{ $featuredApplication->description }}
                    </p>
                    <p class="mt-2 max-w-2xl text-sm font-semibold leading-7 text-slate-700 sm:text-base">
                        Bangun pengalaman kerja internasional, dapatkan penghasilan dalam AUD, dan eksplor Australia selama masa visa.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <div class="flex items-center gap-3 rounded-2xl bg-white px-5 py-3 shadow-sm ring-1 ring-slate-100">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-100 text-cyan-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Destinasi</div>
                                <div class="font-bold text-slate-900">{{ $featuredApplication->country }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 rounded-2xl bg-white px-5 py-3 shadow-sm ring-1 ring-slate-100">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</div>
                                <div class="font-bold text-emerald-700">{{ $featuredApplication->status }}</div>
                            </div>
                        </div>

                        @if($featuredApplication->application_deadline)
                        <div class="flex items-center gap-3 rounded-2xl bg-white px-5 py-3 shadow-sm ring-1 ring-slate-100">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-100 text-orange-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Deadline</div>
                                <div class="font-bold text-orange-700">{{ $featuredApplication->application_deadline->format('d M Y') }}</div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                        <a href="#alur-pendaftaran" data-whv-cta="hero_start_application" class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-8 py-4 text-sm font-bold text-white shadow-xl shadow-slate-900/20 transition hover:bg-slate-800 hover:-translate-y-1">
                            <span data-whv-copy-key="hero_primary">Start Application</span>
                            <svg class="h-4 w-4 text-slate-400 transition group-hover:translate-x-1 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="{{ route('guest.free-tests') }}" data-whv-cta="hero_check_eligibility" data-whv-preserve-attribution="true" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-emerald-200 bg-emerald-50/90 px-8 py-4 text-sm font-bold text-emerald-700 shadow-sm transition hover:bg-emerald-100 hover:border-emerald-300">
                            <span data-whv-copy-key="hero_secondary">Check Eligibility</span>
                        </a>
                    </div>
                </div>

                <!-- Visa Snapshot Card -->
                <div class="relative">
                    <div class="absolute -inset-1 rounded-[2.5rem] bg-cyan-200/55 blur-xl"></div>
                    <div class="relative rounded-[2rem] bg-white/92 p-8 text-slate-900 shadow-2xl ring-1 ring-cyan-100 backdrop-blur-sm">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-6">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-700">Visa Snapshot</p>
                                <h2 class="mt-2 text-3xl font-black">Subclass 462</h2>
                            </div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-300 to-orange-400 text-white shadow-lg shadow-orange-300/40">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-cyan-50/90 p-4 ring-1 ring-cyan-100 transition hover:bg-cyan-100/90">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-cyan-700/80">Usia</div>
                                <div class="mt-1 text-lg font-bold text-slate-900">{{ $featuredApplication->age_requirement ?: '18-30' }}</div>
                            </div>
                            <div class="rounded-2xl bg-cyan-50/90 p-4 ring-1 ring-cyan-100 transition hover:bg-cyan-100/90">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-cyan-700/80">Durasi</div>
                                <div class="mt-1 text-lg font-bold text-slate-900">{{ $featuredApplication->visa_duration ?: '12 Bulan' }}</div>
                            </div>
                            <div class="rounded-2xl bg-cyan-50/90 p-4 ring-1 ring-cyan-100 transition hover:bg-cyan-100/90">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-cyan-700/80">Biaya Visa</div>
                                <div class="mt-1 text-lg font-bold text-slate-900">{{ $featuredApplication->application_fee ?: 'AUD 635+' }}</div>
                            </div>
                            <div class="rounded-2xl bg-cyan-50/90 p-4 ring-1 ring-cyan-100 transition hover:bg-cyan-100/90">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-cyan-700/80">Proses</div>
                                <div class="mt-1 text-lg font-bold text-slate-900">{{ $featuredApplication->processing_time ?: 'Bervariasi' }}</div>
                            </div>
                        </div>
                        
                        @if($featuredApplication->sponsored_by)
                        <div class="mt-6 flex items-center gap-3 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-700 ring-1 ring-emerald-100">
                            <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $featuredApplication->sponsored_by }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div data-whv-section="snapshot" class="mt-8 grid gap-6 xl:grid-cols-3">
            <!-- Peta Persiapan -->
            <article class="xl:col-span-1 rounded-[2rem] bg-white p-8 text-slate-900 shadow-xl shadow-cyan-200/40 ring-1 ring-teal-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-6 -mr-6 h-36 w-36 rounded-full bg-teal-200/50 blur-2xl"></div>
                <div class="relative">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Critical Path</p>
                    <h2 class="mt-3 text-2xl font-black leading-tight text-slate-900">3 Hal Wajib Beres Sebelum Submit</h2>
                    <div class="mt-6 space-y-4">
                        <div class="flex gap-4 rounded-xl bg-white/95 p-4 ring-1 ring-amber-100 shadow-sm">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-900">Dokumen Lengkap</div>
                                <p class="text-xs leading-5 text-slate-600 mt-1">Paspor, ijazah, & transkrip harus siap scan.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 rounded-xl bg-white/95 p-4 ring-1 ring-cyan-100 shadow-sm">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-cyan-100 text-cyan-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-900">English Score</div>
                                <p class="text-xs leading-5 text-slate-600 mt-1">IELTS/PTE sesuai syarat minimum.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 rounded-xl bg-white/95 p-4 ring-1 ring-rose-100 shadow-sm">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-rose-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-900">Timing Akurat</div>
                                <p class="mt-1 text-xs leading-5 text-slate-600">Jangan apply mepet deadline.</p>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-gradient-to-br from-sky-50 via-white to-indigo-50/60 p-5 shadow-sm ring-1 ring-sky-100">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-indigo-500 text-white shadow-lg shadow-sky-200/70">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-6H5m14 12H9m10 2a2 2 0 11-4 0 2 2 0 014 0zM9 7a2 2 0 11-4 0 2 2 0 014 0zm4 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-900">WAR SDUWHV</div>
                                    <p class="mt-1 text-xs leading-5 text-slate-600">Surat dukungan ini wajib untuk aplikasi WHV, ada alur administratif, dan harus disiapkan lebih awal.</p>
                                </div>
                            </div>

                            <div class="mt-4 rounded-xl border border-sky-100 bg-white/90 p-4">
                                <div class="text-[11px] font-bold uppercase tracking-[0.14em] text-sky-700">Estimasi Jadwal & Tips Penting</div>
                                <ul class="mt-3 space-y-2 text-xs leading-5 text-slate-700">
                                    <li class="flex gap-2"><span class="mt-0.5 text-sky-500">•</span><span>Belum ada jadwal tetap 2026 — estimasi batch: <strong>Feb–Apr</strong>, <strong>Jun–Agu</strong>, <strong>Okt–Nov</strong>. Pantau <strong>sduwhv.imigrasi.go.id</strong> dan Instagram <strong>@ditjen_imigrasi</strong>.</span></li>
                                    <li class="flex gap-2"><span class="mt-0.5 text-sky-500">•</span><span>Kuota bisa habis dalam hitungan menit. Pendaftaran biasanya dibuka tepat pukul <strong>09:00 WIB</strong> — pastikan sudah login sebelumnya dan jangan refresh berlebihan saat antrean diproses.</span></li>
                                    <li class="flex gap-2"><span class="mt-0.5 text-sky-500">•</span><span>Siapkan dokumen dari sekarang: paspor (berlaku ≥12 bln), sertifikat bahasa (&lt;2 tahun), bukti dana AUD 5.000+, ijazah D3/S1, dan SKCK.</span></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </article>

            <!-- Snapshot Cepat -->
            <article class="xl:col-span-2 rounded-[2rem] bg-cover bg-center p-8 shadow-sm ring-1 ring-cyan-100 relative overflow-hidden" style="background-image: linear-gradient(110deg, rgba(247,249,252,0.38), rgba(247,249,252,0.22)), url('{{ asset('images/whv/sydney-opera-house-day.jpg') }}');">
                <div class="absolute inset-0 bg-gradient-to-br from-white/30 via-cyan-100/15 to-transparent"></div>
                <div class="relative grid items-start gap-6 md:grid-cols-[0.92fr_1.08fr] md:gap-6">
                    @php
                        $daysToOpening = $featuredApplication->opening_date ? now()->startOfDay()->diffInDays($featuredApplication->opening_date->copy()->startOfDay(), false) : null;
                    @endphp

                    <div class="self-start rounded-2xl bg-white/82 p-6 ring-1 ring-white/90 backdrop-blur-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700/90">Key Highlights</p>
                        <h2 class="mt-3 text-3xl font-black text-[#0B1F3A]">Snapshot Program 2026</h2>
                        <p class="mt-4 text-sm leading-8 text-[#334155]">Program ini bukan sekadar visa. Ini adalah peluang kerja internasional, pendapatan dalam mata uang AUD, dan pengalaman hidup global dalam satu langkah strategis.</p>
                        <p class="mt-3 text-sm leading-8 text-[#334155]">Gunakan snapshot ini untuk melihat nilai utamanya secara cepat lalu lanjut ke pendaftaran dengan persiapan yang tepat.</p>

                        <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-slate-900 bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white shadow-sm shadow-slate-900/20">
                            <span class="h-2 w-2 rounded-full bg-amber-400 ring-2 ring-white/20"></span>
                            @if(!is_null($daysToOpening))
                                @if($daysToOpening > 0)
                                    Kuota dibuka dalam {{ $daysToOpening }} hari
                                @elseif($daysToOpening === 0)
                                    Kuota dibuka hari ini
                                @else
                                    Pendaftaran sedang berjalan
                                @endif
                            @else
                                Pantau jadwal resmi pembukaan kuota
                            @endif
                        </div>

                        <div class="mt-5 grid gap-3 sm:grid-cols-3 md:grid-cols-1 xl:grid-cols-3">
                            <div class="rounded-xl border border-cyan-100 bg-cyan-50/80 p-4">
                                <div class="text-[10px] font-bold uppercase tracking-[0.12em] text-cyan-700">Focus</div>
                                <div class="mt-1 text-sm font-black text-slate-900">Kerja sambil travel</div>
                                <p class="mt-1 text-xs leading-5 text-slate-600">Visa ini cocok untuk bangun pengalaman kerja internasional.</p>
                            </div>
                            <div class="rounded-xl border border-emerald-100 bg-emerald-50/80 p-4">
                                <div class="text-[10px] font-bold uppercase tracking-[0.12em] text-emerald-700">Ideal For</div>
                                <div class="mt-1 text-sm font-black text-slate-900">Usia produktif</div>
                                <p class="mt-1 text-xs leading-5 text-slate-600">Paling relevan untuk kandidat yang siap berangkat dalam 6-12 bulan.</p>
                            </div>
                            <div class="rounded-xl border border-amber-100 bg-amber-50/80 p-4">
                                <div class="text-[10px] font-bold uppercase tracking-[0.12em] text-amber-700">Priority</div>
                                <div class="mt-1 text-sm font-black text-slate-900">Dokumen & timing</div>
                                <p class="mt-1 text-xs leading-5 text-slate-600">Kuota cepat habis, jadi kesiapan dokumen lebih penting dari sekadar minat.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="md:col-span-2 flex items-center justify-between rounded-xl bg-white/80 px-4 py-3 ring-1 ring-white/90 backdrop-blur-sm">
                            <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-500">Quick Facts</p>
                            <span class="text-[11px] font-semibold text-emerald-700">Eligible umur 18-30</span>
                        </div>

                        <article class="rounded-xl bg-white/95 p-6 shadow-md ring-1 ring-slate-100 backdrop-blur-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg md:col-span-2">
                            <div class="flex items-start gap-4">
                                <div class="h-12 w-12 shrink-0 flex items-center justify-center rounded-full bg-orange-100 text-orange-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Earning Potential</div>
                                    <div class="mt-1 text-2xl font-black text-[#FF8C42]">AUD $20-30/hour</div>
                                    <p class="mt-1 text-sm font-semibold text-slate-700">~Rp 200-300k per jam</p>
                                </div>
                            </div>
                        </article>

                        <article class="md:col-span-2 rounded-xl bg-white/95 p-5 shadow-md ring-1 ring-cyan-100 backdrop-blur-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-cyan-100 text-cyan-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Estimasi Pembukaan Kuota 2026</div>
                            </div>
                            @if($featuredApplication->opening_date)
                                <div class="text-xl font-black text-[#0B1F3A]">{{ $featuredApplication->opening_date->format('d M Y') }}</div>
                            @else
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="flex flex-col gap-1 rounded-xl bg-orange-50 px-3 py-2.5 ring-1 ring-orange-100">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-orange-500">Batch 1</span>
                                        <span class="text-sm font-black text-slate-900 leading-tight">Feb – Apr</span>
                                        <span class="text-[9px] text-slate-500 leading-tight">Termasuk laporan kuota terbatas awal Feb 2026</span>
                                    </div>
                                    <div class="flex flex-col gap-1 rounded-xl bg-cyan-50 px-3 py-2.5 ring-1 ring-cyan-100">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-cyan-600">Batch 2</span>
                                        <span class="text-sm font-black text-slate-900 leading-tight">Jun – Agu</span>
                                        <span class="text-[9px] text-slate-500 leading-tight">Pertengahan tahun, kuota lebih besar</span>
                                    </div>
                                    <div class="flex flex-col gap-1 rounded-xl bg-emerald-50 px-3 py-2.5 ring-1 ring-emerald-100">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-emerald-600">Batch 3</span>
                                        <span class="text-sm font-black text-slate-900 leading-tight">Okt – Nov</span>
                                        <span class="text-[9px] text-slate-500 leading-tight">Akhir tahun, paling kompetitif</span>
                                    </div>
                                </div>
                                <p class="mt-3 text-[10px] leading-4 text-slate-500">Belum ada jadwal tetap. Jadwal muncul mendadak, biasanya dibuka pukul <strong>09:00 WIB</strong>. Pantau <strong>sduwhv.imigrasi.go.id</strong> &amp; <strong>@ditjen_imigrasi</strong>.</p>
                            @endif
                        </article>

                        <article class="rounded-xl bg-white/95 p-6 shadow-md ring-1 ring-slate-100 backdrop-blur-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-start gap-4">
                                <div class="h-12 w-12 shrink-0 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Visa Duration</div>
                                    <div class="mt-1 text-xl font-black text-[#0B1F3A]">12 months</div>
                                    <p class="mt-1 text-sm font-semibold text-slate-700">Extendable to 2-3 years</p>
                                </div>
                            </div>
                        </article>

                        <article class="rounded-xl bg-white/95 p-6 shadow-md ring-1 ring-slate-100 backdrop-blur-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-start gap-4">
                                <div class="h-12 w-12 shrink-0 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Minimum English Score</div>
                                    <div class="mt-1 text-xl font-black text-[#0B1F3A]">{{ $featuredApplication->min_score ?: 'IELTS 4.5 / PTE 30' }}</div>
                                </div>
                            </div>
                        </article>

                        <article class="rounded-xl bg-white/95 p-6 shadow-md ring-1 ring-slate-100 backdrop-blur-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex items-start gap-4">
                                <div class="h-12 w-12 shrink-0 flex items-center justify-center rounded-full bg-orange-100 text-orange-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Support Letter</div>
                                    <div class="mt-1 text-xl font-black text-[#0B1F3A]">SDUWHV Required</div>
                                </div>
                            </div>
                        </article>

                        <article class="md:col-span-2 rounded-xl bg-[#0B1F3A] p-5 shadow-md ring-1 ring-[#0B1F3A] transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex flex-col gap-3">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-sky-200">Next Step</div>
                                        <p class="mt-1 text-sm font-semibold text-white">Cek kelayakanmu sekarang, lalu lanjut siapkan dokumen.</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('guest.free-tests') }}" data-whv-cta="snapshot_check_eligibility" data-whv-preserve-attribution="true" class="inline-flex items-center justify-center rounded-lg bg-[#FF8C42] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#f47e31]"><span data-whv-copy-key="snapshot_eligibility">Cek Kelayakan Saya</span></a>
                                        <a href="{{ route('student.register') }}" data-whv-cta="snapshot_register_now" data-whv-preserve-attribution="true" class="inline-flex items-center justify-center rounded-lg bg-[#3DA9FC] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#2f97e7]"><span data-whv-copy-key="snapshot_register">Register Now</span></a>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 text-xs text-slate-200">
                                    <svg class="h-4 w-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Referensi kebijakan mengacu pada sumber resmi pemerintah Australia dan SDUWHV.
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </article>
        </div>

        <section data-whv-section="war-info-panels" class="mt-6 rounded-[2rem] bg-cover bg-center p-5 shadow-sm ring-1 ring-slate-200 sm:p-6" style="background-image: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(255,255,255,0.96)), url('{{ $whvGuideBackground }}');">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">War Preparation Guide</p>
                    <h2 class="mt-1.5 text-2xl font-black text-slate-900">Kanal Resmi & Persiapan Dokumen</h2>
                </div>
                <div class="flex items-center gap-2 rounded-full bg-white px-3 py-1.5 text-[11px] font-medium text-slate-500 shadow-sm ring-1 ring-slate-200">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                    Update Maret 2026
                </div>
            </div>

            <div class="mt-5 grid gap-4 xl:grid-cols-2">
                <article class="rounded-[1.6rem] border border-blue-100 bg-white/95 p-4 transition-all duration-300 hover:shadow-md hover:shadow-blue-500/10 sm:p-5" style="background-image: linear-gradient(180deg, rgba(239,246,255,0.82), rgba(255,255,255,0.96)), url('{{ $whvContextBackground }}'); background-size: cover; background-position: center;">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-blue-700/90">Kanal Informasi Resmi (Wajib Pantau)</p>
                    <p class="mt-1.5 text-sm leading-6 text-slate-600">Karena istilah War muncul karena kuota sering habis dalam hitungan menit, pantau kanal resmi berikut agar tidak tertinggal.</p>

                    <div class="mt-4 grid gap-2 md:grid-cols-3">
                        <a href="https://sduwhv.imigrasi.go.id" target="_blank" rel="noopener noreferrer" class="group rounded-[1.2rem] border border-blue-200 bg-white p-3 transition hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-sm">
                            <div class="flex items-start gap-2.5">
                                <div class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-xs font-black text-blue-700">1</div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold uppercase tracking-wider text-blue-600">Situs Resmi</div>
                                    <div class="mt-0.5 text-sm font-black text-slate-900">sduwhv.imigrasi.go.id</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-500">Cek pagi hari, biasanya pengumuman muncul di banner depan.</div>
                                </div>
                            </div>
                        </a>
                        <a href="https://instagram.com/ditjen_imigrasi" target="_blank" rel="noopener noreferrer" class="group rounded-[1.2rem] border border-sky-200 bg-white p-3 transition hover:-translate-y-0.5 hover:border-sky-300 hover:shadow-sm">
                            <div class="flex items-start gap-2.5">
                                <div class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-xs font-black text-sky-700">2</div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold uppercase tracking-wider text-sky-600">Instagram</div>
                                    <div class="mt-0.5 text-sm font-black text-slate-900">@ditjen_imigrasi</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-500">Kanal paling aktif memberikan update jadwal War.</div>
                                </div>
                            </div>
                        </a>
                        <a href="https://x.com/ditjen_imigrasi" target="_blank" rel="noopener noreferrer" class="group rounded-[1.2rem] border border-indigo-200 bg-white p-3 transition hover:-translate-y-0.5 hover:border-indigo-300 hover:shadow-sm">
                            <div class="flex items-start gap-2.5">
                                <div class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-indigo-100 text-xs font-black text-indigo-700">3</div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold uppercase tracking-wider text-indigo-600">X (Twitter)</div>
                                    <div class="mt-0.5 text-sm font-black text-slate-900">@ditjen_imigrasi</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-500">Pantau pengumuman tambahan dan pengingat resmi.</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>

                <article class="rounded-[1.6rem] border border-teal-100 bg-gradient-to-b from-teal-50/70 to-white p-4 transition-all duration-300 hover:shadow-md hover:shadow-teal-500/10 sm:p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-teal-700/90">Persiapan Sebelum War Dimulai</p>
                    <p class="mt-1.5 text-sm leading-6 text-slate-600">Jangan menunggu jadwal keluar. Pastikan dokumen berikut sudah siap di folder Anda.</p>

                    <div class="mt-4 grid gap-2 md:grid-cols-2">
                        <div class="rounded-[1.2rem] border border-emerald-200 bg-white p-3">
                            <div class="flex items-start gap-2.5">
                                <div class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-xs font-black text-emerald-700">1</div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-emerald-600">Paspor RI</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-700">Masa berlaku minimal 12 bulan.</div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-[1.2rem] border border-cyan-200 bg-white p-3">
                            <div class="flex items-start gap-2.5">
                                <div class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-cyan-100 text-xs font-black text-cyan-700">2</div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-cyan-600">Sertifikat Bahasa</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-700">IELTS 4.5, TOEFL iBT, atau PTE Academic (masih berlaku kurang dari 2 tahun).</div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-[1.2rem] border border-orange-200 bg-white p-3 md:col-span-2">
                            <div class="flex items-start gap-2.5">
                                <div class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-orange-100 text-xs font-black text-orange-700">3</div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-orange-600">Bukti Dana (Bank Statement)</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-700">Minimal AUD 5.000 (sekitar Rp52-55 juta), atas nama sendiri atau orang tua dengan surat penjamin.</div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-[1.2rem] border border-sky-200 bg-white p-3">
                            <div class="flex items-start gap-2.5">
                                <div class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-xs font-black text-sky-700">4</div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-sky-600">Ijazah/Transkrip</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-700">Minimal lulusan D3 atau telah menempuh pendidikan minimal 2 tahun S1.</div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-[1.2rem] border border-rose-200 bg-white p-3">
                            <div class="flex items-start gap-2.5">
                                <div class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-xs font-black text-rose-700">5</div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-rose-600">SKCK</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-700">Terkadang diminta untuk proses lanjutan di kedutaan setelah SDUWHV didapat.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section data-whv-section="program_context" class="mt-8 grid gap-6 2xl:grid-cols-[1.3fr_0.7fr]">
            <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Program Context</p>
                <h2 class="mt-3 text-3xl font-black text-slate-900">WHV lebih dari sekadar kerja</h2>
                <div class="mt-6 text-sm leading-8 text-slate-600 space-y-4">
                    <p>{{ $featuredApplication->eligibility_criteria ?: 'WHV adalah kesempatan emas bagi pemuda Indonesia untuk mendapatkan pengalaman global. Program ini memungkinkan Anda bekerja untuk membiayai liburan, belajar dalam jangka pendek, dan menjelajahi budaya Australia.' }}</p>

                    <div class="grid gap-3 md:grid-cols-3">
                        <div class="rounded-xl bg-[#F7F9FC] p-4 ring-1 ring-slate-200">
                            <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Global Exposure</div>
                            <p class="mt-1 text-sm font-semibold text-[#0B1F3A]">Pengalaman kerja internasional</p>
                        </div>
                        <div class="rounded-xl bg-[#F7F9FC] p-4 ring-1 ring-slate-200">
                            <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Income Potential</div>
                            <p class="mt-1 text-sm font-semibold text-[#0B1F3A]">Penghasilan dalam AUD</p>
                        </div>
                        <div class="rounded-xl bg-[#F7F9FC] p-4 ring-1 ring-slate-200">
                            <div class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Travel Opportunity</div>
                            <p class="mt-1 text-sm font-semibold text-[#0B1F3A]">Tinggal & eksplor Australia</p>
                        </div>
                    </div>

                    @if($featuredApplication->job_opportunities)
                    <div class="rounded-2xl bg-amber-50 p-6 border border-amber-100">
                        <div class="flex items-center gap-3 text-amber-800 font-bold mb-3">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Peluang Kerja
                        </div>
                        <p class="text-slate-700">{{ $featuredApplication->job_opportunities }}</p>
                        @if(count($workSectors) > 0)
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($workSectors as $sector)
                                    <span class="rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-amber-700 ring-1 ring-amber-200 shadow-sm">{{ $sector }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Colorful Checklist -->
            <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-cyan-100">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-orange-600/70">Eligibility Check</p>
                <h2 class="mt-3 text-2xl font-black text-slate-900">Syarat Dasar</h2>
                <p class="mt-2 text-sm leading-7 text-slate-600">Centang cepat syarat utama untuk melihat apakah kamu siap melangkah ke tahap aplikasi.</p>

                <div class="mt-6 flex flex-col gap-3">
                    @php
                        $checklistItems = [
                            [
                                'label' => 'Usia',
                                'val' => $featuredApplication->age_requirement,
                                'ring' => 'hover:ring-rose-200',
                                'stripe' => 'bg-rose-400',
                                'labelColor' => 'text-rose-600/80',
                            ],
                            [
                                'label' => 'Pendidikan',
                                'val' => $featuredApplication->education_requirement,
                                'ring' => 'hover:ring-sky-200',
                                'stripe' => 'bg-sky-400',
                                'labelColor' => 'text-sky-600/80',
                            ],
                            [
                                'label' => 'Dana Awal',
                                'val' => $featuredApplication->financial_requirement,
                                'ring' => 'hover:ring-emerald-200',
                                'stripe' => 'bg-emerald-400',
                                'labelColor' => 'text-emerald-600/80',
                            ],
                            [
                                'label' => 'Bahasa Inggris',
                                'val' => $featuredApplication->min_score,
                                'ring' => 'hover:ring-violet-200',
                                'stripe' => 'bg-violet-400',
                                'labelColor' => 'text-violet-600/80',
                            ],
                        ];
                    @endphp

                    @foreach($checklistItems as $item)
                        @if($item['val'])
                        <div class="relative overflow-hidden rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-100 transition hover:shadow-md {{ $item['ring'] }}">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $item['stripe'] }}"></div>
                            <div class="pl-2">
                                <div class="text-[10px] font-bold uppercase tracking-wider {{ $item['labelColor'] }}">{{ $item['label'] }}</div>
                                <div class="mt-1 font-semibold text-slate-700 leading-tight">{{ $item['val'] }}</div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-5 rounded-2xl border border-amber-100 bg-gradient-to-br from-amber-50 via-white to-orange-50/70 p-5 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-amber-700">Action</p>
                            <p class="mt-1 text-sm leading-6 text-slate-700">Kalau 3 dari 4 syarat sudah siap, kamu bisa lanjut ke tahap persiapan dokumen dan cek urutan aplikasi resminya.</p>
                        </div>
                    </div>
                    <a href="#alur-pendaftaran" data-whv-cta="eligibility_view_steps" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#0B1F3A] px-4 py-3 text-sm font-bold text-white transition hover:bg-slate-800 sm:w-auto">
                        Lihat Tahap Aplikasi
                    </a>
                </div>
            </div>
        </section>

        <!-- Main Requirements Grid with Colors -->
        <section data-whv-section="requirements" class="mt-8 rounded-[2.25rem] bg-white p-8 shadow-sm ring-1 ring-teal-100">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Essential Requirements</p>
                    <h2 class="mt-2 text-3xl font-black text-slate-900">Detail Persyaratan Indonesia</h2>
                </div>
                <div class="flex items-center gap-2 rounded-full bg-white px-4 py-2 text-xs font-medium text-slate-500 shadow-sm ring-1 ring-slate-200">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Updated per {{ now()->format('Y') }}
                </div>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @php
                    $requirementPalettes = [
                        [
                            'border' => 'border-cyan-100',
                            'bg' => 'from-cyan-50/80 to-white',
                            'shadow' => 'hover:shadow-cyan-500/10',
                            'badgeBg' => 'bg-cyan-100',
                            'badgeText' => 'text-cyan-700',
                            'titleColor' => 'text-cyan-700/90',
                        ],
                        [
                            'border' => 'border-emerald-100',
                            'bg' => 'from-emerald-50/80 to-white',
                            'shadow' => 'hover:shadow-emerald-500/10',
                            'badgeBg' => 'bg-emerald-100',
                            'badgeText' => 'text-emerald-700',
                            'titleColor' => 'text-emerald-700/90',
                        ],
                        [
                            'border' => 'border-amber-200',
                            'bg' => 'from-amber-50 to-white',
                            'shadow' => 'hover:shadow-amber-500/10',
                            'badgeBg' => 'bg-amber-100',
                            'badgeText' => 'text-amber-700',
                            'titleColor' => 'text-amber-700/90',
                        ],
                        [
                            'border' => 'border-rose-100',
                            'bg' => 'from-rose-50/80 to-white',
                            'shadow' => 'hover:shadow-rose-500/10',
                            'badgeBg' => 'bg-rose-100',
                            'badgeText' => 'text-rose-700',
                            'titleColor' => 'text-rose-700/90',
                        ],
                        [
                            'border' => 'border-lime-100',
                            'bg' => 'from-lime-50/80 to-white',
                            'shadow' => 'hover:shadow-lime-500/10',
                            'badgeBg' => 'bg-lime-100',
                            'badgeText' => 'text-lime-700',
                            'titleColor' => 'text-lime-700/90',
                        ],
                        [
                            'border' => 'border-fuchsia-100',
                            'bg' => 'from-fuchsia-50/80 to-white',
                            'shadow' => 'hover:shadow-fuchsia-500/10',
                            'badgeBg' => 'bg-fuchsia-100',
                            'badgeText' => 'text-fuchsia-700',
                            'titleColor' => 'text-fuchsia-700/90',
                        ],
                    ];
                @endphp
                @foreach($requirementCards as $index => $card)
                    @php $palette = $requirementPalettes[$index % count($requirementPalettes)]; @endphp
                    <article class="group relative rounded-[2rem] border {{ $palette['border'] }} bg-gradient-to-b {{ $palette['bg'] }} p-6 transition-all duration-300 hover:shadow-lg {{ $palette['shadow'] }} hover:-translate-y-1">
                        <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-xl {{ $palette['badgeBg'] }} {{ $palette['badgeText'] }} group-hover:scale-110 transition-transform">
                            <span class="font-black">{{ $index + 1 }}</span>
                        </div>
                        <h3 class="text-xs font-bold uppercase tracking-wider {{ $palette['titleColor'] }} mb-2">{{ $card['title'] }}</h3>
                        <p class="text-sm leading-7 text-slate-600">{{ $card['body'] }}</p>
                    </article>
                @endforeach
            </div>

            @if($featuredApplication->support_letter_info)
                <div class="mt-6 rounded-[1.5rem] bg-amber-50 p-6 border border-amber-100 flex gap-4">
                    <div class="shrink-0 text-amber-500">
                         <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-amber-700/70">Wajib tau tentang Surat Dukungan</div>
                        <p class="mt-2 text-sm leading-7 text-amber-900/80">{{ $featuredApplication->support_letter_info }}</p>
                    </div>
                </div>
            @endif
        </section>

        <!-- Colorful Steps Section -->
           <section id="alur-pendaftaran" data-whv-section="application_roadmap" class="mt-8 rounded-[2.25rem] bg-white p-6 shadow-sm ring-1 ring-emerald-100 sm:p-10 relative overflow-hidden">
               <div class="absolute right-0 top-0 h-40 w-40 bg-gradient-to-bl from-emerald-100 to-transparent rounded-bl-[4rem]"></div>
             
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 relative">Application Roadmap</p>
            <h2 class="mt-2 text-3xl font-black text-slate-900 relative">Alur Pendaftaran Resmi</h2>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-5 relative">
                <!-- Connected Line (Desktop) -->
                <div class="hidden xl:block absolute top-8 left-0 right-0 h-0.5 bg-emerald-100 mx-16"></div>

                @foreach($applicationSteps as $index => $step)
                    <article class="relative rounded-[1.8rem] bg-white p-6 shadow-sm ring-1 ring-emerald-100 transition-all duration-300 hover:ring-emerald-300 hover:shadow-md hover:-translate-y-1 z-10">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-cyan-500 text-lg font-black text-white shadow-lg shadow-emerald-500/20">
                            {{ $index + 1 }}
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 mb-2">Langkah {{ $index + 1 }}</h3>
                        <p class="text-sm leading-6 text-slate-600">{{ $step }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section data-whv-section="benefits_costs" class="mt-8 grid gap-6 2xl:grid-cols-[0.95fr_1.05fr]">
            <!-- Keuntungan -->
            <div class="rounded-[2.25rem] bg-amber-50 p-8 shadow-sm ring-1 ring-amber-100">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-700/80">Benefits</p>
                <h2 class="mt-2 text-2xl font-black text-slate-900">Keuntungan Program</h2>

                <div class="mt-6 space-y-4">
                    @foreach($benefitCards as $card)
                            <article class="flex gap-4 rounded-[1.5rem] bg-white p-5 shadow-sm ring-1 ring-cyan-100/60">
                                <div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <div class="text-sm font-black text-slate-900">{{ $card['title'] }}</div>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ $card['body'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- Estimasi Biaya -->
            <div class="rounded-[2.25rem] bg-white p-8 shadow-sm ring-1 ring-cyan-100">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Total Costs</p>
                <h2 class="mt-2 text-2xl font-black text-slate-900">Estimasi Biaya Awal</h2>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach($costCards as $card)
                        <article class="rounded-[1.5rem] bg-white p-5 ring-1 ring-cyan-100 transition hover:bg-cyan-50/60 hover:shadow-sm hover:ring-cyan-200">
                            <div class="text-sm font-black text-slate-900">{{ $card['title'] }}</div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $card['body'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section data-whv-section="faq" class="mt-8 rounded-[2.25rem] bg-white p-8 shadow-sm ring-1 ring-emerald-100">
            <div class="text-center mb-10">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Frequently Asked Questions</p>
                <h2 class="mt-2 text-3xl font-black text-slate-900">Pertanyaan Populer</h2>
            </div>
            
            <div class="grid gap-6 md:grid-cols-2">
                 @foreach($faqItems as $faq)
                    <details class="group rounded-[1.8rem] border border-cyan-100 bg-white/95 p-6 transition hover:bg-cyan-50/40 hover:shadow-md hover:border-cyan-200 open:border-cyan-300 open:bg-cyan-50/40">
                        <summary class="flex cursor-pointer list-none items-start justify-between gap-4 text-sm font-black text-slate-900">
                            <span class="flex items-start gap-2">
                                <span class="text-lg leading-none text-slate-300 select-none">Q.</span>
                                <span>{{ $faq['question'] }}</span>
                            </span>
                            <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-cyan-100 text-cyan-700 transition group-open:rotate-45 group-open:bg-cyan-200">+</span>
                        </summary>
                        <p class="mt-4 ml-1 border-l-2 border-cyan-200 pl-6 text-sm leading-7 text-slate-600">{{ $faq['answer'] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        <!-- CTA Footer -->
           <section data-whv-section="final_cta" class="mt-8 rounded-[2.5rem] p-8 text-center text-white shadow-2xl shadow-cyan-900/20 ring-1 ring-cyan-200/30 sm:p-12 relative overflow-hidden" style="background-image: url('{{ asset('images/whv/footerwhv.jpg') }}'); background-size: cover; background-position: center; background-color: #1f2937;">
               <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950 to-slate-950"></div>
             <div class="relative">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-200" style="text-shadow: 0 2px 8px rgba(0,0,0,0.8);">Ready to Start?</p>
                <h2 class="mt-3 text-3xl font-black" style="text-shadow: 0 3px 12px rgba(0,0,0,0.9);">Ready to Start Your WHV Journey?</h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-white" style="text-shadow: 0 2px 8px rgba(0,0,0,0.9);">Mulai dari tes bahasa Inggris, rapikan dokumen, lalu masuk ke jalur aplikasi resmi dengan persiapan yang matang.</p>

                <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <a href="{{ route('guest.free-tests') }}" data-whv-cta="footer_free_test" data-whv-preserve-attribution="true" class="inline-flex min-w-[200px] items-center justify-center rounded-2xl bg-amber-400 px-8 py-4 text-sm font-black text-slate-900 shadow-lg shadow-amber-400/40 transition hover:bg-amber-500 hover:-translate-y-1">
                        <span data-whv-copy-key="footer_test">Take Free English Test</span>
                    </a>
                    <a href="{{ route('student.register') }}" data-whv-cta="footer_register_now" data-whv-preserve-attribution="true" class="inline-flex min-w-[200px] items-center justify-center rounded-2xl bg-blue-600 px-8 py-4 text-sm font-black text-white shadow-lg shadow-blue-600/40 transition hover:bg-blue-700 hover:-translate-y-1">
                        <span data-whv-copy-key="footer_register">Register Now</span>
                    </a>
                    @if($featuredApplication->url)
                        <a href="{{ $featuredApplication->url }}" data-whv-cta="footer_official_website" target="_blank" rel="noopener noreferrer" class="inline-flex min-w-[200px] items-center justify-center rounded-2xl border border-emerald-300 bg-emerald-400 px-8 py-4 text-sm font-black text-slate-900 shadow-lg shadow-emerald-400/40 transition hover:bg-emerald-500 hover:-translate-y-1">
                            Official Website
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <div id="whv-mobile-progress" class="fixed inset-x-4 bottom-[4.9rem] z-30 rounded-2xl border border-slate-200 bg-white/92 px-4 py-3 shadow-lg shadow-slate-900/10 backdrop-blur transition-transform duration-300 md:hidden">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Progress</p>
                    <p id="whv-mobile-progress-label" class="mt-1 text-xs font-bold text-slate-900">1 of 8 sections explored</p>
                </div>
                <a href="#alur-pendaftaran" data-whv-cta="mobile_progress_view_steps" class="shrink-0 rounded-full bg-cyan-50 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.08em] text-cyan-700 ring-1 ring-cyan-200">
                    Steps
                </a>
            </div>
            <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-slate-100">
                <div id="whv-mobile-progress-bar" class="h-full rounded-full bg-gradient-to-r from-cyan-500 to-emerald-500 transition-all duration-500" style="width: 12.5%"></div>
            </div>
        </div>

        <div id="whv-mobile-sticky-cta" class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-200 bg-white/95 p-3 shadow-[0_-8px_24px_rgba(15,23,42,0.12)] backdrop-blur transition-transform duration-300 md:hidden">
            <div class="mx-auto flex max-w-md gap-2">
                <a href="{{ route('guest.free-tests') }}" data-whv-cta="sticky_free_test" data-whv-preserve-attribution="true" class="flex-1 rounded-xl bg-[#FF8C42] px-4 py-3 text-center text-xs font-black uppercase tracking-[0.08em] text-white">
                    <span data-whv-copy-key="sticky_test">Free Test</span>
                </a>
                <a href="{{ route('student.register') }}" data-whv-cta="sticky_register" data-whv-preserve-attribution="true" class="flex-1 rounded-xl bg-[#0B1F3A] px-4 py-3 text-center text-xs font-black uppercase tracking-[0.08em] text-white">
                    <span data-whv-copy-key="sticky_register">Register</span>
                </a>
            </div>
        </div>

        <div class="fixed bottom-6 right-6 z-30 hidden w-72 rounded-[1.5rem] border border-slate-200 bg-white/92 p-4 shadow-xl shadow-slate-900/10 backdrop-blur md:block">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Journey Progress</p>
                    <p id="whv-progress-label" class="mt-1 text-sm font-bold text-slate-900">1 of 8 sections explored</p>
                </div>
                <a href="#alur-pendaftaran" data-whv-cta="progress_widget_view_steps" class="rounded-full bg-cyan-50 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-cyan-700 ring-1 ring-cyan-200 transition hover:bg-cyan-100">
                    View Steps
                </a>
            </div>
            <div class="mt-4 h-2 overflow-hidden rounded-full bg-slate-100">
                <div id="whv-progress-bar" class="h-full rounded-full bg-gradient-to-r from-cyan-500 to-emerald-500 transition-all duration-500" style="width: 12.5%"></div>
            </div>
            <p id="whv-progress-note" class="mt-3 text-xs leading-5 text-slate-500">Buka lebih banyak section untuk melihat readiness journey sebelum masuk ke tahap aplikasi.</p>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var attributionStorageKey = 'whv_attribution_context';
    var genericAttributionStorageKey = 'marketing_attribution_context';
    var variantStorageKey = 'whv_cta_copy_variant';
    var lastCtaStorageKey = 'marketing_last_cta';
    var urlParams = new URLSearchParams(window.location.search);
    var storedAttribution = {};

    try {
        storedAttribution = JSON.parse(
            window.sessionStorage.getItem(attributionStorageKey)
            || window.localStorage.getItem(attributionStorageKey)
            || window.sessionStorage.getItem(genericAttributionStorageKey)
            || window.localStorage.getItem(genericAttributionStorageKey)
            || '{}'
        );
    } catch (error) {
        storedAttribution = {};
    }

    var variantOptions = ['control', 'fast_track'];
    var storedVariant = urlParams.get('whv_variant')
        || storedAttribution.acquisition_variant
        || window.sessionStorage.getItem(variantStorageKey)
        || window.localStorage.getItem(variantStorageKey);

    if (variantOptions.indexOf(storedVariant) === -1) {
        storedVariant = Math.random() < 0.5 ? 'control' : 'fast_track';
    }

    try {
        window.sessionStorage.setItem(variantStorageKey, storedVariant);
        window.localStorage.setItem(variantStorageKey, storedVariant);
    } catch (error) {
        // Ignore storage errors.
    }

    var ctaCopyMap = {
        control: {
            hero_primary: 'Start Application',
            hero_secondary: 'Check Eligibility',
            snapshot_eligibility: 'Cek Kelayakan Saya',
            snapshot_register: 'Register Now',
            footer_test: 'Take Free English Test',
            footer_register: 'Register Now',
            sticky_test: 'Free Test',
            sticky_register: 'Register'
        },
        fast_track: {
            hero_primary: 'See My WHV Plan',
            hero_secondary: 'Check My WHV Readiness',
            snapshot_eligibility: 'Check My WHV Readiness',
            snapshot_register: 'Reserve My Spot',
            footer_test: 'Check My WHV Score',
            footer_register: 'Secure My WHV Plan',
            sticky_test: 'Readiness',
            sticky_register: 'Join Now'
        }
    };

    document.querySelectorAll('[data-whv-copy-key]').forEach(function (element) {
        var copyKey = element.getAttribute('data-whv-copy-key');
        if (copyKey && ctaCopyMap[storedVariant] && ctaCopyMap[storedVariant][copyKey]) {
            element.textContent = ctaCopyMap[storedVariant][copyKey];
        }
    });

    var trackingContext = {
        utm_source: urlParams.get('utm_source') || storedAttribution.utm_source || '',
        utm_medium: urlParams.get('utm_medium') || storedAttribution.utm_medium || '',
        utm_campaign: urlParams.get('utm_campaign') || storedAttribution.utm_campaign || '',
        utm_content: urlParams.get('utm_content') || storedAttribution.utm_content || '',
        utm_term: urlParams.get('utm_term') || storedAttribution.utm_term || '',
        referrer: document.referrer || storedAttribution.referrer || '',
        landing_path: window.location.pathname || '',
        acquisition_variant: storedVariant,
        acquisition_last_cta: urlParams.get('acquisition_last_cta') || storedAttribution.acquisition_last_cta || window.sessionStorage.getItem(lastCtaStorageKey) || window.localStorage.getItem(lastCtaStorageKey) || ''
    };

    function persistAttributionContext() {
        try {
            var serializedAttribution = JSON.stringify(trackingContext);
            window.sessionStorage.setItem(attributionStorageKey, serializedAttribution);
            window.localStorage.setItem(attributionStorageKey, serializedAttribution);
            window.sessionStorage.setItem(genericAttributionStorageKey, serializedAttribution);
            window.localStorage.setItem(genericAttributionStorageKey, serializedAttribution);
        } catch (error) {
            // Ignore storage failures in restricted contexts.
        }
    }

    persistAttributionContext();

    function dispatchWhvEvent(eventName, eventData) {
        var payload = Object.assign({
            event: eventName,
            page: 'whv_applications'
        }, trackingContext, eventData || {});

        if (typeof window.gtag === 'function') {
            window.gtag('event', eventName, payload);
        }

        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(payload);
    }

    var maxScrollDepth = 0;
    var sectionElements = document.querySelectorAll('[data-whv-section]');
    var seenSections = new Set();
    var viewedSections = new Set();
    var totalSections = sectionElements.length || 1;
    var progressBar = document.getElementById('whv-progress-bar');
    var progressLabel = document.getElementById('whv-progress-label');
    var progressNote = document.getElementById('whv-progress-note');
    var mobileProgressBar = document.getElementById('whv-mobile-progress-bar');
    var mobileProgressLabel = document.getElementById('whv-mobile-progress-label');

    function updateProgressWidget() {
        var viewedCount = Math.max(viewedSections.size, 1);
        var progressPercent = Math.max(Math.round((viewedCount / totalSections) * 100), 12);

        if (progressBar && progressLabel && progressNote) {
            progressBar.style.width = progressPercent + '%';
            progressLabel.textContent = viewedCount + ' of ' + totalSections + ' sections explored';

            if (viewedCount >= totalSections) {
                progressNote.textContent = 'Semua section utama sudah dilihat. User ini sudah dekat ke keputusan apply.';
            } else if (viewedCount >= Math.ceil(totalSections * 0.75)) {
                progressNote.textContent = 'Minat terlihat kuat. Dorongan ke CTA akhir biasanya paling efektif di fase ini.';
            } else if (viewedCount >= Math.ceil(totalSections * 0.5)) {
                progressNote.textContent = 'Interest sudah terbentuk. Bantu user bergerak ke alur aplikasi atau free test.';
            } else {
                progressNote.textContent = 'Buka lebih banyak section untuk melihat readiness journey sebelum masuk ke tahap aplikasi.';
            }
        }

        if (mobileProgressBar && mobileProgressLabel) {
            mobileProgressBar.style.width = progressPercent + '%';
            mobileProgressLabel.textContent = viewedCount + ' of ' + totalSections + ' sections explored';
        }
    }

    updateProgressWidget();

    if ('IntersectionObserver' in window && sectionElements.length > 0) {
        var sectionObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                var sectionName = entry.target.getAttribute('data-whv-section') || 'unknown_section';
                var seenKey = 'seen:' + sectionName;
                if (seenSections.has(seenKey)) {
                    return;
                }

                seenSections.add(seenKey);
                viewedSections.add(sectionName);
                updateProgressWidget();
                dispatchWhvEvent('whv_section_view', {
                    section_name: sectionName,
                    viewed_sections: viewedSections.size,
                    total_sections: totalSections,
                    visible_ratio: Number(entry.intersectionRatio.toFixed(2))
                });
            });
        }, {
            threshold: [0.45, 0.75]
        });

        sectionElements.forEach(function (section) {
            sectionObserver.observe(section);
        });
    }

    var attributionLinks = document.querySelectorAll('[data-whv-preserve-attribution="true"]');

    function syncAttributionLinks(lastCtaName) {
        attributionLinks.forEach(function (link) {
            var rawHref = link.getAttribute('href');
            if (!rawHref || rawHref.charAt(0) === '#') {
                return;
            }

            try {
                var linkUrl = new URL(rawHref, window.location.origin);
                Object.keys(trackingContext).forEach(function (key) {
                    if (!trackingContext[key] || key === 'referrer' || key === 'landing_path') {
                        return;
                    }

                    if (!linkUrl.searchParams.get(key)) {
                        linkUrl.searchParams.set(key, trackingContext[key]);
                    }
                });

                linkUrl.searchParams.set('whv_source_page', 'whv_applications');
                linkUrl.searchParams.set('whv_variant', trackingContext.acquisition_variant);
                linkUrl.searchParams.set('acquisition_last_cta', lastCtaName || link.getAttribute('data-whv-cta') || trackingContext.acquisition_last_cta || '');
                link.setAttribute('href', linkUrl.toString());
            } catch (error) {
                // Ignore malformed href values.
            }
        });
    }

    syncAttributionLinks(trackingContext.acquisition_last_cta);

    var ctaElements = document.querySelectorAll('[data-whv-cta]');
    ctaElements.forEach(function (element) {
        element.addEventListener('click', function () {
            var ctaName = element.getAttribute('data-whv-cta') || 'unknown_cta';
            var engagementRatio = totalSections > 0 ? (viewedSections.size / totalSections) : 0;

            trackingContext.acquisition_last_cta = ctaName;

            try {
                window.sessionStorage.setItem(lastCtaStorageKey, ctaName);
                window.localStorage.setItem(lastCtaStorageKey, ctaName);
            } catch (error) {
                // Ignore storage failures.
            }

            persistAttributionContext();
            syncAttributionLinks(ctaName);

            dispatchWhvEvent('whv_cta_click', {
                cta_name: ctaName,
                viewed_sections: viewedSections.size,
                total_sections: totalSections,
                max_scroll_depth: maxScrollDepth
            });

            if (engagementRatio >= 0.75 || maxScrollDepth >= 75) {
                dispatchWhvEvent('whv_high_intent_cta_click', {
                    cta_name: ctaName,
                    viewed_sections: viewedSections.size,
                    total_sections: totalSections,
                    max_scroll_depth: maxScrollDepth,
                    engagement_ratio: Number(engagementRatio.toFixed(2))
                });
            }
        });
    });

    var faqDetails = document.querySelectorAll('details.group');
    faqDetails.forEach(function (detailsElement, index) {
        detailsElement.addEventListener('toggle', function () {
            if (!detailsElement.open) {
                return;
            }

            var questionElement = detailsElement.querySelector('summary span span');
            dispatchWhvEvent('whv_faq_open', {
                faq_index: index + 1,
                faq_question: questionElement ? questionElement.textContent.trim() : 'unknown_question'
            });
        });
    });

    var depthMilestones = [25, 50, 75, 90];
    var firedDepth = new Set();
    window.addEventListener('scroll', function () {
        var doc = document.documentElement;
        var maxScroll = doc.scrollHeight - window.innerHeight;
        if (maxScroll <= 0) {
            return;
        }

        var scrolledPercent = Math.round((window.scrollY / maxScroll) * 100);
        if (scrolledPercent > maxScrollDepth) {
            maxScrollDepth = scrolledPercent;
        }

        depthMilestones.forEach(function (milestone) {
            if (scrolledPercent >= milestone && !firedDepth.has(milestone)) {
                firedDepth.add(milestone);
                dispatchWhvEvent('whv_scroll_depth', {
                    depth_percent: milestone,
                    viewed_sections: viewedSections.size,
                    total_sections: totalSections
                });
            }
        });
    }, { passive: true });

    var stickyBar = document.getElementById('whv-mobile-sticky-cta');
    var mobileProgress = document.getElementById('whv-mobile-progress');
    if (stickyBar) {
        var lastScrollY = window.scrollY;
        var hiddenClass = 'translate-y-full';

        window.addEventListener('scroll', function () {
            var currentScrollY = window.scrollY;
            var isScrollingDown = currentScrollY > lastScrollY;
            var passedThreshold = currentScrollY > 120;

            if (isScrollingDown && passedThreshold) {
                stickyBar.classList.add(hiddenClass);
                if (mobileProgress) {
                    mobileProgress.classList.add(hiddenClass);
                }
            } else {
                stickyBar.classList.remove(hiddenClass);
                if (mobileProgress) {
                    mobileProgress.classList.remove(hiddenClass);
                }
            }

            lastScrollY = currentScrollY;
        }, { passive: true });
    }
});
</script>
@endpush
