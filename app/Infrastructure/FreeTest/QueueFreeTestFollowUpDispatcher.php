<?php

namespace App\Infrastructure\FreeTest;

use App\Domain\FreeTest\Contracts\FreeTestFollowUpDispatcher;
use App\Jobs\SendOutreachFollowUpJob;

class QueueFreeTestFollowUpDispatcher implements FreeTestFollowUpDispatcher
{
    public function dispatchForResult(mixed $result): void
    {
        SendOutreachFollowUpJob::dispatch($result)->delay(now()->addMinute());
    }
}
