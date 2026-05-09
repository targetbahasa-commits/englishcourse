<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function createTeacher(): View
    {
        // If currently logged in as a guest, log out first so they can authenticate properly
        if (auth()->check() && in_array(auth()->user()->role, ['guest', 'guest_quick'])) {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
        return view('auth.login-teacher');
    }

    public function createGuest(): View
    {
        return view('auth.login-guest');
    }

    public function createStudent(): View
    {
        // If currently logged in as a guest, log out first so they can authenticate properly
        if (auth()->check() && in_array(auth()->user()->role, ['guest', 'guest_quick'])) {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
        return view('auth.login-student');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Clear any lingering impersonation session so the user gets
        // the correct dashboard for their actual role.
        $request->session()->forget('view_as_role');

        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->isTeacher()) {
            return redirect()->intended(route('teacher.dashboard'));
        }

        if ($user->isGuest()) {
            // Always send guests to their landing page — never let a stored
            // 'intended' URL (e.g. an IELTS test page) override this.
            $request->session()->forget('url.intended');
            return redirect()->route('guest.free-tests');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
