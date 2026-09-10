<?php

namespace App\Jobs;

use App\Mail\FinalTestCertificateMail;
use App\Models\FinalTestResult;
use App\Models\FreeTestCertificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendFinalTestCertificateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $finalTestResultId,
    ) {
    }

    public function handle(): void
    {
        $result = FinalTestResult::find($this->finalTestResultId);

        if (!$result || !$result->email) {
            return;
        }

        $certificate = FreeTestCertificate::where('test_type', $result->test_type)
            ->where('is_active', true)
            ->first();

        if (!$certificate) {
            $result->update([
                'evaluation_data' => array_merge($result->evaluation_data ?? [], [
                    'certificate_email_status' => 'skipped',
                ]),
            ]);
            return;
        }

        try {
            $pdfContent = Pdf::loadView('free-tests.certificate-pdf', [
                'user' => $result->user ?: (object) ['name' => $result->name ?: 'Student'],
                'result' => $result,
                'certificate' => $certificate,
                'testName' => $result->test_label ?: str($result->test_type)->replace('_', ' ')->title(),
                'date' => optional($result->completed_at ?? $result->created_at)->format('d F Y') ?? now()->format('d F Y'),
            ])->setPaper('a4', 'landscape')->output();

            Mail::to($result->email)->send(new FinalTestCertificateMail($result, $pdfContent));

            $result->update([
                'evaluation_data' => array_merge($result->evaluation_data ?? [], [
                    'certificate_email_status' => 'sent',
                    'certificate_emailed_at' => now()->toIso8601String(),
                ]),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Failed to send final test certificate email in queued job.', [
                'result_id' => $result->id,
                'message' => $exception->getMessage(),
            ]);

            $result->update([
                'evaluation_data' => array_merge($result->evaluation_data ?? [], [
                    'certificate_email_status' => 'failed',
                    'certificate_email_error' => $exception->getMessage(),
                ]),
            ]);
        }
    }
}
