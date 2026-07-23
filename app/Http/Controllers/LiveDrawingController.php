<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * LiveDrawingController
 *
 * Handles real-time drawing synchronization between an Admin/Intern (Sender)
 * and a Student (Receiver) using an HTTP API Polling approach.
 *
 * This serves as a reliable fallback when WebSocket broadcasting
 * (Pusher / Laravel Reverb) is disabled (BROADCAST_CONNECTION=null).
 *
 * Cache keys used:
 *   live_drawing_{userId}       → base64 PNG string or 'clear'
 *   live_drawing_time_{userId}  → microtime(true) float timestamp
 */
class LiveDrawingController extends Controller
{
    /**
     * POST /api/live-drawing/sync
     *
     * Receives the current canvas state from an Admin/Intern sender and
     * stores it in the Laravel Cache keyed by the target student's user ID.
     *
     * Request body (JSON):
     *   - targetUserId (int)   : The student's user ID to broadcast to.
     *   - payload      (string): Base64-encoded PNG data URI from canvas.toDataURL(),
     *                            or the literal string 'clear' to clear the student's canvas.
     *
     * Access: Only authenticated users with role 'admin' or 'intern'.
     */
    public function sync(Request $request)
    {
        $user = auth()->user();

        // Guard: must be authenticated admin or intern
        if (! $user || ! in_array($user->role, ['admin', 'intern'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins and interns can sync drawings.',
            ], 403);
        }

        $targetUserId = $request->input('targetUserId');
        $payload      = $request->input('payload'); // base64 PNG or 'clear'

        if (! $targetUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing targetUserId.',
            ], 422);
        }

        if (! $payload) {
            return response()->json([
                'success' => false,
                'message' => 'Missing payload.',
            ], 422);
        }

        // Store the drawing state and a high-precision timestamp
        // TTL: 3600 seconds (1 hour) — drawing persists for the session duration
        $timestamp = microtime(true);
        Cache::put('live_drawing_' . $targetUserId,       $payload,   3600);
        Cache::put('live_drawing_time_' . $targetUserId,  $timestamp, 3600);

        return response()->json([
            'success'   => true,
            'time'      => $timestamp,
        ]);
    }

    /**
     * GET /api/live-drawing/fetch/{targetUserId}
     *
     * Polls for the latest drawing state for the given student.
     * Uses a timestamp-comparison strategy to avoid sending the same
     * large base64 payload repeatedly (bandwidth optimization).
     *
     * Query params:
     *   - last_time (float): The microtime timestamp the client last received.
     *                        Defaults to 0 (fetch unconditionally on first poll).
     *
     * Response (JSON):
     *   If server has a NEWER timestamp than last_time:
     *     { success: true, payload: "<base64 or 'clear'>", time: <float> }
     *   Otherwise (no new drawing since last poll):
     *     { success: true, time: <float> }  ← no payload key to save bandwidth
     *
     * Access:
     *   - The target student themselves (user ID matches).
     *   - Any authenticated user with role 'admin' or 'intern'.
     */
    public function fetch(Request $request, $targetUserId)
    {
        $user = auth()->user();

        // Guard: must be authenticated
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        // Guard: only the target student or admin/intern roles can fetch
        $isOwner  = (int) $user->id === (int) $targetUserId;
        $isStaff  = in_array($user->role, ['admin', 'intern']);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to view this drawing.',
            ], 403);
        }

        // The client sends its last known timestamp so we can diff
        $lastTime     = (float) $request->query('last_time', 0);
        $serverTime   = (float) Cache::get('live_drawing_time_' . $targetUserId, 0);

        // Only send the payload when there's actually something new
        if ($serverTime > 0 && $serverTime > $lastTime) {
            $payload = Cache::get('live_drawing_' . $targetUserId);

            return response()->json([
                'success' => true,
                'payload' => $payload,
                'time'    => $serverTime,
            ]);
        }

        // Nothing new — only return the current server time so the client
        // can update its lastFetchTime reference without a heavy payload.
        return response()->json([
            'success' => true,
            'time'    => $serverTime,
        ]);
    }
}
