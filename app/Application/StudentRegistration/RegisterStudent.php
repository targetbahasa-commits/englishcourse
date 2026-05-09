<?php

namespace App\Application\StudentRegistration;

use App\Domain\StudentRegistration\Repositories\StudentRegistrationRepository;

class RegisterStudent
{
    public function __construct(
        private readonly StudentRegistrationRepository $repository
    ) {
    }

    public function execute(array $data): mixed
    {
        $program = $data['program_id'] ? $this->repository->findProgram($data['program_id']) : null;

        return $this->repository->createStudent([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'],
            'password'     => $data['password'],
            'role'         => 'student',
            'status'       => 'active',
            'program_id'   => $program?->id,
        ]);
    }
}
