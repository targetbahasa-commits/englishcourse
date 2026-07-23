<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ShopProduct extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'description', 'cover_image',
        'price', 'price_discounted', 'stock', 'is_active',
        'program_id', 'file_url', 'platform_links',
        'weight_gram', 'sold_count', 'metadata',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'platform_links' => 'array',
        'metadata'       => 'array',
        'price'          => 'integer',
        'price_discounted' => 'integer',
        'sold_count'     => 'integer',
    ];

    // ── Relationships ────────────────────────────────────────
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function items()
    {
        return $this->hasMany(ShopOrderItem::class);
    }

    // ── Accessors ────────────────────────────────────────────
    public function getEffectivePriceAttribute(): int
    {
        return $this->price_discounted ?? $this->price;
    }

    public function getHasdDiscountAttribute(): bool
    {
        return ! is_null($this->price_discounted) && $this->price_discounted < $this->price;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountedPriceAttribute(): string
    {
        if (is_null($this->price_discounted)) return '';
        return 'Rp ' . number_format($this->price_discounted, 0, ',', '.');
    }

    public function getIsUnlimitedStockAttribute(): bool
    {
        return is_null($this->stock);
    }

    public function getIsDigitalAttribute(): bool
    {
        return in_array($this->type, ['book_digital', 'video_class', 'mock_test', 'mock_test_pte', 'class_voucher']);
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->getTypeMeta()['label'] ?? $this->type;
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_image) return null;
        return asset('storage/' . $this->cover_image);
    }

    // ── Static helpers ───────────────────────────────────────
    public static function types(): array
    {
        return [
            'book_physical' => ['label' => 'Buku Fisik',          'icon' => '📦', 'color' => 'amber'],
            'book_digital'  => ['label' => 'Buku Digital (PDF)',  'icon' => '📄', 'color' => 'blue'],
            'class_voucher' => ['label' => 'Voucher Kelas',       'icon' => '🎟️', 'color' => 'violet'],
            'video_class'   => ['label' => 'Video Kelas Online',  'icon' => '🎬', 'color' => 'rose'],
            'mock_test'     => ['label' => 'Mock Test TOEFL/IELTS','icon' => '📝', 'color' => 'emerald'],
            'mock_test_pte' => ['label' => 'Mock Test PTE',       'icon' => '📝', 'color' => 'teal'],
        ];
    }

    public function getTypeMeta(): array
    {
        return static::types()[$this->type] ?? ['label' => $this->type, 'icon' => '🛒', 'color' => 'gray'];
    }

    // ── Auto-slug ────────────────────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (ShopProduct $product) {
            if (empty($product->slug)) {
                $base = Str::slug($product->name);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $product->slug = $slug;
            }
        });
    }
}
