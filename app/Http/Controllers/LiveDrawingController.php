<?php

namespace App\Http\Controllers;

use App\Models\ClassPeriod;
use App\Models\Program;
use App\Models\User;
use App\Models\WhiteboardArchive;
use App\Models\WhiteboardCheckpoint;
use App\Models\WhiteboardSave;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * LiveDrawingController
 *
 * Handles real-time whiteboard synchronization for a "room" keyed by a
 * student's user ID, using an HTTP API Polling approach. Anyone with access
 * to a room (the student themselves, or an admin/teacher/intern) can both
 * draw AND see everyone else's strokes - it is not a one-way broadcast.
 *
 * This serves as a reliable fallback when WebSocket broadcasting
 * (Pusher / Laravel Reverb) is disabled (BROADCAST_CONNECTION=null).
 *
 * The board is split into two independently-clearable LAYERS: 'staff'
 * (teacher/admin/intern) and 'student'. Which layer a normal draw sync
 * writes to is always inferred server-side from the WRITER's own role
 * (self::STAFF_ROLES), never trusted from client input - this is what
 * guarantees a student can never write into (or clear) the staff layer.
 * `canvas_data` is the original/legacy column from before this split
 * existed and now specifically means the staff layer (this whiteboard is
 * mainly used for teachers explaining material, so pre-split content is
 * treated as staff-authored); `canvas_data_student` is the new column.
 *
 * Cache keys used (per layer, {layer} = 'staff' | 'student'):
 *   live_drawing_{layer}_{userId}       → base64 PNG string
 *   live_drawing_{layer}_time_{userId}  → microtime(true) float timestamp
 *
 * Every sync() also durably autosaves the canvas to the whiteboard_saves
 * table (see WhiteboardSave), since the cache above is ephemeral (1 hour
 * TTL) and only meant for live collaboration - the DB row is what survives
 * cache expiry, server restarts, or the student returning after a break.
 * fetch() transparently falls back to it on a cold cache.
 *
 * BROADCASTING: a staff member can let a chosen set of students watch their
 * OWN individual room (the same one described above - never a separate
 * room). This is deliberate: an earlier version routed broadcasting through
 * a synthetic "batch-{staffId}" room so it wouldn't need a real FK-able
 * user_id, but that meant the teacher's normal board and their broadcast
 * were two DIFFERENT canvases with different content - confusing (the
 * board visibly "changes" when toggling broadcast on/off) and it meant
 * broadcast sessions couldn't be archived. Now "Aktifkan" (see
 * presenceTargets()/isBatchTarget()) just controls WHO ELSE is currently
 * authorized to fetch() the broadcaster's own room's staff layer - the
 * content itself never moves. A targeted student is authorized in fetch()
 * only while BOTH isBatchTarget() is true AND the broadcaster's dedicated
 * "live_drawing_broadcast_presence_{staffId}" key is live (see presence()) -
 * kept deliberately separate from the general
 * "live_drawing_staff_presence_{id}" panel-open key, so starting/stopping a
 * broadcast never flickers a teacher's own private-review presence and vice
 * versa. Since a student has no way to know in advance which staff
 * member(s) might be broadcasting to them, myBatchStatus() consults a small
 * registry of currently-active broadcaster ids (the
 * 'live_drawing_active_broadcasters' cache key, maintained by presence())
 * rather than needing a class-period lookup.
 */
class LiveDrawingController extends Controller
{
    /** Roles allowed to draw on / view any student's whiteboard room. */
    private const STAFF_ROLES = ['admin', 'teacher', 'intern'];

    /** DB column that stores each layer's durable autosave. */
    private const LAYER_COLUMNS = [
        'staff'    => 'canvas_data',
        'student'  => 'canvas_data_student',
        // A student's private "Notebook" tab (see class docblock) - own
        // independent notes, isolated from the staff/student layers above
        // and from broadcast/Live Student View: it lives in the SAME room
        // row (still keyed by the student's own real user id, so the
        // durable-autosave FK stays valid) but is a THIRD layer that's
        // never included in a normal fetch()/pollDrawingState() response
        // unless explicitly requested with last_time_notebook (see fetch()),
        // and only ever for the room's own owner - staff never get it back,
        // even if they ask.
        'notebook' => 'canvas_data_notebook',
    ];

