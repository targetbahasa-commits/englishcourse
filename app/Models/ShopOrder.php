<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopOrder extends Model
{
    protected $fillable = [
        'order_date', 'customer_name', 'customer_whatsapp',
        'platform', 'platform_order_id', 'total_amount',
        'status', 'notes', 'user_id',
    ];

    protected $casts = [
        'order_date'   => 'datetime',
        'total_amount' => 'integer',
    ];

    // ── Relationships ────────────────────────────────────────
    public function items(): HasMany
    {
        return $this->hasMany(ShopOrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessors & Helpers ──────────────────────────────────
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public static function statuses(): array
    {
        return [
            'pending'   => ['label' => 'Pending',   'color' => 'amber'],
            'paid'      => ['label' => 'Dibayar',   'color' => 'blue'],
            'shipped'   => ['label' => 'Dikirim',   'color' => 'indigo'],
            'completed' => ['label' => 'Selesai',   'color' => 'emerald'],
            'cancelled' => ['label' => 'Dibatalkan','color' => 'red'],
        ];
    }

    public function getStatusMeta(): array
    {
        return static::statuses()[$this->status] ?? ['label' => $this->status, 'color' => 'gray'];
    }

    public static function platforms(): array
    {
        return [
            'shopee'    => 'Shopee',
            'tiktok'    => 'TikTok Shop',
            'tokopedia' => 'Tokopedia',
            'whatsapp'  => 'WhatsApp',
            'instagram' => 'Instagram',
            'other'     => 'Lainnya',
        ];
    }

    public function getPlatformLabelAttribute(): string
    {
        return static::platforms()[$this->platform] ?? $this->platform;
    }
}
