<?php

namespace App\Listeners;

use App\Events\PromoTestCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppPromoFeedback implements ShouldQueue
{
    public function handle(PromoTestCompleted $event)
    {
        $waNumber = $event->whatsappNumber;
        $bandScore = $event->aiFeedback['overall_band_score'] ?? 'N/A';
        
        $message = "Halo! Terima kasih telah mengikuti Free Test Target Bahasa.\n\n"
                 . "Estimasi Band Score IELTS Anda: *{$bandScore}*.\n\n"
                 . "Admin kami akan segera menghubungi Anda untuk konsultasi lebih lanjut!";

        // Placeholder for Fonnte / Wablas API Call
        try {
            // Uncomment and configure your gateway when ready
            /*
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_API_KEY'), 
            ])->post('https://api.fonnte.com/send', [
                'target' => $waNumber,
                'message' => $message,
                'countryCode' => '62',
            ]);
            */

            Log::info("Simulated WA Message sent to {$waNumber}: {$message}");
        } catch (\Exception $e) {
            Log::error("Failed to send WA Message: " . $e->getMessage());
        }
    }
}
