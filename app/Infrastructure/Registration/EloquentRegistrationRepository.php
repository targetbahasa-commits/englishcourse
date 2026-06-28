<?php

namespace App\Infrastructure\Registration;

use App\Domain\Registration\Repositories\RegistrationRepository;
use App\Models\ClassPeriod;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\RegistrationLead;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EloquentRegistrationRepository implements RegistrationRepository
{
    public function getActivePrograms(): array
    {
        return Program::where('is_active', true)
            ->where(function ($query) {
                $query->where('slug', 'not like', 'cambridge-%')
                      ->where('slug', 'not like', 'toefl-itp-mock-package-%');
            })
            ->get(['id', 'name', 'color', 'icon', 'program_type', 'description'])
            ->all();
    }

    public function getActiveAndUpcomingClassPeriods(): array
    {
        return ClassPeriod::with('program:id,name')
            ->whereIn('status', ['active', 'upcoming'])
            ->orderBy('start_date')
            ->get(['id', 'name', 'program_id', 'start_date', 'learning_mode', 'batch_type', 'status'])
            ->all();
    }

    public function findClassPeriod(int $id): mixed
    {
        return ClassPeriod::find($id);
    }

    public function findProgram(int $id): mixed
    {
        return Program::find($id);
    }

    public function findProgramByNameLike(string $name): mixed
    {
        return Program::where('name', 'like', '%'.$name.'%')
            ->orWhere('name', 'like', '%'.explode(' ', $name)[0].'%')
            ->first();
    }

    public function createRegistrationLead(array $data): mixed
    {
        return RegistrationLead::create($data);
    }

    public function getLeadsForExport(array $filters): array
    {
        $query = RegistrationLead::with(['program', 'classPeriod', 'convertedUser'])->latest('id');
        $this->applyFilters($query, $filters);

        return $query->get()->all();
    }

    public function getRelatedPaymentForLead(mixed $lead): mixed
    {
        if (!$lead->converted_user_id || !$lead->program_id) {
            return null;
        }

        return \App\Models\Payment::where('user_id', $lead->converted_user_id)
            ->where('program_id', $lead->program_id)
            ->with('program')
            ->latest()
            ->first();
    }

    public function getRelatedEnrollmentForLead(mixed $lead): mixed
    {
        if (!$lead->converted_user_id || !$lead->program_id) {
            return null;
        }

        return Enrollment::where('user_id', $lead->converted_user_id)
            ->where('program_id', $lead->program_id)
            ->with('classPeriod')
            ->first();
    }

    public function isEmailTaken(string $email, ?int $exceptUserId = null): bool
    {
        $query = User::where('email', $email);

        if ($exceptUserId) {
            $query->where('id', '!=', $exceptUserId);
        }

        return $query->exists();
    }

    public function listLeads(array $filters, int $perPage): mixed
    {
        $query = RegistrationLead::with(['program', 'classPeriod', 'convertedUser']);
        $this->applyFilters($query, $filters);
        return $query->paginate($perPage)->withQueryString();
    }

    public function getLeadMetrics(): array
    {
        return [
            'total'           => RegistrationLead::count(),
            'new'             => RegistrationLead::where('status', 'new')->count(),
            'contacted'       => RegistrationLead::where('status', 'contacted')->count(),
            'converted'       => RegistrationLead::where('status', 'converted')->count(),
            'converted_today' => RegistrationLead::whereDate('converted_at', today())->count(),
            'hot'             => RegistrationLead::where('status', 'new')->where('created_at', '>=', now()->subDay())->count(),
            'online'          => RegistrationLead::where('mode', 'online')->count(),
            'offline'         => RegistrationLead::where('mode', 'offline')->count(),
        ];
    }

    public function getAttributionInsights(array $filters): array
    {
        $query = RegistrationLead::query();
        $this->applyFilters($query, $filters);

        return [
            'filtered_total'  => (clone $query)->count(),
            'top_source_page' => (clone $query)
                ->whereNotNull('acquisition_source_page')->where('acquisition_source_page', '!=', '')
                ->selectRaw('acquisition_source_page, COUNT(*) as total')
                ->groupBy('acquisition_source_page')->orderByDesc('total')->first(),
            'top_campaign'    => (clone $query)
                ->whereNotNull('utm_campaign')->where('utm_campaign', '!=', '')
                ->selectRaw('utm_campaign, COUNT(*) as total')
                ->groupBy('utm_campaign')->orderByDesc('total')->first(),
            'top_last_cta'    => (clone $query)
                ->whereNotNull('acquisition_last_cta')->where('acquisition_last_cta', '!=', '')
                ->selectRaw('acquisition_last_cta, COUNT(*) as total')
                ->groupBy('acquisition_last_cta')->orderByDesc('total')->first(),
            'converted_total' => (clone $query)->where('status', 'converted')->count(),
        ];
    }

    public function getQuickAttributionFilters(): array
    {
        return [
            'source_pages' => RegistrationLead::whereNotNull('acquisition_source_page')->where('acquisition_source_page', '!=', '')
                ->selectRaw('acquisition_source_page, COUNT(*) as total')
                ->groupBy('acquisition_source_page')->orderByDesc('total')->limit(6)->get(),
            'campaigns'    => RegistrationLead::whereNotNull('utm_campaign')->where('utm_campaign', '!=', '')
                ->selectRaw('utm_campaign, COUNT(*) as total')
                ->groupBy('utm_campaign')->orderByDesc('total')->limit(6)->get(),
            'last_ctas'    => RegistrationLead::whereNotNull('acquisition_last_cta')->where('acquisition_last_cta', '!=', '')
                ->selectRaw('acquisition_last_cta, COUNT(*) as total')
                ->groupBy('acquisition_last_cta')->orderByDesc('total')->limit(6)->get(),
        ];
    }

    public function findLeadOrFail(int $id): mixed
    {
        return RegistrationLead::findOrFail($id);
    }

    public function updateLead(mixed $lead, array $data): void
    {
        $lead->update($data);
    }

    public function updateConvertedUserFromLead(mixed $lead, array $validated): void
    {
        if (!$lead->convertedUser) {
            return;
        }

        $phoneNumber = preg_replace('/[^0-9]/', '', (string) $validated['whatsapp']);
        if ($phoneNumber && str_starts_with($phoneNumber, '0')) {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        $lead->convertedUser->update([
            'name'            => $validated['full_name'],
            'email'           => $validated['email'] ?: $lead->convertedUser->email,
            'phone_number'    => $phoneNumber,
            'program_id'      => $validated['program_id'] ?? null,
            'class_period_id' => $validated['class_period_id'] ?? null,
            'learning_mode'   => $validated['mode'] === 'flexible' ? 'both' : $validated['mode'],
        ]);

        if (!empty($validated['program_id'])) {
            Enrollment::updateOrCreate(
                ['user_id' => $lead->convertedUser->id, 'program_id' => $validated['program_id']],
                ['status' => 'active', 'enrolled_at' => now()]
            );
        }
    }

    public function convertLeadToStudent(mixed $lead): array
    {
        $email = trim((string) $lead->email);
        if ($email === '') {
            $email = 'lead-' . now()->format('YmdHis') . '-' . $lead->id . '@targetbahasa.local';
        }

        $rawPhone = preg_replace('/[^0-9]/', '', (string) $lead->whatsapp);
        if ($rawPhone && str_starts_with($rawPhone, '0')) {
            $rawPhone = '62' . substr($rawPhone, 1);
        }

        $referralCode = 'TB-' . strtoupper(Str::random(6));
        while (User::where('referral_code', $referralCode)->exists()) {
            $referralCode = 'TB-' . strtoupper(Str::random(6));
        }

        $tempPassword = null;
        $passwordToSave = $lead->password;
        
        if (empty($passwordToSave)) {
            $tempPassword = Str::upper(Str::random(10));
            $passwordToSave = Hash::make($tempPassword);
        }

        $user = User::create([
            'name'            => $lead->full_name,
            'email'           => $email,
            'phone_number'    => $rawPhone,
            'password'        => $passwordToSave,
            'role'            => 'student',
            'status'          => 'active',
            'program_id'      => $lead->program_id,
            'class_period_id' => $lead->class_period_id,
            'learning_mode'   => $lead->mode === 'flexible' ? 'both' : $lead->mode,
            'referral_code'   => $referralCode,
        ]);

        $payment = null;
        if ($lead->program_id) {
            $enrollment = Enrollment::firstOrCreate(
                ['user_id' => $user->id, 'program_id' => $lead->program_id],
                ['status' => 'active', 'enrolled_at' => now()]
            );
            
            $program = Program::find($lead->program_id);
            $amount = $program ? $program->price : 0;
            
            $payment = \App\Models\Payment::create([
                'user_id' => $user->id,
                'program_id' => $lead->program_id,
                'enrollment_id' => $enrollment->id,
                'created_by' => auth()->id() ?? $user->id,
                'invoice_number' => 'TB-INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'amount' => $amount,
                'paid_amount' => $amount,
                'currency' => 'IDR',
                'status' => 'paid',
                'payment_method' => 'manual_transfer',
                'paid_at' => now(),
                'notes' => 'Auto-generated payment on lead conversion.',
            ]);
        }

        $lead->update([
            'status'            => 'converted',
            'converted_user_id' => $user->id,
            'contacted_at'      => $lead->contacted_at ?? now(),
            'converted_at'      => now(),
            'admin_notes'       => trim(($lead->admin_notes ? $lead->admin_notes . "\n" : '') . 'Auto converted to student user #' . $user->id),
        ]);

        return compact('user', 'email', 'tempPassword', 'payment');
    }

    public function deleteLead(mixed $lead): void
    {
        $lead->delete();
    }

    private function applyFilters(mixed $query, array $filters): void
    {
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        if (empty($filters['date_from']) && empty($filters['date_to']) && !empty($filters['date_window'])) {
            $query->where('created_at', '>=', now()->subDays((int) $filters['date_window']));
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['mode'])) {
            $query->where('mode', $filters['mode']);
        }
        if (!empty($filters['program_id'])) {
            $query->where('program_id', $filters['program_id']);
        }
        if (!empty($filters['class_period_id'])) {
            $query->where('class_period_id', $filters['class_period_id']);
        }
        if (!empty($filters['utm_source'])) {
            $query->where('utm_source', $filters['utm_source']);
        }
        if (!empty($filters['utm_campaign'])) {
            $query->where('utm_campaign', $filters['utm_campaign']);
        }
        if (!empty($filters['acquisition_source_page'])) {
            $query->where('acquisition_source_page', $filters['acquisition_source_page']);
        }
        if (!empty($filters['acquisition_last_cta'])) {
            $query->where('acquisition_last_cta', $filters['acquisition_last_cta']);
        }
        if (!empty($filters['hot'])) {
            $query->where('status', 'new')->where('created_at', '>=', now()->subDay());
        }
        if (!empty($filters['converted_today'])) {
            $query->whereDate('converted_at', today());
        }
        if (!empty($filters['converted_only'])) {
            $query->where('status', 'converted');
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $allowedSortBy = ['created_at', 'converted_at', 'status'];
        $sortBy  = in_array($filters['sort_by'] ?? '', $allowedSortBy, true) ? $filters['sort_by'] : 'created_at';
        $sortDir = in_array(strtolower($filters['sort_dir'] ?? ''), ['asc', 'desc'], true) ? strtolower($filters['sort_dir']) : 'desc';

        $query->orderBy($sortBy, $sortDir)->orderByDesc('id');
    }
}
