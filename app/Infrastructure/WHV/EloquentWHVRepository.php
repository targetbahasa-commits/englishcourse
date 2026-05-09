<?php

namespace App\Infrastructure\WHV;

use App\Domain\WHV\Repositories\WHVRepository;
use App\Models\WHVApplication;

class EloquentWHVRepository implements WHVRepository
{
    public function findFeaturedApplication(): mixed
    {
        return WHVApplication::where('is_active', true)
            ->where('status', 'open')
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now()->startOfDay());
            })
            ->orderByRaw('opening_date IS NULL, opening_date DESC')
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
