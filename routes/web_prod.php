<?php

use Illuminate\Support\Facades\Route;

// Public Kokoro TTS stream route (accessible without login - just serves/generates audio)
Route::get('/tts/stream', [App\Http\Controllers\OnlineTestController::class, 'streamKokoroSpeech'])->name('tts.stream');

Route::get('/guest/quick-access/{testType}', [App\Http\Controllers\GuestQuickAccessController::class, 'quickAccess'])->name('guest.quick-access');
Route::get('/guest/quick-access-toefl/{type}/{number}', [App\Http\Controllers\GuestQuickAccessController::class, 'quickAccessToeflPromo'])->name('guest.quick-access-toefl');
Route::get('/guest/dashboard', [App\Http\Controllers\GuestController::class, 'dashboard'])->name('guest.dashboard');
Route::get('/guest/register', [App\Http\Controllers\GuestController::class, 'showRegisterForm'])->name('guest.register');
Route::post('/guest/register', [App\Http\Controllers\GuestController::class, 'register'])->name('guest.register.submit');

// Public Quick Inquiry API (used by modals on Scholarships, Jobs, WHV)
Route::post('/public-inquiry', [App\Http\Controllers\PublicRegistrationLeadController::class, 'ajaxStore'])->name('public.inquiry.store');

// Free AI Test Promo Routes
Route::prefix('promo/test')->name('promo.test.')->group(function () {
    Route::get('/', [App\Http\Controllers\PromoTestController::class, 'index'])->name('index');
    Route::view('/expired', 'promo.expired')->name('expired');
    Route::get('/toefl_listening', [App\Http\Controllers\PromoTestController::class, 'showToeflListening'])->name('toefl_listening');
    Route::post('/toefl_listening/submit', [App\Http\Controllers\PromoTestController::class, 'submitToeflListening'])->name('toefl_listening.submit');
    Route::get('/ielts_listening/{meeting}/test/{test}', [App\Http\Controllers\PromoTestController::class, 'showIeltsListeningPromo'])->name('ielts_listening.show');
    Route::post('/ielts_listening/{meeting}/test/{test}/submit', [App\Http\Controllers\PromoTestController::class, 'submitIeltsListeningPromo'])->name('ielts_listening.submit');
    
    // Grammar Promo Test Routes
    Route::get('/grammar-promo/{meeting}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroductoryMeetingPromo'])->name('grammar.show');
    Route::post('/grammar-promo/{meeting}/submit', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroductoryMeetingSubmitPromo'])->name('grammar.submit');

    // Admin Edit Promo Test Routes
    Route::get('/ieltswritingacademic/{task}/meeting/{id}', [App\Http\Controllers\IeltsWritingController::class, 'showMeeting'])->name('ieltswritingacademic.meeting');
    Route::get('/ieltswritinggeneral/{task}/meeting/{id}', [App\Http\Controllers\IeltsWritingController::class, 'showMeeting'])->name('ieltswritinggeneral.meeting');
    Route::get('/toeflitplistening/{number}', [App\Http\Controllers\ToeflListeningController::class, 'showMeeting'])->name('toeflitplistening.meeting');
    Route::get('/toeflitpstructure/{number}', [App\Http\Controllers\ToeflStructureController::class, 'showMeeting'])->name('toeflitpstructure.meeting');
    Route::get('/toeflitpreading/{number}', [App\Http\Controllers\ToeflReadingController::class, 'showMeeting'])->name('toeflitpreading.meeting');
    Route::get('/grammar/{meeting}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroductoryMeeting'])->name('grammar.meeting');
    // TOEFL Structure Promo Test Routes (public, no auth - isolated ToeflPromoTest/ToeflPromoQuestion pool)
    Route::prefix('toefl-structure')->name('toefl-structure.')->group(function () {
        Route::get('/{id}', [App\Http\Controllers\ToeflPromoTestController::class, 'show'])->name('show');
        Route::post('/{id}/submit', [App\Http\Controllers\ToeflPromoTestController::class, 'submit'])->name('submit');
        Route::patch('/questions/{questionId}/answer', [App\Http\Controllers\ToeflPromoTestController::class, 'updateAnswer'])->name('questions.update-answer');
    });

    Route::get('/{type}/{id}', [App\Http\Controllers\PromoTestController::class, 'show'])->name('show');
    Route::post('/{type}/{id}/submit', [App\Http\Controllers\PromoTestController::class, 'submit'])->name('submit');
    Route::post('/{type}/{id}/submit/retry/{submission_id}', [App\Http\Controllers\PromoTestController::class, 'retryEvaluation'])->name('submit.retry');
    Route::get('/{type}/{id}/ielts-academic-evaluation/{submission_id}', [App\Http\Controllers\PromoTestController::class, 'result'])->name('result');
    Route::post('/{type}/{id}/ielts-academic-evaluation/{submission_id}/send-wa', [App\Http\Controllers\PromoTestController::class, 'sendWaResult'])->name('send-wa-result');
    Route::post('/{type}/{id}/update-admin', [App\Http\Controllers\PromoTestController::class, 'updateAdmin'])->name('update.admin');
    Route::get('/echomimic-avatar', [App\Http\Controllers\PromoTestController::class, 'getEchomimicAvatar'])->name('echomimic-avatar');
});

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

Route::get('/brochure/pdf/{slug}', [App\Http\Controllers\BrochureController::class, 'pdf'])->name('brochure.pdf');
Route::get('/brochure/{type?}', [App\Http\Controllers\BrochureController::class, 'index'])->name('brochure');

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
Route::get('/assignments/ielts-academic/mockup/cambridge', function () {
    return redirect()->route('mock-test.ielts-academic.cambridge', [], 301);
})->name('assignments.ielts-academic.mockup.cambridge');
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

// Public AI APIs (Used by promo pages and public tests)
Route::get('/api/dictionary/lookup', [App\Http\Controllers\ToeflDictionaryController::class, 'lookup'])->name('api.dictionary.lookup');
Route::get('/api/dictionary/synonyms', [App\Http\Controllers\ToeflDictionaryController::class, 'synonyms'])->name('api.dictionary.synonyms');
Route::get('/api/ollama/collocation', [App\Http\Controllers\AiController::class, 'getCollocations'])->name('api.ollama.collocation');
Route::post('/api/ollama/topic-collocations', [App\Http\Controllers\AiController::class, 'getTopicCollocations'])->name('api.ollama.topicCollocations');
Route::post('/api/ollama/topic-idioms', [App\Http\Controllers\AiController::class, 'getTopicIdioms'])->name('api.ollama.topicIdioms');
Route::post('/api/ollama/ideas', [App\Http\Controllers\AiController::class, 'getIdeas'])->name('api.ollama.ideas');
Route::post('/api/ollama/translate', [App\Http\Controllers\AiController::class, 'translate'])->name('api.ollama.translate');
Route::post('/api/ollama/translate-sentence', [App\Http\Controllers\AiController::class, 'translateSentence'])->name('api.ollama.translateSentence');
Route::post('/api/ollama/academic-words', [App\Http\Controllers\AiController::class, 'academicWords'])->name('api.ollama.academicWords');
Route::post('/api/lmstudio/chat', [App\Http\Controllers\AiController::class, 'chat'])->name('api.lmstudio.chat');
Route::post('/api/groq/grammar-eval', [App\Http\Controllers\AiController::class, 'evaluateGrammar'])->name('api.groq.grammarEval');

