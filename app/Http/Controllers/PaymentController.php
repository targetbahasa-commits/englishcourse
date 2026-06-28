<?php

namespace App\Http\Controllers;

use App\Application\Payment\AdminPaymentQuery;
use App\Application\Payment\ApprovePayment;
use App\Application\Payment\BuildStudentPaymentIndexData;
use App\Application\Payment\InitiatePayment;
use App\Application\Payment\RejectPayment;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;
use App\Mail\PaymentProofUploadedMail;

class PaymentController extends Controller
{
    public function __construct(
        private readonly AdminPaymentQuery $adminPaymentQuery,
        private readonly BuildStudentPaymentIndexData $buildStudentPaymentIndexData,
        private readonly InitiatePayment $initiatePayment,
        private readonly ApprovePayment $approvePayment,
        private readonly RejectPayment $rejectPayment,
    ) {}

    public function studentIndex(Request $request): View
    {
        $viewData = $this->buildStudentPaymentIndexData->handle(
            $request->user(),
            (int) $request->session()->get('registration_prefill_program_id', 0),
            (string) $request->session()->get('registration_prefill_payment_channel', 'bank_transfer')
        );
        $viewData['prefillClassType'] = $request->session()->get('registration_prefill_class_type', 'regular');

        return view('payments.student.index', $viewData);
    }

