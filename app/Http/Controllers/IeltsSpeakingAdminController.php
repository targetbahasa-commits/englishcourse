<?php

namespace App\Http\Controllers;

use App\Application\IeltsSpeaking\ManageIeltsSpeakingTopics;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\RequiresAdminAccess;
use Illuminate\Http\Request;

class IeltsSpeakingAdminController extends Controller
{
    use HandlesAssignmentAccess, RequiresAdminAccess;

    public function __construct(
        private readonly ManageIeltsSpeakingTopics $manageIeltsSpeakingTopics,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function toggleLock(int $id)
    {
        $this->requireAdmin();

        $isLocked = $this->manageIeltsSpeakingTopics->toggleLock($id);
        $newLabel = $isLocked ? 'LOCKED' : 'OPEN';

        return back()
            ->with('success', 'Speaking topic is now ' . $newLabel . '.')
            ->with('success_state', $isLocked ? 'locked' : 'open');
    }

    public function storeTopic(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ielts_speaking_topics,slug',
            'icon' => 'required|string',
            'color' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
        ]);

        $this->manageIeltsSpeakingTopics->create($validated);

        return back()->with('success', 'Speaking topic created successfully.');
    }

    public function updateTopic(Request $request, int $id)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ielts_speaking_topics,slug,' . $id,
            'icon' => 'required|string',
            'color' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
        ]);

        $this->manageIeltsSpeakingTopics->update($id, $validated);

        return back()->with('success', 'Speaking topic updated successfully.');
    }

    public function destroyTopic(int $id)
    {
        $this->requireAdmin();

        $this->manageIeltsSpeakingTopics->destroy($id);

        return back()->with('success', 'Speaking topic deleted successfully.');
    }
}