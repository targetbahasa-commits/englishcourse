<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsWritingTask2Lesson6Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Delete existing Meeting 6 to ensure a fresh start
        DB::table('ielts_writing_meetings')
            ->where('meeting_number', 6)
            ->where('task_type', 2)
            ->delete();

        // 2. Create new Lesson 6 (Practice Mode)
        DB::table('ielts_writing_meetings')->insert([
            'meeting_number' => 6,
            'task_type' => 2,
            'title' => 'Review & Practice: Discuss Both Views',
            'category' => 'lesson',
            'view_type' => 'practice', // Falls back to default meeting.blade.php which is correct for full practice
            'prompt' => '<div class="space-y-4">
    <p class="font-medium">You should spend about 40 minutes on this task.</p>
    
    <p>Write about the following topic:</p>
    
    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-gray-700 italic font-serif">
        "Some people believe that the best way to solve environmental problems is to increase the price of fuel. Others disagree and think that there are better solutions being employed to solve these problems."
        <br><br>
        <strong>Discuss both views and give your own opinion.</strong>
    </div>

    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
    
    <p class="text-sm text-gray-500">Write at least 250 words.</p>
</div>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
