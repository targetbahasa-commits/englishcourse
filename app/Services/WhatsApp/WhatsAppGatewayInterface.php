<?php

namespace App\Services\WhatsApp;

interface WhatsAppGatewayInterface
{
    /**
     * Send an OTP via WhatsApp.
     *
     * @param string $phoneNumber
     * @param string $otpCode
     * @return bool True if successfully sent, false otherwise.
     */
    public function sendOtp(string $phoneNumber, string $otpCode): bool;

    /**
     * Send a general text message via WhatsApp.
     *
     * @param string $phoneNumber
     * @param string $message
     * @return bool True if successfully sent, false otherwise.
     */
    public function sendMessage(string $phoneNumber, string $message): bool;
}
