<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningMeeting;

class ToeflListeningMeetingSeeder extends Seeder
{
    public function run(): void
    {
        // Create 20 meetings
        for ($i = 1; $i <= 20; $i++) {
            ToeflListeningMeeting::create([
                'meeting_number' => $i,
                'title' => "Meeting {$i}",
                'is_locked' => false, // All unlocked by default
            ]);
        }
    }
}
