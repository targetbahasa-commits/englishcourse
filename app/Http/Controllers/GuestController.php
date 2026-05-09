<?php

namespace App\Http\Controllers;

use App\Application\Guest\BuildGuestIndexData;
use App\Application\Guest\BuildGuestMyEnglishData;
use App\Application\Guest\RegisterGuestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function __construct(
        private readonly BuildGuestIndexData    $buildGuestIndexData,
        private readonly BuildGuestMyEnglishData $buildGuestMyEnglishData,
        private readonly RegisterGuestUser       $registerGuestUser,
    ) {}

    // ------------------------------------------------------------------ //
    //  Dashboard                                                           //
    // ------------------------------------------------------------------ //

    public function dashboard()
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['guest', 'guest_quick'])) {
            return redirect('/');
        }

        // We no longer use guest.dashboard. Redirect to free-tests.
        return redirect()->route('guest.free-tests');
    }

    // ------------------------------------------------------------------ //
    //  Guest Index                                                         //
    // ------------------------------------------------------------------ //

    public function index()
    {
        return view('guest.index', $this->buildGuestIndexData->handle());
    }

    // ------------------------------------------------------------------ //
    //  Registration                                                        //
    // ------------------------------------------------------------------ //

    public function showRegisterForm()
    {
        return view('guest.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email',
            'phone_number' => 'required|string|max:20',
        ]);

        $user = $this->registerGuestUser->handle($request->only('name', 'email', 'phone_number'), Auth::user());

        Auth::login($user);

        session()->forget(['quick_guest_id', 'quick_guest_allowed_test', 'quick_guest_expires_at']);

        return redirect()->route('guest.free-tests');
    }

    // ------------------------------------------------------------------ //
    //  My English                                                          //
    // ------------------------------------------------------------------ //

    public function myEnglish()
    {
        $user = Auth::user();

        if ($user && !in_array($user->role, ['guest', 'guest_quick'], true)) {
            return redirect()->route('dashboard');
        }

        $viewerNeedsLogin = !$user;

        $data = $this->buildGuestMyEnglishData->handle($user?->id);

        return view('guest.my-english', array_merge($data, compact('viewerNeedsLogin')));
    }
}
