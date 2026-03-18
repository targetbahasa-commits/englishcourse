<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\MeetingScore;
use App\Models\Payment;
use App\Models\Program;
use App\Models\TeacherEvaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
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

        $now = now();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();

        $revenueBasis = 'enrollment_estimate';

        // 1. Top Stat Cards (real data)
        // Revenue priority:
        // 1) Sum paid transactions from payments table (real cash-in basis)
        // 2) Fallback to enrollment * program price if payments table is unavailable
        if (Schema::hasTable('payments')) {
            $monthlyRevenue = (int) Payment::query()
                ->where('status', 'paid')
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->selectRaw('COALESCE(SUM(COALESCE(paid_amount, amount - discount_amount)), 0) as total_revenue')
                ->value('total_revenue');
            $revenueBasis = 'paid_transactions';
        } else {
            $monthlyRevenue = (int) Enrollment::query()
                ->join('programs', 'programs.id', '=', 'enrollments.program_id')
                ->whereBetween('enrollments.enrolled_at', [$monthStart, $monthEnd])
                ->whereIn('enrollments.status', ['active', 'completed'])
                ->sum('programs.price');
        }

        $newEnrolledStudents = Enrollment::query()
            ->whereBetween('enrollments.enrolled_at', [$monthStart, $monthEnd])
            ->whereIn('enrollments.status', ['active', 'completed'])
            ->distinct('user_id')
            ->count('user_id');

        $activeTeachers = User::query()
            ->where('role', 'teacher')
            ->where('status', 'active')
            ->count();

        $activeGuests = User::query()
            ->where('role', 'guest')
            ->where('status', 'active')
            ->count();

        $newGuestsThisMonth = User::query()
            ->where('role', 'guest')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();

        // Proxy conversion metric: students created this month that have a referrer.
        $guestToStudentConvertedThisMonth = User::query()
            ->where('role', 'student')
            ->whereNotNull('referred_by_id')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();

        $financialSummary = [
            'paid_transactions_count' => 0,
            'pending_transactions_count' => 0,
        ];

        if (Schema::hasTable('payments')) {
            $financialSummary['paid_transactions_count'] = Payment::query()
                ->where('status', 'paid')
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->count();

            $financialSummary['pending_transactions_count'] = Payment::query()
                ->where('status', 'pending')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
        }

            $tabCounts = [
                'student' => User::query()->where('role', 'student')->where('status', 'active')->count(),
                'teacher' => $activeTeachers,
                'guest' => $activeGuests,
                'finance' => Schema::hasTable('payments')
                ? $financialSummary['paid_transactions_count']
                : $newEnrolledStudents,
            ];

        // 2. Charts Data (real data)
        // Line Chart: cumulative active student accounts over the last 6 months.
        $studentGrowthLabels = [];
        $studentGrowthPoints = [];

        for ($offset = 5; $offset >= 0; $offset--) {
            $monthPoint = $now->copy()->subMonths($offset);
            $studentGrowthLabels[] = $monthPoint->format('M');
            $studentGrowthPoints[] = User::query()
                ->where('role', 'student')
                ->where('status', 'active')
                ->whereDate('created_at', '<=', $monthPoint->copy()->endOfMonth())
                ->count();
        }

        $studentGrowthData = [
            'labels' => $studentGrowthLabels,
            'data' => $studentGrowthPoints,
        ];

        // Pie Chart: active student distribution by assigned program.
        $programStats = Program::query()
            ->leftJoin('users', function ($join) {
                $join->on('users.program_id', '=', 'programs.id')
                    ->where('users.role', '=', 'student')
                    ->where('users.status', '=', 'active');
            })
            ->groupBy('programs.id', 'programs.name')
            ->orderByDesc('active_students')
            ->selectRaw('programs.name, COUNT(users.id) as active_students')
            ->get();

        if ($programStats->isEmpty()) {
            $programStats = collect([(object) [
                'name' => 'No Program Data',
                'active_students' => 1,
            ]]);
        }

        $programPopularityData = [
            'labels' => $programStats->pluck('name')->all(),
            'data' => $programStats->pluck('active_students')->all(),
        ];

        $totalProgramUsers = max(1, (int) $programStats->sum('active_students'));
        $topProgram = $programStats->first();
        $topProgramPercentage = (int) round(($topProgram->active_students / $totalProgramUsers) * 100);

        // 3. Tables Data (real data)
        $topPerformingStudents = MeetingScore::query()
            ->with(['user.program'])
            ->selectRaw('user_id, MIN(score) as min_score, MAX(score) as max_score, ROUND(AVG(score), 1) as avg_score, COUNT(*) as attempts')
            ->groupBy('user_id')
            ->orderByRaw('(MAX(score) - MIN(score)) DESC')
            ->orderByDesc('avg_score')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                $improvement = ((int) $row->max_score) - ((int) $row->min_score);

                return [
                    'name' => $row->user->name ?? 'Unknown Student',
                    'program' => $row->user->program->name ?? 'No Program',
                    'score_improvement' => '+' . $improvement . ' pts',
                ];
            })
            ->values()
            ->all();

        if (empty($topPerformingStudents)) {
            $topPerformingStudents = [[
                'name' => 'No data yet',
                'program' => '-',
                'score_improvement' => '-',
            ]];
        }

        $highestRatedTeachers = TeacherEvaluation::query()
            ->join('users as teachers', 'teacher_evaluations.teacher_id', '=', 'teachers.id')
            ->leftJoin('programs', 'teachers.program_id', '=', 'programs.id')
            ->selectRaw('teachers.id, teachers.name, COALESCE(programs.name, "General") as specialty, ROUND(AVG(teacher_evaluations.rating), 1) as rating, COUNT(teacher_evaluations.id) as total_reviews')
            ->groupBy('teachers.id', 'teachers.name', 'programs.name')
            ->orderByDesc('rating')
            ->orderByDesc('total_reviews')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                return [
                    'name' => $row->name,
                    'specialty' => $row->specialty,
                    'rating' => $row->rating,
                    'students_active' => $row->total_reviews,
                ];
            })
            ->values()
            ->all();

        if (empty($highestRatedTeachers)) {
            $highestRatedTeachers = [[
                'name' => 'No data yet',
                'specialty' => '-',
                'rating' => '-',
                'students_active' => 0,
            ]];
        }

        // 4. Additional Mock Metrics for Detailed Reporting
        $metrics = [
            'financial' => [
                'conversion_rate' => '42%',
                'most_popular_program' => $topProgram->name . ' (' . $topProgramPercentage . '%)',
            ],
            'academic' => [
                'retention_rate' => '65%',
                'avg_nps' => '4.8/5.0',
            ],
            'teacher' => [
                'grading_time' => '1.5 Days',
                'class_completion' => '98%',
            ],
            'operational' => [
                'peak_hours' => '19:00 - 21:00 WIB',
                'attendance_summary' => 'Students: 92% | Teachers: 99%',
            ]
        ];

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
