<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Repositories\AdminUserRepository;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EloquentAdminUserRepository implements AdminUserRepository
{
    public function listUsers(array $filters, int $perPage): mixed
    {
        $query = User::with(['teacher', 'program', 'classPeriod']);

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['role'])) {
            $query->byRole($filters['role']);
        }

        if (!empty($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        if (!empty($filters['program_id'])) {
            $query->where('program_id', $filters['program_id']);
        }

        return $query->latest()->paginate($perPage)->withQueryString();
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
        return Program::all()->all();
    }

    public function create(array $data): mixed
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $programIds = [];
        if (isset($data['program_ids']) && is_array($data['program_ids'])) {
            $programIds = array_map('intval', $data['program_ids']);
        }
        if (!empty($data['program_id'])) {
            $programIds[] = (int) $data['program_id'];
        }
        $programIds = array_values(array_unique(array_filter($programIds)));

        $teacherIds = $data['teacher_ids'] ?? [];
        $classPeriodIds = $data['class_period_ids'] ?? [];

        if (!empty($programIds)) {
            $primaryProgramId = $programIds[0];
            $data['program_id'] = $primaryProgramId;
            $data['teacher_id'] = $this->resolvePerProgramId($teacherIds, $primaryProgramId);
            $data['class_period_id'] = $this->resolvePerProgramId($classPeriodIds, $primaryProgramId);
        }

        $user = User::create($data);

        foreach ($programIds as $pId) {
            $this->enrollUserInProgram(
                $user,
                $pId,
                $this->resolvePerProgramId($teacherIds, $pId),
                $this->resolvePerProgramId($classPeriodIds, $pId)
            );
        }

        return $user;
    }

    public function update(mixed $user, array $data): void
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $programIds = null;
        if (array_key_exists('program_ids', $data)) {
            $programIds = is_array($data['program_ids']) ? array_map('intval', $data['program_ids']) : [];
        }
        if (!empty($data['program_id'])) {
            if ($programIds === null) {
                $programIds = [];
            }
            $programIds[] = (int) $data['program_id'];
        }

        $teacherIds = $data['teacher_ids'] ?? [];
        $classPeriodIds = $data['class_period_ids'] ?? [];

        if ($programIds !== null) {
            $programIds = array_values(array_unique(array_filter($programIds)));
            $primaryProgramId = $programIds[0] ?? null;
            $data['program_id'] = $primaryProgramId;
            $data['teacher_id'] = $primaryProgramId ? $this->resolvePerProgramId($teacherIds, $primaryProgramId) : null;
            $data['class_period_id'] = $primaryProgramId ? $this->resolvePerProgramId($classPeriodIds, $primaryProgramId) : null;
        }

        $user->update($data);

        if ($programIds !== null) {
            // Actively enroll selected programs
            foreach ($programIds as $pId) {
                $this->enrollUserInProgram(
                    $user,
                    $pId,
                    $this->resolvePerProgramId($teacherIds, $pId),
                    $this->resolvePerProgramId($classPeriodIds, $pId)
                );
            }

            // Drop any enrollments not selected in the new list
            \App\Models\Enrollment::where('user_id', $user->id)
                ->whereNotIn('program_id', $programIds)
                ->update(['status' => 'dropped']);

            \App\Models\ProgramAccess::where('user_id', $user->id)
                ->whereNotIn('program_id', $programIds)
                ->delete();
        }
    }

    /**
     * Pulls the teacher/class-period id submitted for one specific program out of the
     * admin form's teacher_ids[program_id] / class_period_ids[program_id] arrays. An
     * empty/missing entry means the admin explicitly left that program's row blank.
     */
    private function resolvePerProgramId(mixed $map, int $programId): ?int
    {
        if (!is_array($map)) {
            return null;
        }
        $value = $map[$programId] ?? null;
        return ($value !== null && $value !== '') ? (int) $value : null;
    }

    /**
     * Create/reactivate a student's Enrollment for a program via the admin multi-program
     * form, which renders one Teacher and one Batch/Class Period selector per checked
     * program - so $teacherId/$classPeriodId here are already scoped to this exact
     * program, not guessed from a single shared field.
     */
    private function enrollUserInProgram(User $user, int $programId, ?int $teacherId, ?int $classPeriodId): void
    {
        $attributes = [
            'status' => 'active',
            'teacher_id' => $teacherId,
            'class_period_id' => $classPeriodId,
        ];

        $existing = Enrollment::where('user_id', $user->id)->where('program_id', $programId)->first();
        if ($existing) {
            $existing->update($attributes);
            return;
        }

        Enrollment::create(array_merge([
            'user_id' => $user->id,
            'program_id' => $programId,
        ], $attributes));
    }

    public function delete(mixed $user): void
    {
        $user->delete();
    }

    public function toggleStatus(mixed $user): void
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
    }

    public function bulkAssignTeacher(array $userIds, int $teacherId): void
    {
        User::whereIn('id', $userIds)->update(['teacher_id' => $teacherId]);
    }

    public function bulkAssignProgram(array $userIds, int $programId): void
    {
        $users = User::whereIn('id', $userIds)->get();
        foreach ($users as $user) {
            if ($user->program_id && $user->program_id != $programId) {
                \App\Models\Enrollment::where('user_id', $user->id)
                    ->where('program_id', $user->program_id)
                    ->update(['status' => 'dropped']);
                
                \App\Models\ProgramAccess::where('user_id', $user->id)
                    ->where('program_id', $user->program_id)
                    ->delete();
            }
        }

        User::whereIn('id', $userIds)->where('role', 'guest')->update([
            'program_id' => $programId,
            'role'       => 'student',
            'converted_from_guest_at' => now(),
        ]);

        User::whereIn('id', $userIds)->where('role', '!=', 'guest')->update([
            'program_id' => $programId,
        ]);
    }

    public function convertGuest(mixed $user): void
    {
        $user->role = 'student';
        $user->converted_from_guest_at = now();
        $user->save();
    }
}
