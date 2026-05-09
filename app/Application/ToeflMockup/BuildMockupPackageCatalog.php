<?php

namespace App\Application\ToeflMockup;

use App\Application\ToeflMockup\ViewData\MockupPackageCardViewData;

class BuildMockupPackageCatalog
{
    public function handle(): array
    {
        return [
            new MockupPackageCardViewData(
                package_number: 1,
                title: 'Paket 1',
                subtitle: 'Longman TOEFL ITP Series',
                description: 'Complete full mock test covering Listening (50 soal), Structure & Written Expression (40 soal), dan Reading Comprehension (50 soal). Total 140 soal.',
                status: 'available',
            ),
            new MockupPackageCardViewData(
                package_number: 2,
                title: 'Paket 2',
                subtitle: 'TOEFL ITP Practice Set 2',
                description: 'Full simulation test dengan set soal yang berbeda untuk meningkatkan kemampuan Anda.',
                status: 'available',
            ),
            new MockupPackageCardViewData(
                package_number: 3,
                title: 'Paket 3',
                subtitle: 'TOEFL ITP Practice Set 3',
                description: 'Paket latihan tambahan untuk persiapan optimal menghadapi ujian TOEFL ITP.',
                status: 'coming_soon',
            ),
        ];
    }
}