@extends('layouts.admin')

@section('title', 'Pemeriksaan IELTS Writing Student - ' . ($submission->user->name ?? 'Student'))

@push('styles')
    <style>
        ins { background-color: #dcfce7; color: #15803d; padding: 2px 6px; border-radius: 4px; font-weight: 700; text-decoration: none; display: inline-block; margin: 1px 0; border: 1px solid #bbf7d0; }
        del { background-color: #fee2e2; color: #b91c1c; padding: 2px 6px; border-radius: 4px; text-decoration: line-through; font-weight: 600; display: inline-block; margin: 1px 0; border: 1px solid #fecaca; }
        .pdf-paper-sheet { position: relative; width: 100%; min-height: 0 !important; height: auto !important; box-sizing: border-box; }
        .canvas-overlay-container { position: relative; width: 100%; min-height: 0 !important; height: auto !important; margin-top: 0 !important; padding-top: 0 !important; }
        .annotation-canvas { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 30; cursor: crosshair; touch-action: none; pointer-events: auto; }
        .annotation-canvas.disabled { pointer-events: none !important; cursor: default; }
        .student-essay-text-box { position: relative; z-index: 1; min-height: 0 !important; height: auto !important; margin-top: 0 !important; padding-top: 0 !important; white-space: pre-wrap; word-break: break-word; }
        .student-essay-text-box > *:first-child { margin-top: 0 !important; padding-top: 0 !important; }
        .student-essay-text-box p { margin-bottom: 1em; }
        .stamp-badge-btn { cursor: pointer; transition: all 0.15s ease; user-select: none; }
        .stamp-badge-btn:hover { transform: translateY(-1px); filter: brightness(1.05); }
        .stamp-badge-btn:active { transform: translateY(0); }
    </style>
@endpush

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
    $savedCanvasData = $scores['annotation_canvas_data'] ?? '';
    $savedTeacherCorrection = $scores['teacher_correction_html'] ?? $submission->essay;
    $criterionFeedback = $scores['feedback'] ?? [];
    $taskFeedback = $criterionFeedback['task_achievement'] ?? $criterionFeedback['task_response'] ?? '';
    $cohesionFeedback = $criterionFeedback['coherence_cohesion'] ?? '';
    $lexicalFeedback = $criterionFeedback['lexical_resource'] ?? '';
    $grammarFeedback = $criterionFeedback['grammatical_range'] ?? '';
@endphp

<div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 py-4 pb-28"
     x-data="writingAnnotatorApp({
         essayText: @js($submission->essay),
         savedCorrection: @js($savedTeacherCorrection),
         savedCanvas: @js($savedCanvasData),
         taskScore: @js(old('task_achievement_score', is_numeric($taskScore) ? (float) $taskScore : null)),
         cohesionScore: @js(old('coherence_cohesion_score', is_numeric($cohesionScore) ? (float) $cohesionScore : null)),
         lexicalScore: @js(old('lexical_resource_score', is_numeric($lexicalScore) ? (float) $lexicalScore : null)),
         grammarScore: @js(old('grammatical_range_score', is_numeric($grammarScore) ? (float) $grammarScore : null))
     })">

    @if(session('success'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm text-sm">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <div class="font-semibold">{{ session('success') }}</div>
        </div>
    @endif

    <!-- Header Navigation & Student Overview (Compact Single Banner) -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm mb-4 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.writing-practice-submissions.index') }}"
               class="p-2 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h1 class="text-lg font-bold text-gray-900">
                        Pemeriksaan Submission IELTS Writing Student - {{ $submission->user->name ?? 'Student' }}
                    </h1>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                        Task {{ $submission->task_type }}
                    </span>
                    <span class="text-xs text-gray-500 font-medium">
                        {{ $meeting->title ?? 'Writing Practice' }} • {{ $submission->created_at ? $submission->created_at->format('d M Y H:i') : '' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- AI Evaluation Toggle Switch (Admin & Teacher) -->
            <div x-data="{
                    aiEnabled: @js($aiEnabled ?? true),
                    loading: false,
                    async toggleAi() {
                        if (this.loading) return;
                        this.loading = true;
                        try {
                            const res = await fetch('{{ route('admin.writing-practice-submissions.toggle-ai') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ enabled: !this.aiEnabled })
                            });
                            const data = await res.json();
                            if (res.ok && data.status === 'success') {
                                this.aiEnabled = data.ai_enabled;
                                alert(data.message);
                            } else {
                                alert('Gagal mengubah mode penilaian AI.');
                            }
                        } catch(e) {
                            console.error(e);
                            alert('Terjadi kesalahan jaringan.');
                        } finally {
                            this.loading = false;
                        }
                    }
                }" class="flex items-center gap-2.5 bg-slate-50 border border-slate-200 rounded-lg px-3 py-1 text-xs">
                <span class="font-bold text-gray-700">🤖 AI Penilaian:</span>
                <span x-text="aiEnabled ? 'ON' : 'OFF'" :class="aiEnabled ? 'text-emerald-700 bg-emerald-100 border border-emerald-200' : 'text-amber-700 bg-amber-100 border border-amber-200'" class="px-1.5 py-0.5 rounded font-black text-[11px]"></span>
                <button type="button" @click="toggleAi()" :disabled="loading"
                        class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                        :class="aiEnabled ? 'bg-emerald-500' : 'bg-slate-400'">
                    <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                          :class="aiEnabled ? 'translate-x-4' : 'translate-x-0'"></span>
                </button>
            </div>

            <div class="flex items-center gap-4 bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-xs">
                <div>AI Overall: <strong class="text-amber-600 font-extrabold text-sm ml-1">{{ $overallBand }}</strong></div>
                <div class="w-px h-4 bg-slate-300"></div>
                <div>Nilai Guru: <strong class="text-emerald-600 font-extrabold text-sm ml-1">{{ $submission->teacher_score ? number_format($submission->teacher_score, 1) : '-' }}</strong></div>
            </div>

            <a href="{{ route('assignments.ielts-academic.writing.submission.show', $submission->id) }}" target="_blank"
               class="px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold text-xs rounded-lg shadow-sm transition">
                Preview Student
            </a>

            <button onclick="retryAiEvaluation({{ $submission->id }}, this)"
                    class="px-3 py-1.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-lg shadow-sm transition cursor-pointer">
                Kirim Ulang AI
            </button>
        </div>
    </div>

    <!-- Topic Prompt Card (Compact) -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm mb-4" x-data="{ showPromptText: true }">
        <div class="flex items-center justify-between gap-2 cursor-pointer" @click="showPromptText = !showPromptText">
            <div class="flex items-center gap-2">
                <span class="text-[11px] font-bold text-indigo-700 uppercase tracking-wider bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded">
                    TOPIC PROMPT
                </span>
                <h4 class="text-sm font-bold text-gray-900">{{ $meeting->title ?? 'IELTS Writing Task ' . $submission->task_type }}</h4>
            </div>
            <button type="button" class="text-xs text-indigo-600 font-bold hover:underline">
                <span x-text="showPromptText ? 'Sembunyikan Soal ▲' : 'Tampilkan Soal ▼'"></span>
            </button>
        </div>

        <div x-show="showPromptText" x-transition class="mt-3 pt-3 border-t border-gray-100">
            <div class="text-xs text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-200 leading-relaxed font-medium">
                {!! nl2br(e($meeting->prompt ?? 'Prompt text')) !!}
            </div>
            @php
                $promptImage = $meeting->image ?? null;
                if (!$promptImage && !empty($meeting->title) && str_contains(strtolower($meeting->title), 'glass container')) {
                    $promptImage = 'images/practice/glass_container_production.png';
                }
            @endphp
            @if($promptImage)
                <div class="mt-3 p-2 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden flex justify-center">
                    <img src="{{ asset($promptImage) }}" alt="{{ $meeting->title ?? 'Topic Image' }}" class="max-w-full h-auto rounded object-contain max-h-[220px]">
                </div>
            @endif
        </div>
    </div>

    <!-- Student Essay Card & Interactive Annotator Canvas Overlay (A4 PDF Paper Sheet) -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm relative overflow-hidden mb-4">
        <div class="flex flex-wrap items-center justify-between mb-3 pb-2 border-b border-gray-100 gap-2">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Jawaban Student & Lembar PDF Coretan</span>
                </h3>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="editMode = 'text'"
                        :class="editMode === 'text' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-3 py-1 rounded-lg text-xs font-bold transition">
                    ✏️ Koreksi Teks
                </button>
                <button type="button" @click="editMode = 'draw'"
                        :class="editMode === 'draw' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-3 py-1 rounded-lg text-xs font-bold transition">
                    🎨 Mode Canvas Coret-Coret
                </button>
                <span class="text-xs font-bold px-2.5 py-1 bg-gray-100 text-gray-700 border border-gray-200 rounded-lg">
                    {{ $wordCount }} Kata
                </span>

                <!-- Zoom Controls: scales the whole PDF sheet (text + canvas annotations together) -->
                <div class="flex items-center gap-1 bg-gray-100 border border-gray-200 rounded-lg px-1 py-1" title="Perbesar Lembar (teks + coretan)">
                    <button type="button" @click="zoomOut()" :disabled="zoomLevel <= 50"
                            class="w-6 h-6 flex items-center justify-center rounded-md text-gray-700 hover:bg-gray-200 disabled:opacity-30 disabled:cursor-not-allowed font-bold"
                            title="Perkecil Lembar">
                        −
                    </button>
                    <button type="button" @click="resetZoom()" class="px-1.5 text-xs font-bold text-gray-700 hover:text-indigo-600 tabular-nums" x-text="zoomLevel + '%'" title="Reset Perbesaran Lembar"></button>
                    <button type="button" @click="zoomIn()" :disabled="zoomLevel >= 200"
                            class="w-6 h-6 flex items-center justify-center rounded-md text-gray-700 hover:bg-gray-200 disabled:opacity-30 disabled:cursor-not-allowed font-bold"
                            title="Perbesar Lembar">
                        +
                    </button>
                </div>

                <!-- Text Size Controls: enlarges only the student's answer text, independent of sheet zoom -->
                <div class="flex items-center gap-1 bg-gray-100 border border-gray-200 rounded-lg px-1 py-1" title="Ukuran Teks Jawaban Student">
                    <button type="button" @click="textSizeDown()" :disabled="textSize <= 14"
                            class="w-6 h-6 flex items-center justify-center rounded-md text-gray-700 hover:bg-gray-200 disabled:opacity-30 disabled:cursor-not-allowed text-xs font-black"
                            title="Perkecil Teks">
                        A−
                    </button>
                    <button type="button" @click="resetTextSize()" class="px-1.5 text-xs font-bold text-gray-700 hover:text-indigo-600 tabular-nums" x-text="textSize + 'px'" title="Reset Ukuran Teks"></button>
                    <button type="button" @click="textSizeUp()" :disabled="textSize >= 32"
                            class="w-6 h-6 flex items-center justify-center rounded-md text-gray-700 hover:bg-gray-200 disabled:opacity-30 disabled:cursor-not-allowed text-base font-black"
                            title="Perbesar Teks">
                        A+
                    </button>
                </div>
            </div>
        </div>

        <!-- Text Correction Helper Bar -->
        <div x-show="editMode === 'text'" class="mb-3 p-2.5 bg-indigo-50 border border-indigo-100 rounded-lg text-xs text-indigo-900 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 font-medium">
                <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Sorot/blok kata pada teks untuk mencoret atau memberi perbaikan kata.</span>
            </div>
            <button type="button" @click="resetTextToOriginal()" class="px-2 py-0.5 bg-white border border-indigo-200 hover:bg-indigo-100 text-indigo-700 font-bold rounded shrink-0">
                Reset
            </button>
        </div>

        <!-- A4 PDF Paper Sheet Document Container -->
        <div class="bg-gray-100/90 p-4 sm:p-6 rounded-xl border border-gray-200 shadow-inner flex justify-center overflow-x-auto">
            <div class="pdf-paper-sheet relative bg-white text-gray-900 shadow-xl rounded-sm border border-gray-300 p-6 sm:p-10 w-full max-w-[850px] select-text"
                 :style="`zoom: ${zoomLevel}%;`"
                
                <!-- A4 PDF Header Banner -->
                <div class="border-b-2 border-gray-900 pb-2 mb-2 flex items-center justify-between gap-4 select-none">
                    <div>
                        <h3 class="font-serif text-base sm:text-lg font-bold text-gray-900 tracking-wider uppercase">IELTS WRITING RESPONSE SHEET</h3>
                        <p class="text-xs font-mono text-gray-500 mt-0.5">
                            Student: <strong>{{ $submission->user->name ?? 'Student' }}</strong> • Task {{ $submission->task_type }} • {{ $wordCount }} Words
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] font-mono font-bold px-2.5 py-1 bg-slate-100 rounded border border-slate-300 text-slate-700">
                            OFFICIAL SHEET
                        </span>
                    </div>
                </div>

                <!-- Canvas Overlay Container: wraps ONLY the essay text so drawings land on text -->
                <div class="canvas-overlay-container" id="essay-overlay-shell" style="position: relative !important; margin: 0 !important; padding: 0 !important; min-height: 0 !important; display: block !important;">
                    <!-- Drawing Overlay Canvas (Overlays 100% of the essay text area only) -->
                    <canvas id="writing-annotation-canvas"
                            class="annotation-canvas"
                            :class="{ 'disabled': editMode !== 'draw' }"
                            style="position: absolute !important; top: 0 !important; left: 0 !important; width: 100% !important; height: 100% !important; z-index: 30; margin: 0 !important; padding: 0 !important;"
                            @mousedown="startDrawing($event)"
                            @mousemove="draw($event)"
                            @mouseup="stopDrawing()"
                            @mouseleave="stopDrawing()"
                            @touchstart.prevent="startDrawing($event)"
                            @touchmove.prevent="draw($event)"
                            @touchend.prevent="stopDrawing()"></canvas>

                    <!-- Student Essay Text -->
                    <div id="student-essay-content"
                         @mouseup="handleTextSelection($event)"
                         class="student-essay-text-box font-serif leading-loose text-gray-900 select-text font-normal w-full"
                         :style="`position: relative !important; z-index: 1 !important; margin: 0 !important; padding: 0 !important; min-height: 0 !important; display: block !important; font-size: ${textSize}px;`"
                         x-html="correctionHtml">
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

    <!-- Teacher Evaluation Form Card (Compact) -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-4 overflow-hidden">
        <form id="teacherReviewForm" action="{{ route('admin.writing-practice-submissions.review', $submission->id) }}" method="POST" @submit="prepareFormSubmission($event)" class="p-4 bg-white space-y-3">
            @csrf
            <!-- Hidden Payload Inputs -->
            <input type="hidden" name="teacher_correction_html" id="input_teacher_correction_html" :value="correctionHtml">
            <input type="hidden" name="annotation_canvas_data" id="input_annotation_canvas_data" :value="canvasDataUrl">

            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-1/4 shrink-0">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Nilai Band Rata-rata</label>
                    <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 flex items-baseline gap-1.5">
                        <span class="font-bold text-lg text-indigo-700" x-text="averageBand() !== null ? averageBand().toFixed(1) : '-'"></span>
                        <span class="text-xs text-gray-400 font-semibold">/ 9.0</span>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Otomatis dari rata-rata 4 komponen di bawah.</p>
                </div>
                <div class="w-full md:w-3/4 flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Catatan / Feedback Umum (General)</label>
                    <textarea name="teacher_feedback" rows="2"
                              placeholder="Tuliskan apresiasi, koreksi khusus, atau catatan perbaikan umum..."
                              class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-gray-900 text-xs placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition leading-relaxed min-h-[60px]">{{ old('teacher_feedback', $submission->teacher_feedback) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <div class="flex items-center gap-2 text-xs text-gray-500 font-medium">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Coretan & Koreksi Teks akan tersimpan otomatis saat Anda menekan Simpan.</span>
                </div>

                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow transition flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Evaluasi Pengajar</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Score Criteria Grid (4 Compact Cards) - editable by Teacher/Admin; pre-filled with AI's score as a starting point when available -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
        <div class="bg-white rounded-xl p-3.5 border border-gray-200 border-t-4 border-t-blue-500 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Task {{ $submission->task_type == 1 ? 'Achievement' : 'Response' }}</span>
            <div class="flex items-baseline justify-between mt-2 gap-1">
                <input type="number" step="0.5" min="0" max="9" name="task_achievement_score" form="teacherReviewForm"
                       x-model.number="taskScore"
                       placeholder="-"
                       class="w-full bg-transparent border-0 p-0 text-2xl font-extrabold text-blue-600 focus:ring-0 focus:outline-none">
                <span class="text-[11px] font-semibold text-gray-400 shrink-0">/ 9.0</span>
            </div>
            <textarea name="feedback[task_achievement]" form="teacherReviewForm" rows="2"
                      placeholder="Feedback Task Achievement..."
                      class="w-full mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2 text-gray-900 text-[11px] placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition leading-relaxed">{{ old('feedback.task_achievement', $taskFeedback) }}</textarea>
        </div>

        <div class="bg-white rounded-xl p-3.5 border border-gray-200 border-t-4 border-t-purple-500 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Coherence & Cohesion</span>
            <div class="flex items-baseline justify-between mt-2 gap-1">
                <input type="number" step="0.5" min="0" max="9" name="coherence_cohesion_score" form="teacherReviewForm"
                       x-model.number="cohesionScore"
                       placeholder="-"
                       class="w-full bg-transparent border-0 p-0 text-2xl font-extrabold text-purple-600 focus:ring-0 focus:outline-none">
                <span class="text-[11px] font-semibold text-gray-400 shrink-0">/ 9.0</span>
            </div>
            <textarea name="feedback[coherence_cohesion]" form="teacherReviewForm" rows="2"
                      placeholder="Feedback Coherence & Cohesion..."
                      class="w-full mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2 text-gray-900 text-[11px] placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition leading-relaxed">{{ old('feedback.coherence_cohesion', $cohesionFeedback) }}</textarea>
        </div>

        <div class="bg-white rounded-xl p-3.5 border border-gray-200 border-t-4 border-t-emerald-500 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Lexical Resource</span>
            <div class="flex items-baseline justify-between mt-2 gap-1">
                <input type="number" step="0.5" min="0" max="9" name="lexical_resource_score" form="teacherReviewForm"
                       x-model.number="lexicalScore"
                       placeholder="-"
                       class="w-full bg-transparent border-0 p-0 text-2xl font-extrabold text-emerald-600 focus:ring-0 focus:outline-none">
                <span class="text-[11px] font-semibold text-gray-400 shrink-0">/ 9.0</span>
            </div>
            <textarea name="feedback[lexical_resource]" form="teacherReviewForm" rows="2"
                      placeholder="Feedback Lexical Resource..."
                      class="w-full mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2 text-gray-900 text-[11px] placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition leading-relaxed">{{ old('feedback.lexical_resource', $lexicalFeedback) }}</textarea>
        </div>

        <div class="bg-white rounded-xl p-3.5 border border-gray-200 border-t-4 border-t-amber-500 shadow-sm flex flex-col justify-between">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Grammatical Range</span>
            <div class="flex items-baseline justify-between mt-2 gap-1">
                <input type="number" step="0.5" min="0" max="9" name="grammatical_range_score" form="teacherReviewForm"
                       x-model.number="grammarScore"
                       placeholder="-"
                       class="w-full bg-transparent border-0 p-0 text-2xl font-extrabold text-amber-600 focus:ring-0 focus:outline-none">
                <span class="text-[11px] font-semibold text-gray-400 shrink-0">/ 9.0</span>
            </div>
            <textarea name="feedback[grammatical_range]" form="teacherReviewForm" rows="2"
                      placeholder="Feedback Grammatical Range..."
                      class="w-full mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2 text-gray-900 text-[11px] placeholder-gray-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 focus:bg-white transition leading-relaxed">{{ old('feedback.grammatical_range', $grammarFeedback) }}</textarea>
        </div>
    </div>

    <!-- Section 3: AI Analysis & Breakdown Grid (2 Columns Below) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if(!empty($scores['overall_comment']))
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    <span>Evaluasi AI Umum</span>
                </h3>
                <p class="text-sm text-gray-800 leading-relaxed bg-indigo-50/70 p-4 rounded-xl border border-indigo-100 font-medium">
                    {{ $scores['overall_comment'] }}
                </p>
            </div>
        @endif

        @if(isset($scores['feedback']) && is_array($scores['feedback']))
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2 2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>Rincian Evaluasi AI per Kriteria</span>
                </h3>

                @if(!empty($scores['feedback']['task_achievement']) || !empty($scores['feedback']['task_response']))
                    <div>
                        <h4 class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1">Task {{ $submission->task_type == 1 ? 'Achievement' : 'Response' }}</h4>
                        <div class="text-sm text-gray-800 bg-blue-50/70 p-4 rounded-xl border border-blue-100 leading-relaxed">
                            {!! $scores['feedback']['task_achievement'] ?? $scores['feedback']['task_response'] !!}
                        </div>
                    </div>
                @endif

                @if(!empty($scores['feedback']['coherence_cohesion']))
                    <div>
                        <h4 class="text-xs font-bold text-purple-700 uppercase tracking-wider mb-1">Coherence & Cohesion</h4>
                        <div class="text-sm text-gray-800 bg-purple-50/70 p-4 rounded-xl border border-purple-100 leading-relaxed">
                            {!! $scores['feedback']['coherence_cohesion'] !!}
                        </div>
                    </div>
                @endif

                @if(!empty($scores['feedback']['lexical_resource']))
                    <div>
                        <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-1">Lexical Resource</h4>
                        <div class="text-sm text-gray-800 bg-emerald-50/70 p-4 rounded-xl border border-emerald-100 leading-relaxed">
                            {!! $scores['feedback']['lexical_resource'] !!}
                        </div>
                    </div>
                @endif

                @if(!empty($scores['feedback']['grammatical_range']))
                    <div>
                        <h4 class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Grammatical Range</h4>
                        <div class="text-sm text-gray-800 bg-amber-50/70 p-4 rounded-xl border border-amber-100 leading-relaxed">
                            {!! $scores['feedback']['grammatical_range'] !!}
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @if(!empty($scores['correction_html']))
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Teks Hasil Koreksi AI (Diff / Highlighting)</span>
                </h3>
                <div class="bg-amber-50/50 p-5 rounded-xl border border-amber-200 text-sm text-gray-900 leading-relaxed whitespace-pre-wrap">
                    {!! $scores['correction_html'] !!}
                </div>
            </div>
        @endif

        @if(!empty($scores['better_version']) || !empty($scores['band_9_version']))
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <span>Contoh Model Band 9</span>
                </h3>
                <div class="bg-emerald-50/60 p-5 rounded-xl border border-emerald-200 text-sm text-emerald-950 leading-relaxed whitespace-pre-wrap font-sans">
                    {!! $scores['better_version'] ?? $scores['band_9_version'] !!}
                </div>
            </div>
        @endif
    </div>

    <!-- ════════════════════════════════════════
         FLOATING ANNOTATOR TOOLBAR (EXACT MATCH WITH TOEFL TOOLBAR)
    ════════════════════════════════════════ -->
    <!-- Floating Toolbar Toggle (When Collapsed) -->
    <button type="button"
            @click="showToolbar = !showToolbar"
            x-show="editMode === 'draw' && !showToolbar"
            class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[100] px-4 py-2.5 bg-[#111827] text-white rounded-full shadow-2xl border border-slate-700 font-bold text-xs flex items-center gap-2 hover:bg-slate-800 transition cursor-pointer">
        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        <span>Buka Toolbar Coretan</span>
    </button>

    <!-- Main Floating Toolbar Shell (TOEFL Style: Solid Dark Navy #111827) -->
    <div x-show="editMode === 'draw' && showToolbar"
         x-transition:enter="transition ease-out duration-200 transform"
         x-transition:enter-start="translate-y-8 opacity-0 scale-95"
         x-transition:enter-end="translate-y-0 opacity-100 scale-100"
         style="background-color: #111827 !important; color: #ffffff !important; opacity: 1 !important; box-shadow: 0 20px 60px rgba(0,0,0,0.55);"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[300] px-6 py-3 rounded-full border border-slate-700 flex items-center gap-4">

        <!-- Pen Tool -->
        <button type="button" @click="activeTool = 'pen'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Pen (Coretan Bebas)"
                :style="activeTool === 'pen' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Pen</span>
        </button>

        <!-- Text Box Tool -->
        <button type="button" @click="activeTool = 'text'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Teks (Tambah Catatan / Koreksi)"
                :style="activeTool === 'text' ? 'color: #38BDF8; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M12 6v12M9 18h6"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Teks</span>
        </button>

        <!-- Line Tool -->
        <button type="button" @click="activeTool = 'line'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Garis Lurus"
                :style="activeTool === 'line' ? 'color: #60A5FA; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20L20 4"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Garis</span>
        </button>

        <!-- Arrow Tool -->
        <button type="button" @click="activeTool = 'arrow'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Panah Petunjuk Koreksi"
                :style="activeTool === 'arrow' ? 'color: #818CF8; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Panah</span>
        </button>

        <!-- Rect Tool -->
        <button type="button" @click="activeTool = 'rect'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Kotak Highlight Teks"
                :style="activeTool === 'rect' ? 'color: #34D399; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Kotak</span>
        </button>

        <!-- Circle Tool -->
        <button type="button" @click="activeTool = 'circle'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Lingkaran Highlight"
                :style="activeTool === 'circle' ? 'color: #F472B6; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" stroke-width="2"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Lingkaran</span>
        </button>

        <!-- Stabilo Tool -->
        <button type="button" @click="activeTool = 'highlighter'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Stabilo / Highlighter"
                :style="activeTool === 'highlighter' ? 'color: #FACC15; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Stabilo</span>
        </button>

        <!-- Stamp Tool (With Drawer Toggle) -->
        <button type="button" @click="activeTool = 'stamp'; showStampsDrawer = !showStampsDrawer"
                class="flex flex-col items-center transition cursor-pointer relative px-1.5"
                title="Stempel Evaluasi IELTS"
                :style="activeTool === 'stamp' ? 'color: #A855F7; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2zm3-4h4a1 1 0 011 1v3H9V4a1 1 0 011-1z"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Stempel</span>
        </button>

        <!-- Laser Pointer Tool -->
        <button type="button" @click="activeTool = 'laser'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Laser Pointer"
                :style="activeTool === 'laser' ? 'color: #F87171; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3" fill="currentColor"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12h10"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Laser</span>
        </button>

        <!-- Eraser Tool -->
        <button type="button" @click="activeTool = 'eraser'"
                class="flex flex-col items-center transition cursor-pointer px-1.5"
                title="Eraser"
                :style="activeTool === 'eraser' ? 'color: #FFFFFF; transform: scale(1.1);' : 'color: #9CA3AF;'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Eraser</span>
        </button>

        <!-- Separator 1 -->
        <div style="width:1px;height:28px;background:#374151;margin:0 2px;"></div>

        <!-- Thickness Selector Options (2px, 4px, 8px, 12px) -->
        <div class="flex items-center gap-1 bg-slate-900/90 p-1 rounded-full border border-slate-700">
            <template x-for="sz in [2, 4, 8, 12]" :key="sz">
                <button type="button" @click="setLineWidth(sz)"
                        :class="Number(lineWidth) === Number(sz) ? 'bg-blue-600 text-white font-black scale-105 shadow-md ring-1 ring-white/50' : 'text-slate-400 hover:text-white hover:bg-slate-800'"
                        class="w-7 h-5 rounded-full text-[10px] flex items-center justify-center transition cursor-pointer"
                        :title="`Ketebalan Garis ${sz}px`"
                        x-text="sz + 'px'"></button>
            </template>
        </div>

        <!-- Functional Color Picker Tool -->
        <label class="flex flex-col items-center transition cursor-pointer px-1.5 text-slate-300 hover:text-white relative"
               title="Pilih Warna Coretan">
            <div class="w-5 h-5 rounded-full border-2 border-white/80 shadow-md flex items-center justify-center overflow-hidden transition transform hover:scale-110"
                 :style="`background-color: ${selectedColor}; box-shadow: 0 0 8px ${selectedColor};`">
                <input type="color" x-model="selectedColor" @input="if(activeTool==='eraser') activeTool='pen';" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
            </div>
            <span class="text-[10px] mt-0.5 font-medium text-slate-400">Warna</span>
        </label>

        <!-- Separator 2 -->
        <div style="width:1px;height:28px;background:#374151;margin:0 2px;"></div>

        <!-- Undo Action -->
        <button type="button" @click="undoCanvas()"
                class="flex flex-col items-center transition cursor-pointer text-slate-400 hover:text-white px-1"
                title="Undo (Kembalikan)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6-6m-6 6l6 6"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Undo</span>
        </button>

        <!-- Redo Action -->
        <button type="button" @click="redoCanvas()"
                :disabled="redoStack.length === 0"
                :class="redoStack.length > 0 ? 'text-slate-400 hover:text-white cursor-pointer' : 'text-slate-600 opacity-40 cursor-not-allowed'"
                class="flex flex-col items-center transition px-1"
                title="Redo (Ulangi)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6-6m6 6l-6 6"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium">Redo</span>
        </button>

        <!-- Clear All Action -->
        <button type="button" @click="clearCanvas()"
                class="flex flex-col items-center transition cursor-pointer text-red-500 hover:text-red-400 px-1"
                title="Hapus Semua Coretan">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="text-[10px] mt-0.5 font-medium text-red-500">Reset</span>
        </button>

        <!-- Close Toolbar Button -->
        <button type="button" @click="showToolbar = false"
                class="ml-1 text-slate-400 hover:text-white p-1 rounded-full hover:bg-slate-800 transition"
                title="Sembunyikan Toolbar">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- IELTS Stamps Drawer Popover (Pops UP above the toolbar, 100% Solid Dark Navy) -->
        <div x-show="activeTool === 'stamp' && showStampsDrawer"
             x-transition:enter="transition ease-out duration-200 transform"
             x-transition:enter-start="-translate-y-2 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             style="background-color: #111827 !important; color: #ffffff !important; opacity: 1 !important; backdrop-filter: none !important; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75) !important; display: none;"
             class="absolute bottom-full mb-4 left-1/2 -translate-x-1/2 p-4 rounded-2xl border border-slate-700 grid grid-cols-2 gap-2 min-w-[340px] max-w-[440px] z-[400]">
            <div class="col-span-2 text-[11px] font-bold text-slate-300 uppercase tracking-wider mb-1 flex items-center justify-between pb-2 border-b border-slate-800">
                <span>Pilih Stempel Evaluasi IELTS:</span>
                <button type="button" @click="showStampsDrawer = false" class="text-slate-400 hover:text-white px-2 py-0.5 rounded-md hover:bg-slate-800 transition">✕</button>
            </div>
            <template x-for="st in ieltsStamps" :key="st.text">
                <button type="button" @click="selectedStamp = st; showStampsDrawer = false"
                        :class="selectedStamp.text === st.text ? 'ring-2 ring-white font-black scale-105 shadow-md' : 'opacity-90 hover:opacity-100 hover:scale-102'"
                        :style="`background-color: ${st.bg}; color: ${st.color};`"
                        class="px-3 py-2.5 rounded-xl text-xs font-bold text-left shadow-sm stamp-badge-btn truncate transition cursor-pointer"
                        x-text="st.text"></button>
            </template>
        </div>
</div>

<!-- Inline Text Selection Popover -->
<div id="text-correction-popover" style="display:none;" class="fixed z-[160] bg-slate-900 text-white px-3 py-2 rounded-xl shadow-xl border border-slate-700 flex items-center gap-2 text-xs">
    <button type="button" onclick="window.applyInlineCorrection()" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-500 font-bold rounded-lg transition text-white">
        ✏️ Corets & Ganti Teks
    </button>
    <button type="button" onclick="window.hideCorrectionPopover()" class="px-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg font-bold">
        ✕
    </button>
</div>

<script>
    function writingAnnotatorApp(config) {
        return {
            editMode: 'draw', // 'draw' or 'text'
            showToolbar: true,
            showStampsDrawer: false,
            activeTool: 'pen', // 'pen', 'highlighter', 'stamp', 'eraser'
            selectedColor: '#ef4444',
            lineWidth: 4,
            canvasDataUrl: config.savedCanvas || '',
            correctionHtml: config.savedCorrection || config.essayText,
            taskScore: config.taskScore,
            cohesionScore: config.cohesionScore,
            lexicalScore: config.lexicalScore,
            grammarScore: config.grammarScore,
            isDrawing: false,
            lastX: 0,
            lastY: 0,
            canvas: null,
            ctx: null,
            undoStack: [],
            redoStack: [],
            zoomLevel: 100,
            textSize: 18,

            setLineWidth(val) {
                this.lineWidth = Number(val) || 4;
            },

            zoomIn() {
                this.zoomLevel = Math.min(200, this.zoomLevel + 10);
            },

            zoomOut() {
                this.zoomLevel = Math.max(50, this.zoomLevel - 10);
            },

            resetZoom() {
                this.zoomLevel = 100;
            },

            textSizeUp() {
                this.textSize = Math.min(32, this.textSize + 2);
                this.$nextTick(() => this.resizeCanvas());
            },

            textSizeDown() {
                this.textSize = Math.max(14, this.textSize - 2);
                this.$nextTick(() => this.resizeCanvas());
            },

            resetTextSize() {
                this.textSize = 18;
                this.$nextTick(() => this.resizeCanvas());
            },

            // IELTS overall band = average of the 4 sub-scores, rounded to the nearest
            // half band (0.25 rounds up to .5, 0.75 rounds up to the next whole band) -
            // only shown once all 4 components have a value.
            averageBand() {
                const vals = [this.taskScore, this.cohesionScore, this.lexicalScore, this.grammarScore];
                if (vals.some(v => v === null || v === '' || v === undefined || isNaN(Number(v)))) {
                    return null;
                }
                const avg = vals.reduce((sum, v) => sum + Number(v), 0) / 4;
                return Math.round(avg * 2) / 2;
            },

            selectColor(val) {
                if (!val) return;
                this.selectedColor = val.toLowerCase();
                if (this.activeTool === 'eraser') {
                    this.activeTool = 'pen';
                }
            },

            colors: [
                { name: 'Merah', value: '#EF4444' },
                { name: 'Biru', value: '#3B82F6' },
                { name: 'Hijau', value: '#10B981' },
                { name: 'Kuning', value: '#FACC15' },
                { name: 'Oranye', value: '#F97316' },
                { name: 'Ungu', value: '#A855F7' },
                { name: 'Cyan', value: '#06B6D4' },
                { name: 'Oranye Tua', value: '#EA580C' },
            ],

            ieltsStamps: [
                { text: 'Grammar Error ❌', bg: '#fee2e2', color: '#b91c1c' },
                { text: 'Word Choice 🔤', bg: '#fef3c7', color: '#b45309' },
                { text: 'Weak Cohesion 🔗', bg: '#e0e7ff', color: '#4338ca' },
                { text: 'Spelling ✏️', bg: '#dcfce7', color: '#15803d' },
                { text: 'Good Paraphrase ⭐', bg: '#fef08a', color: '#854d0e' },
                { text: 'Repetitive Word 🔄', bg: '#f3e8ff', color: '#6b21a8' },
                { text: 'Informal Tone ⚠️', bg: '#ffedd5', color: '#c2410c' },
                { text: 'Missing Overview 📊', bg: '#cff4fc', color: '#055160' },
            ],

            selectedStamp: { text: 'Grammar Error ❌', bg: '#fee2e2', color: '#b91c1c' },

            cleanLeadingWhitespace(html) {
                if (!html) return '';
                return html.replace(/^(?:<p>\s*(?:&nbsp;|<br\s*\/?>|\s)*<\/p>|<br\s*\/?>)+/gi, '');
            },

            formatEssay(html) {
                if (!html) return '';
                let cleaned = this.cleanLeadingWhitespace(html);
                if (!cleaned.includes('<p>') && !cleaned.includes('<br>') && !cleaned.includes('<ins>') && !cleaned.includes('<del>')) {
                    let paragraphs = cleaned.split(/\n\s*\n/);
                    return paragraphs.map(p => `<p class="mb-4 text-justify leading-relaxed">${p}</p>`).join('');
                }
                return cleaned;
            },

            init() {
                this.correctionHtml = this.formatEssay(this.correctionHtml);
                this.$nextTick(() => {
                    this.initCanvas();
                });
            },

            initCanvas() {
                const shell = document.getElementById('essay-overlay-shell');
                this.canvas = document.getElementById('writing-annotation-canvas');
                if (!shell || !this.canvas) return;

                this.ctx = this.canvas.getContext('2d');

                // Delayed resizes to catch Alpine x-html text rendering
                setTimeout(() => this.resizeCanvas(), 100);
                setTimeout(() => this.resizeCanvas(), 500);
                setTimeout(() => this.resizeCanvas(), 1500);

                window.addEventListener('resize', () => this.resizeCanvas());

                // Load saved canvas if available
                if (this.canvasDataUrl) {
                    const img = new Image();
                    img.onload = () => {
                        this.resizeCanvas();
                        this.ctx.drawImage(img, 0, 0, this.canvas.width, this.canvas.height);
                        this.saveState();
                    };
                    img.src = this.canvasDataUrl;
                } else {
                    setTimeout(() => this.saveState(), 200);
                }
            },

            resizeCanvas() {
                // Size from the TEXT DIV (stable, unaffected by canvas attributes)
                const textDiv = document.getElementById('student-essay-content');
                if (!textDiv || !this.canvas) return;
                const rect = textDiv.getBoundingClientRect();
                const newW = Math.round(rect.width);
                const newH = Math.round(rect.height);

                // Skip if dimensions haven't changed
                if (newW <= 0 || newH <= 0) return;
                if (this.canvas.width === newW && this.canvas.height === newH) return;

                // Assigning canvas.width/height clears the drawing buffer, which used to
                // silently wipe existing annotations whenever the rendered size changed
                // (e.g. zooming the sheet in/out, or resizing the browser window). Snapshot
                // the current pixels first and stretch them into the new buffer size so
                // annotations survive and scale together with the zoom level.
                let snapshot = null;
                if (this.canvas.width > 0 && this.canvas.height > 0) {
                    snapshot = document.createElement('canvas');
                    snapshot.width = this.canvas.width;
                    snapshot.height = this.canvas.height;
                    snapshot.getContext('2d').drawImage(this.canvas, 0, 0);
                }

                this.canvas.width = newW;
                this.canvas.height = newH;

                if (snapshot) {
                    this.ctx.drawImage(snapshot, 0, 0, snapshot.width, snapshot.height, 0, 0, newW, newH);
                }
            },

            saveState() {
                if (!this.canvas) return;
                if (this.undoStack.length > 25) this.undoStack.shift();
                this.undoStack.push(this.ctx.getImageData(0, 0, this.canvas.width, this.canvas.height));
                this.redoStack = [];
                this.canvasDataUrl = this.canvas.toDataURL('image/png');
            },

            undoCanvas() {
                if (this.undoStack.length > 1) {
                    const current = this.undoStack.pop();
                    this.redoStack.push(current);
                    const lastState = this.undoStack[this.undoStack.length - 1];
                    this.ctx.putImageData(lastState, 0, 0);
                    this.canvasDataUrl = this.canvas.toDataURL('image/png');
                } else if (this.undoStack.length === 1) {
                    const current = this.undoStack.pop();
                    this.redoStack.push(current);
                    this.clearCanvas();
                }
            },

            redoCanvas() {
                if (this.redoStack.length > 0) {
                    const state = this.redoStack.pop();
                    this.ctx.putImageData(state, 0, 0);
                    this.undoStack.push(state);
                    this.canvasDataUrl = this.canvas.toDataURL('image/png');
                }
            },

            clearCanvas() {
                if (!this.ctx || !this.canvas) return;
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                this.saveState();
            },

            getPos(e) {
                if (!this.canvas) return { x: 0, y: 0 };
                const rect = this.canvas.getBoundingClientRect();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;

                const scaleX = rect.width ? (this.canvas.width / rect.width) : 1;
                const scaleY = rect.height ? (this.canvas.height / rect.height) : 1;

                return {
                    x: (clientX - rect.left) * scaleX,
                    y: (clientY - rect.top) * scaleY
                };
            },

            startDrawing(e) {
                if (this.editMode !== 'draw') return;
                // Always sync canvas buffer to current container size before drawing
                this.resizeCanvas();
                const pos = this.getPos(e);
                this.isDrawing = true;
                this.startX = pos.x;
                this.startY = pos.y;
                this.lastX = pos.x;
                this.lastY = pos.y;

                if (this.activeTool === 'stamp') {
                    this.placeStamp(pos.x, pos.y);
                    this.isDrawing = false;
                } else if (this.activeTool === 'text') {
                    this.placeText(pos.x, pos.y);
                    this.isDrawing = false;
                } else if (['line', 'arrow', 'rect', 'circle'].includes(this.activeTool)) {
                    this.snapshot = this.ctx.getImageData(0, 0, this.canvas.width, this.canvas.height);
                }
            },

            draw(e) {
                if (!this.isDrawing || this.editMode !== 'draw' || ['stamp', 'text'].includes(this.activeTool)) return;
                const pos = this.getPos(e);

                if (['line', 'arrow', 'rect', 'circle'].includes(this.activeTool)) {
                    if (this.snapshot) {
                        this.ctx.putImageData(this.snapshot, 0, 0);
                    }
                    this.ctx.beginPath();
                    this.ctx.globalCompositeOperation = 'source-over';
                    this.ctx.strokeStyle = this.selectedColor;
                    this.ctx.fillStyle = this.selectedColor;
                    this.ctx.globalAlpha = 1.0;
                    this.ctx.lineWidth = this.lineWidth;

                    if (this.activeTool === 'line') {
                        this.ctx.moveTo(this.startX, this.startY);
                        this.ctx.lineTo(pos.x, pos.y);
                        this.ctx.lineCap = 'round';
                        this.ctx.stroke();
                    } else if (this.activeTool === 'arrow') {
                        this.drawArrow(this.startX, this.startY, pos.x, pos.y);
                    } else if (this.activeTool === 'rect') {
                        const w = pos.x - this.startX;
                        const h = pos.y - this.startY;
                        this.ctx.strokeRect(this.startX, this.startY, w, h);
                    } else if (this.activeTool === 'circle') {
                        const rx = Math.abs(pos.x - this.startX) / 2;
                        const ry = Math.abs(pos.y - this.startY) / 2;
                        const cx = Math.min(this.startX, pos.x) + rx;
                        const cy = Math.min(this.startY, pos.y) + ry;
                        this.ctx.beginPath();
                        this.ctx.ellipse(cx, cy, rx, ry, 0, 0, 2 * Math.PI);
                        this.ctx.stroke();
                    }
                } else if (this.activeTool === 'eraser') {
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.lastX, this.lastY);
                    this.ctx.lineTo(pos.x, pos.y);
                    this.ctx.globalCompositeOperation = 'destination-out';
                    this.ctx.lineWidth = this.lineWidth * 3.5;
                    this.ctx.lineCap = 'round';
                    this.ctx.stroke();
                } else if (this.activeTool === 'highlighter') {
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.lastX, this.lastY);
                    this.ctx.lineTo(pos.x, pos.y);
                    this.ctx.globalCompositeOperation = 'source-over';
                    this.ctx.strokeStyle = this.selectedColor;
                    this.ctx.globalAlpha = 0.35;
                    this.ctx.lineWidth = this.lineWidth * 3.5;
                    this.ctx.lineCap = 'square';
                    this.ctx.stroke();
                } else { // Pen / Laser
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.lastX, this.lastY);
                    this.ctx.lineTo(pos.x, pos.y);
                    this.ctx.globalCompositeOperation = 'source-over';
                    this.ctx.strokeStyle = this.selectedColor;
                    this.ctx.globalAlpha = this.activeTool === 'laser' ? 0.9 : 1.0;
                    this.ctx.lineWidth = this.lineWidth;
                    this.ctx.lineCap = 'round';
                    this.ctx.lineJoin = 'round';
                    this.ctx.stroke();
                }

                this.ctx.globalAlpha = 1.0;
                this.ctx.globalCompositeOperation = 'source-over';

                this.lastX = pos.x;
                this.lastY = pos.y;
            },

            stopDrawing() {
                if (this.isDrawing) {
                    this.isDrawing = false;
                    this.saveState();
                }
            },

            placeText(x, y) {
                const text = prompt("Masukkan catatan / komentar perbaikan:");
                if (!text || !text.trim()) return;

                this.ctx.save();
                this.ctx.font = '600 13px Inter, -apple-system, BlinkMacSystemFont, sans-serif';

                const paddingHorizontal = 6;
                const metrics = this.ctx.measureText(text);
                const w = metrics.width + (paddingHorizontal * 2);
                const h = 22;
                const rx = x - 2;
                const ry = y - 15;

                // Translucent background pill for max contrast readability on top of essay text
                this.ctx.fillStyle = 'rgba(255, 255, 255, 0.95)';
                this.ctx.strokeStyle = this.selectedColor;
                this.ctx.lineWidth = 1.5;

                this.ctx.beginPath();
                if (this.ctx.roundRect) {
                    this.ctx.roundRect(rx, ry, w, h, 4);
                } else {
                    this.ctx.rect(rx, ry, w, h);
                }
                this.ctx.fill();
                this.ctx.stroke();

                // Draw Text
                this.ctx.fillStyle = this.selectedColor;
                this.ctx.textBaseline = 'middle';
                this.ctx.fillText(text, rx + paddingHorizontal, ry + (h / 2));

                this.ctx.restore();
                this.saveState();
            },

            drawArrow(fromX, fromY, toX, toY) {
                const headlen = 10 + (this.lineWidth * 1.5);
                const dx = toX - fromX;
                const dy = toY - fromY;
                const angle = Math.atan2(dy, dx);

                this.ctx.beginPath();
                this.ctx.moveTo(fromX, fromY);
                this.ctx.lineTo(toX, toY);
                this.ctx.lineCap = 'round';
                this.ctx.stroke();

                this.ctx.beginPath();
                this.ctx.moveTo(toX, toY);
                this.ctx.lineTo(toX - headlen * Math.cos(angle - Math.PI / 6), toY - headlen * Math.sin(angle - Math.PI / 6));
                this.ctx.lineTo(toX - headlen * Math.cos(angle + Math.PI / 6), toY - headlen * Math.sin(angle + Math.PI / 6));
                this.ctx.closePath();
                this.ctx.fill();
            },

            placeStamp(x, y) {
                if (!this.ctx) return;
                const stamp = this.selectedStamp;

                this.ctx.save();
                this.ctx.font = 'bold 12px sans-serif';
                const textWidth = this.ctx.measureText(stamp.text).width;
                const padding = 6;
                const w = textWidth + (padding * 2);
                const h = 24;

                // Draw rounded badge rect
                this.ctx.fillStyle = stamp.bg;
                this.ctx.strokeStyle = stamp.color;
                this.ctx.lineWidth = 1.5;
                
                const rx = x - (w / 2);
                const ry = y - (h / 2);

                this.ctx.beginPath();
                if (this.ctx.roundRect) {
                    this.ctx.roundRect(rx, ry, w, h, 6);
                } else {
                    this.ctx.rect(rx, ry, w, h);
                }
                this.ctx.fill();
                this.ctx.stroke();

                // Draw text inside badge
                this.ctx.fillStyle = stamp.color;
                this.ctx.textAlign = 'center';
                this.ctx.textBaseline = 'middle';
                this.ctx.fillText(stamp.text, x, y + 1);

                this.ctx.restore();
                this.saveState();
            },

            resetTextToOriginal() {
                if (confirm('Apakah Anda yakin ingin mengembalikan teks ke tulisan asli student?')) {
                    this.correctionHtml = this.formatEssay(config.essayText);
                }
            },

            prepareFormSubmission(e) {
                if (this.canvas) {
                    this.canvasDataUrl = this.canvas.toDataURL('image/png');
                }
                document.getElementById('input_teacher_correction_html').value = this.correctionHtml;
                document.getElementById('input_annotation_canvas_data').value = this.canvasDataUrl;
            },

            handleTextSelection(e) {
                if (this.editMode !== 'text') return;
                const sel = window.getSelection();
                const text = sel ? sel.toString().trim() : '';

                if (text.length > 0) {
                    window.currentSelectedText = text;
                    window.currentSelectionRange = sel.getRangeAt(0);

                    const popover = document.getElementById('text-correction-popover');
                    if (popover) {
                        popover.style.display = 'flex';
                        popover.style.left = Math.min(window.innerWidth - 250, Math.max(10, e.clientX - 100)) + 'px';
                        popover.style.top = (e.clientY - 45) + 'px';
                    }
                } else {
                    window.hideCorrectionPopover();
                }
            }
        };
    }

    window.hideCorrectionPopover = function() {
        const popover = document.getElementById('text-correction-popover');
        if (popover) popover.style.display = 'none';
    };

    window.applyInlineCorrection = function() {
        const originalText = window.currentSelectedText;
        if (!originalText) return;

        const replacement = prompt(`Perbaikan untuk teks: "${originalText}"`, originalText);
        if (replacement !== null && replacement.trim() !== '') {
            const formatted = `<del>${originalText}</del> <ins>${replacement.trim()}</ins>`;
            const range = window.currentSelectionRange;
            if (range) {
                range.deleteContents();
                const el = document.createElement('span');
                el.innerHTML = formatted;
                range.insertNode(el);

                // Sync back to Alpine data. Two bugs fixed here:
                // 1) el.__x.$data was Alpine v2 API, removed in Alpine v3 (which
                //    this project uses) - it silently returned undefined, so this
                //    sync never ran; corrections looked applied in the DOM but
                //    were lost on the next Alpine re-render and never got saved.
                // 2) document.querySelector('[x-data]') grabs the FIRST x-data
                //    element anywhere on the page (the sidebar's), not this
                //    component's - it must be scoped to an element known to be
                //    inside writingAnnotatorApp and walk up with .closest().
                const essayBox = document.getElementById('student-essay-content');
                const app = Alpine.$data(essayBox.closest('[x-data]'));
                app.correctionHtml = essayBox.innerHTML;
            }
        }
        window.hideCorrectionPopover();
    };

    async function retryAiEvaluation(id, buttonEl) {
        if (!confirm('Apakah Anda yakin ingin melakukan penilaian AI ulang untuk submission ini?')) return;

        buttonEl.disabled = true;
        const originalText = buttonEl.innerHTML;
        buttonEl.innerHTML = 'Mengirim AI...';

        try {
            const response = await fetch(`/assignments/ielts-academic/writing/submission/${id}/retry`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                alert('Penilaian AI berhasil dikirim ulang dan diperbarui!');
                window.location.reload();
            } else {
                alert('Gagal menilai ulang AI: ' + (data.error || 'Unknown error'));
                buttonEl.disabled = false;
                buttonEl.innerHTML = originalText;
            }
        } catch (e) {
            console.error(e);
            alert('Terjadi kesalahan jaringan.');
            buttonEl.disabled = false;
            buttonEl.innerHTML = originalText;
        }
    }
</script>
@endsection
