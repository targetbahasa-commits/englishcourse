<?php

namespace App\Domain\Admin\Contracts;

interface DatabaseHealthChecker
{
    public function isConnected(): bool;
}
