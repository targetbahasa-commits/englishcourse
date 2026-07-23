<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListeningBankModule extends Model
{
    protected $fillable = [
        'listening_bank_id',
        'module_type',
        'module_id',
    ];

    public function bank()
    {
        return $this->belongsTo(ListeningBank::class, 'listening_bank_id');
    }
}
