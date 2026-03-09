<?php

namespace App\Http\Controllers;

use App\Models\ReferralReward;
use App\Models\UserRewardClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    /**
     * Display the referral dashboard for the student.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure user has a referral code (for older users without one)
        if (empty($user->referral_code)) {
            $newCode = 'TB-' . strtoupper(\Illuminate\Support\Str::random(6));
            while (\App\Models\User::where('referral_code', $newCode)->exists()) {
                $newCode = 'TB-' . strtoupper(\Illuminate\Support\Str::random(6));
            }
            $user->referral_code = $newCode;
            $user->save();
        }

        $referrals = $user->referrals()->latest()->get();
        $rewards = ReferralReward::where('is_active', true)->orderBy('points_required')->get();
        $claims = $user->rewardClaims()->with('reward')->latest()->get();
        $socialSubmissions = $user->socialMediaSubmissions()->latest()->get();

        return view('student.referrals.index', compact('user', 'referrals', 'rewards', 'claims', 'socialSubmissions'));
    }

    /**
     * Submit a claim for a specific reward.
     */
    public function claim(Request $request)
    {
        $request->validate([
            'reward_id' => 'required|exists:referral_rewards,id',
            'shipping_address' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $reward = ReferralReward::findOrFail($request->reward_id);

        if ($user->referral_points < $reward->points_required) {
            return back()->with('error', 'You do not have enough points for this reward.');
        }

        // Deduct points and create claim
        $user->referral_points -= $reward->points_required;
        $user->save();

        UserRewardClaim::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'shipping_address' => $request->shipping_address,
            'status' => 'pending',
        ]);

        return back()->with('success', "Reward '{$reward->name}' claimed successfully! We will process your request shortly.");
    }

    /**
     * Submit a social media post for extra points.
     */
    public function submitSocialMedia(Request $request)
    {
        $request->validate([
            'platform' => 'required|in:tiktok,instagram,youtube,other',
            'url' => 'required|url|max:500',
        ]);

        $user = Auth::user();

        // Prevent spam submissions of the same exact URL
        if (\App\Models\SocialMediaSubmission::where('user_id', $user->id)->where('url', $request->url)->exists()) {
            return back()->with('error', 'Anda sudah pernah mengirimkan link postingan ini sebelumnya.');
        }

        \App\Models\SocialMediaSubmission::create([
            'user_id' => $user->id,
            'platform' => $request->platform,
            'url' => $request->url,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Link berhasil dikirim! Tim kami akan meninjau postingan Anda segera dan menambahkan poin/diskon ke akun Anda.');
    }
}
