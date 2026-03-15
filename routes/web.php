<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\OtpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Cleanup Route (Temporary - Public) - Removed
// Route::get('/cleanup-ielts-reading', [App\Http\Controllers\AssignmentController::class, 'cleanupIeltsReading']);

// Guest Portal (Free Tests & Lessons)
Route::get('/free-tests', [App\Http\Controllers\GuestController::class, 'index'])->name('guest.free-tests');

// Authenticated Guest Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/guest/my-english', [App\Http\Controllers\GuestController::class, 'myEnglish'])->name('guest.my-english');
});

// Public Scholarship Search Routes
Route::get('/scholarships-search', [App\Http\Controllers\ScholarshipSearchController::class, 'index'])->name('scholarships.search.index');
Route::get('/scholarships-search/{scholarship}', [App\Http\Controllers\ScholarshipSearchController::class, 'show'])->name('scholarships.search.show')->whereNumber('scholarship');

// Overseas Job Vacancies Public Routes
Route::get('/overseas-jobs', [App\Http\Controllers\JobVacancySearchController::class, 'index'])->name('overseas-jobs.index');
Route::get('/overseas-jobs/{jobVacancy}', [App\Http\Controllers\JobVacancySearchController::class, 'show'])->name('overseas-jobs.show')->whereNumber('jobVacancy');

// Free Lesson Routes (Public Access)
Route::get('/free-lesson', [App\Http\Controllers\FreeLessonController::class, 'index'])->name('free-lesson');
Route::get('/vocabulary-a1', [App\Http\Controllers\FreeLessonController::class, 'vocabularyA1'])->name('vocabulary-a1');
Route::get('/vocabulary-a1-topic/{id}', [App\Http\Controllers\FreeLessonController::class, 'topic'])->name('vocabulary-topic');

Route::get('/vocabulary-a2', [App\Http\Controllers\FreeLessonController::class, 'vocabularyA2'])->name('vocabulary-a2');
Route::get('/vocabulary-a2-topic/{id}', [App\Http\Controllers\FreeLessonController::class, 'topicA2'])->name('vocabulary-a2-topic');

Route::get('/vocabulary-b1', [App\Http\Controllers\FreeLessonController::class, 'vocabularyB1'])->name('vocabulary-b1');
Route::get('/vocabulary-b1-topic/{id}', [App\Http\Controllers\FreeLessonController::class, 'topicB1'])->name('vocabulary-b1-topic');

Route::get('/vocabulary-b2', [App\Http\Controllers\FreeLessonController::class, 'vocabularyB2'])->name('vocabulary-b2');
Route::get('/vocabulary-b2-topic/{id}', [App\Http\Controllers\FreeLessonController::class, 'topicB2'])->name('vocabulary-b2-topic');

Route::get('/vocabulary-c1', [App\Http\Controllers\FreeLessonController::class, 'vocabularyC1'])->name('vocabulary-c1');
Route::get('/vocabulary-c1-topic/{id}', [App\Http\Controllers\FreeLessonController::class, 'topicC1'])->name('vocabulary-c1-topic');

// Parts of Speech Routes
Route::get('/vocabulary-verb', [App\Http\Controllers\FreeLessonController::class, 'vocabularyVerb'])->name('vocabulary-verb');
Route::get('/vocabulary-verb-level/{level}', [App\Http\Controllers\FreeLessonController::class, 'vocabularyVerbLevel'])->name('vocabulary-verb-level');

Route::get('/vocabulary-adjective', [App\Http\Controllers\FreeLessonController::class, 'vocabularyAdjective'])->name('vocabulary-adjective');
Route::get('/vocabulary-adjective-level/{level}', [App\Http\Controllers\FreeLessonController::class, 'vocabularyAdjectiveLevel'])->name('vocabulary-adjective-level');

Route::get('/vocabulary-adverb', [App\Http\Controllers\FreeLessonController::class, 'vocabularyAdverb'])->name('vocabulary-adverb');
Route::get('/vocabulary-adverb-level/{level}', [App\Http\Controllers\FreeLessonController::class, 'vocabularyAdverbLevel'])->name('vocabulary-adverb-level');

// Other Modules Routes
Route::get('/english-expression', [App\Http\Controllers\FreeLessonController::class, 'englishExpression'])->name('english-expression');
Route::get('/english-expression-level/{level}', [App\Http\Controllers\FreeLessonController::class, 'englishExpressionLevel'])->name('english-expression-level');

Route::get('/idioms', [App\Http\Controllers\FreeLessonController::class, 'idioms'])->name('idioms');
Route::get('/idioms-level/{level}', [App\Http\Controllers\FreeLessonController::class, 'idiomsLevel'])->name('idioms-level');

Route::get('/phrasal-verbs', [App\Http\Controllers\FreeLessonController::class, 'phrasalVerbs'])->name('phrasal-verbs');
Route::get('/phrasal-verbs-level/{level}', [App\Http\Controllers\FreeLessonController::class, 'phrasalVerbsLevel'])->name('phrasal-verbs-level');

Route::get('/irregular-verbs', [App\Http\Controllers\FreeLessonController::class, 'irregularVerbs'])->name('irregular-verbs');
Route::post('/free-lesson/progress', [App\Http\Controllers\FreeLessonController::class, 'saveProgress'])->name('free-lesson.progress');

// Free Test Registration for Guests
Route::get('/free-test/register/{type}', [App\Http\Controllers\GuestFreeTestController::class, 'showRegistrationForm'])->name('free-test.register.show');
Route::post('/free-test/register/{type}', [App\Http\Controllers\GuestFreeTestController::class, 'registerAndStart'])->name('free-test.register.submit');

