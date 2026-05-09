<?php

namespace App\Application\IeltsSpeaking;

use App\Domain\IeltsSpeaking\Repositories\IeltsSpeakingRepository;

class GetAllIeltsSpeakingTopics
{
    public function __construct(
        private readonly IeltsSpeakingRepository $repository
    ) {
    }

    public function getAllOrdered(): array
    {
        return $this->repository->getAllOrdered();
    }

    public function findBySlug(string $slug): mixed
    {
        return $this->repository->findBySlug($slug);
    }
}
