<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Contracts\DatabaseHealthChecker;
use Illuminate\Support\Facades\DB;

class LaravelDatabaseHealthChecker implements DatabaseHealthChecker
{
    public function isConnected(): bool
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
