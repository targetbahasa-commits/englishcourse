<?php

namespace App\Infrastructure\Announcement;

use App\Domain\Announcement\Repositories\AnnouncementRepository;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EloquentAnnouncementRepository implements AnnouncementRepository
{
    public function listVisibleTo(mixed $user, int $perPage): mixed
    {
        return Announcement::query()
            ->active()
            ->visibleTo($user)
            ->latest()
            ->paginate($perPage);
    }

    public function getUnreadIdsIn(mixed $user, array $ids): array
    {
        return $user->unreadAnnouncements()
            ->whereIn('announcements.id', $ids)
            ->pluck('announcements.id')
            ->all();
    }

    public function getAllUnreadIds(mixed $user): array
    {
        return $user->unreadAnnouncements()->pluck('announcements.id')->all();
    }

    public function markAllRead(mixed $user, array $ids): void
    {
        if (!Schema::hasTable('announcement_user_reads') || empty($ids)) {
            return;
        }

        $timestamp = now();

        DB::table('announcement_user_reads')->upsert(
            collect($ids)->map(fn ($announcementId) => [
                'announcement_id' => $announcementId,
                'user_id'         => $user->id,
                'read_at'         => $timestamp,
                'created_at'      => $timestamp,
                'updated_at'      => $timestamp,
            ])->all(),
            ['announcement_id', 'user_id'],
            ['read_at', 'updated_at']
        );
    }

    public function listAll(int $perPage): mixed
    {
        return Announcement::latest()->paginate($perPage);
    }

    public function create(array $data): void
    {
        Announcement::create($data);
    }

    public function update(mixed $announcement, array $data): void
    {
        $announcement->update($data);
    }

    public function delete(mixed $announcement): void
    {
        $announcement->delete();
    }
}
