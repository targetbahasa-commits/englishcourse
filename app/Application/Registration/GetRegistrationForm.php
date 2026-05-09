<?php

namespace App\Application\Registration;

use App\Domain\Registration\Repositories\RegistrationRepository;

class GetRegistrationForm
{
    public function __construct(
        private readonly RegistrationRepository $repository
    ) {
    }

    public function execute(): array
    {
        return [
            'programs'     => $this->repository->getActivePrograms(),
            'classPeriods' => $this->repository->getActiveAndUpcomingClassPeriods(),
        ];
    }
}
