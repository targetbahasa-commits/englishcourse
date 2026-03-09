<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Program;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of all students.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student')
            ->with(['program', 'teacher']);

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone_number', 'like', "%{$request->search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Missing data filter
        if ($request->filled('missing')) {
            if ($request->missing === 'whatsapp') {
                $query->whereNull('phone_number')->orWhere('phone_number', '');
            } elseif ($request->missing === 'referral') {
                $query->whereNull('referral_code')->orWhere('referral_code', '');
            } elseif ($request->missing === 'both') {
                $query->where(function ($q) {
                    $q->whereNull('phone_number')->orWhere('phone_number', ''); 
                })->where(function ($q) {
                    $q->whereNull('referral_code')->orWhere('referral_code', ''); 
                });
            }
        }

        $students = $query->paginate(15)->withQueryString();

        // Pass teachers for the Assign Teacher modal
        $teachers = User::where('role', 'teacher')->where('status', 'active')->get();

        // Programs for quick edit
        $programs = Program::orderBy('name')->get();

        // Metrics
        $totalStudents   = User::where('role', 'student')->count();
        $activeStudents  = User::where('role', 'student')->where('status', 'active')->count();
        $missingWa       = User::where('role', 'student')->where(function ($q) { $q->whereNull('phone_number')->orWhere('phone_number', ''); })->count();
        $missingReferral = User::where('role', 'student')->where(function ($q) { $q->whereNull('referral_code')->orWhere('referral_code', ''); })->count();

        $metrics = [
            'total_students'    => $totalStudents,
            'active_students'   => $activeStudents,
            'missing_wa'        => $missingWa,
            'missing_referral'  => $missingReferral,
            'average_progress'  => 65,
        ];

        return view('admin.students.index', compact('students', 'teachers', 'programs', 'metrics'));
    }

    /**
     * Display the specified student's profile.
     */
    public function show(User $student)
    {
        if ($student->role !== 'student') {
            return redirect()->route('students.index')->with('error', 'User is not a student.');
        }

        $student->load(['program', 'teacher', 'classPeriod.classMeetings', 'classes']);

        // Fetch their recent activity
        $recentActivity = \App\Models\MeetingScore::where('user_id', $student->id)
            ->with('classMeeting.assignment')
            ->orderByDesc('submitted_at')
            ->limit(10)
            ->get();

        // Calculate progress stats
        $totalAssignments = 20; // Assuming a standard 20-meeting course
        $completedAssignments = \App\Models\MeetingScore::where('user_id', $student->id)->count();
        $progressPercentage = $totalAssignments > 0 ? min(100, round(($completedAssignments / $totalAssignments) * 100)) : 0;
        
        $averageScore = \App\Models\MeetingScore::where('user_id', $student->id)->avg('score') ?? 0;
        
        // Latest Free Test
        $latestTest = \App\Models\FreeTestResult::where('user_id', $student->id)->latest()->first();

        return view('admin.students.show', compact('student', 'recentActivity', 'progressPercentage', 'completedAssignments', 'totalAssignments', 'averageScore', 'latestTest'));
    }

    /**
     * Reassign a student to a different teacher.
     */
    public function assignTeacher(Request $request, User $student)
    {
        $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        if ($request->teacher_id) {
            $teacher = User::findOrFail($request->teacher_id);
            if ($teacher->role !== 'teacher') {
                return back()->with('error', 'The selected user is not a teacher.');
            }
            $student->teacher_id = $teacher->id;
            $message = "Student {$student->name} has been assigned to {$teacher->name}.";
        } else {
            $student->teacher_id = null;
            $message = "Student {$student->name} has been unassigned from their teacher.";
        }

        $student->save();

        return back()->with('success', $message);
    }

    /**
     * Quick inline update of phone_number and/or referral_code.
     */
    public function quickUpdate(Request $request, User $student)
    {
        $request->validate([
            'phone_number'  => 'nullable|string|max:30',
            'referral_code' => 'nullable|string|max:50|unique:users,referral_code,' . $student->id,
        ]);

        if ($request->filled('phone_number')) {
            // Normalise: strip non-digits, then ensure starts with 62
            $phone = preg_replace('/[^0-9]/', '', $request->phone_number);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            $student->phone_number = $phone;
        }

        if ($request->filled('referral_code')) {
            $student->referral_code = strtoupper($request->referral_code);
        } elseif ($request->referral_code === '') {
            // If explicitly sent empty, keep current OR generate one
            if (!$student->referral_code) {
                $student->referral_code = strtoupper(Str::random(8));
            }
        }

        $student->save();

        return back()->with('success', "Updated {$student->name}'s contact info successfully.");
    }

    /**
     * Bulk auto-generate referral codes for students who don't have one.
     */
    public function bulkGenerateReferralCodes()
    {
        $students = User::where('role', 'student')
            ->where(function ($q) { $q->whereNull('referral_code')->orWhere('referral_code', ''); })
            ->get();

        $updated = 0;
        foreach ($students as $student) {
            do {
                $code = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', strtoupper($student->name)), 0, 3) . Str::random(5));
            } while (User::where('referral_code', $code)->exists());

            $student->referral_code = $code;
            $student->save();
            $updated++;
        }

        return back()->with('success', "Generated referral codes for {$updated} student(s).");
    }
}
