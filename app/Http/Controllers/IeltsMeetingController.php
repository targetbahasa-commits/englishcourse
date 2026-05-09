<?php

namespace App\Http\Controllers;

use App\Application\IeltsShared\ManageIeltsMeetings;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\RequiresAdminAccess;
use Illuminate\Http\Request;

class IeltsMeetingController extends Controller
{
    use HandlesAssignmentAccess, RequiresAdminAccess;

    public function __construct(
        private readonly ManageIeltsMeetings $manageIeltsMeetings,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function update(Request $request, int $id)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required',
            'meeting_number' => 'required',
        ]);

        $this->manageIeltsMeetings->update($id, $validated);

        return back()->with('success', 'Practice Test updated successfully');
    }

    public function destroy(int $id)
    {
        $this->requireAdmin();

        $this->manageIeltsMeetings->destroy($id);

        return back()->with('success', 'Practice Test deleted successfully');
    }

    public function toggleLock(int $id)
    {
        $this->requireAdmin();

        $this->manageIeltsMeetings->toggleLock($id);

        return back()->with('success', 'Lock status toggled');
    }
}