<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarTopic;
use App\Models\GrammarTopicQuestion;

class Topic2Seeder extends Seeder
{
    public function run()
    {
        $topic = GrammarTopic::find(2);
        if (!$topic) return;

        // Clear existing just in case
        $topic->questions()->delete();

        $sentences = [
            ["Saya membeli <strong>sebuah</strong> apel.", "I bought an apple.", ['apel' => ['pos' => 'n', 'id' => 'apple'], 'membeli' => ['pos' => 'v', 'id' => 'bought']], ['id' => 'Dia makan sebuah pisang.', 'en' => 'He eats a banana.']],
            ["Ini adalah <strong>sebuah</strong> buku yang bagus.", "This is a good book.", ['buku' => ['pos' => 'n', 'id' => 'book'], 'bagus' => ['pos' => 'adj', 'id' => 'good']], null],
            ["<strong>Buku itu</strong> ada di atas meja.", "The book is on the table.", ['meja' => ['pos' => 'n', 'id' => 'table'], 'atas' => ['pos' => 'prep', 'id' => 'on']], null],
            ["Mereka melihat <strong>seekor</strong> anjing.", "They saw a dog.", ['anjing' => ['pos' => 'n', 'id' => 'dog'], 'melihat' => ['pos' => 'v', 'id' => 'saw']], null],
            ["<strong>Anjing itu</strong> sedang menggonggong.", "The dog is barking.", ['menggonggong' => ['pos' => 'v', 'id' => 'barking']], null],
            ["Kami mengunjungi <strong>sebuah</strong> universitas.", "We visited a university.", ['universitas' => ['pos' => 'n', 'id' => 'university'], 'mengunjungi' => ['pos' => 'v', 'id' => 'visited']], null],
            ["<strong>Matahari</strong> bersinar terang hari ini.", "The sun shines brightly today.", ['matahari' => ['pos' => 'n', 'id' => 'sun'], 'terang' => ['pos' => 'adv', 'id' => 'brightly']], null],
            ["Dia memakai <strong>sebuah</strong> payung.", "She uses an umbrella.", ['payung' => ['pos' => 'n', 'id' => 'umbrella'], 'memakai' => ['pos' => 'v', 'id' => 'uses']], null],
            ["Saya butuh <strong>satu jam</strong> untuk sampai ke sana.", "I need an hour to get there.", ['jam' => ['pos' => 'n', 'id' => 'hour'], 'butuh' => ['pos' => 'v', 'id' => 'need']], null],
            ["Ini adalah <strong>sebuah</strong> kehormatan.", "This is an honor.", ['kehormatan' => ['pos' => 'n', 'id' => 'honor']], null],
            ["Mereka tinggal di <strong>sebuah</strong> rumah tua.", "They live in an old house.", ['tua' => ['pos' => 'adj', 'id' => 'old'], 'rumah' => ['pos' => 'n', 'id' => 'house']], null],
            ["<strong>Rumah itu</strong> sangat besar.", "The house is very big.", ['besar' => ['pos' => 'adj', 'id' => 'big']], null],
            ["Bumi mengelilingi <strong>matahari</strong>.", "The earth goes around the sun.", ['bumi' => ['pos' => 'n', 'id' => 'earth'], 'mengelilingi' => ['pos' => 'v', 'id' => 'goes around']], null],
            ["Dia adalah <strong>orang yang jujur</strong>.", "He is an honest person.", ['jujur' => ['pos' => 'adj', 'id' => 'honest'], 'orang' => ['pos' => 'n', 'id' => 'person']], null],
            ["Saya ingin menjadi <strong>seorang</strong> insinyur.", "I want to be an engineer.", ['insinyur' => ['pos' => 'n', 'id' => 'engineer'], 'ingin' => ['pos' => 'v', 'id' => 'want']], null],
            ["Kami menikmati <strong>pesta tersebut</strong>.", "We enjoyed the party.", ['pesta' => ['pos' => 'n', 'id' => 'party'], 'menikmati' => ['pos' => 'v', 'id' => 'enjoyed']], null],
            ["Bolehkah saya meminta <strong>segumpal</strong> es?", "Can I have an ice cube?", ['es' => ['pos' => 'n', 'id' => 'ice'], 'segumpal' => ['pos' => 'n', 'id' => 'cube']], null],
            ["Itu adalah <strong>ide yang luar biasa</strong>.", "That is an amazing idea.", ['ide' => ['pos' => 'n', 'id' => 'idea'], 'luar biasa' => ['pos' => 'adj', 'id' => 'amazing']], null],
            ["Saya suka bermain <strong>gitar</strong>.", "I like to play the guitar.", ['gitar' => ['pos' => 'n', 'id' => 'guitar'], 'bermain' => ['pos' => 'v', 'id' => 'play']], null],
            ["Mari kita pergi ke <strong>pantai</strong>.", "Let's go to the beach.", ['pantai' => ['pos' => 'n', 'id' => 'beach'], 'pergi' => ['pos' => 'v', 'id' => 'go']], null]
        ];

        foreach ($sentences as $idx => $s) {
            GrammarTopicQuestion::create([
                'grammar_topic_id' => $topic->id,
                'type' => 'sentence',
                'question_id' => $s[0],
                'answer_en' => $s[1],
                'vocab_helper' => $s[2],
                'example' => $s[3],
                'order' => $idx + 1
            ]);
        }

        GrammarTopicQuestion::create([
            'grammar_topic_id' => $topic->id,
            'type' => 'paragraph',
            'question_id' => 'Pagi ini saya makan <strong>sebuah</strong> apel dan <strong>sepotong</strong> roti. <strong>Apel itu</strong> sangat manis, tetapi <strong>roti itu</strong> sedikit keras. Kemudian saya pergi ke <strong>sebuah</strong> universitas menggunakan <strong>mobil</strong>. <strong>Matahari</strong> bersinar sangat cerah di perjalanan.',
            'answer_en' => 'This morning I ate an apple and a piece of bread. The apple was very sweet, but the bread was a bit hard. Then I went to a university using a car. The sun shone very brightly on the way.',
            'vocab_helper' => [
                'apel' => ['pos' => 'n', 'id' => 'apple'],
                'roti' => ['pos' => 'n', 'id' => 'bread'],
                'manis' => ['pos' => 'adj', 'id' => 'sweet'],
                'keras' => ['pos' => 'adj', 'id' => 'hard'],
                'universitas' => ['pos' => 'n', 'id' => 'university'],
                'cerah' => ['pos' => 'adv', 'id' => 'brightly'],
                'perjalanan' => ['pos' => 'n', 'id' => 'way']
            ],
            'example' => null,
            'order' => 21
        ]);
    }
}
