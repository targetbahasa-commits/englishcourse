<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RemoteViewController extends Controller
{
    /**
     * Display the remote view page for Admins.
     */
    public function adminView(User $user)
    {
        // Admins can view anyone (teachers, students, guests)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access to remote view.');
        }

        return view('remote-view.index', compact('user'));
    }

    /**
     * Display the remote view page for Teachers.
     */
    public function teacherView(User $user)
    {
        // Teachers can only view students and guests
        if (auth()->user()->role !== 'teacher') {
            abort(403, 'Unauthorized access to remote view.');
        }

        if (in_array($user->role, ['admin', 'teacher'])) {
             abort(403, 'Teachers cannot view other teachers or admins.');
        }

        return view('remote-view.index', compact('user'));
    }
}
