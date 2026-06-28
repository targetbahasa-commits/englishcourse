<?php

namespace App\Http\Controllers;

use App\Application\Referral\ManageReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function __construct(
        private readonly ManageReferral $manageReferral,
    ) {
    }

    public function index()
    {
        $user = Auth::user();

        if (empty($user->referral_code)) {
            $user->referral_code = $this->manageReferral->generateUniqueCode();
            $user->save();
        }

        $referrals         = $user->referrals()->latest()->get();
        $rewards           = $this->manageReferral->getActiveRewards();
        $claims            = $user->rewardClaims()->with('reward')->latest()->get();
        $socialSubmissions = $user->socialMediaSubmissions()->latest()->get();

        return view('student.referrals.index', compact('user', 'referrals', 'rewards', 'claims', 'socialSubmissions'));
    }

    public function claim(Request $request)
    {
        $request->validate([
            'reward_id'        => 'required|exists:referral_rewards,id',
            'shipping_address' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        try {
            $this->manageReferral->claim($user, (int) $request->reward_id, $request->shipping_address);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "Reward claimed successfully! We will process your request shortly.");
    }

    public function submitSocialMedia(Request $request)
    {
        $request->validate([
            'platform' => 'required|in:tiktok,instagram,youtube,other',
            'url'      => 'required|url|max:500',
        ]);

        $user = Auth::user();

        try {
            $this->manageReferral->submitSocialMedia($user, $request->platform, $request->url);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Link berhasil dikirim! Tim kami akan meninjau postingan Anda segera dan menambahkan poin/diskon ke akun Anda.');
    }

    public function verify(Request $request)
    {
        $code = trim($request->input('code', ''));

        if (!$code) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode referral tidak boleh kosong.'
            ], 400);
        }

        $user = \App\Models\User::where('referral_code', $code)->first();

        if ($user) {
            return response()->json([
                'valid' => true,
                'message' => 'Kode referral valid!',
                'referrer_name' => $user->name,
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => 'Kode referral tidak ditemukan.'
        ], 404);
    }
}
