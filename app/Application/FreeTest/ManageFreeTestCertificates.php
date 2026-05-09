<?php

namespace App\Application\FreeTest;

use App\Domain\FreeTest\Contracts\FreeTestCertificateStorage;
use App\Domain\FreeTest\Repositories\FreeTestRepository;

class ManageFreeTestCertificates
{
    private const TEST_TYPES = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];

    public function __construct(
        private readonly FreeTestRepository $repository,
        private readonly FreeTestCertificateStorage $certificateStorage,
    ) {}

    public function listAll(): mixed
    {
        return $this->repository->allCertificates(self::TEST_TYPES);
    }

    public function findOrFail(int $id): mixed
    {
        return $this->repository->findCertificateById($id);
    }

    public function update(mixed $certificate, array $data, mixed $backgroundImageFile = null): void
    {
        if ($backgroundImageFile !== null) {
            if ($certificate->background_image) {
                $this->certificateStorage->deleteFile($certificate->background_image);
            }
            $data['background_image'] = $this->certificateStorage->storeUploadedFile($backgroundImageFile);
        }

        $this->repository->updateCertificate($certificate, $data);
    }
}
