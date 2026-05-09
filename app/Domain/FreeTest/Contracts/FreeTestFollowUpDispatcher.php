<?php

namespace App\Domain\FreeTest\Contracts;

interface FreeTestFollowUpDispatcher
{
    public function dispatchForResult(mixed $result): void;
}
