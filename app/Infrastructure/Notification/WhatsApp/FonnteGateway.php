<?php

namespace App\Infrastructure\Notification\WhatsApp;

use App\Domain\Notification\Contracts\WhatsAppGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteGateway implements WhatsAppGateway
{
    protected string $token;

    public function __construct()
    {
        $this->token = (string) config('services.whatsapp.fonnte.token');
    }

    public function sendOtp(string $phoneNumber, string $otpCode): bool
    {
        if (empty($this->token)) {
            // production's LOG_LEVEL=error filters out warning() entirely,
            // which silently hid missing-config failures for a long time -
            // error() is the level that actually gets written.
            Log::error('Fonnte token is missing. OTP not sent to '.$phoneNumber);
            return env('APP_ENV') === 'local';
        }

        $message = "Your Target Bahasa Registration OTP is: *{$otpCode}*. \n\nThis code will expire in 5 minutes. Do not share this code with anyone.";

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $phoneNumber,
                'message' => $message,
                'delay' => '1',
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('Fonnte OTP Error', ['response' => $response->json()]);
            return false;
        } catch (\Exception $e) {
            Log::error('Fonnte Exception: '.$e->getMessage());
            return false;
        }
    }

    public function sendMessage(string $phoneNumber, string $message, ?string $file = null): bool
    {
        if (empty($this->token)) {
            Log::error('Fonnte token is missing. Message not sent to '.$phoneNumber);
            return env('APP_ENV') === 'local';
        }

        try {
            $payload = [
                'target' => $phoneNumber,
                'message' => $message,
                'delay' => '1',
                'countryCode' => '62',
            ];

            if ($file) {
                // If the file is an absolute path and exists locally, convert it to base64
                if (file_exists($file)) {
                    $mime = mime_content_type($file);
                    $base64 = base64_encode(file_get_contents($file));
                    $payload['file'] = "data:{$mime};base64,{$base64}";
                } else {
                    $payload['file'] = $file; // Assume it's a URL
                }
            }

            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', $payload);

            if ($response->successful()) {
                return true;
            }

            Log::error('Fonnte Message Error', ['status' => $response->status(), 'response' => $response->json()]);
            return false;
        } catch (\Exception $e) {
            Log::error('Fonnte Exception: '.$e->getMessage());
            return false;
        }
    }
}