// Booking Class: Public student/guest registration & booking into an available Class Period batch (No login or signup required)
Route::get('/booking-class', [App\Http\Controllers\BookingClassController::class, 'index'])->name('student.booking-class.index');
Route::post('/booking-class', [App\Http\Controllers\BookingClassController::class, 'submit'])->name('student.booking-class.submit');
Route::post('/booking-class/{classPeriod}', [App\Http\Controllers\BookingClassController::class, 'book'])->name('student.booking-class.book');

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
    Route::prefix('online-test')->name('online-test.')->group(function () {
        Route::get('/', [App\Http\Controllers\OnlineTestController::class, 'index'])->name('index');
        Route::post('/{slug}/verify-access-code', [App\Http\Controllers\OnlineTestController::class, 'verifyAccessCode'])->name('verify-access-code');
        Route::get('/{slug}', [App\Http\Controllers\OnlineTestController::class, 'show'])->name('show');
        Route::post('/{slug}/start', [App\Http\Controllers\OnlineTestResultController::class, 'start'])->name('start');
        Route::get('/{slug}/exam/{onlineTestResult}', [App\Http\Controllers\OnlineTestController::class, 'exam'])->name('exam');
        Route::post('/{slug}/exam/{onlineTestResult}', [App\Http\Controllers\OnlineTestResultController::class, 'submit'])->name('submit');
        Route::get('/{slug}/result/{onlineTestResult}', [App\Http\Controllers\OnlineTestController::class, 'result'])->name('result');
        Route::get('/kokoro-tts/stream', [App\Http\Controllers\OnlineTestController::class, 'streamKokoroSpeech'])->name('kokoro-tts.stream');
        Route::post('/kokoro-tts', [App\Http\Controllers\OnlineTestController::class, 'synthesizeKokoroSpeech'])->name('kokoro-tts');
        Route::get('/kokoro-tts/{filename}', [App\Http\Controllers\OnlineTestController::class, 'serveSynthesizedSpeech'])->name('kokoro-tts.file');
        Route::get('/ielts-academic/paket{package}/band-report', [App\Http\Controllers\OnlineTestController::class, 'ieltsAcademicBandReport'])->whereNumber('package')->name('ielts-academic.band-report');
        Route::post('/ielts-academic/paket{package}/band-report/certificate', [App\Http\Controllers\OnlineTestController::class, 'updateIeltsAcademicCertificate'])->whereNumber('package')->name('ielts-academic.band-report.certificate');
        Route::get('/ielts-general/paket{package}/band-report', [App\Http\Controllers\OnlineTestController::class, 'ieltsGeneralBandReport'])->whereNumber('package')->name('ielts-general.band-report');
        Route::get('/toefl-itp/paket{package}/score-report', [App\Http\Controllers\OnlineTestController::class, 'toeflItpScoreReport'])->whereNumber('package')->name('toefl-itp.score-report');
        Route::get('/{slugAlias}/paket{package}/{section}', [App\Http\Controllers\OnlineTestController::class, 'packageSection'])->whereNumber('package')->name('package-section');
        Route::post('/{slugAlias}/paket{package}/{section}', [App\Http\Controllers\OnlineTestController::class, 'submitPackageSection'])->whereNumber('package')->name('package-section.submit');
        Route::post('/{slug}/end-session', [App\Http\Controllers\OnlineTestController::class, 'endSession'])->name('end-session');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/leads', [App\Http\Controllers\AdminLeadController::class, 'index'])->name('leads.index');
        Route::post('/leads/{id}/status', [App\Http\Controllers\AdminLeadController::class, 'updateStatus'])->name('leads.status.update');
        
        // ── Listening Machine (full AI pipeline) ─────────────────────────────
        Route::prefix('listening-machine')->name('listening-machine.')->group(function () {
            // AJAX endpoints must come BEFORE the {bank} wildcard
            Route::post('/api/humanize',           [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'humanize'])->name('humanize');
            Route::post('/api/generate-audio',     [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'generateAudio'])->name('generate-audio');
            Route::post('/api/generate-sfx',       [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'generateSfx'])->name('generate-sfx');
            Route::post('/api/upload-sfx',         [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'uploadSfx'])->name('upload-sfx');
            Route::post('/api/compile-audio',      [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'compileAudio'])->name('compile-audio');
            Route::post('/api/generate-questions', [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'generateQuestions'])->name('generate-questions');
            Route::get('/api/job-status/{jobId}',  [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'jobStatus'])->name('job-status');
            Route::post('/api/export-to-public',   [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'exportToPublic'])->name('export-to-public');
            Route::get('/',          [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'index'])->name('index');
            Route::get('/create',    [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'create'])->name('create');
            Route::post('/',         [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'store'])->name('store');
            Route::get('/{bank}',    [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'show'])->name('show');
            Route::delete('/{bank}', [App\Http\Controllers\Admin\AdminListeningMachineController::class, 'destroy'])->name('destroy');
        });
        // ── Audio / Media Library Manager ─────────────────────────────
        Route::prefix('audio-library')->name('audio-library.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AdminAudioLibraryController::class, 'index'])->name('index');
            Route::delete('/delete', [App\Http\Controllers\Admin\AdminAudioLibraryController::class, 'destroy'])->name('destroy');
            Route::get('/stats', [App\Http\Controllers\Admin\AdminAudioLibraryController::class, 'stats'])->name('stats');
        });


        Route::get('/promo-tests', [App\Http\Controllers\AdminPromoTestController::class, 'index'])->name('promo-tests.index');
        Route::get('/promo-tests/preview/writing', [App\Http\Controllers\AdminPromoTestController::class, 'previewWriting'])->name('promo-tests.preview.writing');
        Route::get('/promo-tests/preview/speaking', [App\Http\Controllers\AdminPromoTestController::class, 'previewSpeaking'])->name('promo-tests.preview.speaking');
        Route::get('/promo-tests/preview/toefl', [App\Http\Controllers\AdminPromoTestController::class, 'previewToefl'])->name('promo-tests.preview.toefl');

        Route::get('/ai-management', [App\Http\Controllers\Admin\AiManagementController::class, 'index'])->name('ai-management.index');
        Route::post('/ai-management/update-key', [App\Http\Controllers\Admin\AiManagementController::class, 'updateKey'])->name('ai-management.update-key');
        Route::post('/ai-management/save-groq-keys', [App\Http\Controllers\Admin\AiManagementController::class, 'saveGroqKeys'])->name('ai-management.save-groq-keys');
        Route::post('/ai-management/save-other-provider-keys', [App\Http\Controllers\Admin\AiManagementController::class, 'saveOtherProviderKeys'])->name('ai-management.save-other-provider-keys');
        Route::post('/ai-management/toggle-local-api', [App\Http\Controllers\Admin\AiManagementController::class, 'toggleLocalApi'])->name('ai-management.toggle-local-api');
        Route::get('/ai-management/tts-server-status', [App\Http\Controllers\Admin\AiManagementController::class, 'ttsServerStatus'])->name('ai-management.tts-server-status');
        Route::post('/promo-tests/colab', [App\Http\Controllers\AdminPromoTestController::class, 'updateColab'])->name('promo-tests.update-colab');
        Route::post('/promo-tests/bulk', [App\Http\Controllers\AdminPromoTestController::class, 'bulkUpdate'])->name('promo-tests.bulk-update');
        Route::post('/promo-tests/writing', [App\Http\Controllers\AdminPromoTestController::class, 'storeWriting'])->name('promo-tests.writing.store');
        Route::delete('/promo-tests/writing/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'destroyWriting'])->name('promo-tests.writing.destroy');
        Route::post('/promo-tests/writing/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateWriting'])->name('promo-tests.writing.update');
        Route::post('/promo-tests/speaking', [App\Http\Controllers\AdminPromoTestController::class, 'storeSpeaking'])->name('promo-tests.speaking.store');
        Route::delete('/promo-tests/speaking/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'destroySpeaking'])->name('promo-tests.speaking.destroy');
        Route::post('/promo-tests/speaking/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateSpeaking'])->name('promo-tests.speaking.update');
        Route::post('/promo-tests/speaking/{id}/render', [App\Http\Controllers\AdminPromoTestController::class, 'renderSpeaking'])->name('promo-tests.speaking.render');
        Route::post('/promo-tests/listening/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateListening'])->name('promo-tests.listening.update');
        Route::post('/promo-tests/grammar/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateGrammar'])->name('promo-tests.grammar.update');
        Route::post('/promo-tests/reading-general/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateReadingGeneral'])->name('promo-tests.reading-general.update');
        Route::post('/promo-tests/reading-academic/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateReadingAcademic'])->name('promo-tests.reading-academic.update');
        Route::post('/promo-tests/toefl-listening/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateToeflListening'])->name('promo-tests.toefl-listening.update');
        Route::post('/promo-tests/toefl-structure/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateToeflStructure'])->name('promo-tests.toefl-structure.update');
        Route::post('/promo-tests/toefl-structure-promo', [App\Http\Controllers\AdminPromoTestController::class, 'storeToeflPromoStructure'])->name('promo-tests.toefl-structure-promo.store');
        Route::post('/promo-tests/toefl-structure-promo/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateToeflPromoStructure'])->name('promo-tests.toefl-structure-promo.update');
        Route::delete('/promo-tests/toefl-structure-promo/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'destroyToeflPromoStructure'])->name('promo-tests.toefl-structure-promo.destroy');
        Route::get('/promo-tests/toefl-structure/{test}/questions', [App\Http\Controllers\AdminPromoTestController::class, 'toeflStructureQuestionsEditor'])->name('promo-tests.toefl-structure.questions.index');
        Route::post('/promo-tests/toefl-structure/{test}/questions', [App\Http\Controllers\AdminPromoTestController::class, 'storeToeflStructureQuestion'])->name('promo-tests.toefl-structure.questions.store');
        Route::put('/promo-tests/toefl-structure/questions/{question}', [App\Http\Controllers\AdminPromoTestController::class, 'updateToeflStructureQuestion'])->name('promo-tests.toefl-structure.questions.update');
        Route::delete('/promo-tests/toefl-structure/questions/{question}', [App\Http\Controllers\AdminPromoTestController::class, 'destroyToeflStructureQuestion'])->name('promo-tests.toefl-structure.questions.destroy');
        Route::delete('/promo-tests/toefl-structure/{test}/questions/clear-all', [App\Http\Controllers\AdminPromoTestController::class, 'clearToeflStructureQuestions'])->name('promo-tests.toefl-structure.questions.clear-all');
        Route::post('/promo-tests/toefl-reading/{id}', [App\Http\Controllers\AdminPromoTestController::class, 'updateToeflReading'])->name('promo-tests.toefl-reading.update');

        Route::get('/online-tests', [App\Http\Controllers\Admin\OnlineTestController::class, 'index'])->name('online-tests.index');
        Route::post('/online-tests', [App\Http\Controllers\Admin\OnlineTestController::class, 'update'])->name('online-tests.update');
        Route::post('/online-tests/{slug}/generate-code', [App\Http\Controllers\Admin\OnlineTestController::class, 'generateCode'])->name('online-tests.generate-code');
        Route::post('/online-tests/{slug}/toggle-code-access', [App\Http\Controllers\Admin\OnlineTestController::class, 'toggleCodeAccess'])->name('online-tests.toggle-code-access');
        Route::post('/online-tests/batches/{id}/archive', [App\Http\Controllers\Admin\OnlineTestController::class, 'archiveBatch'])->whereNumber('id')->name('online-tests.batch.archive');
        Route::post('/online-tests/batches/{id}/toggle-active', [App\Http\Controllers\Admin\OnlineTestController::class, 'toggleBatchActive'])->whereNumber('id')->name('online-tests.batch.toggle-active');
        Route::delete('/online-tests/batches/{id}', [App\Http\Controllers\Admin\OnlineTestController::class, 'destroyBatch'])->whereNumber('id')->name('online-tests.batch.destroy');
        Route::post('/online-tests/user-access/toggle', [App\Http\Controllers\Admin\OnlineTestController::class, 'toggleUserAccess'])->name('online-tests.user-access.toggle');
        Route::post('/online-tests/{slug}/sections/{section}/video', [App\Http\Controllers\Admin\OnlineTestController::class, 'updateSectionVideo'])->name('online-tests.section-video.update');
        Route::get('/online-tests/{slug}/package-bank', [App\Http\Controllers\Admin\OnlineTestController::class, 'packageBank'])->name('online-tests.package-bank');
        Route::post('/online-tests/{slug}/package-bank', [App\Http\Controllers\Admin\OnlineTestController::class, 'updatePackageBank'])->name('online-tests.package-bank.update');
        Route::get('/online-tests/{slug}/paket{package}/{section}/answer-key', [App\Http\Controllers\Admin\OnlineTestController::class, 'editPackageAnswerKey'])->whereNumber('package')->name('online-tests.package-answer-key.edit');
        Route::post('/online-tests/{slug}/paket{package}/{section}/answer-key', [App\Http\Controllers\Admin\OnlineTestController::class, 'updatePackageAnswerKey'])->whereNumber('package')->name('online-tests.package-answer-key.update');
        Route::get('/online-tests/{slug}/paket{package}/{section}/answer-key/json', [App\Http\Controllers\Admin\OnlineTestController::class, 'packageAnswerKeyJson'])->whereNumber('package')->name('online-tests.package-answer-key.json');
        Route::post('/online-tests/{slug}/paket{package}/{section}/answer-key/json', [App\Http\Controllers\Admin\OnlineTestController::class, 'updatePackageAnswerKeyJson'])->whereNumber('package')->name('online-tests.package-answer-key.json.update');
        Route::get('/online-tests/toefl-score', [App\Http\Controllers\Admin\OnlineTestController::class, 'editToeflScore'])->name('online-tests.toefl-score.edit');
        Route::post('/online-tests/toefl-score', [App\Http\Controllers\Admin\OnlineTestController::class, 'updateToeflScore'])->name('online-tests.toefl-score.update');
        Route::get('/online-tests/reference/availability', [App\Http\Controllers\Admin\OnlineTestController::class, 'referenceAvailability'])->name('online-tests.reference.availability');
        Route::post('/online-tests/reference/suggestion', [App\Http\Controllers\Admin\OnlineTestController::class, 'referenceSuggestion'])->name('online-tests.reference.suggestion');
        
        // Offline Tests
        Route::get('/offline-tests', [App\Http\Controllers\Admin\OfflineTestController::class, 'index'])->name('offline-tests.index');
        Route::get('/offline-tests/create', [App\Http\Controllers\Admin\OfflineTestController::class, 'create'])->name('offline-tests.create');
        Route::post('/offline-tests', [App\Http\Controllers\Admin\OfflineTestController::class, 'store'])->name('offline-tests.store');
        Route::post('/offline-tests/import', [App\Http\Controllers\Admin\OfflineTestController::class, 'import'])->name('offline-tests.import');
        Route::post('/offline-tests/{id}/resend', [App\Http\Controllers\Admin\OfflineTestController::class, 'resendCertificate'])->name('offline-tests.resend');
        Route::delete('/offline-tests/{id}', [App\Http\Controllers\Admin\OfflineTestController::class, 'destroy'])->name('offline-tests.destroy');

        // Offline Test Certificates
        Route::get('/offline-test-certificates', [App\Http\Controllers\Admin\OfflineTestCertificateController::class, 'index'])->name('offline-test-certificates.index');
        Route::post('/offline-test-certificates', [App\Http\Controllers\Admin\OfflineTestCertificateController::class, 'update'])->name('offline-test-certificates.update');
        Route::get('/offline-test-certificates/preview', [App\Http\Controllers\Admin\OfflineTestCertificateController::class, 'preview'])->name('offline-test-certificates.preview');
        Route::post('/offline-test-certificates/upload-background', [App\Http\Controllers\Admin\OfflineTestCertificateController::class, 'uploadBackground'])->name('offline-test-certificates.upload-background');
        Route::get('/offline-test-certificates/{id}/background', [App\Http\Controllers\Admin\OfflineTestCertificateController::class, 'backgroundImage'])->name('offline-test-certificates.background');
        Route::get('/offline-test-certificates/{id}/signature', [App\Http\Controllers\Admin\OfflineTestCertificateController::class, 'signatureImage'])->name('offline-test-certificates.signature');
        Route::get('/offline-test-certificates/{id}/stamp', [App\Http\Controllers\Admin\OfflineTestCertificateController::class, 'stampImage'])->name('offline-test-certificates.stamp');

        Route::get('/online-test-results', [App\Http\Controllers\Admin\OnlineTestResultController::class, 'index'])->name('online-test-results.index');
        Route::get('/online-test-results/{id}', [App\Http\Controllers\Admin\OnlineTestResultController::class, 'show'])->whereNumber('id')->name('online-test-results.show');
        Route::patch('/online-test-results/{id}/status', [App\Http\Controllers\Admin\OnlineTestResultController::class, 'updateStatus'])->whereNumber('id')->name('online-test-results.update-status');
        Route::get('/online-test-results/{id}/certificate', [App\Http\Controllers\Admin\OnlineTestResultController::class, 'certificate'])->whereNumber('id')->name('online-test-results.certificate');
        Route::get('/final-test-results', [App\Http\Controllers\Admin\FinalTestResultController::class, 'index'])->name('final-test-results.index');
        Route::get('/final-test-results/{id}', [App\Http\Controllers\Admin\FinalTestResultController::class, 'show'])->whereNumber('id')->name('final-test-results.show');
        Route::patch('/final-test-results/{id}/status', [App\Http\Controllers\Admin\FinalTestResultController::class, 'updateStatus'])->whereNumber('id')->name('final-test-results.update-status');
        Route::put('/final-test-results/{id}/evaluation', [App\Http\Controllers\Admin\FinalTestResultController::class, 'updateEvaluation'])->whereNumber('id')->name('final-test-results.update-evaluation');
        Route::post('/final-test-results/{id}/re-evaluate', [App\Http\Controllers\Admin\FinalTestResultController::class, 'reEvaluate'])->whereNumber('id')->name('final-test-results.re-evaluate');
        Route::delete('/final-test-results/{id}', [App\Http\Controllers\Admin\FinalTestResultController::class, 'destroy'])->whereNumber('id')->name('final-test-results.destroy');
        Route::get('/final-test-results/{id}/certificate', [App\Http\Controllers\Admin\FinalTestResultController::class, 'certificate'])->whereNumber('id')->name('final-test-results.certificate');
        Route::get('/final-test-results/search-students', [App\Http\Controllers\Admin\FinalTestResultController::class, 'searchStudents'])->name('final-test-results.search-students');
        Route::post('/final-test-results/manual-issue', [App\Http\Controllers\Admin\FinalTestResultController::class, 'manualIssue'])->name('final-test-results.manual-issue');
        // Admin: fetch class period meetings (returns JSON)
        Route::get('/class-periods/{classPeriod}/meetings', [App\Http\Controllers\TeacherAttendanceController::class, 'getMeetings'])
            ->whereNumber('classPeriod')
            ->name('class-periods.meetings');
    });

    // Scholarships Routes
    Route::get('/scholarships', [App\Http\Controllers\ScholarshipController::class, 'index'])->name('scholarships.index');
    Route::get('/scholarships/{scholarship}', [App\Http\Controllers\ScholarshipController::class, 'show'])->name('scholarships.show');

    Route::get('/mock-test', function () {
        return view('mock-test.index');
    })->name('mock-test');

    Route::get('/mock-test/toefl-itp', [App\Http\Controllers\ToeflMockupController::class, 'index'])->name('mock-test.toefl-itp');
    Route::get('/mock-test/ielts-academic', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'index'])->name('mock-test.ielts-academic');
    Route::get('/mock-test/ielts-academic/cambridge', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'index'])->name('mock-test.ielts-academic.cambridge');
    Route::get('/mock-test/ielts-academic/cambridge/{edition}', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'edition'])->name('mock-test.ielts-academic.cambridge.edition');
    Route::get('/mock-test/ielts-general', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'index'])->name('mock-test.ielts-general');
    Route::get('/mock-test/ielts-general/cambridge', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'index'])->name('mock-test.ielts-general.cambridge');
    Route::get('/mock-test/ielts-general/cambridge/{edition}', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'edition'])->name('mock-test.ielts-general.cambridge.edition');

    Route::get('/assignments', [App\Http\Controllers\AssignmentController::class, 'index'])
        ->name('assignments.index')
        ;
    Route::get('/assignments/final-test', function () {
        return redirect()->route('final-test');
    })->name('assignments.final-test')
        ;

    Route::get('/final-test', [App\Http\Controllers\AssignmentController::class, 'finalTestIndex'])
        ->name('final-test')
        ;

    // Admin manage final test (shows editor UI for admins)
    Route::get('/admin/manage-final-test', [App\Http\Controllers\AssignmentController::class, 'finalTestIndex'])
        ->name('admin.manage-final-test')
        ->middleware(['role:admin', 'check.assignment.program.access']);

    Route::post('/final-test/settings', [App\Http\Controllers\AssignmentController::class, 'updateFinalTestSettings'])
        ->name('final-test.settings.update')
        ->middleware(['role:admin', 'check.assignment.program.access']);

    Route::get('/final-test/results/{result}', [App\Http\Controllers\AssignmentController::class, 'showFinalTestResult'])
        ->whereNumber('result')
        ->name('final-test.results.show')
        ;

    Route::get('/final-test/results/{result}/certificate', [App\Http\Controllers\AssignmentController::class, 'downloadFinalTestCertificate'])
        ->whereNumber('result')
        ->name('final-test.certificate.download')
        ;

    Route::get('/offline-test/results/{id}/certificate', [App\Http\Controllers\AssignmentController::class, 'downloadOfflineTestCertificate'])
        ->name('offline-test.certificate.download');

    Route::post('/final-test/{program}/{variant?}/complete', [App\Http\Controllers\AssignmentController::class, 'completeFinalTest'])
        ->where('program', 'grammar-for-writing|toefl-itp|ielts-academic|pte-academic|ielts-general|speaking')
        ->where('variant', 'introductory|complexity|proficiency|fast-track|intermediate|advanced')
        ->name('final-test.complete')
        ;

    Route::get('/final-test/{program}/{variant?}', [App\Http\Controllers\AssignmentController::class, 'finalTestProgram'])
        ->where('program', 'grammar-for-writing|toefl-itp|ielts-academic|pte-academic|ielts-general|speaking')
        ->where('variant', 'introductory|complexity|proficiency|fast-track|intermediate|advanced')
        ->name('final-test.show')
        ;

    // Meetings: allow authenticated users (students/teachers/admins) to fetch meetings for a class period
    Route::get('/class-periods/{classPeriod}/meetings', [App\Http\Controllers\TeacherAttendanceController::class, 'getMeetings'])
        ->whereNumber('classPeriod')
        ->name('class-periods.meetings');

    // Update meeting date (PATCH) - only authorized users allowed by controller
    Route::patch('/class-meetings/{classMeeting}', [App\Http\Controllers\TeacherAttendanceController::class, 'updateMeeting'])
        ->whereNumber('classMeeting')
        ->name('class-meetings.update');

    // Note: the admin group earlier also exposes /admin/class-periods/{classPeriod}/meetings — keep both for backwards compatibility.

    Route::get('/assignments/final-test/{program}/{variant?}', function (string $program, ?string $variant = null) {
        return redirect()->route('final-test.show', array_filter([
            'program' => $program,
            'variant' => $variant,
        ]));
    })->where('program', 'grammar-for-writing|toefl-itp|ielts-academic|pte-academic|ielts-general|speaking')
        ->where('variant', 'introductory|complexity|proficiency|fast-track|intermediate|advanced')
        ->name('assignments.final-test.show')
        ;

    // Cleanup Route (Temporary) - Outside this block in next step or just accessed via browser tool logged in?
    // Actually, I'll just remove it from here and put it at the top of the file in a separate replace call if needed, 
    // but the tool allows me to just replace this block.
    // Let's just remove it from here and add it at line 5.
    
    Route::get('/ielts/academic', [App\Http\Controllers\AssignmentController::class, 'ieltsAcademic'])
        ->name('assignments.ielts-academic')
        ;
    Route::get('/assignments/pte-academic', [App\Http\Controllers\AssignmentController::class, 'pteAcademic'])
        ->name('assignments.pte-academic')
        ;

    Route::get('/assignments/pte-academic/speaking-writing', function () {
        return view('assignments.pte-academic.speaking-writing');
    })->name('assignments.pte-academic.speaking-writing.index');

    Route::get('/assignments/pte-academic/speaking-writing/personal-introduction', function () {
        return view('assignments.pte-academic.personal-introduction.practice');
    })->name('assignments.pte-academic.speaking-writing.personal-introduction.practice');

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
    })->name('assignments.pte-academic.speaking-writing.read-aloud.index');

    Route::get('/assignments/pte-academic/speaking-writing/read-aloud/{id}', function ($id) {
        $hardcoded = config('pte_read_aloud', []);
        $topic = isset($hardcoded[$id]) ? $hardcoded[$id] : ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT), 'content' => 'Content for topic ' . $id . ' will be added soon.'];

        return view('assignments.pte-academic.read-aloud.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.read-aloud.practice');

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
    })->name('assignments.pte-academic.speaking-writing.repeat-sentence.index');

    Route::get('/assignments/pte-academic/speaking-writing/repeat-sentence/{id}', function ($id) {
        $hardcoded = config('pte_repeat_sentence', []);
        $topic = isset($hardcoded[$id]) ? $hardcoded[$id] : ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT), 'content' => 'Please repeat this sentence carefully and clearly for topic number ' . $id . '.'];

        return view('assignments.pte-academic.repeat-sentence.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.repeat-sentence.practice');

    Route::get('/assignments/pte-academic/speaking-writing/describe-image', function () {
        $hardcoded = config('pte_describe_image', []);
        $topics = [];
        foreach ($hardcoded as $i => $data) {
            $topics[$i] = $data;
        }
        return view('assignments.pte-academic.describe-image.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.describe-image.index');

    Route::get('/assignments/pte-academic/speaking-writing/describe-image/{id}', function ($id) {
        $hardcoded = config('pte_describe_image', []);
        $topic = isset($hardcoded[$id]) ? $hardcoded[$id] : ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT), 'content' => 'Please describe the image shown below for topic number ' . $id . '.'];
        $totalTopics = count($hardcoded) ?: 300;
        return view('assignments.pte-academic.describe-image.practice', ['topicId' => $id, 'topic' => $topic, 'totalTopics' => $totalTopics]);
    })->name('assignments.pte-academic.speaking-writing.describe-image.practice');

    Route::get('/assignments/pte-academic/speaking-writing/retell-lecture', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.retell-lecture.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.retell-lecture.index');

    Route::get('/assignments/pte-academic/speaking-writing/retell-lecture/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.retell-lecture.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.retell-lecture.practice');

    Route::get('/assignments/pte-academic/speaking-writing/summarize-group-discussion', function () {
        $topics = [];
        for ($i = 1; $i <= 100; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.summarize-group-discussion.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.summarize-group-discussion.index');

    Route::get('/assignments/pte-academic/speaking-writing/summarize-group-discussion/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.summarize-group-discussion.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.summarize-group-discussion.practice');

    Route::get('/assignments/pte-academic/speaking-writing/respond-to-a-situation', function () {
        $topics = config('pte_respond_to_a_situation') ?? [];
        if (empty($topics)) {
            for ($i = 1; $i <= 100; $i++) {
                $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
            }
        }
        return view('assignments.pte-academic.respond-to-a-situation.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.respond-to-a-situation.index');

    Route::get('/assignments/pte-academic/speaking-writing/respond-to-a-situation/{id}', function ($id) {
        $rs_topics = config('pte_respond_to_a_situation') ?? [];
        $data = $rs_topics[$id] ?? ($rs_topics[$id - 1] ?? null);
        $topic = [
            'title' => $data['title'] ?? ('Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)),
            'prompt' => $data['prompt'] ?? null,
            'transcript' => $data['transcript'] ?? null,
            'sample_answer' => $data['sample_answer'] ?? null,
        ];
        $totalTopics = count($rs_topics) ?: 100;
        return view('assignments.pte-academic.respond-to-a-situation.practice', ['topicId' => $id, 'topic' => $topic, 'totalTopics' => $totalTopics]);
    })->name('assignments.pte-academic.speaking-writing.respond-to-a-situation.practice');

    Route::get('/assignments/pte-academic/speaking-writing/answer-short-question', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.answer-short-question.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.answer-short-question.index');

    Route::get('/assignments/pte-academic/speaking-writing/answer-short-question/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.answer-short-question.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.answer-short-question.practice');

    Route::get('/assignments/pte-academic/speaking-writing/summarize-written-text', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.summarize-written-text.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.summarize-written-text.index');

    Route::get('/assignments/pte-academic/speaking-writing/summarize-written-text/{id}', function ($id) {
        $topic = ['title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT)];
        return view('assignments.pte-academic.summarize-written-text.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.summarize-written-text.practice');

    Route::get('/assignments/pte-academic/speaking-writing/write-essay', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.write-essay.index', compact('topics'));
    })->name('assignments.pte-academic.speaking-writing.write-essay.index');

    Route::get('/assignments/pte-academic/speaking-writing/write-essay/{id}', function ($id) {
        $prompts = config('pte_essay_topics') ?? [];
        $prompt = $prompts[$id - 1] ?? 'Do you agree that technology has had a more positive than negative impact on the quality of education? Discuss both views and give your own opinion. Write 200–300 words.';
        $topic = [
            'title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'prompt' => $prompt
        ];
        return view('assignments.pte-academic.write-essay.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.speaking-writing.write-essay.practice');

    Route::get('/assignments/pte-academic/reading', function () {
        return view('assignments.pte-academic.reading');
    })->name('assignments.pte-academic.reading.index');

    Route::get('/assignments/pte-academic/reading/reading-writing-fill-blanks', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.reading-writing-fill-blanks.index', compact('topics'));
    })->name('assignments.pte-academic.reading.reading-writing-fill-blanks.index');

    Route::get('/assignments/pte-academic/reading/reading-writing-fill-blanks/{id}', function ($id) {
        $passages = config('pte_rw_fib_topics') ?? [];
        $passage = $passages[$id - 1] ?? 'Placeholder passage...';
        $topic = [
            'title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'passage' => $passage
        ];
        return view('assignments.pte-academic.reading-writing-fill-blanks.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.reading-writing-fill-blanks.practice');

    Route::get('/assignments/pte-academic/reading/multiple-choice-multiple-answer', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.multiple-choice-multiple-answer.index', compact('topics'));
    })->name('assignments.pte-academic.reading.multiple-choice-multiple-answer.index');

    Route::get('/assignments/pte-academic/reading/multiple-choice-multiple-answer/{id}', function ($id) {
        $mcma_topics = config('pte_reading_mcma_topics') ?? [];
        $data = $mcma_topics[$id - 1] ?? [
            'passage' => 'Placeholder passage...',
            'question' => 'Placeholder question?',
            'options' => ['Option A', 'Option B', 'Option C', 'Option D', 'Option E'],
            'answers' => ['A']
        ];
        $topic = [
            'title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'passage' => $data['passage'],
            'question' => $data['question'],
            'options' => $data['options'],
            'answers' => $data['answers']
        ];
        return view('assignments.pte-academic.multiple-choice-multiple-answer.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.multiple-choice-multiple-answer.practice');

    Route::get('/assignments/pte-academic/reading/reorder-paragraphs', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.reorder-paragraphs.index', compact('topics'));
    })->name('assignments.pte-academic.reading.reorder-paragraphs.index');

    Route::get('/assignments/pte-academic/reading/reorder-paragraphs/{id}', function ($id) {
        $reorder_topics = config('pte_reading_reorder_paragraphs_topics') ?? [];
        $data = $reorder_topics[$id - 1] ?? [
            'paragraphs' => [
                'Globalization has increased the popularity of international cuisines.',
                'This curiosity has led to a rise in ethnic restaurants and food festivals.',
                'Yet, this trend also challenges traditional food industries to innovate and adapt to changing consumer preferences.',
                'People are now more adventurous in their food choices, exploring dishes from different cultures.'
            ],
            'correctOrder' => ['A', 'D', 'B', 'C']
        ];
        $topic = [
            'title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'paragraphs' => $data['paragraphs'],
            'correctOrder' => $data['correctOrder']
        ];
        return view('assignments.pte-academic.reorder-paragraphs.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.reorder-paragraphs.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/reading-fill-blanks', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.reading-fill-blanks.index', compact('topics'));
    })->name('assignments.pte-academic.reading.reading-fill-blanks.index');

    Route::get('/assignments/pte-academic/reading/reading-fill-blanks/{id}', function ($id) {
        $fib_topics = config('pte_reading_fill_blanks_topics') ?? [];
        $data = $fib_topics[$id - 1] ?? [
            'passage' => 'Coding languages, <div class="blank-space dropzone" data-id="blank1"></div> to modern technology, emerged from the convergence of mathematical logic and electronic engineering. Initially <div class="blank-space dropzone" data-id="blank2"></div> for specific tasks, they evolved to create complex systems and applications. Python, known for its simplicity and readability, has become widely used in <div class="blank-space dropzone" data-id="blank3"></div> fields from web development to data science. Moreover, it is constantly evolving and improving, as new features and enhancements are <div class="blank-space dropzone" data-id="blank4"></div> into the language and its library every year.',
            'words' => ['diverse', 'reverse', 'incorporated', 'integral', 'frugal', 'mixed', 'developed'],
            'correctAnswers' => [
                'blank1' => 'integral',
                'blank2' => 'developed',
                'blank3' => 'diverse',
                'blank4' => 'incorporated'
            ]
        ];
        $topic = [
            'title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'passage' => $data['passage'],
            'words' => $data['words'],
            'correctAnswers' => $data['correctAnswers']
        ];
        return view('assignments.pte-academic.reading-fill-blanks.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.reading-fill-blanks.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/reading/multiple-choice-single-answer', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.multiple-choice-single-answer.index', compact('topics'));
    })->name('assignments.pte-academic.reading.multiple-choice-single-answer.index');

    Route::get('/assignments/pte-academic/reading/multiple-choice-single-answer/{id}', function ($id) {
        $mcsa_topics = config('pte_reading_mcsa_topics') ?? [];
        $data = $mcsa_topics[$id - 1] ?? [
            'passage' => 'B-15 broke off from the Ross Ice Shelf in Antarctica. It was the largest iceberg ever documented, with a surface area of more than 4,200 square miles - more than twice the size of the state of Delaware. After it started breaking up, the largest of its pieces, B-15a, drifted along the coast of Antarctica, lingered on a shallow seamount, and collided with an ice tongue, before running aground and breaking again. Late in 2007, the largest remaining chunk floated out into the South Pacific where, in the warmer water, it began to disintegrate.',
            'question' => 'Where did the largest piece off from B-15 eventually go?',
            'options' => ['Chile', 'South Pacific', 'Seafloor', 'Antarctica'],
            'correctAnswer' => 'B'
        ];
        $topic = [
            'title' => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'passage' => $data['passage'],
            'question' => $data['question'],
            'options' => $data['options'],
            'correctAnswer' => $data['correctAnswer']
        ];
        return view('assignments.pte-academic.multiple-choice-single-answer.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.reading.multiple-choice-single-answer.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening', function () {
        return view('assignments.pte-academic.listening');
    })->name('assignments.pte-academic.listening.index');

    Route::get('/assignments/pte-academic/listening/summarize-spoken-text', function () {
        $topics = [];
        for ($i = 1; $i <= 300; $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.summarize-spoken-text.index', compact('topics'));
    })->name('assignments.pte-academic.listening.summarize-spoken-text.index');

    Route::get('/assignments/pte-academic/listening/summarize-spoken-text/{id}', function ($id) {
        $sst_topics = config('pte_listening_sst_topics');
        $data = $sst_topics[$id - 1] ?? [];
        
        $topic = [
            'title'    => 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'transcript' => $data['transcript'] ?? 'Fallback transcript.',
            'voice'    => $data['voice'] ?? 'af_heart',
            'filename' => 'topic_' . str_pad($id, 3, '0', STR_PAD_LEFT) . '.mp3',
            'folder'   => 'kokoro-tts/listening-summarize-spoken-text',
        ];
        return view('assignments.pte-academic.summarize-spoken-text.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.summarize-spoken-text.practice')->middleware('check.assignment.program.access');

    Route::get('/assignments/pte-academic/listening/listening-multiple-choice-multiple-answer', function () {
        $topics = [];
        $mcma_topics = config('pte_listening_mcma') ?? [];
        for ($i = 1; $i <= count($mcma_topics); $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-multiple-choice-multiple-answer.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-multiple-choice-multiple-answer.index');

    Route::get('/assignments/pte-academic/listening/listening-multiple-choice-multiple-answer/{id}', function ($id) {
        $mcma_topics = config('pte_listening_mcma') ?? [];
        $topic = $mcma_topics[$id - 1] ?? null;
        if (!$topic) {
            abort(404);
        }
        $topic['title'] = 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('assignments.pte-academic.listening-multiple-choice-multiple-answer.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-multiple-choice-multiple-answer.practice');

    Route::get('/assignments/pte-academic/listening/listening-fill-blanks', function () {
        $topics = [];
        $fib_topics = config('pte_listening_fib') ?? [];
        for ($i = 1; $i <= count($fib_topics); $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-fill-blanks.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-fill-blanks.index');

    Route::get('/assignments/pte-academic/listening/listening-fill-blanks/{id}', function ($id) {
        $fib_topics = config('pte_listening_fib') ?? [];
        $topic = $fib_topics[$id - 1] ?? null;
        if (!$topic) {
            abort(404);
        }
        $topic['title'] = 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('assignments.pte-academic.listening-fill-blanks.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-fill-blanks.practice');

    Route::get('/assignments/pte-academic/listening/listening-highlight-correct-summary', function () {
        $topics = [];
        $hcs_topics = config('pte_highlight_correct_summary') ?? [];
        for ($i = 1; $i <= count($hcs_topics); $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-highlight-correct-summary.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-highlight-correct-summary.index');

    Route::get('/assignments/pte-academic/listening/listening-highlight-correct-summary/{id}', function ($id) {
        $hcs_topics = config('pte_highlight_correct_summary') ?? [];
        $topic = $hcs_topics[$id - 1] ?? null;
        if (!$topic) {
            abort(404);
        }
        $topic['title'] = 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('assignments.pte-academic.listening-highlight-correct-summary.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-highlight-correct-summary.practice');

    Route::get('/assignments/pte-academic/listening/listening-multiple-choice-single-answer', function () {
        $topics = [];
        $mcsa_topics = config('pte_listening_mcsa') ?? [];
        for ($i = 1; $i <= count($mcsa_topics); $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-multiple-choice-single-answer.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-multiple-choice-single-answer.index');

    Route::get('/assignments/pte-academic/listening/listening-multiple-choice-single-answer/{id}', function ($id) {
        $mcsa_topics = config('pte_listening_mcsa') ?? [];
        $topic = $mcsa_topics[$id - 1] ?? null;
        if (!$topic) {
            abort(404);
        }
        $topic['title'] = 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('assignments.pte-academic.listening-multiple-choice-single-answer.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-multiple-choice-single-answer.practice');

    Route::get('/assignments/pte-academic/listening/listening-select-missing-word', function () {
        $topics = [];
        $smw_topics = config('pte_select_missing_word') ?? [];
        for ($i = 1; $i <= count($smw_topics); $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-select-missing-word.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-select-missing-word.index');

    Route::get('/assignments/pte-academic/listening/listening-select-missing-word/{id}', function ($id) {
        $smw_topics = config('pte_select_missing_word') ?? [];
        $topic = $smw_topics[$id - 1] ?? null;
        if (!$topic) {
            abort(404);
        }
        $topic['title'] = 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('assignments.pte-academic.listening-select-missing-word.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-select-missing-word.practice');

    Route::get('/assignments/pte-academic/listening/listening-highlight-incorrect-words', function () {
        $topics = [];
        $hiw_topics = config('pte_highlight_incorrect_words') ?? [];
        for ($i = 1; $i <= count($hiw_topics); $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-highlight-incorrect-words.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-highlight-incorrect-words.index');

    Route::get('/assignments/pte-academic/listening/listening-highlight-incorrect-words/{id}', function ($id) {
        $hiw_topics = config('pte_highlight_incorrect_words') ?? [];
        $topic = $hiw_topics[$id - 1] ?? null;
        if (!$topic) {
            abort(404);
        }
        $topic['title'] = 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('assignments.pte-academic.listening-highlight-incorrect-words.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-highlight-incorrect-words.practice');

    Route::get('/assignments/pte-academic/listening/listening-write-from-dictation', function () {
        $topics = [];
        $wfd_topics = config('pte_write_from_dictation') ?? [];
        for ($i = 1; $i <= count($wfd_topics); $i++) {
            $topics[$i] = ['title' => 'Topic ' . str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return view('assignments.pte-academic.listening-write-from-dictation.index', compact('topics'));
    })->name('assignments.pte-academic.listening.listening-write-from-dictation.index');

    Route::get('/assignments/pte-academic/listening/listening-write-from-dictation/{id}', function ($id) {
        $wfd_topics = config('pte_write_from_dictation') ?? [];
        $topic = $wfd_topics[$id - 1] ?? null;
        if (!$topic) {
            abort(404);
        }
        $topic['title'] = 'Topic ' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('assignments.pte-academic.listening-write-from-dictation.practice', ['topicId' => $id, 'topic' => $topic]);
    })->name('assignments.pte-academic.listening.listening-write-from-dictation.practice');

    // PTE Academic API Scoring Routes
    Route::get('/pte/practice/stats/{module}', [App\Http\Controllers\PtePracticeController::class, 'moduleStats'])
        ->name('pte.practice.stats.module');
    Route::post('/pte/practice/bookmark', [App\Http\Controllers\PtePracticeController::class, 'toggleBookmark'])
        ->name('pte.practice.bookmark');
    Route::get('/pte/practice/stats/{module}/{topic_id}', [App\Http\Controllers\PtePracticeController::class, 'topicStats'])
        ->name('pte.practice.stats.topic');
    Route::post('/pte/practice/evaluate-speaking', [App\Http\Controllers\PtePracticeController::class, 'evaluateSpeaking'])
        ->name('pte.practice.evaluate.speaking');
    Route::post('/pte/practice/evaluate-writing', [App\Http\Controllers\PtePracticeController::class, 'evaluateWriting'])
        ->name('pte.practice.evaluate.writing');
    Route::post('/pte/practice/save-score', [App\Http\Controllers\PtePracticeController::class, 'saveScore'])
        ->name('pte.practice.save-score');

    Route::get('/assignments/ielts-general', [App\Http\Controllers\AssignmentController::class, 'ieltsGeneral'])
        ->name('assignments.ielts-general')
        ;

    // IELTS Academic Listening Routes
    Route::get('/assignments/ielts-academic/listening', [App\Http\Controllers\IeltsListeningController::class, 'index'])
        ->name('assignments.ielts-academic.listening.index')
        ;
    Route::get('/assignments/ielts-academic/listening/material/{id}', [App\Http\Controllers\IeltsListeningController::class, 'material'])
        ->name('assignments.ielts-academic.listening.material')
        ;
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-audio', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadMaterialAudio'])
        ->name('assignments.ielts-academic.listening.material.upload-audio')
        ;
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-srt', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadMaterialSrt'])
        ->name('assignments.ielts-academic.listening.material.upload-srt')
        ;
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-answer-key', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadMaterialAnswerKey'])
        ->name('assignments.ielts-academic.listening.material.upload-answer-key')
        ;
    Route::get('/assignments/ielts-academic/listening/practice-index', [App\Http\Controllers\IeltsListeningController::class, 'practiceIndex'])
        ->name('assignments.ielts-academic.listening.practice.index')
        ;
    Route::get('/assignments/ielts-academic/listening/practice-index/part{set}', [App\Http\Controllers\IeltsListeningController::class, 'practiceIndexPart'])
        ->name('assignments.ielts-academic.listening.practice-index.part')
        ;
    Route::get('/assignments/ielts-academic/speaking/practice-index', [App\Http\Controllers\IeltsSpeakingController::class, 'practiceIndex'])->name('assignments.ielts-academic.speaking.practice.index');
    Route::get('/assignments/ielts-academic/speaking/practice-index/part{part}', [App\Http\Controllers\IeltsSpeakingController::class, 'practiceIndexPart'])->name('assignments.ielts-academic.speaking.practice-index.part');
    Route::get('/assignments/ielts-academic/writing/practice-index', [App\Http\Controllers\IeltsWritingController::class, 'practiceIndex'])->name('assignments.ielts-academic.writing.practice.index');

    Route::get('/assignments/ielts-academic/writing/practice-index/grammar-practice', [App\Http\Controllers\IeltsWritingController::class, 'grammarPractice'])->name('assignments.ielts-academic.writing.grammar-practice');
    Route::get('/assignments/ielts-academic/listening/warm-up/{type}', [App\Http\Controllers\IeltsListeningController::class, 'warmUp'])->name('assignments.ielts-academic.listening.warmup');
    
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
    Route::post('/assignments/ielts-academic/listening/practice-draft', [App\Http\Controllers\IeltsListeningController::class, 'saveDraft'])->name('assignments.ielts-academic.listening.practice-draft');
    

    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/upload-audio', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadAudio'])->name('assignments.ielts.listening.upload-audio');
    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/upload-srt', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadTranscript'])->name('assignments.ielts.listening.upload-srt');
    Route::post('/assignments/ielts-academic/listening/practice/{meeting}/part/{set}/upload-answer-key', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadSectionAnswerKey'])->name('assignments.ielts.listening.upload-answer-key');
    Route::post('/assignments/ielts-academic/listening/material/{id}/upload-answer-key-practice', [App\Http\Controllers\IeltsListeningAdminController::class, 'uploadMaterialPracticeAnswerKey'])->name('assignments.ielts-academic.listening.material.upload-answer-key-practice');

    // IELTS Academic Reading Routes
    Route::get('/assignments/ielts-academic/reading', [App\Http\Controllers\IeltsReadingController::class, 'index'])->name('assignments.ielts-academic.reading.index');
    Route::get('/assignments/ielts-academic/reading/material/{id}', [App\Http\Controllers\IeltsReadingController::class, 'material'])->name('assignments.ielts-academic.reading.material');
    Route::get('/assignments/ielts-academic/reading/practice-index', [App\Http\Controllers\IeltsReadingController::class, 'practiceIndex'])->name('assignments.ielts-academic.reading.practice-index');
    Route::post('/assignments/ielts-academic/reading/practice-submit', [App\Http\Controllers\IeltsReadingController::class, 'submitPractice'])->name('assignments.ielts-academic.reading.practice-submit');
    Route::post('/assignments/ielts-academic/reading/practice-draft', [App\Http\Controllers\IeltsReadingController::class, 'saveDraft'])->name('assignments.ielts-academic.reading.practice-draft');
    Route::get('/assignments/ielts-academic/reading/skill/{skill}', [App\Http\Controllers\IeltsReadingController::class, 'skill'])->name('assignments.ielts-academic.reading.skill');
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
    Route::post('/assignments/ielts-academic/mockup/cambridge/{edition}/test-{id}/transcribe', [App\Http\Controllers\IeltsCambridgeMockupController::class, 'transcribeAudio'])->name('assignments.ielts-academic.mockup.cambridge.transcribe');
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
    Route::post('/assignments/ielts-academic/writing/submission/{submission}/retry', [App\Http\Controllers\IeltsWritingController::class, 'retryEvaluate'])->name('assignments.ielts.writing.submission.retry');
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
    Route::get('/assignments/ielts-academic/speaking/tts-stream', [App\Http\Controllers\OnlineTestController::class, 'streamKokoroSpeech'])->name('assignments.ielts-academic.speaking.tts-stream');
    Route::get('/assignments/ielts-academic/speaking/practice', [App\Http\Controllers\IeltsSpeakingController::class, 'practice'])->name('assignments.ielts-academic.speaking.practice');
    Route::post('/assignments/ielts-academic/speaking/practice/grade', [App\Http\Controllers\IeltsSpeakingController::class, 'grade'])->name('assignments.ielts-academic.speaking.practice.grade');

    Route::get('/assignments/ielts-academic/speaking/practice/evaluation', [App\Http\Controllers\IeltsSpeakingController::class, 'evaluation'])->name('assignments.ielts-academic.speaking.evaluation');
    Route::post('/assignments/ielts-academic/speaking/practice/upgrade-lexical', [App\Http\Controllers\IeltsSpeakingController::class, 'upgradeLexical'])->name('assignments.ielts-academic.speaking.upgrade-lexical');
    Route::post('/assignments/ielts-academic/speaking/practice/collocations', [App\Http\Controllers\IeltsSpeakingController::class, 'suggestCollocations'])->name('assignments.ielts-academic.speaking.collocations');
    
    // Speaking Topics CRUD
    Route::post('/admin/ielts-speaking/topics', [App\Http\Controllers\IeltsSpeakingAdminController::class, 'storeTopic'])->name('admin.ielts.speaking.topics.store');
    Route::put('/admin/ielts-speaking/topics/{id}', [App\Http\Controllers\IeltsSpeakingAdminController::class, 'updateTopic'])->name('admin.ielts.speaking.topics.update');
    Route::put('/admin/ielts-speaking/topics/{id}/questions', [App\Http\Controllers\IeltsSpeakingAdminController::class, 'updateContent'])->name('admin.ielts.speaking.topics.update-questions');
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
    Route::post('/assignments/toefl-itp/structure/{number}/draft', [App\Http\Controllers\ToeflStructureController::class, 'saveDraft'])->name('assignments.toefl-itp.structure.meeting.draft');
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
    Route::get('/assignments/toefl-itp/mock-test', [App\Http\Controllers\ToeflMockupController::class, 'index'])->name('assignments.toefl-itp.mockup');
    Route::redirect('/assignments/toefl-itp/mockup', '/assignments/toefl-itp/mock-test');
    Route::get('/assignments/toefl-itp/mockup/package/{package}', [App\Http\Controllers\ToeflMockupController::class, 'showPackage'])->whereNumber('package')->name('assignments.toefl-itp.mockup.package');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/submit', [App\Http\Controllers\ToeflMockupController::class, 'submit'])->whereNumber('package')->name('assignments.toefl-itp.mockup.submit');
    Route::get('/assignments/mock-tests/results/{result}', [App\Http\Controllers\ToeflMockupController::class, 'showResult'])->whereNumber('result')->name('assignments.mock-tests.results.show');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/upload-audio', [App\Http\Controllers\ToeflMockupController::class, 'uploadAudio'])->whereNumber('package')->name('assignments.toefl-itp.mockup.package.upload-audio');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/upload-srt', [App\Http\Controllers\ToeflMockupController::class, 'uploadSrt'])->whereNumber('package')->name('assignments.toefl-itp.mockup.package.upload-srt');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/update-transcript', [App\Http\Controllers\ToeflMockupController::class, 'updateTranscript'])->whereNumber('package')->name('assignments.toefl-itp.mockup.package.update-transcript');
    Route::post('/assignments/toefl-itp/mockup/package/{package}/question/{question_id}/upload-audio', [App\Http\Controllers\ToeflMockupController::class, 'uploadQuestionAudio'])->whereNumber('package')->whereNumber('question_id')->name('assignments.toefl-itp.mockup.package.question.upload-audio');
    
    Route::get('/assignments/grammar-writing', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingClasses'])->name('assignments.grammar-writing.classes');
    Route::get('/assignments/grammar-writing/practice', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPractice'])->name('assignments.grammar-writing.practice');
    Route::post('/assignments/grammar-writing/practice', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeStore'])->name('assignments.grammar-writing.practice.store')->middleware('role:admin');
    Route::post('/assignments/grammar-writing/practice/reorder', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeReorder'])->name('assignments.grammar-writing.practice.reorder')->middleware('role:admin');
    Route::put('/assignments/grammar-writing/practice/{topic}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeUpdate'])->name('assignments.grammar-writing.practice.update')->middleware('role:admin');
    Route::delete('/assignments/grammar-writing/practice/{topic}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeDestroy'])->name('assignments.grammar-writing.practice.destroy')->middleware('role:admin');
    Route::get('/assignments/grammar-writing/practice/topic/{topic}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeTopic'])->name('assignments.grammar-writing.practice.topic');
    Route::post('/assignments/grammar-writing/practice/topic/{topic}/question', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeQuestionStore'])->name('assignments.grammar-writing.practice.question.store')->middleware('role:admin');
    Route::put('/assignments/grammar-writing/practice/question/{question}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeQuestionUpdate'])->name('assignments.grammar-writing.practice.question.update')->middleware('role:admin');
    Route::delete('/assignments/grammar-writing/practice/question/{question}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeQuestionDestroy'])->name('assignments.grammar-writing.practice.question.destroy')->middleware('role:admin');
    Route::post('/assignments/grammar-writing/practice/topic/{topic}/submit', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeTopicSubmit'])->name('assignments.grammar-writing.practice.topic.submit');
    Route::post('/assignments/grammar-writing/practice/topic/{topic}/reset', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeTopicReset'])->name('assignments.grammar-writing.practice.topic.reset');
    Route::get('/assignments/grammar-writing/practice/level/{level}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingPracticeLevel'])->name('assignments.grammar-writing.practice.level');
    Route::post('/assignments/grammar-writing/ai-proxy', [App\Http\Controllers\GrammarWritingAdminController::class, 'aiProxy'])->name('assignments.grammar-writing.ai-proxy');
    // Admin CRUD for Introductory Topics
    Route::get('/assignments/grammar-writing/intro-topics', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroTopics'])->name('assignments.grammar-writing.intro-topics')->middleware('role:admin');
    Route::post('/assignments/grammar-writing/intro-topics', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroTopicStore'])->name('assignments.grammar-writing.intro-topics.store')->middleware('role:admin');
    Route::put('/assignments/grammar-writing/intro-topics/{topic}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroTopicUpdate'])->name('assignments.grammar-writing.intro-topics.update')->middleware('role:admin');
    Route::delete('/assignments/grammar-writing/intro-topics/{topic}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroTopicDestroy'])->name('assignments.grammar-writing.intro-topics.destroy')->middleware('role:admin');
    Route::post('/assignments/grammar-writing/intro-topics/reorder', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingIntroTopicReorder'])->name('assignments.grammar-writing.intro-topics.reorder')->middleware('role:admin');
    Route::get('/assignments/grammar-writing/introductory', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingTrack'])
        ->defaults('track', 'introductory')
        ->name('assignments.grammar-writing.introductory');
    Route::get('/assignments/grammar-writing/complexity', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingTrack'])
        ->defaults('track', 'complexity')
        ->name('assignments.grammar-writing.complexity');
    Route::get('/assignments/grammar-writing/proficiency', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingTrack'])
        ->defaults('track', 'proficiency')
        ->name('assignments.grammar-writing.proficiency');
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
    Route::post('/assignments/grammar-writing/complexity/meeting/{meeting}/submit', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingComplexityMeetingSubmit'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.complexity.meeting.submit');
    Route::post('/assignments/grammar-writing/complexity/meeting/{meeting}/reset', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingComplexityMeetingReset'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.complexity.meeting.reset');
    Route::get('/assignments/grammar-writing/proficiency/meeting/{meeting}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingProficiencyMeeting'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.proficiency.meeting');
    Route::post('/assignments/grammar-writing/proficiency/meeting/{meeting}/submit', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingProficiencyMeetingSubmit'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.proficiency.meeting.submit');
    Route::get('/assignments/grammar-writing/proficiency/meeting/{meeting}/reset', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingProficiencyMeetingReset'])
        ->whereNumber('meeting')
        ->name('assignments.grammar-writing.proficiency.meeting.reset');
    Route::get('/assignments/grammar-writing/{track}', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWritingTrack'])
        ->whereIn('track', ['introductory', 'complexity', 'proficiency'])
        ->name('assignments.grammar-writing.track');
    
    Route::post('/assignments/grammar-writing/ai-variation', [App\Http\Controllers\GrammarWritingAiPracticeController::class, 'generateVariation'])->name('assignments.grammar-writing.ai-variation');
    Route::post('/assignments/grammar-writing/switch-mode', [App\Http\Controllers\GrammarWritingAiPracticeController::class, 'switchMode'])->name('assignments.grammar-writing.switch-mode');
    Route::get('/assignments/grammar-writing/fast-track/book-pdf', [App\Http\Controllers\GrammarWritingAdminController::class, 'fastTrackBookPdf'])->name('assignments.grammar-writing.fast-track.book-pdf');
    Route::get('/assignments/grammar-writing/fast-track', [App\Http\Controllers\GrammarWritingAdminController::class, 'grammarWriting'])->name('assignments.grammar-writing');
    Route::post('/assignments/grammar-writing/period', [App\Http\Controllers\GrammarWritingAdminController::class, 'updatePeriod'])->name('assignments.grammar-writing.period');
    Route::post('/assignments/batch-period', [App\Http\Controllers\GrammarWritingAdminController::class, 'updateBatchPeriod'])->name('assignments.batch-period');

    Route::get('/assignments/speaking', [App\Http\Controllers\SpeakingAdminController::class, 'speakingClasses'])->name('assignments.speaking.classes');
    Route::get('/assignments/speaking/{level}', [App\Http\Controllers\SpeakingAdminController::class, 'speakingLevel'])
        ->whereIn('level', ['introductory', 'intermediate', 'advanced', 'proficiency', 'super'])
        ->name('assignments.speaking.level');
    Route::get('/assignments/speaking/{level}/meeting/{meeting}', [App\Http\Controllers\SpeakingAdminController::class, 'speakingMeeting'])
        ->whereIn('level', ['introductory', 'intermediate', 'advanced', 'proficiency', 'super'])
        ->whereNumber('meeting')
        ->name('assignments.speaking.meeting');
    Route::get('/assignments/speaking/fast-track', [App\Http\Controllers\SpeakingAdminController::class, 'speaking'])->name('assignments.speaking');
    Route::post('/assignments/meeting/{meeting}/toggle-lock', [App\Http\Controllers\GrammarWritingAdminController::class, 'toggleLock'])->name('assignments.meeting.toggle-lock');
    Route::get('/assignments/grammar-writing/fast-track/meeting1', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2'])->name('assignments.grammar-writing.meeting1');
    Route::post('/assignments/grammar-writing/fast-track/meeting1', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2Submit'])->name('assignments.grammar-writing.meeting1.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting1/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2Reset'])->name('assignments.grammar-writing.meeting1.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting2', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2Practice'])->name('assignments.grammar-writing.meeting2');
    Route::post('/assignments/grammar-writing/fast-track/meeting2', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2PracticeSubmit'])->name('assignments.grammar-writing.meeting2.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting2/reset', [App\Http\Controllers\GrammarWritingSessionController::class, 'meeting2PracticeReset'])->name('assignments.grammar-writing.meeting2.reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting3', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting3'])->name('assignments.grammar-writing.meeting3');
    Route::post('/assignments/grammar-writing/fast-track/meeting3', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting3Submit'])->name('assignments.grammar-writing.meeting3.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting{meeting}/draft', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meetingDraft'])->whereNumber('meeting')->name('assignments.grammar-writing.meeting.draft');
    Route::get('/assignments/grammar-writing/fast-track/meeting{meeting}/draft', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meetingDraftShow'])->whereNumber('meeting')->name('assignments.grammar-writing.meeting.draft.show');
    Route::post('/assignments/grammar-writing/fast-track/meeting3/reset', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting3Reset'])->name('assignments.grammar-writing.meeting3.reset');
    Route::post('/assignments/grammar-writing/fast-track/meeting3/admin-reset', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting3AdminReset'])->name('assignments.grammar-writing.meeting3.admin-reset');
    Route::get('/assignments/grammar-writing/fast-track/meeting4', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting4'])->name('assignments.grammar-writing.meeting4');
    Route::post('/assignments/grammar-writing/fast-track/meeting4', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting4Submit'])->name('assignments.grammar-writing.meeting4.submit');
    Route::post('/assignments/grammar-writing/fast-track/meeting4/reset', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting4Reset'])->name('assignments.grammar-writing.meeting4.reset');
    Route::post('/assignments/grammar-writing/fast-track/meeting4/generate-ai-variation', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting4GenerateAiVariation'])->name('assignments.grammar-writing.meeting4.ai-variation');
    Route::post('/assignments/grammar-writing/fast-track/meeting4/switch-mode', [App\Http\Controllers\LegacyGrammarWritingController::class, 'meeting4SwitchMode'])->name('assignments.grammar-writing.meeting4.switch-mode');
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
    
    // Fast Track Bonus Meeting (Reducing, Abridgement, Omitting)
    Route::get('/assignments/grammar-writing/fast-track/bonus', [App\Http\Controllers\GrammarWritingBonusMeetingController::class, 'bonusMeeting'])->name('assignments.grammar-writing.fast-track.bonus');
    Route::post('/assignments/grammar-writing/fast-track/bonus', [App\Http\Controllers\GrammarWritingBonusMeetingController::class, 'bonusMeetingSubmit'])->name('assignments.grammar-writing.fast-track.bonus.submit');
    Route::post('/assignments/grammar-writing/fast-track/bonus/reset', [App\Http\Controllers\GrammarWritingBonusMeetingController::class, 'bonusMeetingReset'])->name('assignments.grammar-writing.fast-track.bonus.reset');
    Route::get('/assignments/grammar-writing/fast-track/bonus/materi/pdf', [App\Http\Controllers\GrammarWritingBonusMeetingController::class, 'bonusMeetingMaterialPdf'])->name('assignments.grammar-writing.fast-track.bonus.material-pdf');
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

    Route::post('/admin/assignments/grammar-writing/questions/bulk-introductory', [App\Http\Controllers\GrammarWritingAdminController::class, 'bulkStoreIntroductoryQuestions'])->name('admin.grammar.question.bulk-introductory');
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
    Route::post('/admin/users/bulk-update-status', [App\Http\Controllers\Admin\UserController::class, 'bulkUpdateStatus'])->name('admin.users.bulk_update_status')->middleware('role:admin');
    Route::post('/admin/users/{user}/convert', [App\Http\Controllers\Admin\UserController::class, 'convertGuest'])->name('users.convertGuest')->middleware('role:admin');
    Route::post('/admin/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status')->middleware('role:admin');
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class)->names('users')->middleware('role:admin');
    Route::post('/admin/users/{user}/intern-permissions', [App\Http\Controllers\Admin\InternPermissionController::class, 'update'])->name('users.intern-permissions.update')->middleware('role:admin');
    
    // Admin Teachers Management
    Route::post('/admin/teachers/assign-student', [App\Http\Controllers\TeacherController::class, 'assignStudent'])->name('admin.teachers.assign_student')->middleware('role:admin');
    Route::post('/admin/teachers/assign-class', [App\Http\Controllers\TeacherController::class, 'assignClass'])->name('admin.teachers.assign_class')->middleware('role:admin');
    Route::resource('admin/teachers', App\Http\Controllers\TeacherController::class)->only(['index', 'show'])->names('teachers')->middleware('role:admin');

    // Admin Students Management
    Route::post('/admin/students/{student}/assign-teacher', [App\Http\Controllers\Admin\StudentController::class, 'assignTeacher'])->name('admin.students.assign_teacher')->middleware('role:admin');
    Route::post('/admin/students/{student}/quick-update', [App\Http\Controllers\Admin\StudentController::class, 'quickUpdate'])->name('admin.students.quick_update')->middleware('role:admin');
    Route::post('/admin/students/bulk-generate-referral-codes', [App\Http\Controllers\Admin\StudentController::class, 'bulkGenerateReferralCodes'])->name('admin.students.bulk_generate_referral')->middleware('role:admin');
    Route::get('/admin/students/{student}/current-assignment', [App\Http\Controllers\Admin\StudentController::class, 'currentAssignment'])->name('admin.students.current_assignment')->middleware('role:admin');
    Route::get('/admin/students/{student}/current-assignment-json', [App\Http\Controllers\Admin\StudentController::class, 'currentAssignmentJson'])->name('admin.students.current_assignment_json')->middleware('role:admin');
    Route::resource('admin/students', App\Http\Controllers\Admin\StudentController::class)->only(['index', 'show'])->names('students')->middleware('role:admin');

    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard')->middleware('role:admin');
    Route::get('/admin/api/active-students', [App\Http\Controllers\AdminController::class, 'activeStudentsJson'])->name('admin.api.active-students')->middleware('role:admin');
    Route::get('/admin/api/active-teachers', [App\Http\Controllers\AdminController::class, 'activeTeachersJson'])->name('admin.api.active-teachers')->middleware('role:admin');
    Route::get('/admin/chat', function () { 
        $isLiveChatEnabled = setting('live_chat_enabled', '1') === '1';
        return view('admin.chat.index', compact('isLiveChatEnabled')); 
    })->name('admin.chat.index')->middleware('role:admin');

    Route::post('/admin/chat/toggle', function () {
        $enabled = setting('live_chat_enabled', '1');
        $newValue = $enabled === '1' ? '0' : '1';
        \App\Models\Setting::updateOrCreate(
            ['key' => 'live_chat_enabled'],
            ['value' => $newValue, 'type' => 'boolean']
        );
        \Illuminate\Support\Facades\Cache::forget('app_settings');
        return response()->json(['enabled' => $newValue === '1']);
    })->name('admin.chat.toggle')->middleware('role:admin');
    Route::get('/admin/campaign-signups/export', [App\Http\Controllers\Admin\WHVApplicationController::class, 'exportCampaignSignups'])->name('admin.campaign-signups.export')->middleware('role:admin');
    
    // Admin Class Periods Management
    Route::get('/admin/class-periods/next-batch-number', [App\Http\Controllers\Admin\ClassPeriodController::class, 'nextBatchNumber'])->name('class-periods.next-batch-number')->middleware('role:admin');
    Route::patch('/admin/class-periods/{classPeriod}/status', [App\Http\Controllers\Admin\ClassPeriodController::class, 'updateStatus'])->name('class-periods.status');
    Route::post('/admin/class-periods/{classPeriod}/assign-student', [App\Http\Controllers\Admin\ClassPeriodController::class, 'assignStudent'])->name('class-periods.assign-student');
    Route::delete('/admin/class-periods/{classPeriod}/remove-student/{user}', [App\Http\Controllers\Admin\ClassPeriodController::class, 'removeStudent'])->name('class-periods.remove-student');
    Route::post('/admin/class-periods/{classPeriod}/toggle-meeting/{meeting}', [App\Http\Controllers\Admin\ClassPeriodController::class, 'toggleMeeting'])->name('class-periods.toggle-meeting');
    Route::resource('admin/class-periods', App\Http\Controllers\Admin\ClassPeriodController::class)->names('class-periods')->middleware('role:admin');

    Route::get('/admin/class-schedules', [App\Http\Controllers\Admin\ClassScheduleController::class, 'index'])->name('admin.class-schedules.index')->middleware('role:admin');
    Route::get('/api/admin/class-schedules/events', [App\Http\Controllers\Admin\ClassScheduleController::class, 'apiEvents'])->name('admin.class-schedules.events')->middleware('role:admin');
    Route::patch('/admin/class-schedules/{meeting}', [App\Http\Controllers\Admin\ClassScheduleController::class, 'update'])->name('admin.class-schedules.update')->middleware('role:admin');
    
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
    Route::post('admin/programs/{program}/current-meeting', [App\Http\Controllers\Admin\ProgramController::class, 'updateCurrentMeeting'])->name('programs.current-meeting.update');
    
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
    Route::get('/admin/toefl-mockup-results/{id}', [App\Http\Controllers\Admin\ToeflMockupResultController::class, 'show'])->whereNumber('id')->name('admin.toefl-mockup-results.show')->middleware('role:admin');
    Route::patch('/admin/toefl-mockup-results/{id}/status', [App\Http\Controllers\Admin\ToeflMockupResultController::class, 'updateStatus'])->whereNumber('id')->name('admin.toefl-mockup-results.update-status')->middleware('role:admin');
    Route::get('/admin/toefl-mockup-results/{id}/certificate', [App\Http\Controllers\Admin\ToeflMockupResultController::class, 'certificate'])->whereNumber('id')->name('admin.toefl-mockup-results.certificate')->middleware('role:admin');
    
    // Attendance
    Route::get('/admin/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.attendance.index')->middleware('role:admin');
    Route::get('/admin/attendance/meetings/{classPeriod}', [App\Http\Controllers\Admin\AttendanceController::class, 'getMeetings'])->name('admin.attendance.meetings')->middleware('role:admin');
    Route::get('/admin/attendance/records/{classMeeting}', [App\Http\Controllers\Admin\AttendanceController::class, 'getAttendance'])->name('admin.attendance.records')->middleware('role:admin');
    Route::post('/admin/attendance/store', [App\Http\Controllers\Admin\AttendanceController::class, 'store'])->name('admin.attendance.store')->middleware('role:admin');
    Route::post('/admin/attendance/meetings/{classPeriod}/create', [App\Http\Controllers\Admin\AttendanceController::class, 'createMeeting'])->name('admin.attendance.meeting.create')->middleware('role:admin');
    Route::delete('/admin/attendance/meetings/delete/{classMeeting}', [App\Http\Controllers\Admin\AttendanceController::class, 'deleteMeeting'])->name('admin.attendance.meeting.delete')->middleware('role:admin');
    Route::patch('/admin/attendance/meetings/{classMeeting}', [App\Http\Controllers\Admin\AttendanceController::class, 'updateMeeting'])->name('admin.attendance.meeting.update')->middleware('role:admin');
    
    // Attendance Batch Routes
    Route::get('/admin/attendance/batch/{batchType}/{batchNumber?}', [App\Http\Controllers\Admin\AttendanceController::class, 'getBatchInfo'])->name('admin.attendance.batch.info')->middleware('role:admin');
    Route::get('/admin/attendance/batch/{batchType}/classes/{batchNumber?}', [App\Http\Controllers\Admin\AttendanceController::class, 'getClassesByBatch'])->name('admin.attendance.batch.classes')->middleware('role:admin');
    Route::get('/admin/attendance/batch/{batchType}/meetings/{batchNumber?}', [App\Http\Controllers\Admin\AttendanceController::class, 'getMeetingsByBatch'])->name('admin.attendance.batch.meetings')->middleware('role:admin');
    Route::get('/admin/attendance/batch/{batchType}/students/{batchNumber?}', [App\Http\Controllers\Admin\AttendanceController::class, 'getStudentsByBatch'])->name('admin.attendance.batch.students')->middleware('role:admin');
    
    // Reports
    Route::get('/admin/reports/{tab?}', [App\Http\Controllers\Admin\ReportController::class, 'index'])
        ->where('tab', 'student|teacher|guest|finance')
        ->name('admin.reports.index')
        ->middleware('role:admin');

    // Admin Payment Verification
    Route::get('/admin/payments', [App\Http\Controllers\PaymentController::class, 'adminIndex'])
        ->name('admin.payments.index')
        ->middleware('role:admin');
    Route::get('/admin/payments/queue', [App\Http\Controllers\PaymentController::class, 'adminQueue'])
        ->name('admin.payments.queue')
        ->middleware('role:admin');
    Route::get('/admin/payments/proofs', [App\Http\Controllers\PaymentController::class, 'proofsIndex'])
        ->name('admin.payments.proofs')
        ->middleware('role:admin');
    // Consolidated view of all students who self-booked a class batch (Booking Class feature)
    Route::get('/admin/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])
        ->name('admin.bookings.index')
        ->middleware('role:admin');
    Route::post('/admin/bookings', [App\Http\Controllers\Admin\BookingController::class, 'store'])
        ->name('admin.bookings.store')
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
    
    // Class Evaluations (Admin)
    Route::get('/admin/class-evaluations', [App\Http\Controllers\Admin\ClassEvaluationController::class, 'index'])->name('admin.class-evaluations.index')->middleware('role:admin');
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
    
    // Admin Assignment Results
    Route::get('/admin/assignment-results', [App\Http\Controllers\Admin\AssignmentResultController::class, 'index'])->name('admin.assignment-results.index')->middleware('role:admin');
    Route::get('/admin/assignment-results/{program}', [App\Http\Controllers\Admin\AssignmentResultController::class, 'show'])->name('admin.assignment-results.show')->middleware('role:admin');
    Route::get('/admin/assignment-results/{program}/submissions/{submission}', [App\Http\Controllers\Admin\AssignmentResultController::class, 'showSubmission'])->name('admin.assignment-results.submission')->middleware('role:admin');

    // Admin/Teacher: IELTS Writing Practice submissions that failed AI grading and need a resend.
    Route::get('/admin/writing-practice-submissions', [App\Http\Controllers\Admin\WritingPracticeSubmissionController::class, 'index'])->name('admin.writing-practice-submissions.index')->middleware('role:teacher');

    // Admin Free Test Certificates
    // Camp Management
    Route::get('/admin/camp-management', [App\Http\Controllers\Admin\CampManagementController::class, 'index'])->name('admin.camp-management.index')->middleware('role:admin');
    Route::resource('/admin/camps', App\Http\Controllers\Admin\CampController::class, ['as' => 'admin'])->middleware('role:admin');
    Route::resource('/admin/camps.rooms', App\Http\Controllers\Admin\CampRoomController::class, ['as' => 'admin'])->shallow()->except(['index', 'show'])->middleware('role:admin');
    Route::get('/admin/camp-reviews', [App\Http\Controllers\Admin\CampReviewController::class, 'index'])->name('admin.camp-reviews.index')->middleware('role:admin');
    Route::delete('/admin/camp-reviews/{camp_review}', [App\Http\Controllers\Admin\CampReviewController::class, 'destroy'])->name('admin.camp-reviews.destroy')->middleware('role:admin');
    Route::get('/admin/free-test-certificates', [App\Http\Controllers\Admin\FreeTestCertificateController::class, 'index'])->name('admin.free-tests.certificates.index')->middleware('role:admin');
    Route::put('/admin/free-test-certificates/{id}', [App\Http\Controllers\Admin\FreeTestCertificateController::class, 'update'])->name('admin.free-tests.certificates.update')->middleware('role:admin');
    Route::get('/admin/free-test-certificates/{id}/preview/{resultId?}', [App\Http\Controllers\Admin\FreeTestCertificateController::class, 'preview'])->name('admin.free-tests.certificates.preview')->middleware('role:admin');
    Route::get('/admin/free-test-certificates/{id}/background', [App\Http\Controllers\Admin\FreeTestCertificateController::class, 'backgroundImage'])->name('admin.free-tests.certificates.background')->middleware('role:admin');
    Route::get('/admin/free-test-certificates/{id}/signature', [App\Http\Controllers\Admin\FreeTestCertificateController::class, 'signatureImage'])->name('admin.free-tests.certificates.signature')->middleware('role:admin');
    Route::get('/admin/free-test-certificates/{id}/stamp', [App\Http\Controllers\Admin\FreeTestCertificateController::class, 'stampImage'])->name('admin.free-tests.certificates.stamp')->middleware('role:admin');
    
    // System Settings
    Route::get('/admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index')->middleware('role:admin');
    Route::post('/admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update')->middleware('role:admin');

    // Admin WAHA Management
    Route::prefix('admin/whatsapp-management')->name('admin.waha.')->middleware('role:admin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\WahaManagementController::class, 'index'])->name('index');
        Route::get('/status', [App\Http\Controllers\Admin\WahaManagementController::class, 'status'])->name('status');
        Route::post('/start', [App\Http\Controllers\Admin\WahaManagementController::class, 'start'])->name('start');
        Route::post('/stop', [App\Http\Controllers\Admin\WahaManagementController::class, 'stop'])->name('stop');
        Route::post('/logout', [App\Http\Controllers\Admin\WahaManagementController::class, 'logout'])->name('logout');
        Route::post('/update-session', [App\Http\Controllers\Admin\WahaManagementController::class, 'updateSessionName'])->name('update-session');
        Route::post('/update-api', [App\Http\Controllers\Admin\WahaManagementController::class, 'updateApiConfig'])->name('update-api');
    });

    // Admin Pricing Management
    Route::prefix('admin/pricing')->name('admin.pricing.')->middleware('role:admin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PricingController::class, 'index'])->name('index');
        Route::patch('/mock-test', [App\Http\Controllers\Admin\PricingController::class, 'updateMockTest'])->name('mock-test.update');
        Route::patch('/mock-test/{program}', [App\Http\Controllers\Admin\PricingController::class, 'updateSingleProgram'])->name('mock-test.update-single');
        Route::patch('/online-test', [App\Http\Controllers\Admin\PricingController::class, 'updateOnlineTest'])->name('online-test.update');
    });

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

});

// Public Registration Form
Route::get('/daftar', [App\Http\Controllers\RegistrationController::class, 'show'])->name('registration.show');
Route::post('/daftar', [App\Http\Controllers\RegistrationController::class, 'store'])->name('registration.store')->middleware('throttle:5,10');
Route::get('/daftar/success', [App\Http\Controllers\RegistrationController::class, 'success'])->name('registration.success');
Route::post('/api/verify-referral', [App\Http\Controllers\ReferralController::class, 'verify'])->name('api.verify-referral');

// Landing Page Class Registration Lead (saves to RegistrationLead + redirects to student register)
Route::post('/daftar-kelas', [App\Http\Controllers\PublicRegistrationLeadController::class, 'store'])->name('class-lead.store');

// 2-Way Messaging & Inbox
Route::middleware(['auth'])->group(function () {
    Route::get('/announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/inbox', [App\Http\Controllers\InboxController::class, 'index'])->name('inbox.index');
    Route::post('/inbox', [App\Http\Controllers\InboxController::class, 'store'])->name('inbox.store');
    Route::post('/inbox/{id}/read', [App\Http\Controllers\InboxController::class, 'markAsRead'])->name('inbox.read');

    // In-App Chat Widget API
    Route::prefix('api/chat')->name('chat.')->group(function () {
        Route::get('/messages',       [App\Http\Controllers\ChatWidgetController::class, 'messages'])->name('messages');
        Route::post('/send',          [App\Http\Controllers\ChatWidgetController::class, 'send'])->name('send');
        Route::post('/reply',         [App\Http\Controllers\ChatWidgetController::class, 'reply'])->name('reply');
        Route::post('/mark-read',     [App\Http\Controllers\ChatWidgetController::class, 'markRead'])->name('markRead');
        Route::get('/conversations',  [App\Http\Controllers\ChatWidgetController::class, 'conversations'])->name('conversations');
        Route::get('/search',         [App\Http\Controllers\ChatWidgetController::class, 'search'])->name('search');
        Route::get('/unread-count',   [App\Http\Controllers\ChatWidgetController::class, 'unreadCount'])->name('unreadCount');
    });
});

// OTP Routes for Registration
Route::post('/otp/send', [App\Http\Controllers\Auth\OtpController::class, 'send'])->name('otp.send');
Route::post('/otp/verify', [App\Http\Controllers\Auth\OtpController::class, 'verify'])->name('otp.verify');

require __DIR__.'/auth.php';

Route::post('admin/scholarships/bulk-publish', [App\Http\Controllers\Admin\ScholarshipController::class, 'bulkPublish'])->name('admin.scholarships.bulk-publish')->middleware('role:admin');

// ======================================================
// Social Media Management Routes
// ======================================================
Route::middleware(['auth', config('jetstream.auth_session'), 'verified', 'role:admin'])->prefix('admin/social-media')->name('admin.social-media.')->group(function () {
    // All Programs Overview
    Route::get('/', [App\Http\Controllers\SocialMediaManagementController::class, 'allPrograms'])->name('all');
    Route::get('/export-csv', [App\Http\Controllers\SocialMediaManagementController::class, 'exportCsv'])->defaults('program', 'all')->name('export-all');

    // Per-Program Routes
    Route::prefix('{program}')->group(function () {
        Route::get('/',              [App\Http\Controllers\SocialMediaManagementController::class, 'index'])->name('index');
        Route::post('/',             [App\Http\Controllers\SocialMediaManagementController::class, 'store'])->name('store');
        Route::get('/export-csv',    [App\Http\Controllers\SocialMediaManagementController::class, 'exportCsv'])->name('export');
        Route::get('/{id}',          [App\Http\Controllers\SocialMediaManagementController::class, 'show'])->name('show');
        Route::put('/{id}',          [App\Http\Controllers\SocialMediaManagementController::class, 'update'])->name('update');
        Route::delete('/{id}',       [App\Http\Controllers\SocialMediaManagementController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/duplicate',      [App\Http\Controllers\SocialMediaManagementController::class, 'duplicate'])->name('duplicate');
        Route::post('/{id}/mark-published', [App\Http\Controllers\SocialMediaManagementController::class, 'markPublished'])->name('mark-published');
        Route::post('/{id}/archive',        [App\Http\Controllers\SocialMediaManagementController::class, 'archive'])->name('archive');
        Route::post('/{id}/checklist',      [App\Http\Controllers\SocialMediaManagementController::class, 'updateChecklist'])->name('checklist');
        Route::post('/{id}/stats',          [App\Http\Controllers\SocialMediaManagementController::class, 'updateStats'])->name('stats');
    });
});

// API routes for Live Drawing sync fallback
Route::post('/api/live-drawing/sync', [App\Http\Controllers\LiveDrawingController::class, 'sync'])->name('api.live-drawing.sync')->middleware('auth');
Route::get('/api/live-drawing/fetch/{targetUserId}', [App\Http\Controllers\LiveDrawingController::class, 'fetch'])->name('api.live-drawing.fetch')->middleware('auth');

