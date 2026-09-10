<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Free Test - {{ $testName ?? 'Free Test' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <style>
        {{-- DomPDF can't fetch Google Fonts' @import/remote CSS reliably, so
             .cert-title/.cert-subtitle/.cert-presented-to/.cert-recipient-name
             below silently fell back to Times New Roman in the actual PDF
             even though this file already declared 'Cinzel'/'Playfair Display'
             as the font-family - only the browser-rendered admin preview
             (which loads them via a real @import) ever showed the real
             fonts. Embedding the exact weights/styles actually used here
             (see those classes) as local @font-face files is what DomPDF
             needs to render them for real. base_path(), not public_path() -
             see this deployment's public_path() override quirk noted
             elsewhere in this file. --}}
        @font-face {
            font-family: 'Cinzel';
            font-style: normal;
            font-weight: 700;
            src: url('{{ base_path('public/fonts/certificate/Cinzel-Bold.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Playfair Display';
            font-style: italic;
            font-weight: 400;
            src: url('{{ base_path('public/fonts/certificate/PlayfairDisplay-Italic.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Playfair Display';
            font-style: normal;
            font-weight: 700;
            src: url('{{ base_path('public/fonts/certificate/PlayfairDisplay-Bold.ttf') }}') format('truetype');
        }
        @page {
            size: 297mm 210mm;
            margin: 0;
        }
        body, html {
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
            background-color: #ffffff;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: {{ $certificate->text_color ?: '#0f172a' }};
        }

        .cert-page {
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
        }

        .cert-bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            opacity: 0.6;
            z-index: -1;
        }

        .cert-border-outer {
            position: absolute;
            top: 10mm;
            left: 12mm;
            width: 268mm;
            height: 190mm;
            border: 4px solid {{ $certificate->text_color ?: '#0f172a' }};
            box-sizing: border-box;
            padding: 5px;
            z-index: 1;
        }

        .cert-border-inner {
            border: 1px solid {{ $certificate->text_color ?: '#0f172a' }};
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 24px 35px 16px 35px;
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
        .cert-corner-tl { top: 6px; left: 6px; border-width: 3px 0 0 3px; }
        .cert-corner-tr { top: 6px; right: 6px; border-width: 3px 3px 0 0; }
        .cert-corner-bl { bottom: 6px; left: 6px; border-width: 0 0 3px 3px; }
        .cert-corner-br { bottom: 6px; right: 6px; border-width: 0 3px 3px 0; }

        .cert-header {
            margin-top: 10px;
            text-align: center;
        }

        .cert-logo {
            height: 70px;
            width: auto;
        }

        .cert-eyebrow {
            font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-top: 12px;
        }

        .cert-title {
            font-family: 'Cinzel', Georgia, 'Times New Roman', serif;
            font-size: 40px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 8px;
            line-height: 1.15;
        }

        .cert-subtitle {
            font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
            font-size: 17px;
            color: #475569;
            margin-top: 6px;
            font-style: italic;
        }

        .cert-presented-to {
            font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
            font-size: 15px;
            color: #64748b;
            margin-top: 22px;
            font-style: italic;
        }

        .cert-recipient-name {
            font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
            font-size: 38px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 8px;
            display: inline-block;
        }

        .cert-recipient-line {
            width: 360px;
            height: 2px;
            background-color: {{ $certificate->text_color ?: '#0f172a' }};
            opacity: 0.35;
            margin: 8px auto 0;
        }

        .cert-body-text {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            color: #334155;
            max-width: 660px;
            margin: 20px auto 0;
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
        $hasScoreTable = in_array($result->test_type, ['toefl_itp', 'ielts_academic', 'ielts_general']);

        // Prepare Base64 Signature Image for DomPDF
        $signatureBase64 = null;
        if (!empty($templateConfig['signature_image'])) {
            $sigPath = storage_path('app/public/' . $templateConfig['signature_image']);
            if (file_exists($sigPath)) {
                $ext = strtolower(pathinfo($sigPath, PATHINFO_EXTENSION));
                $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : (($ext === 'webp') ? 'image/webp' : 'image/png');
                $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($sigPath));
            }
        }

        // Prepare Base64 Stamp Image for DomPDF
        $stampBase64 = null;
        if (!empty($templateConfig['stamp_image'])) {
            $stPath = storage_path('app/public/' . $templateConfig['stamp_image']);
            if (file_exists($stPath)) {
                $ext = strtolower(pathinfo($stPath, PATHINFO_EXTENSION));
                $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : (($ext === 'webp') ? 'image/webp' : 'image/png');
                $stampBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($stPath));
            }
        }
        $hasSigOrStamp = ($signatureBase64 !== null || $stampBase64 !== null);

        // Prepare Base64 Background Image for DomPDF
        $backgroundBase64 = null;
        if (!empty($certificate->background_image)) {
            $bgCandidates = [
                storage_path('app/public/' . $certificate->background_image),
                public_path('storage/' . $certificate->background_image),
                public_path($certificate->background_image),
                base_path('storage/app/public/' . $certificate->background_image),
            ];
            foreach ($bgCandidates as $cand) {
                if (file_exists($cand)) {
                    $ext = strtolower(pathinfo($cand, PATHINFO_EXTENSION));
                    $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : (($ext === 'webp') ? 'image/webp' : 'image/png');
                    $backgroundBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($cand));
                    break;
                }
            }
        }
    @endphp

    <div class="cert-page">
        @if($backgroundBase64)
            <img src="{{ $backgroundBase64 }}" class="cert-bg-image" alt="Background image">
        @endif

        <div class="cert-border-outer">
            <div class="cert-corner cert-corner-tl"></div>
            <div class="cert-corner cert-corner-tr"></div>
            <div class="cert-corner cert-corner-bl"></div>
            <div class="cert-corner cert-corner-br"></div>

            <div class="cert-border-inner" style="padding: {{ $hasScoreTable ? '20px 35px 14px 35px' : '28px 35px 18px 35px' }};">
                <!-- Logo and Institution -->
                <div class="cert-header" style="margin-top: {{ $hasScoreTable ? '4px' : '20px' }};">
                    <img src="{{ base_path('public/images/brand/target-bahasa-logo1.png') }}" class="cert-logo" alt="Target Bahasa Logo">
                </div>

                <!-- Header Labels -->
                <div class="cert-eyebrow" style="color: {{ $certificate->text_color ?: '#0f172a' }}; margin-top: {{ $hasScoreTable ? '10px' : '16px' }};">{{ $eyebrow }}</div>
                <div class="cert-title" style="color: {{ $certificate->text_color ?: '#0f172a' }}; margin-top: {{ $hasScoreTable ? '6px' : '10px' }};">{{ $title }}</div>
                <div class="cert-subtitle" style="margin-top: {{ $hasScoreTable ? '6px' : '8px' }};">{{ $subtitle }}</div>

                <!-- Presentation Section -->
                <div class="cert-presented-to" style="margin-top: {{ $hasScoreTable ? '14px' : '30px' }};">This certificate is proudly presented to</div>
                <div class="cert-recipient-name" style="margin-top: {{ $hasScoreTable ? '6px' : '10px' }};">{{ $user->name }}</div>
                <div class="cert-recipient-line"></div>
                <div class="cert-body-text" style="margin-top: {{ $hasScoreTable ? '12px' : '24px' }};">{{ $bodyText }}</div>

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
                    <table style="width: 360px; margin: 8px auto 0; border: 1px solid rgba(15,23,42,0.12); border-collapse: collapse; background: #ffffff;">
                        <tr>
                            <td style="padding: 3px 12px; font-size: 10.5px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Listening Comprehension:</td>
                            <td style="padding: 3px 12px; font-size: 10.5px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $listeningScore ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 12px; font-size: 10.5px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Structure &amp; Written Expression:</td>
                            <td style="padding: 3px 12px; font-size: 10.5px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $structureScore ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 12px; font-size: 10.5px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Reading Comprehension:</td>
                            <td style="padding: 3px 12px; font-size: 10.5px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $readingScore ?? '-' }}</td>
                        </tr>
                        <tr style="background: rgba(248,250,252,0.9);">
                            <td style="padding: 4px 12px; font-size: 11px; font-weight: bold; color: #0f172a; text-align: left;">Total:</td>
                            <td style="padding: 4px 12px; font-size: 12px; font-weight: 800; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ number_format($certificateToeflScore ?? $result->score, 0, '.', '') }}</td>
                        </tr>
                    </table>
                @elseif(in_array($certificate->test_type, ['ielts_academic', 'ielts_general']))
                    @php
                        $ieltsL = $evaluationData['listening_score'] ?? null;
                        $ieltsR = $evaluationData['reading_score'] ?? null;
                        $ieltsW = $evaluationData['writing_score'] ?? null;
                        $ieltsS = $evaluationData['speaking_score'] ?? null;
                        $scoreValue = floatval($result->score);
                        if (is_numeric($ieltsL) && is_numeric($ieltsR) && is_numeric($ieltsW) && is_numeric($ieltsS)) {
                            $avg = ($ieltsL + $ieltsR + $ieltsW + $ieltsS) / 4;
                            $scoreValue = number_format(round($avg * 2) / 2, 1, '.', '');
                        }
                    @endphp
                    <table style="width: 360px; margin: 8px auto 0; border: 1px solid rgba(15,23,42,0.12); border-collapse: collapse; background: #ffffff;">
                        <tr>
                            <td style="padding: 2px 12px; font-size: 10.5px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Listening:</td>
                            <td style="padding: 2px 12px; font-size: 10.5px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $ieltsL ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 12px; font-size: 10.5px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Reading:</td>
                            <td style="padding: 2px 12px; font-size: 10.5px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $ieltsR ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 12px; font-size: 10.5px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Writing:</td>
                            <td style="padding: 2px 12px; font-size: 10.5px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $ieltsW ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px 12px; font-size: 10.5px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Speaking:</td>
                            <td style="padding: 2px 12px; font-size: 10.5px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $ieltsS ?? '-' }}</td>
                        </tr>
                        <tr style="background: rgba(248,250,252,0.9);">
                            <td style="padding: 3px 12px; font-size: 11px; font-weight: bold; color: #0f172a; text-align: left;">Overall Band Score:</td>
                            <td style="padding: 3px 12px; font-size: 12px; font-weight: 800; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $scoreValue }}</td>
                        </tr>
                    </table>
                @endif

                @php
                    $hasScoreTable = in_array($result->test_type, ['toefl_itp', 'ielts_academic', 'ielts_general']);
                @endphp
                <!-- Bottom Layout (Date, Gold Seal, Signature) -->
                <table style="width: 100%; border-collapse: collapse; margin-top: {{ $hasScoreTable ? '30mm' : '72px' }}; vertical-align: bottom;">
                    <tr>
                        <!-- Date -->
                        <td style="width: 37%; text-align: center; vertical-align: bottom; padding-bottom: 2px;">
                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #64748b; margin-bottom: 12px;">{{ $footerLeft }}</div>
                            <div style="height: {{ $hasSigOrStamp ? '110px' : '20px' }};"></div>
                            <div style="width: 220px; height: 1px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.3; margin: 0 auto 10px;"></div>
                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 15px; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $date ?? (isset($result->created_at) ? $result->created_at->format('d F Y') : date('d F Y')) }}</div>
                        </td>
                        
                        <!-- Seal -->
                        <td style="width: 26%; text-align: center; vertical-align: bottom;">
                            @if(!in_array($certificate->test_type, ['toefl_itp', 'ielts_academic', 'ielts_general']))
                                <div style="position: relative; width: 140px; height: 120px; margin: 0 auto;">
                                    <!-- Hanging Ribbons -->
                                    <div style="position: absolute; bottom: -8px; left: 41px; width: 25px; height: 50px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.85; z-index: 1;">
                                        <div style="position: absolute; bottom: 0; left: 0; width: 0; height: 0; border-left: 12.5px solid transparent; border-right: 12.5px solid transparent; border-bottom: 9px solid #ffffff;"></div>
                                    </div>
                                    <div style="position: absolute; bottom: -8px; right: 41px; width: 25px; height: 50px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.85; z-index: 1;">
                                        <div style="position: absolute; bottom: 0; left: 0; width: 0; height: 0; border-left: 12.5px solid transparent; border-right: 12.5px solid transparent; border-bottom: 9px solid #ffffff;"></div>
                                    </div>
                                    <!-- Perfect Round Seal Circle -->
                                    <div style="position: relative; z-index: 5; width: 108px; height: 78px; padding-top: 30px; border-radius: 54px; background-color: #fffbeb; border: 3px double {{ $certificate->text_color ?: '#0f172a' }}; margin: 0 auto; text-align: center; box-sizing: content-box;">
                                        @if($useGradeScore)
                                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 9px; font-weight: bold; letter-spacing: 1px; color: #475569; text-transform: uppercase;">SCORE: {{ floatval($result->score) }}</div>
                                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: {{ strlen($grammarLevel) > 10 ? '14px' : '19px' }}; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }}; margin-top: 3px; line-height: 1.1;">{{ $grammarLevel }}</div>
                                        @else
                                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 9px; font-weight: bold; letter-spacing: 1px; color: #475569; text-transform: uppercase;">{{ $scoreLabel }}</div>
                                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 30px; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }}; margin-top: 2px; line-height: 1;">{{ $result->test_type === 'toefl_itp' ? number_format($certificateToeflScore, 0, '.', '') : floatval($result->score) }}</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div style="height: 100px;"></div>
                            @endif
                        </td>
                        
                        <!-- Signature -->
                        <td style="width: 37%; text-align: center; vertical-align: bottom; padding-bottom: 2px;">
                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #64748b; margin-bottom: 12px;">{{ $footerRight }}</div>
                            <div style="position: relative; width: 220px; height: {{ $hasSigOrStamp ? '110px' : '20px' }}; margin: 0 auto;">
                                @if($stampBase64)
                                    <img src="{{ $stampBase64 }}" style="position: absolute; left: 5px; bottom: -6px; height: 110px; max-width: 140px; z-index: 1;">
                                @endif
                                @if($signatureBase64)
                                    <img src="{{ $signatureBase64 }}" style="position: absolute; left: 10px; bottom: 0px; max-height: 105px; max-width: 220px; z-index: 2;">
                                @endif
                            </div>
                            <div style="width: 220px; height: 1px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.3; margin: 0 auto 10px;"></div>
                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 15px; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $signatureName }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
