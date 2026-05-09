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
        Log::info('Wablas gateway is configured as a placeholder. Implement in app/Infrastructure/Notification/WhatsApp/WablasGateway.php');
        return true;
    }

    public function sendMessage(string $phoneNumber, string $message, ?string $file = null): bool
    {
        Log::info('Wablas gateway sendMessage is a placeholder. Add implementation.');
        return env('APP_ENV') === 'local';
    }
}
