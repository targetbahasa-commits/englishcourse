<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Free Test - {{ $testName ?? 'Free Test' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @php
        $templateConfig = $certificate->template_config ?? [];
        $hasScoreTable = in_array($result->test_type ?? ($certificate->test_type ?? ''), ['toefl_itp', 'ielts_academic', 'ielts_general']);

        $hasResult = isset($result) && $result;
        $testTypeVal = $certificate->test_type ?? ($result->test_type ?? '');
        $useGradeScore = in_array($testTypeVal, [
            'introductory_grammar_for_writing', 'complexity_grammar_for_writing',
            'proficiency_grammar_for_writing', 'fast_track_grammar_for_writing',
            'introductory_speaking', 'intermediate_speaking', 'advanced_speaking',
        ]) || in_array($result->test_type ?? '', [
            'introductory_grammar_for_writing', 'complexity_grammar_for_writing',
            'proficiency_grammar_for_writing', 'fast_track_grammar_for_writing',
            'introductory_speaking', 'intermediate_speaking', 'advanced_speaking',
        ]);

        $grade = 'Distinction';
        if ($hasResult && $useGradeScore) {
            $scoreInt = (int) $result->score;
            if ($scoreInt >= 90) $grade = 'Distinction';
            elseif ($scoreInt >= 80) $grade = 'High Merit';
            elseif ($scoreInt >= 70) $grade = 'Merit';
            elseif ($scoreInt >= 60) $grade = 'Pass with Credit';
            elseif ($scoreInt >= 50) $grade = 'Pass';
            else $grade = 'Fail';
        }

        $schemes = [
            'Distinction' => [
                'frame' => 'gold-frame.png',
                'ribbon' => '#1a202c',
                'frame_solid' => '#c59b27',
                'stops' => [
                    ['pos' => 0, 'r' => 197, 'g' => 155, 'b' => 39],
                    ['pos' => 0.18, 'r' => 245, 'g' => 224, 'b' => 138],
                    ['pos' => 0.35, 'r' => 184, 'g' => 134, 'b' => 11],
                    ['pos' => 0.52, 'r' => 254, 'g' => 248, 'b' => 198],
                    ['pos' => 0.7, 'r' => 212, 'g' => 175, 'b' => 55],
                    ['pos' => 0.85, 'r' => 247, 'g' => 230, 'b' => 150],
                    ['pos' => 1, 'r' => 160, 'g' => 112, 'b' => 24],
                ],
                'raw_stops' => [
                    [0.00, 197, 155, 39], [0.18, 245, 224, 138], [0.35, 184, 134, 11], [0.52, 254, 248, 198],
                    [0.70, 212, 175, 55], [0.85, 247, 230, 150], [1.00, 160, 112, 24],
                ],
            ],
            'High Merit' => [
                'frame' => 'silver-frame.png',
                'ribbon' => '#475569',
                'frame_solid' => '#757f9a',
                'stops' => [
                    ['pos' => 0, 'r' => 117, 'g' => 127, 'b' => 154],
                    ['pos' => 0.25, 'r' => 215, 'g' => 221, 'b' => 232],
                    ['pos' => 0.5, 'r' => 225, 'g' => 228, 'b' => 235],
                    ['pos' => 0.75, 'r' => 180, 'g' => 186, 'b' => 199],
                    ['pos' => 1, 'r' => 137, 'g' => 146, 'b' => 166],
                ],
                'raw_stops' => [
                    [0.00, 117, 127, 154], [0.25, 215, 221, 232], [0.50, 225, 228, 235],
                    [0.75, 180, 186, 199], [1.00, 137, 146, 166],
                ],
            ],
            'Merit' => [
                'frame' => 'bronze-frame.png',
                'ribbon' => '#78350f',
                'frame_solid' => '#8a5a2b',
                'stops' => [
                    ['pos' => 0, 'r' => 138, 'g' => 90, 'b' => 43],
                    ['pos' => 0.25, 'r' => 227, 'g' => 168, 'b' => 105],
                    ['pos' => 0.5, 'r' => 185, 'g' => 110, 'b' => 50],
                    ['pos' => 0.75, 'r' => 240, 'g' => 190, 'b' => 130],
                    ['pos' => 1, 'r' => 205, 'g' => 127, 'b' => 50],
                ],
                'raw_stops' => [
                    [0.00, 138, 90, 43], [0.25, 227, 168, 105], [0.50, 185, 110, 50],
                    [0.75, 240, 190, 130], [1.00, 205, 127, 50],
                ],
            ],
            'Pass with Credit' => [
                'frame' => 'sapphire-frame.png',
                'ribbon' => '#0f172a',
                'frame_solid' => '#0f2027',
                'stops' => [
                    ['pos' => 0, 'r' => 15, 'g' => 32, 'b' => 39],
                    ['pos' => 0.25, 'r' => 40, 'g' => 80, 'b' => 95],
                    ['pos' => 0.5, 'r' => 60, 'g' => 120, 'b' => 140],
                    ['pos' => 0.75, 'r' => 32, 'g' => 58, 'b' => 67],
                    ['pos' => 1, 'r' => 44, 'g' => 83, 'b' => 100],
                ],
                'raw_stops' => [
                    [0.00, 15, 32, 39], [0.25, 40, 80, 95], [0.50, 60, 120, 140],
                    [0.75, 32, 58, 67], [1.00, 44, 83, 100],
                ],
            ],
            'Pass' => [
                'frame' => 'emerald-frame.png',
                'ribbon' => '#064e3b',
                'frame_solid' => '#11998e',
                'stops' => [
                    ['pos' => 0, 'r' => 17, 'g' => 153, 'b' => 142],
                    ['pos' => 0.3, 'r' => 40, 'g' => 180, 'b' => 150],
                    ['pos' => 0.5, 'r' => 65, 'g' => 210, 'b' => 170],
                    ['pos' => 0.7, 'r' => 40, 'g' => 180, 'b' => 150],
                    ['pos' => 1, 'r' => 56, 'g' => 239, 'b' => 125],
                ],
                'raw_stops' => [
                    [0.00, 17, 153, 142], [0.30, 40, 180, 150], [0.50, 65, 210, 170],
                    [0.70, 40, 180, 150], [1.00, 56, 239, 125],
                ],
            ],
            'Fail' => [
                'frame' => 'slate-frame.png',
                'ribbon' => '#1e293b',
                'frame_solid' => '#333333',
                'stops' => [
                    ['pos' => 0, 'r' => 51, 'g' => 51, 'b' => 51],
                    ['pos' => 0.3, 'r' => 70, 'g' => 70, 'b' => 70],
                    ['pos' => 0.5, 'r' => 90, 'g' => 90, 'b' => 90],
                    ['pos' => 0.7, 'r' => 70, 'g' => 70, 'b' => 70],
                    ['pos' => 1, 'r' => 85, 'g' => 85, 'b' => 85],
                ],
                'raw_stops' => [
                    [0.00, 51, 51, 51], [0.30, 70, 70, 70], [0.50, 90, 90, 90],
                    [0.70, 70, 70, 70], [1.00, 85, 85, 85],
                ],
            ],
        ];

        $currentScheme = $schemes[$grade] ?? $schemes['Distinction'];
        $frameSolidColor = $currentScheme['frame_solid'] ?? '#c59b27';
    @endphp

    <style>
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
            top: 8mm;
            left: 8mm;
            width: 281mm;
            height: 194mm;
            border: 3.5px solid {{ $frameSolidColor }};
            z-index: 1;
        }

        .cert-border-inner {
            position: absolute;
            top: 11.5mm;
            left: 11.5mm;
            width: 274mm;
            height: 187mm;
            border: 1.2px solid {{ $frameSolidColor }};
            z-index: 2;
        }

        .cert-content {
            position: absolute;
            top: {{ $hasScoreTable ? '14mm' : '19mm' }};
            left: 13mm;
            width: 271mm;
            text-align: center;
            z-index: 10;
        }

        /* Ornate corners */
        .cert-corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border-color: {{ $frameSolidColor }};
            border-style: solid;
            z-index: 3;
        }
        .cert-corner-tl { top: 13mm; left: 13mm; border-width: 2.5px 0 0 2.5px; }
        .cert-corner-tr { top: 13mm; right: 13mm; border-width: 2.5px 2.5px 0 0; }
        .cert-corner-bl { bottom: 13mm; left: 13mm; border-width: 0 0 2.5px 2.5px; }
        .cert-corner-br { bottom: 13mm; right: 13mm; border-width: 0 2.5px 2.5px 0; }

        .cert-header {
            margin-top: {{ $hasScoreTable ? '0px' : '6px' }};
            text-align: center;
        }

        .cert-logo {
            height: {{ $hasScoreTable ? '58px' : '72px' }};
            width: auto;
        }

        .cert-eyebrow {
            font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
            font-size: {{ $hasScoreTable ? '11px' : '12px' }};
            font-weight: bold;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            margin-top: {{ $hasScoreTable ? '6px' : '14px' }};
        }

        .cert-title {
            font-family: 'Cinzel', Georgia, 'Times New Roman', serif;
            font-size: {{ $hasScoreTable ? '34px' : '38px' }};
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: {{ $hasScoreTable ? '4px' : '8px' }};
            line-height: 1.15;
        }

        .cert-subtitle {
            font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
            font-size: {{ $hasScoreTable ? '14.5px' : '16px' }};
            color: #475569;
            margin-top: {{ $hasScoreTable ? '3px' : '6px' }};
            font-style: italic;
        }

        .cert-presented-to {
            font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
            font-size: {{ $hasScoreTable ? '13.5px' : '15px' }};
            color: #64748b;
            margin-top: {{ $hasScoreTable ? '12px' : '28px' }};
            font-style: italic;
        }

        .cert-recipient-name {
            font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
            font-size: {{ $hasScoreTable ? '30px' : '38px' }};
            font-weight: bold;
            color: #0f172a;
            margin-top: {{ $hasScoreTable ? '4px' : '8px' }};
            display: inline-block;
        }

        .cert-recipient-line {
            width: {{ $hasScoreTable ? '320px' : '380px' }};
            height: 1.5px;
            background-color: {{ $certificate->text_color ?: '#0f172a' }};
            opacity: 0.35;
            margin: {{ $hasScoreTable ? '4px auto 0' : '8px auto 0' }};
        }

        .cert-body-text {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: {{ $hasScoreTable ? '13.5px' : '14.5px' }};
            line-height: 1.55;
            color: #334155;
            max-width: 680px;
            margin: {{ $hasScoreTable ? '6px auto 0' : '18px auto 0' }};
        }
    </style>
