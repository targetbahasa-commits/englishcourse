<?php

namespace App\Http\Controllers;

use App\Application\Admin\GetAdminDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(
        private readonly GetAdminDashboard $getAdminDashboard,
    ) {
    }

    public function index(Request $request)
    {
        $data = $this->getAdminDashboard->execute();

        return view('admin.dashboard', $data);
    }

    public function impersonate($role)
    {
        $currentUser = Auth::user();

        if ($currentUser && $currentUser->role === 'admin' && in_array($role, ['teacher', 'student', 'guest'])) {
            session(['view_as_role' => $role]);
        }

        if ($role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }

        if ($role === 'student' || $role === 'guest') {
            return redirect()->route('dashboard');
        }

        return back();
    }

    public function stopImpersonate()
    {
        session()->forget('view_as_role');

        return redirect()->route('admin.dashboard');
    }
}
