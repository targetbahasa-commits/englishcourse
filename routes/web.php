<?php

use Illuminate\Support\Facades\Route;

Route::get('/guest/quick-access/{testType}', [App\Http\Controllers\GuestQuickAccessController::class, 'quickAccess'])->name('guest.quick-access');
Route::get('/guest/dashboard', [App\Http\Controllers\GuestController::class, 'dashboard'])->name('guest.dashboard');
Route::get('/guest/register', [App\Http\Controllers\GuestController::class, 'showRegisterForm'])->name('guest.register');
Route::post('/guest/register', [App\Http\Controllers\GuestController::class, 'register'])->name('guest.register.submit');

// Cambridge Test Registration (Guest)
Route::get('/test-daftar', [App\Http\Controllers\GuestCambridgeTestController::class, 'showRegisterForm'])->name('guest.cambridge-test-register');
Route::post('/test-daftar', [App\Http\Controllers\GuestCambridgeTestController::class, 'register'])->name('guest.cambridge-test-register.submit');

// Smart redirect for "Register for this Test" buttons on mock test pages:
// - guest_quick (temporary session): logout first, then → student registration with payment flow
// - guest (has real account): → directly to payments page
Route::get('/mock-test/register-or-pay', function (\Illuminate\Http\Request $request) {
    $program = $request->query('program', 'ielts-academic');
    $registerUrl = route('student.register') . '?' . http_build_query(['program' => $program]);

    if (auth()->check() && auth()->user()->active_role === 'guest_quick') {
        // Logout the temporary guest_quick session so student.register (guest middleware) works
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect($registerUrl);
    }

    if (auth()->check() && in_array(auth()->user()->role, ['guest', 'student'])) {
        return redirect()->route('student.payments.index');
    }

    // Not logged in → go to student register
    return redirect($registerUrl);
})->name('mock-test.register-or-pay');

Route::get('/student/register-entry', function (\Illuminate\Http\Request $request) {
    $query = $request->query();
    $registerUrl = route('student.register');

    if (!empty($query)) {
        $registerUrl .= '?' . http_build_query($query);
    }

    if (auth()->check() && in_array(auth()->user()->active_role, ['guest', 'guest_quick'], true)) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($registerUrl);
    }

    if (auth()->check() && auth()->user()->active_role === 'student') {
        return redirect()->route('student.payments.index');
    }

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect($registerUrl);
})->name('student.register.entry');




// Program Access Key Submission
Route::post('/assignments/program-access/{program}', [App\Http\Controllers\AssignmentController::class, 'submitProgramAccessKey'])->name('assignments.program-access.submit')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-reading-test', function() {
    return view('assignments.ielts.mockup.c20-reading-test-4', ['testId' => 4, 'edition' => 20]);
});

// Cleanup Route (Temporary - Public) - Removed
// Route::get('/cleanup-ielts-reading', [App\Http\Controllers\AssignmentController::class, 'cleanupIeltsReading']);

// Guest Portal (Free Tests & Lessons)
Route::get('/free-tests', [App\Http\Controllers\GuestController::class, 'index'])->name('guest.free-tests');

Route::get('/guest/my-english', [App\Http\Controllers\GuestController::class, 'myEnglish'])->name('guest.my-english');

// Public Scholarship Search Routes
Route::get('/scholarships-search', [App\Http\Controllers\ScholarshipSearchController::class, 'index'])->name('scholarships.search.index');
Route::get('/scholarships-search/{scholarship}', [App\Http\Controllers\ScholarshipSearchController::class, 'show'])->name('scholarships.search.show')->whereNumber('scholarship');

// Overseas Job Vacancies Public Routes
Route::get('/overseas-jobs', [App\Http\Controllers\JobVacancySearchController::class, 'index'])->name('overseas-jobs.index');
Route::get('/overseas-jobs/{jobVacancy}', [App\Http\Controllers\JobVacancySearchController::class, 'show'])->name('overseas-jobs.show')->whereNumber('jobVacancy');

// Working Holiday Visa (WHV) Applications Public Routes
Route::get('/whv-australia', [App\Http\Controllers\WHVApplicationController::class, 'index'])->name('whv-applications.index');
// Legacy detail URLs are redirected back to the dedicated WHV landing page.
Route::get('/whv-australia/{whvApplication}', [App\Http\Controllers\WHVApplicationController::class, 'show'])->name('whv-applications.show')->whereNumber('whvApplication');

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

// Cambridge Mockup Test - Publicly accessible (unauthenticated users see sign-up popup)
Route::get('/assignments/ielts-academic/mockup/cambridge', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'index'])->name('assignments.ielts-academic.mockup.cambridge');
Route::get('/assignments/ielts-academic/mockup/cambridge/{edition}', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'edition'])->name('assignments.ielts-academic.mockup.cambridge.edition');
Route::get('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'skills'])->name('assignments.ielts-academic.mockup.cambridge.skills');
Route::get('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/{skill}', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'test'])->name('assignments.ielts-academic.mockup.cambridge.test');

Route::get('/assignments/ielts-academic/mockup/british-council', function () {
    return view('assignments.ielts.mockup.british-council');
})->name('assignments.ielts-academic.mockup.british-council');

Route::get('/assignments/ielts-academic/mockup/british-council/test-{id}', function ($id) {
    return view('assignments.ielts.mockup.british-council-skills', ['testId' => $id]);
})->name('assignments.ielts-academic.mockup.british-council.skills');

// Guest sign-up via Cambridge test modal (public POST)
Route::post('/cambridge/guest-register', [App\Http\Controllers\CambridgeGuestSignupController::class, 'register'])->name('cambridge.guest.register');

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

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Sprint 5: My Progress
    Route::get('/my-progress', [App\Http\Controllers\ProgressController::class, 'index'])
        ->name('student.progress')
        ->middleware('role:student');

    // Sprint 6: Schedule
    Route::get('/schedule', [App\Http\Controllers\ScheduleController::class, 'index'])->name('student.schedule');

    // Referral System
    Route::get('/referrals', [App\Http\Controllers\ReferralController::class, 'index'])->name('student.referrals.index');
    Route::post('/referrals/claim', [App\Http\Controllers\ReferralController::class, 'claim'])->name('student.referrals.claim');
    Route::post('/referrals/social-submit', [App\Http\Controllers\ReferralController::class, 'submitSocialMedia'])->name('student.referrals.social.submit');

    // Student Payments
    Route::get('/student/payments', [App\Http\Controllers\PaymentController::class, 'studentIndex'])
        ->name('student.payments.index')
        ->middleware('role:student');
    Route::post('/student/payments/initiate', [App\Http\Controllers\PaymentController::class, 'initiate'])
        ->name('student.payments.initiate')
        ->middleware('role:student');
    Route::get('/student/payments/{payment}', [App\Http\Controllers\PaymentController::class, 'studentShow'])
        ->name('student.payments.show')
        ->middleware('role:student');
    Route::post('/student/payments/{payment}/proof', [App\Http\Controllers\PaymentController::class, 'uploadProof'])
        ->name('student.payments.upload-proof')
        ->middleware('role:student');



    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student Evaluation Routes (student only)
    Route::get('/evaluate-teacher', [App\Http\Controllers\Student\TeacherEvaluationController::class, 'create'])
        ->name('student.evaluations.create')
        ->middleware('role:student');
    Route::post('/evaluate-teacher', [App\Http\Controllers\Student\TeacherEvaluationController::class, 'store'])
        ->name('student.evaluations.store')
        ->middleware('role:student');
});

