<?php

namespace App\Domain\Program\Contracts;

interface ProgramBrochureStorage
{
    public function storeUploadedFile(mixed $file): string;

    public function deleteFile(?string $path): void;
}
