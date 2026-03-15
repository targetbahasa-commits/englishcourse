<?php

namespace App\Http\Controllers;

use App\Events\RemoteScreenRequested;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RemoteViewController extends Controller
{
    private function pendingRequestCacheKey(int $targetId): string
    {
        return 'remote_screen_request:' . $targetId;
    }

    /**
     * Display the remote view page for Admins.
     */
    public function adminView(User $user)
    {
        // Admins can view anyone (teachers, students, guests)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access to remote view.');
        }

        return view('remote-view.index', compact('user'));
    }

    /**
     * Display the remote view page for Teachers.
     */
    public function teacherView(User $user)
    {
        // Teachers can only view students and guests
        if (auth()->user()->role !== 'teacher') {
            abort(403, 'Unauthorized access to remote view.');
        }

        if (in_array($user->role, ['admin', 'teacher'])) {
             abort(403, 'Teachers cannot view other teachers or admins.');
        }

        return view('remote-view.index', compact('user'));
    }

    /**
     * Send a reliable server-side remote screen request event.
     */
    public function requestScreen(Request $request)
    {
        $request->validate([
            'target_id' => 'required|integer|exists:users,id',
        ]);

        $actor = $request->user();
        $target = User::findOrFail((int) $request->input('target_id'));
        $actorRole = $actor->active_role ?? $actor->role;

        if (!in_array($actorRole, ['admin', 'teacher'], true)) {
            abort(403, 'Only admin/teacher can request screen sharing.');
        }

        if ($actorRole === 'teacher' && in_array($target->role, ['admin', 'teacher'], true)) {
            abort(403, 'Teachers cannot request screen from admins/teachers.');
        }

        $payload = [
            'request_id' => (string) Str::uuid(),
            'fromId' => $actor->id,
            'fromName' => $actor->name,
            'created_at' => now()->toIso8601String(),
        ];

        Cache::put($this->pendingRequestCacheKey($target->id), $payload, now()->addMinutes(2));

        broadcast(new RemoteScreenRequested($target->id, $actor->id, $actor->name))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Screen request sent.',
        ]);
    }

    /**
     * Fallback polling endpoint in case websocket delivery fails.
     */
    public function pendingRequest(Request $request)
    {
        $userId = (int) $request->user()->id;
        $data = Cache::get($this->pendingRequestCacheKey($userId));

        return response()->json([
            'pending' => !empty($data),
            'request' => $data,
        ]);
    }

    /**
     * Acknowledge a pending request so polling does not repeat it.
     */
    public function acknowledgePendingRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|string',
        ]);

        $userId = (int) $request->user()->id;
        $key = $this->pendingRequestCacheKey($userId);
        $data = Cache::get($key);

        if (is_array($data) && ($data['request_id'] ?? null) === $request->input('request_id')) {
            Cache::forget($key);
        }

        return response()->json(['success' => true]);
    }
}
