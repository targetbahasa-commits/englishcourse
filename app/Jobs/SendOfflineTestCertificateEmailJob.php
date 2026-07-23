<?php

namespace App\Jobs;

use App\Mail\OfflineTestCertificateMail;
use App\Models\OfflineTestResult;
use App\Models\OfflineTestCertificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOfflineTestCertificateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $offlineTestResultId,
    ) {
    }

    public function handle(): void
    {
        $result = OfflineTestResult::find($this->offlineTestResultId);

        if (!$result || !$result->email) {
            return;
        }

        $certificate = OfflineTestCertificate::where('test_type', $result->test_type)
            ->where('is_active', true)
            ->first();

        if (!$certificate) {
            return;
        }

        try {
            $pdfContent = Pdf::loadView('admin.offline-tests.certificates.pdf', [
                'result' => $result,
                'certificate' => $certificate,
                'testName' => str($result->test_type)->replace('_', ' ')->title(),
                'date' => optional($result->created_at)->format('d F Y') ?? now()->format('d F Y'),
            ])->setPaper('a4', 'landscape')->output();

            Mail::to($result->email)->send(new OfflineTestCertificateMail($result, $pdfContent));

            $result->update([
                'certificate_sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send offline test certificate: ' . $e->getMessage(), [
                'result_id' => $result->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
