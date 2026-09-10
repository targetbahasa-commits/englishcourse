@extends('layouts.admin')

@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
            <a href="{{ route('admin.final-test-results.index') }}" class="hover:text-indigo-600 transition">Final Test Results</a>
            <span>/</span>
            <span class="text-indigo-600 font-bold">Detail &amp; Pengelolaan Evaluasi</span>
        </div>
        <h2 class="font-black text-2xl text-gray-900 leading-tight mt-1">
            {{ $result->name ?? 'Peserta' }} — {{ $result->test_label ?? ($result->test_type ?? 'Final Test') }}
        </h2>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('admin.final-test-results.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 text-xs font-bold shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Daftar Hasil
        </a>
        <a href="{{ route('final-test.results.show', $result->id ?? $result->ID ?? 0) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-xl hover:bg-indigo-100 text-xs font-bold shadow-xs transition" title="Lihat tampilan hasil dari sisi siswa">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Tampilan Siswa
        </a>
        <a href="{{ route('admin.final-test-results.certificate', $result->id ?? $result->ID ?? 0) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-600 border border-transparent text-white rounded-xl hover:bg-blue-700 text-xs font-bold shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Sertifikat
        </a>
        <form method="POST" action="{{ route('admin.final-test-results.destroy', $result->id ?? $result->ID ?? 0) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data hasil final test ini? Tindakan ini tidak dapat dibatalkan.');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border border-rose-200 text-rose-600 rounded-xl hover:bg-rose-50 text-xs font-bold transition" title="Hapus submission">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus
            </button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .word-correct { color: #059669; font-weight: 600; }
    .word-wrong { color: #dc2626; text-decoration: line-through; }
    .word-missing { color: #2563eb; font-weight: 700; text-decoration: underline; }
    .word-extra { color: #d97706; text-decoration: line-through; }
</style>
@endpush

@section('content')
<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900">&times;</button>
        </div>
    @endif

    @php
        $answersData = is_array($result->answers_data) ? $result->answers_data : [];
        $evaluationData = is_array($result->evaluation_data) ? $result->evaluation_data : [];
        $criteria = $answersData['criteria'] ?? [];
        $feedback = $answersData['feedback'] ?? [];
        $modules = $answersData['module_diagnostics'] ?? [];
        $paragraphs = $answersData['paragraphs'] ?? [];

        $grammarScore = $criteria['grammar_complexity']['score'] ?? null;
        $lexicalScore = $criteria['lexical_resource']['score'] ?? null;
        $accuracyScore = $criteria['translation_accuracy']['score'] ?? null;
        $overallScore = $result->score ?? ($answersData['score'] ?? 0);
        $isPassed = $answersData['passed'] ?? ($overallScore >= 70);
        $cefrLevel = $answersData['cefr_level'] ?? ($evaluationData['cefr'] ?? 'B2');
        $ieltsEquiv = $answersData['ielts_equivalent'] ?? ($evaluationData['ielts_equivalent'] ?? 'IELTS Band 6.5');
        $predicate = $answersData['predicate'] ?? ($evaluationData['predicate'] ?? 'Pass');

        $reviewedBy = $evaluationData['reviewed_by'] ?? null;
        $reviewedAt = $evaluationData['reviewed_at'] ?? null;
        $reEvaluatedAt = $evaluationData['re_evaluated_at'] ?? null;
    @endphp

    <!-- 1. Metadata Siswa & Ringkasan Ujian -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Student Info Card -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center font-bold text-lg">
                        👤
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-white">Informasi Peserta Ujian</h3>
                        <p class="text-xs text-blue-100">Data registrasi dan pengerjaan final assessment</p>
                    </div>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider {{ $result->status === 'completed' ? 'bg-emerald-400/20 text-emerald-100 border border-emerald-300/30' : 'bg-amber-400/20 text-amber-100 border border-amber-300/30' }}">
                    {{ ucfirst(str_replace('_', ' ', $result->status ?? 'in_progress')) }}
                </span>
            </div>
            <div class="p-6 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                <div class="space-y-1">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Nama Lengkap</p>
                    <p class="text-sm font-bold text-gray-900">{{ $result->name ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Email</p>
                    <p class="text-sm font-bold text-gray-900 truncate" title="{{ $result->email }}">{{ $result->email ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Candidate ID</p>
                    <p class="text-sm font-mono font-bold text-indigo-700">{{ $result->candidate_id ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Tipe Program</p>
                    <p class="text-sm font-bold text-gray-900">{{ $result->test_label ?? ($result->test_type ?? '-') }}</p>
                </div>
                <div class="space-y-1 pt-2 border-t border-gray-100">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Durasi Ujian</p>
                    <p class="text-sm font-bold text-gray-800">{{ $result->time_spent_seconds ? gmdate('H:i:s', $result->time_spent_seconds) : '-' }}</p>
                </div>
                <div class="space-y-1 pt-2 border-t border-gray-100">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Waktu Selesai</p>
                    <p class="text-sm font-bold text-gray-800">{{ $result->completed_at ? \Carbon\Carbon::parse($result->completed_at)->format('d M Y H:i') : ($result->created_at ? $result->created_at->format('d M Y H:i') : '-') }}</p>
                </div>
                <div class="space-y-1 pt-2 border-t border-gray-100">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Email Sertifikat</p>
                    <p class="text-xs font-bold {{ ($result->evaluation_data['certificate_email_status'] ?? '') === 'sent' ? 'text-emerald-700' : 'text-gray-600' }}">
                        {{ ucfirst($result->evaluation_data['certificate_email_status'] ?? 'Pending') }}
                    </p>
                </div>
                <div class="space-y-1 pt-2 border-t border-gray-100">
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Status Review</p>
                    @if($reviewedBy)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-md">
                            Sudah Direview
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md">
                            Belum Direview
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Score & Re-Evaluate Box -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Skor Final Saat Ini</span>
                    @if($isPassed)
                        <span class="rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-black px-2.5 py-0.5 border border-emerald-200">LULUS</span>
                    @else
                        <span class="rounded-full bg-amber-100 text-amber-800 text-[11px] font-black px-2.5 py-0.5 border border-amber-200">PERLU PENGUATAN</span>
                    @endif
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-5xl font-black text-indigo-700 font-mono">{{ is_numeric($overallScore) ? number_format((float) $overallScore, 1) : $overallScore }}</span>
                    <span class="text-sm font-bold text-gray-400">/ 100</span>
                </div>
                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                    <span class="rounded-lg bg-indigo-50 border border-indigo-200 px-2.5 py-1 font-bold text-indigo-700">{{ $cefrLevel }}</span>
                    <span class="rounded-lg bg-blue-50 border border-blue-200 px-2.5 py-1 font-bold text-blue-700">{{ $ieltsEquiv }}</span>
                </div>
                @if($reviewedBy)
                    <p class="mt-3 text-[11px] text-gray-500">
                        Direview oleh <strong class="text-gray-800">{{ $reviewedBy }}</strong> pada {{ \Carbon\Carbon::parse($reviewedAt)->format('d M Y H:i') }}
                    </p>
                @endif
                @if($reEvaluatedAt)
                    <p class="mt-1 text-[11px] text-gray-400">
                        Auto re-evaluated: {{ \Carbon\Carbon::parse($reEvaluatedAt)->format('d M Y H:i') }}
                    </p>
                @endif
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100">
                <form method="POST" action="{{ route('admin.final-test-results.re-evaluate', $result->id ?? $result->ID ?? 0) }}" onsubmit="return confirm('Jalankan kalkulasi ulang evaluasi otomatis? Skor dan matriks diagnostik akan diperbarui sesuai jawaban tersimpan siswa.');">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50 hover:bg-indigo-100 px-4 py-2.5 text-xs font-black text-indigo-700 transition">
                        <svg class="w-4 h-4 animate-spin-reverse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Hitung Ulang Evaluasi Otomatis
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. Form Pengelolaan Evaluasi & Penilaian (Editable by Admin) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden" x-data="{
        score: {{ (float) $overallScore }},
        grammar: {{ (float) ($grammarScore ?? 0) }},
        lexical: {{ (float) ($lexicalScore ?? 0) }},
        accuracy: {{ (float) ($accuracyScore ?? 0) }},
        passed: {{ $isPassed ? 'true' : 'false' }},
        autoSum() {
            const sum = Math.min(100, Math.max(0, parseFloat(this.grammar || 0) + parseFloat(this.lexical || 0) + parseFloat(this.accuracy || 0)));
            this.score = Math.round(sum * 10) / 10;
            this.passed = this.score >= 70;
        }
    }">
        <div class="bg-blue-600 px-6 py-5 flex items-center justify-between text-white">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center font-bold text-lg">
                    ✍️
                </div>
                <div>
                    <h3 class="font-bold text-lg text-white">Panel Pengelolaan &amp; Koreksi Evaluasi Guru</h3>
                    <p class="text-xs text-blue-100">Ubah nilai per kriteria, sesuaikan status kelulusan, dan tulis ulasan kualitatif penguji</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="rounded-lg bg-blue-700 text-white border border-blue-400 text-xs font-bold px-3 py-1">
                    Form Mode Admin
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.final-test-results.update-evaluation', $result->id ?? $result->ID ?? 0) }}" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Top Scoring Metrics Grid -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4 flex items-center gap-2">
                    <span>1. Skor Keseluruhan &amp; Penentuan Kelulusan</span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="rounded-xl border-2 border-indigo-200 bg-indigo-50/40 p-4">
                        <label class="block text-xs font-bold text-indigo-900 mb-1">Skor Akhir (Total 0 - 100)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" step="0.5" min="0" max="100" name="score" x-model="score" required
                                class="w-full text-2xl font-black text-indigo-700 bg-white border border-indigo-300 rounded-xl px-3 py-1.5 focus:ring-indigo-500 focus:border-indigo-500 font-mono">
                            <span class="text-xs font-bold text-gray-400">/ 100</span>
                        </div>
                        <button type="button" @click="autoSum()" class="mt-2 text-[11px] font-bold text-indigo-600 hover:text-indigo-800 underline">
                            ↺ Hitung dari 3 Kriteria
                        </button>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-4">
                        <label class="block text-xs font-bold text-gray-700 mb-2">Status Kelulusan</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center justify-center gap-2 p-2 rounded-lg border text-xs font-bold cursor-pointer transition"
                                :class="passed ? 'border-emerald-400 bg-emerald-50 text-emerald-800' : 'border-gray-200 text-gray-500'">
                                <input type="radio" name="passed" value="1" x-model="passed" :value="true" class="hidden">
                                <span>✅ Lulus</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 p-2 rounded-lg border text-xs font-bold cursor-pointer transition"
                                :class="!passed ? 'border-amber-400 bg-amber-50 text-amber-800' : 'border-gray-200 text-gray-500'">
                                <input type="radio" name="passed" value="0" x-model="passed" :value="false" class="hidden">
                                <span>⚠️ Perlu Review</span>
                            </label>
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-4">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Level CEFR</label>
                        <select name="cefr_level" class="w-full border-gray-300 rounded-xl text-xs font-bold text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="C2 Proficient" {{ $cefrLevel === 'C2 Proficient' ? 'selected' : '' }}>C2 Proficient</option>
                            <option value="C1 Advanced" {{ $cefrLevel === 'C1 Advanced' ? 'selected' : '' }}>C1 Advanced</option>
                            <option value="B2 Upper Intermediate" {{ $cefrLevel === 'B2 Upper Intermediate' ? 'selected' : '' }}>B2 Upper Intermediate</option>
                            <option value="B1 - B2 Intermediate" {{ $cefrLevel === 'B1 - B2 Intermediate' ? 'selected' : '' }}>B1 - B2 Intermediate</option>
                            <option value="B1 Intermediate" {{ $cefrLevel === 'B1 Intermediate' ? 'selected' : '' }}>B1 Intermediate</option>
                            <option value="A2 Elementary" {{ $cefrLevel === 'A2 Elementary' ? 'selected' : '' }}>A2 Elementary</option>
                        </select>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-4">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kesetaraan IELTS Band</label>
                        <input type="text" name="ielts_equivalent" value="{{ $ieltsEquiv }}" placeholder="e.g. IELTS Band 7.5"
                            class="w-full border-gray-300 rounded-xl text-xs font-bold text-gray-900 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Rubrik 3 Kriteria Utama -->
            <div class="pt-6 border-t border-gray-200">
                <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4 flex items-center justify-between">
                    <span>2. Rubrik Penilaian 3 Kriteria Utama</span>
                    <span class="text-xs font-normal text-gray-400">Total poin: 40 + 30 + 30 = 100</span>
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Kriteria 1: Grammar -->
                    <div class="rounded-2xl border border-indigo-200 bg-indigo-50/20 p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-wider text-indigo-700">Kriteria 1 (Bobot 40%)</span>
                            <span class="text-xs font-bold text-gray-400">Maks 40 Poin</span>
                        </div>
                        <h5 class="text-sm font-bold text-gray-900">Grammar &amp; Structural Mastery (10 Modul)</h5>
                        <p class="text-xs text-gray-500">Penguasaan tenses, inversion, modals, complex clauses, gerund/infinitive, comparison.</p>
                        <div class="pt-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nilai Grammar (0 - 40):</label>
                            <input type="number" step="0.5" min="0" max="40" name="grammar_score" x-model="grammar" @input="autoSum()"
                                class="w-full text-lg font-bold text-indigo-700 bg-white border border-gray-300 rounded-xl px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono">
                        </div>
                    </div>

                    <!-- Kriteria 2: Lexical Resource -->
                    <div class="rounded-2xl border border-amber-200 bg-amber-50/20 p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-wider text-amber-700">Kriteria 2 (Bobot 30%)</span>
                            <span class="text-xs font-bold text-gray-400">Maks 30 Poin</span>
                        </div>
                        <h5 class="text-sm font-bold text-gray-900">Lexical Resource &amp; Academic Words</h5>
                        <p class="text-xs text-gray-500">Kecocokan kosakata akademik, istilah formal, dan ketepatan diksi per paragraf.</p>
                        <div class="pt-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nilai Lexical (0 - 30):</label>
                            <input type="number" step="0.5" min="0" max="30" name="lexical_score" x-model="lexical" @input="autoSum()"
                                class="w-full text-lg font-bold text-amber-700 bg-white border border-gray-300 rounded-xl px-3 py-2 focus:ring-amber-500 focus:border-amber-500 font-mono">
                        </div>
                    </div>

                    <!-- Kriteria 3: Translation Accuracy -->
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50/20 p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-wider text-emerald-700">Kriteria 3 (Bobot 30%)</span>
                            <span class="text-xs font-bold text-gray-400">Maks 30 Poin</span>
                        </div>
                        <h5 class="text-sm font-bold text-gray-900">Translation Fidelity &amp; Completeness</h5>
                        <p class="text-xs text-gray-500">Keutuhan makna sumber, kelengkapan klausa, dan kohesi antar kalimat.</p>
                        <div class="pt-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nilai Accuracy (0 - 30):</label>
                            <input type="number" step="0.5" min="0" max="30" name="accuracy_score" x-model="accuracy" @input="autoSum()"
                                class="w-full text-lg font-bold text-emerald-700 bg-white border border-gray-300 rounded-xl px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 font-mono">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Matriks Modul Toggle -->
            @if(!empty($modules))
            <div class="pt-6 border-t border-gray-200">
                <input type="hidden" name="modules_submitted" value="1">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500">3. Matriks Diagnostik {{ count($modules) }} Modul Grammar</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Beri tanda centang pada modul yang dinilai telah dikuasai siswa dengan tepat.</p>
                    </div>
                    <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-200">
                        {{ $answersData['mastered_modules_count'] ?? 0 }} / {{ count($modules) }} Modul Dikuasai
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    @foreach($modules as $mIdx => $mod)
                        @php
                            $isMatched = !empty($mod['matched']) || !empty($mod['mastered']);
                        @endphp
                        <label class="rounded-xl border p-3 cursor-pointer flex flex-col justify-between transition hover:shadow-xs {{ $isMatched ? 'border-emerald-300 bg-emerald-50/40' : 'border-gray-200 bg-gray-50/60' }}">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-mono font-bold uppercase {{ $isMatched ? 'text-emerald-700' : 'text-gray-400' }}">
                                        {{ $mod['tag'] ?? 'M' . $mIdx }}
                                    </span>
                                    <input type="checkbox" name="modules[{{ $mIdx }}]" value="1" {{ $isMatched ? 'checked' : '' }}
                                        class="rounded text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                                </div>
                                <h5 class="text-xs font-bold text-gray-900 mt-1.5 leading-snug">{{ $mod['name'] ?? '' }}</h5>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 italic truncate" title="{{ $mod['hint'] ?? '' }}">{{ $mod['hint'] ?? '' }}</p>
                        </label>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Catatan & Feedback Kualitatif Penguji -->
            <div class="pt-6 border-t border-gray-200 space-y-4">
                <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500">4. Catatan &amp; Ulasan Kualitatif Evaluator (Dilihat Siswa)</h4>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Ulasan Umum / Evaluasi Menyeluruh:</label>
                    <textarea name="feedback_overview" rows="3" class="w-full border-gray-300 rounded-xl text-xs text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 p-3"
                        placeholder="Tulis ulasan umum mengenai terjemahan siswa...">{{ $feedback['overview'] ?? '' }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-emerald-700 mb-1">
                            <span>✅ Poin Keunggulan (Key Strengths)</span>
                            <span class="text-gray-400 font-normal ml-1">(1 poin per baris)</span>
                        </label>
                        <textarea name="feedback_strengths" rows="4" class="w-full border-gray-300 rounded-xl text-xs text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 p-3 font-sans"
                            placeholder="Contoh:&#10;Penerapan negative inversion pada paragraf 1 sudah tepat.&#10;Struktur double comparative pada paragraf 2 sangat lancar.">{{ !empty($feedback['strengths']) ? (is_array($feedback['strengths']) ? implode("\n", $feedback['strengths']) : $feedback['strengths']) : '' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-amber-700 mb-1">
                            <span>⚠️ Rekomendasi Peningkatan (Actionable Improvements)</span>
                            <span class="text-gray-400 font-normal ml-1">(1 poin per baris)</span>
                        </label>
                        <textarea name="feedback_improvements" rows="4" class="w-full border-gray-300 rounded-xl text-xs text-gray-900 focus:ring-amber-500 focus:border-amber-500 p-3 font-sans"
                            placeholder="Contoh:&#10;Perhatikan subjek-verb agreement pada klausa subordinat.&#10;Gunakan kosakata akademik formal seperti irreversible tipping points.">{{ !empty($feedback['improvements']) ? (is_array($feedback['improvements']) ? implode("\n", $feedback['improvements']) : $feedback['improvements']) : '' }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">
                        <span>🔒 Catatan Internal Guru / Admin (Hanya Internal, Tidak Dilihat Siswa)</span>
                    </label>
                    <textarea name="teacher_notes" rows="2" class="w-full border-gray-300 rounded-xl text-xs text-gray-700 bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 p-3"
                        placeholder="Catatan internal penguji atau instruktur untuk arsip pengajaran...">{{ $evaluationData['teacher_notes'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-xs text-gray-500">
                    Perubahan nilai dan catatan akan langsung tersimpan ke profil siswa dan tertera pada sertifikat kelulusan.
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 text-sm font-black shadow-md hover:shadow-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan Evaluasi
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- 3. Perbandingan Jawaban Siswa vs Model Answer & Analisis Word Diff -->
    @if(!empty($paragraphs))
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-6">
        <div class="border-b border-gray-200 pb-4">
            <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                <span>🔍 Analisis Jawaban Terjemahan Per Paragraf</span>
            </h3>
            <p class="text-xs text-gray-500 mt-1">
                Tinjauan detail naskah bahasa Indonesia, jawaban siswa, model answer standar, visual word diff, dan target grammar per paragraf.
            </p>
        </div>

        <div class="space-y-8">
            @foreach($paragraphs as $pNum => $p)
                <div class="rounded-2xl border border-gray-200 bg-gray-50/50 p-5 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-200/80 pb-3">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-600 text-white font-black text-xs">
                                P{{ $pNum }}
                            </span>
                            <h4 class="text-sm font-bold text-gray-900">{{ $p['title'] ?? 'Paragraf ' . $pNum }}</h4>
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold">
                            <span class="rounded-md bg-white border border-gray-200 text-gray-700 px-2.5 py-1">
                                Skor: {{ $p['score'] ?? 0 }} / {{ $p['max_score'] ?? 33 }}
                            </span>
                            <span class="rounded-md bg-indigo-50 border border-indigo-200 text-indigo-700 px-2.5 py-1">
                                {{ $p['word_count'] ?? 0 }} Kata
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-xs">
                        <!-- Teks Sumber ID -->
                        <div class="rounded-xl bg-white border border-gray-200 p-4 space-y-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Naskah Asli (Bahasa Indonesia)</span>
                            <p class="text-gray-800 leading-relaxed font-serif">{{ $p['text_id'] ?? '' }}</p>
                        </div>

                        <!-- Jawaban Siswa -->
                        <div class="rounded-xl bg-white border-2 border-indigo-200/80 p-4 space-y-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600">Jawaban Terjemahan Siswa</span>
                            <p class="text-gray-900 leading-relaxed font-sans font-medium whitespace-pre-wrap">{{ $p['user_answer'] ?? '(Tidak ada jawaban)' }}</p>
                        </div>
                    </div>

                    <!-- Model Answer & Diff -->
                    <div class="rounded-xl bg-white border border-gray-200 p-4 space-y-3">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Model Answer Standar</span>
                            <p class="mt-1 text-xs text-gray-800 leading-relaxed font-sans bg-emerald-50/40 p-3 rounded-lg border border-emerald-100">{{ $p['model_answer'] ?? '' }}</p>
                        </div>

                        @if(!empty($p['formatted_answer']))
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-700">Analisis Word Diff</span>
                            <div class="mt-1 text-xs leading-relaxed bg-slate-50 p-3 rounded-lg border border-slate-200 font-sans">
                                {!! $p['formatted_answer'] !!}
                            </div>
                            <div class="mt-2 flex flex-wrap gap-4 text-[11px] text-gray-500">
                                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Hijau: Tepat</span>
                                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-rose-500"></span> Merah Coret: Kata Kurang Tepat</span>
                                <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-blue-600"></span> Biru Garis Bawah: Kata Kunci Model Terlewat</span>
                            </div>
                        </div>
                        @endif

                        <!-- Grammar Target Checklist -->
                        @if(!empty($p['grammar_targets']))
                        <div class="pt-2 border-t border-gray-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Target Grammar Paragraf Ini</span>
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach($p['grammar_targets'] as $tgt)
                                    <div class="flex items-start gap-2 p-2 rounded-lg border text-xs {{ $tgt['matched'] ? 'border-emerald-200 bg-emerald-50/50 text-emerald-900' : 'border-gray-200 bg-gray-50 text-gray-600' }}">
                                        <span class="font-bold text-sm">{{ $tgt['matched'] ? '✅' : '❌' }}</span>
                                        <div>
                                            <p class="font-bold text-xs">{{ $tgt['name'] ?? '' }}</p>
                                            <p class="text-[10px] text-gray-500 italic mt-0.5">{{ $tgt['hint'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @elseif(!empty($answersData['user_translation']))
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
        <h3 class="font-bold text-base text-gray-900">Naskah Terjemahan Lengkap Siswa</h3>
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 text-xs leading-relaxed text-gray-900 whitespace-pre-wrap font-sans">
            {{ $answersData['user_translation'] }}
        </div>
    </div>
    @endif

    <!-- 4. Raw Data Collapsible Accordion (Technical Inspection) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden" x-data="{ open: false }">
        <button type="button" @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between bg-gray-50/60 hover:bg-gray-100/60 transition text-left">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 flex items-center gap-2">
                <span>⚙️ Inspeksi Data Mentah JSON (Developer / Debug)</span>
            </span>
            <svg class="w-4 h-4 text-gray-500 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div x-show="open" x-cloak class="p-6 border-t border-gray-100 bg-gray-900 text-gray-100">
            <pre class="text-[11px] font-mono overflow-x-auto max-h-96 overflow-y-auto">{{ json_encode($result->answers_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    </div>

</div>
@endsection
