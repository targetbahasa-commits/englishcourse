<?php

namespace App\Domain\FreeTest\Repositories;

interface FreeTestRepository
{
    public function createResult(array $data): mixed;

    public function findResultOrFail(int $id, int $userId): mixed;

    public function getOutreachMessage(string $testType, string $targetRole, int $minScore, int $maxScore): mixed;

    public function findCertificate(string $testType): mixed;

    public function getLatestResultForUser(int $userId): mixed;

    public function getHistoryForUser(int $userId): array;

    // Admin — Certificate management
    public function allCertificates(array $testTypes): mixed;

    public function firstOrCreateCertificate(string $testType, array $defaults): mixed;

    public function findCertificateById(int $id): mixed;

    public function updateCertificate(mixed $certificate, array $data): void;
}
