<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Durable autosave of a student's whiteboard ("coret-coret") room, keyed by
 * the room's owner (targetUserId in LiveDrawingController). This is the
 * persistent counterpart to the Cache-based live_drawing_{userId} keys used
 * for real-time sync - the cache is ephemeral (1 hour TTL) and only meant
 * for live collaboration; this table is what survives cache expiry, server
 * restarts, and browser refreshes so a student's notes are never lost.
 *
 * Three independently-clearable layers: `canvas_data` is the staff/teacher
 * layer (also the original/legacy column, from before the split),
 * `canvas_data_student` is the student layer, and `canvas_data_notebook` is
 * a student's own private "Notebook" tab content - isolated from the other
 * two, never shown to staff (see LiveDrawingController class docblock).
 */
class WhiteboardSave extends Model
{
    protected $fillable = [
        'user_id',
        'canvas_data',
        'canvas_data_student',
        'canvas_data_notebook',
        'saved_at',
    ];

    protected $casts = [
        'saved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
