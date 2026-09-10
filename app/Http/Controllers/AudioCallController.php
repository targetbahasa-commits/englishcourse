<?php

namespace App\Http\Controllers;

use App\Events\RemoteAudioCallRequested;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Audio-call "ring" step for the admin Live Preview page's "Panggil Audio"
 * button - deliberately separate from RemoteViewController's screen-share
 * request flow (requestScreen()/pendingRequest()), which hard-validates
 * target_path against an IELTS-Writing-only regex and requires the student
 * to have manually "armed" a specific tab first (see
 * student-broadcaster.blade.php's isCurrentTabArmed()). A voice call should
 * ring the student wherever they currently are, on any assignment page, so
 * neither restriction applies here.
 *
 * The actual WebRTC handshake once the student accepts (Offer/Answer/
 * IceCandidate/Log/CloseSession) reuses RemoteViewController::sendSignal()/
 * pendingSignals() unchanged - those are already fully generic and
 * unrestricted, just relaying whatever payload/type is given to whichever
 * user id it's addressed to. Own Cache key namespace
 * (audio_call_request:{id}) so a pending call-request and a pending
 * screen-share request for the same student never collide.
 */
class AudioCallController extends Controller
{
    private function pendingRequestCacheKey(int $targetId): string
    {
        return 'audio_call_request:' . $targetId;
    }

    /**
     * Send a reliable server-side audio-call request event - the "ring".
     * No SDP here yet; the admin only captures its own mic and creates an
     * Offer once the student has actually accepted (see
     * current-assignment.blade.php's call flow docblock).
     */
    public function requestCall(Request $request)
    {
        $request->validate([
            'target_id' => 'required|integer|exists:users,id',
        ]);

        $actor = $request->user();
        $target = User::findOrFail((int) $request->input('target_id'));
        $actorRole = $actor->active_role ?? $actor->role;

        if (! in_array($actorRole, ['admin', 'teacher'], true)) {
            abort(403, 'Only admin/teacher can start an audio call.');
        }

        if ($actorRole === 'teacher' && in_array($target->role, ['admin', 'teacher'], true)) {
            abort(403, 'Teachers cannot call admins/teachers.');
        }

        $payload = [
            'request_id' => (string) Str::uuid(),
            'fromId'     => $actor->id,
            'fromName'   => $actor->name,
            'created_at' => now()->toIso8601String(),
        ];

        Cache::put($this->pendingRequestCacheKey($target->id), $payload, now()->addMinutes(2));

        broadcast(new RemoteAudioCallRequested($target->id, $actor->id, $actor->name))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Call request sent.',
        ]);
    }

    /**
     * Fallback polling endpoint in case websocket delivery fails - polled
     * by student-broadcaster.blade.php exactly like the screen-share
     * equivalent (pendingRequest() in RemoteViewController).
     */
    public function pendingRequest(Request $request)
    {
        $userId = (int) $request->user()->id;
        $data = Cache::get($this->pendingRequestCacheKey($userId));

        return response()->json([
            'pending' => ! empty($data),
            'request' => $data,
        ]);
    }

    /**
     * Acknowledge a pending call request so polling does not repeat it.
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