Route::middleware(['auth'])->group(function () {
    // Scholarships Routes
    Route::get('/scholarships', [App\Http\Controllers\ScholarshipController::class, 'index'])->name('scholarships.index');
    Route::get('/scholarships/{scholarship}', [App\Http\Controllers\ScholarshipController::class, 'show'])->name('scholarships.show');

    Route::get('/assignments', [App\Http\Controllers\AssignmentController::class, 'index'])
        ->name('assignments.index')
        ->middleware('check.assignment.program.access');
    // Cleanup Route (Temporary) - Outside this block in next step or just accessed via browser tool logged in?
    // Actually, I'll just remove it from here and put it at the top of the file in a separate replace call if needed, 
    // but the tool allows me to just replace this block.
    // Let's just remove it from here and add it at line 5.
    
    Route::get('/ielts/academic', [App\Http\Controllers\AssignmentController::class, 'ieltsAcademic'])
        ->name('assignments.ielts-academic')
        ->middleware('check.assignment.program.access');
    Route::get('/assignments/pte-academic', [App\Http\Controllers\AssignmentController::class, 'pteAcademic'])
        ->name('assignments.pte-academic')
        ->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing', function () {
        return view('assignments.pte-academic.speaking-writing');
    })->name('assignments.pte-academic.speaking-writing.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/personal-introduction', function () {
        return view('assignments.pte-academic.personal-introduction.practice');
    })->name('assignments.pte-academic.speaking-writing.personal-introduction.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/read-aloud', function () {
        $topics = [];
        $hardcoded = config('pte_read_aloud', []);

        for ($i = 1; $i <= 350; $i++) {
            if (isset($hardcoded[$i])) {
                $topics[$i] = $hardcoded[$i];
            } else {
                $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT), 'content' => 'Content for topic ' . $i . ' will be added soon.'];
            }
        }

        return view('assignments.pte-academic.read-aloud.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.read-aloud.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/read-aloud/{id}', function ($id) {
        $hardcoded = config('pte_read_aloud', []);
        $topic = isset($hardcoded[$id]) ? $hardcoded[$id] : ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT), 'content' => 'Content for topic ' . $id . ' will be added soon.'];

        return view('assignments.pte-academic.read-aloud.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.read-aloud.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/repeat-sentence', function () {
        $topics = [];
        $hardcoded = config('pte_repeat_sentence', []);

        for ($i = 1; $i <= 300; $i++) {
            if (isset($hardcoded[$i])) {
                $topics[$i] = $hardcoded[$i];
            } else {
                $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT), 'content' => 'Please repeat this sentence carefully and clearly for topic number ' . $i . '.'];
            }
        }

        return view('assignments.pte-academic.repeat-sentence.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.repeat-sentence.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/repeat-sentence/{id}', function ($id) {
        $hardcoded = config('pte_repeat_sentence', []);
        $topic = isset($hardcoded[$id]) ? $hardcoded[$id] : ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT), 'content' => 'Please repeat this sentence carefully and clearly for topic number ' . $id . '.'];

        return view('assignments.pte-academic.repeat-sentence.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.repeat-sentence.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/describe-image', function () {
        $topics = [];
        $hardcoded = config('pte_describe_image', []);

        for ($i = 1; $i <= 50; $i++) {
            if (isset($hardcoded[$i])) {
                $topics[$i] = $hardcoded[$i];
            } else {
                $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT), 'content' => 'Please describe the image shown below for topic number ' . $i . '.'];
            }
        }

        return view('assignments.pte-academic.describe-image.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.describe-image.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/describe-image/{id}', function ($id) {
        $hardcoded = config('pte_describe_image', []);
        $topic = isset($hardcoded[$id]) ? $hardcoded[$id] : ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT), 'content' => 'Please describe the image shown below for topic number ' . $id . '.'];

        return view('assignments.pte-academic.describe-image.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.describe-image.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/retell-lecture', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.retell-lecture.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.retell-lecture.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/retell-lecture/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.retell-lecture.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.retell-lecture.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/answer-short-question', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.answer-short-question.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.answer-short-question.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/answer-short-question/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.answer-short-question.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.answer-short-question.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/summarize-written-text', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.summarize-written-text.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.summarize-written-text.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/summarize-written-text/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.summarize-written-text.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.summarize-written-text.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/write-essay', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.write-essay.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.write-essay.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/speaking-writing/write-essay/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.write-essay.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.write-essay.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading', function () {
        return view('assignments.pte-academic.reading');
    })->name('assignments.pte-academic.reading.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/reading-writing-fill-blanks', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.reading-writing-fill-blanks.index', compact('topics'));
    })->name('assignments.pte-academic.reading.reading-writing-fill-blanks.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/reading-writing-fill-blanks/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.reading-writing-fill-blanks.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.reading-writing-fill-blanks.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/multiple-choice-multiple-answer', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.multiple-choice-multiple-answer.index', compact('topics'));
    })->name('assignments.pte-academic.reading.multiple-choice-multiple-answer.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/multiple-choice-multiple-answer/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.multiple-choice-multiple-answer.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.multiple-choice-multiple-answer.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/reorder-paragraphs', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.reorder-paragraphs.index', compact('topics'));
    })->name('assignments.pte-academic.reading.reorder-paragraphs.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/reorder-paragraphs/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.reorder-paragraphs.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.reorder-paragraphs.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/reading-fill-blanks', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.reading-fill-blanks.index', compact('topics'));
    })->name('assignments.pte-academic.reading.reading-fill-blanks.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/reading-fill-blanks/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.reading-fill-blanks.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.reading-fill-blanks.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/multiple-choice-single-answer', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.multiple-choice-single-answer.index', compact('topics'));
    })->name('assignments.pte-academic.reading.multiple-choice-single-answer.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/multiple-choice-single-answer/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.multiple-choice-single-answer.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.multiple-choice-single-answer.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening', function () {
        return view('assignments.pte-academic.listening');
    })->name('assignments.pte-academic.listening.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/summarize-spoken-text', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.summarize-spoken-text.index', compact('topics'));
    })->name('assignments.pte-academic.listening.summarize-spoken-text.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/summarize-spoken-text/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.summarize-spoken-text.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.summarize-spoken-text.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-multiple-choice-multiple-answer', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-multiple-choice-multiple-answer.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-multiple-choice-multiple-answer.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-multiple-choice-multiple-answer/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.listening-multiple-choice-multiple-answer.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-multiple-choice-multiple-answer.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-fill-blanks', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-fill-blanks.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-fill-blanks.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-fill-blanks/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.listening-fill-blanks.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-fill-blanks.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-highlight-correct-summary', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-highlight-correct-summary.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-highlight-correct-summary.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-highlight-correct-summary/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.listening-highlight-correct-summary.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-highlight-correct-summary.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-multiple-choice-single-answer', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-multiple-choice-single-answer.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-multiple-choice-single-answer.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-multiple-choice-single-answer/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.listening-multiple-choice-single-answer.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-multiple-choice-single-answer.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-select-missing-word', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-select-missing-word.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-select-missing-word.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-select-missing-word/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.listening-select-missing-word.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-select-missing-word.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-highlight-incorrect-words', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-highlight-incorrect-words.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-highlight-incorrect-words.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-highlight-incorrect-words/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.listening-highlight-incorrect-words.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-highlight-incorrect-words.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-write-from-dictation', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-write-from-dictation.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-write-from-dictation.index')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-write-from-dictation/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.listening-write-from-dictation.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-write-from-dictation.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/ielts-general', [App\Http\Controllers\AssignmentController::class, 'ieltsGeneral'])
        ->name('assignments.ielts-general')
        ->middleware('check.assignment.program.access');

    // IELTS Academic Listening Routes
    Route::get('/assignments/ielts-academic/listening', [App\Http\Controllers\IeltsListeningController::class, 'index'])
        ->name('assignments.ielts-academic.listening.index')
        ->middleware('check.assignment.program.access');
    Route::get('/assignments/ielts-academic/listening/material/{id}', [App\Http\Controllers\IeltsListeningController::class, 'material'])
        ->name('assignments.ielts-academic.listening.material')
        ->middleware('check.assignment.program.access');
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-audio', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadMaterialAudio'])
        ->name('assignments.ielts-academic.listening.material.upload-audio')
        ->middleware('check.assignment.program.access');
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-srt', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadMaterialSrt'])
        ->name('assignments.ielts-academic.listening.material.upload-srt')
        ->middleware('check.assignment.program.access');
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-answer-key', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadMaterialAnswerKey'])
        ->name('assignments.ielts-academic.listening.material.upload-answer-key')
        ->middleware('check.assignment.program.access');
    Route::get('/assignments/ielts-academic/listening/practice-index', [App\Http\Controllers\IeltsListeningController::class, 'practiceIndex'])
        ->name('assignments.ielts-academic.listening.practice.index')
        ->middleware('check.assignment.program.access');
    Route::get('/assignments/ielts-academic/listening/practice-index/part{set}', [App\Http\Controllers\IeltsListeningController::class, 'practiceIndexPart'])
        ->name('assignments.ielts-academic.listening.practice-index.part')
        ->middleware('check.assignment.program.access');
    Route::get('/assignments/ielts-academic/speaking/practice-index', [App\Http\Controllers\IeltsSpeakingController::class, 'practiceIndex'])->name('assignments.ielts-academic.speaking.practice.index');
    Route::get('/assignments/ielts-academic/speaking/practice-index/part{part}', [App\Http\Controllers\IeltsSpeakingController::class, 'practiceIndexPart'])->name('assignments.ielts-academic.speaking.practice-index.part');
    Route::get('/assignments/ielts-academic/writing/practice-index', [App\Http\Controllers\IeltsWritingController::class, 'practiceIndex'])->name('assignments.ielts-academic.writing.practice.index');
    Route::get('/assignments/ielts-academic/listening/warm-up/{type}', [App\Http\Controllers\IeltsListeningController::class, 'warmUp'])->name('assignments.ielts-academic.listening.warmup');
    Route::get('/api/dictionary/lookup', [App\Http\Controllers\ToeflDictionaryController::class, 'lookup'])->name('api.dictionary.lookup');
    Route::get('/api/dictionary/synonyms', [App\Http\Controllers\ToeflDictionaryController::class, 'synonyms'])->name('api.dictionary.synonyms');
    Route::get('/api/ollama/collocation', [App\Http\Controllers\OllamaController::class, 'getCollocations'])->name('api.ollama.collocation');
    Route::post('/api/ollama/translate', [App\Http\Controllers\OllamaController::class, 'translate'])->name('api.ollama.translate');
    Route::post('/api/lmstudio/chat', [App\Http\Controllers\OllamaController::class, 'chat'])->name('api.lmstudio.chat');
    Route::get('/api/audio-files', [App\Http\Controllers\ToeflListeningAdminController::class, 'getSourceAudioFilesList'])->name('api.audio.files');
    
    // Legacy / Other Routes
    Route::post('/assignments/ielts-academic/listening/reorder', [App\Http\Controllers\IeltsListeningAdminController::class, 'reorderMeetings'])->name('assignments.ielts.listening.reorder');
    Route::post('/assignments/ielts-academic/listening/meeting', [App\Http\Controllers\IeltsListeningAdminController::class, 'storeMeeting'])->name('assignments.ielts.listening.meeting.store');
    Route::put('/assignments/ielts-academic/listening/meeting/{id}', [App\Http\Controllers\IeltsMeetingController::class, 'update'])->name('assignments.ielts.listening.meeting.update');
    Route::delete('/assignments/ielts-academic/listening/meeting/{id}', [App\Http\Controllers\IeltsMeetingController::class, 'destroy'])->name('assignments.ielts.listening.meeting.destroy');
    Route::post('/assignments/ielts-academic/listening/meeting/{id}/toggle-lock', [App\Http\Controllers\IeltsMeetingController::class, 'toggleLock'])->name('assignments.ielts.listening.meeting.toggle-lock');

    // Questions Form
    Route::get('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}', [App\Http\Controllers\IeltsListeningController::class, 'showPractice'])->name('assignments.ielts-academic.listening.part1.practice');
    Route::get('/assignments/ielts-academic/listening/practice-index/part{set}/test{test}', [App\Http\Controllers\IeltsListeningController::class, 'practiceIndexTest'])->name('assignments.ielts-academic.listening.practice-index.test');
    Route::get('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/test/{test}', [App\Http\Controllers\IeltsListeningController::class, 'showPracticeTest'])->name('assignments.ielts-academic.listening.part1.practice.test');
    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/test/{test}/submit', [App\Http\Controllers\IeltsListeningController::class, 'submitPractice'])->name('assignment.ielts.listening.submit');
    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/upload-audio', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadAudio'])->name('assignments.ielts.listening.upload-audio');
    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/upload-srt', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadTranscript'])->name('assignments.ielts.listening.upload-srt');

    // IELTS Academic Reading Routes
    Route::get('/assignments/ielts-academic/reading', [App\Http\Controllers\IeltsReadingController::class, 'index'])->name('assignments.ielts-academic.reading.index');
    Route::get('/assignments/ielts-academic/reading/material/{id}', [App\Http\Controllers\IeltsReadingController::class, 'material'])->name('assignments.ielts-academic.reading.material');
    Route::get('/assignments/ielts-academic/reading/practice-index', [App\Http\Controllers\IeltsReadingController::class, 'practiceIndex'])->name('assignments.ielts-academic.reading.practice-index');
    Route::post('/assignments/ielts-academic/reading/reorder', [App\Http\Controllers\IeltsReadingAdminController::class, 'reorderMeetings'])->name('assignments.ielts.reading.reorder');
    Route::post('/assignments/ielts-academic/reading/meeting', [App\Http\Controllers\IeltsReadingAdminController::class, 'storeMeeting'])->name('assignments.ielts.reading.meeting.store');
    
    // Generic IELTS Meeting Routes (Reused logic, different route names for clarity/convention if needed, but pointing to generic controller methods)
    Route::put('/assignments/ielts-academic/reading/meeting/{id}', [App\Http\Controllers\IeltsMeetingController::class, 'update'])->name('assignments.ielts.reading.meeting.update');
    Route::delete('/assignments/ielts-academic/reading/meeting/{id}', [App\Http\Controllers\IeltsMeetingController::class, 'destroy'])->name('assignments.ielts.reading.meeting.destroy');
    Route::post('/assignments/ielts-academic/reading/meeting/{id}/toggle-lock', [App\Http\Controllers\IeltsMeetingController::class, 'toggleLock'])->name('assignments.ielts.reading.meeting.toggle-lock');
    
    // IELTS Reading Material CRUD Routes
    Route::post('/admin/ielts-reading/passage', [App\Http\Controllers\IeltsReadingAdminController::class, 'storePassage'])->name('admin.ielts.reading.passage.store');
    Route::put('/admin/ielts-reading/passage/{id}', [App\Http\Controllers\IeltsReadingAdminController::class, 'updatePassage'])->name('admin.ielts.reading.passage.update');
    Route::delete('/admin/ielts-reading/passage/{id}', [App\Http\Controllers\IeltsReadingAdminController::class, 'destroyPassage'])->name('admin.ielts.reading.passage.delete');

    Route::post('/admin/ielts-reading/question', [App\Http\Controllers\IeltsReadingAdminController::class, 'storeQuestion'])->name('admin.ielts.reading.question.store');
    Route::put('/admin/ielts-reading/question/{id}', [App\Http\Controllers\IeltsReadingAdminController::class, 'updateQuestion'])->name('admin.ielts.reading.question.update');
    Route::delete('/admin/ielts-reading/question/{id}', [App\Http\Controllers\IeltsReadingAdminController::class, 'destroyQuestion'])->name('admin.ielts.reading.question.delete');



    // Admin Upload Routes for Cambridge Test (auth required)
    Route::post('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/upload-audio', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'uploadAudio'])->name('assignments.ielts-academic.mockup.cambridge.upload-audio');
    Route::post('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/upload-srt', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'uploadSrt'])->name('assignments.ielts-academic.mockup.cambridge.upload-srt');
    Route::post('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/upload-answer-key', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'uploadAnswerKey'])->name('assignments.ielts-academic.mockup.cambridge.upload-answer-key');

    // Reading Mockup
    Route::get('/assignments/ielts-academic/mockup/reading', [App\Http\Controllers\IeltsMockupController::class, 'reading'])->name('assignments.ielts-academic.mockup.reading');

    // Writing
    // Writing
    Route::post('/assignments/ielts-academic/writing/evaluate', [App\Http\Controllers\IeltsWritingController::class, 'evaluate'])->name('assignments.ielts.writing.evaluate');
    Route::post('/assignments/ielts-academic/writing/feedback', [App\Http\Controllers\IeltsWritingController::class, 'feedback'])->name('assignments.ielts.writing.feedback');
    Route::post('/assignments/ielts-academic/writing/correct', [App\Http\Controllers\IeltsWritingController::class, 'correct'])->name('assignments.ielts.writing.correct');
    Route::post('/assignments/ielts-academic/writing/vocabulary', [App\Http\Controllers\IeltsWritingController::class, 'vocabulary'])->name('assignments.ielts.writing.vocabulary');
    Route::post('/assignments/ielts-academic/writing/coherence', [App\Http\Controllers\IeltsWritingController::class, 'coherence'])->name('assignments.ielts.writing.coherence');
    Route::post('/assignments/ielts-academic/writing/task-response', [App\Http\Controllers\IeltsWritingController::class, 'taskResponse'])->name('assignments.ielts.writing.task_response');
    Route::post('/assignments/ielts-academic/writing/grammar', [App\Http\Controllers\IeltsWritingController::class, 'grammar'])->name('assignments.ielts.writing.grammar');
    Route::post('/assignments/ielts-academic/writing/improve', [App\Http\Controllers\IeltsWritingController::class, 'improve'])->name('assignments.ielts.writing.improve');
    Route::get('/assignments/ielts-academic/writing', [App\Http\Controllers\IeltsWritingController::class, 'index'])->name('assignments.ielts-academic.writing.index');
    Route::get('/assignments/ielts-academic/writing/{task}/meeting/{id}', [App\Http\Controllers\IeltsWritingController::class, 'showMeeting'])->name('assignments.ielts-academic.writing.meeting');
    Route::post('/assignments/ielts-academic/writing', [App\Http\Controllers\IeltsWritingAdminController::class, 'storeMeeting'])->name('assignments.ielts.writing.store');
    Route::put('/assignments/ielts-academic/writing/{id}', [App\Http\Controllers\IeltsWritingAdminController::class, 'updateMeeting'])->name('assignments.ielts.writing.update');
    Route::delete('/assignments/ielts-academic/writing/{id}', [App\Http\Controllers\IeltsWritingAdminController::class, 'destroyMeeting'])->name('assignments.ielts.writing.destroy');
    Route::post('/assignments/ielts-academic/writing/{id}/toggle-lock', [App\Http\Controllers\IeltsWritingAdminController::class, 'toggleMeetingLock'])->name('assignments.ielts.writing.toggle-lock');
    Route::post('/assignments/ielts-academic/writing/reorder', [App\Http\Controllers\IeltsWritingAdminController::class, 'reorderMeetings'])->name('assignments.ielts.writing.reorder');
    Route::get('/assignments/ielts-academic/mockup/writing', [App\Http\Controllers\IeltsMockupController::class, 'writing'])->name('assignments.ielts-academic.mockup.writing');
    Route::get('/assignments/ielts-academic/mockup/writing/{id}', function($id) {
        return redirect()->route('assignments.ielts-academic.mockup.writing');
    })->name('assignments.ielts-academic.mockup.writing.test');
    
    // IELTS Writing Question CRUD
    Route::post('/assignments/ielts-academic/writing/questions', [App\Http\Controllers\IeltsWritingAdminController::class, 'storeQuestion'])->name('assignments.ielts.writing.question.store');
    Route::put('/assignments/ielts-academic/writing/questions/{id}', [App\Http\Controllers\IeltsWritingAdminController::class, 'updateQuestion'])->name('assignments.ielts.writing.question.update');
    Route::delete('/assignments/ielts-academic/writing/questions/{id}', [App\Http\Controllers\IeltsWritingAdminController::class, 'destroyQuestion'])->name('assignments.ielts.writing.question.destroy');

    // Speaking
    Route::get('/assignments/ielts-academic/speaking', [App\Http\Controllers\IeltsSpeakingController::class, 'index'])->name('assignments.ielts-academic.speaking.index');
    Route::get('/assignments/ielts-academic/speaking/practice', [App\Http\Controllers\IeltsSpeakingController::class, 'practice'])->name('assignments.ielts-academic.speaking.practice');
    Route::post('/assignments/ielts-academic/speaking/practice/grade', [App\Http\Controllers\IeltsSpeakingController::class, 'grade'])->name('assignments.ielts-academic.speaking.practice.grade');
    Route::get('/assignments/ielts-academic/speaking/practice/evaluation', [App\Http\Controllers\IeltsSpeakingController::class, 'evaluation'])->name('assignments.ielts-academic.speaking.evaluation');
    Route::post('/assignments/ielts-academic/speaking/practice/upgrade-lexical', [App\Http\Controllers\IeltsSpeakingController::class, 'upgradeLexical'])->name('assignments.ielts-academic.speaking.upgrade-lexical');
    Route::post('/assignments/ielts-academic/speaking/practice/collocations', [App\Http\Controllers\IeltsSpeakingController::class, 'suggestCollocations'])->name('assignments.ielts-academic.speaking.collocations');
    
    // Speaking Topics CRUD
    Route::post('/admin/ielts-speaking/topics', [App\Http\Controllers\IeltsSpeakingAdminController::class, 'storeTopic'])->name('admin.ielts.speaking.topics.store');
    Route::put('/admin/ielts-speaking/topics/{id}', [App\Http\Controllers\IeltsSpeakingAdminController::class, 'updateTopic'])->name('admin.ielts.speaking.topics.update');
    Route::delete('/admin/ielts-speaking/topics/{id}', [App\Http\Controllers\IeltsSpeakingAdminController::class, 'destroyTopic'])->name('admin.ielts.speaking.topics.delete');
    Route::post('/admin/ielts-speaking/topics/{id}/toggle-lock', [App\Http\Controllers\IeltsSpeakingAdminController::class, 'toggleLock'])->name('admin.ielts.speaking.topics.toggle-lock');
    Route::post('/assignments/ielts-academic/speaking/practice/check-grammar', [App\Http\Controllers\IeltsSpeakingController::class, 'checkGrammar'])->name('assignments.ielts-academic.speaking.check-grammar');
    Route::post('/assignments/ielts-academic/speaking/practice/upgrade-grammar', [App\Http\Controllers\IeltsSpeakingController::class, 'upgradeGrammar'])->name('assignments.ielts-academic.speaking.upgrade-grammar');
    Route::post('/assignments/ielts-academic/speaking/practice/model-answer', [App\Http\Controllers\IeltsSpeakingController::class, 'modelAnswer'])->name('assignments.ielts-academic.speaking.model-answer');
    Route::post('/assignments/ielts-academic/speaking/practice/analyze-pronunciation', [App\Http\Controllers\IeltsSpeakingController::class, 'analyzePronunciation'])->name('assignments.ielts-academic.speaking.analyze-pronunciation');
    Route::post('/assignments/ielts-academic/speaking/practice/analyze-fluency', [App\Http\Controllers\IeltsSpeakingController::class, 'analyzeFluency'])->name('assignments.ielts-academic.speaking.analyze-fluency');
    Route::get('/assignments/ielts-academic/mockup/speaking', [App\Http\Controllers\IeltsMockupController::class, 'speaking'])->name('assignments.ielts-academic.mockup.speaking');
    Route::get('/assignments/ielts-academic/mockup/speaking/{id}', function($id) {
        return redirect()->route('assignments.ielts-academic.mockup.speaking');
    })->name('assignments.ielts-academic.mockup.speaking.test');
    
    // TOEFL ITP Mock Up Test Route
    Route::get('/assignments/toefl-itp', [App\Http\Controllers\ToeflItpController::class, 'index'])->name('assignments.toefl-itp');
    Route::get('/assignments/toefl-itp/listening', [App\Http\Controllers\ToeflListeningController::class, 'index'])->name('assignments.toefl-itp.listening');
    Route::get('/assignments/toefl-itp/listening-lesson', [App\Http\Controllers\ToeflListeningController::class, 'index'])->name('assignments.toefl-itp.listening.lesson');
    Route::get('/assignments/toefl-itp/listening-practice', [App\Http\Controllers\ToeflListeningPracticeController::class, 'index'])->name('assignments.toefl-itp.listening.practice');
    Route::get('/assignments/toefl-itp/listening-practice/part-a', [App\Http\Controllers\ToeflListeningPracticeController::class, 'partA'])->name('assignments.toefl-itp.listening.practice.part-a');
    Route::get('/assignments/toefl-itp/listening-practice/part-a/{start}-{end}', [App\Http\Controllers\ToeflListeningPracticeController::class, 'showPartARange'])->whereNumber('start')->whereNumber('end')->name('assignments.toefl-itp.listening.practice.part-a.range');
    Route::get('/assignments/toefl-itp/listening-practice/package/{package}', [App\Http\Controllers\ToeflListeningPracticeController::class, 'showPackage'])->whereNumber('package')->name('assignments.toefl-itp.listening.practice.package');
    Route::post('/assignments/toefl-itp/listening-practice/package/{package}/submit', [App\Http\Controllers\ToeflListeningPracticeController::class, 'submit'])->whereNumber('package')->name('assignments.toefl-itp.listening.practice.package.submit');
    Route::post('/assignments/toefl-itp/listening-practice/package/{package}/upload-audio', [App\Http\Controllers\ToeflListeningPracticeController::class, 'uploadAudio'])->whereNumber('package')->name('assignments.toefl-itp.listening.practice.package.upload-audio');
    Route::post('/assignments/toefl-itp/listening-practice/package/{package}/upload-srt', [App\Http\Controllers\ToeflListeningPracticeController::class, 'uploadSrt'])->whereNumber('package')->name('assignments.toefl-itp.listening.practice.package.upload-srt');
    Route::post('/assignments/toefl-itp/listening-practice/package/{package}/update-transcript', [App\Http\Controllers\ToeflListeningPracticeController::class, 'updateTranscript'])->whereNumber('package')->name('assignments.toefl-itp.listening.practice.package.update-transcript');
    Route::get('/assignments/toefl-itp/listening/{number}', [App\Http\Controllers\ToeflListeningController::class, 'showMeeting'])->name('assignments.toefl-itp.listening.meeting');
    Route::post('/assignments/toefl-itp/listening/{number}/add-set', [App\Http\Controllers\ToeflListeningAdminController::class, 'addSet'])->name('assignments.toefl-itp.listening.meeting.add-set');
    Route::post('/assignments/toefl-itp/listening/{number}/remove-set', [App\Http\Controllers\ToeflListeningAdminController::class, 'removeSet'])->name('assignments.toefl-itp.listening.meeting.remove-set');
    Route::get('/assignments/toefl-itp/listening/{number}/practice/{set}', [App\Http\Controllers\ToeflListeningController::class, 'showPractice'])->name('assignments.toefl-itp.listening.meeting.practice');
    Route::post('/assignments/toefl-itp/listening/{number}/practice/{set}/upload-srt', [App\Http\Controllers\ToeflListeningAdminController::class, 'uploadSrt'])->name('assignments.toefl-itp.listening.meeting.upload-srt');
    Route::post('/assignments/toefl-itp/listening/{number}/practice/{set}/upload-audio', [App\Http\Controllers\ToeflListeningAdminController::class, 'uploadAudio'])->name('assignments.toefl-itp.listening.meeting.upload-audio');
    Route::post('/assignments/toefl-itp/listening/{number}/practice/{set}/update-transcript', [App\Http\Controllers\ToeflListeningAdminController::class, 'updateTranscript'])->name('assignments.toefl-itp.listening.meeting.update-transcript');
    
    Route::post('/assignments/toefl-itp/listening/question', [App\Http\Controllers\ToeflListeningAdminController::class, 'storeQuestion'])->name('assignments.toefl-itp.listening.question.store');
    Route::put('/assignments/toefl-itp/listening/question/{id}', [App\Http\Controllers\ToeflListeningAdminController::class, 'updateQuestion'])->name('assignments.toefl-itp.listening.question.update');
    Route::delete('/assignments/toefl-itp/listening/question/{id}', [App\Http\Controllers\ToeflListeningAdminController::class, 'destroyQuestion'])->name('assignments.toefl-itp.listening.question.delete');
    
    Route::post('/assignments/toefl-itp/listening/{number}/submit', [App\Http\Controllers\ToeflListeningController::class, 'submit'])->name('assignments.toefl-itp.listening.meeting.submit');
    Route::post('/assignments/toefl-itp/listening/{number}/toggle-lock', [App\Http\Controllers\ToeflListeningAdminController::class, 'toggleLock'])->name('assignments.toefl-itp.listening.toggle-lock');
    Route::post('/assignments/toefl-itp/listening/{number}/toggle-transcript', [App\Http\Controllers\ToeflListeningAdminController::class, 'toggleTranscript'])->name('assignments.toefl-itp.listening.toggle-transcript');
    
    Route::get('/assignments/toefl-itp/structure', [App\Http\Controllers\ToeflStructureController::class, 'index'])->name('assignments.toefl-itp.structure');
    Route::get('/assignments/toefl-itp/structure-lesson', [App\Http\Controllers\ToeflStructureController::class, 'index'])->name('assignments.toefl-itp.structure.lesson');
    Route::get('/assignments/toefl-itp/structure-practice', [App\Http\Controllers\ToeflStructurePracticeController::class, 'index'])->name('assignments.toefl-itp.structure.practice');
    
    Route::post('/assignments/toefl-itp/structure', [App\Http\Controllers\ToeflStructureAdminController::class, 'store'])->name('assignments.toefl-itp.structure.store'); 
    
    Route::post('/assignments/toefl-itp/structure/{number}/add-set', [App\Http\Controllers\ToeflStructureAdminController::class, 'addSet'])->name('assignments.toefl-itp.structure.meeting.add-set');
    Route::post('/assignments/toefl-itp/structure/{number}/remove-set', [App\Http\Controllers\ToeflStructureAdminController::class, 'removeSet'])->name('assignments.toefl-itp.structure.meeting.remove-set');
    Route::post('/assignments/toefl-itp/structure/{number}/submit', [App\Http\Controllers\ToeflStructureController::class, 'submit'])->name('assignments.toefl-itp.structure.meeting.submit');
    Route::post('/assignments/toefl-itp/structure/{number}/save-explanation', [App\Http\Controllers\ToeflStructureAdminController::class, 'saveExplanation'])->name('assignments.toefl-itp.structure.meeting.save-explanation');
    Route::get('/assignments/toefl-itp/structure/{number}/download-explanation', [App\Http\Controllers\ToeflStructureController::class, 'downloadExplanation'])->name('assignments.toefl-itp.structure.meeting.download-explanation');
    
    Route::post('/assignments/toefl-itp/structure/reorder', [App\Http\Controllers\ToeflStructureAdminController::class, 'reorder'])->name('assignments.toefl-itp.structure.reorder');
    
    // Explicit Question Routes for Structure
    Route::post('/assignments/toefl-itp/structure/{number}/question', [App\Http\Controllers\ToeflStructureAdminController::class, 'storeQuestion'])->name('assignments.toefl-itp.structure.question.store');
    Route::put('/assignments/toefl-itp/structure/question/{id}', [App\Http\Controllers\ToeflStructureAdminController::class, 'updateQuestion'])->name('assignments.toefl-itp.structure.question.update');
    Route::delete('/assignments/toefl-itp/structure/question/{id}', [App\Http\Controllers\ToeflStructureAdminController::class, 'destroyQuestion'])->name('assignments.toefl-itp.structure.question.destroy');
    Route::post('/assignments/toefl-itp/structure/question/{id}/update-answer', [App\Http\Controllers\ToeflStructureAdminController::class, 'updateQuestionAnswer'])->name('assignments.toefl-itp.structure.question.update-answer');
    
    Route::get('/assignments/toefl-itp/structure/{number}', [App\Http\Controllers\ToeflStructureController::class, 'showMeeting'])->name('assignments.toefl-itp.structure.meeting');
    Route::post('/assignments/toefl-itp/structure/{meeting}/toggle-lock', [App\Http\Controllers\ToeflStructureAdminController::class, 'toggleLock'])->name('assignments.toefl-itp.structure.toggle-lock');
    Route::put('/assignments/toefl-itp/structure/{meeting}', [App\Http\Controllers\ToeflStructureAdminController::class, 'update'])->name('assignments.toefl-itp.structure.update');
    Route::delete('/assignments/toefl-itp/structure/{meeting}', [App\Http\Controllers\ToeflStructureAdminController::class, 'destroy'])->name('assignments.toefl-itp.structure.destroy');
    
    Route::get('/assignments/toefl-itp/reading', [App\Http\Controllers\ToeflReadingController::class, 'index'])->name('assignments.toefl-itp.reading');
    Route::get('/assignments/toefl-itp/reading-lesson', [App\Http\Controllers\ToeflReadingController::class, 'index'])->name('assignments.toefl-itp.reading.lesson');
    Route::get('/assignments/toefl-itp/reading-practice', [App\Http\Controllers\ToeflReadingPracticeController::class, 'index'])->name('assignments.toefl-itp.reading.practice');
    Route::get('/assignments/toefl-itp/reading-practice/package/{package}', [App\Http\Controllers\ToeflReadingPracticeController::class, 'showPackage'])->whereNumber('package')->name('assignments.toefl-itp.reading.practice.package');
    Route::post('/assignments/toefl-itp/reading', [App\Http\Controllers\ToeflReadingAdminController::class, 'store'])->name('assignments.toefl-itp.reading.store');
    Route::post('/assignments/toefl-itp/reading/reorder', [App\Http\Controllers\ToeflReadingAdminController::class, 'reorder'])->name('assignments.toefl-itp.reading.reorder');
    Route::get('/assignments/toefl-itp/reading/{number}', [App\Http\Controllers\ToeflReadingController::class, 'showMeeting'])->name('assignments.toefl-itp.reading.meeting');
    Route::post('/assignments/toefl-itp/reading/submit', [App\Http\Controllers\ToeflReadingController::class, 'submit'])->name('assignments.toefl-itp.reading.submit');
    Route::post('/assignments/toefl-itp/reading/{meeting}/toggle-lock', [App\Http\Controllers\ToeflReadingAdminController::class, 'toggleLock'])->name('assignments.toefl-itp.reading.toggle-lock');
    Route::post('/assignments/toefl-itp/reading/{meeting}/update', [App\Http\Controllers\ToeflReadingAdminController::class, 'update'])->name('assignments.toefl-itp.reading.update');
    Route::post('/assignments/toefl-itp/reading/{meeting}/destroy', [App\Http\Controllers\ToeflReadingAdminController::class, 'destroy'])->name('assignments.toefl-itp.reading.destroy');
    
    // Reading Passage & Question Routes
    Route::post('/assignments/toefl-itp/reading/passage', [App\Http\Controllers\ToeflReadingAdminController::class, 'storePassage'])->name('assignments.toefl-itp.reading.passage.store');
    Route::post('/assignments/toefl-itp/reading/passage/{passage}/update', [App\Http\Controllers\ToeflReadingAdminController::class, 'updatePassage'])->name('assignments.toefl-itp.reading.passage.update');
    Route::delete('/assignments/toefl-itp/reading/passage/{passage}', [App\Http\Controllers\ToeflReadingAdminController::class, 'destroyPassage'])->name('assignments.toefl-itp.reading.passage.destroy');

    Route::post('/assignments/toefl-itp/reading/question', [App\Http\Controllers\ToeflReadingAdminController::class, 'storeQuestion'])->name('assignments.toefl-itp.reading.question.store');
    Route::post('/assignments/toefl-itp/reading/question/{question}/update', [App\Http\Controllers\ToeflReadingAdminController::class, 'updateQuestion'])->name('assignments.toefl-itp.reading.question.update');
    Route::post('/assignments/toefl-itp/reading/question/{question}/destroy', [App\Http\Controllers\ToeflReadingAdminController::class, 'destroyQuestion'])->name('assignments.toefl-itp.reading.question.destroy');
    Route::post('/assignments/toefl-itp/reading/question/{id}/update-answer', [App\Http\Controllers\ToeflReadingAdminController::class, 'updateQuestionAnswer'])->name('assignments.toefl-itp.reading.question.update-answer');
    Route::get('/assignments/toefl-itp/vocabulary', [App\Http\Controllers\ToeflItpController::class, 'vocabulary'])->name('assignments.toefl-itp.vocabulary');
    Route::get('/assignments/toefl-itp/mockup', [App\Http\Controllers\ToeflMockupController::class, 'index'])->name('assignments.toefl-itp.mockup');
    Route::get('/assignments/toefl-itp/mockup/package/{package}', [App\Http\Controllers\ToeflMockupController::class, 'showPackage'])->whereNumber('package')->name('assignments.toefl-itp.mockup.package');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/submit', [App\Http\Controllers\ToeflMockupController::class, 'submit'])->whereNumber('package')->name('assignments.toefl-itp.mockup.submit');
    Route::get('/assignments/mock-tests/results/{result}', [App\Http\Controllers\ToeflMockupController::class, 'showResult'])->whereNumber('result')->name('assignments.mock-tests.results.show');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/upload-audio', [App\Http\Controllers\ToeflMockupController::class, 'uploadAudio'])->whereNumber('package')->name('assignments.toefl-itp.mockup.package.upload-audio');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/upload-srt', [App\Http\Controllers\ToeflMockupController::class, 'uploadSrt'])->whereNumber('package')->name('assignments.toefl-itp.mockup.package.upload-srt');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/update-transcript', [App\Http\Controllers\ToeflMockupController::class, 'updateTranscript'])->whereNumber('package')->name('assignments.toefl-itp.mockup.package.update-transcript');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/question/{question_id}/upload-audio', [App\Http\Controllers\ToeflMockupController::class, 'uploadQuestionAudio'])->whereNumber('package')->whereNumber('question_id')->name('assignments.toefl-itp.mockup.package.question.upload-audio');
    
    Route::get('/assignments/grammar-writing', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingClasses'])->name('assignments.grammar-writing.classes');
    Route::get('/assignments/grammar-writing/introductory/meeting/{meeting}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroductoryMeeting'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.introductory.meeting');
    Route::post('/assignments/grammar-writing/introductory/meeting/{meeting}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroductoryMeetingSubmit'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.introductory.meeting.submit');
    Route::post('/assignments/grammar-writing/introductory/meeting/{meeting}/reset', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroductoryMeetingReset'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.introductory.meeting.reset');
    Route::get('/assignments/grammar-writing/complexity/meeting/{meeting}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingComplexityMeeting'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.complexity.meeting');
    Route::get('/assignments/grammar-writing/proficiency/meeting/{meeting}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingProficiencyMeeting'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.proficiency.meeting');
    Route::get('/assignments/grammar-writing/{track}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingTrack'])
        ->whereIn('track', ['introductory', 'complexity', 'proficiency'])
        ->name('assignments.grammar-writing.track');
    Route::get('/assignments/grammar-writing/fast-track', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWriting'])->name('assignments.grammar-writing');
    Route::post('/assignments/grammar-writing/period', [App\Http\Controllers\GrammarWritingAdminController::class, 'updatePeriod'])->name('assignments.grammar-writing.period');
    Route::post('/assignments/batch-period', [App\Http\Controllers\GrammarWritingAdminController::class, 'updateBatchPeriod'])->name('assignments.batch-period');

    Route::get('/assignments/speaking', [App\Http\Controllers\SpeakingAdminController::class, 'speakingClasses'])->name('assignments.speaking.classes');
    Route::get('/assignments/speaking/fast-track', [App\Http\Controllers\SpeakingAdminController::class, 'speaking'])->name('assignments.speaking');
    Route::post('/assignments/meeting/{meeting}/toggle-lock', [App\Http\Controllers\GrammarWritingAdminController::class, 'toggleLock'])->name('assignments.meeting.toggle-lock');
    Route::get('/assignments/grammar-writing/fast-track/meeting1', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting1'])->name('assignments.grammar-writing.meeting1');
    Route::post('/assignments/grammar-writing/fast-track/meeting1', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting1Submit'])->name('assignments.grammar-writing.meeting1.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting1/reset', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting1Reset'])->name('assignments.grammar-writing.meeting1.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting2', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2'])->name('assignments.grammar-writing.meeting2');
    Route::post('/assignments/grammar-writing/fast-track/meeting2', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2Submit'])->name('assignments.grammar-writing.meeting2.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting2/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2Reset'])->name('assignments.grammar-writing.meeting2.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting3', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting3'])->name('assignments.grammar-writing.meeting3');
    Route::post('/assignments/grammar-writing/fast-track/meeting3', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting3Submit'])->name('assignments.grammar-writing.meeting3.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting{meeting}/draft', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meetingDraft'])->whereNumber('meeting')->name('assignments.grammar-writing.meeting.draft');
    Route::post('/assignments/grammar-writing/fast-track/meeting3/reset', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting3Reset'])->name('assignments.grammar-writing.meeting3.reset');
    Route::post('/assignments/grammar-writing/fast-track/meeting3/admin-reset', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting3AdminReset'])->name('assignments.grammar-writing.meeting3.admin-reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting4', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting4'])->name('assignments.grammar-writing.meeting4');
    Route::post('/assignments/grammar-writing/fast-track/meeting4', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting4Submit'])->name('assignments.grammar-writing.meeting4.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting4/reset', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting4Reset'])->name('assignments.grammar-writing.meeting4.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting5', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting5'])->name('assignments.grammar-writing.meeting5');
    Route::post('/assignments/grammar-writing/fast-track/meeting5', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting5Submit'])->name('assignments.grammar-writing.meeting5.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting5/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting5Reset'])->name('assignments.grammar-writing.meeting5.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting6', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting6'])->name('assignments.grammar-writing.meeting6');
    Route::post('/assignments/grammar-writing/fast-track/meeting6', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting6Submit'])->name('assignments.grammar-writing.meeting6.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting6/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting6Reset'])->name('assignments.grammar-writing.meeting6.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting7', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting7'])->name('assignments.grammar-writing.meeting7');
    Route::post('/assignments/grammar-writing/fast-track/meeting7', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting7Submit'])->name('assignments.grammar-writing.meeting7.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting7/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting7Reset'])->name('assignments.grammar-writing.meeting7.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting8', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting8'])->name('assignments.grammar-writing.meeting8');
    Route::post('/assignments/grammar-writing/fast-track/meeting8', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting8Submit'])->name('assignments.grammar-writing.meeting8.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting8/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting8Reset'])->name('assignments.grammar-writing.meeting8.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting9', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting9'])->name('assignments.grammar-writing.meeting9');
    Route::post('/assignments/grammar-writing/fast-track/meeting9', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting9Submit'])->name('assignments.grammar-writing.meeting9.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting9/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting9Reset'])->name('assignments.grammar-writing.meeting9.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting10', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting10'])->name('assignments.grammar-writing.meeting10');
    Route::post('/assignments/grammar-writing/fast-track/meeting10', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting10Submit'])->name('assignments.grammar-writing.meeting10.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting10/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting10Reset'])->name('assignments.grammar-writing.meeting10.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting11', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting11'])->name('assignments.grammar-writing.meeting11');
    Route::post('/assignments/grammar-writing/fast-track/meeting11', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting11Submit'])->name('assignments.grammar-writing.meeting11.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting11/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting11Reset'])->name('assignments.grammar-writing.meeting11.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting12', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting12'])->name('assignments.grammar-writing.meeting12');
    Route::post('/assignments/grammar-writing/fast-track/meeting12', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting12Submit'])->name('assignments.grammar-writing.meeting12.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting12/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting12Reset'])->name('assignments.grammar-writing.meeting12.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting13', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting13'])->name('assignments.grammar-writing.meeting13');
    Route::post('/assignments/grammar-writing/fast-track/meeting13', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting13Submit'])->name('assignments.grammar-writing.meeting13.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting13/reset', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting13Reset'])->name('assignments.grammar-writing.meeting13.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting14', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting14'])->name('assignments.grammar-writing.meeting14');
    Route::post('/assignments/grammar-writing/fast-track/meeting14', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting14Submit'])->name('assignments.grammar-writing.meeting14.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting14/reset', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting14Reset'])->name('assignments.grammar-writing.meeting14.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting15', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting15'])->name('assignments.grammar-writing.meeting15');
    Route::post('/assignments/grammar-writing/fast-track/meeting15', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting15Submit'])->name('assignments.grammar-writing.meeting15.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting15/reset', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting15Reset'])->name('assignments.grammar-writing.meeting15.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting16', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting16'])->name('assignments.grammar-writing.meeting16');
    Route::post('/assignments/grammar-writing/fast-track/meeting16', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting16Submit'])->name('assignments.grammar-writing.meeting16.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting16/reset', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting16Reset'])->name('assignments.grammar-writing.meeting16.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting17', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting17'])->name('assignments.grammar-writing.meeting17');
    Route::post('/assignments/grammar-writing/fast-track/meeting17', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting17Submit'])->name('assignments.grammar-writing.meeting17.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting17/reset', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting17Reset'])->name('assignments.grammar-writing.meeting17.reset');
    
    // Grammar Writing Admin Content Routes (generic CRUD)
    Route::post('/admin/assignments/grammar-writing/vocab', [App\Http\Controllers\GrammarWritingAdminController::class, 'storeGrammarVocabulary'])->name('admin.grammar.vocab.store');
    Route::put('/admin/assignments/grammar-writing/vocab/{id}', [App\Http\Controllers\GrammarWritingAdminController::class, 'updateGrammarVocabulary'])->name('admin.grammar.vocab.update');
    Route::delete('/admin/assignments/grammar-writing/vocab/{id}', [App\Http\Controllers\GrammarWritingAdminController::class, 'destroyGrammarVocabulary'])->name('admin.grammar.vocab.destroy');

    Route::post('/admin/assignments/grammar-writing/questions', [App\Http\Controllers\GrammarWritingAdminController::class, 'storeGrammarQuestion'])->name('admin.grammar.question.store');
    Route::put('/admin/assignments/grammar-writing/questions/{id}', [App\Http\Controllers\GrammarWritingAdminController::class, 'updateGrammarQuestion'])->name('admin.grammar.question.update');
    Route::delete('/admin/assignments/grammar-writing/questions/{id}', [App\Http\Controllers\GrammarWritingAdminController::class, 'destroyGrammarQuestion'])->name('admin.grammar.question.destroy');


    Route::get('/assignments/grammar-writing/fast-track/meeting18', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting18'])->name('assignments.grammar-writing.meeting18');
    Route::post('/assignments/grammar-writing/fast-track/meeting18', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting18Submit'])->name('assignments.grammar-writing.meeting18.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting18/reset', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting18Reset'])->name('assignments.grammar-writing.meeting18.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting19', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting19'])->name('assignments.grammar-writing.meeting19');
    Route::post('/assignments/grammar-writing/fast-track/meeting19', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting19Submit'])->name('assignments.grammar-writing.meeting19.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting19/reset', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting19Reset'])->name('assignments.grammar-writing.meeting19.reset');
    
    Route::get('/assignments/grammar-writing/fast-track/meeting20', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting20'])->name('assignments.grammar-writing.meeting20');
     Route::post('/assignments/grammar-writing/fast-track/meeting20', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting20Submit'])->name('assignments.grammar-writing.meeting20.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting20/reset', [App\Http\Controllers\GrammarWritingAdvancedSessionController::class, 'meeting20Reset'])->name('assignments.grammar-writing.meeting20.reset');




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
    Route::get('/admin/students/{student}/current-assignment', [App\Http\Controllers\Admin\StudentController::class, 'currentAssignment'])->name('admin.students.current_assignment')->middleware('role:admin');
    Route::get('/admin/students/{student}/current-assignment-json', [App\Http\Controllers\Admin\StudentController::class, 'currentAssignmentJson'])->name('admin.students.current_assignment_json')->middleware('role:admin');
    Route::resource('admin/students', App\Http\Controllers\Admin\StudentController::class)->names('students')->middleware('role:admin');

    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard')->middleware('role:admin');
    Route::get('/admin/campaign-signups/export', [App\Http\Controllers\Admin\WHVApplicationController::class, 'exportCampaignSignups'])->name('admin.campaign-signups.export')->middleware('role:admin');
    
    // Admin Class Periods Management
    Route::get('/admin/class-periods/next-batch-number', [App\Http\Controllers\Admin\ClassPeriodController::class, 'nextBatchNumber'])->name('class-periods.next-batch-number')->middleware('role:admin');
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
    Route::get('/admin/live-draft/ielts-writing/{user}/{task}/meeting/{meetingId}', [App\Http\Controllers\LiveDraftController::class, 'adminIeltsWriting'])->name('admin.live-draft.ielts-writing')->middleware('role:admin');
    Route::get('/teacher/live-draft/ielts-writing/{user}/{task}/meeting/{meetingId}', [App\Http\Controllers\LiveDraftController::class, 'teacherIeltsWriting'])->name('teacher.live-draft.ielts-writing')->middleware('role:teacher');
    Route::post('/remote-view/request-screen', [App\Http\Controllers\RemoteViewController::class, 'requestScreen'])->name('remote-view.request-screen');
    Route::get('/remote-view/pending-request', [App\Http\Controllers\RemoteViewController::class, 'pendingRequest'])->name('remote-view.pending-request');
    Route::post('/remote-view/pending-request/ack', [App\Http\Controllers\RemoteViewController::class, 'acknowledgePendingRequest'])->name('remote-view.pending-request.ack');
    Route::post('/remote-view/signal', [App\Http\Controllers\RemoteViewController::class, 'sendSignal'])->name('remote-view.signal');
    Route::get('/remote-view/pending-signals', [App\Http\Controllers\RemoteViewController::class, 'pendingSignals'])->name('remote-view.pending-signals');
    
    // Admin Mock Tests Management (subset of programs)
    Route::get('admin/mock-tests', [App\Http\Controllers\Admin\ProgramController::class, 'mockTestsIndex'])->name('programs.mock-tests')->middleware('role:admin');

    // Admin Programs Management
    Route::resource('admin/programs', App\Http\Controllers\Admin\ProgramController::class)->names('programs')->middleware('role:admin');
    Route::post('admin/programs/{program}/deactivate', [App\Http\Controllers\Admin\ProgramController::class, 'deactivate'])->name('programs.deactivate')->middleware('role:admin');
    
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
    Route::get('/admin/toefl-mockup-results', [App\Http\Controllers\Admin\ToeflMockupResultController::class, 'index'])->name('admin.toefl-mockup-results.index')->middleware('role:admin');
    
    // Attendance
    Route::get('/admin/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.attendance.index')->middleware('role:admin');
    Route::get('/admin/attendance/meetings/{classPeriod}', [App\Http\Controllers\Admin\AttendanceController::class, 'getMeetings'])->name('admin.attendance.meetings')->middleware('role:admin');
    Route::get('/admin/attendance/records/{classMeeting}', [App\Http\Controllers\Admin\AttendanceController::class, 'getAttendance'])->name('admin.attendance.records')->middleware('role:admin');
    Route::post('/admin/attendance/store', [App\Http\Controllers\Admin\AttendanceController::class, 'store'])->name('admin.attendance.store')->middleware('role:admin');
    
    // Reports
    Route::get('/admin/reports/{tab?}', [App\Http\Controllers\Admin\ReportController::class, 'index'])
        ->where('tab', 'student|teacher|guest|finance')
        ->name('admin.reports.index')
        ->middleware('role:admin');

    // Admin Payment Verification
    Route::get('/admin/payments', [App\Http\Controllers\PaymentController::class, 'adminIndex'])
        ->name('admin.payments.index')
        ->middleware('role:admin');
    Route::get('/admin/payments/export-csv', [App\Http\Controllers\PaymentController::class, 'adminExportCsv'])
        ->name('admin.payments.export-csv')
        ->middleware('role:admin');
    Route::get('/admin/payments/export-trend-csv', [App\Http\Controllers\PaymentController::class, 'adminExportTrendCsv'])
        ->name('admin.payments.export-trend-csv')
        ->middleware('role:admin');
    Route::post('/admin/payments/{payment}/approve', [App\Http\Controllers\PaymentController::class, 'approve'])
        ->name('admin.payments.approve')
        ->middleware('role:admin');
    Route::post('/admin/payments/{payment}/reject', [App\Http\Controllers\PaymentController::class, 'reject'])
        ->name('admin.payments.reject')
        ->middleware('role:admin');
    
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
    Route::post('admin/scholarships/bulk-review', [App\Http\Controllers\Admin\ScholarshipController::class, 'bulkReview'])->name('admin.scholarships.bulk-review')->middleware('role:admin');
    Route::post('admin/scholarships-scrape-preview', [App\Http\Controllers\Admin\ScholarshipController::class, 'scrapePreview'])->name('admin.scholarships.scrape.preview')->middleware('role:admin');
    Route::post('admin/scholarships-scrape-preview-clear', [App\Http\Controllers\Admin\ScholarshipController::class, 'scrapePreviewClear'])->name('admin.scholarships.scrape.preview.clear')->middleware('role:admin');
    Route::post('admin/scholarships-scrape-commit', [App\Http\Controllers\Admin\ScholarshipController::class, 'scrapeCommit'])->name('admin.scholarships.scrape.commit')->middleware('role:admin');
    Route::post('admin/scholarships-scrape', [App\Http\Controllers\Admin\ScholarshipController::class, 'scrapeProcess'])->name('admin.scholarships.scrape.process')->middleware('role:admin');
    Route::get('admin/scholarships-import', [App\Http\Controllers\Admin\ScholarshipController::class, 'importForm'])->name('admin.scholarships.import.form')->middleware('role:admin');
    Route::post('admin/scholarships-import', [App\Http\Controllers\Admin\ScholarshipController::class, 'importProcess'])->name('admin.scholarships.import.process')->middleware('role:admin');
    Route::get('admin/scholarships/{scholarship}/match', [App\Http\Controllers\Admin\ScholarshipController::class, 'smartMatch'])->name('admin.scholarships.match')->middleware('role:admin');

    // Admin Scholarship News Management
    Route::resource('admin/scholarship-news', App\Http\Controllers\Admin\ScholarshipNewsController::class)->names('admin.scholarship-news')->middleware('role:admin');

    // Admin Job Vacancies Management
    Route::resource('admin/job-vacancies', App\Http\Controllers\Admin\JobVacancyController::class)->names('admin.job-vacancies')->middleware('role:admin');

    // Admin WHV Applications Management
    Route::resource('admin/whv-applications', App\Http\Controllers\Admin\WHVApplicationController::class)->names('admin.whv-applications')->middleware('role:admin');

    // Admin Registration Leads Management
    Route::get('/admin/registration-leads', [App\Http\Controllers\Admin\RegistrationLeadController::class, 'index'])->name('admin.registration-leads.index')->middleware('role:admin');
    Route::get('/admin/registration-leads/export', [App\Http\Controllers\Admin\RegistrationLeadController::class, 'export'])->name('admin.registration-leads.export')->middleware('role:admin');
    Route::get('/admin/registration-leads/{registrationLead}', [App\Http\Controllers\Admin\RegistrationLeadController::class, 'show'])->name('admin.registration-leads.show')->middleware('role:admin');
    Route::put('/admin/registration-leads/{registrationLead}', [App\Http\Controllers\Admin\RegistrationLeadController::class, 'update'])->name('admin.registration-leads.update')->middleware('role:admin');
    Route::patch('/admin/registration-leads/{registrationLead}/status', [App\Http\Controllers\Admin\RegistrationLeadController::class, 'updateStatus'])->name('admin.registration-leads.update-status')->middleware('role:admin');
    Route::post('/admin/registration-leads/{registrationLead}/convert', [App\Http\Controllers\Admin\RegistrationLeadController::class, 'convertToStudent'])->name('admin.registration-leads.convert')->middleware('role:admin');
    Route::delete('/admin/registration-leads/{registrationLead}', [App\Http\Controllers\Admin\RegistrationLeadController::class, 'destroy'])->name('admin.registration-leads.destroy')->middleware('role:admin');

    // Email Logs
    Route::get('/admin/email-logs', [App\Http\Controllers\Admin\EmailLogController::class, 'index'])->name('admin.email-logs.index')->middleware('role:admin');
    Route::get('/admin/email-logs/{emailLog}', [App\Http\Controllers\Admin\EmailLogController::class, 'show'])->name('admin.email-logs.show')->middleware('role:admin');

    // Admin Enrollment Requests
    Route::get('/admin/enrollment-requests', [App\Http\Controllers\Admin\EnrollmentRequestController::class, 'index'])->name('admin.enrollment-requests.index')->middleware('role:admin');
    Route::post('/admin/enrollment-requests/{enrollmentRequest}/approve', [App\Http\Controllers\Admin\EnrollmentRequestController::class, 'approve'])->name('admin.enrollment-requests.approve')->middleware('role:admin');
    Route::post('/admin/enrollment-requests/{enrollmentRequest}/reject', [App\Http\Controllers\Admin\EnrollmentRequestController::class, 'reject'])->name('admin.enrollment-requests.reject')->middleware('role:admin');
});

