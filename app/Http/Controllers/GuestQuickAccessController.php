<?php

namespace App\Http\Controllers;

use App\Application\Guest\CreateQuickGuestAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestQuickAccessController extends Controller
{
    public function __construct(
        private readonly CreateQuickGuestAccess $createQuickGuestAccess,
    ) {
    }

    public function quickAccess(Request $request, $testType)
    {
        $validTypes = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        if (! in_array($testType, $validTypes)) {
            abort(404);
        }

        if (session()->has('quick_guest_id')) {
            $user = $this->createQuickGuestAccess->findById(session('quick_guest_id'));
            if ($user) {
                Auth::login($user);
                session(['quick_guest_allowed_test' => $testType]);
                return $this->redirectAfterQuickAccess($testType);
            }
        }

        $user = $this->createQuickGuestAccess->execute();

        Auth::login($user);
        session(['quick_guest_id' => $user->id, 'quick_guest_allowed_test' => $testType]);
        session()->put('quick_guest_expires_at', now()->addDay());

        return $this->redirectAfterQuickAccess($testType);
    }

    protected function redirectAfterQuickAccess(string $testType)
    {
        if ($testType === 'ielts_academic') {
            return redirect()->route('assignments.ielts-academic.mockup.cambridge');
        }

        return redirect()->route('guest.free-tests');
    }
}
