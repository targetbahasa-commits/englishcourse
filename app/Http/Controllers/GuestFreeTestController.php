<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuestFreeTestController extends Controller
{
    private function extractAttributionData(Request $request): array
    {
        return $request->only([
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_content',
            'utm_term',
            'acquisition_referrer',
            'acquisition_landing_path',
            'acquisition_source_page',
            'acquisition_variant',
            'acquisition_last_cta',
        ]);
    }

    public function showRegistrationForm($type)
    {
        $validTypes = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        // If the user happens to already be logged in, skip the registration
        if (Auth::check()) {
            return redirect()->route('free-test.show', $type);
        }

        return view('guest.free-test-register', compact('type'));
    }

    public function registerAndStart(Request $request, $type)
    {
        $validTypes = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $request->validate([
            // 'cf-turnstile-response' => ['required', new \App\Rules\Turnstile()],
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:20',
            'utm_source' => 'nullable|string|max:100',
            'utm_medium' => 'nullable|string|max:100',
            'utm_campaign' => 'nullable|string|max:150',
            'utm_content' => 'nullable|string|max:150',
            'utm_term' => 'nullable|string|max:150',
            'acquisition_referrer' => 'nullable|string|max:1000',
            'acquisition_landing_path' => 'nullable|string|max:255',
            'acquisition_source_page' => 'nullable|string|max:100',
            'acquisition_variant' => 'nullable|string|max:50',
            'acquisition_last_cta' => 'nullable|string|max:100',
        ]);

        $attributionData = $this->extractAttributionData($request);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        // If not, create a new "student" account
        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make(Str::random(12)), // Generate a random secure password
                'role' => 'guest',
            ] + $attributionData);
        } else {
            // Optional: update phone number or name if missing, 
            // but we leave it simple for now and rely on existing data.
            $updates = [];

            if (!$user->phone_number) {
                $updates['phone_number'] = $request->phone_number;
            }

            foreach ($attributionData as $field => $value) {
                if ($value && empty($user->{$field})) {
                    $updates[$field] = $value;
                }
            }

            if (!empty($updates)) {
                $user->update($updates);
            }
        }

        // Log the user in
        Auth::login($user);

        // Redirect directly to the test
        return redirect()->route('free-test.show', $type);
    }
}
