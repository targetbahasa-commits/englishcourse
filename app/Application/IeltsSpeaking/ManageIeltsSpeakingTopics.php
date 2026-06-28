<?php

namespace App\Application\IeltsSpeaking;

use App\Domain\IeltsSpeaking\Repositories\IeltsSpeakingRepository;

class ManageIeltsSpeakingTopics
{
    public function __construct(
        private readonly IeltsSpeakingRepository $repository
    ) {}

    public function toggleLock(int $id): bool
    {
        $topic = $this->repository->findOrFail($id);
        $topic->update(['is_locked' => !$topic->is_locked]);

        return (bool) $topic->is_locked;
    }

    public function create(array $attributes): void
    {
        $this->repository->create([
            'title'     => $attributes['title'],
            'slug'      => $attributes['slug'],
            'icon'      => $attributes['icon'],
            'color'     => $attributes['color'] ?? 'indigo',
            'order'     => $attributes['order'] ?? 0,
            'is_free_tier' => $attributes['is_free_tier'] ?? false,
            'test_type' => $attributes['test_type'] ?? null,
            'system_prompt_override' => $attributes['system_prompt_override'] ?? null,
            'questions' => [],
            'subtopics' => [],
            'is_locked' => false,
        ]);
    }

    public function update(int $id, array $attributes): void
    {
        $topic = $this->repository->findOrFail($id);

        $this->repository->update($id, [
            'title' => $attributes['title'],
            'slug'  => $attributes['slug'],
            'icon'  => $attributes['icon'],
            'color' => $attributes['color'] ?? $topic->color,
            'order' => $attributes['order'] ?? $topic->order,
            'is_free_tier' => $attributes['is_free_tier'] ?? $topic->is_free_tier,
            'test_type' => $attributes['test_type'] ?? $topic->test_type,
            'system_prompt_override' => $attributes['system_prompt_override'] ?? $topic->system_prompt_override,
        ]);
    }

    public function destroy(int $id): void
    {
        $this->repository->delete($id);
    }
}

