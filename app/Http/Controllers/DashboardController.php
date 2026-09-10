<?php

namespace App\Http\Controllers;

use App\Application\Dashboard\BuildStudentDashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private readonly BuildStudentDashboard $buildStudentDashboard,
    ) {
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($request->has('live_preview_for') && ($user->isAdmin() || $user->isTeacher())) {
            $targetStudent = \App\Models\User::find($request->query('live_preview_for'));
            if ($targetStudent && $targetStudent->isStudent()) {
                $data = $this->buildStudentDashboard->execute($targetStudent);
                return view('dashboard', $data);
            }
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }

        if ($user->isGuest()) {
            return redirect()->route('guest.free-tests');
        }

        if ($user->isTestTaker()) {
            return redirect()->route('online-test.index');
        }

        $data = $this->buildStudentDashboard->execute($user);

        return view('dashboard', $data);
    }
}
