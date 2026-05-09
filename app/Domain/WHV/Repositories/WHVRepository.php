<?php

namespace App\Domain\WHV\Repositories;

interface WHVRepository
{
    public function findFeaturedApplication(): mixed;
}
