<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IeltsSpeakingTopic;

class UpdateLesson3SubtopicsSeeder extends Seeder
{
    public function run()
    {
        $subtopics = [
            [
                'slug' => 'successful-small-business',
                'title' => 'A Successful Small Business',
                'questions' => [
                    "Describe a successful small business that you know.\nYou should say:\n\n• What the business is and how you know about it.\n• What services or products it provides.\n• Why you think it is successful.\n• And explain how you feel about this business."
                ]
            ],
            [
                'slug' => 'practical-skill',
                'title' => 'A Practical Skill You Learned',
                'questions' => [
                    "Describe a useful practical skill you have learned (e.g., coding, cooking, repairing things).\nYou should say:\n\n• What the skill is.\n• How and when you learned it.\n• Why you decided to learn it.\n• And explain how this skill has helped you in your life."
                ]
            ],
            [
                'slug' => 'interesting-place',
                'title' => 'An Interesting Place in Your Country',
                'questions' => [
                    "Describe an interesting part of your country that you would recommend to tourists.\nYou should say:\n\n• Where it is located.\n• What people can see and do there.\n• What makes it different from other places.\n• And explain why you would recommend it to others."
                ]
            ],
        ];

        $topic = IeltsSpeakingTopic::where('slug', 'lesson-3')->first();

        if ($topic) {
            $topic->subtopics = $subtopics;
            $topic->save();
        }
    }
}
