<?php

namespace App\Domain\IeltsWriting\Contracts;

interface IeltsWritingAiHttpClient
{
    public function postJson(string $url, array $payload, int $timeout): ?array;
}
