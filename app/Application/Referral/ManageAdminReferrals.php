<?php

namespace App\Application\Referral;

use App\Domain\Referral\Repositories\ReferralRepository;

class ManageAdminReferrals
{
    public function __construct(
        private readonly ReferralRepository $repository
    ) {}

    public function index(): array
    {
        return [
            'claims' => $this->repository->listClaims(15),
            'rewards' => $this->repository->listRewards(),
            'socialSubmissions' => $this->repository->listSocialSubmissions(15),
        ];
    }

    public function updateClaim(mixed $claim, string $status, ?string $adminNotes): array
    {
        if ($status === 'rejected' && $claim->status !== 'rejected') {
            $user = $claim->user;
            if ($user && $claim->reward) {
                $user->increment('referral_points', $claim->reward->points_required);
                $adminNotes = trim(($adminNotes ?? '') . "\n(Points refunded)");
            }
        } elseif ($claim->status === 'rejected' && $status !== 'rejected') {
            $user = $claim->user;
            if ($user && $claim->reward) {
                if ($user->referral_points >= $claim->reward->points_required) {
                    $user->decrement('referral_points', $claim->reward->points_required);
                } else {
                    return ['ok' => false, 'message' => 'Student does not have enough points to reactivate this claim.'];
                }
            }
        }

        $payload = ['status' => $status];
        if ($adminNotes !== null && $adminNotes !== '') {
            $payload['admin_notes'] = $adminNotes;
        }

        $this->repository->updateClaim($claim, $payload);

        return ['ok' => true];
    }

    public function createReward(array $data): void
    {
        $this->repository->createReward($data);
    }

    public function updateSocialMedia(mixed $submission, string $status, ?string $adminNote, ?int $pointsAwarded): void
    {
        $payload = ['status' => $status];

        if ($status === 'approved' && $submission->status !== 'approved') {
            $points = $pointsAwarded ?? 50;
            $user = $submission->user;
            if ($user) {
                $user->increment('referral_points', $points);
                $payload['points_awarded'] = $points;
                $payload['admin_note'] = trim(($adminNote ?? '') . "\n(Awarded {$points} points)");
            }
        } elseif ($submission->status === 'approved' && $status !== 'approved') {
            $user = $submission->user;
            if ($user) {
                $user->decrement('referral_points', $submission->points_awarded);
                $payload['points_awarded'] = 0;
            }
            if (!empty($adminNote)) {
                $payload['admin_note'] = $adminNote;
            }
        } elseif (!empty($adminNote) && $status !== 'approved') {
            $payload['admin_note'] = $adminNote;
        }

        $this->repository->updateSocialSubmission($submission, $payload);
    }
}