// Public: Calendar Events API (accessible to guests and students)
Route::get('/api/scholarships/calendar-events', [App\Http\Controllers\ScholarshipSearchController::class, 'getCalendarEvents'])->name('api.scholarships.calendar-events');

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Free Tests (Guest and Student)
    Route::get('/free-test/{type}', [App\Http\Controllers\FreeTestController::class, 'show'])->name('free-test.show');
    Route::post('/free-test/{type}/submit', [App\Http\Controllers\FreeTestController::class, 'submit'])->name('free-test.submit');
    Route::get('/free-test/result/{id}', [App\Http\Controllers\FreeTestController::class, 'result'])->name('free-test.result');
    Route::get('/free-test/result/{id}/certificate', [App\Http\Controllers\FreeTestController::class, 'downloadCertificate'])->name('free-test.certificate.download');
    
    // Bookmark and Target Scholarship Routes
    Route::post('/scholarships-search/{scholarship}/save', [App\Http\Controllers\ScholarshipSearchController::class, 'toggleSave'])->name('scholarships.search.save');
    Route::post('/scholarships-search/{scholarship}/target', [App\Http\Controllers\ScholarshipSearchController::class, 'toggleTarget'])->name('scholarships.search.target');

    Route::get('/dashboard', function () {
        $user = auth()->user();

        // If a real admin (not impersonating) tries to access the student dashboard, redirect them to the admin dashboard.
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }

        // If the user is a guest, direct them to the free tests page.
        if ($user->role === 'guest') {
            return redirect()->route('guest.free-tests');
        }

        // 1. Progress Stats
        // Assuming 'Meeting' model represents the standard grammar meetings
        $totalAssignments = \App\Models\Meeting::count(); 
        if ($totalAssignments === 0) $totalAssignments = 20; 

        $completedAssignments = \App\Models\MeetingScore::where('user_id', $user->id)->count();
        $progressPercentage = $totalAssignments > 0 ? ($completedAssignments / $totalAssignments) * 100 : 0;

        // 2. Score Stats
        $averageScore = \App\Models\MeetingScore::where('user_id', $user->id)->avg('score') ?? 0;
        $highestScore = \App\Models\MeetingScore::where('user_id', $user->id)->max('score') ?? 0;
        $totalPoints = \App\Models\MeetingScore::where('user_id', $user->id)->sum('score');

        // 3. Recent Activity (Class Assignments)
        $recentActivity = \App\Models\MeetingScore::where('user_id', $user->id)
            ->orderByDesc('submitted_at')
            ->limit(5)
            ->get();

        // 4. Latest Free Test & Recommendation logic
        $latestTest = \App\Models\FreeTestResult::where('user_id', $user->id)->latest()->first();
        $recommendedProgram = null;
        $targetScore = null;

        if ($latestTest) {
            $outreachMessage = \App\Models\OutreachMessage::query()->with('program')
                ->where('test_type', $latestTest->test_type)
                ->where('target_role', $user->role)
                ->where('min_score', '<=', $latestTest->score)
                ->where('max_score', '>=', $latestTest->score)
                ->first();

            if ($outreachMessage && $outreachMessage->program) {
                $recommendedProgram = $outreachMessage->program;
            }

            // Simple logic for Target Score based on latest test score
            $score = $latestTest->score;
            $isIelts = str_starts_with($latestTest->test_type, 'ielts_') || $latestTest->test_type === 'pte_academic';
            if ($isIelts) {
                $targetScore = min(9.0, $score + 1.0); // e.g. 5.5 -> 6.5
            } else {
                $targetScore = min(677, $score + 50); // e.g. 450 -> 500
            }
        }

        // 5. Upcoming Classes (from User's Class Period)
        $upcomingClasses = collect();
        if ($user->classPeriod) {
            $upcomingClasses = $user->classPeriod->classMeetings()
                ->where('meeting_date', '>=', now()->toDateString())
                ->orderBy('meeting_date')
                ->orderBy('start_time')
                ->limit(3)
                ->get();
        }

        // 6. Chart Data (Standardized for M1-M20)
        $scores = \App\Models\MeetingScore::where('user_id', $user->id)
            ->pluck('score', 'meeting_number')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 20; $i++) {
            $chartData[] = $scores[$i] ?? 0;
        }

        // 7. Sprint 3: Progress Prediction Model
        // Calculate predicted score based on average MeetingScore
        $predictedScore = null;
        if ($completedAssignments > 0) {
            // Rough conversion: Assuming max average score is 100
            // TOEFL max is ~677, IELTS max is 9.0
            
            // Try to guess program type based on latest test if available, or just fallback
            $isIeltsProgram = false;
            if ($latestTest) {
                $isIeltsProgram = str_starts_with($latestTest->test_type, 'ielts_') || $latestTest->test_type === 'pte_academic';
            } elseif ($user->program && stripos($user->program->name, 'IELTS') !== false) {
                $isIeltsProgram = true;
            }

            if ($isIeltsProgram) {
                // IELTS Mapping (e.g., 80 avg = ~7.0, 90 avg = ~8.0, 100 avg = 9.0)
                $predictedScore = round(($averageScore / 100) * 9.0 * 2) / 2; // Round to nearest 0.5
                $predictedScore = number_format(max(1.0, min(9.0, $predictedScore)), 1);
            } else {
                // TOEFL Mapping (e.g., 50 avg = 450, 75 avg = 550, 100 avg = 677)
                // Linear mapping from 0-100 to 310-677
                $baseToefl = 310;
                $predictedScore = round($baseToefl + (($averageScore / 100) * (677 - $baseToefl)));
                $predictedScore = max(310, min(677, $predictedScore));
            }
        }

        // 8. Sprint 3 & 4: Adaptive Assignments & Diagnostic Scorecard
        $lowestScores = \App\Models\MeetingScore::where('user_id', $user->id)
            ->where('score', '<', 70) // Threshold for weakness
            ->orderBy('score', 'asc')
            ->orderBy('submitted_at', 'desc')
            ->limit(2)
            ->get();
            
        // 9. Sprint 4: Score Bands for Diagnostic Scorecard
        $diagnosticStats = [
            'excellent' => 0, // 90-100
            'good'      => 0, // 70-89
            'needs_review' => 0, // < 70
        ];
        
        foreach ($scores as $scoreVal) {
            if ($scoreVal >= 90) {
                $diagnosticStats['excellent']++;
            } elseif ($scoreVal >= 70) {
                $diagnosticStats['good']++;
            } else {
                $diagnosticStats['needs_review']++;
            }
        }
            
        // Sprint 4: Enrolled Program
        $enrolledProgram = $user->program;

        // Target Scholarship Feature
        $targetScholarship = $user->targetScholarships()->first();

        return view('dashboard', [
            'progressPercentage' => $progressPercentage,
            'totalCompleted'     => $completedAssignments,
            'totalAssignments'   => $totalAssignments,
            'averageScore'       => round($averageScore, 1),
            'highestScore'       => $highestScore,
            'totalPoints'        => $totalPoints,
            'recentActivity'     => $recentActivity,
            'latestTest'         => $latestTest,
            'recommendedProgram' => $recommendedProgram,
            'targetScore'        => $targetScore,
            'upcomingClasses'    => $upcomingClasses,
            'chartData'          => $chartData,
            'predictedScore'     => $predictedScore,
            'lowestScores'       => $lowestScores,
            'enrolledProgram'    => $enrolledProgram,
            'diagnosticStats'    => $diagnosticStats,
            'targetScholarship'  => $targetScholarship,
        ]);
    })->name('dashboard');

    // Sprint 5: My Progress
    Route::get('/my-progress', [App\Http\Controllers\ProgressController::class, 'index'])->name('student.progress');

    // Sprint 6: Schedule
    Route::get('/schedule', [App\Http\Controllers\ScheduleController::class, 'index'])->name('student.schedule');

    // Referral System
    Route::get('/referrals', [App\Http\Controllers\ReferralController::class, 'index'])->name('student.referrals.index');
    Route::post('/referrals/claim', [App\Http\Controllers\ReferralController::class, 'claim'])->name('student.referrals.claim');
    Route::post('/referrals/social-submit', [App\Http\Controllers\ReferralController::class, 'submitSocialMedia'])->name('student.referrals.social.submit');



    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student Evaluation Routes
    Route::get('/evaluate-teacher', [App\Http\Controllers\Student\TeacherEvaluationController::class, 'create'])->name('student.evaluations.create');
    Route::post('/evaluate-teacher', [App\Http\Controllers\Student\TeacherEvaluationController::class, 'store'])->name('student.evaluations.store');
});

