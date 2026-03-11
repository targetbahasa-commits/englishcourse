<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\GuestMagicLinkMail;
use Illuminate\Support\Facades\Auth;

class GuestMagicLinkController extends Controller
{
    /**
     * Send the magic link to the guest's email.
     */
    public function sendLink(Request $request)
    {
        $request->validate([
            'cf-turnstile-response' => ['required', new \App\Rules\Turnstile()],
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Ensure this user is actually a guest role
        if ($user->role !== 'guest') {
            return back()->withErrors([
                'email' => 'These credentials do not match our records for a guest account.'
            ]);
        }

        // Generate signed route valid for 15 minutes
        $url = URL::temporarySignedRoute(
            'guest.login.verify',
            now()->addMinutes(15),
            ['user' => $user->id]
        );

        // Send email
        Mail::to($user->email)->send(new GuestMagicLinkMail($url));

        // Return back with a success status
        return back()->with('status', 'We have emailed your magic login link! Please check your inbox.');
    }

    /**
     * Verify the magic link and authenticate the user.
     */
    public function verifyLink(Request $request, User $user)
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'Invalid or expired login link.');
        }

        if ($user->role !== 'guest') {
            abort(403);
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
