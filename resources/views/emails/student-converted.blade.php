<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Target Bahasa</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9fafb; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #1e3a8a; margin: 0; }
        .content { margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #2563eb; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        .box { background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin: 20px 0; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Target Bahasa!</h1>
        </div>
        
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            
            <p>Your registration is confirmed! We are thrilled to welcome you as a student at Target Bahasa.</p>
            
            @if($payment)
                <p>We have successfully received your payment for the <strong>{{ $payment->program->name ?? 'Course' }}</strong> program. Your invoice is attached to this email.</p>
            @endif

            <p>You can now log in to the Student Dashboard to access your materials, check your schedule, and update your profile.</p>

            <div class="box">
                <strong>Login URL:</strong> {{ url('/login') }}<br>
                <strong>Email:</strong> {{ $user->email }}<br>
                @if($tempPassword)
                    <strong>Password:</strong> {{ $tempPassword }}
                @else
                    <strong>Password:</strong> <em>(The password you created during registration)</em>
                @endif
            </div>

            @if($tempPassword)
                <p><em>Note: Please change your temporary password immediately after logging in for the first time.</em></p>
            @endif

            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="btn">Go to Dashboard</a>
            </div>
        </div>

        <div class="footer">
            <p>If you have any questions, feel free to reply to this email or contact us via WhatsApp.</p>
            <p>&copy; {{ date('Y') }} Target Bahasa. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
