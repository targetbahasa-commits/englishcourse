<?php

namespace App\Domain\StudentRegistration\Repositories;

interface StudentRegistrationRepository
{
    public function getActivePrograms(): array;

    public function findProgram(int $id): mixed;

    public function createStudent(array $data): mixed;
}
