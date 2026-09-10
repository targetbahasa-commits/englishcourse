<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Detail Nilai & Koreksi Guru</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .word-diff .word-correct { color: #2ecc71; font-weight: bold; }
        .word-diff .word-extra { color: #3498db; font-weight: bold; text-decoration: line-through; }
        .word-diff .word-missing { color: #f1c40f; font-weight: bold; }
        .word-diff .word-wrong { color: #e74c3c; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-8">
            <div class="max-w-3xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <a href="{{ route('assignments.grammar-writing.my-scores') }}" class="text-sm text-indigo-600 hover:underline flex items-center gap-1 mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m0 7h18"></path></svg>
                            Kembali ke daftar nilai
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">
                            <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-white text-slate-700 align-middle mr-1">{{ $trackLabel ?? 'Program' }}</span>
                            Meeting {{ $meetingScore->meeting_number }}
                        </h1>
                        <p class="text-sm text-gray-500">Submit {{ $meetingScore->submitted_at ? $meetingScore->submitted_at->format('d M Y H:i') : '-' }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 uppercase font-bold">Skor Otomatis</div>
                        <div class="text-3xl font-black text-amber-600">{{ $meetingScore->score }}</div>
                    </div>
                </div>

                @php
                    $evalImg1 = storage_path('app/public/evaluations/eval_' . $meetingScore->id . '.png');
                    $evalImg2 = storage_path('app/public/evaluations/eval_' . $meetingScore->user_id . '_' . $meetingScore->program_id . '_' . $meetingScore->meeting_number . '.png');
                    $evalImg3 = storage_path('app/public/evaluations/eval_user_' . $meetingScore->user_id . '_m_' . $meetingScore->meeting_number . '.png');
                    $hasEvalPdf = file_exists($evalImg1) || file_exists($evalImg2) || file_exists($evalImg3);
                @endphp

                @if($hasEvalPdf)
                    <div class="mb-6 bg-gradient-to-r from-emerald-600 to-teal-700 text-white rounded-2xl p-5 shadow-lg flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-extrabold text-base flex items-center gap-2">
                                <span>📄</span> Hasil Coret-Coret Evaluasi Guru Tersedia!
                            </h3>
                            <p class="text-xs text-emerald-100 mt-1">Pengajar telah memeriksa dan memberikan coretan evaluasi pada tugas Anda. Silakan unduh dokumen PDF di bawah.</p>
                        </div>
                        <a href="{{ route('assignments.grammar-writing.download-evaluation-pdf', $meetingScore->id) }}" 
                           class="px-4 py-2.5 bg-white text-emerald-800 font-bold rounded-xl text-xs hover:bg-emerald-50 shadow-sm transition flex items-center gap-1.5 shrink-0 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M7 10l5 5 5-5M12 15V3"></path></svg>
                            <span>Unduh PDF Evaluasi</span>
                        </a>
                    </div>
                @endif

                @if($meetingScore->reviewed_at)
                    <div class="mb-6 bg-white border border-purple-200 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-sm font-bold text-purple-800 uppercase tracking-wide">Catatan &amp; Evaluasi Pengajar</h2>
                            @if($meetingScore->teacher_score !== null)
                                <span class="inline-block px-3 py-1 rounded-lg text-lg font-extrabold bg-white text-purple-900 border border-purple-200">
                                    {{ number_format($meetingScore->teacher_score, 1) }}
                                </span>
                            @endif
                        </div>
                        @if($meetingScore->teacher_feedback)
                            <p class="text-gray-700 text-sm whitespace-pre-line leading-relaxed">{{ $meetingScore->teacher_feedback }}</p>
                        @else
                            <p class="text-gray-500 text-sm italic">Tidak ada catatan tertulis dari pengajar.</p>
                        @endif
                        <p class="text-xs text-purple-600 mt-3">Direview oleh {{ $meetingScore->reviewer->name ?? 'Pengajar' }} &middot; {{ $meetingScore->reviewed_at->format('d M Y H:i') }}</p>
                    </div>
                @else
                    <div class="mb-6"
                         x-data="{
                            hasDraft: false,
                            teacherScore: null,
                            teacherFeedback: '',
                            lastTime: 0,
                            pollTimer: null,
                            async poll() {
                                try {
                                    const res = await fetch('{{ route('api.submission-review.fetch', $meetingScore->id) }}?last_time=' + this.lastTime, { headers: { 'Accept': 'application/json' } });
                                    const data = await res.json();
                                    if (!data.success) return;
                                    if (data.reviewed) { clearInterval(this.pollTimer); window.location.reload(); return; }
                                    if (data.time) this.lastTime = data.time;
                                    if (data.teacher_score !== undefined && data.teacher_score !== null) { this.teacherScore = data.teacher_score; this.hasDraft = true; }
                                    if (data.teacher_feedback) { this.teacherFeedback = data.teacher_feedback; this.hasDraft = true; }
                                } catch (e) {}
                            }
                         }"
                         x-init="pollTimer = setInterval(() => poll(), 1500)"
                    >
                        <div x-show="hasDraft" class="bg-white border border-red-200 rounded-2xl p-6 mb-3">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                <h2 class="text-sm font-bold text-red-600 uppercase tracking-wide">Guru sedang mengoreksi...</h2>
                                <span x-show="teacherScore !== null" class="ml-auto px-3 py-1 rounded-lg text-lg font-extrabold bg-red-50 text-red-700 border border-red-200" x-text="teacherScore"></span>
                            </div>
                            <p class="text-gray-700 text-sm whitespace-pre-line leading-relaxed" x-text="teacherFeedback || '(belum ada catatan tertulis)'"></p>
                        </div>
                        <div x-show="!hasDraft" class="bg-white border border-amber-200 rounded-2xl p-4 text-sm text-amber-800 font-medium">
                            ⏳ Menunggu koreksi dari pengajar. Nilai di atas adalah hasil penilaian otomatis sementara.
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4">Rincian Jawaban</h2>

                    @if(!empty($meetingScore->answers_data))
                        @include('partials.grammar-writing-answers-tree', ['data' => $meetingScore->answers_data])
                    @else
                        <div class="p-6 text-center text-gray-400 text-sm bg-white rounded-xl border border-dashed border-gray-200">
                            Rincian jawaban tidak tersedia untuk submission ini.
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