    /**
     * response()->json() with explicit no-store headers, for the polling
     * endpoints (fetch/myBatchStatus). Without this, the
     * very first poll after a fresh page load always requests the exact
     * same URL it did on the previous load (last_time_staff/student reset
     * to 0 by a fresh Alpine mount) - if a browser or intermediary (e.g.
     * Cloudflare, which fronts this site) is allowed to cache that GET by
     * default HTTP semantics, a refresh can silently replay a stale/empty
     * cached response instead of hitting the server, even though live
     * polling within the same session (never repeating a URL, since
     * last_time_* only ever increases) worked fine.
     */
    private function noCacheJson(array $data, int $status = 200)
    {
        return response()->json($data, $status)->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
        ]);
    }

    /** Whether $user (a student) is currently targeted by $broadcasterId's active broadcast. */
    private function isBatchTarget($user, int $broadcasterId): bool
    {
        if ($user->role !== 'student') {
            return false;
        }

        $targets = Cache::get("live_drawing_batch_targets_{$broadcasterId}", []);

        return $targets === 'all' || in_array((int) $user->id, array_map('intval', (array) $targets), true);
    }

    /**
     * Cache key name for the small registry of staff user ids currently
     * broadcasting (see presence()/myBatchStatus()) - a student has no
     * other way to discover which broadcaster(s), if any, are active.
     */
    private const ACTIVE_BROADCASTERS_KEY = 'live_drawing_active_broadcasters';

    /**
     * POST /api/live-drawing/sync
     *
     * Receives the current canvas state from anyone with access to the room
     * and stores it in the Laravel Cache keyed by the room's user ID and
     * layer (which layer is inferred from the WRITER's own role - see class
     * docblock).
     *
     * Request body (JSON):
     *   - targetUserId (int)   : The room (student user ID) to write to.
     *   - payload      (string): Base64-encoded PNG data URI from canvas.toDataURL(),
     *                            or 'clear:all' / 'clear:staff' / 'clear:student'
     *                            to clear a specific layer (or both).
     *
     * Access: the room's own student, or an admin/teacher/intern - but
     * clearing the staff layer (or 'clear:all', which touches it too)
     * additionally requires staff, so a student can never wipe the
     * teacher/admin's content.
     */
    public function sync(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $targetUserId = $request->input('targetUserId');
        $payload      = $request->input('payload');

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

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to draw in this room.',
            ], 403);
        }

        $timestamp = microtime(true);

        if (str_starts_with($payload, 'clear:')) {
            return $this->handleClear($targetUserId, substr($payload, 6), $isStaff, $isOwner, $timestamp);
        }

        // Normal draw payload - layer is inferred from the WRITER's own
        // role, never trusted from the client, so a student can never
        // (accidentally or otherwise) write into the staff layer.
        //
        // Exception: an explicit `layer` field. Used by openArchive() to
        // restore a snapshot that legitimately contains both layers'
        // content back onto the live board - not "drawing" on behalf of a
        // role, just replaying a previously-saved (and already correctly
        // attributed) state. Also the ONLY way to reach 'notebook' - the
        // ternary below never infers it from a role, since a student's
        // Notebook tab (see class docblock) explicitly requests it every
        // sync, staff or not.
        $explicitLayer = $request->input('layer');

        if ($explicitLayer && ! in_array($explicitLayer, ['staff', 'student', 'notebook'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid layer.',
            ], 422);
        }

        if ($explicitLayer === 'staff' && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only staff can write to the teacher/admin layer.',
            ], 403);
        }

        // Notebook is personal - only the room's own student may ever
        // write to it, even staff explicitly asking are refused (unlike
        // every other layer, which staff can always draw into).
        if ($explicitLayer === 'notebook' && ! $isOwner) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only this student can write to their notebook.',
            ], 403);
        }

        $layer = $explicitLayer ?: ($isStaff ? 'staff' : 'student');

        // Per-panel scroll region (see directOverlayMode's scrollRegions) -
        // an independently-scrollable sub-area of the page (e.g. a sticky
        // sidebar with its own overflow) gets its own small canvas, synced
        // under its own Cache key suffix. Deliberately Cache-only/ephemeral
        // (same 3600s TTL as everything else, but skips the WhiteboardSave
        // DB-persistence branch below entirely) - region ink isn't included
        // in Simpan/Arsip/PDF export, only live-session sync. $layer above
        // is still inferred from the writer's role exactly as normal, so
        // the same staff/student write authorization applies.
        $region = $request->input('region');
        if ($region !== null && $region !== '') {
            Cache::put("live_drawing_{$layer}_r{$region}_{$targetUserId}",      $payload,   3600);
            Cache::put("live_drawing_{$layer}_r{$region}_time_{$targetUserId}", $timestamp, 3600);

            return response()->json([
                'success' => true,
                'time'    => $timestamp,
                'layer'   => $layer,
                'region'  => $region,
            ]);
        }

        $column = self::LAYER_COLUMNS[$layer];

        Cache::put("live_drawing_{$layer}_{$targetUserId}",      $payload,   3600);
        Cache::put("live_drawing_{$layer}_time_{$targetUserId}", $timestamp, 3600);

        // firstOrNew (not updateOrCreate) so a brand new row - e.g. a
        // student drawing first, before any staff content ever exists -
        // gets ALL THREE columns defaulted to '' before setting just this
        // one: canvas_data is a legacy NOT NULL column, so leaving it
        // entirely unset on a fresh INSERT would fail the constraint.
        $save = WhiteboardSave::firstOrNew(['user_id' => $targetUserId]);
        if (! $save->exists) {
            $save->canvas_data          = '';
            $save->canvas_data_student  = '';
            $save->canvas_data_notebook = '';
        }
        $save->{$column} = $payload;
        $save->saved_at  = now();
        $save->save();

        return response()->json([
            'success' => true,
            'time'    => $timestamp,
            'layer'   => $layer,
        ]);
    }

    /**
     * Clears a layer ('staff' | 'student' | 'notebook') or both staff+student
     * ('all') for a room, both in the live cache and the durable autosave.
     * Split out of sync() since it has its own authorization rules
     * (staff-only for 'staff'/'all'; owner-only for 'notebook').
     *
     * 'all' deliberately never includes 'notebook' - it means "clear the
     * shared whiteboard for everyone" (what staff's "Hapus" trigger sends),
     * and a student's private notes are never part of that, no matter who's
     * clearing. Only an explicit scope=notebook request (and only from the
     * room's own student) ever touches it.
     */
    private function handleClear(string $targetUserId, string $scope, bool $isStaff, bool $isOwner, float $timestamp)
    {
        if (! in_array($scope, ['all', 'staff', 'student', 'notebook'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid clear scope.',
            ], 422);
        }

        if (($scope === 'staff' || $scope === 'all') && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only staff can clear the teacher/admin layer.',
            ], 403);
        }

        if ($scope === 'notebook' && ! $isOwner) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only this student can clear their notebook.',
            ], 403);
        }

        $layersToClear = $scope === 'all' ? ['staff', 'student'] : [$scope];
        $save          = WhiteboardSave::where('user_id', $targetUserId)->first();

        foreach ($layersToClear as $layer) {
            Cache::forget("live_drawing_{$layer}_{$targetUserId}");
            Cache::put("live_drawing_{$layer}_time_{$targetUserId}", $timestamp, 3600);

            if ($save) {
                // '' not null: canvas_data is a legacy NOT NULL column (from
                // before the student/notebook layers existed), so an empty
                // string is this table's "no content" sentinel for every
                // column - every read site treats it the same as null
                // (falsy checks).
                $save->{self::LAYER_COLUMNS[$layer]} = '';
            }
        }

        if ($save) {
            // Nothing left in ANY layer - remove the row entirely rather
            // than leaving a save with three empty columns behind.
            if (! $save->canvas_data && ! $save->canvas_data_student && ! $save->canvas_data_notebook) {
                $save->delete();
            } else {
                $save->save();
            }
        }

        return response()->json([
            'success' => true,
            'time'    => $timestamp,
            'scope'   => $scope,
        ]);
    }

    /**
     * GET /api/live-drawing/fetch/{targetUserId}
     *
     * Polls for the latest drawing state for the given student, for BOTH
     * layers at once. Uses a timestamp-comparison strategy per layer to
     * avoid sending the same large base64 payload repeatedly (bandwidth
     * optimization) - a viewer only re-fetches whichever layer actually
     * changed since their last poll, not both every time.
     *
     * Query params:
     *   - last_time_staff    (float): timestamp the client last received for the staff layer.
     *   - last_time_student  (float): timestamp the client last received for the student layer.
     *                                 Both default to 0 (fetch unconditionally on first poll).
     *   - last_time_notebook (float, optional): timestamp the client last received for the
     *                                 caller's own notebook layer. Omitted entirely (not just
     *                                 defaulted to 0) unless the caller is the room's own
     *                                 student AND actually asks for it - staff never get a
     *                                 'notebook' key back even if they pass this, and it's
     *                                 never included in the response at all for anyone else,
     *                                 keeping it off every normal/broadcast poll's payload.
     *
     * Response (JSON):
     *   {
     *     success:   true,
     *     staff:     { payload?: "<base64>", time: <float> },
     *     student:   { payload?: "<base64>", time: <float> },
     *     notebook?: { payload?: "<base64>", time: <float> },
     *   }
     *   `payload` is only present on a layer when the server has newer data
     *   than that layer's last_time.
     *
     * Access:
     *   - The room's own student (user ID matches).
     *   - Any authenticated user with role 'admin', 'teacher' or 'intern'.
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

        // Guard: only the room's own student, staff roles, or a student
        // currently targeted by that room owner's active broadcast (see
        // class docblock/toggleBroadcast()) can fetch.
        $isOwner  = (int) $user->id === (int) $targetUserId;
        $isStaff  = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            $isBroadcastTarget = $this->isBatchTarget($user, (int) $targetUserId)
                && Cache::has("live_drawing_broadcast_presence_{$targetUserId}");

            if (! $isBroadcastTarget) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. You do not have permission to view this drawing.',
                ], 403);
            }
        }

        $response = [
            'success'     => true,
            'staff'       => $this->fetchLayer($targetUserId, 'staff', (float) $request->query('last_time_staff', 0)),
            'student'     => $this->fetchLayer($targetUserId, 'student', (float) $request->query('last_time_student', 0)),
            // Whether a staff member currently has their whiteboard panel
            // open for this room - see presence(). The student's own poll
            // response (this same call) uses this to auto-open their panel
            // in real time when the teacher starts explaining.
            'staffActive' => Cache::has("live_drawing_staff_presence_{$targetUserId}"),
            // 'direct' when the staff member opened this from Admin's Live
            // Student View ("Mode Coret-Coret" - see presence()) - the
            // student's auto-open should mirror that as a lean transparent
            // overlay instead of the full floating panel. Defaults to
            // 'panel' (today's normal behavior) for every other case,
            // including stale/missing cache entries.
            'staffMode' => Cache::get("live_drawing_staff_presence_mode_{$targetUserId}", 'panel'),
        ];

        if ($isOwner && $request->has('last_time_notebook')) {
            $response['notebook'] = $this->fetchLayer($targetUserId, 'notebook', (float) $request->query('last_time_notebook', 0));
        }

        // Per-panel scroll regions (see directOverlayMode's scrollRegions) -
        // caller passes the indexes it already detected on its own page
        // (e.g. "0,1"); each gets its own staff/student pair, fetched via
        // the same fetchLayer() Cache-key logic as the main layers (see
        // sync()'s $region branch for how these get written).
        $regionsParam = $request->query('regions', '');
        if ($regionsParam !== '') {
            $response['regions'] = [];
            foreach (explode(',', $regionsParam) as $region) {
                $region = trim($region);
                if ($region === '') {
                    continue;
                }
                $response['regions'][$region] = [
                    'staff'   => $this->fetchLayer($targetUserId, "staff_r{$region}", (float) $request->query("last_time_staff_r{$region}", 0)),
                    'student' => $this->fetchLayer($targetUserId, "student_r{$region}", (float) $request->query("last_time_student_r{$region}", 0)),
                ];
            }
        }

        return $this->noCacheJson($response);
    }

    /**
     * POST /api/live-drawing/presence
     *
     * Lets a staff viewer announce "my whiteboard panel is open/closed for
     * this room" so the student's page (already polling fetch() every
     * 1.5s) can auto-open their own panel the moment a teacher starts
     * explaining, instead of the student having to notice and click it
     * themselves. Purely an ephemeral presence flag - short TTL, refreshed
     * by a client-side heartbeat while the panel stays open, so a teacher
     * closing the tab without cleanup self-expires within seconds rather
     * than leaving the student's panel flagged "active" forever.
     *
     * Only staff can set this - a student opening their own panel has
     * nothing analogous to broadcast (there's no one on the staff side
     * automatically watching every student's room).
     */
    public function presence(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if (! in_array($user->role, self::STAFF_ROLES)) {
            return response()->json([
                'success' => false,
                'message' => 'Only staff can broadcast whiteboard presence.',
            ], 403);
        }

        $targetUserId = $request->input('targetUserId');

        if (! $targetUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing targetUserId.',
            ], 422);
        }

        // Broadcasting (see toggleBroadcast()/class docblock) is tracked via
        // its OWN dedicated presence key and registry, entirely separate
        // from the general "panel open" key below - a single request is
        // EITHER a broadcast ping OR a panel-open ping, never both, so
        // starting/stopping one never touches the other's key even though
        // both can legitimately be true independently for the exact same
        // room. Only the room's own staff member can ever set this (never
        // on someone else's behalf).
        if ($request->boolean('broadcasting')) {
            if (in_array($user->role, self::STAFF_ROLES) && (int) $user->id === (int) $targetUserId) {
                $broadcastKey = "live_drawing_broadcast_presence_{$targetUserId}";

                if ($request->boolean('active')) {
                    Cache::put($broadcastKey, true, 20);

                    // Cosmetic viewer preferences (ruled notebook-lines
                    // background - see toggleRuledLines() - and now the
                    // zoom level - see setZoom()) are never part of the
                    // synced bitmap, so they don't ride along with fetch()'s
                    // payload like drawn content does. Broadcasting is the
                    // one case where a viewer's own preference needs to
                    // follow someone ELSE's toggle, so it's carried here
                    // instead, alongside the same presence ping that already
                    // fires immediately on every toggle and periodically via
                    // the heartbeat (see toggleBroadcast()).
                    Cache::put("live_drawing_broadcast_ruled_{$targetUserId}", $request->boolean('ruledLines'), 20);
                    Cache::put("live_drawing_broadcast_zoom_{$targetUserId}", (float) $request->input('zoomLevel', 1), 20);
                } else {
                    Cache::forget($broadcastKey);
                    Cache::forget("live_drawing_broadcast_ruled_{$targetUserId}");
                    Cache::forget("live_drawing_broadcast_zoom_{$targetUserId}");
                }

                // Additionally needs to be discoverable by students who have
                // no other way to know this broadcaster exists yet - keep a
                // small registry of active broadcaster ids (see myBatchStatus()).
                $this->updateActiveBroadcasters((int) $user->id, $request->boolean('active'));
            }

            return response()->json(['success' => true]);
        }

        $key = "live_drawing_staff_presence_{$targetUserId}";
        // Companion key to $key above, carrying whether this activation came
        // from Admin's Live Student View ("Mode Coret-Coret" - directOverlay
        // in the request body) vs. a normal on-page Whiteboard open - see
        // fetch()'s 'staffMode' and the client's directOverlayMode.
        $modeKey = "live_drawing_staff_presence_mode_{$targetUserId}";

        if ($request->boolean('active')) {
            // TTL comfortably longer than the client's heartbeat interval,
            // so a couple of missed beats (slow network, tab backgrounded)
            // don't flicker the student's panel closed and back open.
            Cache::put($key, true, 20);
            Cache::put($modeKey, $request->boolean('directOverlay') ? 'direct' : 'panel', 20);
        } else {
            Cache::forget($key);
            Cache::forget($modeKey);
        }

        return response()->json(['success' => true]);
    }

    /** Adds or removes a broadcaster id from the active-broadcasters registry (see presence()/myBatchStatus()). */
    private function updateActiveBroadcasters(int $broadcasterId, bool $active): void
    {
        $ids = Cache::get(self::ACTIVE_BROADCASTERS_KEY, []);

        if ($active) {
            if (! in_array($broadcasterId, $ids, true)) {
                $ids[] = $broadcasterId;
            }
        } else {
            $ids = array_values(array_diff($ids, [$broadcasterId]));
        }

        Cache::put(self::ACTIVE_BROADCASTERS_KEY, $ids, 3600);
    }

    /**
     * POST /api/live-drawing/batch/targets
     *
     * Sets which students are currently included in the CALLER's OWN
     * broadcast - 'all', or a specific list of student user IDs picked by
     * name (see searchStudents()). Read by isBatchTarget() to authorize
     * each targeted student's fetch() poll into the broadcaster's own room,
     * and by myBatchStatus() so a student's own page knows whether to auto-attach.
     * Always scoped to the authenticated caller's own broadcaster id -
     * there is no way to set another staff member's targets.
     *
     * Request body (JSON): { targets: 'all' | int[] }
     */
    public function presenceTargets(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        if (! in_array($user->role, self::STAFF_ROLES)) {
            return response()->json([
                'success' => false,
                'message' => 'Only staff can set whiteboard broadcast targets.',
            ], 403);
        }

        $targets = $request->input('targets', 'all');

        if ($targets !== 'all' && ! is_array($targets)) {
            return response()->json([
                'success' => false,
                'message' => 'targets must be "all" or an array of student IDs.',
            ], 422);
        }

        $stored = $targets === 'all' ? 'all' : array_values(array_map('intval', $targets));

        Cache::put("live_drawing_batch_targets_{$user->id}", $stored, 3600);

        return response()->json(['success' => true, 'targets' => $stored]);
    }

    /**
     * GET /api/live-drawing/batch/my-status
     *
     * Lets a student's own page (already polling its own individual room)
     * cheaply check "is any staff member currently broadcasting to me right
     * now?" by scanning the small active-broadcasters registry (see
     * presence()/updateActiveBroadcasters()) rather than needing to know in
     * advance which staff member it might be.
     */
    public function myBatchStatus(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $broadcasterIds = Cache::get(self::ACTIVE_BROADCASTERS_KEY, []);

        foreach ($broadcasterIds as $broadcasterId) {
            // Self-heal the registry against a broadcaster whose tab closed
            // without cleanly calling presence(active:false) - their
            // dedicated broadcast presence key (20s TTL, heartbeat-
            // refreshed) will simply have expired by then.
            if (! Cache::has("live_drawing_broadcast_presence_{$broadcasterId}")) {
                $this->updateActiveBroadcasters($broadcasterId, false);
                continue;
            }

            if ($this->isBatchTarget($user, $broadcasterId)) {
                // The room is just the broadcaster's own real user id now
                // (see class docblock) - fetch() authorizes a targeted
                // student into it the same way it always has for anyone
                // else's room, no separate endpoint needed.
                return $this->noCacheJson([
                    'success'    => true,
                    'active'     => true,
                    'room'       => $broadcasterId,
                    // See presence(): purely cosmetic viewer preferences
                    // that aren't part of the synced bitmap, so they ride
                    // along here instead.
                    'ruledLines' => (bool) Cache::get("live_drawing_broadcast_ruled_{$broadcasterId}", false),
                    'zoomLevel'  => (float) Cache::get("live_drawing_broadcast_zoom_{$broadcasterId}", 1),
                ]);
            }
        }

        return $this->noCacheJson(['success' => true, 'active' => false]);
    }

    /**
     * Resolve one layer's fetch response: newer cached data if available,
     * a cold-cache DB fallback on a client's very first poll, or just the
     * current server timestamp when there's nothing new.
     */
    private function fetchLayer(string $targetUserId, string $layer, float $lastTime): array
    {
        $serverTime = (float) Cache::get("live_drawing_{$layer}_time_{$targetUserId}", 0);

        if ($serverTime > 0 && $serverTime > $lastTime) {
            return [
                'payload' => Cache::get("live_drawing_{$layer}_{$targetUserId}"),
                'time'    => $serverTime,
            ];
        }

        // Cache is cold (expired TTL or server restart) on what looks like a
        // fresh page load (client has no last_time yet) — fall back to the
        // durably-saved canvas and re-hydrate the cache from it, so the
        // last autosaved work reappears instead of a blank board.
        //
        // Per-panel scroll regions (see sync()'s $region branch) pass a
        // composite layer string like "staff_r0" here to reuse this same
        // Cache-key logic - they have no LAYER_COLUMNS/WhiteboardSave
        // entry at all (deliberately Cache-only/ephemeral), so skip this
        // DB-fallback branch entirely for them rather than looking up a
        // column that doesn't exist.
        if ($serverTime === 0.0 && $lastTime === 0.0 && array_key_exists($layer, self::LAYER_COLUMNS)) {
            $column = self::LAYER_COLUMNS[$layer];
            $saved  = WhiteboardSave::where('user_id', $targetUserId)->first();

            if ($saved && $saved->{$column}) {
                $restoredTime = microtime(true);
                Cache::put("live_drawing_{$layer}_{$targetUserId}", $saved->{$column}, 3600);
                Cache::put("live_drawing_{$layer}_time_{$targetUserId}", $restoredTime, 3600);

                return [
                    'payload' => $saved->{$column},
                    'time'    => $restoredTime,
                ];
            }
        }

        // Nothing new — only return the current server time so the client
        // can update its lastFetchTime reference without a heavy payload.
        return ['time' => $serverTime];
    }

    /**
     * POST /api/live-drawing/archive
     *
     * Saves the current canvas as a NEW, permanent named snapshot (does not
     * touch the continuous autosave/live cache at all - a room can have many
     * archives, kept until explicitly deleted). Captures BOTH layers so
     * reopening the archive later restores the full board, not just one
     * layer's content.
     *
     * Request body (JSON):
     *   - targetUserId    (int)   : The room (student user ID) to archive.
     *   - payload         (string): The staff layer's canvas image (same
     *                                JSON-wrapped format sync() uses).
     *   - payloadStudent  (string, optional): The student layer's canvas image.
     *
     * Access: the room's own student, or an admin/teacher/intern.
     */
    public function archive(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $targetUserId   = $request->input('targetUserId');
        $payload        = $request->input('payload');
        $payloadStudent = $request->input('payloadStudent');

        if (! $targetUserId || (! $payload && ! $payloadStudent)) {
            return response()->json([
                'success' => false,
                'message' => 'Missing or invalid payload.',
            ], 422);
        }

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to archive this room.',
            ], 403);
        }

        $archive = WhiteboardArchive::create([
            'user_id'             => $targetUserId,
            'title'               => 'Arsip ' . now()->format('d M Y, H:i'),
            // '' not null: canvas_data is a NOT NULL column, so empty
            // string is this table's "no content" sentinel for both.
            'canvas_data'         => $payload ?: '',
            'canvas_data_student' => $payloadStudent ?: '',
        ]);

        return response()->json([
            'success' => true,
            'archive' => [
                'id'         => $archive->id,
                'title'      => $archive->title,
                'created_at' => $archive->created_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * GET /api/live-drawing/archives/{targetUserId}
     *
     * Lists archives for a room (metadata only - no canvas_data - to keep
     * the list payload small; use showArchive() to fetch one in full).
     *
     * Access: the room's own student, or an admin/teacher/intern.
     */
    public function archives(Request $request, $targetUserId)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to view this room\'s archives.',
            ], 403);
        }

        $archives = WhiteboardArchive::where('user_id', $targetUserId)
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'created_at'])
            ->map(fn ($archive) => [
                'id'         => $archive->id,
                'title'      => $archive->title,
                'created_at' => $archive->created_at->toIso8601String(),
            ]);

        return response()->json([
            'success'  => true,
            'archives' => $archives,
        ]);
    }

    /**
     * GET /api/live-drawing/archives/{targetUserId}/{archive}
     *
     * Fetches one archive's full canvas payload, e.g. to open it back onto
     * the live canvas.
     *
     * Access: the room's own student, or an admin/teacher/intern.
     */
    public function showArchive(Request $request, $targetUserId, WhiteboardArchive $archive)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ((int) $archive->user_id !== (int) $targetUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Archive not found in this room.',
            ], 404);
        }

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        return response()->json([
            'success'        => true,
            'payload'        => $archive->canvas_data,
            'payloadStudent' => $archive->canvas_data_student,
        ]);
    }

    /**
     * DELETE /api/live-drawing/archives/{targetUserId}/{archive}
     *
     * Access: the room's own student, or an admin/teacher/intern.
     */
    public function destroyArchive(Request $request, $targetUserId, WhiteboardArchive $archive)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ((int) $archive->user_id !== (int) $targetUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Archive not found in this room.',
            ], 404);
        }

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $archive->delete();

        return response()->json(['success' => true]);
    }

    /**
     * POST /api/live-drawing/checkpoint
     *
     * Creates a new WhiteboardCheckpoint - identical in shape to archive()
     * (same request body, same both-layers capture), but semantically
     * separate: this is what "Simpan" creates automatically on every click
     * (see the blade component's manualSave()/createCheckpoint()), never a
     * deliberate "save as new snapshot" action of its own. Kept as its own
     * table/model rather than reusing WhiteboardArchive so the two can have
     * different deletion rules (see destroyCheckpoints() - no per-item
     * delete route exists for checkpoints at all, unlike destroyArchive()).
     *
     * Request body (JSON): same as archive() - targetUserId, payload,
     * payloadStudent.
     *
     * Access: the room's own student, or an admin/teacher/intern.
     */
    public function checkpoint(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $targetUserId   = $request->input('targetUserId');
        $payload        = $request->input('payload');
        $payloadStudent = $request->input('payloadStudent');

        if (! $targetUserId || (! $payload && ! $payloadStudent)) {
            return response()->json([
                'success' => false,
                'message' => 'Missing or invalid payload.',
            ], 422);
        }

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to save a checkpoint in this room.',
            ], 403);
        }

        $checkpoint = WhiteboardCheckpoint::create([
            'user_id'             => $targetUserId,
            'title'               => 'Checkpoint ' . now()->format('d M Y, H:i'),
            'canvas_data'         => $payload ?: '',
            'canvas_data_student' => $payloadStudent ?: '',
        ]);

        return response()->json([
            'success'    => true,
            'checkpoint' => [
                'id'         => $checkpoint->id,
                'title'      => $checkpoint->title,
                'created_at' => $checkpoint->created_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * GET /api/live-drawing/checkpoints/{targetUserId}
     *
     * Lists checkpoints for a room (metadata only, same as archives()).
     *
     * Access: the room's own student, or an admin/teacher/intern.
     */
    public function checkpoints(Request $request, $targetUserId)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to view this room\'s checkpoints.',
            ], 403);
        }

        $checkpoints = WhiteboardCheckpoint::where('user_id', $targetUserId)
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'created_at'])
            ->map(fn ($checkpoint) => [
                'id'         => $checkpoint->id,
                'title'      => $checkpoint->title,
                'created_at' => $checkpoint->created_at->toIso8601String(),
            ]);

        return response()->json([
            'success'     => true,
            'checkpoints' => $checkpoints,
        ]);
    }

    /**
     * GET /api/live-drawing/checkpoints/{targetUserId}/{checkpoint}
     *
     * Fetches one checkpoint's full canvas payload, to open it back onto
     * the live canvas (see the blade component's openCheckpoint() - this
     * always replaces the live board for everyone in the room, unlike a
     * local-only preview).
     *
     * Access: the room's own student, or an admin/teacher/intern.
     */
    public function showCheckpoint(Request $request, $targetUserId, WhiteboardCheckpoint $checkpoint)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ((int) $checkpoint->user_id !== (int) $targetUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Checkpoint not found in this room.',
            ], 404);
        }

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        return response()->json([
            'success'        => true,
            'payload'        => $checkpoint->canvas_data,
            'payloadStudent' => $checkpoint->canvas_data_student,
        ]);
    }

    /**
     * DELETE /api/live-drawing/checkpoints/{targetUserId}
     *
     * Bulk-deletes checkpoints by id - the ONLY way a checkpoint is ever
     * removed (see the class-level WhiteboardCheckpoint docblock; there is
     * deliberately no single-checkpoint destroy route). Called from the
     * whiteboard's "Clear All" menu's own checkpoint sub-view (see
     * deleteSelectedCheckpoints() in the blade component).
     *
     * Request body (JSON): { ids: int[] }
     *
     * Access: the room's own student, or an admin/teacher/intern. Only ever
     * deletes checkpoints that actually belong to $targetUserId's room, so
     * a caller can't reach into another room's checkpoints by id-guessing.
     */
    public function destroyCheckpoints(Request $request, $targetUserId)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $isOwner = (int) $user->id === (int) $targetUserId;
        $isStaff = in_array($user->role, self::STAFF_ROLES);

        if (! $isOwner && ! $isStaff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $ids = $request->input('ids', []);

        if (! is_array($ids) || count($ids) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Missing checkpoint ids.',
            ], 422);
        }

        WhiteboardCheckpoint::where('user_id', $targetUserId)
            ->whereIn('id', array_map('intval', $ids))
            ->delete();

        return response()->json(['success' => true]);
    }

    /**
     * POST /api/live-drawing/pdf
     *
     * Renders the whiteboard's current canvas snapshot as a downloadable
     * PDF. The client sends its own already-rendered canvas image (whatever
     * it can currently see/draw on) - this is not a room-access endpoint
     * like sync()/fetch(), just "turn what I'm looking at into a PDF", so
     * the only requirement is being logged in.
     *
     * Request body (JSON):
     *   - payload (string): canvas.toDataURL('image/png') data URI.
     *   - width, height (int, optional): the composite canvas's own pixel
     *     dimensions - see below for why these matter.
     */
    public function exportPdf(Request $request)
    {
        if (! auth()->check()) {
            abort(401);
        }

        $payload = $request->input('payload');

        if (! $payload || ! str_starts_with($payload, 'data:image')) {
            abort(422, 'Missing or invalid image payload.');
        }

        $width  = (int) $request->input('width');
        $height = (int) $request->input('height');

        // The whiteboard canvas grows taller than a single A4 page as
        // notes accumulate. dompdf can't split one <img> across a page
        // break, so scaling it to fit a fixed A4 frame pushed the whole
        // image onto page 2, leaving page 1 blank apart from the header -
        // exactly the "PDF-nya kosong" report this fixes. Sizing the PDF
        // page to the image's own pixel dimensions (plus a fixed header
        // allowance) means the whole note always fits on one page,
        // however tall it is. Falls back to plain A4 if the client didn't
        // send valid dimensions (e.g. an older cached page).
        $headerHeightPx = 40;

        $pdf = Pdf::loadView('pdf.whiteboard-export', [
            'image'          => $payload,
            'width'          => $width > 0 ? $width : null,
            'height'         => $height > 0 ? $height : null,
            'headerHeightPx' => $headerHeightPx,
        ]);

        if ($width > 0 && $height > 0) {
            // dompdf renders at 96 DPI by default: 72pt / 96px = 0.75. The
            // +60px pads the page taller than the header+image's own
            // height - sizing the page to that EXACT total left dompdf's
            // own layout engine deciding the image didn't quite fit in
            // the remaining space (tested: <24px slack still overflowed
            // the image onto a near-empty page 2 - a dompdf box-model
            // quirk, not something worth chasing exactly), pushing the
            // whole image onto page 2 and leaving page 1 blank. 60px of
            // harmless trailing whitespace reliably keeps everything on
            // one page across every size tested (tiny notes through very
            // tall boards).
            $pdf->setPaper([0, 0, $width * 0.75, ($height + $headerHeightPx + 60) * 0.75]);
        } else {
            $pdf->setPaper('a4', 'landscape');
        }

        $filename = 'Catatan-Whiteboard-' . now()->format('Y-m-d-His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * GET /api/live-drawing/students/search?q=...&path=...
     *
     * Backs the "siswa tertentu" broadcast target picker. `path` is the
     * CALLING PAGE's own URL path (e.g. "/assignments/grammar-writing/
     * fast-track/meeting1") - this endpoint's own request path is always
     * just "/api/live-drawing/students/search", so the client has to tell
     * it what page it's being called from. When that path resolves to a
     * Program with a currently-active batch (see resolveProgramFromPath()/
     * resolveActiveClassPeriod()), the list is scoped to just that batch's
     * roster - "the batch currently being taught", matching what the
     * broadcaster is actually looking at. Falls back to an unscoped
     * name/email search across ALL students (the original behavior) when
     * no path is given, it doesn't resolve to a known program, or that
     * program has no active batch - so the picker never goes empty just
     * because a program/track isn't wired into the scoping logic below.
     * Empty query returns the first students alphabetically so the picker
     * isn't empty by default.
     */
    public function searchStudents(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        if (! in_array($user->role, self::STAFF_ROLES)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $q    = trim((string) $request->query('q', ''));
        $path = (string) $request->query('path', '');

        $program     = $path !== '' ? $this->resolveProgramFromPath($path) : null;
        $classPeriod = $program ? $this->resolveActiveClassPeriod($program, $user) : null;

        if ($classPeriod) {
            $students = $this->studentsInClassPeriod($classPeriod->id);

            if ($q !== '') {
                $needle   = mb_strtolower($q);
                $students = $students->filter(fn ($s) => str_contains(mb_strtolower($s->name), $needle)
                    || str_contains(mb_strtolower($s->email), $needle))->values();
            }

            return response()->json([
                'success'   => true,
                'students'  => $students->map(fn ($s) => ['id' => $s->id, 'name' => $s->name])->values(),
                'scopedTo'  => $classPeriod->name,
            ]);
        }

        $students = User::where('role', 'student')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(fn ($inner) => $inner
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%"));
            })
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name']);

        return response()->json(['success' => true, 'students' => $students, 'scopedTo' => null]);
    }

    /**
     * Maps a calling page's URL path to its Program, so searchStudents()
     * can scope the target picker to that program's currently-taught
     * batch. There is no site-wide, generic "which Program does this page
     * belong to" mechanism (each program family's controllers resolve
     * Program - if at all - only for their own internal use, never passing
     * it to the view), so this has to pattern-match the URL itself:
     *   - Grammar Writing tracks: "/assignments/grammar-writing/{track}/..."
     *     - {track} (fast-track|introductory|complexity|proficiency) maps
     *       to a real Program.slug via the same table GrammarWritingAdminController
     *       ::grammarWritingTracks() uses, duplicated here since that method
     *       is private to a different controller with no shared home.
     *   - Everything else: Program.slug is tried directly against the
     *     first path segment after "assignments" (matches toefl-itp,
     *     pte-academic, ielts-general, etc.), then against the first TWO
     *     segments joined with a dash (matches compound slugs like
     *     "ielts-academic-writing" from "/assignments/ielts-academic/writing/...").
     * Returns null (triggering the unscoped fallback) for any path that
     * doesn't match a known pattern, rather than guessing.
     */
    private function resolveProgramFromPath(string $path): ?Program
    {
        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if (count($segments) < 2 || $segments[0] !== 'assignments') {
            return null;
        }

        if ($segments[1] === 'grammar-writing' && isset($segments[2])) {
            $trackProgramSlugs = [
                'fast-track'   => 'fast-track-grammar-for-writing',
                'introductory' => 'introductory-grammar-for-writing',
                'complexity'   => 'complexity-grammar-for-writing',
                'proficiency'  => 'proficiency-grammar-for-writing',
            ];

            $slug = $trackProgramSlugs[$segments[2]] ?? null;

            return $slug ? Program::where('slug', $slug)->first() : null;
        }

        $program = Program::where('slug', $segments[1])->first();

        if (! $program && isset($segments[2])) {
            $program = Program::where('slug', "{$segments[1]}-{$segments[2]}")->first();
        }

        return $program;
    }

    /**
     * Resolves which ClassPeriod (batch) of $program counts as "currently
     * being taught" for $user, in priority order:
     *   1. The program's own explicit active_class_period_id (staff-set on
     *      the track's own index page - respects a deliberate choice).
     *   2. An active batch $user is themselves the assigned teacher of
     *      (the common case: no one set (1), but the teacher IS running a
     *      specific batch right now).
     *   3. Any other active batch of the program (e.g. an admin with no
     *      teacher_id of their own, viewing a program someone else teaches).
     * Returns null (triggering the unscoped fallback) if the program has
     * no active batch at all yet.
     */
    private function resolveActiveClassPeriod(Program $program, $user): ?ClassPeriod
    {
        if ($program->active_class_period_id) {
            $active = $program->classPeriods()->find($program->active_class_period_id);

            if ($active) {
                return $active;
            }
        }

        $myActive = ClassPeriod::where('program_id', $program->id)
            ->where('status', 'active')
            ->where('teacher_id', $user->id)
            ->first();

        if ($myActive) {
            return $myActive;
        }

        return ClassPeriod::where('program_id', $program->id)
            ->where('status', 'active')
            ->first();
    }

    /**
     * All students in $classPeriodId, merging the two coexisting
     * enrollment mechanisms (legacy direct users.class_period_id, and the
     * newer Enrollment pivot) and deduping by id - same pattern already
     * used by EloquentAttendanceRepository::getStudentsInClass().
     */
    private function studentsInClassPeriod(int $classPeriodId)
    {
        $legacy = User::where('class_period_id', $classPeriodId)
            ->where('role', 'student')
            ->get(['id', 'name', 'email']);

        $enrolled = User::whereHas('enrollments', fn ($q) => $q->where('class_period_id', $classPeriodId))
            ->where('role', 'student')
            ->get(['id', 'name', 'email']);

        return $legacy->concat($enrolled)->unique('id')->sortBy('name')->values();
    }
}
