<?php

namespace App\Infrastructure\ProgramDiscount;

use App\Domain\ProgramDiscount\Repositories\ProgramDiscountRepository;
use App\Models\ProgramDiscount;

class EloquentProgramDiscountRepository implements ProgramDiscountRepository
{
    public function getDiscountsForProgram(int $programId): mixed
    {
        return \App\Models\ProgramDiscount::where('program_id', $programId)->latest()->get();
    }

    public function createDiscount(mixed $program, array $data): mixed
    {
        return $program->discounts()->create($data);
    }

    public function findOrFail(int $id): mixed
    {
        return ProgramDiscount::findOrFail($id);
    }

    public function update(mixed $discount, array $data): void
    {
        $discount->update($data);
    }

    public function delete(mixed $discount): void
    {
        $discount->delete();
    }
}
