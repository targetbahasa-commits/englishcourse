<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Meeting;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpeakingAdminController extends Controller
{
    /**
     * SpeakingAdminController
     *
     * Handles speaking classes selector and speaking lessons management.
     */

    public function speakingClasses()
    {
        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        $enrolledSlugs = [];
        if ($user && $user->isStudent()) {
            if ($user->program) {
                $enrolledSlugs[] = $user->program->slug;
            }
            $enrollments = Enrollment::where('user_id', $user->id)
                ->whereIn('status', ['active', 'completed'])
                ->with('program')
                ->get();
            foreach ($enrollments as $enr) {
                if ($enr->program) {
                    $enrolledSlugs[] = $enr->program->slug;
                }
            }
        }

        $accessIntroductory = $isAdminOrTeacher || in_array('introductory-speaking', $enrolledSlugs, true) || in_array('speaking', $enrolledSlugs, true);
        $accessIntermediate = $isAdminOrTeacher || in_array('intermediate-speaking', $enrolledSlugs, true);
        $accessAdvanced     = $isAdminOrTeacher || in_array('advanced-speaking', $enrolledSlugs, true);
        $accessProficiency  = $isAdminOrTeacher || in_array('proficiency-speaking', $enrolledSlugs, true) || in_array('proficient-speaking', $enrolledSlugs, true);
        $accessSuper        = $isAdminOrTeacher || in_array('super-speaking', $enrolledSlugs, true);

        return view('assignments.speaking-classes', compact(
            'accessIntroductory', 'accessIntermediate', 'accessAdvanced', 'accessProficiency', 'accessSuper', 'isAdminOrTeacher'
        ));
    }

    public function speakingLevel(string $level)
    {
        $tracks = $this->speakingTracks();

        if (! isset($tracks[$level])) {
            abort(404);
        }

        $trackData = $tracks[$level];
        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        // Students may only access the track they are enrolled in
        if (! $isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = [];
            if ($user->program) {
                $enrolledSlugs[] = $user->program->slug;
            }
            $enrollments = Enrollment::where('user_id', $user->id)
                ->whereIn('status', ['active', 'completed'])
                ->with('program')
                ->get();
            foreach ($enrollments as $enr) {
                if ($enr->program) {
                    $enrolledSlugs[] = $enr->program->slug;
                }
            }

            if (! in_array($trackData['program_slug'], $enrolledSlugs, true) && ! in_array('speaking', $enrolledSlugs, true)) {
                return redirect()->route('assignments.speaking.classes')
                    ->with('error', 'Anda tidak memiliki akses ke kelas ini. Silakan daftar program yang sesuai.');
            }
        }

        $program = Program::where('slug', $trackData['program_slug'])
            ->with(['meetings', 'classPeriods'])
            ->first();

        if (! $program) {
            $program = Program::create([
                'name' => $trackData['title'],
                'slug' => $trackData['program_slug'],
                'period' => 'All Time',
                'description' => $trackData['description'],
                'color' => $trackData['accent'] ?? 'rose',
            ]);
            $program->load(['meetings', 'classPeriods']);
        }

        // Auto-seed meetings in database if missing
        if ($program->meetings->isEmpty()) {
            foreach ($trackData['meetings'] as $meetingItem) {
                Meeting::firstOrCreate(
                    [
                        'program_id' => $program->id,
                        'meeting_number' => $meetingItem['source_meeting_number'],
                    ],
                    [
                        'title' => $meetingItem['title'] . ' - ' . $meetingItem['topic'],
                        'is_locked' => false,
                    ]
                );
            }
            $program->load('meetings');
        }

        $selectedClassPeriod = null;
        if ($user && $user->isStudent()) {
            $enrollment = $user->enrollments()->where('program_id', $program->id)->whereHas('classPeriod')->first();
            if ($enrollment) {
                $selectedClassPeriod = $enrollment->classPeriod;
            }
        } elseif ($program->active_class_period_id) {
            $selectedClassPeriod = $program->classPeriods->firstWhere('id', $program->active_class_period_id);
        }

        $classMeetings = collect();
        if ($selectedClassPeriod) {
            $classMeetings = $selectedClassPeriod->classMeetings()
                ->whereIn('meeting_id', $program->meetings->pluck('id'))
                ->get()
                ->keyBy('meeting_id');
        }

        $periodMeetingStatus = collect();
        if ($selectedClassPeriod) {
            $periodMeetingStatus = $selectedClassPeriod->meetings()
                ->pluck('class_period_meetings.is_open', 'meetings.id');
        }

        $program->meetings->transform(function ($meeting) use ($user, $selectedClassPeriod, $periodMeetingStatus, $classMeetings) {
            if ($selectedClassPeriod) {
                $meeting->is_locked = ! ((bool) ($periodMeetingStatus[$meeting->id] ?? false));
            } else {
                $meeting->is_locked = $meeting->isLockedFor($user);
            }

            $meeting->classMeeting = $classMeetings->get($meeting->id);

            return $meeting;
        });

        return view('assignments.speaking-track', [
            'level' => $level,
            'track' => $level,
            'trackData' => $trackData,
            'program' => $program,
            'selectedClassPeriod' => $selectedClassPeriod,
        ]);
    }

    public function speakingMeeting(string $level, int $meeting)
    {
        $tracks = $this->speakingTracks();
        if (! isset($tracks[$level])) {
            abort(404);
        }

        $trackData = $tracks[$level];
        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        // Access check for students
        if (! $isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = [];
            if ($user->program) {
                $enrolledSlugs[] = $user->program->slug;
            }
            $enrollments = Enrollment::where('user_id', $user->id)
                ->whereIn('status', ['active', 'completed'])
                ->with('program')
                ->get();
            foreach ($enrollments as $enr) {
                if ($enr->program) {
                    $enrolledSlugs[] = $enr->program->slug;
                }
            }

            if (! in_array($trackData['program_slug'], $enrolledSlugs, true) && ! in_array('speaking', $enrolledSlugs, true)) {
                return redirect()->route('assignments.speaking.classes')
                    ->with('error', 'Anda tidak memiliki akses ke kelas ini.');
            }
        }

        $program = Program::where('slug', $trackData['program_slug'])
            ->with(['meetings', 'classPeriods'])
            ->first();

        $dbMeeting = $program ? $program->meetings->firstWhere('meeting_number', $meeting) : null;

        // Check if meeting is locked for student
        if (! $isAdminOrTeacher && $dbMeeting && $dbMeeting->isLockedFor($user)) {
            return redirect()->route('assignments.speaking.level', $level)
                ->with('error', 'Meeting ini masih terkunci.');
        }

        $meetingDetails = match($level) {
            'super' => $this->getSuperMeetingContent($meeting),
            'proficiency' => $this->getProficiencyMeetingContent($meeting),
            'advanced' => $this->getAdvancedMeetingContent($meeting),
            'intermediate' => $this->getIntermediateMeetingContent($meeting),
            default => $this->getIntroductoryMeetingContent($meeting),
        };

        // Admin-edited AI Interview questions (see updateAiInterviewQuestions())
        // always win over both the hardcoded per-meeting content above and the
        // blade's own generic fallback - this is the ONLY per-meeting override
        // mechanism for this tab, so it applies uniformly across every level/
        // meeting rather than just the one meeting that happened to have
        // hardcoded 'ai_interview' content originally.
        $aiInterviewOverride = \App\Models\SpeakingAiInterviewOverride::where('level', $level)
            ->where('meeting_number', $meeting)
            ->first();
        if ($aiInterviewOverride) {
            $meetingDetails['ai_interview'] = $aiInterviewOverride->questions;
        }

        $selectedClassPeriod = null;
        if ($user && $user->isStudent()) {
            $enrollment = $user->enrollments()->where('program_id', $program?->id)->whereHas('classPeriod')->first();
            if ($enrollment) {
                $selectedClassPeriod = $enrollment->classPeriod;
            }
        } elseif ($program && $program->active_class_period_id) {
            $selectedClassPeriod = $program->classPeriods->firstWhere('id', $program->active_class_period_id);
        }

        $classMeeting = null;
        if ($selectedClassPeriod && $dbMeeting) {
            $classMeeting = $selectedClassPeriod->classMeetings()
                ->where('meeting_id', $dbMeeting->id)
                ->first();
        }

        // Normalize 'games' into a list (every meeting today is a single flat
        // object, wrapped as a 1-item list) and, for real students only, hide
        // any game an admin has explicitly toggled off for their batch via
        // the Meetings-tab per-game visibility control. Admin/teacher always
        // see every game, mirroring how meeting-level locking already
        // bypasses for them above. Never let the filter empty the list
        // entirely - fall back to showing everything rather than a blank tab.
        $rawGames = $meetingDetails['games'] ?? [];
        $allGames = (is_array($rawGames) && array_is_list($rawGames)) ? $rawGames : [$rawGames];

        $games = $allGames;
        if (!$isAdminOrTeacher && $selectedClassPeriod && count($allGames) > 1) {
            $hiddenIndexes = \App\Models\ClassPeriodGameVisibility::where('class_period_id', $selectedClassPeriod->id)
                ->where('meeting_id', $dbMeeting?->id)
                ->where('is_open', false)
                ->pluck('game_index')
                ->all();
            $filtered = collect($allGames)->reject(fn ($g, $i) => in_array($i, $hiddenIndexes, true))->values()->all();
            if (!empty($filtered)) {
                $games = $filtered;
            }
        }

        // Normalize 'materi' into a list the same way 'games' is normalized
        // above (every meeting today is a single flat object, wrapped as a
        // 1-item list) so the Materi tab can support multiple subtopic
        // blocks per meeting with zero behavior change for existing content.
        // Unlike games, materi blocks aren't hidden per-batch - the Materi
        // tab switcher is a free content browser for everyone (admin,
        // teacher, and students alike), same as the Game Speaking switcher.
        $rawMateri = $meetingDetails['materi'] ?? [];
        $materiBlocks = (is_array($rawMateri) && array_is_list($rawMateri)) ? $rawMateri : [$rawMateri];

        // Admin-bar "Kelompok" management: reuses the same StudentGroup roster
        // + group data already built for admin/class-periods/{id}'s "Kelompok/
        // Pasangan" tab (see ManageClassPeriods::show()), filtered down to
        // groups relevant to THIS meeting - either scoped to it specifically,
        // or batch-wide (meeting_id null) groups that apply everywhere.
        $meetingRosterStudents = collect();
        $meetingStudentGroups = collect();
        if ($selectedClassPeriod) {
            $classPeriodData = app(\App\Application\ClassPeriod\ManageClassPeriods::class)->show($selectedClassPeriod);
            $meetingRosterStudents = $classPeriodData['rosterStudents'];
            $meetingStudentGroups = $classPeriodData['studentGroups']->filter(
                fn ($g) => $g->meeting_id === null || ($dbMeeting && $g->meeting_id === $dbMeeting->id)
            )->values();
        }

        return view('assignments.speaking-meeting', [
            'level' => $level,
            'meetingNumber' => $meeting,
            'meetingData' => $meetingDetails,
            'trackData' => $trackData,
            'program' => $program,
            'dbMeeting' => $dbMeeting,
            'classMeeting' => $classMeeting,
            'selectedClassPeriod' => $selectedClassPeriod,
            'meetingRosterStudents' => $meetingRosterStudents,
            'meetingStudentGroups' => $meetingStudentGroups,
            'games' => $games,
            'materiBlocks' => $materiBlocks,
            'totalMeetings' => count($trackData['meetings']),
        ]);
    }

    /**
     * PUT /admin/speaking/{level}/meeting/{meeting}/ai-interview
     *
     * Admin-only (route already gated by role:admin middleware, checked
     * again here defensively). Upserts an override row that
     * speakingMeeting() consults on every subsequent load of this exact
     * (level, meeting) page - see its docblock comment above.
     */
    public function updateAiInterviewQuestions(Request $request, string $level, int $meeting)
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.hint' => 'nullable|string',
        ]);

        // Re-index sequential ids so the client's aiQuestions[currentAiQIdx]
        // lookup keeps working the same way it already does for the
        // hardcoded default arrays (see speaking-meeting.blade.php).
        $questions = array_values(array_map(
            fn ($q, $idx) => [
                'id' => $idx + 1,
                'question' => $q['question'],
                'hint' => $q['hint'] ?? '',
            ],
            $validated['questions'],
            array_keys($validated['questions'])
        ));

        $override = \App\Models\SpeakingAiInterviewOverride::updateOrCreate(
            ['level' => $level, 'meeting_number' => $meeting],
            ['questions' => $questions]
        );

        return response()->json(['success' => true, 'questions' => $override->questions]);
    }

    /**
     * DELETE /admin/speaking/{level}/meeting/{meeting}/ai-interview
     *
     * Reverts to the original hardcoded question content by simply
     * removing the override row - see speakingMeeting()'s lookup above.
     */
    public function resetAiInterviewQuestions(string $level, int $meeting)
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            abort(403);
        }

        \App\Models\SpeakingAiInterviewOverride::where('level', $level)
            ->where('meeting_number', $meeting)
            ->delete();

        return response()->json(['success' => true]);
    }

    /**
     * POST /assignments/speaking/{level}/meeting/{meeting}/draft
     *
     * Real-time autosave endpoint for speaking meeting pairwork activities.
     * Upserts AssignmentDraft for current student and syncs to pair group members.
     */
    public function saveMeetingDraft(Request $request, string $level, int $meeting)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $inputs = $request->input('inputs', []);
        if (! is_array($inputs)) {
            return response()->json(['success' => false], 400);
        }

        $programSlug = $level . '-speaking';
        $program = Program::where('slug', $programSlug)->first();
        $programId = $program?->id;

        // Upsert user's draft
        \App\Models\AssignmentDraft::updateOrCreate(
            [
                'user_id' => $user->id,
                'program_id' => $programId,
                'meeting_number' => $meeting,
            ],
            [
                'answers' => $inputs,
                'last_saved_at' => now(),
            ]
        );

        // If user is in a StudentGroup for this meeting/class period, sync to partners
        $userGroup = \App\Models\StudentGroup::whereHas('members', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->where(function ($q) use ($meeting) {
            $q->whereNull('meeting_id')->orWhereHas('meeting', fn ($m) => $m->where('meeting_number', $meeting));
        })->with('members')->first();

        if ($userGroup) {
            foreach ($userGroup->members as $member) {
                if ($member->id !== $user->id) {
                    \App\Models\AssignmentDraft::updateOrCreate(
                        [
                            'user_id' => $member->id,
                            'program_id' => $programId,
                            'meeting_number' => $meeting,
                        ],
                        [
                            'answers' => $inputs,
                            'last_saved_at' => now(),
                        ]
                    );
                }
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * GET /assignments/speaking/{level}/meeting/{meeting}/draft
     *
     * Real-time polling endpoint to fetch live pairwork answers.
     */
    public function getMeetingDraft(Request $request, string $level, int $meeting)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['success' => false, 'answers' => []]);
        }

        $programSlug = $level . '-speaking';
        $program = Program::where('slug', $programSlug)->first();
        $programId = $program?->id;

        $draft = \App\Models\AssignmentDraft::where('user_id', $user->id)
            ->where('program_id', $programId)
            ->where('meeting_number', $meeting)
            ->first();

        // Check if group partner has newer answers
        $userGroup = \App\Models\StudentGroup::whereHas('members', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->where(function ($q) use ($meeting) {
            $q->whereNull('meeting_id')->orWhereHas('meeting', fn ($m) => $m->where('meeting_number', $meeting));
        })->with('members')->first();

        if ($userGroup) {
            $partnerIds = $userGroup->members->pluck('id')->all();
            $latestGroupDraft = \App\Models\AssignmentDraft::whereIn('user_id', $partnerIds)
                ->where('program_id', $programId)
                ->where('meeting_number', $meeting)
                ->latest('last_saved_at')
                ->first();

            if ($latestGroupDraft) {
                $draft = $latestGroupDraft;
            }
        }

        return response()->json([
            'success' => true,
            'answers' => $draft?->answers ?? [],
            'last_saved_at' => $draft?->last_saved_at?->toIso8601String(),
        ]);
    }

    public function speaking()
    {
        return view('assignments.speaking');
    }

    /**
     * Reverse-lookup: which speakingTracks() level key does this Program's
     * slug belong to? Null for every non-Speaking program - used to gate the
     * per-game visibility admin UI so it never appears for unrelated programs.
     */
    public function speakingLevelForProgramSlug(string $slug): ?string
    {
        foreach ($this->speakingTracks() as $level => $track) {
            if (($track['program_slug'] ?? null) === $slug) {
                return $level;
            }
        }
        return null;
    }

    /**
     * Normalized (always-a-list) games for one meeting - same wrapping logic
     * used in speaking-meeting.blade.php: every meeting's 'games' key today is
     * a single flat object, wrapped here as a 1-item list so callers (the
     * admin Meetings-tab game-count lookup, and this controller's own
     * per-student visibility filter) always iterate the same way.
     */
    public function gamesForMeeting(string $level, int $meetingNumber): array
    {
        $meetingDetails = match ($level) {
            'super' => $this->getSuperMeetingContent($meetingNumber),
            'proficiency' => $this->getProficiencyMeetingContent($meetingNumber),
            'advanced' => $this->getAdvancedMeetingContent($meetingNumber),
            'intermediate' => $this->getIntermediateMeetingContent($meetingNumber),
            default => $this->getIntroductoryMeetingContent($meetingNumber),
        };

        $rawGames = $meetingDetails['games'] ?? [];

        return (is_array($rawGames) && array_is_list($rawGames)) ? $rawGames : [$rawGames];
    }

    private function speakingTracks(): array
    {
        return [
            'introductory' => [
                'title' => 'First Point Speaking',
                'program_slug' => 'introductory-speaking',
                'description' => 'Kelas dasar berbicara Inggris untuk pemula.',
                'summary' => '10 focused meetings + Final Exam dari percakapan dasar, angka & waktu, pronouns hingga simple present & sentence structures.',
                'accent' => 'rose',
                'gradient' => 'from-rose-500 to-rose-700',
                'meetings' => $this->buildIntroductoryMeetings(),
            ],
            'intermediate' => [
                'title' => 'Second Point Speaking',
                'program_slug' => 'intermediate-speaking',
                'description' => 'Tingkatkan kemampuan berbicara Anda dengan kelas menengah yang komprehensif.',
                'summary' => '10 focused meetings dari perkenalan lanjutan, modal keharusan, degrees of certainty, hingga prefixes/suffixes.',
                'accent' => 'amber',
                'gradient' => 'from-amber-500 to-amber-700',
                'meetings' => $this->buildIntermediateMeetings(),
            ],
            'advanced' => [
                'title' => 'Third Point Speaking',
                'program_slug' => 'advanced-speaking',
                'description' => 'Kuasai berbicara Inggris di level profesional dan akademik.',
                'summary' => '10 focused meetings dari Past Modals, Passive Voice, Causative Verbs, hingga Complex Infinitives.',
                'accent' => 'teal',
                'gradient' => 'from-teal-500 to-teal-700',
                'meetings' => $this->buildAdvancedMeetings(),
            ],
            'proficiency' => [
                'title' => 'Fourth Point Speaking',
                'program_slug' => 'proficiency-speaking',
                'description' => 'Kuasai oratori, diplomasi eksekutif, dan retorika tingkat C2 Masterclass.',
                'summary' => '10 focused meetings dari C2 Rhetoric, Diplomatic Negotiation, Counterfactuals, hingga Capstone Keynote.',
                'accent' => 'purple',
                'gradient' => 'from-purple-600 to-indigo-700',
                'meetings' => $this->buildProficiencyMeetings(),
            ],
            'super' => [
                'title' => 'Super Point Speaking',
                'program_slug' => 'super-speaking',
                'description' => 'Akselerasi kelancaran berbicara tingkat tinggi, pitch eksekutif, dan refleks spontan.',
                'summary' => '10 focused meetings dari Instant Thinking, High-Impact Pitching, Spontaneous Wit, hingga Grand Marathon.',
                'accent' => 'fuchsia',
                'gradient' => 'from-fuchsia-600 to-rose-600',
                'meetings' => $this->buildSuperMeetings(),
            ],
        ];
    }

    private function buildIntroductoryMeetings(): array
    {
        $topics = [
            1 => [
                'topic' => 'Introducing Yourself & Alphabet',
                'description' => 'Introducing yourself, basic greetings & farewells, alphabet phonetics (IPA), and spelling names & words.',
            ],
            2 => [
                'topic' => 'Telling Cardinal Numbers & Telling Time',
                'description' => 'Telling cardinal numbers (0 to millions), telling time (British vs American style), clock expressions & time prepositions (at, from...to).',
            ],
            3 => [
                'topic' => 'Telling Ordinal Numbers & Telling Dates',
                'description' => 'Telling ordinal numbers (1st to 31st+), calendar dates & formats, months, 7 days of the week, and date prepositions (in, on).',
            ],
            4 => [
                'topic' => 'Preposition of Place, There is / There are & Imperatives',
                'description' => 'Prepositions of place (in, on, under, behind, next to), spatial descriptions using there is / there are, and classroom & daily imperatives.',
            ],
            5 => [
                'topic' => 'Prohibition, Pronouns & Possessive Nouns',
                'description' => 'Prohibitions (Don\'t / Must not), possessive nouns (\'s), subject pronouns, noun phrases, possessive adjectives, and family wedding photo pairwork.',
            ],
            6 => [
                'topic' => 'To Be (Statements, Contractions & Questions)',
                'description' => 'Be affirmative statements, Be negative statements, contractions, Be Yes/No questions, and Be WH questions.',
            ],
            7 => [
                'topic' => 'The Simple Present (Positive, Spelling Rules & Frequency Words)',
                'description' => 'The simple present positive sentences, spelling of the -s/-es form, practical daily uses, and adverbs of frequency.',
            ],
            8 => [
                'topic' => 'The Simple Present (Negative Statements & Expressions)',
                'description' => 'The simple present negative statements (do not / does not), and common everyday spoken expressions with simple present.',
            ],
            9 => [
                'topic' => 'To-Infinitive, Yes/No, WH & Subject Questions in Simple Present',
                'description' => 'To-infinitive with simple present verbal, simple present Yes/No questions, WH questions, and Subject Questions.',
            ],
            10 => [
                'topic' => 'Complex Transitive Verbs (VTC) & Linking Verbs',
                'description' => 'Verb Transitive Complex (VTC with objects and complements), linking verbs, subject complements, and sentence structures.',
            ],
            11 => [
                'topic' => 'Review and Final Assessment (Exam)',
                'description' => 'Comprehensive review of all 10 First Point speaking topics, oral evaluation, and final speaking assessment.',
            ],
        ];

        $meetings = [];
        foreach ($topics as $i => $item) {
            $meetings[] = [
                'title' => ($i === 11) ? 'Final Exam' : ('Meeting ' . $i),
                'source_meeting_number' => $i,
                'topic' => $item['topic'],
                'description' => $item['description'],
                'route_name' => 'assignments.speaking.meeting',
                'route_parameters' => ['level' => 'introductory', 'meeting' => $i],
                'available' => true,
            ];
        }

        return $meetings;
    }

    private function buildIntermediateMeetings(): array
    {
        $topics = [
            1 => [
                'topic' => 'Introduction and Greetings B1',
                'description' => 'Introductions, too vs enough, used to vs be used to, leisure activities',
            ],
            2 => [
                'topic' => 'Present Continuous Tense',
                'description' => 'Present continuous (actions in progress & future plans), education and schooling',
            ],
            3 => [
                'topic' => 'Modals of Necessity',
                'description' => 'Must, have to, should, ought to, rules & obligations in transportation',
            ],
            4 => [
                'topic' => 'Degrees of Certainty (Present Time)',
                'description' => 'Must, can’t, may, might, could for deductions and certainty, health vocabulary',
            ],
            5 => [
                'topic' => 'Gerunds & Infinitives 1',
                'description' => 'Verbs followed by gerunds (enjoy, avoid, mind) & infinitives (want, decide, hope)',
            ],
            6 => [
                'topic' => 'Gerunds & Infinitives 2',
                'description' => 'Verbs followed by both (stop, remember, forget), talking about food and dining',
            ],
            7 => [
                'topic' => 'Countable & Uncountable Nouns',
                'description' => 'Many/much, few/little, some/any, shopping and consumer goods',
            ],
            8 => [
                'topic' => 'Comparative & Superlative Degrees',
                'description' => 'Comparative & superlative, irregular forms (better, worse, further), earth and space',
            ],
            9 => [
                'topic' => 'Positive degree & Double degree',
                'description' => 'Positive degree (as...as), double degree (the more... the more), the arts vocabulary',
            ],
            10 => [
                'topic' => 'Suffixes & Prefixes',
                'description' => 'Word building with suffixes & prefixes, tag question intonation',
            ],
        ];

        $meetings = [];
        foreach ($topics as $i => $item) {
            $meetings[] = [
                'title' => 'Meeting ' . $i,
                'source_meeting_number' => $i,
                'topic' => $item['topic'],
                'description' => $item['description'],
                'route_name' => 'assignments.speaking.meeting',
                'route_parameters' => ['level' => 'intermediate', 'meeting' => $i],
                'available' => true,
            ];
        }

        return $meetings;
    }

    private function buildAdvancedMeetings(): array
    {
        $topics = [
            1 => [
                'topic' => 'Introduction and Greetings B2',
                'description' => 'Advanced self-presentation, professional profile pitch, high-stakes introductions',
            ],
            2 => [
                'topic' => 'Past Modals & Degrees of Certainty',
                'description' => 'Must have, could have, should have, speculating on past events with nuance',
            ],
            3 => [
                'topic' => 'Passive Voice (Present & Past)',
                'description' => 'Formal passive construction, institutional and scientific reporting',
            ],
            4 => [
                'topic' => 'Causative Verbs & Advanced Tag Questions',
                'description' => 'Have/get/make/let something done, subtle tag question intonations',
            ],
            5 => [
                'topic' => 'Complex Infinitives & Participles',
                'description' => 'Perfect infinitives, participle clauses for fluent spoken narration',
            ],
            6 => [
                'topic' => 'Advanced Conditionals (Mixed & Inverted)',
                'description' => 'Had I known, mixed conditionals, hypothetical business scenarios',
            ],
            7 => [
                'topic' => 'Discourse Markers & Debate Connectors',
                'description' => 'Structuring arguments, counter-arguments, diplomatic disagreement',
            ],
            8 => [
                'topic' => 'Idiomatic Expressions & Nuanced Collocations',
                'description' => 'Natural executive idioms, metaphorical descriptions in business',
            ],
            9 => [
                'topic' => 'Crisis Communication & Negotiation',
                'description' => 'Handling conflict, negotiating terms, de-escalating tense dialogues',
            ],
            10 => [
                'topic' => 'Capstone Presentation & Spoken Mastery',
                'description' => 'Executive keynote delivery, panel discussion simulation, final spoken review',
            ],
        ];

        $meetings = [];
        foreach ($topics as $i => $item) {
            $meetings[] = [
                'title' => 'Meeting ' . $i,
                'source_meeting_number' => $i,
                'topic' => $item['topic'],
                'description' => $item['description'],
                'route_name' => 'assignments.speaking.meeting',
                'route_parameters' => ['level' => 'advanced', 'meeting' => $i],
                'available' => true,
            ];
        }

        return $meetings;
    }

    private function buildProficiencyMeetings(): array
    {
        $topics = [
            1 => [
                'topic' => 'Introduction and Greetings C1',
                'description' => 'Executive personal branding, diplomatic introduction, rhetorical presence',
            ],
            2 => [
                'topic' => 'Inversion & Advanced Sentence Structures',
                'description' => 'Rarely have I seen, Not only... but also, emphasizing spoken eloquence',
            ],
            3 => [
                'topic' => 'Subjunctive Mood & Counterfactuals',
                'description' => 'I demand that he be present, were it not for, executive policy phrasing',
            ],
            4 => [
                'topic' => 'High-Stakes Persuasion & Rhetoric',
                'description' => 'Ethos, pathos, logos, rhetorical devices for persuasive oral delivery',
            ],
            5 => [
                'topic' => 'Nuanced Pragmatics & Diplomatic Tact',
                'description' => 'Hedging, diplomatic ambiguity, softening authoritative directives',
            ],
            6 => [
                'topic' => 'Complex Narrative & Spoken Storytelling',
                'description' => 'Evocative storytelling, metaphor manipulation, emotional resonance',
            ],
            7 => [
                'topic' => 'Academic & Philosophical Discourse',
                'description' => 'Abstract argumentation, philosophical inquiry, intellectual debate',
            ],
            8 => [
                'topic' => 'Spontaneous Wit & Sharp Rebuttal',
                'description' => 'Humor, sarcasm, sharp rebuttal, high-pressure interview handling',
            ],
            9 => [
                'topic' => 'International Media & Press Briefing',
                'description' => 'Spokesperson delivery, handling press inquiries, crisis PR mastery',
            ],
            10 => [
                'topic' => 'Grand Oratory & Masterclass Keynote',
                'description' => 'TED-style keynote delivery, final mastery assessment, viva voce defense',
            ],
        ];

        $meetings = [];
        foreach ($topics as $i => $item) {
            $meetings[] = [
                'title' => 'Meeting ' . $i,
                'source_meeting_number' => $i,
                'topic' => $item['topic'],
                'description' => $item['description'],
                'route_name' => 'assignments.speaking.meeting',
                'route_parameters' => ['level' => 'proficiency', 'meeting' => $i],
                'available' => true,
            ];
        }

        return $meetings;
    }

    private function buildSuperMeetings(): array
    {
        $topics = [
            1 => [
                'topic' => 'Super Speaking Calibration & Instant Fluency',
                'description' => 'Rapid reflex activation, zero-hesitation response, neurological priming',
            ],
            2 => [
                'topic' => 'Rapid-Fire Debate & Lightning Argumentation',
                'description' => 'Split-second rebuttal, dynamic synthesis, rapid-fire cross-examination',
            ],
            3 => [
                'topic' => 'High-Impact Executive Pitching (Elevator to Boardroom)',
                'description' => '30-second elevator pitch, boardroom conviction, venture capital storytelling',
            ],
            4 => [
                'topic' => 'Crisis Negotiation & Hostage Mediation Simulation',
                'description' => 'Tactical empathy, crisis negotiation under extreme pressure, de-escalation',
            ],
            5 => [
                'topic' => 'Spontaneous Humor, Wit & Crowd Domination',
                'description' => 'Audience command, comedic timing, sharp improvisational wit, charismatic banter',
            ],
            6 => [
                'topic' => 'Advanced Cross-Cultural Diplomacy & Geopolitics',
                'description' => 'Multilateral summit diplomacy, cross-cultural nuance, geopolitical rhetoric',
            ],
            7 => [
                'topic' => 'Broadcast Journalism & Live Anchor Delivery',
                'description' => 'Live breaking news anchoring, unscripted teleprompter failure recovery',
            ],
            8 => [
                'topic' => 'Philosophical Dialectics & High-Concept Synthesis',
                'description' => 'Deconstructing paradoxes, conceptual synthesis, visionary discourse',
            ],
            9 => [
                'topic' => 'Hyper-Persuasive Oratory & Crowd Mobilization',
                'description' => 'Inspirational mobilization, monumental speeches, cadence and cadence modulation',
            ],
            10 => [
                'topic' => 'The Grand Marathon: 360-Degree Speaking Championship',
                'description' => 'Ultimate multidimensional speaking gauntlet, final championship evaluation',
            ],
        ];

        $meetings = [];
        foreach ($topics as $i => $item) {
            $meetings[] = [
                'title' => 'Meeting ' . $i,
                'source_meeting_number' => $i,
                'topic' => $item['topic'],
                'description' => $item['description'],
                'route_name' => 'assignments.speaking.meeting',
                'route_parameters' => ['level' => 'super', 'meeting' => $i],
                'available' => true,
            ];
        }

        return $meetings;
    }

    private function getIntroductoryMeetingContent(int $meeting): array
    {
        $data = [
                        1 => [
                'topic' => 'Introduction and Greetings',
                'focus' => 'Greetings & Farewells, Basic Self-Introduction, Personal Pronouns & To Be, Likes & Hobbies',
                'materi' => [
                    'greetings' => [
                        'formal' => [
                            ['en' => 'Good morning', 'id' => 'Selamat pagi (06:00 - 12:00)'],
                            ['en' => 'Good afternoon', 'id' => 'Selamat siang / sore (12:00 - 18:00)'],
                            ['en' => 'Good evening', 'id' => 'Selamat malam (18:00+)'],
                        ],
                        'informal' => [
                            ['en' => 'Hi!', 'id' => 'Hai!'],
                            ['en' => 'Hey! How\'s it going?', 'id' => 'Hei! Bagaimana kabarmu?'],
                        ],
                        'closing' => [
                            ['en' => 'Goodbye', 'id' => 'Selamat tinggal / Sampai jumpa'],
                            ['en' => 'See you later', 'id' => 'Sampai jumpa lagi nanti'],
                            ['en' => 'Have a nice day', 'id' => 'Semoga harimu menyenangkan'],
                        ]
                    ],
                    'self_intro_templates' => [
                        ['label' => 'Name', 'pattern' => 'My name is [Name] / I\'m [Name]', 'example' => 'My name is Student A / I\'m Student B.'],
                        ['label' => 'Age', 'pattern' => 'I am [number] years old', 'example' => 'I am 20 years old / She is 25 years old.'],
                        ['label' => 'Origin', 'pattern' => 'I am from [Country/City]', 'example' => 'I am from Jakarta, Indonesia / I am from Sydney, Australia.'],
                        ['label' => 'Profession', 'pattern' => 'I am a/an [Profession]', 'example' => 'I am an English teacher / I am an English instructor.'],
                    ],
                    'grammar_basics' => [
                        'subject_pronouns' => ['I', 'You', 'He', 'She', 'It', 'We', 'They'],
                        'to_be_conjugations' => [
                            ['subject' => 'I', 'to_be' => 'am', 'contraction' => 'I\'m', 'example' => 'I am an English teacher.'],
                            ['subject' => 'You', 'to_be' => 'are', 'contraction' => 'You\'re', 'example' => 'You are my partner.'],
                            ['subject' => 'We', 'to_be' => 'are', 'contraction' => 'We\'re', 'example' => 'We are learning English together.'],
                            ['subject' => 'They', 'to_be' => 'are', 'contraction' => 'They\'re', 'example' => 'They are friendly classmates.'],
                            ['subject' => 'He', 'to_be' => 'is', 'contraction' => 'He\'s', 'example' => 'He is 20 years old.'],
                            ['subject' => 'She', 'to_be' => 'is', 'contraction' => 'She\'s', 'example' => 'She is from Sydney, Australia.'],
                            ['subject' => 'It', 'to_be' => 'is', 'contraction' => 'It\'s', 'example' => 'It is nice to meet you.'],
                        ]
                    ],
                    'likes_hobbies' => [
                        'patterns' => ['I like + [Noun / V-ing]', 'I don\'t like + [Noun / V-ing]', 'I enjoy + [V-ing]'],
                        'examples' => [
                            ['en' => 'In my free time, I like reading books and playing football.', 'id' => 'Di waktu luang, saya suka membaca buku dan bermain sepak bola.'],
                            ['en' => 'I enjoy hiking in the mountains.', 'id' => 'Saya menikmati mendaki gunung.'],
                            ['en' => 'I don\'t like waking up late.', 'id' => 'Saya tidak suka bangun terlambat.'],
                        ]
                    ],
                    'template' => "Hello everyone! Good morning.

My name is [Full Name]. I am [Age] years old. You can call me [Nick Name].

I am from [City/Country].

I am a/an [Profession].

In my free time, I like [Hobbies/Likes].

It is nice to meet you all. Thank you!",
                    'example' => "Hello! Good morning. How's it going?

My name is Student A. I am 20 years old.

I am from Jakarta, Indonesia, and I am an English teacher.

In my free time, I like reading books and playing football.

It is very nice to meet you all. Have a nice day!"
                ],
                'listening' => [
                    'title' => 'Short Listening: Student Introduction & Dialogue Practice',
                    'audio_script' => "Student A: Hello! Good morning. How's it going? Student B: Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name? Student A: My name is Student A. I'm 20 years old. Where are you from, Student B? Student B: I am from Sydney, Australia. I am an English instructor. What is your profession, Student A? Student A: I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football. Student B: That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A! Student A: It is nice to meet you too, Student B! Have a nice day and see you later!",
                    'key_phrases' => [
                        'How\'s it going? Everything is going great, thank you!',
                        'I am from Sydney, Australia. I am an English instructor.',
                        'I am an English teacher from Jakarta, Indonesia.',
                        'In my free time, I like reading books and playing football.',
                        'That is wonderful! I enjoy hiking in the mountains.',
                        'It is nice to meet you too! Have a nice day and see you later!',
                    ],
                    'questions' => [
                        [
                            'q' => 'Where is Student B from and what is her profession?',
                            'options' => [
                                'From Sydney, Australia; English instructor',
                                'From Jakarta, Indonesia; English teacher',
                                'From Bandung, Indonesia; Doctor',
                                'From London, UK; Engineer',
                            ],
                            'answer' => 'From Sydney, Australia; English instructor',
                        ],
                        [
                            'q' => 'Where is Student A from and what is his profession?',
                            'options' => [
                                'From Jakarta, Indonesia; English teacher',
                                'From Sydney, Australia; English instructor',
                                'From Tokyo, Japan; Pilot',
                                'From Melbourne, Australia; Doctor',
                            ],
                            'answer' => 'From Jakarta, Indonesia; English teacher',
                        ],
                        [
                            'q' => 'What hobbies are mentioned by Student A and Student B?',
                            'options' => [
                                'Student A likes reading & football; Student B enjoys hiking',
                                'Student A likes swimming; Student B likes cooking',
                                'Both students like playing video games',
                                'Student A likes dancing; Student B likes singing',
                            ],
                            'answer' => 'Student A likes reading & football; Student B enjoys hiking',
                        ],
                    ],
                ],
                'drilling1' => [
                    ['en' => 'Hello everyone! Good morning, my name is Student A.', 'id' => 'Halo semuanya! Selamat pagi, nama saya Student A.'],
                    ['en' => 'I am twenty years old, and you can call me Student A.', 'id' => 'Saya berumur dua puluh tahun, dan Anda bisa memanggil saya Student A.'],
                    ['en' => 'I am from Jakarta, Indonesia, and I am an English teacher.', 'id' => 'Saya berasal dari Jakarta, Indonesia, dan saya seorang guru bahasa Inggris.'],
                    ['en' => 'In my free time, I like reading books and playing football.', 'id' => 'Di waktu luang saya, saya suka membaca buku dan bermain sepak bola.'],
                    ['en' => 'It is very nice to meet all of you today.', 'id' => 'Sangat senang bertemu dengan Anda semua hari ini.'],
                ],
                'drilling2' => [
                    ['en' => 'Hi! Good morning. How\'s it going? Everything is going great, thank you!', 'id' => 'Hai! Selamat pagi. Bagaimana kabarmu? Semuanya baik-baik saja, terima kasih!'],
                    ['en' => 'I am from Sydney, Australia, and I am an English instructor.', 'id' => 'Saya berasal dari Sydney, Australia, dan saya seorang instruktur bahasa Inggris.'],
                    ['en' => 'What is your profession, and where are you from, Student A?', 'id' => 'Apa profesimu, dan dari mana asalmu, Student A?'],
                    ['en' => 'That is wonderful! In my free time, I enjoy hiking in the mountains.', 'id' => 'Luar biasa! Di waktu luang, saya menikmati mendaki gunung.'],
                    ['en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!', 'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!'],
                ],
                'grammar_note' => "Subject Pronouns (I, You, He, She, It, We, They) & Verb 'To Be' (am / is / are) | Contractions: I'm, You're, He's, She's, It's, We're, They're",
                'dialogue_setting' => 'Dua peserta kursus, Student A dan Student B, saling berkenalan di hari pertama kelas First Point Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Student A',
                        'en' => 'Hello! Good morning. How\'s it going?',
                        'id' => 'Halo! Selamat pagi. Bagaimana kabarmu?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name?',
                        'id' => 'Hai! Selamat pagi. Semuanya baik-baik saja, terima kasih! Nama saya Student B. Siapa nama kamu?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'My name is Student A. I\'m 20 years old. Where are you from, Student B?',
                        'id' => 'Nama saya Student A. Saya berumur 20 tahun. Dari mana asalmu, Student B?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'I am from Sydney, Australia. I am an English instructor. What is your profession, Student A?',
                        'id' => 'Saya berasal dari Sydney, Australia. Saya seorang instruktur bahasa Inggris. Apa profesimu, Student A?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football.',
                        'id' => 'Saya seorang guru bahasa Inggris dari Jakarta, Indonesia. Di waktu luang, saya suka membaca buku dan bermain sepak bola.',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A!',
                        'id' => 'Luar biasa! Saya menikmati mendaki gunung. Sangat senang berkenalan denganmu, Student A!',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!',
                        'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!',
                    ],
                ],
                'games' => [
                    'title' => 'Zoom Speaking Game: Class Ice-Breaker Survey (Level A1 - Simple Present)',
                    'participation_type' => 'individual',
                    'activity' => 'Whole class: speaking',
                    'aim' => 'To find out personal information and daily habits of classmates using only Simple Present Tense (habits, routines, likes, personal details).',
                    'grammar_functions' => 'Simple Present Tense (do / does, is / am / are, verb 1, routines & habits).',
                    'vocabulary' => 'Personal details, Hometown, Family, Food, Drinks, Hobbies, Daily routines, and Preferences.',
                    'time' => '15 to 20 minutes',
                    'cards' => [
                        [
                            'id' => 1,
                            'title' => "What is your favourite colour?",
                            'question' => "What is your favourite colour?",
                            'sample_answer' => "My favourite colour is [Blue / Red / Green / Black].",
                            'category' => 'Favorites',
                            'badge' => 'Colour Survey',
                            'image' => '/images/speaking/a1_present/card_1.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 2,
                            'title' => "What do you do in your free time?",
                            'question' => "What do you do in your free time?",
                            'sample_answer' => "In my free time, I [read books / play football / listen to music / watch movies].",
                            'category' => 'Hobbies',
                            'badge' => 'Free Time Routine',
                            'image' => '/images/speaking/a1_present/card_2.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 3,
                            'title' => "What time do you usually wake up?",
                            'question' => "What time do you usually wake up every morning?",
                            'sample_answer' => "I usually wake up at [6:00 AM / 7:00 AM] every morning.",
                            'category' => 'Habits',
                            'badge' => 'Morning Routine',
                            'image' => '/images/speaking/a1_present/card_3.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 4,
                            'title' => "What do you eat for breakfast?",
                            'question' => "What do you usually eat for breakfast?",
                            'sample_answer' => "I usually eat [fried rice / two eggs / bread / noodles] for breakfast.",
                            'category' => 'Food & Routine',
                            'badge' => 'Breakfast Habit',
                            'image' => '/images/speaking/a1_present/card_4.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 5,
                            'title' => "Where do you live?",
                            'question' => "Where are you from and where do you live right now?",
                            'sample_answer' => "I am from [City/Country], and I live in [City].",
                            'category' => 'Location',
                            'badge' => 'Hometown & Living',
                            'image' => '/images/speaking/a1_present/card_5.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 6,
                            'title' => "What do you do on weekends?",
                            'question' => "What do you usually do on weekends?",
                            'sample_answer' => "On weekends, I usually [clean my room / visit my family / study English / relax at home].",
                            'category' => 'Routine',
                            'badge' => 'Weekend Habit',
                            'image' => '/images/speaking/a1_present/card_6.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 7,
                            'title' => "How many people are in your family?",
                            'question' => "How many people are there in your family?",
                            'sample_answer' => "There are [4 / 5 / 6] people in my family: [my parents, siblings, and me].",
                            'category' => 'Family',
                            'badge' => 'Family Size',
                            'image' => '/images/speaking/a1_present/card_7.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 8,
                            'title' => "Where do you go on holidays?",
                            'question' => "Where do you usually go for your holidays?",
                            'sample_answer' => "For holidays, I usually go to [the beach / Bali / Bandung / Yogyakarta].",
                            'category' => 'Travel',
                            'badge' => 'Holiday Destination',
                            'image' => '/images/speaking/a1_present/card_8.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 9,
                            'title' => "Do you have any pets at home?",
                            'question' => "Do you have any pets at home?",
                            'sample_answer' => "Yes, I have [a cat / a dog / two birds]. / No, I do not have any pets.",
                            'category' => 'Personal Info',
                            'badge' => 'Pets Survey',
                            'image' => '/images/speaking/a1_present/card_9.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 10,
                            'title' => "Do you like watching movies?",
                            'question' => "Do you like watching movies?",
                            'sample_answer' => "Yes, I like watching [action / comedy / animation] movies at the cinema / at home.",
                            'category' => 'Entertainment',
                            'badge' => 'Movie Taste',
                            'image' => '/images/speaking/a1_present/card_10.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 11,
                            'title' => "When is your birthday?",
                            'question' => "When is your birthday?",
                            'sample_answer' => "My birthday is on [the 15th of September / in August].",
                            'category' => 'Dates & Personal',
                            'badge' => 'Birthday Month',
                            'image' => '/images/speaking/a1_present/card_11.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 12,
                            'title' => "What kind of music do you like?",
                            'question' => "What kind of music do you like listening to?",
                            'sample_answer' => "I like listening to [Pop / Rock / Jazz / Classical / R&B] music.",
                            'category' => 'Music & Taste',
                            'badge' => 'Music Genre',
                            'image' => '/images/speaking/a1_present/card_12.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 13,
                            'title' => "What is your job or daily activity?",
                            'question' => "What do you do every day? Are you a student or working?",
                            'sample_answer' => "I am a [student at school / university / working as a professional].",
                            'category' => 'Profession',
                            'badge' => 'Job & Study',
                            'image' => '/images/speaking/a1_present/card_13.png?v=2026_aesthetic',
                        ],
                        [
                            'id' => 14,
                            'title' => "What is your favourite drink?",
                            'question' => "What is your favourite drink or beverage?",
                            'sample_answer' => "My favourite drink is [mineral water / iced tea / coffee / fresh fruit juice].",
                            'category' => 'Drinks',
                            'badge' => 'Favourite Drink',
                            'image' => '/images/speaking/a1_present/card_14.png?v=2026_aesthetic',
                        ],
                    ],
                    'report_examples' => [
                        'In our class, most students like Fried Rice and Iced Tea.',
                        'Most of my classmates wake up around 6:00 AM every morning.',
                        'In our group, 7 out of 10 students have pets at home.',
                        'Most students in our class relax at home or hang out with friends on weekends.'
                    ],
                ],
                'ai_interview' => [
                    [
                        'id' => 1,
                        'question' => "Hello! Welcome to your speaking practice session. Let's start with an introduction: What is your full name, and what should I call you?",
                        'hint' => "Answer: 'Hello! My full name is [Your Name], and you can call me [Nickname].'",
                    ],
                    [
                        'id' => 2,
                        'question' => "Nice to meet you! Where are you originally from, and where do you live right now?",
                        'hint' => "Answer: 'I am from [City/Country], and I currently live in [City].'",
                    ],
                    [
                        'id' => 3,
                        'question' => "Great! What is your current job or daily activity? Are you a student or are you working?",
                        'hint' => "Answer: 'I am a student at [School/University] / I work as a [Job].'",
                    ],
                    [
                        'id' => 4,
                        'question' => "Interesting! What do you usually like doing in your free time or on weekends?",
                        'hint' => "Answer: 'In my free time, I really enjoy [reading / playing sports / watching movies].'",
                    ],
                    [
                        'id' => 5,
                        'question' => "Wonderful! Why do you want to learn and improve your English speaking skills?",
                        'hint' => "Answer: 'I want to improve my English because [for my career / study / travel abroad].'",
                    ],
                ],
                'monolog_baku' => [
                    "Hello everyone! Good morning. My name is Budi Sugeng. I am 20 years old. You can call me Budi. I am from Jakarta, Indonesia. I am an English teacher. In my free time, I like reading books and playing football. It is nice to meet you all. Thank you!",
                    "Good afternoon, ladies and gentlemen. I am delighted to introduce myself. My name is Sarah Miller, and I am from Sydney, Australia. I work as an instructor, and I enjoy reading historical novels in my leisure time. It is a pleasure to meet everyone."
                ],
                'monolog_tidak_baku' => [
                    "Hi guys! Hey, how's it going? I'm Budi, 20 years old from Jakarta. I teach English and in my spare time I really love hanging out with friends and playing football. Super stoked to meet you all!",
                    "Hey everyone! What's up? I'm Sarah from Sydney. I'm into reading and outdoor hiking when I'm not working. Great to be here with you guys!"
                ],
                'questions_part_a' => [
                    'What is your full name and what is your nickname?',
                    'How old are you?',
                    'Where are you from (City & Country)?',
                    'What is your current profession or field of study?',
                    'What do you like doing in your free time?',
                ],
                'questions_part_b' => [
                    'How do you greet someone formally in the morning, afternoon, and evening?',
                    'What is the difference between "I like reading" and "I don\'t like reading"?',
                    'Can you introduce your best friend using "He is..." or "She is..."?',
                    'How do you say goodbye politely to your teacher at the end of class?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Complete Self-Introduction Showcase',
                'impromptu' => [
                    'Aktivitas 1: Sampaikan perkenalan diri lengkapmu tanpa membaca teks selama 60 detik mengikuti template Budi Sugeng!',
                    'Aktivitas 2: Lakukan perkenalan santai (informal greeting) seolah-olah kamu sedang berkenalan di kafe internasional.',
                    'Aktivitas 3: Jelaskan 3 hal yang paling kamu sukai (likes) dan 2 hal yang tidak kamu sukai (dislikes) dalam kehidupan sehari-hari.',
                    'Aktivitas 4: Rekam suaramu pada fitur Voice Recorder di bawah dan dengarkan kembali intonasimu!',
                ],
            ],
            2 => [
                'topic' => 'Alphabet Pronunciation & Jobs / Occupations',
                'focus' => 'English Alphabet Phonetics (IPA), Spelling Names & Words, Jobs & Occupations Vocabulary, Half a Crossword Speaking Activity',
                'materi' => [
                    'alphabet_list' => [
                        ['letter' => 'A', 'ipa' => 'eɪ', 'id_sound' => 'ei', 'example' => 'Actor / Apple'],
                        ['letter' => 'B', 'ipa' => 'biː', 'id_sound' => 'bi', 'example' => 'Baker / Barber'],
                        ['letter' => 'C', 'ipa' => 'siː', 'id_sound' => 'si', 'example' => 'Chef / Carpenter'],
                        ['letter' => 'D', 'ipa' => 'diː', 'id_sound' => 'di', 'example' => 'Dentist / Dustman'],
                        ['letter' => 'E', 'ipa' => 'iː', 'id_sound' => 'i', 'example' => 'Engineer / Eagle'],
                        ['letter' => 'F', 'ipa' => 'ɛf', 'id_sound' => 'ef', 'example' => 'Farmer / Food'],
                        ['letter' => 'G', 'ipa' => 'ʤiː', 'id_sound' => 'ji', 'example' => 'Green / Guide'],
                        ['letter' => 'H', 'ipa' => 'eɪʧ', 'id_sound' => 'eich', 'example' => 'Hairdresser / House'],
                        ['letter' => 'I', 'ipa' => 'aɪ', 'id_sound' => 'ai', 'example' => 'Ice / Island'],
                        ['letter' => 'J', 'ipa' => 'ʤeɪ', 'id_sound' => 'jei', 'example' => 'Journalist / Job'],
                        ['letter' => 'K', 'ipa' => 'keɪ', 'id_sound' => 'kei', 'example' => 'King / Key'],
                        ['letter' => 'L', 'ipa' => 'ɛl', 'id_sound' => 'el', 'example' => 'Librarian / Lion'],
                        ['letter' => 'M', 'ipa' => 'ɛm', 'id_sound' => 'em', 'example' => 'Miner / Moon'],
                        ['letter' => 'N', 'ipa' => 'ɛn', 'id_sound' => 'en', 'example' => 'Nurse / Night'],
                        ['letter' => 'O', 'ipa' => 'oʊ', 'id_sound' => 'ou', 'example' => 'Ocean / Office'],
                        ['letter' => 'P', 'ipa' => 'piː', 'id_sound' => 'pi', 'example' => 'Pilot / Police'],
                        ['letter' => 'Q', 'ipa' => 'kjuː', 'id_sound' => 'kyu', 'example' => 'Queen / Quiet'],
                        ['letter' => 'R', 'ipa' => 'ɑːr', 'id_sound' => 'ar', 'example' => 'Red / Radio'],
                        ['letter' => 'S', 'ipa' => 'ɛs', 'id_sound' => 'es', 'example' => 'Secretary / Salesman'],
                        ['letter' => 'T', 'ipa' => 'tiː', 'id_sound' => 'ti', 'example' => 'Traffic warden / Teacher'],
                        ['letter' => 'U', 'ipa' => 'juː', 'id_sound' => 'yu', 'example' => 'Uniform / University'],
                        ['letter' => 'V', 'ipa' => 'viː', 'id_sound' => 'vi', 'example' => 'Vet (Veterinarian) / Village'],
                        ['letter' => 'W', 'ipa' => 'ˈdʌbəljuː', 'id_sound' => 'dabel-yu', 'example' => 'Waiter / Warden'],
                        ['letter' => 'X', 'ipa' => 'ɛks', 'id_sound' => 'eks', 'example' => 'X-ray / Expert'],
                        ['letter' => 'Y', 'ipa' => 'waɪ', 'id_sound' => 'wai', 'example' => 'Yellow / Young'],
                        ['letter' => 'Z', 'ipa' => 'ziː', 'id_sound' => 'zi (zee)', 'example' => 'Zoo / Zebra'],
                    ],
                    'alphabet_groups' => [
                        [
                            'group_title' => 'Group 1: /eɪ/, /aɪ/, /kjuː/, /waɪ/',
                            'theme' => 'blue',
                            'letters' => [
                                ['letter' => 'A', 'ipa' => 'eɪ', 'id_sound' => 'ei', 'example' => 'Actor / Apple'],
                                ['letter' => 'I', 'ipa' => 'aɪ', 'id_sound' => 'ai', 'example' => 'Ice / Island'],
                                ['letter' => 'Q', 'ipa' => 'kjuː', 'id_sound' => 'kyu', 'example' => 'Queen / Quiet'],
                                ['letter' => 'Y', 'ipa' => 'waɪ', 'id_sound' => 'wai', 'example' => 'Yellow / Young'],
                            ]
                        ],
                        [
                            'group_title' => 'Group 2: /biː/, /ʤeɪ/, /ɑːr/, /ziː/',
                            'theme' => 'amber',
                            'letters' => [
                                ['letter' => 'B', 'ipa' => 'biː', 'id_sound' => 'bi', 'example' => 'Baker / Barber'],
                                ['letter' => 'J', 'ipa' => 'ʤeɪ', 'id_sound' => 'jei', 'example' => 'Journalist / Job'],
                                ['letter' => 'R', 'ipa' => 'ɑːr', 'id_sound' => 'ar', 'example' => 'Red / Radio'],
                                ['letter' => 'Z', 'ipa' => 'ziː', 'id_sound' => 'zi (zee)', 'example' => 'Zoo / Zebra'],
                            ]
                        ],
                        [
                            'group_title' => 'Group 3: /siː/, /keɪ/, /ɛs/',
                            'theme' => 'emerald',
                            'letters' => [
                                ['letter' => 'C', 'ipa' => 'siː', 'id_sound' => 'si', 'example' => 'Chef / Carpenter'],
                                ['letter' => 'K', 'ipa' => 'keɪ', 'id_sound' => 'kei', 'example' => 'King / Key'],
                                ['letter' => 'S', 'ipa' => 'ɛs', 'id_sound' => 'es', 'example' => 'Secretary / Salesman'],
                            ]
                        ],
                        [
                            'group_title' => 'Group 4: /diː/, /ɛl/, /tiː/',
                            'theme' => 'indigo',
                            'letters' => [
                                ['letter' => 'D', 'ipa' => 'diː', 'id_sound' => 'di', 'example' => 'Dentist / Dustman'],
                                ['letter' => 'L', 'ipa' => 'ɛl', 'id_sound' => 'el', 'example' => 'Librarian / Lion'],
                                ['letter' => 'T', 'ipa' => 'tiː', 'id_sound' => 'ti', 'example' => 'Traffic warden / Teacher'],
                            ]
                        ],
                        [
                            'group_title' => 'Group 5: /iː/, /ɛm/, /juː/',
                            'theme' => 'purple',
                            'letters' => [
                                ['letter' => 'E', 'ipa' => 'iː', 'id_sound' => 'i', 'example' => 'Engineer / Eagle'],
                                ['letter' => 'M', 'ipa' => 'ɛm', 'id_sound' => 'em', 'example' => 'Miner / Moon'],
                                ['letter' => 'U', 'ipa' => 'juː', 'id_sound' => 'yu', 'example' => 'Uniform / University'],
                            ]
                        ],
                        [
                            'group_title' => 'Group 6: /ɛf/, /ɛn/, /viː/',
                            'theme' => 'sky',
                            'letters' => [
                                ['letter' => 'F', 'ipa' => 'ɛf', 'id_sound' => 'ef', 'example' => 'Farmer / Food'],
                                ['letter' => 'N', 'ipa' => 'ɛn', 'id_sound' => 'en', 'example' => 'Nurse / Night'],
                                ['letter' => 'V', 'ipa' => 'viː', 'id_sound' => 'vi', 'example' => 'Vet (Veterinarian) / Village'],
                            ]
                        ],
                        [
                            'group_title' => 'Group 7: /ʤiː/, /oʊ/, /ˈdʌbəljuː/',
                            'theme' => 'orange',
                            'letters' => [
                                ['letter' => 'G', 'ipa' => 'ʤiː', 'id_sound' => 'ji', 'example' => 'Green / Guide'],
                                ['letter' => 'O', 'ipa' => 'oʊ', 'id_sound' => 'ou', 'example' => 'Ocean / Office'],
                                ['letter' => 'W', 'ipa' => 'ˈdʌbəljuː', 'id_sound' => 'dabel-yu', 'example' => 'Waiter / Warden'],
                            ]
                        ],
                        [
                            'group_title' => 'Group 8: /eɪʧ/, /piː/, /ɛks/',
                            'theme' => 'rose',
                            'letters' => [
                                ['letter' => 'H', 'ipa' => 'eɪʧ', 'id_sound' => 'eich', 'example' => 'Hairdresser / House'],
                                ['letter' => 'P', 'ipa' => 'piː', 'id_sound' => 'pi', 'example' => 'Pilot / Police'],
                                ['letter' => 'X', 'ipa' => 'ɛks', 'id_sound' => 'eks', 'example' => 'X-ray / Expert'],
                            ]
                        ],
                    ],
                    'spelling_rules' => [
                        ['label' => 'Ask for Spelling', 'pattern' => 'How do you spell your [name / job / city]?', 'example' => 'How do you spell your first name? -> It is J-O-H-N.'],
                        ['label' => 'Clarify & Confirm', 'pattern' => 'Could you spell that please? / Did you say [Letter] or [Letter]?', 'example' => 'Did you say B as in Baker, or V as in Vet?'],
                        ['label' => 'Double Letters', 'pattern' => 'Double [Letter]', 'example' => 'H-A-I-R-D-R-E-Double S-E-R (Hairdresser).'],
                    ],
                    'jobs_group_a' => [
                        ['job' => 'actor', 'ipa' => '/ˈæk.tər/', 'id' => 'Aktor / Pemeran film/teater', 'definition' => 'A person who performs in plays, movies, or television shows.'],
                        ['job' => 'carpenter', 'ipa' => '/ˈkɑː.pɪn.tər/', 'id' => 'Tukang kayu', 'definition' => 'A person whose job is making and repairing wooden objects and structures.'],
                        ['job' => 'dentist', 'ipa' => '/ˈden.tɪst/', 'id' => 'Dokter gigi', 'definition' => 'A person qualified to treat diseases and conditions that affect the teeth and gums.'],
                        ['job' => 'hairdresser', 'ipa' => '/ˈheəˌdres.ər/', 'id' => 'Penata rambut', 'definition' => 'A person who cuts, washes, colors, and styles people\'s hair.'],
                        ['job' => 'vet', 'ipa' => '/vet/', 'id' => 'Dokter hewan (veterinarian)', 'definition' => 'A doctor who specializes in treating sick and injured animals.'],
                        ['job' => 'baker', 'ipa' => '/ˈbeɪ.kər/', 'id' => 'Pembuat / Penjual roti', 'definition' => 'A person who bakes and sells bread, cakes, and pastries.'],
                        ['job' => 'chef', 'ipa' => '/ʃef/', 'id' => 'Koki profesional', 'definition' => 'A skilled and trained professional cook who works in a restaurant or hotel.'],
                        ['job' => 'doctor', 'ipa' => '/ˈdɒk.tər/', 'id' => 'Dokter', 'definition' => 'A person with medical qualification who treats people who are sick or injured.'],
                        ['job' => 'librarian', 'ipa' => '/laɪˈbreə.ri.ən/', 'id' => 'Pustakawan', 'definition' => 'A person who works in or is in charge of a library.'],
                        ['job' => 'waiter', 'ipa' => '/ˈweɪ.tər/', 'id' => 'Pelayan pria restoran', 'definition' => 'A person whose job is serving food and drinks to customers in a restaurant.'],
                        ['job' => 'butcher', 'ipa' => '/ˈbʊtʃ.ər/', 'id' => 'Tukang daging', 'definition' => 'A person who cuts up, prepares, and sells meat in a shop.'],
                    ],
                    'jobs_group_b' => [
                        ['job' => 'architect', 'ipa' => '/ˈɑː.kɪ.tekt/', 'id' => 'Arsitek', 'definition' => 'A person who designs buildings and oversees their construction.'],
                        ['job' => 'farmer', 'ipa' => '/ˈfɑː.mər/', 'id' => 'Petani / Peternak', 'definition' => 'A person who owns or manages a farm and produces crops or raises livestock.'],
                        ['job' => 'miner', 'ipa' => '/ˈmaɪ.nər/', 'id' => 'Penambang', 'definition' => 'A person who works underground extracting coal, gold, or other minerals.'],
                        ['job' => 'pilot', 'ipa' => '/ˈpaɪ.lət/', 'id' => 'Pilot pesawat', 'definition' => 'A person who is licensed to fly aircraft such as airplanes or helicopters.'],
                        ['job' => 'secretary', 'ipa' => '/ˈsek.rə.tər.i/', 'id' => 'Sekretaris kantor', 'definition' => 'A person employed in an office to assist with letters, appointments, and records.'],
                        ['job' => 'barber', 'ipa' => '/ˈbɑː.bər/', 'id' => 'Pemangkas rambut pria', 'definition' => 'A person whose job is shaving men\'s beards and cutting men\'s hair.'],
                        ['job' => 'journalist', 'ipa' => '/ˈdʒɜː.nə.lɪst/', 'id' => 'Wartawan / Jurnalis', 'definition' => 'A person who writes for newspapers, magazines, or broadcasts news on TV/radio.'],
                        ['job' => 'nurse', 'ipa' => '/nɜːs/', 'id' => 'Perawat medis', 'definition' => 'A person trained to care for the sick or infirm, especially in a hospital.'],
                        ['job' => 'salesman', 'ipa' => '/ˈseɪlz.mən/', 'id' => 'Pramuniaga / Penjual', 'definition' => 'A person whose job is selling goods or services in a store or to clients.'],
                        ['job' => 'traffic warden', 'ipa' => '/ˈtræf.ɪk ˌwɔː.dən/', 'id' => 'Petugas pengatur lalu lintas & parkir', 'definition' => 'An official who checks that vehicles are not parked illegally and directs traffic.'],
                        ['job' => 'dustman', 'ipa' => '/ˈdʌst.mən/', 'id' => 'Petugas kebersihan / Pengangkut sampah', 'definition' => 'A person employed by a local council to collect domestic refuse and rubbish.'],
                    ],
                    'clue_templates' => [
                        'A person who...' => 'A person who treats sick animals (Vet)',
                        'Someone whose job is...' => 'Someone whose job is cutting and selling meat (Butcher)',
                        'They work in a...' => 'They work in a library and help people find books (Librarian)',
                    ]
                ],
                'listening' => [
                    'title' => 'Short Listening: Conference Registration & Spelling Names',
                    'audio_script' => "Receptionist: Good morning! Welcome to the Global Careers Conference. May I have your full name, please?\n\nAttendee: Good morning! My name is Alexander Wright.\n\nReceptionist: Could you spell your last name for me, Mr. Wright?\n\nAttendee: Sure! It's W. R. I. G. H. T.\n\nReceptionist: Thank you. And what is your current occupation?\n\nAttendee: I work as an architect for a design firm in London.\n\nReceptionist: Wonderful. Let me print your conference badge: Alexander Wright, Architect. Here is your pass. Enjoy the event!\n\nAttendee: Thank you very much!",
                    'key_phrases' => [
                        'May I have your full name, please?',
                        'Could you spell your last name for me? It\'s W. R. I. G. H. T.',
                        'What is your current occupation? I work as an architect.',
                        'Here is your conference pass. Enjoy the event!',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the attendee\'s last name?',
                            'options' => [
                                'Wright',
                                'White',
                                'Walker',
                                'Wood',
                            ],
                            'answer' => 'Wright',
                        ],
                        [
                            'q' => 'How is the last name spelled by the attendee?',
                            'options' => [
                                'W. R. I. G. H. T.',
                                'W. I. G. H. T.',
                                'R. I. G. H. T.',
                                'W. R. I. T. E.',
                            ],
                            'answer' => 'W. R. I. G. H. T.',
                        ],
                        [
                            'q' => 'What is Alexander\'s current occupation?',
                            'options' => [
                                'Architect',
                                'Journalist',
                                'Doctor',
                                'Dentist',
                            ],
                            'answer' => 'Architect',
                        ],
                    ],
                ],
                'drilling1' => [
                    ['en' => 'Good morning! Welcome to our English Course.', 'id' => 'Selamat pagi! Selamat datang di Kursus Bahasa Inggris kami.'],
                    ['en' => 'Could you state your full name and spell your surname for registration?', 'id' => 'Bisakah Anda menyebutkan nama lengkap dan mengeja nama belakang Anda untuk pendaftaran?'],
                    ['en' => 'Good morning! My name is Student B. My surname is spelled [spell your surname].', 'id' => 'Selamat pagi! Nama saya Student B. Nama belakang saya dieja [eja nama anda].'],
                    ['en' => 'What is your current profession or occupation? I work as an architect.', 'id' => 'Apa profesi atau pekerjaan Anda saat ini? Saya bekerja sebagai seorang arsitek.'],
                    ['en' => 'How do you spell architect? It is A. R. C. H. I. T. E. C. T.', 'id' => 'Bagaimana Anda mengeja arsitek? Yaitu A. R. C. H. I. T. E. C. T.'],
                    ['en' => 'An architect is a person who designs modern buildings and homes.', 'id' => 'Seorang arsitek adalah seseorang yang merancang bangunan dan rumah modern.'],
                ],
                'drilling2' => [
                    ['en' => 'Good afternoon! Welcome to the Grand Hotel.', 'id' => 'Selamat siang! Selamat datang di Grand Hotel.'],
                    ['en' => 'Could you please spell your surname for check-in?', 'id' => 'Bisakah Anda mengeja nama keluarga Anda untuk check-in?'],
                    ['en' => 'Good afternoon! My name is Student A. My surname is spelled [spell your surname].', 'id' => 'Selamat siang! Nama saya Student A. Nama keluarga saya dieja [eja nama anda].'],
                    ['en' => 'May I also know your current occupation and email address?', 'id' => 'Boleh saya tahu profesi Anda saat ini dan alamat email Anda?'],
                    ['en' => 'I work as a journalist for a news magazine. A journalist reports news.', 'id' => 'Saya bekerja sebagai jurnalis untuk majalah berita. Seorang jurnalis melaporkan berita.'],
                    ['en' => 'How do you spell journalist? It is J. O. U. R. N. A. L. I. S. T.', 'id' => 'Bagaimana Anda mengeja jurnalis? Yaitu J. O. U. R. N. A. L. I. S. T.'],
                ],
                'grammar_note' => 'Rumus Percakapan Partnering: "Could you please spell your [name/surname]?" & "A [Job] is a person who + [Verb-s]..."',
                'dialogue_setting' => 'Praktek Berpasangan 2 Ronde (Roleplay & Switch Roles): Ronde 1 di Front Desk Kursus Bahasa Inggris, lalu bertukar peran di Ronde 2 saat Check-in Hotel Internasional.',
                'dialogue' => [
                    // --- RONDE 1: FRONT DESK KURSUS BAHASA INGGRIS ---
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Front Desk Officer',
                        'section_badge' => 'Ronde 1: Pendaftaran Kursus Bahasa Inggris (Student A: Resepsionis | Student B: Siswa Baru)',
                        'en' => 'Good morning! Welcome to our English Course. Could you state your full name and spell your surname for registration?',
                        'id' => 'Selamat pagi! Selamat datang di Kursus Bahasa Inggris kami. Bisakah Anda menyebutkan nama lengkap dan mengeja nama belakang Anda untuk pendaftaran?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'New Student',
                        'en' => 'Good morning! My name is Student B. My surname is spelled [spell your surname].',
                        'id' => 'Selamat pagi! Nama saya Student B. Nama belakang saya dieja [eja nama anda].',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Front Desk Officer',
                        'en' => 'Thank you, Student B! What is your current profession or occupation?',
                        'id' => 'Terima kasih, Student B! Apa profesi atau pekerjaan Anda saat ini?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'New Student',
                        'en' => 'I work as an architect. An architect is a person who designs modern buildings and homes.',
                        'id' => 'Saya bekerja sebagai seorang arsitek. Seorang arsitek adalah seseorang yang merancang bangunan dan rumah modern.',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Front Desk Officer',
                        'en' => 'How do you spell architect? Is it A. R. C. H. I. T. E. C. T.?',
                        'id' => 'Bagaimana Anda mengeja arsitek? Apakah A. R. C. H. I. T. E. C. T.?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'New Student',
                        'en' => 'Yes, exactly! A. R. C. H. I. T. E. C. T. That is right!',
                        'id' => 'Ya, tepat sekali! A. R. C. H. I. T. E. C. T. Itu benar!',
                    ],

                    // --- RONDE 2: TUKAR PERAN (SWITCH ROLES) - CHECK-IN HOTEL INTERNASIONAL ---
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Hotel Receptionist',
                        'section_badge' => 'Ronde 2: Tukar Peran - Check-In Hotel Internasional (Student B: Resepsionis Hotel | Student A: Tamu Hotel)',
                        'en' => 'Good afternoon! Welcome to the Grand Hotel. Could you please spell your surname for check-in?',
                        'id' => 'Selamat siang! Selamat datang di Grand Hotel. Bisakah Anda mengeja nama keluarga Anda untuk check-in?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Hotel Guest',
                        'en' => 'Good afternoon! My name is Student A. My surname is spelled [spell your surname].',
                        'id' => 'Selamat siang! Nama saya Student A. Nama keluarga saya dieja [eja nama anda].',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Hotel Receptionist',
                        'en' => 'Thank you, Student A! May I also know your current occupation and email address?',
                        'id' => 'Terima kasih, Student A! Boleh saya tahu profesi Anda saat ini dan alamat email Anda?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Hotel Guest',
                        'en' => 'Sure! I work as a journalist for a news magazine. A journalist is a person who reports news.',
                        'id' => 'Tentu! Saya bekerja sebagai jurnalis untuk majalah berita. Seorang jurnalis adalah seseorang yang melaporkan berita.',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Hotel Receptionist',
                        'en' => 'How do you spell journalist? Did you say J. O. U. R. N. A. L. I. S. T.?',
                        'id' => 'Bagaimana Anda mengeja jurnalis? Apakah Anda mengatakan J. O. U. R. N. A. L. I. S. T.?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Hotel Guest',
                        'en' => 'Yes, that is correct! J. O. U. R. N. A. L. I. S. T. Thank you!',
                        'id' => 'Ya, itu benar! J. O. U. R. N. A. L. I. S. T. Terima kasih!',
                    ],
                ],
                'questions_part_a' => [
                    'Bisa tolong eja nama lengkap dan nama panggilanmu huruf demi huruf?',
                    'Apa pekerjaan atau profesi impianmu di masa depan?',
                    'Menurutmu, mengapa mengeja nama secara akurat sangat penting saat wawancara kerja atau pendaftaran resmi?',
                    'Bagaimana cara membedakan pengucapan huruf B dan V, atau G dan J dalam bahasa Inggris?',
                    'Jika kamu bekerja sebagai seorang jurnalis internasional, topik apa yang paling ingin kamu liput?',
                    'Sebutkan 3 profesi di sekitarmu dan jelaskan apa tugas utama mereka menggunakan rumus "A person who..."!',
                    'Menurutmu, profesi mana yang paling menantang: pilot, dokter, arsitek, atau penambang (miner)?',
                    'Bagaimana cara mengeja kata "ARCHITECT" dan "SECRETARY" dengan benar?',
                ],
                'questions_part_b' => [
                    'Mengapa seorang chef profesional harus memiliki disiplin dan keterampilan tinggi di dapur?',
                    'Pernahkah kamu harus mengeja nama atau alamat emailmu kepada orang asing atau customer service berbahasa Inggris?',
                    'Keahlian apa yang paling dibutuhkan oleh seorang tukang kayu modern (carpenter) saat ini?',
                    'Menurutmu, apakah peran seorang pustakawan (librarian) masih sangat dibutuhkan di era digital saat ini?',
                    'Sebutkan 3 huruf dalam abjad Inggris yang pengucapannya paling sering membingungkan bagi pembelajar pemula!',
                    'Profesi apa yang menurutmu memiliki dampak paling besar bagi masyarakat?',
                    'Bagaimana caramu menjelaskan pekerjaan seorang "dentist" dan "veterinarian" dalam bahasa Inggris?',
                    'Jika kamu bisa bertukar peran pekerjaan selama satu hari dengan seorang pilot, ke negara mana kamu ingin terbang?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Professions, Spelling & Career Aspirations',
                'impromptu' => [
                    'Mengapa kemampuan mengeja nama dan istilah secara tepat (spelling) sangat penting dalam komunikasi profesional internasional?',
                    'Jelaskan peran penting seorang arsitek (architect) dalam membangun kota masa depan yang ramah lingkungan!',
                    'Bagaimana perkembangan teknologi kecerdasan buatan (AI) akan memengaruhi profesi seperti jurnalis, sekretaris, dan penerjemah?',
                    'Ceritakan pengalamanmu saat harus berinteraksi dengan dokter atau dokter gigi, dan bagaimana mereka menjelaskan kondisi kesehatanmu!',
                    'Jika kamu mendirikan perusahaan sendiri, profesi atau staf apa yang pertama kali akan kamu rekrut dan mengapa?',
                    'Bagaimana profesi sektor pelayanan publik seperti traffic warden dan dustman berkontribusi pada keteraturan kehidupan perkotaan?',
                    'Pilihlah salah satu dari 22 profesi pada game hari ini dan deskripsikan rutinitas kerja sehari-penuhnya dari pagi hingga malam!',
                    'Apa saran terbaik yang akan kamu berikan kepada seseorang yang sedang bingung memilih jalur karir masa depannya?',
                ],
                'games' => [
                    'title' => 'Zoom Speaking Game: Half a Crossword (Jobs and Occupations - Group A & Group B)',
                    'type' => 'half_a_crossword',
                    'participation_type' => 'pair',
                    'activity' => 'Pair work / Group work: Speaking & Guessing',
                    'aim' => 'To complete the crossword puzzle by describing and asking for missing job words without saying the target words.',
                    'grammar_functions' => 'Relative clauses: "A person who + [Verb]...", "What\'s [number] across/down?", Spelling words letter by letter.',
                    'vocabulary' => '22 Jobs: actor, carpenter, dentist, hairdresser, vet, baker, chef, doctor, librarian, waiter, butcher, architect, farmer, miner, pilot, secretary, barber, journalist, nurse, salesman, traffic warden, dustman.',
                    'time' => '20 to 25 minutes',
                    'drilling_game' => [
                        [
                            'category' => '1. Giliran Tanya Jawab (Pemain A Bertanya ke Pemain B)',
                            'en' => "What is 3 across?",
                            'id' => "Apa nomor 3 mendatar?",
                        ],
                        [
                            'category' => '1. Giliran Tanya Jawab (Pemain A Bertanya ke Pemain B)',
                            'en' => "3 across is farmer.",
                            'id' => "3 mendatar adalah farmer.",
                        ],
                        [
                            'category' => '1. Giliran Tanya Jawab (Pemain A Bertanya ke Pemain B)',
                            'en' => "How do you spell it?",
                            'id' => "Bagaimana Anda mengejanya?",
                        ],
                        [
                            'category' => '1. Giliran Tanya Jawab (Pemain A Bertanya ke Pemain B)',
                            'en' => "It is F. A. R. M. E. R.",
                            'id' => "Yaitu F. A. R. M. E. R.",
                        ],
                        [
                            'category' => '2. Giliran Tanya Jawab (Pemain B Bertanya ke Pemain A)',
                            'en' => "What is 8 down?",
                            'id' => "Apa nomor 8 menurun?",
                        ],
                        [
                            'category' => '2. Giliran Tanya Jawab (Pemain B Bertanya ke Pemain A)',
                            'en' => "8 down is waiter.",
                            'id' => "8 menurun adalah waiter.",
                        ],
                        [
                            'category' => '2. Giliran Tanya Jawab (Pemain B Bertanya ke Pemain A)',
                            'en' => "How do you spell it?",
                            'id' => "Bagaimana Anda mengejanya?",
                        ],
                        [
                            'category' => '2. Giliran Tanya Jawab (Pemain B Bertanya ke Pemain A)',
                            'en' => "It is W. A. I. T. E. R.",
                            'id' => "Yaitu W. A. I. T. E. R.",
                        ],
                        [
                            'category' => '3. Contoh Percakapan Lengkap (Pemain B Bertanya ke Pemain A)',
                            'en' => "What is 4 across? 4 across is actor. How do you spell it? It is A. C. T. O. R.",
                            'id' => "Apa nomor 4 mendatar? 4 mendatar adalah actor. Bagaimana mengejanya? Yaitu A. C. T. O. R.",
                        ],
                        [
                            'category' => '3. Contoh Percakapan Lengkap (Pemain A Bertanya ke Pemain B)',
                            'en' => "What is 14 down? 14 down is architect. How do you spell it? It is A. R. C. H. I. T. E. C. T.",
                            'id' => "Apa nomor 14 menurun? 14 menurun adalah architect. Bagaimana mengejanya? Yaitu A. R. C. H. I. T. E. C. T.",
                        ],
                    ],
                    'group_a_image' => '/images/speaking/worksheet2/group_a_crossword.png',
                    'group_b_image' => '/images/speaking/worksheet2/group_b_crossword.png',
                    'group_a_words' => ['actor', 'carpenter', 'dentist', 'hairdresser', 'vet', 'baker', 'chef', 'doctor', 'librarian', 'waiter', 'butcher'],
                    'group_b_words' => ['architect', 'farmer', 'miner', 'pilot', 'secretary', 'barber', 'journalist', 'nurse', 'salesman', 'traffic warden', 'dustman'],
                    'group_a_missing' => [
                        ['id' => '3A', 'number' => '3 Across', 'question' => 'What is 3 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 3 across', 'target_word' => 'FARMER', 'letters' => ['F', 'A', 'R', 'M', 'E', 'R'], 'answer_preview' => '3 across is farmer. F - A - R - M - E - R.'],
                        ['id' => '2D', 'number' => '2 Down', 'question' => 'What is 2 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 2 down', 'target_word' => 'SECRETARY', 'letters' => ['S', 'E', 'C', 'R', 'E', 'T', 'A', 'R', 'Y'], 'answer_preview' => '2 down is secretary. S - E - C - R - E - T - A - R - Y.'],
                        ['id' => '5D', 'number' => '5 Down', 'question' => 'What is 5 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 5 down', 'target_word' => 'JOURNALIST', 'letters' => ['J', 'O', 'U', 'R', 'N', 'A', 'L', 'I', 'S', 'T'], 'answer_preview' => '5 down is journalist. J - O - U - R - N - A - L - I - S - T.'],
                        ['id' => '9A', 'number' => '9 Across', 'question' => 'What is 9 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 9 across', 'target_word' => 'SALESMAN', 'letters' => ['S', 'A', 'L', 'E', 'S', 'M', 'A', 'N'], 'answer_preview' => '9 across is salesman. S - A - L - E - S - M - A - N.'],
                        ['id' => '11A', 'number' => '11 Across', 'question' => 'What is 11 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 11 across', 'target_word' => 'PILOT', 'letters' => ['P', 'I', 'L', 'O', 'T'], 'answer_preview' => '11 across is pilot. P - I - L - O - T.'],
                        ['id' => '12A', 'number' => '12 Across', 'question' => 'What is 12 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 12 across', 'target_word' => 'BARBER', 'letters' => ['B', 'A', 'R', 'B', 'E', 'R'], 'answer_preview' => '12 across is barber. B - A - R - B - E - R.'],
                        ['id' => '13A', 'number' => '13 Across', 'question' => 'What is 13 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 13 across', 'target_word' => 'TRAFFIC WARDEN', 'letters' => ['T', 'R', 'A', 'F', 'F', 'I', 'C', ' ', 'W', 'A', 'R', 'D', 'E', 'N'], 'answer_preview' => '13 across is traffic warden. T - R - A - F - F - I - C   W - A - R - D - E - N.'],
                        ['id' => '14D', 'number' => '14 Down', 'question' => 'What is 14 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 14 down', 'target_word' => 'ARCHITECT', 'letters' => ['A', 'R', 'C', 'H', 'I', 'T', 'E', 'C', 'T'], 'answer_preview' => '14 down is architect. A - R - C - H - I - T - E - C - T.'],
                        ['id' => '15D', 'number' => '15 Down', 'question' => 'What is 15 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 15 down', 'target_word' => 'DUSTMAN', 'letters' => ['D', 'U', 'S', 'T', 'M', 'A', 'N'], 'answer_preview' => '15 down is dustman. D - U - S - T - M - A - N.'],
                        ['id' => '16D', 'number' => '16 Down', 'question' => 'What is 16 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 16 down', 'target_word' => 'NURSE', 'letters' => ['N', 'U', 'R', 'S', 'E'], 'answer_preview' => '16 down is nurse. N - U - R - S - E.'],
                        ['id' => '19A', 'number' => '19 Across', 'question' => 'What is 19 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group B untuk mengisi kotak kosong no. 19 across', 'target_word' => 'MINER', 'letters' => ['M', 'I', 'N', 'E', 'R'], 'answer_preview' => '19 across is miner. M - I - N - E - R.'],
                    ],
                    'group_b_missing' => [
                        ['id' => '4A', 'number' => '4 Across', 'question' => 'What is 4 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 4 across', 'target_word' => 'ACTOR', 'letters' => ['A', 'C', 'T', 'O', 'R'], 'answer_preview' => '4 across is actor. A - C - T - O - R.'],
                        ['id' => '20A', 'number' => '20 Across', 'question' => 'What is 20 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 20 across', 'target_word' => 'CARPENTER', 'letters' => ['C', 'A', 'R', 'P', 'E', 'N', 'T', 'E', 'R'], 'answer_preview' => '20 across is carpenter. C - A - R - P - E - N - T - E - R.'],
                        ['id' => '18A', 'number' => '18 Across', 'question' => 'What is 18 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 18 across', 'target_word' => 'DENTIST', 'letters' => ['D', 'E', 'N', 'T', 'I', 'S', 'T'], 'answer_preview' => '18 across is dentist. D - E - N - T - I - S - T.'],
                        ['id' => '1D', 'number' => '1 Down', 'question' => 'What is 1 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 1 down', 'target_word' => 'HAIRDRESSER', 'letters' => ['H', 'A', 'I', 'R', 'D', 'R', 'E', 'S', 'S', 'E', 'R'], 'answer_preview' => '1 down is hairdresser. H - A - I - R - D - R - E - S - S - E - R.'],
                        ['id' => '6A', 'number' => '6 Across', 'question' => 'What is 6 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 6 across', 'target_word' => 'VET', 'letters' => ['V', 'E', 'T'], 'answer_preview' => '6 across is vet. V - E - T.'],
                        ['id' => '7D', 'number' => '7 Down', 'question' => 'What is 7 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 7 down', 'target_word' => 'BAKER', 'letters' => ['B', 'A', 'K', 'E', 'R'], 'answer_preview' => '7 down is baker. B - A - K - E - R.'],
                        ['id' => '12D', 'number' => '12 Down', 'question' => 'What is 12 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 12 down', 'target_word' => 'CHEF', 'letters' => ['C', 'H', 'E', 'F'], 'answer_preview' => '12 down is chef. C - H - E - F.'],
                        ['id' => '17A', 'number' => '17 Across', 'question' => 'What is 17 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 17 across', 'target_word' => 'DOCTOR', 'letters' => ['D', 'O', 'C', 'T', 'O', 'R'], 'answer_preview' => '17 across is doctor. D - O - C - T - O - R.'],
                        ['id' => '10D', 'number' => '10 Down', 'question' => 'What is 10 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 10 down', 'target_word' => 'LIBRARIAN', 'letters' => ['L', 'I', 'B', 'R', 'A', 'R', 'I', 'A', 'N'], 'answer_preview' => '10 down is librarian. L - I - B - R - A - R - I - A - N.'],
                        ['id' => '8D', 'number' => '8 Down', 'question' => 'What is 8 down? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 8 down', 'target_word' => 'WAITER', 'letters' => ['W', 'A', 'I', 'T', 'E', 'R'], 'answer_preview' => '8 down is waiter. W - A - I - T - E - R.'],
                        ['id' => '21A', 'number' => '21 Across', 'question' => 'What is 21 across? How do you spell it?', 'id_q' => 'Tanyakan ke Group A untuk mengisi kotak kosong no. 21 across', 'target_word' => 'BUTCHER', 'letters' => ['B', 'U', 'T', 'C', 'H', 'E', 'R'], 'answer_preview' => '21 across is butcher. B - U - T - C - H - E - R.'],
                    ],
                    'words' => [
                        '1D' => ['id' => '1D', 'num' => 1, 'dir' => 'down', 'label' => '1 Down', 'cells' => ['0_8', '1_8', '2_8', '3_8', '4_8', '5_8', '6_8', '7_8', '8_8', '9_8', '10_8']],
                        '2D' => ['id' => '2D', 'num' => 2, 'dir' => 'down', 'label' => '2 Down', 'cells' => ['0_11', '1_11', '2_11', '3_11', '4_11', '5_11', '6_11', '7_11', '8_11']],
                        '3A' => ['id' => '3A', 'num' => 3, 'dir' => 'across', 'label' => '3 Across', 'cells' => ['1_7', '1_8', '1_9', '1_10', '1_11', '1_12']],
                        '4A' => ['id' => '4A', 'num' => 4, 'dir' => 'across', 'label' => '4 Across', 'cells' => ['3_4', '3_5', '3_6', '3_7', '3_8']],
                        '5D' => ['id' => '5D', 'num' => 5, 'dir' => 'down', 'label' => '5 Down', 'cells' => ['2_1', '3_1', '4_1', '5_1', '6_1', '7_1', '8_1', '9_1', '10_1', '11_1']],
                        '6A' => ['id' => '6A', 'num' => 6, 'dir' => 'across', 'label' => '6 Across', 'cells' => ['4_10', '4_11', '4_12']],
                        '7D' => ['id' => '7D', 'num' => 7, 'dir' => 'down', 'label' => '7 Down', 'cells' => ['5_6', '6_6', '7_6', '8_6', '9_6']],
                        '8D' => ['id' => '8D', 'num' => 8, 'dir' => 'down', 'label' => '8 Down', 'cells' => ['5_16', '6_16', '7_16', '8_16', '9_16', '10_16']],
                        '9A' => ['id' => '9A', 'num' => 9, 'dir' => 'across', 'label' => '9 Across', 'cells' => ['6_5', '6_6', '6_7', '6_8', '6_9', '6_10', '6_11', '6_12']],
                        '10D' => ['id' => '10D', 'num' => 10, 'dir' => 'down', 'label' => '10 Down', 'cells' => ['5_3', '6_3', '7_3', '8_3', '9_3', '10_3', '11_3', '12_3', '13_3']],
                        '11A' => ['id' => '11A', 'num' => 11, 'dir' => 'across', 'label' => '11 Across', 'cells' => ['7_15', '7_16', '7_17', '7_18', '7_19']],
                        '12A' => ['id' => '12A', 'num' => 12, 'dir' => 'across', 'label' => '12 Across', 'cells' => ['7_0', '7_1', '7_2', '7_3', '7_4', '7_5']],
                        '13A' => ['id' => '13A', 'num' => 13, 'dir' => 'across', 'label' => '13 Across', 'cells' => ['10_7', '10_8', '10_9', '10_10', '10_11', '10_12', '10_13', '10_14', '10_15', '10_16', '10_17', '10_18', '10_19']],
                        '14D' => ['id' => '14D', 'num' => 14, 'dir' => 'down', 'label' => '14 Down', 'cells' => ['10_9', '11_9', '12_9', '13_9', '14_9', '15_9', '16_9', '17_9', '18_9']],
                        '15D' => ['id' => '15D', 'num' => 15, 'dir' => 'down', 'label' => '15 Down', 'cells' => ['10_17', '11_17', '12_17', '13_17', '14_17', '15_17', '16_17']],
                        '16D' => ['id' => '16D', 'num' => 16, 'dir' => 'down', 'label' => '16 Down', 'cells' => ['10_19', '11_19', '12_19', '13_19', '14_19']],
                        '17A' => ['id' => '17A', 'num' => 17, 'dir' => 'across', 'label' => '17 Across', 'cells' => ['12_7', '12_8', '12_9', '12_10', '12_11', '12_12']],
                        '18A' => ['id' => '18A', 'num' => 18, 'dir' => 'across', 'label' => '18 Across', 'cells' => ['13_14', '13_15', '13_16', '13_17', '13_18', '13_19', '13_20']],
                        '19A' => ['id' => '19A', 'num' => 19, 'dir' => 'across', 'label' => '19 Across', 'cells' => ['14_8', '14_9', '14_10', '14_11', '14_12']],
                        '20A' => ['id' => '20A', 'num' => 20, 'dir' => 'across', 'label' => '20 Across', 'cells' => ['16_5', '16_6', '16_7', '16_8', '16_9', '16_10', '16_11', '16_12', '16_13']],
                        '12D' => ['id' => '12D', 'num' => 12, 'dir' => 'down', 'label' => '12 Down', 'cells' => ['16_5', '17_5', '18_5', '19_5']],
                        '21A' => ['id' => '21A', 'num' => 21, 'dir' => 'across', 'label' => '21 Across', 'cells' => ['18_7', '18_8', '18_9', '18_10', '18_11', '18_12', '18_13']],
                    ],
                    'grid_rows' => 20,
                    'grid_cols' => 21,
                    'grid_cells' => [
                        '0_11' => ['r' => 0, 'c' => 11, 'char' => 'S', 'num' => 2, 'groups' => ['B']],
                        '0_8' => ['r' => 0, 'c' => 8, 'char' => 'H', 'num' => 1, 'groups' => ['A']],
                        '10_1' => ['r' => 10, 'c' => 1, 'char' => 'S', 'num' => null, 'groups' => ['B']],
                        '10_10' => ['r' => 10, 'c' => 10, 'char' => 'F', 'num' => null, 'groups' => ['B']],
                        '10_11' => ['r' => 10, 'c' => 11, 'char' => 'F', 'num' => null, 'groups' => ['B']],
                        '10_12' => ['r' => 10, 'c' => 12, 'char' => 'I', 'num' => null, 'groups' => ['B']],
                        '10_13' => ['r' => 10, 'c' => 13, 'char' => 'C', 'num' => null, 'groups' => ['B']],
                        '10_14' => ['r' => 10, 'c' => 14, 'char' => 'W', 'num' => null, 'groups' => ['B']],
                        '10_15' => ['r' => 10, 'c' => 15, 'char' => 'A', 'num' => null, 'groups' => ['B']],
                        '10_16' => ['r' => 10, 'c' => 16, 'char' => 'R', 'num' => null, 'groups' => ['A', 'B']],
                        '10_17' => ['r' => 10, 'c' => 17, 'char' => 'D', 'num' => 15, 'groups' => ['B']],
                        '10_18' => ['r' => 10, 'c' => 18, 'char' => 'E', 'num' => null, 'groups' => ['B']],
                        '10_19' => ['r' => 10, 'c' => 19, 'char' => 'N', 'num' => 16, 'groups' => ['B']],
                        '10_3' => ['r' => 10, 'c' => 3, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '10_7' => ['r' => 10, 'c' => 7, 'char' => 'T', 'num' => 13, 'groups' => ['B']],
                        '10_8' => ['r' => 10, 'c' => 8, 'char' => 'R', 'num' => null, 'groups' => ['A', 'B']],
                        '10_9' => ['r' => 10, 'c' => 9, 'char' => 'A', 'num' => 14, 'groups' => ['B']],
                        '11_1' => ['r' => 11, 'c' => 1, 'char' => 'T', 'num' => null, 'groups' => ['B']],
                        '11_17' => ['r' => 11, 'c' => 17, 'char' => 'U', 'num' => null, 'groups' => ['B']],
                        '11_19' => ['r' => 11, 'c' => 19, 'char' => 'U', 'num' => null, 'groups' => ['B']],
                        '11_3' => ['r' => 11, 'c' => 3, 'char' => 'I', 'num' => null, 'groups' => ['A']],
                        '11_9' => ['r' => 11, 'c' => 9, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '12_10' => ['r' => 12, 'c' => 10, 'char' => 'T', 'num' => null, 'groups' => ['A']],
                        '12_11' => ['r' => 12, 'c' => 11, 'char' => 'O', 'num' => null, 'groups' => ['A']],
                        '12_12' => ['r' => 12, 'c' => 12, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '12_17' => ['r' => 12, 'c' => 17, 'char' => 'S', 'num' => null, 'groups' => ['B']],
                        '12_19' => ['r' => 12, 'c' => 19, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '12_3' => ['r' => 12, 'c' => 3, 'char' => 'A', 'num' => null, 'groups' => ['A']],
                        '12_7' => ['r' => 12, 'c' => 7, 'char' => 'D', 'num' => 17, 'groups' => ['A']],
                        '12_8' => ['r' => 12, 'c' => 8, 'char' => 'O', 'num' => null, 'groups' => ['A']],
                        '12_9' => ['r' => 12, 'c' => 9, 'char' => 'C', 'num' => null, 'groups' => ['B', 'A']],
                        '13_14' => ['r' => 13, 'c' => 14, 'char' => 'D', 'num' => 18, 'groups' => ['A']],
                        '13_15' => ['r' => 13, 'c' => 15, 'char' => 'E', 'num' => null, 'groups' => ['A']],
                        '13_16' => ['r' => 13, 'c' => 16, 'char' => 'N', 'num' => null, 'groups' => ['A']],
                        '13_17' => ['r' => 13, 'c' => 17, 'char' => 'T', 'num' => null, 'groups' => ['B', 'A']],
                        '13_18' => ['r' => 13, 'c' => 18, 'char' => 'I', 'num' => null, 'groups' => ['A']],
                        '13_19' => ['r' => 13, 'c' => 19, 'char' => 'S', 'num' => null, 'groups' => ['B', 'A']],
                        '13_20' => ['r' => 13, 'c' => 20, 'char' => 'T', 'num' => null, 'groups' => ['A']],
                        '13_3' => ['r' => 13, 'c' => 3, 'char' => 'N', 'num' => null, 'groups' => ['A']],
                        '13_9' => ['r' => 13, 'c' => 9, 'char' => 'H', 'num' => null, 'groups' => ['B']],
                        '14_10' => ['r' => 14, 'c' => 10, 'char' => 'N', 'num' => null, 'groups' => ['B']],
                        '14_11' => ['r' => 14, 'c' => 11, 'char' => 'E', 'num' => null, 'groups' => ['B']],
                        '14_12' => ['r' => 14, 'c' => 12, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '14_17' => ['r' => 14, 'c' => 17, 'char' => 'M', 'num' => null, 'groups' => ['B']],
                        '14_19' => ['r' => 14, 'c' => 19, 'char' => 'E', 'num' => null, 'groups' => ['B']],
                        '14_8' => ['r' => 14, 'c' => 8, 'char' => 'M', 'num' => 19, 'groups' => ['B']],
                        '14_9' => ['r' => 14, 'c' => 9, 'char' => 'I', 'num' => null, 'groups' => ['B']],
                        '15_17' => ['r' => 15, 'c' => 17, 'char' => 'A', 'num' => null, 'groups' => ['B']],
                        '15_9' => ['r' => 15, 'c' => 9, 'char' => 'T', 'num' => null, 'groups' => ['B']],
                        '16_10' => ['r' => 16, 'c' => 10, 'char' => 'N', 'num' => null, 'groups' => ['A']],
                        '16_11' => ['r' => 16, 'c' => 11, 'char' => 'T', 'num' => null, 'groups' => ['A']],
                        '16_12' => ['r' => 16, 'c' => 12, 'char' => 'E', 'num' => null, 'groups' => ['A']],
                        '16_13' => ['r' => 16, 'c' => 13, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '16_17' => ['r' => 16, 'c' => 17, 'char' => 'N', 'num' => null, 'groups' => ['B']],
                        '16_5' => ['r' => 16, 'c' => 5, 'char' => 'C', 'num' => 20, 'groups' => ['A']],
                        '16_6' => ['r' => 16, 'c' => 6, 'char' => 'A', 'num' => null, 'groups' => ['A']],
                        '16_7' => ['r' => 16, 'c' => 7, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '16_8' => ['r' => 16, 'c' => 8, 'char' => 'P', 'num' => null, 'groups' => ['A']],
                        '16_9' => ['r' => 16, 'c' => 9, 'char' => 'E', 'num' => null, 'groups' => ['B', 'A']],
                        '17_5' => ['r' => 17, 'c' => 5, 'char' => 'H', 'num' => null, 'groups' => ['A']],
                        '17_9' => ['r' => 17, 'c' => 9, 'char' => 'C', 'num' => null, 'groups' => ['B']],
                        '18_10' => ['r' => 18, 'c' => 10, 'char' => 'C', 'num' => null, 'groups' => ['A']],
                        '18_11' => ['r' => 18, 'c' => 11, 'char' => 'H', 'num' => null, 'groups' => ['A']],
                        '18_12' => ['r' => 18, 'c' => 12, 'char' => 'E', 'num' => null, 'groups' => ['A']],
                        '18_13' => ['r' => 18, 'c' => 13, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '18_5' => ['r' => 18, 'c' => 5, 'char' => 'E', 'num' => null, 'groups' => ['A']],
                        '18_7' => ['r' => 18, 'c' => 7, 'char' => 'B', 'num' => 21, 'groups' => ['A']],
                        '18_8' => ['r' => 18, 'c' => 8, 'char' => 'U', 'num' => null, 'groups' => ['A']],
                        '18_9' => ['r' => 18, 'c' => 9, 'char' => 'T', 'num' => null, 'groups' => ['B', 'A']],
                        '19_5' => ['r' => 19, 'c' => 5, 'char' => 'F', 'num' => null, 'groups' => ['A']],
                        '1_10' => ['r' => 1, 'c' => 10, 'char' => 'M', 'num' => null, 'groups' => ['B']],
                        '1_11' => ['r' => 1, 'c' => 11, 'char' => 'E', 'num' => null, 'groups' => ['B']],
                        '1_12' => ['r' => 1, 'c' => 12, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '1_7' => ['r' => 1, 'c' => 7, 'char' => 'F', 'num' => 3, 'groups' => ['B']],
                        '1_8' => ['r' => 1, 'c' => 8, 'char' => 'A', 'num' => null, 'groups' => ['A', 'B']],
                        '1_9' => ['r' => 1, 'c' => 9, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '2_1' => ['r' => 2, 'c' => 1, 'char' => 'J', 'num' => 5, 'groups' => ['B']],
                        '2_11' => ['r' => 2, 'c' => 11, 'char' => 'C', 'num' => null, 'groups' => ['B']],
                        '2_8' => ['r' => 2, 'c' => 8, 'char' => 'I', 'num' => null, 'groups' => ['A']],
                        '3_1' => ['r' => 3, 'c' => 1, 'char' => 'O', 'num' => null, 'groups' => ['B']],
                        '3_11' => ['r' => 3, 'c' => 11, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '3_4' => ['r' => 3, 'c' => 4, 'char' => 'A', 'num' => 4, 'groups' => ['A']],
                        '3_5' => ['r' => 3, 'c' => 5, 'char' => 'C', 'num' => null, 'groups' => ['A']],
                        '3_6' => ['r' => 3, 'c' => 6, 'char' => 'T', 'num' => null, 'groups' => ['A']],
                        '3_7' => ['r' => 3, 'c' => 7, 'char' => 'O', 'num' => null, 'groups' => ['A']],
                        '3_8' => ['r' => 3, 'c' => 8, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '4_1' => ['r' => 4, 'c' => 1, 'char' => 'U', 'num' => null, 'groups' => ['B']],
                        '4_10' => ['r' => 4, 'c' => 10, 'char' => 'V', 'num' => 6, 'groups' => ['A']],
                        '4_11' => ['r' => 4, 'c' => 11, 'char' => 'E', 'num' => null, 'groups' => ['B', 'A']],
                        '4_12' => ['r' => 4, 'c' => 12, 'char' => 'T', 'num' => null, 'groups' => ['A']],
                        '4_8' => ['r' => 4, 'c' => 8, 'char' => 'D', 'num' => null, 'groups' => ['A']],
                        '5_1' => ['r' => 5, 'c' => 1, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '5_11' => ['r' => 5, 'c' => 11, 'char' => 'T', 'num' => null, 'groups' => ['B']],
                        '5_16' => ['r' => 5, 'c' => 16, 'char' => 'W', 'num' => 8, 'groups' => ['A']],
                        '5_3' => ['r' => 5, 'c' => 3, 'char' => 'L', 'num' => 10, 'groups' => ['A']],
                        '5_6' => ['r' => 5, 'c' => 6, 'char' => 'B', 'num' => 7, 'groups' => ['A']],
                        '5_8' => ['r' => 5, 'c' => 8, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '6_1' => ['r' => 6, 'c' => 1, 'char' => 'N', 'num' => null, 'groups' => ['B']],
                        '6_10' => ['r' => 6, 'c' => 10, 'char' => 'M', 'num' => null, 'groups' => ['B']],
                        '6_11' => ['r' => 6, 'c' => 11, 'char' => 'A', 'num' => null, 'groups' => ['B']],
                        '6_12' => ['r' => 6, 'c' => 12, 'char' => 'N', 'num' => null, 'groups' => ['B']],
                        '6_16' => ['r' => 6, 'c' => 16, 'char' => 'A', 'num' => null, 'groups' => ['A']],
                        '6_3' => ['r' => 6, 'c' => 3, 'char' => 'I', 'num' => null, 'groups' => ['A']],
                        '6_5' => ['r' => 6, 'c' => 5, 'char' => 'S', 'num' => 9, 'groups' => ['B']],
                        '6_6' => ['r' => 6, 'c' => 6, 'char' => 'A', 'num' => null, 'groups' => ['A', 'B']],
                        '6_7' => ['r' => 6, 'c' => 7, 'char' => 'L', 'num' => null, 'groups' => ['B']],
                        '6_8' => ['r' => 6, 'c' => 8, 'char' => 'E', 'num' => null, 'groups' => ['A', 'B']],
                        '6_9' => ['r' => 6, 'c' => 9, 'char' => 'S', 'num' => null, 'groups' => ['B']],
                        '7_0' => ['r' => 7, 'c' => 0, 'char' => 'B', 'num' => 12, 'groups' => ['B']],
                        '7_1' => ['r' => 7, 'c' => 1, 'char' => 'A', 'num' => null, 'groups' => ['B']],
                        '7_11' => ['r' => 7, 'c' => 11, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '7_15' => ['r' => 7, 'c' => 15, 'char' => 'P', 'num' => 11, 'groups' => ['B']],
                        '7_16' => ['r' => 7, 'c' => 16, 'char' => 'I', 'num' => null, 'groups' => ['A', 'B']],
                        '7_17' => ['r' => 7, 'c' => 17, 'char' => 'L', 'num' => null, 'groups' => ['B']],
                        '7_18' => ['r' => 7, 'c' => 18, 'char' => 'O', 'num' => null, 'groups' => ['B']],
                        '7_19' => ['r' => 7, 'c' => 19, 'char' => 'T', 'num' => null, 'groups' => ['B']],
                        '7_2' => ['r' => 7, 'c' => 2, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '7_3' => ['r' => 7, 'c' => 3, 'char' => 'B', 'num' => null, 'groups' => ['A', 'B']],
                        '7_4' => ['r' => 7, 'c' => 4, 'char' => 'E', 'num' => null, 'groups' => ['B']],
                        '7_5' => ['r' => 7, 'c' => 5, 'char' => 'R', 'num' => null, 'groups' => ['B']],
                        '7_6' => ['r' => 7, 'c' => 6, 'char' => 'K', 'num' => null, 'groups' => ['A']],
                        '7_8' => ['r' => 7, 'c' => 8, 'char' => 'S', 'num' => null, 'groups' => ['A']],
                        '8_1' => ['r' => 8, 'c' => 1, 'char' => 'L', 'num' => null, 'groups' => ['B']],
                        '8_11' => ['r' => 8, 'c' => 11, 'char' => 'Y', 'num' => null, 'groups' => ['B']],
                        '8_16' => ['r' => 8, 'c' => 16, 'char' => 'T', 'num' => null, 'groups' => ['A']],
                        '8_3' => ['r' => 8, 'c' => 3, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '8_6' => ['r' => 8, 'c' => 6, 'char' => 'E', 'num' => null, 'groups' => ['A']],
                        '8_8' => ['r' => 8, 'c' => 8, 'char' => 'S', 'num' => null, 'groups' => ['A']],
                        '9_1' => ['r' => 9, 'c' => 1, 'char' => 'I', 'num' => null, 'groups' => ['B']],
                        '9_16' => ['r' => 9, 'c' => 16, 'char' => 'E', 'num' => null, 'groups' => ['A']],
                        '9_3' => ['r' => 9, 'c' => 3, 'char' => 'A', 'num' => null, 'groups' => ['A']],
                        '9_6' => ['r' => 9, 'c' => 6, 'char' => 'R', 'num' => null, 'groups' => ['A']],
                        '9_8' => ['r' => 9, 'c' => 8, 'char' => 'E', 'num' => null, 'groups' => ['A']],
                    ],
                    'cards' => [
                        // Group A cards
                        ['id' => 1, 'group' => 'A', 'number' => '4 Across', 'word' => 'ACTOR', 'badge' => 'Group A • 4 Across', 'definition' => 'A person who acts in plays, movies, or TV shows.', 'clue_prompt' => 'A person who performs in theater or films.', 'spelling' => 'A - C - T - O - R', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 2, 'group' => 'A', 'number' => '20 Across', 'word' => 'CARPENTER', 'badge' => 'Group A • 20 Across', 'definition' => 'A person who makes and repairs wooden objects and structures.', 'clue_prompt' => 'Someone who builds tables, chairs, and roofs with wood.', 'spelling' => 'C - A - R - P - E - N - T - E - R', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 3, 'group' => 'A', 'number' => '18 Across', 'word' => 'DENTIST', 'badge' => 'Group A • 18 Across', 'definition' => 'A person qualified to treat teeth and dental diseases.', 'clue_prompt' => 'A doctor who cleans and fixes your teeth.', 'spelling' => 'D - E - N - T - I - S - T', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 4, 'group' => 'A', 'number' => '1 Down', 'word' => 'HAIRDRESSER', 'badge' => 'Group A • 1 Down', 'definition' => 'A person who cuts, washes, colors, and styles hair.', 'clue_prompt' => 'Someone who styles and cuts people\'s hair in a salon.', 'spelling' => 'H - A - I - R - D - R - E - S - S - E - R', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 5, 'group' => 'A', 'number' => '6 Across', 'word' => 'VET', 'badge' => 'Group A • 6 Across', 'definition' => 'A doctor who specializes in treating sick and injured animals.', 'clue_prompt' => 'A medical doctor for pets, cats, dogs, and horses.', 'spelling' => 'V - E - T', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 6, 'group' => 'A', 'number' => '7 Down', 'word' => 'BAKER', 'badge' => 'Group A • 7 Down', 'definition' => 'A person who bakes and sells fresh bread, pastries, and cakes.', 'clue_prompt' => 'Someone who makes delicious bread in an oven.', 'spelling' => 'B - A - K - E - R', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 7, 'group' => 'A', 'number' => '12 Down', 'word' => 'CHEF', 'badge' => 'Group A • 12 Down', 'definition' => 'A professional cook in a restaurant kitchen.', 'clue_prompt' => 'A skilled master cook in a fine restaurant.', 'spelling' => 'C - H - E - F', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 8, 'group' => 'A', 'number' => '17 Across', 'word' => 'DOCTOR', 'badge' => 'Group A • 17 Across', 'definition' => 'A licensed medical professional who treats patients in a clinic.', 'clue_prompt' => 'A person in a white coat who cures sick people.', 'spelling' => 'D - O - C - T - O - R', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 9, 'group' => 'A', 'number' => '10 Down', 'word' => 'LIBRARIAN', 'badge' => 'Group A • 10 Down', 'definition' => 'A person in charge of books and resources in a library.', 'clue_prompt' => 'Someone who organizes books and helps you study quietly.', 'spelling' => 'L - I - B - R - A - R - I - A - N', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 10, 'group' => 'A', 'number' => '8 Down', 'word' => 'WAITER', 'badge' => 'Group A • 8 Down', 'definition' => 'A person who brings food and drinks to your table in a restaurant.', 'clue_prompt' => 'Someone who takes your food order and serves your meal.', 'spelling' => 'W - A - I - T - E - R', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],
                        ['id' => 11, 'group' => 'A', 'number' => '21 Across', 'word' => 'BUTCHER', 'badge' => 'Group A • 21 Across', 'definition' => 'A person who cuts, prepares, and sells meat in a butcher shop.', 'clue_prompt' => 'Someone who sells fresh beef, chicken, and steaks.', 'spelling' => 'B - U - T - C - H - E - R', 'image' => '/images/speaking/worksheet2/group_a_crossword.png'],

                        // Group B cards
                        ['id' => 12, 'group' => 'B', 'number' => '14 Down', 'word' => 'ARCHITECT', 'badge' => 'Group B • 14 Down', 'definition' => 'A person who designs buildings and blueprints.', 'clue_prompt' => 'Someone who draws plans for houses, skyscrapers, and bridges.', 'spelling' => 'A - R - C - H - I - T - E - C - T', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 13, 'group' => 'B', 'number' => '3 Across', 'word' => 'FARMER', 'badge' => 'Group B • 3 Across', 'definition' => 'A person who owns or works on a farm growing crops and animals.', 'clue_prompt' => 'Someone who works in rice fields and raises cows/crops.', 'spelling' => 'F - A - R - M - E - R', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 14, 'group' => 'B', 'number' => '19 Across', 'word' => 'MINER', 'badge' => 'Group B • 19 Across', 'definition' => 'A person who works underground digging coal, gold, and minerals.', 'clue_prompt' => 'Someone who digs deep underground in a mine.', 'spelling' => 'M - I - N - E - R', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 15, 'group' => 'B', 'number' => '11 Across', 'word' => 'PILOT', 'badge' => 'Group B • 11 Across', 'definition' => 'A person qualified to fly airplanes or helicopters.', 'clue_prompt' => 'Someone who sits in the cockpit and flies passengers across the sky.', 'spelling' => 'P - I - L - O - T', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 16, 'group' => 'B', 'number' => '2 Down', 'word' => 'SECRETARY', 'badge' => 'Group B • 2 Down', 'definition' => 'An office worker who organizes appointments, calls, and files.', 'clue_prompt' => 'Someone who assists the manager with emails, schedules, and typing.', 'spelling' => 'S - E - C - R - E - T - A - R - Y', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 17, 'group' => 'B', 'number' => '12 Across', 'word' => 'BARBER', 'badge' => 'Group B • 12 Across', 'definition' => 'A person whose job is cutting men\'s hair and shaving beards.', 'clue_prompt' => 'Someone who trims men\'s hair, mustaches, and beards.', 'spelling' => 'B - A - R - B - E - R', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 18, 'group' => 'B', 'number' => '5 Down', 'word' => 'JOURNALIST', 'badge' => 'Group B • 5 Down', 'definition' => 'A person who reports news stories for newspapers, TV, or websites.', 'clue_prompt' => 'Someone who interviews people and writes news reports.', 'spelling' => 'J - O - U - R - N - A - L - I - S - T', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 19, 'group' => 'B', 'number' => '16 Down', 'word' => 'NURSE', 'badge' => 'Group B • 16 Down', 'definition' => 'A person trained to care for patients in a hospital alongside doctors.', 'clue_prompt' => 'Someone who gives medicine and takes care of sick people in hospital beds.', 'spelling' => 'N - U - R - S - E', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 20, 'group' => 'B', 'number' => '9 Across', 'word' => 'SALESMAN', 'badge' => 'Group B • 9 Across', 'definition' => 'A person whose job is selling products and helping customers.', 'clue_prompt' => 'Someone who offers products and convinces clients to buy them.', 'spelling' => 'S - A - L - E - S - M - A - N', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 21, 'group' => 'B', 'number' => '13 Across', 'word' => 'TRAFFIC WARDEN', 'badge' => 'Group B • 13 Across', 'definition' => 'An officer who controls parking rules and directs road traffic.', 'clue_prompt' => 'Someone in uniform who checks parking tickets and stops traffic.', 'spelling' => 'T - R - A - F - F - I - C   W - A - R - D - E - N', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                        ['id' => 22, 'group' => 'B', 'number' => '15 Down', 'word' => 'DUSTMAN', 'badge' => 'Group B • 15 Down', 'definition' => 'A person employed to collect household trash and garbage bins.', 'clue_prompt' => 'Someone who rides the garbage truck and empties household bins.', 'spelling' => 'D - U - S - T - M - A - N', 'image' => '/images/speaking/worksheet2/group_b_crossword.png'],
                    ],
                ],
                'ai_interview' => [
                    [
                        'question' => "Hello! Welcome to Meeting 2: Alphabet and Occupations. Can you introduce yourself and spell your first name letter by letter?",
                        'target' => "Perkenalkan diri dan eja nama depanmu huruf demi huruf (contoh: My name is Arthur, A-R-T-H-U-R).",
                        'hint' => "Gunakan ejaan fonetik alfabet Inggris yang jelas!",
                        'sample_answer' => "Hello! My name is Arthur, that is A-R-T-H-U-R. I am very excited to join this speaking lesson today."
                    ],
                    [
                        'question' => "Wonderful! Now look at the English vowels. Can you pronounce the five vowel letters: A, E, I, O, and U?",
                        'target' => "Lafalkan 5 huruf vokal bahasa Inggris: A (eɪ), E (i), I (aɪ), O (oʊ), dan U (ju).",
                        'hint' => "Ingat: A = /eɪ/, E = /i/, I = /aɪ/, O = /oʊ/, U = /ju/.",
                        'sample_answer' => "Sure! The five vowels are A /eɪ/, E /i/, I /aɪ/, O /oʊ/, and U /ju/."
                    ],
                    [
                        'question' => "Great job! What is your current job or dream occupation, and what does someone in that job do every day?",
                        'target' => "Ceritakan pekerjaan atau profesi impianmu dan apa tugas sehari-harinya.",
                        'hint' => "Contoh: I am an architect / I want to be a pilot because I love flying.",
                        'sample_answer' => "My dream job is to be an architect. An architect designs beautiful and safe modern buildings every day."
                    ],
                    [
                        'question' => "Let's play a guessing game! I will give you a clue: 'A doctor who takes care of sick and injured animals.' What is this job, and how do you spell it?",
                        'target' => "Tebak profesi dokter hewan (VET) dan eja katanya (V-E-T).",
                        'hint' => "Jawab: That is a vet, spelled V-E-T!",
                        'sample_answer' => "That is a vet! It is spelled V-E-T. A vet cures sick pets and animals."
                    ],
                    [
                        'question' => "Excellent! Now it's your turn: please describe one job from our 22 vocabulary words without saying its name, and let me guess what it is!",
                        'target' => "Berikan 1 petunjuk profesi (misal: 'A person who cuts and sells meat') tanpa menyebutkan nama pekerjaannya.",
                        'hint' => "Gunakan pola: 'A person who works in / cuts / cooks...'",
                        'sample_answer' => "Here is my clue: It is a person who bakes and sells delicious fresh bread and cakes in a bakery. What job is it?"
                    ],
                ]
            ],
            3 => [
                'topic' => 'Telling Numbers & Dates',
                'focus' => 'Cardinal & Ordinal Numbers (0 - 45 Billion+), Calendar Months, 7 Days of the Week, Reading Years (BC/AD), Date Formats, Prepositions IN & ON',
                'materi' => [
                    'cardinal_numbers' => [
                        ['num' => '0', 'words' => 'Zero / Null / O', 'ipa' => '/ˈzɪə.rəʊ/', 'id' => 'Nol / Kosong'],
                        ['num' => '1', 'words' => 'One', 'ipa' => '/wʌn/', 'id' => 'Satu'],
                        ['num' => '2', 'words' => 'Two', 'ipa' => '/tuː/', 'id' => 'Dua'],
                        ['num' => '3', 'words' => 'Three', 'ipa' => '/θriː/', 'id' => 'Tiga'],
                        ['num' => '4', 'words' => 'Four', 'ipa' => '/fɔːr/', 'id' => 'Empat'],
                        ['num' => '5', 'words' => 'Five', 'ipa' => '/faɪv/', 'id' => 'Lima'],
                        ['num' => '6', 'words' => 'Six', 'ipa' => '/sɪks/', 'id' => 'Enam'],
                        ['num' => '7', 'words' => 'Seven', 'ipa' => '/ˈsev.ən/', 'id' => 'Tujuh'],
                        ['num' => '8', 'words' => 'Eight', 'ipa' => '/eɪt/', 'id' => 'Delapan'],
                        ['num' => '9', 'words' => 'Nine', 'ipa' => '/naɪn/', 'id' => 'Sembilan'],
                        ['num' => '10', 'words' => 'Ten', 'ipa' => '/ten/', 'id' => 'Sepuluh'],
                        ['num' => '11', 'words' => 'Eleven', 'ipa' => '/ɪˈlev.ən/', 'id' => 'Sebelas'],
                        ['num' => '12', 'words' => 'Twelve', 'ipa' => '/twelv/', 'id' => 'Dua belas'],
                        ['num' => '13', 'words' => 'Thirteen', 'ipa' => '/θɜːˈtiːn/', 'id' => 'Tiga belas'],
                        ['num' => '14', 'words' => 'Fourteen', 'ipa' => '/fɔːˈtiːn/', 'id' => 'Empat belas'],
                        ['num' => '15', 'words' => 'Fifteen', 'ipa' => '/fɪfˈtiːn/', 'id' => 'Lima belas'],
                        ['num' => '16', 'words' => 'Sixteen', 'ipa' => '/sɪkˈstiːn/', 'id' => 'Enam belas'],
                        ['num' => '17', 'words' => 'Seventeen', 'ipa' => '/ˌsev.ənˈtiːn/', 'id' => 'Tujuh belas'],
                        ['num' => '18', 'words' => 'Eighteen', 'ipa' => '/eɪˈtiːn/', 'id' => 'Delapan belas'],
                        ['num' => '19', 'words' => 'Nineteen', 'ipa' => '/ˌnaɪnˈtiːn/', 'id' => 'Sembilan belas'],
                        ['num' => '20', 'words' => 'Twenty', 'ipa' => '/ˈtwen.ti/', 'id' => 'Dua puluh'],
                        ['num' => '21', 'words' => 'Twenty-one', 'ipa' => '/ˌtwen.ti ˈwʌn/', 'id' => 'Dua puluh satu'],
                        ['num' => '22', 'words' => 'Twenty-two', 'ipa' => '/ˌtwen.ti ˈtuː/', 'id' => 'Dua puluh dua'],
                        ['num' => '24', 'words' => 'Twenty-four', 'ipa' => '/ˌtwen.ti ˈfɔːr/', 'id' => 'Dua puluh empat'],
                        ['num' => '25', 'words' => 'Twenty-five', 'ipa' => '/ˌtwen.ti ˈfaɪv/', 'id' => 'Dua puluh lima'],
                        ['num' => '30', 'words' => 'Thirty', 'ipa' => '/ˈθɜː.ti/', 'id' => 'Tiga puluh'],
                        ['num' => '40', 'words' => 'Forty', 'ipa' => '/ˈfɔː.ti/', 'id' => 'Empat puluh'],
                        ['num' => '50', 'words' => 'Fifty', 'ipa' => '/ˈfɪf.ti/', 'id' => 'Lima puluh'],
                        ['num' => '55', 'words' => 'Fifty-five', 'ipa' => '/ˌfɪf.ti ˈfaɪv/', 'id' => 'Lima puluh lima'],
                        ['num' => '60', 'words' => 'Sixty', 'ipa' => '/ˈsɪk.sti/', 'id' => 'Enam puluh'],
                        ['num' => '67', 'words' => 'Sixty-seven', 'ipa' => '/ˌsɪk.sti ˈsev.ən/', 'id' => 'Enam puluh tujuh'],
                        ['num' => '80', 'words' => 'Eighty', 'ipa' => '/ˈeɪ.ti/', 'id' => 'Delapan puluh'],
                        ['num' => '90', 'words' => 'Ninety', 'ipa' => '/ˈnaɪn.ti/', 'id' => 'Sembilan puluh'],
                        ['num' => '99', 'words' => 'Ninety-nine', 'ipa' => '/ˌnaɪn.ti ˈnaɪn/', 'id' => 'Sembilan puluh sembilan'],
                        ['num' => '100', 'words' => 'One hundred', 'ipa' => '/wʌn ˈhʌn.drəd/', 'id' => 'Seratus'],
                        ['num' => '101', 'words' => 'One hundred (and) one', 'ipa' => '/wʌn ˈhʌn.drəd wʌn/', 'id' => 'Seratus satu'],
                        ['num' => '104', 'words' => 'One hundred (and) four', 'ipa' => '/wʌn ˈhʌn.drəd fɔːr/', 'id' => 'Seratus empat'],
                        ['num' => '111', 'words' => 'One hundred (and) eleven', 'ipa' => '/wʌn ˈhʌn.drəd ɪˈlev.ən/', 'id' => 'Seratus sebelas'],
                        ['num' => '587', 'words' => 'Five hundred eighty-seven', 'ipa' => '/faɪv ˈhʌn.drəd ˌeɪ.ti ˈsev.ən/', 'id' => 'Lima ratus delapan puluh tujuh'],
                        ['num' => '893', 'words' => 'Eight hundred ninety-three', 'ipa' => '/eɪt ˈhʌn.drəd ˌnaɪn.ti ˈθriː/', 'id' => 'Delapan ratus sembilan puluh tiga'],
                        ['num' => '999', 'words' => 'Nine hundred ninety-nine', 'ipa' => '/naɪn ˈhʌn.drəd ˌnaɪn.ti ˈnaɪn/', 'id' => 'Sembilan ratus sembilan puluh sembilan'],
                        ['num' => '1,000', 'words' => 'One thousand', 'ipa' => '/wʌn ˈθaʊ.zənd/', 'id' => 'Seribu'],
                        ['num' => '1,004', 'words' => 'One thousand four', 'ipa' => '/wʌn ˈθaʊ.zənd fɔːr/', 'id' => 'Seribu empat'],
                        ['num' => '2,015', 'words' => 'Two thousand fifteen', 'ipa' => '/tuː ˈθaʊ.zənd ˌfɪfˈtiːn/', 'id' => 'Dua ribu lima belas'],
                        ['num' => '4,083', 'words' => 'Four thousand eighty-three', 'ipa' => '/fɔːr ˈθaʊ.zənd ˌeɪ.ti ˈθriː/', 'id' => 'Empat ribu delapan puluh tiga'],
                        ['num' => '8,473', 'words' => 'Eight thousand four hundred seventy-three', 'ipa' => '/eɪt ˈθaʊ.zənd fɔːr ˈhʌn.drəd ˌsev.ən.ti ˈθriː/', 'id' => 'Delapan ribu empat ratus tujuh puluh tiga'],
                        ['num' => '12,234', 'words' => 'Twelve thousand two hundred thirty-four', 'ipa' => '/twelv ˈθaʊ.zənd tuː ˈhʌn.drəd ˌθɜː.ti ˈfɔːr/', 'id' => 'Dua belas ribu dua ratus tiga puluh empat'],
                        ['num' => '65,453', 'words' => 'Sixty-five thousand four hundred fifty-three', 'ipa' => '/ˌsɪk.sti faɪv ˈθaʊ.zənd fɔːr ˈhʌn.drəd ˌfɪf.ti ˈθriː/', 'id' => 'Enam puluh lima ribu empat ratus lima puluh tiga'],
                        ['num' => '453,453', 'words' => 'Four hundred fifty-three thousand four hundred fifty-three', 'ipa' => '/fɔːr ˈhʌn.drəd ˌfɪf.ti θriː ˈθaʊ.zənd.../', 'id' => 'Empat ratus lima puluh tiga ribu empat ratus lima puluh tiga'],
                        ['num' => '939,834', 'words' => 'Nine hundred thirty-nine thousand eight hundred thirty-four', 'ipa' => '/naɪn ˈhʌn.drəd ˌθɜː.ti naɪn ˈθaʊ.zənd.../', 'id' => 'Sembilan ratus tiga puluh sembilan ribu delapan ratus tiga puluh empat'],
                        ['num' => '999,999', 'words' => 'Nine hundred ninety-nine thousand nine hundred ninety-nine', 'ipa' => '/naɪn ˈhʌn.drəd ˌnaɪn.ti naɪn ˈθaʊ.zənd.../', 'id' => 'Sembilan ratus sembilan puluh sembilan ribu sembilan ratus sembilan puluh sembilan'],
                        ['num' => '1,000,000', 'words' => 'One million', 'ipa' => '/wʌn ˈmɪl.jən/', 'id' => 'Satu juta'],
                        ['num' => '999,999,999', 'words' => 'Nine hundred ninety-nine million nine hundred ninety-nine thousand nine hundred ninety-nine', 'ipa' => '/.../', 'id' => 'Sembilan ratus sembilan puluh sembilan juta sembilan ratus sembilan puluh sembilan ribu sembilan ratus sembilan puluh sembilan'],
                        ['num' => '1,000,000,000', 'words' => 'One billion', 'ipa' => '/wʌn ˈbɪl.jən/', 'id' => 'Satu miliar'],
                        ['num' => '45,908,453,578', 'words' => 'Forty-five billion nine hundred eight million four hundred fifty-three thousand five hundred seventy-eight', 'ipa' => '/.../', 'id' => 'Empat puluh lima miliar sembilan ratus delapan juta empat ratus lima puluh tiga ribu lima ratus tujuh puluh delapan'],
                    ],
                    'ordinal_numbers' => [
                        ['num' => '1st', 'words' => 'First', 'ipa' => '/fɜːst/', 'id' => 'Pertama / Kesatu'],
                        ['num' => '2nd', 'words' => 'Second', 'ipa' => '/ˈsek.ənd/', 'id' => 'Kedua'],
                        ['num' => '3rd', 'words' => 'Third', 'ipa' => '/θɜːd/', 'id' => 'Ketiga'],
                        ['num' => '4th', 'words' => 'Fourth', 'ipa' => '/fɔːθ/', 'id' => 'Keempat'],
                        ['num' => '5th', 'words' => 'Fifth', 'ipa' => '/fɪfθ/', 'id' => 'Kelima'],
                        ['num' => '6th', 'words' => 'Sixth', 'ipa' => '/sɪksθ/', 'id' => 'Keenam'],
                        ['num' => '7th', 'words' => 'Seventh', 'ipa' => '/ˈsev.ənθ/', 'id' => 'Ketujuh'],
                        ['num' => '8th', 'words' => 'Eighth', 'ipa' => '/eɪtθ/', 'id' => 'Kedelapan'],
                        ['num' => '9th', 'words' => 'Ninth', 'ipa' => '/naɪnθ/', 'id' => 'Kesembilan'],
                        ['num' => '10th', 'words' => 'Tenth', 'ipa' => '/tenθ/', 'id' => 'Kesepuluh'],
                        ['num' => '11th', 'words' => 'Eleventh', 'ipa' => '/ɪˈlev.ənθ/', 'id' => 'Kesebelas'],
                        ['num' => '12th', 'words' => 'Twelfth', 'ipa' => '/twelfθ/', 'id' => 'Kedua belas'],
                        ['num' => '13th', 'words' => 'Thirteenth', 'ipa' => '/θɜːˈtiːnθ/', 'id' => 'Ketiga belas'],
                        ['num' => '14th', 'words' => 'Fourteenth', 'ipa' => '/fɔːˈtiːnθ/', 'id' => 'Keempat belas'],
                        ['num' => '15th', 'words' => 'Fifteenth', 'ipa' => '/fɪfˈtiːnθ/', 'id' => 'Kelima belas'],
                        ['num' => '16th', 'words' => 'Sixteenth', 'ipa' => '/sɪkˈstiːnθ/', 'id' => 'Keenam belas'],
                        ['num' => '17th', 'words' => 'Seventeenth', 'ipa' => '/ˌsev.ənˈtiːnθ/', 'id' => 'Ketujuh belas'],
                        ['num' => '18th', 'words' => 'Eighteenth', 'ipa' => '/eɪˈtiːnθ/', 'id' => 'Kedelapan belas'],
                        ['num' => '19th', 'words' => 'Nineteenth', 'ipa' => '/ˌnaɪnˈtiːnθ/', 'id' => 'Kesembilan belas'],
                        ['num' => '20th', 'words' => 'Twentieth', 'ipa' => '/ˈtwen.ti.əθ/', 'id' => 'Keduapuluh'],
                        ['num' => '21st', 'words' => 'Twenty-first', 'ipa' => '/ˌtwen.ti ˈfɜːst/', 'id' => 'Kedua puluh satu'],
                        ['num' => '22nd', 'words' => 'Twenty-second', 'ipa' => '/ˌtwen.ti ˈsek.ənd/', 'id' => 'Kedua puluh dua'],
                        ['num' => '23rd', 'words' => 'Twenty-third', 'ipa' => '/ˌtwen.ti ˈθɜːd/', 'id' => 'Kedua puluh tiga'],
                        ['num' => '24th', 'words' => 'Twenty-fourth', 'ipa' => '/ˌtwen.ti ˈfɔːθ/', 'id' => 'Kedua puluh empat'],
                        ['num' => '25th', 'words' => 'Twenty-fifth', 'ipa' => '/ˌtwen.ti ˈfɪfθ/', 'id' => 'Kedua puluh lima'],
                        ['num' => '30th', 'words' => 'Thirtieth', 'ipa' => '/ˈθɜː.ti.əθ/', 'id' => 'Ketiga puluh'],
                        ['num' => '40th', 'words' => 'Fortieth', 'ipa' => '/ˈfɔː.ti.əθ/', 'id' => 'Keempat puluh'],
                        ['num' => '50th', 'words' => 'Fiftieth', 'ipa' => '/ˈfɪf.ti.əθ/', 'id' => 'Kelima puluh'],
                        ['num' => '55th', 'words' => 'Fifty-fifth', 'ipa' => '/ˌfɪf.ti ˈfɪfθ/', 'id' => 'Kelima puluh lima'],
                        ['num' => '60th', 'words' => 'Sixtieth', 'ipa' => '/ˈsɪk.sti.əθ/', 'id' => 'Keenam puluh'],
                        ['num' => '67th', 'words' => 'Sixty-seventh', 'ipa' => '/ˌsɪk.sti ˈsev.ənθ/', 'id' => 'Keenam puluh tujuh'],
                        ['num' => '80th', 'words' => 'Eightieth', 'ipa' => '/ˈeɪ.ti.əθ/', 'id' => 'Kedelapan puluh'],
                        ['num' => '90th', 'words' => 'Ninetieth', 'ipa' => '/ˈnaɪn.ti.əθ/', 'id' => 'Kesembilan puluh'],
                        ['num' => '99th', 'words' => 'Ninety-ninth', 'ipa' => '/ˌnaɪn.ti ˈnaɪnθ/', 'id' => 'Kesembilan puluh sembilan'],
                        ['num' => '100th', 'words' => 'One hundredth', 'ipa' => '/wʌn ˈhʌn.drədθ/', 'id' => 'Keseratus'],
                        ['num' => '101st', 'words' => 'One hundred (and) first', 'ipa' => '/wʌn ˈhʌn.drəd fɜːst/', 'id' => 'Keseratus satu'],
                        ['num' => '111th', 'words' => 'One hundred (and) eleventh', 'ipa' => '/wʌn ˈhʌn.drəd ɪˈlev.ənθ/', 'id' => 'Keseratus sebelas'],
                        ['num' => '587th', 'words' => 'Five hundred eighty-seventh', 'ipa' => '/faɪv ˈhʌn.drəd ˌeɪ.ti ˈsev.ənθ/', 'id' => 'Kelima ratus delapan puluh tujuh'],
                        ['num' => '893rd', 'words' => 'Eight hundred ninety-third', 'ipa' => '/eɪt ˈhʌn.drəd ˌnaɪn.ti ˈθɜːd/', 'id' => 'Kedelapan ratus sembilan puluh tiga'],
                        ['num' => '999th', 'words' => 'Nine hundred ninety-ninth', 'ipa' => '/naɪn ˈhʌn.drəd ˌnaɪn.ti ˈnaɪnθ/', 'id' => 'Kesembilan ratus sembilan puluh sembilan'],
                        ['num' => '1,000th', 'words' => 'One thousandth', 'ipa' => '/wʌn ˈθaʊ.zəndθ/', 'id' => 'Keseribu'],
                        ['num' => '1,004th', 'words' => 'One thousand fourth', 'ipa' => '/wʌn ˈθaʊ.zənd fɔːθ/', 'id' => 'Keseribu empat'],
                        ['num' => '2,015th', 'words' => 'Two thousand fifteenth', 'ipa' => '/tuː ˈθaʊ.zənd ˌfɪfˈtiːnθ/', 'id' => 'Kedua ribu lima belas'],
                        ['num' => '4,083rd', 'words' => 'Four thousand eighty-third', 'ipa' => '/fɔːr ˈθaʊ.zənd ˌeɪ.ti ˈθɜːd/', 'id' => 'Keempat ribu delapan puluh tiga'],
                        ['num' => '1,000,000th', 'words' => 'One millionth', 'ipa' => '/wʌn ˈmɪl.jənθ/', 'id' => 'Kesatu juta'],
                    ],
                    'telling_date' => [
                        'months' => [
                            ['en' => 'January', 'id' => 'Januari', 'days' => '31 hari'],
                            ['en' => 'February', 'id' => 'Februari', 'days' => '28/29 hari'],
                            ['en' => 'March', 'id' => 'Maret', 'days' => '31 hari'],
                            ['en' => 'April', 'id' => 'April', 'days' => '30 hari'],
                            ['en' => 'May', 'id' => 'Mei', 'days' => '31 hari'],
                            ['en' => 'June', 'id' => 'Juni', 'days' => '30 hari'],
                            ['en' => 'July', 'id' => 'Juli', 'days' => '31 hari'],
                            ['en' => 'August', 'id' => 'Agustus', 'days' => '31 hari'],
                            ['en' => 'September', 'id' => 'September', 'days' => '30 hari'],
                            ['en' => 'October', 'id' => 'Oktober', 'days' => '31 hari'],
                            ['en' => 'November', 'id' => 'November', 'days' => '30 hari'],
                            ['en' => 'December', 'id' => 'Desember', 'days' => '31 hari'],
                        ],
                        'days' => [
                            ['en' => 'Sunday', 'id' => 'Minggu'],
                            ['en' => 'Monday', 'id' => 'Senin'],
                            ['en' => 'Tuesday', 'id' => 'Selasa'],
                            ['en' => 'Wednesday', 'id' => 'Rabu'],
                            ['en' => 'Thursday', 'id' => 'Kamis'],
                            ['en' => 'Friday', 'id' => 'Jumat'],
                            ['en' => 'Saturday', 'id' => 'Sabtu'],
                        ],
                        'years' => [
                            ['year' => '1999', 'read' => 'Nineteen ninety-nine', 'rule' => 'Dibagi 2 bagian: 19 (nineteen) + 99 (ninety-nine)'],
                            ['year' => '2000', 'read' => 'Two thousand', 'rule' => 'Dibaca ribuan genap'],
                            ['year' => '2001', 'read' => 'Two thousand (and) one / Twenty oh-one', 'rule' => 'Two thousand one atau Twenty oh-one'],
                            ['year' => '2015', 'read' => 'Twenty fifteen / Two thousand fifteen', 'rule' => 'Dibaca 20 (twenty) + 15 (fifteen)'],
                            ['year' => '1827', 'read' => 'Eighteen twenty-seven', 'rule' => 'Dibaca 18 (eighteen) + 27 (twenty-seven)'],
                        ],
                        'eras' => [
                            ['term' => 'BC (Before Christ)', 'id' => 'Sebelum Masehi', 'example' => '400 BC (400 Sebelum Masehi)'],
                            ['term' => 'AD (Anno Domini)', 'id' => 'Setelah Masehi (Tahun Masehi)', 'example' => '1492 AD (Tahun 1492 Masehi)'],
                        ],
                        'date_formats' => [
                            ['format' => 'British Format', 'pattern' => 'Day + Month + Year', 'example' => '29th January 1492 (The twenty-ninth of January, fourteen ninety-two)'],
                            ['format' => 'American Format', 'pattern' => 'Month + Day + Year', 'example' => 'January 29th, 1492 (January twenty-ninth, fourteen ninety-two)'],
                        ],
                        'prepositions' => [
                            ['prep' => 'IN', 'use_for' => 'Bulan & Tahun (Month, Year, Century, Seasons)', 'example' => 'in January, in 1999, in the morning, in the summer'],
                            ['prep' => 'ON', 'use_for' => 'Hari & Tanggal Spesifik (Days & Specific Dates)', 'example' => 'on Monday, on the 29th of January, on my birthday'],
                            ['prep' => 'AT', 'use_for' => 'Jam Spesifik & Waktu Tepat (Exact Clock Time & Moments)', 'example' => "at 4 o'clock, at 7:30 PM, at noon, at midnight"],
                        ],
                        'qna' => [
                            ['q' => 'When is your birthday?', 'a' => 'My birthday is in January. / It is on the 29th of January.'],
                            ['q' => 'What time does our class start?', 'a' => "Our class starts at a quarter past seven in the morning (07:15 AM)."],
                            ['q' => 'What day is today?', 'a' => 'Today is Wednesday, the 3rd of September.'],
                        ]
                    ],
                ],
                'listening' => [
                    'title' => 'Short Listening: International Conference Registration & Important Dates',
                    'audio_script' => "Coordinator: Welcome to the Global Youth Summit! What is your full name and date of birth?

Participant: Hello! My name is Maya Lin. I was born on the twenty-ninth of January, nineteen ninety-nine (29th January 1999).

Coordinator: Perfect! The conference will take place from Monday, the third of October until Friday, the seventh of October, twenty twenty-four.

Participant: Wonderful! How many participants have registered so far?

Coordinator: We have four thousand five hundred participants registered from sixty-five different countries!

Participant: That is incredible. Thank you so much for the information!",
                    'key_phrases' => [
                        'I was born on the twenty-ninth of January, nineteen ninety-nine.',
                        'The conference takes place from Monday, the third of October.',
                        'The summit runs until Friday, the seventh of October, twenty twenty-four.',
                        'We have four thousand five hundred participants registered from sixty-five countries.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the participant\'s date of birth?',
                            'options' => [
                                'On the 29th of January, 1999',
                                'On the 19th of January, 1999',
                                'On the 29th of June, 1999',
                                'On the 15th of October, 2024',
                            ],
                            'answer' => 'On the 29th of January, 1999',
                        ],
                        [
                            'q' => 'On what day does the conference start?',
                            'options' => [
                                'On Monday, the 3rd of October',
                                'On Friday, the 7th of October',
                                'On Wednesday, the 5th of October',
                                'On Sunday, the 2nd of October',
                            ],
                            'answer' => 'On Monday, the 3rd of October',
                        ],
                        [
                            'q' => 'In what year does the summit take place?',
                            'options' => [
                                'In twenty twenty-four (2024)',
                                'In nineteen ninety-nine (1999)',
                                'In twenty twenty-five (2025)',
                                'In twenty twenty-two (2022)',
                            ],
                            'answer' => 'In twenty twenty-four (2024)',
                        ],
                        [
                            'q' => 'How many participants have registered from how many countries?',
                            'options' => [
                                '4,500 participants from 65 countries',
                                '4,000 participants from 55 countries',
                                '5,500 participants from 60 countries',
                                '3,500 participants from 75 countries',
                            ],
                            'answer' => '4,500 participants from 65 countries',
                        ],
                    ],
                ],
                'drilling1_title' => 'Drilling 1: Cardinal & Ordinal Numbers',
                'drilling1_subtitle' => 'Latihan Pengucapan Angka Nominal Besar & Peringkat',
                'drilling1_desc' => 'Latih pelafalan angka puluhan ribu, jutaan, dan angka urutan/ordinal:',
                'drilling1' => [
                    [
                        'en' => 'Over one million people attended the national festival last summer.',
                        'id' => 'Lebih dari satu juta orang menghadiri festival nasional musim panas lalu.',
                    ],
                    [
                        'en' => 'The total cost of this new project is twelve thousand two hundred dollars (,200).',
                        'id' => 'Total biaya proyek baru ini adalah dua belas ribu dua ratus dolar (,200).',
                    ],
                    [
                        'en' => 'She won first place in the international English speech competition.',
                        'id' => 'Dia memenangkan peringkat pertama dalam kompetisi pidato bahasa Inggris internasional.',
                    ],
                    [
                        'en' => 'We invited fifty-five guests to our annual family gathering.',
                        'id' => 'Kami mengundang lima puluh lima tamu ke acara kumpul keluarga tahunan kami.',
                    ],
                    [
                        'en' => 'The total population of our city is over eight hundred ninety-three thousand people.',
                        'id' => 'Total populasi kota kami lebih dari delapan ratus sembilan puluh tiga ribu orang.',
                    ],
                ],
                'drilling2_title' => 'Drilling 2: Dates, Months & Years',
                'drilling2_subtitle' => 'Latihan Pengucapan Tanggal Lahir, Hari, & Tahun',
                'drilling2_desc' => 'Latih pelafalan kalimat penanggalan, hari dalam seminggu, dan tahun sebelum masuk ke percakapan:',
                'drilling2' => [
                    [
                        'en' => 'Her birthday is on the twenty-ninth of January.',
                        'id' => 'Hari ulang tahunnya adalah pada tanggal dua puluh sembilan Januari.',
                    ],
                    [
                        'en' => 'We were born in nineteen ninety-nine (1999).',
                        'id' => 'Kami lahir pada tahun seribu sembilan ratus sembilan puluh sembilan (1999).',
                    ],
                    [
                        'en' => 'Our international conference is scheduled for Monday, the fifteenth of October.',
                        'id' => 'Konferensi internasional kami dijadwalkan untuk hari Senin, tanggal lima belas Oktober.',
                    ],
                    [
                        'en' => 'The ancient pyramid was built in four hundred BC (Before Christ).',
                        'id' => 'Piramida kuno tersebut dibangun pada tahun empat ratus Sebelum Masehi.',
                    ],
                    [
                        'en' => 'The new university semester always begins in September.',
                        'id' => 'Semester baru universitas selalu dimulai pada bulan September.',
                    ],
                ],
                'grammar_note' => 'Prepositions of Date: IN (Month / Year / Season), ON (Specific Day / Date / Birthday)',
                'dialogue_setting' => 'Dua siswa berlatih menanyakan dan menyebutkan tanggal lahir, hari perayaan, tahun kelahiran, dan jumlah angka/harga.',
                'dialogue' => [
                    // Ronde 1: Student A menanyakan, Student B menjawab
                    [
                        'section_badge' => 'Ronde 1: Student A Bertanya, Student B Menjawab',
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menanyakan Tanggal & Hari)',
                        'id' => 'Permisi, kapan tanggal ulang tahunmu dan pada hari apa kamu merayakannya?',
                        'en' => 'Excuse me, when is your birthday and on what day do you usually celebrate it?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menjawab Tanggal & Hari)',
                        'id' => 'Ulang tahun saya pada tanggal [29th of January]. Saya biasanya merayakannya pada hari [Saturday].',
                        'en' => 'My birthday is on the [29th of January]. I usually celebrate it on [Saturday].',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menanyakan Bulan & Musim)',
                        'id' => 'Di bulan apa liburan favoritmu berlangsung setiap tahun?',
                        'en' => 'In which month does your favorite vacation take place every year?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menjawab Bulan)',
                        'id' => 'Liburan favorit saya di bulan [August] karena cuacanya sangat cerah dan hangat.',
                        'en' => 'My favorite vacation is in [August] because the weather is very sunny and warm.',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menanyakan Angka Tamu & Biaya)',
                        'id' => 'Berapa banyak tamu yang kamu undang, dan berapa perkiraan biaya perayaan tersebut?',
                        'en' => 'How many guests did you invite, and how much is the estimated cost of the celebration?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menjawab Angka / Cardinal)',
                        'id' => 'Saya mengundang [55] teman, dan total biayanya sekitar [one million] rupiah.',
                        'en' => 'I invited [55] friends, and the total cost is around [one million] rupiah.',
                    ],
                    // Ronde 2: Student B menanyakan, Student A menjawab (Tukar Peran)
                    [
                        'section_badge' => 'Ronde 2: Tukar Peran (Student B Bertanya, Student A Menjawab)',
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menanyakan Tanggal & Tahun Lahir)',
                        'id' => 'Sekarang giliran saya bertanya. Kapan kamu lahir dan di tahun berapa?',
                        'en' => 'Now it is my turn to ask. When were you born and in what year?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menjawab Tanggal & Tahun)',
                        'id' => 'Saya lahir pada tanggal [15th of October] di tahun [nineteen ninety-nine] ([1999]).',
                        'en' => 'I was born on the [15th of October] in [nineteen ninety-nine] ([1999]).',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menanyakan Tanggal Acara Konferensi)',
                        'id' => 'Pada tanggal berapa konferensi pemuda internasional akan diselenggarakan?',
                        'en' => 'On what date will the international youth summit be held?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menjawab Tanggal & Hari Acara)',
                        'id' => 'Konferensi dimulai pada hari [Monday, the 3rd of October] hingga [Friday, the 7th of October, 2024].',
                        'en' => 'The conference starts on [Monday, the 3rd of October] until [Friday, the 7th of October, 2024].',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menanyakan Jumlah Peserta Terdaftar)',
                        'id' => 'Berapa banyak total peserta yang mendaftar dari seluruh dunia?',
                        'en' => 'How many total participants have registered from around the world?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menjawab Angka Ribuan & Puluhan)',
                        'id' => 'Total pesertanya adalah [four thousand five hundred] ([4,500]) orang dari [sixty-five] ([65]) negara.',
                        'en' => 'The total is [four thousand five hundred] ([4,500]) participants from [sixty-five] ([65]) countries.',
                    ],
                ],
                'games' => [
                    'type' => 'how_many_kitchen',
                    'participation_type' => 'pair',
                    'title' => 'How many? (Kitchen Objects & Spider Counting Challenge)',
                    'instruction' => 'The object of the game is to find out who has the most things in the kitchen. To do this, Student A and Student B will have to ask each other how many teapots, pans, forks, knives, spoons, cups, saucers, glasses, bowls and plates there are in their kitchens and add up the total. When they have done this, they can find out who has the most spiders!',
                    'image_a' => '/images/speaking/worksheet3/picture_a_kitchen.png',
                    'image_b' => '/images/speaking/worksheet3/picture_b_kitchen.png',
                    'image_full' => '/images/speaking/worksheet3/full_kitchen_worksheet.png',
                    'exponent' => [
                        'q' => 'How many ... are there in your kitchen?',
                        'a_singular' => 'There is one [object]...',
                        'a_plural' => 'There are [number] [objects]...',
                    ],
                    'items' => [
                        ['key' => 'teapots', 'name' => 'Teapots (Teko Teh)', 'icon' => '🫖', 'count_a' => 1, 'count_b' => 1, 'note' => 'A: 1 on table | B: 1 on counter'],
                        ['key' => 'pans', 'name' => 'Pans (Panci / Wajan)', 'icon' => '🍳', 'count_a' => 2, 'count_b' => 3, 'note' => 'A: 2 in cupboard | B: 3 on counter'],
                        ['key' => 'forks', 'name' => 'Forks (Garpu)', 'icon' => '🍴', 'count_a' => 4, 'count_b' => 6, 'note' => 'A: 4 on table | B: 6 on table'],
                        ['key' => 'knives', 'name' => 'Knives (Pisau)', 'icon' => '🔪', 'count_a' => 4, 'count_b' => 18, 'note' => 'A: 4 on table | B: 18 in drawer (marked 18)'],
                        ['key' => 'spoons', 'name' => 'Spoons (Sendok)', 'icon' => '🥄', 'count_a' => 6, 'count_b' => 6, 'note' => 'A: 6 in drawer | B: 6 on table'],
                        ['key' => 'cups', 'name' => 'Cups (Cangkir)', 'icon' => '☕', 'count_a' => 10, 'count_b' => 8, 'note' => 'A: 10 on upper rack (2 rows of 5) | B: 8 on table'],
                        ['key' => 'saucers', 'name' => 'Saucers (Tatakan Cangkir)', 'icon' => '🍽️', 'count_a' => 11, 'count_b' => 6, 'note' => 'A: 11 stacked (marked 11) | B: 6 on table'],
                        ['key' => 'glasses', 'name' => 'Glasses (Gelas)', 'icon' => '🥛', 'count_a' => 13, 'count_b' => 13, 'note' => 'A: 13 in cupboard (marked 13) | B: 13 in cupboard (4+5+4)'],
                        ['key' => 'plates', 'name' => 'Plates (Piring)', 'icon' => '🍽️', 'count_a' => 16, 'count_b' => 34, 'note' => 'A: 16 stacked (marked 16) | B: 20 on wall racks (8+8+4) + 14 on table (marked 14) = 34'],
                        ['key' => 'bowls', 'name' => 'Bowls (Mangkuk)', 'icon' => '🥣', 'count_a' => 4, 'count_b' => 4, 'note' => 'A: 4 on table | B: 4 on table'],
                        ['key' => 'spiders', 'name' => 'Spiders (Laba-laba)', 'icon' => '🕷️', 'count_a' => 11, 'count_b' => 11, 'note' => 'A: 11 spiders | B: 11 spiders'],
                    ],
                    'questions' => [
                        ['q' => 'How many teapots are there in your kitchen?', 'a' => 'There is one teapot on the table.', 'audio' => 'How many teapots are there in your kitchen? There is one teapot on the table.'],
                        ['q' => 'How many cups are there in your kitchen?', 'a' => 'There are ten cups on the shelf / There are eight cups on the table.', 'audio' => 'How many cups are there in your kitchen? There are ten cups on the shelf.'],
                        ['q' => 'How many knives are there in your kitchen?', 'a' => 'There are eighteen knives in the drawer.', 'audio' => 'How many knives are there in your kitchen? There are eighteen knives in the drawer.'],
                        ['q' => 'Who has the most plates in their kitchen?', 'a' => 'Kitchen B has the most plates with thirty-four plates!', 'audio' => 'Who has the most plates in their kitchen? Kitchen B has the most plates!'],
                        ['q' => 'How many spiders can you find in your kitchen?', 'a' => 'There are eleven spiders crawling around the room!', 'audio' => 'How many spiders can you find in your kitchen? There are eleven spiders crawling around the room!'],
                    ]
                ],
                'ai_interview' => [
                    [
                        'id' => 1,
                        'question' => "Hello! Welcome to Meeting 3. Let's start with your birthday: When were you born, and which month is your favorite?",
                        'hint' => "Answer: 'I was born on [Date], [Year]. My favorite month is [Month] because...'",
                    ],
                    [
                        'id' => 2,
                        'question' => "Can you tell me today's full date in English, including the day, ordinal date, month, and year?",
                        'hint' => "Answer: 'Today is [Day], the [Ordinal Date] of [Month], [Year].'",
                    ],
                    [
                        'id' => 3,
                        'question' => "Which preposition of time do we use for months and years versus specific days and dates? Give an example!",
                        'hint' => "Answer: 'We use 'in' for months and years, like 'in January 2024', and 'on' for specific days, like 'on Monday' or 'on my birthday'.'",
                    ],
                    [
                        'id' => 4,
                        'question' => "What is the difference between cardinal numbers and ordinal numbers in English?",
                        'hint' => "Answer: 'Cardinal numbers show quantity, like one, two, three, while ordinal numbers show order or ranking, like first, second, third.'",
                    ],
                    [
                        'id' => 5,
                        'question' => "How do you read the number 45,908,453 in English? Try saying it clearly!",
                        'hint' => "Answer: 'Forty-five million nine hundred eight thousand four hundred fifty-three.'",
                    ],
                ],
            ],
            4 => [
                'topic' => 'Telling Time & Daily Schedules',
                'focus' => 'Telling Time Masterclass (British vs American vs 24-Hour International), Clock Formulas (A quarter past/to, Half past, O\'clock, AM/PM, Sharp, Hundred), Prepositions of Time (At, From...to, Until), Daily Routines & Schedule Conversations',
                'materi' => [
                    'telling_time' => [
                        'british_rules' => [
                            ['pattern' => 'A quarter past [Hour]', 'meaning' => 'Jam [Hour] lebih 15 menit (seperempat)', 'example' => '04:15 -> A quarter past four'],
                            ['pattern' => 'A quarter to [Next Hour]', 'meaning' => 'Jam [Next Hour] kurang 15 menit (seperempat)', 'example' => '04:45 -> A quarter to five'],
                            ['pattern' => 'Half past [Hour]', 'meaning' => 'Jam setengah [Hour] (lebih 30 menit)', 'example' => '06:30 -> Half past six'],
                            ['pattern' => "[Hour] O'clock", 'meaning' => 'Jam [Hour] tepat (tanpa lebih menit)', 'example' => "07:00 -> Seven o'clock"],
                        ],
                        'american_rules' => [
                            ['term' => 'AM (Ante Meridiem)', 'meaning' => 'Pagi (12:00 tengah malam s.d. 11:59 siang)', 'example' => '07:30 AM -> Seven thirty in the morning'],
                            ['term' => 'PM (Post Meridiem)', 'meaning' => 'Siang / Malam (12:00 siang s.d. 11:59 malam)', 'example' => '07:30 PM -> Seven thirty in the evening'],
                            ['term' => 'Digital Direct Form', 'meaning' => 'Membaca jam lalu menit secara langsung', 'example' => '04:15 -> Four fifteen | 06:30 -> Six thirty'],
                        ],
                        'other_formats' => [
                            ['term' => 'Sharp (Tepat)', 'meaning' => 'Menyatakan waktu yang sangat presisi / tanpa toleransi', 'example' => 'The meeting starts at 4 sharp (Tepat jam 4).'],
                            ['term' => 'Hundred (24-Hour International)', 'meaning' => 'Format 24 jam militer / internasional', 'example' => '14:00 -> Fourteen hundred | 13:00 -> Thirteen hundred'],
                        ],
                        'prepositions' => [
                            ['prep' => 'AT', 'use_for' => 'Jam Spesifik & Waktu Tepat (Exact Clock Time & Moments)', 'example' => "at 4 o'clock, at 7:30 PM, at noon, at midnight"],
                            ['prep' => 'FROM ... TO', 'use_for' => 'Rentang Waktu Mulai s.d. Selesai', 'example' => 'from 08:00 AM to 05:00 PM'],
                            ['prep' => 'UNTIL', 'use_for' => 'Batas Waktu Berakhir', 'example' => 'until 10:00 PM'],
                            ['prep' => 'AROUND / ABOUT', 'use_for' => 'Perkiraan Jam (Sekitar / Kurang Lebih)', 'example' => 'around half past six (sekitar jam 06:30)'],
                        ],
                        'qna' => [
                            ['q' => 'What time is it now?', 'a' => "It is a quarter past four in the afternoon (04:15 PM)."],
                            ['q' => 'What time does our class start?', 'a' => "Our class starts at a quarter past eight in the morning (08:15 AM)."],
                            ['q' => 'What time do you usually wake up?', 'a' => "I usually wake up at half past six in the morning (06:30 AM)."],
                        ]
                    ],
                ],
                'listening' => [
                    'title' => 'Short Listening: Flight Reservation & Schedule Confirmation',
                    'audio_script' => "Travel Agent: Good afternoon! Global Travel Services, how can I help you today?

Customer: Hi! I would like to book a flight from Jakarta to London for tomorrow.

Travel Agent: Certainly! We have a flight departing at a quarter past eight in the morning (08:15 AM). The arrival time in London is at half past six in the evening (06:30 PM) on the same day.

Customer: That sounds perfect! What time does boarding start?

Travel Agent: Boarding starts at a quarter to eight in the morning (07:45 AM) sharp at Gate 24.

Customer: Excellent! And what time does the airport train depart?

Travel Agent: The airport train departs every thirty minutes, starting at five o'clock in the morning.

Customer: Wonderful! Please book that flight for me. Thank you!",
                    'key_phrases' => [
                        'The flight departs at a quarter past eight in the morning (08:15 AM).',
                        'The arrival time is at half past six in the evening (06:30 PM).',
                        'Boarding starts at a quarter to eight in the morning (07:45 AM) sharp.',
                        'The airport train departs every thirty minutes starting at five o\'clock.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What time does the flight depart from Jakarta?',
                            'options' => [
                                'At a quarter past eight in the morning (08:15 AM)',
                                'At half past eight in the morning (08:30 AM)',
                                'At a quarter to eight in the morning (07:45 AM)',
                                'At eight o\'clock sharp (08:00 AM)',
                            ],
                            'answer' => 'At a quarter past eight in the morning (08:15 AM)',
                        ],
                        [
                            'q' => 'What time does the flight arrive in London?',
                            'options' => [
                                'At half past six in the evening (06:30 PM)',
                                'At a quarter past six in the evening (06:15 PM)',
                                'At half past seven in the evening (07:30 PM)',
                                'At six o\'clock sharp (06:00 PM)',
                            ],
                            'answer' => 'At half past six in the evening (06:30 PM)',
                        ],
                        [
                            'q' => 'What time does boarding start at Gate 24?',
                            'options' => [
                                'At a quarter to eight in the morning (07:45 AM)',
                                'At a quarter past eight in the morning (08:15 AM)',
                                'At half past seven in the morning (07:30 AM)',
                                'At eight o\'clock sharp (08:00 AM)',
                            ],
                            'answer' => 'At a quarter to eight in the morning (07:45 AM)',
                        ],
                        [
                            'q' => 'What time does the airport train service start in the morning?',
                            'options' => [
                                'At five o\'clock in the morning (05:00 AM)',
                                'At six o\'clock in the morning (06:00 AM)',
                                'At half past five in the morning (05:30 AM)',
                                'At a quarter past five in the morning (05:15 AM)',
                            ],
                            'answer' => 'At five o\'clock in the morning (05:00 AM)',
                        ],
                    ],
                ],
                'drilling1_title' => 'Drilling 1: Telling Time Masterclass (British Style)',
                'drilling1_subtitle' => 'Latihan Pengucapan Jam British (Past, To, Half, Quarter)',
                'drilling1_desc' => 'Latih pelafalan kalimat penyebutan jam dengan rumus British sebelum masuk ke percakapan:',
                'drilling1' => [
                    [
                        'en' => 'My English speaking class starts at a quarter past four in the afternoon (04:15 PM).',
                        'id' => 'Kelas speaking bahasa Inggris saya mulai jam empat lebih seperempat sore (04:15 PM).',
                    ],
                    [
                        'en' => 'The express train will arrive at half past six sharp (06:30 sharp).',
                        'id' => 'Kereta api ekspres akan tiba jam setengah tujuh tepat (06:30 sharp).',
                    ],
                    [
                        'en' => 'Did you say a quarter to five or a quarter past five?',
                        'id' => 'Apakah Anda mengatakan jam lima kurang seperempat atau jam lima lebih seperempat?',
                    ],
                    [
                        'en' => 'Our morning briefing starts at nine o\'clock sharp.',
                        'id' => 'Briefing pagi kita dimulai tepat jam sembilan.',
                    ],
                    [
                        'en' => 'It is twenty-five past ten; we must start our session right away.',
                        'id' => 'Sekarang jam sepuluh lebih dua puluh lima menit; kita harus segera memulai sesi kita.',
                    ],
                ],
                'drilling2_title' => 'Drilling 2: Schedules & 24-Hour International Time',
                'drilling2_subtitle' => 'Latihan Pengucapan Jadwal Harian, AM/PM, & Format 24 Jam',
                'drilling2_desc' => 'Latih pelafalan kalimat jadwal penerbangan, jam kerja, dan waktu presisi:',
                'drilling2' => [
                    [
                        'en' => 'I usually wake up at seven o\'clock in the morning on weekdays.',
                        'id' => 'Saya biasanya bangun jam tujuh tepat di pagi hari pada hari kerja.',
                    ],
                    [
                        'en' => 'Our flight departs at zero eight fifteen (08:15 AM) and lands at eighteen thirty (06:30 PM).',
                        'id' => 'Penerbangan kami berangkat jam 08:15 dan mendarat jam 18:30.',
                    ],
                    [
                        'en' => 'The library is open from eight thirty AM to nine o\'clock PM every day.',
                        'id' => 'Perpustakaan buka dari jam 8.30 pagi sampai jam 9 malam setiap hari.',
                    ],
                    [
                        'en' => 'Flight departure is scheduled for fourteen hundred hours (14:00).',
                        'id' => 'Keberangkatan penerbangan dijadwalkan pada jam empat belas tepat (14:00).',
                    ],
                    [
                        'en' => 'I usually go to bed around half past ten at night.',
                        'id' => 'Saya biasanya tidur sekitar jam setengah sebelas malam.',
                    ],
                ],
                'grammar_note' => 'Prepositions of Clock Time: AT (Specific Time/Hour, e.g. at 7:00 AM, at half past six, at noon, at midnight)',
                'dialogue_setting' => 'Dua siswa berlatih menanyakan jam saat ini, jadwal kegiatan harian, waktu penerbangan, dan jam mulai/selesai kelas.',
                'dialogue' => [
                    // Ronde 1: Student A menanyakan, Student B menjawab
                    [
                        'section_badge' => 'Ronde 1: Student A Bertanya, Student B Menjawab',
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menanyakan Jam Saat Ini)',
                        'id' => 'Permisi, jam berapa sekarang? Jam tangan saya mati.',
                        'en' => 'Excuse me, what time is it right now? My watch has stopped.',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menjawab Jam British)',
                        'id' => 'Sekarang jam [a quarter past four] sore ([04:15 PM]). Kita masih punya banyak waktu.',
                        'en' => 'It is [a quarter past four] in the afternoon ([04:15 PM]). We still have plenty of time.',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menanyakan Jam Mulai Acara)',
                        'id' => 'Jam berapa pesta dan pertemuan kita akan dimulai malam ini?',
                        'en' => 'What time will our party and gathering start tonight?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menjawab Jam Tepat / Sharp)',
                        'id' => 'Acara dimulai jam [half past six] malam ([06:30 PM] sharp). Jangan sampai terlambat ya!',
                        'en' => 'The event starts at [half past six] in the evening ([06:30 PM] sharp). Please do not be late!',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menanyakan Jam Bangun Tidur)',
                        'id' => 'Jam berapa kamu biasanya bangun tidur di pagi hari pada hari kerja?',
                        'en' => 'What time do you usually wake up in the morning on weekdays?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menjawab Jam Pagi AM)',
                        'id' => 'Saya biasanya bangun jam [half past five in the morning] ([05:30 AM]) untuk berolahraga.',
                        'en' => 'I usually wake up at [half past five in the morning] ([05:30 AM]) to exercise.',
                    ],
                    // Ronde 2: Student B menanyakan, Student A menjawab (Tukar Peran)
                    [
                        'section_badge' => 'Ronde 2: Tukar Peran (Student B Bertanya, Student A Menjawab)',
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menanyakan Jam Tidur Malam)',
                        'id' => 'Sekarang giliran saya bertanya. Jam berapa kamu biasanya pergi tidur di malam hari?',
                        'en' => 'Now it is my turn to ask. What time do you usually go to bed at night?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menjawab Jam Malam PM)',
                        'id' => 'Saya biasanya tidur sekitar jam [eleven o\'clock at night] ([11:00 PM]).',
                        'en' => 'I usually go to bed around [eleven o\'clock at night] ([11:00 PM]).',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menanyakan Jadwal Penerbangan)',
                        'id' => 'Jam berapa penerbangan kita berangkat besok pagi, dan jam berapa tiba di London?',
                        'en' => 'What time does our flight depart tomorrow morning, and what time does it arrive in London?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menjawab Jam Keberangkatan & Kedatangan)',
                        'id' => 'Penerbangan berangkat jam [a quarter past eight] pagi ([08:15 AM]) dan tiba jam [half past six] sore ([06:30 PM]).',
                        'en' => 'The flight departs at [a quarter past eight] in the morning ([08:15 AM]) and arrives at [half past six] in the evening ([06:30 PM]).',
                    ],
                    [
                        'speaker' => 'Student B',
                        'role_label' => 'Siswa B (Menanyakan Jam Boarding Pesawat)',
                        'id' => 'Jam berapa proses boarding penumpang akan dimulai di Gate 24?',
                        'en' => 'What time will passenger boarding start at Gate 24?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'role_label' => 'Siswa A (Menjawab Jam Kurang Seperempat)',
                        'id' => 'Boarding dimulai jam [a quarter to eight in the morning] ([07:45 AM] sharp).',
                        'en' => 'Boarding starts at [a quarter to eight in the morning] ([07:45 AM] sharp).',
                    ],
                ],
                'games' => [
                    'type' => 'tourist_in_town',
                    'participation_type' => 'group',
                    'title' => 'Worksheet 4 Game • Wandering Tourists (Asking for Tourist Information)',
                    'activity' => 'Whole class simulation',
                    'aim' => 'To practice asking for and giving directions, opening times, hotel room rates, currency exchange, and train times/fares in English.',
                    'function_practised' => 'Asking for tourist information',
                    'lexical_areas' => 'Directions, public buildings, transport, banks (currency), hotels',
                    'essential_vocabulary' => 'bank, station, tourist office, museum, hotel, art gallery, shopping centre, zoo, abbey, castle, aquarium, single, return, single/double room, shower, bath, times, prices, directions',
                    'exponents' => [
                        'How do I get to ...? / Excuse me, where is the ...?',
                        'Turn left / right. Go straight along ...',
                        'When / What time does the ... open / close / arrive / leave?',
                        'It opens / closes / arrives / leaves at ....',
                        'How much is a single / return ticket to ...?',
                        'Can I change ... into ... please? (e.g. francs / marks / lire / yen into pounds)',
                        'Can I have / Have you got a single / double room for ... nights, please?',
                    ],
                    'teacher_guide' => [
                        'how_to_use' => 'This is an elementary simulation, designed to provide further practice in language already practised in Visiting friends (directions), Planning a day out (asking when places open and close), Getting there on time (asking for travel information), Shopping around (asking about prices) and Finding a hotel (reserving a hotel room).',
                        'student_numbers' => 'The simulation may be done with a minimum of 8 students. Four students will act as Tourist Information Officer, Railway Booking Clerk, Hotel Receptionist and Bank Clerk. If there are more than 15 or 16 students in your class, assign 2 students per desk to deal with the queues.',
                        'room_setup' => 'Clear the room of desks and chairs and set up four desks in different corners of the room to represent the Bank, Tourist Office, Railway Station and Seaview Hotel. Put students at these desks with their respective master information cards.',
                        'game_rules' => [
                            '1. Give each wandering tourist a task sheet (Sheets A through G) with their town map.',
                            '2. The object of the game is for students to carry out the instructions in the EXACT ORDER in which they appear on the sheet.',
                            '3. Students should find out from someone in the street where the hotel, bank, tourist office, and station are ON THE MAP and mark them in on the map, BEFORE going to these places.',
                            '4. At each desk, tourists practice authentic communicative exponents, record their answers, and calculate currency exchange or accommodation costs accurately.',
                        ],
                    ],
                    'time' => '20-25 Menit',
                    'map_image' => '/images/speaking/worksheet4/map_overview.png',
                    'map_landmarks' => [
                        1 => ['id' => 1, 'name' => 'Museum', 'street' => 'Museum Street / Queen Street', 'icon' => '🏛️', 'open' => '9am–5pm', 'closed' => 'Closed on Tuesdays', 'audio' => 'The Museum is building number 1 on Museum Street. It is open from 9am to 5pm, and closed on Tuesdays.'],
                        2 => ['id' => 2, 'name' => 'Shopping centre', 'street' => 'Station Road / Market Street / High Street', 'icon' => '🛍️', 'open' => '9am–5.30pm', 'closed' => 'Closed Wednesday afternoon', 'audio' => 'The Shopping centre is building number 2. Shops are open 9am to 5.30pm, closed Wednesday afternoon.'],
                        3 => ['id' => 3, 'name' => 'Art gallery', 'street' => 'London Road / West Street / Museum Street', 'icon' => '🎨', 'open' => '10am–6pm', 'closed' => 'Closed on Mondays', 'audio' => 'The Art gallery is building number 3 on London Road. It is open from 10am to 6pm, and closed on Mondays.'],
                        4 => ['id' => 4, 'name' => 'Cathedral', 'street' => 'London Road / Church Street / Queen Street', 'icon' => '⛪', 'open' => '8am–6pm', 'closed' => 'Open every day', 'audio' => 'The Cathedral is building number 4 on Church Street. It is open daily from 8am to 6pm.'],
                        5 => ['id' => 5, 'name' => 'Aquarium', 'street' => 'High Street / East Street / Marine Drive', 'icon' => '🐠', 'open' => '9am–5pm', 'closed' => 'Open every day', 'audio' => 'The Aquarium is building number 5 on High Street near Marine Drive. It is open daily from 9am to 5pm.'],
                        6 => ['id' => 6, 'name' => 'Castle', 'street' => 'Park Road / Queen Street', 'icon' => '🏰', 'open' => '10am–5pm', 'closed' => 'Open every day', 'audio' => 'The Castle is building number 6 on Park Road. It is open daily from 10am to 5pm.'],
                        7 => ['id' => 7, 'name' => 'Abbey', 'street' => 'Park Road / Abbey Road / Queen Street', 'icon' => '🕍', 'open' => '9am–6pm', 'closed' => 'Closed on Thursdays', 'audio' => 'The Abbey is building number 7 on Abbey Road. It is open from 9am to 6pm, and closed on Thursdays.'],
                        8 => ['id' => 8, 'name' => 'Zoo', 'street' => 'King Street', 'icon' => '🦁', 'open' => '10am–5.30pm', 'closed' => 'Open every day', 'audio' => 'The Zoo is building number 8 near King Street. It is open every day from 10am to 5.30pm.'],
                    ],
                    'main_buildings' => [
                        'station' => ['name' => 'Railway Station', 'street' => 'North Street / Station Road', 'icon' => '🚆', 'desc' => 'Train ticket office and departures to London, Liverpool, York, Manchester, and Bristol.', 'audio' => 'The Railway Station is located on North Street at the top of Station Road.'],
                        'tourist_office' => ['name' => 'Tourist Office', 'street' => 'High Street / East Street / King Street', 'icon' => 'ℹ️', 'desc' => 'Information desk for city sights opening times and map locations.', 'audio' => 'The Tourist Office is located on High Street at the corner of East Street.'],
                        'bank' => ['name' => 'Bank (Currency Exchange)', 'street' => 'West Street / Marine Drive', 'icon' => '🏦', 'desc' => 'Foreign exchange service into English pounds (£ sterling).', 'audio' => 'The Bank is located on West Street, opposite Marine Drive.'],
                        'hotel' => ['name' => 'Seaview Hotel', 'street' => 'Marine Drive / East Street (Waterfront)', 'icon' => '🏨', 'desc' => 'Hotel accommodation with single/double rooms, shower and bath options.', 'audio' => 'The Seaview Hotel is located on Marine Drive by the seaside at the bottom right of town.'],
                    ],
                    'desks' => [
                        'tourist_office' => [
                            'title' => 'Tourist Office',
                            'subtitle' => 'Opening Times & City Attractions',
                            'icon' => 'ℹ️',
                            'places' => [
                                ['num' => 1, 'name' => 'Museum', 'open' => '9am–5pm', 'note' => 'closed on Tuesdays', 'audio' => 'The museum is open from 9am to 5pm, closed on Tuesdays.'],
                                ['num' => 2, 'name' => 'Shopping centre', 'open' => '9am–5.30pm', 'note' => 'closed Wednesday afternoon', 'audio' => 'The shopping centre shops are open 9am to 5.30pm, closed Wednesday afternoon.'],
                                ['num' => 3, 'name' => 'Art gallery', 'open' => '10am–6pm', 'note' => 'closed on Mondays', 'audio' => 'The art gallery is open 10am to 6pm, closed on Mondays.'],
                                ['num' => 4, 'name' => 'Cathedral', 'open' => '8am–6pm', 'note' => 'open every day', 'audio' => 'The cathedral is open daily from 8am to 6pm.'],
                                ['num' => 5, 'name' => 'Aquarium', 'open' => '9am–5pm', 'note' => 'open every day', 'audio' => 'The aquarium is open daily from 9am to 5pm.'],
                                ['num' => 6, 'name' => 'Castle', 'open' => '10am–5pm', 'note' => 'open every day', 'audio' => 'The castle is open daily from 10am to 5pm.'],
                                ['num' => 7, 'name' => 'Abbey', 'open' => '9am–6pm', 'note' => 'closed on Thursdays', 'audio' => 'The abbey is open 9am to 6pm, closed on Thursdays.'],
                                ['num' => 8, 'name' => 'Zoo', 'open' => '10am–5.30pm', 'note' => 'open every day', 'audio' => 'The zoo is open every day from 10am to 5.30pm.'],
                            ],
                        ],
                        'bank' => [
                            'title' => 'Bank (Foreign Exchange Desk)',
                            'subtitle' => 'Rates of Exchange for Pounds (£ sterling)',
                            'icon' => '🏦',
                            'currencies' => [
                                ['currency' => 'French francs', 'rate' => '10.00', 'rate_desc' => '10.00 francs = £1.00', 'example' => '250 francs = £25.00', 'audio' => 'The exchange rate for French francs is 10.00 francs per pound sterling.'],
                                ['currency' => 'German marks', 'rate' => '4.50', 'rate_desc' => '4.50 marks = £1.00', 'example' => '45 marks = £10.00', 'audio' => 'The exchange rate for German marks is 4.50 marks per pound sterling.'],
                                ['currency' => 'Italian lire', 'rate' => '2,300', 'rate_desc' => '2,300 lire = £1.00', 'example' => '23,000 lire = £10.00', 'audio' => 'The exchange rate for Italian lire is 2,300 lire per pound sterling.'],
                                ['currency' => 'Spanish pesetas', 'rate' => '200', 'rate_desc' => '200 pesetas = £1.00', 'example' => '2,000 pesetas = £10.00', 'audio' => 'The exchange rate for Spanish pesetas is 200 pesetas per pound sterling.'],
                                ['currency' => 'US dollars', 'rate' => '1.50', 'rate_desc' => '$1.50 = £1.00', 'example' => '$15.00 = £10.00', 'audio' => 'The exchange rate for US dollars is 1.50 dollars per pound sterling.'],
                                ['currency' => 'Japanese yen', 'rate' => '400', 'rate_desc' => '400 yen = £1.00', 'example' => '4,000 yen = £10.00', 'audio' => 'The exchange rate for Japanese yen is 400 yen per pound sterling.'],
                            ],
                        ],
                        'hotel' => [
                            'title' => 'Seaview Hotel',
                            'subtitle' => 'Room Price List & Booking',
                            'icon' => '🏨',
                            'rooms' => [
                                ['type' => 'Single room', 'feature' => 'Standard', 'price' => '£12', 'price_num' => 12, 'audio' => 'A single room is £12 per night.'],
                                ['type' => 'Single room', 'feature' => 'With shower', 'price' => '£14', 'price_num' => 14, 'audio' => 'A single room with shower is £14 per night.'],
                                ['type' => 'Single room', 'feature' => 'With bath', 'price' => '£15', 'price_num' => 15, 'audio' => 'A single room with bath is £15 per night.'],
                                ['type' => 'Double room', 'feature' => 'Standard', 'price' => '£20', 'price_num' => 20, 'audio' => 'A double room is £20 per night.'],
                                ['type' => 'Double room', 'feature' => 'With shower', 'price' => '£22', 'price_num' => 22, 'audio' => 'A double room with shower is £22 per night.'],
                                ['type' => 'Double room', 'feature' => 'With bath', 'price' => '£25', 'price_num' => 25, 'audio' => 'A double room with bath is £25 per night.'],
                            ],
                        ],
                        'station' => [
                            'title' => 'Railway Station',
                            'subtitle' => 'Train Timetable & Fares',
                            'icon' => '🚆',
                            'trains' => [
                                [
                                    'dest' => 'London',
                                    'dep' => ['9.00', '14.30', '17.15', '18.40'],
                                    'single' => '£12',
                                    'return' => '£20',
                                    'audio' => 'Trains to London depart at 9.00, 14.30, 17.15, and 18.40. A single ticket is £12 and a return is £20.',
                                ],
                                [
                                    'dest' => 'Liverpool',
                                    'dep' => ['6.00', '15.35', '19.50', '21.17'],
                                    'single' => '£20',
                                    'return' => '£35',
                                    'audio' => 'Trains to Liverpool depart at 6.00, 15.35, 19.50, and 21.17. A single ticket is £20 and a return is £35.',
                                ],
                                [
                                    'dest' => 'York',
                                    'dep' => ['10.00', '13.25', '15.30', '20.45'],
                                    'single' => '£17',
                                    'return' => '£30',
                                    'audio' => 'Trains to York depart at 10.00, 13.25, 15.30, and 20.45. A single ticket is £17 and a return is £30.',
                                ],
                                [
                                    'dest' => 'Manchester',
                                    'dep' => ['10.05', '12.45', '15.27', '18.55'],
                                    'single' => '£15',
                                    'return' => '£25',
                                    'audio' => 'Trains to Manchester depart at 10.05, 12.45, 15.27, and 18.55. A single ticket is £15 and a return is £25.',
                                ],
                                [
                                    'dest' => 'Bristol',
                                    'dep' => ['11.00', '16.40', '22.10', '23.57'],
                                    'single' => '£7',
                                    'return' => '£12',
                                    'audio' => 'Trains to Bristol depart at 11.00, 16.40, 22.10, and 23.57. A single ticket is £7 and a return is £12.',
                                ],
                            ],
                        ],
                    ],
                    'student_sheets' => [
                        'sheet_a' => [
                            'id' => 'sheet_a',
                            'title' => 'Tourist Sheet A (Route 1)',
                            'badge' => 'Tourist A',
                            'image' => '/images/speaking/worksheet4/student_sheet_a.png',
                            'start' => 'Museum Street / Marine Drive (YOU ARE HERE)',
                            'tasks' => [
                                [
                                    'step' => 1,
                                    'action' => 'Go to the Seaview Hotel. Book a single room with a shower for two nights.',
                                    'question' => 'How much does it cost?',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Good day. I\'d like to book a single room with a shower for two nights, please. How much does it cost?',
                                    'desk_reply' => 'A single room with a shower is £14 per night, so for two nights it costs £28.',
                                    'answer' => '£28 (£14 x 2 nights)',
                                    'calc' => 'Single room with shower = £14/night. 2 nights x £14 = £28.',
                                ],
                                [
                                    'step' => 2,
                                    'action' => 'Ask someone where the bank is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Excuse me, could you tell me where the bank is?',
                                    'desk_reply' => 'The bank is on West Street, just opposite Marine Drive near London Road.',
                                    'answer' => 'Mark Bank on West Street / Marine Drive',
                                    'calc' => 'Location is on West Street / Marine Drive.',
                                ],
                                [
                                    'step' => 3,
                                    'action' => 'Go to the bank. Change 250 French francs into English pounds.',
                                    'question' => 'Write down how much you get.',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Hello. Could I change 250 French francs into English pounds, please?',
                                    'desk_reply' => 'Certainly. The rate is 10.00 francs per pound, so you get £25.',
                                    'answer' => '£25 (250 / 10)',
                                    'calc' => '250 francs ÷ 10.00 = £25.00.',
                                ],
                                [
                                    'step' => 4,
                                    'action' => 'Ask someone where the station is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Station',
                                    'inquiry' => 'Excuse me, where is the railway station?',
                                    'desk_reply' => 'Go straight up Station Road to North Street. The station is right at the top of Station Road.',
                                    'answer' => 'Mark Station at top of Station Road / North Street',
                                    'calc' => 'Station is located on North Street / Station Road.',
                                ],
                                [
                                    'step' => 5,
                                    'action' => 'Go to the station. Find the time of the first train to Liverpool in the morning.',
                                    'question' => 'Write the time down here & How much is a return ticket?',
                                    'target_place' => 'Station',
                                    'inquiry' => 'What time is the first train to Liverpool in the morning, and how much is a return ticket?',
                                    'desk_reply' => 'The first train to Liverpool departs at 6.00 in the morning. A return ticket is £35.',
                                    'answer' => 'Time: 6.00 | Return ticket: £35',
                                    'calc' => 'First morning departure: 6.00. Return fare: £35 (Single is £20).',
                                ],
                                [
                                    'step' => 6,
                                    'action' => 'Ask where the tourist office is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Tourist Office',
                                    'inquiry' => 'Excuse me, where can I find the tourist office?',
                                    'desk_reply' => 'The tourist office is on High Street, on the corner of East Street.',
                                    'answer' => 'Mark Tourist Office on High Street / East Street',
                                    'calc' => 'Tourist Office is on High Street and East Street.',
                                ],
                                [
                                    'step' => 7,
                                    'action' => 'Go to the tourist office. Ask where the aquarium is (mark on map) and when it opens and closes.',
                                    'question' => 'Write the times here:',
                                    'target_place' => 'Tourist Office & Aquarium',
                                    'inquiry' => 'Excuse me, where is the aquarium and what are its opening times?',
                                    'desk_reply' => 'The aquarium is building number 5 on High Street / Marine Drive. It is open daily from 9am to 5pm.',
                                    'answer' => 'Location: 5 | Times: 9am–5pm (open every day)',
                                    'calc' => 'Aquarium is building 5. Open 9am–5pm.',
                                ],
                            ],
                        ],
                        'sheet_b' => [
                            'id' => 'sheet_b',
                            'title' => 'Tourist Sheet B (Route 2)',
                            'badge' => 'Tourist B',
                            'image' => '/images/speaking/worksheet4/student_sheet_b.png',
                            'start' => 'Museum Street / Marine Drive (YOU ARE HERE)',
                            'tasks' => [
                                [
                                    'step' => 1,
                                    'action' => 'Ask someone where the bank is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Excuse me, where is the bank please?',
                                    'desk_reply' => 'It is on West Street, just off Marine Drive.',
                                    'answer' => 'Mark Bank on West Street / Marine Drive',
                                    'calc' => 'Bank is located on West Street / Marine Drive.',
                                ],
                                [
                                    'step' => 2,
                                    'action' => 'Go to the bank. Change 23,000 lire into English pounds.',
                                    'question' => 'Write down how much you get.',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Good morning. Could I please exchange 23,000 Italian lire into pounds?',
                                    'desk_reply' => 'Sure! The exchange rate is 2,300 lire per pound, so 23,000 lire is exactly £10.',
                                    'answer' => '£10 (23,000 / 2,300)',
                                    'calc' => '23,000 lire ÷ 2,300 = £10.00.',
                                ],
                                [
                                    'step' => 3,
                                    'action' => 'Ask someone where the station is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Station',
                                    'inquiry' => 'Excuse me, which way is the railway station?',
                                    'desk_reply' => 'Head up Station Road towards North Street. You will see the station at the end of the road.',
                                    'answer' => 'Mark Station on North Street / Station Road',
                                    'calc' => 'Station is on North Street.',
                                ],
                                [
                                    'step' => 4,
                                    'action' => 'Go to the station. Ask when the first train to Bristol is.',
                                    'question' => 'Write the time here & How much is a single ticket?',
                                    'target_place' => 'Station',
                                    'inquiry' => 'What time does the first train to Bristol depart, and how much is a single ticket?',
                                    'desk_reply' => 'The first train to Bristol is at 11.00. A single ticket costs £7.',
                                    'answer' => 'Time: 11.00 | Single ticket: £7',
                                    'calc' => 'First departure: 11.00. Single ticket: £7 (Return is £12).',
                                ],
                                [
                                    'step' => 5,
                                    'action' => 'Ask someone where the Seaview Hotel is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Excuse me, could you tell me where the Seaview Hotel is?',
                                    'desk_reply' => 'The Seaview Hotel is at the far right end of Marine Drive, facing the sea.',
                                    'answer' => 'Mark Seaview Hotel on Marine Drive / East Street (bottom right)',
                                    'calc' => 'Seaview Hotel is located on Marine Drive near East Street.',
                                ],
                                [
                                    'step' => 6,
                                    'action' => 'Go to the Seaview Hotel. Book a double room for one night.',
                                    'question' => 'How much does it cost?',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Hello. I would like to book a standard double room for one night, please. How much is that?',
                                    'desk_reply' => 'A double room for one night costs £20.',
                                    'answer' => '£20 (1 night)',
                                    'calc' => 'Double room standard = £20/night.',
                                ],
                                [
                                    'step' => 7,
                                    'action' => 'Go to the tourist office. Ask where the castle is (mark on map) and when it opens and closes.',
                                    'question' => 'Write the times here:',
                                    'target_place' => 'Tourist Office & Castle',
                                    'inquiry' => 'Excuse me, where is the castle located, and what time does it open and close?',
                                    'desk_reply' => 'The castle is building number 6 on Park Road. It is open every day from 10am to 5pm.',
                                    'answer' => 'Location: 6 | Times: 10am–5pm (open every day)',
                                    'calc' => 'Castle is building 6. Open 10am–5pm.',
                                ],
                            ],
                        ],
                        'sheet_c' => [
                            'id' => 'sheet_c',
                            'title' => 'Tourist Sheet C (Route 3)',
                            'badge' => 'Tourist C',
                            'image' => '/images/speaking/worksheet4/student_sheet_c.png',
                            'start' => 'Museum Street / Marine Drive (YOU ARE HERE)',
                            'tasks' => [
                                [
                                    'step' => 1,
                                    'action' => 'Ask someone where the station is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Station',
                                    'inquiry' => 'Excuse me, could you direct me to the railway station?',
                                    'desk_reply' => 'Walk along West Street, turn left up Station Road. The station is on North Street.',
                                    'answer' => 'Mark Station on North Street / Station Road',
                                    'calc' => 'Station is on North Street.',
                                ],
                                [
                                    'step' => 2,
                                    'action' => 'Go to the station. Ask the times of trains to York.',
                                    'question' => 'Write the times here & How much is a return ticket?',
                                    'target_place' => 'Station',
                                    'inquiry' => 'What are the times of trains to York, and how much is a return ticket?',
                                    'desk_reply' => 'Trains to York depart at 10.00, 13.25, 15.30, and 20.45. A return ticket is £30.',
                                    'answer' => 'Times: 10.00, 13.25, 15.30, 20.45 | Return ticket: £30',
                                    'calc' => 'Departures: 10.00, 13.25, 15.30, 20.45. Return fare: £30 (Single is £17).',
                                ],
                                [
                                    'step' => 3,
                                    'action' => 'Ask someone where the Seaview Hotel is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Excuse me, where is the Seaview Hotel located?',
                                    'desk_reply' => 'It is on Marine Drive, right by the beach at the bottom right corner of town.',
                                    'answer' => 'Mark Seaview Hotel on Marine Drive (bottom right)',
                                    'calc' => 'Seaview Hotel is on Marine Drive.',
                                ],
                                [
                                    'step' => 4,
                                    'action' => 'Go to the Seaview Hotel. Book a single room with shower for four nights.',
                                    'question' => 'How much does it cost?',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'I\'d like to book a single room with a shower for four nights. How much will that be?',
                                    'desk_reply' => 'A single room with shower is £14 per night, so for four nights it will cost £56.',
                                    'answer' => '£56 (£14 x 4 nights)',
                                    'calc' => 'Single room with shower = £14/night. 4 nights x £14 = £56.',
                                ],
                                [
                                    'step' => 5,
                                    'action' => 'Ask where the tourist office is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Tourist Office',
                                    'inquiry' => 'Excuse me, where is the tourist office?',
                                    'desk_reply' => 'The tourist office is on High Street near East Street.',
                                    'answer' => 'Mark Tourist Office on High Street / East Street',
                                    'calc' => 'Tourist Office is on High Street.',
                                ],
                                [
                                    'step' => 6,
                                    'action' => 'Go to the tourist office. Ask where the abbey is (mark on map) and when it opens and closes.',
                                    'question' => 'Write the times here:',
                                    'target_place' => 'Tourist Office & Abbey',
                                    'inquiry' => 'Could you tell me where the abbey is, and when it opens and closes?',
                                    'desk_reply' => 'The abbey is building number 7 on Abbey Road. It is open from 9am to 6pm, and closed on Thursdays.',
                                    'answer' => 'Location: 7 | Times: 9am–6pm, closed on Thursdays',
                                    'calc' => 'Abbey is building 7. Open 9am–6pm, closed Thursdays.',
                                ],
                                [
                                    'step' => 7,
                                    'action' => 'Go to the bank. Change 4,000 yen into English pounds.',
                                    'question' => 'How much do you get?',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Good day, I would like to exchange 4,000 Japanese yen into English pounds, please.',
                                    'desk_reply' => 'Certainly! The exchange rate is 400 yen per pound, so you get £10.',
                                    'answer' => '£10 (4,000 / 400)',
                                    'calc' => '4,000 yen ÷ 400 = £10.00.',
                                ],
                            ],
                        ],
                        'sheet_d' => [
                            'id' => 'sheet_d',
                            'title' => 'Tourist Sheet D (Route 4)',
                            'badge' => 'Tourist D',
                            'image' => '/images/speaking/worksheet4/student_sheet_d.png',
                            'start' => 'Museum Street / Marine Drive (Tourist Office already marked on High St)',
                            'tasks' => [
                                [
                                    'step' => 1,
                                    'action' => 'Ask someone where the bank is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Excuse me, where is the bank please?',
                                    'desk_reply' => 'The bank is on West Street, just opposite Marine Drive.',
                                    'answer' => 'Mark Bank on West Street / Marine Drive',
                                    'calc' => 'Bank is on West Street.',
                                ],
                                [
                                    'step' => 2,
                                    'action' => 'Go to the bank. Change 5,000 pesetas into English pounds.',
                                    'question' => 'How much do you get?',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Hello, could I change 5,000 Spanish pesetas into English pounds, please?',
                                    'desk_reply' => 'Certainly. The exchange rate is 200 pesetas per pound, so you receive £25.',
                                    'answer' => '£25 (5,000 / 200)',
                                    'calc' => '5,000 pesetas ÷ 200 = £25.00.',
                                ],
                                [
                                    'step' => 3,
                                    'action' => 'Ask someone where the station is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Station',
                                    'inquiry' => 'Excuse me, could you tell me where the railway station is?',
                                    'desk_reply' => 'Go up Station Road all the way to North Street. The station is on North Street.',
                                    'answer' => 'Mark Station on North Street / Station Road',
                                    'calc' => 'Station is located on North Street.',
                                ],
                                [
                                    'step' => 4,
                                    'action' => 'Go to the station. Find the time of the first train to London in the morning.',
                                    'question' => 'Write the time here & How much is a return ticket?',
                                    'target_place' => 'Station',
                                    'inquiry' => 'What time is the first train to London in the morning, and how much is a return ticket?',
                                    'desk_reply' => 'The first morning train to London departs at 9.00. A return ticket is £20.',
                                    'answer' => 'Time: 9.00 | Return ticket: £20',
                                    'calc' => 'First departure: 9.00. Return fare: £20 (Single is £12).',
                                ],
                                [
                                    'step' => 5,
                                    'action' => 'Go to the tourist office. Ask where the museum is (mark on map) and when it opens and closes.',
                                    'question' => 'Write the times here:',
                                    'target_place' => 'Tourist Office & Museum',
                                    'inquiry' => 'Could you tell me where the museum is and when it opens and closes?',
                                    'desk_reply' => 'The museum is building number 1 on Museum Street. It is open from 9am to 5pm, and closed on Tuesdays.',
                                    'answer' => 'Location: 1 | Times: 9am–5pm, closed on Tuesdays',
                                    'calc' => 'Museum is building 1 on Museum Street. Open 9am–5pm, closed Tuesdays.',
                                ],
                                [
                                    'step' => 6,
                                    'action' => 'Ask someone where the Seaview Hotel is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Excuse me, where is the Seaview Hotel?',
                                    'desk_reply' => 'The Seaview Hotel is on Marine Drive near East Street by the seaside.',
                                    'answer' => 'Mark Seaview Hotel on Marine Drive (bottom right)',
                                    'calc' => 'Seaview Hotel is on Marine Drive.',
                                ],
                                [
                                    'step' => 7,
                                    'action' => 'Go to the Seaview Hotel. Book a double room with a shower for three nights.',
                                    'question' => 'How much does it cost?',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'I would like to book a double room with a shower for three nights. How much does it cost?',
                                    'desk_reply' => 'A double room with shower is £22 per night, so for three nights it costs £66.',
                                    'answer' => '£66 (£22 x 3 nights)',
                                    'calc' => 'Double room with shower = £22/night. 3 nights x £22 = £66.',
                                ],
                            ],
                        ],
                        'sheet_e' => [
                            'id' => 'sheet_e',
                            'title' => 'Tourist Sheet E (Route 5)',
                            'badge' => 'Tourist E',
                            'image' => '/images/speaking/worksheet4/student_sheet_e.png',
                            'start' => 'Museum Street / Marine Drive (Bank already marked on West St)',
                            'tasks' => [
                                [
                                    'step' => 1,
                                    'action' => 'Ask someone where the station is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Station',
                                    'inquiry' => 'Excuse me, which way is the railway station?',
                                    'desk_reply' => 'Go straight up Station Road to North Street. The station is at the end of the road.',
                                    'answer' => 'Mark Station on North Street / Station Road',
                                    'calc' => 'Station is on North Street.',
                                ],
                                [
                                    'step' => 2,
                                    'action' => 'Go to the station. Find the time of the first train to York in the morning.',
                                    'question' => 'Write the time here & How much is a single ticket?',
                                    'target_place' => 'Station',
                                    'inquiry' => 'What time is the first train to York in the morning, and how much is a single ticket?',
                                    'desk_reply' => 'The first morning train to York is at 10.00. A single ticket costs £17.',
                                    'answer' => 'Time: 10.00 | Single ticket: £17',
                                    'calc' => 'First departure: 10.00. Single fare: £17 (Return is £30).',
                                ],
                                [
                                    'step' => 3,
                                    'action' => 'Ask someone where the tourist office is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Tourist Office',
                                    'inquiry' => 'Excuse me, where can I find the tourist office?',
                                    'desk_reply' => 'The tourist office is on High Street at the corner of East Street.',
                                    'answer' => 'Mark Tourist Office on High Street / East Street',
                                    'calc' => 'Tourist Office is on High Street.',
                                ],
                                [
                                    'step' => 4,
                                    'action' => 'Go to the tourist office. Ask where the shopping centre is (mark on map) and when the shops open and close.',
                                    'question' => 'Write the times here:',
                                    'target_place' => 'Tourist Office & Shopping Centre',
                                    'inquiry' => 'Could you tell me where the shopping centre is, and what time the shops open and close?',
                                    'desk_reply' => 'The shopping centre is building number 2 on Station Road. Shops open 9am to 5.30pm, closed Wednesday afternoon.',
                                    'answer' => 'Location: 2 | Times: 9am–5.30pm, closed Wednesday afternoon',
                                    'calc' => 'Shopping centre is building 2. Open 9am–5.30pm, closed Wednesday afternoon.',
                                ],
                                [
                                    'step' => 5,
                                    'action' => 'Ask someone where the Seaview Hotel is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Excuse me, where is the Seaview Hotel located?',
                                    'desk_reply' => 'It is located at the far right of Marine Drive overlooking the sea.',
                                    'answer' => 'Mark Seaview Hotel on Marine Drive (bottom right)',
                                    'calc' => 'Seaview Hotel is on Marine Drive.',
                                ],
                                [
                                    'step' => 6,
                                    'action' => 'Go to the Seaview Hotel. Book a single room with a bath for two nights.',
                                    'question' => 'How much does it cost?',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Hello, I\'d like to book a single room with a bath for two nights, please. How much is that?',
                                    'desk_reply' => 'A single room with a bath is £15 per night, so for two nights it is £30.',
                                    'answer' => '£30 (£15 x 2 nights)',
                                    'calc' => 'Single room with bath = £15/night. 2 nights x £15 = £30.',
                                ],
                                [
                                    'step' => 7,
                                    'action' => 'Go to the bank. Change £50 into German marks.',
                                    'question' => 'How much do you get?',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Good day. I would like to exchange 50 English pounds into German marks, please.',
                                    'desk_reply' => 'The exchange rate is 4.50 marks per pound, so you receive 225 German marks.',
                                    'answer' => '225 German marks (£50 x 4.50)',
                                    'calc' => '£50 x 4.50 marks = 225.00 German marks.',
                                ],
                            ],
                        ],
                        'sheet_f' => [
                            'id' => 'sheet_f',
                            'title' => 'Tourist Sheet F (Route 6)',
                            'badge' => 'Tourist F',
                            'image' => '/images/speaking/worksheet4/student_sheet_f.png',
                            'start' => 'Museum Street / Marine Drive (Seaview Hotel already marked on Marine Dr)',
                            'tasks' => [
                                [
                                    'step' => 1,
                                    'action' => 'Go to the Seaview Hotel. Book a single room for three nights.',
                                    'question' => 'How much does it cost?',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Hello, I would like to book a standard single room for three nights. How much does it cost?',
                                    'desk_reply' => 'A standard single room is £12 per night, so for three nights it costs £36.',
                                    'answer' => '£36 (£12 x 3 nights)',
                                    'calc' => 'Standard single room = £12/night. 3 nights x £12 = £36.',
                                ],
                                [
                                    'step' => 2,
                                    'action' => 'Ask someone where the bank is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Excuse me, could you tell me where the bank is?',
                                    'desk_reply' => 'The bank is on West Street, just opposite Marine Drive.',
                                    'answer' => 'Mark Bank on West Street / Marine Drive',
                                    'calc' => 'Bank is on West Street.',
                                ],
                                [
                                    'step' => 3,
                                    'action' => 'Go to the bank. Change 10,000 pesetas into English pounds.',
                                    'question' => 'How much do you get?',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Good morning. Could I exchange 10,000 Spanish pesetas into English pounds?',
                                    'desk_reply' => 'Sure! The exchange rate is 200 pesetas per pound, so you get £50.',
                                    'answer' => '£50 (10,000 / 200)',
                                    'calc' => '10,000 pesetas ÷ 200 = £50.00.',
                                ],
                                [
                                    'step' => 4,
                                    'action' => 'Ask someone where the station is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Station',
                                    'inquiry' => 'Excuse me, where is the railway station?',
                                    'desk_reply' => 'Walk straight up Station Road to North Street. The station is right at the top.',
                                    'answer' => 'Mark Station on North Street / Station Road',
                                    'calc' => 'Station is on North Street.',
                                ],
                                [
                                    'step' => 5,
                                    'action' => 'Go to the station. Ask the times of trains to Bristol.',
                                    'question' => 'Write the times here & How much is a return ticket?',
                                    'target_place' => 'Station',
                                    'inquiry' => 'What are the departure times of trains to Bristol, and how much is a return ticket?',
                                    'desk_reply' => 'Trains to Bristol leave at 11.00, 16.40, 22.10, and 23.57. A return ticket is £12.',
                                    'answer' => 'Times: 11.00, 16.40, 22.10, 23.57 | Return ticket: £12',
                                    'calc' => 'Departures: 11.00, 16.40, 22.10, 23.57. Return fare: £12 (Single is £7).',
                                ],
                                [
                                    'step' => 6,
                                    'action' => 'Ask someone where the tourist office is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Tourist Office',
                                    'inquiry' => 'Excuse me, where is the tourist office?',
                                    'desk_reply' => 'The tourist office is on High Street near East Street.',
                                    'answer' => 'Mark Tourist Office on High Street / East Street',
                                    'calc' => 'Tourist Office is on High Street.',
                                ],
                                [
                                    'step' => 7,
                                    'action' => 'Go to the tourist office. Ask where the art gallery is (mark on map) and when it opens and closes.',
                                    'question' => 'Write the times here:',
                                    'target_place' => 'Tourist Office & Art Gallery',
                                    'inquiry' => 'Could you tell me where the art gallery is located, and when it opens and closes?',
                                    'desk_reply' => 'The art gallery is building number 3 on London Road / West Street. It is open from 10am to 6pm, and closed on Mondays.',
                                    'answer' => 'Location: 3 | Times: 10am–6pm, closed on Mondays',
                                    'calc' => 'Art gallery is building 3. Open 10am–6pm, closed Mondays.',
                                ],
                            ],
                        ],
                        'sheet_g' => [
                            'id' => 'sheet_g',
                            'title' => 'Tourist Sheet G (Route 7)',
                            'badge' => 'Tourist G',
                            'image' => '/images/speaking/worksheet4/student_sheet_g.png',
                            'start' => 'Museum Street / Marine Drive (Station already marked on North St)',
                            'tasks' => [
                                [
                                    'step' => 1,
                                    'action' => 'Ask someone where the tourist office is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Tourist Office',
                                    'inquiry' => 'Excuse me, where is the tourist office?',
                                    'desk_reply' => 'The tourist office is on High Street at the corner of East Street.',
                                    'answer' => 'Mark Tourist Office on High Street / East Street',
                                    'calc' => 'Tourist Office is on High Street.',
                                ],
                                [
                                    'step' => 2,
                                    'action' => 'Go to the tourist office. Ask where the zoo is (mark on map) and when it opens and closes.',
                                    'question' => 'Write the times here:',
                                    'target_place' => 'Tourist Office & Zoo',
                                    'inquiry' => 'Could you please tell me where the zoo is and what time it opens and closes?',
                                    'desk_reply' => 'The zoo is building number 8 on King Street. It is open every day from 10am to 5.30pm.',
                                    'answer' => 'Location: 8 | Times: 10am–5.30pm (open every day)',
                                    'calc' => 'Zoo is building 8. Open daily 10am–5.30pm.',
                                ],
                                [
                                    'step' => 3,
                                    'action' => 'Ask someone where the Seaview Hotel is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Excuse me, which way is the Seaview Hotel?',
                                    'desk_reply' => 'The Seaview Hotel is on Marine Drive at the bottom right corner of town.',
                                    'answer' => 'Mark Seaview Hotel on Marine Drive (bottom right)',
                                    'calc' => 'Seaview Hotel is on Marine Drive.',
                                ],
                                [
                                    'step' => 4,
                                    'action' => 'Go to the Seaview Hotel. Book a double room with a bath for two nights.',
                                    'question' => 'How much does it cost?',
                                    'target_place' => 'Seaview Hotel',
                                    'inquiry' => 'Hello, I would like to book a double room with a bath for two nights. How much does it cost?',
                                    'desk_reply' => 'A double room with a bath is £25 per night, so for two nights it will cost £50.',
                                    'answer' => '£50 (£25 x 2 nights)',
                                    'calc' => 'Double room with bath = £25/night. 2 nights x £25 = £50.',
                                ],
                                [
                                    'step' => 5,
                                    'action' => 'Ask someone where the bank is.',
                                    'question' => 'Mark it on your map.',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Excuse me, where is the bank located?',
                                    'desk_reply' => 'The bank is on West Street, opposite Marine Drive.',
                                    'answer' => 'Mark Bank on West Street / Marine Drive',
                                    'calc' => 'Bank is on West Street.',
                                ],
                                [
                                    'step' => 6,
                                    'action' => 'Go to the bank. Change 50 dollars into pounds.',
                                    'question' => 'How much do you get?',
                                    'target_place' => 'Bank',
                                    'inquiry' => 'Good day, I\'d like to change 50 US dollars into English pounds, please.',
                                    'desk_reply' => 'The exchange rate is $1.50 per pound, so 50 dollars is £33.33.',
                                    'answer' => '£33.33 ($50 / 1.50)',
                                    'calc' => '50 dollars ÷ 1.50 = £33.33.',
                                ],
                                [
                                    'step' => 7,
                                    'action' => 'Go to the station. Ask the times of trains to Manchester.',
                                    'question' => 'Write the times here & How much is a return ticket?',
                                    'target_place' => 'Station',
                                    'inquiry' => 'What are the departure times of trains to Manchester, and how much is a return ticket?',
                                    'desk_reply' => 'Trains to Manchester leave at 10.05, 12.45, 15.27, and 18.55. A return ticket is £25.',
                                    'answer' => 'Times: 10.05, 12.45, 15.27, 18.55 | Return ticket: £25',
                                    'calc' => 'Departures: 10.05, 12.45, 15.27, 18.55. Return fare: £25 (Single is £15).',
                                ],
                            ],
                        ],
                    ],
                ],
                'ai_interview' => [
                    [
                        'id' => 1,
                        'question' => "Hello! Welcome to Meeting 4 on Telling Time. Let's start with your daily routine: What time do you usually wake up in the morning?",
                        'hint' => "Answer: 'I usually wake up at [Time, e.g. half past six in the morning / 06:30 AM].'",
                    ],
                    [
                        'id' => 2,
                        'question' => "What time do you usually go to bed at night, and how many hours of sleep do you get?",
                        'hint' => "Answer: 'I usually go to bed at [Time, e.g. eleven o'clock PM], so I get around [7/8] hours of sleep.'",
                    ],
                    [
                        'id' => 3,
                        'question' => "How do you say 04:15 and 04:45 in British English using 'past' and 'to'?",
                        'hint' => "Answer: '04:15 is 'a quarter past four', and 04:45 is 'a quarter to five'.'",
                    ],
                    [
                        'id' => 4,
                        'question' => "What does the word 'sharp' mean when someone says 'The meeting starts at 9 o'clock sharp'?",
                        'hint' => "Answer: ''Sharp' means exactly on time without any delay or tardiness.'",
                    ],
                    [
                        'id' => 5,
                        'question' => "Which preposition do we use for exact clock times, like hours and minutes? Can you make a short sentence?",
                        'hint' => "Answer: 'We use 'at' for clock time, for example: 'Our English speaking class starts at eight o'clock in the morning.''",
                    ],
                ],
            ],
            5 => [
                'topic' => 'Pronouns (Personal, Possessive & Reflexive)',
                'focus' => 'Subject & Object Pronouns, Possessive Adjectives vs Possessive Pronouns, Reflexive Pronouns, Demonstratives, Spoken Fluency Drills',
                'materi' => [
                    'pronouns_mastery' => true,
                    'overview' => 'Pronoun (Kata Ganti) adalah pilar utama kelancaran berbicara bahasa Inggris. Dengan menguasai 5 bentuk kata ganti (Subject, Object, Possessive Adjective, Possessive Pronoun, dan Reflexive), Anda dapat menyusun kalimat yang ringkas, alami, dan bebas dari pengulangan kata benda yang kaku.',
                    'matrix' => [
                        [
                            'person' => '1st Person Singular (Saya)',
                            'subject' => ['word' => 'I', 'ipa' => '/aɪ/', 'example' => 'I learn English every morning.'],
                            'object' => ['word' => 'me', 'ipa' => '/miː/', 'example' => 'Could you please call me later?'],
                            'possessive_adj' => ['word' => 'my', 'ipa' => '/maɪ/', 'example' => 'This is my favorite podcast.'],
                            'possessive_pro' => ['word' => 'mine', 'ipa' => '/maɪn/', 'example' => 'This podcast recommendation is mine.'],
                            'reflexive' => ['word' => 'myself', 'ipa' => '/maɪˈsɛlf/', 'example' => 'I introduced myself to the mentor.'],
                        ],
                        [
                            'person' => '2nd Person Singular (Kamu / Anda)',
                            'subject' => ['word' => 'You', 'ipa' => '/juː/', 'example' => 'You speak English with great confidence.'],
                            'object' => ['word' => 'you', 'ipa' => '/juː/', 'example' => 'I will gladly help you with the project.'],
                            'possessive_adj' => ['word' => 'your', 'ipa' => '/jɔːr/', 'example' => 'Is this your new passport?'],
                            'possessive_pro' => ['word' => 'yours', 'ipa' => '/jɔːrz/', 'example' => 'Is this red passport yours?'],
                            'reflexive' => ['word' => 'yourself', 'ipa' => '/jɔːrˈsɛlf/', 'example' => 'Please believe in yourself!'],
                        ],
                        [
                            'person' => '3rd Person Singular Male (Dia - Laki-laki)',
                            'subject' => ['word' => 'He', 'ipa' => '/hiː/', 'example' => 'He works as a software engineer.'],
                            'object' => ['word' => 'him', 'ipa' => '/hɪm/', 'example' => 'We saw him at the conference yesterday.'],
                            'possessive_adj' => ['word' => 'his', 'ipa' => '/hɪz/', 'example' => 'His presentation was exceptionally clear.'],
                            'possessive_pro' => ['word' => 'his', 'ipa' => '/hɪz/', 'example' => 'That outstanding idea was his.'],
                            'reflexive' => ['word' => 'himself', 'ipa' => '/hɪmˈsɛlf/', 'example' => 'He prepared the whole report himself.'],
                        ],
                        [
                            'person' => '3rd Person Singular Female (Dia - Perempuan)',
                            'subject' => ['word' => 'She', 'ipa' => '/ʃiː/', 'example' => 'She manages international partnerships.'],
                            'object' => ['word' => 'her', 'ipa' => '/hɜːr/', 'example' => 'The director gave her a special promotion.'],
                            'possessive_adj' => ['word' => 'her', 'ipa' => '/hɜːr/', 'example' => 'Her team won the speaking competition.'],
                            'possessive_pro' => ['word' => 'hers', 'ipa' => '/hɜːrz/', 'example' => 'The trophy on the stage is hers.'],
                            'reflexive' => ['word' => 'herself', 'ipa' => '/hɜːrˈsɛlf/', 'example' => 'She taught herself graphic design.'],
                        ],
                        [
                            'person' => '3rd Person Singular Neutral (Benda / Hewan / Hal)',
                            'subject' => ['word' => 'It', 'ipa' => '/ɪt/', 'example' => 'It starts at eight o\'clock sharp.'],
                            'object' => ['word' => 'it', 'ipa' => '/ɪt/', 'example' => 'I received it in the mail this morning.'],
                            'possessive_adj' => ['word' => 'its', 'ipa' => '/ɪts/', 'example' => 'The puppy wagged its fluffy tail.'],
                            'possessive_pro' => ['word' => 'its (rare)', 'ipa' => '/ɪts/', 'example' => 'Its usage is very rare as a standalone pronoun.'],
                            'reflexive' => ['word' => 'itself', 'ipa' => '/ɪtˈsɛlf/', 'example' => 'The smart application updates itself.'],
                        ],
                        [
                            'person' => '1st Person Plural (Kita / Kami)',
                            'subject' => ['word' => 'We', 'ipa' => '/wiː/', 'example' => 'We practice speaking English every day.'],
                            'object' => ['word' => 'us', 'ipa' => '/ʌs/', 'example' => 'The teacher invited us to join the webinar.'],
                            'possessive_adj' => ['word' => 'our', 'ipa' => '/ˈaʊ.ər/', 'example' => 'Our study group meets every Tuesday.'],
                            'possessive_pro' => ['word' => 'ours', 'ipa' => '/ˈaʊ.ərz/', 'example' => 'The highest test score is ours.'],
                            'reflexive' => ['word' => 'ourselves', 'ipa' => '/aʊərˈsɛlvz/', 'example' => 'We really enjoyed ourselves at the gala.'],
                        ],
                        [
                            'person' => '2nd Person Plural (Kalian semua)',
                            'subject' => ['word' => 'You (all)', 'ipa' => '/juː/', 'example' => 'You all did a wonderful job today!'],
                            'object' => ['word' => 'you', 'ipa' => '/juː/', 'example' => 'I am very proud of all of you.'],
                            'possessive_adj' => ['word' => 'your', 'ipa' => '/jɔːr/', 'example' => 'Where are your group presentation slides?'],
                            'possessive_pro' => ['word' => 'yours', 'ipa' => '/jɔːrz/', 'example' => 'The decision to proceed is yours.'],
                            'reflexive' => ['word' => 'yourselves', 'ipa' => '/jɔːrˈsɛlvz/', 'example' => 'Please make yourselves comfortable!'],
                        ],
                        [
                            'person' => '3rd Person Plural (Mereka)',
                            'subject' => ['word' => 'They', 'ipa' => '/ðeɪ/', 'example' => 'They arrived at the airport on time.'],
                            'object' => ['word' => 'them', 'ipa' => '/ðɛm/', 'example' => 'We welcomed them with traditional flowers.'],
                            'possessive_adj' => ['word' => 'their', 'ipa' => '/ðɛər/', 'example' => 'Their flight was smooth and pleasant.'],
                            'possessive_pro' => ['word' => 'theirs', 'ipa' => '/ðɛərz/', 'example' => 'Our car is blue, but theirs is silver.'],
                            'reflexive' => ['word' => 'themselves', 'ipa' => '/ðəmˈsɛlvz/', 'example' => 'They organized the whole charity themselves.'],
                        ],
                    ],
                    'categories' => [
                        [
                            'id' => 'subject',
                            'badge' => 'Category 1',
                            'color' => 'indigo',
                            'title' => 'Subject Pronouns (Pelaku Tindakan)',
                            'tagline' => 'Berada di awal klausa / sebelum Kata Kerja (Verb)',
                            'formula' => '[ Subject Pronoun + Verb + Object / Complement ]',
                            'explanation' => 'Subject Pronouns bertindak sebagai PELAKU yang melakukan aksi dalam kalimat. Selalu ditempatkan sebelum kata kerja utama.',
                            'items' => ['I', 'You', 'He', 'She', 'It', 'We', 'They'],
                            'examples' => [
                                ['en' => 'She loves practicing conversational English.', 'id' => 'Dia suka berlatih percakapan bahasa Inggris.'],
                                ['en' => 'They always arrive before the lecture starts.', 'id' => 'Mereka selalu datang sebelum kuliah dimulai.'],
                                ['en' => 'He works at an international technology firm.', 'id' => 'Dia bekerja di perusahaan teknologi internasional.'],
                            ],
                            'rule' => 'Gunakan Subject Pronoun saat Anda yang memulai atau melakukan aksi utama dalam kalimat.',
                        ],
                        [
                            'id' => 'object',
                            'badge' => 'Category 2',
                            'color' => 'emerald',
                            'title' => 'Object Pronouns (Penerima Tindakan)',
                            'tagline' => 'Berada setelah Kata Kerja (Verb) atau Preposisi (to, for, with, between)',
                            'formula' => '[ Verb + Object Pronoun ] atau [ Preposition + Object Pronoun ]',
                            'explanation' => 'Object Pronouns menerima aksi dari subjek, atau diletakkan langsung setelah kata depan (preposisi) seperti to, for, with, about, between.',
                            'items' => ['me', 'you', 'him', 'her', 'it', 'us', 'them'],
                            'examples' => [
                                ['en' => 'Could you please send me the updated timetable?', 'id' => 'Bisakah kamu mengirimkan jadwal terbaru kepada saya?'],
                                ['en' => 'The manager gave him a round of applause.', 'id' => 'Manajer memberikan tepuk tangan meriah kepadanya.'],
                                ['en' => 'This matter must stay between you and me.', 'id' => 'Urusan ini harus tetap rahasia antara kamu dan saya (Bukan: between you and I).'],
                            ],
                            'rule' => 'Waspada: Setelah preposisi (between, for, with, to), selalu gunakan Object Pronoun (me, him, her, us, them), bukan Subject Pronoun.',
                        ],
                        [
                            'id' => 'possessive_adj',
                            'badge' => 'Category 3',
                            'color' => 'amber',
                            'title' => 'Possessive Adjectives (Kata Sifat Kepemilikan)',
                            'tagline' => 'WAJIB diikuti oleh Kata Benda (Noun) -> [Possessive Adj + NOUN]',
                            'formula' => '[ My / Your / His / Her / Its / Our / Their + NOUN ]',
                            'explanation' => 'Possessive Adjectives menerangkan kepemilikan atas suatu benda. Ciri mutlaknya adalah HARUS selalu menempel di depan kata benda.',
                            'items' => ['my', 'your', 'his', 'her', 'its', 'our', 'their'],
                            'examples' => [
                                ['en' => 'Is this your new smartphone on the table?', 'id' => 'Apakah ini smartphone barumu di atas meja?'],
                                ['en' => 'Our English teacher is very patient and friendly.', 'id' => 'Guru bahasa Inggris kami sangat sabar dan ramah.'],
                                ['en' => 'The cat is cleaning its paws.', 'id' => 'Kucing itu sedang membersihkan cakar-cakarnya (its tanpa tanda kutip!).'],
                            ],
                            'rule' => 'Possessive Adjectives tidak bisa berdiri sendiri tanpa benda di belakangnya (Salah: "This is my." -> Benar: "This is my book.").',
                        ],
                        [
                            'id' => 'possessive_pro',
                            'badge' => 'Category 4',
                            'color' => 'purple',
                            'title' => 'Possessive Pronouns (Kata Ganti Kepemilikan Mandiri)',
                            'tagline' => 'Berdiri SENDIRI dan TIDAK PERNAH diikuti Kata Benda',
                            'formula' => '[ NOUN + to be + Mine / Yours / His / Hers / Ours / Theirs ]',
                            'explanation' => 'Possessive Pronouns menggantikan kata sifat kepemilikan sekaligus bendanya agar tidak terjadi pengulangan kata yang membosankan.',
                            'items' => ['mine', 'yours', 'his', 'hers', 'ours', 'theirs'],
                            'examples' => [
                                ['en' => 'This jacket is mine, and that coat is yours.', 'id' => 'Jaket ini milik saya, dan mantel itu milik kamu.'],
                                ['en' => 'Her presentation was great, but ours was more engaging.', 'id' => 'Presentasinya bagus, tetapi presentasi milik kita lebih menarik.'],
                                ['en' => 'My luggage is black, while theirs is bright red.', 'id' => 'Koper saya hitam, sedangkan koper milik mereka berwarna merah terang.'],
                            ],
                            'rule' => 'Jangan pernah menambahkan kata benda setelah Possessive Pronoun (Salah: "This is mine car." -> Benar: "This car is mine.").',
                        ],
                        [
                            'id' => 'reflexive',
                            'badge' => 'Category 5',
                            'color' => 'rose',
                            'title' => 'Reflexive Pronouns (Kata Ganti Refleksif / Penekanan Diri)',
                            'tagline' => 'Aksi mengenai diri sendiri ATAU Penekanan (Melakukan sendiri tanpa bantuan)',
                            'formula' => '[ Subject + Verb + Reflexive Pronoun (Objek = Subjek) ] / [ Subject + ... + by himself/myself ]',
                            'explanation' => 'Reflexive Pronouns dipakai ketika subjek dan objek adalah orang yang sama, atau untuk memberi penekanan bahwa subjek melakukan tindakan itu sendiri tanpa bantuan orang lain.',
                            'items' => ['myself', 'yourself', 'himself', 'herself', 'itself', 'ourselves', 'yourselves', 'themselves'],
                            'examples' => [
                                ['en' => 'I accidentally cut myself while chopping carrots.', 'id' => 'Saya tidak sengaja melukai diri saya sendiri saat memotong wortel.'],
                                ['en' => 'He built this mobile application all by himself.', 'id' => 'Dia membangun aplikasi seluler ini sepenuhnya sendirian tanpa bantuan.'],
                                ['en' => 'We must take good care of ourselves during the flu season.', 'id' => 'Kita harus menjaga diri kita baik-baik selama musim flu.'],
                            ],
                            'rule' => 'Reflexive tunggal berakhiran "-self" (myself, yourself, himself, herself, itself). Bentuk jamak berakhiran "-selves" (ourselves, yourselves, themselves).',
                        ],
                    ],
                    'pitfalls' => [
                        [
                            'id' => 'its_vs_its',
                            'badge' => 'Crucial Spoken Distinction',
                            'title' => "Its vs It's (Suara Sama, Makna Sangat Berbeda)",
                            'desc' => "<b>It's</b> adalah singkatan dari <i>It is</i> atau <i>It has</i> (memiliki tanda petik apostrof). Sedangkan <b>Its</b> adalah kata ganti kepemilikan (tanpa apostrof sama sekali).",
                            'wrong' => "The company changed it's marketing strategy.",
                            'correct' => "The company changed its marketing strategy. (It's a great strategy!)",
                        ],
                        [
                            'id' => 'your_vs_youre',
                            'badge' => 'Common Pronunciation & Text Error',
                            'title' => "Your vs You're",
                            'desc' => "<b>Your</b> adalah possessive adjective (milikmu). Sedangkan <b>You're</b> adalah singkatan dari <i>You are</i>.",
                            'wrong' => "Your the best English student in our batch.",
                            'correct' => "You're the best English student in our batch! (I love your enthusiasm.)",
                        ],
                        [
                            'id' => 'their_there_theyre',
                            'badge' => 'The Triple Homophone',
                            'title' => "Their vs There vs They're",
                            'desc' => "<b>Their</b> = kepemilikan mereka (their car), <b>There</b> = di sana / penunjuk tempat (over there), <b>They're</b> = singkatan dari <i>They are</i>.",
                            'wrong' => "There going to visit they're grandparents over their.",
                            'correct' => "They're going to visit their grandparents over there.",
                        ],
                        [
                            'id' => 'between_you_and_me',
                            'badge' => 'Preposition + Object Rule',
                            'title' => "Between you and me (Bukan 'Between you and I')",
                            'desc' => "Kata <i>between</i> adalah preposisi. Semua kata ganti setelah preposisi WAJIB menggunakan Object Pronoun (me, him, her, us, them).",
                            'wrong' => "Between you and I, I think the exam was quite tricky.",
                            'correct' => "Between you and me, I think the exam was quite tricky.",
                        ],
                        [
                            'id' => 'myself_as_subject',
                            'badge' => 'Over-politeness Error',
                            'title' => "Jangan gunakan 'Myself' sebagai Subjek atau Objek Biasa",
                            'desc' => "Reflexive pronoun <i>myself</i> hanya dipakai jika Anda adalah subjek sekaligus objek kalimat, atau untuk penekanan. Jangan gunakan untuk menggantikan <i>I</i> atau <i>me</i>.",
                            'wrong' => "John and myself will lead the speaking workshop.",
                            'correct' => "John and I will lead the speaking workshop. (Feel free to contact John or me.)",
                        ],
                    ],
                    'demonstratives' => [
                        'title' => 'Demonstrative Pronouns & Adjectives (Penunjuk Jarak & Jumlah)',
                        'items' => [
                            ['word' => 'This', 'type' => 'Singular (Dekat)', 'ipa' => '/ðɪs/', 'meaning' => 'Ini (satu benda dekat)', 'example' => 'This is my personal laptop on my desk.'],
                            ['word' => 'These', 'type' => 'Plural (Dekat)', 'ipa' => '/ðiːz/', 'meaning' => 'Ini semua (banyak benda dekat)', 'example' => 'These are our newly printed presentation handouts.'],
                            ['word' => 'That', 'type' => 'Singular (Jauh)', 'ipa' => '/ðæt/', 'meaning' => 'Itu (satu benda jauh)', 'example' => 'That is their private conference room across the hall.'],
                            ['word' => 'Those', 'type' => 'Plural (Jauh)', 'ipa' => '/ðoʊz/', 'meaning' => 'Itu semua (banyak benda jauh)', 'example' => 'Those are the award certificates we won last year.'],
                        ]
                    ]
                ],
                'listening' => [
                    'title' => 'Short Listening Practice: The Lost Backpack & Mystery Owner',
                    'audio_script' => "David: Excuse me, Sarah! Is this navy blue backpack yours?\nSarah: No, David, that backpack isn't mine. My backpack is bright red, and I left it in my locker. I think this bag belongs to Jessica. Look at that handcrafted wooden keychain on the zipper—she made it herself during our art workshop last Friday!\nDavid: You are right! I saw her carrying it this morning. Let's return it to her before our lecture starts. We can also ask their study group if anyone left their notebook behind.\nSarah: Great idea! Between you and me, Jessica would be very relieved to have her bag back. Let's go find her right now!",
                    'key_phrases' => [
                        'Is this navy blue backpack yours? No, it isn\'t mine.',
                        'She made it herself during our art workshop last Friday.',
                        'Between you and me, Jessica would be very relieved to have her bag back.',
                        'We can also ask their study group if anyone left their notebook behind.',
                    ],
                    'questions' => [
                        [
                            'q' => 'Whose backpack was actually found in the classroom?',
                            'options' => [
                                'Jessica\'s backpack',
                                'Sarah\'s backpack',
                                'David\'s backpack',
                                'The professor\'s backpack',
                            ],
                            'answer' => 'Jessica\'s backpack',
                        ],
                        [
                            'q' => 'How did Sarah know the backpack belonged to Jessica?',
                            'options' => [
                                'Because of a handcrafted keychain that Jessica made herself',
                                'Because Sarah\'s name was written on the front tag',
                                'Because David opened it and read Jessica\'s diary',
                                'Because the backpack was bright red',
                            ],
                            'answer' => 'Because of a handcrafted keychain that Jessica made herself',
                        ],
                        [
                            'q' => 'Which sentence contains the grammatically correct preposition and pronoun pair?',
                            'options' => [
                                'Between you and me, Jessica will be very relieved.',
                                'Between you and I, Jessica will be very relieved.',
                                'Between yourself and I, Jessica will be very relieved.',
                                'Between you and myself, Jessica will be very relieved.',
                            ],
                            'answer' => 'Between you and me, Jessica will be very relieved.',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I have a new laptop. This new laptop is mine.',
                        'id' => 'Saya punya laptop baru. Laptop baru ini milik saya.',
                    ],
                    [
                        'en' => 'She loves her job, and she always does her assignments herself.',
                        'id' => 'Dia mencintai pekerjaannya, dan dia selalu menyelesaikan tugas-tugasnya sendiri.',
                    ],
                    [
                        'en' => 'They invited us to their party, and we really enjoyed ourselves.',
                        'id' => 'Mereka mengundang kami ke pesta mereka, dan kami sangat menikmati waktu kami.',
                    ],
                    [
                        'en' => 'He bought himself a coffee and offered one to me.',
                        'id' => 'Dia membelikan dirinya sendiri segelas kopi dan menawarkan satu kepada saya.',
                    ],
                    [
                        'en' => 'Between you and me, their presentation is much more convincing than ours.',
                        'id' => 'Antara kamu dan saya, presentasi mereka jauh lebih meyakinkan daripada milik kita.',
                    ],
                    [
                        'en' => 'The company updated its mobile app, and it works seamlessly by itself.',
                        'id' => 'Perusahaan memperbarui aplikasi selulernya, dan aplikasi itu berjalan lancar dengan sendirinya.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'Please introduce yourself to the rest of the speaking class.',
                        'id' => 'Silakan perkenalkan dirimu kepada seluruh anggota kelas speaking.',
                    ],
                    [
                        'en' => 'We built this entire web application ourselves from scratch without external help.',
                        'id' => 'Kami membangun seluruh aplikasi web ini sendiri dari awal tanpa bantuan pihak luar.',
                    ],
                    [
                        'en' => 'Is that umbrella on the rack hers, or did someone leave theirs behind?',
                        'id' => 'Apakah payung di rak itu miliknya, atau ada yang meninggalkan payung milik mereka?',
                    ],
                    [
                        'en' => 'Can you please lend him your notes? He forgot his at home this morning.',
                        'id' => 'Bisakah kamu meminjamkan catatanmu kepadanya? Dia kelupaan membawa miliknya di rumah pagi ini.',
                    ],
                    [
                        'en' => 'They promised to look after themselves during their adventurous mountain hike.',
                        'id' => 'Mereka berjanji untuk menjaga diri mereka baik-baik selama pendakian gunung yang menantang.',
                    ],
                    [
                        'en' => 'These books belong to our mentor, so please handle them with great care.',
                        'id' => 'Buku-buku ini milik mentor kita, jadi tolong rawat buku-buku tersebut dengan hati-hati.',
                    ],
                ],
                'grammar_note' => 'Golden Rule: Possessive Adjectives ALWAYS need a noun (my car, her bag, their house). Possessive Pronouns NEVER take a noun (the car is mine, the bag is hers, the house is theirs). Use Reflexive when Subject = Object (I taught myself) or for emphasis (We did it ourselves).',
                'dialogue_setting' => 'Dua percakapan autentik melatih penggunaan Subjek, Objek, Possessive Adjective, Possessive Pronoun, dan Reflexive Pronoun dalam situasi sosial nyata.',
                'dialogue' => [
                    // Ronde 1: Whose Backpack Is This? (Investigating Lost Items)
                    [
                        'section_badge' => 'Ronde 1: Investigating Lost Belongings (Whose Backpack Is This?)',
                        'speaker' => 'Alex',
                        'role_label' => 'Siswa A (Menemukan Barang Tertinggal)',
                        'id' => 'Permisi Bella! Apakah payung ungu di samping kursimu ini milikmu?',
                        'en' => 'Excuse me Bella! Is this purple umbrella next to your chair yours?',
                    ],
                    [
                        'speaker' => 'Bella',
                        'role_label' => 'Siswa B (Memeriksa Kepemilikan & Memberi Informasi)',
                        'id' => 'Tidak, payung itu bukan milik saya. Milik saya berwarna biru tua di dalam tas saya. Saya rasa payung itu milik Sarah.',
                        'en' => 'No, that umbrella isn\'t mine. Mine is navy blue inside my bag. I think that umbrella belongs to Sarah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'role_label' => 'Siswa A (Menanyakan Ciri-ciri Khusus)',
                        'id' => 'Bagaimana kamu bisa yakin payung itu miliknya?',
                        'en' => 'How can you be so certain that it is hers?',
                    ],
                    [
                        'speaker' => 'Bella',
                        'role_label' => 'Siswa B (Menjelaskan Bukti Reflexive)',
                        'id' => 'Lihat gantungan kuncinya! Dia menghiasnya sendiri dengan pita kain sutra kemarin.',
                        'en' => 'Look at the keychain! She decorated it herself with silk ribbon yesterday.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'role_label' => 'Siswa A (Mengajak Mengembalikan Barang)',
                        'id' => 'Kamu benar sekali! Mari kita antarkan payung ini kepadanya sebelum hujan mulai turun deras.',
                        'en' => 'You are completely right! Let\'s return it to her before the heavy rain starts.',
                    ],
                    [
                        'speaker' => 'Bella',
                        'role_label' => 'Siswa B (Menyetujui dengan Preposisi + Object)',
                        'id' => 'Ide bagus. Antara kamu dan saya, dia pasti sangat cemas mencari payung kesayangannya.',
                        'en' => 'Great idea. Between you and me, she must be very anxious looking for her favorite umbrella.',
                    ],
                    // Ronde 2: Dividing Responsibilities for Group Presentation
                    [
                        'section_badge' => 'Ronde 2: Tukar Peran (Membagi Tugas Presentasi Kelompok)',
                        'speaker' => 'David',
                        'role_label' => 'Siswa A (Membahas Pembagian Proyek)',
                        'id' => 'Maya, bagaimana kita akan membagi bagian presentasi kita untuk ujian speaking besok?',
                        'en' => 'Maya, how shall we divide our presentation parts for tomorrow\'s speaking test?',
                    ],
                    [
                        'speaker' => 'Maya',
                        'role_label' => 'Siswa B (Mengusulkan Pembagian Mandiri)',
                        'id' => 'Saya bisa menyiapkan slide pembuka sendiri, dan kamu bisa merancang studi kasusnya sendiri.',
                        'en' => 'I can prepare the opening slides myself, and you can design the case study yourself.',
                    ],
                    [
                        'speaker' => 'David',
                        'role_label' => 'Siswa A (Menanyakan Data Kelompok Lain)',
                        'id' => 'Terdengar adil! Bagaimana dengan kelompok Kevin dan Lisa? Apakah topik mereka mirip dengan topik kita?',
                        'en' => 'Sounds fair! What about Kevin and Lisa\'s group? Is their topic similar to ours?',
                    ],
                    [
                        'speaker' => 'Maya',
                        'role_label' => 'Siswa B (Membandingkan dengan Possessive Pronouns)',
                        'id' => 'Topik kita berfokus pada teknologi pendidikan, sedangkan topik mereka membahas pariwisata berkelanjutan.',
                        'en' => 'Our topic focuses on educational technology, while theirs discusses sustainable tourism.',
                    ],
                    [
                        'speaker' => 'David',
                        'role_label' => 'Siswa A (Menegaskan Kerja Sama)',
                        'id' => 'Bagus sekali. Mari kita beri diri kita waktu dua jam untuk gladi bersih sore ini.',
                        'en' => 'Excellent. Let\'s give ourselves two hours for a full dress rehearsal this afternoon.',
                    ],
                    [
                        'speaker' => 'Maya',
                        'role_label' => 'Siswa B (Menutup dengan Percaya Diri)',
                        'id' => 'Sepakat! Jika kita percaya pada diri kita sendiri, hasil terbaik pasti menjadi milik kita.',
                        'en' => 'Agreed! If we believe in ourselves, the highest score will certainly be ours.',
                    ],
                ],
                'vocabulary' => [
                    ['word' => 'I', 'type' => 'Subject Pronoun', 'ipa' => '/aɪ/', 'meaning' => 'Saya (subjek pelaku)', 'example' => 'I learn English every day.'],
                    ['word' => 'Me', 'type' => 'Object Pronoun', 'ipa' => '/miː/', 'meaning' => 'Saya (objek penerima / setelah preposisi)', 'example' => 'Please give the document to me.'],
                    ['word' => 'My', 'type' => 'Possessive Adjective', 'ipa' => '/maɪ/', 'meaning' => '... saya (wajib diikuti kata benda)', 'example' => 'This is my personal computer.'],
                    ['word' => 'Mine', 'type' => 'Possessive Pronoun', 'ipa' => '/maɪn/', 'meaning' => 'Milik saya (tanpa kata benda)', 'example' => 'This computer is mine.'],
                    ['word' => 'Myself', 'type' => 'Reflexive Pronoun', 'ipa' => '/maɪˈsɛlf/', 'meaning' => 'Diri saya sendiri / Saya sendiri', 'example' => 'I solved the problem myself.'],
                    ['word' => 'You', 'type' => 'Subject / Object', 'ipa' => '/juː/', 'meaning' => 'Kamu / Anda (tunggal atau jamak)', 'example' => 'You are doing an excellent job.'],
                    ['word' => 'Your', 'type' => 'Possessive Adjective', 'ipa' => '/jɔːr/', 'meaning' => '... kamu / anda (wajib ada benda)', 'example' => 'Is this your new car?'],
                    ['word' => 'Yours', 'type' => 'Possessive Pronoun', 'ipa' => '/jɔːrz/', 'meaning' => 'Milik kamu / milik anda', 'example' => 'Is this blue backpack yours?'],
                    ['word' => 'Yourself', 'type' => 'Reflexive Pronoun', 'ipa' => '/jɔːrˈsɛlf/', 'meaning' => 'Dirimu sendiri (tunggal)', 'example' => 'Take good care of yourself.'],
                    ['word' => 'Yourselves', 'type' => 'Reflexive Pronoun', 'ipa' => '/jɔːrˈsɛlvz/', 'meaning' => 'Diri kalian semua (jamak)', 'example' => 'Please enjoy yourselves at the party.'],
                    ['word' => 'He', 'type' => 'Subject Pronoun', 'ipa' => '/hiː/', 'meaning' => 'Dia (laki-laki, subjek)', 'example' => 'He lives in Melbourne, Australia.'],
                    ['word' => 'Him', 'type' => 'Object Pronoun', 'ipa' => '/hɪm/', 'meaning' => 'Dia (laki-laki, objek)', 'example' => 'We congratulated him on his success.'],
                    ['word' => 'His', 'type' => 'Possessive Adj / Pronoun', 'ipa' => '/hɪz/', 'meaning' => 'Miliknya (laki-laki)', 'example' => 'His speech was inspiring and the idea was his.'],
                    ['word' => 'Himself', 'type' => 'Reflexive Pronoun', 'ipa' => '/hɪmˈsɛlf/', 'meaning' => 'Dirinya sendiri (laki-laki)', 'example' => 'He repaired the vintage bicycle himself.'],
                    ['word' => 'She', 'type' => 'Subject Pronoun', 'ipa' => '/ʃiː/', 'meaning' => 'Dia (perempuan, subjek)', 'example' => 'She leads the regional research team.'],
                    ['word' => 'Her', 'type' => 'Object / Possessive Adj', 'ipa' => '/hɜːr/', 'meaning' => 'Dia (objek) / ... miliknya (perempuan)', 'example' => 'I called her yesterday to discuss her project.'],
                    ['word' => 'Hers', 'type' => 'Possessive Pronoun', 'ipa' => '/hɜːrz/', 'meaning' => 'Miliknya (perempuan, mandiri)', 'example' => 'That golden trophy is hers.'],
                    ['word' => 'Herself', 'type' => 'Reflexive Pronoun', 'ipa' => '/hɜːrˈsɛlf/', 'meaning' => 'Dirinya sendiri (perempuan)', 'example' => 'She prepared the entire gourmet dinner herself.'],
                    ['word' => 'It', 'type' => 'Subject / Object', 'ipa' => '/ɪt/', 'meaning' => 'Benda / hewan / hal ini', 'example' => 'It operates smoothly on all devices.'],
                    ['word' => 'Its', 'type' => 'Possessive Adjective', 'ipa' => '/ɪts/', 'meaning' => 'Miliknya (hewan/benda, tanpa petik)', 'example' => 'The cat washed its paws thoroughly.'],
                    ['word' => 'Itself', 'type' => 'Reflexive Pronoun', 'ipa' => '/ɪtˈsɛlf/', 'meaning' => 'Dirinya sendiri (benda/hewan)', 'example' => 'The software updates itself automatically.'],
                    ['word' => 'We', 'type' => 'Subject Pronoun', 'ipa' => '/wiː/', 'meaning' => 'Kami / kita (subjek)', 'example' => 'We speak fluent English with confidence.'],
                    ['word' => 'Us', 'type' => 'Object Pronoun', 'ipa' => '/ʌs/', 'meaning' => 'Kami / kita (objek)', 'example' => 'The instructor gave us insightful feedback.'],
                    ['word' => 'Our', 'type' => 'Possessive Adjective', 'ipa' => '/ˈaʊ.ər/', 'meaning' => '... kami / kita (wajib ada benda)', 'example' => 'Our team achieved all quarterly goals.'],
                    ['word' => 'Ours', 'type' => 'Possessive Pronoun', 'ipa' => '/ˈaʊ.ərz/', 'meaning' => 'Milik kami / milik kita', 'example' => 'The championship victory is ours.'],
                    ['word' => 'Ourselves', 'type' => 'Reflexive Pronoun', 'ipa' => '/aʊərˈsɛlvz/', 'meaning' => 'Diri kami / kita sendiri', 'example' => 'We treated ourselves to a delicious dinner.'],
                    ['word' => 'They', 'type' => 'Subject Pronoun', 'ipa' => '/ðeɪ/', 'meaning' => 'Mereka (subjek)', 'example' => 'They arrived at the venue on schedule.'],
                    ['word' => 'Them', 'type' => 'Object Pronoun', 'ipa' => '/ðɛm/', 'meaning' => 'Mereka (objek)', 'example' => 'We invited them to join our study group.'],
                    ['word' => 'Their', 'type' => 'Possessive Adjective', 'ipa' => '/ðɛər/', 'meaning' => '... mereka (wajib ada benda)', 'example' => 'Their collaborative effort was phenomenal.'],
                    ['word' => 'Theirs', 'type' => 'Possessive Pronoun', 'ipa' => '/ðɛərz/', 'meaning' => 'Milik mereka', 'example' => 'Our car is red, but theirs is metallic grey.'],
                    ['word' => 'Themselves', 'type' => 'Reflexive Pronoun', 'ipa' => '/ðəmˈsɛlvz/', 'meaning' => 'Diri mereka sendiri', 'example' => 'They built their startup company themselves.'],
                ],
                'games' => [
                    'type' => 'wedding_photos',
                    'participation_type' => 'pair',
                    'title' => 'Worksheet 6 Game • Wedding Photos (Asking & Saying Who Someone Is)',
                    'activity' => 'Pairwork; Information Gap',
                    'aim' => 'To find out who all the people in the photo are and write their names in on the photo by asking "Who\'s that?" and answering "That\'s [Name]. She\'s/He\'s my [Relationship]."',
                    'function_practised' => 'Asking and saying who someone is',
                    'structures' => [
                        "Who's this / that?",
                        "This is / That's [Name]. She's / He's my [Relationship].",
                        "Who's the man with the glasses / moustache?",
                        "Who's the woman wearing the hat / holding flowers?",
                    ],
                    'topic_area' => 'Family members & Pronouns (He, She, This, That, My, His, Her)',
                    'essential_vocabulary' => 'mother, father, sister, brother, aunt, uncle, cousin, grandmother, grandfather, bride, groom, husband, wife',
                    'images' => [
                        'wedding_photo_color' => '/images/speaking/wedding_photos/wedding_photo_color.jpg',
                        'wedding_photo' => '/images/speaking/wedding_photos/wedding_photo_upright.png',
                        'family_trees' => '/images/speaking/wedding_photos/family_trees.png',
                        'family_tree_a' => '/images/speaking/wedding_photos/family_tree_a.png',
                        'family_tree_b' => '/images/speaking/wedding_photos/family_tree_b.png',
                        'teacher_guide_1' => '/images/speaking/wedding_photos/teacher_guide_1.png',
                        'teacher_guide_2' => '/images/speaking/wedding_photos/teacher_guide_2.png',
                    ],
                    'story' => [
                        'en' => "This is a wedding picture: Student A's sister (Ann) is marrying Student B's brother (Tim). A's family is on the bride's side and B's family is on the groom's side.",
                        'id' => "Ini adalah foto pernikahan keluarga besar: Saudara perempuan Siswa A (Ann) menikah dengan saudara laki-laki Siswa B (Tim). Keluarga Siswa A berada di sisi pengantin wanita (Bride), dan keluarga Siswa B berada di sisi pengantin pria (Groom)."
                    ],
                    'family_a' => [
                        'title' => "Family Tree A (Bride's Family)",
                        'badge' => "Bride's Family (Ann's Side)",
                        'self_name' => "Student A (Ann's Sibling)",
                        'bride' => "Ann (The Bride - Sister of Student A)",
                        'groom' => "Tim (The Groom - New Brother-in-law)",
                        'members' => [
                            ['name' => 'Joe', 'relation_en' => 'Grandfather', 'relation_id' => 'Kakek', 'pronoun' => 'He', 'clue' => 'Old man with glasses and spiky hair at the top back', 'spoken_answer' => "That's Joe. He's my grandfather."],
                            ['name' => 'Elsie', 'relation_en' => 'Grandmother', 'relation_id' => 'Nenek', 'pronoun' => 'She', 'clue' => 'Elderly lady with curly hair and round glasses next to Joe', 'spoken_answer' => "That's Elsie. She's my grandmother."],
                            ['name' => 'Tom', 'relation_en' => 'Father', 'relation_id' => 'Ayah', 'pronoun' => 'He', 'clue' => 'Bald man with moustache smiling in suit', 'spoken_answer' => "That's Tom. He's my father."],
                            ['name' => 'Jess', 'relation_en' => 'Mother', 'relation_id' => 'Ibu', 'pronoun' => 'She', 'clue' => 'Woman wearing a wide-brimmed hat next to Tom', 'spoken_answer' => "That's Jess. She's my mother."],
                            ['name' => 'Pete', 'relation_en' => 'Uncle', 'relation_id' => 'Paman', 'pronoun' => 'He', 'clue' => 'Man with curly hair and glasses wearing a bowtie', 'spoken_answer' => "That's Pete. He's my uncle."],
                            ['name' => 'Sue', 'relation_en' => 'Aunt', 'relation_id' => 'Bibi', 'pronoun' => 'She', 'clue' => 'Woman with dark headband and stylish coat', 'spoken_answer' => "That's Sue. She's my aunt."],
                            ['name' => 'Sam', 'relation_en' => 'Brother', 'relation_id' => 'Saudara Laki-laki', 'pronoun' => 'He', 'clue' => 'Young boy in neat suit with bow tie near Ann', 'spoken_answer' => "That's Sam. He's my brother."],
                            ['name' => 'Ann', 'relation_en' => 'Sister (The Bride)', 'relation_id' => 'Pengantin Wanita (Kakak/Adik)', 'pronoun' => 'She', 'clue' => 'The bride in white veil and holding flowers', 'spoken_answer' => "That's Ann. She's my sister (the bride)."],
                            ['name' => 'Mike', 'relation_en' => 'Cousin', 'relation_id' => 'Sepupu', 'pronoun' => 'He', 'clue' => 'Young man with glasses and smile (son of Pete & Sue)', 'spoken_answer' => "That's Mike. He's my cousin."],
                        ]
                    ],
                    'family_b' => [
                        'title' => "Family Tree B (Groom's Family)",
                        'badge' => "Groom's Family (Tim's Side)",
                        'self_name' => "Student B (Tim's Sibling)",
                        'groom' => "Tim (The Groom - Brother of Student B)",
                        'bride' => "Ann (The Bride - New Sister-in-law)",
                        'members' => [
                            ['name' => 'Jim', 'relation_en' => 'Grandfather', 'relation_id' => 'Kakek', 'pronoun' => 'He', 'clue' => 'Old man with thick bushy moustache and suit at the back', 'spoken_answer' => "That's Jim. He's my grandfather."],
                            ['name' => 'Betty', 'relation_en' => 'Grandmother', 'relation_id' => 'Nenek', 'pronoun' => 'She', 'clue' => 'Elderly lady with hair tied in a bun smiling next to Jim', 'spoken_answer' => "That's Betty. She's my grandmother."],
                            ['name' => 'Al', 'relation_en' => 'Father', 'relation_id' => 'Ayah', 'pronoun' => 'He', 'clue' => 'Man with neat moustache and suit standing near Tim', 'spoken_answer' => "That's Al. He's my father."],
                            ['name' => 'Jane', 'relation_en' => 'Mother', 'relation_id' => 'Ibu', 'pronoun' => 'She', 'clue' => 'Woman wearing a hat with flower corsage on jacket', 'spoken_answer' => "That's Jane. She's my mother."],
                            ['name' => 'Ben', 'relation_en' => 'Uncle', 'relation_id' => 'Paman', 'pronoun' => 'He', 'clue' => 'Man with dark combed hair smiling next to Liz', 'spoken_answer' => "That's Ben. He's my uncle."],
                            ['name' => 'Liz', 'relation_en' => 'Aunt', 'relation_id' => 'Bibi', 'pronoun' => 'She', 'clue' => 'Woman wearing a stylish beret hat and scarf', 'spoken_answer' => "That's Liz. She's my aunt."],
                            ['name' => 'Tim', 'relation_en' => 'Brother (The Groom)', 'relation_id' => 'Pengantin Pria (Kakak/Adik)', 'pronoun' => 'He', 'clue' => 'The groom in suit with flower on lapel', 'spoken_answer' => "That's Tim. He's my brother (the groom)."],
                            ['name' => 'Beth', 'relation_en' => 'Sister', 'relation_id' => 'Saudara Perempuan', 'pronoun' => 'She', 'clue' => 'Young girl with bow ribbons in hair holding bouquet', 'spoken_answer' => "That's Beth. She's my sister."],
                            ['name' => 'John', 'relation_en' => 'Cousin', 'relation_id' => 'Sepupu', 'pronoun' => 'He', 'clue' => 'Young man with wavy hair and tie (son of Ben & Liz)', 'spoken_answer' => "That's John. He's my cousin."],
                        ]
                    ],
                    'sample_dialogues' => [
                        [
                            'step' => 1,
                            'asker' => 'Student A (Menunjuk sisi Groom)',
                            'target' => 'Al (Ayah Tim)',
                            'question_en' => "Who's that man with the moustache next to Tim?",
                            'question_id' => "Siapa pria berkumis di samping Tim itu?",
                            'answerer' => 'Student B (Melihat Family Tree B)',
                            'answer_en' => "That's Al. He's my father.",
                            'answer_id' => "Itu Al. Dia adalah ayah saya."
                        ],
                        [
                            'step' => 2,
                            'asker' => 'Student B (Menunjuk sisi Bride)',
                            'target' => 'Jess (Ibu Ann)',
                            'question_en' => "Who's that woman wearing the wide hat next to Ann?",
                            'question_id' => "Siapa wanita bertopi lebar di sebelah Ann itu?",
                            'answerer' => 'Student A (Melihat Family Tree A)',
                            'answer_en' => "That's Jess. She's my mother.",
                            'answer_id' => "Itu Jess. Dia adalah ibu saya."
                        ],
                        [
                            'step' => 3,
                            'asker' => 'Student A (Menunjuk sisi Groom)',
                            'target' => 'Beth (Adik Tim)',
                            'question_en' => "Who's that little girl in the front holding flowers?",
                            'question_id' => "Siapa anak perempuan kecil di depan yang memegang bunga itu?",
                            'answerer' => 'Student B (Melihat Family Tree B)',
                            'answer_en' => "That's Beth. She's my sister.",
                            'answer_id' => "Itu Beth. Dia adalah saudara perempuan saya."
                        ],
                        [
                            'step' => 4,
                            'asker' => 'Student B (Menunjuk sisi Bride)',
                            'target' => 'Joe (Kakek Ann)',
                            'question_en' => "Who's that elderly man with glasses standing at the back?",
                            'question_id' => "Siapa pria tua berkacamata yang berdiri di baris belakang itu?",
                            'answerer' => 'Student A (Melihat Family Tree A)',
                            'answer_en' => "That's Joe. He's my grandfather.",
                            'answer_id' => "Itu Joe. Dia adalah kakek saya."
                        ]
                    ]
                ],
                'ai_interview' => [
                    [
                        'id' => 1,
                        'question' => "Hello! Welcome to Meeting 5 on English Pronouns. Let's start with your self-introduction: Can you introduce yourself, and mention one skill you taught yourself?",
                        'hint' => "Answer: 'Hello! My name is [Name]. In my spare time, I taught myself [e.g. how to play the acoustic guitar / how to edit video / English speaking] all by myself.'",
                    ],
                    [
                        'id' => 2,
                        'question' => "What is the key grammatical difference between 'This is my car' and 'This car is mine'?",
                        'hint' => "Answer: ''My' is a possessive adjective that must be followed by a noun (my car), whereas 'mine' is a possessive pronoun that stands alone without a noun.'",
                    ],
                    [
                        'id' => 3,
                        'question' => "Why is it grammatically incorrect to say 'This secret is between you and I'? What is the correct phrase and why?",
                        'hint' => "Answer: 'The correct phrase is 'Between you and me' because 'between' is a preposition, and pronouns following a preposition must be object pronouns (me, not I).'",
                    ],
                    [
                        'id' => 4,
                        'question' => "Can you explain the difference between 'it's' and 'its' with a clear example for each?",
                        'hint' => "Answer: ''It's' with an apostrophe means 'it is' (e.g. 'It's raining outside'), while 'its' without an apostrophe shows possession (e.g. 'The cat licked its paw').'",
                    ],
                    [
                        'id' => 5,
                        'question' => "Describe a challenging project, presentation, or task that you and your team completed yourselves. Who was involved and how did you feel?",
                        'hint' => "Answer: 'My classmates and I organized a speaking competition ourselves. We divided the tasks between them and me, and we really enjoyed ourselves.'",
                    ],
                ],
            ],
            6 => [
                'topic' => 'Hobbies and Leisure Activities',
                'focus' => 'Expressing likes, dislikes, and frequencies with gerunds',
                'listening' => [
                    'title' => 'Listening Practice: Hobbies and Leisure Activities',
                    'audio_script' => 'In my spare time, I love landscape photography and outdoor cycling. Whenever I have a free Saturday, I take my digital camera to the botanical gardens to capture close-up shots of exotic flowers and birds. Engaging in creative hobbies helps me relieve mental fatigue.',
                    'key_phrases' => [
                        'I enjoy playing badminton with my colleagues twice a week.',
                        'She loves reading mystery novels before going to sleep.',
                        'We often go hiking in the hills on Sunday mornings.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Hobbies and Leisure Activities',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Hobbies and Leisure Activities',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'I enjoy playing badminton with my colleagues twice a week.',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'I enjoy playing badminton with my colleagues twice a week.',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering hobbies and leisure activities?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I enjoy playing badminton with my colleagues twice a week.',
                        'id' => 'Saya menikmati bermain bulu tangkis dengan rekan kerja dua kali seminggu.',
                    ],
                    [
                        'en' => 'She loves reading mystery novels before going to sleep.',
                        'id' => 'Dia suka membaca novel misteri sebelum tidur.',
                    ],
                    [
                        'en' => 'We often go hiking in the hills on Sunday mornings.',
                        'id' => 'Kami sering mendaki bukit pada Minggu pagi.',
                    ],
                    [
                        'en' => 'He practices playing the acoustic guitar every evening.',
                        'id' => 'Dia berlatih bermain gitar akustik setiap malam.',
                    ],
                    [
                        'en' => 'Having active hobbies creates a healthy work-life balance.',
                        'id' => 'Memiliki hobi yang aktif menciptakan keseimbangan hidup dan kerja yang sehat.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about hobbies and leisure activities with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang hobbies and leisure activities dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Verb patterns: Enjoy / Love / Like / Prefer + Gerund (V-ing)',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Hobbies and Leisure Activities dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Hobbies and Leisure Activities today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Hobbies and Leisure Activities hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for hobbies and leisure activities makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk hobbies and leisure activities membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "I enjoy playing badminton with my colleagues twice a week.". It sounds very natural and professional.',
                        'id' => 'Frasa: "I enjoy playing badminton with my colleagues twice a week.". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Hobbies and Leisure Activities memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Hobbies and Leisure Activities ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Hobbies and Leisure Activities?',
                    'Seberapa sering kamu membahas tentang Hobbies and Leisure Activities dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Hobbies and Leisure Activities Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Hobbies and Leisure Activities membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            7 => [
                'topic' => 'Travel and Transportation',
                'focus' => 'Directions, public transport, travel itineraries, asking for help',
                'listening' => [
                    'title' => 'Listening Practice: Travel and Transportation',
                    'audio_script' => 'Traveling opens up new horizons and broadens cultural understanding. Last month, I took the high-speed train to Yogyakarta. Getting around the city was very convenient thanks to the modern public transit, clear directional signboards, and helpful local commuters.',
                    'key_phrases' => [
                        'Excuse me, where is the nearest commuter train station?',
                        'Go straight ahead for two blocks and turn left at the traffic light.',
                        'We take the subway to avoid morning traffic congestion.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Travel and Transportation',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Travel and Transportation',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'Excuse me, where is the nearest commuter train station?',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'Excuse me, where is the nearest commuter train station?',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering travel and transportation?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Excuse me, where is the nearest commuter train station?',
                        'id' => 'Permisi, di mana stasiun kereta komuter terdekat?',
                    ],
                    [
                        'en' => 'Go straight ahead for two blocks and turn left at the traffic light.',
                        'id' => 'Lurus terus sejauh dua blok dan belok kiri di lampu lalu lintas.',
                    ],
                    [
                        'en' => 'We take the subway to avoid morning traffic congestion.',
                        'id' => 'Kami naik kereta bawah tanah untuk menghindari kemacetan pagi.',
                    ],
                    [
                        'en' => 'I always book my flight tickets and hotel rooms online in advance.',
                        'id' => 'Saya selalu memesan tiket pesawat dan kamar hotel secara online sebelumnya.',
                    ],
                    [
                        'en' => 'Exploring unfamiliar places teaches us adaptability and confidence.',
                        'id' => 'Menjelajahi tempat baru mengajarkan kita kemampuan adaptasi dan rasa percaya diri.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about travel and transportation with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang travel and transportation dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Prepositions of Movement: into, out of, across, through, towards, along',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Travel and Transportation dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Travel and Transportation today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Travel and Transportation hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for travel and transportation makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk travel and transportation membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "Excuse me, where is the nearest commuter train station?". It sounds very natural and professional.',
                        'id' => 'Frasa: "Excuse me, where is the nearest commuter train station?". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Travel and Transportation memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Travel and Transportation ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Travel and Transportation?',
                    'Seberapa sering kamu membahas tentang Travel and Transportation dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Travel and Transportation Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Travel and Transportation membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            8 => [
                'topic' => 'Shopping and Money',
                'focus' => 'Bargaining, prices, payment methods, personal budgeting',
                'listening' => [
                    'title' => 'Listening Practice: Shopping and Money',
                    'audio_script' => 'Smart shopping requires careful budgeting and smart decision making. I usually compare prices on e-commerce platforms before making any electronics purchase. It helps me find the best promotional discounts while keeping my monthly expenses within budget.',
                    'key_phrases' => [
                        'How much does this pair of running shoes cost?',
                        'Can you give me a ten percent discount on this purchase?',
                        'Do you accept contactless digital wallet payments here?',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Shopping and Money',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Shopping and Money',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'How much does this pair of running shoes cost?',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'How much does this pair of running shoes cost?',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering shopping and money?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'How much does this pair of running shoes cost?',
                        'id' => 'Berapa harga sepasang sepatu lari ini?',
                    ],
                    [
                        'en' => 'Can you give me a ten percent discount on this purchase?',
                        'id' => 'Bisakah Anda memberi saya diskon sepuluh persen untuk pembelian ini?',
                    ],
                    [
                        'en' => 'Do you accept contactless digital wallet payments here?',
                        'id' => 'Apakah Anda menerima pembayaran dompet digital non-kontak di sini?',
                    ],
                    [
                        'en' => 'I always track my daily expenditures using a financial app.',
                        'id' => 'Saya selalu mencatat pengeluaran harian saya menggunakan aplikasi keuangan.',
                    ],
                    [
                        'en' => 'It is better to invest in high quality items that last longer.',
                        'id' => 'Lebih baik berinvestasi pada barang berkualitas tinggi yang tahan lama.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about shopping and money with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang shopping and money dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Quantifiers: some, any, a few, a little, a lot of, much, many',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Shopping and Money dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Shopping and Money today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Shopping and Money hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for shopping and money makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk shopping and money membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "How much does this pair of running shoes cost?". It sounds very natural and professional.',
                        'id' => 'Frasa: "How much does this pair of running shoes cost?". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Shopping and Money memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Shopping and Money ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Shopping and Money?',
                    'Seberapa sering kamu membahas tentang Shopping and Money dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Shopping and Money Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Shopping and Money membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            9 => [
                'topic' => 'Health and Body',
                'focus' => 'Symptoms, wellness advice, doctor consultations, healthy lifestyle',
                'listening' => [
                    'title' => 'Listening Practice: Health and Body',
                    'audio_script' => 'Maintaining good physical and mental health requires daily dedication. I make sure to drink eight glasses of water every day, sleep at least seven hours, and eat nutritious meals rich in fresh vegetables and lean protein. Regular exercise also keeps my energy levels high.',
                    'key_phrases' => [
                        'I have a mild headache and a sore throat since yesterday.',
                        'You should drink plenty of warm water and get adequate rest.',
                        'She takes essential vitamins every morning to boost her immunity.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Health and Body',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Health and Body',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'I have a mild headache and a sore throat since yesterday.',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'I have a mild headache and a sore throat since yesterday.',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering health and body?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I have a mild headache and a sore throat since yesterday.',
                        'id' => 'Saya mengalami sakit kepala ringan dan sakit tenggorokan sejak kemarin.',
                    ],
                    [
                        'en' => 'You should drink plenty of warm water and get adequate rest.',
                        'id' => 'Kamu sebaiknya minum banyak air hangat dan istirahat yang cukup.',
                    ],
                    [
                        'en' => 'She takes essential vitamins every morning to boost her immunity.',
                        'id' => 'Dia meminum vitamin penting setiap pagi untuk meningkatkan kekebalan tubuhnya.',
                    ],
                    [
                        'en' => 'It is advisable to schedule a medical checkup once a year.',
                        'id' => 'Disarankan untuk menjadwalkan pemeriksaan kesehatan sekali setahun.',
                    ],
                    [
                        'en' => 'Taking deep breaths and walking outdoors helps reduce mental stress.',
                        'id' => 'Mengambil napas dalam-dalam dan berjalan di luar ruangan membantu mengurangi stres.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about health and body with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang health and body dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Modals for giving advice: Should, Ought to, Had better + V1',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Health and Body dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Health and Body today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Health and Body hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for health and body makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk health and body membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "I have a mild headache and a sore throat since yesterday.". It sounds very natural and professional.',
                        'id' => 'Frasa: "I have a mild headache and a sore throat since yesterday.". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Health and Body memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Health and Body ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Health and Body?',
                    'Seberapa sering kamu membahas tentang Health and Body dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Health and Body Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Health and Body membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            10 => [
                'topic' => 'Work and Professions',
                'focus' => 'Job roles, workplace responsibilities, professional communication',
                'listening' => [
                    'title' => 'Listening Practice: Work and Professions',
                    'audio_script' => 'I work as a digital marketing specialist for an innovative technology company. My daily responsibilities include formulating social media campaigns, analyzing web analytics, and coordinating cross-functional projects with our creative and software engineering teams.',
                    'key_phrases' => [
                        'I work as a software engineer at a financial technology company.',
                        'I am responsible for managing client relationships and project deadlines.',
                        'We collaborate effectively through daily morning standup meetings.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Work and Professions',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Work and Professions',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'I work as a software engineer at a financial technology company.',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'I work as a software engineer at a financial technology company.',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering work and professions?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I work as a software engineer at a financial technology company.',
                        'id' => 'Saya bekerja sebagai insinyur perangkat lunak di perusahaan teknologi finansial.',
                    ],
                    [
                        'en' => 'I am responsible for managing client relationships and project deadlines.',
                        'id' => 'Saya bertanggung jawab mengelola hubungan klien dan tenggat waktu proyek.',
                    ],
                    [
                        'en' => 'We collaborate effectively through daily morning standup meetings.',
                        'id' => 'Kami berkolaborasi secara efektif melalui rapat koordinasi pagi setiap hari.',
                    ],
                    [
                        'en' => 'Continuous professional development is essential in a dynamic career.',
                        'id' => 'Pengembangan profesional berkelanjutan sangat penting dalam karier yang dinamis.',
                    ],
                    [
                        'en' => 'Setting clear working boundaries ensures long-term career satisfaction.',
                        'id' => 'Menetapkan batasan kerja yang jelas memastikan kepuasan karier jangka panjang.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about work and professions with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang work and professions dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Action verbs in professional context: Coordinate, analyze, manage, lead, optimize, execute',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Work and Professions dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Work and Professions today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Work and Professions hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for work and professions makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk work and professions membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "I work as a software engineer at a financial technology company.". It sounds very natural and professional.',
                        'id' => 'Frasa: "I work as a software engineer at a financial technology company.". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Work and Professions memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Work and Professions ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Work and Professions?',
                    'Seberapa sering kamu membahas tentang Work and Professions dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Work and Professions Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Work and Professions membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            11 => [
                'topic' => 'Education and Learning',
                'focus' => 'School subjects, past learning experiences, self-improvement',
                'listening' => [
                    'title' => 'Listening Practice: Education and Learning',
                    'audio_script' => 'Education is a lifelong journey of curiosity and growth. When I was in university, I participated actively in international student exchange programs and English debate competitions. Those enriching experiences helped me cultivate strong critical thinking and articulate public speaking skills.',
                    'key_phrases' => [
                        'I graduated with a bachelor degree in English literature and education.',
                        'She studied foreign languages diligently during her school years.',
                        'A dedicated mentor can inspire students to achieve their greatest potential.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Education and Learning',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Education and Learning',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'I graduated with a bachelor degree in English literature and education.',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'I graduated with a bachelor degree in English literature and education.',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering education and learning?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I graduated with a bachelor degree in English literature and education.',
                        'id' => 'Saya lulus dengan gelar sarjana sastra Inggris dan pendidikan.',
                    ],
                    [
                        'en' => 'She studied foreign languages diligently during her school years.',
                        'id' => 'Dia belajar bahasa asing dengan tekun selama masa sekolahnya.',
                    ],
                    [
                        'en' => 'A dedicated mentor can inspire students to achieve their greatest potential.',
                        'id' => 'Seorang mentor yang berdedikasi dapat menginspirasi siswa untuk mencapai potensi terbesar mereka.',
                    ],
                    [
                        'en' => 'Active listening and speaking practice are the keys to language mastery.',
                        'id' => 'Latihan menyimak dan berbicara aktif adalah kunci penguasaan bahasa.',
                    ],
                    [
                        'en' => 'Cultivating a curious mindset empowers lifelong personal achievement.',
                        'id' => 'Menumbuhkan pola pikir penuh rasa ingin tahu mendorong pencapaian pribadi seumur hidup.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about education and learning with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang education and learning dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Past Simple Tense: Regular (-ed) and Irregular verbs for finished events',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Education and Learning dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Education and Learning today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Education and Learning hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for education and learning makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk education and learning membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "I graduated with a bachelor degree in English literature and education.". It sounds very natural and professional.',
                        'id' => 'Frasa: "I graduated with a bachelor degree in English literature and education.". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Education and Learning memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Education and Learning ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Education and Learning?',
                    'Seberapa sering kamu membahas tentang Education and Learning dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Education and Learning Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Education and Learning membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            12 => [
                'topic' => 'Technology and Communication',
                'focus' => 'Gadgets, internet vocabulary, AI and future trends',
                'listening' => [
                    'title' => 'Listening Practice: Technology and Communication',
                    'audio_script' => 'Technological innovation plays an indispensable role in shaping modern civilization. From artificial intelligence tools that automate routine workflows to cloud collaboration platforms that connect global teams, digital technology enables us to accomplish complex tasks faster and more efficiently.',
                    'key_phrases' => [
                        'I rely on my smartphone and laptop for daily remote communication.',
                        'Artificial intelligence will revolutionize personalized online education.',
                        'We must safeguard our digital accounts with strong authentication.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Technology and Communication',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Technology and Communication',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'I rely on my smartphone and laptop for daily remote communication.',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'I rely on my smartphone and laptop for daily remote communication.',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering technology and communication?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I rely on my smartphone and laptop for daily remote communication.',
                        'id' => 'Saya mengandalkan ponsel pintar dan laptop untuk komunikasi jarak jauh harian.',
                    ],
                    [
                        'en' => 'Artificial intelligence will revolutionize personalized online education.',
                        'id' => 'Kecerdasan buatan akan merevolusi pendidikan online yang dipersonalisasi.',
                    ],
                    [
                        'en' => 'We must safeguard our digital accounts with strong authentication.',
                        'id' => 'Kita harus mengamankan akun digital kita dengan autentikasi yang kuat.',
                    ],
                    [
                        'en' => 'Digital productivity tools help streamline collaborative project workflows.',
                        'id' => 'Alat produktivitas digital membantu merampingkan alur kerja proyek kolaboratif.',
                    ],
                    [
                        'en' => 'Taking regular breaks from digital screens promotes mental clarity.',
                        'id' => 'Mengambil jeda rutin dari layar digital meningkatkan kejernihan pikiran.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about technology and communication with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang technology and communication dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Future predictions: Will + V1 vs Be going to + V1 for intentions',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Technology and Communication dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Technology and Communication today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Technology and Communication hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for technology and communication makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk technology and communication membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "I rely on my smartphone and laptop for daily remote communication.". It sounds very natural and professional.',
                        'id' => 'Frasa: "I rely on my smartphone and laptop for daily remote communication.". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Technology and Communication memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Technology and Communication ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Technology and Communication?',
                    'Seberapa sering kamu membahas tentang Technology and Communication dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Technology and Communication Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Technology and Communication membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            13 => [
                'topic' => 'Environment and Weather',
                'focus' => 'Climate, weather descriptions, eco-friendly habits, conservation',
                'listening' => [
                    'title' => 'Listening Practice: Environment and Weather',
                    'audio_script' => 'Protecting our natural environment begins with mindful everyday choices. In my local community, residents actively participate in tree planting initiatives and plastic recycling programs. By conserving electricity and supporting renewable energy, we contribute to a greener planet.',
                    'key_phrases' => [
                        'Indonesia has a tropical climate characterized by dry and wet seasons.',
                        'We should reduce single-use plastics to protect marine ecosystems.',
                        'Transitioning to renewable solar and wind energy reduces carbon emissions.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Environment and Weather',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Environment and Weather',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'Indonesia has a tropical climate characterized by dry and wet seasons.',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'Indonesia has a tropical climate characterized by dry and wet seasons.',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering environment and weather?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Indonesia has a tropical climate characterized by dry and wet seasons.',
                        'id' => 'Indonesia memiliki iklim tropis yang ditandai dengan musim kemarau dan hujan.',
                    ],
                    [
                        'en' => 'We should reduce single-use plastics to protect marine ecosystems.',
                        'id' => 'Kita harus mengurangi plastik sekali pakai untuk melindungi ekosistem laut.',
                    ],
                    [
                        'en' => 'Transitioning to renewable solar and wind energy reduces carbon emissions.',
                        'id' => 'Beralih ke energi surya dan angin terbarukan mengurangi emisi karbon.',
                    ],
                    [
                        'en' => 'Community cleanup drives foster environmental awareness and civic pride.',
                        'id' => 'Gerakan bersih-bersih lingkungan menumbuhkan kesadaran lingkungan dan kebanggaan warga.',
                    ],
                    [
                        'en' => 'Small eco-friendly habits practiced consistently create lasting global impact.',
                        'id' => 'Kebiasaan ramah lingkungan kecil yang dipraktikkan secara konsisten menciptakan dampak global yang langgeng.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about environment and weather with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang environment and weather dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Describing Weather: It is sunny/rainy/windy vs The weather is warm/humid',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Environment and Weather dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Environment and Weather today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Environment and Weather hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for environment and weather makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk environment and weather membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "Indonesia has a tropical climate characterized by dry and wet seasons.". It sounds very natural and professional.',
                        'id' => 'Frasa: "Indonesia has a tropical climate characterized by dry and wet seasons.". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Environment and Weather memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Environment and Weather ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Environment and Weather?',
                    'Seberapa sering kamu membahas tentang Environment and Weather dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Environment and Weather Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Environment and Weather membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            14 => [
                'topic' => 'Culture and Traditions',
                'focus' => 'Festivals, heritage, customary celebrations, intercultural dialogue',
                'listening' => [
                    'title' => 'Listening Practice: Culture and Traditions',
                    'audio_script' => 'Indonesia is celebrated worldwide for its rich cultural diversity and ancient customs. During major festive holidays like Eid and Independence Day, families travel long distances to reunite, cook traditional delicacies, and celebrate the timeless values of mutual cooperation and unity in diversity.',
                    'key_phrases' => [
                        'Indonesia preserves hundreds of distinctive regional languages and arts.',
                        'We wear traditional batik and regional costumes during official celebrations.',
                        'Gotong royong embodies the spirit of solidarity and communal cooperation.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Culture and Traditions',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Culture and Traditions',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'Indonesia preserves hundreds of distinctive regional languages and arts.',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'Indonesia preserves hundreds of distinctive regional languages and arts.',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering culture and traditions?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Indonesia preserves hundreds of distinctive regional languages and arts.',
                        'id' => 'Indonesia melestarikan ratusan bahasa dan kesenian daerah yang khas.',
                    ],
                    [
                        'en' => 'We wear traditional batik and regional costumes during official celebrations.',
                        'id' => 'Kami mengenakan batik tradisional dan busana daerah saat perayaan resmi.',
                    ],
                    [
                        'en' => 'Gotong royong embodies the spirit of solidarity and communal cooperation.',
                        'id' => 'Gotong royong melambangkan semangat solidaritas dan kerja sama masyarakat.',
                    ],
                    [
                        'en' => 'Warm hospitality and kindness to strangers are core cultural values.',
                        'id' => 'Keramahan yang hangat dan kebaikan kepada orang asing adalah nilai budaya utama.',
                    ],
                    [
                        'en' => 'Embracing multicultural dialogue builds mutual understanding across nations.',
                        'id' => 'Merangkul dialog multikultural membangun saling pengertian lintas bangsa.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about culture and traditions with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang culture and traditions dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Cultural expressions: Ancestral heritage, customary rituals, mutual cooperation, festive banquets',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Culture and Traditions dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Culture and Traditions today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Culture and Traditions hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for culture and traditions makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk culture and traditions membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "Indonesia preserves hundreds of distinctive regional languages and arts.". It sounds very natural and professional.',
                        'id' => 'Frasa: "Indonesia preserves hundreds of distinctive regional languages and arts.". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Culture and Traditions memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Culture and Traditions ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Culture and Traditions?',
                    'Seberapa sering kamu membahas tentang Culture and Traditions dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Culture and Traditions Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Culture and Traditions membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
            15 => [
                'topic' => 'Review and Final Assessment',
                'focus' => 'Comprehensive evaluation, speaking exam simulation, fluency checklist',
                'listening' => [
                    'title' => 'Listening Practice: Review and Final Assessment',
                    'audio_script' => 'Congratulations on successfully completing all fifteen meetings of the Introductory Speaking program! Throughout this course, you have built a solid foundation in daily conversation, pronunciation accuracy, grammatical structures, and spontaneous speech. You are now prepared to speak English with confidence in diverse real-world situations.',
                    'key_phrases' => [
                        'I can express my ideas and opinions in English fluently without hesitation.',
                        'I have acquired rich vocabulary across a wide spectrum of daily topics.',
                        'I construct accurate sentences using appropriate tenses and prepositions.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the primary subject matter of this audio listening passage?',
                            'options' => [
                                'Review and Final Assessment',
                                'Aerospace Engineering',
                                'Deep Marine Biology',
                                'Automotive Manufacturing',
                            ],
                            'answer' => 'Review and Final Assessment',
                        ],
                        [
                            'q' => 'Which key idea is highlighted by the speaker?',
                            'options' => [
                                'I can express my ideas and opinions in English fluently without hesitation.',
                                'Total disinterest',
                                'Frequent complaining',
                                'Ignoring instructions',
                            ],
                            'answer' => 'I can express my ideas and opinions in English fluently without hesitation.',
                        ],
                        [
                            'q' => 'What positive outcome results from mastering review and final assessment?',
                            'options' => [
                                'Enhanced fluency and articulate communication',
                                'Severe confusion',
                                'Loss of confidence',
                                'Reduced speaking ability',
                            ],
                            'answer' => 'Enhanced fluency and articulate communication',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I can express my ideas and opinions in English fluently without hesitation.',
                        'id' => 'Saya dapat menyampaikan ide dan pendapat dalam bahasa Inggris dengan lancar tanpa ragu.',
                    ],
                    [
                        'en' => 'I have acquired rich vocabulary across a wide spectrum of daily topics.',
                        'id' => 'Saya telah memperoleh kosakata yang kaya di berbagai topik harian.',
                    ],
                    [
                        'en' => 'I construct accurate sentences using appropriate tenses and prepositions.',
                        'id' => 'Saya menyusun kalimat yang akurat menggunakan tenses dan preposisi yang tepat.',
                    ],
                    [
                        'en' => 'My pronunciation and intonation are clear and pleasant to listen to.',
                        'id' => 'Pelafalan dan intonasi saya jelas dan nyaman untuk didengarkan.',
                    ],
                    [
                        'en' => 'This completion marks the beginning of my continuous English speaking journey.',
                        'id' => 'Kelulusan ini menandai awal dari perjalanan berbicara bahasa Inggris saya yang berkelanjutan.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing thoughts about review and final assessment with clarity.',
                        'id' => 'Kami selalu berlatih menyampaikan pemikiran tentang review and final assessment dengan jelas.',
                    ],
                    [
                        'en' => 'She usually asks constructive questions to deepen group discussions.',
                        'id' => 'Dia biasanya mengajukan pertanyaan konstruktif untuk memperdalam diskusi kelompok.',
                    ],
                    [
                        'en' => 'I often shadow native speakers to refine my natural rhythm and pronunciation.',
                        'id' => 'Saya sering menirukan penutur asli untuk menyempurnakan ritme alami dan pelafalan saya.',
                    ],
                    [
                        'en' => 'They rarely feel anxious when speaking English in front of new acquaintances.',
                        'id' => 'Mereka jarang merasa cemas saat berbicara bahasa Inggris di depan kenalan baru.',
                    ],
                    [
                        'en' => 'He sometimes records his speaking responses to assess grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon berbicaranya untuk menilai ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Speaking Assessment Criteria: Fluency & Coherence, Lexical Resource, Grammatical Accuracy, Pronunciation',
                'dialogue_setting' => 'Dua orang mendiskusikan topik Review and Final Assessment dalam suasana santai dan interaktif.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'How do you feel about our discussion on Review and Final Assessment today?',
                        'id' => 'Bagaimana pendapatmu tentang diskusi kita mengenai Review and Final Assessment hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I find it very insightful! Learning practical phrases for review and final assessment makes speaking much easier.',
                        'id' => 'Menurut saya sangat bermanfaat! Mempelajari frasa praktis untuk review and final assessment membuat berbicara jauh lebih mudah.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which key expression resonated most with you during the lesson?',
                        'id' => 'Ungkapan kunci mana yang paling berkesan untukmu selama pelajaran?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'The phrase: "I can express my ideas and opinions in English fluently without hesitation.". It sounds very natural and professional.',
                        'id' => 'Frasa: "I can express my ideas and opinions in English fluently without hesitation.". Terdengar sangat natural dan profesional.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Review and Final Assessment memberikan wawasan yang luas dan keterampilan praktis dalam percakapan sehari-hari. Saya belajar menyusun kalimat secara runtut dan mengekspresikan pendapat dengan percaya diri.',
                    'Dengan mempraktikkan kosakata dan mendengarkan contoh penutur asli secara rutin, kemampuan berbicara bahasa Inggris saya berkembang pesat.',
                ],
                'monolog_tidak_baku' => [
                    'Topik Review and Final Assessment ini seru banget dipelajari bareng tutor dan temen-temen. Banyak frasa gaul dan ekspresi natural yang bisa langsung gue pake pas ngobrol.',
                    'Gue ngerasa sekarang jauh lebih rileks dan gak takut salah lagi pas ngomong bahasa Inggris. Kuncinya emang konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Apa yang pertama kali terlintas di pikiranmu tentang topik Review and Final Assessment?',
                    'Seberapa sering kamu membahas tentang Review and Final Assessment dalam kehidupan sehari-hari?',
                    'Kosakata baru apa yang paling menarik perhatianmu di meeting ini?',
                    'Kamu lebih nyaman belajar topik ini lewat audio percakapan atau studi kasus?',
                    'Ceritakan satu pengalaman menarik yang pernah kamu alami terkait topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa tantangan terbesar saat mengekspresikan topik ini dalam bahasa Inggris?',
                    'Bagaimana caramu menerapkan kosakata meeting ini ke dalam percakapan nyata?',
                    'Siapa orang yang paling sering kamu ajak bertukar pikiran tentang topik ini?',
                    'Apa strategi terbaikmu dalam memperluas perbendaharaan kosakata harian?',
                ],
                'impromptu_title' => 'Pertanyaan Lebih Sulit – Review and Final Assessment Mastery',
                'impromptu' => [
                    'Bagaimana penguasaan topik Review and Final Assessment membantumu berkomunikasi lebih efektif di lingkungan profesional maupun sosial?',
                    'Jelaskan langkah-langkah yang kamu ambil untuk menyusun pidato singkat secara spontan dalam bahasa Inggris.',
                    'Bagaimana cara kamu mengelola rasa cemas ketika harus berinteraksi dengan penutur asing?',
                    'Ceritakan sebuah pencapaian yang membuktikan bahwa konsistensi belajar membawa perubahan besar dalam hidupmu.',
                ],
            ],
        ];

        return $data[$meeting] ?? $data[1];
    }

    private function getIntermediateMeetingContent(int $meeting): array
    {
        $data = [
            1 => [
                'topic' => 'Introduction and Greetings',
                'focus' => 'Greetings & Farewells, Basic Self-Introduction, Personal Pronouns & To Be, Likes & Hobbies',
                'materi' => [
                    'greetings' => [
                        'formal' => [
                            ['en' => 'Good morning', 'id' => 'Selamat pagi (06:00 - 12:00)'],
                            ['en' => 'Good afternoon', 'id' => 'Selamat siang / sore (12:00 - 18:00)'],
                            ['en' => 'Good evening', 'id' => 'Selamat malam (18:00+)'],
                        ],
                        'informal' => [
                            ['en' => 'Hi!', 'id' => 'Hai!'],
                            ['en' => 'Hey! How\'s it going?', 'id' => 'Hei! Bagaimana kabarmu?'],
                        ],
                        'closing' => [
                            ['en' => 'Goodbye', 'id' => 'Selamat tinggal / Sampai jumpa'],
                            ['en' => 'See you later', 'id' => 'Sampai jumpa lagi nanti'],
                            ['en' => 'Have a nice day', 'id' => 'Semoga harimu menyenangkan'],
                        ]
                    ],
                    'self_intro_templates' => [
                        ['label' => 'Name', 'pattern' => 'My name is [Name] / I\'m [Name]', 'example' => 'My name is Budi Sugeng / I\'m Budi.'],
                        ['label' => 'Age', 'pattern' => 'I am [number] years old', 'example' => 'I am 20 years old.'],
                        ['label' => 'Origin', 'pattern' => 'I am from [Country/City]', 'example' => 'I am from Jakarta, Indonesia.'],
                        ['label' => 'Profession', 'pattern' => 'I am a/an [Profession]', 'example' => 'I am an English teacher.'],
                    ],
                    'grammar_basics' => [
                        'subject_pronouns' => ['I', 'You', 'He', 'She', 'It', 'We', 'They'],
                        'to_be_conjugations' => [
                            ['subject' => 'I', 'to_be' => 'am', 'contraction' => 'I\'m', 'example' => 'I am a teacher.'],
                            ['subject' => 'You', 'to_be' => 'are', 'contraction' => 'You\'re', 'example' => 'You are my student.'],
                            ['subject' => 'We', 'to_be' => 'are', 'contraction' => 'We\'re', 'example' => 'We are in the classroom.'],
                            ['subject' => 'They', 'to_be' => 'are', 'contraction' => 'They\'re', 'example' => 'They are friendly.'],
                            ['subject' => 'He', 'to_be' => 'is', 'contraction' => 'He\'s', 'example' => 'He is 20 years old.'],
                            ['subject' => 'She', 'to_be' => 'is', 'contraction' => 'She\'s', 'example' => 'She is from Jakarta.'],
                            ['subject' => 'It', 'to_be' => 'is', 'contraction' => 'It\'s', 'example' => 'It is nice to meet you.'],
                        ]
                    ],
                    'likes_hobbies' => [
                        'patterns' => ['I like + [Noun / V-ing]', 'I don\'t like + [Noun / V-ing]', 'I enjoy + [V-ing]'],
                        'examples' => [
                            ['en' => 'I like reading books.', 'id' => 'Saya suka membaca buku.'],
                            ['en' => 'I enjoy playing football.', 'id' => 'Saya menikmati bermain sepak bola.'],
                            ['en' => 'I don\'t like waking up late.', 'id' => 'Saya tidak suka bangun terlambat.'],
                        ]
                    ],
                    'template' => "Hello everyone! Good morning.

My name is [Full Name]. I am [Age] years old. You can call me [Nick Name].

I am from [City/Country].

I am a/an [Profession].

In my free time, I like [Hobbies/Likes].

It is nice to meet you all. Thank you!",
                    'example' => "Hello! Good morning. How's it going?

My name is Student A. I am 20 years old.

I am from Jakarta, Indonesia, and I am an English teacher.

In my free time, I like reading books and playing football.

It is very nice to meet you all. Have a nice day!"
                ],
                'listening' => [
                    'title' => 'Short Listening: Student Introduction & Dialogue Practice',
                    'audio_script' => "Student A: Hello! Good morning. How's it going? Student B: Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name? Student A: My name is Student A. I'm 20 years old. Where are you from, Student B? Student B: I am from Sydney, Australia. I am an English instructor. What is your profession, Student A? Student A: I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football. Student B: That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A! Student A: It is nice to meet you too, Student B! Have a nice day and see you later!",
                    'key_phrases' => [
                        'How\'s it going? Everything is going great, thank you!',
                        'I am from Sydney, Australia. I am an English instructor.',
                        'I am an English teacher from Jakarta, Indonesia.',
                        'In my free time, I like reading books and playing football.',
                        'That is wonderful! I enjoy hiking in the mountains.',
                        'It is nice to meet you too! Have a nice day and see you later!',
                    ],
                    'questions' => [
                        [
                            'q' => 'Where is Student B from and what is her profession?',
                            'options' => [
                                'From Sydney, Australia; English instructor',
                                'From Jakarta, Indonesia; English teacher',
                                'From Bandung, Indonesia; Doctor',
                                'From London, UK; Engineer',
                            ],
                            'answer' => 'From Sydney, Australia; English instructor',
                        ],
                        [
                            'q' => 'Where is Student A from and what is his profession?',
                            'options' => [
                                'From Jakarta, Indonesia; English teacher',
                                'From Sydney, Australia; English instructor',
                                'From Tokyo, Japan; Pilot',
                                'From Melbourne, Australia; Doctor',
                            ],
                            'answer' => 'From Jakarta, Indonesia; English teacher',
                        ],
                        [
                            'q' => 'What hobbies are mentioned by Student A and Student B?',
                            'options' => [
                                'Student A likes reading & football; Student B enjoys hiking',
                                'Student A likes swimming; Student B likes cooking',
                                'Both students like playing video games',
                                'Student A likes dancing; Student B likes singing',
                            ],
                            'answer' => 'Student A likes reading & football; Student B enjoys hiking',
                        ],
                    ],
                ],
                'drilling1' => [
                    ['en' => 'Hello everyone! Good morning, my name is Student A.', 'id' => 'Halo semuanya! Selamat pagi, nama saya Student A.'],
                    ['en' => 'I am twenty years old, and you can call me Student A.', 'id' => 'Saya berumur dua puluh tahun, dan Anda bisa memanggil saya Student A.'],
                    ['en' => 'I am from Jakarta, Indonesia, and I am an English teacher.', 'id' => 'Saya berasal dari Jakarta, Indonesia, dan saya seorang guru bahasa Inggris.'],
                    ['en' => 'In my free time, I like reading books and playing football.', 'id' => 'Di waktu luang saya, saya suka membaca buku dan bermain sepak bola.'],
                    ['en' => 'It is very nice to meet all of you today.', 'id' => 'Sangat senang bertemu dengan Anda semua hari ini.'],
                ],
                'drilling2' => [
                    ['en' => 'Hi! Good morning. How\'s it going? Everything is going great, thank you!', 'id' => 'Hai! Selamat pagi. Bagaimana kabarmu? Semuanya baik-baik saja, terima kasih!'],
                    ['en' => 'I am from Sydney, Australia, and I am an English instructor.', 'id' => 'Saya berasal dari Sydney, Australia, dan saya seorang instruktur bahasa Inggris.'],
                    ['en' => 'What is your profession, and where are you from, Student A?', 'id' => 'Apa profesimu, dan dari mana asalmu, Student A?'],
                    ['en' => 'That is wonderful! In my free time, I enjoy hiking in the mountains.', 'id' => 'Luar biasa! Di waktu luang, saya menikmati mendaki gunung.'],
                    ['en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!', 'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!'],
                ],
                'grammar_note' => "Subject Pronouns (I, You, He, She, It, We, They) & Verb 'To Be' (am / is / are) | Contractions: I'm, You're, He's, She's, It's, We're, They're",
                'dialogue_setting' => 'Dua peserta kursus, Student A dan Student B, saling berkenalan di hari pertama kelas First Point Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Student A',
                        'en' => 'Hello! Good morning. How\'s it going?',
                        'id' => 'Halo! Selamat pagi. Bagaimana kabarmu?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name?',
                        'id' => 'Hai! Selamat pagi. Semuanya baik-baik saja, terima kasih! Nama saya Student B. Siapa nama kamu?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'My name is Student A. I\'m 20 years old. Where are you from, Student B?',
                        'id' => 'Nama saya Student A. Saya berumur 20 tahun. Dari mana asalmu, Student B?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'I am from Sydney, Australia. I am an English instructor. What is your profession, Student A?',
                        'id' => 'Saya berasal dari Sydney, Australia. Saya seorang instruktur bahasa Inggris. Apa profesimu, Student A?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football.',
                        'id' => 'Saya seorang guru bahasa Inggris dari Jakarta, Indonesia. Di waktu luang, saya suka membaca buku dan bermain sepak bola.',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A!',
                        'id' => 'Luar biasa! Saya menikmati mendaki gunung. Sangat senang berkenalan denganmu, Student A!',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!',
                        'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!',
                    ],
                ],
                'games' => [
                    [
                        'title' => 'Game 1: 60-Second Speed Meet (Tanya Jawab Kilat)',
                        'participation_type' => 'pair',
                        'instructions' => 'Dalam 60 detik, tanyakan 4 info dasar pasanganmu: Nama lengkap, Umur, Kota asal, dan 1 Hobi favoritnya!',
                        'prompts' => ['What is your name and nickname?', 'How old are you?', 'Where are you from?', 'What do you like doing in your free time?']
                    ],
                    [
                        'title' => 'Game 2: Two Truths and One Wish (Tebak Hobi)',
                        'participation_type' => 'pair',
                        'instructions' => 'Sebutkan 2 kalimat hobi yang benar-benar kamu sukai dan 1 hobi khayalan. Pasanganmu harus menebak mana yang khayalan!',
                        'prompts' => ['1. I like reading books.', '2. I enjoy playing football.', '3. I like climbing Mount Everest every weekend. (Which one is the wish?)']
                    ],
                    [
                        'title' => 'Game 3: Pronoun Switch Challenge (Kenalkan Temanmu)',
                        'participation_type' => 'pair',
                        'instructions' => 'Ganti subjek "I am" menjadi "He is / She is" saat memperkenalkan pasanganmu ke hadapan seluruh kelas!',
                        'prompts' => ['"This is my friend Budi. He is 20 years old. He is from Jakarta. In his free time, he likes playing football."']
                    ]
                ],
                'monolog_baku' => [
                    "Hello everyone! Good morning. My name is Budi Sugeng. I am 20 years old. You can call me Budi. I am from Jakarta, Indonesia. I am an English teacher. In my free time, I like reading books and playing football. It is nice to meet you all. Thank you!",
                    "Good afternoon, ladies and gentlemen. I am delighted to introduce myself. My name is Sarah Miller, and I am from Sydney, Australia. I work as an instructor, and I enjoy reading historical novels in my leisure time. It is a pleasure to meet everyone."
                ],
                'monolog_tidak_baku' => [
                    "Hi guys! Hey, how's it going? I'm Budi, 20 years old from Jakarta. I teach English and in my spare time I really love hanging out with friends and playing football. Super stoked to meet you all!",
                    "Hey everyone! What's up? I'm Sarah from Sydney. I'm into reading and outdoor hiking when I'm not working. Great to be here with you guys!"
                ],
                'questions_part_a' => [
                    'What is your full name and what is your nickname?',
                    'How old are you?',
                    'Where are you from (City & Country)?',
                    'What is your current profession or field of study?',
                    'What do you like doing in your free time?',
                ],
                'questions_part_b' => [
                    'How do you greet someone formally in the morning, afternoon, and evening?',
                    'What is the difference between "I like reading" and "I don\'t like reading"?',
                    'Can you introduce your best friend using "He is..." or "She is..."?',
                    'How do you say goodbye politely to your teacher at the end of class?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Complete Self-Introduction Showcase',
                'impromptu' => [
                    'Aktivitas 1: Sampaikan perkenalan diri lengkapmu tanpa membaca teks selama 60 detik mengikuti template Budi Sugeng!',
                    'Aktivitas 2: Lakukan perkenalan santai (informal greeting) seolah-olah kamu sedang berkenalan di kafe internasional.',
                    'Aktivitas 3: Jelaskan 3 hal yang paling kamu sukai (likes) dan 2 hal yang tidak kamu sukai (dislikes) dalam kehidupan sehari-hari.',
                    'Aktivitas 4: Rekam suaramu pada fitur Voice Recorder di bawah dan dengarkan kembali intonasimu!',
                ],
            ],
            2 => [
                'topic' => 'Polite request & Making suggestion',
                'focus' => 'Polite requests (Could you, Would you mind, May I), suggestions (Let\'s, Why don\'t we, Shall I/we), would like, Health vocabulary',
                'listening' => [
                    'title' => 'Listening Practice: Doctor Consultation & Health Advice',
                    'audio_script' => 'Good morning, doctor. Could you please take a look at my throat? I have been feeling feverish and exhausted since yesterday. Doctor: Certainly. Would you mind opening your mouth wide? Hmm, your tonsils look inflamed. Why don\'t you take this prescription and rest for three full days? Shall we schedule a follow-up visit next Monday?',
                    'key_phrases' => [
                        'Could you please take a look...?',
                        'Would you mind opening your mouth?',
                        'Why don\'t you rest for three days?',
                    ],
                    'questions' => [
                        [
                            'q' => 'What polite request did the patient make to the doctor?',
                            'options' => [
                                'Could you please take a look at my throat?',
                                'Give me medicine now!',
                                'I want to go home.',
                                'Can you pay for my bill?',
                            ],
                            'answer' => 'Could you please take a look at my throat?',
                        ],
                        [
                            'q' => 'What did the doctor suggest the patient do?',
                            'options' => [
                                'Take the prescription and rest for three days',
                                'Go swimming in cold water',
                                'Run a marathon',
                                'Eat spicy street food',
                            ],
                            'answer' => 'Take the prescription and rest for three days',
                        ],
                        [
                            'q' => 'What is the tone of the conversation?',
                            'options' => [
                                'Polite, professional, and empathetic',
                                'Angry and hostile',
                                'Sarcastic and careless',
                                'Confused',
                            ],
                            'answer' => 'Polite, professional, and empathetic',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Could you please pass me the medical report?',
                        'id' => 'Bisakah kamu tolong berikan laporan medis itu kepada saya?',
                    ],
                    [
                        'en' => 'Would you mind waiting in the consultation room for a moment?',
                        'id' => 'Apakah kamu keberatan menunggu di ruang konsultasi sebentar?',
                    ],
                    [
                        'en' => 'Why don\'t we consult a nutritionist regarding a balanced diet?',
                        'id' => 'Mengapa kita tidak berkonsultasi dengan ahli gizi mengenai pola makan seimbang?',
                    ],
                    [
                        'en' => 'Shall I schedule an appointment with the cardiologist for you?',
                        'id' => 'Haruskah saya buatkan jadwal temu dengan dokter spesialis jantung untukmu?',
                    ],
                    [
                        'en' => 'I would like to have a comprehensive health screening.',
                        'id' => 'Saya ingin melakukan pemeriksaan kesehatan menyeluruh.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'Could you do me a favor and fetch some warm water for the patient?',
                        'id' => 'Bisakah kamu tolong bantu saya mengambilkan air hangat untuk pasien?',
                    ],
                    [
                        'en' => 'Let\'s take preventive measures before the flu season peaks.',
                        'id' => 'Mari kita ambil langkah pencegahan sebelum musim flu mencapai puncaknya.',
                    ],
                    [
                        'en' => 'Would you like some herbal tea to soothe your sore throat?',
                        'id' => 'Apakah Anda ingin teh herbal untuk meredakan radang tenggorokan Anda?',
                    ],
                    [
                        'en' => 'Why don\'t we cut down on sugary drinks to improve our energy levels?',
                        'id' => 'Mengapa kita tidak mengurangi minuman manis untuk meningkatkan energi kita?',
                    ],
                    [
                        'en' => 'Shall we go for a gentle walk to stimulate our blood circulation?',
                        'id' => 'Haruskah kita jalan santai untuk melancarkan sirkulasi darah?',
                    ],
                ],
                'grammar_note' => 'Polite Requests: \'Would you mind + V-ing?\' (Answer: \'Not at all / Sure\') | Suggestions: Let\'s + V1 / Why don\'t we + V1 / Shall we + V1',
                'dialogue_setting' => 'Di sebuah apotek, apoteker memberikan saran obat dan saran gaya hidup sehat kepada pelanggan.',
                'dialogue' => [
                    [
                        'speaker' => 'Pharmacist',
                        'en' => 'Good afternoon! How may I assist you today?',
                        'id' => 'Selamat siang! Ada yang bisa saya bantu hari ini?',
                    ],
                    [
                        'speaker' => 'Customer',
                        'en' => 'Could you recommend something effective for persistent migraines?',
                        'id' => 'Bisakah Anda merekomendasikan obat yang efektif untuk migrain yang tak kunjung sembuh?',
                    ],
                    [
                        'speaker' => 'Pharmacist',
                        'en' => 'Certainly. Why don\'t you try this herbal supplement? Also, would you mind drinking at least two liters of water daily?',
                        'id' => 'Tentu. Mengapa Anda tidak mencoba suplemen herbal ini? Dan apakah Anda keberatan minum setidaknya dua liter air setiap hari?',
                    ],
                    [
                        'speaker' => 'Customer',
                        'en' => 'I will definitely follow your advice. Shall I take this tablet after meals?',
                        'id' => 'Saya pasti akan mengikuti saran Anda. Haruskah saya minum tablet ini setelah makan?',
                    ],
                ],
                'monolog_baku' => [
                    'Mengajukan permintaan secara sopan adalah keterampilan komunikasi yang sangat penting dalam dunia kerja dan kesehatan. Menggunakan ungkapan seperti \'Could you please\' atau \'Would you mind\' mencerminkan rasa hormat kepada lawan bicara.',
                    'Menjaga kesehatan fisik tidak hanya bergantung pada konsumsi obat saat sakit, melainkan juga melalui pola makan bergizi, olahraga teratur, dan istirahat yang cukup untuk mencegah penyakit kronis.',
                ],
                'monolog_tidak_baku' => [
                    'Kalo lagi butuh bantuan orang lain, mending pake bahasa yang santun biar orang lain juga seneng ngebantunya.',
                    'Kalo udah ngerasa badan drop, gue biasanya langsung stop begadang, minum banyak air putih anget, dan minum vitamin biar gak makin drop.',
                ],
                'questions_part_a' => [
                    'Bagaimana cara kamu meminta bantuan secara sopan kepada seniormu di kantor atau sekolah?',
                    'Apa saran kesehatan yang paling sering kamu berikan kepada teman yang sedang sakit?',
                    'Apakah kamu lebih suka saran langsung (Why don\'t we...) atau saran halus (Perhaps we could...)?',
                    'Bagaimana responmu jika seseorang bertanya "Would you mind helping me?"',
                    'Apa yang biasanya kamu lakukan ketika merasa gejala flu mulai menyerang?',
                ],
                'questions_part_b' => [
                    'Pernahkah kamu melakukan negosiasi (hard bargaining) saat membeli sesuatu? Ceritakan!',
                    'Seberapa sering kamu memeriksakan kesehatan ke dokter atau klinik?',
                    'Apa minuman sehat favoritmu ketika tenggorokan terasa kurang nyaman?',
                    'Bagaimana caramu menolak permintaan seseorang secara halus tanpa membuatnya tersinggung?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Polite Requests & Sweet Talk Simulation',
                'impromptu' => [
                    'Aktivitas "Do Me a Favor": Lakukan simulasi meminta 3 hal penting kepada rekan kerjamu dengan variasi frasa permintaan sopan yang berbeda.',
                    'Bagaimana kamu meyakinkan seseorang yang enggan berolahraga agar mau memulai gaya hidup sehat (Sweet Talk)?',
                    'Diskusikan pentingnya etika berbahasa dalam pelayanan kesehatan dan rumah sakit.',
                    'Bagaimana cara menjaga kesehatan mental ketika menghadapi beban pekerjaan yang sangat tinggi?',
                ],
            ],
            3 => [
                'topic' => 'Expressing necessity, prohibition, & ability',
                'focus' => 'Necessity (must, have to, have got to), lack of necessity & prohibition (don\'t have to, mustn\'t), ability (can, could, be able to), School & Activities',
                'listening' => [
                    'title' => 'Listening Practice: School Rules & Academic Talents',
                    'audio_script' => 'Welcome to the new academic term! As registered students, you have got to attend at least eighty percent of the scheduled lectures. You mustn\'t use mobile phones during examination sessions. However, you don\'t have to wear uniforms on Fridays. If you need academic counseling, you can book an appointment with our advisors online.',
                    'key_phrases' => [
                        'You have got to attend...',
                        'You mustn\'t use mobile phones',
                        'You don\'t have to wear uniforms',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the minimum lecture attendance requirement?',
                            'options' => [
                                'Eighty percent',
                                'Fifty percent',
                                'One hundred percent',
                                'Seventy percent',
                            ],
                            'answer' => 'Eighty percent',
                        ],
                        [
                            'q' => 'What are students strictly prohibited from doing during exams?',
                            'options' => [
                                'Using mobile phones',
                                'Drinking water',
                                'Writing on paper',
                                'Asking the proctor questions',
                            ],
                            'answer' => 'Using mobile phones',
                        ],
                        [
                            'q' => 'What rule applies on Fridays?',
                            'options' => [
                                'Students don\'t have to wear uniforms',
                                'School is closed',
                                'Exams are mandatory',
                                'No homework is allowed',
                            ],
                            'answer' => 'Students don\'t have to wear uniforms',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'All students must submit their research papers before the deadline.',
                        'id' => 'Semua siswa harus mengumpulkan makalah penelitian mereka sebelum tenggat waktu.',
                    ],
                    [
                        'en' => 'You have got to study hard if you want to achieve top grades.',
                        'id' => 'Kamu harus belajar giat jika ingin meraih nilai tertinggi.',
                    ],
                    [
                        'en' => 'You mustn\'t cheat during the standardized test.',
                        'id' => 'Kamu tidak boleh menyontek selama ujian terstandar.',
                    ],
                    [
                        'en' => 'She doesn\'t have to attend the orientation session because she is a senior.',
                        'id' => 'Dia tidak perlu menghadiri sesi orientasi karena dia mahasiswa senior.',
                    ],
                    [
                        'en' => 'He is able to solve advanced mathematical equations effortlessly.',
                        'id' => 'Dia mampu memecahkan persamaan matematika tingkat lanjut dengan mudah.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We have to practice our presentation skills regularly to speak fluently.',
                        'id' => 'Kami harus melatih keterampilan presentasi secara rutin agar lancar berbicara.',
                    ],
                    [
                        'en' => 'You don\'t need to worry about the entrance interview if you prepare well.',
                        'id' => 'Kamu tidak perlu khawatir tentang wawancara masuk jika kamu bersiap dengan baik.',
                    ],
                    [
                        'en' => 'She could play complex violin melodies when she was only seven years old.',
                        'id' => 'Dia bisa memainkan melodi biola yang rumit saat baru berusia tujuh tahun.',
                    ],
                    [
                        'en' => 'Candidates must be able to communicate effectively in both written and spoken English.',
                        'id' => 'Kandidat harus mampu berkomunikasi secara efektif dalam bahasa Inggris lisan maupun tulisan.',
                    ],
                    [
                        'en' => 'Visitors mustn\'t enter the laboratory without safety goggles and lab coats.',
                        'id' => 'Pengunjung dilarang memasuki laboratorium tanpa kacamata pelindung dan jas lab.',
                    ],
                ],
                'grammar_note' => 'Must (personal obligation) vs Have to (external rule) | Mustn\'t (prohibition/dilarang) vs Don\'t have to (tidak harus/optional) | Can / Be able to (ability)',
                'dialogue_setting' => 'Dua siswa SMA, Ryan dan Clara, mendiskusikan peraturan ujian akhir dan persiapan beasiswa.',
                'dialogue' => [
                    [
                        'speaker' => 'Ryan',
                        'en' => 'Clara, do we have to submit the biology project today?',
                        'id' => 'Clara, apakah kita harus mengumpulkan proyek biologi hari ini?',
                    ],
                    [
                        'speaker' => 'Clara',
                        'en' => 'No, we don\'t have to submit it today, but we must finish the draft by tomorrow morning.',
                        'id' => 'Tidak, kita tidak harus mengumpulkannya hari ini, tetapi kita harus menyelesaikan drafnya besok pagi.',
                    ],
                    [
                        'speaker' => 'Ryan',
                        'en' => 'I see! Are you able to help me proofread my chemistry essay tonight?',
                        'id' => 'Begitu ya! Apakah kamu bisa membantuku memeriksa esai kimia malam ini?',
                    ],
                    [
                        'speaker' => 'Clara',
                        'en' => 'Sure! But remember, we mustn\'t copy sources without proper citations.',
                        'id' => 'Tentu! Tapi ingat, kita tidak boleh menyalin sumber tanpa sitasi yang benar.',
                    ],
                ],
                'monolog_baku' => [
                    'Di lingkungan akademik dan dunia profesional, mematuhi peraturan dan tenggat waktu adalah sebuah keharusan. Memahami perbedaan antara kewajiban mutlak (must), larangan ketat (mustn\'t), dan fleksibilitas (don\'t have to) sangat krusial.',
                    'Kemampuan berbicara di depan umum dan berpikir analitis adalah keterampilan yang dapat dikembangkan melalui latihan konsisten. Setiap siswa memiliki potensi untuk menguasai keterampilan baru jika memiliki dedikasi tinggi.',
                ],
                'monolog_tidak_baku' => [
                    'Kalo di kampus gue, absen tuh bener-bener ketat. Lu harus masuk minimal 80% kalo mau ikutan ujian akhir, gak boleh bolos sembarangan.',
                    'Gue ngerasa skill bahasa Inggris itu bukan cuma bakat dari lahir, tapi emang kemampuan yang bisa diasah asal lu konsisten latihan tiap hari.',
                ],
                'questions_part_a' => [
                    'Peraturan apa di sekolah atau kampusmu yang paling ketat dan tidak boleh dilanggar (mustn\'t)?',
                    'Apa keharusan terbesar yang harus kamu selesaikan minggu ini (have to)?',
                    'Keahlian apa yang mampu kamu lakukan sekarang yang dulu tidak bisa kamu lakukan (be able to)?',
                    'Kapan terakhir kali kamu merasa tidak perlu melakukan sesuatu yang biasanya wajib (don\'t have to)?',
                    'Mata pelajaran apa yang paling kamu sukai saat masa sekolah?',
                ],
                'questions_part_b' => [
                    'Bagaimana cara kamu melatih pelafalan kata "hafta" (have to) dan "gotta" (got to) secara natural?',
                    'Apa bakat unik yang kamu miliki yang jarang dimiliki orang lain?',
                    'Menurutmu, apakah seragam sekolah wajib dikenakan oleh seluruh siswa?',
                    'Bagaimana kamu mempersiapkan diri untuk wawancara beasiswa atau pekerjaan?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – My Ideal School & Talent Scouts',
                'impromptu' => [
                    'Aktivitas "My Ideal World / School": Deskripsikan sekolah atau tempat kerja impianmu dengan menjelaskan 3 hal yang WAJIB ada, 3 hal yang DILARANG, dan 3 hal yang BEBAS/TIDAK HARUS dilakukan.',
                    'Simulasi Wawancara Kerja (Job Interview): Ceritakan kemampuan dan keahlian unggulanmu (abilities) yang membuatmu layak diterima di posisi impian.',
                    'Diskusikan bagaimana sistem pendidikan dapat memotivasi siswa untuk mengembangkan bakat mereka secara optimal.',
                    'Bagaimana cara mengatasi hambatan ketika merasa tidak mampu (unable to) menguasai suatu materi yang sulit?',
                ],
            ],
            4 => [
                'topic' => 'Making suggestion, Expectation, Advisability, & Expressing preference',
                'focus' => 'Suggestions (could vs should), Expectation (be supposed to), Advisability (should, ought to, had better), Preference (would rather), Travel & Transport',
                'listening' => [
                    'title' => 'Listening Practice: Travel Itinerary & Flight Advice',
                    'audio_script' => 'Attention passengers for flight GA-402 to Tokyo: You are supposed to board at Gate 5 by 2:30 PM. The weather in Tokyo is reported to be quite chilly, so you had better carry a warm jacket with you. If you prefer quiet surroundings, you would rather select seats in the forward cabin. We wish you a safe and pleasant journey!',
                    'key_phrases' => [
                        'You are supposed to board at Gate 5',
                        'You had better carry a warm jacket',
                        'Would rather select seats...',
                    ],
                    'questions' => [
                        [
                            'q' => 'What are the passengers supposed to do by 2:30 PM?',
                            'options' => [
                                'Board at Gate 5',
                                'Eat lunch at the food court',
                                'Check in their luggage',
                                'Cancel their flight',
                            ],
                            'answer' => 'Board at Gate 5',
                        ],
                        [
                            'q' => 'Why had passengers better carry a warm jacket?',
                            'options' => [
                                'Tokyo weather is reported to be chilly',
                                'It is raining in the terminal',
                                'The airplane has no roof',
                                'Jackets are required by law',
                            ],
                            'answer' => 'Tokyo weather is reported to be chilly',
                        ],
                        [
                            'q' => 'What would passengers who prefer quiet surroundings rather do?',
                            'options' => [
                                'Select seats in the forward cabin',
                                'Sit near the engine',
                                'Stay at the airport',
                                'Travel by train',
                            ],
                            'answer' => 'Select seats in the forward cabin',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'You are supposed to arrive at the airport two hours before departure.',
                        'id' => 'Kamu seharusnya tiba di bandara dua jam sebelum keberangkatan.',
                    ],
                    [
                        'en' => 'You had better check your passport validity before booking international flights.',
                        'id' => 'Kamu sebaiknya memeriksa masa berlaku paspor sebelum memesan penerbangan internasional.',
                    ],
                    [
                        'en' => 'We ought to reserve the train tickets early to get discounted fares.',
                        'id' => 'Kita seharusnya memesan tiket kereta lebih awal untuk mendapatkan harga diskon.',
                    ],
                    [
                        'en' => 'I would rather take the high-speed rail than drive through traffic.',
                        'id' => 'Saya lebih memilih naik kereta cepat daripada menyetir melewati kemacetan.',
                    ],
                    [
                        'en' => 'You could explore the historic district if you have a four-hour layover.',
                        'id' => 'Kamu bisa menjelajahi kawasan bersejarah jika memiliki transit empat jam.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We should follow local customs and etiquette when visiting foreign landmarks.',
                        'id' => 'Kita harus mengikuti adat istiadat dan etika lokal saat mengunjungi tempat bersejarah asing.',
                    ],
                    [
                        'en' => 'He is supposed to lead the city tour group this afternoon.',
                        'id' => 'Dia seharusnya memimpin rombongan tur keliling kota siang ini.',
                    ],
                    [
                        'en' => 'She would rather travel solo because it gives her more flexibility.',
                        'id' => 'Dia lebih memilih bepergian sendiri karena memberikannya lebih banyak fleksibilitas.',
                    ],
                    [
                        'en' => 'You had better not forget your travel insurance documents.',
                        'id' => 'Kamu sebaiknya jangan lupa membawa dokumen asuransi perjalananmu.',
                    ],
                    [
                        'en' => 'Travelers ought to keep digital copies of their important travel vouchers.',
                        'id' => 'Wisatawan seharusnya menyimpan salinan digital dari voucher perjalanan penting mereka.',
                    ],
                ],
                'grammar_note' => 'Be supposed to = expectation based on rule/schedule | Had better = strong urgent advice (or there will be negative consequence) | Would rather + V1 than + V1',
                'dialogue_setting' => 'Di stasiun kereta, dua pelancong merencanakan rute perjalanan terbaik menuju destinasi wisata.',
                'dialogue' => [
                    [
                        'speaker' => 'Danu',
                        'en' => 'The train is supposed to arrive in ten minutes. Have you validated your ticket?',
                        'id' => 'Kereta seharusnya tiba dalam sepuluh menit. Sudahkah kamu validasi tiketmu?',
                    ],
                    [
                        'speaker' => 'Sinta',
                        'en' => 'Yes, all set! Would you rather stop in Yogyakarta first or head straight to Bali?',
                        'id' => 'Ya, sudah beres! Apakah kamu lebih memilih singgah di Yogyakarta dulu atau langsung ke Bali?',
                    ],
                    [
                        'speaker' => 'Danu',
                        'en' => 'I would rather spend two days in Yogyakarta. We could visit the temples and enjoy culinary spots.',
                        'id' => 'Saya lebih memilih menghabiskan dua hari di Yogyakarta. Kita bisa mengunjungi candi dan menikmati kuliner.',
                    ],
                    [
                        'speaker' => 'Sinta',
                        'en' => 'Great idea! We had better book the boutique hotel now before rooms run out.',
                        'id' => 'Ide bagus! Kita sebaiknya pesan hotel butik sekarang sebelum kamar habis.',
                    ],
                ],
                'monolog_baku' => [
                    'Perjalanan ke tempat baru menuntut perencanaan yang matang. Mengetahui jadwal keberangkatan (be supposed to) dan mempersiapkan perlengkapan penting (had better) akan menjamin kenyamanan selama perjalanan.',
                    'Memilih moda transportasi yang sesuai dengan preferensi pribadi (would rather) seperti kereta api atau pesawat terbang akan menghemat waktu dan energi saat menjelajahi tempat wisata.',
                ],
                'monolog_tidak_baku' => [
                    'Kalo traveling jarak jauh, gue lebih milih naik kereta eksekutif daripada nyetir mobil seharian. Capek di jalan bisa bikin liburan gak maksimal.',
                    'Sebelum cabut liburan, lu mendingan pastiin semua dokumen dan bookingan hotel udah aman di HP biar gak ribet pas nyampe lokasi.',
                ],
                'questions_part_a' => [
                    'Jam berapa kamu seharusnya (are supposed to) mulai bekerja atau belajar setiap hari?',
                    'Kamu lebih memilih (would rather) liburan ala backpacker atau liburan santai di resort?',
                    'Apa nasihat penting (had better) yang selalu kamu berikan kepada orang yang baru pertama kali naik pesawat?',
                    'Kamu lebih suka bepergian sendirian (solo traveling) atau bareng rombongan teman?',
                    'Sebutkan satu hal yang seharusnya (ought to) dilakukan semua orang saat berkunjung ke tempat wisata alam!',
                ],
                'questions_part_b' => [
                    'Kamu lebih suka transit lama sambil jalan-jalan atau penerbangan langsung tanpa transit?',
                    'Apa barang bawaan wajib yang sebaiknya jangan sampai ketinggalan saat bepergian?',
                    'Bagaimana cara kamu menangani keterlambatan pesawat (flight delay)?',
                    'Pilihan moda transportasi apa yang paling ramah lingkungan menurutmu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Sound Advice & Sales Rep Pitch',
                'impromptu' => [
                    'Aktivitas "Sales Rep Pitch": Berperanlah sebagai travel consultant yang meyakinkan klien untuk memilih paket liburan terbaik dengan menggunakan "could", "should", "had better", dan "would rather".',
                    'Aktivitas "Sound Advice": Berikan 5 nasihat mendalam untuk seseorang yang akan pindah dan tinggal di luar negeri untuk pertama kalinya.',
                    'Diskusikan bagaimana etika wisatawan dapat mempengaruhi kelestarian destinasi pariwisata lokal.',
                    'Ceritakan keputusan perjalanan terbaik yang pernah kamu ambil dan jelaskan mengapa pilihan tersebut sangat memuaskan.',
                ],
            ],
            5 => [
                'topic' => 'Simple Future, be going to, & Semi Modal',
                'focus' => 'Simple Future (will), be going to (prior plan/evidence), Semi Modal (be about to, be due to), Nature vocabulary',
                'listening' => [
                    'title' => 'Listening Practice: Simple Future, be going to, & Semi Modal',
                    'audio_script' => 'Look at those dark clouds gathering over the mountain peak! It is definitely going to rain heavily this afternoon. The weather forecast predicts that gusty winds will blow across the valley. The conservation team is about to close the hiking trail to ensure everyone\'s safety.',
                    'key_phrases' => [
                        'Scientists predict that global temperatures will continue to fluctuate.',
                        'We are going to plant one hundred mangrove saplings along the coastline.',
                        'The scientific expedition is about to depart for the rainforest.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this audio listening passage?',
                            'options' => [
                                'Simple Future, be going to, & Semi Modal',
                                'Agricultural Farming in Sahara',
                                'Deep Coal Mining',
                                'Textile Factory Operations',
                            ],
                            'answer' => 'Simple Future, be going to, & Semi Modal',
                        ],
                        [
                            'q' => 'Which core principle is emphasized by the speaker?',
                            'options' => [
                                'Scientists predict that global temperatures will continue to fluctuate.',
                                'Ignoring all advice',
                                'Frequent procrastination',
                                'Avoiding speaking entirely',
                            ],
                            'answer' => 'Scientists predict that global temperatures will continue to fluctuate.',
                        ],
                        [
                            'q' => 'How does mastering simple future, be going to, & semi modal advance your speaking competency?',
                            'options' => [
                                'Elevates articulation, fluency, and nuance',
                                'Creates severe confusion',
                                'Decreases vocabulary power',
                                'Reduces conversational speed',
                            ],
                            'answer' => 'Elevates articulation, fluency, and nuance',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Scientists predict that global temperatures will continue to fluctuate.',
                        'id' => 'Para ilmuwan memprediksi bahwa suhu global akan terus berfluktuasi.',
                    ],
                    [
                        'en' => 'We are going to plant one hundred mangrove saplings along the coastline.',
                        'id' => 'Kami akan menanam seratus bibit bakau di sepanjang garis pantai.',
                    ],
                    [
                        'en' => 'The scientific expedition is about to depart for the rainforest.',
                        'id' => 'Ekspedisi ilmiah akan segera berangkat menuju hutan hujan.',
                    ],
                    [
                        'en' => 'The eco-documentary is due to air on national television tomorrow evening.',
                        'id' => 'Dokumenter lingkungan dijadwalkan tayang di televisi nasional besok malam.',
                    ],
                    [
                        'en' => 'Protecting pristine natural forests will guarantee fresh water for future generations.',
                        'id' => 'Melindungi hutan alam yang asri akan menjamin air bersih bagi generasi mendatang.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing complex ideas about simple future, be going to, & semi modal clearly.',
                        'id' => 'Kami selalu berlatih menyampaikan ide-ide kompleks tentang simple future, be going to, & semi modal secara jelas.',
                    ],
                    [
                        'en' => 'She usually formulates articulate arguments during our classroom discussions.',
                        'id' => 'Dia biasanya menyusun argumen yang lugas saat diskusi kelas kami.',
                    ],
                    [
                        'en' => 'I often shadow native audio recordings to master natural rhythm and cadence.',
                        'id' => 'Saya sering menirukan rekaman audio penutur asli untuk menguasai ritme dan intonasi alami.',
                    ],
                    [
                        'en' => 'They rarely encounter difficulties when presenting in front of an international audience.',
                        'id' => 'Mereka jarang mengalami kesulitan saat presentasi di depan audiens internasional.',
                    ],
                    [
                        'en' => 'He sometimes records his spontaneous responses to monitor grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon spontannya untuk memantau ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Will (spontaneous/prediction) vs Be going to (evidence/prior plan) | Be about to (immediate future)',
                'pronunciation_tip' => 'Pelafalan "won\'t" vs "want" dan pengurangan bentuk informal "gonna"',
                'dialogue_setting' => 'Dua profesional mendiskusikan topik Simple Future, be going to, & Semi Modal dalam sesi mentoring.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'What is your main takeaway from our lesson on Simple Future, be going to, & Semi Modal today?',
                        'id' => 'Apa poin utama yang kamu dapatkan dari pelajaran tentang Simple Future, be going to, & Semi Modal hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I really enjoyed mastering the sentence structures for simple future, be going to, & semi modal. It makes my speech more professional.',
                        'id' => 'Saya sangat menikmati menguasai struktur kalimat untuk simple future, be going to, & semi modal. Ini membuat gaya berbicara saya lebih profesional.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which expression do you plan to use most frequently in real conversations?',
                        'id' => 'Ungkapan mana yang berencana kamu gunakan paling sering dalam percakapan nyata?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'Definitely: "Scientists predict that global temperatures will continue to fluctuate.". It sounds very articulate and precise.',
                        'id' => 'Tentu saja: "Scientists predict that global temperatures will continue to fluctuate.". Terdengar sangat lugas dan presisi.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Simple Future, be going to, & Semi Modal pada tingkat menengah memberikan landasan yang kokoh dalam membangun percakapan yang berbobot. Kita dilatih untuk tidak sekadar menyampaikan informasi dasar, melainkan juga menyusun argumen, dugaan logis, dan perbandingan yang elegan.',
                    'Penerapan struktur tata bahasa yang tepat seperti Will (spontaneous/prediction) vs Be going to (evidence/prior plan) meningkatkan kredibilitas dan kejelasan saat kita berbicara di forum resmi maupun profesional.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Simple Future, be going to, & Semi Modal ini bener-bener ngebuka wawasan banget. Dulu gue kalo ngomong bahasa Inggris suka kaku dan pake pola kalimat itu-itu aja, sekarang variasinya makin banyak.',
                    'Keren banget pas nyobain latihan langsung. Gue jadi ngerti kapan harus pake intonasi naik atau turun pas ngajuin pertanyaan tag atau bikin analogi.',
                ],
                'questions_part_a' => [
                    'Apa konsep terpenting yang kamu pelajari dari topik Simple Future, be going to, & Semi Modal?',
                    'Bagaimana kamu menerapkan aturan Will (spontaneous/prediction) vs Be going to (evidence/prior plan) | Be about to (immediate future) dalam percakapan sehari-hari?',
                    'Coba buat satu contoh kalimat menggunakan kosakata baru di meeting ini!',
                    'Kamu lebih mudah memahami materi ini dengan mendengar audio atau membaca contoh dialog?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa kesalahan umum yang sering dilakukan orang saat mempelajari topik ini?',
                    'Bagaimana caramu menguji pemahamanmu sendiri setelah kelas selesai?',
                    'Siapa tokoh atau penutur bahasa Inggris yang cara berbicaranya paling kamu kagumi?',
                    'Apa target kemampuan berbicara yang ingin kamu capai dalam sebulan ke depan?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Simple Future, be going to, & Semi Modal Mastery',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai penerapan Simple Future, be going to, & Semi Modal dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana teknik pengucapan (Pelafalan "won\'t" vs "want" dan pengurangan bentuk informal "gonna") dapat meningkatkan rasa percaya dirimu saat berbicara.',
                    'Diskusikan bagaimana kemampuan bahasa Inggris tingkat menengah membuka peluang kolaborasi global.',
                    'Bagaimana cara kamu mempertahankan konsistensi belajar setelah menyelesaikan 10 pertemuan ini?',
                ],
            ],
            6 => [
                'topic' => 'Present Continuous & stative verbs',
                'focus' => 'Present Continuous for temporary/in-progress actions vs Stative verbs (feel, believe, belong, seem, prefer, understand), Recreation',
                'listening' => [
                    'title' => 'Listening Practice: Present Continuous & stative verbs',
                    'audio_script' => 'Right now, thousands of people are enjoying the annual summer carnival downtown. Children are riding the carousel while street performers are entertaining the crowd with magic tricks. I believe that community recreation is essential for urban happiness.',
                    'key_phrases' => [
                        'The acrobats are performing breathtaking stunts in the main arena.',
                        'This vintage game console belongs to my older brother.',
                        'I understand why millions of tourists adore this amusement park.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this audio listening passage?',
                            'options' => [
                                'Present Continuous & stative verbs',
                                'Agricultural Farming in Sahara',
                                'Deep Coal Mining',
                                'Textile Factory Operations',
                            ],
                            'answer' => 'Present Continuous & stative verbs',
                        ],
                        [
                            'q' => 'Which core principle is emphasized by the speaker?',
                            'options' => [
                                'The acrobats are performing breathtaking stunts in the main arena.',
                                'Ignoring all advice',
                                'Frequent procrastination',
                                'Avoiding speaking entirely',
                            ],
                            'answer' => 'The acrobats are performing breathtaking stunts in the main arena.',
                        ],
                        [
                            'q' => 'How does mastering present continuous & stative verbs advance your speaking competency?',
                            'options' => [
                                'Elevates articulation, fluency, and nuance',
                                'Creates severe confusion',
                                'Decreases vocabulary power',
                                'Reduces conversational speed',
                            ],
                            'answer' => 'Elevates articulation, fluency, and nuance',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The acrobats are performing breathtaking stunts in the main arena.',
                        'id' => 'Para pemain akrobat sedang melakukan atraksi memukau di arena utama.',
                    ],
                    [
                        'en' => 'This vintage game console belongs to my older brother.',
                        'id' => 'Konsol game antik ini milik kakak laki-laki saya.',
                    ],
                    [
                        'en' => 'I understand why millions of tourists adore this amusement park.',
                        'id' => 'Saya memahami mengapa jutaan wisatawan sangat menyukai taman hiburan ini.',
                    ],
                    [
                        'en' => 'She is currently organizing a community board game tournament.',
                        'id' => 'Dia saat ini sedang mengorganisir turnamen permainan papan komunitas.',
                    ],
                    [
                        'en' => 'Engaging in recreational sports promotes physical vigor and mental wellness.',
                        'id' => 'Terlibat dalam olahraga rekreasi meningkatkan stamina fisik dan kesehatan mental.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing complex ideas about present continuous & stative verbs clearly.',
                        'id' => 'Kami selalu berlatih menyampaikan ide-ide kompleks tentang present continuous & stative verbs secara jelas.',
                    ],
                    [
                        'en' => 'She usually formulates articulate arguments during our classroom discussions.',
                        'id' => 'Dia biasanya menyusun argumen yang lugas saat diskusi kelas kami.',
                    ],
                    [
                        'en' => 'I often shadow native audio recordings to master natural rhythm and cadence.',
                        'id' => 'Saya sering menirukan rekaman audio penutur asli untuk menguasai ritme dan intonasi alami.',
                    ],
                    [
                        'en' => 'They rarely encounter difficulties when presenting in front of an international audience.',
                        'id' => 'Mereka jarang mengalami kesulitan saat presentasi di depan audiens internasional.',
                    ],
                    [
                        'en' => 'He sometimes records his spontaneous responses to monitor grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon spontannya untuk memantau ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Stative Verbs (non-action/mental state): belong, believe, seem, understand, prefer, know (NOT used in -ing form)',
                'pronunciation_tip' => 'Intonasi dinamis dalam mendeskripsikan aksi langsung (*live commentary*)',
                'dialogue_setting' => 'Dua profesional mendiskusikan topik Present Continuous & stative verbs dalam sesi mentoring.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'What is your main takeaway from our lesson on Present Continuous & stative verbs today?',
                        'id' => 'Apa poin utama yang kamu dapatkan dari pelajaran tentang Present Continuous & stative verbs hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I really enjoyed mastering the sentence structures for present continuous & stative verbs. It makes my speech more professional.',
                        'id' => 'Saya sangat menikmati menguasai struktur kalimat untuk present continuous & stative verbs. Ini membuat gaya berbicara saya lebih profesional.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which expression do you plan to use most frequently in real conversations?',
                        'id' => 'Ungkapan mana yang berencana kamu gunakan paling sering dalam percakapan nyata?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'Definitely: "The acrobats are performing breathtaking stunts in the main arena.". It sounds very articulate and precise.',
                        'id' => 'Tentu saja: "The acrobats are performing breathtaking stunts in the main arena.". Terdengar sangat lugas dan presisi.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Present Continuous & stative verbs pada tingkat menengah memberikan landasan yang kokoh dalam membangun percakapan yang berbobot. Kita dilatih untuk tidak sekadar menyampaikan informasi dasar, melainkan juga menyusun argumen, dugaan logis, dan perbandingan yang elegan.',
                    'Penerapan struktur tata bahasa yang tepat seperti Stative Verbs (non-action/mental state): belong, believe, seem, understand, prefer, know (NOT used in -ing form) meningkatkan kredibilitas dan kejelasan saat kita berbicara di forum resmi maupun profesional.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Present Continuous & stative verbs ini bener-bener ngebuka wawasan banget. Dulu gue kalo ngomong bahasa Inggris suka kaku dan pake pola kalimat itu-itu aja, sekarang variasinya makin banyak.',
                    'Keren banget pas nyobain latihan langsung. Gue jadi ngerti kapan harus pake intonasi naik atau turun pas ngajuin pertanyaan tag atau bikin analogi.',
                ],
                'questions_part_a' => [
                    'Apa konsep terpenting yang kamu pelajari dari topik Present Continuous & stative verbs?',
                    'Bagaimana kamu menerapkan aturan Stative Verbs (non-action/mental state) dalam percakapan sehari-hari?',
                    'Coba buat satu contoh kalimat menggunakan kosakata baru di meeting ini!',
                    'Kamu lebih mudah memahami materi ini dengan mendengar audio atau membaca contoh dialog?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa kesalahan umum yang sering dilakukan orang saat mempelajari topik ini?',
                    'Bagaimana caramu menguji pemahamanmu sendiri setelah kelas selesai?',
                    'Siapa tokoh atau penutur bahasa Inggris yang cara berbicaranya paling kamu kagumi?',
                    'Apa target kemampuan berbicara yang ingin kamu capai dalam sebulan ke depan?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Present Continuous & stative verbs Mastery',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai penerapan Present Continuous & stative verbs dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana teknik pengucapan (Intonasi dinamis dalam mendeskripsikan aksi langsung (*live commentary*)) dapat meningkatkan rasa percaya dirimu saat berbicara.',
                    'Diskusikan bagaimana kemampuan bahasa Inggris tingkat menengah membuka peluang kolaborasi global.',
                    'Bagaimana cara kamu mempertahankan konsistensi belajar setelah menyelesaikan 10 pertemuan ini?',
                ],
            ],
            7 => [
                'topic' => 'Degrees of certainty & Progressive form of modals',
                'focus' => 'Degrees of certainty for present & future (must be, could be, may be, might be, can\'t be) and progressive modals (modal + be + V-ing), Tourism',
                'listening' => [
                    'title' => 'Listening Practice: Degrees of certainty & Progressive form of modals',
                    'audio_script' => 'Look at the crowd gathered at the historic cathedral; the famous royal parade must be taking place right now! The foreign dignitaries could be arriving in diplomatic carriages. They might be visiting the grand art gallery afterwards.',
                    'key_phrases' => [
                        'He has traveled to thirty countries; he must be an experienced globe-trotter.',
                        'The international flight may be experiencing minor air turbulence.',
                        'That ancient monument can\'t be made of artificial plastic.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this audio listening passage?',
                            'options' => [
                                'Degrees of certainty & Progressive form of modals',
                                'Agricultural Farming in Sahara',
                                'Deep Coal Mining',
                                'Textile Factory Operations',
                            ],
                            'answer' => 'Degrees of certainty & Progressive form of modals',
                        ],
                        [
                            'q' => 'Which core principle is emphasized by the speaker?',
                            'options' => [
                                'He has traveled to thirty countries; he must be an experienced globe-trotter.',
                                'Ignoring all advice',
                                'Frequent procrastination',
                                'Avoiding speaking entirely',
                            ],
                            'answer' => 'He has traveled to thirty countries; he must be an experienced globe-trotter.',
                        ],
                        [
                            'q' => 'How does mastering degrees of certainty & progressive form of modals advance your speaking competency?',
                            'options' => [
                                'Elevates articulation, fluency, and nuance',
                                'Creates severe confusion',
                                'Decreases vocabulary power',
                                'Reduces conversational speed',
                            ],
                            'answer' => 'Elevates articulation, fluency, and nuance',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'He has traveled to thirty countries; he must be an experienced globe-trotter.',
                        'id' => 'Dia telah bepergian ke tiga puluh negara; dia pasti seorang penjelajah dunia yang berpengalaman.',
                    ],
                    [
                        'en' => 'The international flight may be experiencing minor air turbulence.',
                        'id' => 'Penerbangan internasional mungkin sedang mengalami turbulensi udara ringan.',
                    ],
                    [
                        'en' => 'That ancient monument can\'t be made of artificial plastic.',
                        'id' => 'Monumen kuno itu tidak mungkin terbuat dari plastik buatan.',
                    ],
                    [
                        'en' => 'The tour guide must be briefing the guests at the reception desk.',
                        'id' => 'Pemandu tur pasti sedang memberikan pengarahan kepada tamu di meja resepsionis.',
                    ],
                    [
                        'en' => 'Sustainable eco-tourism may stimulate local economies without damaging nature.',
                        'id' => 'Ekowisata berkelanjutan mungkin dapat menstimulasi ekonomi lokal tanpa merusak alam.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing complex ideas about degrees of certainty & progressive form of modals clearly.',
                        'id' => 'Kami selalu berlatih menyampaikan ide-ide kompleks tentang degrees of certainty & progressive form of modals secara jelas.',
                    ],
                    [
                        'en' => 'She usually formulates articulate arguments during our classroom discussions.',
                        'id' => 'Dia biasanya menyusun argumen yang lugas saat diskusi kelas kami.',
                    ],
                    [
                        'en' => 'I often shadow native audio recordings to master natural rhythm and cadence.',
                        'id' => 'Saya sering menirukan rekaman audio penutur asli untuk menguasai ritme dan intonasi alami.',
                    ],
                    [
                        'en' => 'They rarely encounter difficulties when presenting in front of an international audience.',
                        'id' => 'Mereka jarang mengalami kesulitan saat presentasi di depan audiens internasional.',
                    ],
                    [
                        'en' => 'He sometimes records his spontaneous responses to monitor grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon spontannya untuk memantau ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Degrees of Certainty: 100% (is/will be) -> 90% (must be) -> 50% (may/might/could be) -> 0% (can\'t be)',
                'pronunciation_tip' => 'Penekanan modal stress pada dugaan logis (*logical deduction*)',
                'dialogue_setting' => 'Dua profesional mendiskusikan topik Degrees of certainty & Progressive form of modals dalam sesi mentoring.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'What is your main takeaway from our lesson on Degrees of certainty & Progressive form of modals today?',
                        'id' => 'Apa poin utama yang kamu dapatkan dari pelajaran tentang Degrees of certainty & Progressive form of modals hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I really enjoyed mastering the sentence structures for degrees of certainty & progressive form of modals. It makes my speech more professional.',
                        'id' => 'Saya sangat menikmati menguasai struktur kalimat untuk degrees of certainty & progressive form of modals. Ini membuat gaya berbicara saya lebih profesional.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which expression do you plan to use most frequently in real conversations?',
                        'id' => 'Ungkapan mana yang berencana kamu gunakan paling sering dalam percakapan nyata?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'Definitely: "He has traveled to thirty countries; he must be an experienced globe-trotter.". It sounds very articulate and precise.',
                        'id' => 'Tentu saja: "He has traveled to thirty countries; he must be an experienced globe-trotter.". Terdengar sangat lugas dan presisi.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Degrees of certainty & Progressive form of modals pada tingkat menengah memberikan landasan yang kokoh dalam membangun percakapan yang berbobot. Kita dilatih untuk tidak sekadar menyampaikan informasi dasar, melainkan juga menyusun argumen, dugaan logis, dan perbandingan yang elegan.',
                    'Penerapan struktur tata bahasa yang tepat seperti Degrees of Certainty: 100% (is/will be) -> 90% (must be) -> 50% (may/might/could be) -> 0% (can\'t be) meningkatkan kredibilitas dan kejelasan saat kita berbicara di forum resmi maupun profesional.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Degrees of certainty & Progressive form of modals ini bener-bener ngebuka wawasan banget. Dulu gue kalo ngomong bahasa Inggris suka kaku dan pake pola kalimat itu-itu aja, sekarang variasinya makin banyak.',
                    'Keren banget pas nyobain latihan langsung. Gue jadi ngerti kapan harus pake intonasi naik atau turun pas ngajuin pertanyaan tag atau bikin analogi.',
                ],
                'questions_part_a' => [
                    'Apa konsep terpenting yang kamu pelajari dari topik Degrees of certainty & Progressive form of modals?',
                    'Bagaimana kamu menerapkan aturan Degrees of Certainty dalam percakapan sehari-hari?',
                    'Coba buat satu contoh kalimat menggunakan kosakata baru di meeting ini!',
                    'Kamu lebih mudah memahami materi ini dengan mendengar audio atau membaca contoh dialog?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa kesalahan umum yang sering dilakukan orang saat mempelajari topik ini?',
                    'Bagaimana caramu menguji pemahamanmu sendiri setelah kelas selesai?',
                    'Siapa tokoh atau penutur bahasa Inggris yang cara berbicaranya paling kamu kagumi?',
                    'Apa target kemampuan berbicara yang ingin kamu capai dalam sebulan ke depan?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Degrees of certainty & Progressive form of modals Mastery',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai penerapan Degrees of certainty & Progressive form of modals dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana teknik pengucapan (Penekanan modal stress pada dugaan logis (*logical deduction*)) dapat meningkatkan rasa percaya dirimu saat berbicara.',
                    'Diskusikan bagaimana kemampuan bahasa Inggris tingkat menengah membuka peluang kolaborasi global.',
                    'Bagaimana cara kamu mempertahankan konsistensi belajar setelah menyelesaikan 10 pertemuan ini?',
                ],
            ],
            8 => [
                'topic' => 'Comparison, Superlative, & Irregular comparative superlative',
                'focus' => 'Comparison (-er/more), Superlative (the -est/most), Irregular forms (good-better-best, bad-worse-worst, far-further-furthest), Earth & Space',
                'listening' => [
                    'title' => 'Listening Practice: Comparison, Superlative, & Irregular comparative superlative',
                    'audio_script' => 'Jupiter is by far the largest planet in our solar system, with a mass greater than all other planets combined. Mars is farther from the sun than Earth, making its surface significantly colder. Space exploration provides the best insights into cosmic history.',
                    'key_phrases' => [
                        'Earth has a much denser atmosphere than the Moon.',
                        'Mount Everest is the highest mountain peak above sea level on Earth.',
                        'Telescopes in high orbit produce far better images than ground observatories.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this audio listening passage?',
                            'options' => [
                                'Comparison, Superlative, & Irregular comparative superlative',
                                'Agricultural Farming in Sahara',
                                'Deep Coal Mining',
                                'Textile Factory Operations',
                            ],
                            'answer' => 'Comparison, Superlative, & Irregular comparative superlative',
                        ],
                        [
                            'q' => 'Which core principle is emphasized by the speaker?',
                            'options' => [
                                'Earth has a much denser atmosphere than the Moon.',
                                'Ignoring all advice',
                                'Frequent procrastination',
                                'Avoiding speaking entirely',
                            ],
                            'answer' => 'Earth has a much denser atmosphere than the Moon.',
                        ],
                        [
                            'q' => 'How does mastering comparison, superlative, & irregular comparative superlative advance your speaking competency?',
                            'options' => [
                                'Elevates articulation, fluency, and nuance',
                                'Creates severe confusion',
                                'Decreases vocabulary power',
                                'Reduces conversational speed',
                            ],
                            'answer' => 'Elevates articulation, fluency, and nuance',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Earth has a much denser atmosphere than the Moon.',
                        'id' => 'Bumi memiliki atmosfer yang jauh lebih padat daripada Bulan.',
                    ],
                    [
                        'en' => 'Mount Everest is the highest mountain peak above sea level on Earth.',
                        'id' => 'Gunung Everest adalah puncak gunung tertinggi di atas permukaan laut di Bumi.',
                    ],
                    [
                        'en' => 'Telescopes in high orbit produce far better images than ground observatories.',
                        'id' => 'Teleskop di orbit tinggi menghasilkan gambar yang jauh lebih baik daripada observatorium darat.',
                    ],
                    [
                        'en' => 'Solar flares can cause the worst radio blackouts in satellite communications.',
                        'id' => 'Suar matahari dapat menyebabkan gangguan radio terburuk dalam komunikasi satelit.',
                    ],
                    [
                        'en' => 'Exploring the mysteries of the universe requires the most sophisticated scientific instruments.',
                        'id' => 'Menjelajahi misteri alam semesta membutuhkan instrumen ilmiah yang paling canggih.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing complex ideas about comparison, superlative, & irregular comparative superlative clearly.',
                        'id' => 'Kami selalu berlatih menyampaikan ide-ide kompleks tentang comparison, superlative, & irregular comparative superlative secara jelas.',
                    ],
                    [
                        'en' => 'She usually formulates articulate arguments during our classroom discussions.',
                        'id' => 'Dia biasanya menyusun argumen yang lugas saat diskusi kelas kami.',
                    ],
                    [
                        'en' => 'I often shadow native audio recordings to master natural rhythm and cadence.',
                        'id' => 'Saya sering menirukan rekaman audio penutur asli untuk menguasai ritme dan intonasi alami.',
                    ],
                    [
                        'en' => 'They rarely encounter difficulties when presenting in front of an international audience.',
                        'id' => 'Mereka jarang mengalami kesulitan saat presentasi di depan audiens internasional.',
                    ],
                    [
                        'en' => 'He sometimes records his spontaneous responses to monitor grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon spontannya untuk memantau ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Irregular forms: good -> better -> best | bad -> worse -> worst | far -> farther/further -> farthest/furthest',
                'pronunciation_tip' => 'Pelafalan suku kata bertekanan pada bentuk komparatif dan superlatif',
                'dialogue_setting' => 'Dua profesional mendiskusikan topik Comparison, Superlative, & Irregular comparative superlative dalam sesi mentoring.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'What is your main takeaway from our lesson on Comparison, Superlative, & Irregular comparative superlative today?',
                        'id' => 'Apa poin utama yang kamu dapatkan dari pelajaran tentang Comparison, Superlative, & Irregular comparative superlative hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I really enjoyed mastering the sentence structures for comparison, superlative, & irregular comparative superlative. It makes my speech more professional.',
                        'id' => 'Saya sangat menikmati menguasai struktur kalimat untuk comparison, superlative, & irregular comparative superlative. Ini membuat gaya berbicara saya lebih profesional.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which expression do you plan to use most frequently in real conversations?',
                        'id' => 'Ungkapan mana yang berencana kamu gunakan paling sering dalam percakapan nyata?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'Definitely: "Earth has a much denser atmosphere than the Moon.". It sounds very articulate and precise.',
                        'id' => 'Tentu saja: "Earth has a much denser atmosphere than the Moon.". Terdengar sangat lugas dan presisi.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Comparison, Superlative, & Irregular comparative superlative pada tingkat menengah memberikan landasan yang kokoh dalam membangun percakapan yang berbobot. Kita dilatih untuk tidak sekadar menyampaikan informasi dasar, melainkan juga menyusun argumen, dugaan logis, dan perbandingan yang elegan.',
                    'Penerapan struktur tata bahasa yang tepat seperti Irregular forms: good -> better -> best meningkatkan kredibilitas dan kejelasan saat kita berbicara di forum resmi maupun profesional.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Comparison, Superlative, & Irregular comparative superlative ini bener-bener ngebuka wawasan banget. Dulu gue kalo ngomong bahasa Inggris suka kaku dan pake pola kalimat itu-itu aja, sekarang variasinya makin banyak.',
                    'Keren banget pas nyobain latihan langsung. Gue jadi ngerti kapan harus pake intonasi naik atau turun pas ngajuin pertanyaan tag atau bikin analogi.',
                ],
                'questions_part_a' => [
                    'Apa konsep terpenting yang kamu pelajari dari topik Comparison, Superlative, & Irregular comparative superlative?',
                    'Bagaimana kamu menerapkan aturan Irregular forms dalam percakapan sehari-hari?',
                    'Coba buat satu contoh kalimat menggunakan kosakata baru di meeting ini!',
                    'Kamu lebih mudah memahami materi ini dengan mendengar audio atau membaca contoh dialog?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa kesalahan umum yang sering dilakukan orang saat mempelajari topik ini?',
                    'Bagaimana caramu menguji pemahamanmu sendiri setelah kelas selesai?',
                    'Siapa tokoh atau penutur bahasa Inggris yang cara berbicaranya paling kamu kagumi?',
                    'Apa target kemampuan berbicara yang ingin kamu capai dalam sebulan ke depan?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Comparison, Superlative, & Irregular comparative superlative Mastery',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai penerapan Comparison, Superlative, & Irregular comparative superlative dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana teknik pengucapan (Pelafalan suku kata bertekanan pada bentuk komparatif dan superlatif) dapat meningkatkan rasa percaya dirimu saat berbicara.',
                    'Diskusikan bagaimana kemampuan bahasa Inggris tingkat menengah membuka peluang kolaborasi global.',
                    'Bagaimana cara kamu mempertahankan konsistensi belajar setelah menyelesaikan 10 pertemuan ini?',
                ],
            ],
            9 => [
                'topic' => 'Positive degree & Double degree',
                'focus' => 'Positive degree (as ... as, not as ... as) and Double degree (The more ..., the more ... / The sooner, the better), The Arts',
                'listening' => [
                    'title' => 'Listening Practice: Positive degree & Double degree',
                    'audio_script' => 'The more you practice artistic drawing, the more refined your creative vision becomes. Classical music is as captivating as modern orchestral soundtracks. Art exhibitions play as vital a role in culture as literature does.',
                    'key_phrases' => [
                        'Traditional batik is as intricate as foreign renaissance paintings.',
                        'Digital reproductions are not as expressive as original oil masterpieces.',
                        'The more colorful the theatrical stage is, the more captivated the audience becomes.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this audio listening passage?',
                            'options' => [
                                'Positive degree & Double degree',
                                'Agricultural Farming in Sahara',
                                'Deep Coal Mining',
                                'Textile Factory Operations',
                            ],
                            'answer' => 'Positive degree & Double degree',
                        ],
                        [
                            'q' => 'Which core principle is emphasized by the speaker?',
                            'options' => [
                                'Traditional batik is as intricate as foreign renaissance paintings.',
                                'Ignoring all advice',
                                'Frequent procrastination',
                                'Avoiding speaking entirely',
                            ],
                            'answer' => 'Traditional batik is as intricate as foreign renaissance paintings.',
                        ],
                        [
                            'q' => 'How does mastering positive degree & double degree advance your speaking competency?',
                            'options' => [
                                'Elevates articulation, fluency, and nuance',
                                'Creates severe confusion',
                                'Decreases vocabulary power',
                                'Reduces conversational speed',
                            ],
                            'answer' => 'Elevates articulation, fluency, and nuance',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Traditional batik is as intricate as foreign renaissance paintings.',
                        'id' => 'Batik tradisional sama rumitnya dengan lukisan zaman renaisans luar negeri.',
                    ],
                    [
                        'en' => 'Digital reproductions are not as expressive as original oil masterpieces.',
                        'id' => 'Reproduksi digital tidak se-ekspresif karya agung cat minyak asli.',
                    ],
                    [
                        'en' => 'The more colorful the theatrical stage is, the more captivated the audience becomes.',
                        'id' => 'Semakin berwarna panggung teater, semakin terpikat para penonton.',
                    ],
                    [
                        'en' => 'The deeper you analyze a musical composition, the more beauty you discover.',
                        'id' => 'Semakin dalam Anda menganalisis komposisi musik, semakin banyak keindahan yang Anda temukan.',
                    ],
                    [
                        'en' => 'Engaging in creative arts enriches cultural empathy and creative imagination.',
                        'id' => 'Terlibat dalam seni kreatif memperkaya empati budaya dan imajinasi kreatif.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing complex ideas about positive degree & double degree clearly.',
                        'id' => 'Kami selalu berlatih menyampaikan ide-ide kompleks tentang positive degree & double degree secara jelas.',
                    ],
                    [
                        'en' => 'She usually formulates articulate arguments during our classroom discussions.',
                        'id' => 'Dia biasanya menyusun argumen yang lugas saat diskusi kelas kami.',
                    ],
                    [
                        'en' => 'I often shadow native audio recordings to master natural rhythm and cadence.',
                        'id' => 'Saya sering menirukan rekaman audio penutur asli untuk menguasai ritme dan intonasi alami.',
                    ],
                    [
                        'en' => 'They rarely encounter difficulties when presenting in front of an international audience.',
                        'id' => 'Mereka jarang mengalami kesulitan saat presentasi di depan audiens internasional.',
                    ],
                    [
                        'en' => 'He sometimes records his spontaneous responses to monitor grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon spontannya untuk memantau ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Double Degree Structure: The + comparative ..., the + comparative ... (e.g. The harder you work, the better you perform)',
                'pronunciation_tip' => 'Ritme berpasangan (*parallel rhythm*) pada kalimat Double Degree',
                'dialogue_setting' => 'Dua profesional mendiskusikan topik Positive degree & Double degree dalam sesi mentoring.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'What is your main takeaway from our lesson on Positive degree & Double degree today?',
                        'id' => 'Apa poin utama yang kamu dapatkan dari pelajaran tentang Positive degree & Double degree hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I really enjoyed mastering the sentence structures for positive degree & double degree. It makes my speech more professional.',
                        'id' => 'Saya sangat menikmati menguasai struktur kalimat untuk positive degree & double degree. Ini membuat gaya berbicara saya lebih profesional.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which expression do you plan to use most frequently in real conversations?',
                        'id' => 'Ungkapan mana yang berencana kamu gunakan paling sering dalam percakapan nyata?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'Definitely: "Traditional batik is as intricate as foreign renaissance paintings.". It sounds very articulate and precise.',
                        'id' => 'Tentu saja: "Traditional batik is as intricate as foreign renaissance paintings.". Terdengar sangat lugas dan presisi.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Positive degree & Double degree pada tingkat menengah memberikan landasan yang kokoh dalam membangun percakapan yang berbobot. Kita dilatih untuk tidak sekadar menyampaikan informasi dasar, melainkan juga menyusun argumen, dugaan logis, dan perbandingan yang elegan.',
                    'Penerapan struktur tata bahasa yang tepat seperti Double Degree Structure: The + comparative ..., the + comparative ... (e.g. The harder you work, the better you perform) meningkatkan kredibilitas dan kejelasan saat kita berbicara di forum resmi maupun profesional.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Positive degree & Double degree ini bener-bener ngebuka wawasan banget. Dulu gue kalo ngomong bahasa Inggris suka kaku dan pake pola kalimat itu-itu aja, sekarang variasinya makin banyak.',
                    'Keren banget pas nyobain latihan langsung. Gue jadi ngerti kapan harus pake intonasi naik atau turun pas ngajuin pertanyaan tag atau bikin analogi.',
                ],
                'questions_part_a' => [
                    'Apa konsep terpenting yang kamu pelajari dari topik Positive degree & Double degree?',
                    'Bagaimana kamu menerapkan aturan Double Degree Structure dalam percakapan sehari-hari?',
                    'Coba buat satu contoh kalimat menggunakan kosakata baru di meeting ini!',
                    'Kamu lebih mudah memahami materi ini dengan mendengar audio atau membaca contoh dialog?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa kesalahan umum yang sering dilakukan orang saat mempelajari topik ini?',
                    'Bagaimana caramu menguji pemahamanmu sendiri setelah kelas selesai?',
                    'Siapa tokoh atau penutur bahasa Inggris yang cara berbicaranya paling kamu kagumi?',
                    'Apa target kemampuan berbicara yang ingin kamu capai dalam sebulan ke depan?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Positive degree & Double degree Mastery',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai penerapan Positive degree & Double degree dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana teknik pengucapan (Ritme berpasangan (*parallel rhythm*) pada kalimat Double Degree) dapat meningkatkan rasa percaya dirimu saat berbicara.',
                    'Diskusikan bagaimana kemampuan bahasa Inggris tingkat menengah membuka peluang kolaborasi global.',
                    'Bagaimana cara kamu mempertahankan konsistensi belajar setelah menyelesaikan 10 pertemuan ini?',
                ],
            ],
            10 => [
                'topic' => 'Suffixes & Prefixes',
                'focus' => 'Word building with Prefixes (un-, dis-, re-, mis-, pre-) and Suffixes (-ful, -less, -able, -ment, -ness), Tag Intonation',
                'listening' => [
                    'title' => 'Listening Practice: Suffixes & Prefixes',
                    'audio_script' => 'Language mastery expands exponentially when you understand word formation. Adding the prefix \'re-\' transforms \'write\' into \'rewrite\', while the suffix \'-able\' turns \'rely\' into \'reliable\'. You have noticed these patterns before, haven\'t you?',
                    'key_phrases' => [
                        'The author decided to rewrite the entire introductory chapter.',
                        'Misunderstandings often disappear when people communicate openly, don\'t they?',
                        'She is a remarkably dependable team player in high pressure situations.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this audio listening passage?',
                            'options' => [
                                'Suffixes & Prefixes',
                                'Agricultural Farming in Sahara',
                                'Deep Coal Mining',
                                'Textile Factory Operations',
                            ],
                            'answer' => 'Suffixes & Prefixes',
                        ],
                        [
                            'q' => 'Which core principle is emphasized by the speaker?',
                            'options' => [
                                'The author decided to rewrite the entire introductory chapter.',
                                'Ignoring all advice',
                                'Frequent procrastination',
                                'Avoiding speaking entirely',
                            ],
                            'answer' => 'The author decided to rewrite the entire introductory chapter.',
                        ],
                        [
                            'q' => 'How does mastering suffixes & prefixes advance your speaking competency?',
                            'options' => [
                                'Elevates articulation, fluency, and nuance',
                                'Creates severe confusion',
                                'Decreases vocabulary power',
                                'Reduces conversational speed',
                            ],
                            'answer' => 'Elevates articulation, fluency, and nuance',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The author decided to rewrite the entire introductory chapter.',
                        'id' => 'Penulis memutuskan untuk menulis ulang seluruh bab pengantar.',
                    ],
                    [
                        'en' => 'Misunderstandings often disappear when people communicate openly, don\'t they?',
                        'id' => 'Kesalahpahaman sering kali lenyap saat orang berkomunikasi terbuka, bukan?',
                    ],
                    [
                        'en' => 'She is a remarkably dependable team player in high pressure situations.',
                        'id' => 'Dia adalah anggota tim yang sangat dapat diandalkan dalam situasi bertekanan tinggi.',
                    ],
                    [
                        'en' => 'True leadership is defined by kindness, integrity, and resilience.',
                        'id' => 'Kepemimpinan sejati didefinisikan oleh kebaikan hati, integritas, dan ketangguhan.',
                    ],
                    [
                        'en' => 'You will continue practicing your English speaking skills diligently, won\'t you?',
                        'id' => 'Anda akan terus melatih keterampilan berbicara bahasa Inggris Anda dengan tekun, bukan?',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always practice expressing complex ideas about suffixes & prefixes clearly.',
                        'id' => 'Kami selalu berlatih menyampaikan ide-ide kompleks tentang suffixes & prefixes secara jelas.',
                    ],
                    [
                        'en' => 'She usually formulates articulate arguments during our classroom discussions.',
                        'id' => 'Dia biasanya menyusun argumen yang lugas saat diskusi kelas kami.',
                    ],
                    [
                        'en' => 'I often shadow native audio recordings to master natural rhythm and cadence.',
                        'id' => 'Saya sering menirukan rekaman audio penutur asli untuk menguasai ritme dan intonasi alami.',
                    ],
                    [
                        'en' => 'They rarely encounter difficulties when presenting in front of an international audience.',
                        'id' => 'Mereka jarang mengalami kesulitan saat presentasi di depan audiens internasional.',
                    ],
                    [
                        'en' => 'He sometimes records his spontaneous responses to monitor grammatical precision.',
                        'id' => 'Dia kadang-kadang merekam respon spontannya untuk memantau ketepatan tata bahasa.',
                    ],
                ],
                'grammar_note' => 'Prefixes: un- (not), re- (again), mis- (wrongly), pre- (before) | Suffixes: -ful (full of), -less (without), -ment (noun), -able (capable of)',
                'pronunciation_tip' => 'Tag Question Intonation: Falling tone (sure of answer / asking for agreement) vs Rising tone (genuine question)',
                'dialogue_setting' => 'Dua profesional mendiskusikan topik Suffixes & Prefixes dalam sesi mentoring.',
                'dialogue' => [
                    [
                        'speaker' => 'Alex',
                        'en' => 'What is your main takeaway from our lesson on Suffixes & Prefixes today?',
                        'id' => 'Apa poin utama yang kamu dapatkan dari pelajaran tentang Suffixes & Prefixes hari ini?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'I really enjoyed mastering the sentence structures for suffixes & prefixes. It makes my speech more professional.',
                        'id' => 'Saya sangat menikmati menguasai struktur kalimat untuk suffixes & prefixes. Ini membuat gaya berbicara saya lebih profesional.',
                    ],
                    [
                        'speaker' => 'Alex',
                        'en' => 'Which expression do you plan to use most frequently in real conversations?',
                        'id' => 'Ungkapan mana yang berencana kamu gunakan paling sering dalam percakapan nyata?',
                    ],
                    [
                        'speaker' => 'Budi',
                        'en' => 'Definitely: "The author decided to rewrite the entire introductory chapter.". It sounds very articulate and precise.',
                        'id' => 'Tentu saja: "The author decided to rewrite the entire introductory chapter.". Terdengar sangat lugas dan presisi.',
                    ],
                ],
                'monolog_baku' => [
                    'Mempelajari topik Suffixes & Prefixes pada tingkat menengah memberikan landasan yang kokoh dalam membangun percakapan yang berbobot. Kita dilatih untuk tidak sekadar menyampaikan informasi dasar, melainkan juga menyusun argumen, dugaan logis, dan perbandingan yang elegan.',
                    'Penerapan struktur tata bahasa yang tepat seperti Prefixes: un- (not), re- (again), mis- (wrongly), pre- (before) meningkatkan kredibilitas dan kejelasan saat kita berbicara di forum resmi maupun profesional.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Suffixes & Prefixes ini bener-bener ngebuka wawasan banget. Dulu gue kalo ngomong bahasa Inggris suka kaku dan pake pola kalimat itu-itu aja, sekarang variasinya makin banyak.',
                    'Keren banget pas nyobain latihan langsung. Gue jadi ngerti kapan harus pake intonasi naik atau turun pas ngajuin pertanyaan tag atau bikin analogi.',
                ],
                'questions_part_a' => [
                    'Apa konsep terpenting yang kamu pelajari dari topik Suffixes & Prefixes?',
                    'Bagaimana kamu menerapkan aturan Prefixes dalam percakapan sehari-hari?',
                    'Coba buat satu contoh kalimat menggunakan kosakata baru di meeting ini!',
                    'Kamu lebih mudah memahami materi ini dengan mendengar audio atau membaca contoh dialog?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Menurutmu, apa kesalahan umum yang sering dilakukan orang saat mempelajari topik ini?',
                    'Bagaimana caramu menguji pemahamanmu sendiri setelah kelas selesai?',
                    'Siapa tokoh atau penutur bahasa Inggris yang cara berbicaranya paling kamu kagumi?',
                    'Apa target kemampuan berbicara yang ingin kamu capai dalam sebulan ke depan?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Suffixes & Prefixes Mastery',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai penerapan Suffixes & Prefixes dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana teknik pengucapan (Tag Question Intonation: Falling tone (sure of answer / asking for agreement) vs Rising tone (genuine question)) dapat meningkatkan rasa percaya dirimu saat berbicara.',
                    'Diskusikan bagaimana kemampuan bahasa Inggris tingkat menengah membuka peluang kolaborasi global.',
                    'Bagaimana cara kamu mempertahankan konsistensi belajar setelah menyelesaikan 10 pertemuan ini?',
                ],
            ],
        ];

        return $data[$meeting] ?? $data[1];
    }

    private function getAdvancedMeetingContent(int $meeting): array
    {
        $data = [
            1 => [
                'topic' => 'Introduction and Greetings',
                'focus' => 'Greetings & Farewells, Basic Self-Introduction, Personal Pronouns & To Be, Likes & Hobbies',
                'materi' => [
                    'greetings' => [
                        'formal' => [
                            ['en' => 'Good morning', 'id' => 'Selamat pagi (06:00 - 12:00)'],
                            ['en' => 'Good afternoon', 'id' => 'Selamat siang / sore (12:00 - 18:00)'],
                            ['en' => 'Good evening', 'id' => 'Selamat malam (18:00+)'],
                        ],
                        'informal' => [
                            ['en' => 'Hi!', 'id' => 'Hai!'],
                            ['en' => 'Hey! How\'s it going?', 'id' => 'Hei! Bagaimana kabarmu?'],
                        ],
                        'closing' => [
                            ['en' => 'Goodbye', 'id' => 'Selamat tinggal / Sampai jumpa'],
                            ['en' => 'See you later', 'id' => 'Sampai jumpa lagi nanti'],
                            ['en' => 'Have a nice day', 'id' => 'Semoga harimu menyenangkan'],
                        ]
                    ],
                    'self_intro_templates' => [
                        ['label' => 'Name', 'pattern' => 'My name is [Name] / I\'m [Name]', 'example' => 'My name is Budi Sugeng / I\'m Budi.'],
                        ['label' => 'Age', 'pattern' => 'I am [number] years old', 'example' => 'I am 20 years old.'],
                        ['label' => 'Origin', 'pattern' => 'I am from [Country/City]', 'example' => 'I am from Jakarta, Indonesia.'],
                        ['label' => 'Profession', 'pattern' => 'I am a/an [Profession]', 'example' => 'I am an English teacher.'],
                    ],
                    'grammar_basics' => [
                        'subject_pronouns' => ['I', 'You', 'He', 'She', 'It', 'We', 'They'],
                        'to_be_conjugations' => [
                            ['subject' => 'I', 'to_be' => 'am', 'contraction' => 'I\'m', 'example' => 'I am a teacher.'],
                            ['subject' => 'You', 'to_be' => 'are', 'contraction' => 'You\'re', 'example' => 'You are my student.'],
                            ['subject' => 'We', 'to_be' => 'are', 'contraction' => 'We\'re', 'example' => 'We are in the classroom.'],
                            ['subject' => 'They', 'to_be' => 'are', 'contraction' => 'They\'re', 'example' => 'They are friendly.'],
                            ['subject' => 'He', 'to_be' => 'is', 'contraction' => 'He\'s', 'example' => 'He is 20 years old.'],
                            ['subject' => 'She', 'to_be' => 'is', 'contraction' => 'She\'s', 'example' => 'She is from Jakarta.'],
                            ['subject' => 'It', 'to_be' => 'is', 'contraction' => 'It\'s', 'example' => 'It is nice to meet you.'],
                        ]
                    ],
                    'likes_hobbies' => [
                        'patterns' => ['I like + [Noun / V-ing]', 'I don\'t like + [Noun / V-ing]', 'I enjoy + [V-ing]'],
                        'examples' => [
                            ['en' => 'I like reading books.', 'id' => 'Saya suka membaca buku.'],
                            ['en' => 'I enjoy playing football.', 'id' => 'Saya menikmati bermain sepak bola.'],
                            ['en' => 'I don\'t like waking up late.', 'id' => 'Saya tidak suka bangun terlambat.'],
                        ]
                    ],
                    'template' => "Hello everyone! Good morning.

My name is [Full Name]. I am [Age] years old. You can call me [Nick Name].

I am from [City/Country].

I am a/an [Profession].

In my free time, I like [Hobbies/Likes].

It is nice to meet you all. Thank you!",
                    'example' => "Hello! Good morning. How's it going?

My name is Student A. I am 20 years old.

I am from Jakarta, Indonesia, and I am an English teacher.

In my free time, I like reading books and playing football.

It is very nice to meet you all. Have a nice day!"
                ],
                'listening' => [
                    'title' => 'Short Listening: Student Introduction & Dialogue Practice',
                    'audio_script' => "Student A: Hello! Good morning. How's it going? Student B: Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name? Student A: My name is Student A. I'm 20 years old. Where are you from, Student B? Student B: I am from Sydney, Australia. I am an English instructor. What is your profession, Student A? Student A: I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football. Student B: That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A! Student A: It is nice to meet you too, Student B! Have a nice day and see you later!",
                    'key_phrases' => [
                        'How\'s it going? Everything is going great, thank you!',
                        'I am from Sydney, Australia. I am an English instructor.',
                        'I am an English teacher from Jakarta, Indonesia.',
                        'In my free time, I like reading books and playing football.',
                        'That is wonderful! I enjoy hiking in the mountains.',
                        'It is nice to meet you too! Have a nice day and see you later!',
                    ],
                    'questions' => [
                        [
                            'q' => 'Where is Student B from and what is her profession?',
                            'options' => [
                                'From Sydney, Australia; English instructor',
                                'From Jakarta, Indonesia; English teacher',
                                'From Bandung, Indonesia; Doctor',
                                'From London, UK; Engineer',
                            ],
                            'answer' => 'From Sydney, Australia; English instructor',
                        ],
                        [
                            'q' => 'Where is Student A from and what is his profession?',
                            'options' => [
                                'From Jakarta, Indonesia; English teacher',
                                'From Sydney, Australia; English instructor',
                                'From Tokyo, Japan; Pilot',
                                'From Melbourne, Australia; Doctor',
                            ],
                            'answer' => 'From Jakarta, Indonesia; English teacher',
                        ],
                        [
                            'q' => 'What hobbies are mentioned by Student A and Student B?',
                            'options' => [
                                'Student A likes reading & football; Student B enjoys hiking',
                                'Student A likes swimming; Student B likes cooking',
                                'Both students like playing video games',
                                'Student A likes dancing; Student B likes singing',
                            ],
                            'answer' => 'Student A likes reading & football; Student B enjoys hiking',
                        ],
                    ],
                ],
                'drilling1' => [
                    ['en' => 'Hello everyone! Good morning, my name is Student A.', 'id' => 'Halo semuanya! Selamat pagi, nama saya Student A.'],
                    ['en' => 'I am twenty years old, and you can call me Student A.', 'id' => 'Saya berumur dua puluh tahun, dan Anda bisa memanggil saya Student A.'],
                    ['en' => 'I am from Jakarta, Indonesia, and I am an English teacher.', 'id' => 'Saya berasal dari Jakarta, Indonesia, dan saya seorang guru bahasa Inggris.'],
                    ['en' => 'In my free time, I like reading books and playing football.', 'id' => 'Di waktu luang saya, saya suka membaca buku dan bermain sepak bola.'],
                    ['en' => 'It is very nice to meet all of you today.', 'id' => 'Sangat senang bertemu dengan Anda semua hari ini.'],
                ],
                'drilling2' => [
                    ['en' => 'Hi! Good morning. How\'s it going? Everything is going great, thank you!', 'id' => 'Hai! Selamat pagi. Bagaimana kabarmu? Semuanya baik-baik saja, terima kasih!'],
                    ['en' => 'I am from Sydney, Australia, and I am an English instructor.', 'id' => 'Saya berasal dari Sydney, Australia, dan saya seorang instruktur bahasa Inggris.'],
                    ['en' => 'What is your profession, and where are you from, Student A?', 'id' => 'Apa profesimu, dan dari mana asalmu, Student A?'],
                    ['en' => 'That is wonderful! In my free time, I enjoy hiking in the mountains.', 'id' => 'Luar biasa! Di waktu luang, saya menikmati mendaki gunung.'],
                    ['en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!', 'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!'],
                ],
                'grammar_note' => "Subject Pronouns (I, You, He, She, It, We, They) & Verb 'To Be' (am / is / are) | Contractions: I'm, You're, He's, She's, It's, We're, They're",
                'dialogue_setting' => 'Dua peserta kursus, Student A dan Student B, saling berkenalan di hari pertama kelas First Point Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Student A',
                        'en' => 'Hello! Good morning. How\'s it going?',
                        'id' => 'Halo! Selamat pagi. Bagaimana kabarmu?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name?',
                        'id' => 'Hai! Selamat pagi. Semuanya baik-baik saja, terima kasih! Nama saya Student B. Siapa nama kamu?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'My name is Student A. I\'m 20 years old. Where are you from, Student B?',
                        'id' => 'Nama saya Student A. Saya berumur 20 tahun. Dari mana asalmu, Student B?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'I am from Sydney, Australia. I am an English instructor. What is your profession, Student A?',
                        'id' => 'Saya berasal dari Sydney, Australia. Saya seorang instruktur bahasa Inggris. Apa profesimu, Student A?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football.',
                        'id' => 'Saya seorang guru bahasa Inggris dari Jakarta, Indonesia. Di waktu luang, saya suka membaca buku dan bermain sepak bola.',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A!',
                        'id' => 'Luar biasa! Saya menikmati mendaki gunung. Sangat senang berkenalan denganmu, Student A!',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!',
                        'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!',
                    ],
                ],
                'game' => [
                    'aim' => 'To find out information about members of the class by asking and answering questions.',
                    'grammar_functions' => 'Asking for and giving information. Questions with question words (what, who, when, where, how) and auxiliary verbs.',
                    'vocabulary' => 'Personal information, daily habits, favorites, and routines.',
                    'time' => '15 to 20 minutes',
                    'title' => 'Zoom Classroom Speaking Game: Worksheet 1b "Find Out" (Third Point Level)',
                    'grammar_focus' => 'WH-Questions (what, who, when, where, how), Auxiliary verbs, Superlatives, & Past Forms.',
                    'vocabulary_focus' => 'Personal information, routines, hobbies, holidays, family, & past events.',
                    'procedure' => [
                        '1. If there are more than 12 students in the class, divide them into groups. Give one card to each student.',
                        '2. Tell the students that they are responsible for finding the answer to the question on their own card by speaking to everybody in the class or group.',
                        '3. Now ask the students to go round the class or group, asking and answering questions. Make notes on what classmates answer.',
                        '4. When finished, take turns to report back to the class or group on what you found out during the activity.',
                    ],
                    'report_examples' => [
                        'In our group, Blue is the most popular colour.',
                        'In our class, Budi went to bed latest last night at 2:00 AM.',
                        'Watching television and playing football are the most popular leisure activities.',
                        'In our group, 8 out of 10 people have pets at home.'
                    ],
                    'cards' => [
                        [
                            'id' => 1,
                            'title' => "What's the most popular colour? Find out.",
                            'question' => "What is your favourite colour?",
                            'sample_answer' => "My favourite colour is [Blue / Red / Green / Black].",
                            'category' => 'Favorites',
                            'badge' => 'Colour Survey',
                            'image' => '/images/speaking/worksheet1b/colored/card_1.png?v=2026',
                        ],
                        [
                            'id' => 2,
                            'title' => "What's the most popular leisure activity? Find out.",
                            'question' => "What is your favourite leisure activity?",
                            'sample_answer' => "In my free time, I like [reading books / playing football / watching movies].",
                            'category' => 'Hobbies',
                            'badge' => 'Leisure Activity',
                            'image' => '/images/speaking/worksheet1b/colored/card_2.png?v=2026',
                        ],
                        [
                            'id' => 3,
                            'title' => "Who went to bed latest last night? Find out.",
                            'question' => "What time did you go to bed last night?",
                            'sample_answer' => "I went to bed at [11:00 PM / midnight / 1:30 AM].",
                            'category' => 'Habits',
                            'badge' => 'Sleep Routine',
                            'image' => '/images/speaking/worksheet1b/colored/card_3.png?v=2026',
                        ],
                        [
                            'id' => 4,
                            'title' => "Who ate the most for breakfast this morning? Find out.",
                            'question' => "What did you have for breakfast this morning?",
                            'sample_answer' => "I had [fried rice, two eggs, toast, and a glass of milk].",
                            'category' => 'Food & Routine',
                            'badge' => 'Breakfast',
                            'image' => '/images/speaking/worksheet1b/colored/card_4.png?v=2026',
                        ],
                        [
                            'id' => 5,
                            'title' => "Who's visited the most capital cities? Find out.",
                            'question' => "How many capital cities have you visited?",
                            'sample_answer' => "I have visited [3] capital cities: [Jakarta, Kuala Lumpur, and Bangkok].",
                            'category' => 'Travel',
                            'badge' => 'Capital Cities',
                            'image' => '/images/speaking/worksheet1b/colored/card_5.png?v=2026',
                        ],
                        [
                            'id' => 6,
                            'title' => "Who had the busiest weekend? Find out.",
                            'question' => "What did you do last weekend?",
                            'sample_answer' => "I [cleaned my room, visited my family, studied English, and went grocery shopping].",
                            'category' => 'Past Activities',
                            'badge' => 'Weekend',
                            'image' => '/images/speaking/worksheet1b/colored/card_6.png?v=2026',
                        ],
                        [
                            'id' => 7,
                            'title' => "Who's got the biggest family? Find out.",
                            'question' => "How many people are there in your family?",
                            'sample_answer' => "There are [6] people in my family: [my parents, two brothers, one sister, and me].",
                            'category' => 'Family',
                            'badge' => 'Family Size',
                            'image' => '/images/speaking/worksheet1b/colored/card_7.png?v=2026',
                        ],
                        [
                            'id' => 8,
                            'title' => "Who travelled furthest for their holidays last year? Find out.",
                            'question' => "Where did you go for your holidays last year?",
                            'sample_answer' => "I travelled to [Bali / Japan / Singapore / Yogyakarta] for my holiday.",
                            'category' => 'Vacation',
                            'badge' => 'Holiday Travel',
                            'image' => '/images/speaking/worksheet1b/colored/card_8.png?v=2026',
                        ],
                        [
                            'id' => 9,
                            'title' => "How many people have pets? Find out.",
                            'question' => "Do you have any pets at home?",
                            'sample_answer' => "Yes, I have [a cat / a dog / two birds]. / No, I do not have any pets.",
                            'category' => 'Personal Info',
                            'badge' => 'Pets Survey',
                            'image' => '/images/speaking/worksheet1b/colored/card_9.png?v=2026',
                        ],
                        [
                            'id' => 10,
                            'title' => "Who has been to the cinema most recently? Find out.",
                            'question' => "When did you last go to the cinema?",
                            'sample_answer' => "I went to the cinema [last night / last weekend / two days ago] and watched [a movie].",
                            'category' => 'Entertainment',
                            'badge' => 'Cinema & Movie',
                            'image' => '/images/speaking/worksheet1b/colored/card_10.png?v=2026',
                        ],
                        [
                            'id' => 11,
                            'title' => "Who is going to have their birthday next? Find out.",
                            'question' => "When is your birthday?",
                            'sample_answer' => "My birthday is on [the 15th of September / next month].",
                            'category' => 'Dates & Personal',
                            'badge' => 'Next Birthday',
                            'image' => '/images/speaking/worksheet1b/colored/card_11.png?v=2026',
                        ],
                        [
                            'id' => 12,
                            'title' => "What sort of music is most popular? Find out.",
                            'question' => "What sort of music do you like listening to?",
                            'sample_answer' => "I like listening to [Pop / Rock / Jazz / Classical / R&B] music.",
                            'category' => 'Music & Taste',
                            'badge' => 'Music Genre',
                            'image' => '/images/speaking/worksheet1b/colored/card_12.png?v=2026',
                        ],
                    ]
                ],
                'monolog_baku' => [
                    "Hello everyone! Good morning. My name is Budi Sugeng. I am 20 years old. You can call me Budi. I am from Jakarta, Indonesia. I am an English teacher. In my free time, I like reading books and playing football. It is nice to meet you all. Thank you!",
                    "Good afternoon, ladies and gentlemen. I am delighted to introduce myself. My name is Sarah Miller, and I am from Sydney, Australia. I work as an instructor, and I enjoy reading historical novels in my leisure time. It is a pleasure to meet everyone."
                ],
                'monolog_tidak_baku' => [
                    "Hi guys! Hey, how's it going? I'm Budi, 20 years old from Jakarta. I teach English and in my spare time I really love hanging out with friends and playing football. Super stoked to meet you all!",
                    "Hey everyone! What's up? I'm Sarah from Sydney. I'm into reading and outdoor hiking when I'm not working. Great to be here with you guys!"
                ],
                'questions_part_a' => [
                    'What is your full name and what is your nickname?',
                    'How old are you?',
                    'Where are you from (City & Country)?',
                    'What is your current profession or field of study?',
                    'What do you like doing in your free time?',
                ],
                'questions_part_b' => [
                    'How do you greet someone formally in the morning, afternoon, and evening?',
                    'What is the difference between "I like reading" and "I don\'t like reading"?',
                    'Can you introduce your best friend using "He is..." or "She is..."?',
                    'How do you say goodbye politely to your teacher at the end of class?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Complete Self-Introduction Showcase',
                'impromptu' => [
                    'Aktivitas 1: Sampaikan perkenalan diri lengkapmu tanpa membaca teks selama 60 detik mengikuti template Budi Sugeng!',
                    'Aktivitas 2: Lakukan perkenalan santai (informal greeting) seolah-olah kamu sedang berkenalan di kafe internasional.',
                    'Aktivitas 3: Jelaskan 3 hal yang paling kamu sukai (likes) dan 2 hal yang tidak kamu sukai (dislikes) dalam kehidupan sehari-hari.',
                    'Aktivitas 4: Rekam suaramu pada fitur Voice Recorder di bawah dan dengarkan kembali intonasimu!',
                ],
            ],
            2 => [
                'topic' => 'Simple Past Nominal',
                'focus' => 'Simple Past Nominal (was / were, wasn\'t / weren\'t), -ed pronunciation (/t/, /d/, /ɪd/), Eyewitness reports & Shopping queues',
                'listening' => [
                    'title' => 'Listening Practice: Eyewitness Testimony at Grand Central Store',
                    'audio_script' => 'Officer, I was right across the street when the incident occurred last night at 9:00 PM. The street lamps were exceptionally bright, and the storefront was fully illuminated. The witnesses were mostly tourists waiting in a souvenir queue. Everyone was calm until a loud commotion erupted near the entrance. I was certain that the manager was inside the premises.',
                    'key_phrases' => [
                        'I was right across the street',
                        'The witnesses were mostly tourists',
                        'The manager was inside the premises',
                    ],
                    'questions' => [
                        [
                            'q' => 'Where was the eyewitness standing when the incident took place?',
                            'options' => [
                                'Right across the street',
                                'Inside the bank vault',
                                'On the rooftop',
                                'At the subway terminal',
                            ],
                            'answer' => 'Right across the street',
                        ],
                        [
                            'q' => 'Who were the majority of the witnesses in the queue?',
                            'options' => [
                                'Tourists waiting in a souvenir queue',
                                'Police officers',
                                'Construction workers',
                                'Store cashiers',
                            ],
                            'answer' => 'Tourists waiting in a souvenir queue',
                        ],
                        [
                            'q' => 'Which past nominal form was used to describe the street lamps?',
                            'options' => [
                                'The street lamps were exceptionally bright',
                                'The street lamps are dim',
                                'The street lamps was broken',
                                'The street lamps will be replaced',
                            ],
                            'answer' => 'The street lamps were exceptionally bright',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I was in the conference hall when the presentation began yesterday.',
                        'id' => 'Saya berada di aula konferensi ketika presentasi dimulai kemarin.',
                    ],
                    [
                        'en' => 'The flight tickets were surprisingly affordable during the holiday season.',
                        'id' => 'Tiket penerbangan tersebut sangat terjangkau selama musim liburan.',
                    ],
                    [
                        'en' => 'She wasn\'t aware of the schedule change because she was on medical leave.',
                        'id' => 'Dia tidak menyadari perubahan jadwal tersebut karena dia sedang cuti sakit.',
                    ],
                    [
                        'en' => 'Were you present at the annual board meeting last Friday afternoon?',
                        'id' => 'Apakah Anda hadir pada rapat dewan tahunan Jumat sore yang lalu?',
                    ],
                    [
                        'en' => 'The museum exhibits were extraordinary and well preserved.',
                        'id' => 'Pameran museum tersebut luar biasa dan terawat dengan baik.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'The queue at the souvenir counter was extremely long and disorganized.',
                        'id' => 'Antrean di loket suvenir sangat panjang dan tidak teratur.',
                    ],
                    [
                        'en' => 'Eyewitnesses were confident that the suspect was tall and wore a navy jacket.',
                        'id' => 'Saksi mata yakin bahwa tersangka bertubuh tinggi dan mengenakan jaket biru tua.',
                    ],
                    [
                        'en' => 'It was a chilly, foggy evening in London when the incident occurred.',
                        'id' => 'Malam itu dingin dan berkabut di London saat peristiwa tersebut terjadi.',
                    ],
                    [
                        'en' => 'We were proud of our team\'s dedication during the international debate tournament.',
                        'id' => 'Kami bangga dengan dedikasi tim kami selama turnamen debat internasional.',
                    ],
                    [
                        'en' => 'Why were the store gates locked before the official closing hour?',
                        'id' => 'Mengapa gerbang toko dikunci sebelum jam tutup resmi?',
                    ],
                ],
                'grammar_note' => 'Past Nominal: I/He/She/It WAS | You/We/They WERE | Pronunciation of -ed: /t/ after voiceless (watched), /d/ after voiced (played), /ɪd/ after t/d (decided, visited)',
                'dialogue_setting' => 'Seorang polisi menginterogasi saksi mata, Bu Maya, terkait kejadian pencurian di pusat perbelanjaan tadi malam.',
                'dialogue' => [
                    [
                        'speaker' => 'Detective',
                        'en' => 'Good evening, Ma\'am. Were you near the boutique when the alarm sounded?',
                        'id' => 'Selamat malam, Bu. Apakah Anda berada di dekat butik saat alarm berbunyi?',
                    ],
                    [
                        'speaker' => 'Maya',
                        'en' => 'Yes, officer. I was in the souvenir queue right beside the main escalator.',
                        'id' => 'Ya, pak polisi. Saya berada di antrean suvenir persis di samping eskalator utama.',
                    ],
                    [
                        'speaker' => 'Detective',
                        'en' => 'Was the cashier alone, or were there security officers nearby?',
                        'id' => 'Apakah kasir sendirian, atau ada petugas keamanan di dekat sana?',
                    ],
                    [
                        'speaker' => 'Maya',
                        'en' => 'The cashier was alone at that moment. The security guards were on the second floor.',
                        'id' => 'Kasir sendirian pada saat itu. Petugas keamanan sedang berada di lantai dua.',
                    ],
                ],
                'monolog_baku' => [
                    'Memberikan kesaksian peristiwa masa lalu membutuhkan ketelitian dalam menggunakan bentuk lampau nominal (was/were). Setiap rincian seperti kondisi cuaca, pencahayaan, dan lokasi saksi sangat menentukan akurasi laporan investigasi.',
                    'Pelafalan akhiran -ed pada kata kerja lampau memiliki tiga variasi bunyi: bunyi /t/ seperti pada kata \'walked\', bunyi /d/ seperti pada \'opened\', dan bunyi /ɪd/ seperti pada \'started\'. Menguasai variasi bunyi ini membuat ucapan kita terdengar natural.',
                ],
                'monolog_tidak_baku' => [
                    'Tadi malem gue pas banget lagi ngantre beli oleh-oleh pas ada insiden rame-rame di mall. Suasananya sempet panik karena petugas keamanannya lagi gak di tempat.',
                    'Kalo ngomong kata kerja lampau kayak \'worked\' jangan dibaca work-ed ya, tapi bunyinya /t/ di ujungnya. Latihan pelafalan ini penting biar gak medok.',
                ],
                'questions_part_a' => [
                    'Di mana kamu berada jam 8 malam kemarin (Where were you)?',
                    'Bagaimana suasana sekolah atau kantormu saat pertama kali kamu bergabung dulu?',
                    'Apakah kamu pernah menjadi saksi mata (eyewitness) dari suatu peristiwa unik? Ceritakan suasananya!',
                    'Bagaimana cara membedakan pengucapan akhiran -ed pada kata "asked", "cleaned", dan "needed"?',
                    'Apakah belanja oleh-oleh (souvenir shopping) adalah hal wajib bagimu saat berlibur?',
                ],
                'questions_part_b' => [
                    'Bagaimana reaksimu ketika harus menunggu di antrean yang sangat panjang (long queue)?',
                    'Apakah kamu merasa puas dengan prestasimu saat masih di jenjang sekolah sebelumnya?',
                    'Siapa orang yang paling berjasa dalam hidupmu di masa lampau?',
                    'Buat 3 kalimat tanya menggunakan "Were you..." dan 3 kalimat menggunakan "Was it..."!',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Last Night Eyewitness & The Queue Simulation',
                'impromptu' => [
                    'Aktivitas "Eyewitness Report": Rekam laporan kesaksian selama 2 menit sebagai saksi kunci dari sebuah insiden misterius dengan mendeskripsikan secara detail lokasi, orang, dan suasananya menggunakan "was/were".',
                    'Aktivitas "The Queue Complaint": Sampaikan keluhan formal kepada pengelola toko mengenai antrean yang tidak tertib menggunakan kalimat lampau.',
                    'Diskusikan keandalan memori saksi mata manusia dalam proses peradilan hukum.',
                    'Mengapa ketepatan pelafalan (*phonetic endings*) sangat berpengaruh terhadap persepsi profesionalisme seseorang?',
                ],
            ],
            3 => [
                'topic' => 'Simple Past Verbal & irregular verbs',
                'focus' => 'Simple Past Verbal with all common irregular verbs (went, saw, took, thought, bought, brought, caught), Crime investigation & Roleplay',
                'listening' => [
                    'title' => 'Listening Practice: Simple Past Verbal & irregular verbs',
                    'audio_script' => 'Detective Miller investigated the mysterious case of Robin Koch yesterday. He arrived at the estate at dawn, interviewed three key suspects, found a hidden diary under the floorboards, and gathered crucial forensic evidence that unlocked the entire mystery.',
                    'key_phrases' => [
                        'The suspect fled the scene before the authorities arrived.',
                        'She found an encrypted flash drive hidden inside the bookshelf.',
                        'The detective interrogated the butler regarding his whereabouts.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Simple Past Verbal & irregular verbs',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Simple Past Verbal & irregular verbs',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'The suspect fled the scene before the authorities arrived.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'The suspect fled the scene before the authorities arrived.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering simple past verbal & irregular verbs?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The suspect fled the scene before the authorities arrived.',
                        'id' => 'Tersangka melarikan diri dari tempat kejadian sebelum pihak berwenang tiba.',
                    ],
                    [
                        'en' => 'She found an encrypted flash drive hidden inside the bookshelf.',
                        'id' => 'Dia menemukan diska lepas terenkripsi yang tersembunyi di dalam rak buku.',
                    ],
                    [
                        'en' => 'The detective interrogated the butler regarding his whereabouts.',
                        'id' => 'Detektif menginterogasi kepala pelayan mengenai keberadaannya.',
                    ],
                    [
                        'en' => 'He proved his innocence by showing timestamped receipts.',
                        'id' => 'Dia membuktikan ketidakbersalahannya dengan menunjukkan kuitansi bertanda waktu.',
                    ],
                    [
                        'en' => 'They solved the complex puzzle after analyzing forensic fingerprints.',
                        'id' => 'Mereka memecahkan teka-teki rumit tersebut setelah menganalisis sidik jari forensik.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for simple past verbal & irregular verbs rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk simple past verbal & irregular verbs secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Irregular Verbs: fly-flew, freeze-froze, rise-rose, choose-chose, speak-spoke, take-took, break-broke',
                'pronunciation_tip' => 'Pelafalan vokal pendek vs panjang pada kata kerja bentuk lampau (e.g. read /riːd/ vs read /rɛd/)',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Simple Past Verbal & irregular verbs dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Simple Past Verbal & irregular verbs elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Simple Past Verbal & irregular verbs meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "The suspect fled the scene before the authorities arrived.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "The suspect fled the scene before the authorities arrived.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Simple Past Verbal & irregular verbs di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Irregular Verbs: fly-flew, freeze-froze, rise-rose, choose-chose, speak-spoke, take-took, break-broke memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Simple Past Verbal & irregular verbs ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Simple Past Verbal & irregular verbs membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Irregular Verbs!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Pelafalan vokal pendek vs panjang pada kata kerja bentuk lampau (e.g. read /riːd/ vs read /rɛd/)) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Simple Past Verbal & irregular verbs Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Simple Past Verbal & irregular verbs dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Irregular Verbs: fly-flew, freeze-froze, rise-rose, choose-chose, speak-spoke, take-took, break-broke meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            4 => [
                'topic' => 'Simple past & Past Continuous',
                'focus' => 'Interrupted past actions (Past Continuous: was/were + V-ing interrupted by Simple Past with when/while), Scene of the crime & Storytelling',
                'listening' => [
                    'title' => 'Listening Practice: Simple past & Past Continuous',
                    'audio_script' => 'While Detective Watson was examining the library window, a strange silhouette suddenly dashed across the garden courtyard. Heavy rain was pouring relentlessly as thunder shook the mansion. When the lights flickered, the intruder vanished into the dark.',
                    'key_phrases' => [
                        'I was writing my thesis when the power outage suddenly occurred.',
                        'While the professor was lecturing, students were taking detailed notes.',
                        'The storm was howling violently while the rescue team was searching for survivors.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Simple past & Past Continuous',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Simple past & Past Continuous',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'I was writing my thesis when the power outage suddenly occurred.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'I was writing my thesis when the power outage suddenly occurred.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering simple past & past continuous?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I was writing my thesis when the power outage suddenly occurred.',
                        'id' => 'Saya sedang menulis tesis saya ketika pemadaman listrik tiba-tiba terjadi.',
                    ],
                    [
                        'en' => 'While the professor was lecturing, students were taking detailed notes.',
                        'id' => 'Saat profesor sedang memberikan kuliah, para mahasiswa sedang mencatat dengan saksama.',
                    ],
                    [
                        'en' => 'The storm was howling violently while the rescue team was searching for survivors.',
                        'id' => 'Badai sedang menderu hebat saat tim penyelamat sedang mencari korban selamat.',
                    ],
                    [
                        'en' => 'She met her childhood mentor while she was traveling in Switzerland.',
                        'id' => 'Dia bertemu mentor masa kecilnya saat dia sedang bepergian di Swiss.',
                    ],
                    [
                        'en' => 'What were you doing at nine o\'clock when the fire alarm rang?',
                        'id' => 'Apa yang sedang Anda lakukan pada pukul sembilan ketika alarm kebakaran berbunyi?',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for simple past & past continuous rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk simple past & past continuous secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Past Continuous (ongoing background: was walking) + When + Simple Past (interruption: heard a scream) | While + Past Continuous',
                'pronunciation_tip' => 'Pengucapan penghubung waktu: "while" /waɪl/ dan "when" /wɛn/ dengan intonasi klausa bertingkat',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Simple past & Past Continuous dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Simple past & Past Continuous elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Simple past & Past Continuous meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "I was writing my thesis when the power outage suddenly occurred.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "I was writing my thesis when the power outage suddenly occurred.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Simple past & Past Continuous di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Past Continuous (ongoing background: was walking) + When + Simple Past (interruption: heard a scream) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Simple past & Past Continuous ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Simple past & Past Continuous membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Past Continuous (ongoing background!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Pengucapan penghubung waktu: "while" /waɪl/ dan "when" /wɛn/ dengan intonasi klausa bertingkat) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Simple past & Past Continuous Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Simple past & Past Continuous dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Past Continuous (ongoing background: was walking) + When + Simple Past (interruption: heard a scream) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            5 => [
                'topic' => 'Modals & Degrees certainty (Past time)',
                'focus' => 'Past Modals of Deduction: must have, might have, could have, can\'t have + V3, Past form of should (should have + V3), Would for past repeated action',
                'listening' => [
                    'title' => 'Listening Practice: Modals & Degrees certainty (Past time)',
                    'audio_script' => 'The artifact is missing from the locked vault; the thief must have known the security passcode in advance! They can\'t have broken in through the steel doors without triggering sirens. The security team should have updated the encryption protocols last month.',
                    'key_phrases' => [
                        'The streets are soaking wet; it must have rained heavily overnight.',
                        'He can\'t have committed the fraud because he was abroad with verifiable records.',
                        'We should have double-checked the contract terms before signing the agreement.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Modals & Degrees certainty (Past time)',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Modals & Degrees certainty (Past time)',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'The streets are soaking wet; it must have rained heavily overnight.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'The streets are soaking wet; it must have rained heavily overnight.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering modals & degrees certainty (past time)?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The streets are soaking wet; it must have rained heavily overnight.',
                        'id' => 'Jalanan basah kuyup; pasti hujan lebat turun semalaman.',
                    ],
                    [
                        'en' => 'He can\'t have committed the fraud because he was abroad with verifiable records.',
                        'id' => 'Dia tidak mungkin melakukan penipuan tersebut karena dia sedang di luar negeri dengan catatan terverifikasi.',
                    ],
                    [
                        'en' => 'We should have double-checked the contract terms before signing the agreement.',
                        'id' => 'Kita seharusnya memeriksa ulang syarat kontrak sebelum menandatangani perjanjian tersebut.',
                    ],
                    [
                        'en' => 'She might have taken a different flight due to the airport cancellation.',
                        'id' => 'Dia mungkin telah mengambil penerbangan lain karena pembatalan di bandara.',
                    ],
                    [
                        'en' => 'Every summer, my grandfather would sit on the porch and recount historical tales.',
                        'id' => 'Setiap musim panas, kakek saya biasa duduk di serambi dan menceritakan kisah-kisah sejarah.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for modals & degrees certainty (past time) rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk modals & degrees certainty (past time) secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Past Deductions: Must have + V3 (95% sure it happened) | Can\'t have + V3 (impossible) | Might/Could have + V3 (possible) | Should have + V3 (regret/unfulfilled obligation)',
                'pronunciation_tip' => 'Bentuk reduksi cepat: "must\'ve" /mʌstəv/, "should\'ve" /ʃʊdəv/, "could\'ve" /kʊdəv/',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Modals & Degrees certainty (Past time) dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Modals & Degrees certainty (Past time) elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Modals & Degrees certainty (Past time) meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "The streets are soaking wet; it must have rained heavily overnight.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "The streets are soaking wet; it must have rained heavily overnight.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Modals & Degrees certainty (Past time) di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Past Deductions: Must have + V3 (95% sure it happened) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Modals & Degrees certainty (Past time) ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Modals & Degrees certainty (Past time) membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Past Deductions!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Bentuk reduksi cepat: "must\'ve" /mʌstəv/, "should\'ve" /ʃʊdəv/, "could\'ve" /kʊdəv/) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Modals & Degrees certainty (Past time) Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Modals & Degrees certainty (Past time) dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Past Deductions: Must have + V3 (95% sure it happened) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            6 => [
                'topic' => 'Present Perfect',
                'focus' => 'Present Perfect (have/has + V3) for life experiences, recent achievements, unfinished timeframes (since, for, already, yet, ever, never), Job Interview 2',
                'listening' => [
                    'title' => 'Listening Practice: Present Perfect',
                    'audio_script' => 'Over the past eight years, I have spearheaded numerous digital transformation initiatives across Southeast Asia. I have collaborated with multidisciplinary teams, expanded our market reach by forty percent, and published three industry whitepapers. Have you ever managed cross-border operations?',
                    'key_phrases' => [
                        'I have traveled to over twenty countries and negotiated cross-border contracts.',
                        'She has already published two bestselling academic textbooks on linguistics.',
                        'We have lived in this metropolitan area since January 2018.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Present Perfect',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Present Perfect',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'I have traveled to over twenty countries and negotiated cross-border contracts.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'I have traveled to over twenty countries and negotiated cross-border contracts.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering present perfect?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I have traveled to over twenty countries and negotiated cross-border contracts.',
                        'id' => 'Saya telah bepergian ke lebih dari dua puluh negara dan menegosiasikan kontrak lintas batas.',
                    ],
                    [
                        'en' => 'She has already published two bestselling academic textbooks on linguistics.',
                        'id' => 'Dia telah menerbitkan dua buku teks akademik terlaris tentang linguistik.',
                    ],
                    [
                        'en' => 'We have lived in this metropolitan area since January 2018.',
                        'id' => 'Kami telah tinggal di kawasan metropolitan ini sejak Januari 2018.',
                    ],
                    [
                        'en' => 'Have you ever resolved a major crisis under tight project deadlines?',
                        'id' => 'Pernahkah Anda menyelesaikan krisis besar di bawah tenggat waktu proyek yang ketat?',
                    ],
                    [
                        'en' => 'Our engineering team has just deployed the latest software patch.',
                        'id' => 'Tim teknik kami baru saja meluncurkan pembaruan perangkat lunak terbaru.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for present perfect rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk present perfect secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Present Perfect: Have/Has + Past Participle (V3) | Ever (in questions) vs Never | Already (positive) vs Yet (questions & negatives) | Since (point in time) vs For (duration)',
                'pronunciation_tip' => 'Penekanan kata keterangan waktu: already, yet, recently, so far, ever',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Present Perfect dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Present Perfect elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Present Perfect meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "I have traveled to over twenty countries and negotiated cross-border contracts.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "I have traveled to over twenty countries and negotiated cross-border contracts.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Present Perfect di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Present Perfect: Have/Has + Past Participle (V3) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Present Perfect ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Present Perfect membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Present Perfect!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Penekanan kata keterangan waktu: already, yet, recently, so far, ever) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Present Perfect Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Present Perfect dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Present Perfect: Have/Has + Past Participle (V3) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            7 => [
                'topic' => 'Past perfect & Present Perfect continuous',
                'focus' => 'Past Perfect (had + V3 for earlier past action) vs Present Perfect Continuous (have/has been + V-ing for ongoing duration), Criminal investigations',
                'listening' => [
                    'title' => 'Listening Practice: Past perfect & Present Perfect continuous',
                    'audio_script' => 'By the time the police arrived at the harbor, the cargo ship had already departed. The investigators have been analyzing surveillance camera footage for the past forty-eight hours without a break to track the vessel\'s destination.',
                    'key_phrases' => [
                        'By the time I reached the airport, the flight had already taken off.',
                        'She has been studying international maritime law for five consecutive years.',
                        'He had been driving for eight hours before he finally stopped to rest.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Past perfect & Present Perfect continuous',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Past perfect & Present Perfect continuous',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'By the time I reached the airport, the flight had already taken off.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'By the time I reached the airport, the flight had already taken off.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering past perfect & present perfect continuous?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'By the time I reached the airport, the flight had already taken off.',
                        'id' => 'Pada saat saya tiba di bandara, pesawat sudah lepas landas.',
                    ],
                    [
                        'en' => 'She has been studying international maritime law for five consecutive years.',
                        'id' => 'Dia telah belajar hukum maritim internasional selama lima tahun berturut-turut.',
                    ],
                    [
                        'en' => 'He had been driving for eight hours before he finally stopped to rest.',
                        'id' => 'Dia telah mengemudi selama delapan jam sebelum akhirnya dia berhenti untuk beristirahat.',
                    ],
                    [
                        'en' => 'They hadn\'t realized the magnitude of the problem until the audit report arrived.',
                        'id' => 'Mereka belum menyadari besarnya masalah tersebut hingga laporan audit tiba.',
                    ],
                    [
                        'en' => 'We have been working tirelessly to modernize our course curriculum.',
                        'id' => 'Kami telah bekerja tanpa lelah untuk memodernisasi kurikulum kursus kami.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for past perfect & present perfect continuous rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk past perfect & present perfect continuous secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Past Perfect (Action 1: Had done) happened before Simple Past (Action 2: Happened) | Present Perfect Continuous: Have been doing (focus on duration/process)',
                'pronunciation_tip' => 'Kontraksi subjek dengan had: I\'d, they\'d, she\'d dan have been: I\'ve been',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Past perfect & Present Perfect continuous dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Past perfect & Present Perfect continuous elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Past perfect & Present Perfect continuous meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "By the time I reached the airport, the flight had already taken off.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "By the time I reached the airport, the flight had already taken off.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Past perfect & Present Perfect continuous di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Past Perfect (Action 1: Had done) happened before Simple Past (Action 2: Happened) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Past perfect & Present Perfect continuous ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Past perfect & Present Perfect continuous membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Past Perfect (Action 1!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Kontraksi subjek dengan had: I\'d, they\'d, she\'d dan have been: I\'ve been) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Past perfect & Present Perfect continuous Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Past perfect & Present Perfect continuous dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Past Perfect (Action 1: Had done) happened before Simple Past (Action 2: Happened) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            8 => [
                'topic' => 'Passive Voice (Present & Past)',
                'focus' => 'Passive Voice in Present (is/are + V3) and Past (was/were + V3), Stative passive, Get + V3, Amazing scientific facts',
                'listening' => [
                    'title' => 'Listening Practice: Passive Voice (Present & Past)',
                    'audio_script' => 'Penicillin was discovered accidentally by Alexander Fleming in 1928. Today, life-saving antibiotics are manufactured in state-of-the-art sterile laboratories and distributed to hospitals worldwide to cure bacterial infections.',
                    'key_phrases' => [
                        'The ancient Pyramids of Giza were constructed thousands of years ago.',
                        'Over seventy percent of the Earth\'s surface is covered by vast oceans.',
                        'The historical documents are securely preserved inside climate-controlled archives.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Passive Voice (Present & Past)',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Passive Voice (Present & Past)',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'The ancient Pyramids of Giza were constructed thousands of years ago.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'The ancient Pyramids of Giza were constructed thousands of years ago.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering passive voice (present & past)?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The ancient Pyramids of Giza were constructed thousands of years ago.',
                        'id' => 'Piramida kuno Giza dibangun ribuan tahun yang lalu.',
                    ],
                    [
                        'en' => 'Over seventy percent of the Earth\'s surface is covered by vast oceans.',
                        'id' => 'Lebih dari tujuh puluh persen permukaan Bumi tertutup oleh lautan luas.',
                    ],
                    [
                        'en' => 'The historical documents are securely preserved inside climate-controlled archives.',
                        'id' => 'Dokumen sejarah tersebut tersimpan aman di dalam arsip berpengatur suhu.',
                    ],
                    [
                        'en' => 'Several outdated regulations got abolished during the parliamentary session.',
                        'id' => 'Beberapa peraturan usang dihapuskan selama sidang parlemen.',
                    ],
                    [
                        'en' => 'Renewable solar panels are installed on millions of residential rooftops globally.',
                        'id' => 'Panel surya terbarukan dipasang di jutaan atap rumah di seluruh dunia.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for passive voice (present & past) rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk passive voice (present & past) secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Passive Voice: Subject + be (conjugated) + Past Participle (V3) + by Agent | Stative passive: The door is locked / The glass is broken',
                'pronunciation_tip' => 'Pelafalan ritme kalimat pasif dengan penekanan pada kata kerja bentuk ketiga (V3)',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Passive Voice (Present & Past) dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Passive Voice (Present & Past) elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Passive Voice (Present & Past) meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "The ancient Pyramids of Giza were constructed thousands of years ago.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "The ancient Pyramids of Giza were constructed thousands of years ago.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Passive Voice (Present & Past) di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Passive Voice: Subject + be (conjugated) + Past Participle (V3) + by Agent memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Passive Voice (Present & Past) ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Passive Voice (Present & Past) membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Passive Voice!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Pelafalan ritme kalimat pasif dengan penekanan pada kata kerja bentuk ketiga (V3)) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Passive Voice (Present & Past) Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Passive Voice (Present & Past) dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Passive Voice: Subject + be (conjugated) + Past Participle (V3) + by Agent meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            9 => [
                'topic' => 'Causative Verb & Tag Question Past',
                'focus' => 'Causative Verbs (Active: Have/Make/Let someone do, Get someone to do; Passive: Have/Get something done), Tag questions in the past',
                'listening' => [
                    'title' => 'Listening Practice: Causative Verb & Tag Question Past',
                    'audio_script' => 'The CEO had the chief architect redesign the headquarters to incorporate green building standards. You had your legal documents certified by a notary public yesterday, didn\'t you?',
                    'key_phrases' => [
                        'The professor made the students revise their research methodologies.',
                        'She got her business partner to agree to the international merger terms.',
                        'I had my vehicle serviced by certified technicians before the road trip.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Causative Verb & Tag Question Past',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Causative Verb & Tag Question Past',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'The professor made the students revise their research methodologies.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'The professor made the students revise their research methodologies.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering causative verb & tag question past?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The professor made the students revise their research methodologies.',
                        'id' => 'Profesor tersebut menyuruh para mahasiswa merevisi metodologi penelitian mereka.',
                    ],
                    [
                        'en' => 'She got her business partner to agree to the international merger terms.',
                        'id' => 'Dia berhasil membujuk mitra bisnisnya untuk menyetujui syarat penggabungan internasional.',
                    ],
                    [
                        'en' => 'I had my vehicle serviced by certified technicians before the road trip.',
                        'id' => 'Saya menyervis kendaraan saya oleh teknisi tersertifikasi sebelum perjalanan jauh.',
                    ],
                    [
                        'en' => 'They let the interns lead the client presentation last Thursday.',
                        'id' => 'Mereka mengizinkan para pemagang memimpin presentasi klien Kamis lalu.',
                    ],
                    [
                        'en' => 'You attended the international economic summit in Geneva, didn\'t you?',
                        'id' => 'Anda menghadiri pertemuan puncak ekonomi internasional di Jenewa, bukan?',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for causative verb & tag question past rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk causative verb & tag question past secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Active Causative: Make + person + V1 (force) | Have + person + V1 (assign) | Get + person + TO V1 (persuade) | Let + person + V1 (allow) | Passive Causative: Have/Get + object + V3',
                'pronunciation_tip' => 'Tag Question Intonation: Falling tone when confirming information known, Rising tone when genuinely inquiring',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Causative Verb & Tag Question Past dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Causative Verb & Tag Question Past elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Causative Verb & Tag Question Past meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "The professor made the students revise their research methodologies.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "The professor made the students revise their research methodologies.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Causative Verb & Tag Question Past di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Active Causative: Make + person + V1 (force) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Causative Verb & Tag Question Past ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Causative Verb & Tag Question Past membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Active Causative!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Tag Question Intonation: Falling tone when confirming information known, Rising tone when genuinely inquiring) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Causative Verb & Tag Question Past Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Causative Verb & Tag Question Past dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Active Causative: Make + person + V1 (force) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            10 => [
                'topic' => 'MODAL TAMBAHAN & to infinitives complex',
                'focus' => 'Modal tambahan (semi-modals, modal idioms: be bound to, be likely to, would sooner, had better), Complex to-infinitives (passive infinitives, perfect infinitives), Debates',
                'listening' => [
                    'title' => 'Listening Practice: MODAL TAMBAHAN & to infinitives complex',
                    'audio_script' => 'In an era of rapid technological disruption, organizations are bound to embrace continuous innovation. Leaders are supposed to be equipped with ethical foresight so as to navigate complex global challenges successfully.',
                    'key_phrases' => [
                        'With such thorough preparation, your team is bound to win the debate competition.',
                        'Renewable energy prices are likely to decrease significantly over the coming decade.',
                        'Every citizen deserves to be treated with equal dignity and justice under the law.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'MODAL TAMBAHAN & to infinitives complex',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'MODAL TAMBAHAN & to infinitives complex',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'With such thorough preparation, your team is bound to win the debate competition.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'With such thorough preparation, your team is bound to win the debate competition.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering modal tambahan & to infinitives complex?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'With such thorough preparation, your team is bound to win the debate competition.',
                        'id' => 'Dengan persiapan yang begitu matang, tim Anda pasti akan memenangkan kompetisi debat.',
                    ],
                    [
                        'en' => 'Renewable energy prices are likely to decrease significantly over the coming decade.',
                        'id' => 'Harga energi terbarukan kemungkinan besar akan turun secara signifikan selama dekade mendatang.',
                    ],
                    [
                        'en' => 'Every citizen deserves to be treated with equal dignity and justice under the law.',
                        'id' => 'Setiap warga negara berhak untuk diperlakukan dengan martabat dan keadilan yang setara di bawah hukum.',
                    ],
                    [
                        'en' => 'The archaeologist claims to have uncovered remnants of an ancient lost civilization.',
                        'id' => 'Arkeolog tersebut mengklaim telah menemukan sisa-sisa peradaban kuno yang hilang.',
                    ],
                    [
                        'en' => 'We implement rigorous quality checks so as to ensure zero defect rates in production.',
                        'id' => 'Kami menerapkan pemeriksaan kualitas yang ketat guna memastikan tingkat kecacatan nol dalam produksi.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for modal tambahan & to infinitives complex rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk modal tambahan & to infinitives complex secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Complex Infinitives: Passive infinitive (to be + V3: hopes to be nominated) | Perfect infinitive (to have + V3: claims to have discovered) | Semi-modals: be bound to (certain), be likely to (probable)',
                'pronunciation_tip' => 'Artikulasi formal dan modulasi vokal dalam debat tingkat tinggi (*high-stakes debates*)',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai MODAL TAMBAHAN & to infinitives complex dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering MODAL TAMBAHAN & to infinitives complex elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan MODAL TAMBAHAN & to infinitives complex meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "With such thorough preparation, your team is bound to win the debate competition.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "With such thorough preparation, your team is bound to win the debate competition.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi MODAL TAMBAHAN & to infinitives complex di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Complex Infinitives: Passive infinitive (to be + V3: hopes to be nominated) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi MODAL TAMBAHAN & to infinitives complex ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik MODAL TAMBAHAN & to infinitives complex membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Complex Infinitives!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Artikulasi formal dan modulasi vokal dalam debat tingkat tinggi (*high-stakes debates*)) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – MODAL TAMBAHAN & to infinitives complex Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi MODAL TAMBAHAN & to infinitives complex dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Complex Infinitives: Passive infinitive (to be + V3: hopes to be nominated) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
        ];

        return $data[$meeting] ?? $data[1];
    }

    private function getProficiencyMeetingContent(int $meeting): array
    {
        $data = [
            1 => [
                'topic' => 'Introduction and Greetings',
                'focus' => 'Greetings & Farewells, Basic Self-Introduction, Personal Pronouns & To Be, Likes & Hobbies',
                'materi' => [
                    'greetings' => [
                        'formal' => [
                            ['en' => 'Good morning', 'id' => 'Selamat pagi (06:00 - 12:00)'],
                            ['en' => 'Good afternoon', 'id' => 'Selamat siang / sore (12:00 - 18:00)'],
                            ['en' => 'Good evening', 'id' => 'Selamat malam (18:00+)'],
                        ],
                        'informal' => [
                            ['en' => 'Hi!', 'id' => 'Hai!'],
                            ['en' => 'Hey! How\'s it going?', 'id' => 'Hei! Bagaimana kabarmu?'],
                        ],
                        'closing' => [
                            ['en' => 'Goodbye', 'id' => 'Selamat tinggal / Sampai jumpa'],
                            ['en' => 'See you later', 'id' => 'Sampai jumpa lagi nanti'],
                            ['en' => 'Have a nice day', 'id' => 'Semoga harimu menyenangkan'],
                        ]
                    ],
                    'self_intro_templates' => [
                        ['label' => 'Name', 'pattern' => 'My name is [Name] / I\'m [Name]', 'example' => 'My name is Budi Sugeng / I\'m Budi.'],
                        ['label' => 'Age', 'pattern' => 'I am [number] years old', 'example' => 'I am 20 years old.'],
                        ['label' => 'Origin', 'pattern' => 'I am from [Country/City]', 'example' => 'I am from Jakarta, Indonesia.'],
                        ['label' => 'Profession', 'pattern' => 'I am a/an [Profession]', 'example' => 'I am an English teacher.'],
                    ],
                    'grammar_basics' => [
                        'subject_pronouns' => ['I', 'You', 'He', 'She', 'It', 'We', 'They'],
                        'to_be_conjugations' => [
                            ['subject' => 'I', 'to_be' => 'am', 'contraction' => 'I\'m', 'example' => 'I am a teacher.'],
                            ['subject' => 'You', 'to_be' => 'are', 'contraction' => 'You\'re', 'example' => 'You are my student.'],
                            ['subject' => 'We', 'to_be' => 'are', 'contraction' => 'We\'re', 'example' => 'We are in the classroom.'],
                            ['subject' => 'They', 'to_be' => 'are', 'contraction' => 'They\'re', 'example' => 'They are friendly.'],
                            ['subject' => 'He', 'to_be' => 'is', 'contraction' => 'He\'s', 'example' => 'He is 20 years old.'],
                            ['subject' => 'She', 'to_be' => 'is', 'contraction' => 'She\'s', 'example' => 'She is from Jakarta.'],
                            ['subject' => 'It', 'to_be' => 'is', 'contraction' => 'It\'s', 'example' => 'It is nice to meet you.'],
                        ]
                    ],
                    'likes_hobbies' => [
                        'patterns' => ['I like + [Noun / V-ing]', 'I don\'t like + [Noun / V-ing]', 'I enjoy + [V-ing]'],
                        'examples' => [
                            ['en' => 'I like reading books.', 'id' => 'Saya suka membaca buku.'],
                            ['en' => 'I enjoy playing football.', 'id' => 'Saya menikmati bermain sepak bola.'],
                            ['en' => 'I don\'t like waking up late.', 'id' => 'Saya tidak suka bangun terlambat.'],
                        ]
                    ],
                    'template' => "Hello everyone! Good morning.

My name is [Full Name]. I am [Age] years old. You can call me [Nick Name].

I am from [City/Country].

I am a/an [Profession].

In my free time, I like [Hobbies/Likes].

It is nice to meet you all. Thank you!",
                    'example' => "Hello! Good morning. How's it going?

My name is Student A. I am 20 years old.

I am from Jakarta, Indonesia, and I am an English teacher.

In my free time, I like reading books and playing football.

It is very nice to meet you all. Have a nice day!"
                ],
                'listening' => [
                    'title' => 'Short Listening: Student Introduction & Dialogue Practice',
                    'audio_script' => "Student A: Hello! Good morning. How's it going? Student B: Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name? Student A: My name is Student A. I'm 20 years old. Where are you from, Student B? Student B: I am from Sydney, Australia. I am an English instructor. What is your profession, Student A? Student A: I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football. Student B: That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A! Student A: It is nice to meet you too, Student B! Have a nice day and see you later!",
                    'key_phrases' => [
                        'How\'s it going? Everything is going great, thank you!',
                        'I am from Sydney, Australia. I am an English instructor.',
                        'I am an English teacher from Jakarta, Indonesia.',
                        'In my free time, I like reading books and playing football.',
                        'That is wonderful! I enjoy hiking in the mountains.',
                        'It is nice to meet you too! Have a nice day and see you later!',
                    ],
                    'questions' => [
                        [
                            'q' => 'Where is Student B from and what is her profession?',
                            'options' => [
                                'From Sydney, Australia; English instructor',
                                'From Jakarta, Indonesia; English teacher',
                                'From Bandung, Indonesia; Doctor',
                                'From London, UK; Engineer',
                            ],
                            'answer' => 'From Sydney, Australia; English instructor',
                        ],
                        [
                            'q' => 'Where is Student A from and what is his profession?',
                            'options' => [
                                'From Jakarta, Indonesia; English teacher',
                                'From Sydney, Australia; English instructor',
                                'From Tokyo, Japan; Pilot',
                                'From Melbourne, Australia; Doctor',
                            ],
                            'answer' => 'From Jakarta, Indonesia; English teacher',
                        ],
                        [
                            'q' => 'What hobbies are mentioned by Student A and Student B?',
                            'options' => [
                                'Student A likes reading & football; Student B enjoys hiking',
                                'Student A likes swimming; Student B likes cooking',
                                'Both students like playing video games',
                                'Student A likes dancing; Student B likes singing',
                            ],
                            'answer' => 'Student A likes reading & football; Student B enjoys hiking',
                        ],
                    ],
                ],
                'drilling1' => [
                    ['en' => 'Hello everyone! Good morning, my name is Student A.', 'id' => 'Halo semuanya! Selamat pagi, nama saya Student A.'],
                    ['en' => 'I am twenty years old, and you can call me Student A.', 'id' => 'Saya berumur dua puluh tahun, dan Anda bisa memanggil saya Student A.'],
                    ['en' => 'I am from Jakarta, Indonesia, and I am an English teacher.', 'id' => 'Saya berasal dari Jakarta, Indonesia, dan saya seorang guru bahasa Inggris.'],
                    ['en' => 'In my free time, I like reading books and playing football.', 'id' => 'Di waktu luang saya, saya suka membaca buku dan bermain sepak bola.'],
                    ['en' => 'It is very nice to meet all of you today.', 'id' => 'Sangat senang bertemu dengan Anda semua hari ini.'],
                ],
                'drilling2' => [
                    ['en' => 'Hi! Good morning. How\'s it going? Everything is going great, thank you!', 'id' => 'Hai! Selamat pagi. Bagaimana kabarmu? Semuanya baik-baik saja, terima kasih!'],
                    ['en' => 'I am from Sydney, Australia, and I am an English instructor.', 'id' => 'Saya berasal dari Sydney, Australia, dan saya seorang instruktur bahasa Inggris.'],
                    ['en' => 'What is your profession, and where are you from, Student A?', 'id' => 'Apa profesimu, dan dari mana asalmu, Student A?'],
                    ['en' => 'That is wonderful! In my free time, I enjoy hiking in the mountains.', 'id' => 'Luar biasa! Di waktu luang, saya menikmati mendaki gunung.'],
                    ['en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!', 'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!'],
                ],
                'grammar_note' => "Subject Pronouns (I, You, He, She, It, We, They) & Verb 'To Be' (am / is / are) | Contractions: I'm, You're, He's, She's, It's, We're, They're",
                'dialogue_setting' => 'Dua peserta kursus, Student A dan Student B, saling berkenalan di hari pertama kelas First Point Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Student A',
                        'en' => 'Hello! Good morning. How\'s it going?',
                        'id' => 'Halo! Selamat pagi. Bagaimana kabarmu?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name?',
                        'id' => 'Hai! Selamat pagi. Semuanya baik-baik saja, terima kasih! Nama saya Student B. Siapa nama kamu?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'My name is Student A. I\'m 20 years old. Where are you from, Student B?',
                        'id' => 'Nama saya Student A. Saya berumur 20 tahun. Dari mana asalmu, Student B?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'I am from Sydney, Australia. I am an English instructor. What is your profession, Student A?',
                        'id' => 'Saya berasal dari Sydney, Australia. Saya seorang instruktur bahasa Inggris. Apa profesimu, Student A?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football.',
                        'id' => 'Saya seorang guru bahasa Inggris dari Jakarta, Indonesia. Di waktu luang, saya suka membaca buku dan bermain sepak bola.',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A!',
                        'id' => 'Luar biasa! Saya menikmati mendaki gunung. Sangat senang berkenalan denganmu, Student A!',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!',
                        'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!',
                    ],
                ],
                'games' => [
                    [
                        'title' => 'Game 1: 60-Second Speed Meet (Tanya Jawab Kilat)',
                        'participation_type' => 'pair',
                        'instructions' => 'Dalam 60 detik, tanyakan 4 info dasar pasanganmu: Nama lengkap, Umur, Kota asal, dan 1 Hobi favoritnya!',
                        'prompts' => ['What is your name and nickname?', 'How old are you?', 'Where are you from?', 'What do you like doing in your free time?']
                    ],
                    [
                        'title' => 'Game 2: Two Truths and One Wish (Tebak Hobi)',
                        'participation_type' => 'pair',
                        'instructions' => 'Sebutkan 2 kalimat hobi yang benar-benar kamu sukai dan 1 hobi khayalan. Pasanganmu harus menebak mana yang khayalan!',
                        'prompts' => ['1. I like reading books.', '2. I enjoy playing football.', '3. I like climbing Mount Everest every weekend. (Which one is the wish?)']
                    ],
                    [
                        'title' => 'Game 3: Pronoun Switch Challenge (Kenalkan Temanmu)',
                        'participation_type' => 'pair',
                        'instructions' => 'Ganti subjek "I am" menjadi "He is / She is" saat memperkenalkan pasanganmu ke hadapan seluruh kelas!',
                        'prompts' => ['"This is my friend Budi. He is 20 years old. He is from Jakarta. In his free time, he likes playing football."']
                    ]
                ],
                'monolog_baku' => [
                    "Hello everyone! Good morning. My name is Budi Sugeng. I am 20 years old. You can call me Budi. I am from Jakarta, Indonesia. I am an English teacher. In my free time, I like reading books and playing football. It is nice to meet you all. Thank you!",
                    "Good afternoon, ladies and gentlemen. I am delighted to introduce myself. My name is Sarah Miller, and I am from Sydney, Australia. I work as an instructor, and I enjoy reading historical novels in my leisure time. It is a pleasure to meet everyone."
                ],
                'monolog_tidak_baku' => [
                    "Hi guys! Hey, how's it going? I'm Budi, 20 years old from Jakarta. I teach English and in my spare time I really love hanging out with friends and playing football. Super stoked to meet you all!",
                    "Hey everyone! What's up? I'm Sarah from Sydney. I'm into reading and outdoor hiking when I'm not working. Great to be here with you guys!"
                ],
                'questions_part_a' => [
                    'What is your full name and what is your nickname?',
                    'How old are you?',
                    'Where are you from (City & Country)?',
                    'What is your current profession or field of study?',
                    'What do you like doing in your free time?',
                ],
                'questions_part_b' => [
                    'How do you greet someone formally in the morning, afternoon, and evening?',
                    'What is the difference between "I like reading" and "I don\'t like reading"?',
                    'Can you introduce your best friend using "He is..." or "She is..."?',
                    'How do you say goodbye politely to your teacher at the end of class?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Complete Self-Introduction Showcase',
                'impromptu' => [
                    'Aktivitas 1: Sampaikan perkenalan diri lengkapmu tanpa membaca teks selama 60 detik mengikuti template Budi Sugeng!',
                    'Aktivitas 2: Lakukan perkenalan santai (informal greeting) seolah-olah kamu sedang berkenalan di kafe internasional.',
                    'Aktivitas 3: Jelaskan 3 hal yang paling kamu sukai (likes) dan 2 hal yang tidak kamu sukai (dislikes) dalam kehidupan sehari-hari.',
                    'Aktivitas 4: Rekam suaramu pada fitur Voice Recorder di bawah dan dengarkan kembali intonasimu!',
                ],
            ],
            2 => [
                'topic' => 'Simple Past Nominal',
                'focus' => 'Simple Past Nominal (was / were, wasn\'t / weren\'t), -ed pronunciation (/t/, /d/, /ɪd/), Eyewitness reports & Shopping queues',
                'listening' => [
                    'title' => 'Listening Practice: Eyewitness Testimony at Grand Central Store',
                    'audio_script' => 'Officer, I was right across the street when the incident occurred last night at 9:00 PM. The street lamps were exceptionally bright, and the storefront was fully illuminated. The witnesses were mostly tourists waiting in a souvenir queue. Everyone was calm until a loud commotion erupted near the entrance. I was certain that the manager was inside the premises.',
                    'key_phrases' => [
                        'I was right across the street',
                        'The witnesses were mostly tourists',
                        'The manager was inside the premises',
                    ],
                    'questions' => [
                        [
                            'q' => 'Where was the eyewitness standing when the incident took place?',
                            'options' => [
                                'Right across the street',
                                'Inside the bank vault',
                                'On the rooftop',
                                'At the subway terminal',
                            ],
                            'answer' => 'Right across the street',
                        ],
                        [
                            'q' => 'Who were the majority of the witnesses in the queue?',
                            'options' => [
                                'Tourists waiting in a souvenir queue',
                                'Police officers',
                                'Construction workers',
                                'Store cashiers',
                            ],
                            'answer' => 'Tourists waiting in a souvenir queue',
                        ],
                        [
                            'q' => 'Which past nominal form was used to describe the street lamps?',
                            'options' => [
                                'The street lamps were exceptionally bright',
                                'The street lamps are dim',
                                'The street lamps was broken',
                                'The street lamps will be replaced',
                            ],
                            'answer' => 'The street lamps were exceptionally bright',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I was in the conference hall when the presentation began yesterday.',
                        'id' => 'Saya berada di aula konferensi ketika presentasi dimulai kemarin.',
                    ],
                    [
                        'en' => 'The flight tickets were surprisingly affordable during the holiday season.',
                        'id' => 'Tiket penerbangan tersebut sangat terjangkau selama musim liburan.',
                    ],
                    [
                        'en' => 'She wasn\'t aware of the schedule change because she was on medical leave.',
                        'id' => 'Dia tidak menyadari perubahan jadwal tersebut karena dia sedang cuti sakit.',
                    ],
                    [
                        'en' => 'Were you present at the annual board meeting last Friday afternoon?',
                        'id' => 'Apakah Anda hadir pada rapat dewan tahunan Jumat sore yang lalu?',
                    ],
                    [
                        'en' => 'The museum exhibits were extraordinary and well preserved.',
                        'id' => 'Pameran museum tersebut luar biasa dan terawat dengan baik.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'The queue at the souvenir counter was extremely long and disorganized.',
                        'id' => 'Antrean di loket suvenir sangat panjang dan tidak teratur.',
                    ],
                    [
                        'en' => 'Eyewitnesses were confident that the suspect was tall and wore a navy jacket.',
                        'id' => 'Saksi mata yakin bahwa tersangka bertubuh tinggi dan mengenakan jaket biru tua.',
                    ],
                    [
                        'en' => 'It was a chilly, foggy evening in London when the incident occurred.',
                        'id' => 'Malam itu dingin dan berkabut di London saat peristiwa tersebut terjadi.',
                    ],
                    [
                        'en' => 'We were proud of our team\'s dedication during the international debate tournament.',
                        'id' => 'Kami bangga dengan dedikasi tim kami selama turnamen debat internasional.',
                    ],
                    [
                        'en' => 'Why were the store gates locked before the official closing hour?',
                        'id' => 'Mengapa gerbang toko dikunci sebelum jam tutup resmi?',
                    ],
                ],
                'grammar_note' => 'Past Nominal: I/He/She/It WAS | You/We/They WERE | Pronunciation of -ed: /t/ after voiceless (watched), /d/ after voiced (played), /ɪd/ after t/d (decided, visited)',
                'dialogue_setting' => 'Seorang polisi menginterogasi saksi mata, Bu Maya, terkait kejadian pencurian di pusat perbelanjaan tadi malam.',
                'dialogue' => [
                    [
                        'speaker' => 'Detective',
                        'en' => 'Good evening, Ma\'am. Were you near the boutique when the alarm sounded?',
                        'id' => 'Selamat malam, Bu. Apakah Anda berada di dekat butik saat alarm berbunyi?',
                    ],
                    [
                        'speaker' => 'Maya',
                        'en' => 'Yes, officer. I was in the souvenir queue right beside the main escalator.',
                        'id' => 'Ya, pak polisi. Saya berada di antrean suvenir persis di samping eskalator utama.',
                    ],
                    [
                        'speaker' => 'Detective',
                        'en' => 'Was the cashier alone, or were there security officers nearby?',
                        'id' => 'Apakah kasir sendirian, atau ada petugas keamanan di dekat sana?',
                    ],
                    [
                        'speaker' => 'Maya',
                        'en' => 'The cashier was alone at that moment. The security guards were on the second floor.',
                        'id' => 'Kasir sendirian pada saat itu. Petugas keamanan sedang berada di lantai dua.',
                    ],
                ],
                'monolog_baku' => [
                    'Memberikan kesaksian peristiwa masa lalu membutuhkan ketelitian dalam menggunakan bentuk lampau nominal (was/were). Setiap rincian seperti kondisi cuaca, pencahayaan, dan lokasi saksi sangat menentukan akurasi laporan investigasi.',
                    'Pelafalan akhiran -ed pada kata kerja lampau memiliki tiga variasi bunyi: bunyi /t/ seperti pada kata \'walked\', bunyi /d/ seperti pada \'opened\', dan bunyi /ɪd/ seperti pada \'started\'. Menguasai variasi bunyi ini membuat ucapan kita terdengar natural.',
                ],
                'monolog_tidak_baku' => [
                    'Tadi malem gue pas banget lagi ngantre beli oleh-oleh pas ada insiden rame-rame di mall. Suasananya sempet panik karena petugas keamanannya lagi gak di tempat.',
                    'Kalo ngomong kata kerja lampau kayak \'worked\' jangan dibaca work-ed ya, tapi bunyinya /t/ di ujungnya. Latihan pelafalan ini penting biar gak medok.',
                ],
                'questions_part_a' => [
                    'Di mana kamu berada jam 8 malam kemarin (Where were you)?',
                    'Bagaimana suasana sekolah atau kantormu saat pertama kali kamu bergabung dulu?',
                    'Apakah kamu pernah menjadi saksi mata (eyewitness) dari suatu peristiwa unik? Ceritakan suasananya!',
                    'Bagaimana cara membedakan pengucapan akhiran -ed pada kata "asked", "cleaned", dan "needed"?',
                    'Apakah belanja oleh-oleh (souvenir shopping) adalah hal wajib bagimu saat berlibur?',
                ],
                'questions_part_b' => [
                    'Bagaimana reaksimu ketika harus menunggu di antrean yang sangat panjang (long queue)?',
                    'Apakah kamu merasa puas dengan prestasimu saat masih di jenjang sekolah sebelumnya?',
                    'Siapa orang yang paling berjasa dalam hidupmu di masa lampau?',
                    'Buat 3 kalimat tanya menggunakan "Were you..." dan 3 kalimat menggunakan "Was it..."!',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Last Night Eyewitness & The Queue Simulation',
                'impromptu' => [
                    'Aktivitas "Eyewitness Report": Rekam laporan kesaksian selama 2 menit sebagai saksi kunci dari sebuah insiden misterius dengan mendeskripsikan secara detail lokasi, orang, dan suasananya menggunakan "was/were".',
                    'Aktivitas "The Queue Complaint": Sampaikan keluhan formal kepada pengelola toko mengenai antrean yang tidak tertib menggunakan kalimat lampau.',
                    'Diskusikan keandalan memori saksi mata manusia dalam proses peradilan hukum.',
                    'Mengapa ketepatan pelafalan (*phonetic endings*) sangat berpengaruh terhadap persepsi profesionalisme seseorang?',
                ],
            ],
            3 => [
                'topic' => 'Simple Past Verbal & irregular verbs',
                'focus' => 'Simple Past Verbal with all common irregular verbs (went, saw, took, thought, bought, brought, caught), Crime investigation & Roleplay',
                'listening' => [
                    'title' => 'Listening Practice: Simple Past Verbal & irregular verbs',
                    'audio_script' => 'Detective Miller investigated the mysterious case of Robin Koch yesterday. He arrived at the estate at dawn, interviewed three key suspects, found a hidden diary under the floorboards, and gathered crucial forensic evidence that unlocked the entire mystery.',
                    'key_phrases' => [
                        'The suspect fled the scene before the authorities arrived.',
                        'She found an encrypted flash drive hidden inside the bookshelf.',
                        'The detective interrogated the butler regarding his whereabouts.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Simple Past Verbal & irregular verbs',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Simple Past Verbal & irregular verbs',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'The suspect fled the scene before the authorities arrived.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'The suspect fled the scene before the authorities arrived.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering simple past verbal & irregular verbs?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The suspect fled the scene before the authorities arrived.',
                        'id' => 'Tersangka melarikan diri dari tempat kejadian sebelum pihak berwenang tiba.',
                    ],
                    [
                        'en' => 'She found an encrypted flash drive hidden inside the bookshelf.',
                        'id' => 'Dia menemukan diska lepas terenkripsi yang tersembunyi di dalam rak buku.',
                    ],
                    [
                        'en' => 'The detective interrogated the butler regarding his whereabouts.',
                        'id' => 'Detektif menginterogasi kepala pelayan mengenai keberadaannya.',
                    ],
                    [
                        'en' => 'He proved his innocence by showing timestamped receipts.',
                        'id' => 'Dia membuktikan ketidakbersalahannya dengan menunjukkan kuitansi bertanda waktu.',
                    ],
                    [
                        'en' => 'They solved the complex puzzle after analyzing forensic fingerprints.',
                        'id' => 'Mereka memecahkan teka-teki rumit tersebut setelah menganalisis sidik jari forensik.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for simple past verbal & irregular verbs rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk simple past verbal & irregular verbs secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Irregular Verbs: fly-flew, freeze-froze, rise-rose, choose-chose, speak-spoke, take-took, break-broke',
                'pronunciation_tip' => 'Pelafalan vokal pendek vs panjang pada kata kerja bentuk lampau (e.g. read /riːd/ vs read /rɛd/)',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Simple Past Verbal & irregular verbs dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Simple Past Verbal & irregular verbs elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Simple Past Verbal & irregular verbs meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "The suspect fled the scene before the authorities arrived.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "The suspect fled the scene before the authorities arrived.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Simple Past Verbal & irregular verbs di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Irregular Verbs: fly-flew, freeze-froze, rise-rose, choose-chose, speak-spoke, take-took, break-broke memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Simple Past Verbal & irregular verbs ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Simple Past Verbal & irregular verbs membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Irregular Verbs!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Pelafalan vokal pendek vs panjang pada kata kerja bentuk lampau (e.g. read /riːd/ vs read /rɛd/)) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Simple Past Verbal & irregular verbs Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Simple Past Verbal & irregular verbs dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Irregular Verbs: fly-flew, freeze-froze, rise-rose, choose-chose, speak-spoke, take-took, break-broke meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            4 => [
                'topic' => 'Simple past & Past Continuous',
                'focus' => 'Interrupted past actions (Past Continuous: was/were + V-ing interrupted by Simple Past with when/while), Scene of the crime & Storytelling',
                'listening' => [
                    'title' => 'Listening Practice: Simple past & Past Continuous',
                    'audio_script' => 'While Detective Watson was examining the library window, a strange silhouette suddenly dashed across the garden courtyard. Heavy rain was pouring relentlessly as thunder shook the mansion. When the lights flickered, the intruder vanished into the dark.',
                    'key_phrases' => [
                        'I was writing my thesis when the power outage suddenly occurred.',
                        'While the professor was lecturing, students were taking detailed notes.',
                        'The storm was howling violently while the rescue team was searching for survivors.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Simple past & Past Continuous',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Simple past & Past Continuous',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'I was writing my thesis when the power outage suddenly occurred.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'I was writing my thesis when the power outage suddenly occurred.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering simple past & past continuous?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I was writing my thesis when the power outage suddenly occurred.',
                        'id' => 'Saya sedang menulis tesis saya ketika pemadaman listrik tiba-tiba terjadi.',
                    ],
                    [
                        'en' => 'While the professor was lecturing, students were taking detailed notes.',
                        'id' => 'Saat profesor sedang memberikan kuliah, para mahasiswa sedang mencatat dengan saksama.',
                    ],
                    [
                        'en' => 'The storm was howling violently while the rescue team was searching for survivors.',
                        'id' => 'Badai sedang menderu hebat saat tim penyelamat sedang mencari korban selamat.',
                    ],
                    [
                        'en' => 'She met her childhood mentor while she was traveling in Switzerland.',
                        'id' => 'Dia bertemu mentor masa kecilnya saat dia sedang bepergian di Swiss.',
                    ],
                    [
                        'en' => 'What were you doing at nine o\'clock when the fire alarm rang?',
                        'id' => 'Apa yang sedang Anda lakukan pada pukul sembilan ketika alarm kebakaran berbunyi?',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for simple past & past continuous rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk simple past & past continuous secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Past Continuous (ongoing background: was walking) + When + Simple Past (interruption: heard a scream) | While + Past Continuous',
                'pronunciation_tip' => 'Pengucapan penghubung waktu: "while" /waɪl/ dan "when" /wɛn/ dengan intonasi klausa bertingkat',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Simple past & Past Continuous dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Simple past & Past Continuous elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Simple past & Past Continuous meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "I was writing my thesis when the power outage suddenly occurred.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "I was writing my thesis when the power outage suddenly occurred.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Simple past & Past Continuous di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Past Continuous (ongoing background: was walking) + When + Simple Past (interruption: heard a scream) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Simple past & Past Continuous ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Simple past & Past Continuous membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Past Continuous (ongoing background!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Pengucapan penghubung waktu: "while" /waɪl/ dan "when" /wɛn/ dengan intonasi klausa bertingkat) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Simple past & Past Continuous Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Simple past & Past Continuous dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Past Continuous (ongoing background: was walking) + When + Simple Past (interruption: heard a scream) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            5 => [
                'topic' => 'Modals & Degrees certainty (Past time)',
                'focus' => 'Past Modals of Deduction: must have, might have, could have, can\'t have + V3, Past form of should (should have + V3), Would for past repeated action',
                'listening' => [
                    'title' => 'Listening Practice: Modals & Degrees certainty (Past time)',
                    'audio_script' => 'The artifact is missing from the locked vault; the thief must have known the security passcode in advance! They can\'t have broken in through the steel doors without triggering sirens. The security team should have updated the encryption protocols last month.',
                    'key_phrases' => [
                        'The streets are soaking wet; it must have rained heavily overnight.',
                        'He can\'t have committed the fraud because he was abroad with verifiable records.',
                        'We should have double-checked the contract terms before signing the agreement.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Modals & Degrees certainty (Past time)',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Modals & Degrees certainty (Past time)',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'The streets are soaking wet; it must have rained heavily overnight.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'The streets are soaking wet; it must have rained heavily overnight.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering modals & degrees certainty (past time)?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The streets are soaking wet; it must have rained heavily overnight.',
                        'id' => 'Jalanan basah kuyup; pasti hujan lebat turun semalaman.',
                    ],
                    [
                        'en' => 'He can\'t have committed the fraud because he was abroad with verifiable records.',
                        'id' => 'Dia tidak mungkin melakukan penipuan tersebut karena dia sedang di luar negeri dengan catatan terverifikasi.',
                    ],
                    [
                        'en' => 'We should have double-checked the contract terms before signing the agreement.',
                        'id' => 'Kita seharusnya memeriksa ulang syarat kontrak sebelum menandatangani perjanjian tersebut.',
                    ],
                    [
                        'en' => 'She might have taken a different flight due to the airport cancellation.',
                        'id' => 'Dia mungkin telah mengambil penerbangan lain karena pembatalan di bandara.',
                    ],
                    [
                        'en' => 'Every summer, my grandfather would sit on the porch and recount historical tales.',
                        'id' => 'Setiap musim panas, kakek saya biasa duduk di serambi dan menceritakan kisah-kisah sejarah.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for modals & degrees certainty (past time) rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk modals & degrees certainty (past time) secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Past Deductions: Must have + V3 (95% sure it happened) | Can\'t have + V3 (impossible) | Might/Could have + V3 (possible) | Should have + V3 (regret/unfulfilled obligation)',
                'pronunciation_tip' => 'Bentuk reduksi cepat: "must\'ve" /mʌstəv/, "should\'ve" /ʃʊdəv/, "could\'ve" /kʊdəv/',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Modals & Degrees certainty (Past time) dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Modals & Degrees certainty (Past time) elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Modals & Degrees certainty (Past time) meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "The streets are soaking wet; it must have rained heavily overnight.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "The streets are soaking wet; it must have rained heavily overnight.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Modals & Degrees certainty (Past time) di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Past Deductions: Must have + V3 (95% sure it happened) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Modals & Degrees certainty (Past time) ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Modals & Degrees certainty (Past time) membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Past Deductions!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Bentuk reduksi cepat: "must\'ve" /mʌstəv/, "should\'ve" /ʃʊdəv/, "could\'ve" /kʊdəv/) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Modals & Degrees certainty (Past time) Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Modals & Degrees certainty (Past time) dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Past Deductions: Must have + V3 (95% sure it happened) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            6 => [
                'topic' => 'Present Perfect',
                'focus' => 'Present Perfect (have/has + V3) for life experiences, recent achievements, unfinished timeframes (since, for, already, yet, ever, never), Job Interview 2',
                'listening' => [
                    'title' => 'Listening Practice: Present Perfect',
                    'audio_script' => 'Over the past eight years, I have spearheaded numerous digital transformation initiatives across Southeast Asia. I have collaborated with multidisciplinary teams, expanded our market reach by forty percent, and published three industry whitepapers. Have you ever managed cross-border operations?',
                    'key_phrases' => [
                        'I have traveled to over twenty countries and negotiated cross-border contracts.',
                        'She has already published two bestselling academic textbooks on linguistics.',
                        'We have lived in this metropolitan area since January 2018.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Present Perfect',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Present Perfect',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'I have traveled to over twenty countries and negotiated cross-border contracts.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'I have traveled to over twenty countries and negotiated cross-border contracts.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering present perfect?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I have traveled to over twenty countries and negotiated cross-border contracts.',
                        'id' => 'Saya telah bepergian ke lebih dari dua puluh negara dan menegosiasikan kontrak lintas batas.',
                    ],
                    [
                        'en' => 'She has already published two bestselling academic textbooks on linguistics.',
                        'id' => 'Dia telah menerbitkan dua buku teks akademik terlaris tentang linguistik.',
                    ],
                    [
                        'en' => 'We have lived in this metropolitan area since January 2018.',
                        'id' => 'Kami telah tinggal di kawasan metropolitan ini sejak Januari 2018.',
                    ],
                    [
                        'en' => 'Have you ever resolved a major crisis under tight project deadlines?',
                        'id' => 'Pernahkah Anda menyelesaikan krisis besar di bawah tenggat waktu proyek yang ketat?',
                    ],
                    [
                        'en' => 'Our engineering team has just deployed the latest software patch.',
                        'id' => 'Tim teknik kami baru saja meluncurkan pembaruan perangkat lunak terbaru.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for present perfect rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk present perfect secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Present Perfect: Have/Has + Past Participle (V3) | Ever (in questions) vs Never | Already (positive) vs Yet (questions & negatives) | Since (point in time) vs For (duration)',
                'pronunciation_tip' => 'Penekanan kata keterangan waktu: already, yet, recently, so far, ever',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Present Perfect dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Present Perfect elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Present Perfect meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "I have traveled to over twenty countries and negotiated cross-border contracts.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "I have traveled to over twenty countries and negotiated cross-border contracts.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Present Perfect di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Present Perfect: Have/Has + Past Participle (V3) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Present Perfect ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Present Perfect membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Present Perfect!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Penekanan kata keterangan waktu: already, yet, recently, so far, ever) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Present Perfect Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Present Perfect dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Present Perfect: Have/Has + Past Participle (V3) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            7 => [
                'topic' => 'Past perfect & Present Perfect continuous',
                'focus' => 'Past Perfect (had + V3 for earlier past action) vs Present Perfect Continuous (have/has been + V-ing for ongoing duration), Criminal investigations',
                'listening' => [
                    'title' => 'Listening Practice: Past perfect & Present Perfect continuous',
                    'audio_script' => 'By the time the police arrived at the harbor, the cargo ship had already departed. The investigators have been analyzing surveillance camera footage for the past forty-eight hours without a break to track the vessel\'s destination.',
                    'key_phrases' => [
                        'By the time I reached the airport, the flight had already taken off.',
                        'She has been studying international maritime law for five consecutive years.',
                        'He had been driving for eight hours before he finally stopped to rest.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Past perfect & Present Perfect continuous',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Past perfect & Present Perfect continuous',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'By the time I reached the airport, the flight had already taken off.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'By the time I reached the airport, the flight had already taken off.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering past perfect & present perfect continuous?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'By the time I reached the airport, the flight had already taken off.',
                        'id' => 'Pada saat saya tiba di bandara, pesawat sudah lepas landas.',
                    ],
                    [
                        'en' => 'She has been studying international maritime law for five consecutive years.',
                        'id' => 'Dia telah belajar hukum maritim internasional selama lima tahun berturut-turut.',
                    ],
                    [
                        'en' => 'He had been driving for eight hours before he finally stopped to rest.',
                        'id' => 'Dia telah mengemudi selama delapan jam sebelum akhirnya dia berhenti untuk beristirahat.',
                    ],
                    [
                        'en' => 'They hadn\'t realized the magnitude of the problem until the audit report arrived.',
                        'id' => 'Mereka belum menyadari besarnya masalah tersebut hingga laporan audit tiba.',
                    ],
                    [
                        'en' => 'We have been working tirelessly to modernize our course curriculum.',
                        'id' => 'Kami telah bekerja tanpa lelah untuk memodernisasi kurikulum kursus kami.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for past perfect & present perfect continuous rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk past perfect & present perfect continuous secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Past Perfect (Action 1: Had done) happened before Simple Past (Action 2: Happened) | Present Perfect Continuous: Have been doing (focus on duration/process)',
                'pronunciation_tip' => 'Kontraksi subjek dengan had: I\'d, they\'d, she\'d dan have been: I\'ve been',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Past perfect & Present Perfect continuous dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Past perfect & Present Perfect continuous elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Past perfect & Present Perfect continuous meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "By the time I reached the airport, the flight had already taken off.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "By the time I reached the airport, the flight had already taken off.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Past perfect & Present Perfect continuous di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Past Perfect (Action 1: Had done) happened before Simple Past (Action 2: Happened) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Past perfect & Present Perfect continuous ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Past perfect & Present Perfect continuous membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Past Perfect (Action 1!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Kontraksi subjek dengan had: I\'d, they\'d, she\'d dan have been: I\'ve been) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Past perfect & Present Perfect continuous Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Past perfect & Present Perfect continuous dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Past Perfect (Action 1: Had done) happened before Simple Past (Action 2: Happened) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            8 => [
                'topic' => 'Passive Voice (Present & Past)',
                'focus' => 'Passive Voice in Present (is/are + V3) and Past (was/were + V3), Stative passive, Get + V3, Amazing scientific facts',
                'listening' => [
                    'title' => 'Listening Practice: Passive Voice (Present & Past)',
                    'audio_script' => 'Penicillin was discovered accidentally by Alexander Fleming in 1928. Today, life-saving antibiotics are manufactured in state-of-the-art sterile laboratories and distributed to hospitals worldwide to cure bacterial infections.',
                    'key_phrases' => [
                        'The ancient Pyramids of Giza were constructed thousands of years ago.',
                        'Over seventy percent of the Earth\'s surface is covered by vast oceans.',
                        'The historical documents are securely preserved inside climate-controlled archives.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Passive Voice (Present & Past)',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Passive Voice (Present & Past)',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'The ancient Pyramids of Giza were constructed thousands of years ago.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'The ancient Pyramids of Giza were constructed thousands of years ago.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering passive voice (present & past)?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The ancient Pyramids of Giza were constructed thousands of years ago.',
                        'id' => 'Piramida kuno Giza dibangun ribuan tahun yang lalu.',
                    ],
                    [
                        'en' => 'Over seventy percent of the Earth\'s surface is covered by vast oceans.',
                        'id' => 'Lebih dari tujuh puluh persen permukaan Bumi tertutup oleh lautan luas.',
                    ],
                    [
                        'en' => 'The historical documents are securely preserved inside climate-controlled archives.',
                        'id' => 'Dokumen sejarah tersebut tersimpan aman di dalam arsip berpengatur suhu.',
                    ],
                    [
                        'en' => 'Several outdated regulations got abolished during the parliamentary session.',
                        'id' => 'Beberapa peraturan usang dihapuskan selama sidang parlemen.',
                    ],
                    [
                        'en' => 'Renewable solar panels are installed on millions of residential rooftops globally.',
                        'id' => 'Panel surya terbarukan dipasang di jutaan atap rumah di seluruh dunia.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for passive voice (present & past) rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk passive voice (present & past) secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Passive Voice: Subject + be (conjugated) + Past Participle (V3) + by Agent | Stative passive: The door is locked / The glass is broken',
                'pronunciation_tip' => 'Pelafalan ritme kalimat pasif dengan penekanan pada kata kerja bentuk ketiga (V3)',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Passive Voice (Present & Past) dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Passive Voice (Present & Past) elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Passive Voice (Present & Past) meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "The ancient Pyramids of Giza were constructed thousands of years ago.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "The ancient Pyramids of Giza were constructed thousands of years ago.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Passive Voice (Present & Past) di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Passive Voice: Subject + be (conjugated) + Past Participle (V3) + by Agent memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Passive Voice (Present & Past) ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Passive Voice (Present & Past) membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Passive Voice!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Pelafalan ritme kalimat pasif dengan penekanan pada kata kerja bentuk ketiga (V3)) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Passive Voice (Present & Past) Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Passive Voice (Present & Past) dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Passive Voice: Subject + be (conjugated) + Past Participle (V3) + by Agent meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            9 => [
                'topic' => 'Causative Verb & Tag Question Past',
                'focus' => 'Causative Verbs (Active: Have/Make/Let someone do, Get someone to do; Passive: Have/Get something done), Tag questions in the past',
                'listening' => [
                    'title' => 'Listening Practice: Causative Verb & Tag Question Past',
                    'audio_script' => 'The CEO had the chief architect redesign the headquarters to incorporate green building standards. You had your legal documents certified by a notary public yesterday, didn\'t you?',
                    'key_phrases' => [
                        'The professor made the students revise their research methodologies.',
                        'She got her business partner to agree to the international merger terms.',
                        'I had my vehicle serviced by certified technicians before the road trip.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'Causative Verb & Tag Question Past',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'Causative Verb & Tag Question Past',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'The professor made the students revise their research methodologies.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'The professor made the students revise their research methodologies.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering causative verb & tag question past?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'The professor made the students revise their research methodologies.',
                        'id' => 'Profesor tersebut menyuruh para mahasiswa merevisi metodologi penelitian mereka.',
                    ],
                    [
                        'en' => 'She got her business partner to agree to the international merger terms.',
                        'id' => 'Dia berhasil membujuk mitra bisnisnya untuk menyetujui syarat penggabungan internasional.',
                    ],
                    [
                        'en' => 'I had my vehicle serviced by certified technicians before the road trip.',
                        'id' => 'Saya menyervis kendaraan saya oleh teknisi tersertifikasi sebelum perjalanan jauh.',
                    ],
                    [
                        'en' => 'They let the interns lead the client presentation last Thursday.',
                        'id' => 'Mereka mengizinkan para pemagang memimpin presentasi klien Kamis lalu.',
                    ],
                    [
                        'en' => 'You attended the international economic summit in Geneva, didn\'t you?',
                        'id' => 'Anda menghadiri pertemuan puncak ekonomi internasional di Jenewa, bukan?',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for causative verb & tag question past rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk causative verb & tag question past secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Active Causative: Make + person + V1 (force) | Have + person + V1 (assign) | Get + person + TO V1 (persuade) | Let + person + V1 (allow) | Passive Causative: Have/Get + object + V3',
                'pronunciation_tip' => 'Tag Question Intonation: Falling tone when confirming information known, Rising tone when genuinely inquiring',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai Causative Verb & Tag Question Past dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering Causative Verb & Tag Question Past elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan Causative Verb & Tag Question Past meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "The professor made the students revise their research methodologies.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "The professor made the students revise their research methodologies.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Causative Verb & Tag Question Past di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Active Causative: Make + person + V1 (force) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Causative Verb & Tag Question Past ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik Causative Verb & Tag Question Past membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Active Causative!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Tag Question Intonation: Falling tone when confirming information known, Rising tone when genuinely inquiring) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Causative Verb & Tag Question Past Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi Causative Verb & Tag Question Past dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Active Causative: Make + person + V1 (force) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
            10 => [
                'topic' => 'MODAL TAMBAHAN & to infinitives complex',
                'focus' => 'Modal tambahan (semi-modals, modal idioms: be bound to, be likely to, would sooner, had better), Complex to-infinitives (passive infinitives, perfect infinitives), Debates',
                'listening' => [
                    'title' => 'Listening Practice: MODAL TAMBAHAN & to infinitives complex',
                    'audio_script' => 'In an era of rapid technological disruption, organizations are bound to embrace continuous innovation. Leaders are supposed to be equipped with ethical foresight so as to navigate complex global challenges successfully.',
                    'key_phrases' => [
                        'With such thorough preparation, your team is bound to win the debate competition.',
                        'Renewable energy prices are likely to decrease significantly over the coming decade.',
                        'Every citizen deserves to be treated with equal dignity and justice under the law.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the core intellectual theme explored in this advanced audio passage?',
                            'options' => [
                                'MODAL TAMBAHAN & to infinitives complex',
                                'Elementary Spelling Rules',
                                'Basic Kindergarten Rhymes',
                                'Simple Counting Exercises',
                            ],
                            'answer' => 'MODAL TAMBAHAN & to infinitives complex',
                        ],
                        [
                            'q' => 'Which thesis statement is strongly supported by the discourse?',
                            'options' => [
                                'With such thorough preparation, your team is bound to win the debate competition.',
                                'Passive avoidance of study',
                                'Complete lack of interest',
                                'Dismissal of critical thought',
                            ],
                            'answer' => 'With such thorough preparation, your team is bound to win the debate competition.',
                        ],
                        [
                            'q' => 'What strategic advantage is gained from mastering modal tambahan & to infinitives complex?',
                            'options' => [
                                'Achieves high-level rhetorical eloquence and analytical precision',
                                'Creates intellectual confusion',
                                'Reduces conversational range',
                                'Impedes career advancement',
                            ],
                            'answer' => 'Achieves high-level rhetorical eloquence and analytical precision',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'With such thorough preparation, your team is bound to win the debate competition.',
                        'id' => 'Dengan persiapan yang begitu matang, tim Anda pasti akan memenangkan kompetisi debat.',
                    ],
                    [
                        'en' => 'Renewable energy prices are likely to decrease significantly over the coming decade.',
                        'id' => 'Harga energi terbarukan kemungkinan besar akan turun secara signifikan selama dekade mendatang.',
                    ],
                    [
                        'en' => 'Every citizen deserves to be treated with equal dignity and justice under the law.',
                        'id' => 'Setiap warga negara berhak untuk diperlakukan dengan martabat dan keadilan yang setara di bawah hukum.',
                    ],
                    [
                        'en' => 'The archaeologist claims to have uncovered remnants of an ancient lost civilization.',
                        'id' => 'Arkeolog tersebut mengklaim telah menemukan sisa-sisa peradaban kuno yang hilang.',
                    ],
                    [
                        'en' => 'We implement rigorous quality checks so as to ensure zero defect rates in production.',
                        'id' => 'Kami menerapkan pemeriksaan kualitas yang ketat guna memastikan tingkat kecacatan nol dalam produksi.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We always analyze advanced linguistic structures for modal tambahan & to infinitives complex rigorously.',
                        'id' => 'Kami selalu menganalisis struktur linguistik tingkat lanjut untuk modal tambahan & to infinitives complex secara mendalam.',
                    ],
                    [
                        'en' => 'She delivers compelling, articulate presentations during our international seminars.',
                        'id' => 'Dia membawakan presentasi yang memikat dan lugas saat seminar internasional kami.',
                    ],
                    [
                        'en' => 'I consistently shadow professional native discourses to refine my advanced nuance.',
                        'id' => 'Saya secara konsisten menirukan wacana penutur asli profesional untuk memperhalus nuansa tingkat lanjut saya.',
                    ],
                    [
                        'en' => 'They debate complex socioeconomic issues with remarkable poise and eloquence.',
                        'id' => 'Mereka memperdebatkan isu-isu sosioekonomi yang kompleks dengan ketenangan dan kefasihan yang luar biasa.',
                    ],
                    [
                        'en' => 'He records and critically evaluates his speech pacing and grammatical precision.',
                        'id' => 'Dia merekam dan mengevaluasi secara kritis tempo berbicara dan ketepatan tata bahasanya.',
                    ],
                ],
                'grammar_note' => 'Complex Infinitives: Passive infinitive (to be + V3: hopes to be nominated) | Perfect infinitive (to have + V3: claims to have discovered) | Semi-modals: be bound to (certain), be likely to (probable)',
                'pronunciation_tip' => 'Artikulasi formal dan modulasi vokal dalam debat tingkat tinggi (*high-stakes debates*)',
                'dialogue_setting' => 'Dua analis profesional berdiskusi mengenai MODAL TAMBAHAN & to infinitives complex dalam forum strategis.',
                'dialogue' => [
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'How does mastering MODAL TAMBAHAN & to infinitives complex elevate our professional communication?',
                        'id' => 'Bagaimana penguasaan MODAL TAMBAHAN & to infinitives complex meningkatkan komunikasi profesional kita?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'It allows us to express subtle nuances, logical deductions, and complex arguments with utmost precision.',
                        'id' => 'Ini memungkinkan kita menyampaikan nuansa halus, deduksi logis, dan argumen kompleks dengan ketepatan tertinggi.',
                    ],
                    [
                        'speaker' => 'Clarissa',
                        'en' => 'Which advanced sentence pattern did you find most versatile?',
                        'id' => 'Pola kalimat tingkat lanjut mana yang menurutmu paling serbaguna?',
                    ],
                    [
                        'speaker' => 'Edward',
                        'en' => 'Undoubtedly: "With such thorough preparation, your team is bound to win the debate competition.". It sounds remarkably sophisticated.',
                        'id' => 'Pasti: "With such thorough preparation, your team is bound to win the debate competition.". Terdengar sangat canggih dan berkelas.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi MODAL TAMBAHAN & to infinitives complex di level lanjutan (Advanced) adalah batu loncatan menuju kemahiran berbahasa Inggris setara penutur profesional. Pada tingkat ini, fokus kita bukan lagi sekadar pemahaman gramatikal dasar, melainkan ketepatan diksi, retorika berbicara, dan penyampaian ide yang persuasif.',
                    'Penerapan struktur seperti Complex Infinitives: Passive infinitive (to be + V3: hopes to be nominated) memungkinkan kita memimpin diskusi strategis, wawancara kerja tingkat eksekutif, dan presentasi global dengan wibawa.',
                ],
                'monolog_tidak_baku' => [
                    'Materi MODAL TAMBAHAN & to infinitives complex ini bener-bener level up banget! Frasa-frasanya kepake banget kalo lagi meeting bareng klien luar negeri atau pas wawancara kerja profesional.',
                    'Gue ngerasa sekarang jauh lebih luwes dan bisa nyampein argumen kompleks tanpa harus muter-muter. Kuncinya emang berani langsung praktek ngomong tiap hari.',
                ],
                'questions_part_a' => [
                    'Bagaimana penguasaan topik MODAL TAMBAHAN & to infinitives complex membedakan penutur bahasa Inggris tingkat mahir dari pemula?',
                    'Coba buat satu kalimat kompleks menggunakan struktur Complex Infinitives!',
                    'Apa tantangan terbesar saat menerapkan kosakata dan tata bahasa tingkat lanjut ini secara spontan?',
                    'Dalam situasi profesional apa materi meeting ini paling sering kamu butuhkan?',
                    'Ceritakan satu studi kasus atau pengalaman nyata yang relevan dengan topik ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik pelafalan (Artikulasi formal dan modulasi vokal dalam debat tingkat tinggi (*high-stakes debates*)) membantu memperjelas pesanmu kepada audiens?',
                    'Apa strategi terbaikmu dalam mengatasi kebuntuan kata (*mental block*) saat berbicara bahasa Inggris tingkat tinggi?',
                    'Bagaimana kamu mengukur perkembangan kelancaran dan akurasi berbicaramu setelah mempelajari materi ini?',
                    'Siapa pembicara publik internasional yang gaya bicaranya paling menginspirasimu?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – MODAL TAMBAHAN & to infinitives complex Advanced Fluency',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato persuasif selama 2 menit mengenai signifikansi MODAL TAMBAHAN & to infinitives complex dalam konteks global dan karier modern.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Complex Infinitives: Passive infinitive (to be + V3: hopes to be nominated) meningkatkan kredibilitas intelektualmu saat bernegosiasi.',
                    'Bagaimana cara kamu mengelola perdebatan sengit secara profesional tanpa kehilangan kesantunan berbahasa?',
                    'Refleksikan transformasi kemampuan berbicara bahasa Inggrismu dari tingkat dasar hingga mencapai level mahir (Advanced).',
                ],
            ],
        ];

        return $data[$meeting] ?? $data[1];
    }

    private function getSuperMeetingContent(int $meeting): array
    {
        $data = [
            1 => [
                'topic' => 'Introduction and Greetings',
                'focus' => 'Greetings & Farewells, Basic Self-Introduction, Personal Pronouns & To Be, Likes & Hobbies',
                'materi' => [
                    'greetings' => [
                        'formal' => [
                            ['en' => 'Good morning', 'id' => 'Selamat pagi (06:00 - 12:00)'],
                            ['en' => 'Good afternoon', 'id' => 'Selamat siang / sore (12:00 - 18:00)'],
                            ['en' => 'Good evening', 'id' => 'Selamat malam (18:00+)'],
                        ],
                        'informal' => [
                            ['en' => 'Hi!', 'id' => 'Hai!'],
                            ['en' => 'Hey! How\'s it going?', 'id' => 'Hei! Bagaimana kabarmu?'],
                        ],
                        'closing' => [
                            ['en' => 'Goodbye', 'id' => 'Selamat tinggal / Sampai jumpa'],
                            ['en' => 'See you later', 'id' => 'Sampai jumpa lagi nanti'],
                            ['en' => 'Have a nice day', 'id' => 'Semoga harimu menyenangkan'],
                        ]
                    ],
                    'self_intro_templates' => [
                        ['label' => 'Name', 'pattern' => 'My name is [Name] / I\'m [Name]', 'example' => 'My name is Budi Sugeng / I\'m Budi.'],
                        ['label' => 'Age', 'pattern' => 'I am [number] years old', 'example' => 'I am 20 years old.'],
                        ['label' => 'Origin', 'pattern' => 'I am from [Country/City]', 'example' => 'I am from Jakarta, Indonesia.'],
                        ['label' => 'Profession', 'pattern' => 'I am a/an [Profession]', 'example' => 'I am an English teacher.'],
                    ],
                    'grammar_basics' => [
                        'subject_pronouns' => ['I', 'You', 'He', 'She', 'It', 'We', 'They'],
                        'to_be_conjugations' => [
                            ['subject' => 'I', 'to_be' => 'am', 'contraction' => 'I\'m', 'example' => 'I am a teacher.'],
                            ['subject' => 'You', 'to_be' => 'are', 'contraction' => 'You\'re', 'example' => 'You are my student.'],
                            ['subject' => 'We', 'to_be' => 'are', 'contraction' => 'We\'re', 'example' => 'We are in the classroom.'],
                            ['subject' => 'They', 'to_be' => 'are', 'contraction' => 'They\'re', 'example' => 'They are friendly.'],
                            ['subject' => 'He', 'to_be' => 'is', 'contraction' => 'He\'s', 'example' => 'He is 20 years old.'],
                            ['subject' => 'She', 'to_be' => 'is', 'contraction' => 'She\'s', 'example' => 'She is from Jakarta.'],
                            ['subject' => 'It', 'to_be' => 'is', 'contraction' => 'It\'s', 'example' => 'It is nice to meet you.'],
                        ]
                    ],
                    'likes_hobbies' => [
                        'patterns' => ['I like + [Noun / V-ing]', 'I don\'t like + [Noun / V-ing]', 'I enjoy + [V-ing]'],
                        'examples' => [
                            ['en' => 'I like reading books.', 'id' => 'Saya suka membaca buku.'],
                            ['en' => 'I enjoy playing football.', 'id' => 'Saya menikmati bermain sepak bola.'],
                            ['en' => 'I don\'t like waking up late.', 'id' => 'Saya tidak suka bangun terlambat.'],
                        ]
                    ],
                    'template' => "Hello everyone! Good morning.

My name is [Full Name]. I am [Age] years old. You can call me [Nick Name].

I am from [City/Country].

I am a/an [Profession].

In my free time, I like [Hobbies/Likes].

It is nice to meet you all. Thank you!",
                    'example' => "Hello! Good morning. How's it going?

My name is Student A. I am 20 years old.

I am from Jakarta, Indonesia, and I am an English teacher.

In my free time, I like reading books and playing football.

It is very nice to meet you all. Have a nice day!"
                ],
                'listening' => [
                    'title' => 'Short Listening: Student Introduction & Dialogue Practice',
                    'audio_script' => "Student A: Hello! Good morning. How's it going? Student B: Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name? Student A: My name is Student A. I'm 20 years old. Where are you from, Student B? Student B: I am from Sydney, Australia. I am an English instructor. What is your profession, Student A? Student A: I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football. Student B: That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A! Student A: It is nice to meet you too, Student B! Have a nice day and see you later!",
                    'key_phrases' => [
                        'How\'s it going? Everything is going great, thank you!',
                        'I am from Sydney, Australia. I am an English instructor.',
                        'I am an English teacher from Jakarta, Indonesia.',
                        'In my free time, I like reading books and playing football.',
                        'That is wonderful! I enjoy hiking in the mountains.',
                        'It is nice to meet you too! Have a nice day and see you later!',
                    ],
                    'questions' => [
                        [
                            'q' => 'Where is Student B from and what is her profession?',
                            'options' => [
                                'From Sydney, Australia; English instructor',
                                'From Jakarta, Indonesia; English teacher',
                                'From Bandung, Indonesia; Doctor',
                                'From London, UK; Engineer',
                            ],
                            'answer' => 'From Sydney, Australia; English instructor',
                        ],
                        [
                            'q' => 'Where is Student A from and what is his profession?',
                            'options' => [
                                'From Jakarta, Indonesia; English teacher',
                                'From Sydney, Australia; English instructor',
                                'From Tokyo, Japan; Pilot',
                                'From Melbourne, Australia; Doctor',
                            ],
                            'answer' => 'From Jakarta, Indonesia; English teacher',
                        ],
                        [
                            'q' => 'What hobbies are mentioned by Student A and Student B?',
                            'options' => [
                                'Student A likes reading & football; Student B enjoys hiking',
                                'Student A likes swimming; Student B likes cooking',
                                'Both students like playing video games',
                                'Student A likes dancing; Student B likes singing',
                            ],
                            'answer' => 'Student A likes reading & football; Student B enjoys hiking',
                        ],
                    ],
                ],
                'drilling1' => [
                    ['en' => 'Hello everyone! Good morning, my name is Student A.', 'id' => 'Halo semuanya! Selamat pagi, nama saya Student A.'],
                    ['en' => 'I am twenty years old, and you can call me Student A.', 'id' => 'Saya berumur dua puluh tahun, dan Anda bisa memanggil saya Student A.'],
                    ['en' => 'I am from Jakarta, Indonesia, and I am an English teacher.', 'id' => 'Saya berasal dari Jakarta, Indonesia, dan saya seorang guru bahasa Inggris.'],
                    ['en' => 'In my free time, I like reading books and playing football.', 'id' => 'Di waktu luang saya, saya suka membaca buku dan bermain sepak bola.'],
                    ['en' => 'It is very nice to meet all of you today.', 'id' => 'Sangat senang bertemu dengan Anda semua hari ini.'],
                ],
                'drilling2' => [
                    ['en' => 'Hi! Good morning. How\'s it going? Everything is going great, thank you!', 'id' => 'Hai! Selamat pagi. Bagaimana kabarmu? Semuanya baik-baik saja, terima kasih!'],
                    ['en' => 'I am from Sydney, Australia, and I am an English instructor.', 'id' => 'Saya berasal dari Sydney, Australia, dan saya seorang instruktur bahasa Inggris.'],
                    ['en' => 'What is your profession, and where are you from, Student A?', 'id' => 'Apa profesimu, dan dari mana asalmu, Student A?'],
                    ['en' => 'That is wonderful! In my free time, I enjoy hiking in the mountains.', 'id' => 'Luar biasa! Di waktu luang, saya menikmati mendaki gunung.'],
                    ['en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!', 'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!'],
                ],
                'grammar_note' => "Subject Pronouns (I, You, He, She, It, We, They) & Verb 'To Be' (am / is / are) | Contractions: I'm, You're, He's, She's, It's, We're, They're",
                'dialogue_setting' => 'Dua peserta kursus, Student A dan Student B, saling berkenalan di hari pertama kelas First Point Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Student A',
                        'en' => 'Hello! Good morning. How\'s it going?',
                        'id' => 'Halo! Selamat pagi. Bagaimana kabarmu?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'Hi! Good morning. Everything is going great, thank you! My name is Student B. What is your name?',
                        'id' => 'Hai! Selamat pagi. Semuanya baik-baik saja, terima kasih! Nama saya Student B. Siapa nama kamu?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'My name is Student A. I\'m 20 years old. Where are you from, Student B?',
                        'id' => 'Nama saya Student A. Saya berumur 20 tahun. Dari mana asalmu, Student B?',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'I am from Sydney, Australia. I am an English instructor. What is your profession, Student A?',
                        'id' => 'Saya berasal dari Sydney, Australia. Saya seorang instruktur bahasa Inggris. Apa profesimu, Student A?',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'I am an English teacher from Jakarta, Indonesia. In my free time, I like reading books and playing football.',
                        'id' => 'Saya seorang guru bahasa Inggris dari Jakarta, Indonesia. Di waktu luang, saya suka membaca buku dan bermain sepak bola.',
                    ],
                    [
                        'speaker' => 'Student B',
                        'en' => 'That is wonderful! I enjoy hiking in the mountains. It is very nice to meet you, Student A!',
                        'id' => 'Luar biasa! Saya menikmati mendaki gunung. Sangat senang berkenalan denganmu, Student A!',
                    ],
                    [
                        'speaker' => 'Student A',
                        'en' => 'It is nice to meet you too, Student B! Have a nice day and see you later!',
                        'id' => 'Senang berkenalan denganmu juga, Student B! Semoga harimu menyenangkan dan sampai jumpa lagi!',
                    ],
                ],
                'games' => [
                    [
                        'title' => 'Game 1: 60-Second Speed Meet (Tanya Jawab Kilat)',
                        'participation_type' => 'pair',
                        'instructions' => 'Dalam 60 detik, tanyakan 4 info dasar pasanganmu: Nama lengkap, Umur, Kota asal, dan 1 Hobi favoritnya!',
                        'prompts' => ['What is your name and nickname?', 'How old are you?', 'Where are you from?', 'What do you like doing in your free time?']
                    ],
                    [
                        'title' => 'Game 2: Two Truths and One Wish (Tebak Hobi)',
                        'participation_type' => 'pair',
                        'instructions' => 'Sebutkan 2 kalimat hobi yang benar-benar kamu sukai dan 1 hobi khayalan. Pasanganmu harus menebak mana yang khayalan!',
                        'prompts' => ['1. I like reading books.', '2. I enjoy playing football.', '3. I like climbing Mount Everest every weekend. (Which one is the wish?)']
                    ],
                    [
                        'title' => 'Game 3: Pronoun Switch Challenge (Kenalkan Temanmu)',
                        'participation_type' => 'pair',
                        'instructions' => 'Ganti subjek "I am" menjadi "He is / She is" saat memperkenalkan pasanganmu ke hadapan seluruh kelas!',
                        'prompts' => ['"This is my friend Budi. He is 20 years old. He is from Jakarta. In his free time, he likes playing football."']
                    ]
                ],
                'monolog_baku' => [
                    "Hello everyone! Good morning. My name is Budi Sugeng. I am 20 years old. You can call me Budi. I am from Jakarta, Indonesia. I am an English teacher. In my free time, I like reading books and playing football. It is nice to meet you all. Thank you!",
                    "Good afternoon, ladies and gentlemen. I am delighted to introduce myself. My name is Sarah Miller, and I am from Sydney, Australia. I work as an instructor, and I enjoy reading historical novels in my leisure time. It is a pleasure to meet everyone."
                ],
                'monolog_tidak_baku' => [
                    "Hi guys! Hey, how's it going? I'm Budi, 20 years old from Jakarta. I teach English and in my spare time I really love hanging out with friends and playing football. Super stoked to meet you all!",
                    "Hey everyone! What's up? I'm Sarah from Sydney. I'm into reading and outdoor hiking when I'm not working. Great to be here with you guys!"
                ],
                'questions_part_a' => [
                    'What is your full name and what is your nickname?',
                    'How old are you?',
                    'Where are you from (City & Country)?',
                    'What is your current profession or field of study?',
                    'What do you like doing in your free time?',
                ],
                'questions_part_b' => [
                    'How do you greet someone formally in the morning, afternoon, and evening?',
                    'What is the difference between "I like reading" and "I don\'t like reading"?',
                    'Can you introduce your best friend using "He is..." or "She is..."?',
                    'How do you say goodbye politely to your teacher at the end of class?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Complete Self-Introduction Showcase',
                'impromptu' => [
                    'Aktivitas 1: Sampaikan perkenalan diri lengkapmu tanpa membaca teks selama 60 detik mengikuti template Budi Sugeng!',
                    'Aktivitas 2: Lakukan perkenalan santai (informal greeting) seolah-olah kamu sedang berkenalan di kafe internasional.',
                    'Aktivitas 3: Jelaskan 3 hal yang paling kamu sukai (likes) dan 2 hal yang tidak kamu sukai (dislikes) dalam kehidupan sehari-hari.',
                    'Aktivitas 4: Rekam suaramu pada fitur Voice Recorder di bawah dan dengarkan kembali intonasimu!',
                ],
            ],
            2 => [
                'topic' => 'Conjunctions',
                'focus' => 'Coordinating conjunctions (FANBOYS: For, And, Nor, But, Or, Yet, So) and Correlative Conjunctions (Neither...nor, Either...or, Not only...but also)',
                'listening' => [
                    'title' => 'Listening Practice: Conjunctions',
                    'audio_script' => 'In modern corporate governance, a company can neither ignore digital transformation nor neglect ethical compliance. Not only does sustainable investment enhance long-term profitability, but it also elevates global brand reputation.',
                    'key_phrases' => [
                        'Not only did she achieve record sales targets, but she also mentored the entire junior team.',
                        'The proposal offered neither economic viability nor environmental sustainability.',
                        'We must either adapt our marketing strategy immediately or risk losing significant market share.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Conjunctions?',
                            'options' => [
                                'Conjunctions',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Conjunctions',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'Not only did she achieve record sales targets, but she also mentored the entire junior team.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'Not only did she achieve record sales targets, but she also mentored the entire junior team.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering conjunctions?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Not only did she achieve record sales targets, but she also mentored the entire junior team.',
                        'id' => 'Tidak hanya dia mencapai target penjualan rekor, tetapi dia juga membimbing seluruh tim junior.',
                    ],
                    [
                        'en' => 'The proposal offered neither economic viability nor environmental sustainability.',
                        'id' => 'Proposal tersebut tidak menawarkan kelayakan ekonomi maupun kelestarian lingkungan.',
                    ],
                    [
                        'en' => 'We must either adapt our marketing strategy immediately or risk losing significant market share.',
                        'id' => 'Kita harus mengadaptasi strategi pemasaran kita segera atau berisiko kehilangan pangsa pasar yang signifikan.',
                    ],
                    [
                        'en' => 'The negotiations were arduous and intense, yet both delegations reached a historic consensus.',
                        'id' => 'Negosiasinya berat dan intens, namun kedua delegasi mencapai konsensus bersejarah.',
                    ],
                    [
                        'en' => 'He has not finalized the financial audit, nor has he submitted the quarterly tax filings.',
                        'id' => 'Dia belum menyelesaikan audit keuangan, dan dia juga belum mengumpulkan pengajuan pajak kuartalan.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for conjunctions into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk conjunctions ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'FANBOYS vs Correlative Conjunctions: Parallel structure rule (Both X and Y / Neither X nor Y / Not only X but also Y with subject-verb inversion when starting a sentence)',
                'pronunciation_tip' => 'Ritme keseimbangan paralel (*parallel rhythm*) pada pasangan korelatif',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Conjunctions dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Conjunctions elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Conjunctions meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "Not only did she achieve record sales targets, but she also mentored the entire junior team.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "Not only did she achieve record sales targets, but she also mentored the entire junior team.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Conjunctions pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa FANBOYS vs Correlative Conjunctions: Parallel structure rule (Both X and Y / Neither X nor Y / Not only X but also Y with subject-verb inversion when starting a sentence) membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Conjunctions ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Conjunctions dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola FANBOYS vs Correlative Conjunctions!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Ritme keseimbangan paralel (*parallel rhythm*) pada pasangan korelatif) membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Conjunctions Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Conjunctions dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang FANBOYS vs Correlative Conjunctions: Parallel structure rule (Both X and Y / Neither X nor Y / Not only X but also Y with subject-verb inversion when starting a sentence) meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
            3 => [
                'topic' => 'Questions & Adverbs',
                'focus' => 'Tag Questions in present tense (do you, isn\'t it, aren\'t they), Advanced Question forms, and Intensifying Adverbs (utterly, remarkably, exceptionally, profoundly)',
                'listening' => [
                    'title' => 'Listening Practice: Questions & Adverbs',
                    'audio_script' => 'The findings of the market research are remarkably insightful, aren\'t they? Investing in renewable infrastructure is profoundly transformative, and we are exceptionally well positioned to lead this transition.',
                    'key_phrases' => [
                        'Her spontaneous presentation was remarkably articulate and well researched.',
                        'The cultural exchange program had a profoundly positive impact on the students.',
                        'You understand the legal implications of this non-disclosure agreement, don\'t you?',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Questions & Adverbs?',
                            'options' => [
                                'Questions & Adverbs',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Questions & Adverbs',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'Her spontaneous presentation was remarkably articulate and well researched.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'Her spontaneous presentation was remarkably articulate and well researched.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering questions & adverbs?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Her spontaneous presentation was remarkably articulate and well researched.',
                        'id' => 'Presentasi spontannya sangat lugas dan diriset dengan sangat baik.',
                    ],
                    [
                        'en' => 'The cultural exchange program had a profoundly positive impact on the students.',
                        'id' => 'Program pertukaran budaya tersebut memiliki dampak positif yang sangat mendalam bagi para siswa.',
                    ],
                    [
                        'en' => 'You understand the legal implications of this non-disclosure agreement, don\'t you?',
                        'id' => 'Anda memahami implikasi hukum dari perjanjian kerahasiaan ini, bukan?',
                    ],
                    [
                        'en' => 'The new operating system is exceptionally user-friendly, isn\'t it?',
                        'id' => 'Sistem operasi yang baru sangat ramah pengguna, bukan?',
                    ],
                    [
                        'en' => 'Under what specific conditions do you envisage expanding operations into Southeast Asia?',
                        'id' => 'Dalam kondisi spesifik apa Anda membayangkan perluasan operasi ke Asia Tenggara?',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for questions & adverbs into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk questions & adverbs ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'Intensifying Adverbs: Collocations with adjectives (utterly devastating, profoundly moving, remarkably resilient, exceptionally talented) | Tag Question intonations',
                'pronunciation_tip' => 'Intonasi Tag Question: Nada turun (*falling tone*) untuk meminta persetujuan, Nada naik (*rising tone*) untuk pertanyaan murni',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Questions & Adverbs dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Questions & Adverbs elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Questions & Adverbs meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "Her spontaneous presentation was remarkably articulate and well researched.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "Her spontaneous presentation was remarkably articulate and well researched.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Questions & Adverbs pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa Intensifying Adverbs: Collocations with adjectives (utterly devastating, profoundly moving, remarkably resilient, exceptionally talented) membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Questions & Adverbs ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Questions & Adverbs dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola Intensifying Adverbs!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Intonasi Tag Question: Nada turun (*falling tone*) untuk meminta persetujuan, Nada naik (*rising tone*) untuk pertanyaan murni) membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Questions & Adverbs Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Questions & Adverbs dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Intensifying Adverbs: Collocations with adjectives (utterly devastating, profoundly moving, remarkably resilient, exceptionally talented) meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
            4 => [
                'topic' => 'Adverbial Clause 1',
                'focus' => 'Adverbial Clauses of Time (when, while, as soon as, until), Purpose (in order that, so that), Place (wherever, everywhere), Contrast (although, even though, whereas)',
                'listening' => [
                    'title' => 'Listening Practice: Adverbial Clause 1',
                    'audio_script' => 'Although geopolitical tensions created market volatility, our export volume increased steadily. We implemented stringent quality protocols so that our overseas clients would receive flawless shipments wherever they operate.',
                    'key_phrases' => [
                        'Although the initial budget was limited, the creative team produced award-winning campaign assets.',
                        'We upgraded our server infrastructure so that international users could experience zero latency.',
                        'As soon as the regulatory authority approved the license, production commenced immediately.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Adverbial Clause 1?',
                            'options' => [
                                'Adverbial Clause 1',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Adverbial Clause 1',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'Although the initial budget was limited, the creative team produced award-winning campaign assets.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'Although the initial budget was limited, the creative team produced award-winning campaign assets.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering adverbial clause 1?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Although the initial budget was limited, the creative team produced award-winning campaign assets.',
                        'id' => 'Meskipun anggaran awal terbatas, tim kreatif menghasilkan materi kampanye pemenang penghargaan.',
                    ],
                    [
                        'en' => 'We upgraded our server infrastructure so that international users could experience zero latency.',
                        'id' => 'Kami memperbarui infrastruktur server kami agar pengguna internasional dapat merasakan latensi nol.',
                    ],
                    [
                        'en' => 'As soon as the regulatory authority approved the license, production commenced immediately.',
                        'id' => 'Begitu otoritas regulasi menyetujui izin tersebut, produksi langsung dimulai.',
                    ],
                    [
                        'en' => 'Our customer support team is available to assist users wherever they are located globally.',
                        'id' => 'Tim dukungan pelanggan kami siap membantu pengguna di mana pun mereka berada di seluruh dunia.',
                    ],
                    [
                        'en' => 'When we were teenagers, we used to spend hours discussing scientific discoveries in the town square.',
                        'id' => 'Ketika kami masih remaja, kami biasa menghabiskan berjam-jam mendiskusikan penemuan ilmiah di alun-alun kota.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for adverbial clause 1 into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk adverbial clause 1 ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'Subordinating Conjunctions for Adverbial Clauses: Time, Purpose (so that + modal), Place, Contrast (Although + full clause vs In spite of + noun)',
                'pronunciation_tip' => 'Jeda koma (*comma pause*) setelah adverbial clause di awal kalimat',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Adverbial Clause 1 dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Adverbial Clause 1 elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Adverbial Clause 1 meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "Although the initial budget was limited, the creative team produced award-winning campaign assets.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "Although the initial budget was limited, the creative team produced award-winning campaign assets.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Adverbial Clause 1 pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa Subordinating Conjunctions for Adverbial Clauses: Time, Purpose (so that + modal), Place, Contrast (Although + full clause vs In spite of + noun) membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Adverbial Clause 1 ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Adverbial Clause 1 dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola Subordinating Conjunctions for Adverbial Clauses!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Jeda koma (*comma pause*) setelah adverbial clause di awal kalimat) membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Adverbial Clause 1 Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Adverbial Clause 1 dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Subordinating Conjunctions for Adverbial Clauses: Time, Purpose (so that + modal), Place, Contrast (Although + full clause vs In spite of + noun) meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
            5 => [
                'topic' => 'Adverbial Clause 2',
                'focus' => 'Adverbial Clauses of Reason (because, since, as, given that), Result (so...that, such...that), That clauses, and Reducing Adverbial Clauses to modifying participle phrases',
                'listening' => [
                    'title' => 'Listening Practice: Adverbial Clause 2',
                    'audio_script' => 'Given that climate volatility poses severe economic risks, corporations are restructuring their supply chains. The demand for renewable energy is so massive that solar manufacturers are operating at full capacity.',
                    'key_phrases' => [
                        'Given that global consumer preferences are shifting rapidly, innovation is imperative.',
                        'The technological demonstration was so captivating that every investor signed the pledge.',
                        'It was such a comprehensive strategy that it eliminated all operational bottlenecks.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Adverbial Clause 2?',
                            'options' => [
                                'Adverbial Clause 2',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Adverbial Clause 2',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'Given that global consumer preferences are shifting rapidly, innovation is imperative.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'Given that global consumer preferences are shifting rapidly, innovation is imperative.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering adverbial clause 2?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Given that global consumer preferences are shifting rapidly, innovation is imperative.',
                        'id' => 'Mengingat bahwa preferensi konsumen global bergeser dengan cepat, inovasi adalah keharusan mutlak.',
                    ],
                    [
                        'en' => 'The technological demonstration was so captivating that every investor signed the pledge.',
                        'id' => 'Demonstrasi teknologi tersebut begitu memikat sehingga setiap investor menandatangani komitmen.',
                    ],
                    [
                        'en' => 'It was such a comprehensive strategy that it eliminated all operational bottlenecks.',
                        'id' => 'Itu adalah strategi yang sedemikian komprehensif sehingga menghilangkan semua hambatan operasional.',
                    ],
                    [
                        'en' => 'Recognizing the urgency of the situation, the management deployed immediate contingency funds.',
                        'id' => 'Menyadari urgensi situasi tersebut, manajemen menyalurkan dana darurat segera.',
                    ],
                    [
                        'en' => 'The board unanimously resolved that the international expansion should proceed without delay.',
                        'id' => 'Dewan memutuskan secara bulat bahwa ekspansi internasional harus dilanjutkan tanpa penundaan.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for adverbial clause 2 into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk adverbial clause 2 ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'Result Clauses: So + adjective + That vs Such + noun phrase + That | Reducing clauses: "Because he felt tired" -> "Feeling tired, he rested"',
                'pronunciation_tip' => 'Pengucapan klausa hasil: Penekanan vokal pada kata "so" dan "such"',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Adverbial Clause 2 dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Adverbial Clause 2 elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Adverbial Clause 2 meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "Given that global consumer preferences are shifting rapidly, innovation is imperative.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "Given that global consumer preferences are shifting rapidly, innovation is imperative.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Adverbial Clause 2 pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa Result Clauses: So + adjective + That vs Such + noun phrase + That membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Adverbial Clause 2 ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Adverbial Clause 2 dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola Result Clauses!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Pengucapan klausa hasil: Penekanan vokal pada kata "so" dan "such") membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Adverbial Clause 2 Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Adverbial Clause 2 dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Result Clauses: So + adjective + That vs Such + noun phrase + That meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
            6 => [
                'topic' => 'Adjective Clause',
                'focus' => 'Relative Pronouns as Subject (RPS: who, which, that), Object (RPO: whom, which, that), Possessive (RPP: whose), Relative Adverbs (where, when, why), and Reducing Adjective Clauses',
                'listening' => [
                    'title' => 'Listening Practice: Adjective Clause',
                    'audio_script' => 'The distinguished diplomat whose keynote address inspired the plenary session is an expert in multilateral trade. Renewable energy projects which generate clean power contribute directly to global climate targets.',
                    'key_phrases' => [
                        'Engineers who develop energy-efficient microchips are shaping the future of computing.',
                        'The international clients whom we met in Singapore expressed immense satisfaction.',
                        'We partnered with an enterprise whose technological innovations revolutionized rural healthcare.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Adjective Clause?',
                            'options' => [
                                'Adjective Clause',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Adjective Clause',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'Engineers who develop energy-efficient microchips are shaping the future of computing.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'Engineers who develop energy-efficient microchips are shaping the future of computing.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering adjective clause?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Engineers who develop energy-efficient microchips are shaping the future of computing.',
                        'id' => 'Insinyur yang mengembangkan cip mikro hemat energi sedang membentuk masa depan komputasi.',
                    ],
                    [
                        'en' => 'The international clients whom we met in Singapore expressed immense satisfaction.',
                        'id' => 'Klien internasional yang kami temui di Singapura menyatakan kepuasan yang sangat besar.',
                    ],
                    [
                        'en' => 'We partnered with an enterprise whose technological innovations revolutionized rural healthcare.',
                        'id' => 'Kami bermitra dengan perusahaan yang inovasi teknologinya merevolusi layanan kesehatan pedesaan.',
                    ],
                    [
                        'en' => 'The historical period when the industrial revolution emerged transformed global commerce forever.',
                        'id' => 'Periode sejarah ketika revolusi industri muncul mengubah perdagangan global selamanya.',
                    ],
                    [
                        'en' => 'The resolution passed by the general assembly sets binding emission reduction targets.',
                        'id' => 'Resolusi yang disahkan oleh majelis umum menetapkan target pengurangan emisi yang mengikat.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for adjective clause into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk adjective clause ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'Relative clauses: Restrictive (no commas) vs Non-restrictive (commas) | Reduced Adjective Clauses: "The delegates who represent..." -> "The delegates representing..."',
                'pronunciation_tip' => 'Intonasi non-restrictive: Nada sedikit turun di antara dua tanda koma',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Adjective Clause dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Adjective Clause elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Adjective Clause meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "Engineers who develop energy-efficient microchips are shaping the future of computing.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "Engineers who develop energy-efficient microchips are shaping the future of computing.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Adjective Clause pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa Relative clauses: Restrictive (no commas) vs Non-restrictive (commas) membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Adjective Clause ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Adjective Clause dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola Relative clauses!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Intonasi non-restrictive: Nada sedikit turun di antara dua tanda koma) membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Adjective Clause Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Adjective Clause dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Relative clauses: Restrictive (no commas) vs Non-restrictive (commas) meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
            7 => [
                'topic' => 'Reported Speech & Noun Clause',
                'focus' => 'Reported Speech with tense backshifts and reporting verbs (asserted, claimed, emphasized, inquired), Noun Clauses with that/wh-words/if-whether, and Reduced Noun Clauses',
                'listening' => [
                    'title' => 'Listening Practice: Reported Speech & Noun Clause',
                    'audio_script' => 'During the press briefing, the trade minister asserted that exports had surged by thirty percent. Whether global tariffs will fluctuate remains a matter of intense debate among international economists.',
                    'key_phrases' => [
                        'What the research team discovered in the Arctic will alter climate models worldwide.',
                        'Economists are debating whether central banks will lower interest rates next quarter.',
                        'The chief architect emphasized that sustainability must remain the guiding principle of urban planning.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Reported Speech & Noun Clause?',
                            'options' => [
                                'Reported Speech & Noun Clause',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Reported Speech & Noun Clause',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'What the research team discovered in the Arctic will alter climate models worldwide.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'What the research team discovered in the Arctic will alter climate models worldwide.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering reported speech & noun clause?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'What the research team discovered in the Arctic will alter climate models worldwide.',
                        'id' => 'Apa yang ditemukan oleh tim peneliti di Arktik akan mengubah model iklim di seluruh dunia.',
                    ],
                    [
                        'en' => 'Economists are debating whether central banks will lower interest rates next quarter.',
                        'id' => 'Para ekonom sedang memperdebatkan apakah bank sentral akan menurunkan suku bunga kuartal depan.',
                    ],
                    [
                        'en' => 'The chief architect emphasized that sustainability must remain the guiding principle of urban planning.',
                        'id' => 'Kepala arsitek menekankan bahwa keberlanjutan harus tetap menjadi prinsip panduan perencanaan kota.',
                    ],
                    [
                        'en' => 'The parliamentary committee inquired why the cybersecurity measures had not been updated sooner.',
                        'id' => 'Komite parlemen menanyakan mengapa langkah-langkah keamanan siber tidak diperbarui lebih awal.',
                    ],
                    [
                        'en' => 'The board discussed how to allocate surplus capital effectively across emerging markets.',
                        'id' => 'Dewan mendiskusikan bagaimana mengalokasikan surplus modal secara efektif di pasar negara berkembang.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for reported speech & noun clause into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk reported speech & noun clause ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'Noun Clauses as Subject/Object: "What he said is true" / "I wonder whether they will arrive" | Reporting verbs with appropriate prepositions and infinitives',
                'pronunciation_tip' => 'Modulasi pelaporan berita: Nada objektif dan tegas dalam merekonstruksi pernyataan pihak ketiga',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Reported Speech & Noun Clause dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Reported Speech & Noun Clause elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Reported Speech & Noun Clause meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "What the research team discovered in the Arctic will alter climate models worldwide.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "What the research team discovered in the Arctic will alter climate models worldwide.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Reported Speech & Noun Clause pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa Noun Clauses as Subject/Object: "What he said is true" / "I wonder whether they will arrive" membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Reported Speech & Noun Clause ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Reported Speech & Noun Clause dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola Noun Clauses as Subject/Object!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Modulasi pelaporan berita: Nada objektif dan tegas dalam merekonstruksi pernyataan pihak ketiga) membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Reported Speech & Noun Clause Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Reported Speech & Noun Clause dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Noun Clauses as Subject/Object: "What he said is true" / "I wonder whether they will arrive" meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
            8 => [
                'topic' => 'Conditional Sentences',
                'focus' => 'Conditional Sentences Type 1 (Real future: if + present, will + V1), Type 2 (Hypothetical present/future: if + past, would + V1), and Type 3 (Past counterfactual: if + had V3, would have V3)',
                'listening' => [
                    'title' => 'Listening Practice: Conditional Sentences',
                    'audio_script' => 'If we invest boldly in green innovation, we will secure a thriving economy for future generations. If I were the minister of education, I would integrate bilingual debate into every school curriculum. Had we launched the initiative earlier, we would have avoided supply constraints.',
                    'key_phrases' => [
                        'If market demand continues to expand, we will establish a dedicated regional office in Jakarta.',
                        'If I had unlimited philanthropic resources, I would build modern libraries in every rural community.',
                        'Had they verified the legal parameters, they would not have encountered regulatory sanctions.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Conditional Sentences?',
                            'options' => [
                                'Conditional Sentences',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Conditional Sentences',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'If market demand continues to expand, we will establish a dedicated regional office in Jakarta.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'If market demand continues to expand, we will establish a dedicated regional office in Jakarta.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering conditional sentences?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'If market demand continues to expand, we will establish a dedicated regional office in Jakarta.',
                        'id' => 'Jika permintaan pasar terus meningkat, kami akan mendirikan kantor regional khusus di Jakarta.',
                    ],
                    [
                        'en' => 'If I had unlimited philanthropic resources, I would build modern libraries in every rural community.',
                        'id' => 'Jika saya memiliki sumber daya filantropi tanpa batas, saya akan membangun perpustakaan modern di setiap komunitas pedesaan.',
                    ],
                    [
                        'en' => 'Had they verified the legal parameters, they would not have encountered regulatory sanctions.',
                        'id' => 'Seandainya mereka memverifikasi parameter hukum, mereka tidak akan mengalami sanksi regulasi.',
                    ],
                    [
                        'en' => 'Would you mind if we rescheduled our strategy meeting to Friday morning?',
                        'id' => 'Apakah Anda keberatan jika kita menjadwal ulang rapat strategi kita ke Jumat pagi?',
                    ],
                    [
                        'en' => 'If scientists discovered an elixir of life, how would global society balance resources and longevity?',
                        'id' => 'Jika para ilmuwan menemukan ramuan keabadian hidup, bagaimana masyarakat global menyeimbangkan sumber daya dan umur panjang?',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for conditional sentences into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk conditional sentences ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'Conditionals Type 1 (Real possibility) vs Type 2 (Unreal present/were) vs Type 3 (Unreal past regret/had + V3)',
                'pronunciation_tip' => 'Penekanan klausa pengandaian pada kata kerja bantu (*will, would, would have*)',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Conditional Sentences dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Conditional Sentences elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Conditional Sentences meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "If market demand continues to expand, we will establish a dedicated regional office in Jakarta.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "If market demand continues to expand, we will establish a dedicated regional office in Jakarta.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Conditional Sentences pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa Conditionals Type 1 (Real possibility) vs Type 2 (Unreal present/were) vs Type 3 (Unreal past regret/had + V3) membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Conditional Sentences ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Conditional Sentences dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola Conditionals Type 1 (Real possibility) vs Type 2 (Unreal present/were) vs Type 3 (Unreal past regret/had + V3)!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Penekanan klausa pengandaian pada kata kerja bantu (*will, would, would have*)) membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Conditional Sentences Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Conditional Sentences dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Conditionals Type 1 (Real possibility) vs Type 2 (Unreal present/were) vs Type 3 (Unreal past regret/had + V3) meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
            9 => [
                'topic' => 'Participle & Subjunctive',
                'focus' => 'Present and Past Participles as adjectives and clauses (Having analyzed, Exhausted by the journey), Wish & If only structures (wish + past/past perfect/would)',
                'listening' => [
                    'title' => 'Listening Practice: Participle & Subjunctive',
                    'audio_script' => 'Having completed the rigorous feasibility assessment, the delegation presented their findings to parliament. I wish our educational institutions had access to greater digital infrastructure. If only global leaders would unite to combat climate disruption decisively!',
                    'key_phrases' => [
                        'Having synthesized the econometric data, the researchers published a breakthrough report.',
                        'Surrounded by majestic mountain peaks, the research institute offers a peaceful environment for study.',
                        'I wish I had participated in international debate competitions during my university years.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Participle & Subjunctive?',
                            'options' => [
                                'Participle & Subjunctive',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Participle & Subjunctive',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'Having synthesized the econometric data, the researchers published a breakthrough report.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'Having synthesized the econometric data, the researchers published a breakthrough report.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering participle & subjunctive?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'Having synthesized the econometric data, the researchers published a breakthrough report.',
                        'id' => 'Setelah mensintesis data ekonometrika, para peneliti menerbitkan laporan terobosan.',
                    ],
                    [
                        'en' => 'Surrounded by majestic mountain peaks, the research institute offers a peaceful environment for study.',
                        'id' => 'Dikelilingi oleh puncak-puncak gunung yang megah, institut riset tersebut menawarkan lingkungan yang damai untuk belajar.',
                    ],
                    [
                        'en' => 'I wish I had participated in international debate competitions during my university years.',
                        'id' => 'Saya berharap saya telah berpartisipasi dalam kompetisi debat internasional semasa kuliah dulu.',
                    ],
                    [
                        'en' => 'If only governments would allocate greater funding toward renewable energy research!',
                        'id' => 'Seandainya saja pemerintah mau mengalokasikan pendanaan yang lebih besar untuk riset energi terbarukan!',
                    ],
                    [
                        'en' => 'She wishes she were fluent in multiple international languages so as to conduct global diplomacy.',
                        'id' => 'Dia berharap dia fasih dalam berbagai bahasa internasional agar dapat melakukan diplomasi global.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for participle & subjunctive into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk participle & subjunctive ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'Participle Clauses (Active: V-ing, Passive: V3, Perfect: Having + V3) | Subjunctive with Wish / If only (Unreal present: Wish + V2, Unreal past: Wish + Had V3, Desire for change: Wish + Would)',
                'pronunciation_tip' => 'Ekspresi penjiwaan emosional pada kalimat "Wish" dan "If only"',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Participle & Subjunctive dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Participle & Subjunctive elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Participle & Subjunctive meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "Having synthesized the econometric data, the researchers published a breakthrough report.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "Having synthesized the econometric data, the researchers published a breakthrough report.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Participle & Subjunctive pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa Participle Clauses (Active: V-ing, Passive: V3, Perfect: Having + V3) membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Participle & Subjunctive ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Participle & Subjunctive dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola Participle Clauses (Active!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Ekspresi penjiwaan emosional pada kalimat "Wish" dan "If only") membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Participle & Subjunctive Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Participle & Subjunctive dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Participle Clauses (Active: V-ing, Passive: V3, Perfect: Having + V3) meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
            10 => [
                'topic' => 'Review',
                'focus' => 'Comprehensive synthesis of all Super Speaking modules: FANBOYS, Adverbial Clauses, Adjective Clauses, Reported Speech, Conditionals, and Participles',
                'listening' => [
                    'title' => 'Listening Practice: Review',
                    'audio_script' => 'Congratulations on completing the entire Super Speaking program! Throughout these ten meetings, you have mastered sophisticated grammar structures, advanced clauses, conditional reasoning, and dynamic public oratory. You now possess the linguistic power and eloquence to lead international discussions with supreme confidence.',
                    'key_phrases' => [
                        'I integrate complex adverbial and adjective clauses seamlessly into my spontaneous speech.',
                        'My ability to construct persuasive arguments empowers me to excel in high-stakes negotiations.',
                        'I construct accurate conditional sentences and reported speech structures with effortless precision.',
                    ],
                    'questions' => [
                        [
                            'q' => 'What is the central focus of this Super Speaking audio training on Review?',
                            'options' => [
                                'Review',
                                'Basic Alphabet Rhymes',
                                'Kindergarten Counting',
                                'Unrelated Theory',
                            ],
                            'answer' => 'Review',
                        ],
                        [
                            'q' => 'Which core principle is highlighted by the speaker?',
                            'options' => [
                                'I integrate complex adverbial and adjective clauses seamlessly into my spontaneous speech.',
                                'Complete silence during conversations',
                                'Giving up when challenged',
                                'Speaking in disjointed single words',
                            ],
                            'answer' => 'I integrate complex adverbial and adjective clauses seamlessly into my spontaneous speech.',
                        ],
                        [
                            'q' => 'What speaking capability is developed by mastering review?',
                            'options' => [
                                'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                                'Loss of fluency',
                                'Cognitive hesitation',
                                'Impaired sentence structure',
                            ],
                            'answer' => 'Seamless sentence connection, rhetorical precision, and confident spontaneity',
                        ],
                    ],
                ],
                'drilling1' => [
                    [
                        'en' => 'I integrate complex adverbial and adjective clauses seamlessly into my spontaneous speech.',
                        'id' => 'Saya mengintegrasikan klausa adverbial dan ajektiva yang kompleks secara mulus ke dalam ucapan spontan saya.',
                    ],
                    [
                        'en' => 'My ability to construct persuasive arguments empowers me to excel in high-stakes negotiations.',
                        'id' => 'Kemampuan saya menyusun argumen yang persuasif memberdayakan saya untuk unggul dalam negosiasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'I construct accurate conditional sentences and reported speech structures with effortless precision.',
                        'id' => 'Saya menyusun kalimat pengandaian dan struktur kalimat tidak langsung yang akurat dengan ketepatan tanpa ragu.',
                    ],
                    [
                        'en' => 'Public speaking challenges no longer intimidate me; they serve as platforms for impactful leadership.',
                        'id' => 'Tantangan berbicara di depan umum tidak lagi mencemaskan saya; tantangan itu menjadi panggung kepemimpinan yang berdampak.',
                    ],
                    [
                        'en' => 'I will continue cultivating my English speaking mastery to inspire positive change across the world.',
                        'id' => 'Saya akan terus mengembangkan penguasaan berbicara bahasa Inggris saya untuk menginspirasi perubahan positif di seluruh dunia.',
                    ],
                ],
                'drilling2' => [
                    [
                        'en' => 'We practice integrating advanced structures for review into spontaneous discussions.',
                        'id' => 'Kami berlatih mengintegrasikan struktur tingkat lanjut untuk review ke dalam diskusi spontan.',
                    ],
                    [
                        'en' => 'She delivers articulate, well-structured arguments during our classroom debate sessions.',
                        'id' => 'Dia menyampaikan argumen yang lugas dan terstruktur rapi saat sesi debat kelas kami.',
                    ],
                    [
                        'en' => 'I consistently shadow native recordings to master complex sentence rhythms and clause transitions.',
                        'id' => 'Saya secara konsisten menirukan rekaman penutur asli untuk menguasai ritme kalimat kompleks dan transisi klausa.',
                    ],
                    [
                        'en' => 'They express sophisticated ideas without hesitation during high-stakes presentations.',
                        'id' => 'Mereka mengekspresikan ide-ide berbobot tanpa ragu saat presentasi berisiko tinggi.',
                    ],
                    [
                        'en' => 'He records his impromptu responses to critically assess grammatical precision and lexical variety.',
                        'id' => 'Dia merekam respon spontannya untuk mengevaluasi ketepatan tata bahasa dan variasi kosakatanya secara kritis.',
                    ],
                ],
                'grammar_note' => 'Comprehensive Synthesis of B2/C1 Grammar into Spontaneous Speaking Competency',
                'pronunciation_tip' => 'Artikulasi wibawa paripurna: Penguasaan intonasi, tempo, dan resonansi vokal kelas dunia',
                'dialogue_setting' => 'Dua profesional berlatih menguasai struktur Review dalam sesi akselerasi Super Speaking.',
                'dialogue' => [
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'How does mastering Review elevate your conversational fluency?',
                        'id' => 'Bagaimana penguasaan Review meningkatkan kelancaran percakapanmu?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'It enables me to link complex thoughts together logically without pausing to translate.',
                        'id' => 'Ini memungkinkan saya menghubungkan pemikiran kompleks secara logis tanpa harus jeda menerjemahkan.',
                    ],
                    [
                        'speaker' => 'Coach Ryan',
                        'en' => 'Which sentence pattern from this lesson felt most impactful when speaking?',
                        'id' => 'Pola kalimat mana dari pelajaran ini yang terasa paling berdampak saat berbicara?',
                    ],
                    [
                        'speaker' => 'Elena',
                        'en' => 'Definitely: "I integrate complex adverbial and adjective clauses seamlessly into my spontaneous speech.". It sounds very articulate and persuasive.',
                        'id' => 'Pasti: "I integrate complex adverbial and adjective clauses seamlessly into my spontaneous speech.". Terdengar sangat lugas dan persuasif.',
                    ],
                ],
                'monolog_baku' => [
                    'Penguasaan materi Review pada program Super Speaking membekali pembicara dengan kemampuan menyusun kalimat majemuk bertingkat secara spontan. Kita belajar menghubungkan ide menggunakan klausa yang tepat sehingga wacana terdengar berbobot dan terstruktur.',
                    'Penerapan prinsip tata bahasa Comprehensive Synthesis of B2/C1 Grammar into Spontaneous Speaking Competency membuktikan bahwa kemahiran berbicara bahasa Inggris bukan sekadar berbicara cepat, melainkan kemampuan menyampaikan pesan yang logis, presisi, dan meyakinkan.',
                ],
                'monolog_tidak_baku' => [
                    'Materi Review ini bener-bener ngebantu banget buat bikin omongan bahasa Inggris kita naik kelas. Dulu kalo ngomong kalimatnya pendek-pendek dan keputus-putus, sekarang udah bisa nyambungin ide pake klausa panjang yang mengalir.',
                    'Pas dipraktekkin langsung lewat latihan speaking di kelas, kita dilatih buat langsung ngomong lancar tanpa takut salah grammar. Lama-lama refleks ngomongnya jadi otomatis keluar.',
                ],
                'questions_part_a' => [
                    'Apa manfaat terbesar dari mempelajari struktur Review dalam komunikasi sehari-harimu?',
                    'Coba buat satu kalimat kompleks menggunakan pola Comprehensive Synthesis of B2/C1 Grammar into Spontaneous Speaking Competency!',
                    'Bagaimana cara kamu menjaga kelancaran berbicara saat harus menggunakan kalimat yang panjang dan bertingkat?',
                    'Dalam situasi presentasi atau diskusi apa materi meeting ini paling sering kamu terapkan?',
                    'Ceritakan satu pengalaman menarik yang berkaitan dengan penerapan materi ini.',
                ],
                'questions_part_b' => [
                    'Bagaimana teknik intonasi (Artikulasi wibawa paripurna: Penguasaan intonasi, tempo, dan resonansi vokal kelas dunia) membantu memperjelas maksud pesanmu kepada pendengar?',
                    'Apa strategi terbaikmu dalam meminimalkan jeda hening (*awkward silence*) saat berpikir di tengah pembicaraan?',
                    'Bagaimana kamu mengukur peningkatan rasa percaya dirimu setelah menguasai materi ini?',
                    'Siapa pembicara publik yang gaya penggabungan kalimatnya paling menginspirasi caramu berbicara?',
                ],
                'impromptu_title' => 'Pertanyaan & Aktivitas Final – Review Speaking Challenge',
                'impromptu' => [
                    'Aktivitas Speaking Final: Sampaikan pidato terstruktur selama 2 menit mengenai signifikansi Review dalam karier atau kehidupan akademismu.',
                    'Jelaskan bagaimana pemahaman mendalam tentang Comprehensive Synthesis of B2/C1 Grammar into Spontaneous Speaking Competency meningkatkan kualitas retorika berbicaramu.',
                    'Simulasikan sesi diskusi interaktif di mana kamu harus mempertahankan argumenmu menggunakan variasi klausa yang kompleks.',
                    'Refleksikan kemajuan berbicara bahasa Inggrismu sejak pertemuan pertama hingga saat ini.',
                ],
            ],
        ];

        return $data[$meeting] ?? $data[1];
    }
}
