<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Repositories\AdminUserRepository;
use App\Models\ClassPeriod;
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

        if (!empty($programIds)) {
            $data['program_id'] = $programIds[0];
        }

        $user = User::create($data);

        foreach ($programIds as $pId) {
            $this->enrollUserInProgram($user, $pId);
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

        if ($programIds !== null) {
            $programIds = array_values(array_unique(array_filter($programIds)));
            $data['program_id'] = !empty($programIds) ? $programIds[0] : null;
        }

        $user->update($data);

        if ($programIds !== null) {
            // Actively enroll selected programs
            foreach ($programIds as $pId) {
                $this->enrollUserInProgram($user, $pId);
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
     * Create/reactivate a student's Enrollment for a program via the admin multi-program
     * checkbox form. This form only exposes one class_period_id selector for however many
     * programs are ticked, so $user->class_period_id is NOT necessarily valid for $programId
     * (it may belong to a different program entirely, or be null). Only ever apply it when
     * it demonstrably belongs to this program; never overwrite an existing enrollment's
     * class_period_id through this generic path (that field is set correctly by the
     * dedicated payment-approval / assign-to-class-period flows, which know exactly which
     * class period a specific program-enrollment belongs to).
     */
    private function enrollUserInProgram(User $user, int $programId): void
    {
        $existing = Enrollment::where('user_id', $user->id)->where('program_id', $programId)->first();

        if ($existing) {
            $existing->update(['status' => 'active']);
            return;
        }

        $classPeriodId = null;
        if ($user->class_period_id) {
            $ownsProgram = ClassPeriod::where('id', $user->class_period_id)
                ->where('program_id', $programId)
                ->exists();
            if ($ownsProgram) {
                $classPeriodId = $user->class_period_id;
            }
        }

        Enrollment::create([
            'user_id' => $user->id,
            'program_id' => $programId,
            'class_period_id' => $classPeriodId,
            'status' => 'active',
        ]);
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
