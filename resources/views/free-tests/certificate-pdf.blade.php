<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Free Test - {{ $testName }}</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: {{ $certificate->text_color }};
        }
        
        /* Background Image Setup */
        @if($certificate->background_image)
        .certificate-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ storage_path('app/public/' . $certificate->background_image) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
        }
        @else
        /* Fallback background if no image is uploaded */
        .certificate-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #f8fafc;
            border: 20px solid #e2e8f0;
            box-sizing: border-box;
            z-index: -1;
        }
        @endif

        .content {
            text-align: center;
            padding-top: 15%; /* Adjust vertically depending on background */
            position: relative;
            z-index: 10;
        }

        h1 {
            font-size: 50px;
            margin-bottom: 10px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.8;
        }

        .presented-to {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .student-name {
            font-size: 45px;
            font-weight: bold;
            margin-bottom: 30px;
            text-transform: uppercase;
            border-bottom: 2px solid {{ $certificate->text_color }};
            display: inline-block;
            padding-bottom: 5px;
            min-width: 400px;
        }

        .course-details {
            font-size: 22px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .score {
            font-size: 26px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 40px;
            padding: 10px 20px;
            border: 2px dashed {{ $certificate->text_color }};
            display: inline-block;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
        }

        .date-section {
            float: left;
            margin-left: 20%;
            text-align: center;
        }
        
        .signature-section {
            float: right;
            margin-right: 20%;
            text-align: center;
        }

        .line {
            border-top: 1px solid {{ $certificate->text_color }};
            width: 200px;
            margin-top: 50px;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
    <div class="certificate-container"></div>
    
    <div class="content">
        <h1>CERTIFICATE</h1>
        <div class="subtitle">OF COMPLETION</div>
        
        <div class="presented-to">This is to certify that</div>
        
        <div class="student-name">{{ $user->name }}</div>
        
        <div class="course-details">
            has successfully completed the<br>
            <strong>{{ $testName }}</strong> Free Mock Test
        </div>

        @if($certificate->description)
            <div style="font-size: 16px; margin-top:-10px; margin-bottom:15px; font-style: italic;">
                "{{ $certificate->description }}"
            </div>
        @endif
        
        <div class="score">
            Score: {{ $result->score }}
        </div>
        
        <div class="footer">
            <div class="date-section">
                <div class="line"></div>
                <div>{{ $date }}</div>
                <div style="font-size:12px; margin-top:5px;">Date Completed</div>
            </div>
            
            <div class="signature-section">
                <div class="line"></div>
                <div>Target Bahasa Team</div>
                <div style="font-size:12px; margin-top:5px;">Authorized Signature</div>
            </div>
        </div>
    </div>
</body>
</html>
