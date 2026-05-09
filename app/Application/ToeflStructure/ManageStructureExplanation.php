<?php

namespace App\Application\ToeflStructure;

use App\Domain\ToeflStructure\Repositories\ToeflStructureRepository;
use RuntimeException;

class ManageStructureExplanation
{
    public function __construct(
        private readonly StructureExplanationPathResolver $pathResolver,
        private readonly ToeflStructureRepository $repository,
    ) {
    }

    public function save(int $number, string $image): void
    {
        $meeting = $this->repository->findMeetingByNumberOrFail($number);

        if (!str_starts_with($image, 'data:image/png;base64,')) {
            throw new RuntimeException('Invalid image format.');
        }

        $binaryData = base64_decode(substr($image, strlen('data:image/png;base64,')));
        if ($binaryData === false) {
            throw new RuntimeException('Invalid image payload.');
        }

        $directory = public_path('uploads/structure-explanations');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($this->pathResolver->resolve((int) $meeting->meeting_number), $binaryData);
    }

    public function resolveDownload(int $number): array
    {
        $meeting = $this->repository->findMeetingByNumberOrFail($number);

        return [
            'absolutePath' => $this->pathResolver->resolve((int) $meeting->meeting_number),
            'filename' => 'structure-explanation-meeting-' . $meeting->meeting_number . '.png',
        ];
    }
}