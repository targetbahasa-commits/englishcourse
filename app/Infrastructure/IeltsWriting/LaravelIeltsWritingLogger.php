<?php

namespace App\Infrastructure\IeltsWriting;

use App\Domain\IeltsWriting\Contracts\IeltsWritingLogger;
use Illuminate\Support\Facades\Log;

class LaravelIeltsWritingLogger implements IeltsWritingLogger
{
    public function info(string $message, array $context = []): void
    {
        Log::info($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        Log::warning($message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        Log::error($message, $context);
    }
}
