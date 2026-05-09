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
}
