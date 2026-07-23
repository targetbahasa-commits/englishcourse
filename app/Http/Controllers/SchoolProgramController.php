<?php

namespace App\Http\Controllers;

use App\Application\Registration\CreateRegistrationLead;
use Illuminate\Http\Request;

class SchoolProgramController extends Controller
{
    public function __construct(
        private readonly CreateRegistrationLead $createRegistrationLead,
    ) {}

    /**
     * Display the School English Camp landing page.
     */
    public function index()
    {
        return view('school-program');
    }

    /**
     * Store a school inquiry lead from the landing page form.
     */
    public function inquiryStore(Request $request)
    {
        $validated = $request->validate([
            'school_name'       => 'required|string|max:200',
            'pic_name'          => 'required|string|max:150',
            'whatsapp'          => 'required|string|max:20',
            'email'             => 'nullable|email|max:150',
            'city'              => 'required|string|max:100',
            'school_level'      => 'required|in:SD,SMP,SMA,SMK,Lainnya',
            'participant_count' => 'required|in:<20,20-50,50-100,>100',
            'departure_plan'    => 'nullable|string|max:50',
            'notes'             => 'nullable|string|max:1000',
        ]);

        $notes = implode(' | ', array_filter([
            'Sekolah: ' . $validated['school_name'],
            'Jenjang: ' . $validated['school_level'],
            'Jumlah Peserta: ' . $validated['participant_count'],
            $validated['departure_plan'] ? 'Rencana Berangkat: ' . $validated['departure_plan'] : null,
            $validated['notes'] ? 'Catatan: ' . $validated['notes'] : null,
        ]));

        $this->createRegistrationLead->execute([
            'full_name'               => $validated['pic_name'],
            'whatsapp'                => $validated['whatsapp'],
            'email'                   => $validated['email'] ?? null,
            'city'                    => $validated['city'],
            'profession'              => 'Pihak Sekolah / Guru',
            'program_interest'        => 'PARE English School Camp',
            'source'                  => 'school_program',
            'source_detail'           => 'school-program-inquiry-form',
            'status'                  => 'new',
            'acquisition_source_page' => 'school-program',
            'acquisition_last_cta'    => 'school_inquiry_form_submit',
            'notes'                   => $notes,
            'utm_source'              => $request->query('utm_source'),
            'utm_medium'              => $request->query('utm_medium'),
            'utm_campaign'            => $request->query('utm_campaign'),
        ]);

        return back()->with('inquiry_success', true);
    }
}
