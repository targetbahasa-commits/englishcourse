<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\BuildAdminReport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        private readonly BuildAdminReport $buildAdminReport
    ) {}

    /**
     * Display the admin reports dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, ?string $tab = null)
    {
        $allowedTabs = ['student', 'teacher', 'guest', 'finance'];
        $requestedTab = $tab ?? $request->query('tab');
        $activeTab = in_array($requestedTab, $allowedTabs, true)
            ? $requestedTab
            : 'student';

        [
            'tabCounts' => $tabCounts,
            'monthlyRevenue' => $monthlyRevenue,
            'newEnrolledStudents' => $newEnrolledStudents,
            'activeTeachers' => $activeTeachers,
            'activeGuests' => $activeGuests,
            'newGuestsThisMonth' => $newGuestsThisMonth,
            'guestToStudentConvertedThisMonth' => $guestToStudentConvertedThisMonth,
            'financialSummary' => $financialSummary,
            'revenueBasis' => $revenueBasis,
            'studentGrowthData' => $studentGrowthData,
            'programPopularityData' => $programPopularityData,
            'topPerformingStudents' => $topPerformingStudents,
            'highestRatedTeachers' => $highestRatedTeachers,
            'metrics' => $metrics,
        ] = $this->buildAdminReport->execute();

        return view('admin.reports.index', compact(
            'activeTab',
            'tabCounts',
            'monthlyRevenue',
            'newEnrolledStudents',
            'activeTeachers',
            'activeGuests',
            'newGuestsThisMonth',
            'guestToStudentConvertedThisMonth',
            'financialSummary',
            'revenueBasis',
            'studentGrowthData',
            'programPopularityData',
            'topPerformingStudents',
            'highestRatedTeachers',
            'metrics'
        ));
    }
}
