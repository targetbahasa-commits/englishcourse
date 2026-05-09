<?php

namespace App\Domain\ProgramDiscount\Repositories;

interface ProgramDiscountRepository
{
    public function getDiscountsForProgram(int $programId): mixed;

    public function createDiscount(mixed $program, array $data): mixed;

    public function findOrFail(int $id): mixed;

    public function update(mixed $discount, array $data): void;

    public function delete(mixed $discount): void;
}
