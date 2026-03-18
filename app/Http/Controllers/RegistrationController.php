<?php

namespace App\Http\Controllers;

use App\Models\ClassPeriod;
use App\Models\Program;
use App\Models\RegistrationLead;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private function extractAttributionData(Request $request): array
    {
        return $request->only([
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_content',
            'utm_term',
            'acquisition_referrer',
            'acquisition_landing_path',
            'acquisition_source_page',
            'acquisition_variant',
            'acquisition_last_cta',
        ]);
    }

    public function show()
    {
        $programs = Program::where('is_active', true)->get(['id', 'name', 'color', 'icon']);
        $classPeriods = ClassPeriod::with('program:id,name')
            ->whereIn('status', ['active', 'upcoming'])
            ->orderBy('start_date')
            ->get(['id', 'name', 'program_id', 'start_date', 'learning_mode', 'batch_type', 'status']);

        return view('registration.form', compact('programs', 'classPeriods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'            => 'required|string|max:150',
            'whatsapp'             => 'required|string|max:20',
            'email'                => 'nullable|email|max:150',
            'city'                 => 'required|string|max:100',
            'age'                  => 'nullable|integer|min:10|max:100',
            'profession'           => 'required|in:student_sma,mahasiswa,karyawan,other',
            'profession_other'     => 'nullable|string|max:100',
            'program_id'           => 'nullable|exists:programs,id',
            'class_period_id'      => 'nullable|exists:class_periods,id',
            'program_interest'     => 'nullable|string|max:100',
            'mode'                 => 'required|in:online,offline,flexible',
            'schedule_preference'  => 'required|in:weekday,weekend,flexible',
            'preferred_time'       => 'required|in:pagi,siang,sore,malam,flexible',
            'learning_goal'        => 'nullable|string|max:1000',
            'target_score'         => 'nullable|string|max:50',
            'source'               => 'required|in:instagram,tiktok,teman,google,brosur,youtube,other',
            'source_detail'        => 'nullable|string|max:100',
            'utm_source'           => 'nullable|string|max:100',
            'utm_medium'           => 'nullable|string|max:100',
            'utm_campaign'         => 'nullable|string|max:150',
            'utm_content'          => 'nullable|string|max:150',
            'utm_term'             => 'nullable|string|max:150',
            'acquisition_referrer' => 'nullable|string|max:1000',
            'acquisition_landing_path' => 'nullable|string|max:255',
            'acquisition_source_page'  => 'nullable|string|max:100',
            'acquisition_variant'      => 'nullable|string|max:50',
            'acquisition_last_cta'     => 'nullable|string|max:100',
            'has_previous_course'  => 'boolean',
            'previous_course_name' => 'nullable|string|max:100',
            'budget_range'         => 'nullable|string|max:50',
            'best_contact_time'    => 'nullable|string|max:100',
            'notes'                => 'nullable|string|max:1000',
        ]);

        $data = array_merge($data, $this->extractAttributionData($request));

        $data['has_previous_course'] = $request->boolean('has_previous_course');

        if (!empty($data['class_period_id'])) {
            $selectedPeriod = ClassPeriod::find($data['class_period_id']);

            if (!$selectedPeriod || !in_array($selectedPeriod->status, ['active', 'upcoming'], true)) {
                return back()->withErrors(['class_period_id' => 'Batch kelas tidak tersedia.'])->withInput();
            }

            if (!empty($data['program_id']) && (int) $selectedPeriod->program_id !== (int) $data['program_id']) {
                return back()->withErrors(['class_period_id' => 'Batch tidak sesuai dengan program yang dipilih.'])->withInput();
            }

            if ($data['mode'] !== 'flexible' && $selectedPeriod->learning_mode !== $data['mode']) {
                return back()->withErrors(['class_period_id' => 'Batch tidak sesuai dengan mode belajar yang dipilih.'])->withInput();
            }
        }

        RegistrationLead::create($data);

        return redirect()->route('registration.success');
    }

    public function success()
    {
        return view('registration.success');
    }
}
