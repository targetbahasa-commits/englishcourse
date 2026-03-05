<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Meeting38Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ielts_writing_meetings')->updateOrInsert(
            ['id' => 38],
            [
                'meeting_number' => 5,
                'task_type' => 1,
                'title' => 'Lesson 5: Describing Numbers & Data',
                'prompt' => 'Translate the sentences below using the correct structures for numbers, fractions, and percentages.',
                'view_type' => 'numbers_percentages',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
