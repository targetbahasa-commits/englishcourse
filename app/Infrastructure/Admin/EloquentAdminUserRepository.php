<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Repositories\AdminUserRepository;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EloquentAdminUserRepository implements AdminUserRepository
{
    public function listUsers(array $filters, int $perPage): mixed
    {
        $query = User::with(['teacher', 'program']);

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

        return User::create($data);
    }

    public function update(mixed $user, array $data): void
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
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
        User::whereIn('id', $userIds)->where('role', 'guest')->update([
            'program_id' => $programId,
            'role'       => 'student',
        ]);

        User::whereIn('id', $userIds)->where('role', '!=', 'guest')->update([
            'program_id' => $programId,
        ]);
    }

    public function convertGuest(mixed $user): void
    {
        $user->role = 'student';
        $user->save();
    }
}
