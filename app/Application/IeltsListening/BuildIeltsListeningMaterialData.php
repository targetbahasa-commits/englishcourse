<?php

namespace App\Application\IeltsListening;

use App\Domain\IeltsListening\Repositories\IeltsListeningRepository;

class BuildIeltsListeningMaterialData
{
    public function __construct(
        private readonly IeltsListeningRepository $repository,
    ) {}

    private const MATERIALS = [
        1 => 'Multiple Choice',
        2 => 'Matching',
        3 => 'Note Completion',
        4 => 'Form Completion',
        5 => 'Table Completion',
        6 => 'Sentence Completion',
        7 => 'Summary Completion',
        8 => 'Short Answer',
        9 => 'Map & Plan Labelling',
        10 => 'Diagrams & Flowcharts',
        11 => 'Mixed Exercise',
    ];

    public function material(int $id, int $practice): array
    {
        if (!array_key_exists($id, self::MATERIALS)) {
            abort(404);
        }

        $title = self::MATERIALS[$id];
        $material = $this->repository->findOrCreateMaterialByTypeId($id, ['title' => $title]);

        return [
            'title' => $title,
            'id' => $id,
            'material' => $material,
            'practice' => $practice,
        ];
    }
}