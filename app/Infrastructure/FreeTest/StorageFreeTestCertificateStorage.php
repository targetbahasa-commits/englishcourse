<?php

namespace App\Infrastructure\FreeTest;

use App\Domain\FreeTest\Contracts\FreeTestCertificateStorage;
use Illuminate\Support\Facades\Storage;

class StorageFreeTestCertificateStorage implements FreeTestCertificateStorage
{
    public function storeUploadedFile(mixed $file): string
    {
        return $file->store('certificates', 'public');
    }

    public function deleteFile(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}
