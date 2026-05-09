<?php

namespace App\Domain\IeltsShared;

use App\Domain\IeltsShared\Repositories\IeltsSharedRepository;

class CambridgeAccessPolicy
{
    // Returned when a visitor is not authenticated — they can see the page but need to sign up
    public const NEEDS_SIGNUP = 'needs_signup';

    public function __construct(
        private readonly IeltsSharedRepository $repository,
    ) {}

    /**
     * Returns true if access is granted, self::NEEDS_SIGNUP if the user needs to create an account,
     * or false if the user is authenticated but doesn't have the required enrollment.
     */
    public function canAccess(mixed $user, int $edition, ?int $testId = null): bool|string
    {
        // Unauthenticated visitor — let them see the page with a sign-up popup
        if (!$user) {
            return self::NEEDS_SIGNUP;
        }

        if ($user->isAdmin() || $user->isTeacher()) {
            return true;
        }

        // guest_quick users haven't properly registered yet — show them the signup popup
        if ($user->active_role === 'guest_quick') {
            return self::NEEDS_SIGNUP;
        }

        // Regular guests (who have provided email) can access Cambridge 16 Test 1 for free
        if ($user->active_role === 'guest') {
            return $edition === 16 && $testId === 1;
        }

        if (!$user->isStudent()) {
            return false;
        }

        $editionProgramSlug = 'cambridge-' . $edition;
        $testProgramSlug = $testId ? 'cambridge-' . $edition . '-test-' . $testId : null;

        return $this->repository->hasEnrollmentForPrograms($user->id, $editionProgramSlug, $testProgramSlug);
    }
}