Route::middleware(['auth'])->group(function () {
    // Scholarships Routes
    Route::get('/scholarships', [App\Http\Controllers\ScholarshipController::class, 'index'])->name('scholarships.index');
    Route::get('/scholarships/{scholarship}', [App\Http\Controllers\ScholarshipController::class, 'show'])->name('scholarships.show');

    Route::get('/assignments', [App\Http\Controllers\AssignmentController::class, 'index'])->name('assignments.index');
    // Cleanup Route (Temporary) - Outside this block in next step or just accessed via browser tool logged in?
    // Actually, I'll just remove it from here and put it at the top of the file in a separate replace call if needed, 
    // but the tool allows me to just replace this block.
    // Let's just remove it from here and add it at line 5.
    
    Route::get('/ielts/academic', [App\Http\Controllers\AssignmentController::class, 'ieltsAcademic'])->name('assignments.ielts-academic');
    Route::get('/assignments/pte-academic', [App\Http\Controllers\AssignmentController::class, 'pteAcademic'])->name('assignments.pte-academic');
    Route::get('/assignments/ielts-general', [App\Http\Controllers\AssignmentController::class, 'ieltsGeneral'])->name('assignments.ielts-general');

    // IELTS Academic Listening Routes
    Route::get('/assignments/ielts-academic/listening', [App\Http\Controllers\AssignmentController::class, 'ieltsListeningIndex'])->name('assignments.ielts-academic.listening.index');
    Route::get('/assignments/ielts-academic/listening/material/{id}', [App\Http\Controllers\AssignmentController::class, 'ieltsListeningMaterial'])->name('assignments.ielts-academic.listening.material');
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-audio', [App\Http\Controllers\AssignmentController::class, 'uploadIeltsMaterialAudio'])->name('assignments.ielts-academic.listening.material.upload-audio');
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-srt', [App\Http\Controllers\AssignmentController::class, 'uploadIeltsMaterialSrt'])->name('assignments.ielts-academic.listening.material.upload-srt');
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-answer-key', [App\Http\Controllers\AssignmentController::class, 'uploadIeltsMaterialAnswerKey'])->name('assignments.ielts-academic.listening.material.upload-answer-key');
    Route::get('/assignments/ielts-academic/listening/practice-index', [App\Http\Controllers\AssignmentController::class, 'listeningPracticeIndex'])->name('assignments.ielts-academic.listening.practice.index');
    Route::get('/assignments/ielts-academic/listening/practice-index/part{set}', [App\Http\Controllers\AssignmentController::class, 'listeningPracticeIndexPart'])->name('assignments.ielts-academic.listening.practice-index.part');
    Route::get('/assignments/ielts-academic/speaking/practice-index', [App\Http\Controllers\AssignmentController::class, 'ieltsSpeakingPracticeIndex'])->name('assignments.ielts-academic.speaking.practice.index');
    Route::get('/assignments/ielts-academic/speaking/practice-index/part{part}', [App\Http\Controllers\AssignmentController::class, 'ieltsSpeakingPracticeIndexPart'])->name('assignments.ielts-academic.speaking.practice-index.part');
    Route::get('/assignments/ielts-academic/writing/practice-index', [App\Http\Controllers\AssignmentController::class, 'ieltsWritingPracticeIndex'])->name('assignments.ielts-academic.writing.practice.index');
    Route::get('/assignments/ielts-academic/listening/warm-up/{type}', [App\Http\Controllers\AssignmentController::class, 'ieltsListeningWarmUp'])->name('assignments.ielts-academic.listening.warmup');
    Route::get('/api/dictionary/lookup', [App\Http\Controllers\ToeflDictionaryController::class, 'lookup'])->name('api.dictionary.lookup');
    Route::get('/api/dictionary/synonyms', [App\Http\Controllers\ToeflDictionaryController::class, 'synonyms'])->name('api.dictionary.synonyms');
    Route::get('/api/ollama/collocation', [App\Http\Controllers\OllamaController::class, 'getCollocations'])->name('api.ollama.collocation');
    Route::post('/api/ollama/translate', [App\Http\Controllers\OllamaController::class, 'translate'])->name('api.ollama.translate');
    
    // Legacy / Other Routes
    Route::post('/assignments/ielts-academic/listening/reorder', [App\Http\Controllers\AssignmentController::class, 'reorderIeltsListeningMeetings'])->name('assignments.ielts.listening.reorder');
    Route::post('/assignments/ielts-academic/listening/meeting', [App\Http\Controllers\AssignmentController::class, 'storeIeltsMeeting'])->name('assignments.ielts.listening.meeting.store');
    Route::put('/assignments/ielts-academic/listening/meeting/{id}', [App\Http\Controllers\AssignmentController::class, 'updateIeltsMeeting'])->name('assignments.ielts.listening.meeting.update');
    Route::delete('/assignments/ielts-academic/listening/meeting/{id}', [App\Http\Controllers\AssignmentController::class, 'destroyIeltsMeeting'])->name('assignments.ielts.listening.meeting.destroy');
    Route::post('/assignments/ielts-academic/listening/meeting/{id}/toggle-lock', [App\Http\Controllers\AssignmentController::class, 'toggleIeltsMeetingLock'])->name('assignments.ielts.listening.meeting.toggle-lock');

    // Questions Form
    Route::get('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}', [App\Http\Controllers\AssignmentController::class, 'ieltsListeningPart1Practice'])->name('assignments.ielts-academic.listening.part1.practice');
    Route::get('/assignments/ielts-academic/listening/practice-index/part{set}/test{test}', [App\Http\Controllers\AssignmentController::class, 'listeningPracticeIndexTest'])->name('assignments.ielts-academic.listening.practice-index.test');
    Route::get('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/test/{test}', [App\Http\Controllers\AssignmentController::class, 'ieltsListeningPracticeTest'])->name('assignments.ielts-academic.listening.part1.practice.test');
    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/test/{test}/submit', [App\Http\Controllers\AssignmentController::class, 'submitIeltsListening'])->name('assignment.ielts.listening.submit');
    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/upload-audio', [App\Http\Controllers\AssignmentController::class, 'uploadIeltsListeningAudio'])->name('assignments.ielts.listening.upload-audio');
    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/upload-srt', [App\Http\Controllers\AssignmentController::class, 'uploadIeltsListeningSrt'])->name('assignments.ielts.listening.upload-srt');

    // IELTS Academic Reading Routes
    Route::get('/assignments/ielts-academic/reading', [App\Http\Controllers\AssignmentController::class, 'ieltsReadingIndex'])->name('assignments.ielts-academic.reading.index');
    Route::get('/assignments/ielts-academic/reading/material/{id}', [App\Http\Controllers\AssignmentController::class, 'ieltsReadingMaterial'])->name('assignments.ielts-academic.reading.material');
    Route::get('/assignments/ielts-academic/reading/practice-index', [App\Http\Controllers\AssignmentController::class, 'ieltsReadingPracticeIndex'])->name('assignments.ielts-academic.reading.practice-index');
    Route::post('/assignments/ielts-academic/reading/reorder', [App\Http\Controllers\AssignmentController::class, 'reorderIeltsReadingMeetings'])->name('assignments.ielts.reading.reorder');
    Route::post('/assignments/ielts-academic/reading/meeting', [App\Http\Controllers\AssignmentController::class, 'storeIeltsReadingMeeting'])->name('assignments.ielts.reading.meeting.store');
    
    // Generic IELTS Meeting Routes (Reused logic, different route names for clarity/convention if needed, but pointing to generic controller methods)
    Route::put('/assignments/ielts-academic/reading/meeting/{id}', [App\Http\Controllers\AssignmentController::class, 'updateIeltsMeeting'])->name('assignments.ielts.reading.meeting.update');
    Route::delete('/assignments/ielts-academic/reading/meeting/{id}', [App\Http\Controllers\AssignmentController::class, 'destroyIeltsMeeting'])->name('assignments.ielts.reading.meeting.destroy');
    Route::post('/assignments/ielts-academic/reading/meeting/{id}/toggle-lock', [App\Http\Controllers\AssignmentController::class, 'toggleIeltsMeetingLock'])->name('assignments.ielts.reading.meeting.toggle-lock');
    
    // IELTS Reading Material CRUD Routes
    Route::post('/admin/ielts-reading/passage', [App\Http\Controllers\AssignmentController::class, 'storePassage'])->name('admin.ielts.reading.passage.store');
    Route::put('/admin/ielts-reading/passage/{id}', [App\Http\Controllers\AssignmentController::class, 'updatePassage'])->name('admin.ielts.reading.passage.update');
    Route::delete('/admin/ielts-reading/passage/{id}', [App\Http\Controllers\AssignmentController::class, 'deletePassage'])->name('admin.ielts.reading.passage.delete');
    
    Route::post('/admin/ielts-reading/question', [App\Http\Controllers\AssignmentController::class, 'storeQuestion'])->name('admin.ielts.reading.question.store');
    Route::put('/admin/ielts-reading/question/{id}', [App\Http\Controllers\AssignmentController::class, 'updateQuestion'])->name('admin.ielts.reading.question.update');
    Route::delete('/admin/ielts-reading/question/{id}', [App\Http\Controllers\AssignmentController::class, 'deleteQuestion'])->name('admin.ielts.reading.question.delete');



    // Mockup Cambridge Test Route Handlers
    Route::get('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}', [App\Http\Controllers\AssignmentController::class, 'ieltsCambridgeTestSkills'])->name('assignments.ielts-academic.mockup.cambridge.skills');
    Route::get('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/{skill}', [App\Http\Controllers\AssignmentController::class, 'ieltsCambridgeTestTest'])->name('assignments.ielts-academic.mockup.cambridge.test');
    
    // Admin Upload Routes for Cambridge Test
    Route::post('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/upload-audio', [App\Http\Controllers\AssignmentController::class, 'uploadIeltsMockupCambridgeAudio'])->name('assignments.ielts-academic.mockup.cambridge.upload-audio');
    Route::post('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/upload-srt', [App\Http\Controllers\AssignmentController::class, 'uploadIeltsMockupCambridgeSrt'])->name('assignments.ielts-academic.mockup.cambridge.upload-srt');
    Route::post('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/upload-answer-key', [App\Http\Controllers\AssignmentController::class, 'uploadIeltsMockupCambridgeAnswerKey'])->name('assignments.ielts-academic.mockup.cambridge.upload-answer-key');

    // Mockup Cambridge
    Route::get('/assignments/ielts-academic/mockup/cambridge', [App\Http\Controllers\AssignmentController::class, 'ieltsCambridgeMockUp'])->name('assignments.ielts-academic.mockup.cambridge');
    Route::get('/assignments/ielts-academic/mockup/cambridge/{edition}', [App\Http\Controllers\AssignmentController::class, 'ieltsCambridgeEdition'])->name('assignments.ielts-academic.mockup.cambridge.edition');

    // Reading Mockup
    Route::get('/assignments/ielts-academic/mockup/reading', [App\Http\Controllers\AssignmentController::class, 'ieltsReadingMockUp'])->name('assignments.ielts-academic.mockup.reading');

    // Writing
    // Writing
    Route::post('/assignments/ielts-academic/writing/evaluate', [App\Http\Controllers\AssignmentController::class, 'evaluateIeltsWriting'])->name('assignments.ielts.writing.evaluate');
    Route::post('/assignments/ielts-academic/writing/feedback', [App\Http\Controllers\AssignmentController::class, 'evaluateIeltsFeedback'])->name('assignments.ielts.writing.feedback');
    Route::post('/assignments/ielts-academic/writing/correct', [App\Http\Controllers\AssignmentController::class, 'evaluateIeltsCorrection'])->name('assignments.ielts.writing.correct');
    Route::post('/assignments/ielts-academic/writing/vocabulary', [App\Http\Controllers\AssignmentController::class, 'evaluateIeltsVocabulary'])->name('assignments.ielts.writing.vocabulary');
    Route::post('/assignments/ielts-academic/writing/coherence', [App\Http\Controllers\AssignmentController::class, 'evaluateIeltsCoherence'])->name('assignments.ielts.writing.coherence');
    Route::post('/assignments/ielts-academic/writing/task-response', [App\Http\Controllers\AssignmentController::class, 'evaluateIeltsTaskResponse'])->name('assignments.ielts.writing.task_response');
    Route::post('/assignments/ielts-academic/writing/grammar', [App\Http\Controllers\AssignmentController::class, 'evaluateIeltsGrammar'])->name('assignments.ielts.writing.grammar');
    Route::post('/assignments/ielts-academic/writing/improve', [App\Http\Controllers\AssignmentController::class, 'improveIeltsWriting'])->name('assignments.ielts.writing.improve');
    Route::get('/assignments/ielts-academic/writing', [App\Http\Controllers\AssignmentController::class, 'ieltsWritingIndex'])->name('assignments.ielts-academic.writing.index');
    Route::get('/assignments/ielts-academic/writing/{task}/meeting/{id}', [App\Http\Controllers\AssignmentController::class, 'ieltsWritingMeeting'])->name('assignments.ielts-academic.writing.meeting');
    Route::post('/assignments/ielts-academic/writing', [App\Http\Controllers\AssignmentController::class, 'storeIeltsWritingMeeting'])->name('assignments.ielts.writing.store');
    Route::put('/assignments/ielts-academic/writing/{id}', [App\Http\Controllers\AssignmentController::class, 'updateIeltsWritingMeeting'])->name('assignments.ielts.writing.update');
    Route::delete('/assignments/ielts-academic/writing/{id}', [App\Http\Controllers\AssignmentController::class, 'deleteIeltsWritingMeeting'])->name('assignments.ielts.writing.destroy');
    Route::get('/assignments/ielts-academic/mockup/writing', [App\Http\Controllers\AssignmentController::class, 'ieltsWritingMockUp'])->name('assignments.ielts-academic.mockup.writing');
    Route::get('/assignments/ielts-academic/mockup/writing/{id}', function($id) {
        return app(\App\Http\Controllers\AssignmentController::class)->ieltsListeningMockUpTest($id, 'writing');
    })->name('assignments.ielts-academic.mockup.writing.test');
    
    // IELTS Writing Question CRUD
    Route::post('/assignments/ielts-academic/writing/questions', [App\Http\Controllers\AssignmentController::class, 'storeIeltsWritingQuestion'])->name('assignments.ielts.writing.question.store');
    Route::put('/assignments/ielts-academic/writing/questions/{id}', [App\Http\Controllers\AssignmentController::class, 'updateIeltsWritingQuestion'])->name('assignments.ielts.writing.question.update');
    Route::delete('/assignments/ielts-academic/writing/questions/{id}', [App\Http\Controllers\AssignmentController::class, 'deleteIeltsWritingQuestion'])->name('assignments.ielts.writing.question.destroy');

    // Speaking
    Route::get('/assignments/ielts-academic/speaking', [App\Http\Controllers\AssignmentController::class, 'ieltsSpeakingIndex'])->name('assignments.ielts-academic.speaking.index');
    Route::get('/assignments/ielts-academic/speaking/practice', [App\Http\Controllers\AssignmentController::class, 'ieltsSpeakingPractice'])->name('assignments.ielts-academic.speaking.practice');
    Route::post('/assignments/ielts-academic/speaking/practice/grade', [App\Http\Controllers\AssignmentController::class, 'gradeSpeakingPractice'])->name('assignments.ielts-academic.speaking.practice.grade');
    Route::get('/assignments/ielts-academic/speaking/practice/evaluation', [App\Http\Controllers\AssignmentController::class, 'showSpeakingEvaluation'])->name('assignments.ielts-academic.speaking.evaluation');
    Route::post('/assignments/ielts-academic/speaking/practice/upgrade-lexical', [App\Http\Controllers\AssignmentController::class, 'upgradeSpeakingLexical'])->name('assignments.ielts-academic.speaking.upgrade-lexical');
    Route::post('/assignments/ielts-academic/speaking/practice/collocations', [App\Http\Controllers\AssignmentController::class, 'suggestSpeakingCollocations'])->name('assignments.ielts-academic.speaking.collocations');
    
    // Speaking Topics CRUD
    Route::post('/admin/ielts-speaking/topics', [App\Http\Controllers\AssignmentController::class, 'storeSpeakingTopic'])->name('admin.ielts.speaking.topics.store');
    Route::put('/admin/ielts-speaking/topics/{id}', [App\Http\Controllers\AssignmentController::class, 'updateSpeakingTopic'])->name('admin.ielts.speaking.topics.update');
    Route::delete('/admin/ielts-speaking/topics/{id}', [App\Http\Controllers\AssignmentController::class, 'destroySpeakingTopic'])->name('admin.ielts.speaking.topics.delete');
    Route::post('/assignments/ielts-academic/speaking/practice/check-grammar', [App\Http\Controllers\AssignmentController::class, 'checkSpeakingGrammar'])->name('assignments.ielts-academic.speaking.check-grammar');
    Route::post('/assignments/ielts-academic/speaking/practice/upgrade-grammar', [App\Http\Controllers\AssignmentController::class, 'upgradeSpeakingGrammar'])->name('assignments.ielts-academic.speaking.upgrade-grammar');
    Route::post('/assignments/ielts-academic/speaking/practice/model-answer', [App\Http\Controllers\AssignmentController::class, 'generateBand9SpeakingAnswer'])->name('assignments.ielts-academic.speaking.model-answer');
    Route::post('/assignments/ielts-academic/speaking/practice/analyze-pronunciation', [App\Http\Controllers\AssignmentController::class, 'analyzeSpeakingPronunciation'])->name('assignments.ielts-academic.speaking.analyze-pronunciation');
    Route::post('/assignments/ielts-academic/speaking/practice/analyze-fluency', [App\Http\Controllers\AssignmentController::class, 'analyzeSpeakingFluency'])->name('assignments.ielts-academic.speaking.analyze-fluency');
    Route::get('/assignments/ielts-academic/mockup/speaking', [App\Http\Controllers\AssignmentController::class, 'ieltsSpeakingMockUp'])->name('assignments.ielts-academic.mockup.speaking');
    Route::get('/assignments/ielts-academic/mockup/speaking/{id}', function($id) {
        return app(\App\Http\Controllers\AssignmentController::class)->ieltsListeningMockUpTest($id, 'speaking');
    })->name('assignments.ielts-academic.mockup.speaking.test');
    
    // TOEFL ITP Mock Up Test Route
    Route::get('/assignments/toefl-itp', [App\Http\Controllers\AssignmentController::class, 'toeflItp'])->name('assignments.toefl-itp');
    Route::get('/assignments/toefl-itp/listening', [App\Http\Controllers\AssignmentController::class, 'listeningIndex'])->name('assignments.toefl-itp.listening');
    Route::get('/assignments/toefl-itp/listening/{number}', [App\Http\Controllers\AssignmentController::class, 'listeningMeeting'])->name('assignments.toefl-itp.listening.meeting');
    Route::post('/assignments/toefl-itp/listening/{number}/add-set', [App\Http\Controllers\AssignmentController::class, 'addListeningSet'])->name('assignments.toefl-itp.listening.meeting.add-set');
    Route::post('/assignments/toefl-itp/listening/{number}/remove-set', [App\Http\Controllers\AssignmentController::class, 'removeListeningSet'])->name('assignments.toefl-itp.listening.meeting.remove-set');
    Route::get('/assignments/toefl-itp/listening/{number}/practice/{set}', [App\Http\Controllers\AssignmentController::class, 'listeningMeetingPractice'])->name('assignments.toefl-itp.listening.meeting.practice');
    Route::post('/assignments/toefl-itp/listening/{number}/upload-srt', [App\Http\Controllers\AssignmentController::class, 'uploadListeningSrt'])->name('assignments.toefl-itp.listening.meeting.upload-srt');
    Route::post('/assignments/toefl-itp/listening/{number}/practice/{set}/upload-audio', [App\Http\Controllers\AssignmentController::class, 'uploadListeningAudio'])->name('assignments.toefl-itp.listening.meeting.upload-audio');
    Route::post('/assignments/toefl-itp/listening/{number}/practice/{set}/update-transcript', [App\Http\Controllers\AssignmentController::class, 'updateListeningTranscript'])->name('assignments.toefl-itp.listening.meeting.update-transcript');
    
    Route::post('/assignments/toefl-itp/listening/question', [App\Http\Controllers\AssignmentController::class, 'storeListeningQuestion'])->name('assignments.toefl-itp.listening.question.store');
    Route::put('/assignments/toefl-itp/listening/question/{id}', [App\Http\Controllers\AssignmentController::class, 'updateListeningQuestion'])->name('assignments.toefl-itp.listening.question.update');
    Route::delete('/assignments/toefl-itp/listening/question/{id}', [App\Http\Controllers\AssignmentController::class, 'deleteListeningQuestion'])->name('assignments.toefl-itp.listening.question.delete');
    
    Route::post('/assignments/toefl-itp/listening/{number}/submit', [App\Http\Controllers\AssignmentController::class, 'submitListeningMeeting'])->name('assignments.toefl-itp.listening.meeting.submit');
    Route::post('/assignments/toefl-itp/listening/{number}/toggle-lock', [App\Http\Controllers\AssignmentController::class, 'toggleListeningLock'])->name('assignments.toefl-itp.listening.toggle-lock');
    
    Route::get('/assignments/toefl-itp/structure', [App\Http\Controllers\AssignmentController::class, 'structureIndex'])->name('assignments.toefl-itp.structure');
    
    // Existing store route kept for backward compatibility if needed, but adding specific add-set route
    // Note: addStructureSet expects {number} parameter based on my earlier read
    Route::post('/assignments/toefl-itp/structure', [App\Http\Controllers\AssignmentController::class, 'addStructureSet'])->name('assignments.toefl-itp.structure.store'); 
    
    Route::post('/assignments/toefl-itp/structure/{number}/add-set', [App\Http\Controllers\AssignmentController::class, 'addStructureSet'])->name('assignments.toefl-itp.structure.meeting.add-set');
    Route::post('/assignments/toefl-itp/structure/{number}/remove-set', [App\Http\Controllers\AssignmentController::class, 'removeStructureSet'])->name('assignments.toefl-itp.structure.meeting.remove-set');
    Route::post('/assignments/toefl-itp/structure/{number}/submit', [App\Http\Controllers\AssignmentController::class, 'submitStructureMeeting'])->name('assignments.toefl-itp.structure.meeting.submit');
    
    Route::post('/assignments/toefl-itp/structure/reorder', [App\Http\Controllers\AssignmentController::class, 'reorderStructureMeetings'])->name('assignments.toefl-itp.structure.reorder');
    
    // Explicit Question Routes for Structure
    Route::post('/assignments/toefl-itp/structure/question', [App\Http\Controllers\AssignmentController::class, 'storeStructureQuestion'])->name('assignments.toefl-itp.structure.question.store');
    Route::put('/assignments/toefl-itp/structure/question/{id}', [App\Http\Controllers\AssignmentController::class, 'updateStructureQuestion'])->name('assignments.toefl-itp.structure.question.update');
    Route::delete('/assignments/toefl-itp/structure/question/{id}', [App\Http\Controllers\AssignmentController::class, 'deleteStructureQuestion'])->name('assignments.toefl-itp.structure.question.destroy');
    
    Route::get('/assignments/toefl-itp/structure/{number}', [App\Http\Controllers\AssignmentController::class, 'structureMeeting'])->name('assignments.toefl-itp.structure.meeting');
    Route::post('/assignments/toefl-itp/structure/{meeting}/toggle-lock', [App\Http\Controllers\AssignmentController::class, 'toggleStructureLock'])->name('assignments.toefl-itp.structure.toggle-lock');
    Route::post('/assignments/toefl-itp/structure/{meeting}/update', [App\Http\Controllers\AssignmentController::class, 'updateStructureMeeting'])->name('assignments.toefl-itp.structure.update');
    Route::post('/assignments/toefl-itp/structure/{meeting}/destroy', [App\Http\Controllers\AssignmentController::class, 'removeStructureSet'])->name('assignments.toefl-itp.structure.destroy');
    
    Route::get('/assignments/toefl-itp/reading', [App\Http\Controllers\AssignmentController::class, 'readingIndex'])->name('assignments.toefl-itp.reading');
    Route::post('/assignments/toefl-itp/reading', [App\Http\Controllers\AssignmentController::class, 'storeReadingMeeting'])->name('assignments.toefl-itp.reading.store');
    Route::post('/assignments/toefl-itp/reading/reorder', [App\Http\Controllers\AssignmentController::class, 'reorderReadingMeetings'])->name('assignments.toefl-itp.reading.reorder');
    Route::get('/assignments/toefl-itp/reading/{number}', [App\Http\Controllers\AssignmentController::class, 'readingMeeting'])->name('assignments.toefl-itp.reading.meeting');
    Route::post('/assignments/toefl-itp/reading/{meeting}/toggle-lock', [App\Http\Controllers\AssignmentController::class, 'toggleReadingLock'])->name('assignments.toefl-itp.reading.toggle-lock');
    Route::post('/assignments/toefl-itp/reading/{meeting}/update', [App\Http\Controllers\AssignmentController::class, 'updateReadingMeeting'])->name('assignments.toefl-itp.reading.update');
    Route::post('/assignments/toefl-itp/reading/{meeting}/destroy', [App\Http\Controllers\AssignmentController::class, 'destroyReadingMeeting'])->name('assignments.toefl-itp.reading.destroy');
    
    // Reading Passage & Question Routes
    Route::post('/assignments/toefl-itp/reading/passage', [App\Http\Controllers\AssignmentController::class, 'storeReadingPassage'])->name('assignments.toefl-itp.reading.passage.store');
    Route::post('/assignments/toefl-itp/reading/passage/{id}/update', [App\Http\Controllers\AssignmentController::class, 'updateReadingPassage'])->name('assignments.toefl-itp.reading.passage.update');
    Route::delete('/assignments/toefl-itp/reading/passage/{id}', [App\Http\Controllers\AssignmentController::class, 'destroyReadingPassage'])->name('assignments.toefl-itp.reading.passage.destroy');

    Route::post('/assignments/toefl-itp/reading/question', [App\Http\Controllers\AssignmentController::class, 'storeReadingQuestion'])->name('assignments.toefl-itp.reading.question.store');
    Route::post('/assignments/toefl-itp/reading/question/{id}/update', [App\Http\Controllers\AssignmentController::class, 'updateReadingQuestion'])->name('assignments.toefl-itp.reading.question.update');
    Route::post('/assignments/toefl-itp/reading/question/{id}/destroy', [App\Http\Controllers\AssignmentController::class, 'destroyReadingQuestion'])->name('assignments.toefl-itp.reading.question.destroy');
    Route::get('/assignments/toefl-itp/vocabulary', [App\Http\Controllers\AssignmentController::class, 'toeflItpVocabulary'])->name('assignments.toefl-itp.vocabulary');
    Route::get('/assignments/toefl-itp/mockup', [App\Http\Controllers\AssignmentController::class, 'toeflItpMockup'])->name('assignments.toefl-itp.mockup');
    
    Route::get('/assignments/grammar-writing', [App\Http\Controllers\AssignmentController::class, 'grammarWriting'])->name('assignments.grammar-writing');
    Route::post('/assignments/grammar-writing/period', [App\Http\Controllers\AssignmentController::class, 'updatePeriod'])->name('assignments.grammar-writing.period');
    Route::post('/assignments/meeting/{meeting}/toggle-lock', [App\Http\Controllers\AssignmentController::class, 'toggleLock'])->name('assignments.meeting.toggle-lock');
    Route::get('/assignments/grammar-writing/meeting1', [App\Http\Controllers\AssignmentController::class, 'meeting1'])->name('assignments.grammar-writing.meeting1');
    Route::post('/assignments/grammar-writing/meeting1', [App\Http\Controllers\AssignmentController::class, 'meeting1Submit'])->name('assignments.grammar-writing.meeting1.submit');
    Route::post('/assignments/grammar-writing/meeting1/reset', [App\Http\Controllers\AssignmentController::class, 'meeting1Reset'])->name('assignments.grammar-writing.meeting1.reset');
    Route::get('/assignments/grammar-writing/meeting2', [App\Http\Controllers\AssignmentController::class, 'meeting2'])->name('assignments.grammar-writing.meeting2');
    Route::post('/assignments/grammar-writing/meeting2', [App\Http\Controllers\AssignmentController::class, 'meeting2Submit'])->name('assignments.grammar-writing.meeting2.submit');
    Route::post('/assignments/grammar-writing/meeting2/reset', [App\Http\Controllers\AssignmentController::class, 'meeting2Reset'])->name('assignments.grammar-writing.meeting2.reset');
    Route::get('/assignments/grammar-writing/meeting3', [App\Http\Controllers\AssignmentController::class, 'meeting3'])->name('assignments.grammar-writing.meeting3');
    Route::post('/assignments/grammar-writing/meeting3', [App\Http\Controllers\AssignmentController::class, 'meeting3Submit'])->name('assignments.grammar-writing.meeting3.submit');
    Route::post('/assignments/grammar-writing/meeting3/reset', [App\Http\Controllers\AssignmentController::class, 'meeting3Reset'])->name('assignments.grammar-writing.meeting3.reset');
    Route::get('/assignments/grammar-writing/meeting4', [App\Http\Controllers\AssignmentController::class, 'meeting4'])->name('assignments.grammar-writing.meeting4');
    Route::post('/assignments/grammar-writing/meeting4', [App\Http\Controllers\AssignmentController::class, 'meeting4Submit'])->name('assignments.grammar-writing.meeting4.submit');
    Route::post('/assignments/grammar-writing/meeting4/reset', [App\Http\Controllers\AssignmentController::class, 'meeting4Reset'])->name('assignments.grammar-writing.meeting4.reset');
    Route::get('/assignments/grammar-writing/meeting5', [App\Http\Controllers\AssignmentController::class, 'meeting5'])->name('assignments.grammar-writing.meeting5');
    Route::post('/assignments/grammar-writing/meeting5', [App\Http\Controllers\AssignmentController::class, 'meeting5Submit'])->name('assignments.grammar-writing.meeting5.submit');
    Route::post('/assignments/grammar-writing/meeting5/reset', [App\Http\Controllers\AssignmentController::class, 'meeting5Reset'])->name('assignments.grammar-writing.meeting5.reset');
    Route::get('/assignments/grammar-writing/meeting6', [App\Http\Controllers\AssignmentController::class, 'meeting6'])->name('assignments.grammar-writing.meeting6');
    Route::post('/assignments/grammar-writing/meeting6', [App\Http\Controllers\AssignmentController::class, 'meeting6Submit'])->name('assignments.grammar-writing.meeting6.submit');
    Route::post('/assignments/grammar-writing/meeting6/reset', [App\Http\Controllers\AssignmentController::class, 'meeting6Reset'])->name('assignments.grammar-writing.meeting6.reset');
    Route::get('/assignments/grammar-writing/meeting7', [App\Http\Controllers\AssignmentController::class, 'meeting7'])->name('assignments.grammar-writing.meeting7');
    Route::post('/assignments/grammar-writing/meeting7', [App\Http\Controllers\AssignmentController::class, 'meeting7Submit'])->name('assignments.grammar-writing.meeting7.submit');
    Route::post('/assignments/grammar-writing/meeting7/reset', [App\Http\Controllers\AssignmentController::class, 'meeting7Reset'])->name('assignments.grammar-writing.meeting7.reset');
    Route::get('/assignments/grammar-writing/meeting8', [App\Http\Controllers\AssignmentController::class, 'meeting8'])->name('assignments.grammar-writing.meeting8');
    Route::post('/assignments/grammar-writing/meeting8', [App\Http\Controllers\AssignmentController::class, 'meeting8Submit'])->name('assignments.grammar-writing.meeting8.submit');
    Route::post('/assignments/grammar-writing/meeting8/reset', [App\Http\Controllers\AssignmentController::class, 'meeting8Reset'])->name('assignments.grammar-writing.meeting8.reset');
    
    // Meeting 19 Admin Routes
    Route::get('/admin/assignments/grammar-writing/meeting19/vocab/add', [App\Http\Controllers\AssignmentController::class, 'meeting19VocabAdd'])->name('admin.grammar.vocab.add');
    Route::post('/admin/assignments/grammar-writing/meeting19/vocab', [App\Http\Controllers\AssignmentController::class, 'meeting19VocabStore'])->name('admin.grammar.vocab.store');
    Route::get('/admin/assignments/grammar-writing/meeting19/vocab/{id}/edit', [App\Http\Controllers\AssignmentController::class, 'meeting19VocabEdit'])->name('admin.grammar.vocab.edit');
    Route::put('/admin/assignments/grammar-writing/meeting19/vocab/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting19VocabUpdate'])->name('admin.grammar.vocab.update');
    Route::delete('/admin/assignments/grammar-writing/meeting19/vocab/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting19VocabDestroy'])->name('admin.grammar.vocab.destroy');

    Route::get('/admin/assignments/grammar-writing/meeting19/questions/add', [App\Http\Controllers\AssignmentController::class, 'meeting19QuestionAdd'])->name('admin.grammar.question.add');
    Route::post('/admin/assignments/grammar-writing/meeting19/questions', [App\Http\Controllers\AssignmentController::class, 'meeting19QuestionStore'])->name('admin.grammar.question.store');
    Route::get('/admin/assignments/grammar-writing/meeting19/questions/{id}/edit', [App\Http\Controllers\AssignmentController::class, 'meeting19QuestionEdit'])->name('admin.grammar.question.edit');
     Route::put('/admin/assignments/grammar-writing/meeting19/questions/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting19QuestionUpdate'])->name('admin.grammar.question.update');
    Route::delete('/admin/assignments/grammar-writing/meeting19/questions/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting19QuestionDestroy'])->name('admin.grammar.question.destroy');

    Route::post('/admin/assignments/grammar-writing/meeting19/paragraph', [App\Http\Controllers\AssignmentController::class, 'meeting19ParagraphUpdate'])->name('admin.grammar.paragraph.update');

    // Meeting 20 Admin Routes
    Route::get('/admin/assignments/grammar-writing/meeting20/vocab/add', [App\Http\Controllers\AssignmentController::class, 'meeting20VocabAdd'])->name('admin.grammar.meeting20.vocab.add');
    Route::post('/admin/assignments/grammar-writing/meeting20/vocab', [App\Http\Controllers\AssignmentController::class, 'meeting20VocabStore'])->name('admin.grammar.meeting20.vocab.store');
    Route::get('/admin/assignments/grammar-writing/meeting20/vocab/{id}/edit', [App\Http\Controllers\AssignmentController::class, 'meeting20VocabEdit'])->name('admin.grammar.meeting20.vocab.edit');
    Route::put('/admin/assignments/grammar-writing/meeting20/vocab/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting20VocabUpdate'])->name('admin.grammar.meeting20.vocab.update');
    Route::delete('/admin/assignments/grammar-writing/meeting20/vocab/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting20VocabDestroy'])->name('admin.grammar.meeting20.vocab.destroy');

    Route::get('/admin/assignments/grammar-writing/meeting20/questions/add', [App\Http\Controllers\AssignmentController::class, 'meeting20QuestionAdd'])->name('admin.grammar.meeting20.question.add');
    Route::post('/admin/assignments/grammar-writing/meeting20/questions', [App\Http\Controllers\AssignmentController::class, 'meeting20QuestionStore'])->name('admin.grammar.meeting20.question.store');
    Route::get('/admin/assignments/grammar-writing/meeting20/questions/{id}/edit', [App\Http\Controllers\AssignmentController::class, 'meeting20QuestionEdit'])->name('admin.grammar.meeting20.question.edit');
    Route::put('/admin/assignments/grammar-writing/meeting20/questions/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting20QuestionUpdate'])->name('admin.grammar.meeting20.question.update');
    Route::delete('/admin/assignments/grammar-writing/meeting20/questions/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting20QuestionDestroy'])->name('admin.grammar.meeting20.question.destroy');

    Route::post('/admin/assignments/grammar-writing/meeting20/paragraph', [App\Http\Controllers\AssignmentController::class, 'meeting20ParagraphUpdate'])->name('admin.grammar.meeting20.paragraph.update');


    Route::get('/assignments/grammar-writing/meeting18', [App\Http\Controllers\AssignmentController::class, 'meeting18'])->name('assignments.grammar-writing.meeting18');
    Route::post('/assignments/grammar-writing/meeting18', [App\Http\Controllers\AssignmentController::class, 'meeting18Submit'])->name('assignments.grammar-writing.meeting18.submit');
    Route::post('/assignments/grammar-writing/meeting18/reset', [App\Http\Controllers\AssignmentController::class, 'meeting18Reset'])->name('assignments.grammar-writing.meeting18.reset');
    Route::get('/assignments/grammar-writing/meeting19', [App\Http\Controllers\AssignmentController::class, 'meeting19'])->name('assignments.grammar-writing.meeting19');
    Route::post('/assignments/grammar-writing/meeting19', [App\Http\Controllers\AssignmentController::class, 'meeting19Submit'])->name('assignments.grammar-writing.meeting19.submit');
    Route::post('/assignments/grammar-writing/meeting19/reset', [App\Http\Controllers\AssignmentController::class, 'meeting19Reset'])->name('assignments.grammar-writing.meeting19.reset');
    
    Route::get('/assignments/grammar-writing/meeting20', [App\Http\Controllers\AssignmentController::class, 'meeting20'])->name('assignments.grammar-writing.meeting20');
     Route::post('/assignments/grammar-writing/meeting20', [App\Http\Controllers\AssignmentController::class, 'meeting20Submit'])->name('assignments.grammar-writing.meeting20.submit');
    Route::post('/assignments/grammar-writing/meeting20/reset', [App\Http\Controllers\AssignmentController::class, 'meeting20Reset'])->name('assignments.grammar-writing.meeting20.reset');


    // Meeting 8 Admin Routes (CRUD) - Now using Database
    Route::get('/admin/assignments/grammar-writing/meeting8/questions/add', [App\Http\Controllers\AssignmentController::class, 'meeting8QuestionAdd'])->name('admin.grammar.meeting8.question.add');
    Route::post('/admin/assignments/grammar-writing/meeting8/questions', [App\Http\Controllers\AssignmentController::class, 'meeting8QuestionStore'])->name('admin.grammar.meeting8.question.store');
    Route::get('/admin/assignments/grammar-writing/meeting8/questions/{id}/edit', [App\Http\Controllers\AssignmentController::class, 'meeting8QuestionEdit'])->name('admin.grammar.meeting8.question.edit');
    Route::put('/admin/assignments/grammar-writing/meeting8/questions/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting8QuestionUpdate'])->name('admin.grammar.meeting8.question.update');
    Route::delete('/admin/assignments/grammar-writing/meeting8/questions/{id}', [App\Http\Controllers\AssignmentController::class, 'meeting8QuestionDestroy'])->name('admin.grammar.meeting8.question.destroy');
    Route::post('/admin/assignments/grammar-writing/meeting8/paragraph', [App\Http\Controllers\AssignmentController::class, 'meeting8ParagraphUpdate'])->name('admin.grammar.meeting8.paragraph.update');

    // Admin Users Management
    Route::post('/admin/users/bulk-assign-teacher', [App\Http\Controllers\Admin\UserController::class, 'bulkAssignTeacher'])->name('admin.users.bulk_assign_teacher')->middleware('role:admin');
    Route::post('/admin/users/bulk-assign-program', [App\Http\Controllers\Admin\UserController::class, 'bulkAssignProgram'])->name('admin.users.bulk_assign_program')->middleware('role:admin');
    Route::post('/admin/users/{user}/convert', [App\Http\Controllers\Admin\UserController::class, 'convertGuest'])->name('users.convertGuest')->middleware('role:admin');
    Route::post('/admin/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status')->middleware('role:admin');
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class)->names('users')->middleware('role:admin');
    
    // Admin Teachers Management
    Route::post('/admin/teachers/assign-student', [App\Http\Controllers\TeacherController::class, 'assignStudent'])->name('admin.teachers.assign_student')->middleware('role:admin');
    Route::post('/admin/teachers/assign-class', [App\Http\Controllers\TeacherController::class, 'assignClass'])->name('admin.teachers.assign_class')->middleware('role:admin');
    Route::resource('admin/teachers', App\Http\Controllers\TeacherController::class)->names('teachers')->middleware('role:admin');

    // Admin Students Management
    Route::post('/admin/students/{student}/assign-teacher', [App\Http\Controllers\Admin\StudentController::class, 'assignTeacher'])->name('admin.students.assign_teacher')->middleware('role:admin');
    Route::post('/admin/students/{student}/quick-update', [App\Http\Controllers\Admin\StudentController::class, 'quickUpdate'])->name('admin.students.quick_update')->middleware('role:admin');
    Route::post('/admin/students/bulk-generate-referral-codes', [App\Http\Controllers\Admin\StudentController::class, 'bulkGenerateReferralCodes'])->name('admin.students.bulk_generate_referral')->middleware('role:admin');
    Route::resource('admin/students', App\Http\Controllers\Admin\StudentController::class)->names('students')->middleware('role:admin');

    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard')->middleware('role:admin');
    
    // Admin Class Periods Management
    Route::post('/admin/class-periods/{classPeriod}/status', [App\Http\Controllers\Admin\ClassPeriodController::class, 'updateStatus'])->name('class-periods.status');
    Route::post('/admin/class-periods/{classPeriod}/assign-student', [App\Http\Controllers\Admin\ClassPeriodController::class, 'assignStudent'])->name('class-periods.assign-student');
    Route::delete('/admin/class-periods/{classPeriod}/remove-student/{user}', [App\Http\Controllers\Admin\ClassPeriodController::class, 'removeStudent'])->name('class-periods.remove-student');
    Route::post('/admin/class-periods/{classPeriod}/toggle-meeting/{meeting}', [App\Http\Controllers\Admin\ClassPeriodController::class, 'toggleMeeting'])->name('class-periods.toggle-meeting');
    Route::resource('admin/class-periods', App\Http\Controllers\Admin\ClassPeriodController::class)->names('class-periods')->middleware('role:admin');
    
    // Admin Impersonation Routes
    Route::get('/admin/impersonate/{role}', [App\Http\Controllers\AdminController::class, 'impersonate'])->name('admin.impersonate');
    Route::get('/admin/impersonate-stop', [App\Http\Controllers\AdminController::class, 'stopImpersonate'])->name('admin.impersonate.stop'); // no middleware so impersonated users can return
    
    // Admin Remote View
    Route::get('/admin/remote-view/{user}', [App\Http\Controllers\RemoteViewController::class, 'adminView'])->name('admin.remote-view');
    
    // Teacher Dashboard
    Route::get('/teacher/dashboard', [App\Http\Controllers\TeacherDashboardController::class, 'index'])->name('teacher.dashboard')->middleware('role:teacher');
    
    // Teacher Evaluations
    Route::get('/teacher/evaluations', [App\Http\Controllers\Teacher\EvaluationController::class, 'index'])->name('teacher.evaluations.index')->middleware('role:teacher');
    
    // Teacher Attendance
    Route::get('/teacher/attendance', [App\Http\Controllers\TeacherAttendanceController::class, 'index'])->name('teacher.attendance.index')->middleware('role:teacher');
    Route::get('/teacher/attendance/meetings/{classPeriod}', [App\Http\Controllers\TeacherAttendanceController::class, 'getMeetings'])->name('teacher.attendance.meetings')->middleware('role:teacher');
    Route::get('/teacher/attendance/records/{classMeeting}', [App\Http\Controllers\TeacherAttendanceController::class, 'getAttendance'])->name('teacher.attendance.records')->middleware('role:teacher');
    Route::post('/teacher/attendance/store', [App\Http\Controllers\TeacherAttendanceController::class, 'store'])->name('teacher.attendance.store')->middleware('role:teacher');
    
    // Teacher Remote View
    Route::get('/teacher/remote-view/{user}', [App\Http\Controllers\RemoteViewController::class, 'teacherView'])->name('teacher.remote-view')->middleware('role:teacher');
    Route::post('/remote-view/request-screen', [App\Http\Controllers\RemoteViewController::class, 'requestScreen'])->name('remote-view.request-screen');
    Route::get('/remote-view/pending-request', [App\Http\Controllers\RemoteViewController::class, 'pendingRequest'])->name('remote-view.pending-request');
    Route::post('/remote-view/pending-request/ack', [App\Http\Controllers\RemoteViewController::class, 'acknowledgePendingRequest'])->name('remote-view.pending-request.ack');
    
    // Admin Programs Management
    Route::resource('admin/programs', App\Http\Controllers\Admin\ProgramController::class)->names('programs')->middleware('role:admin');
    
    // Admin Programs Syllabus Management
    Route::get('admin/programs/{program}/syllabus', [App\Http\Controllers\Admin\ProgramController::class, 'syllabus'])->name('programs.syllabus')->middleware('role:admin');
    Route::post('admin/programs/{program}/syllabus/reorder', [App\Http\Controllers\Admin\ProgramController::class, 'reorderSyllabus'])->name('programs.syllabus.reorder')->middleware('role:admin');
    Route::post('admin/programs/{program}/syllabus', [App\Http\Controllers\Admin\ProgramController::class, 'storeSyllabus'])->name('programs.syllabus.store')->middleware('role:admin');
    Route::put('admin/programs/{program}/syllabus/{meeting}', [App\Http\Controllers\Admin\ProgramController::class, 'updateSyllabus'])->name('programs.syllabus.update')->middleware('role:admin');
    Route::delete('admin/programs/{program}/syllabus/{meeting}', [App\Http\Controllers\Admin\ProgramController::class, 'destroySyllabus'])->name('programs.syllabus.destroy')->middleware('role:admin');

    // Admin Programs Discount Management
    Route::get('admin/programs/{program}/discounts', [App\Http\Controllers\Admin\ProgramDiscountController::class, 'index'])->name('programs.discounts.index')->middleware('role:admin');
    Route::post('admin/programs/{program}/discounts', [App\Http\Controllers\Admin\ProgramDiscountController::class, 'store'])->name('programs.discounts.store')->middleware('role:admin');
    Route::put('admin/programs/{program}/discounts/{discount}', [App\Http\Controllers\Admin\ProgramDiscountController::class, 'update'])->name('programs.discounts.update')->middleware('role:admin');
    Route::delete('admin/programs/{program}/discounts/{discount}', [App\Http\Controllers\Admin\ProgramDiscountController::class, 'destroy'])->name('programs.discounts.destroy')->middleware('role:admin');

    // Admin Programs Brochure Management
    Route::get('admin/programs/{program}/brochure', [App\Http\Controllers\Admin\ProgramController::class, 'brochure'])->name('programs.brochure')->middleware('role:admin');
    Route::post('admin/programs/{program}/brochure', [App\Http\Controllers\Admin\ProgramController::class, 'updateBrochure'])->name('programs.brochure.update')->middleware('role:admin');

    Route::get('/admin/scores', [App\Http\Controllers\ScoreController::class, 'index'])->name('admin.scores.index')->middleware('role:admin');
    
    // Attendance
    Route::get('/admin/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.attendance.index')->middleware('role:admin');
    Route::get('/admin/attendance/meetings/{classPeriod}', [App\Http\Controllers\Admin\AttendanceController::class, 'getMeetings'])->name('admin.attendance.meetings')->middleware('role:admin');
    Route::get('/admin/attendance/records/{classMeeting}', [App\Http\Controllers\Admin\AttendanceController::class, 'getAttendance'])->name('admin.attendance.records')->middleware('role:admin');
    Route::post('/admin/attendance/store', [App\Http\Controllers\Admin\AttendanceController::class, 'store'])->name('admin.attendance.store')->middleware('role:admin');
    
    // Reports
    Route::get('/admin/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index')->middleware('role:admin');
    
    // Teacher Evaluations (Admin)
    Route::get('/admin/teacher-evaluations', [App\Http\Controllers\Admin\TeacherEvaluationController::class, 'index'])->name('admin.evaluations.index')->middleware('role:admin');
    
    // Announcements (Admin)
    Route::get('admin/announcements', [App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('admin.announcements.index')->middleware('role:admin');
    Route::get('admin/announcements/create', [App\Http\Controllers\Admin\AnnouncementController::class, 'create'])->name('admin.announcements.create')->middleware('role:admin');
    Route::post('admin/announcements', [App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('admin.announcements.store')->middleware('role:admin');
    Route::get('admin/announcements/{announcement}/edit', [App\Http\Controllers\Admin\AnnouncementController::class, 'edit'])->name('admin.announcements.edit')->middleware('role:admin');
    Route::put('admin/announcements/{announcement}', [App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('admin.announcements.update')->middleware('role:admin');
    Route::delete('admin/announcements/{announcement}', [App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy')->middleware('role:admin');
    
    // Broadcast Messages (Admin)
    Route::resource('admin/broadcast-messages', App\Http\Controllers\Admin\BroadcastMessageController::class)
         ->names('admin.broadcast-messages')
         ->middleware('role:admin')
         ->except(['edit', 'update', 'destroy']);
    
    // Outreach Messages (Admin)
    Route::get('admin/outreach-messages', [App\Http\Controllers\Admin\OutreachMessageController::class, 'index'])->name('admin.outreach-messages.index')->middleware('role:admin');
    Route::get('admin/outreach-messages/create', [App\Http\Controllers\Admin\OutreachMessageController::class, 'create'])->name('admin.outreach-messages.create')->middleware('role:admin');
    Route::post('admin/outreach-messages', [App\Http\Controllers\Admin\OutreachMessageController::class, 'store'])->name('admin.outreach-messages.store')->middleware('role:admin');
    Route::get('admin/outreach-messages/{outreachMessage}/edit', [App\Http\Controllers\Admin\OutreachMessageController::class, 'edit'])->name('admin.outreach-messages.edit')->middleware('role:admin');
    Route::put('admin/outreach-messages/{outreachMessage}', [App\Http\Controllers\Admin\OutreachMessageController::class, 'update'])->name('admin.outreach-messages.update')->middleware('role:admin');
    Route::delete('admin/outreach-messages/{outreachMessage}', [App\Http\Controllers\Admin\OutreachMessageController::class, 'destroy'])->name('admin.outreach-messages.destroy')->middleware('role:admin');
    
    // Admin Referral Management
    Route::get('/admin/referrals', [App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('admin.referrals.index')->middleware('role:admin');
    Route::put('/admin/referrals/claims/{id}', [App\Http\Controllers\Admin\ReferralController::class, 'updateClaim'])->name('admin.referrals.claims.update')->middleware('role:admin');
    Route::post('/admin/referrals/rewards', [App\Http\Controllers\Admin\ReferralController::class, 'storeReward'])->name('admin.referrals.rewards.store')->middleware('role:admin');
    Route::put('/admin/referrals/social/{id}', [App\Http\Controllers\Admin\ReferralController::class, 'updateSocialMedia'])->name('admin.referrals.social.update')->middleware('role:admin');
    
    // Admin Free Test Certificates
    Route::get('/admin/free-test-certificates', [App\Http\Controllers\Admin\FreeTestCertificateController::class, 'index'])->name('admin.free-tests.certificates.index')->middleware('role:admin');
    Route::put('/admin/free-test-certificates/{id}', [App\Http\Controllers\Admin\FreeTestCertificateController::class, 'update'])->name('admin.free-tests.certificates.update')->middleware('role:admin');
    
    // System Settings
    Route::get('/admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index')->middleware('role:admin');
    Route::post('/admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update')->middleware('role:admin');

    // Admin Scholarship Management
    Route::resource('admin/scholarships', App\Http\Controllers\Admin\ScholarshipController::class)->names('admin.scholarships')->middleware('role:admin');
    Route::get('admin/scholarships-import', [App\Http\Controllers\Admin\ScholarshipController::class, 'importForm'])->name('admin.scholarships.import.form')->middleware('role:admin');
    Route::post('admin/scholarships-import', [App\Http\Controllers\Admin\ScholarshipController::class, 'importProcess'])->name('admin.scholarships.import.process')->middleware('role:admin');
    Route::get('admin/scholarships/{scholarship}/match', [App\Http\Controllers\Admin\ScholarshipController::class, 'smartMatch'])->name('admin.scholarships.match')->middleware('role:admin');

    // Admin Scholarship News Management
    Route::resource('admin/scholarship-news', App\Http\Controllers\Admin\ScholarshipNewsController::class)->names('admin.scholarship-news')->middleware('role:admin');

    // Admin Job Vacancies Management
    Route::resource('admin/job-vacancies', App\Http\Controllers\Admin\JobVacancyController::class)->names('admin.job-vacancies')->middleware('role:admin');
});

// 2-Way Messaging & Inbox
Route::middleware(['auth'])->group(function () {
    Route::get('/inbox', [App\Http\Controllers\InboxController::class, 'index'])->name('inbox.index');
    Route::post('/inbox', [App\Http\Controllers\InboxController::class, 'store'])->name('inbox.store');
    Route::post('/inbox/{id}/read', [App\Http\Controllers\InboxController::class, 'markAsRead'])->name('inbox.read');
});

// OTP Routes for Registration
Route::post('/otp/send', [App\Http\Controllers\Auth\OtpController::class, 'send'])->name('otp.send');
Route::post('/otp/verify', [App\Http\Controllers\Auth\OtpController::class, 'verify'])->name('otp.verify');

require __DIR__.'/auth.php';

require __DIR__.'/seed_writing.php';

require __DIR__.'/seed_writing_lesson2.php';

require __DIR__.'/seed_writing_lesson3.php';




