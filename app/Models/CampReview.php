<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'camp_id',
        'student_id',
        'tingkat_kebersihan',
        'kualitas_fasilitas',
        'kritik_saran',
        'tanggal_review',
    ];

    protected $casts = [
        'tanggal_review' => 'date',
    ];

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
