<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuestFreeTestController extends Controller
{
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        // If not, create a new "student" account
        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make(Str::random(12)), // Generate a random secure password
                'role' => 'student',
            ]);
        } else {
            // Optional: update phone number or name if missing, 
            // but we leave it simple for now and rely on existing data.
            if (!$user->phone_number) {
                 $user->update(['phone_number' => $request->phone_number]);
            }
        }

        // Log the user in
        Auth::login($user);

        // Redirect directly to the test
        return redirect()->route('free-test.show', $type);
    }
}
