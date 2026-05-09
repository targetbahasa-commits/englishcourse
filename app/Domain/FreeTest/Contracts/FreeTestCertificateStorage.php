<?php

namespace App\Domain\FreeTest\Contracts;

interface FreeTestCertificateStorage
{
    public function storeUploadedFile(mixed $file): string;

    public function deleteFile(string $path): void;
}
