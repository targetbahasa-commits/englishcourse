<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeTestSubmission extends Model
{
    use HasFactory;

    protected $table = 'free_test_submissions';
    protected $guarded = [];
}
