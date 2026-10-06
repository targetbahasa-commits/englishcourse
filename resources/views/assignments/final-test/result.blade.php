<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Target Bahasa') }} - Final Test Result</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .word-correct { color: #059669; font-weight: 600; }
        .word-wrong { color: #dc2626; text-decoration: line-through; }
        .word-missing { color: #2563eb; font-weight: 700; text-decoration: underline; }
        .word-extra { color: #d97706; text-decoration: line-through; }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64">
            <div class="mx-auto max-w-5xl px-5 py-8 sm:px-8 lg:px-10">
                @if(session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-white px-4 py-3 text-sm font-semibold text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-6 rounded-xl border border-amber-200 bg-white px-4 py-3 text-sm font-semibold text-amber-700">
                        {{ session('warning') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                <a href="{{ route('final-test') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Final Test Center
                </a>

                @if(Auth::user()?->isAdmin())
                    <div class="mt-4 rounded-2xl border border-blue-500 bg-blue-600 p-4 sm:p-5 text-white shadow-md flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/15 text-white border border-white/25 font-bold text-lg">
                                👑
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-black uppercase tracking-widest text-blue-100">Akses Administrator</span>
                                    @if(!empty($result->evaluation_data['reviewed_by']))
                                        <span class="rounded-full bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 border border-white/30">
                                            Direview oleh {{ $result->evaluation_data['reviewed_by'] }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-sm font-bold text-white mt-0.5">Pengelolaan Evaluasi Hasil Ujian Ini</h3>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <a href="{{ route('admin.final-test-results.show', $result->id) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-white hover:bg-blue-50 px-3.5 py-2 text-xs font-black text-blue-700 shadow-sm transition">
                                <svg class="h-4 w-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Kelola / Edit Nilai &amp; Catatan
                            </a>
                            <form method="POST" action="{{ route('admin.final-test-results.re-evaluate', $result->id) }}" onsubmit="return confirm('Kalkulasi ulang evaluasi otomatis untuk ujian ini?');" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-blue-400 bg-blue-700 hover:bg-blue-800 px-3.5 py-2 text-xs font-bold text-white transition cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Hitung Ulang (Auto Re-Evaluate)
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="bg-blue-600 px-6 py-6 text-white">
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-100">Final Test Completed</p>
                        <h1 class="mt-2 text-3xl font-bold">{{ $result->test_label ?? 'Final Test' }}</h1>
                        <p class="mt-2 text-sm text-blue-100">Your result is ready. A PDF certificate is available below and has been sent to your email when the certificate template is active.</p>
                    </div>

                    <div class="grid gap-0 md:grid-cols-[0.75fr_1.25fr]">
                        <div class="border-b border-slate-200 p-6 md:border-b-0 md:border-r">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Score</p>
                            <p class="mt-3 text-6xl font-bold text-indigo-700">{{ is_numeric($result->score) ? number_format((float) $result->score, 1) : ($result->score ?? '-') }}</p>
                            <span class="mt-4 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-white px-3 py-1.5 text-sm font-semibold text-emerald-700">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                {{ ucfirst($result->status ?? 'completed') }}
                            </span>
                        </div>

                        <div class="grid gap-4 p-6 sm:grid-cols-2">
                            <div>
                                <p class="text-xs text-slate-500">Name</p>
                                <p class="mt-1 font-semibold text-slate-900">{{ $result->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Email</p>
                                <p class="mt-1 font-semibold text-slate-900">{{ $result->email ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Candidate ID</p>
                                <p class="mt-1 font-mono font-semibold text-slate-900">{{ $result->candidate_id ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Completed At</p>
                                <p class="mt-1 font-semibold text-slate-900">{{ optional($result->completed_at)->format('d M Y H:i') ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Email Status</p>
                                @php
                                    $emailStatus = $result->evaluation_data['certificate_email_status'] ?? 'pending';
                                    $emailLabel = match ($emailStatus) {
                                        'sent' => 'Sent',
                                        'failed' => 'Failed',
                                        'skipped' => 'Skipped',
                                        'queued' => 'Queued',
                                        default => 'Pending',
                                    };
                                    $emailClasses = match ($emailStatus) {
                                        'sent' => 'bg-white text-emerald-700 border-emerald-200',
                                        'failed' => 'bg-rose-100 text-rose-700 border-rose-200',
                                        'skipped' => 'bg-white text-amber-700 border-amber-200',
                                        'queued' => 'bg-white text-sky-700 border-sky-200',
                                        default => 'bg-white text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="mt-2 inline-flex items-center rounded-full border px-3 py-1 text-sm font-semibold {{ $emailClasses }}">{{ $emailLabel }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-slate-200 bg-white px-6 py-5 sm:flex-row sm:items-center">
                        @if(!Auth::user()->isAdmin() && (float) $result->score < 50)
                            <div class="flex flex-col gap-2 rounded-xl border border-rose-200 bg-rose-50 px-5 py-3">
                                <span class="text-sm font-semibold text-rose-700">Skor Anda ({{ $result->score }}) belum mencapai batas kelulusan (50). Ulangi Final Test untuk mendapatkan sertifikat.</span>
                                <a href="{{ route('final-test') }}" class="inline-flex w-fit items-center gap-2 rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700 transition">
                                    Ulangi Final Test
                                </a>
                            </div>
                        @elseif($certificateAvailable && !Auth::user()->isAdmin() && $result->certificate_downloads_count >= 3)
                            <span class="inline-flex h-11 items-center rounded-xl border border-rose-200 bg-white px-5 text-sm font-semibold text-rose-600">
                                Batas download sertifikat (3x) sudah tercapai
                            </span>
                        @elseif($certificateAvailable)
                            <div class="flex flex-col gap-1">
                            <div x-data="{
                                hasReviewed: localStorage.getItem('reviewed_google') === 'true',
                                showReviewModal: false,
                                googleReviewUrl: 'https://search.google.com/local/writereview?placeid=ChIJhTdCkI9deC4RQZJ4cWggS5o',
                                downloadUrl: '{{ route('final-test.certificate.download', $result) }}'
                            }">
                                <!-- Direct Download if already reviewed -->
                                <template x-if="hasReviewed">
                                    <a :href="downloadUrl" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Silahkan Download Certificate
                                    </a>
                                </template>
                                
                                <!-- Button to trigger review modal -->
                                <template x-if="!hasReviewed">
                                    <button type="button" @click="showReviewModal = true" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Certificate PDF
                                    </button>
                                </template>

                                <!-- Review Modal -->
                                <div x-show="showReviewModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <!-- Background overlay -->
                                    <div x-show="showReviewModal" 
                                         x-transition:enter="ease-out duration-300" 
                                         x-transition:enter-start="opacity-0" 
                                         x-transition:enter-end="opacity-100" 
                                         x-transition:leave="ease-in duration-200" 
                                         x-transition:leave-start="opacity-100" 
                                         x-transition:leave-end="opacity-0" 
                                         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" 
                                         aria-hidden="true"></div>

                                    <!-- Modal panel -->
                                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                            <div x-show="showReviewModal" 
                                                 @click.away="showReviewModal = false"
                                                 x-transition:enter="ease-out duration-300" 
                                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                                 x-transition:leave="ease-in duration-200" 
                                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                                 class="relative transform overflow-hidden rounded-2xl bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                                
                                                <div>
                                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white">
                                                        <svg class="h-8 w-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-4 text-center sm:mt-5">
                                                        <h3 class="text-xl font-bold leading-6 text-slate-900" id="modal-title">Berikan Review Google Maps</h3>
                                                        <div class="mt-3">
                                                            <p class="text-sm text-slate-500">
                                                                Selamat! Anda telah menyelesaikan Final Test. Sebelum mendownload sertifikat, luangkan waktu sebentar untuk memberikan <strong class="text-slate-700">review bintang 5</strong> di Google Maps kami.<br><br>Sertifikat Anda akan otomatis dapat di-download setelah mengklik tombol di bawah ini.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-6 sm:mt-8 sm:flex sm:flex-col sm:gap-3">
                                                    <a :href="googleReviewUrl" 
                                                       target="_blank" 
                                                       @click="
                                                            localStorage.setItem('reviewed_google', 'true');
                                                            hasReviewed = true;
                                                            setTimeout(() => { showReviewModal = false; }, 1500);
                                                       "
                                                       class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-3 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                                         Berikan Ulasan Bintang 5 di Google
                                                    </a>
                                                    <button type="button" @click="showReviewModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-3.5 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-white sm:mt-0">
                                                        Nanti saja
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!Auth::user()->isAdmin())
                                <span class="text-xs text-slate-400">Sisa kuota download: {{ max(0, 3 - $result->certificate_downloads_count) }}x</span>
                            @endif
                            </div>
                        @else
                            <span class="inline-flex h-11 items-center rounded-xl border border-amber-200 bg-white px-5 text-sm font-semibold text-amber-700">
                                Certificate template is not active yet.
                            </span>
                        @endif
                        <button onclick="window.print()" class="inline-flex h-11 items-center justify-center rounded-xl bg-white px-5 text-sm font-semibold text-slate-700 ring-1 ring-slate-200 transition hover:bg-white cursor-pointer">
                            Print Result
                        </button>
                    </div>
                </section>

                @if(!empty($result->answers_data))
                    @php
                        $data = $result->answers_data;
                        $criteria = $data['criteria'] ?? null;
                        $modules = $data['module_diagnostics'] ?? [];
                        $feedback = $data['feedback'] ?? null;
                    @endphp

                    <section class="mt-8 space-y-6">
                        <!-- Section Header -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-200 pb-4">
                            <div>
                                <h2 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                                    <span>Laporan Hasil Evaluasi Komprehensif</span>
                                    @if($data['passed'] ?? ($result->score >= 70))
                                        <span class="rounded-full bg-emerald-100 text-emerald-800 text-xs px-3 py-0.5 font-bold border border-emerald-200">LULUS (Passed)</span>
                                    @else
                                        <span class="rounded-full bg-amber-100 text-amber-800 text-xs px-3 py-0.5 font-bold border border-amber-200">Perlu Penguatan</span>
                                    @endif
                                </h2>
                                <p class="text-xs text-slate-500 mt-1">
                                    Hasil asesmen kelulusan Grammar for Writing (Summary 10 Pertemuan) berdasarkan rubrik standar akademik internasional.
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if(!empty($data['cefr_level']))
                                    <span class="rounded-xl bg-indigo-50 border border-indigo-200 px-3 py-1.5 text-xs font-black text-indigo-700 font-mono">
                                        CEFR: {{ $data['cefr_level'] }}
                                    </span>
                                @endif
                                @if(!empty($data['ielts_equivalent']))
                                    <span class="rounded-xl bg-blue-50 border border-blue-200 px-3 py-1.5 text-xs font-black text-blue-700 font-mono">
                                        {{ $data['ielts_equivalent'] }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 3 Core Criteria Cards -->
                        @if(!empty($criteria))
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Criterion 1: Grammar Mastery -->
                                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Kriteria 1 (Bobot 40%)</span>
                                            <span class="rounded-md bg-blue-50 text-blue-700 px-2 py-0.5 text-xs font-black font-mono">
                                                {{ $criteria['grammar_complexity']['score'] ?? 0 }} / 40
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900 mt-1.5">Grammar & Structural Complexity</h3>
                                        <p class="text-xs text-slate-500 mt-1">Capaian variasi 10 struktur tata bahasa (Inversion, Clauses, Gerund, dsb).</p>
                                    </div>
                                    <div class="mt-4">
                                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $criteria['grammar_complexity']['percentage'] ?? 0 }}%;"></div>
                                        </div>
                                        <div class="mt-1.5 flex justify-between text-[11px] text-slate-400 font-medium">
                                            <span>Penguasaan Modul</span>
                                            <span class="font-bold text-slate-700">{{ $criteria['grammar_complexity']['percentage'] ?? 0 }}%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Criterion 2: Lexical Resource -->
                                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Kriteria 2 (Bobot 30%)</span>
                                            <span class="rounded-md bg-amber-50 text-amber-700 px-2 py-0.5 text-xs font-black font-mono">
                                                {{ $criteria['lexical_resource']['score'] ?? 0 }} / 30
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900 mt-1.5">Lexical Resource & Academic Words</h3>
                                        <p class="text-xs text-slate-500 mt-1">Kecocokan kosakata akademik, istilah formal, dan ketepatan diksi.</p>
                                    </div>
                                    <div class="mt-4">
                                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-amber-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $criteria['lexical_resource']['percentage'] ?? 0 }}%;"></div>
                                        </div>
                                        <div class="mt-1.5 flex justify-between text-[11px] text-slate-400 font-medium">
                                            <span>Cakupan Kosakata</span>
                                            <span class="font-bold text-slate-700">{{ $criteria['lexical_resource']['percentage'] ?? 0 }}%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Criterion 3: Translation Accuracy -->
                                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Kriteria 3 (Bobot 30%)</span>
                                            <span class="rounded-md bg-emerald-50 text-emerald-700 px-2 py-0.5 text-xs font-black font-mono">
                                                {{ $criteria['translation_accuracy']['score'] ?? 0 }} / 30
                                            </span>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900 mt-1.5">Translation Fidelity & Completeness</h3>
                                        <p class="text-xs text-slate-500 mt-1">Keutuhan pesan, kelengkapan klausa, dan kohesi antar kalimat.</p>
                                    </div>
                                    <div class="mt-4">
                                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-emerald-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $criteria['translation_accuracy']['percentage'] ?? 0 }}%;"></div>
                                        </div>
                                        <div class="mt-1.5 flex justify-between text-[11px] text-slate-400 font-medium">
                                            <span>Akurasi Makna</span>
                                            <span class="font-bold text-slate-700">{{ $criteria['translation_accuracy']['percentage'] ?? 0 }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Qualitative Examiner's Summary & Feedback -->
                        @if(!empty($feedback))
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-6 space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-white font-black text-sm">
                                        ✍️
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">Ulasan & Rekomendasi Evaluator</h3>
                                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $feedback['overview'] ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-200/80">
                                    <!-- Strengths -->
                                    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-2xs">
                                        <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-700 flex items-center gap-1.5 mb-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Poin Kekuatan Terjemahan (Key Strengths)
                                        </h4>
                                        <ul class="space-y-1.5 text-xs text-slate-700">
                                            @foreach($feedback['strengths'] ?? [] as $st)
                                                <li class="flex items-start gap-2">
                                                    <span class="text-emerald-500 font-bold">✓</span>
                                                    <span>{{ $st }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <!-- Priority Improvements -->
                                    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-2xs">
                                        <h4 class="text-xs font-bold uppercase tracking-wider text-amber-700 flex items-center gap-1.5 mb-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            Fokus Perbaikan (Actionable Improvements)
                                        </h4>
                                        <ul class="space-y-1.5 text-xs text-slate-700">
                                            @foreach($feedback['improvements'] ?? [] as $imp)
                                                <li class="flex items-start gap-2">
                                                    <span class="text-amber-500 font-bold">⚠️</span>
                                                    <span>{{ $imp }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 10-Module Diagnostic Matrix -->
                        @if(!empty($modules))
                            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-100 pb-3">
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                            <span>Peta Capaian 10 Modul Grammar Fast-Track</span>
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-0.5">Pemeriksaan otomatis deteksi penerapan konsep grammar per modul dalam terjemahan Anda.</p>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs font-bold">
                                        <span class="rounded-md bg-emerald-50 text-emerald-700 px-2.5 py-1 border border-emerald-200">
                                            {{ $data['mastered_modules_count'] ?? 0 }} Dikuasai
                                        </span>
                                        <span class="rounded-md bg-amber-50 text-amber-700 px-2.5 py-1 border border-amber-200">
                                            {{ $data['review_modules_count'] ?? 0 }} Perlu Penguatan
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                                    @foreach($modules as $mNum => $m)
                                        <div class="rounded-xl border p-3 flex flex-col justify-between transition hover:shadow-2xs {{ $m['matched'] ? 'border-emerald-200 bg-emerald-50/40' : 'border-slate-200 bg-slate-50/60' }}">
                                            <div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[10px] font-mono font-bold uppercase {{ $m['matched'] ? 'text-emerald-700' : 'text-slate-400' }}">{{ $m['tag'] ?? 'M' . $mNum }}</span>
                                                    @if($m['matched'])
                                                        <span class="rounded-full bg-emerald-600 text-white text-[9px] font-bold px-1.5 py-0.2">Kuasai ✓</span>
                                                    @else
                                                        <span class="rounded-full bg-slate-200 text-slate-600 text-[9px] font-bold px-1.5 py-0.2">Review</span>
                                                    @endif
                                                </div>
                                                <h4 class="text-xs font-bold text-slate-900 mt-1.5 leading-snug">{{ $m['name'] }}</h4>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $m['description'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Word Diff Legend -->
                        <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-600 bg-slate-50 p-3.5 rounded-xl border border-slate-200">
                            <span class="text-slate-400 uppercase font-bold text-[10px] tracking-wider">Keterangan Analisis Kata:</span>
                            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Kata Cocok/Benar</span>
                            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-blue-600"></span> Kata Kurang/Harus Ada</span>
                            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span> Kata Salah</span>
                            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span> Kata Berlebih</span>
                        </div>

                        <!-- Whole Essay Translation Diff Card -->
                        @if(!empty($data['formatted_answer']))
                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <div class="bg-slate-900 px-6 py-4 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div>
                                        <span class="rounded-md bg-blue-500/20 text-blue-300 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider border border-blue-400/30">
                                            Evaluasi Hasil Terjemahan Utuh (Whole Passage Word Diff)
                                        </span>
                                        <h3 class="text-base font-bold text-white mt-1">Penerjemahan Artikel Akademik 3 Paragraf</h3>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-xs text-slate-400">Total Nilai Final Test</p>
                                        <p class="text-2xl font-black text-emerald-400">{{ $data['score'] ?? $result->score }} <span class="text-xs font-normal text-slate-400">/ 100</span></p>
                                    </div>
                                </div>

                                <div class="p-6 space-y-6">
                                    <!-- Word Diff Output -->
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Hasil Analisis Kata pada Terjemahan Anda (Word-Level Match Diff)</p>
                                        <div class="rounded-2xl bg-white p-5 text-sm sm:text-base text-slate-900 leading-relaxed border border-slate-200 shadow-inner font-sans whitespace-pre-line">
                                            {!! $data['formatted_answer'] !!}
                                        </div>
                                    </div>

                                    <!-- Full Model Answer -->
                                    @if(!empty($data['full_text_en']))
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-2 flex items-center gap-1.5">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Kunci Jawaban Model Akademik Utuh (Full Academic Model Answer)
                                            </p>
                                            <div class="rounded-2xl bg-emerald-50/60 p-5 text-sm sm:text-base text-emerald-950 leading-relaxed border border-emerald-100 font-medium whitespace-pre-line">
                                                {{ $data['full_text_en'] }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Paragraph-by-Paragraph Breakdown Reference -->
                        @if(!empty($data['paragraphs']))
                            <div class="space-y-4">
                                <h3 class="text-base font-bold text-slate-900">Analisis Mendalam Tiap Paragraf</h3>
                                <div class="grid grid-cols-1 gap-5">
                                    @foreach($data['paragraphs'] as $pNum => $pData)
                                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xs p-6 space-y-5">
                                            <!-- Paragraph Header -->
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-100 pb-4">
                                                <div>
                                                    <span class="rounded-md bg-blue-100 text-blue-800 px-2.5 py-1 text-xs font-bold">
                                                        Paragraf {{ $pNum }} dari 3
                                                    </span>
                                                    <h4 class="text-base font-bold text-slate-900 mt-1.5">{{ $pData['title'] ?? 'Paragraf ' . $pNum }}</h4>
                                                    @if(!empty($pData['focus']))
                                                        <p class="text-xs text-slate-500 mt-0.5"><strong class="text-blue-700">Fokus Grammar:</strong> {{ $pData['focus'] }}</p>
                                                    @endif
                                                </div>
                                                @if(isset($pData['score']))
                                                    <div class="text-right shrink-0 bg-emerald-50 px-4 py-2 rounded-xl border border-emerald-100">
                                                        <span class="text-xs text-slate-500">Skor Paragraf:</span>
                                                        <span class="text-lg font-black text-emerald-700 ml-1.5">{{ $pData['score'] }} / {{ $pData['max_score'] ?? 33 }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Grammar Target Checklist for this paragraph -->
                                            @if(!empty($pData['grammar_targets']))
                                                <div class="rounded-xl bg-slate-50 p-4 border border-slate-200">
                                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-2 flex items-center justify-between">
                                                        <span>Target Struktur Grammar Paragraf Ini:</span>
                                                        <span class="text-[11px] font-normal text-slate-500">{{ $pData['grammar_summary'] ?? '' }}</span>
                                                    </p>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                        @foreach($pData['grammar_targets'] as $tgt)
                                                            <div class="rounded-lg p-2.5 text-xs flex items-start gap-2 border {{ $tgt['matched'] ? 'bg-white border-emerald-200 text-emerald-900' : 'bg-white border-slate-200 text-slate-600' }}">
                                                                <span class="text-sm shrink-0 {{ $tgt['matched'] ? 'text-emerald-600 font-bold' : 'text-slate-300' }}">{{ $tgt['matched'] ? '✓' : '✗' }}</span>
                                                                <div>
                                                                    <p class="font-bold {{ $tgt['matched'] ? 'text-emerald-800' : 'text-slate-700' }}">{{ $tgt['name'] }}</p>
                                                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $tgt['hint'] }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Original Indonesian -->
                                            <div>
                                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Naskah Asli Bahasa Indonesia</p>
                                                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100 font-medium">{{ $pData['text_id'] ?? '' }}</p>
                                            </div>

                                            <!-- Word-Level Diff -->
                                            @if(!empty($pData['formatted_answer']))
                                                <div>
                                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Hasil Analisis Terjemahan Siswa (Word Match Diff)</p>
                                                    <div class="rounded-xl bg-white p-4 text-xs sm:text-sm text-slate-900 leading-relaxed border border-slate-200 shadow-2xs font-sans whitespace-pre-line">
                                                        {!! $pData['formatted_answer'] !!}
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Model English Translation -->
                                            @if(!empty($pData['text_en']))
                                                <div>
                                                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-1.5 flex items-center gap-1">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        Kunci Jawaban Model Akademik (Academic Model Answer)
                                                    </p>
                                                    <div class="rounded-xl bg-emerald-50/70 p-4 text-xs sm:text-sm text-emerald-950 leading-relaxed border border-emerald-100 font-medium">
                                                        {{ $pData['text_en'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </section>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
