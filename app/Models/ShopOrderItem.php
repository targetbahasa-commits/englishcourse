<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopOrderItem extends Model
{
    protected $fillable = [
        'shop_order_id', 'shop_product_id', 'quantity', 'price_at_order',
    ];

    protected $casts = [
        'quantity'       => 'integer',
        'price_at_order' => 'integer',
    ];

    // ── Relationships ────────────────────────────────────────
    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'shop_order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ShopProduct::class, 'shop_product_id');
    }

    // ── Accessors ────────────────────────────────────────────
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_at_order, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->price_at_order * $this->quantity, 0, ',', '.');
    }
}