</head>
<body>
    @php
        $eyebrow = $templateConfig['eyebrow'] ?? 'Certificate of Achievement';
        $title = $templateConfig['title'] ?? 'Certificate of Completion';
        $subtitle = $templateConfig['subtitle'] ?? 'Free Test Practice Result';
        $scoreLabel = $templateConfig['score_label'] ?? 'Final Score';
        $bodyText = $templateConfig['body'] ?? 'This certificate is awarded to the candidate for successfully completing the free test.';
        $footerLeft = $templateConfig['footer_left_label'] ?? 'Date';
        $footerRight = $templateConfig['footer_right_label'] ?? 'Authorized Signature';
        $signatureName = $templateConfig['signature_name'] ?? 'Target Bahasa';
        $signatureTitle = $templateConfig['signature_title'] ?? (($signatureName === 'Nendra Wirawan' || empty($templateConfig['signature_title'])) ? 'Founder & Developer' : $templateConfig['signature_title']);

        // Prepare Base64 Signature Image for DomPDF
        $signatureBase64 = null;
        if (!empty($templateConfig['signature_image'])) {
            $sigCandidates = [
                storage_path('app/public/' . $templateConfig['signature_image']),
                public_path('storage/' . $templateConfig['signature_image']),
                base_path('storage/app/public/' . $templateConfig['signature_image']),
            ];
            foreach ($sigCandidates as $cand) {
                if (file_exists($cand)) {
                    $ext = strtolower(pathinfo($cand, PATHINFO_EXTENSION));
                    $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : (($ext === 'webp') ? 'image/webp' : 'image/png');
                    $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($cand));
                    break;
                }
            }
        }

        // Prepare Base64 Stamp Image for DomPDF
        $stampBase64 = null;
        if (!empty($templateConfig['stamp_image'])) {
            $stCandidates = [
                storage_path('app/public/' . $templateConfig['stamp_image']),
                public_path('storage/' . $templateConfig['stamp_image']),
                base_path('storage/app/public/' . $templateConfig['stamp_image']),
            ];
            foreach ($stCandidates as $cand) {
                if (file_exists($cand)) {
                    $ext = strtolower(pathinfo($cand, PATHINFO_EXTENSION));
                    $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : (($ext === 'webp') ? 'image/webp' : 'image/png');
                    $stampBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($cand));
                    break;
                }
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

        $rawBgOpacity = array_key_exists('background_opacity', $templateConfig) && is_numeric($templateConfig['background_opacity']) ? (float)$templateConfig['background_opacity'] : 18;
        $bgOpacity = $rawBgOpacity > 1 ? ($rawBgOpacity / 100) : $rawBgOpacity;

        // Prepare Base64 Metallic Frame Image
        $goldFrameBase64 = null;
        $frameCandidates = [
            public_path('images/certificates/frames/' . $currentScheme['frame']),
            base_path('public/images/certificates/frames/' . $currentScheme['frame']),
            base_path('public_html/images/certificates/frames/' . $currentScheme['frame']),
            base_path('images/certificates/frames/' . $currentScheme['frame']),
            (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/images/certificates/frames/' . $currentScheme['frame'] : null),
            (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/public/images/certificates/frames/' . $currentScheme['frame'] : null),
        ];

        foreach ($frameCandidates as $cand) {
            if ($cand && file_exists($cand)) {
                $goldFrameBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($cand));
                break;
            }
        }

        // Guaranteed GD generation if frame image file is missing
        if (!$goldFrameBase64 && function_exists('imagecreatetruecolor')) {
            $w = 1170; $h = 827;
            $im = imagecreatetruecolor($w, $h);
            imagesavealpha($im, true);
            $trans = imagecolorallocatealpha($im, 0, 0, 0, 127);
            imagefill($im, 0, 0, $trans);

            $outX1 = 31; $outY1 = 31; $outX2 = $w - 31; $outY2 = $h - 31; $outThick = 5;
            $inX1 = 45;  $inY1 = 45;  $inX2 = $w - 45;  $inY2 = $h - 45;  $inThick = 2;

            $rawStops = $currentScheme['raw_stops'];
            $colors = [];
            for ($t = 0; $t <= 500; $t++) {
                $tf = $t / 500;
                $rgb = [$rawStops[0][1], $rawStops[0][2], $rawStops[0][3]];
                for ($i = 0; $i < count($rawStops) - 1; $i++) {
                    if ($tf >= $rawStops[$i][0] && $tf <= $rawStops[$i+1][0]) {
                        $range = $rawStops[$i+1][0] - $rawStops[$i][0];
                        $localT = ($tf - $rawStops[$i][0]) / $range;
                        $rgb = [
                            (int)($rawStops[$i][1] + $localT * ($rawStops[$i+1][1] - $rawStops[$i][1])),
                            (int)($rawStops[$i][2] + $localT * ($rawStops[$i+1][2] - $rawStops[$i][2])),
                            (int)($rawStops[$i][3] + $localT * ($rawStops[$i+1][3] - $rawStops[$i][3])),
                        ];
                        break;
                    }
                }
                $colors[$t] = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
            }

            $getColor = function($x, $y) use ($colors, $w, $h) {
                $t = ($x / $w) * 0.6 + ($y / $h) * 0.4;
                $t = max(0, min(500, (int)($t * 500)));
                return $colors[$t];
            };

            for ($th = 0; $th < $outThick; $th++) {
                for ($x = $outX1; $x <= $outX2; $x++) { imagesetpixel($im, $x, $outY1 + $th, $getColor($x, $outY1)); imagesetpixel($im, $x, $outY2 - $th, $getColor($x, $outY2)); }
                for ($y = $outY1; $y <= $outY2; $y++) { imagesetpixel($im, $outX1 + $th, $y, $getColor($outX1, $y)); imagesetpixel($im, $outX2 - $th, $y, $getColor($outX2, $y)); }
            }
            for ($th = 0; $th < $inThick; $th++) {
                for ($x = $inX1; $x <= $inX2; $x++) { imagesetpixel($im, $x, $inY1 + $th, $getColor($x, $inY1)); imagesetpixel($im, $x, $inY2 - $th, $getColor($x, $inY2)); }
                for ($y = $outY1; $y <= $outY2; $y++) { imagesetpixel($im, $inX1 + $th, $y, $getColor($inX1, $y)); imagesetpixel($im, $inX2 - $th, $y, $getColor($inX2, $y)); }
            }

            $cSize = 24; $cThick = 3;
            $tlX = $outX1 - 5; $tlY = $outY1 - 5; $trX = $outX2 + 5; $trY = $outY1 - 5;
            $blX = $outX1 - 5; $blY = $outY2 + 5; $brX = $outX2 + 5; $brY = $outY2 + 5;

            for ($th = 0; $th < $cThick; $th++) {
                for ($i = 0; $i < $cSize; $i++) { imagesetpixel($im, $tlX + $i, $tlY + $th, $getColor($tlX+$i, $tlY)); imagesetpixel($im, $tlX + $th, $tlY + $i, $getColor($tlX, $tlY+$i)); }
                for ($i = 0; $i < $cSize; $i++) { imagesetpixel($im, $trX - $i, $trY + $th, $getColor($trX-$i, $trY)); imagesetpixel($im, $trX - $th, $trY + $i, $getColor($trX, $trY+$i)); }
                for ($i = 0; $i < $cSize; $i++) { imagesetpixel($im, $blX + $i, $blY - $th, $getColor($blX+$i, $blY)); imagesetpixel($im, $blX + $th, $blY - $i, $getColor($blX, $blY-$i)); }
                for ($i = 0; $i < $cSize; $i++) { imagesetpixel($im, $brX - $i, $brY - $th, $getColor($brX-$i, $brY)); imagesetpixel($im, $brX - $th, $brY - $i, $getColor($brX, $brY-$i)); }
            }

            ob_start();
            imagepng($im);
            $goldFrameBase64 = 'data:image/png;base64,' . base64_encode(ob_get_clean());
            imagedestroy($im);
        }
    @endphp

    <div class="cert-page">
        @if($backgroundBase64)
            <img src="{{ $backgroundBase64 }}" class="cert-bg-image" style="opacity: {{ $bgOpacity }};" alt="Background image">
        @endif

        @if($goldFrameBase64)
            <img src="{{ $goldFrameBase64 }}" style="position: absolute; top: 0; left: 0; width: 297mm; height: 210mm; z-index: 2; pointer-events: none;" alt="Frame">
        @else
            <div class="cert-border-outer"></div>
            <div class="cert-border-inner"></div>

            <div class="cert-corner cert-corner-tl"></div>
            <div class="cert-corner cert-corner-tr"></div>
            <div class="cert-corner cert-corner-bl"></div>
            <div class="cert-corner cert-corner-br"></div>
        @endif

        <div class="cert-content">
            <!-- Logo and Institution -->
            <div class="cert-header" style="margin-top: {{ $hasScoreTable ? '0px' : '6px' }};">
                <img src="{{ base_path('public/images/brand/target-bahasa-logo1.png') }}" class="cert-logo" alt="Target Bahasa Logo">
            </div>

            <!-- Header Labels -->
            @if(!empty($eyebrow))
                <div class="cert-eyebrow" style="color: {{ $certificate->text_color ?: '#0f172a' }}; margin-top: {{ $hasScoreTable ? '6px' : '14px' }};">{{ $eyebrow }}</div>
            @endif
            @if(!empty($title))
                <div class="cert-title" style="color: {{ $certificate->text_color ?: '#0f172a' }}; margin-top: {{ $hasScoreTable ? '4px' : '8px' }};">{{ $title }}</div>
            @endif
            @if(!empty($subtitle))
                <div class="cert-subtitle" style="margin-top: {{ $hasScoreTable ? '3px' : '6px' }};">{{ $subtitle }}</div>
            @endif

            <!-- Presentation Section -->
            <div class="cert-presented-to" style="margin-top: {{ $hasScoreTable ? '10px' : '28px' }};">This certificate is proudly presented to</div>
            <div class="cert-recipient-name" style="margin-top: {{ $hasScoreTable ? '4px' : '8px' }};">{{ $user->name }}</div>
            <div class="cert-recipient-line"></div>
            @if(!empty($bodyText))
                <div class="cert-body-text" style="margin-top: {{ $hasScoreTable ? '6px' : '18px' }};">{{ $bodyText }}</div>
            @endif

            @php
                $evaluationData = $result->evaluation_data ?? [];
                $listeningScore = $evaluationData['listening_score'] ?? null;
                $structureScore = $evaluationData['structure_score'] ?? null;
                $readingScore = $evaluationData['reading_score'] ?? null;
                $certificateToeflScore = $evaluationData['toefl_score'] ?? $result->score;

                $grammarLevel = $grade;

                // Prepare Base64 Seal Image with Ribbons for DomPDF
                $sealBase64 = null;
                if (!in_array($certificate->test_type, ['toefl_itp', 'ielts_academic', 'ielts_general'])) {
                    $mainColor = $certificate->text_color ?: '#0f172a';
                    if ($useGradeScore) {
                        $sealTopLabel = 'SCORE: ' . floatval($result->score) . '/100';
                        $sealMainText = $grammarLevel;
                    } else {
                        $sealTopLabel = $scoreLabel;
                        $sealMainText = (string)($result->test_type === 'toefl_itp' ? number_format($certificateToeflScore, 0, '.', '') : floatval($result->score));
                    }

                    if (strlen($sealMainText) > 13) {
                        $sealFontSize = 14;
                        $sealYOffset = 83;
                    } elseif (strlen($sealMainText) > 9) {
                        $sealFontSize = 18;
                        $sealYOffset = 84;
                    } elseif (strlen($sealMainText) > 5) {
                        $sealFontSize = 20;
                        $sealYOffset = 85;
                    } elseif (is_numeric($sealMainText)) {
                        $sealFontSize = 38;
                        $sealYOffset = 89;
                    } else {
                        $sealFontSize = 26;
                        $sealYOffset = 87;
                    }

                    $sealTopFontSize = $useGradeScore ? 13 : 11;
                    $sealTopY = $useGradeScore ? 52 : 52;

                    // Generate Metallic Gradient Badge Base via PHP GD
                    $scale = 2;
                    $bw = 150 * $scale;
                    $bh = 162 * $scale;
                    $cx = 75 * $scale;
                    $cy = 68 * $scale;
                    $rOuter = 64 * $scale;
                    $rGoldRing = 60 * $scale;
                    $rInnerCream = 53 * $scale;
                    $rInnerGoldBorder = 50 * $scale;

                    $im = imagecreatetruecolor($bw, $bh);
                    imagesavealpha($im, true);
                    $transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
                    imagefill($im, 0, 0, $transparent);

                    // Ribbons (Dynamic Color)
                    $hex = ltrim($currentScheme['ribbon'], '#');
                    if (strlen($hex) == 3) {
                        $rr = hexdec($hex[0].$hex[0]);
                        $gg = hexdec($hex[1].$hex[1]);
                        $bb = hexdec($hex[2].$hex[2]);
                    } elseif (strlen($hex) == 6) {
                        $rr = hexdec(substr($hex, 0, 2));
                        $gg = hexdec(substr($hex, 2, 2));
                        $bb = hexdec(substr($hex, 4, 2));
                    } else {
                        $rr = 15; $gg = 23; $bb = 42;
                    }
                    $ribbonColor = imagecolorallocate($im, $rr, $gg, $bb);

                    $leftPts = [
                        26 * $scale, 80 * $scale,
                        66 * $scale, 80 * $scale,
                        50 * $scale, 155 * $scale,
                        36 * $scale, 138 * $scale,
                        18 * $scale, 158 * $scale
                    ];
                    imagefilledpolygon($im, $leftPts, 5, $ribbonColor);

                    $rightPts = [
                        84 * $scale, 80 * $scale,
                        124 * $scale, 80 * $scale,
                        132 * $scale, 158 * $scale,
                        114 * $scale, 138 * $scale,
                        100 * $scale, 155 * $scale
                    ];
                    imagefilledpolygon($im, $rightPts, 5, $ribbonColor);

                    // Dynamic gradient stops matching certificate frame
                    $stops = $currentScheme['stops'];

                    $minX = $cx - $rOuter;
                    $maxX = $cx + $rOuter;
                    $minY = $cy - $rOuter;
                    $maxY = $cy + $rOuter;
                    $diagSpan = ($maxX - $minX) + ($maxY - $minY);

                    for ($gy = (int)$minY; $gy <= (int)$maxY; $gy++) {
                        for ($gx = (int)$minX; $gx <= (int)$maxX; $gx++) {
                            $dx = $gx - $cx;
                            $dy = $gy - $cy;
                            $dist = sqrt($dx * $dx + $dy * $dy);

                            if ($dist <= $rOuter) {
                                $t = (($gx - $minX) + ($gy - $minY)) / $diagSpan;
                                $t = max(0.0, min(1.0, $t));
                                $rgb = [$stops[0]['r'], $stops[0]['g'], $stops[0]['b']];
                                for ($si = 0; $si < count($stops) - 1; $si++) {
                                    if ($t >= $stops[$si]['pos'] && $t <= $stops[$si + 1]['pos']) {
                                        $span = $stops[$si + 1]['pos'] - $stops[$si]['pos'];
                                        $localT = ($t - $stops[$si]['pos']) / $span;
                                        $rgb = [
                                            (int)($stops[$si]['r'] + ($stops[$si + 1]['r'] - $stops[$si]['r']) * $localT),
                                            (int)($stops[$si]['g'] + ($stops[$si + 1]['g'] - $stops[$si]['g']) * $localT),
                                            (int)($stops[$si]['b'] + ($stops[$si + 1]['b'] - $stops[$si]['b']) * $localT),
                                        ];
                                        break;
                                    }
                                }

                                if ($dist > $rGoldRing) {
                                    $alpha = (int)(40 + 70 * (($dist - $rGoldRing) / ($rOuter - $rGoldRing)));
                                    $c = imagecolorallocatealpha($im, $rgb[0], $rgb[1], $rgb[2], min(120, $alpha));
                                    imagesetpixel($im, $gx, $gy, $c);
                                } elseif ($dist > $rInnerCream) {
                                    $c = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
                                    imagesetpixel($im, $gx, $gy, $c);
                                } elseif ($dist > $rInnerGoldBorder) {
                                    $creamColor = imagecolorallocate($im, 255, 255, 255);
                                    imagesetpixel($im, $gx, $gy, $creamColor);
                                } elseif ($dist > ($rInnerGoldBorder - 1.5 * $scale)) {
                                    $c = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
                                    imagesetpixel($im, $gx, $gy, $c);
                                } else {
                                    $creamColor = imagecolorallocate($im, 255, 255, 255);
                                    imagesetpixel($im, $gx, $gy, $creamColor);
                                }
                            }
                        }
                    }

                    ob_start();
                    imagepng($im);
                    $badgeData = ob_get_clean();
                    imagedestroy($im);

                    $badgeBase64 = 'data:image/png;base64,' . base64_encode($badgeData);

                    $sealSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="150" height="162" viewBox="0 0 150 162">'
                      . '<image href="' . $badgeBase64 . '" x="0" y="0" width="150" height="162" />'
                      . '<!-- Text inside seal -->'
                      . '<text x="75" y="' . $sealTopY . '" font-family="Helvetica, Arial, sans-serif" font-size="' . $sealTopFontSize . '" font-weight="bold" letter-spacing="1.2" text-anchor="middle" fill="#334155">' . htmlspecialchars($sealTopLabel) . '</text>'
                      . '<text x="75" y="' . $sealYOffset . '" font-family="Helvetica, Arial, sans-serif" font-size="' . $sealFontSize . '" font-weight="bold" text-anchor="middle" fill="' . $mainColor . '">' . htmlspecialchars($sealMainText) . '</text>'
                      . '</svg>';

                    $sealBase64 = 'data:image/svg+xml;base64,' . base64_encode($sealSvg);
                }
            @endphp

            @if($result->test_type === 'toefl_itp')
                <table style="width: 380px; margin: 4px auto 0; border: 1px solid rgba(15,23,42,0.12); border-collapse: collapse; background: #ffffff;">
                    <tr>
                        <td style="padding: 2px 12px; font-size: 10px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Listening Comprehension:</td>
                        <td style="padding: 2px 12px; font-size: 10px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $listeningScore ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 12px; font-size: 10px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Structure &amp; Written Expression:</td>
                        <td style="padding: 2px 12px; font-size: 10px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $structureScore ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 12px; font-size: 10px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Reading Comprehension:</td>
                        <td style="padding: 2px 12px; font-size: 10px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $readingScore ?? '-' }}</td>
                    </tr>
                    <tr style="background: rgba(248,250,252,0.9);">
                        <td style="padding: 2px 12px; font-size: 10.5px; font-weight: bold; color: #0f172a; text-align: left;">Total Score:</td>
                        <td style="padding: 2px 12px; font-size: 11.5px; font-weight: 800; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ number_format($certificateToeflScore ?? $result->score, 0, '.', '') }}</td>
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
                <table style="width: 380px; margin: 4px auto 0; border: 1px solid rgba(15,23,42,0.12); border-collapse: collapse; background: #ffffff;">
                    <tr>
                        <td style="padding: 2px 12px; font-size: 10px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Listening:</td>
                        <td style="padding: 2px 12px; font-size: 10px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $ieltsL ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 12px; font-size: 10px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Reading:</td>
                        <td style="padding: 2px 12px; font-size: 10px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $ieltsR ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 12px; font-size: 10px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Writing:</td>
                        <td style="padding: 2px 12px; font-size: 10px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $ieltsW ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 12px; font-size: 10px; color: #334155; border-bottom: 1px solid rgba(15,23,42,0.06); text-align: left;">Speaking:</td>
                        <td style="padding: 2px 12px; font-size: 10px; font-weight: bold; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }}; border-bottom: 1px solid rgba(15,23,42,0.06);">{{ $ieltsS ?? '-' }}</td>
                    </tr>
                    <tr style="background: rgba(248,250,252,0.9);">
                        <td style="padding: 2px 12px; font-size: 10.5px; font-weight: bold; color: #0f172a; text-align: left;">Overall Band Score:</td>
                        <td style="padding: 2px 12px; font-size: 11.5px; font-weight: 800; text-align: right; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $scoreValue }}</td>
                    </tr>
                </table>
            @endif

            <!-- Bottom Layout (Date, Gold Seal, Signature) -->
            <table style="width: 100%; border-collapse: collapse; margin-top: {{ $hasScoreTable ? '10px' : '42px' }}; vertical-align: bottom;">
                <tr>
                    <!-- Date -->
                    <td style="width: 37%; text-align: center; vertical-align: bottom; padding-bottom: 2px;">
                        <div style="position: relative; width: 220px; height: {{ $hasSigOrStamp ? '115px' : '25px' }}; margin: 0 auto;">
                            @if($stampBase64)
                                <img src="{{ $stampBase64 }}" style="position: absolute; left: 48px; bottom: -8px; height: 120px; max-width: 155px; z-index: 1;">
                            @endif
                        </div>
                        <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 10.5px; font-weight: bold; text-transform: uppercase; color: #64748b; margin-top: 4px; margin-bottom: 8px; visibility: {{ empty($footerLeft) ? 'hidden' : 'visible' }};"><span style="letter-spacing: 2px; margin-right: -2px;">{!! $footerLeft ?: '&nbsp;' !!}</span></div>
                        <div style="width: 210px; height: 1px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.3; margin: 0 auto 10px;"></div>
                        <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 14px; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $date ?? (isset($result->created_at) ? $result->created_at->format('d F Y') : date('d F Y')) }}</div>
                        @if(!empty($signatureTitle))
                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 10.5px; font-weight: 500; color: transparent; margin-top: 3px;">&nbsp;</div>
                        @endif
                    </td>
                    
                    <!-- Seal -->
                    <td style="width: 26%; text-align: center; vertical-align: bottom;">
                        @if($sealBase64)
                            <div style="position: relative; width: 150px; height: 162px; margin: 0 auto; top: 12px;">
                                <img src="{{ $sealBase64 }}" width="150" height="162" alt="Certificate Seal" style="display: block; margin: 0 auto;">
                            </div>
                        @else
                            <div style="height: 90px;"></div>
                        @endif
                    </td>
                    
                    <!-- Signature -->
                    <td style="width: 37%; text-align: center; vertical-align: bottom; padding-bottom: 2px;">
                        <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 10.5px; font-weight: bold; text-transform: uppercase; color: #64748b; margin-bottom: 8px; visibility: {{ empty($footerRight) ? 'hidden' : 'visible' }};"><span style="letter-spacing: 2px; margin-right: -2px;">{!! $footerRight ?: '&nbsp;' !!}</span></div>
                        <div style="position: relative; width: 220px; height: {{ $hasSigOrStamp ? '115px' : '25px' }}; margin: 0 auto;">
                            @if($signatureBase64)
                                <img src="{{ $signatureBase64 }}" style="position: absolute; left: -15px; bottom: -8px; height: 125px; width: 250px; z-index: 2;">
                            @endif
                        </div>
                        <div style="width: 210px; height: 1px; background-color: {{ $certificate->text_color ?: '#0f172a' }}; opacity: 0.3; margin: 0 auto 10px;"></div>
                        @if(!empty($signatureName))
                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 14px; font-weight: bold; color: {{ $certificate->text_color ?: '#0f172a' }};">{{ $signatureName }}</div>
                        @endif
                        @if(!empty($signatureTitle))
                            <div style="font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif; font-size: 10.5px; font-weight: 500; color: #64748b; margin-top: 3px;">{{ $signatureTitle }}</div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        @if(!empty($result->certificate_number))
            <div style="position: absolute; top: 14mm; left: 16mm; text-align: left; z-index: 20; max-width: 250px;">
                <span style="background-color: rgba(255,255,255,0.85); padding: 1px 6px; border-radius: 3px; font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 7.5px; color: #64748b;">Certificate No.: {{ $result->certificate_number }} &nbsp;&middot;&nbsp; Verification: {{ route('certificates.verify', $result->certificate_number) }}</span>
            </div>
        @endif
    </div>
</body>
</html>