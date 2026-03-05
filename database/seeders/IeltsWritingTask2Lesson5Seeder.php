<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsWritingTask2Lesson5Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ielts_writing_meetings')->updateOrInsert(
            [
                'meeting_number' => 5,
                'task_type' => 2,
            ],
            [
                'title' => 'Conclusion',
                'category' => 'lesson',
                'view_type' => 'layout_builder', 
                'prompt' => '<p>Write a conclusion for your essay...</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
