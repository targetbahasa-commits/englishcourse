<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\AdminLead\GetLeadsList;
use App\Application\AdminLead\GetLeadsStats;
use App\Application\AdminLead\UpdateLeadStatus;

class AdminLeadController extends Controller
{
    public function __construct(
        private readonly GetLeadsList $getLeadsList,
        private readonly GetLeadsStats $getLeadsStats,
        private readonly UpdateLeadStatus $updateLeadStatus
    ) {
    }

    public function index(Request $request)
    {
        $filters = [
            'status' => $request->filled('status') ? $request->status : null,
            'search' => $request->filled('search') ? $request->search : null,
            'test_category' => $request->filled('test_category') ? $request->test_category : null,
            'cefr_level' => $request->filled('cefr_level') ? $request->cefr_level : null,
            'eval_status' => $request->filled('eval_status') ? $request->eval_status : null,
            'date_preset' => $request->filled('date_preset') ? $request->date_preset : null,
            'date_from' => $request->filled('date_from') ? $request->date_from : null,
            'date_to' => $request->filled('date_to') ? $request->date_to : null,
        ];

        $leads = $this->getLeadsList->execute($filters, 15);
        $stats = $this->getLeadsStats->execute($filters);

        return view('admin.leads.index', array_merge($filters, [
            'leads' => $leads,
            'totalLeads' => $stats['totalLeads'],
            'pendingLeads' => $stats['pendingLeads'],
            'contactedLeads' => $stats['contactedLeads'],
            'enrolledLeads' => $stats['enrolledLeads'],
        ]));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,enrolled'
        ]);

        $this->updateLeadStatus->execute((int) $id, $request->status);

        return back()->with('success', 'Lead status updated successfully.');
    }

    public function reevaluate($id)
    {
        $submission = \App\Models\FreeTestSubmission::findOrFail($id);

        try {
            $res = $this->evaluateSubmission($submission);
            $scoreText = isset($res['band_score']) ? " (Est. Band Score: {$res['band_score']})" : '';
            $emailText = !empty($res['email_sent']) ? " Hasil telah otomatis dikirimkan ke email {$submission->email}!" : '';
            return back()->with('success', "Jawaban lead {$submission->name} berhasil dikirim ulang dan dinilai oleh AI{$scoreText}!{$emailText}");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Re-evaluation Error for Lead #{$id}: " . $e->getMessage());

            $submission->update([
                'evaluation_status' => 'failed',
                'updated_at' => now(),
            ]);

            return back()->with('error', 'Gagal mengevaluasi AI: ' . $e->getMessage());
        }
    }

    public function reevaluateAllFailed()
    {
        $pendingSubmissions = \App\Models\FreeTestSubmission::where(function ($q) {
            $q->whereNull('estimated_band_score')
              ->orWhere('evaluation_status', 'failed');
        })
        ->where(function ($q) {
            $q->whereNotNull('answer_text')->where('answer_text', '!=', '')
              ->orWhereNotNull('audio_paths');
        })
        ->get();

        if ($pendingSubmissions->isEmpty()) {
            return back()->with('info', 'Tidak ada submission tersimpan yang membutuhkan evaluasi ulang AI.');
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($pendingSubmissions as $submission) {
            try {
                $this->evaluateSubmission($submission);
                $successCount++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Batch Re-evaluate Error for Lead #{$submission->id}: " . $e->getMessage());
                $submission->update(['evaluation_status' => 'failed']);
                $failCount++;
            }
        }

        return back()->with('success', "Proses evaluasi ulang AI selesai. Berhasil: {$successCount}, Gagal: {$failCount}.");
    }

    /**
     * Evaluates a single FreeTestSubmission using AI providers.
     */
    private function evaluateSubmission(\App\Models\FreeTestSubmission $submission): array
    {
        $type = strtolower($submission->test_type ?? '');
        $answerText = trim($submission->answer_text ?? '');
        $audioPaths = json_decode($submission->audio_paths, true) ?? [];

        if (empty($answerText) && empty($audioPaths)) {
            throw new \Exception("Teks jawaban atau file suara tidak ditemukan untuk submission ID #{$submission->id}.");
        }

        $promoController = app(\App\Http\Controllers\PromoTestController::class);
        $aiFeedback = [];
        $bandScore = null;

        if (str_contains($type, 'writing') || str_contains($type, 'essay')) {
            $isTask1 = str_contains($type, 't1') || str_contains($type, 'task1');
            if ($isTask1) {
                $aiFeedback = $promoController->evaluateWritingTask1(null, $answerText);
            } else {
                $aiFeedback = $promoController->evaluateWritingTask2(null, $answerText);
            }
            $bandScore = $aiFeedback['overall_band_score'] ?? null;
        } elseif (str_contains($type, 'speaking')) {
            $questions = [];
            foreach ($audioPaths as $r) {
                $questions[] = $r['question'] ?? 'Speaking question';
            }
            $aiFeedback = $promoController->evaluateSpeaking(null, [], $questions);
            $bandScore = $aiFeedback['overall_band_score'] ?? null;
            $aiFeedback['recordings'] = $audioPaths;
        } else {
            throw new \Exception("Tipe tes '{$type}' tidak didukung untuk evaluasi otomatis AI.");
        }

        if (empty($aiFeedback) || !is_array($aiFeedback)) {
            throw new \Exception('Evaluasi AI mengembalikan respon kosong.');
        }

        $submission->update([
            'estimated_band_score' => is_numeric($bandScore) ? $bandScore : null,
            'ai_raw_json_feedback' => $aiFeedback,
            'evaluation_status' => 'success',
            'updated_at' => now(),
        ]);

        $emailSent = false;
        if (!empty($submission->email) && filter_var($submission->email, FILTER_VALIDATE_EMAIL)) {
            try {
                \Illuminate\Support\Facades\Mail::to($submission->email)->send(new \App\Mail\FreeTestReevaluatedMail($submission));
                $emailSent = true;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Failed to send reevaluation email to {$submission->email}: " . $e->getMessage());
            }
        }

        return [
            'success' => true,
            'band_score' => $bandScore,
            'feedback' => $aiFeedback,
            'email_sent' => $emailSent,
        ];
    }
}
