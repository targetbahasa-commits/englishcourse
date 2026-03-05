<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflListeningQuestion;

class DeleteToeflListeningMeetings3to16Seeder extends Seeder
{
    public function run(): void
    {
        // Delete all questions for meetings 3 through 16
        ToeflListeningQuestion::whereBetween('meeting_number', [3, 16])->delete();
        
        echo "Deleted questions from meetings 3-16\n";
    }
}
