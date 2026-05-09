<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\ManageUsers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserBulkAssignProgramRequest;
use App\Http\Requests\Admin\UserBulkAssignTeacherRequest;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly ManageUsers $manageUsers
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->manageUsers->listAll($request->only(['search', 'role', 'status', 'program_id']), 15);
        ['teachers' => $teachers, 'programs' => $programs] = $this->manageUsers->formOptions();

        return view('admin.users.index', compact('users', 'teachers', 'programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ['teachers' => $teachers, 'programs' => $programs] = $this->manageUsers->formOptions();
        
        return view('admin.users.create', compact('teachers', 'programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();

        $this->manageUsers->create($validated, $request);

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
        ['teachers' => $teachers, 'programs' => $programs] = $this->manageUsers->formOptions();
        
        return view('admin.users.edit', compact('user', 'teachers', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();

        $this->manageUsers->update($user, $validated, $request);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->manageUsers->delete($user);

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function toggleStatus(User $user)
    {
        $user = $this->manageUsers->toggleStatus($user);

        return response()->json([
            'success' => true,
            'status' => $user->status,
            'message' => 'User status updated successfully.'
        ]);
    }

    /**
     * Bulk assign a teacher to selected users.
     */
    public function bulkAssignTeacher(UserBulkAssignTeacherRequest $request)
    {
        $userIds = json_decode($request->user_ids, true);
        
        if (!is_array($userIds) || empty($userIds)) {
            return back()->with('error', 'No users selected.');
        }

        $this->manageUsers->bulkAssignTeacher($userIds, (int) $request->teacher_id);

        return back()->with('success', count($userIds) . ' users assigned to the new teacher successfully.');
    }

    /**
     * Bulk assign a program to selected users.
     */
    public function bulkAssignProgram(UserBulkAssignProgramRequest $request)
    {
        $userIds = json_decode($request->user_ids, true);
        
        if (!is_array($userIds) || empty($userIds)) {
            return back()->with('error', 'No users selected.');
        }

        $this->manageUsers->bulkAssignProgram($userIds, (int) $request->program_id);

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

        $this->manageUsers->convertGuest($user);

        session()->flash('success', 'Guest successfully converted to Student.');

        return response()->json([
            'success' => true,
            'message' => 'Guest successfully converted to Student.'
        ]);
    }
}
