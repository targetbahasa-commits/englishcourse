<?php

namespace App\Domain\IeltsWriting\Contracts;

interface IeltsWritingLogger
{
    public function info(string $message, array $context = []): void;

    public function warning(string $message, array $context = []): void;

    public function error(string $message, array $context = []): void;
}
