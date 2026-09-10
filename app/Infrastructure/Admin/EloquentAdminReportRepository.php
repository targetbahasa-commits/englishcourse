<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Repositories\AdminReportRepository;
use App\Models\Enrollment;
use App\Models\MeetingScore;
use App\Models\Payment;
use App\Models\Program;
use App\Models\TeacherEvaluation;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class EloquentAdminReportRepository implements AdminReportRepository
{
    public function buildDashboardData(): array
    {
        $now = now();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd   = $now->copy()->endOfMonth();

        $revenueBasis = 'enrollment_estimate';
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

        $activeTeachers = User::where('role', 'teacher')->where('status', 'active')->count();
        $activeGuests   = User::where('role', 'guest')->where('status', 'active')->count();

        $newGuestsThisMonth = User::where('role', 'guest')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();

        $guestToStudentConvertedThisMonth = User::where('role', 'student')
            ->whereNotNull('converted_from_guest_at')
            ->whereBetween('converted_from_guest_at', [$monthStart, $monthEnd])
            ->count();

        $financialSummary = [
            'paid_transactions_count'    => 0,
            'pending_transactions_count' => 0,
        ];

        if (Schema::hasTable('payments')) {
            $financialSummary['paid_transactions_count'] = Payment::where('status', 'paid')
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->count();

            $financialSummary['pending_transactions_count'] = Payment::where('status', 'pending')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
        }

        $tabCounts = [
            'student' => User::where('role', 'student')->where('status', 'active')->count(),
            'teacher' => $activeTeachers,
            'guest'   => $activeGuests,
            'finance' => Schema::hasTable('payments')
                ? $financialSummary['paid_transactions_count']
                : $newEnrolledStudents,
        ];

        // Student growth (last 6 months)
        $studentGrowthLabels = [];
        $studentGrowthPoints = [];
        for ($offset = 5; $offset >= 0; $offset--) {
            $point = $now->copy()->subMonths($offset);
            $studentGrowthLabels[] = $point->format('M');
            $studentGrowthPoints[] = User::where('role', 'student')
                ->where('status', 'active')
                ->whereDate('created_at', '<=', $point->copy()->endOfMonth())
                ->count();
        }

        $studentGrowthData = ['labels' => $studentGrowthLabels, 'data' => $studentGrowthPoints];

        // Program popularity
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
            $programStats = collect([(object) ['name' => 'No Program Data', 'active_students' => 1]]);
        }

        $programPopularityData = [
            'labels' => $programStats->pluck('name')->all(),
            'data'   => $programStats->pluck('active_students')->all(),
        ];

        $totalProgramUsers = max(1, (int) $programStats->sum('active_students'));
        $topProgram = $programStats->first();
        $topProgramPercentage = (int) round(($topProgram->active_students / $totalProgramUsers) * 100);

        // Top performing students
        $topPerformingStudents = MeetingScore::where('is_reported', true)
            ->with(['user.program'])
            ->selectRaw('user_id, MIN(score) as min_score, MAX(score) as max_score, ROUND(AVG(score), 1) as avg_score, COUNT(*) as attempts')
            ->groupBy('user_id')
            ->orderByRaw('(MAX(score) - MIN(score)) DESC')
            ->orderByDesc('avg_score')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                return [
                    'name'              => $row->user->name ?? 'Unknown Student',
                    'program'           => $row->user->program->name ?? 'No Program',
                    'score_improvement' => '+' . (((int) $row->max_score) - ((int) $row->min_score)) . ' pts',
                ];
            })
            ->values()
            ->all();

        if (empty($topPerformingStudents)) {
            $topPerformingStudents = [['name' => 'No data yet', 'program' => '-', 'score_improvement' => '-']];
        }

        // Highest rated teachers
        $highestRatedTeachers = TeacherEvaluation::query()
            ->join('users as teachers', 'teacher_evaluations.teacher_id', '=', 'teachers.id')
            ->leftJoin('programs', 'teachers.program_id', '=', 'programs.id')
            ->selectRaw('teachers.id, teachers.name, COALESCE(programs.name, "General") as specialty, ROUND(AVG(teacher_evaluations.rating), 1) as rating, COUNT(teacher_evaluations.id) as total_reviews')
            ->groupBy('teachers.id', 'teachers.name', 'programs.name')
            ->orderByDesc('rating')
            ->orderByDesc('total_reviews')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'name'           => $row->name,
                'specialty'      => $row->specialty,
                'rating'         => $row->rating,
                'students_active' => $row->total_reviews,
            ])
            ->values()
            ->all();

        if (empty($highestRatedTeachers)) {
            $highestRatedTeachers = [['name' => 'No data yet', 'specialty' => '-', 'rating' => '-', 'students_active' => 0]];
        }

        // Conversion Rate (Guest -> Student), all-time: converted / (converted + still-guest)
        $everConvertedFromGuest = User::whereNotNull('converted_from_guest_at')->count();
        $conversionPool = $everConvertedFromGuest + $activeGuests;
        $conversionRate = $conversionPool > 0 ? round(($everConvertedFromGuest / $conversionPool) * 100, 1) : 0;

        // Retention Rate: enrollments still active/completed out of all enrollments ever created
        $totalEnrollments = Enrollment::count();
        $retainedEnrollments = Enrollment::whereIn('status', ['active', 'completed'])->count();
        $retentionRate = $totalEnrollments > 0 ? round(($retainedEnrollments / $totalEnrollments) * 100, 1) : 0;

        // Average Teacher Rating (there is no real 0-10 NPS survey in this app - only
        // 1-5 star TeacherEvaluation ratings, so this is labelled honestly, not as NPS).
        $teacherRatingCount = TeacherEvaluation::count();
        $avgTeacherRating = $teacherRatingCount > 0 ? round((float) TeacherEvaluation::avg('rating'), 1) : null;

        // Grading time: avg(updated_at - submitted_at) for MeetingScore rows that have
        // been scored. Imprecise (updated_at can be bumped by any later edit, not only
        // the initial grading), but it's the only timestamp signal this schema has.
        $scoredMeetings = MeetingScore::whereNotNull('score')
            ->whereNotNull('submitted_at')
            ->get(['submitted_at', 'updated_at']);
        $avgGradingHours = $scoredMeetings->isNotEmpty()
            ? $scoredMeetings->avg(fn ($m) => max(0, $m->submitted_at->diffInMinutes($m->updated_at)) / 60)
            : null;
        $gradingTimeLabel = $avgGradingHours === null
            ? 'Belum ada data'
            : ($avgGradingHours < 24 ? round($avgGradingHours, 1) . ' Jam' : round($avgGradingHours / 24, 1) . ' Hari');

        // Class completion: % of already-past ClassMeetings that have at least one
        // Attendance row recorded against them.
        $pastMeetingIds = \App\Models\ClassMeeting::whereNotNull('meeting_date')
            ->where('meeting_date', '<', $now->toDateString())
            ->pluck('id');
        $totalPastMeetings = $pastMeetingIds->count();
        $meetingsWithAttendance = $totalPastMeetings > 0
            ? \App\Models\Attendance::whereIn('class_meeting_id', $pastMeetingIds)->distinct('class_meeting_id')->count('class_meeting_id')
            : 0;
        $classCompletionRate = $totalPastMeetings > 0 ? round(($meetingsWithAttendance / $totalPastMeetings) * 100, 1) : 0;

        // Peak hours: most common ClassMeeting start_time hour bucket.
        $peakHourLabel = 'Belum ada data';
        $peakHourCounts = \App\Models\ClassMeeting::whereNotNull('start_time')->pluck('start_time')
            ->map(fn ($t) => \Illuminate\Support\Carbon::parse($t)->format('H:00'))
            ->countBy();
        if ($peakHourCounts->isNotEmpty()) {
            $peakHourLabel = $peakHourCounts->sortDesc()->keys()->first() . ' WIB';
        }

        // Attendance summary: % of student Attendance rows marked "present".
        // (There is no separate, unambiguous "teacher attendance" signal distinct from
        // class_completion above, so only the student side is reported here.)
        $totalAttendanceRecords = \App\Models\Attendance::count();
        $presentAttendanceRecords = \App\Models\Attendance::where('status', 'present')->count();
        $studentAttendanceRate = $totalAttendanceRecords > 0
            ? round(($presentAttendanceRecords / $totalAttendanceRecords) * 100, 1)
            : 0;

        $metrics = [
            'financial'   => [
                'conversion_rate' => $conversionRate . '%',
                'most_popular_program' => $topProgram->name . ' (' . $topProgramPercentage . '%)',
            ],
            'academic'    => [
                'retention_rate' => $retentionRate . '%',
                'avg_teacher_rating' => $avgTeacherRating === null ? 'Belum ada data' : $avgTeacherRating . '/5.0',
            ],
            'teacher'     => [
                'grading_time' => $gradingTimeLabel,
                'class_completion' => $classCompletionRate . '%',
            ],
            'operational' => [
                'peak_hours' => $peakHourLabel,
                'attendance_summary' => 'Students: ' . $studentAttendanceRate . '%',
            ],
        ];

        return compact(
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
        );
    }
}
