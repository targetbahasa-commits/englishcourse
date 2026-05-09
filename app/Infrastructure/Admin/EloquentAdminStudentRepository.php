<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Repositories\AdminStudentRepository;
use App\Models\FreeTestResult;
use App\Models\MeetingScore;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Str;

class EloquentAdminStudentRepository implements AdminStudentRepository
{
    public function listStudents(array $filters, int $perPage): mixed
    {
        $query = User::where('role', 'student')->with(['program', 'teacher']);

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('email', 'like', "%{$filters['search']}%")
                  ->orWhere('phone_number', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['missing'])) {
            if ($filters['missing'] === 'whatsapp') {
                $query->whereNull('phone_number')->orWhere('phone_number', '');
            } elseif ($filters['missing'] === 'referral') {
                $query->whereNull('referral_code')->orWhere('referral_code', '');
            } elseif ($filters['missing'] === 'both') {
                $query->where(function ($q) {
                    $q->whereNull('phone_number')->orWhere('phone_number', '');
                })->where(function ($q) {
                    $q->whereNull('referral_code')->orWhere('referral_code', '');
                });
            }
        }

        if (!empty($filters['program_id'])) {
            $query->where('program_id', $filters['program_id']);
        }

        if (!empty($filters['class_period_id'])) {
            $query->where('class_period_id', $filters['class_period_id']);
        }

        if (!empty($filters['month_year'])) {
            // month_year format expected: "YYYY-MM"
            $parts = explode('-', $filters['month_year']);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function findOrFail(int $id): mixed
    {
        return User::findOrFail($id);
    }

    public function getTeacherOptions(): array
    {
        return User::where('role', 'teacher')->where('status', 'active')->get()->all();
    }

    public function getProgramOptions(): array
    {
        return Program::orderBy('name')->get()->all();
    }

    public function getStudentMetrics(): array
    {
        return [
            'total_students'    => User::where('role', 'student')->count(),
            'active_students'   => User::where('role', 'student')->where('status', 'active')->count(),
            'missing_wa'        => User::where('role', 'student')->where(function ($q) { $q->whereNull('phone_number')->orWhere('phone_number', ''); })->count(),
            'missing_referral'  => User::where('role', 'student')->where(function ($q) { $q->whereNull('referral_code')->orWhere('referral_code', ''); })->count(),
            'average_progress'  => 65,
        ];
    }

    public function getRecentActivity(int $userId): mixed
    {
        return MeetingScore::where('user_id', $userId)
            ->with('classMeeting.assignment')
            ->orderByDesc('submitted_at')
            ->limit(10)
            ->get();
    }

    public function getProgressStats(int $userId): array
    {
        $totalAssignments = 20;
        $completedAssignments = MeetingScore::where('user_id', $userId)->count();
        $progressPercentage = $totalAssignments > 0
            ? min(100, round(($completedAssignments / $totalAssignments) * 100))
            : 0;

        $averageScore = MeetingScore::where('user_id', $userId)->avg('score') ?? 0;

        return compact('totalAssignments', 'completedAssignments', 'progressPercentage', 'averageScore');
    }

    public function getLatestTest(int $userId): mixed
    {
        return FreeTestResult::where('user_id', $userId)->latest()->first();
    }

    public function assignTeacher(mixed $student, ?int $teacherId): string
    {
        if ($teacherId !== null) {
            $teacher = User::findOrFail($teacherId);
            $student->teacher_id = $teacher->id;
            $message = "Student {$student->name} has been assigned to {$teacher->name}.";
        } else {
            $student->teacher_id = null;
            $message = "Student {$student->name} has been unassigned from their teacher.";
        }
        $student->save();
        return $message;
    }

    public function quickUpdate(mixed $student, array $data): void
    {
        if (!empty($data['phone_number'])) {
            $phone = preg_replace('/[^0-9]/', '', $data['phone_number']);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            $student->phone_number = $phone;
        }

        if (!empty($data['referral_code'])) {
            $student->referral_code = strtoupper($data['referral_code']);
        } elseif (isset($data['referral_code']) && $data['referral_code'] === '') {
            if (!$student->referral_code) {
                $student->referral_code = strtoupper(Str::random(8));
            }
        }

        $student->save();
    }

    public function bulkGenerateReferralCodes(): int
    {
        $students = User::where('role', 'student')
            ->where(function ($q) { $q->whereNull('referral_code')->orWhere('referral_code', ''); })
            ->get();

        $updated = 0;
        foreach ($students as $student) {
            do {
                $code = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', strtoupper($student->name)), 0, 3) . Str::random(5));
            } while (User::where('referral_code', $code)->exists());

            $student->referral_code = $code;
            $student->save();
            $updated++;
        }

        return $updated;
    }
}
