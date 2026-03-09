<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralReward;
use App\Models\UserRewardClaim;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Display the admin referral dashboard.
     */
    public function index()
    {
        $claims = UserRewardClaim::with(['user', 'reward'])
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->latest()
            ->paginate(15);
            
        $rewards = ReferralReward::orderBy('points_required')->get();

        $socialSubmissions = \App\Models\SocialMediaSubmission::with('user')
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->latest()
            ->paginate(15, ['*'], 'social_page');

        return view('admin.referrals.index', compact('claims', 'rewards', 'socialSubmissions'));
    }

    /**
     * Update a reward claim status.
     */
    public function updateClaim(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,shipped,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $claim = UserRewardClaim::findOrFail($id);
        
        // Handle rejection to refund points
        if ($request->status === 'rejected' && $claim->status !== 'rejected') {
            $user = $claim->user;
            if ($user && $claim->reward) {
                $user->increment('referral_points', $claim->reward->points_required);
                $claim->admin_notes = $request->admin_notes . "\n(Points refunded)";
            }
        } elseif ($claim->status === 'rejected' && $request->status !== 'rejected') {
            // Re-deduct points if moving away from rejected
             $user = $claim->user;
            if ($user && $claim->reward) {
                if ($user->referral_points >= $claim->reward->points_required) {
                   $user->decrement('referral_points', $claim->reward->points_required);
                } else {
                    return back()->with('error', 'Student does not have enough points to reactivate this claim.');
                }
            }
        }

        $claim->status = $request->status;
        if ($request->filled('admin_notes')) {
            $claim->admin_notes = $request->admin_notes;
        }
        $claim->save();

        return back()->with('success', 'Claim status updated successfully.');
    }

    /**
     * Store a new referral reward.
     */
    public function storeReward(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rewards', 'public');
        }

        ReferralReward::create([
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
    public function updateSocialMedia(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string|max:1000',
            'points_awarded' => 'nullable|integer|min:0',
        ]);

        $submission = \App\Models\SocialMediaSubmission::findOrFail($id);
        
        // Handle approval to grant points
        if ($request->status === 'approved' && $submission->status !== 'approved') {
            $points = $request->points_awarded ?? 50; // default 50 points if not specified
            $user = $submission->user;
            if ($user) {
                $user->increment('referral_points', $points);
                $submission->points_awarded = $points;
                $submission->admin_note = $request->admin_note . "\n(Awarded {$points} points)";
            }
        } elseif ($submission->status === 'approved' && $request->status !== 'approved') {
            // Re-deduct points if moving away from approved
             $user = $submission->user;
            if ($user) {
                // We just deduct what was awarded
                $user->decrement('referral_points', $submission->points_awarded);
                $submission->points_awarded = 0;
            }
        }

        $submission->status = $request->status;
        if ($request->filled('admin_note') && $request->status !== 'approved') {
            $submission->admin_note = $request->admin_note;
        }
        $submission->save();

        return back()->with('success', 'Social media submission status updated successfully.');
    }
}
