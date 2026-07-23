<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($test['package_label'] ?? $test['label']) }} - Online Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-slate-100">
    @include('components.impersonation-banner')
    @if(!Auth::user()->isAdmin())
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">TB</div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent">Target Bahasa</span>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-medium rounded-xl transition-colors duration-200 text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @endif

    <div class="flex min-h-screen {{ !Auth::user()->isAdmin() ? 'max-w-7xl mx-auto w-full' : '' }}">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @endif

        <main class="flex-1 {{ Auth::user()->isAdmin() ? 'md:ml-64' : 'w-full' }} p-4 md:p-8">
            <div class="max-w-4xl mx-auto">
                <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('online-test.index') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-gray-600 hover:text-blue-600 hover:border-blue-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke daftar online test
                    </a>

                    <form action="{{ route('online-test.end-session', ['slug' => $test['slug']]) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 hover:border-red-300 rounded-xl text-sm font-semibold transition" onclick="return confirm('Apakah Anda yakin ingin mengakhiri sesi? Progress ujian yang sedang berjalan mungkin akan hilang.')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Selesai & Keluar
                        </button>
                    </form>
                </div>

                <section class="bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-8">
                        <p class="text-blue-100 text-sm tracking-wide uppercase font-semibold">Online Test Module</p>
                        <h1 class="text-3xl font-bold text-white mt-1">{{ $test['package_label'] ?? $test['label'] }}</h1>
                        @if(!empty($test['package_meta']))
                            <p class="text-blue-100 mt-2 text-sm leading-relaxed max-w-3xl">
                                {{ $test['package_meta']['description'] ?? $test['description'] }}
                            </p>
                        @endif

                        @if(Auth::user()->isAdmin())
                            <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/25 text-xs font-semibold text-white">
                                <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                                Paket aktif saat ini: Paket {{ max(1, min(16, (int) ($test['package_number'] ?? 1))) }}
                            </div>
                        @endif
                    </div>

                    <div class="p-8">
                        <p class="text-gray-700 leading-relaxed text-base">{{ $test['description'] }}</p>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Total Section</p>
                                <p class="text-2xl font-bold text-slate-800 mt-1">{{ count($test['sections']) }}</p>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Duration</p>
                                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $test['duration_minutes'] }} menit</p>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                                <p class="text-xs text-slate-500 uppercase tracking-wide">Test Time Estimation</p>
                                <p class="text-2xl font-bold text-slate-800 mt-1">{{ now()->addMinutes((int) $test['duration_minutes'])->format('H:i') }}</p>
                            </div>
                        </div>

                        @php
                            $requiredSectionKeys = collect($test['sections'])->pluck('key')->filter()->values()->all();
                            $isIeltsFlow = collect(['listening', 'reading', 'writing', 'speaking'])->every(
                                fn ($key) => in_array($key, $requiredSectionKeys, true)
                            );
                            $hasPackageBankForAdmin = in_array(($test['slug'] ?? ''), ['ielts_academic', 'ielts_general', 'toefl_itp'], true);
                            $isAdminIeltsAcademic = Auth::user()->isAdmin()
                                && ($test['slug'] ?? '') === 'ielts_academic'
                                && $isIeltsFlow;
                            $isIeltsAcademic = ($test['slug'] ?? '') === 'ielts_academic' && $isIeltsFlow;
                            $isToeflItp = ($test['slug'] ?? '') === 'toefl_itp';
                            $selectedEdition = max(1, min(16, (int) ($test['package_number'] ?? 1)));
                            $submitRedirectUrl = $latestResult
                                ? route('online-test.result', ['slug' => $test['slug'], 'onlineTestResult' => $latestResult->id])
                                : route('online-test.index');
                            $bandReportRouteParams = ['package' => $selectedEdition];

                            if ($latestResult && $latestResult->online_test_taker_id) {
                                $bandReportRouteParams['taker_id'] = $latestResult->online_test_taker_id;
                            }

                            $submitGateConfig = [
                                'slug' => $test['slug'],
                                'requiredSections' => $requiredSectionKeys,
                                'isIeltsFlow' => $isIeltsFlow,
                                'submitRedirectUrl' => $submitRedirectUrl,
                            ];
                        @endphp

                        @if(Auth::user()->isAdmin())
                            <div class="mt-6 p-4 rounded-2xl border border-indigo-100 bg-indigo-50/70">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Admin Package Info</p>
                                        <p class="text-sm font-semibold text-indigo-900 mt-1">Test ini sedang menggunakan Paket {{ $selectedEdition }}.</p>
                                        <p class="text-xs text-indigo-700 mt-1">Semua link paket section pada halaman ini mengikuti paket aktif ini.</p>
                                    </div>
                                    @if($hasPackageBankForAdmin)
                                        <a href="{{ route('admin.online-tests.package-bank', ['slug' => $test['slug']]) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition-colors">
                                            Kelola Bank Paket
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($isIeltsAcademic)
                            <div class="mt-6 p-4 rounded-2xl border border-emerald-100 bg-emerald-50/60">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Band Score Report</p>
                                        <p class="text-sm font-semibold text-emerald-900 mt-1">Lihat rekap band score IELTS Academic untuk Paket {{ $selectedEdition }}.</p>
                                    </div>
                                    <a href="{{ route('online-test.ielts-academic.band-report', $bandReportRouteParams) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition-colors">
                                        Lihat Band Score Report
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($isToeflItp)
                            <div class="mt-6 p-4 rounded-2xl border border-purple-100 bg-purple-50/60">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-purple-700">Score Report</p>
                                        <p class="text-sm font-semibold text-purple-900 mt-1">Lihat rekap score report TOEFL ITP untuk Paket {{ $selectedEdition }}.</p>
                                    </div>
                                    <a href="{{ route('online-test.toefl-itp.score-report', $bandReportRouteParams) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold transition-colors">
                                        Lihat Score Report
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="mt-8" x-data='ieltsSubmitGate(@js($submitGateConfig))' x-init="init()">
                            <h2 class="text-lg font-semibold text-slate-900 mb-4">Test Structure & Instruction</h2>
                            <div class="space-y-6">
                                @foreach($test['sections'] as $section)
                                    <div class="border border-slate-200 rounded-2xl p-6 bg-white" x-data="{ checked: false, showVideoForm: false }">
                                        <div class="flex items-center justify-between gap-3 mb-4">
                                            <div>
                                                <p class="font-bold text-xl text-slate-800">{{ $section['title'] }}</p>
                                                <p class="text-sm text-slate-500">{{ $section['question_count'] }} questions</p>
                                            </div>
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                                                {{ $section['minutes'] }} minutes
                                            </span>
                                        </div>
                                        
                                        @if(!empty($section['video_url']))
                                            <div class="rounded-xl overflow-hidden mb-5 border border-slate-200 bg-black aspect-video">
                                                <iframe
                                                    class="w-full h-full"
                                                    src="{{ $section['video_url'] }}"
                                                    title="{{ $section['title'] }} Instruction Video"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen
                                                ></iframe>
                                            </div>
                                        @else
                                            <div class="bg-slate-50 rounded-xl aspect-video flex flex-col items-center justify-center text-slate-400 mb-5 border-2 border-dashed border-slate-200">
                                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span class="text-sm font-medium">{{ $section['title'] }} Instruction Video</span>
                                            </div>
                                        @endif

                                        @if(Auth::user()->isAdmin())
                                            <div class="mb-5">
                                                <button type="button" @click="showVideoForm = !showVideoForm" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg border border-indigo-200 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition">
                                                    Input Video
                                                </button>

                                                <form
                                                    x-show="showVideoForm"
                                                    x-transition
                                                    action="{{ route('admin.online-tests.section-video.update', ['slug' => $test['slug'], 'section' => $section['key']]) }}"
                                                    method="POST"
                                                    class="mt-3 p-3 rounded-xl border border-slate-200 bg-slate-50"
                                                >
                                                    @csrf
                                                    <label class="block text-xs font-semibold text-slate-700 mb-2">URL Video (YouTube Embed / Vimeo Embed)</label>
                                                    <input
                                                        type="url"
                                                        name="video_url"
                                                        value="{{ $section['video_url'] ?? '' }}"
                                                        placeholder="https://www.youtube.com/embed/..."
                                                        class="w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    >
                                                    <div class="mt-3 flex justify-end">
                                                        <button type="submit" class="px-3 py-2 text-xs font-semibold rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Simpan Video</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        @if($isAdminIeltsAcademic && in_array($section['key'], ['listening', 'reading', 'writing', 'speaking'], true))
                                            <div class="mb-5 p-3 rounded-xl border border-amber-100 bg-amber-50/70">
                                                <p class="text-xs font-semibold uppercase tracking-wide text-amber-700 mb-2">Admin Reference</p>
                                                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                                    <a
                                                        href="{{ $section['key'] === 'listening'
                                                            ? url('/online-test/ielts-academic/paket1/listening')
                                                            : route('online-test.package-section', ['slugAlias' => str_replace('_', '-', $test['slug']), 'package' => $selectedEdition, 'section' => $section['key']]) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold transition-colors"
                                                    >
                                                        Buka Halaman Paket {{ ucfirst($section['key']) }}
                                                    </a>
                                                    @if(in_array($section['key'], ['listening', 'reading'], true))
                                                        <a
                                                            href="{{ route('admin.online-tests.package-answer-key.edit', ['slug' => $test['slug'], 'package' => $selectedEdition, 'section' => $section['key']]) }}"
                                                            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-white border border-amber-200 hover:bg-amber-100 text-amber-700 text-xs font-semibold transition-colors"
                                                        >
                                                            Edit Answer Key
                                                        </a>
                                                    @endif
                                                    <span class="text-xs text-amber-700">Halaman paket ini memuat draft internal section. Dari sana Anda tetap bisa buka referensi style jika diperlukan.</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Checkbox -->
                                        <label class="flex items-start gap-3 mb-5 cursor-pointer">
                                            <input type="checkbox" x-model="checked" class="mt-0.5 w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                            <span class="text-sm text-slate-700 font-medium leading-relaxed select-none">I understand the instructions for {{ $section['title'] }}</span>
                                        </label>

                                        <!-- Start Button Form -->
                                        @if(Auth::user()->isAdmin() && ($test['slug'] ?? '') === 'ielts_academic')
                                            <form action="{{ route('online-test.package-section', ['slugAlias' => str_replace('_', '-', $test['slug']), 'package' => $selectedEdition, 'section' => $section['key']]) }}" method="GET">
                                                <button type="submit" :disabled="!checked" :class="checked ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm' : 'bg-slate-100 text-slate-400 cursor-not-allowed'" class="inline-flex items-center justify-center px-6 py-3 font-semibold rounded-xl transition-all duration-200 w-full sm:w-auto">
                                                    Begin {{ $section['title'] }} Session
                                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('online-test.start', ['slug' => $test['slug']]) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="section" value="{{ $section['key'] }}">
                                                <button type="submit" @click="markSectionDone('{{ $section['key'] }}')" :disabled="!checked" :class="checked ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm' : 'bg-slate-100 text-slate-400 cursor-not-allowed'" class="inline-flex items-center justify-center px-6 py-3 font-semibold rounded-xl transition-all duration-200 w-full sm:w-auto">
                                                    Begin {{ $section['title'] }} Session
                                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @if($isIeltsFlow)
                                <div class="mt-6 p-5 bg-slate-50 border border-slate-200 rounded-2xl">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">Final IELTS Submission</p>
                                            <p class="text-xs text-slate-500 mt-1" x-text="canSubmitFinal ? 'Semua section sudah dikerjakan. Anda bisa submit IELTS test sekarang.' : 'Selesaikan Listening, Reading, Writing, dan Speaking terlebih dahulu.'"></p>
                                        </div>
                                        <button
                                            type="button"
                                            @click="submitIeltsTest()"
                                            :disabled="!canSubmitFinal"
                                            :class="canSubmitFinal ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm' : 'bg-slate-100 text-slate-400 cursor-not-allowed'"
                                            class="inline-flex items-center justify-center px-6 py-3 font-semibold rounded-xl transition-all duration-200 w-full sm:w-auto"
                                        >
                                            Submit IELTS Test
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- <div class="mt-8 p-5 bg-blue-50 border border-blue-100 rounded-xl">
                            <p class="text-sm text-blue-800 font-medium">Modul ini berada di jalur Online Test terpisah dan tidak terhubung ke halaman Assignment.</p>
                        </div> -->

                        @if($latestResult)
                            <div class="mt-6 p-5 bg-emerald-50 border border-emerald-100 rounded-xl">
                                <p class="text-sm text-emerald-800 font-medium">Hasil terakhir: status {{ $latestResult->status }}{{ $latestResult->score !== null ? ', skor ' . $latestResult->score : '' }}.</p>
                                <a href="{{ route('online-test.result', ['slug' => $test['slug'], 'onlineTestResult' => $latestResult->id]) }}" class="inline-flex items-center mt-3 text-sm font-semibold text-emerald-700 hover:text-emerald-900">Lihat hasil terakhir</a>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        function ieltsSubmitGate(config) {
            return {
                slug: config.slug,
                isIeltsFlow: Boolean(config.isIeltsFlow),
                requiredSections: Array.isArray(config.requiredSections) ? config.requiredSections : [],
                submitRedirectUrl: config.submitRedirectUrl || '',
                completedSections: [],
                get storageKey() {
                    return `online-test-progress-${this.slug}`;
                },
                get canSubmitFinal() {
                    if (!this.isIeltsFlow) {
                        return false;
                    }

                    const ieltsSections = ['listening', 'reading', 'writing', 'speaking'];

                    return ieltsSections.every((key) => this.completedSections.includes(key));
                },
                init() {
                    if (!this.isIeltsFlow) {
                        return;
                    }

                    try {
                        const raw = localStorage.getItem(this.storageKey);
                        this.completedSections = raw ? JSON.parse(raw) : [];
                    } catch (error) {
                        this.completedSections = [];
                    }
                },
                markSectionDone(sectionKey) {
                    if (!this.isIeltsFlow || !sectionKey) {
                        return;
                    }

                    if (!this.completedSections.includes(sectionKey)) {
                        this.completedSections.push(sectionKey);
                        localStorage.setItem(this.storageKey, JSON.stringify(this.completedSections));
                    }
                },
                submitIeltsTest() {
                    if (!this.canSubmitFinal || !this.submitRedirectUrl) {
                        return;
                    }

                    window.location.href = this.submitRedirectUrl;
                },
            };
        }
    </script>
</body>

</html>