// Public Registration Form
Route::get('/daftar', [App\Http\Controllers\RegistrationController::class, 'show'])->name('registration.show');
Route::post('/daftar', [App\Http\Controllers\RegistrationController::class, 'store'])->name('registration.store');
Route::get('/daftar/success', [App\Http\Controllers\RegistrationController::class, 'success'])->name('registration.success');

// Landing Page Class Registration Lead (saves to RegistrationLead + redirects to student register)
Route::post('/daftar-kelas', [App\Http\Controllers\PublicRegistrationLeadController::class, 'store'])->name('class-lead.store');

// 2-Way Messaging & Inbox
Route::middleware(['auth'])->group(function () {
    Route::get('/announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/inbox', [App\Http\Controllers\InboxController::class, 'index'])->name('inbox.index');
    Route::post('/inbox', [App\Http\Controllers\InboxController::class, 'store'])->name('inbox.store');
    Route::post('/inbox/{id}/read', [App\Http\Controllers\InboxController::class, 'markAsRead'])->name('inbox.read');
});

// OTP Routes for Registration
Route::post('/otp/send', [App\Http\Controllers\Auth\OtpController::class, 'send'])->name('otp.send');
Route::post('/otp/verify', [App\Http\Controllers\Auth\OtpController::class, 'verify'])->name('otp.verify');

require __DIR__.'/auth.php';

Route::post('admin/scholarships/bulk-publish', [App\Http\Controllers\Admin\ScholarshipController::class, 'bulkPublish'])->name('admin.scholarships.bulk-publish')->middleware('role:admin');
