<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeningBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'level',
        'topic',
        'accent',
        'voice',
        'background_sound',
        'audio',
        'duration',
        'transcript',
        'humanized_transcript',
        'status',
        'error_message',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    /**
     * Questions generated for this bank.
     */
    public function questions()
    {
        return $this->hasMany(ListeningQuestion::class)->orderBy('order');
    }

    /**
     * Module attachments (pivot).
     */
    public function modules()
    {
        return $this->hasMany(ListeningBankModule::class);
    }

    /**
     * Readable duration string: "3:42"
     */
    public function getDurationFormattedAttribute(): string
    {
        if (!$this->duration) return '--:--';
        $m = floor($this->duration / 60);
        $s = $this->duration % 60;
        return sprintf('%d:%02d', $m, $s);
    }

    /**
     * Full URL for the audio file.
     */
    public function getAudioUrlAttribute(): ?string
    {
        return $this->audio ? asset('storage/' . $this->audio) : null;
    }

    public function isReady(): bool
    {
        return $this->status === 'ready';
    }
}
