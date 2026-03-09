<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Log;

class WablasGateway implements WhatsAppGatewayInterface
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
        Log::info('Wablas Gateway is configured as a placeholder. Add implementation in App\Services\WhatsApp\WablasGateway.php');
        return true;
    }
}
