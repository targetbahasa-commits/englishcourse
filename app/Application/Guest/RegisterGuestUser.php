<?php

namespace App\Application\Guest;

use App\Domain\Guest\Repositories\GuestUserRepository;

/**
 * Handles guest user registration (new guest or upgrade from guest_quick).
 */
class RegisterGuestUser
{
    public function __construct(
        private readonly GuestUserRepository $guestUserRepository,
    ) {}

    /**
     * Register or upgrade a guest user.
     *
     * If the authenticated user is a guest_quick, upgrade them to a full guest.
     * Otherwise, create a brand-new guest user and log them in.
     *
     * @param  array{name: string, email: string, phone_number: string}  $data
     * @return mixed  The user model instance.
     */
    public function handle(array $data, mixed $currentUser = null): mixed
    {
        if ($currentUser && $currentUser->role === 'guest_quick') {
            $this->guestUserRepository->updateGuestUser($currentUser->id, [
                'name'         => $data['name'],
                'email'        => $data['email'],
                'phone_number' => $data['phone_number'],
                'role'         => 'guest',
            ]);

            return $currentUser->fresh();
        }

        return $this->guestUserRepository->createGuestUser([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'],
            'role'         => 'guest',
            'password'     => '',
        ]);
    }
}
