<?php

namespace App\Http\Controllers;

use App\Application\Guest\RegisterGuestUser;
use App\Http\Controllers\Concerns\ExtractsAttributionData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestFreeTestController extends Controller
{
    use ExtractsAttributionData;

    public function __construct(
        private readonly RegisterGuestUser $registerGuestUser,
    ) {
    }

    public function showRegistrationForm($type)
    {
        $validTypes = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        if (! in_array($type, $validTypes)) {
            abort(404);
        }

        if (Auth::check()) {
            return redirect()->route('free-test.show', $type);
        }

        return view('guest.free-test-register', compact('type'));
    }

    public function registerAndStart(Request $request, $type)
    {
        $validTypes = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        if (! in_array($type, $validTypes)) {
            abort(404);
        }

        $request->validate([
            'name'                     => 'required|string|max:255',
            'email'                    => 'required|string|email|max:255',
            'phone_number'             => 'required|string|max:20',
            'utm_source'               => 'nullable|string|max:100',
            'utm_medium'               => 'nullable|string|max:100',
            'utm_campaign'             => 'nullable|string|max:150',
            'utm_content'              => 'nullable|string|max:150',
            'utm_term'                 => 'nullable|string|max:150',
            'acquisition_referrer'     => 'nullable|string|max:1000',
            'acquisition_landing_path' => 'nullable|string|max:255',
            'acquisition_source_page'  => 'nullable|string|max:100',
            'acquisition_variant'      => 'nullable|string|max:50',
            'acquisition_last_cta'     => 'nullable|string|max:100',
        ]);

        $attributionData = $this->extractAttributionData($request);
        $data = array_merge($request->only(['name', 'email', 'phone_number']), $attributionData);

        try {
            $existing = app(\App\Domain\Guest\Repositories\GuestUserRepository::class)->findByEmail($data['email']);
            if ($existing && $existing->role === 'student') {
                // Email sudah terdaftar sebagai student, buat quick guest baru dengan nama & phone number dari input
                $quickGuest = app(\App\Domain\Guest\Repositories\GuestUserRepository::class)->createQuickGuestUser([
                    'name' => $data['name'],
                    'phone_number' => $data['phone_number'],
                ]);
                Auth::login($quickGuest);
            } else {
                $result = $this->registerGuestUser->handle($data, Auth::user());
                Auth::login($result);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Pendaftaran gagal, email mungkin sudah digunakan.']);
        }

        return redirect()->route('free-test.show', $type);
    }
}
