<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - {{ $selectedProgram['name'] }} Final Test</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .word-correct { color: #059669; font-weight: 600; }
        .word-wrong { color: #dc2626; text-decoration: line-through; }
        .word-missing { color: #2563eb; font-weight: 700; text-decoration: underline; }
        .word-extra { color: #d97706; text-decoration: line-through; }
    
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    
        .final-test-textarea {
            flex: 1 1 0% !important;
            min-height: 550px !important;
            height: 100% !important;
            width: 100% !important;
            padding: 1.5rem !important;
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
            font-size: 0.95rem !important;
            line-height: 1.75 !important;
            color: #0f172a !important;
            resize: none !important;
            background-color: #ffffff;
        }
        .final-test-textarea:focus {
            outline: none !important;
            box-shadow: none !important;
            border: 0 !important;
            background-color: rgba(239, 246, 255, 0.25) !important;
        }
        .final-test-split-panel {
            min-height: 680px !important;
        }

    </style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen">
        @if(Auth::user()?->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()?->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        @php
            $accentClasses = [
                'green' => ['line' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'soft' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'button' => 'bg-emerald-600 hover:bg-emerald-700'],
                'purple' => ['line' => 'bg-violet-500', 'text' => 'text-violet-700', 'soft' => 'bg-violet-50 text-violet-700 border-violet-100', 'button' => 'bg-violet-600 hover:bg-violet-700'],
                'red' => ['line' => 'bg-rose-500', 'text' => 'text-rose-700', 'soft' => 'bg-rose-50 text-rose-700 border-rose-100', 'button' => 'bg-rose-600 hover:bg-rose-700'],
                'orange' => ['line' => 'bg-amber-500', 'text' => 'text-amber-700', 'soft' => 'bg-amber-50 text-amber-700 border-amber-100', 'button' => 'bg-amber-600 hover:bg-amber-700'],
                'blue' => ['line' => 'bg-blue-600', 'text' => 'text-blue-700', 'soft' => 'bg-blue-50 text-blue-700 border-blue-100', 'button' => 'bg-blue-600 hover:bg-blue-700'],
                'yellow' => ['line' => 'bg-yellow-500', 'text' => 'text-yellow-700', 'soft' => 'bg-yellow-50 text-yellow-700 border-yellow-100', 'button' => 'bg-yellow-600 hover:bg-yellow-700'],
            ];
            $accent = $accentClasses[$selectedProgram['accent']] ?? $accentClasses['blue'];
            $displayTitle = $selectedProgram['name'] . ($variantLabel ? ' - ' . $variantLabel : '');
        @endphp

        <main class="flex-1 md:ml-64 min-h-screen">
            <div class="px-4 py-6 sm:px-6 lg:px-8 max-w-[1600px] w-full mx-auto">
                <!-- Navigation Bar -->
                <div class="mb-6 flex flex-col gap-4 border-b border-slate-200 pb-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <a href="{{ route('final-test') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Final Test Center
                        </a>
                        <div class="mt-3 flex items-center gap-2.5">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-extrabold text-blue-800 border border-blue-200">
                                <span class="h-2 w-2 rounded-full bg-blue-600 animate-pulse"></span>
                                FINAL ASSESSMENT
                            </span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600 border border-slate-200">
                                {{ $testData['summary_badge'] ?? 'Summary Test' }}
                            </span>
                        </div>
                        <h1 class="mt-2 text-2xl sm:text-3xl font-black tracking-tight text-slate-950">{{ $testData['track_title'] ?? $displayTitle }}</h1>
                        <p class="mt-1 text-sm text-slate-600 max-w-3xl">
                            {{ $testData['description'] ?? $selectedProgram['description'] }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm shrink-0">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <div class="rounded-xl bg-slate-50 px-3.5 py-2">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Track</p>
                                <p class="mt-0.5 text-xs font-black text-slate-900">{{ $variantLabel ?? 'Main' }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3.5 py-2">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Batch</p>
                                <p class="mt-0.5 text-xs font-black text-slate-900 truncate max-w-[120px]">{{ $displayBatch }}</p>
                            </div>
                            <div class="rounded-xl bg-emerald-50 px-3.5 py-2 col-span-2 sm:col-span-1 border border-emerald-100">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Status</p>
                                <p class="mt-0.5 text-xs font-black text-emerald-700">Active Room</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!empty($testData) && !empty($testData['paragraphs']))
                    <script>
                    function finalTestWorkspace() {
                        const sampleEn1 = {{ Js::from($testData['paragraphs'][1]['text_en'] ?? '') }};
                        const sampleEn2 = {{ Js::from($testData['paragraphs'][2]['text_en'] ?? '') }};
                        const sampleEn3 = {{ Js::from($testData['paragraphs'][3]['text_en'] ?? '') }};
                        const testTrackTitle = {{ Js::from($testData['track_title'] ?? 'Final Test') }};
                        const serverDraftAnswers = {{ Js::from($savedDraft?->answers ?? []) }};
                        const serverDraftTime = {{ Js::from($savedDraft?->time_spent_seconds ?? 0) }};
                        const draftSaveUrl = {{ Js::from(route('final-test.draft.save', array_filter(['program' => $program, 'variant' => $variant]))) }};

                        return {
                            answers: { 1: '', 2: '', 3: '' },
                            timerSeconds: 0,
                            timerRunning: true,
                            timerInterval: null,
                            showVocabModal: false,
                            showSubmitModal: false,
                            showModulesSummary: false,
                            showAdminModelModal: false,
                            vocabActiveTab: 'all',
                            vocabSearch: '',
                            splitLeftWidth: 50,
                            isResizing: false,
                            startX: 0,
                            startWidth: 50,
                            isDesktop: typeof window !== 'undefined' ? window.innerWidth >= 1024 : true,
                            resizeMoveHandler: null,
                            resizeUpHandler: null,
                            splitStorageKey: 'ft_gfw_{{ $variant }}_split_v5',
                            submitting: false,
                            draftSaveTimeout: null,
                            draftSyncInterval: null,
                            lastSyncedAnswers: '',

                            setSplit(percent) {
                                this.splitLeftWidth = Math.max(35, Math.min(65, percent));
                                try {
                                    localStorage.setItem(this.splitStorageKey, String(this.splitLeftWidth));
                                } catch (e) {}
                            },

                            resetSplit() {
                                this.setSplit(50);
                            },

                            panelStyle(side) {
                                if (!this.isDesktop) return '';
                                const left = this.splitLeftWidth;
                                if (side === 'left') {
                                    return `width: ${left}%; flex: 0 0 ${left}%; min-width: 320px;`;
                                } else {
                                    const right = 100 - left;
                                    return `width: ${right}%; flex: 0 0 ${right}%; min-width: 360px;`;
                                }
                            },

                            startResize(event) {
                                if (!this.isDesktop) return;
                                this.isResizing = true;
                                this.startX = event.clientX;
                                this.startWidth = this.splitLeftWidth;
                                if (!this.resizeMoveHandler) {
                                    this.resizeMoveHandler = (e) => this.onResize(e);
                                }
                                if (!this.resizeUpHandler) {
                                    this.resizeUpHandler = () => this.stopResize();
                                }
                                document.addEventListener('mousemove', this.resizeMoveHandler);
                                document.addEventListener('mouseup', this.resizeUpHandler);
                                document.body.classList.add('select-none', 'cursor-col-resize');
                            },

                            startResizeTouch(event) {
                                if (!this.isDesktop || !event.touches || event.touches.length === 0) return;
                                this.isResizing = true;
                                this.startX = event.touches[0].clientX;
                                this.startWidth = this.splitLeftWidth;
                                const onTouchMove = (e) => {
                                    if (!this.isResizing || !e.touches || e.touches.length === 0) return;
                                    this.handleResizeMove(e.touches[0].clientX);
                                };
                                const onTouchEnd = () => {
                                    this.stopResize();
                                    window.removeEventListener('touchmove', onTouchMove);
                                    window.removeEventListener('touchend', onTouchEnd);
                                };
                                window.addEventListener('touchmove', onTouchMove, { passive: true });
                                window.addEventListener('touchend', onTouchEnd);
                                document.body.classList.add('select-none');
                            },

                            onResize(event) {
                                if (!this.isResizing) return;
                                this.handleResizeMove(event.clientX);
                            },

                            handleResizeMove(clientX) {
                                const container = this.$refs.splitContainer;
                                if (!container) return;
                                const containerWidth = container.clientWidth;
                                if (!containerWidth) return;
                                const deltaPercent = ((clientX - this.startX) / containerWidth) * 100;
                                this.splitLeftWidth = Math.max(35, Math.min(65, this.startWidth + deltaPercent));
                            },

                            stopResize() {
                                this.isResizing = false;
                                if (this.resizeMoveHandler) {
                                    document.removeEventListener('mousemove', this.resizeMoveHandler);
                                }
                                if (this.resizeUpHandler) {
                                    document.removeEventListener('mouseup', this.resizeUpHandler);
                                }
                                document.body.classList.remove('select-none', 'cursor-col-resize');
                                try {
                                    localStorage.setItem(this.splitStorageKey, String(this.splitLeftWidth));
                                } catch (e) {}
                            },

                            init() {
                                this.isDesktop = window.innerWidth >= 1024;
                                window.addEventListener('resize', () => {
                                    this.isDesktop = window.innerWidth >= 1024;
                                });

                                try {
                                    localStorage.removeItem('ft_gfw_{{ $variant }}_split');
                                    localStorage.removeItem('ft_gfw_{{ $variant }}_split_v2');
                                    localStorage.removeItem('ft_gfw_{{ $variant }}_split_v3');
                                    localStorage.removeItem('ft_gfw_{{ $variant }}_split_v4');
                                    const stored = parseFloat(localStorage.getItem(this.splitStorageKey) || '');
                                    if (!isNaN(stored) && stored >= 35 && stored <= 65) {
                                        this.splitLeftWidth = stored;
                                    } else {
                                        this.splitLeftWidth = 50;
                                    }
                                } catch (e) {
                                    this.splitLeftWidth = 50;
                                }

                                // Server draft (survives a cleared browser, private/incognito
                                // mode, or switching devices) always wins over localStorage
                                // when it has content - it is the source of truth that
                                // syncDraftToServer() keeps updated. localStorage is only
                                // the fallback for the (rare) logged-out-of-sync case.
                                const hasServerDraft = serverDraftAnswers && (serverDraftAnswers[1] || serverDraftAnswers[2] || serverDraftAnswers[3]);
                                if (hasServerDraft) {
                                    this.answers[1] = serverDraftAnswers[1] || '';
                                    this.answers[2] = serverDraftAnswers[2] || '';
                                    this.answers[3] = serverDraftAnswers[3] || '';
                                    if (serverDraftTime) this.timerSeconds = serverDraftTime;
                                } else {
                                    const p1 = localStorage.getItem('ft_gfw_{{ $variant }}_p1') || '';
                                    const p2 = localStorage.getItem('ft_gfw_{{ $variant }}_p2') || '';
                                    const p3 = localStorage.getItem('ft_gfw_{{ $variant }}_p3') || '';
                                    if (p1) this.answers[1] = p1;
                                    if (p2) this.answers[2] = p2;
                                    if (p3) this.answers[3] = p3;

                                    if (!this.answers[1] && !this.answers[2] && !this.answers[3]) {
                                        const fullSaved = localStorage.getItem('ft_gfw_{{ $variant }}_full_answer');
                                        if (fullSaved && fullSaved.trim()) {
                                            const parts = fullSaved.split(/\n\s*\n+/);
                                            if (parts[0]) this.answers[1] = parts[0].trim();
                                            if (parts[1]) this.answers[2] = parts[1].trim();
                                            if (parts[2]) this.answers[3] = parts[2].trim();
                                        }
                                    }
                                }

                                this.timerInterval = setInterval(() => {
                                    if (this.timerRunning) this.timerSeconds++;
                                }, 1000);

                                // Backup heartbeat in case a burst of typing never triggers
                                // saveAnswer()'s debounce to actually fire (e.g. tab loses
                                // focus mid-debounce and gets throttled by the browser).
                                this.draftSyncInterval = setInterval(() => this.syncDraftToServer(), 20000);

                                window.addEventListener('beforeunload', (e) => {
                                    if (this.submitting) return;
                                    this.syncDraftToServer(true);
                                    if (this.getTotalWords() > 0) {
                                        e.preventDefault();
                                        e.returnValue = '';
                                    }
                                });
                                document.addEventListener('visibilitychange', () => {
                                    if (document.visibilityState === 'hidden') this.syncDraftToServer();
                                });
                            },

                            saveAnswer(pNum) {
                                try {
                                    localStorage.setItem('ft_gfw_{{ $variant }}_p' + pNum, this.answers[pNum]);
                                    const combined = [this.answers[1], this.answers[2], this.answers[3]].filter(Boolean).join('\n\n');
                                    localStorage.setItem('ft_gfw_{{ $variant }}_full_answer', combined);
                                } catch (e) {}

                                clearTimeout(this.draftSaveTimeout);
                                this.draftSaveTimeout = setTimeout(() => this.syncDraftToServer(), 2000);
                            },

                            // Persists the 3 paragraphs to the server (final_test_drafts
                            // table) so an exited/closed/crashed tab never loses work -
                            // localStorage alone (the only persistence before this) doesn't
                            // survive private/incognito mode or a cleared browser. Called
                            // debounced from saveAnswer(), on a 20s heartbeat, on tab-hide,
                            // and (via sendBeacon) on beforeunload.
                            syncDraftToServer(useBeacon = false) {
                                const snapshot = JSON.stringify(this.answers);
                                if (snapshot === this.lastSyncedAnswers) return;

                                const payload = {
                                    paragraphs: this.answers,
                                    time_spent_seconds: this.timerSeconds,
                                };
                                const token = document.querySelector('meta[name="csrf-token"]')?.content || '';

                                if (useBeacon && navigator.sendBeacon) {
                                    const formData = new FormData();
                                    formData.append('_token', token);
                                    formData.append('time_spent_seconds', String(this.timerSeconds));
                                    Object.keys(this.answers).forEach((k) => formData.append('paragraphs[' + k + ']', this.answers[k]));
                                    navigator.sendBeacon(draftSaveUrl, formData);
                                    this.lastSyncedAnswers = snapshot;
                                    return;
                                }

                                fetch(draftSaveUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                        'X-Requested-With': 'XMLHttpRequest',
                                    },
                                    body: JSON.stringify(payload),
                                }).then((res) => {
                                    if (res.ok) this.lastSyncedAnswers = snapshot;
                                }).catch(() => {});
                            },

                            saveDrafts() {
                                this.saveAnswer(1);
                                this.saveAnswer(2);
                                this.saveAnswer(3);
                            },

                            formatTimer(sec) {
                                const m = Math.floor(sec / 60);
                                const s = sec % 60;
                                return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
                            },

                            fillSampleAnswers() {
                                this.answers[1] = sampleEn1;
                                this.answers[2] = sampleEn2;
                                this.answers[3] = sampleEn3;
                                this.saveDrafts();
                                alert('Draf contoh teks terjemahan model untuk ' + testTrackTitle + ' berhasil diisikan ke 3 kolom jawaban.');
                            },

                            getWordCount(text) {
                                if (!text || !text.trim()) return 0;
                                return text.trim().split(/\s+/).filter(Boolean).length;
                            },

                            getTotalWords() {
                                return this.getWordCount(this.answers[1]) + this.getWordCount(this.answers[2]) + this.getWordCount(this.answers[3]);
                            },

                            clearProgress() {
                                if (confirm('Apakah Anda yakin ingin mengosongkan ketiga lembar jawaban draf ini?')) {
                                    this.answers[1] = '';
                                    this.answers[2] = '';
                                    this.answers[3] = '';
                                    try {
                                        localStorage.removeItem('ft_gfw_{{ $variant }}_p1');
                                        localStorage.removeItem('ft_gfw_{{ $variant }}_p2');
                                        localStorage.removeItem('ft_gfw_{{ $variant }}_p3');
                                        localStorage.removeItem('ft_gfw_{{ $variant }}_full_answer');
                                    } catch (e) {}
                                    this.lastSyncedAnswers = '';
                                    this.syncDraftToServer();
                                }
                            }
                        };
                    }

                    window.finalTestWorkspace = finalTestWorkspace;
                    document.addEventListener('alpine:init', () => {
                        if (window.Alpine) {
                            window.Alpine.data('finalTestWorkspace', finalTestWorkspace);
                        }
                    });
                    </script>

                    <div x-data="finalTestWorkspace()" x-cloak class="space-y-4 flex flex-col flex-1">

                        @if(Auth::user()?->isAdmin())
                            <!-- Admin Evaluation Management Banner (Solid Bright Blue) -->
                            <div class="rounded-2xl border border-blue-500 bg-blue-600 p-4 sm:p-5 text-white shadow-md">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                    <div class="flex items-center gap-3.5">
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/15 text-white border border-white/25 font-black text-xl">
                                            👑
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-black uppercase tracking-widest text-blue-100">Fitur Khusus Administrator</span>
                                                <span class="rounded-full bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 border border-white/30">Pengelolaan Evaluasi Aktif</span>
                                            </div>
                                            <h2 class="text-base sm:text-lg font-black text-white mt-0.5">Pusat Pengelolaan Evaluasi &amp; Koreksi Nilai Siswa</h2>
                                            <p class="text-xs text-blue-100">Akses hasil pengerjaan seluruh peserta, sesuaikan rubrik penilaian, atau gunakan draf uji otomatis.</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2.5">
                                        <a href="{{ route('admin.final-test-results.index', ['test_type' => ($variant ? $variant . '-grammar-for-writing' : 'fast-track-grammar-for-writing')]) }}" class="inline-flex items-center gap-2 rounded-xl bg-white hover:bg-blue-50 px-4 py-2.5 text-xs font-black text-blue-700 shadow-sm transition">
                                            <svg class="h-4 w-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            Kelola Hasil &amp; Nilai Siswa
                                        </a>
                                        <button type="button" @click="showAdminModelModal = true" class="inline-flex items-center gap-1.5 rounded-xl border border-blue-400 bg-blue-700 hover:bg-blue-800 px-3.5 py-2.5 text-xs font-bold text-white transition cursor-pointer">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Kunci Model &amp; {{ count($testData['modules_covered'] ?? []) }} Modul
                                        </button>
                                        <button type="button" @click="fillSampleAnswers()" class="inline-flex items-center gap-1.5 rounded-xl border border-blue-400 bg-blue-700 hover:bg-blue-800 px-3.5 py-2.5 text-xs font-bold text-white transition cursor-pointer" title="Isi cepat lembar jawaban dengan contoh standar untuk menguji sistem evaluasi">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            Isi Draf Uji Coba
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Top Toolbar Bar: Timer, Total Words, Vocab Button, and Submit Button -->
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4 shrink-0">
                            <!-- Left: Timer & Autosave -->
                            <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-start">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100 shrink-0">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Waktu Berjalan</p>
                                        <p class="text-xl font-black font-mono text-slate-900 leading-tight" x-text="formatTimer(timerSeconds)">00:00</p>
                                    </div>
                                </div>

                                <div class="hidden sm:flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-100">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Tersimpan Otomatis</span>
                                </div>
                            </div>

                            <!-- Center: Mode Badge & Quick Info -->
                            <div class="hidden lg:flex items-center gap-2.5 text-xs text-slate-600">
                                <span class="rounded-md bg-blue-50 px-2.5 py-1 text-xs font-extrabold text-blue-700 border border-blue-200">
                                    3 Kolom Jawaban (Split-Screen)
                                </span>
                                <span>•</span>
                                <!-- Quick Split Controls -->
                                <div class="inline-flex items-center gap-1 bg-slate-100 p-0.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700">
                                    <span class="text-[10px] text-slate-400 font-semibold px-1.5 uppercase">Split:</span>
                                    <button type="button" @click="setSplit(50)"
                                        :class="Math.round(splitLeftWidth) === 50 ? 'bg-white text-blue-700 shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                                        class="px-2 py-0.5 rounded-lg transition text-[11px] cursor-pointer"
                                        title="Bagi 50% Soal : 50% Jawaban (Seimbang)">
                                        50:50
                                    </button>
                                    <button type="button" @click="setSplit(40)"
                                        :class="Math.round(splitLeftWidth) === 40 ? 'bg-white text-blue-700 shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                                        class="px-2 py-0.5 rounded-lg transition text-[11px] cursor-pointer"
                                        title="Fokus Menulis: 40% Soal : 60% Jawaban">
                                        40:60
                                    </button>
                                    <button type="button" @click="setSplit(60)"
                                        :class="Math.round(splitLeftWidth) === 60 ? 'bg-white text-blue-700 shadow-2xs' : 'text-slate-500 hover:text-slate-800'"
                                        class="px-2 py-0.5 rounded-lg transition text-[11px] cursor-pointer"
                                        title="Fokus Membaca: 60% Soal : 40% Jawaban">
                                        60:40
                                    </button>
                                </div>
                                <span>•</span>
                                <button type="button" @click="showModulesSummary = !showModulesSummary" class="text-blue-600 hover:text-blue-800 font-bold underline decoration-dotted transition cursor-pointer">
                                    <span x-text="showModulesSummary ? 'Tutup Modul' : 'Cakupan Modul'"></span>
                                </button>
                            </div>

                            <!-- Right Actions: Vocab Assistant & Submit Modal Trigger -->
                            <div class="flex items-center gap-2.5 w-full md:w-auto justify-end">
                                <button type="button" @click="showVocabModal = true" class="inline-flex items-center gap-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 text-xs font-bold shadow-sm transition cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span>Bantuan Kosakata</span>
                                </button>

                                <button type="button" @click="showSubmitModal = true" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 text-xs font-bold shadow-sm transition cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Kumpulkan Ujian</span>
                                </button>
                            </div>
                        </div>

                        <!-- 10 Modules Curriculum Strip (Collapsible / Expandable) -->
                        <div x-show="showModulesSummary" x-transition class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm shrink-0">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-600 flex items-center gap-1.5">
                                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                                    Cakupan 10 Modul Fast Track dalam Final Test
                                </h4>
                                <button type="button" @click="showModulesSummary = false" class="text-slate-400 hover:text-slate-600 text-xs">Tutup</button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($testData['modules_covered'] as $mod)
                                    <div class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs text-slate-700">
                                        <span class="font-extrabold text-blue-700 font-mono text-[11px]">{{ $mod['tag'] }}</span>
                                        <span class="font-medium text-slate-600">{{ $mod['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Main Form for Final Test Submission with Split Screen & 3 Answer Columns -->
                        <form id="finalTestForm" method="POST" action="{{ route('final-test.complete', array_filter(['program' => $program, 'variant' => $variant])) }}" class="flex-1 flex flex-col min-h-0" @submit="submitting = true">
                            @csrf
                            <input type="hidden" name="time_spent_seconds" :value="timerSeconds">
                            <input type="hidden" name="paragraphs[1]" :value="answers[1]">
                            <input type="hidden" name="paragraphs[2]" :value="answers[2]">
                            <input type="hidden" name="paragraphs[3]" :value="answers[3]">
                            <input type="hidden" name="full_translation" :value="[answers[1], answers[2], answers[3]].filter(Boolean).join('\n\n')">

                            <!-- Split Screen Layout Container -->
                            <div x-ref="splitContainer" class="flex flex-col lg:flex-row flex-1 min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-[height] duration-200" style="min-height: 720px; height: calc(100vh - 220px);">
                                
                                <!-- Left Column: Source Indonesian 3 Paragraphs -->
                                <div id="left-panel" class="w-full lg:w-1/2 lg:basis-1/2 flex-1 flex flex-col min-h-0 min-w-0 h-full overflow-hidden bg-slate-50/60 border-b lg:border-b-0 lg:border-r border-slate-200 transition-[width] duration-75" :style="panelStyle('left')">
                                    <!-- Left Panel Header -->
                                    <div class="px-5 py-3.5 bg-slate-900 text-white flex items-center justify-between shrink-0 shadow-xs">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-rose-500/20 text-rose-400 border border-rose-500/30 text-xs font-bold font-mono">
                                                ID
                                            </span>
                                            <div>
                                                <h3 class="text-sm font-bold text-white leading-tight">Naskah Soal Bahasa Indonesia</h3>
                                                <p class="text-[11px] text-slate-400">3 Paragraf Terpadu (Source Passage)</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="hidden sm:inline-flex items-center rounded-md bg-white/10 px-2 py-0.5 text-[10px] font-mono font-bold text-slate-300 border border-white/15" x-text="'Lebar: ' + Math.round(splitLeftWidth) + '%'">
                                                Lebar: 50%
                                            </span>
                                            <span class="rounded-lg bg-white/10 px-2.5 py-1 text-[11px] font-bold text-blue-200 border border-white/15">
                                                3 Paragraf
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Left Panel Scrollable Content -->
                                    <div class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-6 select-text custom-scrollbar">
                                        @foreach($testData['paragraphs'] as $pNum => $p)
                                            @php
                                                $cleanTitle = preg_replace('/^Paragraf\s*\d+\s*:\s*/i', '', $p['title']);
                                            @endphp
                                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs transition hover:border-slate-300">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5 mb-3 border-b border-slate-100 pb-2.5">
                                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 text-blue-800 px-2.5 py-1 text-xs font-bold border border-blue-100">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                                                        Paragraf {{ $pNum }}: {{ $cleanTitle }}
                                                    </span>
                                                    <span class="text-[11px] text-slate-400 font-mono">Bagian {{ $pNum }} dari 3</span>
                                                </div>

                                                <div class="mb-3 rounded-lg bg-slate-50 px-3 py-1.5 border border-slate-100">
                                                    <p class="text-xs text-slate-600">
                                                        <strong class="text-blue-700">Fokus Grammar:</strong> {{ $p['focus'] }}
                                                    </p>
                                                </div>

                                                <p class="text-sm sm:text-[15px] leading-relaxed text-slate-900 font-medium select-text">
                                                    {{ $p['text_id'] }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Resizable Divider Handle (desktop) -->
                                <div
                                    class="hidden lg:flex w-4 items-stretch justify-center cursor-col-resize select-none shrink-0 bg-slate-100 hover:bg-blue-100 active:bg-blue-200 transition-colors group relative z-10"
                                    @mousedown.prevent="startResize($event)"
                                    @touchstart.passive="startResizeTouch($event)"
                                    @dblclick="resetSplit()"
                                    title="Geser untuk atur lebar layar • Klik 2x untuk reset 50:50">
                                    <div class="w-1.5 rounded-full bg-slate-300 group-hover:bg-blue-500 transition-colors my-auto h-28 flex items-center justify-center">
                                        <div class="h-7 w-3.5 bg-white rounded-md border border-slate-300 shadow-sm flex flex-col justify-center items-center gap-0.5 group-hover:border-blue-500 transition-colors">
                                            <span class="w-1.5 h-0.5 bg-slate-400 rounded-full group-hover:bg-blue-600"></span>
                                            <span class="w-1.5 h-0.5 bg-slate-400 rounded-full group-hover:bg-blue-600"></span>
                                            <span class="w-1.5 h-0.5 bg-slate-400 rounded-full group-hover:bg-blue-600"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: 3 Answer Boxes for Each Paragraph -->
                                <div id="writing-panel" class="w-full lg:w-1/2 lg:basis-1/2 flex-1 flex flex-col min-h-0 min-w-0 h-full overflow-hidden bg-white transition-[width] duration-75" :style="panelStyle('right')">
                                    <!-- Right Panel Header -->
                                    <div class="px-5 py-3.5 border-b border-slate-200 bg-slate-50 flex items-center justify-between shrink-0">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-500/20 text-emerald-700 border border-emerald-500/30 text-xs font-bold font-mono">
                                                EN
                                            </span>
                                            <div>
                                                <h3 class="text-sm font-bold text-slate-900 leading-tight">Lembar Jawaban Terjemahan</h3>
                                                <p class="text-[11px] text-slate-500">3 Kolom Jawaban per Paragraf</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2.5">
                                            <button type="button" @click="resetSplit()" class="hidden md:inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 hover:text-blue-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1 shadow-2xs transition cursor-pointer" title="Kembalikan ukuran split ke 50:50">
                                                <svg class="h-3 w-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                <span>Reset 50:50</span>
                                            </button>
                                            <span class="hidden sm:inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-[10px] font-mono font-bold text-slate-600 border border-slate-200" x-text="'Lebar: ' + Math.round(100 - splitLeftWidth) + '%'">
                                                Lebar: 50%
                                            </span>
                                            <span class="inline-flex items-center rounded-lg bg-white px-3 py-1 text-xs font-bold text-slate-800 border border-slate-200 shadow-2xs font-mono">
                                                Total: <span x-text="getTotalWords()" class="text-emerald-700 ml-1">0</span>&nbsp;words
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Right Panel Scrollable Content (3 Answer Boxes) -->
                                    <div class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-6 custom-scrollbar">
                                        @foreach($testData['paragraphs'] as $pNum => $p)
                                            @php
                                                $cleanTitle = preg_replace('/^Paragraf\s*\d+\s*:\s*/i', '', $p['title']);
                                            @endphp
                                            <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-5 shadow-xs transition hover:border-slate-300 hover:bg-white flex flex-col space-y-3">
                                                <div class="flex items-center justify-between gap-2 border-b border-slate-200/80 pb-2.5">
                                                    <div class="flex items-center gap-2">
                                                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-600 text-white text-xs font-black">
                                                            {{ $pNum }}
                                                        </span>
                                                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">
                                                            Jawaban Terjemahan Paragraf {{ $pNum }}: {{ $cleanTitle }}
                                                        </h4>
                                                    </div>
                                                    <span class="inline-flex items-center rounded-lg bg-white px-2.5 py-1 text-xs font-mono font-bold text-slate-700 border border-slate-200 shadow-2xs">
                                                        <span x-text="getWordCount(answers[{{ $pNum }}])">0</span>&nbsp;words
                                                    </span>
                                                </div>

                                                <div>
                                                    <textarea
                                                        id="paragraph_answer_{{ $pNum }}"
                                                        name="paragraphs[{{ $pNum }}]"
                                                        x-model="answers[{{ $pNum }}]"
                                                        @input="saveAnswer({{ $pNum }})"
                                                        rows="7"
                                                        placeholder="Ketik terjemahan bahasa Inggris untuk Paragraf {{ $pNum }} di sini..."
                                                        class="w-full rounded-xl border border-slate-300 bg-white p-4 text-sm sm:text-base leading-relaxed text-slate-900 shadow-inner focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 focus:outline-none transition resize-y font-sans custom-scrollbar"
                                                        style="min-height: 180px;"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Right Panel Footer (Pinned to bottom) -->
                                    <div class="px-5 py-3.5 border-t border-slate-200 bg-slate-50/90 flex items-center justify-between gap-3 shrink-0" style="margin-top: auto;">
                                        <button type="button" @click="clearProgress()" class="text-xs font-bold text-slate-400 hover:text-rose-600 transition inline-flex items-center gap-1.5 cursor-pointer">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="hidden sm:inline">Kosongkan Semua Draf</span>
                                        </button>

                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="showSubmitModal = true" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-2.5 text-xs sm:text-sm font-bold text-white shadow-sm hover:shadow transition transform hover:-translate-y-0.5 cursor-pointer">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Kumpulkan Lembar Jawaban
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Final Submit Confirmation Modal -->
                            <div x-show="showSubmitModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" role="dialog" aria-modal="true">
                                <div x-show="showSubmitModal"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
                                     @click="showSubmitModal = false"></div>

                                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                        <div x-show="showSubmitModal"
                                             x-transition:enter="ease-out duration-300"
                                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                             x-transition:leave="ease-in duration-200"
                                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             class="relative transform overflow-hidden rounded-3xl bg-white px-6 pb-6 pt-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">
                                            
                                            <div class="text-center">
                                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <h3 class="mt-4 text-xl font-black text-slate-900">Kumpulkan Final Test Sekarang?</h3>
                                                <p class="mt-2 text-xs leading-relaxed text-slate-500">
                                                    Pastikan seluruh terjemahan ketiga paragraf telah Anda periksa dengan teliti. Setelah dikumpulkan, skor evaluasi tata bahasa dan sertifikat resmi kelulusan akan langsung diterbitkan.
                                                </p>
                                            </div>

                                            <div class="mt-5 space-y-2 rounded-2xl bg-slate-50 p-4 border border-slate-200">
                                                <div class="flex items-center justify-between text-xs">
                                                    <span class="font-semibold text-slate-600">Paragraf 1:</span>
                                                    <span :class="getWordCount(answers[1]) >= 25 ? 'text-emerald-700 font-bold' : 'text-amber-600 font-bold'" x-text="getWordCount(answers[1]) + ' kata ' + (getWordCount(answers[1]) >= 25 ? '✓' : '(Belum optimal)')"></span>
                                                </div>
                                                <div class="flex items-center justify-between text-xs">
                                                    <span class="font-semibold text-slate-600">Paragraf 2:</span>
                                                    <span :class="getWordCount(answers[2]) >= 25 ? 'text-emerald-700 font-bold' : 'text-amber-600 font-bold'" x-text="getWordCount(answers[2]) + ' kata ' + (getWordCount(answers[2]) >= 25 ? '✓' : '(Belum optimal)')"></span>
                                                </div>
                                                <div class="flex items-center justify-between text-xs">
                                                    <span class="font-semibold text-slate-600">Paragraf 3:</span>
                                                    <span :class="getWordCount(answers[3]) >= 25 ? 'text-emerald-700 font-bold' : 'text-amber-600 font-bold'" x-text="getWordCount(answers[3]) + ' kata ' + (getWordCount(answers[3]) >= 25 ? '✓' : '(Belum optimal)')"></span>
                                                </div>
                                                <div class="border-t border-slate-200 pt-2 mt-2 flex items-center justify-between text-xs font-bold text-slate-900">
                                                    <span>Total Kata:</span>
                                                    <span x-text="getTotalWords() + ' kata'"></span>
                                                </div>
                                                <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                                                    <span>Durasi Pengerjaan:</span>
                                                    <span class="font-bold text-slate-800 font-mono" x-text="formatTimer(timerSeconds)"></span>
                                                </div>
                                            </div>

                                            <div class="mt-6 flex flex-col sm:flex-row gap-2">
                                                <button type="submit" :disabled="submitting" class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-md hover:bg-emerald-500 transition cursor-pointer disabled:opacity-70 disabled:cursor-wait">
                                                    <svg x-show="submitting" x-cloak class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                    </svg>
                                                    <span x-text="submitting ? 'Mengirim...' : 'Ya, Kumpulkan Ujian'"></span>
                                                </button>
                                                <button type="button" @click="showSubmitModal = false" :disabled="submitting" class="w-full inline-flex justify-center items-center rounded-xl bg-white px-4 py-3 text-sm font-bold text-slate-700 border border-slate-200 hover:bg-slate-50 transition cursor-pointer disabled:opacity-50">
                                                    Periksa Kembali
                                                </button>
                                            </div>
                                            <p x-show="submitting" x-cloak class="mt-3 text-center text-xs font-semibold text-emerald-700">
                                                Jawaban sedang dikirim, mohon tunggu dan jangan tutup halaman ini...
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Vocabulary Assistant Modal -->
                        <div x-show="showVocabModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" role="dialog" aria-modal="true">
                            <div x-show="showVocabModal"
                                 x-transition:enter="ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
                                 @click="showVocabModal = false"></div>

                            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                    <div x-show="showVocabModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         class="relative transform overflow-hidden rounded-3xl bg-white px-6 pb-6 pt-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-slate-200">
                                        
                                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-100">
                                                    📚
                                                </div>
                                                <div>
                                                    <h3 class="text-base font-bold text-slate-900">Bantuan Kosakata Akademik (Vocabulary Assistance)</h3>
                                                    <p class="text-xs text-slate-500">Daftar istilah dan frasa kunci yang dapat membantu terjemahan Anda.</p>
                                                </div>
                                            </div>
                                            <button type="button" @click="showVocabModal = false" class="text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-100 transition cursor-pointer">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>

                                        <!-- Filter Tabs -->
                                        <div class="mt-4 flex flex-wrap gap-2 border-b border-slate-100 pb-3">
                                            <button type="button" @click="vocabActiveTab = 'all'" :class="vocabActiveTab === 'all' ? 'bg-blue-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'" class="rounded-xl px-3.5 py-1.5 text-xs transition cursor-pointer">
                                                Semua Kosakata (All)
                                            </button>
                                            @foreach($testData['paragraphs'] as $pNum => $paragraph)
                                                <button type="button" @click="vocabActiveTab = 'p' + {{ $pNum }}" :class="vocabActiveTab === ('p' + {{ $pNum }}) ? 'bg-blue-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'" class="rounded-xl px-3.5 py-1.5 text-xs transition cursor-pointer">
                                                    Paragraf {{ $pNum }}
                                                </button>
                                            @endforeach
                                        </div>

                                        <div class="mt-4 max-h-[60vh] overflow-y-auto space-y-4 pr-1 custom-scrollbar">
                                            @if(!empty($testData['paragraphs']))
                                                @foreach($testData['paragraphs'] as $pNum => $paragraph)
                                                    @php
                                                        $cleanTitle = preg_replace('/^Paragraf\s*\d+\s*:\s*/i', '', $paragraph['title']);
                                                    @endphp
                                                    <div x-show="vocabActiveTab === 'all' || vocabActiveTab === 'p' + {{ $pNum }}" class="space-y-2">
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Paragraf {{ $pNum }}: {{ $cleanTitle }}</span>
                                                        </div>
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                            @foreach($paragraph['vocab'] as $vEn => $vId)
                                                                <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-3 flex flex-col justify-between hover:bg-white hover:border-slate-300 transition shadow-2xs">
                                                                    <div class="flex items-start justify-between gap-1">
                                                                        <p class="text-xs font-bold text-blue-900 font-mono">{{ $vEn }}</p>
                                                                        <span class="text-[10px] font-bold text-slate-400 font-mono">{{ $vId['pos'] }}</span>
                                                                    </div>
                                                                    <p class="text-xs text-slate-600 mt-1">{{ $vId['id'] }}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                        <!-- Admin Model Answer & 10 Modules Modal -->
                        <div x-show="showAdminModelModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" role="dialog" aria-modal="true">
                            <div x-show="showAdminModelModal"
                                 x-transition:enter="ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity"
                                 @click="showAdminModelModal = false"></div>

                            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                    <div x-show="showAdminModelModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         class="relative transform overflow-hidden rounded-3xl bg-white px-6 pb-6 pt-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-indigo-200">
                                        
                                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold text-lg">
                                                    👑
                                                </div>
                                                <div>
                                                    <h3 class="text-base font-bold text-slate-900">Kunci Jawaban Model &amp; {{ count($testData['modules_covered'] ?? []) }} Modul {{ $testData['title'] ?? 'Grammar for Writing' }}</h3>
                                                    <p class="text-xs text-slate-500">Referensi standar evaluasi akademik untuk para evaluator &amp; administrator.</p>
                                                </div>
                                            </div>
                                            <button type="button" @click="showAdminModelModal = false" class="text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-100 transition cursor-pointer">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>

                                        <!-- Model Paragraphs List -->
                                        <div class="mt-4 max-h-[65vh] overflow-y-auto space-y-6 pr-1 custom-scrollbar">
                                            @if(!empty($testData['paragraphs']))
                                                @foreach($testData['paragraphs'] as $pNum => $p)
                                                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4 space-y-3">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center gap-2">
                                                                <span class="rounded-lg bg-indigo-600 text-white font-bold text-xs px-2 py-0.5">Paragraf {{ $pNum }}</span>
                                                                <h4 class="text-xs font-bold text-slate-900">{{ $p['title'] }}</h4>
                                                            </div>
                                                            <span class="text-[11px] text-slate-400 font-medium">Fokus: {{ $p['focus'] }}</span>
                                                        </div>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                                                            <div class="rounded-xl bg-white border border-slate-200 p-3 space-y-1">
                                                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Naskah Asli (ID)</span>
                                                                <p class="text-slate-700 leading-relaxed font-serif">{{ $p['text_id'] }}</p>
                                                            </div>
                                                            <div class="rounded-xl bg-emerald-50/50 border border-emerald-200 p-3 space-y-1">
                                                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Model Translation (EN)</span>
                                                                <p class="text-emerald-950 font-sans leading-relaxed">{{ $p['text_en'] }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                            <!-- 10 Modul Matrix Reference -->
                                            @if(!empty($testData['modules_covered']))
                                                <div class="rounded-2xl border border-slate-200 bg-white p-4 space-y-3">
                                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600">Daftar Modul Evaluasi ({{ count($testData['modules_covered'] ?? []) }} Modul)</h4>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                        @foreach($testData['modules_covered'] as $m)
                                                            <div class="flex items-center gap-2 rounded-xl border border-slate-100 bg-slate-50 p-2.5 text-xs">
                                                                <span class="rounded-md bg-indigo-50 border border-indigo-200 text-indigo-700 font-mono font-bold px-2 py-0.5 text-[11px]">
                                                                    {{ $m['tag'] }}
                                                                </span>
                                                                <span class="font-semibold text-slate-800">{{ $m['name'] }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-6 flex justify-between items-center border-t border-slate-100 pt-4">
                                            <a href="{{ route('admin.final-test-results.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                                                <span>Ke Halaman Semua Hasil Final Test &rarr;</span>
                                            </a>
                                            <button type="button" @click="showAdminModelModal = false" class="rounded-xl bg-slate-900 px-5 py-2 text-xs font-bold text-white hover:bg-slate-800 transition cursor-pointer">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
@else
                    <!-- Fallback Room for non-Grammar for Writing programs -->
                    <section class="grid grid-cols-1 gap-4 lg:grid-cols-[1.4fr_0.6fr]">
                        <article class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="absolute inset-x-0 top-0 h-1 {{ $accent['line'] }}"></div>
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border {{ $accent['soft'] }}">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-950">Assessment Room</h2>
                                        <p class="mt-1 text-sm text-slate-600">Halaman ini sudah terpisah dari Assignment dan memakai route final test khusus.</p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('final-test.complete', array_filter(['program' => $program, 'variant' => $variant])) }}" class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                    @csrf
                                    <input type="hidden" name="score" value="100">
                                    <input type="hidden" name="time_spent_seconds" value="0">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">Finish Final Test</p>
                                            <p class="mt-0.5 text-xs text-slate-500">Kumpulkan ujian untuk memproses hasil penilaian dan sertifikat resmi.</p>
                                        </div>
                                        <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl px-5 text-xs font-bold text-white shadow-sm transition {{ $accent['button'] }} cursor-pointer">
                                            Submit Final Test
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </article>
                    </section>
                @endif
            </div>
        </main>
    </div>

    @if($program === 'grammar-for-writing')
        @php
            $toolbarPrompt = strip_tags($testData['full_text_id'] ?? ($testData['paragraphs'][1]['text_id'] ?? 'Grammar for Writing Final Test'));
            $toolbarMeeting = (object) [
                'task_type' => 2,
                'prompt' => $toolbarPrompt,
                'topic' => 'Grammar for Writing: Final Test',
            ];
        @endphp
        @include('assignments.ielts.writing.practice_toolbar', [
            'meeting' => $toolbarMeeting,
            'task' => 2,
            'hideCollocations' => true,
            'hideIdioms' => true,
            'hideIdeas' => true,
            'hideMagicSentence' => true,
            'hideCollocationDictionary' => true,
        ])
    @endif

    <x-live-drawing />
</body>
</html>