    public function initiate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'payment_channel' => ['required', 'in:bank_transfer,cash'],
            'class_type' => ['nullable', 'string', 'in:regular,semi_private,private'],
        ]);

        $result = $this->initiatePayment->handle(
            $request->user(),
            $validated['program_id'],
            $validated['payment_channel'],
            $validated['class_type'] ?? 'regular'
        );

        if ($result['status'] === 'already_enrolled') {
            return back()->with('error', 'Kamu sudah terdaftar di program ini.');
        }

        if ($result['status'] === 'pending_exists') {
            return redirect()->route('student.payments.show', $result['payment'])
                ->with('success', 'Pembayaran pending sebelumnya ditemukan. Silakan lanjutkan.');
        }

        $discountMessage = $result['discountAmount'] > 0
            ? ' Diskon ' . $result['discountLabel'] . ' diterapkan: Rp' . number_format($result['discountAmount'], 0, ',', '.') . '.'
            : '';

        return redirect()->route('student.payments.show', $result['payment'])
            ->with('success', 'Invoice berhasil dibuat. Total tagihan: Rp' . number_format($result['netAmount'], 0, ',', '.') . '.' . $discountMessage);
    }

    public function studentShow(Request $request, Payment $payment): View
    {
        $this->assertPaymentOwner($payment, $request->user()->id);

        $payment->load('program');

        return view('payments.student.show', [
            'payment' => $payment,
        ]);
    }

    public function uploadProof(Request $request, Payment $payment): RedirectResponse
    {
        $this->assertPaymentOwner($payment, $request->user()->id);

        $validated = $request->validate([
            'proof_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if (!in_array($payment->status, ['pending', 'waiting_verification'])) {
            return back()->with('error', 'Pembayaran ini sudah diproses dan tidak bisa diubah.');
        }

        if ($payment->payment_channel !== 'bank_transfer') {
            return back()->with('error', 'Upload bukti hanya untuk pembayaran transfer bank.');
        }

        $path = $validated['proof_file']->store('payment-proofs/' . $payment->user_id, 'public');

        $notes = trim((string) ($validated['notes'] ?? ''));

        $payment->update([
            'proof_file' => $path,
            'status' => 'waiting_verification',
            'notes' => $notes !== '' ? $notes : $payment->notes,
        ]);

        try {
            $notificationEmails = setting('notification_emails');
            if (!empty($notificationEmails)) {
                $emails = array_filter(array_map('trim', explode(',', $notificationEmails)));
                if (count($emails) > 0) {
                    Mail::to($emails)->send(new PaymentProofUploadedMail($payment));
                }
            }
            
            $notificationWhatsapps = setting('notification_whatsapps');
            if (!empty($notificationWhatsapps)) {
                $whatsapps = array_filter(array_map('trim', explode(',', $notificationWhatsapps)));
                if (count($whatsapps) > 0) {
                    $waMessage = "Bukti transfer baru diunggah oleh " . ($payment->user->name ?? 'Student') . " untuk Invoice {$payment->invoice_number}. Silakan cek dashboard admin.";
                    $waGateway = app(\App\Domain\Notification\Contracts\WhatsAppGateway::class);
                    foreach ($whatsapps as $waNumber) {
                        $waGateway->sendMessage($waNumber, $waMessage);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to send payment proof notifications: ' . $e->getMessage());
        }

        return back()->with('success', 'Bukti transfer berhasil diunggah. Menunggu verifikasi admin.');
    }

    public function adminIndex(Request $request): View
    {
        $filters = $this->adminPaymentQuery->getFilters($request);
        $netAmountExpr = 'CASE WHEN (amount - discount_amount) < 0 THEN 0 ELSE (amount - discount_amount) END';
        $activeClassPeriods = \App\Models\ClassPeriod::whereIn('status', ['active', 'upcoming'])->get();

        $summaryStats = $this->adminPaymentQuery->build($filters, false)
            ->selectRaw('COUNT(*) as total_invoices')
            ->selectRaw('COALESCE(SUM(' . $netAmountExpr . '), 0) as total_net_amount')
            ->selectRaw('COALESCE(SUM(COALESCE(paid_amount, 0)), 0) as total_paid_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN paid_amount IS NOT NULL THEN (paid_amount - ' . $netAmountExpr . ') ELSE 0 END), 0) as total_variance_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN paid_amount IS NOT NULL AND paid_amount < ' . $netAmountExpr . ' THEN 1 ELSE 0 END), 0) as underpaid_count')
            ->first();

        $recentPaidPayments = Payment::query()
            ->with(['user', 'program'])
            ->where('status', 'paid')
            ->orderByDesc('paid_at')
            ->paginate(10, ['*'], 'paid_page')
            ->withQueryString();

        $trendStats = $this->adminPaymentQuery->buildTrendStats($filters, $filters['trend_period']);
        $trendThreshold = (float) ($filters['trend_threshold'] ?? 10);
        $peakUnderpaidPercentage = !empty($trendStats)
            ? max(array_map(static fn (array $trend): float => (float) $trend['underpaid_percentage'], $trendStats))
            : 0.0;
        $trendSeverity = 'normal';
        if ($peakUnderpaidPercentage > ($trendThreshold * 1.5)) {
            $trendSeverity = 'critical';
        } elseif ($peakUnderpaidPercentage > $trendThreshold) {
            $trendSeverity = 'warning';
        }
        $trendAlert = [
            'threshold' => $trendThreshold,
            'peak_underpaid_percentage' => $peakUnderpaidPercentage,
            'is_triggered' => $peakUnderpaidPercentage > $trendThreshold,
            'severity' => $trendSeverity,
        ];

        $totalInvoices = (int) ($summaryStats->total_invoices ?? 0);
        $underpaidCount = (int) ($summaryStats->underpaid_count ?? 0);
        $totalNetAmount = (int) ($summaryStats->total_net_amount ?? 0);
        $totalPaidAmount = (int) ($summaryStats->total_paid_amount ?? 0);
        $underpaidPercentage = $totalInvoices > 0
            ? round(($underpaidCount / $totalInvoices) * 100, 2)
            : 0.0;
        $paidCoveragePercentage = $totalNetAmount > 0
            ? round(($totalPaidAmount / $totalNetAmount) * 100, 2)
            : 0.0;

        return view('payments.admin.index', [
            'recentPaidPayments' => $recentPaidPayments,
            'filters' => $filters,
            'summaryStats' => [
                'total_invoices' => $totalInvoices,
                'total_net_amount' => $totalNetAmount,
                'total_paid_amount' => $totalPaidAmount,
                'total_variance_amount' => (int) ($summaryStats->total_variance_amount ?? 0),
                'underpaid_count' => $underpaidCount,
                'underpaid_percentage' => $underpaidPercentage,
                'paid_coverage_percentage' => $paidCoveragePercentage,
            ],
            'trendStats' => $trendStats,
            'trendAlert' => $trendAlert,
            'activeClassPeriods' => $activeClassPeriods,
        ]);
    }

    public function adminQueue(Request $request): View
    {
        $filters = $this->adminPaymentQuery->getFilters($request);
        $activeClassPeriods = \App\Models\ClassPeriod::whereIn('status', ['active', 'upcoming'])->get();

        $paymentQueue = $this->adminPaymentQuery->build($filters)
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        // Build a map of registration leads keyed by "user_id_program_id"
        $queueUserIds = $paymentQueue->pluck('user_id')->unique()->filter();
        $leadMap = \App\Models\RegistrationLead::whereIn('converted_user_id', $queueUserIds)
            ->whereNotNull('converted_user_id')
            ->get()
            ->keyBy(fn($l) => $l->converted_user_id . '_' . $l->program_id);

        // Count payments with uploaded proof pending admin review
        $proofPendingCount = \App\Models\Payment::whereIn('status', ['pending', 'waiting_verification'])
            ->where(function ($q) {
                $q->whereNotNull('proof_file')
                  ->orWhereNotNull('meta->transfer_proof_path');
            })
            ->count();

        $oldProofCount = \App\Models\Payment::whereNotNull('proof_file')
            ->where('created_at', '<', now()->subDays(30))
            ->count();

        return view('payments.admin.queue', [
            'paymentQueue' => $paymentQueue,
            'filters' => $filters,
            'leadMap' => $leadMap,
            'proofPendingCount' => $proofPendingCount,
            'oldProofCount' => $oldProofCount,
            'activeClassPeriods' => $activeClassPeriods,
        ]);
    }

    public function adminExportCsv(Request $request): StreamedResponse
    {
        $filters = $this->adminPaymentQuery->getFilters($request);

        $fileName = 'payments-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($filters) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Invoice',
                'Status',
                'Student Name',
                'Student Email',
                'Program',
                'Payment Channel',
                'Amount',
                'Discount Amount',
                'Net Amount',
                'Paid Amount',
                'Variance Amount',
                'Settlement',
                'Override Used',
                'Override Reason',
                'Created At',
                'Paid At',
                'Notes',
            ]);

            $this->adminPaymentQuery->build($filters)
                ->orderByDesc('created_at')
                ->chunkById(300, function ($payments) use ($handle) {
                    foreach ($payments as $payment) {
                        $netAmount = max(0, (int) $payment->amount - (int) $payment->discount_amount);
                        $paidAmount = $payment->paid_amount !== null ? (int) $payment->paid_amount : null;
                        $overrideUsed = (bool) ($payment->meta['override_underpayment'] ?? false);
                        $varianceAmount = $paidAmount !== null ? ($paidAmount - $netAmount) : null;

                        $settlement = '';
                        if ($paidAmount !== null) {
                            if ($paidAmount < $netAmount) {
                                $settlement = 'underpaid';
                            } elseif ($paidAmount > $netAmount) {
                                $settlement = 'overpaid';
                            } else {
                                $settlement = 'exact';
                            }
                        }

                        fputcsv($handle, [
                            $payment->invoice_number,
                            $payment->status,
                            $payment->user->name ?? '',
                            $payment->user->email ?? '',
                            $payment->program->name ?? '',
                            $payment->payment_channel,
                            (int) $payment->amount,
                            (int) $payment->discount_amount,
                            $netAmount,
                            $paidAmount,
                            $varianceAmount,
                            $settlement,
                            $overrideUsed ? 'yes' : 'no',
                            (string) ($payment->meta['override_underpayment_reason'] ?? ''),
                            optional($payment->created_at)->toDateTimeString(),
                            optional($payment->paid_at)->toDateTimeString(),
                            (string) ($payment->notes ?? ''),
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function adminExportTrendCsv(Request $request): StreamedResponse
    {
        $filters = $this->adminPaymentQuery->getFilters($request);
        $trendStats = $this->adminPaymentQuery->buildTrendStats($filters, $filters['trend_period']);
        $fileName = 'payments-trend-' . $filters['trend_period'] . '-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($trendStats) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Date Label',
                'Invoices',
                'Paid Coverage Percentage',
                'Underpaid Percentage',
            ]);

            foreach ($trendStats as $trend) {
                fputcsv($handle, [
                    $trend['date_label'],
                    (int) $trend['invoices'],
                    (float) $trend['paid_coverage_percentage'],
                    (float) $trend['underpaid_percentage'],
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function approve(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'paid_amount' => ['nullable', 'integer', 'min:0'],
            'override_underpayment' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:500'],
            'receiver_name' => ['nullable', 'string', 'max:100'],
            'class_period_id' => ['required', 'exists:class_periods,id'],
        ]);

        $result = $this->approvePayment->handle($request->user(), $payment, $validated);

        if ($result['status'] === 'already_paid') {
            return back()->with('success', 'Pembayaran ini sudah berstatus paid.');
        }

        if ($result['status'] === 'validation_error') {
            return back()->withErrors($result['errors'])->withInput();
        }

        return back()->with('success', 'Pembayaran disetujui dan enrollment diaktifkan.');
    }

    public function reject(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:500'],
        ]);

        $result = $this->rejectPayment->handle($payment, $request->user()->id, $validated['notes']);

        if ($result['status'] === 'already_paid') {
            return back()->with('error', 'Pembayaran yang sudah paid tidak bisa ditolak.');
        }

        return back()->with('success', 'Pembayaran ditandai gagal. Student bisa membuat invoice baru.');
    }

    private function assertPaymentOwner(Payment $payment, int $userId): void
    {
        abort_if($payment->user_id !== $userId, 403, 'Unauthorized access.');
    }

    public function proofsIndex(Request $request): View
    {
        $query = Payment::with(['user', 'program'])
            ->whereNotNull('proof_file')
            ->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(20);

        return view('payments.admin.proofs', [
            'payments' => $payments,
        ]);
    }
}
