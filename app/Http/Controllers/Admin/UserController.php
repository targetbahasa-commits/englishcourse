<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with(['teacher', 'program']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->byRole($request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by program
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        // Order by latest
        $query->latest();

        // Paginate
        $users = $query->paginate(15)->withQueryString();

        // Fetch choices for assignment modals
        $teachers = User::where('role', 'teacher')->where('status', 'active')->get();
        $programs = \App\Models\Program::all();

        return view('admin.users.index', compact('users', 'teachers', 'programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::where('role', 'teacher')->where('status', 'active')->get();
        $programs = \App\Models\Program::all();
        
        return view('admin.users.create', compact('teachers', 'programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,teacher,student,guest',
            'status' => 'required|in:active,inactive',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'teacher_id' => 'nullable|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'learning_mode' => 'required|in:online,offline,both',
            'bio' => 'nullable|string',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $validated['profile_photo'] = 'uploads/profiles/' . $filename;
        }

        // Automatic Guest to Student Conversion on Program Registration
        if (isset($validated['role']) && $validated['role'] === 'guest' && !empty($validated['program_id'])) {
            $validated['role'] = 'student';
        }

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $teachers = User::where('role', 'teacher')->where('status', 'active')->get();
        $programs = \App\Models\Program::all();
        
        return view('admin.users.edit', compact('user', 'teachers', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,teacher,student,guest',
            'status' => 'required|in:active,inactive',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'teacher_id' => 'nullable|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'learning_mode' => 'required|in:online,offline,both',
            'bio' => 'nullable|string',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo));
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $validated['profile_photo'] = 'uploads/profiles/' . $filename;
        }

        // Automatic Guest to Student Conversion on Program Registration
        if (isset($validated['role']) && $validated['role'] === 'guest' && !empty($validated['program_id'])) {
            $validated['role'] = 'student';
        }

        // Hash password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Delete profile photo if exists
        if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
            unlink(public_path($user->profile_photo));
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status,
            'message' => 'User status updated successfully.'
        ]);
    }

    /**
     * Bulk assign a teacher to selected users.
     */
    public function bulkAssignTeacher(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $userIds = json_decode($request->user_ids, true);
        
        if (!is_array($userIds) || empty($userIds)) {
            return back()->with('error', 'No users selected.');
        }

        User::whereIn('id', $userIds)->update(['teacher_id' => $request->teacher_id]);

        return back()->with('success', count($userIds) . ' users assigned to the new teacher successfully.');
    }

    /**
     * Bulk assign a program to selected users.
     */
    public function bulkAssignProgram(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|string',
            'program_id' => 'required|exists:programs,id',
        ]);

        $userIds = json_decode($request->user_ids, true);
        
        if (!is_array($userIds) || empty($userIds)) {
            return back()->with('error', 'No users selected.');
        }

        // Convert guests to students automatically
        User::whereIn('id', $userIds)->where('role', 'guest')->update([
            'program_id' => $request->program_id,
            'role' => 'student'
        ]);

        // Just update program for others
        User::whereIn('id', $userIds)->where('role', '!=', 'guest')->update([
            'program_id' => $request->program_id
        ]);

        return back()->with('success', count($userIds) . ' users enrolled in the new program successfully.');
    }

    /**
     * Convert a Guest user to a Student.
     */
    public function convertGuest(User $user)
    {
        if ($user->role !== 'guest') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a guest.'
            ], 400);
        }

        $user->role = 'student';
        $user->save();

        session()->flash('success', 'Guest successfully converted to Student.');

        return response()->json([
            'success' => true,
            'message' => 'Guest successfully converted to Student.'
        ]);
    }
}
