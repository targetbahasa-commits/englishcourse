<?php

namespace App\Domain\ToeflMockup\Repositories;

interface MockupResultRepository
{
    public function create(array $attributes): mixed;

    public function findById(int $id): mixed;

    public function listAll(int $perPage): mixed;
}