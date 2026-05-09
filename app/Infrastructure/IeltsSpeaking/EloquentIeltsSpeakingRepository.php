<?php

namespace App\Infrastructure\IeltsSpeaking;

use App\Domain\IeltsSpeaking\Repositories\IeltsSpeakingRepository;
use App\Models\IeltsSpeakingTopic;

class EloquentIeltsSpeakingRepository implements IeltsSpeakingRepository
{
    public function findOrFail(int $id): mixed
    {
        return IeltsSpeakingTopic::findOrFail($id);
    }

    public function getAllOrdered(): array
    {
        return IeltsSpeakingTopic::orderBy('order')->get()->all();
    }

    public function findBySlug(string $slug): mixed
    {
        return IeltsSpeakingTopic::where('slug', $slug)->first();
    }

    public function create(array $data): void
    {
        IeltsSpeakingTopic::create($data);
    }

    public function update(int $id, array $data): void
    {
        IeltsSpeakingTopic::findOrFail($id)->update($data);
    }

    public function delete(int $id): void
    {
        IeltsSpeakingTopic::findOrFail($id)->delete();
    }
}
