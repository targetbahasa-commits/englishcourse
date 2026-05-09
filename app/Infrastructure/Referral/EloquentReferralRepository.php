<?php

namespace App\Infrastructure\Referral;

use App\Domain\Referral\Repositories\ReferralRepository;
use App\Models\ReferralReward;
use App\Models\SocialMediaSubmission;
use App\Models\User;
use App\Models\UserRewardClaim;

class EloquentReferralRepository implements ReferralRepository
{
    public function getActiveRewards(): array
    {
        return ReferralReward::where('is_active', true)
            ->orderBy('points_required')
            ->get()->all();
    }

    public function findRewardOrFail(int $id): mixed
    {
        return ReferralReward::findOrFail($id);
    }

    public function createRewardClaim(array $data): void
    {
        UserRewardClaim::create($data);
    }

    public function referralCodeExists(string $code): bool
    {
        return User::where('referral_code', $code)->exists();
    }

    public function hasSocialSubmissionByUrl(int $userId, string $url): bool
    {
        return SocialMediaSubmission::where('user_id', $userId)
            ->where('url', $url)
            ->exists();
    }

    public function createSocialSubmission(array $data): void
    {
        SocialMediaSubmission::create($data);
    }

    public function listClaims(int $perPage): mixed
    {
        return UserRewardClaim::with(['user', 'reward'])
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->latest()
            ->paginate($perPage);
    }

    public function listRewards(): array
    {
        return ReferralReward::orderBy('points_required')->get()->all();
    }

    public function listSocialSubmissions(int $perPage): mixed
    {
        return SocialMediaSubmission::with('user')
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->latest()
            ->paginate($perPage, ['*'], 'social_page');
    }

    public function findClaimOrFail(int $id): mixed
    {
        return UserRewardClaim::findOrFail($id);
    }

    public function updateClaim(mixed $claim, array $data): void
    {
        $claim->update($data);
    }

    public function createReward(array $data): void
    {
        ReferralReward::create($data);
    }

    public function findSocialSubmissionOrFail(int $id): mixed
    {
        return SocialMediaSubmission::findOrFail($id);
    }

    public function updateSocialSubmission(mixed $submission, array $data): void
    {
        $submission->update($data);
    }
}
