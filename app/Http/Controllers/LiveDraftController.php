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

        // No fallback to the public Yjs demo server (wss://demos.yjs.dev) -
        // that sent real student essay content to an unauthenticated
        // third-party server with no SLA. Null here means "not configured
        // yet" - the view shows a clear message instead of connecting.
        $wsUrl = env('CRDT_WS_URL');
        $relaySecret = env('CRDT_RELAY_SECRET');

        // Our own relay rejects any connection whose token doesn't match
        // this HMAC - see the relay's server.js. Without it, knowing/
        // guessing a room name (predictable: meeting/task/user IDs) would
        // be enough for anyone to read a student's essay in real time.
        $token = $relaySecret ? hash_hmac('sha256', $roomId, $relaySecret) : null;

        return view('live-draft.ielts-writing-monitor', [
            'targetUser' => $targetUser,
            'meeting' => $meeting,
            'task' => $task,
            'roomId' => $roomId,
            'wsUrl' => $wsUrl && $token ? $wsUrl : null,
            'token' => $token,
            'isAdmin' => $isAdmin,
        ]);
    }
}
