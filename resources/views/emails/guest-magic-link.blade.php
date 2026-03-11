<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; color: #1f2937; line-height: 1.6; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #2563eb; }
        .button { display: inline-block; padding: 12px 24px; background-color: #2563eb; color: white !important; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 20px 0; }
        .footer { margin-top: 40px; font-size: 12px; color: #6b7280; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Target Bahasa</div>
        </div>
        <h2>Guest Access Request</h2>
        <p>Hello,</p>
        <p>We received a request to log into your guest account. You can sign in immediately by clicking the button below:</p>
        
        <div style="text-align: center;">
            <a href="{{ $url }}" class="button">Log In to My Dashboard</a>
        </div>
        
        <p>If the button doesn't work, you can copy and paste this direct link into your browser:</p>
        <p style="word-break: break-all; font-size: 14px; background: #f3f4f6; padding: 10px; border-radius: 6px;"><a href="{{ $url }}" style="color: #2563eb; text-decoration: none;">{{ $url }}</a></p>
        
        <p><em>Note: This link is valid for 15 minutes.</em></p>
        
        <p>If you didn't request this link, you can safely ignore this email.</p>
        
        <div class="footer">
            &copy; {{ date('Y') }} Target Bahasa. All rights reserved.
        </div>
    </div>
</body>
</html>
