<?php

namespace App\Domain\ToeflMockup;

readonly class ToeflScore
{
    public function __construct(
        public int $listening,
        public int $structure,
        public int $reading,
    ) {}

    public function total(): int
    {
        return (int) round(($this->listening + $this->structure + $this->reading) * 10 / 3);
    }

    public function toArray(): array
    {
        return [
            'listening' => $this->listening,
            'structure' => $this->structure,
            'reading' => $this->reading,
        ];
    }
}
