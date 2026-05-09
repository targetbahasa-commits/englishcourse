<?php

namespace App\Application\ToeflReadingPractice;

use App\Application\ToeflReadingPractice\Support\ToeflReadingPracticeData;

class BuildReadingPracticeCatalog
{
    public function handle(): array
    {
        return [
            'readingPackages' => collect(ToeflReadingPracticeData::catalog()),
        ];
    }
}