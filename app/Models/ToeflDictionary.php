<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflDictionary extends Model
{
    protected $fillable = [
        'word',
        'translation',
        'synonyms',
    ];
}
