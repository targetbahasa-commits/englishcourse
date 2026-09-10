<?php

namespace App\Application\Admin;

use App\Domain\Admin\Repositories\AdminUserRepository;

class ManageUsers
{
    public function __construct(
        private readonly AdminUserRepository $repository
    ) {}

    public function listAll(array $filters, int $perPage = 15): mixed
    {
        return $this->repository->listUsers($filters, $perPage);
    }

    public function formOptions(): array
    {
        return [
            'teachers'     => $this->repository->getTeacherOptions(),
            'programs'     => $this->repository->getProgramOptions(),
            'camps'        => \App\Models\Camp::with('rooms')->get(),
            'classPeriods' => \App\Models\ClassPeriod::with('program')->latest()->get(),
        ];
    }

    public function create(array $validated, mixed $request): mixed
    {
        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $this->storeProfilePhoto($request->file('profile_photo'));
        }

        if (isset($validated['role']) && $validated['role'] === 'guest' && !empty($validated['program_id'])) {
            $validated['role'] = 'student';
        }

        return $this->repository->create($validated);
    }

    public function update(mixed $user, array $validated, mixed $request): void
    {
        if ($request->hasFile('profile_photo')) {
            $this->deleteProfilePhoto($user->profile_photo);
            $validated['profile_photo'] = $this->storeProfilePhoto($request->file('profile_photo'));
        }

        if (isset($validated['role']) && $validated['role'] === 'guest' && !empty($validated['program_id'])) {
            $validated['role'] = 'student';
        }

        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        $this->repository->update($user, $validated);
    }

    public function delete(mixed $user): void
    {
        $this->deleteProfilePhoto($user->profile_photo);
        $this->repository->delete($user);
    }

    public function toggleStatus(mixed $user): mixed
    {
        $this->repository->toggleStatus($user);
        return $user;
    }

    public function bulkAssignTeacher(array $userIds, int $teacherId): void
    {
        $this->repository->bulkAssignTeacher($userIds, $teacherId);
    }

    public function bulkAssignProgram(array $userIds, int $programId): void
    {
        $this->repository->bulkAssignProgram($userIds, $programId);
    }

    public function convertGuest(mixed $user): void
    {
        $this->repository->convertGuest($user);
    }

    private function storeProfilePhoto(mixed $file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/profiles'), $filename);
        return 'uploads/profiles/' . $filename;
    }

    private function deleteProfilePhoto(?string $relativePath): void
    {
        if ($relativePath && file_exists(public_path($relativePath))) {
            unlink(public_path($relativePath));
        }
    }
}
