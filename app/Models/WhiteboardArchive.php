<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A named, permanent snapshot of a whiteboard ("coret-coret") room that the
 * user explicitly chose to keep, separate from WhiteboardSave (the single
 * continuously-autosaved "current" state). A room can have many archives -
 * they are never overwritten by autosave and only removed when the user
 * deletes them.
 */
class WhiteboardArchive extends Model
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
