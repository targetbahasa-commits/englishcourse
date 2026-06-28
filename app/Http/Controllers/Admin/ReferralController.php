<?php

namespace App\Http\Controllers\Admin;

use App\Application\Referral\ManageAdminReferrals;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReferralStoreRewardRequest;
use App\Http\Requests\Admin\ReferralUpdateClaimRequest;
use App\Http\Requests\Admin\ReferralUpdateSocialMediaRequest;
use App\Models\SocialMediaSubmission;
use App\Models\UserRewardClaim;

class ReferralController extends Controller
{
    public function __construct(
        private readonly ManageAdminReferrals $manageAdminReferrals
    ) {}

    /**
     * Display the admin referral dashboard.
     */
    public function index()
    {
        [
            'claims' => $claims,
            'rewards' => $rewards,
            'socialSubmissions' => $socialSubmissions,
        ] = $this->manageAdminReferrals->index();

        // Build payment map for claim users: user_id => latest payment
        $claimUserIds = $claims->pluck('user_id')->unique()->filter();
        $paymentMap = \App\Models\Payment::whereIn('user_id', $claimUserIds)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('user_id')
            ->map(fn($g) => $g->first());

        // Build registration lead map for claim users: user_id => lead
        $leadMap = \App\Models\RegistrationLead::whereIn('converted_user_id', $claimUserIds)
            ->whereNotNull('converted_user_id')
            ->get()
            ->keyBy('converted_user_id');

        // Build enrollment map for social submission users
        $socialUserIds = $socialSubmissions->pluck('user_id')->unique()->filter();
        $enrollmentMap = \App\Models\Enrollment::with('program')
            ->whereIn('user_id', $socialUserIds)
            ->where('status', 'active')
            ->get()
            ->keyBy('user_id');

        return view('admin.referrals.index', compact('claims', 'rewards', 'socialSubmissions', 'paymentMap', 'leadMap', 'enrollmentMap'));
    }

    /**
     * Update a reward claim status.
     */
    public function updateClaim(ReferralUpdateClaimRequest $request, $id)
    {
        $claim = UserRewardClaim::findOrFail($id);
        $result = $this->manageAdminReferrals->updateClaim($claim, $request->status, $request->admin_notes);
        if (!$result['ok']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', 'Claim status updated successfully.');
    }

    /**
     * Store a new referral reward.
     */
    public function storeReward(ReferralStoreRewardRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rewards', 'public');
        }

        $this->manageAdminReferrals->createReward([
            'name' => $request->name,
            'description' => $request->description,
            'points_required' => $request->points_required,
            'is_active' => $request->has('is_active'),
            'image' => $imagePath,
        ]);

        return back()->with('success', 'New reward added to catalog.');
    }

    /**
     * Update a social media submission status.
     */
    public function updateSocialMedia(ReferralUpdateSocialMediaRequest $request, $id)
    {
        $submission = SocialMediaSubmission::findOrFail($id);
        $this->manageAdminReferrals->updateSocialMedia(
            $submission,
            $request->status,
            $request->admin_note,
            $request->points_awarded
        );

        return back()->with('success', 'Social media submission status updated successfully.');
    }
}
