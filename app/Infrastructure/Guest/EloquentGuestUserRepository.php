<?php

namespace App\Infrastructure\Guest;

use App\Domain\Guest\Repositories\GuestUserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EloquentGuestUserRepository implements GuestUserRepository
{
    public function findByEmail(string $email): mixed
    {
        return User::where('email', $email)->first();
    }

    public function createGuestUser(array $data): mixed
    {
        return User::create([
            ...$data,
            'password' => Hash::make($data['password'] ?? Str::random(12)),
        ]);
    }

    public function updateGuestUser(int $userId, array $data): void
    {
        User::findOrFail($userId)->update($data);
    }

    public function createQuickGuestUser(array $data): mixed
    {
        $randomStr = Str::random(6);
        $name = $data['name'] ?? ('Guest-'.$randomStr);
        $phone = $data['phone_number'] ?? null;
        return User::create([
            'name'          => $name,
            'email'         => 'guest_'.strtolower($randomStr).'@quick.targetbahasa.com',
            'phone_number'  => $phone,
            'role'          => 'guest_quick',
            'password'      => '',
            ...$data,
        ]);
    }

    public function findQuickGuestById(int $id): mixed
    {
        return User::where('id', $id)->where('role', 'guest_quick')->first();
    }
}
