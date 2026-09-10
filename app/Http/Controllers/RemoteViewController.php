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

    private function signalQueueCacheKey(int $targetId): string
    {
        return 'remote_signal_queue:' . $targetId;
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
            'target_path' => ['nullable', 'string', 'regex:#^/assignments/ielts-academic/writing/(1|2)/meeting/[0-9]+$#'],
            'target_title' => 'nullable|string|max:120',
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

        $targetPath = $request->input('target_path');
        $targetTitle = $request->input('target_title');

        $payload = [
            'request_id' => (string) Str::uuid(),
            'fromId' => $actor->id,
            'fromName' => $actor->name,
            'target_path' => $targetPath,
            'target_title' => $targetTitle,
            'created_at' => now()->toIso8601String(),
        ];

        Cache::put($this->pendingRequestCacheKey($target->id), $payload, now()->addMinutes(2));

        broadcast(new RemoteScreenRequested($target->id, $actor->id, $actor->name, $targetPath, $targetTitle))->toOthers();

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

    /**
     * Queue a WebRTC signaling message for polling fallback.
     */
    public function sendSignal(Request $request)
    {
        $request->validate([
            'target_id' => 'required|integer|exists:users,id',
            // AudioCallAccepted/AudioCallRejected/AudioCallEnded are the
            // ring-step acks for AudioCallController's audio-call flow
            // (see its docblock) - Offer/Answer/IceCandidate/Log/
            // CloseSession are shared, already-generic signal types reused
            // as-is by both screen-share and audio-call sessions.
            'type' => 'required|string|in:ScreenAccepted,ScreenRejected,Offer,Answer,IceCandidate,ScreenStopped,CloseSession,Log,AudioCallAccepted,AudioCallRejected,AudioCallEnded',
            'payload' => 'nullable|array',
        ]);

        $actor = $request->user();
        $target = User::findOrFail((int) $request->input('target_id'));
        $payload = $request->input('payload', []);

        $signal = [
            'signal_id' => $payload['signal_id'] ?? (string) Str::uuid(),
            'type' => $request->input('type'),
            'fromId' => $actor->id,
            'fromName' => $actor->name,
            'payload' => $payload,
            'created_at' => now()->toIso8601String(),
        ];

        $key = $this->signalQueueCacheKey($target->id);
        $queue = Cache::get($key, []);
        if (!is_array($queue)) {
            $queue = [];
        }

        $queue[] = $signal;
        $queue = array_slice($queue, -100);
        Cache::put($key, $queue, now()->addMinutes(2));

        return response()->json(['success' => true]);
    }

    /**
     * Retrieve and clear queued signaling messages for polling fallback.
     */
    public function pendingSignals(Request $request)
    {
        $userId = (int) $request->user()->id;
        $key = $this->signalQueueCacheKey($userId);
        $signals = Cache::pull($key, []);

        return response()->json([
            'signals' => is_array($signals) ? $signals : [],
        ]);
    }
}
