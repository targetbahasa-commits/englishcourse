<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Auth;

trait RequiresAdminAccess
{
    protected function requireAdmin(): void
    {
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            abort(403);
        }
    }
}
