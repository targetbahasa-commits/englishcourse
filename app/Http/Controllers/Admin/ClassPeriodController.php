<?php

namespace App\Http\Controllers\Admin;

use App\Application\ClassPeriod\ManageClassPeriods;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassPeriodUpsertRequest;
use App\Models\Meeting;
use App\Models\Program;
use App\Models\StudentGroup;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClassPeriod;

class ClassPeriodController extends Controller
{
    public function __construct(
        private readonly ManageClassPeriods $manageClassPeriods
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $periods = $this->manageClassPeriods->listAll($request->only(['program_id', 'status']));
        
        return view('admin.class-periods.index', compact('periods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassPeriodUpsertRequest $request)
    {
        $data = $request->validated();

        $program = Program::findOrFail($data['program_id']);
        if (!$program->is_active) {
            return back()->with('error', 'Tidak dapat membuat Class Period baru untuk program yang sudah dinonaktifkan.')->withInput();
        }

        $this->manageClassPeriods->create($data);

        return back()->with('success', 'Class Period created successfully. You can now manage meetings and students.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassPeriod $classPeriod)
    {
        [
            'classPeriod' => $classPeriod,
            'meetings' => $meetings,
            'allStudents' => $allStudents,
            'bookedEnrollments' => $bookedEnrollments,
            'studentGroups' => $studentGroups,
            'rosterStudents' => $rosterStudents,
        ] = $this->manageClassPeriods->show($classPeriod);

        return view('admin.class-periods.show', compact('classPeriod', 'meetings', 'allStudents', 'bookedEnrollments', 'studentGroups', 'rosterStudents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassPeriodUpsertRequest $request, ClassPeriod $classPeriod)
    {
        $data = $request->validated();

        if ((int) $data['program_id'] !== (int) $classPeriod->program_id) {
            $program = Program::findOrFail($data['program_id']);
            if (!$program->is_active) {
                return back()->with('error', 'Tidak dapat memindahkan Class Period ke program yang sudah dinonaktifkan.')->withInput();
            }
        }

        $this->manageClassPeriods->update($classPeriod, $data);

        return back()->with('success', 'Class Period updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassPeriod $classPeriod)
    {
        $this->manageClassPeriods->delete($classPeriod);

        // The delete button lives on this class's own show page, so
        // back() would normally bounce the admin right back to the URL
        // they just deleted - a guaranteed 404 on the next load. Send
        // them to the list instead.
        return redirect()->route('class-periods.index')->with('success', 'Class Period deleted successfully.');
    }

    public function nextBatchNumber(Request $request)
    {
        $request->validate(['program_id' => 'required|exists:programs,id']);
        $next = $this->manageClassPeriods->getNextBatchNumber((int) $request->program_id);
        return response()->json(['next_batch_number' => $next]);
    }

    // --- Custom Methods ---

    public function toggleMeeting(Request $request, ClassPeriod $classPeriod, Meeting $meeting)
    {
          $this->manageClassPeriods->toggleMeeting($classPeriod, $meeting);

        return back()->with('success', 'Meeting status updated.');
    }

    public function toggleGame(ClassPeriod $classPeriod, Meeting $meeting, int $gameIndex)
    {
        $this->manageClassPeriods->toggleGame($classPeriod, $meeting, $gameIndex);

        return back()->with('success', 'Game visibility updated.');
    }

    public function assignStudent(Request $request, ClassPeriod $classPeriod)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $result = $this->manageClassPeriods->assignStudent($classPeriod, (int) $request->user_id);

        if ($result['status'] === 'capacity_exceeded') {
            return back()->with('error', 'Batch ini sudah mencapai kapasitas maksimum (' . $classPeriod->max_capacity . ' siswa). Tambah kapasitas atau pilih batch lain.');
        }

        return back()->with('success', 'Student assigned to class period.');
    }
    
    public function updateStatus(Request $request, ClassPeriod $classPeriod)
    {
        $request->validate([
            'status' => 'required|in:active,upcoming,closed',
        ]);

        $this->manageClassPeriods->updateStatus($classPeriod, $request->status);

        return back()->with('success', "Status updated to " . ucfirst($request->status));
    }

    public function removeStudent(ClassPeriod $classPeriod, User $user)
    {
        if ($this->manageClassPeriods->removeStudent($classPeriod, $user)) {
            return back()->with('success', 'Student removed from class period.');
        }
        return back()->with('error', 'Student does not belong to this class period.');
    }

    public function storeGroup(Request $request, ClassPeriod $classPeriod)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'integer|exists:users,id',
            'meeting_id' => 'nullable|integer|exists:meetings,id',
            'game_index' => 'nullable|integer|min:0',
        ]);

        $group = $this->manageClassPeriods->createGroup(
            $classPeriod,
            $validated['name'] ?? null,
            $validated['user_ids'],
            $validated['meeting_id'] ?? null,
            $validated['game_index'] ?? null
        );

        return back()->with('success', "Kelompok \"{$group->name}\" berhasil dibuat.");
    }

    public function bulkStoreGroups(Request $request, ClassPeriod $classPeriod)
    {
        $validated = $request->validate([
            'group_count' => 'required|integer|min:2|max:50',
            'assignments' => 'required|array',
            'assignments.*' => 'nullable|integer|min:1',
            'meeting_id' => 'nullable|integer|exists:meetings,id',
            'game_index' => 'nullable|integer|min:0',
        ]);

        $groups = $this->manageClassPeriods->bulkCreateGroups(
            $classPeriod,
            $validated['group_count'],
            $validated['assignments'],
            $validated['meeting_id'] ?? null,
            $validated['game_index'] ?? null
        );

        if ($groups->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa yang dipilih ke kelompok manapun.');
        }

        return back()->with('success', "{$groups->count()} kelompok berhasil dibuat.");
    }

    public function autoPairGroups(Request $request, ClassPeriod $classPeriod)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array|min:2',
            'user_ids.*' => 'integer|exists:users,id',
            'meeting_id' => 'nullable|integer|exists:meetings,id',
            'game_index' => 'nullable|integer|min:0',
            'name_prefix' => 'nullable|string|max:50',
            'odd_handling' => 'nullable|string|in:trio,single',
            'replace_existing' => 'nullable|boolean',
        ]);

        $prefix = !empty($validated['name_prefix']) ? $validated['name_prefix'] : 'Pair';
        $oddHandling = $validated['odd_handling'] ?? 'trio';
        $replaceExisting = !empty($validated['replace_existing']);

        $groups = $this->manageClassPeriods->autoPairGroups(
            $classPeriod,
            $validated['user_ids'],
            $validated['meeting_id'] ?? null,
            $validated['game_index'] ?? null,
            $prefix,
            $oddHandling,
            $replaceExisting
        );

        if ($groups->isEmpty()) {
            return back()->with('error', 'Gagal membuat pasangan. Pastikan minimal 2 siswa dipilih.');
        }

        return back()->with('success', "Berhasil membuat {$groups->count()} kelompok/pasangan siswa secara acak.");
    }

    public function destroyAllGroups(Request $request, ClassPeriod $classPeriod)
    {
        $meetingId = $request->input('meeting_id');
        $gameIndex = $request->input('game_index');

        $deletedCount = $this->manageClassPeriods->deleteAllGroups(
            $classPeriod,
            $meetingId !== null && $meetingId !== '' ? (int) $meetingId : null,
            $gameIndex !== null && $gameIndex !== '' ? (int) $gameIndex : null
        );

        return back()->with('success', "{$deletedCount} kelompok berhasil dihapus.");
    }

    public function destroyGroup(ClassPeriod $classPeriod, StudentGroup $studentGroup)
    {
        if ($this->manageClassPeriods->deleteGroup($classPeriod, $studentGroup)) {
            return back()->with('success', 'Kelompok berhasil dihapus.');
        }
        return back()->with('error', 'Kelompok tidak ditemukan di batch ini.');
    }

    public function addGroupMember(Request $request, ClassPeriod $classPeriod, StudentGroup $studentGroup)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $this->manageClassPeriods->addGroupMember($studentGroup, (int) $request->user_id);

        return back()->with('success', 'Anggota berhasil ditambahkan ke kelompok.');
    }

    public function removeGroupMember(ClassPeriod $classPeriod, StudentGroup $studentGroup, User $user)
    {
        $this->manageClassPeriods->removeGroupMember($studentGroup, $user->id);

        return back()->with('success', 'Anggota berhasil dihapus dari kelompok.');
    }
}
