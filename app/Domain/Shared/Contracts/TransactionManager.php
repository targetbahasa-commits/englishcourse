<?php

namespace App\Domain\Shared\Contracts;

interface TransactionManager
{
    public function run(callable $callback): void;
}
