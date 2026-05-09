<?php

namespace App\Infrastructure\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupResultRepository;
use App\Models\ToeflMockupResult;

class EloquentMockupResultRepository implements MockupResultRepository
{
    public function create(array $attributes): mixed
    {
        return ToeflMockupResult::create($attributes);
    }

    public function findById(int $id): mixed
    {
        return ToeflMockupResult::with('user')->find($id);
    }

    public function listAll(int $perPage): mixed
    {
        return ToeflMockupResult::with('user')->orderBy('created_at', 'desc')->paginate($perPage);
    }
}