@extends('layouts.admin')

@section('title', 'Hasil Evaluation IELTS Writing - ' . ($meeting->title ?? 'Practice'))

@section('head')
    <style>
        ins { background-color: #dcfce7; color: #15803d; padding: 2px 6px; border-radius: 4px; font-weight: 700; text-decoration: none; display: inline-block; margin: 1px 0; border: 1px solid #bbf7d0; }
        del { background-color: #fee2e2; color: #b91c1c; padding: 2px 6px; border-radius: 4px; text-decoration: line-through; font-weight: 600; display: inline-block; margin: 1px 0; border: 1px solid #fecaca; }
        .pdf-paper-sheet { position: relative; width: 100%; min-height: 0 !important; height: auto !important; box-sizing: border-box; }
        .canvas-overlay-container { position: relative; width: 100%; min-height: 0 !important; height: auto !important; margin-top: 0 !important; padding-top: 0 !important; }
        .rendered-canvas-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 20; object-fit: fill; }
        .student-essay-text-box { position: relative; z-index: 1; min-height: 0 !important; height: auto !important; margin-top: 0 !important; padding-top: 0 !important; white-space: pre-wrap; word-break: break-word; }
        .student-essay-text-box > *:first-child { margin-top: 0 !important; padding-top: 0 !important; }
        .student-essay-text-box p { margin-bottom: 1em; }
        @media print {
            header, nav, aside, .sidebar, a[href*="ielts-academic"], button, .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .pdf-paper-sheet { box-shadow: none !important; border: 1px solid #ccc !important; max-width: 100% !important; }
        }
    </style>
@endsection

@section('content')
@php
    $scores = $submission->scores ?? [];
    $meeting = $submission->meeting;
    $overallBand = $scores['overall_band_score'] ?? $scores['overall_band'] ?? '-';
    $taskScore = $scores['task_achievement_score'] ?? $scores['task_response_score'] ?? $scores['task_achievement'] ?? '-';
    $cohesionScore = $scores['coherence_cohesion_score'] ?? $scores['coherence_cohesion'] ?? '-';
    $lexicalScore = $scores['lexical_resource_score'] ?? $scores['lexical_resource'] ?? '-';
    $grammarScore = $scores['grammatical_range_score'] ?? $scores['grammatical_range'] ?? '-';
    $wordCount = str_word_count(strip_tags($submission->essay));
    $teacherCorrection = $scores['teacher_correction_html'] ?? null;
    $canvasOverlayImg = $scores['annotation_canvas_data'] ?? null;
@endphp

<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 py-8">

    <!-- Header Banner -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic') }}"
               class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-white transition-colors shadow-sm flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-white text-blue-800">
                        IELTS Writing Task {{ $submission->task_type }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-white text-purple-800">
                        Submission Result
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mt-1">
                    Hasil Pengerjaan Writing Student
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>🖨️ Cetak / Unduh PDF</span>
            </button>
            <a href="{{ url()->current() }}" class="px-4 py-2 bg-white border border-gray-200 hover:bg-white text-gray-700 font-semibold text-xs rounded-xl shadow-sm transition">
                ↻ Refresh Hasil
            </a>
        </div>
    </div>

    <!-- Student & Score Summary Banner Card -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-purple-950 rounded-2xl p-6 text-white shadow-xl mb-8 flex flex-wrap items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xl font-extrabold text-white shrink-0 shadow-lg">
                {{ strtoupper(substr($submission->user->name ?? 'S', 0, 2)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">{{ $submission->user->name ?? 'Student' }}</h2>
                <p class="text-sm text-slate-300 mt-0.5">{{ $submission->user->email ?? '' }}</p>
                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-300">
                    <span>Meeting: <strong>{{ $meeting->title ?? 'IELTS Writing Practice' }}</strong></span>
                    <span>•</span>
                    <span>Waktu Submit: <strong>{{ $submission->created_at ? $submission->created_at->format('d M Y H:i') : '-' }}</strong></span>
                    <span>•</span>
                    <span>Jumlah Kata: <strong>{{ $wordCount }} Kata</strong></span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6 bg-white/10 border border-white/15 rounded-2xl px-6 py-3.5 backdrop-blur-md">
            <div class="text-center px-2">
                <div class="text-xs uppercase tracking-wider text-slate-300 font-bold">Overall Band AI</div>
                <div class="text-3xl font-black text-amber-400 mt-0.5">{{ $overallBand }}</div>
            </div>
            @if($submission->teacher_score)
                <div class="w-px h-10 bg-white/20"></div>
                <div class="text-center px-2">
                    <div class="text-xs uppercase tracking-wider text-emerald-200 font-bold">Nilai Pengajar</div>
                    <div class="text-3xl font-black text-emerald-400 mt-0.5">{{ number_format($submission->teacher_score, 1) }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Pending Teacher Evaluation Notice (if AI is disabled) -->
    @if($submission->evaluation_status === 'pending_teacher' || ($overallBand === '-' && !$submission->teacher_feedback))
        <div class="bg-white border border-amber-200 rounded-2xl p-5 mb-8 shadow-sm flex items-center gap-4 text-amber-900">
            <span class="p-3 bg-amber-500 text-white rounded-2xl text-xl font-bold shrink-0 shadow-sm">✏️</span>
            <div>
                <h3 class="text-sm font-extrabold text-amber-950 uppercase tracking-wider">Penilaian Manual & Coret-Coret Guru Aktif</h3>
                <p class="text-xs text-amber-800 mt-1 font-medium leading-relaxed">
                    Fitur penilaian AI saat ini sedang dinonaktifkan oleh Pengajar. Lembar tulisan Anda telah tersimpan dan sedang dalam antrean pemeriksaan & coret-coret langsung dari Teacher.
                </p>
            </div>
        </div>
    @endif

    <!-- Teacher Feedback Alert Card (if reviewed) -->
    @if($submission->teacher_feedback || $submission->teacher_score || $teacherCorrection || $canvasOverlayImg)
        <div class="bg-gradient-to-r from-purple-50 via-indigo-50 to-blue-50 border border-purple-200 rounded-2xl p-6 mb-8 shadow-md">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-purple-600 text-white rounded-2xl shadow-md shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <h3 class="text-lg font-bold text-purple-950">Catatan & Evaluasi Resmi dari Pengajar</h3>
                        @if($submission->reviewed_at)
                            <span class="text-xs text-purple-700 font-bold bg-white/80 px-3 py-1 rounded-full border border-purple-200 shadow-sm">
                                Diperiksa oleh {{ $submission->reviewer->name ?? 'Teacher' }} • {{ $submission->reviewed_at->format('d M Y H:i') }}
                            </span>
                        @endif
                    </div>

                    @if($submission->teacher_score)
                        <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 bg-purple-200 text-purple-900 rounded-lg text-sm font-bold">
                            <span>Nilai Akhir Pengajar:</span>
                            <span class="text-base text-purple-950 font-extrabold">{{ number_format($submission->teacher_score, 1) }} / 9.0</span>
                        </div>
                    @endif

                    @if($submission->teacher_feedback)
                        <div class="mt-3 text-sm text-purple-950 leading-relaxed bg-white/90 p-4 rounded-xl border border-purple-200 shadow-sm font-medium">
                            {!! nl2br(e($submission->teacher_feedback)) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Score Breakdown Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-gray-200 border-t-4 border-t-blue-500 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Task {{ $submission->task_type == 1 ? 'Achievement' : 'Response' }}</span>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-3xl font-extrabold text-blue-600">{{ $taskScore }}</span>
                <span class="text-xs font-semibold text-gray-400">/ 9.0</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 border-t-4 border-t-purple-500 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Coherence & Cohesion</span>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-3xl font-extrabold text-purple-600">{{ $cohesionScore }}</span>
                <span class="text-xs font-semibold text-gray-400">/ 9.0</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 border-t-4 border-t-emerald-500 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Lexical Resource</span>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-3xl font-extrabold text-emerald-600">{{ $lexicalScore }}</span>
                <span class="text-xs font-semibold text-gray-400">/ 9.0</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 border-t-4 border-t-amber-500 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Grammatical Range</span>
            <div class="flex items-baseline justify-between mt-3">
                <span class="text-3xl font-extrabold text-amber-600">{{ $grammarScore }}</span>
                <span class="text-xs font-semibold text-gray-400">/ 9.0</span>
            </div>
        </div>
    </div>

    <!-- Section 1 (Full Width): Topic / Prompt Card -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-8">
        <div class="flex items-center gap-2 mb-3">
            <span class="text-xs font-bold text-indigo-700 uppercase tracking-wider bg-white border border-indigo-100 px-2.5 py-1 rounded-md">
                TOPIC PROMPT
            </span>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $meeting->title ?? 'Writing Task' }}</h4>
        <div class="text-sm text-gray-700 bg-white p-4 rounded-xl border border-gray-100 leading-relaxed font-medium">
            {!! nl2br(e($meeting->prompt ?? 'Task prompt content')) !!}
        </div>
        @php
            $promptImage = $meeting->image ?? null;
            if (!$promptImage && !empty($meeting->title) && str_contains(strtolower($meeting->title), 'glass container')) {
                $promptImage = 'images/practice/glass_container_production.png';
            }
        @endphp
        @if($promptImage)
            <div class="mt-4 p-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex justify-center">
                <img src="{{ asset($promptImage) }}" alt="{{ $meeting->title ?? 'Topic Image' }}" class="max-w-full h-auto rounded-lg object-contain max-h-[400px]">
            </div>
        @endif
    </div>

    <!-- Section 2 (Full Width): Student Submitted Essay with Teacher Coretan & Annotations Overlay -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-8">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Hasil Tulisan & Coretan Evaluasi Teacher</span>
            </h3>
            <span class="text-xs font-bold px-3 py-1 bg-white text-gray-700 border border-gray-200 rounded-full">
                {{ $wordCount }} Kata
            </span>
        </div>

        <!-- A4 PDF Paper Sheet Document Container (Constant PDF Sheet) -->
        <div class="bg-white p-4 sm:p-6 rounded-xl border border-gray-200 shadow-inner flex justify-center overflow-x-auto">
            <div class="canvas-overlay-container pdf-paper-sheet relative bg-white text-gray-900 shadow-xl rounded-sm border border-gray-300 p-6 sm:p-10 w-full max-w-[850px]">
                
                <!-- A4 PDF Header Banner -->
                <div class="border-b-2 border-gray-900 pb-2 mb-2 flex items-center justify-between gap-4 select-none">
                    <div>
                        <h3 class="font-serif text-base sm:text-lg font-bold text-gray-900 tracking-wider uppercase">IELTS WRITING RESPONSE SHEET</h3>
                        <p class="text-xs font-mono text-gray-500 mt-0.5">
                            Student: <strong>{{ $submission->user->name ?? 'Student' }}</strong> • Task {{ $submission->task_type }} • {{ $wordCount }} Words
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] font-mono font-bold px-2.5 py-1 bg-white rounded border border-slate-300 text-slate-700">
                            EVALUATED SHEET
                        </span>
                    </div>
                </div>

                <div class="canvas-overlay-container" style="position: relative !important; margin: 0 !important; padding: 0 !important; min-height: 0 !important; display: block !important;">
                    @if($canvasOverlayImg)
                        <!-- Render Teacher Canvas Drawing Overlay -->
                        <img src="{{ $canvasOverlayImg }}" alt="Coretan Teacher" class="rendered-canvas-img" style="position: absolute !important; top: 0 !important; left: 0 !important; width: 100% !important; height: 100% !important; z-index: 20; object-fit: fill; margin: 0 !important; padding: 0 !important;">
                    @endif

                    <!-- Student Essay Text rendered directly inside the A4 PDF Paper Sheet -->
                    <div class="student-essay-text-box font-serif text-base sm:text-lg leading-loose text-gray-900 font-normal w-full" style="position: relative !important; z-index: 10 !important; margin: 0 !important; padding: 0 !important; min-height: 0 !important; display: block !important;">
                        @if($teacherCorrection)
                            {!! $teacherCorrection !!}
                        @else
                            @foreach(explode("\n", $submission->essay) as $paragraph)
                                @if(strlen($paragraph) > 0)
                                    <p class="mb-4 text-justify leading-relaxed">{{ $paragraph }}</p>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- A4 PDF Footer Banner -->
                <div class="border-t border-gray-300 pt-3 mt-6 flex items-center justify-between text-xs text-gray-400 font-mono select-none">
                    <span>Target Bahasa IELTS Writing Evaluation Suite</span>
                    <span>Page 1 of 1</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: AI Analysis Grid (2 Columns Below) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Overall Comment -->
            @if(!empty($scores['overall_comment']))
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Evaluasi & Masukan Umum AI</span>
                    </h3>
                    <p class="text-sm text-gray-800 leading-relaxed bg-white p-4 rounded-xl border border-indigo-100 font-medium">
                        {{ $scores['overall_comment'] }}
                    </p>
                </div>
            @endif

            <!-- Detailed Criteria Feedback -->
            @if(isset($scores['feedback']) && is_array($scores['feedback']))
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2 2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span>Rincian Evaluasi per Kriteria</span>
                    </h3>

                    @if(!empty($scores['feedback']['task_achievement']) || !empty($scores['feedback']['task_response']))
                        <div>
                            <h4 class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1">Task {{ $submission->task_type == 1 ? 'Achievement' : 'Response' }}</h4>
                            <div class="text-sm text-gray-800 bg-white p-4 rounded-xl border border-blue-100 leading-relaxed">
                                {!! $scores['feedback']['task_achievement'] ?? $scores['feedback']['task_response'] !!}
                            </div>
                        </div>
                    @endif

                    @if(!empty($scores['feedback']['coherence_cohesion']))
                        <div>
                            <h4 class="text-xs font-bold text-purple-700 uppercase tracking-wider mb-1">Coherence & Cohesion</h4>
                            <div class="text-sm text-gray-800 bg-white p-4 rounded-xl border border-purple-100 leading-relaxed">
                                {!! $scores['feedback']['coherence_cohesion'] !!}
                            </div>
                        </div>
                    @endif

                    @if(!empty($scores['feedback']['lexical_resource']))
                        <div>
                            <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-1">Lexical Resource</h4>
                            <div class="text-sm text-gray-800 bg-white p-4 rounded-xl border border-emerald-100 leading-relaxed">
                                {!! $scores['feedback']['lexical_resource'] !!}
                            </div>
                        </div>
                    @endif

                    @if(!empty($scores['feedback']['grammatical_range']))
                        <div>
                            <h4 class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Grammatical Range</h4>
                            <div class="text-sm text-gray-800 bg-white p-4 rounded-xl border border-amber-100 leading-relaxed">
                                {!! $scores['feedback']['grammatical_range'] !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- AI Text Correction Highlight -->
            @if(!empty($scores['correction_html']))
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span>Teks Hasil Koreksi AI (Diff / Highlighting)</span>
                    </h3>
                    <div class="bg-white p-5 rounded-xl border border-amber-200 text-sm text-gray-900 leading-relaxed whitespace-pre-wrap">
                        {!! $scores['correction_html'] !!}
                    </div>
                </div>
            @endif

            <!-- Band 9 Model Answer -->
            @if(!empty($scores['better_version']) || !empty($scores['band_9_version']))
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        <span>Contoh Model Band 9</span>
                    </h3>
                    <div class="bg-white p-5 rounded-xl border border-emerald-200 text-sm text-emerald-950 leading-relaxed whitespace-pre-wrap font-sans">
                        {!! $scores['better_version'] ?? $scores['band_9_version'] !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
