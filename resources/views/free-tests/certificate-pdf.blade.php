<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Free Test - {{ $testName }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: {{ $certificate->text_color ?: '#0f172a' }};
        }

        .cert-page {
            position: relative;
            width: 297mm;
            height: 210mm;
            padding: 20mm;
            box-sizing: border-box;
            overflow: hidden;
            background-color: #ffffff;
        }

        .cert-bg-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0.18;
            z-index: 0;
        }

        .cert-border-outer {
            border: 4px solid {{ $certificate->text_color ?: '#0f172a' }};
            height: 100%;
            box-sizing: border-box;
            padding: 8px;
            position: relative;
            z-index: 1;
        }

        .cert-border-inner {
            border: 1px solid {{ $certificate->text_color ?: '#0f172a' }};
            height: 100%;
            box-sizing: border-box;
            padding: 25px 45px;
            position: relative;
            text-align: center;
        }

        /* Ornate corners */
        .cert-corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border-color: {{ $certificate->text_color ?: '#0f172a' }};
            border-style: solid;
        }
        .cert-corner-tl { top: 8px; left: 8px; border-width: 3px 0 0 3px; }
        .cert-corner-tr { top: 8px; right: 8px; border-width: 3px 3px 0 0; }
        .cert-corner-bl { bottom: 8px; left: 8px; border-width: 0 0 3px 3px; }
        .cert-corner-br { bottom: 8px; right: 8px; border-width: 0 3px 3px 0; }

        .cert-header {
            margin-top: 10px;
            text-align: center;
        }

        .cert-logo {
            height: 54px;
            width: auto;
        }

        .cert-eyebrow {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 18px;
        }

        .cert-title {
            font-size: 38px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 8px;
            line-height: 1.1;
        }

        .cert-subtitle {
            font-size: 16px;
            color: #475569;
            margin-top: 6px;
            font-style: italic;
        }

        .cert-presented-to {
            font-size: 15px;
            color: #64748b;
            margin-top: 22px;
            font-style: italic;
        }

        .cert-recipient-name {
            font-size: 34px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 8px;
            border-bottom: 2px solid {{ $certificate->text_color ?: '#0f172a' }};
            display: inline-block;
            padding-bottom: 5px;
        }

        .cert-body-text {
            font-size: 14px;
            line-height: 1.6;
            color: #334155;
            max-width: 620px;
            margin: 18px auto 0;
        }

        .section-score-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 22px;
            width: 100%;
        }

        .section-score-box {
            flex: 1 1 170px;
            min-width: 155px;
            padding: 16px 18px;
            border-radius: 18px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background-color: rgba(255, 255, 255, 0.94);
            box-shadow: 0 8px 20px -12px rgba(15, 23, 42, 0.15);
        }

        .section-score-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: #64748b;
            margin-bottom: 8px;
        }

        .section-score-value {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }
    </style>
