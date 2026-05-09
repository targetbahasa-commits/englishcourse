<?php

namespace App\Http\Controllers;

use App\Application\Guest\RegisterGuestUser;
use App\Domain\Guest\Repositories\GuestUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CambridgeGuestSignupController extends Controller
{
    public function __construct(
        private readonly RegisterGuestUser     $registerGuestUser,
        private readonly GuestUserRepository   $guestUserRepository,
    ) {}

    /**
     * Handle the guest sign-up form submitted from the Cambridge test popup modal.
     * Creates (or reuses) a guest account and redirects the user back to the test page.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone_number' => 'required|string|max:30',
            'redirect_to'  => 'nullable|string|max:1000',
        ]);

        // Determine safe redirect URL (must be an internal path)
        $redirectTo = $this->safeRedirectUrl($request->input('redirect_to'));

        try {
            $existingUser = $this->guestUserRepository->findByEmail($request->email);

            if ($existingUser) {
                // If already a student, create a temporary quick-guest session instead
                if ($existingUser->role === 'student') {
                    $quickGuest = $this->guestUserRepository->createQuickGuestUser([
                        'name'         => $request->name,
                        'phone_number' => $request->phone_number,
                    ]);
                    Auth::login($quickGuest);
                } else {
                    // Re-use existing guest account
                    Auth::login($existingUser);
                }
            } else {
                // Create a new guest account
                $user = $this->registerGuestUser->handle(
                    $request->only(['name', 'email', 'phone_number']),
                    null
                );
                Auth::login($user);
            }
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Pendaftaran gagal. Silakan coba lagi.']);
        }

        // Always direct newly signed-up guests to the proper guest landing page
        return redirect()->route('guest.free-tests')
            ->with('success', 'Selamat datang! Kamu sekarang bisa mengakses Cambridge Mock Test secara gratis dari halaman ini.');
    }

    /**
     * Only allow redirects to internal paths (same domain).
     */
    private function safeRedirectUrl(?string $url): string
    {
        if (!$url) {
            return route('guest.free-tests');
        }

        $parsed  = parse_url($url);
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);

        // Allow only if it's a relative path or same-host URL
        if (empty($parsed['host']) || $parsed['host'] === $appHost) {
            return $url;
        }

        return route('guest.free-tests');
    }
}
