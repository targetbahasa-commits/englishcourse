<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait ResolvesAuthenticatedUser
{
    protected function authenticatedUser(): ?User
    {
        $user = Auth::user();

        return $user instanceof User ? $user : null;
    }
}