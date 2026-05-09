<?php

namespace App\Domain\Payment;

readonly class DiscountResult
{
    public function __construct(
        public int $amount,
        public ?string $label,
        public ?array $meta,
    ) {}

    public static function none(): self
    {
        return new self(0, null, null);
    }
}
