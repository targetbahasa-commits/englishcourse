<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Target Bahasa') }} - Final Test Result</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">
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
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700">
                        {{ session('warning') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                <a href="{{ route('final-test') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Final Test Center
                </a>

                <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-6 text-white">
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-100">Final Test Completed</p>
                        <h1 class="mt-2 text-3xl font-bold">{{ $result->test_label ?? 'Final Test' }}</h1>
                        <p class="mt-2 text-sm text-blue-100">Your result is ready. A PDF certificate is available below and has been sent to your email when the certificate template is active.</p>
                    </div>

                    <div class="grid gap-0 md:grid-cols-[0.75fr_1.25fr]">
                        <div class="border-b border-slate-200 p-6 md:border-b-0 md:border-r">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Score</p>
                            <p class="mt-3 text-6xl font-bold text-indigo-700">{{ is_numeric($result->score) ? number_format((float) $result->score, 1) : ($result->score ?? '-') }}</p>
                            <span class="mt-4 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700">
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
                                        'sent' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'failed' => 'bg-rose-100 text-rose-700 border-rose-200',
                                        'skipped' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'queued' => 'bg-sky-100 text-sky-700 border-sky-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="mt-2 inline-flex items-center rounded-full border px-3 py-1 text-sm font-semibold {{ $emailClasses }}">{{ $emailLabel }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center">
                        @if($certificateAvailable)
                            <div x-data="{
                                hasReviewed: localStorage.getItem('reviewed_google') === 'true',
                                showReviewModal: false,
                                googleReviewUrl: 'https://www.google.com/maps/place/TARGET+BAHASA/@-7.7573236,112.1833212,17z/data=!3m1!4b1!4m6!3m5!1s0x2e785d8f90423785:0x9a4b206871789241!8m2!3d-7.7573236!4d112.1833212!16s%2Fg%2F11y97lt96g?entry=ttu&g_ep=EgoyMDI2MDcwOC4wIKXMDSoASAFQAw%3D%3D',
                                downloadUrl: '{{ route('final-test.certificate.download', $result) }}'
                            }">
                                <!-- Direct Download if already reviewed -->
                                <template x-if="hasReviewed">
                                    <a :href="downloadUrl" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Certificate PDF
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
                                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-yellow-50">
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
                                                        ⭐ Berikan Ulasan Bintang 5 di Google
                                                    </a>
                                                    <button type="button" @click="showReviewModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-3.5 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0">
                                                        Nanti saja
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <span class="inline-flex h-11 items-center rounded-xl border border-amber-200 bg-amber-50 px-5 text-sm font-semibold text-amber-700">
                                Certificate template is not active yet.
                            </span>
                        @endif
                        <button onclick="window.print()" class="inline-flex h-11 items-center justify-center rounded-xl bg-white px-5 text-sm font-semibold text-slate-700 ring-1 ring-slate-200 transition hover:bg-slate-50">
                            Print Result
                        </button>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
