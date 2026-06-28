<?php

namespace App\Infrastructure\Teacher;

use App\Domain\Teacher\Repositories\TeacherRepository;
use App\Models\ClassPeriod;
use App\Models\TeacherEvaluation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EloquentTeacherRepository implements TeacherRepository
{
    public function searchTeachers(array $filters = []): mixed
    {
        $query = User::where('role', 'teacher')->withCount(['students', 'classes']);

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%'.$filters['search'].'%')
                    ->orWhere('email', 'like', '%'.$filters['search'].'%');
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(15)->withQueryString();
    }

    public function getUnassignedStudents(): array
    {
        return User::where('role', 'student')
            ->whereNull('teacher_id')
            ->where('status', 'active')
            ->get()->all();
    }

    public function getUnassignedClasses(): array
    {
        return ClassPeriod::with('program')
            ->whereNull('teacher_id')
            ->whereIn('status', ['active', 'upcoming'])
            ->orderBy('batch_number')
            ->get()->all();
    }

    public function findTeacher(int $id): mixed
    {
        return User::with(['classes.students', 'students.program'])->findOrFail($id);
    }

    public function assignStudentToTeacher(int $teacherId, int $studentId): void
    {
        $student = User::findOrFail($studentId);
        $student->teacher_id = $teacherId;
        $student->save();
    }

    public function unassignStudent(int $teacherId, int $studentId): void
    {
        $student = User::findOrFail($studentId);
        $student->teacher_id = null;
        $student->save();
    }

    public function assignClassToTeacher(int $teacherId, int $classPeriodId): void
    {
        $classPeriod = ClassPeriod::findOrFail($classPeriodId);
        $classPeriod->teacher_id = $teacherId;
        $classPeriod->save();
    }

    public function listEvaluations(array $filters, int $perPage): mixed
    {
        $query = TeacherEvaluation::with(['student', 'teacher']);

        if (!empty($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getTeachersWithEvaluations(): array
    {
        // Include all teachers so the admin filter can choose any teacher, not only those with existing evaluations.
        return User::where('role', 'teacher')
            ->orderBy('name')
            ->get()
            ->all();
    }

    public function getAverageRating(): float
    {
        return (float) (TeacherEvaluation::avg('rating') ?? 0);
    }

    public function countEvaluations(): int
    {
        return TeacherEvaluation::count();
    }

    public function getTopTeachers(int $limit): array
    {
        return User::select('users.id', 'users.name', DB::raw('AVG(teacher_evaluations.rating) as avg_rating'), DB::raw('COUNT(teacher_evaluations.id) as total_reviews'))
            ->join('teacher_evaluations', 'users.id', '=', 'teacher_evaluations.teacher_id')
            ->groupBy('users.id', 'users.name')
            ->having('total_reviews', '>=', 1)
            ->orderByDesc('avg_rating')
            ->orderByDesc('total_reviews')
            ->take($limit)
            ->get()->all();
    }

    public function getTeacherForEvaluation(int $teacherId): mixed
    {
        return User::findOrFail($teacherId);
    }

    public function saveTeacherEvaluation(int $studentId, int $teacherId, int $rating, ?string $comment = null): void
    {
        TeacherEvaluation::create([
            'student_id' => $studentId,
            'teacher_id' => $teacherId,
            'rating' => $rating,
            'comment' => $comment,
        ]);
    }

    public function countTeachers(): int
    {
        return User::where('role', 'teacher')->count();
    }

    public function getTeacherRecentEvaluations(int $teacherId, int $limit = 5): array
    {
        return TeacherEvaluation::with('student')
            ->where('teacher_id', $teacherId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->all();
    }

    public function getTeacherAverageRating(int $teacherId): float
    {
        return (float) (TeacherEvaluation::where('teacher_id', $teacherId)->avg('rating') ?? 0);
    }

    public function getUpcomingClassesForTeacher(int $teacherId): array
    {
        return ClassPeriod::where('teacher_id', $teacherId)
            ->whereIn('status', ['active', 'upcoming'])
            ->withCount('users as students_count')
            ->get()
            ->all();
    }
}
