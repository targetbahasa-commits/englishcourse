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
        $validTestTypes = ['ielts_academic', 'ielts_general', 'toefl_itp'];
        if (! in_array($testType, $validTestTypes)) {
            abort(404);
        }

        if (Auth::check() && !in_array(Auth::user()->role, ['guest', 'guest_quick'])) {
            return $this->redirectAfterQuickAccess($testType);
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

    public function quickAccessToeflPromo(Request $request, $type, $number)
    {
        $validTypes = ['listening', 'structure', 'reading'];
        if (! in_array($type, $validTypes)) {
            abort(404);
        }

        $table = "toefl_{$type}_meetings";
        $test = \Illuminate\Support\Facades\DB::table($table)->where('meeting_number', $number)->first();
        
        if (!$test || 
            !$test->is_free_tier || 
            ($test->promo_start && \Carbon\Carbon::parse($test->promo_start)->isFuture()) || 
            ($test->promo_deadline && \Carbon\Carbon::parse($test->promo_deadline)->isPast())) {
            return view('promo.expired');
        }

        if (Auth::check() && !in_array(Auth::user()->role, ['guest', 'guest_quick'])) {
            return redirect()->route("assignments.toefl-itp.{$type}.meeting", $number);
        }

        if (session()->has('quick_guest_id')) {
            $user = $this->createQuickGuestAccess->findById(session('quick_guest_id'));
            if ($user) {
                Auth::login($user);
                session(['quick_guest_allowed_test' => 'toefl_itp']);
                return $type === 'listening' ? redirect()->route("promo.test.toefl_listening") : redirect()->route("promo.test.show", ['type' => "toefl_{$type}", 'id' => $number]);
            }
        }

        $user = $this->createQuickGuestAccess->execute();

        Auth::login($user);
        session(['quick_guest_id' => $user->id, 'quick_guest_allowed_test' => 'toefl_itp']);
        session()->put('quick_guest_expires_at', now()->addDay());

        return $type === 'listening' ? redirect()->route("promo.test.toefl_listening") : redirect()->route("promo.test.show", ['type' => "toefl_{$type}", 'id' => $number]);
    }
}
