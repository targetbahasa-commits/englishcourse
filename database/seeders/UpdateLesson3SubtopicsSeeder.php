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
                    "Describe a successful small business that you know. You should say:  • What the business is and how you know about it. • What services or products it provides. • Why you think it is successful. • And explain how you feel about this business."
                ]
            ],
            [
                'slug' => 'practical-skill',
                'title' => 'A Practical Skill You Learned',
                'questions' => [
                    "Describe a useful practical skill you have learned (e.g., coding, cooking, repairing things). You should say:  • What the skill is. • How and when you learned it. • Why you decided to learn it. • And explain how this skill has helped you in your life."
                ]
            ],
            [
                'slug' => 'interesting-place',
                'title' => 'An Interesting Place in Your Country',
                'questions' => [
                    "Describe an interesting part of your country that you would recommend to tourists. You should say:  • Where it is located. • What people can see and do there. • What makes it different from other places. • And explain why you would recommend it to others."
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
