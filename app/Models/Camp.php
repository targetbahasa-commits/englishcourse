<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_camp',
        'alamat',
        'gender_khusus',
        'teacher_id',
        'jumlah_toilet',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function rooms()
    {
        return $this->hasMany(CampRoom::class);
    }

    public function reviews()
    {
        return $this->hasMany(CampReview::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'camp_id');
    }
}
