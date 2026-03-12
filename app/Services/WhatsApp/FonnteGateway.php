<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteGateway implements WhatsAppGatewayInterface
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.whatsapp.fonnte.token');
    }

    public function sendOtp(string $phoneNumber, string $otpCode): bool
    {
        if (empty($this->token)) {
            Log::warning('Fonnte token is missing. OTP not sent to ' . $phoneNumber);
            // In a real scenario, this might return false.
            // Returning true here locally so the flow can be tested even without a token.
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
            Log::error('Fonnte Exception: ' . $e->getMessage());
            return false;
        }
    }

    public function sendMessage(string $phoneNumber, string $message): bool
    {
        if (empty($this->token)) {
            Log::warning('Fonnte token is missing. Message not sent to ' . $phoneNumber);
            return env('APP_ENV') === 'local'; 
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $phoneNumber,
                'message' => $message,
                'delay' => '1',
                'countryCode' => '62',
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Fonnte Exception: ' . $e->getMessage());
            return false;
        }
    }
}
