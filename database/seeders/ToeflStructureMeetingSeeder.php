<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToeflStructureMeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            1 => 'Subject + Verb + Preposition',
            2 => 'Verb Palsu',
            3 => 'Appositives',
            4 => 'FANBOYS',
            5 => 'Adverbial Clause',
            6 => 'Noun Clause',
            7 => 'Adjective Clause',
            8 => 'Peringkasan',
            9 => 'Inversi',
            10 => 'Fanboys & Pair Conjunction',
            11 => 'Comparative & Superlative',
            12 => 'Expressions of Quantity',
            13 => 'Possessive Adjectives & Pronouns',
            14 => 'Make and Do',
            15 => 'Other, Another, and Others',
            16 => 'Adjectives and Adverbs',
        ];

        foreach ($topics as $number => $title) {
            \App\Models\ToeflStructureMeeting::updateOrCreate(
                ['meeting_number' => $number],
                ['title' => $title]
            );
        }
    }
}
