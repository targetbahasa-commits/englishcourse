<?php

namespace App\Application\Announcement;

use App\Domain\Announcement\Repositories\AnnouncementRepository;

class GetAnnouncementsForUser
{
    public function __construct(
        private readonly AnnouncementRepository $repository
    ) {
    }

    public function handle(mixed $user, int $perPage = 15): array
    {
        $announcements = $this->repository->listVisibleTo($user, $perPage);
        $visibleIds    = $announcements->getCollection()->pluck('id')->all();

        $justReadIds  = $visibleIds
            ? $this->repository->getUnreadIdsIn($user, $visibleIds)
            : collect();

        $allUnreadIds = $this->repository->getAllUnreadIds($user);

        $this->repository->markAllRead($user, $allUnreadIds->all());

        return [
            'announcements' => $announcements,
            'justReadIds'   => $justReadIds->map(fn ($id) => (int) $id)->all(),
        ];
    }
}
