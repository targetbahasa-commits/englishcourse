<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class DeleteToeflListeningMeeting2ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Delete all questions for meeting 2
        ToeflListeningQuestion::where('meeting_number', 2)->delete();
    }
}
