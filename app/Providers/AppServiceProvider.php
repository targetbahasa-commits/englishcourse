<?php

namespace App\Providers;

use App\Domain\ToeflMockup\Repositories\MockupPackageRepository;
use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use App\Domain\ToeflMockup\Repositories\MockupResultRepository;
use App\Domain\ToeflListeningPractice\Repositories\ListeningPracticeRepository;
use App\Domain\ToeflShared\Repositories\ToeflSharedRepository;
use App\Domain\ToeflListening\Repositories\ToeflListeningRepository;
use App\Domain\ToeflReading\Repositories\ToeflReadingRepository;
use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;
use App\Domain\ToeflStructurePractice\Repositories\ToeflStructurePracticeRepository;
use App\Domain\IeltsShared\Repositories\IeltsSharedRepository;
use App\Domain\IeltsWriting\Contracts\IeltsWritingAiHttpClient;
use App\Domain\IeltsWriting\Contracts\IeltsWritingLogger;
use App\Domain\IeltsWriting\Repositories\IeltsWritingRepository;
use App\Domain\IeltsReading\Repositories\IeltsReadingRepository;
use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;
use App\Domain\IeltsSpeaking\Repositories\IeltsSpeakingRepository;
use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;
use App\Domain\Payment\Repositories\PaymentRepository;
use App\Domain\Scholarship\Repositories\ScholarshipRepository;
use App\Domain\WHV\Repositories\WHVRepository;
use App\Domain\Announcement\Repositories\AnnouncementRepository;
use App\Domain\JobVacancy\Repositories\JobVacancyRepository;
use App\Domain\Program\Contracts\ProgramBrochureStorage;
use App\Domain\Program\Repositories\ProgramRepository;
use App\Domain\Referral\Repositories\ReferralRepository;
use App\Domain\Inbox\Repositories\InboxRepository;
use App\Domain\Progress\Repositories\ProgressRepository;
use App\Domain\FreeTest\Contracts\FreeTestCertificateStorage;
use App\Domain\FreeTest\Contracts\FreeTestFollowUpDispatcher;
use App\Domain\FreeTest\Repositories\FreeTestRepository;
use App\Domain\Registration\Repositories\RegistrationRepository;
use App\Domain\Score\Repositories\ScoreRepository;
use App\Domain\Teacher\Repositories\TeacherRepository;
use App\Domain\Teacher\Repositories\AttendanceRepository;
use App\Domain\Guest\Repositories\GuestUserRepository;
use App\Domain\StudentRegistration\Repositories\StudentRegistrationRepository;
use App\Domain\Shared\Contracts\TransactionManager;
use App\Domain\Admin\Contracts\DatabaseHealthChecker;
use App\Domain\Admin\Repositories\AdminRepository;
use App\Domain\Admin\Repositories\AdminDashboardRepository;
use App\Domain\Dashboard\Repositories\DashboardRepository;
use App\Domain\Setting\Repositories\SettingRepository;
use App\Domain\OutreachMessage\Repositories\OutreachMessageRepository;
use App\Domain\Broadcast\Repositories\BroadcastRepository;
use App\Domain\Broadcast\Contracts\BroadcastAudienceGateway;
use App\Domain\ProgramDiscount\Repositories\ProgramDiscountRepository;
use App\Domain\ClassPeriod\Repositories\ClassPeriodRepository;
use App\Domain\Admin\Repositories\AdminUserRepository;
use App\Domain\Admin\Repositories\AdminStudentRepository;
use App\Domain\Admin\Repositories\AdminReportRepository;
use App\Infrastructure\ToeflMockup\EloquentMockupMediaRepository;
use App\Infrastructure\ToeflMockup\EloquentMockupPackageRepository;
use App\Infrastructure\ToeflMockup\EloquentMockupResultRepository;
use App\Infrastructure\ToeflListeningPractice\EloquentListeningPracticeRepository;
use App\Infrastructure\ToeflShared\EloquentToeflSharedRepository;
use App\Infrastructure\ToeflListening\EloquentToeflListeningRepository;
use App\Infrastructure\ToeflReading\EloquentToeflReadingRepository;
use App\Infrastructure\ToeflStructure\EloquentToeflStructureRepository;
use App\Infrastructure\ToeflStructurePractice\EloquentToeflStructurePracticeRepository;
use App\Infrastructure\IeltsShared\EloquentIeltsSharedRepository;
use App\Infrastructure\IeltsWriting\LaravelIeltsWritingAiHttpClient;
use App\Infrastructure\IeltsWriting\LaravelIeltsWritingLogger;
use App\Infrastructure\IeltsWriting\EloquentIeltsWritingRepository;
use App\Infrastructure\IeltsReading\EloquentIeltsReadingRepository;
use App\Infrastructure\IeltsListening\EloquentIeltsListeningRepository;
use App\Infrastructure\IeltsSpeaking\EloquentIeltsSpeakingRepository;
use App\Infrastructure\GrammarWriting\EloquentGrammarWritingRepository;
use App\Infrastructure\Payment\EloquentPaymentRepository;
use App\Infrastructure\Scholarship\EloquentScholarshipRepository;
use App\Infrastructure\WHV\EloquentWHVRepository;
use App\Infrastructure\Announcement\EloquentAnnouncementRepository;
use App\Infrastructure\JobVacancy\EloquentJobVacancyRepository;
use App\Infrastructure\Program\EloquentProgramRepository;
use App\Infrastructure\Program\StorageProgramBrochureStorage;
use App\Infrastructure\Referral\EloquentReferralRepository;
use App\Infrastructure\Inbox\EloquentInboxRepository;
use App\Infrastructure\Progress\EloquentProgressRepository;
use App\Infrastructure\FreeTest\QueueFreeTestFollowUpDispatcher;
use App\Infrastructure\FreeTest\EloquentFreeTestRepository;
use App\Infrastructure\FreeTest\StorageFreeTestCertificateStorage;
use App\Infrastructure\Registration\EloquentRegistrationRepository;
use App\Infrastructure\Teacher\EloquentTeacherRepository;
use App\Infrastructure\Teacher\EloquentAttendanceRepository;
use App\Infrastructure\Guest\EloquentGuestUserRepository;
use App\Infrastructure\StudentRegistration\EloquentStudentRegistrationRepository;
use App\Infrastructure\Admin\LaravelDatabaseHealthChecker;
use App\Infrastructure\Admin\EloquentAdminRepository;
use App\Infrastructure\Admin\EloquentAdminDashboardRepository;
use App\Infrastructure\Dashboard\EloquentDashboardRepository;
use App\Infrastructure\Setting\EloquentSettingRepository;
use App\Infrastructure\OutreachMessage\EloquentOutreachMessageRepository;
use App\Infrastructure\Broadcast\EloquentBroadcastRepository;
use App\Infrastructure\Broadcast\EloquentBroadcastAudienceGateway;
use App\Infrastructure\ProgramDiscount\EloquentProgramDiscountRepository;
use App\Infrastructure\ClassPeriod\EloquentClassPeriodRepository;
use App\Infrastructure\Admin\EloquentAdminUserRepository;
use App\Infrastructure\Admin\EloquentAdminStudentRepository;
use App\Infrastructure\Admin\EloquentAdminReportRepository;
use Illuminate\Support\ServiceProvider;
use App\Application\FinalTest\StudentFinalTestAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Domain\Notification\Contracts\WhatsAppGateway;
use App\Infrastructure\Shared\LaravelTransactionManager;
use App\Infrastructure\Notification\WhatsApp\FonnteGateway;
use App\Infrastructure\Notification\WhatsApp\WablasGateway;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MockupPackageRepository::class, EloquentMockupPackageRepository::class);
        $this->app->bind(MockupMediaRepository::class, EloquentMockupMediaRepository::class);
        $this->app->bind(MockupResultRepository::class, EloquentMockupResultRepository::class);
        $this->app->bind(ListeningPracticeRepository::class, EloquentListeningPracticeRepository::class);
        $this->app->bind(ToeflSharedRepository::class, EloquentToeflSharedRepository::class);
        $this->app->bind(ToeflListeningRepository::class, EloquentToeflListeningRepository::class);
        $this->app->bind(ToeflReadingRepository::class, EloquentToeflReadingRepository::class);
        $this->app->bind(ToeflStructureRepository::class, EloquentToeflStructureRepository::class);
        $this->app->bind(ToeflStructurePracticeRepository::class, EloquentToeflStructurePracticeRepository::class);
        $this->app->bind(IeltsSharedRepository::class, EloquentIeltsSharedRepository::class);
        $this->app->bind(IeltsWritingAiHttpClient::class, LaravelIeltsWritingAiHttpClient::class);
        $this->app->bind(IeltsWritingLogger::class, LaravelIeltsWritingLogger::class);
        $this->app->bind(IeltsWritingRepository::class, EloquentIeltsWritingRepository::class);
        $this->app->bind(IeltsReadingRepository::class, EloquentIeltsReadingRepository::class);
        $this->app->bind(IeltsListeningRepository::class, EloquentIeltsListeningRepository::class);
        $this->app->bind(IeltsSpeakingRepository::class, EloquentIeltsSpeakingRepository::class);
        $this->app->bind(GrammarWritingRepository::class, EloquentGrammarWritingRepository::class);
        $this->app->bind(PaymentRepository::class, EloquentPaymentRepository::class);
        $this->app->bind(ScholarshipRepository::class, EloquentScholarshipRepository::class);
        $this->app->bind(WHVRepository::class, EloquentWHVRepository::class);
        $this->app->bind(AnnouncementRepository::class, EloquentAnnouncementRepository::class);
        $this->app->bind(JobVacancyRepository::class, EloquentJobVacancyRepository::class);
        $this->app->bind(ProgramBrochureStorage::class, StorageProgramBrochureStorage::class);
        $this->app->bind(ProgramRepository::class, EloquentProgramRepository::class);
        $this->app->bind(ReferralRepository::class, EloquentReferralRepository::class);
        $this->app->bind(InboxRepository::class, EloquentInboxRepository::class);
        $this->app->bind(ProgressRepository::class, EloquentProgressRepository::class);
        $this->app->bind(FreeTestCertificateStorage::class, StorageFreeTestCertificateStorage::class);
        $this->app->bind(FreeTestFollowUpDispatcher::class, QueueFreeTestFollowUpDispatcher::class);
        $this->app->bind(FreeTestRepository::class, EloquentFreeTestRepository::class);
        $this->app->bind(\App\Domain\FreeLesson\Repositories\FreeLessonProgressRepository::class, \App\Infrastructure\FreeLesson\EloquentFreeLessonProgressRepository::class);
        $this->app->bind(RegistrationRepository::class, EloquentRegistrationRepository::class);
        $this->app->bind(ScoreRepository::class, \App\Infrastructure\Score\EloquentScoreRepository::class);
        $this->app->bind(TeacherRepository::class, EloquentTeacherRepository::class);
        $this->app->bind(AttendanceRepository::class, EloquentAttendanceRepository::class);
        $this->app->bind(GuestUserRepository::class, EloquentGuestUserRepository::class);
        $this->app->bind(StudentRegistrationRepository::class, EloquentStudentRegistrationRepository::class);
        $this->app->bind(TransactionManager::class, LaravelTransactionManager::class);
        $this->app->bind(DatabaseHealthChecker::class, LaravelDatabaseHealthChecker::class);
        $this->app->bind(AdminRepository::class, EloquentAdminRepository::class);
        $this->app->bind(AdminDashboardRepository::class, EloquentAdminDashboardRepository::class);
        $this->app->bind(DashboardRepository::class, EloquentDashboardRepository::class);
        $this->app->bind(SettingRepository::class, EloquentSettingRepository::class);
        $this->app->bind(OutreachMessageRepository::class, EloquentOutreachMessageRepository::class);
        $this->app->bind(BroadcastAudienceGateway::class, EloquentBroadcastAudienceGateway::class);
        $this->app->bind(BroadcastRepository::class, EloquentBroadcastRepository::class);
        $this->app->bind(ProgramDiscountRepository::class, EloquentProgramDiscountRepository::class);
        $this->app->bind(ClassPeriodRepository::class, EloquentClassPeriodRepository::class);
        $this->app->bind(AdminUserRepository::class, EloquentAdminUserRepository::class);
        $this->app->bind(AdminStudentRepository::class, EloquentAdminStudentRepository::class);
        $this->app->bind(AdminReportRepository::class, EloquentAdminReportRepository::class);

        $this->app->bind(WhatsAppGateway::class, function ($app) {
            $gateway = config('services.whatsapp.gateway');
            if ($gateway === 'wablas') {
                return new WablasGateway();
            } elseif ($gateway === 'waha') {
                return new \App\Infrastructure\Notification\WhatsApp\WahaGateway();
            }
            return new FonnteGateway(); // Default
        });

        // Ensure public_path() returns the correct path on shared hosting
        $this->app->bind('path.public', function () {
            // If the base path itself is public_html, it means we are in the production shared hosting root
            if (str_ends_with(base_path(), 'public_html')) {
                return base_path();
            }
            return base_path('public');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') || str_ends_with(base_path(), 'public_html')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Mail\Events\MessageSent::class,
            \App\Listeners\LogSentEmail::class
        );

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\EnforceSingleDeviceSession::class
        );

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        Password::defaults(function () {
            $rule = Password::min(8)
                ->mixedCase()
                ->numbers();

            return $this->app->environment('production')
                        ? $rule->uncompromised()
                        : $rule;
        });

        View::composer('components.sidebar-student', function ($view) {
            $user = Auth::user();
            $canAccessFinalTest = $user?->isStudent()
                && app(StudentFinalTestAccess::class)->canAccessMenu($user);

            $view->with('canAccessFinalTest', $canAccessFinalTest);
        });
    }
}
