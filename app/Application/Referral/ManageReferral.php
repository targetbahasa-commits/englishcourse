<?php

namespace App\Application\Referral;

use App\Domain\Referral\Repositories\ReferralRepository;
use Illuminate\Support\Str;

class ManageReferral
{
    public function __construct(
        private readonly ReferralRepository $repository
    ) {
    }

    public function getActiveRewards(): array
    {
        return $this->repository->getActiveRewards();
    }

    public function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(6));
        } while ($this->repository->referralCodeExists($code));

        return $code;
    }

    public function claim(mixed $user, int $rewardId, ?string $shippingAddress): void
    {
        $reward = $this->repository->findRewardOrFail($rewardId);

        if ($user->referral_points < $reward->points_required) {
            throw new \RuntimeException('You do not have enough points for this reward.');
        }

        $user->referral_points -= $reward->points_required;
        $user->save();

        $this->repository->createRewardClaim([
            'user_id'          => $user->id,
            'reward_id'        => $reward->id,
            'shipping_address' => $shippingAddress,
            'status'           => 'pending',
        ]);
    }

    public function submitSocialMedia(mixed $user, string $platform, string $url): void
    {
        if ($this->repository->hasSocialSubmissionByUrl($user->id, $url)) {
            throw new \RuntimeException('Anda sudah pernah mengirimkan link postingan ini sebelumnya.');
        }

        $this->repository->createSocialSubmission([
            'user_id'  => $user->id,
            'platform' => $platform,
            'url'      => $url,
            'status'   => 'pending',
        ]);
    }
}