</head>
<body>
    @php
        $templateConfig = $certificate->template_config ?? [];
        $eyebrow = $templateConfig['eyebrow'] ?? 'Certificate of Achievement';
        $title = $templateConfig['title'] ?? 'Certificate of Completion';
        $subtitle = $templateConfig['subtitle'] ?? 'Free Test Practice Result';
        $scoreLabel = $templateConfig['score_label'] ?? 'Final Score';
        $bodyText = $templateConfig['body'] ?? 'This certificate is awarded to the candidate for successfully completing the free test.';
        $footerLeft = $templateConfig['footer_left_label'] ?? 'Date';
        $footerRight = $templateConfig['footer_right_label'] ?? 'Authorized Signature';
        $signatureName = $templateConfig['signature_name'] ?? 'Target Bahasa';
    @endphp

    <div class="cert-page">
        @if($certificate->background_image)
            <img src="{{ storage_path('app/public/' . $certificate->background_image) }}" class="cert-bg-image" alt="Background image">
        @endif

        <div class="cert-border-outer">
            <div class="cert-corner cert-corner-tl"></div>
            <div class="cert-corner cert-corner-tr"></div>
            <div class="cert-corner cert-corner-bl"></div>
            <div class="cert-corner cert-corner-br"></div>

            <div class="cert-border-inner">
                <!-- Logo and Institution -->
                <div class="cert-header">
                    <img src="{{ public_path('images/brand/target-bahasa-logo1.png') }}" class="cert-logo" alt="Target Bahasa Logo">
                </div>

                <!-- Header Labels -->
                <div class="cert-eyebrow" style="color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $eyebrow }}</div>
                <div class="cert-title" style="color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $title }}</div>
                <div class="cert-subtitle">{{ $subtitle }}</div>

                <!-- Presentation Section -->
                <div class="cert-presented-to">This certificate is proudly presented to</div>
                <div class="cert-recipient-name">{{ $user->name }}</div>
                <div class="cert-body-text">{{ $bodyText }}</div>

                @php
                    $evaluationData = $result->evaluation_data ?? [];
                    $listeningScore = $evaluationData['listening_score'] ?? null;
                    $structureScore = $evaluationData['structure_score'] ?? null;
                    $readingScore = $evaluationData['reading_score'] ?? null;
                    $certificateToeflScore = $evaluationData['toefl_score'] ?? $result->score;

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
                        $scoreInt = (int) $result->score;
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

                @if($result->test_type === 'toefl_itp')
                    <div class="section-score-grid" role="table" aria-label="TOEFL ITP section scores">
                        <div class="section-score-box" role="row">
                            <div class="section-score-label">Listening Comprehension</div>
                            <div class="section-score-value">{{ $listeningScore ?? '—' }}</div>
                        </div>
                        <div class="section-score-box" role="row">
                            <div class="section-score-label">Structure &amp; Written Expression</div>
                            <div class="section-score-value">{{ $structureScore ?? '—' }}</div>
                        </div>
                        <div class="section-score-box" role="row">
                            <div class="section-score-label">Reading Comprehension</div>
                            <div class="section-score-value">{{ $readingScore ?? '—' }}</div>
                        </div>
                    </div>
                    <div style="margin-top:18px; text-align:center;">
                        <div style="display:inline-block; padding:12px 18px; border-radius:18px; background:#fff; border:1px solid rgba(15,23,42,0.06);">
                            <div style="font-size:11px; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:0.12em;">Total</div>
                            <div style="font-size:26px; font-weight:800; color: {{ $certificate->text_color ?: '#0f172a' }}; margin-top:4px;">{{ number_format($certificateToeflScore ?? $result->score, 0, '.', '') }}</div>
                        </div>
                    </div>
                @endif

                <!-- Bottom Layout (Date, Gold Seal, Signature) -->
                <table style="width: 100%; border-collapse: collapse; margin-top: 35px; vertical-align: bottom;">
                    <tr>
                        <!-- Date -->
                        <td style="width: 38%; text-align: center; vertical-align: bottom; padding-bottom: 2px;">
                            <div style="font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #64748b; margin-bottom: 10px;">{{ $footerLeft }}</div>
                            <div style="width: 140px; height: 1px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.3; margin: 0 auto 8px;"></div>
                            <div style="font-size: 13px; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $date }}</div>
                        </td>
                        
                        <!-- Seal -->
                        <td style="width: 24%; text-align: center; vertical-align: bottom;">
                            <div style="position: relative; width: 120px; height: 130px; margin: 0 auto;">
                                <!-- Ribbons -->
                                <div style="position: absolute; bottom: 10px; left: 32px; width: 20px; height: 48px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.85; z-index: 5;"></div>
                                <div style="position: absolute; bottom: 10px; right: 32px; width: 20px; height: 48px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.85; z-index: 5;"></div>
                                <!-- Seal Circle -->
                                <div style="width: 100px; height: 100px; border-radius: 50px; background-color: #fffbeb; border: 3px double {{ $certificate->text_color ?: '#0f172a' }}; margin: 0 auto; padding-top: 20px; box-sizing: border-box; position: relative; z-index: 10; text-align: center;">
                                    @if($useGradeScore)
                                        <span style="font-size: 9px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #475569; display: block; line-height: 1;">SCORE: {{ $result->score }}</span>
                                        <span style="font-size: {{ strlen($grammarLevel) > 10 ? '13px' : '16px' }}; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }}; display: block; margin-top: 5px; line-height: 1.1; padding: 0 2px;">{{ $grammarLevel }}</span>
                                    @else
                                        <span style="font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #475569; display: block; line-height: 1;">{{ $scoreLabel }}</span>
                                        <span style="font-size: 30px; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }}; display: block; margin-top: 2px; line-height: 1;">{{ $result->test_type === 'toefl_itp' ? number_format($certificateToeflScore, 0, '.', '') : $result->score }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        <!-- Signature -->
                        <td style="width: 38%; text-align: center; vertical-align: bottom; padding-bottom: 2px;">
                            <div style="font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #64748b; margin-bottom: 10px;">{{ $footerRight }}</div>
                            <div style="width: 140px; height: 1px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.3; margin: 0 auto 8px;"></div>
                            <div style="font-size: 13px; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $signatureName }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
