<?php

namespace App\Infrastructure\Notification\WhatsApp;

use App\Domain\Notification\Contracts\WhatsAppGateway;
use Illuminate\Support\Facades\Log;

class WablasGateway implements WhatsAppGateway
{
    protected string $token;
    protected string $domain;

    public function __construct()
    {
        $this->token = config('services.whatsapp.wablas.token');
        $this->domain = config('services.whatsapp.wablas.domain');
    }

    public function sendOtp(string $phoneNumber, string $otpCode): bool
    {
        Log::error('Wablas gateway is configured as a placeholder - not actually implemented. OTP not sent to ' . $phoneNumber);
        return env('APP_ENV') === 'local';
    }

    public function sendMessage(string $phoneNumber, string $message, ?string $file = null): bool
    {
        Log::error('Wablas gateway is configured as a placeholder - not actually implemented. Message not sent to ' . $phoneNumber);
        return env('APP_ENV') === 'local';
    }
}
