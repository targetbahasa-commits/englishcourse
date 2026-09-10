<?php

namespace App\Infrastructure\Notification\WhatsApp;

use App\Domain\Notification\Contracts\WhatsAppGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WahaGateway implements WhatsAppGateway
{
    protected string $url;
    protected string $session;
    protected string $apiKey;

    public function __construct()
    {
        $urlSetting = \App\Models\Setting::where('key', 'waha_url')->first();
        $this->url = rtrim($urlSetting && !empty($urlSetting->value) ? $urlSetting->value : config('services.whatsapp.waha.url', 'http://localhost:3000'), '/');

        $sessionSetting = \App\Models\Setting::where('key', 'waha_session_name')->first();
        $this->session = $sessionSetting && !empty($sessionSetting->value) ? $sessionSetting->value : config('services.whatsapp.waha.session', 'default');

        $apiKeySetting = \App\Models\Setting::where('key', 'waha_api_key')->first();
        $this->apiKey = (string) ($apiKeySetting && !empty($apiKeySetting->value) ? $apiKeySetting->value : config('services.whatsapp.waha.api_key', ''));
    }

    /**
     * Send OTP message
     */
    public function sendOtp(string $phoneNumber, string $otpCode): bool
    {
        $message = "Your Target Bahasa Registration OTP is: *{$otpCode}*. \n\nThis code will expire in 5 minutes. Do not share this code with anyone.";
        return $this->sendMessage($phoneNumber, $message);
    }

    /**
     * Send standard WhatsApp message (with optional file)
     */
    public function sendMessage(string $phoneNumber, string $message, ?string $file = null): bool
    {
        if (empty($this->url)) {
            // production's LOG_LEVEL=error filters out warning() entirely,
            // which silently hid missing-config failures for a long time -
            // error() is the level that actually gets written.
            Log::error('WAHA URL is missing. Message not sent to ' . $phoneNumber);
            return env('APP_ENV') === 'local';
        }

        // Format phone number to WAHA format: 628123456789@c.us
        $chatId = $this->formatPhoneNumber($phoneNumber);

        try {
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            if (!empty($this->apiKey)) {
                $headers['X-Api-Key'] = $this->apiKey;
            }

            if ($file) {
                // Determine if it's a local file or remote URL
                $filePayload = [];
                if (filter_var($file, FILTER_VALIDATE_URL)) {
                    $filePayload = ['url' => $file];
                } elseif (file_exists($file)) {
                    $mime = mime_content_type($file);
                    $base64 = base64_encode(file_get_contents($file));
                    $filename = basename($file);
                    
                    $filePayload = [
                        'mimetype' => $mime,
                        'filename' => $filename,
                        'data' => $base64
                    ];
                } else {
                    Log::error("WahaGateway: File not found or invalid URL: {$file}");
                    return false;
                }

                $payload = [
                    'session' => $this->session,
                    'chatId'  => $chatId,
                    'file'    => $filePayload,
                    'caption' => $message,
                ];

                $response = Http::withHeaders($headers)
                    ->timeout(15)
                    ->post($this->url . '/api/sendFile', $payload);

            } else {
                // Send plain text
                $payload = [
                    'session' => $this->session,
                    'chatId'  => $chatId,
                    'text'    => $message,
                ];

                $response = Http::withHeaders($headers)
                    ->timeout(10)
                    ->post($this->url . '/api/sendText', $payload);
            }

            if ($response->successful()) {
                return true;
            }

            Log::error('WAHA API Error', ['status' => $response->status(), 'response' => $response->json()]);
            return false;

        } catch (\Exception $e) {
            Log::error('WAHA Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper to format phone number to WAHA chat ID format
     * WAHA requires number@c.us
     */
    protected function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-numeric characters
        $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // If it starts with 0, replace with 62 (assuming Indonesian default)
        // If your system handles international numbers, this might need refinement
        if (str_starts_with($cleanNumber, '0')) {
            $cleanNumber = '62' . substr($cleanNumber, 1);
        }
        
        return $cleanNumber . '@c.us';
    }
}
