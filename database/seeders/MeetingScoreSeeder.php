<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MeetingScore;
use App\Models\User;

class MeetingScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the student user (Budi)
        $student = User::where('email', 'student@targetbahasa.com')->first();
        
        if (!$student) {
            $this->command->error('Student user not found!');
            return;
        }

        // Create dummy scores for meetings 1-10
        $dummyScores = [
            1 => 85.5,
            2 => 92.0,
            3 => 78.5,
            4 => 88.0,
            5 => 95.5,
            6 => 72.0,
            7 => 90.5,
            8 => 65.0,
            9 => 87.5,
            10 => 93.0,
        ];

        foreach ($dummyScores as $meetingNumber => $score) {
            MeetingScore::updateOrCreate(
                [
                    'user_id' => $student->id,
                    'meeting_number' => $meetingNumber
                ],
                [
                    'score' => $score,
                    'submitted_at' => now()->subDays(rand(1, 30))
                ]
            );
        }

        $this->command->info('Dummy meeting scores created successfully for ' . $student->name);
    }
}
