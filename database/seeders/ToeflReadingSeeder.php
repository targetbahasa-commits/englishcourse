<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflReadingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = [
            [
                'meeting_number' => 1,
                'title' => 'Main Idea, Main Topic, and Main Purpose Questions'
            ],
            [
                'meeting_number' => 2,
                'title' => 'Factual Questions, Negative Questions, and Scanning Questions'
            ],
            [
                'meeting_number' => 3,
                'title' => 'Inference Questions and Purpose Questions'
            ],
            [
                'meeting_number' => 4,
                'title' => 'Vocabulary-in-Context Questions'
            ],
            [
                'meeting_number' => 5,
                'title' => 'Reference Questions'
            ],
        ];

        foreach ($lessons as $lesson) {
            \App\Models\ToeflReadingMeeting::updateOrCreate(
                ['meeting_number' => $lesson['meeting_number']],
                ['title' => $lesson['title'], 'is_locked' => false]
            );
        }
    }
}
