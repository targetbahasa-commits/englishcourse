<?php

namespace App\Http\Controllers;

use App\Application\Registration\CreateRegistrationLead;
use App\Domain\Registration\Repositories\RegistrationRepository;
use Illuminate\Http\Request;

class PublicRegistrationLeadController extends Controller
{
    public function __construct(
        private readonly RegistrationRepository $repository,
        private readonly CreateRegistrationLead $createRegistrationLead,
    ) {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'        => 'required|string|max:150',
            'whatsapp'         => 'required|string|max:20',
            'city'             => 'nullable|string|max:100',
            'age'              => 'nullable|integer|min:10|max:99',
            'profession'       => 'nullable|string|max:100',
            'program_interest' => 'nullable|string|max:150',
        ]);

        $program = null;
        if (! empty($validated['program_interest'])) {
            $program = $this->repository->findProgramByNameLike($validated['program_interest']);
        }

        $this->createRegistrationLead->execute([
            'full_name'               => $validated['full_name'],
            'whatsapp'                => $validated['whatsapp'],
            'city'                    => $validated['city'] ?? null,
            'age'                     => $validated['age'] ?? null,
            'profession'              => $validated['profession'] ?? null,
            'program_interest'        => $validated['program_interest'] ?? null,
            'program_id'              => $program?->id,
            'source'                  => 'landing_page',
            'source_detail'           => 'form-class',
            'status'                  => 'new',
            'mode'                    => 'flexible',
            'acquisition_source_page' => 'welcome',
            'acquisition_last_cta'    => 'form_class_submit',
            'utm_source'              => $request->query('utm_source'),
            'utm_medium'              => $request->query('utm_medium'),
            'utm_campaign'            => $request->query('utm_campaign'),
        ]);

        $params = http_build_query([
            'name'         => $validated['full_name'],
            'phone_number' => $validated['whatsapp'],
            'program'      => $validated['program_interest'] ?? '',
            'city'         => $validated['city'] ?? '',
        ]);

        return redirect('/student/register?'.$params)
            ->with('success', 'Data kamu sudah tercatat! Silakan buat akun untuk akses kelas.');
    }
}
