<?php

namespace Tests\Feature;

use App\Application\Admin\BuildAdminReport;
use App\Application\Admin\ManageStudents;
use App\Application\Admin\ManageUsers;
use App\Application\Attendance\ManageAdminAttendance;
use App\Application\Broadcast\DispatchBroadcast;
use App\Application\ClassPeriod\ManageClassPeriods;
use App\Application\Program\ManagePrograms;
use App\Application\Referral\ManageAdminReferrals;
use App\Application\Registration\ManageRegistrationLeads;
use App\Application\ToeflMockup\ListMockupResults;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\BroadcastMessageController;
use App\Http\Controllers\Admin\ClassPeriodController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\Admin\RegistrationLeadController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ToeflMockupResultController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminRefactorSmokeTest extends TestCase
{
    private function emptyPaginator(int $perPage = 15): LengthAwarePaginator
    {
        return new LengthAwarePaginator([], 0, $perPage, 1, [
            'path' => '/',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_refactored_admin_routes_are_registered(): void
    {
        $routes = [
            'admin.toefl-mockup-results.index',
            'admin.broadcast-messages.index',
            'admin.attendance.index',
            'class-periods.index',
            'students.index',
            'users.index',
            'admin.reports.index',
            'programs.index',
            'programs.discounts.index',
            'admin.registration-leads.index',
            'admin.referrals.index',
        ];

        foreach ($routes as $name) {
            $this->assertTrue(Route::has($name), "Missing route: {$name}");
        }
    }

    public function test_refactored_admin_index_controllers_delegate_without_runtime_errors(): void
    {
        $listMockupResults = $this->createMock(ListMockupResults::class);
        $listMockupResults->expects($this->once())->method('execute')->with(15)->willReturn($this->emptyPaginator(15));
        $this->app->instance(ListMockupResults::class, $listMockupResults);

        $dispatchBroadcast = $this->createMock(DispatchBroadcast::class);
        $dispatchBroadcast->expects($this->once())->method('listAll')->with(15)->willReturn($this->emptyPaginator(15));
        $this->app->instance(DispatchBroadcast::class, $dispatchBroadcast);

        $manageAdminAttendance = $this->createMock(ManageAdminAttendance::class);
        $manageAdminAttendance->expects($this->once())->method('getClassPeriodsWithStudents')->willReturn(collect());
        $this->app->instance(ManageAdminAttendance::class, $manageAdminAttendance);

        $manageClassPeriods = $this->createMock(ManageClassPeriods::class);
        $manageClassPeriods->expects($this->once())
            ->method('listAll')
            ->with($this->isType('array'))
            ->willReturn($this->emptyPaginator(15));
        $this->app->instance(ManageClassPeriods::class, $manageClassPeriods);

        $manageStudents = $this->createMock(ManageStudents::class);
        $manageStudents->expects($this->once())
            ->method('listAll')
            ->with($this->isType('array'), 15)
            ->willReturn([
                'students' => collect(),
                'teachers' => collect(),
                'programs' => collect(),
                'metrics' => [],
            ]);
        $this->app->instance(ManageStudents::class, $manageStudents);

        $manageUsers = $this->createMock(ManageUsers::class);
        $manageUsers->expects($this->once())
            ->method('listAll')
            ->with($this->isType('array'), 15)
            ->willReturn($this->emptyPaginator(15));
        $manageUsers->expects($this->once())
            ->method('formOptions')
            ->willReturn([
                'teachers' => collect(),
                'programs' => collect(),
            ]);
        $this->app->instance(ManageUsers::class, $manageUsers);

        $buildAdminReport = $this->createMock(BuildAdminReport::class);
        $buildAdminReport->expects($this->once())
            ->method('execute')
            ->willReturn([
                'tabCounts' => [],
                'monthlyRevenue' => 0,
                'newEnrolledStudents' => 0,
                'activeTeachers' => 0,
                'activeGuests' => 0,
                'newGuestsThisMonth' => 0,
                'guestToStudentConvertedThisMonth' => 0,
                'financialSummary' => [],
                'revenueBasis' => 'paid_amount',
                'studentGrowthData' => [],
                'programPopularityData' => [],
                'topPerformingStudents' => collect(),
                'highestRatedTeachers' => collect(),
                'metrics' => [],
            ]);
        $this->app->instance(BuildAdminReport::class, $buildAdminReport);

        $managePrograms = $this->createMock(ManagePrograms::class);
        $managePrograms->expects($this->once())->method('listAll')->willReturn($this->emptyPaginator(15));
        $this->app->instance(ManagePrograms::class, $managePrograms);

        $manageRegistrationLeads = $this->createMock(ManageRegistrationLeads::class);
        $manageRegistrationLeads->expects($this->once())
            ->method('index')
            ->with([])
            ->willReturn([
                'leads' => collect(),
                'programs' => collect(),
                'classPeriods' => collect(),
                'attributionInsights' => [],
                'quickAttributionFilters' => [],
                'metrics' => [],
            ]);
        $this->app->instance(ManageRegistrationLeads::class, $manageRegistrationLeads);

        $manageAdminReferrals = $this->createMock(ManageAdminReferrals::class);
        $manageAdminReferrals->expects($this->once())
            ->method('index')
            ->willReturn([
                'claims' => collect(),
                'rewards' => collect(),
                'socialSubmissions' => collect(),
            ]);
        $this->app->instance(ManageAdminReferrals::class, $manageAdminReferrals);

        $request = Request::create('/admin', 'GET');

        $toeflResponse = $this->app->make(ToeflMockupResultController::class)->index();
        $this->assertEquals('admin.toefl-mockup-results.index', $toeflResponse->name());

        $broadcastResponse = $this->app->make(BroadcastMessageController::class)->index();
        $this->assertEquals('admin.broadcast-messages.index', $broadcastResponse->name());

        $attendanceResponse = $this->app->make(AttendanceController::class)->index();
        $this->assertEquals('admin.attendance.index', $attendanceResponse->name());

        $classPeriodResponse = $this->app->make(ClassPeriodController::class)->index($request);
        $this->assertEquals('admin.class-periods.index', $classPeriodResponse->name());

        $studentResponse = $this->app->make(StudentController::class)->index($request);
        $this->assertEquals('admin.students.index', $studentResponse->name());

        $userResponse = $this->app->make(UserController::class)->index($request);
        $this->assertEquals('admin.users.index', $userResponse->name());

        $reportResponse = $this->app->make(ReportController::class)->index($request, null);
        $this->assertEquals('admin.reports.index', $reportResponse->name());

        $programResponse = $this->app->make(ProgramController::class)->index();
        $this->assertEquals('admin.programs.index', $programResponse->name());

        $registrationLeadResponse = $this->app->make(RegistrationLeadController::class)->index($request);
        $this->assertEquals('admin.registration-leads.index', $registrationLeadResponse->name());

        $referralResponse = $this->app->make(ReferralController::class)->index();
        $this->assertEquals('admin.referrals.index', $referralResponse->name());
    }
}
