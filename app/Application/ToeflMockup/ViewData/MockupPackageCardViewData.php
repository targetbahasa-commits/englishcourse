<?php

namespace App\Application\ToeflMockup\ViewData;

class MockupPackageCardViewData
{
    public function __construct(
        public readonly int $package_number,
        public readonly string $title,
        public readonly string $subtitle,
        public readonly string $description,
        public readonly string $status,
    ) {
    }

    public function toArray(): array
    {
        return [
            'package_number' => $this->package_number,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}