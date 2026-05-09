<?php

namespace App\Http\Controllers;

use App\Application\IeltsWriting\ShowIeltsWritingMeeting;
use App\Models\User;
use Illuminate\Http\Request;

class LiveDraftController extends Controller
{
    public function __construct(
        private readonly ShowIeltsWritingMeeting $showIeltsWritingMeeting,
    ) {
    }
    public function adminIeltsWriting(User $user, int $task, int $meetingId)
    {
        $actor = auth()->user();
        if (!$actor || $actor->role !== 'admin') {
            abort(403, 'Only admins can access this live draft monitor.');
        }

        return $this->renderIeltsWritingMonitor($user, $task, $meetingId, true);
    }

    public function teacherIeltsWriting(User $user, int $task, int $meetingId)
    {
        $actor = auth()->user();
        if (!$actor || $actor->role !== 'teacher') {
            abort(403, 'Only teachers can access this live draft monitor.');
        }

        if (in_array($user->role, ['admin', 'teacher'], true)) {
            abort(403, 'Teachers can only monitor student or guest drafts.');
        }

        return $this->renderIeltsWritingMonitor($user, $task, $meetingId, false);
    }

    private function renderIeltsWritingMonitor(User $targetUser, int $task, int $meetingId, bool $isAdmin)
    {
        if (!in_array($task, [1, 2], true)) {
            abort(404);
        }

        $meeting = $this->showIeltsWritingMeeting->handle($meetingId);

        $roomId = sprintf(
            'ielts-writing:%d:task:%d:user:%d',
            $meeting->id,
            $task,
            $targetUser->id
        );

        $wsUrl = env('CRDT_WS_URL', 'wss://demos.yjs.dev');

        return view('live-draft.ielts-writing-monitor', [
            'targetUser' => $targetUser,
            'meeting' => $meeting,
            'task' => $task,
            'roomId' => $roomId,
            'wsUrl' => $wsUrl,
            'isAdmin' => $isAdmin,
        ]);
    }
}
