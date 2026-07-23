@extends('layouts.admin')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Montserrat:wght@500;600;700;800&display=swap');

    .certificate-container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0;
    }

    .certificate-canvas {
        --main-color: {{ $certificate->text_color ?: '#0f172a' }};
        position: relative;
        width: 100%;
        max-width: 1000px;
        aspect-ratio: 1.414 / 1; /* Standard A4 Aspect Ratio */
        background-color: #ffffff;
        box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(15, 23, 42, 0.05);
        border-radius: 8px;
        padding: 30px;
        box-sizing: border-box;
        overflow: hidden;
        font-family: 'Inter', sans-serif;
    }

    .cert-bg-pattern {
        position: absolute;
        inset: 0;
        opacity: 0.02;
        background-image: radial-gradient(var(--main-color) 1.5px, transparent 1.5px);
        background-size: 24px 24px;
        pointer-events: none;
        z-index: 0;
    }

    .cert-border-outer {
        border: 4px solid var(--main-color);
        height: 100%;
        box-sizing: border-box;
        padding: 8px;
        position: relative;
        z-index: 1;
    }

    .cert-border-inner {
        border: 1px solid var(--main-color);
        height: 100%;
        box-sizing: border-box;
        padding: 20px 40px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-align: center;
    }

    /* Elegant corner accents */
    .cert-corner {
        position: absolute;
        width: 24px;
        height: 24px;
        border-color: var(--main-color);
        border-style: solid;
        pointer-events: none;
    }
    .cert-corner-tl { top: 8px; left: 8px; border-width: 3px 0 0 3px; }
    .cert-corner-tr { top: 8px; right: 8px; border-width: 3px 3px 0 0; }
    .cert-corner-bl { bottom: 8px; left: 8px; border-width: 0 0 3px 3px; }
    .cert-corner-br { bottom: 8px; right: 8px; border-width: 0 3px 3px 0; }

    .cert-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .cert-logo {
        height: 70px;
        width: auto;
        object-fit: contain;
    }

    .cert-eyebrow {
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.28em;
        text-transform: uppercase;
        color: var(--main-color);
        margin-top: 4px;
    }

    .cert-title {
        font-family: 'Cinzel', Georgia, serif;
        font-size: 38px;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: var(--main-color);
        line-height: 1.2;
        margin-top: 4px;
    }

    .cert-subtitle {
        font-family: 'Playfair Display', Georgia, serif;
        font-style: italic;
        font-size: 17px;
        color: #475569;
        margin-top: 6px;
    }

    .cert-presented-to {
        font-family: 'Playfair Display', Georgia, serif;
        font-style: italic;
        font-size: 15px;
        color: #64748b;
        margin-top: 8px;
    }

    .cert-recipient-name {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 34px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 4px;
        padding-bottom: 6px;
        border-bottom: 2px solid;
        border-image: linear-gradient(to right, transparent, var(--main-color), transparent) 1;
        display: inline-block;
        max-width: 80%;
        word-break: break-word;
        white-space: normal;
    }

    .cert-body-text {
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        line-height: 1.6;
        color: #334155;
        max-width: 650px;
        margin-top: 8px;
    }

    .cert-section-score-grid {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 22px;
        width: 100%;
    }

    .cert-section-score-box {
        flex: 1 1 160px;
        min-width: 150px;
        padding: 14px 16px;
        border-radius: 16px;
        border: 1px solid rgba(15, 23, 42, 0.12);
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 25px -15px rgba(15, 23, 42, 0.08);
        text-align: center;
    }

    /* Vertical list/card style for admin reference layout */
    .cert-score-card {
        width: 100%;
        max-width: 420px;
        background: rgba(255,255,255,0.9);
        border-radius: 12px;
        box-shadow: 0 12px 30px -16px rgba(15,23,42,0.12);
        border: 1px solid rgba(15,23,42,0.06);
        margin: 12px auto 0;
        overflow: hidden;
        box-sizing: border-box;
        padding: 0;
    }

    .cert-score-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 20px;
        border-bottom: 1px solid rgba(15,23,42,0.04);
        font-family: 'Inter', sans-serif;
    }

    .cert-score-row .label {
        color: #334155;
        font-size: 14px;
    }

    .cert-score-row .value {
        color: var(--main-color);
        font-weight: 700;
        font-size: 14px;
    }

    .cert-score-row.total {
        background: rgba(250,250,250,0.8);
        font-weight: 800;
    }

    .cert-section-score-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: #64748b;
        margin-bottom: 8px;
    }

    .cert-section-score-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .cert-footer-layout {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: flex-end;
        gap: 30px;
        margin-top: 10px;
    }

    .cert-footer-col {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .cert-footer-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #64748b;
        margin-bottom: 12px;
    }

    .cert-footer-line {
        width: 160px;
        height: 1px;
        background-color: var(--main-color);
        opacity: 0.3;
        margin-bottom: 10px;
    }

    .cert-footer-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: var(--main-color);
    }

    /* Premium Gold-colored Seal styling */
    .cert-seal-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 140px;
    }

    .cert-seal {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: radial-gradient(circle, #ffffff 0%, #fffbeb 60%, #fef08a 100%);
        border: 3px double var(--main-color);
        box-shadow: 0 10px 25px -5px rgba(250, 204, 21, 0.25), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        z-index: 10;
    }

    .cert-seal-ribbon-l, .cert-seal-ribbon-r {
        position: absolute;
        bottom: -16px;
        width: 24px;
        height: 50px;
        background-color: var(--main-color);
        opacity: 0.85;
        clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 85%, 0 100%);
        z-index: 5;
    }
    .cert-seal-ribbon-l {
        left: 42px;
        transform: rotate(-12deg);
    }
    .cert-seal-ribbon-r {
        right: 42px;
        transform: rotate(12deg);
    }

    .cert-seal-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #475569;
    }

    .cert-seal-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 30px;
        font-weight: 800;
        color: var(--main-color);
        line-height: 1.1;
        margin-top: 2px;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        
        .certificate-canvas, .certificate-canvas * {
            visibility: visible;
        }

        .certificate-canvas {
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 20px !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            transform: none !important;
        }

        /* Set landscape layout for print */
        @page {
            size: A4 landscape;
            margin: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto no-print">
    <div class="flex flex-col gap-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Preview Sertifikat Free Test</h1>
                    <p class="text-sm text-slate-500 mt-1">Lihat tampilan sertifikat berdasarkan template yang disimpan untuk {{ str($certificate->test_type)->replace('_', ' ')->title() }}.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.free-tests.certificates.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">Kembali</a>
                    <button onclick="window.print()" class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition">Cetak Sertifikat</button>
                </div>
            </div>
        </div>

        @php
            $config = $certificate->template_config ?? [];
            $eyebrow = $config['eyebrow'] ?? 'Certificate of Achievement';
            $title = $config['title'] ?? 'Certificate of Completion';
            $subtitle = $config['subtitle'] ?? 'Free Test Practice Result';
            $scoreLabel = $config['score_label'] ?? 'Final Score';
            $bodyText = $config['body'] ?? 'This certificate is awarded to the candidate for successfully completing the free test.';
            $footerLeft = $config['footer_left_label'] ?? 'Date';
            $footerRight = $config['footer_right_label'] ?? 'Authorized Signature';
            $signatureName = $config['signature_name'] ?? 'Target Bahasa';
            $mainColor = $certificate->text_color;

            $hasResult = $result !== null;
            $studentName = $hasResult && $result->user ? $result->user->name : 'Nama Contoh Siswa';
            $evaluationData = $hasResult ? ($result->evaluation_data ?? []) : [];
            $listeningScore = $hasResult ? ($evaluationData['listening_score'] ?? '48') : '48';
            $structureScore = $hasResult ? ($evaluationData['structure_score'] ?? '37') : '37';
            $ieltsL = $hasResult ? ($evaluationData['listening_score'] ?? null) : '9.0';
            $ieltsR = $hasResult ? ($evaluationData['reading_score'] ?? null) : '9.0';
            $ieltsW = $hasResult ? ($evaluationData['writing_score'] ?? null) : '9.0';
            $ieltsS = $hasResult ? ($evaluationData['speaking_score'] ?? null) : '9.0';
            
            $ieltsListening = $ieltsL ?? '-';
            $ieltsReading = $ieltsR ?? '-';
            $ieltsWriting = $ieltsW ?? '-';
            $ieltsSpeaking = $ieltsS ?? '-';

            $scoreValue = $hasResult ? ($result->test_type === 'toefl_itp' ? number_format($evaluationData['toefl_score'] ?? $result->score, 0, '.', '') : $result->score) : '577';
            
            if (in_array($certificate->test_type, ['ielts_academic', 'ielts_general'])) {
                if (is_numeric($ieltsL) && is_numeric($ieltsR) && is_numeric($ieltsW) && is_numeric($ieltsS)) {
                    $avg = ($ieltsL + $ieltsR + $ieltsW + $ieltsS) / 4;
                    // IELTS rounding rules: end in .25 rounds up to .5, .75 rounds up to next whole band.
                    // This is equivalent to round($avg * 2) / 2
                    $scoreValue = number_format(round($avg * 2) / 2, 1, '.', '');
                } else {
                    $scoreValue = '-';
                }
            }
            
            $programLabel = str($certificate->test_type)->replace('_', ' ')->title();
            $certificateDate = $hasResult ? $result->created_at->format('d F Y') : now()->format('d F Y');

            $useGradeScore = in_array($certificate->test_type, [
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
                $scoreInt = (int) ($hasResult ? $result->score : 85);
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

        @if(! $hasResult)
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-800">
                <p class="font-bold text-base">Tidak ada hasil Free Test untuk jenis ini.</p>
                <p class="text-sm mt-1">Menampilkan konten sertifikat contoh. Setelah siswa menyelesaikan Free Test {{ $programLabel }}, preview akan memakai data hasil nyata.</p>
            </div>
        @endif

        <div class="rounded-3xl border border-slate-200 bg-slate-100 p-6 md:p-12 shadow-inner flex justify-center">
            <div class="certificate-container">
                <div class="certificate-canvas">
                    <div class="cert-bg-pattern"></div>
                    
                    @if($certificate->background_image)
                        <div style="position:absolute; inset:0; background-image:url('{{ asset('storage/' . $certificate->background_image) }}'); background-size:cover; background-position:center; opacity:0.18; z-index:0; pointer-events:none;"></div>
                    @endif

                    <div class="cert-border-outer">
                        <div class="cert-corner cert-corner-tl"></div>
                        <div class="cert-corner cert-corner-tr"></div>
                        <div class="cert-corner cert-corner-bl"></div>
                        <div class="cert-corner cert-corner-br"></div>

                        <div class="cert-border-inner">
                            <!-- Logo and Institution -->
                            <div class="cert-header">
                                <img src="{{ asset('images/brand/target-bahasa-logo1.png') }}" class="cert-logo" alt="Target Bahasa Logo">
                            </div>

                            <!-- Header Labels -->
                            <div class="flex flex-col items-center">
                                <div class="cert-eyebrow">{{ $eyebrow }}</div>
                                <h1 class="cert-title">{{ $title }}</h1>
                                <div class="cert-subtitle">{{ $subtitle }}</div>
                            </div>

                            <!-- Presentation Section -->
                            <div class="flex flex-col items-center w-full">
                                <div class="cert-presented-to">This certificate is proudly presented to</div>
                                <div class="cert-recipient-name">{{ $studentName }}</div>
                                <div class="cert-body-text">{{ $bodyText }}</div>

                                @if($certificate->test_type === 'toefl_itp')
                                    <div class="cert-score-card" role="group" aria-label="TOEFL ITP scores">
                                        <div class="cert-score-row">
                                            <div class="label">Listening Comprehension:</div>
                                            <div class="value">{{ $hasResult ? $listeningScore : '-' }}</div>
                                        </div>
                                        <div class="cert-score-row">
                                            <div class="label">Structure &amp; Written Expression:</div>
                                            <div class="value">{{ $hasResult ? $structureScore : '-' }}</div>
                                        </div>
                                        <div class="cert-score-row">
                                            <div class="label">Reading Comprehension:</div>
                                            <div class="value">{{ $hasResult ? $readingScore : '-' }}</div>
                                        </div>
                                        <div class="cert-score-row total">
                                            <div class="label">Total:</div>
                                            <div class="value">{{ $hasResult ? $scoreValue : '-' }}</div>
                                        </div>
                                    </div>
                                @elseif(in_array($certificate->test_type, ['ielts_academic', 'ielts_general']))
                                    <div class="cert-score-card" role="group" aria-label="IELTS scores">
                                        <div class="cert-score-row">
                                            <div class="label">Listening:</div>
                                            <div class="value">{{ $ieltsListening }}</div>
                                        </div>
                                        <div class="cert-score-row">
                                            <div class="label">Reading:</div>
                                            <div class="value">{{ $ieltsReading }}</div>
                                        </div>
                                        <div class="cert-score-row">
                                            <div class="label">Writing:</div>
                                            <div class="value">{{ $ieltsWriting }}</div>
                                        </div>
                                        <div class="cert-score-row">
                                            <div class="label">Speaking:</div>
                                            <div class="value">{{ $ieltsSpeaking }}</div>
                                        </div>
                                        <div class="cert-score-row total">
                                            <div class="label">Overall Band Score:</div>
                                            <div class="value">{{ $scoreValue }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Bottom Layout (Date, Gold Seal, Signature) -->
                            <div class="cert-footer-layout">
                                <div class="cert-footer-col">
                                    <span class="cert-footer-label">{{ $footerLeft }}</span>
                                    <div class="cert-footer-line"></div>
                                    <span class="cert-footer-value">{{ $certificateDate }}</span>
                                </div>

                                @if(!in_array($certificate->test_type, ['toefl_itp', 'ielts_academic', 'ielts_general']))
                                    <div class="cert-seal-wrapper">
                                        <div class="cert-seal-ribbon-l"></div>
                                        <div class="cert-seal-ribbon-r"></div>
                                        <div class="cert-seal">
                                            @if($useGradeScore)
                                                <span class="cert-seal-label" style="font-size: 8px; margin-bottom: 3px;">SCORE: {{ $hasResult ? $result->score : '85' }}</span>
                                                <span class="cert-seal-value" style="font-size: {{ strlen($grammarLevel) > 10 ? '14px' : '18px' }}; text-align: center; line-height: 1.1; margin-top: 0; padding: 0 4px;">{{ $grammarLevel }}</span>
                                            @else
                                                <span class="cert-seal-label">{{ $scoreLabel }}</span>
                                                <span class="cert-seal-value">{{ $hasResult ? $scoreValue : '577' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div></div>
                                @endif

                                <div class="cert-footer-col">
                                    <span class="cert-footer-label">{{ $footerRight }}</span>
                                    <div class="cert-footer-line"></div>
                                    <span class="cert-footer-value">{{ $signatureName }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
