<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; padding: 0px; font-family: 'Helvetica', 'Arial', sans-serif; }
        .certificate-container {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .background-image {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .content {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            padding: 50px;
            text-align: center;
            color: {{ $certificate->text_color ?? '#0f172a' }};
        }
        h1.eyebrow {
            font-size: 24px;
            margin-top: 100px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        h2.title {
            font-size: 32px;
            font-weight: normal;
            margin-top: 20px;
        }
        .name {
            font-size: 48px;
            font-weight: bold;
            margin: 40px 0;
            font-style: italic;
        }
        .subtitle {
            font-size: 20px;
            margin-bottom: 30px;
        }
        .test-name {
            font-size: 36px;
            font-weight: bold;
            color: #d97706; /* target bahasa orange */
            margin-bottom: 20px;
        }
        .score-container {
            margin: 30px auto;
            width: 200px;
            border: 2px solid {{ $certificate->text_color ?? '#0f172a' }};
            border-radius: 10px;
            padding: 20px;
        }
        .score-label {
            font-size: 16px;
            text-transform: uppercase;
        }
        .score-value {
            font-size: 42px;
            font-weight: bold;
            margin-top: 10px;
        }
        .body-text {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.5;
        }
        .footer {
            position: absolute;
            bottom: 100px;
            left: 100px;
            right: 100px;
            display: table;
            width: calc(100% - 200px);
        }
        .footer-left {
            display: table-cell;
            text-align: left;
            width: 50%;
        }
        .footer-right {
            display: table-cell;
            text-align: right;
            width: 50%;
        }
        .signature-line {
            border-top: 1px solid {{ $certificate->text_color ?? '#0f172a' }};
            width: 250px;
            margin-top: 60px;
            padding-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        @if($certificate->background_image)
            <img src="{{ public_path('storage/' . $certificate->background_image) }}" class="background-image" />
        @endif
        
        @php
            $config = $certificate->template_config ?? [];
        @endphp
        
        <div class="content">
            <h1 class="eyebrow">{{ $config['eyebrow'] ?? 'CERTIFICATE OF ACHIEVEMENT' }}</h1>
            <h2 class="title">{{ $config['title'] ?? 'This is to certify that' }}</h2>
            
            <div class="name">{{ $result->name }}</div>
            
            <div class="subtitle">{{ $config['subtitle'] ?? 'has achieved the following score on the' }}</div>
            <div class="test-name">{{ $testName }}</div>
            
            <div class="score-container">
                <div class="score-label">{{ $config['score_label'] ?? 'Total Score' }}</div>
                <div class="score-value">{{ floatval($result->score) }}</div>
            </div>
            
            <div class="body-text">
                {{ $config['body'] ?? 'This certificate is proudly presented for outstanding performance in the offline test.' }}
            </div>
            
            <div class="footer">
                <div class="footer-left">
                    <div class="signature-line" style="text-align: center;">
                        {{ $date }}<br>
                        <span style="font-weight: normal; font-size: 14px;">{{ $config['footer_left_label'] ?? 'Date' }}</span>
                    </div>
                </div>
                <div class="footer-right">
                    <div class="signature-line" style="float: right; text-align: center;">
                        {{ $config['signature_name'] ?? 'Director' }}<br>
                        <span style="font-weight: normal; font-size: 14px;">{{ $config['footer_right_label'] ?? 'Signature' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
