<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Domain\Notification\Contracts\WhatsAppGateway;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{
    public function send(Request $request, WhatsAppGateway $whatsapp)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'min:9', 'max:20', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
        ]);

        $phoneNumber = $request->phone_number;

        // Generate a 6-digit OTP
        $otpCode = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

        // Save logic - Upsert or create new for this phone number
        $otpRecord = Otp::updateOrCreate(
            ['phone_number' => $phoneNumber],
            [
                'otp_code' => $otpCode,
                'expires_at' => now()->addMinutes(5),
                'is_verified' => false,
            ]
        );

        // Send OTP via Gateway
        $sent = $whatsapp->sendOtp($phoneNumber, $otpCode);

        if ($sent) {
            return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to send OTP. Please try again or check your number.'], 500);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'max:20'],
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $otpRecord = Otp::where('phone_number', $request->phone_number)
            ->where('otp_code', $request->otp_code)
            ->first();

        if (!$otpRecord) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP code.'], 400);
        }

        if (now()->greaterThan($otpRecord->expires_at)) {
            return response()->json(['success' => false, 'message' => 'OTP code has expired. Please request a new one.'], 400);
        }

        // Verify successfully
        $otpRecord->update(['is_verified' => true]);

        return response()->json(['success' => true, 'message' => 'Phone number verified successfully.']);
    }
}
