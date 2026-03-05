<?php

namespace Database\Seeders;

use App\Models\IeltsWritingMeeting;
use Illuminate\Database\Seeder;

class Meeting37Seeder extends Seeder
{
    public function run()
    {
        IeltsWritingMeeting::updateOrCreate(
            ['id' => 37],
            [
                'title' => 'Lesson 4: Using the Right Prepositions',
                'meeting_number' => 4,
                'task_type' => 1,
                'prompt' => 'Complete the sentences choosing the right preposition from the list below.',
                'view_type' => 'using_prepositions',
            ]
        );
    }
}
