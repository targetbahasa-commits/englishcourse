<?php

namespace App\Repositories\Eloquent;

use App\Models\FreeTestSubmission;
use App\Repositories\Contracts\LeadRepositoryInterface;

class LeadRepository implements LeadRepositoryInterface
{
    public function getPaginatedLeads(?string $status, ?string $search, int $perPage = 15)
    {
        $query = FreeTestSubmission::query()->orderBy('created_at', 'desc');

        if (!empty($status)) {
            $query->where('follow_up_status', $status);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp_number', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function countAll(): int
    {
        return FreeTestSubmission::count();
    }

    public function countByStatus(string $status): int
    {
        return FreeTestSubmission::where('follow_up_status', $status)->count();
    }

    public function updateStatus(int $id, string $status): bool
    {
        return FreeTestSubmission::where('id', $id)->update([
            'follow_up_status' => $status,
            'updated_at' => now(),
        ]) > 0;
    }
}
