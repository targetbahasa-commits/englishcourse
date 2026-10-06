<?php

namespace App\Infrastructure\Program;

use App\Domain\Program\Contracts\ProgramBrochureStorage;
use Illuminate\Support\Facades\Storage;

class StorageProgramBrochureStorage implements ProgramBrochureStorage
{
    public function storeUploadedFile(mixed $file): string
    {
        return $file->store('brochures', 'public');
    }

    public function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    public function storeDraftImage(string $binaryContents, string $extension): string
    {
        $path = 'brochures/ai-drafts/' . uniqid('ai-', true) . '.' . $extension;
        Storage::disk('public')->put($path, $binaryContents);

        return $path;
    }

    public function promoteDraft(string $draftPath): string
    {
        $extension = pathinfo($draftPath, PATHINFO_EXTENSION) ?: 'png';
        $finalPath = 'brochures/' . uniqid('ai-', true) . '.' . $extension;

        Storage::disk('public')->move($draftPath, $finalPath);

        return $finalPath;
    }
}
