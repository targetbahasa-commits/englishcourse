<?php

namespace App\Domain\Payment\Repositories;


interface PaymentRepository
{
    public function buildQuery(array $filters, bool $withRelations = true): mixed;

    public function getDiscountsForProgram(int $programId): array;

    public function hasUserPaidPayments(int $userId): bool;

    public function hasUserActiveEnrollment(int $userId): bool;
}
