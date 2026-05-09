<?php

namespace App\Domain\Notification\Contracts;

interface WhatsAppGateway
{
    public function sendOtp(string $phoneNumber, string $otpCode): bool;

    public function sendMessage(string $phoneNumber, string $message, ?string $file = null): bool;
}
