<?php

namespace App\Http\Controllers\Admin;

use App\Application\Registration\ManageRegistrationLeads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegistrationLeadUpdateRequest;
use App\Http\Requests\Admin\RegistrationLeadUpdateStatusRequest;
use App\Models\ClassPeriod;
use App\Models\Program;
use App\Models\RegistrationLead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class RegistrationLeadController extends Controller
{
    public function __construct(
        private readonly ManageRegistrationLeads $manageRegistrationLeads
    ) {}

    private function resolveLeadWindowDays(Request $request): ?int
    {
        $allowed = [7, 14, 30, 90];
        $raw = $request->query('date_window');

        if ($raw === null || $raw === '') {
            return null;
        }

        $window = (int) $raw;

        return in_array($window, $allowed, true) ? $window : null;
    }

    public function index(Request $request)
    {
        [
            'leads' => $leads,
            'programs' => $programs,
            'classPeriods' => $classPeriods,
            'attributionInsights' => $attributionInsights,
            'quickAttributionFilters' => $quickAttributionFilters,
            'metrics' => $metrics,
        ] = $this->manageRegistrationLeads->index($request->query());

        $activeDateWindow = $this->resolveLeadWindowDays($request);

        return view('admin.registration-leads.index', compact('leads', 'programs', 'classPeriods', 'metrics', 'attributionInsights', 'quickAttributionFilters', 'activeDateWindow'));
    }

    public function export(Request $request)
    {
        $query = RegistrationLead::with(['program', 'classPeriod', 'convertedUser'])->latest('id');
        $this->applyIndexFilters($query, $request);

        $rows = $query->get();
        $filename = 'registration_leads_' . Carbon::now()->format('Ymd_His') . '.csv';

        $preset = (string) $request->query('export_preset', 'registration_leads_filtered');
        $this->logExportAction($preset, [
            'filters' => $request->query(),
            'rows' => $rows->count(),
        ]);

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'id',
                'created_at',
                'full_name',
                'whatsapp',
                'email',
                'city',
                'status',
                'mode',
                'program',
                'class_period',
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'utm_content',
                'utm_term',
                'acquisition_source_page',
                'acquisition_landing_path',
                'acquisition_referrer',
                'acquisition_variant',
                'acquisition_last_cta',
                'converted_user_id',
                'converted_at',
            ]);

            foreach ($rows as $lead) {
                fputcsv($handle, [
                    $lead->id,
                    optional($lead->created_at)->toDateTimeString(),
                    $lead->full_name,
                    $lead->whatsapp,
                    $lead->email,
                    $lead->city,
                    $lead->status,
                    $lead->mode,
                    $lead->program?->name,
                    $lead->classPeriod?->name,
                    $lead->utm_source,
                    $lead->utm_medium,
                    $lead->utm_campaign,
                    $lead->utm_content,
                    $lead->utm_term,
                    $lead->acquisition_source_page,
                    $lead->acquisition_landing_path,
                    $lead->acquisition_referrer,
                    $lead->acquisition_variant,
                    $lead->acquisition_last_cta,
                    $lead->converted_user_id,
                    optional($lead->converted_at)->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function show(RegistrationLead $registrationLead)
    {
        $programs = Program::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $classPeriods = ClassPeriod::with('program:id,name')
            ->whereIn('status', ['active', 'upcoming'])
            ->orderBy('start_date')
            ->get(['id', 'name', 'program_id', 'start_date', 'learning_mode']);

        $lead = $registrationLead->load(['program', 'classPeriod.program', 'convertedUser']);

        // Load related payment & enrollment when this lead has been converted
        $relatedPayment = null;
        $relatedEnrollment = null;
        if ($lead->converted_user_id && $lead->program_id) {
            $relatedPayment = \App\Models\Payment::where('user_id', $lead->converted_user_id)
                ->where('program_id', $lead->program_id)
                ->with('program')
                ->latest()
                ->first();
            $relatedEnrollment = \App\Models\Enrollment::where('user_id', $lead->converted_user_id)
                ->where('program_id', $lead->program_id)
                ->with('classPeriod')
                ->first();
        }

        return view('admin.registration-leads.show', [
            'lead'              => $lead,
            'programs'          => $programs,
            'classPeriods'      => $classPeriods,
            'relatedPayment'    => $relatedPayment,
            'relatedEnrollment' => $relatedEnrollment,
        ]);
    }

    public function update(RegistrationLeadUpdateRequest $request, RegistrationLead $registrationLead)
    {
        $validated = $request->validated();

        if (!empty($validated['class_period_id'])) {
            $selectedPeriod = ClassPeriod::find($validated['class_period_id']);

            if (!$selectedPeriod || !in_array($selectedPeriod->status, ['active', 'upcoming'], true)) {
                return back()->withErrors(['class_period_id' => 'Batch kelas tidak tersedia.'])->withInput();
            }

            if (!empty($validated['program_id']) && (int) $selectedPeriod->program_id !== (int) $validated['program_id']) {
                return back()->withErrors(['class_period_id' => 'Batch tidak sesuai dengan program yang dipilih.'])->withInput();
            }

            if ($validated['mode'] !== 'flexible' && $selectedPeriod->learning_mode !== $validated['mode']) {
                return back()->withErrors(['class_period_id' => 'Batch tidak sesuai dengan mode belajar yang dipilih.'])->withInput();
            }
        }

        $this->manageRegistrationLeads->update($registrationLead, $validated);

        return back()->with('success', 'Data lead berhasil diperbarui.');
    }

    public function updateStatus(RegistrationLeadUpdateStatusRequest $request, RegistrationLead $registrationLead)
    {
        $this->manageRegistrationLeads->updateStatus($registrationLead, $request->status, $request->admin_notes);

        return back()->with('success', 'Status lead berhasil diperbarui.');
    }

    public function destroy(RegistrationLead $registrationLead)
    {
        $this->manageRegistrationLeads->delete($registrationLead);
        return redirect()->route('admin.registration-leads.index')
                         ->with('success', 'Lead berhasil dihapus.');
    }

    public function convertToStudent(RegistrationLead $registrationLead)
    {
        if ($registrationLead->status === 'converted' || $registrationLead->converted_user_id) {
            return back()->with('error', 'Lead ini sudah pernah dikonversi.');
        }

        $email = trim((string) $registrationLead->email);
        if ($email !== '' && User::where('email', $email)->exists()) {
            return back()->with('error', 'Email sudah dipakai user lain. Silakan ubah email lead terlebih dahulu.');
        }
        
        ['user' => $user, 'email' => $email, 'tempPassword' => $tempPassword, 'payment' => $payment] = $this->manageRegistrationLeads->convertToStudent($registrationLead);

        // Generate PDF Invoice if payment exists
        $pdfPath = null;
        if ($payment) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('emails.invoice-pdf', ['payment' => $payment, 'user' => $user]);
            $pdfFileName = 'invoice-' . $payment->invoice_number . '.pdf';
            $pdfPath = storage_path('app/public/invoices/' . $pdfFileName);
            
            // Ensure directory exists
            if (!file_exists(storage_path('app/public/invoices'))) {
                mkdir(storage_path('app/public/invoices'), 0755, true);
            }
            
            $pdf->save($pdfPath);
        }

        // Send Email
        try {
            \Illuminate\Support\Facades\Mail::to($email)->send(
                new \App\Mail\StudentConvertedMail($user, $payment, $tempPassword, $pdfPath)
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send conversion email: ' . $e->getMessage());
        }

        // Send WhatsApp Message manually later, so we just flash the message and invoice path
        if ($user->phone_number) {
            $passwordText = $tempPassword ? "Password Sementara: {$tempPassword}\n\nSilakan login ke " . url('/login') . " dan segera ubah password Anda.\n" : "Password: (Sesuai yang Anda buat saat pendaftaran)\n\nSilakan login ke " . url('/login') . "\n";
            
            $invoiceText = "";
            if ($payment) {
                $formattedAmount = "Rp " . number_format($payment->amount, 0, ',', '.');
                $invoiceText = "No. Invoice: {$payment->invoice_number}\nTotal Pembayaran: {$formattedAmount}\n\n";
            }
            
            $waMessage = "Halo {$user->name},\n\n" .
                "Pendaftaran Anda di Target Bahasa telah berhasil dikonfirmasi!\n\n" .
                "Berikut adalah detail akses akun Anda:\n" .
                "Email: {$email}\n" .
                $passwordText . "\n" .
                $invoiceText .
                "Invoice dan detail lebih lengkap juga telah kami kirimkan ke email Anda.\n\n" .
                "Terima kasih!";
                
            session()->flash('wa_template', $waMessage);
            if ($pdfPath && $payment) {
                session()->flash('invoice_url', asset('storage/invoices/invoice-' . $payment->invoice_number . '.pdf'));
            }
        }

        return redirect()->back()
            ->with('success', "Student baru berhasil dibuat dari lead. Email telah dikirimkan. Silakan copy template WhatsApp di bawah ini untuk dikirim secara manual.");
    }

    private function applyIndexFilters($query, Request $request): void
    {
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        if (!empty($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if (empty($dateFrom) && empty($dateTo)) {
            $windowDays = $this->resolveLeadWindowDays($request);
            if ($windowDays !== null) {
                $query->where('created_at', '>=', now()->subDays($windowDays));
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }
        if ($request->filled('class_period_id')) {
            $query->where('class_period_id', $request->class_period_id);
        }
        if ($request->filled('utm_source')) {
            $query->where('utm_source', $request->utm_source);
        }
        if ($request->filled('utm_campaign')) {
            $query->where('utm_campaign', $request->utm_campaign);
        }
        if ($request->filled('acquisition_source_page')) {
            $query->where('acquisition_source_page', $request->acquisition_source_page);
        }
        if ($request->filled('acquisition_last_cta')) {
            $query->where('acquisition_last_cta', $request->acquisition_last_cta);
        }
        if ($request->boolean('hot')) {
            $query->where('status', 'new')
                ->where('created_at', '>=', now()->subDay());
        }
        if ($request->boolean('converted_today')) {
            $query->whereDate('converted_at', today());
        }
        if ($request->boolean('converted_only')) {
            $query->where('status', 'converted');
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $allowedSortBy = ['created_at', 'converted_at', 'status'];
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDir = strtolower((string) $request->query('sort_dir', 'desc'));

        if (!in_array($sortBy, $allowedSortBy, true)) {
            $sortBy = 'created_at';
        }

        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        $query->orderBy($sortBy, $sortDir)->orderByDesc('id');
    }

    private function logExportAction(string $preset, array $meta = []): void
    {
        try {
            if (!Schema::hasTable('admin_activity_logs')) {
                return;
            }

            DB::table('admin_activity_logs')->insert([
                'user_id' => Auth::id(),
                'action' => 'registration_leads_export',
                'preset' => $preset,
                'meta' => json_encode($meta, JSON_UNESCAPED_SLASHES),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Fail silently so export flow is never blocked by logging.
        }
    }
}
