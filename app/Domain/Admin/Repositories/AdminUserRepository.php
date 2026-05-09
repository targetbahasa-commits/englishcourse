<?php

namespace App\Domain\Admin\Repositories;

interface AdminUserRepository
{
    public function listUsers(array $filters, int $perPage): mixed;

    public function findOrFail(int $id): mixed;

    public function getTeacherOptions(): array;

    public function getProgramOptions(): array;

    public function create(array $data): mixed;

    public function update(mixed $user, array $data): void;

    public function delete(mixed $user): void;

    public function toggleStatus(mixed $user): void;

    public function bulkAssignTeacher(array $userIds, int $teacherId): void;

    public function bulkAssignProgram(array $userIds, int $programId): void;

    public function convertGuest(mixed $user): void;
}
