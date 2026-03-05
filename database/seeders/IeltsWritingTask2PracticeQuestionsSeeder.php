<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsWritingTask2PracticeQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $practices = [
            [
                'number' => 101,
                'title' => 'Practice 1: Online vs Traditional Learning',
                'prompt' => 'Some people believe that online learning is more effective than traditional classroom teaching, while others think face-to-face learning is better.<br><br>Discuss both views and give your opinion.'
            ],
            [
                'number' => 102,
                'title' => 'Practice 2: Public Transport vs Roads',
                'prompt' => 'Some people think governments should spend more money on public transportation, while others believe that road infrastructure for cars is more important.<br><br>Discuss both views and give your opinion.'
            ],
            [
                'number' => 103,
                'title' => 'Practice 3: Art vs Science Subjects',
                'prompt' => 'Some believe that art subjects are as important as science in education, while others argue that students should focus only on science and technology.<br><br>Discuss both views and give your opinion.'
            ],
            [
                'number' => 104,
                'title' => 'Practice 4: Advertising Pros & Cons',
                'prompt' => 'Some people say that advertising encourages us to buy unnecessary products, while others believe it provides useful information about new goods.<br><br>Discuss both views and give your opinion.'
            ],
            [
                'number' => 105,
                'title' => 'Practice 5: Countryside vs City Life',
                'prompt' => 'Some people think it is better to live in the countryside, while others believe that city life offers more advantages.<br><br>Discuss both views and give your opinion.'
            ],
        ];

        // 1. Create Parent "Folder" Item (Advantages VS Disadvantages)
        DB::table('ielts_writing_meetings')->updateOrInsert(
            [
                'meeting_number' => 100,
                'task_type' => 2,
            ],
            [
                'title' => 'Discuss Both Views',
                'category' => 'practice',       // Shows in main list
                'view_type' => 'practice_selection', // Custom view to show list
                'prompt' => 'Select a topic to practice.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Create Child Practice Items (Hidden from main list)
        foreach ($practices as $p) {
            DB::table('ielts_writing_meetings')->updateOrInsert(
                [
                    'meeting_number' => $p['number'],
                    'task_type' => 2,
                ],
                [
                    'title' => $p['title'],
                    'category' => 'practice_item', // HIDDEN from main task_list
                    'view_type' => 'layout_builder',     // Standard writing interface
                    'prompt' => '<div class="space-y-4">
    <p class="font-medium">You should spend about 40 minutes on this task.</p>
    
    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-gray-700 italic font-serif">
        "' . $p['prompt'] . '"
    </div>

    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
    
    <p class="text-sm text-gray-500">Write at least 250 words.</p>
</div>',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
