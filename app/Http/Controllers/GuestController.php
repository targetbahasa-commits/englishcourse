<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        // Re-using the free lessons array structure
        $freeLessons = [
            [
                'id' => 'a1',
                'title' => 'Vocabulary A1',
                'description' => 'Essential vocabulary for absolute beginners. 20 topics covering everyday situations.',
                'color' => 'blue',
                'route' => route('vocabulary-a1')
            ],
            [
                'id' => 'a2',
                'title' => 'Vocabulary A2',
                'description' => 'Elementary vocabulary to expand your daily communication skills.',
                'color' => 'green',
                'route' => route('vocabulary-a2')
            ],
            [
                'id' => 'b1',
                'title' => 'Vocabulary B1',
                'description' => 'Intermediate vocabulary for more complex conversations.',
                'color' => 'purple',
                'route' => route('vocabulary-b1')
            ],
            [
                'id' => 'b2',
                'title' => 'Vocabulary B2',
                'description' => 'Upper-intermediate vocabulary for professional fluency.',
                'color' => 'orange',
                'route' => route('vocabulary-b2')
            ],
            [
                'id' => 'c1',
                'title' => 'Vocabulary C1',
                'description' => 'Advanced vocabulary for near-native proficiency.',
                'color' => 'red',
                'route' => route('vocabulary-c1')
            ],
            [
                'id' => 'verbs',
                'title' => 'Verbs (A1-C1)',
                'description' => 'Master English verbs across 5 proficiency levels.',
                'color' => 'teal',
                'route' => route('vocabulary-verb')
            ],
            [
                'id' => 'adjectives',
                'title' => 'Adjectives (A1-C1)',
                'description' => 'Descriptive words to enhance your expression.',
                'color' => 'yellow',
                'route' => route('vocabulary-adjective')
            ],
            [
                'id' => 'adverbs',
                'title' => 'Adverbs (A1-C1)',
                'description' => 'Add nuance to your verbs and adjectives.',
                'color' => 'indigo',
                'route' => route('vocabulary-adverb')
            ],
            [
                'id' => 'expressions',
                'title' => 'English Expressions',
                'description' => 'Common expressions for natural conversation.',
                'color' => 'cyan',
                'route' => route('english-expression')
            ],
             [
                'id' => 'idioms',
                'title' => 'English Idioms',
                'description' => 'Learn idioms to sound like a native speaker.',
                'color' => 'pink',
                'route' => route('idioms')
            ],
             [
                'id' => 'phrasal-verbs',
                'title' => 'Phrasal Verbs',
                'description' => 'Essential phrasal verbs for fluency.',
                'color' => 'orange',
                'route' => route('phrasal-verbs')
            ],
             [
                'id' => 'irregular-verbs',
                'title' => 'Irregular Verbs',
                'description' => 'Complete list of irregular verbs.',
                'color' => 'purple',
                'route' => route('irregular-verbs')
            ]
        ];

        return view('guest.index', compact('freeLessons'));
    }
}
