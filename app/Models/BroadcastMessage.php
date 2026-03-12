<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastMessage extends Model
{
    protected $fillable = [
        'title',
        'content',
        'target_role',
        'send_via_email',
        'send_via_whatsapp',
        'send_via_inbox',
        'status',
        'recipients_count'
    ];

    protected $casts = [
        'send_via_email' => 'boolean',
        'send_via_whatsapp' => 'boolean',
        'send_via_inbox' => 'boolean',
    ];
}
