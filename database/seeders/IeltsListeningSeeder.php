<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Meeting;

class IeltsListeningSeeder extends Seeder
{
    public function run()
    {
        $program = Program::firstOrCreate(
            ['slug' => 'ielts-academic-listening'],
            [
                'name' => 'IELTS Academic Listening',
                'period' => 'All Time',
                'is_active' => true,
                'price' => 0
            ]
        );

        $parts = [
            1 => 'Conversation (Social Context)',
            2 => 'Monologue (Social Context)',
            3 => 'Conversation (Educational)',
            4 => 'Monologue (Academic Subject)',
        ];

        foreach ($parts as $number => $title) {
            Meeting::firstOrCreate(
                [
                    'program_id' => $program->id,
                    'meeting_number' => $number
                ],
                [
                    'title' => $title,
                    'is_locked' => $number > 1
                ]
            );
        }
    }
}
