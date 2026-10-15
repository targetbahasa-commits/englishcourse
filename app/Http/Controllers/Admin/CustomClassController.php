<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassMeeting;
use App\Models\ClassPeriod;
use App\Models\Enrollment;
use App\Models\Meeting;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Setting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CustomClassController extends Controller
{
    /**
     * Show form to create a new custom online class (Private 1-on-1 or Semi-Private 2-4 students).
     */
    public function create()
    {
        $students = User::where('role', 'student')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone_number']);

        $teachers = User::where('role', 'teacher')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $ratePrivate = (int) (Setting::where('key', 'custom_class_private_rate_per_meeting')->value('value') ?: 150000);
        $rateSemiPrivate = (int) (Setting::where('key', 'custom_class_semi_private_rate_per_meeting')->value('value') ?: 75000);

        return view('admin.custom-classes.create', compact(
            'students',
            'teachers',
            'ratePrivate',
            'rateSemiPrivate'
        ));
    }

    /**
     * Store the custom class, syllabus meetings, enrollments, and optional invoice.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch_type' => 'required|in:private,semi_private',
            'student_selection_mode' => 'required|in:existing,new,both',
            'existing_student_ids' => 'nullable|array',
            'existing_student_ids.*' => 'exists:users,id',
            'new_students' => 'nullable|array',
            'new_students.*.name' => 'required_with:new_students|string|max:255',
            'new_students.*.email' => 'required_with:new_students|email|unique:users,email',
            'new_students.*.phone_number' => 'nullable|string|max:30',
            'teacher_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'zoom_link' => 'nullable|string|max:1000',
            'zoom_password' => 'nullable|string|max:255',
            'total_meetings' => 'required|integer|min:1|max:60',
            'suggested_price' => 'nullable|numeric|min:0',
            'agreed_price' => 'required|numeric|min:0',
            'create_invoice' => 'nullable|boolean',
            'custom_curriculum_notes' => 'nullable|string',
            // Curriculum is built separately after the class exists (see
            // curriculum()/saveCurriculum() below) - a class may legitimately
            // be created with no meetings yet.
            'meetings' => 'nullable|array',
            'meetings.*.meeting_number' => 'required|integer|min:1',
            'meetings.*.topic' => 'required|string|max:255',
            'meetings.*.material_type' => 'required|in:existing,custom',
            'meetings.*.source_program_id' => 'nullable|exists:programs,id',
            'meetings.*.meeting_id' => 'nullable|exists:meetings,id',
            'meetings.*.material_url' => 'nullable|string|max:1000',
            'meetings.*.material_notes' => 'nullable|string',
            'meetings.*.meeting_date' => 'nullable|date',
            'meetings.*.start_time' => 'nullable|string',
            'meetings.*.end_time' => 'nullable|string',
        ]);

        $batchType = $validated['batch_type'];

        // Determine student IDs
        $studentIds = [];
        $createdStudentDetails = [];

        if (in_array($validated['student_selection_mode'], ['existing', 'both'])) {
            $existing = $validated['existing_student_ids'] ?? [];
            foreach ($existing as $id) {
                if (!in_array($id, $studentIds)) {
                    $studentIds[] = $id;
                }
            }
        }

        if (in_array($validated['student_selection_mode'], ['new', 'both'])) {
            $newStudentsData = $validated['new_students'] ?? [];
            foreach ($newStudentsData as $studentRow) {
                if (empty($studentRow['name']) || empty($studentRow['email'])) {
                    continue;
                }
                $plainPassword = Str::random(8);
                $newUser = User::create([
                    'name' => $studentRow['name'],
                    'email' => $studentRow['email'],
                    'phone_number' => $studentRow['phone_number'] ?? ($studentRow['phone'] ?? null),
                    'password' => Hash::make($plainPassword),
                    'role' => 'student',
                    'email_verified_at' => now(),
                ]);

                $studentIds[] = $newUser->id;
                $createdStudentDetails[] = [
                    'user' => $newUser,
                    'password' => $plainPassword,
                ];
            }
        }

        if ($batchType === 'private' && count($studentIds) !== 1) {
            return back()->withErrors(['existing_student_ids' => 'Kelas Privat harus memiliki tepat 1 siswa.'])->withInput();
        }

        if ($batchType === 'semi_private' && (count($studentIds) < 1 || count($studentIds) > 4)) {
            return back()->withErrors(['existing_student_ids' => 'Kelas Semi-Privat harus memiliki 1 hingga 4 siswa.'])->withInput();
        }

        $customProgram = Program::firstOrCreate(
            ['slug' => 'custom-class'],
            [
                'name' => 'Kelas Custom (Privat & Semi-Privat)',
                'period' => 'Fleksibel',
                'description' => 'Kelas online eksklusif privat 1 orang atau semi privat 2-4 orang.',
                'color' => 'indigo',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>',
                'price' => 0,
                'program_type' => 'paket',
                'delivery_mode' => 'online',
                'is_active' => true,
            ]
        );

        $createdClassPeriod = null;
        $primaryPayment = null;
        $primaryStudent = null;

        DB::transaction(function () use ($validated, $batchType, $studentIds, $customProgram, &$createdClassPeriod, &$primaryPayment, &$primaryStudent) {
            // 1. Create ClassPeriod
            $capacity = $batchType === 'private' ? 1 : 4;
            $classPeriod = ClassPeriod::create([
                'name' => $validated['name'],
                'program_id' => $customProgram->id,
                'teacher_id' => $validated['teacher_id'] ?? null,
                'status' => 'active',
                'learning_mode' => 'online',
                'batch_type' => $batchType,
                'min_capacity' => $batchType === 'private' ? 1 : count($studentIds),
                'max_capacity' => $capacity,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'] ?? $validated['start_date'],
                'zoom_link' => $validated['zoom_link'] ?? null,
                'zoom_password' => $validated['zoom_password'] ?? null,
                'is_custom' => true,
                'total_meetings' => (int) $validated['total_meetings'],
                'suggested_price' => $validated['suggested_price'] ?? null,
                'agreed_price' => $validated['agreed_price'],
                'custom_curriculum_notes' => $validated['custom_curriculum_notes'] ?? null,
            ]);

            $createdClassPeriod = $classPeriod;

            // 2. Create ClassMeetings & link existing meetings to pivot
            // (curriculum is usually built afterwards via curriculum()/
            // saveCurriculum() - see "Curriculum & Meeting Builder" on the
            // class's Assignments page, not here)
            $pivotMeetingIds = [];
            foreach ($validated['meetings'] ?? [] as $meetingData) {
                $classMeeting = ClassMeeting::create([
                    'class_period_id' => $classPeriod->id,
                    'meeting_id' => $meetingData['meeting_id'] ?? null,
                    'meeting_number' => $meetingData['meeting_number'],
                    'topic' => $meetingData['topic'],
                    'material_type' => $meetingData['material_type'],
                    'source_program_id' => $meetingData['source_program_id'] ?? null,
                    'material_url' => $meetingData['material_url'] ?? null,
                    'material_notes' => $meetingData['material_notes'] ?? null,
                    'meeting_date' => $meetingData['meeting_date'] ?? null,
                    'start_time' => !empty($meetingData['start_time']) ? $meetingData['start_time'] : null,
                    'end_time' => !empty($meetingData['end_time']) ? $meetingData['end_time'] : null,
                    'meeting_link' => $validated['zoom_link'] ?? null,
                    'meeting_password' => $validated['zoom_password'] ?? null,
                ]);

                if (!empty($meetingData['meeting_id'])) {
                    $pivotMeetingIds[$meetingData['meeting_id']] = ['is_open' => true];
                }
            }

            if (!empty($pivotMeetingIds)) {
                $classPeriod->meetings()->syncWithoutDetaching($pivotMeetingIds);
            }

            // 3. Create Enrollments and optional Payments for each student
            $shouldCreateInvoice = !empty($validated['create_invoice']);
            $pricePerStudent = count($studentIds) > 0 ? (float) ($validated['agreed_price'] / count($studentIds)) : (float) $validated['agreed_price'];

            foreach ($studentIds as $index => $studentId) {
                $studentUser = User::find($studentId);
                if (!$studentUser) {
                    continue;
                }

                if (!$primaryStudent) {
                    $primaryStudent = $studentUser;
                }

                // If student doesn't have class_period_id, assign this one
                if (!$studentUser->class_period_id) {
                    $studentUser->update(['class_period_id' => $classPeriod->id]);
                }

                $enrollment = Enrollment::create([
                    'user_id' => $studentUser->id,
                    'program_id' => $customProgram->id,
                    'class_period_id' => $classPeriod->id,
                    'teacher_id' => $validated['teacher_id'] ?? null,
                    'class_period_booked_at' => now(),
                    'enrolled_at' => now(),
                    'status' => 'active',
                ]);

                if ($shouldCreateInvoice) {
                    $invoiceNumber = 'INV-CUST-' . strtoupper(Str::random(5)) . '-' . date('ymd');
                    $payment = Payment::create([
                        'user_id' => $studentUser->id,
                        'program_id' => $customProgram->id,
                        'enrollment_id' => $enrollment->id,
                        'created_by' => auth()->id(),
                        'invoice_number' => $invoiceNumber,
                        'amount' => $pricePerStudent,
                        'status' => 'pending',
                        'currency' => 'IDR',
                        'due_at' => now()->addDays(3),
                        'notes' => "Invoice Kelas Custom: {$classPeriod->name} ({$classPeriod->total_meetings} Pertemuan)",
                    ]);

                    if (!$primaryPayment) {
                        $primaryPayment = $payment;
                    }

                    // Attempt PDF generation
                    try {
                        $pdf = Pdf::loadView('emails.invoice-pdf', ['payment' => $payment, 'user' => $studentUser]);
                        $pdfFileName = 'invoice-' . $payment->invoice_number . '.pdf';
                        $pdfDirectory = storage_path('app/public/invoices');
                        if (!file_exists($pdfDirectory)) {
                            mkdir($pdfDirectory, 0755, true);
                        }
                        $pdf->save($pdfDirectory . '/' . $pdfFileName);
                    } catch (\Throwable $e) {
                        Log::error('Gagal generate PDF invoice custom class: ' . $e->getMessage());
                    }
                }
            }
        });

        // Generate WhatsApp Notification Template
        $waTemplate = null;
        if ($primaryStudent) {
            $formattedPrice = 'Rp ' . number_format($validated['agreed_price'], 0, ',', '.');
            $typeName = $batchType === 'private' ? 'Privat 1-on-1' : 'Semi-Privat';

            $newAccountInfo = '';
            foreach ($createdStudentDetails as $cred) {
                if ($cred['user']->id === $primaryStudent->id) {
                    $newAccountInfo = "\n\n*Akses Login Target Bahasa:*\nEmail: {$cred['user']->email}\nPassword Sementara: {$cred['password']}\nLogin: " . url('/login');
                    break;
                }
            }

            $invoiceInfo = '';
            if ($primaryPayment) {
                $invoiceInfo = "\n\n*Detail Pembayaran:*\nNo. Invoice: {$primaryPayment->invoice_number}\nTotal Biaya: {$formattedPrice}\nStatus: Menunggu Pembayaran";
            }

            $waTemplate = "Halo {$primaryStudent->name},\n\n" .
                "Kelas online custom Anda di *Target Bahasa Course* telah berhasil kami siapkan!\n\n" .
                "• *Nama Kelas:* {$createdClassPeriod->name}\n" .
                "• *Tipe Kelas:* {$typeName}\n" .
                "• *Jumlah Pertemuan:* {$createdClassPeriod->total_meetings} Pertemuan\n" .
                "• *Mulai:* " . \Carbon\Carbon::parse($createdClassPeriod->start_date)->translatedFormat('d F Y') .
                $invoiceInfo .
                $newAccountInfo . "\n\n" .
                "Kurikulum materi dan jadwal pertemuan sudah dapat dicek di Student Dashboard Anda.\n" .
                "Terima kasih!";

            session()->flash('wa_template', $waTemplate);
            if ($primaryPayment) {
                session()->flash('invoice_url', asset('storage/invoices/invoice-' . $primaryPayment->invoice_number . '.pdf'));
            }
        }

        return redirect()->route('custom-classes.curriculum', $createdClassPeriod->id)
            ->with('success', "Kelas Online Custom '{$createdClassPeriod->name}' berhasil dibuat! Sekarang susun kurikulumnya di bawah ini.");
    }

    /**
     * Show the Curriculum & Meeting Builder for an existing custom class -
     * moved off the creation form (see store()'s docblock) so a class can be
     * created first and its curriculum built/edited afterwards, independent
     * of the one-shot create transaction.
     */
    public function curriculum(ClassPeriod $classPeriod)
    {
        abort_unless($classPeriod->is_custom, 404);

        $existingMeetings = ClassMeeting::where('class_period_id', $classPeriod->id)
            ->orderBy('meeting_number')
            ->get();

        $meetingsForJs = $existingMeetings->map(function (ClassMeeting $meeting) {
            return [
                'meeting_number' => $meeting->meeting_number,
                'material_type' => $meeting->material_type ?: 'existing',
                'selectedCatalogIndex' => '',
                'selectedMeetingIndex' => '',
                'source_program_id' => $meeting->source_program_id,
                'meeting_id' => $meeting->meeting_id,
                'topic' => $meeting->topic,
                'material_url' => $meeting->material_url,
                'material_notes' => $meeting->material_notes,
                'meeting_date' => optional($meeting->meeting_date)->format('Y-m-d'),
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
            ];
        })->values();

        $curriculumCatalog = $this->buildCurriculumCatalog();

        return view('admin.custom-classes.curriculum', compact(
            'classPeriod',
            'existingMeetings',
            'meetingsForJs',
            'curriculumCatalog'
        ));
    }

    /**
     * Replace this custom class's curriculum (ClassMeetings) wholesale with
     * the submitted set - simpler and less error-prone than diffing against
     * what's already there, and matches how store() originally built them.
     */
    public function saveCurriculum(Request $request, ClassPeriod $classPeriod)
    {
        abort_unless($classPeriod->is_custom, 404);

        $validated = $request->validate([
            'meetings' => 'nullable|array',
            'meetings.*.meeting_number' => 'required|integer|min:1',
            'meetings.*.topic' => 'required|string|max:255',
            'meetings.*.material_type' => 'required|in:existing,custom',
            'meetings.*.source_program_id' => 'nullable|exists:programs,id',
            'meetings.*.meeting_id' => 'nullable|exists:meetings,id',
            'meetings.*.material_url' => 'nullable|string|max:1000',
            'meetings.*.material_notes' => 'nullable|string',
            'meetings.*.meeting_date' => 'nullable|date',
            'meetings.*.start_time' => 'nullable|string',
            'meetings.*.end_time' => 'nullable|string',
        ]);

        $meetings = $validated['meetings'] ?? [];

        DB::transaction(function () use ($meetings, $classPeriod) {
            ClassMeeting::where('class_period_id', $classPeriod->id)->delete();

            $pivotMeetingIds = [];
            foreach ($meetings as $meetingData) {
                ClassMeeting::create([
                    'class_period_id' => $classPeriod->id,
                    'meeting_id' => $meetingData['meeting_id'] ?? null,
                    'meeting_number' => $meetingData['meeting_number'],
                    'topic' => $meetingData['topic'],
                    'material_type' => $meetingData['material_type'],
                    'source_program_id' => $meetingData['source_program_id'] ?? null,
                    'material_url' => $meetingData['material_url'] ?? null,
                    'material_notes' => $meetingData['material_notes'] ?? null,
                    'meeting_date' => $meetingData['meeting_date'] ?? null,
                    'start_time' => !empty($meetingData['start_time']) ? $meetingData['start_time'] : null,
                    'end_time' => !empty($meetingData['end_time']) ? $meetingData['end_time'] : null,
                    'meeting_link' => $classPeriod->zoom_link,
                    'meeting_password' => $classPeriod->zoom_password,
                ]);

                if (!empty($meetingData['meeting_id'])) {
                    $pivotMeetingIds[$meetingData['meeting_id']] = ['is_open' => true];
                }
            }

            // Full sync (not syncWithoutDetaching) so a meeting removed from
            // the curriculum here also loses its pivot row, not just ones
            // newly added.
            $classPeriod->meetings()->sync($pivotMeetingIds);

            if (count($meetings) > 0) {
                $classPeriod->update(['total_meetings' => count($meetings)]);
            }
        });

        return redirect()->route('custom-classes.curriculum', $classPeriod->id)
            ->with('success', 'Kurikulum kelas berhasil disimpan (' . count($meetings) . ' pertemuan).');
    }

    /**
     * Build the structured curriculum catalog to power the dynamic meeting builder.
     */
    protected function buildCurriculumCatalog(): array
    {
        $programs = Program::where('is_active', true)
            ->with(['meetings' => function ($q) {
                $q->select('id', 'program_id', 'meeting_number', 'title')
                  ->orderBy('meeting_number');
            }])
            ->get(['id', 'name', 'slug', 'program_type']);

        $catalog = [];

        foreach ($programs as $prog) {
            if ($prog->meetings->isNotEmpty()) {
                $catalog[] = [
                    'program_id' => $prog->id,
                    'program_name' => $prog->name,
                    'category' => $this->detectProgramCategory($prog->slug, $prog->name),
                    'meetings' => $prog->meetings->map(fn($m) => [
                        'meeting_id' => $m->id,
                        'meeting_number' => $m->meeting_number,
                        'title' => $m->title,
                    ])->values()->all(),
                ];
            }
        }

        // Add special modules (IELTS Writing Task 1 & 2, TOEFL ITP, SAT) as quick presets
        $this->appendSpecialModulePresets($catalog);

        return $catalog;
    }

    protected function detectProgramCategory(string $slug, string $name): string
    {
        $slug = strtolower($slug);
        if (str_contains($slug, 'ielts')) return 'IELTS';
        if (str_contains($slug, 'toefl')) return 'TOEFL';
        if (str_contains($slug, 'grammar')) return 'Grammar for Writing';
        if (str_contains($slug, 'speaking')) return 'Speaking';
        if (str_contains($slug, 'sat')) return 'SAT';
        if (str_contains($slug, 'pte')) return 'PTE Academic';
        return 'General English';
    }

    protected function appendSpecialModulePresets(array &$catalog): void
    {
        // TOEFL ITP Modules (1-20)
        $toeflProg = Program::where('slug', 'toefl-itp')->first();
        if ($toeflProg) {
            $listeningMeetings = [];
            $structureMeetings = [];
            $readingMeetings = [];
            for ($i = 1; $i <= 20; $i++) {
                $listeningMeetings[] = ['meeting_id' => null, 'meeting_number' => $i, 'title' => "TOEFL Listening Comprehension - Part $i"];
                $structureMeetings[] = ['meeting_id' => null, 'meeting_number' => $i, 'title' => "TOEFL Structure & Written Expression - Skill $i"];
            }
            for ($i = 1; $i <= 14; $i++) {
                $readingMeetings[] = ['meeting_id' => null, 'meeting_number' => $i, 'title' => "TOEFL Reading Comprehension - Passage & Skill $i"];
            }

            $catalog[] = [
                'program_id' => $toeflProg->id,
                'program_name' => 'TOEFL ITP Listening Skills',
                'category' => 'TOEFL',
                'meetings' => $listeningMeetings,
            ];
            $catalog[] = [
                'program_id' => $toeflProg->id,
                'program_name' => 'TOEFL ITP Structure Skills',
                'category' => 'TOEFL',
                'meetings' => $structureMeetings,
            ];
            $catalog[] = [
                'program_id' => $toeflProg->id,
                'program_name' => 'TOEFL ITP Reading Skills',
                'category' => 'TOEFL',
                'meetings' => $readingMeetings,
            ];
        }

        // IELTS Writing Tasks
        $ieltsWritingProg = Program::where('slug', 'ielts-academic-writing')->orWhere('slug', 'ielts-academic')->first();
        if ($ieltsWritingProg) {
            $writingMeetings = [
                ['meeting_id' => null, 'meeting_number' => 1, 'title' => 'IELTS Writing Task 1: Line Graph & Bar Chart Overview'],
                ['meeting_id' => null, 'meeting_number' => 2, 'title' => 'IELTS Writing Task 1: Pie Chart & Table Analysis'],
                ['meeting_id' => null, 'meeting_number' => 3, 'title' => 'IELTS Writing Task 1: Maps & Comparative Diagrams'],
                ['meeting_id' => null, 'meeting_number' => 4, 'title' => 'IELTS Writing Task 1: Process & Life Cycle Diagrams'],
                ['meeting_id' => null, 'meeting_number' => 5, 'title' => 'IELTS Writing Task 2: Agree or Disagree Essay'],
                ['meeting_id' => null, 'meeting_number' => 6, 'title' => 'IELTS Writing Task 2: Discuss Both Views and Give Opinion'],
                ['meeting_id' => null, 'meeting_number' => 7, 'title' => 'IELTS Writing Task 2: Advantages and Disadvantages Essay'],
                ['meeting_id' => null, 'meeting_number' => 8, 'title' => 'IELTS Writing Task 2: Problem and Solution Essay'],
            ];
            $catalog[] = [
                'program_id' => $ieltsWritingProg->id,
                'program_name' => 'IELTS Academic Writing (Task 1 & Task 2)',
                'category' => 'IELTS',
                'meetings' => $writingMeetings,
            ];
        }

        // SAT Modules
        $satProg = Program::where('slug', 'sat')->first();
        if ($satProg) {
            $satRwMeetings = [];
            $satMathMeetings = [];
            for ($i = 1; $i <= 10; $i++) {
                $satRwMeetings[] = ['meeting_id' => null, 'meeting_number' => $i, 'title' => "Digital SAT Reading & Writing - Module $i"];
                $satMathMeetings[] = ['meeting_id' => null, 'meeting_number' => $i, 'title' => "Digital SAT Math - Module $i"];
            }
            $catalog[] = [
                'program_id' => $satProg->id,
                'program_name' => 'Digital SAT Reading & Writing',
                'category' => 'SAT',
                'meetings' => $satRwMeetings,
            ];
            $catalog[] = [
                'program_id' => $satProg->id,
                'program_name' => 'Digital SAT Math',
                'category' => 'SAT',
                'meetings' => $satMathMeetings,
            ];
        }
    }
}
