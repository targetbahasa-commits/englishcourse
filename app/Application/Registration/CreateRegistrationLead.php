<?php

namespace App\Application\Registration;

use App\Domain\Registration\Repositories\RegistrationRepository;

class CreateRegistrationLead
{
    public function __construct(
        private readonly RegistrationRepository $repository
    ) {
    }

    public function execute(array $data): void
    {
        $this->repository->createRegistrationLead($data);
    }

    public function validateClassPeriod(array $data): ?array
    {
        if (empty($data['class_period_id'])) {
            return null;
        }

        $selectedPeriod = $this->repository->findClassPeriod((int) $data['class_period_id']);

        if (! $selectedPeriod || ! in_array($selectedPeriod->status, ['active', 'upcoming'], true)) {
            return ['class_period_id' => 'Batch kelas tidak tersedia.'];
        }

        if (! empty($data['program_id']) && (int) $selectedPeriod->program_id !== (int) $data['program_id']) {
            return ['class_period_id' => 'Batch tidak sesuai dengan program yang dipilih.'];
        }

        if ($data['mode'] !== 'flexible' && $selectedPeriod->learning_mode !== $data['mode']) {
            return ['class_period_id' => 'Batch tidak sesuai dengan mode belajar yang dipilih.'];
        }

        return null;
    }
}
