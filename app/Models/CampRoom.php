<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'camp_id',
        'nama_kamar',
        'kapasitas_per_kamar',
        'harga_per_orang',
        'status',
    ];

    protected $appends = ['jumlah_penghuni'];

    public function getJumlahPenghuniAttribute()
    {
        if (array_key_exists('users_count', $this->attributes)) {
            return $this->attributes['users_count'];
        }

        if ($this->relationLoaded('users')) {
            return $this->users->count();
        }

        return $this->users()->count();
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'camp_room_id');
    }
}
