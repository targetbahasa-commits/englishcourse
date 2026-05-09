<?php

namespace App\Application\ProgramDiscount;

use App\Domain\ProgramDiscount\Repositories\ProgramDiscountRepository;

class ManageProgramDiscounts
{
    public function __construct(
        private readonly ProgramDiscountRepository $repository
    ) {}

    public function listForProgram(mixed $program): mixed
    {
        return $this->repository->getDiscountsForProgram($program->id);
    }

    public function create(mixed $program, array $data, mixed $request): void
    {
        $conditions = null;
        if ($data['type'] === 'holiday' && !empty($data['start_date'])) {
            $conditions = [
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'] ?? $data['start_date'],
            ];
        } elseif ($data['type'] === 'region' && !empty($data['regions'])) {
            $regions = array_map('trim', explode(',', $data['regions']));
            $conditions = ['regions' => array_filter($regions)];
        }

        $this->repository->createDiscount($program, [
            'type'           => $data['type'],
            'label'          => $data['label'],
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'conditions'     => $conditions,
            'is_active'      => $request->boolean('is_active', true),
        ]);
    }

    public function toggleActive(mixed $discount): void
    {
        $this->repository->update($discount, ['is_active' => !$discount->is_active]);
    }

    public function update(mixed $discount, array $data, mixed $request): void
    {
        $conditions = $discount->conditions;
        if ($discount->type === 'holiday' && !empty($data['start_date'])) {
            $conditions = [
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'] ?? $data['start_date'],
            ];
        } elseif ($discount->type === 'region' && !empty($data['regions'])) {
            $regions = array_map('trim', explode(',', $data['regions']));
            $conditions = ['regions' => array_filter($regions)];
        }

        $this->repository->update($discount, [
            'label'          => $data['label'],
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'conditions'     => $conditions,
            'is_active'      => $request->boolean('is_active', true),
        ]);
    }

    public function delete(mixed $discount): void
    {
        $this->repository->delete($discount);
    }
}
