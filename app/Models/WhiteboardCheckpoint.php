<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A named, permanent snapshot of a whiteboard ("coret-coret") room created
 * automatically every time the "Simpan" button is clicked (see
 * LiveDrawingController::checkpoint() / the blade component's
 * createCheckpoint()) - separate from WhiteboardArchive ("Arsipkan", a
 * deliberate/manual save-as-new-snapshot action) and from WhiteboardSave
 * (the single continuously-autosaved "current" state).
 *
 * Unlike WhiteboardArchive, a checkpoint has NO individual delete route -
 * the only way to remove one is a bulk delete via the whiteboard's "Clear
 * All" menu (see destroyCheckpoints()), by design.
 */
class WhiteboardCheckpoint extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'canvas_data',
        'canvas_data_student',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
