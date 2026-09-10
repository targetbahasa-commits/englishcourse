@extends('layouts.admin')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Playfair+Display:ital,wght@0,600;0,700&family=Montserrat:wght@500;600;700;800&display=swap');

    .mini-cert-canvas {
        position: relative;
        width: 100%;
        max-width: 500px;
        aspect-ratio: 1.414 / 1;
        background-color: #ffffff;
        border-radius: 6px;
        padding: 15px;
        box-sizing: border-box;
        overflow: hidden;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.03);
    }
    .mini-cert-border-outer {
        border: 2.5px solid var(--cert-color, #0f172a);
        height: 100%;
        padding: 5px;
        box-sizing: border-box;
        position: relative;
        z-index: 1;
    }
    .mini-cert-border-inner {
        border: 0.5px solid var(--cert-color, #0f172a);
        height: 100%;
        padding: 15px 25px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-align: center;
    }
    .mini-cert-logo {
        height: 28px;
        width: auto;
        object-fit: contain;
    }
    .mini-cert-eyebrow {
        font-family: 'Montserrat', sans-serif;
        font-size: 7px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--cert-color, #0f172a);
    }
    .mini-cert-title {
        font-family: 'Cinzel', Georgia, serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--cert-color, #0f172a);
        line-height: 1.2;
        margin-top: 2px;
    }
    .mini-cert-subtitle {
        font-family: 'Playfair Display', Georgia, serif;
        font-style: italic;
        font-size: 9px;
        color: #475569;
    }
    .mini-cert-presented {
        font-family: 'Playfair Display', Georgia, serif;
        font-style: italic;
        font-size: 8px;
        color: #64748b;
        margin-top: 6px;
    }
    .mini-cert-name {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
        padding-bottom: 3px;
        border-bottom: 1.5px solid;
        border-image: linear-gradient(to right, transparent, var(--cert-color, #0f172a), transparent) 1;
        display: inline-block;
        min-width: 150px;
    }
    .mini-cert-body {
        font-size: 8px;
        line-height: 1.4;
        color: #334155;
        max-width: 320px;
        margin-top: 6px;
    }
    .mini-cert-footer {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: flex-end;
        gap: 15px;
        margin-top: 10px;
    }
    .mini-cert-col {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .mini-cert-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 6px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
    }
    .mini-cert-line {
        width: 70px;
        height: 1px;
        background-color: var(--cert-color, #0f172a);
        opacity: 0.3;
        margin: 4px 0;
    }
    .mini-cert-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 8px;
        font-weight: 700;
        color: var(--cert-color, #0f172a);
    }
    .mini-cert-seal {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: radial-gradient(circle, #ffffff 0%, #fffbeb 60%, #fef08a 100%);
        border: 1.5px double var(--cert-color, #0f172a);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .mini-cert-seal-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 4px;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
    }
    .mini-cert-seal-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 15px;
        font-weight: 800;
        color: var(--cert-color, #0f172a);
        line-height: 1;
        margin-top: 1px;
    }
    .mini-cert-score-card {
        width: 100%;
        max-width: 200px;
        background: rgba(255,255,255,0.9);
        border-radius: 6px;
        box-shadow: 0 4px 10px -4px rgba(15,23,42,0.12);
        border: 0.5px solid rgba(15,23,42,0.06);
        margin: 6px auto 0;
        overflow: hidden;
        box-sizing: border-box;
        padding: 0;
    }
    .mini-cert-score-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 4px 8px;
        border-bottom: 0.5px solid rgba(15,23,42,0.04);
        font-family: 'Inter', sans-serif;
    }
    .mini-cert-score-row .label {
        color: #334155;
        font-size: 6px;
    }
    .mini-cert-score-row .value {
        color: var(--cert-color, #0f172a);
        font-weight: 700;
        font-size: 6px;
    }
    .mini-cert-score-row.total {
        background: rgba(250,250,250,0.8);
        font-weight: 800;
    }
</style>
@endpush

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Certificates 🎓</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola template sertifikat untuk setiap jenis Free Test dan Program.</p>
        </div>
        <div x-data>
            <button type="button" @click="$dispatch('open-review-modal')" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold transition">
                Preview Review Modal
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach($certificates as $cert)
    @php \Illuminate\Support\Facades\Log::info("test_type: " . $cert->test_type); @endphp
        @php
            $certificateLabels = [
                'toefl_itp' => 'TOEFL ITP',
                'ielts_academic' => 'IELTS Academic',
                'ielts_general' => 'IELTS General',
                'pte_academic' => 'PTE Academic',
                'introductory_grammar_for_writing' => 'Introductory Grammar For Writing',
                'complexity_grammar_for_writing' => 'Complexity Grammar For Writing',
                'proficiency_grammar_for_writing' => 'Proficiency Grammar For Writing',
                'fast_track_grammar_for_writing' => 'Fast Track Grammar For Writing',
                'introductory_speaking' => 'Introductory Speaking',
                'intermediate_speaking' => 'Intermediate Speaking',
                'advanced_speaking' => 'Advanced Speaking',
            ];
            $certificateLabel = $certificateLabels[$cert->test_type] ?? str($cert->test_type)->replace('_', ' ')->title();
            $templateConfig = $cert->template_config ?? [];
            $latestResult = \App\Models\FreeTestResult::where('test_type', $cert->test_type)->latest('id')->first();
        @endphp
        <div class="bg-white shadow-lg rounded-2xl border border-slate-200 p-6 flex flex-col justify-between" x-data="{ openAdvanced: false }">
            <div>
                <h2 class="text-xl font-bold text-slate-800 mb-6 pb-3 border-b border-slate-100">{{ $certificateLabel }}</h2>
                
                <form action="{{ route('admin.free-tests.certificates.update', $cert->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-5">
                        <!-- Background Image Preview -->
                        <div>
                            <p class="text-sm font-semibold text-slate-700 mb-2">Background Saat Ini</p>
                            @if($cert->background_image)
                                <div class="rounded-xl overflow-hidden border border-slate-200 mb-2 h-32 bg-slate-50 relative group">
                                    <img src="{{ route('admin.free-tests.certificates.background', $cert->id) }}" alt="Certificate Background" class="w-full h-full object-contain">
                                </div>
                                <div class="mb-3">
                                    <label class="inline-flex items-center gap-1.5 text-xs text-rose-600 font-medium cursor-pointer">
                                        <input type="checkbox" name="remove_background_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                        Hapus background template
                                    </label>
                                </div>
                            @else
                                <div class="rounded-xl border border-dashed border-slate-300 mb-3 h-32 flex items-center justify-center bg-slate-50">
                                    <span class="text-sm text-slate-400 font-medium">Belum ada template background</span>
                                </div>
                            @endif
                            
                            <input type="file" name="background_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 file:cursor-pointer transition">
                            <p class="text-xs text-slate-400 mt-1.5">Gunakan gambar resolusi tinggi landscape (misal A4 landscape).</p>
                        </div>

                        <!-- Signature and Stamp Upload Section -->
                        <div class="grid gap-4 md:grid-cols-2 pt-2 border-t border-slate-100">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanda Tangan Digital</label>
                                @if(!empty($templateConfig['signature_image']))
                                    <div class="rounded-xl border border-slate-200 p-2 mb-2 bg-slate-50 flex items-center justify-center h-24 relative group">
                                        <img src="{{ route('admin.free-tests.certificates.signature', $cert->id) }}" alt="Tanda Tangan" class="max-h-20 max-w-full object-contain">
                                    </div>
                                    <div class="mb-2">
                                        <label class="inline-flex items-center gap-1.5 text-xs text-rose-600 font-medium cursor-pointer">
                                            <input type="checkbox" name="remove_signature_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                            Hapus tanda tangan
                                        </label>
                                    </div>
                                @else
                                    <div class="rounded-xl border border-dashed border-slate-300 mb-2 h-24 flex items-center justify-center bg-slate-50">
                                        <span class="text-xs text-slate-400 font-medium">Belum ada tanda tangan</span>
                                    </div>
                                @endif
                                <input type="file" name="signature_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 file:cursor-pointer transition">
                                <p class="text-[11px] text-slate-400 mt-1">Disarankan format PNG transparan (maks 3MB).</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Stempel Resmi (Seal/Stamp)</label>
                                @if(!empty($templateConfig['stamp_image']))
                                    <div class="rounded-xl border border-slate-200 p-2 mb-2 bg-slate-50 flex items-center justify-center h-24 relative group">
                                        <img src="{{ route('admin.free-tests.certificates.stamp', $cert->id) }}" alt="Stempel" class="max-h-20 max-w-full object-contain">
                                    </div>
                                    <div class="mb-2">
                                        <label class="inline-flex items-center gap-1.5 text-xs text-rose-600 font-medium cursor-pointer">
                                            <input type="checkbox" name="remove_stamp_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                            Hapus stempel
                                        </label>
                                    </div>
                                @else
                                    <div class="rounded-xl border border-dashed border-slate-300 mb-2 h-24 flex items-center justify-center bg-slate-50">
                                        <span class="text-xs text-slate-400 font-medium">Belum ada stempel</span>
                                    </div>
                                @endif
                                <input type="file" name="stamp_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 file:cursor-pointer transition">
                                <p class="text-[11px] text-slate-400 mt-1">Disarankan format PNG transparan stempel (maks 3MB).</p>
                            </div>
                        </div>

                        <!-- Main Configuration Fields -->
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Penanda Tangan</label>
                                <input type="text" name="signature_name" value="{{ old('signature_name', $templateConfig['signature_name'] ?? 'Target Bahasa') }}" placeholder="Target Bahasa" class="form-input w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Warna Teks Utama</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="text_color" value="{{ old('text_color', $cert->text_color ?: '#0f172a') }}" class="h-10 w-10 p-1 border border-slate-300 rounded-xl cursor-pointer">
                                    <input type="text" name="text_color_preview" value="{{ old('text_color', $cert->text_color ?: '#0f172a') }}" class="form-input rounded-xl border-slate-300 w-32 text-sm" readonly>
                                </div>
                            </div>

                            <div class="flex items-center pt-6">
                                <input type="checkbox" name="is_active" id="active_{{ $cert->id }}" value="1" {{ $cert->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label for="active_{{ $cert->id }}" class="ml-2 text-sm font-semibold text-slate-700">Aktifkan Sertifikat</label>
                            </div>
                        </div>

                        <!-- Collapsible Advanced Settings -->
                        <div class="border border-slate-200 rounded-xl overflow-hidden mt-4">
                            <button type="button" @click="openAdvanced = !openAdvanced" class="flex justify-between items-center w-full px-4 py-3 bg-slate-50 text-slate-700 font-semibold text-sm hover:bg-slate-100 transition">
                                <span>Pengaturan Teks & Label Lanjutan</span>
                                <svg class="w-4 h-4 transform transition-transform duration-200" :class="openAdvanced ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="openAdvanced" class="p-4 border-t border-slate-100 bg-white grid gap-4 md:grid-cols-2" x-cloak>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Eyebrow Sertifikat</label>
                                    <input type="text" name="eyebrow" value="{{ old('eyebrow', $templateConfig['eyebrow'] ?? 'Certificate of Achievement') }}" placeholder="Certificate of Achievement" class="form-input w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Sertifikat</label>
                                    <input type="text" name="title" value="{{ old('title', $templateConfig['title'] ?? 'Certificate of Completion') }}" placeholder="Certificate of Completion" class="form-input w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Subjudul Sertifikat</label>
                                    <input type="text" name="subtitle" value="{{ old('subtitle', $templateConfig['subtitle'] ?? 'Free Test Practice Result') }}" placeholder="Free Test Practice Result" class="form-input w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Label Nilai</label>
                                    <input type="text" name="score_label" value="{{ old('score_label', $templateConfig['score_label'] ?? 'Final Score') }}" placeholder="Final Score" class="form-input w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kalimat Sertifikat</label>
                                    <textarea name="body" rows="3" placeholder="This certificate is awarded to the candidate for successfully completing the free test." class="form-textarea w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('body', $templateConfig['body'] ?? 'This certificate is awarded to the candidate for successfully completing the free test.') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Label Tanggal</label>
                                    <input type="text" name="footer_left_label" value="{{ old('footer_left_label', $templateConfig['footer_left_label'] ?? 'Date') }}" placeholder="Date" class="form-input w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Label Tanda Tangan</label>
                                    <input type="text" name="footer_right_label" value="{{ old('footer_right_label', $templateConfig['footer_right_label'] ?? 'Authorized Signature') }}" placeholder="Authorized Signature" class="form-input w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Tambahan (Opsional)</label>
                                    <input type="text" name="description" value="{{ old('description', $cert->description ?? '') }}" placeholder="Certificate for {{ $certificateLabel }}" class="form-input w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="flex flex-wrap gap-3">
                                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-sm transition">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.free-tests.certificates.preview', $cert->id) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-sm font-semibold transition">
                                    Lihat Preview Penuh
                                </a>

                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="mb-4 text-sm font-bold text-slate-700">Pratinjau Sertifikat</div>
                <div class="flex justify-center bg-slate-100 p-4 rounded-2xl shadow-inner">
                    @php
                        $previewEvaluationData = $latestResult ? $latestResult->evaluation_data ?? [] : [];
                        $previewName = $latestResult && $latestResult->user ? $latestResult->user->name : 'Nama Siswa';
                        $previewListening = $previewEvaluationData['listening_score'] ?? 48;
                        $previewStructure = $previewEvaluationData['structure_score'] ?? 37;
                        $previewReading = $previewEvaluationData['reading_score'] ?? 44;
                        $previewScore = $latestResult
                            ? ($latestResult->test_type === 'toefl_itp'
                                ? number_format($previewEvaluationData['toefl_score'] ?? $latestResult->score, 0, '.', '')
                                : $latestResult->score)
                            : '577';
                        $previewIeltsL = $previewEvaluationData['listening_score'] ?? null;
                        $previewIeltsR = $previewEvaluationData['reading_score'] ?? null;
                        $previewIeltsW = $previewEvaluationData['writing_score'] ?? null;
                        $previewIeltsS = $previewEvaluationData['speaking_score'] ?? null;

                        $previewIeltsListening = $previewIeltsL ?? '-';
                        $previewIeltsReading   = $previewIeltsR ?? '-';
                        $previewIeltsWriting   = $previewIeltsW ?? '-';
                        $previewIeltsSpeaking  = $previewIeltsS ?? '-';

                        if (in_array($cert->test_type, ['ielts_academic', 'ielts_general'])) {
                            if (is_numeric($previewIeltsL) && is_numeric($previewIeltsR) && is_numeric($previewIeltsW) && is_numeric($previewIeltsS)) {
                                $avg = ($previewIeltsL + $previewIeltsR + $previewIeltsW + $previewIeltsS) / 4;
                                $previewScore = number_format(round($avg * 2) / 2, 1, '.', '');
                            } else {
                                $previewScore = '-';
                            }
                        }

                        $useGradeScore = in_array($cert->test_type, [
                            'introductory_grammar_for_writing',
                            'complexity_grammar_for_writing',
                            'proficiency_grammar_for_writing',
                            'fast_track_grammar_for_writing',
                            'introductory_speaking',
                            'intermediate_speaking',
                            'advanced_speaking',
                        ]);

                        $grammarLevel = '-';
                        if ($useGradeScore) {
                            $scoreInt = (int) ($latestResult ? $latestResult->score : 85);
                            $previewScore = $latestResult ? $latestResult->score : '85';
                            if ($scoreInt >= 90) {
                                $grammarLevel = 'Distinction';
                            } elseif ($scoreInt >= 80) {
                                $grammarLevel = 'High Merit';
                            } elseif ($scoreInt >= 70) {
                                $grammarLevel = 'Merit';
                            } elseif ($scoreInt >= 60) {
                                $grammarLevel = 'Pass with Credit';
                            } elseif ($scoreInt >= 50) {
                                $grammarLevel = 'Pass';
                            } else {
                                $grammarLevel = 'Fail';
                            }
                        }
                    @endphp

                    <div class="mini-cert-canvas" style="--cert-color: {{ $cert->text_color ?: '#0f172a' }};">
                        @if($cert->background_image)
                            <div style="position:absolute; inset:0; background-image:url('{{ route('admin.free-tests.certificates.background', $cert->id) }}'); background-size:cover; background-position:center; opacity:0.15; z-index:0; pointer-events:none;"></div>
                        @endif
                        <div class="mini-cert-border-outer">
                            <div class="mini-cert-border-inner">
                                <!-- Logo -->
                                <img src="{{ asset('images/brand/target-bahasa-logo1.png') }}" class="mini-cert-logo" alt="Logo">
                                
                                <!-- Header info -->
                                <div>
                                    <div class="mini-cert-eyebrow">{{ $templateConfig['eyebrow'] ?? 'Certificate of Achievement' }}</div>
                                    <h4 class="mini-cert-title">{{ $templateConfig['title'] ?? 'Certificate of Completion' }}</h4>
                                    <div class="mini-cert-subtitle">{{ $templateConfig['subtitle'] ?? 'Free Test Practice Result' }}</div>
                                </div>

                                <!-- Presentation -->
                                <div>
                                    <div class="mini-cert-presented">This certificate is proudly presented to</div>
                                    <div class="mini-cert-name">{{ $previewName }}</div>
                                    <div class="mini-cert-body">
                                        {{ $templateConfig['body'] ?? 'This certificate is awarded to the candidate for successfully completing the free test.' }}
                                    </div>
                                </div>

                                @if($cert->test_type === 'toefl_itp')
                                    <div class="mini-cert-score-card">
                                        <div class="mini-cert-score-row">
                                            <div class="label">Listening Comprehension:</div>
                                            <div class="value">{{ $previewListening }}</div>
                                        </div>
                                        <div class="mini-cert-score-row">
                                            <div class="label">Structure &amp; Written Expression:</div>
                                            <div class="value">{{ $previewStructure }}</div>
                                        </div>
                                        <div class="mini-cert-score-row">
                                            <div class="label">Reading Comprehension:</div>
                                            <div class="value">{{ $previewReading }}</div>
                                        </div>
                                        <div class="mini-cert-score-row total">
                                            <div class="label">Total:</div>
                                            <div class="value">{{ $previewScore }}</div>
                                        </div>
                                    </div>

                                    <div class="mini-cert-footer" style="margin-top: 10px;">
                                        <div class="mini-cert-col">
                                            <span class="mini-cert-label">{{ $templateConfig['footer_left_label'] ?? 'Date' }}</span>
                                            <div style="height: {{ (!empty($templateConfig['signature_image']) || !empty($templateConfig['stamp_image'])) ? '34px' : '10px' }};"></div>
                                            <div class="mini-cert-line"></div>
                                            <span class="mini-cert-value">{{ now()->format('d M Y') }}</span>
                                        </div>
                                        
                                        <div></div>

                                        <div class="mini-cert-col">
                                            <span class="mini-cert-label">{{ $templateConfig['footer_right_label'] ?? 'Authorized Signature' }}</span>
                                            <div class="mini-cert-signature-wrap" style="position: relative; height: {{ (!empty($templateConfig['signature_image']) || !empty($templateConfig['stamp_image'])) ? '34px' : '10px' }}; width: 80px; display: flex; align-items: center; justify-content: center;">
                                                @if(!empty($templateConfig['stamp_image']))
                                                    <img src="{{ route('admin.free-tests.certificates.stamp', $cert->id) }}" alt="Stamp" style="position: absolute; left: 2px; bottom: -3px; height: 32px; max-width: 38px; object-fit: contain; opacity: 0.88; transform: rotate(-6deg); pointer-events: none; z-index: 1;">
                                                @endif
                                                @if(!empty($templateConfig['signature_image']))
                                                    <img src="{{ route('admin.free-tests.certificates.signature', $cert->id) }}" alt="Signature" style="position: relative; max-height: 32px; max-width: 76px; object-fit: contain; z-index: 2;">
                                                @endif
                                            </div>
                                            <div class="mini-cert-line"></div>
                                            <span class="mini-cert-value">{{ $templateConfig['signature_name'] ?? 'Target Bahasa' }}</span>
                                        </div>
                                    </div>
                                @elseif(in_array($cert->test_type, ['ielts_academic', 'ielts_general']))
                                    <div class="mini-cert-score-card">
                                        <div class="mini-cert-score-row">
                                            <div class="label">Listening:</div>
                                            <div class="value">{{ $previewIeltsListening }}</div>
                                        </div>
                                        <div class="mini-cert-score-row">
                                            <div class="label">Reading:</div>
                                            <div class="value">{{ $previewIeltsReading }}</div>
                                        </div>
                                        <div class="mini-cert-score-row">
                                            <div class="label">Writing:</div>
                                            <div class="value">{{ $previewIeltsWriting }}</div>
                                        </div>
                                        <div class="mini-cert-score-row">
                                            <div class="label">Speaking:</div>
                                            <div class="value">{{ $previewIeltsSpeaking }}</div>
                                        </div>
                                        <div class="mini-cert-score-row total">
                                            <div class="label">Overall Band Score:</div>
                                            <div class="value">{{ $previewScore }}</div>
                                        </div>
                                    </div>

                                    <div class="mini-cert-footer" style="margin-top: 10px;">
                                        <div class="mini-cert-col">
                                            <span class="mini-cert-label">{{ $templateConfig['footer_left_label'] ?? 'Date' }}</span>
                                            <div style="height: {{ (!empty($templateConfig['signature_image']) || !empty($templateConfig['stamp_image'])) ? '34px' : '10px' }};"></div>
                                            <div class="mini-cert-line"></div>
                                            <span class="mini-cert-value">{{ now()->format('d M Y') }}</span>
                                        </div>
                                        
                                        <div></div>

                                        <div class="mini-cert-col">
                                            <span class="mini-cert-label">{{ $templateConfig['footer_right_label'] ?? 'Authorized Signature' }}</span>
                                            <div class="mini-cert-signature-wrap" style="position: relative; height: {{ (!empty($templateConfig['signature_image']) || !empty($templateConfig['stamp_image'])) ? '34px' : '10px' }}; width: 80px; display: flex; align-items: center; justify-content: center;">
                                                @if(!empty($templateConfig['stamp_image']))
                                                    <img src="{{ route('admin.free-tests.certificates.stamp', $cert->id) }}" alt="Stamp" style="position: absolute; left: 2px; bottom: -3px; height: 32px; max-width: 38px; object-fit: contain; opacity: 0.88; transform: rotate(-6deg); pointer-events: none; z-index: 1;">
                                                @endif
                                                @if(!empty($templateConfig['signature_image']))
                                                    <img src="{{ route('admin.free-tests.certificates.signature', $cert->id) }}" alt="Signature" style="position: relative; max-height: 32px; max-width: 76px; object-fit: contain; z-index: 2;">
                                                @endif
                                            </div>
                                            <div class="mini-cert-line"></div>
                                            <span class="mini-cert-value">{{ $templateConfig['signature_name'] ?? 'Target Bahasa' }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="mini-cert-footer">
                                        <div class="mini-cert-col">
                                            <span class="mini-cert-label">{{ $templateConfig['footer_left_label'] ?? 'Date' }}</span>
                                            <div style="height: {{ (!empty($templateConfig['signature_image']) || !empty($templateConfig['stamp_image'])) ? '34px' : '10px' }};"></div>
                                            <div class="mini-cert-line"></div>
                                            <span class="mini-cert-value">{{ now()->format('d M Y') }}</span>
                                        </div>
                                        
                                        <div class="mini-cert-seal">
                                            @if($useGradeScore)
                                                <span class="mini-cert-seal-label" style="font-size: 3px; margin-bottom: 1px;">SCORE: {{ $previewScore }}</span>
                                                <span class="mini-cert-seal-value" style="font-size: {{ strlen($grammarLevel) > 10 ? '5px' : '7px' }}; text-align: center; line-height: 1.1; margin-top: 0; padding: 0 1px;">{{ $grammarLevel }}</span>
                                            @else
                                                <span class="mini-cert-seal-label">{{ $templateConfig['score_label'] ?? 'Score' }}</span>
                                                <span class="mini-cert-seal-value">{{ $previewScore }}</span>
                                            @endif
                                        </div>

                                        <div class="mini-cert-col">
                                            <span class="mini-cert-label">{{ $templateConfig['footer_right_label'] ?? 'Authorized Signature' }}</span>
                                            <div class="mini-cert-signature-wrap" style="position: relative; height: {{ (!empty($templateConfig['signature_image']) || !empty($templateConfig['stamp_image'])) ? '34px' : '10px' }}; width: 80px; display: flex; align-items: center; justify-content: center;">
                                                @if(!empty($templateConfig['stamp_image']))
                                                    <img src="{{ route('admin.free-tests.certificates.stamp', $cert->id) }}" alt="Stamp" style="position: absolute; left: 2px; bottom: -3px; height: 32px; max-width: 38px; object-fit: contain; opacity: 0.88; transform: rotate(-6deg); pointer-events: none; z-index: 1;">
                                                @endif
                                                @if(!empty($templateConfig['signature_image']))
                                                    <img src="{{ route('admin.free-tests.certificates.signature', $cert->id) }}" alt="Signature" style="position: relative; max-height: 32px; max-width: 76px; object-fit: contain; z-index: 2;">
                                                @endif
                                            </div>
                                            <div class="mini-cert-line"></div>
                                            <span class="mini-cert-value">{{ $templateConfig['signature_name'] ?? 'Target Bahasa' }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
</div>

    </div>

    <!-- Review Modal Preview -->
    <div x-data="{ showReviewModal: false }" @open-review-modal.window="showReviewModal = true" x-show="showReviewModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                        <button type="button" @click="showReviewModal = false; alert('Ini hanya preview. Saat diklik, siswa akan diarahkan ke Google Maps.');"
                           class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-3 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            ⭐ Berikan Ulasan Bintang 5 di Google
                        </button>
                        <button type="button" @click="showReviewModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-3.5 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0">
                            Nanti saja
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
