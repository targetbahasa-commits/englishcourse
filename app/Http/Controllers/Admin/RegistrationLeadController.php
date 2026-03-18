<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassPeriod;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\RegistrationLead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class RegistrationLeadController extends Controller
{
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
        $query = RegistrationLead::with(['program', 'classPeriod', 'convertedUser']);
        $this->applyIndexFilters($query, $request);

        $leads    = $query->paginate(20)->withQueryString();
        $programs = Program::where('is_active', true)->get(['id', 'name']);
        $classPeriods = ClassPeriod::with('program:id,name')
            ->whereIn('status', ['active', 'upcoming'])
            ->orderBy('start_date')
            ->get(['id', 'name', 'program_id', 'start_date', 'learning_mode']);

        $insightQuery = RegistrationLead::query();
        $this->applyIndexFilters($insightQuery, $request);

        $attributionInsights = [
            'filtered_total'   => (clone $insightQuery)->count(),
            'top_source_page'  => (clone $insightQuery)
                ->whereNotNull('acquisition_source_page')
                ->where('acquisition_source_page', '!=', '')
                ->selectRaw('acquisition_source_page, COUNT(*) as total')
                ->groupBy('acquisition_source_page')
                ->orderByDesc('total')
                ->first(),
            'top_campaign'     => (clone $insightQuery)
                ->whereNotNull('utm_campaign')
                ->where('utm_campaign', '!=', '')
                ->selectRaw('utm_campaign, COUNT(*) as total')
                ->groupBy('utm_campaign')
                ->orderByDesc('total')
                ->first(),
            'top_last_cta'     => (clone $insightQuery)
                ->whereNotNull('acquisition_last_cta')
                ->where('acquisition_last_cta', '!=', '')
                ->selectRaw('acquisition_last_cta, COUNT(*) as total')
                ->groupBy('acquisition_last_cta')
                ->orderByDesc('total')
                ->first(),
            'converted_total'  => (clone $insightQuery)->where('status', 'converted')->count(),
        ];

        $quickAttributionFilters = [
            'source_pages' => RegistrationLead::query()
                ->whereNotNull('acquisition_source_page')
                ->where('acquisition_source_page', '!=', '')
                ->selectRaw('acquisition_source_page, COUNT(*) as total')
                ->groupBy('acquisition_source_page')
                ->orderByDesc('total')
                ->limit(6)
                ->get(),
            'campaigns' => RegistrationLead::query()
                ->whereNotNull('utm_campaign')
                ->where('utm_campaign', '!=', '')
                ->selectRaw('utm_campaign, COUNT(*) as total')
                ->groupBy('utm_campaign')
                ->orderByDesc('total')
                ->limit(6)
                ->get(),
            'last_ctas' => RegistrationLead::query()
                ->whereNotNull('acquisition_last_cta')
                ->where('acquisition_last_cta', '!=', '')
                ->selectRaw('acquisition_last_cta, COUNT(*) as total')
                ->groupBy('acquisition_last_cta')
                ->orderByDesc('total')
                ->limit(6)
                ->get(),
        ];

        $metrics = [
            'total'           => RegistrationLead::count(),
            'new'             => RegistrationLead::where('status', 'new')->count(),
            'contacted'       => RegistrationLead::where('status', 'contacted')->count(),
            'converted'       => RegistrationLead::where('status', 'converted')->count(),
            'converted_today' => RegistrationLead::whereDate('converted_at', today())->count(),
            'hot'             => RegistrationLead::where('status', 'new')->where('created_at', '>=', now()->subDay())->count(),
            'online'          => RegistrationLead::where('mode', 'online')->count(),
            'offline'         => RegistrationLead::where('mode', 'offline')->count(),
        ];

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

        return view('admin.registration-leads.show', [
            'lead' => $registrationLead->load(['program', 'classPeriod.program', 'convertedUser']),
            'programs' => $programs,
            'classPeriods' => $classPeriods,
        ]);
    }

    public function update(Request $request, RegistrationLead $registrationLead)
    {
        $validated = $request->validate([
            'full_name'        => 'required|string|max:150',
            'whatsapp'         => 'required|string|max:20',
            'email'            => ['nullable', 'email', 'max:150', Rule::unique('users', 'email')->ignore($registrationLead->converted_user_id)],
            'city'             => 'required|string|max:100',
            'profession'       => 'required|in:student_sma,mahasiswa,karyawan,other',
            'profession_other' => 'nullable|string|max:100',
            'program_id'       => 'nullable|exists:programs,id',
            'class_period_id'  => 'nullable|exists:class_periods,id',
            'mode'             => 'required|in:online,offline,flexible',
        ]);

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

        $registrationLead->update($validated);

        if ($registrationLead->convertedUser) {
            $phoneNumber = preg_replace('/[^0-9]/', '', (string) $validated['whatsapp']);
            if ($phoneNumber && str_starts_with($phoneNumber, '0')) {
                $phoneNumber = '62' . substr($phoneNumber, 1);
            }

            $registrationLead->convertedUser->update([
                'name'            => $validated['full_name'],
                'email'           => $validated['email'] ?: $registrationLead->convertedUser->email,
                'phone_number'    => $phoneNumber,
                'program_id'      => $validated['program_id'] ?? null,
                'class_period_id' => $validated['class_period_id'] ?? null,
                'learning_mode'   => $validated['mode'] === 'flexible' ? 'both' : $validated['mode'],
            ]);

            if (!empty($validated['program_id'])) {
                Enrollment::updateOrCreate(
                    ['user_id' => $registrationLead->convertedUser->id, 'program_id' => $validated['program_id']],
                    ['status' => 'active', 'enrolled_at' => now()]
                );
            }
        }

        return back()->with('success', 'Data lead berhasil diperbarui.');
    }

    public function updateStatus(Request $request, RegistrationLead $registrationLead)
    {
        $request->validate([
            'status'      => 'required|in:new,contacted,converted,cancelled',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $data = ['status' => $request->status, 'admin_notes' => $request->admin_notes];
        if ($request->status === 'contacted' && ! $registrationLead->contacted_at) {
            $data['contacted_at'] = now();
        }
        if ($request->status === 'converted' && ! $registrationLead->converted_at) {
            $data['converted_at'] = now();
        }
        if ($request->status !== 'converted') {
            $data['converted_at'] = null;
        }

        $registrationLead->update($data);

        return back()->with('success', 'Status lead berhasil diperbarui.');
    }

    public function destroy(RegistrationLead $registrationLead)
    {
        $registrationLead->delete();
        return redirect()->route('admin.registration-leads.index')
                         ->with('success', 'Lead berhasil dihapus.');
    }

    public function convertToStudent(RegistrationLead $registrationLead)
    {
        if ($registrationLead->status === 'converted' || $registrationLead->converted_user_id) {
            return back()->with('error', 'Lead ini sudah pernah dikonversi.');
        }

        $email = trim((string) $registrationLead->email);
        if ($email === '') {
            $email = 'lead-' . now()->format('YmdHis') . '-' . $registrationLead->id . '@targetbahasa.local';
        }

        if (User::where('email', $email)->exists()) {
            return back()->with('error', 'Email sudah dipakai user lain. Silakan ubah email lead terlebih dahulu.');
        }

        $rawPhone = preg_replace('/[^0-9]/', '', (string) $registrationLead->whatsapp);
        if ($rawPhone && str_starts_with($rawPhone, '0')) {
            $rawPhone = '62' . substr($rawPhone, 1);
        }

        $referralCode = 'TB-' . strtoupper(Str::random(6));
        while (User::where('referral_code', $referralCode)->exists()) {
            $referralCode = 'TB-' . strtoupper(Str::random(6));
        }

        $tempPassword = Str::upper(Str::random(10));

        $user = User::create([
            'name'            => $registrationLead->full_name,
            'email'           => $email,
            'phone_number'    => $rawPhone,
            'password'        => Hash::make($tempPassword),
            'role'            => 'student',
            'status'          => 'active',
            'program_id'      => $registrationLead->program_id,
            'class_period_id' => $registrationLead->class_period_id,
            'learning_mode'   => $registrationLead->mode === 'flexible' ? 'both' : $registrationLead->mode,
            'referral_code'   => $referralCode,
        ]);

        if ($registrationLead->program_id) {
            Enrollment::firstOrCreate(
                ['user_id' => $user->id, 'program_id' => $registrationLead->program_id],
                ['status' => 'active', 'enrolled_at' => now()]
            );
        }

        $registrationLead->update([
            'status'            => 'converted',
            'converted_user_id' => $user->id,
            'contacted_at'      => $registrationLead->contacted_at ?? now(),
            'converted_at'      => now(),
            'admin_notes'       => trim(($registrationLead->admin_notes ? $registrationLead->admin_notes . "\n" : '') . 'Auto converted to student user #' . $user->id),
        ]);

        return redirect()->route('students.show', $user)
            ->with('success', "Student baru berhasil dibuat dari lead. Email login: {$email}, password sementara: {$tempPassword}");
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
