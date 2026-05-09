<?php

namespace App\Application\ToeflMockup;

use App\Domain\ToeflMockup\Repositories\MockupMediaRepository;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class UploadMockupDirectionAudio
{
    public function __construct(
        private readonly MockupMediaRepository $mediaRepository,
        private readonly MockupMediaStorage $mediaStorage,
    ) {
    }

    public function handle(int $package, string $directionPart, ?UploadedFile $audioFile, ?string $existingAudioPath): array
    {
        $part = strtoupper($directionPart);
        if (!in_array($part, ['A', 'B', 'C'], true)) {
            throw new RuntimeException('Bagian directions tidak valid.');
        }

        $directory = 'audio/toefl-itp/mockup/package-' . $package . '/directions';
        $publicPath = $this->mediaStorage->ensurePublicDirectoryExists($directory);
        $selectedPath = $this->mediaStorage->resolveSelectedAudioPath($audioFile, $existingAudioPath, $publicPath, $directory, 'direction-part-' . strtolower($part));

        $column = match ($part) {
            'A' => 'audio_part_a',
            'B' => 'audio_part_b',
            'C' => 'audio_part_c',
        };

        $this->mediaRepository->updateListeningDirectionAudio($package, $column, $selectedPath);

        return ['message' => 'Audio directions Part ' . $part . ' berhasil disimpan.'];
    }
}