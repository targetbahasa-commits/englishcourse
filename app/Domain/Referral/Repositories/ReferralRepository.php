<?php

namespace App\Domain\Referral\Repositories;

interface ReferralRepository
{
    public function getActiveRewards(): array;

    public function findRewardOrFail(int $id): mixed;

    public function createRewardClaim(array $data): void;

    public function referralCodeExists(string $code): bool;

    public function hasSocialSubmissionByUrl(int $userId, string $url): bool;

    public function createSocialSubmission(array $data): void;

    // Admin methods
    public function listClaims(int $perPage): mixed;

    public function listRewards(): array;

    public function listSocialSubmissions(int $perPage): mixed;

    public function findClaimOrFail(int $id): mixed;

    public function updateClaim(mixed $claim, array $data): void;

    public function createReward(array $data): void;

    public function findSocialSubmissionOrFail(int $id): mixed;

    public function updateSocialSubmission(mixed $submission, array $data): void;
}
